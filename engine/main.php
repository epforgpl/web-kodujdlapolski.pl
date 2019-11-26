<?php


function engine_register_post_type( $name, $slug, $supports, $exclude_from_search = false, $cap = array()) {

	$labels = array(
		'name' => ucfirst($name),
		'singular_name' => ucfirst($name),
		'add_new' => __('Dodaj nowe', 'engine'),
		'add_new_item' => __('Dodaj nowe', 'engine'),
		'edit_item' => __('Edytuj', 'engine'),
		'new_item' => __('Nowe', 'engine'),
		'view_item' => __('Zobacz', 'engine'),
		'search_items' => __('Szukaj', 'engine'),
		'not_found' =>  __('Brak','engine'),
		'not_found_in_trash' => __('Brak','engine'), 
		'parent_item_colon' => ''
	);
	  
	$args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => $exclude_from_search,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'capability_type' => 'post2',
				'capabilities' => array(
				'publish_posts' => 'publish_post2s',
				'edit_posts' => 'edit_post2s',
				'edit_others_posts' => 'edit_others_post2s',
				'delete_posts' => 'delete_post2s',
				'delete_others_posts' => 'delete_others_post2s',
				'read_private_posts' => 'read_private_post2s',
				'edit_post' => 'edit_post2',
				'delete_post' => 'delete_post2',
				'read_post' => 'read_post2',
			),
		'hierarchical' => false,
		'menu_position' => null,
		'rewrite' => array('slug' => $slug),
		'supports' => $supports,
		'taxonomies' => array('groups', 'post_tag') 
	); 
	register_post_type( strtolower($slug), $args );
}



function engine_register_taxonomy($name, $slug, $posttype, $hierarchical = true) {

	if (!is_array($posttype)) $posttype = array($posttype);
	
	register_taxonomy(
		$slug, 
		$posttype, 
		array(
			"hierarchical" => $hierarchical,
		 	"label" => $name, 
		 	"singular_label" => ucfirst($name), 
		 	"rewrite" => 
			 	array(
			 		'slug' => strtolower($slug), 
			 		'hierarchical' => true
			 	)
		)
	); 
}


function engine_register_project_type( $name, $slug, $supports, $exclude_from_search = false) {

	$labels = array(
		'name' => ucfirst($name),
		'singular_name' => ucfirst($name),
		'add_new' => __('Dodaj nowe', 'engine'),
		'add_new_item' => __('Dodaj nowe', 'engine'),
		'edit_item' => __('Edytuj', 'engine'),
		'new_item' => __('Nowe', 'engine'),
		'view_item' => __('Zobacz', 'engine'),
		'search_items' => __('Szukaj', 'engine'),
		'not_found' =>  __('Brak','engine'),
		'not_found_in_trash' => __('Brak','engine'), 
		'parent_item_colon' => ''
	);

	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => $exclude_from_search,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'capability_type' => 'project',
			'capabilities' => array(
				'publish_posts' => 'publish_projects',
				'edit_posts' => 'edit_projects',
				'edit_others_posts' => 'edit_others_projects',
				'delete_posts' => 'delete_projects',
				'delete_others_posts' => 'delete_others_projects',
				'read_private_posts' => 'read_private_projects',
				'edit_post' => 'edit_project',
				'delete_post' => 'delete_project',
				'read_post' => 'read_project',
			),
		'hierarchical' => false,
		'menu_position' => null,
		'rewrite' => array('slug' => $slug),
		'supports' => $supports,
		'taxonomies' => array('groups', 'post_tag') 
	); 
	register_post_type( strtolower($slug), $args );
}

function engine_register_partners_type( $name, $slug, $supports, $exclude_from_search = false) {

	$labels = array(
		'name' => ucfirst($name),
		'singular_name' => ucfirst($name),
		'add_new' => __('Dodaj nowe', 'engine'),
		'add_new_item' => __('Dodaj nowe', 'engine'),
		'edit_item' => __('Edytuj', 'engine'),
		'new_item' => __('Nowe', 'engine'),
		'view_item' => __('Zobacz', 'engine'),
		'search_items' => __('Szukaj', 'engine'),
		'not_found' =>  __('Brak','engine'),
		'not_found_in_trash' => __('Brak','engine'), 
		'parent_item_colon' => ''
	);
	  
	$args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => $exclude_from_search,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'capability_type' => 'partner',
			'capabilities' => array(
				'publish_posts' => 'publish_partners',
				'edit_posts' => 'edit_partners',
				'edit_others_posts' => 'edit_others_partners',
				'delete_posts' => 'delete_partners',
				'delete_others_posts' => 'delete_others_partners',
				'read_private_posts' => 'read_private_partners',
				'edit_post' => 'edit_partner',
				'delete_post' => 'delete_partner',
				'read_post' => 'read_partner',
			),
		'hierarchical' => false,
		'menu_position' => null,
		'rewrite' => array('slug' => $slug),
		'supports' => $supports,
		'taxonomies' => array('groups', 'post_tag') 
	); 
	register_post_type( strtolower($slug), $args );
}