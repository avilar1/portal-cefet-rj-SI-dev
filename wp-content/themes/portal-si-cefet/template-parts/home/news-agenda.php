<?php
/**
 * Zona 6 — Notícias (75%) + Agenda (25%) — RF17, RF20.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$news_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$noticias_items = portal_si_map_noticias_from_query( $news_query );
$noticias_url   = portal_si_noticias_url();
$agenda_url   = portal_si_page_url( 'agenda-e-eventos' );
$events       = portal_si_home_agenda_events();
?>
<section class="portal-news-agenda" aria-labelledby="portal-news-agenda-title">
	<div class="portal-news-agenda__inner">
		<div class="portal-news-agenda__news">
			<?php
			get_template_part(
				'template-parts/noticia/list-section',
				null,
				array(
					'items'         => $noticias_items,
					'title'         => __( 'Notícias', 'portal-si-cefet' ),
					'heading_id'    => 'portal-news-title',
					'more_url'      => $noticias_url,
					'grid_class'    => 'portal-noticia-grid portal-noticia-grid--home',
					'empty_message' => __( 'Nenhuma notícia publicada ainda. A equipa editorial pode publicar posts em Notícias.', 'portal-si-cefet' ),
				)
			);
			?>
		</div>

		<aside class="portal-news-agenda__agenda" aria-labelledby="portal-agenda-title">
			<header class="portal-section-header">
				<h2 id="portal-agenda-title" class="portal-section-header__title">
					<?php esc_html_e( 'Agenda', 'portal-si-cefet' ); ?>
				</h2>
				<a class="portal-section-header__more" href="<?php echo esc_url( $agenda_url ); ?>">
					<?php esc_html_e( 'Ver todos', 'portal-si-cefet' ); ?>
				</a>
			</header>
			<?php
			get_template_part(
				'template-parts/evento/list',
				null,
				array(
					'events'        => $events,
					'variant'       => 'compact',
					'empty_message' => __( 'Nenhum evento programado no momento. Consulte a agenda completa ou volte em breve.', 'portal-si-cefet' ),
				)
			);
			?>
		</aside>
	</div>
</section>
