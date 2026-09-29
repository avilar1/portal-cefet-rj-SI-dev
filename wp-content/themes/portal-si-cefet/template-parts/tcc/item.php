<?php
/**
 * Item da lista de TCCs.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tcc = isset( $args['tcc'] ) ? $args['tcc'] : null;
if ( ! $tcc ) {
	return;
}
$heading = ( isset( $args['heading'] ) && 'h2' === $args['heading'] ) ? 'h2' : 'h3';
?>
<li class="portal-tcc-item">
	<div class="portal-tcc-item__main">
		<<?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- h2|h3. ?> class="portal-tcc-item__title">
			<a href="<?php echo esc_url( $tcc['url'] ); ?>"><?php echo esc_html( $tcc['title'] ); ?></a>
		</<?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<p class="portal-tcc-item__meta">
			<?php if ( $tcc['autores_text'] ) : ?>
				<span><?php echo esc_html( $tcc['autores_text'] ); ?></span>
			<?php endif; ?>
			<?php if ( $tcc['orientador'] ) : ?>
				<span>
					<?php
					/* translators: %s: nome do orientador. */
					printf( esc_html__( 'Orientação: %s', 'portal-si-cefet' ), esc_html( $tcc['orientador'] ) );
					?>
				</span>
			<?php endif; ?>
		</p>
	</div>
	<div class="portal-tcc-item__side">
		<?php if ( $tcc['periodo'] ) : ?>
			<span class="portal-tcc-item__periodo"><?php echo esc_html( $tcc['periodo'] ); ?></span>
		<?php endif; ?>
		<?php if ( $tcc['file_url'] ) : ?>
			<span class="portal-tcc-badge portal-tcc-badge--pdf">PDF</span>
		<?php endif; ?>
		<?php if ( $tcc['link'] ) : ?>
			<span class="portal-tcc-badge portal-tcc-badge--link"><?php esc_html_e( 'Link', 'portal-si-cefet' ); ?></span>
		<?php endif; ?>
		<?php if ( $tcc['exemplo'] ) : ?>
			<span class="portal-tcc-badge portal-tcc-badge--exemplo"><?php esc_html_e( 'Exemplo', 'portal-si-cefet' ); ?></span>
		<?php endif; ?>
	</div>
</li>
