<?php
/**
 * Infraestrutura — RF04.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_infraestrutura_config();
$campus = isset( $config['campus'] ) && is_array( $config['campus'] ) ? $config['campus'] : array();

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--infraestrutura" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-infra-header">
			<p class="portal-infra-header__badge"><?php esc_html_e( 'Campus Maria da Graça', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_infraestrutura_intro();
			if ( $intro ) :
				?>
				<p class="portal-page-header__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
			<?php if ( get_the_content() ) : ?>
				<div class="portal-page-header__intro entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $campus['address'] ) ) : ?>
				<p class="portal-infra-meta">
					<?php
					echo esc_html( (string) $campus['address'] );
					if ( ! empty( $campus['cep'] ) ) {
						echo ' · CEP ' . esc_html( (string) $campus['cep'] );
					}
					?>
					<?php if ( function_exists( 'portal_si_infraestrutura_map' ) && portal_si_infraestrutura_map() ) : ?>
						·
						<a class="portal-infra-meta__map-jump" href="#como-chegar-mapa">
							<?php esc_html_e( 'Ver mapa', 'portal-si-cefet' ); ?>
						</a>
					<?php endif; ?>
				</p>
			<?php endif; ?>
		</header>

		<div class="portal-infra-body">
			<?php
			get_template_part( 'template-parts/infraestrutura/campus-access' );
			get_template_part( 'template-parts/infraestrutura/highlights' );

			$sections = portal_si_infraestrutura_sections();
			foreach ( $sections as $section ) {
				get_template_part(
					'template-parts/infraestrutura/section',
					null,
					array( 'section' => $section )
				);
			}

			get_template_part( 'template-parts/infraestrutura/links' );
			get_template_part( 'template-parts/infraestrutura/footer-cta' );
			?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
