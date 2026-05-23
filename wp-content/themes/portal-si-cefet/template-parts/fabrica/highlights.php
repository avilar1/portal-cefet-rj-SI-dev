<?php
/**
 * Destaques — pilares da Fábrica.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = portal_si_fabrica_highlights();
if ( empty( $items ) ) {
	return;
}
?>
<section class="portal-fabrica-highlights" aria-label="<?php esc_attr_e( 'Destaques', 'portal-si-cefet' ); ?>">
	<ul class="portal-fabrica-highlights__list">
		<?php foreach ( $items as $item ) : ?>
			<li class="portal-fabrica-highlights__item">
				<?php if ( ! empty( $item['value'] ) ) : ?>
					<span class="portal-fabrica-highlights__value"><?php echo esc_html( $item['value'] ); ?></span>
				<?php endif; ?>
				<span class="portal-fabrica-highlights__label"><?php echo esc_html( $item['label'] ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
