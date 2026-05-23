<?php
/**
 * Documentos institucionais — RF06.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configuração da página.
 *
 * @return array<string, mixed>
 */
function portal_si_documentos_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	$path = get_template_directory() . '/data/documentos-institucionais.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = portal_si_documentos_resolve_urls( $loaded );
			return apply_filters( 'portal_si_documentos_config', $config );
		}
	}

	$config = array();
	return apply_filters( 'portal_si_documentos_config', $config );
}

/**
 * Preenche URLs internas (slug → permalink).
 *
 * @param array<string, mixed> $config Config bruta.
 * @return array<string, mixed>
 */
function portal_si_documentos_resolve_urls( array $config ) {
	if ( empty( $config['groups'] ) || ! is_array( $config['groups'] ) ) {
		return $config;
	}

	foreach ( $config['groups'] as $gi => $group ) {
		if ( empty( $group['items'] ) || ! is_array( $group['items'] ) ) {
			continue;
		}
		foreach ( $group['items'] as $ii => $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			if ( ! empty( $item['internal'] ) && ! empty( $item['slug'] ) ) {
				$config['groups'][ $gi ]['items'][ $ii ]['url'] = portal_si_page_url( (string) $item['slug'] );
			}
		}
	}

	return $config;
}

/**
 * Intro — excerpt ou fallback.
 *
 * @return string
 */
function portal_si_documentos_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_DOCUMENTOS_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_documentos_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * Grupos com itens válidos (publicações do wp-admin + blocos fixos do tema).
 *
 * @return array<int, array<string, mixed>>
 */
function portal_si_documentos_groups() {
	$out = array();

	$editorial = function_exists( 'portal_si_documentos_editorial_group' ) ? portal_si_documentos_editorial_group() : null;
	if ( $editorial ) {
		$out[] = $editorial;
	} else {
		$config = portal_si_documentos_config();
		$block  = isset( $config['editorial_group'] ) && is_array( $config['editorial_group'] ) ? $config['editorial_group'] : array();
		$out[]  = array(
			'id'           => 'editorial',
			'title'        => isset( $block['title'] ) ? (string) $block['title'] : __( 'Comunicados e publicações do curso', 'portal-si-cefet' ),
			'intro'        => isset( $block['intro'] ) ? (string) $block['intro'] : '',
			'items'        => array(),
			'empty_notice' => true,
		);
	}

	$config = portal_si_documentos_config();
	$groups = isset( $config['groups'] ) && is_array( $config['groups'] ) ? $config['groups'] : array();

	foreach ( $groups as $group ) {
		if ( ! is_array( $group ) ) {
			continue;
		}
		$items = isset( $group['items'] ) && is_array( $group['items'] ) ? $group['items'] : array();
		$clean = array();
		foreach ( $items as $item ) {
			if ( ! is_array( $item ) || empty( $item['title'] ) ) {
				continue;
			}
			$clean[] = $item;
		}
		if ( empty( $clean ) ) {
			continue;
		}
		$group['items'] = $clean;
		$out[]          = $group;
	}

	return $out;
}

/**
 * Garante página e pai institucional.
 */
function portal_si_ensure_documentos_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_DOCUMENTOS_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Documentos Institucionais', 'portal-si-cefet' ),
			PORTAL_SI_DOCUMENTOS_SLUG
		);
	}

	if ( ! $page_id ) {
		return;
	}

	$hub_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	if ( $hub_id && (int) get_post_field( 'post_parent', $page_id ) !== (int) $hub_id ) {
		wp_update_post(
			array(
				'ID'          => $page_id,
				'post_parent' => $hub_id,
			)
		);
	}

	$intro = portal_si_documentos_intro();
	if ( $intro ) {
		$page = get_post( $page_id );
		if ( $page && '' === trim( $page->post_excerpt ) ) {
			wp_update_post(
				array(
					'ID'           => $page_id,
					'post_excerpt' => $intro,
				)
			);
		}
	}
}
add_action( 'after_setup_theme', 'portal_si_ensure_documentos_page', 26 );

/**
 * CSS da página.
 */
function portal_si_documentos_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_DOCUMENTOS_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-documentos',
		get_template_directory_uri() . '/assets/css/documentos.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_documentos_enqueue_assets', 16 );
