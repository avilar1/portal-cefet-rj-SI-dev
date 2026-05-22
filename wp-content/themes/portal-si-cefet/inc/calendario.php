<?php
/**
 * Calendário Acadêmico — página dedicada (separada da Agenda de eventos / RF20).
 *
 * Dados: data/calendario-academico.php + PDF em assets/documentos/.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_CALENDARIO_SLUG', 'calendario-academico' );

/**
 * Lê argumento passado a template-parts/calendario/* (compatível com $args do WP 5.5+).
 *
 * @param array<string, mixed>|null $args    Args do get_template_part.
 * @param string                  $key     Chave.
 * @param mixed                   $default Valor padrão.
 * @return mixed
 */
function portal_si_calendario_tpl_arg( $args, $key, $default = null ) {
	if ( is_array( $args ) && array_key_exists( $key, $args ) ) {
		return $args[ $key ];
	}
	return $default;
}

/**
 * Configuração do calendário (meta da página no WP; fallback: data/calendario-academico.php).
 *
 * @return array<string, mixed>
 */
function portal_si_calendario_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	if ( function_exists( 'portal_si_calendario_get_page_data' ) ) {
		$config = portal_si_calendario_get_page_data();
	} else {
		$config = portal_si_calendario_defaults();
	}

	return apply_filters( 'portal_si_calendario_config', $config );
}

/**
 * URL pública do PDF — biblioteca de media ou ficheiro padrão do tema.
 *
 * @return string URL vazia se ausente.
 */
function portal_si_calendario_pdf_url() {
	$config = portal_si_calendario_config();

	if ( ! empty( $config['pdf_attachment_id'] ) ) {
		$url = wp_get_attachment_url( (int) $config['pdf_attachment_id'] );
		if ( $url ) {
			return $url;
		}
	}

	$filename = isset( $config['pdf_filename'] ) ? (string) $config['pdf_filename'] : '';
	if ( '' === $filename ) {
		return '';
	}

	$path = get_template_directory() . '/assets/documentos/' . $filename;
	if ( ! is_readable( $path ) ) {
		return '';
	}

	return get_template_directory_uri() . '/assets/documentos/' . rawurlencode( $filename );
}

/**
 * Data da última atualização do documento oficial (PDF CONPUS), definida no painel.
 *
 * @return string
 */
function portal_si_calendario_document_updated_display() {
	$config = portal_si_calendario_config();
	$raw    = '';
	if ( ! empty( $config['last_updated'] ) ) {
		$raw = (string) $config['last_updated'];
	} elseif ( ! empty( $config['source_updated'] ) ) {
		$raw = (string) $config['source_updated'];
	}
	if ( function_exists( 'portal_si_calendario_format_date_display' ) ) {
		return portal_si_calendario_format_date_display( $raw );
	}
	return $raw;
}

/** @deprecated Use portal_si_calendario_document_updated_display() */
function portal_si_calendario_last_updated_display() {
	return portal_si_calendario_document_updated_display();
}

/**
 * Última vez que um editor/admin gravou esta página no portal (automático).
 *
 * @param int $page_id ID da página.
 * @return array{date: string, author: string}|null
 */
function portal_si_calendario_portal_revision_display( $page_id = 0 ) {
	if ( function_exists( 'portal_si_calendario_portal_revision' ) ) {
		return portal_si_calendario_portal_revision( $page_id );
	}
	return null;
}

/**
 * Intro — excerpt da página ou fallback.
 *
 * @return string
 */
function portal_si_calendario_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CALENDARIO_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_calendario_config();
	return isset( $config['intro'] ) ? (string) $config['intro'] : '';
}

/**
 * Garante página, pai institucional e excerpt.
 */
function portal_si_ensure_calendario_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CALENDARIO_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Calendário Acadêmico', 'portal-si-cefet' ),
			PORTAL_SI_CALENDARIO_SLUG
		);
	}

	if ( ! $page_id ) {
		return;
	}

	if ( function_exists( 'portal_si_calendario_seed_page_meta' ) ) {
		portal_si_calendario_seed_page_meta( $page_id );
	}

	$hub_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	if ( $hub_id && (int) get_post_field( 'post_parent', $page_id ) !== (int) $hub_id ) {
		wp_update_post(
			array(
				'ID'          => $page_id,
				'post_parent' => $hub_id,
			)
		);
	}

	$intro = portal_si_calendario_intro();
	if ( $intro ) {
		$page = get_post( $page_id );
		if ( $page && '' === trim( $page->post_excerpt ) ) {
			wp_update_post(
				array(
					'ID'           => $page_id,
					'post_excerpt' => $intro,
				)
			);
		}
	}
}
add_action( 'after_setup_theme', 'portal_si_ensure_calendario_page', 25 );

/**
 * CSS da página de calendário.
 */
function portal_si_calendario_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_CALENDARIO_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-calendario',
		get_template_directory_uri() . '/assets/css/calendario.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_calendario_enqueue_assets', 16 );
