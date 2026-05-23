<?php
/**
 * Infraestrutura — RF04.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_INFRAESTRUTURA_SLUG', 'infraestrutura' );

/**
 * @return array<string, mixed>
 */
function portal_si_infraestrutura_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	$path = get_template_directory() . '/data/infraestrutura.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = $loaded;
			return apply_filters( 'portal_si_infraestrutura_config', $config );
		}
	}

	$config = array();
	return apply_filters( 'portal_si_infraestrutura_config', $config );
}

/**
 * @return string
 */
function portal_si_infraestrutura_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_INFRAESTRUTURA_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_infraestrutura_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * @return array<int, array{value: string, label: string}>
 */
function portal_si_infraestrutura_highlights() {
	$config = portal_si_infraestrutura_config();
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
 * @return array<int, array<string, mixed>>
 */
function portal_si_infraestrutura_sections() {
	$config   = portal_si_infraestrutura_config();
	$sections = isset( $config['sections'] ) && is_array( $config['sections'] ) ? $config['sections'] : array();
	$out      = array();

	foreach ( $sections as $section ) {
		if ( ! is_array( $section ) || empty( $section['title'] ) ) {
			continue;
		}
		$items = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();
		$clean = array();
		foreach ( $items as $item ) {
			if ( is_array( $item ) && ! empty( $item['title'] ) ) {
				$clean[] = $item;
			}
		}
		if ( empty( $clean ) ) {
			continue;
		}
		$section['items'] = $clean;
		$out[]            = $section;
	}

	return $out;
}

/**
 * Garante página e pai institucional.
 */
function portal_si_ensure_infraestrutura_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_INFRAESTRUTURA_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Infraestrutura', 'portal-si-cefet' ),
			PORTAL_SI_INFRAESTRUTURA_SLUG
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

	$intro = portal_si_infraestrutura_intro();
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
add_action( 'after_setup_theme', 'portal_si_ensure_infraestrutura_page', 26 );

/**
 * HTML do mapa (oEmbed do WP ou iframe configurado).
 *
 * @return array{html: string, link: string}|null
 */
function portal_si_infraestrutura_map() {
	$config = portal_si_infraestrutura_config();
	$campus = isset( $config['campus'] ) && is_array( $config['campus'] ) ? $config['campus'] : array();
	$map    = isset( $campus['map'] ) && is_array( $campus['map'] ) ? $campus['map'] : array();

	$place_url = isset( $map['place_url'] ) ? esc_url_raw( (string) $map['place_url'] ) : '';
	$embed_url = isset( $map['embed_url'] ) ? esc_url_raw( (string) $map['embed_url'] ) : '';

	if ( '' === $place_url && '' === $embed_url ) {
		return null;
	}

	$html = '';
	if ( $place_url && function_exists( 'wp_oembed_get' ) ) {
		$oembed = wp_oembed_get( $place_url, array( 'width' => 640, 'height' => 480 ) );
		if ( $oembed ) {
			$html = $oembed;
		}
	}

	if ( '' === $html && $embed_url ) {
		$title = isset( $map['iframe_title'] ) ? (string) $map['iframe_title'] : __( 'Mapa do campus', 'portal-si-cefet' );
		$html  = sprintf(
			'<iframe src="%1$s" title="%2$s" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>',
			esc_url( $embed_url ),
			esc_attr( $title )
		);
	}

	if ( '' === $html ) {
		return null;
	}

	return array(
		'html' => $html,
		'link' => $place_url ? $place_url : $embed_url,
	);
}

/**
 * CSS da página.
 */
function portal_si_infraestrutura_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_INFRAESTRUTURA_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-infraestrutura',
		get_template_directory_uri() . '/assets/css/infraestrutura.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_infraestrutura_enqueue_assets', 16 );
