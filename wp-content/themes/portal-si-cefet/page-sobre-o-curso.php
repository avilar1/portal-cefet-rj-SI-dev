<?php
/**
 * Sobre o Curso — RF02 (layout_sobre_o_curso_mvp.md).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--sobre" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'entry entry--page entry--sobre' ); ?>>
			<?php
			get_template_part(
				'template-parts/sobre/hero',
				null,
				array( 'intro' => portal_si_sobre_intro() )
			);
			get_template_part( 'template-parts/sobre/stats' );
			?>
			<div class="portal-sobre-body">
				<?php portal_si_sobre_the_content(); ?>
			</div>
			<?php get_template_part( 'template-parts/sobre/footer-cta' ); ?>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
