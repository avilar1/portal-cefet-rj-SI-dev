<?php
/**
 * Um período da grade com suas disciplinas.
 *
 * @package Portal_SI_CEFET
 *
 * @var array $args { period: array{number: int, disciplines: array, cr: int, ha: int, hr: int} }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$period = isset( $args['period'] ) && is_array( $args['period'] ) ? $args['period'] : array();
if ( empty( $period['disciplines'] ) ) {
	return;
}

$number   = (int) $period['number'];
$title_id = 'periodo-' . $number . '-titulo';
?>
<section id="periodo-<?php echo (int) $number; ?>" class="portal-grade-period" aria-labelledby="<?php echo esc_attr( $title_id ); ?>">
	<header class="portal-grade-period__header">
		<h2 id="<?php echo esc_attr( $title_id ); ?>" class="portal-grade-section__title">
			<?php
			/* translators: %d: period number */
			printf( esc_html__( '%dº período', 'portal-si-cefet' ), (int) $number );
			?>
		</h2>
		<p class="portal-grade-period__summary">
			<?php
			printf(
				/* translators: 1: number of disciplines, 2: credits, 3: clock hours, 4: class hours */
				esc_html__( '%1$d disciplinas · %2$d créditos · %3$s h (%4$s horas-aula)', 'portal-si-cefet' ),
				count( $period['disciplines'] ),
				(int) $period['cr'],
				esc_html( portal_si_grade_format_number( $period['hr'] ) ),
				esc_html( portal_si_grade_format_number( $period['ha'] ) )
			);
			?>
		</p>
	</header>
	<ul class="portal-grade-list">
		<?php
		foreach ( $period['disciplines'] as $discipline ) {
			get_template_part( 'template-parts/grade/discipline', null, array( 'discipline' => $discipline ) );
		}
		?>
	</ul>
</section>
