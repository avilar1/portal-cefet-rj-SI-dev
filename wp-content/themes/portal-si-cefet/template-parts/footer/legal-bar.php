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
		<p class="portal-footer-legal__copy">
			&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
			<?php esc_html_e( 'CEFET/RJ — Todos os direitos reservados', 'portal-si-cefet' ); ?>
		</p>
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
				<button type="button" class="portal-footer-legal__cookies" data-portal-cookies-notice>
					<?php esc_html_e( 'Aviso de Cookies', 'portal-si-cefet' ); ?>
				</button>
			</li>
		</ul>
	</div>
</div>
