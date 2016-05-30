<?php

function algores_custom_types()
{
	register_post_type('note', array(
		'public' => true,
		'labels' => array(
			'name'               => 'Notes',
			'singular_name'      => 'Note',
			'menu_name'          => 'Notes',
			'name_admin_bar'     => 'Note',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Note',
			'new_item'           => 'New Note',
			'edit_item'          => 'Edit Note',
			'view_item'          => 'View Note',
			'all_items'          => 'All Notes',
			'search_items'       => 'Search Notes',
			'parent_item_colon'  => 'Parent Notes:',
			'not_found'          => 'No notes found.',
			'not_found_in_trash' => 'No notes found in Trash.'
		),
		'has_archive' => true,
		'rewrite' => array('slug' => 'notes'),
		'menu_position' => 5,
		'menu_icon' => 'dashicons-format-aside',
		'taxonomies' => array(
			'category',
			'post_tag'
		),
		'supports' => array(
			'title',
			'editor',
			'thumbnail'
		)
	));

	add_action( 'admin_menu', function ()
	{
		global $menu;
		$menu[5][0] = 'Research';
	});

	add_image_size('ars_small_1',  300, 200, true);
	add_image_size('ars_small_2',  384, 260, true);
	add_image_size('ars_medium',   460, 280, true);
	add_image_size('ars_big_1',    540, 300, true);
	add_image_size('ars_big_2',    626, 408, true);
	add_image_size('ars_carousel', 940, 450, true);

	add_action( 'fm_post_note', function()
	{
		$fm = new Fieldmanager_Group( array(
			'name' => 'note_data',
			'children' => array(
				'link' => new Fieldmanager_Textfield( 'Link:' ),
				'size' => new Fieldmanager_Radios( 'Size:', array(
					'options' => array(
						'ars_small_1' => 'Small 1 (300x200)',
						'ars_small_2' => 'Small 2 (384x260)',
						'ars_medium' => 'Medium (460x280)',
						'ars_big_1' => 'Big 1 (540x300)',
						'ars_big_2' => 'Big 2 (626x408)'
					)
				))
			)
		));

		$fm->add_meta_box( 'Settings', 'note' );
	});
}
add_action('init', 'algores_custom_types');

function algores_setup()
{
	$GLOBALS['content_width'] = apply_filters( 'algores_content_width', 640 );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form', 'gallery', 'caption'
	) );

	register_nav_menus( array(
		'primary' => 'Primary',
		'footer' => 'Footer'
	) );
}
add_action( 'after_setup_theme', 'algores_setup' );


function algores_scripts()
{
	$cssdate = '20160407';

	wp_enqueue_style( 'algores-style', get_template_directory_uri() . '/style.css', array(), $cssdate );
	wp_enqueue_script( 'algores-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'imagesLoaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), '20160131', true );
	wp_enqueue_script( 'owlcarousel2', get_template_directory_uri() . '/js/owlcarousel2/owl.carousel.min.js', array('imagesLoaded'), '20160131', true );
	wp_enqueue_script( 'packery', get_template_directory_uri() . '/js/packery.pkgd.min.js', array('owlcarousel2'), '2.0.0', true );
	wp_enqueue_script( 'packery', 'https://www.google.com/recaptcha/api.js?ver=1.3.3.1', array('packery'), '', true );
	wp_enqueue_script( 'algores-main', get_template_directory_uri() . '/js/main.js', array('packery'), $cssdate, true );
}
add_action( 'wp_enqueue_scripts', 'algores_scripts' );


function load_custom_wp_admin_style()
{
	wp_register_style( 'algores_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'algores_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/admin.php';


