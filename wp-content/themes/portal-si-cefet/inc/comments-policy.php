<?php
/**
 * Comentários e pingbacks desligados em posts e páginas.
 * Alinha-se ao RI06 (sem comentários abertos no portal institucional).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove suporte a comentários e trackbacks dos tipos editoriais principais.
 */
function portal_si_comments_disable_support() {
	foreach ( array( 'post', 'page' ) as $type ) {
		remove_post_type_support( $type, 'comments' );
		remove_post_type_support( $type, 'trackbacks' );
	}
}
add_action( 'init', 'portal_si_comments_disable_support', 100 );

/**
 * Garante que o front não ofereça comentários (conteúdo já publicado incluído).
 */
function portal_si_comments_closed( $open, $post_id ) {
	$post = get_post( $post_id );
	if ( $post && in_array( $post->post_type, array( 'post', 'page' ), true ) ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'portal_si_comments_closed', 10, 2 );
add_filter( 'pings_open', 'portal_si_comments_closed', 10, 2 );
