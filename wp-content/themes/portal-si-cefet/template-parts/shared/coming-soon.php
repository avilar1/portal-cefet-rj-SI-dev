<?php
/**
 * Aviso «conteúdo em breve» / «em construção».
 *
 * @package Portal_SI_CEFET
 *
 * @var array $args {
 *     @type string $variant       page|section|inline|compact
 *     @type string $badge         Texto do selo.
 *     @type string $title         Título opcional.
 *     @type string $message       Parágrafo principal.
 *     @type bool   $show_contact  Exibir orientação de contato.
 *     @type string $contact_url   URL da coordenação.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$variant      = isset( $args['variant'] ) ? sanitize_key( (string) $args['variant'] ) : 'section';
$badge        = isset( $args['badge'] ) ? (string) $args['badge'] : __( 'Conteúdo em breve', 'portal-si-cefet' );
$title        = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$message      = isset( $args['message'] ) ? trim( (string) $args['message'] ) : __( 'Esta seção está em construção. O conteúdo será publicado em breve.', 'portal-si-cefet' );
$show_contact = ! isset( $args['show_contact'] ) || ! empty( $args['show_contact'] );
$contact_url  = isset( $args['contact_url'] ) ? (string) $args['contact_url'] : portal_si_coordination_contato_url();

$classes = array(
	'portal-coming-soon',
	'portal-coming-soon--' . $variant,
);

if ( 'page' === $variant ) {
	$classes[] = 'br-card';
}
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" role="status">
	<?php if ( 'compact' !== $variant && 'inline' !== $variant ) : ?>
		<p class="portal-coming-soon__badge"><?php echo esc_html( $badge ); ?></p>
	<?php endif; ?>

	<?php if ( '' !== $title && 'compact' !== $variant ) : ?>
		<h2 class="portal-coming-soon__title"><?php echo esc_html( $title ); ?></h2>
	<?php endif; ?>

	<?php if ( 'inline' === $variant || 'compact' === $variant ) : ?>
		<p class="portal-coming-soon__text">
			<span class="portal-coming-soon__badge portal-coming-soon__badge--inline"><?php echo esc_html( $badge ); ?></span>
			<?php echo esc_html( $message ); ?>
		</p>
	<?php else : ?>
		<p class="portal-coming-soon__text"><?php echo esc_html( $message ); ?></p>
	<?php endif; ?>

	<?php if ( $show_contact ) : ?>
		<p class="portal-coming-soon__urgency">
			<?php
			echo wp_kses_post(
				sprintf(
					/* translators: %s: link to contact page */
					__( 'Em caso de urgência na solicitação desta informação, entre em contato com a %s.', 'portal-si-cefet' ),
					'<a href="' . esc_url( $contact_url ) . '">' . esc_html__( 'coordenação do curso', 'portal-si-cefet' ) . '</a>'
				)
			);
			?>
		</p>
	<?php endif; ?>
</div>
