<?php
/**
 * Fluxo de disciplinas — RF26.
 *
 * Página filha da Grade Curricular; usa os mesmos dados (portal_si_grade_periods / optativas).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_FLUXO_SLUG', 'fluxo-de-disciplinas' );

/**
 * Intro — excerpt da página ou fallback.
 *
 * @return string
 */
function portal_si_fluxo_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_FLUXO_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}
	return __( 'Selecione uma disciplina para ver o caminho até ela: quais matérias precisam ser cursadas antes e quais ela libera nos períodos seguintes.', 'portal-si-cefet' );
}

/**
 * Garante a página do fluxo como filha da Grade Curricular.
 */
function portal_si_ensure_fluxo_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_FLUXO_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Fluxo de Disciplinas', 'portal-si-cefet' ),
			PORTAL_SI_FLUXO_SLUG
		);
	}

	if ( ! $page_id ) {
		return;
	}

	$grade_id = portal_si_get_page_id_by_slug( PORTAL_SI_GRADE_SLUG );
	if ( $grade_id && (int) get_post_field( 'post_parent', $page_id ) !== (int) $grade_id ) {
		wp_update_post(
			array(
				'ID'          => $page_id,
				'post_parent' => $grade_id,
			)
		);
	}
}
add_action( 'after_setup_theme', 'portal_si_ensure_fluxo_page', 27 );

/**
 * Pré-requisitos como atributo data (códigos separados por espaço).
 *
 * @param array<string, mixed> $disc Disciplina normalizada.
 * @return string
 */
function portal_si_fluxo_pre_attr( $disc ) {
	return implode( ' ', isset( $disc['pre'] ) ? (array) $disc['pre'] : array() );
}

/**
 * Classe no body.
 *
 * @param string[] $classes Classes do body.
 * @return string[]
 */
function portal_si_fluxo_body_class( $classes ) {
	if ( is_page( PORTAL_SI_FLUXO_SLUG ) ) {
		$classes[] = 'portal-is-fluxo';
	}
	return $classes;
}
add_filter( 'body_class', 'portal_si_fluxo_body_class' );

/**
 * CSS e JS do fluxo.
 */
function portal_si_fluxo_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_FLUXO_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-fluxo',
		get_template_directory_uri() . '/assets/css/fluxo.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);

	wp_enqueue_script(
		'portal-si-fluxo',
		get_template_directory_uri() . '/assets/js/fluxo.js',
		array(),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_fluxo_enqueue_assets', 16 );
