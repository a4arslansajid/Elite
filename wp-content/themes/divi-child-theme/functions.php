<?php
/*
 * This is the child theme for Divi theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */

add_action( 'wp_enqueue_scripts', 'divi_child_theme_enqueue_styles' );
function divi_child_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
   wp_enqueue_script('scripts-js',get_stylesheet_directory_uri().'/assets/js/scripts.js',['jquery'],'',true);
    wp_localize_script('scripts-js','variables',[
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);

    
}

/*
 * Your code goes below
 */
add_action('init','register_custom_post_types');
function register_custom_post_types(){
    register_post_type('location',[
        'labels'=>[
            'name'=>'Location',
            'singular_name'=>'Location',
            'menu_name'=>'Locations',
        ],
        'public'=>true,
        'publicly_queryable' =>true,
        'menu_icon'=>'dashicons-location',
        'has_archive'=>true,
        'rewrite'=>['slug'=>'location'],
        'supports'=>[
            'title',
            'editor',
            'author',
            'excerpt',
            'thumbnail',
        ],


    ]);
}
add_action('init','register_taxonomies');
function register_taxonomies(){
    register_taxonomy('location_type',['location'],
      [
        'hierarchical'=> true,
        'labels'=>[
            'name'=>__('Categories'),
            'singular_name'=>__('Category'),
            'menu_name'=>__('Categories'),
        ],
        'show_ui'=>true,
        'show_admin_column'=>true,
        'rewrite'=>['slug'=>__('type')],
      ]  

);
}

add_action('wp_ajax_filter_posts','filter_posts');
add_action('wp_ajax_nopriv_filter_posts','filter_posts');
function filter_posts(){
    $args=[
        'post_type'=> 'location',
        'posts_per_page'=> -1,
    ];
    $type= $_REQUEST['cat'];
    $select_emirate= $_REQUEST['select_emirate'];



    if(!empty($type)){
        $args['tax_query'][]=[
            'taxonomy'=>'location_type',
            'field'=>'slug',
            'terms'=>$type,

        ];
    }

     if(!empty($select_emirate)){
        $args['meta_query'][] = [
            'key' => 'select_emirate',
            'value' => $select_emirate,
            'compare' => '=',
        ];
    }
   
      $locations = new WP_Query($args);
    if($locations->have_posts()):
        while ($locations->have_posts()): $locations->the_post();
            get_template_part('template-parts/loop','locations');
        endwhile;
        wp_reset_postdata();
    else:
        echo "No Academy Found";
    endif;
    wp_die();
}
