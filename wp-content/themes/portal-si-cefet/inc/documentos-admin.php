<?php
/**
 * Documentos institucionais — publicações editáveis no wp-admin (RF06).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_DOCUMENTOS_UPLOADS_META', '_portal_si_documentos_uploads' );

/**
 * Secções da página onde uma publicação pode aparecer.
 *
 * @return array<string, string>
 */
function portal_si_documentos_upload_sections() {
	return array(
		'editorial' => __( 'Comunicados e publicações do curso', 'portal-si-cefet' ),
		'curso'     => __( 'Curso de Sistemas de Informação', 'portal-si-cefet' ),
	);
}

/**
 * Secção padrão conforme tipo (normativos → bloco do curso).
 *
 * @param string $kind Tipo sanitizado.
 * @param string $title Título.
 * @return string
 */
function portal_si_documentos_default_upload_section( $kind, $title = '' ) {
	if ( 'normativo' === $kind ) {
		return 'curso';
	}

	$title_l = strtolower( remove_accents( $title ) );
	if ( false !== strpos( $title_l, 'ppc' ) || false !== strpos( $title_l, 'projeto pedagogico' ) ) {
		return 'curso';
	}

	return 'editorial';
}

/**
 * Normaliza secção guardada ou inferida.
 *
 * @param array<string, mixed> $row Linha bruta.
 * @return string
 */
function portal_si_documentos_normalize_upload_section( array $row ) {
	$sections = portal_si_documentos_upload_sections();
	$section  = isset( $row['section'] ) ? sanitize_key( (string) $row['section'] ) : '';

	if ( isset( $sections[ $section ] ) ) {
		return $section;
	}

	$kind  = isset( $row['kind'] ) ? sanitize_key( (string) $row['kind'] ) : 'outro';
	$title = isset( $row['title'] ) ? (string) $row['title'] : '';

	return portal_si_documentos_default_upload_section( $kind, $title );
}

/**
 * Tipos de publicação (rótulo no site).
 *
 * @return array<string, string>
 */
function portal_si_documentos_upload_kinds() {
	return array(
		'normativo'   => __( 'Normativo', 'portal-si-cefet' ),
		'memorando'   => __( 'Memorando', 'portal-si-cefet' ),
		'comunicado'  => __( 'Comunicado', 'portal-si-cefet' ),
		'atualizacao' => __( 'Atualização', 'portal-si-cefet' ),
		'outro'       => __( 'Documento', 'portal-si-cefet' ),
	);
}

/**
 * Publicações guardadas na página Documentos Institucionais.
 *
 * @param int $page_id ID da página.
 * @return array<int, array<string, mixed>>
 */
function portal_si_documentos_get_uploads( $page_id = 0 ) {
	if ( ! $page_id ) {
		$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_DOCUMENTOS_SLUG );
	}
	if ( ! $page_id ) {
		return array();
	}

	$stored = get_post_meta( $page_id, PORTAL_SI_DOCUMENTOS_UPLOADS_META, true );
	if ( ! is_array( $stored ) ) {
		return array();
	}

	$kinds = portal_si_documentos_upload_kinds();
	$out   = array();

	foreach ( $stored as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$title = isset( $row['title'] ) ? trim( (string) $row['title'] ) : '';
		if ( '' === $title ) {
			continue;
		}

		$attachment_id = isset( $row['attachment_id'] ) ? absint( $row['attachment_id'] ) : 0;
		$external_url  = isset( $row['external_url'] ) ? esc_url_raw( (string) $row['external_url'] ) : '';
		$url           = '';

		if ( $attachment_id ) {
			$file_url = wp_get_attachment_url( $attachment_id );
			if ( $file_url ) {
				$url = $file_url;
			}
		} elseif ( $external_url ) {
			$url = $external_url;
		}

		if ( '' === $url ) {
			continue;
		}

		$kind = isset( $row['kind'] ) ? sanitize_key( (string) $row['kind'] ) : 'outro';
		if ( ! isset( $kinds[ $kind ] ) ) {
			$kind = 'outro';
		}

		$date_raw = isset( $row['date'] ) ? (string) $row['date'] : '';
		$date_ts  = $date_raw ? strtotime( $date_raw ) : 0;

		$meta = $kinds[ $kind ];
		if ( $date_ts > 0 ) {
			$meta .= ' · ' . wp_date( 'd/m/Y', $date_ts );
		}

		$mime = $attachment_id ? get_post_mime_type( $attachment_id ) : '';
		if ( $attachment_id && $mime && false !== strpos( $mime, 'pdf' ) ) {
			$meta = 'PDF · ' . $meta;
		}

		$section = portal_si_documentos_normalize_upload_section( $row );

		$out[] = array(
			'title'       => $title,
			'description' => isset( $row['description'] ) ? trim( (string) $row['description'] ) : '',
			'url'         => $url,
			'meta'        => $meta,
			'external'    => (bool) ( $external_url && ! $attachment_id ),
			'editorial'   => 'editorial' === $section,
			'section'     => $section,
			'date_ts'     => $date_ts,
		);
	}

	usort(
		$out,
		static function ( $a, $b ) {
			$ta = isset( $a['date_ts'] ) ? (int) $a['date_ts'] : 0;
			$tb = isset( $b['date_ts'] ) ? (int) $b['date_ts'] : 0;
			if ( $ta === $tb ) {
				return 0;
			}
			return $ta > $tb ? -1 : 1;
		}
	);

	return $out;
}

