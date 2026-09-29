<?php
/**
 * Repositório de TCCs — RF25.
 *
 * Cada TCC aceita arquivo PDF (biblioteca de mídia) e/ou link externo (ex.: repositório
 * oficial). O envio de arquivos pode ser desligado em TCCs → Configurações.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_TCC_POST_TYPE          = 'portal_tcc';
const PORTAL_SI_TCC_AUTORES_META       = '_portal_tcc_autores';
const PORTAL_SI_TCC_ORIENTADOR_META    = '_portal_tcc_orientador';
const PORTAL_SI_TCC_ORIENTADOR_NOME_META = '_portal_tcc_orientador_nome';
const PORTAL_SI_TCC_COORIENTADOR_META  = '_portal_tcc_coorientador';
const PORTAL_SI_TCC_ANO_META           = '_portal_tcc_ano';
const PORTAL_SI_TCC_SEMESTRE_META      = '_portal_tcc_semestre';
const PORTAL_SI_TCC_PALAVRAS_META      = '_portal_tcc_palavras';
const PORTAL_SI_TCC_ARQUIVO_META       = '_portal_tcc_arquivo';
const PORTAL_SI_TCC_LINK_META          = '_portal_tcc_link';
const PORTAL_SI_TCC_EXEMPLO_META       = '_portal_tcc_exemplo';
const PORTAL_SI_TCC_UPLOAD_OPTION      = 'portal_si_tcc_allow_upload';
const PORTAL_SI_TCC_PER_PAGE           = 20;

define( 'PORTAL_SI_TCCS_SLUG', 'tccs' );

/**
 * Envio de PDF habilitado (padrão: sim).
 *
 * @return bool
 */
function portal_si_tcc_upload_enabled() {
	return (bool) apply_filters( 'portal_si_tcc_upload_enabled', '0' !== (string) get_option( PORTAL_SI_TCC_UPLOAD_OPTION, '1' ) );
}

/**
 * Registra CPT TCC.
 */
