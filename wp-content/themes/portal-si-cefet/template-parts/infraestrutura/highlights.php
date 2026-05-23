<?php
/**
 * Destaques do campus.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = portal_si_infraestrutura_highlights();
if ( empty( $stats ) ) {
	return;
}
?>
<section class="portal-infra-highlights" aria-label="<?php esc_attr_e( 'Destaques da infraestrutura', 'portal-si-cefet' ); ?>">
	<ul class="portal-infra-highlights__list">
		<?php foreach ( $stats as $stat ) : ?>
			<li class="portal-infra-highlights__item br-card">
				<div class="card-content portal-infra-highlights__content">
					<span class="portal-infra-highlights__value"><?php echo esc_html( $stat['value'] ); ?></span>
					<span class="portal-infra-highlights__label"><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
