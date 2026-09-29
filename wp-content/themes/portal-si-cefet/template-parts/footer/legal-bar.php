<?php
/**
 * Zona 8 — Footer legal (RNF07).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="portal-footer-legal">
	<div class="portal-footer-legal__inner">
		<div class="portal-footer-legal__brand">
			<span class="portal-footer-legal__logo">
				<?php portal_si_the_logo( array( 'alt' => __( 'Sistemas de Informação — CEFET/RJ', 'portal-si-cefet' ) ) ); ?>
			</span>
			<p class="portal-footer-legal__copy">
				&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
				<?php esc_html_e( 'CEFET/RJ — Todos os direitos reservados', 'portal-si-cefet' ); ?>
			</p>
		</div>
		<ul class="portal-footer-legal__links">
			<li>
				<a href="<?php echo esc_url( portal_si_page_url( 'politica-de-privacidade' ) ); ?>">
					<?php esc_html_e( 'Política de Privacidade', 'portal-si-cefet' ); ?>
				</a>
			</li>
			<li>
				<a href="<?php echo esc_url( portal_si_page_url( 'termos-de-uso' ) ); ?>">
					<?php esc_html_e( 'Termos de Uso', 'portal-si-cefet' ); ?>
				</a>
			</li>
			<li>
				<button type="button" class="portal-footer-legal__cookies" data-portal-cookie-preferences>
					<?php esc_html_e( 'Preferências de cookies', 'portal-si-cefet' ); ?>
				</button>
			</li>
		</ul>
	</div>
</div>
