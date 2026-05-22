<?php
/**
 * Zona 5 — Acesso rápido (RF01, RF22 — serviços externos + páginas internas).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = portal_si_home_service_links();
?>
<section class="portal-service-links" aria-labelledby="portal-service-links-title">
	<div class="portal-service-links__inner">
		<ul class="portal-service-links__grid">
			<?php foreach ( $services as $service ) : ?>
				<?php
				$is_external = ! empty( $service['external'] );
				$card_class  = portal_si_br_card_class( array( 'hover' ) ) . ' portal-service-card';
				if ( $is_external ) {
					$card_class .= ' portal-service-card--external';
				}
				?>
				<li>
					<a
						class="<?php echo esc_attr( $card_class ); ?>"
						href="<?php echo esc_url( $service['url'] ); ?>"
						<?php if ( $is_external ) : ?>
							target="_blank"
							rel="noopener noreferrer"
						<?php endif; ?>
					>
						<div class="card-content portal-service-card__inner">
							<span class="portal-service-card__icon" aria-hidden="true">
								<?php
								$icon = $service['icon'];
								get_template_part( 'template-parts/home/icon', null, array( 'icon' => $icon ) );
								?>
							</span>
							<span class="portal-service-card__body">
								<span class="portal-service-card__title">
									<?php echo esc_html( $service['title'] ); ?>
									<?php if ( $is_external ) : ?>
										<span class="portal-service-card__external-mark" aria-hidden="true">↗</span>
										<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
									<?php endif; ?>
								</span>
								<span class="portal-service-card__description"><?php echo esc_html( $service['description'] ); ?></span>
							</span>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