function portal_si_register_tcc_cpt() {
	register_post_type(
		PORTAL_SI_TCC_POST_TYPE,
		array(
			'labels'             => array(
				'name'               => __( 'TCCs', 'portal-si-cefet' ),
				'singular_name'      => __( 'TCC', 'portal-si-cefet' ),
				'add_new'            => __( 'Adicionar TCC', 'portal-si-cefet' ),
				'add_new_item'       => __( 'Adicionar novo TCC', 'portal-si-cefet' ),
				'edit_item'          => __( 'Editar TCC', 'portal-si-cefet' ),
				'new_item'           => __( 'Novo TCC', 'portal-si-cefet' ),
				'view_item'          => __( 'Ver TCC', 'portal-si-cefet' ),
				'search_items'       => __( 'Buscar TCCs', 'portal-si-cefet' ),
				'not_found'          => __( 'Nenhum TCC encontrado.', 'portal-si-cefet' ),
				'not_found_in_trash' => __( 'Nenhum TCC na lixeira.', 'portal-si-cefet' ),
				'all_items'          => __( 'Todos os TCCs', 'portal-si-cefet' ),
				'menu_name'          => __( 'TCCs', 'portal-si-cefet' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-book-alt',
			'menu_position'      => 29,
			'has_archive'        => false,
			'rewrite'            => array(
				'slug'       => 'tcc',
				'with_front' => false,
			),
			'supports'           => array( 'title', 'editor' ),
			'show_in_rest'       => false,
			'capability_type'    => 'post',
		)
	);
}
add_action( 'init', 'portal_si_register_tcc_cpt' );

/**
 * Permalinks /tcc/slug após registrar o CPT.
 */
function portal_si_tcc_maybe_flush_rewrites() {
	if ( get_option( 'portal_si_tcc_rewrites_v1' ) ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'portal_si_tcc_rewrites_v1', 1 );
}
add_action( 'init', 'portal_si_tcc_maybe_flush_rewrites', 99 );

/**
 * Página /tccs.
 */
function portal_si_ensure_tccs_page() {
	portal_si_ensure_page( __( 'Repositório de TCCs', 'portal-si-cefet' ), PORTAL_SI_TCCS_SLUG );
}
add_action( 'after_setup_theme', 'portal_si_ensure_tccs_page', 27 );

/* ------------------------------------------------------------------ */
/* Painel                                                              */
/* ------------------------------------------------------------------ */

/**
 * Meta box do TCC.
 */
function portal_si_tcc_add_meta_boxes() {
	add_meta_box(
		'portal-tcc-dados',
		__( 'Dados do TCC', 'portal-si-cefet' ),
		'portal_si_tcc_render_meta_box',
		PORTAL_SI_TCC_POST_TYPE,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_tcc_add_meta_boxes' );

/**
 * Texto do editor principal: é o resumo.
 *
 * @param WP_Post $post Post.
 */
function portal_si_tcc_editor_hint( $post ) {
	if ( PORTAL_SI_TCC_POST_TYPE !== $post->post_type ) {
		return;
	}
	echo '<p class="description" style="margin:1em 0 0.5em;">' . esc_html__( 'Use o editor abaixo para o RESUMO do trabalho.', 'portal-si-cefet' ) . '</p>';
}
add_action( 'edit_form_after_title', 'portal_si_tcc_editor_hint' );

/**
 * @param WP_Post $post TCC.
 */
function portal_si_tcc_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_tcc_save', 'portal_si_tcc_nonce' );
	$m = function ( $key ) use ( $post ) {
		return get_post_meta( $post->ID, $key, true );
	};
	$autores     = (array) $m( PORTAL_SI_TCC_AUTORES_META );
	$orientador  = (int) $m( PORTAL_SI_TCC_ORIENTADOR_META );
	$arquivo_id  = (int) $m( PORTAL_SI_TCC_ARQUIVO_META );
	$semestre    = (int) $m( PORTAL_SI_TCC_SEMESTRE_META );
	$upload      = portal_si_tcc_upload_enabled();
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
	<?php if ( '1' === $m( PORTAL_SI_TCC_EXEMPLO_META ) ) : ?>
		<div class="notice notice-warning inline"><p>
			<?php esc_html_e( 'Este é um TCC de EXEMPLO (aparece no site com o selo "Exemplo"). Substitua pelos dados reais e desmarque "TCC de exemplo", ou exclua.', 'portal-si-cefet' ); ?>
		</p></div>
	<?php endif; ?>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_tcc_autores"><?php esc_html_e( 'Autor(es)', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="2" id="portal_tcc_autores" name="portal_tcc_autores"><?php echo esc_textarea( implode( "\n", $autores ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Um nome por linha.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_tcc_orientador"><?php esc_html_e( 'Orientador(a)', 'portal-si-cefet' ); ?></label></th>
			<td>
				<select id="portal_tcc_orientador" name="portal_tcc_orientador">
					<option value="0"><?php esc_html_e( '— Escolha no Corpo Docente —', 'portal-si-cefet' ); ?></option>
					<?php foreach ( $professores as $prof ) : ?>
						<option value="<?php echo esc_attr( $prof->ID ); ?>" <?php selected( $orientador, $prof->ID ); ?>><?php echo esc_html( get_the_title( $prof ) ); ?></option>
					<?php endforeach; ?>
				</select>
				<p>
					<label for="portal_tcc_orientador_nome"><?php esc_html_e( 'Ou nome do(a) orientador(a) (se não estiver no Corpo Docente):', 'portal-si-cefet' ); ?></label><br />
					<input type="text" class="regular-text" id="portal_tcc_orientador_nome" name="portal_tcc_orientador_nome" value="<?php echo esc_attr( (string) $m( PORTAL_SI_TCC_ORIENTADOR_NOME_META ) ); ?>" />
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_tcc_coorientador"><?php esc_html_e( 'Coorientador(a)', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="regular-text" id="portal_tcc_coorientador" name="portal_tcc_coorientador" value="<?php echo esc_attr( (string) $m( PORTAL_SI_TCC_COORIENTADOR_META ) ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Defesa', 'portal-si-cefet' ); ?></th>
			<td>
				<label><?php esc_html_e( 'Ano', 'portal-si-cefet' ); ?> <input type="number" min="2000" max="2100" step="1" name="portal_tcc_ano" value="<?php echo esc_attr( (string) $m( PORTAL_SI_TCC_ANO_META ) ); ?>" style="width:6em;" required /></label>
				<label style="margin-left:1em;"><?php esc_html_e( 'Semestre', 'portal-si-cefet' ); ?>
					<select name="portal_tcc_semestre">
						<option value="0"><?php esc_html_e( '—', 'portal-si-cefet' ); ?></option>
						<option value="1" <?php selected( $semestre, 1 ); ?>>1º</option>
						<option value="2" <?php selected( $semestre, 2 ); ?>>2º</option>
					</select>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_tcc_palavras"><?php esc_html_e( 'Palavras-chave', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="text" class="large-text" id="portal_tcc_palavras" name="portal_tcc_palavras" value="<?php echo esc_attr( (string) $m( PORTAL_SI_TCC_PALAVRAS_META ) ); ?>" />
				<p class="description"><?php esc_html_e( 'Separadas por vírgula. Entram na busca.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Arquivo PDF', 'portal-si-cefet' ); ?></th>
			<td>
				<input type="hidden" id="portal_tcc_arquivo" name="portal_tcc_arquivo" value="<?php echo esc_attr( $arquivo_id ? $arquivo_id : '' ); ?>" />
				<span id="portal_tcc_arquivo_nome">
					<?php
					if ( $arquivo_id && get_post( $arquivo_id ) ) {
						echo esc_html( get_the_title( $arquivo_id ) . ' (' . size_format( (int) filesize( get_attached_file( $arquivo_id ) ) ) . ')' );
					} else {
						esc_html_e( 'Nenhum arquivo.', 'portal-si-cefet' );
					}
					?>
				</span>
				<?php if ( $upload ) : ?>
					<p>
						<button type="button" class="button" id="portal_tcc_arquivo_pick"><?php esc_html_e( 'Escolher PDF', 'portal-si-cefet' ); ?></button>
						<button type="button" class="button-link" id="portal_tcc_arquivo_clear"><?php esc_html_e( 'Remover', 'portal-si-cefet' ); ?></button>
					</p>
				<?php else : ?>
					<p class="description"><?php esc_html_e( 'O envio de arquivos está desligado (TCCs → Configurações). Use o link externo.', 'portal-si-cefet' ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_tcc_link"><?php esc_html_e( 'Link externo', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="url" class="large-text" id="portal_tcc_link" name="portal_tcc_link" value="<?php echo esc_attr( (string) $m( PORTAL_SI_TCC_LINK_META ) ); ?>" placeholder="https://" />
				<p class="description"><?php esc_html_e( 'Repositório oficial, Google Drive institucional etc. Pode ser usado junto com o arquivo ou no lugar dele.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Exemplo', 'portal-si-cefet' ); ?></th>
			<td><label><input type="checkbox" name="portal_tcc_exemplo" value="1" <?php checked( '1', $m( PORTAL_SI_TCC_EXEMPLO_META ) ); ?> /> <?php esc_html_e( 'TCC de exemplo (exibe o selo "Exemplo" no site)', 'portal-si-cefet' ); ?></label></td>
		</tr>
	</table>
	<?php
}

/**
 * @param int $post_id ID do TCC.
 */
function portal_si_tcc_save_meta( $post_id ) {
	if ( ! isset( $_POST['portal_si_tcc_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_tcc_nonce'] ) ), 'portal_si_tcc_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$autores = isset( $_POST['portal_tcc_autores'] ) ? portal_si_text_to_lines( sanitize_textarea_field( wp_unslash( $_POST['portal_tcc_autores'] ) ) ) : array();
	update_post_meta( $post_id, PORTAL_SI_TCC_AUTORES_META, $autores );

	$orientador = isset( $_POST['portal_tcc_orientador'] ) ? absint( $_POST['portal_tcc_orientador'] ) : 0;
	if ( $orientador && PORTAL_SI_PROFESSOR_POST_TYPE === get_post_type( $orientador ) ) {
		update_post_meta( $post_id, PORTAL_SI_TCC_ORIENTADOR_META, $orientador );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_TCC_ORIENTADOR_META );
	}

	$texts = array(
		PORTAL_SI_TCC_ORIENTADOR_NOME_META => 'portal_tcc_orientador_nome',
		PORTAL_SI_TCC_COORIENTADOR_META    => 'portal_tcc_coorientador',
		PORTAL_SI_TCC_PALAVRAS_META        => 'portal_tcc_palavras',
	);
	foreach ( $texts as $meta => $field ) {
		update_post_meta( $post_id, $meta, isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '' );
	}

	$ano = isset( $_POST['portal_tcc_ano'] ) ? absint( $_POST['portal_tcc_ano'] ) : 0;
	if ( $ano >= 2000 && $ano <= 2100 ) {
		update_post_meta( $post_id, PORTAL_SI_TCC_ANO_META, $ano );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_TCC_ANO_META );
	}
	$semestre = isset( $_POST['portal_tcc_semestre'] ) ? absint( $_POST['portal_tcc_semestre'] ) : 0;
	update_post_meta( $post_id, PORTAL_SI_TCC_SEMESTRE_META, in_array( $semestre, array( 1, 2 ), true ) ? $semestre : 0 );

	$current_file = (int) get_post_meta( $post_id, PORTAL_SI_TCC_ARQUIVO_META, true );
	$arquivo      = isset( $_POST['portal_tcc_arquivo'] ) ? absint( $_POST['portal_tcc_arquivo'] ) : 0;
	if ( ! portal_si_tcc_upload_enabled() && $arquivo !== $current_file ) {
		$arquivo = $current_file;
	}
	if ( $arquivo && 'application/pdf' === get_post_mime_type( $arquivo ) ) {
		update_post_meta( $post_id, PORTAL_SI_TCC_ARQUIVO_META, $arquivo );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_TCC_ARQUIVO_META );
	}

	$link = isset( $_POST['portal_tcc_link'] ) ? esc_url_raw( wp_unslash( $_POST['portal_tcc_link'] ), array( 'http', 'https' ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_TCC_LINK_META, $link );

	if ( ! empty( $_POST['portal_tcc_exemplo'] ) ) {
		update_post_meta( $post_id, PORTAL_SI_TCC_EXEMPLO_META, '1' );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_TCC_EXEMPLO_META );
	}
}
add_action( 'save_post_' . PORTAL_SI_TCC_POST_TYPE, 'portal_si_tcc_save_meta' );

/**
 * Colunas no painel.
 *
 * @param string[] $columns Colunas.
 * @return string[]
 */
function portal_si_tcc_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['portal_tcc_autores']    = __( 'Autor(es)', 'portal-si-cefet' );
			$new['portal_tcc_orientador'] = __( 'Orientador(a)', 'portal-si-cefet' );
			$new['portal_tcc_periodo']    = __( 'Defesa', 'portal-si-cefet' );
			$new['portal_tcc_acesso']     = __( 'Acesso', 'portal-si-cefet' );
		}
	}
	return $new;
}
add_filter( 'manage_' . PORTAL_SI_TCC_POST_TYPE . '_posts_columns', 'portal_si_tcc_admin_columns' );

