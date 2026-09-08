<?php
/**
 * @package Oviya
 */

$related = oviya_related_posts( get_the_ID(), 3 );
if ( ! $related ) {
	return;
}
?>
<aside id="related-posts" aria-labelledby="related-label">
	<h3 class="mb-4" id="related-label"><?php esc_html_e( 'Further Reading', 'oviya' ); ?></h3>
	<nav class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-4">
		<?php foreach ( $related as $related_post ) : ?>
			<article class="col">
				<a href="<?php echo esc_url( get_permalink( $related_post ) ); ?>" class="post-preview card h-100">
					<div class="card-body">
						<?php oviya_datetime( get_the_time( 'U', $related_post ) ); ?>
						<h4 class="pt-0 my-2"><?php echo esc_html( get_the_title( $related_post ) ); ?></h4>
						<div class="text-muted">
							<p><?php echo esc_html( oviya_post_summary( $related_post->ID ) ); ?></p>
						</div>
					</div>
				</a>
			</article>
		<?php endforeach; ?>
	</nav>
</aside>
