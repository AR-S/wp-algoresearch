<?php
$style = '';
$thumbnail_style = '';
$category_color = '';
$category = get_the_terms($post->ID, 'category');

if( is_array($category) && count($category) )
{
	$category = reset($category);
	$category_color = get_term_meta( $category->term_id, 'color', true );
	$category_background_color = get_term_meta( $category->term_id, 'background_color', true );
}

$classes = array();

if( ! empty($category_background_color) )
{
	$style .= 'background-color: ' . $category_background_color . '; color: ' . $category_color . ';';

	if( strtolower($category_background_color) === '#0000ff' ) {
		$classes[] = 'light';
	}
}

$post_thumb_id = get_post_meta($post->ID, '_thumbnail_id', true);

if( $post_thumb_id )
{
	$post_thumbnail = wp_get_attachment_image_src($post_thumb_id, 'ars_carousel');
	$thumbnail_style = 'style="background-image: url('. $post_thumbnail[0] .');"';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>

	<header class="entry-header" style="<?php echo $style; ?>">

		<?php if ( is_single() ) : ?>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php algores_post_gallery(get_the_ID()); ?>
		<?php else : ?>
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<?php if( $thumbnail_style !== '' ) : ?>
				<div class="post-thumbnail" <?php echo $thumbnail_style; ?>></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php edit_post_link(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if( is_single() ):  ?>
			<?php the_content(); ?>
			<?php algores_note_link(); ?>
		<?php endif; ?>
		
	</div><!-- .entry-content -->

	<div class="faux-footer <?php echo implode(' ', $classes); ?>" style="<?php echo $style; ?>"><?php the_title(); ?></div>

</article><!-- #post-## -->
