<?php
if ( !function_exists("Divi_filter_item_module_import") ){
    add_action( 'et_builder_ready', 'Divi_filter_item_module_import');

    function Divi_filter_item_module_import(){
        if(class_exists("ET_Builder_Module") && !class_exists("et_pb_df_product_filter_item_code")){

            class et_pb_df_product_filter_item_code extends ET_Builder_Module {

                public $vb_support = 'on';

                public $weight_count = 0;

                public $acf_fields = array();

                public $de_domain_name = '';

                public $acf_map_fields = array();

                protected $module_credits = array(
                    'module_uri' => DE_DF_PRODUCT_URL,
                    'author'     => DE_DF_AUTHOR,
                    'author_uri' => DE_DF_URL,
                );

                function init() {

                    global $wpdb;

                    if (defined('DE_DMACH_VERSION')) {
                    $this->name       = esc_html__( 'Search/Filter Item', 'divi-machine' );
                    $this->advanced_setting_title_text = esc_html__( 'New Search/Filter Item', 'divi-machine' );
                    $this->settings_text               = esc_html__( 'Search/Filter Item Settings', 'divi-machine' );
                    $this->folder_name = 'divi_machine';
                    $this->de_domain_name = 'divi-machine';
                  } else if (defined('DE_DB_WOO_VERSION')) {
                    $this->name       = esc_html__( 'Filter Item', 'divi-bodyshop-woocommerce' );
                    $this->advanced_setting_title_text = esc_html__( 'New Filter Item', 'divi-bodyshop-woocommerce' );
                    $this->settings_text               = esc_html__( 'Filter Item Settings', 'divi-bodyshop-woocommerce' );
                    $this->folder_name = 'divi_bodycommerce';
                    $this->de_domain_name = 'divi-bodyshop-woocommerce';
                  } else {
                      $this->name       = esc_html__( 'Filter Item', 'divi-filter' );
                      $this->advanced_setting_title_text = esc_html__( 'New Filter Item', 'divi-filter' );
                      $this->settings_text               = esc_html__( 'Filter Item Settings', 'divi-filter' );
                      $this->folder_name = 'divi_ajax_filter';
                      $this->de_domain_name = 'divi-filter';
                    }

                    $sql = "SELECT COUNT(*) FROM {$wpdb->posts} a INNER JOIN {$wpdb->postmeta} b ON a.id=b.post_id where a.post_type='product' AND b.meta_key='_weight'";
                    $this->weight_count = $wpdb->get_var($sql);

                    $this->slug = 'et_pb_de_mach_search_posts_item';
                    $this->vb_support      = 'on';
                    $this->type                        = 'child';
                    $this->child_title_var             = 'title';

                    $this->fields_defaults = array(
                    // 'loop_layout'         => array( 'on' ),
                    );

                    if ( class_exists( 'DE_Filter' ) ) {
                        $this->acf_fields = DE_Filter::get_acf_fields();    
                    } else if ( class_exists( 'DEBC_INIT' ) ) {
                        $this->acf_fields = DEBC_INIT::get_acf_fields();
                    } else if ( class_exists( 'DEDMACH_INIT' ) ) {
                        $this->acf_fields = DEDMACH_INIT::get_acf_fields();
                    }
                    

                    $this->acf_map_fields = $this->get_acf_map_fields();

                    $this->settings_modal_toggles = array(
                        'general' => array(
                            'toggles' => array(
                                'main_content' => esc_html__( 'Main', $this->de_domain_name ),
                                'layout' => esc_html__( 'Layout', $this->de_domain_name ),
                                'text_filter' => esc_html__( 'Text', $this->de_domain_name ),
                                'select_filter' => esc_html__( 'Select', $this->de_domain_name ),
                                'tags_filter' => esc_html__( 'Category, Tags &amp; Taxonomy', $this->de_domain_name ),
                                'radio_filter' => esc_html__( 'Checkbox / Radio', $this->de_domain_name ),
                                'range_filter' => esc_html__( 'Range', $this->de_domain_name ),
                                'true_false_filter' => esc_html__( 'True/False', $this->de_domain_name ),
                                'conditional_logic' => esc_html__( 'Conditional Logic', $this->de_domain_name ),
                              ),
                            ),
                            'advanced' => array(
                              'toggles' => array(
                                'text' => array(
                                  'title' => esc_html__( 'Text', $this->de_domain_name ),
                                  'tabbed_subtoggles' => true,
                                  'sub_toggles' => array(
                                    'item' => array(
                                      'name' => 'Item'
                                    ),
                                    'title' => array(
                                      'name' => 'Title'
                                      )
                                      )
                                    ),
                                    'checkbox_radio' => array(
                                      'title' => esc_html__( 'Checkbox / Radio', $this->de_domain_name ),
                                      'tabbed_subtoggles' => true,
                                      'sub_toggles' => array(
                                        'checkbox_radio_style' => array(
                                      'name' => 'Radio / Checkbox Style'
                                    ),
                                    'checkbox_radio_count' => array(
                                      'name' => 'Radio / Checkbox Post Count'
                                    ),
                                    'checkbox_radio_checked' => array(
                                      'name' => 'Radio / Checkbox Checked Style'
                                      )
                                      )
                                    ),
                                'radio_button_style' => array(
                                  'title' => esc_html__( 'Checkbox Style', $this->de_domain_name ),
                                  'tabbed_subtoggles' => true,
                                  'sub_toggles' => array(
                                    'nonchecked_check' => array(
                                      'name' => 'Checkbox Background'
                                    ),
                                    'checked_check' => array(
                                      'name' => 'Selected Checkbox Background'
                                    )
                                  )
                                ),
                                'range' => array(
                                  'title' => esc_html__( 'Range', $this->de_domain_name ),
                                  'tabbed_subtoggles' => true,
                                  'sub_toggles' => array(
                                    'range_primary' => array(
                                      'name' => 'Range Primary'
                                    ),
                                    'range_secondary' => array(
                                      'name' => 'Range Secondary'
                                    )
                                  )
                                ),
                                'show_limit' => array(
                                  'title' => esc_html__( 'Limit Height', $this->de_domain_name ),
                                  'tabbed_subtoggles' => true,
                                  'sub_toggles' => array(
                                    'show_more' => array(
                                      'name' => 'Show More'
                                    ),
                                    'show_less' => array(
                                      'name' => 'Show Less'
                                    )                                    
                                  )
                                ),
                                'select' => esc_html__( 'Select Style', $this->de_domain_name ),
                                'swatch_style_tab' => esc_html__( 'Swatch', $this->de_domain_name ),
                                'collapsible_icon' => esc_html__( 'Collapsible Toggle icon', $this->de_domain_name )
                            )
                        )
                    );

                    $this->main_css_element = '%%order_class%%';

                    $this->advanced_fields = array(
                      'borders'        => array(
                        'default' => array(
                          'css'          => array(
                            'main'      => array(
                              'border_radii'  => '%%order_class%% p.et_pb_contact_field select,%%order_class%% p.et_pb_contact_field input,%%order_class%% .et_pb_contact_field[data-type="radio"], %%order_class%% .et_pb_contact_field[data-type="range"]+.divi-filter-item, %%order_class%% .et_pb_contact_field_options_list.divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                              'border_styles' => '%%order_class%% p.et_pb_contact_field select,%%order_class%% p.et_pb_contact_field input,%%order_class%% .et_pb_contact_field[data-type="radio"], %%order_class%% .et_pb_contact_field[data-type="range"]+.divi-filter-item, %%order_class%% .et_pb_contact_field_options_list.divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                            ),
                            'important' => 'plugin_only',
                          ),
                          'label_prefix' => esc_html__( 'Inputs', $this->de_domain_name ),
                        ),
                      ),
                        'fonts' => array(
                            'title' => array(
                                'label'    => esc_html__( 'Item', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_checkbox_select_wrapper .et_pb_contact_field_options_list, %%order_class%%, %%order_class%% input[type=text], %%order_class%% .divi-filter-item, %%order_class%% input[type=text]::-webkit-input-placeholder, %%order_class%% input[type=text]:-moz-placeholder, %%order_class%% input[type=text]::-moz-placeholder, %%order_class%% input[type=text]:-ms-input-placeholder",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'text',
                                'sub_toggle'  => 'item'
                            ),
                            'title_text' => array(
                                'label'    => esc_html__( 'Title', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .et_pb_contact_field_options_title",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'text',
                                'sub_toggle'  => 'title'
                            ),
                            'count_text' => array(
                                'label'    => esc_html__( 'Radio / Checkbox Post Count', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .radio-count",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'checkbox_radio',
                                'sub_toggle' => 'checkbox_radio_count'
                            ),
                            'radio_button_text' => array(
                                'label'    => esc_html__( 'Checkbox / Radio Style', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .et_pb_contact_field_radio label",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'checkbox_radio',
                                'sub_toggle' => 'checkbox_radio_style'
                            ),
                            'radio_button_text_checked' => array(
                                'label'    => esc_html__( 'Checkbox / Radio Checked Style', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .et_pb_contact_field_radio input:checked ~ label",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'checkbox_radio',
                                'sub_toggle' => 'checkbox_radio_checked'
                            ),
                            'range_primary_text' => array(
                                'label'    => esc_html__( 'Range Primary', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .irs-from, %%order_class%% .irs-to, %%order_class%% .irs-single",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'range',
                                'sub_toggle' => 'range_primary'
                            ),
                            'range_secondary_text' => array(
                                'label'    => esc_html__( 'Range Secondary', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .irs-min, %%order_class%% .irs-max",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'range',
                                'sub_toggle' => 'range_secondary'
                            ),
                            'limit_show_more_text' => array(
                                'label'    => esc_html__( 'Limit Show More', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .limit_filter_text.showmore",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'show_limit',
                                'sub_toggle'  => 'show_more'
                            ),
                            'limit_show_less_text' => array(
                                'label'    => esc_html__( 'Limit Show Less', $this->de_domain_name ),
                                'css'      => array(
                                    'main' => "%%order_class%% .limit_filter_text.showless, %%order_class%% .limit_filter_text.showmore",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'show_limit',
                                'sub_toggle'  => 'show_less'
                            ),
                            
                        ),
                        'background' => array(
                            'settings' => array(
                                'color' => 'alpha',
                            ),
                        ),
                        'button' => array(
                          'button' => array(
                              'label' => esc_html__( 'Radio / Checkbox Button', $this->de_domain_name ),
                              'css' => array(
                                  'main' => "{$this->main_css_element} .divi-radio-buttons .et_pb_contact_field_radio label",
                                  'important' => 'all',
                              ),
                              'box_shadow'  => array(
                                  'css' => array(
                                      'main' => "{$this->main_css_element} .divi-radio-buttons .et_pb_contact_field_radio label",
                                      'important' => 'all',
                                  ),
                              ),
                              'margin_padding' => array(
                                  'css'           => array(
                                      'main' => "{$this->main_css_element} .divi-radio-buttons .et_pb_contact_field_radio label",
                                      'important' => 'all',
                                  ),
                              ),
                          ),
                          'active_button' => array(
                          'label' => esc_html__( 'Active Radio / Checkbox Button', $this->de_domain_name ),
                          'css' => array(
                            'main' => "{$this->main_css_element} .divi-radio-buttons .et_pb_contact_field_radio input:checked + label",
                            'important' => 'all',
                          ),
                          'box_shadow'  => array(
                            'css' => array(
                              'main' => ".woocommerce {$this->main_css_element} .divi-radio-buttons .et_pb_contact_field_radio input:checked + label",
                            ),
                          ),
                          ),
                        
                        
                        ),
                        'form_field'           => array(
                            'form_field' => array(
                                'label'         => esc_html__( 'Fields', $this->de_domain_name ),
                                'css'           => array(
                                    'main' => '%%order_class%% .et_pb_contact_select, %%order_class%% input.divi-filter-item, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i, %%order_class%% .et_pb_contact_select.divi-acf-map-radius',
                                    'background_color'       => '%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_checkbox_select_wrapper .et_pb_contact_field_options_list, %%order_class%% input.divi-filter-item, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                                    'background_color_hover' => '%%order_class%% .et_pb_contact_select:hover, %%order_class%% input.divi-filter-item:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:hover + label i, %%order_class%% .et_pb_contact_field[type="radio"]:hover + label i',
                                    'focus_background_color' => '%%order_class%% .et_pb_contact_select:focus, %%order_class%% input.divi-filter-item:focus, %%order_class%% .et_pb_contact_field[type="checkbox"]:active + label i, %%order_class%% .et_pb_contact_field[type="radio"]:active + label i',
                                    'focus_background_color_hover' => '%%order_class%% .et_pb_contact_select:focus:hover, %%order_class%% input.divi-filter-item:focus:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:active:hover + label i, %%order_class%% .et_pb_contact_field[type="radio"]:active:hover + label i',
                                    'placeholder_focus'      => '%%order_class%% p input:focus::-webkit-input-placeholder, %%order_class%% input.divi-filter-item:focus::-webkit-input-placeholder, %%order_class%% p input:focus::-moz-placeholder, %%order_class%% p input:focus:-ms-input-placeholder, %%order_class%% p textarea:focus::-webkit-input-placeholder, %%order_class%% p textarea:focus::-moz-placeholder, %%order_class%% p textarea:focus:-ms-input-placeholder',
                                    'padding'                => '%%order_class%% .et_pb_contact_select, %%order_class%% input.divi-filter-item, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                                    'margin'                 => '%%order_class%% .et_pb_contact_select, %%order_class%% input.divi-filter-item, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                                    'form_text_color'        => '%%order_class%% .et_pb_contact_select, %%order_class%% input.divi-filter-item, %%order_class%% .et_pb_contact_field[type="checkbox"] + label, %%order_class%% .et_pb_contact_field[type="radio"] + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked + label i:before',
                                    'form_text_color_hover'  => '%%order_class%% .et_pb_contact_select:hover, %%order_class%% input.divi-filter-item:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:hover + label, %%order_class%% .et_pb_contact_field[type="radio"]:hover + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:hover + label i:before',
                                    'focus_text_color'       => '%%order_class%% .et_pb_contact_select:focus, %%order_class%% input.divi-filter-item:focus, %%order_class%% .et_pb_contact_field[type="checkbox"]:active + label, %%order_class%% .et_pb_contact_field[type="radio"]:active + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:active + label i:before',
                                    'focus_text_color_hover' => '%%order_class%% .et_pb_contact_select:focus:hover, %%order_class%% input.divi-filter-item:focus:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:active:hover + label, %%order_class%% .et_pb_contact_field[type="radio"]:active:hover + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:active:hover + label i:before',
                                ),

                                'box_shadow'    => false,
                                'border_styles' => false,
                                'font_field'    => array(
                                    'css' => array(
                                        'main'  => implode( ', ', array(
                                            "{$this->main_css_element} input",
                                            "{$this->main_css_element} select",
                                            "{$this->main_css_element} input::placeholder",
                                            "{$this->main_css_element} input::-webkit-input-placeholder",
                                            "{$this->main_css_element} input::-moz-placeholder",
                                            "{$this->main_css_element} input:-ms-input-placeholder",
                                            "{$this->main_css_element} input[type=checkbox] + label",
                                            "{$this->main_css_element} input[type=radio] + label",
                                        ) ),
                                        'hover' => array(
                                            "{$this->main_css_element} input:hover",
                                            "{$this->main_css_element} select:hover",
                                            "{$this->main_css_element} input:hover::placeholder",
                                            "{$this->main_css_element} input:hover::-webkit-input-placeholder",
                                            "{$this->main_css_element} input:hover::-moz-placeholder",
                                            "{$this->main_css_element} input:hover:-ms-input-placeholder",
                                            "{$this->main_css_element} input[type=checkbox]:hover + label",
                                            "{$this->main_css_element} input[type=radio]:hover + label",
                                        ),
                                    ),
                                ),
                                'margin_padding' => array(
                                    'css'        => array(
                                        'main'    => '%%order_class%% .et_pb_contact_field',
                                        'padding' => '%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i, %%order_class%% .et_pb_contact_field[data-type="range"]+.divi-filter-item, %%order_class%% .et_pb_contact_field[data-type="radio"], %%order_class%% input.divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                                        'margin'  => '%%order_class%% .et_pb_contact_select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i, %%order_class%% .et_pb_contact_field[data-type="range"]+.divi-filter-item, %%order_class%% .et_pb_contact_field[data-type="radio"], %%order_class%% input.divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                                    ),
                                    'important' => 'all',
                                ),
                            ),
                        ),
                        'height'         => array(
                            'css' => array(
                                'main' => implode( ', ',
                                    array(
                                        '%%order_class%% input[type=text]',
                                        '%%order_class%% input[type=email]',
                                        '%%order_class%% textarea',
                                        '%%order_class%% [data-type=checkbox]',
                                        '%%order_class%% [data-type=radio]',
                                        '%%order_class%% [data-type=select]',
                                        '%%order_class%% select',
                                    )
                                ),
                            ),
                        ),
                        'box_shadow' => array(
                          'default' => array(),
                          'filter_items' => array(
                              'label' => esc_html__( 'Filter Items', $this->de_domain_name ),
                              'css' => array(
                                  'main' => '%%order_class%% p.et_pb_contact_field select,%%order_class%% p.et_pb_contact_field input,%%order_class%% .et_pb_contact_field[data-type="radio"], %%order_class%% .et_pb_contact_field[data-type="range"]+.divi-filter-item',
                              ),
                          ),
                        ),
                    );

                    $this->custom_css_fields = array( );

                    $this->help_videos = array( );

                }

                public function get_acf_map_fields( ){

                    $acf_fields = array();

                    if ( function_exists( 'acf_get_field_groups' ) ) {
                        $fields_all = get_posts(array(
                            'posts_per_page'   => -1,
                            'post_type'        => 'acf-field',
                            'orderby'          => 'name',
                            'order'            => 'ASC',
                            'post_status'       => 'publish',
                        ));

                        $acf_fields['none'] = 'Please select an ACF field';

                        foreach ( $fields_all as $field ) {

                            $post_content = maybe_unserialize($field->post_content);
                            if ( isset( $post_content['type'] ) && $post_content['type'] == 'google_map' ) {
                                $post_parent = $field->post_parent;
                                $post_parent_name = get_the_title($post_parent);
                                $grandparent = wp_get_post_parent_id($post_parent);
                                $grandparent_name = get_the_title($grandparent);

                                $acf_fields[$field->post_name] = $post_parent_name . " > " . $field->post_title . " - " . $grandparent_name;
                            }

                        }


                        $field_groups = acf_get_field_groups();
                        foreach ( $field_groups as $group ) {
                            // DO NOT USE here: $fields = acf_get_fields($group['key']);
                            // because it causes repeater field bugs and returns "trashed" fields
                            $fields = get_posts(array(
                                'posts_per_page'   => -1,
                                'post_type'        => 'acf-field',
                                'orderby'          => 'name',
                                'order'            => 'ASC',
                                'suppress_filters' => true, // DO NOT allow WPML to modify the query
                                'post_parent'      => $group['ID'],
                                'post_status'       => 'publish',
                                'update_post_meta_cache' => false
                            ));

                            foreach ( $fields as $field ) {

                                $post_content = maybe_unserialize($field->post_content);
                                if ( isset( $post_content['type'] ) && $post_content['type'] == 'google_map' ) {
                                    $acf_fields[$field->post_name] = $field->post_title . " - " . $group['title'];
                                }

                            }
                        }
                    }

                    return $acf_fields;
                }

                function get_fields() {

                    global $wpdb;

                    $et_accent_color = et_builder_accent_color();

                    ///////////////////////////////

                    $filter_post_type = array(
                        'category'          => 'Category',
                        'tags'    => 'Tags',
                        'search'          => 'Search Text',
                        'taxonomy'          => 'Custom Taxonomy',
                        'custom_meta'       => 'Custom Post Meta'
                        // 'posttypes'          => 'Post Type Select (Search only)',
                    );

                    if ( function_exists( 'acf_get_field_groups' ) ){
                        $filter_post_type['acf'] = 'Advanced Custom Field (ACF Plugin)';
                        $filter_post_type['acf_map'] = 'Map Radius Search (ACF Plugin)';
                    }

                    $productattr = array();

                    if ( class_exists('WooCommerce') ){
                        $filter_post_type['productattr'] = 'Product Attributes';
                        $attribute_taxonomies = wc_get_attribute_taxonomies();
                        $productattr['none'] = 'Please select an Product Attribute';
                        if ( $attribute_taxonomies ) {
                            foreach ( $attribute_taxonomies as $tax ) {
                                $productattr[esc_attr( wc_attribute_taxonomy_name( $tax->attribute_name ) )] = esc_html( $tax->attribute_label );
                            }
                        }
                        $filter_post_type['stock_status'] = 'Stock Status';
                        $filter_post_type['productprice'] = 'Product Price';

                        if ( $this->weight_count > 0 ){
                            $filter_post_type['productweight']  = 'Product Weight';
                        }
                        $filter_post_type['productrating'] = 'Product Rating';
                    }

                    $fields = array(

                        //////////////////////////////////////////////////
                        /* MAIN OPTIONS */
                        //////////////////////////////////////////////////

                        'title' => array(
                            'label'           => esc_html__( 'Admin Filter Name', $this->de_domain_name ),
                            'type'            => 'text',
                            'description'     => esc_html__( 'Change the name of the filter for admin purposes ONLY, this is just used so you can see what the filter is.', $this->de_domain_name ),
                            'toggle_slug'     => 'main_content',
                            'dynamic_content' => 'text',
                            'option_category' => 'configuration',
                        ),
                        'filter_post_type' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'What do you want to search/filter?', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => $filter_post_type,
                            'default'           => 'category',
                            'affects'         => array(
                                'text_placeholder',
                                'is_number_input',
                                'custom_meta_name',
                                'acf_name',
                                'acf_map_name',
                                'acf_map_radius_unit',
                                'acf_map_radius_select',
                                'acf_map_fields_inline',
                                'radius_field_placeholder',
                                'radius_field_value',
                                'select_options',
                                'custom_tax_choose',
                                'product_attribute',
                                'attribute_swatch',
                                'post_type_choose',
                                'acf_filter_type',
                                'cat_tag_display_mode',
                                'max_price_type',
                                'taxonomy_order',
                                'tax_sub_prefix'
                            ),
                            'computed_affects' => array(
                              '__acf'
                            ),
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Choose what you want to search or filter', $this->de_domain_name ),
                        ),
                        'text_typing_timeout' => array(
                          'toggle_slug'       => 'main_content',
                          'label'             => esc_html__( 'Typing delay to filter', $this->de_domain_name ),
                          'type'              => 'range',
                          'option_category'   => 'configuration',
                          'default'   => '2000',
                          'show_if' => [
                              'filter_post_type' => [ 'search' ],
                          ],
                          'range_settings'  => array(
                              'min'  => '0',
                              'max'  => '15000',
                              'step' => '1',
                          ),
                          'description'       => esc_html__( 'Choose the delay it takes for the person to stop typing, for the filter to start searching.', $this->de_domain_name ),
                        ),
                        'custom_tax_choose' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Choose Your Taxonomy', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => get_taxonomies( array( '_builtin' => FALSE ) ),
                            'option_category'   => 'configuration',
                            'default'           => '',
                            'depends_show_if'  => 'taxonomy',
                            'description'       => esc_html__( 'Choose the custom taxonomy that you have made and want to filter', $this->de_domain_name ),
                        ),
                        'post_type_choose' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Post Type', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => et_get_registered_post_type_options( false, false ),
                            'option_category'   => 'configuration',
                            'default'           => 'post',
                            'description'       => esc_html__( 'Choose the post type that you want to filter', $this->de_domain_name ),
                            'show_if' => [
                                'filter_post_type' => [ 'category', 'tags', 'search', 'taxonomy', 'posttypes', 'acf', 'custom_meta' ],
                            ],
                        ),
                        'custom_meta_name'      => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Custom Meta Name', $this->de_domain_name),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'           => '',
                            'depends_show_if'   => 'custom_meta',
                            'description'       => esc_html__( 'Custom Meta Name for filtering.', $this->de_domain_name ),
                        ),
                        'acf_name' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'ACF Name', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => $this->acf_fields,
                            'default'           => 'none',
                            'depends_show_if'   => 'acf',
                            'option_category'   => 'configuration',
                            'computed_affects' => array(
                              '__acf'
                            ),
                            'description'       => esc_html__( 'Choose the ACF item that you want to filter by. Make sure it belongs to the post type you have/want to filter. It cannot be inside a group or repeater type. ', $this->de_domain_name ),
                        ),
                        'acf_map_name' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'ACF Map Name', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => $this->acf_map_fields,
                            'default'           => 'none',
                            'depends_show_if'   => 'acf_map',
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Choose the ACF Map item that you want to filter by. Make sure it belongs to the post type you have/want to filter. It cannot be inside a group or repeater type. ', $this->de_domain_name ),
                        ),
                        'radius_field_placeholder'      => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Radius Field Placeholder', $this->de_domain_name),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'           => 'Enter Radius',
                            'depends_show_if'   => 'acf_map',
                            'description'       => esc_html__( 'Input the placeholder text for your radius field.', $this->de_domain_name ),
                        ),
                        'radius_field_value'      => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Radius Field Value', $this->de_domain_name),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'           => '10',
                            'depends_show_if'   => 'acf_map',
                            'description'       => esc_html__( 'Input the placeholder text for your radius field.', $this->de_domain_name ),
                        ),
                        'acf_map_radius_unit'  => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'ACF Map Radius Unit', $this->de_domain_name),
                            'type'              => 'select',
                            'options'           => array(
                                'km'            => esc_html__( 'Km', $this->de_domain_name ),
                                'mi'            => esc_html__( 'Mile', $this->de_domain_name ),
                            ),
                            'default'           => 'km',
                            'depends_show_if'   => 'acf_map',
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Choose the Unit of the radius for search by address or zip code.', $this->de_domain_name ),
                        ),
                        'acf_map_fields_inline' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Place Map Search Fields inline?', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'options'   => array(
                                'on'    => esc_html__( 'Yes', $this->de_domain_name ),
                                'off'   => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default'           => 'on',
                            'depends_show_if'   => 'acf_map',
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'If you want to display Address Field and Radius Field in one row, enable this.', $this->de_domain_name ),
                        ),
                        'acf_map_radius_select' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Make Radius Field as Dropdown?', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'options'   => array(
                                'on'    => esc_html__( 'Yes', $this->de_domain_name ),
                                'off'   => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default'           => 'on',
                            'depends_show_if'   => 'acf_map',
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'If you want to radius field in dropdown box, enable this.', $this->de_domain_name ),
                            'affects'           => array(
                                'acf_map_radius_select_values'
                            )
                        ),
                        'acf_map_radius_select_values'      => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Radius Field Dropdown Values', $this->de_domain_name),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'           => '1,2,5,10,20,50,100',
                            'depends_show_if'   => 'on',
                            'description'       => esc_html__( 'Enable this to show only subcategories of selected or current category.', $this->de_domain_name ),
                        ),
                        'product_attribute' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Product Attributes', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => $productattr,
                            'default'           => 'none',
                            'depends_show_if'   => 'productattr',
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Add the name of the Product Attribute you want to display here', $this->de_domain_name ),
                        ),
                        'attribute_swatch' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Show Attributes Swatches', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'options'   => array(
                                'on'    => esc_html__( 'Yes', $this->de_domain_name ),
                                'off'   => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default'           => 'off',
                            'show_if'      => array(
                                'filter_post_type' => ['productattr', 'productrating']
                            ),
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'If you want to display swatches on the filter, check this option. Filter type will be ignored if this option is on.', $this->de_domain_name ),
                        ),
                        'acf_filter_type' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Filter Type', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'select'        => 'Select',
                                'number_range'  => 'Number / Range',
                                'radio'         => 'Checkbox / Radio Buttons'
                            ),
                            'default'           => 'select',
                            'show_if_not'           => array(
                                'filter_post_type' => ['productprice', 'search', 'acf_map'],
                                'attribute_swatch' => 'on'
                            ),

                            'affects'         => array(
                                'default_num',
                            ),
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Choose how you want the filter to be displayed', $this->de_domain_name ),
                        ),
                        'range_type' => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Range Type', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'none'        => 'Select',
                                'single'        => 'Single',
                                'double'        => 'Double'
                            ),
                            'default'           => 'none',
                            'show_if'           => array(
                                'acf_filter_type' => ['number_range'],
                            ),
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Choose how the range type you want', $this->de_domain_name ),
                        ),
                        'min_price_type'      => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Min Price Setting', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'store'         => 'Min of Store',
                                'category'      => 'Min of current category (Category Page Only)',
                                'custom'        => 'Custom (Specify in Range Filter Options Tab Below)'
                            ),
                            'show_if'      => array(
                                'filter_post_type' => ['productprice']
                            ),
                            'default'           => 'store',
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Choose how you want the get min price in price range.', $this->de_domain_name ),  
                        ),
                        'max_price_type'      => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Max Price Setting', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'store'         => 'Max of Store',
                                'category'      => 'Max of current category (Category Page Only)',
                                'custom'        => 'Custom (Specify in Range Filter Options Tab Below)'
                            ),
                            'show_if'      => array(
                                'filter_post_type' => ['productprice']
                            ),
                            'default'           => 'store',
                            'option_category'   => 'configuration',
                            'description'       => esc_html__( 'Choose how you want the get max price in price range.', $this->de_domain_name ),  
                        ),
                        'value_type'    => array(
                              'toggle_slug'       => 'main_content',
                              'label'             => esc_html__( 'Filter Value Type', $this->de_domain_name ),
                              'type'              => 'select',
                              'options'           => array(
                                'string'      => 'String',
                                'numeric'     => 'Numeric',
                                'decimal'      => 'Numeric with decimal',
                              ),
                              'default'           => 'string',
                              'show_if_not'           => array(
                                  'filter_post_type'    => ['productprice', 'search', 'acf_map'],
                                  'acf_filter_type'     => 'number_range',
                                  'attribute_swatch'    => 'on'
                              ),
                              'option_category'   => 'configuration',
                              'description'       => esc_html__( 'Select the type of filter you are using - for example if it is a select or radio filter - it should be a string. If you are using a range or number filter, you need to choose either numeric or with decimal depending on how you have your numbers formatted.', $this->de_domain_name ),  
                        ),
                        'taxonomy_order'    => array(
                              'toggle_slug'       => 'tags_filter',
                              'label'             => esc_html__( 'Category/Tag/Taxonomy Terms Order', $this->de_domain_name ),
                              'type'              => 'select',
                              'options'           => array(
                                'id'              => 'ID',
                                'name'            => 'Name',
                                'menu_order'      => 'Menu Order',
                                'numeric'         => 'Name(Include number)'
                              ),
                              'default'           => 'name',
                              'show_if'           => array(
                                  'filter_post_type' => ['category', 'tags', 'taxonomy', 'acf', 'productattr', 'custom_meta']
                              ),
                              'option_category'   => 'configuration',
                              'description'       => esc_html__( 'Select SortBy option for Category/Tag/Taxonomy/ACF/Meta Filter options.', $this->de_domain_name ),  
                        ),
                        'tax_sub_prefix'      => array(
                            'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Sub Taxonomy Prefix', $this->de_domain_name),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'           => '--',
                            'show_if'       => array(
                                'filter_post_type' => ['taxonomy']
                            ),
                            'description'       => esc_html__( 'Enable this to show only subcategories of selected or current category.', $this->de_domain_name ),
                        ),
                        'filter_params' => array(
                          'toggle_slug'       => 'layout',
                          'label'             => esc_html__( 'Show Filter Parameters', $this->de_domain_name ),
                          'type'              => 'select',
                          'options'           => array(
                            'no'        => 'No',
                            'yes_title'        => 'Yes with title',
                            'yes_no_title'        => 'Yes without title, just the value',
                          ),
                          'default'           => 'no',
                          'option_category'   => 'configuration',
                          'description'       => esc_html__( 'If you want to have the filter selections show up above the archive loop so the customer can see and remove them, enable this.', $this->de_domain_name ),
                        ),
                        'include_option' => array(
                          'toggle_slug'       => 'main_content',
                          'label'             => esc_html__( 'Include Options', $this->de_domain_name ),
                          'type'              => 'text',
                          'default'           => '',
                          'option_category'   => 'configuration',
                          'show_if'           => array(
                            'filter_post_type' => array(
                              'category',
                              'tags',    
                              'taxonomy',          
                              'acf',
                              'custom_meta'
                            )
                          ),
                          'description'       => esc_html__( 'Input option values you want to include only for filter - comma seperated for multiple values.', $this->de_domain_name ),
                        ),
                        'exclude_option' => array(
                          'toggle_slug'       => 'main_content',
                          'label'             => esc_html__( 'Exclude Options', $this->de_domain_name ),
                          'type'              => 'text',
                          'default'           => '',
                          'option_category'   => 'configuration',
                          'show_if'           => array(
                            'filter_post_type' => array(
                              'category',
                              'tags',    
                              'taxonomy',          
                              'acf',
                              'custom_meta'
                            )
                          ),
                          'description'       => esc_html__( 'Input option values you want to exclude from filter - comma seperated for multiple values.', $this->de_domain_name ),
                        ),
                        'radio_show_count' => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Display filter count?', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'option_category'   => 'configuration',
                            'options'           => array(
                                'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                                'off' => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default'   => 'off',
                            'show_if_not'   => array(
                              'filter_post_type' => 'search',
                              'acf_filter_type' => ['select', 'number_range']
                            ),
                            'description'       => esc_html__( 'Choose if you want to show the filter count for every option.', $this->de_domain_name ),
                        ),
                        
                      'radio_show_count_dis_top' => array(
                        'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Filter Count Distance from Top', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category'   => 'configuration',
                        'default'   => '0px',
                        'default_unit'    => 'px',
                        'show_if'   => array(
                          'radio_show_count' => 'on',
                          // 'acf_filter_type' => 'radio'
                        ),
                        'description'       => esc_html__( 'Specify the distance from the top for the count.', $this->de_domain_name ),
                      ),

                        
                        'show_label' => array(
                            'label' => esc_html__( 'Show Label', $this->de_domain_name ),
                            'type' => 'yes_no_button',
                            'options_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__( 'Yes', $this->de_domain_name ),
                                'off' => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'affects' => array(
                                'custom_label'
                            ),
                            'default' => 'on',
                            'description' => esc_html__( 'Enable or disable the label.', $this->de_domain_name ),
                            'toggle_slug'       => 'layout',
                        ),
                        'custom_label' => array(
                          'toggle_slug'       => 'main_content',
                            'label'             => esc_html__( 'Custom label (leave blank for default label)', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'depends_show_if'   => 'on',
                            'description'       => esc_html__( 'Add a custom label here or leave it blank to get the default label.', $this->de_domain_name ),
                        ),
                        'radio_show_empty' => array(
                          'toggle_slug'       => 'main_content',
                          'label'             => esc_html__( 'Display empty filter option? (Select/Radio/Checkbox Only)', $this->de_domain_name ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'configuration',
                          'options'           => array(
                              'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                              'off' => esc_html__( 'No', $this->de_domain_name ),
                          ),
                          'default'   => 'off',
                          'show_if_not'   => array(
                            'filter_post_type' => 'search',
                            'acf_filter_type' => ['number_range']
                          ),
                          'description'       => esc_html__( 'Choose if you want to show empty filter options.', $this->de_domain_name ),
                      ),
                      
                      'only_show_avail' => array(
                        'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Only show available Options on Load? (archive/category pages only)', $this->de_domain_name ),
                        'type'              => 'yes_no_button',
                        'option_category'   => 'configuration',
                        'options'           => array(
                          'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                          'off' => esc_html__( 'No', $this->de_domain_name ),
                        ),
                        'show_if_not'   => array(
                          'filter_post_type' => 'search',
                          'acf_filter_type' => ['number_range']
                        ),
                        'default'   => 'off',
                        'description'       => esc_html__( 'If you want to show only the categories, tags or custom taxonomies that are linked to the posts queried on the page - enable this', $this->de_domain_name ),
                      ),

                      'hide_module_for_empty'   => array(
                        'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Hide the module when filter has no options', $this->de_domain_name ),
                        'type'              => 'yes_no_button',
                        'option_category'   => 'configuration',
                        'options'           => array(
                          'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                          'off' => esc_html__( 'No', $this->de_domain_name ),
                        ),
                        'show_if_not'   => array(
                          'acf_filter_type' => ['number_range']
                        ),
                        'default'   => 'off',
                        'description'       => esc_html__( 'If you want to hide the whole module when there is no options avaliable - enable this', $this->de_domain_name ),
                      ),

                        //////////////////////////////////////////////////
                        /* LAYOUT OPTIONS */
                        //////////////////////////////////////////////////

                        'acf_filter_width' => array(
                          'toggle_slug'       => 'layout',
                          'label'             => esc_html__( 'Filter Width', $this->de_domain_name ),
                          'type'              => 'select',
                          'options'           => array(
                              'et_pb_column_4_4'        => 'Full (4/4)',
                              'et_pb_column_3_4'        => 'Three Quarter (3/4)',
                              'et_pb_column_2_3'        => 'Two Thirds (2/3)',
                              'et_pb_column_1_2'        => 'Half (1/2)',
                              'et_pb_column_1_3'        => 'Third (1/3)',
                              'et_pb_column_1_4'        => 'Quarter (1/4)',
                          ),
                          'default'           => 'et_pb_column_4_4',
                          'option_category'   => 'configuration',
                          'description'       => esc_html__( 'Choose the width of the filter', $this->de_domain_name ),
                      ),

                      //////////////////////////////////////////////////
                        /* RANGE FILTER */
                        //////////////////////////////////////////////////


                      'range_hide_min_max' => array(
                        'toggle_slug'       => 'range_filter',
                        'label'             => esc_html__( 'Range Hide Min and Max Labels', $this->de_domain_name ),
                        'type'              => 'yes_no_button',
                        'option_category'   => 'configuration',
                        'options'           => array(
                            'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                            'off' => esc_html__( 'No', $this->de_domain_name ),
                        ),
                        'default'   => 'off',
                        'show_if'   => array(
                          // 'filter_post_type' => 'productprice',
                          // 'acf_filter_type' => 'number_range'
                        )
                      ),
                      'range_hide_from_to' => array(
                          'toggle_slug'       => 'range_filter',
                          'label'             => esc_html__( 'Range Hide From and To Labels', $this->de_domain_name ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'configuration',
                          'options'           => array(
                              'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                              'off' => esc_html__( 'No', $this->de_domain_name ),
                          ),
                          'default'   => 'off',
                          'show_if'   => array(
                            // 'filter_post_type' => 'productprice',
                            // 'acf_filter_type' => 'number_range'
                          )
                      ),
                        'range_number_custom' => array(
                          'toggle_slug'       => 'range_filter',
                          'label'             => esc_html__( 'Range Values Type', $this->de_domain_name ),
                          'type'              => 'select',
                          'options'           => array(
                              'default'       => esc_html__( 'Default (From and To)', $this->de_domain_name ),
                              'from_acf'      => esc_html__( 'From ACF Value (From and To)', $this->de_domain_name ),
                              'custom'       => esc_html__( 'Custom Values', $this->de_domain_name ),
                          ),
                          // 'show_if'   => array(
                          //   'acf_filter_type' => 'radio'
                          // ),
                          'option_category'   => 'configuration',
                          'default'           => 'default',
                          'description'       => esc_html__( 'Most will be default - but if you want to set your own numbers and pattern, enable custom', $this->de_domain_name ),
                      ),
                        'range_from' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Range From Number', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => '100',
                            'show_if'       => array ('range_number_custom' => array('default', 'custom') ),
                            'description'       => esc_html__( 'Choose the default from number.', $this->de_domain_name ),
                        ),
                        'range_to' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Range To Number', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => '800',
                            'show_if'       => array ('range_number_custom' => array('default', 'custom') ),
                            'description'       => esc_html__( 'Choose the default to number.', $this->de_domain_name ),
                        ),
                        'range_custom_values' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Set your Custom Values', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => '0, 10, 100, 1000, 10000, 100000, 1000000',
                            'description'       => esc_html__( 'Add your custom values steps - comma seperated. BE CAREFUL - You have to have the from and to numbers above as one of these numbers in the comma seperated list for us to add the default values', $this->de_domain_name ),
                            'show_if'       => array ('range_number_custom' => 'custom'),
                        ),
                        'range_breakpoint' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Range Breakpointer', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'           => '',
                            'description'       => esc_html__( 'Input the number to break the range slider(Other max values will be represented to Breakpoint value +, ex:50+).', $this->de_domain_name ),
                        ),
                        'range_step' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Number / Range Step', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => '1',
                            'description'       => esc_html__( 'Choose the number it steps up.', $this->de_domain_name ),
                        ),
                        'range_skin' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Number / Range Appearance Style', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'flat'       => esc_html__( 'Flat', $this->de_domain_name ),
                                'big'       => esc_html__( 'Big', $this->de_domain_name ),
                                'modern'       => esc_html__( 'Modern', $this->de_domain_name ),
                                'sharp'       => esc_html__( 'Sharp', $this->de_domain_name ),
                                'round'       => esc_html__( 'Round', $this->de_domain_name ),
                                'square'       => esc_html__( 'Square', $this->de_domain_name ),
                            ),
                            'option_category'   => 'configuration',
                            'default'           => 'flat',
                            'description'       => esc_html__( 'Choose the appearance style of the slider', $this->de_domain_name ),
                        ),
                        'range_prim_color' => array(
                            'label' => esc_html__('Range Primary Color', $this->de_domain_name) ,
                            'type'              => 'color-alpha',
                            'priority'          => '1',
                            'custom_color'      => true,
                            'default'           => '#2ea3f2',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'range',
                            'sub_toggle'        => 'range_primary',
                            'option_category'   => 'configuration'
                            // 'show_if'   => array(
                            //   'filter_post_type' => 'productprice',
                            //   'acf_filter_type' => 'number_range'
                            // ),
                        ),
                        'range_sec_color' => array(
                            'label' => esc_html__('Range Secondary Color', $this->de_domain_name) ,
                            'type'              => 'color-alpha',
                            'priority'          => '1',
                            'custom_color'      => true,
                            'default'           => '#efefef',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'range',
                            'sub_toggle'        => 'range_secondary',
                            'option_category'   => 'configuration',
                            'show_if'   => array(
                              // 'filter_post_type' => 'productprice',
                              // 'acf_filter_type' => 'number_range'
                            )
                        ),
                        'range_prettify_enabled' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Number / Range Prettify', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'option_category'   => 'configuration',
                            'options'           => array(
                                'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                                'off' => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default'   => 'on',
                            // 'show_if'   => array(
                            //   'filter_post_type' => 'productprice',
                            //   'acf_filter_type' => 'number_range'
                            // ),
                            'description'       => esc_html__( 'Enable this if you want to pretify your text, improve readibility of long numbers. 10000000 → 10 000 000', $this->de_domain_name ),
                        ),
                        'range_prettify_separator' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Number / Range Prettify Separator', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => ' ',
                            'description'       => esc_html__( 'Set up your own separator for long numbers. 10 000, 10.000, 10-000 etc.', $this->de_domain_name ),
                        ),
                        'range_prefix' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Number / Range Before Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => '',
                            'description'       => esc_html__( 'Set the text for values. Will be set up right before the number: $100', $this->de_domain_name ),
                        ),
                        'range_postfix' => array(
                            'toggle_slug'       => 'range_filter',
                            'label'             => esc_html__( 'Number / Range After Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => '',
                            'description'       => esc_html__( 'Set the text for values. Will be set up right after the number: 100k', $this->de_domain_name ),
                        ),
                        'true_text' => array(
                            'toggle_slug'       => 'true_false_filter',
                            'label'             => esc_html__( 'True Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => 'Yes',
                            'description'       => esc_html__( 'Set the text you want to appear when it is "true"', $this->de_domain_name ),
                            'show_if'           => array(
                              'filter_post_type' => 'acf'
                            )
                          ),
                        'false_text' => array(
                            'toggle_slug'       => 'true_false_filter',
                            'label'             => esc_html__( 'False Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => 'No',
                            'description'       => esc_html__( 'Set the text you want to appear when it is "false"', $this->de_domain_name ),
                            'show_if'           => array(
                              'filter_post_type' => 'acf'
                            )
                          ),



                        //////////////////////////////////////////////////
                        /* CONDITIONAL LOGIC */
                        //////////////////////////////////////////////////
                        
                        'field_id'                   => array(
                            'label'            => esc_html__( 'Logic ID', $this->de_domain_name ),
                            'type'             => 'text',
                            'description'      => esc_html__( 'Define the unique ID of this field. You should use only English characters without special characters and spaces.', $this->de_domain_name ),
                            'toggle_slug'      => 'conditional_logic',
                            'default_on_front' => '',
                            'option_category'  => 'layout',
                        ),
                        'field_title' => array(
                            'label'           => esc_html__( 'Logic Title', $this->de_domain_name ),
                            'type'            => 'text',
                            'description'     => esc_html__( 'Change the name of the filter for admin purposes ONLY, this is just used so you can see what the filter is.', $this->de_domain_name ),
                            'toggle_slug'     => 'conditional_logic',
                            'dynamic_content' => 'text',
                            'option_category' => 'layout',
                        ),
                        'conditional_logic'          => array(
                            'label'           => esc_html__( 'Enable', $this->de_domain_name ),
                            'type'            => 'yes_no_button',
                            'option_category' => 'layout',
                            'default'         => 'off',
                            'options'         => array(
                                'on'  => esc_html__( 'Yes' ),
                                'off' => esc_html__( 'No' ),
                            ),
                            'affects'         => array(
                                'conditional_logic_rules',
                                'conditional_logic_relation',
                            ),
                            'description'     => et_get_safe_localization( __( 'Enabling conditional logic makes this field only visible when any or all of the rules below are fulfilled<br><strong>Note:</strong> Only fields with an unique and non-empty field ID can be used', $this->de_domain_name ) ),
                            'toggle_slug'     => 'conditional_logic',
                        ),
                        'conditional_logic_relation' => array(
                            'label'           => esc_html__( 'Relation', $this->de_domain_name ),
                            'type'            => 'yes_no_button',
                            'option_category' => 'layout',
                            'options'         => array(
                                'on'  => esc_html__( 'All', $this->de_domain_name ),
                                'off' => esc_html__( 'Any', $this->de_domain_name ),
                            ),
                            'default'         => 'off',
                            'button_options'  => array(
                                'button_type' => 'equal',
                            ),
                            'depends_show_if' => 'on',
                            'description'     => esc_html__( 'Choose whether any or all of the rules should be fulfilled', $this->de_domain_name ),
                            'toggle_slug'     => 'conditional_logic',
                        ),
                        'conditional_logic_rules'    => array(
                            'label'           => esc_html__( 'Rules', $this->de_domain_name ),
                            'type'            => 'conditional_logic',
                            'option_category' => 'layout',
                            'depends_show_if' => 'on',
                            'toggle_slug'     => 'conditional_logic',
                        ),

                        
                        //////////////////////////////////////////////////
                        /* TEXT FILTER */
                        //////////////////////////////////////////////////


                        'text_placeholder' => array(
                            'toggle_slug'       => 'text_filter',
                            'label'             => esc_html__( 'Placeholder Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'show_if'      => array(
                                'filter_post_type' => ['search', 'acf_map']
                            ),
                            'default'           => "Search...",
                            'description'       => esc_html__( 'Add the placeholder for the text input.', $this->de_domain_name ),
                        ),
                        'is_number_input' => array(
                            'toggle_slug'       => 'text_filter',
                            'label'             => esc_html__( 'Make text a number input?', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'option_category'   => 'configuration',
                            'show_if'      => array(
                                'filter_post_type' => ['search', 'acf_map']
                            ),
                            'options'           => array(
                                'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                                'off' => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default'   => 'off',
                            'description'       => esc_html__( 'If you want the text input to be a number input (only numeric) - enable this', $this->de_domain_name ),
                        ),

                        //////////////////////////////////////////////////
                        /* SELECT FILTER */
                        //////////////////////////////////////////////////                        

                        'select2' => array(
                          'toggle_slug' => 'select_filter',
                          'label' => esc_html__( 'Enable Select2? (make sure to enable in Filter Module too)', $this->de_domain_name ),
                          'type' => 'yes_no_button',
                          'option_category' => 'configuration',
                          'options' => array(
                              'on' => esc_html__( 'Yes', $this->de_domain_name ),
                              'off' => esc_html__( 'No', $this->de_domain_name ),
                          ),
                          'default' => 'off',
                          'description' => esc_html__( 'If you want this filter to have Select2 - enable this.', $this->de_domain_name ),
                          'show_if_not' => array(
                            'acf_filter_type' => array(
                              'radio',
                              'number_range'
                            ),
                            'attribute_swatch' => 'on',
                            'filter_post_type' => 'productprice'
                          )
                      ),

                        'select_placeholder' => array(
                            'toggle_slug'       => 'select_filter',
                            'label'             => esc_html__( 'First Option Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => esc_html__('-- Select Option --', $this->de_domain_name),
                            'show_if_not' => array(
                              'acf_filter_type' => array(
                                'radio',
                                'number_range'
                              ),
                              'attribute_swatch' => 'on',
                              'filter_post_type' => 'productprice'
                            ),
                            'description'       => esc_html__( 'Choose what the first option of the select option will be.', $this->de_domain_name ),
                        ),

                        //////////////////////////////////////////////////
                        /* RADIO FILTER */
                        //////////////////////////////////////////////////

                        'radio_select' => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Checkbox / Radio Button Functionality', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'radio'       => esc_html__( 'Choose One', $this->de_domain_name ),
                                'checkbox'       => esc_html__( 'Multiple Select', $this->de_domain_name ),
                            ),
                            'option_category'   => 'configuration',
                            'default'           => 'radio',
                            'affects'           => array(
                                'filter_condition'
                            ),
                            'show_if_not'   => array(
                              'filter_post_type' => 'search',
                              'acf_filter_type' => ['select', 'number_range']
                            ),
                            'description'       => esc_html__( 'Choose the style of your radio buttons', $this->de_domain_name ),
                        ),
                        'radio_deselect' => array(
                            'toggle_slug' => 'radio_filter',
                            'label' => esc_html__('Enable Deselect of Radio Button?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ) ,
                            'default' => 'off',
                            'show_if_not' => array(
                                'filter_post_type' => 'search',
                                'acf_filter_type' => ['select',
                                'number_range']
                            ) ,
                            'show_if' => array(
                                'radio_select' => 'radio'
                            ) ,
                            'description' => esc_html__('If you are using radio buttons you cannot deselect it by default, enable this to disable the radio when you click the checked one.', $this->de_domain_name) ,
                        ),
                        'filter_condition' => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Filter combination option for Multiple selection', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'or'            => esc_html__( 'OR', $this->de_domain_name ),
                                'and'           => esc_html__( 'AND', $this->de_domain_name ),
                            ),
                            'option_category'   => 'configuration',
                            'default'           => 'or',
                            'depends_show_if'   => 'checkbox',
                            'description'       => esc_html__( 'Filter option for multiselected options.', $this->de_domain_name ),
                        ),
                        'radio_style' => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Checkbox / Radio Style', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'normal'       => esc_html__( 'Normal', $this->de_domain_name ),
                                'tick_box'       => esc_html__( 'Divi Style', $this->de_domain_name ),
                                'buttons'       => esc_html__( 'Buttons', $this->de_domain_name ),
                                'select'       => esc_html__( 'Select Drop Down', $this->de_domain_name ),
                            ),
                            'show_if_not'   => array(
                              'filter_post_type' => 'search',
                              'acf_filter_type' => ['select', 'number_range']
                            ),
                            'affects'           => array(
                              'select_labeltext'
                            ),
                            'option_category'   => 'configuration',
                            'default'           => 'normal',
                            'description'       => esc_html__( 'Choose the style of your radio buttons', $this->de_domain_name ),
                        ),
                        'select_labeltext' => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Select Label Text', $this->de_domain_name ),
                            'type'              => 'text',
                            'option_category'   => 'configuration',
                            'default'   => esc_html__('-- Select Option --', $this->de_domain_name),
                            'depends_show_if'   => 'select',
                            'description'       => esc_html__( 'Choose what the first option of the select option will be.', $this->de_domain_name ),
                        ),
                        'radio_choice' => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Checkbox or Radio?', $this->de_domain_name ),
                            'type'              => 'select',
                            'options'           => array(
                                'radio'       => esc_html__( 'Radio', $this->de_domain_name ),
                                'check'       => esc_html__( 'Check', $this->de_domain_name ),
                            ),
                            'show_if'   => array(
                              'radio_select' => 'radio',
                              'radio_style' => 'tick_box'
                            ),
                            'option_category'   => 'configuration',
                            'default'           => 'radio',
                            'description'       => esc_html__( 'Choose whether you want radio or checkboxes', $this->de_domain_name ),
                        ),
                        'radio_inline' => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Display Checkbox / Radio Inline?', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'option_category'   => 'configuration',
                            'options'           => array(
                                'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                                'off' => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'default'   => 'off',
                            'show_if_not'   => array(
                              'filter_post_type' => 'search',
                              'acf_filter_type' => ['select', 'number_range']
                            ),
                            'affects'         => array(
                                'radio_gap',
                            ),
                            'description'       => esc_html__( 'Choose if you want the checkboxes to be inline or on their own line', $this->de_domain_name ),
                        ),

                      'radio_gap' => array(
                        'toggle_slug'       => 'radio_filter',
                        'label'             => esc_html__( 'Gap Between each item', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category'   => 'configuration',
                        'default'   => '20',
                        'depends_show_if'   => 'on',
                        'description'       => esc_html__( 'Specify the gap you want between each item that is inline.', $this->de_domain_name ),
                      ),
                        'hide_radio_all'    => array(
                            'toggle_slug'       => 'radio_filter',
                            'label'             => esc_html__( 'Hide All option', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'option_category'   => 'configuration',
                            'options'           => array(
                                'on'            => esc_html__( 'Yes', $this->de_domain_name),
                                'off'           => esc_html__( 'No', $this->de_domain_name),
                            ),
                            'show_if_not'   => array(
                              'filter_post_type' => 'search',
                              'acf_filter_type' => ['select', 'number_range']
                            ),
                            'default'           => 'off',
                            'description'       => esc_html__( 'Define the text you want to be shown as the "all" checkbox to show all the values.', $this->de_domain_name ),
                        ),
                        'radio_all_text' => array(
                          'toggle_slug'       => 'radio_filter',
                          'label'             => esc_html__( 'All Label Text', $this->de_domain_name ),
                          'type'              => 'text',
                          'option_category'   => 'configuration',
                          'default'   => 'All',
                          'description'       => esc_html__( 'Define the text you want to be shown as the "all" checkbox to show all the values.', $this->de_domain_name ),
                          'show_if_not'   => array(
                            'filter_post_type' => 'search',
                            'acf_filter_type' => ['select', 'number_range'],
                            'hide_radio_all' => 'on'
                          )
                      ),
                        'filter_limit' => array(
                          'option_category' => 'configuration',
                          'toggle_slug'     => 'radio_filter',
                          'label'             => esc_html__( 'Limit Height of Radio/Checkbox filters?', $this->de_domain_name ),
                          'type'              => 'yes_no_button',
                          'options'   => array(
                              'on'    => esc_html__( 'Yes', $this->de_domain_name ),
                              'off'   => esc_html__( 'No', $this->de_domain_name ),
                          ),
                          'show_if_not'   => array(
                            'filter_post_type' => 'search',
                            'acf_filter_type' => ['select', 'number_range']
                          ),
                          'default'           => 'off',
                          'description'       => esc_html__( 'If you want to limit the height of the filters with an option to toggle more, enable this.', $this->de_domain_name ),
                      ),
                      'filter_limit_height' => array(
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                          'label'           => esc_html__( 'Max Height of the Filter Item', $this->de_domain_name ),
                          'type'            => 'range',
                          'default'         => '200',
                          'default_unit'    => 'px',
                          'default_on_front' => '',
                          'show_if' => array(
                              'filter_limit' => 'on'
                              ),
                          'range_settings'  => array(
                              'min'  => '0',
                              'max'  => '1000',
                              'step' => '1',
                          ),
                      ),
                      'filter_limit_show_more_text' => array(
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                          'label'             => esc_html__( 'Show More Text', $this->de_domain_name ),
                          'type'              => 'text',
                          'show_if' => array(
                              'filter_limit' => 'on'
                              ),
                          'default'           => 'Show More',
                          'description'       => esc_html__( 'Enter the text you want to appear to toggle more', $this->de_domain_name ),
                      ),
                      'filter_limit_show_less_text' => array(
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                          'label'             => esc_html__( 'Show Less Text', $this->de_domain_name ),
                          'type'              => 'text',
                          'show_if' => array(
                              'filter_limit' => 'on'
                              ),
                          'default'           => 'Show Less',
                          'description'       => esc_html__( 'Enter the text you want to appear to toggle less', $this->de_domain_name ),
                      ),
                      'filter_limit_show_lessmore_icon' => array(
                        'label'               => esc_html__( 'Show More Icon', $this->de_domain_name ),
                        'description'         => esc_html__( 'Define the icon that appears after the show more text', $this->de_domain_name ),
                        'type'                => 'select_icon',
                        'class'               => array( 'et-pb-font-icon' ),
                        'default'           => '%%18%%',
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                        'show_if' => array(
                            'filter_limit' => 'on'
                            ),
                      ),
                      'filter_limit_show_less_icon' => array(
                        'label'               => esc_html__( 'Show Less Icon', $this->de_domain_name ),
                        'description'         => esc_html__( 'Define the icon that appears after the show less text', $this->de_domain_name ),
                        'type'                => 'select_icon',
                        'class'               => array( 'et-pb-font-icon' ),
                        'default'           => '%%17%%',
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                        'show_if' => array(
                            'filter_limit' => 'on'
                            ),
                      ),
                      'filter_limit_show_less_icon_size' => array(
                        'label'             => esc_html__( 'Show More/Less Icon Size', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                        'default'   => '15',
                        'show_if' => array(
                            'filter_limit' => 'on'
                            ),
                        'description'       => esc_html__( 'Change the size of the icon.', $this->de_domain_name ),
                      ),
                      'filter_limit_show_less_icon_pos_top' => array(
                        'label'             => esc_html__( 'Show More/Less Icon Position Top', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                        'default'   => '0',
                        'show_if' => array(
                            'filter_limit' => 'on'
                            ),
                            'range_settings'  => array(
                              'min'  => '-300',
                              'max'  => '300',
                              'step' => '1',
                            ),
                        'description'       => esc_html__( 'Change the position from the top of the icon.', $this->de_domain_name ),
                      ),
                      'filter_limit_show_less_icon_pos_right' => array(
                        'label'             => esc_html__( 'Show More/Less Icon Position Right', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category' => 'configuration',
                        'toggle_slug'     => 'radio_filter',
                        'default'   => '-22',
                        'show_if' => array(
                            'filter_limit' => 'on'
                            ),
                            'range_settings'  => array(
                              'min'  => '-300',
                              'max'  => '300',
                              'step' => '1',
                            ),
                        'description'       => esc_html__( 'Change the position from the right of the icon.', $this->de_domain_name ),
                      ),
                      

                        
                      // 'cat_tag_hide_empty' => array(
                      //   'toggle_slug'       => 'radio_filter',
                      //   'label'             => esc_html__( 'Hide Empty Options?', $this->de_domain_name ),
                      //   'type'              => 'yes_no_button',
                      //   'option_category'   => 'configuration',
                      //   'options'           => array(
                      //     'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                      //     'off' => esc_html__( 'No', $this->de_domain_name ),
                      //   ),
                      //   'default'   => 'off',
                      //   'description'       => esc_html__( 'Enable this to hide the empty values (ones that have no posts assigned to them)', $this->de_domain_name ),
                      // ),
                      'radio_button_background_color' => array(
                          'label'             => esc_html__( 'Checkbox Background Color', $this->de_domain_name ),
                          'type'              => 'color-alpha',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'radio_button_style',
                          'sub_toggle'        => 'nonchecked_check',
                          'description'       => esc_html__( 'This will change the fill color for the checkbox or radio button background.', $this->de_domain_name ),
                          'default'           => "#eee",
                          'show_if'           => array(
                            'acf_filter_type' => 'radio',
                          )
                      ),
                      'radio_button_background_color_selected' => array(
                          'label'             => esc_html__( 'Checkbox Background Color Selected', $this->de_domain_name ),
                          'type'              => 'color-alpha',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'radio_button_style',
                          'sub_toggle'        => 'checked_check',
                          'description'       => esc_html__( 'This will change the fill color for the checkbox or radio button background when selected/clicked.', $this->de_domain_name ),
                          'default'           => $et_accent_color,
                          'show_if'           => array(
                            'acf_filter_type' => 'radio',
                          )
                    ),

                        

                        //////////////////////////////////////////////////
                        /* SWATCH FILTER */
                        //////////////////////////////////////////////////


                        'swatch_style' => array(
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'swatch_style_tab',
                          'label'             => esc_html__( 'Swatch Style', $this->de_domain_name ),
                          'type'              => 'select',
                          'options'           => array(
                              'circle'        => 'Circle',
                              'square'        => 'Square'
                          ),
                          'default'           => 'circle',
                          'affects'         => array(
                              'default_num',
                          ),
                          'description'       => esc_html__( 'When using a color, image or label swatch - choose the style here.', $this->de_domain_name ),
                          'show_if'           => array(
                            'attribute_swatch' => 'on'
                          )
                      ),
                      'swatch_width' => array(
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'swatch_style_tab',
                        'label'             => esc_html__( 'Swatch Width', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category'   => 'configuration',
                        'default'   => '40',
                        'description'       => esc_html__( 'Specify the swatch width.', $this->de_domain_name ),
                        'show_if'           => array(
                          'attribute_swatch' => 'on'
                        )
                      ),
                      'swatch_height' => array(
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'swatch_style_tab',
                        'label'             => esc_html__( 'Swatch Height', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category'   => 'configuration',
                        'default'   => '40',
                        'description'       => esc_html__( 'Specify the swatch height.', $this->de_domain_name ),
                        'show_if'           => array(
                          'attribute_swatch' => 'on'
                        )
                      ),
                      'swatch_bg_color' => array(
                        'tab_slug'          => 'advanced',
                        'label'             => esc_html__( 'Swatch Background Color', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'toggle_slug'       => 'swatch_style_tab',
                        'description'       => esc_html__( 'Change the color of the swatch background.', $this->de_domain_name ),
                        'default'           => "#ffffff",
                        'show_if'           => array(
                          'attribute_swatch' => 'on'
                        )
                      ),
                      'swatch_border_color' => array(
                        'tab_slug'          => 'advanced',
                        'label'             => esc_html__( 'Swatch Border Color', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'toggle_slug'       => 'swatch_style_tab',
                        'description'       => esc_html__( 'Change the color of the swatch border.', $this->de_domain_name ),
                        'default'           => "#000000",
                        'show_if'           => array(
                          'attribute_swatch' => 'on'
                        )
                      ),
                      'swatch_bg_color_active' => array(
                        'tab_slug'          => 'advanced',
                        'label'             => esc_html__( 'Active Swatch Background Color', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'toggle_slug'       => 'swatch_style_tab',
                        'description'       => esc_html__( 'Change the color of the swatch background when active.', $this->de_domain_name ),
                        'default'           => "#ffffff",
                        'show_if'           => array(
                          'attribute_swatch' => 'on'
                        )
                      ),
                      'swatch_border_color_active' => array(
                        'tab_slug'          => 'advanced',
                        'label'             => esc_html__( 'Active Swatch Border Color', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'toggle_slug'       => 'swatch_style_tab',
                        'description'       => esc_html__( 'Change the color of the swatch border when active.', $this->de_domain_name ),
                        'default'           => "#00b8ff",
                        'show_if'           => array(
                          'attribute_swatch' => 'on'
                        )
                      ),
                      'swatch_border_width' => array(
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'swatch_style_tab',
                        'label'             => esc_html__( 'Swatch Border Width', $this->de_domain_name ),
                        'type'              => 'range',
                        'option_category'   => 'configuration',
                        'default'   => '2',
                        'description'       => esc_html__( 'Change the width of the border.', $this->de_domain_name ),
                        'show_if'           => array(
                          'attribute_swatch' => 'on'
                        )
                      ),
                      'star_bg_color' => array(
                        'tab_slug'          => 'advanced',
                        'label'             => esc_html__( 'Star Background Color', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'toggle_slug'       => 'swatch_style_tab',
                        'description'       => esc_html__( 'Change the color of the star background.', $this->de_domain_name ),
                        'default'           => "#ccc",
                        'show_if'           => array(
                          'attribute_swatch'  => 'on',
                          'filter_post_type'  => 'productrating'
                        )
                      ),
                      'star_color' => array(
                        'tab_slug'          => 'advanced',
                        'label'             => esc_html__( 'Star Color', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'toggle_slug'       => 'swatch_style_tab',
                        'description'       => esc_html__( 'Change the color of the star rating.', $this->de_domain_name ),
                        'default'           => $et_accent_color,
                        'show_if'           => array(
                          'attribute_swatch'  => 'on',
                          'filter_post_type'  => 'productrating'
                        )
                      ),
                      'star_color_active' => array(
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'swatch_style_tab',
                        'label'             => esc_html__( 'Star Color Active', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'option_category'   => 'configuration',
                        'default'           => "#f9fb41",
                        'description'       => esc_html__( 'Change the color of the star rating when active.', $this->de_domain_name ),
                        'show_if'           => array(
                          'attribute_swatch'  => 'on',
                          'filter_post_type'  => 'productrating'
                        )
                      ),

                        //////////////////////////////////////////////////
                        /* CATEGORIES */
                        //////////////////////////////////////////////////
                      
                      'cat_tag_display_mode' => array(
                        'toggle_slug'       => 'tags_filter',
                        'label'             => esc_html__( 'Category Display Mode', $this->de_domain_name ),
                        'type'              => 'select',
                        'option_category'   => 'configuration',
                        'options'           => array(
                          'only_parents'    => esc_html__( 'Only Parent Categories', $this->de_domain_name ),
                          'only_child'      => esc_html__( 'Only Sub Categories of Selected Category', $this->de_domain_name ),
                          'category_child'  => esc_html__( 'Sub Categories of Current Category (Category page only)', $this->de_domain_name ),
                          'all_cat_sub'     => esc_html__( 'All Categories and Sub categories', $this->de_domain_name ),
                        ),
                        'default'   => 'all_cat_sub',
                        'description'       => esc_html__( 'Select option which categories you want to display.', $this->de_domain_name ),
                        'depends_show_if'   => 'category',
                        'affects'         => array(
                            'cat_parent_category',
                            'cat_show_only_children',
                            'cat_sub_prefix',
                            'cat_sub_collapsible'
                        ),
                      ),
                      'cat_parent_category' => array(
                        'toggle_slug'       => 'tags_filter',
                        'label'             => esc_html__( 'Parent Category', $this->de_domain_name ),
                        'type'              => 'text',
                        'option_category'   => 'configuration',
                        'default'   => 'all_cat_sub',
                        'description'       => esc_html__( 'Input a parent category slug of the categories that you want to display.', $this->de_domain_name ),
                        'depends_show_if'   => 'only_child',
                      ),
                      'cat_show_only_children'  => array(
                        'toggle_slug'       => 'tags_filter',
                        'label'             => esc_html__( 'Disable Hierarchical?', $this->de_domain_name),
                        'type'              => 'yes_no_button',
                        'option_category'   => 'configuration',
                        'options'           => array(
                          'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                          'off' => esc_html__( 'No', $this->de_domain_name ),
                        ),
                        'default'           => 'off',
                        'show_if'           => array(
                            'cat_tag_display_mode' => ['only_child', 'category_child']
                        ),
                        'description'       => esc_html__( 'Enable this to show only sub categories of selected or current category (do not show grandchildren).', $this->de_domain_name ),
                      ),
                      'sub_cat_indent_prefix' => array(
                        'toggle_slug'       => 'tags_filter',
                        'label'             => esc_html__( 'Sub Category Identification', $this->de_domain_name ),
                        'type'              => 'select',
                        'options'           => array(
                          'prefix'  => esc_html__( 'Prefix', $this->de_domain_name ),
                          'indent' => esc_html__( 'Indent', $this->de_domain_name )
                        ),
                        'option_category'   => 'configuration',
                        'default'           => 'prefix',
                        'show_if_not'       => array(
                            'cat_tag_display_mode' => ['only_parents', 'conditional']
                        ),
                        'description'       => esc_html__( 'Choose how you want your sub categories to appear, so the user knows it is a child.', $this->de_domain_name )
                    ),
                    'cat_sub_indent' => array(
                      'option_category' => 'configuration',
                      'toggle_slug'       => 'tags_filter',
                        'label'           => esc_html__( 'Indent Spacing', $this->de_domain_name ),
                        'type'            => 'range',
                        'default'         => '20',
                        'default_unit'    => 'px',
                        'default_on_front' => '',
                        'show_if_not'       => array(
                            'cat_tag_display_mode' => ['only_parents', 'conditional'],
                            'sub_cat_indent_prefix' => 'prefix'
                        ),
                        'range_settings'  => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                      'cat_sub_prefix'      => array(
                        'toggle_slug'       => 'tags_filter',
                        'label'             => esc_html__( 'Sub Category Prefix', $this->de_domain_name),
                        'type'              => 'text',
                        'option_category'   => 'configuration',
                        'default'           => '--',
                        'show_if_not'       => array(
                            'cat_tag_display_mode' => ['only_parents', 'conditional'],
                            'sub_cat_indent_prefix' => 'indent'
                        ),
                        'description'       => esc_html__( 'Enable this to show only subcategories of selected or current category.', $this->de_domain_name ),
                      ),
                      'cat_sub_collapsible'      => array(
                        'toggle_slug'       => 'tags_filter',
                        'label'             => esc_html__( 'Collapsible Sub Categories?', $this->de_domain_name),
                        'type'              => 'yes_no_button',
                        'option_category'   => 'configuration',
                        'options'           => array(
                          'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                          'off' => esc_html__( 'No', $this->de_domain_name ),
                        ),
                        'default'           => 'off',
                        'show_if_not'       => array(
                            'cat_tag_display_mode' => ['only_parents', 'conditional']
                        ),
                        'description'       => esc_html__( 'Enable this if you want to have the sub-categories expand and collapse when clicking.', $this->de_domain_name ),
                      ),
                      'cat_sub_collapsible_prevent'      => array(
                        'toggle_slug'       => 'tags_filter',
                        'label'             => esc_html__( 'Disable Filter on Parent?', $this->de_domain_name),
                        'type'              => 'yes_no_button',
                        'option_category'   => 'configuration',
                        'options'           => array(
                          'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                          'off' => esc_html__( 'No', $this->de_domain_name ),
                        ),
                        'default'           => 'on',
                        'show_if_not'       => array(
                            'cat_sub_collapsible' => ['off']
                        ),
                        'description'       => esc_html__( 'Enable this if you want to disable the filter of the posts when clicking on the parent, this will expand the list without filtering.', $this->de_domain_name ),
                      ),
                      'cat_sub_collapsible_toggle_icon' => array(
                        'label'               => esc_html__( 'Category Collapse Toggle Icon', $this->de_domain_name ),
                        'description'         => esc_html__( 'Define the icon for toggling categories collapse', $this->de_domain_name ),
                        'type'                => 'select_icon',
                        'class'               => array( 'et-pb-font-icon' ),
                        'default'           => '%%18%%',
                        'option_category' => 'configuration',
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'collapsible_icon',
                        'show_if_not'       => array(
                          'cat_sub_collapsible' => ['off']
                        ),
                      ),
                      'cat_sub_collapsible_toggle_icon_font_size' => array(
                        'label'               => esc_html__( 'Category Collapse Toggle Icon', $this->de_domain_name ),
                        'description'         => esc_html__( 'Define the icon for toggling categories collapse', $this->de_domain_name ),
                        'type'                => 'select_icon',
                        'class'               => array( 'et-pb-font-icon' ),
                        'default'           => '%%18%%',
                        'option_category' => 'configuration',
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'collapsible_icon',
                        'show_if_not'       => array(
                          'cat_sub_collapsible' => ['off']
                        ),
                      ),
                      'cat_sub_collapsible_toggle_icon_color' => array(
                        'label'             => esc_html__( 'Category Collapse Toggle Color', $this->de_domain_name ),
                        'type'              => 'color-alpha',
                        'option_category'   => 'configuration',
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'collapsible_icon',
                        'description'       => esc_html__( 'This will change the fill color of the chevron icon to toggle the sub-categories.', $this->de_domain_name ),
                        'default'           => "#666",
                        'show_if_not'       => array(
                          'cat_sub_collapsible' => ['off']
                        ),
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
                      ),
                      'filter_item_padding'          => array(
                        'label'           => esc_html__( 'Filter Item Padding', $this->de_domain_name ),
                        'type'           => 'custom_padding',
                        'description'     => esc_html__( 'Set padding for the filter item not including the label', $this->de_domain_name ),
                        'default_unit' => 'px',
                        'validate_unit' => true,
                        'tab_slug'        => 'advanced',
                        'toggle_slug'     => 'margin_padding',
                        'mobile_options'  => true,
                        ),
                        'filter_item_margin'          => array(
                        'label'           => esc_html__( 'Filter Item Margin', $this->de_domain_name ),
                        'type'           => 'custom_margin',
                        'description'     => esc_html__( 'Set margin for the filter item not including the label', $this->de_domain_name ),
                        'default_unit' => 'px',
                        'validate_unit' => true,
                        'tab_slug'        => 'advanced',
                        'toggle_slug'     => 'margin_padding',
                        'mobile_options'  => true,
                      )
                      // '__acf' => array(
                      //   'type' => 'computed',
                      //   'computed_callback' => array(
                      //     'db_filter_loop_code',
                      //     'computed_acf'
                      //   ),
                      //   'computed_depends_on' => array(
                      //       'filter_post_type',
                      //       'acf_name'
                      //   )
                      //  )
                        
                    );

                    return $fields;
                }

                public static function computed_acf(){
	                if ( isset( $args ) ) {
                  $filter_post_type  = $args['filter_post_type'];
	                }
                    $acf_name = $args['acf_name'];
                    $field_type = get_field_object($acf_name);

                    ob_start();

                    echo $field_type;

                    wp_reset_query();
                    $shop = ob_get_clean();
                    return $shop;
                }

                  function render($attrs, $content, $render_slug){
 
                    if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
                      return;
                    }

                    if (is_admin()) {
                      return;
                    }

                    global $wpdb;

                    $post_type_choose   = $this->props['post_type_choose'];
                    $filter_post_type   = $this->props['filter_post_type'];
                    $custom_tax_choose   = $this->props['custom_tax_choose'];

                    $custom_meta_name   = $this->props['custom_meta_name'];
                    $acf_name           = $this->props['acf_name'];
                    $acf_map_name       = !empty($this->props['acf_map_name'])?$this->props['acf_map_name']:'';
                    $acf_map_radius_unit= !empty($this->props['acf_map_radius_unit'])?$this->props['acf_map_radius_unit']:'';
                    $acf_map_fields_inline = $this->props['acf_map_fields_inline'];
                    $acf_map_radius_select = $this->props['acf_map_radius_select'];
                    $acf_map_radius_select_values = $this->props['acf_map_radius_select_values'];
                    $radius_field_placeholder = $this->props['radius_field_placeholder'];
                    $radius_field_value = $this->props['radius_field_value'];
                    $acf_filter_type    = $this->props['acf_filter_type'];
                    $acf_filter_width   = $this->props['acf_filter_width'];
                    $attribute_swatch   = $this->props['attribute_swatch'];
                    $show_label         = $this->props['show_label'];
                    $text_placeholder   = $this->props['text_placeholder'];
                    $is_number_input   = $this->props['is_number_input'];
                    $max_price_type     = $this->props['max_price_type'];
                    $min_price_type     = $this->props['min_price_type'];
                    
                    $select_placeholder = $this->props['select_placeholder'];
                    $exclude_option     = $this->props['exclude_option'];
                    $include_option     = $this->props['include_option'];
                    $value_type         = ($acf_filter_type != 'number_range')?$this->props['value_type']:'decimal';

                    $product_attribute  = $this->props['product_attribute'];

                    // $default_num                         = $this->props['default_num'];
                    
                    $radio_deselect        = $this->props['radio_deselect'];
                    $radio_style        = $this->props['radio_style'];
                    $radio_choice        = $this->props['radio_choice'];
                    $radio_select       = $this->props['radio_select'];
                    $radio_all_text     = $this->props['radio_all_text'];
                    $radio_all_hide     = $this->props['hide_radio_all'];
                    $select_labeltext   = $this->props['select_labeltext'];

                    // $checkbox_color                         = $this->props['checkbox_color'];
                    $range_prim_color                               = $this->props['range_prim_color'];
                    $range_sec_color                                = $this->props['range_sec_color'];
                    $radio_button_background_color                  = $this->props['radio_button_background_color'];
                    $radio_button_background_color_selected         = $this->props['radio_button_background_color_selected'];

                    $range_type                 = $this->props['range_type'];
                    $range_from                 = $this->props['range_from'];
                    $range_to                   = $this->props['range_to'];
                    $range_step                 = $this->props['range_step'];
                    $range_skin                 = $this->props['range_skin'];
                    $range_hide_min_max         = $this->props['range_hide_min_max'];
                    $range_hide_from_to         = $this->props['range_hide_from_to'];
                    $range_prettify_enabled     = $this->props['range_prettify_enabled'];
                    $range_prettify_separator   = $this->props['range_prettify_separator'];
                    $range_prefix               = $this->props['range_prefix'];
                    $range_postfix              = $this->props['range_postfix'];
                    $range_breakpoint           = $this->props['range_breakpoint'];

                    $range_number_custom              = $this->props['range_number_custom'];
                    $range_custom_values              = $this->props['range_custom_values'];
                    
                    

                    $select_options             = !empty($this->props['select_options'])?$this->props['select_options']:'';
                    $select2                    = $this->props['select2'];
                    $custom_label               = $this->props['custom_label'];
                    // $tags_style                 = $this->props['tags_style'];
                    $radio_inline               = $this->props['radio_inline'];
                    $radio_gap               = $this->props['radio_gap'];
                    $radio_show_count           = $this->props['radio_show_count'];
                    $radio_show_empty           = $this->props['radio_show_empty'];

                    if ($radio_show_empty == 'off' && $acf_filter_type == 'select') {
                        $radio_show_count = 'on';
                    }

                    $swatch_style               = $this->props['swatch_style'];
                    $swatch_width               = $this->props['swatch_width'];
                    $swatch_height              = $this->props['swatch_height'];
                    $swatch_bg_color            = $this->props['swatch_bg_color'];
                    $swatch_border_color        = $this->props['swatch_border_color'];
                    $swatch_bg_color_active     = $this->props['swatch_bg_color_active'];
                    $swatch_border_color_active = $this->props['swatch_border_color_active'];
                    $star_bg_color              = $this->props['star_bg_color'];
                    $star_color                 = $this->props['star_color'];
                    $star_color_active          = $this->props['star_color_active'];
                    $swatch_border_width        = $this->props['swatch_border_width'];
                    $field_title                = $this->props['field_title'];
                    $field_id                   = $this->props['field_id'];
                    $conditional_logic          = $this->props['conditional_logic'];
                    $conditional_logic_relation = $this->props['conditional_logic_relation'];
                    $conditional_logic_rules    = $this->props['conditional_logic_rules'];

                    $taxonomy_order             = $this->props['taxonomy_order'];

                    $hide_title        = !empty($this->props['hide_title'])?$this->props['hide_title']:'';

                    $cat_tag_display_mode       = $this->props['cat_tag_display_mode'];
                    $cat_parent_category        = $this->props['cat_parent_category'];
                    $cat_show_only_children     = $this->props['cat_show_only_children'];

                    
                    $sub_cat_indent_prefix             = $this->props['sub_cat_indent_prefix'];
                    $cat_sub_indent             = $this->props['cat_sub_indent'] ?: '20px';
                    $cat_sub_prefix             = $this->props['cat_sub_prefix'];
                
                    // Module classnames
                    $this->add_classname(
                        array(
                            'clearfix',
                            $this->get_text_orientation_classname(),
                        )
                    );

                    if ($sub_cat_indent_prefix !== 'prefix') {
                      $cat_sub_prefix = '';
                    } else {
                      $this->add_classname( 'cat_prefix');
                    }

                    $filter_item_padding    	= $this->props['filter_item_padding'];
                    $filter_item_padding_tablet		= $this->props['filter_item_padding_tablet'];
                    $filter_item_padding_phone		= $this->props['filter_item_padding_phone'];
                    
                    $filter_item_margin     = $this->props['filter_item_margin'];
                    $filter_item_margin_tablet		= $this->props['filter_item_margin_tablet'];
                    $filter_item_margin_phone		= $this->props['filter_item_margin_phone'];                                       
                    
                    // Filter Item Padding
                    
                    if ('' !== $filter_item_padding && '|||' !== $filter_item_padding) {
                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                        'declaration' => sprintf(
                          'padding-top: %1$s; padding-right: %2$s; padding-bottom: %3$s; padding-left: %4$s;',
                          esc_attr(et_pb_get_spacing($filter_item_padding, 'top', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding, 'right', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding, 'bottom', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding, 'left', '0px'))
                        ),
                      ));
                    }
                    if ('' !== $filter_item_padding_tablet && '|||' !== $filter_item_padding_tablet) {
                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                        'declaration' => sprintf(
                          'padding-top: %1$s; padding-right: %2$s; padding-bottom: %3$s; padding-left: %4$s;',
                          esc_attr(et_pb_get_spacing($filter_item_padding_tablet, 'top', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding_tablet, 'right', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding_tablet, 'bottom', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding_tablet, 'left', '0px'))
                        ),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                      ));
                    }
                    if ('' !== $filter_item_padding_phone && '|||' !== $filter_item_padding_phone) {
                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                        'declaration' => sprintf(
                          'padding-top: %1$s; padding-right: %2$s; padding-bottom: %3$s; padding-left: %4$s;',
                          esc_attr(et_pb_get_spacing($filter_item_padding_phone, 'top', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding_phone, 'right', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding_phone, 'bottom', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_padding_phone, 'left', '0px'))
                        ),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                      ));
                    }
                    
                    // Filter Item margin
                    if ('' !== $filter_item_margin && '|||' !== $filter_item_margin) {
                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                        'declaration' => sprintf(
                          'margin-top: %1$s; margin-right: %2$s; margin-bottom: %3$s; margin-left: %4$s;',
                          esc_attr(et_pb_get_spacing($filter_item_margin, 'top', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin, 'right', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin, 'bottom', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin, 'left', '0px'))
                        ),
                      ));
                    }
                    if ('' !== $filter_item_margin_tablet && '|||' !== $filter_item_margin_tablet) {
                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                        'declaration' => sprintf(
                          'margin-top: %1$s; margin-right: %2$s; margin-bottom: %3$s; margin-left: %4$s;',
                          esc_attr(et_pb_get_spacing($filter_item_margin_tablet, 'top', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin_tablet, 'right', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin_tablet, 'bottom', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin_tablet, 'left', '0px'))
                        ),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                      ));
                    }
                    if ('' !== $filter_item_margin_phone && '|||' !== $filter_item_margin_phone) {
                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper',
                        'declaration' => sprintf(
                          'margin-top: %1$s; margin-right: %2$s; margin-bottom: %3$s; margin-left: %4$s;',
                          esc_attr(et_pb_get_spacing($filter_item_margin_phone, 'top', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin_phone, 'right', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin_phone, 'bottom', '0px')),
                          esc_attr(et_pb_get_spacing($filter_item_margin_phone, 'left', '0px'))
                        ),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                      ));
                    }
                    

                    $tax_sub_prefix             = $this->props['tax_sub_prefix'];
                    $cat_sub_collapsible        = $this->props['cat_sub_collapsible'];
                    $cat_sub_collapsible_prevent        = $this->props['cat_sub_collapsible_prevent'];                    
                    $cat_sub_collapsible_toggle_icon                                = $this->props['cat_sub_collapsible_toggle_icon'];
                    $cat_sub_collapsible_toggle_icon_color                                = $this->props['cat_sub_collapsible_toggle_icon_color'];
                    
                    

                    $only_show_avail           = $this->props['only_show_avail'];
                    $hide_module_for_empty      = $this->props['hide_module_for_empty'];

                    $filter_limit        =  $this->props['filter_limit'];
                    $filter_limit_height        =  $this->props['filter_limit_height'];
                    $filter_limit_show_more_text        =  $this->props['filter_limit_show_more_text'];
                    $filter_limit_show_less_text        =  $this->props['filter_limit_show_less_text'];
                    
                    $filter_limit_show_less_icon        =  $this->props['filter_limit_show_less_icon'];
                    $filter_limit_show_lessmore_icon        =  $this->props['filter_limit_show_lessmore_icon'];
                    $filter_limit_show_less_icon_size        =  $this->props['filter_limit_show_less_icon_size'];
                    $filter_limit_show_less_icon_pos_right        =  $this->props['filter_limit_show_less_icon_pos_right'];
                    $filter_limit_show_less_icon_pos_top        =  $this->props['filter_limit_show_less_icon_pos_top'];
                    $filter_condition                           =  $this->props['filter_condition'];

                    $text_typing_timeout                           =  $this->props['text_typing_timeout'];

                    $radio_show_count_dis_top                           =  $this->props['radio_show_count_dis_top'];
                    
                    
                    if ($radio_show_count  == "on") {
                      $this->add_classname( 'radio_show_count');
                      
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector' => '%%order_class%% .divi-filter-item span.et_pb_contact_field_radio .radio-count',
                        'declaration' => "top: ". esc_attr( $radio_show_count_dis_top ) .";"
                        )
                      );
                    }

                    $button_use_icon            = $this->props['button_use_icon'];
                    $custom_icon                = $this->props['button_icon'];
                    $button_custom              = $this->props['custom_button'];
                    $button_bg_color            = $this->props['button_bg_color'];
                    $button_icon_placement      = $this->props['button_icon_placement'];

                    $custom_active_button           = $this->props['custom_active_button'];
                  $custom_icon_active_button                = $this->props['active_button_icon'];
                    $button_bg_color_active_button            = $this->props['active_button_bg_color'];
                  $button_use_icon_active_button            = $this->props['active_button_use_icon'];
                    $button_icon_active_button                = $this->props['active_button_icon'];
                    $button_icon_placement_active_button      = $this->props['active_button_icon_placement'];
                    $label_spacing        = $this->props['label_spacing'];


                  $true_text        = $this->props['true_text'];
                  $false_text       = $this->props['false_text'];
                  
                  if ( class_exists( 'DE_Filter' ) ) {
                    $cat_sub_collapsible_toggle_icon_rendered = DE_Filter::et_icon_css_content( esc_attr($cat_sub_collapsible_toggle_icon) );
                } else if ( class_exists( 'DEBC_INIT' ) ) {
                    $cat_sub_collapsible_toggle_icon_rendered = DEBC_INIT::et_icon_css_content( esc_attr($cat_sub_collapsible_toggle_icon) );
                } else if ( class_exists( 'DEDMACH_INIT' ) ) {
                    $cat_sub_collapsible_toggle_icon_rendered = DEDMACH_INIT::et_icon_css_content( esc_attr($cat_sub_collapsible_toggle_icon) );
                }

                $collapse_icon_arr = explode('||', $cat_sub_collapsible_toggle_icon);
                $collapse_icon_arr_font_family = ( !empty( $collapse_icon_arr[1] ) && $collapse_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                $collapse_icon_arr_font_weight = ( !empty( $collapse_icon_arr[2] ))?$collapse_icon_arr[2]:'400';

	                  if ( isset( $cat_sub_collapsible_toggle_icon_rendered ) ) {
              ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .et_pb_contact_field_radio.is-collapsible:after',
                'declaration' =>"content: '{$cat_sub_collapsible_toggle_icon_rendered}';
                                  color: {$cat_sub_collapsible_toggle_icon_color};
                                  font-family: {$collapse_icon_arr_font_family}!important;
                                  font-weight: {$collapse_icon_arr_font_weight};"
                )
              );
	                  }

                  if( $custom_icon != '' ){

                    $IconSelector = '';
                            if( $button_icon_placement == 'right' ){
                              $IconSelector = '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input+ label:after';
                            }elseif( $button_icon_placement == 'left' ){
                              $IconSelector = '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input+ label:before';
                            }
  
                            if( !empty( $IconContent ) && !empty( $IconSelector ) ){
            ET_Builder_Element::set_style( $render_slug, array(
              'selector' => $IconSelector,
              'declaration' => "content: '{$IconContent}'!important;font-family:ETmodules!important;"
              )
            );
          }
  
                  }

                  if ($radio_deselect == 'on') {
                      $this->add_classname('deselect_radio');
                  }

                  if( $button_use_icon == 'on' ){

                    // button icon
                    if( $custom_icon !== '' ){

                        if( !empty( $custom_icon ) ){
                            $button_icon_arr = explode('||', $custom_icon);
                            $button_icon_font_family = ( !empty( $button_icon_arr[1] ) && $button_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                            $button_icon_font_weight = ( !empty( $button_icon_arr[2] ))?$button_icon_arr[2]:'400';
                        }

                        if ( class_exists( 'DE_Filter' ) ) {
                            $addToCartIconContent = DE_Filter::et_icon_css_content( esc_attr($custom_icon) );
                        } else if ( class_exists( 'DEBC_INIT' ) ) {
                            $addToCartIconContent = DEBC_INIT::et_icon_css_content( esc_attr($custom_icon) );
                        } else if ( class_exists( 'DEDMACH_INIT' ) ) {
                            $addToCartIconContent = DEDMACH_INIT::et_icon_css_content( esc_attr($custom_icon) );
                        }
                      

                      $addToCartIconSelector = '';
                      if( $button_icon_placement_active_button == 'right' ){
                        $addToCartIconSelector = '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input + label:after';
                      }elseif( $button_icon_placement_active_button == 'left' ){
                        $addToCartIconSelector = '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input + label:before';
                      }

                      if( !empty( $addToCartIconContent ) && !empty( $addToCartIconSelector ) ){
                        ET_Builder_Element::set_style( $render_slug, array(
                          'selector' => $addToCartIconSelector,
                          'declaration' => "
                          content: '{$addToCartIconContent}'!important;
                          font-family:{$button_icon_font_family}!important;
                          font-weight:{$button_icon_font_weight};
                          display: inline-block;
                          line-height: inherit;
                          font-size: inherit!important;
                          margin-left: .3em;
                          left: auto;
                          display: inline-block;
                          "
                          )
                        );
                      }
                    }

                    // button background
                    if( !empty( $button_bg_color_active_button ) ){
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => 'body #page-container %%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input + label',
                        'declaration' => "background-color:". esc_attr( $button_bg_color_active_button ) ."!important;",
                      ) );
                    }
                  }
                  // fix the button padding if has no icon
                  if( $button_use_icon == 'off' ){
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => 'body #page-container %%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input + label',
                      'declaration' => "padding: 0.3em 1em!important"
                      )
                    );
                  }

                  if( $custom_active_button == 'on' ){

                    // button icon
                    if( $button_icon_active_button !== '' ){

                        if( !empty( $button_icon_active_button ) ){
                            $button_icon_arr = explode('||', $button_icon_active_button);
                            $button_icon_font_family = ( !empty( $button_icon_arr[1] ) && $button_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                            $button_icon_font_weight = ( !empty( $button_icon_arr[2] ))?$button_icon_arr[2]:'400';
                        }

                        if ( class_exists( 'DE_Filter' ) ) {
                            $addToCartIconContent = DE_Filter::et_icon_css_content( esc_attr($button_icon_active_button) );
                        } else if ( class_exists( 'DEBC_INIT' ) ) {
                            $addToCartIconContent = DEBC_INIT::et_icon_css_content( esc_attr($button_icon_active_button) );
                        } else if ( class_exists( 'DEDMACH_INIT' ) ) {
                            $addToCartIconContent = DEDMACH_INIT::et_icon_css_content( esc_attr($button_icon_active_button) );
                        }
                      

                      $addToCartIconSelector = '';
                      if( $button_icon_placement_active_button == 'right' ){
                        $addToCartIconSelector = '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input:checked + label:after';
                      }elseif( $button_icon_placement_active_button == 'left' ){
                        $addToCartIconSelector = '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input:checked + label:before';
                      }

                      if( !empty($button_icon_font_weight) && !empty($button_icon_font_family) && !empty( $addToCartIconContent ) && !empty( $addToCartIconSelector ) ){
                        ET_Builder_Element::set_style( $render_slug, array(
                          'selector' => $addToCartIconSelector,
                          'declaration' => "
                          content: '{$addToCartIconContent}'!important;
                          font-family:{$button_icon_font_family}!important;
                          font-weight:{$button_icon_font_weight};
                          display: inline-block;
                          line-height: inherit;
                          font-size: inherit!important;
                          margin-left: .3em;
                          left: auto;
                          display: inline-block;
                          "
                          )
                        );
                      }
                    }

                    // button background
                    if( !empty( $button_bg_color_active_button ) ){
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => 'body #page-container %%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input:checked + label',
                        'declaration' => "background-color:". esc_attr( $button_bg_color_active_button ) ."!important;",
                      ) );
                    }
                  }
                  // fix the button padding if has no icon
                  if( $custom_active_button == 'off' ){
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => 'body #page-container %%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input:checked',
                      'declaration' => "padding: 0.3em 1em!important"
                      )
                    );
                  }

                    if ($filter_limit == "on") {

                      if($filter_limit_show_less_icon != ""){
                        if ( class_exists( 'DE_Filter' ) ) {
                          $filter_limit_show_less_icon_rendered = DE_Filter::et_icon_css_content( esc_attr($filter_limit_show_less_icon) );
                      } else if ( class_exists( 'DEBC_INIT' ) ) {
                          $filter_limit_show_less_icon_rendered = DEBC_INIT::et_icon_css_content( esc_attr($filter_limit_show_less_icon) );
                      } else if ( class_exists( 'DEDMACH_INIT' ) ) {
                          $filter_limit_show_less_icon_rendered = DEDMACH_INIT::et_icon_css_content( esc_attr($filter_limit_show_less_icon) );
                      }

                      $filter_less_icon_arr = explode('||', $filter_limit_show_less_icon);
                      $filter_icon_font_family = ( !empty( $filter_less_icon_arr[1] ) && $filter_less_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                      $filter_icon_font_weight = ( !empty( $filter_less_icon_arr[2] ))?$filter_less_icon_arr[2]:'400';

                      ET_Builder_Element::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .limit_filter_text.showless:after',
                          'declaration' => sprintf(
                              'content: "%1$s";
                              font-size: %2$spx;
                              top: %3$spx;
                              right: %4$spx;
                              font-family: "%5$s"!important;
                              font-weight: %6$s;',
                              isset($filter_limit_show_less_icon_rendered) ? esc_html( $filter_limit_show_less_icon_rendered ) : '',
                              $filter_limit_show_less_icon_size,
                              $filter_limit_show_less_icon_pos_top,
                              $filter_limit_show_less_icon_pos_right,
                              $filter_icon_font_family,
                              $filter_icon_font_weight
                          ),
                      ) );
                      }

                      if($filter_limit_show_lessmore_icon != ""){                        

                        if ( class_exists( 'DE_Filter' ) ) {
                            $filter_limit_show_lessmore_icon_rendered = DE_Filter::et_icon_css_content( esc_attr($filter_limit_show_lessmore_icon) );
                        } else if ( class_exists( 'DEBC_INIT' ) ) {
                            $filter_limit_show_lessmore_icon_rendered = DEBC_INIT::et_icon_css_content( esc_attr($filter_limit_show_lessmore_icon) );
                        } else if ( class_exists( 'DEDMACH_INIT' ) ) {
                            $filter_limit_show_lessmore_icon_rendered = DEDMACH_INIT::et_icon_css_content( esc_attr($filter_limit_show_lessmore_icon) );
                        }

                        $filter_more_icon_arr = explode('||', $filter_limit_show_lessmore_icon);
                        $filter_icon_font_family = ( !empty( $filter_more_icon_arr[1] ) && $filter_more_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                        $filter_icon_font_weight = ( !empty( $filter_more_icon_arr[2] ))?$filter_more_icon_arr[2]:'400';

                        ET_Builder_Element::set_style( $render_slug, array(
                            'selector'    => '%%order_class%% .limit_filter_text.showmore:after',
                            'declaration' => sprintf(
                                'content: "%1$s";
                                font-size: %2$spx;
                                top: %3$spx;
                                right: %4$spx;
                                font-family: "%5$s"!important;
                                font-weight: %6$s;',
                                esc_html( $filter_limit_show_lessmore_icon_rendered ),
                                $filter_limit_show_less_icon_size,
                                $filter_limit_show_less_icon_pos_top,
                                $filter_limit_show_less_icon_pos_right,
                                $filter_icon_font_family,
                                $filter_icon_font_weight
                            ),
                        ) );
                          }
                    }

                    if ( $attribute_swatch == "on" ) {
                        if ( $swatch_style == "square" ) {
                            ET_Builder_Element::set_style( $render_slug, array(
                                'selector'    => '%%order_class%% .divi-swatch .et_pb_contact_field_radio label:not([data-value=all])',
                                'declaration' => "border-radius:0;"
                            ) );

                            ET_Builder_Element::set_style( $render_slug, array(
                                'selector'    => '%%order_class%% .divi-swatch .et_pb_contact_field_radio label:not([data-value=all]) i',
                                'declaration' => "border-radius:0;"
                            ) );
                        }
                    }


                    if ($radio_show_empty == "off") {
                      $cat_tag_hide_empty_dis = true;
                    } else {
                      $cat_tag_hide_empty_dis = false;
                    }

                    if ( $acf_filter_type == "number_range" || ($filter_post_type == "productprice") || ($filter_post_type == "productweight") ) {
                        wp_enqueue_script( 'divi-filter-rangeSlider-js');
                        wp_enqueue_style( 'divi-filter-rangeSlider-css');
                    }

                    // SWATCH STYLE
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch .et_pb_contact_field_radio label:not([data-value="all"])',
                      'declaration' => "
                      width: {$swatch_width}px;
                      height: {$swatch_height}px;
                      background-color: {$swatch_bg_color};
                      border-color: {$swatch_border_color};
                      border-width: {$swatch_border_width}px;
                      "
                      )
                    );
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch-full .et_pb_contact_field_radio label:not([data-value="all"])',
                      'declaration' => "
                      width: 100%!important;
                      height: auto!important;
                      border:none!important;
                      background:none!important;
                      "
                      )
                    );
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch-full .et_pb_contact_field_radio label:not([data-value="all"]) .star-rating',
                      'declaration' => "float: left;"
                      )
                    );
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch .et_pb_contact_field_radio input:checked ~ label',
                      'declaration' => "
                      background-color: {$swatch_bg_color_active};
                      border-color: {$swatch_border_color_active};
                      "
                      )
                    );

                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-filter-item .star-rating:before',
                      'declaration' => "color: {$star_bg_color} !important;"
                      )
                    );

                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch .et_pb_contact_field_radio label .star-rating span:before',
                      'declaration' => "color: {$star_color} !important;"
                      )
                    );

                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch .et_pb_contact_field_radio input:checked~label .star-rating span:before, %%order_class%% .divi-swatch .et_pb_contact_field_radio label:hover .star-rating span:before',
                      'declaration' => "color: {$star_color_active} !important;"
                      )
                    );

                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch-full .et_pb_contact_field_radio input:checked ~ label',
                      'declaration' => "
                      background-color: none;
                      "
                      )
                    );

                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch .et_pb_contact_field_radio label .star-rating span:before',
                      'declaration' => "
                      color: {$swatch_bg_color};
                      "
                      )
                    );

                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .divi-swatch .et_pb_contact_field_radio input:checked ~ label .star-rating span:before',
                      'declaration' => "
                      color: {$swatch_bg_color_active};
                      "
                      )
                    );
                    // END SWATCH STYLE
                      if (!empty($label_spacing)) {
                          self::set_style($render_slug, array(
                                  'selector' => '%%order_class%% .divi-filter-item, %%order_class%% .divi-acf-map-radius',
                                  'declaration' => "margin-top: $label_spacing;"
                              )
                          );
                      }
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => '%%order_class%% .check_radio_normal .divi-filter-item, %%order_class%% .et_pb_checkbox_select_wrapper, %%order_class%% .divi-acf-map-radius',
                      'declaration' => "
                      margin-top: {$label_spacing} !important;
                      "
                      )
                    );

                    $filter_params           = $this->props['filter_params'];
                    if ($filter_params !== "no") {
                      $this->add_classname( 'filter_params_' . $filter_params);
                      $this->add_classname( 'filter_params');
                    } else {
                      $this->add_classname( 'no_filter_params');
                    }

                    if ($hide_title == "on") {
                      $this->add_classname( 'hide_title');
                    }

                    if ($radio_inline == "on") {
                      $this->add_classname( 'inline_checkboxes');
                      self::set_style( $render_slug,
                        array(
                          'selector'    => '%%order_class%%.inline_checkboxes .divi-filter-item>*',
                          'declaration' => sprintf( 'margin-right: %1$spx;', esc_attr( $radio_gap ))
                        )
                      );
                      self::set_style( $render_slug,
                        array(
                          'selector'    => '%%order_class%%.inline_checkboxes .divi-filter-item>*:nth-last-child(1)',
                          'declaration' => 'margin-right: 0 !important;',
                        )
                      );
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

                    $exclude_option = str_replace( ' ', '', $exclude_option );

                    $exclude_option_array = ($exclude_option != '')?explode(',', $exclude_option):array();

                    $include_option = str_replace( ' ', '', $include_option );

                    $include_option_array = ($include_option != '')?explode(',', $include_option):array();

                    $num = mt_rand(100000,999999);
                    $css_class = $render_slug . "_" . esc_attr( $num );

                    if ($range_hide_min_max == "off") {$range_hide_min_max = "false";} else {$range_hide_min_max = "true";};
                    if ($range_hide_from_to == "off") {$range_hide_from_to = "false";} else {$range_hide_from_to = "true";};
                    if ($range_prettify_enabled == "off") {$range_prettify_enabled = "false";} else {$range_prettify_enabled = "true";};

                    $this->add_classname(
                      array(
                        $acf_filter_width,
                        'et_pb_column',
                      )
                    );

                    if ( ! empty( $radio_button_background_color ) ) {
                      self::set_style( $render_slug,
                      array(
                          'selector'    => '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input+label, %%order_class%% .radio-choice-check.divi-radio-tick_box .checkmark, %%order_class%% .divi-radio-tick_box.radio-choice-radio .divi-checkboxmulti input ~ .checkmark',
                          'declaration' => sprintf( 'background-color: %1$s!important;', esc_attr( $radio_button_background_color ) ),
                      )
                    );
                  }

                  // TODO: add color for simple radiio
                  if ( ! empty( $radio_button_background_color_selected ) ) {
                    self::set_style( $render_slug,
                    array(
                      'selector'    => '%%order_class%% .divi-radio-buttons .et_pb_contact_field_radio input:checked+label, %%order_class%% .divi-radio-tick_box.radio-choice-check input:checked ~ .checkmark, %%order_class%% .divi-radio-tick_box.radio-choice-radio .divi-checkboxsingle input:checked ~ .checkmark:after, %%order_class%% .divi-radio-tick_box.radio-choice-radio .divi-checkboxmulti input:checked ~ .checkmark, %%order_class%% .divi-radio-tick_box .divi-checkboxmulti input:checked ~ .checkmark',
                      'declaration' => sprintf( 'background-color: %1$s!important;', esc_attr( $radio_button_background_color_selected ) ),
                    )
                  );
                }


                if ($show_label == "off") {
                  $label_css = "divi-hide";
                } else {
                  $label_css = "";
                }

                if ($acf_filter_width == "et_pb_column_4_4") {
                  $acf_filter_width_num = "100";
                } else if ($acf_filter_width == "et_pb_column_3_4") {
                  $acf_filter_width_num = "75";
                } else if ($acf_filter_width == "et_pb_column_2_3") {
                  $acf_filter_width_num = "60";
                } else if ($acf_filter_width == "et_pb_column_1_2") {
                  $acf_filter_width_num = "50";
                } else if ($acf_filter_width == "et_pb_column_1_3") {
                  $acf_filter_width_num = "40";
                } else if ($acf_filter_width == "et_pb_column_1_4") {
                  $acf_filter_width_num = "25";
                } else {

                }

                //////////////////////////////////////////////////////////////////////

                $conditional_logic_attr = '';
                $conditional_display = '';

                if ( 'on' === $conditional_logic && ! empty( $conditional_logic_rules ) ) {
                    $option_search           = array( '&#91;', '&#93;' );
                    $option_replace          = array( '[', ']' );
                    $conditional_logic_rules = str_replace( $option_search, $option_replace, $conditional_logic_rules );
                    $condition_rows          = json_decode( $conditional_logic_rules );
                    $ruleset                 = array();

                    foreach ( $condition_rows as $condition_row ) {
                        $condition_value = isset( $condition_row->value ) ? $condition_row->value : '';
                        $condition_value = trim( $condition_value );

                        $ruleset[] = array(
                            $condition_row->field,
                            $condition_row->condition,
                            $condition_value
                        );
                    }

                    if ( ! empty( $ruleset ) ) {
                        $json     = wp_json_encode( $ruleset );
                        $relation = $conditional_logic_relation === 'off' ? 'any' : 'all';

                        $conditional_logic_attr = sprintf(
                            ' data-conditional-logic="%1$s" data-conditional-relation="%2$s"',
                            esc_attr($json),
                            $relation
                        );

                        ET_Builder_Element::set_style( $render_slug, array(
                          'selector' => '%%order_class%%',
                          'declaration' => "
                          display:none;
                          "
                          )
                        );

                        $conditional_display = '';
                    }
                }

                if ( $hide_module_for_empty == 'on' ) {
                    $this->add_classname('hide_module_for_empty');
                }

                ob_start();

                global $wp_query;
                $field_id = strtolower($field_id);
                
                $data_attribs = '';

                if ( $filter_post_type == 'category' ) {
                    if ( $cat_tag_hide_empty_dis == true ) {
                        $data_hide_empty = 'data-hide-empty="true"';
                    } else {
                        $data_hide_empty = 'data-hide-empty="false"';
                    }
                    
                    $data_attribs = ' data-child-mode="'.$cat_show_only_children.'" ' . $data_hide_empty .'" data-sub-prefix="' . $cat_sub_prefix.'" data-show-available="'.$only_show_avail.'" data-field-type="' . $acf_filter_type . '"';
                    if ( $acf_filter_type == 'select') {
                        $data_attribs .= ' data-select-placeholder="'.$select_placeholder.'"';
                    }else{
                        $data_attribs .= ' data-radio-select="'.$radio_select.'" data-radio-all-hide="'.$radio_all_hide.'" data-radio-style="'.$radio_style.'" data-radio-all-text="'.$radio_all_text.'"';
                    }
                }

                if ( $radio_select == 'checkbox' && $filter_condition == 'and' ) {
                    $filter_condition = 'and';
                } else {
                    $filter_condition = 'or';
                }
?>
                <div class="search_filter_cont <?php echo esc_attr( $css_class ) ?>" id="<?php echo esc_attr( $field_id );?>" data-count="<?php echo esc_attr( $acf_filter_width_num ) ?>" <?php echo $conditional_logic_attr;?> data-value-type="<?php echo esc_attr( $value_type );?>" data-type="<?php echo esc_attr( $filter_post_type );?>" data-post-type="<?php echo esc_attr( $post_type_choose );?>" <?php echo $data_attribs . $conditional_display;?> data-filter-condition="<?php echo esc_attr( $filter_condition );?>">
                <?php
                
                if ($filter_limit == "on") {
                  $filter_limit_height = $filter_limit_height;
                  $filter_limit_class = 'limit_filter_cont ';
                } else {
                  $filter_limit_height = $filter_limit_class = "";
                }

               // if show available is true


                  // 1) First we get the term query
                  // if ($filter_post_type == "category") {
                  //   if ( $post_type_choose == 'product' ){ // if products
                  //     $term_query = new WP_Term_Query( array( 'taxonomy' => 'product_cat' ) );
                  //   } else if ($post_type_choose == 'post') { // else if posts
                  //     $term_query = new WP_Term_Query( array( 'taxonomy' => 'category' ) );
                  //   }else { // else everything else
                  //     $ending = "_category";
                  //     $cat_key = $post_type_choose . $ending;
                  //     $term_query = new WP_Term_Query( array( 'taxonomy' => $cat_key ) );
                  //   }
                  // } else if ($filter_post_type == "tags") {
                  //   $ending = "_tag";
                  //   $cat_key = $post_type_choose . $ending;
                  //   $term_query = new WP_Term_Query( array( 'taxonomy' => $cat_key ) );
                  // } else if ( $filter_post_type == "taxonomy" ) {
                  //   $term_query = new WP_Term_Query( array( 'taxonomy' => $custom_tax_choose ) );
                  // }


                if ( $filter_post_type == "category" ) {

                  // GET AVAILABLE CATEGORIES
                  // 1) First we get the term query
                  if ($only_show_avail == "on") {
                    global $wp_query;
                    $current_query_var = $wp_query->query_vars;
                    unset( $current_query_var['paged']);
                    $current_query_var['posts_per_page'] = 999999;
                    $the_query = new WP_Query( $current_query_var );
                    $ID_array = $the_query->posts;
                    $avail_terms = '';
                    foreach($ID_array as $item) { // Then for each ID - we then look for the category
                      if ($post_type_choose == 'post') {
                        $terms_post = get_the_category( $item->ID );
                      } else if ( $post_type_choose == 'product' ) {
                        $terms_post = get_the_terms( $item->ID , 'product_cat' );
                      } else {
                        $cat_key = $post_type_choose . '_category';
                        if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                          $terms_post = get_the_category( $item->ID );
                        } else {
                          $terms_post = get_the_terms( $item->ID , $cat_key );
                        }
                      }
                      // 3) for each category we then add the ID to a string
                      if (is_array($terms_post)) {
                        foreach ($terms_post as $term_cat) {
                          $term_cat_id = $term_cat->term_id;
                          $avail_terms .= $term_cat_id.",";
                        }
                      }
                    }
                    $avail_terms = implode(',',array_unique(explode(',', $avail_terms)));
                    if ( $avail_terms == '' ){
                      $avail_terms = array(-1);
                      $this->add_classname( 'divi-hide');
                      $this->add_classname( 'no-avail-terms');
                    }
                  } else {
                    $avail_terms = '';
                  }
                  // GET AVAILABLE CATEGORIES


                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        $custom_label_final = 'Categories';
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Category Filter Label', $custom_label_final );

                    $cat_args = array(
                        'hide_empty' => $cat_tag_hide_empty_dis,
                        'include'   => $avail_terms,
                    );

                    if ($post_type_choose == 'post') {
                        $cat_key = 'category';
                    } else if ( $post_type_choose == 'product' ) {
                        $cat_key = 'product_cat';
                    } else {
                        $cpt_taxonomies = get_object_taxonomies( $post_type_choose );

                        if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                            $cat_key = 'category';
                        }else{
                            $ending = "_category";
                            $cat_key = $post_type_choose . $ending;
                        }
                    }

                    $cat_args['taxonomy'] = $cat_key;

                    if ( $taxonomy_order == 'id' ) {
                        $cat_args['orderby'] = 'term_id';
                    } else if ( $taxonomy_order == 'numeric' ) {
                        //$cat_args['orderby'] = 'name';
                    } else {
                        $cat_args['orderby'] = $taxonomy_order;
                    }

                    $cat_args['order'] = 'ASC';                    

                    $cat_parent_data = '';

                    switch ( $cat_tag_display_mode ) {
                        case 'only_parents':
                            $cat_args['parent'] = 0;
                            $get_categories = get_terms( $cat_args );

                            if ( $taxonomy_order == 'numeric' ) {
                                usort( $get_categories, function($a, $b) {
                                    return strnatcmp( $a->name, $b->name );
                                });
                            }

                            break;
                        case 'only_child':
                            $parent_term = get_term_by( 'slug', $cat_parent_category, $cat_key );
                            $cat_parent_data = ' data-parent-cat="'.$cat_parent_category.'"';
                            if ( $parent_term ){
                                $term_id = $parent_term->term_id;
                                $cat_args['parent'] = $term_id;    
                            }else{
                                $cat_args['parent'] = 0;
                            }

                            if ( $cat_show_only_children == 'on' ) {
                                $get_categories = get_terms( $cat_args );

                                if ( $taxonomy_order == 'numeric' ) {
                                    usort( $get_categories, function($a, $b) {
                                        return strnatcmp( $a->name, $b->name );
                                    });
                                }

                            } else {
                                if ( $taxonomy_order == 'numeric' ) {
                                    $cat_args['tax_order'] = 'numeric';
                                }
                                $this->listTaxonomies( $cat_args, $get_categories );
                            }
                            break;
                        case 'category_child':
                            if ( is_tax( $cat_key ) || ( $cat_key == 'category' && is_category() ) ) {

                                if ( $cat_key != 'category' ) {
                                $current_cat = get_query_var( $cat_key );
                                $current_cat_obj = get_term_by( 'slug', $current_cat, $cat_key );
                                } else {
                                    $current_cat_obj = get_queried_object();
                                }
                                
                                if ( isset( $current_cat_obj ) ) {
                                    $cat_args['parent'] = $current_cat_obj->term_id;

                                    if ( $cat_show_only_children == 'on' ) {
                                        $get_categories = get_terms( $cat_args );

                                        if ( $taxonomy_order == 'numeric' ) {
                                            usort( $get_categories, function($a, $b) {
                                                return strnatcmp( $a->name, $b->name );
                                            });
                                        }
                                    } else {
                                        if ( $taxonomy_order == 'numeric' ) {
                                            $cat_args['tax_order'] = 'numeric';
                                        }

                                        $this->listTaxonomies( $cat_args, $get_categories );
                                    }       
                                }
                            }else {
                                $cat_args['parent'] = 0;
                                if ( $taxonomy_order == 'numeric' ) {
                                    $cat_args['tax_order'] = 'numeric';
                                }
                                $this->listTaxonomies( $cat_args, $get_categories );
                            }
                            break;
                        case 'all_cat_sub':
                        default:
                            $cat_args['parent'] = 0;
                            if ( $taxonomy_order == 'numeric' ) {
                                $cat_args['tax_order'] = 'numeric';
                            }
                            $this->listTaxonomies( $cat_args, $get_categories );
                            break;
                    }

                    $queryvar = !empty($_GET[$cat_key])?stripcslashes(urldecode($_GET[$cat_key])):(get_query_var( $cat_key )?get_query_var( $cat_key):'' );
                    $get_categories = ( !empty( $get_categories) && is_array( $get_categories) )?array_values( $get_categories ):$get_categories;
                    $first_parent_id = ( !empty( $get_categories) && is_array( $get_categories) )?$get_categories[0]->parent:0;
                    $cat_depth = array( $first_parent_id => 0 );

                    if ( $get_categories ) {
                        $cat_slugs = wp_list_pluck( $get_categories, 'slug' );
                        
                        if ( !empty ( $exclude_option_array ) ) {
                            $cat_slugs = array_diff( $cat_slugs, $exclude_option_array );
                        }

                        if ( !empty( $include_option_array ) ) {
                            $cat_slugs = array_intersect( $cat_slugs, $include_option_array);

                            if ( empty( $cat_slugs ) && $hide_module_for_empty == 'on' ) {
                                $this->add_classname('hide_this');
                            }
                        }
                    } else {
                        if ( $hide_module_for_empty == 'on' ) {
                            $this->add_classname( 'hide_this' );
                        }
                    }


                    if ($acf_filter_type == "select") {

                        $selected_cats = preg_split('/(,|\|)/', $queryvar);
?>
                      <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                      <p class="et_pb_contact_field divi-filter-item" data-type="select" data-filtertype="select" name="categories" data-field_type="select" data-filter-option="<?php echo esc_attr( $cat_key );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $cat_key );?>">
                        <select id="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-filtertype="customcategory" data-field_type="select" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num ) ?>" data-name="<?php echo esc_attr( $cat_key );?>">
                          <option value="" <?php echo in_array('', $selected_cats)?'selected':''; ?>><?php echo esc_html( $select_placeholder ) ?></option>
                          <?php
                          if ( $get_categories ) :
                            foreach ( $get_categories as $cat ) :
                                if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                    continue;
                                }
                                $child_cats = get_terms(array( 'hide_empty' => false, 'parent' => $cat->term_id, 'taxonomy' => $cat_key ) );
                                $data_parent = '';
                                if ( !empty( $child_cats) && count( $child_cats ) > 0 ) {
                                    $data_parent = ' data-type="has-child"';
                                }
                                $parent_cat_id = $cat->parent;
                                $prefix = '';
                                if ( isset( $cat_depth[$parent_cat_id] ) ) {
                                    $prefix = str_repeat( $cat_sub_prefix, $cat_depth[ $parent_cat_id ] );
                                    $cat_depth[ $cat->term_id ] = $cat_depth[$parent_cat_id] + 1;
                                }
                              ?>
                              <option id="<?php echo esc_attr( $cat->term_id ) . '_' . esc_attr( $num ); ?>" <?php echo $data_parent;?> value="<?php echo esc_attr( $cat->slug ); ?>" <?php echo in_array($cat->slug, $selected_cats)?'selected':'';?>><?php echo esc_html( $prefix ) . esc_html( $cat->name ); ?></option>
                              <?php
                            endforeach;
                          endif;
                          ?>
                        </select>
                      </p>
                      <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_html($cat_key) . '_' . esc_html($num); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }

                    } else {

                        $empty_class = '';
                        if ( $radio_show_empty == 'on' ){
                            $empty_class = 'show-empty';
                        }

                        if ($radio_select == "checkbox") {
                            $checkboxtype = "divi-checkboxmulti";
                        } else {
                            $checkboxtype = "divi-checkboxsingle";
                        }
                        $queryvar = preg_split('/(,|\|)/', $queryvar);

                        if ( $radio_style == 'select') {
?>
                      <div class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                        <div class="et_pb_contact_field_options_wrapper check_radio_select radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style ) ?>">
                          <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                          <div class="et_pb_checkbox_select_wrapper">
                            <label class="et_pb_contact_select"><?php echo $select_labeltext;?></label>
                                <!-- <form> -->
                            <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) . ' ' . esc_attr( $empty_class ); ?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $cat_key );?>" data-filter-name="<?php echo esc_attr( $cat_key );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height) ?>;" <?php echo $cat_parent_data;?>>

                              <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on') && $only_show_avail == "off" ) { ?>
                              <span class="et_pb_contact_field_radio">
                                <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $cat_key ); ?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num );?>" data-name="<?php echo esc_attr( $cat_key );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo (count($queryvar) == 1 && $queryvar[0] =='' )?'checked="checked"':'';?>>
                                <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; }?>
                                <label class="radio-label" data-value="all<?php echo ($cat_tag_display_mode=='only_child')?'_'. esc_attr( $cat_parent_category ):'';?>" for="<?php echo esc_attr( $cat_key ); ?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                              </span>
                              <?php } ?>
                              <?php
                              if ( $get_categories ) :
                                $cat_inx = 0;
                                foreach ( $get_categories as $cat ) :
                                  
                                  $cat_indent = "";
                                  if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                      $cat_inx++;
                                      continue;
                                  }
                                  $parent_cat_id = $cat->parent;
                                  $cat_id = $cat->term_id;
                                  $prefix = '';
                                  $child_cats = get_terms(array( 'hide_empty' => false, 'parent' => $cat->term_id, 'taxonomy' => $cat_key ) );
                                  $data_parent = '';
                                  if ( !empty( $child_cats) && count( $child_cats ) > 0 ) {
                                      $data_parent = ' data-type="has-child"';
                                  }
                                  $collapsible_class = '';
                                  if ( $cat_sub_collapsible == 'on' && ( $cat_inx < count($get_categories) - 1 ) && $cat->term_id == $get_categories[$cat_inx + 1]->parent ) { 
                                    $this->add_classname( 'sub_cat_collapsible');
                                      $collapsible_class = 'is-collapsible';
                                  
                                  }
                                  
                                  /*if ($sub_cat_indent_prefix == 'indent' && $cat->term_id == $get_categories[$cat_inx + 1]->parent) {
                                  } else {
                                    $cat_indent = 'style="padding-left:'.$cat_sub_indent .';"';
                                  }*/
                                  
                                  $cat_inx++;
                                  if ( isset( $cat_depth[$parent_cat_id] ) ) {
                                      if ( $sub_cat_indent_prefix == 'indent' ) {
                                          $cat_sub_indent = intval( $cat_sub_indent );
                                          $cat_indent = 'style="padding-left:'. esc_attr( ($cat_depth[ $parent_cat_id ] * $cat_sub_indent) )  .'px;"';
                                      } else {
                                          $prefix = str_repeat( $cat_sub_prefix, $cat_depth[ $parent_cat_id ] );    
                                      }                                    
                                      $cat_depth[ $cat->term_id ] = $cat_depth[$parent_cat_id] + 1;
                                  }
                                  ?>
                                  <span <?php echo $cat_indent ?> class="et_pb_contact_field_radio <?php echo esc_attr( $collapsible_class );?>" data_prevent_collapse="<?php echo esc_attr( $cat_sub_collapsible_prevent )?>" data_parent_cat_id="<?php echo esc_attr( $parent_cat_id )?>" data_cat_id="<?php echo esc_attr( $cat_id ) ?>">
                                    <input type="<?php echo esc_attr( $radio_select ) ?>" <?php echo $data_parent;?>  id="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $cat->slug ) ?>" data-name="<?php echo esc_attr( $cat_key );?>" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num );?>" data-required_mark="required" data-field_type="<?php echo esc_attr( $radio_select );?>" <?php echo in_array($cat->slug, $queryvar)?'checked':'';?> data-original_id="radio">
                                    <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                    <label class="radio-label" data-value="<?php echo esc_attr( $cat->slug ) ?>" for="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $cat->name );?>"><i></i><?php echo esc_attr( $prefix ) . esc_attr( $cat->name ); ?></label>
                                  </span>
                                  <?php
                                endforeach;
                              endif;
                              ?>
                              <!-- </form> -->
                            </div>
                          </div>
                        </div>
                      </div>
