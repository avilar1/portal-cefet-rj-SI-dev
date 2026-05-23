<?php
/**
 * Portfólio de projetos — RF14.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = portal_si_fabrica_portfolio();
$items = isset( $block['items'] ) ? $block['items'] : array();
$title = ! empty( $block['title'] ) ? (string) $block['title'] : __( 'Projetos desenvolvidos', 'portal-si-cefet' );
?>
<section class="portal-fabrica-section portal-fabrica-portfolio" id="projetos" aria-labelledby="portal-fabrica-portfolio-title">
	<h2 id="portal-fabrica-portfolio-title" class="portal-fabrica-section__title">
		<?php echo esc_html( $title ); ?>
	</h2>
	<?php if ( ! empty( $block['intro'] ) ) : ?>
		<p class="portal-fabrica-section__intro"><?php echo esc_html( (string) $block['intro'] ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $items ) ) : ?>
		<ul class="portal-fabrica-portfolio__list">
			<?php foreach ( $items as $project ) : ?>
				<?php
				get_template_part(
					'template-parts/fabrica/project-card',
					null,
					array( 'project' => $project )
				);
				?>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<div class="portal-fabrica-portfolio-empty">
			<p><?php esc_html_e( 'Nenhum projeto publicado ainda.', 'portal-si-cefet' ); ?></p>
			<?php if ( current_user_can( 'edit_posts' ) ) : ?>
				<p>
					<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . PORTAL_SI_FABRICA_PROJETO_POST_TYPE ) ); ?>">
						<?php esc_html_e( 'Adicionar primeiro projeto', 'portal-si-cefet' ); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</section>
