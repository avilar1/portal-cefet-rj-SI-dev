<?php
/**
 * Fábrica de Software — RF13, portfólio RF14 (mesma página).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_FABRICA_SLUG', 'fabrica-de-software' );

/**
 * @return array<string, mixed>
 */
function portal_si_fabrica_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	$path = get_template_directory() . '/data/fabrica-software.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = $loaded;
			return apply_filters( 'portal_si_fabrica_config', $config );
		}
	}

	$config = array();
	return apply_filters( 'portal_si_fabrica_config', $config );
}

/**
 * @return string
 */
function portal_si_fabrica_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_FABRICA_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_fabrica_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * @return array<int, array{value: string, label: string}>
 */
function portal_si_fabrica_highlights() {
	$config = portal_si_fabrica_config();
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
 * @return array<string, mixed>
 */
function portal_si_fabrica_mission() {
	$config = portal_si_fabrica_config();
	$block  = isset( $config['mission'] ) && is_array( $config['mission'] ) ? $config['mission'] : array();
	if ( empty( $block['text'] ) ) {
		return array();
	}
	return $block;
}

/**
 * @return array<string, mixed>
 */
function portal_si_fabrica_methodology() {
	$config = portal_si_fabrica_config();
	$block  = isset( $config['methodology'] ) && is_array( $config['methodology'] ) ? $config['methodology'] : array();
	$steps  = isset( $block['steps'] ) && is_array( $block['steps'] ) ? $block['steps'] : array();
	$clean  = array();

	foreach ( $steps as $step ) {
		if ( is_array( $step ) && ! empty( $step['title'] ) ) {
			$clean[] = $step;
		}
	}

	if ( empty( $clean ) ) {
		return array();
	}

	$block['steps'] = $clean;
	return $block;
}

/**
 * @return array<string, mixed>
 */
function portal_si_fabrica_project_types() {
	$config = portal_si_fabrica_config();
	$block  = isset( $config['project_types'] ) && is_array( $config['project_types'] ) ? $config['project_types'] : array();
	$items  = isset( $block['items'] ) && is_array( $block['items'] ) ? $block['items'] : array();
	$clean  = array();

	foreach ( $items as $item ) {
		if ( is_array( $item ) && ! empty( $item['title'] ) ) {
			$clean[] = $item;
		}
	}

	if ( empty( $clean ) ) {
		return array();
	}

	$block['items'] = $clean;
	return $block;
}

/**
 * @return array<string, mixed>
 */
function portal_si_fabrica_team() {
	$config = portal_si_fabrica_config();
	$block  = isset( $config['team'] ) && is_array( $config['team'] ) ? $config['team'] : array();
	$roles  = isset( $block['roles'] ) && is_array( $block['roles'] ) ? $block['roles'] : array();
	$clean  = array();

	foreach ( $roles as $role ) {
		if ( is_array( $role ) && ! empty( $role['title'] ) ) {
			$clean[] = $role;
		}
	}

	if ( empty( $clean ) ) {
		return array();
	}

	$block['roles'] = $clean;
	return $block;
}

/**
 * Portfólio RF14 — só exemplos em data/ (fallback).
 *
 * @return array<int, array<string, string>>
 */
function portal_si_fabrica_portfolio_items_from_data() {
	$config = portal_si_fabrica_config();
	$block  = isset( $config['portfolio'] ) && is_array( $config['portfolio'] ) ? $config['portfolio'] : array();
	$items  = isset( $block['items'] ) && is_array( $block['items'] ) ? $block['items'] : array();
	$out    = array();

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) || empty( $item['name'] ) ) {
			continue;
		}
		$out[] = array(
			'name'             => (string) $item['name'],
			'description'      => isset( $item['description'] ) ? (string) $item['description'] : '',
			'technologies'     => isset( $item['technologies'] ) ? (string) $item['technologies'] : '',
			'students'         => isset( $item['students'] ) ? (string) $item['students'] : '',
			'result'           => isset( $item['result'] ) ? (string) $item['result'] : '',
			'year'             => isset( $item['year'] ) ? (string) $item['year'] : '',
			'presentation_url' => '',
			'photo_url'        => '',
		);
	}

	return $out;
}

