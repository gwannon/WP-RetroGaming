<?php 

// Accessories ----------------------------------------
// ------------------------------------------------
add_action( 'init', 'wp_retrogaming_accessory_create_post_type' );
function wp_retrogaming_accessory_create_post_type() {
	$labels = array(
		'name'               => __( 'Accessories', 'wp-retrogaming' ),
		'singular_name'      => __( 'Socio', 'wp-retrogaming' ),
		'add_new'            => __( 'Add new', 'wp-retrogaming' ),
		'add_new_item'       => __( 'Add new accessory', 'wp-retrogaming' ),
		'edit_item'          => __( 'Edit accessory', 'wp-retrogaming' ),
		'new_item'           => __( 'New accessory', 'wp-retrogaming' ),
		'all_items'          => __( 'All accessories', 'wp-retrogaming' ),
		'view_item'          => __( 'View accessory', 'wp-retrogaming' ),
		'search_items'       => __( 'Search accessory', 'wp-retrogaming' ),
		'not_found'          => __( 'Accessory not found', 'wp-retrogaming' ),
		'not_found_in_trash' => __( 'Accessory not found in trash bin', 'wp-retrogaming' ),
		'menu_name'          => __( 'Accessories', 'wp-retrogaming' ),
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __( 'Add new accessory', 'wp-retrogaming' ),
		'public'        => true,
		'menu_position' => 8,
		'query_var' 	  => true,
		'supports'      => array( 'title', 'editor', 'thumbnail'/*, 'page-attributes'*/ ),
		'rewrite'	      => array('slug' => 'accessory', 'with_front' => false),
		'query_var'	    => true,
		'has_archive' 	=> false,
		'hierarchical'	=> true,
	);
	register_post_type( 'accessory', $args );
}

//CAMPOS personalizados ---------------------------
// ------------------------------------------------
function get_wp_retrogaming_accessory_custom_fields () {
	$fields = array(
    'model' => array ('titulo' => __( 'Model', 'wp-retrogaming' ), 'tipo' => 'text'),
		'serial_number' => array ('titulo' => __( 'Serial Number', 'wp-retrogaming' ), 'tipo' => 'text'),
	);
	return $fields;
}

function wp_retrogaming_accessory_add_custom_fields() {
  add_meta_box(
    'box_accessories', // $id
    __('Accessory data', 'wp-retrogaming'), // $title 
    'wp_retrogaming_show_custom_fields', // $callback
    'accessory', // $page
    'normal', // $context
    'high'); // $priority
}
add_action('add_meta_boxes', 'wp_retrogaming_accessory_add_custom_fields');
add_action('save_post', 'wp_retrogaming_save_custom_fields' );