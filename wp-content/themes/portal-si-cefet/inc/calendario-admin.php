<?php
/**
 * Calendário Acadêmico — edição no wp-admin (meta da página).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_CALENDARIO_META_KEY', '_portal_si_calendario_data' );
define( 'PORTAL_SI_CALENDARIO_META_SEEDED', 'portal_si_calendario_meta_seeded_v1' );
define( 'PORTAL_SI_CALENDARIO_REVISION_AT', '_portal_si_calendario_revision_at' );
define( 'PORTAL_SI_CALENDARIO_REVISION_BY', '_portal_si_calendario_revision_by' );

/**
 * Defaults do ficheiro data/ (só seed / fallback).
 *
 * @return array<string, mixed>
 */
function portal_si_calendario_defaults() {
	static $defaults = null;
	if ( null !== $defaults ) {
		return $defaults;
	}

	$path = get_template_directory() . '/data/calendario-academico.php';
	if ( is_readable( $path ) ) {
		$loaded = require $path;
		if ( is_array( $loaded ) ) {
			$defaults = $loaded;
			return $defaults;
		}
	}

	$defaults = array();
	return $defaults;
}

/**
 * Dados guardados na página ou defaults.
 *
 * @param int $page_id ID da página calendário.
 * @return array<string, mixed>
 */
function portal_si_calendario_get_page_data( $page_id = 0 ) {
	if ( ! $page_id ) {
		$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CALENDARIO_SLUG );
	}
	$defaults = portal_si_calendario_defaults();
	if ( ! $page_id ) {
		return $defaults;
	}

	$stored = get_post_meta( $page_id, PORTAL_SI_CALENDARIO_META_KEY, true );
	if ( ! is_array( $stored ) || empty( $stored ) ) {
		return $defaults;
	}

	$out = portal_si_calendario_merge_config( $defaults, $stored );
	portal_si_calendario_apply_dynamic_labels( $out );

	return $out;
}

/**
 * Título do semestre conforme o ano letivo (ex.: 2027.1).
 *
 * @param int $semester_index 0 = 1º semestre, 1 = 2º semestre.
 * @param int $year           Ano letivo.
 * @return string
 */
function portal_si_calendario_semester_title( $semester_index, $year ) {
	$year = (int) $year;
	if ( 0 === (int) $semester_index ) {
		return sprintf(
			/* translators: 1: academic year, 2: semester number (1 or 2) */
			__( '1º semestre (%1$d.%2$d)', 'portal-si-cefet' ),
			$year,
			1
		);
	}
	return sprintf(
		/* translators: 1: academic year, 2: semester number (1 or 2) */
		__( '2º semestre (%1$d.%2$d)', 'portal-si-cefet' ),
		$year,
		2
	);
}

/**
 * Título do grupo de prazos administrativos conforme o ano.
 *
 * @param int $group_index 0, 1 ou 2.
 * @param int $year        Ano letivo.
 * @return string
 */
function portal_si_calendario_admin_group_title( $group_index, $year ) {
	$year = (int) $year;
	if ( 0 === (int) $group_index ) {
		return sprintf(
			__( 'Renovação de matrícula — %d.1', 'portal-si-cefet' ),
			$year
		);
	}
	if ( 1 === (int) $group_index ) {
		return sprintf(
			__( 'Renovação de matrícula — %d.2', 'portal-si-cefet' ),
			$year
		);
	}
	return __( 'Outros prazos recorrentes', 'portal-si-cefet' );
}

/**
 * Atualiza títulos que dependem do ano letivo (não ficam “2026” fixos no site).
 *
 * @param array<string, mixed> $config Config (por referência).
 */
