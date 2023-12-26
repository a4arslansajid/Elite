<?php

// TODO: Make sure you add option for "pretty URLS" and remove Cars etc

if ( ! defined( 'ABSPATH' ) ) exit;


function divi_machine_titan_add_post_options() {
  /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-machine' );*/
  add_action( 'init', 'create_dmachine_create_posts');
  
  function create_dmachine_create_posts() {

      /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-machine' );*/
      $ids = array();
      $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );

        $dmach_posts = get_posts( $args );
        foreach ($dmach_posts as $dmach_post) {
          $ids[] = $dmach_post->ID;
        }

        foreach (array_unique($ids) as $key => $value) {

          $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true);//$titan->getOption( 'dmach_post_type_key', $value  ); // DONE

          if ($dmach_post_type_key == "post_type") {
            function custom_post_notice() {
              echo '<div class="error"><p><strong>' . sprintf(esc_html__('Please make sure you choose a unique slug name and not "post_type" for your CPT', 'divi-machine')) . '</strong></p></div>';
            }
            add_action('admin_notices', 'custom_post_notice');
          } else {
            $dmach_description          = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true);//$titan->getOption( 'dmach_description', $value  ); // DONE
            $dmach_name_singular        = get_post_meta( $value, 'divi-machine_dmach_name_singular', true);//$titan->getOption( 'dmach_name_singular', $value  ); // DONE
            $dmach_name_plural          = get_post_meta( $value, 'divi-machine_dmach_name_plural', true);//$titan->getOption( 'dmach_name_plural', $value  ); // DONE
            $dmach_taxonomies           = maybe_unserialize( get_post_meta( $value, 'divi-machine_dmach_taxonomies', true) );//$titan->getOption( 'dmach_taxonomies', $value  ); // DONE
            $dmach_hierarchical_get     = get_post_meta( $value, 'divi-machine_dmach_hierarchical', true);//$titan->getOption( 'dmach_hierarchical', $value  ); // DONE
            $dmach_menu_name            = get_post_meta( $value, 'divi-machine_dmach_menu_name', true);//$titan->getOption( 'dmach_menu_name', $value  ); // DONE
            $dmach_all_items            = get_post_meta( $value, 'divi-machine_dmach_all_items', true);//$titan->getOption( 'dmach_all_items', $value  ); // DONE
            $dmach_admin_bar_name       = get_post_meta( $value, 'divi-machine_dmach_admin_bar_name', true);//$titan->getOption( 'dmach_admin_bar_name', $value  ); // DONE
            $dmach_add_new_item         = get_post_meta( $value, 'divi-machine_dmach_add_new_item', true);//$titan->getOption( 'dmach_add_new_item', $value  ); // DONE
            $dmach_new_item             = get_post_meta( $value, 'divi-machine_dmach_new_item', true);//$titan->getOption( 'dmach_new_item', $value  ); // DONE
            $dmach_add_new              = get_post_meta( $value, 'divi-machine_dmach_add_new', true);//$titan->getOption( 'dmach_add_new', $value  ); // DONE
            $dmach_edit_item            = get_post_meta( $value, 'divi-machine_dmach_edit_item', true);//$titan->getOption( 'dmach_edit_item', $value  ); // DONE
            $dmach_update_item          = get_post_meta( $value, 'divi-machine_dmach_update_item', true);//$titan->getOption( 'dmach_update_item', $value  ); // DONE
            $dmach_view_item            = get_post_meta( $value, 'divi-machine_dmach_view_item', true);//$titan->getOption( 'dmach_view_item', $value  ); // DONE
            $dmach_view_items           = get_post_meta( $value, 'divi-machine_dmach_view_items', true) ?: $dmach_view_item . 's';//$titan->getOption( 'dmach_view_item', $value  ); // DONE
            $dmach_search_item          = get_post_meta( $value, 'divi-machine_dmach_search_item', true);//$titan->getOption( 'dmach_search_item', $value  ); // DONE
            $dmach_supports             = maybe_unserialize(get_post_meta( $value, 'divi-machine_dmach_supports', true));//$titan->getOption( 'dmach_supports', $value  ); // DONE
            $dmach_exclude_from_search_get = get_post_meta( $value, 'divi-machine_dmach_exclude_from_search', true);//$titan->getOption( 'dmach_exclude_from_search', $value  ); // DONE
            $dmach_enable_archives      = get_post_meta( $value, 'divi-machine_dmach_enable_archives', true);//$titan->getOption( 'dmach_enable_archives', $value  );// DONE
            $dmach_custom_archive_slug  = get_post_meta( $value, 'divi-machine_dmach_custom_archive_slug', true);//$titan->getOption( 'dmach_custom_archive_slug', $value  );// DONE
            $dmach_custom_post_slug     = get_post_meta( $value, 'divi-machine_dmach_custom_post_slug', true);//$titan->getOption( 'dmach_custom_post_slug', $value ); // DONE
            $dmach_rewrite              = get_post_meta( $value, 'divi-machine_dmach_rewrite', true);//$titan->getOption( 'dmach_rewrite', $value  );
            // $dmach_rewrite_custom_slug = $titan->getOption( 'dmach_rewrite_custom_slug', $value  );
            $dmach_rewrite_withfront    = get_post_meta( $value, 'divi-machine_dmach_rewrite_withfront', true);//$titan->getOption( 'dmach_rewrite_withfront', $value  );

            //$dmach_rewrite_withfront = filter_var($dmach_rewrite_withfront, FILTER_VALIDATE_BOOLEAN);
            //$dmach_rewrite = filter_var($dmach_rewrite, FILTER_VALIDATE_BOOLEAN);
    
            if ($dmach_enable_archives == "true" || $dmach_enable_archives == "1") {
              $dmach_enable_archives_dis = $dmach_post_type_key;
            } else if ($dmach_enable_archives == "true_custom") {
              $dmach_enable_archives_dis = $dmach_custom_archive_slug;
            } else {
              $dmach_enable_archives_dis = false;//$dmach_post_type_key;
            }

            if ( empty( $dmach_supports ) ) {
              $dmach_supports = array();
            }

            if ( empty( $dmach_taxonomies ) ) {
              $dmach_taxonomies = array();
            }

            $dmach_rewrite_custom_slug = $dmach_post_type_key;
            $dmach_public_get = get_post_meta( $value, 'divi-machine_dmach_public', true); // $titan->getOption( 'dmach_public', $value  ); // DONE
            $dmach_public_queryable = get_post_meta( $value, 'divi-machine_dmach_public_queryable', true); // $titan->getOption( 'dmach_public_queryable', $value  ); // DONE
            $dmach_show_in_admin_sidebar_get = get_post_meta( $value, 'divi-machine_dmach_show_in_admin_sidebar', true); // $titan->getOption( 'dmach_show_in_admin_sidebar', $value  ); // DONE
            $dmach_show_admin_sidebar_postion_raw = get_post_meta( $value, 'divi-machine_dmach_show_admin_sidebar_postion', true); // $titan->getOption( 'dmach_show_admin_sidebar_postion', $value  ); // DONE
            $dmach_show_admin_sidebar_postion = (int)$dmach_show_admin_sidebar_postion_raw;
            $dmach_show_admin_sidebar_icon = get_post_meta( $value, 'divi-machine_dmach_show_admin_sidebar_icon', true); // $titan->getOption( 'dmach_show_admin_sidebar_icon', $value  ); // DONE
            $dmach_show_in_admin_bar_get = get_post_meta( $value, 'divi-machine_dmach_show_in_admin_bar', true); // $titan->getOption( 'dmach_show_in_admin_bar', $value  ); // DONE
            $dmach_show_in_nav_menus_get = get_post_meta( $value, 'divi-machine_dmach_show_in_nav_menus', true); // $titan->getOption( 'dmach_show_in_nav_menus', $value  ); // DONE

            // $dmach_query = $titan->getOption( 'dmach_query', $value  );
            // $dmach_custom_query = $titan->getOption( 'dmach_custom_query', $value  );
            // $dmach_public_query = $titan->getOption( 'dmach_public_query', $value  );
            // $dmach_permalinks_rewrite = $titan->getOption( 'dmach_permalinks_rewrite', $value  );
            // $dmach_capability_type = $titan->getOption( 'dmach_capability_type', $value  );
            $dmach_prettify_post = get_post_meta( $value, 'divi-machine_dmach_prettify_post', true); // $titan->getOption( 'dmach_prettify_post', $value  );
            // $dmach_prettify_name_cat = $titan->getOption( 'dmach_prettify_name_cat', $value  );
            // $dmach_prettify_name_tag = $titan->getOption( 'dmach_prettify_name_tag', $value  );

                        
            $dmach_gutenberg_get = get_post_meta( $value, 'divi-machine_dmach_gutenberg', true); // $titan->getOption( 'dmach_gutenberg', $value  );

           if ( $dmach_exclude_from_search_get == "0" || $dmach_exclude_from_search_get == "false" ) {
             $dmach_exclude_from_search = false;
           } else {
            $dmach_exclude_from_search = true;
           }

           if ($dmach_gutenberg_get === "0" || $dmach_gutenberg_get === "false" ) {
            $dmach_gutenberg = false;
          } else {
           $dmach_gutenberg = true;
          }

          if ($dmach_hierarchical_get === "0" || $dmach_hierarchical_get === "false" ) {
           $dmach_hierarchical = false;
         } else {
          $dmach_hierarchical = true;
         }

          if ( $dmach_rewrite === "0" || $dmach_rewrite === "false" ) {
            $dmach_rewrite = false;
          } else {
            $dmach_rewrite = true;
          }

          if ( $dmach_rewrite_withfront === "0" || $dmach_rewrite_withfront === "false" ) {
            $dmach_rewrite_withfront = false;
          } else {
            $dmach_rewrite_withfront = true;
          }

         

         if ($dmach_public_get === "0" || $dmach_public_get === "false") {
            $dmach_public = false;
          } else {
            $dmach_public = true;
          }

          if ( $dmach_public_queryable === "0" || $dmach_public_queryable === "false") {
            $dmach_public_queryable = false;
          } else {            
            $dmach_public_queryable = true;
          }
        

        if ($dmach_show_in_admin_sidebar_get === "0" || $dmach_show_in_admin_sidebar_get === "false" ) {
          $dmach_show_in_admin_sidebar = false; 
        } else {         
         $dmach_show_in_admin_sidebar = true;
        }
        

        if ($dmach_show_in_admin_bar_get === "0" || $dmach_show_in_admin_bar_get === "false" ) {
         $dmach_show_in_admin_bar = false; 
        } else {         
         $dmach_show_in_admin_bar = true;
        }
        

        if ($dmach_show_in_nav_menus_get === "0" || $dmach_show_in_nav_menus_get === "false" ) {
          $dmach_show_in_nav_menus = false;
        } else {
          $dmach_show_in_nav_menus = true;
        }
            
            if ($dmach_taxonomies !== "") {
              if (is_array($dmach_taxonomies)) {
                foreach ($dmach_taxonomies as $value) {
                  $ending = "_" . $value;
                  $cat_key = $dmach_post_type_key . $ending;
                  if ($value == "category") {
                    $label = "Category";
                    $label_plural = "Categories";
                    $label_lower = "category";
                    $label_lower_plural = "categories";
                    $slug = $dmach_post_type_key . '_category';
                  } else {
                    $label = "Tag";
                    $label_plural = "Tags";
                    $label_lower = "tag";
                    $label_lower_plural = "tags";
                    $slug = $dmach_post_type_key . '_tag';
                  }
                  
                  
                  register_taxonomy(
                    $cat_key,
                    $dmach_post_type_key,
                    array(
                      'hierarchical'          => true,
                      'label'                 => __( $label_plural, 'divi-machine' ),
                      'labels'                => array(
                      'name'              => __( $dmach_name_singular . ' ' . $label_lower_plural, 'divi-machine' ),
                      'singular_name'     => __( $dmach_name_singular . ' ' . $label, 'divi-machine' ),
                      'menu_name'         => __( $label_plural, 'divi-machine' ),
                      'search_items'      => __( 'Search ' . $label_lower_plural, 'divi-machine' ),
                      'all_items'         => __( 'All ' . $label_lower_plural, 'divi-machine' ),
                      'parent_item'       => __( 'Parent ' . $label_lower, 'divi-machine' ),
                      'parent_item_colon' => __( 'Parent ' . $label_lower . ':', 'divi-machine' ),
                      'edit_item'         => __( 'Edit ' . $label_lower, 'divi-machine' ),
                      'update_item'       => __( 'Update ' . $label_lower, 'divi-machine' ),
                      'add_new_item'      => __( 'Add new ' . $label_lower, 'divi-machine' ),
                      'new_item_name'     => __( 'New ' . $label_lower . ' name', 'divi-machine' ),
                      'not_found'         => __( 'No ' . $label_lower_plural . ' found', 'divi-machine' ),
                      ),
                      'show_ui'               => true,
                      'show_admin_column' => true,
                      'query_var'             => true,
                      'rewrite'               => array(
                      'slug'         => $slug,
                      'with_front'   => false,
                      'hierarchical' => true,
                      ),
                      'show_in_rest' => true,
                    )
                  );
                }
              }
            } else {

            }
            
            $labels = array(
              'name'                  => _x( $dmach_name_plural, 'Post Type General Name', 'divi_machine' ),
              'singular_name'         => _x( $dmach_name_singular, 'Post Type Singular Name', 'divi_machine' ),
              'menu_name'             => __( $dmach_menu_name, 'divi_machine' ),
              'name_admin_bar'        => __( $dmach_admin_bar_name, 'divi_machine' ),
              'archives'              => __( 'Item Archives', 'divi_machine' ),
              'attributes'            => __( 'Item Attributes', 'divi_machine' ),
              'parent_item_colon'     => __( 'Parent Item:', 'divi_machine' ),
              'all_items'             => __( $dmach_all_items, 'divi_machine' ),
              'add_new_item'          => __( $dmach_new_item, 'divi_machine' ),
              'add_new'               => __( $dmach_add_new, 'divi_machine' ),
              'new_item'              => __( $dmach_new_item, 'divi_machine' ),
              'edit_item'             => __( $dmach_edit_item, 'divi_machine' ),
              'update_item'           => __( $dmach_update_item, 'divi_machine' ),
              'view_item'             => __( $dmach_view_item, 'divi_machine' ),
              'view_items'            => __( $dmach_view_items, 'divi_machine' ),
              'search_items'          => __( $dmach_search_item, 'divi_machine' ),
              'not_found'             => __( 'Not found', 'divi_machine' ),
              'not_found_in_trash'    => __( 'Not found in Trash', 'divi_machine' ),
              'featured_image'        => __( 'Featured Image', 'divi_machine' ),
              'set_featured_image'    => __( 'Set featured image', 'divi_machine' ),
              'remove_featured_image' => __( 'Remove featured image', 'divi_machine' ),
              'use_featured_image'    => __( 'Use as featured image', 'divi_machine' ),
              'insert_into_item'      => __( 'Insert into item', 'divi_machine' ),
              'uploaded_to_this_item' => __( 'Uploaded to this item', 'divi_machine' ),
              'items_list'            => __( 'Items list', 'divi_machine' ),
              'items_list_navigation' => __( 'Items list navigation', 'divi_machine' ),
              'filter_items_list'     => __( 'Filter items list', 'divi_machine' ),
            );
    
            $capabilities = array(
              'edit_post'             => 'edit_post',
              'read_post'             => 'read_post',
              'delete_post'           => 'delete_post',
              'edit_posts'            => 'edit_posts',
              'edit_others_posts'     => 'edit_others_posts',
              'publish_posts'         => 'publish_posts',
              'read_private_posts'    => 'read_private_posts',
            );
            
            $args = array(
            'label'                 => __( $dmach_name_singular, 'divi_machine' ),
            'description'           => __( $dmach_description, 'divi_machine' ),
            'labels'                => $labels,
            'supports'              => $dmach_supports,
            'show_in_rest'      => $dmach_gutenberg,
            'publicly_queryable'    => $dmach_public_queryable,
            'query_var'             => true,
            'hierarchical'          => $dmach_hierarchical,
            'public'                => $dmach_public,
            'show_ui'               => true,
            'show_in_menu'          => $dmach_show_in_admin_sidebar,
            'menu_position'         => $dmach_show_admin_sidebar_postion,
            'menu_icon'             => $dmach_show_admin_sidebar_icon,
            'show_in_admin_bar'     => $dmach_show_in_admin_bar,
            'show_in_nav_menus'     => $dmach_show_in_nav_menus,
            'exclude_from_search'   => $dmach_exclude_from_search,
          );
          
          if ($dmach_prettify_post == "1" || $dmach_prettify_post == "true" || $dmach_prettify_post == "on" ) {
            $args['rewrite']['slug'] = $dmach_post_type_key.'/%'.$dmach_post_type_key.'_category%';
            $args['rewrite']['with_front'] = true;
            if ($dmach_enable_archives == "false") {
              $args['has_archive'] = false;
            } else {
              $args['has_archive'] = $dmach_post_type_key;
            }
          } else {
            if ($dmach_rewrite == true) {
              $args['rewrite']['with_front'] = $dmach_rewrite_withfront;
              $args['has_archive'] = $dmach_enable_archives_dis;
            } else {
              // $args['rewrite']['slug'] = $dmach_post_type_key.'/%'.$dmach_post_type_key.'_category%';
              // $args['rewrite']['with_front'] = true;
              // $args['has_archive'] = $dmach_post_type_key;
            }

            if ( !empty( $dmach_custom_post_slug ) )        {
              $args['rewrite']['slug'] = $dmach_custom_post_slug;
            }
          }
          
          register_post_type( $dmach_post_type_key, $args );
          flush_rewrite_rules();
        }
      }
      
      wp_reset_postdata();
  }

  
  add_action( 'init', 'create_dmachine_create_taxonomies' );
  ///////////////////////////// CREATE CUSTOM TAX 
  function create_dmachine_create_taxonomies() {

    $ids = array();
    $args = array( 'post_type' => 'dmach_tax', 'posts_per_page' => -1 );

    $dmach_posts = get_posts( $args );
    foreach ($dmach_posts as $dmach_post) {
      $ids[] = $dmach_post->ID;
    }
    foreach (array_unique($ids) as $key => $value) {
    
      $dmach_tax_slug = get_post_meta( $value, 'divi-machine_dmach_tax_slug', true); // $titan->getOption( 'dmach_tax_slug', $value  ); // done
      $dmach_tax_plural = get_post_meta( $value, 'divi-machine_dmach_tax_plural', true); // $titan->getOption( 'dmach_tax_plural', $value  ); // done
      $dmach_tax_single = get_post_meta( $value, 'divi-machine_dmach_tax_single', true); // $titan->getOption( 'dmach_tax_single', $value  ); // done
      $dmach_tax_post_type = get_post_meta( $value, 'divi-machine_dmach_tax_post_type', true); // $titan->getOption( 'dmach_tax_post_type', $value  ); // done
      $dmach_tax_menu_name = get_post_meta( $value, 'divi-machine_dmach_tax_menu_name', true); // $titan->getOption( 'dmach_tax_menu_name', $value  ); // done
      $dmach_tax_all_items = get_post_meta( $value, 'divi-machine_dmach_tax_all_items', true); // $titan->getOption( 'dmach_tax_all_items', $value  ); // done
      $dmach_tax_edit_item = get_post_meta( $value, 'divi-machine_dmach_tax_edit_item', true); // $titan->getOption( 'dmach_tax_edit_item', $value  ); // done
      $dmach_tax_view_item = get_post_meta( $value, 'divi-machine_dmach_tax_view_item', true); // $titan->getOption( 'dmach_tax_view_item', $value  ); // done
      $dmach_tax_update_item = get_post_meta( $value, 'divi-machine_dmach_tax_update_item', true); // $titan->getOption( 'dmach_tax_update_item', $value  ); // done
      $dmach_tax_add_new = get_post_meta( $value, 'divi-machine_dmach_tax_add_new', true); // $titan->getOption( 'dmach_tax_add_new', $value  ); // done
      $dmach_tax_new_item = get_post_meta( $value, 'divi-machine_dmach_tax_new_item', true); // $titan->getOption( 'dmach_tax_new_item', $value  ); // done
      $dmach_tax_parent = get_post_meta( $value, 'divi-machine_dmach_tax_parent', true); // $titan->getOption( 'dmach_tax_parent', $value  ); // done
      $dmach_tax_parent_colon = get_post_meta( $value, 'divi-machine_dmach_tax_parent_colon', true); // $titan->getOption( 'dmach_tax_parent_colon', $value  ); // done
      $dmach_tax_search = get_post_meta( $value, 'divi-machine_dmach_tax_search', true); // $titan->getOption( 'dmach_tax_search', $value  ); // done
      $dmach_tax_popular = get_post_meta( $value, 'divi-machine_dmach_tax_popular', true); // $titan->getOption( 'dmach_tax_popular', $value  ); // done
      $dmach_tax_seperate_commas = get_post_meta( $value, 'divi-machine_dmach_tax_seperate_commas', true); // $titan->getOption( 'dmach_tax_seperate_commas', $value  ); // done
      $dmach_tax_add_remove = get_post_meta( $value, 'divi-machine_dmach_tax_add_remove', true); // $titan->getOption( 'dmach_tax_add_remove', $value  ); // done
      $dmach_tax_most_used = get_post_meta( $value, 'divi-machine_dmach_tax_most_used', true); // $titan->getOption( 'dmach_tax_most_used', $value  ); // done
      $dmach_tax_notfound = get_post_meta( $value, 'divi-machine_dmach_tax_notfound', true); // $titan->getOption( 'dmach_tax_notfound', $value  ); // done
      $dmach_tax_noterms = get_post_meta( $value, 'divi-machine_dmach_tax_noterms', true); // $titan->getOption( 'dmach_tax_noterms', $value  );
      $dmach_tax_item_list_nav = get_post_meta( $value, 'divi-machine_dmach_tax_item_list_nav', true); // $titan->getOption( 'dmach_tax_item_list_nav', $value  );
      $dmach_tax_item_list = get_post_meta( $value, 'divi-machine_dmach_tax_item_list', true); // $titan->getOption( 'dmach_tax_item_list', $value  );
      $dmach_tax_public = get_post_meta( $value, 'divi-machine_dmach_tax_public', true); // $titan->getOption( 'dmach_tax_public', $value  );
      $dmach_tax_public_queryable = get_post_meta( $value, 'divi-machine_dmach_tax_public_queryable', true); // $titan->getOption( 'dmach_tax_public_queryable', $value  );
      $dmach_tax_hierarchical = get_post_meta( $value, 'divi-machine_dmach_tax_hierarchical', true); // $titan->getOption( 'dmach_tax_hierarchical', $value  );
      $dmach_tax_show_ui = get_post_meta( $value, 'divi-machine_dmach_tax_show_ui', true); // $titan->getOption( 'dmach_tax_show_ui', $value  );
      $dmach_tax_show_in_menu = get_post_meta( $value, 'divi-machine_dmach_tax_show_in_menu', true); // $titan->getOption( 'dmach_tax_show_in_menu', $value  );
      $dmach_tax_show_nav_menu = get_post_meta( $value, 'divi-machine_dmach_tax_show_nav_menu', true); // $titan->getOption( 'dmach_tax_show_nav_menu', $value  );
      $dmach_tax_query_var = get_post_meta( $value, 'divi-machine_dmach_tax_query_var', true); // $titan->getOption( 'dmach_tax_query_var', $value  );
      $dmach_tax_query_var_custom = get_post_meta( $value, 'divi-machine_dmach_tax_query_var_custom', true); // $titan->getOption( 'dmach_tax_query_var_custom', $value  );
      $dmach_tax_rewrite = get_post_meta( $value, 'divi-machine_dmach_tax_rewrite', true); // $titan->getOption( 'dmach_tax_rewrite', $value  );
      $dmach_tax_query_rewrite_custom = get_post_meta( $value, 'divi-machine_dmach_tax_query_rewrite_custom', true); // $titan->getOption( 'dmach_tax_query_rewrite_custom', $value  );
      $dmach_tax_rewrite_front = get_post_meta( $value, 'divi-machine_dmach_tax_rewrite_front', true); // $titan->getOption( 'dmach_tax_rewrite_front', $value  );
      $dmach_tax_rewrite_hierarchical = get_post_meta( $value, 'divi-machine_dmach_tax_rewrite_hierarchical', true); // $titan->getOption( 'dmach_tax_rewrite_hierarchical', $value  );


      $dmach_tax_rewrite_arg = array(
        'slug'         => $dmach_tax_query_rewrite_custom,
        'with_front'   => $dmach_tax_rewrite_front,
        'hierarchical' => $dmach_tax_rewrite_hierarchical,
      );
      
      if ( !$dmach_tax_rewrite ){
        $dmach_tax_rewrite_arg = false;
      }

      // echo "peter";
      // print_r($dmach_tax_rewrite_arg);
      
      register_taxonomy(
        $dmach_tax_slug,
        $dmach_tax_post_type,
        array(
          'public'          => __( $dmach_tax_public, 'divi-machine' ),
          'publicly_queryable'          => __( $dmach_tax_public_queryable, 'divi-machine' ),
          'hierarchical'          => __( $dmach_tax_hierarchical, 'divi-machine' ),
          'show_ui'          => __( $dmach_tax_show_ui, 'divi-machine' ),
          'show_in_menu'          => __( $dmach_tax_show_in_menu, 'divi-machine' ),
          'show_in_nav_menus'          => __( $dmach_tax_show_nav_menu, 'divi-machine' ),
					'label'                 => __( $dmach_tax_plural, 'divi-machine' ),
					'labels'                => array(
					'name'              => __( $dmach_tax_plural, 'divi-machine' ),
					'singular_name'     => __( $dmach_tax_single , 'divi-machine' ),
					'menu_name'         => _x( $dmach_tax_menu_name, 'divi-machine' ),
          'search_items'      => __( $dmach_tax_search, 'divi-machine' ),
          'popular_items'     => __( $dmach_tax_popular, 'divi-machine' ),
					'all_items'         => __( $dmach_tax_all_items, 'divi-machine' ),
					'parent_item'       => __( $dmach_tax_parent, 'divi-machine' ),
					'parent_item_colon' => __( $dmach_tax_parent_colon, 'divi-machine' ),
           'edit_item'         => __( $dmach_tax_edit_item, 'divi-machine' ),
           'view_item'         => __( $dmach_tax_view_item, 'divi-machine' ),
					'update_item'       => __( $dmach_tax_update_item, 'divi-machine' ),
					'add_new_item'      => __( $dmach_tax_add_new, 'divi-machine' ),
					'new_item_name'     => __( $dmach_tax_new_item, 'divi-machine' ),
          'not_found'         => __( $dmach_tax_notfound, 'divi-machine' ),
          'separate_items_with_commas' => __( $dmach_tax_seperate_commas, 'divi-machine' ),
          'add_or_remove_items' => __( $dmach_tax_add_remove, 'divi-machine' ),
          'choose_from_most_used' => __( $dmach_tax_most_used, 'divi-machine' ),
        ),
        'show_ui'               => $dmach_tax_show_ui,
				'query_var'             => true,
        'rewrite'               => $dmach_tax_rewrite_arg,
        'show_in_rest' => true,
        )
      );
    }
    
    wp_reset_postdata();
  }

  $dmach_post_ids = array();
  $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );
  $loop = get_posts( $args );

  foreach ($loop as $key => $dmach_post) {
    array_push( $dmach_post_ids, $dmach_post->ID );
  }

  $GLOBALS['dmach_post_ids'] = array_unique($dmach_post_ids);



  // TODO: remove error messages that the following code generates
  add_filter( 'post_type_link', 'dmach_pretty_permalinks', 15, 2 );
  function dmach_pretty_permalinks( $post_link, $post ){

    $args = array(
      'public'   => true,
      '_builtin' => false
    );

    $post_types = get_post_types($args);
    global $pagenow;
    
    if ( !in_array( $post->post_type, $post_types )){
      return $post_link;
    }
        
    foreach ($GLOBALS['dmach_post_ids'] as $key => $value) {
    //foreach (array_unique($ids) as $key => $value) {
      $dmach_prettify_post = get_post_meta( $value, 'divi-machine_dmach_prettify_post', true); // $titan->getOption( 'dmach_prettify_post', $value  );
      $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true); // $titan->getOption( 'dmach_post_type_key', $value  ); // DONE
      $dmach_taxonomies = maybe_unserialize( get_post_meta( $value, 'divi-machine_dmach_taxonomies', true) ); // $titan->getOption( 'dmach_taxonomies', $value  ); // DONE
      
      if ($dmach_prettify_post == "1") {
        if ( is_object( $post ) && $post->post_type == $dmach_post_type_key ){
          if ($dmach_taxonomies !== "") {
            if (is_array($dmach_taxonomies)) {
              foreach ($dmach_taxonomies as $tax) {
                if ($tax == "category") {
                  $label = "Category";
                  $label_plural = "Categories";
                  $label_lower = "category";
                  $label_lower_plural = "categories";
                  $slug = $dmach_post_type_key . '_category';
                } else {
                  $label = "Tag";
                  $label_plural = "Tags";
                  $label_lower = "tag";
                  $label_lower_plural = "tags";
                  $slug = $dmach_post_type_key . '_tag';
                }
                $terms = wp_get_object_terms( $post->ID, $slug );
                if( !empty($terms) ){
                  $post_link = str_replace( '%'.$slug.'%' , $terms[0]->slug , $post_link );
                }else {
                   $post_link = str_replace( '%'.$slug.'%' , 'uncategorized' , $post_link );
                }
              }
            }
          }
        }
      }
    }

     return $post_link;
  }


  add_filter( 'get_sample_permalink', 'dmach_get_sample_permalink', 10, 5);
  function dmach_get_sample_permalink( $permalink, $post_id, $title, $name, $post ){
    $ids = array();
    $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );
    $loop = get_posts( $args );
    foreach ($loop as $key => $dmach_post) {
        array_push( $ids, $dmach_post->ID );    
    }
    
    foreach (array_unique($ids) as $key => $value) {
      $dmach_prettify_post = get_post_meta( $value, 'divi-machine_dmach_prettify_post', true); // $titan->getOption( 'dmach_prettify_post', $value  );
      $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true); // $titan->getOption( 'dmach_post_type_key', $value  ); // DONE
      $dmach_taxonomies = maybe_unserialize(get_post_meta( $value, 'divi-machine_dmach_taxonomies', true)); // $titan->getOption( 'dmach_taxonomies', $value  ); // DONE
      
      if ($dmach_prettify_post == "1") {
        if ( is_object( $post ) && $post->post_type == $dmach_post_type_key ){
          if ($dmach_taxonomies !== "") {
            if (is_array($dmach_taxonomies)) {
              foreach ($dmach_taxonomies as $tax) {
                if ($tax == "category") {
                  $label = "Category";
                  $label_plural = "Categories";
                  $label_lower = "category";
                  $label_lower_plural = "categories";
                  $slug = $dmach_post_type_key . '_category';
                } else {
                  $label = "Tag";
                  $label_plural = "Tags";
                  $label_lower = "tag";
                  $label_lower_plural = "tags";
                  $slug = $dmach_post_type_key . '_tag';
                }
                $terms = wp_get_object_terms( $post->ID, $slug );
                if( $terms ){
                  $permalink[0] = str_replace( '%'.$slug.'%' , $terms[0]->slug , $permalink[0] );
                }
              }
            }
          }
        }
      }
    }
    
    return $permalink;
  }

  add_filter( 'rewrite_rules_array', 'dmach_rewrite_rules' );
  function dmach_rewrite_rules( $rules ) {
    $new = array();
    $ids = array();
    $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );

    $dmach_posts = get_posts( $args );
    foreach ($dmach_posts as $dmach_post) {
      $ids[] = $dmach_post->ID;
    }
    foreach (array_unique($ids) as $key => $value) {
      $dmach_prettify_post = get_post_meta( $value, 'divi-machine_dmach_prettify_post', true); // $titan->getOption( 'dmach_prettify_post', $value  );
      if ($dmach_prettify_post == "1") {
        $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true); // $titan->getOption( 'dmach_post_type_key', $value  ); // DONE
        //$new["'".$dmach_post_type_key."/([^/]+)/(.+)/?$'"] = 'index.php?'.$dmach_post_type_key.'=$matches[2]';
        //$new["'".$dmach_post_type_key."/(.+)/?$'"] = 'index.php?'.$dmach_post_type_key.'_category=$matches[1]';
        // $new[$post_type_slug . '/' . $term->slug . '/page/?([0-9]{1,})/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug . '&paged=' . $wp_rewrite->preg_index( 1 ); // CODE TO CHANGE THE STRUCTURE ON PAGINATION 2
      }
    }
    wp_reset_postdata();  
    return array_merge( $new, $rules ); // Ensure our rules come first
  }



