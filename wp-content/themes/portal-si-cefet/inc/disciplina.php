<?php
/**
 * Disciplinas — CPT editável pela coordenação (RF03).
 *
 * Na primeira execução, importa as disciplinas de data/grade-curricular.php.
 * Depois disso, o painel é a fonte da grade; o arquivo segue definindo as vagas
 * de optativa por período, destaques, núcleos e observações.
 * Rascunho = disciplina fora do site sem ser apagada.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_DISCIPLINA_POST_TYPE = 'portal_disciplina';

const PORTAL_SI_DISCIPLINA_CODE_META     = '_portal_disciplina_code';
const PORTAL_SI_DISCIPLINA_PERIOD_META   = '_portal_disciplina_period';
const PORTAL_SI_DISCIPLINA_THEORY_META   = '_portal_disciplina_theory';
const PORTAL_SI_DISCIPLINA_PRACTICE_META = '_portal_disciplina_practice';
const PORTAL_SI_DISCIPLINA_NUCLEO_META   = '_portal_disciplina_nucleo';
const PORTAL_SI_DISCIPLINA_PREREQS_META  = '_portal_disciplina_prereqs';
const PORTAL_SI_DISCIPLINA_EMENTA_META   = '_portal_disciplina_ementa';

const PORTAL_SI_DISCIPLINA_IMPORTED_OPTION = 'portal_si_disciplinas_imported';

/** Horas-aula (50 min) por crédito. */
const PORTAL_SI_DISCIPLINA_HA_PER_CREDIT = 18;

/**
 * Registra CPT Disciplina.
 */
