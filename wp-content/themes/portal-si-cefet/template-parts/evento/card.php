<?php
/**
 * Card de evento (br-card) — página Agenda e Eventos.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$event = isset( $args['event'] ) ? $args['event'] : null;
if ( ! $event ) {
	return;
}
?>
<li class="portal-event-grid__item">
	<article class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) . ' portal-event-card' ); ?>">
		<a
			class="portal-event-card__media"
			href="<?php echo esc_url( $event['url'] ); ?>"
			aria-label="<?php echo esc_attr( sprintf( __( 'Ver evento: %s', 'portal-si-cefet' ), $event['title'] ) ); ?>"
		>
			<?php if ( ! empty( $event['has_thumb'] ) && ! empty( $event['thumb_html'] ) ) : ?>
				<?php echo $event['thumb_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML do thumbnail. ?>
			<?php else : ?>
				<span class="portal-event-card__placeholder" aria-hidden="true"></span>
			<?php endif; ?>
		</a>
		<div class="card-content portal-event-card__body">
			<p class="portal-event-card__meta">
				<time datetime="<?php echo esc_attr( $event['date_iso'] ); ?>">
					<?php echo esc_html( $event['date'] ); ?>
				</time>
			</p>
			<h3 class="portal-event-card__title">
				<a href="<?php echo esc_url( $event['url'] ); ?>"><?php echo esc_html( $event['title'] ); ?></a>
			</h3>
			<?php if ( ! empty( $event['excerpt'] ) ) : ?>
				<p class="portal-event-card__excerpt"><?php echo esc_html( $event['excerpt'] ); ?></p>
			<?php endif; ?>
		</div>
	</article>
</li>
