<?php
/**
 * Ingresso — SISU 2026 / curso de Sistemas de Informação (Campus Maria da Graça).
 *
 * Fonte oficial: página do CEFET/RJ do processo seletivo e Edital CCONC nº 01/2026.
 * Convocações e prazos mudam — a página do portal aponta sempre para o site institucional.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'intro_default' => 'Formas de ingresso no curso de Sistemas de Informação do CEFET/RJ — Campus Maria da Graça. O ingresso na graduação federal é pelo ENEM e pelo SISU; a matrícula, quando convocado, é feita online na plataforma do CEFET/RJ.',

	'edition' => array(
		'label' => 'SISU 2026 — edição única',
		'detail' => 'Uma única edição do SISU para preencher vagas do 1º e do 2º semestre de 2026 (2026.1 e 2026.2).',
	),

	'course' => array(
		'name'   => 'Sistemas de Informação',
		'campus' => 'Campus Maria da Graça',
		'city'   => 'Rio de Janeiro — RJ',
		'degree' => 'Bacharelado',
	),

	'highlights' => array(
		array(
			'value' => '60 vagas',
			'label' => 'Total no SISU 2026 (todas as modalidades de concorrência)',
		),
		array(
			'value' => 'Gratuito',
			'label' => 'Instituição federal — sem mensalidade',
		),
		array(
			'value' => '4 anos',
			'label' => 'Duração prevista do curso',
		),
		array(
			'value' => 'ENEM + SISU',
			'label' => 'Seleção unificada do MEC',
		),
	),

	'steps' => array(
		array(
			'title' => 'Faça o ENEM',
			'text'  => 'O ingresso nos cursos de graduação do CEFET/RJ utiliza a nota do Exame Nacional do Ensino Médio (ENEM) como etapa de seleção.',
		),
		array(
			'title' => 'Inscreva-se no SISU',
			'text'  => 'No período de inscrição do SISU, escolha o curso Sistemas de Informação no campus Maria da Graça (código de oferta no sistema do MEC).',
		),
		array(
			'title' => 'Acompanhe as chamadas',
			'text'  => 'Se classificado, siga as convocações publicadas pelo CEFET/RJ: heteroidentificação (se aplicável), lista de espera e períodos de matrícula por semestre.',
		),
		array(
			'title' => 'Matrícula online',
			'text'  => 'No prazo da sua convocação, acesse a plataforma de matrícula do CEFET/RJ, leia o manual orientador e envie a documentação solicitada.',
		),
	),

	'official_links' => array(
		array(
			'title'       => 'Avisos e convocações (CEFET/RJ)',
			'description' => 'Página oficial com chamadas, listas de candidatos, prazos de matrícula e comunicados atualizados.',
			'url'         => 'https://www.cefet-rj.br/index.php/alunos-graduacao/10049-processo-seletivo-para-os-cursos-de-graduacao-edicao-unica-do-sisu-2026-para-preenchimento-das-vagas-de-2026-1-e-2026-2',
			'primary'     => true,
		),
		array(
			'title'       => 'Plataforma de matrícula',
			'description' => 'Acesso exclusivo para candidatos convocados realizarem a matrícula online.',
			'url'         => 'https://processoseletivo.cefet-rj.br/candidato/entrar/',
			'primary'     => false,
		),
		array(
			'title'       => 'Manual de matrícula online',
			'description' => 'Leitura obrigatória antes do primeiro acesso à plataforma (POP — matrícula online).',
			'url'         => 'https://www.cefet-rj.br/attachments/article/10049/POP%20-%20Matr%C3%ADcula%20online%20-%20rev05.pdf',
			'primary'     => false,
		),
		array(
			'title'       => 'Edital CCONC nº 01/2026',
			'description' => 'Normas completas do processo seletivo, vagas por campus e documentação exigida.',
			'url'         => 'https://www.cefet-rj.br/attachments/article/10049/EDITAL_SISU_2026_vf_assinado.pdf',
			'primary'     => false,
		),
		array(
			'title'       => 'Portal SISU (gov.br)',
			'description' => 'Inscrições, resultados e informações do Ministério da Educação.',
			'url'         => 'https://www.gov.br/sisu',
			'primary'     => false,
		),
		array(
			'title'       => 'Portal ENEM (gov.br)',
			'description' => 'Informações sobre o exame e inscrições.',
			'url'         => 'https://www.gov.br/enem',
			'primary'     => false,
		),
	),

	'documents' => array(
		'intro' => 'Na matrícula online, o candidato convocado deve enviar cópias digitais dos documentos previstos no edital. A lista abaixo é um resumo — consulte sempre o edital e o manual oficial.',
		'items' => array(
			'Documento de identidade com foto (RG ou equivalente).',
			'CPF.',
			'Título de eleitor e comprovante da última eleição (maiores de 18 anos), ou certidão de quitação eleitoral.',
			'Certificado de reservista ou documento militar (homens maiores de 18 anos).',
			'Certificado de conclusão do ensino médio.',
			'Histórico escolar completo do ensino médio.',
			'Comprovante de ensino médio integral em escola pública (candidatos em vagas reservadas, quando aplicável).',
			'Foto recente (cabeça descoberta e ombros visíveis), em .png, .jpg ou .bmp, até 500 KB.',
		),
	),

	'notices' => array(
		array(
			'title' => 'Fonte oficial para prazos',
			'text'  => 'Convocações e datas de matrícula são publicadas na página do CEFET/RJ. Este portal do curso não substitui aquele canal.',
		),
		array(
			'title' => 'Campus e curso na inscrição',
			'text'  => 'O edital não prevê troca de campus após a escolha no SISU, ainda que o nome do curso seja o mesmo em outra unidade.',
		),
		array(
			'title' => 'Semestre da convocação',
			'text'  => 'Não é possível alterar o semestre (2026.1 ou 2026.2) para o qual o candidato foi convocado para matrícula.',
		),
		array(
			'title' => 'Dúvidas na matrícula',
			'text'  => 'Problemas com documentos ou com a plataforma devem ser encaminhados ao e-mail da secretaria do campus indicado no quadro de contatos da página oficial do processo seletivo.',
		),
	),

	'contacts' => array(
		'intro'   => 'Para o processo seletivo em geral (edital, recursos, impugnações):',
		'email'   => 'concursos@cefet-rj.br',
		'note'    => 'Após a matrícula, serviços acadêmicos do campus Maria da Graça são tratados pela SERAC e pelos canais institucionais do CEFET/RJ.',
	),

	'footer_cta' => array(
		'title' => 'Conheça o curso antes de escolher',
		'text'  => 'Veja a grade curricular, o calendário acadêmico e a apresentação institucional do curso de Sistemas de Informação.',
	),
);
