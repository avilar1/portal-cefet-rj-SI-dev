<?php
/**
 * Vida estudantil — conteúdo inicial (RF07).
 *
 * Usado até a página ser salva no painel pela primeira vez; depois disso, vale o que
 * estiver na caixa «Conteúdo da página» (inc/vida-estudantil.php).
 * Textos sem valores nem datas: regras e prazos ficam nos editais oficiais.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro' => 'Auxílios, bolsas e serviços de apoio para quem estuda Sistemas de Informação no CEFET/RJ, Campus Maria da Graça. Valores, prazos e regras estão sempre no edital de cada programa.',

	'categories' => array(
		'auxilio' => 'Auxílio financeiro',
		'bolsa'   => 'Bolsas acadêmicas',
		'apoio'   => 'Apoio no campus',
	),

	'items' => array(
		array(
			'category'    => 'auxilio',
			'title'       => 'Programa de Auxílio ao Estudante (PAE)',
			'description' => 'Auxílio financeiro para estudantes em situação de vulnerabilidade socioeconômica. Há um edital por semestre, com inscrição online.',
			'link_label'  => 'Página da assistência estudantil',
			'url'         => 'https://cefet-rj.br/index.php/component/content/category/extensao-assistencia-estudantil',
		),
		array(
			'category'    => 'bolsa',
			'title'       => 'Monitoria',
			'description' => 'Apoie professores e colegas em uma disciplina que você já cursou. Os editais são divulgados pela coordenação no início do semestre.',
			'link_label'  => '',
			'url'         => '',
		),
		array(
			'category'    => 'bolsa',
			'title'       => 'Iniciação científica',
			'description' => 'Participe de um projeto de pesquisa com um professor orientador. Procure um docente do curso que tenha projeto aberto.',
			'link_label'  => 'Iniciação científica no CEFET/RJ',
			'url'         => 'https://www.cefet-rj.br/index.php/depes/223-depes/8782-iniciacao-cientifica',
		),
		array(
			'category'    => 'bolsa',
			'title'       => 'Extensão',
			'description' => 'Atue em projetos que levam o conhecimento do curso à comunidade. Cada projeto seleciona seus bolsistas.',
			'link_label'  => 'Editais de extensão',
			'url'         => 'https://www.cefet-rj.br/index.php/formularios-acoes-de-extensao/editais-pbext-e-pbext-dh',
		),
		array(
			'category'    => 'apoio',
			'title'       => 'Seção de Articulação Pedagógica (SAPED)',
			'description' => 'Assistente social, psicólogo e equipe pedagógica para acolhimento, orientação e apoio aos estudos.',
			'link_label'  => 'Página da SAPED',
			'url'         => 'https://www.cefet-rj.br/index.php/secao-de-articulacao-pedagogica',
		),
		array(
			'category'    => 'apoio',
			'title'       => 'Núcleo de Acessibilidade (NAPNE)',
			'description' => 'Apoio e recursos de acessibilidade para estudantes com deficiência, TEA ou transtornos de aprendizagem.',
			'link_label'  => 'Página do NAPNE',
			'url'         => 'https://www.cefet-rj.br/index.php/napne',
		),
		array(
			'category'    => 'apoio',
			'title'       => 'Biblioteca do campus',
			'description' => 'Acervo com foco em Computação, espaço para estudo individual e empréstimo domiciliar.',
			'link_label'  => 'Página da biblioteca',
			'url'         => 'https://www.cefet-rj.br/index.php/biblioteca-campus-maria-da-graca',
		),
		array(
			'category'    => 'apoio',
			'title'       => 'Central de Estágio',
			'description' => 'Orientação e análise dos documentos de estágio, feitas pela Seção de Registros Acadêmicos do campus.',
			'link_label'  => 'Estágio no campus',
			'url'         => 'https://www.cefet-rj.br/index.php/estagio-campus-maria-da-graca',
		),
	),
);
