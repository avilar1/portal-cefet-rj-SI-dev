<?php
/**
 * Funções do tema Portal SI CEFET/RJ.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_CEFET_VERSION', '0.3.6' );

require_once get_template_directory() . '/inc/seed-ia.php';
require_once get_template_directory() . '/inc/seed-editorial.php';
require_once get_template_directory() . '/inc/comments-policy.php';
require_once get_template_directory() . '/inc/evento.php';
require_once get_template_directory() . '/inc/breadcrumbs.php';
require_once get_template_directory() . '/inc/search.php';
require_once get_template_directory() . '/inc/home.php';
require_once get_template_directory() . '/inc/fonts.php';
require_once get_template_directory() . '/inc/design-system.php';
require_once get_template_directory() . '/inc/ds-components.php';
require_once get_template_directory() . '/inc/a11y.php';
require_once get_template_directory() . '/inc/nav.php';

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
 * Classe no body para estilos da home.
 *
 * @param string[] $classes Classes do body.
 * @return string[]
 */
function portal_si_cefet_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'portal-is-home';
	}
	if ( is_page( 'agenda-e-eventos' ) ) {
		$classes[] = 'portal-is-agenda';
	}
	return $classes;
}
add_filter( 'body_class', 'portal_si_cefet_body_classes' );

/**
 * Folhas de estilo e scripts do tema.
 */
function portal_si_cefet_scripts() {
	wp_enqueue_style(
		'portal-si-cefet-style',
		get_stylesheet_uri(),
		array( 'portal-si-cefet-font-rawline', 'portal-si-cefet-font-raleway', 'portal-si-ds-tokens' ),
		PORTAL_SI_CEFET_VERSION
	);

	wp_enqueue_style(
		'portal-si-cefet-layout',
		get_template_directory_uri() . '/assets/css/home.css',
		array( 'portal-si-cefet-style', 'portal-si-ds-compat' ),
		PORTAL_SI_CEFET_VERSION
	);

	wp_enqueue_style(
		'portal-si-pages',
		get_template_directory_uri() . '/assets/css/pages.css',
		array( 'portal-si-cefet-layout' ),
		PORTAL_SI_CEFET_VERSION
	);

	wp_enqueue_script(
		'portal-si-cefet-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_cefet_scripts' );
