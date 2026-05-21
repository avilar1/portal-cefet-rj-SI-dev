<?php
/**
 * Dados estáticos do hub institucional — editar neste arquivo (~1×/ano).
 *
 * Intro da Zona A: preferir o excerpt da página no WordPress; o valor abaixo é fallback.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	/** Zonas ativas: a, b, c, d, e */
	'zones'          => array( 'a', 'b', 'c' ),

	'intro_default'  => 'Conheça o Curso de Sistemas de Informação do CEFET/RJ — sua estrutura acadêmica, corpo docente, formas de ingresso e vida estudantil. Navegue pelas seções abaixo.',

	'zona_b'         => array(
		'heading' => 'Explore o Institucional',
		'cards'   => array(
			array(
				'icon'        => 'book',
				'title'       => 'Sobre o Curso',
				'description' => 'Histórico, objetivos e perfil do egresso',
				'slug'        => 'sobre-o-curso',
			),
			array(
				'icon'        => 'graduation',
				'title'       => 'Ingresso',
				'description' => 'SISU, ENEM, processo seletivo e matrícula',
				'slug'        => 'ingresso',
			),
			array(
				'icon'        => 'clipboard',
				'title'       => 'Grade Curricular',
				'description' => 'Disciplinas por semestre e fluxo de progressão',
				'slug'        => 'grade-curricular',
			),
			array(
				'icon'        => 'building',
				'title'       => 'Infraestrutura',
				'description' => 'Laboratórios, biblioteca e recursos do campus',
				'slug'        => 'infraestrutura',
			),
			array(
				'icon'        => 'teacher',
				'title'       => 'Corpo Docente',
				'description' => 'Professores, áreas de atuação e pesquisa',
				'slug'        => 'corpo-docente',
			),
			array(
				'icon'        => 'users',
				'title'       => 'Carreira e Egressos',
				'description' => 'Empregabilidade, depoimentos e trajetórias',
				'slug'        => 'carreira-e-egressos',
			),
			array(
				'icon'        => 'calendar',
				'title'       => 'Vida Estudantil',
				'description' => 'Bolsas, auxílios, benefícios e ferramentas',
				'slug'        => 'vida-estudantil',
			),
			array(
				'icon'        => 'document',
				'title'       => 'Documentos',
				'description' => 'PPC, regulamentos e arquivos oficiais',
				'slug'        => 'documentos-institucionais',
			),
		),
	),

	'zona_c'         => array(
		'title'      => 'Pronto para ingressar?',
		'text'       => 'O curso de Sistemas de Informação do CEFET/RJ é gratuito, com formação sólida em tecnologia e integração com projetos reais. Confira como ingressar e comece sua trajetória no campus Maria da Graça.',
		'cta_slug'   => 'ingresso',
		'cta_label'  => 'Como ingressar',
		'icon'       => 'graduation',
	),

	'zona_d'         => array(
		'stats' => array(
			array( 'value' => '4 anos', 'label' => 'Duração do curso' ),
			array( 'value' => 'Gratuidade total', 'label' => 'Sem mensalidades' ),
			array( 'value' => 'Alta empregabilidade', 'label' => 'Mercado aquecido' ),
			array( 'value' => 'Campus Maria da Graça', 'label' => 'Rio de Janeiro — RJ' ),
		),
	),
);
