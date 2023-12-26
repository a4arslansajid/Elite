<?php
/* 
Plugin Name: Divi Machine
Plugin URL: https://diviengine.com/product/divi-machine/
Description: Use Divi Machine to Create Dynamic Content with Divi and Advanced Custom Fields.
Version: 5.4.3
Requires PHP: 7.0
Author: Divi Engine
Author URI: https://diviengine.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: divi-machine
Domain Path: /languages
@author      diviengine.com
@copyright   2020 diviengine.com

I pray that you bless the people who interact and who own this website - I pray the blessing to be one that goes beyond worldly treasures but understanding the deep love you have for them.

John 14:6
I am the way, and the truth, and the life. No one comes to the Father except through me.
*/


if ( ! defined( 'ABSPATH' ) ) exit;

define('DE_DMACH_VERSION', '5.4.3');

define('DE_DMACH_AUTHOR', 'Divi Engine' );
define('DE_DMACH_PATH',   plugin_dir_path(__FILE__));
define('DE_DMACH_PATH_URL',    plugins_url('', __FILE__));
define('DE_DMACH_PRODUCT_ID','WP-DE-DMACH');
define('DE_DMACH_INSTANCE', str_replace(array ("https://" , "http://"), "", home_url()));
define('DE_DMACH_PRODUCT_URL', 'https://diviengine.com/product/divi-machine/' );
define('DE_DMACH_APP_API_URL', 'https://diviengine.com/index.php');
define('DE_DMACH_URL', 'https://www.diviengine.com' );
define('DE_DM_P', 'd_e');
define('DE_DMACH_NAME',plugin_basename( __FILE__ ));



function acf_missing_notice_divi_machine() {
    echo '<div class="error"><p><strong>' . sprintf(esc_html__('Divi Machine requires ACF to be installed and active. You can download %s here.', 'divi-machine'), '<a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">Advanced Custom Fields</a>') . '</strong></p></div>';
}

function divi_missing_notice_divi_machine() {
  echo '<div class="error"><p><strong>' . sprintf(esc_html__('Divi Machine requires Divi Theme to be installed and active.', 'divi-machine')) . '</strong></p></div>';
}

/**
 * Check if ACF or Divi is installed.
 *
 * @see    acf_missing_notice_divi_machine
 * @return void
 */
if( !class_exists('acf') ) {
    add_filter('acf/format_value/type=textarea', 'do_shortcode');
    add_action('admin_notices', 'acf_missing_notice_divi_machine');
    return;
}

register_activation_hook( __FILE__, 'divimachine_activate_hook' );
function divimachine_activate_hook() {
    flush_rewrite_rules();
}


include(DE_DMACH_PATH . '/includes/classes/init.class.php');
include(DE_DMACH_PATH . '/includes/classes/class.wooslt.php');
include(DE_DMACH_PATH . '/includes/classes/class.licence.php');
include(DE_DMACH_PATH . '/includes/classes/class.options.php');
include(DE_DMACH_PATH . '/includes/classes/class.updater.php');

include(DE_DMACH_PATH . '/includes/classes/acf_fields.php');


require_once dirname( __FILE__ ) .'/divi-machine-options.php';
include(DE_DMACH_PATH . '/settings/settings.php');
require_once dirname( __FILE__ ) .'/functions.php';

require_once dirname( __FILE__ ) .'/lib/custom-post.php';
require_once dirname( __FILE__ ) .'/lib/create-post.php';
require_once dirname( __FILE__ ) .'/lib/custom-css-js.php';

require_once dirname( __FILE__ ) .'/includes/ajaxcalls/post-ajax.php';


// initialise Divi Modules
if ( !function_exists( 'de_dm_initialise_ext' ) ) {
    function de_dm_initialise_ext()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/DiviMachineModules.php';
    }
    add_action( 'divi_extensions_init', 'de_dm_initialise_ext' );
}

