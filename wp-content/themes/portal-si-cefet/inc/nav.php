<?php
/**
 * Navegação — menu compacto no header (Figma) + menu completo no mobile.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Itens do menu principal no header desktop (slugs + rótulos do wireframe).
 *
 * @return array<int, array{slug: string, label: string|null}>
 */
function portal_si_header_compact_items() {
	return array(
		array(
			'slug'  => 'sobre-o-curso',
			'label' => __( 'Institucional', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'ingresso',
			'label' => __( 'Curso', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'grade-curricular',
			'label' => __( 'Grade Curricular', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'corpo-docente',
			'label' => __( 'Docentes', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'fabrica-de-software',
			'label' => __( 'Fábrica de Software', 'portal-si-cefet' ),
		),
		array(
			'slug'  => 'contato',
			'label' => __( 'Contato', 'portal-si-cefet' ),
		),
	);
}

/**
 * Imprime links do menu compacto (header azul).
 */
function portal_si_render_header_compact_menu() {
	echo '<ul class="nav-primary__list nav-primary__list--compact">';
	$seen = array();
	foreach ( portal_si_header_compact_items() as $item ) {
		$key = $item['slug'] . '|' . $item['label'];
		if ( isset( $seen[ $key ] ) ) {
			continue;
		}
		$seen[ $key ] = true;
		$url   = portal_si_page_url( $item['slug'] );
		$label = $item['label'];
		printf(
			'<li><a href="%1$s">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}
