<?php
/**
 * Marcos por semestre.
 *
 * @package Portal_SI_CEFET
 * @var array<string, mixed>|null $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config  = portal_si_calendario_config();
$details = portal_si_calendario_tpl_arg( isset( $args ) ? $args : null, 'details', array() );
if ( empty( $details ) && ! empty( $config['semester_details'] ) ) {
	$details = $config['semester_details'];
}
if ( empty( $details ) || ! is_array( $details ) ) {
	return;
}
?>
<section class="portal-calendario-semesters" aria-labelledby="portal-calendario-semesters-title">
	<h2 id="portal-calendario-semesters-title" class="portal-calendario-section__title">
		<?php esc_html_e( 'Marcos do semestre', 'portal-si-cefet' ); ?>
	</h2>
	<div class="portal-calendario-semesters__grid">
		<?php foreach ( $details as $semester ) : ?>
			<?php
			if ( ! is_array( $semester ) ) {
				continue;
			}
			$milestones = isset( $semester['milestones'] ) && is_array( $semester['milestones'] ) ? $semester['milestones'] : array();
			?>
			<article class="portal-calendario-semester br-card">
				<div class="card-content">
					<h3 class="portal-calendario-semester__title"><?php echo esc_html( (string) ( $semester['title'] ?? '' ) ); ?></h3>
					<?php if ( ! empty( $semester['period'] ) ) : ?>
						<p class="portal-calendario-semester__period"><?php echo esc_html( (string) $semester['period'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $milestones ) ) : ?>
						<ul class="portal-calendario-milestones">
							<?php foreach ( $milestones as $item ) : ?>
								<?php if ( ! is_array( $item ) ) { continue; } ?>
								<li>
									<span class="portal-calendario-milestones__date"><?php echo esc_html( (string) ( $item['date'] ?? '' ) ); ?></span>
									<span class="portal-calendario-milestones__label"><?php echo esc_html( (string) ( $item['label'] ?? '' ) ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
