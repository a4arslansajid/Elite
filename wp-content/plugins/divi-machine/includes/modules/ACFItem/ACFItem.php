<?php
if (!defined('ABSPATH')) exit;

class de_mach_acf_item_code extends ET_Builder_Module
{
  public $vb_support = 'on';

  protected $module_credits = array(
    'module_uri' => DE_DMACH_PRODUCT_URL,
    'author'     => DE_DMACH_AUTHOR,
    'author_uri' => DE_DMACH_URL, 
  );

  function init()
  {
    $this->name       = esc_html__('ACF Item - Divi Machine', 'divi-machine');
    $this->slug = 'et_pb_de_mach_acf_item';
    $this->child_title_var             = 'admin_label';
    $this->child_title_fallback_var    = 'custom_identifier';
    $this->folder_name = 'divi_machine';


    $this->fields_defaults = array(
      // 'loop_layout'         => array( 'on' ),
    );

    $this->settings_modal_toggles = array(
      'general' => array(
        'toggles' => array(
          'main_content' => esc_html__('Main Options', 'divi-machine'),
					'main_content'		=> array(
						'title' => esc_html__( 'Main Options', 'divi-form-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'main'     => array(
								'name' => esc_html__( 'Main', 'divi-form-builder')
							),
							'label'     => array(
								'name' => esc_html__( 'Label', 'divi-form-builder')
              ),
							'prefix'     => array(
								'name' => esc_html__( 'Prefix/Suffix', 'divi-form-builder')
              ),
							'visibility'     => array(
								'name' => esc_html__( 'Visibility', 'divi-form-builder')
              )
						)
					),
					'specific_image_settings'		=> array(
						'title' => esc_html__( 'Image, file, url, phone, email & Link Settings', 'divi-form-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'shared'     => array(
								'name' => esc_html__( 'Shared Settings', 'divi-form-builder')
							),
							'image'     => array(
								'name' => esc_html__( 'Image Only', 'divi-form-builder')
              ),
							'email'     => array(
								'name' => esc_html__( 'Email Only', 'divi-form-builder')
							)
						)
					),
					'specific_checkbox_settings'		=> array(
						'title' => esc_html__( 'Checkbox/Radio Settings', 'divi-form-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'shared'     => array(
								'name' => esc_html__( 'Shared Settings', 'divi-form-builder')
							),
							'checkbox'     => array(
								'name' => esc_html__( 'Checkbox Only', 'divi-form-builder')
							)
						)
					),
					'specific_other_settings'		=> array(
						'title' => esc_html__( 'Other Field Settings', 'divi-form-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'text'     => array(
								'name' => esc_html__( 'Text', 'divi-form-builder')
              ),
							'number'     => array(
								'name' => esc_html__( 'Number', 'divi-form-builder')
              ),
							'video_audio'     => array(
								'name' => esc_html__( 'Video/Audio', 'divi-form-builder')
              ),
							'true_false'     => array(
								'name' => esc_html__( 'True/False', 'divi-form-builder')
              ),
							'repeater'     => array(
								'name' => esc_html__( 'Repeater', 'divi-form-builder')
							),
						)
					),
          'relational'        => esc_html__('Relational Field Settings', 'divi-machine'),
          'conditional'        => esc_html__('Conditional Settings', 'divi-machine'),
          'image'        => esc_html__('Image & Icon', 'divi-machine'),
        ),
      ),
      'advanced' => array(
        'toggles' => array(
          'text' => esc_html__('Text', 'divi-machine'),
        ),
      ),

    );


    $this->main_css_element = '%%order_class%%';


    $this->advanced_fields = array(
      'fonts' => array(
        'title_css' => array(
          'label'    => esc_html__('Item', 'divi-machine'),
          'css'      => array(
            'main' => "%%order_class%% .dmach-acf-item-content",
            'important' => 'all',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
        ),
        'acf_label_css' => array(
          'label'    => esc_html__('Label', 'divi-machine'),
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
        'label_css' => array(
          'label'    => esc_html__('Value', 'divi-machine'),
          'css'      => array(
            'main' => "%%order_class%% .dmach-acf-value",
            'important' => 'all',
          ),
          'font_size' => array(
          ),
          'line_height' => array(
          ),
        ),
        'text_before_css' => array(
          'label'    => esc_html__('Before', 'divi-machine'),
          'css'      => array(
            'main' => "%%order_class%% .dmach-acf-before",
            'important' => 'all',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
        ),
        'seperator' => array(
          'label'    => esc_html__('Separator', 'divi-machine'),
          'css'      => array(
            'main' => "%%order_class%% .dmach-seperator",
            'important' => 'all',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
        ),
        'relational_field_item' => array(
          'label'    => esc_html__('Relational Field List Item', 'divi-machine'),
          'css'      => array(
            'main' => "%%order_class%% .linked_list_item a",
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


      'borders'               => array(
        'default' => array(
          'css' => array(
            'main' => array(
              // Accordion Item can use %%parent_class%% because its slug is parent_slug + `_item` suffix
              'border_radii'  => "{$this->main_css_element}",
              'border_styles' => "{$this->main_css_element}",
            )
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
          'label' => esc_html__('Button', 'divi-machine'),
          'css' => array(
            'main' => "{$this->main_css_element} .et_pb_button",
            'plugin_main' => "{$this->main_css_element}.et_pb_module",
          ),
          'box_shadow'  => array(
            'css' => array(
              'main' => "{$this->main_css_element} .et_pb_button",
              'important' => 'all',
            ),
          ),
          'margin_padding' => array(
            'css'           => array(
              'main' => "{$this->main_css_element} .et_pb_button",
              'important' => 'all',
            ),
          ),
        ),
      ),
      'box_shadow' => array(
        'default' => array(),
      ),
    );


    $this->custom_css_fields = array(
      'item' => array(
        'label'       => esc_html__('Item', 'divi-machine'),
        'selector'    => '.dmach-acf-value',
      ),
      'text_before' => array(
        'label'       => esc_html__('Text Before', 'divi-machine'),
        'selector'    => '.dmach-acf-before',
      ),
      'label' => array(
        'label'       => esc_html__('Label', 'divi-machine'),
        'selector'    => '.dmach-acf-label',
      ),
      'image' => array(
        'label'       => esc_html__('Image', 'divi-machine'),
        'selector'    => '.dmach-icon-image-content img',
      ),
    );




    $this->help_videos = array();

    // add_filter( 'et_pb_module_content', array( $this, 'add_acf_item_content' ),10, 6 );
  }

 

  function get_fields()
  {

    $looplayout_options = DEDMACH_INIT::get_divi_layouts();

    $et_accent_color = et_builder_accent_color();

    $acf_fields = DEDMACH_INIT::get_acf_fields();

    ///////////////////////////////
    $sizes = get_intermediate_image_sizes();
    foreach ($sizes as $size) {
      $options[$size] = $size;
    }


    //////////////////////////////
    $fields = array(
      'custom_identifier' => array(
        'label'       => __('Repeater Custom Label', 'divi-machine'),
        'type'        => 'text',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'repeater',
        'default'         => 'ACF Item',
        'option_category'   => 'configuration',
        'description' => __('This will change the label of the item inside the repeater module for easy identification.', 'divi-machine'),
      ),
      'acf_name' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label'             => esc_html__('ACF Name', 'divi-machine'),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'option_category'   => 'configuration',
        'description'       => esc_html__('Add the name of the ACF you want to display here', 'divi-machine'),
      ),
      'acf_name_custom' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label'             => esc_html__('ACF Custom Field ID', 'divi-machine'),
        'type'              => 'text',
        'default'           => '',
        'show_if'           => array('acf_name' => 'custom_acf_name_de'),
        'option_category'   => 'configuration',
        'description'       => esc_html__('Add the name of the ACF you want to display here', 'divi-machine'),
      ),

      'is_author_acf_field' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label' => esc_html__('ACF Field From', 'divi-machine'),
        'type' => 'select',
        'options_category' => 'configuration',
        'options' => array(
          'off' => esc_html__('Default (current post)', 'divi-machine'),
          'on' => esc_html__('User Field', 'divi-machine'),
          'current_taxonomy' => esc_html__('Current Taxonomy', 'divi-machine'),
          'taxonomy' => esc_html__('ACF Category, ACF Tag or ACF Taxonomy of current CPT', 'divi-machine'),
          'post_object' => esc_html__('Post Object', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('Leave as default. If you want to get ACF from something else like a category, linked post or user - choose this. If you want to get the ACF value of the author or logged in user, choose "user field" for example.', 'divi-machine')
      ),          
      'current_taxonomy_slug' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label'             => esc_html__('Taxonomy Slug', 'divi-machine'),
        'type'              => 'text',
        'default'           => '',
        'show_if'           => array ('is_author_acf_field'  => 'current_taxonomy'),
        'option_category'   => 'configuration',
        'description'       => esc_html__('Specify the taxonomy.', 'divi-machine'),
      ),
      'post_object_acf_name' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label'             => esc_html__('Post Object ACF Name', 'divi-machine'),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'show_if'           => array ('is_author_acf_field'  => 'post_object'),
        'option_category'   => 'configuration',
        'description'       => esc_html__('Choose the ACF field that is assigned to this custom post. We will then look for the ACF field above that is assigned to this post object.', 'divi-machine'),
      ),
      'author_field_type' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label' => esc_html__('User Field Type', 'divi-machine'),
        'type' => 'select',
        'options_category' => 'configuration',
        'options' => array(
          'author_post' => esc_html__('Author Of Post', 'divi-machine'),
          'logged_in' => esc_html__('Logged In User', 'divi-machine'),
        ),       
        'show_if'           => array ('is_author_acf_field'  => 'on'),
        'default' => 'author_post',
        'description' => esc_html__('If you are using an ACF field for the author (like image) and want to show this - we try work it out but if it is not working, enable this to override.', 'divi-machine')
      ),      
      'type_taxonomy_acf_name' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label'             => esc_html__('Field Taxonmy ACF Name', 'divi-machine'),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'show_if'           => array ('is_author_acf_field'  => 'taxonomy'),
        'option_category'   => 'configuration',
        'description'       => esc_html__('Use a taxonomy field to choose which one we should be looking at to show. We will look for the taxonomy (category, tag or taxonomy) selected and show the ACF values.', 'divi-machine'),
      ),

      'acf_tag' => array(
        'option_category' => 'configuration',
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label'             => esc_html__('Value HTML Tag', 'divi-machine'),
        'type'              => 'select',
        'options'           => array(
          'div' => esc_html__('div', 'divi-machine'),
          'p' => esc_html__('p', 'divi-machine'),
          'span' => esc_html__('span', 'divi-machine'),
          'h1' => esc_html__('h1', 'divi-machine'),
          'h2' => esc_html__('h2', 'divi-machine'),
          'h3' => esc_html__('h3', 'divi-machine'),
          'h4' => esc_html__('h4', 'divi-machine'),
          'h5' => esc_html__('h5', 'divi-machine'),
          'h6' => esc_html__('h6', 'divi-machine'),
          'img' => esc_html__('img', 'divi-machine'),
        ),
        'default' => 'p',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('Choose what HTML tag you want for your ACF value', 'divi-machine'),
      ),
      'show_label' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'label',
        'label' => esc_html__('Show Label', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'affects'         => array(
          'label_seperator',
          'custom_label'
        ),
        'default' => 'on',
        'description' => esc_html__('Enable this if you want to show the label of the ACF item.', 'divi-machine')
      ),
      'label_seperator' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'label',
        'show_if'           => array('show_label' => 'on'),
        'label'             => esc_html__('Label Seperator', 'divi-machine'),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'depends_show_if'   => 'on',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'default'           => ': ',
        'description'       => esc_html__('Add the label seperator here, something like : ', 'divi-machine'),
      ),
      'custom_label' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'label',
        'show_if'           => array('show_label' => 'on'),
        'label'             => esc_html__('Custom label (leave blank for default label)', 'divi-machine'),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'depends_show_if'   => 'on',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('Add a custom label here or leave it blank to get the default label.', 'divi-machine'),
      ),
      'prefix' => array(
        'option_category' => 'configuration',
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'prefix',
        'label'             => esc_html__('Prefix', 'divi-machine'),
        'type'              => 'text',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('If you want text to appear directly before the ACF, add it here', 'divi-machine'),
      ),
      'suffix' => array(
        'option_category' => 'configuration',
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'prefix',
        'label'             => esc_html__('Suffix', 'divi-machine'),
        'type'              => 'text',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('If you want text to appear directly after the ACF, add it here', 'divi-machine'),
      ),
      'text_before' => array(
        'option_category' => 'configuration',
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'prefix',
        'label'             => esc_html__('Text Before', 'divi-machine'),
        'type'              => 'text',
        'description'       => esc_html__('If you want text to appear before the choice field, add it here', 'divi-machine'),
      ),




     

      'visibility' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'visibility',
        'label' => esc_html__('Visibility', 'divi-machine'),
        'type' => 'select',
        'options_category' => 'configuration',
        'options' => array(
          'all' => esc_html__('All', 'divi-machine'),
          'logged_in' => esc_html__('Logged in users only', 'divi-machine'),
        ),
        'affects'         => array(
          'label_seperator',
          'custom_label'
        ),
        'default' => 'on',
        'description' => esc_html__('Choose who can see this ACF field on the frontend.', 'divi-machine')
      ),

      'empty_value_option' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'visibility',
        'label' => esc_html__('What to do when empty value?', 'divi-machine'),
        'type' => 'select',
        'options_category' => 'configuration',
        'options' => array(
          'hide_module' => esc_html__('Hide Module', 'divi-machine'),
          'hide_parent_row' => esc_html__('Hide Parent Row & this module', 'divi-machine'),
          'hide_parent_section' => esc_html__('Hide Parent Section & this module', 'divi-machine'),
          'hide_element' => esc_html__('Hide Another Element & this module', 'divi-machine'),
          'custom_text' => esc_html__('Custom Text (define below)', 'divi-machine'),
        ),
        'default' => 'hide_module',
        'description' => esc_html__('Choose what you want to happen when the value is empty - by default we will hide the module but you can do things like hiding the row/section or other element or even show custom text.', 'divi-machine')
      ),

      

      'empty_value_option_element' => array(
        'option_category' => 'configuration',
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'visibility',
        'label'             => esc_html__('Hide Element Selector', 'divi-machine'),
        'type'              => 'text',
        'description'       => esc_html__('Add the selector to hide - for example it could be the class or the ID of the other module or row etc.', 'divi-machine'),
        'show_if'           => array (
          'empty_value_option'  => 'hide_element'
        )
      ),
      'empty_value_option_custom_text' => array(
        'option_category' => 'configuration',
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'visibility',
        'label'             => esc_html__('Custom Text for empty value', 'divi-machine'),
        'type'              => 'text',
        'description'       => esc_html__('Add the selector to hide - for example it could be the class or the ID of the other module or row etc.', 'divi-machine'),
        'show_if'           => array (
          'empty_value_option'  => 'custom_text'
        )
      ),

      'use_icon' => array( // TODO: VB
        'label'           => esc_html__('Use Icon', 'divi-machine'),
        'type'            => 'yes_no_button',
        'option_category' => 'basic_option',
        'options'         => array(
          'off' => esc_html__('No', 'divi-machine'),
          'on'  => esc_html__('Yes', 'divi-machine'),
        ),
        'toggle_slug'     => 'image',
        'computed_affects' => array(
          '__getacfitem',
        ),
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
        'description' => esc_html__('Here you can choose whether icon set below should be used.', 'divi-machine'),
        'default_on_front' => 'off',
      ),
      'font_icon' => array(
        'label'               => esc_html__('Icon', 'divi-machine'),
        'type'                => 'select_icon',
        'option_category'     => 'basic_option',
        'class'               => array('et-pb-font-icon'),
        'toggle_slug'         => 'image',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'         => esc_html__('Choose an icon to display with your ACF item.', 'divi-machine'),
        'depends_show_if'     => 'on',
        'mobile_options'      => true,
        'hover'               => 'tabs',
      ),
      'icon_color' => array(
        'default'           => $et_accent_color,
        'label'             => esc_html__('Icon Color', 'divi-machine'),
        'type'              => 'color-alpha',
        'description'       => esc_html__('Here you can define a custom color for your icon.', 'divi-machine'),
        'depends_show_if'   => 'on',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'icon_settings',
        'hover'             => 'tabs',
        'mobile_options'    => true,
      ),
      'use_circle' => array(
        'label'           => esc_html__('Circle Icon', 'divi-machine'),
        'type'            => 'yes_no_button',
        'option_category' => 'configuration',
        'options'         => array(
          'off' => esc_html__('No', 'divi-machine'),
          'on'  => esc_html__('Yes', 'divi-machine'),
        ),
        'affects'           => array(
          'use_circle_border',
          'circle_color',
        ),
        'tab_slug'         => 'advanced',
        'toggle_slug'      => 'icon_settings',
        'description'      => esc_html__('Here you can choose whether icon set above should display within a circle.', 'divi-machine'),
        'depends_show_if'  => 'on',
        'default_on_front' => 'off',
      ),
      'circle_color' => array(
        'default'         => $et_accent_color,
        'label'           => esc_html__('Circle Color', 'divi-machine'),
        'type'            => 'color-alpha',
        'description'     => esc_html__('Here you can define a custom color for the icon circle.', 'divi-machine'),
        'depends_show_if' => 'on',
        'tab_slug'        => 'advanced',
        'toggle_slug'     => 'icon_settings',
        'hover'           => 'tabs',
        'mobile_options'  => true,
      ),
      'use_circle_border' => array(
        'label'           => esc_html__('Show Circle Border', 'divi-machine'),
        'type'            => 'yes_no_button',
        'option_category' => 'layout',
        'options'         => array(
          'off' => esc_html__('No', 'divi-machine'),
          'on'  => esc_html__('Yes', 'divi-machine'),
        ),
        'affects'           => array(
          'circle_border_color',
        ),
        'description' => esc_html__('Here you can choose whether if the icon circle border should display.', 'divi-machine'),
        'depends_show_if'   => 'on',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'icon_settings',
        'default_on_front'  => 'off',
      ),
      'circle_border_color' => array(
        'default'         => $et_accent_color,
        'label'           => esc_html__('Circle Border Color', 'divi-machine'),
        'type'            => 'color-alpha',
        'description'     => esc_html__('Here you can define a custom color for the icon circle border.', 'divi-machine'),
        'depends_show_if' => 'on',
        'tab_slug'        => 'advanced',
        'toggle_slug'     => 'icon_settings',
        'hover'           => 'tabs',
        'mobile_options'  => true,
      ),
      'use_icon_font_size'  => array(
        'label'            => esc_html__( 'Use Icon Font Size', 'divi-machine' ),
        'description'      => esc_html__( 'If you would like to control the size of the icon, you must first enable this option.', 'divi-machine' ),
        'type'             => 'yes_no_button',
        'option_category'  => 'font_option',
        'options'          => array(
          'off' => esc_html__('No', 'divi-machine'),
          'on'  => esc_html__('Yes', 'divi-machine'),
        ),
        'affects'          => array(
          'icon_font_size',
        ),
        'depends_show_if'  => 'on',
        'tab_slug'         => 'advanced',
        'toggle_slug'      => 'icon_settings',
        'default_on_front' => 'off',
      ),
      'icon_font_size'      => array(
        'label'            => esc_html__( 'Icon Font Size', 'divi-machine' ),
        'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'divi-machine' ),
        'type'             => 'range',
        'option_category'  => 'font_option',
        'tab_slug'         => 'advanced',
        'toggle_slug'      => 'icon_settings',
        'default'          => '16px',
        'default_unit'     => 'px',
        'default_on_front' => '',
        'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
        'range_settings'   => array(
          'min'  => '1',
          'max'  => '500',
          'step' => '1',
        ),
        'depends_show_if'  => 'on',
        'responsive'       => true,
        'hover'            => 'tabs',
      ),
      'icon_pos_top'      => array(
        'label'            => esc_html__( 'Icon Postion from Top', 'divi-machine' ),
        'description'      => esc_html__( 'Change the position of the icon from the top.', 'divi-machine' ),
        'type'             => 'range',
        'option_category'  => 'font_option',
        'tab_slug'         => 'advanced',
        'toggle_slug'      => 'icon_settings',
        'default'          => '0px',
        'default_unit'     => 'px',
        'default_on_front' => '',
        'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
        'range_settings'   => array(
          'min'  => '1',
          'max'  => '500',
          'step' => '1',
        ),
        'responsive'       => true,
        'hover'            => 'tabs',
      ),
      'icon_pos_left'      => array(
        'label'            => esc_html__( 'Icon Postion from Left', 'divi-machine' ),
        'description'      => esc_html__( 'Change the position of the icon from the left.', 'divi-machine' ),
        'type'             => 'range',
        'option_category'  => 'font_option',
        'tab_slug'         => 'advanced',
        'toggle_slug'      => 'icon_settings',
        'default'          => '0px',
        'default_unit'     => 'px',
        'default_on_front' => '',
        'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
        'range_settings'   => array(
          'min'  => '1',
          'max'  => '500',
          'step' => '1',
        ),
        'responsive'       => true,
        'hover'            => 'tabs',
      ),
      'image' => array(
        'label'              => esc_html__('Custom Image before/after', 'divi-machine'),
        'type'               => 'upload',
        'option_category'    => 'basic_option',
        'upload_button_text' => esc_attr__('Upload an image', 'divi-machine'),
        'choose_text'        => esc_attr__('Choose an Image', 'divi-machine'),
        'update_text'        => esc_attr__('Set As Image', 'divi-machine'),
        'depends_show_if'    => 'off',
        'description'        => esc_html__('Upload an image to display at the top of your ACF item.', 'divi-machine'),
        'toggle_slug'        => 'image',
        'dynamic_content'    => 'image',
        'mobile_options'     => true,
        'hover'              => 'tabs',
      ),
      'alt' => array(
        'label'           => esc_html__('Custom Image Alt Text', 'divi-machine'),
        'type'            => 'text',
        'option_category' => 'basic_option',
        'description'     => esc_html__('Define the HTML ALT text for the custom image.', 'divi-machine'),
        'depends_show_if' => 'off',
        'toggle_slug'     => 'image',
        'dynamic_content' => 'text',
      ),
      'icon_image_placement' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'image',
        'label'             => esc_html__('Image / Icon Placement', 'divi-machine'),
        'type'              => 'select',
        'options'           => array(
          'top' => esc_html__('Top', 'divi-machine'),
          'right' => sprintf(esc_html__('Right', 'divi-machine')),
          'bottom' => sprintf(esc_html__('Bottom', 'divi-machine')),
          'left' => sprintf(esc_html__('Left', 'divi-machine')),
        ),
        'default' => 'left',
        'description'       => esc_html__('Choose where you want the icon or image to be.', 'divi-machine'),
      ),

      'image_max_width' => array(
        'label'           => esc_html__('Custom Image before/after max width', 'divi-machine'),
        'description'     => esc_html__('Adjust the width of the image.', 'divi-machine'),
        'type'            => 'range',
        'option_category' => 'basic_option',
        'toggle_slug'     => 'image',
        'mobile_options'  => true,
        'validate_unit'   => true,
        'depends_show_if' => 'off',
        'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
        'default'         => '100%',
        'default_unit'    => '%',
        'default_on_front' => '',
        'allow_empty'     => true,
        'range_settings'  => array(
          'min'  => '0',
          'max'  => '100',
          'step' => '1',
        ),
        'responsive'      => true,
      ),

      'image_mobile_stacking' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'image',
        'label'             => esc_html__('Image Mobile Stacking', 'divi-machine'),
        'type'              => 'select',
        'options'           => array(
          'initial' => esc_html__('None', 'divi-machine'),
          'column' => sprintf(esc_html__('Stack', 'divi-machine')),
          'column-reverse' => sprintf(esc_html__('Stack Reverse', 'divi-machine')),
        ),
        'default' => 'initial',
        'description'       => esc_html__('CHoose how you want the image and ACF item to stack on mobile.', 'divi-machine'),
      ),

      // 'icon_image_padding_left' => array(
      //  'label'           => esc_html__( 'Image / Icon Padding Left', 'divi-machine' ),
      //  'description'     => esc_html__( 'Adjust the passing on the left of the icon or the image.', 'divi-machine' ),
      //  'type'            => 'range',
      //   'option_category' => 'basic_option',
      //   'toggle_slug'     => 'image',
      //  'validate_unit'   => true,
      //  'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
      //  'default'         => '0px',
      //  'default_unit'    => 'px',
      //  'default_on_front'=> '',
      //  'allow_empty'     => true,
      //  'range_settings'  => array(
      //    'min'  => '0',
      //    'max'  => '100',
      //    'step' => '1',
      //  ),
      // ),
      //
      // 'icon_image_padding_right' => array(
      //  'label'           => esc_html__( 'Image / Icon Padding Right', 'divi-machine' ),
      //  'description'     => esc_html__( 'Adjust the passing on the right of the icon or the image.', 'divi-machine' ),
      //  'type'            => 'range',
      //   'option_category' => 'basic_option',
      //   'toggle_slug'     => 'image',
      //  'validate_unit'   => true,
      //  'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
      //  'default'         => '10px',
      //  'default_unit'    => 'px',
      //  'default_on_front'=> '',
      //  'allow_empty'     => true,
      //  'range_settings'  => array(
      //    'min'  => '0',
      //    'max'  => '100',
      //    'step' => '1',
      //  ),
      // ),

      // Specific field

      'return_format' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'shared',
        'label'             => esc_html__('Image/File/Link: Return Format', 'divi-machine'),
        'type'              => 'select',
        'options'           => array(
          'array' => esc_html__('Array', 'divi-machine'),
          'url' => sprintf(esc_html__('URL', 'divi-machine')),
          'id' => sprintf(esc_html__('ID', 'divi-machine')),
          'value' => sprintf(esc_html__('Choice Value', 'divi-machine')),
          'label' => sprintf(esc_html__('Choice Label', 'divi-machine')),
          'both' => sprintf(esc_html__('Choice Both', 'divi-machine')),
        ),
        'default' => 'array',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('Choose how you have defined the return format in ACF settings.', 'divi-machine'),
      ),
      'image_link_url' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'image',
        'label' => esc_html__('Image: Link image to another ACF field?', 'divi-machine'),
        'type' => 'yes_no_button',
        'option_category' => 'basic_option',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('If you want to have an ACF image link to another ACF field - enable this.', 'divi-machine')
      ),
      
      'image_link_url_acf_name' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'image',
        'label'             => esc_html__('Image ACF Link Field', 'divi-machine'),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'show_if'           => array(
                  'image_link_url' => 'on'
        ),
        'description'       => esc_html__('Choose the ACF link field that you want to make the image link to', 'divi-machine'),
      ),

      'checkbox_style' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_checkbox_settings',
				'sub_toggle'		=> 'checkbox',
        'label'             => esc_html__('Checkbox: Style', 'divi-machine'),
        'type'              => 'select',
        'options'           => array(
          'list' => esc_html__('List (Comma Seperated)', 'divi-machine'),
          'bullet' => sprintf(esc_html__('Bullet List', 'divi-machine')),
          'numbered' => sprintf(esc_html__('Numbered List', 'divi-machine')),
        ),
        'default' => 'array',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('Choose how you want the checkbox to be displayed.', 'divi-machine'),
      ),

      'checkbox_radio_return' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_checkbox_settings',
				'sub_toggle'		=> 'shared',
        'label'             => esc_html__('Checkbox/Radio/Select Return Type', 'divi-machine'),
        'type'              => 'select',
        'options'           => array(
          'value' => esc_html__('Value', 'divi-machine'),
          'label' => sprintf(esc_html__('Label', 'divi-machine')),
        ),
        'default' => 'label',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('Choose what you want to show. For example if the options is = red-color : Red = "red-color" is the value and "Red" is the label. Useful to return the value if you are adding HTML to the site and want this shown.', 'divi-machine'),
      ),

      'checkbox_radio_value_type' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_checkbox_settings',
				'sub_toggle'		=> 'shared',
        'label' => esc_html__('Checkbox/Radio field: Is value a url?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'affects' => array(
          'checkbox_radio_link'
        ),
        'description' => esc_html__('Enable this if you want to make the file or link a button.', 'divi-machine')
      ),

      'checkbox_radio_link' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_checkbox_settings',
				'sub_toggle'		=> 'shared',
        'label' => esc_html__('Checkbox/Radio field: Make it a link?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'show_if' => 'on',
        'description' => esc_html__('Enable this if you want to make the file or link a button.', 'divi-machine')
      ),

      'checkbox_radio_link' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_checkbox_settings',
				'sub_toggle'		=> 'shared',
        'label' => esc_html__('Checkbox/Radio field: Make it a link?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'show_if_not' => 'default',
        'description' => esc_html__('Enable this if you want to make the file or link a button.', 'divi-machine')
      ),

      'link_button' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'shared',
        'label' => esc_html__('File/Link/Email/Phone field: Make it a Button?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description' => esc_html__('Enable this if you want to make the file or link a button.', 'divi-machine')
      ),

      'email_subject' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'email',
        'label' => esc_html__('Email: Subject', 'divi-machine'),
        'type' => 'select',
        'options_category' => 'configuration',
        'options' => array(
          'none' => esc_html__('None', 'divi-machine'),
          'page_title' => esc_html__('Page Title', 'divi-machine'),
          'page_url' => esc_html__('Page URL', 'divi-machine'),
          'custom_text' => esc_html__('Custom Text', 'divi-machine'),
        ),
        'default' => 'none',
        'description' => esc_html__('If it is an ACF email type and you want a subject, choose it here.', 'divi-machine')
      ),

      'email_subject_custom' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'email',
        'label' => esc_html__('Email: Subject Custom Text', 'divi-machine'),
        'type' => 'text',
        'options_category' => 'configuration',
        'default' => '',
        'description' => esc_html__('If custom, add the text you want for the subject here.', 'divi-machine'),
        'show_if'   => array('email_subject', 'custom_text')
      ),

      'email_body_text' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'email',
        'label' => esc_html__('Email: Body Text', 'divi-machine'),
        'type' => 'text',
        'options_category' => 'configuration',
        'default' => '',
        'description' => esc_html__('Add text you want for the body in the email link.', 'divi-machine')
      ),

      'email_body_after' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'email',
        'label' => esc_html__('Email: Body after', 'divi-machine'),
        'type' => 'select',
        'options_category' => 'configuration',
        'options' => array(
          'none' => esc_html__('None', 'divi-machine'),
          'page_title' => esc_html__('Page Title', 'divi-machine'),
          'page_url' => esc_html__('Page URL', 'divi-machine'),
        ),
        'default' => 'none',
        'description' => esc_html__('Choose what you want to appear after your body text.', 'divi-machine')
      ),

      'email_custom_parameters' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'email',
        'label' => esc_html__('Email: Custom parameters', 'divi-machine'),
        'type' => 'text',
        'options_category' => 'configuration',
        'default' => '',
        'description' => esc_html__('Add any other email parameters you want to prepend on the link.', 'divi-machine')
      ),

      'add_css_class' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'conditional',
        'label' => esc_html__('Checkbox/Select - Add value as a CSS class?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if you want the checkbox or select to add the value as a CSS class to the body or another element. This is useful when you want to add custom styling for different pages.', 'divi-machine')
      ),
      'add_css_loop_layout' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'conditional',
        'label' => esc_html__('Is this in a loop layout?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'show_if' => array(
          'add_css_class' => 'on',
        ),
        'description' => esc_html__('Enable this if the value is inside a loop laout, then we will check for the element inside the same grid item.', 'divi-machine')
      ),

      'add_css_class_selector' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'conditional',
        'label' => esc_html__('CSS Selector', 'divi-machine'),
        'type' => 'text',
        'options_category' => 'configuration',
        'default' => 'body',
        'description' => esc_html__('Add the CSS class or ID that you want to target.', 'divi-machine'),
        'show_if' => array(
          'add_css_class' => 'on',
        )
      ),
      'add_css_class_prefix' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'conditional',
        'label' => esc_html__('CSS name prefix', 'divi-machine'),
        'type' => 'text',
        'options_category' => 'configuration',
        'default' => '',
        'description' => esc_html__('Add any text you want as a prefix, could be something like: color-. The value of the ACF field will directly follow this', 'divi-machine'),
        'show_if' => array(
          'add_css_class' => 'on',
        )
      ),
      'add_css_class_suffix' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'conditional',
        'label' => esc_html__('CSS name suffix', 'divi-machine'),
        'type' => 'text',
        'options_category' => 'configuration',
        'default' => '',
        'description' => esc_html__('Add any text you want as a suffix, could be something like: -value. The value of the ACF field will appear just before this', 'divi-machine'),
        'show_if' => array(
          'add_css_class' => 'on',
        )
      ),

      'link_new_tab' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'shared',
        'label' => esc_html__('Link/URL/image/email/phone: Open in a New Tab?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'on',
        'description' => esc_html__('Enable this if you want the link to open up in a new tab.', 'divi-machine')
      ),
      'link_name_acf' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'shared',
        'label' => esc_html__('Link/URL: Set name as another ACF Field?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if you want to set the name of the download link or button as another ACF.', 'divi-machine')
      ),
      
      'link_name_acf_name' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'shared',
        'label'             => esc_html__('ACF Name', 'divi-machine'),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'show_if'           => array(
                  'link_name_acf' => 'on'
        ),
        'description'       => esc_html__('Add the name of the ACF you want to be as the name for the link here', 'divi-machine'),
      ),


      'link_button_text' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'shared',
        'label'             => esc_html__('File/Link/URL/Email: Custom Text for Button', 'divi-machine'),
        'type'              => 'text',
        'default'           => '',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'       => esc_html__('If you want custom text instead of the URL or file name, add it here', 'divi-machine'),
      ),


      'url_link_icon' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'shared',
        'label' => esc_html__('File/Link field: remove website link name', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if you want to remove the url name and have the icon/image link.', 'divi-machine')
      ),
      'image_size' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_image_settings',
				'sub_toggle'		=> 'image',
        'label' => __('Image: Image Size', 'divi-machine'),
        'type' => 'select',
        'options' => isset($options)?? '',
        'default' => 'full',
        'description' => __('Choose the size of the image you want to display, if you are using an image field and returning the ID or array.', 'divi-machine'),
      ),

      

      'true_false_condition' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'conditional',
        'label' => esc_html__('True/False: Hide another module/column/row in same section', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('If you want to hide another module, row or column in the same section as this ACF Item module - dependant on if a true/false is checked. - enable this', 'divi-machine')
      ),
      'true_false_condition_css_selector' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'conditional',
        'label'             => esc_html__('Hide the element with this CSS Selector', 'divi-machine'),
        'type'              => 'text',
        'default'           => '.et_pb_button',
        'description'       => esc_html__('Add the CSS class or ID that you want to hide in the same section', 'divi-machine'),
        'show_if'           => array(
          'true_false_condition' => 'on'
        )
      ),


      'true_false_text_true' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'true_false',
        'label'             => esc_html__('True/False: Text when True', 'divi-machine'),
        'type'              => 'text',
        'default'           => 'True',
        'description'       => esc_html__('Add the text you want to appear when they select true in the True / False field', 'divi-machine'),
        'show_if'           => array(
          'true_false_condition' => 'off'
        )
      ),
      'true_false_text_false' => array(
        'option_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'true_false',
        'label'             => esc_html__('True/False: Text when False', 'divi-machine'),
        'type'              => 'text',
        'default'           => 'False',
        'description'       => esc_html__('Add the text you want to appear when they select false in the True / False field', 'divi-machine'),
        'show_if'           => array(
          'true_false_condition' => 'off'
        )
      ),

      'is_audio'   => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label' => esc_html__('Is Audio?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if the field is audio.', 'divi-machine')
      ),
      'is_video'   => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label' => esc_html__('Is mp4 Video?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'affects' => array(
          'video_loop',
          'video_autoplay',
          'video_width',
          'video_height'
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if the field is video.', 'divi-machine')
      ),
      'video_width'          => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label'            => esc_html__( 'Video Width', 'divi-machine' ),
        'description'      => esc_html__( 'Define the width of the video.', 'divi-machine' ),
        'type'             => 'range',
        'allowed_units'    => array( 'px' ),
        'default'          => '640',
        'default_unit'     => 'px',
        'default_on_front' => '',
        'range_settings'   => array(
          'min'  => '1',
          'max'  => '5000',
          'step' => '1',
        ),
        'depends_show_if'  => 'on',
      ),
      'video_height'          => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label'            => esc_html__( 'Video Height', 'divi-machine' ),
        'description'      => esc_html__( 'Define the height of the video.', 'divi-machine' ),
        'type'             => 'range',
        'allowed_units'    => array( 'px' ),
        'default'          => '360',
        'default_unit'     => 'px',
        'default_on_front' => '',
        'range_settings'   => array(
          'min'  => '1',
          'max'  => '5000',
          'step' => '1',
        ),
        'depends_show_if'  => 'on',
      ),
      'video_loop'  => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label' => esc_html__('Loop Video?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'depends_show_if'   => 'on',
        'default' => 'on',
        'description' => esc_html__('Enable this if you want to loop video.', 'divi-machine')
      ),
      'video_autoplay'  => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label' => esc_html__('Autoplay Video?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'affects' => array(
          'video_thumbnail',
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'depends_show_if'   => 'on',
        'default' => 'on',
        'description' => esc_html__('Enable this if you want to play video automatically. Note, Google Chrome and Chromium based browsers may block auto playing videos.', 'divi-machine')
      ),
      'video_thumbnail'  => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label' => esc_html__('Video Thumbnail', 'divi-machine'),
        'type' => 'upload',
        'depends_show_if'   => 'on',
        'upload_button_text'      => esc_html__( 'Upload an image' ),
        'choose_text'             => esc_attr__( 'Choose an Image', 'divi-machine' ),
        'update_text'             => esc_attr__( 'Set As Image', 'divi-machine' ),
        'classes'                 => 'et_pb_video_overlay',
        'dynamic_content'         => 'image',
        'mobile_options'          => true,
        'hover'                   => 'tabs',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'depends_show_if'         => 'off',
        'description' => esc_html__('Enable this if you want to show the label of the ACF item.', 'divi-machine')
      ),

      
      'is_oembed_video'   => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label' => esc_html__('Is oEmbed Video?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if the field is an oEmbed video.', 'divi-machine')
      ),
      'defer_video'   => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label' => esc_html__('Defer Video?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if you want the YouTube video to ONLY load when the user clicks on the play button (helps with site speed).', 'divi-machine'),
        'show_if'         => array('is_oembed_video' => 'on')
      ),

      
      'defer_video_icon' => array(
        'label'               => esc_html__('Play Icon', 'divi-machine'),
        'type'                => 'select_icon',
        'option_category'     => 'basic_option',
        'class'               => array('et-pb-font-icon'),
        'default'           => 'I||divi||400',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'description'         => esc_html__('Choose the icon for the play icon.', 'divi-machine'),
        'show_if'         => array('is_oembed_video' => 'on'),
      ),
      
      'video_icon_color'         => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label'          => esc_html__( 'Play Icon Color', 'divi-machine' ),
        'description'    => esc_html__( 'Here you can define a custom color for the play icon.', 'divi-machine' ),
        'type'           => 'color-alpha',
        'custom_color'   => true,
        'hover'          => 'tabs',
        'mobile_options' => true,
      ),
      
      'video_icon_font_size'      => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label'            => esc_html__( 'Play Icon Custom Size?', 'divi-machine' ),
        'description'      => esc_html__( 'If you would like to control the size of the icon, you must first enable this option.', 'divi-machine' ),
        'type'             => 'yes_no_button',
        'options'          => array(
          'off' => esc_html__( 'No' ),
          'on'  => esc_html__( 'Yes' ),
        ),
        'affects'          => array(
          'video_icon_custom_size',
        ),
        'default'       => 'off',
      ),
      'video_icon_custom_size'          => array(
        'options_category' => 'basic_option',
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'video_audio',
        'label'            => esc_html__( 'Play Icon Font Size', 'divi-machine' ),
        'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'divi-machine' ),
        'type'             => 'range',
        'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
        'default'          => '96px',
        'default_unit'     => 'px',
        'default_on_front' => '',
        'range_settings'   => array(
          'min'  => '1',
          'max'  => '120',
          'step' => '1',
        ),
        'depends_show_if'  => 'on',
      ),

      'pretify_text' => array(
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'text',
        'label' => esc_html__('Prettify Your text?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'affects'         => array(
          'pretify_seperator',
        ),
        'default' => 'off',
        'description' => esc_html__('Enable this if you want to pretify your text, improve readibility of long numbers. 10000000 → 10 000 000.', 'divi-machine')
      ),
      'pretify_seperator' => array(
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'text',
        'label'             => esc_html__('Pretify Separator', 'divi-machine'),
        'type'              => 'text',
        'options_category' => 'configuration',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'depends_show_if'   => 'on',
        'default'           => ', ',
        'description'       => esc_html__('Set up your own separator for long numbers. 10 000, 10.000, 10-000 etc.', 'divi-machine'),
      ),
      'number_decimal' => array(
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'number',
        'label'             => esc_html__('Number Decimal', 'divi-machine'),
        'type'              => 'text',
        'options_category' => 'configuration',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'default'           => '.',
        'description'       => esc_html__('Change the decimal to another character you may want such as a comma', 'divi-machine'),
      ),
      
      'text_image' => array(
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'text',
        'label' => esc_html__('Text: Make Image', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('If you have a ACF text field that is a image URL (like from an external site) and want to show as an image, enable this.', 'divi-machine')
      ),

      'is_options_page' => array(
				'toggle_slug'     => 'main_content',
				'sub_toggle'		=> 'main',
        'label' => esc_html__('ACF is on an Options Page', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('If using ACF Pro and have made options page for your customer and want to get the values from here, enable this (https://www.advancedcustomfields.com/resources/options-page/).', 'divi-machine')
      ),

      'is_repeater_loop_layout' => array(
				'toggle_slug'     => 'specific_other_settings',
				'sub_toggle'		=> 'repeater',
        'label' => esc_html__('Is this inside a repeater loop layout?', 'divi-machine'),
        'type' => 'yes_no_button',
        'options_category' => 'configuration',
        'options' => array(
          'on' => esc_html__('Yes', 'divi-machine'),
          'off' => esc_html__('No', 'divi-machine'),
        ),
        'default' => 'off',
        'description' => esc_html__('If you are using a repeater field and have this in the custom loop layout - we try determine this and show the sub field - if it is not working, enable this to override.', 'divi-machine')
      ),

      'linked_post_style' => array(
        'option_category' => 'basic_option',
        'toggle_slug'     => 'relational',
        'label'             => esc_html__('Relational Field Style', 'divi-machine'),
        'type'              => 'select',
        'options'           => array(
          'custom' => esc_html__('Custom Loop Layout', 'divi-machine'),
          'list' => sprintf(esc_html__('Comma-Seperated List', 'divi-machine')),
        ),
        'default' => 'custom',
        'description'       => esc_html__('Choose the way you want to show your linked posts.', 'divi-machine'),
        'affects'         => array(
          'loop_layout',
          'columns',
          'columns_tablet',
          'columns_mobile',
          'link_post_seperator'
        ),
      ),
      'link_post_seperator' => array(
        'toggle_slug'       => 'relational',
        'label'             => esc_html__('List Seperator', 'divi-machine'),
        'type'              => 'text',
        'option_category'   => 'basic_option',
        'depends_show_if'   => 'list',
        'default'           => ', ',
        'description'       => esc_html__('Add the label seperator here, something like , ', 'divi-machine'),
      ),
      'loop_layout' => array(
        'label'             => esc_html__('Relational Field Loop Layout', 'divi-machine'),
        'type'              => 'select',
        'option_category' => 'basic_option',
        'toggle_slug'     => 'relational',
        'default'           => 'none',
        'depends_show_if'   => 'custom',
        'computed_affects' => array(
          '__getarchiveloop',
        ),
        'options'           => $looplayout_options,
        'description'        => esc_html__('Choose the layout you have made for each post in the loop.', 'divi-machine'),
      ),
      'columns' => array(
        'toggle_slug'       => 'relational',
        'label'             => esc_html__('Grid Columns', 'divi-machine'),
        'type'              => 'select',
        'option_category'   => 'basic_option',
        'default'   => '4',
        'depends_show_if'   => 'custom',
        'options'           => array(
          '1'  => esc_html__('One', 'divi-machine'),
          '2'  => esc_html__('Two', 'divi-machine'),
          '3' => esc_html__('Three', 'divi-machine'),
          '4' => esc_html__('Four', 'divi-machine'),
          '5' => esc_html__('Five', 'divi-machine'),
          '6' => esc_html__('Six', 'divi-machine'),
        ),
        'computed_affects' => array(
          '__getarchiveloop',
        ),
        'description'        => esc_html__('How many columns do you want to see', 'divi-machine'),
      ),
      'columns_tablet' => array(
        'toggle_slug'       => 'relational',
        'label'             => esc_html__('Tablet Grid Columns', 'divi-machine'),
        'type'              => 'select',
        'option_category'   => 'basic_option',
        'default'   => '2',
        'depends_show_if'   => 'custom',
        'options'           => array(
          1  => esc_html__('One', 'divi-machine'),
          2  => esc_html__('Two', 'divi-machine'),
          3 => esc_html__('Three', 'divi-machine'),
          4 => esc_html__('Four', 'divi-machine'),
        ),
        'computed_affects' => array(
          '__getarchiveloop',
        ),
        'description'        => esc_html__('How many columns do you want to see on tablet', 'divi-machine'),
      ),
      'columns_mobile' => array(
        'toggle_slug'       => 'relational',
        'label'             => esc_html__('Mobile Grid Columns', 'divi-machine'),
        'type'              => 'select',
        'option_category'   => 'basic_option',
        'default'   => '1',
        'depends_show_if'   => 'custom',
        'options'           => array(
          1  => esc_html__('One', 'divi-machine'),
          2  => esc_html__('Two', 'divi-machine'),
        ),
        'computed_affects' => array(
          '__getarchiveloop',
        ),
        'description'        => esc_html__('How many columns do you want to see on mobile', 'divi-machine'),
      ),

      
      'repeater_dyn_btn_acf' => array(
        'toggle_slug'       => 'repeater',
        'label'             => esc_html__('Repeater Dynamic Field Button Name', 'divi-machine'),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'option_category'   => 'basic_option',
        'description'       => esc_html__('If you are using a repeater to display a bunch of buttons to link to a file or link somewhere and you want each button to have a unique name depending on the repeater row - enable this. Make sure in this module you choose the file or link you want to use and then choose in this setting the text field you wan to use as the custom button name', 'divi-machine'),
      ),

      'button_alignment' => array(
        'label'            => esc_html__('ACF Item Alignment', 'divi-machine'),
        'description'      => esc_html__('Align your ACF item and icon/image.', 'divi-machine'),
        'type'             => 'text_align',
        'option_category'  => 'configuration',
        'options'          => et_builder_get_text_orientation_options(array('justified')),
        'tab_slug'         => 'advanced',
        'toggle_slug'      => 'alignment',
      ),
      '__getacfitem' => array(
        'type' => 'computed',
        'computed_callback' => array('de_mach_acf_item_code', 'get_acf_item'),
        'computed_depends_on' => array(
          'acf_name',
          'acf_tag',
          'pretify_text',
          'pretify_seperator',
          'prefix',
          'suffix',
          'label_seperator',
          'custom_label',
          'return_format',
          'checkbox_style',
          'columns',
          'columns_tablet',
          'columns_mobile',
          'is_video',
          'is_audio',
          'video_loop',
          'video_autoplay',
          'loop_layout',
          'font_icon',
          'use_icon',
          'link_button_text',
          'link_button'
        ),
      ),
      '__geticon' => array(
        'type' => 'computed',
        'computed_callback' => array('de_mach_acf_item_code', 'get_icon_content'),
        'computed_depends_on' => array(
          'font_icon',
          'use_icon'
        ),
      ),
      /*'__get_css_class' => array(
        'type' => 'computed',
        'computed_callback' => array('de_mach_acf_item_code', 'get_css_class'),
        'computed_depends_on' => array(
          'acf_name',
        ),
      ),*/




    );

    return $fields;
  }

  public static function get_css_class($args = array(), $conditional_tags = array(), $current_page = array())
  {
    $num = mt_rand(100000,999999);
    $css_class              = "acfitem_" . $num;
    $GLOBALS['css_class'] = $css_class ;
    return $css_class;
  }

  public static function get_icon_content( $args = array(), $conditional_tags = array(), $current_page = array())
  {

    ob_start();

    $use_icon       =  $args['use_icon'];
    $font_icon        =  $args['font_icon'];
    $css_class = 'acf-item-' . rand(0, time());

    if ('off' === $use_icon) {
    } else {
    $symbols = array( '21', '22', '23', '24', '25', '26', '27', '28', '29', '2a', '2b', '2c', '2d', '2e', '2f', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '3a', '3b', '3c', '3d', '3e', '3f', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '4a', '4b', '4c', '4d', '4e', '4f', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '5a', '5b', '5c', '5d', '5e', '5f', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '6a', '6b', '6c', '6d', '6e', '6f', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '7a', '7b', '7c', '7d', '7e', 'e000', 'e001', 'e002', 'e003', 'e004', 'e005', 'e006', 'e007', 'e009', 'e00a', 'e00b', 'e00c', 'e00d', 'e00e', 'e00f', 'e010', 'e011', 'e012', 'e013', 'e014', 'e015', 'e016', 'e017', 'e018', 'e019', 'e01a', 'e01b', 'e01c', 'e01d', 'e01e', 'e01f', 'e020', 'e021', 'e022', 'e023', 'e024', 'e025', 'e026', 'e027', 'e028', 'e029', 'e02a', 'e02b', 'e02c', 'e02d', 'e02e', 'e02f', 'e030', 'e103', 'e0ee', 'e0ef', 'e0e8', 'e0ea', 'e101', 'e107', 'e108', 'e102', 'e106', 'e0eb', 'e010', 'e105', 'e0ed', 'e100', 'e104', 'e0e9', 'e109', 'e0ec', 'e0fe', 'e0f6', 'e0fb', 'e0e2', 'e0e3', 'e0f5', 'e0e1', 'e0ff', 'e031', 'e032', 'e033', 'e034', 'e035', 'e036', 'e037', 'e038', 'e039', 'e03a', 'e03b', 'e03c', 'e03d', 'e03e', 'e03f', 'e040', 'e041', 'e042', 'e043', 'e044', 'e045', 'e046', 'e047', 'e048', 'e049', 'e04a', 'e04b', 'e04c', 'e04d', 'e04e', 'e04f', 'e050', 'e051', 'e052', 'e053', 'e054', 'e055', 'e056', 'e057', 'e058', 'e059', 'e05a', 'e05b', 'e05c', 'e05d', 'e05e', 'e05f', 'e060', 'e061', 'e062', 'e063', 'e064', 'e065', 'e066', 'e067', 'e068', 'e069', 'e06a', 'e06b', 'e06c', 'e06d', 'e06e', 'e06f', 'e070', 'e071', 'e072', 'e073', 'e074', 'e075', 'e076', 'e077', 'e078', 'e079', 'e07a', 'e07b', 'e07c', 'e07d', 'e07e', 'e07f', 'e080', 'e081', 'e082', 'e083', 'e084', 'e085', 'e086', 'e087', 'e088', 'e089', 'e08a', 'e08b', 'e08c', 'e08d', 'e08e', 'e08f', 'e090', 'e091', 'e092', 'e0f8', 'e0fa', 'e0e7', 'e0fd', 'e0e4', 'e0e5', 'e0f7', 'e0e0', 'e0fc', 'e0f9', 'e0dd', 'e0f1', 'e0dc', 'e0f3', 'e0d8', 'e0db', 'e0f0', 'e0df', 'e0f2', 'e0f4', 'e0d9', 'e0da', 'e0de', 'e0e6', 'e093', 'e094', 'e095', 'e096', 'e097', 'e098', 'e099', 'e09a', 'e09b', 'e09c', 'e09d', 'e09e', 'e09f', 'e0a0', 'e0a1', 'e0a2', 'e0a3', 'e0a4', 'e0a5', 'e0a6', 'e0a7', 'e0a8', 'e0a9', 'e0aa', 'e0ab', 'e0ac', 'e0ad', 'e0ae', 'e0af', 'e0b0', 'e0b1', 'e0b2', 'e0b3', 'e0b4', 'e0b5', 'e0b6', 'e0b7', 'e0b8', 'e0b9', 'e0ba', 'e0bb', 'e0bc', 'e0bd', 'e0be', 'e0bf', 'e0c0', 'e0c1', 'e0c2', 'e0c3', 'e0c4', 'e0c5', 'e0c6', 'e0c7', 'e0c8', 'e0c9', 'e0ca', 'e0cb', 'e0cc', 'e0cd', 'e0ce', 'e0cf', 'e0d0', 'e0d1', 'e0d2', 'e0d3', 'e0d4', 'e0d5', 'e0d6', 'e0d7', 'e600', 'e601', 'e602', 'e603', 'e604', 'e605', 'e606', 'e607', 'e608', 'e609', 'e60a', 'e60b', 'e60c', 'e60d', 'e60e', 'e60f', 'e610', 'e611', 'e612', 'e008', );

    $font_icon_index   = (int) str_replace( '%', '', $font_icon );
    $font_icon_rendered =  sprintf(
              '\%1$s',
              $symbols[$font_icon_index]
            );

      echo '<span class="dmach-icon ' . $css_class . '"></span>';
?>
      <style>
      .<?php echo $css_class;?>:before {
        content: "<?php echo $font_icon_rendered ?>"
      }
      </style>
<?php 
    }
      $data = ob_get_clean();
      return $data;
  }


  public static function get_acf_item($args = array(), $conditional_tags = array(), $current_page = array())
  {
    
    if (!is_admin()) {
      return;
    }

    ob_start();
    $acf_name = $args['acf_name'];
    $acf_tag = $args['acf_tag'];
    $pretify_text = $args['pretify_text'];
    $pretify_seperator = $args['pretify_seperator'];
    $prefix = $args['prefix'];
    $suffix = $args['suffix'];
    $label_seperator = $args['label_seperator'];
    $custom_label = $args['custom_label'];
    $return_format = $args['return_format'];
    $checkbox_style = $args['checkbox_style'];
    $columns = $args['columns'];
    $columns_tablet = $args['columns_tablet'];
    $columns_mobile = $args['columns_mobile'];
    $loop_layout        = $args['loop_layout'];
    $use_icon       =  $args['use_icon'];
    $font_icon        =  $args['font_icon'];
    $link_button_text =  $args['link_button_text'];
    $link_button =  $args['link_button'];
    //$css_class = $GLOBALS['css_class'];

    //$css_class_css              = "." . $css_class;


    if ('off' === $use_icon) {
    } else {
    $symbols = array( '21', '22', '23', '24', '25', '26', '27', '28', '29', '2a', '2b', '2c', '2d', '2e', '2f', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '3a', '3b', '3c', '3d', '3e', '3f', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '4a', '4b', '4c', '4d', '4e', '4f', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '5a', '5b', '5c', '5d', '5e', '5f', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '6a', '6b', '6c', '6d', '6e', '6f', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '7a', '7b', '7c', '7d', '7e', 'e000', 'e001', 'e002', 'e003', 'e004', 'e005', 'e006', 'e007', 'e009', 'e00a', 'e00b', 'e00c', 'e00d', 'e00e', 'e00f', 'e010', 'e011', 'e012', 'e013', 'e014', 'e015', 'e016', 'e017', 'e018', 'e019', 'e01a', 'e01b', 'e01c', 'e01d', 'e01e', 'e01f', 'e020', 'e021', 'e022', 'e023', 'e024', 'e025', 'e026', 'e027', 'e028', 'e029', 'e02a', 'e02b', 'e02c', 'e02d', 'e02e', 'e02f', 'e030', 'e103', 'e0ee', 'e0ef', 'e0e8', 'e0ea', 'e101', 'e107', 'e108', 'e102', 'e106', 'e0eb', 'e010', 'e105', 'e0ed', 'e100', 'e104', 'e0e9', 'e109', 'e0ec', 'e0fe', 'e0f6', 'e0fb', 'e0e2', 'e0e3', 'e0f5', 'e0e1', 'e0ff', 'e031', 'e032', 'e033', 'e034', 'e035', 'e036', 'e037', 'e038', 'e039', 'e03a', 'e03b', 'e03c', 'e03d', 'e03e', 'e03f', 'e040', 'e041', 'e042', 'e043', 'e044', 'e045', 'e046', 'e047', 'e048', 'e049', 'e04a', 'e04b', 'e04c', 'e04d', 'e04e', 'e04f', 'e050', 'e051', 'e052', 'e053', 'e054', 'e055', 'e056', 'e057', 'e058', 'e059', 'e05a', 'e05b', 'e05c', 'e05d', 'e05e', 'e05f', 'e060', 'e061', 'e062', 'e063', 'e064', 'e065', 'e066', 'e067', 'e068', 'e069', 'e06a', 'e06b', 'e06c', 'e06d', 'e06e', 'e06f', 'e070', 'e071', 'e072', 'e073', 'e074', 'e075', 'e076', 'e077', 'e078', 'e079', 'e07a', 'e07b', 'e07c', 'e07d', 'e07e', 'e07f', 'e080', 'e081', 'e082', 'e083', 'e084', 'e085', 'e086', 'e087', 'e088', 'e089', 'e08a', 'e08b', 'e08c', 'e08d', 'e08e', 'e08f', 'e090', 'e091', 'e092', 'e0f8', 'e0fa', 'e0e7', 'e0fd', 'e0e4', 'e0e5', 'e0f7', 'e0e0', 'e0fc', 'e0f9', 'e0dd', 'e0f1', 'e0dc', 'e0f3', 'e0d8', 'e0db', 'e0f0', 'e0df', 'e0f2', 'e0f4', 'e0d9', 'e0da', 'e0de', 'e0e6', 'e093', 'e094', 'e095', 'e096', 'e097', 'e098', 'e099', 'e09a', 'e09b', 'e09c', 'e09d', 'e09e', 'e09f', 'e0a0', 'e0a1', 'e0a2', 'e0a3', 'e0a4', 'e0a5', 'e0a6', 'e0a7', 'e0a8', 'e0a9', 'e0aa', 'e0ab', 'e0ac', 'e0ad', 'e0ae', 'e0af', 'e0b0', 'e0b1', 'e0b2', 'e0b3', 'e0b4', 'e0b5', 'e0b6', 'e0b7', 'e0b8', 'e0b9', 'e0ba', 'e0bb', 'e0bc', 'e0bd', 'e0be', 'e0bf', 'e0c0', 'e0c1', 'e0c2', 'e0c3', 'e0c4', 'e0c5', 'e0c6', 'e0c7', 'e0c8', 'e0c9', 'e0ca', 'e0cb', 'e0cc', 'e0cd', 'e0ce', 'e0cf', 'e0d0', 'e0d1', 'e0d2', 'e0d3', 'e0d4', 'e0d5', 'e0d6', 'e0d7', 'e600', 'e601', 'e602', 'e603', 'e604', 'e605', 'e606', 'e607', 'e608', 'e609', 'e60a', 'e60b', 'e60c', 'e60d', 'e60e', 'e60f', 'e610', 'e611', 'e612', 'e008', );

    $font_icon_index   = (int) str_replace( '%', '', $font_icon );
    $font_icon_rendered =  sprintf(
              '\%1$s',
              $symbols[$font_icon_index]
            );
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
      'post_type' => $post_slug,
      'post_status' => 'publish',
      'posts_per_page' => '1',
      'orderby' => 'ID',
      'order' => 'ASC',
    );

    query_posts($get_cpt_args);

    $first = true;

    if (have_posts()) {
      while (have_posts()) {
        the_post();
        // setup_postdata( $post );

        if ($first) {

         ?>
          <?php 

          //////////////////////////////////////////////////

          $get_id = get_the_ID();
          $get_title = get_the_title();
          
          if (isset($acf_name) && $acf_name !== 'none') {

            // $acf_value = get_field($acf_name, $get_id);
            $acf_get = get_field_object($acf_name);
            $acf_type = $acf_get['type'];



            // TODO: Do VB for acf items

            ?>

            <?php

            $basic_acf_types = "text, textarea, number, range, password, wysiwyg, oembed, date_picker, date_time_picker, time_picker";
            $basic_acf_types_explode = explode(', ', $basic_acf_types);

            $choice_acf_choice_types = "select, checkbox, radio, button_group, true_false";
            $choice_acf_choice_types_explode = explode(', ', $choice_acf_choice_types);


            if ($custom_label == "") {
              $show_label_dis =  $acf_get['label'] . $label_seperator;
            } else {
              $show_label_dis =  $custom_label . $label_seperator;
            }

            $show_label_dis = '<span class="dmach-acf-label">' . $show_label_dis . '</span>';

           
            if ( isset($acf_get['prepend']) && $acf_get['prepend'] !== "" ) {
               $prepend = '<span class="acf_prepend">' . $acf_get['prepend'] . '</span>';
            } else {
              $prepend = "";
            }

            if ( isset($acf_get['append']) && $acf_get['append'] !== "" ) {
              $append = '<span class="acf_append">' . $acf_get['append'] . '</span>';
           } else {
             $append = "";
           }     

              


            ////////////////////////////////////////////////////
            // basic fields
            ////////////////////////////////////////////////////
            if (in_array($acf_type, $basic_acf_types_explode)) {
              

              if ($pretify_text == "on" && ($acf_type == 'number' || $acf_type == 'range')) {
                $item_value_before = number_format($acf_get['value'], 0, '.', ',');
                $item_value = str_replace(',', $pretify_seperator, $item_value_before);
                $item_value  = str_replace(' ', '', $item_value);
                $item_value = $prepend . $item_value . $append;
              } else {
                $item_value = $prepend . $acf_get['value'] . $append;
              }

              $label_seperator = '<span class="dmach-seperator">' . esc_html($label_seperator) . '</span>';

              ?>

              <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $item_value; ?><?php echo $suffix; ?></<?php echo $acf_tag ?>>

              <?php

            }
            ////////////////////////////////////////////////////
            // image fields
            ////////////////////////////////////////////////////

            else if ($acf_type == "image") {
              if ($return_format == "array") {

                if(isset($image_size)){
                    $thumb = $acf_get['value']['sizes'][$image_size];
                }
	              if ( isset( $thumb ) ) {
		              if ($thumb == "") {
                        $thumb = $acf_get['value']['sizes']['large'];
                      }
	              }

                ?>
                <?php echo $show_label_dis ?> <img class="dmach-acf-value" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($acf_get['value']['alt']); ?>" />
              <?php } else if ($return_format == "id") {
                  if(isset($image_size)){
	                  echo wp_get_attachment_image($acf_get['value'], $image_size);
                  }
              }  else { ?>
                <?php echo $show_label_dis ?> <img class="dmach-acf-value" src="<?php echo $acf_get['value']; ?>" />
                <?php
              }
            }
            ////////////////////////////////////////////////////
            // file fields
            ////////////////////////////////////////////////////

            else if ($acf_type == "file") {

              $return_format = $acf_get['return_format'];
              $is_video = false;
              $is_audio = false;

              if ($return_format == "array") {
                $link_url = $acf_get['value']['url'];
              } else if ($return_format == "id") {
                $link_url = wp_get_attachment_url( $acf_get['value'] );
              } else { 
                $link_url = $acf_get['value'];
              }

              $mime_type = wp_check_filetype($link_url);
              if ( preg_match('/video\/*/', $mime_type['type'] ) ){
                $is_video = true;
              }
              if ( preg_match('/audio\/*/', $mime_type['type'] ) ){
                $is_audio = true;
              }

              if ($return_format == "array") {
                $title = $acf_get['value']['title'];
                $icon = $acf_get['value']['icon'];
                if ($acf_get['value']['type'] == 'image') {
                  $icon =  $acf_get['value']['sizes']['thumbnail'];
                }

                if ($link_button_text !== "") {
                  $link_button_text_dis = $link_button_text;
                } else {
                  $link_button_text_dis = esc_html($title);
                }
                ?>
                <?php echo $show_label_dis ?>
                <a class="dmach-acf-value et_pb_button" <?php echo (isset($custom_icon) ? esc_html($custom_icon) : '');?> href="<?php echo $acf_get['value']['url']; ?>"><span><?php echo $link_button_text_dis; ?></span></a>
                <a class="dmach-acf-value no-button" href="<?php echo $acf_get['value']['url']; ?>"><span><?php echo esc_html($title); ?></span></a>
                <?php
              } else if ($return_format == "id") {
                $url = wp_get_attachment_url($acf_get['value']); 
                if ($link_button_text !== "") {
                  $link_button_text_dis = $link_button_text;
                } else {
                  $link_button_text_dis = "Download File";
                }
                ?>
                <?php echo $show_label_dis ?>
                <a class="dmach-acf-value et_pb_button" <?php echo (isset($custom_icon) ? esc_html($custom_icon) : '');?> href="<?php echo esc_html($url); ?>"><?php echo $link_button_text_dis; ?></a>
                <a class="dmach-acf-value no-button" href="<?php echo esc_html($url); ?>">Download File</a> <?php
              } else { 
                if ($link_button_text !== "") {
                  $link_button_text_dis = $link_button_text;
                } else {
                  $link_button_text_dis = "Download File";
                }
                ?>
                <?php echo $show_label_dis ?>
                <a class="dmach-acf-value et_pb_button" <?php echo (isset($custom_icon) ? esc_html($custom_icon) : '');?> href="<?php echo $acf_get['value']; ?>"><?php echo $link_button_text_dis ?></a>
                <a class="dmach-acf-value no-button" href="<?php echo $acf_get['value']; ?>">Download File</a> <?php
              }
              if ( $is_video ){
                $video_loop = ($args['video_loop'] == 'on')?true:false;
                $video_autoplay = ($args['video_autoplay'] == 'on')?true:false;
                echo '<div class="dmach-acf-video-wrapper">';

                $video_args = array(
                  $mime_type['ext'] => $link_url,
                  'preload' => 'auto',
                  'autoplay' => $video_autoplay,
                  'loop'    => $video_loop
                );
                echo wp_video_shortcode( $video_args );

                if ( !$video_autoplay ){
                  $video_icon_color = $args['video_icon_color'];
                  $video_icon_font_size = ( $args['video_icon_font_size'] == 'on' )?true:false;
                  if ( $video_icon_font_size ){
                    $video_icon_custom_size = $args['video_icon_custom_size'];
                    $current_style = "color:#".$video_icon_color.";font-size:" . $video_icon_custom_size;
                  }
                ?>
                <div class="dmach-acf-video-poster">
                  <a href="#" class="dmach-acf-video-play" style="<?php echo (isset($current_style) ? esc_attr($current_style) : '');?>"></a>
                </div>
                <script>
                  jQuery(document).ready(function($){
                    $('.dmach-acf-video-play').click(function(e){
                      e.preventDefault();
                      $(this).closest('.dmach-acf-video-wrapper').addClass('playing');
                      $(this).closest('.dmach-acf-video-wrapper').find('video')[0].play();
                    });
                    $('.dmach-acf-video-wrapper video').on('pause',function(){
                      $(this).closest('.dmach-acf-video-wrapper').removeClass('playing');
                    });
                  });
                </script>
                <?php
                }

                echo '</div>';
              }
              if ($is_audio) {

                if ($return_format == "array") {
                  $audio_url = $acf_get['value']['url'];
                } else if ($return_format == "id") {
                  $audio_url = wp_get_attachment_url($acf_get['value']);
                } else {
                  $audio_url = $acf_get['value'];
                }

                echo do_shortcode("[audio src='$audio_url']");

              } 
            }

              ////////////////////////////////////////////////////
            // Choice fields
            ////////////////////////////////////////////////////

            else if (in_array($acf_type, $choice_acf_choice_types_explode)) {

              if (isset($acf_get['multiple']) && $acf_get['multiple'] == "1") {
                $getselected_name = isset($acf_get['choices'][$acf_get['value']])?$acf_get['choices'][$acf_get['value']]:'';
                $class_name = isset($getselected_name) && !is_array($getselected_name)?str_replace(' ', '-', strtolower($getselected_name)):'';
                ?>
                <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo $class_name ?>"><?php echo $show_label_dis ?><?php echo is_array($getselected_name)?implode(', ', $getselected_name):''; ?></<?php echo $acf_tag ?>>
                <?php
              } else {
                if ($acf_type == "checkbox") {
               
                  $getselected_name = $acf_get['value'];
                  $choices = $acf_get['choices'];

                  $class_name = isset($getselected_name) && !is_array($getselected_name)?str_replace(' ', '-', strtolower($getselected_name)):'';
                  if ($checkbox_style == "bullet") {
                    ?>
                    <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo $class_name ?>"><?php echo $show_label_dis ?>
                    <?php
                echo "<ul>";
                    foreach( $getselected_name as $v ) { 
                      $value_css_class = str_replace(' ', '-', strtolower($choices[$v]));
                      echo '<li class="'.$value_css_class.'">'. $choices[$v].'</li>';
                    }
                echo "</ul>";
                ?>
                    </<?php echo $acf_tag ?>>
                    <?php
                  } else if ($checkbox_style == "numbered") {
                    ?>
                    <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?>
                    <?php
                echo "<ol>";
                    foreach( $getselected_name as $v ) { 
                      $value_css_class = str_replace(' ', '-', strtolower($choices[$v]));
                      echo '<li class="'.$value_css_class.'">'. $choices[$v].'</li>';
                    }
                echo "</ol>";
                ?>
                    </<?php echo $acf_tag ?>>
                    <?php
                  } else {
                  ?>
                  <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?><?php echo implode(', ', $getselected_name); ?></<?php echo $acf_tag ?>>
                  <?php
                  }

                } else if ($acf_type == "true_false") {
                  ?>
                  <<?php echo $acf_tag ?> class="dmach-acf-value">
                    <?php echo $show_label_dis ?>
                    <?php
                    if ($acf_get['value'] == "1") {
                        echo ($true_false_text_true ?? '');
                    } else {
                        echo ($true_false_text_false ?? '');
                    }
                    ?></<?php echo $acf_tag ?>>
                    <?php
                  } else {
                    $getselected_name = $acf_get['value'];
                    $class_name = str_replace(' ', '-', strtolower($getselected_name));
                    ?>
                    <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo $class_name ?>"><?php echo $show_label_dis ?><?php echo $getselected_name ?></<?php echo $acf_tag ?>>
                    <?php
                  }
                }
              }
              ////////////////////////////////////////////////////
              //  link fields
              ////////////////////////////////////////////////////

              else if ($acf_type == "link" || $acf_type == "email" || $acf_type == "dmachphone") {

                if ($link_button == "on") {
                  $link_button_css = "et_pb_button";
                } else {
                  $link_button_css = "";
                }
                

                if ($return_format == "array") {
                  $title = isset($acf_get['value']['title'])?$acf_get['value']['title']:'';
                  $target = isset($acf_get['value']['target'])?$acf_get['value']['target']:'';
                  $url = $acf_get['value']['url'] ?? '';


                    if ( isset( $link_name_acf_name ) ) {
                        $link_name_acf_name_get = get_field_object($link_name_acf_name);
                    }
                  if ($link_button_text !== "") {
                    $link_button_text_dis = $link_button_text;
                  } else if ( isset( $link_name_acf ) ) {
	                  if ($link_name_acf == "on" && $link_name_acf_name_get['value'] !== "none") {
                        $link_button_text_dis = $link_name_acf_name_get['value'];
                      } else {
                        $link_button_text_dis = esc_html($title);
                      }
                  }
                  ?>
                  <?php echo $show_label_dis ?>
                  <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo ($custom_icon ?? '');?> href="<?php echo $url; ?>" target="<?php echo esc_html($target) ?>">
                    <span><?php echo $link_button_text_dis; ?></span>
                  </a>
                  <?php
                } else { 
                  if ($link_button_text !== "") {
                    $link_button_text_dis = $link_button_text;
                  } else {
                    $link_button_text_dis = $acf_get['value'];
                  }
                  ?>
                  <?php echo $show_label_dis ?>
                  <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo ($custom_icon ?? '');?> href="<?php echo $acf_get['value']; ?>" target="<?php echo (isset($target) ? esc_html($target) : '') ?>"><?php echo $link_button_text_dis; ?></a><?php
                }
              }
              ////////////////////////////////////////////////////
              //  POST OBJECT fields
              ////////////////////////////////////////////////////

              else if ($acf_type == "post_object") {
                

                $item_value = $acf_get['value'];
          
          
                ?>
                <div class="dmach-acf-item-container">
                  <?php echo ($icon_image_placement_left ?? ''); ?>
                  <div class="dmach-acf-item-content">
                    <?php if (isset($text_before) && $text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
          
                    <div class="dmach-acf-value">
          
                      <?php if (is_array($item_value)) {
                        // TODO:
                        // get correct posts
          
                        ?>
          
                        <div class="repeater-cont grid col-desk-<?php echo $columns ?> col-tab-<?php echo $columns_tablet ?> col-mob-<?php echo $columns_mobile ?>">
                          <div class="grid-posts acf-loop-grid"> <?php
                          
                          global $post;
                          $current_post = $post;
                          foreach ($item_value as $item) {
                            $post = $item;
                            setup_postdata( $item );
                            ?>
                              <div class="grid-col">
                                  <div class="grid-item-cont">
                                    <?php
                                    echo apply_filters('the_content', get_post_field('post_content', $loop_layout));
                                    ?>
                                  </div>
                              </div>
                              <?php
                          }
                          $post = $current_post;
                          ?>
                          </div>
          
          
                        </div>
          
                      </div>
                      <?php
                          
                    } else {
          
                      $args_postobject = array(
                        'post_type'         => $acf_get['post_type'][0],
                        'post_status' => 'publish',
                        'posts_per_page' => '1',
                        'post__in'       => array( $item_value->ID )
                      );
          
          
          query_posts( $args_postobject );
          
          if ( have_posts() ) {
            
            while ( have_posts() ) {
              the_post();
              setup_postdata( $args_postobject );
          
              $post_content = apply_filters( 'the_content', get_post_field('post_content', $loop_layout) );

              $post_content = preg_replace( '/et_pb_section_(\d+)_tb_body/', 'et_pb_dmach_section_${1}_tb_body', $post_content );

              $post_content = preg_replace( '/et_pb_row_(\d+)_tb_body/', 'et_pb_dmach_row_${1}_tb_body', $post_content );

              $post_content = preg_replace( '/et_pb_column_(\d+)_tb_body/', 'et_pb_dmach_column_${1}_tb_body', $post_content );

          
              $post_content = preg_replace( '/et_pb_section_(\d+)/', 'et_pb_dmach_section_${1}', $post_content );

              $post_content = preg_replace( '/et_pb_row_(\d+)/', 'et_pb_dmach_row_${1}', $post_content );

            echo $post_content;

            $internal_style = ET_Builder_Element::get_style();
            // reset all the attributes after we retrieved styles
            ET_Builder_Element::clean_internal_modules_styles( false );
            $et_pb_rendering_column_content = false;

            // append styles
            if ( $internal_style ) {
              ?>
                  <div class="dmach-inner-styles">
              <?php
                      $cleaned_styles = str_replace("#et-boc .et-l","#et-boc .et-l .filtered-posts", $internal_style);
                      $cleaned_styles = str_replace(".et_pb_section_",".filtered-posts .et_pb_ajax_filter_section_", $cleaned_styles);
                      $cleaned_styles = str_replace(".et_pb_row_",".filtered-posts .et_pb_ajax_filter_row_", $cleaned_styles);
                      $cleaned_styles = str_replace(".et_pb_module_",".filtered-posts .et_pb_module_", $cleaned_styles);
                      $cleaned_styles = str_replace(".et_pb_column_",".filtered-posts .et_pb_ajax_filter_column_", $cleaned_styles);
                      $cleaned_styles = str_replace(".et_pb_de_mach_",".filtered-posts .et_pb_de_mach_", $cleaned_styles);
                      $cleaned_styles = str_replace(".filtered-posts .filtered-posts",".filtered-posts", $cleaned_styles);
                      $cleaned_styles = str_replace(".filtered-posts .et_pb_section .filtered-posts",".filtered-posts", $cleaned_styles);
              
                      printf(
                          '<style type="text/css" class="dmach_ajax_inner_styles">
                            %1$s
                          </style>',
                          et_core_esc_previously( $cleaned_styles )
                      );
              ?>
                  </div>
              <?php
                  }
          
                    } // end while have posts
          
                  }
          
                  wp_reset_query();
          
                    }
                    ?>
          
                  </div>
          
                </div>
                <?php echo ($icon_image_placement_right ?? ''); ?>
              </div>
              <?php
          
          
            }



            } else {
              echo 'Please select an ACF field you have created';
            }

            //////////////////////////////////////////////////
            $first = false;

            ?>
           
            <?php 
          } else {
          }
        }
      }

      $data = ob_get_clean();

      return $data;
    }


    public function get_button_alignment($device = 'desktop')
    {
      $suffix           = 'desktop' !== $device ? "_{$device}" : '';
      $text_orientation = isset($this->props["button_alignment{$suffix}"]) ? $this->props["button_alignment{$suffix}"] : '';

      return et_pb_get_alignment($text_orientation);
    }



    function render($attrs, $content, $render_slug)
    {

      // if (is_admin()) {
      //     return;
      // }

      $acf_name                        = $this->props['acf_name'];
      $acf_name_custom                        = $this->props['acf_name_custom'];

      if ($acf_name == 'custom_acf_name_de') {
        $acf_name = $acf_name_custom;
      }
      
      $acf_tag                        = $this->props['acf_tag'];
      // $acf_type                        = $this->props['acf_type'];
      $use_icon                        = $this->props['use_icon'];
      $font_icon                       = $this->props['font_icon'];

      $image_mobile_stacking           = $this->props['image_mobile_stacking'];
      

      $icon_color                      = $this->props['icon_color'];
      $icon_color_hover                = $this->get_hover_value('icon_color');
      $icon_color_values               = et_pb_responsive_options()->get_property_values($this->props, 'icon_color');
      $icon_color_tablet               = isset($icon_color_values['tablet']) ? $icon_color_values['tablet'] : '';
      $icon_color_phone                = isset($icon_color_values['phone']) ? $icon_color_values['phone'] : '';

      $circle_color                    = $this->props['circle_color'];
      $circle_color_hover              = $this->get_hover_value('circle_color');
      $circle_color_values             = et_pb_responsive_options()->get_property_values($this->props, 'circle_color');
      $circle_color_tablet             = isset($circle_color_values['tablet']) ? $circle_color_values['tablet'] : '';
      $circle_color_phone              = isset($circle_color_values['phone']) ? $circle_color_values['phone'] : '';

      $show_label                      = $this->props['show_label'];
      $custom_label                    = $this->props['custom_label'];


      $label_seperator                 = $this->props['label_seperator'];
      $image                           = $this->props['image'];
      $image_alt                         = $this->props['alt'];
      $icon_image_placement            = $this->props['icon_image_placement'];
      $use_circle                      = $this->props['use_circle'];
      $use_circle_border               = $this->props['use_circle_border'];
      $icon_pos_top                      = $this->props['icon_pos_top'] ?: '0px';
      $icon_pos_left                      = $this->props['icon_pos_left'] ?: '0px';
      


      $circle_border_color             = $this->props['circle_border_color'];
      $circle_border_color_hover       = $this->get_hover_value('circle_border_color');
      $circle_border_color_values      = et_pb_responsive_options()->get_property_values($this->props, 'circle_border_color');
      $circle_border_color_tablet      = isset($circle_border_color_values['tablet']) ? $circle_border_color_values['tablet'] : '';
      $circle_border_color_phone       = isset($circle_border_color_values['phone']) ? $circle_border_color_values['phone'] : '';

      $icon_placement                  = $this->props['icon_image_placement'];
      $icon_placement_values           = et_pb_responsive_options()->get_property_values($this->props, 'icon_placement');
      $icon_placement_tablet           = isset($icon_placement_values['tablet']) ? $icon_placement_values['tablet'] : '';
      $icon_placement_phone            = isset($icon_placement_values['phone']) ? $icon_placement_values['phone'] : '';
      $is_icon_placement_responsive    = et_pb_responsive_options()->is_responsive_enabled($this->props, 'icon_placement');
      $is_icon_placement_top           = !$is_icon_placement_responsive ? 'top' === $icon_placement : in_array('top', $icon_placement_values);

      $return_format                   = $this->props['return_format'];
      // $choice_return_format            = $this->props['choice_return_format'];
      $image_size                      = $this->props['image_size'];
      $prefix                      = $this->props['prefix'];
      $suffix                      = $this->props['suffix'];
      $text_before                     = $this->props['text_before'];
      $true_false_text_true            = $this->props['true_false_text_true'];
      $true_false_text_false           = $this->props['true_false_text_false'];

      $image_max_width                 = $this->props['image_max_width'];
      $image_max_width_tablet          = $this->props['image_max_width_tablet'];
      $image_max_width_phone           = $this->props['image_max_width_phone'];
      $image_max_width_last_edited     = $this->props['image_max_width_last_edited'];

      $loop_layout                     = $this->props['loop_layout'];

      $linked_post_style                     = $this->props['linked_post_style'];
      $link_post_seperator                     = $this->props['link_post_seperator'];
 
      $columns                = $this->props['columns'];
      $columns_tablet         = $this->props['columns_tablet'];
      $columns_mobile         = $this->props['columns_mobile'];

      $pretify_text     = $this->props['pretify_text'];
      $pretify_seperator     = $this->props['pretify_seperator'];

      $checkbox_radio_value_type  = $this->props['checkbox_radio_value_type'];
      $checkbox_radio_link  = $this->props['checkbox_radio_link'];

      $link_button    = $this->props['link_button'];
      $link_button_text    = $this->props['link_button_text'];
      $url_link_icon    = $this->props['url_link_icon'];
      $is_video     = $this->props['is_video'];
      $video_width     = $this->props['video_width'];
      $video_height     = $this->props['video_height'];
      $is_audio     = $this->props['is_audio'];

      $text_image     = $this->props['text_image'];
     
      $visibility     = $this->props['visibility'];

      
      $repeater_dyn_btn_acf     = $this->props['repeater_dyn_btn_acf'];
      
      $number_decimal     = $this->props['number_decimal'];
      
      $checkbox_radio_return     = $this->props['checkbox_radio_return'];

      $true_false_condition     = $this->props['true_false_condition'];
      $true_false_condition_css_selector     = $this->props['true_false_condition_css_selector'];
      

      $add_css_class     = $this->props['add_css_class'];
      $add_css_loop_layout     = $this->props['add_css_loop_layout'];
      $add_css_class_selector     = $this->props['add_css_class_selector'];
      $add_css_class_prefix     = $this->props['add_css_class_prefix'];
      $add_css_class_suffix     = $this->props['add_css_class_suffix'];


      $email_subject     = $this->props['email_subject'];
      $email_subject_custom     = $this->props['email_subject_custom'];
      $email_body_text     = $this->props['email_body_text'];
      $email_body_after     = $this->props['email_body_after'];
      $email_custom_parameters     = $this->props['email_custom_parameters'];
            

      $is_oembed_video     = $this->props['is_oembed_video'];
      $defer_video     = $this->props['defer_video'];
      $video_icon_color     = $this->props['video_icon_color'];
      $video_icon_font_size     = $this->props['video_icon_font_size'];
      $video_icon_custom_size     = $this->props['video_icon_custom_size'];   
      $defer_video_icon     = $this->props['defer_video_icon'];   
      

      
      $link_new_tab    = $this->props['link_new_tab'];

      if ($link_new_tab == "on") {
        $link_new_tab_dis = 'target="_blank"';
      } else {
        $link_new_tab_dis = '';
      }
      
      
      $link_name_acf    = $this->props['link_name_acf'];
      $link_name_acf_name    = $this->props['link_name_acf_name'];

      $checkbox_style    = $this->props['checkbox_style'];

      
      $is_options_page    = $this->props['is_options_page'];
      
      
      $empty_value_option    = $this->props['empty_value_option'];
      $empty_value_option_element    = $this->props['empty_value_option_element'];
      $empty_value_option_custom_text    = $this->props['empty_value_option_custom_text'];
      
      $is_repeater_loop_layout    = $this->props['is_repeater_loop_layout'];
      $is_author_acf_field    = $this->props['is_author_acf_field'];
      $current_taxonomy_slug    = $this->props['current_taxonomy_slug'];
      

      $post_object_acf_name    = $this->props['post_object_acf_name'];
      
      $author_field_type    = $this->props['author_field_type'];
      $type_taxonomy_acf_name    = $this->props['type_taxonomy_acf_name'];
      

      $image_link_url    = $this->props['image_link_url'];
      $image_link_url_acf_name    = $this->props['image_link_url_acf_name'];
      

      

      $use_icon_font_size            = $this->props['use_icon_font_size'];
      $icon_font_size                = $this->props['icon_font_size'];
      $button_use_icon            = $this->props['button_use_icon'];

      $custom_icon              = $this->props['button_icon'];
      $button_custom            = $this->props['custom_button'];
      $button_bg_color          = $this->props['button_bg_color'];
      $button_bg_hover_color          = isset($this->props['button_bg_color__hover'])?$this->props['button_bg_color__hover']:'';

      $button_alignment                = $this->get_button_alignment();
      $button_alignments = sprintf('et_pb_de_mach_alignment_%1$s', esc_attr($button_alignment));

      $this->add_classname($button_alignments);

      $font_icon_rendered = DEDMACH_INIT::et_icon_css_content(esc_attr($font_icon));

      $is_image_svg   = isset($image_pathinfo['extension']) ? 'svg' === $image_pathinfo['extension'] : false;

      $icon_selector = '%%order_class%% .dmach-icon';

      if ('' !== $image_max_width_tablet || '' !== $image_max_width_phone || '' !== $image_max_width || $is_image_svg) {
        $is_size_px = false;

        // If size is given in px, we want to override parent width
        if (
          false !== strpos($image_max_width, 'px') ||
          false !== strpos($image_max_width_tablet, 'px') ||
          false !== strpos($image_max_width_phone, 'px')
        ) {
          $is_size_px = true;
        }
        // SVG image overwrite. SVG image needs its value to be explicit
        if ('' === $image_max_width && $is_image_svg) {
          $image_max_width = '100%';
        }

        // Image max width selector.
        $image_max_width_selectors       = array();
        $image_max_width_reset_selectors = array();
        $image_max_width_reset_values    = array();

        $image_max_width_selector = $is_image_svg ? '%%order_class%% .dmach-icon-image-content' : '%%order_class%% .dmach-icon-image-content';


        foreach (array('tablet', 'phone') as $device) {
          $device_icon_placement = 'tablet' === $device ? $icon_placement_tablet : $icon_placement_phone;
          if (empty($device_icon_placement)) {
            continue;
          }

          $image_max_width_selectors[$device] = 'top' === $device_icon_placement && $is_image_svg ? '%%order_class%% .dmach-icon-image-content' : '%%order_class%% .dmach-icon-image-content';

          $prev_icon_placement = 'tablet' === $device ? $icon_placement : $icon_placement_tablet;
          if (empty($prev_icon_placement) || $prev_icon_placement === $device_icon_placement || !$is_image_svg) {
            continue;
          }

          // Image/icon placement setting is related to image width setting. In some cases,
          // user uses different image/icon placement settings for each devices. We need to
          // reset previous device image width styles to make it works with current style.
          $image_max_width_reset_selectors[$device] = '%%order_class%% .dmach-icon-image-content';
          $image_max_width_reset_values[$device]    = array('width' => '32px');

          if ('top' === $device_icon_placement) {
            $image_max_width_reset_selectors[$device] = '%%order_class%% .dmach-icon-image-content';
            $image_max_width_reset_values[$device]    = array('width' => 'auto');
          }
        }

        // Add image max width desktop selector if user sets different image/icon placement setting.
        if (!empty($image_max_width_selectors)) {
          $image_max_width_selectors['desktop'] = $image_max_width_selector;
        }

        $image_max_width_property = ($is_image_svg || $is_size_px) ? 'width' : 'max-width';

        $image_max_width_responsive_active = et_pb_get_responsive_status($image_max_width_last_edited);

        $image_max_width_values = array(
          'desktop' => $image_max_width,
          'tablet'  => $image_max_width_responsive_active ? $image_max_width_tablet : '',
          'phone'   => $image_max_width_responsive_active ? $image_max_width_phone : '',
        );

        $main_image_max_width_selector = $image_max_width_selector;

        // Overwrite image max width if there are image max width selectors for different devices.
        if (!empty($image_max_width_selectors)) {
          $main_image_max_width_selector = $image_max_width_selectors;

          if (!empty($image_max_width_selectors['tablet']) && empty($image_max_width_values['tablet'])) {
            $image_max_width_values['tablet'] = $image_max_width_responsive_active ? esc_attr(et_pb_responsive_options()->get_any_value($this->props, 'image_max_width_tablet', '100%', true)) : esc_attr($image_max_width);
          }

          if (!empty($image_max_width_selectors['phone']) && empty($image_max_width_values['phone'])) {
            $image_max_width_values['phone'] = $image_max_width_responsive_active ? esc_attr(et_pb_responsive_options()->get_any_value($this->props, 'image_max_width_phone', '100%', true)) : esc_attr($image_max_width);
          }
        }


        et_pb_responsive_options()->generate_responsive_css($image_max_width_values, $main_image_max_width_selector, $image_max_width_property, $render_slug);

        // Reset custom image max width styles.
        if (!empty($image_max_width_selectors) && !empty($image_max_width_reset_selectors)) {
          et_pb_responsive_options()->generate_responsive_css($image_max_width_reset_values, $image_max_width_reset_selectors, $image_max_width_property, $render_slug, '', 'input');
        }
      }


      if ('off' === $use_icon) {
      } else {
        $font_icon_arr = explode('||', $font_icon);
        $icon_style        = sprintf('color: %1$s;', esc_attr($icon_color));
        $icon_tablet_style = '' !== $icon_color_tablet ? sprintf('color: %1$s;', esc_attr($icon_color_tablet)) : '';
        $icon_phone_style  = '' !== $icon_color_phone ? sprintf('color: %1$s;', esc_attr($icon_color_phone)) : '';
        $icon_style_hover  = '';

        if (et_builder_is_hover_enabled('icon_color', $this->props)) {
          $icon_style_hover = sprintf('color: %1$s;', esc_attr($icon_color_hover));
        }

        if ('on' === $use_circle) {
          $icon_style .= sprintf(' background-color: %1$s;', esc_attr($circle_color));
          $icon_tablet_style .= '' !== $circle_color_tablet ? sprintf(' background-color: %1$s;', esc_attr($circle_color_tablet)) : '';
          $icon_phone_style  .= '' !== $circle_color_phone ? sprintf(' background-color: %1$s;', esc_attr($circle_color_phone)) : '';

          if (et_builder_is_hover_enabled('circle_color', $this->props)) {
            $icon_style_hover .= sprintf(' background-color: %1$s;', esc_attr($circle_color_hover));
          }

          if ('on' === $use_circle_border) {
            $icon_style .= sprintf(' border-color: %1$s;', esc_attr($circle_border_color));
            $icon_tablet_style .= '' !== $circle_border_color_tablet ? sprintf(' border-color: %1$s;', esc_attr($circle_border_color_tablet)) : '';
            $icon_phone_style  .= '' !== $circle_border_color_phone ? sprintf(' border-color: %1$s;', esc_attr($circle_border_color_phone)) : '';

            if (et_builder_is_hover_enabled('circle_border_color', $this->props)) {
              $icon_style_hover .= sprintf(' border-color: %1$s;', esc_attr($circle_border_color_hover));
            }
          }
        }

        $font_icon_font_family = ( !empty( $font_icon_arr[1] ) && $font_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
        $font_icon_font_weight = ( !empty( $font_icon_arr[2] ))?$font_icon_arr[2]:'400';
        
          ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .dmach-icon',
            'declaration' => sprintf(
              'position: relative;
              top: %1$s;
              left: %2$s;',
              $icon_pos_top,
              $icon_pos_left
            ),
          ));

        ET_Builder_Element::set_style($render_slug, array(
          'selector'    => '%%order_class%% .dmach-icon:before',
          'declaration' => sprintf(
            'content: "%1$s";
            color: %2$s;
            font-family:"%3$s"!important;
            font-weight:%4$s;',
            $font_icon_rendered,
            $icon_color,
            $font_icon_font_family,
            $font_icon_font_weight
          ),
        ));

        ET_Builder_Element::set_style($render_slug, array(
          'selector'    => '%%order_class%% .dmach-icon:hover:before',
          'declaration' => sprintf(
            'color: %1$s;',
            $icon_color_hover
          ),
        ));

        ET_Builder_Element::set_style($render_slug, array(
          'selector'    => $icon_selector,
          'declaration' => $icon_style,
        ));

        ET_Builder_Element::set_style($render_slug, array(
          'selector'    => $icon_selector,
          'declaration' => $icon_tablet_style,
          'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
          'selector'    => $icon_selector,
          'declaration' => $icon_phone_style,
          'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));


        if ('' !== $icon_style_hover) {
          ET_Builder_Element::set_style($render_slug, array(
            'selector'    => $this->add_hover_to_order_class($icon_selector),
            'declaration' => $icon_style_hover,
          ));
        }

        $image_classes[] = 'et-pb-icon';

        if ('on' === $use_circle) {
          $image_classes[] = 'et-pb-icon-circle';
        }

        if ('on' === $use_circle && 'on' === $use_circle_border) {
          $image_classes[] = 'et-pb-icon-circle-border';
        }
      
        if ( 'off' !== $use_icon_font_size ) {
          
          ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .dmach-icon:before',
            'declaration' => sprintf(
              'font-size: %1$s;',
              $icon_font_size
            ),
          ));
    
          if ( et_builder_is_hover_enabled( 'icon_font_size', $this->props ) ) {
            $el_style = array(
              'selector'    => $this->add_hover_to_order_class( $icon_selector ),
              'declaration' => sprintf(
                'font-size: %1$s;',
                isset($icon_font_size_hover) ? esc_html( $icon_font_size_hover ) : ''
              ),
            );
            ET_Builder_Element::set_style( $render_slug, $el_style );
          }
        }
      
      }

      
      if( $button_use_icon == 'on' && $custom_icon != '' ){
        
        $custom_icon_arr = explode('||', $custom_icon);
        $custom_icon_font_family = ( !empty( $custom_icon_arr[1] ) && $custom_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
        $custom_icon_font_weight = ( !empty( $custom_icon_arr[2] ))?$custom_icon_arr[2]:'400';

        $custom_icon = 'data-icon="'. esc_attr( et_pb_process_font_icon( $custom_icon ) ) .'"';
        ET_Builder_Element::set_style( $render_slug, array(
          'selector'    => 'body #page-container %%order_class%% .et_pb_button:after',
          'declaration' => "content: attr(data-icon);
            font-family:{$custom_icon_font_family}!important;
            font-weight:{$custom_icon_font_weight};",
        ) );
      }else{
        ET_Builder_Element::set_style( $render_slug, array(
          'selector'    => 'body #page-container %%order_class%% .et_pb_button:hover',
          'declaration' => "padding: .3em 1em;",
        ) );
      }

      if( !empty( $button_bg_color ) ){

        ET_Builder_Element::set_style( $render_slug, array(
          'selector'    => 'body #page-container %%order_class%% .et_pb_button',
          'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
        ) );
      }

      if( !empty( $button_bg_hover_color ) ){

        ET_Builder_Element::set_style( $render_slug, array(
          'selector'    => 'body #page-container %%order_class%% .et_pb_button:hover',
          'declaration' => "background-color:". esc_attr( $button_bg_hover_color ) ."!important;",
        ) );
      }


      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => 'body #page-container %%order_class%% .dmach-acf-item-container',
        'declaration' => "flex-direction:". esc_attr( $image_mobile_stacking ) .";",
        'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
      ) );

      
      //////////////////////////////////////////////////////////////////////

      ob_start();

      
      $term = get_queried_object();

      if ( $visibility == "logged_in" && !is_user_logged_in() ) {
        $this->add_classname("hidethis");
        return;
      }

      $author_id = get_the_author_meta('ID');
      $check_if_author_field = get_field_object($acf_name, 'user_'. $author_id);
      
      // $cat_acf = get_field( $acf_name, $cat_key . "_" . $term_id );
       
      if ($is_options_page == "off") {
        if (get_field($acf_name)) {
          $acf_get = get_field_object($acf_name);
          $noacf = false;
        } else if (get_sub_field($acf_name)) {
          $acf_get = get_sub_field_object($acf_name);
          $noacf = false;
        } else if (!empty($check_if_author_field) && !is_archive()) {
          $acf_get = get_field_object($acf_name, 'user_'. $author_id);
          $noacf = false;
        } else {
          $noacf = true;
        }

        if ( ! empty( $acf_get ) ) {
          if ( $acf_get['value'] == "" ) {
            $noacf = true;
          } else {
            $noacf = false;
          }
        }

      } else {
        if (get_field($acf_name, 'option')) {
        $noacf = false;
        $acf_get = get_field_object($acf_name, 'option');
        } else {
          $noacf = true;
        }
        
      }
    
    if ($is_repeater_loop_layout == "on") {
        $acf_get = get_sub_field_object($acf_name);
        $noacf = false;
      }
      

      if ($is_author_acf_field == "on") {
        if ($author_field_type == 'logged_in') {
          $author_id = get_current_user_id();
        } else {
          $author_id = $author_id;
        }

        $acf_get = get_field_object($acf_name, 'user_'. $author_id);
        $noacf = false;
      } else if ($is_author_acf_field == "taxonomy") {

        $type_taxonomy_acf_name_get = get_field_object($type_taxonomy_acf_name);
        
        $taxonomy = $type_taxonomy_acf_name_get['taxonomy'];

        if (!empty($type_taxonomy_acf_name_get['value']['0'])){
          $termid = $type_taxonomy_acf_name_get['value']['0'];
        } else {
          $termid = $type_taxonomy_acf_name_get['value'];
        }

          $acf_get = get_field_object($acf_name, $taxonomy . '_' . $termid);
        $noacf = false;
      } else if ($is_author_acf_field == "post_object") {

        $post_object_acf_name = get_field_object($post_object_acf_name);
        $post_object_val = $post_object_acf_name['value'];
        if ( isset( $post_object_val->ID ) ) {
            $post_object_id = $post_object_val->ID;
        }

        $acf_get = get_field_object($acf_name, $post_object_id);

        $noacf = false;

      } else if ($is_author_acf_field == "current_taxonomy") {
        global $de_categoryloop_term;
        if (isset($de_categoryloop_term)) {
          $acf_get = get_field_object($acf_name, $current_taxonomy_slug . '_' . $de_categoryloop_term->term_id);
          $noacf = false;
        } else {
          $acf_get = get_field_object($acf_name, $current_taxonomy_slug . '_' . $term->term_id);
          $noacf = false;
        }
      }
    
    if (is_archive() && $noacf == true) { // on category page and looking for tax ACF item
        $acf_get = get_field_object($acf_name, $term);
        $noacf = false;
      }
    
      global $post;
      if (isset($acf_get['value']) && ((!is_array($acf_get['value']) && $acf_get['value'] == "") || (is_array($acf_get['value']) && count($acf_get['value']) == 0))) {
        if ( $acf_get['parent'] != 0 ) {
          $parent_obj = get_post( $acf_get['parent'] );
       $parent_acf_obj = get_field_object( $parent_obj->post_name );
          if ( $parent_obj->post_type == 'acf-field-group' || ( $parent_obj->post_type == 'acf-field' && isset($parent_acf_obj['type']) && $parent_acf_obj['type'] == 'repeater')) {
            $noacf = true;
          } else if ( isset($parent_acf_obj['type']) && $parent_acf_obj['type'] == 'group') {
            if ( have_rows( $parent_obj->post_name ) ) {
              while ( have_rows( $parent_obj->post_name ) ) : the_row();
                  $acf_get['value'] = get_sub_field( $acf_name );
              endwhile;
            }

            if ( $acf_get['value'] == "" ) {
              $noacf = true;
            } else {
              $noacf = false;
            }
          }
        }
      }
      
      if ( ! $noacf ) {

	      if ( ! empty( $acf_get ) ) {
		      if ( array_key_exists( 'type', $acf_get ) ) {
			      $acf_type = $acf_get['type'];
		      }
	      }

	      /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
		  $titan = TitanFramework::getInstance( 'divi-machine' );*/
	      $enable_debug = de_get_option_value( 'divi-machine', 'enable_debug' );//$titan->getOption( 'enable_debug' );

	      if ( $enable_debug == "1" ) {
		      if ( ! empty( $acf_type ) ) {
			      echo "<p class=\"reporting_args hidethis\">ACF Type: $acf_type</p>";
		      }
	      }

	      if ( ! empty( $acf_get ) ) {
              if(array_key_exists('value',$acf_get)) {
	              if ( $acf_get['value'] == "" ) {
		              $this->add_classname( "hidethis" );
	              } else {
		              $this->add_classname( "dmach-acf-has-value" );
	              }
              }
	      }

        $label_seperator = '<span class="dmach-seperator">' . esc_html($label_seperator) . '</span>';

        if ($show_label == "on") {
          if ($custom_label == "") {
	          if ( isset( $acf_get ) ) {
		          $show_label_dis =  $acf_get['label'] . $label_seperator;
	          }
          } else {
            $show_label_dis =  $custom_label . $label_seperator;
          }

          do_action( 'wpml_register_single_string', 'divi-machine', 'ACF custom Label', $show_label_dis );

          $show_label_dis = '<span class="dmach-acf-label">' . $show_label_dis . '</span>';
        } else {
          $show_label_dis = "";
        }

        if ($use_icon == "on") {
            $fa_class = '';
            if (!empty($font_icon_arr)) {
                if(array_key_exists(1,$font_icon_arr)){
                    if ( $font_icon_arr[1] == 'fa' ){
                      $fa_class = 'fas';
                    }
                }
            }
            $icon_image_dis = '<div class="dmach-icon-image-content"><span class="dmach-icon ' . $fa_class . '"></span></div>';
        } else {
          if ($image == "") {
            $icon_image_dis = "";
          } else {
            $icon_image_dis = sprintf('<div class="dmach-icon-image-content"><img src="%1$s" alt="%2$s"></div>',$image,$image_alt);
          }
        }

        if ($icon_image_placement == "top" || $icon_image_placement == "left") {
          $icon_image_placement_left = $icon_image_dis;
          $icon_image_placement_right = "";
        } else {
          $icon_image_placement_left = "";
          $icon_image_placement_right = $icon_image_dis;
        }


        $this->add_classname('dmach-image-icon-placement-' . $icon_image_placement . '');

        $basic_acf_types = "text, textarea, number, range, password, wysiwyg, oembed, date_picker, date_time_picker, time_picker";
        $basic_acf_types = apply_filters('divi_machine_basic_acf_types', $basic_acf_types);

        $basic_acf_types_explode = explode(', ', $basic_acf_types);

        $choice_acf_choice_types = "select, checkbox, radio, button_group, true_false, taxonomy";
        $choice_acf_choice_types = apply_filters('divi_machine_choice_acf_types', $choice_acf_choice_types);
        
        $choice_acf_choice_types_explode = explode(', ', $choice_acf_choice_types);

    
        if ( isset($acf_get['prepend']) && $acf_get['prepend'] !== "") {
          $prepend = '<span class="acf_prepend">' . $acf_get['prepend'] . '</span>';
        } else {
          $prepend = "";
        }
 

    
        if ( isset($acf_get['append']) && $acf_get['append'] !== "") {
          $append = '<span class="acf_append">' . $acf_get['append'] . '</span>';
        } else {
          $append = "";
        }

	      if ( isset( $acf_type ) ) {
		      if ( $acf_type != "post_object") {
			      if ( ! empty( $acf_get ) ) {
				      if ( !empty( $acf_get['value'] ) && !is_array( $acf_get['value'] ) ) {
                        $acf_get['value'] = do_shortcode( $acf_get['value'] );
                      }
			      }
              }
	      }

        ////////////////////////////////////////////////////
        // basic fields
        ////////////////////////////////////////////////////
	      if ( isset( $acf_type ) ) {
		      if (in_array($acf_type, $basic_acf_types_explode)) {

                if ($pretify_text == "on" && ($acf_type == 'number' || $acf_type == 'range')) {
                  if ( $acf_get['value'] == '' ){
                    $acf_get['value'] = 0;
                  } else {
                    $acf_get['value'] = floatval($acf_get['value']);
                  }
                  $item_value_before = number_format($acf_get['value'], 0, $number_decimal, ',');
                  $item_value = str_replace(',', $pretify_seperator, $item_value_before);
                  $item_value  = str_replace(' ', '', $item_value);
                  $item_value = $prepend . $item_value . $append;

                  if ($item_value == '0') {
                    $item_value = '';
                  }
                } else {

                  $item_value_un = $prepend . $acf_get['value'] . $append;
                  $item_value = str_replace(".",$number_decimal,$item_value_un);
                }


                if ( $is_audio == "on" ){
                  $audio_url = strip_tags($acf_get['value']);
                  ?>

                  <div class="dmach-acf-audio-oembed-poster">
                  <iframe src="<?php echo $audio_url ?>" style="width:100%; height:100px;" scrolling="no" frameborder="no"></iframe>
                  </div>
                  <?php
                } else if ($acf_type == 'text' && $text_image == 'on') {

                  if (!empty($acf_get['value'])) :
                    ?>
                    <div class="dmach-acf-item-container">
                      <?php echo $icon_image_placement_left; ?>
                      <div class="dmach-acf-item-content">
                        <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>

                          <?php echo $show_label_dis ?> <img class="dmach-acf-value" src="<?php echo $acf_get['value']; ?>" />

                      </div>
                      <?php echo $icon_image_placement_right; ?>
                      <div class="repeater_sep"></div>
                    </div>
                  <?php endif;

                } else {

                  if ($item_value !== '') {
                    ?>
                    <div class="dmach-acf-item-container">
                      <?php echo $icon_image_placement_left; ?>
                      <div class="dmach-acf-item-content">
                        <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>

                        <?php if ($acf_tag == 'img') {
                          ?>
                          <img class="dmach-acf-value" src="<?php echo $item_value; ?>" />
                          <?php
                        } else {
                          // IS OEMBED VIDEO


                          if ($is_oembed_video == 'on' && $defer_video == 'on') {
                            $youtube_video_url = get_field($acf_name, false, false);
                            $youtube_video_url_parsed = parse_url($youtube_video_url);
                            $host = $youtube_video_url_parsed['host'];
                            if (isset($youtube_video_url_parsed['query'])) {
                              $query_id = $youtube_video_url_parsed['query'];
                              $query_id = str_replace("v=", "",$query_id);
                            } else {
                              $query_id = $youtube_video_url_parsed['path'];
                              $query_id = str_replace("/", "",$query_id);
                            }
                            if ($host == 'www.youtube.com' || $host == 'youtube.com' || $host == 'youtu.be') {
                              $vido_type_dis = "de_demach_youtube_listener";
                              // $thumbnail_src = "https://img.youtube.com/vi/" . $query_id . "/0.jpg";
                              $thumbnail_src = "https://img.youtube.com/vi/" . $query_id . "/maxresdefault.jpg";
                            } else if ($host == 'www.vimeo.com' || $host == 'vimeo.com') {
                              $vido_type_dis = "de_demach_vimeo_listener";
                              $video_info = file_get_contents('https://vimeo.com/api/v2/video/' . $query_id . '.json');
                              if ( $video_info !== FALSE ) {
                                $obj = json_decode($video_info);
                                $thumbnail_src = $obj[0]->thumbnail_large;
                              }
                            }

                            $output = sprintf(
                              '<div id="%2$s" class="de_dmach_defer_video %3$s" data-id="%2$s" data-thumb="%1$s" data-thumbalt="" style="background-image:url(%1$s);background-repeat: no-repeat;background-size: cover;background-position: center;"></div>',
                              $thumbnail_src ?? '',
                              $query_id,
                              $vido_type_dis ?? ''
                            );

                            echo $output; // phpcs:ignore

                            ET_Builder_Element::set_style($render_slug, array(
                              'selector'    => '.de_dmach_defer_video',
                              'declaration' => '
                                position: relative;
                                padding-bottom: 56.23%;
                                height: 0;
                                overflow: hidden;
                                max-width: 100%;
                                background: #000;
                                ',
                            ));

                            ET_Builder_Element::set_style($render_slug, array(
                              'selector'    => '.de_dmach_defer_video iframe',
                              'declaration' => '
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                z-index: 100;
                                background: 0 0;
                                ',
                            ));

                            ET_Builder_Element::set_style($render_slug, array(
                              'selector'    => '.de_dmach_defer_video img',
                              'declaration' => '
                                height: 100%;
                                margin: 0;
                                bottom: 0;
                                display: block;
                                left: 0;
                                max-width: 100%;
                                width: 100%;
                                position: absolute;
                                right: 0;
                                top: 0;
                                border: none;
                                cursor: pointer;
                                -webkit-transition: 0.4s all;
                                -moz-transition: 0.4s all;
                                transition: 0.4s all;
                                ',
                            ));

                            ET_Builder_Element::set_style($render_slug, array(
                              'selector'    => '.de_dmach_defer_video:hover img',
                              'declaration' => '
                                -webkit-filter: brightness(50%);
                                ',
                            ));


                            $defer_video_icon_rendered = DEDMACH_INIT::et_icon_css_content(esc_attr($defer_video_icon));

                            $defer_video_icon_arr = explode('||', $defer_video_icon);
                            $defer_video_icon_family = ( !empty( $defer_video_icon_arr[1] ) && $defer_video_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                            $defer_video_icon_weight = ( !empty( $defer_video_icon_arr[2] ))?$defer_video_icon_arr[2]:'400';
                            ET_Builder_Element::set_style($render_slug, array(
                              'selector'    => '%%order_class%% .et_pb_video_play::before',
                              'declaration' => sprintf(
                                'content: "%1$s";
                                color: %2$s;
                                font-family:"%3$s"!important;
                                font-weight:%4$s;',
                                $defer_video_icon_rendered,
                                $video_icon_color,
                                $defer_video_icon_family,
                                $defer_video_icon_weight
                              ),
                            ));

                            if ($video_icon_font_size == 'on') {

                              ET_Builder_Element::set_style( $render_slug, array(
                                'selector' => '%%order_class%% .et_pb_video_play::before',
                                'declaration' => "
                                font-size: {$video_icon_custom_size} !important;
                                "
                                )
                              );
                            }

                          } else {
                            ?>
                            <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo ($is_video)?'dmach-acf-video-container':'';?>"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $item_value; ?><?php echo $suffix; ?></<?php echo $acf_tag ?>>
                            <?php
                          }
                        } ?>
                      </div>
                      <?php echo $icon_image_placement_right; ?>
                      <div class="repeater_sep"></div>
                    </div>
                    <?php
                  }



                }
              }

              ////////////////////////////////////////////////////
              // image fields
              ////////////////////////////////////////////////////

              else if ($acf_type == "image") {




                $return_format = $acf_get['return_format'];

                if (!empty($acf_get['value'])) :
                  ?>
                  <div class="dmach-acf-item-container">

                    <?php if ($image_link_url == 'on') {
                      $image_link_url_acf_name_get = get_field_object($image_link_url_acf_name);

                      if (is_array($image_link_url_acf_name_get['value'])) {
                        $target = 'target="'.$image_link_url_acf_name_get['value']['target'].'"';
                        $link_url = $image_link_url_acf_name_get['value']['url'];
                      } else {
                        $link_url = $image_link_url_acf_name_get['value'];
                        $target = $link_new_tab_dis;
                      }

                        if ($link_url == "") {
                          $image_link_url_acf_name_get = get_sub_field_object($image_link_url_acf_name);


                          if (is_array($image_link_url_acf_name_get['value'])) {
                              $target = 'target="'.$image_link_url_acf_name_get['value']['target'].'"';
                            $link_url = $image_link_url_acf_name_get['value']['url'];
                          } else {
                            $link_url = $image_link_url_acf_name_get['value'];
                            $target = $link_new_tab_dis;
                          }

                        }


                      ?>
                      <a class="image-acf-text-link" <?php echo $target ?> href="<?php echo $link_url ?>" >
                      <?php
                    } ?>

                    <?php echo $icon_image_placement_left; ?>
                    <div class="dmach-acf-item-content">
                      <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                      <?php if ($return_format == "array") {


                        $thumb = $acf_get['value']['sizes'][$image_size] ?? $acf_get['value']['sizes']['large'];
                        $image_alt_tag = $acf_get['value']['alt'];

                        ?>
                        <?php echo $show_label_dis ?> <img class="dmach-acf-value" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($image_alt_tag); ?>" />
                      <?php } else if ($return_format == "id") {
                        echo wp_get_attachment_image($acf_get['value'], $image_size);
                      } else { ?>
                        <?php echo $show_label_dis ?> <img class="dmach-acf-value" src="<?php echo $acf_get['value']; ?>" alt="<?php echo is_array( $acf_get['value'] ) && isset( $acf_get['value']['alt'] ) ?$acf_get['value']['alt']:''; ?>" />
                      <?php } ?>
                    </div>
                    <?php echo $icon_image_placement_right; ?>

                    <?php if ($image_link_url == 'on') {
                      ?>
                      </a>
                      <?php
                    } ?>
                    <div class="repeater_sep"></div>
                  </div>
                <?php endif;
              }

              ////////////////////////////////////////////////////
              // file fields
              ////////////////////////////////////////////////////

              else if ($acf_type == "file") {


                if ($link_button == "on") {
                  $link_button_css = "et_pb_button";
                } else {
                  $link_button_css = "";
                }

                $return_format = $acf_get['return_format'];

                if ($acf_get['value']) :

                  if ($return_format == "array") {
                    $link_url = $acf_get['value']['url'];
                  } else if ($return_format == "id") {
                    $link_url = wp_get_attachment_url( $acf_get['value'] );
                  } else {
                    $link_url = $acf_get['value'];
                  }

                  $is_video = false;
                  $is_audio = false;

                  $mime_type = wp_check_filetype($link_url);
                  if ( preg_match('/video\/*/', $mime_type['type'] ) ){
                    $is_video = true;
                  }
                  if ( preg_match('/audio\/*/', $mime_type['type'] ) ){
                    $is_audio = true;
                  }


                  if ($url_link_icon == 'on' && !$is_video ) {
                    if (!$is_audio){
                  ?> <a href="<?php echo $link_url; ?>" <?php echo $link_new_tab_dis;?>> <?php
                    }
                  }
                ?>

                <div class="dmach-acf-item-container <?php echo ($is_video)?'dmach-acf-video-container':'';?>">
                  <?php echo $icon_image_placement_left; ?>
                  <div class="dmach-acf-item-content">
                    <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                    <?php
                      if ($repeater_dyn_btn_acf != "none") {

                        $link_button_text_dis = get_sub_field($repeater_dyn_btn_acf);
                      } else if ($link_button_text !== "") {
                        $link_button_text_dis = $link_button_text;
                      } else {
                        $link_button_text_dis = "Download File";
                      }
                      ?>


                    <?php if ($return_format == "array") {
                      $title = $acf_get['value']['title'];
                      $icon = $acf_get['value']['icon'];
                      if ($acf_get['value']['type'] == 'image') {
                        $icon =  $acf_get['value']['sizes']['thumbnail'];
                      }
                      ?>
                      <?php echo $show_label_dis ?>

                      <?php
                      if ($repeater_dyn_btn_acf != "none") {
                        $link_button_text_dis = get_sub_field($repeater_dyn_btn_acf);
                      } else if ($link_button_text !== "") {
                        $link_button_text_dis = $link_button_text;
                      } else {
                        $link_button_text_dis = esc_html($title);
                      }


                      do_action( 'wpml_register_single_string', 'divi-machine', 'ACF custom button Label', $link_button_text_dis );
                      $link_button_text_dis = apply_filters( 'wpml_translate_single_string', $link_button_text_dis, 'divi-machine', 'ACF custom button Label' );


                      ?>

                      <?php
                      if ($url_link_icon == 'off' && !$is_video) {
                        if (!$is_audio){
                      ?>
                      <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo $custom_icon?> href="<?php echo $acf_get['value']['url']; ?>" <?php echo $link_new_tab_dis;?>>
                        <span><?php echo $link_button_text_dis; ?></span>
                      </a>
                      <?php
                        }
                    }

                    } else if ($return_format == "id") {

                      if ($url_link_icon == 'off' && !$is_video) {
                        if (!$is_audio){
                      $url = wp_get_attachment_url($acf_get['value']); ?>
                      <?php echo $show_label_dis ?>
                      <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo $custom_icon?> href="<?php echo esc_html($url); ?>" <?php echo $link_new_tab_dis;?>><?php echo $link_button_text_dis; ?></a>
                      <?php
                        }
                      }

                    } else {
                      if ($url_link_icon == 'off' && !$is_video) {
                        if (!$is_audio){
                      echo $show_label_dis ?>
                      <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo $custom_icon?> href="<?php echo $acf_get['value']; ?>" <?php echo $link_new_tab_dis;?>><?php echo $link_button_text_dis; ?></a> <?php
                        }
                      }
                    }

                    ?>
                    <?php
                    if ( $is_video ){

                      $video_loop = ($this->props['video_loop'] == 'on')?true:false;
                      $video_autoplay = ($this->props['video_autoplay'] == 'on')?true:false;
                      echo '<div class="dmach-acf-video-wrapper">';

                      $video_args = array(
                        $mime_type['ext'] => $link_url,
                        'preload' => 'auto',
                        'autoplay' => $video_autoplay,
                        'muted'    => $video_autoplay,
                        'loop'    => $video_loop,
                        'height'  => $video_width,
                        'width'   => $video_height
                      );


                      echo wp_video_shortcode( $video_args );

                      if ( !$video_autoplay ){
                        $video_thumbnail = $this->props['video_thumbnail'];
                        $video_icon_color = $this->props['video_icon_color'];
                        $video_icon_font_size = ( $this->props['video_icon_font_size'] == 'on' )?true:false;
                        if ( $video_icon_font_size ){
                          $video_icon_custom_size = $this->props['video_icon_custom_size'];
                          $current_style = "color:".$video_icon_color.";font-size:" . $video_icon_custom_size;
                        }
                      ?>
                      <div class="dmach-acf-video-poster">
                        <img src="<?php echo $video_thumbnail;?>" class="poster"/>
                        <a href="#" class="dmach-acf-video-play" style="<?php echo ($current_style ?? '');?>"></a>
                      </div>
                      <script>
                        jQuery(document).ready(function($){
                          $('.dmach-acf-video-play').click(function(e){
                            e.preventDefault();
                            $(this).closest('.dmach-acf-video-wrapper').addClass('playing');
                            $(this).closest('.dmach-acf-video-wrapper').find('video')[0].play();
                          });
                          $('.dmach-acf-video-wrapper video').on('pause',function(){
                            $(this).closest('.dmach-acf-video-wrapper').removeClass('playing');
                          });
                        });
                      </script>
                      <?php
                      }

                      echo '</div>';
                    }

                    if ($is_audio) {

                      if ($return_format == "array") {
                        $audio_url = $acf_get['value']['url'];
                      } else if ($return_format == "id") {
                        $audio_url = wp_get_attachment_url($acf_get['value']);
                      } else {
                        $audio_url = $acf_get['value'];
                      }

                      echo do_shortcode("[audio src='$audio_url']");

                    }

                    ?>
                  </div>
                  <?php echo $icon_image_placement_right; ?>

                  <?php if ($url_link_icon == 'on' && !$is_video ) {
                    if (!$is_audio){
                  ?> </a> <?php
                    }
                  }
                   ?>
                  <div class="repeater_sep"></div>
                </div>
                <?php
                endif;
              }
            ////////////////////////////////////////////////////
            // Choice fields
            ////////////////////////////////////////////////////

            else if (in_array($acf_type, $choice_acf_choice_types_explode)) {
              if ($acf_get['value']) :
                ?>
                <div class="dmach-acf-item-container">
                  <?php echo $icon_image_placement_left; ?>
                  <div class="dmach-acf-item-content">
                    <?php
                    if ( isset($acf_get['multiple']) && $acf_get['multiple'] == "1") {
                      if (is_array($acf_get['value'])) {
                        $getselected_name = $acf_get['value'];
                        if (is_array($acf_get['value'])) {
                          $class_name = "";
                        } else {
                          $class_name = str_replace(' ', '-', strtolower($acf_get['value']));
                        }
                        ?>
                        <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?> </p> <?php } ?>
                        <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo $class_name ?>"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo implode(', ',  $getselected_name); ?><?php echo $suffix; ?></<?php echo $acf_tag ?>>
                        <?php
                      }
                    } else {
                      if ($acf_type == "checkbox" || $acf_type == "taxonomy" ) {
                        if ($checkbox_radio_return == "label") {
                          $value = $acf_get['value'];
                          $getselected_name = array();

                          $target = "_self";
                          if ( $link_new_tab == 'on' ) {
                            $target = "_blank";
                          }

                          if (is_array($acf_get['value'])) {
                            $class_name = "";
                            foreach( $acf_get['value'] as $key => $acf_value ) {
                              if ( $checkbox_radio_value_type == 'on' && $checkbox_radio_link == 'on' ) {
                                if ( !empty( $acf_get['choices'][ $acf_value ] ) ) {

                                  if ($acf_type == "taxonomy") {
                                    $term = get_term( $acf_get['choices'][ $acf_value ] );
                                    $value_final = $term->name;
                                  } else {
                                    $value_final = $acf_get['choices'][ $acf_value ];
                                  }

                                  $getselected_name[] = '<a href="' . $acf_value . '" target="' . $target . '">' . $acf_get['choices'][ $acf_value ] . '</a>';
                                } else {
                                  $getselected_name[] = '<a href="' . $acf_value . '" target="' . $target . '">' . $acf_value . '</a>';
                                }

                              } else {
                                if ($acf_type == "taxonomy") {
                                  $term = get_term( $acf_value );
                                  $getselected_name[] = $term->name;//$acf_get['choices'][$acf_value];
                                } else {
                                  $getselected_name[] = $acf_value;//$acf_get['choices'][$acf_value];
                                }
                              }
                            }
                          } else {
                            $class_name = str_replace(' ', '-', strtolower($acf_get['choices'][ $value ]));
                            if ( $checkbox_radio_value_type == 'on' && $checkbox_radio_link == 'on' ) {
                              if ( !empty( $acf_get['choices'][ $value ] ) ) {
                                $getselected_name = '<a href="' . $value . '" target="' . $target . '">' . $acf_get['choices'][ $value ] . '</a>';
                              } else {
	                              if ( isset( $acf_value ) ) {
		                              $getselected_name = '<a href="' . $value . '" target="' . $target . '">' . $acf_value . '</a>';
	                              }
                              }
                            }else {
                              if ( !empty( $acf_get['choices'][ $value ] ) ) {
                                $getselected_name = $acf_get['choices'][ $value ];
                              } else {
	                              if ( isset( $acf_value ) ) {
		                              $getselected_name = $acf_value;
	                              }
                              }
                            }
                          }
                        } else {
                          $getselected_name = $acf_get['value'];
                          $class_name = "";
                          $target = "_self";
                          if ( $link_new_tab == 'on' ) {
                            $target = "_blank";
                          }
                            foreach( $getselected_name as $key => $selected_name ) {
                              if ( $checkbox_radio_value_type == 'on' && $checkbox_radio_link == 'on' ) {
                                $getselected_name[$key] = '<a href="' . $selected_name . '" target="' . $target . '">' . $selected_name . '</a>';
                              } else {
                                $getselected_name[$key] = $selected_name;
                              }
                            }
                        }


                        if ($getselected_name == '') {
	                        if ( isset( $value ) ) {
		                        $getselected_name = $value;
	                        }
                        }

                        if ($add_css_class == 'on') {
                          $css_value = '';
                          if (is_array($getselected_name)) {
                            foreach($getselected_name as $array_item) {
                              $array_item_remove_spaces = str_replace(' ', '-', $array_item);
                              $css_value .=  $add_css_class_prefix . '' . $array_item_remove_spaces . '' . $add_css_class_suffix . ' ';
                            }
                          } else {
                            $css_value_remove_spaces = str_replace(' ', '-', $getselected_name);
                            $css_value = $add_css_class_prefix . '' . $css_value_remove_spaces . '' . $add_css_class_suffix;
                          }

                          if ($add_css_loop_layout == 'on') {
                            $num = mt_rand(100000,999999);
                            ?>
                            <div class="hide_this <?php echo esc_attr($num) ?>"></div>
                            <script>
                              jQuery(document).ready(function () {
                              jQuery('.<?php echo esc_attr($num) ?>').closest('.dmach-grid-item').find('<?php echo esc_attr($add_css_class_selector) ?>').addClass('<?php echo esc_attr($css_value) ?>');
                              });
                            </script>
                            <?php
                          } else {
                            ?>
                            <script>
                              jQuery(document).ready(function () {
                              jQuery('<?php echo esc_attr($add_css_class_selector) ?>').addClass('<?php echo esc_attr($css_value) ?>');
                            });
                              </script>
                            <?php
                          }
                        }

                        if ($checkbox_style == "bullet") {
                          ?>
                          <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?> </p> <?php } ?>
                          <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo $class_name ?>"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php
                          echo "<ul>";
                          foreach ($getselected_name as $key => $value) {
                            //$value_css_class = str_replace(' ', '-', strtolower($value));
                            $value_css_class = str_replace(' ', '-',strtolower(strip_tags($value)));
                            echo '<li class="'.$value_css_class.'">'. $value .'</li>';
                          }
                          echo "</ul>";
                          ?>
                          <?php echo $suffix; ?>
                          </<?php echo $acf_tag ?>>
                          <?php
                        } else if ($checkbox_style == "numbered") {
                          ?>
                          <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?> </p> <?php } ?>
                          <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php
                      echo "<ol>";
                      foreach ($getselected_name as $key => $value) {
                        $value_css_class = str_replace(' ', '-', strtolower($value));
                        echo '<li class="'.$value_css_class.'">'. $value .'</li>';
                      }
                      echo "</ol>";
                      ?>
                      <?php echo $suffix; ?>
                          </<?php echo $acf_tag ?>>
                          <?php
                        } else {
                        ?>
                        <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?> </p> <?php } ?>
                        <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?><?php echo implode(', ', $getselected_name); ?></<?php echo $acf_tag ?>>
                        <?php
                        }
                      } else if ($acf_type == "true_false") {

                        if ($true_false_condition == 'on') {
                          ?>
                          <div class="checkbox_hide_this"></div>
                          <script>
                        jQuery(document).ready(function($){
                            jQuery('.checkbox_hide_this').closest('.et_pb_section').find('<?php echo esc_html($true_false_condition_css_selector) ?>').hide();
                        });
                          </script>
                          <?php
                        } else {

                        ?>
                        <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                        <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php if ($acf_get['value'] == "1") {echo $true_false_text_true;} else {echo $true_false_text_false;}?><?php echo $suffix; ?></<?php echo $acf_tag ?>>
                          <?php

                        }


                        } else if ($acf_type == "select") {

                          $value = $acf_get['value'];
                          $getselected_name='';
                          
                          if ($checkbox_radio_return == "label") {
                            if ( array_key_exists($value,$acf_get['choices'])) {
                              $getselected_name = $acf_get['choices'][ $value ];
                            }
                            if ($getselected_name == '') {
                              $getselected_name = $value;
                            }
                          } else {
                            if ( array_key_exists($value,$acf_get['choices'])) {
                              $getselected_name = $acf_get['choices']['value'];
                            }
                            if ($getselected_name == '') {
                              $getselected_name = $value;
                            }
                          }


                          if ($add_css_class == 'on') {
                            $css_value = str_replace(' ', '-', $getselected_name);

                            if ($add_css_loop_layout == 'on') {
                              $num = mt_rand(100000,999999);
                              ?>
                              <div class="hide_this <?php echo esc_attr($num) ?>"></div>
                              <script>
                                jQuery(document).ready(function () {
                                jQuery('.<?php echo esc_attr($num) ?>').closest('.dmach-grid-item').find('<?php echo esc_attr($add_css_class_selector) ?>').addClass('<?php echo esc_attr($add_css_class_prefix) ?><?php echo esc_attr($css_value) ?><?php echo esc_attr($add_css_class_suffix) ?>');
                                });
                              </script>
                              <?php
                            } else {
                              ?>
                              <script>
                                jQuery(document).ready(function () {
                                jQuery('<?php echo esc_attr($add_css_class_selector) ?>').addClass('<?php echo esc_attr($add_css_class_prefix) ?><?php echo esc_attr($css_value) ?><?php echo esc_attr($add_css_class_suffix) ?>');
                              });
                                </script>
                              <?php
                            }
                          }


                          if (is_array($acf_get['value'])) {
                            $class_name = "";
                          } else {
                            $class_name = str_replace(' ', '-', strtolower($acf_get['value']));
                          }
                          ?>
                          <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                          <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo $class_name ?>"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $getselected_name ?><?php echo $suffix; ?></<?php echo $acf_tag ?>>
                          <?php

                        } else {
                            if ( array_key_exists('value',$acf_get) ) {
                              if ($checkbox_radio_return == "label") {
                                $value = $acf_get['value'];
                                $getselected_name = array();
                                if (is_array($acf_get['value'])) {
                                  $class_name = "";
                                  foreach( $acf_get['value'] as $key => $acf_value ) {
                                     $getselected_name[] = $acf_value;//$acf_get['choices'][ $acf_value ];
                                  }
                                } else {
                                  $class_name = str_replace(' ', '-', strtolower($acf_get['value'])); //str_replace(' ', '-', strtolower($acf_get['choices'][$value]));
                                  $getselected_name = $acf_get['value'];//$acf_get['choices'][$value];
                                }
                              } else {
                                $getselected_name = $acf_get['value'];
                                $class_name = "";
                              }
                              ?>
                              <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                              <<?php echo $acf_tag ?> class="dmach-acf-value <?php echo $class_name ?>"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $getselected_name ?><?php echo $suffix; ?></<?php echo $acf_tag ?>>
                              <?php
                            }
                        }
                      }
                      ?>
                    </div>
                    <?php echo $icon_image_placement_right; ?>
                    <div class="repeater_sep"></div>
                  </div>
                  <?php
                endif;
              }

              ////////////////////////////////////////////////////
              //  link fields
              ////////////////////////////////////////////////////

              else if ($acf_type == "link") {

                if ($link_button == "on") {
                  $link_button_css = "et_pb_button";
                } else {
                  $link_button_css = "";
                }

                if ($acf_get['value']) : ?>

                <?php if ($url_link_icon == 'on') {
                  ?> <a href="<?php echo $acf_get['value']; ?>" <?php echo esc_attr($link_new_tab_dis) ?>> <?php
                }
                ?>

                <div class="dmach-acf-item-container">
                  <?php echo $icon_image_placement_left; ?>
                  <div class="dmach-acf-item-content">
                    <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>

                    <?php if ($return_format  == "array") {
                        $title = '';
                        $url = '';
                        $target = '';
                      if(is_array($acf_get['value'])){
                          $url = $acf_get['value']['url'];
                          $title=$acf_get['value']['title'];
                          $target = $acf_get['value']['target'];
                      }


                      if ($repeater_dyn_btn_acf != "none") {
                        $link_button_text_dis = get_sub_field($repeater_dyn_btn_acf);
                      } else if ($link_button_text !== "") {
                        $link_button_text_dis = $link_button_text;
                      } else if ($link_name_acf == "on" && $link_name_acf_name['value'] !== "none") {
                        $link_name_acf_name_get = get_field_object($link_name_acf_name);
                        $link_button_text_dis = $link_name_acf_name_get['value'];
                      } else {
                        $link_button_text_dis = esc_html($title);
                      }


                      if ($link_button_text_dis == '') {
                        $link_button_text_dis = get_sub_field($link_name_acf_name);
                      }

                      do_action( 'wpml_register_single_string', 'divi-machine', 'ACF custom button Label', $link_button_text_dis );

                      ?>
                      <?php echo $show_label_dis ?>
                      <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo $custom_icon?> href="<?php echo $url; ?>" <?php echo $link_new_tab_dis ?>">
                        <span><?php echo $prefix; ?><?php echo $link_button_text_dis; ?><?php echo $suffix; ?></span>
                      </a>
                      <?php
                    } else {

                      ?>
                      <?php echo $show_label_dis ?>
                  <?php if ($url_link_icon == 'off') {

                    if ($repeater_dyn_btn_acf != "none") {
                      $link_button_text_dis = get_sub_field($repeater_dyn_btn_acf);
                    } else if ($link_button_text !== "") {
                      $link_button_text_dis = $link_button_text;
                    } else if ($link_name_acf == "on" && $link_name_acf_name['value'] !== "none") {
                      $link_name_acf_name_get = get_field_object($link_name_acf_name);
                      $link_button_text_dis = $link_name_acf_name_get['value'];
                    } else {
                      $link_button_text_dis = $acf_get['value'];
                    }


                    if ($link_button_text_dis == '') {
                      $link_button_text_dis = get_sub_field($link_name_acf_name);
                    }


                    do_action( 'wpml_register_single_string', 'divi-machine', 'ACF custom button Label', $link_button_text_dis );


                    ?>
                      <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo $custom_icon?> href="<?php echo $acf_get['value']; ?>" <?php echo $link_new_tab_dis ?>"><?php echo $link_button_text_dis; ?></a>
                    <?php
                  }
                    }
                    ?>
                  </div>
                  <?php echo $icon_image_placement_right; ?>

                  <?php if ($url_link_icon == 'on') {
                  ?> </a> <?php
                  }
                   ?>
                   <div class="repeater_sep"></div>
                </div>
                <?php
              endif;
            }

                   ////////////////////////////////////////////////////
              //  Email or phone fields
              ////////////////////////////////////////////////////

              else if ($acf_type == "email" || $acf_type == "dmachphone") {


                $link_ending = '';

                if ($acf_type == "email") {
                  $linktype = 'mailto';

                  if ($email_subject == 'none') {
                  } else if ($email_subject == 'page_title') {
                    global $wp_query;
                    $post = $wp_query->get_queried_object();
                    $pagename = $post->post_title;
                    $link_ending .= 'subject=' . $pagename . '&';
                  } else if ($email_subject == 'page_url') {
                    $pageurl = get_page_link();
                    $link_ending .= 'subject=' . $pageurl . '&';
                  } if ($email_subject == 'custom_text') {
                    $link_ending .= 'subject=' . $email_subject_custom . '&';
                  }

                  if ($email_body_text !== '') {

                    if ($email_body_after !== 'none') {

                      global $wp_query;
                      $post = $wp_query->get_queried_object();
                      $pagename = $post->post_title;
                      $pageurl = get_page_link();

                      if ($email_body_after == 'page_title') {
                        $email_body_text_cont = $pagename;
                      }

                      if ($email_body_after == 'page_url') {
                        $email_body_text_cont = $pageurl;
                      }

                      if(isset($email_body_text_cont)){
$email_body_text = $email_body_text . $email_body_text_cont;
}
                    }

                    $link_ending .= 'body=' . $email_body_text . '&';

                  }

                  if ($email_custom_parameters !== '') {
                    $link_ending .= $email_custom_parameters;
                  }
                  if ($link_ending !== '') {
                    $link_ending = "?" . $link_ending;
                  }

                  $link_ending = rtrim($link_ending, '&');

                  if ( $acf_get['value'] == 'blank@domain.com') {
                    $email_phone_val = '';
                  } else {
                    $email_phone_val = $acf_get['value'];
                  }

                } else {
                  $linktype = 'tel';
                  $email_phone_val = $acf_get['value'];
                }

                if ($link_button == "on") {
                  $link_button_css = "et_pb_button";
                } else {
                  $link_button_css = "";
                }

                if ($acf_get['value']) : ?>
                <?php if ($url_link_icon == 'on') {
                  ?> <a href="<?php echo $linktype ?>:<?php echo $email_phone_val; ?><?php echo $link_ending ?>" <?php echo esc_attr($link_new_tab_dis) ?>> <?php
                }
                ?>

                <div class="dmach-acf-item-container">
                <?php echo $icon_image_placement_left; ?>
                <div class="dmach-acf-item-content">
                <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                <?php echo $show_label_dis ?>
                <?php if ($url_link_icon == 'off') {
                  if ($repeater_dyn_btn_acf != "none") {
                    $link_button_text_dis = get_sub_field($repeater_dyn_btn_acf);
                  } else if ($link_button_text !== "") {
                    $link_button_text_dis = $link_button_text;
                  } else {
                    $link_button_text_dis = $acf_get['value'];
                  }

                  do_action( 'wpml_register_single_string', 'divi-machine', 'ACF custom button Label', $link_button_text_dis );

                  ?>
                  <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo $custom_icon?> href="<?php echo $linktype ?>:<?php echo $email_phone_val; ?><?php echo $link_ending ?>" <?php echo $link_new_tab_dis;?>><?php echo $link_button_text_dis; ?></a>
                  <?php
                  }
                  ?>
                  </div>
                  <?php echo $icon_image_placement_right; ?>

                  <?php if ($url_link_icon == 'on') {
                  ?> </a> <?php
                  }
                   ?>
                   <div class="repeater_sep"></div>
                </div>
                <?php
              endif;
            }

            ////////////////////////////////////////////////////
            //  URL fields
            ////////////////////////////////////////////////////

            else if ($acf_type == "url") {


              if ($link_button == "on") {
                $link_button_css = "et_pb_button";
              } else {
                $link_button_css = "";
              }

              $link_name_acf_name_get = get_field_object($link_name_acf_name);

              if ($repeater_dyn_btn_acf != "none") {
                $link_button_text_dis = get_sub_field($repeater_dyn_btn_acf);
              } else if ($link_button_text !== "") {
                $link_button_text_dis = $link_button_text;
              }  else if ($link_name_acf == "on" && $link_name_acf_name_get['value'] !== "none") {
                $link_button_text_dis = $link_name_acf_name_get['value'];
              } else {
                $link_button_text_dis = $acf_get['value'];
              }


              if ($link_button_text_dis == '') {
                $link_button_text_dis = get_sub_field($link_name_acf_name);
              }

                      do_action( 'wpml_register_single_string', 'divi-machine', 'ACF custom button Label', $link_button_text_dis );

              if ($acf_get['value']) : ?>
              <div class="dmach-acf-item-container">

                <?php if ($url_link_icon == 'on') {
                  ?> <a class="dmach-acf-item-container" href="<?php echo $acf_get['value']; ?>" <?php echo $link_new_tab_dis ?>> <?php
                }
                ?>
                <?php echo $icon_image_placement_left; ?>
                <div class="dmach-acf-item-content">
                  <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                  <?php echo $show_label_dis ?>
                  <?php if ($url_link_icon == 'off') {
                    ?>
                    <a class="dmach-acf-value <?php echo $link_button_css ?>" <?php echo $custom_icon?> href="<?php echo $acf_get['value']; ?>" <?php echo $link_new_tab_dis ?>><?php echo $link_button_text_dis; ?></a>
                    <?php
                  }
                  ?>
                </div>
                <?php echo $icon_image_placement_right; ?>
                <?php if ($url_link_icon == 'on') {
                  ?> </a> <?php
                }
                ?>
                <div class="repeater_sep"></div>
              </div>
              <?php
            endif;
          }
          ////////////////////////////////////////////////////
          //  post_object fields
          ////////////////////////////////////////////////////

          else if ($acf_type == "post_object") {

            $item_value = $acf_get['value'];

            ?>
            <div class="dmach-acf-item-container">
              <?php echo $icon_image_placement_left; ?>
              <div class="dmach-acf-item-content">
                <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>

                <div class="dmach-acf-value">
                <?php echo $show_label_dis ?>
                  <?php if (is_array($item_value)) {

                     $item_value_arr = array();
                     foreach ($item_value as $item) {
                     $item_value_arr[] = $item->ID;
                     $post_type = $acf_get['post_type'][0];
                     }

                  } else {

                    $item_value_arr = array( $item_value->ID );
                    $post_type = $acf_get['post_type'][0];

                  }

                  $args_postobject = array(
                    'post_type'         => $post_type ?? '',
                    'post_status' => 'publish',
                    'posts_per_page' => '-1',
                    'post__in'       => $item_value_arr,
                    'orderby' => 'post__in'
                  );


                  if ($linked_post_style == 'custom') {
                    ?>
                    <div class="repeater-cont grid col-desk-<?php echo $columns ?> col-tab-<?php echo $columns_tablet ?> col-mob-<?php echo $columns_mobile ?>">
                      <div class="grid-posts acf-loop-grid">
                      <?php
                  }

                        $new_query = new WP_Query( $args_postobject );
                        if ( $new_query->have_posts() ) {
                          $post_counter = 0;
                          while ( $new_query->have_posts() ) {
                            $new_query->the_post();
                            $post_counter++;
                            $post_count = $new_query->post_count;

                            if ($linked_post_style == 'custom') {
                            ?>
                            <div class="grid-col">
                            <div class="grid-item-cont">
                            <?php
                  echo do_shortcode(get_post_field('post_content', $loop_layout));
                            //echo apply_filters('the_content', get_post_field('post_content', $loop_layout));
                            ?>
                            </div>
                            </div>
                            <?php
                            } else {
                              $url = get_permalink( get_the_ID() );
                              ?>
                              <span class="linked_list_item">
                                <a href="<?php echo esc_html($url)?>"><?php echo esc_html(get_the_title()) ?></a><?php if ( $post_counter == $post_count ) { } else { echo '<span class="dmach-seperator">' . esc_html($link_post_seperator) . '</span>';}
                                ?>
                              </span>
                              <?php
                            }
                            }
                          }
                          //wp_reset_query();
                          wp_reset_postdata();
                          ?>
                          <?php
                          if ($linked_post_style == 'custom') {
                            ?>
                            </div>
                            </div>
                            <?php
                          }
                        ?>
                  </div>
              </div>

            <?php echo $icon_image_placement_right; ?>
            <div class="repeater_sep"></div>
          </div>
          <?php


        } else if ( $acf_type == 'google_map' ) {
          $item_value = '';
          if ( !empty( $acf_get['value'] ) ) {
            $item_value = $acf_get['value']['address'];
          }
          ?>
                <div class="dmach-acf-item-container">
                  <?php echo $icon_image_placement_left; ?>
                  <div class="dmach-acf-item-content">
                    <?php if ($text_before != "") { ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php } ?>
                    <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?><?php echo $prefix; ?><?php echo $item_value; ?><?php echo $suffix; ?></<?php echo $acf_tag ?>>
                  </div>
                  <?php echo $icon_image_placement_right; ?>
                  <div class="repeater_sep"></div>
                </div>
          <?php
        } else {

        }
	      }
} else {
  $num = mt_rand(100000,999999);
  $css_class              = $render_slug . "_" . $num;
  if ($empty_value_option == "hide_module") {
  $this->add_classname("hidethis");
  } else if ($empty_value_option != "custom_text") {
    $this->add_classname("hidethis");
    $target = "";
    if ( $empty_value_option == "hide_element" ) {
      $target = ' data-hide_target="' . esc_html($empty_value_option_element) . '"';
    }
?>
      <span id="<?php echo esc_html($css_class) ?>" data-hide_option="<?php echo $empty_value_option;?>" <?php echo $target;?> class="hidethis"></span>
<?php 
  } else if ($empty_value_option == "custom_text") {


    if ($use_icon == "on") {
      $icon_image_dis = '<div class="dmach-icon-image-content"><span class="dmach-icon"></span></div>';
    } else {
      if ($image == "") {
        $icon_image_dis = "";
      } else {
        $icon_image_dis = '<div class="dmach-icon-image-content"><img src="' . $image . '"></div>';
      }
    }

    if ($icon_image_placement == "top" || $icon_image_placement == "left") {
      $icon_image_placement_left = $icon_image_dis;
      $icon_image_placement_right = "";
    } else {
      $icon_image_placement_left = "";
      $icon_image_placement_right = $icon_image_dis;
    }
    
    if ( $show_label == 'on' ) {
      $show_label_dis =  $custom_label . $label_seperator;  
    } else {
      $show_label_dis = '';
    }
    
    
    ?>
    <div class="dmach-acf-item-container">
      <?php echo $icon_image_placement_left; ?>
      <div class="dmach-acf-item-content">
        <?php if ($text_before != "") { 
          ?><p class="dmach-acf-before"><?php echo $text_before ?></p><?php 
          } ?>
    
          <<?php echo $acf_tag ?> class="dmach-acf-value"><?php echo $show_label_dis ?><span class="acf_prefix"><?php echo $prefix; ?></span><?php echo $empty_value_option_custom_text; ?><span class="acf_suffix"><?php echo $suffix; ?></span></<?php echo $acf_tag ?>>
         
    
      </div>
      <?php echo $icon_image_placement_right; ?>
      <div class="repeater_sep"></div>
    </div>
    <?php 
  }
}



$data = ob_get_clean();
//////////////////////////////////////////////////////////////////////


return $data;


}
}

new de_mach_acf_item_code;

?>