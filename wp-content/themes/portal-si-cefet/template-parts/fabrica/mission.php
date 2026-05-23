<?php
/**
 * Missão.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$mission = portal_si_fabrica_mission();
if ( empty( $mission['text'] ) ) {
	return;
}
?>
<section class="portal-fabrica-section portal-fabrica-mission" id="missao" aria-labelledby="portal-fabrica-mission-title">
	<h2 id="portal-fabrica-mission-title" class="portal-fabrica-section__title">
		<?php
		echo esc_html(
			! empty( $mission['title'] ) ? (string) $mission['title'] : __( 'Missão', 'portal-si-cefet' )
		);
		?>
	</h2>
	<p class="portal-fabrica-section__text"><?php echo esc_html( (string) $mission['text'] ); ?></p>
</section>
