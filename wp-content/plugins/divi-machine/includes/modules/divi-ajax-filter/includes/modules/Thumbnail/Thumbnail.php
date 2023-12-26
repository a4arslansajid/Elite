<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    if (!function_exists("Divi_filter_thumbnail_module_import")) {
        add_action('et_builder_ready', 'Divi_filter_thumbnail_module_import');
        function Divi_filter_thumbnail_module_import()
        {
            if (class_exists("ET_Builder_Module") && !class_exists("et_pb_de_mach_thumbnail") && !class_exists("et_pb_db_shop_thumbnail")) {
                class de_filter_thumbnail_code extends ET_Builder_Module
                {
                    public $vb_support        = 'on';
                    protected $module_credits = array(
                        'module_uri' => DE_DF_PRODUCT_URL,
                        'author'     => DE_DF_AUTHOR,
                        'author_uri' => DE_DF_URL
                    );

                    function init()
                    {
                        if (defined('DE_DB_WOO_VERSION')) {
                            $this->name        = esc_html__('LL Thumbnail - Loop Layout', 'divi-bodyshop-woocommerce');
                            $this->slug        = 'et_pb_db_shop_thumbnail';
                            $this->folder_name = 'divi_bodycommerce';
                        } else if (defined('DE_DMACH_VERSION')) {
                            $this->name        = esc_html__('Thumbnail - Divi Machine', 'divi-machine');
                            $this->slug        = 'et_pb_de_mach_thumbnail';
                            $this->folder_name = 'divi_machine';
                        } else {
                            $this->name        = esc_html__('Thumbnail - Divi Ajax Filter', 'divi-filter');
                            $this->slug        = 'et_pb_df_thumbnail';
                            $this->folder_name = 'divi_ajax_filter';
                        }

                        add_action('et_theme_builder_after_layout_opening_wrappers', array(
                            $this,
                            'change_shortcode_in_content'
                        ), 1, 2);
                        add_filter('the_content', array(
                            $this,
                            'change_shortcode_in_render'
                        ), 1, 1);

                        $this->fields_defaults = array(
                            // 'loop_layout'         => array( 'on' ),
                            'link_product' => array(
                                'on'
                            )
                        );

                        $this->settings_modal_toggles = array(
                            'general'  => array(
                                'toggles' => array(
                                    'main_content' => esc_html__('Main Options', 'divi-filter')
                                )
                            ),
                            'advanced' => array(
                                'toggles' => array(
                                    'text' => esc_html__('Text', 'divi-filter')
                                )
                            )
                        );

                        $this->main_css_element = '%%order_class%%';
                        $this->advanced_fields  = array(
                            'fonts'                 => array(),
                            'background'            => array(
                                'settings' => array(
                                    'color' => 'alpha'
                                )
                            ),
                            'button'                => array(),
                            'box_shadow'            => array(
                                'default'         => array(),
                                'thumbnail_image' => array(
                                    'label'           => esc_html__('Thumbnail Box Shadow', 'divi-filter'),
                                    'css'             => array(
                                        'main' => "%%order_class%% img"
                                    ),
                                    'option_category' => 'layout',
                                    'tab_slug'        => 'advanced'
                                )
                            ),
                            'custom_margin_padding' => array(
                                'css' => array(
                                    'important' => 'all'
                                )
                            )
                        );

                        $this->custom_css_fields = array();
                        $this->help_videos       = array();
                    }

                    function change_shortcode()
                    {
                        global $shortcode_tags;
                        $slug_arr = array(
                            'et_pb_db_shop_thumbnail',
                            'et_pb_de_mach_thumbnail',
                            'et_pb_df_thumbnail'
                        );
                        unset($slug_arr[array_search($this->slug, $slug_arr)]);
                        foreach ($slug_arr as $other_slug) {
                            if (!shortcode_exists($other_slug)) {
                                $shortcode_tags[$other_slug] = $shortcode_tags[$this->slug]; // phpcs:ignore

                            }
                        }
                    }

                    function change_shortcode_in_render($content)
                    {
                        $slug_arr = array(
                            'et_pb_db_shop_thumbnail',
                            'et_pb_de_mach_thumbnail',
                            'et_pb_df_thumbnail'
                        );
                        unset($slug_arr[array_search($this->slug, $slug_arr)]);
                        foreach ($slug_arr as $other_slug) {
                            if (has_shortcode($content, $other_slug)) {
                                $content = str_replace($other_slug, $this->slug, $content);
                            }
                        }

                        return $content;
                    }

                    function change_shortcode_in_content($layout_type, $layout_id)
                    {
                        $layout_post    = get_post($layout_id);
                        $layout_content = $layout_post->post_content;

                        $slug_arr = array(
                            'et_pb_db_shop_thumbnail',
                            'et_pb_de_mach_thumbnail',
                            'et_pb_df_thumbnail'
                        );
                        unset($slug_arr[array_search($this->slug, $slug_arr)]);
                        $content_changed = false;
                        foreach ($slug_arr as $other_slug) {
                            if (has_shortcode($layout_content, $other_slug)) {
                                $layout_content  = str_replace($other_slug, $this->slug, $layout_content);
                                $content_changed = true;
                            }
                        }

                        if ($content_changed) {
                            $post_arr = array(
                                'ID'           => $layout_id,
                                'post_content' => $layout_content
                            );

                            wp_update_post($post_arr, false, false);
                        }
                    }

                    function get_fields()
                    {
                        $options = $col_options = array();
                        $sizes   = get_intermediate_image_sizes();

                        foreach ($sizes as $size) {
                            $options[$size] = $size;
                        }

                        for ($i = 1; $i <= 6; $i++) {
                            $col_options[$i] = $i;
                        }

                        $acf_fields = array();

                        if (class_exists('ACF')) {

                            if (class_exists('DEBC_INIT')) {
                                $acf_fields = DEBC_INIT::get_acf_fields();
                            } else if (class_exists('DEDMACH_INIT')) {
                                $acf_fields = DEDMACH_INIT::get_acf_fields();
                            } else {
                                $acf_fields = DE_Filter::get_acf_fields();
                            }
                            $acf_fields['none'] = esc_html__('Please select an ACF field', 'divi-bodyshop-woocommerce');

                            $image_style_settings = array(
                                'default'    => esc_html__('Default', 'et_builder'),
                                'no_overlay' => esc_html__('Image Only (no overlay)', 'et_builder'),
                                'flip_image' => esc_html__('Flip Image', 'et_builder')
                            );
                        } else if (defined('DE_DB_WOO_VERSION')) {
                            $acf_fields           = DEBC_INIT::get_acf_fields();
                            $image_style_settings = array(
                                'default'    => esc_html__('Default', 'et_builder'),
                                'no_overlay' => esc_html__('Image Only (no overlay)', 'et_builder'),
                                'flip_image' => esc_html__('Flip Image', 'et_builder')
                            );
                        } else {
                            $image_style_settings = array(
                                'default'    => esc_html__('Default', 'et_builder'),
                                'no_overlay' => esc_html__('Image Only (no overlay)', 'et_builder')
                            );
                        }

                        if (class_exists('DEBC_INIT')) {
                            $options_posttype = DEBC_INIT::get_divi_post_types();
                        } else if (class_exists('DEDMACH_INIT')) {
                            $options_posttype = DEDMACH_INIT::get_divi_post_types();
                        } else {
                            $options_posttype = DE_Filter::get_divi_post_types();
                        }

                        $fields = array(
                            'thumb_image_size'         => array(
                                'label'            => __('Thumbnail Image Size', 'et_builder'),
                                'type'             => 'select',
                                'computed_affects' => array(
                                    '__getthumbnail'
                                ),
                                'options'          => $options,
                                'default'          => 'woocommerce_thumbnail',
                                'description'      => __('Pick a size for the thumbnail image from the list.', 'et_builder')
                            ),
                            'link_product'             => array(
                                'label'           => esc_html__('Link Image to Single Page', 'et_builder'),
                                'type'            => 'yes_no_button',
                                'option_category' => 'configuration',
                                'options'         => array(
                                    'on'  => esc_html__('Yes', 'et_builder'),
                                    'off' => esc_html__('No', 'et_builder')
                                ),
                                'affects'         => array(
                                    'new_tab'
                                ),
                                'description'     => esc_html__('Enable this if you want to allow the user to click on the image to go to the single page.)', 'et_builder')
                            ),
                            'enable_placeholder_image' => array(
                                'label'           => esc_html__('Enable placeholder image (ACF)?', 'et_builder'),
                                'type'            => 'yes_no_button',
                                'option_category' => 'configuration',
                                'options'         => array(
                                    'on'  => esc_html__('Yes', 'et_builder'),
                                    'off' => esc_html__('No', 'et_builder')
                                ),
                                'affects'         => array(
                                    'placeholder_image'
                                ),
                                'description'     => esc_html__('Enable this if you want a placeholder incase no one uploads a featured image. If using WooCommerce it will look for the default WooCommerce placeholder and not this setting.)', 'et_builder')
                            ),
                            'change_on_variation'   => array(
                                'label'           => esc_html__('Variation Image Change?', 'et_builder'),
                                'type'            => 'yes_no_button',
                                'option_category' => 'configuration',
                                'options'         => array(
                                    'on'  => esc_html__('Yes', 'et_builder'),
                                    'off' => esc_html__('No', 'et_builder')
                                ),
                                'default'         => 'off',
                                'description'     => esc_html__('Enable this if you want the thumbnail to change to the variation if you have images set for each variation. This used alongside the add to cart module, with the setting "show variation on archive page".', 'et_builder')
                            ),
                            'placeholder_image'        => array(
                                'label'              => esc_html__('Placeholder Image'),
                                'type'               => 'upload',
                                'option_category'    => 'configuration',
                                'upload_button_text' => esc_html__('Upload an image'),
                                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                                'hide_metadata'      => true,
                                'description'        => esc_html__('Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder'),
                                'depends_show_if'    => 'on',
                                'depends_on'         => array(
                                    'enable_placeholder_image'
                                )
                            ),
                            'placeholder_alt'          => array(
                                'label'           => esc_html__('Image Alternative Text', 'et_builder'),
                                'type'            => 'text',
                                'option_category' => 'configuration',
                                'depends_show_if' => 'on',
                                'depends_on'      => array(
                                    'enable_placeholder_image'
                                ),
                                'description'     => esc_html__('This defines the HTML ALT text. A short description of your image can be placed here.', 'et_builder')
                            ),
                            'placeholder_title_text'   => array(
                                'label'           => esc_html__('Image Title Text', 'et_builder'),
                                'type'            => 'text',
                                'option_category' => 'configuration',
                                'depends_show_if' => 'on',
                                'depends_on'      => array(
                                    'enable_placeholder_image'
                                ),
                                'description'     => esc_html__('This defines the HTML Title text.', 'et_builder')
                            ),
                            'new_tab'                  => array(
                                'label'           => esc_html__('Open In New Tab?', 'et_builder'),
                                'type'            => 'yes_no_button',
                                'option_category' => 'layout',
                                'option_category' => 'configuration',
                                'options'         => array(
                                    'on'  => esc_html__('Yes', 'et_builder'),
                                    'off' => esc_html__('No', 'et_builder')
                                ),
                                'default'         => 'off',
                                'depends_show_if' => 'on',
                                'description'     => esc_html__('Enable this if you want the link to open in a new tab.', 'et_builder')
                            ),
                            'enable_title'             => array(
                                'label'           => esc_html__('Enable Title Tag?', 'et_builder'),
                                'type'            => 'yes_no_button',
                                'option_category' => 'layout',
                                'option_category' => 'configuration',
                                'options'         => array(
                                    'on'  => esc_html__('Yes', 'et_builder'),
                                    'off' => esc_html__('No', 'et_builder')
                                ),
                                'default'         => 'on',
                                'description'     => esc_html__('Enable this if you want to have a title tag on the image.', 'et_builder')
                            ),
                            'image_style'              => array(
                                'label'       => esc_html__('Image Style', 'et_builder'),
                                'type'        => 'select',
                                // 'option_category'   => 'color_option',
                                'options'     => $image_style_settings,
                                'affects'     => array(
                                    'acf_name'
                                ),
                                'description' => esc_html__('Choose what style of thumbnail you want, for example if you want the first image of your gallery to flip to when hovering over the thumbnail, select "Flip Hover". Flip image only works with BodyCommerce or ACF installed', 'et_builder')
                            ),
                            'acf_name'                 => array(
                                'label'           => esc_html__('Choose Second Image (ACF Only), leave blank for WooCommerce gallery 2nd image', 'divi-filter'),
                                'type'            => 'select',
                                'depends_show_if' => 'flip_image',
                                'options'         => $acf_fields,
                                'option_category' => 'configuration',
                                'description'     => esc_html__('For WooCommerce, leave blank if you want the second image int he gallery to show. Choose the second image you want to show when hovered (flip) if you want an ACF image to show', 'divi-filter')
                            ),
                            'icon_hover_color'         => array(
                                'label'        => esc_html__('Icon Hover Color', 'et_builder'),
                                'type'         => 'color-alpha',
                                'custom_color' => true,
                                'tab_slug'     => 'advanced',
                                'toggle_slug'  => 'overlay'
                            ),
                            'hover_overlay_color'      => array(
                                'label'        => esc_html__('Hover Overlay Color', 'et_builder'),
                                'type'         => 'color-alpha',
                                'custom_color' => true,
                                'tab_slug'     => 'advanced',
                                'toggle_slug'  => 'overlay'
                            ),
                            'hover_icon'               => array(
                                'label'           => esc_html__('Hover Icon Picker', 'et_builder'),
                                'type'            => 'select_icon',
                                'option_category' => 'configuration',
                                'default'         => 'P',
                                'class'           => array(
                                    'et-pb-font-icon'
                                ),
                                'depends_show_if' => 'on',
                                'tab_slug'        => 'advanced',
                                'toggle_slug'     => 'overlay',
                                'description'     => esc_html__('Here you can define a custom icon for the overlay', 'et_builder')
                            ),
                            'align'                    => array(
                                'label'            => esc_html__('Image Alignment', 'et_builder'),
                                'type'             => 'text_align',
                                'option_category'  => 'layout',
                                'options'          => et_builder_get_text_orientation_options(array(
                                    'justified'
                                )),
                                'default_on_front' => 'left',
                                'tab_slug'         => 'advanced',
                                'toggle_slug'      => 'alignment',
                                'description'      => esc_html__('Here you can choose the image alignment.', 'et_builder'),
                                'options_icon'     => 'module_align'
                            ),
                            'force_fullwidth'          => array(
                                'label'            => esc_html__('Force Fullwidth', 'et_builder'),
                                'type'             => 'yes_no_button',
                                'option_category'  => 'layout',
                                'options'          => array(
                                    'off' => esc_html__('No', 'et_builder'),
                                    'on'  => esc_html__('Yes', 'et_builder')
                                ),
                                'default_on_front' => 'off',
                                'tab_slug'         => 'advanced',
                                'toggle_slug'      => 'width',
                                'affects'          => array(
                                    'max_width'
                                )
                            ),
                            'always_center_on_mobile'  => array(
                                'label'            => esc_html__('Always Center Image On Mobile', 'et_builder'),
                                'type'             => 'yes_no_button',
                                'option_category'  => 'layout',
                                'options'          => array(
                                    'on'  => esc_html__('Yes', 'et_builder'),
                                    'off' => esc_html__('No', 'et_builder')
                                ),
                                'default_on_front' => 'on',
                                'tab_slug'         => 'advanced',
                                'toggle_slug'      => 'alignment'
                            ),
                            // 'vb_posttype' => array(
                            //   'toggle_slug'       => 'visual_builder',
                            //   'label'       => __( 'Visual Builder Post', 'et_builder' ),
                            //   'type'        => 'select',
                            //   'options'     => $options_posttype,
                            //   'default'     => 'none',
                            //   'computed_affects' => array(
                            //     '__getthumbnail',
                            //   ),
                            //   'description' => __( 'Set the post type you want to display in the Visual builder - we will look for the first post in this post type to get the data.', 'et_builder' ),
                            // ),
                            '__getthumbnail'           => array(
                                'type'                => 'computed',
                                'computed_callback'   => array(
                                    'de_filter_thumbnail_code',
                                    'get_thumbnail'
                                ),
                                'computed_depends_on' => array(
                                    'thumb_image_size',
                                    'vb_posttype'
                                )
                            )
                        );

                        return $fields;
                    }

                    public static function get_thumbnail($args = array(), $conditional_tags = array(), $current_page = array())
                    {

                        if (!is_admin()) {
                            return;
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

                        $post_type_choose = $page_post_type;

                        $thumb_image_size = $args['thumb_image_size'];

                        ob_start();

                        $get_cpt_args = array(
                            'post_type'      => $post_type_choose,
                            'post_status'    => 'publish',
                            'posts_per_page' => '1',
                            'orderby'        => 'ID',
                            'order'          => 'ASC'
                        );

                        query_posts($get_cpt_args);
                        $first = true;
                        if (have_posts()) {
                            while (have_posts()) {
                                the_post();
                                if (has_post_thumbnail()) {
                                    // setup_postdata( $post );
                                    if ($first) {
                                        //////////////////////////////////////////////////
                                        if (class_exists('woocommerce') && get_post_type() == "product") {
                                            do_action('woocommerce_before_shop_loop_item_title');
                                        } else {
                                        ?>
                    <span class="et_shop_image">
                    <?php
                        echo get_the_post_thumbnail(get_the_id(), $thumb_image_size, array(
                                                                    'class' => 'featured-image'
                                                                ));
                                                            ?>
                    <span class="et_overlay"></span>
                    </span>
                    <?php
                        }
                                                            /////////////////////////////////////////////////
                                                            $first = false;
                                                        } else {

                                                        }
                                                    } else {
                                                    ?>
                <img src="//via.placeholder.com/350x350?text=Post+has+no+image" />
                <?php
                    }
                                            }
                                        }
                                        $data = ob_get_clean();
                                        return $data;

                                    }

                                    public function get_alignment()
                                    {
                                        $alignment = isset($this->props['align']) ? $this->props['align'] : '';

                                        return et_pb_get_alignment($alignment);
                                    }

                                    function render($attrs, $content, $render_slug)
                                    {
                                        if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
                                            return;
                                        }

                                        global $de_loop_variable, $post;

                                        $post_id = $post->ID;

                                        $link_product            = $this->props['link_product'];
                                        $new_tab                 = $this->props['new_tab'];
                                        $image_style             = $this->props['image_style'];
                                        $align                   = $this->get_alignment();
                                        $force_fullwidth         = $this->props['force_fullwidth'];
                                        $always_center_on_mobile = $this->props['always_center_on_mobile'];
                                        $icon_hover_color        = $this->props['icon_hover_color'];
                                        $hover_overlay_color     = $this->props['hover_overlay_color'];
                                        $hover_icon              = $this->props['hover_icon'] ?: 'P';
                                        $animation_style         = $this->props['animation_style'];
                                        $thumb_image_size        = $this->props['thumb_image_size'];
                                        $acf_name                = $this->props['acf_name'];
                                        $enable_title            = $this->props['enable_title'];

                                        $enable_placeholder_image = $this->props['enable_placeholder_image'];
                                        $change_on_variation      = $this->props['change_on_variation'];
                                        $placeholder_image        = $this->props['placeholder_image'];
                                        $placeholder_alt          = $this->props['placeholder_alt'];
                                        $placeholder_title_text   = $this->props['placeholder_title_text'];
                
                                        // Module classnames
                                        $this->add_classname(
                                            array(
                                                'clearfix',
                                                $this->get_text_orientation_classname(),
                                            )
                                        );

                                        if ("on" == $new_tab) {
                                            $new_tab_dis = '_blank';
                                        } else {
                                            $new_tab_dis = '';
                                        }

                                        if ('' !== $icon_hover_color) {
                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%% .et_overlay:before',
                                                'declaration' => sprintf('color: %1$s !important;', esc_html($icon_hover_color))
                                            ));
                                        }
                                        if ('' !== $hover_overlay_color) {
                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%% .et_overlay',
                                                'declaration' => sprintf('background-color: %1$s !important;border-color: %1$s;', esc_html($hover_overlay_color))
                                            ));
                                        }
                                        if (!$this->_is_field_default('align', $align)) {
                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%%',
                                                'declaration' => sprintf('text-align: %1$s;', esc_html($align))
                                            ));
                                        }
                                        if ('center' !== $align) {
                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%%',
                                                'declaration' => sprintf('margin-%1$s: 0;', esc_html($align))
                                            ));
                                        }
                                        if ('on' === $force_fullwidth) {
                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%%',
                                                'declaration' => 'max-width: 100% !important;'
                                            ));
                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%% .et_pb_image_wrap, %%order_class%% img',
                                                'declaration' => 'width: 100%;'
                                            ));
                                        }
                                        if ('on' === $always_center_on_mobile) {
                                            $this->add_classname('et_always_center_on_mobile');
                                        }
                                        if ("flip_image" == $image_style || "flip_image_dmach" == $image_style) {
                                            $this->add_classname('flip-image-thumbnail');
                                        }
                                        if (!in_array($animation_style, array(
                                            '',
                                            'none'
                                        ))) {
                                            $this->add_classname('et-waypoint');
                                        }

                                        if ( $change_on_variation == 'on' ) {
                                            $this->add_classname('change_on_variation');
                                        }
                                        
                                        if ('' !== $hover_overlay_color) {
                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%% .et_overlay',
                                                'declaration' => sprintf('background-color: %1$s;', esc_html($hover_overlay_color))
                                            ));
                                        }

                                        if (class_exists('DEBC_INIT')) {
                                            $options_posttype = DEBC_INIT::get_divi_post_types();
                                        } else if (class_exists('DEDMACH_INIT')) {
                                            $options_posttype = DEDMACH_INIT::get_divi_post_types();
                                        } else {
                                            $options_posttype = DE_Filter::get_divi_post_types();
                                        }

                                        if (!empty($hover_icon)) {
                                            if (class_exists('DEBC_INIT')) {
                                                $css_icon_hover = DEBC_INIT::et_icon_css_content(esc_attr($hover_icon));
                                            } else if (class_exists('DEDMACH_INIT')) {
                                                $css_icon_hover = DEDMACH_INIT::et_icon_css_content(esc_attr($hover_icon));
                                            } else {
                                                $css_icon_hover = DE_Filter::et_icon_css_content(esc_attr($hover_icon));
                                            }

                                            $hover_icon_arr         = explode('||', $hover_icon);
                                            $hover_icon_font_family = (!empty($hover_icon_arr[1]) && 'fa' == $hover_icon_arr[1]) ? 'FontAwesome' : 'ETmodules';
                                            $hover_icon_font_weight = (!empty($hover_icon_arr[2])) ? $hover_icon_arr[2] : '400';

                                            ET_Builder_Element::set_style($render_slug, array(
                                                'selector'    => '%%order_class%% .et_overlay:before',
                                                'declaration' => sprintf('content: "%1$s";font-family: "%2$s"!important;font-weight: %3$s;', esc_html($css_icon_hover), $hover_icon_font_family, $hover_icon_font_weight)
                                            ));
                                        }

                                        //////////////////////////////////////////////////////////////////////
                                        ob_start();

                                        $image_src = "";

                                        $is_product = false;

                                        if ( class_exists('woocommerce') ) {
                                            global $product;
                                            if ( $product && ( $product->get_id() == $post_id ) ) {
                                                $is_product = true;
                                            }
                                        }

                                        if ('on' == $link_product) {
                                            if ($is_product) {
                                                global $product, $woocommerce;
                                                if (!is_a($product, 'WC_Product')) {
                                                    return;
                                                }
                                                $post_id = $product->get_id();
                                            }

                                            if (isset($de_loop_variable[$post_id]['permalink'])) {
                                                $url = $de_loop_variable[$post_id]['permalink'];
                                            } else {
                                                $url = $de_loop_variable[$post_id]['permalink'] = get_permalink($post_id);
                                            }

                                            echo '<a href="' . esc_url($url) . '" target="'. esc_attr($new_tab_dis) . '">';
                                        }

                                        $image_thumbnail = get_the_post_thumbnail($post_id);

                                        if ( $is_product && $image_thumbnail == '' ) {
                                            $parent_product_id = $product->get_parent_id();
                                            if ( $product->get_parent_id() != 0 ) {
                                                $image_thumbnail = get_the_post_thumbnail($parent_product_id);
                                            }
                                        }

                                        if ("flip_image" == $image_style || "flip_image_dmach" == $image_style) {

                                            if ($is_product) {

                                                global $de_categoryloop_term;
                                                if (isset($de_categoryloop_term)) {
                                                    $thumbnail_id = get_term_meta( $de_categoryloop_term->term_id, 'thumbnail_id', true );
                                                    $placeholder_alt = $de_categoryloop_term->name;
                                                    $image = wp_get_attachment_url( $thumbnail_id );
                                                    if ( !$image ) {
                                                        $image = wc_placeholder_img_src();
                                                      }
                                                    ?>
                                                    <img src="<?php echo esc_html($image); ?>" alt="<?php echo esc_attr($placeholder_alt); ?>" style="width: 100%;" class="featured-image">
                                                    <?php
                                                } else {
                                                    global $product;
                                                    $attachment_ids = $product->get_gallery_image_ids();
                                                    
                                                    $image_info  = "";
                                                    $image_src   = "";
                                                    $h           = "";
                                                    $w           = "";
                                                    $image_title = "";
                                                    $image_alt   = "";
                                                    
                                                    if (class_exists('ACF')) {
                                                        $acf_get = get_field_object($acf_name);
                                                        
                                                        if ("" == $acf_get) {
                                                            if (!empty($attachment_ids)) {
                                                                $image_info          = wp_get_attachment_image_src($attachment_ids[0], $thumb_image_size);
                                                                $attachment_first[1] = get_post_thumbnail_id($post_id);
                                                                $attachment          = wp_get_attachment_image_src($attachment_first[1], $thumb_image_size);
                                                                $w                   = $attachment[1];
                                                                $h                   = $attachment[2];

                                                                if ("on" == $enable_title) {
                                                                    $image_title = get_the_title($attachment_ids[0]);
                                                                } else {
                                                                    $image_title = "";
                                                                }
                                                                $image_alt = get_post_meta($attachment_ids[0], '_wp_attachment_image_alt', true);
                                                                $image_src = $image_info[0];
                                                            }
                                                        } else {
                                                            
                                                            if (is_array($acf_get)) {
                                                                $acf_type = $acf_get['type'];
                                                                $image    = null;
                                                                if (!empty($acf_get['parent']) && get_post_type($acf_get['parent']) != 'acf-field-group') {
                                                                    $parent_object     = get_post($acf_get['parent']);
                                                                    $parent_object_key = $parent_object->post_name;
                                                                    if (have_rows($parent_object_key, get_the_ID())) {
                                                                        while (have_rows($parent_object_key)):
                                                                            the_row();
                                                                            $image = get_sub_field($acf_name);
                                                                        endwhile;
                                                                    }
                                                                } else {
                                                                    $image = get_field($acf_name);
                                                                }
                                                                if ("image" == $acf_type) {
                                                                    $return_format = $acf_get['return_format'];
                                                                    if ("array" == $return_format) {
                                                                        $thumb      = wp_get_attachment_image_src($image['id'], $thumb_image_size);
                                                                        $srcset     = wp_get_attachment_image_srcset($image['id'], $thumb_image_size);
                                                                        $image_info = esc_url($thumb[0]);
                                                                        $alt        = esc_attr($image['alt']);
                                                                        $title      = esc_attr($image['caption']);
                                                                    } else if ("id" == $return_format) {
                                                                        $thumb      = wp_get_attachment_image_src($image, $thumb_image_size);
                                                                        $srcset     = wp_get_attachment_image_srcset($image, $thumb_image_size);
                                                                        $image_info = esc_url($thumb[0]);
                                                                        $alt        = "";
                                                                        $title      = "";
                                                                    } else if ("url" == $return_format) {
                                                                        $image_info = $image;
                                                                        $srcset     = "";
                                                                        $alt        = "";
                                                                        $title      = "";
                                                                    }

                                                                    if ("on" == $enable_title) {
                                                                        $title = $title;
                                                                    } else {
                                                                        $title = "";
                                                                    }
                                                                }
                                                                $image_src = $image_info;
                                                            }
                                                        }
                                                    }
                                                    
                                                    if ("" == $image_src) {
                                                        if (!empty($attachment_ids)) {
                                                            $image_info          = wp_get_attachment_image_src($attachment_ids[0], $thumb_image_size);
                                                            $attachment_first[1] = get_post_thumbnail_id($product->get_id());
                                                            $attachment          = wp_get_attachment_image_src($attachment_first[1], $thumb_image_size);
                                                            $w                   = $attachment[1];
                                                            $h                   = $attachment[2];

                                                            if ("on" == $enable_title) {
                                                                $image_title = get_the_title($attachment_ids[0]);
                                                            } else {
                                                                $image_title = "";
                                                            }
                                                            $image_alt = get_post_meta($attachment_ids[0], '_wp_attachment_image_alt', true);
                                                            $image_src = $image_info[0];
                                                        }
                                                    }

                                                    echo woocommerce_show_product_loop_sale_flash();
                                                    ?>
                                                    <div class="flip-image-cont">
                                                        <?php
                                                        if ("" !== $image_src) {
                                                            echo '<img class="secondary-image" src="' . esc_attr($image_src) . '" height="' . esc_attr($h) . '" width="' . esc_attr($w) . '" title="' . esc_attr($image_title) . '" alt="' . esc_attr($image_alt) . '">';
                                                        }
                                                        global $product;
                                                        $image_size = apply_filters('single_product_archive_thumbnail_size', $thumb_image_size);
                                                        echo $product ? wp_kses_post($product->get_image($image_size)) : '';
                                                        ?>
                                                        </div>
                                                        <?php
                                                    }
                                                
                                            } else if (class_exists('ACF')) {

                                              $acf_get = get_field_object($acf_name);

                                                if (is_array($acf_get)) {

                                                  $acf_type = $acf_get['type'];
                                                  $image    = null;
                                                  if (!empty($acf_get['parent']) && get_post_type($acf_get['parent']) != 'acf-field-group') {
                                                      $parent_object     = get_post($acf_get['parent']);
                                                      $parent_object_key = $parent_object->post_name;
                                                      if (have_rows($parent_object_key, get_the_ID())) {
                                                          while (have_rows($parent_object_key)):
                                                              the_row();
                                                              $image = get_sub_field($acf_name);
                                                          endwhile;
                                                      }
                                                  } else {
                                                      $image = get_field($acf_name);
                                                  }

                                                    if ("image" == $acf_type) {
                                                      $return_format = $acf_get['return_format'];
                                                      if ("array" == $return_format) {
                                                          $thumb      = wp_get_attachment_image_src($image['id'], $thumb_image_size);
                                                          $srcset     = wp_get_attachment_image_srcset($image['id'], $thumb_image_size);
                                                          $image_info = esc_url($thumb[0]);
                                                          $alt        = esc_attr($image['alt']);
                                                          $title      = esc_attr($image['caption']);
                                                      } else if ("id" == $return_format) {
                                                          $thumb      = wp_get_attachment_image_src($image, $thumb_image_size);
                                                          $srcset     = wp_get_attachment_image_srcset($image, $thumb_image_size);
                                                          $image_info = esc_url($thumb[0]);
                                                          $alt        = "";
                                                          $title      = "";
                                                      } else if ("url" == $return_format) {
                                                          $image_info = $image;
                                                          $srcset     = "";
                                                          $alt        = "";
                                                          $title      = "";
                                                      }

                                                         if ("on" == $enable_title) {
                                                           $title = $title;
                                                        } else {
                                                             $title = "";
                                                         }
                                                        ?>
                                                        <img class="secondary-image" src="<?php echo esc_attr($image_info); ?>" alt="<?php echo esc_attr($alt); ?>" title="<?php echo esc_attr($title); ?>" srcset="<?php echo esc_attr($srcset); ?>" />
                                                        <?php
                                                        if ("" == $image_thumbnail && "on" == $enable_placeholder_image) {
                                                          ?>
                                                          <img src="<?php echo esc_html($placeholder_image); ?>" alt="<?php echo esc_attr($placeholder_alt); ?>" title="<?php echo esc_attr($placeholder_title_text); ?>" style="width: 100%;" class="featured-image">
                                                          <?php
                                                        } else {
                                                    
                                                            if ($thumb_image_size == 'et-pb-portfolio-image') {
                                                                $width = 400;
                                                                $width = (int) apply_filters( 'et_pb_portfolio_image_width', $width );
                                                                $height = 284;
                                                                $height = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
                                                                $thumb_image_size = array($width, $height);
                                                            }

                                                            echo get_the_post_thumbnail($post_id, $thumb_image_size, array(
                                                                'class' => 'featured-image'
                                                            ));
                                                        }
                                                    } else {
                                                        if ("" == $image_thumbnail && "on" == $enable_placeholder_image) {
                                                            ?>
                                                            <img src="<?php echo esc_html($placeholder_image); ?>" alt="<?php echo esc_attr($placeholder_alt); ?>" title="<?php echo esc_attr($placeholder_title_text); ?>" style="width: 100%;" class="featured-image">
                                                            <?php
                                                        } else {
                                                            
                                                    
                                                    if ($thumb_image_size == 'et-pb-portfolio-image') {
                                                        $width = 400;
                                                        $width = (int) apply_filters( 'et_pb_portfolio_image_width', $width );
                                                        $height = 284;
                                                        $height = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
                                                        $thumb_image_size = array($width, $height);
                                                    }

                                                            echo get_the_post_thumbnail($post_id, $thumb_image_size, array(
                                                                'class' => 'featured-image'
                                                            ));
                                                        }
                                                    }
                                                }
                                            } else {

                                            }

                                        } else if ("no_overlay" == $image_style) {
                                            
                                            if ($is_product) {
                                                global $de_categoryloop_term;
                                                if (isset($de_categoryloop_term)) {
                                                    $thumbnail_id = get_term_meta( $de_categoryloop_term->term_id, 'thumbnail_id', true );
                                                    $placeholder_alt = $de_categoryloop_term->name;
                                                    $image = wp_get_attachment_url( $thumbnail_id );
                                                    if ( !$image ) {
                                                        $image = wc_placeholder_img_src();
                                                      }
                                                    ?>
                                                    <img src="<?php echo esc_html($image); ?>" alt="<?php echo esc_attr($placeholder_alt); ?>" style="width: 100%;" class="featured-image">
                                                    <?php
                                                } else {
                                                    echo woocommerce_show_product_loop_sale_flash();
                                                    global $product;
                                                    $image_size = apply_filters('single_product_archive_thumbnail_size', $thumb_image_size);
                                                    echo $product ? wp_kses_post($product->get_image($image_size)) : '';
                                                }
                                            } else {
                                                if ("on" == $enable_title) {
                                                    $title = get_the_title(get_post_thumbnail_id());
                                                } else {
                                                    $title = "";
                                                }
                                                
                                                $alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                                                if ("" == $image_thumbnail && "on" == $enable_placeholder_image) {
                                                    ?>
                                                    <img src="<?php echo esc_html($placeholder_image); ?>" alt="<?php echo esc_attr($placeholder_alt); ?>" title="<?php echo esc_attr($placeholder_title_text); ?>" style="width: 100%;" class="featured-image">
                                                    <?php
                                                } else {
                                                    
                                                    
                                                    if ($thumb_image_size == 'et-pb-portfolio-image') {
                                                        $width = 400;
                                                        $width = (int) apply_filters( 'et_pb_portfolio_image_width', $width );
                                                        $height = 284;
                                                        $height = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
                                                        $thumb_image_size = array($width, $height);
                                                    }
                                                    
                                                    echo get_the_post_thumbnail(get_the_id(), $thumb_image_size, array(
                                                        'title' => $title,
                                                        'alt'   => $alt,
                                                        'class' => 'featured-image'
                                                    ));
                                                }

                                            }

                                        } else {
                                            
                                            if (class_exists('woocommerce') && $is_product ) {
                                                global $de_categoryloop_term;
                                                if (isset($de_categoryloop_term)) {
                                                    $thumbnail_id = get_term_meta( $de_categoryloop_term->term_id, 'thumbnail_id', true );
                                                    $placeholder_alt = $de_categoryloop_term->name;
                                                    $image = wp_get_attachment_url( $thumbnail_id );
                                                    if ( !$image ) {
                                                        $image = wc_placeholder_img_src();
                                                      }
                                                    ?>
                                                    <span class="et_shop_image">
                                                        <img src="<?php echo esc_html($image); ?>" alt="<?php echo esc_attr($placeholder_alt); ?>" style="width: 100%;" class="featured-image">
                                                        <span class="et_overlay"></span>
                                                    </span>
                                                    <?php
                                                } else {
                                                 do_action('woocommerce_before_shop_loop_item_title');
                                                }
                                            } else {
                                            ?>
                                            <span class="et_shop_image">
                                                <?php
                                                if ("on" == $enable_title) {
                                                    $title = get_the_title(get_post_thumbnail_id());
                                                } else {
                                                    $title = "";
                                                }
                                                
                                                $alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                                                
                                                
                                                if (get_the_post_thumbnail(get_the_id()) == "" && "on" == $enable_placeholder_image) {
                                                    ?>
                                                    <img src="<?php echo esc_html($placeholder_image); ?>" alt="<?php echo esc_attr($placeholder_alt); ?>" title="<?php echo esc_attr($placeholder_title_text); ?>" style="width: 100%;" class="featured-image">
                                                    <?php
                                                } else {
                                                    
                                                    if ($thumb_image_size == 'et-pb-portfolio-image') {
                                                        $width = 400;
                                                        $width = (int) apply_filters( 'et_pb_portfolio_image_width', $width );
                                                        $height = 284;
                                                        $height = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
                                                        $thumb_image_size = array($width, $height);
                                                    }

                                                    echo get_the_post_thumbnail(get_the_id(), $thumb_image_size, array(
                                                        'title' => $title,
                                                        'alt'   => $alt,
                                                        'class' => 'featured-image'
                                                    ));
                                                }
                                                ?>
                                                <span class="et_overlay"></span>
                                            </span>
                                            <?php
                                            }
                                        }
                                        
                                        if ('on' == $link_product) {
                                            echo '</a>';
                                        }
                                        
                                        $data = ob_get_clean();

                                      //////////////////////////////////////////////////////////////////////
                                      return $data;
                                  }
                              }
                              $de_filter_thumbnail_object = new de_filter_thumbnail_code();
                              $de_filter_thumbnail_object->change_shortcode();
                          }
                      }
              }
