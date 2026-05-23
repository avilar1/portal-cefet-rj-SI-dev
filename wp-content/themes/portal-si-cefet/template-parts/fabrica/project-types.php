<?php
/**
 * Tipos de projeto atendidos.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = portal_si_fabrica_project_types();
$items = isset( $block['items'] ) ? $block['items'] : array();
if ( empty( $items ) ) {
	return;
}
?>
<section class="portal-fabrica-section portal-fabrica-types" id="tipos-de-projeto" aria-labelledby="portal-fabrica-types-title">
	<h2 id="portal-fabrica-types-title" class="portal-fabrica-section__title">
		<?php
		echo esc_html(
			! empty( $block['title'] ) ? (string) $block['title'] : __( 'Tipos de projeto', 'portal-si-cefet' )
		);
		?>
	</h2>
	<?php if ( ! empty( $block['intro'] ) ) : ?>
		<p class="portal-fabrica-section__intro"><?php echo esc_html( (string) $block['intro'] ); ?></p>
	<?php endif; ?>
	<ul class="portal-fabrica-cards">
		<?php foreach ( $items as $item ) : ?>
			<li class="portal-fabrica-cards__item portal-card">
				<h3 class="portal-fabrica-cards__title"><?php echo esc_html( (string) $item['title'] ); ?></h3>
				<?php if ( ! empty( $item['description'] ) ) : ?>
					<p class="portal-fabrica-cards__text"><?php echo esc_html( (string) $item['description'] ); ?></p>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
