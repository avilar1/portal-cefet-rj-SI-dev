<?php
/**
 * Documentação para matrícula (resumo do edital).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_ingresso_config();
$docs   = isset( $config['documents'] ) && is_array( $config['documents'] ) ? $config['documents'] : array();
$items  = isset( $docs['items'] ) && is_array( $docs['items'] ) ? $docs['items'] : array();

if ( empty( $items ) ) {
	return;
}
?>
<section class="portal-ingresso-documents" aria-labelledby="portal-ingresso-documents-title">
	<div class="portal-ingresso-documents__inner">
		<h2 id="portal-ingresso-documents-title" class="portal-ingresso-section__title">
			<?php esc_html_e( 'Documentação na matrícula', 'portal-si-cefet' ); ?>
		</h2>
		<?php if ( ! empty( $docs['intro'] ) ) : ?>
			<p class="portal-ingresso-documents__intro"><?php echo esc_html( (string) $docs['intro'] ); ?></p>
		<?php endif; ?>
		<ul class="portal-ingresso-documents__list">
			<?php foreach ( $items as $item ) : ?>
				<?php if ( '' === trim( (string) $item ) ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<li><?php echo esc_html( (string) $item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
