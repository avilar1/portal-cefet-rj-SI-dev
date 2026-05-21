<?php
/**
 * Zona D — Navegação por âncoras.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sections = portal_si_sobre_anchor_sections();
if ( empty( $sections ) ) {
	return;
}
?>
<div class="portal-sobre-anchor-wrap">
	<div class="portal-sobre-anchor-wrap__inner">
		<p class="portal-sobre-anchor-wrap__context">
			<?php esc_html_e( 'Coordenação do curso de Sistemas de Informação', 'portal-si-cefet' ); ?><br />
			<?php esc_html_e( 'CEFET/RJ — Campus Maria da Graça', 'portal-si-cefet' ); ?>
		</p>
		<nav class="portal-sobre-anchor-nav" aria-label="<?php esc_attr_e( 'Nesta página', 'portal-si-cefet' ); ?>">
			<ul class="portal-sobre-anchor-nav__list">
				<?php foreach ( $sections as $section ) : ?>
					<li>
						<a
							class="portal-sobre-anchor-nav__link"
							href="#<?php echo esc_attr( $section['id'] ); ?>"
							data-portal-sobre-anchor="<?php echo esc_attr( $section['id'] ); ?>"
						>
							<?php echo esc_html( $section['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
</div>
