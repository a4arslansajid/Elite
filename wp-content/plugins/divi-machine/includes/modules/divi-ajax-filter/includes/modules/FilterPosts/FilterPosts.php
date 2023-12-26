<?php
if (!function_exists("Divi_filter_module_import")) {
    add_action('et_builder_ready', 'Divi_filter_module_import');

    function Divi_filter_module_import() {
        if (class_exists("ET_Builder_Module") && !class_exists("de_df_filter_product_code")) {
            class de_df_filter_product_code extends ET_Builder_Module {

                public $vb_support = 'on';

                public $de_domain_name = '';

                protected $module_credits = array(
                    'module_uri' => DE_DF_PRODUCT_URL,
                    'author' => DE_DF_AUTHOR,
                    'author_uri' => DE_DF_URL,
                );

                function init() {
                    if (defined('DE_DMACH_VERSION')) {
                        $this->name = esc_html__('Filter Posts - Divi Machine', 'divi-machine');
                        $this->folder_name = 'divi_machine';
                        $this->de_domain_name = 'divi-machine';
                    }
                    else if (defined('DE_DB_WOO_VERSION')) {
                        $this->name = esc_html__('ARP Filter Posts - Archive Pages', 'divi-bodyshop-woocommerce');
                        $this->folder_name = 'divi_bodycommerce';
                        $this->de_domain_name = 'divi-bodyshop-woocommerce';
                    }
                    else {
                        $this->name = esc_html__('Filter Posts - Divi Ajax Filter', 'divi-filter');
                        $this->folder_name = 'divi_ajax_filter';
                        $this->de_domain_name = 'divi-filter';
                    }

                    $this->slug = 'et_pb_de_mach_filter_posts';
                    $this->vb_support = 'on';
                    $this->child_slug = 'et_pb_de_mach_search_posts_item';
                    $this->child_item_text = esc_html__('Filter Item', $this->de_domain_name);

                    $this->settings_modal_toggles = array(
                        'general' => array(
                            'toggles' => array(
                                'main_content' => esc_html__('Main Options', $this->de_domain_name),
                                'layout' => esc_html__('Layout Options', $this->de_domain_name),
                                'mobile_layout' => esc_html__('Mobile Options', $this->de_domain_name),
                                'filter_item' => esc_html__('Filter Item', $this->de_domain_name),
                                'toggle_appearance' => esc_html__('Toggle Appearance', $this->de_domain_name)
                            )
                        ),
                        'advanced' => array(
                            'toggles' => array(
                                'text' => esc_html__('Text', $this->de_domain_name)
                            )
                        )
                    );

                    $this->main_css_element = '%%order_class%%';
                    $this->advanced_fields = array(
                        'fonts' => array(
                            'title' => array(
                                'label' => esc_html__('Item', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%%, 
                                                %%order_class%% input[type=text], 
                                                %%order_class%% .divi-filter-item, 
                                                %%order_class%% input[type=text]::-webkit-input-placeholder, %%order_class%% input[type=text]:-moz-placeholder, 
                                                %%order_class%% input[type=text]::-moz-placeholder, 
                                                %%order_class%% input[type=text]:-ms-input-placeholder,
                                                %%order_class%% .divi-radio-buttons label",
                                    'important' => 'plugin_only'
                                ),
                                'font_size' => array(
                                    'default' => '14px'
                                ),
                                'line_height' => array(
                                    'default' => '1em'
                                )
                            ),
                            'filter_headings' => array(
                                'label' => esc_html__('Filter Heading', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% .et_pb_contact_field_options_title",
                                    'important' => 'plugin_only'
                                ),
                                'font_size' => array(
                                    'default' => '14px'
                                ),
                                'line_height' => array(
                                    'default' => '1em'
                                )
                            )
                        ),
                        'background' => array(
                            'settings' => array(
                                'color' => 'alpha'
                            )
                        ),
                        'button' => array(
                            'button' => array(
                                'label' => esc_html__('All Buttons', $this->de_domain_name),
                                'css' => array(
                                    'main' => "{$this->main_css_element} .et_pb_button",
                                    'important' => 'all'
                                ),
                                'box_shadow' => array(
                                    'css' => array(
                                        'main' => "{$this->main_css_element} .et_pb_button",
                                        'important' => 'all'
                                    ) ,
                                ) ,
                                'margin_padding' => array(
                                    'css' => array(
                                        'main' => "{$this->main_css_element} .et_pb_button",
                                        'important' => 'all'
                                    ) ,
                                ) ,
                                'use_alignment' => true,
                            ),
                            'search_button' => array(
                                'label' => esc_html__('Search Button', $this->de_domain_name),
                                'css' => array(
                                    'main' => "{$this->main_css_element} #divi_filter_button",
                                    'important' => 'all'
                                ),
                                'box_shadow' => array(
                                    'css' => array(
                                        'important' => 'all',
                                    )
                                ),
                                'margin_padding' => array(
                                    'css' => array(
                                        'important' => 'all',
                                    )
                                ),
                                'use_alignment' => false
                            ),
                            'reset_filter' => array(
                                // todo: find out if this can be conditionally hidden if button is inline
                                'hide_text_align' => true,
                                'label' => esc_html__('Reset Filter', $this->de_domain_name),
                                'css' => array(
                                    'main' => "{$this->main_css_element} .reset-filters.et_pb_button",
                                    'important' => 'all'
                                ),
                                'box_shadow' => array(
                                    'css' => array(
                                        'important' => 'all',
                                    )
                                ),
                                'margin_padding' => array(
                                    'css' => array(
                                        'important' => 'all',
                                    )
                                ),
                                'use_alignment' => false
                            ),
                            'filter_params' => array(
                                'label' => esc_html__('Filter Parameters', $this->de_domain_name),
                                'css' => array(
                                    'main' => ".filter-param-item",
                                    'important' => 'all'
                                ),
                                'box_shadow' => array(
                                    'css' => array(
                                        'main' => ".filter-param-item",
                                        'important' => 'all'
                                    )
                                ),
                                'margin_padding' => array(
                                    'css' => array(
                                        'main' => ".filter-param-item",
                                        'important' => 'all'
                                    )
                                ),
                                'use_alignment' => false
                            ),
                            'mobile_toggle_button' => array(
                                'label' => esc_html__('Mobile Toggle Button', $this->de_domain_name),
                                'css' => array(
                                    'main' => ".mobile_toggle_trigger.et_pb_button",
                                    'important' => 'all'
                                ),
                                'box_shadow' => array(
                                    'css' => array(
                                        'main' => ".mobile_toggle_trigger.et_pb_button",
                                        'important' => 'all',
                                    )
                                ),
                                'margin_padding' => array(
                                    'css' => array(
                                        'main' => ".mobile_toggle_trigger.et_pb_button",
                                        'important' => 'all'
                                    )
                                )
                            )
                        ),
                        'form_field' => array(
                            'form_field' => array(
                                'label' => esc_html__('Fields', $this->de_domain_name),
                                'css' => array(
                                    'main' => '%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                                    'background_color' => '%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_checkbox_select_wrapper .et_pb_contact_field_options_list, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                                    'background_color_hover' => '%%order_class%% .et_pb_contact_select:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:hover + label i, %%order_class%% .et_pb_contact_field[type="radio"]:hover + label i',
                                    'focus_background_color' => '%%order_class%% .et_pb_contact_select:focus, %%order_class%% .et_pb_contact_field[type="checkbox"]:active + label i, %%order_class%% .et_pb_contact_field[type="radio"]:active + label i',
                                    'focus_background_color_hover' => '%%order_class%% .et_pb_contact_select:focus:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:active:hover + label i, %%order_class%% .et_pb_contact_field[type="radio"]:active:hover + label i',
                                    'placeholder_focus' => '%%order_class%% p .input:focus::-webkit-input-placeholder, %%order_class%% p .input:focus::-moz-placeholder, %%order_class%% p .input:focus:-ms-input-placeholder, %%order_class%% p textarea:focus::-webkit-input-placeholder, %%order_class%% p textarea:focus::-moz-placeholder, %%order_class%% p textarea:focus:-ms-input-placeholder',
                                    'padding' => '%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                                    'margin' => '%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                                    'form_text_color' => '%%order_class%% .et_pb_contact_field_radio label, %%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label, %%order_class%% .et_pb_contact_field[type="radio"] + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked + label i:before',
                                    'form_text_color_hover' => '%%order_class%% .et_pb_contact_field_radio:hover label, %%order_class%% .et_pb_contact_select:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:hover + label, %%order_class%% .et_pb_contact_field[type="radio"]:hover + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:hover + label i:before',
                                    'focus_text_color' => '%%order_class%% .et_pb_contact_field_radio:focus label, %%order_class%% .et_pb_contact_select:focus, %%order_class%% .et_pb_contact_field[type="checkbox"]:active + label, %%order_class%% .et_pb_contact_field[type="radio"]:active + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:active + label i:before',
                                    'focus_text_color_hover' => '%%order_class%% .et_pb_contact_field_radio:focus:hover label, %%order_class%% .et_pb_contact_select:focus:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:active:hover + label, %%order_class%% .et_pb_contact_field[type="radio"]:active:hover + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:active:hover + label i:before',
                                ),
                                'box_shadow' => false,
                                'border_styles' => false,
                                'font_field' => array(
                                    'css' => array(
                                        'main' => implode(', ', array(
                                            "{$this->main_css_element} .input",
                                            "{$this->main_css_element} .input::placeholder",
                                            "{$this->main_css_element} .input::-webkit-input-placeholder",
                                            "{$this->main_css_element} .input::-moz-placeholder",
                                            "{$this->main_css_element} .input:-ms-input-placeholder",
                                            "{$this->main_css_element} .input[type=checkbox] + label",
                                            "{$this->main_css_element} .input[type=radio] + label"
                                        )),
                                        'hover' => array(
                                            "{$this->main_css_element} .input:hover",
                                            "{$this->main_css_element} .input:hover::placeholder",
                                            "{$this->main_css_element} .input:hover::-webkit-input-placeholder",
                                            "{$this->main_css_element} .input:hover::-moz-placeholder",
                                            "{$this->main_css_element} .input:hover:-ms-input-placeholder",
                                            "{$this->main_css_element} .input[type=checkbox]:hover + label",
                                            "{$this->main_css_element} .input[type=radio]:hover + label"
                                        )
                                    )
                                ),
                                'margin_padding' => array(
                                    'css' => array(
                                        'main' => '%%order_class%% .et_pb_contact_field',
                                        'padding' => '%%order_class%% .et_pb_contact_field .input',
                                        'margin' => '%%order_class%% .et_pb_contact_field'
                                    )
                                )
                            )
                        ),
                        'height' => array(
                            'css' => array(
                                'main' => implode(', ', array(
                                    '%%order_class%% input[type=text]',
                                    '%%order_class%% input[type=email]',
                                    '%%order_class%% textarea',
                                    '%%order_class%% [data-type=checkbox]',
                                    '%%order_class%% [data-type=radio]',
                                    '%%order_class%% [data-type=select]',
                                    '%%order_class%% select'
                                ))
                            )
                        ),
                        'box_shadow' => array(
                            'default' => array(),
                            'filter_item' => array(
                                'label' => esc_html__('Filter Item Box Shadow', $this->de_domain_name),
                                'option_category' => 'layout',
                                'tab_slug' => 'advanced',
                                'toggle_slug' => 'filter_item',
                                'css' => array(
                                    'main' => '%%order_class%% .divi-filter-item'
                                ),
                                'default_on_fronts' => array(
                                    'color' => '',
                                    'position' => ''
                                )
                            )
                        )
                    );

                    $this->custom_css_fields = array();

	                $this->help_videos=array(
		                array(
			                'id'   => '5GwmJUISgX8',
			                'name' => esc_html__( 'How to Add a Filter Field', $this->de_domain_name ),
		                ),
		                array(
			                'id'   => '6dhNwkljzUk',
			                'name' => esc_html__( 'Cómo mostrar los parámetros de filtrado', $this->de_domain_name ),
		                ),
		                array(
			                'id'   => 'oWXxPwdmoMg',
			                'name' => esc_html__( 'Conditional Logic', $this->de_domain_name ),
		                ),
		                array(
			                'id'   => 'RlXsz_j5Ilw',
			                'name' => esc_html__( 'Category Options', $this->de_domain_name ),
		                ),
	                );
                }

                function get_fields() {

                    $et_accent_color = et_builder_accent_color();

                    $fields = array(

                        'filter_update_type' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Filter Update Type', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'update_button' => esc_html__('Update via button', $this->de_domain_name),
                                'update_field' => esc_html__('Update after each field change', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'affects' => array(
                                'search_button_text',
                                'button_sidebyside'
                            ),
                            'default' => 'update_button',
                            'description' => esc_html__('Choose the post type you want to search', $this->de_domain_name)
                        ),
                        'scrollto' => array(
                            'label' => esc_html__('Scroll to Section After Ajax Update', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name)
                            ),
                            'default' => 'off',
                            'description' => esc_html__('If you want to scroll to a section after the update of the ajax filter, enable this.', $this->de_domain_name),
                            'toggle_slug' => 'main_content',
                            'affects' => array(
                                'scrollto_where',
                                'scrollto_section',
                                'scrollto_fine_tune'
                            )
                        ),
                        'scrollto_where' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('When To use Scroll To?', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'all' => esc_html__('Both Desktop, Tablet & Mobile', $this->de_domain_name),
                                'desktop' => esc_html__('Desktop Only', $this->de_domain_name),
                                'tab_mob' => esc_html__('Tablet & Mobile', $this->de_domain_name),
                                'mobile' => esc_html__('Mobile Only', $this->de_domain_name),
                            ),
                            'option_category' => 'configuration',
                            'default' => 'all',
                            'description' => esc_html__('Specify when you want it to scroll to - on desktop, mobile or all?', $this->de_domain_name),
                            'depends_show_if' => 'on'
                        ),
                        'scrollto_section' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Where to Scroll?', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'main-archive-loop' => esc_html__('Top of Posts', $this->de_domain_name),
                                'main-orderby' => esc_html__('Top of Orderby', $this->de_domain_name),
                                'main-filters' => esc_html__('Top of Filters', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'default' => 'main-archive-loop',
                            'description' => esc_html__('Choose where to scroll to.', $this->de_domain_name),
                            'depends_show_if' => 'on'
                        ),
                        'scrollto_fine_tune' => array(
                            'label' => esc_html__('Fine Tune the position', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '0px',
                            'toggle_slug' => 'main_content',
                            'option_category' => 'configuration',
                            'depends_show_if' => 'on',
                            'range_settings' => array(
                                'min' => '-500',
                                'max' => '500',
                                'step' => '1'
                            )
                        ),
                        'search_button_text' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Filter Button Text', $this->de_domain_name),
                            'type' => 'text',
                            'option_category' => 'configuration',
                            'default' => esc_html__('Search', $this->de_domain_name),
                            'depends_show_if' => 'update_button',
                            'description' => esc_html__('Choose what you want the search button to say', $this->de_domain_name)
                        ),
                        'button_sidebyside' => array(
                            'label' => esc_html__('Filter & Reset Buttons Side By Side?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name)
                            ),
                            'default' => 'off',
                            'depends_show_if' => 'update_button',
                            'description' => esc_html__('If you want the buttons to be side by side, please enable this.', $this->de_domain_name),
                            'toggle_slug' => 'layout'
                        ),
                        'reset_text' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Reset Text', $this->de_domain_name),
                            'type' => 'text',
                            'option_category' => 'configuration',
                            'default' => esc_html__('Reset', $this->de_domain_name),
                            'description' => esc_html__('Choose what you want the reset button text to say', $this->de_domain_name),
                            'show_if' => array(
                                'hide_reset' => 'off'
                            )
                        ),
                        'select2' => array(
                            'label' => esc_html__('Enable Select2 for your Select Options?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name)
                            ),
                            'default' => 'off',
                            'description' => esc_html__('If you want to use Select2 on one or more of your select options in the filter, enable this. This will enqueue the Select2 JS and CSS to make this work.', $this->de_domain_name),
                            'toggle_slug' => 'main_content'
                        ),
                        'filter_location' => array(
                            'toggle_slug' => 'layout',
                            'label' => esc_html__('Filter Location', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'side' => esc_html__('Side Columm', $this->de_domain_name),
                                'fullwidth' => esc_html__('Fullwidth Column', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'affects' => array(
                                'column_gap',
                                'column_min_width'
                            ),
                            'default' => 'side',
                            'description' => esc_html__('Choose where you are placing the filter, this will change the appearance and the settings in the design tab', $this->de_domain_name)
                        ),
                        'fullwidth_columns' => array(
                            'toggle_slug' => 'layout',
                            'label' => esc_html__('Number of Columns Desktop', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'auto' => esc_html__('Auto', $this->de_domain_name),
                                '1' => esc_html__('1', $this->de_domain_name),
                                '2' => esc_html__('2', $this->de_domain_name),
                                '3' => esc_html__('3', $this->de_domain_name),
                                '4' => esc_html__('4', $this->de_domain_name),
                                '5' => esc_html__('5', $this->de_domain_name),
                                '6' => esc_html__('6', $this->de_domain_name),
                                '7' => esc_html__('7', $this->de_domain_name),
                                '8' => esc_html__('8', $this->de_domain_name),
                                '9' => esc_html__('9', $this->de_domain_name),
                                '10' => esc_html__('10', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'show_if' => array(
                                'filter_location' => ['fullwidth']
                            ),
                            'default' => 'auto',
                            'description' => esc_html__('We will evenly divide the space between the number of filters unless you specify the number here.', $this->de_domain_name)
                        ),
                        'fullwidth_columns_tablet' => array(
                            'toggle_slug' => 'layout',
                            'label' => esc_html__('Number of Columns Tablet', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'auto' => esc_html__('Auto', $this->de_domain_name),
                                '1' => esc_html__('1', $this->de_domain_name),
                                '2' => esc_html__('2', $this->de_domain_name),
                                '3' => esc_html__('3', $this->de_domain_name),
                                '4' => esc_html__('4', $this->de_domain_name),
                                '5' => esc_html__('5', $this->de_domain_name),
                                '6' => esc_html__('6', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'show_if' => array(
                                'filter_location' => ['fullwidth']
                            ),
                            'default' => 'auto',
                            'description' => esc_html__('We will evenly divide the space between the number of filters unless you specify the number here.', $this->de_domain_name)
                        ),
                        'fullwidth_columns_mobile' => array(
                            'toggle_slug' => 'layout',
                            'label' => esc_html__('Number of Columns Mobile', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'auto' => esc_html__('Auto', $this->de_domain_name),
                                '1' => esc_html__('1', $this->de_domain_name),
                                '2' => esc_html__('2', $this->de_domain_name),
                                '3' => esc_html__('3', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'show_if' => array(
                                'filter_location' => ['fullwidth']
                            ),
                            'default' => '1',
                            'description' => esc_html__('We will evenly divide the space between the number of filters unless you specify the number here.', $this->de_domain_name)
                        ),
                        'column_min_width' => array(
                            'label' => esc_html__('Column Min Width', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '100',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'depends_show_if' => 'fullwidth',
                            'range_settings' => array(
                                'min' => '1',
                                'max' => '1000',
                                'step' => '1'
                            ),
                            'toggle_slug' => 'layout',
                            'option_category' => 'configuration',
                            'description' => esc_html__('Set the gap between the columns.', $this->de_domain_name),
                        ),
                        'column_gap' => array(
                            'label' => esc_html__('Gap Between Columns', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '20',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'depends_show_if' => 'fullwidth',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '300',
                                'step' => '1'
                            ),
                            'toggle_slug' => 'layout',
                            'option_category' => 'configuration',
                            'description' => esc_html__('Set the gap between the columns.', $this->de_domain_name)
                        ),
                        'appearance' => array(
                            'toggle_slug' => 'layout',
                            'label' => esc_html__('Filter Style', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'normal'        => esc_html__( 'Normal', $this->de_domain_name ),
                                'toggle'        => esc_html__( 'Toggle', $this->de_domain_name ),
                                'slide'         => esc_html__( 'Slide', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'affects' => array(
                                'toggle_icon',
                                'toggle_dropdown_padding',
                                'slide_toggler',
                                'slide_toggler_hide_text'
                            ),
                            'default' => 'normal',
                            'description' => esc_html__('Choose the appearance style of your filters', $this->de_domain_name),
                        ),
                        'mobile_toggle' => array(
                            'toggle_slug' => 'mobile_layout',
                            'label' => esc_html__('Toggle Whole Filter?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'affects' => array(
                                'mobile_toggle_style'
                            ),
                            'default' => 'off',
                            'description' => esc_html__('Enable this when you want to show your filters by toggle.', $this->de_domain_name)
                        ),
                        'mobile_toggle_style' => array(
                            'toggle_slug' => 'mobile_layout',
                            'label' => esc_html__('Mobile Toggle Style', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'button' => esc_html__('Button', $this->de_domain_name),
                                // 'sticky'         => esc_html__( 'Sticky Icon on Side', $this->de_domain_name ), // need to finish settings for this to work properly
                                
                            ),
                            'option_category' => 'configuration',
                            'affects' => array(
                                'mobile_toggle_position',
                                'filter_toggle_name',
                                'filter_toggle_icon',
                                'filter_toggle_icon_color',
                                'auto_close_toggle'
                            ),
                            'default' => 'button',
                            'depends_show_if' => 'on',
                            'description' => esc_html__('Choose the type of Toggle style you want - how the visitor will open to see the filters.', $this->de_domain_name)
                        ),
                        'auto_close_toggle' => array(
                            'toggle_slug' => 'mobile_layout',
                            'label' => esc_html__('Auto-Close Toggle on Filter', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'default' => 'off',
                            'depends_show_if' => 'button',
                            'description' => esc_html__('Enable this if you want the filter to auto-close when making a selection.', $this->de_domain_name)
                        ),
                        'filter_toggle_name' => array(
                            'toggle_slug' => 'mobile_layout',
                            'label'             => esc_html__( 'Filter Toggle Button Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'           => 'Show Filter',
                            'depends_show_if'   => 'button',
                            'description'       => esc_html__( 'Choose the name of the button that when they press it will toggle the filter', $this->de_domain_name ),
                        ),
                        'filter_toggle_hide_name' => array(
                            'toggle_slug'       => 'mobile_layout',
                            'label'             => esc_html__( 'Filter Toggle Button Text(Hide)', $this->de_domain_name ),
                            'type' => 'text',
                            'option_category' => 'configuration',
                            'default'           => 'Hide Filter',
                            'depends_show_if' => 'button',
                            'description' => esc_html__('Choose the name of the button that when they press it will toggle the filter', $this->de_domain_name)
                        ),
                        'mobile_toggle_ind_filter' => array(
                            'toggle_slug' => 'mobile_layout',
                            'label' => esc_html__('Toggle Individual Filters?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'default' => 'off',
                            'description' => esc_html__('Enable this when you want to enable toggles for each filter on mobile.', $this->de_domain_name)
                        ),
                        'filter_toggle_icon' => array(
                            'toggle_slug' => 'mobile_layout',
                            'label' => esc_html__('Filter Toggle Icon', $this->de_domain_name),
                            'type' => 'select_icon',
                            'option_category' => 'basic_option',
                            'class' => array(
                                'et-pb-font-icon'
                            ),
                            'description' => esc_html__('Choose the icon you want to use to slide the filter.', $this->de_domain_name),
                            'depends_show_if' => 'sticky'
                        ),
                        'filter_toggle_icon_color' => array(
                            'default' => $et_accent_color,
                            'label' => esc_html__('Filter Toggle Icon Color', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'description' => esc_html__('Here you can define a custom color for your icon.', $this->de_domain_name),
                            'depends_show_if' => 'sticky',
                            'toggle_slug' => 'mobile_layout'
                        ),
                        'mobile_toggle_position' => array(
                            'toggle_slug' => 'mobile_layout',
                            'label' => esc_html__('Sticky Toggle Position', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'left' => esc_html__('Left', $this->de_domain_name),
                                'right' => esc_html__('Right', $this->de_domain_name)
                            ),
                            'option_category' => 'configuration',
                            'default' => 'left',
                            'depends_show_if' => 'sticky',
                            'description'       => esc_html__( 'Enable this when you want to show your filters by toggle.', $this->de_domain_name ),
                        ),
                        'slide_toggler'         => array(
                            'toggle_slug'       => 'layout',
                            'label'             => esc_html__( 'Slide Toggle Button', $this->de_domain_name ),
                            'type'              => 'text',
                            'default'           => '',
                            'depends_show_if'   => 'slide',
                            'description'       => esc_html__( 'Input the ID of the html element to slide filter module when it is clicked.', $this->de_domain_name ),
                        ),
                        'slide_toggler_hide_text'   => array(
                            'toggle_slug'       => 'layout',
                            'label'             => esc_html__( 'Button Hide Filter Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'default'           => esc_html__( 'Hide Filter', $this->de_domain_name ),
                            'depends_show_if'   => 'slide',
                            'description'       => esc_html__( 'Input the text of the slide toggler button to close filter module when it is opened.', $this->de_domain_name ),
                        ),
                        'hide_reset' => array(
                            'toggle_slug' => 'layout',
                            'label'             => esc_html__( 'Hide Reset Button?', $this->de_domain_name ),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on'    => esc_html__( 'Yes', $this->de_domain_name ),
                                'off'   => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default' => 'off',
                            'affects' => array(
                                'align_reset',
                                'show_reset_on_update'
                            ),
                            'description' => esc_html__('If you want to hide the reset button, enable this.', $this->de_domain_name)
                        ),
                        'align_reset' => array(
                            'toggle_slug' => 'layout',
                            'label' => esc_html__('Align Reset Button', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'none' => esc_html__('None', $this->de_domain_name),
                                'left' => esc_html__('Left', $this->de_domain_name),
                                'right' => esc_html__('Right', $this->de_domain_name)
                            ),
                            'show_if' => array(
                                'button_sidebyside' => 'off'
                            ),
                            'default' => 'none',
                            'show_if' => array(
                                'button_sidebyside' => 'off'
                            ),
                            'description' => esc_html__('Select this option if you want to align the reset button with search button.', $this->de_domain_name)
                        ),
                        'show_reset_on_update' => array(
                            'label' => esc_html__('Show Reset button only after filter change?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name)
                            ),
                            'depends_show_if' => 'off',
                            'default' => 'off',
                            'description' => esc_html__('If you want the reset button to only show when they make a change to the filters, enable this.', $this->de_domain_name),
                            'toggle_slug' => 'layout'
                        ),
                        'filter_item_top' => array(
                            'label' => esc_html__('Filter Item From Top', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '40',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '300',
                                'step' => '1'
                            ),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'filter_item'
                        ),
                        'filter_item_bg_color' => array(
                            'label' => esc_html__('Filter Item Background Color', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'filter_item',
                            'description' => esc_html__('This will change the fill color for the filter item background.', $this->de_domain_name),
                            'default' => "#ffffff"
                        ),
                        'filter_item_padding_top' => array(
                            'label' => esc_html__('Filter Item Padding Top', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '0',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '100',
                                'step' => '1'
                            ),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'filter_item'
                        ),
                        'filter_item_padding_right' => array(
                            'label' => esc_html__('Filter Item Padding Right', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '0',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '100',
                                'step' => '1'
                            ),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'filter_item'
                        ),
                        'filter_item_padding_bottom' => array(
                            'label' => esc_html__('Filter Item Padding Bottom', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '0',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '100',
                                'step' => '1'
                            ),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'filter_item'
                        ),
                        'filter_item_padding_left' => array(
                            'label' => esc_html__('Filter Item Padding Left', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '0',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '100',
                                'step' => '1'
                            ),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'filter_item'
                        ),
                        'toggle_icon' => array(
                            'label' => esc_html__('Toggle Icon', $this->de_domain_name),
                            'type' => 'select_icon',
                            'option_category' => 'configuration',
                            'class' => array(
                                'et-pb-font-icon'
                            ),
                            'description' => esc_html__('Choose the icon to open the toggle.', $this->de_domain_name),
                            'tab_slug' => 'advanced',
                            'default' => '&#x33;||divi||400',
                            'toggle_slug' => 'toggle_appearance'
                        ),
                        'toggle_icon_close' => array(
                            'label' => esc_html__('Toggle Close Icon', $this->de_domain_name),
                            'type' => 'select_icon',
                            'option_category' => 'configuration',
                            'default' => '&#x32;||divi||400',
                            'class' => array(
                                'et-pb-font-icon'
                            ),
                            'description' => esc_html__('Choose the icon to close the toggle.', $this->de_domain_name),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'toggle_appearance'
                        ),
                        'toggle_dropdown_padding' => array(
                            'label' => esc_html__('Toggle dropdown padding', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '10',
                            'default_unit' => 'px',
                            'default_on_front' => '',
                            'depends_show_if' => 'toggle',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '200',
                                'step' => '1'
                            ),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'toggle_appearance',
                            'option_category' => 'configuration',
                            'description' => esc_html__('Set the padding of the toggle drop down box.', $this->de_domain_name)
                        ),
                        'label_spacing' => array(
                            'label'             => esc_html__( 'Space Above Item', $this->de_domain_name ),
                            'type'              => 'range',
                            'option_category'   => 'configuration',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'margin_padding',
                            'description'       => esc_html__( 'This will adjust the spacing above the item.', $this->de_domain_name ),
                            'default'           => "16px",
                            'default_unit'      => 'px',
                        )
                    );

                    return $fields;
                }

                public function get_search_items_content() {
                    return $this->content;
                }

                public function get_transition_fields_css_props() {
                    $fields = parent::get_transition_fields_css_props();

                    $fields['form_field_background_color'] = array(
                        'background-color' => implode(', ', array(
                            '%%order_class%% .et_pb_contact_field',
                            '%%order_class%% .et_pb_checkbox_select_wrapper .et_pb_contact_field_options_list',
                            '%%order_class%% .et_pb_contact_field[type="checkbox"]+label i',
                            '%%order_class%% .et_pb_contact_field[type="radio"]+label i',
                        ))
                    );

                    return $fields;
                }

                public function get_button_alignment() {
                    $text_orientation = isset($this->props['button_alignment']) ? $this->props['button_alignment'] : '';
                    return et_pb_get_alignment($text_orientation);
                }

                function render($attrs, $content, $render_slug) {

                    if (is_admin()) {
                        return;
                    }

                    global $divi_filter_removed_param;

                    //if ( !empty( $_GET['filter'] ) && $_GET['filter'] == 'true' ){
                    if ( !empty($divi_filter_removed_param) ) {
                        foreach ($divi_filter_removed_param as $key => $value ) {
                                $_GET[$key] = $value;
                            }
                        }

                    //}

                    $divi_filter_removed_param = array();

                    $select2             = $this->props['select2'];                    
                    $search_button_text = $this->props['search_button_text'];
                    $reset_text = $this->props['reset_text'];
                    $filter_update_type = $this->props['filter_update_type'];
                    $appearance = $this->props['appearance'];
                    $mobile_toggle = $this->props['mobile_toggle'];
                    $mobile_toggle_style = $this->props['mobile_toggle_style'];
                    $filter_toggle_name = $this->props['filter_toggle_name'];
                    $filter_toggle_hide_name        = $this->props['filter_toggle_hide_name'];
                    $mobile_toggle_position = $this->props['mobile_toggle_position'];
                    $filter_location = $this->props['filter_location'];
                    $filter_item_bg_color = $this->props['filter_item_bg_color'];

                    $slide_toggler                  = $this->props['slide_toggler'];
                    $slide_toggler_hide_text        = $this->props['slide_toggler_hide_text'];

                    $filter_item_top = $this->props['filter_item_top'];
                    $toggle_icon = $this->props['toggle_icon'];
                    $toggle_icon_close = $this->props['toggle_icon_close'];

                    $filter_item_padding_top = $this->props['filter_item_padding_top'];
                    $filter_item_padding_right = $this->props['filter_item_padding_right'];
                    $filter_item_padding_bottom = $this->props['filter_item_padding_bottom'];
                    $filter_item_padding_left = $this->props['filter_item_padding_left'];
                    $fullwidth_columns = $this->props['fullwidth_columns'];
                    $fullwidth_columns_tablet = $this->props['fullwidth_columns_tablet'];
                    $fullwidth_columns_mobile = $this->props['fullwidth_columns_mobile'];
                    $column_gap = $this->props['column_gap'];
                    $column_min_width = $this->props['column_min_width'];
                    $toggle_dropdown_padding = $this->props['toggle_dropdown_padding'];
                    $hide_reset = $this->props['hide_reset'];
                    $align_reset = $this->props['align_reset'];
                    $button_sidebyside = $this->props['button_sidebyside'];
                    $button_alignment = $this->get_button_alignment();
                    $button_use_icon = $this->props['button_use_icon'];
                    $custom_icon = $this->props['button_icon'];
                    $button_bg_color = $this->props['button_bg_color'];
                    $filter_toggle_icon = $this->props['filter_toggle_icon'];
                    $filter_toggle_icon_color = $this->props['filter_toggle_icon_color'];
                    
                    $show_reset_on_update = $this->props['show_reset_on_update'];
                    $mobile_toggle_ind_filter = $this->props['mobile_toggle_ind_filter'];
                    $auto_close_toggle = $this->props['auto_close_toggle'];
                    $mobile_toggle_button_use_icon = $this->props['mobile_toggle_button_use_icon'];
                    $mobile_toggle_button_icon = $this->props['mobile_toggle_button_icon'];
                    $mobile_toggle_button_bg_color = $this->props['mobile_toggle_button_bg_color'];
                    $mobile_toggle_button_icon_placement      = $this->props['mobile_toggle_button_icon_placement'];
                      
                    $scrollto = $this->props['scrollto'];
                    $scrollto_where = $this->props['scrollto_where'];
                    $scrollto_section = $this->props['scrollto_section'];
                    $scrollto_fine_tune = $this->props['scrollto_fine_tune'];
                    $label_spacing        = $this->props['label_spacing'];

                    // Module classnames
                    $this->add_classname(
                        array(
                            'clearfix',
                            $this->get_text_orientation_classname(),
                        )
                    );

                    ////////////////////////////
                    // BUTTON ICONS 

                    // search filter - search_button

                    $search_button_icon = $this->props['search_button_icon'];
                    $search_button_icon_placement = $this->props['search_button_icon_placement'];
                    
                    $search_button_icon = $search_button_icon ?? 'N||divi||400';
                    $search_button_icon_arr = explode('||', $search_button_icon);
                    $search_button_icon_font_family = ( !empty( $search_button_icon_arr[1] ) && $search_button_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                    $search_button_icon_font_weight = ( !empty( $search_button_icon_arr[2] ))?$search_button_icon_arr[2]:'400';
                    $search_button_icon_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $search_button_icon ) );
                    $search_button_icon_dis = preg_replace( '/(&#x)|;/', '', $search_button_icon_dis );
                    $search_button_icon_selector= $search_button_icon_placement == 'right' ? 'after' : 'before';

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "body #page-container %%order_class%% #divi_filter_button::$search_button_icon_selector",
                        'declaration' => sprintf(
                            '
                            position: absolute;
                            content:"\%1s";
                            font-family:%2$s!important;
                            font-weight:%3$s;
                            ',$search_button_icon_dis,
                            $search_button_icon_font_family,
                            $search_button_icon_font_weight
                        ),
                    ));

                    // reset filter - reset_filter

                    $reset_filter_icon = $this->props['reset_filter_icon'];
                    $reset_filter_icon_placement = $this->props['reset_filter_icon_placement'];
                    
                    $reset_filter_icon = $reset_filter_icon ?? 'N||divi||400';
                    $reset_filter_icon_arr = explode('||', $reset_filter_icon);
                    $reset_filter_icon_font_family = ( !empty( $reset_filter_icon_arr[1] ) && $reset_filter_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                    $reset_filter_icon_font_weight = ( !empty( $reset_filter_icon_arr[2] ))?$reset_filter_icon_arr[2]:'400';
                    $reset_filter_icon_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $reset_filter_icon ) );
                    $reset_filter_icon_dis = preg_replace( '/(&#x)|;/', '', $reset_filter_icon_dis );
                    $reset_filter_icon_selector= $reset_filter_icon_placement == 'right' ? 'after' : 'before';

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "body #page-container %%order_class%% .reset-filters::$reset_filter_icon_selector",
                        'declaration' => sprintf(
                            '
                            position: absolute;
                            content:"\%1s";
                            font-family:%2$s!important;
                            font-weight:%3$s;
                            ',$reset_filter_icon_dis,
                            $reset_filter_icon_font_family,
                            $reset_filter_icon_font_weight
                        ),
                    ));

                    // Filter Params - filter_params

                    $filter_params_icon = $this->props['filter_params_icon'];
                    $filter_params_icon_placement = $this->props['filter_params_icon_placement'];
                    
                    $filter_params_icon = $filter_params_icon ?? 'N||divi||400';
                    $filter_params_icon_arr = explode('||', $filter_params_icon);
                    $filter_params_icon_font_family = ( !empty( $filter_params_icon_arr[1] ) && $filter_params_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                    $filter_params_icon_font_weight = ( !empty( $filter_params_icon_arr[2] ))?$filter_params_icon_arr[2]:'400';
                    $filter_params_icon_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $filter_params_icon ) );
                    $filter_params_icon_dis = preg_replace( '/(&#x)|;/', '', $filter_params_icon_dis );
                    $filter_params_icon_selector= $filter_params_icon_placement == 'right' ? 'after' : 'before';

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "body #page-container .et_pb_section .filter-param-tags .filter-param-item",
                        'declaration' => sprintf(
                            '
                            padding-right: 35px !important;
                            '
                        ),
                    ));
 
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "body #page-container .et_pb_section .filter-param-tags .filter-param-item::$filter_params_icon_selector",
                        'declaration' => sprintf(
                            '
                            position: absolute;
                            content:"\%1s";
                            font-family:%2$s!important;
                            font-weight:%3$s;
                            ',$filter_params_icon_dis,
                            $filter_params_icon_font_family,
                            $filter_params_icon_font_weight
                        ),
                    ));

                    // Mobile Toggle Button - mobile_toggle_button

                    $mobile_toggle_button_icon = $this->props['mobile_toggle_button_icon'];
                    $mobile_toggle_button_icon_placement = $this->props['mobile_toggle_button_icon_placement'];
                    
                    $mobile_toggle_button_icon = $mobile_toggle_button_icon ?? 'N||divi||400';
                    $mobile_toggle_button_icon_arr = explode('||', $mobile_toggle_button_icon);
                    $mobile_toggle_button_icon_font_family = ( !empty( $mobile_toggle_button_icon_arr[1] ) && $mobile_toggle_button_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                    $mobile_toggle_button_icon_font_weight = ( !empty( $mobile_toggle_button_icon_arr[2] ))?$mobile_toggle_button_icon_arr[2]:'400';
                    $mobile_toggle_button_icon_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $mobile_toggle_button_icon ) );
                    $mobile_toggle_button_icon_dis = preg_replace( '/(&#x)|;/', '', $mobile_toggle_button_icon_dis );
                    $mobile_toggle_button_icon_selector= $mobile_toggle_button_icon_placement == 'right' ? 'after' : 'before';

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => "body #page-container %%order_class%% #divi_filter_mobile_trigger.mobile_toggle_trigger.et_pb_button::$mobile_toggle_button_icon_selector",
                        'declaration' => sprintf(
                            '
                            position: absolute;
                            content:"\%1s";
                            font-family:%2$s!important;
                            font-weight:%3$s;
                            ',$mobile_toggle_button_icon_dis,
                            $mobile_toggle_button_icon_font_family,
                            $mobile_toggle_button_icon_font_weight
                        ),
                    ));

                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => '%%order_class%% #divi_filter .mobile_toggle_trigger.sticky-toggle:after',
                        'declaration' => sprintf('content: "%1$s";', $filter_toggle_icon_color)
                    ));

                    if (class_exists('DEBC_INIT')) {
                        $toggle_icon_dis = DEBC_INIT::et_icon_css_content(esc_attr($toggle_icon));
                    }
                    else if (class_exists('DEDMACH_INIT')) {
                        $toggle_icon_dis = DEDMACH_INIT::et_icon_css_content(esc_attr($toggle_icon));
                    }
                    else {
                        $toggle_icon_dis = DE_Filter::et_icon_css_content(esc_attr($toggle_icon));
                    }

                    if (class_exists('DEBC_INIT')) {
                        $toggle_icon_close_dis = DEBC_INIT::et_icon_css_content(esc_attr($toggle_icon_close));
                    }
                    else if (class_exists('DEDMACH_INIT')) {
                        $toggle_icon_close_dis = DEDMACH_INIT::et_icon_css_content(esc_attr($toggle_icon_close));
                    }
                    else {
                        $toggle_icon_close_dis = DE_Filter::et_icon_css_content(esc_attr($toggle_icon_close));
                    }

                    $all_tabs_content = $this->get_search_items_content();

                    $this->add_classname('divi-location-' . $filter_location);

                    if ($appearance == "toggle") {
                        $this->add_classname( 'divi-filer-toggle' );
                    }

                    if ( $appearance == "slide" ) {
                        $this->add_classname( 'divi-filter-slide' );
                    }
                    if ($mobile_toggle_ind_filter == "on") {
                        $this->add_classname('divi-filer-toggle-mob');
                    }

                    if ($hide_reset == "on") {
                        $this->add_classname('hide_reset_btn');
                    }

                    if ($button_sidebyside == "on") {
                        $this->add_classname('side_by_side_btns');
                    }
                    if ($show_reset_on_update == "off") {
                        $this->add_classname('show_reset_always');
                    }

                    if ($auto_close_toggle == "on") {
                        $this->add_classname('auto_close_filter_mobile');
                    }

                    if (!empty($toggle_dropdown_padding)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .divi-filter-item',
                            'declaration' => sprintf('padding: %1$s !important;', esc_html($toggle_dropdown_padding))
                        ));
                    }

                    if (!empty($fullwidth_columns)) {

                        if ($fullwidth_columns != "auto") {
                            self::set_style($render_slug, array(
                                'selector' => '%%order_class%%.divi-location-fullwidth .divi-filter-containter',
                                'declaration' => sprintf('grid-template-columns: repeat(%1$s, minmax(0, 1fr));', esc_html($fullwidth_columns))
                            ));
                        }

                    }

                    if (!empty($column_gap)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%%.divi-location-fullwidth .divi-filter-containter',
                            'declaration' => sprintf('column-gap: %1$s;', esc_html($column_gap))
                        ));
                    }

                    if (!empty($column_min_width)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%%.divi-location-fullwidth .divi-filter-containter',
                            'declaration' => sprintf('grid-template-columns: repeat(auto-fit, minmax(%1$s, 1fr));', esc_html($column_min_width))
                        ));
                    }

                    if (!empty($toggle_icon)) {
                        $toggle_icon_arr = explode('||', $toggle_icon);
                        $toggle_icon_font_family = (!empty($toggle_icon_arr[1]) && $toggle_icon_arr[1] == 'fa') ? 'FontAwesome' : 'ETmodules';
                        $toggle_icon_font_weight = (!empty($toggle_icon_arr[2])) ? $toggle_icon_arr[2] : '400';
                    }

                    if (!empty($toggle_icon_close)) {
                        $toggle_icon_close_arr = explode('||', $toggle_icon_close);
                        $toggle_icon_close_font_family = (!empty($toggle_icon_close_arr[1]) && $toggle_icon_close_arr[1] == 'fa') ? 'FontAwesome' : 'ETmodules';
                        $toggle_icon_close_font_weight = (!empty($toggle_icon_close_arr[2])) ? $toggle_icon_close_arr[2] : '400';
                    }

                    // if ($mobile_toggle_ind_filter == "on") {
                    //     $this->add_classname('individual-toggle');
                    // }
                    
                    if ($toggle_icon != "" && ($appearance == "toggle" || $mobile_toggle_ind_filter == "on")) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .et_pb_contact_field_options_title::after',
                            'declaration' => sprintf('content: "%1$s";font-family:"%2$s"!important;font-weight:%3$s;', esc_html($toggle_icon_dis), $toggle_icon_font_family ?? '', $toggle_icon_font_weight ?? '')
                        ));
                    }

                    if ($toggle_icon_close != "" && ($mobile_toggle_ind_filter == "on" || $appearance == "toggle")) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .visible .et_pb_contact_field_options_title::after',
                            'declaration' => sprintf('content: "%1$s";font-family:"%2$s"!important;font-weight:%3$s;', esc_html($toggle_icon_close_dis), $toggle_icon_close_font_family ?? '', $toggle_icon_close_font_weight ?? '')
                        ));
                    }

                    if (!empty($filter_item_bg_color)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .divi-filter-item',
                            'declaration' => sprintf('background-color: %1$s;', esc_attr($filter_item_bg_color))
                        ));
                    }

                    if (!empty($filter_item_top)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .divi-filter-item',
                            'declaration' => sprintf('top: %1$s;', esc_attr($filter_item_top))
                        ));
                    }

                    if (!empty($filter_item_padding_top)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .divi-filter-item',
                            'declaration' => sprintf('padding-top: %1$s;', esc_attr($filter_item_padding_top))
                        ));
                    }

                    if (!empty($filter_item_padding_right)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .divi-filter-item',
                            'declaration' => sprintf('padding-right: %1$s;', esc_attr($filter_item_padding_right))
                        ));
                    }

                    if (!empty($filter_item_padding_bottom)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .divi-filter-item',
                            'declaration' => sprintf('padding-bottom: %1$s;', esc_attr($filter_item_padding_bottom))
                        ));
                    }

                    if (!empty($filter_item_padding_left)) {
                        self::set_style($render_slug, array(
                            'selector' => '%%order_class%% .divi-filter-item',
                            'declaration' => sprintf('padding-left: %1$s;', esc_attr($filter_item_padding_left))
                        ));
                    }

                    $this->add_classname('et_pb_button_alignment_' . $button_alignment . '');

                    if ($scrollto_section === 'main-filters') {
                        $this->add_classname('main-filters');
                    }

                    if ($select2 == "on") {

                        wp_enqueue_style('divi-filter-select2-css');
                        wp_enqueue_script('divi-filter-select2-js');

                    }
                    if (!empty($label_spacing)) {
                        self::set_style($render_slug, array(
                                'selector' => '%%order_class%% .divi-filter-item, %%order_class%% .divi-acf-map-radius',
                                'declaration' => "margin-top: $label_spacing;"
                            )
                        );
                    }

                    //////////////////////////////////////////////////////////////////////
                    ob_start();

                    global $post;

                    if (is_object($post)) {
                        $post_type = get_post_type($post->ID);
                        $post_link = get_post_type_archive_link($post_type);
                    }
                    else {
                        $post_link = "";
                    }

                    if ($mobile_toggle == 'on') {

                        $mobile_toggle_class = '';

                        if ($mobile_toggle == 'on' && $mobile_toggle_style == "sticky") {
                            $mobile_toggle_class = 'mobile_toggle_' . $mobile_toggle_position;
                        }

                        $this->add_classname($mobile_toggle_class);

                        if ($mobile_toggle_style == "button") {
                            $this->add_classname( "toggle_mobile" );
                            echo '<a id="divi_filter_mobile_trigger" class="mobile_toggle_trigger et_pb_button" '. esc_attr($mobile_toggle_button_icon_dis).' data-toggle_text="'. esc_attr($filter_toggle_hide_name) . '">'.esc_attr($filter_toggle_name).'</a>';
                            $toggle_html = '';
                        } else {
	                        if ( isset( $filter_toggle_icon_rendered ) ) {
                            $toggle_html = '<div id="divi_filter_mobile_trigger" class="mobile_toggle_trigger sticky-toggle" ' . $filter_toggle_icon_rendered . '></div>';
                        }
                    }
                    }
                    else {
                        $toggle_html = '';
                    }

                    $slide_toggler_data = '';

                    if ( $appearance == 'slide' && $slide_toggler != '' ) {
                        $slide_toggler_data = 'data-slide_toggler="' . $slide_toggler . '"';
                        if ( $slide_toggler_hide_text != '' ) {
                            $slide_toggler_data = $slide_toggler_data. ' data-slide_hide_text="' . $slide_toggler_hide_text . '"';
                        }
                    }
                ?>

                    <div id="divi_filter" class="et_pb_contact updatetype-<?php echo esc_attr($filter_update_type) ?> " data-settings='{"scrollto" : "<?php echo esc_attr($scrollto) ?>","scrollto_where" : "<?php echo esc_attr($scrollto_where) ?>","scrollto_section" : "<?php echo esc_attr($scrollto_section) ?>","scrollto_fine_tune" : "<?php echo esc_attr($scrollto_fine_tune) ?>"}' <?php echo $slide_toggler_data;?>>
    
                        <?php echo esc_html($toggle_html) ?>
                        <form>
                            <div class="ajax-filter-results"></div>
                            <div class="divi-filter-containter">
                                <?php echo et_core_esc_previously($all_tabs_content); ?>
                            </div>
                        </form>

                        <?php
                        $align_search_class = '';
                    if ($filter_update_type == "update_button") {
                        

                        if ($align_reset == 'left') {
                            $align_search_class = "align_reset_right";
                        }
                        else if ($align_reset == 'right') {
                            $align_search_class = "align_reset_left";
                        }
?>
                
                            <script>
                                jQuery(document).ready(function($) {
                                    $( "#divi_filter_button" ).click(function() {
                                        $(".filter-param-tags").html("");
                                        divi_find_filters_to_filter();

                                        var type_arr = [],
                                        slug_arr = [],
                                        value_arr = [],
                                        name_arr = [],
                                        filter_param_type_arr = [],
                                        iris_to_arr = [],
                                        irs_from_arr = [];

                                        $('.et_pb_de_mach_search_posts_item').each(function(i, obj) {
                                
                                            
                                            if ( jQuery(this).hasClass( "filter_params" ) ) {
                                                if ( jQuery(this).hasClass( "filter_params_yes_title" ) ) {
                                                    var filter_param_type = "title";
                                                } else {
                                                    var filter_param_type = "no-title";
                                                }

                                                var type = jQuery(this).find(".et_pb_contact_field ").attr("data-type"),
                                                slug = $(this).find('.divi-acf').data("name"),
                                                name = jQuery(this).find(".et_pb_contact_field_options_title").text(),
                                                iris_to = "",
                                                irs_from = "";
                                                if (type == "select") {
                                                    if ($(this).find('.divi-acf').val() !== "") {
                                                    var value = $(this).find('.divi-acf').find('option:selected').text();
                                                    } else {
                                                    var value = "";
                                                    }
                                                } else if (type == "radio") {

                                                    var selected_radio = $(this).find('input:checked');

                                                    var value = [];

                                                    jQuery.each( selected_radio, function( ind, obj ){
                                                        if (jQuery(this).closest('.et_pb_contact_field_radio').find('.radio-label').attr('title') !== "") {
                                                            var cur_value = jQuery(this).closest('.et_pb_contact_field_radio').find('.radio-label').attr('title');
                                                                        } else {
                                                            var cur_value = jQuery(this).closest('.et_pb_contact_field_radio').find('.divi-acf').val();
                                                                        }
                                                        value.push( cur_value );
                                                    });
                                
                                                } else {
                                                    var value = $(this).find('.divi-acf').val();
                                                }

                                                iris_to = $(this).find(".irs-to").text(),
                                                irs_from = $(this).find(".irs-from").text();

                                                if ( Array.isArray( value ) && value.length > 0 ) {
                                                    jQuery.each( value, function(ind, val){
                                                        type_arr.push(type);
                                                        slug_arr.push(slug);
                                                        value_arr.push(val);
                                                        name_arr.push(name);
                                                        filter_param_type_arr.push(filter_param_type);
                                                        iris_to_arr.push(iris_to);
                                                        irs_from_arr.push(irs_from);
                                                    });
                                                } else {
                                                    type_arr.push(type);
                                                    slug_arr.push(slug);
                                                    value_arr.push(value);
                                                    name_arr.push(name);
                                                    filter_param_type_arr.push(filter_param_type);
                                                    iris_to_arr.push(iris_to);
                                                    irs_from_arr.push(irs_from);
                                                }
                                            }

                                        });
                                        
                                        divi_filter_params_array(type_arr, slug_arr, value_arr, name_arr, filter_param_type_arr, iris_to_arr, irs_from_arr);
                                    });

                                    $(document).on('change', '#divi_filter select, #divi_filter input[type=radio], #divi_filter input[type=checkbox], #divi_filter input[type=range]', function() {
                                        var filter_item_name = $(this).data("name"),
                                            filter_item_val = $(this).val();
                                        divi_append_url(filter_item_name, filter_item_val);
                                    });

                                    $('#divi_filter input[type=text]').each(function(i, obj) {
                                        var $input = $(this);
                                    
                                        $input.on('keyup', function (e) {
                                            if ( e.keyCode == 13){
                                                e.preventDefault();
                                                e.stopPropagation();
                                                divi_find_filters_to_filter();
                                                return false;
                                            }
                                        });

                                        $input.on('keydown', function (e) {
                                            if ( e.keyCode == 13){
                                                e.preventDefault();
                                                e.stopPropagation();
                                                return false;
                                            }
                                        });
                                    });
                                });

                            </script>
                    <?php } ?>
                    <?php 
                        $align_reset_class = '';
                        if ($align_reset != 'none') {
                            $align_reset_class = "align_reset_" . $align_reset;
                        }
                    ?>
                    <div class="button_container <?php echo $align_reset_class;?>">
                    <?php if ($filter_update_type == "update_button") { ?>
                        <button id="divi_filter_button" class="et_pb_button button <?php echo esc_attr($align_search_class); ?>" type="button"><?php echo esc_attr($search_button_text); ?></button>
                    <?php } ?>
                        <a class="reset-filters et_pb_button" <?php echo $custom_icon ?> href=""><?php echo $reset_text ?></a>
                    </div>
                            
                </div>

                    <?php if ($filter_update_type == "update_field"): ?>
                            <script>
                                jQuery(document).ready(function($) {

                                    $(document).on('change', '#divi_filter select, #divi_filter input[type=radio], #divi_filter input[type=checkbox], #divi_filter input[type=range]', function() {
                                        if ( jQuery(this).closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) ) {
                                            if ( jQuery(this).closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                                                var filter_param_type = "title";
                                            } else {
                                                var filter_param_type = "no-title";
                                            }
                                            var type = jQuery(this).data('field_type');//closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field ").attr("data-filtertype"),
                                            slug = $(this).data("name"),
                                            name = jQuery(this).closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title").text(),
                                            iris_to = "",
                                            irs_from = "";
                                            if (jQuery(this).is("select")) {
                                                if ($(this).val() !== "") {
                                                var value = $(this).find('option:selected').text().trim();
                                                } else {
                                                    var value = "";
                                                }
                                            } else if (jQuery(this).attr("type") == "radio" || jQuery(this).attr("type") == "checkbox") {
                                                var t_title = $(this).closest(".et_pb_contact_field_radio").find('.radio-label').attr('title');
                                                if ( typeof t_title !== 'undefined' && t_title !== "") {
                                                    var value = $(this).closest(".et_pb_contact_field_radio").find('.radio-label').attr('title').trim();
                                                } else {
                                                    var value = $(this).val().trim();
                                                }
                                            } else {
                                                var value = $(this).val().trim();
                                            }
                                            divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                                        }
                                        if ( !( $(this).closest('.search_filter_cont').hasClass('condition-field') && ($(this).data('type') == 'has-child' || $(this).find('option:selected').data('type') == 'has-child') ) ){
                                            if ( $(this).closest('.search_filter_cont').hasClass('condition-field') ) {
                                                handle_conditional_fields($(this));
                                            }
                                            divi_find_filters_to_filter();
                                        }                       
                                    });


                                    /* timer to check when stopped typing */
                                    var typingTimer;
                                    $('#divi_filter input[type=text]:not(.divi-acf-map)').each(function(i, obj) {
                                        var $input = $(this);
                                        var searchdelay = $input.attr('data-searchdelay');
                                    
                                        $input.on('keyup', function (e) {
                                        clearTimeout(typingTimer);
                                        if ( e.keyCode != 13 && e.keyCode != 9){
                                        typingTimer = setTimeout(doneTyping, searchdelay);
                                        }else{
                                            e.preventDefault();
                                            e.stopPropagation();
                                            divi_find_filters_to_filter();
                                            return false;
                                        }
                                        });
                                    
                                        $input.on('keydown', function (e) {
                                        clearTimeout(typingTimer);
                                        if(e.keyCode == 13) {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            //$(this).trigger("enterKey");
                                            return false;
                                        }
                                        });

                                        function doneTyping () {
                                        divi_find_filters_to_filter();
                                        }
                                    });
                                    /* timer to check when stopped typing */


                                    $('#divi_filter input[type=text]:not(.divi-acf-map)').blur(function() {
                                        clearTimeout(typingTimer);
                                        var cur_value = $(this).val();
                                        if (cur_value != "") {
                                            divi_find_filters_to_filter();
                                        }
                                    });
                                    $('#divi_filter input[type=text]').bind("enterKey",function(e){
                                        divi_find_filters_to_filter();
                                    });

                                    $('.divi-tag-cloud a').click(function( event ) {
                                        event.preventDefault();
                                    });
                                });
                            </script>
                    <?php
                    endif; ?>


                    <?php if (!empty($fullwidth_columns)) {

                        if ($fullwidth_columns_tablet != "auto") {
?>
                            <style>
                                @media (min-width: 768px) and (max-width: 980px) {
                                <?php sprintf('%%order_class%%') ?>.divi-location-fullwidth .divi-filter-containter {
                                    grid-template-columns: repeat(<?php echo esc_html($fullwidth_columns_tablet) ?>, minmax(0, 1fr)) !important;
                                    }
                                }
                            </style>
                            <?php
                        }

                        if ($fullwidth_columns_mobile != "auto") {
?>
                            <style>
                                @media (min-width: 0px) and (max-width: 767px) {
                                <?php sprintf($this->main_css_element) ?>.divi-location-fullwidth .divi-filter-containter {
                                    grid-template-columns: repeat(<?php echo esc_html($fullwidth_columns_mobile) ?>, minmax(0, 1fr)) !important;
                                    }
                                }
                            </style>
                            <?php
                        }

                    }

                    $data = ob_get_clean();

                    return $data;
                }
            }

            new de_df_filter_product_code;
        }
    }

    if (!function_exists('divi_filter_js_enqueue_scripts')) {
        add_action('wp_enqueue_scripts', 'divi_filter_js_enqueue_scripts');

        function divi_filter_js_enqueue_scripts() {
            $ajax_pagination = true;
            if (defined('DE_DB_WOO_VERSION')) {
                $mydata = get_option('divi-bodyshop-woo_options');
                $mydata = unserialize($mydata);

                if (isset($mydata['disable_ajax_pagination']) && $mydata['disable_ajax_pagination'] == '1') {
                    $ajax_pagination = false;
                }
                wp_register_script('divi-filter-js', plugins_url('../../../js/divi-filter.min.js', __FILE__), array(
                    'jquery'
                ), DE_DB_WOO_VERSION);
                wp_register_script('divi-filter-masonry-js', plugins_url('../../../js/masonry.min.js', __FILE__), array(
                    'jquery'
                ), DE_DB_WOO_VERSION);
                wp_register_script('markerclusterer-js', plugins_url('../../../js/markerclusterer.min.js', __FILE__), array(
                    'jquery'
                ), DE_DB_WOO_VERSION);

            }
            else {
                wp_register_script('divi-filter-js', plugins_url('../../../js/divi-filter.min.js', __FILE__), array(
                    'jquery'
                ), DE_DF_VERSION);
                wp_register_script('divi-filter-masonry-js', plugins_url('../../../js/masonry.min.js', __FILE__), array(
                    'jquery'
                ), DE_DF_VERSION);
                wp_register_script('markerclusterer-js', plugins_url('../../../js/markerclusterer.min.js', __FILE__), array(
                    'jquery'
                ), DE_DF_VERSION);
            }

            $ajax_nonce = wp_create_nonce('filter_object');

            wp_localize_script('divi-filter-js', 'filter_ajax_object', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'ajax_pagination' => $ajax_pagination,
                'security' => $ajax_nonce
            ));

            wp_localize_script('markerclusterer-js', 'clusterer_obj', array(
                'imgPath' => plugins_url('../../../images/markerClusterer/m', __FILE__)
            ));
        }
    }
}
