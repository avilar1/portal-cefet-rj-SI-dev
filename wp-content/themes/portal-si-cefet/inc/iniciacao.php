<?php
/**
 * Iniciação científica — RF10.
 *
 * Página filha do hub Pesquisa e Extensão, editada numa caixa da própria página.
 * Os projetos que aceitam alunos (inc/projeto.php) entram automaticamente.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_IC_SLUG', 'iniciacao-cientifica' );

const PORTAL_SI_IC_META = '_portal_si_ic_content';

/**
 * Página /pesquisa-e-extensao/iniciacao-cientifica.
 */
function portal_si_ensure_ic_page() {
	portal_si_pesquisa_ensure_child_page( __( 'Iniciação Científica', 'portal-si-cefet' ), PORTAL_SI_IC_SLUG );
}
add_action( 'after_setup_theme', 'portal_si_ensure_ic_page', 27 );

/**
 * Uma linha por item, sem linhas vazias.
 *
 * @param string $text Texto.
 * @return string[]
 */
function portal_si_text_to_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) ) );
}

/**
 * Linhas "Rótulo | URL" (ou "Rótulo | Descrição | URL") em array.
 *
 * @param string $text Texto.
 * @return array<int, array{label: string, description: string, url: string}>
 */
function portal_si_text_to_link_rows( $text ) {
	$rows = array();
	foreach ( portal_si_text_to_lines( $text ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );
		$label = $parts[0];
		$url   = '';
		$desc  = '';
		if ( count( $parts ) >= 3 ) {
			$desc = $parts[1];
			$url  = $parts[2];
		} elseif ( 2 === count( $parts ) ) {
			if ( preg_match( '#^https?://#i', $parts[1] ) ) {
				$url = $parts[1];
			} else {
				$desc = $parts[1];
			}
		}
		$url = preg_match( '#^https?://#i', $url ) ? esc_url_raw( $url, array( 'http', 'https' ) ) : '';
		if ( '' !== $label ) {
			$rows[] = array(
				'label'       => $label,
				'description' => $desc,
				'url'         => $url,
			);
		}
	}
	return $rows;
}

/**
 * Converte linhas de volta em texto para o formulário.
 *
 * @param array<int, array{label: string, description?: string, url: string}> $rows Linhas.
 * @return string
 */
function portal_si_link_rows_to_text( $rows ) {
	$lines = array();
	foreach ( (array) $rows as $row ) {
		$parts = array( $row['label'] );
		if ( ! empty( $row['description'] ) ) {
			$parts[] = $row['description'];
		}
		if ( ! empty( $row['url'] ) ) {
			$parts[] = $row['url'];
		}
		$lines[] = implode( ' | ', $parts );
	}
	return implode( "\n", $lines );
}

/**
 * Conteúdo da página: salvo no painel ou, na primeira vez, o do arquivo de dados.
 *
 * @return array{intro: string, alert: string, alert_until: string, criterios: string[], passos: string[], links: array, contato: string}
 */
function portal_si_ic_content() {
	static $content = null;
	if ( null !== $content ) {
		return $content;
	}

	$defaults = require get_template_directory() . '/data/iniciacao-cientifica.php';
	$defaults = array_merge(
		array(
			'alert'       => '',
			'alert_until' => '',
		),
		(array) $defaults
	);

	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_IC_SLUG );
	$saved   = $page_id ? get_post_meta( $page_id, PORTAL_SI_IC_META, true ) : '';
	$content = is_array( $saved ) ? array_merge( $defaults, $saved ) : $defaults;

	return apply_filters( 'portal_si_ic_content', $content );
}

/**
 * Aviso vigente (vazio depois da data "Exibir até").
 *
 * @return string
 */
function portal_si_ic_alert() {
	$content = portal_si_ic_content();
	if ( '' === trim( $content['alert'] ) ) {
		return '';
	}
	if ( $content['alert_until'] && current_time( 'Y-m-d' ) > $content['alert_until'] ) {
		return '';
	}
	return $content['alert'];
}

/**
 * Meta box na página IC.
 *
 * @param string       $post_type Tipo.
 * @param WP_Post|null $post      Post.
 */
function portal_si_ic_add_meta_box( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post || PORTAL_SI_IC_SLUG !== $post->post_name ) {
		return;
	}
	add_meta_box(
		'portal-si-ic-content',
		__( 'Conteúdo da página', 'portal-si-cefet' ),
		'portal_si_ic_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_ic_add_meta_box', 10, 2 );

