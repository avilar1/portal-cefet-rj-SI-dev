<?php
/**
 * Listagem de notícias — página de posts (Configurações → Leitura).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$intro = portal_si_noticias_page_intro();
?>
<main id="main-content" class="site-main site-main--page site-main--noticias" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<header class="portal-page-header">
		<h1 class="portal-page-header__title"><?php echo esc_html( portal_si_noticias_page_title() ); ?></h1>
		<?php if ( $intro ) : ?>
			<p class="portal-page-header__intro"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
	</header>

	<div class="portal-noticia-page__content">
		<?php
		if ( have_posts() ) {
			$items = array();
			while ( have_posts() ) {
				the_post();
				$item = portal_si_noticia_to_array( get_the_ID() );
				if ( $item ) {
					$items[] = $item;
				}
			}
			wp_reset_postdata();

			get_template_part(
				'template-parts/noticia/grid',
				null,
				array(
					'items'         => $items,
					'show_excerpt'  => true,
					'empty_message' => __( 'Nenhuma notícia publicada ainda.', 'portal-si-cefet' ),
				)
			);

			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => __( 'Anterior', 'portal-si-cefet' ),
					'next_text' => __( 'Próxima', 'portal-si-cefet' ),
				)
			);
		} else {
			get_template_part(
				'template-parts/noticia/grid',
				null,
				array(
					'items'         => array(),
					'empty_message' => __( 'Nenhuma notícia publicada ainda. A equipa editorial pode publicar em Posts no painel.', 'portal-si-cefet' ),
				)
			);
		}
		?>
	</div>
</main>
<?php
get_footer();
