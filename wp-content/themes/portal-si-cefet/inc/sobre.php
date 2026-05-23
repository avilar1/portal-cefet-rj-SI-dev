<?php
/**
 * Sobre o Curso — RF02 (layout_sobre_o_curso_mvp.md).
 *
 * Conteúdo editorial (textos, endereço, coordenação): WordPress — Páginas → Sobre o Curso.
 * Este ficheiro: seed inicial (uma vez), âncoras, enqueue — não é CMS após o seed.
 * Ver: docs/conteudo-wordpress-vs-codigo.md
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_SOBRE_SLUG', 'sobre-o-curso' );
define( 'PORTAL_SI_SOBRE_CONTENT_SEEDED_OPTION', 'portal_si_sobre_content_seeded_v1' );

/** Marcador HTML no conteúdo — insere a navegação por âncoras (Zona D). */
define( 'PORTAL_SI_SOBRE_NAV_MARKER', '<!-- portal-sobre-nav -->' );

/**
 * Configuração da página.
 *
 * @return array<string, mixed>
 */
function portal_si_sobre_config() {
	static $config = null;
	if ( null !== $config ) {
		return $config;
	}
	$path = get_template_directory() . '/data/sobre-o-curso.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = $loaded;
			return apply_filters( 'portal_si_sobre_config', $config );
		}
	}
	$config = array(
		'intro_default'   => '',
		'stats'           => array(),
		'anchor_sections' => array(),
	);
	return apply_filters( 'portal_si_sobre_config', $config );
}

/**
 * Intro — excerpt da página ou fallback.
 *
 * @return string
 */
function portal_si_sobre_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_SOBRE_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}
	$config = portal_si_sobre_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * Números institucionais (Zona B).
 *
 * @return array<int, array{value: string, label: string}>
 */
function portal_si_sobre_stats() {
	$config = portal_si_sobre_config();
	$stats  = isset( $config['stats'] ) && is_array( $config['stats'] ) ? $config['stats'] : array();
	$out    = array();
	foreach ( $stats as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$value = isset( $row['value'] ) ? trim( (string) $row['value'] ) : '';
		$label = isset( $row['label'] ) ? trim( (string) $row['label'] ) : '';
		if ( '' === $value && '' === $label ) {
			continue;
		}
		$out[] = array(
			'value' => $value,
			'label' => $label,
		);
	}
	return $out;
}

/**
 * Âncoras da navegação interna (Zona D).
 *
 * @return array<int, array{id: string, label: string}>
 */
function portal_si_sobre_anchor_sections() {
	$config = portal_si_sobre_config();
	$items  = isset( $config['anchor_sections'] ) && is_array( $config['anchor_sections'] ) ? $config['anchor_sections'] : array();
	$out    = array();
	foreach ( $items as $row ) {
		if ( ! is_array( $row ) || empty( $row['id'] ) ) {
			continue;
		}
		$out[] = array(
			'id'    => sanitize_title( $row['id'] ),
			'label' => isset( $row['label'] ) ? (string) $row['label'] : '',
		);
	}
	return $out;
}

/**
 * Conteúdo inicial Gutenberg/HTML (seed editorial).
 *
 * @return string
 */