/**
 * Portfólio RF14 — CPT no painel; fallback data/ se vazio.
 *
 * @return array<int, array<string, string>>
 */
function portal_si_fabrica_portfolio_items() {
	if ( function_exists( 'portal_si_get_fabrica_projetos' ) ) {
		$from_cpt = portal_si_get_fabrica_projetos();
		if ( ! empty( $from_cpt ) ) {
			return $from_cpt;
		}
	}

	return portal_si_fabrica_portfolio_items_from_data();
}

/**
 * @return array<string, mixed>
 */
function portal_si_fabrica_portfolio() {
	$config = portal_si_fabrica_config();
	$block  = isset( $config['portfolio'] ) && is_array( $config['portfolio'] ) ? $config['portfolio'] : array();
	$items  = portal_si_fabrica_portfolio_items();

	if ( empty( $items ) ) {
		return array();
	}

	$block['items'] = $items;
	if ( function_exists( 'portal_si_fabrica_portfolio_intro_text' ) ) {
		$intro = portal_si_fabrica_portfolio_intro_text();
		if ( '' !== $intro ) {
			$block['intro'] = $intro;
		}
	}
	return $block;
}

/**
 * @return array<string, mixed>
 */
function portal_si_fabrica_partnership() {
	$config = portal_si_fabrica_config();
	$block  = isset( $config['partnership'] ) && is_array( $config['partnership'] ) ? $config['partnership'] : array();
	$points = isset( $block['points'] ) && is_array( $block['points'] ) ? $block['points'] : array();
	$clean  = array();

	foreach ( $points as $point ) {
		$point = trim( (string) $point );
		if ( '' !== $point ) {
			$clean[] = $point;
		}
	}

	if ( empty( $clean ) ) {
		return array();
	}

	$block['points'] = $clean;
	return $block;
}

/**
 * @return array<string, mixed>
 */
function portal_si_fabrica_partner_cta() {
	$config = portal_si_fabrica_config();
	return isset( $config['partner_cta'] ) && is_array( $config['partner_cta'] ) ? $config['partner_cta'] : array();
}

/**
 * URL de contato para parceria (página Contato + âncora).
 *
 * @return string
 */
function portal_si_fabrica_partner_contact_url() {
	$cta  = portal_si_fabrica_partner_cta();
	$slug = isset( $cta['contact_slug'] ) ? (string) $cta['contact_slug'] : 'contato';
	$url  = portal_si_page_url( $slug );
	$anchor = isset( $cta['anchor'] ) ? trim( (string) $cta['anchor'] ) : 'parceria-fabrica';

	if ( $anchor && $url ) {
		$url .= '#' . sanitize_title( $anchor );
	}

	return $url ? $url : portal_si_page_url( 'contato' );
}

/**
 * E-mail CTA — preferência meta da página.
 *
 * @return string
 */
function portal_si_fabrica_partner_cta_email() {
	if ( function_exists( 'portal_si_fabrica_partner_email' ) ) {
		return portal_si_fabrica_partner_email();
	}
	$cta = portal_si_fabrica_partner_cta();
	return isset( $cta['email'] ) ? trim( (string) $cta['email'] ) : '';
}

/**
 * Garante página pública.
 */
function portal_si_ensure_fabrica_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_FABRICA_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Fábrica de Software', 'portal-si-cefet' ),
			PORTAL_SI_FABRICA_SLUG
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
				'post_excerpt' => portal_si_fabrica_intro(),
			)
		);
	}
}
add_action( 'after_setup_theme', 'portal_si_ensure_fabrica_page', 26 );

/**
 * Enfileira CSS.
 */
function portal_si_fabrica_enqueue_assets() {
	if ( is_page( PORTAL_SI_FABRICA_SLUG ) ) {
		wp_enqueue_style(
			'portal-si-fabrica',
			get_template_directory_uri() . '/assets/css/fabrica-software.css',
			array( 'portal-si-pages' ),
			PORTAL_SI_CEFET_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'portal_si_fabrica_enqueue_assets', 16 );

/**
 * Converte **negrito** simples em <strong>.
 *
 * @param string $text Texto.
 * @return string HTML escapado com strong.
 */
function portal_si_fabrica_format_inline( $text ) {
	$text = esc_html( (string) $text );
	return preg_replace( '/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text );
}
