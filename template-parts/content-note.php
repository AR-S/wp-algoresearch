<?php
$text_style = '';
$wrapper_style = '';
$category_color = '';
$category = get_the_terms($post->ID, 'category');

if( is_array($category) && count($category) )
{
	$category = reset($category);
	$category_color = get_term_meta( $category->term_id, 'color', true );
	$category_background_color = get_term_meta( $category->term_id, 'background_color', true );
}

$classes = array();

if( is_single() ) {
	$classes[] = 'open';
}

if( ! empty($category_background_color) )
{
	$cat_bg_color = 'background-color: ' . $category_background_color . ';';
	$text_style .= $cat_bg_color;
	$both_style = $cat_bg_color . 'color: ' . $category_background_color . ';';

	if( strtolower($category_background_color) === '#0000ff' ) {
		$classes[] = 'light';
	}
}
else
{
	$cat_bg_color = 'background-color: #FFF;';
	$text_style .= $cat_bg_color;
	$both_style = $cat_bg_color . 'color: #FFF;';
}

if( ! empty($category_color) )
{
	$cat_color = 'color: ' . $category_color . ';';	
	$text_style .= $cat_color;
}
else
{
	$cat_color = 'color: #000;';	
	$text_style .= $cat_color;
}

$post_thumb_id = get_post_meta($post->ID, '_thumbnail_id', true);

if( $post_thumb_id )
{
	$post_thumbnail = wp_get_attachment_image_src($post_thumb_id, 'ars_carousel');
	$wrapper_style = 'background-image: url(' . $post_thumbnail[0] . ');';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>

	<?php edit_post_link(); ?>

	<?php if( ! is_single() ) : ?>
		<a href="<?php the_permalink(); ?>" class="wrapper" style="<?php echo $wrapper_style; ?>">
			<div class="text" style="<?php echo $both_style; ?>">
				<header class="entry-header" style="<?php echo $cat_color; ?>">
					<h2 class="entry-title"><?php the_title(); ?></h2>
				</header><!-- .entry-header -->

				<div class="entry-excerpt" style="<?php echo $cat_color; ?>">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
			</div>
		</a>
		<div class="entry-content" style="<?php echo $text_style; ?>"></div><!-- .entry-content -->
	<?php else : ?>
		<div class="wrapper" style="<?php echo $wrapper_style; ?>">
			<div class="text" style="<?php echo $text_style; ?>">
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php the_content(); ?>
					<?php algores_note_link(); ?>
				</div><!-- .entry-content -->
			</div>
		</div>
	<?php endif; ?>
	
</article><!-- #post-## -->
