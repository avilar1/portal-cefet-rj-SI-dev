<?php
/**
 * Artigo (post) — RF18 / RF19: conteúdo singular com metadados básicos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--singular" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'entry entry--post' ); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<p class="entry-meta">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<?php
					$cats = get_the_category();
					if ( ! empty( $cats ) ) {
						echo ' <span class="entry-meta__sep" aria-hidden="true">·</span> ';
						the_category( ', ' );
					}
					?>
				</p>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
