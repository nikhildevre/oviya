<?php
/**
 * Extra author profile fields.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_user_profile_fields( $user ) {
	?>
	<h2><?php esc_html_e( 'Oviya Author Info', 'oviya' ); ?></h2>
	<table class="form-table">
		<tr>
			<th><label for="oviya_twitter"><?php esc_html_e( 'Twitter/X username', 'oviya' ); ?></label></th>
			<td>
				<input type="text" name="oviya_twitter" id="oviya_twitter"
					value="<?php echo esc_attr( get_the_author_meta( 'oviya_twitter', $user->ID ) ); ?>"
					class="regular-text" />
			</td>
		</tr>
	</table>
	<?php
}
add_action( 'show_user_profile', 'oviya_user_profile_fields' );
add_action( 'edit_user_profile', 'oviya_user_profile_fields' );

function oviya_save_user_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	if ( isset( $_POST['oviya_twitter'] ) ) {
		update_user_meta( $user_id, 'oviya_twitter', sanitize_text_field( wp_unslash( $_POST['oviya_twitter'] ) ) );
	}
}
add_action( 'personal_options_update', 'oviya_save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'oviya_save_user_profile_fields' );
