<?php
/**
 * Acessibilidade — recursos que o portal já oferece (H11).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contato = function_exists( 'portal_si_coordination_contato_url' )
	? portal_si_coordination_contato_url()
	: portal_si_page_url( 'contato' );

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--acessibilidade" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<header class="portal-page-header">
		<h1 class="portal-page-header__title"><?php esc_html_e( 'Acessibilidade', 'portal-si-cefet' ); ?></h1>
		<p class="portal-page-header__intro">
			<?php esc_html_e( 'Recursos deste portal para leitura e navegação. Eles funcionam no computador e no celular.', 'portal-si-cefet' ); ?>
		</p>
	</header>

	<ul class="portal-help-list">
		<li class="portal-help-item" id="ir-para-o-conteudo">
			<h2><?php esc_html_e( 'Ir direto ao conteúdo', 'portal-si-cefet' ); ?></h2>
			<p><?php esc_html_e( 'O primeiro link de cada página, “Ir para o conteúdo”, pula a faixa do governo e o menu. Ele aparece quando você navega pelo teclado (Tab).', 'portal-si-cefet' ); ?></p>
		</li>
		<li class="portal-help-item" id="alto-contraste">
			<h2><?php esc_html_e( 'Alto contraste', 'portal-si-cefet' ); ?></h2>
			<p><?php esc_html_e( 'O botão na faixa do topo aumenta o contraste das cores. A escolha fica gravada neste aparelho.', 'portal-si-cefet' ); ?></p>
			<p>
				<button type="button" class="portal-btn portal-btn--secondary" data-portal-contrast-toggle aria-pressed="false">
					<?php esc_html_e( 'Alto contraste', 'portal-si-cefet' ); ?>
				</button>
			</p>
		</li>
		<li class="portal-help-item" id="vlibras">
			<h2><?php esc_html_e( 'VLibras', 'portal-si-cefet' ); ?></h2>
			<p><?php esc_html_e( 'O VLibras traduz conteúdo digital para Libras. O link abre o site do governo federal em outra aba.', 'portal-si-cefet' ); ?></p>
			<p>
				<a href="https://www.vlibras.gov.br/" rel="noopener noreferrer" target="_blank">
					<?php esc_html_e( 'Abrir o VLibras', 'portal-si-cefet' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
				</a>
			</p>
		</li>
		<li class="portal-help-item" id="barreira">
			<h2><?php esc_html_e( 'Se algo impedir o uso', 'portal-si-cefet' ); ?></h2>
			<p><?php esc_html_e( 'Fale com a coordenação do curso e descreva a página e o que não funcionou. O contato também está no rodapé.', 'portal-si-cefet' ); ?></p>
			<p>
				<a href="<?php echo esc_url( $contato ); ?>"><?php esc_html_e( 'Falar com a coordenação', 'portal-si-cefet' ); ?></a>
			</p>
		</li>
	</ul>
	<?php
	while ( have_posts() ) :
		the_post();
		if ( function_exists( 'portal_si_post_has_meaningful_content' ) && portal_si_post_has_meaningful_content( get_post() ) ) :
			?>
			<div class="entry-content"><?php the_content(); ?></div>
			<?php
		endif;
	endwhile;
	?>
</main>
<?php
get_footer();
