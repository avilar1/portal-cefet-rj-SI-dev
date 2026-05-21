<?php
/**
 * Zona A — Hero institucional (fundo azul).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$intro = isset( $args['intro'] ) ? (string) $args['intro'] : portal_si_sobre_intro();
?>
<section class="portal-sobre-hero" aria-labelledby="portal-sobre-hero-title">
	<div class="portal-sobre-hero__inner">
		<?php portal_si_the_breadcrumbs(); ?>
		<h1 id="portal-sobre-hero-title" class="portal-sobre-hero__title"><?php the_title(); ?></h1>
		<?php if ( $intro ) : ?>
			<p class="portal-sobre-hero__intro"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
	</div>
</section>
