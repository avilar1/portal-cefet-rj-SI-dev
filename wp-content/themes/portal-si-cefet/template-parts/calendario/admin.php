<?php
/**
 * Prazos administrativos (tabelas simplificadas).
 *
 * @package Portal_SI_CEFET
 * @var array<string, mixed>|null $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_calendario_config();
$admin  = portal_si_calendario_tpl_arg( isset( $args ) ? $args : null, 'admin', array() );
if ( empty( $admin ) && ! empty( $config['admin_deadlines'] ) ) {
	$admin = $config['admin_deadlines'];
}
$groups = isset( $admin['groups'] ) && is_array( $admin['groups'] ) ? $admin['groups'] : array();
if ( empty( $groups ) ) {
	return;
}
?>
<section class="portal-calendario-admin" aria-labelledby="portal-calendario-admin-title">
	<h2 id="portal-calendario-admin-title" class="portal-calendario-section__title">
		<?php echo esc_html( isset( $admin['title'] ) ? (string) $admin['title'] : __( 'Prazos administrativos', 'portal-si-cefet' ) ); ?>
	</h2>
	<?php if ( ! empty( $admin['note'] ) ) : ?>
		<p class="portal-calendario-admin__note"><?php echo esc_html( (string) $admin['note'] ); ?></p>
	<?php endif; ?>
	<div class="portal-calendario-admin__groups">
		<?php foreach ( $groups as $group ) : ?>
			<?php
			if ( ! is_array( $group ) || empty( $group['items'] ) ) {
				continue;
			}
			$items = is_array( $group['items'] ) ? $group['items'] : array();
			?>
			<div class="portal-calendario-admin-group br-card">
				<div class="card-content">
					<h3 class="portal-calendario-admin-group__title"><?php echo esc_html( (string) ( $group['title'] ?? '' ) ); ?></h3>
					<dl class="portal-calendario-admin-list">
						<?php foreach ( $items as $item ) : ?>
							<?php if ( ! is_array( $item ) ) { continue; } ?>
							<div class="portal-calendario-admin-list__row">
								<dt><?php echo esc_html( (string) ( $item['label'] ?? '' ) ); ?></dt>
								<dd><?php echo esc_html( (string) ( $item['period'] ?? '' ) ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