function portal_si_register_disciplina_cpt() {
	register_post_type(
		PORTAL_SI_DISCIPLINA_POST_TYPE,
		array(
			'labels'             => array(
				'name'               => __( 'Disciplinas', 'portal-si-cefet' ),
				'singular_name'      => __( 'Disciplina', 'portal-si-cefet' ),
				'add_new'            => __( 'Adicionar disciplina', 'portal-si-cefet' ),
				'add_new_item'       => __( 'Adicionar nova disciplina', 'portal-si-cefet' ),
				'edit_item'          => __( 'Editar disciplina', 'portal-si-cefet' ),
				'new_item'           => __( 'Nova disciplina', 'portal-si-cefet' ),
				'search_items'       => __( 'Buscar disciplinas', 'portal-si-cefet' ),
				'not_found'          => __( 'Nenhuma disciplina encontrada.', 'portal-si-cefet' ),
				'not_found_in_trash' => __( 'Nenhuma disciplina na lixeira.', 'portal-si-cefet' ),
				'menu_name'          => __( 'Disciplinas', 'portal-si-cefet' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-book-alt',
			'menu_position'      => 28,
			'has_archive'        => false,
			'rewrite'            => false,
			'supports'           => array( 'title', 'page-attributes' ),
			'show_in_rest'       => false,
			'capability_type'    => 'post',
		)
	);
}
add_action( 'init', 'portal_si_register_disciplina_cpt' );

/**
 * Placeholder do título.
 *
 * @param string  $text Texto padrão.
 * @param WP_Post $post Post atual.
 * @return string
 */
function portal_si_disciplina_title_placeholder( $text, $post ) {
	if ( PORTAL_SI_DISCIPLINA_POST_TYPE === $post->post_type ) {
		return __( 'Nome da disciplina', 'portal-si-cefet' );
	}
	return $text;
}
add_filter( 'enter_title_here', 'portal_si_disciplina_title_placeholder', 10, 2 );

/**
 * Núcleos que uma disciplina pode ter.
 *
 * @return array<string, string> chave => rótulo
 */
function portal_si_disciplina_nucleo_options() {
	$out = array();
	foreach ( portal_si_grade_nucleos() as $key => $nucleo ) {
		if ( 'complementar' !== $key ) {
			$out[ $key ] = $nucleo['label'];
		}
	}
	return $out;
}

/**
 * Rótulo do período (0 = optativa).
 *
 * @param int $period Período.
 * @return string
 */
function portal_si_disciplina_period_label( $period ) {
	$period = (int) $period;
	if ( 0 === $period ) {
		return __( 'Optativa', 'portal-si-cefet' );
	}
	/* translators: %d: period number */
	return sprintf( __( '%dº período', 'portal-si-cefet' ), $period );
}

/**
 * Meta box — dados da disciplina.
 */
function portal_si_disciplina_add_meta_boxes() {
	add_meta_box(
		'portal-disciplina-dados',
		__( 'Dados da disciplina', 'portal-si-cefet' ),
		'portal_si_disciplina_render_meta_box',
		PORTAL_SI_DISCIPLINA_POST_TYPE,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_disciplina_add_meta_boxes' );

/**
 * @param WP_Post $post Post atual.
 */
function portal_si_disciplina_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_disciplina_save', 'portal_si_disciplina_nonce' );

	$code     = (string) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_CODE_META, true );
	$period   = get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_PERIOD_META, true );
	$period   = '' === $period ? 1 : (int) $period;
	$theory   = (int) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_THEORY_META, true );
	$practice = (int) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_PRACTICE_META, true );
	$nucleo   = (string) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_NUCLEO_META, true );
	$ementa   = (string) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_EMENTA_META, true );
	$prereqs  = array_map( 'intval', (array) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_PREREQS_META, true ) );

	$others = get_posts(
		array(
			'post_type'      => PORTAL_SI_DISCIPLINA_POST_TYPE,
			'post_status'    => array( 'publish', 'draft' ),
			'posts_per_page' => -1,
			'post__not_in'   => array( $post->ID ),
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	);

	$grouped = array();
	foreach ( $others as $other ) {
		$other_period               = (int) get_post_meta( $other->ID, PORTAL_SI_DISCIPLINA_PERIOD_META, true );
		$grouped[ $other_period ][] = $other;
	}
	ksort( $grouped );
	if ( isset( $grouped[0] ) ) {
		$optativas = $grouped[0];
		unset( $grouped[0] );
		$grouped[0] = $optativas;
	}
	?>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_disciplina_code"><?php esc_html_e( 'Código', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="text" class="regular-text" id="portal_disciplina_code" name="portal_disciplina_code" value="<?php echo esc_attr( $code ); ?>" placeholder="SIAE101" required style="text-transform:uppercase" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_disciplina_period"><?php esc_html_e( 'Período', 'portal-si-cefet' ); ?></label></th>
			<td>
				<select id="portal_disciplina_period" name="portal_disciplina_period">
					<?php for ( $i = 1; $i <= 8; $i++ ) : ?>
						<option value="<?php echo (int) $i; ?>" <?php selected( $period, $i ); ?>><?php echo esc_html( portal_si_disciplina_period_label( $i ) ); ?></option>
					<?php endfor; ?>
					<option value="0" <?php selected( $period, 0 ); ?>><?php esc_html_e( 'Optativa', 'portal-si-cefet' ); ?></option>
				</select>
				<p class="description"><?php esc_html_e( 'A ordem dentro do período segue o campo «Ordem» na caixa Atributos.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Créditos', 'portal-si-cefet' ); ?></th>
			<td>
				<label>
					<?php esc_html_e( 'Teóricos', 'portal-si-cefet' ); ?>
					<input type="number" class="small-text" name="portal_disciplina_theory" min="0" max="30" value="<?php echo (int) $theory; ?>" />
				</label>
				&nbsp;
				<label>
					<?php esc_html_e( 'Práticos', 'portal-si-cefet' ); ?>
					<input type="number" class="small-text" name="portal_disciplina_practice" min="0" max="30" value="<?php echo (int) $practice; ?>" />
				</label>
				<p class="description">
					<?php
					printf(
						/* translators: %d: class hours per credit */
						esc_html__( 'A carga horária é calculada: cada crédito vale %d horas-aula de 50 minutos (5 créditos = 90 horas-aula = 75 horas).', 'portal-si-cefet' ),
						(int) PORTAL_SI_DISCIPLINA_HA_PER_CREDIT
					);
					?>
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_disciplina_nucleo"><?php esc_html_e( 'Núcleo', 'portal-si-cefet' ); ?></label></th>
			<td>
				<select id="portal_disciplina_nucleo" name="portal_disciplina_nucleo">
					<?php foreach ( portal_si_disciplina_nucleo_options() as $key => $label ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $nucleo, $key ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Pré-requisitos', 'portal-si-cefet' ); ?></th>
			<td>
				<?php if ( empty( $grouped ) ) : ?>
					<p class="description"><?php esc_html_e( 'Nenhuma outra disciplina cadastrada.', 'portal-si-cefet' ); ?></p>
				<?php else : ?>
					<div style="max-height:18rem;overflow:auto;padding:0.5rem 0.75rem;border:1px solid #c3c4c7;background:#fff">
						<?php foreach ( $grouped as $group_period => $items ) : ?>
							<fieldset style="margin-bottom:0.75rem">
								<legend style="font-weight:600;margin-bottom:0.25rem"><?php echo esc_html( portal_si_disciplina_period_label( $group_period ) ); ?></legend>
								<?php foreach ( $items as $item ) : ?>
									<label style="display:block;margin:0.15rem 0">
										<input type="checkbox" name="portal_disciplina_prereqs[]" value="<?php echo (int) $item->ID; ?>" <?php checked( in_array( (int) $item->ID, $prereqs, true ) ); ?> />
										<?php
										echo esc_html(
											trim( get_post_meta( $item->ID, PORTAL_SI_DISCIPLINA_CODE_META, true ) . ' · ' . get_the_title( $item ) )
										);
										if ( 'draft' === $item->post_status ) {
											echo ' <em>(' . esc_html__( 'rascunho', 'portal-si-cefet' ) . ')</em>';
										}
										?>
									</label>
								<?php endforeach; ?>
							</fieldset>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_disciplina_ementa"><?php esc_html_e( 'Ementa', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="6" id="portal_disciplina_ementa" name="portal_disciplina_ementa"><?php echo esc_textarea( $ementa ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Deixe vazio para disciplinas de conteúdo variável; o site mostra «Conteúdo variável, definido no plano de curso do semestre».', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
	</table>
	<p class="description">
		<?php esc_html_e( 'Para tirar uma disciplina do site sem apagá-la (ex.: optativa fora de oferta), mude o status para Rascunho.', 'portal-si-cefet' ); ?>
	</p>
	<?php
}

/**
 * Normaliza código (maiúsculas, só letras e números).
 *
 * @param string $code Código digitado.
 * @return string
 */
function portal_si_disciplina_sanitize_code( $code ) {
	return (string) preg_replace( '/[^A-Z0-9]/', '', strtoupper( (string) $code ) );
}

/**
 * Busca disciplina (qualquer status exceto lixeira) pelo código.
 *
 * @param string $code       Código.
 * @param int    $exclude_id Post a ignorar.
 * @return int ID ou 0.
 */
function portal_si_disciplina_find_by_code( $code, $exclude_id = 0 ) {
	$ids = get_posts(
		array(
			'post_type'      => PORTAL_SI_DISCIPLINA_POST_TYPE,
			'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'post__not_in'   => $exclude_id ? array( $exclude_id ) : array(),
			'meta_key'       => PORTAL_SI_DISCIPLINA_CODE_META, // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => $code, // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	return $ids ? (int) $ids[0] : 0;
}

/**
 * @param int $post_id ID do post.
 */
function portal_si_disciplina_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_disciplina_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_disciplina_nonce'] ) ), 'portal_si_disciplina_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( PORTAL_SI_DISCIPLINA_POST_TYPE !== get_post_type( $post_id ) ) {
		return;
	}

	$code = isset( $_POST['portal_disciplina_code'] ) ? portal_si_disciplina_sanitize_code( wp_unslash( $_POST['portal_disciplina_code'] ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_CODE_META, $code );

	if ( $code && portal_si_disciplina_find_by_code( $code, $post_id ) ) {
		set_transient(
			'portal_si_disciplina_notice_' . get_current_user_id(),
			sprintf(
				/* translators: %s: discipline code */
				__( 'Atenção: já existe outra disciplina com o código %s. Pré-requisitos e links da grade podem ficar ambíguos.', 'portal-si-cefet' ),
				$code
			),
			60
		);
	}

	$period = isset( $_POST['portal_disciplina_period'] ) ? absint( $_POST['portal_disciplina_period'] ) : 1;
	update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PERIOD_META, min( 8, $period ) );

	$theory   = isset( $_POST['portal_disciplina_theory'] ) ? min( 30, absint( $_POST['portal_disciplina_theory'] ) ) : 0;
	$practice = isset( $_POST['portal_disciplina_practice'] ) ? min( 30, absint( $_POST['portal_disciplina_practice'] ) ) : 0;
	update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_THEORY_META, $theory );
	update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PRACTICE_META, $practice );

	$nucleo  = isset( $_POST['portal_disciplina_nucleo'] ) ? sanitize_key( wp_unslash( $_POST['portal_disciplina_nucleo'] ) ) : '';
	$allowed = portal_si_disciplina_nucleo_options();
	update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_NUCLEO_META, isset( $allowed[ $nucleo ] ) ? $nucleo : '' );

	$prereqs = array();
	if ( isset( $_POST['portal_disciplina_prereqs'] ) && is_array( $_POST['portal_disciplina_prereqs'] ) ) {
		foreach ( wp_unslash( $_POST['portal_disciplina_prereqs'] ) as $id ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$id = absint( $id );
			if ( $id && $id !== (int) $post_id && PORTAL_SI_DISCIPLINA_POST_TYPE === get_post_type( $id ) ) {
				$prereqs[] = $id;
			}
		}
	}
	update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PREREQS_META, array_values( array_unique( $prereqs ) ) );

	update_post_meta(
		$post_id,
		PORTAL_SI_DISCIPLINA_EMENTA_META,
		isset( $_POST['portal_disciplina_ementa'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_disciplina_ementa'] ) ) : ''
	);
}
add_action( 'save_post_' . PORTAL_SI_DISCIPLINA_POST_TYPE, 'portal_si_disciplina_save_meta_box' );

/**
 * Aviso de código duplicado após salvar.
 */
function portal_si_disciplina_admin_notice() {
	$key     = 'portal_si_disciplina_notice_' . get_current_user_id();
	$message = get_transient( $key );
	if ( ! $message ) {
		return;
	}
	delete_transient( $key );
	printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', esc_html( $message ) );
}
add_action( 'admin_notices', 'portal_si_disciplina_admin_notice' );

/**
 * Colunas da listagem no admin.
 *
 * @param array<string, string> $columns Colunas.
 * @return array<string, string>
 */
function portal_si_disciplina_admin_columns( $columns ) {
	return array(
		'cb'                 => $columns['cb'],
		'title'              => __( 'Disciplina', 'portal-si-cefet' ),
		'portal_disc_code'   => __( 'Código', 'portal-si-cefet' ),
		'portal_disc_period' => __( 'Período', 'portal-si-cefet' ),
		'portal_disc_cr'     => __( 'Créditos', 'portal-si-cefet' ),
		'portal_disc_nucleo' => __( 'Núcleo', 'portal-si-cefet' ),
	);
}
add_filter( 'manage_' . PORTAL_SI_DISCIPLINA_POST_TYPE . '_posts_columns', 'portal_si_disciplina_admin_columns' );

/**
 * @param string $column  Coluna.
 * @param int    $post_id ID do post.
 */
function portal_si_disciplina_admin_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'portal_disc_code':
			echo esc_html( (string) get_post_meta( $post_id, PORTAL_SI_DISCIPLINA_CODE_META, true ) );
			break;
		case 'portal_disc_period':
			echo esc_html( portal_si_disciplina_period_label( (int) get_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PERIOD_META, true ) ) );
			break;
		case 'portal_disc_cr':
			echo (int) get_post_meta( $post_id, PORTAL_SI_DISCIPLINA_THEORY_META, true ) + (int) get_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PRACTICE_META, true );
			break;
		case 'portal_disc_nucleo':
			echo esc_html( portal_si_grade_nucleo_label( (string) get_post_meta( $post_id, PORTAL_SI_DISCIPLINA_NUCLEO_META, true ) ) );
			break;
	}
}
add_action( 'manage_' . PORTAL_SI_DISCIPLINA_POST_TYPE . '_posts_custom_column', 'portal_si_disciplina_admin_column_content', 10, 2 );

