<?php
/**
 * Template Name: Oviya - Categories
 *
 * @package Oviya
 */

get_header();

$top_level_categories = get_categories(
	array(
		'parent'     => 0,
		'orderby'    => 'name',
		'hide_empty' => true,
	)
);
?>
<article class="px-1">
	<h1 class="dynamic-title"><?php the_title(); ?></h1>

	<div class="content">
		<?php
		$group_index = 0;
		foreach ( $top_level_categories as $category ) :
			$children = get_categories(
				array(
					'parent'     => $category->term_id,
					'orderby'    => 'name',
					'order'      => 'ASC',
					'hide_empty' => true,
				)
			);

			$total_count = $category->count;
			foreach ( $children as $child ) {
				$total_count += $child->count;
			}
			?>
			<div class="card categories">
				<div id="h_<?php echo esc_attr( $group_index ); ?>" class="card-header d-flex justify-content-between hide-border-bottom">
					<span class="ms-2">
						<i class="far fa-folder<?php echo $children ? '-open' : ''; ?> fa-fw"></i>
						<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" class="mx-2"><?php echo esc_html( $category->name ); ?></a>

						<span class="text-muted small font-weight-light">
							<?php if ( $children ) : ?>
								<?php
								printf(
									/* translators: %d: number of sub-categories */
									esc_html( _n( '%d subcategory', '%d subcategories', count( $children ), 'oviya' ) ),
									count( $children )
								);
								?>,
							<?php endif; ?>
							<?php
							printf(
								/* translators: %d: number of posts */
								esc_html( _n( '%d post', '%d posts', $total_count, 'oviya' ) ),
								$total_count
							);
							?>
						</span>
					</span>

					<?php if ( $children ) : ?>
						<!-- Category HAS subcategories: render toggle chevron down -->
						<a href="#l_<?php echo esc_attr( $group_index ); ?>" data-bs-toggle="collapse" aria-expanded="true"
							aria-label="<?php echo esc_attr( 'h_' . $group_index . '-trigger' ); ?>" class="category-trigger hide-border-bottom">
							<i class="fas fa-fw fa-angle-down"></i>
						</a>
					<?php else : ?>
						<!-- Category HAS NO subcategories: render clickable link chevron right -->
						<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" class="category-trigger hide-border-bottom">
							<i class="fas fa-fw fa-angle-right"></i>
						</a>
					<?php endif; ?>
				</div>

				<?php if ( $children ) : ?>
					<div id="l_<?php echo esc_attr( $group_index ); ?>" class="collapse show" aria-expanded="true">
						<ul class="list-group">
							<?php foreach ( $children as $child ) : ?>
								<li class="list-group-item">
									<i class="far fa-folder fa-fw"></i>
									<a href="<?php echo esc_url( get_category_link( $child ) ); ?>" class="mx-2"><?php echo esc_html( $child->name ); ?></a>
									<span class="text-muted small font-weight-light">
										<?php
										printf(
											/* translators: %d: number of posts */
											esc_html( _n( '%d post', '%d posts', $child->count, 'oviya' ) ),
											$child->count
										);
										?>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<?php
			++$group_index;
		endforeach;

		if ( empty( $top_level_categories ) ) {
			echo '<p class="text-muted">' . esc_html__( 'No categories yet.', 'oviya' ) . '</p>';
		}
		?>
	</div>
</article>
<?php
get_footer();
