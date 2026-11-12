<?php
/**
 * Dúvidas frequentes — orientação curta (H10).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--duvidas" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<header class="portal-page-header">
		<h1 class="portal-page-header__title"><?php esc_html_e( 'Dúvidas frequentes', 'portal-si-cefet' ); ?></h1>
		<p class="portal-page-header__intro">
			<?php esc_html_e( 'Respostas curtas sobre ingresso, datas, contato e o que este portal faz. Se a sua dúvida não estiver aqui, fale com a coordenação.', 'portal-si-cefet' ); ?>
		</p>
	</header>

	<ul class="portal-help-list">
		<?php foreach ( portal_si_duvidas_items() as $item ) : ?>
			<li class="portal-help-item" id="<?php echo esc_attr( 'duvida-' . $item['id'] ); ?>">
				<h2><?php echo esc_html( $item['question'] ); ?></h2>
				<p><?php echo esc_html( $item['answer'] ); ?></p>
				<?php if ( ! empty( $item['url'] ) ) : ?>
					<p>
						<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['link_label'] ); ?></a>
					</p>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
	while ( have_posts() ) :
		the_post();
		if ( function_exists( 'portal_si_post_has_meaningful_content' ) && portal_si_post_has_meaningful_content( get_post() ) ) :
			?>
			<div class="entry-content"><?php the_content(); ?></div>
			<?php
		endif;
	endwhile;
	?>
</main>
<?php
get_footer();
