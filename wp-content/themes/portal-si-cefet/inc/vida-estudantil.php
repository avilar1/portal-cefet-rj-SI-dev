<?php
/**
 * Vida estudantil — auxílios, bolsas e apoio ao estudante (RF07).
 *
 * Todo o conteúdo é editável na caixa «Conteúdo da página» da própria página no wp-admin.
 * Enquanto a caixa nunca foi salva, vale o conteúdo inicial de data/vida-estudantil.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_VIDA_SLUG', 'vida-estudantil' );

const PORTAL_SI_VIDA_INTRO_META       = '_portal_si_vida_intro';
const PORTAL_SI_VIDA_ALERT_META       = '_portal_si_vida_alert';
const PORTAL_SI_VIDA_ALERT_UNTIL_META = '_portal_si_vida_alert_until';
const PORTAL_SI_VIDA_ITEMS_META       = '_portal_si_vida_items';

/** Dias sem revisão até o painel lembrar os editores (um semestre, com folga). */
const PORTAL_SI_VIDA_REVIEW_DAYS = 150;

/**
 * Conteúdo inicial do arquivo de dados.
 *
 * @return array<string, mixed>
 */
function portal_si_vida_defaults() {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$path     = get_template_directory() . '/data/vida-estudantil.php';
	$loaded   = is_readable( $path ) ? require $path : array();
	$defaults = apply_filters( 'portal_si_vida_defaults', is_array( $loaded ) ? $loaded : array() );

	return $defaults;
}

/**
 * Categorias dos cards (chave => rótulo).
 *
 * @return array<string, string>
 */
function portal_si_vida_categories() {
	$defaults = portal_si_vida_defaults();
	return isset( $defaults['categories'] ) && is_array( $defaults['categories'] ) ? $defaults['categories'] : array();
}

/**
 * ID da página Vida Estudantil.
 *
 * @return int
 */
function portal_si_vida_page_id() {
	return (int) portal_si_get_page_id_by_slug( PORTAL_SI_VIDA_SLUG );
}

/**
 * Se a caixa do painel já foi salva ao menos uma vez.
 *
 * @param int $page_id ID da página.
 * @return bool
 */
function portal_si_vida_has_saved_content( $page_id ) {
	return $page_id && metadata_exists( 'post', $page_id, PORTAL_SI_VIDA_ITEMS_META );
}

/**
 * Introdução da página.
 *
 * @return string
 */
function portal_si_vida_intro() {
	$page_id = portal_si_vida_page_id();
	if ( portal_si_vida_has_saved_content( $page_id ) ) {
		return (string) get_post_meta( $page_id, PORTAL_SI_VIDA_INTRO_META, true );
	}

	$defaults = portal_si_vida_defaults();
	return isset( $defaults['intro'] ) ? (string) $defaults['intro'] : '';
}

/**
 * Aviso em destaque, se houver e ainda estiver no prazo.
 *
 * @return string
 */
function portal_si_vida_alert() {
	$page_id = portal_si_vida_page_id();
	if ( ! $page_id ) {
		return '';
	}

	$alert = trim( (string) get_post_meta( $page_id, PORTAL_SI_VIDA_ALERT_META, true ) );
	$until = (string) get_post_meta( $page_id, PORTAL_SI_VIDA_ALERT_UNTIL_META, true );

	if ( '' === $alert ) {
		return '';
	}
	if ( $until && wp_date( 'Y-m-d' ) > $until ) {
		return '';
	}

	return $alert;
}

/**
 * Cards brutos (painel ou conteúdo inicial).
 *
 * @param int $page_id ID da página.
 * @return array<int, array<string, string>>
 */
function portal_si_vida_raw_items( $page_id ) {
	if ( portal_si_vida_has_saved_content( $page_id ) ) {
		$stored = get_post_meta( $page_id, PORTAL_SI_VIDA_ITEMS_META, true );
		return is_array( $stored ) ? $stored : array();
	}

	$defaults = portal_si_vida_defaults();
	return isset( $defaults['items'] ) && is_array( $defaults['items'] ) ? $defaults['items'] : array();
}

/**
 * Cards agrupados por categoria, na ordem das categorias.
 *
 * @return array<string, array{label: string, items: array<int, array<string, string>>}>
 */