<?php                          
                        } else {
?>
                      <div class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                        <div class="et_pb_contact_field_options_wrapper check_radio_normal radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style ) ?>">
                          <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                              <!-- <form> -->
                          <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) . ' ' . esc_attr( $empty_class ); ?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $cat_key );?>" data-filter-name="<?php echo esc_attr( $cat_key );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height) ?>" <?php echo $cat_parent_data;?>>

                            <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on') && $only_show_avail == "off" ) { ?>
                            <span class="et_pb_contact_field_radio">
                              <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $cat_key ); ?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num );?>" data-name="<?php echo esc_attr( $cat_key );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo (count($queryvar) == 1 && $queryvar[0] =='' )?'checked="checked"':'';?>>
                              <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; }?>
                              <label class="radio-label" data-value="all<?php echo ($cat_tag_display_mode=='only_child')?'_'. esc_attr( $cat_parent_category ):'';?>" for="<?php echo esc_attr( $cat_key ); ?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                            </span>
                            <?php } ?>
                            <?php
                            if ( $get_categories ) :
                              $cat_inx = 0;
                              foreach ( $get_categories as $cat ) :
                                
                                $cat_indent = "";
                                if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                    $cat_inx++;
                                    continue;
                                }
                                $parent_cat_id = $cat->parent;
                                $cat_id = $cat->term_id;
                                $prefix = '';
                                $child_cats = get_terms(array( 'hide_empty' => false, 'parent' => $cat->term_id, 'taxonomy' => $cat_key ) );
                                $data_parent = '';
                                if ( !empty( $child_cats) && count( $child_cats ) > 0 ) {
                                    $data_parent = ' data-type="has-child"';
                                }
                                $collapsible_class = '';
                                if ( $cat_sub_collapsible == 'on' && ( $cat_inx < count($get_categories) - 1 ) && $cat->term_id == $get_categories[$cat_inx + 1]->parent ) { 
                                  $this->add_classname( 'sub_cat_collapsible');
                                    $collapsible_class = 'is-collapsible';
                                
                                }
                                
                                /*if ($sub_cat_indent_prefix == 'indent' && $cat->term_id == $get_categories[$cat_inx + 1]->parent) {
                                } else {
                                  $cat_indent = 'style="padding-left:'.$cat_sub_indent .';"';
                                }*/
                                
                                $cat_inx++;
                                if ( isset( $cat_depth[$parent_cat_id] ) ) {
                                    if ( $sub_cat_indent_prefix == 'indent' ) {
                                        $cat_sub_indent = intval( $cat_sub_indent );
                                        $cat_indent = 'style="padding-left:'. esc_attr( ($cat_depth[ $parent_cat_id ] * $cat_sub_indent) )  .'px;"';
                                    } else {
                                        $prefix = str_repeat( $cat_sub_prefix, $cat_depth[ $parent_cat_id ] );    
                                    }                                    
                                    $cat_depth[ $cat->term_id ] = $cat_depth[$parent_cat_id] + 1;
                                }
                                ?>
                                <span <?php echo $cat_indent ?> class="et_pb_contact_field_radio <?php echo esc_attr( $collapsible_class );?>" data_prevent_collapse="<?php echo esc_attr( $cat_sub_collapsible_prevent )?>" data_parent_cat_id="<?php echo esc_attr( $parent_cat_id )?>" data_cat_id="<?php echo esc_attr( $cat_id ) ?>">
                                  <input type="<?php echo esc_attr( $radio_select ) ?>" <?php echo $data_parent;?>  id="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $cat->slug ) ?>" data-name="<?php echo esc_attr( $cat_key );?>" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num );?>" data-required_mark="required" data-field_type="<?php echo esc_attr( $radio_select );?>" <?php echo in_array($cat->slug, $queryvar)?'checked':'';?> data-original_id="radio">
                                  <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                  <label class="radio-label" data-value="<?php echo esc_attr( $cat->slug ) ?>" for="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $cat->name );?>"><i></i><?php echo esc_attr( $prefix ) . esc_attr( $cat->name ); ?></label>
                                </span>
                                <?php
                              endforeach;
                            endif;
                            ?>
                            <!-- </form> -->
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                    }
                } else if ( $filter_post_type == "acf" ) {
                  if( class_exists('ACF') ) {
                    $acf_get = get_field_object($acf_name);
                    $acf_type = $acf_get['type'];

                    if ( $acf_type == 'true_false' ) {
                        $acf_get['choices'] = array(
                            '1' => esc_html__($true_text, $this->de_domain_name),
                            '0' => esc_html__($false_text, $this->de_domain_name)
                        );
                    }

                    $queryvar = get_query_var($acf_get['name']) ?  get_query_var($acf_get['name'])  : ( !empty( $_GET[$acf_get['name']] )?  stripcslashes(urldecode($_GET[$acf_get['name']]))  : '' );

                    $selected_vals = preg_split('/(,|\|)/', $queryvar);

                    if ($custom_label !== '') {
                      $custom_label_final = $custom_label;
                    } else {
                      $custom_label_final = $acf_get['label'];
                    }

                    if ( !empty( $acf_get['choices' ] ) ) {
                        if ( $taxonomy_order == 'name' || $taxonomy_order == 'numeric' ) {
                            uksort( $acf_get['choices'], 'strnatcmp' );
                        }
                    }

                    if ( $acf_type == 'post_object' && empty( $acf_get['choices'] ) ) {
                        $acf_post_type = $acf_get['post_type'];
                        $taxonomy = $acf_get['taxonomy'];
                        $acf_args = array( 
                            'post_type'     => $acf_post_type,
                            'numberposts'   => -1,
                            'tax_query'     => array(
                                'relation' => 'AND'
                            ),
                        );

                        if ( $taxonomy != "" && is_array( $taxonomy ) ) {
                            foreach ( $taxonomy as $tax_string ) {
                                list($tax_key , $tax_val ) = explode( ':', $tax_string );
                                $acf_args['tax_query'][] = array(
                                    'taxonomy' => $tax_key,
                                    'field' => 'slug',
                                    'terms' => $tax_val,
                                    'operator' => 'IN'
                                );
                            }
                        }

                        if ( $taxonomy_order == 'id' ) {
                            $acf_args['orderby'] = 'ID';
                        } else if ( $taxonomy_order == 'name' || $taxonomy_order == 'numeric' ) {
                            $acf_args['orderby'] = 'title';
                        } else {
                            $acf_args['orderby'] = 'menu_order';
                        }

                        $acf_args['order'] = 'ASC';

                        $post_result = get_posts( $acf_args );
                        if ( !empty( $post_result ) ) {
                            $acf_get['choices'] = array();
                            foreach ( $post_result as $post_obj ) {
                                $acf_get['choices'][ $post_obj->ID ] = $post_obj->post_title;
                            }
                        }
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'ACF Filter Label - ' . $acf_get['name'], $custom_label_final );
                    ?>
                    <div class="et_pb_contact">
                      <?php
                      if ($acf_filter_type == "select") {

                        if ( !empty( $acf_get['choices'] ) ) {

                            $acf_keys = array_keys( $acf_get['choices'] );
                            if ( !empty ( $exclude_option_array ) ) {
                                $acf_keys = array_diff( $acf_keys, $exclude_option_array );
                            }

                            if ( !empty( $include_option_array ) ) {
                                $acf_keys = array_intersect( $acf_keys, $include_option_array);

                                if ( empty( $acf_keys ) && $hide_module_for_empty == 'on' ) {
                                    $this->add_classname('hide_this');
                                }
                            }
                        } else {
                            if ( $hide_module_for_empty == 'on' ) {
                                $this->add_classname( 'hide_this' );
                            }
                        }

                        if (isset($acf_get['multiple']) && $acf_get['multiple'] == '1') {
                          $select_multiple = 'mulitple';
                        } else {
                          $select_multiple = '';
                        }

                        if ($acf_type == "select" || $acf_type == "checkbox" || $acf_type == 'true_false' || $acf_type == 'radio' || $acf_type == 'post_object' ) {

                          if ($acf_type == "select" || $acf_type == 'true_false' || $acf_type == 'post_object' ) {
                            $acf_type_filter = "acfselect";
                          } else {
                            if ($radio_select == "checkbox") {
                              $acf_type_filter = "divi-checkboxmulti";
                            } else {
                              $acf_type_filter = "divi-checkboxsingle";
                            }
                          }

                          $data_type = 'select';

                          if ( $acf_type == "checkbox" || ( $acf_type == "select" && $acf_get['multiple'] == '1' ) || ( $acf_type == "post_object" && $acf_get['multiple'] == '1' ) ){
                            $data_type = 'checkbox';
                          }
                          ?>
                          <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                          <p class="et_pb_contact_field divi-filter-item" data-type="<?php echo esc_attr( $data_type );?>" data-filtertype="<?php echo esc_attr( $acf_filter_type );?>" data-filter-option="<?php echo esc_attr( $acf_get['name'] );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $acf_get['key'] );?>">
                            <select id="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-filtertype="<?php echo esc_attr( $acf_type_filter ) ?><?php echo esc_attr( $select_multiple ) ?>" name="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" data-name="<?php echo esc_attr( $acf_get['name'] ); ?>" data-field_type="select">
                              <option value="" <?php echo (count( $selected_vals) == 1 && $selected_vals[0] == '')?'selected':'';?>><?php echo esc_attr( $select_placeholder ) ?></option>
                              <?php
                              foreach($acf_get['choices'] as $key => $value) {
                                if ( ( !empty($exclude_option_array) && in_array( $key , $exclude_option_array ) ) || ( !empty( $include_option_array) && !in_array( $key, $include_option_array) ) ) {
                                    continue;
                                }
                                if ( !(count( $selected_vals) == 1 && $selected_vals[0] == '') && in_array( $key, $selected_vals ) ) {
                                  ?>
                                  <option value="<?php echo esc_attr( $key ) ?>" selected="selected"><?php echo esc_html( $value ); ?></option>
                                  <?php
                                } else {
                                  ?>
                                  <option value="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $value ); ?></option>
                                  <?php
                                }
                              }
                              ?>
                            </select>
                          </p>
                          <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_html( $acf_get['name'] ) . '_' . esc_html( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                        } else {
                          echo "Please make sure your field is a select or checkbox type";
                        }
                      }else if ($acf_filter_type == "radio") {

                            if ( !empty( $acf_get['choices'] ) ) {

                                $acf_keys = array_keys( $acf_get['choices'] );
                                if ( !empty ( $exclude_option_array ) ) {
                                    $acf_keys = array_diff( $acf_keys, $exclude_option_array );
                                }

                                if ( !empty( $include_option_array ) ) {
                                    $acf_keys = array_intersect( $acf_keys, $include_option_array);

                                    if ( empty( $acf_keys ) && $hide_module_for_empty == 'on' ) {
                                        $this->add_classname('hide_this');
                                    }
                                }
                            } else {
                                if ( $hide_module_for_empty == 'on' ) {
                                    $this->add_classname( 'hide_this' );
                                }
                            }

                          $data_type = $acf_type;

                          if ( $acf_type == "checkbox" || ( $acf_type == "select" && $acf_get['multiple'] == '1' ) || ( $acf_type == "post_object" && $acf_get['multiple'] == '1' ) ){
                            $data_type = 'checkbox';
                          }

                        if ($radio_style == "select") {
                          ?>
                          <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                          <p class="et_pb_contact_field divi-filter-item" data-type="<?php echo esc_attr( $data_type );?>" name="<?php echo esc_attr( $acf_get['name'] ); ?>" data-field_type="select" data-filtertype="<?php echo esc_attr( $acf_filter_type );?>" data-filter-option="<?php echo esc_attr( $acf_get['name'] );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $acf_get['key'] );?>">
                            <select id="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-filtertype="divi-checkboxsingle" data-field_type="select" name="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" data-name="<?php echo esc_attr( $acf_get['name'] ); ?>">
                              <option value=""  <?php echo (count( $selected_vals) == 1 && $selected_vals[0] == '')?'selected':'';?>><?php echo esc_html( $select_placeholder ) ?></option>
                              <?php
                              foreach($acf_get['choices'] as $key => $value) {
                                if ( (!empty($exclude_option_array) && in_array( $key , $exclude_option_array ) ) || ( !empty( $include_option_array) && !in_array( $key, $include_option_array) ) ) {
                                    continue;
                                }
                                if ( !(count( $selected_vals) == 1 && $selected_vals[0] == '') && in_array( $key, $selected_vals ) ) {
                                  ?>
                                  <option id="<?php echo esc_attr( $acf_get['name'] ); ?>_<?php echo esc_attr( $key ) . '_' . esc_attr( $num ); ?>" value="<?php echo esc_attr ( $key ) ?>" selected="selected"><?php echo esc_html ( $value ); ?></option>
                                  <?php
                                } else {
                                  ?>
                                  <option id="<?php echo esc_attr( $acf_get['name'] ); ?>_<?php echo esc_attr( $key ) . '_' . esc_attr( $num ); ?>" value="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $value ); ?></option>
                                  <?php
                                }
                              }
                              ?>
                            </select>
                          </p>
                          <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_html( $acf_get['name'] ) . '_' . esc_html( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                        } else {
                          if ($radio_select == "checkbox") {
                            $checkboxtype = "divi-checkboxmulti";
                          } else {
                            $checkboxtype = "divi-checkboxsingle";
                          }

                          $additional_classes = '';
                          if ( isset( $radio_show_count ) && $radio_show_count == 'on' ){
                            $additional_classes .= ' divi-show-count';
                          }

                          $empty_class = '';
                          if ( $radio_show_empty == 'on' ){
                            $empty_class = 'show-empty';
                          }

                          $data_type = $acf_type;

                          if ( $acf_type == "checkbox" || ( $acf_type == "select" && $acf_get['multiple'] == '1' ) || ( $acf_type == "post_object" && $acf_get['multiple'] == '1' ) ){
                            $data_type = 'checkbox';
                          }

                          $selected_values = preg_split('/(,|\|)/', $queryvar);
                          ?>
                          <p class="et_pb_contact_field" data-type="<?php echo esc_attr( $data_type );?>" data-filtertype="<?php echo esc_attr( $acf_filter_type );?>">
                            <div class="et_pb_contact_field_options_wrapper check_radio_normal radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style ) ?>">
                              <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                              <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) ?> <?php echo esc_attr( $empty_class );?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-option="<?php echo esc_attr( $acf_get['name'] );?>" data-filter-name="<?php echo esc_attr( $acf_get['key'] );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
                              <!-- <form> -->
                                <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on' ) ) { ?>
                                  <span class="et_pb_contact_field_radio">
                                    <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $acf_get['name'] ); ?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" name="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" data-name="<?php echo esc_attr( $acf_get['name'] ); ?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo (empty($selected_values) || (count($selected_values) == 1 && $selected_values[0] == ''))?'checked':'';?>>
                                    <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } ?>
                                    <label class="radio-label" data-value="all" for="<?php echo esc_attr( $acf_get['name'] ); ?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                                  </span>
                                <?php } ?>
                                  <?php
                                foreach($acf_get['choices'] as $key => $value) {
                                    if ( ( !empty($exclude_option_array) && in_array( $key , $exclude_option_array ) ) || ( !empty( $include_option_array) && !in_array( $key, $include_option_array) ) ) {
                                        continue;
                                    }
                                  ?>
                                  <span class="et_pb_contact_field_radio">
                                      <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $acf_get['name'] ); ?>_<?php echo esc_attr( $key ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $key ) ?>" name="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" data-name="<?php echo esc_attr( $acf_get['name'] ); ?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo (!(count( $selected_vals) == 1 && $selected_vals[0] == '') && in_array( $key, $selected_values ))?'checked="checked"':'';?>>
                                      <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                      <label class="radio-label" data-value="<?php echo esc_attr( $key ) ?>" for="<?php echo esc_attr( $acf_get['name'] ); ?>_<?php echo esc_attr( $key ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $value );?>"><i></i><?php echo esc_html( $value ); ?></label>
                                  </span>
                                  <?php
                                }
                                ?>
                                <!-- </form> -->
                              </div>
                            </div>
                          </p>
                          <?php
                        }
                      } else if ($acf_filter_type == "number_range") {
                        $acf_type = $acf_get['type'];
                        $data_type = $acf_type;

                        if ( $acf_type == "checkbox" || ( $acf_type == "select" && $acf_get['multiple'] == '1' ) ){
                          $data_type = 'checkbox';
                        }
                          $data_type = $acf_type;

                        if ( $acf_type == "checkbox" || ( $acf_type == "select" && $acf_get['multiple'] == '1' ) ){
                              $data_type = 'checkbox';
                        }
                        if ($range_type == "none") {
                          if ($acf_type == "range" || $acf_type == "checkbox" || $acf_type == "radio" || $acf_type == "select" ) {
                              $range_type = "double";
                          } else if ($acf_type == "number")  {
                              $range_type = "single";
                          } else {
                              $range_type = "none";
                          }
                        }
                        if ($range_type == "none") {
                          echo "please make sure your ACF item is a number or a range field.";
                        } else {

                            $range_ok = true;

                          if (isset($queryvar)) {
                            $queryvar_arr = (explode(";",$queryvar));
                            // echo 'Array set: ';
                            // print_r($queryvar_arr);
                            if ( is_array( $queryvar_arr ) ) {
                              if ( isset( $queryvar_arr[1] ) ){
                                $range_from_query = $queryvar_arr[0];
                                $range_to_query = $queryvar_arr[1];
                              }else{
                                $range_from_query = $queryvar_arr[0];
                                $range_to_query = '';
                              }
                            } else {
                              $range_from_query = "";
                              $range_to_query = "";
                            }
                          }

                          if ($range_from_query != "") {
                            $range_from = $range_from_query;
                          }
                          if ($range_to_query != "") {
                            $range_to = $range_to_query;
                          }

                          if ( $acf_type == "range" || $acf_type == "number" ) {
                              if ($acf_get['max'] < $range_to && $acf_get['max'] !== "") {
                                $range_to = $acf_get['max'];
                              }
                              
                              if ($acf_get['max'] == "") {
                                $range_max = $range_to;
                              } else {
                                $range_max = $acf_get['max'];
                              }

                                if ($acf_get['min'] == "") {
                                  $range_min = 0;
                                } else {
                                    $range_min = $acf_get['min'];
                                }
                                if ( $range_from > $range_max || $range_from < $range_min ) {
                                    $range_from = $range_min;
                                }
                          } else {

                            if ( isset( $acf_get['choices'] ) ) {
                                $value_array = array_keys( $acf_get['choices'] );  

                                $value_array = array_map( function( $val ) {
                                    return floatval( $val );
                                }, $value_array);

                                if ( count( $value_array ) == 0 ) {
                                    echo "please make sure your ACF item is a number or a range field.";
                                    $range_ok = false;
                                } else {
                                    $range_min = min( $value_array );
                                    $origin_max = $range_max = max( $value_array );
                                }

                                if ($range_max < $range_to && $range_max !== "") {
                                    $range_to = $range_max;
                                }
                                  
                                if ($range_max == "") {
                                    $origin_max = $range_max = $range_to;
                                }

                                if ( $range_from > $range_max || $range_from < $range_min ) {
                                    $range_from = $range_min;
                                }

                                if ( $range_breakpoint != '' && $range_breakpoint >= $range_max ) {
                                    $range_breakpoint = '';
                                }

                                if ( $range_breakpoint != '' ) {
                                    $range_max = floatval($range_breakpoint) + floatval($range_step);
                                    if ($range_to > $range_max ) {
                                        $range_to = $range_max;
                                    }
                                }
                            } else {
                                echo "please make sure your ACF item is a number or a range field.";
                                $range_ok = false;
                            }
                          }

                          if ( $range_ok ) {

                            $data_additional = '';

                            if ( $range_breakpoint != '' ) {
                                $data_additional = 'data-origin_max="' . $origin_max . '" data-current_max="' . $range_max . '"';
                            }
                        
                          ?>
                          <p class="et_pb_contact_field" data-type="<?php echo esc_attr( $data_type );?>" data-filtertype="range">
                            <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                            <div class="divi-filter-item" data-filter-option="<?php echo esc_attr( $acf_get['name'] );?>">
                              <input id="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" type="select" class="divi-acf js-range-slider" data-filtertype="rangeslider" data-field_type="range" name="<?php echo esc_attr( $acf_get['name'] ) . '_' . esc_attr( $num ); ?>" data-name="<?php echo esc_attr( $acf_get['name'] ); ?>" value="" <?php echo $data_additional;?>/>
                            </div>
                          </p>
                          <?php
                          $css_classrend = "." . $css_class . "";
                          ?>
                          <style>
                          <?php echo esc_html( $css_classrend ) ?> .irs-bar,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single,
                          <?php echo esc_html( $css_classrend ) ?> span:not(.irs--sharp) .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-sharp .irs-handle{
                              background: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--sharp .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single:before {
                              border-top-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs-line,
                          <?php echo esc_html( $css_classrend ) ?> .irs-min,
                          <?php echo esc_html( $css_classrend ) ?> .irs-max {
                            background-color: <?php echo esc_html( $range_sec_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--round .irs-handle {
                           border-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                        </style>

                        <?php

                        if ( !isset($acf_get['min']) || $acf_get['min'] == "") {
                          $acf_get['min'] = "0";
                        }
                        ?>

                        <script>
                        jQuery(document).ready(function($) {

                          var type = '<?php echo esc_html( $range_type ) ?>',
                          min = <?php echo esc_html( $acf_get['min'] ) ?>,
                          max = <?php echo esc_html( $range_max ) ?>,
                          from = <?php echo esc_html( $range_from ) ?>,
                          to = <?php echo esc_html( $range_to ) ?>,
                          step = <?php echo esc_html( $range_step ) ?>,
                          skin = "<?php echo esc_html( $range_skin ) ?>",
                          hide_min_max = <?php echo esc_html( $range_hide_min_max ) ?>,
                          hide_from_to = <?php echo esc_html( $range_hide_from_to ) ?>,
                          prettify_enabled = <?php echo esc_html( $range_prettify_enabled ) ?>,
                          prettify_separator = "<?php echo esc_html( $range_prettify_separator ) ?>",
                          prefix = "<?php echo esc_html( $range_prefix ) ?>",
                          postfix = "<?php echo esc_html( $range_postfix ) ?>";

                          var filters = [];

                          var filter_item_name_arr = [];
                          var filter_item_id_arr = [];
                          var filter_item_val_arr = [];
                          var filter_input_type_arr = [];
                          jQuery('.divi-acf').each(function(i, obj) {
                            var filter_item_name = jQuery(this).attr("name"),
                            filter_item_id = jQuery(this).attr("id"),
                            filter_item_val = jQuery(this).val(),
                            filter_input_type = jQuery(this).attr('type');
                            filter_item_name_arr.push(filter_item_name);
                            filter_item_id_arr.push(filter_item_id);
                            filter_item_val_arr.push(filter_item_val);
                            filter_input_type_arr.push(filter_input_type);
                          });

                          var filter_item_name = jQuery(".<?php echo esc_html( $css_class ) ?> .js-range-slider").attr("name");

                          <?php if ($range_number_custom == 'custom') {
                            $range_custom_val_arr = explode( ',', $range_custom_values );
                            $range_custom_min = min( $range_custom_val_arr );
                            $range_custom_max = max( $range_custom_val_arr );
                            if ( empty($range_from) || $range_from >= $range_custom_max || $range_from < $range_custom_min ) {
                                $range_from = $range_custom_min;
                            }

                            if ( empty( $range_to) || $range_to > $range_custom_max || $range_to <= $range_custom_min ) {
                                $range_to = $range_custom_max;
                            }
                            ?>
                            var range_custom_values = [<?php echo esc_html( $range_custom_values ) ?>],
                                from = range_custom_values.indexOf(<?php echo esc_html( $range_from ) ?>),
                                to = range_custom_values.indexOf(<?php echo esc_html( $range_to ) ?>);
                            <?php
                          }

                          if ( $range_breakpoint != '' ) {
                          ?>
                            function <?php echo $css_class ?>_transform (n) {
                                if (n > <?php echo $range_breakpoint;?> ) {
                                    return "<?php echo $range_breakpoint;?>+";
                                }
                                return n;
                            }

                          <?php } ?>

                          $(".<?php echo $css_class ?> .js-range-slider").ionRangeSlider({
                            type: type,
                            <?php if ($range_number_custom == 'default' || $range_number_custom == 'from_acf') { ?>
                            min: min,
                            max: max,
                            <?php } else { ?>
                            values: range_custom_values,
                            <?php } ?>
                            <?php if ($range_number_custom == 'from_acf') { ?>
                            from: <?php echo esc_html($acf_get['min'])?>,
                            to: <?php echo esc_html($acf_get['max'])?>,
                            <?php  } else { ?>
                            from: from,
                            to: to,
                            <?php } ?>
                            step: step,
                            skin: skin,
                            hide_min_max: hide_min_max,
                            hide_from_to: hide_from_to,
                            prettify_enabled: prettify_enabled,
                            prettify_separator: prettify_separator,
                            prefix: prefix,
                            postfix: postfix,
                        <?php if ( $range_breakpoint != '' ) { ?>
                            prettify: function (n) {
                                return <?php echo $css_class ?>_transform(n);
                            },
                        <?php } ?>
                            onFinish: function (data) {
                              if ( $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.et_pb_de_mach_search_posts').length == 0 && $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.updatetype-update_button').length == 0 ){

                                      var _this = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                                      var iris_to = data.to;
                                      var irs_from = data.from;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                      if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) && (irs_from != data.min || iris_to != data.max ) ) {
                                        if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                                          var filter_param_type = "title";
                                        } else {
                                          var filter_param_type = "no-title";
                                        }
                                        var value = _this.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                                        name = _this.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                                        slug = _this.data("name"),
                                        type = 'range';
                                        //iris_to = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                                        //irs_from = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                        divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                                      } else {
                                        if (jQuery('.param-' + _this.data('name') ).length) {
                                          jQuery('.param-' + _this.data('name') ).remove();
                                        }
                                      }
                                divi_find_filters_to_filter();
                              }
                            }
                          });
<?php
            if ( !empty( $_GET[$acf_get['name']] ) && ( $range_from != $range_min || $range_to != $range_max ) ) {
?>
                var acf_slider = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) ) {
                    if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                      var filter_param_type = "title";
                    } else {
                      var filter_param_type = "no-title";
                    }
                    var value = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                    name = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                    slug = acf_slider.attr("name"),
                    type = 'range',
                    slider_data = acf_slider.data('ionRangeSlider'),
                    iris_to = slider_data.options.to, //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                    irs_from = slider_data.options.from; //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                    divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                }
<?php
            }
?>
                        });
                      </script>
                      <?php
                    }
                  }
                  }
                  ?>
                </div>
                <?php
                  }
                } else if ( $filter_post_type == "custom_meta" ) {
                    $meta_values_sql = "SELECT DISTINCT p_meta.meta_value FROM $wpdb->postmeta AS p_meta INNER JOIN $wpdb->posts posts ON p_meta.post_id=posts.ID WHERE p_meta.meta_key=%s AND posts.post_type=%s";

                    $meta_values_result = $wpdb->get_results( $wpdb->prepare($meta_values_sql, $custom_meta_name, $post_type_choose) );

                    $meta_values = array();

                    if ( !empty( $meta_values_result ) ) {
                        foreach ($meta_values_result as $key => $meta_obj) {
                            $meta_values[] = $meta_obj->meta_value;
                        }
                    }
                    
                    $queryvar = get_query_var($custom_meta_name) ?  get_query_var($custom_meta_name)  : ( !empty( $_GET[$custom_meta_name] )?  stripcslashes(urldecode($_GET[$custom_meta_name]))  : '' );

                    $selected_vals = preg_split('/(,|\|)/', $queryvar);

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        $custom_label_final = $custom_meta_name;
                    }

                    if ( !empty( $meta_values ) ) {
                        if ( $taxonomy_order == 'name' || $taxonomy_order == 'numeric' ) {
                            uksort( $meta_values, 'strnatcmp' );
                        }
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'ACF Filter Label - ' . $custom_meta_name, $custom_label_final );
?>
                    <div class="et_pb_contact">
