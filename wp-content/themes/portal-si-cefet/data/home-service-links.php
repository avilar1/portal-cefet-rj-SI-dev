<?php
/**
 * Home — Zona 5: links de acesso rápido (RF01 + RF22).
 *
 * RF22: serviços externos (Área do Aluno, Professor, Chamados).
 * Mantidos no portal: Grade Curricular e Calendário Acadêmico (páginas internas).
 * Extra: Estágio — Campus Maria da Graça (CEFET/RJ).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	array(
		'icon'        => 'clipboard',
		'title'       => 'Grade Curricular',
		'description' => 'Consultar disciplinas e ementas',
		'url'         => '', // preenchido em inc/home.php (permalink interno).
		'external'    => false,
		'slug'        => 'grade-curricular',
	),
	array(
		'icon'        => 'calendar',
		'title'       => 'Calendário Acadêmico',
		'description' => 'Datas importantes e eventos',
		'url'         => '',
		'external'    => false,
		'slug'        => 'calendario-academico',
	),
	array(
		'icon'        => 'graduation',
		'title'       => 'Área do Aluno',
		'description' => 'Portal acadêmico do CEFET/RJ',
		'url'         => 'https://alunos.cefet-rj.br/',
		'external'    => true,
	),
	array(
		'icon'        => 'teacher',
		'title'       => 'Área do Professor',
		'description' => 'Portal do corpo docente',
		'url'         => 'https://professor.cefet-rj.br/',
		'external'    => true,
	),
	array(
		'icon'        => 'ticket',
		'title'       => 'Abertura de Chamados',
		'description' => 'Central de suporte do CEFET/RJ',
		'url'         => 'https://chamados.cefet-rj.br/index.php',
		'external'    => true,
	),
	array(
		'icon'        => 'briefcase',
		'title'       => 'Estágio',
		'description' => 'Orientações e documentos — Campus MG',
		'url'         => 'https://www.cefet-rj.br/index.php/estagio-campus-maria-da-graca',
		'external'    => true,
	),
);