if ( !function_exists('de_dm_load_actions_ajax')) {
  function de_dm_load_actions_ajax( $actions ) {
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

  add_filter( 'et_builder_load_actions', 'de_dm_load_actions_ajax' );
}

$get_divi_engine_css = get_option('divi-engine-css', null);
if ($get_divi_engine_css == "" || $get_divi_engine_css == "machine-added" ) {
    update_option('divi-engine-css', 'machine-added');

    add_action( 'admin_enqueue_scripts', 'load_divi_engine_style_machine' , 20);
    function load_divi_engine_style_machine($hook_suffix) {
    
      global $pagenow;

        if ( 'post-new.php' === $pagenow && 'dmach_post' === get_post_type( $_GET['post'] ) || 'post.php' === $pagenow && isset($_GET['post']) && 'dmach_post' === get_post_type( $_GET['post'] ) ||'post-new.php' === $pagenow && 'dmach_tax' === get_post_type( $_GET['post'] ) || 'post.php' === $pagenow && isset($_GET['post']) && 'dmach_tax' === get_post_type( $_GET['post'] ) ) { 

          wp_register_style( 'dmach_cpt_admin_css', DE_DMACH_PATH_URL . '/css/admin.min.css', false, DE_DMACH_VERSION );
          wp_enqueue_style( 'dmach_cpt_admin_css' );
          
          wp_enqueue_script( 'dmach_admin_js', plugins_url( '/js/cpt-admin.min.js', __FILE__ ), array( 'jquery' ), DE_DMACH_VERSION );


        }

      $cssfile = plugins_url( 'css/divi-engine.min.css', __FILE__ );
      wp_enqueue_style( 'divi_engine_admin_css', $cssfile , false, DE_DMACH_VERSION );
    }
}


add_action( 'admin_enqueue_scripts', 'divi_machine_admin_scripts' , 20);
function divi_machine_admin_scripts($hook_suffix) {

    $jsfile = plugins_url( 'js/admin.min.js', __FILE__ );
    $importjsfile = plugins_url( 'js/import_export.js', __FILE__ );
    wp_enqueue_script( 'divi-machine-admin-script', $jsfile, array( 'jquery' ), DE_DMACH_VERSION );
    wp_enqueue_script( 'divi-machine-admin-import-export', $importjsfile, array( 'jquery' ), DE_DMACH_VERSION );


}

add_action( 'wp_enqueue_scripts', 'divi_machine_masonry_js' );

function divi_machine_masonry_js() {

  wp_enqueue_script( 'divi-filter-masonry-js', plugins_url('\includes\modules\divi-ajax-filter\js\masonry.min.js', __FILE__ ), array( 'jquery' ), DE_DMACH_VERSION );

}

add_filter( 'post_type_link', 'divi_machine_remove_baseslug', 20, 3 );

function divi_machine_remove_baseslug( $permalink, $post, $leavename ){
  global $wp_post_types;
  if (!isset( $_GET['et_fb'] )) {
    foreach( $wp_post_types as $type => $custom_post ){
      if( $custom_post->_builtin == false && $custom_post->name == 'dmach_post'){
        if ( is_array($custom_post->rewrite) && isset( $custom_post->rewrite['slug'] ) ) {
          $custom_post->rewrite['slug'] = trim( $custom_post->rewrite['slug'], '/' );
          $permalink = str_replace( '/' . $custom_post->rewrite['slug'] . '/', '/', $permalink );
        }
      }
    }
    return $permalink;
  } else {
    return $permalink;
  }
}


////////////////////////////////////////////////

// GET QUERY VARS

function divi_machine_add_query_vars_filter( $vars ){
  
if ( !empty( $_GET['filter'] ) && $_GET['filter'] == 'true' ) {
  if ( !empty( $vars['s'] ) ) {
    unset( $vars['s'] );
  }
}
return $vars;

}
add_filter( 'request', 'divi_machine_add_query_vars_filter' );

// END GET QUERY VARS

$acf_fields = array();
$field_groups = acf_get_field_groups();

foreach ( $field_groups as $group ) {
  // DO NOT USE here: $fields = acf_get_fields($group['key']);
  // because it causes repeater field bugs and returns "trashed" fields
  $fields = get_posts(array(
    'posts_per_page'   => -1,
    'post_type'        => 'acf-field',
    'orderby'          => 'menu_order',
    'order'            => 'ASC',
    'suppress_filters' => true, // DO NOT allow WPML to modify the query
    'post_parent'      => $group['ID'],
    'post_status'      => 'any',
    'update_post_meta_cache' => false
  ));


  foreach ( $fields as $field ) {
    $acf_fields[$field->post_name] = $field->post_excerpt;
  }
}


// array of filters (field key => field name)
$GLOBALS['my_query_filters'] = $acf_fields;

add_action( 'parse_tax_query', 'dmach_parse_tax_query', 10);
function dmach_parse_tax_query( $query ){
    if ( isset( $_GET['filter'] ) && $_GET['filter'] == "true" ){
        $post_type = isset($query->query_vars['post_type'])?$query->query_vars['post_type']:''; 
        if ( !empty( $post_type ) ){
          if ( !is_array( $post_type ) ) {
            $post_type = array( $post_type );
          }
          $categories_array = array();
          foreach( $post_type as $i => $type ) {
            if ( $type == 'post' ) {
              $categories_array[] = 'category';
            }else {
              $categories_array[] = $type . '_category';  
            }            
          }
          foreach ($query->tax_query->queries as $key => $tax_query) {
              if (!($categories_array)) {
                  if (in_array( $tax_query['taxonomy'], $categories_array )) {
                      if (isset($tax_query['taxonomy'])) {
                          if (!isset($GLOBALS['my_query_filters']['tax_query']) || !in_array($tax_query['taxonomy'], $GLOBALS['my_query_filters']['tax_query'])) {
                              unset($query->tax_query->queries[$key]);
                          }
                      }
                  }
              }
          }
        }
    }

}

///////////////////////////////////////////////


/**
 * [list_searcheable_acf list all the custom fields we want to include in our search query]
 * @return [array] [list of custom fields]
 */
function list_searcheable_acf(){


  $list_searcheable_acf = array();
  $field_groups = acf_get_field_groups();
  foreach ( $field_groups as $group ) {
    // DO NOT USE here: $fields = acf_get_fields($group['key']);
    // because it causes repeater field bugs and returns "trashed" fields
    $fields = get_posts(array(
      'posts_per_page'   => -1,
      'post_type'        => 'acf-field',
      'orderby'          => 'menu_order',
      'order'            => 'ASC',
      'suppress_filters' => true, // DO NOT allow WPML to modify the query
      'post_parent'      => $group['ID'],
      'post_status'      => 'any',
      'update_post_meta_cache' => false
    ));
    foreach ( $fields as $field ) {
      $list_searcheable_acf[] = $field->post_excerpt;
    }
  }


  return $list_searcheable_acf;
}


/**
 * [advanced_custom_search search that encompasses ACF/advanced custom fields and taxonomies and split expression before request]
 * @param  [query-part/string]      $where    [the initial "where" part of the search query]
 * @param  [object]                 $wp_query []
 * @return [query-part/string]      $where    [the "where" part of the search query as we customized]
 * see https://vzurczak.wordpress.com/2013/06/15/extend-the-default-wordpress-search/
 * credits to Vincent Zurczak for the base query structure/spliting tags section
 */
function dmach_advanced_custom_search( $where, $wp_query ) {

    global $wpdb, $current_screen;

    // get search expression
    $terms = $wp_query->query_vars[ 's' ];

    if ( empty( $terms ) ){
      return $where;
    }

    if (!empty( $current_screen ) && $current_screen->base == 'edit' && substr($current_screen->id, 0, 4) == 'edit' ){
      return $where;
    }

    $terms = addslashes( $terms );

    // reset search in order to rebuilt it as we whish
    $where = '';

    $search_enable_post_common = de_get_option_value( 'divi-machine', 'search_enable_post_common');

    if ( !empty($search_enable_post_common) ) {
      $search_enable_post_content = $search_enable_post_common['content'];
      $search_enable_post_excerpt = $search_enable_post_common['excerpt'];
      $search_enable_taxonomy = $search_enable_post_common['taxonomy'];
      $search_enable_comments = $search_enable_post_common['comments'];
    } else {
      $search_enable_post_content = de_get_option_value( 'divi-machine', 'search_enable_post_content');
      $search_enable_post_excerpt = de_get_option_value( 'divi-machine', 'search_enable_post_excerpt');
      $search_enable_taxonomy = de_get_option_value( 'divi-machine', 'search_enable_taxonomy');
      $search_enable_comments = de_get_option_value( 'divi-machine', 'search_enable_comments');
    }

    $where .= "({$wpdb->posts}.post_title LIKE '%$terms%')";

    if ( $search_enable_post_content == '1' ) {
      $where .= " OR ({$wpdb->posts}.post_content LIKE '%$terms%')";
    }

    if ( $search_enable_post_excerpt == '1') {
      $where .= " OR ({$wpdb->posts}.post_excerpt LIKE '%$terms%')";
    }

    if ( $search_enable_taxonomy == '1' ) {
      $where .= " OR {$wpdb->posts}.ID IN (
          SELECT object_id FROM $wpdb->terms
          INNER JOIN $wpdb->term_taxonomy
            ON {$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id
          INNER JOIN $wpdb->term_relationships
            ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_taxonomy_id
          WHERE {$wpdb->terms}.name LIKE '%$terms%'
    )";
    }

    if ( $search_enable_comments == '1' ) {
      $where .= " OR {$wpdb->posts}.ID IN (
                    SELECT comment_post_ID FROM $wpdb->comments
                    WHERE comment_content LIKE '%$terms%'
                  )";
    }

    // get searcheable_acf, a list of advanced custom fields you want to search content in

    $search_enable_acf_groups = de_get_option_value( 'divi-machine', 'search_enable_acf_group' );

    $i = 0;

    $field_groups = acf_get_field_groups();
    foreach ( $field_groups as $group ) {
      if ( !empty( $search_enable_acf_groups ) ) {
        $search_enable_group = $search_enable_acf_groups[ $group['key'] ];
      } else {
        $search_enable_group = de_get_option_value( 'divi-machine', 'search_enable_' . $group['key'] );
      }      

      if ( $search_enable_group ) {
        if ( $i == 0 ) {
          $where .= " OR {$wpdb->posts}.ID IN (
                        SELECT post_id FROM $wpdb->postmeta
                          WHERE ";
        }
        $fields = get_posts(array(
          'posts_per_page'   => -1,
          'post_type'        => 'acf-field',
          'orderby'          => 'menu_order',
          'order'            => 'ASC',
          'suppress_filters' => true, // DO NOT allow WPML to modify the query
          'post_parent'      => $group['ID'],
          'post_status'      => 'any',
          'update_post_meta_cache' => false
        ));
        foreach ( $fields as $field ) {
          if ( $i == 0 ) {
            $where .= " (meta_key LIKE '%" . $field->post_excerpt . "%' AND meta_value LIKE '%$terms%')";
          } else {
            $where .= " OR (meta_key LIKE '%" . $field->post_excerpt . "%' AND meta_value LIKE '%$terms%')";
          }

          $i++;
        }
      }
    }

    if ( $i !== 0 ) {
      $where .= " )";
    }

    $where = " AND ( " . $where . " )";

    return $where;
}

