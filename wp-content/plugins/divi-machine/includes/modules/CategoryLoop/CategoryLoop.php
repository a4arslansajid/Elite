<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_cat_loop_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMACH_PRODUCT_URL,
  'author'     => DE_DMACH_AUTHOR,
  'author_uri' => DE_DMACH_URL,
);

                function init() {
                    $this->name       = esc_html__( 'Category Loop - Divi Machine', 'divi-machine' );
                    $this->slug = 'et_pb_de_mach_cat_loop';
                    $this->folder_name = 'divi_machine';

                    $this->fields_defaults = array(
                    'loop_layout'         => array( 'none' ),
                    'fullwidth'         => array( 'on' ),
                    'columns'         => array( '3' ),
                    'show_pagination'   => array( 'on' ),
                    'cat_order'   => array( '1' ),
                    'hide_empty'   => array( 'on' ),
                    'column_style'   => array( 'text-ontop' ),
                    );

          $this->settings_modal_toggles = array(
            'general' => array(
              'toggles' => array(
                'main_content' => esc_html__( 'Module Options', 'divi-machine' ),
                'loop_options' => esc_html__( 'Loop Options', 'divi-machine' ),
                'element_options' => esc_html__( 'Element Options', 'divi-machine' ),
                'grid_options' => esc_html__( 'Grid Options', 'divi-machine' ),
              ),
            ),
            'advanced' => array(
              'toggles' => array(
                'overlay' => esc_html__( 'Overlay', 'divi-machine' ),
                'image'   => esc_html__( 'Image', 'divi-machine' ),
              ),
            ),

          );


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
              'fonts' => array(
                'text'   => array(
                                'label'    => esc_html__( 'Title', 'divi-machine' ),
                                'css'      => array(
                                        'main' => "{$this->main_css_element} .dmach-cat-title",
                                          'important' => 'all',
                                ),
                                'font_size' => array('default' => '14px'),
                                'line_height'    => array('default' => '1.5em'),
                ),
                'active_title'   => array(
                  'label'    => esc_html__( 'Active Title', 'divi-bodyshop-woocommerce' ),
                  'css'      => array(
                    'main' => "{$this->main_css_element} .active-category .dmach-cat-title", 
                    'important' => 'all',
                  ),
                  'font_size' => array('default' => '14px'),
                  'line_height'    => array('default' => '1.5em'),
                ),
                'description'   => array(
                                'label'    => esc_html__( 'Description', 'divi-machine' ),
                                'css'      => array(
                                        'main' => "{$this->main_css_element} .dmach-cat-desc",
                                          'important' => 'all',
                                ),
                                'font_size' => array('default' => '14px'),
                                'line_height'    => array('default' => '1.5em'),
                ),
              ),
              'background' => array(
                'settings' => array(
                  'color' => 'alpha',
                ),
              ),
              'box_shadow'     => array(
                'default' => array(
                    'label' => esc_html__( 'All Box Shadow', 'divi-bodyshop-woocommerce' ),
                    'css' => array(
                        'main' => "%%order_class%%",
                        'important' => 'plugin_only',
                    ),
                ),
                'category_cards' => array(
                    'label' => esc_html__( 'Individual Categories Box Shadow', 'divi-bodyshop-woocommerce' ),
                    'css' => array(
                        'main' => "%%order_class%% .dmach-grid-item",
                        'important' => 'plugin_only',
                    ),
                ),
              ),
              'borders'        => array(
                'default' => array(
                  'css'          => array(
                    'main'      => array(
                      'border_radii'  => sprintf( '%1$s', $this->main_css_element ),
                      'border_styles' => sprintf( '%1$s', $this->main_css_element ),
                    ),
                    'important' => 'plugin_only',
                  ),
                  'label_prefix' => esc_html__( 'All', 'et_builder' ),
                ),
                'cards' => array(
                  'css'          => array(
                    'main'      => array(
                      'border_radii'  => sprintf( '%1$s .dmach-grid-item', $this->main_css_element ),
                      'border_styles' => sprintf( '%1$s .dmach-grid-item', $this->main_css_element ),
                    ),
                    'important' => 'plugin_only',
                  ),
                  'label_prefix' => esc_html__( 'Individual Categories', 'et_builder' ),
                ),
              ),
              'custom_margin_padding' => array(
                'css' => array(
                  'important' => 'all',
                ),
              ),
            );

            $this->help_videos = array(

            );
          }

                  function get_fields() {

                    $acf_fields = DEDMACH_INIT::get_acf_fields();
                    
                    $looplayout_options = DEDMACH_INIT::get_divi_layouts();

                      $fields = array(


                        'post_type_define' => array(
                        'label'             => esc_html__( 'Return Type', 'divi-machine' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'options'           => array(
                        'default'  => esc_html__( 'Current Post', 'divi-machine' ),
                        'custom' => esc_html__( 'Custom Post (you define)', 'divi-machine' ),
                        'taxonomy' => esc_html__( 'Custom Taxonomy (you define)', 'divi-machine' ),
                        ),
                        'affects'         => array(
                          'post_type_choose',
                          'tax_type_choose',
                        ),
                        'description'        => esc_html__( 'Choose if you want to use the current post or define a custom one', 'divi-machine' ),
                        'toggle_slug'       => 'loop_options',
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        ),

                        'tax_type_choose' => array(
                          'toggle_slug'       => 'loop_options',
                          'label'             => esc_html__( 'Taxonomy Slug', 'divi-machine' ),
                          'type'              => 'text',
                          'option_category'   => 'layout',
                          'default'           => '',
                          'depends_show_if' => 'taxonomy',
                          'description'       => esc_html__( 'Add the slug of the custom taxonomy you want to use', 'divi-machine' ),
                          'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        ),

                        'post_type_choose' => array(
                          'toggle_slug'       => 'loop_options',
                          'label'             => esc_html__( 'Post Type', 'divi-machine' ),
                          'type'              => 'select',
                          'options'           => et_get_registered_post_type_options( false, false ),
                          'option_category'   => 'layout',
                          'default'           => 'post',
                          'show_if_not'           => array(
                              'filter_post_type' => 'default',
                              'filter_post_type' => 'taxonomy'
                          ),
                          'description'       => esc_html__( 'Choose the post type you want to display', 'divi-machine' ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                        ),
                        'layout_style' => array(
                          'toggle_slug'       => 'loop_options',
                          'label'             => esc_html__( 'Layout Style', 'divi-machine' ),
                          'type'              => 'select',
                          'options'           => array(
                          'default'  => esc_html__( 'Default', 'divi-machine' ),
                          'loop' => esc_html__( 'Loop Layout', 'divi-machine' ),
                          ),
                          'option_category'   => 'layout',
                          'default'           => 'default',
                          'description'       => esc_html__( 'Default will show the title, description and image for you. If you want to use a loop layout = choose this', 'divi-machine' ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                        ),
                        'loop_layout' => array(
                          'label'             => esc_html__('Loop Layout', 'divi-machine'),
                          'type'              => 'select',
                          'option_category'   => 'layout',
                          'toggle_slug'       => 'loop_options',
                          'default'           => 'none',
                          'show_if'   => array('layout_style' => 'loop'),
                          'options'           => $looplayout_options,
                          'description'        => esc_html__('Choose the layout you have made for each category.', 'divi-machine'),
                        ),
                        
                        'filter_acf_name' => array(
                          'toggle_slug'       => 'loop_options',
                          'label'             => esc_html__( 'Filter By ACF Field', 'divi-machine' ),
                          'type'              => 'select',
                          'options'           => $acf_fields,
                          'option_category'   => 'layout',
                          'default'           => 'none',
                          'description'       => esc_html__( 'Choose the ACF field to filter categories by.', 'divi-machine' ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                        ),
                        'filter_acf_value' => array(
                          'toggle_slug'       => 'loop_options',
                          'label'             => esc_html__( 'ACF Value', 'divi-machine' ),
                          'type'              => 'text',
                          'option_category'   => 'layout',
                          'default'           => '',
                          'description'       => esc_html__( 'Choose the ACF field value to filter categories by.', 'divi-machine' ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                        ),
                        'acf_name' => array(
                        'toggle_slug'       => 'element_options',
                          'label'             => esc_html__( 'Image Name', 'divi-machine' ),
                          'type'              => 'select',
                          'options'           => $acf_fields,
                          'option_category'   => 'layout',
                          'default'           => 'none',
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                          'description'       => esc_html__( 'If you want to display an image in the category loop, specify the image acf item that you have added to the post category. This image is a ACF field that you add on the category settings page', 'divi-machine' ),
                        ),
                        'title_tag' => array(
                          'label'       => __( 'Title HTML Tag', 'divi-machine' ),
                          'type'        => 'select',
                          'options'     => array(
                            "h1"=>"h1",
                            "h2"=>"h2",
                            "h3"=>"h3",
                            "h4"=>"h4",
                            "h5"=>"h5",
                            "h6"=>"h6",
                            "p"=>"p"
                          ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                          'default'     => 'h3',
                          'description' => __( 'Set the title tag. For example you may want it to be h3 or h4 on the custom layout.', 'divi-machine' ),
                          'toggle_slug'     => 'element_options',
                        ),
                        'return_format' => array(
                          'toggle_slug'     => 'element_options',
                          'label'             => esc_html__('Image Return Format', 'divi-machine'),
                          'type'              => 'select',
                          'options'           => array(
                            'array' => esc_html__('Array', 'divi-machine'),
                            'url' => sprintf(esc_html__('URL', 'divi-machine')),
                          ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                          'default' => 'array',
                          'description'       => esc_html__('Choose how you have defined the return format in ACF settings.', 'divi-machine'),
                        ),
                          'column_style' => array(
                        'label'             => esc_html__( 'Column Style', 'divi-machine' ),
                        'type'              => 'select',
                        // 'computed_affects' => array(
                        //   '__getcategoryarchive',
                        // ),
                        'option_category'   => 'layout',
                        'options'           => array(
                        'text-ontop'  => esc_html__( 'Title On Top Image', 'divi-machine' ),
                        'text-below' => esc_html__( 'Title Below Image', 'divi-machine' ),
                        'image-left' => esc_html__( 'Image on left of Title', 'divi-machine' ),
                        ),
                        'depends_show_if' => 'off',
                        'default'         => 'text-ontop',
                        'description'        => esc_html__( 'Choose the style of the grid layout', 'divi-machine' ),
                        'toggle_slug'       => 'element_options',
                        ),
                        'columns' => array(
                        'label'             => esc_html__( 'Grid Columns', 'divi-machine' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'options'           => array(
                        1  => esc_html__( 'One', 'divi-machine' ),
                        2  => esc_html__( 'Two', 'divi-machine' ),
                        3 => esc_html__( 'Three', 'divi-machine' ),
                        4 => esc_html__( 'Four', 'divi-machine' ),
                        5 => esc_html__( 'Five', 'divi-machine' ),
                        6 => esc_html__( 'Six', 'divi-machine' ),
                        ),
                        'description'        => esc_html__( 'How many columns do you want to see', 'divi-machine' ),
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'toggle_slug'       => 'grid_options',
                        ),
                        'columns_tablet' => array(
                        'label'             => esc_html__( 'Tablet Grid Columns', 'divi-machine' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'toggle_slug'       => 'grid_options',
                        'default'   => '2',
                        'options'           => array(
                        1  => esc_html__( 'One', 'divi-machine' ),
                        2  => esc_html__( 'Two', 'divi-machine' ),
                        3 => esc_html__( 'Three', 'divi-machine' ),
                        4 => esc_html__( 'Four', 'divi-machine' ),
                        ),
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'description'        => esc_html__( 'How many columns do you want to see on tablet', 'divi-machine' ),
                        ),
                        'columns_mobile' => array(
                        'label'             => esc_html__( 'Mobile Grid Columns', 'divi-machine' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'toggle_slug'       => 'grid_options',
                        'default'   => '1',
                        'options'           => array(
                        1  => esc_html__( 'One', 'divi-machine' ),
                        2  => esc_html__( 'Two', 'divi-machine' ),
                        ),
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'description'        => esc_html__( 'How many columns do you want to see on mobile', 'divi-machine' ),
                        ),
                        'text_orientation' => array(
                                        'label'             => esc_html__( 'Text Orientation', 'divi-machine' ),
                                        'type'              => 'select',
                                        'option_category'   => 'layout',
                                        'options'           => et_builder_get_text_orientation_options(),
                                        'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'divi-machine' ),
                                        'toggle_slug'       => 'element_options',
                        ),
                        'hide_description' => array(
                        'label'             => esc_html__( 'Hide Descriptions', 'divi-machine' ),
                        'type'              => 'select',
                        'options'           => array(
                        "off"  => esc_html__( 'No', 'divi-machine' ),
                        "on" => esc_html__( 'Yes', 'divi-machine' ),
                        ),
                        'description'        => esc_html__( 'If you want to only show the title and image and hide the descriptions, check this.', 'divi-machine' ),
                        'toggle_slug'       => 'element_options',
                        ),
                        'hide_title' => array(
                        'label'             => esc_html__( 'Hide Titles', 'divi-machine' ),
                        'type'              => 'select',
                        'options'           => array(
                        "off"  => esc_html__( 'No', 'divi-machine' ),
                        "on" => esc_html__( 'Yes', 'divi-machine' ),
                        ),
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'description'        => esc_html__( 'If you want to only show the image and hide the titles, check this.', 'divi-machine' ),
                        'toggle_slug'       => 'element_options',
                        ),
                        'cat_order' => array(
                        'label'             => esc_html__( 'Orderby', 'divi-machine' ),
                        'type'              => 'select',
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'options'           => array(
                        "1"  => esc_html__( 'Name', 'divi-machine' ),
                        "2" => esc_html__( 'Category Order', 'divi-machine' ),
                        ),
                        'description'        => esc_html__( 'Select how you want the categories ordered.', 'divi-machine' ),
                        'toggle_slug'       => 'loop_options',
                        ),
                        'hide_empty' => array(
                          'label'             => esc_html__( 'Hide Empty?', 'divi-machine' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-machine' ),
                            'off' => esc_html__( 'No', 'divi-machine' ),
                          ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                          'description' => esc_html__( 'If you want to hide empty categories/taxonomies, enable this.', 'divi-machine' ),
                          'toggle_slug'       => 'loop_options',
                        ),
                        'show_all_terms' => array(
                          'label'             => esc_html__( 'Show All (not specific to post)?', 'divi-machine' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-machine' ),
                            'off' => esc_html__( 'No', 'divi-machine' ),
                          ),
                          'description' => esc_html__( 'If you want to show all the terms and not those assigned to the current post, enable this.', 'divi-machine' ),
                          'toggle_slug'       => 'loop_options',
                        ),
                        'is_loop_layout' => array(
                          'label'             => esc_html__( 'Is in loop layout?', 'divi-machine' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-machine' ),
                            'off' => esc_html__( 'No', 'divi-machine' ),
                          ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                          'description' => esc_html__( 'If you want to only show the categories that are assigned to this post and using it inside a custom loop layout, enable this.', 'divi-machine' ),
                          'toggle_slug'       => 'loop_options',
                        ),
                        'show_all' => array(
                          'label'             => esc_html__( 'Show Only Child Categories?', 'divi-machine' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-machine' ),
                            'off' => esc_html__( 'No', 'divi-machine' ),
                          ),
                          'default'           => 'off',
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                          'description' => esc_html__( 'If you want to show only the child categories or if on the archive page, show only the main categories - enable this.', 'divi-machine' ),
                          'toggle_slug'       => 'loop_options',
                        ),
                        'exclude_cats' => array(
                          'toggle_slug'       => 'loop_options',
                          'label'           => esc_html__( 'Exclude (ID)(comma-seperated)', 'divi-machine' ),
                          'type'            => 'text',
                          'description'     => esc_html__( 'If you want to exclude some categories, add the IDs here. (comma-seperated)', 'divi-machine' ),
                          'computed_affects' => array(
                            '__getcategoryarchive',
                          ),
                        ),
                        'zoom_icon_color' => array(
                          'label'             => esc_html__( 'Zoom Icon Color', 'divi-machine' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'depends_show_if'   => 'off',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        'hover_overlay_color' => array(
                          'label'             => esc_html__( 'Hover Overlay Color', 'divi-machine' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'depends_show_if'   => 'off',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        'hover_icon' => array(
                          'label'               => esc_html__( 'Hover Icon Picker', 'divi-machine' ),
                          'type'                => 'text',
                          'option_category'     => 'configuration',
                          'class'               => array( 'et-pb-font-icon' ),
                          'renderer'            => 'select_icon',
                          'renderer_with_field' => true,
                          'depends_show_if'     => 'off',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        '__getcategoryarchive' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'de_mach_cat_loop_code', 'get_cat_archive' ),
                          'computed_depends_on' => array(
                            'post_type_define',
                            'tax_type_choose',
                            'post_type_choose',
                            'filter_acf_name',
                            'filter_acf_value',
                            'cat_order',
                            'columns',
                            'columns_tablet',
                            'columns_mobile',
                            'acf_name',
                            'hide_empty',
                            'exclude_cats',
                            'return_format',
                            'title_tag'
                          ),
                        ),

                      );

                      return $fields;
                  }


                  public static function get_cat_archive ( $args = array(), $conditional_tags = array(), $current_page = array() ){

                    ob_start();

                    //$post_slug = DEDMACH_INIT::get_vb_post_type();

                    $post_id = $current_page['id'];

                    $vb_post_type          = get_post_meta($post_id, '_divi_filters_post_type', true);
                    $page_post_meta_backup = get_post_meta($post_id, '_daf_post_type', true);

                    $cat_order = $args['cat_order'];
                    $columns = $args['columns'];
                    $columns_tablet = $args['columns_tablet'];
                    $columns_mobile = $args['columns_mobile'];
                    $acf_name = $args['acf_name'];
                    $hide_empty = $args['hide_empty'];
                    $exclude_cats          = $args['exclude_cats'];
                    $return_format          = $args['return_format'];
                    $hide_title          = $args['hide_title'];
                    $title_tag          = $args['title_tag'];
                    $post_type_define         = $args['post_type_define'];
                    $tax_type_choose          = $args['tax_type_choose'];
                    $post_type_choose          = $args['post_type_choose'];
                    $filter_acf_name          = $args['filter_acf_name'];
                    $filter_acf_value         = $args['filter_acf_value'];

                    $ending = "_category";
	                  if ( isset( $post_slug ) ) {
		                  $cat_key = $post_slug . $ending;
	                  }

                    if ($post_type_define == "taxonomy") {
                      $cat_key = $tax_type_choose;
                    } else {
                      if ($post_type_define == "custom") {
                        $current_post_type = $post_type_choose;
                      } else {
                        $current_post_type = $vb_post_type;
                      }

                      if ($current_post_type == "") {
                        //$current_post_type = $wp_query->query["post_type"];
                        $current_post_type = get_post_type( $post_id );
                      }

                      if ($current_post_type == "post") {
                        $cat_key = "category";
                      } else {
                        $ending = "_category";
                        $cat_key = $current_post_type . $ending;
                      }
                    }

                    if ($hide_empty == "off") {
                      $hide_empty = false;
                    } else {
                      $hide_empty = true;
                    }

                    if ($exclude_cats != "") {
                      $exclude_cats = $exclude_cats;
                    } else {
                      $exclude_cats = array();
                    }

                    if ( $filter_acf_name != "" ) {
                      $acf_field_obj = get_field_object($filter_acf_name);
                      if ( $filter_acf_value != "" ) {
                        $get_terms_array['meta_query'] = array(
                          array(
                            'key' => $acf_field_obj['name'],
                            'value' => $filter_acf_value,
                            'compare' => '='
                          )
                        );
                      } else {
                        $get_terms_array['meta_query'] = array(
                          array(
                            'key' => $acf_field_obj['name'],
                            'compare' => 'EXISTS'
                          )
                        );
                      }
                    }

                    $get_terms_array['hide_empty'] = $hide_empty;
                    $get_terms_array['orderby'] = 'ASC';
                    $get_terms_array['exclude'] = $exclude_cats;
                    $get_terms_array['parent'] = 0;

                    if ($cat_order == 1) { // NAME
                      $terms = get_terms(
                        $cat_key,
                        $get_terms_array
                    );
                      }
                      else if ($cat_order == 2) { // CAT ORDER
                        $terms = get_terms(
                          $cat_key,
                          $get_terms_array
                      );
                      }
                      else {
                        $terms = get_terms(
                          $cat_key,
                          $get_terms_array
                        );
                      }

                    if ( $terms != "0" && !is_wp_error($terms) ) {

                      ?>
                      <div class="et_pb_de_mach_cat_loop">
                      <div class="category-loop col-desk-<?php echo $columns?> col-tab-<?php echo $columns_tablet?> col-mob-<?php echo $columns_mobile?>">
                        <div class="grid-posts">
                        <?php
                        foreach ( $terms as $term ){
                          $category_id = $term->term_id;
                          $category_name = $term->name;
                          $category_slug = $term->slug;
                          $category_description = $term->description;

                          ?>
                          <div class="grid-col dmach-grid-item">
                            <?php

                        ///////////

                        $category_id = $term->term_id;
                        /*if ($hide_title == 'on') {
                        } else {
                          echo '<h3 class="title-top">'. $category_name .'</h3>';
                        }*/

                        $term_id = $term->term_id;
                        $image = get_field( $acf_name, $cat_key . "_" . $term_id );
                        if ( $image ) {
                          if ($return_format == "array") {
                          ?>
                          <span class="et_portfolio_image">
                            <img src="<?php echo $image["url"]; ?>" alt="<?php echo $category_name; ?>" />
                          <?php if ( isset( $overlay ) ) {
	                          echo $overlay;
                          } ?>
                          </span>
                          <?php
                          }  else {
                            ?>
                            <span class="et_portfolio_image">
                              <img src="<?php echo $image; ?>" alt="<?php echo $category_name; ?>" />
                            <?php if ( isset( $overlay ) ) {
	                            echo $overlay;
                            } ?>
                            </span>
                            <?php
                          }
                        }

                        if ($hide_title == 'on') {
                        } else {
                          echo '<'. $title_tag .' class="dmach-cat-title title-bottom">'. $category_name .'</'. $title_tag .'>';
                        }

                        echo  $category_description;


                          ?>
                              </div>
                              <?php

                          }

                              ?>

                  </div>
                      </div>
                      </div>
                      <?php

                    }


                    $data = ob_get_clean();

                  return $data;

                  }



                  function render($attrs, $content, $render_slug){

                    $background_layout = '';
                    $columns                   = $this->props['columns'];
                    $columns_tablet           = $this->props['columns_tablet'];
                    $columns_mobile          = $this->props['columns_mobile'];
                    $column_style           = $this->props['column_style'];
                    $text_orientation       = $this->props['text_orientation'];
                    $hide_title       = $this->props['hide_title'];
                    $hide_description       = $this->props['hide_description'];
                    $cat_order              = $this->props['cat_order'];
                    $zoom_icon_color     = $this->props['zoom_icon_color'];
                    $hover_overlay_color = $this->props['hover_overlay_color'];
                    $hover_icon          = $this->props['hover_icon'];
                    $acf_name          = $this->props['acf_name'];
                    $hide_empty          = $this->props['hide_empty'];
                    $post_type_define         = $this->props['post_type_define'];
                    $post_type_choose          = $this->props['post_type_choose'];
                    $exclude_cats          = $this->props['exclude_cats'];
                    $return_format          = $this->props['return_format'];
                    $show_all          = $this->props['show_all'];
                    $is_loop_layout          = $this->props['is_loop_layout'];
                    $title_tag          = $this->props['title_tag'];
                    $tax_type_choose          = $this->props['tax_type_choose'];
                    $show_all_terms          = $this->props['show_all_terms'];
                    $filter_acf_name          = $this->props['filter_acf_name'];
                    $filter_acf_value         = $this->props['filter_acf_value'];

                    $layout_style         = $this->props['layout_style'];
                    $loop_layout         = $this->props['loop_layout'];
                    

                    
                  //////////////////////////////////////////////////////////////////////


                                    if( is_admin() && !wp_doing_ajax() ){
                                      return;
                                    }

                                    ob_start();


                                                    global $paged;


                                                    $container_is_closed = false;

                                                    $overlay = "";
                                                    // Set inline style
                                                    if ( '' !== $zoom_icon_color ) {
                                                      ET_Builder_Element::set_style( $render_slug, array(
                                                        'selector'    => '%%order_class%% .et_overlay:before',
                                                        'declaration' => sprintf(
                                                          'color: %1$s !important;',
                                                          esc_html( $zoom_icon_color )
                                                        ),
                                                      ) );


                                                    }

                                                    if ( '' !== $hover_overlay_color ) {
                                                      ET_Builder_Element::set_style( $render_slug, array(
                                                        'selector'    => '%%order_class%% .et_overlay',
                                                        'declaration' => sprintf(
                                                          'background-color: %1$s;
                                                          border-color: %1$s;',
                                                          esc_html( $hover_overlay_color )
                                                        ),
                                                      ) );
                                                    }



                                                    if ( is_rtl() && 'left' === $text_orientation ) {
                                                                    $text_orientation = 'right';
                                                    }




                                            global $post, $wp_query, $de_categoryloop_term;


                                            if ($post_type_define == "taxonomy") {
                                              $cat_key = $tax_type_choose;
                                            } else {
                                              if ($post_type_define == "custom") {
                                                $current_post_type = $post_type_choose;
                                              } else {
                                                $current_post_type = get_post_type( get_the_ID() );
                                              }
                                              if ($current_post_type == "") {
                                                $current_post_type = $wp_query->query["post_type"];
                                              }

                                              if ($current_post_type == "post") {
                                                $cat_key = "category";
                                              } else {
                                                $ending = "_category";
                                                $cat_key = $current_post_type . $ending;
                                              }
                                            }


                                            if ($hide_empty == "off") {
                                              $hide_empty = false;
                                            } else {
                                              $hide_empty = true;
                                            }

                                            if ($exclude_cats != "") {
                                              $exclude_cats = $exclude_cats;
                                            } else {
                                              $exclude_cats = array();
                                            }

                                            $get_terms_array = array();

                                            $get_parent_only = 0;

                                            if (isset(get_queried_object()->term_id)){
                                              $get_current_id = get_queried_object()->term_id;
                                              $get_parent = get_queried_object()->term_id;
                                            } else {
                                              $get_current_id = "";
                                              $get_parent = '0';
                                            }

                                            if ($show_all == "off") {
                                              $get_parent = '';
                                            } else {
                                              $get_terms_array['parent'] = $get_parent;
                                            }

                                            $get_terms_array['hide_empty'] = $hide_empty;
                                            $get_terms_array['orderby'] = 'ASC';
                                            $get_terms_array['exclude'] = $exclude_cats;
                                            $get_terms_array['taxonomy'] = $cat_key;

                                            if ( $filter_acf_name != "" ) {
                                              $acf_field_obj = get_field_object($filter_acf_name);
                                              if ( $filter_acf_value != "" ) {
                                                $get_terms_array['meta_query'] = array(
                                                  array(
                                                    'key' => $acf_field_obj['name'],
                                                    'value' => $filter_acf_value,
                                                    'compare' => '='
                                                  )
                                                );
                                              } else {
                                                $get_terms_array['meta_query'] = array(
                                                  array(
                                                    'key' => $acf_field_obj['name'],
                                                    'compare' => 'EXISTS'
                                                  )
                                                );
                                              }
                                            }

                                            if ($post_type_define != "taxonomy") {
                                              
                                              if (is_single() || $is_loop_layout == "on") {
                                                $terms = get_the_terms( get_the_ID(), $cat_key );
                                              } else {
                                                $terms = get_terms( $get_terms_array );
                                              }

                                              if ($show_all_terms == "on") {
                                                $terms = get_terms( $get_terms_array );
                                              }
                                              
                                            } else {

                                              if (is_single() || $is_loop_layout == "on") {

                                                $terms = get_the_terms( get_the_ID(), $tax_type_choose );

                                              } else {

                                                $term_query = array(
                                                  'taxonomy' => $tax_type_choose,
                                                  'hide_empty' => $hide_empty,
                                                  'orderby' => 'ASC',
                                                  'exclude' => $exclude_cats,
                                                  'parent' => $get_parent,
                                                );

                                                if ( $filter_acf_name != "" ) {
                                                  $term_query['meta_query'] = $get_terms_array['meta_query'];  
                                                }                                                
                                                $terms = get_terms( $term_query );
                                              }

                                              
                                              if ($show_all_terms == "on") {
                                                $term_query = array(
                                                  'taxonomy' => $tax_type_choose,
                                                  'hide_empty' => $hide_empty,
                                                  'orderby' => 'ASC',
                                                  'exclude' => $exclude_cats,
                                                  'parent' => $get_parent,
                                                );

                                                if ( $filter_acf_name != "" ) {
                                                  $term_query['meta_query'] = $get_terms_array['meta_query'];  
                                                }
                                                $terms = get_terms( $term_query );
                                              }

                                            }
            

                                            ///////////////// CATEGORY

                                            if ( $terms != "0" && !is_wp_error($terms) ) {

                                                $shortcodes = '';
                                                $i = 0;
                                                
                                                ?>
                                                <div class="et_pb_de_mach_archive_loop">
                                                  <div class="category-loop col-desk-<?php echo $columns?> col-tab-<?php echo $columns_tablet?> col-mob-<?php echo $columns_mobile?>">
                                                    <div class="grid-posts">
                                                      <?php
                                                    if ($layout_style == 'loop') {

                                                        foreach ( $terms as $term ){
                                                          $de_categoryloop_term = $term;
        
                                                          echo do_shortcode(get_post_field('post_content', $loop_layout));
        
                                                        }
        
                                                        $de_categoryloop_term = null;
        
                                                    } else {
                                                      foreach ( $terms as $term ){
                                                        $category_id = $term->term_id;
                                                        $category_name = $term->name;
                                                        $category_slug = $term->slug;
                                                        $category_description = $term->description;

                                                        $css_classes = "";
                                                        if (is_tax( $get_terms_array['taxonomy'], $term->name )) {
                                                          $css_classes .= "active-category";
                                                        }
                                                        
                                                        ?>
                                                        <div class="grid-col dmach-grid-item <?php echo esc_html($css_classes); ?>">
                                                        <?php
                                                        
                                                        ///////////
                                                        
                                                        if ($column_style == "text-ontop"){
                                                          $category_id = $term->term_id;
                                                          
                                                          echo '<a href="'. get_term_link($category_slug, $cat_key) .'">';
                                                          if ($hide_title == 'on') {
                                                          } else {
                                                            echo '<'. $title_tag .' class="dmach-cat-title">'. $category_name .'</'. $title_tag .'>';
                                                          }
                                                          
                                                          $term_id = $term->term_id;
                                                          $image = get_field( $acf_name, $cat_key . "_" . $term_id );
                                                          
                                                          if (isset($image['url'])) {
                                                            $image_url = $image['url'];
                                                          } else {
                                                            $image_url = $image;
                                                          }
                                                          
                                                          if ( $image ) {
                                                            if ($return_format == "array") {
                                                              ?>
                                                              <span class="et_portfolio_image">
                                                                <img src="<?php echo $image_url; ?>" alt="<?php echo $category_name; ?>" />
                                                                <?php echo $overlay; ?>
                                                              </span>
                                                              <?php
                                                            }  else {
                                                              ?>
                                                              <span class="et_portfolio_image">
                                                                <img src="<?php echo $image; ?>" alt="<?php echo $category_name; ?>" />
                                                                <?php echo $overlay; ?>
                                                              </span>
                                                              <?php
                                                            }
                                                          }
                                                        
                                                          echo '</a>';
                                                          
                                                          if ($hide_description == 'on') {
                                                          } else {
                                                            ?>
                                                            <div class="dmach-cat-desc">
                                                              <?php
                                                              echo  $category_description;
                                                              ?>
                                                            </div>
                                                            <?php
                                                          }
                                                        } else if ($column_style == "text-below") {

                                                          echo '<a href="'. get_term_link($category_slug, $cat_key) .'">';
                                                          $term_id = $term->term_id;
                                                          $image = get_field( $acf_name, $cat_key . "_" . $term_id );
                                                          
                                                          if (isset($image['url'])) {
                                                            $image_url = $image['url'];
                                                          } else {
                                                            $image_url = $image;
                                                          }
                                                          
                                                          if ( $image ) {
                                                            ?>
                                                            <span class="et_portfolio_image">
                                                              <img src="<?php echo $image_url; ?>" alt="<?php echo $category_name; ?>" />
                                                              <?php echo $overlay; ?>
                                                            </span>
                                                            <?php
                                                          }
                                                          
                                                          if ($hide_title == 'on') {
                                                          } else {
                                                            echo '<'. $title_tag .' class="dmach-cat-title">'. $category_name .'</'. $title_tag .'>';
                                                          }
                                                          
                                                          echo '</a>';
                                                          
                                                          if ($hide_description == 'on') {
                                                          } else {
                                                            ?>
                                                            <div class="dmach-cat-desc">
                                                              <?php
                                                              echo  $category_description;
                                                              ?>
                                                              </div>
                                                              <?php
                                                          }
                                                        } else if ($column_style == "image-left") {
                                                          
                                                          echo '<div class="cat_loop_image_left">';
                                                          $term_id = $term->term_id;
                                                          $image = get_field( $acf_name, $cat_key . "_" . $term_id );
                                                          
                                                          if (isset($image['url'])) {
                                                            $image_url = $image['url'];
                                                          } else {
                                                            $image_url = $image;
                                                          }
                                                          
                                                          if ( $image ) {
                                                            echo '<div class="category_loop_image">';
                                                            echo '<a href="'. get_term_link($category_slug, $cat_key) .'">';
                                                            ?>
                                                            <span class="et_portfolio_image">
                                                              <img src="<?php echo $image_url; ?>" alt="<?php echo $category_name; ?>" />
                                                              <?php echo $overlay; ?>
                                                            </span>
                                                            </a>
                                                            </div>
                                                            <?php
                                                          }
                                                          
                                                          echo '<div class="category_loop_content">';
                                                          if ($hide_title == 'on') {
                                                          } else {
                                                            echo '<a href="'. get_term_link($category_slug, $cat_key) .'">';
                                                            echo '<'. $title_tag .' class="dmach-cat-title">'. $category_name .'</'. $title_tag .'>';
                                                            echo '</a>';
                                                          }
                                                          
                                                          if ($hide_description == 'on') {
                                                          } else {
                                                            ?>
                                                            <div class="dmach-cat-desc">
                                                              <?php
                                                              echo  $category_description;
                                                              ?>
                                                            </div>
                                                            <?php
                                                          }
                                                          echo '</div>';
                                                          echo '</div>';
                                                        
                                                        }
                                                        
                                                        /////////////////
                                                        ?>
                                                        </div>
                                                        <?php
                                                      }
                                                    }
                                                      ?>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <?php
                                              
                                              
                                              if (is_single() || $is_loop_layout == "on") {

                                              } else {
                                                wp_reset_query();
                                              }

                                            } else {
                                            }

                                            ////////////// CATEGORY




                                                //////
                                                    $data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

                                return $data;
                  }
              }

            new de_mach_cat_loop_code;
