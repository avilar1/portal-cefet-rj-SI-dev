<?php
/**
 * Cabeçalho híbrido — layout do portal + boas práticas gov.br (RN04, RF32, RF33).
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
<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Ir para o conteúdo', 'portal-si-cefet' ); ?></a>
<div class="portal-header-meta">
	<?php
	get_template_part( 'template-parts/header/top-banner' );
	get_template_part( 'template-parts/header/legal-nav' );
	?>
</div>
<header class="site-header site-header--sticky" role="banner">
	<?php get_template_part( 'template-parts/header/main-nav' ); ?>
</header>
