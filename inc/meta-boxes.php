<?php
/**
 * Per-post display options.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_register_post_meta() {
	foreach ( array( '_oviya_toc', '_oviya_math', '_oviya_mermaid' ) as $key ) {
		register_post_meta(
			'post',
			$key,
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'oviya_register_post_meta' );

function oviya_add_meta_box() {
	add_meta_box(
		'oviya_display_options',
		__( 'Oviya Display Options', 'oviya' ),
		'oviya_render_meta_box',
		'post',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'oviya_add_meta_box' );

function oviya_render_meta_box( $post ) {
	wp_nonce_field( 'oviya_meta_box', 'oviya_meta_box_nonce' );

	$toc     = get_post_meta( $post->ID, '_oviya_toc', true );
	$math    = get_post_meta( $post->ID, '_oviya_math', true );
	$mermaid = get_post_meta( $post->ID, '_oviya_mermaid', true );
	?>
	<p>
		<label>
			<input type="checkbox" name="oviya_toc" value="1" <?php checked( '0' !== $toc ); ?>>
			<?php esc_html_e( 'Show Table of Contents (if it has headings)', 'oviya' ); ?>
		</label>
	</p>
	<p>
		<label>
			<input type="checkbox" name="oviya_math" value="1" <?php checked( '1', $math ); ?>>
			<?php esc_html_e( 'Load MathJax (this post uses LaTeX math)', 'oviya' ); ?>
		</label>
	</p>
	<p>
		<label>
			<input type="checkbox" name="oviya_mermaid" value="1" <?php checked( '1', $mermaid ); ?>>
			<?php esc_html_e( 'Load Mermaid (this post has diagram code blocks)', 'oviya' ); ?>
		</label>
	</p>
	<?php
}

function oviya_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['oviya_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['oviya_meta_box_nonce'], 'oviya_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_oviya_toc', isset( $_POST['oviya_toc'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_oviya_math', isset( $_POST['oviya_math'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_oviya_mermaid', isset( $_POST['oviya_mermaid'] ) ? '1' : '0' );
}
add_action( 'save_post', 'oviya_save_meta_box' );

/**
 * Sidebar tab icon. Only relevant for Pages that
 * are added to the "Sidebar Navigation (Tabs)" menu.
 */
function oviya_add_page_icon_meta_box() {
	add_meta_box(
		'oviya_page_icon',
		__( 'Oviya Sidebar Tab Icon', 'oviya' ),
		'oviya_render_page_icon_meta_box',
		'page',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'oviya_add_page_icon_meta_box' );

function oviya_render_page_icon_meta_box( $post ) {
	wp_nonce_field( 'oviya_page_icon', 'oviya_page_icon_nonce' );
	$icon = get_post_meta( $post->ID, '_oviya_icon', true );
	?>
	<p>
		<label for="oviya_icon"><?php esc_html_e( 'Font Awesome class', 'oviya' ); ?></label>
		<input type="text" id="oviya_icon" name="oviya_icon" class="widefat"
			placeholder="fas fa-info-circle"
			value="<?php echo esc_attr( $icon ); ?>">
	</p>
	<p class="description"><?php esc_html_e( 'Shown next to this page in the sidebar navigation, if it is added to the Sidebar Navigation (Tabs) menu.', 'oviya' ); ?></p>
	<?php
}

function oviya_save_page_icon_meta_box( $post_id ) {
	if ( ! isset( $_POST['oviya_page_icon_nonce'] ) || ! wp_verify_nonce( $_POST['oviya_page_icon_nonce'], 'oviya_page_icon' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['oviya_icon'] ) ) {
		update_post_meta( $post_id, '_oviya_icon', sanitize_text_field( wp_unslash( $_POST['oviya_icon'] ) ) );
	}
}
add_action( 'save_post_page', 'oviya_save_page_icon_meta_box' );
