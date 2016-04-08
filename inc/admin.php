<?php

function algores_manage_posts_columns ( $columns, $post_type )
{
	$post_thumb = array('post_thumbnail' => 'Featured image');

	$columns = array_slice($columns, 0, 1, true) 
			+ $post_thumb 
			+ array_slice($columns, 1, count($columns)-1, true);

	$newcols = array();

	return array_merge($columns, $newcols);
}
add_filter( 'manage_posts_columns', 'algores_manage_posts_columns', 100, 2 );



function algores_manage_posts_custom_column ( $column_name, $post_id )
{
	switch( $column_name )
	{
		case 'post_thumbnail':
			if( $thumb_id = get_post_meta($post_id, '_thumbnail_id', true) ) {
				echo wp_get_attachment_image($thumb_id);
			}
		break;
	}
}
add_action( 'manage_posts_custom_column', 'algores_manage_posts_custom_column', 100, 2 );



function algores_fm_user()
{
	$fm = new Fieldmanager_Media( array(
		'name' => 'photo',
	));
	$fm->add_user_form( 'User photo' );

	$fm = new Fieldmanager_Checkbox( array(
		'name' => 'show_profile',
	));
	$fm->add_user_form( 'Show on "People" page' );
}
add_action('fm_user', 'algores_fm_user');