add_filter( 'posts_search', 'dmach_advanced_custom_search', 20, 2 );

function dmach_load_actions_ajax( $actions ) {
  $actions[] = 'divi_machine_filterposts_handler';
  $actions[] = 'divi_machine_get_post_modal_ajax_handler';
  $actions[] = 'divi_machine_loadmore_ajax_handler';

  return $actions;
}
add_filter( 'et_builder_load_actions', 'dmach_load_actions_ajax' );


function machine_internet_explorer_jquery() {
?>
<script>
jQuery(document).ready(function(i){const c=window.navigator.userAgent;function t(c){i(".et_pb_de_mach_archive_loop").each(function(t,s){var e,n,o,d=i(this).find(".dmach-grid-item"),h=(e=i(".dmach-grid-sizes"),n=c,o=void 0,i(e.attr("class").split(" ")).each(function(){this.indexOf(n)>-1&&(o=this)}),o).replace(c,""),a=1,r=1;i(d).each(function(i,c){a++});var l=Math.ceil(a/h),m=l*h;i(d).each(function(c,t){var s=(r-1)%h+1,e=Math.ceil(r*l/m);i(this).closest(".grid-posts").find(".dmach-grid-item:nth-child("+r+")").css("-ms-grid-row",""+e),i(this).closest(".grid-posts").find(".dmach-grid-item:nth-child("+r+")").css("-ms-grid-column",""+s),r++})})}/MSIE|Trident/.test(c)&&i(window).on("resize",function(){i(window).width()>=981?(col_size="col-desk-",t(col_size)):(col_size="col-mob-",t(col_size))})});
</script>
<?php
  }
  add_action('wp_head', 'machine_internet_explorer_jquery');


