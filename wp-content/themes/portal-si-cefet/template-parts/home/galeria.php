<?php
/**
 * Faixa Galeria na home — álbuns marcados "Destacar na página inicial" (RF21).
 *
 * Só é incluída pelo front-page.php quando há ao menos um álbum destacado.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$albums = isset( $args['albums'] ) ? $args['albums'] : array();
if ( empty( $albums ) ) {
	return;
}
?>
<section class="portal-home-galeria" aria-labelledby="portal-home-galeria-title">
	<div class="portal-home-galeria__inner">
		<header class="portal-section-header portal-home-galeria__header">
			<a class="portal-section-header__more" href="<?php echo esc_url( portal_si_page_url( PORTAL_SI_GALERIA_SLUG ) ); ?>">
				<?php esc_html_e( 'Ver galeria', 'portal-si-cefet' ); ?>
			</a>
		</header>
		<?php
		get_template_part(
			'template-parts/noticia/grid',
			null,
			array(
				'items'        => $albums,
				'show_excerpt' => true,
				'grid_class'   => 'portal-noticia-grid portal-noticia-grid--home',
			)
		);
		?>
	</div>
</section>
