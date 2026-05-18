<?php
/**
 * Zona 1 — Banner superior (RN04).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="portal-top-banner" aria-label="<?php esc_attr_e( 'Identidade institucional', 'portal-si-cefet' ); ?>">
	<div class="portal-top-banner__inner">
		<a class="portal-top-banner__brand" href="https://www.cefet-rj.br/" rel="noopener noreferrer" target="_blank">
			<span class="portal-top-banner__brand-text">CEFET/RJ</span>
			<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
		</a>
		<nav class="portal-top-banner__gov" aria-label="<?php esc_attr_e( 'Órgãos superiores', 'portal-si-cefet' ); ?>">
			<ul class="portal-top-banner__gov-list">
				<li>
					<a href="https://www.gov.br/mec" rel="noopener noreferrer" target="_blank">
						<?php esc_html_e( 'Ministério da Educação', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</li>
				<li>
					<a href="https://www.gov.br/" rel="noopener noreferrer" target="_blank">
						<?php esc_html_e( 'gov.br', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
