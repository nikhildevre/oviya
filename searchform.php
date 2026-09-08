<?php
/**
 * Standalone search form.
 * @package Oviya
 */
?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input
		class="form-control"
		id="search-input"
		type="search"
		name="s"
		aria-label="search"
		autocomplete="off"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="<?php esc_attr_e( 'Search', 'oviya' ); ?>...">
</form>
