<?php
/**
 * Template Name: Oviya - Tags
 *
 * @package Oviya
 */

get_header();

$tags = get_terms(
	array(
		'taxonomy'   => 'post_tag',
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
	)
);
?>
<article class="px-1">
	<h1 class="dynamic-title"><?php the_title(); ?></h1>

	<div class="content">
		<div id="tags" class="d-flex flex-wrap mx-xl-2">
			<?php foreach ( $tags as $tag ) : ?>
				<div>
					<a class="tag" href="<?php echo esc_url( get_term_link( $tag ) ); ?>">
						<?php echo esc_html( $tag->name ); ?>
						<span class="text-muted"><?php echo esc_html( $tag->count ); ?></span>
					</a>
				</div>
			<?php endforeach; ?>

			<?php if ( empty( $tags ) ) : ?>
				<p class="text-muted"><?php esc_html_e( 'No tags yet.', 'oviya' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</article>
<?php
get_footer();