/**
 * @param string $column  Coluna.
 * @param int    $post_id ID.
 */
function portal_si_tcc_admin_column_content( $column, $post_id ) {
	$tcc = portal_si_tcc_to_array( $post_id, false );
	if ( ! $tcc ) {
		return;
	}
	switch ( $column ) {
		case 'portal_tcc_autores':
			echo esc_html( $tcc['autores_text'] ? $tcc['autores_text'] : '—' );
			if ( $tcc['exemplo'] ) {
				echo ' <strong>(' . esc_html__( 'exemplo', 'portal-si-cefet' ) . ')</strong>';
			}
			break;
		case 'portal_tcc_orientador':
			echo esc_html( $tcc['orientador'] ? $tcc['orientador'] : '—' );
			break;
		case 'portal_tcc_periodo':
			echo esc_html( $tcc['periodo'] ? $tcc['periodo'] : '—' );
			break;
		case 'portal_tcc_acesso':
			$parts = array();
			if ( $tcc['file_url'] ) {
				$parts[] = 'PDF (' . $tcc['file_size'] . ')';
			}
			if ( $tcc['link'] ) {
				$parts[] = __( 'Link', 'portal-si-cefet' );
			}
			echo esc_html( $parts ? implode( ' + ', $parts ) : '—' );
			break;
	}
}
add_action( 'manage_' . PORTAL_SI_TCC_POST_TYPE . '_posts_custom_column', 'portal_si_tcc_admin_column_content', 10, 2 );

