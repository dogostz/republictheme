<?php  

/*
	Slider Post Type
*/
register_post_type('slide', array(
	'labels' => array(
		'name'               => __('Слайдове'),
		'singular_name'      => __('Слайд'),
		'add_new'            => __('Добави нов слайд'),
		'add_new_item'       => __('Добави нов слайд'),
		'view_item'          => __('Виж слайд'),
		'edit_item'          => __('Редактирай слайд'),
		'new_item'           => __('Нов слайд'),
		'view_item'          => __('Виж слайд'),
		'search_items'       => __('Търси в слайдове'),
		'not_found'          => __('Няма намерени слайдове'),
		'not_found_in_trash' => __('Няма намерени слайдове в кошчето'),
	),
	'public'        => false,
	'exclude_from_search' => true,
	'show_ui'       => true,
	'hierarchical'  => false,
	'query_var' 	=> true,
	'_edit_link' 	=>  'post.php?post=%d',
	'rewrite' 		=> false,
	'supports'      => array('title', 'page-attributes'),
	'menu_position' => 101,
	'menu_icon'     => get_stylesheet_directory_uri() . '/images/icons/icon-slides.png'
));


/*
	Brokers Post Type
*/
register_post_type('broker', array(
	'labels' => array(
		'name'               => __('Брокери'),
		'singular_name'      => __('Брокер'),
		'add_new'            => __('Добави нов брокер'),
		'add_new_item'       => __('Добави нов брокер'),
		'view_item'          => __('Виж брокер'),
		'edit_item'          => __('Редактирай брокер'),
		'new_item'           => __('Нов брокер'),
		'view_item'          => __('Виж брокер'),
		'search_items'       => __('Търси в брокери'),
		'not_found'          => __('Няма намерени брокери'),
		'not_found_in_trash' => __('Няма намерени брокери в кошчето'),
	),
	'public'        => false,
	'exclude_from_search' => true,
	'show_ui'       => true,
	'hierarchical'  => false,
	'query_var' 	=> true,
	'_edit_link' 	=>  'post.php?post=%d',
	'rewrite' 		=> false,
	'supports'      => array('title', 'editor', 'page-attributes'),
	'menu_position' => 101,
	'menu_icon'     => get_stylesheet_directory_uri() . '/images/icons/icon-broker.png'
));


/*
	Database Post Type
*/
register_post_type('property-base', array(
	'labels' => array(
		'name'               => __('База данни'),
		'singular_name'      => __('Имот'),
		'add_new'            => __('Добави нов имот'),
		'add_new_item'       => __('Добави нов имот'),
		'view_item'          => __('Виж имот'),
		'edit_item'          => __('Редактирай имот'),
		'new_item'           => __('Нов имот'),
		'view_item'          => __('Виж имот'),
		'search_items'       => __('Търси в имоти'),
		'not_found'          => __('Няма намерени имоти'),
		'not_found_in_trash' => __('Няма намерени имоти в кошчето'),
	),
	'public'        => true,
	'exclude_from_search' => true,
	'show_ui'       => true,
	'hierarchical'  => false,
	'query_var' 	=> true,
	'_edit_link' 	=>  'post.php?post=%d',
	'rewrite' 		=> array(
		'slug' => 'bazov-imot'
	),
	'supports'      => array('title', 'editor', 'page-attributes', 'revisions'),
	'menu_position' => 101,
	'menu_icon'     => get_stylesheet_directory_uri() . '/images/icons/icon-property.png'
));


/*
	Database (rentals) Post Type
*/
register_post_type('property-rental-base', array(
    'labels' => array(
        'name'               => __('База данни - Наеми'),
        'singular_name'      => __('Имот'),
        'add_new'            => __('Добави нов имот'),
        'add_new_item'       => __('Добави нов имот'),
        'view_item'          => __('Виж имот'),
        'edit_item'          => __('Редактирай имот'),
        'new_item'           => __('Нов имот'),
        'view_item'          => __('Виж имот'),
        'search_items'       => __('Търси в имоти'),
        'not_found'          => __('Няма намерени имоти'),
        'not_found_in_trash' => __('Няма намерени имоти в кошчето'),
    ),
    'public'        => true,
    'exclude_from_search' => true,
    'show_ui'       => true,
    'hierarchical'  => false,
    'query_var' 	=> true,
    '_edit_link' 	=>  'post.php?post=%d',
    'rewrite' 		=> array(
        'slug' => 'bazov-imot-naemi'
    ),
    'supports'      => array('title', 'editor', 'page-attributes', 'revisions'),
    'menu_position' => 101,
    'menu_icon'     => get_stylesheet_directory_uri() . '/images/icons/icon-rent-base.png'
));


/*
	Properties Post Type
*/
register_post_type('property', array(
	'labels' => array(
		'name'               => __('Продажби'),
		'singular_name'      => __('Имот'),
		'add_new'            => __('Добави нов имот'),
		'add_new_item'       => __('Добави нов имот'),
		'view_item'          => __('Виж имот'),
		'edit_item'          => __('Редактирай имот'),
		'new_item'           => __('Нов имот'),
		'view_item'          => __('Виж имот'),
		'search_items'       => __('Търси в имоти'),
		'not_found'          => __('Няма намерени имоти'),
		'not_found_in_trash' => __('Няма намерени имоти в кошчето'),
	),
	'public'        => true,
	'exclude_from_search' => false,
	'show_ui'       => true,
	'hierarchical'  => false,
	'query_var' 	=> true,
	'_edit_link' 	=>  'post.php?post=%d',
	'rewrite' 		=> array(
		'slug' => 'imot'
	),
	'supports'      => array('title', 'editor', 'page-attributes', 'revisions'),
	'menu_position' => 101,
	'menu_icon'     => get_stylesheet_directory_uri() . '/images/icons/icon-property-base.png'
));

/*
	Rental Properties Post Type
*/
register_post_type('property-rental', array(
	'labels' => array(
		'name'               => __('Наеми'),
		'singular_name'      => __('Имот'),
		'add_new'            => __('Добави нов имот'),
		'add_new_item'       => __('Добави нов имот'),
		'view_item'          => __('Виж имот'),
		'edit_item'          => __('Редактирай имот'),
		'new_item'           => __('Нов имот'),
		'view_item'          => __('Виж имот'),
		'search_items'       => __('Търси в имоти'),
		'not_found'          => __('Няма намерени имоти'),
		'not_found_in_trash' => __('Няма намерени имоти в кошчето'),
	),
	'public'        => true,
	'exclude_from_search' => false,
	'show_ui'       => true,
	'hierarchical'  => false,
	'query_var' 	=> true,
	'_edit_link' 	=>  'post.php?post=%d',
	'rewrite' 		=> array(
		'slug' => 'naemi'
	),
	'supports'      => array('title', 'editor', 'page-attributes', 'revisions'),
	'menu_position' => 101,
	'menu_icon'     => get_stylesheet_directory_uri() . '/images/icons/icon-rent.png'
));