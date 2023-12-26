<?php
global $deMainTabs, $deOptions, $deMenus, $deTabNames, $deGlobalOptions;
if(defined('ABSPATH')){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
}

$plugin_name = 'divi-machine';

if ( isset( $deMainTabs[$plugin_name] ) ) {
	$deMainTabs[$plugin_name] = array_merge(
		array(
			'divi-engine' => array(),
			'dm-options'  => array('general','search','override','license','help')
		),
		$deMainTabs[$plugin_name]
	);
} else {
	$deMainTabs[$plugin_name] = array(
		'divi-engine' => array(),
		'dm-options'  => array('general','search','override','license','help')
	);
}

if ( isset( $deMenus[$plugin_name] ) ) {
	$deMenus[$plugin_name] = array_merge(
		array(
			'divi-engine' => array( 'Divi Engine', 'Divi Engine',  1 ),
			'dm-options' => array( 'Machine Settings', 'Machine Settings', 2 )
		),
		$deMenus[$plugin_name]
	);
} else {
	$deMenus[$plugin_name] = array(
		'divi-engine' => array( 'Divi Engine', 'Divi Engine',  1 ),
		'dm-options' => array( 'Machine Settings', 'Machine Settings', 2 )
	);	
}

$deTabNames[$plugin_name]['dm-options'] = array(
		'general'           => _x( '1. General Settings', 'site ads placement areas', 'divi-machine' ),
		'search' 			=> _x( '2. Search Settings', 'site color scheme', 'divi-machine' ),
		'override'      	=> _x( '3. Module Overrides', 'general options', 'divi-machine' ),
		'license'           => _x( '4. License', 'site ads placement areas', 'divi-machine' ),
		'help' 				=> _x( '5. Get Help', 'site color scheme', 'divi-machine' )
	);

function get_all_post_types() {
	$post_types = array();

	/*RETRIEVE ALL DIVI MACHINE CREATED POST TYPES*/
	$de_mach_post_types = get_posts(
		array(
			'post_type' => 'dmach_post',
			'numberposts' => -1,
		)
	);
	foreach ( $de_mach_post_types as $post_type ){
		$de_mach_post_type_key = get_post_meta($post_type->ID,  'divi-machine_dmach_post_type_key' , true );
		$post_types[$de_mach_post_type_key] = $post_type->post_title;
	}

	/* RETRIEVE ALL WP POST TYPES */
	$all_wp_post_types = get_post_types( array(
		'public'   => true,
	), 'object' );

	foreach ($all_wp_post_types as $key => $obj) {
		$post_types[$key] = $obj->label;
	}

	/* RETRIEVE ALL BUILT IN CUSTOM POST TYPES */
	/*$all_cpts = get_post_types( array(
		'public'   => true,
		'_builtin' => true,
	), 'object' );

	foreach ($all_cpts as $key => $obj) {
		$post_types[$key] = $obj->label;
	}*/

	/* RETRIEVE ALL NON BUILT IN CUSTOM POST TYPES */
	/*$all_nb_cpts = get_post_types( array(
		'public'   => true,
		'_builtin' => false,
	), 'object' );

	foreach ($all_nb_cpts as $key => $obj) {
		$post_types[$key] = $obj->label;
	}*/


	/* ADD CPT UI POST TYPES TO ARRAY IF CPT UI PLUGIN IS ACTIVE */
	if ( function_exists( 'is_plugin_active' ) && is_plugin_active('custom-post-type-ui/custom-post-type-ui.php')) {
		$cptui_post_types = get_option( 'cptui_post_types', [] );
		foreach ($cptui_post_types as $key => $obj) {
			$post_types[$key] = $obj['label'];
		}
	}

	/* ADD WOO PRODUCTS POST TYPE TO ARRAY IF WOO PLUGIN IS ACTIVE */
	if ( function_exists( 'is_plugin_active' ) && is_plugin_active('woocommerce/woocommerce.php')) {
		$post_types['product'] = 'Products';
	}

	/* WE SORT THE POST TYPES ARRAY BY KEY ASC */
	ksort($post_types);

	return $post_types;
}

$post_types = get_all_post_types();

$de_dmach_option = new DE_DMACH_options_interface();

