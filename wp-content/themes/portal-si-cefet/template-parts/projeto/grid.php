<?php
/**
 * Grade de cards de projeto (ou aviso quando vazia).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items         = isset( $args['items'] ) ? $args['items'] : array();
$heading       = isset( $args['heading'] ) ? $args['heading'] : 'h3';
$empty_message = isset( $args['empty_message'] ) ? $args['empty_message'] : __( 'Nenhum projeto publicado ainda.', 'portal-si-cefet' );

if ( empty( $items ) ) {
	portal_si_the_coming_soon_notice(
		array(
			'variant' => 'compact',
			'message' => $empty_message,
		)
	);
	return;
}

$has_exemplo = false;
foreach ( $items as $item ) {
	if ( ! empty( $item['exemplo'] ) ) {
		$has_exemplo = true;
		break;
	}
}
?>
<?php if ( $has_exemplo && ! empty( $args['show_exemplo_note'] ) ) : ?>
	<p class="portal-projeto-exemplo-note" role="note">
		<?php esc_html_e( 'Projetos com o selo "Exemplo" são ilustrativos e serão substituídos pelos projetos reais do curso.', 'portal-si-cefet' ); ?>
	</p>
<?php endif; ?>
<ul class="portal-projeto-grid">
	<?php
	foreach ( $items as $item ) {
		get_template_part(
			'template-parts/projeto/card',
			null,
			array(
				'projeto' => $item,
				'heading' => $heading,
			)
		);
	}
	?>
</ul>
