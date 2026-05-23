<?php
/**
 * Grupo de documentos.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$group = isset( $args['group'] ) && is_array( $args['group'] ) ? $args['group'] : array();
$items = isset( $group['items'] ) && is_array( $group['items'] ) ? $group['items'] : array();

if ( empty( $items ) ) {
	return;
}

$group_id = ! empty( $group['id'] ) ? sanitize_title( (string) $group['id'] ) : 'grupo';
$title    = isset( $group['title'] ) ? (string) $group['title'] : '';
?>
<section class="portal-documentos-group" data-group-id="<?php echo esc_attr( $group_id ); ?>" aria-labelledby="portal-documentos-<?php echo esc_attr( $group_id ); ?>-title">
	<div class="portal-documentos-group__inner">
		<?php if ( $title ) : ?>
			<h2 id="portal-documentos-<?php echo esc_attr( $group_id ); ?>-title" class="portal-documentos-section__title">
				<?php echo esc_html( $title ); ?>
			</h2>
		<?php endif; ?>
		<?php if ( ! empty( $group['intro'] ) ) : ?>
			<p class="portal-documentos-group__intro"><?php echo esc_html( (string) $group['intro'] ); ?></p>
		<?php endif; ?>
		<ul class="portal-documentos-list">
			<?php foreach ( $items as $item ) : ?>
				<?php
				get_template_part(
					'template-parts/documentos/item',
					null,
					array( 'item' => $item )
				);
				?>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
