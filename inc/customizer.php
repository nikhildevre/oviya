<?php
/**
 * Theme Customizer.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_customize_register( $wp_customize ) {

	/* ---------------------------------------------------------------
	 * Appearance: theme mode + table of contents
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'oviya_appearance',
		array(
			'title'    => __( 'Oviya: Appearance', 'oviya' ),
			'priority' => 25,
		)
	);

	$wp_customize->add_setting(
		'oviya_theme_mode',
		array(
			'default'           => 'auto',
			'sanitize_callback' => 'oviya_sanitize_theme_mode',
		)
	);
	$wp_customize->add_control(
		'oviya_theme_mode',
		array(
			'label'   => __( 'Color scheme', 'oviya' ),
			'section' => 'oviya_appearance',
			'type'    => 'select',
			'choices' => array(
				'auto'  => __( 'Auto (visitor can toggle light/dark/system)', 'oviya' ),
				'light' => __( 'Force light', 'oviya' ),
				'dark'  => __( 'Force dark', 'oviya' ),
			),
		)
	);

	$wp_customize->add_setting(
		'oviya_toc_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'oviya_toc_enabled',
		array(
			'label'       => __( 'Enable Table of Contents on posts', 'oviya' ),
			'description' => __( 'Only shown on posts that actually contain headings.', 'oviya' ),
			'section'     => 'oviya_appearance',
			'type'        => 'checkbox',
		)
	);

	/* ---------------------------------------------------------------
	 * Sidebar contact links
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'oviya_contact',
		array(
			'title'    => __( 'Oviya: Sidebar Contact Links', 'oviya' ),
			'priority' => 30,
		)
	);

	$contact_fields = array(
		'github'         => array( __( 'GitHub username', 'oviya' ), 'text' ),
		'twitter'        => array( __( 'Twitter/X username', 'oviya' ), 'text' ),
		'email'          => array( __( 'Contact email', 'oviya' ), 'email' ),
		'mastodon_url'   => array( __( 'Mastodon profile URL', 'oviya' ), 'url' ),
		'linkedin_url'   => array( __( 'LinkedIn profile URL', 'oviya' ), 'url' ),
		'stackoverflow_url' => array( __( 'Stack Overflow profile URL', 'oviya' ), 'url' ),
		'bluesky_url'    => array( __( 'Bluesky profile URL', 'oviya' ), 'url' ),
		'reddit_url'     => array( __( 'Reddit profile URL', 'oviya' ), 'url' ),
		'threads_url'    => array( __( 'Threads profile URL', 'oviya' ), 'url' ),
	);

	foreach ( $contact_fields as $key => $field ) {
		list( $label, $type ) = $field;
		$setting_id            = 'oviya_contact_' . $key;
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'url' === $type ? 'esc_url_raw' : ( 'email' === $type ? 'sanitize_email' : 'sanitize_text_field' ),
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => $label,
				'section' => 'oviya_contact',
				'type'    => $type,
			)
		);
	}

	$wp_customize->add_setting(
		'oviya_contact_rss_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'oviya_contact_rss_enabled',
		array(
			'label'   => __( 'Show RSS feed icon', 'oviya' ),
			'section' => 'oviya_contact',
			'type'    => 'checkbox',
		)
	);

	/* ---------------------------------------------------------------
	 * Post sharing
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'oviya_share',
		array(
			'title'    => __( 'Oviya: Post Sharing', 'oviya' ),
			'priority' => 35,
		)
	);

	foreach ( array( 'twitter', 'facebook', 'telegram', 'linkedin', 'reddit' ) as $platform ) {
		$default = in_array( $platform, array( 'twitter', 'facebook', 'telegram' ), true );
		$wp_customize->add_setting(
			'oviya_share_' . $platform,
			array(
				'default'           => $default,
				'sanitize_callback' => 'wp_validate_boolean',
			)
		);
		$wp_customize->add_control(
			'oviya_share_' . $platform,
			array(
				'label'   => sprintf( __( 'Show %s share button', 'oviya' ), ucfirst( $platform ) ),
				'section' => 'oviya_share',
				'type'    => 'checkbox',
			)
		);
	}

	/* ---------------------------------------------------------------
	 * Comments
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'oviya_comments',
		array(
			'title'    => __( 'Oviya: Comments', 'oviya' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'oviya_comments_provider',
		array(
			'default'           => 'native',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control(
		'oviya_comments_provider',
		array(
			'label'   => __( 'Comments provider', 'oviya' ),
			'section' => 'oviya_comments',
			'type'    => 'select',
			'choices' => array(
				'none'   => __( 'Disabled', 'oviya' ),
				'native' => __( 'Native WordPress comments', 'oviya' ),
				'disqus' => __( 'Disqus', 'oviya' ),
			),
		)
	);

	$wp_customize->add_setting(
		'oviya_disqus_shortname',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'oviya_disqus_shortname',
		array(
			'label'       => __( 'Disqus shortname', 'oviya' ),
			'description' => __( 'help.disqus.com/en/articles/1717111-what-s-a-shortname', 'oviya' ),
			'section'     => 'oviya_comments',
			'type'        => 'text',
		)
	);

	/* ---------------------------------------------------------------
	 * Footer / copyright
	 * ------------------------------------------------------------- */
	$wp_customize->add_section(
		'oviya_footer',
		array(
			'title'    => __( 'Oviya: Footer', 'oviya' ),
			'priority' => 45,
		)
	);

	$wp_customize->add_setting(
		'oviya_copyright_name',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'oviya_copyright_name',
		array(
			'label'       => __( 'Copyright owner name', 'oviya' ),
			'description' => __( 'Defaults to the site title if left blank.', 'oviya' ),
			'section'     => 'oviya_footer',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'oviya_copyright_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'oviya_copyright_url',
		array(
			'label'   => __( 'Copyright owner link (e.g. your GitHub/Twitter)', 'oviya' ),
			'section' => 'oviya_footer',
			'type'    => 'url',
		)
	);
}
add_action( 'customize_register', 'oviya_customize_register' );

