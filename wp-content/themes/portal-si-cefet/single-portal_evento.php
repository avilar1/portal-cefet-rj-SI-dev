<?php
/**
 * Evento individual — singular do CPT portal_evento.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--singular site-main--evento" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		$iso = portal_si_evento_get_date( get_the_ID() );
		?>
		<article <?php post_class( 'entry entry--evento' ); ?>>
			<header class="portal-page-header portal-page-header--evento">
				<?php if ( $iso ) : ?>
					<p class="portal-event-single__date">
						<time datetime="<?php echo esc_attr( $iso ); ?>">
							<?php echo esc_html( portal_si_evento_format_date( $iso ) ); ?>
						</time>
					</p>
				<?php endif; ?>
				<h1 class="portal-page-header__title entry-title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="portal-event-single__figure">
					<?php the_post_thumbnail( 'large', array( 'class' => 'portal-event-single__img' ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<p class="portal-event-single__back">
				<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( 'agenda-e-eventos' ) ); ?>">
					<?php esc_html_e( '← Voltar para Agenda e Eventos', 'portal-si-cefet' ); ?>
				</a>
			</p>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
