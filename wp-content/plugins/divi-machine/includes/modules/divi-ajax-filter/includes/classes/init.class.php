<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

if ( !class_exists('DE_Filter_INIT') ) {
	class DE_Filter_INIT{

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


		}

		// render ET font icons content css property
		public static function et_icon_css_content( $font_icon ){
			$icon = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon ) );
			$icon = preg_replace( '/(&amp#x)|;/', '', $icon );
			$icon = preg_replace( '/(&#x)|;/', '', $icon );

			return '\\' . $icon;
		}


		public static function get_acf_fields(  ){

			$domain_name = '';

			if (defined('DE_DB_WOO_VERSION')) {
                $domain_name = 'divi-bodyshop-woocommerce';
            } else if (defined('DE_DMACH_VERSION')) {
                $domain_name = 'divi-machine';
            } else {
                $domain_name = 'divi-filter';
            }

			if ( empty( self::$acf_fields ) ) {
				self::$acf_fields = array(
					"none" => esc_html__('Please select an ACF field', $domain_name)
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
								if ( $grandparent != 0 ) {
									$grandparent_obj = get_post( $grandparent );  
									$grandparent_name = $grandparent_obj->post_title;
									if ( isset( self::$acf_fields[$grandparent_name] ) && isset( self::$acf_fields[$grandparent_name][$post_parent_obj->post_name] ) ) {
										//unset( self::$acf_fields[$grandparent_name][$post_parent_obj->post_name] );
									}

									self::$acf_fields[$grandparent_name][$field->post_name] = $post_parent_name . ' - ' . $field->post_title;
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

	$post_slug = str_replace('-', '_', $post_slug);
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

	new DE_Filter_INIT();

}