<?php
                    if ($acf_filter_type == "select") {

                        if ( !empty( $meta_values ) ) {

                            if ( !empty ( $exclude_option_array ) ) {
                                $meta_values = array_diff( $meta_values, $exclude_option_array );
                            }

                            if ( !empty( $include_option_array ) ) {
                                $meta_values = array_intersect( $meta_values, $include_option_array);

                                if ( empty( $meta_values ) && $hide_module_for_empty == 'on' ) {
                                    $this->add_classname('hide_this');
                                }
                            }
                        } else {
                            if ( $hide_module_for_empty == 'on' ) {
                                $this->add_classname( 'hide_this' );
                            }
                        }

                        $select_multiple = '';

                        $acf_type_filter = "acfselect";

                        $data_type = 'select';
?>
                          <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                          <p class="et_pb_contact_field divi-filter-item" data-type="<?php echo esc_attr( $data_type );?>" data-filtertype="<?php echo esc_attr( $acf_filter_type );?>" data-filter-option="<?php echo (isset($acf_get) ? esc_attr( $acf_get['name']) : '' );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $custom_meta_name );?>">
                            <select id="<?php echo esc_attr( $custom_meta_name ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-filtertype="<?php echo esc_attr( $acf_type_filter ) ?><?php echo esc_attr( $select_multiple ) ?>" name="<?php echo esc_attr( $custom_meta_name ) . '_' . esc_attr( $num ); ?>" data-name="<?php echo esc_attr( $custom_meta_name ); ?>" data-field_type="select">
                              <option value="" <?php echo (count( $selected_vals) == 1 && $selected_vals[0] == '')?'selected':'';?>><?php echo esc_attr( $select_placeholder ) ?></option>
<?php
                              foreach($meta_values as $key => $value) {
                                if ( ( !empty($exclude_option_array) && in_array( $value , $exclude_option_array ) ) || ( !empty( $include_option_array) && !in_array( $value, $include_option_array) ) ) {
                                    continue;
                                }
                                if ( !(count( $selected_vals) == 1 && $selected_vals[0] == '') && in_array( $value, $selected_vals ) ) {
                                  ?>
                                  <option value="<?php echo esc_attr( $value ) ?>" selected="selected"><?php echo esc_html( $value ); ?></option>
                                  <?php
                                } else {
                                  ?>
                                  <option value="<?php echo esc_attr( $value ) ?>"><?php echo esc_html( $value ); ?></option>
                                  <?php
                                }
                              }
                              ?>
                            </select>
                          </p>
<?php
                            if ($select2 == "on") {
                                if ( !wp_script_is( 'divi-filter-select2-js') ) {
                                    wp_enqueue_script('divi-filter-select2-js');
                                }
?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_html( $custom_meta_name ) . '_' . esc_html( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
<?php 
                            }
                    }else if ($acf_filter_type == "radio") {

                        if ( !empty( $meta_values ) ) {

                            if ( !empty ( $exclude_option_array ) ) {
                                $meta_values = array_diff( $meta_values, $exclude_option_array );
                            }

                            if ( !empty( $include_option_array ) ) {
                                $meta_values = array_intersect( $meta_values, $include_option_array);

                                if ( empty( $meta_values ) && $hide_module_for_empty == 'on' ) {
                                    $this->add_classname('hide_this');
                                }
                            }
                        } else {
                            if ( $hide_module_for_empty == 'on' ) {
                                $this->add_classname( 'hide_this' );
                            }
                        }

                        if ($radio_select == "checkbox") {
                            $checkboxtype = "divi-checkboxmulti";
                          } else {
                            $checkboxtype = "divi-checkboxsingle";
                          }

                          $empty_class = '';
                          if ( $radio_show_empty == 'on' ){
                            $empty_class = 'show-empty';
                          }

                          $data_type = 'radio';
?>
                        <p class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                            <div class="et_pb_contact_field_options_wrapper radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style ) ?>">
                                <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
<?php

                        if ($radio_style == "select") {
?>
                                <div class="et_pb_checkbox_select_wrapper">
                                    <label class="et_pb_contact_select"><?php echo $select_labeltext;?></label>
<?php
                        }
?>
                                    <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) ?> <?php echo esc_attr($empty_class); ?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $custom_meta_name );?>" data-filter-name="<?php echo esc_attr( $custom_meta_name );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
