<?php
/**
 * TCCs de exemplo (RF25) — importados uma vez, publicados com o selo "Exemplo".
 *
 * Nomes e trabalhos fictícios; devem ser substituídos pelos TCCs reais no painel.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	array(
		'title'    => 'Portal acessível para cursos de graduação: um estudo de caso com WordPress',
		'resumo'   => 'Este trabalho apresenta o desenvolvimento de um portal institucional para um curso de graduação, com foco em acessibilidade (eMAG e WCAG 2.1) e facilidade de manutenção por editores sem formação técnica. São discutidas as escolhas de arquitetura, os testes com leitores de tela e os resultados da avaliação com usuários.',
		'autores'  => array( 'Autor(a) de exemplo 1' ),
		'ano'      => 2025,
		'semestre' => 2,
		'palavras' => 'acessibilidade, WordPress, portal institucional',
	),
	array(
		'title'    => 'Previsão de evasão no ensino superior com aprendizado de máquina',
		'resumo'   => 'Comparação entre modelos de classificação (regressão logística, árvores de decisão e random forest) para prever o risco de evasão a partir de dados acadêmicos anonimizados. O trabalho discute também os cuidados éticos e de privacidade no uso desses dados.',
		'autores'  => array( 'Autor(a) de exemplo 2', 'Autor(a) de exemplo 3' ),
		'ano'      => 2025,
		'semestre' => 1,
		'palavras' => 'aprendizado de máquina, evasão, ciência de dados',
	),
	array(
		'title'    => 'Aplicação móvel para gestão de filas em serviços públicos',
		'resumo'   => 'Desenvolvimento de um aplicativo móvel que permite ao cidadão acompanhar filas de atendimento em tempo real. O trabalho descreve o levantamento de requisitos, a arquitetura com API REST e os testes de usabilidade realizados.',
		'autores'  => array( 'Autor(a) de exemplo 4' ),
		'ano'      => 2024,
		'semestre' => 2,
		'palavras' => 'aplicativo móvel, API REST, usabilidade',
	),
	array(
		'title'    => 'Adoção de práticas DevOps em pequenas equipes de desenvolvimento',
		'resumo'   => 'Estudo exploratório sobre a adoção de integração e entrega contínuas em equipes com até cinco desenvolvedores, com base em entrevistas e na análise de repositórios. São apresentados os principais obstáculos e um roteiro de adoção gradual.',
		'autores'  => array( 'Autor(a) de exemplo 5' ),
		'ano'      => 2024,
		'semestre' => 1,
		'palavras' => 'DevOps, integração contínua, engenharia de software',
	),
);
