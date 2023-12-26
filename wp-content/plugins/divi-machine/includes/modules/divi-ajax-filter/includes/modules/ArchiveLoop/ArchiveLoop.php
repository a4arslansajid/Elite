<?php
if (!defined('ABSPATH')) exit;

if (!function_exists("Divi_filter_loop_module_import")) {
    add_action('et_builder_ready', 'Divi_filter_loop_module_import');

    function Divi_filter_loop_module_import() {
        if (class_exists("ET_Builder_Module") && !class_exists("db_filter_loop_code")) {
            class db_filter_loop_code extends ET_Builder_Module {

                public $vb_support = 'on';

                public $options_posttype = array();
                public $options = array();

                public $acf_fields = array();

                public $de_domain_name = '';

                protected $module_credits = array(
                    'module_uri' => DE_DF_PRODUCT_URL,
                    'author' => DE_DF_AUTHOR,
                    'author_uri' => DE_DF_URL,
                );

                function init() {

                    if (defined('DE_DB_WOO_VERSION')) {
                        $this->slug = 'et_pb_db_shop_loop';
                        $this->name = esc_html__('ARP Product Loop - Archive Pages', 'divi-bodyshop-woocommerce');
                        $this->folder_name = 'divi_bodycommerce';
                        $this->de_domain_name = 'divi-bodyshop-woocommerce';
                    }
                    else {
                        $this->slug = 'et_pb_db_filter_loop';
                        $this->name = esc_html__('Archive Loop - Divi Ajax Filter', 'divi-filter');
                        $this->folder_name = 'divi_ajax_filter';
                        $this->de_domain_name = 'divi-filter';
                    }

                    if (class_exists('DEBC_INIT')) {
                        $this->options_posttype = DEBC_INIT::get_divi_post_types();
                        $this->options = DEBC_INIT::get_divi_layouts();
                    }
                    else if (class_exists('DEDMACH_INIT')) {
                        $this->options_posttype = DEDMACH_INIT::get_divi_post_types();
                        $this->options = DEDMACH_INIT::get_divi_layouts();
                    }
                    else {
                        $this->options_posttype = DE_Filter::get_divi_post_types();
                        $this->options = DE_Filter::get_divi_layouts();
                    }

                    if (function_exists('acf_get_field_groups')) {
                        $field_groups = acf_get_field_groups();
                        foreach ($field_groups as $group) {
                            // DO NOT USE here: $fields = acf_get_fields($group['key']);
                            // because it causes repeater field bugs and returns "trashed" fields
                            $fields = get_posts(array(
                                'posts_per_page' => - 1,
                                'post_type' => 'acf-field',
                                'orderby' => 'menu_order',
                                'order' => 'ASC',
                                'suppress_filters' => true, // DO NOT allow WPML to modify the query
                                'post_parent' => $group['ID'],
                                'post_status' => 'any',
                                'update_post_meta_cache' => false
                            ));
                            foreach ( $fields as $field ) {
                                $this->acf_fields[$field->post_name] = $field->post_excerpt;
                            }
                        }
                    }

                    $this->fields_defaults = array(
                        'cat_loop_style'        => array( 'off' ),
                        'fullwidth'             => array( 'off' ),
                        'columns'               => array( '3' ),
                        'show_pagination'       => array( 'on' ),
                        'show_add_to_cart'      => array( 'on' ),
                        'show_sorting_menu'     => array( 'off' ),
                        'show_results_count'    => array( 'off' ),
                    );

                    $this->settings_modal_toggles = array(
                        'general' => array(
                            'toggles' => array(
                                'main_content' => esc_html__('Module Options', $this->de_domain_name),
                                'loop_options'    => array(
                                    'title' => esc_html__( 'Loop Options', $this->de_domain_name),
                                    'tabbed_subtoggles' => true,
                                    'sub_toggles'       => array(
                                      'include_terms'     => array(
                                        'name' => esc_html__( 'Include Terms', $this->de_domain_name)
                                      ),
                                      'onload_terms'     => array(
                                        'name' => esc_html__( 'Terms on load Only', $this->de_domain_name)
                                      ),
                                    //   'sorting'     => array(
                                    //     'name' => esc_html__( 'Sorting', $this->de_domain_name)
                                    //   ),
                                    )
                                  ),
                                  'custom_content'    => array(
                                      'title' => esc_html__( 'Loop Layout Options', $this->de_domain_name),
                                      'tabbed_subtoggles' => true,
                                      'sub_toggles'       => array(
                                        'general'     => array(
                                          'name' => esc_html__( 'General', $this->de_domain_name)
                                        ),
                                        'include_terms'     => array(
                                          'name' => esc_html__( 'Include Terms', $this->de_domain_name)
                                        ),
                                        'grid'     => array(
                                          'name' => esc_html__( 'Grid Options', $this->de_domain_name)
                                        ),
                                      )
                                    ),
                                'element_options' => esc_html__('Element Options', $this->de_domain_name),
                                'default_content' => esc_html__('Default Layout Options', $this->de_domain_name)
                            )
                        ),
                        'advanced' => array(
                            'toggles' => array(
                                'text' => esc_html__('Text', $this->de_domain_name),
                                'loading_animation' => array(
                                    'priority' => '2',
                                    'title' => esc_html__('Loading Animation', $this->de_domain_name)
                                ),
                                'overlay' => esc_html__('Overlay', $this->de_domain_name),
                                'product' => esc_html__('Product', 'et_builder'),
                                'default_styles' => array(
                                    'title' => esc_html__('Default Style Options', $this->de_domain_name),
                                    'tabbed_subtoggles' => true,
                                    'sub_toggles' => array(
                                        'title' => array(
                                            'name' => 'Title'
                                        ),
                                        'price' => array(
                                            'name' => 'Price'
                                        ),
                                        'excerpt' => array(
                                            'name' => 'Excerpt'
                                        ),
                                        'category_title' => array(
                                            'name' => 'Category Title'
                                        ),
                                        'category_count' => array(
                                            'name' => 'Category Count'
                                        ),
                                        'category_count' => array(
                                            'name' => 'Category Count'
                                        ),
                                    )
                                ),
                                'pagination_styles' => array(
                                    'title' => esc_html__('Pagination', $this->de_domain_name),
                                    'tabbed_subtoggles' => true,
                                    'sub_toggles' => array(
                                        'pagination_item' => array(
                                            'name' => 'Pagination Item'
                                        ),
                                        'active_pagination_item' => array(
                                            'name' => 'Active Pagination Item'
                                        )
                                    )
                                )
                            )
                        )
                    );

                    $this->main_css_element = '%%order_class%%';

                    $this->advanced_fields = array(
                        'fonts' => array(
                            'title' => array(
                                'label' => esc_html__('Title', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% ul.products li.product .woocommerce-loop-product__title",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'default_styles',
                                'sub_toggle' => 'title'
                            ),
                            'price' => array(
                                'label' => esc_html__('Price', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% ul.products li.product .price, %%order_class%% ul.products li.product .price .amount",
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'range_settings' => array(
                                        'min' => '1',
                                        'max' => '100',
                                        'step' => '1',
                                    ),
                                    'default' => '1.7em',
                                ),
                                'toggle_slug' => 'default_styles',
                                'sub_toggle' => 'price'
                            ),
                            'excerpt' => array(
                                'label' => esc_html__('Excerpt', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% ul.products li.product .woocommerce-product-details__short-description",
                                    'important' => 'plugin_only',
                                ),
                                'font_size' => array(
                                    'default' => '14px',
                                ),
                                'line_height' => array(
                                    'default' => '1em',
                                ),
                                'toggle_slug' => 'default_styles',
                                'sub_toggle' => 'excerpt'
                            ),
                            'cattitle' => array(
                                'label' => esc_html__('Category Title', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% ul.products .woocommerce-loop-category__title",
                                    'important' => 'all',
                                ),
                                'toggle_slug' => 'default_styles',
                                'sub_toggle' => 'category_title'
                            ),
                            'catcount' => array(
                                'label' => esc_html__('Category Count', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% ul.products .woocommerce-loop-category__title .count",
                                    'important' => 'all',
                                ),
                                'toggle_slug' => 'default_styles',
                                'sub_toggle' => 'category_count'
                            ),
                            'pagination_font' => array(
                                'label' => esc_html__('Pagination', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% nav.woocommerce-pagination ul li span, %%order_class%% nav.woocommerce-pagination ul li a, %%order_class%% nav.woocommerce-pagination ul li a",
                                    'important' => 'all',
                                ),
                                'toggle_slug' => 'pagination_styles',
                                'sub_toggle' => 'pagination_item'
                            ),
                            'active_pagination' => array(
                                'label' => esc_html__('Active Pagination', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% nav.woocommerce-pagination ul li span.current, %%order_class%% nav.woocommerce-pagination ul li a:hover, %%order_class%% nav.woocommerce-pagination ul li a:focus",
                                    'important' => 'all',
                                ),
                                'toggle_slug' => 'pagination_styles',
                                'sub_toggle' => 'active_pagination_item'
                            ),
                        ),
                        'background' => array(
                            'settings' => array(
                                'color' => 'alpha',
                            ),
                        ),
                        'button' => array(
                            'add_to_cart_button' => array(
                                'label' => esc_html__('Default Layout - Add To Cart Button', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% .default-layout ul.products li.product .button",
                                    'important' => 'all',
                                ),
                                'box_shadow' => array(
                                    'css' => array(
                                        'main' => "%%order_class%% .default-layout ul.products li.product .button",
                                    ),
                                ),
                            ),
                            'button' => array(
                                'label' => esc_html__('Button - Load More', $this->de_domain_name),
                                'css' => array(
                                    'main' => "{$this->main_css_element} .et_pb_button.dmach-loadmore",
                                    'important' => 'all',
                                ),
                                'box_shadow' => array(
                                    'css' => array(
                                        'main' => "{$this->main_css_element} .et_pb_button.dmach-loadmore",
                                        'important' => 'all',
                                    ),
                                ),
                                'margin_padding' => array(
                                    'css' => array(
                                        'main' => "{$this->main_css_element} .et_pb_button.dmach-loadmore",
                                        'important' => 'all',
                                    ),
                                ),
                            ),
                        ),
                        'box_shadow' => array(
                            'default' => array(),
                            'product' => array(
                                'label' => esc_html__('Default Layout - Product Box Shadow', $this->de_domain_name),
                                'css' => array(
                                    'main' => "%%order_class%% .products .product",
                                ),
                                'option_category' => 'layout',
                                'tab_slug' => 'advanced',
                                'toggle_slug' => 'product',
                            ),
                        ),
                    );

                    $this->custom_css_fields = array(
                        'product' => array(
                            'label' => esc_html__('Default Layout - Product', $this->de_domain_name),
                            'selector' => '%%order_class%% li.product',
                        ),
                        'onsale' => array(
                            'label' => esc_html__('Default Layout - Onsale', $this->de_domain_name),
                            'selector' => '%%order_class%% li.product .onsale',
                        ),
                        'image' => array(
                            'label' => esc_html__('Default Layout - Image', $this->de_domain_name),
                            'selector' => '%%order_class%% .et_shop_image',
                        ),
                        'overlay' => array(
                            'label' => esc_html__('Default Layout - Overlay', $this->de_domain_name),
                            'selector' => '%%order_class%% .et_overlay,  %%order_class%% .et_pb_extra_overlay',
                        ),
                        'title' => array(
                            'label' => esc_html__('Default Layout - Title', $this->de_domain_name),
                            'selector' => '%%order_class%% .woocommerce-loop-product__title',
                        ),
                        'rating' => array(
                            'label' => esc_html__('Default Layout - Rating', $this->de_domain_name),
                            'selector' => '%%order_class%% .star-rating',
                        ),
                        'price' => array(
                            'label' => esc_html__('Default Layout - Price', $this->de_domain_name),
                            'selector' => "body.woocommerce {$this->main_css_element} .et_pb_post .et_pb_post_type ul.products li.product .price, {$this->main_css_element} .et_pb_post .et_pb_post_type ul.products li.product .price",
                        ),
                        'price_old' => array(
                            'label' => esc_html__('Default Layout - Old Price', $this->de_domain_name),
                            'selector' => '%%order_class%% li.product .price del span.amount',
                        ),
                        'excerpt' => array(
                            'label' => esc_html__('Default Layout - Product Excerpt', $this->de_domain_name),
                            'selector' => '%%order_class%% li.product .woocommerce-product-details__short-description',
                        ),
                        'add_to_cart' => array(
                            'label' => esc_html__('Default Layout - Add To Cart Button', $this->de_domain_name),
                            'selector' => '%%order_class%% li.product a.button',
                        ),
                    );

                    $this->help_videos = array(
                        array(
                            'id' => esc_html__('9EtJRhTf9_o', $this->de_domain_name), // CATEGORY VIDEO
                            'name' => esc_html__('BodyCommcerce Product Page Template Guide', $this->de_domain_name),
                        ),
                    );
                }

                function get_fields() {

                    //////////////////////////////
                    $registered_post_types = et_get_registered_post_type_options(false, false);

                    $post_types = array_merge(array(
                        'auto-detect' => esc_html__('Auto Detect', $this->de_domain_name)
                    ), $registered_post_types);

                    $post_types['product_variation'] = esc_html__('Variable Products as Single Products', $this->de_domain_name);
                    $post_display_type = array( 'default' => esc_html__( 'Default', $this->de_domain_name ) );

                    if (defined('DE_DB_WOO_VERSION')) {
                        if (get_bodycommerce_option('wishlist_enable') == "1") {
                            $post_display_type['wishlist'] = esc_html__( 'Wishlist', $this->de_domain_name );
                        }
                    }

                    $fields = array(
                        'post_type_choose' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Post Type', $this->de_domain_name),
                            'type' => 'select',
                            'options' => $post_types,
                            'default' => 'product',
                            'computed_affects' => array(
                                '__products',
                            ),
                            'description' => esc_html__('Choose the post type you want to display', $this->de_domain_name),
                        ),
                        'post_display_type' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Display Type', $this->de_domain_name),
                            'type' => 'select',
                            'options' => $post_display_type,
                            'default' => 'default',
                            'description' => esc_html__('Choose the display type, if you have wishlist enabled for example - it will appear here', $this->de_domain_name),
                        ),
                        'cat_loop_style' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Loop Style', $this->de_domain_name),
                            'type' => 'select',
                            'default' => 'on',
                            'option_category' => 'configuration',
                            'affects' => array(
                                'loop_layout'
                            ),
                            'computed_affects' => array(
                                '__products',
                            ),
                            'options' => array(
                                'on' => esc_html__('Default (WooCommerce Only)', $this->de_domain_name),
                                'off' => esc_html__('Custom Layout', $this->de_domain_name),
                            ),
                            'description' => esc_html__('Choose the loop style you want, default will result in the normal WooCommerce style but if you want to create your own one using a loop layout created in the Divi Library, choose custom.', $this->de_domain_name),
                        ),
                        'loop_layout' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Loop Layout', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'configuration',
                            'depends_show_if' => 'off',
                            'default' => 'none',
                            'options' => $this->options,
                            'description' => esc_html__('Choose the layout you have made for each product in the loop.', $this->de_domain_name),
                        ),

                        'is_main_loop' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Is Main Loop?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'default' => 'on',
                            'description' => esc_html__('Choose if you want to make this loop as main loop on the page - the filter will affect this loop.', $this->de_domain_name),
                            'affects' => array(
                                'show_sorting_menu',
                                'show_results_count',
                                'enable_loadmore',
                            ),
                        ),
                        'show_sorting_menu' => array(
                            'label' => esc_html__('Show Default OrderBy Menu', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'on',
                            'description' => esc_html__('Show/Hide the sorting dropdown menu in the frontend.', $this->de_domain_name),
                            'toggle_slug' => 'element_options',
                            'depends_show_if' => 'on',
                        ),
                        'show_results_count' => array(
                            'label' => esc_html__('Show Results Count', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'on',
                            'description' => esc_html__('Show/Hide products count.', $this->de_domain_name),
                            'toggle_slug' => 'element_options',
                            'depends_show_if' => 'on',
                            'affects'       => array(
                                'results_count_position'
                            )
                        ),
                        'results_count_position' => array(
                            'label' => esc_html__('Results Count Position', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'configuration',
                            'options' => array(
                                'top' => esc_html__('Top', $this->de_domain_name),
                                'bottom' => esc_html__('Bottom', $this->de_domain_name),
                            ),
                            'default' => 'top',
                            'description' => esc_html__('Select the position of the products count related with Product Loop.', $this->de_domain_name),
                            'toggle_slug' => 'element_options',
                            'depends_show_if' => 'on',
                        ),
                        'enable_loadmore' => array(
                            'label' => esc_html__('Choose how to display load more posts', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Load More', $this->de_domain_name),
                                'pagination' => esc_html__('Pagination', $this->de_domain_name),
                                'infinite' => esc_html__('Infinite Scroll', $this->de_domain_name),
                                'off' => esc_html__('None', $this->de_domain_name),
                            ),
                            'default' => 'pagination',
                            'toggle_slug' => 'element_options',
                            'depends_show_if' => 'on',
                            'affects' => array(
                                'loadmore_text',
                                'loadmore_align',
                                'scrollto'
                            ),
                        ),

                        'loadmore_text' => array(
                            'toggle_slug' => 'element_options',
                            'option_category' => 'configuration',
                            'label' => esc_html__('Load More Text', $this->de_domain_name),
                            'type' => 'text',
                            'depends_show_if' => 'on',
                            'default' => 'Load More',
                            'description' => esc_html__('Add the text for the load more button', $this->de_domain_name),
                        ),
                        'loadmore_text_loading' => array(
                            'toggle_slug' => 'element_options',
                            'option_category' => 'configuration',
                            'label' => esc_html__('Load More Loading Text', $this->de_domain_name),
                            'type' => 'text',
                            'show_if' => array(
                                'enable_loadmore' => array(
                                    'on'
                                )
                            ),
                            'default' => 'Loading...',
                            'description' => esc_html__('Add the text for the load more button when it is loading', $this->de_domain_name),
                        ),
                        'loadmore_align' => array(
                            'toggle_slug' => 'element_options',
                            'option_category' => 'configuration',
                            'label' => esc_html__('Load More Button Alignment', $this->de_domain_name),
                            'type' => 'select',
                            'options'   => array(
                                'left'      => esc_html__( 'Left', $this->de_domain_name ),
                                'center'    => esc_html__( 'Center', $this->de_domain_name ),
                                'right'     => esc_html__( 'Right', $this->de_domain_name )
                            ),
                            'depends_show_if' => 'on',
                            'default' => 'center',
                            'description' => esc_html__('Set the position of the Load More Button', $this->de_domain_name),
                        ),
                        'scrollto' => array(
                            'label' => esc_html__('Scroll to Top After Ajax Update', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'on',
                            'show_if' => array(
                                'enable_loadmore' => array(
                                    'on',
                                    'pagination',
                                    'infinite'
                                )
                            ),
                            'description' => esc_html__('If you want to scroll to a section after the update of the ajax filter, enable this.', $this->de_domain_name),
                            'toggle_slug' => 'element_options',
                            'affects' => array(
                                'scrollto_fine_tune'
                            ),
                        ),
                        'scrollto_fine_tune' => array(
                            'label' => esc_html__('Fine Tune the position', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '0px',
                            'toggle_slug' => 'element_options',
                            'option_category' => 'configuration',
                            'show_if' => array(
                                'scrollto' => 'on'
                            ),
                            'range_settings' => array(
                                'min' => '-500',
                                'max' => '500',
                                'step' => '1',
                            ),
                        ),

                        'disable_products_has_cat' => array(
                            'label' => esc_html__('Disable products when category has child categories?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                            'description' => esc_html__('Only works on categories. If you are on a category page and the category has sub-categories, you can disable the products to be shown with this setting.', $this->de_domain_name),
                        ),

                        'exclude_cats' => array(
                            'label' => esc_html__('Exclude Categories (comma-seperated)', $this->de_domain_name),
                            'type' => 'text',
                            'option_category' => 'configuration',
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'include_terms',
                            'description' => esc_html__('Add a list of category slugs that you want to exclude from show. (comma-seperated)', $this->de_domain_name),
                        ),

                        'exclude_products' => array(
                            'label' => esc_html__('Exclude Products', $this->de_domain_name),
                            'type' => 'text',
                            'option_category' => 'configuration',
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'include_terms',
                            'description' => esc_html__('Add a list of product ids that you want to exclude from show. (comma-seperated)', $this->de_domain_name),
                        ),

                        'onload_cats' => array(
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'onload_terms',
                            /*'sub_toggle'        => 'onload_terms',*/
                            'option_category' => 'configuration',
                            'label' => esc_html__('Include Categories on load ONLY (Slug comma-seperated)', $this->de_domain_name),
                            'type' => 'text',
                            'description' => esc_html__('Add a list of categories you want to show ONLY on load - not included in the ajax filters. (comma-seperated)', $this->de_domain_name),
                        ),

                        'onload_tags' => array(
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'onload_terms',
                            /*'sub_toggle'        => 'onload_terms',*/
                            'option_category' => 'configuration',
                            'label' => esc_html__('Include Tags on load ONLY (Slug comma-seperated)', $this->de_domain_name),
                            'type' => 'text',
                            'description' => esc_html__('Add a list of tags you want to show ONLY on load - not included in the ajax filters. (comma-seperated)', $this->de_domain_name),
                        ),

                        'onload_tax_choose' => array(
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'onload_terms',
                            /*'sub_toggle'        => 'onload_terms',*/
                            'label' => esc_html__('Include Custom Taxonomy on load ONLY', $this->de_domain_name),
                            'type' => 'select',
                            'options' => get_taxonomies(array(
                                '_builtin' => false
                            )),
                            'option_category' => 'configuration',
                            'description' => esc_html__('Choose the custom taxonomy that you want to include on load only', $this->de_domain_name),
                        ),

                        'onload_taxomony' => array(
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'onload_terms',
                            /*'sub_toggle'      => 'onload_terms',*/
                            'option_category' => 'configuration',
                            'label' => esc_html__('Include Custom Taxonomy Values on load ONLY (comma-seperated)', $this->de_domain_name),
                            'type' => 'text',
                            'description' => esc_html__('Add a list of values that you want to show - make sure to specify the custom taxonomy above, it will then show the posts that have the values here from that custom taxonomy. (comma-seperated)', $this->de_domain_name),
                        ),

                        'filter_update_animation' => array(
                            'toggle_slug' => 'main_content',
                            'label' => esc_html__('Filter/Infinite Scroll Icon Animation', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'load-1' => esc_html__('Three Lines Vertical', $this->de_domain_name),
                                'load-2' => esc_html__('Three Lines Horizontal', $this->de_domain_name),
                                'load-3' => esc_html__('Three Dots Bouncing', $this->de_domain_name),
                                'load-4' => esc_html__('Donut', $this->de_domain_name),
                                'load-5' => esc_html__('Donut Multiple', $this->de_domain_name),
                                'load-6' => esc_html__('Ripple', $this->de_domain_name),
                            ),
                            'option_category' => 'configuration',
                            'default' => 'load-6',
                            'description' => esc_html__('Choose the animation style for when loading the posts', $this->de_domain_name),
                        ),
                        'animation_color' => array(
                            'label' => esc_html__('Ajax Filter Animation Icon Color', $this->de_domain_name),
                            'description' => esc_html__('Define the color of the animation you choose above.', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'option_category' => 'configuration',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'loading_animation'
                        ),
                        'loading_bg_color' => array(
                            'label' => esc_html__('Ajax Filter Background Color', $this->de_domain_name),
                            'description' => esc_html__('Define the color of the background when it is loading.', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'option_category' => 'configuration',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'loading_animation',
                        ),
                        // 'product_type' => array(
                        //     'label' => esc_html__('Type', $this->de_domain_name),
                        //     'type' => 'select',
                        //     'option_category' => 'configuration',
                        //     'options' => array(
                        //         'original' => esc_html__('Default (ALL)', $this->de_domain_name),
                        //              'recent'  => esc_html__( 'Recent Products', $this->de_domain_name ),
                        //              'featured' => esc_html__( 'Featured Products', $this->de_domain_name ),
                        //              'sale' => esc_html__( 'Sale Products', $this->de_domain_name ),
                        //              'best_selling' => esc_html__( 'Best Selling Products', $this->de_domain_name ),
                        //              'top_rated' => esc_html__( 'Top Rated Products', $this->de_domain_name ),
                        //     ),
                        //     'default' => 'original',
                        //     'toggle_slug'       => 'main_content',
                        //     'description' => esc_html__('Choose which type of products you would like to display', $this->de_domain_name),
                        // ),
                        
                        'posts_number' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                            'label' => esc_html__('Posts Number', $this->de_domain_name),
                            'type' => 'text',
                            'default' => 16,
                            'description' => esc_html__('Choose how many posts you would like to display per page. Divi sometimes overrides this. To set it go to Divi > Theme Options and change the value "Number of Products displayed on WooCommerce archive pages"', $this->de_domain_name),
                        ),
                        'no_results_layout' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                            'label' => esc_html__('No Results Layout', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'layout',
                            'default' => 'none',
                            'options' => $this->options,
                            'description' => esc_html__('Choose the layout you want to appear when there are no products.', $this->de_domain_name),
                            'show_if' => array(
                                'cat_loop_style' => 'off',
                            )
                        ),
                        'hide_non_purchasable' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                            'label' => esc_html__('Hide non purchasable products?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'off' => esc_html__('No', $this->de_domain_name),
                                'on' => esc_html__('Yes', $this->de_domain_name),
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'off',
                                'post_type_choose' => ['product',
                                'product_variation']
                            ),
                            'default' => 'off',
                            'description' => esc_html__('If you want to hide non purchasable products, enable this.', $this->de_domain_name),
                        ),
                        'link_whole_gird' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                            'label' => esc_html__('Link each layout to post/product', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'off' => esc_html__('No', $this->de_domain_name),
                                'on' => esc_html__('Yes', $this->de_domain_name),
                            ),
                            'affects' => array(
                                'link_whole_gird_new_tab',
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'off'
                            ),
                            'description' => esc_html__('Enable this if you want to link each loop layout to the product. For example if you want the whole "grid card" to link to the product page. NB: You need to have no other links on the loop layout so do not link the image or the title to the product page.', $this->de_domain_name),
                        ),
                        'link_whole_gird_new_tab' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                            'label' => esc_html__('Open in New Tab?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'off' => esc_html__('No', $this->de_domain_name),
                                'on' => esc_html__('Yes', $this->de_domain_name),
                            ),
                            'depends_show_if' => 'on',
                            'description' => esc_html__('Enable this if you want it to open in a new tab.', $this->de_domain_name),
                        ),
                        'equal_height' => array(
                            'label' => esc_html__('Equal Height Grid Cards', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'affects' => array(
                                'equal_height_mob',
                                'align_last_bottom'
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'off',
                                'fullwidth' => ['off',
                                'masonry']
                            ),
                            'description' => esc_html__('Enable this if you have the grid layout and want all your cards to be the same height.', $this->de_domain_name),
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                        ),

                        'equal_height_mob' => array(
                            'label' => esc_html__('Equal Height  on mobile?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'off',
                            'depends_show_if' => 'on',
                            'description' => esc_html__('We will disable equal height on mobile. If you want it to stay, enable this..', $this->de_domain_name),
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                        ),
                        'align_last_bottom' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                            'label' => esc_html__('Align last module at the bottom', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'depends_show_if' => 'on',
                            'options' => array(
                                'off' => esc_html__('No', $this->de_domain_name),
                                'on' => esc_html__('Yes', $this->de_domain_name),
                            ),
                            'description' => esc_html__('Enable this to align the last module (probably the add to cart) at the bottom. Works well when using the equal height.', $this->de_domain_name),
                        ),
                        'masonry_ajax_buffer' => array(
                            'label' => esc_html__('Masonry Ajax Filter Buffer', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '500',
                            'default_unit' => 'ms',
                            'default_on_front' => '',
                            'range_settings' => array(
                                'min' => '0',
                                'max' => '5000',
                                'step' => '1',
                            ),
                            'show_if' => ['fullwidth' => ['masonry'],
                            ],
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'general',
                            'option_category' => 'layout',
                            'description' => esc_html__('When using masonry, after ajax we need to re-sort the posts and create the masonry. Depending on your site you might need to increase this to run our code after the posts are loaded.', $this->de_domain_name),
                        ),
                        'fullwidth' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'grid',
                            'label' => esc_html__('Layout Style', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'layout',
                            'options' => array(
                                'off' => esc_html__('Grid', $this->de_domain_name),
                                'list' => esc_html__('List', $this->de_domain_name),
                                'masonry' => esc_html__('Masonry', $this->de_domain_name),
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'off'
                            ),
                            'default' => 'off',
                            'description' => esc_html__('Choose if you want it displayed as a list or a grid layout', $this->de_domain_name),
                        ),
                        'columns' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'grid',
                            'label' => esc_html__('Grid Columns', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'layout',
                            'default' => '3',
                            'options' => array(
                                '2' => esc_html__('Two', $this->de_domain_name),
                                '3' => esc_html__('Three', $this->de_domain_name),
                                '4' => esc_html__('Four', $this->de_domain_name),
                                '5' => esc_html__('Five', $this->de_domain_name),
                                '6' => esc_html__('Six', $this->de_domain_name),
                            ),
                            'show_if' => ['fullwidth' => ['off','masonry'],'cat_loop_style' => 'off'],
                            'description' => esc_html__('How many columns do you want to see', $this->de_domain_name),
                        ),
                        'columns_tablet' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'grid',
                            'label' => esc_html__('Tablet Grid Columns', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'layout',
                            'default' => '2',
                            'options' => array(
                                '1' => esc_html__('One', $this->de_domain_name),
                                '2' => esc_html__('Two', $this->de_domain_name),
                                '3' => esc_html__('Three', $this->de_domain_name),
                                '4' => esc_html__('Four', $this->de_domain_name),
                            ),
                            'show_if' => ['fullwidth' => ['off',
                            'masonry'],
                            'cat_loop_style' => 'off'],
                            'description' => esc_html__('How many columns do you want to see on tablet', $this->de_domain_name),
                        ),
                        'columns_mobile' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'grid',
                            'label' => esc_html__('Mobile Grid Columns', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'layout',
                            'default' => '1',
                            'options' => array(
                                '1' => esc_html__('One', $this->de_domain_name),
                                '2' => esc_html__('Two', $this->de_domain_name),
                            ),
                            'show_if' => ['fullwidth' => ['off','masonry'],'cat_loop_style' => 'off'],
                            'description' => esc_html__('How many columns do you want to see on mobile', $this->de_domain_name),
                        ),


                        'custom_gutter_width' => array(
                            'label'             => esc_html__( 'Custom Gutter Gaps', $this->de_domain_name ),
                            'type'              => 'yes_no_button',
                            'option_category'   => 'configuration',
                            'options'           => array(
                              'on'  => esc_html__( 'Yes', $this->de_domain_name ),
                              'off' => esc_html__( 'No', $this->de_domain_name ),
                            ),
                            'description'       => esc_html__( 'Enable this if you want custom gutter gaps for row and columns.', $this->de_domain_name ),
                            'affects'         => array(
                              'gutter_row_gap',
                              'gutter_row_column',
                            ),
                            'show_if' => ['fullwidth' => ['off','masonry'],'cat_loop_style' => 'off'],
                            'default' => 'off',
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'grid',
                          ),
        
        
                          'gutter_row_gap' => array(
                            'label'           => esc_html__('Gutter Row Gap', $this->de_domain_name),
                            'description'     => esc_html__('Set the distance between each grid item vertically.', $this->de_domain_name),
                            'type'            => 'range',
                            'option_category' => 'basic_option',
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'grid',
                            'validate_unit'   => true,
                            'depends_show_if' => 'on',
                            'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                            'default'         => '25px',
                            'default_unit'    => 'px',
                            'default_on_front' => '',
                            'allow_empty'     => false,
                            'range_settings'  => array(
                              'min'  => '0',
                              'max'  => '100',
                              'step' => '1',
                            ),
                          ),
                          'gutter_row_column' => array(
                            'label'           => esc_html__('Gutter Column Gap', $this->de_domain_name),
                            'description'     => esc_html__('Set the distance between each grid item horizontally.', $this->de_domain_name),
                            'type'            => 'range',
                            'option_category' => 'basic_option',
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'grid',
                            'validate_unit'   => true,
                            'depends_show_if' => 'on',
                            'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                            'default'         => '25px',
                            'default_unit'    => 'px',
                            'default_on_front' => '',
                            'allow_empty'     => false,
                            'range_settings'  => array(
                              'min'  => '0',
                              'max'  => '100',
                              'step' => '1',
                            ),
                          ),

                        // 'sort_order' => array(
                        // 'label'             => esc_html__( 'Product Sort Order', $this->de_domain_name ),
                        // 'type'              => 'select',
                        // 'options'           => array(
                        // "default"  => esc_html__( 'Default', $this->de_domain_name ),
                        // "name"  => esc_html__( 'Name', $this->de_domain_name ),
                        // "popularity" => esc_html__( 'Popularity', $this->de_domain_name ),
                        // "rating" => esc_html__( 'Averagez Rating', $this->de_domain_name ),
                        // "recent" => esc_html__( 'Most Recent', $this->de_domain_name ),
                        // "price_asc" => esc_html__( 'Price Asc', $this->de_domain_name ),
                        // "price_desc" => esc_html__( 'Price Desc', $this->de_domain_name ),
                        // "random" => esc_html__( 'Random', $this->de_domain_name ),
                        // ),
                        // 'description'        => esc_html__( 'Select the sort order of the loop', $this->de_domain_name ),
                        // 'toggle_slug'       => 'main_content',
                        // ),
                        // 'et_shortcode' => array(
                        // 'toggle_slug'       => 'custom_content',
                        // 'option_category'   => 'layout',
                        // 'label'             => esc_html__( 'ET Shortcode for loop layout', $this->de_domain_name ),
                        // 'type'              => 'select',
                        // 'options'           => array(
                        // 'et_pb_row'  => esc_html__( 'et_pb_row', $this->de_domain_name ),
                        // 'et_pb_section' => esc_html__( 'et_pb_section', $this->de_domain_name ),
                        // ),
                        // 'default' => 'et_pb_row',
                        // 'description'        => esc_html__( 'Choose what you want the loop layout shortcode to be. By default the row will be fine but if you have this module inside a speciality section it can cause issues with the html structure - so change it to be the section to see.', $this->de_domain_name ),
                        // ),
                        'custom_loop' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Define Custom Terms?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'off' => esc_html__('No', $this->de_domain_name),
                                'on' => esc_html__('Yes', $this->de_domain_name),
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'off'
                            ),
                            'affects' => array(
                                'post_type',
                                'include_tags',
                                'include_cats',
                                'featured_only',
                                'popular_only',
                                'on_sale_only',
                                'outofstock_only',
                                'new_only',
                                'sort_order',
                                'order_asc_desc'
                            ),
                            'description' => esc_html__('Enable this to create your own query, you can set the post number and to include products with specific tags only.', $this->de_domain_name),
                        ),
                        'include_cats' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Include Categories', $this->de_domain_name),
                            'type' => 'text',
                            'depends_show_if' => 'on',
                            'description' => esc_html__('Add a list of categories that you ONLY want to show. This will remove all products that dont have these. (comma-seperated)', $this->de_domain_name),
                        ),
                        'include_tags' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Include Tags', $this->de_domain_name),
                            'type' => 'text',
                            'depends_show_if' => 'on',
                            'description' => esc_html__('Add a list of tags that you ONLY want to show. This will remove all products that dont have these tags. (comma-seperated)', $this->de_domain_name),
                        ),
                        'custom_tax_choose' => array(
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Choose Your Taxonomy', $this->de_domain_name),
                            'type' => 'select',
                            'options' => get_taxonomies(array(
                                '_builtin' => false
                            )),
                            'option_category' => 'configuration',
                            'default' => 'post',
                            'description' => esc_html__('Choose the custom taxonomy that you have made and want to filter', $this->de_domain_name),
                        ),
                        'include_taxomony' => array(
                            'toggle_slug'       => 'loop_options',
                            'sub_toggle'    => 'include_terms',
                            'option_category' => 'configuration',
                            'label' => esc_html__('Include Custom Taxonomy (comma-seperated)', $this->de_domain_name),
                            'type' => 'text',
                            'description' => esc_html__('Add a list of values that you want to show - make sure to specify the custom taxonomy above, it will then show the posts that have the values here from that custom taxonomy. (comma-seperated)', $this->de_domain_name),
                        ),
                        'featured_only' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Display featured products?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'depends_show_if' => 'on',
                        ),
                        'popular_only' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Display Most Popular products?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'depends_show_if' => 'on',
                        ),
                        'on_sale_only' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Display On Sale products?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'depends_show_if' => 'on',
                        ),
                        'outofstock_only' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Out of Stock products only?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'depends_show_if' => 'on',
                        ),
                        'new_only' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('New products only?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'depends_show_if' => 'on',
                            'affects' => array(
                                'new_time'
                            ),
                        ),
                        'new_time' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Number of days', $this->de_domain_name),
                            'type' => 'text',
                            'depends_show_if' => 'on',
                            'description' => esc_html__('Define the number of days you want to show the products', $this->de_domain_name),
                        ),
                        'show_hidden_prod' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Show Hidden Products?', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', 'et_builder'),
                                'off' => esc_html__('No', 'et_builder'),
                            ),
                            'depends_show_if' => 'on',
                            'default' => 'off',
                            'show_if' => array(
                                'cat_loop_style' => 'off',
                                'post_type_choose' => ['product',
                                'product_variation']
                            )
                        ),
                        'sort_order' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('What do you want to sort your products by?', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'date' => sprintf(esc_html__('Date', $this->de_domain_name)),
                                'title' => esc_html__('Title', $this->de_domain_name),
                                'relevance' => esc_html__('Relevance', $this->de_domain_name),
                                'popularity' => esc_html__('Popularity', $this->de_domain_name),
                                'ID' => esc_html__('ID', $this->de_domain_name),
                                'rand' => esc_html__('Random', $this->de_domain_name),
                                'menu_order' => esc_html__('Menu Order', $this->de_domain_name),
                                'name' => esc_html__('Name', $this->de_domain_name),
                                'modified' => esc_html__('Modified', $this->de_domain_name),
                                'product_price' => esc_html__('Price', $this->de_domain_name),
                                'stock_status' => esc_html__('Stock Status', $this->de_domain_name),
                            ),
                            'depends_show_if' => 'on',
                            'default' => 'date',
                            'description' => esc_html__('Choose what you want to sort the product by.', $this->de_domain_name),
                        ),
                        'order_asc_desc' => array(
                            'toggle_slug'       => 'custom_content',
                            'sub_toggle'    => 'include_terms',
                            'label' => esc_html__('Sort Order', $this->de_domain_name),
                            'type' => 'select',
                            'options' => array(
                                'ASC' => esc_html__('Ascending', $this->de_domain_name),
                                'DESC' => sprintf(esc_html__('Descending', $this->de_domain_name)),
                            ),
                            'depends_show_if' => 'on',
                            'default' => 'ASC',
                            'description' => esc_html__('Choose the sort order of the products.', $this->de_domain_name),
                        ),

                        // DEFAULT
                        'display_type' => array(
                            'label' => esc_html__('Display Type', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'layout',
                            'options' => array(
                                'grid' => esc_html__('Grid', $this->de_domain_name),
                                'list_view' => esc_html__('Classic Blog', $this->de_domain_name),
                            ),
                            'default' => 'grid',
                            'affects' => array(
                                'columns_number',
                            ),
                            'toggle_slug' => 'default_content',
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'columns_number' => array(
                            'label' => esc_html__('Columns Number', $this->de_domain_name),
                            'type' => 'select',
                            'option_category' => 'layout',
                            'options' => array(
                                '0' => esc_html__('-- Default --', $this->de_domain_name),
                                '6' => sprintf(esc_html__('%1$s Columns', $this->de_domain_name), esc_html('6')),
                                '5' => sprintf(esc_html__('%1$s Columns', $this->de_domain_name), esc_html('5')),
                                '4' => sprintf(esc_html__('%1$s Columns', $this->de_domain_name), esc_html('4')),
                                '3' => sprintf(esc_html__('%1$s Columns', $this->de_domain_name), esc_html('3')),
                                '2' => sprintf(esc_html__('%1$s Columns', $this->de_domain_name), esc_html('2')),
                                '1' => esc_html__('1 Column', $this->de_domain_name),
                            ),
                            'computed_affects' => array(
                                '__products',
                            ),
                            'depends_show_if' => 'grid',
                            'default' => '3',
                            'description' => esc_html__('Choose how many columns to display. Default is 3.', $this->de_domain_name),
                            'toggle_slug' => 'default_content',
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'show_rating' => array(
                            'label' => esc_html__('Show Rating', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'on',
                            'toggle_slug' => 'default_content',
                            'affects' => array(
                                'stars_color',
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'show_price' => array(
                            'label' => esc_html__('Show Price', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'on',
                            'toggle_slug' => 'default_content',
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'show_excerpt' => array(
                            'label' => esc_html__('Show Excerpt', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'off' => esc_html__('No', $this->de_domain_name),
                                'on' => esc_html__('Yes', $this->de_domain_name),
                            ),
                            'toggle_slug' => 'default_content',
                            'computed_affects' => array(
                                '__products',
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'show_add_to_cart' => array(
                            'label' => esc_html__('Show Add To Cart Button', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => array(
                                'off' => esc_html__('No', $this->de_domain_name),
                                'on' => esc_html__('Yes', $this->de_domain_name),
                            ),
                            'toggle_slug' => 'default_content',
                            'computed_affects' => array(
                                '__products',
                            ),
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'sale_badge_color' => array(
                            'label' => esc_html__('Sale Badge Color', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'toggle_slug' => 'default_content',
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'stars_color' => array(
                            'label' => esc_html__('Rating Stars Color', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'toggle_slug' => 'default_content',
                        ),
                        'use_overlay' => array(
                            'label' => esc_html__('Use Overlay', $this->de_domain_name),
                            'type' => 'yes_no_button',
                            'options' => array(
                                'on' => esc_html__('Yes', $this->de_domain_name),
                                'off' => esc_html__('No', $this->de_domain_name),
                            ),
                            'default' => 'on',
                            'affects' => array(
                                'icon_hover_color',
                                'hover_overlay_color',
                                'hover_icon',
                            ),
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'overlay',
                        ),
                        'icon_hover_color' => array(
                            'label' => esc_html__('Icon Color', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'depends_show_if' => 'on',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'overlay',
                        ),
                        'hover_overlay_color' => array(
                            'label' => esc_html__('Overlay Color', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'depends_show_if' => 'on',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'overlay',
                        ),
                        'hover_icon' => array(
                            'label' => esc_html__('Icon Picker', $this->de_domain_name),
                            'type' => 'select_icon',
                            'option_category' => 'configuration',
                            'class' => array(
                                'et-pb-font-icon'
                            ),
                            'default' => 'P',
                            'depends_show_if' => 'on',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'overlay',
                        ),
                        'product_background' => array(
                            'label' => esc_html__('Product Background', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'toggle_slug' => 'default_content',
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'product_padding' => array(
                            'label' => esc_html__('Product Padding', $this->de_domain_name),
                            'type' => 'range',
                            'default' => '0px',
                            'toggle_slug' => 'default_content',
                            'show_if' => array(
                                'cat_loop_style' => 'on'
                            )
                        ),
                        'pagination_item_background' => array(
                            'label' => esc_html__('Pagination Background', $this->de_domain_name),
                            'description' => esc_html__('Define the background color of the pagination item.', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'option_category' => 'configuration',
                            'default' => '#fff',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'pagination_styles',
                            'sub_toggle' => 'pagination_item'
                        ),
                        'pagination_item_background_active' => array(
                            'label' => esc_html__('Active Pagination Background', $this->de_domain_name),
                            'description' => esc_html__('Define the background color of the active pagination item.', $this->de_domain_name),
                            'type' => 'color-alpha',
                            'custom_color' => true,
                            'default' => '#ebe9eb',
                            'option_category' => 'configuration',
                            'tab_slug' => 'advanced',
                            'toggle_slug' => 'pagination_styles',
                            'sub_toggle' => 'active_pagination_item'
                        ),
                        // 'pagination_item_border' => array(
                        //     'label'             => esc_html__( 'Pagination Border', 'et_builder' ),
                        //     'description'       => esc_html__( 'Define the border color of the pagination item.', 'et_builder' ),
                        //     'type'              => 'color-alpha',
                        //     'custom_color'      => true,
                        //     'option_category'   => 'configuration',
                        //     'tab_slug'          => 'advanced',
                        //     'toggle_slug'       => 'pagination_styles',
                        //     'sub_toggle'        => 'pagination_item'
                        // ),
                        // 'pagination_item_border_active' => array(
                        //     'label'             => esc_html__( 'Active Pagination Border', 'et_builder' ),
                        //     'description'       => esc_html__( 'Define the border color of the active pagination item.', 'et_builder' ),
                        //     'type'              => 'color-alpha',
                        //     'custom_color'      => true,
                        //     'option_category'   => 'configuration',
                        //     'tab_slug'          => 'advanced',
                        //     'toggle_slug'       => 'pagination_styles',
                        //     'sub_toggle'        => 'active_pagination_item'
                        // ),
                        '__products' => array(
                            'type' => 'computed',
                            'computed_callback' => array(
                                'db_filter_loop_code',
                                'get_products'
                            ),
                            'computed_depends_on' => array(
                                'columns_number',
                                'show_add_to_cart',
                                'show_excerpt',
                                'loop_layout',
                                'cat_loop_style',
                                'fullwidth',
                                'include_tags',
                                'include_cats',
                                'posts_number',
                                'custom_loop',
                                'sort_order',
                                'order_asc_desc',
                                'post_type_choose',
                                'columns',
                                'columns_tablet',
                                'columns_mobile',
                                'show_sorting_menu',
                                'show_results_count',
                                'show_hidden_prod',
                                'enable_loadmore'
                            ),
                        )
                    );

                    return $fields;
                }

                // GET COMPUTED PRODUCTS
                public static function get_products($args = array(), $conditional_tags = array(), $current_page = array()) {

                    if (!is_admin()) {
                        return;
                    }

                    $post_type_choose = $args['post_type_choose'];
                    $enable_loadmore = $args['enable_loadmore'];

                    ob_start();

                    if (isset($args['cat_loop_style']) && $args['cat_loop_style'] == 'on') {

                        if ($post_type_choose !== "product") {

                            echo '<div class="no-html-output" style="background-color:#1d0d6f;color:#fff;padding:40px 60px;clear: both;"><p>Default layout only works with products from WooCommerce at the moment. <br>
                            To fix
                            <ol>
                            <li>Choose "Custom Layout" in the setting -> Loop Style</li>
                            <li>Create a custom loop layout in the Divi Library</li>
                            <li>Assign this layout created in step 2 in the setting -> Loop Layout</li>
                            </ol>
                            </p>
                            </div>';

                        }
                        else {
                            global $post, $columns;
                            $term = false;
                            $shortcode_options = '';

                            if (isset($_REQUEST['et_post_id'])) {
                                $post_id = absint($_REQUEST['et_post_id']);
                            }
                            elseif (isset($_REQUEST['current_page']['id'])) {
                                $post_id = absint($_REQUEST['current_page']['id']);
                            }
                            else {
                                $post_id = false;
                            }

                            $post = get_post($post_id); // phpcs:ignore
                            $columns = isset($args['columns_number']) && absint($args['columns_number']) > 0 ? absint($args['columns_number']) : 3;

                            // columns
                            add_filter('loop_shop_columns', function ($c) {
                                global $columns;
                                return $columns;
                            }
                            , 9999);

                            // get the current posts per page
                            $limit = 9;

                            // add to cart
                            if (isset($args['show_add_to_cart']) && $args['show_add_to_cart'] == 'on') {
                                add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9);
                            }

                            if (isset($args['show_excerpt']) && $args['show_excerpt'] == 'on') {
                                add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8);
                            }

                            add_action('woocommerce_shop_loop_item_title', array(
                                'db_filter_loop_code',
                                'product_details_wrapper_start'
                            ), 0);
                            add_action('woocommerce_shop_loop_subcategory_title', array(
                                'db_filter_loop_code',
                                'product_details_wrapper_start'
                            ), 0);
                            add_action('woocommerce_after_shop_loop_item', array(
                                'db_filter_loop_code',
                                'product_details_wrapper_end'
                            ), 10);
                            add_action('woocommerce_after_subcategory', array(
                                'db_filter_loop_code',
                                'product_details_wrapper_end'
                            ), 10);
                            add_action('woocommerce_before_shop_loop_item_title', array(
                                'db_filter_loop_code',
                                'product_image_wrapper_start'
                            ), 0);
                            add_action('woocommerce_before_subcategory_title', array(
                                'db_filter_loop_code',
                                'product_image_wrapper_start'
                            ), 0);
                            add_action('woocommerce_before_shop_loop_item_title', array(
                                'db_filter_loop_code',
                                'product_image_wrapper_end'
                            ), 20);
                            add_action('woocommerce_before_subcategory_title', array(
                                'db_filter_loop_code',
                                'product_image_wrapper_end'
                            ), 20);

                            remove_all_actions('woocommerce_after_shop_loop');
                            $shortcode = "[products paginate='true' limit='{$limit}' {$shortcode_options}]";

                            if ($enable_loadmore == 'off') {
                                remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                            }

                            echo do_shortcode($shortcode);
                        }

                    }
                    else if (isset($args['cat_loop_style']) && $args['cat_loop_style'] == 'off') {

                        $loop_layout = $args['loop_layout'];
                        $columns = $args['columns'];
                        $columns_tablet = $args['columns_tablet'];
                        $columns_mobile = $args['columns_mobile'];
                        $include_cats = $args['include_cats'];
                        $include_tags = $args['include_tags'];
                        $sort_order = $args['sort_order'];
                        $order_asc_desc = $args['order_asc_desc'];
                        $show_sorting_menu = $args['show_sorting_menu'];
                        $show_results_count = $args['show_results_count'];
                        $fullwidth = $args['fullwidth'];
                        $show_hidden_prod = $args['show_hidden_prod'];
                        $enable_loadmore = $args['enable_loadmore'];
                        $posts_number = $args['posts_number'];
                        $featured_only = isset($args['featured_only']) ? $args['featured_only'] : 'off';
                        $popular_only = isset($args['popular_only']) ? $args['popular_only'] : 'off';
                        $on_sale_only = isset($args['on_sale_only']) ? $args['on_sale_only'] : 'off';
                        $new_only = isset($args['new_only']) ? $args['new_only'] : 'off';
                        $cols = $args['columns'];

                        $get_cpt_args = array(
                            'post_type' => $post_type_choose,
                            'post_status' => 'publish',
                            'posts_per_page' => (int)$posts_number,
                            'orderby' => $sort_order,
                            'order' => $order_asc_desc,
                        );

                        if ($include_cats != "") {
                            if ($post_type_choose == "post") {
                                $get_cpt_args['category_name'] = $include_cats;
                            }
                            else if ($post_type_choose == 'product') {
                                $get_cpt_args['product_cat'] = $include_cats;
                            }
                            else {

                                if (!empty($cpt_taxonomies) && in_array('category', $cpt_taxonomies)) {
                                    $get_cpt_args['category_name'] = $include_cats;
                                }
                                else {
                                    $ending = "_category";
                                    $cat_key = $post_type_choose . $ending;
                                    if ($cat_key == "product_category") {
                                        $cat_key = "product_cat";
                                    }
                                    else {
                                        $cat_key = $cat_key;
                                    }

                                    $get_cpt_args['tax_query'][] = array(
                                        'taxonomy' => $cat_key,
                                        'field' => 'slug',
                                        'terms' => $include_cats,
                                        'operator' => 'IN'
                                    );
                                }
                            }
                        }

                        if ($include_tags != "") {
                            $get_cpt_args['product_tag'] = $include_tags;
                            if ($post_type_choose == "post") {
                                $get_cpt_args['tag'] = $include_tags;
                            }
                            else {
                                $ending = "_tag";
                                $cat_key = $post_type_choose . $ending;

                                $get_cpt_args['tax_query'][] = array(
                                    'taxonomy' => $cat_key,
                                    'field' => 'slug',
                                    'terms' => $include_tags,
                                    'operator' => 'IN'
                                );
                            }
                        }

                        if ($featured_only == "on") {
                            $tax_query[] = array(
                                'taxonomy' => 'product_visibility',
                                'field' => 'name',
                                'terms' => 'featured',
                                'operator' => 'IN',
                            );

                            $get_cpt_args['tax_query'] = $tax_query;
                        }

                        // POPULAR
                        if ($popular_only == "on") {
                            $customclass = "popular-products";
                            $get_cpt_args['meta_key'] = 'total_sales';
                            $get_cpt_args['orderby'] = 'meta_value_num';
                        }

                        // ON SALE
                        if ($on_sale_only == "on") {
                            $customclass = "onsale-products";
                            $products_on_sale = wc_get_product_ids_on_sale();
                            $get_cpt_args['post__in'] = $products_on_sale;
                        }

                        // NEW PRODUCT
                        if ($new_only == "on") {
                            $customclass = "new-products";
                            if ( isset( $new_time ) ) {
                            $get_cpt_args['date_query'] = array(
                                array(
                                    'after' => '-' . $new_time . ' days',
                                    'column' => 'post_date',
                                )
                            );
                        }
                        }

                        if ($show_hidden_prod == "off") {

                            if (!empty($product_visibility_not_in)) {
                                $get_cpt_args['tax_query'][] = array(
                                    'taxonomy' => 'product_visibility',
                                    'field' => 'term_taxonomy_id',
                                    'terms' => $product_visibility_not_in,
                                    'operator' => 'NOT IN',
                                );
                                if ($featured_only == "on") {
                                    $get_cpt_args['tax_query']['relation'] = 'AND';
                                }
                            }
                        }

                        $module_class = '';

                        if ($fullwidth == 'list') {
                            $module_class .= ' et_pb_db_filter_loop_list et_pb_db_filter_loop_hide custom-layout';
                            echo '<style>.et_shop_image {display:inline-block;}</style>';
                        }
                        else {
                            $module_class .= ' et_pb_db_filter_loop_grid et_pb_db_filter_loop_hide custom-layout';
                        }

                        if ($post_type_choose == "product") {
                            if ($show_sorting_menu == 'off') {
                                remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                            }
                            if ($show_results_count == 'off') {
                                remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
                            }
                        }

                        query_posts($get_cpt_args);

                        if ($loop_layout == "none") {
                            echo '<div class="no-html-output" style="background-color:#1d0d6f;color:#fff;padding:40px 60px;clear: both;">
                            <p style="color:#fff;">You have selected a custom layout but have not selected a loop layout for your products</p>
                            <p>Please create a <a href="https://www.youtube.com/watch?v=mLiUJ_hvBjE" target="_blank">custom loop layout</a> and specify it in the settings, or change the layout style to be default.</p>
                            </div>';
                        }
                        else {

                            if ( have_posts() ){
                                if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ){
                                    ?>
                                    <div class="woocommerce-page">
                                    <?php
                                    do_action('woocommerce_before_shop_loop');
                                }
?>
                                <div class="filtered-posts-cont">
                                    <div class="divi-filter-archive-loop main-archive-loop has-result">
                                        <div class="divi-filter-loop-container col-desk-<?php echo esc_attr($cols); ?> col-tab-<?php echo esc_attr($columns_tablet); ?> col-mob-<?php echo esc_attr($columns_mobile); ?>">

                                        <?php
                                if ($post_type_choose == 'product') {
                                    if ($fullwidth == 'off' || $fullwidth == 'masonry') { //grid
                                        echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products bc_product_grid bc_product_' . esc_attr($cols) . ' bc_pro_tab_' . esc_attr($columns_tablet) . ' bc_pro_mob_' . esc_attr($columns_mobile) . '">';
                                    }
                                    else {
                                        echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products">';
                                    }
                                }
                                else {
                                    echo '<ul class="et_pb_row_divifilter custom-loop-layout">';
                                }

                                while (have_posts()) {
                                    the_post();
                                    global $product, $post;
                                    echo '<li>';
                                    $product_content = apply_filters('the_content', wp_kses_post(get_post_field('post_content', $loop_layout)));

                                    $product_content = preg_replace('/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $product_content);
                                    $product_content = preg_replace('/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $product_content);

                                    echo et_core_esc_previously($product_content);
                                    echo '</li>';
                                }

                                echo '</ul>';
                                wp_reset_query();
?>

                                        </div>
                                    </div>
                                 </div>
                                <?php
                                if ('pagination' === $enable_loadmore) {
                                    do_action('woocommerce_after_shop_loop');
                                }

                                if ($post_type_choose == 'product') {
?>
                                    </div>
                                    <?php
                                }
                            }

                            // retrieve the styles for the modules
                            $internal_style = ET_Builder_Element::get_style();
                            // reset all the attributes after we retrieved styles
                            ET_Builder_Element::clean_internal_modules_styles(false);
                            $et_pb_rendering_column_content = false;
                            // append styles
                            if ($internal_style) {
?>
                                 <div class="df-inner-styles">
                                     <?php
                                //$cleaned_styles = str_replace("#et-boc .et-l","#et-boc .et-l .filtered-posts", $internal_style);
                                $cleaned_styles = preg_replace('/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $internal_style);
                                $cleaned_styles = preg_replace('/et_pb_([a-z]+)_(\d+)( |"|.)/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $cleaned_styles);
                                printf('<style type="text/css" class="dmach_ajax_inner_styles">
                                         %1$s
                                         </style>', et_core_esc_previously($cleaned_styles));
?>
                                </div>
                                <?php
                            }
                        }

                    }
                    wp_reset_query();
                    $shop = ob_get_clean();
                    return $shop;

                }

                // END COMPUTED PRODUCTS
                public function change_columns_number($c) {

                    $columns = 3;
                    if (absint($this->columns) > 0) {
                        $columns = absint($this->columns);
                    }
                    return $columns;
                }

                public static function product_details_wrapper_start() {
                    echo "<div class='de_db_product_details'>";
                }
                public static function product_details_wrapper_end() {
                    echo "</div>";
                }
                public static function product_image_wrapper_start() {
                    echo "<div class='de_db_product_image'>";
                }
                public static function product_image_wrapper_end() {
                    echo "</div>";
                }

                public function validateDate($date, $format = 'Y-m-d H:i:s')
                {
                    $d = DateTime::createFromFormat($format, $date);
                    return $d && $d->format($format) == $date;
                }

                function render($attrs, $content, $render_slug) {
                    if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
                        return;
                    }

                    global $wpdb, $address_filter_var, $price_filter_var;

                    $address_filter_var['is_filter'] = false;

                    $price_filter_var = array(
                        'is_filter' => false,
                        'min_price' => 0,
                        'max_price' => 999999999
                    );

                    $cat_loop_style = $this->props['cat_loop_style'];
                    $background_layout = '';
                    $loop_layout = $this->props['loop_layout'];
                    $cols = $this->props['columns'];
                    $columns_tablet = $this->props['columns_tablet'];
                    $columns_mobile = $this->props['columns_mobile'];
                    $module_id = $this->props['module_id'];
                    $module_class = $this->props['module_class'];
                    $fullwidth = $this->props['fullwidth'];
                    $post_display_type = $this->props['post_display_type'];

                    $masonry_ajax_buffer = $this->props['masonry_ajax_buffer'];

                    if ($masonry_ajax_buffer == "") {
                        $masonry_ajax_buffer = "500";
                    }

                    $masonry_ajax_buffer = preg_replace("/[^0-9]/", "", $masonry_ajax_buffer);

                    $custom_loop = !empty($this->props['custom_loop']) ? $this->props['custom_loop'] : 'off';
                    $include_tags = ($custom_loop == 'on') ? $this->props['include_tags'] : '';
                    $include_cats = ($custom_loop == 'on') ? $this->props['include_cats'] : '';
                    $posts_number = $this->props['posts_number'];

                    $post_type_choose = $this->props['post_type_choose'];
                    $sort_order = $this->props['sort_order'];
                    $order_asc_desc = $this->props['order_asc_desc'];
                    $featured_only = $this->props['featured_only'];
                    $popular_only = $this->props['popular_only'];
                    $on_sale_only = $this->props['on_sale_only'];
                    $outofstock_only = $this->props['outofstock_only'];
                    $link_whole_gird = $this->props['link_whole_gird'];
                    $new_only = $this->props['new_only'];
                    $new_time = $this->props['new_time'];

                    // $product_type        = $this->props['product_type'];
                    // DEFAULT
                    $display_type = $this->props['display_type'];
                    $is_main_loop = $this->props['is_main_loop'];
                    $main_loop = ($is_main_loop == 'on') ? true : false;
                    $show_sorting_menu = $main_loop ? $this->props['show_sorting_menu'] : 'off';
                    $show_results_count = $main_loop ? $this->props['show_results_count'] : 'off';
                    $results_count_position = $main_loop && $show_results_count == 'on' && $this->props['results_count_position'] != '' ? $this->props['results_count_position'] : 'top';
                    $show_rating = $this->props['show_rating'];
                    $show_price = $this->props['show_price'];
                    $show_excerpt = $this->props['show_excerpt'];
                    $show_add_to_cart = $this->props['show_add_to_cart'];
                    $enable_loadmore = $main_loop ? $this->props['enable_loadmore'] : 'off';
                    $loadmore_text = $this->props['loadmore_text'];
                    $loadmore_align = $this->props['loadmore_align'];
                    $loadmore_text_loading = $this->props['loadmore_text_loading'];

                    $scrollto = $this->props['scrollto'];
                    $scrollto_fine_tune = $this->props['scrollto_fine_tune'];

                    $this->columns = $this->props['columns_number'];
                    $sale_badge_color = $this->props['sale_badge_color'];
                    $stars_color = $this->props['stars_color'];
                    $use_overlay = $this->props['use_overlay'];
                    $icon_hover_color = $this->props['icon_hover_color'];
                    $hover_overlay_color = $this->props['hover_overlay_color'];
                    $hover_icon = $this->props['hover_icon'];
                    $product_background = $this->props['product_background'];
                    $product_padding = $this->props['product_padding'];

                    $custom_add_to_cart_button = $this->props['custom_add_to_cart_button'];
                    $add_to_cart_button_bg_color = $this->props['add_to_cart_button_bg_color'];
                    $add_to_cart_button_icon = $this->props['add_to_cart_button_icon'];
                    $add_to_cart_button_icon_placement = $this->props['add_to_cart_button_icon_placement'];

                    $equal_height_mob = $this->props['equal_height_mob'];
                    $equal_height = $this->props['equal_height'];
                    $align_last_bottom = $this->props['align_last_bottom'];
                    $hide_non_purchasable = $this->props['hide_non_purchasable'];
                    // $et_shortcode        = $this->props['et_shortcode'];
                    $disable_products_has_cat = $this->props['disable_products_has_cat'];
                    $exclude_products = $this->props['exclude_products'];
                    $exclude_cats = $this->props['exclude_cats'];

                    $no_results_layout = $this->props['no_results_layout'];
                    $show_hidden_prod = $this->props['show_hidden_prod'];

                    $filter_update_animation = $this->props['filter_update_animation'];
                    $animation_color = $this->props['animation_color'];
                    $loading_bg_color = $this->props['loading_bg_color'];
                    $pagination_item_background = $this->props['pagination_item_background'];
                    $pagination_item_background_active = $this->props['pagination_item_background_active'];

                    $custom_tax_choose = $this->props['custom_tax_choose'];
                    $include_taxomony = $this->props['include_taxomony'];

                    $onload_cats = $this->props['onload_cats'];
                    $onload_tags = $this->props['onload_tags'];
                    $onload_tax_choose = $this->props['onload_tax_choose'];
                    $onload_taxomony = $this->props['onload_taxomony'];

                    

                $custom_gutter_width    = $this->props['custom_gutter_width']; 
                $gutter_row_gap         = $this->props['gutter_row_gap'] ?: '25px';
                $gutter_row_column      = $this->props['gutter_row_column'] ?: '25px';
                
                // Module classnames
                $this->add_classname(
                    array(
                        'clearfix',
                        $this->get_text_orientation_classname(),
                    )
                );

                if ('on' === $custom_gutter_width) {
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .bc_product_grid',
                    'declaration' => sprintf(
                      'grid-row-gap: %1$s !important;',
                      esc_html( $gutter_row_gap )
                    ),
                  ) );
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .bc_product_grid',
                    'declaration' => sprintf(
                      'grid-column-gap: %1$s !important;',
                      esc_html( $gutter_row_column )
                    ),
                  ) );
                }

                    wp_enqueue_script('divi-filter-js');
                    wp_enqueue_script('divi-filter-masonry-js');

                    $this->add_classname('grid-layout-' . $fullwidth);

                    $link_whole_gird_new_tab = $this->props['link_whole_gird_new_tab'];
                    if ($link_whole_gird_new_tab == 'on') {
                        $this->add_classname('link_whole_new_tab');
                    }

                    if ($fullwidth == 'list') {
                        $cols = 1;
                        $columns_tablet = 1;
                        $columns_mobile = 1;
                    }

                    //////////////////////////////////////////////////////////////////////
                    if ($equal_height == 'on' && $fullwidth !== "masonry") {
                        $this->add_classname('same-height-cards');
                    }
                    if ($align_last_bottom == 'on') {
                        $this->add_classname('align-last-module');
                    }

                    if (!empty($_GET['orderby'])) {
                        $sort_order = $_GET['orderby'];
                    }

                    if ('' !== $loading_bg_color) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .ajax-loading',
                            'declaration' => sprintf('background-color: %1$s !important;', esc_html($loading_bg_color)),
                        ));
                    }

                    if ("pagination" === $enable_loadmore) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% nav.woocommerce-pagination ul li span, %%order_class%% nav.woocommerce-pagination ul li a, %%order_class%% nav.woocommerce-pagination ul li a, %%order_class%% .divi-filter-pagination ul.page-numbers li span',
                            'declaration' => "background-color: {$pagination_item_background} !important;"
                        ));

                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% nav.woocommerce-pagination ul li span.current, %%order_class%% nav.woocommerce-pagination ul li a:hover, %%order_class%% nav.woocommerce-pagination ul li a:focus, %%order_class%% .divi-filter-pagination ul.page-numbers li span.current',
                            'declaration' => "background-color: {$pagination_item_background_active} !important;"
                        ));
                    }

                    if ('' !== $animation_color) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .line',
                            'declaration' => sprintf('background-color: %1$s !important;', esc_html($animation_color)),
                        ));
                    }

                    if ('' !== $animation_color) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .donut',
                            'declaration' => sprintf('border-top-color: %1$s !important;', esc_html($animation_color)),
                        ));
                    }

                    if ('' !== $animation_color) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .donut.multi',
                            'declaration' => sprintf('border-bottom-color: %1$s !important;', esc_html($animation_color)),
                        ));
                    }

                    if ( $results_count_position == 'bottom' ) {
                        if ( $enable_loadmore == 'on' || $enable_loadmore == 'pagination' ) {
                            ET_Builder_Element::set_style($render_slug, array(
                                'selector' => '%%order_class%% .woocommerce-result-count',
                                'declaration' => 'position:absolute;float:none;',
                            ));
                        }

                        if ( $loadmore_align == 'left' ) {
                            $loadmore_align = 'center';
                        }
                    }

                    if ( $enable_loadmore == 'on' ) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .dmach-loadmore',
                            'declaration' => 'display:inline-block;',
                        ));
                    }

                    if ( $loadmore_align == 'center' ) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .dmach-loadmore',
                            'declaration' => 'left:50%; transform:translateX(-50%);',
                        ));
                    } else if ( $loadmore_align == 'right' ) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .dmach-loadmore',
                            'declaration' => 'float:right;',
                        ));
                    }

                    if ('' !== $animation_color) {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => '%%order_class%% .ripple',
                            'declaration' => sprintf('border-color: %1$s !important;', esc_html($animation_color)),
                        ));
                    }

                    global $wp_query;

                    if ($post_type_choose == 'auto-detect' && (is_archive() || is_search())) {
                        $post_type_choose = $wp_query->query_vars['post_type'];
                    }

                    ob_start();

                    if (function_exists('is_product_category') && is_product_category() && $disable_products_has_cat == "on") {
                        global $post;
                        $cate = get_queried_object();
                        $cateID = $cate->term_id;
                        $terms = get_terms('product_cat', array(
                            'orderby' => 'ASC',
                            'parent' => $cateID,
                        ));
                        if ($terms) {
                            return;
                        }
                    }

                    $initial_query_vars = $wp_query->query_vars;
                    $current_taxonomy = '';
                    $current_tax_term = '';
                    if (!empty($initial_query_vars['taxonomy']) && !empty($initial_query_vars['term'])) {
                        $current_taxonomy = $initial_query_vars['taxonomy'];
                        $current_tax_term = $initial_query_vars['term'];
                    }

                    $et_paged = is_front_page() ? get_query_var('page') : get_query_var('paged');

                    if ($is_main_loop == 'off') {
                        $et_paged = 1;
                    }

                    if ($custom_loop != 'on') {
                        $order_asc_desc = 'DESC';
                        $sort_order = 'DATE';
                    }

                    $wc_product_attributes = array();

                    if ( ($post_type_choose == 'product' || $post_type_choose == 'product_variation') && is_plugin_active('woocommerce/woocommerce.php' ) ) {
                        if ( !is_admin() && ! wp_doing_ajax() ) {
?>
<script>
    jQuery(document).ready(function(){
        jQuery('body').addClass('woocommerce');
    });    
</script>
<?php
                        }
                        
                        if ( $post_type_choose == 'product' && function_exists( 'wc_get_attribute_taxonomies' ) ) {
                            $attribute_taxonomies = wc_get_attribute_taxonomies();
                            if ( $attribute_taxonomies ) {
                                foreach ( $attribute_taxonomies as $tax ) {
                                    $wc_product_attributes[]  = 'pa_' . $tax->attribute_name;
                                }
                            }
                        }
                    }

                    $args = array(
                        'post_type' => $post_type_choose,
                        'order' => $order_asc_desc,
                        'post_status' => 'publish',
                        'paged' => $et_paged,
                        'posts_per_page' => (int)$posts_number,
                        'meta_query' => array(
                            'relation' => 'AND'
                        ),
                        'tax_query' => array(
                            'relation' => 'AND'
                        ),
                        'post__not_in' => explode(',', $exclude_products),
                    );

                    $cpt_taxonomies = get_object_taxonomies($post_type_choose);

                    if ($exclude_cats != "") {
                        $exclude_cats_arr = explode(',', $exclude_cats);

                        if ($post_type_choose == "post") {
                            $args['category__not_in'] = $exclude_cats_arr;
                        }
                        else {

                            if (!empty($cpt_taxonomies) && in_array('category', $cpt_taxonomies)) {
                                $args['category__not_in'] = $exclude_cats_arr;
                            }
                            else {
                                $ending = "_category";
                                $cat_key = $post_type_choose . $ending;
                                if ($cat_key == "product_category" || $cat_key == "product_variation_category") {
                                    $cat_key = "product_cat";
                                }

                                $args['tax_query'][] = array(
                                    'taxonomy' => $cat_key,
                                    'field' => 'slug',
                                    'terms' => $exclude_cats_arr,
                                    'operator' => 'NOT IN'
                                );
                            }
                        }
                    }

                    $stock_status = '';

                    if ( isset( $_GET['stock_status'] ) && $_GET['stock_status'] != '' ) {
                        $stock_status = $_GET['stock_status'];
                        $args['meta_query'][] = array(
                            'key' => '_stock_status',
                            'value' => $stock_status,
                            'type'  => 'CHAR',
                        );
                    }

                    $current_product_attributes = array();

                    if ( $post_type_choose == 'product' && $is_main_loop == 'on' ) {
                        foreach ( $cpt_taxonomies as $tax_name ) {
                            if ( !empty($_GET[$tax_name]) && is_array( $wc_product_attributes ) && in_array( $tax_name, $wc_product_attributes ) ) {
                                $current_product_attributes[] = array( 'attr_name' => $tax_name, 'attr_val' => $_GET[$tax_name] );
                            }
                        }
                    }

                    if ( !empty( $current_product_attributes ) ) {

                        global $wpdb;

                        if ( $stock_status == '' ) {
                            $stock_status = 'instock';
                        }

                        $sql = "
                            SELECT child_posts.post_parent
                              FROM {$wpdb->posts} as child_posts            
                        ";

                        foreach ( $current_product_attributes as $ind => $attr ) {
                            $sql .= " 
                                INNER JOIN {$wpdb->postmeta} AS child_meta{$ind} ON child_meta{$ind}.post_id = child_posts.id AND child_meta{$ind}.meta_key = 'attribute_{$attr['attr_name']}' AND child_meta{$ind}.meta_value='{$attr['attr_val']}'
                                INNER JOIN {$wpdb->postmeta} AS child_stock{$ind} ON child_stock{$ind}.post_id = child_posts.id AND child_stock{$ind}.meta_key = '_stock_status' AND child_stock{$ind}.meta_value != '{$stock_status}'
                            ";
                        }

                        $sql .= " WHERE child_posts.post_type = 'product_variation'";

                        $unavailable_posts = $wpdb->get_results( $sql, ARRAY_A );

                        if ( !empty( $unavailable_posts ) ) {
                            $unavailable_posts = array_column($unavailable_posts, 'post_parent');

                            /*if ( !empty( $args['post__not_in'] ) ) {
                                $args['post__not_in'] = array_merge( $args['post__not_in'], $unavailable_posts);    
                            } else {
                                $args['post__not_in'] = $unavailable_posts;
                            }*/

                            //$args['post__not_in'] =  array_filter( $args['post__not_in'] );
                            $args['post__not_in'] = $unavailable_posts;
                        }
                    }

                    if ($sort_order == "stock_status") {

                        $args['orderby'] = 'meta_value';
                        $args['meta_key'] = '_stock_status';

                    }
                    else if ($sort_order == "product_price") {
                        $args['orderby'] = 'price';
                        if ($order_asc_desc == "ASC") {
                            add_filter('posts_clauses', array(
                                WC()->query,
                                'order_by_price_asc_post_clauses'
                            ));
                        }
                        else {
                            add_filter('posts_clauses', array(
                                WC()->query,
                                'order_by_price_desc_post_clauses'
                            ));
                        }
                    }
                    else {
                        $args['orderby'] = $sort_order;
                    }

                    $is_search = is_search();

                    if ($is_search && $is_main_loop == 'on') {

                        // Add compatibility with Algolia plugin
                        add_filter('algolia_should_filter_query', function ($should_filter, $query) {
                            return true;
                        }
                        , 20, 2);

                        // Add compatibility with Relevanssi plugin
                        add_filter('relevanssi_search_ok', function ($search_ok, $query) {
                            return true;
                        }
                        , 20, 2);
                    }

                    if (is_archive() || $is_search) {
                        $args = array_merge($wp_query->query_vars, $args);
                    }

                    if ($custom_loop != 'on') {
                        $orderby_value = apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
                        $orderby_value = is_array($orderby_value) ? $orderby_value : explode('-', $orderby_value);
                        $orderby = esc_attr($orderby_value[0]);
                        $order = !empty($orderby_value[1]) ? $orderby_value[1] : '';
                        if (function_exists('WC')) {
                            $orderby_args = WC()
                                ->query
                                ->get_catalog_ordering_args($orderby, $order);
                        }
                        else {
                            $orderby_args = array(
                                'orderby' => $orderby,
                                'order' => $order
                            );
                        }

                        $args = array_merge($args, $orderby_args);
                    }

                    if ($enable_loadmore == 'on') {
                        wp_enqueue_script('divi-machine-ajax-loadmore-js');
                    }

                    if ($post_type_choose != 'product') {
                        $taxonomies = get_object_taxonomies($post_type_choose);

                        foreach ($taxonomies as $tax_name) {
                            if ($main_loop && !empty($_GET[$tax_name])) {
                                if (!empty($args['tax_query'])) {
                                    $query_val = $_GET[$tax_name];
                                    $query_val_array = explode(';', $query_val);
                                    if (count($query_val_array) > 1) {
                                        $terms = get_terms(array(
                                            'taxonomy' => $tax_name,
                                            'hide_empty' => true
                                        ));
                                        $term_id_array = array();
                                        foreach ($terms as $term) {
                                            $term_slug = floatval(str_replace('-', '.', $term->slug));
                                            if ($term_slug >= $query_val_array[0] && $term_slug <= $query_val_array[1]) {
                                                $term_id_array[] = $term->term_id;
                                            }
                                        }
                                        $tax_query[] = array(
                                            'taxonomy' => $tax_name,
                                            'field' => 'term_id',
                                            'terms' => $term_id_array,
                                            'operator' => 'IN'
                                        );
                                    }
                                    else {
                                        $get_tax_name = $_GET[$tax_name];
                                        $val_and_array = explode('|', $get_tax_name);
                                        if (is_array($val_and_array) && count($val_and_array) > 1) {
                                            $sub_tax_query = array(
                                                'relation' => 'AND'
                                            );
                                            foreach ($val_and_array as $key => $or_value) {
                                                $sub_tax_query[] = array(
                                                    'taxonomy' => $tax_name,
                                                    'field' => 'slug',
                                                    'terms' => explode(',', $or_value),
                                                    'operator' => 'IN'
                                                );
                                            }
                                            $args['tax_query'][] = $sub_tax_query;
                                        }
                                        else {
                                            $args['tax_query'][] = array(
                                                'taxonomy' => $tax_name,
                                                'field' => 'slug',
                                                'terms' => explode(',', $_GET[$tax_name]),
                                                'operator' => 'IN'
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if ($include_taxomony != "") {
                        $args['tax_query'][] = array(
                            'taxonomy' => $custom_tax_choose,
                            'field' => 'slug',
                            'terms' => explode(',', $include_taxomony),
                            'operator' => 'IN'
                        );
                    }

                    if ($onload_cats != "" ) {

                        $onload_cats_arr = explode(',', $onload_cats);

                        if ($post_type_choose == "post") {
                            if ( !isset($_GET['filter'] ) || !isset( $_GET['category'] ) ) {
                                $args['tax_query'][] = array(
                                    'taxonomy' => 'category',
                                    'field' => 'slug',
                                    'terms' => $onload_cats_arr,
                                    'operator' => 'IN'
                                );
                            }
                        }
                        else {

                            $ending = "_category";
                            $cat_key = $post_type_choose . $ending;
                            if ($cat_key == "product_category" || $cat_key == "product_variation_category") {
                                $cat_key = "product_cat";
                            }

                            if (!empty($cpt_taxonomies) && in_array($cat_key, $cpt_taxonomies)) {
                                if ( !isset($_GET['filter'] ) || !isset( $_GET[ $cat_key] ) ) {
                                    $args['tax_query'][] = array(
                                        'taxonomy' => $cat_key,
                                        'field' => 'slug',
                                        'terms' => $onload_cats_arr,
                                        'operator' => 'IN'
                                    );
                                }
                            }
                            else if (!empty($cpt_taxonomies) && in_array('category', $cpt_taxonomies)) {
                                if ( !isset($_GET['filter'] ) || !isset( $_GET['category'] ) ) {
                                    $args['tax_query'][] = array(
                                        'taxonomy' => 'category',
                                        'field' => 'slug',
                                        'terms' => $onload_cats_arr,
                                        'operator' => 'IN'
                                    );
                                }
                            }
                        }
                    }

                    if ($onload_tags != "") {

                        $onload_tags_arr = explode(',', $onload_tags);

                        $ending = "_tag";
                        $cat_key = $post_type_choose . $ending;

                        if ( !isset($_GET['filter'] ) || !isset( $_GET[$cat_key] ) ) {

                            $args['tax_query'][] = array(
                                'taxonomy' => $cat_key,
                                'field' => 'slug',
                                'terms' => $onload_tags_arr,
                                'operator' => 'IN'
                            );
                        }
                    }

                    if ($onload_taxomony != "" && ( !isset($_GET['filter'] ) || !isset( $_GET[$onload_tax_choose] ) ) ) {
                        $args['tax_query'][] = array(
                            'taxonomy' => $onload_tax_choose,
                            'field' => 'slug',
                            'terms' => explode(',', $onload_taxomony),
                            'operator' => 'IN'
                        );
                    }

                    if ( $post_display_type != 'default') {
                        $user_id = get_current_user_id();
                        $wishlist_ids = array();
                        
                        if ( $user_id != 0 ) {
                            $get_wishlist_settings = get_user_meta( $user_id, 'bc_wishlist_compare_' . $post_display_type , true );

                            if ( !empty( $get_wishlist_settings[$post_type_choose] ) ) {
                                $wishlist_ids = $get_wishlist_settings[$post_type_choose];
                            }
                        }
                        
                        $args['post__in'] = $wishlist_ids;
                        // var_dump($args['post__in']); exit;
                    }

                    if ($main_loop && !empty($this->acf_fields)) {
                        foreach ($this->acf_fields as $key => $field) {
                            if (!empty($_GET[$field])) {
                                $acf_get = get_field_object($key);
                                $acf_type = $acf_get['type'];

                                // append meta query
                                if ($acf_type == 'range') {

                                    $value_between = str_replace("%3B", ";", $_GET[$field]);
                                    $value = (explode(";", $value_between));
                                    if (count($value) == 1) {
                                        $args['meta_query'][] = array(
                                            'key' => $field,
                                            'value' => $value[0],
                                            'type' => 'NUMERIC',
                                            'compare' => '<='
                                        );
                                    }
                                    else {
                                        $args['meta_query'][] = array(
                                            'key' => $field,
                                            'value' => $value,
                                            'compare' => 'BETWEEN',
                                            'type' => 'NUMERIC'
                                        );
                                    }
                                }
                                else if ($acf_type == "checkbox" ) {
                                    $range_values = explode(';', $_GET[ $field ] );
                                    if ( is_array( $range_values ) && sizeof($range_values) > 1 ){
                                        $sub_query = array();
                                        foreach( $acf_get['choices'] as $choice_val => $choice_label ) {
                                            if ( ( floatval($choice_val) >= floatval($range_values[0] ) ) 
                                                && ( floatval($choice_val) <= floatval($range_values[1] ) ) ) {
                                                $sub_query[] = array(
                                                    'key' => $field,
                                                    'value' => '"' . $choice_val . '"',
                                                    'type'  => 'CHAR',
                                                    'compare' => 'LIKE'
                                                );
                                            }
                                        }
                                        if ( !empty( $sub_query ) ) {
                                            $sub_query['relation'] = 'OR';
                                            $args['meta_query'][] = $sub_query;
                                        }
                                    } else {
                                        $val_and_array = explode('|', $_GET[ $field ]);
                                        if (is_array($val_and_array) && count($val_and_array) > 1) {
                                            $query_arr = array(
                                                'relation' => 'AND'
                                            );
                                            foreach ($val_and_array as $key => $or_value) {
                                                $val_array = explode(',', $or_value);
                                                if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                                    $query_sub_arr = array( 'relation' => 'OR' );
                                                    foreach ( $val_array as $meta_val ) {
                                                        $query_sub_arr[] = array(
                                                            'key' => $field,
                                                            'value' => '"' . $meta_val . '"',
                                                            'type' => 'CHAR',
                                                            'compare' => 'LIKE',
                                                        );
                                                    }
                                                    $query_arr[] = $query_sub_arr;
                                                } else {
                                                    $query_arr[] = array(
                                                        'key' => $field,
                                                        'value' => '"' . $or_value . '"',
                                                        'type' => 'CHAR',
                                                        'compare' => 'LIKE',
                                                    );
                                                }
                                            }
                                            $args['meta_query'][] = $query_arr;
                                        } else {
                                            $val_array = explode( ',',  $_GET[ $field ]  );
                                            if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                                $query_arr = array( 'relation' => 'OR' );
                                                foreach ( $val_array as $meta_val ) {
                                                    $query_arr[] = array(
                                                        'key' => $field,
                                                        'value' => '"' . $meta_val . '"',
                                                        'type' => 'CHAR',
                                                        'compare' => 'LIKE',
                                                    );
                                                }
                                                $args['meta_query'][] = $query_arr;
                                            } else {
                                                $args['meta_query'][] = array(
                                                    'key' => $field,
                                                    'value' => '"' . $_GET[ $field ] . '"',
                                                    'type' => 'CHAR',
                                                    'compare' => 'LIKE',
                                                );
                                            }
                                        }
                                    }
                                } else if ($acf_type == "google_map") {
                                    if (isset($_GET[$field])) {
                                        $address = $_GET[$field];
                                        $address = str_replace(" ", "+", $address);
                                    }

                                    $et_google_api_settings = get_option('et_google_api_settings');
                                    if (isset($et_google_api_settings['api_key'])) {
                                        $key = $et_google_api_settings['api_key'];
                                        if ( isset( $address ) ) {
                                            $json = file_get_contents( "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$key" );
                                        }
                                        $json = json_decode($json);

                                        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                                        $lng = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

                                        if (isset($_GET['map_radius']) && isset($_GET['map_radius_unit'])) {
                                            $get_map_radius = $_GET['map_radius'];
                                            $map_radius_unit = $_GET['map_radius_unit'];
                                        }

                                        $address_filter_var['is_filter'] = true;
                                        $address_filter_var['lat'] = $lat;
                                        $address_filter_var['lng'] = $lng;
                                        $address_filter_var['radius'] = !empty($get_map_radius) ? $get_map_radius : 30;
                                        $address_filter_var['radius_unit'] = !empty($map_radius_unit) ? $map_radius_unit : 'km';
                                        $address_filter_var['address_field'] = $field;
                                    }
                                } else {
                                    $value = explode(',', $_GET[ $field ]);
                                    $range_values = explode(';', $_GET[ $field ] );
                                    if ( isset($acf_get['multiple']) && $acf_get['multiple'] == true ){
                                      if ( is_array( $range_values ) && count($range_values) > 1 ){
                                        $sub_query = array();
                                        foreach( $acf_get['choices'] as $choice_val => $choice_label ) {
                                            if ( ( floatval($choice_val) >= floatval($range_values[0] ) ) 
                                                    && ( floatval($choice_val) <= floatval($range_values[1] ) ) ) {
                                                $sub_query[] = array(
                                                    'key' => $field,
                                                    'value' => '"' . $choice_val . '"',
                                                    'type'  => 'CHAR',
                                                    'compare' => 'LIKE'
                                                );
                                            }
                                        }
                                        if ( !empty( $sub_query ) ) {
                                            $sub_query['relation'] = 'OR';
                                            $args['meta_query'][] = $sub_query;
                                        }
                                      } else {
                                        $val_and_array = explode('|', $_GET[ $field ]);
                                        if (is_array($val_and_array) && count($val_and_array) > 1) {
                                            $query_arr = array(
                                                'relation' => 'AND'
                                            );
                                            foreach ($val_and_array as $key => $or_value) {
                                                $val_array = explode(',', $or_value);
                                                if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                                    $query_sub_arr = array( 'relation' => 'OR' );
                                                    foreach ( $val_array as $meta_val ) {
                                                        $query_sub_arr[] = array(
                                                            'key' => $field,
                                                            'value' => '"' . $meta_val . '"',
                                                            'type' => 'CHAR',
                                                            'compare' => 'LIKE',
                                                        );
                                                    }
                                                    $query_arr[] = $query_sub_arr;
                                                } else {
                                                    $query_arr[] = array(
                                                        'key' => $field,
                                                        'value' => '"' . $or_value . '"',
                                                        'type' => 'CHAR',
                                                        'compare' => 'LIKE',
                                                    );
                                                }
                                            }
                                            $args['meta_query'][] = $query_arr;
                                        } else {
                                            if ( is_array( $value ) && sizeof( $value ) > 1 ){
                                                $query_arr = array( 'relation' => 'OR' );
                                                foreach ( $value as $meta_val ) {
                                                    $query_arr[] = array(
                                                        'key' => $field,
                                                        'value' => '"' . $meta_val . '"',
                                                        'type' => 'CHAR',
                                                        'compare' => 'LIKE',
                                                    );
                                                }
                                                $args['meta_query'][] = $query_arr;
                                            } else {
                                                $args['meta_query'][] = array(
                                                    'key' => $field,
                                                    'value' => '"' . $_GET[ $field ] . '"',
                                                    'type' => 'CHAR',
                                                    'compare' => 'LIKE',
                                                );
                                            }
                                        }
                                        
                                      }
                                    } else{
                                      if ( is_array( $range_values ) && count($range_values) > 1 ){
                                        $args['meta_query'][] = array(
                                            'key' => $field,
                                            'value' => $range_values,
                                            'compare' => 'BETWEEN',
                                            'type' => 'DECIMAL(10,3)'
                                        );
                                      } else {
                                        $val_and_array = explode('|', $_GET[ $field ]);
                                        if (is_array($val_and_array) && count($val_and_array) > 1) {
                                            $query_arr = array(
                                                'relation' => 'AND'
                                            );
                                            foreach ($val_and_array as $key => $or_value) {
                                                $val_array = explode(',', $or_value);
                                              
                                                $query_arr[] = array(
                                                    'key' => $field,
                                                    'value' => $val_array,
                                                    'compare' => 'IN',
                                                );
                                            }
                                            $args['meta_query'][] = $query_arr;
                                        } else {
                                            $args['meta_query'][] = array(
                                              'key'       => $field,
                                              'value'     => $value,
                                              'compare' => 'IN'
                                            );    
                                        }
                                        /*
                                        $meta_query[] = array(
                                          'key'       => $name,
                                          'value'     => $value,
                                          'compare' => 'IN'
                                          ); */ 
                                      }  
                                    }
                                    /*$value = explode(',', $_GET[$field]);
                                    $args['meta_query'][] = array(
                                        'key' => $field,
                                        'value' => $value,
                                        'compare' => 'IN',
                                    );*/
                                }
                            }
                        }
                    }

                    $meta_key_sql = "SELECT DISTINCT p_meta.meta_key FROM {$wpdb->postmeta} p_meta INNER JOIN {$wpdb->posts} posts ON p_meta.post_id=posts.ID WHERE posts.post_type=%s;";

                    if(defined('ARRAY_N')) {
                    $meta_keys = $wpdb->get_results( $wpdb->prepare( $meta_key_sql, $post_type_choose ), ARRAY_N );
                    }
                    $meta_keys = array_map( function( $v ){
                        return $v[0];
                    }, $meta_keys);

                    if ($cat_loop_style == "off") { // CUSTOM LAYOUT
                        if ($show_sorting_menu == 'off') {
                            remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                        }
                        if ($show_results_count == 'off' || $results_count_position == 'bottom' ) {
                            remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
                        }

                        if ( $results_count_position == 'bottom' ) {

                            add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 5);
                        }

                        global $paged;

                        $module_class = ET_Builder_Element::add_module_order_class($module_class, $render_slug);

                        $container_is_closed = false;

                        if ($fullwidth == 'list') {
                            $module_class .= ' et_pb_db_filter_loop_list et_pb_db_filter_loop_hide custom-layout';
                            echo '<style>.et_shop_image {display:inline-block;}</style>';
                        }
                        else {
                            $module_class .= ' et_pb_db_filter_loop_grid et_pb_db_filter_loop_hide custom-layout';
                        }

                        if ($custom_loop == 'on') { // CUSTOM LOOP
                            if ($include_cats != "") {
                                if ($post_type_choose == "post") {
                                    $args['category_name'] = $include_cats;
                                } else if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation') {
                                    $args['product_cat'] = $include_cats;
                                }
                                else {

                                    if (!empty($cpt_taxonomies) && in_array('category', $cpt_taxonomies)) {
                                        $args['category_name'] = $include_cats;
                                    }
                                    else {
                                        $ending = "_category";
                                        $cat_key = $post_type_choose . $ending;
                                        if ($cat_key == "product_category" || $cat_key == "product_variation_category") {
                                            $cat_key = "product_cat";
                                        }
                                        else {
                                            $cat_key = $cat_key;
                                        }

                                        $args['tax_query'][] = array(
                                            'taxonomy' => $cat_key,
                                            'field' => 'slug',
                                            'terms' => $include_cats,
                                            'operator' => 'IN'
                                        );
                                    }
                                }
                            }

                            if ($include_tags != "") {
                                $args['product_tag'] = $include_tags;
                                if ($post_type_choose == "post") {
                                    $args['tag'] = $include_tags;
                                }
                                else {
                                    $ending = "_tag";
                                    $cat_key = $post_type_choose . $ending;

                                    $args['tax_query'][] = array(
                                        'taxonomy' => $cat_key,
                                        'field' => 'slug',
                                        'terms' => $include_tags,
                                        'operator' => 'IN'
                                    );
                                }
                            }

                            // FEATURED
                            if ($featured_only == "on") {
                                $tax_query[] = array(
                                    'taxonomy' => 'product_visibility',
                                    'field' => 'name',
                                    'terms' => 'featured',
                                    'operator' => 'IN',
                                );

                                $args['tax_query'] = $tax_query;
                            }

                            // POPULAR
                            if ($popular_only == "on") {
                                $customclass = "popular-products";
                                $args['meta_key'] = 'total_sales';
                                $args['orderby'] = 'meta_value_num';
                            }

                            // ON SALE
                            if ($on_sale_only == "on") {
                                $customclass = "onsale-products";
                                $products_on_sale = wc_get_product_ids_on_sale();
                                $args['post__in'] = $products_on_sale;
                            }

                            // NEW PRODUCT
                            if ($new_only == "on") {
                                $customclass = "new-products";
                                $args['date_query'] = array(
                                    array(
                                        'after' => '-' . $new_time . ' days',
                                        'column' => 'post_date',
                                    )
                                );
                            }

                            if ($outofstock_only == "on") {
                                $args['meta_query'][] = array(
                                    'key' => '_stock_status',
                                    'value' => 'outofstock'
                                );
                            }

                            if (is_single() && !isset($args['post__not_in'])) {
                                $args['post__not_in'] = array(
                                    get_the_ID()
                                );
                            }

                            // $wc_query = new WC_Query();
                            // $ordering = $wc_query->get_catalog_ordering_args();
                            // $args['orderby'] = $ordering['orderby'];
                            // $args['order']  = $ordering['order'];
                            if (!empty($ordering['meta_key'])) {
                                $args['meta_key'] = $ordering['meta_key'];
                            }

                            //query_posts( $args );
                            

                            
                        } // END CUSTOM LOOP

                        if ( class_exists( 'woocommerce' ) && ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ) ) {
                            $product_visibility_terms = wc_get_product_visibility_term_ids();
                            $product_visibility_not_in = array(
                                is_search() ? $product_visibility_terms['exclude-from-search'] : $product_visibility_terms['exclude-from-catalog']
                            );
                            if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
                                $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
                            }

                            if ($show_hidden_prod == "off") {

                                if (!empty($product_visibility_not_in)) {
                                    $args['tax_query'][] = array(
                                        'taxonomy' => 'product_visibility',
                                        'field' => 'term_taxonomy_id',
                                        'terms' => $product_visibility_not_in,
                                        'operator' => 'NOT IN',
                                    );
                                }
                            }

                            if ($hide_non_purchasable == "on") {
                                $args['meta_query'][] = array(
                                    'key' => '_price',
                                    'value' => '',
                                    'compare' => '!='
                                );

                                $args['meta_query'][] = array(
                                    'key' => '_stock_status',
                                    'value' => 'outofstock',
                                    'compare' => 'NOT IN'
                                );
                            }
                        }

                        //$args = $wp_query->query_vars;
                        if ($main_loop && !empty($_GET['page'])) {
                            $args['paged'] = $_GET['page'];
                        }

                        if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ) {

                            $product_taxonomies = get_object_taxonomies('product');
                            if ($main_loop) {
                                foreach ($product_taxonomies as $tax_name) {
                                    if (!empty($_GET[$tax_name])) {
                                        $query_val = $_GET[$tax_name];
                                        $query_val_array = explode(';', $query_val);
                                        if (count($query_val_array) > 1) {
                                            $terms = get_terms(array(
                                                'taxonomy' => $tax_name,
                                                'hide_empty' => true
                                            ));
                                            $term_id_array = array();
                                            foreach ($terms as $term) {
                                                $term_slug = floatval(str_replace('-', '.', $term->slug));
                                                if ($term_slug >= $query_val_array[0] && $term_slug <= $query_val_array[1]) {
                                                    $term_id_array[] = $term->term_id;
                                                }
                                            }
                                            if (!empty($args['tax_query'])) {
                                                $args['tax_query'][] = array(
                                                    'taxonomy' => $tax_name,
                                                    'field' => 'term_id',
                                                    'terms' => $term_id_array,
                                                    'operator' => 'IN'
                                                );
                                            }
                                        }
                                        else {
                                            $val_and_array = explode('|', $_GET[$tax_name]);
                                            if (is_array($val_and_array) && count($val_and_array) > 1) {
                                                $sub_tax_query = array(
                                                    'relation' => 'AND'
                                                );
                                                foreach ($val_and_array as $key => $or_value) {
                                                    $sub_tax_query[] = array(
                                                        'taxonomy' => $tax_name,
                                                        'field' => 'slug',
                                                        'terms' => explode(',', $or_value),
                                                        'operator' => 'IN'
                                                    );
                                                }
                                                $args['tax_query'][] = $sub_tax_query;
                                            }
                                            else {
                                                $args['tax_query'][] = array(
                                                    'taxonomy' => $tax_name,
                                                    'field' => 'slug',
                                                    'terms' => explode(',', $_GET[$tax_name]),
                                                    'operator' => 'IN'
                                                );
                                            }
                                        }
                                    }
                                }
                            }

                            foreach (array(
                                "product_cat",
                                "product_tag"
                            ) as $tax_key) {
                                if ($main_loop && !empty($_GET[$tax_key])) {
                                    unset($args[$tax_key]);
                                    if (!empty($args['taxonomy']) && $args['taxonomy'] == $tax_key) {
                                        unset($args['taxonomy']);
                                        unset($args['term']);
                                    }
                                }
                                else {
                                    if (!empty($args[$tax_key])) {

                                        if (strpos($args[$tax_key], '+') === false) {
                                            $args['tax_query'][] = array(
                                                'taxonomy' => $tax_key,
                                                'field' => 'slug',
                                                'terms' => explode(',', $args[$tax_key]),
                                                'operator' => 'IN'
                                            );
                                        }
                                        else {
                                            $or_arr = array();
                                            foreach (explode(',', $args[$tax_key]) as $values) {
                                                $and_arr = array();
                                                foreach (explode('+', $values) as $sub_val) {
                                                    $and_arr[] = array(
                                                        'taxonomy' => $tax_key,
                                                        'field' => 'slug',
                                                        'terms' => $sub_val
                                                    );
                                                }
                                                $or_arr[] = array(
                                                    'relation' => 'AND',
                                                    $and_arr
                                                );
                                            }
                                            $args['tax_query'][] = array(
                                                'relation' => 'OR',
                                                $or_arr
                                            );
                                        }

                                        unset($args[$tax_key]);
                                        if (!empty($args['taxonomy']) && $args['taxonomy'] == $tax_key && $current_taxonomy !== $tax_key ) {
                                            unset($args['taxonomy']);
                                            unset($args['term']);
                                        }
                                    }
                                }
                            }

                            if ($main_loop && !empty($_GET['product_price'])) {

                                $price_value = (explode(';', $_GET['product_price']));

                                if (count($price_value) == 1) {
                                    $min_filter_price = 0;
                                    $max_filter_price = floatval($price_value[0]);
                                }
                                else {
                                    $max_filter_price = floatval($price_value[1]);
                                    $min_filter_price = floatval($price_value[0]);
                                }

                                if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
                                    $tax_class = apply_filters('woocommerce_price_filter_widget_tax_class', ''); // Uses standard tax class.
                                    $tax_rates = WC_Tax::get_rates($tax_class);

                                    if ($tax_rates) {
                                        $min_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($min_filter_price, $tax_rates));
                                        $max_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($max_filter_price, $tax_rates));
                                    }
                                }

                                $price_filter_var['is_filter'] = true;
                                $price_filter_var['min_price'] = $min_filter_price;
                                $price_filter_var['max_price'] = $max_filter_price;
                            }

                            if ($main_loop && !empty($_GET['product_weight'])) {
                                foreach ($args['meta_query'] as $key => $meta) {
                                    if (is_array($meta) && !empty($meta['key']) && ('_weight' == $meta['key'])) {
                                        unset($args['meta_query'][strval($key)]);
                                    }
                                    else if (is_array($meta)) {
                                        foreach ($meta as $subkey => $subMeta) {
                                            if (is_array($subMeta) && !empty($subMeta['key']) && ('_weight' == $subMeta['key'])) {
                                                unset($args['meta_query'][strval($key)]);
                                            }
                                        }
                                    }
                                }
                                $range_value = (explode(";", $_GET['product_weight']));

                                if (count($range_value) == 1) {
                                    $args['meta_query'][] = array(
                                        'key' => '_weight',
                                        'value' => $range_value[0],
                                        'type' => 'DECIMAL',
                                        'compare' => '<='
                                    );
                                }
                                else {
                                    $args['meta_query'][] = array(
                                        'key' => '_weight',
                                        'value' => $range_value,
                                        'compare' => 'BETWEEN',
                                        'type' => 'DECIMAL'
                                    );
                                }
                            }

                            if ($main_loop && isset($_GET['product_rating'])) {
                                foreach ($args['meta_query'] as $key => $meta) {
                                    if (is_array($meta) && !empty($meta['key']) && ('_wc_average_rating' == $meta['key'])) {
                                        unset($args['meta_query'][strval($key)]);
                                    }
                                    else if (is_array($meta)) {
                                        foreach ($meta as $subkey => $subMeta) {
                                            if (is_array($subMeta) && !empty($subMeta['key']) && ('_wc_average_rating' == $subMeta['key'])) {
                                                unset($args['meta_query'][strval($key)]);
                                            }
                                        }
                                    }
                                }

                                $product_rating_arr = explode(',', $_GET['product_rating']);

                                if (is_array($product_rating_arr) && count($product_rating_arr) > 1) {
                                    $rating_query = array(
                                        'relation' => 'OR'
                                    );
                                    foreach ($product_rating_arr as $key => $p_rating) {
                                        if ($p_rating == 0) {
                                            $rating_query[] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => $p_rating,
                                            );
                                        }
                                        else {
                                            $rating_query[] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => array(
                                                    $p_rating - 1,
                                                    (int)$p_rating
                                                ),
                                                'type' => 'DECIMAL(10, 3)',
                                                'compare' => 'BETWEEN',
                                            );
                                        }
                                    }
                                    $args['meta_query'][] = $rating_query;
                                }
                                else {
                                    $range_value = (explode(";", $_GET['product_rating']));

                                    if (count($range_value) == 1) {
                                        if ($range_value[0] == 0) {
                                            $args['meta_query'][] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => $range_value[0],
                                            );
                                        }
                                        else {
                                            $args['meta_query'][] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => array(
                                                    $range_value[0] - 1,
                                                    (int)$range_value[0]
                                                ),
                                                'type' => 'DECIMAL(10, 3)',
                                                'compare' => 'BETWEEN'
                                            );
                                        }
                                    }
                                    else {
                                        $args['meta_query'][] = array(
                                            'key' => '_wc_average_rating',
                                            'value' => $range_value,
                                            'compare' => 'BETWEEN',
                                            'type' => 'DECIMAL(10, 3)'
                                        );
                                    }
                                }
                            }

                            if ($main_loop && !empty($_GET['orderby'])) {
                                $orderby_args = WC()
                                    ->query
                                    ->get_catalog_ordering_args();
                                $args = array_merge($args, $orderby_args);
                            }
                        }

                        $is_post_type_archive = $wp_query->is_post_type_archive;

                        if ($args['orderby'] == 'rand') {
                            $args['orderby'] = 'rand(' . rand() . ')';
                        }

                        $args = apply_filters('db_archive_module_args', $args);

                        $orderby_param = $args['orderby'];
                        $sorttype = 'string';

                        if ($orderby_param == 'meta_value_num') {
                            $sorttype = 'num';
                        }

                        if (strpos($orderby_param, 'meta_value') === 0) {
                            $orderby_param = $args['meta_key'];
                        }

                        if ( $post_type_choose == 'product_variation' ) {
                            $args['post_type'] = array( 'product', 'product_variation' );

                            add_filter( 'posts_clauses', function( $clauses, $w_query ) {
                                global $wpdb;

                                $clauses['fields'] = "IFNULL(child_posts.ID, {$wpdb->posts}.ID) ID, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_date, child_posts.post_date) post_date, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_author, child_posts.post_author) post_author, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_content, child_posts.post_content) post_content, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_title, child_posts.post_title) post_title, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_name, child_posts.post_name) post_name, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_parent, child_posts.post_parent) post_parent,  
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.guid, child_posts.guid) guid, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.menu_order, child_posts.menu_order) menu_order, 
                                    IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_type, child_posts.post_type) post_type";
                                $clauses['join'] = $clauses['join'] . " LEFT JOIN {$wpdb->posts} AS child_posts ON ({$wpdb->posts}.ID = child_posts.post_parent) AND child_posts.post_type = 'product_variation' ";
                                $clauses['groupby'] = "ID";
                                $clauses['orderby'] = str_ireplace( $wpdb->posts . ".", "", $clauses['orderby']);

                                return $clauses;
                            }, 129, 2);

                        }

                        foreach ( $_GET as $param_key => $param_value ) {
                            if ( in_array( $param_key , $cpt_taxonomies ) 
                                || in_array( $param_key, $this->acf_fields ) 
                                || in_array( $param_key, array('orderby', 'stock_status', 'map_radius', 'map_radius_unit', 'page', 'product_price', 'product_weight', 'product_rating', 's', 'filter' ) ) ) {

                                continue;
                            }

                            if ( in_array( $param_key, $meta_keys ) ) {
                                $param_value_array = (explode(';', $param_value));

                                if (count($param_value_array) == 2 ) {
                                    if ( !is_numeric( $param_value_array[0] ) || !is_numeric( $param_value_array[1] ) ) {
                                        $args['meta_query'][] = array(
                                            'key' => $param_key,
                                            'value' => $param_value_array,
                                            'compare' => 'BETWEEN',
                                            'type' => 'DECIMAL(10, 3)'
                                        );
                                    }

                                    if ( !$this->validateDate( $param_value_array[0] ) || !$this->validateDate( $param_value_array[1] ) ) {
                                        $args['meta_query'][] = array(
                                            'key' => $param_key,
                                            'value' => $param_value_array,
                                            'compare' => 'BETWEEN',
                                            'type' => 'DATETIME'
                                        );
                                    }
                                } else {
                                    $val_and_array = explode('|', $param_value);
                                    if (is_array($val_and_array) && count($val_and_array) > 1) {
                                        foreach ($val_and_array as $key => $or_value) {
                                            $or_val_array = explode( ',', $or_value );
                                            $is_date_val = true;
                                            $is_num_val = true;
                                            foreach( $or_val_array as $or_val ) {
                                                if ( !$this->validateDate( $or_val ) ) {
                                                    $is_date_val = false;
                                                }
                                                if ( !is_numeric( $or_val ) ) {
                                                    $is_num_val = false;
                                                }
                                            }

                                            if ( $is_num_val ) {
                                                $args['meta_query'][] = array(
                                                    'key' => $param_key,
                                                    'value' => explode(',', $or_value),
                                                    'compare' => 'IN',
                                                    'type' => 'DECIMAL(10, 3)'
                                                );        
                                            } else if ( $is_date_val ) {
                                                $args['meta_query'][] = array(
                                                    'key' => $param_key,
                                                    'value' => explode(',', $or_value),
                                                    'compare' => 'IN',
                                                    'type' => 'DATETIME'
                                                );
                                            } else {
                                                $args['meta_query'][] = array(
                                                    'key' => $param_key,
                                                    'value' => explode(',', $or_value),
                                                    'compare' => 'IN'
                                                );
                                            }
                                            
                                        }
                                    } else {
                                        $or_val_array = explode( ',', $param_value );
                                        $is_date_val = true;
                                        $is_num_val = true;
                                        foreach( $or_val_array as $or_val ) {
                                            if ( !$this->validateDate( $or_val ) ) {
                                                $is_date_val = false;
                                            }
                                            if ( !is_numeric( $or_val ) ) {
                                                $is_num_val = false;
                                            }
                                        }

                                        if ( $is_num_val ) {
                                            $args['meta_query'][] = array(
                                                'key' => $param_key,
                                                'value' => explode(',', $param_value),
                                                'compare' => 'IN',
                                                'type' => 'DECIMAL(10, 3)'
                                            );        
                                        } else if ( $is_date_val ) {
                                            $args['meta_query'][] = array(
                                                'key' => $param_key,
                                                'value' => explode(',', $param_value),
                                                'compare' => 'IN',
                                                'type' => 'DATETIME'
                                            );
                                        } else {
                                            $args['meta_query'][] = array(
                                                'key' => $param_key,
                                                'value' => explode(',', $param_value),
                                                'compare' => 'IN'
                                            );
                                        }
                                    }
                                }
                            }  
                        }

                        query_posts( $args );

                        if ( $post_type_choose == 'product_variation' ) {
                            remove_all_filters( 'posts_clauses', 129 );
                        }

                        $address_filter_var['is_filter'] = false;

                        $price_filter_var['is_filter'] = false;

                        // $wp_query->is_post_type_archive = $is_post_type_archive;
                        $wp_query->is_search = $is_search;

                        if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation') {
                            $wp_query->set( 'wc_query', 'product_query' );    
                        }                        

                        if ($loop_layout == "none") {
                            echo "</div>";
                            echo "<h1>You have selected a custom layout but have not selected a loop layout for your products</h1>
                            Please create a <a href='https://www.youtube.com/watch?v=mLiUJ_hvBjE' target='_blank'>custom loop layout</a> and specify it in the settings, or change the layout style to be default.";
                        }
                        else {

                            if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ){
                                /*$have_post = false;
                                
                                if ( have_posts() ){
                                    while ( have_posts() ){
                                        the_post();
                                        global $product;
                                        if (isset($product)) {
                                        if ( $product->is_purchasable() !== false ){
                                            $have_post = true;
                                        }
                                    }
                                
                                    }
                                    $have_post = true;
                                }    */
                                add_filter('loop_shop_columns', array(
                                    $this,
                                    'change_columns_number'
                                ), 9999);
                            }

                            //if ( ($post_type_choose == 'product' && ((have_posts() && $hide_non_purchasable != "on") || ( $hide_non_purchasable == "on" && $have_post == true )) ) || (have_posts() && $post_type_choose != 'product' ) ) {
                            if (have_posts()) {

                                if ($post_type_choose == 'product') {
                                    do_action('woocommerce_before_shop_loop');
                                }

                                $wp_query_var = $wp_query->query_vars;
                                if ($main_loop && !empty($_GET['product_price'])) {
                                    $wp_query_var['product_price'] = $_GET['product_price'];
                                }

                                if (empty($current_taxonomy) || $current_taxonomy != $wp_query_var['taxonomy']) {
                                    unset($wp_query_var['taxonomy']);
                                    unset($wp_query_var['term']);
                                }

?>
                                <?php if ($main_loop) { ?>
                                <div class="filter-param-tags"></div>
                                <?php
                                } ?>
                                <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                                <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                                <div class="divi-filter-archive-loop main-archive-loop has-result <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>"
                                    data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>"
                                    data-posttype="<?php echo esc_attr($post_type_choose) ?>"
                                    data-layoutid="<?php echo esc_attr($loop_layout) ?>" data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                    data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                 ?>" 
                                    data-sortorder="<?php echo esc_attr($orderby_param) ?>"
                                    data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                    data-sortasc="<?php echo esc_attr($wp_query_var['order']); ?>"
                                    data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                    data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                    data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                    data-include_category="<?php echo esc_attr($include_cats); ?>"
                                    data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                    data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                    data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                    data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                    data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                    data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                    data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                    data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                    data-show_price="<?php echo esc_attr($show_price); ?>"
                                    data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                    data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                    data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                    data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                    data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                    data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                    data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                    data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                    data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                    data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                    <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                    <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                    data-noresults="<?php echo esc_attr($no_results_layout); ?>" 
                                    data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
                                    <div class="divi-filter-loop-container col-desk-<?php echo esc_attr($cols); ?> col-tab-<?php echo esc_attr($columns_tablet); ?> col-mob-<?php echo esc_attr($columns_mobile); ?>">
                                <?php

                                $product_id = null;
                                $class = '';
                                $shortcodes = '';

                                $i = 0;

                                $mas_style = '';
                                if ($fullwidth == 'masonry') {
                                    $mas_style = 'style="grid-auto-rows: 1px;"';
                                }
                                                                   
                                if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation') {

                                    if ($fullwidth == 'off' || $fullwidth == 'masonry') { //grid
                                        echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products bc_product_grid bc_product_' . esc_attr($cols) . ' bc_pro_tab_' . esc_attr($columns_tablet) . ' bc_pro_mob_' . esc_attr($columns_mobile) . ' grid-posts loop-grid" ' . esc_attr($mas_style) . '>';
                                    }
                                    else if ($fullwidth == 'list') {
                                        echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products">';
                                    }
                                }
                                else {
                                    echo '<ul class="et_pb_row_divifilter custom-loop-layout grid-posts loop-grid" ' . esc_attr($mas_style) . '>';
                                }

                                unset($GLOBALS['woocommerce_loop']);

                                $loop_prop = function_exists('wc_get_loop_prop') ? wc_get_loop_prop('total') : true;

                                if (($post_type_choose == 'product' && $loop_prop) || ($post_type_choose != 'product')) {
                                    $loop_layout_content = '';

                                    if ($loop_layout != '') {
                                        $loop_layout_content = get_post_field('post_content', $loop_layout);
                                    }

                                    while (have_posts()) {
                                        the_post();
                                        global $product, $post;
                                        $post_link = get_permalink(get_the_ID());
                                        $product_id = get_the_ID();
                                        
                                        if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ) {
                                                
                                            if (isset($product)) {
                                                if (!($hide_non_purchasable == "on" && (!$product->is_type('grouped') && !$product->is_type('external')) && $product->is_purchasable() === false)) {
                                                    if (get_option('woocommerce_hide_out_of_stock_items') == "yes" && (!$product->managing_stock() && !$product->is_in_stock())) {

                                                    }
                                                    else {
                                                        if ($fullwidth == 'off' || $fullwidth == 'masonry') {

                                                            if ($fullwidth == "masonry") {
                                                                $grid_class = "grid-item";
                                                            }
                                                            else {
                                                                $grid_class = "grid-col";
                                                            }

                                                            echo '<li class="' . esc_attr($grid_class) . ' ' . esc_attr(implode(" ", wc_get_product_class($class, $product_id))) . ' " data-pid="' . esc_attr($product_id) . '">';
?>
                                                        <div class="grid-item-cont">
                                                        <?php
                                                            if ($link_whole_gird == "on") {
?>
                                                            <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr($post_link) ?>">
                                                            <?php
                                                            }

                                                            do_action('de_ajaxfilter_before_shop_loop_item');

                                                            echo apply_filters('the_content', wp_kses_post($loop_layout_content));

                                                            do_action('de_ajaxfilter_after_shop_loop_item');

                                                            if ($link_whole_gird == "on") {
?>
                                                            </div>
                                                            <?php
                                                            }
?>
                                                        </div>
                                                        <?php
                                                            echo '</li>';
                                                        }
                                                        else if ($fullwidth == 'list') {
                                                            echo '<li class="' . esc_attr(implode(" ", wc_get_product_class($class, $product_id))) . ' bc_product" style="width: 100%;margin-right: 0;">';
                                                            if ($link_whole_gird == "on") {
?>
                                                            <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr($post_link) ?>">
                                                            <?php
                                                            }

                                                            echo apply_filters('the_content', wp_kses_post($loop_layout_content));

                                                            if ($link_whole_gird == "on") {
?>
                                                            </div>  
                                                            <?php
                                                            }

                                                            echo '</li>';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        else {
                                            if ($fullwidth == 'off' || $fullwidth == 'masonry') {

                                                if ($fullwidth == "masonry") {
                                                    $grid_class = "grid-item";
                                                }
                                                else {
                                                    $grid_class = "grid-col";
                                                }

                                                echo '<li class="' . esc_attr($grid_class) . '" data-pid="' . esc_attr($product_id) . '">';
                                                echo '<div class="grid-item-cont">';
                                                if ($link_whole_gird == "on") {
?>
                                                    <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr($post_link) ?>">
                                                    <?php
                                                }

                                                echo apply_filters('the_content', wp_kses_post($loop_layout_content));

                                                if ($link_whole_gird == "on") {
?>
                                                    </div>  
                                                    <?php
                                                }
                                                echo '</div>';
                                                echo '</li>';
                                            }
                                            else if ($fullwidth == 'list') {
                                                echo '<li style="width: 100%;margin-right: 0;">';
                                                if ($link_whole_gird == "on") {
?>
                                                    <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr($post_link) ?>">
                                                    <?php
                                                }

                                                echo apply_filters('the_content', $loop_layout_content);

                                                if ($link_whole_gird == "on") {
?>
                                                        </div>  
                                                        <?php
                                                }

?>
                                                    <?php
                                                echo '</li>';
                                            }
                                        }
                                    } // endwhile
                                    
                                }

                                echo '</ul>';

                                echo '</div>';
                                echo '</div>';
                                echo '</div>';

                                if ($enable_loadmore != 'pagination') {
                                    remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                                }
                                else {
                                    add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                                }

                                if ( $enable_loadmore != 'pagination' && $post_type_choose == 'product' && $results_count_position == 'bottom' ) {
                                    do_action('woocommerce_after_shop_loop');
                                }

                                //woocommerce_product_loop_end();
                                if ('pagination' === $enable_loadmore) {
                                    if ($post_type_choose == 'product') {
                                        do_action('woocommerce_after_shop_loop');
                                    }
                                    else {
?>
                                        <div class="divi-filter-pagination"><?php echo paginate_links(array(
                                            'type' => 'list'
                                        )); ?></div>
                        <?php
                                    }
                                }
                                else if ('on' === $enable_loadmore) {
                                    if ($wp_query->max_num_pages > 1) {
?>
                                    <div class="dmach-loadmore et_pb_button"><?php echo esc_html($loadmore_text) ?></div>
                        <?php
                                    }
                                }

                                wp_reset_query();

                                if ($equal_height_mob == "off") {
?>
                            <style>@media only screen and (max-width:767px) {.woocommerce .et_pb_db_filter_loop.same-height-cards ul.products li.product {height: auto!important}}</style>
                        <?php
                                }
                            }
                            else {
                                $wp_query_var = $wp_query->query_vars;
                                if ($main_loop && !empty($_GET['product_price'])) {
                                    $wp_query_var['product_price'] = $_GET['product_price'];
                                }
?>
                            <?php if ($main_loop) { ?><div class="filter-param-tags"></div><?php
                                } ?>
                            <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                            <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                            <div class="divi-filter-archive-loop main-archive-loop no-results-layout <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>" 
                            data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>"
                                    data-layoutid="<?php echo esc_attr($loop_layout) ?>"  data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                    data-posttype="<?php echo esc_attr($post_type_choose) ?>"
                                    data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                 ?>"
                                    data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                    data-sortorder="<?php echo esc_attr($orderby_param); ?>"
                                    data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                    data-sortasc="<?php echo esc_attr($wp_query_var['order']) ?>"
                                    data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                    data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                    data-include_category="<?php echo esc_attr($include_cats); ?>"
                                    data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                    data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                    data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                    data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                    data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                    data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                    data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                    data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                    data-show_price="<?php echo esc_attr($show_price); ?>"
                                    data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                    data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                    data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                    data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                    data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                    data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                    data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                    data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                    data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                    data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                    <?php echo ($post_type_choose != 'product' && $post_type_choose != 'product_variation' && $enable_loadmore == 'pagination') ? ' data-loadmore="pagination"' : ''; ?>
                                    <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                    <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                    data-noresults="<?php echo esc_attr($no_results_layout); ?>" 
                                    data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
                        <?php
                                if ($fullwidth == 'off' || $fullwidth == 'masonry') { //grid
                                    echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products bc_product_grid bc_product_' . esc_attr($cols) . ' bc_pro_tab_' . esc_attr($columns_tablet) . ' bc_pro_mob_' . esc_attr($columns_mobile) . '">';
                                }
                                else if ($fullwidth == 'list') {
                                    echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products">';
                                }

                                if ($no_results_layout == 'none') {
                                    if (et_is_builder_plugin_active()) {
                                        if(defined('ET_BUILDER_PLUGIN_DIR')){
                                        include (ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php');
                                    }
                                    }
                                    else {
                                        get_template_part('includes/no-results', 'index');
                                    }
                                }
                                else {
                                    echo apply_filters('the_content', get_post_field('post_content', wp_kses_post($no_results_layout)));
                                }
?>
                                </ul>
                            </div>
                            </div>
                        <?php
                            }
                        }

                        wp_reset_query();

                        $posts = ob_get_contents();

                        ob_end_clean();

                        $class = " et_pb_module et_pb_bg_layout_{$background_layout}";

                        $output = sprintf('<div%4$s class="%1$s%3$s%5$s"%6$s>
                            %2$s</div>', ($fullwidth == 'list' ? 'et_pb_posts' : 'et_pb_blog_grid clearfix'), $posts, esc_attr($class), ('' !== $module_id ? sprintf(' id="%1$s"', esc_attr($module_id)) : ''), ('' !== $module_class ? sprintf(' %1$s', esc_attr($module_class)) : ''), ('on' !== $fullwidth ? ' data-columns' : ''));

                        if ('off' == $fullwidth) {
                            $output = sprintf('<div class="et_pb_blog_grid_wrapper">%1$s</div>', $output);
                        }
                        else if ('list' == $fullwidth) {
                            $output = sprintf('<div class="et_pb_woo_list_wrapper">%1$s</div>', $output);
                        }

                        return $output;

                    } // END CUSTOM LAYOUT
                    // DEFAULT
                    else if ($cat_loop_style == "on") {

                        if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ) {
                            
                            $product_taxonomies = get_object_taxonomies( 'product' );

                            if ($main_loop) {
                                foreach ($product_taxonomies as $tax_name) {
                                    if (!empty($_GET[$tax_name])) {
                                        $query_val = $_GET[$tax_name];
                                        $query_val_array = explode(';', $query_val);
                                        if (count($query_val_array) > 1) {
                                            $terms = get_terms(array(
                                                'taxonomy' => $tax_name,
                                                'hide_empty' => true
                                            ));
                                            $term_id_array = array();
                                            foreach ($terms as $term) {
                                                $term_slug = floatval(str_replace('-', '.', $term->slug));
                                                if ($term_slug >= $query_val_array[0] && $term_slug <= $query_val_array[1]) {
                                                    $term_id_array[] = $term->term_id;
                                                }
                                            }
                                            if (!empty($args['tax_query'])) {
                                                $args['tax_query'][] = array(
                                                    'taxonomy' => $tax_name,
                                                    'field' => 'term_id',
                                                    'terms' => $term_id_array,
                                                    'operator' => 'IN'
                                                );
                                            }
                                        }
                                        else {
                                            $val_and_array = explode('|', $_GET[$tax_name]);
                                            if (is_array($val_and_array) && count($val_and_array) > 1) {
                                                $sub_tax_query = array(
                                                    'relation' => 'AND'
                                                );
                                                foreach ($val_and_array as $key => $or_value) {
                                                    $sub_tax_query[] = array(
                                                        'taxonomy' => $tax_name,
                                                        'field' => 'slug',
                                                        'terms' => explode(',', $or_value),
                                                        'operator' => 'IN'
                                                    );
                                                }
                                                $args['tax_query'][] = $sub_tax_query;
                                            }
                                            else {
                                                $args['tax_query'][] = array(
                                                    'taxonomy' => $tax_name,
                                                    'field' => 'slug',
                                                    'terms' => explode(',', $_GET[$tax_name]),
                                                    'operator' => 'IN'
                                                );
                                            }
                                        }
                                    }
                                }
                            }

                            foreach (array(
                                "product_cat",
                                "product_tag"
                            ) as $tax_key) {
                                if ($main_loop && !empty($_GET[$tax_key])) {
                                    unset($args[$tax_key]);
                                    if (!empty($args['taxonomy']) && $args['taxonomy'] == $tax_key) {
                                        unset($args['taxonomy']);
                                        unset($args['term']);
                                    }
                                }
                                else {
                                    if (!empty($args[$tax_key])) {
                                        $args['tax_query'][] = array(
                                            'taxonomy' => $tax_key,
                                            'field' => 'slug',
                                            'terms' => explode(',', $args[$tax_key]),
                                            'operator' => 'IN'
                                        );
                                        unset($args[$tax_key]);
                                        if (!empty($args['taxonomy']) && $args['taxonomy'] == $tax_key) {
                                            unset($args['taxonomy']);
                                            unset($args['term']);
                                        }
                                    }
                                }
                            }

                            if ($main_loop && !empty($_GET['product_price'])) {

                                $price_value = (explode(';', $_GET['product_price']));

                                if (count($price_value) == 1) {
                                    $min_filter_price = 0;
                                    $max_filter_price = floatval($price_value[0]);
                                }
                                else {
                                    $max_filter_price = floatval($price_value[1]);
                                    $min_filter_price = floatval($price_value[0]);
                                }

                                if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
                                    $tax_class = apply_filters('woocommerce_price_filter_widget_tax_class', ''); // Uses standard tax class.
                                    $tax_rates = WC_Tax::get_rates($tax_class);

                                    if ($tax_rates) {
                                        $min_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($min_filter_price, $tax_rates));
                                        $max_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($max_filter_price, $tax_rates));
                                    }
                                }

                                $price_filter_var['is_filter'] = true;
                                $price_filter_var['min_price'] = $min_filter_price;
                                $price_filter_var['max_price'] = $max_filter_price;
                            }

                            if ($main_loop && !empty($_GET['product_weight'])) {
                                foreach ($args['meta_query'] as $key => $meta) {
                                    if (is_array($meta) && !empty($meta['key']) && ('_weight' == $meta['key'])) {
                                        unset($args['meta_query'][strval($key)]);
                                    }
                                    else if (is_array($meta)) {
                                        foreach ($meta as $subkey => $subMeta) {
                                            if (is_array($subMeta) && !empty($subMeta['key']) && ('_weight' == $subMeta['key'])) {
                                                unset($args['meta_query'][strval($key)]);
                                            }
                                        }
                                    }
                                }
                                $range_value = (explode(";", $_GET['product_weight']));

                                if (count($range_value) == 1) {
                                    $args['meta_query'][] = array(
                                        'key' => '_weight',
                                        'value' => $range_value[0],
                                        'type' => 'DECIMAL',
                                        'compare' => '<='
                                    );
                                }
                                else {
                                    $args['meta_query'][] = array(
                                        'key' => '_weight',
                                        'value' => $range_value,
                                        'compare' => 'BETWEEN',
                                        'type' => 'DECIMAL'
                                    );
                                }
                            }

                            if ($main_loop && isset($_GET['product_rating'])) {
                                foreach ($args['meta_query'] as $key => $meta) {
                                    if (is_array($meta) && !empty($meta['key']) && ('_wc_average_rating' == $meta['key'])) {
                                        unset($args['meta_query'][strval($key)]);
                                    }
                                    else if (is_array($meta)) {
                                        foreach ($meta as $subkey => $subMeta) {
                                            if (is_array($subMeta) && !empty($subMeta['key']) && ('_wc_average_rating' == $subMeta['key'])) {
                                                unset($args['meta_query'][strval($key)]);
                                            }
                                        }
                                    }
                                }

                                $product_rating_arr = explode(',', $_GET['product_rating']);

                                if (is_array($product_rating_arr) && count($product_rating_arr) > 1) {
                                    $rating_query = array(
                                        'relation' => 'OR'
                                    );
                                    foreach ($product_rating_arr as $key => $p_rating) {
                                        if ($p_rating == 0) {
                                            $rating_query[] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => $p_rating,
                                            );
                                        }
                                        else {
                                            $rating_query[] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => array(
                                                    $p_rating - 1,
                                                    (int)$p_rating
                                                ),
                                                'type' => 'DECIMAL',
                                                'compare' => 'BETWEEN',
                                            );
                                        }
                                    }
                                    $args['meta_query'][] = $rating_query;
                                }
                                else {
                                    $range_value = (explode(";", $_GET['product_rating']));

                                    if (count($range_value) == 1) {
                                        if ($range_value[0] == 0) {
                                            $args['meta_query'][] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => $range_value[0],
                                            );
                                        }
                                        else {
                                            $args['meta_query'][] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => array(
                                                    $range_value[0] - 1,
                                                    (int)$range_value[0]
                                                ),
                                                'type' => 'DECIMAL',
                                                'compare' => 'BETWEEN'
                                            );
                                        }
                                    }
                                    else {
                                        $args['meta_query'][] = array(
                                            'key' => '_wc_average_rating',
                                            'value' => $range_value,
                                            'compare' => 'BETWEEN',
                                            'type' => 'DECIMAL'
                                        );
                                    }
                                }
                            }

                            if ($main_loop && !empty($_GET['orderby'])) {
                                $orderby_args = WC()
                                    ->query
                                    ->get_catalog_ordering_args();
                                $args = array_merge($args, $orderby_args);
                            }
                        }

                        if ($main_loop && !empty($_GET['page'])) {
                            $args['paged'] = $_GET['page'];
                        }

                        if ( class_exists( 'woocommerce' ) && ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ) ) {
                            $product_visibility_terms = wc_get_product_visibility_term_ids();
                            $product_visibility_not_in = array(
                                is_search() ? $product_visibility_terms['exclude-from-search'] : $product_visibility_terms['exclude-from-catalog']
                            );
                            if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
                                $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
                            }

                            if (!empty($product_visibility_not_in)) {
                                $args['tax_query'][] = array(
                                    'taxonomy' => 'product_visibility',
                                    'field' => 'term_taxonomy_id',
                                    'terms' => $product_visibility_not_in,
                                    'operator' => 'NOT IN',
                                );
                            }
                        }

                        $is_post_type_archive = $wp_query->is_post_type_archive;

                        $args = apply_filters('db_archive_module_args', $args);
                        query_posts($args);

                        $price_filter_var['is_filter'] = false;

                        if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation' ) {
                            $wp_query->set( 'wc_query', 'product_query' );
                        }

                        //$wp_query->is_post_type_archive = $is_post_type_archive;
                        //$wp_query->is_search = $is_search;
                        if ($show_sorting_menu == 'off') {
                            remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                        }
                        else {
                            add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                        }
                        if ($show_results_count == 'off') {
                            remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
                        }
                        else {
                            add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
                        }
                        if ($show_rating == 'off') {
                            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
                        }
                        else {
                            add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
                        }
                        if ($show_price == 'off') {
                            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
                        }
                        else {
                            add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
                        }
                        if ($show_excerpt == 'on') {
                            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8);
                        }
                        if ($show_add_to_cart == 'on') {
                            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9);
                        }
                        if ($enable_loadmore != 'pagination') {
                            remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                        }
                        else {
                            add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                        }

                        add_action('woocommerce_shop_loop_item_title', array(
                            'db_filter_loop_code',
                            'product_details_wrapper_start'
                        ), 0);
                        add_action('woocommerce_after_shop_loop_item', array(
                            'db_filter_loop_code',
                            'product_details_wrapper_end'
                        ), 10);

                        add_action('woocommerce_before_shop_loop_item_title', array(
                            'db_filter_loop_code',
                            'product_image_wrapper_start'
                        ), 0);
                        add_action('woocommerce_before_shop_loop_item_title', array(
                            'db_filter_loop_code',
                            'product_image_wrapper_end'
                        ), 20);

                        // list view
                        if ($display_type == 'list_view') {
                            $this->add_classname('de_db_list_view');
                            $this->columns = 1;
                        }

                        // columns
                        add_filter('loop_shop_columns', array(
                            $this,
                            'change_columns_number'
                        ), 9999);

                        if (!empty($hover_icon)) {
                            $hover_icon_arr = explode('||', $hover_icon);

                            $hover_icon_font_family = (!empty($hover_icon_arr[1]) && $hover_icon_arr[1] == 'fa') ? 'FontAwesome' : 'ETmodules';
                            $hover_icon_font_weight = (!empty($hover_icon_arr[2])) ? $hover_icon_arr[2] : '400';

                            if (class_exists('DEBC_INIT')) {
                                $hover_icon_content = DEBC_INIT::et_icon_css_content(esc_attr($hover_icon));
                            }
                            else if (class_exists('DEDMACH_INIT')) {
                                $hover_icon_content = DEDMACH_INIT::et_icon_css_content(esc_attr($hover_icon));
                            }
                            else {
                                $hover_icon_content = DE_Filter::et_icon_css_content(esc_attr($hover_icon));
                            }

                        }

                        // show add to cart
                        if ($show_add_to_cart == 'on') {
                            // add to cart button icon and background
                            if ($custom_add_to_cart_button == 'on') {
                                // button icon
                                if ($add_to_cart_button_icon !== '') {

                                    $addToCartIconSelector = '';
                                    if ($add_to_cart_button_icon_placement == 'right') {
                                        $addToCartIconSelector = '%%order_class%% li.product .button:after';
                                    }
                                    elseif ($add_to_cart_button_icon_placement == 'left') {
                                        $addToCartIconSelector = '%%order_class%% li.product .button:before';
                                    }

                                    $hover_icon_arr = explode('||', $hover_icon);

                                    $hover_icon_font_family = (!empty($hover_icon_arr[1]) && $hover_icon_arr[1] == 'fa') ? 'FontAwesome' : 'ETmodules';
                                    $hover_icon_font_weight = (!empty($hover_icon_arr[2])) ? $hover_icon_arr[2] : '400';

                                    if (!empty($hover_icon_content) && !empty($addToCartIconSelector)) {
                                        ET_Builder_Element::set_style($render_slug, array(
                                            'selector' => $addToCartIconSelector,
                                            'declaration' => "content: '{$hover_icon_content}'!important;font-family:{$hover_icon_font_family}!important;font-weight:{$hover_icon_font_weight};"
                                        ));
                                    }
                                }

                                // button background
                                if (!empty($add_to_cart_button_bg_color)) {
                                    ET_Builder_Element::set_style($render_slug, array(
                                        'selector' => 'body #page-container %%order_class%% .button',
                                        'declaration' => "background-color:" . esc_attr($add_to_cart_button_bg_color) . "!important;",
                                    ));
                                }
                            }
                        }

                        if ($use_overlay == 'off') {
                            $this->add_classname('hide_overlay');
                        }
                        elseif ($use_overlay == 'on') {
                            // icon
                            if (!empty($hover_icon)) {
                                $icon_color = !(empty($icon_hover_color)) ? 'color: ' . esc_attr($icon_hover_color) . ';' : '';

                                ET_Builder_Element::set_style($render_slug, array(
                                    'selector' => '%%order_class%% .et_overlay:before, %%order_class%% .et_pb_extra_overlay:before',
                                    'declaration' => "content: '{$hover_icon_content}'; font-family: {$hover_icon_font_family}!important;font-weight:{$hover_icon_font_weight};{$icon_color}",
                                ));
                            }

                            // hover background color
                            if (!empty($hover_overlay_color)) {

                                ET_Builder_Element::set_style($render_slug, array(
                                    'selector' => '%%order_class%% .et_overlay, %%order_class%% .et_pb_extra_overlay',
                                    'declaration' => "background: " . esc_attr($hover_overlay_color) . ";",
                                ));
                            }
                        }

                        // stars color
                        if (!empty($stars_color)) {
                            ET_Builder_Element::set_style($render_slug, array(
                                'selector' => 'body.woocommerce %%order_class%% .star-rating span:before, body.woocommerce-page %%order_class%% .star-rating span:before, %%order_class%% .star-rating span:before',
                                'declaration' => "color: " . esc_attr($stars_color) . "!important;",
                            ));
                        }

                        if ('' !== $sale_badge_color) {
                            ET_Builder_Element::set_style($render_slug, array(
                                'selector' => '%%order_class%% span.onsale',
                                'declaration' => sprintf('background-color: %1$s !important;', esc_html($sale_badge_color)),
                            ));
                        }

                        if ('' !== $product_background) {
                            ET_Builder_Element::set_style($render_slug, array(
                                'selector' => "%%order_class%% .products .product",
                                'declaration' => sprintf('background-color: %1$s !important;', esc_html($product_background)),
                            ));
                        }

                        if ('' !== $product_padding) {
                            ET_Builder_Element::set_style($render_slug, array(
                                'selector' => "%%order_class%% .products .product",
                                'declaration' => sprintf('padding: %1$s !important;', esc_html($product_padding)),
                            ));
                        }

                        if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation'){
                            /**
                             * Products Loop Start
                             * If the module is used inside a product archive page, load the default loop to maintain compatibility with 3rd party plugins
                             * But if the module is used in any other page, use the [products] shortcode
                             *
                             */
                            if ((function_exists('is_product_taxonomy') && is_product_taxonomy()) || (function_exists('is_shop') && is_shop())) {
                                ob_start();
                                /**
                                 * This loop is from archive-product.php
                                 * @version 3.4.0 => WC
                                 */
                                if (have_posts()) {

                                    /**
                                     * Hook: woocommerce_before_shop_loop.
                                     *
                                     * @hooked wc_print_notices - 10
                                     * @hooked woocommerce_result_count - 20
                                     * @hooked woocommerce_catalog_ordering - 30
                                     */
                                    do_action('woocommerce_before_shop_loop');
                                    $wp_query_var = $wp_query->query_vars;
                                    if ($main_loop && !empty($_GET['product_price'])) {
                                        $wp_query_var['product_price'] = $_GET['product_price'];
                                    }

                                    $orderby_param = $wp_query_var['orderby'];
                                    $sorttype = 'string';

                                    if ($orderby_param == 'meta_value_num') {
                                        $sorttype = 'num';
                                    }

                                    if (strpos($orderby_param, 'meta_value') === 0) {
                                        $orderby_param = $wp_query_var['meta_key'];
                                    }
?>
                                    <?php if ($main_loop) { ?><div class="filter-param-tags"></div><?php
                                    } ?>
                                    <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                                    <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                                    <div class="divi-filter-archive-loop main-archive-loop has-result <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>" 
                                    data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>"
                                        data-layoutid="<?php echo esc_attr($loop_layout) ?>" data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                        data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                     ?>"
                                        data-sortorder="<?php echo esc_attr($orderby_param); ?>"
                                        data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                        data-posttype="<?php echo esc_attr($post_type_choose) ?>"
                                        data-sortasc="<?php echo esc_attr($wp_query_var['order']) ?>"
                                        data-noresults="<?php echo esc_attr($no_results_layout); ?>"
                                        data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                        data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                        data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                        data-include_category="<?php echo esc_attr($include_cats); ?>"
                                        data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                        data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                        data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                        data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                        data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                        data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                        data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                        data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                        data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                        data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                        data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                        data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                        data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                        data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                        data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                        data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                        data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                        data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                        <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                        <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                        data-show_price="<?php echo esc_attr($show_price); ?>"
                                        data-show_excerpt="<?php echo esc_attr($show_excerpt); ?>"
                                        data-show_add_to_cart="<?php echo esc_attr($show_add_to_cart); ?>" 
                                        data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
                                        <div class="divi-filter-loop-container default-layout">
                                     <?php
                                    woocommerce_product_loop_start();

                                    if (function_exists('wc_get_loop_prop') && wc_get_loop_prop('total')) {
                                        while (have_posts()) {
                                            the_post();

                                            /**
                                             * Hook: woocommerce_shop_loop.
                                             *
                                             * @hooked WC_Structured_Data::generate_product_data() - 10
                                             */
                                            do_action('woocommerce_shop_loop');

                                            wc_get_template_part('content', 'product');
                                        }
                                    }

                                    woocommerce_product_loop_end();
                                    echo '</div>';

                                    echo '</div>';

                                    echo '</div>';

                                    /**
                                     * Hook: woocommerce_after_shop_loop.
                                     *
                                     * @hooked woocommerce_pagination - 10
                                     */
                                    if ( $enable_loadmore == 'pagination') {
                                        if ( $post_type_choose == 'product' || $post_type_choose == 'product_variation'){
                                            do_action( 'woocommerce_after_shop_loop' );
                                        }else{
                            ?>
                                            <div class="divi-filter-pagination"><?php echo paginate_links(array('type' => 'list')); ?></div>
                            <?php
                                        }
                                    }
                                    else if ('on' === $enable_loadmore) {
                                        if ($wp_query->max_num_pages > 1) {
?>
                                        <div class="dmach-loadmore et_pb_button"><?php echo esc_html($loadmore_text) ?></div>
                            <?php
                                        }
                                    }
                                }
                                else {
                                    /**
                                     * Hook: woocommerce_no_products_found.
                                     *
                                     * @hooked wc_no_products_found - 10
                                     */
                                    $wp_query_var = $wp_query->query_vars;
                                    if ($main_loop && !empty($_GET['product_price'])) {
                                        $wp_query_var['product_price'] = $_GET['product_price'];
                                    }

                                    $orderby_param = $wp_query_var['orderby'];
                                    $sorttype = 'string';

                                    if ($orderby_param == 'meta_value_num') {
                                        $sorttype = 'num';
                                    }

                                    if (strpos($orderby_param, 'meta_value') === 0) {
                                        $orderby_param = $wp_query_var['meta_key'];
                                    }

?>
                                    <?php if ($main_loop) { ?><div class="filter-param-tags"></div><?php
                                    } ?>
                                    <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                                    <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                                    <div class="divi-filter-archive-loop main-archive-loop no-result-layout <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>" 
                                    data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>"
                                        data-layoutid="<?php echo esc_attr($loop_layout) ?>" data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                        data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                     ?>"
                                        data-posttype="<?php echo esc_attr($post_type_choose) ?>"
                                        data-sortorder="<?php echo esc_attr($orderby_param); ?>"
                                        data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                        data-sortasc="<?php echo esc_attr($wp_query_var['order']) ?>"
                                        data-noresults="<?php echo esc_attr($no_results_layout); ?>"
                                        data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                        data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                        data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                        data-include_category="<?php echo esc_attr($include_cats); ?>"
                                        data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                        data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                        data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                        data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                        data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                        data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                        data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                        data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                        data-show_price="<?php echo esc_attr($show_price); ?>"
                                        data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                        data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                        data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                        data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                        data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                        data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                        data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                        <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                        <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                        data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                        data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                        data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                        data-show_excerpt="<?php echo esc_attr($show_excerpt); ?>"
                                        data-show_add_to_cart="<?php echo esc_attr($show_add_to_cart); ?>" 
                                        data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
                                <?php
                                    do_action('woocommerce_no_products_found');
                                    echo '</div>';
                                    echo '</div>';
                                }
                                $loop = ob_get_clean();
                                $loop = "<div class='woocommerce default-style columns-" . (int)$this->columns . "'>" . $loop . "</div>";
                            }
                            else {

                                $wp_query_var = $wp_query->query_vars;
                                if ($main_loop && !empty($_GET['product_price'])) {
                                    $wp_query_var['product_price'] = $_GET['product_price'];
                                }

                                $orderby_param = $wp_query_var['orderby'];
                                $sorttype = 'string';

                                if ($orderby_param == 'meta_value_num') {
                                    $sorttype = 'num';
                                }

                                if (strpos($orderby_param, 'meta_value') === 0) {
                                    $orderby_param = $wp_query_var['meta_key'];
                                }

                                if (is_search()) {

                                    $wp_query_var['s'] = get_search_query();

                                    ob_start();
?>
                                    <?php if ($main_loop) { ?><div class="filter-param-tags"></div><?php
                                    } ?>
                                    <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                                    <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                                    <div class="divi-filter-archive-loop main-archive-loop has-result <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>" 
                                    data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>"
                                        data-layoutid="<?php echo esc_attr($loop_layout) ?>" data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                        data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                     ?>"
                                        data-posttype="<?php echo esc_attr($post_type_choose) ?>"
                                        data-sortorder="<?php echo esc_attr($orderby_param); ?>"
                                        data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                        data-sortasc="<?php echo esc_attr($wp_query_var['order']) ?>"
                                        data-noresults="<?php echo esc_attr($no_results_layout); ?>"
                                        data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                        data-show_price="<?php echo esc_attr($show_price); ?>"
                                        data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                        data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                        data-include_category="<?php echo esc_attr($include_cats); ?>"
                                        data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                        data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                        data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                        data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                        data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                        data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                        data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                        data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                        data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                        data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                        data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                        data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                        data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                        data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                        data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                        <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                        <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                        data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                        data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                        data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                        data-show_excerpt="<?php echo esc_attr($show_excerpt); ?>"
                                        data-show_add_to_cart="<?php echo esc_attr($show_add_to_cart); ?>" 
                                        data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
                                    <?php

?>
                                    <div class="reporting_args" style="white-space: pre;">
                                          <?php print_r(get_search_query()); ?>
                                    </div>
                                      <?php
                                    echo '</div>';
                                    echo '</div>';
                                    $loop = ob_get_clean();
                                }
                                else {
                                    ob_start();
?>
                                <?php if ($main_loop) { ?><div class="filter-param-tags"></div><?php
                                    } ?>
                                <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                                <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                                <div class="divi-filter-archive-loop main-archive-loop has-result <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>" 
                                data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>"
                                    data-layoutid="<?php echo esc_attr($loop_layout) ?>" data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                    data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                     ?>"
                                    data-posttype="<?php echo esc_attr($post_type_choose) ?>"
                                    data-sortorder="<?php echo esc_attr($orderby_param); ?>"
                                    data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                    data-sortasc="<?php echo esc_attr($wp_query_var['order']) ?>"
                                    data-noresults="<?php echo esc_attr($no_results_layout); ?>"
                                    data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                    data-show_price="<?php echo esc_attr($show_price); ?>"
                                    data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                    data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                    data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                    data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                    data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                    data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                    data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                    data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                    data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                    data-include_category="<?php echo esc_attr($include_cats); ?>"
                                    data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                    data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                    data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                    data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                    data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                    data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                    data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                    data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                    data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                    data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                    data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                    <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                    <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                    data-show_excerpt="<?php echo esc_attr($show_excerpt); ?>"
                                    data-show_add_to_cart="<?php echo esc_attr($show_add_to_cart); ?>" 
                                    data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
                                    <div class="divi-filter-loop-container col-desk-<?php echo esc_attr($cols); ?> col-tab-<?php echo esc_attr($columns_tablet); ?> col-mob-<?php echo esc_attr($columns_mobile); ?>">
                                <?php
                                    $columns = esc_attr($this->columns);
                                    global $shortname; // theme name
                                    $limit = function_exists('et_get_option') ? (int)et_get_option($shortname . '_woocommerce_archive_num_posts', '9') : 9;
                                    $pagination = $enable_loadmore == 'pagination' ? 'true' : 'false';

                                    $shortcode = "[products columns='{$columns}' limit='{$limit}' paginate='{$pagination}']";
                                    echo do_shortcode($shortcode);
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    $loop = ob_get_clean();

                                }
                            }

                            /* Products Loop Start */

                            /* reset in case the module used twice start */
                            if ($show_sorting_menu == 'off') {
                                add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                            }
                            if ($show_results_count == 'off') {
                                add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
                            }
                            if ($show_rating == 'off') {
                                add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
                            }
                            if ($show_price == 'off') {
                                add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
                            }
                            if ($show_excerpt == 'on') {
                                remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8);
                            }
                            if ($show_add_to_cart == 'on') {
                                remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9);
                            }
                            if ($enable_loadmore != 'pagination') {
                                add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
                            }

                            remove_filter('loop_shop_columns', array(
                                $this,
                                'change_columns_number'
                            ), 9999);
                            remove_action('woocommerce_shop_loop_item_title', array(
                                'db_filter_loop_code',
                                'product_details_wrapper_start'
                            ), 0);
                            remove_action('woocommerce_after_shop_loop_item', array(
                                'db_filter_loop_code',
                                'product_details_wrapper_end'
                            ), 10);
                            remove_action('woocommerce_before_shop_loop_item_title', array(
                                'db_filter_loop_code',
                                'product_image_wrapper_start'
                            ), 0);
                            remove_action('woocommerce_before_shop_loop_item_title', array(
                                'db_filter_loop_code',
                                'product_image_wrapper_end'
                            ), 20);

                        }
                        else {
                            ob_start();
                            /**
                             * This loop is from archive-product.php
                             * @version 3.4.0 => WC
                             */
                            if (have_posts()) {
                                $wp_query_var = $wp_query->query_vars;
                                if ($main_loop && !empty($_GET['product_price'])) {
                                    $wp_query_var['product_price'] = $_GET['product_price'];
                                }
                                $orderby_param = $wp_query_var['orderby'];
                                $sorttype = 'string';

                                if ($orderby_param == 'meta_value_num') {
                                    $sorttype = 'num';
                                }

                                if (strpos($orderby_param, 'meta_value') === 0) {
                                    $orderby_param = $wp_query_var['meta_key'];
                                }
                                ob_start();
?>
                                <?php if ($main_loop) { ?><div class="filter-param-tags"></div><?php
                                } ?>
                                <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                                <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                                <div class="divi-filter-archive-loop main-archive-loop has-result <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>"
                                data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>" 
                                    data-layoutid="<?php echo esc_attr($loop_layout) ?>" data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                    data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                 ?>"
                                    data-posttype="<?php echo esc_attr($post_type_choose); ?>"
                                    data-sortorder="<?php echo esc_attr($orderby_param); ?>"
                                    data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                    data-sortasc="<?php echo esc_attr($wp_query_var['order']) ?>"
                                    data-noresults="<?php echo esc_attr($no_results_layout); ?>"
                                    data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                    data-show_price="<?php echo esc_attr($show_price); ?>"
                                    data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                    data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                    data-include_category="<?php echo esc_attr($include_cats); ?>"
                                    data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                    data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                    data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                    data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                    data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                    data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                    data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                    data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                    data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                    data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                    data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                    data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                    data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                    data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                    data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                    data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                    data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                    data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                    <?php echo ($post_type_choose != 'product' && $post_type_choose != 'product_variation' && $enable_loadmore == 'pagination') ? ' data-loadmore="pagination"' : ''; ?>
                                    <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                    <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                    data-show_excerpt="<?php echo esc_attr($show_excerpt); ?>"
                                    data-show_add_to_cart="<?php echo esc_attr($show_add_to_cart); ?>" 
                                    data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
<?php
                                while (have_posts()) {
                                    the_post();
                                    if ( $post_type_choose == 'product_variation' ) {
                                        get_template_part( 'single', 'product' );
                                    } else {
                                        get_template_part( 'single', $post_type_choose );
                                    }
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                            else {
                                $wp_query_var = $wp_query->query_vars;
                                if ($main_loop && !empty($_GET['product_price'])) {
                                    $wp_query_var['product_price'] = $_GET['product_price'];
                                }
                                $orderby_param = $wp_query_var['orderby'];
                                $sorttype = 'string';

                                if ($orderby_param == 'meta_value_num') {
                                    $sorttype = 'num';
                                }

                                if (strpos($orderby_param, 'meta_value') === 0) {
                                    $orderby_param = $wp_query_var['meta_key'];
                                }
                                ob_start();
?>
                                <?php if ($main_loop) { ?><div class="filter-param-tags"></div><?php
                                } ?>
                                <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_attr($filter_update_animation) ?>">
                                <div class="filtered-posts-loading <?php echo esc_attr($filter_update_animation) ?> "></div>
                                <div class="divi-filter-archive-loop main-archive-loop no-results-layout <?php echo $main_loop ? 'main-loop' : ''; ?> <?php echo esc_attr($fullwidth) ?>" 
                                data-link_wholegrid="<?php echo esc_attr($link_whole_gird) ?>"
                                    data-layoutid="<?php echo esc_attr($loop_layout) ?>" data-columnscount="<?php echo esc_attr($this->columns) ?>" 
                                    data-filter-var="<?php echo htmlspecialchars(json_encode($wp_query_var)); // phpcs:ignore
                                 ?>"
                                    data-posttype="<?php echo esc_attr($post_type_choose); ?>"
                                    data-sortorder="<?php echo esc_attr($orderby_param); ?>"
                                    data-sorttype="<?php echo esc_attr($sorttype); ?>"
                                    data-sortasc="<?php echo esc_attr($wp_query_var['order']); ?>"
                                    data-noresults="<?php echo esc_attr($no_results_layout); ?>"
                                    data-show_rating="<?php echo esc_attr($show_rating); ?>"
                                    data-show_price="<?php echo esc_attr($show_price); ?>"
                                    data-pagi_scrollto="<?php echo esc_attr($scrollto); ?>"
                                    data-gridstyle="<?php echo esc_attr($fullwidth) ?>"
                                    data-postnumber="<?php echo esc_attr($posts_number) ?>"
                                    data-max-page="<?php echo esc_attr($wp_query->max_num_pages); ?>"
                                    data-btntext="<?php echo esc_attr($loadmore_text) ?>"
                                    data-btntext_loading="<?php echo esc_attr($loadmore_text_loading) ?>"
                                    data-loadmore="<?php echo esc_attr($enable_loadmore) ?>"
                                    data-masonry_ajax_buffer="<?php echo esc_attr($masonry_ajax_buffer) ?>"
                                    data-include_category="<?php echo esc_attr($include_cats); ?>"
                                    data-include_tag="<?php echo esc_attr($include_tags); ?>"
                                    data-include_taxomony="<?php echo esc_attr($custom_tax_choose); ?>"
                                    data-include_term="<?php echo esc_attr($include_taxomony); ?>"
                                    data-onload_cats="<?php echo esc_attr($onload_cats); ?>"
                                    data-onload_tags="<?php echo esc_attr($onload_tags); ?>"
                                    data-onload_tax="<?php echo esc_attr($onload_tax_choose); ?>"
                                    data-onload_terms="<?php echo esc_attr($onload_taxomony); ?>"
                                    data-exclude_category="<?php echo esc_attr($exclude_cats); ?>"
                                    data-pagi_scrollto_fine="<?php echo esc_attr($scrollto_fine_tune); ?>"
                                    data-show_sort="<?php echo esc_attr($show_sorting_menu); ?>"
                                    data-resultcount="<?php echo esc_attr($show_results_count); ?>"
                                    data-countposition="<?php echo esc_attr($results_count_position); ?>"
                                    <?php echo (!empty($current_taxonomy)) ? ' data-current-taxonomy="' . esc_attr($current_taxonomy) . '"' : ''; ?>
                                    <?php echo (!empty($current_tax_term)) ? ' data-current-taxterm="' . esc_attr($current_tax_term) . '"' : ''; ?>
                                    data-show_excerpt="<?php echo esc_attr($show_excerpt); ?>"
                                    data-show_add_to_cart="<?php echo esc_attr($show_add_to_cart); ?>" 
                                    data-current-page="<?php echo get_query_var('paged') ? filter_var(get_query_var('paged'), FILTER_VALIDATE_INT) : 1; ?>">
                                    <p>No Result</p>
                                </div>
                                </div>
<?php
                            }
                            $loop = ob_get_clean();
                        }

                        $output = $loop;

                        wp_reset_query();

                        return $output;
                    }
                }
            }

            new db_filter_loop_code;
        }
    }

    if (!function_exists('Divi_filter_restore_get_params')) {
        add_action('template_redirect', 'Divi_filter_restore_get_params');

        function Divi_filter_restore_get_params() {
            global $divi_filter_removed_param;
          //if ( !empty( $_GET['filter'] ) && $_GET['filter'] == 'true' ){
            if ( !empty($divi_filter_removed_param) ) {
              foreach ($divi_filter_removed_param as $key => $value ) {
                        $_GET[$key] = $value;
                    }
                }
          //}
         $divi_filter_removed_param = array();
        }
    }

    add_action('wp_enqueue_scripts', 'divi_filter_loop_enqueue_scripts');

    function divi_filter_loop_enqueue_scripts() {
        $ajax_nonce = wp_create_nonce('filter_object');

        wp_enqueue_script('divi-filter-loadmore-js', plugins_url('../../../js/divi-filter-loadmore.min.js', __FILE__), array(
            'jquery'
        ), DE_DF_VERSION);
        wp_localize_script('divi-filter-loadmore-js', 'loadmore_ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'security' => $ajax_nonce
        ));

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

?>
