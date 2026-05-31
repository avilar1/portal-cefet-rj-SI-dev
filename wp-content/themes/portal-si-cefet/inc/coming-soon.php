<?php
/**
 * Avisos «conteúdo em breve» — páginas e seções pendentes.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slugs de páginas sem conteúdo editorial (até a coordenação publicar).
 *
 * @return string[]
 */
function portal_si_coming_soon_page_slugs() {
	$slugs = array(
		'grade-curricular',
		'carreira-e-egressos',
		'vida-estudantil',
		'acessibilidade',
		'termos-de-uso',
		'mapa-do-site',
	);

	return apply_filters( 'portal_si_coming_soon_page_slugs', $slugs );
}

/**
 * Verifica se a página tem texto no editor (ignora blocos vazios).
 *
 * @param WP_Post|null $post Post.
 * @return bool
 */
function portal_si_post_has_meaningful_content( $post ) {
	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	$raw = trim( (string) $post->post_content );
	if ( '' === $raw ) {
		return false;
	}

	$text = trim( wp_strip_all_tags( $raw ) );
	return '' !== $text;
}

/**
 * Página genérica ainda sem contúdo publicado.
 *
 * @param WP_Post|null $post Post.
 * @return bool
 */
function portal_si_page_should_show_coming_soon( $post = null ) {
	if ( null === $post ) {
		$post = get_post();
	}

	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}

	if ( portal_si_post_has_meaningful_content( $post ) ) {
		return false;
	}

	return in_array( $post->post_name, portal_si_coming_soon_page_slugs(), true );
}

/**
 * Slug sem conteúdo publicado no editor (para selos no hub).
 *
 * @param string $slug Slug da página.
 * @return bool
 */
function portal_si_slug_lacks_published_content( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug || ! in_array( $slug, portal_si_coming_soon_page_slugs(), true ) ) {
		return false;
	}

	$page_id = portal_si_get_page_id_by_slug( $slug );
	if ( ! $page_id ) {
		return true;
	}

	return ! portal_si_post_has_meaningful_content( get_post( $page_id ) );
}

/**
 * URL da coordenação (Contato).
 *
 * @return string
 */
function portal_si_coordination_contato_url() {
	$url = portal_si_page_url( 'contato' );
	if ( $url ) {
		return $url . '#coordenacao';
	}
	return home_url( '/contato/#coordenacao' );
}

/**
 * Mensagem contextual por slug de página.
 *
 * @param string $slug Slug da página.
 * @return string
 */
function portal_si_coming_soon_message_for_slug( $slug ) {
	$messages = array(
		'grade-curricular'          => __( 'A grade curricular, ementas e fluxo de disciplinas estão sendo organizados pela coordenação e em breve estarão disponíveis aqui.', 'portal-si-cefet' ),
		'carreira-e-egressos'       => __( 'Informações sobre empregabilidade, trajetórias de egressos e oportunidades de carreira serão publicadas em breve nesta seção.', 'portal-si-cefet' ),
		'vida-estudantil'           => __( 'Conteúdos sobre bolsas, auxílios, benefícios e vida acadêmica no campus estão em preparação.', 'portal-si-cefet' ),
		'acessibilidade'            => __( 'A declaração de acessibilidade e os recursos deste portal para pessoas com deficiência serão publicados em breve.', 'portal-si-cefet' ),
		'politica-de-privacidade'   => __( 'A política de privacidade e o tratamento de dados pessoais conforme a LGPD estão em elaboração.', 'portal-si-cefet' ),
		'termos-de-uso'             => __( 'Os termos de uso do portal institucional do curso serão publicados em breve.', 'portal-si-cefet' ),
		'mapa-do-site'              => __( 'O mapa completo do portal está sendo atualizado. Enquanto isso, use o menu principal ou o mapa no rodapé.', 'portal-si-cefet' ),
	);

	if ( isset( $messages[ $slug ] ) ) {
		return $messages[ $slug ];
	}

	return __( 'Esta seção está em construção e será atualizada em breve pela equipe do curso.', 'portal-si-cefet' );
}

/**
 * Renderiza aviso reutilizável.
 *
 * @param array<string, mixed> $args Argumentos do template.
 */
function portal_si_the_coming_soon_notice( $args = array() ) {
	get_template_part( 'template-parts/shared/coming-soon', null, $args );
}

/**
 * Enfileira estilos do componente.
 */
function portal_si_coming_soon_enqueue_assets() {
	wp_enqueue_style(
		'portal-si-coming-soon',
		get_template_directory_uri() . '/assets/css/coming-soon.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_coming_soon_enqueue_assets', 17 );
