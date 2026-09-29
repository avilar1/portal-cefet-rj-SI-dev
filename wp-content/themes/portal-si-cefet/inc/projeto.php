<?php
/**
 * Projetos de pesquisa e extensão — RF09 (e listagens do hub, RF11).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_PROJETO_POST_TYPE        = 'portal_projeto';
const PORTAL_SI_PROJETO_TIPO_META        = '_portal_projeto_tipo';
const PORTAL_SI_PROJETO_SITUACAO_META    = '_portal_projeto_situacao';
const PORTAL_SI_PROJETO_COORDENADOR_META = '_portal_projeto_coordenador';
const PORTAL_SI_PROJETO_RESPONSAVEL_META = '_portal_projeto_responsavel';
const PORTAL_SI_PROJETO_AREA_META        = '_portal_projeto_area';
const PORTAL_SI_PROJETO_INICIO_META      = '_portal_projeto_inicio';
const PORTAL_SI_PROJETO_FIM_META         = '_portal_projeto_fim';
const PORTAL_SI_PROJETO_VAGAS_META       = '_portal_projeto_vagas';
const PORTAL_SI_PROJETO_PARTICIPAR_META  = '_portal_projeto_participar';
const PORTAL_SI_PROJETO_LINK_META        = '_portal_projeto_link';
const PORTAL_SI_PROJETO_EXEMPLO_META     = '_portal_projeto_exemplo';

define( 'PORTAL_SI_PESQUISA_HUB_SLUG', 'pesquisa-e-extensao' );
define( 'PORTAL_SI_PROJETOS_SLUG', 'projetos' );

/**
 * @return array<string, string>
 */
function portal_si_projeto_tipos() {
	return array(
		'pesquisa' => __( 'Pesquisa', 'portal-si-cefet' ),
		'extensao' => __( 'Extensão', 'portal-si-cefet' ),
	);
}

/**
 * @return array<string, string>
 */
function portal_si_projeto_situacoes() {
	return array(
		'andamento' => __( 'Em andamento', 'portal-si-cefet' ),
		'concluido' => __( 'Concluído', 'portal-si-cefet' ),
	);
}

/**
 * Registra CPT Projeto.
 */
