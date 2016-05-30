<?php

function algores_post_gallery( $post_id = NULL )
{
	global $post, $thumb_id;

	if( $post_id === NULL ) {
		$post_id = $post->ID;
	}

	$images = get_attached_media('image', $post_id);
	$thumb_id = get_post_meta($post_id, '_thumbnail_id', true);

	if( ! empty($images) )
	{
		$images = array_filter($images, function($image){
			global $thumb_id;
			return $image->ID != $thumb_id;
		});
	}

	if( ! empty($images) )
	{
		$dots = count($images) > 1 ? 'has-dots' : '';

		echo '<div class="post-gallery carousel owl-carousel owl-theme ' . $dots . '">';

		foreach( $images as $image )
		{
			$src = wp_get_attachment_image_src($image->ID, 'ars_carousel');
			$full = wp_get_attachment_image_src($image->ID, 'full');
			$bg_image = ' background-image: url(' . $src[0] . ');';
		?>
		<a style="<?php echo $bg_image; ?>" href="<?php echo $full[0]; ?>" id="attachment-image-<?php echo $image->ID; ?>" class="carousel-item item">
			<?php echo $image->post_title; ?>
		</a>
		<?php
		}

		echo '</div>';
	}
}



function algores_note_link()
{
	global $post;

	$data = get_post_meta($post->ID, 'note_data', true);

	if( ! empty($data['link']) ) {
		echo '<p>(<a href="' . $data['link'] . '" class="article-link">source accessed ' . date('d.m.Y.', $data['date_accessed']) . '</a>)</p>';
	}
}



function algores_category_dots()
{
	$cats = get_terms('category');
	$notes = is_home() || is_post_type_archive('note');

	$out = array();

	foreach( $cats as $cat )
	{
		$cid = $cat->term_id;
		$background_color = get_term_meta($cid, 'background_color', true);
		$color = get_term_meta($cid, 'color', true);
		$style = "color: $background_color;";
		$link = get_category_link($cid);

		if( $notes ) {
			$link = str_replace('/category/', '/notes/category/', $link);
		}

		$out[] = '<li><a href="' . $link . '" style="' . $style . '" data-title="' . $cat->name . '"><span>' . $cat->name . '</span></a></li>';
	}

	echo join("\n", $out);
}



function algores_active_category_background()
{
	$cat = get_category_by_slug(get_query_var('category_name'));

	if( ! $cat ) {
		echo 'inherit';
		return;
	}

	echo get_term_meta($cat->term_id, 'background_color', true);
}
