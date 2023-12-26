<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_post_meta_item_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMACH_PRODUCT_URL,
  'author'     => DE_DMACH_AUTHOR,
  'author_uri' => DE_DMACH_URL,
);

                function init() {
                    $this->name       = esc_html__( 'Post Meta Item - Divi Machine', 'divi-machine' );
                    $this->slug = 'et_pb_de_mach_post_meta_item';
                		$this->vb_support      = 'on';
                		$this->type                        = 'child';
                		$this->child_title_var             = 'meta_item';
                    $this->advanced_setting_title_text = esc_html__( 'New Post Meta Item', 'divi-machine' );
                		$this->settings_text               = esc_html__( 'Post Meta Item Settings', 'divi-machine' );
						$this->folder_name = 'divi_machine';


                    $this->fields_defaults = array(
                    // 'loop_layout'         => array( 'on' ),
                    );

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Main Options', 'divi-machine' ),
                'specific'        => esc_html__( 'Specific Settings', 'divi-machine' ),
                'image'        => esc_html__( 'Image & Icon', 'divi-machine' ),
      				),
      			),
      			'advanced' => array(
      				'toggles' => array(
      					'text' => esc_html__( 'Text', 'divi-machine' ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';


                      $this->advanced_fields = array(
                  			'fonts' => array(
                  				'meta_item' => array(
                  					'label'    => esc_html__( 'Meta Item', 'divi-machine' ),
                  					'css'      => array(
                  						'main' => "%%order_class%% .dmach-postmeta-value",
                  						'important' => 'all',
                  					),
                  					'font_size' => array(
                  						'default' => '14px',
                  					),
                  					'line_height' => array(
                  						'default' => '1em',
                  					),
                  				),
                    				'meta_label' => array(
                    					'label'    => esc_html__( 'Label', 'divi-machine' ),
                    					'css'      => array(
                    						'main' => "%%order_class%% .dmach-acf-label",
                    						'important' => 'all',
                    					),
                    					'font_size' => array(
                    						'default' => '14px',
                    					),
                    					'line_height' => array(
                    						'default' => '1em',
                    					),
                    				),
                      				'meta_link' => array(
                      					'label'    => esc_html__( 'Link (not button)', 'divi-machine' ),
                      					'css'      => array(
                      						'main' => "%%order_class%% .dmach-postmeta-value a",
                      						'important' => 'all',
                      					),
                      					'font_size' => array(
                      						'default' => '14px',
                      					),
                      					'line_height' => array(
                      						'default' => '1em',
                      					),
                      				),
                  			),

                  			'margin_padding' => array(
                  				'css' => array(
                  					'important' => 'all',
                  				),
                  			),

              			'background' => array(
              				'settings' => array(
              					'color' => 'alpha',
              				),
              			),
                  			'button' => array(
                'button' => array(
                  'label' => esc_html__( 'Button - Meta Value', 'divi-machine' ),
                  'css' => array(
                    'main' => "{$this->main_css_element} .dmach-postmeta-value a.et_pb_button.meta_button",
                    'important' => 'all',
                  ),
                  'box_shadow'  => array(
                    'css' => array(
                      'main' => "{$this->main_css_element} .dmach-postmeta-value a.et_pb_button.meta_button",
                          'important' => 'all',
                    ),
                  ),
                  'margin_padding' => array(
                  'css'           => array(
                    'main' => "{$this->main_css_element} .dmach-postmeta-value a.et_pb_button.meta_button",
                    'important' => 'all',
                  ),
                  ),
                ),
                  			),
                  			'box_shadow' => array(
                  				'default' => array(),
                  				'product' => array(
                  					'label' => esc_html__( 'Default Layout - Box Shadow', 'divi-machine' ),
                  					'css' => array(
                  						'main' => "%%order_class%% .products .product",
                  					),
                  					'option_category' => 'layout',
                  					'tab_slug'        => 'advanced',
                  					'toggle_slug'     => 'product',
                  				),
                  			),
                  		);


                      $this->custom_css_fields = array(
                  			'item' => array(
                  				'label'       => esc_html__( 'Item', 'divi-machine' ),
                  				'selector'    => '.dmach-acf-value',
                  			),
                    			'text_before' => array(
                    				'label'       => esc_html__( 'Text Before', 'divi-machine' ),
                    				'selector'    => '.dmach-acf-before',
                    			),
                      			'label' => array(
                      				'label'       => esc_html__( 'Label', 'divi-machine' ),
                      				'selector'    => '.dmach-acf-label',
                      			),
                        			'image' => array(
                        				'label'       => esc_html__( 'Image', 'divi-machine' ),
                        				'selector'    => '.dmach-icon-image-content img',
                        			),
                  		);




            $this->help_videos = array(
            );
          }

                  function get_fields() {
                		$et_accent_color = et_builder_accent_color();

                    ///////////////////////////////
                    $sizes = get_intermediate_image_sizes();
                            foreach ($sizes as $size) {
                                $options[$size] = $size;
                            }


                //////////////////////////////
                  $fields = array(
                  'meta_item' => array(
                  'toggle_slug'       => 'main_content',
                    'label'             => esc_html__( 'Choose Your Meta Item', 'divi-machine' ),
                    'type'              => 'select',
                    'options'           => array(
                      'posted_date' => esc_html__( 'Posted Date', 'divi-machine' ),
                      'author' => sprintf( esc_html__( 'Author', 'divi-machine' ) ),
                      'categories' => sprintf( esc_html__( 'Categories', 'divi-machine' ) ),
                      'tags' => sprintf( esc_html__( 'Tags', 'divi-machine' ) ),
                      'taxonomy' => sprintf( esc_html__( 'Custom Taxonomy', 'divi-machine' ) ),
                    ),
                    'affects'         => array(
						'post_date_custom',
						'custom_tax_choose'
                    ),
                    'default' => 'posted_date',
                    'description'       => esc_html__( 'Choose where you want the icon or image to be.', 'divi-machine' ),
                  ),
                  'exclude_categories' => array(
                  'toggle_slug'       => 'main_content',
                    'label'             => esc_html__( 'Exclude Categories (slug)', 'divi-machine' ),
                    'type'              => 'text',
                    'option_category'   => 'configuration',
                    'default'           => '',
					'depends_show_if'  => 'categories',
                    'description'       => esc_html__( 'Add the slugs of your taxonomies comma-seperated to exclude them from the list', 'divi-machine' ),
                  ),
                  'custom_tax_choose' => array(
                  'toggle_slug'       => 'main_content',
                    'label'             => esc_html__( 'Choose Your Taxonomy', 'divi-machine' ),
                    'type'              => 'select',
                    'options'           => get_taxonomies( array( '_builtin' => FALSE ) ),
                    'option_category'   => 'configuration',
                    'default'           => 'post',
					'depends_show_if'  => 'taxonomy',
                    'description'       => esc_html__( 'Choose the custom taxonomy that you have made and want to show', 'divi-machine' ),
                  ),
                  'post_type_choose' => array(
                  'toggle_slug'       => 'main_content',
                    'label'             => esc_html__( 'Post Type', 'divi-machine' ),
                    'type'              => 'select',
                    'options'           => et_get_registered_post_type_options( false, false ),
                    'option_category'   => 'configuration',
                    'default'           => 'post',
                    'description'       => esc_html__( 'Choose the post type you want to search the category for', 'divi-machine' ),
                  ),
                      'show_label' => array(
                      'toggle_slug'       => 'main_content',
                        'label' => esc_html__( 'Show Label', 'divi-machine' ),
                        'type' => 'yes_no_button',
                        'options_category' => 'configuration',
                        'options' => array(
                          'on' => esc_html__( 'Yes', 'divi-machine' ),
                          'off' => esc_html__( 'No', 'divi-machine' ),
                        ),
                				'affects'         => array(
                  					'label_name',
                				),
                        'default' => 'on',
                        'description' => esc_html__( 'Enable this if you want to show the label of the ACF item.', 'divi-machine' )
                      ),
                      'label_name' => array(
                      'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Label Name', 'divi-machine' ),
                        'type'              => 'text',
                        'option_category'   => 'configuration',
                				'depends_show_if'   => 'on',
                        'default'           => '',
                        'description'       => esc_html__( 'Add the name for the label here', 'divi-machine' ),
                      ),
                          'link_item' => array(
                          'toggle_slug'       => 'main_content',
                            'label' => esc_html__( 'Link Items', 'divi-machine' ),
                            'type' => 'yes_no_button',
                            'options_category' => 'configuration',
                            'options' => array(
                              'on' => esc_html__( 'Yes', 'divi-machine' ),
                              'off' => esc_html__( 'No', 'divi-machine' ),
                            ),
                            'default' => 'on',
                            'description' => esc_html__( 'If you want to link the author, categories or tags - enable this.', 'divi-machine' )
                          ),
                      'use_icon' => array(
                				'label'           => esc_html__( 'Use Icon', 'divi-machine' ),
                				'type'            => 'yes_no_button',
                				'option_category' => 'basic_option',
                				'options'         => array(
                					'off' => esc_html__( 'No', 'divi-machine' ),
                					'on'  => esc_html__( 'Yes', 'divi-machine' ),
                				),
                				'toggle_slug'     => 'image',
                				'affects'         => array(
                					'font_icon',
                					'image_max_width',
                					'use_icon_font_size',
                					'use_circle',
                					'icon_color',
                					'image',
                					'alt',
                					'child_filter_hue_rotate',
                					'child_filter_saturate',
                					'child_filter_brightness',
                					'child_filter_contrast',
                					'child_filter_invert',
                					'child_filter_sepia',
                					'child_filter_opacity',
                					'child_filter_blur',
                					'child_mix_blend_mode',
                				),
                				'description' => esc_html__( 'Here you can choose whether icon set below should be used.', 'divi-machine' ),
                				'default_on_front'=> 'off',
                			),
                			'font_icon' => array(
                				'label'               => esc_html__( 'Icon', 'divi-machine' ),
                				'type'                => 'select_icon',
                				'option_category'     => 'basic_option',
                				'class'               => array( 'et-pb-font-icon' ),
                				'toggle_slug'         => 'image',
                				'description'         => esc_html__( 'Choose an icon to display with your ACF item.', 'divi-machine' ),
                				'depends_show_if'     => 'on',
                				'mobile_options'      => true,
                				'hover'               => 'tabs',
                			),
                			'icon_color' => array(
                				'default'           => $et_accent_color,
                				'label'             => esc_html__( 'Icon Color', 'divi-machine' ),
                				'type'              => 'color-alpha',
                				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi-machine' ),
                				'depends_show_if'   => 'on',
                				'tab_slug'          => 'advanced',
                				'toggle_slug'       => 'icon_settings',
                				'hover'             => 'tabs',
                				'mobile_options'    => true,
                			),
                			'use_circle' => array(
                				'label'           => esc_html__( 'Circle Icon', 'divi-machine' ),
                				'type'            => 'yes_no_button',
                				'option_category' => 'configuration',
                				'options'         => array(
                					'off' => esc_html__( 'No', 'divi-machine' ),
                					'on'  => esc_html__( 'Yes', 'divi-machine' ),
                				),
                				'affects'           => array(
                					'use_circle_border',
                					'circle_color',
                				),
                				'tab_slug'         => 'advanced',
                				'toggle_slug'      => 'icon_settings',
                				'description'      => esc_html__( 'Here you can choose whether icon set above should display within a circle.', 'divi-machine' ),
                				'depends_show_if'  => 'on',
                				'default_on_front'=> 'off',
                			),
                			'circle_color' => array(
                				'default'         => $et_accent_color,
                				'label'           => esc_html__( 'Circle Color', 'divi-machine' ),
                				'type'            => 'color-alpha',
                				'description'     => esc_html__( 'Here you can define a custom color for the icon circle.', 'divi-machine' ),
                				'depends_show_if' => 'on',
                				'tab_slug'        => 'advanced',
                				'toggle_slug'     => 'icon_settings',
                				'hover'           => 'tabs',
                				'mobile_options'  => true,
                			),
                			'use_circle_border' => array(
                				'label'           => esc_html__( 'Show Circle Border', 'divi-machine' ),
                				'type'            => 'yes_no_button',
                				'option_category' => 'layout',
                				'options'         => array(
                					'off' => esc_html__( 'No', 'divi-machine' ),
                					'on'  => esc_html__( 'Yes', 'divi-machine' ),
                				),
                				'affects'           => array(
                					'circle_border_color',
                				),
                				'description' => esc_html__( 'Here you can choose whether if the icon circle border should display.', 'divi-machine' ),
                				'depends_show_if'   => 'on',
                				'tab_slug'          => 'advanced',
                				'toggle_slug'       => 'icon_settings',
                				'default_on_front'  => 'off',
                			),
                			'circle_border_color' => array(
                				'default'         => $et_accent_color,
                				'label'           => esc_html__( 'Circle Border Color', 'divi-machine' ),
                				'type'            => 'color-alpha',
                				'description'     => esc_html__( 'Here you can define a custom color for the icon circle border.', 'divi-machine' ),
                				'depends_show_if' => 'on',
                				'tab_slug'        => 'advanced',
                				'toggle_slug'     => 'icon_settings',
                				'hover'           => 'tabs',
                				'mobile_options'  => true,
                			),
                			'image' => array(
                				'label'              => esc_html__( 'Custom Image before/after', 'divi-machine' ),
                				'type'               => 'upload',
                				'option_category'    => 'basic_option',
                				'upload_button_text' => esc_attr__( 'Upload an image', 'divi-machine' ),
                				'choose_text'        => esc_attr__( 'Choose an Image', 'divi-machine' ),
                				'update_text'        => esc_attr__( 'Set As Image', 'divi-machine' ),
                				'depends_show_if'    => 'off',
                				'description'        => esc_html__( 'Upload an image to display at the top of your ACF item.', 'divi-machine' ),
                				'toggle_slug'        => 'image',
                				'dynamic_content'    => 'image',
                				'mobile_options'     => true,
                				'hover'              => 'tabs',
                			),
                			'alt' => array(
                				'label'           => esc_html__( 'Image Alt Text', 'divi-machine' ),
                				'type'            => 'text',
                				'option_category' => 'basic_option',
                				'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'divi-machine' ),
                				'depends_show_if' => 'off',
                				'tab_slug'        => 'custom_css',
                				'toggle_slug'     => 'attributes',
                				'dynamic_content' => 'text',
                			),
                      'icon_image_placement' => array(
                      'option_category' => 'basic_option',
                      'toggle_slug'     => 'image',
                        'label'             => esc_html__( 'Image / Icon Placement', 'divi-machine' ),
                        'type'              => 'select',
                        'options'           => array(
                          'top' => esc_html__( 'Top', 'divi-machine' ),
                          'right' => sprintf( esc_html__( 'Right', 'divi-machine' ) ),
                          'bottom' => sprintf( esc_html__( 'Bottom', 'divi-machine' ) ),
                          'left' => sprintf( esc_html__( 'Left', 'divi-machine' ) ),
                        ),
                        'default' => 'left',
                        'description'       => esc_html__( 'Choose where you want the icon or image to be.', 'divi-machine' ),
                      ),

                			'image_max_width' => array(
                				'label'           => esc_html__( 'Custom Image before/after max width', 'divi-machine' ),
                				'description'     => esc_html__( 'Adjust the width of the image.', 'divi-machine' ),
                				'type'            => 'range',
                        'option_category' => 'basic_option',
                        'toggle_slug'     => 'image',
                				'mobile_options'  => true,
                				'validate_unit'   => true,
                				'depends_show_if' => 'off',
                				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                				'default'         => '100%',
                				'default_unit'    => '%',
                				'default_on_front'=> '',
                				'allow_empty'     => true,
                				'range_settings'  => array(
                					'min'  => '0',
                					'max'  => '100',
                					'step' => '1',
                				),
                				'responsive'      => true,
                			),
                			'values_as_btns' => array(
                				'label'           => esc_html__( 'Show Value/s as buttons?', 'divi-machine' ),
                				'type'            => 'yes_no_button',
                				'option_category' => 'basic_option',
                				'options'         => array(
                					'off' => esc_html__( 'No', 'divi-machine' ),
                					'on'  => esc_html__( 'Yes', 'divi-machine' ),
                				),
                				'description' => esc_html__( 'If you want the values to be buttons, enable this.', 'divi-machine' ),
                				'toggle_slug'       => 'specific',
                			),
                			'values_sep_line' => array(
                				'label'           => esc_html__( 'Put each value on a separate line?', 'divi-machine' ),
                				'type'            => 'yes_no_button',
                				'option_category' => 'basic_option',
                				'options'         => array(
                					'off' => esc_html__( 'No', 'divi-machine' ),
                					'on'  => esc_html__( 'Yes', 'divi-machine' ),
                				),
								'default'			=> 'off',
                				'description' => esc_html__( 'If you want each value on a separate line, enable this.', 'divi-machine' ),
                				'toggle_slug'       => 'specific',
                			),
                      'post_date_custom' => array(
                      'option_category' => 'basic_option',
                      'toggle_slug'     => 'specific',
                      	'depends_show_if'  => 'posted_date',
                      'default' => '',
                        'label'             => esc_html__( 'Custom Post Date Format', 'divi-machine' ),
                        'type'              => 'text',
                        'description'       => esc_html__( 'If you want a custom date format, add it here ', 'divi-machine' ),
                      ),
            'custom_seperator' => array(
            'option_category' => 'basic_option',
            'toggle_slug'     => 'specific',
              'label'             => esc_html__( 'Item Seperator', 'divi-machine' ),
              'type'              => 'text',
              'default'           => ', ',
              'description'       => esc_html__( 'Specify what you want to seperate the items (for example the categories)', 'divi-machine' ),
			  'show_if'			  => array(
				  					'values_sep_line' => 'off'
			  						)
            ),
            'prefix' => array(
            'option_category' => 'basic_option',
            'toggle_slug'     => 'specific',
              'label'             => esc_html__( 'Prefix', 'divi-machine' ),
              'type'              => 'text',
              'description'       => esc_html__( 'If you want text to appear directly before the Meta Item, add it here', 'divi-machine' ),
            ),
            'text_before' => array(
            'option_category' => 'basic_option',
            'toggle_slug'     => 'specific',
              'label'             => esc_html__( 'Text Before', 'divi-machine' ),
              'type'              => 'text',
              'description'       => esc_html__( 'If you want text to appear before the choice field, add it here', 'divi-machine' ),
            ),

                      );

                      return $fields;
                  }



                  function render($attrs, $content, $render_slug){

               

                    /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
                    $titan = TitanFramework::getInstance( 'divi-machine' );*/
                    $enable_debug = de_get_option_value('divi-machine', 'enable_debug'); //$titan->getOption( 'enable_debug' );




                    $meta_item                        = $this->props['meta_item'];
                    $custom_tax_choose                        = $this->props['custom_tax_choose'];
                    $exclude_categories                        = $this->props['exclude_categories'];

                    $post_type_choose                         = $this->props['post_type_choose'];


                		$use_icon                        = $this->props['use_icon'];
                		$font_icon                       = $this->props['font_icon'];

                    $link_item                       = $this->props['link_item'];



                		$icon_color                      = $this->props['icon_color'];
                		$icon_color_hover                = $this->get_hover_value( 'icon_color' );
                		$icon_color_values               = et_pb_responsive_options()->get_property_values( $this->props, 'icon_color' );
                		$icon_color_tablet               = isset( $icon_color_values['tablet'] ) ? $icon_color_values['tablet'] : '';
                		$icon_color_phone                = isset( $icon_color_values['phone'] ) ? $icon_color_values['phone'] : '';

                		$circle_color                    = $this->props['circle_color'];
                		$circle_color_hover              = $this->get_hover_value( 'circle_color' );
                		$circle_color_values             = et_pb_responsive_options()->get_property_values( $this->props, 'circle_color' );
                		$circle_color_tablet             = isset( $circle_color_values['tablet'] ) ? $circle_color_values['tablet'] : '';
                		$circle_color_phone              = isset( $circle_color_values['phone'] ) ? $circle_color_values['phone'] : '';

                    $show_label                      = $this->props['show_label'];
                    $label_name                      = $this->props['label_name'];

                    $image                           = $this->props['image'];
                    $alt                             = $this->props['alt'];
                    $icon_image_placement            = $this->props['icon_image_placement'];
                    $use_circle                      = $this->props['use_circle'];
                		$use_circle_border               = $this->props['use_circle_border'];

                    $circle_border_color             = $this->props['circle_border_color'];
                		$circle_border_color_hover       = $this->get_hover_value( 'circle_border_color' );
                		$circle_border_color_values      = et_pb_responsive_options()->get_property_values( $this->props, 'circle_border_color' );
                		$circle_border_color_tablet      = isset( $circle_border_color_values['tablet'] ) ? $circle_border_color_values['tablet'] : '';
                		$circle_border_color_phone       = isset( $circle_border_color_values['phone'] ) ? $circle_border_color_values['phone'] : '';

                    $icon_placement                  = $this->props['icon_image_placement'];
                		$icon_placement_values           = et_pb_responsive_options()->get_property_values( $this->props, 'icon_placement' );
                		$icon_placement_tablet           = isset( $icon_placement_values['tablet'] ) ? $icon_placement_values['tablet'] : '';
                		$icon_placement_phone            = isset( $icon_placement_values['phone'] ) ? $icon_placement_values['phone'] : '';
                		$is_icon_placement_responsive    = et_pb_responsive_options()->is_responsive_enabled( $this->props, 'icon_placement' );
                		$is_icon_placement_top           = ! $is_icon_placement_responsive ? 'top' === $icon_placement : in_array( 'top', $icon_placement_values );


                    $prefix                      = $this->props['prefix'];
                    $values_sep_line                      = $this->props['values_sep_line'];
                    $custom_seperator                      = $this->props['custom_seperator'];
					

                    $text_before                     = $this->props['text_before'];


                		$image_max_width                 = $this->props['image_max_width'];
                		$image_max_width_tablet          = $this->props['image_max_width_tablet'];
                		$image_max_width_phone           = $this->props['image_max_width_phone'];
                		$image_max_width_last_edited     = $this->props['image_max_width_last_edited'];

                    $post_date_custom     = $this->props['post_date_custom'];

                    $value_button     = $this->props['values_as_btns'];


					
                    if( $values_sep_line == 'on' ){
						ET_Builder_Element::set_style( $render_slug, array(
						  'selector'    => '%%order_class%% .dmach-postmeta-value a, %%order_class%% .dmach-postmeta-value span',
						  'declaration' => "display: block !important;",
						) );
					  }


                    if ( !empty( $font_icon ) ) {
                      if ( class_exists( 'DE_Filter' ) ) {
                          $font_icon_rendered = DE_Filter::et_icon_css_content( esc_attr($font_icon) );
                      } else if ( class_exists( 'DEBC_INIT' ) ) {
                          $font_icon_rendered = DEBC_INIT::et_icon_css_content( esc_attr($font_icon) );
                      } else if ( class_exists( 'DEDMACH_INIT' ) ) {
                          $font_icon_rendered = DEDMACH_INIT::et_icon_css_content( esc_attr($font_icon) );
                      }

                      $font_icon_arr = explode('||', $font_icon);
                      $font_icon_font_family = ( !empty( $font_icon_arr[1] ) && $font_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                      $font_icon_font_weight = ( !empty( $font_icon_arr[2] ))?$font_icon_arr[2]:'400';
                    }

                		$is_image_svg   = isset( $image_pathinfo['extension'] ) ? 'svg' === $image_pathinfo['extension'] : false;

                    $icon_selector = '%%order_class%% .dmach-icon';

                    if ( '' !== $image_max_width_tablet || '' !== $image_max_width_phone || '' !== $image_max_width || $is_image_svg ) {
                			$is_size_px = false;

                			// If size is given in px, we want to override parent width
                			if (
                				false !== strpos( $image_max_width, 'px' ) ||
                				false !== strpos( $image_max_width_tablet, 'px' ) ||
                				false !== strpos( $image_max_width_phone, 'px' )
                			) {
                				$is_size_px = true;
                			}
                			// SVG image overwrite. SVG image needs its value to be explicit
                			if ( '' === $image_max_width && $is_image_svg ) {
                				$image_max_width = '100%';
                			}

                			// Image max width selector.
                			$image_max_width_selectors       = array();
                			$image_max_width_reset_selectors = array();
                			$image_max_width_reset_values    = array();

                			$image_max_width_selector = $is_image_svg ? '%%order_class%% .dmach-icon-image-content img' : '%%order_class%% .dmach-icon-image-content img';


                      foreach ( array( 'tablet', 'phone' ) as $device ) {
                        $device_icon_placement = 'tablet' === $device ? $icon_placement_tablet : $icon_placement_phone;
                        if ( empty( $device_icon_placement ) ) {
                          continue;
                        }

                        $image_max_width_selectors[ $device ] = 'top' === $device_icon_placement && $is_image_svg ? '%%order_class%% .dmach-icon-image-content' : '%%order_class%% .dmach-icon-image-content';

                        $prev_icon_placement = 'tablet' === $device ? $icon_placement : $icon_placement_tablet;
                        if ( empty( $prev_icon_placement ) || $prev_icon_placement === $device_icon_placement || ! $is_image_svg ) {
                          continue;
                        }

                        // Image/icon placement setting is related to image width setting. In some cases,
                        // user uses different image/icon placement settings for each devices. We need to
                        // reset previous device image width styles to make it works with current style.
                        $image_max_width_reset_selectors[ $device ] = '%%order_class%% .dmach-icon-image-content';
                        $image_max_width_reset_values[ $device ]    = array( 'width' => '32px' );

                        if ( 'top' === $device_icon_placement ) {
                          $image_max_width_reset_selectors[ $device ] = '%%order_class%% .dmach-icon-image-content';
                          $image_max_width_reset_values[ $device ]    = array( 'width' => 'auto' );
                        }
                      }

                      // Add image max width desktop selector if user sets different image/icon placement setting.
                      if ( ! empty( $image_max_width_selectors ) ) {
                        $image_max_width_selectors['desktop'] = $image_max_width_selector;
                      }

                      $image_max_width_property = ( $is_image_svg || $is_size_px ) ? 'width' : 'max-width';

                      $image_max_width_responsive_active = et_pb_get_responsive_status( $image_max_width_last_edited );

                      $image_max_width_values = array(
                        'desktop' => $image_max_width,
                        'tablet'  => $image_max_width_responsive_active ? $image_max_width_tablet : '',
                        'phone'   => $image_max_width_responsive_active ? $image_max_width_phone : '',
                      );

                      $main_image_max_width_selector = $image_max_width_selector;

                      // Overwrite image max width if there are image max width selectors for different devices.
                      if ( ! empty( $image_max_width_selectors ) ) {
                        $main_image_max_width_selector = $image_max_width_selectors;

                        if ( ! empty( $image_max_width_selectors['tablet'] ) && empty( $image_max_width_values['tablet'] ) ) {
                          $image_max_width_values['tablet'] = $image_max_width_responsive_active ? esc_attr( et_pb_responsive_options()->get_any_value( $this->props, 'image_max_width_tablet', '100%', true ) ) : esc_attr( $image_max_width );
                        }

                        if ( ! empty( $image_max_width_selectors['phone'] ) && empty( $image_max_width_values['phone'] ) ) {
                          $image_max_width_values['phone'] = $image_max_width_responsive_active ? esc_attr( et_pb_responsive_options()->get_any_value( $this->props, 'image_max_width_phone', '100%', true ) ) : esc_attr( $image_max_width );
                        }
                      }


                      et_pb_responsive_options()->generate_responsive_css( $image_max_width_values, $main_image_max_width_selector, $image_max_width_property, $render_slug );

                			// Reset custom image max width styles.
                			if ( ! empty( $image_max_width_selectors ) && ! empty( $image_max_width_reset_selectors ) ) {
                				et_pb_responsive_options()->generate_responsive_css( $image_max_width_reset_values, $image_max_width_reset_selectors, $image_max_width_property, $render_slug, '', 'input' );
                			}
                		}


                    if ( 'off' === $use_icon ) {
                		} else {
                			$icon_style        = sprintf( 'color: %1$s;', esc_attr( $icon_color ) );
                			$icon_tablet_style = '' !== $icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $icon_color_tablet ) ) : '';
                			$icon_phone_style  = '' !== $icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $icon_color_phone ) ) : '';
                			$icon_style_hover  = '';

                			if ( et_builder_is_hover_enabled( 'icon_color', $this->props ) ) {
                				$icon_style_hover = sprintf( 'color: %1$s;', esc_attr( $icon_color_hover ) );
                			}

                			if ( 'on' === $use_circle ) {
                				$icon_style .= sprintf( ' background-color: %1$s;', esc_attr( $circle_color ) );
                				$icon_tablet_style .= '' !== $circle_color_tablet ? sprintf( ' background-color: %1$s;', esc_attr( $circle_color_tablet ) ) : '';
                				$icon_phone_style  .= '' !== $circle_color_phone ? sprintf( ' background-color: %1$s;', esc_attr( $circle_color_phone ) ) : '';

                				if ( et_builder_is_hover_enabled( 'circle_color', $this->props ) ) {
                					$icon_style_hover .= sprintf( ' background-color: %1$s;', esc_attr( $circle_color_hover ) );
                				}

                				if ( 'on' === $use_circle_border ) {
                					$icon_style .= sprintf( ' border-color: %1$s;', esc_attr( $circle_border_color ) );
                					$icon_tablet_style .= '' !== $circle_border_color_tablet ? sprintf( ' border-color: %1$s;', esc_attr( $circle_border_color_tablet ) ) : '';
                					$icon_phone_style  .= '' !== $circle_border_color_phone ? sprintf( ' border-color: %1$s;', esc_attr( $circle_border_color_phone ) ) : '';

                					if ( et_builder_is_hover_enabled( 'circle_border_color', $this->props ) ) {
                						$icon_style_hover .= sprintf( ' border-color: %1$s;', esc_attr( $circle_border_color_hover ) );
                					}
                				}
                			}

                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .dmach-icon:before',
                        'declaration' => sprintf(
                          'content: "%1$s";
                          color: %2$s;
                          font-family:"%3$s"!important;
                          font-weight:%4$s;',
                          isset($font_icon_rendered) ? esc_html( $font_icon_rendered ) : '',
                          $icon_color,
                          $font_icon_font_family ?? '',
                          $font_icon_font_weight ?? ''
                        ),
                      ) );

                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .dmach-icon:hover:before',
                        'declaration' => sprintf(
                          'color: %1$s',
                          $icon_color_hover
                        ),
                      ) );

                			ET_Builder_Element::set_style( $render_slug, array(
                				'selector'    => $icon_selector,
                				'declaration' => $icon_style,
                			) );

                			ET_Builder_Element::set_style( $render_slug, array(
                				'selector'    => $icon_selector,
                				'declaration' => $icon_tablet_style,
                				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
                			) );

                			ET_Builder_Element::set_style( $render_slug, array(
                				'selector'    => $icon_selector,
                				'declaration' => $icon_phone_style,
                				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
                			) );


                    			if ( '' !== $icon_style_hover ) {
                				ET_Builder_Element::set_style( $render_slug, array(
                					'selector'    => $this->add_hover_to_order_class( $icon_selector ),
                					'declaration' => $icon_style_hover,
                				) );
                			}

                			$image_classes[] = 'et-pb-icon';

                			if ( 'on' === $use_circle ) {
                				$image_classes[] = 'et-pb-icon-circle';
                			}

                			if ( 'on' === $use_circle && 'on' === $use_circle_border ) {
                				$image_classes[] = 'et-pb-icon-circle-border';
                			}


                		}

                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    if ($enable_debug == "1") {
										if (isset($acf_name)) {
                    $acf_get = get_field_object($acf_name);
                      ?>
                      <div class="reporting_args hidethis">
                        Post Type: <?php echo esc_html__($post_type_choose); ?><br>
                        Meta Item: <?php echo esc_html__($meta_item); ?><br>
                      </div>
                      <?php
										}
                    }


                    if ($show_label == "on") {
                      $show_label_dis =  $label_name;
                      $show_label_dis = '<span class="dmach-acf-label">' . $show_label_dis . '</span>';
                    } else {
                      $show_label_dis = "";
                    }

                    if ($use_icon == "on") {
                    $icon_image_dis = '<div class="dmach-icon-image-content"><span class="dmach-icon"></span></div>';
                    } else {
                      if ($image != "") {
                    $icon_image_dis = '<div class="dmach-icon-image-content"><img src="'.$image.'"></div>';
                  } else {
                    $icon_image_dis = "";
                  }
                    }

                    if ($icon_image_placement == "top" || $icon_image_placement == "left") {
                      $icon_image_placement_left = $icon_image_dis;
                      $icon_image_placement_right = "";
                    } else {
                      $icon_image_placement_left = "";
                      $icon_image_placement_right = $icon_image_dis;
                    }

                    $this->add_classname( 'dmach-image-icon-placement-' . $icon_image_placement . '' );


                    if ($value_button == "on") {
                      $value_button_name = "et_pb_button meta_button";
                    } else {
                      $value_button_name = "";
                    }

                    ////////////////////////////////////////////////////
                    //  fields
                    ////////////////////////////////////////////////////
