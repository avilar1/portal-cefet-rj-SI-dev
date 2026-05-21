<?php
/**
 * Breadcrumbs mínimos (páginas internas — Seção 8.1 / RNF03).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Link de um nível da trilha.
 */
function portal_si_breadcrumb_link( $url, $label ) {
	return '<a class="breadcrumbs__link" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
}

/**
 * Imprime a navegação em trilha (omitida na página inicial).
 */
function portal_si_the_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$sep = '<span class="breadcrumbs__sep" aria-hidden="true"> › </span>';
	$parts = array();

	$parts[] = portal_si_breadcrumb_link( home_url( '/' ), __( 'Início', 'portal-si-cefet' ) );

	if ( is_page() && ! is_front_page() ) {
		global $post;
		$ancestors = get_post_ancestors( $post );
		if ( $ancestors ) {
			$ancestors = array_reverse( $ancestors );
			foreach ( $ancestors as $ancestor_id ) {
				$parts[] = portal_si_breadcrumb_link( get_permalink( $ancestor_id ), get_the_title( $ancestor_id ) );
			}
		} elseif ( function_exists( 'portal_si_is_institucional_child_page' ) && portal_si_is_institucional_child_page( $post ) ) {
			$hub_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
			if ( $hub_id ) {
				$parts[] = portal_si_breadcrumb_link( get_permalink( $hub_id ), get_the_title( $hub_id ) );
			}
		}
		$parts[] = '<span class="breadcrumbs__current" aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_singular( PORTAL_SI_EVENTO_POST_TYPE ) || ( is_singular() && PORTAL_SI_EVENTO_POST_TYPE === get_post_type() ) ) {
		$parts[] = portal_si_breadcrumb_link(
			portal_si_page_url( 'agenda-e-eventos' ),
			__( 'Agenda e Eventos', 'portal-si-cefet' )
		);
		$parts[] = '<span class="breadcrumbs__current" aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_single() && 'post' === get_post_type() ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		if ( $posts_page ) {
			$parts[] = portal_si_breadcrumb_link( get_permalink( $posts_page ), get_the_title( $posts_page ) );
		}
		$parts[] = '<span class="breadcrumbs__current" aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_home() && ! is_front_page() ) {
		$pid   = (int) get_option( 'page_for_posts' );
		$label = $pid ? get_the_title( $pid ) : __( 'Notícias', 'portal-si-cefet' );
		$parts[] = '<span class="breadcrumbs__current" aria-current="page">' . esc_html( $label ) . '</span>';
	} elseif ( is_category() || is_tag() || is_author() || is_date() ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		if ( $posts_page ) {
			$parts[] = portal_si_breadcrumb_link( get_permalink( $posts_page ), get_the_title( $posts_page ) );
		}
		$parts[] = '<span class="breadcrumbs__current" aria-current="page">' . esc_html( wp_strip_all_tags( get_the_archive_title() ) ) . '</span>';
	} elseif ( is_search() ) {
		$parts[] = '<span class="breadcrumbs__current" aria-current="page">' . esc_html__( 'Busca', 'portal-si-cefet' ) . '</span>';
	} else {
		$title = get_the_archive_title();
		if ( $title ) {
			$parts[] = '<span class="breadcrumbs__current" aria-current="page">' . esc_html( wp_strip_all_tags( $title ) ) . '</span>';
		}
	}

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Navegação em trilha', 'portal-si-cefet' ) . '">';
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trechos já escapados ou HTML controlado acima.
	echo implode( $sep, $parts );
	echo '</nav>';
}
