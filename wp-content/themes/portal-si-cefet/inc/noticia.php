<?php
/**
 * Notícias (post type post) — dados e consultas desacopladados dos templates.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Posts por página na listagem de notícias. */
define( 'PORTAL_SI_NOTICIAS_PER_PAGE', 9 );

/**
 * Título da página de notícias (página de posts do WordPress).
 *
 * @return string
 */
function portal_si_noticias_page_title() {
	$page_id = (int) get_option( 'page_for_posts' );
	if ( $page_id ) {
		return get_the_title( $page_id );
	}
	return __( 'Notícias', 'portal-si-cefet' );
}

/**
 * Texto introdutório opcional (excerpt da página de notícias).
 *
 * @return string
 */
function portal_si_noticias_page_intro() {
	$page_id = (int) get_option( 'page_for_posts' );
	if ( ! $page_id ) {
		return '';
	}
	$page = get_post( $page_id );
	if ( $page && $page->post_excerpt ) {
		return $page->post_excerpt;
	}
	return '';
}

/**
 * URL da listagem de notícias.
 *
 * @return string
 */
function portal_si_noticias_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	if ( $page_id ) {
		return get_permalink( $page_id );
	}
	return portal_si_page_url( 'noticias' );
}

/**
 * Normaliza um post em array para template parts.
 *
 * @param int|WP_Post|null $post Post ou ID.
 * @return array<string, mixed>|null
 */
function portal_si_noticia_to_array( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'post' !== $post->post_type ) {
		return null;
	}

	$categories = get_the_category( $post->ID );
	$cat_name   = ! empty( $categories ) ? $categories[0]->name : __( 'Institucional', 'portal-si-cefet' );
	$cat_slug   = ! empty( $categories ) ? $categories[0]->slug : '';

	$excerpt = get_the_excerpt( $post );
	if ( ! $excerpt ) {
		$excerpt = wp_trim_words( wp_strip_all_tags( $post->post_content ), 22, '…' );
	}

	return array(
		'id'         => $post->ID,
		'title'      => get_the_title( $post ),
		'url'        => get_permalink( $post ),
		'date'       => get_the_date( '', $post ),
		'date_iso'   => get_the_date( DATE_W3C, $post ),
		'category'   => $cat_name,
		'cat_slug'   => $cat_slug,
		'excerpt'    => $excerpt,
		'has_thumb'  => has_post_thumbnail( $post ),
		'thumb_html' => get_the_post_thumbnail( $post, 'medium_large', array( 'class' => 'portal-noticia-card__img' ) ),
	);
}

/**
 * Converte WP_Query em lista de notícias.
 *
 * @param WP_Query $query Consulta.
 * @return array<int, array<string, mixed>>
 */
function portal_si_map_noticias_from_query( WP_Query $query ) {
	$items = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$item = portal_si_noticia_to_array( get_the_ID() );
			if ( $item ) {
				$items[] = $item;
			}
		}
		wp_reset_postdata();
	}
	return $items;
}

/**
 * Ajusta a listagem principal de notícias.
 *
 * @param WP_Query $query Consulta principal.
 */
function portal_si_noticias_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_home() && ! is_front_page() ) {
		$query->set( 'posts_per_page', PORTAL_SI_NOTICIAS_PER_PAGE );
	}
}
add_action( 'pre_get_posts', 'portal_si_noticias_pre_get_posts' );