/**
 * Aviso na listagem enquanto houver TCCs de exemplo.
 */
function portal_si_tcc_exemplo_notice() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'edit-' . PORTAL_SI_TCC_POST_TYPE !== $screen->id ) {
		return;
	}
	$count = count(
		get_posts(
			array(
				'post_type'      => PORTAL_SI_TCC_POST_TYPE,
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => PORTAL_SI_TCC_EXEMPLO_META,
				'meta_value'     => '1',
			)
		)
	);
	if ( ! $count ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>';
	printf(
		/* translators: %d: quantidade de TCCs de exemplo. */
		esc_html( _n( 'Há %d TCC de exemplo publicado. Substitua pelos TCCs reais (desmarcando "TCC de exemplo") ou exclua.', 'Há %d TCCs de exemplo publicados. Substitua pelos TCCs reais (desmarcando "TCC de exemplo") ou exclua.', $count, 'portal-si-cefet' ) ),
		(int) $count
	);
	echo '</p></div>';
}
add_action( 'admin_notices', 'portal_si_tcc_exemplo_notice' );

/**
 * Seletor de PDF.
 *
 * @param string $hook Tela.
 */
function portal_si_tcc_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || PORTAL_SI_TCC_POST_TYPE !== $screen->post_type || ! portal_si_tcc_upload_enabled() ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script(
		'portal-si-tcc-admin',
		get_template_directory_uri() . '/assets/js/tcc-admin.js',
		array( 'jquery' ),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'portal_si_tcc_admin_assets' );

