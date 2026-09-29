<?php
/**
 * Distribuição da carga horária por núcleo de conteúdo.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nucleos = portal_si_grade_nucleos();
if ( empty( $nucleos ) ) {
	return;
}

$total_ha = 0;
$total_hr = 0;
$notes    = array();
foreach ( $nucleos as $nucleo ) {
	$total_ha += $nucleo['ha'];
	$total_hr += $nucleo['hr'];
	if ( $nucleo['note'] ) {
		$notes[] = $nucleo['note'];
	}
}
?>
<section id="carga-horaria" class="portal-grade-period portal-grade-nucleos" aria-labelledby="carga-horaria-titulo">
	<header class="portal-grade-period__header">
		<h2 id="carga-horaria-titulo" class="portal-grade-section__title"><?php esc_html_e( 'Carga horária por núcleo', 'portal-si-cefet' ); ?></h2>
	</header>
	<div class="portal-grade-table-wrap">
		<table class="portal-grade-table">
			<caption class="screen-reader-text"><?php esc_html_e( 'Distribuição da carga horária do curso por núcleo de conteúdo', 'portal-si-cefet' ); ?></caption>
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'Núcleo', 'portal-si-cefet' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Horas-aula', 'portal-si-cefet' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Horas', 'portal-si-cefet' ); ?></th>
					<th scope="col"><?php esc_html_e( '% do curso', 'portal-si-cefet' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $nucleos as $key => $nucleo ) : ?>
					<tr>
						<th scope="row">
							<span class="portal-grade-chip portal-grade-chip--<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $nucleo['label'] ); ?></span>
						</th>
						<td><?php echo esc_html( portal_si_grade_format_number( $nucleo['ha'] ) ); ?></td>
						<td><?php echo esc_html( portal_si_grade_format_number( $nucleo['hr'] ) ); ?></td>
						<td><?php echo esc_html( $nucleo['pct'] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<th scope="row"><?php esc_html_e( 'Total', 'portal-si-cefet' ); ?></th>
					<td><?php echo esc_html( portal_si_grade_format_number( $total_ha ) ); ?></td>
					<td><?php echo esc_html( portal_si_grade_format_number( $total_hr ) ); ?></td>
					<td>100%</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<?php foreach ( $notes as $note ) : ?>
		<p class="portal-grade-nucleos__note"><?php echo esc_html( $note ); ?></p>
	<?php endforeach; ?>
</section>