$post   = get_post( get_the_ID() );
$current_post_type = get_post_type( get_the_ID() );

if ($meta_item == "posted_date") {

if ($post_date_custom == "") {
$item_value = get_the_time('F jS, Y');
} else {
$post_date_custom = str_replace("*","\\",$post_date_custom);
$item_value = get_the_time($post_date_custom);
}


?>
<div class="dmach-postmeta-item-containter">
<?php echo $icon_image_placement_left; ?>
<div class="dmach-postmeta-item-content">
<?php if ($text_before != ""){ ?><p class="dmach-postmeta-before"><?php echo $text_before ?></p><?php } ?>
<p class="dmach-postmeta-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><span class="<?php echo $value_button_name ?>"><?php echo $item_value; ?></span></p>
    </div>
<?php echo $icon_image_placement_right; ?>
 </div>
 <?php

} else if ($meta_item == "author") {

if ($link_item == "on") {
  $link_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
  $item_value = '<a href="' .$link_url. '">'. get_the_author(). '</a>';

} else {
  $item_value = get_the_author();
}


?>
<div class="dmach-postmeta-item-containter">
<?php echo $icon_image_placement_left; ?>
<div class="dmach-postmeta-item-content">
<?php if ($text_before != ""){ ?><p class="dmach-postmeta-before"><?php echo $text_before ?></p><?php } ?>
<p class="dmach-postmeta-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><span class="<?php echo $value_button_name ?>"><?php echo $item_value; ?></span></p>
    </div>
<?php echo $icon_image_placement_right; ?>
 </div>
 <?php

} else if ($meta_item == "categories") {

	$exclude_categories_array = explode(', ', $exclude_categories);

	if ($post_type_choose == 'post' || $post_type_choose == 'page') {
  $cat_key = 'category';
  $get_categories = wp_get_post_categories(get_the_ID());
  } else {
  $ending = "_category";
  $cat_key = $post_type_choose . $ending;
  $get_categories = get_the_terms( get_the_ID(), $cat_key, array('hide_empty' => false, 'orderby' => 'term_order', 'order' => 'ASC') );
}

  if ( $get_categories && ! is_wp_error( $get_categories ) ) {
  $cats_array = array();
  foreach ( $get_categories as $cat ) {



		if ($post_type_choose == 'post' || $post_type_choose == 'page') {
			$term = get_queried_object();
			$category = get_category( $cat );
			$term_slug = !empty( $category )?$category->slug:$category->slug;

			if (in_array($term_slug, $exclude_categories_array)) {
			} else {
				if ($link_item == "on") {
					$cats_array[] = '<a class="'. $value_button_name . ' dmach_cat_'.$term_slug.'" href="'.get_term_link( $cat ).'">'.  get_cat_name( $cat ) .'</a>';
				} else {
					$cats_array[] = '<span class="dmach_cat_'.$term_slug.'">'.  get_cat_name( $cat ) .'</span>';
				}
			}

		} else {

			if (in_array($cat->slug, $exclude_categories_array)) {
			} else {
				if ($link_item == "on") {
					$cats_array[] = '<a class=" '. $value_button_name . ' dmach_cat_'.$cat->slug.'" href="'.get_term_link( $cat ).'">'.$cat->name.'</a>';
				} else {
					$cats_array[] = '<span class="dmach_cat_'.$cat->slug.'">'.$cat->name.'</span>';
				}
			}

		}



  }
        if ($value_button == "on") {
  $cats_list = join( "", $cats_array );
        } else if ($values_sep_line == "on") {
			$cats_list = join( "", $cats_array );
		} else {
  $cats_list = join( $custom_seperator, $cats_array );
          }

  $item_value = $cats_list;
  ?>
  <div class="dmach-postmeta-item-containter">
  <?php echo $icon_image_placement_left; ?>
  <div class="dmach-postmeta-item-content">
  <?php if ($text_before != ""){ ?><p class="dmach-postmeta-before"><?php echo $text_before ?></p><?php } ?>
  <p class="dmach-postmeta-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $item_value; ?></p>
      </div>
  <?php echo $icon_image_placement_right; ?>
   </div>
   <?php
}





} else if ($meta_item == "tags") {

	if ($post_type_choose == 'post' || $post_type_choose == 'page') {
		$cat_key = 'post_tag';
	} else {
		$ending = "_tag";
		$cat_key = $current_post_type . $ending;
	}
$terms = get_the_terms( get_the_ID(), $cat_key, array('hide_empty' => false, 'orderby' => 'term_order', 'order' => 'ASC') );

  if ( $terms && ! is_wp_error( $terms ) ) {
$terms_array = array();
foreach ( $terms as $term ) {

if ($link_item == "on") {
  $terms_array[] = '<a class="'. $value_button_name .' dmach_tag_'.$term->slug.'" href="'.get_term_link( $term ).'">'.$term->name.'</a>';
        } else {
$terms_array[] = '<span class="dmach_tag_'.$term->slug.'">'.$term->name.'</span>';
        }
}

  if ($value_button == "on") {
$terms_list = join( "", $terms_array );
  } else if ($values_sep_line == "on") {
	$terms_list = join( "", $terms_array );
} else {
$terms_list = join( $custom_seperator, $terms_array );
    }


$item_value = $terms_list;

?>
<div class="dmach-postmeta-item-containter">
<?php echo $icon_image_placement_left; ?>
<div class="dmach-postmeta-item-content">
<?php if ($text_before != ""){ ?><p class="dmach-postmeta-before"><?php echo $text_before ?></p><?php } ?>
<p class="dmach-postmeta-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $item_value; ?></p>
    </div>
<?php echo $icon_image_placement_right; ?>
 </div>
 <?php

 }

} else if ($meta_item == "taxonomy") {

	$exclude_categories_array = explode(', ', $exclude_categories);

	$terms = get_the_terms( get_the_ID(), $custom_tax_choose, array('hide_empty' => false, 'orderby' => 'term_order', 'order' => 'ASC') );

	if ( $terms && ! is_wp_error( $terms ) ) {
  $terms_array = array();
  foreach ( $terms as $term ) {
	  
	if (in_array($term->slug, $exclude_categories_array)) {

	} else {
		if ($link_item == "on") {
			$terms_array[] = '<a class="'. $value_button_name .' dmach_tax_'.$term->slug.'" href="'.get_term_link( $term ).'">'.$term->name.'</a>';
		} else {
			$terms_array[] = '<span class="dmach_tax_'.$term->slug.'">'.$term->name.'</span>';
		}
	}
  }
  
	if ($value_button == "on") {
  $terms_list = join( "", $terms_array );
	} else if ($values_sep_line == "on") {
		$terms_list = join( "", $terms_array );
	} else {
  $terms_list = join( $custom_seperator, $terms_array );
	  }
  
  
  $item_value = $terms_list;
  
  ?>
  <div class="dmach-postmeta-item-containter">
  <?php echo $icon_image_placement_left; ?>
  <div class="dmach-postmeta-item-content">
  <?php if ($text_before != ""){ ?><p class="dmach-postmeta-before"><?php echo $text_before ?></p><?php } ?>
  <p class="dmach-postmeta-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $item_value; ?></p>
	  </div>
  <?php echo $icon_image_placement_right; ?>
   </div>
   <?php

	}

} else {

}


                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;



              }

            }

            new de_mach_post_meta_item_code;

?>