function portal_si_calendario_apply_dynamic_labels( array &$config ) {
	$year = isset( $config['year'] ) ? (int) $config['year'] : (int) gmdate( 'Y' );

	if ( ! empty( $config['semester_details'] ) && is_array( $config['semester_details'] ) ) {
		foreach ( $config['semester_details'] as $si => $semester ) {
			if ( ! is_array( $semester ) ) {
				continue;
			}
			$config['semester_details'][ $si ]['title'] = portal_si_calendario_semester_title( $si, $year );
		}
	}

	if ( ! empty( $config['admin_deadlines']['groups'] ) && is_array( $config['admin_deadlines']['groups'] ) ) {
		foreach ( $config['admin_deadlines']['groups'] as $gi => $group ) {
			if ( ! is_array( $group ) ) {
				continue;
			}
			$config['admin_deadlines']['groups'][ $gi ]['title'] = portal_si_calendario_admin_group_title( $gi, $year );
		}
	}
}

/**
 * Regista data e autor da última gravação no portal (automático).
 *
 * @param int $post_id ID da página calendário.
 */
function portal_si_calendario_record_portal_revision( $post_id ) {
	update_post_meta( $post_id, PORTAL_SI_CALENDARIO_REVISION_AT, time() );
	$user_id = get_current_user_id();
	if ( $user_id ) {
		update_post_meta( $post_id, PORTAL_SI_CALENDARIO_REVISION_BY, $user_id );
	}
}

/**
 * Última revisão feita no wp-admin (datas do resumo).
 *
 * @param int $page_id ID da página.
 * @return array{date: string, author: string}|null
 */
function portal_si_calendario_portal_revision( $page_id = 0 ) {
	if ( ! $page_id ) {
		$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CALENDARIO_SLUG );
	}
	if ( ! $page_id ) {
		return null;
	}

	$at = (int) get_post_meta( $page_id, PORTAL_SI_CALENDARIO_REVISION_AT, true );
	if ( $at <= 0 ) {
		$modified = get_post_field( 'post_modified', $page_id );
		$at       = $modified ? strtotime( $modified ) : 0;
	}
	if ( $at <= 0 ) {
		return null;
	}

	$author = '';
	$by     = (int) get_post_meta( $page_id, PORTAL_SI_CALENDARIO_REVISION_BY, true );
	if ( $by ) {
		$user = get_userdata( $by );
		if ( $user ) {
			$author = $user->display_name ? $user->display_name : $user->user_login;
		}
	}

	return array(
		'date'   => wp_date( 'd/m/Y \à\s H:i', $at ),
		'author' => $author,
	);
}

/**
 * Mescla dados guardados sobre defaults (campos fixos do tema).
 *
 * @param array<string, mixed> $defaults Base.
 * @param array<string, mixed> $stored   Meta da página.
 * @return array<string, mixed>
 */
function portal_si_calendario_merge_config( $defaults, $stored ) {
	$out = $defaults;

	foreach ( array( 'year', 'campus', 'audience', 'intro', 'disclaimer', 'official_page_url', 'pdf_label', 'pdf_filename', 'pdf_attachment_id', 'last_updated', 'source_updated' ) as $key ) {
		if ( array_key_exists( $key, $stored ) && '' !== $stored[ $key ] && null !== $stored[ $key ] ) {
			$out[ $key ] = $stored[ $key ];
		}
	}

	if ( ! empty( $stored['year_overview'] ) && is_array( $stored['year_overview'] ) ) {
		$out['year_overview'] = $stored['year_overview'];
	}
	if ( ! empty( $stored['semester_details'] ) && is_array( $stored['semester_details'] ) ) {
		$out['semester_details'] = $stored['semester_details'];
	}
	if ( ! empty( $stored['admin_deadlines'] ) && is_array( $stored['admin_deadlines'] ) ) {
		$out['admin_deadlines'] = $stored['admin_deadlines'];
	}

	return $out;
}

/**
 * Grava meta inicial a partir dos defaults do tema (uma vez).
 *
 * @param int $page_id ID da página.
 */
