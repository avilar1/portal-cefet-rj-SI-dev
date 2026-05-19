<?php
/**
 * Zona 1 — Faixa institucional (RN04), inspirada na barra gov.br.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$govbr_logo = 'https://www.gov.br/ds/assets/img/govbr-logo.png';
?>
<div class="portal-top-banner" aria-label="<?php esc_attr_e( 'Identidade institucional', 'portal-si-cefet' ); ?>">
	<div class="portal-top-banner__inner">
		<div class="portal-top-banner__brand-group">
			<a class="portal-top-banner__govbr" href="https://www.gov.br/" rel="noopener noreferrer" target="_blank">
				<img src="<?php echo esc_url( $govbr_logo ); ?>" alt="<?php esc_attr_e( 'gov.br', 'portal-si-cefet' ); ?>" width="96" height="28" />
				<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
			</a>
			<span class="portal-top-banner__divider" aria-hidden="true"></span>
			<a class="portal-top-banner__brand" href="https://www.cefet-rj.br/" rel="noopener noreferrer" target="_blank">
				<?php esc_html_e( 'CEFET/RJ', 'portal-si-cefet' ); ?>
				<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
			</a>
		</div>
		<nav class="portal-top-banner__gov" aria-label="<?php esc_attr_e( 'Órgãos superiores', 'portal-si-cefet' ); ?>">
			<ul class="portal-top-banner__gov-list">
				<li>
					<a href="https://www.gov.br/mec" rel="noopener noreferrer" target="_blank">
						<?php esc_html_e( 'Ministério da Educação', 'portal-si-cefet' ); ?>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
