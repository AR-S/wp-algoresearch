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

	<header id="masthead" class="site-header headroom" role="banner">

		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="site-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 viewBox="28 -29 82 82" xml:space="preserve">
					<g>
						<circle cx="69" cy="12" r="40" class="st1"/>
						<g>
							<path class="st0" d="M50.8,15.5h-6L43.3,20H41l5.7-15.9H49L54.8,20h-2.3L50.8,15.5z M47.9,6.3c0,0-0.4,1.4-0.6,2.2l-1.8,5h4.8
								l-1.8-5C48.2,7.8,47.9,6.3,47.9,6.3L47.9,6.3z"/>
							<path class="st0" d="M62.5,4.2h4.9c1.7,0,2.4,0.1,3,0.4C71.9,5.1,73,6.7,73,8.8c0,2-1.1,3.7-2.9,4.3v0c0,0,0.2,0.2,0.5,0.7
								l3.4,6.2h-2.5l-3.3-6.3h-3.4V20h-2.2V4.2z M67.9,11.8c1.7,0,2.8-1.1,2.8-2.9c0-1.2-0.4-2-1.3-2.4c-0.4-0.2-0.9-0.4-2.2-0.4h-2.6
								v5.7H67.9z"/>
							<path class="st0" d="M78.7,17.7H81V20h-2.3V17.7z"/>
							<path class="st0" d="M87.1,16.5c0,0,1.7,1.7,4,1.7c1.5,0,2.7-0.8,2.7-2.3c0-3.4-7.7-2.7-7.7-7.6c0-2.5,2.1-4.4,5.1-4.4
								c2.9,0,4.5,1.6,4.5,1.6l-1,1.8c0,0-1.5-1.4-3.5-1.4c-1.7,0-2.9,1.1-2.9,2.3c0,3.3,7.7,2.4,7.7,7.5c0,2.4-1.9,4.5-5,4.5
								c-3.4,0-5.3-2.1-5.3-2.1L87.1,16.5z"/>
						</g>
					</g>
				</svg>
			</a>
		</div>

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
