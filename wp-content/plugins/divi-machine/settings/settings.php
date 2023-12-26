<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

if ( !class_exists( 'de_menu' ) ) {
	class de_menu{
		function __construct() {
			add_action( 'admin_menu', array( $this, 'add_plugins_menu' ), 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'de_epanel_admin_scripts' ) );
			add_filter( 'wp_code_editor_settings', array( $this, 'de_epanel_enable_css_lint' ) );

			add_action( 'wp_ajax_de_save_epanel', array( $this, 'de_epanel_save_data' ) );
		}

		function de_epanel_save_data( ){
			global $deOptions, $deGlobalOptions;

			$license_callback = false;

			if ( isset($_POST['action']) ) {
				do_action( 'de_et_epanel_options' );

				$plugin_name = $_POST['plugin_name'];

				if ( !isset( $deGlobalOptions[$plugin_name] ) && !is_array( $deGlobalOptions[$plugin_name] ) ) {
					$deGlobalOptions[$plugin_name] = array();
				}

				if ( 'de_save_epanel' === $_POST['action'] ) {
					check_admin_referer( 'de_epanel_nonce' );

					$options = $deOptions[ $plugin_name ];

					foreach ( $options as $sub_options ) {
						foreach ( $sub_options as $value ) {

							if ( isset( $value['id'] ) ) {
								$de_option_name = $value['id'];

								if ( $value['type'] == 'license') {
									$license_callback = call_user_func( $value['submit_function_name'] );
								} else {
									if ( isset( $_POST[ $value['id'] ] ) || 'checkbox_list' === $value['type'] || 'checkbox' === $value['type'] || 'checkbox2' === $value['type'] ) {
										if ( in_array( $value['type'], array( 'text', 'textlimit', 'password' ) ) ) {
											if( 'password' === $value['type'] && isset($et_option_name) && _et_epanel_password_mask() === $_POST[$et_option_name] ) {
												// The password was not modified so no need to update it
												continue;
											}

											if ( isset( $value['validation_type'] ) ) {
												// saves the value as integer
												if ( 'number' === $value['validation_type'] ) {
													$de_option_new_value = intval( stripslashes( $_POST[$value['id']] ) );
												}

												// makes sure the option is a url
												if ( 'url' === $value['validation_type'] ) {
													$de_option_new_value = esc_url_raw( stripslashes( $_POST[ $value['id'] ] ) );
												}

												// option is a date format
												if ( 'date_format' === $value['validation_type'] ) {
													$de_option_new_value = sanitize_option( 'date_format', $_POST[ $value['id'] ] );
												}

												/*
												 * html is not allowed
												 * wp_strip_all_tags can't be used here, because it returns trimmed text, some options need spaces ( e.g 'character to separate BlogName and Post title' option )
												 */
												if ( 'nohtml' === $value['validation_type'] ) {
													$de_option_new_value = stripslashes( wp_filter_nohtml_kses( $_POST[$value['id']] ) );
												}
												if ( 'apikey' === $value['validation_type'] ) {
													$de_option_new_value = stripslashes( sanitize_text_field( $_POST[ $value['id'] ]  ) );
												}
											} else {
												// use html allowed for posts if the validation type isn't provided
												$de_option_new_value = wp_kses_post( stripslashes( $_POST[ $value['id'] ] ) );
											}
										} elseif ( 'select' === $value['type'] ) {

											// select boxes that list pages / categories should save page/category ID ( as integer )
											if ( isset( $value['et_array_for'] ) && in_array( $value['et_array_for'], array( 'pages', 'categories' ) ) ) {
												$de_option_new_value = intval( stripslashes( $_POST[$value['id']] ) );
											} else { // html is not allowed in select boxes
												$de_option_new_value = sanitize_text_field( stripslashes( $_POST[$value['id']] ) );
											}

										} elseif ( in_array( $value['type'], array( 'checkbox', 'checkbox2' ) ) ) {

											// saves 'on' value to the database, if the option is enabled
											if ( isset( $_POST[ $value['id'] ] ) ) {
												$de_option_new_value = '1';
											} else {
												$de_option_new_value = '0';
											}

										} elseif ( 'upload' === $value['type'] ) {

											// makes sure the option is a url
											$de_option_new_value = esc_url_raw( stripslashes( $_POST[ $value['id'] ] ) );

										} elseif ( in_array( $value['type'], array( 'textcolorpopup', 'et_color_palette' ) ) ) {

											// the color value
											$de_option_new_value = sanitize_text_field( stripslashes( $_POST[$value['id']] ) );

										} elseif ( 'textarea' === $value['type'] ) {

											if ( isset( $value['validation_type'] ) ) {
												// html is not allowed
												if ( 'nohtml' === $value['validation_type'] ) {
													$de_option_new_value = wp_strip_all_tags( $_POST[ $value['id'] ] );
												}
											} else {
												if ( current_user_can( 'edit_theme_options' ) ) {
													$de_option_new_value = stripslashes( $_POST[ $value['id'] ] );
												} else {
													$de_option_new_value = stripslashes( wp_filter_post_kses( addslashes( $_POST[ $value['id'] ] ) ) ); // wp_filter_post_kses() expects slashed value
												}
											}

										} elseif ( 'de_editor' === $value['type'] ) {

											$de_option_new_value = stripslashes( $_POST[ $value['id'] ] );

										} elseif ( 'checkboxes' === $value['type'] ) {

											if ( isset( $value['value_sanitize_function'] ) && 'sanitize_text_field' === $value['value_sanitize_function'] ) {
												// strings
												$de_option_new_value = array_map( 'sanitize_text_field', stripslashes_deep( $_POST[ $value['id'] ] ) );
											} else {
												// saves categories / pages IDs
												$de_option_new_value = array_map( 'intval', stripslashes_deep( $_POST[ $value['id'] ] ) );
											}

										} elseif ( 'different_checkboxes' === $value['type'] ) {

											// saves 'author/date/categories/comments' options
											$de_option_new_value = array_map( 'sanitize_text_field', array_map( 'wp_strip_all_tags', stripslashes_deep( $_POST[$value['id']] ) ) );

										} elseif ( 'checkbox_list' === $value['type'] ) {
											// saves array of: 'value' => 'on' or 'off'
											$raw_checked_options = isset( $_POST[ $value['id'] ] ) ? stripslashes_deep( $_POST[ $value['id'] ] ) : array();
											$checkbox_options    = $value['options'];

											if ( is_callable( $checkbox_options ) ) {
												// @phpcs:ignore Generic.PHP.ForbiddenFunctions.Found
												$checkbox_options = call_user_func( $checkbox_options );
											}

											$allowed_values = array_values( $checkbox_options );

											if ( isset( $value['et_save_values'] ) && $value['et_save_values'] ) {
												$allowed_values = array_keys( $checkbox_options );
											}

											$de_option_new_value = array();

											foreach ( $allowed_values as $allowed_value ) {
												$de_option_new_value[ $allowed_value ] = in_array( $allowed_value, $raw_checked_options ) ? '1' : '0';
											}
										}
									}

									if ( false !== $de_option_name && false !== $de_option_new_value ) {
										$deGlobalOptions[$plugin_name][$de_option_name] = $de_option_new_value;
									}
								}
							}
						}
					}

					update_option( $plugin_name . '_options', $deGlobalOptions[ $plugin_name ] );
				}
			}

			wp_send_json( array('result' => $license_callback ) );
		}


		function add_plugins_menu() {

			
			global $deMenus, $menu;

			$menuExist = false;

			foreach($menu as $item) {
				if(strtolower($item[0]) == strtolower('Divi Engine')) {
					$menuExist = true;
				}
			}

			if ( !$menuExist ) {
				$icon = plugins_url( 'images/dash-icon.svg', __FILE__ );
				add_menu_page( __( 'Divi Engine', 'divi-engine' ), __( 'Divi Engine', 'divi-engine' ), 'manage_options', 'divi-engine', 'de_dmach_de_page', $icon );
				$menuExist = true;
			}

			if ( $menuExist ) {
				foreach ( $deMenus as $plugin_name => $menus ) {
					foreach ( $menus as $menu_slug => $cur_menu ) {
						if ( $menu_slug != 'divi-engine' ) {
							add_submenu_page( 'divi-engine', $cur_menu[0], $cur_menu[1], 'manage_options', $menu_slug, array( $this, 'create_menu_page' ), $cur_menu[2] );
						}
					}
				}
			}
		}

		function de_epanel_enable_css_lint( $settings ){
			$modes = array( 'text/css', 'css', 'text/x-scss', 'text/x-less', 'text/x-sass' );
			
			if ( in_array( $settings['codemirror']['mode'], $modes, true ) ) {
				$settings['codemirror']['lint'] = true;
				$settings['codemirror']['gutters'] = array( 'CodeMirror-lint-markers' );
			}

			return $settings;
		}

		function ajaxSecurityChecker() {
			if ( empty( $_POST['nonce'] ) ) {
				wp_send_json_error( __( 'Security check failed, please refresh the page and try again.', 'divi-engine' ) );
			}
			if ( ! wp_verify_nonce( $_POST['nonce'], 'de-ajax-button' ) ) { // phpcs:ignore
				wp_send_json_error( __( 'Security check failed, please refresh the page and try again.', 'divi-engine' ) );
			}
		}

		function de_epanel_admin_scripts( $hook ) {
			$current_screen = get_current_screen();

			$is_divi        = ( 'divi-engine_page_dm-options' === $current_screen->id );

			if ( ! wp_style_is( 'et-core-admin', 'enqueued' ) ) {
				wp_enqueue_style( 'et-core-admin-epanel', get_template_directory_uri() . '/core/admin/css/core.css', array(), et_get_theme_version() );
			}

			if ( str_starts_with($current_screen->id, 'divi-engine' ) || str_contains( $current_screen->id, 'dmach_post') || str_contains( $current_screen->id, 'dmach_tax')) {
				wp_enqueue_style( 'epanel-style', get_template_directory_uri() . '/epanel/css/panel.css', array(), et_get_theme_version() );
			}

			if ( wp_style_is( 'activecampaign-subscription-forms', 'enqueued' ) ) {
				// activecampaign-subscription-forms style breaks the panel.
				wp_dequeue_style( 'activecampaign-subscription-forms' );
			}

			// ePanel on theme others than Divi might want to add specific styling
			/*if ( ! apply_filters( 'et_epanel_is_divi', $is_divi ) ) {
				wp_enqueue_style( 'epanel-theme-style', apply_filters( 'et_epanel_style_url', get_template_directory_uri() . '/style-epanel.css'), array( 'epanel-style' ), et_get_theme_version() );
			}*/

			$this->de_divi_epanel_admin_js();

		}

		function de_divi_epanel_admin_js(){
			global $current_plugin;

			$current_screen = get_current_screen();

			if ( str_starts_with($current_screen->id, 'divi-engine' ) || str_contains( $current_screen->id, 'dmach_post') || str_contains( $current_screen->id, 'dmach_tax')) {

				$epanel_jsfolder = get_template_directory_uri() . '/epanel/js';

				et_core_load_main_fonts();

				wp_register_script( 'epanel_colorpicker', $epanel_jsfolder . '/colorpicker.js', array(), et_get_theme_version() );
				wp_register_script( 'epanel_eye', $epanel_jsfolder . '/eye.js', array(), et_get_theme_version() );
				wp_register_script( 'epanel_checkbox', $epanel_jsfolder . '/checkbox.js', array(), et_get_theme_version() );
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_style( 'wp-color-picker' );

				$wp_color_picker_alpha_uri = defined( 'ET_BUILDER_URI' ) ? ET_BUILDER_URI . '/scripts/ext/wp-color-picker-alpha.min.js' : $epanel_jsfolder . '/wp-color-picker-alpha.min.js';

				wp_enqueue_script( 'wp-color-picker-alpha', $wp_color_picker_alpha_uri, array( 'jquery', 'wp-color-picker' ), et_get_theme_version(), true );

				wp_enqueue_script( 'epanel_functions_init', $epanel_jsfolder . '/functions-init.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-form', 'epanel_colorpicker', 'epanel_eye', 'epanel_checkbox', 'wp-color-picker-alpha' ), et_get_theme_version() );
				wp_localize_script( 'epanel_functions_init', 'ePanelSettings', array(
					'clearpath'      => get_template_directory_uri() . '/epanel/images/empty.png',
					'de_epanel_nonce'   => wp_create_nonce( 'de_epanel_nonce' ),
					'help_label'     => esc_html__( 'Help', $current_plugin ),
					'et_core_nonces' => et_core_get_nonces(),
					'allowedCaps'    => array(
						'portability' => et_pb_is_allowed( 'portability' ) ? et_pb_is_allowed( 'et_code_snippets_portability' ) : false,
						'addLibrary'  => et_pb_is_allowed( 'divi_library' ) ? et_pb_is_allowed( 'add_library' ) : false,
						'saveLibrary' => et_pb_is_allowed( 'divi_library' ) ? et_pb_is_allowed( 'save_library' ) : false,
					),
					'i18n'           => [
						// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralDomain -- Following the standard.
						'Code Snippet' => esc_html__( 'Code Snippet', $current_plugin ),
					],
				) );

				wp_enqueue_script( 'de_settings', plugins_url( 'js/de_settings.js', __FILE__)  , array( 'jquery' ), '1.0', true );
				wp_enqueue_style( 'de_settings', plugins_url( 'css/settings.css', __FILE__) );

				// Use WP 4.9 CodeMirror Editor for some fields
				if ( function_exists( 'wp_enqueue_code_editor' ) ) {
					wp_enqueue_code_editor(
						array(
							'type' => 'text/css',
						)
					);
					// Required for Javascript mode
					wp_enqueue_script( 'jshint' );
					wp_enqueue_script( 'htmlhint' );
				}

				wp_enqueue_script( 'et_epanel_uploader', get_template_directory_uri().'/epanel/js/custom_uploader.js', array('jquery', 'media-upload', 'thickbox'), et_get_theme_version() );
				wp_enqueue_media();
				wp_localize_script( 'et_epanel_uploader', 'epanel_uploader', array(
					'media_window_title' => esc_html__( 'Choose an File', 'divi-engine' ),
				) );
			}
		}

		function create_menu_page() {
			global $deMainTabs, $deTabNames, $deMenus, $deOptions;

			$menu_slug 		= $_GET['page'];
			$menu_tabs 		= array();
			$tabs           = array();
			$current_plugin = '';

			foreach( $deMainTabs as $plugin_name => $plugin_tabs ) {
				if ( isset( $plugin_tabs[$menu_slug] ) ) {
					$menu_tabs = $plugin_tabs[$menu_slug];
					$current_plugin = $plugin_name;
					break;
				}
			}

			$options = $deOptions[ $current_plugin ][ $menu_slug ];

			if ( $menu_slug != 'divi-engine' ) {
				foreach( $menu_tabs as $tab_slug ) {
					if ( isset( $deTabNames[ $current_plugin ][ $menu_slug ][ $tab_slug ] ) ) {
						$tabs[ $tab_slug ] = $deTabNames[ $current_plugin ][ $menu_slug ][ $tab_slug ];
					}
				}	
			}
			
			if ( isset($_GET['saved']) ) {
				if ( $_GET['saved'] ) echo '<div id="message" class="updated fade"><p><strong>' . esc_html( $current_plugin ) . ' ' . esc_html__( 'settings saved.', $current_plugin ) . '</strong></p></div>';
			}

			if ( isset($_GET['reset']) ) {
				if ( $_GET['reset'] ) echo '<div id="message" class="updated fade"><p><strong>' . esc_html( $current_plugin ) . ' ' . esc_html__( 'settings reset.', $current_plugin ) . '</strong></p></div>';
			}
		?>
			<div id="wrapper">
				<div id="panel-wrap">

				<?php if ( $menu_slug != 'divi-engine' ) { ?>

					<div id="epanel-top">
						<button class="et-save-button" id="de-epanel-save-top"><?php esc_html_e( 'Save Changes', $current_plugin ); ?></button>
					</div>

				<?php } ?>

					<form method="post" id="main_options_form" enctype="multipart/form-data">
						<div id="epanel-wrapper">
							<div id="epanel" class="et-onload">
								<div id="epanel-content-wrap">
									<div id="epanel-content" class="<?php echo ($menu_slug == 'divi-engine')?'divi-engine':'';?>">

									<?php if ( $menu_slug != 'divi-engine' ) { ?>

										<div id="epanel-header">
											<h1 id="epanel-title"><?php echo esc_html__( $deMenus[ $current_plugin ][ $menu_slug ][0], $current_plugin ); ?></h1>
											<a href="#" class="et-defaults-button epanel-reset" title="<?php esc_attr_e( 'Reset to Defaults', $current_plugin ); ?>"><span class="label"><?php esc_html_e( 'Reset to Defaults', $current_plugin ); ?></span></a>
										</div>
										<ul id="epanel-mainmenu">
											<?php
												foreach ( $tabs as $tab_slug => $tab_name ) {

													printf( '<li><a href="#wrap-%1$s">%2$s</a></li>', esc_attr( $tab_slug ), esc_html( $tab_name ) );
												}
											?>
										</ul><!-- end epanel mainmenu -->

									<?php } ?>

										<?php
										foreach ($options as $value) {
											if ( ! isset( $value['type'] ) ) {
												continue;
											}

											if ( ! empty( $value[ 'depends_on' ] ) ) {
												// function defined in 'depends on' key returns false, if a setting shouldn't be displayed
												// @phpcs:ignore Generic.PHP.ForbiddenFunctions.Found
												if ( ! call_user_func( $value[ 'depends_on' ] ) ) {
													continue;
												}
											}

											$is_new_global_setting    = false;
											$global_setting_main_name = $global_setting_sub_name = '';

											if ( isset( $value['is_global'] ) && $value['is_global'] && ! empty( $value['id'] ) ) {
												$is_new_global_setting    = true;
												$global_setting_main_name = isset( $value['main_setting_name'] ) ? sanitize_text_field( $value['main_setting_name'] ) : '';
												$global_setting_sub_name  = isset( $value['sub_setting_name'] ) ? sanitize_text_field( $value['sub_setting_name'] ) : '';
											}

											// Is hidden option
											$is_hidden_option        = isset( $value['hide_option'] ) && $value['hide_option'];
											$hidden_option_classname = $is_hidden_option ? ' et-hidden-option' : '';
											$disabled                = $is_hidden_option ? 'disabled="disabled"' : '';

											if ( in_array( $value['type'], array( 'text', 'textlimit', 'textarea', 'select', 'checkboxes', 'different_checkboxes', 'colorpicker', 'textcolorpopup', 'upload', 'callback_function', 'et_color_palette', 'password', 'de_editor', 'de_button', 'de_ajax_button' ) ) ) { ?>
													<div class="et-epanel-box">
														<div class="et-box-title">
															<h3><?php echo esc_html( $value['name'] ); ?></h3>
															<div class="et-box-descr">
																<p><?php
																echo wp_kses( $value['desc'],
																	array(
																		'a' => array(
																			'href'   => array(),
																			'title'  => array(),
																			'target' => array(),
																		),
																	)
																);
																?></p>
															</div> <!-- end et-box-desc-content div -->
														</div> <!-- end div et-box-title -->

														<div class="et-box-content">

													<?php 
														if ( '' !== $global_setting_main_name ) {
															if ( ! $setting = get_site_option( $global_setting_main_name ) ) {
																$setting = get_option( $global_setting_main_name, array() );
															}

															$et_input_value = isset( $setting[ $global_setting_sub_name ] ) ? $setting[ $global_setting_sub_name ] : (isset($value['std'])?$value['std']:'');
														} else {
															$et_input_value = de_get_option_value( $plugin_name, $value['id'] );
															$et_input_value = ! empty( $et_input_value ) ? $et_input_value : (isset($value['std'])?$value['std']:'');
														}

													?>

													<?php if ( in_array( $value['type'], array( 'text', 'password' ) ) ) { ?>

														<?php

															$et_input_value = stripslashes( $et_input_value );

															if( 'password' === $value['type'] && !empty( $et_input_value ) ) {
																$et_input_value = _et_epanel_password_mask();
															}
														?>

														<input name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" type="<?php echo esc_attr( $value['type'] ); ?>" value="<?php echo esc_attr( $et_input_value ); ?>" />

													<?php } elseif ( 'textlimit' === $value['type'] ) { ?>

														<?php
															$et_input_value = stripslashes( $et_input_value );
														?>

														<input name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" type="text" maxlength="<?php echo esc_attr( $value['max'] ); ?>" size="<?php echo esc_attr( $value['max'] ); ?>" value="<?php echo esc_attr( $et_input_value ); ?>" />
													<?php } elseif ( 'colorpicker' === $value['type'] ) { ?>

														<div id="colorpickerHolder"></div>

													<?php } elseif ( 'textcolorpopup' === $value['type'] ) { ?>

														<input name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" class="colorpopup" type="text" value="<?php echo esc_attr( $et_input_value ); ?>" />

													<?php } elseif ( 'textarea' === $value['type'] ) { ?>

														<textarea name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_textarea( $et_input_value ); ?></textarea>

													<?php } elseif ( 'de_editor' === $value['type'] ) { ?>

														<textarea name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" class="de_editor_<?php echo $value['editor_type'];?>"><?php echo esc_textarea( $et_input_value ); ?></textarea>
													<?php } elseif ( 'de_ajax_button' === $value['type'] ) { ?>

													<?php
														$et_button_data = sprintf( ' data-nonce="%1$s"', esc_attr( wp_create_nonce( 'de-ajax-button' ) ) );
														$et_button_data .= isset( $value['button_text'] ) ? sprintf( ' data-button_text="%1$s"', esc_attr( $value['button_text'] ) ) : '';
														$et_button_data .= isset( $value['data_filter_callback'] ) ? sprintf( ' data-filter_callback="%1$s"', esc_attr( $value['data_filter_callback'] ) ) : '';
														$et_button_data .= isset( $value['action'] ) ? sprintf( ' data-action="%1$s"', esc_attr( $value['action'] ) ) : '';
														$et_button_data .= isset( $value['success_callback'] ) ? sprintf( ' data-success_callback="%1$s"', esc_attr( $value['success_callback'] ) ) : '';
														if ( !empty( $value['action'] ) ) {
															add_action( 'wp_ajax_' . $value['action'], array( $this, 'ajaxSecurityChecker' ), 1 );	
														}														
													?>

														<div class="de-button">
															<input class="de_ajax_button et-button <?php echo implode(' ', $value['class']);?>" type="button"<?php echo et_core_esc_previously( $et_button_data ); ?> value="<?php esc_attr_e( $value['button_text'], $current_plugin ); ?>" />
														</div>
													<?php } elseif ( 'upload' === $value['type'] ) { ?>

													<?php
														$et_upload_button_data = isset( $value['button_text'] ) ? sprintf( ' data-button_text="%1$s"', esc_attr( $value['button_text'] ) ) : '';
													?>

														<input id="<?php echo esc_attr( $value['id'] ); ?>" class="et-upload-field" type="text" size="90" name="<?php echo esc_attr( $value['id'] ); ?>" value="<?php echo esc_url( $et_input_value ); ?>" />
														<div class="et-upload-buttons">
															<span class="et-upload-image-reset"><?php esc_html_e( 'Reset', $current_plugin ); ?></span>
															<input class="et-upload-image-button" type="button"<?php echo et_core_esc_previously( $et_upload_button_data ); ?> value="<?php esc_attr_e( 'Upload', $current_plugin ); ?>" />
														</div>

														<div class="clear"></div>

													<?php } elseif ( 'select' === $value['type'] ) { ?>

														<select name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>">
															<?php 
																$has_optgroup = false;
																foreach ( $value['options'] as $option_key => $option ) { ?>
																<?php
																	$et_select_active = '';
																	$et_use_option_values = ( isset( $value['et_array_for'] ) && in_array( $value['et_array_for'], array( 'pages', 'categories' ) ) ) ||
																	( isset( $value['et_save_values'] ) && $value['et_save_values'] ) ? true : false;

																	if ( is_array( $option ) ) {
																		if ( $has_optgroup ) {
																			echo '</optgroup>';
																		}
																		echo '<optgroup label="' . $option_key . '">';
																		$has_optgroup = true;
																		foreach ( $option as $sub_key => $sub_option ) {
																			$sub_option = strval( $sub_option );
																			$et_select_active = '';
																			if ( ( $et_use_option_values && ( $et_input_value === $sub_key ) ) || ( stripslashes( $et_input_value ) === trim( stripslashes( $sub_option ) ) ) || ( ! $et_input_value && isset( $value['std'] ) && stripslashes( $sub_option ) === stripslashes( $value['std'] ) ) )
																				$et_select_active = ' selected="selected"';
																		?>
																			<option<?php if ( $et_use_option_values ) echo ' value="' . esc_attr( $sub_key ) . '"'; ?> <?php echo et_core_esc_previously( $et_select_active ); ?>><?php echo esc_html( trim( $sub_option ) ); ?></option>
																		<?php
																		}
																	} else {
																		$option_key = strval( $option_key );
																		if ( ( $et_use_option_values && ( $et_input_value === $option_key ) ) || ( stripslashes( $et_input_value ) === trim( stripslashes( $option_key ) ) ) || ( ! $et_input_value && isset( $value['std'] ) && stripslashes( $option_key ) === stripslashes( $value['std'] ) ) )
																				$et_select_active = ' selected="selected"';
																?>
																<option<?php if ( $et_use_option_values ) echo ' value="' . esc_attr( $option_key ) . '"'; ?> <?php echo et_core_esc_previously( $et_select_active ); ?>><?php echo esc_html( trim( $option ) ); ?></option>
															<?php 
																	} 
																}

																if ( $has_optgroup ) {
																	echo '</optgroup>';
																}
															?>
														</select>

													<?php } elseif ( 'checkboxes' === $value['type'] ) { ?>

														<?php
														if ( empty( $value['options'] ) ) {
															esc_html_e( "You don't have pages", $current_plugin );
														} else {
															$i = 1;
															$className = 'inputs';
															if ( isset( $value['excludeDefault'] ) && $value['excludeDefault'] === 'true' ) $className .= ' different';

															foreach ( $value['options'] as $option ) {
																$checked = "";
																$class_name_last = 0 === $i % 3 ? ' last' : '';

																if ( et_get_option( $value['id'] ) ) {
																	if ( in_array( $option, et_get_option( $value['id'] ) ) ) {
																		$checked = "checked=\"checked\"";
																	}
																}

																$et_checkboxes_label = $value['id'] . '-' . $option;
																if ( 'custom' === $value['usefor'] ) {
																	$et_helper = (array) $value['helper'];
																	$et_checkboxes_value = $et_helper[$option];
																} else {
																	if ( 'taxonomy_terms' === $value['usefor'] && isset( $value['taxonomy_name'] ) ) {
																		$et_checkboxes_term = get_term_by( 'id', $option, $value['taxonomy_name'] );
																		$et_checkboxes_value = sanitize_text_field( $et_checkboxes_term->name );
																	} else {
																		$et_checkboxes_value = ( 'pages' === $value['usefor'] ) ? get_pagename( $option ) : get_categname( $option );
																	}
																}
																?>

																<p class="<?php echo esc_attr( $className . $class_name_last ); ?>">
																	<input type="checkbox" class="et-usual-checkbox" name="<?php echo esc_attr( $value['id'] ); ?>[]" id="<?php echo esc_attr( $et_checkboxes_label ); ?>" value="<?php echo esc_attr( $option ); ?>" <?php echo esc_html( $checked ); ?> />
																	<label for="<?php echo esc_attr( $et_checkboxes_label ); ?>"><?php echo esc_html( $et_checkboxes_value ); ?></label>
																</p>

																<?php $i++;
															}
														}
														?>
														<br class="et-clearfix"/>

													<?php } elseif ( 'different_checkboxes' === $value['type'] ) { ?>

														<?php
														foreach ( $value['options'] as $option ) {
															$checked = '';
															if ( et_get_option( $value['id'] ) !== false ) {
																if ( in_array( $option, et_get_option( $value['id'] ) ) ) $checked = "checked=\"checked\"";
															} elseif ( isset( $value['std'] ) ) {
																if ( in_array( $option, $value['std'] ) ) {
																	$checked = "checked=\"checked\"";
																}
															} ?>

															<p class="postinfo <?php echo esc_attr( 'postinfo-' . $option ); ?>">
																<input type="checkbox" class="et-usual-checkbox" name="<?php echo esc_attr( $value['id'] ); ?>[]" id="<?php echo esc_attr( $value['id'] . '-' . $option ); ?>" value="<?php echo esc_attr( $option ); ?>" <?php echo esc_html( $checked ); ?> />
															</p>
														<?php } ?>
														<br class="et-clearfix"/>

													<?php } elseif ( 'callback_function' === $value['type'] ) {

														// @phpcs:ignore Generic.PHP.ForbiddenFunctions.Found
														echo call_user_func( $value['function_name'] ); ?>

													<?php } elseif ( 'et_color_palette' === $value['type'] ) {
															$items_amount = isset( $value['items_amount'] ) ? $value['items_amount'] : 1;
															$et_input_value = et_get_option( $value['id'], '', '', false, $is_new_global_setting, $global_setting_main_name, $global_setting_sub_name );
															$et_input_value_processed = str_replace( '|', '', $et_input_value );
															$et_input_value = ! empty( $et_input_value_processed ) ? $et_input_value : (isset($value['std'])?$value['std']:'');
														?>
															<div class="et_pb_colorpalette_overview">
														<?php
															for ( $colorpalette_index = 1; $colorpalette_index <= $items_amount; $colorpalette_index++ ) { ?>
																<span class="colorpalette-item colorpalette-item-<?php echo esc_attr( $colorpalette_index ); ?>" data-index="<?php echo esc_attr( $colorpalette_index ); ?>"><span class="color"></span></span>
														<?php } ?>

															</div>

														<?php for ( $colorpicker_index = 1; $colorpicker_index <= $items_amount; $colorpicker_index++ ) { ?>
																<div class="colorpalette-colorpicker" data-index="<?php echo esc_attr( $colorpicker_index ); ?>">
																	<input data-index="<?php echo esc_attr( $colorpicker_index ); ?>" type="text" class="input-colorpalette-colorpicker" data-alpha="true" />
																</div>
														<?php } ?>

														<input name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] ); ?>" class="et_color_palette_main_input" type="hidden" value="<?php echo esc_attr( $et_input_value ); ?>" />

													<?php } ?>

												</div> <!-- end et-box-content div -->
												<span class="et-box-description"></span>
											</div> <!-- end et-epanel-box div -->

									<?php } elseif ( 'checkbox' === $value['type'] || 'checkbox2' === $value['type'] ) { ?>
										<?php
											$et_box_class = 'checkbox' === $value['type'] ? 'et-epanel-box-small-1' : 'et-epanel-box-small-2';

											if ( '' !== $global_setting_main_name ) {
												if ( ! $setting = get_site_option( $global_setting_main_name ) ) {
													$setting = get_option( $global_setting_main_name, array() );
												}

												$saved_checkbox = isset( $setting[ $global_setting_sub_name ] ) ? $setting[ $global_setting_sub_name ] : (isset($value['std'])?$value['std']:'');	
											} else {
												$saved_checkbox = de_get_option_value( $plugin_name, $value['id'] );
												$checked = ( '1' === $saved_checkbox || (!$saved_checkbox && isset($value['std']) && '1' === $value['std']) ) ?
														'checked="checked"' : '';
											}
											
										?>
										<div class="<?php echo esc_attr( 'et-epanel-box ' . $et_box_class . $hidden_option_classname ); ?>">
											<div class="et-box-title"><h3><?php echo esc_html( $value['name'] ); ?></h3>
												<div class="et-box-descr">
													<p><?php
													echo wp_kses( $value['desc'],  array(
														'a' => array(
															'href'   => array(),
															'title'  => array(),
															'target' => array(),
														),
													) );
													?></p>
												</div> <!-- end et-box-desc-content div -->
											</div> <!-- end div et-box-title -->
											<div class="et-box-content">

												<?php if ( isset( $value['hidden_option_message'] ) && $is_hidden_option ) : ?>
													<div class="et-hidden-option-message">
														<?php echo et_core_esc_previously( wpautop( esc_html( $value['hidden_option_message'] ) ) ); ?>
													</div>
												<?php endif; ?>
												<input type="checkbox" class="et-checkbox yes_no_button" name="<?php echo esc_attr( $value['id'] ); ?>" id="<?php echo esc_attr( $value['id'] );?>" <?php echo et_core_esc_previously( $checked ); ?> <?php echo et_core_esc_previously( $disabled );?>/>

											</div> <!-- end et-box-content div -->
											<?php if ( 'et_pb_static_css_file' === $value['id'] ) { ?>
												<span class="et-button"><?php echo esc_html_x( 'Clear', 'clear static resources', $current_plugin ); ?></span>
											<?php } ?>
											<span class="et-box-description"></span>
										</div> <!-- end epanel-box-small div -->

									<?php } elseif ( 'checkbox_list' === $value['type'] ) { ?>

										<div class="<?php echo esc_attr( 'et-epanel-box et-epanel-box__checkbox-list' . $hidden_option_classname ); ?>">
											<div class="et-box-title">
												<h3><?php echo esc_html( $value['name'] ); ?></h3>
												<div class="et-box-descr">
													<p>
														<?php
														echo wp_kses( $value['desc'],  array(
															'a' => array(
																'href'   => array(),
																'title'  => array(),
																'target' => array(),
															),
														) );
														?>
													</p>
												</div> <!-- end et-box-descr div -->
											</div> <!-- end div et-box-title -->
											<div class="et-box-content et-epanel-box-small-2">
												<div class="et-box-content--list">
													<?php
													if ( empty( $value['options'] ) ) {
														esc_html_e( 'No available options.', $current_plugin );
													} else {
														$defaults = ( isset( $value['default'] ) && is_array( $value['default'] ) ) ? $value['default'] : array();
														$stored_values = maybe_unserialize( de_get_option_value( $plugin_name, $value['id'] ) );

														$value_options = $value['options'];
														if ( is_callable( $value_options ) ) {
															// @phpcs:ignore Generic.PHP.ForbiddenFunctions.Found
															$value_options = call_user_func( $value_options );
														}

														foreach ( $value_options as $option_key => $option ) {
															$option_value = isset( $value['et_save_values'] ) && $value['et_save_values'] ? sanitize_text_field( $option_key ) : sanitize_text_field( $option );
															$option_label = sanitize_text_field( $option );
															$checked = isset( $defaults[ $option_value ] ) ? $defaults[ $option_value ] : 'off';
															if ( isset( $stored_values[ $option_value ] ) ) {
																$checked = $stored_values[ $option_value ];
															}
															$checked = '1' === $checked ? 'checked="checked"' : '';
															$checkbox_list_id = sanitize_text_field( $value['id'] . '-' . $option_key );
															?>
															<div class="et-box-content">
																<span class="et-panel-box__checkbox-list-label">
																	<?php echo esc_html( $option_label ); ?>
																</span>
																<input type="checkbox" class="et-checkbox yes_no_button" name="<?php echo esc_attr( $value['id'] ); ?>[]" id="<?php echo esc_attr( $checkbox_list_id ); ?>" value="<?php echo esc_attr( $option_value ); ?>" <?php echo et_core_esc_previously( $checked ); ?> />
															</div> <!-- end et-box-content div -->
															<?php
														}
													}
													?>
												</div>
											</div>
											<span class="et-box-description"></span>
										</div> <!-- end epanel-box-small div -->

									<?php } elseif ( 'support' === $value['type'] ) { ?>

										<div class="inner-content">
											<?php include get_template_directory() . "/includes/functions/" . $value['name'] . ".php"; ?>
										</div>

									<?php } elseif ( 'html' === $value['type'] ) { ?>

										<<?php echo $value['html_tag'];?>> <?php echo $value['html'];?> </<?php echo $value['html_tag'];?>>

									<?php } elseif ( 'license' === $value['type'] ) { ?>

										<h4 class="subheading"> <?php esc_html_e( 'License', $current_plugin );?> </h4>
										<div class="et-epanel-box">
											<div class="et-box-content">
												<?php echo call_user_func( $value['function_name'] ); ?>
											</div>
										</div>

									<?php } elseif ( 'subheading' === $value['type'] ) { ?>

										<h4 class="subheading"> <?php echo $value['name'];?> </h4>
										
									<?php } elseif ( 'contenttab-wrapstart' === $value['type'] || 'subcontent-start' === $value['type'] ) { ?>

										<?php $et_contenttab_class = 'contenttab-wrapstart' === $value['type'] ? 'et-content-div' : 'et-tab-content'; ?>

										<div id="<?php echo esc_attr( $value['name'] ); ?>" class="<?php echo esc_attr( $et_contenttab_class ); ?>">

									<?php } elseif ( 'contenttab-wrapend' === $value['type'] || 'subcontent-end' === $value['type'] ) { ?>

										</div> <!-- end <?php echo esc_html( $value['name'] ); ?> div -->

									<?php } elseif ( 'subnavtab-start' === $value['type'] ) { ?>

										<ul class="et-id-tabs">

									<?php } elseif ( 'subnavtab-end' === $value['type'] ) { ?>

										</ul>

									<?php } elseif ( 'subnav-tab' === $value['type'] ) { ?>

										<li><a href="#<?php echo esc_attr( $value['name'] ); ?>"><span class="pngfix"><?php echo esc_html( $value['desc'] ); ?></span></a></li>

									<?php } elseif ($value['type'] === "clearfix") { ?>

										<div class="et-clearfix"></div>

									<?php } ?>

								<?php } //end foreach ($options as $value) ?>

									</div> <!-- end epanel-content div -->
								</div> <!-- end epanel-content-wrap div -->
							</div> <!-- end epanel div -->
						</div> <!-- end epanel-wrapper div -->

					<?php if ( $menu_slug != 'divi-engine' ) { ?>

						<div id="epanel-bottom">
							<?php wp_nonce_field( 'de_epanel_nonce' ); ?>
							<button class="et-save-button" name="save" id="de-epanel-save"><?php esc_html_e( 'Save Changes', $current_plugin ); ?></button>
							<input type="hidden" name="plugin_name" value="<?php echo $current_plugin;?>" />
							<input type="hidden" name="action" value="de_save_epanel" />
						</div><!-- end epanel-bottom div -->

					<?php } ?>

					</form>
					<div class="reset-popup-overlay">
						<div class="defaults-hover">
							<div class="reset-popup-header"><?php esc_html_e( 'Reset', $current_plugin ); ?></div>
							<?php echo et_get_safe_localization( __( 'This will return all of the settings throughout the options page to their default values. <strong>Are you sure you want to do this?</strong>', $current_plugin ) ); ?>
							<div class="et-clearfix"></div>
							<form method="post">
								<?php wp_nonce_field( 'et-nojs-reset_epanel', '_wpnonce_reset' ); ?>
								<input name="reset" type="submit" value="<?php esc_attr_e( 'Yes', $current_plugin ); ?>" id="epanel-reset" />
								<input type="hidden" name="action" value="reset" />
							</form>
							<span class="no"><?php esc_html_e( 'No', $current_plugin ); ?></span>
						</div>
					</div>

				</div> <!-- end panel-wrap div -->
			</div> <!-- end wrapper div -->

			<div id="epanel-ajax-saving">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/core/admin/images/ajax-loader.gif' ); ?>" alt="loading" id="loading" />
			</div>

			<script type="text/template" id="epanel-yes-no-button-template">
			<div class="et_pb_yes_no_button_wrapper">
				<div class="et_pb_yes_no_button"><!-- .et_pb_on_state || .et_pb_off_state -->
					<span class="et_pb_value_text et_pb_on_value"><?php esc_html_e( 'Enabled', $current_plugin ); ?></span>
					<span class="et_pb_button_slider"></span>
					<span class="et_pb_value_text et_pb_off_value"><?php esc_html_e( 'Disabled', $current_plugin ); ?></span>
				</div>
			</div>
			</script>

			<style type="text/css">
				#epanel p.postinfo-author .mark:after {
					content: '<?php esc_html_e( "Author", $current_plugin ); ?>';
				}

				#epanel p.postinfo-date .mark:after {
					content: '<?php esc_html_e( "Date", $current_plugin ); ?>';
				}

				#epanel p.postinfo-categories .mark:after {
					content: '<?php esc_html_e( "Categories", $current_plugin ); ?>';
				}

				#epanel p.postinfo-comments .mark:after {
					content: '<?php esc_html_e( "Comments", $current_plugin ); ?>';
				}

				#epanel p.postinfo-rating_stars .mark:after {
					content: '<?php esc_html_e( "Ratings", $current_plugin ); ?>';
				}
			</style>

		<?php
		}
	}

	$de_menu_obj = new de_menu();
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
if ( !function_exists( 'de_dmach_de_page' ) ) {
function de_dmach_de_page() {
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
                <tr valign="top" class="row-1 odd">
                    <th scope="row" class="first">
                        <label for="divi-bodyshop-woo_2696610e41262487"></label>
                    </th>
                    <td class="second tf-note">
                        <p class='description'>
                            <iframe class="nitro_videos" width="560" height="315"
                                    src="https://www.youtube.com/embed/jKio-EA4I0k" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </p>
                    </td>
                </tr>
                <tr valign="top" class="even first tf-heading">
                    <th scope="row" class="first last" colspan="2">
                        <h3 id="support">Support</h3>
                    </th>
                </tr>
                <tr valign="top" class="row-2 even">
                    <th scope="row" class="first">
                        <label for="divi-bodyshop-woo_6cec1d75697d2af1"></label>
                    </th>
                    <td class="second tf-note">
                        <p class='description'>We know that when building a website things may not always go according
                            to plan. If you experience issues when using our plugins do not worry we are here to help.
                            First take a look at our documentation <a href="https://help.diviengine.com/ "
                                                                      target="_blank">here</a> and if you cannot find a
                            solution, please contact us <a href="https://diviengine.com/support/"
                                                           target="_blank">here</a> and we will help you resolve any
                            issues.</p></td>
                </tr>
                <tr valign="top" class="even first tf-heading">
                    <th scope="row" class="first last" colspan="2">
                        <h3 id="feedback">Feedback</h3>
                    </th>
                </tr>
                <tr valign="top" class="row-3 odd">
                    <th scope="row" class="first">
                        <label for="divi-bodyshop-woo_cf59399160a5028e"></label>
                    </th>
                    <td class="second tf-note">
                        <p class='description'>We would love to hear from you, good or bad! We would really appreciate
                            it if you could leave a review on our product page so that it helps others!</p></td>
                </tr>
                <tr valign="top" class="even first tf-heading">
                    <th scope="row" class="first last" colspan="2">
                        <h3 id="do-you-have-idea?">Do you have idea?</h3>
                    </th>
                </tr>
                <tr valign="top" class="row-4 even">
                    <th scope="row" class="first">
                        <label for="divi-bodyshop-woo_6cb3afd29b1f9cf7"></label>
                    </th>
                    <td class="second tf-note">
                        <p class='description'>If you have an idea for how to improve our plugins, please dont hesitate
                            to contact us <a href="https://diviengine.com/contact/" target="_blank">here</a> as we
                            really want to make them better for everyone!</p></td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php
    }
}
}