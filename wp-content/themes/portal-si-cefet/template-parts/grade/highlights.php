<?php
/**
 * Destaques do curso (duração, carga horária, turno, conceito).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = portal_si_grade_highlights();
if ( empty( $stats ) ) {
	return;
}
?>
<section class="portal-grade-highlights" aria-label="<?php esc_attr_e( 'Resumo do curso', 'portal-si-cefet' ); ?>">
	<ul class="portal-grade-highlights__list">
		<?php foreach ( $stats as $stat ) : ?>
			<li class="portal-grade-highlights__item br-card">
				<div class="card-content portal-grade-highlights__content">
					<span class="portal-grade-highlights__value"><?php echo esc_html( $stat['value'] ); ?></span>
					<span class="portal-grade-highlights__label"><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
