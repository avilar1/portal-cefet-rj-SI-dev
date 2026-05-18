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
 * Eventos da agenda na home (placeholder até The Events Calendar).
 *
 * @return array<int, array{date: string, title: string, url: string}>
 */
function portal_si_home_agenda_events() {
	$agenda_url = portal_si_page_url( 'agenda-e-eventos' );

	$events = array(
		array(
			'date'  => '12 Jun 2026',
			'title' => __( 'Semana de Integração — Calouros', 'portal-si-cefet' ),
			'url'   => $agenda_url,
		),
		array(
			'date'  => '20 Ago 2026',
			'title' => __( 'Defesas de TCC — 2º semestre', 'portal-si-cefet' ),
			'url'   => $agenda_url,
		),
		array(
			'date'  => '15 Out 2026',
			'title' => __( 'Feira de Projetos — Fábrica de Software', 'portal-si-cefet' ),
			'url'   => $agenda_url,
		),
		array(
			'date'  => '10 Dez 2026',
			'title' => __( 'Encerramento do semestre letivo', 'portal-si-cefet' ),
			'url'   => $agenda_url,
		),
	);

	/**
	 * Permite substituir eventos por integração com plugin de calendário.
	 *
	 * @param array $events Lista de eventos.
	 */
	return apply_filters( 'portal_si_home_agenda_events', $events );
}

/**
 * Links de serviço — zona 5 (acesso rápido funcional).
 *
 * @return array<int, array{icon: string, title: string, description: string, url: string}>
 */
function portal_si_home_service_links() {
	return array(
		array(
			'icon'        => 'clipboard',
			'title'       => __( 'Grade Curricular', 'portal-si-cefet' ),
			'description' => __( 'Consultar disciplinas e ementas', 'portal-si-cefet' ),
			'url'         => portal_si_page_url( 'grade-curricular' ),
		),
		array(
			'icon'        => 'calendar',
			'title'       => __( 'Calendário Acadêmico', 'portal-si-cefet' ),
			'description' => __( 'Datas importantes e eventos', 'portal-si-cefet' ),
			'url'         => portal_si_page_url( 'agenda-e-eventos' ),
		),
		array(
			'icon'        => 'graduation',
			'title'       => __( 'Processo Seletivo', 'portal-si-cefet' ),
			'description' => __( 'Informações sobre inscrição', 'portal-si-cefet' ),
			'url'         => portal_si_page_url( 'ingresso' ),
		),
		array(
			'icon'        => 'teacher',
			'title'       => __( 'Corpo Docente', 'portal-si-cefet' ),
			'description' => __( 'Conhecer professores e pesquisadores', 'portal-si-cefet' ),
			'url'         => portal_si_page_url( 'corpo-docente' ),
		),
		array(
			'icon'        => 'megaphone',
			'title'       => __( 'Ouvidoria', 'portal-si-cefet' ),
			'description' => __( 'Canal de comunicação e denúncias', 'portal-si-cefet' ),
			'url'         => portal_si_page_url( 'contato' ),
		),
		array(
			'icon'        => 'document',
			'title'       => __( 'Documentos', 'portal-si-cefet' ),
			'description' => __( 'Regulamentos, normas e formulários', 'portal-si-cefet' ),
			'url'         => portal_si_page_url( 'termos-de-uso' ),
		),
	);
}

/**
 * Colunas do mapa do site no rodapé (zona 7).
 *
 * @return array<int, array{title: string, links: array<int, array{label: string, slug: string}>}>
 */
function portal_si_footer_sitemap_columns() {
	return array(
		array(
			'title' => __( 'Institucional', 'portal-si-cefet' ),
			'links' => array(
				array( 'label' => __( 'Sobre o Curso', 'portal-si-cefet' ), 'slug' => 'sobre-o-curso' ),
				array( 'label' => __( 'Ingresso', 'portal-si-cefet' ), 'slug' => 'ingresso' ),
				array( 'label' => __( 'Infraestrutura', 'portal-si-cefet' ), 'slug' => 'infraestrutura' ),
				array( 'label' => __( 'Contato', 'portal-si-cefet' ), 'slug' => 'contato' ),
			),
		),
		array(
			'title' => __( 'Docentes', 'portal-si-cefet' ),
			'links' => array(
				array( 'label' => __( 'Corpo Docente', 'portal-si-cefet' ), 'slug' => 'corpo-docente' ),
				array( 'label' => __( 'Pesquisa e Extensão', 'portal-si-cefet' ), 'slug' => 'pesquisa-e-extensao' ),
				array( 'label' => __( 'Grade Curricular', 'portal-si-cefet' ), 'slug' => 'grade-curricular' ),
				array( 'label' => __( 'Carreira e Egressos', 'portal-si-cefet' ), 'slug' => 'carreira-e-egressos' ),
			),
		),
		array(
			'title' => __( 'Fábrica de Software', 'portal-si-cefet' ),
			'links' => array(
				array( 'label' => __( 'Fábrica de Software', 'portal-si-cefet' ), 'slug' => 'fabrica-de-software' ),
				array( 'label' => __( 'Vida Estudantil', 'portal-si-cefet' ), 'slug' => 'vida-estudantil' ),
				array( 'label' => __( 'Notícias', 'portal-si-cefet' ), 'slug' => 'noticias' ),
				array( 'label' => __( 'Agenda e Eventos', 'portal-si-cefet' ), 'slug' => 'agenda-e-eventos' ),
			),
		),
	);
}
