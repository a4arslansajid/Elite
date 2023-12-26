<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/* 
Plugin Name: Divi Ajax Filters
Plugin URL: https://diviengine.com
Description: Create Ajax Filters for WooCommerce & ACF. Best used with one of our plugins BodyCommerce or Machine.
Version: 2.3.3
WC tested up to: 6.6.1
Author: Divi Engine
Author URI: https://diviengine.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
@author      diviengine.com
@copyright   2020 diviengine.com

I pray that you bless the people who interact and who own this website - I pray the blessing to be one that goes beyond worldly treasures but understanding the deep love you have for them.

John 14:6
I am the way, and the truth, and the life. No one comes to the Father except through me.

DE_DF_P: d_e | m_a

*/


defined('DE_DF_VERSION') or define('DE_DF_VERSION', '2.3.3');

defined('DE_DF_PATH') or define('DE_DF_PATH',   plugin_dir_path(__FILE__));
defined('DE_DF_PLUGIN_URL') or define('DE_DF_PLUGIN_URL',   plugin_dir_url(__FILE__));
defined('DE_DF_APP_API_URL') or define('DE_DF_APP_API_URL',      'https://diviengine.com/index.php');
defined('DE_DF_PRODUCT_ID') or define('DE_DF_PRODUCT_ID',           'WP-DE-DF');
defined('DE_DF_PRODUCT_URL') or define('DE_DF_PRODUCT_URL', 'https://diviengine.com/product/divi-ajax-filter/');
defined('DE_DF_INSTANCE') or define('DE_DF_INSTANCE', str_replace(array ("https://" , "http://"), "", home_url()));
defined('DE_DF_AUTHOR') or define('DE_DF_AUTHOR', 'Divi Engine');
defined('DE_DF_URL') or define('DE_DF_URL', 'https://www.diviengine.com');
defined('DE_DF_P') or define('DE_DF_P', 'd_e');

// IF BC
if (defined('DE_DB_WOO_VERSION')) {
// IF MACHINE
} else if (defined('DE_DMACH_VERSION')) {
  include(DE_DF_PATH . '/includes/classes/init.class.php');
} else {

    /* m_a Remove */
    include(DE_DF_PATH . '/includes/classes/class.wooslt.php');
    include(DE_DF_PATH . '/includes/classes/class.licence.php');
    include(DE_DF_PATH . '/includes/classes/class.options.php');
    include(DE_DF_PATH . '/includes/classes/class.updater.php');    
    require_once plugin_dir_path( __FILE__ ) . 'includes/daf-settings.php';
    /* m_a Remove */

    include(DE_DF_PATH . '/includes/classes/init.class.php');
    
    add_action( 'admin_enqueue_scripts', 'load_divi_engine_style_divi_filter' , 20);
    function load_divi_engine_style_divi_filter() {
        $cssfile = plugins_url( 'css/divi-engine.min.css', __FILE__ );
        wp_enqueue_style( 'divi_engine_style', $cssfile , false, DE_DF_VERSION );
    }
    
}


// initialise Divi Modules
if ( !function_exists( 'de_df_initialise_ext' ) ) {
    function de_df_initialise_ext()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/DiviFilterModules.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/loader.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/ajaxcalls/post_ajax.php';

        if ( defined('DE_DB_WOO_VERSION')) {
            $db_settings = get_option( 'divi-bodyshop-woo_options' );
            $enable_variation_swatches = unserialize( $db_settings );
            if ( isset( $enable_variation_swatches['enable_variation_swatches'][0] ) ) {
                $check_enable_variation_swatches = $enable_variation_swatches['enable_variation_swatches'][0];
            }else { $check_enable_variation_swatches = "1"; }
            if ($check_enable_variation_swatches == "0") {
                require_once dirname( __FILE__ ) .'/lib/variation-swatches.php';
                require_once dirname( __FILE__ ) .'/includes/classes/class-wvs-term-meta.php';
            }
        }else{

            require_once dirname( __FILE__ ) .'/lib/variation-swatches.php';
            require_once dirname( __FILE__ ) .'/includes/classes/class-wvs-term-meta.php';
        }
    }
}

if ( !class_exists( 'DiviExtension' ) ){
    add_action( 'divi_extensions_init', 'de_df_initialise_ext' );
}else{
    de_df_initialise_ext();
}

