<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class DEDMACH_INIT{

	protected static $required_item = array();
	public static $product_layout_id = '0';
	public static $page_layout 	= false;
	public static $product_builder_used = 'divi_library';
	public $layout_type = false;
	public static $plugin_settings = false;
	public static $notices = '';

	public static $divi_layouts = array();

	public static $acf_fields = array();

	public function __construct(){

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_load_scripts' ) );

	}


	// load front end scripts
	public function load_scripts(){
		wp_enqueue_script( 'dmach-carousel-js',  DE_DMACH_PATH_URL . '/js/carousel.min.js', array(), DE_DMACH_VERSION, true );
        wp_enqueue_style( 'dmach-carousel-css', DE_DMACH_PATH_URL . '/css/carousel.min.css', array(), DE_DMACH_VERSION );
		wp_enqueue_script( 'divi-machine-general-js', DE_DMACH_PATH_URL . '/js/frontend-general.min.js', array( 'jquery' ), DE_DMACH_VERSION, true );
		$ajax_nonce = wp_create_nonce('filter_object');
		wp_add_inline_script( 'divi-machine-general-js', 'var filter_ajax_object = ' . json_encode( array(
			    'ajax_url' => admin_url( 'admin-ajax.php' ),
			    'ajax_pagination' => true,
			    'security'			=> $ajax_nonce
			) ) );

		// Register ajax load more js library
		// global $wp_query;
		//wp_register_script( 'divi-machine-ajax-loadmore-js', DE_DMACH_PATH_URL . '/scripts/ajax-loadmore.min.js', array('jquery'), DE_DMACH_VERSION, true );

		/*wp_localize_script( 'divi-machine-ajax-loadmore-js', 'divi_machine_loadmore_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
			'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
			'max_page' => $wp_query->max_num_pages
		) );
		wp_enqueue_script( 'divi-machine-ajax-loadmore-js' );*/
		// JS RANGE SLIDER
		//wp_enqueue_script( 'divi-machine-rangeSlider-js', DE_DMACH_PATH_URL . '/scripts/ion.rangeSlider.min.js', array( 'jquery' ), DE_DMACH_VERSION, true );
	  	//wp_enqueue_style( 'divi-machine-rangeSlider-css', DE_DMACH_PATH_URL . '/css/ion.rangeSlider.min.css' , array(), DE_DMACH_VERSION, 'all' );
	}

	// load back end scripts
	public function admin_load_scripts(){
		// wp_enqueue_script( 'woo-pro-divi-admin-js', DE_DMACH_PATH_URL . '/includes/assets/admin/main.admin.js', array( 'jquery' ), null, true );
		// wp_register_style( 'divi-machine-admin-css', DE_DMACH_PATH_URL . '/styles/admin-style.css', false, DE_DMACH_VERSION );
		// wp_enqueue_style( 'divi-machine-admin-css' );

	}


	// render ET font icons content css property
	public static function et_icon_css_content( $font_icon ){
		$icon = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon ) );
		$icon = preg_replace( '/(&amp#x)|;/', '', $icon );
		$icon = preg_replace( '/(&#x)|;/', '', $icon );

		return '\\' . $icon;
	}

	public static function get_acf_field_group( ) {

		$result = array();

		if ( function_exists( 'acf_get_field_groups' ) ) {
			$field_groups = acf_get_field_groups();

			if ( !empty( $field_groups ) ) {
				foreach ( $field_groups as $group ) {
		    	$result[$group['key']] = $group['title'];
		    }
			}
		}

		return $result;
	}

	public static function search_acf_group_default() {
		$result = array();

		if ( function_exists( 'acf_get_field_groups' ) ) {
			$field_groups = acf_get_field_groups();

			if ( !empty( $field_groups ) ) {
				foreach ( $field_groups as $group ) {
		    	$result[$group['key']] = "on";
		    }
			}
		}

		return $result;	
	}


	public static function get_acf_fields(  ){

		if ( empty( self::$acf_fields ) ) {
			self::$acf_fields = array(
				"none" => esc_html__('Please select an ACF field', 'divi-machine'),
				"custom_acf_name_de" => esc_html__('Custom ID (you specify)', 'divi-machine')
			);

			if ( function_exists( 'acf_get_field_groups' ) ) {
				$field_groups = acf_get_field_groups();
				foreach ( $field_groups as $group ) {
					// DO NOT USE here: $fields = acf_get_fields($group['key']);
					// because it causes repeater field bugs and returns "trashed" fields
					self::$acf_fields[ $group['title'] ] = array();
					$fields = get_posts(array(
						'posts_per_page'   => -1,
						'post_type'        => 'acf-field',
						'orderby'          => 'title',
						'order'            => 'ASC',
						'suppress_filters' => true, // DO NOT allow WPML to modify the query
						'post_parent'      => $group['ID'],
						'post_status'       => 'publish',
						'update_post_meta_cache' => false
					));

					foreach ( $fields as $field ) {

						self::$acf_fields[ $group['title'] ][$field->post_name] = $field->post_title;

					}

				}
			}

			$fields_all = get_posts(array(
				'posts_per_page'   => -1,
				'post_type'        => 'acf-field',
				'orderby'          => 'name',
				'order'            => 'ASC',
				'post_status'       => 'publish',
			));

			if ( !empty( $fields_all ) ) {
				foreach ( $fields_all as $field ) {

					$post_parent = $field->post_parent;
					if ( $post_parent ) {
						$post_parent_obj = get_post( $post_parent );
						if ( $post_parent_obj ) {
							$post_parent_name = $post_parent_obj->post_title;
							$grandparent = wp_get_post_parent_id($post_parent);
							if ( $grandparent ) {
								$grandparent_obj = get_post( $grandparent );
								if ( ! empty( $grandparent_obj ) ) {
									$grandparent_name = $grandparent_obj->post_title;
									if ( isset( self::$acf_fields[ $grandparent_name ] ) && isset( self::$acf_fields[ $grandparent_name ][ $post_parent_obj->post_name ] ) ) {
										//unset( self::$acf_fields[$grandparent_name][$post_parent_obj->post_name] );
									}

									self::$acf_fields[ $grandparent_name ][ $field->post_name ] = $post_parent_name . ' - ' . $field->post_title;
								}
							}
						}
					}
				}
			}
		}

		foreach( self::$acf_fields as $key => $value ){
			if ( is_array( $value ) ) {
				asort( self::$acf_fields[$key] );	
			}			
		}

		return self::$acf_fields;
	}

	public static function get_divi_layouts(  ){

		if ( empty( self::$divi_layouts ) ) {
			$layout_query = array(
				'post_type'=>'et_pb_layout'
				, 'posts_per_page'=>-1
				, 'meta_query' => array(
						array(
								'key' => '_et_pb_predefined_layout',
								'compare' => 'NOT EXISTS',
						),
				)
			);

			self::$divi_layouts['none'] = 'No Layout (please choose one)';
			if ($layouts = get_posts($layout_query)) {
				foreach ($layouts as $layout) {
					self::$divi_layouts[$layout->ID] = $layout->post_title;
				}
			}
		}
		return self::$divi_layouts;		
	}


	public static function get_vb_post_type(  ){

		$get_dmach_args = array(
      'post_type' => 'dmach_post',
      'post_status' => 'publish',
      'posts_per_page' => '1',
	    'orderby' => 'ID',
	    'order' => 'ASC',
  );

  query_posts( $get_dmach_args );

  $first = true;

  if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();
      // setup_postdata( $post );

    if ( $first )  {

			global $post;
			$post_slug = $post->post_name;
$first = false;
		} else {
}
	}
} else {
$post_slug = 'post';
}

		if ( isset( $post_slug ) ) {
			$post_slug = str_replace('-', '_', $post_slug);
		}
return $post_slug;
	}


	public static function get_divi_post_types(  ){

		// if (!is_admin()) {
		// 	return;
		// }

		$options_posttype = array();

		$args_posttype = array(
			'public'   => true,
		);

		$output = 'names'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'

		$post_types = get_post_types( $args_posttype, $output, $operator );

		foreach ( $post_types  as $post_type ) {
			if ($post_type == "attachment") {} else {
			$options_posttype[$post_type] = $post_type;
			}
		}

		return $options_posttype;
	}



}

new DEDMACH_INIT();