add_action('init','dmach_redirect_old_category');

function dmach_redirect_old_category() {

  if (!is_admin()) {

    /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-machine' );*/

    $ids = array();
    $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );
    $dmach_posts = get_posts( $args );
    foreach ($dmach_posts as $dmach_post) {
      $ids[] = $dmach_post->ID;
    }

    foreach (array_unique($ids) as $key => $value) {
      $dmach_prettify_post = get_post_meta( $value, 'divi-machine_dmach_prettify_post', true); // $titan->getOption( 'dmach_prettify_post', $value  );
      $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true); // $titan->getOption( 'dmach_post_type_key', $value  ); // DONE
      $dmach_taxonomies = get_post_meta( $value, 'divi-machine_dmach_taxonomies', true); // $titan->getOption( 'dmach_taxonomies', $value  ); // DONE

      if ($dmach_prettify_post == "1") {


        if ($dmach_taxonomies !== "") {

          if (is_array($dmach_taxonomies)) {
            foreach ($dmach_taxonomies as $value) {

              if ($value == "category") {

                $slug_underscore = $dmach_post_type_key . '_category';
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $url = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

                if (strpos($url,'?filter') == false) {
                  if (strpos($url,$slug_underscore) !== false) {
                    
                    $url_new = str_replace( $slug_underscore,$dmach_post_type_key,$url);

                    wp_redirect($url_new);
                    exit();
                  } else {
                  }
                }
              }
            }
          }
        }
      }
    }

    wp_reset_postdata();
  }

}




