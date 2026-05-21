<?php
/**
 * Módulo institucional — hub (layout_hub_institucional_mvp.md).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Slug da página hub. */
define( 'PORTAL_SI_INSTITUCIONAL_HUB_SLUG', 'institucional' );

/** Slug da listagem de documentos (RF06 — página placeholder até layout dedicado). */
define( 'PORTAL_SI_DOCUMENTOS_SLUG', 'documentos-institucionais' );

/**
 * Carrega configuração estática do hub.
 *
 * @return array<string, mixed>
 */
function portal_si_institucional_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	$path = get_template_directory() . '/data/institucional.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = $loaded;
			return apply_filters( 'portal_si_institucional_config', $config );
		}
	}

	$config = array(
		'zones'         => array( 'a', 'b' ),
		'intro_default' => '',
		'zona_b'        => array( 'heading' => '', 'cards' => array() ),
		'zona_c'        => array(),
		'zona_d'        => array( 'stats' => array() ),
	);

	return apply_filters( 'portal_si_institucional_config', $config );
}

/**
 * Zona ativa no layout.
 *
 * @param string $zone ID da zona (a–e).
 */
function portal_si_institucional_has_zone( $zone ) {
	$config = portal_si_institucional_config();
	$zones  = isset( $config['zones'] ) && is_array( $config['zones'] ) ? $config['zones'] : array( 'a', 'b' );
	return in_array( $zone, $zones, true );
}

/**
 * Intro da Zona A — excerpt da página ou fallback do arquivo de dados.
 *
 * @return string
 */
function portal_si_institucional_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_institucional_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * Cards da Zona B com URLs resolvidas (somente páginas publicadas).
 *
 * @return array<int, array{icon: string, title: string, description: string, slug: string, url: string}>
 */
function portal_si_institucional_nav_cards() {
	$config = portal_si_institucional_config();
	$zona_b = isset( $config['zona_b'] ) && is_array( $config['zona_b'] ) ? $config['zona_b'] : array();
	$cards  = isset( $zona_b['cards'] ) && is_array( $zona_b['cards'] ) ? $zona_b['cards'] : array();
	$out    = array();

	foreach ( $cards as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$slug = isset( $row['slug'] ) ? sanitize_title( $row['slug'] ) : '';
		$title = isset( $row['title'] ) ? trim( (string) $row['title'] ) : '';
		if ( '' === $slug || '' === $title ) {
			continue;
		}
		if ( ! portal_si_get_page_id_by_slug( $slug ) ) {
			continue;
		}
		$out[] = array(
			'icon'        => isset( $row['icon'] ) ? sanitize_key( $row['icon'] ) : '',
			'title'       => $title,
			'description' => isset( $row['description'] ) ? trim( (string) $row['description'] ) : '',
			'slug'        => $slug,
			'url'         => portal_si_page_url( $slug ),
		);
	}

	return $out;
}

/**
 * Título H2 da Zona B.
 *
 * @return string
 */
function portal_si_institucional_zona_b_heading() {
	$config = portal_si_institucional_config();
	$zona_b = isset( $config['zona_b'] ) && is_array( $config['zona_b'] ) ? $config['zona_b'] : array();
	return isset( $zona_b['heading'] ) ? trim( (string) $zona_b['heading'] ) : '';
}

/**
 * Dados da Zona C normalizados.
 *
 * @return array<string, string>
 */
function portal_si_institucional_zona_c() {
	$config = portal_si_institucional_config();
	$zona_c = isset( $config['zona_c'] ) && is_array( $config['zona_c'] ) ? $config['zona_c'] : array();
	$slug   = isset( $zona_c['cta_slug'] ) ? sanitize_title( $zona_c['cta_slug'] ) : 'ingresso';

	return array(
		'title'     => isset( $zona_c['title'] ) ? (string) $zona_c['title'] : '',
		'text'      => isset( $zona_c['text'] ) ? (string) $zona_c['text'] : '',
		'cta_label' => isset( $zona_c['cta_label'] ) ? (string) $zona_c['cta_label'] : __( 'Como ingressar', 'portal-si-cefet' ),
		'cta_url'   => portal_si_page_url( $slug ),
		'icon'      => isset( $zona_c['icon'] ) ? sanitize_key( $zona_c['icon'] ) : 'graduation',
	);
}

