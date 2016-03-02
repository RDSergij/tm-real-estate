<?php
/**
 * Breadcumb trail file
 */

/**
 * Breadcrumbs trail model class
 */
class Model_Breadcrumb_Trail {

	const URL = '__URL__';
	const LABEL = '__LABEL__';

	public static $args = array(
		'post_taxonomy' => array(
			'post'      => 'category',
			'portfolio' => 'portfolio_category'
		)
	);

	/**
	 * Get breacrumbs list items
	 * @param  array  $args arguments.
	 * @return array items.
	 */
	public static function get_items( $args = array() ) {
		self::$args = array_merge( self::$args, $args );
		$items[] = self::get_site_home_link();
		if ( ! is_front_page() ) {
			// add blog page related items
			if ( is_home() ) {

				$items = array_merge( $items, self::get_blog_page() );

			} elseif ( is_singular() ) {

				// add single page/post items
				$items = array_merge( $items, self::get_singular_items() );
			} elseif ( is_archive() ) {

				// is is archive page
				if ( is_post_type_archive() ) {
					$items = array_merge( $items, self::get_post_type_archive_items() );

				} elseif ( is_category() || is_tag() || is_tax() ) {
					$items = array_merge( $items, self::get_term_archive_items() );

				} elseif ( is_author() ) {
					$items = array_merge( $items, self::get_user_archive_items() );

				} elseif ( get_query_var( 'minute' ) && get_query_var( 'hour' ) ) {
					$items = array_merge( $items, self::get_minute_hour_archive_items() );

				} elseif ( get_query_var( 'minute' ) ) {
					$items = array_merge( $items, self::get_minute_archive_items() );

				} elseif ( get_query_var( 'hour' ) ) {
					$items = array_merge( $items, self::get_hour_archive_items() );

				} elseif ( is_day() ) {
					$items = array_merge( $items, self::get_day_archive_items() );

				} elseif ( get_query_var( 'w' ) ) {
					$items = array_merge( $items, self::get_week_archive_items() );

				} elseif ( is_month() ) {
					$items = array_merge( $items, self::get_month_archive_items() );

				} elseif ( is_year() ) {
					$items = array_merge( $items, self::get_year_archive_items() );

				} else {
					$items = array_merge( $items, self::get_default_archive_items() );

				}
			} elseif ( is_search() ) {
				$items = array_merge( $items, self::get_search_items() );
			} elseif ( is_404() ) {
				/* If viewing the 404 page. */
				$items = array_merge( $items, self::get_404_items() );
			}
		}
		return $items;
	}

	/**
	 * Add site home link if is paged front page
	 */
	public static function get_site_home_link() {
		return array(
			self::URL => home_url( '/' ),
			self::LABEL => __( 'Homepage', 'blogetti' )
		);
	}

	/**
	 * Add blog page breadcrumbs item
	 */
	public static function get_blog_page() {
		$items   = array();
		$post_id = get_queried_object_id();
		$post    = get_page( $post_id );

		// If the post has parents, add them to the array.
		if ( 0 < $post->post_parent )
			$items = self::get_post_parents( $post->post_parent );

		$url   = get_permalink( $post_id );
		$label = get_the_title( $post_id );

		if ( is_paged() ) {
			$items[] = array(
				self::URL   => $url,
				self::LABEL => $label,
			);
		} elseif ( $label ) {
			$items[] = array(
				self::LABEL => $label,
			);
		}
		return $items;
	}

	/**
	 * Add post parents link to breadcrumbs items
	 *
	 * @param integer $post_id first parent post ID
	 */
	public static function get_post_parents( $post_id ) {

		$items = array();

		while ( $post_id ) {

			$items[] = array(
				self::URL => get_permalink( $post_id ),
				self::LABEL => get_the_title( $post_id )
			);

			$post = get_post( $post_id );
			// If there's no longer a post parent, break out of the loop.
			if ( 0 >= $post->post_parent ) {
				break;
			}

			// Change the post ID to the parent post to continue looping.
			$post_id = $post->post_parent;
		}
		// Get the post hierarchy based off the final parent post.
		$items = array_merge( array_reverse( $items ), (array) self::get_post_hierarchy( $post_id ), (array) self::get_post_terms( $post_id ) );

		return $items;
	}

