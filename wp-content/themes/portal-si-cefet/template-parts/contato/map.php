<?php
/**
 * Mapa — RF27.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$map = portal_si_contato_map();
if ( ! $map ) {
	return;
}

$config = portal_si_infraestrutura_config();
$campus = isset( $config['campus'] ) && is_array( $config['campus'] ) ? $config['campus'] : array();
?>
<section class="portal-contato-section portal-contato-map-section" id="localizacao" aria-labelledby="portal-contato-map-title">
	<h2 id="portal-contato-map-title" class="portal-contato-section__title"><?php esc_html_e( 'Localização', 'portal-si-cefet' ); ?></h2>
	<aside class="portal-contato-map br-card" aria-label="<?php esc_attr_e( 'Mapa do campus', 'portal-si-cefet' ); ?>">
		<div class="card-content portal-contato-map__inner">
			<?php if ( ! empty( $campus['name'] ) ) : ?>
				<p class="portal-contato-map__campus"><strong><?php echo esc_html( (string) $campus['name'] ); ?></strong></p>
			<?php endif; ?>
			<div class="portal-contato-map__embed">
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iframe/oEmbed.
				echo $map['html'];
				?>
			</div>
			<?php if ( ! empty( $map['link'] ) ) : ?>
				<p class="portal-contato-map__link">
					<a href="<?php echo esc_url( $map['link'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Abrir no Google Maps', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</p>
			<?php endif; ?>
		</div>
	</aside>
</section>