<?php 
                            if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on' ) && $only_show_avail == "off" ) {
?>
                                        <span class="et_pb_contact_field_radio">
                                            <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $custom_meta_name ); ?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" data-name="<?php echo esc_attr( $custom_meta_name );?>" name="<?php echo esc_attr( $custom_meta_name );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php if ( isset( $query_var_arr ) ) {
	                                            echo ( count($query_var_arr) == 1 && $query_var_arr[0] == '' )?'checked':'';
                                            } ?>>
                                  <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; }?>
                                            <label class="radio-label" data-value="all" for="<?php echo esc_attr( $custom_meta_name ); ?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                                        </span>
<?php 
                            }
                            if ( $meta_values ) :
                                foreach ( $meta_values as $value ) :
                                    if ( in_array( $value , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $value, $include_option_array) ) ) {
                                        continue;
                                    }
?>
                                        <span class="et_pb_contact_field_radio">
                                            <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $custom_meta_name ); ?>_<?php echo esc_attr( $value ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $value ) ?>" data-name="<?php echo esc_attr( $custom_meta_name );?>" name="<?php echo esc_attr( $custom_meta_name );?>" data-required_mark="required" data-field_type="radio" <?php echo in_array($value, $selected_vals)?'checked':'';?> data-original_id="radio">
                                      <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                      <label class="radio-label" data-value="<?php echo esc_attr( $value ) ?>" for="<?php echo esc_attr( $custom_meta_name ); ?>_<?php echo esc_attr( $value ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $value );?>"><i></i><?php echo esc_html( $value ); ?></label>
                                    </span>
                                    <?php
                                  endforeach;
                                endif;
                                ?>                      
                                <!-- </form> -->
                                    </div>
