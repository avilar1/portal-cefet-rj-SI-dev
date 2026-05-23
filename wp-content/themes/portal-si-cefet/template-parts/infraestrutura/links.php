<?php
/**
 * Links oficiais CEFET/RJ.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_infraestrutura_config();
$links  = isset( $config['official_links'] ) && is_array( $config['official_links'] ) ? $config['official_links'] : array();

if ( empty( $links ) ) {
	return;
}
?>
<section class="portal-infra-links" aria-labelledby="portal-infra-links-title">
	<h2 id="portal-infra-links-title" class="portal-infra-section__title">
		<?php esc_html_e( 'Links oficiais do campus', 'portal-si-cefet' ); ?>
	</h2>
	<ul class="portal-infra-links__list">
		<?php foreach ( $links as $link ) : ?>
			<?php
			if ( ! is_array( $link ) || empty( $link['url'] ) ) {
				continue;
			}
			?>
			<li class="portal-infra-links__item">
				<a href="<?php echo esc_url( (string) $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
					<strong><?php echo esc_html( isset( $link['title'] ) ? (string) $link['title'] : '' ); ?></strong>
					<?php if ( ! empty( $link['description'] ) ) : ?>
						<span><?php echo esc_html( (string) $link['description'] ); ?></span>
					<?php endif; ?>
					<span class="portal-infra-links__ext" aria-hidden="true"> ↗</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
