<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_carousel_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMACH_PRODUCT_URL,
  'author'     => DE_DMACH_AUTHOR,
  'author_uri' => DE_DMACH_URL,
);

                function init() {
                    $this->name       = esc_html__( 'Post Carousel - Divi Machine', 'divi-machine' );
                    $this->slug = 'et_pb_de_mach_carousel';
                    $this->folder_name = 'divi_machine';


                    $this->fields_defaults = array(
                    // 'loop_layout'         => array( 'on' ),
                    );

          $this->settings_modal_toggles = array(
            'general' => array(
              'toggles' => array(
                'main_content' => esc_html__( 'Main Options', 'divi-machine' ),

                'loop_options'    => array(
                  'title' => esc_html__( 'Loop Options', 'divi-machine'),
                  'tabbed_subtoggles' => true,
                  'sub_toggles'       => array(
                    'general'     => array(
                      'name' => esc_html__( 'General', 'divi-machine')
                    ),
                    'include_terms'     => array(
                      'name' => esc_html__( 'Include Terms', 'divi-machine')
                    ),
                    'sorting'     => array(
                      'name' => esc_html__( 'Sorting', 'divi-machine')
                    ),
                  )
                ),

                  'element_options' => esc_html__( 'Element Options', 'divi-machine' ),
                  'grid_options' => esc_html__( 'Grid Options', 'divi-machine' ),
                  'extra_options' => esc_html__( 'Extra Options', 'divi-machine' ),
                  'carousel_settings' => esc_html__( 'Carousel Settings', 'divi-machine' ),
              ),
            ),
            'advanced' => array(
              'toggles' => array(
                'text' => esc_html__( 'Text', 'divi-machine' ),
                'overlay' => esc_html__( 'Overlay', 'divi-machine' ),
              ),
            ),

          );


                      $this->main_css_element = '%%order_class%%';


                      $this->advanced_fields = array(
                        'fonts' => array(
                          'title' => array(
                            'label'    => esc_html__( 'Default Layout - Title', 'divi-machine' ),
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
                          'excerpt' => array(
                            'label'    => esc_html__( 'Default Layout - Excerpt', 'divi-machine' ),
                            'css'      => array(
                              'main' => "%%order_class%% ul.products li.product .woocommerce-product-details__short-description",
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
                    'background' => array(
                      'settings' => array(
                        'color' => 'alpha',
                      ),
                    ),
                        'button' => array(
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
                        'image' => array(
                          'label'    => esc_html__( 'Default Layout - Image', 'divi-machine' ),
                          'selector' => '%%order_class%% .et_shop_image',
                        ),
                        'overlay' => array(
                          'label'    => esc_html__( 'Default Layout - Overlay', 'divi-machine' ),
                          'selector' => '%%order_class%% .et_overlay,  %%order_class%% .et_pb_extra_overlay',
                        ),
                        'title' => array(
                          'label'    => esc_html__( 'Default Layout - Title', 'divi-machine' ),
                          'selector' => '%%order_class%% .woocommerce-loop-product__title',
                        ),
                      );


            $this->help_videos = array(
            );
          }

                  function get_fields() {

                    $options = DEDMACH_INIT::get_divi_layouts();

                    ///////////////////////////////

                  $acf_fields = DEDMACH_INIT::get_acf_fields();

                    //////////////////////////////


                      $fields = array(
                      'post_type_choose' => array(
                      'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Post Type', 'divi-machine' ),
                        'type'              => 'select',
                        'options'           => et_get_registered_post_type_options( false, false ),
                        'option_category'   => 'configuration',
                        'default'           => 'post',
                        'computed_affects' => array(
                          '__getcarousel',
                        ),
                        'description'       => esc_html__( 'Choose the post type you want to display', 'divi-machine' ),
                      ),
                      'loop_layout' => array(
                        'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Custom Loop Layout', 'divi-machine' ),
                        'type'              => 'select',
                        'option_category'   => 'configuration',
                        'default'           => 'none',
                        'computed_affects' => array(
                          '__getcarousel',
                        ),
                        'options'           => $options,
                        'description'        => esc_html__( 'Choose the layout you have made for each post in the loop.', 'divi-machine' ),
                      ),
// LOOP SETTINGS

                      'post_status' => array(
                        'toggle_slug'       => 'loop_options',
                        'sub_toggle'    => 'general',
                        'option_category'   => 'configuration',
                        'label'             => esc_html__( 'Post Status', 'divi-machine' ),
                        'type'              => 'select',
                        'options'           => array(
                        'publish' => sprintf( esc_html__( 'Publish', 'divi-machine' ) ),
                        'pending' => esc_html__( 'Pending', 'divi-machine' ),
                        'draft' => esc_html__( 'Draft', 'divi-machine' ),
                        'auto-draft' => esc_html__( 'Auto-draft', 'divi-machine' ),
                        'future' => esc_html__( 'Future', 'divi-machine' ),
                        'private' => esc_html__( 'Private', 'divi-machine' ),
                        'inherit' => esc_html__( 'Inherit', 'divi-machine' ),
                        ),
                        'default' => 'publish',
                        'computed_affects' => array(
                          '__getcarousel',
                        ),
                        'description'       => esc_html__( 'Choose the status of the posts you want to show.', 'divi-machine' ),
                      ),

                      'posts_number' => array(
                        'toggle_slug'       => 'loop_options',
                        'sub_toggle'    => 'general',
                        'option_category'   => 'configuration',
                        'label'             => esc_html__( 'Post Count', 'divi-machine' ),
                        'type'              => 'text',
                        'default'           => 10,
                        'description'       => esc_html__( 'Choose how many posts you would like to display per page."', 'divi-machine' ),
                      ),



            'post_display_type' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'general',
              'option_category'   => 'configuration',
              'label'             => esc_html__( 'Post Display Type', 'divi-machine' ),
              'type'              => 'select',
              'options'           => array(
                'default' => sprintf( esc_html__( 'Default', 'divi-machine' ) ),
                'related' => esc_html__( 'Related', 'divi-machine' ),
              ),
              'affects'         => array(
                'related_content',
              ),
              'default' => 'default',
              'description'       => esc_html__( 'Choose the display type. If you want to have related posts for example, we will find posts in the same categories or tags to show.', 'divi-machine' ),
            ),
            
						'show_current_post' => array(
							'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'general',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Include current post?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'default' => 'off',
							'description'       => esc_html__( 'By default we will exclude the current post. If you want to show it in the carousel, enable this.', 'divi-machine' ),
						),

            'related_content' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'general',
              'option_category'   => 'configuration',
              'label'             => esc_html__( 'Related Content', 'divi-machine' ),
              'type'              => 'select',
              'options'           => array(
                'categories' => sprintf( esc_html__( 'Categories', 'divi-machine' ) ),
                'tags' => esc_html__( 'Tags', 'divi-machine' ),
              ),
              'default' => 'categories',
              'depends_show_if' => 'related',
              'description'       => esc_html__( 'Choose what would define the posts to be related.', 'divi-machine' ),
            ),

            'include_current_tax' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'        => 'include_terms',
              'label'             => esc_html__( 'Show Posts of current taxonomy terms on taxonomy page?', 'divi-machine' ),
              'type'              => 'yes_no_button',
              'option_category'   => 'configuration',
              'options'           => array(
                'on'  => esc_html__( 'Yes', 'divi-machine' ),
                'off' => esc_html__( 'No', 'divi-machine' ),
              ),
              'default'           => 'off',
              'description'       => esc_html__( 'Enable this option if you want to show posts of current taxonomy terms only on taxonomy page.', 'divi-machine' ),
            ),
            'include_cats' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'include_terms',
              'option_category'   => 'configuration',
              'label'           => esc_html__( 'Include Categories (comma-seperated)', 'divi-machine' ),
              'type'            => 'text',
              'computed_affects' => array(
                '__getcarousel',
              ),
              'description'     => esc_html__( 'Add a list of categories you want to include to show. This will remove all products that dont have these tags. (comma-seperated)', 'divi-machine' ),
            ),
            'include_tags' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'include_terms',
              'option_category'   => 'configuration',
              'label'           => esc_html__( 'Include Tags (comma-seperated)', 'divi-machine' ),
              'type'            => 'text',
              'computed_affects' => array(
                '__getcarousel',
              ),
              'description'     => esc_html__( 'Add a list of tags that you want to include to show. This will remove all products that dont have these tags. (comma-seperated)', 'divi-machine' ),
            ),

            'custom_tax_choose' => array(
            'toggle_slug'       => 'loop_options',
            'sub_toggle'    => 'include_terms',
              'label'             => esc_html__( 'Choose Your Taxonomy', 'divi-machine' ),
              'type'              => 'select',
              'options'           => get_taxonomies( array( '_builtin' => FALSE ) ),
              'option_category'   => 'configuration',
              'default'           => 'post',
      'depends_show_if'  => 'taxonomy',
              'description'       => esc_html__( 'Choose the custom taxonomy that you have made and want to filter', 'divi-machine' ),
            ),
            'include_taxomony' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'include_terms',
              'option_category'   => 'configuration',
              'label'           => esc_html__( 'Include Custom Taxonomy (comma-seperated)', 'divi-machine' ),
              'type'            => 'text',
              'computed_affects' => array(
                '__getcarousel',
              ),
              'description'     => esc_html__( 'Add a list of values that you want to show - make sure to specify the custom taxonomy above, it will then show the posts that have the values here from that custom taxonomy. (comma-seperated)', 'divi-machine' ),
            ),
            'acf_name' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'include_terms',
              'label'             => esc_html__( 'Include ACF Field', 'divi-machine' ),
              'type'              => 'select',
              'options'           => $acf_fields,
              'default'           => 'none',
              'option_category'   => 'configuration',
              'computed_affects' => array(
                '__getcarousel',
              ),
              'description'       => esc_html__( 'If you want to show posts that only have a specific ACF field value, specify the field here and then the value below', 'divi-machine' ),
            ),
            'acf_value' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'include_terms',
              'option_category'   => 'configuration',
              'label'           => esc_html__( 'Include ACF Value', 'divi-machine' ),
              'type'            => 'text',
              'computed_affects' => array(
                '__getcarousel',
              ),
              'description'     => esc_html__( 'Add the value here, it will show posts only with the value of the ACF field above', 'divi-machine' ),
            ),

      // 'author' => array(
      // 'toggle_slug'       => 'loop_options',
      // 'option_category'   => 'configuration',
      //   'label'           => esc_html__( 'Author/s (comma-seperated)', 'divi-machine' ),
      //   'type'            => 'text',
      //   'description'     => esc_html__( 'Add a list of authors IDs. (comma-seperated)', 'divi-machine' ),
      // ),
      'sort_order' => array(
      'toggle_slug'       => 'loop_options',
      'sub_toggle'    => 'sorting',
      'option_category'   => 'configuration',
        'label'             => esc_html__( 'Sort Order', 'divi-machine' ),
        'type'              => 'select',
        'options'           => array(
        'date' => sprintf( esc_html__( 'Date', 'divi-machine' ) ),
        'title' => esc_html__( 'Title', 'divi-machine' ),
        'ID' => esc_html__( 'ID', 'divi-machine' ),
        'rand' => esc_html__( 'Random', 'divi-machine' ),
        'menu_order' => esc_html__( 'Menu Order', 'divi-machine' ),
        'name' => esc_html__( 'Name', 'divi-machine' ),
        'modified' => esc_html__( 'Modified', 'divi-machine' ),
        'acf_field' => esc_html__( 'ACF Field', 'divi-machine' ),
        'acf_date_picker' => esc_html__( 'ACF Date Picker', 'divi-machine' ),
        ),
        'affects'         => array(
          'acf_sort_field',
          'acf_sort_type',
          'acf_date_picker_field',
          'acf_date_picker_method',
        ),
        'default' => 'date',
        'computed_affects' => array(
          '__getcarousel',
        ),
        'description'       => esc_html__( 'Choose the sort order of the products.', 'divi-machine' ),
      ),
      'acf_sort_field' => array(
        'toggle_slug'       => 'loop_options',
        'sub_toggle'    => 'sorting',
        'label'             => esc_html__( 'ACF Sort Field', 'divi-machine' ),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'option_category'   => 'configuration',
        'depends_show_if' => 'acf_field',
        'description'       => esc_html__( 'Choose your ACF Field to sort by,', 'divi-machine' ),
      ),
      'acf_sort_type'    => array(
        'toggle_slug'       => 'loop_options',
        'sub_toggle'    => 'sorting',
        'label'             => esc_html__( 'ACF Field Value Type', 'divi-filter' ),
        'type'              => 'select',
        'options'           => array(
          'string'      => 'String',
          'numeric'     => 'Numeric',
        ),
        'default'           => 'string',
        'option_category'   => 'configuration',
        'depends_show_if' => 'acf_field',
        'description'       => esc_html__( 'Choose your acf field value type.', 'divi-filter' ),  
      ),
      'acf_date_picker_field' => array(
        'toggle_slug'       => 'loop_options',
        'sub_toggle'    => 'sorting',
        'label'             => esc_html__( 'ACF Date Picker', 'divi-machine' ),
        'type'              => 'select',
        'options'           => $acf_fields,
        'default'           => 'none',
        'option_category'   => 'configuration',
        'depends_show_if' => 'acf_date_picker',
        'description'       => esc_html__( 'Choose your date picker ACF item', 'divi-machine' ),
      ),
      'acf_date_picker_method' => array(
        'toggle_slug'       => 'loop_options',
        'sub_toggle'    => 'sorting',
        'option_category'   => 'configuration',
        'depends_show_if' => 'acf_date_picker',
        'label'             => esc_html__( 'ACF Date Picker Method', 'divi-machine' ),
        'type'              => 'select',
        'options'           => array(
          'default' => esc_html__( 'Default', 'divi-machine' ),
          'today' => sprintf( esc_html__( 'Today Only', 'divi-machine' ) ),
          'today_future' => sprintf( esc_html__( 'Today and in the future', 'divi-machine' ) ),
          'today_30' => sprintf( esc_html__( 'Today and next x days', 'divi-machine' ) ),
          'before_today' => sprintf( esc_html__( 'In the Past', 'divi-machine' ) ),
          'last_week' => sprintf( esc_html__( 'Last 7 days (including today)', 'divi-machine' ) ),
          'past_30' => sprintf( esc_html__( 'Yesterday and past x days', 'divi-machine' ) ),
          
        ),
        'default' => 'default',
        'computed_affects' => array(
          '__getarchiveloop',
        ),
        'description'       => esc_html__( 'Choose the sort order of the products.', 'divi-machine' ),
      ),                  
      'acf_date_picker_custom_day' => array(
        'toggle_slug'       => 'loop_options',
        'sub_toggle'    => 'sorting',
        'option_category'   => 'configuration',
        'label'             => esc_html__( 'x days', 'divi-machine' ),
        'type'              => 'text',
        'default'           => 30,
        'computed_affects' => array(
          '__getarchiveloop',
        ),
        'show_if'         => array( 'acf_date_picker_method' => array( 'today_30', 'past_30') ),
        'description'       => esc_html__( 'Set the number of days you want it to be.', 'divi-machine' ),
      ),



      'order_asc_desc' => array(
      'toggle_slug'       => 'loop_options',
      'sub_toggle'    => 'sorting',
      'option_category'   => 'configuration',
        'label'             => esc_html__( 'Order', 'divi-machine' ),
        'type'              => 'select',
        'options'           => array(
          'ASC' => esc_html__( 'Ascending', 'divi-machine' ),
          'DESC' => sprintf( esc_html__( 'Descending', 'divi-machine' ) ),
        ),
        'default' => 'ASC',
        'computed_affects' => array(
          '__getcarousel',
        ),
        'description'       => esc_html__( 'Choose the sort order of the products.', 'divi-machine' ),
      ),
      // CAROUSEL OPTIONS
      'posts_number_desktop' => array(
        'default'           => 5,
        'label'             => esc_html__( 'Desktop Posts in view', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'computed_affects' => array(
          '__getcarousel',
        ),
        'description'       => esc_html__( 'Define the number of Posts that should be displayed.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),
      'posts_number_desktop_slide' => array(
        'default'           => 1,
        'label'             => esc_html__( 'Desktop Posts to Slide', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Define the number of posts to slide.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),
      'posts_number_tablet' => array(
        'default'           => 4,
        'label'             => esc_html__( 'Tablet Portrait Posts in view', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Define the number of Posts that should be displayed on tablet portrait.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),
      'posts_number_slide_tablet' => array(
        'default'           => 1,
        'label'             => esc_html__( 'Tablet Portrait Posts to Slide', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Define the number of posts to slide on tablet portrait.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),
      'posts_number_tablet_land' => array(
        'default'           => 3,
        'label'             => esc_html__( 'Tablet Landscape Posts in view', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Define  the number of Posts that should be displayed on tablet landscape.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),
      'posts_number_slide_tablet_land' => array(
        'default'           => 1,
        'label'             => esc_html__( 'Tablet Landscape Posts to Slide', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Define the number of posts to slide on tablet landscape.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),
      'posts_number_mobile' => array(
        'default'           => 1,
        'label'             => esc_html__( 'Mobile Posts in view', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Define the number of Posts that should be displayed on mobile.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),
      'posts_number_slide_mobile' => array(
        'default'           => 1,
        'label'             => esc_html__( 'Mobile Images Posts to Slide', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Define the number of posts to slide on mobile.', 'divi-machine' ),
        'toggle_slug'       => 'carousel_settings',
      ),

      'enable_arrows' => array(
        'toggle_slug'       => 'carousel_settings',
        'label'             => esc_html__( 'Enable Arrows?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'           => 'on',
        'description'       => esc_html__( 'Do you want the carousel to have arrows?', 'divi-machine' ),
      ),
      'left_icon' => array(
        'label'               => esc_html__('Previous Icon', 'divi-machine'),
        'type'                => 'select_icon',
        'option_category'     => 'configuration',
        'class'               => array('et-pb-font-icon'),
        'default'             => '%%19%%',
        'toggle_slug'         => 'carousel_settings',
        'show_if' => [
            'enable_arrows' => [ 'on' ],
        ],
        'description'         => esc_html__('Choose an icon to display for the left (previous) icon.', 'divi-machine'),
        'computed_affects' => array(
          '__getcarousel',
        ),
      ),
      'right_icon' => array(
        'label'               => esc_html__('Next Icon', 'divi-machine'),
        'type'                => 'select_icon',
        'option_category'     => 'configuration',
        'class'               => array('et-pb-font-icon'),
        'default'             => '%%20%%',
        'toggle_slug'         => 'carousel_settings',
        'show_if' => [
            'enable_arrows' => [ 'on' ],
        ],
        'description'         => esc_html__('Choose an icon to display for the right (next) icon.', 'divi-machine'),
        'computed_affects' => array(
          '__getcarousel',
        ),
      ),

      'arrows_color' => array(
        'label'             => esc_html__( 'Arrows Color', 'divi-machine' ),
        'type'              => 'color-alpha',
        'custom_color'      => true,
        'show_if' => [
            'enable_arrows' => [ 'on' ],
        ],
        'toggle_slug'       => 'carousel_settings',
      ),

      'enable_dots' => array(
        'toggle_slug'       => 'carousel_settings',
        'label'             => esc_html__( 'Enable Dot Navigation?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'           => 'off',
        'description'       => esc_html__( 'Do you want the carousel to have dot navigation?', 'divi-machine' ),
      ),
'dot_color' => array(
        'label'             => esc_html__( 'Dot Color', 'divi-machine' ),
        'type'              => 'color-alpha',
        'custom_color'      => true,
        'show_if' => [
            'enable_dots' => [ 'on' ],
        ],
        'toggle_slug'       => 'carousel_settings',
      ),
      'dot_color_active' => array(
              'label'             => esc_html__( 'Dot Active Color', 'divi-machine' ),
              'type'              => 'color-alpha',
              'custom_color'      => true,
              'show_if' => [
                  'enable_dots' => [ 'on' ],
              ],
              'toggle_slug'       => 'carousel_settings',
            ),
      'dot_size' => array(
          'label'             => esc_html__( 'Dots size', 'divi-machine' ),
          'type'              => 'range',
          'default'           => '20px',
          'shortcode_default' => '20px',
          'option_category'   => 'configuration',
          'description'       => esc_html__( 'Set the size of the dots.', 'divi-machine' ),
          'toggle_slug'         => 'carousel_settings',
          'show_if' => [
              'enable_dots' => [ 'on' ],
          ],
      ),

            'center_mode' => array(
              'toggle_slug'       => 'carousel_settings',
              'label'             => esc_html__( 'Center Mode?', 'divi-machine' ),
              'type'              => 'yes_no_button',
              'option_category'   => 'configuration',
              'options'           => array(
                'on'  => esc_html__( 'Yes', 'divi-machine' ),
                'off' => esc_html__( 'No', 'divi-machine' ),
              ),
              'default'           => 'off',
              'description'       => esc_html__( 'Enable this if you want center mode?', 'divi-machine' ),
            ),

            
            'center_mode_padding' => array(
              'toggle_slug'       => 'carousel_settings',
              'label'             => esc_html__( 'Center Mode Padding', 'divi-filter' ),
              'type'              => 'range',
              'option_category'   => 'configuration',
              'default'   => '60px',
              'default_unit'    => 'px',
              'show_if' => [
                  'center_mode' => [ 'on' ],
              ],
              'range_settings'  => array(
                  'min'  => '0',
                  'max'  => '300',
                  'step' => '1',
              ),
              'description'       => esc_html__( 'Choose the padding for the center mode', 'divi-filter' ),
            ),

      
      'autoplay_speed' => array(
        'default'           => "",
        'label'             => esc_html__( 'Autoplay and delay', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'If you would like it to autoplay - add the delay time of each slide. To remove autoplay - set no text here. Time in milliseconds, example 5 seconds would be "5000".', 'divi-machine' ),
        'toggle_slug'         => 'carousel_settings',
      ),
      'slide_speed' => array(
        'default'           => "300",
        'label'             => esc_html__( 'Slide speed', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Set the speed of the slide in milliseconds, for example 1 second will be "1000".', 'divi-machine' ),
        'toggle_slug'         => 'carousel_settings',
      ),
      'infinate' => array(
        'toggle_slug'       => 'carousel_settings',
        'label'             => esc_html__( 'Infinite scrolling?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'           => 'off',
        'description'       => esc_html__( 'Do you want your posts to slide infinite so it looks like an endless amount of images.', 'divi-machine' ),
      ),




// ADVANCED OPTIONS
'equal_height' => array(
  'label'             => esc_html__( 'Equal Height Grid Cards', 'divi-machine' ),
  'type'              => 'yes_no_button',
  'option_category'   => 'configuration',
  'options'           => array(
    'on'  => esc_html__( 'Yes', 'divi-machine' ),
    'off' => esc_html__( 'No', 'divi-machine' ),
  ),
  'description' => esc_html__( 'Enable this if you have the grid layout and want all your cards to be the same height.', 'divi-machine' ),
  'toggle_slug'       => 'extra_options',
),
'link_whole_gird' => array(
'toggle_slug'       => 'extra_options',
'label'             => esc_html__( 'Link each layout to product', 'divi-machine' ),
'type'              => 'yes_no_button',
'options'           => array(
'off' => esc_html__( 'No', 'divi-machine' ),
'on'  => esc_html__( 'Yes', 'divi-machine' ),
),
'description'        => esc_html__( 'Enable this if you want to link each loop layout to the single post.', 'divi-machine' ),
),
'align_last_bottom' => array(
'toggle_slug'       => 'extra_options',
'label'             => esc_html__( 'Align last module at the bottom', 'divi-machine' ),
'type'              => 'yes_no_button',
'options'           => array(
'off' => esc_html__( 'No', 'divi-machine' ),
'on'  => esc_html__( 'Yes', 'divi-machine' ),
),
'description'        => esc_html__( 'Enable this to align the last module (probably the add to cart) at the bottom. Works well when using the equal height.', 'divi-machine' ),
),
'__getcarousel' => array(
        'type' => 'computed',
        'computed_callback' => array( 'de_mach_carousel_code', 'get_carousel' ),
        'computed_depends_on' => array(
          'post_type_choose',
          'loop_layout',
          'post_status',
          'include_cats',
          'include_tags',
          'acf_name',
          'acf_value',
          'sort_order',
          'order_asc_desc',
          'posts_number_desktop',
          'left_icon',
          'right_icon',
        ),
      ),


                      );

                      return $fields;
                  }


                  public static function get_carousel ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                    if (!is_admin()) {
                      return;
                    }

            ob_start();

            $loop_layout        = $args['loop_layout'];
            $columns            = $args['posts_number_desktop'];
            $post_type_choose            = $args['post_type_choose'];


            $post_status     = $args['post_status'];
            $include_cats     = $args['include_cats'];
            $include_tags     = $args['include_tags'];
            $acf_name     = $args['acf_name'];
            $acf_value     = $args['acf_value'];
            $sort_order     = $args['sort_order'];
            $order_asc_desc     = $args['order_asc_desc'];

            $show_current_post            = $this->props['show_current_post'];

            $num = mt_rand(100000,999999);
            $css_class_css              = ".carousel_" . $num;
            $css_class              = "carousel_" . $num;


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

          if ( $post_type_choose != '' ) {
            $page_post_type = $post_type_choose;
          }
      
          $post_slug = $page_post_type;
            


            $symbols = array( '21', '22', '23', '24', '25', '26', '27', '28', '29', '2a', '2b', '2c', '2d', '2e', '2f', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '3a', '3b', '3c', '3d', '3e', '3f', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '4a', '4b', '4c', '4d', '4e', '4f', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '5a', '5b', '5c', '5d', '5e', '5f', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '6a', '6b', '6c', '6d', '6e', '6f', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '7a', '7b', '7c', '7d', '7e', 'e000', 'e001', 'e002', 'e003', 'e004', 'e005', 'e006', 'e007', 'e009', 'e00a', 'e00b', 'e00c', 'e00d', 'e00e', 'e00f', 'e010', 'e011', 'e012', 'e013', 'e014', 'e015', 'e016', 'e017', 'e018', 'e019', 'e01a', 'e01b', 'e01c', 'e01d', 'e01e', 'e01f', 'e020', 'e021', 'e022', 'e023', 'e024', 'e025', 'e026', 'e027', 'e028', 'e029', 'e02a', 'e02b', 'e02c', 'e02d', 'e02e', 'e02f', 'e030', 'e103', 'e0ee', 'e0ef', 'e0e8', 'e0ea', 'e101', 'e107', 'e108', 'e102', 'e106', 'e0eb', 'e010', 'e105', 'e0ed', 'e100', 'e104', 'e0e9', 'e109', 'e0ec', 'e0fe', 'e0f6', 'e0fb', 'e0e2', 'e0e3', 'e0f5', 'e0e1', 'e0ff', 'e031', 'e032', 'e033', 'e034', 'e035', 'e036', 'e037', 'e038', 'e039', 'e03a', 'e03b', 'e03c', 'e03d', 'e03e', 'e03f', 'e040', 'e041', 'e042', 'e043', 'e044', 'e045', 'e046', 'e047', 'e048', 'e049', 'e04a', 'e04b', 'e04c', 'e04d', 'e04e', 'e04f', 'e050', 'e051', 'e052', 'e053', 'e054', 'e055', 'e056', 'e057', 'e058', 'e059', 'e05a', 'e05b', 'e05c', 'e05d', 'e05e', 'e05f', 'e060', 'e061', 'e062', 'e063', 'e064', 'e065', 'e066', 'e067', 'e068', 'e069', 'e06a', 'e06b', 'e06c', 'e06d', 'e06e', 'e06f', 'e070', 'e071', 'e072', 'e073', 'e074', 'e075', 'e076', 'e077', 'e078', 'e079', 'e07a', 'e07b', 'e07c', 'e07d', 'e07e', 'e07f', 'e080', 'e081', 'e082', 'e083', 'e084', 'e085', 'e086', 'e087', 'e088', 'e089', 'e08a', 'e08b', 'e08c', 'e08d', 'e08e', 'e08f', 'e090', 'e091', 'e092', 'e0f8', 'e0fa', 'e0e7', 'e0fd', 'e0e4', 'e0e5', 'e0f7', 'e0e0', 'e0fc', 'e0f9', 'e0dd', 'e0f1', 'e0dc', 'e0f3', 'e0d8', 'e0db', 'e0f0', 'e0df', 'e0f2', 'e0f4', 'e0d9', 'e0da', 'e0de', 'e0e6', 'e093', 'e094', 'e095', 'e096', 'e097', 'e098', 'e099', 'e09a', 'e09b', 'e09c', 'e09d', 'e09e', 'e09f', 'e0a0', 'e0a1', 'e0a2', 'e0a3', 'e0a4', 'e0a5', 'e0a6', 'e0a7', 'e0a8', 'e0a9', 'e0aa', 'e0ab', 'e0ac', 'e0ad', 'e0ae', 'e0af', 'e0b0', 'e0b1', 'e0b2', 'e0b3', 'e0b4', 'e0b5', 'e0b6', 'e0b7', 'e0b8', 'e0b9', 'e0ba', 'e0bb', 'e0bc', 'e0bd', 'e0be', 'e0bf', 'e0c0', 'e0c1', 'e0c2', 'e0c3', 'e0c4', 'e0c5', 'e0c6', 'e0c7', 'e0c8', 'e0c9', 'e0ca', 'e0cb', 'e0cc', 'e0cd', 'e0ce', 'e0cf', 'e0d0', 'e0d1', 'e0d2', 'e0d3', 'e0d4', 'e0d5', 'e0d6', 'e0d7', 'e600', 'e601', 'e602', 'e603', 'e604', 'e605', 'e606', 'e607', 'e608', 'e609', 'e60a', 'e60b', 'e60c', 'e60d', 'e60e', 'e60f', 'e610', 'e611', 'e612', 'e008', );

            $left_icon             = $args['left_icon']; // Left Icon
            $right_icon            = $args['right_icon']; // Right Icon

            $left_icon_index   = (int) str_replace( '%', '', $left_icon );
            $rendered_left_icon =  sprintf(
              '\%1$s',
              $symbols[$left_icon_index]
            );

            $right_icon_index   = (int) str_replace( '%', '', $right_icon );
            $right_icon_icon =  sprintf(
              '\%1$s',
              $symbols[$right_icon_index]
            );
            

            // $icon_index   = (int) str_replace( '%', '', $left_icon );
            // // @phpcs:ignore Generic.PHP.ForbiddenFunctions.Found
            // $icon_symbols = 'default' === $symbols_function ? et_pb_get_font_icon_symbols() : call_user_func( $symbols_function );
            // $left_icon    = isset( $icon_symbols[ $icon_index ] ) ? $icon_symbols[ $icon_index ] : '';
          
            // return $font_icon;
         

                    $get_cpt_args = array(
                      'post_type' => $post_slug,
                      'post_status' => $post_status,
                      'posts_per_page' => $columns,
                      'orderby' => $sort_order,
                      'order' => $order_asc_desc,
                  );

                  if ($include_cats != "") {
                    if ($post_type_choose == "post") {
                        $get_cpt_args['category_name'] = $include_cats;
                    } else {

                        if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                            $get_cpt_args['category_name'] = $include_cats;
                        }else{
                            $ending = "_category";
                            $cat_key = $post_type_choose . $ending;
                            if ($cat_key == "product_category") {
                                $cat_key = "product_cat";
                            } else {
                                $cat_key = $cat_key;
                            }

                            $include_cats_arr = explode(',', $include_cats);
                            $get_cpt_args['tax_query'][] = array(
                                'taxonomy'  => $cat_key,
                                'field'     => 'slug',
                                'terms'     => $include_cats_arr,
                                'operator' => 'IN'
                            );  
                        }
                    }
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
            
                    $include_tags_arr = explode(',', $include_tags);
                    $get_cpt_args['tax_query'] = array(
                        array(
                            'taxonomy'  => $cat_key,
                            'field'     => 'slug',
                            'terms'     => $include_tags_arr,
                            'operator' => 'IN'
                        )
                    );
                  }
                }

                  query_posts( $get_cpt_args );


                    if ($loop_layout == "none") {
                        echo "Please create a custom loop layout and specify it in the settings.";
                    } else {

                      if ( have_posts() ) {
                        ?>
                        <div class="<?php echo $css_class ?> dmach_carousel_container">
                        <button class="slick-prev slick-arrow single" type="button">Previous</button>
                        <div class="slick-list draggable">
                          <?php
                        while ( have_posts() ) {
                          the_post();

                        ?>

                            <?php
                            echo apply_filters('the_content', get_post_field('post_content', $loop_layout));
                            ?>


                        <?php
                        } // end while

                        ?>
                        </div>
                        <button class="slick-next slick-arrow single" type="button">Next</button>
                        </div>

                        <style>

                        <?php echo $css_class_css ?>.dmach_carousel_container .slick-prev::before {
                          content: "<?php echo $rendered_left_icon; ?>"; 
                        }
                        <?php echo $css_class_css ?>.dmach_carousel_container .slick-next::before {
                          content: "<?php echo $right_icon_icon; ?>"; 
                        }
                        
                        .slick-next:before, .slick-prev:before {
                          line-height: 1;
                          color: #fff;
                        }
                        .dmach_carousel_container {opacity: 1 !important;}
                        .et_pb_de_mach_acf_slider_containter_nav, .et_pb_de_mach_acf_slider_containter  {
                              position: relative;
                        }
                        .slick-next, .slick-prev {
                            font-size: 0;
                            line-height: 0;
                            position: absolute;
                            top: 50%;
                            display: block;
                            width: 20px;
                            height: 20px;
                            padding: 0;
                            -webkit-transform: translate(0, -50%);
                            -ms-transform: translate(0, -50%);
                            transform: translate(0, -50%);
                            cursor: pointer;
                            color: transparent;
                            border: none;
                            outline: 0;
                            background: 0 0;
                        }
                        .slick-prev {
                            left: -25px;
                        }
                        .slick-next {
                            right: -25px;
                        }
                        .slick-dots {
                            bottom: -50px;
                        }
                        .slick-dots {
                            position: absolute;
                            bottom: -25px;
                            display: block;
                            width: 100%;
                            padding: 0;
                            margin: 0;
                            list-style: none;
                            text-align: center;
                        }
                        .slick-dots, .slick-dots li {
                            list-style-type: none !important;
                        }
                        .slick-dots li {
                            position: relative;
                            display: inline-block;
                            width: 20px;
                            height: 20px;
                            margin: 0 5px;
                            padding: 0;
                            cursor: pointer;
                        }
                        .et_pb_de_mach_acf_slider .slick-dots li button {
                            text-indent: 100%;
                            white-space: nowrap;
                            height: 17px;
                            width: 17px;
                            border-radius: 50%;
                            font-size: 0;
                            cursor: pointer;
                            color: transparent;
                            border: 0;
                            outline: 0;
                            padding: 5px;
                            line-height: 0;
                            display: block;
                        }
                        .slick-dots li button {
                            background: #ececec;
                          }
                        .slick-dots li.slick-active button {
                            background: #000000;
                        }
                        </style>
                        <?php

                        // retrieve the styles for the modules
                        $internal_style = ET_Builder_Element::get_style();
                        // reset all the attributes after we retrieved styles
                        ET_Builder_Element::clean_internal_modules_styles( false );
                        $et_pb_rendering_column_content = false;

                        // append styles
                        if ( $internal_style ) {
                    ?>
                        <div class="dmach-inner-styles">
                    <?php
                            $cleaned_styles = str_replace("#et-boc .et-l","#et-boc .et-l .dmach_carousel_container", $internal_style);
                            $cleaned_styles = str_replace(".et_pb_section_",".dmach_carousel_container .et_pb_section_", $cleaned_styles);
                            $cleaned_styles = str_replace(".et_pb_row_",".dmach_carousel_container .et_pb_row_", $cleaned_styles);
                            $cleaned_styles = str_replace(".et_pb_module_",".dmach_carousel_container .et_pb_module_", $cleaned_styles);
                            $cleaned_styles = str_replace(".et_pb_column_",".dmach_carousel_container .et_pb_column_", $cleaned_styles);
                            $cleaned_styles = str_replace(".et_pb_de_mach_",".dmach_carousel_container .et_pb_de_mach_", $cleaned_styles);
                            $cleaned_styles = str_replace(".dmach_carousel_container .dmach_carousel_container",".dmach_carousel_container", $cleaned_styles);
                            $cleaned_styles = str_replace(".dmach_carousel_container .et_pb_section .dmach_carousel_container",".dmach_carousel_container", $cleaned_styles);

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


                      } // end if

                    }



                      $data = ob_get_clean();

                    return $data;

                    }


                  function render($attrs, $content, $render_slug){

                    if (is_admin()) {
                        return;
                    }

                    /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
                    $titan = TitanFramework::getInstance( 'divi-machine' );*/
                    $enable_debug = de_get_option_value('divi-machine', 'enable_debug'); //$titan->getOption( 'enable_debug' );

                    $loop_layout       = $this->props['loop_layout'];
                    $post_type_choose       = $this->props['post_type_choose'];
                    $post_status       = $this->props['post_status'];

                    $include_current_tax = $this->props['include_current_tax'];
                    $include_cats       = $this->props['include_cats'];
                    $include_tags       = $this->props['include_tags'];
                    


                    $custom_tax_choose           = $this->props['custom_tax_choose'];
                    $include_taxomony           = $this->props['include_taxomony'];

                    // $author       = $this->props['author'];
                    $sort_order       = $this->props['sort_order'];
                    $order_asc_desc       = $this->props['order_asc_desc'];
                    $posts_number       = $this->props['posts_number'];

                    
                $acf_date_picker_field  = $this->props['acf_date_picker_field'];
                $acf_date_picker_method = $this->props['acf_date_picker_method'];
                $acf_date_picker_custom_day = $this->props['acf_date_picker_custom_day'];

                $acf_sort_field         = $this->props['acf_sort_field'];
                $acf_sort_type          = $this->props['acf_sort_type'];

                    $post_display_type      = $this->props['post_display_type'];
                    $related_content  = $this->props['related_content'];


                    $link_whole_gird      = $this->props['link_whole_gird'];

                    $acf_name      = $this->props['acf_name'];
                    $acf_value      = $this->props['acf_value'];


                    $equal_height      = $this->props['equal_height'];
                    $align_last_bottom    = $this->props['align_last_bottom'];


                    $left_icon             = $this->props['left_icon']; // Left Icon
                    $right_icon            = $this->props['right_icon']; // Right Icon

                    $left_icon_rendered = DEDMACH_INIT::et_icon_css_content(esc_attr($left_icon));
                    $right_icon_rendered = DEDMACH_INIT::et_icon_css_content(esc_attr($right_icon));

                    $autoplay_speed           = $this->props['autoplay_speed']; // autoplay_speed
                    $slide_speed           = $this->props['slide_speed']; // slide_speed
                    $arrows_color       = $this->props['arrows_color'];   //Arrows Color

                    $infinate                       = $this->props['infinate'];

                    if ($infinate == "" || $infinate == "off") {
                      $infinate_display = "infinite: false,";
                    } else {
                      if ($infinate == "on") {
                        $infinate = "true";
                      }
                      $infinate_display = "infinite: " . $infinate . ',';
                    };

                    $posts_number_desktop          = $this->props['posts_number_desktop'];                           // desktop number
                    $posts_number_desktop_slide        = $this->props['posts_number_desktop_slide'];                 // desktop number slides
                    $posts_number_tablet          = $this->props['posts_number_tablet'];                             // tablet number
                    $posts_number_slide_tablet          = $this->props['posts_number_slide_tablet'];                 // tablet number slides
                    $posts_number_tablet_land          = $this->props['posts_number_tablet_land'];                   // tablet landscape number
                    $posts_number_slide_tablet_land          = $this->props['posts_number_slide_tablet_land'];       // tablet landscape number slides
                    $posts_number_mobile          = $this->props['posts_number_mobile'];                             // mobile number
                    $posts_number_slide_mobile          = $this->props['posts_number_slide_mobile'];

                    $enable_arrows          = $this->props['enable_arrows'];
                    $enable_dots          = $this->props['enable_dots'];
                    $dot_color          = $this->props['dot_color'];
                    $dot_color_active          = $this->props['dot_color_active'];
                    $dot_size          = $this->props['dot_size'];
                    $center_mode          = $this->props['center_mode'];

                    $center_mode_padding          = $this->props['center_mode_padding'];
                    
                    
                    if ($enable_arrows == "on") {
                      $arrows_display = 'arrows: true,';
                    } else {
                      $arrows_display = 'arrows: false,';
                    }
                    
                    if ($enable_dots == "on") {
                      $dots_display = 'dots: true,';

                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .slick-dots li button',
                        'declaration' => sprintf(
                          'background: %1$s;',
                          esc_html($dot_color)
                        ),
                      ));

                      ET_Builder_Element::set_style($render_slug, array(
                        'selector'    => '%%order_class%% .slick-dots li.slick-active button',
                        'declaration' => sprintf(
                          'background: %1$s;',
                          esc_html($dot_color_active)
                        ),
                      ));

                      ET_Builder_Element::set_style( $render_slug, array(
                            'selector'    => '%%order_class%% .slick-dots li',
                            'declaration' => sprintf(
                                'width: %1$s;height: %1$s;',
                                esc_html( $dot_size )
                            ),
                      ) );

                      ET_Builder_Element::set_style( $render_slug, array(
                            'selector'    => '%%order_class%% .slick-dots li button',
                            'declaration' => sprintf(
                                'width: %1$s;height: %1$s;',
                                esc_html( $dot_size )
                            ),
                      ) );

                    } else {
                      $dots_display = 'dots: false,';
                    }

                    if ($center_mode == "on") {
                      $this->add_classname( 'center_mode');
                      $center_display = 'centerMode: true,centerPadding: "'. $center_mode_padding . '",';
                    } else {
                      $center_display = 'centerMode: false,';
                    }





                                        if ($autoplay_speed != "") {
                                          $autospeed = $autoplay_speed;
                                          $autoplay = "autoplay: true,";
                                        }
                                        else {
                                          $autospeed = "0";
                                          $autoplay = "autoplay: false,";
                                        }

                    $num = mt_rand(100000,999999);
                    $css_class              = $render_slug . "_" . $num;

                    if ( $equal_height == 'on' ) {
                      $this->add_classname('same-height-cards');
                    }
                    if ( $align_last_bottom == 'on' ) {
                      $this->add_classname('align-last-module');
                    }

                    if ( $link_whole_gird == 'on' ) {
                      $this->add_classname('dmach-link-whole-grid');
                    }

                    $left_icon_arr = explode('||', $left_icon);
                    $left_icon_font_family = ( !empty( $left_icon_arr[1] ) && $left_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                    $left_icon_font_weight = ( !empty( $left_icon_arr[2] ))?$left_icon_arr[2]:'400';

                    ET_Builder_Element::set_style($render_slug, array(
                      'selector'    => '%%order_class%% .dmach_carousel_container .slick-prev::before',
                      'declaration' => sprintf(
                        'content: "%1$s";
                        color: %2$s;
                        font-family:%3$s!important;
                        font-weight:%4$s;',
                        esc_html($left_icon_rendered),
                        $arrows_color,
                        $left_icon_font_family,
                        $left_icon_font_weight
                      ),
                    ));

                    $right_icon_arr = explode('||', $right_icon);
                    $right_icon_font_family = ( !empty( $right_icon_arr[1] ) && $right_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                    $right_icon_font_weight = ( !empty( $right_icon_arr[2] ))?$right_icon_arr[2]:'400';
                    
                    ET_Builder_Element::set_style($render_slug, array(
                      'selector'    => '%%order_class%% .dmach_carousel_container .slick-next::before',
                      'declaration' => sprintf(
                        'content: "%1$s";
                        color: %2$s;
                        font-family:%3$s!important;
                        font-weight:%4$s;',
                        esc_html($right_icon_rendered),
                        $arrows_color,
                        $right_icon_font_family,
                        $right_icon_font_weight
                      ),
                    ));

                    wp_enqueue_script( 'dmach-carousel-js',  DE_DMACH_PATH_URL . '/js/carousel.min.js', array(), DE_DMACH_VERSION, true );
                    wp_enqueue_style( 'dmach-carousel-css', DE_DMACH_PATH_URL . '/css/carousel.min.css', array(), DE_DMACH_VERSION );

                  //////////////////////////////////////////////////////////////////////

                    ob_start();


                    $cpt_taxonomies = get_object_taxonomies( $post_type_choose );

                      global $wp_query, $wpdb, $post, $woocommerce;



                      if ($post_display_type == "related") {


                        if (isset($post->ID)) {
                  
                          $tax_array[] = "";
                  
                          if ($post_type_choose == "post") {
                  
                  
                            $args = array(
                              'post_type'         => $post_type_choose,
                              'post_status'       => $post_status,
                              'posts_per_page'    => (int) $posts_number,
                              'orderby'           => $sort_order,
                              'order'             => $order_asc_desc
                            );

                            if ($show_current_post == "off") {
                              $args['post__not_in'] = array($post->ID);
                            }
                  
                            if ($related_content == "categories"){
                  
                              $cats = wp_get_post_terms( $post->ID, 'category' );
                              foreach ( $cats as $cat ) {
                                $tax_array[] = $cat->term_id;
                              }
                  
                              $args['cat'] = $tax_array;
                              
                            } else {
                  
                              $cats = wp_get_post_terms( $post->ID, 'post_tag' );
                              foreach ( $cats as $cat ) {
                                $tax_array[] = $cat->term_id;
                              }
                  
                              if ($post_type_choose == "post") {
                                $args['tag__in'] = $tax_array;
                              } else {
                                $args['tag'] = $tax_array;
                              }
                  
                  
                            }
                  
                  
                          } else {
                  
                  
                            if ($related_content == "categories"){
                  
                              $cats = wp_get_post_terms( $post->ID, $post_type_choose . '_category' );
                              foreach ( $cats as $cat ) {
                                $tax_array[] = $cat->term_id;
                              }
                  
                              $category_name = $post_type_choose . '_category';
                      
                              if ($category_name == "product_category") {
                                $category_name = "product_cat";
                              } else {
                                $category_name = $category_name;
                              }
                  
                            } else {
                  
                              $cats = wp_get_post_terms( $post->ID, $post_type_choose . '_tag' );
                              foreach ( $cats as $cat ) {
                                $tax_array[] = $cat->term_id;
                              }
                  
                              $category_name = $post_type_choose . '_tag';
                      
                              if ($category_name == "product_tag") {
                                $category_name = "product_tag";
                              } else {
                                $category_name = $category_name;
                              }
                  
                            }
                  
                  
                  
                            $args = array(
                              'post_type'         => $post_type_choose,
                              'post_status'       => $post_status,
                              'posts_per_page'    => (int) $posts_number,
                              'orderby'           => $sort_order,
                              'order'             => $order_asc_desc,
                              'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                  'taxonomy' => $category_name,
                                  'field' => 'id',
                                  'terms' => $tax_array
                                )
                              )
                            );

                            if ($show_current_post == "off") {
                              $args['post__not_in'] = array($post->ID);
                            }

                          }
                  
                        }
                  
                  
                      } else {

                        $args = array(
                            'post_type'           => $post_type_choose,
                            'post_status'         => $post_status,
                            'posts_per_page' => (int) $posts_number,
                            'orderby'        => $sort_order,
                            'order' => $order_asc_desc
                        );

                        $args['tax_query']['relation'] = 'AND';
                        $meta_query = array('relation' => 'AND');

                        if ($include_cats != "") {
                            if ($post_type_choose == "post") {
                                $args['category_name'] = $include_cats;
                            } else {

                                if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                                    $args['category_name'] = $include_cats;
                                }else{
                                    $ending = "_category";
                                    $cat_key = $post_type_choose . $ending;
                                    if ($cat_key == "product_category") {
                                        $cat_key = "product_cat";
                                    } else {
                                        $cat_key = $cat_key;
                                    }

                                    $include_cats_arr = explode(',', $include_cats);
                                    $args['tax_query'][] = array(
                                        'taxonomy'  => $cat_key,
                                        'field'     => 'slug',
                                        'terms'     => $include_cats_arr,
                                        'operator' => 'IN'
                                    );  
                                }
                            }
                        }

                        if ($include_tags != "") {

                          if ($post_type_choose == "post") {
                            $args['tag'] = $include_tags;
                          } else {
                            $ending = "_tag";
                            $cat_key = $post_type_choose . $ending;
                            if ($cat_key == "product_tag") {
                              $cat_key = "product_tag";
                            } else {
                              $cat_key = $cat_key;
                            }
                    
                            $include_tags_arr = explode(',', $include_tags);
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy'  => $cat_key,
                                    'field'     => 'slug',
                                    'terms'     => $include_tags_arr,
                                    'operator' => 'IN'
                                )
                            );
                          }
                        }


                        if ($include_taxomony != "") {
          
                          $args['tax_query'][] = array(
                              'taxonomy'  => $custom_tax_choose,
                              'field'     => 'slug',
                              'terms'     => explode(',', $include_taxomony),
                              'operator' => 'IN'
                          );  
                        }

                        if ( $include_current_tax == 'on' ) {
                          $initial_query_vars = $wp_query->query_vars;
                          if ( !empty($initial_query_vars['taxonomy'] ) && !empty( $initial_query_vars['term'] ) ) {
                              $args['tax_query'][] = array(
                                'taxonomy'  => $initial_query_vars['taxonomy'],
                                'field'     => 'slug',
                                'terms'     => explode(',', $initial_query_vars['term']),
                                'operator' => 'IN'
                              );
                          }     
                        }

                        if ($show_current_post == "off") {
                          $args['post__not_in'] = array($post->ID);
                        }

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

                            $args['meta_query'] = $meta_query ?? '';
                        }
                      }
                    
                    // if ($author != "") {
                      //   $args['author_name'] = $author;
                      // }
                      
                      
                      // START SORTING
                      if ($sort_order == 'acf_date_picker') {
                        $acf_get = get_field_object($acf_date_picker_field);
                        if ($acf_date_picker_method == 'today') {
                          $args['meta_key'] = $acf_get['name'];
                          $args['orderby'] = 'meta_value_num';
                          $args['order'] = 'ASC';
                          
                          $meta_query[] = array(
                            'key' => $acf_get['name'],
                            'compare' => '=',
                            'value' => date("Y-m-d"),
                            'type' => 'DATE'
                          );

                        } elseif ($acf_date_picker_method == 'today_future') {
                          $args['meta_key'] = $acf_get['name'];
                          $args['orderby'] = 'meta_value_num';
                          $args['order'] = 'ASC';
                          
                          $meta_query[] = array(
                            'key' => $acf_get['name'],
                            'compare' => '>=',
                            'value' => date("Y-m-d"),
                            'type' => 'DATE'
                          );

                        } elseif ($acf_date_picker_method == 'today_30') {
                          $args['meta_key'] = $acf_get['name'];
                          $args['orderby'] = 'meta_value_num';
                          $args['order'] = 'ASC';
                          
                          $meta_query[] = array(
                            'key' => $acf_get['name'],
                            'compare' => '>=',
                            'value' => date("Y-m-d"),
                            'type' => 'DATE'
                          );
                          
                          $meta_query[] = array(
                            'key' => $acf_get['name'],
                            'compare' => '<=',
                            'value' => date("Y-m-d", strtotime("+".$acf_date_picker_custom_day." days")),
                            'type' => 'DATE'
                          );
                        } elseif ($acf_date_picker_method == 'before_today') {
                          $args['meta_key'] = $acf_get['name'];
                          $args['orderby'] = 'meta_value_num';
                          $args['order'] = $order_asc_desc;
                          
                          $meta_query[] = array(
                            'key' => $acf_get['name'],
                            'compare' => '<=',
                            'value' => date('Y-m-d',strtotime("-1 days")),
                            'type' => 'DATE'
                          );
                        
                        } elseif ($acf_date_picker_method == 'last_week') {
                          $args['meta_key'] = $acf_get['name'];
                          $args['orderby'] = 'meta_value_num';
                          $args['order'] = $order_asc_desc;
                          
                          $meta_query[] = array(
                            'key' => $acf_get['name'],
                            'compare' => 'BETWEEN',
                            'value' => array(date("Y-m-d", strtotime("-7 days")), date("Y-m-d")),
                            'type' => 'DATE'
                          );
                        
                        } elseif ($acf_date_picker_method == 'past_30') {
                          $args['meta_key'] = $acf_get['name'];
                          $args['orderby'] = 'meta_value_num';
                          $args['order'] = $order_asc_desc;
                          
                          $meta_query[] = array(
                            'key' => $acf_get['name'],
                            'compare' => 'BETWEEN',
                            'value' => array(date("Y-m-d", strtotime("-".$acf_date_picker_custom_day." days")), date('Y-m-d',strtotime("-1 days"))),
                            'type' => 'DATE'
                          );
                        
                        } else {
                          if ($acf_get['type'] == 'date_time_picker') {
                            $args['orderby'] = 'meta_value';
                            $args['meta_type'] = 'DATETIME';
                          } else if ( $acf_get['type'] == 'date_picker' ) {
                            $args['orderby'] = 'meta_value_num';  
                          } else {
                            $args['orderby'] = 'meta_value';
                          }
                          $args['meta_key'] = $acf_get['name'];
                          $args['order'] = $order_asc_desc;
                
                        }
                      } else if ( $sort_order == "acf_field") {
                        $acf_get = get_field_object($acf_sort_field);
                        if ( $acf_sort_type == 'string' ) {
                          $args['orderby'] = 'meta_value';
                        } else if ( $acf_sort_type == 'numeric') {
                          $args['orderby'] = 'meta_value_num';
                        }
                        $args['meta_key'] = $acf_get['name'];
                        $args['order'] = $order_asc_desc;
                      } else if ( $sort_order == "rand") {
                        $args['orderby'] = 'rand(' . rand() . ')';
                      } else {
                        $args['orderby'] = $sort_order;
                        $args['order']= $order_asc_desc;
                      }
                      
                      // END SORTING
                
              if (isset($meta_query)) {
                $args['meta_query'] = $meta_query;
              }


                    $args = apply_filters('dmach_archive_post_args', $args);

                     query_posts( $args );

                      if ($enable_debug == "1") {
                        $acf_get = get_field_object($acf_name);
                        ?>
                        <div class="reporting_args hidethis" style="white-space: pre;">
                          <?php  print_r($args); ?>
                        </div>
                        <?php
                      }


                      if ($loop_layout == "none") {
                        echo "Please create a custom loop layout and specify it in the settings.";
                      } else {


                    if ( have_posts() ) {

                      ?>
                      
                      <div class="dmach-before-posts"></div>
                      <div class="<?php echo $css_class ?> dmach_carousel_container">
                      <?php

                      while ( have_posts() ) {
                        the_post();
                        setup_postdata( $post );

                        $post_id = $post->ID;

                        $terms = wp_get_object_terms( $post_id, get_object_taxonomies($post_type_choose) );
                        $terms_array = array();
                        foreach ( $terms as $term ) {
                          $terms_array[] = $term->taxonomy . '-' . $term->slug;
                        }
                        $terms_string = implode (" ", $terms_array);

                        if ( $link_whole_gird == 'on' ) {
                          $post_link = get_permalink(get_the_ID());
                          ?>
                          <div class="dmach-link-whole-grid-card <?php echo esc_attr( $terms_string ) ?> post_id_<?php echo esc_html($post_id) ?>" data-link-url="<?php echo $post_link ?>">
                          <?php      
                          $cat_classes_css = '';                 
                          } else {
                            $cat_classes_css = ''.esc_attr( $terms_string ) .'post_id_'. esc_html($post_id) .'';
                          }
                          
                          echo '<div class="post_content_wrapper '.$cat_classes_css.'">';
                          echo apply_filters('the_content', get_post_field('post_content', $loop_layout));
                          echo '</div>';
                          
                          if ( $link_whole_gird == 'on' ) {
                            ?>
                            </div>  
                            <?php                    
                            }

                      } // end while have posts

                      ?>
                      </div>
                      <div class="dmach-after-posts"></div>
                      <?php




                } // end if have posts


                }


                    wp_reset_query();

?>
<script type="text/javascript">
  jQuery(document).ready(function($){
    $(".<?php echo $css_class ?>.dmach_carousel_container").slick({
<?php echo $arrows_display; ?>
<?php echo $dots_display; ?>
<?php echo $infinate_display; ?>
<?php echo $center_display; ?>
slidesToShow: <?php echo $posts_number_desktop ?>,
slidesToScroll:<?php echo $posts_number_desktop_slide ?>,
<?php echo $autoplay ?>
autoplaySpeed: <?php echo $autospeed ?>,
responsive: [
   {
     breakpoint: 1030,
     settings: {
       slidesToShow: <?php echo $posts_number_tablet ?>,
       slidesToScroll: <?php echo $posts_number_slide_tablet ?>,
     } },
   {
     breakpoint: 980,
     settings: {
       slidesToShow: <?php echo $posts_number_tablet_land ?>,
       slidesToScroll: <?php echo $posts_number_slide_tablet_land ?>
     } },
   {
     breakpoint: 580,
     settings: {
       slidesToShow: <?php echo $posts_number_mobile ?>,
       slidesToScroll: <?php echo $posts_number_slide_mobile ?>
     } }
 ]
});

$('.<?php echo $css_class ?>.dmach_carousel_container div[data-slick-index="0"] video')[0].play();

$('.<?php echo $css_class ?>.dmach_carousel_container').on('afterChange', function(event, slick, currentSlide, nextSlide){
  console.log(currentSlide);
  $('.<?php echo $css_class ?>.dmach_carousel_container video').each(function() {
    $(this).get(0).pause();
  });
  if($('.<?php echo $css_class ?>.dmach_carousel_container div[data-slick-index="'+currentSlide+'"] video').length){
    $('.<?php echo $css_class ?>.dmach_carousel_container div[data-slick-index="'+currentSlide+'"] video')[0].play();
  }
});

$('.align-last-module').each(function () {
    var $this = $(this);

    if ($this.find(".slick-list").length) {

      if ($this.find('.slick-slide:nth-child(1) .et_pb_section .et_pb_row:nth-child(2)').length > 1) { //if looking for direct descendants then do .children('div').length
        // console.log("yere");
        $this.addClass('align-multiple_rows');
      } else {
        $this.addClass('align-single_row');
      }

    } else {
      // console.log("not found");
      if ($this.find('.divi-filter-archive-loop .et_pb_row:nth-child(2)').length > 1) { //if looking for direct descendants then do .children('div').length
        $this.addClass('align-multiple_rows');
      } else {
        $this.addClass('align-single_row');
      }

    }
  });
  
});
    </script>
<?php

                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;



              }

            }

            new de_mach_carousel_code;