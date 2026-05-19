<?php
/**
 * Componentes GovBR-DS (@govbr-ds/core 3.7.0) — card e divider.
 *
 * Assets em assets/vendor/govbr-ds/3.7.0/ (origem: contexto/package do projeto).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Versão do pacote @govbr-ds/core em uso no tema. */
define( 'PORTAL_SI_GOVBR_DS_VERSION', '3.7.0' );

/**
 * URI base dos assets vendor do DS.
 *
 * @return string
 */
function portal_si_govbr_ds_vendor_uri() {
	return get_template_directory_uri() . '/assets/vendor/govbr-ds/' . PORTAL_SI_GOVBR_DS_VERSION;
}

/**
 * Enfileira tokens + card + divider (sem core.min.css).
 */
function portal_si_enqueue_govbr_ds_components() {
	$vendor = portal_si_govbr_ds_vendor_uri();
	$ver    = PORTAL_SI_GOVBR_DS_VERSION;

	wp_enqueue_style(
		'portal-si-govbr-tokens',
		$vendor . '/core-tokens.min.css',
		array( 'portal-si-ds-tokens' ),
		$ver
	);

	wp_enqueue_style(
		'portal-si-govbr-card',
		$vendor . '/card.min.css',
		array( 'portal-si-govbr-tokens' ),
		$ver
	);

	wp_enqueue_style(
		'portal-si-govbr-divider',
		$vendor . '/divider.min.css',
		array( 'portal-si-govbr-tokens' ),
		$ver
	);

	wp_enqueue_style(
		'portal-si-ds-compat',
		get_template_directory_uri() . '/assets/css/ds-compat.css',
		array( 'portal-si-govbr-card', 'portal-si-govbr-divider' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_enqueue_govbr_ds_components', 9 );

/**
 * Classes extras para br-card.
 *
 * @param string[] $modifiers Modificadores (ex.: hover, h-fixed).
 * @return string
 */
function portal_si_br_card_class( array $modifiers = array() ) {
	$classes = array( 'br-card' );
	foreach ( $modifiers as $mod ) {
		$mod = sanitize_html_class( $mod );
		if ( $mod ) {
			$classes[] = $mod;
		}
	}
	return implode( ' ', $classes );
}

/**
 * Imprime separador de seção (br-divider).
 *
 * @param array $args {
 *     @type string $label  Título central (ativa classe `content`).
 *     @type string $id     ID para aria-labelledby da seção seguinte.
 *     @type string $size   sm|md|lg.
 *     @type string $class  Classes adicionais.
 *     @type bool   $wrap    Envolver em container com largura do portal.
 * }
 */
function portal_si_section_divider( array $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'label' => '',
			'id'    => '',
			'size'  => '',
			'class' => 'portal-section-divider',
			'wrap'  => true,
		)
	);

	$classes = array( 'br-divider' );
	if ( $args['label'] ) {
		$classes[] = 'content';
	}
	if ( $args['size'] && in_array( $args['size'], array( 'sm', 'md', 'lg' ), true ) ) {
		$classes[] = $args['size'];
	}
	if ( $args['class'] ) {
		$classes[] = $args['class'];
	}

	$class_attr = esc_attr( implode( ' ', $classes ) );
	$id_attr    = $args['id'] ? ' id="' . esc_attr( $args['id'] ) . '"' : '';

	if ( $args['wrap'] ) {
		echo '<div class="portal-section-divider-wrap">';
	}

	if ( $args['label'] ) {
		printf(
			'<span class="%1$s"%2$s role="separator" aria-label="%3$s">',
			$class_attr,
			$id_attr,
			esc_attr( $args['label'] )
		);
		echo '<span class="portal-section-divider__label">';
		echo esc_html( $args['label'] );
		echo '</span></span>';
	} else {
		printf( '<hr class="%s"%s />', $class_attr, $id_attr );
	}

	if ( $args['wrap'] ) {
		echo '</div>';
	}
}
