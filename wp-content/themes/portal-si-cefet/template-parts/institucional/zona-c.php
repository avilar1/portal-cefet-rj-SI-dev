<?php
/**
 * Zona C — Destaque editorial + CTA.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$zona_c = portal_si_institucional_zona_c();

if ( '' === trim( $zona_c['title'] . $zona_c['text'] ) ) {
	return;
}
?>
<section class="portal-inst-zona-c" aria-labelledby="portal-inst-zona-c-title">
	<div class="portal-inst-zona-c__inner">
		<div class="portal-inst-zona-c__content">
			<?php if ( $zona_c['title'] ) : ?>
				<h2 id="portal-inst-zona-c-title" class="portal-inst-zona-c__title">
					<?php echo esc_html( $zona_c['title'] ); ?>
				</h2>
			<?php endif; ?>
			<?php if ( $zona_c['text'] ) : ?>
				<p class="portal-inst-zona-c__text"><?php echo esc_html( $zona_c['text'] ); ?></p>
			<?php endif; ?>
			<?php if ( $zona_c['cta_url'] && $zona_c['cta_label'] ) : ?>
				<p class="portal-inst-zona-c__cta">
					<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( $zona_c['cta_url'] ); ?>">
						<?php echo esc_html( $zona_c['cta_label'] ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>
		<div class="portal-inst-zona-c__visual" aria-hidden="true">
			<span class="portal-inst-zona-c__icon-wrap">
				<?php
				get_template_part(
					'template-parts/home/icon',
					null,
					array( 'icon' => $zona_c['icon'] )
				);
				?>
			</span>
		</div>
	</div>
</section>
