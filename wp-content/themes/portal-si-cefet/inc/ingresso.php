<?php
/**
 * Ingresso — RF05 (página básica SISU / ENEM / matrícula).
 *
 * Conteúdo estruturado em data/ingresso.php; intro opcional no excerpt da página WP.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_INGRESSO_SLUG', 'ingresso' );

/**
 * Configuração da página de ingresso.
 *
 * @return array<string, mixed>
 */
function portal_si_ingresso_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	$path = get_template_directory() . '/data/ingresso.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = $loaded;
			return apply_filters( 'portal_si_ingresso_config', $config );
		}
	}

	$config = array();
	return apply_filters( 'portal_si_ingresso_config', $config );
}

/**
 * Intro — excerpt da página ou fallback.
 *
 * @return string
 */
function portal_si_ingresso_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_INGRESSO_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_ingresso_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * Destaques numéricos.
 *
 * @return array<int, array{value: string, label: string}>
 */
function portal_si_ingresso_highlights() {
	$config = portal_si_ingresso_config();
	$rows   = isset( $config['highlights'] ) && is_array( $config['highlights'] ) ? $config['highlights'] : array();
	$out    = array();

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$value = isset( $row['value'] ) ? trim( (string) $row['value'] ) : '';
		$label = isset( $row['label'] ) ? trim( (string) $row['label'] ) : '';
		if ( '' === $value && '' === $label ) {
			continue;
		}
		$out[] = array(
			'value' => $value,
			'label' => $label,
		);
	}

	return $out;
}

/**
 * Garante página, pai institucional e excerpt.
 */
function portal_si_ensure_ingresso_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_INGRESSO_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Ingresso', 'portal-si-cefet' ),
			PORTAL_SI_INGRESSO_SLUG
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

	$intro = portal_si_ingresso_intro();
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
add_action( 'after_setup_theme', 'portal_si_ensure_ingresso_page', 26 );

/**
 * CSS da página Ingresso.
 */
function portal_si_ingresso_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_INGRESSO_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-ingresso',
		get_template_directory_uri() . '/assets/css/ingresso.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_ingresso_enqueue_assets', 16 );
