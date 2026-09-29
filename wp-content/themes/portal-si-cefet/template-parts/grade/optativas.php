<?php
/**
 * Disciplinas optativas.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$optativas = portal_si_grade_optativas();
if ( empty( $optativas ) ) {
	return;
}

$config  = portal_si_grade_config();
$min_ha  = isset( $config['optativas_min_ha'] ) ? (int) $config['optativas_min_ha'] : 0;
?>
<section id="optativas" class="portal-grade-period portal-grade-optativas" aria-labelledby="optativas-titulo">
	<header class="portal-grade-period__header">
		<h2 id="optativas-titulo" class="portal-grade-section__title"><?php esc_html_e( 'Disciplinas optativas', 'portal-si-cefet' ); ?></h2>
		<?php if ( $min_ha ) : ?>
			<p class="portal-grade-period__summary">
				<?php
				printf(
					/* translators: %s: minimum class hours */
					esc_html__( 'O aluno deve cursar no mínimo %s horas-aula em optativas, a partir do 6º período. A oferta de cada semestre é definida pela coordenação.', 'portal-si-cefet' ),
					esc_html( portal_si_grade_format_number( $min_ha ) )
				);
				?>
			</p>
		<?php endif; ?>
	</header>
	<ul class="portal-grade-list">
		<?php
		foreach ( $optativas as $discipline ) {
			get_template_part( 'template-parts/grade/discipline', null, array( 'discipline' => $discipline ) );
		}
		?>
	</ul>
</section>
