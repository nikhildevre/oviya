<?php
/**
 * Post sharing icons. Platforms
 * come from the Customizer (see oviya_share_platforms()).
 *
 * @package Oviya
 */

$title = rawurlencode( get_the_title() . ' - ' . get_bloginfo( 'name' ) );
$url   = rawurlencode( get_permalink() );
?>
<div class="share-wrapper d-flex align-items-center">
	<span class="share-label text-muted"><?php esc_html_e( 'Share', 'oviya' ); ?></span>
	<span class="share-icons">
		<?php foreach ( oviya_share_platforms() as list( $label, $icon, $link_template ) ) :
			$link = str_replace( array( 'TITLE', 'URL' ), array( $title, $url ), $link_template );
			?>
			<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener"
				data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo esc_attr( $label ); ?>" aria-label="<?php echo esc_attr( $label ); ?>">
				<i class="fa-fw <?php echo esc_attr( $icon ); ?>"></i>
			</a>
		<?php endforeach; ?>

		<button id="copy-link" aria-label="Copy link" class="btn small"
			data-bs-toggle="tooltip" data-bs-placement="top"
			title="<?php esc_attr_e( 'Copy link', 'oviya' ); ?>"
			data-title-succeed="<?php esc_attr_e( 'Copied!', 'oviya' ); ?>">
			<i class="fa-fw fas fa-link pe-none fs-6"></i>
		</button>
	</span>
</div>
