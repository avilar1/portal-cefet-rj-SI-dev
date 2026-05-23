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
$show_empty = ! empty( $group['empty_notice'] );

if ( empty( $items ) && ! $show_empty ) {
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
		<?php if ( ! empty( $items ) ) : ?>
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
		<?php else : ?>
			<?php
			portal_si_the_coming_soon_notice(
				array(
					'variant' => 'section',
					'message' => __( 'Ainda não há publicações enviadas pela coordenação nesta seção. Memorandos e arquivos aparecerão aqui quando forem disponibilizados.', 'portal-si-cefet' ),
				)
			);
			?>
		<?php endif; ?>
	</div>
</section>
