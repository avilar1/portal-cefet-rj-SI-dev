<?php
/**
 * Galeria multimídia — álbuns por categoria (RF21).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_term = portal_si_galeria_current_term();
$paged        = max( 1, (int) get_query_var( 'paged' ) );
$query_args   = array( 'paged' => $paged );
if ( $current_term ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => PORTAL_SI_ALBUM_TAXONOMY,
			'field'    => 'term_id',
			'terms'    => $current_term->term_id,
		),
	);
}
$albums_query = portal_si_album_query( $query_args );
$albums       = portal_si_map_albums_from_query( $albums_query );
$terms        = portal_si_galeria_terms();
$page_url     = portal_si_page_url( PORTAL_SI_GALERIA_SLUG );

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--galeria" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-galeria-header">
			<p class="portal-galeria-header__badge"><?php esc_html_e( 'Comunicação', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<p class="portal-page-header__intro"><?php echo esc_html( portal_si_galeria_intro() ); ?></p>
		</header>

		<div class="portal-galeria-body">
			<?php if ( count( $terms ) > 1 ) : ?>
				<nav class="portal-galeria-filter" aria-label="<?php esc_attr_e( 'Filtrar álbuns por categoria', 'portal-si-cefet' ); ?>">
					<ul class="portal-galeria-filter__list">
						<li>
							<a class="portal-galeria-filter__link" href="<?php echo esc_url( $page_url ); ?>" <?php echo $current_term ? '' : 'aria-current="page"'; ?>>
								<?php esc_html_e( 'Todos', 'portal-si-cefet' ); ?>
							</a>
						</li>
						<?php foreach ( $terms as $term ) : ?>
							<li>
								<a
									class="portal-galeria-filter__link"
									href="<?php echo esc_url( add_query_arg( 'categoria', $term->slug, $page_url ) ); ?>"
									<?php echo ( $current_term && $current_term->term_id === $term->term_id ) ? 'aria-current="page"' : ''; ?>
								>
									<?php echo esc_html( $term->name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>

			<?php
			get_template_part(
				'template-parts/noticia/grid',
				null,
				array(
					'items'         => $albums,
					'show_excerpt'  => true,
					'grid_class'    => 'portal-noticia-grid portal-galeria-grid',
					'empty_message' => $current_term
						? __( 'Nenhum álbum nesta categoria ainda.', 'portal-si-cefet' )
						: __( 'Nenhum álbum publicado ainda. Em breve, fotos e vídeos das atividades do curso.', 'portal-si-cefet' ),
				)
			);

			$pagination = paginate_links(
				array(
					'total'     => (int) $albums_query->max_num_pages,
					'current'   => $paged,
					'prev_text' => __( '← Anteriores', 'portal-si-cefet' ),
					'next_text' => __( 'Próximos →', 'portal-si-cefet' ),
				)
			);
			if ( $pagination ) :
				?>
				<nav class="portal-galeria-pagination" aria-label="<?php esc_attr_e( 'Páginas da galeria', 'portal-si-cefet' ); ?>">
					<?php echo wp_kses_post( $pagination ); ?>
				</nav>
			<?php endif; ?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
