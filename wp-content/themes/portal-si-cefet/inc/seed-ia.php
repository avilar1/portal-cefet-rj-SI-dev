<?php
/**
 * Cria páginas vazias conforme arquitetura de informação (Seção 8 do documento de requisitos)
 * e menus na primeira visita de um administrador ao painel (execução única).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slug da opção que impede reexecução do seed.
 */
const PORTAL_SI_IA_SEEDED_OPTION = 'portal_si_ia_seeded_v1';

/**
 * Páginas nível 1 — ordem do menu principal.
 *
 * @return array<int, array{title: string, slug: string}>
 */
function portal_si_ia_level1_pages() {
	return array(
		array( 'title' => 'Início', 'slug' => 'inicio' ),
		array( 'title' => 'Ingresso', 'slug' => 'ingresso' ),
		array( 'title' => 'Institucional', 'slug' => 'institucional' ),
		array( 'title' => 'Sobre o Curso', 'slug' => 'sobre-o-curso' ),
		array( 'title' => 'Grade Curricular', 'slug' => 'grade-curricular' ),
		array( 'title' => 'Corpo Docente', 'slug' => 'corpo-docente' ),
		array( 'title' => 'Pesquisa e Extensão', 'slug' => 'pesquisa-e-extensao' ),
		array( 'title' => 'Fábrica de Software', 'slug' => 'fabrica-de-software' ),
		array( 'title' => 'Infraestrutura', 'slug' => 'infraestrutura' ),
		array( 'title' => 'Carreira e Egressos', 'slug' => 'carreira-e-egressos' ),
		array( 'title' => 'Vida Estudantil', 'slug' => 'vida-estudantil' ),
		array( 'title' => 'Documentos Institucionais', 'slug' => 'documentos-institucionais' ),
		array( 'title' => 'Notícias', 'slug' => 'noticias' ),
		array( 'title' => 'Agenda e Eventos', 'slug' => 'agenda-e-eventos' ),
		array( 'title' => 'Contato', 'slug' => 'contato' ),
	);
}

/**
 * Páginas nível 2 — menu rodapé (links legais e mapa).
 *
 * @return array<int, array{title: string, slug: string}>
 */
function portal_si_ia_level2_pages() {
	return array(
		array( 'title' => 'Acessibilidade', 'slug' => 'acessibilidade' ),
		array( 'title' => 'Política de Privacidade', 'slug' => 'politica-de-privacidade' ),
		array( 'title' => 'Termos de Uso', 'slug' => 'termos-de-uso' ),
		array( 'title' => 'Mapa do Site', 'slug' => 'mapa-do-site' ),
	);
}

/**
 * Obtém ID de página publicada pelo slug, ou null.
 */
function portal_si_get_page_id_by_slug( $slug ) {
	$query = new WP_Query(
		array(
			'name'           => $slug,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);
	if ( ! $query->have_posts() ) {
		return null;
	}
	return (int) $query->posts[0]->ID;
}

/**
 * Cria página publicada vazia se o slug ainda não existir.
 */
function portal_si_ensure_page( $title, $slug ) {
	$existing = portal_si_get_page_id_by_slug( $slug );
	if ( $existing ) {
		return $existing;
	}
	$id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_content' => '',
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		return null;
	}
	return (int) $id;
}

/**
 * Cria ou obtém menu de navegação por nome.
 */
function portal_si_ensure_nav_menu( $name ) {
	$term = get_term_by( 'name', $name, 'nav_menu' );
	if ( $term && ! is_wp_error( $term ) ) {
		return (int) $term->term_id;
	}
	$menu_id = wp_create_nav_menu( $name );
	if ( is_wp_error( $menu_id ) ) {
		return 0;
	}
	return (int) $menu_id;
}

/**
 * Limpa itens de um menu e adiciona páginas na ordem informada.
 *
 * @param int   $menu_id ID do menu.
 * @param int[] $page_ids IDs das páginas.
 */
function portal_si_fill_menu_with_pages( $menu_id, array $page_ids ) {
	$items = wp_get_nav_menu_items( $menu_id );
	if ( is_array( $items ) ) {
		foreach ( $items as $item ) {
			wp_delete_post( (int) $item->ID, true );
		}
	}
	$order = 0;
	foreach ( $page_ids as $page_id ) {
		if ( $page_id <= 0 ) {
			continue;
		}
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page_id,
				'menu-item-status'    => 'publish',
				'menu-item-position'  => ++$order,
			)
		);
	}
}

/**
 * Executa seed de IA (uma vez).
 */
function portal_si_run_ia_seed() {
	if ( get_option( PORTAL_SI_IA_SEEDED_OPTION ) ) {
		return;
	}

	$ids_level1 = array();
	foreach ( portal_si_ia_level1_pages() as $row ) {
		$pid = portal_si_ensure_page( $row['title'], $row['slug'] );
		if ( $pid ) {
			$ids_level1[ $row['slug'] ] = $pid;
		}
	}

	$ids_level2 = array();
	foreach ( portal_si_ia_level2_pages() as $row ) {
		$pid = portal_si_ensure_page( $row['title'], $row['slug'] );
		if ( $pid ) {
			$ids_level2[ $row['slug'] ] = $pid;
		}
	}

	$menu_principal_id = portal_si_ensure_nav_menu( 'Menu principal' );
	$menu_rodape_id    = portal_si_ensure_nav_menu( 'Menu rodapé' );

	if ( $menu_principal_id > 0 ) {
		$principal_order = function_exists( 'portal_si_primary_menu_slugs' )
			? portal_si_primary_menu_slugs()
			: array(
				'inicio',
				'institucional',
				'corpo-docente',
				'pesquisa-e-extensao',
				'fabrica-de-software',
				'noticias',
				'agenda-e-eventos',
				'contato',
			);
		$principal_ids = array();
		foreach ( $principal_order as $slug ) {
			if ( ! empty( $ids_level1[ $slug ] ) ) {
				$principal_ids[] = $ids_level1[ $slug ];
			}
		}
		portal_si_fill_menu_with_pages( $menu_principal_id, $principal_ids );
	}

	if ( $menu_rodape_id > 0 ) {
		$rodape_order = array( 'acessibilidade', 'politica-de-privacidade', 'termos-de-uso', 'mapa-do-site' );
		$rodape_ids   = array();
		foreach ( $rodape_order as $slug ) {
			if ( ! empty( $ids_level2[ $slug ] ) ) {
				$rodape_ids[] = $ids_level2[ $slug ];
			}
		}
		portal_si_fill_menu_with_pages( $menu_rodape_id, $rodape_ids );
	}

	$locations = array(
		'primary' => $menu_principal_id,
		'footer'  => $menu_rodape_id,
	);
	set_theme_mod( 'nav_menu_locations', array_filter( $locations ) );

	$id_inicio   = isset( $ids_level1['inicio'] ) ? $ids_level1['inicio'] : 0;
	$id_noticias = isset( $ids_level1['noticias'] ) ? $ids_level1['noticias'] : 0;

	if ( $id_inicio && $id_noticias && ! (int) get_option( 'page_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $id_inicio );
		update_option( 'page_for_posts', $id_noticias );
	}

	update_option( PORTAL_SI_IA_SEEDED_OPTION, 1 );
}

/**
 * Dispara o seed apenas para administradores no painel (uma execução).
 */
function portal_si_maybe_seed_on_admin() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( get_option( PORTAL_SI_IA_SEEDED_OPTION ) ) {
		return;
	}
	portal_si_run_ia_seed();
}
add_action( 'admin_init', 'portal_si_maybe_seed_on_admin', 5 );