function portal_si_sobre_default_post_content() {
	$img = esc_url( get_template_directory_uri() . '/assets/images/mariadagraca.jpg' );
	$ppc = esc_url( portal_si_page_url( 'documentos-institucionais' ) );

	ob_start();
	?>
	<section id="apresentacao" class="portal-sobre-carta">
		<h2 class="portal-sobre-section__title portal-sobre-section__title--plain"><?php esc_html_e( 'Bem-vindo ao curso de Sistemas de Informação', 'portal-si-cefet' ); ?></h2>
		<div class="portal-sobre-carta__grid">
			<div class="portal-sobre-carta__text">
				<p><?php esc_html_e( 'O Curso de Sistemas de Informação do CEFET/RJ foi criado para atender à crescente demanda por profissionais qualificados na área de tecnologia da informação. Nossa formação integra teoria e prática, preparando você para os desafios do mercado de trabalho.', 'portal-si-cefet' ); ?></p>
				<p><?php esc_html_e( 'Com infraestrutura moderna, corpo docente experiente e forte conexão com o setor produtivo, oferecemos um ambiente propício ao desenvolvimento acadêmico e profissional. A Fábrica de Software e os projetos de pesquisa e extensão complementam a formação em sala de aula.', 'portal-si-cefet' ); ?></p>
				<p><?php esc_html_e( 'Convidamos você a conhecer nossa história, objetivos e equipe nesta página — e a explorar o portal para descobrir tudo o que o curso pode oferecer.', 'portal-si-cefet' ); ?></p>
				<p class="portal-sobre-carta__sign"><?php esc_html_e( 'Coordenação do curso de Sistemas de Informação', 'portal-si-cefet' ); ?></p>
			</div>
			<figure class="portal-sobre-carta__media">
				<img src="<?php echo esc_url( $img ); ?>" alt="<?php esc_attr_e( 'Estudantes no ambiente acadêmico do CEFET/RJ', 'portal-si-cefet' ); ?>" width="480" height="360" loading="lazy" />
			</figure>
		</div>
	</section>

	<?php echo PORTAL_SI_SOBRE_NAV_MARKER; ?>

	<section id="historico" class="portal-sobre-section">
		<h2 class="portal-sobre-section__title"><?php esc_html_e( 'Histórico', 'portal-si-cefet' ); ?></h2>
		<p><?php esc_html_e( 'O curso de Sistemas de Informação do CEFET/RJ foi criado em resposta à demanda crescente por profissionais qualificados na área de tecnologia da informação. Desde sua fundação, o curso tem se destacado pela excelência acadêmica e pela formação de profissionais altamente capacitados.', 'portal-si-cefet' ); ?></p>
		<aside class="portal-sobre-highlight">
			<h3 class="portal-sobre-highlight__title"><?php esc_html_e( 'Marcos importantes', 'portal-si-cefet' ); ?></h3>
			<ul class="portal-sobre-timeline">
				<li><span class="portal-sobre-timeline__year">2005</span> <?php esc_html_e( 'Criação do curso de Sistemas de Informação no CEFET/RJ', 'portal-si-cefet' ); ?></li>
				<li><span class="portal-sobre-timeline__year">2009</span> <?php esc_html_e( 'Primeira turma de egressos formados', 'portal-si-cefet' ); ?></li>
				<li><span class="portal-sobre-timeline__year">2015</span> <?php esc_html_e( 'Reconhecimento do curso com nota máxima no MEC', 'portal-si-cefet' ); ?></li>
				<li><span class="portal-sobre-timeline__year">2020</span> <?php esc_html_e( 'Modernização do projeto pedagógico e infraestrutura', 'portal-si-cefet' ); ?></li>
			</ul>
		</aside>
	</section>

	<section id="objetivos" class="portal-sobre-section">
		<h2 class="portal-sobre-section__title"><?php esc_html_e( 'Objetivos do curso', 'portal-si-cefet' ); ?></h2>
		<p><?php esc_html_e( 'O curso de Sistemas de Informação tem como objetivo geral formar profissionais com sólida base teórica e prática em computação, capazes de desenvolver, gerenciar e inovar em soluções tecnológicas.', 'portal-si-cefet' ); ?></p>
		<h3 class="portal-sobre-section__subtitle"><?php esc_html_e( 'Competências desenvolvidas', 'portal-si-cefet' ); ?></h3>
		<div class="portal-sobre-comp-grid">
			<div class="portal-sobre-comp-card br-card">
				<div class="card-content">
					<span class="portal-sobre-comp-card__icon" aria-hidden="true"><?php portal_si_sobre_icon_graduation(); ?></span>
					<h4 class="portal-sobre-comp-card__title"><?php esc_html_e( 'Desenvolvimento de Software', 'portal-si-cefet' ); ?></h4>
					<p><?php esc_html_e( 'Projetar, desenvolver e testar sistemas utilizando metodologias ágeis e as principais tecnologias do mercado.', 'portal-si-cefet' ); ?></p>
				</div>
			</div>
			<div class="portal-sobre-comp-card br-card">
				<div class="card-content">
					<span class="portal-sobre-comp-card__icon" aria-hidden="true"><?php portal_si_sobre_icon_users(); ?></span>
					<h4 class="portal-sobre-comp-card__title"><?php esc_html_e( 'Gestão de Projetos', 'portal-si-cefet' ); ?></h4>
					<p><?php esc_html_e( 'Planejar, coordenar e gerenciar projetos de TI, aplicando boas práticas de gestão e governança.', 'portal-si-cefet' ); ?></p>
				</div>
			</div>
			<div class="portal-sobre-comp-card br-card">
				<div class="card-content">
					<span class="portal-sobre-comp-card__icon" aria-hidden="true"><?php portal_si_sobre_icon_document(); ?></span>
					<h4 class="portal-sobre-comp-card__title"><?php esc_html_e( 'Análise de Sistemas', 'portal-si-cefet' ); ?></h4>
					<p><?php esc_html_e( 'Modelar processos de negócio, levantar requisitos e propor soluções tecnológicas adequadas.', 'portal-si-cefet' ); ?></p>
				</div>
			</div>
			<div class="portal-sobre-comp-card br-card">
				<div class="card-content">
					<span class="portal-sobre-comp-card__icon" aria-hidden="true"><?php portal_si_sobre_icon_innovation(); ?></span>
					<h4 class="portal-sobre-comp-card__title"><?php esc_html_e( 'Inovação Tecnológica', 'portal-si-cefet' ); ?></h4>
					<p><?php esc_html_e( 'Identificar oportunidades de inovação e aplicar novas tecnologias para resolver problemas complexos.', 'portal-si-cefet' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section id="perfil-egresso" class="portal-sobre-section">
		<h2 class="portal-sobre-section__title"><?php esc_html_e( 'Perfil do egresso', 'portal-si-cefet' ); ?></h2>
		<div class="portal-sobre-notice">
			<p><strong><?php esc_html_e( 'Projeto Pedagógico do Curso (PPC):', 'portal-si-cefet' ); ?></strong>
			<?php
			printf(
				/* translators: %s: link to documents page */
				esc_html__( 'Para informações detalhadas sobre a estrutura curricular, ementas e metodologia, consulte o %s.', 'portal-si-cefet' ),
				'<a href="' . esc_url( $ppc ) . '">' . esc_html__( 'documento completo (PDF)', 'portal-si-cefet' ) . '</a>'
			);
			?>
			</p>
		</div>
		<p><?php esc_html_e( 'O egresso do curso de Sistemas de Informação do CEFET/RJ é um profissional versátil, preparado para atuar em diversos segmentos do mercado de TI, desde desenvolvimento de software até gestão de projetos e consultoria.', 'portal-si-cefet' ); ?></p>
		<h3 class="portal-sobre-section__subtitle"><?php esc_html_e( 'Áreas de atuação', 'portal-si-cefet' ); ?></h3>
		<div class="portal-sobre-areas-grid">
			<div class="portal-sobre-areas-card">
				<h4><?php esc_html_e( 'Desenvolvimento', 'portal-si-cefet' ); ?></h4>
				<ul>
					<li><?php esc_html_e( 'Desenvolvedor full-stack', 'portal-si-cefet' ); ?></li>
					<li><?php esc_html_e( 'Desenvolvedor mobile', 'portal-si-cefet' ); ?></li>
					<li><?php esc_html_e( 'Engenheiro de software', 'portal-si-cefet' ); ?></li>
				</ul>
			</div>
			<div class="portal-sobre-areas-card">
				<h4><?php esc_html_e( 'Gestão', 'portal-si-cefet' ); ?></h4>
				<ul>
					<li><?php esc_html_e( 'Gerente de projetos', 'portal-si-cefet' ); ?></li>
					<li><?php esc_html_e( 'Analista de negócios', 'portal-si-cefet' ); ?></li>
					<li><?php esc_html_e( 'Consultor de TI', 'portal-si-cefet' ); ?></li>
				</ul>
			</div>
			<div class="portal-sobre-areas-card">
				<h4><?php esc_html_e( 'Especialidades', 'portal-si-cefet' ); ?></h4>
				<ul>
					<li><?php esc_html_e( 'Cientista de dados', 'portal-si-cefet' ); ?></li>
					<li><?php esc_html_e( 'Arquiteto de sistemas', 'portal-si-cefet' ); ?></li>
					<li><?php esc_html_e( 'Especialista em segurança', 'portal-si-cefet' ); ?></li>
				</ul>
			</div>
		</div>
		<p><?php esc_html_e( 'Nossos egressos estão inseridos em empresas de diversos portes e segmentos, desde startups inovadoras até grandes corporações multinacionais. Muitos também seguem carreira acadêmica, ingressando em programas de mestrado e doutorado.', 'portal-si-cefet' ); ?></p>
	</section>

	<section id="coordenacao" class="portal-sobre-section">
		<h2 class="portal-sobre-section__title"><?php esc_html_e( 'Coordenação e direção', 'portal-si-cefet' ); ?></h2>
		<p><?php esc_html_e( 'O curso conta com uma equipe dedicada de professores e coordenadores comprometidos com a excelência do ensino e o desenvolvimento dos alunos.', 'portal-si-cefet' ); ?></p>
		<div class="portal-sobre-person-grid">
			<div class="portal-sobre-person-card br-card">
				<div class="card-content portal-sobre-person-card__inner">
					<span class="portal-sobre-person-card__avatar" aria-hidden="true"><?php portal_si_sobre_icon_person(); ?></span>
					<div class="portal-sobre-person-card__body">
						<h3 class="portal-sobre-person-card__name"><?php esc_html_e( 'Prof. Cristiano Fuschilo', 'portal-si-cefet' ); ?></h3>
						<p class="portal-sobre-person-card__role"><?php esc_html_e( 'Coordenador do curso', 'portal-si-cefet' ); ?></p>
						<p class="portal-sobre-person-card__contact"><span aria-hidden="true">✉</span> <a href="mailto:coord.si@cefet-rj.br">coord.si@cefet-rj.br</a></p>
						<p class="portal-sobre-person-card__contact"><span aria-hidden="true">☎</span> <a href="tel:+552132977905">(21) 3297-7905</a></p>
					</div>
				</div>
			</div>
			<div class="portal-sobre-person-card br-card">
				<div class="card-content portal-sobre-person-card__inner">
					<span class="portal-sobre-person-card__avatar" aria-hidden="true"><?php portal_si_sobre_icon_person(); ?></span>
					<div class="portal-sobre-person-card__body">
						<h3 class="portal-sobre-person-card__name"><?php esc_html_e( 'Vice-coordenador(a) do curso', 'portal-si-cefet' ); ?></h3>
						<p class="portal-sobre-person-card__contact portal-sobre-person-card__contact--muted"><?php esc_html_e( 'Nome e telefone em atualização.', 'portal-si-cefet' ); ?></p>
						<p class="portal-sobre-person-card__contact"><span aria-hidden="true">✉</span> <a href="mailto:vicecoord.si@cefet-rj.br">vicecoord.si@cefet-rj.br</a></p>
					</div>
				</div>
			</div>
		</div>
		<aside class="portal-sobre-office">
			<h3 class="portal-sobre-office__title"><?php esc_html_e( 'Horário de atendimento', 'portal-si-cefet' ); ?></h3>
			<p><strong><?php esc_html_e( 'Segunda a sexta:', 'portal-si-cefet' ); ?></strong> <?php esc_html_e( '9h às 12h e 14h às 17h', 'portal-si-cefet' ); ?></p>
			<p><strong><?php esc_html_e( 'Local:', 'portal-si-cefet' ); ?></strong> <?php esc_html_e( 'Sala 201, Bloco A — Campus Maria da Graça', 'portal-si-cefet' ); ?></p>
			<p><strong><?php esc_html_e( 'Endereço:', 'portal-si-cefet' ); ?></strong> <?php esc_html_e( 'Rua Miguel Ângelo, 96 — Rio de Janeiro, RJ', 'portal-si-cefet' ); ?></p>
		</aside>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Ícones inline leves (competências / pessoas).
 */
function portal_si_sobre_icon_graduation() {
	echo '<svg width="24" height="24" viewBox="0 0 24 24" focusable="false"><path fill="currentColor" d="M12 3 1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>';
}

function portal_si_sobre_icon_users() {
	echo '<svg width="24" height="24" viewBox="0 0 24 24" focusable="false"><path fill="currentColor" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V20h14v-3.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V20h6v-3.5c0-2.33-4.67-3.5-7-3.5z"/></svg>';
}

function portal_si_sobre_icon_document() {
	echo '<svg width="24" height="24" viewBox="0 0 24 24" focusable="false"><path fill="currentColor" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2 5 5h-5V4z"/></svg>';
}

function portal_si_sobre_icon_innovation() {
	echo '<svg width="24" height="24" viewBox="0 0 24 24" focusable="false"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>';
}

function portal_si_sobre_icon_person() {
	echo '<svg width="40" height="40" viewBox="0 0 24 24" focusable="false"><path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5z"/></svg>';
}

/**
 * Garante página, excerpt e conteúdo seed.
 */
function portal_si_ensure_sobre_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_SOBRE_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page( __( 'Sobre o Curso', 'portal-si-cefet' ), PORTAL_SI_SOBRE_SLUG );
	}

	if ( ! $page_id ) {
		return;
	}

	$hub_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	if ( $hub_id && (int) get_post_field( 'post_parent', $page_id ) !== (int) $hub_id ) {
		wp_update_post(
			array(
				'ID'          => $page_id,
				'post_parent' => $hub_id,
			)
		);
	}

	$intro = portal_si_sobre_intro();
	if ( $intro ) {
		$page = get_post( $page_id );
		if ( $page && '' === trim( $page->post_excerpt ) ) {
			wp_update_post(
				array(
					'ID'           => $page_id,
					'post_excerpt' => $intro,
				)
			);
		}
	}

	if ( ! get_option( PORTAL_SI_SOBRE_CONTENT_SEEDED_OPTION ) ) {
		$page = get_post( $page_id );
		if ( $page && '' === trim( $page->post_content ) ) {
			wp_update_post(
				array(
					'ID'           => $page_id,
					'post_content' => portal_si_sobre_default_post_content(),
				)
			);
		}
		update_option( PORTAL_SI_SOBRE_CONTENT_SEEDED_OPTION, 1 );
	}
}
add_action( 'after_setup_theme', 'portal_si_ensure_sobre_page', 26 );

