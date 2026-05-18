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
		<h2 id="portal-service-links-title" class="portal-service-links__heading">
			<?php esc_html_e( 'Acesso Rápido', 'portal-si-cefet' ); ?>
		</h2>
		<ul class="portal-service-links__grid">
			<?php foreach ( $services as $service ) : ?>
				<li>
					<a class="portal-service-card" href="<?php echo esc_url( $service['url'] ); ?>">
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
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
