<?php
/**
 * Corpo Docente — RF08.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$professores = portal_si_get_professores();

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--corpo-docente" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-professor-header">
			<p class="portal-professor-header__badge"><?php esc_html_e( 'Pesquisa e extensão', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_corpo_docente_intro();
			if ( $intro ) :
				?>
				<p class="portal-page-header__intro"><?php echo esc_html( $intro ); ?></p>
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

	<section class="portal-section portal-professor-grid-section" aria-labelledby="corpo-docente-grid-heading">
		<h2 id="corpo-docente-grid-heading" class="screen-reader-text"><?php esc_html_e( 'Lista de professores', 'portal-si-cefet' ); ?></h2>

		<?php if ( ! empty( $professores ) ) : ?>
			<div class="professor-grid">
				<?php foreach ( $professores as $professor ) : ?>
					<?php get_template_part( 'template-parts/professor/card', null, array( 'professor' => $professor ) ); ?>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="portal-empty-state portal-professor-empty">
				<p><?php esc_html_e( 'Os perfis dos professores estão sendo organizados e em breve aparecerão aqui.', 'portal-si-cefet' ); ?></p>
				<?php if ( current_user_can( 'edit_posts' ) ) : ?>
					<p>
						<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . PORTAL_SI_PROFESSOR_POST_TYPE ) ); ?>">
							<?php esc_html_e( 'Adicionar professor', 'portal-si-cefet' ); ?>
						</a>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</section>
</main>
<?php
get_footer();
