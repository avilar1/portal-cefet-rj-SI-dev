<?php
/**
 * Contato — RF27, RF29.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--contato" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-contato-header">
			<p class="portal-contato-header__badge"><?php esc_html_e( 'Atendimento', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_contato_intro();
			if ( $intro ) :
				?>
				<p class="portal-page-header__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
			<?php if ( get_the_content() ) : ?>
				<div class="portal-page-header__intro entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</header>

		<div class="portal-contato-body">
			<?php
			get_template_part( 'template-parts/contato/coordination' );
			get_template_part( 'template-parts/contato/form' );
			get_template_part( 'template-parts/contato/map' );
			get_template_part( 'template-parts/contato/channels' );
			get_template_part( 'template-parts/contato/partner-fabrica' );
			get_template_part( 'template-parts/contato/ouvidoria' );
			?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
