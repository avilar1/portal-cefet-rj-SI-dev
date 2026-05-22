<?php
/**
 * Calendário Acadêmico — resumo legível + PDF oficial (graduação / campus MG).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config   = portal_si_calendario_config();
$pdf_url  = portal_si_calendario_pdf_url();
$overview = isset( $config['year_overview'] ) && is_array( $config['year_overview'] ) ? $config['year_overview'] : array();
$details  = isset( $config['semester_details'] ) && is_array( $config['semester_details'] ) ? $config['semester_details'] : array();
$admin    = isset( $config['admin_deadlines'] ) && is_array( $config['admin_deadlines'] ) ? $config['admin_deadlines'] : array();
$related  = isset( $config['related'] ) && is_array( $config['related'] ) ? $config['related'] : array();

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--calendario" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-calendario-header">
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_calendario_intro();
			if ( $intro ) :
				?>
				<p class="portal-page-header__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
			<?php if ( get_the_content() ) : ?>
				<div class="portal-page-header__intro entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
			<p class="portal-calendario-meta">
				<?php
				printf(
					/* translators: 1: year, 2: campus, 3: audience */
					esc_html__( 'Ano letivo %1$s · %2$s · %3$s', 'portal-si-cefet' ),
					isset( $config['year'] ) ? (int) $config['year'] : 2026,
					isset( $config['campus'] ) ? esc_html( (string) $config['campus'] ) : '',
					isset( $config['audience'] ) ? esc_html( (string) $config['audience'] ) : ''
				);
				?>
			</p>
			<?php
			$revision = portal_si_calendario_portal_revision_display();
			if ( $revision ) :
				?>
				<p class="portal-calendario-portal-revision">
					<strong><?php esc_html_e( 'Informações revisadas no portal em:', 'portal-si-cefet' ); ?></strong>
					<?php echo esc_html( $revision['date'] ); ?>
					<?php if ( ! empty( $revision['author'] ) ) : ?>
						<?php
						printf(
							/* translators: %s: user display name */
							esc_html__( 'por %s', 'portal-si-cefet' ),
							esc_html( $revision['author'] )
						);
						?>
					<?php endif; ?>
				</p>
			<?php endif; ?>
		</header>
		<?php
	endwhile;
	wp_reset_postdata();
	?>

	<?php
	$calendario_tpl_args = array(
		'config'   => $config,
		'pdf_url'  => $pdf_url,
		'overview' => $overview,
		'details'  => $details,
		'admin'    => $admin,
		'related'  => $related,
	);
	?>
	<div class="portal-calendario-body">
		<?php get_template_part( 'template-parts/calendario/download', null, $calendario_tpl_args ); ?>
		<?php get_template_part( 'template-parts/calendario/overview', null, $calendario_tpl_args ); ?>
		<?php get_template_part( 'template-parts/calendario/semesters', null, $calendario_tpl_args ); ?>
		<?php get_template_part( 'template-parts/calendario/admin', null, $calendario_tpl_args ); ?>

		<?php if ( ! empty( $config['disclaimer'] ) ) : ?>
			<p class="portal-calendario-disclaimer"><?php echo esc_html( (string) $config['disclaimer'] ); ?></p>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/calendario/related', null, $calendario_tpl_args ); ?>
	</div>
</main>
<?php
get_footer();
