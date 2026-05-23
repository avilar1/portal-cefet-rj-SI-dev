<?php
/**
 * Página Agenda e Eventos — listagem completa (CPT portal_evento).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$upcoming = portal_si_get_upcoming_eventos( -1 );
$past     = portal_si_get_past_eventos( -1 );
?>
<main id="main-content" class="site-main site-main--page site-main--agenda" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<div class="portal-agenda-notice">
		<p>
			<strong><?php esc_html_e( 'Calendário acadêmico oficial', 'portal-si-cefet' ); ?></strong> —
			<?php esc_html_e( 'datas do ano letivo, recessos e prazos da graduação estão em', 'portal-si-cefet' ); ?>
			<a href="<?php echo esc_url( portal_si_page_url( 'calendario-academico' ) ); ?>">
				<?php esc_html_e( 'Calendário Acadêmico', 'portal-si-cefet' ); ?>
			</a>.
			<?php esc_html_e( 'Esta página é a agenda de eventos e atividades do curso.', 'portal-si-cefet' ); ?>
		</p>
	</div>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header">
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() || get_the_content() ) : ?>
				<div class="portal-page-header__intro entry-content">
					<?php
					if ( has_excerpt() ) {
						the_excerpt();
					}
					the_content();
					?>
				</div>
			<?php endif; ?>
		</header>
		<?php
	endwhile;
	wp_reset_postdata();
	?>

	<?php if ( empty( $upcoming ) && empty( $past ) ) : ?>
		<div class="portal-event-section__inner">
			<?php
			portal_si_the_coming_soon_notice(
				array(
					'variant' => 'section',
					'message' => __( 'Nenhum evento cadastrado no momento. Volte em breve ou acompanhe as notícias do curso.', 'portal-si-cefet' ),
				)
			);
			?>
		</div>
	<?php else : ?>
		<?php
		get_template_part(
			'template-parts/evento/section',
			null,
			array(
				'title'         => __( 'Próximos eventos', 'portal-si-cefet' ),
				'section_id'    => 'portal-agenda-proximos',
				'events'        => $upcoming,
				'variant'       => 'cards',
				'empty_message' => __( 'Nenhum evento programado. Confira o arquivo abaixo.', 'portal-si-cefet' ),
			)
		);

		if ( ! empty( $past ) ) {
			get_template_part(
				'template-parts/evento/section',
				null,
				array(
					'title'         => __( 'Eventos realizados', 'portal-si-cefet' ),
					'section_id'    => 'portal-agenda-passados',
					'events'        => $past,
					'variant'       => 'cards',
					'empty_message' => '',
				)
			);
		}
		?>
	<?php endif; ?>
</main>
<?php
get_footer();
