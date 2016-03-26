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

function algores_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'algores' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'algores' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

function algores_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'algores' ) );
		if ( $categories_list && algores_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'algores' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'algores' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'algores' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'algores' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

function algores_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'algores_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'algores_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so algores_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so algores_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in algores_categorized_blog.
 */
function algores_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'algores_categories' );
}
add_action( 'edit_category', 'algores_category_transient_flusher' );
add_action( 'save_post',     'algores_category_transient_flusher' );


function algores_note_link()
{
	global $post;

	$data = get_post_meta($post->ID, 'note_data', true);

	if( ! empty($data['link']) ) {
		echo '<p><a href="' . $data['link'] . '" class="article-link">link to full article</a></p>';
	}
}


function algores_category_dots()
{
	$cats = get_terms('category');
	$notes = is_post_type_archive('note');

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