/**
 * Filtro por período na listagem.
 *
 * @param string $post_type Tipo listado.
 */
function portal_si_disciplina_admin_period_filter( $post_type ) {
	if ( PORTAL_SI_DISCIPLINA_POST_TYPE !== $post_type ) {
		return;
	}
	$current = isset( $_GET['portal_periodo'] ) ? sanitize_text_field( wp_unslash( $_GET['portal_periodo'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	?>
	<label for="portal-periodo-filter" class="screen-reader-text"><?php esc_html_e( 'Filtrar por período', 'portal-si-cefet' ); ?></label>
	<select name="portal_periodo" id="portal-periodo-filter">
		<option value=""><?php esc_html_e( 'Todos os períodos', 'portal-si-cefet' ); ?></option>
		<?php for ( $i = 1; $i <= 8; $i++ ) : ?>
			<option value="<?php echo (int) $i; ?>" <?php selected( $current, (string) $i ); ?>><?php echo esc_html( portal_si_disciplina_period_label( $i ) ); ?></option>
		<?php endfor; ?>
		<option value="0" <?php selected( $current, '0' ); ?>><?php esc_html_e( 'Optativas', 'portal-si-cefet' ); ?></option>
	</select>
	<?php
}
add_action( 'restrict_manage_posts', 'portal_si_disciplina_admin_period_filter' );

/**
 * Listagem no admin: ordena por período e ordem; aplica filtro de período.
 *
 * @param WP_Query $query Query.
 */
function portal_si_disciplina_admin_query( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() || PORTAL_SI_DISCIPLINA_POST_TYPE !== $query->get( 'post_type' ) ) {
		return;
	}

	if ( ! $query->get( 'orderby' ) ) {
		$query->set( 'meta_key', PORTAL_SI_DISCIPLINA_PERIOD_META );
		$query->set(
			'orderby',
			array(
				'meta_value_num' => 'ASC',
				'menu_order'     => 'ASC',
			)
		);
	}

	$period = isset( $_GET['portal_periodo'] ) ? sanitize_text_field( wp_unslash( $_GET['portal_periodo'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	if ( '' !== $period ) {
		$query->set(
			'meta_query',
			array(
				array(
					'key'   => PORTAL_SI_DISCIPLINA_PERIOD_META,
					'value' => (int) $period,
					'type'  => 'NUMERIC',
				),
			)
		);
	}
}
add_action( 'pre_get_posts', 'portal_si_disciplina_admin_query' );

/**
 * Disciplinas publicadas no formato de data/grade-curricular.php.
 *
 * @return array{periods: array<int, array<int, array<string, mixed>>>, optativas: array<int, array<string, mixed>>}|null
 *         Null quando não há disciplinas publicadas.
 */
function portal_si_disciplina_rows() {
	$posts = get_posts(
		array(
			'post_type'      => PORTAL_SI_DISCIPLINA_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	);

	if ( empty( $posts ) ) {
		return null;
	}

	$codes = array();
	foreach ( $posts as $post ) {
		$codes[ $post->ID ] = (string) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_CODE_META, true );
	}

	$out = array(
		'periods'   => array(),
		'optativas' => array(),
	);

	foreach ( $posts as $post ) {
		$theory   = (int) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_THEORY_META, true );
		$practice = (int) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_PRACTICE_META, true );
		$credits  = $theory + $practice;
		$ha       = $credits * PORTAL_SI_DISCIPLINA_HA_PER_CREDIT;

		$pre = array();
		foreach ( (array) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_PREREQS_META, true ) as $pre_id ) {
			if ( ! empty( $codes[ (int) $pre_id ] ) ) {
				$pre[] = $codes[ (int) $pre_id ];
			}
		}

		$row = array(
			'code'   => $codes[ $post->ID ],
			'name'   => get_the_title( $post ),
			't'      => $theory,
			'p'      => $practice,
			'cr'     => $credits,
			'ha'     => $ha,
			'hr'     => (int) round( $ha * 50 / 60 ),
			'pre'    => $pre,
			'nucleo' => (string) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_NUCLEO_META, true ),
			'ementa' => (string) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_EMENTA_META, true ),
		);

		$period = (int) get_post_meta( $post->ID, PORTAL_SI_DISCIPLINA_PERIOD_META, true );
		if ( 0 === $period ) {
			if ( '' === $row['nucleo'] ) {
				$row['nucleo'] = 'optativa';
			}
			$out['optativas'][] = $row;
		} else {
			$out['periods'][ $period ][] = $row;
		}
	}

	ksort( $out['periods'] );
	return $out;
}

