<?php
/**
 * Infraestrutura — RF04 (Campus Maria da Graça / curso de SI).
 *
 * Textos editáveis no excerpt da página; estrutura e links em data/.
 * Fontes: site CEFET/RJ (biblioteca, campus) e PDI institucional (laboratórios).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro_default' => 'Laboratórios, biblioteca, espaços de estudo e recursos de apoio ao curso de Sistemas de Informação no campus Maria da Graça do CEFET/RJ — instituição federal gratuita, com fácil acesso pelo metrô.',

	'campus' => array(
		'name'    => 'CEFET/RJ — Campus Maria da Graça',
		'address' => 'Rua Miguel Ângelo, 96 — Maria da Graça, Rio de Janeiro/RJ',
		'cep'     => '20785-220',
		'access'  => 'Ao lado da estação de metrô Maria da Graça (Linha 2). Entrada principal na Rua Miguel Ângelo e acesso pela passarela do metrô.',
		'map'     => array(
			// oEmbed do WordPress (preferido) e link "Abrir no Google Maps".
			'place_url'    => 'https://www.google.com/maps/place/CEFET%2FRJ+-+Maria+da+Gra%C3%A7a/@-22.8815,-43.3187,17z',
			// Fallback: iframe sem API key (substitua pelo código "Incorporar mapa" do Google se quiser precisão máxima).
			'embed_url'    => 'https://maps.google.com/maps?q=Rua+Miguel+%C3%82ngelo,+96,+Maria+da+Gra%C3%A7a,+Rio+de+Janeiro+-+RJ,+20785-220&hl=pt-BR&z=16&output=embed',
			'iframe_title' => 'Mapa — CEFET/RJ Campus Maria da Graça',
		),
	),

	'highlights' => array(
		array(
			'value' => 'Metrô',
			'label' => 'Estação Maria da Graça ao lado do campus',
		),
		array(
			'value' => 'Biblioteca',
			'label' => 'UnED Maria da Graça — acervo em computação e engenharias',
		),
		array(
			'value' => 'Laboratórios',
			'label' => 'Práticas em informática, redes e software',
		),
		array(
			'value' => 'Gratuito',
			'label' => 'Instituição federal — estrutura compartilhada do campus',
		),
	),

	'sections' => array(
		array(
			'id'    => 'laboratorios',
			'title' => 'Laboratórios e salas de aula',
			'intro' => 'O curso de Sistemas de Informação utiliza os ambientes de informática e laboratórios temáticos do campus para aulas práticas, projetos integradores, pesquisa e extensão.',
			'items' => array(
				array(
					'title'       => 'Ambientes de informática',
					'description' => 'Salas equipadas para disciplinas de programação, banco de dados, engenharia de software e projetos do curso.',
					'bullets'     => array(
						'Estações para desenvolvimento e experimentação em equipe',
						'Uso orientado pelos professores em horário de aula e projetos',
						'Apoio à Fábrica de Software e trabalhos de conclusão de curso',
					),
				),
				array(
					'title'       => 'Laboratório de Redes',
					'description' => 'Espaço para práticas de redes de computadores e infraestrutura de comunicação, conforme a oferta do campus.',
					'bullets'     => array(
						'Atividades ligadas a disciplinas de redes e sistemas distribuídos',
						'Experimentação com equipamentos em ambiente controlado',
					),
				),
				array(
					'title'       => 'Laboratório de Software',
					'description' => 'Ambiente voltado ao desenvolvimento e testes de software, integrando formação técnica e projetos aplicados.',
					'bullets'     => array(
						'Prototipação e validação de soluções',
						'Integração com projetos de extensão e parcerias',
					),
				),
			),
		),
		array(
			'id'    => 'biblioteca',
			'title' => 'Biblioteca UnED Maria da Graça',
			'intro' => 'A biblioteca do campus apoia a formação em Sistemas de Informação com acervo em computação, engenharias e áreas afins, além de serviços de empréstimo e consulta ao acervo integrado do CEFET/RJ.',
			'items' => array(
				array(
					'title'       => 'Atendimento e acervo',
					'description' => 'Funcionamento em dias úteis, com salão de leitura e consulta ao catálogo on-line da rede de bibliotecas do CEFET/RJ.',
					'bullets'     => array(
						'Horário habitual: segunda a sexta, 8h às 17h (confirmar no site oficial)',
						'Empréstimo, renovação e reserva via biblioteca.cefet-rj.br',
						'Empréstimo entre bibliotecas da rede e bibliotecas conveniadas',
					),
					'link'        => array(
						'url'   => 'https://www.cefet-rj.br/index.php/biblioteca-campus-maria-da-graca',
						'label' => 'Página da biblioteca no CEFET/RJ',
					),
				),
			),
		),
		array(
			'id'    => 'convivencia',
			'title' => 'Espaços de convivência e apoio ao estudante',
			'intro' => 'Além das salas de aula, o campus oferece áreas para estudo individual, pausas entre aulas e serviços administrativos acadêmicos.',
			'items' => array(
				array(
					'title'       => 'Áreas comuns',
					'description' => 'Circulação entre blocos, espaços ao ar livre e pontos de encontro para atividades acadêmicas e eventos do curso.',
					'bullets'     => array(
						'Acesso facilitado para quem chega de ônibus ou metrô',
						'Ambiente compartilhado com outros cursos da unidade',
					),
				),
				array(
					'title'       => 'Serviços acadêmicos (SERAC-MG)',
					'description' => 'Secretaria e registros acadêmicos do campus para matrícula, documentos, diplomas e demais procedimentos de graduação.',
					'bullets'     => array(
						'Solicitações via sistema de chamados do CEFET/RJ (canal oficial)',
						'Formulários e orientações no portal da SERAC-MG',
					),
					'link'        => array(
						'url'   => 'https://app.cefet-rj.br/index.php/secao-registros-academicos',
						'label' => 'Seção de Registros Acadêmicos — campus MG',
					),
				),
			),
		),
		array(
			'id'    => 'recursos',
			'title' => 'Recursos de tecnologia e acessibilidade',
			'intro' => 'A infraestrutura do campus busca apoiar o ensino presencial com conectividade, equipamentos e melhorias de acessibilidade previstas no planejamento institucional.',
			'items' => array(
				array(
					'title'       => 'Conectividade e TI',
					'description' => 'Rede e serviços de tecnologia da informação institucionais para apoio às atividades acadêmicas.',
					'bullets'     => array(
						'Acesso à internet e sistemas do CEFET/RJ conforme políticas da instituição',
						'Suporte via canais oficiais de TI do Cefet',
					),
				),
				array(
					'title'       => 'Acessibilidade',
					'description' => 'O CEFET/RJ investe em adequações de acessibilidade nos campi, incluindo o campus Maria da Graça, conforme diagnósticos e obras do planejamento institucional (PDI).',
					'bullets'     => array(
						'Melhorias em circulação e apoio a pessoas com deficiência ou mobilidade reduzida',
						'Dúvidas específicas: canais oficiais do campus e da coordenação',
					),
				),
			),
		),
	),

	'official_links' => array(
		array(
			'title'       => 'Campus Maria da Graça — CEFET/RJ',
			'description' => 'Apresentação da unidade, cursos e informações gerais.',
			'url'         => 'https://www.cefet-rj.br/index.php/campus-maria-da-graca-historico',
		),
		array(
			'title'       => 'Biblioteca — campus Maria da Graça',
			'description' => 'Horários, serviços e acervo da biblioteca UnED.',
			'url'         => 'https://www.cefet-rj.br/index.php/biblioteca-campus-maria-da-graca',
		),
		array(
			'title'       => 'Catálogo da biblioteca (CEFET/RJ)',
			'description' => 'Consulta, empréstimo e reserva on-line.',
			'url'         => 'https://biblioteca.cefet-rj.br',
		),
	),

	'footer_cta' => array(
		'title' => 'Conheça o curso e a estrutura acadêmica',
		'text'  => 'Veja a grade curricular, formas de ingresso e a apresentação institucional do curso de Sistemas de Informação.',
	),
);
