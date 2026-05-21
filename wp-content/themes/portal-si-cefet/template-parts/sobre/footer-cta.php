<?php
/**
 * Zona F — Encerramento (CTAs).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="portal-sobre-footer-cta" aria-label="<?php esc_attr_e( 'Próximos passos', 'portal-si-cefet' ); ?>">
	<div class="portal-sobre-footer-cta__inner">
		<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( 'ingresso' ) ); ?>">
			<?php esc_html_e( 'Como ingressar', 'portal-si-cefet' ); ?>
		</a>
		<a class="portal-sobre-footer-cta__secondary" href="<?php echo esc_url( portal_si_institucional_hub_url() ); ?>">
			<?php esc_html_e( 'Voltar ao Institucional', 'portal-si-cefet' ); ?>
		</a>
	</div>
</section>
