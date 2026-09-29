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

/* —— Aviso para alunos da grade antiga (plano de transição) —— */

const PORTAL_SI_GRADE_TRANSICAO_TEXT_META = '_portal_si_grade_transicao_texto';
const PORTAL_SI_GRADE_TRANSICAO_DOC_META  = '_portal_si_grade_transicao_doc';
const PORTAL_SI_GRADE_TRANSICAO_URL_META  = '_portal_si_grade_transicao_url';

/**
 * Aviso de transição; null quando não há documento definido.
 *
 * @return array{text: string, url: string, label: string}|null
 */
function portal_si_grade_transicao() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_GRADE_SLUG );
	if ( ! $page_id ) {
		return null;
	}

	$doc_id = (int) get_post_meta( $page_id, PORTAL_SI_GRADE_TRANSICAO_DOC_META, true );
	$url    = $doc_id ? wp_get_attachment_url( $doc_id ) : '';
	if ( ! $url ) {
		$url = (string) get_post_meta( $page_id, PORTAL_SI_GRADE_TRANSICAO_URL_META, true );
	}
	if ( ! $url ) {
		return null;
	}

	$text = (string) get_post_meta( $page_id, PORTAL_SI_GRADE_TRANSICAO_TEXT_META, true );
	$ext  = strtoupper( (string) pathinfo( (string) wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION ) );

	return array(
		'text'  => $text ? $text : __( 'Alunos da grade antiga: verifiquem o documento abaixo.', 'portal-si-cefet' ),
		'url'   => $url,
		'label' => __( 'Plano de transição curricular', 'portal-si-cefet' ) . ( $ext ? ' (' . $ext . ')' : '' ),
	);
}

/**
 * Meta box na página Grade Curricular.
 *
 * @param string       $post_type Tipo.
 * @param WP_Post|null $post      Post.
 */
function portal_si_grade_add_meta_box( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post || PORTAL_SI_GRADE_SLUG !== $post->post_name ) {
		return;
	}
	add_meta_box(
		'portal-si-grade-transicao',
		__( 'Alunos da grade antiga', 'portal-si-cefet' ),
		'portal_si_grade_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_grade_add_meta_box', 10, 2 );

/**
 * @param WP_Post $post Página.
 */
function portal_si_grade_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_grade_save', 'portal_si_grade_nonce' );
	$text   = (string) get_post_meta( $post->ID, PORTAL_SI_GRADE_TRANSICAO_TEXT_META, true );
	$doc_id = (int) get_post_meta( $post->ID, PORTAL_SI_GRADE_TRANSICAO_DOC_META, true );
	$url    = (string) get_post_meta( $post->ID, PORTAL_SI_GRADE_TRANSICAO_URL_META, true );
	$doc    = $doc_id ? get_post( $doc_id ) : null;
	?>
	<p class="description">
		<?php esc_html_e( 'Aparece nas Observações da grade, com link para o plano de transição. Sem documento (arquivo ou link), o aviso não é exibido.', 'portal-si-cefet' ); ?>
	</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_si_grade_transicao_texto"><?php esc_html_e( 'Texto do aviso', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="text" class="large-text" id="portal_si_grade_transicao_texto" name="portal_si_grade_transicao_texto" value="<?php echo esc_attr( $text ); ?>" placeholder="<?php esc_attr_e( 'Alunos da grade antiga: verifiquem o documento abaixo.', 'portal-si-cefet' ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Documento', 'portal-si-cefet' ); ?></th>
			<td>
				<input type="hidden" id="portal_si_grade_transicao_doc" name="portal_si_grade_transicao_doc" value="<?php echo esc_attr( $doc_id ? $doc_id : '' ); ?>" />
				<span id="portal_si_grade_transicao_doc_name"><?php echo $doc ? esc_html( get_the_title( $doc ) ) : esc_html__( 'Nenhum arquivo escolhido.', 'portal-si-cefet' ); ?></span>
				<p>
					<button type="button" class="button" id="portal_si_grade_transicao_pick"><?php esc_html_e( 'Escolher arquivo', 'portal-si-cefet' ); ?></button>
					<button type="button" class="button-link" id="portal_si_grade_transicao_clear"><?php esc_html_e( 'Remover', 'portal-si-cefet' ); ?></button>
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_grade_transicao_url"><?php esc_html_e( 'Ou link externo', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="url" class="large-text" id="portal_si_grade_transicao_url" name="portal_si_grade_transicao_url" value="<?php echo esc_attr( $url ); ?>" placeholder="https://" />
				<p class="description"><?php esc_html_e( 'Usado só quando nenhum arquivo foi escolhido.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * @param int $post_id ID da página.
 */
function portal_si_grade_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_grade_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_grade_nonce'] ) ), 'portal_si_grade_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || PORTAL_SI_GRADE_SLUG !== $post->post_name ) {
		return;
	}

	$text = isset( $_POST['portal_si_grade_transicao_texto'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_si_grade_transicao_texto'] ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_GRADE_TRANSICAO_TEXT_META, $text );

	$doc_id = isset( $_POST['portal_si_grade_transicao_doc'] ) ? absint( $_POST['portal_si_grade_transicao_doc'] ) : 0;
	if ( $doc_id && 'attachment' === get_post_type( $doc_id ) ) {
		update_post_meta( $post_id, PORTAL_SI_GRADE_TRANSICAO_DOC_META, $doc_id );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_GRADE_TRANSICAO_DOC_META );
	}

	$url = isset( $_POST['portal_si_grade_transicao_url'] ) ? esc_url_raw( wp_unslash( $_POST['portal_si_grade_transicao_url'] ), array( 'http', 'https' ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_GRADE_TRANSICAO_URL_META, $url );
}
add_action( 'save_post_page', 'portal_si_grade_save_meta_box' );

/**
 * Seletor de mídia do aviso de transição.
 *
 * @param string $hook_suffix Tela.
 */
function portal_si_grade_admin_assets( $hook_suffix ) {
	if ( 'post.php' !== $hook_suffix ) {
		return;
	}
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id || $post_id !== (int) portal_si_get_page_id_by_slug( PORTAL_SI_GRADE_SLUG ) ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script(
		'portal-si-grade-admin',
		get_template_directory_uri() . '/assets/js/grade-admin.js',
		array( 'jquery' ),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'portal_si_grade_admin_assets' );