if(!class_exists('DiviAjaxFilter_Admin')){
    require_once plugin_dir_path( __FILE__ ) .  'class.daf-admin.php';
    new DiviAjaxFilter_Admin;
}

require_once plugin_dir_path( __FILE__ ) .  'daf-page-settings.php';

if ( !function_exists('divi_filter_load_actions_ajax') ) {
    function divi_filter_load_actions_ajax( $actions ) {
        $filter_handler_exist = false;
        $modal_handler_exist = false;
        $loadmore_handler_exist = false;
        $filter_counter_handler_exist = false;
        $filter_get_sub_category_handler_exist = false;
        $ajax_marker_layout_ajax_handler_exist = false;

        foreach ($actions as $key => $action) {
          if ( $action == 'divi_filter_ajax_handler' )
            $filter_handler_exist = true;
          if ( $action == 'divi_filter_get_post_modal_ajax_handler' )
            $modal_handler_exist = true;
          if ( $action == 'divi_filter_loadmore_ajax_handler')
            $loadmore_handler_exist = true;
          if ( $action == 'divi_filter_get_count_ajax_handler')
            $filter_counter_handler_exist = true;
          if ( $action == 'divi_filter_get_sub_category_handler')
            $filter_get_sub_category_handler_exist = true;
            if ( $action == 'ajax_marker_layout_ajax_handler')
            $ajax_marker_layout_ajax_handler_exist = true;
        }

        if ( !$filter_handler_exist )
          $actions[] = 'divi_filter_ajax_handler';

        if ( !$modal_handler_exist )
          $actions[] = 'divi_filter_get_post_modal_ajax_handler';

        if ( !$loadmore_handler_exist )
          $actions[] = 'divi_filter_loadmore_ajax_handler';

        if ( !$filter_counter_handler_exist )
          $actions[] = 'divi_filter_get_count_ajax_handler';

        if ( !$filter_get_sub_category_handler_exist )
          $actions[] = 'divi_filter_get_sub_category_handler';

          if ( !$ajax_marker_layout_ajax_handler_exist )
            $actions[] = 'ajax_marker_layout_ajax_handler';

        return $actions;
    }

    add_filter( 'et_builder_load_actions', 'divi_filter_load_actions_ajax' );
}

if ( !function_exists('bodycommerce_wpml_currency_ajax_actions')) {
  function bodycommerce_wpml_currency_ajax_actions( $actions ) {
    $actions[] = 'divi_filter_ajax_handler';
    $actions[] = 'divi_filter_get_post_modal_ajax_handler';
    $actions[] = 'divi_filter_loadmore_ajax_handler';
    $actions[] = 'divi_filter_get_sub_category_handler';
    $actions[] = 'ajax_marker_layout_ajax_handler';

    return $actions;
  }

  add_filter( 'wcml_multi_currency_ajax_actions', 'bodycommerce_wpml_currency_ajax_actions', 10, 1 );
}

if ( !function_exists('divi_filter_enqueue_scripts') ) {
  function divi_filter_enqueue_scripts() {
      wp_register_script( 'divi-filter-rangeSlider-js', plugins_url('/js/ion.rangeSlider.min.js', __FILE__ ), array( 'jquery' ), DE_DF_VERSION, true );
      wp_register_style( 'divi-filter-rangeSlider-css', plugins_url( '/css/ion.rangeSlider.min.css' , __FILE__ ), array(), DE_DF_VERSION, 'all' );
      
      wp_register_script( 'divi-filter-select2-js', plugins_url('/js/select2.min.js', __FILE__ ), array( 'jquery' ), DE_DF_VERSION );
      wp_register_style( 'divi-filter-select2-css', plugins_url( '/css/select2.min.css' , __FILE__ ), array(), DE_DF_VERSION, 'all' );
  }
  add_action( 'wp_enqueue_scripts', 'divi_filter_enqueue_scripts' );    
}


/*

register_uninstall_hook( __FILE__, 'df_uninstall_hook' );
register_deactivation_hook( __FILE__, 'df_deactivation_hook' );

function df_uninstall_hook() {
}

function df_deactivation_hook() {
}*/

