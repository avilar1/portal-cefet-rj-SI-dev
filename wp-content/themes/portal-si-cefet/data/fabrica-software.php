<?php
/**
 * Fábrica de Software — RF13 + portfólio RF14 (MVP).
 *
 * Textos estáveis em data/; resumo da página editável no wp-admin.
 * Portfólio: exemplos iniciais — substituir quando houver projetos reais documentados.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro_default' => 'Disciplina-extensionista do curso de Sistemas de Informação: alunos desenvolvem soluções de software gratuitas para parceiros externos (empresas, ONGs, instituições), com orientação docente e termo de parceria formal.',

	'highlights' => array(
		array(
			'value' => '100%',
			'label' => 'Projetos gratuitos para o parceiro',
		),
		array(
			'value' => 'Termo',
			'label' => 'Parceria formal assinada antes do início',
		),
		array(
			'value' => 'Real',
			'label' => 'Demandas reais com entregas concretas',
		),
		array(
			'value' => 'Acadêmico',
			'label' => 'Nível formativo — expectativa alinhada desde o início',
		),
	),

	'mission' => array(
		'title' => 'Missão',
		'text'  => 'A Fábrica de Software é a disciplina em que o curso de Sistemas de Informação do CEFET/RJ conecta formação prática à comunidade: estudantes atuam como uma equipe de desenvolvimento orientada por professores, atendendo demandas de parceiros externos com o mesmo rigor de um projeto real — dentro de um contexto acadêmico, com cronograma vinculado ao semestre letivo e entregas progressivas.',
	),

	'methodology' => array(
		'title' => 'Como trabalhamos',
		'intro' => 'Metodologia inspirada em práticas ágeis e em fábricas de software acadêmicas: entendimento da necessidade, proposta de escopo, desenvolvimento iterativo e entrega com documentação básica.',
		'steps' => array(
			array(
				'number' => '1',
				'title'  => 'Contato e enquadramento',
				'text'   => 'O parceiro descreve a demanda. A coordenação avalia viabilidade, encaixe no semestre e alinhamento com a formação em SI.',
			),
			array(
				'number' => '2',
				'title'  => 'Termo de parceria',
				'text'   => 'Com interesse mútuo, assina-se o termo que define escopo, gratuidade, propriedade intelectual, confidencialidade e expectativas de nível acadêmico.',
			),
			array(
				'number' => '3',
				'title'  => 'Planejamento e equipe',
				'text'   => 'Professores orientam a definição de requisitos, arquitetura e sprint do semestre. Estudantes organizam-se em squads com papéis definidos.',
			),
			array(
				'number' => '4',
				'title'  => 'Desenvolvimento e entrega',
				'text'   => 'Ciclos de implementação, validação com o parceiro e entrega final (código, documentação e demonstração), conforme o acordado no termo.',
			),
		),
	),

	'project_types' => array(
		'title' => 'Tipos de projeto atendidos',
		'intro' => 'Priorizamos demandas com impacto social ou formativo e escopo compatível com um semestre. Exemplos de frentes já atendidas ou previstas:',
		'items' => array(
			array(
				'title'       => 'Sistemas web e portais',
				'description' => 'Cadastros, painéis administrativos, sites institucionais e ferramentas internas para pequenas organizações.',
			),
			array(
				'title'       => 'Aplicativos e automações',
				'description' => 'Protótipos mobile, integrações simples entre planilhas/sistemas e scripts que eliminam trabalho manual repetitivo.',
			),
			array(
				'title'       => 'Dados e relatórios',
				'description' => 'Organização de bases, dashboards básicos e visualizações para apoiar decisões de ONGs e pequenos negócios.',
			),
			array(
				'title'       => 'Extensão e inclusão digital',
				'description' => 'Projetos para comunidade escolar, associações de bairro e entidades sem fins lucrativos com baixo orçamento de TI.',
			),
		),
	),

	'team' => array(
		'title' => 'Equipe',
		'intro' => 'A Fábrica reúne docentes do curso de SI (coordenação e orientação) e estudantes matriculados na disciplina, em equipes multidisciplinares por projeto.',
		'roles' => array(
			array(
				'title' => 'Coordenação docente',
				'text'  => 'Define critérios de aceite, acompanha riscos, valida entregas e representa o curso perante o parceiro.',
			),
			array(
				'title' => 'Orientadores de projeto',
				'text'  => 'Professores da área de computação que acompanham squads em reuniões semanais e revisões técnicas.',
			),
			array(
				'title' => 'Estudantes desenvolvedores',
				'text'  => 'Análise, desenvolvimento, testes e documentação — em papéis rotativos (dev, QA, gestão leve) ao longo do semestre.',
			),
		),
	),

	'portfolio' => array(
		'title' => 'Projetos desenvolvidos',
		'intro' => 'Amostra de entregas da Fábrica. Os detalhes e a lista completa serão atualizados pela coordenação conforme novos semestres forem concluídos.',
		'items' => array(
			array(
				'name'        => 'Portal de gestão para ONG parceira',
				'description' => 'Sistema web para cadastro de beneficiários e relatórios mensais, reduzindo planilhas dispersas.',
				'technologies' => 'PHP, MySQL, Bootstrap',
				'students'    => 'Equipe de 5 alunos — turma 2024/2',
				'result'      => 'Entrega funcional com manual de uso e treinamento remoto de 2h.',
				'year'        => '2024',
			),
			array(
				'name'        => 'App de agendamento — comércio local',
				'description' => 'Protótipo mobile para reserva de horários em serviço de manutenção, com notificações básicas.',
				'technologies' => 'React Native, API REST em Node.js',
				'students'    => 'Equipe de 4 alunos — turma 2024/1',
				'result'      => 'MVP publicado em ambiente de testes; parceiro validou fluxo principal.',
				'year'        => '2024',
			),
			array(
				'name'        => 'Dashboard de indicadores — projeto extensionista',
				'description' => 'Painel para visualização de indicadores de extensão do próprio curso, alimentado por planilhas padronizadas.',
				'technologies' => 'Python, PostgreSQL, Chart.js',
				'students'    => 'Equipe de 6 alunos — turma 2023/2',
				'result'      => 'Relatórios exportáveis em PDF para prestação de contas interna.',
				'year'        => '2023',
			),
		),
	),

	'partnership' => array(
		'title' => 'Parceria responsável',
		'points' => array(
			'Todo projeto é **100% gratuito** para o parceiro — não há cobrança de desenvolvimento.',
			'A formalização ocorre por **termo de parceria** assinado antes do início dos trabalhos.',
			'O parceiro deve compreender que o produto é desenvolvido em **nível acadêmico**: prazos seguem o calendário do semestre e a disponibilidade da turma.',
			'Demandas precisam de **interlocutor disponível** para esclarecer requisitos e validar entregas em reuniões periódicas.',
			'Propriedade intelectual, confidencialidade e suporte pós-entrega são tratados no termo, conforme cada caso.',
		),
	),

	'partner_cta' => array(
		'title'       => 'Quer propor um projeto?',
		'text'        => 'Envie uma descrição da demanda, o perfil da organização e um contato para retorno. A coordenação avalia encaixe no próximo semestre e orienta os próximos passos — inclusive a assinatura do termo de parceria.',
		'button'      => 'Solicitar parceria',
		'contact_slug' => 'contato',
		'anchor'      => 'parceria-fabrica',
		'email'       => '', // Preencher no wp-admin ou em data/ quando a coordenação definir.
		'email_label' => 'E-mail da Fábrica de Software',
	),
);
