<?php
/**
 * Zona 5 — Serviços / links rápidos (RF01, RF03, RF05, RF17, RF20).
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
				<li>
					<a
						class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) . ' portal-service-card' ); ?>"
						href="<?php echo esc_url( $service['url'] ); ?>"
					>
						<div class="card-content portal-service-card__inner">
							<span class="portal-service-card__icon" aria-hidden="true">
								<?php
								$icon = $service['icon'];
								get_template_part( 'template-parts/home/icon', null, array( 'icon' => $icon ) );
								?>
							</span>
							<span class="portal-service-card__body">
								<span class="portal-service-card__title"><?php echo esc_html( $service['title'] ); ?></span>
								<span class="portal-service-card__description"><?php echo esc_html( $service['description'] ); ?></span>
							</span>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
