<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists("Divi_filter_title_module_import")) {
    add_action('et_builder_ready', 'Divi_filter_title_module_import');

    function Divi_filter_title_module_import()
    {
        if (class_exists("ET_Builder_Module") && !class_exists("de_filter_title_code")) {
            class de_filter_title_code extends ET_Builder_Module
            {

                public $vb_support        = 'on';
                protected $module_credits = array(
                    'module_uri' => DE_DF_PRODUCT_URL,
                    'author'     => DE_DF_AUTHOR,
                    'author_uri' => DE_DF_URL,
                );

                function init()
                {
                    if (defined('DE_DB_WOO_VERSION')) {
                        $this->name        = esc_html__('PL Title - Product Page / Loop Layout', 'divi-bodyshop-woocommerce');
                        $this->slug        = 'et_pb_db_product_title';
                        $this->folder_name = 'divi_bodycommerce';
                    } else if (defined('DE_DMACH_VERSION')) {
                        $this->name        = esc_html__('Post Title - Divi Machine', 'divi-machine');
                        $this->slug        = 'et_pb_de_mach_title';
                        $this->folder_name = 'divi_machine';
                    } else {
                        $this->name        = esc_html__('Post Title - Archive Pages', 'divi-filter');
                        $this->slug        = 'et_pb_df_title';
                        $this->folder_name = 'divi_ajax_filter';
                    }

                    add_action('et_theme_builder_after_layout_opening_wrappers', array(
                        $this,
                        'change_shortcode_in_content',
                    ), 1, 2);
                    add_filter('the_content', array(
                        $this,
                        'change_shortcode_in_render',
                    ), 1, 1);

                    $this->fields_defaults = array(
                        // 'loop_layout'         => array( 'on' ),
                        'background_layout' => array(
                            'light',
                        ),
                        'link_product'      => array(
                            'off',
                        ),
                    );
                    $this->settings_modal_toggles = array(
                        'general'  => array(
                            'toggles' => array(
                                'main_content' => esc_html__('Main Options', 'divi-machine'),
                                // 'visual_builder' => esc_html__( 'Visual Builder', 'divi-machine' ),

                            ),
                        ),
                        'advanced' => array(
                            'toggles' => array(
                                'text' => esc_html__('Text', 'divi-machine'),
                            ),
                        ),

                    );

                    $this->main_css_element = '%%order_class%%';
                    $this->advanced_fields  = array(
                        'fonts'          => array(
                            'title'  => array(
                                'label'       => esc_html__('Title', 'divi-machine'),
                                'css'         => array(
                                    'main'      => "{$this->main_css_element} .de_title_module, {$this->main_css_element} .dmach-post-title",
                                    'important' => 'all',
                                ),
                                'font_size'   => array(
                                    'default' => '30px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                            ),
                            'header' => array(
                                'label'       => esc_html__('Product Title', 'divi-bodyshop-woocommerce'),
                                'css'         => array(
                                    'main'      => "{$this->main_css_element} .product_title",
                                    'important' => 'all',
                                ),
                                'font_size'   => array(
                                    'default' => '30px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                            ),
                        ),
                        'background'     => array(
                            'settings' => array(
                                'color' => 'alpha',
                            ),
                        ),
                        'button'         => array(
                        ),
                        'box_shadow'     => array(
                            'default' => array(),
                            'product' => array(
                                'label'           => esc_html__('Box Shadow', 'divi-machine'),
                                'css'             => array(
                                    'main' => "%%order_class%%",
                                ),
                                'option_category' => 'layout',
                                'tab_slug'        => 'advanced',
                                'toggle_slug'     => 'product',
                            ),
                        ),
                        'margin_padding' => array(
                            'css' => array(
                                'margin'    => "%%order_class%%",
                                'padding'   => "%%order_class%% .entry-title",
                                'important' => 'all',
                            ),
                        ),
                    );

                    $this->custom_css_fields = array(
                    );

                    $this->help_videos = array(
                    );
                }

                function change_shortcode()
                {
                    global $shortcode_tags;
                    $slug_arr = array(
                        'et_pb_db_product_title',
                        'et_pb_de_mach_title',
                        'et_pb_df_title',
                    );
                    unset($slug_arr[array_search($this->slug, $slug_arr)]);
                    foreach ($slug_arr as $other_slug) {
                        if (!shortcode_exists($other_slug)) {
                            $shortcode_tags[$other_slug] = $shortcode_tags[$this->slug]; // phpcs:ignore

                        }
                    }
                }

                function change_shortcode_in_content($layout_type, $layout_id)
                {
                    $layout_post    = get_post($layout_id);
                    $layout_content = $layout_post->post_content;

                    $slug_arr = array(
                        'et_pb_db_product_title',
                        'et_pb_de_mach_title',
                        'et_pb_df_title',
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
                            'post_content' => $layout_content,
                        );

                        wp_update_post($post_arr, false, false);
                    }
                }

                function change_shortcode_in_render($content)
                {
                    $slug_arr = array(
                        'et_pb_db_product_title',
                        'et_pb_de_mach_title',
                        'et_pb_df_title',
                    );
                    unset($slug_arr[array_search($this->slug, $slug_arr)]);
                    foreach ($slug_arr as $other_slug) {
                        if (has_shortcode($content, $other_slug)) {
                            $content = str_replace($other_slug, $this->slug, $content);
                        }
                    }

                    return $content;
                }

                function get_fields()
                {
                    if (class_exists('DEBC_INIT')) {
                        $options_posttype = DEBC_INIT::get_divi_post_types();
                    } else if (class_exists('DEDMACH_INIT')) {
                        $options_posttype = DEDMACH_INIT::get_divi_post_types();
                    } else {
                        $options_posttype = DE_Filter::get_divi_post_types();
                    }

                    if (defined('DE_DMACH_VERSION')) {
                        $get_title_options = array (
                            'post'          => 'Post Title',
                            'category'      => 'Taxonomy Title'
                        );
                    } else {
                        $get_title_options = array (
                            'post'          => 'Post Title',
                            'category'      => 'Category Title'
                        );
                    }

                    $fields = array(
                        'title_tag'      => array(
                            'label'       => __('Title HTML Tag', 'et_builder'),
                            'type'        => 'select',
                            'options'     => array(
                                "h1" => "h1",
                                "h2" => "h2",
                                "h3" => "h3",
                                "h4" => "h4",
                                "h5" => "h5",
                                "h6" => "h6",
                                "p"  => "p",
                            ),
                            'default'     => 'h1',
                            'description' => __('Set the title tag. For example you may want it to be h3 or h4 on the custom layout.', 'et_builder'),
                        ),
                        'link_product'   => array(
                            'label'           => esc_html__('Link Title to Single Page', 'et_builder'),
                            'type'            => 'yes_no_button',
                            'option_category' => 'layout',
                            'option_category' => 'configuration',
                            'options'         => array(
                                'on'  => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'affects'         => array(
                                'new_tab',
                            ),
                            'description'     => esc_html__('Enable this if you want to allow the user to click on the title to go to the single/product page.', 'et_builder'),
                        ),
                        'new_tab'        => array(
                            'label'           => esc_html__('Open In New Tab?', 'et_builder'),
                            'type'            => 'yes_no_button',
                            'option_category' => 'layout',
                            'option_category' => 'configuration',
                            'options'         => array(
                                'on'  => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'default'         => 'off',
                            'depends_show_if' => 'on',
                            'description'     => esc_html__('Enable this if you want the link to open in a new tab.', 'et_builder'),
                        ),
                        'get_title_options'      => array(
                            'label'       => __('Get Title From', 'et_builder'),
                            'type'        => 'select',
                            'options'     => $get_title_options,
                            'default'     => 'post',
                            'description' => __('Post is default. But if you are using Divi Machine or BodyCommerce and using category loop layout for example, choose "Category".', 'et_builder'),
                        ),
                        // 'vb_posttype' => array(
                        //   'toggle_slug'       => 'visual_builder',
                        //   'label'       => __( 'Visual Builder Post', 'et_builder' ),
                        //   'type'        => 'select',
                        //   'computed_affects' => array(
                        //     '__getposttitle',
                        //   ),
                        //   'options'     => $options_posttype,
                        //   'default'     => 'none',
                        //   'description' => __( 'Set the post type you want to display in the Visual builder - we will look for the first post in this post type to get the data.', 'et_builder' ),
                        // ),
                        '__getposttitle' => array(
                            'type'                => 'computed',
                            'computed_callback'   => array(
                                'de_filter_title_code',
                                'get_post_title',
                            ),
                            'computed_depends_on' => array(
                                'vb_posttype',
                            ),
                        ),
                    );

                    return $fields;
                }

                public static function get_post_title($args = array(), $conditional_tags = array(), $current_page = array())
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

                    ob_start();

                    $get_cpt_args = array(
                        'post_type'      => $post_type_choose,
                        'post_status'    => 'publish',
                        'posts_per_page' => '1',
                        'orderby'        => 'ID',
                        'order'          => 'ASC',
                    );

                    query_posts($get_cpt_args);
                    $first = true;

                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            // setup_postdata( $post );
                            if ($first) {

                                //////////////////////////////////////////////////
                                echo get_the_title();
                                //////////////////////////////////////////////////
                                $first = false;
                            } else {

                            }
                        }
                    }

                    $data = ob_get_clean();

                    return $data;

                }

                function render($attrs, $content, $render_slug)
                {
                    if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
                        return;
                    }

                    global $de_loop_variable, $post;

                    $post_id = $post->ID;

                    $link_product = $this->props['link_product'];
                    $title_tag    = $this->props['title_tag'];
                    $new_tab      = $this->props['new_tab'];

                    $get_title_options      = $this->props['get_title_options'];
                
                    // Module classnames
                    $this->add_classname(
                        array(
                            'clearfix',
                            $this->get_text_orientation_classname(),
                        )
                    );
                    

                    if ("" == $title_tag) {
                        $title_tag = "h1";
                    } else {
                        $title_tag = $title_tag;
                    }

                    if ("on" == $new_tab) {
                        $new_tab_dis = '_blank';
                    } else {
                        $new_tab_dis = '';
                    }
                    //////////////////////////////////////////////////////////////////////
                    ob_start();

                    if (class_exists('woocommerce') && get_post_type() == "product") {
                        $class_name = "product_title";
                    } else if (defined('DE_DMACH_VERSION')) {
                        $class_name = "dmach-post-title";
                    } else {
                        $class_name = "df-post-title";
                    }

                    // $term = get_queried_object();
                    // $title = $term->name;
                    // // $term_link = get_term_link( $term->term_id, $term->name);
                    // echo $title;

                    $title = '';
                    if (isset($de_loop_variable[$post_id]['title'])) {
                        $title = $de_loop_variable[$post_id]['title'];
                    } else {
                        if ($get_title_options == 'post') {
                            $title = $de_loop_variable[$post_id]['title'] = get_the_title();
                        } else {
                            global $de_categoryloop_term;
                            if (isset($de_categoryloop_term)) {
                                $title = $de_categoryloop_term->name;
                                $url = get_term_link( $de_categoryloop_term->term_id, $de_categoryloop_term->taxonomy);
                            } else {
                                $term = get_queried_object();
                                $title = $term->name;
                                $url = get_term_link( $term->term_id, $term->taxonomy);
                            }
                        }
                    }

                    if ('on' == $link_product) {
                        if (class_exists('woocommerce') && get_post_type() == "product") {
                            global $product, $woocommerce;
                            if (!is_a($product, 'WC_Product')) {
                                return;
                            }
                            $post_id = $product->get_id();
                        }

                        if ($get_title_options == 'post') {
                            if (isset($de_loop_variable[$post_id]['permalink'])) {
                                $url = $de_loop_variable[$post_id]['permalink'];
                            } else {
                                $url = $de_loop_variable[$post_id]['permalink'] = get_permalink($post_id);
                            }
                        }

	                    if ( isset( $url ) ) {
                        echo '<a href="' . esc_url($url) . '" target="'. esc_attr($new_tab_dis) . '">';
                    }
                    }
                    

                    echo '<' . esc_attr($title_tag) . ' itemprop="name" class="entry-title de_title_module ' . esc_attr($class_name) . '">';
                    echo wp_kses_post($title);
                    echo '</' . esc_attr($title_tag) . '>';

                    if ('on' == $link_product) {
                        echo '</a>';
                    }

                    $data = ob_get_clean();
                    //////////////////////////////////////////////////////////////////////
                    return $data;

                }

            }

            $de_filter_title_object = new de_filter_title_code();
            $de_filter_title_object->change_shortcode();

        }
    }
}
