<?php
/**
 * Pesquisa e Extensão — hub (RF09–RF11 parcial).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--pesquisa" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header">
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="portal-page-header__intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php else : ?>
				<p class="portal-page-header__intro">
					<?php esc_html_e( 'Projetos de pesquisa, extensão e parcerias do curso de Sistemas de Informação. Algumas seções já estão disponíveis; outras estão em preparação.', 'portal-si-cefet' ); ?>
				</p>
			<?php endif; ?>
			<?php if ( get_the_content() ) : ?>
				<div class="portal-page-header__intro entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</header>
		<?php
	endwhile;
	wp_reset_postdata();
	?>

	<div class="portal-pesquisa-hub__grid">
		<section aria-labelledby="pesquisa-disponivel-title">
			<h2 id="pesquisa-disponivel-title" class="portal-pesquisa-hub__section-title">
				<?php esc_html_e( 'Já disponível', 'portal-si-cefet' ); ?>
			</h2>
			<ul class="portal-pesquisa-hub__links">
				<li>
					<a class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) . ' portal-pesquisa-hub__link-card' ); ?>" href="<?php echo esc_url( portal_si_page_url( 'corpo-docente' ) ); ?>">
						<span class="card-content">
							<span class="portal-pesquisa-hub__link-title"><?php esc_html_e( 'Corpo docente', 'portal-si-cefet' ); ?></span>
							<span class="portal-pesquisa-hub__link-desc"><?php esc_html_e( 'Professores, formação e linhas de atuação.', 'portal-si-cefet' ); ?></span>
						</span>
					</a>
				</li>
				<li>
					<a class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) . ' portal-pesquisa-hub__link-card' ); ?>" href="<?php echo esc_url( portal_si_page_url( 'fabrica-de-software' ) ); ?>">
						<span class="card-content">
							<span class="portal-pesquisa-hub__link-title"><?php esc_html_e( 'Fábrica de Software', 'portal-si-cefet' ); ?></span>
							<span class="portal-pesquisa-hub__link-desc"><?php esc_html_e( 'Projetos de extensão com parceiros externos.', 'portal-si-cefet' ); ?></span>
						</span>
					</a>
				</li>
			</ul>
		</section>

		<section aria-labelledby="pesquisa-projetos-title">
			<h2 id="pesquisa-projetos-title" class="portal-pesquisa-hub__section-title">
				<?php esc_html_e( 'Projetos de pesquisa', 'portal-si-cefet' ); ?>
			</h2>
			<?php
			portal_si_the_coming_soon_notice(
				array(
					'variant' => 'section',
					'badge'   => __( 'Em construção', 'portal-si-cefet' ),
					'message' => __( 'A listagem de projetos de pesquisa, grupos de estudo e iniciação científica será publicada em breve.', 'portal-si-cefet' ),
				)
			);
			?>
		</section>

		<section aria-labelledby="pesquisa-extensao-title">
			<h2 id="pesquisa-extensao-title" class="portal-pesquisa-hub__section-title">
				<?php esc_html_e( 'Projetos de extensão', 'portal-si-cefet' ); ?>
			</h2>
			<?php
			portal_si_the_coming_soon_notice(
				array(
					'variant' => 'section',
					'badge'   => __( 'Em construção', 'portal-si-cefet' ),
					'message' => __( 'Projetos de extensão além da Fábrica de Software serão divulgados nesta seção.', 'portal-si-cefet' ),
				)
			);
			?>
		</section>

		<section aria-labelledby="pesquisa-parcerias-title">
			<h2 id="pesquisa-parcerias-title" class="portal-pesquisa-hub__section-title">
				<?php esc_html_e( 'Parcerias e convênios', 'portal-si-cefet' ); ?>
			</h2>
			<?php
			portal_si_the_coming_soon_notice(
				array(
					'variant' => 'section',
					'badge'   => __( 'Conteúdo em breve', 'portal-si-cefet' ),
					'message' => __( 'Convênios institucionais e parcerias vigentes serão apresentados com descrição e logos das organizações.', 'portal-si-cefet' ),
				)
			);
			?>
		</section>
	</div>
</main>
<?php
get_footer();
