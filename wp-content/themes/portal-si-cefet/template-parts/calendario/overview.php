<?php
/**
 * Visão geral do ano letivo (cartões).
 *
 * @package Portal_SI_CEFET
 * @var array<string, mixed>|null $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config   = portal_si_calendario_config();
$overview = portal_si_calendario_tpl_arg( isset( $args ) ? $args : null, 'overview', array() );
if ( empty( $overview ) && ! empty( $config['year_overview'] ) ) {
	$overview = $config['year_overview'];
}
if ( empty( $overview ) || ! is_array( $overview ) ) {
	return;
}

$year = isset( $config['year'] ) ? (int) $config['year'] : 2026;
?>
<section class="portal-calendario-overview" aria-labelledby="portal-calendario-overview-title">
	<h2 id="portal-calendario-overview-title" class="portal-calendario-section__title">
		<?php
		printf(
			/* translators: %d: academic year */
			esc_html__( 'Visão geral de %d', 'portal-si-cefet' ),
			$year
		);
		?>
	</h2>
	<ul class="portal-calendario-overview__list">
		<?php foreach ( $overview as $block ) : ?>
			<?php
			if ( ! is_array( $block ) ) {
				continue;
			}
			$accent = isset( $block['accent'] ) && 'primary' === $block['accent'] ? 'primary' : 'neutral';
			?>
			<li class="portal-calendario-overview__item portal-calendario-overview__item--<?php echo esc_attr( $accent ); ?> br-card">
				<div class="card-content">
					<h3 class="portal-calendario-overview__label"><?php echo esc_html( (string) ( $block['label'] ?? '' ) ); ?></h3>
					<p class="portal-calendario-overview__period"><?php echo esc_html( (string) ( $block['period'] ?? '' ) ); ?></p>
					<?php if ( ! empty( $block['detail'] ) ) : ?>
						<p class="portal-calendario-overview__detail"><?php echo esc_html( (string) $block['detail'] ); ?></p>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
