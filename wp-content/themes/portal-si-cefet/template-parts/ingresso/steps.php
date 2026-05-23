<?php
/**
 * Passo a passo do ingresso.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_ingresso_config();
$steps  = isset( $config['steps'] ) && is_array( $config['steps'] ) ? $config['steps'] : array();

if ( empty( $steps ) ) {
	return;
}
?>
<section class="portal-ingresso-steps" aria-labelledby="portal-ingresso-steps-title">
	<div class="portal-ingresso-steps__inner">
		<h2 id="portal-ingresso-steps-title" class="portal-ingresso-section__title">
			<?php esc_html_e( 'Como funciona o ingresso', 'portal-si-cefet' ); ?>
		</h2>
		<ol class="portal-ingresso-steps__list">
			<?php foreach ( $steps as $index => $step ) : ?>
				<?php
				if ( ! is_array( $step ) ) {
					continue;
				}
				$title = isset( $step['title'] ) ? (string) $step['title'] : '';
				$text  = isset( $step['text'] ) ? (string) $step['text'] : '';
				if ( '' === $title && '' === $text ) {
					continue;
				}
				?>
				<li class="portal-ingresso-steps__item">
					<span class="portal-ingresso-steps__num" aria-hidden="true"><?php echo (int) ( $index + 1 ); ?></span>
					<div class="portal-ingresso-steps__body">
						<?php if ( $title ) : ?>
							<h3 class="portal-ingresso-steps__title"><?php echo esc_html( $title ); ?></h3>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="portal-ingresso-steps__text"><?php echo esc_html( $text ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