function oviya_sanitize_theme_mode( $input ) {
	return in_array( $input, array( 'auto', 'light', 'dark' ), true ) ? $input : 'auto';
}

function oviya_share_platforms() {
	$all = array(
		'twitter'  => array( 'Twitter', 'fa-brands fa-square-x-twitter', 'https://twitter.com/intent/tweet?text=TITLE&url=URL' ),
		'facebook' => array( 'Facebook', 'fab fa-facebook-square', 'https://www.facebook.com/sharer/sharer.php?title=TITLE&u=URL' ),
		'telegram' => array( 'Telegram', 'fab fa-telegram', 'https://t.me/share/url?url=URL&text=TITLE' ),
		'linkedin' => array( 'LinkedIn', 'fab fa-linkedin', 'https://www.linkedin.com/feed/?shareActive=true&shareUrl=URL' ),
		'reddit'   => array( 'Reddit', 'fa-brands fa-square-reddit', 'https://www.reddit.com/submit?url=URL&title=TITLE' ),
	);

	$enabled = array();
	foreach ( $all as $key => $data ) {
		if ( get_theme_mod( 'oviya_share_' . $key, in_array( $key, array( 'twitter', 'facebook', 'telegram' ), true ) ) ) {
			$enabled[ $key ] = $data;
		}
	}
	return $enabled;
}

/**
 * Returns the configured sidebar contact links as [type, icon, url] tuples,
 */
function oviya_contact_links() {
	$links = array();

	$github = get_theme_mod( 'oviya_contact_github' );
	if ( $github ) {
		$links[] = array( 'github', 'fab fa-github', 'https://github.com/' . $github );
	}

	$twitter = get_theme_mod( 'oviya_contact_twitter' );
	if ( $twitter ) {
		$links[] = array( 'twitter', 'fa-brands fa-x-twitter', 'https://twitter.com/' . $twitter );
	}

	$email = get_theme_mod( 'oviya_contact_email' );
	if ( $email ) {
		$parts   = explode( '@', $email );
		$links[] = array(
			'email',
			'fas fa-envelope',
			"javascript:void(location.href = 'mailto:' + ['{$parts[0]}','{$parts[1]}'].join('@'))",
		);
	}

	$mastodon = get_theme_mod( 'oviya_contact_mastodon_url' );
	if ( $mastodon ) {
		$links[] = array( 'mastodon', 'fab fa-mastodon', $mastodon );
	}

	$linkedin = get_theme_mod( 'oviya_contact_linkedin_url' );
	if ( $linkedin ) {
		$links[] = array( 'linkedin', 'fab fa-linkedin', $linkedin );
	}

	$stackoverflow = get_theme_mod( 'oviya_contact_stackoverflow_url' );
	if ( $stackoverflow ) {
		$links[] = array( 'stack-overflow', 'fab fa-stack-overflow', $stackoverflow );
	}

	$bluesky = get_theme_mod( 'oviya_contact_bluesky_url' );
	if ( $bluesky ) {
		$links[] = array( 'bluesky', 'fa-brands fa-bluesky', $bluesky );
	}

	$reddit = get_theme_mod( 'oviya_contact_reddit_url' );
	if ( $reddit ) {
		$links[] = array( 'reddit', 'fa-brands fa-reddit', $reddit );
	}

	$threads = get_theme_mod( 'oviya_contact_threads_url' );
	if ( $threads ) {
		$links[] = array( 'threads', 'fa-brands fa-threads', $threads );
	}

	if ( get_theme_mod( 'oviya_contact_rss_enabled', true ) ) {
		$links[] = array( 'rss', 'fas fa-rss', get_feed_link() );
	}

	return $links;
}
