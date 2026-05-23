<?php
/**
 * Perfil individual do professor.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$professor = portal_si_professor_to_array( get_the_ID() );
	if ( ! $professor ) {
		continue;
	}
	?>
	<main id="main-content" class="site-main site-main--single site-main--professor" tabindex="-1">
		<?php portal_si_the_breadcrumbs(); ?>

		<div class="portal-section portal-professor-single">
			<p class="portal-professor-single__back">
				<a href="<?php echo esc_url( get_permalink( portal_si_get_page_id_by_slug( PORTAL_SI_CORPO_DOCENTE_SLUG ) ) ); ?>">
					<?php esc_html_e( '← Voltar ao corpo docente', 'portal-si-cefet' ); ?>
				</a>
			</p>
			<?php get_template_part( 'template-parts/professor/profile', null, array( 'professor' => $professor ) ); ?>
		</div>
	</main>
	<?php
endwhile;

get_footer();
