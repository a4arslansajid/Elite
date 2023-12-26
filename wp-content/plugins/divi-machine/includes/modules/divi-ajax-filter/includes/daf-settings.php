<?php

  add_action( 'admin_menu', 'divi_filter_add_menu' );
  function divi_filter_add_menu(){
    global $menu;
    $menuExist = false;
    foreach($menu as $item) {
        if(strtolower($item[0]) == strtolower('Divi Engine')) {
            $menuExist = true;
        }
    }
    if(!$menuExist) {
      $icon = DE_DF_PLUGIN_URL . 'images/dash-icon.svg';
      $page_title = 'Divi Engine';
      $menu_title = 'Divi Engine';
      $capability = 'edit_pages';
      $menu_slug  = 'divi-engine';
      $icon_url   = $icon;
      $position   = '100';
      add_menu_page(
          $page_title,
          $menu_title,
          $capability,
          $menu_slug,
          'daf_de_page',
          $icon_url,
          $position
      );
    }
  }


  function daf_de_page() {
    global $menu;
    $menuExist = false;
    foreach($menu as $item) {
        if(strtolower($item[0]) == strtolower('Divi Engine')) {
            $menuExist = true;
        }
    }
    if($menuExist) {

      ?>
      <div class="titan-framework-panel-wrap">
      <table class="form-table">
      <tbody>
				<tr valign="top" class="even first tf-heading">
			<th scope="row" class="first last" colspan="2">
				<h3 id="welcome-to-divi-engine">Welcome to Divi Engine</h3>
							</th>
		</tr>
				<tr valign="top" class="row-1 odd" >
		<th scope="row" class="first">
			<label for="divi-bodyshop-woo_2696610e41262487"></label>
		</th>
		<td class="second tf-note">
		<p class='description'><iframe class="nitro_videos" width="560" height="315" src="https://www.youtube.com/embed/jKio-EA4I0k" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>		</td>
		</tr>
				<tr valign="top" class="even first tf-heading">
			<th scope="row" class="first last" colspan="2">
				<h3 id="support">Support</h3>
							</th>
		</tr>
				<tr valign="top" class="row-2 even" >
		<th scope="row" class="first">
			<label for="divi-bodyshop-woo_6cec1d75697d2af1"></label>
		</th>
		<td class="second tf-note">
		<p class='description'>We know that when building a website things may not always go according to plan. If you experience issues when using our plugins do not worry we are here to help. First take a look at our documentation <a href="https://help.diviengine.com/ " target="_blank">here</a> and if you cannot find a solution, please contact us  <a href="https://diviengine.com/support/" target="_blank">here</a> and we will help you resolve any issues.</p>		</td>
		</tr>
				<tr valign="top" class="even first tf-heading">
			<th scope="row" class="first last" colspan="2">
				<h3 id="feedback">Feedback</h3>
							</th>
		</tr>
				<tr valign="top" class="row-3 odd" >
		<th scope="row" class="first">
			<label for="divi-bodyshop-woo_cf59399160a5028e"></label>
		</th>
		<td class="second tf-note">
		<p class='description'>We would love to hear from you, good or bad! We would really appreciate it if you could leave a review on our product page so that it helps others!</p>		</td>
		</tr>
				<tr valign="top" class="even first tf-heading">
			<th scope="row" class="first last" colspan="2">
				<h3 id="do-you-have-idea?">Do you have idea?</h3>
							</th>
		</tr>
				<tr valign="top" class="row-4 even" >
		<th scope="row" class="first">
			<label for="divi-bodyshop-woo_6cb3afd29b1f9cf7"></label>
		</th>
		<td class="second tf-note">
		<p class='description'>If you have an idea for how to improve our plugins, please dont hesitate to contact us <a href="https://diviengine.com/contact/" target="_blank">here</a> as we really want to make them better for everyone!</p>		</td>
		</tr>
					</tbody>
      </table>
    </div>
      <?php
    }
  }

function daf_de_option_tab( $tabs ) {
	$custom_tab = 'Divi Engine';
	$keys = array_keys( $tabs );
	$values = array_values( $tabs );

	array_splice( $keys, 7, 0, 'diviengine' );
	array_splice( $values, 7, 0, $custom_tab );

	return array_combine( $keys, $values );
}
add_filter( 'et_epanel_tab_names', 'daf_de_option_tab' );

function daf_de_options( $options ) {
	$de_options = array(
		array( "name" => "wrap-diviengine",
		   "type" => "contenttab-wrapstart",),

			array( "type" => "subnavtab-start",),

				array( "name" => "diviengine-daf",
					   "type" => "subnav-tab",
					   "desc" => esc_html__( "Divi Ajax Filter", 'divi-ajax-filter') ),

			array( "type" => "subnavtab-end",),

			array( "name" => "diviengine-daf-content",
				   "type" => "subcontent-start",),

				array( "name" => esc_html__( "Filter individual variation prices for price range filter?", 'divi-ajax-filter' ),
					   "id" => "price_filter_setting",
					   "type" => "checkbox",
					   "std" => "off",
					   "desc" => esc_html__( "If this is enabled, it will show the product if ANY of the variations are within the price range filter. If you want it so that it only shows the product if ALL of the variations are in the specified price range, disable this.", "divi-ajax-filter" )
				),

			array(
				"name" => "diviengine-daf-content",
				"type" => "subcontent-end",
			),
		array(
			"name" => "wrap-diviengine",
			"type" => "contenttab-wrapend",
		),
	);

	$options = array_merge($options, $de_options);

	return $options;
}
add_filter( 'et_epanel_layout_data', 'daf_de_options');
