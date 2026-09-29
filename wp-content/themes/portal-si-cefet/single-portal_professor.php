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

			<?php $projetos = portal_si_get_projetos_do_professor( $professor['id'] ); ?>
			<?php if ( $projetos ) : ?>
				<section class="professor-profile__projetos" aria-labelledby="professor-projetos-title">
					<h2 id="professor-projetos-title" class="portal-pesquisa-section__title"><?php esc_html_e( 'Projetos coordenados', 'portal-si-cefet' ); ?></h2>
					<?php get_template_part( 'template-parts/projeto/grid', null, array( 'items' => $projetos ) ); ?>
				</section>
			<?php endif; ?>

			<?php $tccs = portal_si_get_tccs_do_professor( $professor['id'] ); ?>
			<?php if ( $tccs ) : ?>
				<section class="professor-profile__tccs" aria-labelledby="professor-tccs-title">
					<h2 id="professor-tccs-title" class="professor-profile__tccs-title"><?php esc_html_e( 'TCCs orientados', 'portal-si-cefet' ); ?></h2>
					<ul class="portal-tcc-list">
						<?php foreach ( $tccs as $tcc ) : ?>
							<?php get_template_part( 'template-parts/tcc/item', null, array( 'tcc' => $tcc ) ); ?>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>
		</div>
	</main>
	<?php
endwhile;

get_footer();
