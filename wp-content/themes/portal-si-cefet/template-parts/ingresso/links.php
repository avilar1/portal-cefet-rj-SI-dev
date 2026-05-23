<?php
/**
 * Links oficiais (SISU, edital, matrícula).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_ingresso_config();
$links  = isset( $config['official_links'] ) && is_array( $config['official_links'] ) ? $config['official_links'] : array();

if ( empty( $links ) ) {
	return;
}
?>
<section class="portal-ingresso-links" aria-labelledby="portal-ingresso-links-title">
	<div class="portal-ingresso-links__inner">
		<h2 id="portal-ingresso-links-title" class="portal-ingresso-section__title">
			<?php esc_html_e( 'Links oficiais', 'portal-si-cefet' ); ?>
		</h2>
		<ul class="portal-ingresso-links__grid">
			<?php foreach ( $links as $link ) : ?>
				<?php
				if ( ! is_array( $link ) || empty( $link['url'] ) ) {
					continue;
				}
				$is_primary = ! empty( $link['primary'] );
				$card_class = $is_primary ? ' portal-ingresso-links__item--primary' : '';
				?>
				<li class="portal-ingresso-links__item br-card<?php echo esc_attr( $card_class ); ?>">
					<div class="card-content portal-ingresso-links__content">
						<h3 class="portal-ingresso-links__title">
							<?php echo esc_html( isset( $link['title'] ) ? (string) $link['title'] : '' ); ?>
						</h3>
						<?php if ( ! empty( $link['description'] ) ) : ?>
							<p class="portal-ingresso-links__desc"><?php echo esc_html( (string) $link['description'] ); ?></p>
						<?php endif; ?>
						<a
							class="<?php echo $is_primary ? 'portal-btn portal-btn--primary' : 'portal-ingresso-links__anchor'; ?>"
							href="<?php echo esc_url( (string) $link['url'] ); ?>"
							target="_blank"
							rel="noopener noreferrer"
						>
							<?php echo $is_primary ? esc_html__( 'Acessar página oficial', 'portal-si-cefet' ) : esc_html__( 'Abrir link', 'portal-si-cefet' ); ?>
							<span aria-hidden="true"> ↗</span>
							<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
						</a>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
