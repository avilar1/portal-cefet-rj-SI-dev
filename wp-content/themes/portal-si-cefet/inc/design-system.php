<?php
/**
 * Design System gov.br — modo híbrido.
 *
 * Tokens leves do tema (ds-tokens.css) + componentes pontuais do @govbr-ds/core 3.7
 * (card, divider) via inc/ds-components.php — sem core.min.css completo.
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
