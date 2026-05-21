<?php
/**
 * Acessibilidade — alto contraste, preferências e strings para JS.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Restaura alto contraste antes da pintura (localStorage).
 */
function portal_si_a11y_contrast_boot() {
	?>
	<script>
	(function () {
		try {
			if (window.localStorage.getItem('portal-high-contrast') === '1') {
				document.body.classList.add('portal-high-contrast');
			}
		} catch (e) {}
	})();
	</script>
	<?php
}
add_action( 'wp_body_open', 'portal_si_a11y_contrast_boot', 1 );

/**
 * Folha de estilos de acessibilidade.
 */
function portal_si_enqueue_a11y_styles() {
	wp_enqueue_style(
		'portal-si-a11y',
		get_template_directory_uri() . '/assets/css/a11y.css',
		array( 'portal-si-noticias' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_enqueue_a11y_styles', 20 );

/**
 * Strings e estado inicial para theme.js.
 */
function portal_si_a11y_script_data() {
	wp_localize_script(
		'portal-si-cefet-theme',
		'portalSiA11y',
		array(
			'contrastOn'  => __( 'Desativar alto contraste', 'portal-si-cefet' ),
			'contrastOff' => __( 'Alto contraste', 'portal-si-cefet' ),
			'searchOpen'  => __( 'Abrir busca', 'portal-si-cefet' ),
			'searchClose' => __( 'Fechar busca', 'portal-si-cefet' ),
			'menuOpen'    => __( 'Abrir menu', 'portal-si-cefet' ),
			'menuClose'   => __( 'Fechar menu', 'portal-si-cefet' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_a11y_script_data', 25 );