/**
 * URL do hub institucional.
 *
 * @return string
 */
function portal_si_institucional_hub_url() {
	return portal_si_page_url( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
}

/**
 * Slugs das páginas filhas do hub (fonte: data/institucional.php → zona_b.cards).
 *
 * @return string[]
 */
function portal_si_institucional_hub_child_slugs() {
	$config = portal_si_institucional_config();
	$zona_b = isset( $config['zona_b'] ) && is_array( $config['zona_b'] ) ? $config['zona_b'] : array();
	$cards  = isset( $zona_b['cards'] ) && is_array( $zona_b['cards'] ) ? $zona_b['cards'] : array();
	$slugs  = array();

	foreach ( $cards as $row ) {
		if ( ! is_array( $row ) || empty( $row['slug'] ) ) {
			continue;
		}
		$slug = sanitize_title( $row['slug'] );
		if ( PORTAL_SI_INSTITUCIONAL_HUB_SLUG !== $slug ) {
			$slugs[] = $slug;
		}
	}

	return array_values( array_unique( $slugs ) );
}

/**
 * Página pertence ao módulo institucional (filha do hub), exceto o próprio hub.
 *
 * @param int|WP_Post|null $post Post ou ID.
 */
function portal_si_is_institucional_child_page( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}
	if ( PORTAL_SI_INSTITUCIONAL_HUB_SLUG === $post->post_name ) {
		return false;
	}

	if ( in_array( $post->post_name, portal_si_institucional_hub_child_slugs(), true ) ) {
		return true;
	}

	$hub_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	return $hub_id && (int) $post->post_parent === $hub_id;
}

/**
 * Links da coluna Institucional no rodapé (hub + cards do hub).
 *
 * @return array<int, array{label: string, slug: string}>
 */
function portal_si_footer_institucional_links() {
	$links = array(
		array(
			'label' => __( 'Visão geral', 'portal-si-cefet' ),
			'slug'  => PORTAL_SI_INSTITUCIONAL_HUB_SLUG,
		),
	);

	foreach ( portal_si_institucional_nav_cards() as $card ) {
		$links[] = array(
			'label' => $card['title'],
			'slug'  => $card['slug'],
		);
	}

	return $links;
}

/**
 * Define páginas do hub como filhas de /institucional/ no WordPress (breadcrumb nativo).
 */
function portal_si_sync_institucional_page_parents() {
	$hub_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	if ( ! $hub_id ) {
		return;
	}

	foreach ( portal_si_institucional_hub_child_slugs() as $slug ) {
		$child_id = portal_si_get_page_id_by_slug( $slug );
		if ( ! $child_id || (int) $child_id === (int) $hub_id ) {
			continue;
		}
		$child = get_post( $child_id );
		if ( $child && (int) $child->post_parent !== (int) $hub_id ) {
			wp_update_post(
				array(
					'ID'          => $child_id,
					'post_parent' => $hub_id,
				)
			);
		}
	}
}

/**
 * Garante página do hub e excerpt padrão da intro.
 */
function portal_si_ensure_institucional_hub_page() {
	$config = portal_si_institucional_config();
	$intro  = isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';

	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page( __( 'Institucional', 'portal-si-cefet' ), PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	}

	if ( ! portal_si_get_page_id_by_slug( PORTAL_SI_DOCUMENTOS_SLUG ) ) {
		portal_si_ensure_page(
			__( 'Documentos Institucionais', 'portal-si-cefet' ),
			PORTAL_SI_DOCUMENTOS_SLUG
		);
	}

	if ( $page_id && $intro ) {
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

	portal_si_sync_institucional_page_parents();
}
add_action( 'after_setup_theme', 'portal_si_ensure_institucional_hub_page', 25 );

/**
 * CSS do hub apenas em /institucional/.
 */
function portal_si_institucional_enqueue_styles() {
	if ( ! is_page( PORTAL_SI_INSTITUCIONAL_HUB_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-institucional',
		get_template_directory_uri() . '/assets/css/institucional.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_institucional_enqueue_styles', 15 );
