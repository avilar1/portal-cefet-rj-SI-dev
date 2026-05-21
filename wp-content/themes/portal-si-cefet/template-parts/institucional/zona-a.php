<?php
/**
 * Zona A — Cabeçalho da área (H1 + intro).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$intro = isset( $args['intro'] ) ? (string) $args['intro'] : portal_si_institucional_intro();
?>
<header class="portal-page-header portal-inst-zona-a">
	<h1 class="portal-page-header__title entry-title"><?php the_title(); ?></h1>
	<?php if ( $intro ) : ?>
		<p class="portal-page-header__intro portal-inst-zona-a__intro">
			<?php echo esc_html( $intro ); ?>
		</p>
	<?php endif; ?>
</header>
