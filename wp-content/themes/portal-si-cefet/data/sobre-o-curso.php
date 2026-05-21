<?php
/**
 * Dados estáticos — Sobre o Curso (Zona B: números; âncoras; intro fallback).
 * Editável no código/deploy — NÃO confundir com o corpo da página no WP.
 * Mapa WP vs código: docs/conteudo-wordpress-vs-codigo.md
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro_default' => 'O curso de Sistemas de Informação do CEFET/RJ forma profissionais para desenvolver, gerir e inovar em soluções de software. Conheça nossa trajetória, objetivos e equipe.',

	'stats'         => array(
		array( 'value' => '4 anos', 'label' => 'Duração do curso' ),
		array( 'value' => 'Gratuidade total', 'label' => 'Instituição federal' ),
		array( 'value' => 'Bacharelado', 'label' => 'Título conferido' ),
		array( 'value' => 'Campus Maria da Graça', 'label' => 'Rio de Janeiro — RJ' ),
	),

	'anchor_sections' => array(
		array(
			'id'    => 'historico',
			'label' => 'Histórico',
		),
		array(
			'id'    => 'objetivos',
			'label' => 'Objetivos',
		),
		array(
			'id'    => 'perfil-egresso',
			'label' => 'Perfil do egresso',
		),
		array(
			'id'    => 'coordenacao',
			'label' => 'Coordenação',
		),
	),
);
