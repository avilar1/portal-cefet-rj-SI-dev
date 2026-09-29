<?php
/**
 * Álbum da galeria — fotos com ampliação e vídeos (RF21).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--singular site-main--album" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		$album_id  = get_the_ID();
		$iso       = portal_si_album_date_iso( $album_id );
		$term      = portal_si_album_term( $album_id );
		$photo_ids = portal_si_album_photo_ids( $album_id );
		$videos    = portal_si_album_video_urls( $album_id );
		$evento_id = (int) get_post_meta( $album_id, PORTAL_SI_ALBUM_EVENTO_META, true );
		$evento_ok = $evento_id && 'publish' === get_post_status( $evento_id );
		$total     = count( $photo_ids );
		?>
		<article <?php post_class( 'entry entry--album' ); ?>>
			<header class="portal-page-header portal-galeria-header">
				<?php if ( $term ) : ?>
					<p class="portal-galeria-header__badge"><?php echo esc_html( $term->name ); ?></p>
				<?php endif; ?>
				<h1 class="portal-page-header__title entry-title"><?php the_title(); ?></h1>
				<p class="portal-album-meta">
					<time datetime="<?php echo esc_attr( $iso ); ?>"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $iso ) ) ); ?></time>
					<span aria-hidden="true"> · </span>
					<?php echo esc_html( portal_si_album_media_summary( $album_id ) ); ?>
					<?php if ( $evento_ok ) : ?>
						<span aria-hidden="true"> · </span>
						<?php esc_html_e( 'Evento:', 'portal-si-cefet' ); ?>
						<a href="<?php echo esc_url( get_permalink( $evento_id ) ); ?>"><?php echo esc_html( get_the_title( $evento_id ) ); ?></a>
					<?php endif; ?>
				</p>
			</header>

			<div class="portal-album-body">
				<?php if ( trim( get_the_content() ) ) : ?>
					<div class="entry-content portal-album-description">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<?php if ( $photo_ids ) : ?>
					<section class="portal-album-section" aria-labelledby="portal-album-fotos-title">
						<h2 id="portal-album-fotos-title" class="portal-album-section__title"><?php esc_html_e( 'Fotos', 'portal-si-cefet' ); ?></h2>
						<ul class="portal-album-photos" data-galeria>
							<?php
							foreach ( $photo_ids as $index => $photo_id ) :
								$caption = wp_get_attachment_caption( $photo_id );
								$alt     = trim( (string) get_post_meta( $photo_id, '_wp_attachment_image_alt', true ) );
								$label   = $caption ? $caption : $alt;
								$large   = wp_get_attachment_image_url( $photo_id, 'large' );
								?>
								<li class="portal-album-photos__item">
									<a
										class="portal-album-photos__link"
										href="<?php echo esc_url( $large ); ?>"
										data-galeria-item
										data-caption="<?php echo esc_attr( $caption ); ?>"
										data-alt="<?php echo esc_attr( $alt ); ?>"
										aria-label="<?php echo esc_attr( sprintf( __( 'Ampliar foto %1$d de %2$d', 'portal-si-cefet' ), $index + 1, $total ) . ( $label ? ': ' . $label : '' ) ); ?>"
									>
										<?php echo wp_get_attachment_image( $photo_id, 'medium_large', false, array( 'class' => 'portal-album-photos__img', 'loading' => 'lazy' ) ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

				<?php if ( $videos ) : ?>
					<section class="portal-album-section" aria-labelledby="portal-album-videos-title">
						<h2 id="portal-album-videos-title" class="portal-album-section__title"><?php esc_html_e( 'Vídeos', 'portal-si-cefet' ); ?></h2>
						<div class="portal-album-videos">
							<?php foreach ( $videos as $url ) : ?>
								<?php $embed = $GLOBALS['wp_embed']->shortcode( array(), $url ); ?>
								<div class="portal-album-video">
									<?php if ( $embed && false !== strpos( $embed, '<iframe' ) ) : ?>
										<div class="portal-album-video__frame"><?php echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML de oEmbed de provedor permitido. ?></div>
									<?php else : ?>
										<a class="portal-album-video__link" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
											<?php esc_html_e( 'Assistir ao vídeo (abre em nova aba)', 'portal-si-cefet' ); ?>
										</a>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( ! $photo_ids && ! $videos ) : ?>
					<?php
					portal_si_the_coming_soon_notice(
						array(
							'variant' => 'compact',
							'message' => __( 'Este álbum ainda não tem fotos ou vídeos.', 'portal-si-cefet' ),
						)
					);
					?>
				<?php endif; ?>

				<p class="portal-album-back">
					<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( PORTAL_SI_GALERIA_SLUG ) ); ?>">
						<?php esc_html_e( '← Voltar para a Galeria', 'portal-si-cefet' ); ?>
					</a>
				</p>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