function portal_si_register_projeto_cpt() {
	register_post_type(
		PORTAL_SI_PROJETO_POST_TYPE,
		array(
			'labels'             => array(
				'name'               => __( 'Projetos', 'portal-si-cefet' ),
				'singular_name'      => __( 'Projeto', 'portal-si-cefet' ),
				'add_new'            => __( 'Adicionar projeto', 'portal-si-cefet' ),
				'add_new_item'       => __( 'Adicionar novo projeto', 'portal-si-cefet' ),
				'edit_item'          => __( 'Editar projeto', 'portal-si-cefet' ),
				'new_item'           => __( 'Novo projeto', 'portal-si-cefet' ),
				'view_item'          => __( 'Ver projeto', 'portal-si-cefet' ),
				'search_items'       => __( 'Buscar projetos', 'portal-si-cefet' ),
				'not_found'          => __( 'Nenhum projeto encontrado.', 'portal-si-cefet' ),
				'not_found_in_trash' => __( 'Nenhum projeto na lixeira.', 'portal-si-cefet' ),
				'all_items'          => __( 'Todos os projetos', 'portal-si-cefet' ),
				'menu_name'          => __( 'Projetos P&E', 'portal-si-cefet' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'menu_position'      => 27,
			'has_archive'        => false,
			'rewrite'            => array(
				'slug'       => 'projeto',
				'with_front' => false,
			),
			'supports'           => array( 'title', 'editor', 'excerpt' ),
			'show_in_rest'       => false,
			'capability_type'    => 'post',
		)
	);
}
add_action( 'init', 'portal_si_register_projeto_cpt' );

/**
 * Permalinks /projeto/slug após registrar o CPT.
 */
function portal_si_projeto_maybe_flush_rewrites() {
	if ( get_option( 'portal_si_projeto_rewrites_v1' ) ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'portal_si_projeto_rewrites_v1', 1 );
}
add_action( 'init', 'portal_si_projeto_maybe_flush_rewrites', 99 );

/**
 * Garante uma página filha do hub Pesquisa e Extensão.
 *
 * @param string $title Título.
 * @param string $slug  Slug.
 */
function portal_si_pesquisa_ensure_child_page( $title, $slug ) {
	$page_id = portal_si_ensure_page( $title, $slug );
	$hub_id  = portal_si_get_page_id_by_slug( PORTAL_SI_PESQUISA_HUB_SLUG );
	if ( $page_id && $hub_id && (int) get_post_field( 'post_parent', $page_id ) !== (int) $hub_id ) {
		wp_update_post(
			array(
				'ID'          => $page_id,
				'post_parent' => $hub_id,
			)
		);
	}
}

/**
 * Página /pesquisa-e-extensao/projetos.
 */
function portal_si_ensure_projetos_page() {
	portal_si_pesquisa_ensure_child_page( __( 'Projetos', 'portal-si-cefet' ), PORTAL_SI_PROJETOS_SLUG );
}
add_action( 'after_setup_theme', 'portal_si_ensure_projetos_page', 27 );

/* ------------------------------------------------------------------ */
/* Painel                                                              */
/* ------------------------------------------------------------------ */

/**
 * Meta box do projeto.
 */
function portal_si_projeto_add_meta_boxes() {
	add_meta_box(
		'portal-projeto-dados',
		__( 'Dados do projeto', 'portal-si-cefet' ),
		'portal_si_projeto_render_meta_box',
		PORTAL_SI_PROJETO_POST_TYPE,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_projeto_add_meta_boxes' );

/**
 * @param WP_Post $post Projeto.
 */
function portal_si_projeto_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_projeto_save', 'portal_si_projeto_nonce' );
	$m = function ( $key ) use ( $post ) {
		return (string) get_post_meta( $post->ID, $key, true );
	};
	$tipo        = $m( PORTAL_SI_PROJETO_TIPO_META ) ? $m( PORTAL_SI_PROJETO_TIPO_META ) : 'pesquisa';
	$situacao    = $m( PORTAL_SI_PROJETO_SITUACAO_META ) ? $m( PORTAL_SI_PROJETO_SITUACAO_META ) : 'andamento';
	$coordenador = (int) $m( PORTAL_SI_PROJETO_COORDENADOR_META );
	$professores = get_posts(
		array(
			'post_type'      => PORTAL_SI_PROFESSOR_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	?>
	<?php if ( '1' === $m( PORTAL_SI_PROJETO_EXEMPLO_META ) ) : ?>
		<div class="notice notice-warning inline"><p>
			<?php esc_html_e( 'Este é um projeto de EXEMPLO (aparece no site com o selo "Exemplo"). Substitua pelos dados reais e desmarque a opção "Projeto de exemplo" abaixo, ou exclua o projeto.', 'portal-si-cefet' ); ?>
		</p></div>
	<?php endif; ?>
	<table class="form-table">
		<tr>
			<th scope="row"><?php esc_html_e( 'Tipo', 'portal-si-cefet' ); ?></th>
			<td>
				<?php foreach ( portal_si_projeto_tipos() as $key => $label ) : ?>
					<label style="margin-right:1em;"><input type="radio" name="portal_projeto_tipo" value="<?php echo esc_attr( $key ); ?>" <?php checked( $tipo, $key ); ?> /> <?php echo esc_html( $label ); ?></label>
				<?php endforeach; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Situação', 'portal-si-cefet' ); ?></th>
			<td>
				<?php foreach ( portal_si_projeto_situacoes() as $key => $label ) : ?>
					<label style="margin-right:1em;"><input type="radio" name="portal_projeto_situacao" value="<?php echo esc_attr( $key ); ?>" <?php checked( $situacao, $key ); ?> /> <?php echo esc_html( $label ); ?></label>
				<?php endforeach; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_projeto_coordenador"><?php esc_html_e( 'Docente responsável', 'portal-si-cefet' ); ?></label></th>
			<td>
				<select id="portal_projeto_coordenador" name="portal_projeto_coordenador">
					<option value="0"><?php esc_html_e( '— Escolha no Corpo Docente —', 'portal-si-cefet' ); ?></option>
					<?php foreach ( $professores as $prof ) : ?>
						<option value="<?php echo esc_attr( $prof->ID ); ?>" <?php selected( $coordenador, $prof->ID ); ?>><?php echo esc_html( get_the_title( $prof ) ); ?></option>
					<?php endforeach; ?>
				</select>
				<p>
					<label for="portal_projeto_responsavel"><?php esc_html_e( 'Ou nome do responsável (se não estiver no Corpo Docente):', 'portal-si-cefet' ); ?></label><br />
					<input type="text" class="regular-text" id="portal_projeto_responsavel" name="portal_projeto_responsavel" value="<?php echo esc_attr( $m( PORTAL_SI_PROJETO_RESPONSAVEL_META ) ); ?>" />
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_projeto_area"><?php esc_html_e( 'Área / linha de pesquisa', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="regular-text" id="portal_projeto_area" name="portal_projeto_area" value="<?php echo esc_attr( $m( PORTAL_SI_PROJETO_AREA_META ) ); ?>" placeholder="<?php esc_attr_e( 'Ex.: Ciência de dados', 'portal-si-cefet' ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Período', 'portal-si-cefet' ); ?></th>
			<td>
				<label><?php esc_html_e( 'Início', 'portal-si-cefet' ); ?> <input type="number" min="1990" max="2100" step="1" name="portal_projeto_inicio" value="<?php echo esc_attr( $m( PORTAL_SI_PROJETO_INICIO_META ) ); ?>" style="width:6em;" /></label>
				<label style="margin-left:1em;"><?php esc_html_e( 'Término', 'portal-si-cefet' ); ?> <input type="number" min="1990" max="2100" step="1" name="portal_projeto_fim" value="<?php echo esc_attr( $m( PORTAL_SI_PROJETO_FIM_META ) ); ?>" style="width:6em;" /></label>
				<p class="description"><?php esc_html_e( 'Anos. Deixe o término em branco se o projeto está em andamento.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Alunos', 'portal-si-cefet' ); ?></th>
			<td>
				<label><input type="checkbox" name="portal_projeto_vagas" value="1" <?php checked( '1', $m( PORTAL_SI_PROJETO_VAGAS_META ) ); ?> /> <?php esc_html_e( 'Aceita alunos no momento (aparece em Iniciação Científica)', 'portal-si-cefet' ); ?></label>
				<p>
					<label for="portal_projeto_participar"><?php esc_html_e( 'Como participar / pré-requisitos (opcional):', 'portal-si-cefet' ); ?></label><br />
					<textarea class="large-text" rows="2" id="portal_projeto_participar" name="portal_projeto_participar"><?php echo esc_textarea( $m( PORTAL_SI_PROJETO_PARTICIPAR_META ) ); ?></textarea>
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_projeto_link"><?php esc_html_e( 'Link externo', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="url" class="large-text" id="portal_projeto_link" name="portal_projeto_link" value="<?php echo esc_attr( $m( PORTAL_SI_PROJETO_LINK_META ) ); ?>" placeholder="https://" />
				<p class="description"><?php esc_html_e( 'Site do projeto, grupo no Diretório do CNPq, repositório etc.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Exemplo', 'portal-si-cefet' ); ?></th>
			<td><label><input type="checkbox" name="portal_projeto_exemplo" value="1" <?php checked( '1', $m( PORTAL_SI_PROJETO_EXEMPLO_META ) ); ?> /> <?php esc_html_e( 'Projeto de exemplo (exibe o selo "Exemplo" no site)', 'portal-si-cefet' ); ?></label></td>
		</tr>
	</table>
	<p class="description"><?php esc_html_e( 'O "Resumo" (caixa abaixo do editor) aparece nos cards; o texto principal aparece na página do projeto.', 'portal-si-cefet' ); ?></p>
	<?php
}

/**
 * @param int $post_id ID do projeto.
 */
function portal_si_projeto_save_meta( $post_id ) {
	if ( ! isset( $_POST['portal_si_projeto_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_projeto_nonce'] ) ), 'portal_si_projeto_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$tipo = isset( $_POST['portal_projeto_tipo'] ) ? sanitize_key( wp_unslash( $_POST['portal_projeto_tipo'] ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_PROJETO_TIPO_META, isset( portal_si_projeto_tipos()[ $tipo ] ) ? $tipo : 'pesquisa' );

	$situacao = isset( $_POST['portal_projeto_situacao'] ) ? sanitize_key( wp_unslash( $_POST['portal_projeto_situacao'] ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_PROJETO_SITUACAO_META, isset( portal_si_projeto_situacoes()[ $situacao ] ) ? $situacao : 'andamento' );

	$coord = isset( $_POST['portal_projeto_coordenador'] ) ? absint( $_POST['portal_projeto_coordenador'] ) : 0;
	if ( $coord && PORTAL_SI_PROFESSOR_POST_TYPE === get_post_type( $coord ) ) {
		update_post_meta( $post_id, PORTAL_SI_PROJETO_COORDENADOR_META, $coord );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_PROJETO_COORDENADOR_META );
	}

	$texts = array(
		PORTAL_SI_PROJETO_RESPONSAVEL_META => 'portal_projeto_responsavel',
		PORTAL_SI_PROJETO_AREA_META        => 'portal_projeto_area',
	);
	foreach ( $texts as $meta => $field ) {
		update_post_meta( $post_id, $meta, isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '' );
	}
	update_post_meta( $post_id, PORTAL_SI_PROJETO_PARTICIPAR_META, isset( $_POST['portal_projeto_participar'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_projeto_participar'] ) ) : '' );

	foreach ( array( PORTAL_SI_PROJETO_INICIO_META => 'portal_projeto_inicio', PORTAL_SI_PROJETO_FIM_META => 'portal_projeto_fim' ) as $meta => $field ) {
		$year = isset( $_POST[ $field ] ) ? absint( $_POST[ $field ] ) : 0;
		if ( $year >= 1990 && $year <= 2100 ) {
			update_post_meta( $post_id, $meta, $year );
		} else {
			delete_post_meta( $post_id, $meta );
		}
	}

	$link = isset( $_POST['portal_projeto_link'] ) ? esc_url_raw( wp_unslash( $_POST['portal_projeto_link'] ), array( 'http', 'https' ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_PROJETO_LINK_META, $link );

	foreach ( array( PORTAL_SI_PROJETO_VAGAS_META => 'portal_projeto_vagas', PORTAL_SI_PROJETO_EXEMPLO_META => 'portal_projeto_exemplo' ) as $meta => $field ) {
		if ( ! empty( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta, '1' );
		} else {
			delete_post_meta( $post_id, $meta );
		}
	}
}
add_action( 'save_post_' . PORTAL_SI_PROJETO_POST_TYPE, 'portal_si_projeto_save_meta' );

/**
 * Colunas no painel.
 *
 * @param string[] $columns Colunas.
 * @return string[]
 */
function portal_si_projeto_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['portal_projeto_tipo']     = __( 'Tipo', 'portal-si-cefet' );
			$new['portal_projeto_situacao'] = __( 'Situação', 'portal-si-cefet' );
			$new['portal_projeto_resp']     = __( 'Responsável', 'portal-si-cefet' );
		}
	}
	return $new;
}
add_filter( 'manage_' . PORTAL_SI_PROJETO_POST_TYPE . '_posts_columns', 'portal_si_projeto_admin_columns' );

/**
 * @param string $column  Coluna.
 * @param int    $post_id ID.
 */
function portal_si_projeto_admin_column_content( $column, $post_id ) {
	$item = portal_si_projeto_to_array( $post_id, false );
	if ( ! $item ) {
		return;
	}
	if ( 'portal_projeto_tipo' === $column ) {
		echo esc_html( $item['tipo_label'] );
		if ( $item['exemplo'] ) {
			echo ' <strong>(' . esc_html__( 'exemplo', 'portal-si-cefet' ) . ')</strong>';
		}
	} elseif ( 'portal_projeto_situacao' === $column ) {
		echo esc_html( $item['situacao_label'] );
	} elseif ( 'portal_projeto_resp' === $column ) {
		echo esc_html( $item['responsavel'] ? $item['responsavel'] : '—' );
	}
}
add_action( 'manage_' . PORTAL_SI_PROJETO_POST_TYPE . '_posts_custom_column', 'portal_si_projeto_admin_column_content', 10, 2 );

/**
 * Aviso na listagem enquanto houver projetos de exemplo.
 */
function portal_si_projeto_exemplo_notice() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'edit-' . PORTAL_SI_PROJETO_POST_TYPE !== $screen->id ) {
		return;
	}
	$count = count(
		get_posts(
			array(
				'post_type'      => PORTAL_SI_PROJETO_POST_TYPE,
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => PORTAL_SI_PROJETO_EXEMPLO_META,
				'meta_value'     => '1',
			)
		)
	);
	if ( ! $count ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>';
	printf(
		/* translators: %d: quantidade de projetos de exemplo. */
		esc_html( _n( 'Há %d projeto de exemplo publicado. Substitua pelos projetos reais do curso (desmarcando "Projeto de exemplo") ou exclua.', 'Há %d projetos de exemplo publicados. Substitua pelos projetos reais do curso (desmarcando "Projeto de exemplo") ou exclua.', $count, 'portal-si-cefet' ) ),
		(int) $count
	);
	echo '</p></div>';
}
add_action( 'admin_notices', 'portal_si_projeto_exemplo_notice' );

/**
 * Importa os projetos de exemplo uma vez, se ainda não houver projetos.
 */
function portal_si_projeto_maybe_seed() {
	if ( ! add_option( 'portal_si_projetos_seeded', 1, '', false ) ) {
		return;
	}
	$existing = get_posts(
		array(
			'post_type'      => PORTAL_SI_PROJETO_POST_TYPE,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		return;
	}

	$items = require get_template_directory() . '/data/projetos-exemplo.php';
	foreach ( (array) $items as $index => $item ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => PORTAL_SI_PROJETO_POST_TYPE,
				'post_status'  => 'publish',
				'post_title'   => $item['title'],
				'post_excerpt' => $item['excerpt'],
				'post_content' => $item['content'],
				'menu_order'   => $index,
			),
			true
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}
		update_post_meta( $post_id, PORTAL_SI_PROJETO_TIPO_META, $item['tipo'] );
		update_post_meta( $post_id, PORTAL_SI_PROJETO_SITUACAO_META, $item['situacao'] );
		update_post_meta( $post_id, PORTAL_SI_PROJETO_AREA_META, $item['area'] );
		update_post_meta( $post_id, PORTAL_SI_PROJETO_RESPONSAVEL_META, __( 'Docente responsável (exemplo)', 'portal-si-cefet' ) );
		update_post_meta( $post_id, PORTAL_SI_PROJETO_INICIO_META, (int) $item['inicio'] );
		if ( ! empty( $item['fim'] ) ) {
			update_post_meta( $post_id, PORTAL_SI_PROJETO_FIM_META, (int) $item['fim'] );
		}
		if ( ! empty( $item['vagas'] ) ) {
			update_post_meta( $post_id, PORTAL_SI_PROJETO_VAGAS_META, '1' );
		}
		update_post_meta( $post_id, PORTAL_SI_PROJETO_PARTICIPAR_META, $item['participar'] );
		update_post_meta( $post_id, PORTAL_SI_PROJETO_EXEMPLO_META, '1' );
	}
}
add_action( 'init', 'portal_si_projeto_maybe_seed', 20 );

/* ------------------------------------------------------------------ */
/* Dados                                                               */
/* ------------------------------------------------------------------ */

/**
 * Projeto normalizado para templates.
 *
 * @param int|WP_Post $post         Projeto.
 * @param bool        $only_public  Exigir publicado.
 * @return array<string, mixed>|null
 */
function portal_si_projeto_to_array( $post, $only_public = true ) {
	$post = get_post( $post );
	if ( ! $post || PORTAL_SI_PROJETO_POST_TYPE !== $post->post_type ) {
		return null;
	}
	if ( $only_public && 'publish' !== $post->post_status ) {
		return null;
	}

	$tipos      = portal_si_projeto_tipos();
	$situacoes  = portal_si_projeto_situacoes();
	$tipo       = (string) get_post_meta( $post->ID, PORTAL_SI_PROJETO_TIPO_META, true );
	$tipo       = isset( $tipos[ $tipo ] ) ? $tipo : 'pesquisa';
	$situacao   = (string) get_post_meta( $post->ID, PORTAL_SI_PROJETO_SITUACAO_META, true );
	$situacao   = isset( $situacoes[ $situacao ] ) ? $situacao : 'andamento';
	$coord_id   = (int) get_post_meta( $post->ID, PORTAL_SI_PROJETO_COORDENADOR_META, true );
	$coord_ok   = $coord_id && 'publish' === get_post_status( $coord_id );
	$inicio     = (int) get_post_meta( $post->ID, PORTAL_SI_PROJETO_INICIO_META, true );
	$fim        = (int) get_post_meta( $post->ID, PORTAL_SI_PROJETO_FIM_META, true );

	if ( $inicio && $fim && $fim !== $inicio ) {
		$periodo = $inicio . '–' . $fim;
	} elseif ( $inicio && 'andamento' === $situacao ) {
		/* translators: %d: ano de início. */
		$periodo = sprintf( __( 'Desde %d', 'portal-si-cefet' ), $inicio );
	} else {
		$periodo = $inicio ? (string) $inicio : '';
	}

	$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 24, '…' );

	return array(
		'id'              => (int) $post->ID,
		'title'           => get_the_title( $post ),
		'url'             => get_permalink( $post ),
		'excerpt'         => $excerpt,
		'tipo'            => $tipo,
		'tipo_label'      => $tipos[ $tipo ],
		'situacao'        => $situacao,
		'situacao_label'  => $situacoes[ $situacao ],
		'responsavel'     => $coord_ok ? get_the_title( $coord_id ) : (string) get_post_meta( $post->ID, PORTAL_SI_PROJETO_RESPONSAVEL_META, true ),
		'responsavel_url' => $coord_ok ? get_permalink( $coord_id ) : '',
		'area'            => (string) get_post_meta( $post->ID, PORTAL_SI_PROJETO_AREA_META, true ),
		'inicio'          => $inicio,
		'periodo'         => $periodo,
		'vagas'           => '1' === get_post_meta( $post->ID, PORTAL_SI_PROJETO_VAGAS_META, true ),
		'participar'      => (string) get_post_meta( $post->ID, PORTAL_SI_PROJETO_PARTICIPAR_META, true ),
		'link'            => (string) get_post_meta( $post->ID, PORTAL_SI_PROJETO_LINK_META, true ),
		'exemplo'         => '1' === get_post_meta( $post->ID, PORTAL_SI_PROJETO_EXEMPLO_META, true ),
	);
}

/**
 * Projetos publicados: em andamento primeiro, depois os mais recentes.
 *
 * @param array{tipo?: string, situacao?: string, vagas?: bool, limit?: int} $filters Filtros.
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_projetos( array $filters = array() ) {
	$posts = get_posts(
		array(
			'post_type'      => PORTAL_SI_PROJETO_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	);

	$items = array();
	foreach ( $posts as $post ) {
		$item = portal_si_projeto_to_array( $post );
		if ( ! $item ) {
			continue;
		}
		if ( ! empty( $filters['tipo'] ) && $item['tipo'] !== $filters['tipo'] ) {
			continue;
		}
		if ( ! empty( $filters['situacao'] ) && $item['situacao'] !== $filters['situacao'] ) {
			continue;
		}
		if ( ! empty( $filters['vagas'] ) && ( ! $item['vagas'] || 'andamento' !== $item['situacao'] ) ) {
			continue;
		}
		$items[] = $item;
	}

	usort(
		$items,
		function ( $a, $b ) {
			if ( $a['situacao'] !== $b['situacao'] ) {
				return 'andamento' === $a['situacao'] ? -1 : 1;
			}
			return $b['inicio'] <=> $a['inicio'];
		}
	);

	if ( ! empty( $filters['limit'] ) ) {
		$items = array_slice( $items, 0, (int) $filters['limit'] );
	}
	return $items;
}

/**
 * Projetos coordenados por um professor (para o perfil docente).
 *
 * @param int $professor_id ID do professor.
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_projetos_do_professor( $professor_id ) {
	$ids = get_posts(
		array(
			'post_type'      => PORTAL_SI_PROJETO_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_key'       => PORTAL_SI_PROJETO_COORDENADOR_META,
			'meta_value'     => (int) $professor_id,
		)
	);
	return array_values( array_filter( array_map( 'portal_si_projeto_to_array', $ids ) ) );
}

/**
 * Filtro atual da página Projetos (?tipo= & ?situacao=).
 *
 * @return array{tipo: string, situacao: string}
 */
function portal_si_projetos_current_filters() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$tipo     = isset( $_GET['tipo'] ) ? sanitize_key( wp_unslash( $_GET['tipo'] ) ) : '';
	$situacao = isset( $_GET['situacao'] ) ? sanitize_key( wp_unslash( $_GET['situacao'] ) ) : '';
	// phpcs:enable
	return array(
		'tipo'     => isset( portal_si_projeto_tipos()[ $tipo ] ) ? $tipo : '',
		'situacao' => isset( portal_si_projeto_situacoes()[ $situacao ] ) ? $situacao : '',
	);
}

/* ------------------------------------------------------------------ */
/* Front-end                                                           */
/* ------------------------------------------------------------------ */

/**
 * Páginas do módulo Pesquisa e Extensão (hub, projetos, IC e projeto individual).
 *
 * @return bool
 */
function portal_si_is_pesquisa_module() {
	return is_page( array( PORTAL_SI_PESQUISA_HUB_SLUG, PORTAL_SI_PROJETOS_SLUG, 'iniciacao-cientifica' ) )
		|| is_singular( PORTAL_SI_PROJETO_POST_TYPE );
}

/**
 * @param string[] $classes Classes do body.
 * @return string[]
 */
function portal_si_pesquisa_body_class( $classes ) {
	if ( portal_si_is_pesquisa_module() ) {
		$classes[] = 'portal-is-pesquisa';
	}
	return $classes;
}
add_filter( 'body_class', 'portal_si_pesquisa_body_class' );

/**
 * CSS do módulo.
 */
function portal_si_pesquisa_enqueue_assets() {
	if ( ! portal_si_is_pesquisa_module() && ! is_singular( PORTAL_SI_PROFESSOR_POST_TYPE ) ) {
		return;
	}
	wp_enqueue_style(
		'portal-si-pesquisa',
		get_template_directory_uri() . '/assets/css/pesquisa.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_pesquisa_enqueue_assets', 16 );
