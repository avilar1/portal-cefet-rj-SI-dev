<?php
/**
 * Grade curricular — disciplinas por período, pré-requisitos e ementas (RF03).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_grade_config();
$source = isset( $config['source'] ) && is_array( $config['source'] ) ? $config['source'] : array();

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--grade" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-grade-header">
			<?php if ( ! empty( $source['label'] ) ) : ?>
				<p class="portal-grade-header__badge"><?php esc_html_e( 'PPC 2025', 'portal-si-cefet' ); ?></p>
			<?php endif; ?>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_grade_intro();
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

		<div class="portal-grade-body">
			<?php
			get_template_part( 'template-parts/grade/highlights' );
			get_template_part( 'template-parts/grade/period-nav' );

			foreach ( portal_si_grade_periods() as $period ) {
				get_template_part( 'template-parts/grade/period', null, array( 'period' => $period ) );
			}

			get_template_part( 'template-parts/grade/optativas' );
			get_template_part( 'template-parts/grade/nucleos' );
			get_template_part( 'template-parts/grade/notes' );
			get_template_part( 'template-parts/grade/footer-cta' );
			?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
