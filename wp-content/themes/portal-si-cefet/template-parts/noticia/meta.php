<?php
/**
 * Metadados de notícia (categoria + data).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$date_iso = isset( $args['date_iso'] ) ? $args['date_iso'] : '';
$date     = isset( $args['date'] ) ? $args['date'] : '';
$category = isset( $args['category'] ) ? $args['category'] : '';
?>
<p class="portal-noticia-meta">
	<?php if ( $category ) : ?>
		<span class="portal-noticia-meta__tag"><?php echo esc_html( $category ); ?></span>
	<?php endif; ?>
	<?php if ( $date_iso && $date ) : ?>
		<time datetime="<?php echo esc_attr( $date_iso ); ?>"><?php echo esc_html( $date ); ?></time>
	<?php endif; ?>
</p>
