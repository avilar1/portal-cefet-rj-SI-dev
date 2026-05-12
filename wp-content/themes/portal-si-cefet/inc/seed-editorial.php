<?php
/**
 * Seed editorial (uma vez): categorias de exemplo + post em rascunho para testar fluxo (RF17–RF19).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_EDITORIAL_SEEDED_OPTION = 'portal_si_editorial_seeded_v1';

/**
 * Devolve o ID da categoria pelo slug ou 0.
 */
function portal_si_editorial_get_cat_id( $slug ) {
	$t = get_term_by( 'slug', $slug, 'category' );
	return ( $t && ! is_wp_error( $t ) ) ? (int) $t->term_id : 0;
}

/**
 * Cria categoria se não existir.
 */
function portal_si_editorial_ensure_category( $name, $slug ) {
	$id = portal_si_editorial_get_cat_id( $slug );
	if ( $id ) {
		return $id;
	}
	$res = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
	if ( is_wp_error( $res ) ) {
		return 0;
	}
	return (int) $res['term_id'];
}

/**
 * Executa seed editorial (uma vez).
 */
function portal_si_run_editorial_seed() {
	if ( get_option( PORTAL_SI_EDITORIAL_SEEDED_OPTION ) ) {
		return;
	}

	$cat_inst = portal_si_editorial_ensure_category( 'Institucional', 'institucional' );
	portal_si_editorial_ensure_category( 'Eventos', 'eventos' );

	$slug  = 'post-de-exemplo-rascunho';
	$query = new WP_Query(
		array(
			'name'           => $slug,
			'post_type'      => 'post',
			'post_status'    => 'any',
			'posts_per_page' => 1,
		)
	);
	if ( $query->have_posts() ) {
		update_option( PORTAL_SI_EDITORIAL_SEEDED_OPTION, 1 );
		return;
	}

	$default_cat = (int) get_option( 'default_category' );
	$cat_for     = $cat_inst > 0 ? $cat_inst : $default_cat;

	$body = implode(
		"\n\n",
		array(
			'Este é um post em rascunho para a equipa testar o fluxo editorial no WordPress.',
			'O que fazer: entre com um utilizador com perfil Editor, edite este texto, adicione imagem em destaque se quiser, e publique (ou siga o processo interno de revisão com o administrador).',
			'Depois pode apagar este post ou convertê-lo na primeira notícia real do portal.',
			'Documentação da equipa: ficheiro WORDPRESS-REDAÇÃO-E-PAPÉIS.txt na raiz do repositório.',
		)
	);

	$new_id = wp_insert_post(
		array(
			'post_title'    => __( 'Post de exemplo (rascunho)', 'portal-si-cefet' ),
			'post_name'     => $slug,
			'post_status'   => 'draft',
			'post_type'     => 'post',
			'post_category' => array( $cat_for ),
			'post_content'  => $body,
		),
		true
	);

	if ( is_wp_error( $new_id ) ) {
		return;
	}

	update_option( PORTAL_SI_EDITORIAL_SEEDED_OPTION, 1 );
}

/**
 * Dispara o seed apenas para administradores no painel (uma execução).
 */
function portal_si_maybe_seed_editorial() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( get_option( PORTAL_SI_EDITORIAL_SEEDED_OPTION ) ) {
		return;
	}
	portal_si_run_editorial_seed();
}
add_action( 'admin_init', 'portal_si_maybe_seed_editorial', 6 );
