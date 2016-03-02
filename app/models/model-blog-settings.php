<?php
/**
 * Blog settings model file
 *
 * @package photolab
 */

/**
 * Blog settings Model
 */
class Model_Blog_Settings implements I_Model {
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option('', 'blog_settings', $key );
	}

	/**
	 * Get content template name
	 *
	 * @return string content template name
	 */
	public static function get_content_name() {
		$post_format = ( string ) get_post_format();
		return '' == $post_format ? 'content' : $post_format;
	}

	/**
	 * Get paginate links
	 *
	 * @return string
	 */
	public static function get_paginate_links() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		return paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $wp_query->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 1,
				//'add_args'  => array_map( 'urlencode', (array) $query_args ),
				'prev_text' => '<i class="material-icons">keyboard_arrow_left</i>',
				'next_text' => '<i class="material-icons">keyboard_arrow_right</i>',
			)
		);
	}

	/**
	 * Get layout
	 *
	 * @return string layout name.
	 */
	public static function get_layout() {
		$layout = (string) self::get_option( 'layout' );
		if ( '' == $layout ) {
			$layout = 'default';
		}
		return $layout;
	}

	/**
	 * Get loop name
	 *
	 * @return string loop name.
	 */
	public static function get_loop_name() {
		$loops = array(
			'default' => 'loop',
			'grid'    => 'loop-grid',
			'masonry' => 'loop-masonry'
		);
		return $loops[ self::get_layout() ];
	}

	/**
	 * Columns
	 *
	 * @return string columns count.
	 */
	public static function get_columns() {
		$columns = (string) self::get_option( 'columns' );
		if ( '' == $columns ) {
			$columns = 2;
		}
		return $columns;
	}

	/**
	 * Get column CSS class
	 *
	 * @return string --- column CSS class
	 */
	public static function get_column_css_class() {
		$classes = array(
			2 => 'col-md-6 col-lg-6',
			3 => 'col-md-4 col-lg-4',
		);
		return $classes[ self::get_columns() ];
	}

	/**
	 * Exclude category
	 *
	 * @return string text.
	 */
	public static function get_exclude_categories_from_blog() {
		$exclude = trim( (string) self::get_option( 'exclude_categories_from_blog' ) );
		if ( '' == $exclude ) {
			return '';
		}
		$result   = array();
		$elements = explode( ',', $exclude );
		foreach ($elements as $value) {
			$result[] = $value * -1;
		}
		return implode(',', $result);
	}

	/**
	 * Blog label
	 *
	 * @return string text.
	 */
	public static function get_blog_label() {
		$blog_label = (string) self::get_option( 'blog_label' );
		if ( '' == $blog_label ) {
			$blog_label = get_option( 'blogname' );
		}
		return $blog_label;
	}

	/**
	 * Read more text button
	 *
	 * @return string text.
	 */
	public static function get_read_more_button_text() {
		$read_more = (string) self::get_option( 'read_more_button_text' );
		if ( '' == $read_more ) {
			$read_more = __( 'Read more', 'blogetti' );
		}
		return $read_more;
	}

	/**
	 * Hide additional info ( post author, publish date, category, tags) in single post
	 *
	 * @return string.
	 */
	public static function is_hide_additional_info_in_single() {
		return (boolean) self::get_option( 'hide_additional_info_in_single' );
	}

	/**
	 * Hide additional info ( post author, publish date, category, tags) in loop posts
	 *
	 * @return string.
	 */
	public static function is_hide_additional_info_in_loop() {
		return (boolean) self::get_option( 'hide_additional_info_in_loop' );
	}

	/**
	 * Enable / Disable the author block after each post
	 *
	 * @return string.
	 */
	public static function is_on_off_author_block() {
		return (boolean) self::get_option( 'on_off_author_block' );
	}
}