/**
 * @param WP_Post $post Página.
 */
function portal_si_ic_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_ic_save', 'portal_si_ic_nonce' );
	$c = portal_si_ic_content();
	?>
	<p class="description">
		<?php esc_html_e( 'Revise a cada edital. Evite valores de bolsa e datas no texto: aponte para o edital oficial. Os projetos que "aceitam alunos" (menu Projetos P&E) aparecem sozinhos na página.', 'portal-si-cefet' ); ?>
	</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_si_ic_intro"><?php esc_html_e( 'Introdução', 'portal-si-cefet' ); ?></label></th>
			<td><textarea class="large-text" rows="3" id="portal_si_ic_intro" name="portal_si_ic[intro]"><?php echo esc_textarea( $c['intro'] ); ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_ic_alert"><?php esc_html_e( 'Aviso em destaque', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="2" id="portal_si_ic_alert" name="portal_si_ic[alert]" placeholder="<?php esc_attr_e( 'Ex.: Edital de IC aberto até 30/04. Veja o link abaixo.', 'portal-si-cefet' ); ?>"><?php echo esc_textarea( $c['alert'] ); ?></textarea>
				<p>
					<label for="portal_si_ic_alert_until"><?php esc_html_e( 'Exibir até:', 'portal-si-cefet' ); ?></label>
					<input type="date" id="portal_si_ic_alert_until" name="portal_si_ic[alert_until]" value="<?php echo esc_attr( $c['alert_until'] ); ?>" />
					<span class="description"><?php esc_html_e( 'Depois dessa data o aviso some sozinho.', 'portal-si-cefet' ); ?></span>
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_ic_criterios"><?php esc_html_e( 'Quem pode participar', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="5" id="portal_si_ic_criterios" name="portal_si_ic[criterios]"><?php echo esc_textarea( implode( "\n", $c['criterios'] ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Um critério por linha.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_ic_passos"><?php esc_html_e( 'Como participar', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="5" id="portal_si_ic_passos" name="portal_si_ic[passos]"><?php echo esc_textarea( implode( "\n", $c['passos'] ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Um passo por linha, na ordem.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_ic_links"><?php esc_html_e( 'Editais e links oficiais', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text code" rows="4" id="portal_si_ic_links" name="portal_si_ic[links]"><?php echo esc_textarea( portal_si_link_rows_to_text( $c['links'] ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Um link por linha, no formato: Texto do link | https://endereco', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_si_ic_contato"><?php esc_html_e( 'Contato', 'portal-si-cefet' ); ?></label></th>
			<td><textarea class="large-text" rows="2" id="portal_si_ic_contato" name="portal_si_ic[contato]"><?php echo esc_textarea( $c['contato'] ); ?></textarea></td>
		</tr>
	</table>
	<?php
}

/**
 * @param int $post_id ID da página.
 */
function portal_si_ic_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_ic_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_ic_nonce'] ) ), 'portal_si_ic_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || PORTAL_SI_IC_SLUG !== $post->post_name ) {
		return;
	}

	$raw = isset( $_POST['portal_si_ic'] ) && is_array( $_POST['portal_si_ic'] ) ? wp_unslash( $_POST['portal_si_ic'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$get = function ( $key ) use ( $raw ) {
		return isset( $raw[ $key ] ) ? sanitize_textarea_field( (string) $raw[ $key ] ) : '';
	};

	$until = $get( 'alert_until' );
	update_post_meta(
		$post_id,
		PORTAL_SI_IC_META,
		array(
			'intro'       => $get( 'intro' ),
			'alert'       => $get( 'alert' ),
			'alert_until' => preg_match( '/^\d{4}-\d{2}-\d{2}$/', $until ) ? $until : '',
			'criterios'   => portal_si_text_to_lines( $get( 'criterios' ) ),
			'passos'      => portal_si_text_to_lines( $get( 'passos' ) ),
			'links'       => array_values(
				array_filter(
					portal_si_text_to_link_rows( $get( 'links' ) ),
					function ( $row ) {
						return '' !== $row['url'];
					}
				)
			),
			'contato'     => $get( 'contato' ),
		)
	);
}
add_action( 'save_post_page', 'portal_si_ic_save_meta_box' );
