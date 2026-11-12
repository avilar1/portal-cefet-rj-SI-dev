<?php
/**
 * Dúvidas frequentes — orientação curta sobre o que o portal já explica.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_DUVIDAS_SLUG = 'duvidas-frequentes';

/**
 * Perguntas estáveis. O texto muda com o tema, não no wp-admin.
 *
 * @return array<int, array{id: string, question: string, answer: string, url: string, link_label: string}>
 */
function portal_si_duvidas_items() {
	$ingresso = portal_si_page_url( 'ingresso' );
	$calendario = portal_si_page_url( 'calendario-academico' );
	$agenda = portal_si_page_url( 'agenda-e-eventos' );
	$contato = function_exists( 'portal_si_coordination_contato_url' )
		? portal_si_coordination_contato_url()
		: portal_si_page_url( 'contato' );

	return array(
		array(
			'id'         => 'ingressar',
			'question'   => __( 'Como ingressar no curso?', 'portal-si-cefet' ),
			'answer'     => __( 'O ingresso é pelo SISU, com a nota do ENEM. A página Ingresso reúne o passo a passo, os documentos e os links oficiais do CEFET/RJ e do MEC.', 'portal-si-cefet' ),
			'url'        => $ingresso,
			'link_label' => __( 'Ver como ingressar', 'portal-si-cefet' ),
		),
		array(
			'id'         => 'calendario',
			'question'   => __( 'Calendário acadêmico e agenda são a mesma coisa?', 'portal-si-cefet' ),
			'answer'     => __( 'Não. O Calendário Acadêmico lista as datas oficiais do período letivo, como início das aulas, provas e feriados. A Agenda reúne eventos do curso, como palestras e atividades.', 'portal-si-cefet' ),
			'url'        => $calendario,
			'link_label' => __( 'Abrir o calendário acadêmico', 'portal-si-cefet' ),
		),
		array(
			'id'         => 'agenda',
			'question'   => __( 'Onde vejo palestras e atividades do curso?', 'portal-si-cefet' ),
			'answer'     => __( 'Na Agenda e Eventos. Essa página não substitui o calendário oficial.', 'portal-si-cefet' ),
			'url'        => $agenda,
			'link_label' => __( 'Abrir a agenda', 'portal-si-cefet' ),
		),
		array(
			'id'         => 'contato',
			'question'   => __( 'Onde falo com a coordenação?', 'portal-si-cefet' ),
			'answer'     => __( 'Na página Contato há e-mail, telefone e um formulário. A resposta volta pelo e-mail informado, com um número de referência.', 'portal-si-cefet' ),
			'url'        => $contato,
			'link_label' => __( 'Falar com a coordenação', 'portal-si-cefet' ),
		),
		array(
			'id'         => 'link-externo',
			'question'   => __( 'O que significa um link que abre outro site?', 'portal-si-cefet' ),
			'answer'     => __( 'No acesso rápido da página inicial, Área do Aluno, Área do Professor, Chamados e Estágio abrem um site do CEFET/RJ em outra aba. O endereço deixa de ser o deste portal.', 'portal-si-cefet' ),
			'url'        => home_url( '/#portal-service-links-title' ),
			'link_label' => __( 'Ver o acesso rápido', 'portal-si-cefet' ),
		),
		array(
			'id'         => 'em-breve',
			'question'   => __( 'O que ainda está em construção?', 'portal-si-cefet' ),
			'answer'     => __( 'Quando uma seção ainda não tem conteúdo, o portal mostra o aviso “Conteúdo em breve” e um caminho para a coordenação. Termos de Uso é um desses casos. O mapa das páginas publicadas está no rodapé de todas as telas.', 'portal-si-cefet' ),
			'url'        => '#portal-mapa-do-site',
			'link_label' => __( 'Ir ao mapa do rodapé', 'portal-si-cefet' ),
		),
	);
}

/**
 * Garante a página publicada para o template page-duvidas-frequentes.php.
 */
function portal_si_ensure_duvidas_page() {
	if ( ! function_exists( 'portal_si_ensure_page' ) ) {
		return;
	}
	portal_si_ensure_page(
		__( 'Dúvidas frequentes', 'portal-si-cefet' ),
		PORTAL_SI_DUVIDAS_SLUG
	);
}
add_action( 'init', 'portal_si_ensure_duvidas_page', 20 );
