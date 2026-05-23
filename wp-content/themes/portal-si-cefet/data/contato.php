<?php
/**
 * Contato — RF27, RF29.
 *
 * Dados alinhados à página oficial do curso no CEFET/RJ (campus Maria da Graça):
 * https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca
 *
 * Coordenação e horários editáveis na caixa da página Contato no wp-admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro_default' => 'Endereço, telefone, e-mail e horários da coordenação do curso de Sistemas de Informação no campus Maria da Graça. Para parcerias com a Fábrica de Software, use a seção dedicada abaixo.',

	'coordination' => array(
		'title' => 'Coordenação do curso',
		'intro' => 'Canal principal para dúvidas acadêmicas, documentos, grade e orientações sobre o curso de Bacharelado em Sistemas de Informação.',
		'people' => array(
			array(
				'name'  => 'Prof. Cristiano Fuschilo',
				'role'  => 'Coordenador do curso',
				'phone' => '(21) 3297-7905',
				'email' => 'coord.si@cefet-rj.br',
			),
			array(
				'name'  => '',
				'role'  => 'Vice-coordenador(a) do curso',
				'phone' => '',
				'email' => 'vicecoord.si@cefet-rj.br',
			),
		),
		'hours'  => 'Segunda a sexta, conforme disponibilidade da coordenação — confirme horário antes de ir ao campus.',
		'room'   => 'Coordenação do curso — Campus Maria da Graça (consulte a secretaria do campus para a sala atual).',
		'address' => 'Rua Miguel Ângelo, 96 — Maria da Graça, Rio de Janeiro/RJ — CEP 20785-220',
	),

	'channels' => array(
		'title' => 'Outros canais úteis',
		'items' => array(
			array(
				'label'       => 'Portal do aluno',
				'description' => 'Notas, horários e serviços acadêmicos',
				'url'         => 'https://alunos.cefet-rj.br/',
				'external'    => true,
			),
			array(
				'label'       => 'Secretaria acadêmica — campus',
				'description' => 'Registros, documentos e matrícula',
				'url'         => 'https://app.cefet-rj.br/index.php/secao-registros-academicos',
				'external'    => true,
			),
			array(
				'label'       => 'Site institucional CEFET/RJ',
				'description' => 'Informações gerais da instituição',
				'url'         => 'https://www.cefet-rj.br/',
				'external'    => true,
			),
			array(
				'label'       => 'Página oficial do curso (legado)',
				'description' => 'Referência institucional no portal CEFET/RJ',
				'url'         => 'https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca',
				'external'    => true,
			),
		),
	),

	'ouvidoria' => array(
		'title' => 'Ouvidoria e manifestações',
		'text'  => 'Para reclamações, sugestões ou solicitações formais à instituição, utilize a Ouvidoria do CEFET/RJ. Formulário integrado ao portal do curso previsto para versão futura (RF28).',
		'url'   => 'https://www.cefet-rj.br/index.php/ouvidoria',
		'label' => 'Acessar Ouvidoria CEFET/RJ',
	),

	'fabrica_partnership' => array(
		'anchor' => 'parceria-fabrica',
		'title'  => 'Parcerias — Fábrica de Software',
		'text'   => 'Empresas, ONGs e instituições interessadas em propor projetos gratuitos com alunos do curso devem entrar em contato pela Fábrica de Software. Projetos são acadêmicos, com termo de parceria formal.',
		'fabrica_slug' => 'fabrica-de-software',
	),
);
