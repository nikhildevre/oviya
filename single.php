<?php
/**
 * Single post template.
 *
 * @package Oviya
 */

get_header();

while ( have_posts() ) :
	the_post();
	$enable_toc = oviya_toc_enabled();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'px-1' ); ?> data-toc="<?php echo $enable_toc ? 'true' : 'false'; ?>">
		<header>
			<h1 data-toc-skip><?php the_title(); ?></h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="post-desc fw-light mb-4"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
			<?php endif; ?>

			<div class="post-meta text-muted">
				<span>
					<?php esc_html_e( 'Posted:', 'oviya' ); ?>
					<?php oviya_datetime( get_the_time( 'U' ), array( 'tooltip' => true ) ); ?>
				</span>

				<?php if ( get_the_modified_time( 'U' ) - get_the_time( 'U' ) > DAY_IN_SECONDS ) : ?>
					<span>
						<?php esc_html_e( 'Updated:', 'oviya' ); ?>
						<?php oviya_datetime( get_the_modified_time( 'U' ), array( 'tooltip' => true ) ); ?>
					</span>
				<?php endif; ?>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="mt-3 mb-3">
						<?php the_post_thumbnail( 'large', array( 'class' => 'preview-img' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="d-flex justify-content-between">
					<span>
						<?php esc_html_e( 'Written by', 'oviya' ); ?>
						<?php oviya_post_authors(); ?>
					</span>
					<div>
						<?php oviya_reading_time(); ?>
					</div>
				</div>
			</div>
		</header>

		<?php if ( $enable_toc ) : ?>
			<div id="toc-bar" class="d-flex align-items-center justify-content-between invisible">
				<span class="label text-truncate"><?php the_title(); ?></span>
				<button type="button" class="toc-trigger btn me-1">
					<i class="fa-solid fa-list-ul fa-fw"></i>
				</button>
			</div>

			<button id="toc-solo-trigger" type="button" class="toc-trigger btn btn-outline-secondary btn-sm">
				<span class="label ps-2 pe-1"><?php esc_html_e( 'Contents', 'oviya' ); ?></span>
				<i class="fa-solid fa-angle-right fa-fw"></i>
			</button>

			<dialog id="toc-popup" class="p-0">
				<div class="header d-flex flex-row align-items-center justify-content-between">
					<div class="label text-truncate py-2 ms-4"><?php the_title(); ?></div>
					<button id="toc-popup-close" type="button" class="btn-close btn-sm mx-3" aria-label="Close"></button>
				</div>
				<div id="toc-popup-content" class="px-4 py-3 pb-4"></div>
			</dialog>
		<?php endif; ?>

		<div class="content">
			<?php 
			the_content(); 
			wp_link_pages( array(
				'before' => '<div class="page-links mt-4">' . esc_html__( 'Pages:', 'oviya' ),
				'after'  => '</div>',
			) );
			?>
		</div>

		<div class="post-tail-wrapper text-muted">
			<div class="d-flex justify-content-between align-items-center gap-3 mb-3">
				<?php if ( has_category() ) : ?>
					<div class="post-meta">
						<i class="far fa-folder-open fa-fw me-1"></i>
						<?php
						$cats = get_the_category();
						$links = array();
						foreach ( $cats as $cat ) {
							$links[] = '<a href="' . esc_url( get_category_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a>';
						}
						echo wp_kses_post( implode( ', ', $links ) );
						?>
					</div>
				<?php endif; ?>

				<?php if ( current_user_can( 'edit_post', get_the_ID() ) ) : ?>
					<div class="post-edit">
						<a href="<?php echo esc_url( get_edit_post_link() ); ?>" target="_blank" rel="noopener">
							<i class="fa fa-pen fa-fw me-1"></i><span><?php esc_html_e( 'Edit', 'oviya' ); ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( has_tag() ) : ?>
				<div class="post-tags">
					<i class="fa fa-tags fa-fw me-1"></i>
					<?php
					foreach ( get_the_tags() as $tag ) {
						printf(
							'<a href="%1$s" class="post-tag no-text-decoration">%2$s</a>',
							esc_url( get_tag_link( $tag ) ),
							esc_html( $tag->name )
						);
					}
					?>
				</div>
			<?php endif; ?>

			<div class="post-tail-bottom d-flex justify-content-between align-items-center mt-5 pb-2">
				<div class="license-wrapper"></div>
				<?php get_template_part( 'template-parts/post-sharing' ); ?>
			</div>
		</div>
	</article>

	<?php
	// Related posts + prev/next navigation render below the article, inside
	// #tail-wrapper — see footer.php's `oviya_tail_content` action.
	add_action(
		'oviya_tail_content',
		function () {
			get_template_part( 'template-parts/related-posts' );
			get_template_part( 'template-parts/post-nav' );
		}
	);

	$provider = oviya_comments_provider();
	if ( 'disqus' === $provider ) {
		oviya_disqus_embed();
	} elseif ( 'native' === $provider ) {
		comments_template();
	}

endwhile;

get_footer();
