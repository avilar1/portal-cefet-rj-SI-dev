<?php
/**
 * Header oficial GovBR-DS (br-header compact + sticky).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$govbr_logo = 'https://www.gov.br/ds/assets/img/govbr-logo.png';
$home_url   = home_url( '/' );
?>
<header class="br-header compact" data-sticky="data-sticky">
	<div class="container-lg">
		<div class="header-top">
			<div class="header-logo">
				<a href="<?php echo esc_url( $home_url ); ?>">
					<img src="<?php echo esc_url( $govbr_logo ); ?>" alt="<?php esc_attr_e( 'gov.br', 'portal-si-cefet' ); ?>" />
				</a>
				<span class="br-divider vertical mx-half mx-sm-1"></span>
				<div class="header-sign">
					<a href="https://www.cefet-rj.br/" rel="noopener noreferrer" target="_blank">
						<?php esc_html_e( 'CEFET/RJ', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</div>
			</div>
			<div class="header-actions">
				<div class="header-links dropdown">
					<button class="br-button circle small" type="button" data-toggle="dropdown" aria-label="<?php esc_attr_e( 'Abrir links de acessibilidade e governo', 'portal-si-cefet' ); ?>">
						<i class="fas fa-ellipsis-v" aria-hidden="true"></i>
					</button>
					<div class="br-list">
						<div class="header">
							<div class="title"><?php esc_html_e( 'Acesso rápido', 'portal-si-cefet' ); ?></div>
						</div>
						<a class="br-item" href="#main-content"><?php esc_html_e( 'Ir para o conteúdo', 'portal-si-cefet' ); ?></a>
						<a class="br-item" href="<?php echo esc_url( portal_si_page_url( 'acessibilidade' ) ); ?>"><?php esc_html_e( 'Acessibilidade', 'portal-si-cefet' ); ?></a>
						<a class="br-item" href="https://www.vlibras.gov.br/" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'VLibras', 'portal-si-cefet' ); ?></a>
						<button class="br-item portal-br-item-button" type="button" data-portal-contrast-toggle=""<?php esc_html_e( 'Alto Contraste', 'portal-si-cefet' ); ?></button>
						<a class="br-item" href="<?php echo esc_url( portal_si_page_url( 'mapa-do-site' ) ); ?>"><?php esc_html_e( 'Mapa do Site', 'portal-si-cefet' ); ?></a>
						<a class="br-item" href="https://www.gov.br/mec" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Ministério da Educação', 'portal-si-cefet' ); ?></a>
						<a class="br-item" href="https://www.gov.br/" rel="noopener noreferrer" target="_blank">gov.br</a>
					</div>
				</div>
				<div class="header-search-trigger">
					<button class="br-button circle small" type="button" aria-label="<?php esc_attr_e( 'Abrir busca', 'portal-si-cefet' ); ?>" data-toggle="search" data-target=".header-search">
						<i class="fas fa-search" aria-hidden="true"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="header-menu">
				<div class="header-menu-trigger">
					<button class="br-button small circle" type="button" aria-label="<?php esc_attr_e( 'Menu', 'portal-si-cefet' ); ?>" data-toggle="menu" data-target="#main-navigation" id="menu-compact">
						<i class="fas fa-bars" aria-hidden="true"></i>
					</button>
				</div>
				<div class="header-info">
					<div class="header-title">
						<a href="<?php echo esc_url( $home_url ); ?>"><?php esc_html_e( 'Sistemas de Informação', 'portal-si-cefet' ); ?></a>
					</div>
					<div class="header-subtitle"><?php esc_html_e( 'CEFET/RJ — Campus Maria da Graça', 'portal-si-cefet' ); ?></div>
				</div>
			</div>
			<nav class="portal-header-nav" aria-label="<?php esc_attr_e( 'Menu principal', 'portal-si-cefet' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'portal-header-nav__list',
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
			<div class="header-search">
				<form role="search" method="get" class="br-input has-icon portal-header-search" action="<?php echo esc_url( $home_url ); ?>">
					<label for="portal-header-search-field" class="sr-only"><?php esc_html_e( 'Buscar no portal', 'portal-si-cefet' ); ?></label>
					<input id="portal-header-search-field" type="search" name="s" placeholder="<?php esc_attr_e( 'O que você procura?', 'portal-si-cefet' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" />
					<button class="br-button circle small" type="submit" aria-label="<?php esc_attr_e( 'Pesquisar', 'portal-si-cefet' ); ?>">
						<i class="fas fa-search" aria-hidden="true"></i>
					</button>
				</form>
				<button class="br-button circle search-close ml-1" type="button" aria-label="<?php esc_attr_e( 'Fechar busca', 'portal-si-cefet' ); ?>" data-dismiss="search">
					<i class="fas fa-times" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	</div>
</header>
