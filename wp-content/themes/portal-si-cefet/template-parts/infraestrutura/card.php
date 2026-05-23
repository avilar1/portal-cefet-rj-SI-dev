<?php
/**
 * Card de espaço / recurso.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$item = isset( $args['item'] ) && is_array( $args['item'] ) ? $args['item'] : array();

$title       = isset( $item['title'] ) ? (string) $item['title'] : '';
$description = isset( $item['description'] ) ? (string) $item['description'] : '';
$bullets     = isset( $item['bullets'] ) && is_array( $item['bullets'] ) ? $item['bullets'] : array();
$link        = isset( $item['link'] ) && is_array( $item['link'] ) ? $item['link'] : array();

if ( '' === $title ) {
	return;
}
?>
<li class="portal-infra-cards__item br-card">
	<div class="card-content portal-infra-cards__content">
		<h3 class="portal-infra-cards__title"><?php echo esc_html( $title ); ?></h3>
		<?php if ( $description ) : ?>
			<p class="portal-infra-cards__desc"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $bullets ) ) : ?>
			<ul class="portal-infra-cards__bullets">
				<?php foreach ( $bullets as $bullet ) : ?>
					<?php if ( '' !== trim( (string) $bullet ) ) : ?>
						<li><?php echo esc_html( (string) $bullet ); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ( ! empty( $link['url'] ) ) : ?>
			<a class="portal-infra-cards__link" href="<?php echo esc_url( (string) $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
				<?php
				echo esc_html(
					! empty( $link['label'] ) ? (string) $link['label'] : __( 'Saiba mais', 'portal-si-cefet' )
				);
				?>
				<span aria-hidden="true"> ↗</span>
				<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
			</a>
		<?php endif; ?>
	</div>
</li>
