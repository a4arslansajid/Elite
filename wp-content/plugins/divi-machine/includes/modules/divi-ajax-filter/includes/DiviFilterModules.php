<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists('DE_Filter')) {

class DE_Filter extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divi-ajax-filter';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-ajax-filter';

	/**
	 * The extension's version
	 *
	 * @since 2.1.5
	 *
	 * @var string
	 */
	public $version = DE_DF_VERSION;

	public static $divi_layouts = array();

	public static $acf_fields = array();
	/**
	 * DE_Machine constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-ajax-filter', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );
		
		//add_action( 'rest_api_init', array( $this, 'de_setup_rest_api' ) );

		parent::__construct( $name, $args );
	}

	public static function get_divi_layouts(  ){

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

		return self::$divi_layouts;
	}

	public static function get_divi_post_types(  ){

		if (!is_admin()) {
			return;
		}

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


	public static function ajax_filter_create_modules_mw() {

		$de_plugin_array = array(
			'divi-machine' => array(
				'plugin_path'	=> 'divi-machine/divi-machine.php',
				'plugin_name'	=> 'Divi Machine',
				'plugin_de_id'	=> 'DE_DM',
				'plugin_et_id'	=> ''
			),
			'divi-bodycommerce' => array(
				'plugin_path'	=> 'divi-bodycommerce/divi-bodyshop-woocommerce.php',
				'plugin_name'	=> 'Divi BodyCommerce',
				'plugin_de_id'	=> 'DE_DB',
				'plugin_et_id'	=> ''
			),
			'divi-ajax-filter' => array(
				'plugin_path'	=> 'divi-ajax-filter/divi-ajax-filter.php',
				'plugin_name'	=> 'Divi Ajax Filter',
				'plugin_de_id'	=> 'DE_DAF',
				'plugin_et_id'	=> ''
			),
			'divi-form-builder' => array(
				'plugin_path' 	=> 'divi-form-builder/divi-form-builder.php',
				'plugin_name'	=> 'Divi Form Builder',
				'plugin_de_id'	=> 'DE_FB',
				'plugin_et_id'	=> ''
			),
			'divi-mega-menu'	=> array(
				'plugin_path'	=> 'divi-mega-menu/divi-mega-menu.php',
				'plugin_name'	=> 'Divi Mega Menu',
				'plugin_de_id'	=> 'DE_DMM',
				'plugin_et_id'	=> '352'
			),
			'divi-mobile'		=> array(
				'plugin_path'	=> 'divi-mobile/divi-mobile.php',
				'plugin_name'	=> 'Divi Mobile',
				'plugin_de_id'	=> 'DE_DM',
				'plugin_et_id'	=> '353'
			),
			'divi-nitro'		=> array(
				'plugin_path'	=> 'divi-nitro/divi-nitro.php',
				'plugin_name'	=> 'Divi Nitro',
				'plugin_de_id'	=> 'DE_DN',
				'plugin_et_id'	=> ''
			),
			'divi-protect'		=> array(
				'plugin_path'	=> 'divi-protect/divi-protect.php',
				'plugin_name'	=> 'Divi Protect',
				'plugin_de_id'	=> 'DE_DP',
				'plugin_et_id'	=> ''
			)
		);

		$de_get = get_option( 'de_plugins', array() );

		$result = array();

		$aj_gaket = get_option( 'et_automatic_updates_options' );
		$aj_gaket_val = $aj_gaket['api_key'];

		foreach( $de_plugin_array as $plugin_key => $plugin_data ) {

			if ( is_plugin_active( $plugin_data['plugin_path'] ) ) {
				$code_d = '0';

				if ( in_array( $plugin_data['plugin_de_id'] , $de_get ) ) {
					$code_d = '1';
				}

				$code_m = "na";

				if ( $plugin_data['plugin_et_id'] != '' ) {
					if ( isset( $product_id ) ) {
					$json = file_get_contents('https://www.elegantthemes.com/marketplace/index.php/wp-json/api/v1/check_subscription/product_id/'.$product_id.'/api_key/'.$aj_gaket_val);
					}
					$data = json_decode($json);
					$code_m = $data->code;
				}
				if(defined('DE_FB_P')){
				$result[ $plugin_data['plugin_name'] ] = array (
					'p_f' => DE_FB_P,
					'd_l' => $code_d,
					'm_l' => $code_m
				);
				}
			}			
		}

		return $result;
	}

	public function de_setup_rest_api() {
		register_rest_route( 'de_plugins', '/products/', array(
			'methods' => 'GET',
			'callback' => array( $this, 'ajax_filter_create_modules_mw' ),
		) );
	}

}

new DE_Filter;
}