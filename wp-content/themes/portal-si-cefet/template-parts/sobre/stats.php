<?php
/**
 * Zona B — Números do curso.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = portal_si_sobre_stats();
if ( empty( $stats ) ) {
	return;
}
?>
<section class="portal-sobre-stats" aria-label="<?php esc_attr_e( 'Destaques do curso', 'portal-si-cefet' ); ?>">
	<div class="portal-sobre-stats__inner">
		<ul class="portal-sobre-stats__list">
			<?php foreach ( $stats as $stat ) : ?>
				<li class="portal-sobre-stats__item br-card">
					<div class="card-content portal-sobre-stats__content">
						<span class="portal-sobre-stats__value"><?php echo esc_html( $stat['value'] ); ?></span>
						<span class="portal-sobre-stats__label"><?php echo esc_html( $stat['label'] ); ?></span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