/* —— Configurações (envio de arquivos e espaço usado) —— */

/**
 * Submenu TCCs → Configurações.
 */
function portal_si_tcc_settings_menu() {
	add_submenu_page(
		'edit.php?post_type=' . PORTAL_SI_TCC_POST_TYPE,
		__( 'Configurações do repositório', 'portal-si-cefet' ),
		__( 'Configurações', 'portal-si-cefet' ),
		'manage_options',
		'portal-si-tcc-config',
		'portal_si_tcc_render_settings'
	);
}
add_action( 'admin_menu', 'portal_si_tcc_settings_menu' );

/**
 * Registra a opção de envio.
 */
function portal_si_tcc_register_setting() {
	register_setting(
		'portal_si_tcc_config',
		PORTAL_SI_TCC_UPLOAD_OPTION,
		array(
			'type'              => 'string',
			'default'           => '1',
			'sanitize_callback' => function ( $value ) {
				return '1' === (string) $value ? '1' : '0';
			},
		)
	);
}
add_action( 'admin_init', 'portal_si_tcc_register_setting' );

/**
 * Espaço ocupado pelos PDFs vinculados a TCCs.
 *
 * @return array{count: int, bytes: int}
 */
function portal_si_tcc_storage_usage() {
	global $wpdb;
	$ids   = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value <> ''", PORTAL_SI_TCC_ARQUIVO_META ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$bytes = 0;
	$count = 0;
	foreach ( $ids as $id ) {
		$path = get_attached_file( (int) $id );
		if ( $path && file_exists( $path ) ) {
			$bytes += (int) filesize( $path );
			++$count;
		}
	}
	return array(
		'count' => $count,
		'bytes' => $bytes,
	);
}

