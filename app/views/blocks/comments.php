<?php
/**
 * Comments view
 *
 * @package photolab
 */
?>@if ( !post_password_required() ) 

<div id="comments" class="comments-area">
	@if ( have_comments() ) 

		<h4 class="comments-title">
			<?php 
				printf( 
					esc_html( _nx( '%1$s Response', '%1$s Responses', get_comments_number(), 'comments title', 'blank' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				)
			?>
		</h4>

		@if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) )
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<div class="nav-previous">{{ get_previous_comments_link( __( '&larr; Older Comments', 'blogetti' ) ) }}</div>
			<div class="nav-next">{{ get_next_comments_link( __( 'Newer Comments &rarr;', 'blogetti' ) ) }}</div>
		</nav><!-- #comment-nav-above -->
		@endif

		<ol class="comment-list">
			{{
				wp_list_comments( 
					array(
						'style'      => 'ol',
						'short_ping' => true,
						'max_depth'	 => 4,
						'callback'   => array('Comments', 'comment'),
						'echo'       => false
					)
				)
			}}
		</ol><!-- .comment-list -->

		@if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) )
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<div class="nav-previous">{{ get_previous_comments_link( __( '&larr; Older Comments', 'blogetti' ) ) }}</div>
			<div class="nav-next">{{ get_next_comments_link( __( 'Newer Comments &rarr;', 'blogetti' ) ) }}</div>
		</nav><!-- #comment-nav-below -->
		@endif
	@endif

	@if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) 
		<p class="no-comments">{{ __( 'Comments are closed.', 'blogetti' ) }}</p>
	@endif

	<?php
		comment_form(
			array(
				'comment_field'  => '<div class="comment-form-comment"><div class="label"><em class="h6-style">' . __( 'Comments', 'blogetti' ) . '<span class="required accent1-color">*</span>' .  '</em></div><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
				'title_reply'    => '<span class="h4-style">' . __( 'Leave a Reply', 'blogetti' ) . '</span>',
				'title_reply_to' => '<span>' . __( 'Leave a Reply to %s', 'blogetti' ) . '</span>',
				'label_submit' 	 => __( 'Submit Comment', 'blogetti' ),
				'comment_notes_before' => '<em>' . __( 'Your email address will not be published. Required fields are marked ', 'blogetti' ) . '<span class="required accent1-color">*</span></em>',
			)
		);
	?>

</div><!-- #comments -->
@endif