function machine_internet_explorer_css() {
?>

<style>
.col-desk-1>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr}.col-desk-2>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr 1fr}.col-desk-3>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr}.col-desk-4>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr 1fr}.col-desk-5>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr 1fr 1fr}.col-desk-6>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr 1fr 1fr 1fr}@media(max-width:980px){body .col-mob-1>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr}body .col-mob-2>:not(.no-results-layout){display:-ms-grid;-ms-grid-columns:1fr 1fr}}@media screen and (-ms-high-contrast:active),(-ms-high-contrast:none){.et_pb_gutters4 .dmach-grid-sizes>:not(.no-results-layout)>div{margin-left:8%!important;margin-right:8%!important}.et_pb_gutters3 .dmach-grid-sizes>:not(.no-results-layout)>div{margin-left:5.5%!important;margin-right:5.5%!important}.et_pb_gutters2 .dmach-grid-sizes>:not(.no-results-layout)>div{margin-left:3%!important;margin-right:3%!important}.et_pb_gutters1 .dmach-grid-sizes>:not(.no-results-layout)>div{margin-left:0!important;margin-right:0!important}}
</style>

<?php
}
add_action('wp_head', 'machine_internet_explorer_css');


function dmach_acf_map_key() {
  $et_google_api_settings = get_option( 'et_google_api_settings' );
  if ( isset( $et_google_api_settings['api_key'] ) ) {
    acf_update_setting('google_api_key', $et_google_api_settings['api_key']);
    wp_register_script('dmach_js_googlemaps_script',  'https://maps.googleapis.com/maps/api/js?key='.$et_google_api_settings['api_key'].'&libraries=places&callback=initAutocomplete', array('divi-filter-js')); // with Google Maps API fix
  }
}
add_action('acf/init', 'dmach_acf_map_key');




