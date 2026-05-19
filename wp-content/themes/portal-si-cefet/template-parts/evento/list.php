<?php
/**
 * Lista de eventos — variantes compact (home) ou cards (página agenda).
 *
 * @package Portal_SI_CEFET
 *
 * @var array $args {
 *     @type array  $events        Lista de eventos (portal_si_evento_to_array).
 *     @type string $variant       compact|cards.
 *     @type string $empty_message Mensagem se vazia.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$events        = isset( $args['events'] ) ? $args['events'] : array();
$variant       = isset( $args['variant'] ) ? $args['variant'] : 'compact';
$empty_message = isset( $args['empty_message'] ) ? $args['empty_message'] : __( 'Nenhum evento nesta seção.', 'portal-si-cefet' );

if ( empty( $events ) ) {
	echo '<p class="portal-news-agenda__empty portal-agenda-list__empty">';
	echo esc_html( $empty_message );
	echo '</p>';
	return;
}

if ( 'cards' === $variant ) {
	echo '<ul class="portal-event-grid">';
	foreach ( $events as $event ) {
		get_template_part( 'template-parts/evento/card', null, array( 'event' => $event ) );
	}
	echo '</ul>';
	return;
}

echo '<ul class="portal-agenda-list">';
foreach ( $events as $event ) {
	?>
	<li class="portal-agenda-list__item">
		<time class="portal-agenda-list__date" datetime="<?php echo esc_attr( $event['date_iso'] ); ?>">
			<?php echo esc_html( $event['date'] ); ?>
		</time>
		<a class="portal-agenda-list__link" href="<?php echo esc_url( $event['url'] ); ?>">
			<?php echo esc_html( $event['title'] ); ?>
		</a>
	</li>
	<?php
}
echo '</ul>';
