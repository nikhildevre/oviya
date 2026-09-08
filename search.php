<?php
/**
 * Search results template.
 *
 * @package Oviya
 */

get_header();
?>
<div id="post-list" class="flex-grow-1 px-xl-1">
	<h1 class="mb-4">
		<?php
		printf(
			/* translators: %s: search query */
			esc_html__( 'Search Results for: %s', 'oviya' ),
			'<em>' . esc_html( get_search_query() ) . '</em>'
		);
		?>
	</h1>

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article class="card-wrapper card mb-3">
				<a href="<?php the_permalink(); ?>" class="post-preview row g-0">
					<div class="col-12">
						<div class="card-body d-flex flex-column">
							<h2 class="card-title my-2 mt-md-0"><?php the_title(); ?></h2>
							<div class="card-text content mt-0 mb-3">
								<p><?php echo esc_html( oviya_post_summary() ); ?></p>
							</div>
							<div class="post-meta">
								<i class="far fa-calendar fa-fw me-1"></i>
								<?php oviya_datetime( get_the_time( 'U' ) ); ?>
								<?php if ( has_category() ) : ?>
									<i class="far fa-folder-open fa-fw ms-2 me-1"></i>
									<span class="categories"><?php echo esc_html( oviya_get_post_categories_line() ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</a>
			</article>
		<?php endwhile; ?>

		<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
	<?php else : ?>
		<p class="mt-5"><?php esc_html_e( 'No results found.', 'oviya' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