//populate divi module with ACF field
add_filter('et_pb_module_shortcode_attributes', 'dmach_divi_modules_acf', 20, 3);

function dmach_divi_modules_acf($dmach_props, $cd_atts, $get_slug) {

    $dmach_map_acf = de_get_option_value('divi-machine', 'dmach_map_acf'); // $titan->getOption( 'dmach_map_acf' );
    $dmach_post_type = de_get_option_value('divi-machine', 'dmach_post_type'); // $titan->getOption( 'dmach_post_type' );
    $dmach_post_type_custom = de_get_option_value('divi-machine', 'dmach_post_type_custom'); // $titan->getOption( 'dmach_post_type_custom' );

    if ($dmach_post_type_custom !== "") {
      $dmach_post_type = $dmach_post_type_custom;
    }

    if ($dmach_map_acf !== "none") {

        $location = get_field($dmach_map_acf);

        $dmach_module_slug = array('et_pb_map_pin', 'et_pb_map', 'et_pb_fullwidth_map');

        if (!in_array($get_slug, $dmach_module_slug)) {
            return $dmach_props;
        }

        if ( get_post_type() == $dmach_post_type && is_array($location) ) {
            $dmach_props['pin_address_lat'] = esc_attr($location['lat']);
            $dmach_props['pin_address_lng'] = esc_attr($location['lng']);


                $dmach_props['address_lat'] = esc_attr( $location['lat'] );
                $dmach_props['address_lng'] = esc_attr( $location['lng'] );
                $dmach_props['address'] = esc_attr( $location['address'] );




            return $dmach_props;
        }else return $dmach_props;
    }else return $dmach_props;
}


// function to add the expired date and time to the divi countdown timer
add_filter('et_pb_module_shortcode_attributes', 'dmach_countdown_timer_acf', 20, 3);

