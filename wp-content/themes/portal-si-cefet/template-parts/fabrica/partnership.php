<?php
/**
 * Compromissos da parceria (confiança para parceiros externos).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = portal_si_fabrica_partnership();
$points = isset( $block['points'] ) ? $block['points'] : array();
if ( empty( $points ) ) {
	return;
}
?>
<section class="portal-fabrica-section portal-fabrica-partnership" id="parceria" aria-labelledby="portal-fabrica-partnership-title">
	<h2 id="portal-fabrica-partnership-title" class="portal-fabrica-section__title">
		<?php
		echo esc_html(
			! empty( $block['title'] ) ? (string) $block['title'] : __( 'Parceria', 'portal-si-cefet' )
		);
		?>
	</h2>
	<ul class="portal-fabrica-partnership__list">
		<?php foreach ( $points as $point ) : ?>
			<li><?php echo wp_kses_post( portal_si_fabrica_format_inline( $point ) ); ?></li>
		<?php endforeach; ?>
	</ul>
</section>
