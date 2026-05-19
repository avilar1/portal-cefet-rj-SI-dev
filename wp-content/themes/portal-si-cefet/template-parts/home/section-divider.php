<?php
/**
 * Separador de seção — br-divider (GovBR-DS 3.7).
 *
 * Variante `content` quando há label (linha — título — linha).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

portal_si_section_divider(
	array(
		'label' => isset( $args['label'] ) ? $args['label'] : '',
		'id'    => isset( $args['id'] ) ? $args['id'] : '',
		'size'  => isset( $args['size'] ) ? $args['size'] : '',
		'class' => isset( $args['class'] ) ? $args['class'] : 'portal-section-divider',
		'wrap'  => isset( $args['wrap'] ) ? (bool) $args['wrap'] : true,
	)
);
