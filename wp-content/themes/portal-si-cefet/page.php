<?php
/**
 * Página genérica — breadcrumbs + conteúdo do editor.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'entry entry--page' ); ?>>
			<header class="portal-page-header">
				<h1 class="portal-page-header__title entry-title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="portal-page-header__intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</header>
			<div class="entry-content">
				<?php
				if ( portal_si_post_has_meaningful_content( get_post() ) ) {
					the_content();
				} else {
					portal_si_the_coming_soon_notice(
						array(
							'variant' => 'page',
							'badge'   => in_array( get_post()->post_name, portal_si_coming_soon_page_slugs(), true )
								? __( 'Em construção', 'portal-si-cefet' )
								: __( 'Conteúdo em breve', 'portal-si-cefet' ),
							'message' => portal_si_coming_soon_message_for_slug( get_post()->post_name ),
						)
					);
				}
				?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
