<?php
/**
 * Acesso ao campus + mapa.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_infraestrutura_config();
$campus = isset( $config['campus'] ) && is_array( $config['campus'] ) ? $config['campus'] : array();
$map    = function_exists( 'portal_si_infraestrutura_map' ) ? portal_si_infraestrutura_map() : null;

$has_text = ! empty( $campus['access'] ) || ! empty( $campus['name'] );
if ( ! $has_text && ! $map ) {
	return;
}
?>
<aside id="como-chegar-mapa" class="portal-infra-access br-card" aria-label="<?php esc_attr_e( 'Como chegar', 'portal-si-cefet' ); ?>">
	<div class="card-content portal-infra-access__inner">
		<h2 class="portal-infra-access__title"><?php esc_html_e( 'Como chegar', 'portal-si-cefet' ); ?></h2>

		<div class="portal-infra-access__layout<?php echo $map ? '' : ' portal-infra-access__layout--text-only'; ?>">
			<?php if ( $has_text ) : ?>
				<div class="portal-infra-access__copy">
					<?php if ( ! empty( $campus['access'] ) ) : ?>
						<p class="portal-infra-access__text"><?php echo esc_html( (string) $campus['access'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $campus['name'] ) ) : ?>
						<p class="portal-infra-access__name"><strong><?php echo esc_html( (string) $campus['name'] ); ?></strong></p>
					<?php endif; ?>
					<?php if ( ! empty( $campus['address'] ) ) : ?>
						<p class="portal-infra-access__address"><?php echo esc_html( (string) $campus['address'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $map ) : ?>
				<div class="portal-infra-access__map-wrap">
					<div class="portal-infra-access__map">
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iframe/oEmbed do Google Maps.
						echo $map['html'];
						?>
					</div>
					<?php if ( ! empty( $map['link'] ) ) : ?>
						<p class="portal-infra-access__map-link">
							<a href="<?php echo esc_url( $map['link'] ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Abrir no Google Maps', 'portal-si-cefet' ); ?>
								<span aria-hidden="true"> ↗</span>
								<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
							</a>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</aside>
