<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_view_button_code extends ET_Builder_Module {

    public static $button_text, $p;
    public static function change_button_text( $btn_text ){
        if( !empty( self::$button_text ) ){
            $btn_text = esc_html__( self::$button_text );
        }
        return $btn_text; 
    }

    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => DE_DMACH_PRODUCT_URL,
        'author'     => DE_DMACH_AUTHOR,
        'author_uri' => DE_DMACH_URL,
    );

    function init() {
        $this->name       = esc_html__( 'View Post Btn - Divi Machine', 'divi-machine' );
        $this->slug = 'et_pb_de_mach_view_button';
        $this->folder_name = 'divi_machine';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(),
            ),
        );

        $this->main_css_element = '%%order_class%%';
        $this->fields_defaults = array();



        $this->advanced_fields = array(
            'fonts' => array(
                'text' => array(
                    'label'    => esc_html__( 'Button', 'divi-machine' ),
                    'css'      => array(
                        'main' => "%%order_class%% .et_pb_module_inner",
                        'important' => 'plugin_only',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1em',
                    ),
                ),
            ),
            'button' => array(
                'button' => array(
                    'label' => esc_html__( 'Button', 'divi-machine' ),
                    'css' => array(
                        'main' => "{$this->main_css_element} .et_pb_button, {$this->main_css_element} .dmach_view_btn",
                        'important' => 'all',
                    ),
                    'box_shadow'  => array(
                        'css' => array(
                            'main' => "{$this->main_css_element} .et_pb_button, {$this->main_css_element} .dmach_view_btn",
                            'important' => 'all',
                        ),
                    ),
                    'margin_padding' => array(
                        'css'           => array(
                            'main' => "{$this->main_css_element} .et_pb_button, {$this->main_css_element} .dmach_view_btn",
                            'important' => 'all',
                        ),
                    ),
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
            ),
            'border' => array(),
            'custom_margin_padding' => array(
                'css' => array(
                    'important' => 'all',
                ),
            ),
        );

        $this->custom_css_fields = array();
    }
    

    function get_fields() {

            $options_posttype = DEDMACH_INIT::get_divi_post_types();
            $options_posttype['auto'] = "Detect Automatically";


        
        $acf_fields = DEDMACH_INIT::get_acf_fields();

        $options = DEDMACH_INIT::get_divi_layouts();

        $et_accent_color = et_builder_accent_color();

        $fields = array(
            'button_name' => array(
                'toggle_slug'       => 'main_content',
                'option_category' => 'basic_option',
                'label' => esc_html__( 'Button Name Type', 'divi-machine' ),
                'type' => 'select',
                'options' => array(
                    'custom' => esc_html__( 'Custom Text', 'divi-machine' ),
                    'acf' => esc_html__( 'ACF Field', 'divi-machine' ),
                ),
                'default' => 'custom',
                'description' => esc_html__( 'Choose how you want the button name to be, text or ACF.', 'divi-machine' )
            ),
            'title' => array(
                'label'           => esc_html__( 'Button Text', 'divi-machine' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'default'         => 'View Post',
                'toggle_slug'       => 'main_content',
                'show_if'           => array(
                          'button_name' => 'custom'
                ),
                'description'     => esc_html__( 'Input your desired button text.', 'divi-machine' ),
            ),
            'link_name_acf_name' => array(
                'toggle_slug'       => 'main_content',
                'option_category' => 'basic_option',
                'label'             => esc_html__('ACF Name', 'divi-machine'),
                'type'              => 'select',
                'options'           => $acf_fields,
                'default'           => 'none',
                'show_if'           => array(
                          'button_name' => 'acf'
                ),
                'description'       => esc_html__('Choose the name of the button to be this ACF field (text)', 'divi-machine'),
              ),
            'custom_url' => array(
                'label'       => __( 'Custom URL End', 'divi-machine' ),
                'type'        => 'text',
                'toggle_slug'       => 'main_content',
                'option_category' => 'basic_option',
                'description' => __( 'If you want to add an extension after the URL such as an anchor link - add it here. For example add #buynow to go to a section on the product page that has the ID "buynow".', 'divi-machine' ),
            ),
            'fullwidth_btn' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Fullwidth Button?', 'divi-machine' ),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-machine' ),
                    'off' => esc_html__( 'No', 'divi-machine' ),
                ),
                'default' => 'on',
                'description' => esc_html__( 'If you want to make your button fullwdith of the available space, enable this.', 'divi-machine' ),
            ),
            'disable_button' => array(
                'toggle_slug'       => 'main_content',
                'option_category' => 'basic_option',
                'label'             => esc_html__( 'Disable "Button" Style', 'divi-machine' ),
                'type'              => 'yes_no_button',
                'options'   => array(
                    'on'    => esc_html__( 'Yes', 'divi-machine' ),
                    'off'   => esc_html__( 'No', 'divi-machine' ),
                ),
                'default'           => 'off',
                'description'       => esc_html__( 'If you want the button to be disabled so its just plain text, enable this.', 'divi-machine' ),
            ),
            'new_tab' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Open in New Tab?', 'divi-machine' ),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-machine' ),
                    'off' => esc_html__( 'No', 'divi-machine' ),
                ),
                'default' => 'off',
                'description' => esc_html__( 'Enable this if you want to open in a new tab.', 'divi-machine' )
            ),
            'open_external' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Open to External Site?', 'divi-machine' ),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-machine' ),
                    'off' => esc_html__( 'No', 'divi-machine' ),
                ),
                'default' => 'off',
                'affects'         => array(
                    'external_acf',
                    'showin_modal'
                ),
                'description' => esc_html__( 'If you want the button to link to an external site and not to the single page, enable this (then specify the ACF field next).', 'divi-machine' )
            ),
            'external_acf' => array(
              'toggle_slug'       => 'main_content',
              'label'             => esc_html__('External ACF Text Field', 'divi-machine'),
              'type'              => 'select',
              'options'           => $acf_fields,
              'default'           => 'none',
              'option_category'   => 'configuration',
              'depends_show_if' => 'on',
              'description'       => esc_html__('Choose the ACF you want to use to tell the system where to link to', 'divi-machine'),
            ),
            'showin_modal' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Show Post in Modal/Update Content?', 'divi-machine' ),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-machine' ),
                    'off' => esc_html__( 'No', 'divi-machine' ),
                ),
                'depends_show_if' => 'off',
                'default' => 'off',
                'affects'         => array(
                    'modal_layout',
                    'modal_overlay_color',
                    'modal_close_icon',
                    'modal_close_icon_color',
                    'modal_close_icon_size',
                    'prev_next_option',
                    'modal_style',
                    'post_type_choose'
                ),
                'description' => esc_html__( 'If you want to show post in modal instead to go post page, enable this.', 'divi-machine' )
            ),
            'post_type_choose' => array(
                'toggle_slug'       => 'main_content',
                'label'             => esc_html__( 'Post Type', 'divi-filter' ),
                'type'              => 'select',
                'option_category' => 'basic_option',
                'options'           => $options_posttype,
                'default'           => 'auto',
                'depends_show_if' => 'on',
                'description'       => esc_html__( 'If you are using this feature on a page or somewhere that we cannot work out the post type, choose it here', 'divi-filter' ),
            ),
            'modal_type' => array(
                'toggle_slug'       => 'main_content',
                'label'             => esc_html__( 'How do you want to display the post content?', 'divi-filter' ),
                'type'              => 'select',
                'option_category' => 'basic_option',
                'options'           => array(
                    'modal'         => esc_html__( 'Modal Pop up', 'divi-machine' ),
                    'update_content'         => esc_html__( 'Update Content', 'divi-machine' ),
                ),
                'default'           => 'modal',
                'show_if' => array('showin_modal' => 'on'),
                'description'       => esc_html__( 'Choose how you want the content to display. If you want it in a pop up modal, choose this. If you want a section that has the content and it gets updated based on the selection, choose "update content".', 'divi-filter' ),
            ),
            'update_content_pos' => array(
                'toggle_slug'       => 'main_content',
                'label'             => esc_html__( 'Position of content', 'divi-filter' ),
                'type'              => 'select',
                'option_category' => 'basic_option',
                'options'           => array(
                    'above'         => esc_html__( 'Above Archive or Carousel Module', 'divi-machine' ),
                    'below'         => esc_html__( 'Below Archive or Carousel Module', 'divi-machine' ),
                ),
                'default'           => 'above',
                'show_if' => array('modal_type' => 'update_content'),
                'description'       => esc_html__( 'Choose where the content loop layout gets shown - above or below the archive or carousel module.', 'divi-filter' ),
            ),
            'modal_layout' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Modal / Content Loop layout', 'divi-machine' ),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => $options,
                'default' => 'none',
                'depends_show_if' => 'on',
                'description' => esc_html__( 'Select Loop Layout to show post in modal.', 'divi-machine' )
            ),
            'update_content_show_start' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Show First Post on Page Load?', 'divi-machine' ),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-machine' ),
                    'off' => esc_html__( 'No', 'divi-machine' ),
                ),
                'show_if' => array('modal_type' => 'update_content'),
                'default' => 'on',
                'description' => esc_html__( 'If you want the "update content" to show on first load, enable this. If you want the visitor to have to click on the post to show - disable this.', 'divi-machine' )
            ),
            'modal_style' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Modal Style', 'divi-machine' ),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'center-modal'       => esc_html__( 'Center', 'divi-machine' ),
                    'side-modal'       => esc_html__( 'Side', 'divi-machine' ),
                ),
                'default' => 'center-modal',
                'depends_show_if' => 'on',
                'description' => esc_html__( 'Select the modal style.', 'divi-machine' ),
            ),
            'modal_overlay_color' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Modal Overlay Background', 'divi-machine' ),
                'type' => 'color-alpha',
                'option_category' => 'basic_option',
                'default' => 'rgba(0,0,0,0.5)',
                'depends_show_if' => 'on',
                'description' => esc_html__( 'Select background color of modal overlay.', 'divi-machine' )
            ),
            'modal_close_icon' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Modal Close Icon', 'divi-machine' ),
                'type' => 'select_icon',
                'option_category' => 'basic_option',
                'class' => array('et-pb-font-icon'),
                'mobile_options'      => true,
                'default'           => '%%44%%',
                'depends_show_if' => 'on',
                'description' => esc_html__( 'Choose an icon for modal close icon.', 'divi-machine' )
            ),
            'modal_close_icon_color' => array(
                'default'           => $et_accent_color,
                'label'             => esc_html__('Modal Close Icon Color', 'divi-machine'),
                'type'              => 'color-alpha',
                'description'       => esc_html__('Here you can define a custom color for modal close icon.', 'divi-machine'),
                'depends_show_if'   => 'on',
                'toggle_slug'       => 'main_content',
                'option_category'   => 'basic_option',
                'mobile_options'    => true,
            ),
            'modal_close_icon_size' => array(
                'label'            => esc_html__( 'Modal Close Icon Size', 'divi-machine' ),
                'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'divi-machine' ),
                'type'             => 'range',
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'main_content',
                'default'          => '46px',
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
            'prev_next_option' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Next & Previous Post Options?', 'divi-machine' ),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-machine' ),
                    'off' => esc_html__( 'No', 'divi-machine' ),
                ),
                'default' => 'off',
                'affects'         => array(
                    'prev_icon',
                    'next_icon',
                    'prev_next_icon_color',
                    'prev_next_icon_size',
                ),
                'description' => esc_html__( 'If you want the ability to go to the next and previous posts, enable this.', 'divi-machine' )
            ),
            'prev_icon' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Modal Previous Icon', 'divi-machine' ),
                'type' => 'select_icon',
                'option_category' => 'basic_option',
                'class' => array('et-pb-font-icon'),
                'mobile_options'      => true,
                'default'           => '%%19%%',
                'depends_show_if' => 'on',
                'description' => esc_html__( 'Choose an icon for modal previous icon.', 'divi-machine' )
            ),
            'next_icon' => array(
                'toggle_slug'       => 'main_content',
                'label' => esc_html__( 'Modal Next Icon', 'divi-machine' ),
                'type' => 'select_icon',
                'option_category' => 'basic_option',
                'class' => array('et-pb-font-icon'),
                'mobile_options'      => true,
                'default'           => '%%20%%',
                'depends_show_if' => 'on',
                'description' => esc_html__( 'Choose an icon for modal next icon.', 'divi-machine' )
            ),
            'prev_next_icon_color' => array(
                'default'           => $et_accent_color,
                'label'             => esc_html__('Modal Previous & Next Icon Color', 'divi-machine'),
                'type'              => 'color-alpha',
                'description'       => esc_html__('Here you can define a custom color for modal Next and Previoius icons.', 'divi-machine'),
                'depends_show_if'   => 'on',
                'toggle_slug'       => 'main_content',
                'option_category'   => 'basic_option',
                'mobile_options'    => true,
            ),
            'prev_next_icon_size' => array(
                'label'            => esc_html__( 'Modal Previous & Next Icon Size', 'divi-machine' ),
                'description'      => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'divi-machine' ),
                'type'             => 'range',
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'main_content',
                'default'          => '46px',
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
            'loading_animation_color' => array(
              'label'             => esc_html__( 'Loading Post Animation Color', 'et_builder' ),
              'description'       => esc_html__( 'Define the color of the animation.', 'et_builder' ),
              'type'              => 'color-alpha',
              'custom_color'      => true,
              'option_category'   => 'configuration',
              'toggle_slug'       => 'main_content',
            ),
            'button_alignment' => array(
                'label'            => esc_html__( 'Button Alignment', 'divi-machine' ),
                'description'      => esc_html__( 'Align your button to the left, right or center of the module.', 'divi-machine' ),
                'type'             => 'text_align',
                'option_category'  => 'configuration',
                'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'alignment',
            ),
        );

        return $fields;
    }

    public function get_button_alignment($device = 'desktop')
    {
      $suffix           = 'desktop' !== $device ? "_{$device}" : '';
      $text_orientation = isset($this->props["button_alignment{$suffix}"]) ? $this->props["button_alignment{$suffix}"] : '';

      return et_pb_get_alignment($text_orientation);
    }

    function render($attrs, $content, $render_slug){


        self::$button_text          = $this->props['title'];

        $custom_url  = $this->props['custom_url'];
        $title_get  = $this->props['title'];
        $button_use_icon            = $this->props['button_use_icon'];
        $custom_icon                = $this->props['button_icon'];
        $button_bg_color            = $this->props['button_bg_color'];
        $fullwidth_btn              = $this->props['fullwidth_btn'];
        $showin_modal               = $this->props['showin_modal'];
        $modal_type               = $this->props['modal_type'];
        $update_content_pos               = $this->props['update_content_pos'];
        $update_content_show_start               = $this->props['update_content_show_start'];
        

        $post_type_choose  = $this->props['post_type_choose'];
        $modal_layout               = $this->props['modal_layout'];
        $modal_overlay_color        = $this->props['modal_overlay_color'];
        $modal_close_icon           = $this->props['modal_close_icon'];
        $modal_close_icon_color     = $this->props['modal_close_icon_color'];
        $modal_close_icon_size      = $this->props['modal_close_icon_size'];
        
        $loading_animation_color      = $this->props['loading_animation_color'];

        $prev_next_option      = $this->props['prev_next_option'];
        $prev_icon      = $this->props['prev_icon'];
        $next_icon      = $this->props['next_icon'];
        $prev_next_icon_color      = $this->props['prev_next_icon_color'];
        $prev_next_icon_size      = $this->props['prev_next_icon_size'];
        
        $open_external      = $this->props['open_external'];
        $external_acf       = $this->props['external_acf'];

        $button_name      = $this->props['button_name'];
        $link_name_acf_name      = $this->props['link_name_acf_name'];
        

        $disable_button 		= $this->props['disable_button'];
                  
        
        $new_tab      = $this->props['new_tab'];
        
        
        $modal_style      = $this->props['modal_style'];
        
        $button_alignment  = $this->get_button_alignment();


        
        $data = '';

        $this->add_classname( 'dmach-btn-align-' . $button_alignment );

        if ($fullwidth_btn == 'on') {
            $this->add_classname('fullwidth-btn');
        }

        if ($disable_button == 'on') {
          $button_class = '';
        } else {
          $button_class = 'et_pb_button';
        }


        
        do_action( 'wpml_register_single_string', 'divi-machine', 'View Post Title Text', $title_get );
        $title = apply_filters( 'wpml_translate_single_string', $title_get, 'divi-machine', 'View Post Title Text' );

        
        


        // wp_enqueue_style( 'dmach-magnific-css', DE_DMACH_PATH_URL . '/styles/magnific-popup.css', array(), DE_DMACH_VERSION );
        // wp_enqueue_script( 'dmach-magnific-js',  DE_DMACH_PATH_URL . '/scripts/jquery.magnific-popup.min.js', array('jquery'), DE_DMACH_VERSION, true );
        
        //////////////////////////////////////////////////////////////////////

        ob_start();
        
        $button_text_final = $title;

        if ($button_name == 'acf') {
            $button_name_acf_name_get = get_field_object($link_name_acf_name);
            if($button_name_acf_name_get['value'] !== '') $button_text_final = $button_name_acf_name_get['value'];
        } 

        $close_icon_index   = (int) str_replace( '%', '', $modal_close_icon );
        $close_icon_rendered = DEDMACH_INIT::et_icon_css_content(esc_attr($modal_close_icon));

        $prev_icon_index   = (int) str_replace( '%', '', $prev_icon );
        $prev_icon_rendered = DEDMACH_INIT::et_icon_css_content(esc_attr($prev_icon));

        $next_icon_index   = (int) str_replace( '%', '', $next_icon );

        $next_icon_rendered = DEDMACH_INIT::et_icon_css_content(esc_attr($next_icon));

        if( $button_use_icon == 'on' && $custom_icon != '' ){
            $custom_icon_arr = explode('||', $custom_icon);
            $custom_icon_font_family = ( !empty( $custom_icon_arr[1] ) && $custom_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
            $custom_icon_font_weight = ( !empty( $custom_icon_arr[2] ))?$custom_icon_arr[2]:'400';
            $custom_icon = 'data-icon="'. esc_attr( et_pb_process_font_icon( $custom_icon ) ) .'"';
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => 'body #page-container %%order_class%% .dmach_view_btn:after',
                'declaration' => "content: attr(data-icon);
                    font-family:{$custom_icon_font_family}!important;
                    font-weight:{$custom_icon_font_weight};",
            ) );
        }else{
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => 'body #page-container %%order_class%% .dmach_view_btn:hover',
                'declaration' => "padding: .3em 1em;",
            ) );
        }

        if( !empty( $button_bg_color ) ){
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => 'body #page-container %%order_class%% .dmach_view_btn',
                'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
            ) );
        }

        $post_link = get_permalink(get_the_ID());
        if ( $showin_modal == 'on' && $open_external == 'off'){
            $close_icon_arr = explode('||', $modal_close_icon);
            $close_icon_font_family = ( !empty( $close_icon_arr[1] ) && $close_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
            $close_icon_font_weight = ( !empty( $close_icon_arr[2] ))?$close_icon_arr[2]:'400';
        ?>
            <style>
                .dmach-popup .modal-close:before {
                    content: "<?php echo $close_icon_rendered ?>";
                    font-size: <?php echo $modal_close_icon_size;?>;
                    color: <?php echo $modal_close_icon_color;?>;
                    font-family: "<?php echo $close_icon_font_family;?>";
                    font-weight: <?php echo $close_icon_font_weight;?>;
                }
                .dmach-popup{
                    background-color: <?php echo $modal_overlay_color;?>!important;
                }
            </style>
            <?php
            ?>
            <a class="dmach_view_btn <?php echo esc_attr($button_class); ?> show_modal" <?php echo ($custom_icon != '')?$custom_icon:'';?> data-modal-style="<?php echo $modal_style ?>" data-modal-postype="<?php echo $post_type_choose ?>" data-modal-layout="<?php echo $modal_layout;?>" data-id="<?php echo get_the_ID();?>" data-modal-src="#post-modal-<?php echo get_the_ID();?>" loading_animation_color="<?php echo esc_attr($loading_animation_color) ?>" modal_type="<?php echo esc_attr($modal_type) ?>" update_content_pos="<?php echo esc_attr($update_content_pos) ?>" update_content_show_start="<?php echo esc_attr($update_content_show_start) ?>" href="#"><?php echo esc_html__( $button_text_final, 'divi-machine' ); ?></a>
            <?php
            
            if ($modal_type == "update_content") {
                ?>
                <script> 
                jQuery(document).ready(function ($) {
                    $('.show_modal').closest('.et_pb_de_mach_archive_loop, .et_pb_de_mach_carousel').addClass('update_content_loop');
                });
                </script>
                <?php 
            }

            if ($prev_next_option == 'on') {
                $prev_icon_arr = explode('||', $prev_icon);
                $prev_icon_font_family = ( !empty( $prev_icon_arr[1] ) && $prev_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                $prev_icon_font_weight = ( !empty( $prev_icon_arr[2] ))?$prev_icon_arr[2]:'400';

                $next_icon_arr = explode('||', $next_icon);
                $next_icon_font_family = ( !empty( $next_icon_arr[1] ) && $next_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                $next_icon_font_weight = ( !empty( $next_icon_arr[2] ))?$next_icon_arr[2]:'400';
        ?>
                <style>
                .dmach-prev-post:before, .dmach-next-post:before {
                    content: "<?php echo $prev_icon_rendered ?>";
                    font-size: <?php echo $modal_close_icon_size;?>;
                    color: <?php echo $modal_close_icon_color;?>;
                    font-family: "<?php echo $prev_icon_font_family;?>";
                    font-weight: <?php echo $prev_icon_font_weight;?>;
                }
                .dmach-next-post:before {
                    content: "<?php echo $next_icon_rendered ?>";
                    font-family: "<?php echo $next_icon_font_family;?>";
                    font-weight: <?php echo $next_icon_font_weight;?>;
                }
                </style>
                <?php
            } else {
                ?>
                <style>
                .dmach-prev-post:before, .dmach-next-post:before {
                    display: none !important;
                }
                </style>
                <?php
            }
        } else {
            if ($open_external == 'on') {
                if (isset($external_acf) && $external_acf !== 'none') {
                    $acf_get = get_field_object($external_acf);
                    if($acf_get['value'] !== '') $post_link = $acf_get['value'];
                } 
            } 
            $newtab = '';
            if ($new_tab == 'on') {
                $newtab = 'target="_blank"';
            }

            global $de_categoryloop_term;
            if (isset($de_categoryloop_term) && isset($term)) {
              $post_link = get_term_link( $de_categoryloop_term->term_id, $term->taxonomy);
            }
            ?>
        <a class="<?php echo esc_attr($button_class); ?>"  <?php echo ($custom_icon != '')?$custom_icon:'';?> href="<?php echo $post_link ?><?php echo $custom_url ?>" <?php echo $newtab ?>><?php echo esc_html__( $button_text_final, 'divi-machine' ); ?> </a>

    <?php
        }

        $data = ob_get_clean();
        //////////////////////////////////////////////////////////////////////

        /*$data = str_replace(
            'class="et_pb_button"',
            'class="et_pb_button"' . $custom_icon
            , $data
        );*/

        return $data;

    }
}

new de_mach_view_button_code;

?>