	public static function get_post_hierarchy( $post_id ) {
		$items = array();
		// Get the post type.
		$post_type        = get_post_type( $post_id );
		$post_type_object = get_post_type_object( $post_type );

		// If this is the 'post' post type, get the rewrite front items and map the rewrite tags.
		if ( 'post' === $post_type ) {
			// Get permalink specific breadcrumb items
			$items = array_merge(
				(array) self::get_rewrite_front_items(),
				(array) self::get_map_rewrite_tags( $post_id, get_option( 'permalink_structure' ) )
			);
		} elseif ( false !== $post_type_object->rewrite ) {
			// Add post type specific items
			if ( isset( $post_type_object->rewrite['with_front'] ) && $post_type_object->rewrite['with_front'] ) {
				$items = self::get_rewrite_front_items();
			}
		}

		/* If there's an archive page, add it to the trail. */
		if ( !empty( $post_type_object->has_archive ) ) {
			$items[] = array(
				self::URL => get_post_type_archive_link( $post_type ),
				self::LABEL => !empty( $post_type_object->labels->archive_title )
						? $post_type_object->labels->archive_title
						: $post_type_object->labels->name,
			);
		}
	}

	/**
	 * Add front items based on $wp_rewrite->front.
	 */
	public static function get_rewrite_front_items() {
		$items = array();
		global $wp_rewrite;

		if ( $wp_rewrite->front ) {
			$items = self::get_path_parents( $wp_rewrite->front );
		}
		return $items;
	}

	/**
	 * Get parent posts by path. Currently, this method only supports getting parents of the 'page'
	 * post type.  The goal of this function is to create a clear path back to home given what would
	 * normally be a "ghost" directory.  If any page matches the given path, it'll be added.
	 *
	 * @param  string $path The path (slug) to search for posts by.
	 */
	public static function get_path_parents( $path ) {

		$items = array();
		/* Trim '/' off $path in case we just got a simple '/' instead of a real path. */
		$path = trim( $path, '/' );

		/* If there's no path, return. */
		if ( empty( $path ) )
			return;

		// process default Cherry permalinks by own way
		if ( in_array( $path, array( 'tag', 'category' ) ) ) {
			return;
		}

		/* Get parent post by the path. */
		$post = get_page_by_path( $path );

		if ( !empty( $post ) ) {
			$items = self::get_post_parents( $post->ID );
		} elseif ( is_null( $post ) ) {

			/* Separate post names into separate paths by '/'. */
			$path = trim( $path, '/' );
			preg_match_all( "/\/.*?\z/", $path, $matches );

			/* If matches are found for the path. */
			if ( isset( $matches ) ) {

				/* Reverse the array of matches to search for posts in the proper order. */
				$matches = array_reverse( $matches );

				/* Loop through each of the path matches. */
				foreach ( $matches as $match ) {

					/* If a match is found. */
					if ( isset( $match[0] ) ) {

						/* Get the parent post by the given path. */
						$path = str_replace( $match[0], '', $path );
						$post = get_page_by_path( trim( $path, '/' ) );

						/* If a parent post is found, set the $post_id and break out of the loop. */
						if ( !empty( $post ) && 0 < $post->ID ) {
							$items = self::get_post_parents( $post->ID );
							break;
						}
					}
				}
			}
		}
		return $items;
	}

