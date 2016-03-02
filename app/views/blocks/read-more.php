@if( '' != $read_more )
	<a href="{{ esc_url( get_permalink() ) }}" class="btn btn-link h5-style"><em class="hidden-sm-down">{{ esc_attr( $read_more ) }}</em> <i class="material-icons">arrow_forward</i></a>
@endif
