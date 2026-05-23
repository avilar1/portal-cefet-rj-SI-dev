<?php
/**
 * Contato do processo seletivo.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_ingresso_config();
$block  = isset( $config['contacts'] ) && is_array( $config['contacts'] ) ? $config['contacts'] : array();

if ( empty( $block['email'] ) ) {
	return;
}
?>
<section class="portal-ingresso-contact" aria-labelledby="portal-ingresso-contact-title">
	<div class="portal-ingresso-contact__inner br-card">
		<div class="card-content">
			<h2 id="portal-ingresso-contact-title" class="portal-ingresso-section__title portal-ingresso-section__title--compact">
				<?php esc_html_e( 'Dúvidas sobre o processo seletivo', 'portal-si-cefet' ); ?>
			</h2>
			<?php if ( ! empty( $block['intro'] ) ) : ?>
				<p class="portal-ingresso-contact__intro"><?php echo esc_html( (string) $block['intro'] ); ?></p>
			<?php endif; ?>
			<p class="portal-ingresso-contact__email">
				<a href="mailto:<?php echo esc_attr( (string) $block['email'] ); ?>">
					<?php echo esc_html( (string) $block['email'] ); ?>
				</a>
			</p>
			<?php if ( ! empty( $block['note'] ) ) : ?>
				<p class="portal-ingresso-contact__note"><?php echo esc_html( (string) $block['note'] ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
