<div class="post-meta h6-style">
    <span class="meta-author"><em><?php echo __( 'Posted by', 'blogetti' ); ?> <a href="{{ get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) }}" class="author"><strong>{{ get_the_author() }}</strong></a></em></span>
    <span class="meta-date accent1-color"><em><time datatime="{{ get_the_date( 'Y-m-d' ) }}">{{ get_the_date( get_option('date_format') ) }}</time></em></span>
    <span class="meta-comments"><a href="{{ esc_url( get_permalink() ) }}#comments"><em><?php comments_number( 'no comments', 'one response', '% comments' ) ?></em></a></span>
    @if (get_the_tag_list())
	    <span class="meta-tags">
	    	{{ get_the_tag_list('<em>',', ', '</em>') }}
		</span>
	@endif
</div>