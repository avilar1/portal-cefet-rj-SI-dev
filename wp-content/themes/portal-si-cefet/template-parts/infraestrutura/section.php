<?php
/**
 * Secção de infraestrutura (laboratórios, biblioteca, etc.).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = isset( $args['section'] ) && is_array( $args['section'] ) ? $args['section'] : array();
$items   = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();

if ( empty( $section['title'] ) || empty( $items ) ) {
	return;
}

$section_id = ! empty( $section['id'] ) ? sanitize_title( (string) $section['id'] ) : 'secao';
?>
<section class="portal-infra-section" id="<?php echo esc_attr( $section_id ); ?>" aria-labelledby="portal-infra-<?php echo esc_attr( $section_id ); ?>-title">
	<h2 id="portal-infra-<?php echo esc_attr( $section_id ); ?>-title" class="portal-infra-section__title">
		<?php echo esc_html( (string) $section['title'] ); ?>
	</h2>
	<?php if ( ! empty( $section['intro'] ) ) : ?>
		<p class="portal-infra-section__intro"><?php echo esc_html( (string) $section['intro'] ); ?></p>
	<?php endif; ?>
	<ul class="portal-infra-cards">
		<?php foreach ( $items as $item ) : ?>
			<?php
			get_template_part(
				'template-parts/infraestrutura/card',
				null,
				array( 'item' => $item )
			);
			?>
		<?php endforeach; ?>
	</ul>
</section>
