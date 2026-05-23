<?php
/**
 * Resumo de contato no rodapé — RF29.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'portal_si_contato_footer_summary' ) ) {
	return;
}

$summary = portal_si_contato_footer_summary();
if ( empty( $summary ) ) {
	return;
}
?>
<div class="portal-footer-contact">
	<?php if ( ! empty( $summary['name'] ) ) : ?>
		<p class="portal-footer-contact__coord">
			<strong><?php echo esc_html( $summary['name'] ); ?></strong>
		</p>
	<?php endif; ?>
	<?php if ( ! empty( $summary['phone'] ) ) : ?>
		<?php $tel = portal_si_contato_phone_href( $summary['phone'] ); ?>
		<p class="portal-footer-contact__line">
			<?php if ( $tel ) : ?>
				<a href="<?php echo esc_url( $tel ); ?>"><?php echo esc_html( $summary['phone'] ); ?></a>
			<?php else : ?>
				<?php echo esc_html( $summary['phone'] ); ?>
			<?php endif; ?>
		</p>
	<?php endif; ?>
	<?php if ( ! empty( $summary['email'] ) && is_email( $summary['email'] ) ) : ?>
		<p class="portal-footer-contact__line">
			<a href="<?php echo esc_url( 'mailto:' . $summary['email'] ); ?>"><?php echo esc_html( $summary['email'] ); ?></a>
		</p>
	<?php endif; ?>
	<?php if ( ! empty( $summary['url'] ) ) : ?>
		<p class="portal-footer-contact__more">
			<a href="<?php echo esc_url( $summary['url'] ); ?>"><?php esc_html_e( 'Página de contato', 'portal-si-cefet' ); ?></a>
		</p>
	<?php endif; ?>
</div>
