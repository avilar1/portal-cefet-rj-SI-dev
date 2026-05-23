<?php
/**
 * Documentos institucionais — RF06.
 *
 * Blocos fixos (links institucionais, calendário interno): este ficheiro.
 * Memorandos, normativos e PDFs enviados à comunidade: wp-admin → Páginas → Documentos Institucionais
 * (caixa «Publicações do curso»). Ver docs/edicao-documentos-institucionais.md
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro_default' => 'Projeto pedagógico, regulamentos, resoluções e arquivos oficiais do curso de Sistemas de Informação e do CEFET/RJ. Use os links abaixo para consulta ou download.',

	'notice' => 'Documentos do curso devem refletir a versão vigente aprovada pela coordenação e pelos órgãos colegiados. Em caso de divergência, prevalece o texto oficial publicado pelo CEFET/RJ.',

	'editorial_group' => array(
		'title' => 'Comunicados e publicações do curso',
		'intro' => 'Memorandos, normativos e arquivos publicados pela coordenação para a comunidade acadêmica. Ordenados do mais recente para o mais antigo.',
	),

	'groups' => array(
		array(
			'id'    => 'curso',
			'title' => 'Curso de Sistemas de Informação',
			'intro' => 'Documentos específicos da graduação no campus Maria da Graça.',
			'items' => array(
				array(
					'title'       => 'Projeto Pedagógico do Curso (PPC)',
					'description' => 'Documento completo com estrutura curricular, ementas e perfil do egresso.',
					'url'         => '',
					'meta'        => 'PDF',
					'coming_soon' => true,
				),
				array(
					'title'       => 'Calendário acadêmico 2026 (campus MG)',
					'description' => 'Resumo das datas letivas e link para o PDF oficial do CONPUS.',
					'url'         => '', // preenchido em inc/documentos.php
					'slug'        => 'calendario-academico',
					'internal'    => true,
					'meta'        => 'Página do portal',
				),
			),
		),
		array(
			'id'    => 'normas',
			'title' => 'Normas e regulamentos',
			'intro' => 'Regulamentos acadêmicos e regimentos aplicáveis aos estudantes de graduação.',
			'items' => array(
				array(
					'title'       => 'Regulamento dos cursos de graduação do CEFET/RJ',
					'description' => 'Normas gerais de funcionamento dos cursos de graduação da instituição.',
					'url'         => 'https://www.cefet-rj.br/index.php/documentos-institucionais',
					'external'    => true,
					'meta'        => 'CEFET/RJ',
				),
				array(
					'title'       => 'Regimento Geral do CEFET/RJ',
					'description' => 'Organização administrativa e acadêmica da instituição.',
					'url'         => 'https://www.cefet-rj.br/index.php/documentos-institucionais',
					'external'    => true,
					'meta'        => 'CEFET/RJ',
				),
			),
		),
		array(
			'id'    => 'transparencia',
			'title' => 'Transparência e documentos do CEFET/RJ',
			'intro' => 'Resoluções, portarias e demais publicações oficiais no portal da instituição.',
			'items' => array(
				array(
					'title'       => 'Documentos institucionais do CEFET/RJ',
					'description' => 'Índice central de documentos, resoluções e publicações oficiais.',
					'url'         => 'https://www.cefet-rj.br/index.php/documentos-institucionais',
					'external'    => true,
					'meta'        => 'Site institucional',
				),
				array(
					'title'       => 'Transparência e prestação de contas',
					'description' => 'Informações públicas conforme legislação de transparência.',
					'url'         => 'https://www.cefet-rj.br/index.php/acesso-a-informacao/transparencia-e-prestacao-de-contas',
					'external'    => true,
					'meta'        => 'CEFET/RJ',
				),
			),
		),
	),
);
