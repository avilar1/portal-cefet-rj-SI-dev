<?php
/**
 * Contato — RF27, RF29.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_CONTATO_SLUG', 'contato' );

/**
 * @return array<string, mixed>
 */
function portal_si_contato_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	$path = get_template_directory() . '/data/contato.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = $loaded;
			return apply_filters( 'portal_si_contato_config', $config );
		}
	}

	$config = array();
	return apply_filters( 'portal_si_contato_config', $config );
}

/**
 * @return string
 */
function portal_si_contato_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CONTATO_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_contato_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * Coordenação — meta da página ou data/.
 *
 * @return array<string, mixed>
 */
function portal_si_contato_coordination() {
	$config = portal_si_contato_config();
	$block  = isset( $config['coordination'] ) && is_array( $config['coordination'] ) ? $config['coordination'] : array();

	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CONTATO_SLUG );
	if ( $page_id && function_exists( 'portal_si_contato_get_page_meta' ) ) {
		$meta = portal_si_contato_get_page_meta( $page_id );
		if ( ! empty( $meta['coordination'] ) && is_array( $meta['coordination'] ) ) {
			$block = array_merge( $block, $meta['coordination'] );
		}
		if ( ! empty( $meta['people'] ) && is_array( $meta['people'] ) ) {
			$block['people'] = $meta['people'];
		}
	}

	$people = isset( $block['people'] ) && is_array( $block['people'] ) ? $block['people'] : array();
	$clean  = array();
	foreach ( $people as $person ) {
		if ( ! is_array( $person ) ) {
			continue;
		}
		$name  = isset( $person['name'] ) ? trim( (string) $person['name'] ) : '';
		$role  = isset( $person['role'] ) ? trim( (string) $person['role'] ) : '';
		$phone = isset( $person['phone'] ) ? trim( (string) $person['phone'] ) : '';
		$email = isset( $person['email'] ) ? trim( (string) $person['email'] ) : '';
		if ( '' === $name && '' === $role && '' === $phone && '' === $email ) {
			continue;
		}
		$clean[] = $person;
	}
	$block['people'] = $clean;

	return $block;
}

/**
 * Contato resumido para rodapé (RF29).
 *
 * @return array<string, string>
 */
function portal_si_contato_footer_summary() {
	$coord = portal_si_contato_coordination();
	$people = isset( $coord['people'] ) && is_array( $coord['people'] ) ? $coord['people'] : array();
	$primary = ! empty( $people[0] ) && is_array( $people[0] ) ? $people[0] : array();

	$phone = isset( $primary['phone'] ) ? trim( (string) $primary['phone'] ) : '';
	$email = isset( $primary['email'] ) ? trim( (string) $primary['email'] ) : '';
	$name  = isset( $primary['name'] ) ? trim( (string) $primary['name'] ) : '';

	if ( '' === $phone && '' === $email ) {
		return array();
	}

	return array(
		'name'  => $name,
		'phone' => $phone,
		'email' => $email,
		'url'   => portal_si_page_url( PORTAL_SI_CONTATO_SLUG ),
	);
}

/**
 * @return array<int, array<string, mixed>>
 */
function portal_si_contato_channels() {
	$config = portal_si_contato_config();
	$block  = isset( $config['channels'] ) && is_array( $config['channels'] ) ? $config['channels'] : array();
	$items  = isset( $block['items'] ) && is_array( $block['items'] ) ? $block['items'] : array();
	$out    = array();

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) || empty( $item['label'] ) || empty( $item['url'] ) ) {
			continue;
		}
		$out[] = $item;
	}

	$block['items'] = $out;
	return $block;
}

/**
 * @return array<string, mixed>
 */
function portal_si_contato_ouvidoria() {
	$config = portal_si_contato_config();
	return isset( $config['ouvidoria'] ) && is_array( $config['ouvidoria'] ) ? $config['ouvidoria'] : array();
}

/**
 * @return array<string, mixed>
 */
function portal_si_contato_fabrica_block() {
	$config = portal_si_contato_config();
	return isset( $config['fabrica_partnership'] ) && is_array( $config['fabrica_partnership'] ) ? $config['fabrica_partnership'] : array();
}

/**
 * Mapa — reutiliza campus MG (RF27).
 *
 * @return array{html: string, link: string}|null
 */
function portal_si_contato_map() {
	if ( function_exists( 'portal_si_infraestrutura_map' ) ) {
		return portal_si_infraestrutura_map();
	}
	return null;
}

/**
 * Garante página Contato.
 */
function portal_si_ensure_contato_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CONTATO_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Contato', 'portal-si-cefet' ),
			PORTAL_SI_CONTATO_SLUG
		);
	}

	if ( ! $page_id ) {
		return;
	}

	$page = get_post( $page_id );
	if ( $page && '' === trim( $page->post_excerpt ) ) {
		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_excerpt' => portal_si_contato_intro(),
			)
		);
	}
}
add_action( 'after_setup_theme', 'portal_si_ensure_contato_page', 26 );

/**
 * CSS da página.
 */
function portal_si_contato_enqueue_assets() {
	if ( is_page( PORTAL_SI_CONTATO_SLUG ) ) {
		wp_enqueue_style(
			'portal-si-contato',
			get_template_directory_uri() . '/assets/css/contato.css',
			array( 'portal-si-pages' ),
			PORTAL_SI_CEFET_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'portal_si_contato_enqueue_assets', 16 );

/**
 * @param string $phone Telefone.
 * @return string
 */
function portal_si_contato_phone_href( $phone ) {
	$digits = preg_replace( '/\D+/', '', (string) $phone );
	if ( '' === $digits ) {
		return '';
	}
	if ( strlen( $digits ) <= 11 && '55' !== substr( $digits, 0, 2 ) ) {
		$digits = '55' . $digits;
	}
	return 'tel:+' . $digits;
}
