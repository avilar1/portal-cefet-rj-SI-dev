<?php
/**
 * Navegação — organização por módulos (Requisitos §5 e §8).
 *
 * Header compacto = entradas de módulo. Rodapé = links por módulo.
 * Páginas filhas do hub Institucional não entram no menu principal.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Opção: sincronização única do menu WP após reorganização por módulos. */
const PORTAL_SI_NAV_MODULES_SYNC_OPTION = 'portal_si_nav_modules_sync_v1';

/**
 * Slugs do menu principal (mobile / WP nav) — raízes por módulo.
 *
 * @return string[]
 */
function portal_si_primary_menu_slugs() {
	return array(
		'inicio',
		'institucional',
		'corpo-docente',
		'pesquisa-e-extensao',
		'fabrica-de-software',
		'noticias',
		'agenda-e-eventos',
		'contato',
	);
}

/**
 * Itens do menu compacto no header desktop (um link por módulo).
 *
 * @return array<int, array{slug: string, label: string}>
 */
function portal_si_header_compact_items() {
	return array(
		array(
			'slug'  => 'institucional',
			'label' => __( 'Institucional', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'corpo-docente',
			'label' => __( 'Docentes', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'pesquisa-e-extensao',
			'label' => __( 'Pesquisa e Extensão', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'fabrica-de-software',
			'label' => __( 'Fábrica de Software', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'noticias',
			'label' => __( 'Comunicação', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'contato',
			'label' => __( 'Contato', 'portal-si-cefet' ),
		),
	);
}

/**
 * Colunas do mapa do site no rodapé (RN10) — três módulos + comunicação/contato.
 *
 * @return array<int, array{title: string, links: array<int, array{label: string, slug: string}>}>
 */
function portal_si_footer_sitemap_columns() {
	$institucional_links = array();
	if ( function_exists( 'portal_si_footer_institucional_links' ) ) {
		foreach ( portal_si_footer_institucional_links() as $link ) {
			if ( isset( $link['slug'] ) && 'corpo-docente' === $link['slug'] ) {
				continue;
			}
			$institucional_links[] = $link;
		}
	} else {
		$institucional_links[] = array(
			'label' => __( 'Visão geral', 'portal-si-cefet' ),
			'slug'  => 'institucional',
		);
	}

	return array(
		array(
			'title' => __( 'Institucional', 'portal-si-cefet' ),
			'links' => $institucional_links,
		),
		array(
			'title' => __( 'Docentes e Pesquisa', 'portal-si-cefet' ),
			'links' => array(
				array(
					'label' => __( 'Corpo Docente', 'portal-si-cefet' ),
					'slug'  => 'corpo-docente',
				),
				array(
					'label' => __( 'Pesquisa e Extensão', 'portal-si-cefet' ),
					'slug'  => 'pesquisa-e-extensao',
				),
			),
		),
		array(
			'title' => __( 'Comunicação e Contato', 'portal-si-cefet' ),
			'links' => array(
				array(
					'label' => __( 'Fábrica de Software', 'portal-si-cefet' ),
					'slug'  => 'fabrica-de-software',
				),
				array(
					'label' => __( 'Notícias', 'portal-si-cefet' ),
					'slug'  => 'noticias',
				),
				array(
					'label' => __( 'Agenda e Eventos', 'portal-si-cefet' ),
					'slug'  => 'agenda-e-eventos',
				),
				array(
					'label' => __( 'Contato', 'portal-si-cefet' ),
					'slug'  => 'contato',
				),
			),
		),
	);
}

/**
 * Imprime links do menu compacto (header azul).
 */
function portal_si_render_header_compact_menu() {
	echo '<ul class="nav-primary__list nav-primary__list--compact">';
	$seen = array();
	foreach ( portal_si_header_compact_items() as $item ) {
		$key = $item['slug'] . '|' . $item['label'];
		if ( isset( $seen[ $key ] ) ) {
			continue;
		}
		$seen[ $key ] = true;
		$url   = portal_si_page_url( $item['slug'] );
		$label = $item['label'];
		printf(
			'<li><a href="%1$s">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Itens do menu lateral GovBR (br-menu) — mesma lógica do header + Início.
 */
function portal_si_render_br_menu_items() {
	$items = array_merge(
		array(
			array(
				'slug'  => '',
				'label' => __( 'Início', 'portal-si-cefet' ),
				'url'   => home_url( '/' ),
			),
		),
		array_map(
			function ( $item ) {
				return array(
					'slug'  => $item['slug'],
					'label' => $item['label'],
					'url'   => portal_si_page_url( $item['slug'] ),
				);
			},
			portal_si_header_compact_items()
		)
	);

	echo '<div class="menu-group">';
	foreach ( $items as $item ) {
		printf(
			'<a class="menu-item" href="%1$s"><span class="content">%2$s</span></a>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</div>';
}

/**
 * Reconstrói o menu principal do WordPress conforme módulos (execução única).
 */
function portal_si_sync_primary_nav_menu() {
	if ( ! function_exists( 'portal_si_ensure_nav_menu' ) || ! function_exists( 'portal_si_fill_menu_with_pages' ) ) {
		return;
	}

	$menu_id = portal_si_ensure_nav_menu( 'Menu principal' );
	if ( $menu_id <= 0 ) {
		return;
	}

	$page_ids = array();
	foreach ( portal_si_primary_menu_slugs() as $slug ) {
		$page_id = portal_si_get_page_id_by_slug( $slug );
		if ( $page_id ) {
			$page_ids[] = $page_id;
		}
	}

	if ( ! empty( $page_ids ) ) {
		portal_si_fill_menu_with_pages( $menu_id, $page_ids );
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Sincroniza menu principal após reorganização por módulos.
 */
function portal_si_maybe_sync_navigation_menus() {
	if ( get_option( PORTAL_SI_NAV_MODULES_SYNC_OPTION ) ) {
		return;
	}
	portal_si_sync_primary_nav_menu();
	update_option( PORTAL_SI_NAV_MODULES_SYNC_OPTION, 1 );
}
add_action( 'after_setup_theme', 'portal_si_maybe_sync_navigation_menus', 30 );
