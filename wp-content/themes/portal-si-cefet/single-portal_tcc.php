<?php
/**
 * TCC individual — dados, resumo e acesso ao trabalho (RF25).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--singular site-main--tcc" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		$tcc = portal_si_tcc_to_array( get_the_ID() );
		if ( ! $tcc ) {
			continue;
		}
		?>
		<article <?php post_class( 'entry entry--tcc' ); ?>>
			<header class="portal-page-header portal-tcc-header">
				<p class="portal-tcc-header__badge">
					<?php
					echo esc_html( $tcc['periodo'] ? sprintf( __( 'TCC · %s', 'portal-si-cefet' ), $tcc['periodo'] ) : __( 'TCC', 'portal-si-cefet' ) );
					?>
				</p>
				<h1 class="portal-page-header__title entry-title"><?php the_title(); ?></h1>
				<?php if ( $tcc['autores_text'] ) : ?>
					<p class="portal-tcc-single__autores"><?php echo esc_html( $tcc['autores_text'] ); ?></p>
				<?php endif; ?>
			</header>

			<div class="portal-tcc-body">
				<?php if ( $tcc['exemplo'] ) : ?>
					<p class="portal-tcc-exemplo-note" role="note">
						<?php esc_html_e( 'Este é um trabalho ilustrativo, que será substituído pelos TCCs reais do curso.', 'portal-si-cefet' ); ?>
					</p>
				<?php endif; ?>

				<div class="portal-tcc-single__layout">
					<div class="portal-tcc-single__content">
						<h2 class="portal-tcc-single__section-title"><?php esc_html_e( 'Resumo', 'portal-si-cefet' ); ?></h2>
						<div class="entry-content"><?php the_content(); ?></div>

						<?php if ( $tcc['palavras'] ) : ?>
							<h2 class="portal-tcc-single__section-title"><?php esc_html_e( 'Palavras-chave', 'portal-si-cefet' ); ?></h2>
							<ul class="portal-tcc-keywords">
								<?php foreach ( $tcc['palavras'] as $palavra ) : ?>
									<li>
										<a href="<?php echo esc_url( add_query_arg( 'busca', $palavra, portal_si_page_url( PORTAL_SI_TCCS_SLUG ) ) ); ?>"><?php echo esc_html( $palavra ); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>

					<aside class="portal-tcc-single__aside" aria-label="<?php esc_attr_e( 'Dados do trabalho', 'portal-si-cefet' ); ?>">
						<dl class="portal-tcc-single__meta">
							<?php if ( $tcc['orientador'] ) : ?>
								<dt><?php esc_html_e( 'Orientação', 'portal-si-cefet' ); ?></dt>
								<dd>
									<?php if ( $tcc['orientador_url'] ) : ?>
										<a href="<?php echo esc_url( $tcc['orientador_url'] ); ?>"><?php echo esc_html( $tcc['orientador'] ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $tcc['orientador'] ); ?>
									<?php endif; ?>
								</dd>
							<?php endif; ?>
							<?php if ( $tcc['coorientador'] ) : ?>
								<dt><?php esc_html_e( 'Coorientação', 'portal-si-cefet' ); ?></dt>
								<dd><?php echo esc_html( $tcc['coorientador'] ); ?></dd>
							<?php endif; ?>
							<?php if ( $tcc['periodo'] ) : ?>
								<dt><?php esc_html_e( 'Defesa', 'portal-si-cefet' ); ?></dt>
								<dd><?php echo esc_html( $tcc['periodo'] ); ?></dd>
							<?php endif; ?>
						</dl>

						<?php if ( $tcc['file_url'] || $tcc['link'] ) : ?>
							<div class="portal-tcc-single__actions">
								<?php if ( $tcc['file_url'] ) : ?>
									<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( $tcc['file_url'] ); ?>" target="_blank" rel="noopener noreferrer">
										<?php
										echo esc_html( $tcc['file_size'] ? sprintf( __( 'Baixar PDF (%s)', 'portal-si-cefet' ), $tcc['file_size'] ) : __( 'Baixar PDF', 'portal-si-cefet' ) );
										?>
										<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
									</a>
								<?php endif; ?>
								<?php if ( $tcc['link'] ) : ?>
									<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( $tcc['link'] ); ?>" target="_blank" rel="noopener noreferrer">
										<?php esc_html_e( 'Acessar no repositório', 'portal-si-cefet' ); ?>
										<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						<?php else : ?>
							<p class="portal-tcc-single__unavailable"><?php esc_html_e( 'O texto completo não está disponível on-line. Consulte a coordenação do curso.', 'portal-si-cefet' ); ?></p>
						<?php endif; ?>
					</aside>
				</div>

				<p class="portal-tcc-single__back">
					<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( PORTAL_SI_TCCS_SLUG ) ); ?>">
						<?php esc_html_e( '← Voltar ao repositório', 'portal-si-cefet' ); ?>
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