/**
 * Importa as disciplinas de data/grade-curricular.php uma única vez.
 */
function portal_si_disciplina_maybe_import() {
	if ( get_option( PORTAL_SI_DISCIPLINA_IMPORTED_OPTION ) ) {
		return;
	}
	// add_option falha se outra requisição já gravou a opção: evita importação duplicada.
	if ( ! add_option( PORTAL_SI_DISCIPLINA_IMPORTED_OPTION, time() ) ) {
		return;
	}

	$existing = get_posts(
		array(
			'post_type'      => PORTAL_SI_DISCIPLINA_POST_TYPE,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		return;
	}

	$config = portal_si_grade_config();
	$rows   = array();

	if ( isset( $config['periods'] ) && is_array( $config['periods'] ) ) {
		foreach ( $config['periods'] as $period => $items ) {
			foreach ( (array) $items as $index => $item ) {
				if ( is_array( $item ) && empty( $item['optativa'] ) ) {
					$rows[] = array( (int) $period, $index + 1, $item );
				}
			}
		}
	}
	if ( isset( $config['optativas'] ) && is_array( $config['optativas'] ) ) {
		foreach ( $config['optativas'] as $index => $item ) {
			if ( is_array( $item ) ) {
				$rows[] = array( 0, $index + 1, $item );
			}
		}
	}

	$ids     = array();
	$pending = array();

	foreach ( $rows as $row ) {
		list( $period, $order, $item ) = $row;

		$code = portal_si_disciplina_sanitize_code( isset( $item['code'] ) ? $item['code'] : '' );
		if ( '' === $code || empty( $item['name'] ) ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'   => PORTAL_SI_DISCIPLINA_POST_TYPE,
				'post_status' => 'publish',
				'post_title'  => (string) $item['name'],
				'menu_order'  => $order,
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		$nucleo = isset( $item['nucleo'] ) ? sanitize_key( $item['nucleo'] ) : ( 0 === $period ? 'optativa' : '' );

		update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_CODE_META, $code );
		update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PERIOD_META, $period );
		update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_THEORY_META, isset( $item['t'] ) ? (int) $item['t'] : 0 );
		update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PRACTICE_META, isset( $item['p'] ) ? (int) $item['p'] : 0 );
		update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_NUCLEO_META, $nucleo );
		update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_EMENTA_META, isset( $item['ementa'] ) ? (string) $item['ementa'] : '' );

		$ids[ $code ]        = (int) $post_id;
		$pending[ $post_id ] = isset( $item['pre'] ) ? (array) $item['pre'] : array();
	}

	foreach ( $pending as $post_id => $pre_codes ) {
		$pre_ids = array();
		foreach ( $pre_codes as $pre_code ) {
			$pre_code = portal_si_disciplina_sanitize_code( $pre_code );
			if ( isset( $ids[ $pre_code ] ) && $ids[ $pre_code ] !== (int) $post_id ) {
				$pre_ids[] = $ids[ $pre_code ];
			}
		}
		update_post_meta( $post_id, PORTAL_SI_DISCIPLINA_PREREQS_META, $pre_ids );
	}
}
add_action( 'init', 'portal_si_disciplina_maybe_import', 20 );
