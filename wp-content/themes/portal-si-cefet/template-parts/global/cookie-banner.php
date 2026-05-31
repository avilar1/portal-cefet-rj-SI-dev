<?php
/**
 * Banner de consentimento de cookies (LGPD).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$privacy_url = portal_si_page_url( PORTAL_SI_PRIVACIDADE_SLUG );
?>
<div
	id="portal-cookie-banner"
	class="portal-cookie-banner"
	role="dialog"
	aria-modal="true"
	aria-labelledby="portal-cookie-banner-title"
	aria-describedby="portal-cookie-banner-desc"
	hidden
>
	<div class="portal-cookie-banner__inner">
		<p id="portal-cookie-banner-title" class="portal-cookie-banner__title">
			<?php esc_html_e( 'Privacidade e cookies', 'portal-si-cefet' ); ?>
		</p>
		<p id="portal-cookie-banner-desc" class="portal-cookie-banner__text">
			<?php esc_html_e( 'Usamos cookies necessários para o site funcionar e para lembrar suas escolhas (como este aviso). Não usamos cookies de publicidade nesta versão.', 'portal-si-cefet' ); ?>
			<?php if ( $privacy_url ) : ?>
				<a href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Saiba mais na Política de Privacidade', 'portal-si-cefet' ); ?></a>.
			<?php endif; ?>
		</p>
		<div class="portal-cookie-banner__actions">
			<button type="button" class="portal-btn portal-btn--primary" data-portal-cookie-accept>
				<?php esc_html_e( 'Aceitar', 'portal-si-cefet' ); ?>
			</button>
			<button type="button" class="portal-btn portal-btn--secondary" data-portal-cookie-reject>
				<?php esc_html_e( 'Recusar cookies opcionais', 'portal-si-cefet' ); ?>
			</button>
		</div>
	</div>
</div>
