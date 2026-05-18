<?php
/**
 * Zona 7 — Footer mapa do site (RN10).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$columns = portal_si_footer_sitemap_columns();
?>
<div class="portal-footer-sitemap">
	<div class="portal-footer-sitemap__inner">
		<div class="portal-footer-sitemap__columns">
			<?php foreach ( $columns as $column ) : ?>
				<div class="portal-footer-sitemap__col">
					<h2 class="portal-footer-sitemap__heading"><?php echo esc_html( $column['title'] ); ?></h2>
					<ul class="portal-footer-sitemap__list">
						<?php foreach ( $column['links'] as $link ) : ?>
							<li>
								<a href="<?php echo esc_url( portal_si_page_url( $link['slug'] ) ); ?>">
									<?php echo esc_html( $link['label'] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="portal-footer-sitemap__brand">
			<p class="portal-footer-sitemap__logo">CEFET/RJ</p>
			<p class="portal-footer-sitemap__course"><?php esc_html_e( 'Curso de Sistemas de Informação', 'portal-si-cefet' ); ?></p>
			<ul class="portal-footer-sitemap__social" aria-label="<?php esc_attr_e( 'Redes sociais institucionais', 'portal-si-cefet' ); ?>">
				<li>
					<a href="https://www.instagram.com/cefetrjoficial/" rel="noopener noreferrer" target="_blank">
						<?php esc_html_e( 'Instagram', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</li>
				<li>
					<a href="https://www.youtube.com/@cefetrj" rel="noopener noreferrer" target="_blank">
						<?php esc_html_e( 'YouTube', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</li>
				<li>
					<a href="https://www.linkedin.com/school/cefet-rj/" rel="noopener noreferrer" target="_blank">
						<?php esc_html_e( 'LinkedIn', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