if ( !function_exists('Divi_filter_remove_get_params')) {
    add_filter( 'query_vars', 'Divi_filter_remove_get_params', 10, 1 );

    function Divi_filter_remove_get_params( $query ){
        global $divi_filter_removed_param;
        $divi_filter_removed_param = array();
        $is_search_page = false;
        if ( !empty( $_GET['filter' ] ) && $_GET['filter' ] == 'true'){
            $is_geolocation_enabled = false;
            if ( class_exists('WC_Admin_Settings') ) {
                $geolocation_setting = WC_Admin_Settings::get_option( 'woocommerce_default_customer_address', '' );

                if ( $geolocation_setting == 'geolocation_ajax') {
                    $is_geolocation_enabled = true;
                }
            }
            if ( isset( $_GET['is_search'] ) && $_GET['is_search'] == 'true' ) {
               $is_search_page = true;
            }
            foreach ($_GET as $key => $param) {
                if ( $key != 'filter'){
                    if ( ( $is_search_page == false || ( $is_search_page == true && $key != 's' ) ) && !( $is_geolocation_enabled == true && $key == 'v' ) ){
                        $divi_filter_removed_param[$key] = $param;
                        unset($_GET[$key]);
                    }
                }
            }

            $divi_filter_removed_param['filter'] = 'true';
            unset( $_GET['filter'] );
        }
        return $query;
  }  
}

// Price filter

if ( !function_exists( 'bodycommerce_product_search_join' ) ) {
    function bodycommerce_product_search_join( $join, $query ) {
    
        global $price_filter_var;
        global $wpdb;

        if ( ( is_array( $query->query_vars['post_type'] ) && in_array( 'product', $query->query_vars['post_type'] ) ) || $query->query_vars['post_type'] == 'product') {
            if ( isset($price_filter_var['is_filter']) && $price_filter_var['is_filter'] ) {
                $join  .= " LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup ON $wpdb->posts.ID = wc_product_meta_lookup.product_id ";    
            }
        }

        if ( ! $query->is_main_query() || is_admin() || ! is_search() || ( !function_exists('is_woocommerce') || (function_exists('is_woocommerce') && ! is_woocommerce() ) ) ) {
            return $join;
        }

        $join .= " LEFT JOIN {$wpdb->postmeta} iconic_post_meta ON {$wpdb->posts}.ID = iconic_post_meta.post_id ";
        return $join;
    }
    add_filter( 'posts_join', 'bodycommerce_product_search_join', 10, 2 );
}

