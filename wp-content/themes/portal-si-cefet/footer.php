<?php
/**
 * Rodapé: menu secundário (legal / mapa) e fechamento do documento.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer" role="contentinfo">
	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'footer',
			'container'       => 'nav',
			'container_class' => 'nav-footer',
			'container_aria_label' => __( 'Menu rodapé', 'portal-si-cefet' ),
			'menu_class'      => 'nav-footer__list',
			'fallback_cb'     => false,
		)
	);
	?>
	<p class="site-footer__meta">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
