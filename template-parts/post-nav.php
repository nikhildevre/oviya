<?php
/**
 * Previous/next post navigation.
 *
 * @package Oviya
 */

$prev = get_previous_post();
$next = get_next_post();
?>
<nav class="post-navigation d-flex justify-content-between" aria-label="Post Navigation">
	<?php if ( $prev ) : ?>
		<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="btn btn-outline-primary" aria-label="<?php esc_attr_e( 'Previous', 'oviya' ); ?>">
			<p><?php echo esc_html( get_the_title( $prev ) ); ?></p>
		</a>
	<?php else : ?>
		<div class="btn btn-outline-primary disabled" aria-label="<?php esc_attr_e( 'Previous', 'oviya' ); ?>"><p>-</p></div>
	<?php endif; ?>

	<?php if ( $next ) : ?>
		<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="btn btn-outline-primary" aria-label="<?php esc_attr_e( 'Next', 'oviya' ); ?>">
			<p><?php echo esc_html( get_the_title( $next ) ); ?></p>
		</a>
	<?php else : ?>
		<div class="btn btn-outline-primary disabled" aria-label="<?php esc_attr_e( 'Next', 'oviya' ); ?>"><p>-</p></div>
	<?php endif; ?>
</nav>
