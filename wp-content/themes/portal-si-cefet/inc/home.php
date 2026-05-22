<?php
/**
 * Helpers da página inicial (RF01, RF17, RF20).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URL de página publicada pelo slug, ou home.
 *
 * @param string $slug Slug da página.
 */
function portal_si_page_url( $slug ) {
	$page_id = portal_si_get_page_id_by_slug( $slug );
	if ( $page_id ) {
		return get_permalink( $page_id );
	}
	return home_url( '/' );
}

/**
 * Eventos da agenda na home (CPT portal_evento).
 *
 * @return array<int, array{date: string, date_iso: string, title: string, url: string}>
 */
function portal_si_home_agenda_events() {
	$events = portal_si_get_upcoming_eventos( 4 );

	/**
	 * Permite ajustar ou substituir a lista (ex.: plugin de calendário).
	 *
	 * @param array $events Lista de eventos.
	 */
	return apply_filters( 'portal_si_home_agenda_events', $events );
}

/**
 * Links de serviço — zona 5 (RF01, RF22: acesso rápido).
 *
 * URLs externas e textos: data/home-service-links.php
 *
 * @return array<int, array{icon: string, title: string, description: string, url: string, external: bool}>
 */
function portal_si_home_service_links() {
	static $links = null;

	if ( null !== $links ) {
		return $links;
	}

	$path = get_template_directory() . '/data/home-service-links.php';
	$raw  = is_readable( $path ) ? require $path : array();
	$out  = array();

	foreach ( $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$url = isset( $row['url'] ) ? (string) $row['url'] : '';
		if ( '' === $url && ! empty( $row['slug'] ) ) {
			$url = portal_si_page_url( (string) $row['slug'] );
		}

		if ( '' === $url ) {
			continue;
		}

		$out[] = array(
			'icon'        => isset( $row['icon'] ) ? (string) $row['icon'] : 'document',
			'title'       => isset( $row['title'] ) ? (string) $row['title'] : '',
			'description' => isset( $row['description'] ) ? (string) $row['description'] : '',
			'url'         => $url,
			'external'    => ! empty( $row['external'] ),
		);
	}

	/**
	 * @param array<int, array{icon: string, title: string, description: string, url: string, external: bool}> $out Links da home.
	 */
	$links = apply_filters( 'portal_si_home_service_links', $out );
	return $links;
}