	/**
	 * Turns %tag% from permalink structures into usable links for the breadcrumb trail.
	 * This feels kind of hackish for now because we're checking for specific %tag% examples and only doing
	 * it for the 'post' post type. In the future, maybe it'll handle a wider variety of possibilities,
	 * especially for custom post types.
	 *
	 * @param  int    $post_id ID of the post whose parents we want.
	 * @param  string $path    Path of a potential parent page.
	 */
	public static function get_map_rewrite_tags( $post_id, $path ) {
		$items = array();
		/* Get the post based on the post ID. */
		$post = get_post( $post_id );

		/* If no post is returned, an error is returned, or the post does not have a 'post' post type, return. */
		if ( empty( $post ) || is_wp_error( $post ) || 'post' !== $post->post_type ) {
			return $items;
		}

		/* Trim '/' from both sides of the $path. */
		$path = trim( $path, '/' );

		/* Split the $path into an array of strings. */
		$matches = explode( '/', $path );

		/* If matches are found for the path. */
		if ( ! is_array( $matches ) ) {
			return $items;
		}

		/* Loop through each of the matches, adding each to the $trail array. */
		foreach ( $matches as $match ) {
			$items = array_merge( $items, (array) self::get_single_tag( $match, $post_id ) );
		}
		return $items;
	}

