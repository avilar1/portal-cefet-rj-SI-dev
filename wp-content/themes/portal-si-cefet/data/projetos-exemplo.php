<?php
/**
 * Projetos de exemplo (RF09) — importados uma vez, publicados com o selo "Exemplo".
 *
 * Servem só para demonstrar a listagem; devem ser substituídos por projetos reais no painel.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	array(
		'title'     => 'Análise de dados educacionais para apoio à permanência estudantil',
		'excerpt'   => 'Uso de dados acadêmicos anonimizados para identificar cedo os fatores de risco de evasão no curso.',
		'content'   => 'O projeto investiga como dados acadêmicos anonimizados (frequência, desempenho por disciplina e trancamentos) podem indicar cedo o risco de evasão. A proposta é construir painéis e modelos simples que ajudem a coordenação a planejar ações de apoio aos alunos.',
		'tipo'      => 'pesquisa',
		'situacao'  => 'andamento',
		'area'      => 'Ciência de dados',
		'inicio'    => 2025,
		'fim'       => 0,
		'vagas'     => true,
		'participar' => 'Interesse em análise de dados e Python. Procure o professor responsável com seu histórico.',
	),
	array(
		'title'     => 'Acessibilidade digital em portais públicos',
		'excerpt'   => 'Avaliação de sites públicos segundo o eMAG e as WCAG, com propostas de melhoria.',
		'content'   => 'Avaliação da acessibilidade de portais públicos com base no Modelo de Acessibilidade em Governo Eletrônico (eMAG) e nas diretrizes WCAG. O projeto combina testes automáticos, inspeção manual e testes com leitores de tela, e produz recomendações práticas de correção.',
		'tipo'      => 'pesquisa',
		'situacao'  => 'andamento',
		'area'      => 'Interação humano-computador',
		'inicio'    => 2026,
		'fim'       => 0,
		'vagas'     => true,
		'participar' => 'Ter cursado ou estar cursando Programação Web. Não é preciso experiência prévia com acessibilidade.',
	),
	array(
		'title'     => 'Métodos ágeis em equipes acadêmicas de desenvolvimento',
		'excerpt'   => 'Estudo sobre a adaptação de práticas ágeis a equipes de alunos com dedicação parcial.',
		'content'   => 'Estudo de caso sobre a adaptação de práticas ágeis (Scrum e Kanban) a equipes formadas por alunos com dedicação parcial. Foram analisados ritmo de entrega, comunicação e qualidade do código ao longo de dois semestres.',
		'tipo'      => 'pesquisa',
		'situacao'  => 'concluido',
		'area'      => 'Engenharia de software',
		'inicio'    => 2023,
		'fim'       => 2024,
		'vagas'     => false,
		'participar' => '',
	),
	array(
		'title'     => 'Inclusão digital para a comunidade',
		'excerpt'   => 'Oficinas de uso seguro da internet e de serviços digitais para moradores do entorno do campus.',
		'content'   => 'Oficinas abertas à comunidade do entorno do campus sobre uso seguro da internet, acesso a serviços públicos digitais e proteção contra golpes. Os alunos do curso atuam como monitores e preparam o material didático.',
		'tipo'      => 'extensao',
		'situacao'  => 'andamento',
		'area'      => 'Inclusão digital',
		'inicio'    => 2025,
		'fim'       => 0,
		'vagas'     => true,
		'participar' => 'Disponibilidade aos sábados pela manhã, em datas combinadas a cada semestre.',
	),
	array(
		'title'     => 'Oficinas de programação para o ensino médio',
		'excerpt'   => 'Introdução à lógica de programação para estudantes de escolas públicas da região.',
		'content'   => 'Oficinas de introdução à lógica de programação para estudantes de escolas públicas da região, com atividades práticas e projetos curtos. O objetivo é aproximar os estudantes da área de tecnologia e divulgar o curso.',
		'tipo'      => 'extensao',
		'situacao'  => 'andamento',
		'area'      => 'Educação em computação',
		'inicio'    => 2026,
		'fim'       => 0,
		'vagas'     => true,
		'participar' => 'Ter cursado Algoritmos e Lógica de Programação.',
	),
);