/**
 * CSS e JS da página Sobre.
 */
function portal_si_sobre_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_SOBRE_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-sobre',
		get_template_directory_uri() . '/assets/css/sobre.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);

	wp_enqueue_script(
		'portal-si-sobre',
		get_template_directory_uri() . '/assets/js/sobre.js',
		array(),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_sobre_enqueue_assets', 16 );

/**
 * Remove bloco legado de coordenação do HTML seedado (substituído por template dinâmico).
 *
 * @param string $html Conteúdo da página.
 * @return string
 */
function portal_si_sobre_strip_coordination_block( $html ) {
	return (string) preg_replace( '#<section id="coordenacao"[\s\S]*?</section>#', '', (string) $html );
}

/**
 * Aplica filtros de conteúdo sem wpautop (HTML já estruturado em seções).
 *
 * @param string $html Conteúdo bruto.
 * @return string
 */
function portal_si_sobre_render_content( $html ) {
	$html = trim( (string) $html );
	if ( '' === $html ) {
		return '';
	}

	remove_filter( 'the_content', 'wpautop', 10 );
	remove_filter( 'the_content', 'shortcode_unautop', 10 );

	$rendered = do_blocks( $html );
	$rendered = do_shortcode( $rendered );
	$rendered = wptexturize( $rendered );
	$rendered = convert_smilies( $rendered );
	$rendered = convert_chars( $rendered );
	if ( function_exists( 'wp_filter_content_tags' ) ) {
		$rendered = wp_filter_content_tags( $rendered );
	}

	add_filter( 'the_content', 'wpautop', 10 );
	add_filter( 'the_content', 'shortcode_unautop', 10 );

	// Limpa parágrafos órfãos (wpautop legado no conteúdo seedado).
	$rendered = preg_replace( '#(</(?:section|div|aside|figure|article|main|nav|header|footer|ul|ol|table|form)>\s*)<p>\s*$#', '$1', $rendered );
	$rendered = preg_replace( '#^\s*</p>\s*#', '', $rendered );
	$rendered = preg_replace( '#\s*<p>\s*</p>\s*$#', '', $rendered );

	return trim( $rendered );
}

/**
 * Imprime conteúdo com nav marker e coordenação dinâmica.
 */
function portal_si_sobre_the_content() {
	$post = get_post();
	if ( ! $post ) {
		return;
	}

	$raw = $post->post_content;
	if ( false === strpos( $raw, PORTAL_SI_SOBRE_NAV_MARKER ) ) {
		echo '<div class="portal-sobre-content__block">';
		echo portal_si_sobre_render_content( portal_si_sobre_strip_coordination_block( $raw ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
		get_template_part( 'template-parts/sobre/anchor-nav' );
		echo '<div class="portal-sobre-content__block portal-sobre-content__block--coord">';
		get_template_part( 'template-parts/sobre/coordination' );
		echo '</div>';
		return;
	}

	$parts = explode( PORTAL_SI_SOBRE_NAV_MARKER, $raw, 2 );
	printf(
		'<div class="portal-sobre-content__block portal-sobre-content__block--pre">%s</div>',
		portal_si_sobre_render_content( $parts[0] ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
	get_template_part( 'template-parts/sobre/anchor-nav' );
	printf(
		'<div class="portal-sobre-content__block portal-sobre-content__block--main">%s</div>',
		portal_si_sobre_render_content( portal_si_sobre_strip_coordination_block( $parts[1] ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
	echo '<div class="portal-sobre-content__block portal-sobre-content__block--coord">';
	get_template_part( 'template-parts/sobre/coordination' );
	echo '</div>';
}