function dmach_countdown_timer_acf($dmach_props, $cd_atts, $cd_slug) {
  
  $dmach_countdown_acf = de_get_option_value('divi-machine', 'dmach_countdown_acf'); // $titan->getOption( 'dmach_countdown_acf' );
  $dmach_countdown_post_type = de_get_option_value('divi-machine', 'dmach_countdown_post_type'); // $titan->getOption( 'dmach_countdown_post_type' );
  $dmach_countdown_post_type_custom = de_get_option_value('divi-machine', 'dmach_countdown_post_type_custom'); // $titan->getOption( 'dmach_countdown_post_type_custom' );

  if ($dmach_countdown_post_type_custom !== "") {
    $dmach_countdown_post_type = $dmach_countdown_post_type_custom;
  }

  if ($dmach_countdown_acf !== "none") {
    $cd_module_slugs = array('et_pb_countdown_timer');
    if (!in_array($cd_slug, $cd_module_slugs)) {
      return $dmach_props;
    }
    if ( get_post_type() == $dmach_countdown_post_type && $dmach_countdown_acf != "" ) {
      $dmach_props['date_time'] = get_field($dmach_countdown_acf, false, false);
      return $dmach_props;
    } else return $dmach_props;
  } else return $dmach_props;
}

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

register_deactivation_hook( __FILE__, 'machine_deactivate_hook' );


function machine_deactivate_hook() {
delete_option( 'divi-engine-menu' );
delete_option( 'divi-engine-css' );
}

$get_divi_settings = get_option( 'et_divi' );
if ( array_key_exists("divi_disable_translations", $get_divi_settings) ) {
	$divi_disable_translations = $get_divi_settings['divi_disable_translations'];
}

if (isset($divi_disable_translations) && $divi_disable_translations !== 'on') {
function machine_load_languages() {
load_plugin_textdomain( 'divi-machine', false, basename( dirname( __FILE__ ) ) . '/languages' );
load_plugin_textdomain( 'titan-framework', false, basename( dirname( __FILE__ ) ) . '/titan-framework/languages' );
}
add_action( 'plugins_loaded', 'machine_load_languages' );
}

if ( !function_exists('divi_filter_map_search_join') ) {
  function divi_filter_map_search_join( $join, $query ) {

      global $address_filter_var;
      global $wpdb;

      if ( isset($address_filter_var['is_filter']) && $address_filter_var['is_filter'] ) {
          $join  .= " LEFT JOIN (
            SELECT
              pm.post_id,
              SUBSTRING_INDEX(
                  SUBSTRING(pm.meta_value, ( INSTR( pm.meta_value, CONCAT( 'lat', '\";' )  ) + 7 ) ),
                ';', 1 ) AS lat,
              SUBSTRING_INDEX(
                  SUBSTRING(pm.meta_value, ( INSTR( pm.meta_value, CONCAT( 'lng', '\";' )  ) + 7 ) ),
                ';', 1 ) AS lng
            FROM {$wpdb->postmeta} pm
            WHERE pm.meta_key = '". $address_filter_var['address_field'] . "'
          ) as latlng ON {$wpdb->posts}.ID = latlng.post_id
          ";
      }

      return $join;
  }
  add_filter( 'posts_join', 'divi_filter_map_search_join', 9, 2 );
}

