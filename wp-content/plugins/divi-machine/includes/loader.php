<?php

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}

$disable_ajax_filters = false;
$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

if (isset($mydata['disable_ajax_filters'])){
	if ( $mydata['disable_ajax_filters'] == '1' ){
		$disable_ajax_filters = true;
	}
}

$module_files = glob( __DIR__ . '/modules/*/*.php' );
// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if (strpos($module_file, 'divi-ajax-filter.php') !== false) { 
		if ($disable_ajax_filters == false) {
			if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
				require_once $module_file;
			}
		} else {
			defined('DE_DF_PRODUCT_URL') or define('DE_DF_PRODUCT_URL', 'https://diviengine.com/product/divi-machine/');
			defined('DE_DF_AUTHOR') or define('DE_DF_AUTHOR', 'Divi Engine');
			defined('DE_DF_URL') or define('DE_DF_URL', 'https://www.diviengine.com');
			require_once __DIR__ . '/modules/divi-ajax-filter/includes/modules/PostTitle/PostTitle.php';
			require_once __DIR__ . '/modules/divi-ajax-filter/includes/modules/Thumbnail/Thumbnail.php';
			require_once __DIR__ . '/modules/divi-ajax-filter/includes/modules/ArchiveLoop/ArchiveLoop.php';
			require_once __DIR__ . '/modules/divi-ajax-filter/includes/modules/MachineLoop/MachineLoop.php';

			$ajax_nonce = wp_create_nonce('filter_object');

			wp_add_inline_script( 'filter-script', 'var filter_ajax_object = ' . json_encode( array(
			    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			    'ajax_pagination' => false,
			    'security'	=> $ajax_nonce
			) ) );
		}
	} else {
		if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
			require_once $module_file;
		}
	}
}
