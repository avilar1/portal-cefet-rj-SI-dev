<?php
/**
 * Equipe.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = portal_si_fabrica_team();
$roles = isset( $block['roles'] ) ? $block['roles'] : array();
if ( empty( $roles ) ) {
	return;
}
?>
<section class="portal-fabrica-section portal-fabrica-team" id="equipe" aria-labelledby="portal-fabrica-team-title">
	<h2 id="portal-fabrica-team-title" class="portal-fabrica-section__title">
		<?php
		echo esc_html(
			! empty( $block['title'] ) ? (string) $block['title'] : __( 'Equipe', 'portal-si-cefet' )
		);
		?>
	</h2>
	<?php if ( ! empty( $block['intro'] ) ) : ?>
		<p class="portal-fabrica-section__intro"><?php echo esc_html( (string) $block['intro'] ); ?></p>
	<?php endif; ?>
	<ul class="portal-fabrica-roles">
		<?php foreach ( $roles as $role ) : ?>
			<li class="portal-fabrica-roles__item">
				<h3 class="portal-fabrica-roles__title"><?php echo esc_html( (string) $role['title'] ); ?></h3>
				<?php if ( ! empty( $role['text'] ) ) : ?>
					<p class="portal-fabrica-roles__text"><?php echo esc_html( (string) $role['text'] ); ?></p>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
