<?php
// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;
// check if class already exists
if( !class_exists('acf_plugin_phone') ) :
class acf_plugin_phone {
  

	function __construct() {

		// include field
		add_action('acf/include_field_types', 	array($this, 'include_field_types')); // v5
		add_action('acf/register_fields', 		array($this, 'include_field_types')); // v4

	}


	/*
	*  include_field_types
	*
	*  This function will include the field type class
	*
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	n/a
	*/

	function include_field_types( $version = false ) {

    include(DE_DMACH_PATH . '/includes/acf_fields/acf-phone.php');

	}

}
new acf_plugin_phone();
endif;

?>
