<?php
/**
 * Observações importantes do edital.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config  = portal_si_ingresso_config();
$notices = isset( $config['notices'] ) && is_array( $config['notices'] ) ? $config['notices'] : array();

if ( empty( $notices ) ) {
	return;
}
?>
<section class="portal-ingresso-notices" aria-labelledby="portal-ingresso-notices-title">
	<div class="portal-ingresso-notices__inner">
		<h2 id="portal-ingresso-notices-title" class="portal-ingresso-section__title">
			<?php esc_html_e( 'Antes de se matricular', 'portal-si-cefet' ); ?>
		</h2>
		<ul class="portal-ingresso-notices__list">
			<?php foreach ( $notices as $notice ) : ?>
				<?php
				if ( ! is_array( $notice ) ) {
					continue;
				}
				$title = isset( $notice['title'] ) ? (string) $notice['title'] : '';
				$text  = isset( $notice['text'] ) ? (string) $notice['text'] : '';
				if ( '' === $title && '' === $text ) {
					continue;
				}
				?>
				<li class="portal-ingresso-notices__item">
					<?php if ( $title ) : ?>
						<strong class="portal-ingresso-notices__label"><?php echo esc_html( $title ); ?></strong>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<span><?php echo esc_html( $text ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