add_filter( 'wpseo_opengraph_url', 'dmach_opengraph_url_pretty_urls' );
function dmach_opengraph_url_pretty_urls($url) {
  
  if (!is_admin()) {

  /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-machine' );*/

  $ids = array();
  $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
  array_push( $ids, get_the_ID() );

  // END LOOP
  endwhile;

  foreach (array_unique($ids) as $key => $value) {
    $dmach_prettify_post = get_post_meta( $value, 'divi-machine_dmach_prettify_post', true); // $titan->getOption( 'dmach_prettify_post', $value  );
    $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true); // $titan->getOption( 'dmach_post_type_key', $value  ); // DONE
    $dmach_taxonomies = get_post_meta( $value, 'divi-machine_dmach_taxonomies', true); // $titan->getOption( 'dmach_taxonomies', $value  ); // DONE

    if ($dmach_prettify_post == "1") {


      if ($dmach_taxonomies !== "") {

        if (is_array($dmach_taxonomies)) {
        foreach ($dmach_taxonomies as $value) {

          if ($value == "category") {

            $slug_underscore = $dmach_post_type_key . '_category';

  if (strpos($url,'?filter') == false) {
  if (strpos($url,$slug_underscore) !== false) {
    
    $url_new = str_replace( $slug_underscore,$dmach_post_type_key,$url);

    $url = $url_new;
    return $url;

} else {
}
}
          }
}
}
}
}
}

wp_reset_postdata();

}

}

 