function portal_si_vida_groups() {
	$categories = portal_si_vida_categories();
	$groups     = array();

	foreach ( $categories as $key => $label ) {
		$groups[ $key ] = array(
			'label' => $label,
			'items' => array(),
		);
	}

	foreach ( portal_si_vida_raw_items( portal_si_vida_page_id() ) as $row ) {
		if ( ! is_array( $row ) || empty( $row['title'] ) ) {
			continue;
		}
		$category = isset( $row['category'], $groups[ $row['category'] ] ) ? $row['category'] : 'apoio';
		if ( ! isset( $groups[ $category ] ) ) {
			continue;
		}
		$groups[ $category ]['items'][] = array(
			'title'       => (string) $row['title'],
			'description' => isset( $row['description'] ) ? (string) $row['description'] : '',
			'link_label'  => isset( $row['link_label'] ) ? (string) $row['link_label'] : '',
			'url'         => isset( $row['url'] ) ? (string) $row['url'] : '',
		);
	}

	return array_filter(
		$groups,
		static function ( $group ) {
			return ! empty( $group['items'] );
		}
	);
}

/**
 * Data da última revisão (última vez que a página foi salva).
 *
 * @return string d/m/Y ou vazio.
 */
function portal_si_vida_reviewed_at() {
	$page_id = portal_si_vida_page_id();
	return $page_id ? get_the_modified_date( 'd/m/Y', $page_id ) : '';
}

/* —— Painel —— */

/**
 * Caixa «Conteúdo da página» só na página Vida Estudantil.
 *
 * @param string  $post_type Tipo do post.
 * @param WP_Post $post      Post atual.
 */
function portal_si_vida_add_meta_box( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post || PORTAL_SI_VIDA_SLUG !== $post->post_name ) {
		return;
	}

	add_meta_box(
		'portal-si-vida-content',
		__( 'Conteúdo da página', 'portal-si-cefet' ),
		'portal_si_vida_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_vida_add_meta_box', 10, 2 );

/**
 * @param WP_Post $post Post atual.
 */
function portal_si_vida_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_vida_save', 'portal_si_vida_nonce' );

	$saved = portal_si_vida_has_saved_content( $post->ID );
	$intro = $saved ? (string) get_post_meta( $post->ID, PORTAL_SI_VIDA_INTRO_META, true ) : portal_si_vida_intro();
	$alert = (string) get_post_meta( $post->ID, PORTAL_SI_VIDA_ALERT_META, true );
	$until = (string) get_post_meta( $post->ID, PORTAL_SI_VIDA_ALERT_UNTIL_META, true );
	$items = portal_si_vida_raw_items( $post->ID );
	if ( empty( $items ) ) {
		$items = array( array() );
	}
	$categories = portal_si_vida_categories();
	?>
	<p class="description">
		<?php esc_html_e( 'Revise esta página a cada semestre. Evite colocar valores e datas nos cards: aponte para o edital oficial, que é quem muda.', 'portal-si-cefet' ); ?>
	</p>

	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_si_vida_intro"><?php esc_html_e( 'Introdução', 'portal-si-cefet' ); ?></label></th>
			<td><textarea class="large-text" rows="3" id="portal_si_vida_intro" name="portal_si_vida_intro"><?php echo esc_textarea( $intro ); ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_vida_alert"><?php esc_html_e( 'Aviso em destaque', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="2" id="portal_si_vida_alert" name="portal_si_vida_alert" placeholder="<?php esc_attr_e( 'Ex.: Inscrições do PAE abertas até 24/08. Veja o edital na página da assistência estudantil.', 'portal-si-cefet' ); ?>"><?php echo esc_textarea( $alert ); ?></textarea>
				<p>
					<label for="portal_si_vida_alert_until"><?php esc_html_e( 'Exibir até', 'portal-si-cefet' ); ?></label>
					<input type="date" id="portal_si_vida_alert_until" name="portal_si_vida_alert_until" value="<?php echo esc_attr( $until ); ?>" />
				</p>
				<p class="description"><?php esc_html_e( 'Opcional. Depois dessa data o aviso some sozinho do site. Deixe o aviso vazio para não exibir nada.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
	</table>

	<h3><?php esc_html_e( 'Cards', 'portal-si-cefet' ); ?></h3>
	<p class="description"><?php esc_html_e( 'Cada card aparece no grupo da categoria escolhida, na ordem abaixo. Use «Subir» e «Descer» para reordenar.', 'portal-si-cefet' ); ?></p>

	<div id="portal_si_vida_rows">
		<?php
		foreach ( array_values( $items ) as $index => $row ) {
			portal_si_vida_render_row( $index, is_array( $row ) ? $row : array(), $categories );
		}
		?>
	</div>
	<p><button type="button" class="button button-secondary" id="portal_si_vida_add_row"><?php esc_html_e( 'Adicionar card', 'portal-si-cefet' ); ?></button></p>
	<template id="portal_si_vida_row_template">
		<?php portal_si_vida_render_row( '__INDEX__', array(), $categories ); ?>
	</template>
	<?php
}