	/**
	 * Service function to process single tag item
	 *
	 * @param  string $tag     single tag.
	 * @param  int    $post_id processed post ID.
	 */
	public static function get_single_tag( $tag, $post_id ) {

		global $post;

		/* Trim any '/' from the $tag. */
		$tag = trim( $tag, '/' );

		/* If using the %year% tag, add a link to the yearly archive. */
		if ( '%year%' == $tag ) {
			return array(
				self::URL => get_year_link( get_the_time( 'Y', $post_id ) ),
				self::LABEL => get_the_time( _x( 'Y', 'yearly archives date format', 'blogetti' ) ),
			);

		/* If using the %monthnum% tag, add a link to the monthly archive. */
		} elseif ( '%monthnum%' == $tag ) {
			return array(
				self::URL => get_month_link( get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ) ),
				self::LABEL => get_the_time( _x( 'F', 'monthly archives date format', 'blogetti' ) ),
			);

		/* If using the %day% tag, add a link to the daily archive. */
		} elseif ( '%day%' == $tag ) {
			return array(
				self::URL => get_day_link(
					get_the_time( 'Y', $post_id ), get_the_time( 'm', $post_id ), get_the_time( 'd', $post_id )
				),
				self::LABEL => get_the_time( _x( 'j', 'daily archives date format', 'blogetti' ) ),
			);

		/* If using the %author% tag, add a link to the post author archive. */
		} elseif ( '%author%' == $tag ) {
			return array(
				self::URL => get_author_posts_url( $post->post_author ),
				self::LABEL => get_the_author_meta( 'display_name', $post->post_author ),
			);

		/* If using the %category% tag, add a link to the first category archive to match permalinks. */
		} elseif ( '%category%' == $tag ) {

			$items = array();
			/* Force override terms in this post type. */
			self::$args['post_taxonomy'][ $post->post_type ] = false;

			/* Get the post categories. */
			$terms = get_the_category( $post_id );

			/* Check that categories were returned. */
			if ( $terms ) {

				/* Sort the terms by ID and get the first category. */
				usort( $terms, '_usort_terms_by_ID' );
				$term = get_term( $terms[0], 'category' );

				/* If the category has a parent, add the hierarchy to the trail. */
				if ( 0 < $term->parent ) {
					$items = self::get_term_parents( $term->parent, 'category' );
				}

				$items[] = array(
					self::URL => get_term_link( $term, 'category' ),
					self::LABEL => $term->name,
				);

				return $items;
			}
		}
	}

	/**
	 * Searches for term parents of hierarchical taxonomies.
	 * This function is similar to the WordPress function get_category_parents() but handles any type of taxonomy.
	 *
	 * @param  int    $term_id  ID of the term to get the parents of.
	 * @param  string $taxonomy Name of the taxonomy for the given term.
	 */
	public static function get_term_parents( $term_id, $taxonomy ) {

		/* Set up some default arrays. */
		$parents = array();

		/* While there is a parent ID, add the parent term link to the $parents array. */
		while ( $term_id ) {

			/* Get the parent term. */
			$term = get_term( $term_id, $taxonomy );

			$parents[] = array(
				self::URL => get_term_link( $term_id, $taxonomy ),
				self::LABEL => esc_attr( $term->name ),
			);

			/* Set the parent term's parent as the parent ID. */
			$term_id = $term->parent;
		}

		return $parents;
	}

	/**
	 * Adds a post's terms from a specific taxonomy to the items array.
	 *
	 * @param  int    $post_id The ID of the post to get the terms for.
	 */
	public static function get_post_terms( $post_id ) {
		$items = array();
		/* Get the post type. */
		$post_type = get_post_type( $post_id );

		/* Add the terms of the taxonomy for this post. */
		if ( !empty( self::$args['post_taxonomy'][ $post_type ] ) ) {

			$post_terms = wp_get_post_terms( $post_id, self::$args['post_taxonomy'][ $post_type ] );

			if ( is_array( $post_terms ) && isset( $post_terms[0] ) && is_object( $post_terms[0] ) ) {
				$term_id = $post_terms[0]->term_id;
				$items = self::get_term_parents( $term_id, self::$args['post_taxonomy'][ $post_type ] );
			}
		}
		return $items;
	}

	/**
	 * Adds singular post items to the items array.
	 *
	 * @since  4.0.0
	 */
	public static function get_singular_items() {
		$items = array();
		/* Get the queried post. */
		$post    = get_queried_object();
		$post_id = get_queried_object_id();
		
		/* If the post has a parent, follow the parent trail. */
		if ( 0 < $post->post_parent ) {
			$items = self::get_post_parents( $post->post_parent );
		} else {
			/* If the post doesn't have a parent, get its hierarchy based off the post type. */
			$items = self::get_post_hierarchy( $post_id );
		}

		/* Display terms for specific post type taxonomy if requested. */
		$items = array_merge( (array) $items, (array) self::get_post_terms( $post_id ) );

		/* End with the post title. */
		if ( $post_title = single_post_title( '', false ) ) {

			if ( 1 < get_query_var( 'page' ) ) {

				$items[] = array(
					self::URL => get_permalink( $post_id ),
					self::LABEL => $post_title,
				);

			}

			$items[] = array(
				self::URL => get_permalink( $post_id ),
				self::LABEL => $post_title,
			);

			return $items;

		}
	}

	/**
	 * Adds the items to the trail items array for post type archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_post_type_archive_items() {
		$items = array();
		/* Get the post type object. */
		$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

		if ( false !== $post_type_object->rewrite ) {

			/* If 'with_front' is true, add $wp_rewrite->front to the trail. */
			if ( $post_type_object->rewrite['with_front'] ) {
				$items = self::get_rewrite_front_items();
			}

		}

		/* Add the post type [plural] name to the trail end. */
		if ( is_paged() ) {
			$items[] = array(
				self::URL => esc_url( get_post_type_archive_link( $post_type_object->name ) ),
				self::LABEL => post_type_archive_title( '', false )
			);
		}

		$items[] = array(
			self::LABEL => post_type_archive_title( '', false )
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for taxonomy term archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_term_archive_items() {

		$items = array();
		global $wp_rewrite;

		/* Get some taxonomy and term variables. */
		$term     = get_queried_object();
		$taxonomy = get_taxonomy( $term->taxonomy );

		/* If there are rewrite rules for the taxonomy. */
		if ( false !== $taxonomy->rewrite ) {

			$post_type_catched = false;

			/* If 'with_front' is true, dd $wp_rewrite->front to the trail. */
			if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front ) {
				$items = self::get_rewrite_front_items();
			}

			/* Get parent pages by path if they exist. */
			$items = array_merge( $items, self::get_path_parents( $taxonomy->rewrite['slug'] ) );

			/* Add post type archive if its 'has_archive' matches the taxonomy rewrite 'slug'. */
			if ( $taxonomy->rewrite['slug'] ) {

				$slug = trim( $taxonomy->rewrite['slug'], '/' );

				/**
				 * Deals with the situation if the slug has a '/' between multiple strings. For
				 * example, "movies/genres" where "movies" is the post type archive.
				 */
				$matches = explode( '/', $slug );

				/* If matches are found for the path. */
				if ( isset( $matches ) ) {

					/* Reverse the array of matches to search for posts in the proper order. */
					$matches = array_reverse( $matches );

					/* Loop through each of the path matches. */
					foreach ( $matches as $match ) {

						/* If a match is found. */
						$slug = $match;

						/* Get public post types that match the rewrite slug. */
						$post_types = self::get_post_types_by_slug( $match );

						if ( !empty( $post_types ) ) {

							$post_type_object = $post_types[0];

							$items[] = array(
								self::URL => get_post_type_archive_link( $post_type_object->name ),
								self::LABEL => !empty( $post_type_object->labels->archive_title )
									? $post_type_object->labels->archive_title
									: $post_type_object->labels->name
							);

							$post_type_catched = true;
							/* Break out of the loop. */
							break;
						}
					}
				}
			}

			/* Add the post type archive link to the trail for custom post types */
			if ( ! $post_type_catched ) {
				$post_type = isset( $taxonomy->object_type[0] ) ? $taxonomy->object_type[0] : false;

				if ( $post_type && 'post' != $post_type ) {
					$post_type_object = get_post_type_object( $post_type );

					$items[] = array(
						self::URL => get_post_type_archive_link( $post_type_object->name ),
						self::LABEL => !empty( $post_type_object->labels->archive_title )
							? $post_type_object->labels->archive_title
							: $post_type_object->labels->name
					);

				}
			}

		}

		/* If the taxonomy is hierarchical, list its parent terms. */
		if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) {
			$items = array_merge( $items, self::get_term_parents( $term->parent, $term->taxonomy ) );
		}

		$label = single_term_title( '', false );

		/* Add the term name to the trail end. */
		if ( is_paged() ) {
			$items[] = array(
				self::URL => esc_url( get_term_link( $term, $term->taxonomy ) ),
				self::LABEL => $label,
			);
		}

		$items[] = array(
			self::LABEL => $label,
		);
		return $items;

	}

	/**
	 * Gets post types by slug.  This is needed because the get_post_types() function doesn't exactly
	 * match the 'has_archive' argument when it's set as a string instead of a boolean.
	 *
	 * @since  4.0.0
	 *
	 * @param  int    $slug  The post type archive slug to search for.
	 */
	public static function get_post_types_by_slug( $slug ) {

		$return = array();

		$post_types = get_post_types( array(), 'objects' );

		foreach ( $post_types as $type ) {

			if ( $slug === $type->has_archive || ( true === $type->has_archive && $slug === $type->rewrite['slug'] ) )
				$return[] = $type;
		}

		return $return;
	}

	/**
	 * Adds the items to the trail items array for user (author) archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_user_archive_items() {
		$items = array();
		global $wp_rewrite;

		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();

		/* Get the user ID. */
		$user_id = get_query_var( 'author' );

		/* If $author_base exists, check for parent pages. */
		if ( !empty( $wp_rewrite->author_base ) ) {
			$items = array_merge( $items, self::get_path_parents( $wp_rewrite->author_base ) );
		}

		$label = get_the_author_meta( 'display_name', $user_id );

		/* Add the author's display name to the trail end. */
		if ( is_paged() ) {
			$items[] = array(
				self::URL   => esc_url( get_author_posts_url( $user_id ) ),
				self::LABEL => $label,
			);

		}

		$items[] = array(
			self::LABEL => $label,
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for minute + hour archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_minute_hour_archive_items() {
		$items = array();
		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();
		$items[] = array(
			self::LABEL => get_the_time( _x( 'g:i a', 'minute and hour archives time format', 'blogetti' ) ),
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for minute archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_minute_archive_items() {
		$items = array();
		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();

		/* Add the minute item. */
		$items[] = array(
			self::LABEL => get_the_time( _x( 'i', 'minute archives time format', 'blogetti' ) ),
		);
		return $items;

	}

	/**
	 * Adds the items to the trail items array for hour archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_hour_archive_items() {
		$items = array();
		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();

		/* Add the minute item. */
		$items[] = array(
			self::LABEL => get_the_time( _x( 'g a', 'hour archives time format', 'blogetti' ) ),
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for day archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_day_archive_items() {
		$items = array();
		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();

		/* Add the year and month items. */
		$items[] = array(
			self::URL   => get_year_link( get_the_time( 'Y' ) ),
			self::LABEL => get_the_time( _x( 'Y', 'yearly archives date format',  'blogetti' ) ),
		);
		$items[] = array(
			self::URL   => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
			self::LABEL => get_the_time( _x( 'F', 'monthly archives date format', 'blogetti' ) ),
		);

		/* Add the day item. */
		if ( is_paged() ) {
			$items[] = array(
				self::URL   => get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ),
				self::LABEL => get_the_time( _x( 'j', 'daily archives date format',   'blogetti' ) ),
			);
		}

		$items[] = array(
			self::LABEL => get_the_time( _x( 'j', 'daily archives date format',   'blogetti' ) ),
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for week archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_week_archive_items() {
		$items = array();
		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();

		/* Get the year and week. */
		$items[] = array(
			self::URL   => get_year_link( get_the_time( 'Y' ) ),
			self::LABEL => get_the_time( _x( 'Y', 'yearly archives date format', 'blogetti' ) ),
		);

		/* Add the week item. */
		if ( is_paged() ) {
			$items[] = array(
				self::URL   =>add_query_arg( array( 'm' => get_the_time( 'Y' ), 'w' => get_the_time( 'W' ) ), home_url( '/' ) ),
				self::LABEL => get_the_time( _x( 'W', 'weekly archives date format', 'blogetti' ) ),
			);
		}

		$items[] = array(
			self::LABEL => get_the_time( _x( 'W', 'weekly archives date format', 'blogetti' ) ),
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for month archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_month_archive_items() {
		$items = array();
		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();

		/* Get the year and month. */
		$items[] = array(
			self::URL   => get_year_link( get_the_time( 'Y' ) ),
			self::LABEL => get_the_time( _x( 'Y', 'yearly archives date format',  'blogetti' ) ),
		);

		/* Add the month item. */
		if ( is_paged() ) {
			$items[] = array(
				self::URL   => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
				self::LABEL => get_the_time( _x( 'F', 'monthly archives date format', 'blogetti' ) ),
			);
		}

		$items[] = array(
			self::LABEL => get_the_time( _x( 'F', 'monthly archives date format', 'blogetti' ) ),
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for year archives.
	 *
	 * @since  4.0.0
	 */
	public static function get_year_archive_items() {
		$items = array();
		/* Add $wp_rewrite->front to the trail. */
		$items = self::get_rewrite_front_items();

		/* Add the year item. */
		if ( is_paged() ) {
			$items[] = array(
				self::URL   => get_year_link( get_the_time( 'Y' ) ),
				self::LABEL => get_the_time( _x( 'Y', 'yearly archives date format',  'blogetti' ) ),
			);
		}

		$items[] = array(
			self::LABEL => get_the_time( _x( 'Y', 'yearly archives date format',  'blogetti' ) ),
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for archives that don't have a more specific method
	 * defined in this class.
	 *
	 * @since  4.0.0
	 */
	public static function get_default_archive_items() {
		$items = array();

		/* If this is a date-/time-based archive, add $wp_rewrite->front to the trail. */
		if ( is_date() || is_time() ) {
			$items = self::get_rewrite_front_items();
		}

		$items[] = array(
			self::LABEL => __( 'Archives', 'blogetti' ),
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for search results.
	 *
	 * @since  4.0.0
	 */
	public static function get_search_items() {
		$items = array();
		$label = sprintf( __( 'Search results for &#8220;%s&#8221;', 'blogetti' ), get_search_query() );

		if ( is_paged() ) {
			$items[] = array(
				self::URL   => get_search_link(),
				self::LABEL => $label,
			);
		}

		$items[] = array(
			self::LABEL => $label,
		);
		return $items;
	}

	/**
	 * Adds the items to the trail items array for 404 pages.
	 *
	 * @since  0.6.0
	 * @access public
	 * @return void
	 */
	public static function get_404_items() {
		return array(
			array(
				self::LABEL => __( '404 Not Found', 'blogetti' ),
			),
		);
	}
}