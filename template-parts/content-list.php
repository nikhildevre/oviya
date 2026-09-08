<?php
/**
 * The post card list shown on the blog index.
 *
 * @package Oviya
 */
?>
<div id="post-list" class="flex-grow-1 px-xl-1">
	<?php
	while ( have_posts() ) :
		the_post();
		$has_thumb = has_post_thumbnail();
		?>
		<article class="card-wrapper card">
			<a href="<?php the_permalink(); ?>" class="post-preview row g-0 flex-md-row-reverse">
				<?php if ( $has_thumb ) : ?>
					<div class="col-md-5">
						<?php the_post_thumbnail( 'oviya-card', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
					</div>
				<?php endif; ?>

				<div class="col-md-<?php echo $has_thumb ? '7' : '12'; ?>">
					<div class="card-body d-flex flex-column">
						<h1 class="card-title my-2 mt-md-0"><?php the_title(); ?></h1>

						<div class="card-text content mt-0 mb-3">
							<p><?php echo esc_html( oviya_post_summary() ); ?></p>
						</div>

						<div class="post-meta flex-grow-1 d-flex align-items-end">
							<div class="me-auto">
								<i class="far fa-calendar fa-fw me-1"></i>
								<?php oviya_datetime( get_the_time( 'U' ) ); ?>

								<?php if ( has_category() ) : ?>
									<i class="far fa-folder-open fa-fw me-1"></i>
									<span class="categories"><?php echo esc_html( oviya_get_post_categories_line() ); ?></span>
								<?php endif; ?>
							</div>

							<?php if ( oviya_is_pinned() ) : ?>
								<div class="pin ms-1">
									<i class="fas fa-thumbtack fa-fw"></i>
									<span><?php esc_html_e( 'Pinned', 'oviya' ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</a>
		</article>
	<?php endwhile; ?>
</div>

<?php
the_posts_pagination(
	array(
		'mid_size'  => 1,
		'prev_text' => '<i class="fas fa-angle-left"></i>',
		'next_text' => '<i class="fas fa-angle-right"></i>',
	)
);
