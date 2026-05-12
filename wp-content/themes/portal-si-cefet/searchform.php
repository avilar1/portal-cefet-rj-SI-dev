<?php
/**
 * Formulário de busca global (RF33) — HTML5 e rótulo acessível.
 *
 * Variáveis injetadas por load_template a partir de get_search_form(): $aria_label, $echo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portal_search_aria = __( 'Busca no portal', 'portal-si-cefet' );
if ( isset( $aria_label ) && is_string( $aria_label ) && $aria_label !== '' ) {
	$portal_search_aria = $aria_label;
}
?>
<form
	role="search"
	method="get"
	class="search-form portal-global-search"
	action="<?php echo esc_url( home_url( '/' ) ); ?>"
	aria-label="<?php echo esc_attr( $portal_search_aria ); ?>"
>
	<label class="portal-global-search__label" for="portal-search-field">
		<span class="screen-reader-text"><?php esc_html_e( 'Termo de busca', 'portal-si-cefet' ); ?></span>
		<input
			id="portal-search-field"
			type="search"
			name="s"
			class="search-field portal-global-search__input"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Buscar no portal…', 'portal-si-cefet' ); ?>"
			autocomplete="off"
			maxlength="200"
		/>
	</label>
	<button type="submit" class="search-submit portal-global-search__submit">
		<?php esc_html_e( 'Buscar', 'portal-si-cefet' ); ?>
	</button>
</form>
