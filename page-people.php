<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main users" role="main">

			<?php the_post(); ?>

			<?php
				$users = get_users();

				foreach( $users as $user ) :

					$show_profile = get_user_meta($user->ID, 'show_profile', true);

					if( $show_profile ) :

						$first_name = get_user_meta($user->ID, 'first_name', true);
						$last_name = get_user_meta($user->ID, 'last_name', true);
						$description = wpautop(get_user_meta($user->ID, 'description', true));
						$photo = get_user_meta($user->ID, 'photo', true);
						$link = $user->data->user_url;

						if( $link )
						{
							$link = '<p>+ <a href="' . $link . '">Personal web page</a></p>';
							$description = $link . $description;
						}

						if( $photo )
						{
							$photo = wp_get_attachment_image_src($photo, 'medium');
							$photo = ' style="background-image: url(' . $photo[0] . ')"';
						}
			?>

			<article id="user-<?php echo $user->ID; ?>" class="user open">
				<div class="user-photo"<?php echo $photo; ?>></div>
				<h1 class="entry-title"><?php echo $first_name . ' ' . $last_name; ?></h1>
				<div class="entry-content">
					<?php echo $description; ?>
				</div><!-- .entry-content -->

			</article><!-- #post-## -->

			<?php endif; ?>
		<?php endforeach; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
