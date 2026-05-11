<?php
/**
 * Template principal — listagens e singular via mesma base.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="site-main" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php if ( is_home() && ! is_front_page() ) : ?>
		<?php
		$posts_page = (int) get_option( 'page_for_posts' );
		$archive_h1 = $posts_page ? get_the_title( $posts_page ) : __( 'Notícias', 'portal-si-cefet' );
		?>
		<h1 class="archive-title"><?php echo esc_html( $archive_h1 ); ?></h1>
	<?php endif; ?>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			if ( is_singular() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
				the_content();
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
				the_excerpt();
			}
		endwhile;
	else :
		?>
		<p><?php esc_html_e( 'Nada encontrado.', 'portal-si-cefet' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