$deOptions[$plugin_name]['divi-engine'] = array(
	array( "name" => "wrap-general", 
			"type" => "contenttab-wrapstart",),
		
		array( "name" => "general",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__( "Welcome to Divi Engine", 'divi-engine' ),
				   "type" => "subheading"
			),

			array(	"type"            => "html",
					"html_tag"		  => "div",
					"html"			  => '<iframe class="nitro_videos" width="560" height="315" src="https://www.youtube.com/embed/jKio-EA4I0k" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
			),

			array( "name" => esc_html__( "Support", 'divi-engine' ),
				   "type" => "subheading"
			),

			array(	"type"            => "html",
					"html_tag"		  => "div",
					"html"			  => esc_html__( 'We know that when building a website things may not always go according to plan. If you experience issues when using our plugins do not worry we are here to help. First take a look at our documentation ', 'divi-engine').'<a href="https://help.diviengine.com/ " target="_blank">'. esc_html__( 'here', 'divi-engine') .'</a>'. esc_html__( ' and if you cannot find a solution, please contact us ', 'divi-engine').' <a href="https://diviengine.com/support/" target="_blank">'. esc_html__( 'here', 'divi-engine').'</a>'. esc_html__( ' and we will help you resolve any issues.', 'divi-engine')
			),

			array( "name" => esc_html__( "Feedback", 'divi-engine' ),
				   "type" => "subheading"
			),

			array(	"type"            => "html",
					"html_tag"		  => "div",
					"html"			  => esc_html__( 'We would love to hear from you, good or bad! We would really appreciate it if you could leave a review on our product page so that it helps others!', 'divi-engine')
			),

			array( "name" => esc_html__( "Do you have idea?", 'divi-engine' ),
				   "type" => "subheading"
			),

			array(	"type"            => "html",
					"html_tag"		  => "div",
					"html"			  => esc_html__( 'If you have an idea for how to improve our plugins, please dont hesitate to contact us ', 'divi-engine') .'<a href="https://diviengine.com/contact/" target="_blank">'. esc_html__( 'here', 'divi-engine') .'</a>'. esc_html__( ' as we really want to make them better for everyone!', 'divi-engine')
			),
			
		array( 	"name" => "general",
				"type" => "subcontent-end"
		),

	array( "name" => "wrap-general", 
			"type" => "contenttab-wrapend",),
);

