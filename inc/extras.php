<?php

function algores_body_classes( $classes )
{
	if( is_post_type_archive('note') || is_home() || is_single('note') ) {
		$classes[] = 'notes';
	} else if( ! is_page() && ! is_404() && ! is_search() ) {
		$classes[] = 'research';
	}

	return $classes;
}
add_filter( 'body_class', 'algores_body_classes' );



function algores_post_classes( $classes )
{
	global $post;

	if( is_single() ) {
		$classes[] = 'open';
	}
	else if( get_post_type() === 'note' )
	{
		$data = get_post_meta($post->ID, 'note_data', true);

		if( empty($data['size']) ) {
			$data['size'] = 'ars_medium';
		}

		$classes[] = $data['size'];
	}

	return $classes;
}
add_filter( 'post_class', 'algores_post_classes' );



function algores_get_image_dimensions( $size )
{
	global $_wp_additional_image_sizes;

	$width = $_wp_additional_image_sizes[ $size ]['width'];
	$height = $_wp_additional_image_sizes[ $size ]['height'];

	return 'width: ' . $width . 'px; height: ' . $height . 'px; ';
}



function algores_header_css()
{
	echo '<style type="text/css">';
?>
	.ars_small_1,
	.ars_small_1 .wrapper
	{
		<?php echo algores_get_image_dimensions('ars_small_1'); ?>
	}

	.ars_small_2,
	.ars_small_2 .wrapper
	{
		<?php echo algores_get_image_dimensions('ars_small_2'); ?>
	}

	.ars_medium,
	.ars_medium .wrapper
	{
		<?php echo algores_get_image_dimensions('ars_medium'); ?>
	}

	.ars_big_1,
	.ars_big_1 .wrapper
	{
		<?php echo algores_get_image_dimensions('ars_big_1'); ?>
	}

	.ars_big_2,
	.ars_big_2 .wrapper
	{
		<?php echo algores_get_image_dimensions('ars_big_2'); ?>
	}
<?php
	echo '</style>';
}
add_action('wp_head', 'algores_header_css');



/* misc and helpers */

function algores_convert_first_attached_image_to_featured()
{
	if( ! isset($_GET['convert_to_featured']) ) {
		return false;
	}

	$q = array(
		'post_type' => array('post', 'note'),
		'posts_per_page' => 9999
	);

	$query = new WP_Query($q);

	foreach( $query->posts as $post )
	{
		$thumb_id = get_post_meta($post->ID, '_thumbnail_id', true);

		if( ! $thumb_id )
		{
			$args = array(
				'post_parent' => $post->ID,
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'posts_per_page' => 1,
				'orderby' => 'menu_order',
				'order' => 'ASC'
			);

			$images = new WP_Query($args);

			if( $images->found_posts ) {
				update_post_meta($post->ID, '_thumbnail_id', $images->post->ID);
			}
		}
	}
}
// add_action('after_setup_theme', 'algores_convert_first_attached_image_to_featured');

function alogores_fm_term_category()
{
	$fm = new Fieldmanager_Colorpicker( array(
		'name' => 'background_color',
	));
	$fm->add_term_meta_box( 'Background color', 'category' );

	$fm = new Fieldmanager_Colorpicker( array(
		'name' => 'color',
	));
	$fm->add_term_meta_box( 'Color', 'category' );
}
add_action('fm_term_category', 'alogores_fm_term_category');



function algores_filter_caldera_forms_assets( $urls )
{
	if( isset($urls['grid']) ) {
		return array();
	}

	unset($urls['conditionals']);
	unset($urls['modals']);
	unset($urls['field']);
	unset($urls['validator-i18n']);

	foreach( $urls as $script_key => $script_url )
	{
		if( ! empty( $script_url ) ){
			wp_enqueue_script( 'cf-' . $script_key, $script_url, array('jquery'), CFCORE_VER, true );
		}
	}

	return array();
}
if( ! is_admin() )
{
	add_filter('caldera_forms_style_urls', 'algores_filter_caldera_forms_assets' );
	add_filter('caldera_forms_script_urls', 'algores_filter_caldera_forms_assets' );
}



function algores_rewrite_rules( $rules )
{
	$newrules = array();

	$newrules['notes/category/([^/]+)/page/([\d]+)$'] = 'index.php?post_type=note&category_name=$matches[1]&paged=$matches[2]';
	$newrules['notes/category/([^/]+)$'] = 'index.php?post_type=note&category_name=$matches[1]';
	$newrules['notes/page/([\d]+)$'] = 'index.php?post_type=note&paged=$matches[1]';
	$newrules['notes$'] = 'index.php?post_type=note';

	$newrules['research/category/([^/]+)/page/([\d]+)$'] = 'index.php?post_type=post&category_name=$matches[1]&paged=$matches[2]';
	$newrules['research/category/([^/]+)$'] = 'index.php?post_type=post&category_name=$matches[1]';
	$newrules['research/page/([\d]+)$'] = 'index.php?post_type=post&paged=$matches[1]';
	$newrules['research$'] = 'index.php?post_type=post';

	return $newrules + $rules;
}
add_filter('rewrite_rules_array', 'algores_rewrite_rules');



function algores_filter_pre_get_posts( $query )
{
	if( ! is_admin() && $query->is_main_query() )
	{
		if( is_home() ) {
			$query->query_vars['post_type'] = 'note';
		}

		if( is_home() || is_archive('note') ) {
			$query->query_vars['posts_per_page'] = 25;
		}
	}

	return $query;
}
add_action('pre_get_posts', 'algores_filter_pre_get_posts');



function algores_parse_query ( &$query )
{
	if( $query->query_vars['post_type'] == 'post' ) {
		$query->is_home = false;
	}
}
add_action( 'parse_query', 'algores_parse_query' );