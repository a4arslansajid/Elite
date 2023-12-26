<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_repeater_code extends ET_Builder_Module {

  public $vb_support = 'on';

  protected $module_credits = array(
    'module_uri' => DE_DMACH_PRODUCT_URL,
    'author'     => DE_DMACH_AUTHOR,
    'author_uri' => DE_DMACH_URL,
  );

  function init() {
    $this->name       = esc_html__( 'Repeater/Table/Tabs - Divi Machine', 'divi-machine' );
    $this->slug = 'et_pb_de_mach_repeater';
    $this->vb_support      = 'on';
    $this->child_slug      = 'et_pb_de_mach_acf_item';
    $this->child_item_text = esc_html__( 'ACF Item', 'divi-machine' );
    $this->folder_name = 'divi_machine';


    $this->fields_defaults = array(
      // 'loop_layout'         => array( 'on' ),
    );

    $this->settings_modal_toggles = array(
      'general' => array(
        'toggles' => array(
          'main_content' => esc_html__( 'Main Options', 'divi-machine' ),
          'table' => esc_html__( 'Table Settings', 'divi-machine' ),
          'loop_layout' => esc_html__( 'Loop Layout Settings', 'divi-machine' ),
          'tabs' => esc_html__( 'Tabs/Accordion Settings', 'divi-machine' ),
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
        'title' => array(
          'label'    => esc_html__( 'Item', 'divi-machine' ),
          'css'      => array(
            'main' => "%%order_class%% ul.products li.product .woocommerce-loop-product__title",
            'important' => 'plugin_only',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
        ),
        'table_header' => array(
          'label'    => esc_html__( 'Table Header', 'divi-machine' ),
          'css'      => array(
            'main' => "%%order_class%% table.dmach-repeater-table th",
            'important' => 'plugin_only',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
        ),
        'table_text' => array(
          'label'    => esc_html__( 'Table Body', 'divi-machine' ),
          'css'      => array(
            'main' => "%%order_class%% table.dmach-repeater-table tr, %%order_class%% table.dmach-repeater-table td",
            'important' => 'plugin_only',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
        ),
        'table_odd_text' => array(
          'label'    => esc_html__( 'Table Body Odd', 'divi-machine' ),
          'css'      => array(
            'main' => "%%order_class%% table.dmach-repeater-table tr:nth-of-type(odd)",
            'important' => 'plugin_only',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
        ),
				'tab'  => array(
					'label'            => esc_html__( 'Tab', 'divi-machine' ),
					'css'              => array(
						'main'        => "{$this->main_css_element} .et_pb_tabs_controls li, {$this->main_css_element} .et_pb_tabs_controls li a",
						'color'       => "{$this->main_css_element} .et_pb_tabs_controls li a",
						'hover'       => "{$this->main_css_element} .et_pb_tabs_controls li:hover, {$this->main_css_element} .et_pb_tabs_controls li:hover a",
						'color_hover' => "{$this->main_css_element} .et_pb_tabs_controls li:hover a",
					),
					'hide_text_align'  => true,
					'options_priority' => array(
						'tab_text_color' => 9,
					),
        ),
        'toggle'        => array(
					'label'            => esc_html__( 'Accordion Title' ),
					'css'              => array(
						'main'      => "{$this->main_css_element} h5.et_pb_toggle_title, {$this->main_css_element} h1.et_pb_toggle_title, {$this->main_css_element} h2.et_pb_toggle_title, {$this->main_css_element} h3.et_pb_toggle_title, {$this->main_css_element} h4.et_pb_toggle_title, {$this->main_css_element} h6.et_pb_toggle_title",
						'important' => 'plugin_only',
					),
					'header_level'     => array(
						'default' => 'h5',
					),
					'options_priority' => array(
						'toggle_text_color' => 9,
					),
				),
				'closed_toggle' => array(
					'label'           => esc_html__( 'Accordion Closed Title', 'divi-machine' ),
					'css'             => array(
						'main'      => "{$this->main_css_element} .et_pb_toggle_close h5.et_pb_toggle_title, {$this->main_css_element} .et_pb_toggle_close h1.et_pb_toggle_title, {$this->main_css_element} .et_pb_toggle_close h2.et_pb_toggle_title, {$this->main_css_element} .et_pb_toggle_close h3.et_pb_toggle_title, {$this->main_css_element} .et_pb_toggle_close h4.et_pb_toggle_title, {$this->main_css_element} .et_pb_toggle_close h6.et_pb_toggle_title",
						'important' => 'plugin_only',
					),
					'hide_text_color' => true,
					'line_height'     => array(
						'default' => '1.7em',
					),
					'font_size'       => array(
						'default' => '16px',
					),
					'letter_spacing'  => array(
						'default' => '0px',
					),
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
      'borders'               => array(
        'default' => array(
          'css'                 => array(
            'main' => array(
              'border_radii'  => "{$this->main_css_element}",
              'border_styles' => "{$this->main_css_element}",
            ),
          ),
          'defaults' => array(
            'border_radii'  => 'on||||',
            'border_styles' => array(
              'width' => '1px',
              'color' => '#bebebe',
              'style' => 'solid',
            ),
          ),
        ),
      ),
      'box_shadow' => array(
        'default' => array(),
        'product' => array(
          'label' => esc_html__( 'Default Layout - Box Shadow', 'divi-machine' ),
          'css' => array(
            'main' => "%%order_class%%",
          ),
          'option_category' => 'layout',
          'tab_slug'        => 'advanced',
          'toggle_slug'     => 'product',
        ),
      ),
        'margin_padding' => array(
            'css' => array(
                'main'=>'.et_pb_column %%order_class%%',
            ),
        ),
    );




		$this->custom_css_fields = array(
			'tabs_controls' => array(
				'label'    => esc_html__( 'Tabs Controls', 'divi-machine' ),
				'selector' => '.et_pb_tabs_controls',
			),
			'tab'           => array(
				'label'    => esc_html__( 'Tab', 'divi-machine' ),
				'selector' => '.et_pb_tabs_controls li',
			),
			'active_tab'    => array(
				'label'    => esc_html__( 'Active Tab', 'divi-machine' ),
				'selector' => '.et_pb_tabs_controls li.et_pb_tab_active',
			),
			'tabs_content'  => array(
				'label'    => esc_html__( 'Tabs Content', 'divi-machine' ),
				'selector' => '.et_pb_tab',
			),
			'toggle'         => array(
				'label'    => esc_html__( 'Toggle', 'divi-machine' ),
				'selector' => '.et_pb_toggle',
			),
			'open_toggle'    => array(
				'label'    => esc_html__( 'Open Toggle', 'divi-machine' ),
				'selector' => '.et_pb_toggle_open',
			),
			'toggle_title'   => array(
				'label'    => esc_html__( 'Toggle Title', 'divi-machine' ),
				'selector' => '.et_pb_toggle_title',
			),
			'toggle_icon'    => array(
				'label'    => esc_html__( 'Toggle Icon', 'divi-machine' ),
				'selector' => '.et_pb_toggle_title:before',
			),
			'toggle_content' => array(
				'label'    => esc_html__( 'Toggle Content', 'divi-machine' ),
				'selector' => '.et_pb_toggle_content',
			),
		);

    $this->help_videos = array(
    );
  }




  function get_fields() {

    $options = DEDMACH_INIT::get_divi_layouts();

    $acf_fields = DEDMACH_INIT::get_acf_fields();

    $fields = array(
      'repeater_type' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'Repeater Type', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'default'   => 'acf_item',
        'options'           => array(
          'acf_item'  => esc_html__( 'ACF Items', 'divi-machine' ),
          'repeater_field'  => esc_html__( 'ACF Repeater Field Type (ACF Pro)', 'divi-machine' )
        ),
        'affects'         => array(
          'repeater_loop_layout',
          'repeater_name',
          'repeater_field_type',
          'repeater_links_buttons'
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'        => esc_html__( 'How many columns do you want to see', 'divi-machine' ),
      ),
      'acf_item_style' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'ACF Item Repeat Style', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'default'   => 'grid',
        'options'           => array(
          'grid'  => esc_html__( 'Grid', 'divi-machine' ),
          'list'  => esc_html__( 'List', 'divi-machine' ),
        ),
        'show_if'      => array(
            'repeater_type' => ['acf_item']
        ),
        'description'        => esc_html__( 'Choose how you want the ACF Items to be repeated, grid or maybe you want it comma-seperated', 'divi-machine' ),
      ),
      'acf_repeater_seperator' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'List Seperator', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'default'   => ', ',
        'show_if'           => array(
            'repeater_type' => 'acf_item',
            'acf_item_style' => 'list'
        ),
        'description'        => esc_html__( 'Choose how you want the list to be seperated with', 'divi-machine' ),
      ),      
      'acf_list_space_left' => array(
        'label'           => esc_html__( 'Space left of seperator', 'divi-machine' ),
        'type'            => 'range',
        'option_category'   => 'configuration',
        'toggle_slug'       => 'main_content',
        'default'         => '0px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'allowed_units'   => array( ' ' ),
        'range_settings' => array(
          'min'  => '1',
          'max'  => '50',
          'step' => '1',
        ),
        'show_if'           => array(
            'repeater_type' => 'acf_item',
            'acf_item_style' => 'list'
        ),
      ),
      'acf_list_space_right' => array(
        'label'           => esc_html__( 'Space right of seperator', 'divi-machine' ),
        'type'            => 'range',
        'option_category'   => 'configuration',
        'toggle_slug'       => 'main_content',
        'default'         => '3px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'allowed_units'   => array( ' ' ),
        'range_settings' => array(
          'min'  => '1',
          'max'  => '50',
          'step' => '1',
        ),
        'show_if'           => array(
            'repeater_type' => 'acf_item',
            'acf_item_style' => 'list'
        ),
      ),


      'repeater_name' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'Repeater Name', 'divi-machine' ),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'depends_show_if' => 'repeater_field',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Add the name of your repeater field', 'divi-machine' ),
      ),


      'repeater_field_type' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'Repeater Field Style', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'depends_show_if' => 'repeater_field',
        'default'   => 'repeater_loop_layout_custom',
        'options'           => array(
          'repeater_loop_layout_custom'  => esc_html__( 'Loop Layout', 'divi-machine' ),
          'table'  => esc_html__( 'Table (basic fields only)', 'divi-machine' ),
          'tabs'  => esc_html__( 'Tabs', 'divi-machine' ),
          'accordion'  => esc_html__( 'Accordion', 'divi-machine' ),
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'        => esc_html__( 'If you want complete control, select custom loop layout. Otherwise select one of our premade repeater styles', 'divi-machine' ),
      ),
      'repeater_links_buttons' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'Make Links/Files as buttons', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if' => 'repeater_field',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'           => 'off',
        'description'       => esc_html__( 'Enable this to make all the links and files as buttons in the table - we will get the name of the file or name of the link as the text for the button.', 'divi-machine' ),
      ),


      'repeater_loop_layout' => array(
        'toggle_slug'       => 'loop_layout',
        'label'             => esc_html__( 'Repeater Loop Layout', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'default'           => 'none',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'repeater_loop_layout_custom'
        ),
        'options'           => $options,
        'description'        => esc_html__( 'Choose the layout you have made for each repeater in the loop.', 'divi-machine' ),
      ),
      'columns' => array(
        'toggle_slug'       => 'grid_options',
        'label'             => esc_html__( 'Grid Columns', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'layout',
        'default'   => '4',
        'options'           => array(
          '1'  => esc_html__( 'One', 'divi-machine' ),
          '2'  => esc_html__( 'Two', 'divi-machine' ),
          '3' => esc_html__( 'Three', 'divi-machine' ),
          '4' => esc_html__( 'Four', 'divi-machine' ),
          '5' => esc_html__( 'Five', 'divi-machine' ),
          '6' => esc_html__( 'Six', 'divi-machine' ),
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'        => esc_html__( 'How many columns do you want to see', 'divi-machine' ),
      ),
      'columns_tablet' => array(
        'toggle_slug'       => 'grid_options',
        'label'             => esc_html__( 'Tablet Grid Columns', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'layout',
        'default'   => '2',
        'options'           => array(
          '1'  => esc_html__( 'One', 'divi-machine' ),
          '2'  => esc_html__( 'Two', 'divi-machine' ),
          '3' => esc_html__( 'Three', 'divi-machine' ),
          '4' => esc_html__( 'Four', 'divi-machine' ),
          '5' => esc_html__( 'Five', 'divi-machine' ),
          '6' => esc_html__( 'Six', 'divi-machine' ),
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'        => esc_html__( 'How many columns do you want to see on tablet', 'divi-machine' ),
      ),
      'columns_mobile' => array(
        'toggle_slug'       => 'grid_options',
        'label'             => esc_html__( 'Mobile Grid Columns', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'layout',
        'default'   => '1',
        'options'           => array(
          '1'  => esc_html__( 'One', 'divi-machine' ),
          '2'  => esc_html__( 'Two', 'divi-machine' ),
          '3' => esc_html__( 'Three', 'divi-machine' ),
          '4' => esc_html__( 'Four', 'divi-machine' ),
          '5' => esc_html__( 'Five', 'divi-machine' ),
          '6' => esc_html__( 'Six', 'divi-machine' ),
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
        'description'        => esc_html__( 'How many columns do you want to see on mobile', 'divi-machine' ),
      ),
      'custom_gutter_repeater' => array(
        'label'           => esc_html__( 'Custom Gutter Width', 'divi-machine' ),
        'type'            => 'range',
        'option_category' => 'layout',
        'toggle_slug'     => 'grid_options',
        'default'         => '3',
        'default_unit'    => ' ',
        'default_on_front'=> '',
        'allowed_units'   => array( ' ' ),
        'range_settings' => array(
          'min'  => '1',
          'max'  => '4',
          'step' => '1',
        ),
        'computed_affects' => array(
          '__getacfitem',
        ),
      ),
      'grid_gap' => array(
        'label'           => esc_html__( 'Grid Gap', 'divi-machine' ),
        'type'            => 'range',
        'option_category' => 'layout',
        'toggle_slug'     => 'grid_options',
        'default'         => '25px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'allowed_units'   => array( ' ' ),
      ),


      
      'tabs_header_text' => array(
        'toggle_slug'       => 'tabs',
        'label'             => esc_html__( 'Tabs/Accordion Header Text', 'divi-machine' ),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => ['tabs', 'accordion']
        ),
        'depends_show_if' => 'repeater_field',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'If you are using this repeater module to make tabs, choose the repeater field that will be the title.', 'divi-machine' ),
      ),
      'tabs_loop_layout' => array(
        'toggle_slug'       => 'tabs',
        'label'             => esc_html__( 'Tabs/Accordion Body (loop layout)', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'default'           => 'none',
        'computed_affects' => array(
          '__getacfitem',
        ),
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => ['tabs', 'accordion']
        ),
        'depends_show_if' => 'repeater_field',
        'options'           => $options,
        'description'        => esc_html__( 'Choose the layout to show for each tabs body.', 'divi-machine' ),
      ),


      'table_header_background' => array(
        'label'          => esc_html__( 'Table header background color', 'divi-machine' ),
        'description'    => esc_html__( 'Choose the color you want for the heading background of your table.', 'divi-machine' ),
        'type'           => 'color-alpha',
        'custom_color'   => true,
        'tab_slug'       => 'advanced',
        'toggle_slug'    => 'table',
        'priority'       => 20,
        'default'        => '#000',
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'table'
        ),
      ),
      'zebra_bg_color' => array(
        'label'          => esc_html__( 'Table odd row background color', 'divi-machine' ),
        'description'    => esc_html__( 'Choose the background you want to be shown for each odd row.', 'divi-machine' ),
        'type'           => 'color-alpha',
        'custom_color'   => true,
        'tab_slug'       => 'advanced',
        'toggle_slug'    => 'table',
        'priority'       => 20,
        'default'        => '#eee',
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'table'
        ),
      ),
      'table_border_color' => array(
        'label'          => esc_html__( 'Table border color', 'divi-machine' ),
        'description'    => esc_html__( 'Choose the border color.', 'divi-machine' ),
        'type'           => 'color-alpha',
        'custom_color'   => true,
        'tab_slug'       => 'advanced',
        'toggle_slug'    => 'table',
        'priority'       => 20,
        'default'        => '#ccc',
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'table'
        ),
      ),


			'active_tab_background_color'   => array(
				'label'          => esc_html__( 'Active Tab Background Color', 'divi-machine' ),
				'description'    => esc_html__( 'Pick a color to be used for active tab backgrounds. You can assign a unique color to active tabs to differentiate them from inactive tabs.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tab',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'tabs'
        ),
			),
			'inactive_tab_background_color' => array(
				'label'          => esc_html__( 'Inactive Tab Background Color', 'divi-machine' ),
				'description'    => esc_html__( 'Pick a color to be used for inactive tab backgrounds. You can assign a unique color to inactive tabs to differentiate them from active tabs.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tab',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'tabs'
        ),
			),
			'active_tab_text_color'         => array(
				'label'          => esc_html__( 'Active Tab Text Color', 'divi-machine' ),
				'description'    => esc_html__( 'Pick a color to use for tab text within active tabs. You can assign a unique color to active tabs to differentiate them from inactive tabs.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tab',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'tabs'
        ),
      ),
      


      'open_toggle_text_color'         => array(
				'label'          => esc_html__( 'Accordion Open Title Text Color', 'divi-machine' ),
				'description'    => esc_html__( 'You can pick unique text colors for toggle titles when they are open and closed. Choose the open state title color here.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'toggle',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'accordion'
        ),
			),
			'open_toggle_background_color'   => array(
				'label'          => esc_html__( 'Accordion Open Toggle Background Color', 'divi-machine' ),
				'description'    => esc_html__( 'You can pick unique background colors for toggles when they are in their open and closed states. Choose the open state background color here.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'toggle_layout',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'accordion'
        ),
			),
			'closed_toggle_text_color'       => array(
				'label'          => esc_html__( 'Accordion Closed Title Text Color', 'divi-machine' ),
				'description'    => esc_html__( 'You can pick unique text colors for toggle titles when they are open and closed. Choose the closed state title color here.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'closed_toggle',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'accordion'
        ),
			),
			'closed_toggle_background_color' => array(
				'label'          => esc_html__( 'Accordion Closed Toggle Background Color', 'divi-machine' ),
				'description'    => esc_html__( 'You can pick unique background colors for toggles when they are in their open and closed states. Choose the closed state background color here.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'toggle_layout',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'accordion'
        ),
			),
			'icon_color'                     => array(
				'label'          => esc_html__( 'Accordion Icon Color', 'divi-machine' ),
				'description'    => esc_html__( 'Here you can define a custom color for the toggle icon.', 'divi-machine' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'icon',
				'hover'          => 'tabs',
				'mobile_options' => true,
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'accordion'
        ),
			),
			'use_icon_font_size'             => array(
				'label'            => esc_html__( 'Accordion Use Icon Font Size', 'divi-machine' ),
				'description'      => esc_html__( 'If you would like to control the size of the icon, you must first enable this option.', 'divi-machine' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__( 'No' ),
					'on'  => esc_html__( 'Yes' ),
				),
				'default_on_front' => 'off',
        'show_if'           => array(
            'repeater_type' => 'repeater_field',
            'repeater_field_type' => 'accordion'
        ),
				'affects'          => array(
					'icon_font_size',
				),
				'depends_show_if'  => 'on',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'icon',
				'option_category'  => 'font_option',
			),
			'icon_font_size'                 => array(
				'label'            => esc_html__( 'Accordion Icon Font Size', 'divi-machine' ),
				'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'divi-machine' ),
				'type'             => 'range',
				'option_category'  => 'font_option',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'icon',
				'default'          => '16px',
				'default_unit'     => 'px',
				'default_on_front' => '',
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'   => true,
				'depends_show_if'  => 'on',
				'hover'            => 'tabs',
			),


      '_getrepeater'  => array(
        'type' => 'computed',
        'computed_callback' => array( 'de_mach_repeater_code', 'get_repeated_content' ),
        'computed_depends_on' => array(
          'columns',
          'columns_tablet',
          'columns_mobile',
          'custom_gutter_repeater'
        ),
      ),
    );

    return $fields;
  }

  public static function get_repeated_content( $args = array(), $conditional_tags = array(), $current_page = array() ){
    ob_start();


    $data = ob_get_clean();
    return $data;
  }

  public function get_repeater_items_content() {
    return $this->content;
  }



  function render($attrs, $content, $render_slug){
    
    // if (is_admin()) {
    //     return;
    // }
    
    /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-machine' );*/
    $enable_debug = de_get_option_value('divi-machine', 'enable_debug'); //$titan->getOption( 'enable_debug' );

    $columns      = $this->props['columns'];
    $columns_tablet      = $this->props['columns_tablet'];
    $columns_mobile      = $this->props['columns_mobile'];
    $custom_gutter_repeater      = $this->props['custom_gutter_repeater'];

    $repeater_type            = $this->props['repeater_type'];
    $repeater_name            = $this->props['repeater_name'];
    $repeater_loop_layout            = $this->props['repeater_loop_layout'];
    $repeater_field_type            = $this->props['repeater_field_type'];
    $repeater_links_buttons            = $this->props['repeater_links_buttons'];
    

    
    $acf_item_style            = $this->props['acf_item_style'];
    $acf_repeater_seperator            = $this->props['acf_repeater_seperator'];
    $acf_list_space_left            = $this->props['acf_list_space_left'] ?: '0px';
    $acf_list_space_right            = $this->props['acf_list_space_right'] ?: '3px';
    
    $all_repeater_content = $this->get_repeater_items_content();

    $table_header_background            = $this->props['table_header_background'];
    $zebra_bg_color            = $this->props['zebra_bg_color'];
    $table_border_color            = $this->props['table_border_color'];


    $tabs_header_text            = $this->props['tabs_header_text'];
    $tabs_loop_layout            = $this->props['tabs_loop_layout'];

    $grid_gap            = $this->props['grid_gap'];
    
    $custom_icon              = $this->props['button_icon'];
    $button_custom            = $this->props['custom_button'];
    $button_bg_color          = $this->props['button_bg_color'];
    $button_bg_hover_color          = isset($this->props['button_bg_color__hover'])?$this->props['button_bg_color__hover']:'';

    if( $custom_icon != '' ){
        
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
    } else {
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
      'selector'    => 'body #page-container %%order_class%% .et_pb_button',
      'declaration' => "display: inline-block;",
    ) );
    

    $active_tab_background_color_hover    = $this->get_hover_value( 'active_tab_background_color' );
		$active_tab_background_color_values   = et_pb_responsive_options()->get_property_values( $this->props, 'active_tab_background_color' );
		$inactive_tab_background_color_hover  = $this->get_hover_value( 'inactive_tab_background_color' );
		$inactive_tab_background_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'inactive_tab_background_color' );
		$active_tab_text_color_hover          = $this->get_hover_value( 'active_tab_text_color' );
		$active_tab_text_color_values         = et_pb_responsive_options()->get_property_values( $this->props, 'active_tab_text_color' );
    

    // Inactive Tab Background Color.
		et_pb_responsive_options()->generate_responsive_css( $inactive_tab_background_color_values, '%%order_class%% .et_pb_tabs_controls li', 'background-color', $render_slug, '', 'color' );

		if ( et_builder_is_hover_enabled( 'inactive_tab_background_color', $this->props ) ) {
			$el_style = array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li:hover',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $inactive_tab_background_color_hover )
				),
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );
		}

		// Active Tab Background Color.
		et_pb_responsive_options()->generate_responsive_css( $active_tab_background_color_values, '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active', 'background-color', $render_slug, '', 'color' );

		if ( et_builder_is_hover_enabled( 'active_tab_background_color', $this->props ) ) {
			$el_style = array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active:hover',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $active_tab_background_color_hover )
				),
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );
		}

		// Active Text Color
		et_pb_responsive_options()->generate_responsive_css( $active_tab_text_color_values, '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active a', 'color', $render_slug, ' !important;', 'color' );

		if ( et_builder_is_hover_enabled( 'active_tab_text_color', $this->props ) ) {
			$el_style = array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active:hover a',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $active_tab_text_color_hover )
				),
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );
    }
    

    $grid_gap_style = array(
      'selector'    => '%%order_class%% .grid-posts',
				'declaration' => sprintf(
					'grid-gap: %1$s !important;',
        esc_html( $grid_gap )
      ),
    );
    ET_Builder_Element::set_style( $render_slug, $grid_gap_style );



    $open_toggle_background_color_values   = et_pb_responsive_options()->get_property_values( $this->props, 'open_toggle_background_color' );
		$open_toggle_background_color_hover    = $this->get_hover_value( 'open_toggle_background_color' );
		$closed_toggle_background_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'closed_toggle_background_color' );
		$closed_toggle_background_color_hover  = $this->get_hover_value( 'closed_toggle_background_color' );
		$icon_color_values                     = et_pb_responsive_options()->get_property_values( $this->props, 'icon_color' );
		$icon_color_hover                      = $this->get_hover_value( 'icon_color' );
		$use_icon_font_size                    = $this->props['use_icon_font_size'];
		$icon_font_size_values                 = et_pb_responsive_options()->get_property_values( $this->props, 'icon_font_size' );
		$icon_font_size_any_values             = et_pb_responsive_options()->get_property_values( $this->props, 'icon_font_size', '16px', true ); // 16px is default toggle icon size.
		$icon_font_size_hover                  = $this->get_hover_value( 'icon_font_size' );
		$closed_toggle_text_color_values       = et_pb_responsive_options()->get_property_values( $this->props, 'closed_toggle_text_color' );
		$closed_toggle_text_color_hover        = $this->get_hover_value( 'closed_toggle_text_color' );
		$open_toggle_text_color_values         = et_pb_responsive_options()->get_property_values( $this->props, 'open_toggle_text_color' );
		$open_toggle_text_color_hover          = $this->get_hover_value( 'open_toggle_text_color' );
    

    	// Open Toggle Background Color.
		et_pb_responsive_options()->generate_responsive_css( $open_toggle_background_color_values, '%%order_class%% .et_pb_toggle_open', 'background-color', $render_slug, '', 'color' );

		if ( et_builder_is_hover_enabled( 'open_toggle_background_color', $this->props ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%%:hover .et_pb_toggle_open',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $open_toggle_background_color_hover )
					),
				)
			);
		}

		// Closed Toggle Background Color.
		et_pb_responsive_options()->generate_responsive_css( $closed_toggle_background_color_values, '%%order_class%% .et_pb_toggle_close', 'background-color', $render_slug, '', 'color' );

		if ( et_builder_is_hover_enabled( 'closed_toggle_background_color', $this->props ) ) {
			$el_style = array(
				'selector'    => '%%order_class%%:hover .et_pb_toggle_close',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $closed_toggle_background_color_hover )
				),
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );
		}

		// Open Toggle Text Color.
		et_pb_responsive_options()->generate_responsive_css(
			$open_toggle_text_color_values,
			'%%order_class%%.et_pb_accordion .et_pb_toggle_open h5.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_open h1.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_open h2.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_open h3.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_open h4.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_open h6.et_pb_toggle_title',
			'color',
			$render_slug,
			' !important;',
			'color'
		);

		if ( et_builder_is_hover_enabled( 'open_toggle_text_color', $this->props ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%%:hover .et_pb_toggle_open h5.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_open h1.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_open h2.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_open h3.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_open h4.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_open h6.et_pb_toggle_title',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $open_toggle_text_color_hover )
					),
				)
			);
		}

		// Closed Toggle Text Color.
		et_pb_responsive_options()->generate_responsive_css(
			$closed_toggle_text_color_values,
			'%%order_class%%.et_pb_accordion .et_pb_toggle_close h5.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_close h1.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_close h2.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_close h3.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_close h4.et_pb_toggle_title, %%order_class%%.et_pb_accordion .et_pb_toggle_close h6.et_pb_toggle_title',
			'color',
			$render_slug,
			' !important;',
			'color'
		);

		if ( et_builder_is_hover_enabled( 'closed_toggle_text_color', $this->props ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%%:hover .et_pb_toggle_close h5.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_close h1.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_close h2.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_close h3.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_close h4.et_pb_toggle_title, %%order_class%%:hover .et_pb_toggle_close h6.et_pb_toggle_title',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $closed_toggle_text_color_hover )
					),
				)
			);
		}

		// Icon Size.
		if ( 'off' !== $use_icon_font_size ) {
			et_pb_responsive_options()->generate_responsive_css( $icon_font_size_values, '%%order_class%% .et_pb_toggle_title:before', 'font-size', $render_slug );

			// Calculate right position.
			$is_icon_font_size_responsive = et_pb_responsive_options()->is_responsive_enabled( $this->props, 'icon_font_size' );
			$icon_font_size_default       = '16px';  // Default toggle icon size.
			$icon_font_size_right_values  = array();

			foreach ( $icon_font_size_values as $device => $value ) {
				$icon_font_size_active = isset( $icon_font_size_any_values[ $device ] ) ? $icon_font_size_any_values[ $device ] : 0;
				if ( ! empty( $icon_font_size_active ) && $icon_font_size_active !== $icon_font_size_default ) {
					$icon_font_size_active_int  = (int) $icon_font_size_active;
					$icon_font_size_active_unit = str_replace( $icon_font_size_active_int, '', $icon_font_size_active );
					$icon_font_size_active_diff = (int) $icon_font_size_default - $icon_font_size_active_int;
					if ( 0 !== $icon_font_size_active_diff ) {
						// 2 is representation of left & right sides.
						$icon_font_size_right_values[ $device ] = round( $icon_font_size_active_diff / 2 ) . $icon_font_size_active_unit;
					}
				}
			}

			et_pb_responsive_options()->generate_responsive_css( $icon_font_size_right_values, '%%order_class%% .et_pb_toggle_title:before', 'right', $render_slug );

			if ( et_builder_is_hover_enabled( 'icon_font_size', $this->props ) && '' !== $icon_font_size_hover ) {
				if ( ! empty( $icon_font_size_hover ) && $icon_font_size_hover !== $icon_font_size_default ) {
					$icon_font_size_hover_int  = (int) $icon_font_size_hover;
					$icon_font_size_hover_unit = str_replace( $icon_font_size_hover_int, '', $icon_font_size_hover );
					$icon_font_size_hover_diff = (int) $icon_font_size_default - $icon_font_size_hover_int;
					if ( 0 !== $icon_font_size_hover_diff ) {
						// 2 is representation of left & right sides.
						$icon_font_size_right_hover = round( $icon_font_size_hover_diff / 2 ) . $icon_font_size_hover_unit;
						$el_style                      = array(
							'selector'    => '%%order_class%% .et_pb_toggle_title:hover:before',
							'declaration' => sprintf(
								'right:%1$s;',
								esc_html( $icon_font_size_right_hover )
							),
						);
						ET_Builder_Element::set_style( $render_slug, $el_style );
					}
				}

				// Hover Icon Size.
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .et_pb_toggle_title:hover:before',
						'declaration' => sprintf(
							'font-size:%1$s;',
							esc_html( $icon_font_size_hover )
						),
					)
				);
			}
		}

		// Icon Color.
		et_pb_responsive_options()->generate_responsive_css( $icon_color_values, '%%order_class%% .et_pb_toggle_title:before', 'color', $render_slug, '', 'color', ET_Builder_Element::DEFAULT_PRIORITY );

		if ( et_builder_is_hover_enabled( 'icon_color', $this->props ) ) {
			$el_style = array(
				'selector'    => '%%order_class%% .et_pb_toggle_title:hover:before',
				'priority'    => ET_Builder_Element::DEFAULT_PRIORITY,
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $icon_color_hover )
				),
			);
			ET_Builder_Element::set_style( $render_slug, $el_style );
		}

    if ( $repeater_type == "repeater_field" &&  $repeater_field_type == "table") {

      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% table.dmach-repeater-table th',
        'declaration' => sprintf(
          'background-color: %1$s !important;',
          esc_html( $table_header_background )
        ),
      ) );

      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% table.dmach-repeater-table tr:nth-of-type(odd)',
        'declaration' => sprintf(
          'background-color: %1$s !important;',
          esc_html( $zebra_bg_color )
        ),
      ) );

      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% table.dmach-repeater-table td, %%order_class%% table.dmach-repeater-table th',
        'declaration' => sprintf(
          'border: 1px solid %1$s !important;',
          esc_html( $table_border_color )
        ),
      ) );

    }

    //////////////////////////////////////////////////////////////////////

    ob_start();



    if ($repeater_type == "repeater_field") {



      if ($repeater_field_type == "repeater_loop_layout_custom") {
        ?>
        <div class="et_pb_de_mach_archive_loop et_pb_gutters<?php echo $custom_gutter_repeater ?>">
          <div class="dmach-grid-sizes et_pb_de_mach_archive_loop repeater-cont grid col-desk-<?php echo $columns?> col-tab-<?php echo $columns_tablet?> col-mob-<?php echo $columns_mobile?>">
            <div class="grid-posts">

              <?php
              $user_id = get_current_user_id();

              if( have_rows($repeater_name) ) {
                // loop through the rows of data
                while ( have_rows($repeater_name) ) : the_row();
                ?>
                <div class="dmach-grid-item">
                  <?php
                  
                  //echo apply_filters('the_content', get_post_field('post_content', $repeater_loop_layout));
                  echo do_shortcode( get_post_field('post_content', $repeater_loop_layout) );

                  ?>
                </div>
                <?php

                endwhile;
              } else if ( have_rows($repeater_name,"user_{$user_id}") ) {
                // loop through the rows of data
                while ( have_rows($repeater_name,"user_{$user_id}") ) : the_row();
                ?>
                <div class="dmach-grid-item">
                  <?php
                  
                  //echo apply_filters('the_content', get_post_field('post_content', $repeater_loop_layout));
                  echo do_shortcode( get_post_field('post_content', $repeater_loop_layout) );

                  ?>
                </div>
                <?php

                endwhile;
              }
            ?>
          </div>
        </div>
      </div>
      <?php

    } else if ($repeater_field_type == "table") {

      
      
      $repeater = get_field_object($repeater_name);

      ?>
      <?php if ( have_rows($repeater_name) ) { ?>
      <table class="dmach-repeater-table">
        <thead>
          <tr>
            <?php

            if ($enable_debug == "1") {
            ?>
            <div class="reporting_args hidethis" style="white-space: pre; display: none;">
              <?php  print_r($repeater); ?>
            </div>
            <?php
            }

            if ($repeater) {
              foreach($repeater['sub_fields'] as $row) {
                ?><th><?php echo $row['label'] ?></th><?php
              }
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php

          if ($repeater) {
            $subvalues = array();
            foreach($repeater['sub_fields'] as $row) {
              $subvalues[$row['label']] = $row['key'];
            }

            if ( have_rows($repeater_name) ) {

              while( have_rows($repeater_name) ) {
                the_row();
                ?>
                <tr> 
                  <?php
                  foreach($subvalues as $key => $value) {

                    $acf_get = get_sub_field_object($value);

        
                    $choice_acf_choice_types = "select, checkbox, radio, button_group, true_false";
                    $choice_acf_choice_types_explode = explode(', ', $choice_acf_choice_types);

                    $acf_type = $acf_get['type'];

                    if (in_array($acf_type, $choice_acf_choice_types_explode)) {
                      // IF MULTI SELECT
                      if ( isset($acf_get['multiple']) && $acf_get['multiple'] == "1") {
                        if (is_array($acf_get['value'])) { 
                          $getselected_name = $acf_get['value'];
                          $value = implode(', ',  $getselected_name);
                        }

                      } else {
                        if ($acf_type == "checkbox") {
                          $getselected_name = array();
                          if (is_array($acf_get['value'])) {
                            foreach( $acf_get['value'] as $key => $acf_value ) {
                              $getselected_name[] = $acf_get['choices'][ $acf_value ];
                            }
                          } else {
                            $getselected_name = $acf_get['choices'][ $value ];
                          }
                          $value = implode(', ',  $getselected_name);
                        } else if ($acf_type == "select") {
                          $value = $acf_get['value'];

                          $getselected_name = $acf_get['choices'][ $value ];
                          
                          if ($getselected_name == '') {
                            $getselected_name = $value;
                          }
                        }
                      }
                      
                    } else if ( $acf_type == "link" || $acf_type == "file" ) {
                   
                      if ($repeater_links_buttons == 'on') {
        
                        $link_title = $acf_get['value']['title'];
                        $link_url = $acf_get['value']['url'];

                        $value = '<a class="et_pb_button" '.$custom_icon.' href="'.$link_url.'">'.$link_title.'</a>';
                      } else {
                        $value = $acf_get['value'];
                      }
                    } else if ( $acf_type == "image" ) {
                      if (!is_array($acf_get['value'])) {
                        $value = '<img src="'.$acf_get['value'].'">';
                      } else {
                        $value = '<img src="'.$acf_get['value']['url'].'">';
                      }
                    } else if ( $acf_type == "post_object" ) {
                      if (!is_array($acf_get['value'])) {
                        $value = $acf_get['value']->post_title;
                      } else {
                        $value = $acf_get['value'];
                      }
                    } else {
                      $value = $acf_get['value'];
                    }


                    if (isset($acf_get['prepend'])) {
                    $prepend = $acf_get['prepend'];
                  } else {
                    $prepend = "";
                  }
                  
                  if (isset($acf_get['append'])) {
                    $append = $acf_get['append'];
                  } else {
                    $append = "";
                  }

                    if ($value == "") {
                      $value = $acf_get['default_value'];
                    }
                    ?>
                    <td data-column="<?php echo $key ?>"><span class="table-val-prepend"><?php echo $prepend; ?></span>
                    <?php echo $value; ?>
                    <span class="table-val-append"><?php echo $append; ?></span></td>

                    <?php
                  }
                  ?>
                </tr>
                <?php
              }
            }

          }
          ?>
        </tbody>
      </table>

      <?php } ?>
      <?php
    } else if ($repeater_field_type == "tabs") {
      $repeater = get_field_object($repeater_name);
      
      if ($enable_debug == "1") {
      ?>
      <div class="reporting_args hidethis" style="white-space: pre; display: none;">
        <?php  print_r($repeater); ?>
      </div>
      <?php
      }
      ?>
      
      <?php
      if( have_rows($repeater_name) ) {
        ?>
        <div class="et_pb_module et_pb_tabs">
        <?php 
      }
      ?>
				
          <?php
          if( have_rows($repeater_name) ):
            ?>
				<ul class="et_pb_tabs_controls clearfix">
        <?php
              // loop through the rows of data
              $i = 0;
              while ( have_rows($repeater_name) ) : the_row();
              if ($i == "0") {
                $isactive = "et_pb_tab_active";
              } else {
                $isactive = "";
              }

              $tabs_header_text_get = get_sub_field($tabs_header_text);
         ?>
					<li class="et_pb_tab_<?php echo $i ?> <?php echo $isactive ?>"><a href="#"><?php echo $tabs_header_text_get ?></a></li>
                <?php
                $i++;
              endwhile;
              ?>
				</ul>
        <?php
            endif;
            ?>
            
            <?php
      if( have_rows($repeater_name) ) {
        ?>
				<div class="et_pb_all_tabs">
        <?php 
      }
      ?>
          <?php
          if( have_rows($repeater_name) ):
            $i = 0;
            while ( have_rows($repeater_name) ) : the_row();
            if ($i == "0") {
              $isactive = "et_pb_active_content";
            } else {
              $isactive = "";
            }
            ?>
					<div class="et_pb_tab et_pb_tab_<?php echo $i ?> clearfix <?php echo $isactive ?>">
							<div class="et_pb_tab_content">
              <?php
              echo do_shortcode('[et_pb_section global_module="' . $tabs_loop_layout . '"][/et_pb_section]');
              ?>
              </div>
			    </div> 
          <?php
                $i++;
              endwhile;
            endif;
              ?>

        <?php
      if( have_rows($repeater_name) ) {
        ?>
        </div>
				</div>
        <?php 
      }
      ?> 
      <?php 
      
    } else if ($repeater_field_type == "accordion") {
      $repeater = get_field_object($repeater_name);
      
      if ($enable_debug == "1") {
      ?>
      <div class="reporting_args hidethis" style="white-space: pre; display: none;">
        <?php  print_r($repeater); ?>
      </div>
      <?php
      }
      ?>
      
      <?php
      if( have_rows($repeater_name) ) {
      ?>
      <div class="et_pb_module et_pb_accordion">
        <?php 
      }
      ?> 
				
          <?php
          if( have_rows($repeater_name) ):
              // loop through the rows of data
              $i = 0;
              while ( have_rows($repeater_name) ) : the_row();
              if ($i == "0") {
                $isactive = "et_pb_toggle_open";
              } else {
                $isactive = "et_pb_toggle_close";
              }

              $tabs_header_text_get = get_sub_field($tabs_header_text);
              ?>
              
            <div class="et_pb_toggle et_pb_module et_pb_accordion_item et_pb_accordion_item_<?php echo $i ?> <?php echo $isactive ?>">
              
              <h5 class="et_pb_toggle_title"><?php echo $tabs_header_text_get ?></h5>
              <div class="et_pb_toggle_content clearfix">  
                
                <?php
                echo do_shortcode('[et_pb_section global_module="' . $tabs_loop_layout . '"][/et_pb_section]');
                ?>
              </div> <!-- .et_pb_toggle_content -->
            </div>

                <?php
                $i++;
                 endwhile;
                 endif;
                 ?>
    <?php
      if( have_rows($repeater_name) ) {
        ?>
        </div>
        <?php 
      }
      ?> 
      
      <?php 
      
    } else {
      echo "Please select a repeater style";
    }




  } else {
    if ($acf_item_style == 'list'){

      
      $this->add_classname('repeater-style-list');

      
ET_Builder_Element::set_style(
  $render_slug,
  array(
    'selector'    => '%%order_class%% .repeater_sep',
    'declaration' => sprintf(
      '
      padding-left:%1$s;
      padding-right:%2$s;
      ',
      esc_html( $acf_list_space_left ),
      esc_html( $acf_list_space_right )
    ),
  )
);
      

      $all_repeater_content_with_sep = str_replace('<div class="repeater_sep"></div>', '<div class="repeater_sep">'.$acf_repeater_seperator.'</div>', $all_repeater_content);
   
  
      echo $all_repeater_content_with_sep;

      
    } else {
    ?>
    <div class="et_pb_de_mach_archive_loop et_pb_gutters<?php echo $custom_gutter_repeater ?>">
      <div class="dmach-grid-sizes et_pb_de_mach_archive_loop repeater-cont grid col-desk-<?php echo $columns?> col-tab-<?php echo $columns_tablet?> col-mob-<?php echo $columns_mobile?>">
        <div class="grid-posts">

          <?php
          echo $all_repeater_content;
          ?>
        </div>
      </div>
    </div>
    <?php
    }
  }


  $data = ob_get_clean();



  //////////////////////////////////////////////////////////////////////

  return $data;



}

}

new de_mach_repeater_code;

?>