$deOptions[$plugin_name]['dm-options'] = array (
	array( "name" => "wrap-general", 
			"type" => "contenttab-wrapstart",),
		
		array( "name" => "general",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__( "Enable Debug Mode?", 'divi-machine' ),
				   "id" =>  "enable_debug",
				   "type" => "checkbox",
				   "std" => "off",
				   "desc" => esc_html__( "Enable debug mode if a Divi Engine support engineer has instructed you to do so.", 'divi-machine' )
			),

			array( "name" => esc_html__( "Add some custom CSS/JS (great when exporting/importing settings)", 'divi-machine' ),
				   "type" => "subheading"
			),

			array( "name" => esc_html__( "Custom CSS", 'divi-machine' ),
				   "id" =>  "machine_custom_css",
				   "type" => "de_editor",
				   "editor_type"	=> "css",
				   "std" => "",
				   "desc" => esc_html__( "Put your custom CSS rules here. Do not put <style> tags as we will do this for you. We will automatically minify your CSS so no need to minify it here.", 'divi-machine' )
			),

			array( "name" => esc_html__( "Custom JavaScript", 'divi-machine' ),
				   "id" =>  "machine_custom_js",
				   "type" => "de_editor",
				   "editor_type"	=> "js",
				   "std" => "",
				   "desc" => esc_html__( "Add your additional javascript rules here. Do not forget to add your <script> tags.", 'divi-machine' )
			),

			array( "name" => esc_html__( "Import/Export Settings", 'divi-machine' ),
				   "type" => "subheading"
			),

			array( "name" => esc_html__( "Upload your setting file", 'divi-machine' ),
				   "id" => "setting_file_upload",
				   "type" => "upload",
				   "button_text" => esc_html__( "Select CSV File", 'divi-machine' ),
				   "std" => "",
				   "desc" => esc_html__( "Select the setting file to upload.", 'divi-machine' )
			),

			array( "name" => esc_html__( "Import Settings", 'divi-machine' ),
				   "id" => "import_setting_btn",
				   "type" => "de_ajax_button",
				   "data_filter_callback"	=> "import_settings_data_filter_callback_machine",
				   "action" => "divi_machine_import_action",
				   "success_callback" => "import_settings_machine",
				   "class" => array("button-primary", "button-secondary"),
				   "button_text" => esc_html__( "Save Settings", 'divi-machine' ),
				   "desc" => esc_html__( "Import Settings from uploaded file.", 'divi-machine' )
			),

			array( "name" => esc_html__( "Export Settings", 'divi-machine' ),
				   "id" => "export_setting_btn",
				   "type" => "de_ajax_button",
				   "action" => "divi_machine_export_action",
				   "success_callback" => "export_settings_machine",
				   "class" => array("button-primary", "button-secondary"),
				   "button_text" => esc_html__( "Download", 'divi-machine' ),
				   "desc" => esc_html__( "Export current settings to file.", 'divi-machine' )
			),

			array( "name" => esc_html__( "Other Settings", 'divi-machine' ),
			"type" => "subheading"
	 ),

			array( "name" => esc_html__( "Remove all settings when plugin is deleted ?", 'divi-machine' ),
			       "id" =>  "settings_delete_from_database",
			       "type" => "checkbox",
			       "std" => "off",
			       "desc" => esc_html__( "Please enable this option if you want to remove all of your settings set up here when you delete our plugin.", 'divi-machine' )
			),

		array(
			'name' => 'general',
			'type' => 'subcontent-end',
		),
	array( 
		"name" => "wrap-general",
		"type" => "contenttab-wrapend"
	),

	array( "name" => "wrap-search", 
			"type" => "contenttab-wrapstart",),
		
		array( "name" => "search",
			   "type" => "subcontent-start",),

			array( "name" 	=> esc_html__( "Search Post Common Fields", 'divi-machine' ),
				   "id" 	=>  "search_enable_post_common",
				   "type" 	=> "checkbox_list",
				   'usefor'	=> 'custom',
				   "std" => "off",
				   "desc" => esc_html__( "Here you can enable/disable what gets searched when you are using the native search or Divi Machine search module.", 'divi-machine' ),
				   "options"         => array(
				   		"content"	=> "Content",
				   		"excerpt"	=> "Excerpt",
				   		"taxonomy"	=> "Taxonomy",
				   		"comments"	=> "Comments"
				   ),
				   "default" 		=> array(
				   		"content"	=> "on",
				   		"excerpt"	=> "on",
				   		"taxonomy"	=> "on",
				   		"comments"	=> "on"
				   ),
				   "validation_type" => "on_off_array",
				   "et_save_values"  => true,
			),

			array( "name" 	=> esc_html__( "Search ACF Group", 'divi-machine' ),
				   "id" 	=>  "search_enable_acf_group",
				   "type" 	=> "checkbox_list",
				   'usefor'	=> 'custom',
				   "std" => "off",
				   "desc" => esc_html__( "Here you can enable/disable what gets searched when you are using the native search or Divi Machine search module.", 'divi-machine' ),
				   "options"         => 'DEDMACH_INIT::get_acf_field_group',
				   "default" 		 => DEDMACH_INIT::search_acf_group_default(),
				   "validation_type" => "on_off_array",
				   "et_save_values"  => true,
			),

		array(
			'name' => 'search',
			'type' => 'subcontent-end',
		),
	array( 
		"name" => "wrap-search",
		"type" => "contenttab-wrapend"
	),

	array( "name" => "wrap-override", 
			"type" => "contenttab-wrapstart",),
		
		array( "name" => "override",
			   "type" => "subcontent-start",),

			array( "name" => esc_html__( "Map Module", 'divi-machine' ),
				   "type" => "subheading"
			),

			array( 	"name" => esc_html__( "Map Module Override: ACF Item", 'divi-machine' ),
				   	"id" => "dmach_map_acf",
				   	"type" => "select",
				   	"options" => DEDMACH_INIT::get_acf_fields(),
				   	"std" => "none",
				   	"desc" => esc_html__( "If you would like to have a pin on a map on a single page of your custom post then add the Google Map ACF item here. When you add a map module to your theme builder template with a map pin (do not add the exact pin location) Divi Machine will change the pin location to what you specify in the ACF settings for each post.", 'divi-machine' ),
				   	'et_save_values' => true,
			),

			array( 	"name" 			=> esc_html__( "Map Post Type", 'divi-machine' ),
				   	"id" 			=> "dmach_post_type",
				   	"type" 			=> "select",
				   	"options" 		=> $post_types,
				   	"std" 			=> "",
				   	"desc" 			=> esc_html__( "Add the post type to override the Divi module.", 'divi-machine' ),
				   	'et_save_values' => true,
			),

			array(
				"name"              => esc_html__( "Map Post Type Slug (custom)", 'divi-machine' ),
				"id"                => "dmach_post_type_custom",
				"std"               => "",
				"type"              => "text",
				"desc"              => esc_html__( "If your custom post is not specified above, add the slug of the custom post here.", 'divi-machine' ),
			),

			array( "name" => esc_html__( "Countdown Module", 'divi-machine' ),
				   "type" => "subheading"
			),

			array( 	"name" => esc_html__( "Countdown Module Override: ACF Item", 'divi-machine' ),
				   	"id" => "dmach_countdown_acf",
				   	"type" => "select",
				   	"options" => DEDMACH_INIT::get_acf_fields(),
				   	"std" => "none",
				   	"desc" => esc_html__( "Select the ACF datepicker field that you are using to define the countdown for each post.", 'divi-machine' ),
				   	'et_save_values' => true,
			),

			array( 	"name" 			=> esc_html__( "Countdown Post Type", 'divi-machine' ),
				   	"id" 			=> "dmach_countdown_post_type",
				   	"type" 			=> "select",
				   	"options" 		=> $post_types,
				   	"std" 			=> "",
				   	"desc" 			=> esc_html__( "Add the post type to override the Divi module.", 'divi-machine' ),
				   	'et_save_values' => true,
			),

			array(
				"name"              => esc_html__( "Countdown Post Type Slug (custom)", 'divi-machine' ),
				"id"                => "dmach_countdown_post_type_custom",
				"std"               => "",
				"type"              => "text",
				"desc"              => esc_html__( "If your custom post is not specified above, add the slug of the custom post here.", 'divi-machine' ),
			),

		array(
			'name' => 'override',
			'type' => 'subcontent-end',
		),
	array( 
		"name" => "wrap-override",
		"type" => "contenttab-wrapend"
	),

	array( "name" => "wrap-license", 
			"type" => "contenttab-wrapstart",),
		
		array( "name" => "subcontent-license",
			   "type" => "subcontent-start",),

			array(	"name"            => esc_html__( "License", 'divi-machine' ),
					"id"              => "divi_machine_license",
					"type"            => 'license',
					"function_name"   => array( $de_dmach_option, 'admin_menu' ),
					"submit_function_name"	=> array( $de_dmach_option, 'options_update' ),
					"desc"			  => ""
			),

		array(
			'name' => 'subcontent-license',
			'type' => 'subcontent-end',
		),
	array( 
		"name" => "wrap-license",
		"type" => "contenttab-wrapend"
	),

	array( "name" => "wrap-help", 
			"type" => "contenttab-wrapstart",),
		
		array( "name" => "help",
			   "type" => "subcontent-start",),

			array(	"type"            => "html",
					"html_tag"		  => "p",
					"html"			  => esc_html__("Divi Machine is a very detailed plugin with numerous capabilities. At first the complexity may seem overwhelming, but we assure you that once you understand it, Divi Machine will speed up your development time and therefore save you money.", 'divi-machine')
			),

			array(	"type"            => "html",
					"html_tag"		  => "div",
					"html"			  => '<hr><h4>Please click <a href="https://help.diviengine.com/collection/100-divi-machine" target="_blank">here for documentation</a></h4>'
			),

		array(
			'name' => 'search',
			'type' => 'subcontent-end',
		),
	array( 
		"name" => "wrap-search",
		"type" => "contenttab-wrapend"
	),
);
