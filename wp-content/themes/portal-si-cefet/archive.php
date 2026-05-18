<?php
/**
 * Arquivos de posts (categoria, tag, data, autor) — RF17 listagens relacionadas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--archive" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<header class="archive-header">
		<h1 class="archive-title"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
	</header>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'entry entry--excerpt' ); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<p class="entry-meta">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</p>
				<?php the_excerpt(); ?>
			</article>
			<?php
		endwhile;
		the_posts_pagination(
			array(
				'mid_size'  => 1,
				'prev_text' => __( 'Anterior', 'portal-si-cefet' ),
				'next_text' => __( 'Próxima', 'portal-si-cefet' ),
			)
		);
	else :
		?>
		<p><?php esc_html_e( 'Nada encontrado neste arquivo.', 'portal-si-cefet' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
