<?php
/**
 * Hub Institucional — layout_hub_institucional_mvp.md
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--institucional-hub" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'entry entry--page entry--institucional-hub' ); ?>>
			<?php
			if ( portal_si_institucional_has_zone( 'a' ) ) {
				get_template_part(
					'template-parts/institucional/zona',
					'a',
					array( 'intro' => portal_si_institucional_intro() )
				);
			}
			?>
		</article>
		<?php
	endwhile;
	wp_reset_postdata();

	if ( portal_si_institucional_has_zone( 'b' ) ) {
		get_template_part( 'template-parts/institucional/zona', 'b' );
	}

	if ( portal_si_institucional_has_zone( 'c' ) ) {
		get_template_part( 'template-parts/institucional/zona', 'c' );
	}
	?>
</main>
<?php
get_footer();
