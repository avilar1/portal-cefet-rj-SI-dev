<?php
/**
 * Zona 3 — Navegação principal (layout portal + RF32, RF33).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="portal-main-nav">
	<div class="portal-main-nav__inner">
		<a class="portal-main-nav__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="portal-main-nav__brand-icon" aria-hidden="true">
				<svg width="28" height="28" viewBox="0 0 24 24" focusable="false">
					<rect width="24" height="24" rx="2" fill="#fff"/>
					<path fill="#1351B4" d="M12 3 1 9l11 6 9-4.91V17h2V9L12 3zm7 11.5-7 3.85-7-3.85V18l7 4 7-4v-3.5z"/>
				</svg>
			</span>
			<span class="portal-main-nav__brand-text">
				<span class="portal-main-nav__brand-name">CEFET/RJ</span>
				<span class="portal-main-nav__brand-tagline"><?php esc_html_e( 'Sistemas de Informação', 'portal-si-cefet' ); ?></span>
			</span>
			<span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
		</a>

		<button
			type="button"
			class="portal-main-nav__toggle"
			aria-expanded="false"
			aria-controls="portal-primary-menu"
			data-portal-menu-toggle
		>
			<span class="portal-main-nav__toggle-icon" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Abrir menu', 'portal-si-cefet' ); ?></span>
		</button>

		<div class="portal-main-nav__menu-wrap" id="portal-primary-menu">
			<nav class="nav-primary nav-primary--desktop" aria-label="<?php esc_attr_e( 'Menu principal', 'portal-si-cefet' ); ?>">
				<?php portal_si_render_header_compact_menu(); ?>
			</nav>
			<nav class="nav-primary nav-primary--mobile" aria-label="<?php esc_attr_e( 'Menu completo', 'portal-si-cefet' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location'       => 'primary',
						'container'            => false,
						'menu_class'           => 'nav-primary__list nav-primary__list--full',
						'fallback_cb'          => false,
					)
				);
				?>
			</nav>
		</div>

		<div class="portal-main-nav__search-wrap">
			<button
				type="button"
				class="portal-main-nav__search-toggle"
				aria-expanded="false"
				aria-controls="portal-header-search"
				data-portal-search-toggle
			>
				<svg class="portal-icon" width="22" height="22" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
					<path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
				</svg>
				<span class="screen-reader-text"><?php esc_html_e( 'Abrir busca', 'portal-si-cefet' ); ?></span>
			</button>
			<div class="portal-main-nav__search-panel" id="portal-header-search" hidden>
				<?php
				get_search_form(
					array(
						'aria_label' => __( 'Busca no portal', 'portal-si-cefet' ),
					)
				);
				?>
			</div>
		</div>
	</div>
</div>