<?php

                        if ($radio_style == "select") {
?>
                                </div>
<?php
                        }
?>                              
                            </div>
                          </p>
<?php
                      } else if ($acf_filter_type == "number_range") {
                        $acf_type = $data_type = 'select';

                        $range_type = 'double';

                        foreach ($meta_values as $key => $value) {
                            if ( !is_numeric( $value ) ){
                                $range_type = 'none';
                            }
                        }

                        if ($range_type == "none") {
                          echo "Please make sure custom meta values are numeric.";
                        } else {

                            $range_ok = true;

                          if (isset($queryvar)) {
                            $queryvar_arr = (explode(";",$queryvar));
                            // echo 'Array set: ';
                            // print_r($queryvar_arr);
                            if ( is_array( $queryvar_arr ) ) {
                              if ( isset( $queryvar_arr[1] ) ){
                                $range_from_query = $queryvar_arr[0];
                                $range_to_query = $queryvar_arr[1];
                              }else{
                                $range_from_query = $queryvar_arr[0];
                                $range_to_query = '';
                              }
                            } else {
                              $range_from_query = "";
                              $range_to_query = "";
                            }
                          }

                          if ($range_from_query != "") {
                            $range_from = $range_from_query;
                          }
                          if ($range_to_query != "") {
                            $range_to = $range_to_query;
                          }

                            if ( isset( $meta_values ) ) {

                                $meta_values = array_map( function( $val ) {
                                    return floatval( $val );
                                }, $meta_values);

                                if ( count( $meta_values ) == 0 ) {
                                    echo "Please make sure custom meta values are numeric.";
                                    $range_ok = false;
                                } else {
                                    $range_min = min( $meta_values );
                                    $origin_max = $range_max = max( $meta_values );
                                }

                                if ($range_max < $range_to && $range_max !== "") {
                                    $range_to = $range_max;
                                }
                                  
                                if ($range_max == "") {
                                    $origin_max = $range_max = $range_to;
                                }

                                if ( $range_from > $range_max || $range_from < $range_min ) {
                                    $range_from = $range_min;
                                }

                                if ( $range_breakpoint != '' && $range_breakpoint >= $range_max ) {
                                    $range_breakpoint = '';
                                }

                                if ( $range_breakpoint != '' ) {
                                    $range_max = floatval($range_breakpoint) + floatval($range_step);
                                    if ($range_to > $range_max ) {
                                        $range_to = $range_max;
                                    }
                                }
                            } else {
                                echo "Please make sure custom meta values are numeric.";
                                $range_ok = false;
                            }

                          if ( $range_ok ) {

                            $data_additional = '';

                            if ( $range_breakpoint != '' ) {
                                $data_additional = 'data-origin_max="' . $origin_max . '" data-current_max="' . $range_max . '"';
                            }
                        
                          ?>
                          <p class="et_pb_contact_field" data-type="<?php echo esc_attr( $data_type );?>" data-filtertype="range">
                            <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                            <div class="divi-filter-item" data-filter-option="<?php echo esc_attr( $custom_meta_name );?>">
                              <input id="<?php echo esc_attr( $custom_meta_name ) . '_' . esc_attr( $num ); ?>" type="select" class="divi-acf js-range-slider" data-filtertype="rangeslider" data-field_type="range" name="<?php echo esc_attr( $custom_meta_name ) . '_' . esc_attr( $num ); ?>" data-name="<?php echo esc_attr( $custom_meta_name ); ?>" value="" <?php echo $data_additional;?>/>
                            </div>
                          </p>
                          <?php
                          $css_classrend = "." . $css_class . "";
                          ?>
                          <style>
                          <?php echo esc_html( $css_classrend ) ?> .irs-bar,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single,
                          <?php echo esc_html( $css_classrend ) ?> span:not(.irs--sharp) .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-sharp .irs-handle{
                              background: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--sharp .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single:before {
                              border-top-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs-line,
                          <?php echo esc_html( $css_classrend ) ?> .irs-min,
                          <?php echo esc_html( $css_classrend ) ?> .irs-max {
                            background-color: <?php echo esc_html( $range_sec_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--round .irs-handle {
                           border-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                        </style>

                        <script>
                        jQuery(document).ready(function($) {

                          var type = '<?php echo esc_html( $range_type ) ?>',
                          min = <?php echo esc_html( $range_min ) ?>,
                          max = <?php echo esc_html( $range_max ) ?>,
                          from = <?php echo esc_html( $range_from ) ?>,
                          to = <?php echo esc_html( $range_to ) ?>,
                          step = <?php echo esc_html( $range_step ) ?>,
                          skin = "<?php echo esc_html( $range_skin ) ?>",
                          hide_min_max = <?php echo esc_html( $range_hide_min_max ) ?>,
                          hide_from_to = <?php echo esc_html( $range_hide_from_to ) ?>,
                          prettify_enabled = <?php echo esc_html( $range_prettify_enabled ) ?>,
                          prettify_separator = "<?php echo esc_html( $range_prettify_separator ) ?>",
                          prefix = "<?php echo esc_html( $range_prefix ) ?>",
                          postfix = "<?php echo esc_html( $range_postfix ) ?>";

                          var filters = [];

                          var filter_item_name_arr = [];
                          var filter_item_id_arr = [];
                          var filter_item_val_arr = [];
                          var filter_input_type_arr = [];
                          jQuery('.divi-acf').each(function(i, obj) {
                            var filter_item_name = jQuery(this).attr("name"),
                            filter_item_id = jQuery(this).attr("id"),
                            filter_item_val = jQuery(this).val(),
                            filter_input_type = jQuery(this).attr('type');
                            filter_item_name_arr.push(filter_item_name);
                            filter_item_id_arr.push(filter_item_id);
                            filter_item_val_arr.push(filter_item_val);
                            filter_input_type_arr.push(filter_input_type);
                          });

                          var filter_item_name = jQuery(".<?php echo esc_html( $css_class ) ?> .js-range-slider").attr("name");

                          <?php if ($range_number_custom == 'custom') {
                            $range_custom_val_arr = explode( ',', $range_custom_values );
                            $range_custom_min = min( $range_custom_val_arr );
                            $range_custom_max = max( $range_custom_val_arr );
                            if ( empty($range_from) || $range_from >= $range_custom_max || $range_from < $range_custom_min ) {
                                $range_from = $range_custom_min;
                            }

                            if ( empty( $range_to) || $range_to > $range_custom_max || $range_to <= $range_custom_min ) {
                                $range_to = $range_custom_max;
                            }
                            ?>
                            var range_custom_values = [<?php echo esc_html( $range_custom_values ) ?>],
                                from = range_custom_values.indexOf(<?php echo esc_html( $range_from ) ?>),
                                to = range_custom_values.indexOf(<?php echo esc_html( $range_to ) ?>);
                            <?php
                          }

                          if ( $range_breakpoint != '' ) {
                          ?>
                            function <?php echo $css_class ?>_transform (n) {
                                if (n > <?php echo $range_breakpoint;?> ) {
                                    return "<?php echo $range_breakpoint;?>+";
                                }
                                return n;
                            }

                          <?php } ?>

                          $(".<?php echo $css_class ?> .js-range-slider").ionRangeSlider({
                            type: type,
                            <?php if ($range_number_custom == 'default') { ?>
                            min: min,
                            max: max,
                            <?php } else { ?>
                            values: range_custom_values,
                            <?php } ?>
                            from: from,
                            to: to,
                            step: step,
                            skin: skin,
                            hide_min_max: hide_min_max,
                            hide_from_to: hide_from_to,
                            prettify_enabled: prettify_enabled,
                            prettify_separator: prettify_separator,
                            prefix: prefix,
                            postfix: postfix,
                        <?php if ( $range_breakpoint != '' ) { ?>
                            prettify: function (n) {
                                return <?php echo $css_class ?>_transform(n);
                            },
                        <?php } ?>
                            onFinish: function (data) {
                              if ( $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.et_pb_de_mach_search_posts').length == 0 && $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.updatetype-update_button').length == 0 ){

                                      var _this = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                                      var iris_to = data.to;
                                      var irs_from = data.from;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                      if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) && (irs_from != data.min || iris_to != data.max ) ) {
                                        if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                                          var filter_param_type = "title";
                                        } else {
                                          var filter_param_type = "no-title";
                                        }
                                        var value = _this.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                                        name = _this.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                                        slug = _this.data("name"),
                                        type = 'range';
                                        //iris_to = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                                        //irs_from = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                        divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                                      } else {
                                        if (jQuery('.param-' + _this.data('name') ).length) {
                                          jQuery('.param-' + _this.data('name') ).remove();
                                        }
                                      }
                                divi_find_filters_to_filter();
                              }
                            }
                          });
<?php
            if ( !empty( $_GET[$custom_meta_name] ) && ( $range_from != $range_min || $range_to != $range_max ) ) {
?>
                var acf_slider = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) ) {
                    if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                      var filter_param_type = "title";
                    } else {
                      var filter_param_type = "no-title";
                    }
                    var value = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                    name = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                    slug = acf_slider.attr("name"),
                    type = 'range',
                    slider_data = acf_slider.data('ionRangeSlider'),
                    iris_to = slider_data.options.to, //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                    irs_from = slider_data.options.from; //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                    divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                }
<?php
            }
?>
                        });
                      </script>
                      <?php
                    }
                  }
                  }
                  ?>
                </div>
                <?php
                } else if ($filter_post_type == "tags") {

                  // GET AVAILABLE TAGS
                  // 1) First we get the term query
                  if ($only_show_avail == "on") {
                    $ending = "_tag";
                    $cat_key = $post_type_choose . $ending;
                    // 2) We get the WP_Query - get all the posts ID's on the page
                    
                    global $wp_query;
                    $avail_terms = "";
                    $current_query_var = $wp_query->query_vars;
                    unset( $current_query_var['paged']);
                    $current_query_var['posts_per_page'] = 999999;
                    $the_query = new WP_Query( $current_query_var );
                    $ID_array = $the_query->posts;
                    foreach($ID_array as $item) { // Then for each ID - we then look for the category
                      $terms_post = get_the_terms( $item->ID , $cat_key );
                      // 3) for each category we then add the ID to a string
                      if (is_array($terms_post)) {
                        foreach ($terms_post as $term_cat) {
                          $term_cat_id = $term_cat->term_id;
                          $avail_terms .= $term_cat_id.",";
                        }
                      }
                    }
                    $avail_terms = implode(',',array_unique(explode(',', $avail_terms)));
                    if ( $avail_terms == '' ){
                      $avail_terms = array(-1);
                      $this->add_classname( 'divi-hide');
                      $this->add_classname( 'no-avail-terms');
                    }
                  } else {
                    $avail_terms = '';
                  }
                  // GET AVAILABLE TAGS

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        $custom_label_final = 'Tags';
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Tag Filter Label', $custom_label_final );

                    $ending = "_tag";
                    $cat_key = $post_type_choose . $ending;

                    $orderby = 'term_id';

                    if ( $taxonomy_order != 'numeric' && $taxonomy_order != 'id' ) {
                        $orderby = $taxonomy_order;
                    }

                    $get_categories = get_terms( $cat_key, array('hide_empty' => $cat_tag_hide_empty_dis, 'include' => $avail_terms, 'orderby' => $orderby, 'order' => 'ASC' ) );

                    if ( $taxonomy_order == 'numeric' ) {

                        usort( $get_categories, function($a, $b) {
                            return strnatcmp( $a->name, $b->name );
                        });

                    }

                    if ( $get_categories ) {
                        $tag_slugs = wp_list_pluck( $get_categories, 'slug' );
                        
                        if ( !empty ( $exclude_option_array ) ) {
                            $tag_slugs = array_diff( $tag_slugs, $exclude_option_array );
                        }

                        if ( !empty( $include_option_array ) ) {
                            $tag_slugs = array_intersect( $tag_slugs, $include_option_array);

                            if ( empty( $tag_slugs ) && $hide_module_for_empty == 'on' ) {
                                $this->add_classname('hide_this');
                            }
                        }
                    } else {
                        if ( $hide_module_for_empty == 'on' ) {
                            $this->add_classname( 'hide_this' );
                        }
                    }

                    $queryvar = get_query_var( $cat_key )?get_query_var( $cat_key):( !empty($_GET[$cat_key])? stripslashes(urldecode($_GET[$cat_key])) :'' );

                    $selected_vals = preg_split('/(,|\|)/', $queryvar);

                    if ($acf_filter_type == "select") {
?>
                    <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                    <p class="et_pb_contact_field divi-filter-item" data-type="select" data-filtertype="select" name="tags" data-field_type="select" data-filter-option="<?php echo esc_attr( $cat_key );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $cat_key );?>">
                      <select id="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-field_type="select" data-filtertype="customtag" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num ) ?>" data-name="<?php echo esc_attr( $cat_key ) ?>">
                        <option value="" <?php echo (count($selected_vals) == 1 && ($selected_vals[0] == ''))?'selected':'';?>><?php echo esc_html( $select_placeholder ) ?></option>
                        <?php
                        if ( $get_categories ) :
                          foreach ( $get_categories as $cat ) :
                            if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                continue;
                            }
                            ?>
                            <option id="<?php echo esc_attr( $cat->term_id ) . '_' . esc_attr( $num ); ?>" value="<?php echo esc_attr( $cat->slug ); ?>" <?php echo ( in_array( $cat->slug, $selected_vals) )?'selected':''; ?>><?php echo esc_html( $cat->name ); ?></option>
                            <?php
                          endforeach;
                        endif;
                        ?>
                      </select>
                    </p>
                    <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_html( $cat_key ) . '_' . esc_html( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                    } else {

                        if ($radio_select == "checkbox") {
                            $checkboxtype = "divi-checkboxmulti";
                        } else {
                            $checkboxtype = "divi-checkboxsingle";
                        }

                        $empty_class = '';
                        if ( $radio_show_empty == 'on' ){
                            $empty_class = 'show-empty';
                        }

                        $query_var_arr = preg_split('/(,|\|)/', $queryvar);
?>
                    <p class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                      <div class="et_pb_contact_field_options_wrapper radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style ) ?>">
                        <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>

                    <?php
                        if ( $radio_style == 'select' ) {
                    ?>
                        <div class="et_pb_checkbox_select_wrapper">
                            <label class="et_pb_contact_select"><?php echo $select_labeltext;?></label>
                    <?php
                        }
                    ?>
                        <!-- <form> -->
                        <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) ?> <?php echo $empty_class;?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $cat_key );?>" data-filter-name="<?php echo esc_attr( $cat_key );?>"  data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
                          <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on' ) && $only_show_avail == "off") { ?>
                          <span class="et_pb_contact_field_radio">
                            <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $cat_key );?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num );?>" data-name="<?php echo esc_attr( $cat_key );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo (count($query_var_arr) == 1 && $query_var_arr[0] == '')?'checked':'';?>>
                            <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                            <label class="radio-label" data-value="all" for="<?php echo esc_attr( $cat_key );?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                          </span>
                          <?php } ?>
                          <?php
                          if ( $get_categories ) :
                            foreach ( $get_categories as $cat ) :
                                if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                    continue;
                                }
                              ?>
                              <span class="et_pb_contact_field_radio">
                                <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $cat->slug ) ?>" name="<?php echo esc_attr( $cat_key ) . '_' . esc_attr( $num );?>" data-name="<?php echo esc_attr( $cat_key );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo in_array($cat->slug, $query_var_arr)?'checked':'';?>>
                                <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                <label class="radio-label" data-value="<?php echo esc_attr( $cat->slug ) ?>" for="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $cat->name );?>"><i></i><?php echo esc_html( $cat->name ); ?></label>
                              </span>
                              <?php
                            endforeach;
                          endif;
                          ?>
                          <!-- </form> -->
                      <?php
                        if ( $radio_style == 'select' ) {
                      ?>
                          </div>
                      <?php
                          }
                      ?>
                        </div>
                      </div>
                    </p>
