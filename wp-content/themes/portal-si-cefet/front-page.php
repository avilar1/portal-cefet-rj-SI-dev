<?php
/**
 * Página inicial — layout MVP (8 zonas; conteúdo nas zonas 4–6).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--home" tabindex="-1">
	<?php
	get_template_part( 'template-parts/home/hero' );
	get_template_part(
		'template-parts/home/section-divider',
		null,
		array(
			'label' => __( 'Acesso Rápido', 'portal-si-cefet' ),
			'id'    => 'portal-service-links-title',
		)
	);
	get_template_part( 'template-parts/home/service-links' );
	get_template_part(
		'template-parts/home/section-divider',
		null,
		array(
			'label' => __( 'Notícias e Agenda', 'portal-si-cefet' ),
			'id'    => 'portal-news-agenda-title',
		)
	);
	get_template_part( 'template-parts/home/news-agenda' );
	?>
</main>
<?php
get_footer();
