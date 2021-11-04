<?php 

// Devices ----------------------------------------
// ------------------------------------------------
add_action( 'init', 'wp_retrogaming_device_create_post_type' );
function wp_retrogaming_device_create_post_type() {
	$labels = array(
		'name'               => __( 'Devices', 'wp-retrogaming' ),
		'singular_name'      => __( 'Socio', 'wp-retrogaming' ),
		'add_new'            => __( 'Add new', 'wp-retrogaming' ),
		'add_new_item'       => __( 'Add new device', 'wp-retrogaming' ),
		'edit_item'          => __( 'Edit device', 'wp-retrogaming' ),
		'new_item'           => __( 'New device', 'wp-retrogaming' ),
		'all_items'          => __( 'All devices', 'wp-retrogaming' ),
		'view_item'          => __( 'View device', 'wp-retrogaming' ),
		'search_items'       => __( 'Search device', 'wp-retrogaming' ),
		'not_found'          => __( 'Device not found', 'wp-retrogaming' ),
		'not_found_in_trash' => __( 'Device not found in trash bin', 'wp-retrogaming' ),
		'menu_name'          => __( 'Devices', 'wp-retrogaming' ),
	);
	$args = array(
		'labels'        => $labels,
		'description'   => __( 'Add new device', 'wp-retrogaming' ),
		'public'        => true,
		'menu_position' => 7,
		'query_var' 	  => true,
		'supports'      => array( 'title', 'editor', 'thumbnail'/*, 'page-attributes'*/ ),
		'rewrite'	      => array( 'slug' => 'device', 'with_front' => false),
		'query_var'	    => true,
		'has_archive' 	=> false,
		'hierarchical'	=> true,
	);
	register_post_type( 'device', $args );
}

//Platform -------------------------
add_action( 'init', 'wp_retrogaming_device_platform_create_type' );
function wp_retrogaming_device_platform_create_type() {
	$labels = array(
		'name'              => __( 'Platforms', 'wp-retrogaming' ),
		'singular_name'     => __( 'Platform', 'wp-retrogaming' ),
		'search_items'      => __( 'Search platform', 'wp-retrogaming' ),
		'all_items'         => __( 'All platforms', 'wp-retrogaming' ),
		'parent_item'       => __( 'Parent platform', 'wp-retrogaming' ),
		'parent_item_colon' => __( 'Parent platform', 'wp-retrogaming' ).":",
		'edit_item'         => __( 'Edit platform', 'wp-retrogaming' ),
		'update_item'       => __( 'Update platform', 'wp-retrogaming' ),
		'add_new_item'      => __( 'Add platform', 'wp-retrogaming' ),
		'new_item_name'     => __( 'New platform', 'wp-retrogaming' ),
		'menu_name'         => __( 'Platforms', 'wp-retrogaming' ),
	);
	$args = array(
		'labels' 		        => $labels,
		'hierarchical' 	    => true,
		'public'		        => true,
		'query_var'		      => true,
		'show_in_nav_menus' => true,
		'has_archive'       => true,
    'rewrite'           =>  array( 'slug' => 'platform', 'with_front' => false),
    'publicly_queryable' => true
	);
  register_taxonomy( 'platform', array('device'/*, 'accessory'*/), $args );
}

//Brand -------------------------
add_action( 'init', 'wp_retrogaming_device_brand_create_type' );
function wp_retrogaming_device_brand_create_type() {
	$labels = array(
		'name'              => __( 'Brands', 'wp-retrogaming' ),
		'singular_name'     => __( 'Brand', 'wp-retrogaming' ),
		'search_items'      => __( 'Search brand', 'wp-retrogaming' ),
		'all_items'         => __( 'All brands', 'wp-retrogaming' ),
		'parent_item'       => __( 'Parent brand', 'wp-retrogaming' ),
		'parent_item_colon' => __( 'Parent brand', 'wp-retrogaming' ).":",
		'edit_item'         => __( 'Edit brand', 'wp-retrogaming' ),
		'update_item'       => __( 'Update brand', 'wp-retrogaming' ),
		'add_new_item'      => __( 'Add brand', 'wp-retrogaming' ),
		'new_item_name'     => __( 'New brand', 'wp-retrogaming' ),
		'menu_name'         => __( 'Brands', 'wp-retrogaming' ),
	);
	$args = array(
		'labels' 		        => $labels,
		'hierarchical' 	    => true,
		'public'		        => true,
		'query_var'		      => true,
		'show_in_nav_menus' => true,
		'has_archive'       => true,
    'rewrite'           =>  array( 'slug' => 'brand', 'with_front' => false),
    'publicly_queryable' => true
	);
	register_taxonomy( 'brand', array('device', 'accessory'), $args );
}

//CAMPOS personalizados ---------------------------
// ------------------------------------------------
function get_wp_retrogaming_device_custom_fields () {
	$fields = array(
    'model' => array ('titulo' => __( 'Model', 'wp-retrogaming' ), 'tipo' => 'text'),
		'serial_number' => array ('titulo' => __( 'Serial Number', 'wp-retrogaming' ), 'tipo' => 'text'),
    'model_number' => array ('titulo' => __( 'Model Number', 'wp-retrogaming' ), 'tipo' => 'text'),
    'packaging' => array ('titulo' => __( 'Packaging', 'wp-retrogaming' ), 'tipo' => 'checkbox', "valores" => array(
			"box" =>  __('Box', 'wp-retrogaming'), 
			"insert" => __('Insert', 'wp-retrogaming'), 
			"manual" => __('Manual', 'wp-retrogaming'), 
			"warranty" => __('Warranty', 'wp-retrogaming')
		)),
    'video_system' => array ('titulo' => __( 'Video System', 'wp-retrogaming' ), 'tipo' => 'checkbox', "valores" => array(
			"ntsc" =>  __('NTSC', 'wp-retrogaming'), 
			"pal" => __('PAL', 'wp-retrogaming')
		)),
    'mods' => array ('titulo' => __( "Modifications", 'wp-retrogaming' ), 'tipo' => 'repeater', "fields" => array (
      'title' => array ('titulo' => __( "Description", 'wp-retrogaming' ), 'tipo' => 'text'),
      'date' => array ('titulo' => __( "Date", 'wp-retrogaming' ), 'tipo' => 'text')
    ))
	);

	return $fields;
}

function wp_retrogaming_device_add_custom_fields() {
  add_meta_box(
    'box_devices', // $id
    __('Device data', 'wp-retrogaming'), // $title 
    'wp_retrogaming_show_custom_fields', // $callback
    'device', // $page
    'normal', // $context
    'high'); // $priority
}
add_action('add_meta_boxes', 'wp_retrogaming_device_add_custom_fields');
add_action('save_post', 'wp_retrogaming_save_custom_fields' );