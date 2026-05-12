<?php
/**
 * Funções do tema Portal SI CEFET/RJ (esqueleto).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/seed-ia.php';
require_once get_template_directory() . '/inc/breadcrumbs.php';
require_once get_template_directory() . '/inc/search.php';

/**
 * Suporte a recursos usados nas próximas etapas (título, thumbnails, HTML5).
 */
function portal_si_cefet_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Menu principal', 'portal-si-cefet' ),
			'footer'  => __( 'Menu rodapé', 'portal-si-cefet' ),
		)
	);
}
add_action( 'after_setup_theme', 'portal_si_cefet_setup' );

/**
 * Folha de estilos do tema.
 */
function portal_si_cefet_scripts() {
	wp_enqueue_style(
		'portal-si-cefet-style',
		get_stylesheet_uri(),
		array(),
		'0.1.3'
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_cefet_scripts' );