<?php
                    }
                } else if ($filter_post_type == "search") {

                  if ($is_number_input == "on") {
                    $text_search_type = 'number';
                  } else {
                    $text_search_type = 'text';
                  }

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        if($show_label == "on"){
                            $custom_label_final = 'Search';
                        }else{
                            $custom_label_final='';
                        }
                    }

                    if (get_search_query() == "") {
                        $seach_value = get_search_query();
                    } else if ( !empty( $wp_query->query_vars['s']) ){
                        $seach_value = $wp_query->query_vars['s'];
                    } else {
                        $seach_value = "";
                    }

                    if ( $custom_label_final != '' ) {
                        do_action( 'wpml_register_single_string', $this->de_domain_name, 'Search Filter Label', $custom_label_final );
                    }
?>
                    <p class="et_pb_contact_field" data-type="input" data-filtertype="input" style="padding-left: 0;">
                        <span class="et_pb_contact_field_options_title"><label for="s_<?php echo esc_attr( $num );?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></label></span>
                        <input id="s_<?php echo esc_attr( $num );?>" class="divi-acf divi-filter-item" data-filter-option="<?php echo "s";?>" data-filtertype="textsearch" data-searchdelay="<?php echo esc_attr($text_typing_timeout); ?>" type="<?php echo esc_attr($text_search_type); ?>" name="s" data-name="s" placeholder="<?php echo esc_html__( $text_placeholder, $this->de_domain_name ); ?>" value="<?php echo esc_attr( $seach_value ) ?>" style="width: 100%;">
                    </p>
                  <?php
                } else if ($filter_post_type == "posttypes") {

                  if ($custom_label !== '') {
                    $custom_label_final = $custom_label;
                  } else {
                    $custom_label_final = '';
                  }

                  if ( $custom_label_final != '' ) {
                        do_action( 'wpml_register_single_string', $this->de_domain_name, 'PostType Filter Label', $custom_label_final );
                    }

                  $option_search  = array( '&#91;', '&#93;' );
                  $option_replace = array( '[', ']' );
                  $select_options = str_replace( $option_search, $option_replace, $select_options );
                  $select_options = json_decode( $select_options );
                  ?>
                  <p class="et_pb_contact_field_options_title"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                  <p class="et_pb_contact_field divi-filter-item" data-type="select" data-filtertype="select" data-filter-option="select_post_types">
                    <select id="select_post_types_<?php echo esc_attr( $num );?>" class="divi-acf et_pb_contact_select" data-filtertype="posttypes" name="select_post_types" data-name="select_post_types" data-field_type="select">
                      <option value="" selected="selected"><?php echo esc_html( $select_placeholder ) ?></option>
                      <?php
                      foreach ( $select_options as $option ) {
                        if ( in_array( $option->value , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $option->value, $include_option_array) ) ) {
                                continue;
                            }
                        $pt = get_post_type_object( $option->value );
                        ?>
                        <option value="<?php echo esc_attr( $option->value ); ?>"><?php echo esc_html( $pt->labels->name ); ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </p>
                  <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#select_post_types_<?php echo esc_html( $num );?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                } else if ( $filter_post_type == "taxonomy" ) {

                   // GET AVAILABLE TAXONOMIES
                  // 1) First we get the term query
                  if ($only_show_avail == "on") {
                    global $wp_query;
                    $avail_terms = "";
                    $current_query_var = $wp_query->query_vars;
                    unset( $current_query_var['paged']);
                    $current_query_var['posts_per_page'] = 999999;
                    $the_query = new WP_Query( $current_query_var );
                    $ID_array = $the_query->posts;
                    foreach($ID_array as $item) { // Then for each ID - we then look for the category
                      $terms_post = get_the_terms( $item->ID , $custom_tax_choose );
                      // 3) for each category we then add the ID to a string
                      if (is_array($terms_post)) {
                        foreach ($terms_post as $term_cat) {
                          $term_cat_id = $term_cat->term_id;
                          $avail_terms .= $term_cat_id.",";
                        }
                      }
                    }
                    $avail_terms = implode(',',array_unique(explode(',', $avail_terms)));
                    if ( $avail_terms == '' ){
                      $avail_terms = array(-1);
                      $this->add_classname( 'divi-hide');
                      $this->add_classname( 'no-avail-terms');
                    }
                  } else {
                    $avail_terms = '';
                  }
                  // GET AVAILABLE TAXONOMIES

                    $taxonomy_details = get_taxonomy( $custom_tax_choose );

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        $custom_label_final = $taxonomy_details->label;
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Taxonomy Filter Label - ' . $custom_tax_choose, $custom_label_final );

                    $orderby = 'term_id';

                    $cat_args = array(
                        'taxonomy'      => $custom_tax_choose, 
                        'hide_empty'    => $cat_tag_hide_empty_dis, 
                        'include'       => $avail_terms, 
                        'parent'        => 0,
                        'orderby'       => $orderby, 
                        'order'         => 'ASC'
                    );

                    if ( $taxonomy_order == 'id' ) {
                        $cat_args['orderby'] = 'term_id';
                    } else {
                        $cat_args['orderby'] = $taxonomy_order;
                    }

                    if ( $taxonomy_details->hierarchical == false ) {
                        $get_categories = get_terms( $cat_args );

                        if ( $taxonomy_order == 'numeric' ) {
                            usort( $get_categories, function($a, $b) {
                                return strnatcmp( $a->name, $b->name );
                            });
                            
                        }
                    } else {
                        $this->listTaxonomies( $cat_args, $get_categories );
                    }

                    $queryvar = get_query_var( $custom_tax_choose )?get_query_var( $custom_tax_choose):( !empty($_GET[$custom_tax_choose])? stripslashes(urldecode($_GET[$custom_tax_choose])) :'' );
                    $query_var_arr = preg_split('/(,|\|)/', $queryvar);

                    if ($acf_filter_type == "select") {

                        if ( $get_categories ) {
                            $tax_slugs = wp_list_pluck( $get_categories, 'slug' );
                            
                            if ( !empty ( $exclude_option_array ) ) {
                                $tax_slugs = array_diff( $tax_slugs, $exclude_option_array );
                            }

                            if ( !empty( $include_option_array ) ) {
                                $tax_slugs = array_intersect( $tax_slugs, $include_option_array);

                                if ( empty( $tax_slugs ) && $hide_module_for_empty == 'on' ) {
                                    $this->add_classname('hide_this');
                                }
                            }
                        } else {
                            if ( $hide_module_for_empty == 'on' ) {
                                $this->add_classname( 'hide_this' );
                            }
                        }
?>
                    <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                    <p class="et_pb_contact_field divi-filter-item" data-type="select" data-filtertype="select" name="<?php echo esc_attr( $taxonomy_details->name ) ?>" data-field_type="select" data-filter-option="<?php echo esc_attr( $custom_tax_choose );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $custom_tax_choose );?>">
                        <select id="<?php echo esc_attr( $custom_tax_choose ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-filtertype="customtaxonomy" data-field_type="select" data-name="<?php echo esc_attr( $custom_tax_choose ) ?>" name="<?php echo esc_attr( $custom_tax_choose ) . '_' . esc_attr( $num ); ?>">
                            <option value="" <?php echo ( count( $query_var_arr) == 1 && $query_var_arr[0] == '')?'selected':''; ?>><?php echo esc_html( $select_placeholder ) ?></option>
<?php
                        $first_parent_id = ( !empty( $get_categories) && is_array( $get_categories) )?$get_categories[0]->parent:0;
                        $cat_depth = array( $first_parent_id => 0 );
                        if ( $get_categories ) :
                            foreach ( $get_categories as $cat ) :
                                if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                    continue;
                                }
                                $parent_cat_id = $cat->parent;
                                $prefix = '';
                                if ( isset( $cat_depth[$parent_cat_id] ) ) {
                                    $prefix = str_repeat( $tax_sub_prefix, $cat_depth[ $parent_cat_id ] );
                                    $cat_depth[ $cat->term_id ] = $cat_depth[$parent_cat_id] + 1;
                                }
?>
                            <option id="<?php echo esc_attr( $cat->term_id ) . '_' . esc_attr( $num ); ?>" value="<?php echo esc_attr( $cat->slug ); ?>" <?php echo in_array( $cat->slug, $query_var_arr)?'selected':''; ?>><?php echo esc_html( $prefix ) . esc_html( $cat->name ); ?></option>
<?php
                            endforeach;
                        endif;
                        ?>
                        </select>
                    </p>
                    <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_html( $custom_tax_choose) . '_' . esc_html( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                    } else if ( $acf_filter_type == "radio" ) {

                        if ( $get_categories ) {
                            $tax_slugs = wp_list_pluck( $get_categories, 'slug' );
                            
                            if ( !empty ( $exclude_option_array ) ) {
                                $tax_slugs = array_diff( $tax_slugs, $exclude_option_array );
                            }

                            if ( !empty( $include_option_array ) ) {
                                $tax_slugs = array_intersect( $tax_slugs, $include_option_array);

                                if ( empty( $tax_slugs ) && $hide_module_for_empty == 'on' ) {
                                    $this->add_classname('hide_this');
                                }
                            }
                        } else {
                            if ( $hide_module_for_empty == 'on' ) {
                                $this->add_classname( 'hide_this' );
                            }
                        }

                        $empty_class = '';
                        if ( $radio_show_empty == 'on' ){
                            $empty_class = 'show-empty';
                        }

                        if ($radio_select == "checkbox") {
                            $checkboxtype = "divi-checkboxmulti";
                        } else {
                            $checkboxtype = "divi-checkboxsingle";
                        }
?>
                    <p class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                      <div class="et_pb_contact_field_options_wrapper radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style ) ?>">
                        <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                              <!-- <form> -->
                    <?php
                      if ( $radio_style == 'select' ) {
                    ?>
                        <div class="et_pb_checkbox_select_wrapper">
                            <label class="et_pb_contact_select"><?php echo $select_labeltext;?></label>
                    <?php
                        }
                    ?>
                        <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) ?> <?php echo esc_attr( $empty_class );?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $custom_tax_choose );?>" data-filter-name="<?php echo esc_attr( $custom_tax_choose );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
                          <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on' ) && $only_show_avail == "off") { ?>
                          <span class="et_pb_contact_field_radio">
                            <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $custom_tax_choose );?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" name="<?php echo esc_attr( $custom_tax_choose ) . '_' . esc_attr( $num );?>" data-name="<?php echo esc_attr( $custom_tax_choose );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo ( count($query_var_arr) == 1 && $query_var_arr[0]=='')?'checked="checked"':'';?>>
                            <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; }?>
                            <label class="radio-label" data-value="all" for="<?php echo esc_attr( $custom_tax_choose );?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                          </span>
                          <?php } ?>
                          <?php
                          $first_parent_id = ( !empty( $get_categories) && is_array( $get_categories) )?$get_categories[0]->parent:0;
                            $cat_depth = array( $first_parent_id => 0 );
                          if ( $get_categories ) :
                            $cat_inx = 0;
                            foreach ( $get_categories as $cat ) :
                                if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                    continue;
                                }

                                $cat_indent = "";
                                if ( in_array( $cat->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $cat->slug, $include_option_array) ) ) {
                                    $cat_inx++;
                                    continue;
                                }
                                $parent_cat_id = $cat->parent;
                                $cat_id = $cat->term_id;
                                $prefix = '';
                                $child_cats = get_terms(array( 'hide_empty' => true, 'parent' => $cat->term_id, 'taxonomy' => $cat->taxonomy ) );
                                $data_parent = '';
                                if ( !empty( $child_cats) && count( $child_cats ) > 0 ) {
                                    $data_parent = ' data-type="has-child"';
                                }
                                $collapsible_class = '';
                                if ( $cat_sub_collapsible == 'on' && ( $cat_inx < count($get_categories) - 1 ) && $cat->term_id == $get_categories[$cat_inx + 1]->parent ) { 
                                  $this->add_classname( 'sub_cat_collapsible');
                                    $collapsible_class = 'is-collapsible';

                                     
                                }
                                
                                
                                if ($radio_inline == 'off' && $sub_cat_indent_prefix == 'indent' && $cat->term_id == $get_categories[$cat_inx + 1]->parent) {
                                  $cat_indent = 'style="padding-left:'.esc_attr($cat_sub_indent) .';"';
                                }
                                
                                $cat_inx++;
                                if ( isset( $cat_depth[$parent_cat_id] ) ) {
                                    $prefix = str_repeat( $cat_sub_prefix, $cat_depth[ $parent_cat_id ] );
                                    $cat_depth[ $cat->term_id ] = $cat_depth[$parent_cat_id] + 1;
                                }

                                $parent_cat_id = $cat->parent;
                                $prefix = '';
                                if ( isset( $cat_depth[$parent_cat_id] ) ) {
                                    $prefix = str_repeat( $tax_sub_prefix, $cat_depth[ $parent_cat_id ] );
                                    $cat_depth[ $cat->term_id ] = $cat_depth[$parent_cat_id] + 1;
                                }
                              ?>
                              <span <?php echo $cat_indent; ?> class="et_pb_contact_field_radio">
                                <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ) ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $cat->slug ) ?>" name="<?php echo esc_attr( $custom_tax_choose) . '_' . esc_attr( $num );?>" data-name="<?php echo esc_attr( $custom_tax_choose );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo (!(count( $query_var_arr) == 1 && $query_var_arr[0] == '') && in_array( $cat->slug, $query_var_arr ))?'checked="checked"':'';?>>
                                <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                <label class="radio-label" data-value="<?php echo esc_attr( $cat->slug ) ?>" for="<?php echo esc_attr( $cat->term_id ); ?>_<?php echo esc_attr( $cat->slug ) . '_' . esc_attr( $num ) ?>" title="<?php echo esc_attr( $cat->name );?>"><i></i><?php echo esc_html( $prefix ) . esc_html( $cat->name ); ?></label>
                              </span>
                              <?php
                            endforeach;
                          endif;
                          ?>
                          <!-- </form> -->
                    <?php
                      if ( $radio_style == 'select' ) {
                    ?>
                        </div>
                    <?php
                        }
                    ?>
                        </div>
                      </div>
                    </p>
<?php
                    } else if ( $acf_filter_type == "number_range"){
                        $is_term_number = true;
                        $term_min = 99999999;
                        $term_max = 0;

                        if ( !empty( $get_categories ) && is_array( $get_categories ) ) {
                            foreach ($get_categories as $term) {
                                $term_slug = $term->slug;
                                if ( $value_type == 'decimal' ) {
                                    $term_slug = str_replace('-', '.', $term_slug );
                                }
                                if ( !is_numeric( $term_slug ) ) {
                                    $is_term_number = false;
                                    break;
                                }else {
                                    $number_slug = ($value_type == 'decimal')?floatval($term_slug):intval($term_slug);
                                    $term_max = max( $term_max, $number_slug );
                                    $term_min = min( $term_min, $number_slug );
                                }
                            }
                        }

                        if ( $is_term_number ) {
                            if (isset($queryvar)) {
                                $queryvar_arr = (explode(";",$queryvar));
                                if ( is_array( $queryvar_arr ) ) {
                                    if ( isset( $queryvar_arr[1] ) ){
                                        $range_from_query = $queryvar_arr[0];
                                        $range_to_query = $queryvar_arr[1];
                                    }else{
                                        $range_from_query = $queryvar_arr[0];
                                        $range_to_query = '';
                                    }
                                } else {
                                    $range_from_query = "";
                                    $range_to_query = "";
                                }
                            }

                            if ($range_from_query != "") {
                                $range_from = $range_from_query;
                            }
                            if ( $range_from > $term_max ) {
                                $range_from = 0;
                            }
                            if ($range_to_query != "") {
                                $range_to = $range_to_query;
                            }

                            if ( $term_max < $range_to) {
                                $range_to = $term_max;
                            }
?>
                        <div class="et_pb_contact_field" data-type="range" data-filtertype="range">
                            <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                            <div class="divi-filter-item" data-filter-option="<?php echo esc_attr( $custom_tax_choose );?>">
                              <input id="<?php echo esc_attr( $custom_tax_choose ) . '_' . esc_attr( $num ); ?>" type="select" class="divi-acf js-range-slider" data-filtertype="rangeslider" data-field_type="range" name="<?php echo esc_attr( $custom_tax_choose );?>" data-name="<?php echo esc_attr( $custom_tax_choose );?>" value="" />
                            </div>
                        </div>
<?php
                                $css_classrend = "." . $css_class . "";
?>
                        <style>
                          <?php echo esc_html( $css_classrend ) ?> .irs-bar,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single,
                          <?php echo esc_html( $css_classrend ) ?> span:not(.irs--sharp) .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-sharp .irs-handle{
                              background: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--sharp .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single:before {
                              border-top-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs-line,
                          <?php echo esc_html( $css_classrend ) ?> .irs-min,
                          <?php echo esc_html( $css_classrend ) ?> .irs-max {
                            background-color: <?php echo esc_html( $range_sec_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--round .irs-handle {
                           border-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                        </style>
                        <script>
                        jQuery(document).ready(function($) {

                          var type = 'double',
                          min = <?php echo esc_html( $term_min) ?>,
                          max = <?php echo esc_html( $term_max) ?>,
                          from = <?php echo esc_html( $range_from) ?>,
                          to = <?php echo esc_html( $range_to ) ?>,
                          step = <?php echo esc_html( $range_step ) ?>,
                          skin = "<?php echo esc_html( $range_skin ) ?>",
                          hide_min_max = <?php echo esc_html( $range_hide_min_max ) ?>,
                          hide_from_to = <?php echo esc_html( $range_hide_from_to ) ?>,
                          prettify_enabled = <?php echo esc_html( $range_prettify_enabled ) ?>,
                          prettify_separator = "<?php echo esc_html( $range_prettify_separator ) ?>",
                          prefix = "<?php echo esc_html( $range_prefix ) ?>",
                          postfix = "<?php echo esc_html( $range_postfix ) ?>";

                          var filters = [];

                          var filter_item_name_arr = [];
                          var filter_item_id_arr = [];
                          var filter_item_val_arr = [];
                          var filter_input_type_arr = [];
                          jQuery('.divi-acf').each(function(i, obj) {
                            var filter_item_name = jQuery(this).attr("name"),
                            filter_item_id = jQuery(this).attr("id"),
                            filter_item_val = jQuery(this).val(),
                            filter_input_type = jQuery(this).attr('type');
                            filter_item_name_arr.push(filter_item_name);
                            filter_item_id_arr.push(filter_item_id);
                            filter_item_val_arr.push(filter_item_val);
                            filter_input_type_arr.push(filter_input_type);
                          });

                          var filter_item_name = jQuery(".<?php echo esc_html( $css_class ) ?> .js-range-slider").attr("name");

                          <?php if ($range_number_custom == 'custom') {
                            ?>
                            var range_custom_values = [<?php echo esc_html( $range_custom_values ) ?>],
                                from = range_custom_values.indexOf(<?php echo esc_html( $range_from ) ?>),
                                to = range_custom_values.indexOf(<?php echo esc_html( $range_to ) ?>);
                            <?php
                          }
                          ?>

                          $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").ionRangeSlider({
                            type: type,
                            <?php if ($range_number_custom == 'default') { ?>
                            min: min,
                            max: max,
                            <?php } else { ?>
                            values: range_custom_values,
                            <?php } ?>
                            from: from,
                            to: to,
                            step: step,
                            skin: skin,
                            hide_min_max: hide_min_max,
                            hide_from_to: hide_from_to,
                            prettify_enabled: prettify_enabled,
                            prettify_separator: prettify_separator,
                            prefix: prefix,
                            postfix: postfix,
                            onFinish: function (data) {
                              if ( $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.et_pb_de_mach_search_posts').length == 0 && $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.updatetype-update_button').length == 0 ){

                                      var _this = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                                      var iris_to = data.to;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text();
                                      var irs_from = data.from;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                      if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) && (irs_from != 0 || iris_to != max ) ) {
                                        if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                                          var filter_param_type = "title";
                                        } else {
                                          var filter_param_type = "no-title";
                                        }
                                        var value = _this.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                                        name = _this.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                                        slug = _this.data("name"),
                                        type = 'range';
                                        //iris_to = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                                        //irs_from = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                        divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                                      } else {
                                        if (jQuery('.param-' + _this.data('name') ).length) {
                                          jQuery('.param-' + _this.data('name') ).remove();
                                        }
                                      }
                                divi_find_filters_to_filter();
                              }
                            }
                          });
<?php
                                if ( !empty( $_GET[$custom_tax_choose] ) && ( $range_from != $term_min || $range_to != $term_max ) ) {
?>
                        var acf_slider = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                        if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) ) {
                            if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                              var filter_param_type = "title";
                            } else {
                              var filter_param_type = "no-title";
                            }
                            var value = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                            name = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                            slug = acf_slider.attr("name"),
                            type = 'range',
                            slider_data = acf_slider.data('ionRangeSlider'),
                            iris_to = slider_data.options.to, //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                            irs_from = slider_data.options.from; //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                            divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                        }
<?php
                                }
?>
                        });
                      </script>