function portal_si_calendario_seed_page_meta( $page_id ) {
	if ( ! $page_id || get_option( PORTAL_SI_CALENDARIO_META_SEEDED ) ) {
		return;
	}

	$existing = get_post_meta( $page_id, PORTAL_SI_CALENDARIO_META_KEY, true );
	if ( is_array( $existing ) && ! empty( $existing ) ) {
		update_option( PORTAL_SI_CALENDARIO_META_SEEDED, 1 );
		return;
	}

	$defaults = portal_si_calendario_defaults();
	$stored = portal_si_calendario_prepare_stored( $defaults );
	portal_si_calendario_apply_dynamic_labels( $stored );
	update_post_meta( $page_id, PORTAL_SI_CALENDARIO_META_KEY, $stored );

	$modified = get_post_field( 'post_modified', $page_id );
	if ( $modified ) {
		update_post_meta( $page_id, PORTAL_SI_CALENDARIO_REVISION_AT, strtotime( $modified ) );
	}
	update_option( PORTAL_SI_CALENDARIO_META_SEEDED, 1 );
}

/**
 * Prepara array para guardar (sem chaves só de tema).
 *
 * @param array<string, mixed> $config Config completa.
 * @return array<string, mixed>
 */
function portal_si_calendario_prepare_stored( $config ) {
	return array(
		'year'               => isset( $config['year'] ) ? (int) $config['year'] : (int) gmdate( 'Y' ),
		'last_updated'       => isset( $config['last_updated'] ) ? (string) $config['last_updated'] : ( isset( $config['source_updated'] ) ? (string) $config['source_updated'] : '' ),
		'pdf_attachment_id'  => isset( $config['pdf_attachment_id'] ) ? (int) $config['pdf_attachment_id'] : 0,
		'pdf_label'          => isset( $config['pdf_label'] ) ? (string) $config['pdf_label'] : '',
		'year_overview'      => isset( $config['year_overview'] ) ? $config['year_overview'] : array(),
		'semester_details'   => isset( $config['semester_details'] ) ? $config['semester_details'] : array(),
		'admin_deadlines'    => isset( $config['admin_deadlines'] ) ? $config['admin_deadlines'] : array(),
	);
}

/**
 * Formata data para exibição (aceita Y-m-d ou d/m/Y).
 *
 * @param string $raw Data bruta.
 * @return string
 */
function portal_si_calendario_format_date_display( $raw ) {
	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		return '';
	}
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $raw ) ) {
		$ts = strtotime( $raw . ' 12:00:00' );
		if ( $ts ) {
			return wp_date( 'd/m/Y', $ts );
		}
	}
	return $raw;
}

/**
 * @param WP_Post $post Post atual.
 */
