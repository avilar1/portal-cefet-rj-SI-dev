<?php
/**
 * Links relacionados (agenda ≠ calendário).
 *
 * @package Portal_SI_CEFET
 * @var array<string, mixed>|null $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config  = portal_si_calendario_config();
$related = portal_si_calendario_tpl_arg( isset( $args ) ? $args : null, 'related', array() );
if ( empty( $related ) && ! empty( $config['related'] ) ) {
	$related = $config['related'];
}
if ( empty( $related ) || ! is_array( $related ) ) {
	return;
}
?>
<aside class="portal-calendario-related" aria-labelledby="portal-calendario-related-title">
	<h2 id="portal-calendario-related-title" class="portal-calendario-section__title">
		<?php esc_html_e( 'Também no portal', 'portal-si-cefet' ); ?>
	</h2>
	<ul class="portal-calendario-related__list">
		<?php foreach ( $related as $link ) : ?>
			<?php
			if ( ! is_array( $link ) || empty( $link['slug'] ) ) {
				continue;
			}
			$url = portal_si_page_url( (string) $link['slug'] );
			?>
			<li class="portal-calendario-related__item br-card">
				<div class="card-content">
					<a class="portal-calendario-related__link" href="<?php echo esc_url( $url ); ?>">
						<?php echo esc_html( (string) ( $link['label'] ?? '' ) ); ?>
					</a>
					<?php if ( ! empty( $link['note'] ) ) : ?>
						<p class="portal-calendario-related__note"><?php echo esc_html( (string) $link['note'] ); ?></p>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</aside>
