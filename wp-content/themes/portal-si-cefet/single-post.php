<?php
/**
 * Notícia individual — post type post (RF18 / RF19).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--singular site-main--noticia" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		$categories = get_the_category();
		$cat_name   = ! empty( $categories ) ? $categories[0]->name : __( 'Institucional', 'portal-si-cefet' );
		?>
		<article <?php post_class( 'portal-noticia-single entry' ); ?>>
			<header class="portal-page-header portal-page-header--noticia">
				<?php
				get_template_part(
					'template-parts/noticia/meta',
					null,
					array(
						'date_iso' => get_the_date( DATE_W3C ),
						'date'     => get_the_date(),
						'category' => $cat_name,
					)
				);
				?>
				<h1 class="portal-page-header__title entry-title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="portal-noticia-single__figure">
					<?php the_post_thumbnail( 'large', array( 'class' => 'portal-noticia-single__img' ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="entry-content portal-noticia-single__content">
				<?php the_content(); ?>
			</div>

			<footer class="portal-noticia-single__footer">
				<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_noticias_url() ); ?>">
					<?php esc_html_e( '← Voltar para Notícias', 'portal-si-cefet' ); ?>
				</a>
			</footer>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
