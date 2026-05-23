<?php
/**
 * Documentos institucionais — RF06.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_documentos_config();
$groups = portal_si_documentos_groups();

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--documentos" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-documentos-header">
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php
			$intro = portal_si_documentos_intro();
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

		<div class="portal-documentos-body">
			<?php
			if ( ! empty( $config['notice'] ) ) {
				get_template_part(
					'template-parts/documentos/notice',
					null,
					array( 'text' => (string) $config['notice'] )
				);
			}

			if ( ! empty( $groups ) ) {
				foreach ( $groups as $group ) {
					get_template_part(
						'template-parts/documentos/group',
						null,
						array( 'group' => $group )
					);
				}
			}
			?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
