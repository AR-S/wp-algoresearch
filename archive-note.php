<?php get_header(); ?>

	<div id="primary" class="content-area">

		<header class="page-header">
			<h1 class="page-title">Notes</h1>
		</header><!-- .page-header -->

		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'note' ); ?>
			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		<?php
			global $wp_query, $paged;

			if( ! $paged ) {
				$paged = 1;
			}

			$num = $wp_query->max_num_pages;

			if( $num > 1 )
			{
				$i = 1;

				echo '<div class="dot-pagination">';

				for( $i; $i <= $num; $i++ )
				{
					$class = ($i == $paged) ? 'current' : '';
					echo '<a href="/notes/page/' . $i . '" class="' . $class . '" title="Go to page ' . $i . '">' . $i . '</a>';
				}

				echo '</div>';
			}
		?>

		</main><!-- #main -->

	</div><!-- #primary -->

<?php get_footer(); ?>
