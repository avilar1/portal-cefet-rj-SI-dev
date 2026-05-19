<?php
/**
 * Design System gov.br — modo adaptado (tokens + boas práticas, sem core.min.css).
 *
 * O pacote completo @govbr-ds/core conflita com o layout do portal; usamos
 * theme.json + CSS do tema alinhados aos tokens oficiais (#1351B4, Rawline, Raleway).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Folha leve com utilitários inspirados no DS (botões, foco).
 */
function portal_si_enqueue_design_tokens() {
	wp_enqueue_style(
		'portal-si-ds-tokens',
		get_template_directory_uri() . '/assets/css/ds-tokens.css',
		array( 'portal-si-cefet-font-rawline', 'portal-si-cefet-font-raleway' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_enqueue_design_tokens', 8 );