<?php
                        } else {
                            echo '<p>' . esc_html__( 'This taxonomy contains non numeric value.', $this->de_domain_name ) . '</p>';
                        }
                    }
                } else if ($filter_post_type == "productattr") {


                  // GET AVAILABLE PRO ATTR
                  // 1) First we get the term query
                  if ($only_show_avail == "on") {
                    // 2) We get the WP_Query - get all the posts ID's on the page
                    global $wp_query;
                    $avail_terms = "";
                    $current_query_var = $wp_query->query_vars;
                    unset( $current_query_var['paged']);
                    $current_query_var['posts_per_page'] = 999999;
                    $the_query = new WP_Query( $current_query_var );
                    $ID_array = $the_query->posts;
                    foreach($ID_array as $item) { // Then for each ID - we then look for the category
                      $terms_post = get_the_terms( $item->ID , $product_attribute );
                      // 3) for each category we then add the ID to a string
                      if (is_array($terms_post)) {
                        foreach ($terms_post as $term_cat) {
                          $term_cat_id = $term_cat->term_id;
                          $avail_terms .= $term_cat_id.",";
                        }
                      }
                    }
                    $avail_terms = implode(',',array_unique(explode(',', $avail_terms)));
                    if ( $avail_terms == '' ){
                      $avail_terms = array(-1);
                      $this->add_classname( 'divi-hide');
                      $this->add_classname( 'no-avail-terms');
                    }
                  } else {
                    $avail_terms = '';
                  }
                  // GET AVAILABLE PRO ATTR

                    $orderby = 'term_id';

                    if ( $taxonomy_order != 'numeric' && $taxonomy_order != 'id' ) {
                        $orderby = $taxonomy_order;
                    }

                    $terms_array = array(
                        'taxonomy' => $product_attribute,
                        'hide_empty' => $cat_tag_hide_empty_dis,
                        'include' => $avail_terms,
                        'orderby' => $orderby,
                        'order'   => 'ASC'
                    );

                    $terms = get_terms( $terms_array );

                    if ( $taxonomy_order == 'numeric' ) {

                        usort( $terms, function($a, $b) {
                            return strnatcmp( $a->name, $b->name );
                        });
                    }

                    $name = str_replace( 'pa_', '', wc_sanitize_taxonomy_name( $product_attribute ) );
                    $taxonomy_array = wc_get_attribute_taxonomies();
                    $taxonomies = wp_list_pluck( $taxonomy_array, 'attribute_label', 'attribute_name' );
                    $taxonomy_types = wp_list_pluck( $taxonomy_array, 'attribute_type', 'attribute_name' );

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    }else{
                        $custom_label_final = $taxonomies[$name];
                    }
                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Product Attribute Filter Label - ' . $product_attribute, $custom_label_final );

                    $queryvar = get_query_var( $product_attribute )?get_query_var( $product_attribute):( !empty($_GET[$product_attribute])? stripslashes(urldecode($_GET[$product_attribute])) :'' );
                    $query_var_arr = preg_split('/(,|\|)/', $queryvar);

                    if ($radio_select == "checkbox") {
                        $checkboxtype = "divi-checkboxmulti";
                    } else {
                        $checkboxtype = "divi-checkboxsingle";
                    }

                    if ( $attribute_swatch == 'on' ){

                        if ( !empty( $terms ) ) {
                            $term_slugs = wp_list_pluck( $terms, 'slug' );
                            
                            if ( !empty ( $exclude_option_array ) ) {
                                $term_slugs = array_diff( $term_slugs, $exclude_option_array );
                            }

                            if ( !empty( $include_option_array ) ) {
                                $term_slugs = array_intersect( $term_slugs, $include_option_array);

                                if ( empty( $term_slugs ) && $hide_module_for_empty == 'on' ) {
                                    $this->add_classname('hide_this');
                                }
                            }
                        } else {
                            if ( $hide_module_for_empty == 'on' ) {
                                $this->add_classname( 'hide_this' );
                            }
                        }

                        if ( $taxonomy_types[$name] != 'select' && $taxonomy_types[$name] != 'button' ) {
?>
                    <div class="et_pb_contact_field divi-swatch" data-type="radio" data-filtertype="radio">
                        <div class="et_pb_contact_field_options_wrapper">
                            <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                            <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype );?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $product_attribute );?>" data-filter-name="<?php echo esc_attr( $product_attribute );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
                                <span class="et_pb_contact_field_radio remove_filter">
                                    <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $product_attribute );?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype );?>" value="" name="<?php echo esc_attr( $product_attribute );?>" data-name="<?php echo esc_attr( $product_attribute );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo (count($query_var_arr) == 1 && $query_var_arr[0] == '')?'checked':'';?>>
                                    <label class="radio-label" data-value="all" for="<?php echo esc_attr( $product_attribute );?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( 'Remove Filter', $this->de_domain_name ); ?></label>
                                </span>
<?php
                            if ( !empty( $terms ) ) {
                                foreach ($terms as $term) {
                                    if ( in_array( $term->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term->slug, $include_option_array) ) ) {
                                        continue;
                                    }
                                    $value = get_term_meta( $term->term_id, 'product_attribute_'.$taxonomy_types[$name], TRUE );
?>
                                <span class="et_pb_contact_field_radio">
                                    <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $term->term_id ); ?>_<?php echo esc_attr( $term->slug ) . '_' . esc_attr( $num ) ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype );?>" value="<?php echo esc_attr( $term->slug ) ?>" name="<?php echo esc_attr( $product_attribute );?>" data-name="<?php echo esc_attr( $product_attribute );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo in_array( $term->slug, $query_var_arr )?'checked':'';?>>
                                    <label class="radio-label" data-value="<?php echo esc_attr( $term->slug ) ?>" title="<?php echo esc_attr( $term->name );?>" for="<?php echo esc_attr( $term->term_id ); ?>_<?php echo esc_attr( $term->slug ) . '_' . esc_attr( $num ) ?>"><i style="<?php echo ($taxonomy_types[$name] == 'color')?'background':'background-image';?>:<?php echo ($taxonomy_types[$name] == 'color' )? esc_attr( $value ):"url('". esc_attr( $value )."')";?>;background-size: cover;background-repeat: no-repeat;background-position: center;"></i></label>
                                </span>
<?php
                                }
                            }
?>
                            </div>
                        </div>
                    </div>
<?php
                        } else if ( $taxonomy_types[$name] == 'button' ){
?>
                    <div class="et_pb_contact_field divi-swatch" data-type="radio" data-filtertype="radio">
                        <div class="et_pb_contact_field_options_wrapper">
                            <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                            <div class="et_pb_contact_field_options_list divi-filter-item divi-checkboxsingle <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $product_attribute );?>" data-filter-name="<?php echo esc_attr( $product_attribute );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
                                <span class="et_pb_contact_field_radio remove_filter">
                                    <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $product_attribute );?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="divi-checkboxsingle" value="" name="<?php echo esc_attr( $product_attribute );?>" data-name="<?php echo esc_attr( $product_attribute );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo ( count($query_var_arr) == 1 && $query_var_arr[0] == '' )?'checked':'';?>>
                                    <label class="radio-label" data-value="all" for="<?php echo esc_attr( $product_attribute );?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( 'Remove Filter', $this->de_domain_name ); ?></label>
                                </span>
<?php
                            if ( !empty( $terms ) ) {
                                foreach ($terms as $term) {
                                    if ( in_array( $term->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term->slug, $include_option_array) ) ) {
                                        continue;
                                    }
                                    $value = get_term_meta( $term->term_id, 'product_attribute_'.$taxonomy_types[$name], TRUE );
?>
                                <span class="et_pb_contact_field_radio">
                                    <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $term->term_id ); ?>_<?php echo esc_attr( $term->slug ) . '_' . esc_attr( $num ) ?>" class="divi-acf input" data-filtertype="divi-checkboxsingle" value="<?php echo esc_attr( $term->slug ) ?>" name="<?php echo esc_attr( $product_attribute );?>" data-name="<?php echo esc_attr( $product_attribute );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo in_array( $term->slug, $query_var_arr )?'checked':'';?>>
                                    <label class="radio-label" data-value="<?php echo esc_attr( $term->slug ) ?>" title="<?php echo esc_attr( $term->name );?>" for="<?php echo esc_attr( $term->term_id ); ?>_<?php echo esc_attr( $term->slug ) . '_' . esc_attr( $num ) ?>"><i><?php echo esc_html( $term->name );?></i></label>
                                </span>
<?php
                                }
                            }
?>
                            </div>
                        </div>
                    </div>
<?php
                        } else if ( $taxonomy_types[$name] == 'select' ) {
?>
                        <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                        <div class="et_pb_contact_field divi-filter-item" data-type="select" data-field_type="select" data-filtertype="select" data-filter-option="<?php echo esc_attr( $product_attribute );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $product_attribute );?>">
                          <select id="<?php echo esc_attr( $product_attribute ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-field_type="select" data-filtertype="customtag" data-name="<?php echo esc_attr( $product_attribute ) ?>" name="<?php echo esc_attr( $product_attribute ) ?>">
                            <option value="" <?php echo ( count($query_var_arr) == 1 &&  $query_var_arr[0] == '' )?'selected':'';?>><?php echo esc_html( $select_placeholder ) ?></option>
                            <?php
                            if ( !empty($terms) ) :
                              foreach ( $terms as $term ) :
                                if ( in_array( $term->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term->slug, $include_option_array) ) ) {
                                    continue;
                                }
                                ?>
                                <option id="<?php echo esc_attr( $term->term_id ) . '_' . esc_attr( $num ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" <?php echo in_array( $term->slug, $query_var_arr )?'selected':'';?>><?php echo esc_html( $term->name ); ?></option>
                                <?php
                              endforeach;
                            endif;
                            ?>
                          </select>
                        </div>
                        <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_html( $product_attribute ) . '_' . esc_html( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                        }
                    }else{
                        if ($acf_filter_type == "select") {

                            if ( !empty( $terms ) ) {
                                $term_slugs = wp_list_pluck( $terms, 'slug' );
                                
                                if ( !empty ( $exclude_option_array ) ) {
                                    $term_slugs = array_diff( $term_slugs, $exclude_option_array );
                                }

                                if ( !empty( $include_option_array ) ) {
                                    $term_slugs = array_intersect( $term_slugs, $include_option_array);

                                    if ( empty( $term_slugs ) && $hide_module_for_empty == 'on' ) {
                                        $this->add_classname('hide_this');
                                    }
                                }
                            } else {
                                if ( $hide_module_for_empty == 'on' ) {
                                    $this->add_classname( 'hide_this' );
                                }
                            }
?>
                        <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                        <div class="et_pb_contact_field divi-filter-item" data-type="select" data-field_type="select" data-filtertype="select" data-filter-option="<?php echo esc_attr( $product_attribute );?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="<?php echo esc_attr( $product_attribute );?>">
                            <select id="<?php echo esc_attr( $product_attribute ) . '_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-field_type="select" data-filtertype="customtag" data-name="<?php echo esc_attr( $product_attribute ) ?>" name="<?php echo esc_attr( $product_attribute ) ?>">
                                <option value="" <?php echo ( count($query_var_arr) == 1 && $query_var_arr[0] == '' )?'selected':'';?>><?php echo esc_html( $select_placeholder ) ?></option>
                            <?php
                                if ( !empty($terms) ) :
                                    foreach ( $terms as $term ) :
                                        if ( in_array( $term->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term->slug, $include_option_array) ) ) {
                                            continue;
                                        }
                            ?>
                                <option id="<?php echo esc_attr( $term->term_id ) . '_' . esc_attr( $num ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" <?php echo in_array( $term->slug, $query_var_arr )?'selected':'';?>><?php echo esc_attr( $term->name ); ?></option>
                        <?php
                                    endforeach;
                                endif;
                        ?>
                            </select>
                        </div>
                        <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo esc_attr( $product_attribute ) . '_' . esc_attr( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                        } else if ( $acf_filter_type == "radio" ) {

                            if ( !empty( $terms ) ) {
                                $term_slugs = wp_list_pluck( $terms, 'slug' );
                                
                                if ( !empty ( $exclude_option_array ) ) {
                                    $term_slugs = array_diff( $term_slugs, $exclude_option_array );
                                }

                                if ( !empty( $include_option_array ) ) {
                                    $term_slugs = array_intersect( $term_slugs, $include_option_array);

                                    if ( empty( $term_slugs ) && $hide_module_for_empty == 'on' ) {
                                        $this->add_classname('hide_this');
                                    }
                                }
                            } else {
                                if ( $hide_module_for_empty == 'on' ) {
                                    $this->add_classname( 'hide_this' );
                                }
                            }
                            
                            if ($radio_select == "checkbox") {
                                $checkboxtype = "divi-checkboxmulti";
                            } else {
                                $checkboxtype = "divi-checkboxsingle";
                            }

                            $empty_class = '';
                            if ( $radio_show_empty == 'on' ){
                                $empty_class = 'show-empty';
                            }
   ?>
                          <p class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                            <div class="et_pb_contact_field_options_wrapper radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style ) ?>">
                              <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>

                          <?php
                            if ( $radio_style == 'select' ) {
                          ?>
                              <div class="et_pb_checkbox_select_wrapper">
                                  <label class="et_pb_contact_select"><?php echo $select_labeltext;?></label>
                          <?php
                              }
                          ?>
                              <!-- <form> -->
                              <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) ?> <?php echo esc_attr($empty_class); ?> <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="<?php echo esc_attr( $product_attribute );?>" data-filter-name="<?php echo esc_attr( $product_attribute );?>" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
                                <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on' ) && $only_show_avail == "off" ) { ?>
                                <span class="et_pb_contact_field_radio">
                                  <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $product_attribute ); ?>_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" data-name="<?php echo esc_attr( $product_attribute );?>" name="<?php echo esc_attr( $product_attribute );?>" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo ( count($query_var_arr) == 1 && $query_var_arr[0] == '' )?'checked':'';?>>
                                  <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; }?>
                                  <label class="radio-label" data-value="all" for="<?php echo esc_attr( $product_attribute ); ?>_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                                </span>
                                <?php } ?>
                                <?php
                                if ( $terms ) :
                                  foreach ( $terms as $term ) :
                                    if ( in_array( $term->slug , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term->slug, $include_option_array) ) ) {
                                        continue;
                                    }
                                    ?>
                                    <span class="et_pb_contact_field_radio">
                                      <input type="<?php echo esc_attr( $radio_select ) ?>" id="<?php echo esc_attr( $term->term_id ); ?>_<?php echo esc_attr( $term->slug ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $term->slug ) ?>" data-name="<?php echo esc_attr( $product_attribute );?>" name="<?php echo esc_attr( $product_attribute );?>" data-required_mark="required" data-field_type="radio" <?php echo in_array($term->slug, $query_var_arr)?'checked':'';?> data-original_id="radio">
                                      <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                      <label class="radio-label" data-value="<?php echo esc_attr( $term->slug ) ?>" for="<?php echo esc_attr( $term->term_id ); ?>_<?php echo esc_attr( $term->slug ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $term->name );?>"><i></i><?php echo esc_html( $term->name ); ?></label>
                                    </span>
                                    <?php
                                  endforeach;
                                endif;
                                ?>
                                <!-- </form> -->
                          <?php
                            if ( $radio_style == 'select' ) {
                          ?>
                              </div>
                          <?php
                              }
                          ?>
                              </div>
                            </div>
                          </p>
<?php
                        } else if ( $acf_filter_type == "number_range"){
                            $is_term_number = true;
                            $term_min = 999999999;
                            $term_max = 0;
                            foreach ($terms as $term) {
                                $term_slug = $term->slug;
                                if ( $value_type == 'decimal' ) {
                                    $term_slug = str_replace('-', '.', $term_slug );
                                }
                                if ( !is_numeric( $term_slug ) ) {
                                    $is_term_number = false;
                                    break;
                                }else {
                                    $number_slug = ($value_type == 'decimal')?floatval($term_slug):intval($term_slug);
                                    $term_max = max( $term_max, $number_slug );
                                    $term_min = min( $term_min, $number_slug );
                                }
                            }

                            if ( $is_term_number ) {
                                if (isset($queryvar)) {
                                    $queryvar_arr = (explode(";",$queryvar));
                                    if ( is_array( $queryvar_arr ) ) {
                                        if ( isset( $queryvar_arr[1] ) ){
                                            $range_from_query = $queryvar_arr[0];
                                            $range_to_query = $queryvar_arr[1];
                                        }else{
                                            $range_from_query = $queryvar_arr[0];
                                            $range_to_query = '';
                                        }
                                    } else {
                                        $range_from_query = "";
                                        $range_to_query = "";
                                    }
                                }

                                if ($range_from_query != "") {
                                    $range_from = $range_from_query;
                                }
                                if ( $range_from > $term_max ) {
                                    $range_from = 0;
                                }
                                if ($range_to_query != "") {
                                    $range_to = $range_to_query;
                                }

                                if ( $term_max < $range_to) {
                                    $range_to = $term_max;
                                }
?>
                        <div class="et_pb_contact_field" data-type="range" data-filtertype="range">
                            <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                            <div class="divi-filter-item" data-filter-option="<?php echo esc_attr( $product_attribute );?>">
                              <input id="<?php echo esc_attr( $product_attribute ) . '_' . esc_attr( $num ); ?>" type="select" class="divi-acf js-range-slider" data-filtertype="rangeslider" data-field_type="range" name="<?php echo esc_attr( $product_attribute );?>" data-name="<?php echo esc_attr( $product_attribute );?>" value="" />
                            </div>
                        </div>
<?php
                                $css_classrend = "." . $css_class . "";
?>
                        <style>
                          <?php echo esc_html( $css_classrend ) ?> .irs-bar,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single,
                          <?php echo esc_html( $css_classrend ) ?> span:not(.irs--sharp) .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-sharp .irs-handle{
                              background: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--sharp .irs-handle>i:first-child,
                          <?php echo esc_html( $css_classrend ) ?> .irs-from:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-to:before,
                          <?php echo esc_html( $css_classrend ) ?> .irs-single:before {
                              border-top-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs-line,
                          <?php echo esc_html( $css_classrend ) ?> .irs-min,
                          <?php echo esc_html( $css_classrend ) ?> .irs-max {
                            background-color: <?php echo esc_html ($range_sec_color ); ?> !important;
                          }
                          <?php echo esc_html( $css_classrend ) ?> .irs--round .irs-handle {
                           border-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
                        </style>
                        <script>
                        jQuery(document).ready(function($) {

                          var type = 'double',
                          min = <?php echo esc_html( $term_min ) ?>,
                          max = <?php echo esc_html( $term_max ) ?>,
                          from = <?php echo esc_html( $range_from ) ?>,
                          to = <?php echo esc_html( $range_to ) ?>,
                          step = <?php echo esc_html( $range_step ) ?>,
                          skin = "<?php echo esc_html( $range_skin ) ?>",
                          hide_min_max = <?php echo esc_html( $range_hide_min_max ) ?>,
                          hide_from_to = <?php echo esc_html( $range_hide_from_to ) ?>,
                          prettify_enabled = <?php echo esc_html( $range_prettify_enabled ) ?>,
                          prettify_separator = "<?php echo esc_html( $range_prettify_separator ) ?>",
                          prefix = "<?php echo esc_html( $range_prefix ) ?>",
                          postfix = "<?php echo esc_html( $range_postfix ) ?>";

                          var filters = [];

                          var filter_item_name_arr = [];
                          var filter_item_id_arr = [];
                          var filter_item_val_arr = [];
                          var filter_input_type_arr = [];
                          jQuery('.divi-acf').each(function(i, obj) {
                            var filter_item_name = jQuery(this).attr("name"),
                            filter_item_id = jQuery(this).attr("id"),
                            filter_item_val = jQuery(this).val(),
                            filter_input_type = jQuery(this).attr('type');
                            filter_item_name_arr.push(filter_item_name);
                            filter_item_id_arr.push(filter_item_id);
                            filter_item_val_arr.push(filter_item_val);
                            filter_input_type_arr.push(filter_input_type);
                          });

                          var filter_item_name = jQuery(".<?php echo esc_html( $css_class ) ?> .js-range-slider").attr("name");

                          <?php if ($range_number_custom == 'custom') {
                            ?>
                            var range_custom_values = [<?php echo esc_html( $range_custom_values ) ?>],
                                from = range_custom_values.indexOf(<?php echo esc_html( $range_from ) ?>),
                                to = range_custom_values.indexOf(<?php echo esc_html( $range_to ) ?>);
                            <?php
                          }
                          ?>

                          $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").ionRangeSlider({
                            type: type,
                            <?php if ($range_number_custom == 'default') { ?>
                            min: min,
                            max: max,
                            <?php } else { ?>
                            values: range_custom_values,
                            <?php } ?>
                            from: from,
                            to: to,
                            step: step,
                            skin: skin,
                            hide_min_max: hide_min_max,
                            hide_from_to: hide_from_to,
                            prettify_enabled: prettify_enabled,
                            prettify_separator: prettify_separator,
                            prefix: prefix,
                            postfix: postfix,
                            onFinish: function (data) {
                              if ( $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.et_pb_de_mach_search_posts').length == 0 && $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.updatetype-update_button').length == 0 ){

                                      var _this = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                                      var iris_to = data.to;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text();
                                      var irs_from = data.from;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                      if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) && (irs_from != 0 || iris_to != max ) ) {
                                        if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                                          var filter_param_type = "title";
                                        } else {
                                          var filter_param_type = "no-title";
                                        }
                                        var value = _this.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                                        name = _this.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                                        slug = _this.data("name"),
                                        type = 'range';
                                        //iris_to = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                                        //irs_from = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                        divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                                      } else {
                                        if (jQuery('.param-' + _this.data('name') ).length) {
                                          jQuery('.param-' + _this.data('name') ).remove();
                                        }
                                      }
                                divi_find_filters_to_filter();
                              }
                            }
                          });
<?php
                                if ( !empty( $_GET[$product_attribute] ) && ( $range_from != $term_min || $range_to != $term_max ) ) {
?>
                        var acf_slider = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                        if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) ) {
                            if ( acf_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                              var filter_param_type = "title";
                            } else {
                              var filter_param_type = "no-title";
                            }
                            var value = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                            name = acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                            slug = acf_slider.attr("name"),
                            type = 'range',
                            slider_data = acf_slider.data('ionRangeSlider'),
                            iris_to = slider_data.options.to, //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                            irs_from = slider_data.options.from; //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                            divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                        }
<?php
                                }
?>
                        });
                      </script>
<?php
                            } else {
                                echo '<p>' . esc_html__( 'This attribute contains non numeric value.', $this->de_domain_name ) . '</p>';
                            }
                        }
                    }
                } else if ( $filter_post_type == "productprice" ) {
                    $product_cat  = get_query_var( 'product_cat' )?get_query_var('product_cat') : ( !empty($_GET['product_cat'])? stripslashes(urldecode($_GET['product_cat'])) : '');
                    $queryvar = get_query_var('product_price') ? get_query_var('product_price') : ( !empty( $_GET['product_price'] )? $_GET['product_price'] : '' );

                    if ( $max_price_type == 'store' || $max_price_type == 'category' ) {
                        $sql = "SELECT MAX(a.max_price) AS max_price FROM {$wpdb->wc_product_meta_lookup} a JOIN {$wpdb->posts} b ON a.product_id=b.id";
                        if ( $max_price_type == 'category' && !empty( $product_cat ) ) {
                            $current_cat = get_term_by( 'slug', $product_cat, 'product_cat' );
                            $current_cat_id = $current_cat->term_id;
                            $categories = get_categories( array( 'child_of' => $current_cat->term_id, 'taxonomy' => 'product_cat' ) );
                            $cat_ids = array( $current_cat_id );
                            foreach ( $categories as $cat_key => $cat ) {
                                $cat_ids[] = $cat->term_id;
                            }
                            $sql .= " JOIN {$wpdb->term_relationships} c ON b.id = c.object_id JOIN {$wpdb->term_taxonomy} d ON c.term_taxonomy_id = d.term_taxonomy_id JOIN {$wpdb->terms} e ON d.term_id = e.term_id WHERE e.term_id IN (". implode(',', $cat_ids ) . ")";
                        }

                        $max_price = ceil( $wpdb->get_var( $sql ) );

                        if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
                            $tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
                            $tax_rates = WC_Tax::get_rates( $tax_class );

                            if ( $tax_rates ) {
                                $max_price = ceil( $max_price + WC_Tax::get_tax_total( WC_Tax::calc_inclusive_tax( $max_price, $tax_rates ) ) );
                            }
                        }

                    } else {
                        $max_price = $range_to;
                    }

                    if ( $min_price_type == 'store' || $min_price_type == 'category' ) {
                      $sql = "SELECT MIN(a.min_price) AS min_price FROM {$wpdb->wc_product_meta_lookup} a JOIN {$wpdb->posts} b ON a.product_id=b.id";
                      if ( $min_price_type == 'category' && !empty( $product_cat ) ) {
                          $current_cat = get_term_by( 'slug', $product_cat, 'product_cat' );
                          $current_cat_id = $current_cat->term_id;
                          $categories = get_categories( array( 'child_of' => $current_cat->term_id, 'taxonomy' => 'product_cat' ) );
                          $cat_ids = array( $current_cat_id );
                          foreach ( $categories as $cat_key => $cat ) {
                              $cat_ids[] = $cat->term_id;
                          }

                          $product_visibility_terms = wc_get_product_visibility_term_ids();
                          $product_visibility_not_in = $product_visibility_terms['exclude-from-search'] . ',' . $product_visibility_terms['exclude-from-catalog'];
                          $sql .= " JOIN {$wpdb->term_relationships} c ON b.id = c.object_id JOIN {$wpdb->term_taxonomy} d ON c.term_taxonomy_id = d.term_taxonomy_id JOIN {$wpdb->terms} e ON d.term_id = e.term_id WHERE e.term_id IN (". implode(',', $cat_ids ) . ") AND b.id not in (select p_a.id from {$wpdb->posts}  p_a JOIN {$wpdb->term_relationships} r_b ON p_a.id=r_b.object_id WHERE r_b.term_taxonomy_id IN (" . $product_visibility_not_in . ") group by p_a.id)";
                      }

                      $min_price = floor( $wpdb->get_var( $sql ) );

                      if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
                          $tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
                          $tax_rates = WC_Tax::get_rates( $tax_class );

                          if ( $tax_rates ) {
                              $min_price = ceil( $min_price + WC_Tax::get_tax_total( WC_Tax::calc_inclusive_tax( $min_price, $tax_rates ) ) );
                          }
                      }

                  } else {
                      $min_price = $range_from;
                  }

                    $range_from_query = $min_price;
                    $range_to_query = $max_price;
                    if ( !empty( $queryvar ) ){
                        $price_arr = (explode(";", $queryvar));
                        if ( is_array( $price_arr ) ) {
                            if ( isset( $price_arr[1] ) ) {
                                $range_from_query = $price_arr[0];
                                $range_to_query = $price_arr[1];
                            }else{
                                $range_from_query = $price_arr[0];
                                $range_to_query = '';
                            }
                        }
                    }

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        $custom_label_final = 'Price Range';
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Product Price Filter Label', $custom_label_final );

?>
                    <div class="et_pb_contact_field" data-type="range" data-filtertype="range">
                        <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css );?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                        <div class="divi-filter-item" data-filter-option="product_price">
                            <input id="<?php echo "price_" . esc_attr( $num );?>" type="input" class="divi-acf js-range-slider" data-filtertype="rangeslider" data-name="product_price" name="product_price" value="" />
                        </div>
                    </div>
<?php
                    $css_classrend = '.' . $css_class;
