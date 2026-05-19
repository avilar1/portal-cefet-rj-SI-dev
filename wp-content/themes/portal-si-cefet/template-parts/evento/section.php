<?php
/**
 * Seção de eventos com separador DS (reutilizável).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title         = isset( $args['title'] ) ? $args['title'] : '';
$section_id    = isset( $args['section_id'] ) ? $args['section_id'] : '';
$events        = isset( $args['events'] ) ? $args['events'] : array();
$variant       = isset( $args['variant'] ) ? $args['variant'] : 'cards';
$empty_message = isset( $args['empty_message'] ) ? $args['empty_message'] : '';
?>
<section class="portal-event-section" <?php echo $section_id ? 'aria-labelledby="' . esc_attr( $section_id ) . '"' : ''; ?>>
	<?php
	if ( $title && $section_id ) {
		portal_si_section_divider(
			array(
				'label' => $title,
				'id'    => $section_id,
				'wrap'  => true,
			)
		);
	}
	?>
	<div class="portal-event-section__inner">
		<?php
		get_template_part(
			'template-parts/evento/list',
			null,
			array(
				'events'        => $events,
				'variant'       => $variant,
				'empty_message' => $empty_message,
			)
		);
		?>
	</div>
</section>