if ( !function_exists('divi_filter_map_search_where') ) {
  function divi_filter_map_search_where( $where, $query ) {

      global $address_filter_var;
      global $wpdb;

      if ( isset($address_filter_var['is_filter']) && $address_filter_var['is_filter']) {
        $earth_radius = 3959; //In Miles
        if ( $address_filter_var['radius_unit'] == 'km' ) {
          $earth_radius = 6371;
        }

        if ( strpos( $address_filter_var['radius'], ';' ) ) {
          $radius_val = explode(';', $address_filter_var['radius']);
          $radius_from = $radius_val[0];
          $radius_to = $radius_val[1];

          $where .= $wpdb->prepare(
              ' AND acos(cos(%f * (PI()/180)) *
                     cos(%f * (PI()/180)) *
                     cos(latlng.lat * (PI()/180)) *
                     cos(latlng.lng * (PI()/180))
                     +
                     cos(%f * (PI()/180)) *
                     sin(%f * (PI()/180)) *
                     cos(latlng.lat * (PI()/180)) *
                     sin(latlng.lng * (PI()/180))
                     +
                     sin(%f * (PI()/180)) *
                     sin(latlng.lat * (PI()/180))
                    ) * %d < %d
                AND acos(cos(%f * (PI()/180)) *
                     cos(%f * (PI()/180)) *
                     cos(latlng.lat * (PI()/180)) *
                     cos(latlng.lng * (PI()/180))
                     +
                     cos(%f * (PI()/180)) *
                     sin(%f * (PI()/180)) *
                     cos(latlng.lat * (PI()/180)) *
                     sin(latlng.lng * (PI()/180))
                     +
                     sin(%f * (PI()/180)) *
                     sin(latlng.lat * (PI()/180))
                    ) * %d > %d',
              $address_filter_var['lat'],
              $address_filter_var['lng'],
              $address_filter_var['lat'],
              $address_filter_var['lng'],
              $address_filter_var['lat'],
              $earth_radius,
              $radius_to,
              $address_filter_var['lat'],
              $address_filter_var['lng'],
              $address_filter_var['lat'],
              $address_filter_var['lng'],
              $address_filter_var['lat'],
              $earth_radius,
              $radius_from
          );
        } else {
          $where .= $wpdb->prepare(
              ' AND acos(cos(%f * (PI()/180)) *
                     cos(%f * (PI()/180)) *
                     cos(latlng.lat * (PI()/180)) *
                     cos(latlng.lng * (PI()/180))
                     +
                     cos(%f * (PI()/180)) *
                     sin(%f * (PI()/180)) *
                     cos(latlng.lat * (PI()/180)) *
                     sin(latlng.lng * (PI()/180))
                     +
                     sin(%f * (PI()/180)) *
                     sin(latlng.lat * (PI()/180))
                    ) * %d < %d',
              $address_filter_var['lat'],
              $address_filter_var['lng'],
              $address_filter_var['lat'],
              $address_filter_var['lng'],
              $address_filter_var['lat'],
              $earth_radius,
              $address_filter_var['radius']
          );
        }
      }

      return $where;
  }
  add_filter( 'posts_where', 'divi_filter_map_search_where', 9, 2 );
}

if ( !function_exists('divi_machine_dynamic_css_assets_atf')) {
  /**
   * Force load module styles above the fold.
   *
   * @return array
   */
  function divi_machine_dynamic_css_assets_atf( $atf_modules ) {
      array_push( $atf_modules, 'et_pb_accordion' );
      array_push( $atf_modules, 'et_pb_tabs' );
      array_push( $atf_modules, 'et_pb_post_slider' );
      array_push( $atf_modules, 'et_pb_gallery' );
      return $atf_modules;
  }
  add_filter( 'et_dynamic_assets_modules_atf', 'divi_machine_dynamic_css_assets_atf', 20 );
}

if ( !function_exists('divi_machine_dynamic_css_assets')) {
  /**
   * Force load module styles.
   *
   * @return array
   */
  function divi_machine_dynamic_css_assets( $modules ) {
    array_push( $modules, 'et_pb_accordion' );
    array_push( $modules, 'et_pb_tabs' );
    array_push( $modules, 'et_pb_post_slider' );
    array_push( $modules, 'et_pb_gallery' );
      return $modules;
  }
  add_filter( 'et_required_module_assets', 'divi_machine_dynamic_css_assets', 99 );
}

// add_action( 'init', 'df_tool' );
require_once dirname( __FILE__ ) .'/includes/modules/divi-ajax-filter/daf-page-settings.php';

if ( !function_exists('de_dmach_plugin_action_links')) {

	function de_dmach_plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=dm-options' ) . '" aria-label="' . esc_attr__( 'View Divi Machine settings', 'divi-machine' ) . '">' . esc_html__( 'Settings', 'divi-machine' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
	add_filter( 'plugin_action_links_' . DE_DMACH_NAME, 'de_dmach_plugin_action_links' );
}

if ( !function_exists('de_dmach_uninstall_hook')) {
	/**
	 * This function validates if settings removal is enabled at our settings page. If so, it removes from the database
	 * all the options related to our plugin
	 * @return void
	 */
	function de_dmach_uninstall_hook() {
		$remove_options = de_get_option_value( 'divi-machine', 'settings_delete_from_database' );
		if ( $remove_options ) {
			delete_option( 'divi_machine_license' ); //license removal
			delete_option( 'divi-engine-css' ); // shared setting removal
			delete_option( 'divi-machine_options' ); // settings removal
		}
	}

	register_uninstall_hook( __FILE__, 'de_dmach_uninstall_hook' );
}