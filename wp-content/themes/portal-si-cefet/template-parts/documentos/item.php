<?php
/**
 * Item de documento (link ou em breve).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$item = isset( $args['item'] ) && is_array( $args['item'] ) ? $args['item'] : array();

$title       = isset( $item['title'] ) ? (string) $item['title'] : '';
$description = isset( $item['description'] ) ? (string) $item['description'] : '';
$url         = isset( $item['url'] ) ? trim( (string) $item['url'] ) : '';
$meta        = isset( $item['meta'] ) ? (string) $item['meta'] : '';
$coming_soon = ! empty( $item['coming_soon'] );
$external    = ! empty( $item['external'] );
$internal    = ! empty( $item['internal'] );
$editorial   = ! empty( $item['editorial'] );

if ( '' === $title ) {
	return;
}

$has_link = '' !== $url && ! $coming_soon;
?>
<li class="portal-documentos-list__item br-card<?php echo $coming_soon ? ' portal-documentos-list__item--soon' : ''; ?><?php echo $editorial ? ' portal-documentos-list__item--editorial' : ''; ?>">
	<div class="card-content portal-documentos-list__content">
		<div class="portal-documentos-list__head">
			<h3 class="portal-documentos-list__title"><?php echo esc_html( $title ); ?></h3>
			<?php if ( $meta ) : ?>
				<span class="portal-documentos-list__meta"><?php echo esc_html( $meta ); ?></span>
			<?php endif; ?>
		</div>
		<?php if ( $description ) : ?>
			<p class="portal-documentos-list__desc"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
		<?php if ( $coming_soon ) : ?>
			<p class="portal-documentos-list__soon"><?php esc_html_e( 'Arquivo em atualização pela coordenação.', 'portal-si-cefet' ); ?></p>
		<?php elseif ( $has_link ) : ?>
			<a
				class="portal-documentos-list__link<?php echo $internal ? ' portal-documentos-list__link--internal' : ''; ?>"
				href="<?php echo esc_url( $url ); ?>"
				<?php echo $external ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
			>
				<?php
				if ( $internal ) {
					esc_html_e( 'Abrir no portal', 'portal-si-cefet' );
				} elseif ( false !== stripos( $meta, 'pdf' ) || false !== stripos( $url, '.pdf' ) ) {
					esc_html_e( 'Baixar PDF', 'portal-si-cefet' );
				} else {
					esc_html_e( 'Acessar', 'portal-si-cefet' );
				}
				?>
				<?php if ( $external ) : ?>
					<span aria-hidden="true"> ↗</span>
					<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
	</div>
</li>
