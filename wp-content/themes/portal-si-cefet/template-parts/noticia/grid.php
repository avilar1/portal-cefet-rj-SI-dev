<?php
/**
 * Grade de cards de notícia.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items         = isset( $args['items'] ) ? $args['items'] : array();
$show_excerpt  = ! empty( $args['show_excerpt'] );
$empty_message = isset( $args['empty_message'] ) ? $args['empty_message'] : __( 'Nenhuma notícia publicada ainda.', 'portal-si-cefet' );
$grid_class    = isset( $args['grid_class'] ) ? $args['grid_class'] : 'portal-noticia-grid';

if ( empty( $items ) ) {
	portal_si_the_coming_soon_notice(
		array(
			'variant' => 'compact',
			'message' => $empty_message,
		)
	);
	return;
}

printf( '<ul class="%s">', esc_attr( $grid_class ) );
foreach ( $items as $noticia ) {
	get_template_part(
		'template-parts/noticia/card',
		null,
		array(
			'noticia'      => $noticia,
			'show_excerpt' => $show_excerpt,
		)
	);
}
echo '</ul>';
