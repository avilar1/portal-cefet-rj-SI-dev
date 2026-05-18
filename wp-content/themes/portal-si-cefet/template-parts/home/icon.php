<?php
/**
 * Ícones SVG da home.
 *
 * @var string $icon clipboard|calendar|graduation|teacher|megaphone|document.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $args ) && is_array( $args ) && isset( $args['icon'] ) ) {
	$icon = $args['icon'];
} elseif ( ! isset( $icon ) ) {
	$icon = '';
}
?>
<svg class="portal-service-card__icon-svg" width="32" height="32" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
	<?php if ( 'clipboard' === $icon ) : ?>
		<path fill="currentColor" d="M9 2a2 2 0 0 0-2 2H5a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2a2 2 0 0 0-2-2H9zm0 2h6v2H9V4zm-4 4h14v11H5V8zm3 2v2h8v-2H8zm0 4v2h5v-2H8z"/>
	<?php elseif ( 'calendar' === $icon ) : ?>
		<path fill="currentColor" d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 16H5V10h14v10zM5 8V6h14v2H5z"/>
	<?php elseif ( 'graduation' === $icon ) : ?>
		<path fill="currentColor" d="M12 3 1 9l11 6 9-4.91V17h2V9L12 3zm7 11.5-7 3.85-7-3.85V18l7 4 7-4v-3.5z"/>
	<?php elseif ( 'teacher' === $icon ) : ?>
		<path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5zm7 8H5v-.23c.22-.69 2.53-2.77 7-2.77s6.78 2.08 7 2.77V22z"/>
	<?php elseif ( 'megaphone' === $icon ) : ?>
		<path fill="currentColor" d="M18 11V8l4-2v10l-4-2v-3H6v6H4V5h14v6h0zM8 14h8v2H8v-2zm0 4h6v2H8v-2z"/>
	<?php elseif ( 'document' === $icon ) : ?>
		<path fill="currentColor" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2 5 5h-5V4zM6 20V4h6v6h6v10H6z"/>
	<?php else : ?>
		<path fill="currentColor" d="M12 2 2 7l10 5 10-5-10-5zm0 2.18L18.82 7 12 10.82 5.18 7 12 4.18zM2 17l10 5 10-5M2 12l10 5 10-5"/>
	<?php endif; ?>
</svg>
