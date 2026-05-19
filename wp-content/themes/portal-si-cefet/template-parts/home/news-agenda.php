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

$noticias_url = portal_si_page_url( 'noticias' );
$events       = portal_si_home_agenda_events();
?>
<section class="portal-news-agenda" aria-labelledby="portal-news-agenda-title">
	<div class="portal-news-agenda__inner">
		<div class="portal-news-agenda__news">
			<header class="portal-section-header">
				<h2 id="portal-news-title" class="portal-section-header__title">
					<?php esc_html_e( 'Notícias', 'portal-si-cefet' ); ?>
				</h2>
				<a class="portal-section-header__more" href="<?php echo esc_url( $noticias_url ); ?>">
					<?php esc_html_e( 'Ver todas', 'portal-si-cefet' ); ?>
				</a>
			</header>

			<?php if ( $news_query->have_posts() ) : ?>
				<ul class="portal-news-grid">
					<?php
					while ( $news_query->have_posts() ) :
						$news_query->the_post();
						$categories = get_the_category();
						$cat_name   = ! empty( $categories ) ? $categories[0]->name : __( 'Institucional', 'portal-si-cefet' );
						?>
						<li class="portal-news-card">
							<article class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) ); ?>">
								<a
									class="portal-news-card__media"
									href="<?php the_permalink(); ?>"
									aria-label="<?php echo esc_attr( sprintf( __( 'Ver notícia: %s', 'portal-si-cefet' ), get_the_title() ) ); ?>"
								>
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large', array( 'class' => 'portal-news-card__img' ) ); ?>
									<?php else : ?>
										<span class="portal-news-card__placeholder" aria-hidden="true"></span>
									<?php endif; ?>
								</a>
								<div class="card-content portal-news-card__body">
									<p class="portal-news-card__meta">
										<span class="portal-news-card__tag"><?php echo esc_html( $cat_name ); ?></span>
										<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
											<?php echo esc_html( get_the_date() ); ?>
										</time>
									</p>
									<h3 class="portal-news-card__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
								</div>
							</article>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<p class="portal-news-agenda__empty">
					<?php esc_html_e( 'Nenhuma notícia publicada ainda. A equipa editorial pode publicar posts em Notícias.', 'portal-si-cefet' ); ?>
				</p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<aside class="portal-news-agenda__agenda" aria-labelledby="portal-agenda-title">
			<header class="portal-section-header">
				<h2 id="portal-agenda-title" class="portal-section-header__title">
					<?php esc_html_e( 'Agenda', 'portal-si-cefet' ); ?>
				</h2>
			</header>
			<ul class="portal-agenda-list">
				<?php foreach ( $events as $event ) : ?>
					<li class="portal-agenda-list__item">
						<time class="portal-agenda-list__date" datetime="<?php echo esc_attr( $event['date'] ); ?>">
							<?php echo esc_html( $event['date'] ); ?>
						</time>
						<a class="portal-agenda-list__link" href="<?php echo esc_url( $event['url'] ); ?>">
							<?php echo esc_html( $event['title'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</aside>
	</div>
</section>
