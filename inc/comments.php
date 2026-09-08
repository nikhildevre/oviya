<?php
/**
 * Comments provider switch. This theme supports
 * native WordPress comments or Disqus.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_comments_provider() {
	return get_theme_mod( 'oviya_comments_provider', 'native' );
}

/**
 * If Disqus is selected, native comments are closed (Disqus replaces the
 * whole thread UI) and comments.php renders the Disqus embed instead.
 */
function oviya_maybe_disable_native_comments( $open, $post_id ) {
	if ( 'disqus' === oviya_comments_provider() ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'oviya_maybe_disable_native_comments', 10, 2 );

/**
 * Outputs the Disqus embed script
 * (lazy-loaded via IntersectionObserver, re-themed on dark/light toggle).
 */
function oviya_disqus_embed() {
	$shortname = get_theme_mod( 'oviya_disqus_shortname' );
	if ( ! $shortname ) {
		return;
	}
	$page_url = esc_url( get_permalink() );
	$page_id  = esc_js( wp_json_encode( wp_make_link_relative( get_permalink() ) ) );
	?>
	<div id="disqus_thread"></div>
	<script>
		var disqus_config = function () {
			this.page.url = '<?php echo esc_js( $page_url ); ?>';
			this.page.identifier = <?php echo $page_id; // phpcs:ignore ?>;
		};

		function reloadDisqus(event) {
			if (event.source === window && event.data && event.data.id === Theme.eventId) {
				if (typeof DISQUS === 'undefined') { return; }
				if (document.readyState === 'complete') {
					DISQUS.reset({ reload: true, config: disqus_config });
				}
			}
		}

		if (window.Theme && Theme.isToggleable) {
			addEventListener('message', reloadDisqus);
		}

		var disqusObserver = new IntersectionObserver(function (entries) {
			if (entries[0].isIntersecting) {
				var d = document, s = d.createElement('script');
				s.src = 'https://<?php echo esc_js( $shortname ); ?>.disqus.com/embed.js';
				s.setAttribute('data-timestamp', +new Date());
				(d.head || d.body).appendChild(s);
				disqusObserver.disconnect();
			}
		}, { threshold: [0] });

		disqusObserver.observe(document.getElementById('disqus_thread'));
	</script>
	<?php
}
