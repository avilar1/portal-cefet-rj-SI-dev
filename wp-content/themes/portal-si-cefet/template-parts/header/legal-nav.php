<?php
/**
 * Zona 2 — Navegação de itens legais e acessibilidade (H11).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav class="portal-legal-nav" aria-label="<?php esc_attr_e( 'Acessibilidade e utilidades', 'portal-si-cefet' ); ?>">
	<div class="portal-legal-nav__inner">
		<ul class="portal-legal-nav__list">
			<li>
				<a href="#main-content">
					<?php esc_html_e( 'Ir para o conteúdo', 'portal-si-cefet' ); ?>
				</a>
			</li>
			<li>
				<a href="<?php echo esc_url( portal_si_page_url( 'acessibilidade' ) ); ?>">
					<?php esc_html_e( 'Acessibilidade', 'portal-si-cefet' ); ?>
				</a>
			</li>
			<li>
				<a href="https://www.vlibras.gov.br/" rel="noopener noreferrer" target="_blank">
					<?php esc_html_e( 'VLibras', 'portal-si-cefet' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
				</a>
			</li>
			<li>
				<button type="button" class="portal-legal-nav__contrast" data-portal-contrast-toggle>
					<?php esc_html_e( 'Alto Contraste', 'portal-si-cefet' ); ?>
				</button>
			</li>
			<li>
				<a href="<?php echo esc_url( portal_si_page_url( 'mapa-do-site' ) ); ?>">
					<?php esc_html_e( 'Mapa do Site', 'portal-si-cefet' ); ?>
				</a>
			</li>
		</ul>
	</div>
</nav>
