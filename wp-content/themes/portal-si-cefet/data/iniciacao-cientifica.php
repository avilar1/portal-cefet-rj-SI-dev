<?php
/**
 * Iniciação científica (RF10) — conteúdo inicial; depois é editado no painel da página.
 *
 * Sem valores de bolsa nem datas: esses dados mudam a cada edital.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro'     => 'Na iniciação científica (IC), o aluno de graduação participa de um projeto de pesquisa orientado por um professor, com ou sem bolsa. É uma forma de aprofundar um tema de interesse, publicar os primeiros trabalhos e se preparar para a pós-graduação.',
	'criterios' => array(
		'Estar regularmente matriculado no curso de Sistemas de Informação.',
		'Ter um professor orientador com projeto de pesquisa ativo.',
		'Ter disponibilidade de horas semanais para o projeto, conforme o edital.',
		'Atender aos demais requisitos do edital vigente, como coeficiente de rendimento mínimo, quando exigido.',
	),
	'passos'    => array(
		'Conheça os projetos em andamento nesta página e os temas de pesquisa dos professores no Corpo Docente.',
		'Converse com o professor responsável pelo projeto e combine um plano de trabalho.',
		'Acompanhe o edital de iniciação científica do CEFET/RJ e faça a inscrição com o orientador dentro do prazo.',
		'Mantenha seu currículo Lattes atualizado: ele costuma ser exigido na inscrição.',
	),
	'links'     => array(
		array(
			'label' => 'Iniciação científica no CEFET/RJ (DEPES)',
			'url'   => 'https://www.cefet-rj.br/index.php/depes/223-depes/8782-iniciacao-cientifica',
		),
		array(
			'label' => 'Plataforma Lattes (currículo)',
			'url'   => 'https://lattes.cnpq.br/',
		),
	),
	'contato'   => 'Dúvidas sobre um projeto: fale com o professor responsável. Dúvidas gerais: procure a coordenação do curso.',
);
