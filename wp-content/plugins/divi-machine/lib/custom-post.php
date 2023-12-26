<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// function create_dmachine_c_posts() {
//
//     register_post_type( 'dmach_post',
//         array(
//             'labels' => array(
//                 'name' => 'DMACH Custom Posts',
//                 'singular_name' => 'DMACH Custom Post',
//                 'add_new' => 'Add New',
//                 'add_new_item' => 'Add New DMACH Custom Post',
//                 'edit' => 'Edit',
//                 'edit_item' => 'Edit DMACH Custom Post',
//                 'new_item' => 'New DMACH Custom Post',
//                 'view' => 'View',
//                 'view_item' => 'View DMACH Custom Post',
//                 'search_items' => 'Search DMACH Custom Post',
//                 'not_found' => 'No DMACH Custom Post found',
//                 'not_found_in_trash' => 'No DMACH Custom Post found in Trash',
//                 'parent' => 'Parent DMACH Custom Post'
//             ),
//
//             'public' => false,
//             'query_var' => false,
//             'show_ui' => TRUE,
//             'exclude_from_search' => true,
//             'publicaly_queryable' => false,
//             'query_var' => false,
//             'supports' => array( 'title', 'custom-fields' ),
//             'has_archive' => false,
//             'show_in_menu' => 'divi-engine',
//             'menu_position' => 3,
//             'show_in_rest' => true,
//         )
//     );
//
//
// }
// add_action( 'init', 'create_dmachine_c_posts' );

// Register Custom Post Type
function create_dmachine_c_posts() {

	$labels_posttypes = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'divi-machine' ),
		'singular_name'         => _x( 'Post Type', 'Post Type Singular Name', 'divi-machine' ),
		'menu_name'             => __( 'Post Types', 'divi-machine' ),
		'name_admin_bar'        => __( 'Post Types', 'divi-machine' ),
		'archives'              => __( 'Post Types Archives', 'divi-machine' ),
		'attributes'            => __( 'Post Types Attributes', 'divi-machine' ),
		'parent_item_colon'     => __( 'Parent Item:', 'divi-machine' ),
		'all_items'             => __( 'Add/Edit Post Types', 'divi-machine' ),
		'add_new_item'          => __( 'Add New Post Type', 'divi-machine' ),
		'add_new'               => __( 'Add New', 'divi-machine' ),
		'new_item'              => __( 'New Post Type', 'divi-machine' ),
		'edit_item'             => __( 'Edit Post Type', 'divi-machine' ),
		'update_item'           => __( 'Update Post Type', 'divi-machine' ),
		'view_item'             => __( 'View Post Type', 'divi-machine' ),
		'view_items'            => __( 'View Post Types', 'divi-machine' ),
		'search_items'          => __( 'Search Post Types', 'divi-machine' ),
		'not_found'             => __( 'Not found', 'divi-machine' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'divi-machine' ),
		'featured_image'        => __( 'Featured Image', 'divi-machine' ),
		'set_featured_image'    => __( 'Set featured image', 'divi-machine' ),
		'remove_featured_image' => __( 'Remove featured image', 'divi-machine' ),
		'use_featured_image'    => __( 'Use as featured image', 'divi-machine' ),
		'insert_into_item'      => __( 'Insert into item', 'divi-machine' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'divi-machine' ),
		'items_list'            => __( 'Items list', 'divi-machine' ),
		'items_list_navigation' => __( 'Items list navigation', 'divi-machine' ),
		'filter_items_list'     => __( 'Filter items list', 'divi-machine' ),
	);
	$args_posttypes = array(
		'label'                 => __( 'Post Types', 'divi-machine' ),
		'description'           => __( 'Divi Machine Create Custom Posts', 'divi-machine' ),
		'labels'                => $labels_posttypes,
		'supports'              => array( 'title', 'custom-fields' ),
		'taxonomies'            => array(''),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
    'show_in_menu' => 'divi-engine',
		'menu_position'         => 5,
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
    'capabilities' => array(
        'publish_posts' => 'manage_options',
        'edit_posts' => 'manage_options',
        'edit_others_posts' => 'manage_options',
        'delete_posts' => 'manage_options',
        'delete_others_posts' => 'manage_options',
        'read_private_posts' => 'manage_options',
        'edit_post' => 'manage_options',
        'delete_post' => 'manage_options',
        'read_post' => 'manage_options',
    ),
	);

	$labels_tax = array(
		'name'                  => _x( 'Taxonomies', 'Taxonomy General Name', 'divi-machine' ),
		'singular_name'         => _x( 'Taxonomy', 'Taxonomy Singular Name', 'divi-machine' ),
		'menu_name'             => __( 'Taxonomies', 'divi-machine' ),
		'name_admin_bar'        => __( 'Taxonomies', 'divi-machine' ),
		'archives'              => __( 'Taxonomies Archives', 'divi-machine' ),
		'attributes'            => __( 'Taxonomies Attributes', 'divi-machine' ),
		'parent_item_colon'     => __( 'Parent Item:', 'divi-machine' ),
		'all_items'             => __( 'Add/Edit Taxonomies', 'divi-machine' ),
		'add_new_item'          => __( 'Add New Taxonomy', 'divi-machine' ),
		'add_new'               => __( 'Add New', 'divi-machine' ),
		'new_item'              => __( 'New Taxonomy', 'divi-machine' ),
		'edit_item'             => __( 'Edit Taxonomy', 'divi-machine' ),
		'update_item'           => __( 'Update Taxonomy', 'divi-machine' ),
		'view_item'             => __( 'View Taxonomy', 'divi-machine' ),
		'view_items'            => __( 'View Taxonomies', 'divi-machine' ),
		'search_items'          => __( 'Search Taxonomies', 'divi-machine' ),
		'not_found'             => __( 'Not found', 'divi-machine' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'divi-machine' ),
		'featured_image'        => __( 'Featured Image', 'divi-machine' ),
		'set_featured_image'    => __( 'Set featured image', 'divi-machine' ),
		'remove_featured_image' => __( 'Remove featured image', 'divi-machine' ),
		'use_featured_image'    => __( 'Use as featured image', 'divi-machine' ),
		'insert_into_item'      => __( 'Insert into item', 'divi-machine' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'divi-machine' ),
		'items_list'            => __( 'Items list', 'divi-machine' ),
		'items_list_navigation' => __( 'Items list navigation', 'divi-machine' ),
		'filter_items_list'     => __( 'Filter items list', 'divi-machine' ),
	);
	$args_tax = array(
		'label'                 => __( 'Taxonomies', 'divi-machine' ),
		'description'           => __( 'Divi Machine Create Custom Posts', 'divi-machine' ),
		'labels'                => $labels_tax,
		'supports'              => array( 'title', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
    'show_in_menu' => 'divi-engine',
		'menu_position'         => 5,
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
    'capabilities' => array(
        'publish_posts' => 'manage_options',
        'edit_posts' => 'manage_options',
        'edit_others_posts' => 'manage_options',
        'delete_posts' => 'manage_options',
        'delete_others_posts' => 'manage_options',
        'read_private_posts' => 'manage_options',
        'edit_post' => 'manage_options',
        'delete_post' => 'manage_options',
        'read_post' => 'manage_options',
    ),
	);


	register_post_type( 'dmach_post', $args_posttypes );
	register_post_type( 'dmach_tax', $args_tax );


}
add_action( 'init', 'create_dmachine_c_posts', 0 );

?>
