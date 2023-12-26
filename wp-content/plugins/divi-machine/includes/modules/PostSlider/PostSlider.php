<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_mach_post_slider_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMACH_PRODUCT_URL,
  'author'     => DE_DMACH_AUTHOR,
  'author_uri' => DE_DMACH_URL,
);

                function init() {
                    $this->name       = esc_html__( 'Post Slider - Divi Machine', 'divi-machine' );
                    $this->slug = 'et_pb_db_mach_post_slider';
                    $this->folder_name = 'divi_machine';

                    $this->fields_defaults = array(
                			'show_arrows'             => array( 'on' ),
                			'show_pagination'         => array( 'on' ),
                			'auto'                    => array( 'off' ),
                			'auto_speed'              => array( '7000' ),
                			'auto_ignore_hover'       => array( 'off' ),
                			'parallax'                => array( 'off' ),
                			'parallax_method'         => array( 'off' ),
                			'show_inner_shadow'       => array( 'on' ),
                			'background_position'     => array( 'center' ),
                			'background_size'         => array( 'cover' ),
                			'show_content_on_mobile'  => array( 'on' ),
                			'show_cta_on_mobile'      => array( 'on' ),
                			'show_image_video_mobile' => array( 'off' ),
                			'more_text'               => array( 'Read More' ),
                			'background_color'        => array( '' ),
                			'image_placement'         => array( 'background' ),
                			'background_layout'       => array( 'dark' ),
                			'orderby'                 => array( 'date_desc' ),
                			'excerpt_length'          => array( '270' ),
                			'use_bg_overlay'          => array( 'on' ),
                			'show_more_button'        => array( 'on' ),
                			'show_image'              => array( 'on' ),
                			'text_orientation'        => array( 'center' ),
                		);

          $this->settings_modal_toggles = array(
            'general'  => array(
              'toggles' => array(
                'main_content'   => esc_html__( 'Content', 'divi-machine' ),
                'elements'       => esc_html__( 'Elements', 'divi-machine' ),
                'featured_image' => esc_html__( 'Featured Image', 'divi-machine' ),
                'background'     => esc_html__( 'Background', 'divi-machine' ),
              ),
            ),
            'advanced' => array(
              'toggles' => array(
                'layout'     => esc_html__( 'Layout', 'divi-machine' ),
                'overlay'    => esc_html__( 'Overlay', 'divi-machine' ),
                'navigation' => esc_html__( 'Navigation', 'divi-machine' ),
                'text'       => array(
                  'title'    => esc_html__( 'Text', 'divi-machine' ),
                  'priority' => 49,
                ),
              ),
            ),
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'divi-machine' ),
						'priority' => 90,
					),
				),
			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
                        'fonts' => array(
                          'header' => array(
                            'label'    => esc_html__( 'Header', 'divi-machine' ),
                            'css'      => array(
                              'main' => "{$this->main_css_element} .et_pb_slide_description .et_pb_slide_title",
                              'important' => array( 'size', 'font-size', 'plugin_all' ),
                            ),
                          ),
                          'body'   => array(
                            'label'    => esc_html__( 'Body', 'divi-machine' ),
                            'css'      => array(
                              'line_height' => "{$this->main_css_element}, {$this->main_css_element} .et_pb_slide_content",
                              'main' => "{$this->main_css_element} .et_pb_slide_content, {$this->main_css_element} .et_pb_slide_content div",
                              'important' => 'all',
                            ),
                          ),
                        ),
                        'button' => array(
                  				'button' => array(
                  					'label' => esc_html__( 'Button', 'divi-machine' ),
                  					'css' => array(
                  						'plugin_main' => "{$this->main_css_element} .et_pb_more_button.et_pb_button",
                  						'alignment' => "{$this->main_css_element} .et_pb_button_wrapper",
                  					),
                            'box_shadow'  => array(
                              'css' => array(
                                'main' => "{$this->main_css_element} .et_pb_more_button.et_pb_button",
                              ),
                            ),
                  					'use_alignment' => true,
                  				),
                  			),
                  			'background' => array(
                  				'css' => array(
                  					'main' => "{$this->main_css_element}, {$this->main_css_element}.et_pb_bg_layout_dark"
                  				),
                  			),
                          'border' => array(
                              'css' => array(
                                  'important' => 'all',
                              ),
                          ),
                    			'custom_margin_padding' => array(
                    				'css' => array(
                    					'main' => '%%order_class%%',
                    					'padding' => '%%order_class%% .et_pb_slide_description, .et_pb_slider_fullwidth_off%%order_class%% .et_pb_slide_description',
                    					'important' => array( 'custom_margin' ), // needed to overwrite last module margin-bottom styling
                    				),
                    			),
                      );

                  		$this->custom_css_fields = array(
                  			'slide_description' => array(
                  				'label'    => esc_html__( 'Slide Description', 'divi-machine' ),
                  				'selector' => '.et_pb_slide_description',
                  			),
                  			'slide_title' => array(
                  				'label'    => esc_html__( 'Slide Title', 'divi-machine' ),
                  				'selector' => '.et_pb_slide_description .et_pb_slide_title',
                  			),
                  			'slide_button' => array(
                  				'label'    => esc_html__( 'Slide Button', 'divi-machine' ),
                  				'selector' => '.et_pb_slider a.et_pb_more_button.et_pb_button',
                  				'no_space_before_selector' => true,
                  			),
                  			'slide_controllers' => array(
                  				'label'    => esc_html__( 'Slide Controllers', 'divi-machine' ),
                  				'selector' => '.et-pb-controllers',
                  			),
                  			'slide_active_controller' => array(
                  				'label'    => esc_html__( 'Slide Active Controller', 'divi-machine' ),
                  				'selector' => '.et-pb-controllers .et-pb-active-control',
                  			),
                  			'slide_image' => array(
                  				'label'    => esc_html__( 'Slide Image', 'divi-machine' ),
                  				'selector' => '.et_pb_slide_image',
                  			),
                  			'slide_arrows' => array(
                  				'label'    => esc_html__( 'Slide Arrows', 'divi-machine' ),
                  				'selector' => '.et-pb-slider-arrows a',
                  			),
                  		);

                  }

                  function get_fields() {

        $acf_fields = DEDMACH_INIT::get_acf_fields();

    		$fields = array(
        'post_type_choose' => array(
        'toggle_slug'       => 'main_content',
          'label'             => esc_html__( 'Post Type', 'divi-machine' ),
          'type'              => 'select',
          'options'           => et_get_registered_post_type_options( false, false ),
          'option_category'   => 'configuration',
          'default'           => 'post',
          'computed_affects'  => array(
            '__postslider',
          ),
          'description'       => esc_html__( 'Choose the post type you want to display', 'divi-machine' ),
        ),
          'posts_number' => array(
            'label'             => esc_html__( 'Product Display Number', 'divi-machine' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'description'       => esc_html__( 'Choose how many products you would like to display in the slider.', 'divi-machine' ),
            'toggle_slug'       => 'main_content',
            'computed_affects'  => array(
              '__postslider',
            ),
          ),
          'include_categories' =>  array(
            'label'             => esc_html__( 'Include Categories', 'divi-machine' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'description'       => esc_html__( 'Add the categories/category you ONLY want to be shown (comma-seperated). You need to use the category slug so no spaces with "-" between if you have a space in the category name', 'divi-machine' ),
            'toggle_slug'       => 'main_content',
            'computed_affects'  => array(
              '__postslider',
            ),
          ),
          'include_tags' => array(
            'toggle_slug'       => 'main_content',
            'option_category'   => 'configuration',
            'label'           => esc_html__( 'Include Tags (IDs comma-seperated)', 'divi-machine' ),
            'type'            => 'text',
            'computed_affects' => array(
              '__postslider',
            ),
            'description'     => esc_html__( 'Add a list of tag IDs that you want to include to show. This will remove all products that dont have these tags. (comma-seperated)', 'divi-machine' ),
          ),
          'custom_tax_choose' => array(
            'toggle_slug'       => 'main_content',
            'label'             => esc_html__( 'Choose Your Taxonomy', 'divi-machine' ),
            'type'              => 'select',
            'options'           => get_taxonomies( array( '_builtin' => FALSE ) ),
            'option_category'   => 'configuration',
            'default'           => 'post',
            'depends_show_if'   => 'taxonomy',
            'description'       => esc_html__( 'Choose the custom taxonomy that you have made and want to filter', 'divi-machine' ),
          ),
          'include_taxomony' => array(
            'toggle_slug'       => 'main_content',
            'option_category'   => 'configuration',
            'label'           => esc_html__( 'Include Custom Taxonomy (comma-seperated)', 'divi-machine' ),
            'type'            => 'text',
            'computed_affects' => array(
              '__postslider',
            ),
            'description'     => esc_html__( 'Add a list of values that you want to show - make sure to specify the custom taxonomy above, it will then show the posts that have the values here from that custom taxonomy. (comma-seperated)', 'divi-machine' ),
          ),
          'acf_name' => array(
            'toggle_slug'       => 'main_content',
            'label'             => esc_html__( 'Filter By ACF Name', 'divi-machine' ),
            'type'              => 'select',
            'options'           => $acf_fields,
            'default'           => 'none',
            'option_category'   => 'configuration',
            'computed_affects' => array(
              '__postslider',
            ),
            'description'       => esc_html__( 'Filter by this ACF name and then the value below', 'divi-machine' ),
          ),
          'acf_value' => array(
            'toggle_slug'       => 'main_content',
            'option_category'   => 'configuration',
            'label'           => esc_html__( 'ACF Value', 'divi-machine' ),
            'type'            => 'text',
            'computed_affects' => array(
              '__postslider',
            ),
            'description'     => esc_html__( 'Add the value here, it will show posts only with the value of the ACF field above', 'divi-machine' ),
          ),
          'orderby' => array(
            'label'             => esc_html__( 'Order By', 'divi-machine' ),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'options'           => array(
              'date_desc'  => esc_html__( 'Date: new to old', 'divi-machine' ),
              'date_asc'   => esc_html__( 'Date: old to new', 'divi-machine' ),
              'title_asc'  => esc_html__( 'Title: a-z', 'divi-machine' ),
              'title_desc' => esc_html__( 'Title: z-a', 'divi-machine' ),
              'rand'       => esc_html__( 'Random', 'divi-machine' ),
            ),
            'toggle_slug'       => 'main_content',
            'description'       => esc_html__( 'Here you can adjust the order in which products are displayed.', 'divi-machine' ),
            'computed_affects'  => array(
              '__postslider',
            ),
          ),
          'show_arrows'         => array(
            'label'           => esc_html__( 'Show Arrows', 'divi-machine' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'on'  => esc_html__( 'yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'toggle_slug'     => 'elements',
            'description'     => esc_html__( 'This setting will turn on and off the navigation arrows.', 'divi-machine' ),
          ),
          'show_pagination' => array(
            'label'             => esc_html__( 'Show Controls', 'divi-machine' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'toggle_slug'       => 'elements',
            'description'       => esc_html__( 'This setting will turn on and off the circle buttons at the bottom of the slider.', 'divi-machine' ),
          ),
          'show_more_button' => array(
            'label'             => esc_html__( 'Show Read More Button', 'divi-machine' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'affects' => array(
              'more_text',
            ),
            'toggle_slug'       => 'elements',
            'description'       => esc_html__( 'This setting will turn on and off the read more button.', 'divi-machine' ),
          ),
          'more_text' => array(
            'label'             => esc_html__( 'Button Text', 'divi-machine' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'depends_show_if'   => 'on',
            'toggle_slug'       => 'main_content',
            'description'       => esc_html__( 'Define the text which will be displayed on "Read More" button. leave blank for default ( Read More )', 'divi-machine' ),
          ),
          'content_source' => array(
            'label'             => esc_html__( 'Content Display', 'divi-machine' ),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'options'           => array(
              'off' => esc_html__( 'Show Short Description', 'divi-machine' ),
              'on'  => esc_html__( 'Show Content', 'divi-machine' ),
            ),
            'default' => 'off',
            'affects' => array(
              'use_manual_excerpt',
              'excerpt_length',
            ),
            'description'       => esc_html__( 'Showing the full content will not truncate your products in the slider. Showing the Short Description will only display the Short Description text.', 'divi-machine' ),
            'toggle_slug'       => 'main_content',
          ),
          'use_manual_excerpt' => array(
            'label'             => esc_html__( 'Use Product Short Description if Defined', 'divi-machine' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'depends_show_if'   => 'off',
            'description'       => esc_html__( 'Disable this option if you want to ignore manually defined Short Descriptions and always generate it automatically.', 'divi-machine' ),
            'toggle_slug'       => 'main_content',
          ),
          'excerpt_length' => array(
            'label'             => esc_html__( 'Automatic Short Description Length', 'divi-machine' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'depends_show_if'   => 'off',
            'description'       => esc_html__( 'Define the length of automatically generated Short Description. Leave blank for default ( 270 ) ', 'divi-machine' ),
            'toggle_slug'       => 'main_content',
          ),
          'background_layout' => array(
            'label'           => esc_html__( 'Text Color', 'divi-machine' ),
            'type'            => 'select',
            'option_category' => 'color_option',
            'options'         => array(
              'dark'  => esc_html__( 'Light', 'divi-machine' ),
              'light' => esc_html__( 'Dark', 'divi-machine' ),
            ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'text',
            'computed_affects'  => array(
              '__postslider',
            ),
            'description'     => esc_html__( 'Here you can choose whether your text is light or dark. If you have a slide with a dark background, then choose light text. If you have a light background, then use dark text.' , 'divi-machine' ),
          ),
          'show_image' => array(
            'label'             => esc_html__( 'Show Product Image', 'divi-machine' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'affects' => array(
              'image_placement',
            ),
            'toggle_slug'       => 'featured_image',
            'description'       => esc_html__( 'This setting will turn on and off the featured image in the slider.', 'divi-machine' ),
          ),
          'image_placement' => array(
            'label'             => esc_html__( 'Image Placement', 'divi-machine' ),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'options'           => array(
              'background' => esc_html__( 'Background', 'divi-machine' ),
              'left'       => esc_html__( 'Left', 'divi-machine' ),
              // 'right'      => esc_html__( 'Right', 'divi-machine' ),
              // 'top'        => esc_html__( 'Top', 'divi-machine' ),
              // 'bottom'     => esc_html__( 'Bottom', 'divi-machine' ),
            ),
            'depends_show_if'   => 'on',
            'toggle_slug'       => 'featured_image',
            'computed_affects'  => array(
              '__postslider',
            ),
            'description'       => esc_html__( 'Select how you would like to display the featured image in slides', 'divi-machine' ),
          ),
          'use_bg_overlay'      => array(
            'label'           => esc_html__( 'Use Background Overlay', 'divi-machine' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'on'  => esc_html__( 'yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'affects'           => array(
              'bg_overlay_color',
            ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'overlay',
            'description'     => esc_html__( 'When enabled, a custom overlay color will be added above your background image and behind your slider content.', 'divi-machine' ),
          ),
          'bg_overlay_color' => array(
            'label'             => esc_html__( 'Background Overlay Color', 'divi-machine' ),
            'type'              => 'color-alpha',
            'custom_color'      => true,
            'depends_show_if'   => 'on',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'overlay',
            'description'       => esc_html__( 'Use the color picker to choose a color for the background overlay.', 'divi-machine' ),
          ),
          'use_text_overlay'      => array(
            'label'           => esc_html__( 'Use Text Overlay', 'divi-machine' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'off' => esc_html__( 'No', 'divi-machine' ),
              'on'  => esc_html__( 'yes', 'divi-machine' ),
            ),
            'affects'           => array(
              'text_overlay_color',
              'text_border_radius',
            ),
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'overlay',
            'description'      => esc_html__( 'When enabled, a background color is added behind the slider text to make it more readable atop background images.', 'divi-machine' ),
          ),
          'text_overlay_color' => array(
            'label'             => esc_html__( 'Text Overlay Color', 'divi-machine' ),
            'type'              => 'color-alpha',
            'custom_color'      => true,
            'depends_show_if'   => 'on',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'overlay',
            'description'       => esc_html__( 'Use the color picker to choose a color for the text overlay.', 'divi-machine' ),
          ),
          'show_inner_shadow'   => array(
            'label'           => esc_html__( 'Show Inner Shadow', 'divi-machine' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'on'  => esc_html__( 'Yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'layout',
          ),
          'show_content_on_mobile' => array(
            'label'           => esc_html__( 'Show Content On Mobile', 'divi-machine' ),
            'type'            => 'yes_no_button',
            'option_category' => 'layout',
            'options'         => array(
              'on'  => esc_html__( 'Yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),
          'show_cta_on_mobile' => array(
            'label'           => esc_html__( 'Show CTA On Mobile', 'divi-machine' ),
            'type'            => 'yes_no_button',
            'option_category' => 'layout',
            'options'         => array(
              'on'  => esc_html__( 'Yes', 'divi-machine' ),
              'off' => esc_html__( 'No', 'divi-machine' ),
            ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),
          'show_image_video_mobile' => array(
            'label'           => esc_html__( 'Show Image On Mobile', 'divi-machine' ),
            'type'            => 'yes_no_button',
            'option_category' => 'layout',
            'options'         => array(
              'off' => esc_html__( 'No', 'divi-machine' ),
              'on'  => esc_html__( 'Yes', 'divi-machine' ),
            ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),
          'text_border_radius' => array(
            'label'           => esc_html__( 'Text Overlay Border Radius', 'divi-machine' ),
            'type'            => 'range',
            'option_category' => 'layout',
            'default'         => '3',
            'range_settings'  => array(
              'min'  => '0',
              'max'  => '100',
              'step' => '1',
            ),
            'depends_show_if' => 'on',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'overlay',
          ),
          'arrows_custom_color' => array(
            'label'        => esc_html__( 'Arrows Custom Color', 'divi-machine' ),
            'type'         => 'color-alpha',
            'custom_color' => true,
            'tab_slug'     => 'advanced',
            'toggle_slug'  => 'navigation',
          ),
          'dot_nav_custom_color' => array(
            'label'        => esc_html__( 'Dot Nav Custom Color', 'divi-machine' ),
            'type'         => 'color-alpha',
            'custom_color' => true,
            'tab_slug'     => 'advanced',
            'toggle_slug'  => 'navigation',
          ),
          'disabled_on' => array(
            'label'           => esc_html__( 'Disable on', 'divi-machine' ),
            'type'            => 'multiple_checkboxes',
            'options'         => array(
              'phone'   => esc_html__( 'Phone', 'divi-machine' ),
              'tablet'  => esc_html__( 'Tablet', 'divi-machine' ),
              'desktop' => esc_html__( 'Desktop', 'divi-machine' ),
            ),
            'additional_att'  => 'disable_on',
            'option_category' => 'configuration',
            'description'     => esc_html__( 'This will disable the module on selected devices', 'divi-machine' ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),


          'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'divi-machine' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi-machine' ),
					'on'  => esc_html__( 'On', 'divi-machine' ),
				),
				'affects' => array(
					'auto_speed',
					'auto_ignore_hover',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'animation',
				'description' => esc_html__( 'If you would like the slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'divi-machine' ),
				'default'     => 'off',
			),
      'auto_speed' => array(
				'label'           => esc_html__( 'Automatic Animation Speed (in ms)', 'divi-machine' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'description'     => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'divi-machine' ),
				'default'         => '7000',
			),
  'auto_ignore_hover' => array(
				'label'           => esc_html__( 'Continue Automatic Slide on Hover', 'divi-machine' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'depends_show_if' => 'on',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi-machine' ),
					'on'  => esc_html__( 'On', 'divi-machine' ),
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'animation',
				'description' => esc_html__( 'Turning this on will allow automatic sliding to continue on mouse hover.', 'divi-machine' ),
				'default'     => 'off',
			),
          '__postslider' => array(
            'type'                => 'computed',
            'computed_callback'   => array( 'db_mach_post_slider_code', 'get_post_slider' ),
            'computed_depends_on' => array(
              'post_type_choose',
              'posts_number',
              'include_categories',
              'include_tags',
              'include_taxomony',
              'acf_name',
              'acf_value',
              'orderby',
              'image_placement',
              'background_layout'
            ),
          ),
    		);

    		return $fields;
    	}


      public static function get_mach_post_slider_code ( $args = array(), $conditional_tags = array(), $current_page = array() ){


        $shop = "<div class='no-html-output'><p>We do not have compatibility for the slider yet. We are working on this still. It will still work as expected on the front-end, you will just not get a live preview.</p></div>";

        return $shop;

      }

      static function get_post_slider ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
          return;
        }

        ob_start();

        $post_type_choose   = $args['post_type_choose'];
        $include_cats       = $args['include_categories'];
        $include_tags       = $args['include_tags'];
        $acf_name           = $args['acf_name'];
        $acf_value          = $args['acf_value'];
        $orderby            = $args['orderby'];
        $image_placement    = $args['image_placement'];
        $background_layout  = $args['background_layout'];

        if ($image_placement == "left") {
          $image_placement_class = "et_pb_slide_with_image";
        } else {
          $image_placement_class = "";
        }

        if ($background_layout == "dark") {
          $background_layout_class = "et_pb_bg_layout_dark";
        } else {
          $background_layout_class = "et_pb_bg_layout_light";
        }

        if (isset($_REQUEST['et_post_id'])) {
          $post_id = absint($_REQUEST['et_post_id']);
        } elseif (isset($_REQUEST['current_page']['id'])) {
          $post_id = absint($_REQUEST['current_page']['id']);
        } else {
          $post_id = false;
        }

        $page_post_meta        = get_post_meta($post_id, '_divi_filters_post_type', true);
        $page_post_meta_backup = get_post_meta($post_id, '_daf_post_type', true);

        if ('' !== $page_post_meta) {
        $page_post_type = $page_post_meta;
        } elseif ('' !== $page_post_meta_backup) {
        $page_post_type = $page_post_meta_backup;
        } else {
        $page_post_type = 'post';
        }

        $post_slug = $page_post_type;

        $get_cpt_args = array(
          'post_type'   => $post_slug,
          'post_status'    => 'publish',
          'orderby' => $orderby,
        );

        if ($include_cats != "") {
            $get_cpt_args['category_name'] = $include_cats;
        }

        if ($include_tags != "") {

          if ($post_type_choose == "post") {
            $get_cpt_args['tag'] = $include_tags;
          } else {
            $ending = "_tag";
            $cat_key = $post_type_choose . $ending;
            if ($cat_key == "product_tag") {
              $cat_key = "product_tag";
            } else {
              $cat_key = $cat_key;
            }

            $get_cpt_args['tax_query'] = array(
              array(
                'taxonomy'  => $cat_key,
                'field'     => 'slug',
                'terms'     => $include_tags,
                'operator' => 'IN'
              )
            );
          }
        }

        query_posts( $get_cpt_args );

        $first = true;

if ( have_posts() ) {

  ?>
<div class="et_pb_module et_pb_slider et_db_mach_post_slider <?php echo $background_layout_class ?> et_pb_slider_with_overlay">
<div class="et_pb_slides">
  <?php

  while ( have_posts() ) {
      the_post();

      if ( $first )  {

?>

<?php
if ($image_placement == "left") {
  ?>
  <div class="et_pb_slide et_pb_media_alignment_center <?php echo $background_layout_class ?> <?php echo $image_placement_class ?>">
  <?php
} else {
?>
<div class="et_pb_slide et_pb_media_alignment_center <?php echo $background_layout_class ?> <?php echo $image_placement_class ?>" style="background-image: url(<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>);">
<?php
}
?>

<div class="et_pb_slide_overlay_container"></div>
<div class="et_pb_container clearfix">
  <div class="et_pb_slider_container_inner">
    <div class="et_pb_slide_image" style="transform: translateY(-50%);">
        <?php the_post_thumbnail(); ?>
    </div>
      <div class="et_pb_slide_description">
          <h3 class="et_pb_slide_title"><?php echo the_title(); ?> </h3>
              <div class="et_pb_slide_content ">
              <div class="post-content">
                <?php echo the_content(); ?>
              </div>
              <div class="post-excerpt">
                <?php echo the_excerpt(); ?>
              </div>
                <div class="clearfix"></div>
              </div>
              <div class="et_pb_button_wrapper">
              <a href="#" class="et_pb_more_button et_pb_button">

<?php
$first = false;
} else {

}
                    }
?>

                    <?php
              }

$data = ob_get_clean();

return $data;

}

                  function render($attrs, $content, $render_slug){



                    if (is_admin()) {
                        return;
                    }

                    $background_layout = '';

                    $post_type_choose       = $this->props['post_type_choose'];
                    $module_id               = $this->props['module_id'];
                		$module_class            = $this->props['module_class'];
                		$show_arrows             = $this->props['show_arrows'];
                		$show_pagination         = $this->props['show_pagination'];
                		$parallax                = $this->props['parallax'];
                		$parallax_method         = $this->props['parallax_method'];
                		$auto                    = $this->props['auto'];
                		$auto_speed              = $this->props['auto_speed'];
                		$auto_ignore_hover       = $this->props['auto_ignore_hover'];
                		$body_font_size          = $this->props['body_font_size'];
                		$show_inner_shadow       = $this->props['show_inner_shadow'];
                		$show_content_on_mobile  = $this->props['show_content_on_mobile'];
                		$show_cta_on_mobile      = $this->props['show_cta_on_mobile'];
                		$show_image_video_mobile = $this->props['show_image_video_mobile'];
                		$background_position     = $this->props['background_position'];
                		$background_size         = $this->props['background_size'];
                		$background_repeat       = $this->props['background_repeat'];
                		$background_blend        = $this->props['background_blend'];
                		$posts_number            = $this->props['posts_number'];
                		$include_categories      = $this->props['include_categories'];
                    $include_tags            = $this->props['include_tags'];
                    $custom_tax_choose       = $this->props['custom_tax_choose'];
                    $include_taxomony        = $this->props['include_taxomony'];
                    $acf_name                = $this->props['acf_name'];
                    $acf_value               = $this->props['acf_value'];
                		$show_more_button        = $this->props['show_more_button'];
                		$more_text               = $this->props['more_text'];
                		$content_source          = $this->props['content_source'];
                		$background_color        = $this->props['background_color'];
                		$show_image              = $this->props['show_image'];
                		$image_placement         = $this->props['image_placement'];
                		$background_image        = $this->props['background_image'];
                		$background_layout       = $this->props['background_layout'];
                		$use_bg_overlay          = $this->props['use_bg_overlay'];
                		$bg_overlay_color        = $this->props['bg_overlay_color'];
                		$use_text_overlay        = $this->props['use_text_overlay'];
                		$text_overlay_color      = $this->props['text_overlay_color'];
                		$orderby                 = $this->props['orderby'];
                		$button_custom           = $this->props['custom_button'];
                		$custom_icon             = $this->props['button_icon'];
                		$use_manual_excerpt      = $this->props['use_manual_excerpt'];
                		$excerpt_length          = $this->props['excerpt_length'];
                		$text_border_radius      = $this->props['text_border_radius'];
                		$dot_nav_custom_color    = $this->props['dot_nav_custom_color'];
                		$arrows_custom_color     = $this->props['arrows_custom_color'];
                		$button_rel              = $this->props['button_rel'];


                    if ( 'on' === $auto ) {
                			$this->add_classname( array(
                				'et_slider_auto',
                				"et_slider_speed_{$auto_speed}",
                			) );
                		}

                		if ( 'on' === $auto_ignore_hover ) {
                			$this->add_classname( 'et_slider_auto_ignore_hover' );
                		}

                    $post_index = 0;

                    $module_class = ET_Builder_Element::add_module_order_class( $module_class, $render_slug );

                    if(defined('HIDE_ON_MOBILE')) {
	                    $hide_on_mobile_class = HIDE_ON_MOBILE;
                    }
                    // Applying backround-related style to slide item since advanced_option only targets module wrapper
                    if ( 'on' === $this->props['show_image'] && 'background' === $this->props['image_placement'] && 'off' === $parallax ) {
                      if ('' !== $background_color) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide:not(.et_pb_slide_with_no_image)',
                          'declaration' => sprintf(
                            'background-color: %1$s;',
                            esc_html( $background_color )
                          ),
                        ) );
                      }

                      if ( '' !== $background_size && 'default' !== $background_size ) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            '-moz-background-size: %1$s;
                            -webkit-background-size: %1$s;
                            background-size: %1$s;',
                            esc_html( $background_size )
                          ),
                        ) );

                        if ( 'initial' === $background_size ) {
                          ET_Builder_Module::set_style( $render_slug, array(
                            'selector'    => 'body.ie %%order_class%% .et_pb_slide',
                            'declaration' => '-moz-background-size: auto; -webkit-background-size: auto; background-size: auto;',
                          ) );
                        }
                      }

                      if ( '' !== $background_position && 'default' !== $background_position ) {
                        $processed_position = str_replace( '_', ' ', $background_position );

                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            'background-position: %1$s;',
                            esc_html( $processed_position )
                          ),
                        ) );
                      }

                      if ( '' !== $background_repeat ) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            'background-repeat: %1$s;',
                            esc_html( $background_repeat )
                          ),
                        ) );
                      }

                      if ( '' !== $background_blend ) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            'background-blend-mode: %1$s;',
                            esc_html( $background_blend )
                          ),
                        ) );
                      }
                    }

                    if ( 'on' === $use_bg_overlay && '' !== $bg_overlay_color ) {
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .et_pb_slide .et_pb_slide_overlay_container',
                        'declaration' => sprintf(
                          'background-color: %1$s;',
                          esc_html( $bg_overlay_color )
                        ),
                      ) );
                    }

                    if ( 'on' === $use_text_overlay && '' !== $text_overlay_color ) {
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .et_pb_slide .et_pb_slide_title, %%order_class%% .et_pb_slide .et_pb_slide_content',
                        'declaration' => sprintf(
                          'background-color: %1$s;',
                          esc_html( $text_overlay_color )
                        ),
                      ) );
                    }

                    if ( '' !== $text_border_radius ) {
                      $border_radius_value = et_builder_process_range_value( $text_border_radius );
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay h3.et_pb_slide_title',
                        'declaration' => sprintf(
                          '-webkit-border-top-left-radius: %1$s;
                          -webkit-border-top-right-radius: %1$s;
                          -moz-border-radius-topleft: %1$s;
                          -moz-border-radius-topright: %1$s;
                          border-top-left-radius: %1$s;
                          border-top-right-radius: %1$s;',
                          esc_html( $border_radius_value )
                        ),
                      ) );
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay .et_pb_slide_content',
                        'declaration' => sprintf(
                          '-webkit-border-bottom-right-radius: %1$s;
                          -webkit-border-bottom-left-radius: %1$s;
                          -moz-border-radius-bottomright: %1$s;
                          -moz-border-radius-bottomleft: %1$s;
                          border-bottom-right-radius: %1$s;
                          border-bottom-left-radius: %1$s;',
                          esc_html( $border_radius_value )
                        ),
                      ) );
                    }

                    $fullwidth = 'et_pb_fullwidth_slider' === $render_slug ? 'on' : 'off';

                    $class  = '';
                    $class .= 'off' === $fullwidth ? ' et_pb_slider_fullwidth_off' : '';
                    $class .= 'off' === $show_arrows ? ' et_pb_slider_no_arrows' : '';
                    $class .= 'off' === $show_pagination ? ' et_pb_slider_no_pagination' : '';
                    $class .= 'on' === $parallax ? ' et_pb_slider_parallax' : '';
                    $class .= 'on' === $auto ? ' et_slider_auto et_slider_speed_' . esc_attr( $auto_speed ) : '';
                    $class .= 'on' === $auto_ignore_hover ? ' et_slider_auto_ignore_hover' : '';
                    $class .= 'on' !== $show_inner_shadow ? ' et_pb_slider_no_shadow' : '';
                    $class .= 'on' === $show_image_video_mobile ? ' et_pb_slider_show_image' : '';
                    $class .= ' et_pb_mach_post_slider_image_' . $image_placement;
                    $class .= 'on' === $use_bg_overlay ? ' et_pb_slider_with_overlay' : '';
                    $class .= 'on' === $use_text_overlay ? ' et_pb_slider_with_text_overlay' : '';

                    $data_dot_nav_custom_color = '' !== $dot_nav_custom_color
                      ? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
                      : '';

                    $data_arrows_custom_color = '' !== $arrows_custom_color
                      ? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
                      : '';

                    $video_background = $this->video_background();
                    $parallax_image_background = $this->get_parallax_image_background();

                    $data_dot_nav_custom_color = '' !== $dot_nav_custom_color
                      ? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
                      : '';

                    $data_arrows_custom_color = '' !== $arrows_custom_color
                      ? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
                      : '';

                    ob_start();

                    global $wp_query, $wpdb, $post, $woocommerce;


                    // print_r($wp_query->query_vars);
                    // echo "peter";


                      $args = array(
                        'posts_per_page' => $posts_number,
                        'post_type'   => $post_type_choose,
                        'post_status'    => 'publish',
                        'orderby' => $orderby,
                      );

                      $args['tax_query']['relation'] = 'AND';
                      $meta_query = array('relation' => 'AND');
                      
                    
                    

                if ($wp_query) {
                  
              
                    
                    if ( $wp_query->is_main_query()
                    && $wp_query->is_archive()
                    && !empty( $wp_query->query_vars['taxonomy'] )
                    && $wp_query->query_vars['taxonomy'] == $post_type_choose . '_category' ){
                      
                      $args['tax_query'][] = array(
                        'taxonomy'  => $wp_query->query_vars['taxonomy'],
                        'field'     => 'slug',
                        'terms'     => $wp_query->query_vars['term']
                      );
                    }
                    
           
                  
                  
                  $current_post = 0;

                  if ( $wp_query->is_main_query()
                  && $wp_query->is_singular()
                  && $wp_query->is_single()
                  && $wp_query->post->post_type == $post_type_choose ){
                  $current_post = $wp_query->post->ID;
                  }

                  if ( $current_post != 0 ){
                    $args['post__not_in'][] = $current_post;
                  }

                }

                    

                      if ($include_categories != "") {
                          $include_cat_array = explode( ',', $include_categories );
                          if ($post_type_choose == "post") {
                              $args['category__in'] = $include_cat_array;
                          } else {

                              if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                                  $args['category__in'] = $include_cat_array;
                              }else{
                                  $ending = "_category";
                                  $cat_key = $post_type_choose . $ending;
                                  if ($cat_key == "product_category") {
                                      $cat_key = "product_cat";
                                  } else {
                                      $cat_key = $cat_key;
                                  }

                                  $args['tax_query'][] = array(
                                      'taxonomy'  => $cat_key,
                                      'field'     => 'slug',
                                      'terms'     => $include_cat_array,
                                      'operator' => 'IN'
                                  );  
                              }
                          }
                      }

                      if ($include_tags != "") {
                        $include_tag_array = explode( ',', $include_tags );

                        if ($post_type_choose == "post") {
                          $args['tag__in'] = $include_tag_array;
                        } else {
                          $ending = "_tag";
                          $cat_key = $post_type_choose . $ending;
                          if ($cat_key == "product_tag") {
                            $cat_key = "product_tag";
                          } else {
                            $cat_key = $cat_key;
                          }
                  
                          $args['tax_query'] = array(
                              array(
                                  'taxonomy'  => $cat_key,
                                  'field'     => 'slug',
                                  'terms'     => $include_tag_array,
                                  'operator' => 'IN'
                              )
                          );
                        }
                      }


                      if ($include_taxomony != "") {
        
                        $args['tax_query'][] = array(
                            'taxonomy'  => $custom_tax_choose,
                            'field'     => 'slug',
                            'terms'     => $include_taxomony,
                            'operator' => 'IN'
                        );  
                      }     

                      if ($acf_name != "none") {

                        if ($acf_value != "") {

                            $acf_name_get = get_field_object($acf_name);
                            $is_multiple = false;
                            $possible_multiples = array( 'select', 'checkbox', 'post_object' );
                            if ( isset( $acf_name_get['type'] ) && in_array( $acf_name_get['type'], $possible_multiples ) ) {
                               if ( isset( $acf_name_get['multiple'] ) && $acf_name_get['multiple'] == 1 ) {
                                  $is_multiple = true;
                               }
                            }
                 
                            if ( $is_multiple ) {
                              $val_array = explode(',', $acf_value);
                              if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                  $query_arr = array( 'relation' => 'OR' );
                                  foreach ( $val_array as $meta_val ) {
                                      $query_arr[] = array(
                                          'key'       => $acf_name_get['name'],
                                          'value'     => '"' . $meta_val . '"',
                                          'compare'   => 'LIKE',
                                      );
                                  }
                                  $meta_query[] = $query_arr;
                              }else{
                                  $meta_query[] = array(
                                      'key' => $acf_name_get['name'],
                                      'value' => '"' . $acf_value . '"',
                                      'compare' => 'LIKE'
                                  );
                              }
                            } else if (isset($acf_name_get['type']) && $acf_name_get['type'] == "range") {

                              $price_value = (explode(";",$acf_value));

                              if ( sizeof( $price_value ) == 1 ){
                                $meta_query[] = array(
                                  'key' => $acf_name_get['name'],
                                  'value' => $price_value[0],
                                  'type' => 'NUMERIC',
                                  'compare' => '<='
                                );
                              }else{
                                $meta_query[] = array(
                                  'key' => $acf_name_get['name'],
                                  'value' => $price_value,
                                  'compare' => 'BETWEEN',
                                  'type' => 'NUMERIC'
                                );
                              }

                            } else if (isset($acf_name_get['type']) && $acf_name_get['type'] == "text") {
                              $args['meta_key'] = $acf_name_get['name'];
                              $args['meta_value'] = $acf_value;
                            } else {
                              $meta_query[] = array(
                                  'key' => $acf_name_get['name'],
                                  'value' => $acf_value,
                                  'compare' => 'IN'
                              );
                            }

                            $args['meta_query'] = $meta_query;
                        }
                      }
                      
                        // Re-used self::get_blog_posts() for builder output

                        $query = new WP_Query( $args );

                        

                        if ( $query->have_posts() ) {
                          while ( $query->have_posts() ) {
                            $query->the_post();

                            $slide_class = 'off' !== $show_image && in_array( $image_placement, array( 'left', 'right' ) ) && has_post_thumbnail() ? ' et_pb_slide_with_image' : '';
                            $slide_class .= 'off' !== $show_image && ! has_post_thumbnail() ? ' et_pb_slide_with_no_image' : '';
                            $slide_class .= " et_pb_bg_layout_{$background_layout}";
                          ?>
                          <div class="et_pb_slide et_pb_media_alignment_center<?php echo esc_attr( $slide_class ); ?>" <?php if ( 'on' !== $parallax && 'off' !== $show_image && 'background' === $image_placement ) { printf( 'style="background-image:url(%1$s)"', esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) );  } ?><?php echo $data_dot_nav_custom_color; echo $data_arrows_custom_color; ?>>
                            <?php if ( 'on' === $parallax && 'off' !== $show_image && 'background' === $image_placement ) { ?>
                              <div class="et_parallax_bg<?php if ( 'off' === $parallax_method ) { echo ' et_pb_parallax_css'; } ?>" style="background-image: url(<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>);"></div>
                            <?php } ?>
                            <?php if ( 'on' === $use_bg_overlay ) { ?>
                              <div class="et_pb_slide_overlay_container"></div>
                            <?php } ?>
                            <div class="et_pb_container clearfix">
                              <div class="et_pb_slider_container_inner">
                                <?php if ( 'off' !== $show_image && has_post_thumbnail() && ! in_array( $image_placement, array( 'background', 'bottom' ) ) ) { ?>
                                  <div class="et_pb_slide_image">
                                    <?php the_post_thumbnail(); ?>
                                  </div>
                                <?php } ?>
                                <div class="et_pb_slide_description">
                                  <h3 class="et_pb_slide_title"><?php the_title(); ?></h3>
                                  <div class="et_pb_slide_content <?php if ( 'on' !== $show_content_on_mobile ) { echo esc_attr( $hide_on_mobile_class ); } ?>">
<div>
                                    <?php

if ($content_source == "off") { // short desc
                                        echo $query->posts[ $post_index ]->post_excerpt;

} else { // CONTENT
                                        echo $query->posts[ $post_index ]->post_content;
}
                                      ?>
</div>
                                      <div class="clearfix"></div><?php
                                      ?>


                                  </div>
                                  <?php if ( 'off' !== $show_more_button && '' !== $more_text ) {
                                      printf(
                                        '<div class="et_pb_button_wrapper"><a href="%1$s" class="et_pb_more_button et_pb_button%4$s%5$s"%3$s%6$s>%2$s</a></div>',
                                        esc_url( get_permalink() ),
                                        esc_html( $more_text ),
                                        '' !== $custom_icon && 'on' === $button_custom ? sprintf(
                                          ' data-icon="%1$s"',
                                          esc_attr( et_pb_process_font_icon( $custom_icon ) )
                                        ) : '',
                                        '' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : '',
                                        'on' !== $show_cta_on_mobile ? esc_attr( " {$hide_on_mobile_class}" ) : '',
                                        $this->get_rel_attributes( $button_rel )
                                      );
                                    }
                                  ?>
                                </div> <!-- .et_pb_slide_description -->
                                <?php if ( 'off' !== $show_image && has_post_thumbnail() && 'bottom' === $image_placement ) { ?>
                                  <div class="et_pb_slide_image">
                                    <?php the_post_thumbnail(); ?>
                                  </div>
                                <?php } ?>
                              </div>
                            </div> <!-- .et_pb_container -->
                          </div> <!-- .et_pb_slide -->
                        <?php
                          $post_index++;

                          } // end while
                          wp_reset_query();
                        } // end if

                        $content = ob_get_contents();


                        ob_end_clean();

                        $output = sprintf(
                          '<div%3$s class="et_pb_module et_pb_slider et_db_mach_post_slider%1$s%4$s%5$s%7$s">
                            %8$s
                            %6$s
                            <div class="et_pb_slides">
                              %2$s
                            </div> <!-- .et_pb_slides -->
                          </div> <!-- .et_pb_slider -->
                          ',
                          $class,
                          $content,
                          ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                          ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                          '' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
                          $video_background,
                          '' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
                          $parallax_image_background
                        );

                        if( isset($customclass) ){
                          $this->add_classname( $customclass );
                        }

                        return $output;

                  }
              }

            new db_mach_post_slider_code;

?>
