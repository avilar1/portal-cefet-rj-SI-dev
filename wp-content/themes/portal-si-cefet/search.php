<?php
/**
 * Resultados da busca global (RF33).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main" class="site-main site-main--search" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<h1 class="search-results-title">
		<?php
		if ( get_search_query() ) {
			printf(
				/* translators: %s: termo de busca */
				esc_html__( 'Resultados da busca por: %s', 'portal-si-cefet' ),
				esc_html( get_search_query() )
			);
		} else {
			esc_html_e( 'Busca no portal', 'portal-si-cefet' );
		}
		?>
	</h1>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'search-result' ); ?>>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<p class="search-result__meta">
					<?php
					$pto = get_post_type_object( get_post_type() );
					echo esc_html( $pto ? $pto->labels->singular_name : get_post_type() );
					?>
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
		<p class="search-no-results"><?php esc_html_e( 'Nenhum resultado encontrado. Tente outras palavras-chave.', 'portal-si-cefet' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
