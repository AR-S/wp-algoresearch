<?php get_header(); ?>

	<div id="primary" class="content-area">

		<header class="page-header">
			<h1 class="page-title">Research</h1>
		</header><!-- .page-header -->

		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->

		<?php the_posts_navigation(); ?>
		
	</div><!-- #primary -->

<?php get_footer(); ?>
