<?php
/**
 * Fábrica de Software — RF13 + RF14.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--fabrica" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-fabrica-header">
			<p class="portal-fabrica-header__badge"><?php esc_html_e( 'Extensão · Curso de SI', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_fabrica_intro();
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

		<div class="portal-fabrica-body">
			<?php
			get_template_part( 'template-parts/fabrica/highlights' );
			get_template_part( 'template-parts/fabrica/mission' );
			get_template_part( 'template-parts/fabrica/methodology' );
			get_template_part( 'template-parts/fabrica/project-types' );
			get_template_part( 'template-parts/fabrica/team' );
			get_template_part( 'template-parts/fabrica/partnership' );
			get_template_part( 'template-parts/fabrica/portfolio' );
			get_template_part( 'template-parts/fabrica/partner-cta' );
			?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
