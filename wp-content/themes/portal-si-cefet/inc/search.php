<?php
/**
 * Comportamento da busca global (RF33): incluir páginas nos resultados.
 * CPTs (professores, projetos, documentos) serão acrescentados quando existirem.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inclui páginas na busca principal (além de posts).
 */
function portal_si_search_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}
	$query->set( 'post_type', array( 'post', 'page' ) );
}
add_action( 'pre_get_posts', 'portal_si_search_pre_get_posts' );