/**
 * Tela de configurações.
 */
function portal_si_tcc_render_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$usage = portal_si_tcc_storage_usage();
	$avg   = $usage['count'] ? (int) ( $usage['bytes'] / $usage['count'] ) : 0;
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Configurações do repositório de TCCs', 'portal-si-cefet' ); ?></h1>

		<h2><?php esc_html_e( 'Espaço usado pelos PDFs', 'portal-si-cefet' ); ?></h2>
		<p>
			<?php
			printf(
				/* translators: 1: quantidade de arquivos, 2: tamanho total. */
				esc_html__( '%1$d arquivo(s), total de %2$s.', 'portal-si-cefet' ),
				(int) $usage['count'],
				esc_html( size_format( $usage['bytes'] ? $usage['bytes'] : 0 ) )
			);
			if ( $avg ) {
				echo ' ';
				printf(
					/* translators: 1: tamanho médio, 2: estimativa para 200 TCCs. */
					esc_html__( 'Média de %1$s por arquivo: 200 TCCs ocupariam cerca de %2$s.', 'portal-si-cefet' ),
					esc_html( size_format( $avg ) ),
					esc_html( size_format( $avg * 200 ) )
				);
			}
			?>
		</p>

		<form method="post" action="options.php">
			<?php settings_fields( 'portal_si_tcc_config' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><?php esc_html_e( 'Envio de arquivos', 'portal-si-cefet' ); ?></th>
					<td>
						<input type="hidden" name="<?php echo esc_attr( PORTAL_SI_TCC_UPLOAD_OPTION ); ?>" value="0" />
						<label>
							<input type="checkbox" name="<?php echo esc_attr( PORTAL_SI_TCC_UPLOAD_OPTION ); ?>" value="1" <?php checked( portal_si_tcc_upload_enabled() ); ?> />
							<?php esc_html_e( 'Permitir anexar o PDF do TCC no portal', 'portal-si-cefet' ); ?>
						</label>
						<p class="description">
							<?php esc_html_e( 'Desligado, o cadastro aceita apenas link externo (ex.: repositório oficial). Os PDFs já anexados continuam disponíveis.', 'portal-si-cefet' ); ?>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Importa os TCCs de exemplo uma vez, se ainda não houver TCCs.
 */
function portal_si_tcc_maybe_seed() {
	if ( ! add_option( 'portal_si_tccs_seeded', 1, '', false ) ) {
		return;
	}
	$existing = get_posts(
		array(
			'post_type'      => PORTAL_SI_TCC_POST_TYPE,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		return;
	}

	$items = require get_template_directory() . '/data/tccs-exemplo.php';
	foreach ( (array) $items as $item ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => PORTAL_SI_TCC_POST_TYPE,
				'post_status'  => 'publish',
				'post_title'   => $item['title'],
				'post_content' => $item['resumo'],
			),
			true
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}
		update_post_meta( $post_id, PORTAL_SI_TCC_AUTORES_META, $item['autores'] );
		update_post_meta( $post_id, PORTAL_SI_TCC_ORIENTADOR_NOME_META, __( 'Docente orientador(a) (exemplo)', 'portal-si-cefet' ) );
		update_post_meta( $post_id, PORTAL_SI_TCC_ANO_META, (int) $item['ano'] );
		update_post_meta( $post_id, PORTAL_SI_TCC_SEMESTRE_META, (int) $item['semestre'] );
		update_post_meta( $post_id, PORTAL_SI_TCC_PALAVRAS_META, $item['palavras'] );
		update_post_meta( $post_id, PORTAL_SI_TCC_EXEMPLO_META, '1' );
	}
}
add_action( 'init', 'portal_si_tcc_maybe_seed', 20 );

