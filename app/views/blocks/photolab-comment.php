<?php
/**
 * Photolab comment view
 *
 * @package photolab
 */
?>@if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type )
	<li id="comment-{{ get_comment_ID() }}" {{ comment_class( '', null, null, false ) }}>
		<div class="comment-body">
			{{ __( 'Pingback:', 'blogetti' ) }} {{ get_comment_author_link() }} <?php edit_comment_link( __( 'Edit', 'blogetti' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	@else
	<li id="comment-{{ get_comment_ID() }}" {{ comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false ) }}>
		<article id="div-comment-{{ get_comment_ID() }}" class="comment-body">
			<div class="comment-author vcard alignleft">
				<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 75 ); ?>
			</div>
			<div class="comment-content">

				<div class="comment-meta h6-style">
					<span><em>
						<?php printf( '%1$s <strong class="accent1-color">%2$s</strong>', __( 'Posted by', '__tm' ), get_comment_author_link($comment) ); ?>

					</em></span>
					<span class="accent1-color"><em>
						<time datetime="{{ get_comment_time( 'c' ) }}">
							{{ get_comment_time( get_option('date_format') ) }}
						</time>
					</em></span>
				</div>

				@if ( '0' == $comment->comment_approved )
					<p class="comment-awaiting-moderation">{{ __( 'Your comment is awaiting moderation.', 'blogetti' ) }}</p>
				@endif

				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
			
			</div><!-- .comment-content -->
			<div class="clear"></div>
			{{
				get_comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'reply_text'=> '<i class="material-icons">reply</i>',
							'after'     => '</div>',
						)
					)
				)
			}}

		</article><!-- .comment-body -->
@endif
