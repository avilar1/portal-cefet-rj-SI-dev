<?php
/**
 * Links úteis.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = portal_si_contato_channels();
$items = isset( $block['items'] ) ? $block['items'] : array();
if ( empty( $items ) ) {
	return;
}
?>
<section class="portal-contato-section portal-contato-channels" aria-labelledby="portal-contato-channels-title">
	<h2 id="portal-contato-channels-title" class="portal-contato-section__title">
		<?php
		echo esc_html(
			! empty( $block['title'] ) ? (string) $block['title'] : __( 'Outros canais', 'portal-si-cefet' )
		);
		?>
	</h2>
	<ul class="portal-contato-channels__list">
		<?php foreach ( $items as $item ) : ?>
			<li class="portal-contato-channels__item">
				<a href="<?php echo esc_url( (string) $item['url'] ); ?>"<?php echo ! empty( $item['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
					<strong><?php echo esc_html( (string) $item['label'] ); ?></strong>
					<?php if ( ! empty( $item['description'] ) ) : ?>
						<span><?php echo esc_html( (string) $item['description'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $item['external'] ) ) : ?>
						<span class="portal-contato-channels__ext" aria-hidden="true">↗</span>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
