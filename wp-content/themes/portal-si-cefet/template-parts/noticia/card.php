<?php
/**
 * Card de notícia (br-card) — reutilizável na home, listagem e arquivo.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$noticia = isset( $args['noticia'] ) ? $args['noticia'] : null;
if ( ! $noticia ) {
	return;
}

$show_excerpt = ! empty( $args['show_excerpt'] );
?>
<li class="portal-noticia-grid__item">
	<article class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) . ' portal-noticia-card' ); ?>">
		<a
			class="portal-noticia-card__media"
			href="<?php echo esc_url( $noticia['url'] ); ?>"
			aria-label="<?php echo esc_attr( sprintf( __( 'Ver notícia: %s', 'portal-si-cefet' ), $noticia['title'] ) ); ?>"
		>
			<?php if ( ! empty( $noticia['has_thumb'] ) && ! empty( $noticia['thumb_html'] ) ) : ?>
				<?php echo $noticia['thumb_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<span class="portal-noticia-card__placeholder" aria-hidden="true"></span>
			<?php endif; ?>
		</a>
		<div class="card-content portal-noticia-card__body">
			<?php
			get_template_part(
				'template-parts/noticia/meta',
				null,
				array(
					'date_iso' => $noticia['date_iso'],
					'date'     => $noticia['date'],
					'category' => $noticia['category'],
				)
			);
			?>
			<h3 class="portal-noticia-card__title">
				<a href="<?php echo esc_url( $noticia['url'] ); ?>"><?php echo esc_html( $noticia['title'] ); ?></a>
			</h3>
			<?php if ( $show_excerpt && ! empty( $noticia['excerpt'] ) ) : ?>
				<p class="portal-noticia-card__excerpt"><?php echo esc_html( $noticia['excerpt'] ); ?></p>
			<?php endif; ?>
		</div>
	</article>
</li>