/**
 * Publicações por secção da página.
 *
 * @param int    $page_id ID da página.
 * @param string $section editorial|curso.
 * @return array<int, array<string, mixed>>
 */
function portal_si_documentos_get_uploads_for_section( $section, $page_id = 0 ) {
	$section = sanitize_key( $section );
	$all     = portal_si_documentos_get_uploads( $page_id );

	return array_values(
		array_filter(
			$all,
			static function ( $item ) use ( $section ) {
				return isset( $item['section'] ) && $section === $item['section'];
			}
		)
	);
}

/**
 * Converte publicações editáveis num grupo para o template.
 *
 * @param int $page_id ID da página.
 * @return array<string, mixed>|null
 */
function portal_si_documentos_editorial_group( $page_id = 0 ) {
	$items = portal_si_documentos_get_uploads_for_section( 'editorial', $page_id );
	if ( empty( $items ) ) {
		return null;
	}

	$config = portal_si_documentos_config();
	$block  = isset( $config['editorial_group'] ) && is_array( $config['editorial_group'] ) ? $config['editorial_group'] : array();

	return array(
		'id'    => 'editorial',
		'title' => isset( $block['title'] ) ? (string) $block['title'] : __( 'Comunicados e publicações do curso', 'portal-si-cefet' ),
		'intro' => isset( $block['intro'] ) ? (string) $block['intro'] : '',
		'items' => $items,
	);
}

/**
 * Meta box na página Documentos Institucionais.
 */
function portal_si_documentos_add_meta_box() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->id ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post || PORTAL_SI_DOCUMENTOS_SLUG !== $post->post_name ) {
			return;
		}
	}

	add_meta_box(
		'portal-si-documentos-uploads',
		__( 'Publicações do curso (PDF e arquivos)', 'portal-si-cefet' ),
		'portal_si_documentos_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_documentos_add_meta_box' );

/**
 * @param WP_Post $post Post atual.
 */
function portal_si_documentos_render_meta_box( $post ) {
	if ( PORTAL_SI_DOCUMENTOS_SLUG !== $post->post_name ) {
		echo '<p>' . esc_html__( 'Esta caixa só aparece na página Documentos Institucionais.', 'portal-si-cefet' ) . '</p>';
		return;
	}

	wp_nonce_field( 'portal_si_documentos_save', 'portal_si_documentos_nonce' );

	$stored = get_post_meta( $post->ID, PORTAL_SI_DOCUMENTOS_UPLOADS_META, true );
	if ( ! is_array( $stored ) ) {
		$stored = array();
	}

	$kinds = portal_si_documentos_upload_kinds();
	?>
	<p class="portal-documentos-admin-help">
		<?php esc_html_e( 'Use esta área para memorandos, normativos, comunicados e PDFs enviados à comunidade (ex.: orientação sobre mudança de grade). Os links fixos do CEFET/RJ continuam definidos pelo tema — não é preciso alterar código.', 'portal-si-cefet' ); ?>
	</p>
	<p>
		<button type="button" class="button button-secondary" id="portal_si_doc_add_row">
			<?php esc_html_e( 'Adicionar publicação', 'portal-si-cefet' ); ?>
		</button>
	</p>
	<div id="portal_si_doc_rows">
		<?php
		if ( empty( $stored ) ) {
			$stored = array( array() );
		}
		foreach ( $stored as $index => $row ) {
			portal_si_documentos_render_upload_row( (int) $index, is_array( $row ) ? $row : array(), $kinds );
		}
		?>
	</div>
	<template id="portal_si_doc_row_template">
		<?php portal_si_documentos_render_upload_row( '__INDEX__', array(), $kinds ); ?>
	</template>
	<?php
}

