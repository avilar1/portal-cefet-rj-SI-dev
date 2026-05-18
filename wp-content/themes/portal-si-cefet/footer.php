<?php
/**
 * Rodapé — zonas 7 e 8 do layout MVP (RN10, RNF07).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer" role="contentinfo">
	<?php
	get_template_part( 'template-parts/footer/sitemap' );
	get_template_part( 'template-parts/footer/legal-bar' );
	?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
