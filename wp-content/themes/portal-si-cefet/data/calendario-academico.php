<?php
/**
 * Calendário acadêmico 2026 — Campus Maria da Graça (graduação / SI).
 *
 * Resumo legível derivado do PDF CONPUS (11/11/2025) e comunicado oficial de volta às aulas 2026.
 * Fonte de verdade para conferência: PDF no tema + página do CEFET/RJ.
 *
 * @see assets/documentos/calendario-academico-2026-campus-mg.pdf
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'year'              => 2026,
	'campus'            => 'Maria da Graça',
	'audience'          => 'Graduação',
	'pdf_filename'      => 'calendario-academico-2026-campus-mg.pdf',
	'pdf_label'         => 'Calendário Acadêmico 2026 — CONPUS (PDF unificado)',
	'source_updated'    => '2025-11-11',
	'official_page_url' => 'https://www.cefet-rj.br/index.php/calendarios-campus-maria-da-graca',

	'intro' => 'Datas do ano letivo de 2026 para cursos de graduação no campus Maria da Graça. O resumo abaixo facilita a consulta; para feriados, sábados não letivos e detalhes de cada semana, use o PDF oficial.',

	'year_overview' => array(
		array(
			'id'          => 'ferias-inicio',
			'label'       => 'Recesso de início de ano',
			'period'      => '26/01/2026 a 18/02/2026',
			'detail'      => '24 dias',
			'accent'      => 'neutral',
		),
		array(
			'id'          => 'semestre-1',
			'label'       => '1º semestre letivo',
			'period'      => '23/02/2026 a 03/07/2026',
			'detail'      => 'Aulas e atividades acadêmicas',
			'accent'      => 'primary',
		),
		array(
			'id'          => 'ferias-meio',
			'label'       => 'Recesso de meio de ano',
			'period'      => '13/07/2026 a 02/08/2026',
			'detail'      => '21 dias',
			'accent'      => 'neutral',
		),
		array(
			'id'          => 'semestre-2',
			'label'       => '2º semestre letivo',
			'period'      => '03/08/2026 a 12/12/2026',
			'detail'      => 'Aulas e atividades acadêmicas',
			'accent'      => 'primary',
		),
	),

	'semester_details' => array(
		array(
			'id'          => '2026-1',
			'title'       => '1º semestre (2026.1)',
			'period'      => '23/02/2026 a 03/07/2026',
			'milestones'  => array(
				array(
					'date'  => '23/02/2026',
					'label' => 'Início das aulas (1º semestre letivo)',
				),
				array(
					'date'  => '04/07 a 10/07/2026',
					'label' => 'Período facultativo (PF) — conforme calendário oficial',
				),
				array(
					'date'  => '03/07/2026',
					'label' => 'Término do 1º semestre letivo',
				),
			),
		),
		array(
			'id'          => '2026-2',
			'title'       => '2º semestre (2026.2)',
			'period'      => '03/08/2026 a 12/12/2026',
			'milestones'  => array(
				array(
					'date'  => '03/08/2026',
					'label' => 'Início das aulas (2º semestre letivo)',
				),
				array(
					'date'  => '12/12/2026',
					'label' => 'Término do 2º semestre letivo / ano letivo',
				),
			),
		),
	),

	'admin_deadlines' => array(
		'title'  => 'Prazos administrativos (graduação)',
		'note'   => 'Datas extraídas do calendário CONPUS. Em caso de dúvida, confirme no PDF ou na secretaria (SERAC).',
		'groups' => array(
			array(
				'title' => 'Renovação de matrícula — 2026.1',
				'items' => array(
					array( 'label' => '1ª fase', 'period' => '26/01 a 29/01' ),
					array( 'label' => '2ª fase', 'period' => '03/02 a 05/02' ),
					array( 'label' => '3ª fase', 'period' => '23/02 a 06/03' ),
				),
			),
			array(
				'title' => 'Renovação de matrícula — 2026.2',
				'items' => array(
					array( 'label' => '1ª fase', 'period' => '17/06 a 22/06' ),
					array( 'label' => '2ª fase', 'period' => '27/06 a 30/06' ),
					array( 'label' => '3ª fase', 'period' => '03/07 a 14/07' ),
				),
			),
			array(
				'title' => 'Outros prazos recorrentes',
				'items' => array(
					array( 'label' => 'Solicitação de isenção de disciplinas', 'period' => 'Consultar janelas no PDF (por semestre)' ),
					array( 'label' => 'Trancamento de matrícula', 'period' => 'Consultar janelas no PDF (por semestre)' ),
					array( 'label' => 'Destrancamento de matrícula', 'period' => 'Consultar janelas no PDF (por semestre)' ),
					array( 'label' => 'Colação de grau', 'period' => 'Datas no calendário oficial (várias ao longo do ano)' ),
				),
			),
		),
	),

	'disclaimer' => 'Este resumo não substitui o calendário oficial. O PDF unificado inclui também cursos EPTNM e detalhes de semanas letivas, feriados e atividades especiais.',

	'related' => array(
		array(
			'label' => 'Agenda e eventos do curso',
			'slug'  => 'agenda-e-eventos',
			'note'  => 'Palestras, reuniões e atividades divulgadas pela coordenação — não confundir com o calendário oficial da instituição.',
		),
	),
);
