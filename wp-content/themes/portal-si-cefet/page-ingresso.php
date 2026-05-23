<?php
/**
 * Ingresso — SISU, ENEM e matrícula (RF05).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_ingresso_config();
$course = isset( $config['course'] ) && is_array( $config['course'] ) ? $config['course'] : array();
$edition = isset( $config['edition'] ) && is_array( $config['edition'] ) ? $config['edition'] : array();

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--ingresso" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-ingresso-header">
			<p class="portal-ingresso-header__badge">
				<?php
				echo esc_html(
					isset( $edition['label'] ) ? (string) $edition['label'] : __( 'Processo seletivo', 'portal-si-cefet' )
				);
				?>
			</p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_ingresso_intro();
			if ( $intro ) :
				?>
				<p class="portal-page-header__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
			<?php if ( get_the_content() ) : ?>
				<div class="portal-page-header__intro entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
			<p class="portal-ingresso-meta">
				<?php
				$course_name = isset( $course['name'] ) ? (string) $course['name'] : __( 'Sistemas de Informação', 'portal-si-cefet' );
				$campus      = isset( $course['campus'] ) ? (string) $course['campus'] : '';
				$city        = isset( $course['city'] ) ? (string) $course['city'] : '';
				$degree      = isset( $course['degree'] ) ? (string) $course['degree'] : '';

				printf(
					/* translators: 1: course name, 2: campus, 3: city, 4: degree */
					esc_html__( '%1$s · %2$s · %3$s · %4$s', 'portal-si-cefet' ),
					esc_html( $course_name ),
					esc_html( $campus ),
					esc_html( $city ),
					esc_html( $degree )
				);
				?>
			</p>
		</header>

		<div class="portal-ingresso-body">
			<?php
			get_template_part( 'template-parts/ingresso/alert-official' );
			get_template_part( 'template-parts/ingresso/highlights' );
			get_template_part( 'template-parts/ingresso/steps' );
			get_template_part( 'template-parts/ingresso/links' );
			get_template_part( 'template-parts/ingresso/documents' );
			get_template_part( 'template-parts/ingresso/notices' );
			get_template_part( 'template-parts/ingresso/contact' );
			get_template_part( 'template-parts/ingresso/footer-cta' );
			?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
