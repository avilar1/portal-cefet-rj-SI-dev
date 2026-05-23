<?php
/**
 * Contato — edição no wp-admin (RF27 / RF29).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_CONTATO_META_KEY', '_portal_si_contato_data' );

/**
 * @param int $page_id ID da página.
 * @return array<string, mixed>
 */
function portal_si_contato_get_page_meta( $page_id = 0 ) {
	if ( ! $page_id ) {
		$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CONTATO_SLUG );
	}
	if ( ! $page_id ) {
		return array();
	}

	$stored = get_post_meta( $page_id, PORTAL_SI_CONTATO_META_KEY, true );
	return is_array( $stored ) ? $stored : array();
}

/**
 * @param string  $post_type Tipo.
 * @param WP_Post $post      Post.
 */
function portal_si_contato_page_add_meta_boxes( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post instanceof WP_Post || PORTAL_SI_CONTATO_SLUG !== $post->post_name ) {
		return;
	}

	add_meta_box(
		'portal-contato-page-settings',
		__( 'Portal — Contato do curso', 'portal-si-cefet' ),
		'portal_si_contato_page_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_contato_page_add_meta_boxes', 10, 2 );

/**
 * @param WP_Post $post Post.
 */
function portal_si_contato_page_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_contato_page_save', 'portal_si_contato_page_nonce' );

	$meta   = portal_si_contato_get_page_meta( $post->ID );
	$coord  = portal_si_contato_config();
	$defaults = isset( $coord['coordination'] ) && is_array( $coord['coordination'] ) ? $coord['coordination'] : array();
	$person = ! empty( $meta['people'][0] ) && is_array( $meta['people'][0] ) ? $meta['people'][0] : array();
	if ( empty( $person ) && ! empty( $defaults['people'][0] ) ) {
		$person = $defaults['people'][0];
	}

	$intro  = $post->post_excerpt;
	$name   = isset( $person['name'] ) ? (string) $person['name'] : '';
	$role   = isset( $person['role'] ) ? (string) $person['role'] : '';
	$phone  = isset( $person['phone'] ) ? (string) $person['phone'] : '';
	$email  = isset( $person['email'] ) ? (string) $person['email'] : '';
	$hours  = isset( $meta['coordination']['hours'] ) ? (string) $meta['coordination']['hours'] : ( isset( $defaults['hours'] ) ? (string) $defaults['hours'] : '' );
	$room   = isset( $meta['coordination']['room'] ) ? (string) $meta['coordination']['room'] : ( isset( $defaults['room'] ) ? (string) $defaults['room'] : '' );
	$address = isset( $meta['coordination']['address'] ) ? (string) $meta['coordination']['address'] : ( isset( $defaults['address'] ) ? (string) $defaults['address'] : '' );
	?>
	<p class="description">
		<?php esc_html_e( 'Estes dados aparecem na página Contato e no resumo do rodapé. Mapa e links institucionais vêm do tema (data/contato.php).', 'portal-si-cefet' ); ?>
	</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_contato_intro"><?php esc_html_e( 'Resumo da página', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="3" id="portal_contato_intro" name="portal_contato_intro"><?php echo esc_textarea( $intro ); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_contato_coord_name"><?php esc_html_e( 'Coordenador(a)', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="large-text" id="portal_contato_coord_name" name="portal_contato_coord_name" value="<?php echo esc_attr( $name ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_contato_coord_role"><?php esc_html_e( 'Cargo', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="regular-text" id="portal_contato_coord_role" name="portal_contato_coord_role" value="<?php echo esc_attr( $role ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_contato_coord_phone"><?php esc_html_e( 'Telefone', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="regular-text" id="portal_contato_coord_phone" name="portal_contato_coord_phone" value="<?php echo esc_attr( $phone ); ?>" placeholder="(21) 3297-7905" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_contato_coord_email"><?php esc_html_e( 'E-mail', 'portal-si-cefet' ); ?></label></th>
			<td><input type="email" class="regular-text" id="portal_contato_coord_email" name="portal_contato_coord_email" value="<?php echo esc_attr( $email ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_contato_hours"><?php esc_html_e( 'Horário de atendimento', 'portal-si-cefet' ); ?></label></th>
			<td><textarea class="large-text" rows="2" id="portal_contato_hours" name="portal_contato_hours"><?php echo esc_textarea( $hours ); ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_contato_room"><?php esc_html_e( 'Local / sala', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="large-text" id="portal_contato_room" name="portal_contato_room" value="<?php echo esc_attr( $room ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_contato_address"><?php esc_html_e( 'Endereço', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="large-text" id="portal_contato_address" name="portal_contato_address" value="<?php echo esc_attr( $address ); ?>" /></td>
		</tr>
	</table>
	<?php
}

/**
 * @param int $post_id ID.
 */
function portal_si_contato_page_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_contato_page_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_contato_page_nonce'] ) ), 'portal_si_contato_page_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'page' !== get_post_type( $post_id ) || PORTAL_SI_CONTATO_SLUG !== get_post_field( 'post_name', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['portal_contato_intro'] ) ) {
		wp_update_post(
			array(
				'ID'           => $post_id,
				'post_excerpt' => sanitize_textarea_field( wp_unslash( $_POST['portal_contato_intro'] ) ),
			)
		);
	}

	$name  = isset( $_POST['portal_contato_coord_name'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_contato_coord_name'] ) ) : '';
	$role  = isset( $_POST['portal_contato_coord_role'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_contato_coord_role'] ) ) : '';
	$phone = isset( $_POST['portal_contato_coord_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_contato_coord_phone'] ) ) : '';
	$email = isset( $_POST['portal_contato_coord_email'] ) ? sanitize_email( wp_unslash( $_POST['portal_contato_coord_email'] ) ) : '';

	$data = array(
		'coordination' => array(
			'hours'   => isset( $_POST['portal_contato_hours'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_contato_hours'] ) ) : '',
			'room'    => isset( $_POST['portal_contato_room'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_contato_room'] ) ) : '',
			'address' => isset( $_POST['portal_contato_address'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_contato_address'] ) ) : '',
		),
		'people'       => array(),
	);

	if ( '' !== $name ) {
		$data['people'][] = array(
			'name'  => $name,
			'role'  => $role,
			'phone' => $phone,
			'email' => $email,
		);
	}

	update_post_meta( $post_id, PORTAL_SI_CONTATO_META_KEY, $data );
}
add_action( 'save_post_page', 'portal_si_contato_page_save_meta_box' );
