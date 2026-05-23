<?php
/**
 * Ouvidoria — link institucional (RF28 futuro).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = portal_si_contato_ouvidoria();
if ( empty( $block['url'] ) ) {
	return;
}
?>
<section class="portal-contato-section portal-contato-ouvidoria" aria-labelledby="portal-contato-ouvidoria-title">
	<h2 id="portal-contato-ouvidoria-title" class="portal-contato-section__title">
		<?php
		echo esc_html(
			! empty( $block['title'] ) ? (string) $block['title'] : __( 'Ouvidoria', 'portal-si-cefet' )
		);
		?>
	</h2>
	<?php if ( ! empty( $block['text'] ) ) : ?>
		<p class="portal-contato-section__intro"><?php echo esc_html( (string) $block['text'] ); ?></p>
	<?php endif; ?>
	<p>
		<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( (string) $block['url'] ); ?>" target="_blank" rel="noopener noreferrer">
			<?php
			echo esc_html(
				! empty( $block['label'] ) ? (string) $block['label'] : __( 'Acessar Ouvidoria', 'portal-si-cefet' )
			);
			?>
			<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
		</a>
	</p>
</section>