?>
            <style>
                <?php echo esc_html( $css_classrend ) ?> .irs-bar,
                <?php echo esc_html( $css_classrend ) ?> .irs-from,
                <?php echo esc_html( $css_classrend ) ?> .irs-to,
                <?php echo esc_html( $css_classrend ) ?> .irs-single,
                <?php echo esc_html( $css_classrend ) ?> span:not(.irs--sharp) .irs-handle>i:first-child,
                <?php echo esc_html( $css_classrend ) ?> .irs--sharp .irs-handle{
                    background: <?php echo esc_html( $range_prim_color ); ?> !important;
                }
                <?php echo esc_html( $css_classrend ) ?> .irs--sharp .irs-handle>i:first-child,
                <?php echo esc_html( $css_classrend ) ?> .irs-from:before,
                <?php echo esc_html( $css_classrend ) ?> .irs-to:before,
                <?php echo esc_html( $css_classrend ) ?> .irs-single:before {
                    border-top-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                }
                <?php echo esc_html( $css_classrend ) ?> .irs-line,
                <?php echo esc_html( $css_classrend ) ?> .irs-min,
                <?php echo esc_html( $css_classrend ) ?> .irs-max {
                    background-color: <?php echo esc_html( $range_sec_color ); ?> !important;
                }
                          <?php echo esc_html( $css_classrend ) ?> .irs--round .irs-handle {
                           border-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
            </style>
        <script>
            jQuery(document).ready(function($) {

                var from = <?php echo esc_html( $range_from_query ) ?>,
                to = <?php echo esc_html( $range_to_query ) ?>,
                step = <?php echo esc_html( $range_step ) ?>,
                skin = "<?php echo esc_html( $range_skin ) ?>",
                hide_min_max = <?php echo esc_html( $range_hide_min_max ) ?>,
                hide_from_to = <?php echo esc_html( $range_hide_from_to ) ?>,
                prettify_enabled = <?php echo esc_html( $range_prettify_enabled ) ?>,
                prettify_separator = "<?php echo esc_html( $range_prettify_separator ) ?>",
                prefix = "<?php echo esc_html( $range_prefix ) ?>",  // before the number
                postfix = "<?php echo esc_html( $range_postfix ) ?>"; // after the number

                var filters = [];

                var filter_item_name_arr = [];
                var filter_item_id_arr = [];
                var filter_item_val_arr = [];
                var filter_input_type_arr = [];

                jQuery('.divi-acf').each(function(i, obj) {
                    var filter_item_name = jQuery(this).attr("name"),
                    filter_item_id = jQuery(this).attr("id"),
                    filter_item_val = jQuery(this).val(),
                    filter_input_type = jQuery(this).attr('type');
                    filter_item_name_arr.push(filter_item_name);
                    filter_item_id_arr.push(filter_item_id);
                    filter_item_val_arr.push(filter_item_val);
                    filter_input_type_arr.push(filter_input_type);
                });

                var filter_item_name = jQuery(".<?php echo esc_html( $css_class ) ?> .js-range-slider").attr("name");

                          <?php if ($range_number_custom == 'custom') {
                            $range_custom_val_arr = explode( ',' , $range_custom_values );
                            $range_custom_min = min( $range_custom_val_arr );
                            $range_custom_max = max( $range_custom_val_arr );
                            if ( empty($range_from) || $range_from >= $range_custom_max || $range_from < $range_custom_min ) {
                                $range_from = $range_custom_min;
                            }

                            if ( empty( $range_to) || $range_to > $range_custom_max || $range_to <= $range_custom_min ) {
                                $range_to = $range_custom_max;
                            }
                            ?>
                            var range_custom_values = [<?php echo esc_html( $range_custom_values ) ?>],
                                from = range_custom_values.indexOf(<?php echo esc_html( $range_from ) ?>),
                                to = range_custom_values.indexOf(<?php echo esc_html( $range_to ) ?>);
                            <?php
                          }
                          ?>

                $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").ionRangeSlider({
                    type: 'double',
                    <?php if ($range_number_custom == 'default') { ?>
                    min: <?php echo esc_html( $min_price );?>,
                    max: <?php echo esc_html( $max_price );?>,
                    <?php } else { ?>
                    values: range_custom_values,
                    <?php } ?>
                    from: from,
                    to: to,
                    step: step,
                    skin: skin,
                    hide_min_max: hide_min_max,
                    hide_from_to: hide_from_to,
                    prettify_enabled: prettify_enabled,
                    prettify_separator: prettify_separator,
                    prefix: prefix,
                    postfix: postfix,
                    onFinish: function (data) {
                        if ( $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.et_pb_de_mach_search_posts').length == 0 && $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.updatetype-update_button').length == 0 ){

                              var _this = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                              var iris_to = data.to;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text();
                              var irs_from = data.from;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                              if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) && (irs_from != 0 || iris_to != <?php echo esc_html( $max_price );?> ) ) {
                                if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                                  var filter_param_type = "title";
                                } else {
                                  var filter_param_type = "no-title";
                                }
                                var value = _this.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                                name = _this.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                                slug = _this.data("name"),
                                type = 'range';
                                //iris_to = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                                //irs_from = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                              } else {
                                if (jQuery('.param-' + _this.data('name') ).length) {
                                  jQuery('.param-' + _this.data('name') ).remove();
                                }
                              }
                              divi_find_filters_to_filter();
                        }
                   }
                });

<?php
            if ( !empty( $_GET['product_price'] ) && ( $range_from_query != 0 || $range_to_query != $max_price ) ) {
?>
                var price_slider = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                if ( price_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) ) {
                    if ( price_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                      var filter_param_type = "title";
                    } else {
                      var filter_param_type = "no-title";
                    }
                    var value = price_slider.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                    name = price_slider.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                    slug = price_slider.attr("name"),
                    type = 'range',
                    slider_data = price_slider.data('ionRangeSlider'),
                    iris_to = slider_data.options.to, //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                    irs_from = slider_data.options.from; //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                    divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                }
<?php
            }
?>
            });
        </script>
<?php
                } else if ( $filter_post_type == "productweight" ) {
                    $product_cat  = get_query_var( 'product_cat' )?get_query_var('product_cat') : ( !empty($_GET['product_cat'])?stripslashes(urldecode($_GET['product_cat'])): '');
                    $product_weight = get_query_var('product_weight') ? get_query_var('product_weight') : ( !empty( $_GET['product_weight'] )?  stripslashes(urldecode($_GET['product_weight'])): '' );

                    $sql = "SELECT MAX(b.meta_value) FROM {$wpdb->posts} a JOIN (SELECT * FROM {$wpdb->postmeta} WHERE meta_key='_weight') b ON a.id=b.post_id";
                    if ( !empty( $product_cat ) ) {
                        $sql .= " JOIN {$wpdb->term_relationships} c ON a.id = c.object_id JOIN {$wpdb->term_taxonomy} d ON c.term_taxonomy_id = d.term_taxonomy_id JOIN {$wpdb->terms} e ON d.term_id = e.term_id WHERE e.slug='".$product_cat."'";
                    }



                    $max_weight = ceil( $wpdb->get_var( $sql ) );

                    if ( !empty( $range_to ) && $range_to != '800' ) {
                        $max_weight = $range_to;
                    }

                    $min_weight = (!empty( $range_from ) && $range_from < $max_weight)?$range_from:0;

                    $range_from_query = 0;
                    $range_to_query = $max_weight;
                    if ( !empty( $product_weight ) ){
                        $weight_arr = (explode(";", $product_weight));
                        if ( is_array( $weight_arr ) ) {
                            if ( isset( $weight_arr[1] ) ) {
                                $range_from_query = $weight_arr[0];
                                $range_to_query = $weight_arr[1];
                            }else{
                                $range_from_query = $weight_arr[0];
                                $range_to_query = '';
                            }
                        }
                    }

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        $custom_label_final = 'Weight Range';
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Product Weight Filter Label', $custom_label_final );

?>
                    <div class="et_pb_contact_field" data-type="range" data-filtertype="range">
                        <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css );?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                        <div class="divi-filter-item" data-filter-option="product_weight">
                            <input id="<?php echo "weight_" . esc_attr( $num );?>" type="input" class="divi-acf js-range-slider" data-filtertype="rangeslider" data-name="product_weight" name="product_weight" value="" />
                        </div>
                    </div>
<?php
                    $css_classrend = '.' . $css_class;
?>
            <style>
                <?php echo esc_html( $css_classrend ) ?> .irs-bar,
                <?php echo esc_html( $css_classrend ) ?> .irs-from,
                <?php echo esc_html( $css_classrend ) ?> .irs-to,
                <?php echo esc_html( $css_classrend ) ?> .irs-single,
                <?php echo esc_html( $css_classrend ) ?> span:not(.irs--sharp) .irs-handle>i:first-child,
                <?php echo esc_html( $css_classrend ) ?> .irs-sharp .irs-handle{
                    background: <?php echo esc_html( $range_prim_color ); ?> !important;
                }
                <?php echo esc_html( $css_classrend ) ?> .irs--sharp .irs-handle>i:first-child,
                <?php echo esc_html( $css_classrend ) ?> .irs-from:before,
                <?php echo esc_html( $css_classrend ) ?> .irs-to:before,
                <?php echo esc_html( $css_classrend ) ?> .irs-single:before {
                    border-top-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                }
                <?php echo esc_html( $css_classrend ) ?> .irs-line,
                <?php echo esc_html( $css_classrend ) ?> .irs-min,
                <?php echo esc_html( $css_classrend ) ?> .irs-max {
                    background-color: <?php echo esc_html( $range_sec_color ); ?> !important;
                }
                          <?php echo esc_html( $css_classrend ) ?> .irs--round .irs-handle {
                           border-color: <?php echo esc_html( $range_prim_color ); ?> !important;
                          }
            </style>
        <script>
            jQuery(document).ready(function($) {

                var from = <?php echo esc_html( $range_from_query ) ?>,
                to = <?php echo esc_html( $range_to_query ) ?>,
                step = <?php echo esc_html( $range_step ) ?>,
                skin = "<?php echo esc_html( $range_skin ) ?>",
                hide_min_max = <?php echo esc_html( $range_hide_min_max ) ?>,
                hide_from_to = <?php echo esc_html( $range_hide_from_to ) ?>,
                prettify_enabled = <?php echo esc_html( $range_prettify_enabled ) ?>,
                prettify_separator = "<?php echo esc_html( $range_prettify_separator ) ?>",
                prefix = "<?php echo esc_html( $range_prefix ) ?>",  // before the number
                postfix = "<?php echo esc_html( $range_postfix ) ?>"; // after the number

                var filters = [];

                var filter_item_name_arr = [];
                var filter_item_id_arr = [];
                var filter_item_val_arr = [];
                var filter_input_type_arr = [];

                jQuery('.divi-acf').each(function(i, obj) {
                    var filter_item_name = jQuery(this).attr("name"),
                    filter_item_id = jQuery(this).attr("id"),
                    filter_item_val = jQuery(this).val(),
                    filter_input_type = jQuery(this).attr('type');
                    filter_item_name_arr.push(filter_item_name);
                    filter_item_id_arr.push(filter_item_id);
                    filter_item_val_arr.push(filter_item_val);
                    filter_input_type_arr.push(filter_input_type);
                });

                var filter_item_name = jQuery(".<?php echo esc_html( $css_class ) ?> .js-range-slider").attr("name");

                <?php if ($range_number_custom == 'custom') {
                            ?>
                            var range_custom_values = [<?php echo esc_html( $range_custom_values ) ?>],
                                from = range_custom_values.indexOf(<?php echo esc_html( $range_from ) ?>),
                                to = range_custom_values.indexOf(<?php echo esc_html( $range_to ) ?>);
                            <?php
                          }
                          ?>

                $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").ionRangeSlider({
                    type: 'double',
                    <?php if ($range_number_custom == 'default') { ?>
                    min: <?php echo esc_html( $min_weight );?>,
                    max: <?php echo esc_html( $max_weight );?>,
                    <?php } else { ?>
                    values: range_custom_values,
                    <?php } ?>
                    from: from,
                    to: to,
                    step: step,
                    skin: skin,
                    hide_min_max: hide_min_max,
                    hide_from_to: hide_from_to,
                    prettify_enabled: prettify_enabled,
                    prettify_separator: prettify_separator,
                    prefix: prefix,
                    postfix: postfix,
                    onFinish: function (data) {
                        if ( $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.et_pb_de_mach_search_posts').length == 0 && $(".<?php echo esc_html( $css_class ) ?> .js-range-slider").parents('.updatetype-update_button').length == 0 ){

                              var _this = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                              var iris_to = data.to;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text();
                              var irs_from = data.from;//_this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                              if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) && (irs_from != 0 || iris_to != <?php echo esc_html( $max_weight );?> ) ) {
                                if ( _this.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                                  var filter_param_type = "title";
                                } else {
                                  var filter_param_type = "no-title";
                                }
                                var value = _this.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                                name = _this.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                                slug = _this.data("name"),
                                type = 'range';
                                //iris_to = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                                //irs_from = _this.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                                divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                              } else {
                                if (jQuery('.param-' + _this.data('name') ).length) {
                                  jQuery('.param-' + _this.data('name') ).remove();
                                }
                              }
                              divi_find_filters_to_filter();
                        }
                    }
                });

<?php
            if ( !empty( $_GET['product_weight'] ) && ( $range_from_query != 0 || $range_to_query != $max_weight ) ) {
?>
                var weight_slider = $(".<?php echo esc_html( $css_class ) ?> .js-range-slider");
                if ( weight_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params" ) ) {
                    if ( weight_slider.closest(".et_pb_de_mach_search_posts_item").hasClass( "filter_params_yes_title" ) ) {
                      var filter_param_type = "title";
                    } else {
                      var filter_param_type = "no-title";
                    }
                    var value = weight_slider.closest(".et_pb_de_mach_search_posts_item").find(".js-range-slider").val(),
                    name = weight_slider.closest(".et_pb_de_mach_search_posts_item").find(".et_pb_contact_field_options_title ").text(),
                    slug = weight_slider.attr("name"),
                    type = 'range',
                    slider_data = acf_slider.data('ionRangeSlider'),
                    iris_to = slider_data.options.to, //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-to").text(),
                    irs_from = slider_data.options.from; //acf_slider.closest(".et_pb_de_mach_search_posts_item").find(".irs-from").text();
                    divi_filter_params(type, slug, value, name, filter_param_type, iris_to, irs_from);
                }
<?php
            }
?>
            });
        </script>
<?php
                } else if ( $filter_post_type == "productrating" ) {

                    $queryvar = get_query_var('product_rating') ? get_query_var('product_rating') : ( !empty( $_GET['product_rating'] )? $_GET['product_rating'] : '' );

                    if ($custom_label !== '') {
                      $custom_label_final = $custom_label;
                    } else {
                      $custom_label_final = 'Product Rating';
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Product Rating Filter Label', $custom_label_final );

                    $terms = array(0, 1, 2, 3, 4, 5);

                    if ( $attribute_swatch == 'on' ){
?>
                    <div class="et_pb_contact_field divi-swatch divi-swatch-full" data-type="radio" data-filtertype="radio">
                        <div class="et_pb_contact_field_options_wrapper">
                            <span class="et_pb_contact_field_options_title <?php echo esc_html( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                            <div class="et_pb_contact_field_options_list divi-filter-item divi-checkboxsingle <?php echo esc_attr($filter_limit_class); ?>" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-option="product_rating" data-filter-name="product_rating" data-limitsize="<?php echo esc_attr( $filter_limit_height ) ?>" style="max-height:<?php echo esc_attr( $filter_limit_height ) ?>">
                                <span class="et_pb_contact_field_radio remove_filter">
                                    <input type="<?php echo esc_attr( $radio_select ) ?>" id="product_rating_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="divi-checkboxsingle" value="" name="product_rating" data-name="product_rating" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php checked( $queryvar, '' );?>>
                                    <label class="radio-label" data-value="all" title="All" for="product_rating_all_<?php echo esc_attr( $num );?>"><i></i><?php echo esc_html__( 'Remove Filter', $this->de_domain_name ); ?></label>
                                </span>
<?php
                            if ( !empty( $terms ) ) {
                              foreach ($terms as $term) {
                                  if ( in_array( $term , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term, $include_option_array) ) ) {
                                      continue;
                                  }
?>
                              <span class="et_pb_contact_field_radio">
                                  <input type="<?php echo $radio_select ?>" id="product_rating_<?php echo $term . '_' . $num ?>" class="divi-acf input" data-filtertype="divi-checkboxsingle" value="<?php echo $term; ?>" name="product_rating" data-name="product_rating" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php checked( $queryvar, $term );?>>
                                  <label class="radio-label" data-value="<?php echo $term ?>" title="<?php echo $term;?>" for="product_rating_<?php echo $term . '_' . $num ?>">
                                      <div class="star-rating" role="img">
                                          <span style="width:<?php echo 20 * $term;?>%"></span>
                                      </div>
                                  </label>
                              </span>
<?php
                              }
                          }
?>
                            </div>
                        </div>
                    </div>
<?php
                    }else{
                        if ($acf_filter_type == "select") {
?>
                        <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                        <div class="et_pb_contact_field divi-filter-item" data-type="select" data-field_type="select" data-filter-option="product_rating" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="product_rating" data-filtertype="select">
                            <select id="<?php echo 'product_rating_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-field_type="select" data-filtertype="divi-checkboxsingle" name="product_rating" data-name="product_rating">
                                <option value="" <?php selected( $queryvar, '' );?>><?php echo esc_attr( $select_placeholder ) ?></option>
                            <?php
                                if ( !empty($terms) ) :
                                    foreach ( $terms as $term ) :
                                        if ( in_array( $term , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term, $include_option_array) ) ) {
                                            continue;
                                        }
                            ?>
                                <option id="<?php echo 'product_rating_'. esc_attr( $term ).'_' . esc_attr( $num ); ?>" value="<?php echo esc_attr( $term ); ?>" <?php selected( $queryvar, $term );?>><?php echo ($term == 0)?esc_html__('No Rating', $this->de_domain_name):sprintf(esc_html__('%d Rating(s)', $this->de_domain_name), $term);// phpcs:ignore ?></option> 
                        <?php
                                    endforeach;
                                endif;
                        ?>
                            </select>
                        </div>
                        <?php
                      if ($select2 == "on") {
                        if ( !wp_script_is( 'divi-filter-select2-js') ) {
                            wp_enqueue_script('divi-filter-select2-js');
                        }
                        ?>
                        <script>
                        jQuery(document).ready(function ($) {
                          $('#<?php echo 'product_rating_' . esc_html( $num ); ?>').select2({width: '100%'});
                        });
                        </script>
                        <?php 
                      }
                        } else if ( $acf_filter_type == "radio" ) {
                            if ($radio_select == "checkbox") {
                                $checkboxtype = "divi-checkboxmulti";
                            } else {
                                $checkboxtype = "divi-checkboxsingle";
                            }
                            $queryvar = explode(',', $queryvar);
    ?>
                          <p class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                            <div class="et_pb_contact_field_options_wrapper radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style )?>">
                              <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                              <!-- <form> -->
                              <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) ?>" data-filter-option="product_rating" data-filter-name="product_rating">
                                <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on' ) && $only_show_avail == "off" ) { ?>
                                <span class="et_pb_contact_field_radio">
                                  <input type="<?php echo esc_attr( $radio_select ) ?>" id="product_rating_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" name="product_rating" data-name="product_rating" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo ($queryvar =='' )?'checked="checked"':'';?>>
                                  <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; }?>
                                  <label class="radio-label" data-value="all" for="product_rating_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                                </span>
                                <?php } ?>
                                <?php
                                if ( $terms ) :
                                  foreach ( $terms as $term ) :
                                    if ( in_array( $term , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term, $include_option_array) ) ) {
                                        continue;
                                    }
                                    ?>
                                    <span class="et_pb_contact_field_radio">
                                      <input type="<?php echo esc_attr( $radio_select ) ?>" id="product_rating_<?php echo esc_attr( $term ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $term ) ?>" name="product_rating" data-name="product_rating" data-required_mark="required" data-field_type="radio" <?php echo in_array($term, $queryvar)?'checked':'';?> data-original_id="radio">
                                      <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                      <label class="radio-label" data-value="<?php echo esc_attr( $term ) ?>" for="product_rating_<?php echo esc_attr( $term ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $term );?>"><i></i><?php echo ($term == 0)?esc_html__('No Rating', $this->de_domain_name):sprintf('%d Rating(s)', $this->de_domain_name, esc_html($term)); ?></label>
                                    </span>
                                    <?php
                                  endforeach;
                                endif;
                                ?>
                                <!-- </form> -->
                              </div>
                            </div>
                          </p>
<?php
                        }
                    }
                } else if ( $filter_post_type == "stock_status" ) {

                    $queryvar = get_query_var('stock_status') ? get_query_var('stock_status') : ( !empty( $_GET['stock_status'] )? $_GET['stock_status'] : '' );

                    if ($custom_label !== '') {
                      $custom_label_final = $custom_label;
                    } else {
                      $custom_label_final = 'Stock Status';
                    }

                    do_action( 'wpml_register_single_string', $this->de_domain_name, 'Stock Status Filter Label', $custom_label_final );

                    $terms = wc_get_product_stock_status_options();

                    if ($acf_filter_type == "select") {
?>
                    <p class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></p>
                    <div class="et_pb_contact_field divi-filter-item" data-type="select" data-field_type="select" data-filter-option="stock_status" data-filter-count="<?php echo esc_attr( $radio_show_count );?>" data-show-empty="<?php echo esc_attr( $radio_show_empty );?>" data-filter-name="stock_status" data-filtertype="select">
                        <select id="<?php echo 'stock_status_' . esc_attr( $num ); ?>" class="divi-acf et_pb_contact_select" data-field_type="select" data-filtertype="divi-checkboxsingle" name="stock_status" data-name="stock_status">
                            <option value="" <?php selected( $queryvar, '' );?>><?php echo esc_attr( $select_placeholder ) ?></option>
                        <?php
                            if ( !empty($terms) ) :
                                foreach ( $terms as $term => $term_label ) :
                                    if ( in_array( $term , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term, $include_option_array) ) ) {
                                        continue;
                                    }
                        ?>
                            <option id="<?php echo 'stock_status_'. esc_attr( $term ).'_' . esc_attr( $num ); ?>" value="<?php echo esc_attr( $term ); ?>" <?php selected( $queryvar, $term );?>><?php echo ($term == "")?esc_html__('Stock Status', $this->de_domain_name):$term_label;// phpcs:ignore ?></option> 
                    <?php
                                endforeach;
                            endif;
                    ?>
                        </select>
                    </div>
                    <?php
                  if ($select2 == "on") {
                    if ( !wp_script_is( 'divi-filter-select2-js') ) {
                        wp_enqueue_script('divi-filter-select2-js');
                    }
                    ?>
                    <script>
                    jQuery(document).ready(function ($) {
                      $('#<?php echo 'stock_status_' . esc_html( $num ); ?>').select2({width: '100%'});
                    });
                    </script>
                    <?php 
                  }
                    } else if ( $acf_filter_type == "radio" ) {
                        if ($radio_select == "checkbox") {
                            $checkboxtype = "divi-checkboxmulti";
                        } else {
                            $checkboxtype = "divi-checkboxsingle";
                        }
                        $queryvar = explode(',', $queryvar);
?>
                      <p class="et_pb_contact_field" data-type="radio" data-filtertype="radio">
                        <div class="et_pb_contact_field_options_wrapper radio-choice-<?php echo esc_attr( $radio_choice ) ?> divi-radio-<?php echo esc_attr( $radio_style )?>">
                          <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                          <!-- <form> -->
                          <div class="et_pb_contact_field_options_list divi-filter-item <?php echo esc_attr( $checkboxtype ) ?>" data-filter-option="stock_status" data-filter-name="stock_status">
                            <?php if ( ( $radio_select != 'checkbox') && ($radio_all_hide != 'on' ) && $only_show_avail == "off" ) { ?>
                            <span class="et_pb_contact_field_radio">
                              <input type="<?php echo esc_attr( $radio_select ) ?>" id="stock_status_all_<?php echo esc_attr( $num );?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="" name="stock_status" data-name="stock_status" data-required_mark="required" data-field_type="radio" data-original_id="radio" <?php echo ($queryvar =='' )?'checked="checked"':'';?>>
                              <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; }?>
                              <label class="radio-label" data-value="all" for="stock_status_all_<?php echo esc_attr( $num );?>" title="All"><i></i><?php echo esc_html__( $radio_all_text, $this->de_domain_name ); ?></label>
                            </span>
                            <?php } ?>
                            <?php
                            if ( $terms ) :
                              foreach ( $terms as $term => $term_label ) :
                                if ( in_array( $term , $exclude_option_array ) || ( !empty( $include_option_array) && !in_array( $term, $include_option_array) ) ) {
                                    continue;
                                }
                                ?>
                                <span class="et_pb_contact_field_radio">
                                  <input type="<?php echo esc_attr( $radio_select ) ?>" id="stock_status_<?php echo esc_attr( $term ) . '_' . esc_attr( $num ); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr( $checkboxtype ) ?>" value="<?php echo esc_attr( $term ) ?>" name="stock_status" data-name="stock_status" data-required_mark="required" data-field_type="radio" <?php echo in_array($term, $queryvar)?'checked':'';?> data-original_id="radio">
                                  <?php if ($radio_style == "tick_box") { echo '<span class="checkmark"></span>'; } else {} ?>
                                  <label class="radio-label" data-value="<?php echo esc_attr( $term ) ?>" for="stock_status_<?php echo esc_attr( $term ) . '_' . esc_attr( $num ); ?>" title="<?php echo esc_attr( $term_label );?>"><i></i><?php echo ($term == "")?esc_html__('Stock Status', $this->de_domain_name):$term_label; ?></label>
                                </span>
                                <?php
                              endforeach;
                            endif;
                            ?>
                            <!-- </form> -->
                          </div>
                        </div>
                      </p>
<?php
                    }
                } else if ($filter_post_type == "sort") {
                } else if ($filter_post_type == "date") {
                } else if ($filter_post_type == "acf_map"){

                    if ($custom_label !== '') {
                        $custom_label_final = $custom_label;
                    } else {
                        $custom_label_final = 'Search By Address';
                    }

                    if( class_exists('ACF') ) {
                        $acf_get = get_field_object($acf_map_name);
                        $acf_type = $acf_get['type'];
                    }

                    $address_value = get_query_var($acf_get['name']) ? get_query_var($acf_get['name']) : ( !empty( $_GET[$acf_get['name']] )?  stripslashes(urldecode($_GET[$acf_get['name']])) : '' );
                    $radius_value = get_query_var('map_radius') ? get_query_var('map_radius') : ( !empty( $_GET['map_radius'] )?  $_GET['map_radius'] : '' );

                    if ( $custom_label_final != '' ) {
                        do_action( 'wpml_register_single_string', 'divi-ajax-filter', 'Map Address Label', $custom_label_final );
                    }
                    $radius_label = 'Radius in ' . strtoupper($acf_map_radius_unit);
                    do_action( 'wpml_register_single_string', 'divi-ajax-filter', 'Range Label for Search by Address ', $radius_label );

                    wp_dequeue_script('google-maps-api');
                    add_filter( 'et_pb_enqueue_google_maps_script', '__return_false' );
                    
                    wp_enqueue_script('dmach_js_googlemaps_script');

                    ?>
                    <div class="et_pb_contact_field" data-type="address" data-filtertype="input" style="padding-left: 0;">
                        <span class="et_pb_contact_field_options_title <?php echo esc_attr( $label_css ) ?>"><?php echo esc_html__( $custom_label_final, $this->de_domain_name ); ?></span>
                        <div class="et_pb_contact_field_options_wrapper divi-filter-item <?php echo ($acf_map_fields_inline == 'on')?'divi-acf-map-inline':'';?>">
                          <p class="et_pb_contact_field" data-type="input" data-filtertype="input" style="padding-left: 0;">
                            <input id="map_address_<?php echo esc_attr( $num );?>" class="divi-acf divi-filter-item divi-acf-map" data-filtertype="address" type="text" name="<?php echo esc_attr( $acf_get['name'] );?>" data-name="<?php echo esc_attr( $acf_get['name'] );?>" placeholder="<?php echo esc_html__( $text_placeholder, $this->de_domain_name ); ?>" value="<?php echo esc_attr( $address_value ) ?>" onFocus="geolocate()" style="width: 100%;">
                         
                            <input id="map_address_lat_<?php echo esc_attr( $num );?>" type="hidden" name="map_address_lat" class="map_address_lat">
                            <input id="map_address_lng_<?php echo esc_attr( $num );?>" type="hidden" name="map_address_lng" class="map_address_lng">
                        <?php if ( $acf_map_fields_inline != 'on' ) { ?>
                            </p>
                            <p class="et_pb_contact_field" data-type="input" data-filtertype="input" style="padding-left: 0;">
                            <span class="radius_label"><?php echo esc_html__($radius_label, $this->de_domain_name);?></span>
                        <?php } 
                            if ( $acf_map_radius_select == 'on' ) {
                  
                                $acf_map_radius_select_values = str_replace(' ', '', $acf_map_radius_select_values);
                                $radius_values = explode(',', $acf_map_radius_select_values);
                                asort( $radius_values );

                                if ( in_array( "0", $radius_values ) ) {
                                    unset( $radius_values[0] );
                                }
                        ?>
                            <select id="map_radius_<?php echo esc_attr( $num );?>" class="divi-acf et_pb_contact_select divi-acf-map-radius" data-radius-type="<?php echo esc_attr( $acf_map_radius_unit );?>" data-filtertype="radius" name="map_radius" data-name="map_radius">
                        <?php   
                            /*if ( $radius_field_placeholder != '' ){
                                echo '<option value="">' . esc_attr( $radius_field_placeholder ) . '</option>';
                            }*/
                        $ind = 0;
                        foreach ($radius_values as $key => $radius) {
                            $prev_value = "0";
                            /*if ( $ind != 0 ) {
                                $prev_value = $radius_values[ $key - 1 ];
                            }*/
                            //echo '<option value="' . $prev_value . ';' . $radius . '">' . $prev_value . ' - ' . $radius . $acf_map_radius_unit . '</option>';
                            echo '<option value="' . esc_html( $radius ) . '" ' . ( $radius == $radius_value?'selected':'') . '>' . esc_attr( $radius ) . esc_attr( $acf_map_radius_unit ) . '</option>';
                            $ind++;
                        }
                        ?>
                            </select>
                        <?php } else { ?>
                            <input id="map_radius_<?php echo esc_html( $num );?>" class="divi-acf divi-filter-item divi-acf-map-radius" data-radius-type="<?php echo esc_attr( $acf_map_radius_unit );?>" data-filtertype="radius" data-searchdelay="<?php echo esc_attr($text_typing_timeout); ?>" type="number" name="map_radius" data-name="map_radius" placeholder="<?php echo esc_html__( $radius_field_placeholder, 'divi-ajax-filter' ); ?>" value="<?php echo esc_attr( $radius_field_value ) ?>" style="width: 100%;">
                        <?php } ?>
                          </p>
                        </div>
                    </div>
                  <?php
                } else{

                }
if ($filter_limit == "on" && $radio_style != 'select') {
// TODO: Finish styling of the show more/less. Add Icons, animations smoother
  $this->add_classname( 'limit_filters');
  echo '<span class="limit_filter_text showmore">' . esc_html( $filter_limit_show_more_text ) . '</span>';
  echo '<span class="limit_filter_text showless">' . esc_html( $filter_limit_show_less_text ) . '</span>';
}
?>
                </div>
                <?php
                $data = ob_get_clean();

                //////////////////////////////////////////////////////////////////////

                return $data;
            }

            public function listTaxonomies($args, &$new_categories = array()) {

                $tax_order = '';

                if ( isset( $args['tax_order'] ) && $args['tax_order'] == 'numeric' ){
                    $tax_order = $args['tax_order'];
                    unset( $args['tax_order'] );
                }
                
                $categories = get_terms($args);

                if ( $tax_order == 'numeric' ) {
                    usort( $categories, function($a, $b) {
                        return strnatcmp( $a->name, $b->name );
                    });
                }

                if( !is_wp_error( $categories ) ) {
                    foreach( $categories as $category ) {
                        $new_categories[] = $category;
                        $args['parent'] = $category->term_id;

                        if ( $tax_order == 'numeric' ) {
                            $args['tax_order'] = 'numeric';
                        }

                        $this->listTaxonomies($args, $new_categories);
                    }
                }
            }
        }

        new et_pb_df_product_filter_item_code;
        }
    }
}