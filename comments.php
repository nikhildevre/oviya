<?php
/**
 * Native WordPress comments
 *
 * @package Oviya
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area mt-5 pt-3 border-top">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title mb-4">
			<?php
			$count = get_comments_number();
			printf(
				/* translators: %s: comment count */
				esc_html( _n( '%s Comment', '%s Comments', $count, 'oviya' ) ),
				esc_html( number_format_i18n( $count ) )
			);
			?>
		</h2>

		<ol class="comment-list list-unstyled">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => __( '&larr; Older Comments', 'oviya' ),
				'next_text' => __( 'Newer Comments &rarr;', 'oviya' ),
			)
		);
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments text-muted"><?php esc_html_e( 'Comments are closed.', 'oviya' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_form'         => 'comment-form',
			'class_submit'       => 'btn btn-outline-primary',
			'comment_field'      => '<p class="comment-form-comment"><label for="comment" class="visually-hidden">' . esc_html__( 'Comment', 'oviya' ) . '</label><textarea id="comment" class="form-control" name="comment" rows="6" placeholder="' . esc_attr__( 'Leave a comment', 'oviya' ) . '" required></textarea></p>',
			'title_reply'        => __( 'Leave a Comment', 'oviya' ),
			'title_reply_to'     => __( 'Leave a Reply to %s', 'oviya' ),
			'cancel_reply_link'  => __( 'Cancel reply', 'oviya' ),
			'label_submit'       => __( 'Post Comment', 'oviya' ),
		)
	);
	?>
</div>