if ( !function_exists('bodycommerce_product_search_where') ) {
    function bodycommerce_product_search_where( $where, $query ) {

        global $price_filter_var;
        global $wpdb;

        if ( ( is_array( $query->query_vars['post_type'] ) && in_array( 'product', $query->query_vars['post_type'] ) ) || $query->query_vars['post_type'] == 'product') {
            if ( isset($price_filter_var['is_filter']) && $price_filter_var['is_filter']) {
                $where .= $wpdb->prepare(
                    ' AND NOT (%f>wc_product_meta_lookup.min_price OR %f<wc_product_meta_lookup.max_price ) ',
                    $price_filter_var['min_price'],
                    $price_filter_var['max_price']
                );
            }
        }

        if ( ! $query->is_main_query() || is_admin() || ! is_search() || ( !function_exists('is_woocommerce') || (function_exists('is_woocommerce') && ! is_woocommerce() ) ) ) {
            return $where;
        }        
        
        $where = preg_replace(
            "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "({$wpdb->posts}.post_title LIKE $1) OR (iconic_post_meta.meta_key = '_sku' AND iconic_post_meta.meta_value LIKE $1)", $where );

        return $where;
    }
    add_filter( 'posts_where', 'bodycommerce_product_search_where', 10, 2 );
}

if ( !function_exists('divi_filter_dynamic_css_assets')) {
    /**
     * Force load Contact Form module styles.
     *
     * @return array
     */
    function divi_filter_dynamic_css_assets( $modules ) {
        array_push( $modules, 'et_pb_contact_form' );
        return $modules;
    }
    add_filter( 'et_required_module_assets', 'divi_filter_dynamic_css_assets', 99 );
}

if ( !function_exists('divi_filter_dynamic_css_assets_atf')) {
    /**
     * Force load Contact Form module styles above the fold.
     *
     * @return array
     */
    function divi_filter_dynamic_css_assets_atf( $atf_modules ) {
        array_push( $atf_modules, 'et_pb_contact_form' );
        return $atf_modules;
    }
    add_filter( 'et_dynamic_assets_modules_atf', 'divi_filter_dynamic_css_assets_atf', 20 );
}

if ( !function_exists('custom_wpkses_post_tags')) {
function custom_wpkses_post_tags( $tags, $context ) {

    $allowed_atts = array(
        'align'      => true,
        'class'      => true,
        'type'       => true,
        'id'         => true,
        'dir'        => true,
        'lang'       => true,
        'style'      => true,
        'xml:lang'   => true,
        'src'        => true,
        'alt'        => true,
        'href'       => true,
        'rel'        => true,
        'rev'        => true,
        'target'     => true,
        'novalidate' => true,
        'type'       => true,
        'value'      => true,
        'name'       => true,
        'tabindex'   => true,
        'action'     => true,
        'method'     => true,
        'for'        => true,
        'width'      => true,
        'height'     => true,
        'data'       => true,
        'data-*'     => true,
        'title'      => true,
        'for'        => true
    );

	if ( 'post' === $context ) {
		$tags['form']     = $allowed_atts;
        $tags['label']    = $allowed_atts;
        $tags['select']   = $allowed_atts;
        $tags['option']   = $allowed_atts;
        $tags['input']    = $allowed_atts;
        $tags['textarea'] = $allowed_atts;
        $tags['iframe']   = $allowed_atts;
        $tags['script']   = $allowed_atts;
        $tags['style']    = $allowed_atts;
        $tags['strong']   = $allowed_atts;
        $tags['small']    = $allowed_atts;
        $tags['table']    = $allowed_atts;
        $tags['span']     = $allowed_atts;
        $tags['abbr']     = $allowed_atts;
        $tags['code']     = $allowed_atts;
        $tags['pre']      = $allowed_atts;
        $tags['div']      = $allowed_atts;
        $tags['img']      = $allowed_atts;
        $tags['h1']       = $allowed_atts;
        $tags['h2']       = $allowed_atts;
        $tags['h3']       = $allowed_atts;
        $tags['h4']       = $allowed_atts;
        $tags['h5']       = $allowed_atts;
        $tags['h6']       = $allowed_atts;
        $tags['ol']       = $allowed_atts;
        $tags['ul']       = $allowed_atts;
        $tags['li']       = $allowed_atts;
        $tags['em']       = $allowed_atts;
        $tags['hr']       = $allowed_atts;
        $tags['br']       = $allowed_atts;
        $tags['tr']       = $allowed_atts;
        $tags['td']       = $allowed_atts;
        $tags['p']        = $allowed_atts;
        $tags['a']        = $allowed_atts;
        $tags['b']        = $allowed_atts;
        $tags['i']        = $allowed_atts;
	}

	return $tags;

}

add_filter( 'wp_kses_allowed_html', 'custom_wpkses_post_tags', 10, 2 );
}

if ( !function_exists( 'de_get_option_value' ) ) {
	function de_get_option_value( $plugin_name, $option_name ) {
		global $deGlobalOptions;

		if ( !isset( $deGlobalOptions[ $plugin_name ] ) ) {
			$deGlobalOptions[ $plugin_name ] = maybe_unserialize( get_option( $plugin_name . '_options' ) );
		}

		return isset( $deGlobalOptions[ $plugin_name ][ $option_name ] )?$deGlobalOptions[ $plugin_name ][ $option_name ]:'';
	}
}

/* m_a Remove */
if (defined('DE_DB_WOO_VERSION')) {
} else if (defined('DE_DMACH_VERSION')) {
} else {
        global $DE_DF;
        $DE_DF = new DE_DF();
}
/* m_a Remove */


if ( !function_exists( 'de_change_locale' ) ) {
    add_filter('determine_locale', 'de_change_locale', 9999, 1);
    function de_change_locale( $locale ) {
        if ( wp_doing_ajax() && isset($_REQUEST['action']) && $_REQUEST['action'] == 'divi_filter_ajax_handler' ) {
            $locale = get_locale();
        }

        return $locale;
    }
}