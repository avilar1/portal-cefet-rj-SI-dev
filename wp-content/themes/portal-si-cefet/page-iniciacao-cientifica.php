<?php
/**
 * Iniciação científica — critérios, como participar, editais e projetos com vagas (RF10).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ic       = portal_si_ic_content();
$alert    = portal_si_ic_alert();
$projetos = portal_si_get_projetos( array( 'vagas' => true ) );

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--ic" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-pesquisa-header">
			<p class="portal-pesquisa-header__badge"><?php esc_html_e( 'Pesquisa e Extensão', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php if ( $ic['intro'] ) : ?>
				<p class="portal-page-header__intro"><?php echo esc_html( $ic['intro'] ); ?></p>
			<?php endif; ?>
		</header>

		<div class="portal-pesquisa-body">
			<?php if ( $alert ) : ?>
				<div class="portal-pesquisa-alert" role="note">
					<p><?php echo esc_html( $alert ); ?></p>
				</div>
			<?php endif; ?>

			<div class="portal-ic-columns">
				<?php if ( $ic['criterios'] ) : ?>
					<section class="portal-ic-block" aria-labelledby="ic-criterios-title">
						<h2 id="ic-criterios-title" class="portal-pesquisa-section__title"><?php esc_html_e( 'Quem pode participar', 'portal-si-cefet' ); ?></h2>
						<ul class="portal-ic-list">
							<?php foreach ( $ic['criterios'] as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

				<?php if ( $ic['passos'] ) : ?>
					<section class="portal-ic-block" aria-labelledby="ic-passos-title">
						<h2 id="ic-passos-title" class="portal-pesquisa-section__title"><?php esc_html_e( 'Como participar', 'portal-si-cefet' ); ?></h2>
						<ol class="portal-ic-steps">
							<?php foreach ( $ic['passos'] as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ol>
					</section>
				<?php endif; ?>
			</div>

			<?php if ( $ic['links'] ) : ?>
				<section class="portal-ic-links" aria-labelledby="ic-links-title">
					<h2 id="ic-links-title" class="portal-pesquisa-section__title"><?php esc_html_e( 'Editais e links oficiais', 'portal-si-cefet' ); ?></h2>
					<ul class="portal-ic-links__list">
						<?php foreach ( $ic['links'] as $link ) : ?>
							<li>
								<a class="portal-ic-links__link" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html( $link['label'] ); ?>
									<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<section class="portal-pesquisa-section" aria-labelledby="ic-projetos-title">
				<header class="portal-section-header">
					<h2 id="ic-projetos-title" class="portal-pesquisa-section__title"><?php esc_html_e( 'Projetos que aceitam alunos', 'portal-si-cefet' ); ?></h2>
					<a class="portal-section-header__more" href="<?php echo esc_url( portal_si_page_url( PORTAL_SI_PROJETOS_SLUG ) ); ?>"><?php esc_html_e( 'Ver todos os projetos', 'portal-si-cefet' ); ?></a>
				</header>
				<?php
				get_template_part(
					'template-parts/projeto/grid',
					null,
					array(
						'items'             => $projetos,
						'heading'           => 'h3',
						'show_exemplo_note' => true,
						'empty_message'     => __( 'Nenhum projeto com vagas divulgado no momento. Converse com os professores sobre novos projetos.', 'portal-si-cefet' ),
					)
				);
				?>
			</section>

			<aside class="portal-pesquisa-cta">
				<h2 class="portal-pesquisa-cta__title"><?php esc_html_e( 'Ficou com dúvida?', 'portal-si-cefet' ); ?></h2>
				<?php if ( $ic['contato'] ) : ?>
					<p class="portal-pesquisa-cta__text"><?php echo esc_html( $ic['contato'] ); ?></p>
				<?php endif; ?>
				<div class="portal-pesquisa-cta__actions">
					<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( 'corpo-docente' ) ); ?>"><?php esc_html_e( 'Conhecer os professores', 'portal-si-cefet' ); ?></a>
					<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( portal_si_page_url( 'contato' ) ); ?>"><?php esc_html_e( 'Falar com a coordenação', 'portal-si-cefet' ); ?></a>
				</div>
			</aside>

			<p class="portal-pesquisa-reviewed">
				<?php
				printf(
					/* translators: %s: data. */
					esc_html__( 'Página revisada em %s.', 'portal-si-cefet' ),
					esc_html( get_the_modified_date() )
				);
				?>
			</p>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
