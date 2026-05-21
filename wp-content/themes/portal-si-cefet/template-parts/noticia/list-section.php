<?php
/**
 * Bloco de listagem de notícias (cabeçalho opcional + grade).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items         = isset( $args['items'] ) ? $args['items'] : array();
$title         = isset( $args['title'] ) ? $args['title'] : '';
$more_url      = isset( $args['more_url'] ) ? $args['more_url'] : '';
$show_excerpt  = ! empty( $args['show_excerpt'] );
$empty_message = isset( $args['empty_message'] ) ? $args['empty_message'] : '';
$heading_id    = isset( $args['heading_id'] ) ? $args['heading_id'] : '';
$grid_class    = isset( $args['grid_class'] ) ? $args['grid_class'] : 'portal-noticia-grid';
?>
<section class="portal-noticia-section" <?php echo $heading_id ? 'aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
	<?php if ( $title ) : ?>
		<header class="portal-section-header">
			<h2 <?php echo $heading_id ? 'id="' . esc_attr( $heading_id ) . '"' : ''; ?> class="portal-section-header__title">
				<?php echo esc_html( $title ); ?>
			</h2>
			<?php if ( $more_url ) : ?>
				<a class="portal-section-header__more" href="<?php echo esc_url( $more_url ); ?>">
					<?php esc_html_e( 'Ver todas', 'portal-si-cefet' ); ?>
				</a>
			<?php endif; ?>
		</header>
	<?php endif; ?>

	<?php
	get_template_part(
		'template-parts/noticia/grid',
		null,
		array(
			'items'         => $items,
			'show_excerpt'  => $show_excerpt,
			'empty_message' => $empty_message,
			'grid_class'    => $grid_class,
		)
	);
	?>
</section>
