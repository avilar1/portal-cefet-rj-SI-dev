<?php
/**
 * Aviso editorial.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text = isset( $args['text'] ) ? trim( (string) $args['text'] ) : '';
if ( '' === $text ) {
	return;
}
?>
<aside class="portal-documentos-notice" role="note">
	<p><?php echo esc_html( $text ); ?></p>
</aside>
