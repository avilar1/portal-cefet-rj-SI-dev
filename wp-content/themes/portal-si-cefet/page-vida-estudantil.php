<?php
/**
 * Vida estudantil — auxílios, bolsas e apoio ao estudante (RF07).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--vida" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-vida-header">
			<p class="portal-vida-header__badge"><?php esc_html_e( 'Assistência estudantil', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_vida_intro();
			if ( $intro ) :
				?>
				<p class="portal-page-header__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</header>

		<div class="portal-vida-body">
			<?php
			$alert = portal_si_vida_alert();
			if ( $alert ) :
				?>
				<div class="portal-vida-alert" role="note">
					<p><?php echo esc_html( $alert ); ?></p>
				</div>
			<?php endif; ?>

			<?php
			get_template_part( 'template-parts/vida/groups' );
			get_template_part( 'template-parts/vida/footer-cta' );
			?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
