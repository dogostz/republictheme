<?php

# Custom hierarchical taxonomy (like categories)
/*
register_taxonomy(
	'property_rooms', # Taxonomy name
	array( 'property-base', 'property' ), # Post Types
	array( # Arguments
		'labels'            => array(
			'name'              => _x( 'Брой стай', 'Брой стай' ),
			'singular_name'     => _x( 'Брой стай', 'Брой стай' ),
			'search_items'      => __( 'Търсене' ),
			'all_items'         => __( 'Всички въведени' ),
			'parent_item'       => __( 'Родителска категория' ),
			'parent_item_colon' => __( 'Родителска категория:' ),
			'edit_item'         => __( 'Редактиране' ),
			'update_item'       => __( 'Обновяване' ),
			'add_new_item'      => __( 'Добавяне на нова' ),
			'new_item_name'     => __( 'Добавяне на нова' ),
			'menu_name'         => __( 'Брой стай' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'broi-stai' ),
	)
);

# Custom hierarchical taxonomy (like categories)
register_taxonomy(
	'property_place', # Taxonomy name
	array( 'property-base', 'property' ), # Post Types
	array( # Arguments
		'labels'            => array(
			'name'              => _x( 'Населено място', 'Населено място' ),
			'singular_name'     => _x( 'Населено място', 'Населено място' ),
			'search_items'      => __( 'Търсене' ),
			'all_items'         => __( 'Всички въведени' ),
			'parent_item'       => __( 'Родителска категория' ),
			'parent_item_colon' => __( 'Родителска категория:' ),
			'edit_item'         => __( 'Редактиране' ),
			'update_item'       => __( 'Обновяване' ),
			'add_new_item'      => __( 'Добавяне на нова' ),
			'new_item_name'     => __( 'Добавяне на нова' ),
			'menu_name'         => __( 'Населено място' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'naseleno-mqsto' ),
	)
);

*/