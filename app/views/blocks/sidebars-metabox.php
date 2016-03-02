<?php
/**
 * Blocks/Sidebars Metabox view
 *
 * @package photolab
 */
?>
<table>
	<tbody>
		<tr>
			<td><label for="full_width"> {{ __( 'Full width', 'blogetti' ) }}: </label></td>
			<td>{{ $full_width }}</td>
		</tr>
		<tr>
			<td><label for="before_content"> {{ __( 'Before content', 'blogetti' ) }}: </label></td>
			<td>{{ $before_content }}</td>
		</tr>
		<tr>
			<td><label for="before_loop"> {{ __( 'Before loop', 'blogetti' ) }}: </label></td>
			<td>{{ $before_loop }}</td>
		</tr>
		<tr>
			<td><label for="content_area"> {{ __( 'Content', 'blogetti' ) }}: </label></td>
			<td>{{ $content_area }}</td>
		</tr>
		<tr>
			<td><label for="after_content"> {{ __( 'After content', 'blogetti' ) }}: </label></td>
			<td>{{ $after_content }}</td>
		</tr>
		<tr>
			<td><label for="after_content_full_width"> {{ __( 'After content full width', 'blogetti' ) }}: </label></td>
			<td>{{ $after_content_full_width }}</td>
		</tr>
		<tr>
			<td><label for="left_sidebar"> {{ __( 'Sidebar left', 'blogetti' ) }}: </label></td>
			<td>{{ $left_sidebar }}</td>
		</tr>
		<tr>
			<td><label for="right_sidebar"> {{ __( 'Sidebar right', 'blogetti' ) }}: </label></td>
			<td>{{ $right_sidebar }}</td>
		</tr>
		<tr>
			<td><label for="footer"> {{ __( 'Footer', 'blogetti' ) }}: </label></td>
			<td>{{ $footer }}</td>
		</tr>
		<tr>
			<td><label for="footer_first_column"> {{ __( 'Footer first column', 'blogetti' ) }}: </label></td>
			<td>{{ $footer_first_column }}</td>
		</tr>
		<tr>
			<td><label for="footer_second_column"> {{ __( 'Footer second column', 'blogetti' ) }}: </label></td>
			<td>{{ $footer_second_column }}</td>
		</tr>
		<tr>
			<td><label for="footer_third_column"> {{ __( 'Footer third column', 'blogetti' ) }}: </label></td>
			<td>{{ $footer_third_column }}</td>
		</tr>
		<tr>
			<td><label for="footer_fourth_column"> {{ __( 'Footer fourth column', 'blogetti' ) }}: </label></td>
			<td>{{ $footer_fourth_column }}</td>
		</tr>
	</tbody>
</table>
