<?php
/**
 * Template tags — reusable helper functions called from template files.
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_breadcrumb() {
    echo '<nav id="breadcrumb" aria-label="Breadcrumb">';

    if ( is_front_page() || is_home() ) {
        echo '<span>' . esc_html__( 'Home', 'oviya' ) . '</span>';
        echo '</nav>';
        return;
    }

    echo '<span><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'oviya' ) . '</a></span>';

    if ( is_singular( 'post' ) ) {
        echo '<span>' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_category() ) {
        echo '<span><a href="' . esc_url( home_url( '/categories/' ) ) . '">' . esc_html__( 'Categories', 'oviya' ) . '</a></span>';
        echo '<span>' . esc_html( single_term_title( '', false ) ) . '</span>';
    } elseif ( is_tag() ) {
        echo '<span><a href="' . esc_url( home_url( '/tags/' ) ) . '">' . esc_html__( 'Tags', 'oviya' ) . '</a></span>';
        echo '<span>' . esc_html( single_term_title( '', false ) ) . '</span>';
    } elseif ( is_search() ) {
        echo '<span>' . esc_html__( 'Search Results', 'oviya' ) . '</span>';
    } elseif ( is_404() ) {
        echo '<span>' . esc_html__( 'Not Found', 'oviya' ) . '</span>';
    } elseif ( is_singular() ) {
        echo '<span>' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_archive() ) {
        echo '<span>' . esc_html( get_the_archive_title() ) . '</span>';
    }

    echo '</nav>';
}

// function oviya_breadcrumb() {
// 	echo '<nav id="breadcrumb" aria-label="Breadcrumb">';

// 	if ( is_front_page() || is_home() ) {
// 		echo '<span>' . esc_html__( 'Home', 'oviya' ) . '</span>';
// 		echo '</nav>';
// 		return;
// 	}

// 	echo '<span><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'oviya' ) . '</a></span>';

// 	if ( is_singular( 'post' ) ) {
// 		echo '<span>' . esc_html( get_the_title() ) . '</span>';
// 	} elseif ( is_category() || is_tag() ) {
// 		echo '<span>' . esc_html( single_term_title( '', false ) ) . '</span>';
// 	} elseif ( is_search() ) {
// 		echo '<span>' . esc_html__( 'Search Results', 'oviya' ) . '</span>';
// 	} elseif ( is_404() ) {
// 		echo '<span>' . esc_html__( 'Not Found', 'oviya' ) . '</span>';
// 	} elseif ( is_singular() ) {
// 		echo '<span>' . esc_html( get_the_title() ) . '</span>';
// 	} elseif ( is_archive() ) {
// 		echo '<span>' . esc_html( get_the_archive_title() ) . '</span>';
// 	}

// 	echo '</nav>';
// }

/**
 * The title shown in the topbar's centre column.
 */
function oviya_topbar_title() {
	if ( is_front_page() || is_home() ) {
		return get_bloginfo( 'name' );
	}
	if ( is_category() || is_tag() ) {
		return single_term_title( '', false );
	}
	if ( is_search() ) {
		return __( 'Search Results', 'oviya' );
	}
	if ( is_404() ) {
		return __( 'Page Not Found', 'oviya' );
	}
	if ( is_singular() ) {
		return get_the_title();
	}
	if ( is_archive() ) {
		return get_the_archive_title();
	}
	return get_bloginfo( 'name' );
}

function oviya_reading_time( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
	$words   = str_word_count( $content );
	$minutes = max( 1, (int) round( $words / 180 ) );

	printf(
		'<span class="readtime" data-bs-toggle="tooltip" data-bs-placement="bottom" title="%1$s">',
		esc_attr(
			sprintf(
				/* translators: %d: word count */
				_n( '%d word', '%d words', $words, 'oviya' ),
				$words
			)
		)
	);
	printf(
		'<em>%1$s</em> %2$s',
		esc_html( $minutes ),
		esc_html( _n( 'minute read', 'minutes read', $minutes, 'oviya' ) )
	);
	echo '</span>';
}
function oviya_datetime( $timestamp, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class'   => '',
			'tooltip' => false,
		)
	);

	$class_attr   = $args['class'] ? ' class="' . esc_attr( $args['class'] ) . '"' : '';
	$tooltip_attr = $args['tooltip'] ? ' data-bs-toggle="tooltip" data-bs-placement="bottom"' : '';

	printf(
		'<time%1$s datetime="%2$s" data-df="LL"%3$s>%4$s</time>',
		$class_attr, // phpcs:ignore
		esc_attr( gmdate( 'c', $timestamp ) ),
		$tooltip_attr, // phpcs:ignore
		esc_html( date_i18n( get_option( 'date_format' ), $timestamp ) )
	);
}

function oviya_post_summary( $post_id = null, $max_length = 200 ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( has_excerpt( $post_id ) ) {
		return wp_strip_all_tags( get_the_excerpt( $post_id ) );
	}

	$content = get_post_field( 'post_content', $post_id );
	$content = strip_shortcodes( $content );
	$content = wp_strip_all_tags( $content );
	$content = preg_replace( '/\s+/', ' ', $content );
	$content = trim( $content );

	if ( mb_strlen( $content ) > $max_length ) {
		$content = mb_substr( $content, 0, $max_length ) . '…';
	}

	return $content;
}

