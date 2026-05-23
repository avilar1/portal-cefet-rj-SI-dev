<?php
/**
 * Destaques do curso no processo seletivo.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = portal_si_ingresso_highlights();
if ( empty( $stats ) ) {
	return;
}
?>
<section class="portal-ingresso-highlights" aria-labelledby="portal-ingresso-highlights-title">
	<div class="portal-ingresso-highlights__inner">
		<h2 id="portal-ingresso-highlights-title" class="portal-ingresso-section__title">
			<?php esc_html_e( 'Sistemas de Informação no SISU 2026', 'portal-si-cefet' ); ?>
		</h2>
		<ul class="portal-ingresso-highlights__list">
			<?php foreach ( $stats as $stat ) : ?>
				<li class="portal-ingresso-highlights__item br-card">
					<div class="card-content portal-ingresso-highlights__content">
						<span class="portal-ingresso-highlights__value"><?php echo esc_html( $stat['value'] ); ?></span>
						<span class="portal-ingresso-highlights__label"><?php echo esc_html( $stat['label'] ); ?></span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