/**
 * Uma linha (card) do formulário.
 *
 * @param int|string            $index      Índice ou placeholder.
 * @param array<string, string> $row        Dados.
 * @param array<string, string> $categories Categorias.
 */
function portal_si_vida_render_row( $index, array $row, array $categories ) {
	$name     = 'portal_si_vida_items[' . $index . ']';
	$category = isset( $row['category'] ) ? (string) $row['category'] : 'apoio';
	?>
	<fieldset class="portal-vida-admin-row">
		<legend class="portal-vida-admin-row__legend">
			<span class="portal-vida-admin-row__title"><?php echo esc_html( ! empty( $row['title'] ) ? (string) $row['title'] : __( 'Novo card', 'portal-si-cefet' ) ); ?></span>
			<button type="button" class="button-link portal-vida-admin-up"><?php esc_html_e( 'Subir', 'portal-si-cefet' ); ?></button>
			<button type="button" class="button-link portal-vida-admin-down"><?php esc_html_e( 'Descer', 'portal-si-cefet' ); ?></button>
			<button type="button" class="button-link-delete portal-vida-admin-remove"><?php esc_html_e( 'Remover', 'portal-si-cefet' ); ?></button>
		</legend>
		<table class="form-table">
			<tr>
				<th scope="row"><?php esc_html_e( 'Categoria', 'portal-si-cefet' ); ?></th>
				<td>
					<select name="<?php echo esc_attr( $name ); ?>[category]">
						<?php foreach ( $categories as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $category, $key ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Título', 'portal-si-cefet' ); ?></th>
				<td><input type="text" class="large-text portal-vida-admin-title-input" name="<?php echo esc_attr( $name ); ?>[title]" value="<?php echo esc_attr( isset( $row['title'] ) ? (string) $row['title'] : '' ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Descrição', 'portal-si-cefet' ); ?></th>
				<td>
					<textarea class="large-text" rows="2" name="<?php echo esc_attr( $name ); ?>[description]"><?php echo esc_textarea( isset( $row['description'] ) ? (string) $row['description'] : '' ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Uma ou duas frases.', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Link', 'portal-si-cefet' ); ?></th>
				<td>
					<input type="url" class="large-text" name="<?php echo esc_attr( $name ); ?>[url]" value="<?php echo esc_attr( isset( $row['url'] ) ? (string) $row['url'] : '' ); ?>" placeholder="https://" />
					<input type="text" class="regular-text" name="<?php echo esc_attr( $name ); ?>[link_label]" value="<?php echo esc_attr( isset( $row['link_label'] ) ? (string) $row['link_label'] : '' ); ?>" placeholder="<?php esc_attr_e( 'Texto do link (ex.: Edital do PAE)', 'portal-si-cefet' ); ?>" />
					<p class="description"><?php esc_html_e( 'Opcional. Prefira a página oficial do programa em vez do PDF de um edital específico.', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
}

/**
 * @param int $post_id ID do post.
 */
function portal_si_vida_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_vida_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_vida_nonce'] ) ), 'portal_si_vida_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || PORTAL_SI_VIDA_SLUG !== $post->post_name ) {
		return;
	}

	update_post_meta( $post_id, PORTAL_SI_VIDA_INTRO_META, isset( $_POST['portal_si_vida_intro'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_si_vida_intro'] ) ) : '' );
	update_post_meta( $post_id, PORTAL_SI_VIDA_ALERT_META, isset( $_POST['portal_si_vida_alert'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_si_vida_alert'] ) ) : '' );

	$until = isset( $_POST['portal_si_vida_alert_until'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_si_vida_alert_until'] ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_VIDA_ALERT_UNTIL_META, preg_match( '/^\d{4}-\d{2}-\d{2}$/', $until ) ? $until : '' );

	$categories = portal_si_vida_categories();
	$raw        = isset( $_POST['portal_si_vida_items'] ) && is_array( $_POST['portal_si_vida_items'] ) ? wp_unslash( $_POST['portal_si_vida_items'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$items      = array();

	foreach ( $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$title = isset( $row['title'] ) ? sanitize_text_field( (string) $row['title'] ) : '';
		if ( '' === $title ) {
			continue;
		}
		$category = isset( $row['category'] ) ? sanitize_key( (string) $row['category'] ) : '';
		$items[]  = array(
			'category'    => isset( $categories[ $category ] ) ? $category : 'apoio',
			'title'       => $title,
			'description' => isset( $row['description'] ) ? sanitize_textarea_field( (string) $row['description'] ) : '',
			'link_label'  => isset( $row['link_label'] ) ? sanitize_text_field( (string) $row['link_label'] ) : '',
			'url'         => isset( $row['url'] ) ? esc_url_raw( (string) $row['url'] ) : '',
		);
	}

	update_post_meta( $post_id, PORTAL_SI_VIDA_ITEMS_META, $items );
}
add_action( 'save_post_page', 'portal_si_vida_save_meta_box' );

/**
 * Lembrete no painel quando a página passa do prazo de revisão.
 */
function portal_si_vida_review_notice() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$screen  = get_current_screen();
	$page_id = portal_si_vida_page_id();
	if ( ! $screen || ! $page_id ) {
		return;
	}

	$on_dashboard = 'dashboard' === $screen->id;
	$on_page      = 'page' === $screen->id && isset( $_GET['post'] ) && (int) $_GET['post'] === $page_id; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $on_dashboard && ! $on_page ) {
		return;
	}

	$modified = (int) get_post_modified_time( 'U', true, $page_id );
	$days     = $modified ? (int) floor( ( time() - $modified ) / DAY_IN_SECONDS ) : 0;
	if ( $days < PORTAL_SI_VIDA_REVIEW_DAYS ) {
		return;
	}

	printf(
		'<div class="notice notice-warning"><p>%1$s %2$s</p></div>',
		esc_html(
			sprintf(
				/* translators: 1: date, 2: days */
				__( 'A página Vida Estudantil não é revisada desde %1$s (%2$d dias). Confira se os editais e links continuam válidos e salve a página.', 'portal-si-cefet' ),
				get_the_modified_date( 'd/m/Y', $page_id ),
				$days
			)
		),
		$on_page ? '' : '<a href="' . esc_url( get_edit_post_link( $page_id ) ) . '">' . esc_html__( 'Revisar agora', 'portal-si-cefet' ) . '</a>'
	);
}
add_action( 'admin_notices', 'portal_si_vida_review_notice' );

/**
 * CSS e JS da caixa no painel.
 *
 * @param string $hook_suffix Tela do admin.
 */
function portal_si_vida_admin_assets( $hook_suffix ) {
	if ( 'post.php' !== $hook_suffix ) {
		return;
	}
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! $post_id || $post_id !== portal_si_vida_page_id() ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-vida-admin',
		get_template_directory_uri() . '/assets/css/vida-admin.css',
		array(),
		PORTAL_SI_CEFET_VERSION
	);
	wp_enqueue_script(
		'portal-si-vida-admin',
		get_template_directory_uri() . '/assets/js/vida-admin.js',
		array( 'jquery' ),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'portal_si_vida_admin_assets' );

/* —— Site —— */

/**
 * Classe no body.
 *
 * @param string[] $classes Classes do body.
 * @return string[]
 */
function portal_si_vida_body_class( $classes ) {
	if ( is_page( PORTAL_SI_VIDA_SLUG ) ) {
		$classes[] = 'portal-is-vida';
	}
	return $classes;
}
add_filter( 'body_class', 'portal_si_vida_body_class' );

/**
 * CSS da página.
 */
function portal_si_vida_enqueue_assets() {
	if ( ! is_page( PORTAL_SI_VIDA_SLUG ) ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-vida',
		get_template_directory_uri() . '/assets/css/vida-estudantil.css',
		array( 'portal-si-pages' ),
		PORTAL_SI_CEFET_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_vida_enqueue_assets', 16 );