/* ------------------------------------------------------------------ */
/* Dados                                                               */
/* ------------------------------------------------------------------ */

/**
 * TCC normalizado para templates.
 *
 * @param int|WP_Post $post        TCC.
 * @param bool        $only_public Exigir publicado.
 * @return array<string, mixed>|null
 */
function portal_si_tcc_to_array( $post, $only_public = true ) {
	$post = get_post( $post );
	if ( ! $post || PORTAL_SI_TCC_POST_TYPE !== $post->post_type ) {
		return null;
	}
	if ( $only_public && 'publish' !== $post->post_status ) {
		return null;
	}

	$autores  = array_values( array_filter( (array) get_post_meta( $post->ID, PORTAL_SI_TCC_AUTORES_META, true ), 'is_string' ) );
	$orient   = (int) get_post_meta( $post->ID, PORTAL_SI_TCC_ORIENTADOR_META, true );
	$orient_ok = $orient && 'publish' === get_post_status( $orient );
	$ano      = (int) get_post_meta( $post->ID, PORTAL_SI_TCC_ANO_META, true );
	$semestre = (int) get_post_meta( $post->ID, PORTAL_SI_TCC_SEMESTRE_META, true );
	$palavras = array_values( array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post->ID, PORTAL_SI_TCC_PALAVRAS_META, true ) ) ) ) );
	$file_id  = (int) get_post_meta( $post->ID, PORTAL_SI_TCC_ARQUIVO_META, true );
	$file_url = $file_id ? (string) wp_get_attachment_url( $file_id ) : '';
	$path     = $file_url ? get_attached_file( $file_id ) : '';

	if ( $ano && $semestre ) {
		$periodo = $ano . '.' . $semestre;
	} else {
		$periodo = $ano ? (string) $ano : '';
	}

	return array(
		'id'             => (int) $post->ID,
		'title'          => get_the_title( $post ),
		'url'            => get_permalink( $post ),
		'autores'        => $autores,
		'autores_text'   => implode( ', ', $autores ),
		'orientador'     => $orient_ok ? get_the_title( $orient ) : (string) get_post_meta( $post->ID, PORTAL_SI_TCC_ORIENTADOR_NOME_META, true ),
		'orientador_id'  => $orient_ok ? $orient : 0,
		'orientador_url' => $orient_ok ? get_permalink( $orient ) : '',
		'coorientador'   => (string) get_post_meta( $post->ID, PORTAL_SI_TCC_COORIENTADOR_META, true ),
		'ano'            => $ano,
		'semestre'       => $semestre,
		'periodo'        => $periodo,
		'palavras'       => $palavras,
		'file_url'       => $file_url,
		'file_size'      => ( $path && file_exists( $path ) ) ? size_format( (int) filesize( $path ) ) : '',
		'link'           => (string) get_post_meta( $post->ID, PORTAL_SI_TCC_LINK_META, true ),
		'exemplo'        => '1' === get_post_meta( $post->ID, PORTAL_SI_TCC_EXEMPLO_META, true ),
	);
}

/**
 * Texto em minúsculas e sem acentos, para busca.
 *
 * @param string $text Texto.
 * @return string
 */
function portal_si_tcc_normalize( $text ) {
	return mb_strtolower( remove_accents( (string) $text ) );
}

/**
 * Todos os TCCs publicados, do mais recente ao mais antigo.
 *
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_all_tccs() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$ids   = get_posts(
		array(
			'post_type'      => PORTAL_SI_TCC_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
	$cache = array_values( array_filter( array_map( 'portal_si_tcc_to_array', $ids ) ) );
	usort(
		$cache,
		function ( $a, $b ) {
			return array( $b['ano'], $b['semestre'], $a['title'] ) <=> array( $a['ano'], $a['semestre'], $b['title'] );
		}
	);
	return $cache;
}

/**
 * Filtros da página (?busca=, ?ano=, ?orientador=).
 *
 * @return array{busca: string, ano: int, orientador: string}
 */