function oviya_related_posts( $post_id, $limit = 3 ) {
	$categories = wp_get_post_categories( $post_id );
	$tags       = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );

	if ( empty( $categories ) && empty( $tags ) ) {
		return array();
	}

	$candidates = get_posts(
		array(
			'post_type'      => 'post',
			'post__not_in'   => array( $post_id ),
			'posts_per_page' => 50,
			'tax_query'      => array( // phpcs:ignore
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categories,
				),
				array(
					'taxonomy' => 'post_tag',
					'field'    => 'term_id',
					'terms'    => $tags,
				),
			),
		)
	);

	$scored = array();
	foreach ( $candidates as $candidate ) {
		$score = 0;
		$c_tags = wp_get_post_tags( $candidate->ID, array( 'fields' => 'ids' ) );
		$c_cats = wp_get_post_categories( $candidate->ID );

		$score += count( array_intersect( $tags, $c_tags ) ) * 1;
		$score += count( array_intersect( $categories, $c_cats ) ) * 0.5;

		if ( $score > 0 ) {
			$scored[] = array( 'post' => $candidate, 'score' => $score );
		}
	}

	usort( $scored, function ( $a, $b ) {
		return $b['score'] <=> $a['score'];
	} );

	return array_map(
		function ( $item ) {
			return $item['post'];
		},
		array_slice( $scored, 0, $limit )
	);
}

function oviya_recently_updated( $limit = 5 ) {
	return get_posts(
		array(
			'post_type'      => 'post',
			'posts_per_page' => $limit,
			'orderby'        => 'modified',
			'order'          => 'DESC',
		)
	);
}

function oviya_trending_tags( $limit = 10 ) {
	return get_terms(
		array(
			'taxonomy'   => 'post_tag',
			'orderby'    => 'count',
			'order'      => 'DESC',
			'number'     => $limit,
			'hide_empty' => true,
		)
	);
}

function oviya_normalize_url_for_compare( $url ) {
	$parts = wp_parse_url( $url );
	$host  = isset( $parts['host'] ) ? preg_replace( '/^www\./', '', strtolower( $parts['host'] ) ) : '';
	$path  = isset( $parts['path'] ) ? untrailingslashit( $parts['path'] ) : '';
	return $host . $path;
}

function oviya_menu_item_is_home( $tab ) {
	if ( oviya_normalize_url_for_compare( $tab->url ) === oviya_normalize_url_for_compare( home_url( '/' ) ) ) {
		return true;
	}

	if ( 'page' === $tab->object && $tab->object_id && 'page' === get_option( 'show_on_front' )
		&& (int) $tab->object_id === (int) get_option( 'page_on_front' ) ) {
		return true;
	}

	$parts = wp_parse_url( $tab->url );
	$path  = isset( $parts['path'] ) ? untrailingslashit( $parts['path'] ) : '';
	if ( '' === $path && 0 === strcasecmp( trim( wp_strip_all_tags( $tab->title ) ), 'home' ) ) {
		return true;
	}

	return false;
}

function oviya_guess_tab_icon( $tab ) {
	if ( $tab->object_id ) {
		$explicit = get_post_meta( $tab->object_id, '_oviya_icon', true );
		if ( $explicit ) {
			return $explicit;
		}

		$template = get_page_template_slug( $tab->object_id );
		if ( $template ) {
			if ( false !== strpos( $template, 'page-archives' ) ) {
				return 'fas fa-archive';
			}
			if ( false !== strpos( $template, 'page-categories' ) ) {
				return 'fas fa-stream';
			}
			if ( false !== strpos( $template, 'page-tags' ) ) {
				return 'fas fa-tags';
			}
		}

		$haystack = strtolower( get_the_title( $tab->object_id ) . ' ' . get_post_field( 'post_name', $tab->object_id ) );
	} else {
		$haystack = strtolower( $tab->title );
	}

	$guesses = array(
		'about'    => 'fas fa-info-circle',
		'archive'  => 'fas fa-archive',
		'categor'  => 'fas fa-stream',
		'tag'      => 'fas fa-tags',
		'contact'  => 'fas fa-envelope',
		'project'  => 'fas fa-diagram-project',
		'resume'   => 'fas fa-file-lines',
		'cv'       => 'fas fa-file-lines',
	);

	foreach ( $guesses as $needle => $icon ) {
		if ( false !== strpos( $haystack, $needle ) ) {
			return $icon;
		}
	}

	return 'fas fa-file';
}

function oviya_get_sidebar_tabs() {
	$menu_locations = get_nav_menu_locations();
	if ( empty( $menu_locations['primary'] ) ) {
		return array();
	}

	$items = wp_get_nav_menu_items( $menu_locations['primary'] );
	if ( ! $items ) {
		return array();
	}

	$items = array_values( array_filter( $items, function ( $tab ) {
		return ! oviya_menu_item_is_home( $tab );
	} ) );

	usort( $items, function ( $a, $b ) {
		return $a->menu_order <=> $b->menu_order;
	} );

	return $items;
}

function oviya_post_authors( $post_id = null ) {
	$post_id   = $post_id ? $post_id : get_the_ID();
	$author_id = get_post_field( 'post_author', $post_id );
	$name      = get_the_author_meta( 'display_name', $author_id );
	$url       = get_author_posts_url( $author_id );

	printf( '<em><a href="%1$s">%2$s</a></em>', esc_url( $url ), esc_html( $name ) );
}

function oviya_get_post_categories_line( $post_id = null ) {
	$cats = get_the_category( $post_id );
	if ( empty( $cats ) ) {
		return '';
	}
	$names = wp_list_pluck( $cats, 'name' );
	return implode( ', ', array_map( 'esc_html', $names ) );
}
