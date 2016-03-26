<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
<script type="text/javascript">
	document.documentElement.className = document.documentElement.className.replace("no-js", "js");
	var siteroot = "<?php bloginfo('url'); ?>";
</script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content">Skip to content</a>

	<header id="masthead" class="site-header" role="banner">

		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>

		<div class="site-tools">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<a href="#primary-menu-container" class="menu-show" aria-controls="primary-menu" aria-expanded="false">Primary Menu</a>
				<div class="site-menu-drawer">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_id' => 'primary-menu-container' ) );?>
					<a href="#" class="menu-hide" aria-controls="primary-menu" aria-expanded="false">X</a>
					<!-- Begin MailChimp Signup Form -->
					<div class="mc_embed_signup">
						<form action="//systems.us12.list-manage.com/subscribe/post?u=be348cfa062148d17ebff31a7&amp;id=3a96094cda" method="post" class="mc-embedded-subscribe-form validate" name="mc-embedded-subscribe-form" target="_blank" novalidate>
							<div class="mc_embed_signup_scroll">
								<label for="mce-EMAIL">Newsletter</label>
								<input type="email" value="" name="EMAIL" class="email" class="mce-EMAIL" placeholder="write your email" required>
								<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_be348cfa062148d17ebff31a7_3a96094cda" tabindex="-1" value=""></div>
								<div class="clear"><input type="submit" value="Subscribe" name="subscribe" class="mc-embedded-subscribe button"></div>
							</div>
						</form>
					</div>
					<!--End mc_embed_signup-->
				</div>
			</nav><!-- #site-navigation -->

			<div id="site-search" class="main-search">
				<button class="search-toggle" aria-controls="primary-search" aria-expanded="false">Search</button>
				<div class="search-options">
					Search options
				</div>
			</div>
		</div>

		<?php if( is_home() || is_archive() ) : ?>
		<div class="category-menu">
			<a href="#" class="the-dot" style="color: <?php algores_active_category_background(); ?>"><span>Choose a category</span></a>
			<ul>
				<?php algores_category_dots(); ?>
			</ul>
		</div>
		<?php endif; ?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
