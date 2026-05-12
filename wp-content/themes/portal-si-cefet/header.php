<?php
/**
 * Cabeçalho: marca, menu principal (RF32) e âncora para conteúdo (RNF03).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Ir para o conteúdo', 'portal-si-cefet' ); ?></a>
<header class="site-header" role="banner">
	<?php // Esqueleto da faixa superior gov.br — substituir por componente oficial do DS quando o layout estiver fechado. ?>
	<div class="br-header-stub" aria-label="<?php esc_attr_e( 'Governo Federal', 'portal-si-cefet' ); ?>">
		<div class="br-header-stub__inner">
			<a class="br-header-stub__link" href="https://www.gov.br/" rel="noopener noreferrer" target="_blank">
				<?php esc_html_e( 'Governo Federal', 'portal-si-cefet' ); ?>
				<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
			</a>
		</div>
	</div>
	<div class="site-header__inner">
		<p class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</p>
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => 'nav',
				'container_class' => 'nav-primary',
				'container_aria_label' => __( 'Menu principal', 'portal-si-cefet' ),
				'menu_class'      => 'nav-primary__list',
				'fallback_cb'     => false,
			)
		);
		?>
	</div>
</header>
