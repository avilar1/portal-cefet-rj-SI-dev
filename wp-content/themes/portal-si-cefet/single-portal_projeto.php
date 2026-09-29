<?php
/**
 * Projeto de pesquisa/extensão individual (RF09).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--singular site-main--projeto" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		$projeto = portal_si_projeto_to_array( get_the_ID() );
		if ( ! $projeto ) {
			continue;
		}
		?>
		<article <?php post_class( 'entry entry--projeto' ); ?>>
			<header class="portal-page-header portal-pesquisa-header">
				<p class="portal-projeto-card__tags">
					<span class="portal-projeto-tag portal-projeto-tag--<?php echo esc_attr( $projeto['tipo'] ); ?>"><?php echo esc_html( $projeto['tipo_label'] ); ?></span>
					<span class="portal-projeto-tag portal-projeto-tag--<?php echo esc_attr( $projeto['situacao'] ); ?>"><?php echo esc_html( $projeto['situacao_label'] ); ?></span>
					<?php if ( $projeto['exemplo'] ) : ?>
						<span class="portal-projeto-tag portal-projeto-tag--exemplo"><?php esc_html_e( 'Exemplo', 'portal-si-cefet' ); ?></span>
					<?php endif; ?>
				</p>
				<h1 class="portal-page-header__title entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="portal-pesquisa-body portal-projeto-single">
				<?php if ( $projeto['exemplo'] ) : ?>
					<p class="portal-projeto-exemplo-note" role="note">
						<?php esc_html_e( 'Este é um projeto ilustrativo, que será substituído pelos projetos reais do curso.', 'portal-si-cefet' ); ?>
					</p>
				<?php endif; ?>

				<div class="portal-projeto-single__layout">
					<div class="entry-content portal-projeto-single__content">
						<?php the_content(); ?>

						<?php if ( $projeto['vagas'] && 'andamento' === $projeto['situacao'] ) : ?>
							<section class="portal-projeto-single__participar" aria-labelledby="projeto-participar-title">
								<h2 id="projeto-participar-title"><?php esc_html_e( 'Este projeto aceita alunos', 'portal-si-cefet' ); ?></h2>
								<?php if ( $projeto['participar'] ) : ?>
									<p><?php echo esc_html( $projeto['participar'] ); ?></p>
								<?php endif; ?>
								<p>
									<?php esc_html_e( 'Converse com o professor responsável e confira as regras da iniciação científica.', 'portal-si-cefet' ); ?>
									<a href="<?php echo esc_url( portal_si_page_url( 'iniciacao-cientifica' ) ); ?>"><?php esc_html_e( 'Como funciona a iniciação científica', 'portal-si-cefet' ); ?></a>
								</p>
							</section>
						<?php endif; ?>
					</div>

					<aside class="portal-projeto-single__aside" aria-label="<?php esc_attr_e( 'Dados do projeto', 'portal-si-cefet' ); ?>">
						<dl class="portal-projeto-single__meta">
							<?php if ( $projeto['responsavel'] ) : ?>
								<dt><?php esc_html_e( 'Responsável', 'portal-si-cefet' ); ?></dt>
								<dd>
									<?php if ( $projeto['responsavel_url'] ) : ?>
										<a href="<?php echo esc_url( $projeto['responsavel_url'] ); ?>"><?php echo esc_html( $projeto['responsavel'] ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $projeto['responsavel'] ); ?>
									<?php endif; ?>
								</dd>
							<?php endif; ?>
							<?php if ( $projeto['area'] ) : ?>
								<dt><?php esc_html_e( 'Área', 'portal-si-cefet' ); ?></dt>
								<dd><?php echo esc_html( $projeto['area'] ); ?></dd>
							<?php endif; ?>
							<?php if ( $projeto['periodo'] ) : ?>
								<dt><?php esc_html_e( 'Período', 'portal-si-cefet' ); ?></dt>
								<dd><?php echo esc_html( $projeto['periodo'] ); ?></dd>
							<?php endif; ?>
						</dl>
						<?php if ( $projeto['link'] ) : ?>
							<a class="portal-btn portal-btn--primary portal-projeto-single__link" href="<?php echo esc_url( $projeto['link'] ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Página do projeto', 'portal-si-cefet' ); ?>
								<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
							</a>
						<?php endif; ?>
					</aside>
				</div>

				<p class="portal-projeto-single__back">
					<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( PORTAL_SI_PROJETOS_SLUG ) ); ?>">
						<?php esc_html_e( '← Todos os projetos', 'portal-si-cefet' ); ?>
					</a>
				</p>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
