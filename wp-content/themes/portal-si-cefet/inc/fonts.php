<?php
/**
 * Tipografia do Design System gov.br — Rawline (corpo) + Raleway (títulos).
 *
 * Rawline: referência oficial do GovBR-DS via CDN documentado em govbr-ds-wiki.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Preconnect aos hosts de fontes (performance).
 *
 * @param array  $urls          URLs.
 * @param string $relation_type Tipo de relação.
 * @return array
 */
function portal_si_fonts_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
		$urls[] = array(
			'href' => 'https://fonts.cdnfonts.com',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'portal_si_fonts_resource_hints', 10, 2 );

/**
 * Enfileira folhas de fonte antes do CSS do tema.
 */
function portal_si_enqueue_fonts() {
	// Rawline — corpo (font-body). Sem este enqueue, o navegador usa o fallback system-ui.
	wp_enqueue_style(
		'portal-si-cefet-font-rawline',
		'https://fonts.cdnfonts.com/css/rawline',
		array(),
		null
	);

	// Raleway — títulos (font-heading). Pesos usados no layout: 400–700.
	wp_enqueue_style(
		'portal-si-cefet-font-raleway',
		'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_enqueue_fonts', 5 );
