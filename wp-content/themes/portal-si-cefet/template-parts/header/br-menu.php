<?php
/**
 * Menu lateral oficial GovBR-DS (br-menu), acionado pelo header.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="br-menu" id="main-navigation">
	<div class="menu-container">
		<div class="menu-panel">
			<div class="menu-header">
				<div class="menu-title">
					<span><?php esc_html_e( 'Sistemas de Informação — CEFET/RJ', 'portal-si-cefet' ); ?></span>
				</div>
				<div class="menu-close">
					<button class="br-button circle" type="button" aria-label="<?php esc_attr_e( 'Fechar o menu', 'portal-si-cefet' ); ?>" data-dismiss="menu">
						<i class="fas fa-times" aria-hidden="true"></i>
					</button>
				</div>
			</div>
			<nav class="menu-body" aria-label="<?php esc_attr_e( 'Menu principal', 'portal-si-cefet' ); ?>">
				<?php portal_si_render_br_menu_items(); ?>
			</nav>
			<div class="menu-footer">
				<div class="menu-links">
					<a href="<?php echo esc_url( portal_si_page_url( 'acessibilidade' ) ); ?>">
						<span class="mr-1"><?php esc_html_e( 'Acessibilidade', 'portal-si-cefet' ); ?></span>
						<i class="fas fa-universal-access" aria-hidden="true"></i>
					</a>
					<a href="https://www.vlibras.gov.br/" rel="noopener noreferrer" target="_blank">
						<span class="mr-1"><?php esc_html_e( 'VLibras', 'portal-si-cefet' ); ?></span>
						<i class="fas fa-deaf" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
