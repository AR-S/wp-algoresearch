<?php
/**
 * Template Name: Modal Overlay
 *
 * @package Algores
 * @subpackage Algores
 */
?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
