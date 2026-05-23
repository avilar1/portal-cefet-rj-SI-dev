<?php
/**
 * Metodologia de trabalho.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$method = portal_si_fabrica_methodology();
$steps  = isset( $method['steps'] ) ? $method['steps'] : array();
if ( empty( $steps ) ) {
	return;
}
?>
<section class="portal-fabrica-section portal-fabrica-methodology" id="metodologia" aria-labelledby="portal-fabrica-method-title">
	<h2 id="portal-fabrica-method-title" class="portal-fabrica-section__title">
		<?php
		echo esc_html(
			! empty( $method['title'] ) ? (string) $method['title'] : __( 'Metodologia', 'portal-si-cefet' )
		);
		?>
	</h2>
	<?php if ( ! empty( $method['intro'] ) ) : ?>
		<p class="portal-fabrica-section__intro"><?php echo esc_html( (string) $method['intro'] ); ?></p>
	<?php endif; ?>
	<ol class="portal-fabrica-steps">
		<?php foreach ( $steps as $step ) : ?>
			<li class="portal-fabrica-steps__item">
				<?php if ( ! empty( $step['number'] ) ) : ?>
					<span class="portal-fabrica-steps__number" aria-hidden="true"><?php echo esc_html( (string) $step['number'] ); ?></span>
				<?php endif; ?>
				<div class="portal-fabrica-steps__body">
					<h3 class="portal-fabrica-steps__title"><?php echo esc_html( (string) $step['title'] ); ?></h3>
					<?php if ( ! empty( $step['text'] ) ) : ?>
						<p class="portal-fabrica-steps__text"><?php echo esc_html( (string) $step['text'] ); ?></p>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
</section>
