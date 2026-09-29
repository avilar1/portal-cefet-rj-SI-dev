<?php
/**
 * Grade curricular — RF03.
 *
 * Disciplinas editáveis no painel (inc/disciplina.php); destaques, núcleos, vagas de optativa
 * e observações em data/grade-curricular.php (PPC). Intro opcional no excerpt da página WP.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_GRADE_SLUG', 'grade-curricular' );

/**
 * Configuração da grade curricular.
 *
 * @return array<string, mixed>
 */
function portal_si_grade_config() {
	static $config = null;

	if ( null !== $config ) {
		return $config;
	}

	$path = get_template_directory() . '/data/grade-curricular.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$config = apply_filters( 'portal_si_grade_config', $loaded );
			return $config;
		}
	}

	$config = apply_filters( 'portal_si_grade_config', array() );
	return $config;
}

/**
 * Intro — excerpt da página ou fallback.
 *
 * @return string
 */
function portal_si_grade_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_GRADE_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}

	$config = portal_si_grade_config();
	return isset( $config['intro_default'] ) ? (string) $config['intro_default'] : '';
}

/**
 * Destaques numéricos do curso.
 *
 * @return array<int, array{value: string, label: string}>
 */
function portal_si_grade_highlights() {
	$config = portal_si_grade_config();
	$rows   = isset( $config['highlights'] ) && is_array( $config['highlights'] ) ? $config['highlights'] : array();
	$out    = array();

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$value = isset( $row['value'] ) ? trim( (string) $row['value'] ) : '';
		$label = isset( $row['label'] ) ? trim( (string) $row['label'] ) : '';
		if ( '' === $value && '' === $label ) {
			continue;
		}
		$out[] = array(
			'value' => $value,
			'label' => $label,
		);
	}

	return $out;
}

/**
 * Normaliza uma disciplina (obrigatória, optativa ou vaga de optativa no período).
 *
 * @param array<string, mixed> $row    Linha do arquivo de dados.
 * @param string               $nucleo Núcleo padrão quando a linha não define.
 * @return array<string, mixed>|null
 */
function portal_si_grade_normalize_discipline( $row, $nucleo = '' ) {
	if ( ! is_array( $row ) ) {
		return null;
	}

	$is_slot = ! empty( $row['optativa'] );
	$code    = isset( $row['code'] ) ? strtoupper( trim( (string) $row['code'] ) ) : '';
	$name    = isset( $row['name'] ) ? trim( (string) $row['name'] ) : '';

	if ( ! $is_slot && ( '' === $code || '' === $name ) ) {
		return null;
	}

	$pre = array();
	if ( isset( $row['pre'] ) && is_array( $row['pre'] ) ) {
		foreach ( $row['pre'] as $pre_code ) {
			$pre_code = strtoupper( trim( (string) $pre_code ) );
			if ( '' !== $pre_code && $pre_code !== $code ) {
				$pre[] = $pre_code;
			}
		}
	}

	return array(
		'slot'   => $is_slot,
		'code'   => $code,
		'name'   => $name,
		't'      => isset( $row['t'] ) ? (int) $row['t'] : 0,
		'p'      => isset( $row['p'] ) ? (int) $row['p'] : 0,
		'cr'     => isset( $row['cr'] ) ? (int) $row['cr'] : 0,
		'ha'     => isset( $row['ha'] ) ? (int) $row['ha'] : 0,
		'hr'     => isset( $row['hr'] ) ? (int) $row['hr'] : 0,
		'pre'    => array_values( array_unique( $pre ) ),
		'nucleo' => isset( $row['nucleo'] ) ? sanitize_key( $row['nucleo'] ) : $nucleo,
		'ementa' => isset( $row['ementa'] ) ? trim( (string) $row['ementa'] ) : '',
	);
}

/**
 * Linhas brutas da grade: disciplinas do painel (CPT) quando houver, senão o arquivo de dados.
 * Vagas de optativa por período vêm sempre do arquivo, na posição em que aparecem lá.
 *
 * @return array{periods: array<int, array>, optativas: array}
 */
function portal_si_grade_source() {
	static $source = null;

	if ( null !== $source ) {
		return $source;
	}

	$config       = portal_si_grade_config();
	$file_periods = isset( $config['periods'] ) && is_array( $config['periods'] ) ? $config['periods'] : array();
	$cpt          = function_exists( 'portal_si_disciplina_rows' ) ? portal_si_disciplina_rows() : null;

	if ( ! $cpt ) {
		$source = array(
			'periods'   => $file_periods,
			'optativas' => isset( $config['optativas'] ) && is_array( $config['optativas'] ) ? $config['optativas'] : array(),
		);
		return $source;
	}

	foreach ( $file_periods as $number => $items ) {
		foreach ( (array) $items as $index => $item ) {
			if ( is_array( $item ) && ! empty( $item['optativa'] ) ) {
				if ( ! isset( $cpt['periods'][ $number ] ) ) {
					$cpt['periods'][ $number ] = array();
				}
				array_splice( $cpt['periods'][ $number ], min( $index, count( $cpt['periods'][ $number ] ) ), 0, array( $item ) );
			}
		}
	}
	ksort( $cpt['periods'] );

	$source = $cpt;
	return $source;
}

/**
 * Períodos com disciplinas normalizadas e totais calculados.
 *
 * @return array<int, array{number: int, disciplines: array<int, array<string, mixed>>, cr: int, ha: int, hr: int}>
 */