function portal_si_calendario_register_meta_box( $post ) {
	if ( ! $post instanceof WP_Post || PORTAL_SI_CALENDARIO_SLUG !== $post->post_name ) {
		return;
	}

	add_meta_box(
		'portal-si-calendario-data',
		__( 'Calendário acadêmico — datas e PDF', 'portal-si-cefet' ),
		'portal_si_calendario_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_page', 'portal_si_calendario_register_meta_box' );

/**
 * @param WP_Post $post Post.
 */
function portal_si_calendario_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_calendario_save', 'portal_si_calendario_nonce' );

	$config = portal_si_calendario_get_page_data( $post->ID );
	$year   = isset( $config['year'] ) ? (int) $config['year'] : (int) gmdate( 'Y' );

	$last_raw = '';
	if ( ! empty( $config['last_updated'] ) ) {
		$last_raw = (string) $config['last_updated'];
	} elseif ( ! empty( $config['source_updated'] ) ) {
		$last_raw = (string) $config['source_updated'];
	}
	$last_input = $last_raw;
	if ( preg_match( '#^\d{2}/\d{2}/\d{4}$#', $last_raw ) ) {
		$parts = explode( '/', $last_raw );
		$last_input = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
	}

	$pdf_id    = isset( $config['pdf_attachment_id'] ) ? (int) $config['pdf_attachment_id'] : 0;
	$pdf_label = isset( $config['pdf_label'] ) ? (string) $config['pdf_label'] : '';
	$pdf_url   = $pdf_id ? wp_get_attachment_url( $pdf_id ) : '';

	$overview = isset( $config['year_overview'] ) && is_array( $config['year_overview'] ) ? $config['year_overview'] : array();
	$semesters = isset( $config['semester_details'] ) && is_array( $config['semester_details'] ) ? $config['semester_details'] : array();
	$admin     = isset( $config['admin_deadlines'] ) && is_array( $config['admin_deadlines'] ) ? $config['admin_deadlines'] : array();
	$groups    = isset( $admin['groups'] ) && is_array( $admin['groups'] ) ? $admin['groups'] : array();

	$doc_url = home_url( '/docs/edicao-calendario-academico.md' );
	?>
	<p class="portal-calendario-admin-help">
		<?php esc_html_e( 'Altere apenas os campos de data e texto indicados. A estrutura da página no site é fixa — não é preciso editar código.', 'portal-si-cefet' ); ?>
		<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Ver página no site', 'portal-si-cefet' ); ?></a>
	</p>

	<table class="form-table portal-calendario-admin-table" role="presentation">
		<tr>
			<th scope="row"><label for="portal_si_cal_year"><?php esc_html_e( 'Ano letivo', 'portal-si-cefet' ); ?></label></th>
			<td><input type="number" id="portal_si_cal_year" name="portal_si_calendario[year]" value="<?php echo esc_attr( (string) $year ); ?>" min="2020" max="2100" class="small-text" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_cal_last_updated"><?php esc_html_e( 'Última atualização do documento', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="date" id="portal_si_cal_last_updated" name="portal_si_calendario[last_updated]" value="<?php echo esc_attr( $last_input ); ?>" />
				<p class="description"><?php esc_html_e( 'Data da versão oficial do PDF (CONPUS). Exibida junto ao botão de download — não é a data em que você salvou esta página.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'PDF oficial', 'portal-si-cefet' ); ?></th>
			<td>
				<input type="hidden" id="portal_si_cal_pdf_id" name="portal_si_calendario[pdf_attachment_id]" value="<?php echo esc_attr( (string) $pdf_id ); ?>" />
				<button type="button" class="button" id="portal_si_cal_pdf_pick"><?php esc_html_e( 'Escolher PDF na biblioteca', 'portal-si-cefet' ); ?></button>
				<button type="button" class="button" id="portal_si_cal_pdf_clear"><?php esc_html_e( 'Remover', 'portal-si-cefet' ); ?></button>
				<p id="portal_si_cal_pdf_name" class="description"><?php echo $pdf_url ? esc_html( basename( (string) $pdf_url ) ) : esc_html__( 'Nenhum ficheiro — usa o PDF padrão do tema se existir.', 'portal-si-cefet' ); ?></p>
				<p>
					<label for="portal_si_cal_pdf_label"><?php esc_html_e( 'Texto do botão de download', 'portal-si-cefet' ); ?></label><br />
					<input type="text" class="large-text" id="portal_si_cal_pdf_label" name="portal_si_calendario[pdf_label]" value="<?php echo esc_attr( $pdf_label ); ?>" />
				</p>
			</td>
		</tr>
	</table>

	<h3 class="portal-calendario-admin-subtitle"><?php echo esc_html( sprintf( __( 'Visão geral de %d', 'portal-si-cefet' ), $year ) ); ?></h3>
	<table class="widefat portal-calendario-admin-grid">
		<thead><tr><th><?php esc_html_e( 'Bloco (fixo)', 'portal-si-cefet' ); ?></th><th><?php esc_html_e( 'Período / datas', 'portal-si-cefet' ); ?></th><th><?php esc_html_e( 'Detalhe (opcional)', 'portal-si-cefet' ); ?></th></tr></thead>
		<tbody>
		<?php foreach ( $overview as $i => $block ) : ?>
			<?php if ( ! is_array( $block ) ) { continue; } ?>
			<tr>
				<td><strong><?php echo esc_html( (string) ( $block['label'] ?? '' ) ); ?></strong>
					<input type="hidden" name="portal_si_calendario[overview][<?php echo (int) $i; ?>][id]" value="<?php echo esc_attr( (string) ( $block['id'] ?? '' ) ); ?>" />
					<input type="hidden" name="portal_si_calendario[overview][<?php echo (int) $i; ?>][label]" value="<?php echo esc_attr( (string) ( $block['label'] ?? '' ) ); ?>" />
					<input type="hidden" name="portal_si_calendario[overview][<?php echo (int) $i; ?>][accent]" value="<?php echo esc_attr( (string) ( $block['accent'] ?? 'neutral' ) ); ?>" />
				</td>
				<td><input type="text" class="large-text" name="portal_si_calendario[overview][<?php echo (int) $i; ?>][period]" value="<?php echo esc_attr( (string) ( $block['period'] ?? '' ) ); ?>" placeholder="26/01/2026 a 18/02/2026" /></td>
				<td><input type="text" class="large-text" name="portal_si_calendario[overview][<?php echo (int) $i; ?>][detail]" value="<?php echo esc_attr( (string) ( $block['detail'] ?? '' ) ); ?>" /></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<h3 class="portal-calendario-admin-subtitle"><?php esc_html_e( 'Marcos do semestre', 'portal-si-cefet' ); ?></h3>
	<?php foreach ( $semesters as $si => $semester ) : ?>
		<?php if ( ! is_array( $semester ) ) { continue; } ?>
		<?php
		$milestones = isset( $semester['milestones'] ) && is_array( $semester['milestones'] ) ? $semester['milestones'] : array();
		while ( count( $milestones ) < 4 ) {
			$milestones[] = array( 'date' => '', 'label' => '' );
		}
		$milestones = array_slice( $milestones, 0, 4 );
		?>
		<?php $semester_title = portal_si_calendario_semester_title( (int) $si, $year ); ?>
		<fieldset class="portal-calendario-admin-fieldset">
			<legend><strong><?php echo esc_html( $semester_title ); ?></strong></legend>
			<input type="hidden" name="portal_si_calendario[semester][<?php echo (int) $si; ?>][id]" value="<?php echo esc_attr( (string) ( $semester['id'] ?? '' ) ); ?>" />
			<input type="hidden" name="portal_si_calendario[semester][<?php echo (int) $si; ?>][title]" value="<?php echo esc_attr( $semester_title ); ?>" />
			<p>
				<label><?php esc_html_e( 'Período do semestre', 'portal-si-cefet' ); ?></label>
				<input type="text" class="large-text" name="portal_si_calendario[semester][<?php echo (int) $si; ?>][period]" value="<?php echo esc_attr( (string) ( $semester['period'] ?? '' ) ); ?>" />
			</p>
			<table class="widefat">
				<thead><tr><th><?php esc_html_e( 'Data', 'portal-si-cefet' ); ?></th><th><?php esc_html_e( 'Descrição', 'portal-si-cefet' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $milestones as $mi => $m ) : ?>
					<tr>
						<td><input type="text" class="regular-text" name="portal_si_calendario[semester][<?php echo (int) $si; ?>][milestone][<?php echo (int) $mi; ?>][date]" value="<?php echo esc_attr( (string) ( $m['date'] ?? '' ) ); ?>" /></td>
						<td><input type="text" class="large-text" name="portal_si_calendario[semester][<?php echo (int) $si; ?>][milestone][<?php echo (int) $mi; ?>][label]" value="<?php echo esc_attr( (string) ( $m['label'] ?? '' ) ); ?>" /></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</fieldset>
	<?php endforeach; ?>

	<h3 class="portal-calendario-admin-subtitle"><?php echo esc_html( isset( $admin['title'] ) ? (string) $admin['title'] : __( 'Prazos administrativos', 'portal-si-cefet' ) ); ?></h3>
	<?php if ( ! empty( $admin['note'] ) ) : ?>
		<p class="description"><?php echo esc_html( (string) $admin['note'] ); ?></p>
	<?php endif; ?>
	<?php foreach ( $groups as $gi => $group ) : ?>
		<?php
		if ( ! is_array( $group ) ) {
			continue;
		}
		$items = isset( $group['items'] ) && is_array( $group['items'] ) ? $group['items'] : array();
		while ( count( $items ) < 4 ) {
			$items[] = array( 'label' => '', 'period' => '' );
		}
		$items = array_slice( $items, 0, 4 );
		?>
		<?php $group_title = portal_si_calendario_admin_group_title( (int) $gi, $year ); ?>
		<fieldset class="portal-calendario-admin-fieldset">
			<legend><strong><?php echo esc_html( $group_title ); ?></strong></legend>
			<input type="hidden" name="portal_si_calendario[admin_group][<?php echo (int) $gi; ?>][title]" value="<?php echo esc_attr( $group_title ); ?>" />
			<table class="widefat">
				<thead><tr><th><?php esc_html_e( 'Item', 'portal-si-cefet' ); ?></th><th><?php esc_html_e( 'Período', 'portal-si-cefet' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $items as $ii => $item ) : ?>
					<tr>
						<td><input type="text" class="regular-text" name="portal_si_calendario[admin_group][<?php echo (int) $gi; ?>][item][<?php echo (int) $ii; ?>][label]" value="<?php echo esc_attr( (string) ( $item['label'] ?? '' ) ); ?>" /></td>
						<td><input type="text" class="large-text" name="portal_si_calendario[admin_group][<?php echo (int) $gi; ?>][item][<?php echo (int) $ii; ?>][period]" value="<?php echo esc_attr( (string) ( $item['period'] ?? '' ) ); ?>" /></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</fieldset>
	<?php endforeach; ?>

	<?php
	$revision = portal_si_calendario_portal_revision( $post->ID );
	if ( $revision ) :
		?>
		<p class="portal-calendario-admin-revision">
			<strong><?php esc_html_e( 'Última revisão no portal (automático):', 'portal-si-cefet' ); ?></strong>
			<?php echo esc_html( $revision['date'] ); ?>
			<?php if ( ! empty( $revision['author'] ) ) : ?>
				<?php
				printf(
					/* translators: %s: display name */
					esc_html__( 'por %s', 'portal-si-cefet' ),
					esc_html( $revision['author'] )
				);
				?>
			<?php endif; ?>
			<br />
			<span class="description"><?php esc_html_e( 'Atualiza sempre que um editor ou administrador clica em “Atualizar” nesta página.', 'portal-si-cefet' ); ?></span>
		</p>
	<?php endif; ?>
	<?php
}

/**
 * @param int $post_id ID do post.
 */
function portal_si_calendario_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_calendario_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_calendario_nonce'] ) ), 'portal_si_calendario_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || PORTAL_SI_CALENDARIO_SLUG !== $post->post_name ) {
		return;
	}
	if ( ! isset( $_POST['portal_si_calendario'] ) || ! is_array( $_POST['portal_si_calendario'] ) ) {
		return;
	}

	$raw      = wp_unslash( $_POST['portal_si_calendario'] );
	$defaults = portal_si_calendario_defaults();
	$stored   = portal_si_calendario_prepare_stored( $defaults );

	$stored['year']              = isset( $raw['year'] ) ? (int) $raw['year'] : (int) gmdate( 'Y' );
	$stored['last_updated']      = isset( $raw['last_updated'] ) ? sanitize_text_field( (string) $raw['last_updated'] ) : '';
	$stored['pdf_attachment_id'] = isset( $raw['pdf_attachment_id'] ) ? absint( $raw['pdf_attachment_id'] ) : 0;
	$stored['pdf_label']         = isset( $raw['pdf_label'] ) ? sanitize_text_field( (string) $raw['pdf_label'] ) : '';

	if ( ! empty( $raw['overview'] ) && is_array( $raw['overview'] ) ) {
		$overview = array();
		foreach ( $raw['overview'] as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$overview[] = array(
				'id'     => isset( $row['id'] ) ? sanitize_title( (string) $row['id'] ) : '',
				'label'  => isset( $row['label'] ) ? sanitize_text_field( (string) $row['label'] ) : '',
				'period' => isset( $row['period'] ) ? sanitize_text_field( (string) $row['period'] ) : '',
				'detail' => isset( $row['detail'] ) ? sanitize_text_field( (string) $row['detail'] ) : '',
				'accent' => isset( $row['accent'] ) && 'primary' === $row['accent'] ? 'primary' : 'neutral',
			);
		}
		if ( ! empty( $overview ) ) {
			$stored['year_overview'] = $overview;
		}
	}

	if ( ! empty( $raw['semester'] ) && is_array( $raw['semester'] ) ) {
		$semesters = array();
		foreach ( $raw['semester'] as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$milestones = array();
			if ( ! empty( $row['milestone'] ) && is_array( $row['milestone'] ) ) {
				foreach ( $row['milestone'] as $m ) {
					if ( ! is_array( $m ) ) {
						continue;
					}
					$date  = isset( $m['date'] ) ? sanitize_text_field( (string) $m['date'] ) : '';
					$label = isset( $m['label'] ) ? sanitize_text_field( (string) $m['label'] ) : '';
					if ( '' === $date && '' === $label ) {
						continue;
					}
					$milestones[] = array(
						'date'  => $date,
						'label' => $label,
					);
				}
			}
			$semesters[] = array(
				'id'         => isset( $row['id'] ) ? sanitize_title( (string) $row['id'] ) : '',
				'title'      => portal_si_calendario_semester_title( count( $semesters ), $stored['year'] ),
				'period'     => isset( $row['period'] ) ? sanitize_text_field( (string) $row['period'] ) : '',
				'milestones' => $milestones,
			);
		}
		if ( ! empty( $semesters ) ) {
			$stored['semester_details'] = $semesters;
		}
	}

	$admin_defaults = isset( $defaults['admin_deadlines'] ) && is_array( $defaults['admin_deadlines'] ) ? $defaults['admin_deadlines'] : array();
	$admin_stored   = array(
		'title'  => isset( $admin_defaults['title'] ) ? (string) $admin_defaults['title'] : '',
		'note'   => isset( $admin_defaults['note'] ) ? (string) $admin_defaults['note'] : '',
		'groups' => array(),
	);

	if ( ! empty( $raw['admin_group'] ) && is_array( $raw['admin_group'] ) ) {
		foreach ( $raw['admin_group'] as $group ) {
			if ( ! is_array( $group ) ) {
				continue;
			}
			$items = array();
			if ( ! empty( $group['item'] ) && is_array( $group['item'] ) ) {
				foreach ( $group['item'] as $item ) {
					if ( ! is_array( $item ) ) {
						continue;
					}
					$label  = isset( $item['label'] ) ? sanitize_text_field( (string) $item['label'] ) : '';
					$period = isset( $item['period'] ) ? sanitize_text_field( (string) $item['period'] ) : '';
					if ( '' === $label && '' === $period ) {
						continue;
					}
					$items[] = array(
						'label'  => $label,
						'period' => $period,
					);
				}
			}
			$admin_stored['groups'][] = array(
				'title' => portal_si_calendario_admin_group_title( count( $admin_stored['groups'] ), $stored['year'] ),
				'items' => $items,
			);
		}
	}
	$stored['admin_deadlines'] = $admin_stored;

	update_post_meta( $post_id, PORTAL_SI_CALENDARIO_META_KEY, $stored );
	portal_si_calendario_record_portal_revision( $post_id );
}

add_action( 'save_post_page', 'portal_si_calendario_save_meta_box' );

/**
 * Regista revisão mesmo quando só o resumo da página ou o título mudam.
 *
 * @param int $post_id ID do post.
 */
function portal_si_calendario_track_page_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || PORTAL_SI_CALENDARIO_SLUG !== $post->post_name ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	portal_si_calendario_record_portal_revision( $post_id );
}
add_action( 'save_post_page', 'portal_si_calendario_track_page_save', 25 );

/**
 * Scripts do meta box (biblioteca de media).
 *
 * @param string $hook_suffix Hook admin.
 */
function portal_si_calendario_admin_assets( $hook_suffix ) {
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
		if ( ! $post || PORTAL_SI_CALENDARIO_SLUG !== $post->post_name ) {
			return;
		}
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'portal-si-calendario-admin',
		get_template_directory_uri() . '/assets/css/calendario-admin.css',
		array(),
		PORTAL_SI_CEFET_VERSION
	);
	wp_enqueue_script(
		'portal-si-calendario-admin',
		get_template_directory_uri() . '/assets/js/calendario-admin.js',
		array( 'jquery' ),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'portal_si_calendario_admin_assets' );