function portal_si_tccs_current_filters() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	return array(
		'busca'      => isset( $_GET['busca'] ) ? sanitize_text_field( wp_unslash( $_GET['busca'] ) ) : '',
		'ano'        => isset( $_GET['ano'] ) ? absint( $_GET['ano'] ) : 0,
		'orientador' => isset( $_GET['orientador'] ) ? sanitize_text_field( wp_unslash( $_GET['orientador'] ) ) : '',
	);
	// phpcs:enable
}

/**
 * TCCs filtrados (busca em título, autores, orientador e palavras-chave; sem acento).
 *
 * @param array{busca?: string, ano?: int, orientador?: string} $filters Filtros.
 * @return array<int, array<string, mixed>>
 */
function portal_si_filter_tccs( array $filters ) {
	$terms = array_filter( explode( ' ', portal_si_tcc_normalize( $filters['busca'] ?? '' ) ) );
	$out   = array();
	foreach ( portal_si_get_all_tccs() as $tcc ) {
		if ( ! empty( $filters['ano'] ) && (int) $filters['ano'] !== $tcc['ano'] ) {
			continue;
		}
		if ( ! empty( $filters['orientador'] ) && $filters['orientador'] !== $tcc['orientador'] ) {
			continue;
		}
		if ( $terms ) {
			$haystack = portal_si_tcc_normalize( $tcc['title'] . ' ' . $tcc['autores_text'] . ' ' . $tcc['orientador'] . ' ' . $tcc['coorientador'] . ' ' . implode( ' ', $tcc['palavras'] ) );
			foreach ( $terms as $term ) {
				if ( false === strpos( $haystack, $term ) ) {
					continue 2;
				}
			}
		}
		$out[] = $tcc;
	}
	return $out;
}

/**
 * Anos e orientadores existentes (para os filtros).
 *
 * @return array{anos: int[], orientadores: string[]}
 */
function portal_si_tccs_filter_options() {
	$anos         = array();
	$orientadores = array();
	foreach ( portal_si_get_all_tccs() as $tcc ) {
		if ( $tcc['ano'] ) {
			$anos[ $tcc['ano'] ] = $tcc['ano'];
		}
		if ( $tcc['orientador'] ) {
			$orientadores[ $tcc['orientador'] ] = $tcc['orientador'];
		}
	}
	krsort( $anos );
	ksort( $orientadores );
	return array(
		'anos'         => array_values( $anos ),
		'orientadores' => array_values( $orientadores ),
	);
}

/**
 * TCCs orientados por um professor.
 *
 * @param int $professor_id ID do professor.
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_tccs_do_professor( $professor_id ) {
	return array_values(
		array_filter(
			portal_si_get_all_tccs(),
			function ( $tcc ) use ( $professor_id ) {
				return (int) $professor_id === $tcc['orientador_id'];
			}
		)
	);
}

/* ------------------------------------------------------------------ */
/* Front-end                                                           */
/* ------------------------------------------------------------------ */

/**
 * @param string[] $classes Classes do body.
 * @return string[]
 */
function portal_si_tcc_body_class( $classes ) {
	if ( is_page( PORTAL_SI_TCCS_SLUG ) || is_singular( PORTAL_SI_TCC_POST_TYPE ) ) {
		$classes[] = 'portal-is-tcc';
	}
	return $classes;
}
add_filter( 'body_class', 'portal_si_tcc_body_class' );

/**
 * CSS do repositório (também no perfil do professor, seção "TCCs orientados").
 */
function portal_si_tcc_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_TCCS_SLUG ) && ! is_singular( array( PORTAL_SI_TCC_POST_TYPE, PORTAL_SI_PROFESSOR_POST_TYPE ) ) ) {
		return;
	}
	wp_enqueue_style(
		'portal-si-tcc',
		get_template_directory_uri() . '/assets/css/tcc.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_tcc_enqueue_assets', 16 );