function portal_si_grade_periods() {
	static $periods = null;

	if ( null !== $periods ) {
		return $periods;
	}

	$source  = portal_si_grade_source();
	$rows    = $source['periods'];
	$periods = array();

	foreach ( $rows as $number => $items ) {
		if ( ! is_array( $items ) ) {
			continue;
		}

		$disciplines = array();
		$totals      = array(
			'cr' => 0,
			'ha' => 0,
			'hr' => 0,
		);

		foreach ( $items as $item ) {
			$disc = portal_si_grade_normalize_discipline( $item );
			if ( ! $disc ) {
				continue;
			}
			$disciplines[] = $disc;
			$totals['cr'] += $disc['cr'];
			$totals['ha'] += $disc['ha'];
			$totals['hr'] += $disc['hr'];
		}

		if ( empty( $disciplines ) ) {
			continue;
		}

		$periods[] = array(
			'number'      => (int) $number,
			'disciplines' => $disciplines,
			'cr'          => $totals['cr'],
			'ha'          => $totals['ha'],
			'hr'          => $totals['hr'],
		);
	}

	return $periods;
}

/**
 * Disciplinas optativas normalizadas.
 *
 * @return array<int, array<string, mixed>>
 */
function portal_si_grade_optativas() {
	static $optativas = null;

	if ( null !== $optativas ) {
		return $optativas;
	}

	$source    = portal_si_grade_source();
	$rows      = $source['optativas'];
	$optativas = array();

	foreach ( $rows as $row ) {
		$disc = portal_si_grade_normalize_discipline( $row, 'optativa' );
		if ( $disc && ! $disc['slot'] ) {
			$optativas[] = $disc;
		}
	}

	return $optativas;
}

/**
 * Índice código → nome e período (0 = optativa).
 *
 * @return array<string, array{name: string, period: int}>
 */
function portal_si_grade_index() {
	static $index = null;

	if ( null !== $index ) {
		return $index;
	}

	$index = array();

	foreach ( portal_si_grade_periods() as $period ) {
		foreach ( $period['disciplines'] as $disc ) {
			if ( ! $disc['slot'] ) {
				$index[ $disc['code'] ] = array(
					'name'   => $disc['name'],
					'period' => $period['number'],
				);
			}
		}
	}

	foreach ( portal_si_grade_optativas() as $disc ) {
		$index[ $disc['code'] ] = array(
			'name'   => $disc['name'],
			'period' => 0,
		);
	}

	return $index;
}

/**
 * Mapa inverso: código → disciplinas que o exigem como pré-requisito.
 *
 * @return array<string, string[]>
 */
function portal_si_grade_unlocks() {
	static $unlocks = null;

	if ( null !== $unlocks ) {
		return $unlocks;
	}

	$unlocks = array();
	$all     = portal_si_grade_optativas();

	foreach ( portal_si_grade_periods() as $period ) {
		$all = array_merge( $all, $period['disciplines'] );
	}

	foreach ( $all as $disc ) {
		if ( $disc['slot'] ) {
			continue;
		}
		foreach ( $disc['pre'] as $pre_code ) {
			$unlocks[ $pre_code ][] = $disc['code'];
		}
	}

	return $unlocks;
}

/**
 * Núcleos de conteúdo (rótulo e carga horária).
 *
 * @return array<string, array{label: string, ha: int, hr: int, pct: string, note: string}>
 */
function portal_si_grade_nucleos() {
	$config = portal_si_grade_config();
	$rows   = isset( $config['nucleos'] ) && is_array( $config['nucleos'] ) ? $config['nucleos'] : array();
	$out    = array();

	foreach ( $rows as $key => $row ) {
		if ( ! is_array( $row ) || empty( $row['label'] ) ) {
			continue;
		}
		$out[ sanitize_key( $key ) ] = array(
			'label' => (string) $row['label'],
			'ha'    => isset( $row['ha'] ) ? (int) $row['ha'] : 0,
			'hr'    => isset( $row['hr'] ) ? (int) $row['hr'] : 0,
			'pct'   => isset( $row['pct'] ) ? (string) $row['pct'] : '',
			'note'  => isset( $row['note'] ) ? (string) $row['note'] : '',
		);
	}

	return $out;
}

/**
 * Rótulo do núcleo.
 *
 * @param string $key Chave do núcleo.
 * @return string
 */
function portal_si_grade_nucleo_label( $key ) {
	$nucleos = portal_si_grade_nucleos();
	return isset( $nucleos[ $key ] ) ? $nucleos[ $key ]['label'] : '';
}

/**
 * ID de âncora de uma disciplina.
 *
 * @param string $code Código da disciplina.
 * @return string
 */
function portal_si_grade_anchor( $code ) {
	return 'disciplina-' . sanitize_title( $code );
}

/**
 * Número de horas no formato brasileiro (3.110).
 *
 * @param int $value Horas.
 * @return string
 */
function portal_si_grade_format_number( $value ) {
	return number_format_i18n( (int) $value );
}

/**
 * Classe no body.
 *
 * @param string[] $classes Classes do body.
 * @return string[]
 */
function portal_si_grade_body_class( $classes ) {
	if ( is_page( PORTAL_SI_GRADE_SLUG ) ) {
		$classes[] = 'portal-is-grade';
	}
	return $classes;
}
add_filter( 'body_class', 'portal_si_grade_body_class' );

/**
 * CSS da página Grade Curricular.
 */
function portal_si_grade_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_GRADE_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-grade',
		get_template_directory_uri() . '/assets/css/grade-curricular.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_grade_enqueue_assets', 16 );