function et_add_post_meta_box_machine( $post_type, $post ) {
	$allowed = et_pb_is_allowed( 'page_options' );
	$enabled = $post ? et_builder_enabled_for_post( $post->ID ) : et_builder_enabled_for_post_type( $post_type );
	$enabled = in_array( $post_type, et_builder_get_default_post_types() ) ? true : $enabled;
  $public  = et_builder_is_post_type_public( $post_type );
  
  /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-machine' );*/
  $ids = array();
  $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );

    $dmach_posts = get_posts( $args );
    foreach ($dmach_posts as $dmach_post) {
      $ids[] = $dmach_post->ID;
    }
    
    $post_types_array = array();
    foreach (array_unique($ids) as $key => $value) {
    $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true); // $titan->getOption( 'dmach_post_type_key', $value  ); // DONE
    array_push($post_types_array, $dmach_post_type_key);
   }
  $post_type = $post->post_type;
             
  if (in_array($post_type, $post_types_array)) { 
	if ( $allowed && $enabled && $public ) {
		add_meta_box( 'settings_machine_meta_box', esc_html__( 'Divi Machine Page Settings', 'Divi' ), 'et_single_machine_settings_meta_box', $post_type, 'side', 'high' );
  }
  }
}
add_action( 'add_meta_boxes', 'et_add_post_meta_box_machine', 10, 2 );

    function et_single_machine_settings_meta_box( $post ) {
      /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-machine' );*/
      $ids = array();
      $args = array( 'post_type' => 'dmach_post', 'posts_per_page' => -1 );

        $dmach_posts = get_posts( $args );
        foreach ($dmach_posts as $dmach_post) {
          $ids[] = $dmach_post->ID;
        }
        
        $post_types_array = array();
        foreach (array_unique($ids) as $key => $value) {
          $dmach_post_type_key = get_post_meta( $value, 'divi-machine_dmach_post_type_key', true); // $titan->getOption( 'dmach_post_type_key', $value  ); // DONE
        array_push($post_types_array, $dmach_post_type_key);
       }
       
        $post_id = get_the_ID();

        $show_title = get_post_meta( $post_id, '_et_pb_show_title', true );

        $post_type = $post->post_type;
             
          if (in_array($post_type, $post_types_array)) { ?>
            <p class="et_pb_page_settings et_pb_single_title">
                <label for="et_single_title" style="display: block; font-weight: bold; margin-bottom: 5px;"><?php esc_html_e( 'Post Title', 'Divi' ); ?>: </label>
    
                <select id="et_single_title" name="et_single_title">
                    <option value="on" <?php selected( 'on', $show_title ); ?>><?php esc_html_e( 'Show', 'Divi' ); ?></option>
                    <option value="off" <?php selected( 'off', $show_title ); ?>><?php esc_html_e( 'Hide', 'Divi' ); ?></option>
                </select>
            </p>

            <?php 
            }
      
    }




    function et_divi_post_machine_settings_save_details( $post_id, $post ) {
        global $pagenow;
        if ( 'post.php' !== $pagenow || ! $post || ! is_object( $post ) ) {
            return;
        }
    
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['et_single_title'] ) )
		update_post_meta( $post_id, '_et_pb_show_title', sanitize_text_field( $_POST['et_single_title'] ) );
	else
		delete_post_meta( $post_id, '_et_pb_show_title' );
    }
    add_action( 'save_post', 'et_divi_post_machine_settings_save_details', 10, 2 );

// END
}

add_action( 'init', 'divi_machine_titan_add_post_options', 1 );