/**
 * Uma linha do formulário de publicações.
 *
 * @param int|string           $index Índice ou placeholder.
 * @param array<string, mixed> $row   Dados.
 * @param array<string, string> $kinds Tipos.
 */
function portal_si_documentos_render_upload_row( $index, array $row, array $kinds ) {
	$attachment_id = isset( $row['attachment_id'] ) ? absint( $row['attachment_id'] ) : 0;
	$file_label    = '';
	if ( $attachment_id ) {
		$file_label = basename( get_attached_file( $attachment_id ) ?: '' );
		if ( ! $file_label ) {
			$file_label = get_the_title( $attachment_id );
		}
	}
	$kind = isset( $row['kind'] ) ? sanitize_key( (string) $row['kind'] ) : 'comunicado';
	if ( ! isset( $kinds[ $kind ] ) ) {
		$kind = 'comunicado';
	}
	$sections      = portal_si_documentos_upload_sections();
	$section       = portal_si_documentos_normalize_upload_section( $row );
	$title_for_def = isset( $row['title'] ) ? (string) $row['title'] : '';
	if ( ! isset( $row['section'] ) && '' === $title_for_def ) {
		$section = portal_si_documentos_default_upload_section( $kind, '' );
	}
	?>
	<fieldset class="portal-documentos-admin-row" data-row-index="<?php echo esc_attr( (string) $index ); ?>">
		<legend>
			<?php
			printf(
				/* translators: %d: row number */
				esc_html__( 'Publicação %s', 'portal-si-cefet' ),
				is_numeric( $index ) ? (string) ( (int) $index + 1 ) : '#'
			);
			?>
			<button type="button" class="button-link-delete portal-documentos-admin-remove" aria-label="<?php esc_attr_e( 'Remover', 'portal-si-cefet' ); ?>">
				<?php esc_html_e( 'Remover', 'portal-si-cefet' ); ?>
			</button>
		</legend>
		<table class="form-table portal-documentos-admin-grid">
			<tr>
				<th scope="row"><label><?php esc_html_e( 'Título', 'portal-si-cefet' ); ?></label></th>
				<td>
					<input type="text" class="large-text" name="portal_si_documentos_upload[<?php echo esc_attr( (string) $index ); ?>][title]" value="<?php echo esc_attr( isset( $row['title'] ) ? (string) $row['title'] : '' ); ?>" required />
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php esc_html_e( 'Tipo', 'portal-si-cefet' ); ?></label></th>
				<td>
					<select name="portal_si_documentos_upload[<?php echo esc_attr( (string) $index ); ?>][kind]">
						<?php foreach ( $kinds as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $kind, $key ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php esc_html_e( 'Exibir na seção', 'portal-si-cefet' ); ?></label></th>
				<td>
					<select name="portal_si_documentos_upload[<?php echo esc_attr( (string) $index ); ?>][section]">
						<?php foreach ( $sections as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $section, $key ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description"><?php esc_html_e( 'Normativos e PPC costumam ficar em «Curso de Sistemas de Informação»; comunicados e memorandos, no topo.', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php esc_html_e( 'Data da publicação', 'portal-si-cefet' ); ?></label></th>
				<td>
					<input type="date" name="portal_si_documentos_upload[<?php echo esc_attr( (string) $index ); ?>][date]" value="<?php echo esc_attr( isset( $row['date'] ) ? (string) $row['date'] : '' ); ?>" />
					<p class="description"><?php esc_html_e( 'Opcional. Usada para ordenar (mais recente primeiro).', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php esc_html_e( 'Resumo', 'portal-si-cefet' ); ?></label></th>
				<td>
					<textarea class="large-text" rows="2" name="portal_si_documentos_upload[<?php echo esc_attr( (string) $index ); ?>][description]"><?php echo esc_textarea( isset( $row['description'] ) ? (string) $row['description'] : '' ); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php esc_html_e( 'Arquivo (PDF)', 'portal-si-cefet' ); ?></label></th>
				<td>
					<input type="hidden" class="portal-doc-attachment-id" name="portal_si_documentos_upload[<?php echo esc_attr( (string) $index ); ?>][attachment_id]" value="<?php echo esc_attr( (string) $attachment_id ); ?>" />
					<p class="portal-doc-file-name"><?php echo esc_html( $file_label ? $file_label : __( 'Nenhum ficheiro selecionado', 'portal-si-cefet' ) ); ?></p>
					<button type="button" class="button portal-doc-pick"><?php esc_html_e( 'Escolher na biblioteca', 'portal-si-cefet' ); ?></button>
					<button type="button" class="button portal-doc-clear"><?php esc_html_e( 'Limpar ficheiro', 'portal-si-cefet' ); ?></button>
				</td>
			</tr>
			<tr>
				<th scope="row"><label><?php esc_html_e( 'Ou link externo', 'portal-si-cefet' ); ?></label></th>
				<td>
					<input type="url" class="large-text" name="portal_si_documentos_upload[<?php echo esc_attr( (string) $index ); ?>][external_url]" value="<?php echo esc_attr( isset( $row['external_url'] ) ? (string) $row['external_url'] : '' ); ?>" placeholder="https://" />
					<p class="description"><?php esc_html_e( 'Use ficheiro OU link. Se ambos estiverem preenchidos, prevalece o ficheiro da biblioteca.', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
}

/**
 * @param int $post_id ID do post.
 */
function portal_si_documentos_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_documentos_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_documentos_nonce'] ) ), 'portal_si_documentos_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || PORTAL_SI_DOCUMENTOS_SLUG !== $post->post_name ) {
		return;
	}

	$raw      = isset( $_POST['portal_si_documentos_upload'] ) && is_array( $_POST['portal_si_documentos_upload'] ) ? wp_unslash( $_POST['portal_si_documentos_upload'] ) : array();
	$kinds    = portal_si_documentos_upload_kinds();
	$sections = portal_si_documentos_upload_sections();
	$stored   = array();

	foreach ( $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$title = isset( $row['title'] ) ? sanitize_text_field( (string) $row['title'] ) : '';
		if ( '' === $title ) {
			continue;
		}

		$kind = isset( $row['kind'] ) ? sanitize_key( (string) $row['kind'] ) : 'outro';
		if ( ! isset( $kinds[ $kind ] ) ) {
			$kind = 'outro';
		}

		$section = isset( $row['section'] ) ? sanitize_key( (string) $row['section'] ) : '';
		if ( ! isset( $sections[ $section ] ) ) {
			$section = portal_si_documentos_default_upload_section( $kind, $title );
		}

		$attachment_id = isset( $row['attachment_id'] ) ? absint( $row['attachment_id'] ) : 0;
		$external_url  = isset( $row['external_url'] ) ? esc_url_raw( (string) $row['external_url'] ) : '';
		$date          = isset( $row['date'] ) ? sanitize_text_field( (string) $row['date'] ) : '';

		if ( ! $attachment_id && '' === $external_url ) {
			continue;
		}

		$stored[] = array(
			'title'         => $title,
			'description'   => isset( $row['description'] ) ? sanitize_textarea_field( (string) $row['description'] ) : '',
			'kind'          => $kind,
			'section'       => $section,
			'date'          => $date,
			'attachment_id' => $attachment_id,
			'external_url'  => $external_url,
		);
	}

	update_post_meta( $post_id, PORTAL_SI_DOCUMENTOS_UPLOADS_META, $stored );
}
add_action( 'save_post_page', 'portal_si_documentos_save_meta_box' );

/**
 * Scripts do meta box.
 *
 * @param string $hook_suffix Hook admin.
 */
function portal_si_documentos_admin_assets( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->id ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post || PORTAL_SI_DOCUMENTOS_SLUG !== $post->post_name ) {
			return;
		}
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'portal-si-documentos-admin',
		get_template_directory_uri() . '/assets/css/documentos-admin.css',
		array(),
		PORTAL_SI_CEFET_VERSION
	);
	wp_enqueue_script(
		'portal-si-documentos-admin',
		get_template_directory_uri() . '/assets/js/documentos-admin.js',
		array( 'jquery' ),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'portal_si_documentos_admin_assets' );
