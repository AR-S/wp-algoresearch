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
			<?php get_template_part('nav-main'); ?>

			<div id="site-search" class="main-search<?php if( is_search() ){ echo ' active'; } ?>">
				<button class="search-toggle" aria-controls="primary-search" aria-expanded="false">Search</button>
				<form class="search-options" method="GET" action="/">
					<input type="search" name="s" value="<?php echo get_search_query(); ?>" />
				</form>
			</div>
		</div>

		<?php if( ! is_page() ) : ?>
		<div class="category-menu">
			<a href="#" class="the-dot" style="color: <?php algores_active_category_background(); ?>"><span>Choose a category</span></a>
			<ul>
				<?php algores_category_dots(); ?>
			</ul>
		</div>
		<?php endif; ?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
