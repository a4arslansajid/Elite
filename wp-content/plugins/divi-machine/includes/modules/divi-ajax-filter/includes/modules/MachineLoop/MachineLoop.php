<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !function_exists("Divi_filter_machine_loop_module_import") ){
	add_action( 'et_builder_ready', 'Divi_filter_machine_loop_module_import');

	function Divi_filter_machine_loop_module_import(){
		if(class_exists("ET_Builder_Module") && !class_exists("de_mach_archive_loop_code")){
			class de_mach_archive_loop_code extends ET_Builder_Module {

				public $vb_support = 'on';

				protected $module_credits = array(
					'module_uri' => DE_DF_PRODUCT_URL,
					'author'     => DE_DF_AUTHOR,
					'author_uri' => DE_DF_URL,
				);

				function init() {
					$this->name       = esc_html__( 'Archive Loop - Divi Machine', 'divi-machine' );
					$this->slug = 'et_pb_de_mach_archive_loop';
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
										'onload_terms'     => array(
											'name' => esc_html__( 'Terms on load ONLY', 'divi-machine')
										),
										'sorting'     => array(
											'name' => esc_html__( 'Sorting', 'divi-machine')
										),
									)
								),

								'element_options' => esc_html__( 'Element Options', 'divi-machine' ),
								'grid_options' => esc_html__( 'Grid Options', 'divi-machine' ),
								'extra_options' => esc_html__( 'Extra Options', 'divi-machine' ),
							),
						),
						'advanced' => array(
							'toggles' => array(
								'alignment'  => esc_html__( 'Alignment', 'divi-machine' ),
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
							'button' => array(
								'label' => esc_html__( 'Button - Load More', 'divi-machine' ),
								'css' => array(
									'main' => "{$this->main_css_element} .et_pb_button.dmach-loadmore",
									'important' => 'all',
								),
								'box_shadow'  => array(
									'css' => array(
										'main' => "{$this->main_css_element} .et_pb_button.dmach-loadmore",
										'important' => 'all',
									),
								),
								'margin_padding' => array(
									'css'           => array(
										'main' => "{$this->main_css_element} .et_pb_button.dmach-loadmore",
										'important' => 'all',
									),
								),
							),
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

					add_filter( 'et_pb_set_style_selector', array( $this, 'change_section_css_selector' ), 10, 2 );
				}

				function get_fields() {

					if ( class_exists( 'DEBC_INIT' ) ) {
						$options = DEBC_INIT::get_divi_layouts();
					} else if (class_exists( 'DEDMACH_INIT' ) ) {
						$options = DEDMACH_INIT::get_divi_layouts();
					} else {
						$options = DE_Filter::get_divi_layouts();
					}


					$registered_post_types = et_get_registered_post_type_options( false, false );

					$registered_post_types = self::sort_post_types( $registered_post_types );

					$post_types = array_merge( array('auto-detect' => esc_html__('Auto Detect', 'divi-machine')), $registered_post_types);

					///////////////////////////////
					if(class_exists('DEDMACH_INIT')){
						$acf_fields = DEDMACH_INIT::get_acf_fields();
					} else {
						$acf_fields = "";
					}

					$post_display_type_fields = array();

					$post_display_type_fields['default'] = esc_html__('Default', 'divi-machine');
					$post_display_type_fields['related'] = esc_html__('Related', 'divi-machine');
					$post_display_type_fields['linked_post'] = esc_html__('Linked Post', 'divi-machine');

					$dmach_acc_types_saved_array = "";
					if (class_exists('DMACHACC_DiviMachineAccount')) {
						$post_display_type_fields['wishlist'] = esc_html__('Saved List (Machine Account)', 'divi-machine');
						$post_display_type_fields['users_posts'] = esc_html__('Current Users Posts', 'divi-machine');
						/*$titan = TitanFramework::getInstance( 'divi-machine' );*/
						$dmach_acc_types_saved = de_get_option_value('divi-machine-acc', 'dmach_acc_types_saved');//$titan->getOption( 'dmach_acc_types_saved' );
						$dmach_acc_types_saved_array = explode(',', $dmach_acc_types_saved);
					}
					//////////////////////////////
					$fields = array(
						'post_type_choose' => array(
							'toggle_slug'       => 'main_content',
							'label'             => esc_html__( 'Post Type', 'divi-machine' ),
							'type'              => 'multiple_checkboxes',
							'options'           => $post_types,
							'option_category'   => 'configuration',
							'default'           => '',
							'computed_affects' => array(
								'__getarchiveloop',
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
								'__getarchiveloop',
							),
							'options'           => $options,
							'description'        => esc_html__( 'Choose the layout you have made for each post in the loop.', 'divi-machine' ),
						),
						'filter_update_animation' => array(
							'toggle_slug'       => 'main_content',
							'label'             => esc_html__( 'Filter/Infinite Scroll Icon Animation', 'divi-machine' ),
							'type'              => 'select',
							'options'           => array(
								'load-1'       => esc_html__( 'Three Lines Vertical', 'divi-machine' ),
								'load-2'       => esc_html__( 'Three Lines Horizontal', 'divi-machine' ),
								'load-3'       => esc_html__( 'Three Dots Bouncing', 'divi-machine' ),
								'load-4'       => esc_html__( 'Donut', 'divi-machine' ),
								'load-5'       => esc_html__( 'Donut Multiple', 'divi-machine' ),
								'load-6'       => esc_html__( 'Ripple', 'divi-machine' ),
							),
							'option_category'   => 'configuration',
							'default'           => 'load-6',
							'description'       => esc_html__( 'Choose the animation style for when loading the posts', 'divi-machine' ),
						),
						'animation_color' => array(
							'label'             => esc_html__( 'Animation Icon Color', 'divi-machine' ),
							'description'       => esc_html__( 'Define the color of the animation you choose above.', 'divi-machine' ),
							'type'              => 'color-alpha',
							'custom_color'      => true,
							'option_category'   => 'configuration',
							'toggle_slug'       => 'main_content',
						),
						'loading_bg_color' => array(
							'label'             => esc_html__( 'Loading Background Color', 'divi-machine' ),
							'description'       => esc_html__( 'Define the color of the background when it is loading.', 'divi-machine' ),
							'type'              => 'color-alpha',
							'custom_color'      => true,
							'option_category'   => 'configuration',
							'toggle_slug'       => 'main_content',
						),
						'no_posts_layout' => array(
							'toggle_slug'       => 'main_content',
							'label'             => esc_html__( 'No Posts Layout', 'divi-machine' ),
							'type'              => 'select',
							'option_category'   => 'configuration',
							'default'           => 'none',
							'options'           => $options,
							'description'        => esc_html__( 'Choose the layout that will be shown if there are no posts in the selection.', 'divi-machine' ),
						),
						'no_posts_layout_text' => array(
							'label' => esc_html__('No Posts Text', 'divi-machine'),
							'toggle_slug' => 'main_content',
							'option_category' => 'configuration',
							'type' => 'text',
							'default' => esc_html__('Sorry, No posts.', 'divi-machine'),
							'description' => esc_html__('Choose the default text when no posts are retrieved', 'divi-machine'),
							'show_if'   => array(
								'no_posts_layout' => 'none'
							),
						),
						'is_main_loop'  => array(
							'toggle_slug'       => 'main_content',
							'label'             => esc_html__( 'Is Main Loop?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'default'           => 'on',
							'description'       => esc_html__( 'Choose if you want to make this loop as main loop on the page - the filter will affect this loop.', 'divi-machine' ),
						),
						// LOOP SETTINGS
						'post_status' => array(
							'toggle_slug'       => 'loop_options',
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
							'sub_toggle'    => 'general',
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'       => esc_html__( 'Choose the status of the posts you want to show.', 'divi-machine' ),
						),
						'show_current_post' => array(
							'toggle_slug'       => 'loop_options',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Include current post?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'default' => 'off',
							'sub_toggle'    => 'general',
							'description'       => esc_html__( 'By default we will exclude the current post. If you want to show it in the loop, enable this.', 'divi-machine' ),
						),
						'posts_number' => array(
							'toggle_slug'       => 'loop_options',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Post Count', 'divi-machine' ),
							'type'              => 'text',
							'default'           => 10,
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'sub_toggle'    => 'general',
							'description'       => esc_html__( 'Choose how many posts you would like to display per page.', 'divi-machine' ),
						),
						'post_offset' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Post Offset Number', 'divi-machine' ),
							'type'              => 'text',
							'default'           => 0,
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'       => esc_html__( 'Choose how many posts you would like to skip. These posts will not be shown in the feed.', 'divi-machine' ),
						),
						'post_display_type' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Post Display Type', 'divi-machine' ),
							'type'              => 'select',
							'options'           => $post_display_type_fields,
							'affects'         => array(
								'related_content',
								'acf_linked_acf'
							),
							'default' => 'default',
							'description'       => esc_html__( 'Choose the display type. If you want to have related posts for example, we will find posts in the same categories or tags to show.', 'divi-machine' ),
						),
						'saved_type' => array(
							'label'           => esc_html__( 'Choose saved type', 'divi-machine' ),
							'type'            => 'multiple_checkboxes',
							'toggle_slug'     => 'loop_options',
							'sub_toggle'    => 'general',
							'option_category' => 'configuration',
							'options'         =>  $dmach_acc_types_saved_array,
							'description'     => esc_html__( 'Choose which saved type you want the icon to be for - you can change this in Machine Account settings.', 'divi-machine' ),
							'default'         => 'wishlist',
							'show_if'     => array(
								'post_display_type' => 'wishlist'
							),
						),
						'acf_linked_acf' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'label'             => esc_html__( 'Linked Post Object ACF Name', 'divi-machine' ),
							'type'              => 'select',
							'options'           => $acf_fields,
							'default'           => 'none',
							'depends_show_if' => 'linked_post',
							'option_category'   => 'configuration',
							'description'       => esc_html__( 'Select the Post Object that you have used to link this post to another', 'divi-machine' ),
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
                'taxonomy'  => esc_html__( 'Custom Taxonomy', 'divi-machine' ),
								'post-object' => esc_html__( 'Post Object', 'divi-machine' ),
							),
							'default' => 'categories',
							'affects'         => array(
                'tax_name_related',
								'acf_name_related',
							),
							'depends_show_if' => 'related',
							'description'       => esc_html__( 'Choose what would define the posts to be related.', 'divi-machine' ),
						),

						'related_content_categories' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Categories Type', 'divi-machine' ),
							'type'              => 'select',
							'options'           => array(
								'default' => sprintf( esc_html__( 'Default', 'divi-machine' ) ),
								'post_cats' => esc_html__( 'Post Categories', 'divi-machine' ),
							),
							'default' => 'default',
							'show_if'     => array(
								'related_content' => 'categories'
							),
							'description'       => esc_html__( 'If you have used Divi Machine to make your custom post and categories (custom) - leave as default. if you have custom coded your custom post and made the categories share with posts - select "Post Categories".', 'divi-machine' ),
						),


						'is_category_loop' => array(
							'toggle_slug'       => 'loop_options',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Is this inside a category loop module?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'default' => 'off',
							'sub_toggle'    => 'general',
							'description'       => esc_html__( 'If you are tring to show posts that are inside in the category and this is inside a category module loop layout, enable this.', 'divi-machine' ),
						),


						'specific_post_objects' => array(
							'toggle_slug'       => 'loop_options',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Specific Posts', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'default' => 'off',
							'sub_toggle'    => 'general',
							'show_if'     => array(
								'related_content' => 'post-object'
							),
							'description'       => esc_html__( 'If you want to show specific posts based on the post object - enable this. If not, we will find other posts based on the post object.', 'divi-machine' ),
						),



						'related_content_tags' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'option_category'   => 'configuration',
							'label'             => esc_html__( 'Tags Type', 'divi-machine' ),
							'type'              => 'select',
							'options'           => array(
								'default' => sprintf( esc_html__( 'Default', 'divi-machine' ) ),
								'post_tags' => esc_html__( 'Post Tags', 'divi-machine' ),
							),
							'default' => 'default',
							'show_if'     => array(
								'related_content' => 'tags'
							),
							'description'       => esc_html__( 'If you have used Divi Machine to make your custom post and tags (custom) - leave as default. if you have custom coded your custom post and made the tags share with posts - select "Post Tags".', 'divi-machine' ),
						),
						'related_exclude_cats' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Related - Exclude Categories (ID comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if'     => array(
								'related_content' => 'categories',
								'post_display_type' => 'related'
							),
							'description'     => esc_html__( 'If you want some categories to be excluded from the related posts, add the IDs here (comma-seperated) ', 'divi-machine' ),
						),
						'related_exclude_tags' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Related - Exclude Tags (ID comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if'     => array(
								'related_content' => 'tags',
								'post_display_type' => 'related'
							),
							'description'     => esc_html__( 'If you want some tags to be excluded from the related posts, add the IDs here (comma-seperated) ', 'divi-machine' ),
						),
            'tax_name_related' => array(
              'toggle_slug'       => 'loop_options',
              'sub_toggle'    => 'general',
              'label'             => esc_html__( 'Related Taxonomy Name', 'divi-machine' ),
              'type'              => 'text',
              'default'           => 'none',
              'depends_show_if' => 'taxonomy',
              'option_category'   => 'configuration',
              'description'       => esc_html__( 'Put the taxonomy name(not label) to show related posts with.', 'divi-machine' ),
            ),
						'acf_name_related' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'general',
							'label'             => esc_html__( 'Post Object ACF Name', 'divi-machine' ),
							'type'              => 'select',
							'options'           => $acf_fields,
							'default'           => 'none',
							'depends_show_if' => 'post-object',
							'option_category'   => 'configuration',
							'description'       => esc_html__( 'Select the Post Object that you want your related posts to look at to show these posts', 'divi-machine' ),
						),

						'include_cats' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'include_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Include Categories (Slug comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add a list of categories you want to include to show. This will remove all posts that dont have these categories. (comma-seperated)', 'divi-machine' ),
						),
						'include_tags' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'include_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Include Tags (Slug comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add a list of tags that you want to include to show. This will remove all posts that dont have these tags. (comma-seperated)', 'divi-machine' ),
						),
						'exclude_cats' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'include_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Exclude Categories (Slug comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add a list of categories you want to exclude to show. This will remove all posts that have these categories. (comma-seperated)', 'divi-machine' ),
						),
						'exclude_tags' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'include_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Exclude tags (Slug comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add a list of tags you want to exclude to show. This will remove all posts that have these tags. (comma-seperated)', 'divi-machine' ),
						),
						'exclude_products'      => array(
							'label'             => esc_html__( 'Exclude Posts', 'divi-machine' ),
							'type'              => 'text',
							'option_category'   => 'configuration',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'include_terms',
							'description'       => esc_html__( 'Add a list of post ids that you want to exclude from show. (comma-seperated)', 'divi-machine' ),
						),
						'custom_tax_choose' => array(
							'toggle_slug'       => 'loop_options',
                  'sub_toggle'    => 'include_terms',
                    'label'             => esc_html__( 'Choose Your Taxonomy', 'divi-machine' ),
                    'type'              => 'select',
                    'options'           => $this->getWP_taxonomies() ,
                    'option_category'   => 'configuration',
                    'show_if_not'     => array(
                      'post_display_type' => 'related'
							),
							'default'           => 'post',
							'depends_show_if'  => 'taxonomy',
							'description'       => esc_html__( 'Choose the custom taxonomy that you have made and want to filter', 'divi-machine' ),
						),
						'include_taxomony' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'include_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Include Custom Taxonomy Values (comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
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
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'       => esc_html__( 'If you want to show posts that only have a specific ACF field value, specify the field here and then the value below', 'divi-machine' ),
						),
						'acf_value' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'include_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Include ACF Value', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add the value here, it will show posts only with the value of the ACF field above', 'divi-machine' ),
						),

						'onload_cats' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'onload_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Include Categories on load ONLY (Slug comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add a list of categories you want to show ONLY on load - not included in the ajax filters. (comma-seperated)', 'divi-machine' ),
						),
						'onload_tags' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'onload_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Include Tags on load ONLY (Slug comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add a list of tags you want to show ONLY on load - not included in the ajax filters. (comma-seperated)', 'divi-machine' ),
						),
						'onload_tax_choose' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'onload_terms',
							'label'             => esc_html__( 'Include Custom Taxonomy on load ONLY', 'divi-machine' ),
							'type'              => 'select',
							'options'           => get_taxonomies( array( '_builtin' => FALSE ) ),
							'option_category'   => 'configuration',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'default'           => 'post',
							'description'       => esc_html__( 'Choose the custom taxonomy that you want to include on load only', 'divi-machine' ),
						),
						'onload_taxomony' => array(
							'toggle_slug'       => 'loop_options',
							'sub_toggle'    => 'onload_terms',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Include Custom Taxonomy Values on load ONLY (comma-seperated)', 'divi-machine' ),
							'type'            => 'text',
							'show_if_not'     => array(
								'post_display_type' => 'related'
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add a list of values that you want to show - make sure to specify the custom taxonomy above, it will then show the posts that have the values here from that custom taxonomy. (comma-seperated)', 'divi-machine' ),
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
								'relevance' => esc_html__( 'Relevance', 'divi-machine' ),
								'title' => esc_html__( 'Title', 'divi-machine' ),
								'ID' => esc_html__( 'ID', 'divi-machine' ),
								'rand' => esc_html__( 'Random', 'divi-machine' ),
								'menu_order' => esc_html__( 'Menu Order', 'divi-machine' ),
								'name' => esc_html__( 'Name', 'divi-machine' ),
								'modified' => esc_html__( 'Modified', 'divi-machine' ),
								'acf_field' => esc_html__( 'ACF Field', 'divi-machine' ),
								'acf_date_picker' => esc_html__( 'ACF Date Picker', 'divi-machine' ),
								'post__in' => esc_html__( 'Linked Posts Order', 'divi-machine' ),
							),
							'affects'         => array(
								'acf_sort_field',
								'acf_sort_type',
								'acf_date_picker_field',
								'acf_date_picker_method',
							),
							'default' => 'date',
							'computed_affects' => array(
								'__getarchiveloop',
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
								'__getarchiveloop',
							),
							'description'       => esc_html__( 'Choose the sort order of the products.', 'divi-machine' ),
						),
						// ELEMENT SETTINGS
						'enable_loadmore' => array(
							'label'             => esc_html__( 'Choose how to display load more posts', 'divi-machine' ),
							'type'              => 'select',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Load More', 'divi-machine' ),
								'pagination' => esc_html__( 'Pagination', 'divi-machine' ),
								'infinite'      => esc_html__( 'Infinite Scroll', 'divi-machine' ),
								'off' => esc_html__( 'None', 'divi-machine' ),
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'       => esc_html__( 'If you want to show a way for the visitors to get more posts you can choose either Load More or Pagination. If you do not want this option - choose "none".', 'divi-machine' ),
							'affects'         => array(
								'loadmore_text',
								'loadmore_text_loading',
								'scrollto'
							),
							'default' => 'off',
							'toggle_slug'       => 'element_options',
						),

						'scrollto' => array(
							'label' => esc_html__( 'Scroll to Top After Ajax Update', 'divi-machine' ),
							'type' => 'yes_no_button',
							'option_category' => 'configuration',
							'options' => array(
								'on' => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'default' => 'on',
							'depends_show_if'   => 'pagination',
							'description' => esc_html__( 'If you want to scroll to a section after the update of the ajax filter, enable this.', 'divi-machine' ),
							'toggle_slug' => 'element_options',
							'affects'=>array(
								'scrollto_fine_tune'
							),
						),
						'scrollto_fine_tune' => array(
							'label'             => esc_html__( 'Fine Tune the position', 'divi-machine' ),
							'type'              => 'range',
							'default'           => '0px',
							'toggle_slug'       => 'element_options',
							'option_category'   => 'configuration',
							'depends_show_if'   => 'on',
							'range_settings'   => array(
								'min'  => '-500',
								'max'  => '500',
								'step' => '1',
							),
						),


						'loadmore_text' => array(
							'toggle_slug'       => 'element_options',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Load More Text', 'divi-machine' ),
							'type'            => 'text',
							'depends_show_if' => 'on',
							'default' => 'Load More',
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'     => esc_html__( 'Add the text for the load more button', 'divi-machine' ),
						),
						'loadmore_text_loading' => array(
							'toggle_slug'       => 'element_options',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Load More Loading Text', 'divi-machine' ),
							'type'            => 'text',
							'show_if'         => array( 'enable_loadmore' => array( 'on') ),
							'default'         => 'Loading...',
							'description'     => esc_html__( 'Add the text for the load more button when it is loading', 'divi-machine' ),
						),
						'enable_resultcount'  => array(
							'label'             => esc_html__( 'Show result count?', 'divi-machine'),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'    => esc_html__( 'Yes', 'divi-machine' ),
								'off'   => esc_html__( 'No', 'divi-machine' ),
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'       => esc_html__( 'If you want to display result count - enable this.', 'divi-machine' ),
							'affects'           => array(
								'resultcount_position',
								'result_count_single_text',
								'result_count_all_text',
								'result_count_pagination_text',

							),
							'default'           => 'off',
							'toggle_slug'       => 'element_options'
						),
						'resultcount_position' => array(
							'label'             => esc_html__( 'Result Count Position', 'divi-machine'),
							'type'              => 'select',
							'option_category'   => 'configuration',
							'options'           => array(
								'left'      => esc_html__( 'Left', 'divi-machine' ),
								'right'     => esc_html__( 'Right', 'divi-machine' ),
							),
							'description'       => esc_html__( 'Select the position that you want to show the result count.', 'divi-machine' ),
							'depends_show_if'   => 'on',
							'default'           => 'right',
							'toggle_slug'       => 'element_options'
						),
						'result_count_single_text' => array(
							'label' => esc_html__('Single Result Count Text', 'divi-machine'),
							'toggle_slug' => 'element_options',
							'option_category' => 'configuration',
							'type' => 'text',
							'default' => 'Showing the single result',
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description' => esc_html__('Choose the default text for single results count.', 'divi-machine'),
							'depends_show_if'   => 'on',
						),
						'result_count_all_text' => array(
							'label' => esc_html__('All Result Count Text', 'divi-machine'),
							'toggle_slug' => 'element_options',
							'option_category' => 'configuration',
							'type' => 'text',
							'default' => 'Showing all %d results',
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description' => esc_html__('Choose the default text for all results count.', 'divi-machine'),
							'depends_show_if'   => 'on',
						),
						'result_count_pagination_text' => array(
							'label' => esc_html__('Pagination Result Count Text', 'divi-machine'),
							'toggle_slug' => 'element_options',
							'option_category' => 'configuration',
							'type' => 'text',
							'default' => 'Showing %d-%d of %d results',
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description' => esc_html__('Choose the default text for pagination results count.', 'divi-machine'),
							'depends_show_if'   => 'on',
						),
						'has_map' => array(
							'label'             => esc_html__( 'Has Map', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'description'       => esc_html__( 'If you have a map to show your posts - enable this.', 'divi-machine' ),
							'affects'         => array(
								'map_selector',
                      'map_infoview_layout',
                      'map_infoview_layout_ajax',
                      'map_tooltip_shortcode',
                      'map_all_posts',
                      'hide_marker_label'
                    ),
                    'default' => 'off',
                    'toggle_slug'       => 'element_options',
						),
						'map_selector' => array(
							'toggle_slug'       => 'element_options',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Map Selector', 'divi-machine' ),
							'type'            => 'text',
							'depends_show_if' => 'on',
							'description'     => esc_html__( 'Input ID or Class name of Map element.', 'divi-machine' ),
						),
						'map_all_posts'     => array(
							'label'             => esc_html__( 'Show All Posts on the map?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'description'       => esc_html__( 'If you want to show all your posts disregarding pagination - enable this.', 'divi-machine' ),
							'default' => 'off',
							'toggle_slug'       => 'element_options',
							'depends_show_if'   => 'on'
						),
						'map_all_posts_limit' => array(
							'toggle_slug'       => 'element_options',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Limit number of pins on map (when showing all pins)', 'divi-machine' ),
							'type'            => 'text',
							'show_if'           => array(
								'map_all_posts' => 'on'
							),
							'default'         => '-1',
							'description'     => esc_html__( 'If you are showing all pins on the map but also want to limit this - enter the number here. "-1" will show all', 'divi-machine' ),
						),
						'map_infoview_layout' => array(
							'toggle_slug'       => 'element_options',
							'option_category'   => 'configuration',
							'label'           => esc_html__( 'Marker Tooltip Layout', 'divi-machine' ),
							'type'              => 'select',
							'default'           => 'none',
							'options'           => $options,
							'depends_show_if' => 'on',
							'description'     => esc_html__( 'Select layout for Marker tooltip', 'divi-machine' ),
						),
						'map_tooltip_shortcode'     => array(
							'label'             => esc_html__( 'Tooltip Shortcode (advanced users)', 'divi-machine' ),
							'type'              => 'text',
							'option_category'   => 'configuration',
							'description'       => esc_html__( 'If you want to create your own HTML and use a shortcode to insert into the tooltip - add the shortcode here (Do not include []) - for example if your shortcode is called [shortcode_name] - just add: shortcode_name.', 'divi-machine' ),
							'default' => '',
							'toggle_slug'       => 'element_options',
							'depends_show_if'   => 'on'
						),
						'map_infoview_layout_ajax'     => array(
							'label'             => esc_html__( 'Ajax load Market Tooptip layout?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'description'       => esc_html__( 'If you want there to be no layouts loaded on the initial load - but ONLY when they click on the marker, enable this.', 'divi-machine' ),
							'default' => 'off',
                    'toggle_slug'       => 'element_options',
                    'depends_show_if'   => 'on'
                  ),
                  'hide_marker_label'      => array(
                    'label'             => esc_html__( 'Hide Marker Label?', 'divi-machine' ),
                    'type'              => 'yes_no_button',
                    'option_category'   => 'configuration',
                    'options'           => array(
                      'on'  => esc_html__( 'Yes', 'divi-machine' ),
                      'off' => esc_html__( 'No', 'divi-machine' ),
                    ),
                    'show_if'           => array(
                      'has_map' => 'on'
                    ),
                    'description'       => esc_html__( 'Enable this if you don\'t want to show label on the marker.', 'divi-machine' ),
                    'default'           => 'off',
                    'toggle_slug'       => 'element_options',
                  ),
                  'map_cluster' => array(
                    'label'             => esc_html__( 'Cluster Map?', 'divi-machine' ),
                    'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'show_if'           => array(
								'has_map' => 'on'
							),
							'description'       => esc_html__( 'Enable this if you want the map to have cluster or not.', 'divi-machine' ),
							'default' => 'on',
							'toggle_slug'       => 'element_options',
						),
						// ADVANCED OPTIONS
						'link_whole_gird' => array(
							'toggle_slug'       => 'extra_options',
							'label'             => esc_html__( 'Link each layout to single page', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'off' => esc_html__( 'No', 'divi-machine' ),
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
							),
							'default'           => 'off',
							'description'        => esc_html__( 'Enable this if you want to link each loop layout to the single post.', 'divi-machine' ),
						),
						'link_whole_gird_external' => array(
							'toggle_slug'       => 'extra_options',
							'label'             => esc_html__( 'Open to External URL?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'off' => esc_html__( 'No', 'divi-machine' ),
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
							),
							'default'           => 'off',
							'show_if'           => array(
								'link_whole_gird' => 'on'
							),
							'description'        => esc_html__( 'Enable this if you want to link each loop layout to the single post.', 'divi-machine' ),
						),
						'external_acf' => array(
							'toggle_slug'       => 'extra_options',
							'label'             => esc_html__('External ACF Text Field', 'divi-machine'),
							'type'              => 'select',
							'options'           => $acf_fields,
							'default'           => 'none',
							'show_if'           => array(
								'link_whole_gird_external' => 'on'
							),
							'description'       => esc_html__('Choose the ACF you want to use to tell the system where to link to', 'divi-machine'),
						),
						'link_whole_gird_new_tab' => array(
							'toggle_slug'       => 'extra_options',
							'label'             => esc_html__( 'Open in New Tab?', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'off' => esc_html__( 'No', 'divi-machine' ),
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
							),
							'show_if'           => array(
								'link_whole_gird' => 'on'
							),
							'description'        => esc_html__( 'Enable this if you want it to open in a new tab.', 'divi-machine' ),
						),
						'show_in_section' => array(
							'toggle_slug'       => 'extra_options',
							'label'             => esc_html__( 'Show Detail in the Same page', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'off' => esc_html__( 'No', 'divi-machine' ),
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
							),
							'show_if_not'       => array(
								'link_whole_gird' => 'on'
							),
							'affects'           => array(
								'content_section_selector',
								'content_section_layout',
								'show_in_same_row_mobile'
							),
							'description'        => esc_html__( 'Enable this if you want to show post detail to the specific section in same page.', 'divi-machine' ),
						),
						'content_section_selector'     => array(
							'label'             => esc_html__( 'Content Wrapper Selector', 'divi-machine' ),
							'type'              => 'text',
							'description'       => esc_html__( 'Input the selector(id/class selector) to show the post detail in the page.', 'divi-machine' ),
							'default' => '',
							'toggle_slug'       => 'extra_options',
							'depends_show_if'   => 'on'
						),
						'content_section_layout' => array(
							'toggle_slug'       => 'extra_options',
							'label'           => esc_html__( 'Post Detail Layout', 'divi-machine' ),
							'type'              => 'select',
							'default'           => 'none',
							'options'           => $options,
							'depends_show_if'   => 'on',
							'description'     => esc_html__( 'Select layout for Post Detail', 'divi-machine' ),
						),
						'show_in_same_row_mobile' => array(
							'toggle_slug'       => 'extra_options',
							'label'             => esc_html__( 'Show in the Same Row on Mobile', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'options'           => array(
								'off' => esc_html__( 'No', 'divi-machine' ),
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
							),
							'depends_show_if'   => 'on',
							'description'        => esc_html__( 'Enable this if you want to show post detail to the specific section in same page.', 'divi-machine' ),
						),
						'grid_layout' => array(
							'toggle_slug'       => 'grid_options',
							'label'             => esc_html__( 'Grid Style', 'divi-machine' ),
							'type'              => 'select',
							'options'           => array(
								'grid'       => esc_html__( 'Grid', 'divi-machine' ),
								'masonry'       => esc_html__( 'Masonry', 'divi-machine' ),
							),
							'affects'         => array(
								'equal_height',
								'align_last_bottom',
								'masonry_ajax_buffer',
							),
							'option_category'   => 'configuration',
							'default'           => 'grid',
							'description'       => esc_html__( 'Choose how you want your posts to be shown', 'divi-machine' ),
						),
						'masonry_ajax_buffer' => array(
							'label'           => esc_html__( 'Masonry Ajax Filter Buffer', 'divi-machine' ),
							'option_category' => 'configuration',
							'toggle_slug'     => 'grid_options',
							'type'            => 'range',
							'default'         => '500',
							'default_unit'    => 'ms',
							'default_on_front' => '',
							'range_settings' => array(
								'min'  => '0',
								'max'  => '5000',
								'step' => '1',
							),
							'depends_show_if' => 'masonry',
							'description'       => esc_html__( 'When using masonry, after ajax we need to re-sort the posts and create the masonry. Depending on your site you might need to increase this to run our code after the posts are loaded.', 'divi-machine' ),
						),


						'equal_height' => array(
							'label'             => esc_html__( 'Equal Height Grid Cards', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'depends_show_if' => 'grid',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'description' => esc_html__( 'Enable this if you have the grid layout and want all your cards to be the same height.', 'divi-machine' ),
							'toggle_slug'       => 'grid_options',
						),
						'align_last_bottom' => array(
							'toggle_slug'       => 'grid_options',
							'label'             => esc_html__( 'Align last module at the bottom', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'depends_show_if' => 'grid',
							'options'           => array(
								'off' => esc_html__( 'No', 'divi-machine' ),
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
							),
							'description'        => esc_html__( 'Enable this to align the last module (probably the add to cart) at the bottom. Works well when using the equal height.', 'divi-machine' ),
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
								'__getarchiveloop',
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
								1  => esc_html__( 'One', 'divi-machine' ),
								2  => esc_html__( 'Two', 'divi-machine' ),
								3 => esc_html__( 'Three', 'divi-machine' ),
								4 => esc_html__( 'Four', 'divi-machine' ),
							),
							'computed_affects' => array(
								'__getarchiveloop',
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
								1  => esc_html__( 'One', 'divi-machine' ),
								2  => esc_html__( 'Two', 'divi-machine' ),
							),
							'computed_affects' => array(
								'__getarchiveloop',
							),
							'description'        => esc_html__( 'How many columns do you want to see on mobile', 'divi-machine' ),
						),


						'custom_gutter_width' => array(
							'label'             => esc_html__( 'Custom Gutter Gaps', 'divi-machine' ),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'divi-machine' ),
								'off' => esc_html__( 'No', 'divi-machine' ),
							),
							'description'       => esc_html__( 'Enable this if you want custom gutter gaps for row and columns.', 'divi-machine' ),
							'affects'         => array(
								'gutter_row_gap',
								'gutter_row_column',
							),
							'default' => 'off',
							'toggle_slug'       => 'grid_options',
						),


						'gutter_row_gap' => array(
							'label'           => esc_html__('Gutter Row Gap', 'divi-machine'),
							'description'     => esc_html__('Set the distance between each grid item vertically.', 'divi-machine'),
							'type'            => 'range',
							'option_category' => 'basic_option',
							'toggle_slug'     => 'grid_options',
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
							'label'           => esc_html__('Gutter Column Gap', 'divi-machine'),
							'description'     => esc_html__('Set the distance between each grid item horizontally.', 'divi-machine'),
							'type'            => 'range',
							'option_category' => 'basic_option',
							'toggle_slug'     => 'grid_options',
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



						'button_alignment' => array(
							'label'            => esc_html__( 'Button Alignment', 'divi-machine' ),
							'description'      => esc_html__( 'Align your button to the left, right or center of the module.', 'divi-machine' ),
							'type'             => 'text_align',
							'option_category'  => 'configuration',
							'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
							'tab_slug'         => 'advanced',
							'toggle_slug'      => 'alignment',
						),
						'__getarchiveloop' => array(
							'type' => 'computed',
							'computed_callback' => array( 'de_mach_archive_loop_code', 'get_archive_loop' ),
							'computed_depends_on' => array(
								'post_type_choose',
								'loop_layout',
								'columns',
								'columns_tablet',
								'columns_tablet',
								'columns_mobile',
								'post_status',
								'enable_resultcount',
								'enable_loadmore',
								'loadmore_text',
								'posts_number',
								'post_offset',
								'include_cats',
								'exclude_cats',
								'include_tags',
								'exclude_tags',
								'acf_name',
								'acf_value',
								'sort_order',
								'order_asc_desc',
							),
						),
					);

					return $fields;
				}

				public static function get_archive_loop ( $args = array(), $conditional_tags = array(), $current_page = array() ){
					if (!is_admin()) {
						return;
					}

					global $wp_query;

					ob_start();

					$registered_post_types = et_get_registered_post_type_options( false, false );

					$registered_post_types = self::sort_post_types( $registered_post_types );

					$post_types = array_merge( array('auto-detect' => esc_html__('Auto Detect', 'divi-machine')), $registered_post_types);

					$post_type_choose_str   = $args['post_type_choose'];
					$loop_layout        = $args['loop_layout'];
					$columns            = $args['columns'];
					$columns_tablet     = $args['columns_tablet'];
					$columns_mobile     = $args['columns_mobile'];

					$post_status        = $args['post_status'];
					$posts_number       = $args['posts_number'];
					$post_offset        = $args['post_offset'];

					$include_cats       = $args['include_cats'];
					$include_tags       = $args['include_tags'];
					$exclude_cats       = $args['exclude_cats'];
					$exclude_tags       = $args['exclude_tags'];
					$acf_name           = $args['acf_name'];
					$acf_value          = $args['acf_value'];
					$sort_order         = $args['sort_order'];
					$order_asc_desc     = $args['order_asc_desc'];
					$enable_loadmore    = $args['enable_loadmore'];
					$enable_resultcount = $args['enable_resultcount'];
					$loadmore_text      = $args['loadmore_text'];
					$resultcount_position = isset($args['resultcount_position'])?$args['resultcount_position']:"right";
					$resultcount_single_text = $args['resultcount_single_text'];
					$resultcount_all_text = $args['resultcount_all_text'];
					$resultcount_pagination_text = $args['resultcount_pagination_text'];

					$post_type_choose = array();

					$post_type_choose_split = explode( '|', $post_type_choose_str );

					$i = 0;
					foreach ( $post_types as $key => $type ) {
						if ( !empty( $post_type_choose_split[$i] ) && $post_type_choose_split[$i] == 'on' ) {
							$post_type_choose[] = $key;
						}
						$i++;
					}

					if ( !empty( $post_type_choose_split ) && empty( $post_type_choose ) ) {
						$post_type_choose = $post_type_choose_split;
					}


					$get_cpt_args = array(
						'post_type' => $post_type_choose,
						'post_status' => $post_status,
						'posts_per_page' => $posts_number,
						'offset' => $post_offset,
						'orderby' => $sort_order,
						'order' => $order_asc_desc,
					);

					$get_cpt_args['tax_query']['relation'] = 'AND';

					if ($include_cats != "") {

						$include_cats_arr = explode(',', $include_cats);

						$tax_query = array( 'relation' => 'OR' );

						foreach ($post_type_choose as $key => $post_type ) {
							if ( $post_type == "post") {
								$tax_query[] = array(
									'taxonomy'  => 'category',
									'field'     => 'slug',
									'terms'     => $include_cats_arr,
									'operator' => 'IN'
								);
							} else {
								if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
									$tax_query[] = array(
										'taxonomy'  => 'category',
										'field'     => 'slug',
										'terms'     => $include_cats_arr,
										'operator' => 'IN'
									);
								}else{
									$ending = "_category";
									$cat_key = $post_type . $ending;
									if ($cat_key == "product_category") {
										$cat_key = "product_cat";
									}

									$tax_query[] = array(
										'taxonomy'  => $cat_key,
										'field'     => 'slug',
										'terms'     => $include_cats_arr,
										'operator' => 'IN'
									);

									//$GLOBALS['my_query_filters']['tax_query'] = $post_type_choose . '_category';
								}
							}
						}

						$get_cpt_args['tax_query'][] = $tax_query;
					}

					if ($exclude_cats != "") {
						$exclude_cats_arr = explode(',', $exclude_cats);
						$tax_query = array( 'relation' => 'AND' );

						foreach ($post_type_choose as $key => $post_type ) {
							if ( $post_type == "post") {
								$tax_query[] = array(
									'taxonomy'  => 'category',
									'field'     => 'slug',
									'terms'     => $exclude_cats_arr,
									'operator' => 'NOT IN'
								);
							} else {
								if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
									$tax_query[] = array(
										'taxonomy'  => 'category',
										'field'     => 'slug',
										'terms'     => $exclude_cats_arr,
										'operator' => 'NOT IN'
									);
								}else{
									$ending = "_category";
									$cat_key = $post_type . $ending;
									if ($cat_key == "product_category") {
										$cat_key = "product_cat";
									}

									$tax_query[] = array(
										'taxonomy'  => $cat_key,
										'field'     => 'slug',
										'terms'     => $exclude_cats_arr,
										'operator' => 'NOT IN'
									);
								}
							}
						}

						$get_cpt_args['tax_query'][] = $tax_query;
					}

					if ($include_tags != "") {

						$include_tags_arr = explode(',', $include_tags);

						$tax_query = array( 'relation' => 'OR' );

						foreach ($post_type_choose as $key => $post_type ) {
							$ending = "_tag";
							$cat_key = $post_type . $ending;

							$tax_query[] = array(
								'taxonomy'  => $cat_key,
								'field'     => 'slug',
								'terms'     => $include_tags_arr,
								'operator' => 'IN'
							);
						}

						$get_cpt_args['tax_query'][] = $tax_query;
					}

					if ($exclude_tags != "") {
						$exclude_tags_arr = explode(',', $exclude_tags);
						$tax_query = array( 'relation' => 'AND' );

						foreach ($post_type_choose as $key => $post_type ) {
							$ending = "_tag";
							$cat_key = $post_type . $ending;

							$tax_query[] = array(
								'taxonomy'  => $cat_key,
								'field'     => 'slug',
								'terms'     => $exclude_tags_arr,
								'operator' => 'NOT IN'
							);
						}

						$get_cpt_args['tax_query'][] = $tax_query;
					}

					wp_enqueue_script('divi-filter-js');
					wp_enqueue_script('markerclusterer-js');
					wp_enqueue_script('divi-filter-masonry-js');

					query_posts( $get_cpt_args );

					if ($loop_layout == "none") {
						echo "Please create a custom loop layout and specify it in the settings.";
					} else {
						?>
                        <div class="filtered-posts-cont">
                            <div class="dmach-grid-sizes divi-filter-archive-loop filtered-posts col-desk-<?php echo esc_attr( $columns )?> col-tab-<?php echo esc_attr( $columns_tablet )?> col-mob-<?php echo esc_attr( $columns_mobile )?>">
								<?php

								if ( have_posts() ) {
									?>
                                    <div class="grid-posts loop-grid">
										<?php
										while ( have_posts() ) {
											the_post();

											?>
                                            <div class="grid-col">
                                                <div class="grid-item-cont">
													<?php
													$post_content = apply_filters( 'the_content', get_post_field('post_content', $loop_layout) );

													$post_content = preg_replace( '/et_pb_section_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_section_${1}_tb_body', $post_content );
													$post_content = preg_replace( '/et_pb_row_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_row_${1}_tb_body', $post_content );
													$post_content = preg_replace( '/et_pb_column_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_column_${1}_tb_body', $post_content );
													$post_content = preg_replace( '/et_pb_section_(\d+)( |")/', 'et_pb_dmach_ajax_filter_section_${1}${2}', $post_content );
													$post_content = preg_replace( '/et_pb_row_(\d+)( |")/', 'et_pb_dmach_ajax_filter_row_${1}${2}', $post_content );
													$post_content = preg_replace( '/et_pb_column_(\d+)( |")/', 'et_pb_dmach_ajax_filter_column_${1}${2}', $post_content );

													$post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_${1}_${2}_tb_body', $post_content );
													$post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_dmach_ajax_filter_${1}_${2}${3}', $post_content );

													echo $post_content;

													?>
                                                </div>
                                            </div>
											<?php
										}

										?>
                                    </div>
									<?php
									// retrieve the styles for the modules
									$internal_style = ET_Builder_Element::get_style();
									// reset all the attributes after we retrieved styles
									ET_Builder_Element::clean_internal_modules_styles( false );
									$et_pb_rendering_column_content = false;

									// append styles
									if ( $internal_style ) {
										?>
                                        <div class="df-inner-styles">
											<?php
											$cleaned_styles = str_replace("#et-boc .et-l","#et-boc .et-l .filtered-posts", $internal_style);
											$cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_${1}_${2}_tb_body', $internal_style );
											$cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)( |"|.)/', 'et_pb_dmach_ajax_filter_${1}_${2}${3}', $cleaned_styles );

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

								}

								?>
                            </div>
                        </div>
                        <div class="dmach-after-posts"></div>
						<?php
						$position_class = '';
						if ( $enable_resultcount == "on" ) {
							$position_class = 'result_count_' . $resultcount_position;
							$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
							echo '<p class="divi-filter-result-count ' . esc_attr( $position_class ) . '">';
							if ( $wp_query->found_posts == 1 ){
								echo $resultcount_single_text;
							}else if ( $wp_query->found_posts == $wp_query->post_count ) {
								printf( $resultcount_all_text, esc_attr( $wp_query->found_posts ) );
							}else {
								printf( $resultcount_pagination_text, (($current_page - 1) * $posts_number + 1), (($current_page - 1) * $posts_number + $wp_query->post_count), esc_html( $wp_query->found_posts ) );
							}
							echo '</p>';
						}
						if ($enable_loadmore == "on") { ?>

                            <div class="dmach-loadmore et_pb_button <?php echo esc_attr( $position_class );?>" <?php echo (isset($custom_icon) ? esc_attr( $custom_icon ) : ''); ?>><?php echo esc_attr( $loadmore_text ) ?></div>

						<?php }else if ( $enable_loadmore == 'pagination' ) {
							?>
                            <div class="divi-filter-pagination <?php echo esc_attr( $position_class );?>"><?php echo paginate_links(array('type' => 'list')); ?></div>
							<?php
						}
					}

					$data = ob_get_clean();

					return $data;

				}

				public static function sort_post_types( $post_types ) {
					$post_type_orders = get_option( 'post_type_orders', array() );
					foreach ( $post_types as $post_name => $post_label ) {
						if ( !in_array( $post_name, $post_type_orders ) ) {
							$post_type_orders[] = $post_name;
						}
					}

					update_option( 'post_type_orders', $post_type_orders );

					$flipped_array = array_flip( $post_type_orders );

					$flipped_post_types = array_flip( $post_types );

					uasort( $flipped_post_types, function( $a, $b ) use ($flipped_array){
						if ( $flipped_array[$a] > $flipped_array[$b] ) {
							return 1;
						} else {
							return -1;
						}
					});

					return array_flip( $flipped_post_types );
				}

				public function change_section_css_selector( $selector, $function_name ){
					global $current_in_archive_loop;
					if ( ( $current_in_archive_loop != '' ) && $function_name == 'et_pb_section' ){
						if ( $current_in_archive_loop == 'archive_loop') {
							$selector = str_replace( 'et_pb_section_', 'et_pb_dmach_section_', $selector );
						}else{
							//$selector = str_replace( 'et_pb_section_', 'et_pb_dmach_' . $current_in_archive_loop . '_section_', $selector );
						}

					}
					if ( ( $current_in_archive_loop != '' ) && $function_name == 'et_pb_row' ){
						if ( $current_in_archive_loop == 'archive_loop') {
							$selector = str_replace( 'et_pb_row_', 'et_pb_dmach_row_', $selector );
						}else{
							//$selector = str_replace( 'et_pb_row_', 'et_pb_dmach_' . $current_in_archive_loop . '_row_', $selector );
						}
					}
					if ( ( $current_in_archive_loop != '' ) && $function_name == 'et_pb_column' ){
						if ( $current_in_archive_loop == 'archive_loop') {
							$selector = str_replace( 'et_pb_column_', 'et_pb_dmach_column_', $selector );
						}else{
							//$selector = str_replace( 'et_pb_column_', 'et_pb_dmach_' . $current_in_archive_loop . '_column_', $selector );
						}
					}
					return $selector;
				}

				public function get_button_alignment( $device = 'desktop' ) {
					$suffix           = 'desktop' !== $device ? "_{$device}" : '';
					$text_orientation = isset( $this->props["button_alignment{$suffix}"] ) ? $this->props["button_alignment{$suffix}"] : '';

					return et_pb_get_alignment( $text_orientation );
				}

				function render($attrs, $content, $render_slug){
                if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
                  return;
                }

                $start_time = microtime( true );

                global $address_filter_var;
                global $divi_filter_removed_param;
                global $de_loop_variable;

                //if ( !empty( $_GET['filter'] ) && $_GET['filter'] == 'true' ){
                  if ( !empty($divi_filter_removed_param) ) {
                    foreach ($divi_filter_removed_param as $key => $value ) {
                      $_GET[$key] = $value;
                    }
                  }
                //}

                $divi_filter_removed_param = array();

                $address_filter_var['is_filter'] = false;

                $de_loop_variable = array();

                /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
                $titan = TitanFramework::getInstance( 'divi-machine' );*/
                $enable_debug = de_get_option_value('divi-machine', 'enable_debug'); //$titan->getOption( 'enable_debug' );

                $registered_post_types = et_get_registered_post_type_options( false, false );

                $registered_post_types = self::sort_post_types( $registered_post_types );

                $post_types = array_merge( array('auto-detect' => esc_html__('Auto Detect', 'divi-machine')), $registered_post_types);

                global $wp_archive_query;


                $loop_layout            = $this->props['loop_layout'];
                $post_type_choose_str   = $this->props['post_type_choose'];

                $post_status            = $this->props['post_status'];
                $post_display_type      = $this->props['post_display_type'];
                $saved_type_str         = $this->props['saved_type'];

                $related_content        = $this->props['related_content'];
                $related_content_categories        = $this->props['related_content_categories'];
                $related_content_tags        = $this->props['related_content_tags'];

                $specific_post_objects      = $this->props['specific_post_objects'] ?: 'off';

                $related_exclude_cats        = $this->props['related_exclude_cats'];
                $related_exclude_tags        = $this->props['related_exclude_tags'];

                $tax_name_related       = $this->props['tax_name_related'];


                $acf_name_related        = $this->props['acf_name_related'];


                $include_cats           = $this->props['include_cats'];
                $include_tags           = $this->props['include_tags'];
                $exclude_cats           = $this->props['exclude_cats'];
                $exclude_tags           = $this->props['exclude_tags'];

                $onload_cats           = $this->props['onload_cats'];
                $onload_tags           = $this->props['onload_tags'];
                $onload_tax_choose           = $this->props['onload_tax_choose'];
                $onload_taxomony           = $this->props['onload_taxomony'];


                $exclude_products       = $this->props['exclude_products'];
                $is_main_loop           = $this->props['is_main_loop'];

                $custom_tax_choose           = $this->props['custom_tax_choose'];
                $include_taxomony           = $this->props['include_taxomony'];



                // $author       = $this->props['author'];
                $sort_order             = $this->props['sort_order'];
                $acf_date_picker_field  = $this->props['acf_date_picker_field'];
                $acf_date_picker_method = $this->props['acf_date_picker_method'];
                $acf_date_picker_custom_day = $this->props['acf_date_picker_custom_day'];

                $acf_sort_field         = $this->props['acf_sort_field'];
                $acf_sort_type          = $this->props['acf_sort_type'];

                $order_asc_desc         = $this->props['order_asc_desc'];

                $posts_number           = $this->props['posts_number'];
                $post_offset           = $this->props['post_offset'];

                $no_posts_layout        = $this->props['no_posts_layout'];
                $no_posts_layout_text   = $this->props['no_posts_layout_text'];


                $is_category_loop        = $this->props['is_category_loop'];


                $columns                = $this->props['columns'];
                $columns_tablet         = $this->props['columns_tablet'];
                $columns_mobile         = $this->props['columns_mobile'];

                $custom_gutter_width    = $this->props['custom_gutter_width'];
                $gutter_row_gap         = $this->props['gutter_row_gap'] ?: '25px';
                $gutter_row_column      = $this->props['gutter_row_column'] ?: '25px';

                $link_whole_gird        = $this->props['link_whole_gird'];
                $link_whole_gird_external        = $this->props['link_whole_gird_external'];
                $external_acf        = $this->props['external_acf'];



                $acf_linked_acf               = $this->props['acf_linked_acf'];

                $acf_name               = $this->props['acf_name'];
                $acf_value              = $this->props['acf_value'];

                $equal_height           = $this->props['equal_height'];
                $align_last_bottom    = $this->props['align_last_bottom'];

                $grid_layout            = $this->props['grid_layout'];

                $masonry_ajax_buffer            = $this->props['masonry_ajax_buffer'];


                $show_current_post            = $this->props['show_current_post'];

                if ($masonry_ajax_buffer == ""){
                  $masonry_ajax_buffer = "500";
                }

                $masonry_ajax_buffer = preg_replace("/[^0-9]/", "", $masonry_ajax_buffer );

                $filter_update_animation = $this->props['filter_update_animation'];
                $animation_color        = $this->props['animation_color'];
                $loading_bg_color        = $this->props['loading_bg_color'];


                $enable_loadmore        = $this->props['enable_loadmore'];

                $scrollto                       = $this->props['scrollto'];
                $scrollto_fine_tune                       = $this->props['scrollto_fine_tune'];

                if ( $enable_loadmore == "on") {
                  $scrollto = "no";
                }


                $loadmore_text          = $this->props['loadmore_text'];
                $loadmore_text_loading  = $this->props['loadmore_text_loading'];

                $enable_resultcount     = $this->props['enable_resultcount'];
                $resultcount_position   = $this->props['resultcount_position'];
                $result_count_single_text   = $this->props['result_count_single_text'];
                $result_count_all_text   = $this->props['result_count_all_text'];
                $result_count_pagination_text   = $this->props['result_count_pagination_text'];

                $button_alignment  = $this->props['button_alignment'];

                $button_use_icon            = $this->props['button_use_icon'];
                $custom_icon              = $this->props['button_icon'];
                $button_bg_color          = $this->props['button_bg_color'];

                $has_map              = $this->props['has_map'];
                $map_selector         = $this->props['map_selector'];
                $map_infoview_layout  = $this->props['map_infoview_layout'];
                $map_infoview_layout_ajax = $this->props['map_infoview_layout_ajax'];
                $map_tooltip_shortcode = $this->props['map_tooltip_shortcode'];
                
                // Module classnames
                $this->add_classname(
                    array(
                        'clearfix',
                        $this->get_text_orientation_classname(),
                    )
                );

                if ( $map_infoview_layout_ajax == 'on') {
                $this->add_classname( 'ajax_load_map_tooltip' );
                }
                $map_all_posts        = !empty($this->props['map_all_posts'])?$this->props['map_all_posts']:'off';


                $map_all_posts_limit  = $this->props['map_all_posts_limit'];

                $map_cluster  = $this->props['map_cluster'];
                $hide_marker_label = $this->props['hide_marker_label'];
                
                global $wp_query, $wpdb, $post, $woocommerce;

                $post_type_choose = array();
                $map_array = array();

                $post_type_choose_split = explode( '|', $post_type_choose_str );

                $i = 0;
                foreach ( $post_types as $key => $type ) {
                  if ( !empty( $post_type_choose_split[$i] ) && $post_type_choose_split[$i] == 'on' ) {
                    $post_type_choose[] = $key;
                  }
                  $i++;
                }

                if ( !empty( $post_type_choose_split ) && empty( $post_type_choose ) ) {
                  $post_type_choose = $post_type_choose_split;
                }

                $dmach_acc_types_saved_array = "";
                if (class_exists('DMACHACC_DiviMachineAccount')) {
                    /*$titan = TitanFramework::getInstance( 'divi-machine' );*/
                    $dmach_acc_types_saved = de_get_option_value('divi-machine-acc', 'dmach_acc_types_saved'); //$titan->getOption( 'dmach_acc_types_saved' );
                    $dmach_acc_types_saved_array = explode(',', $dmach_acc_types_saved);
                }

                $saved_type = array();

                $saved_type_split = explode( '|', $saved_type_str );

                $i = 0;
                if ( !empty( $dmach_acc_types_saved_array ) ) {
                  foreach ( $dmach_acc_types_saved_array as $key => $type ) {
                    if ( !empty($saved_type_split[$i]) && $saved_type_split[$i] == 'on' ) {
                      $saved_type[] = $type;
                    }
                    $i++;
                  }
                }

                if ( !empty( $saved_type_split ) && empty( $saved_type ) ) {
                  $saved_type = $saved_type_split;
                }

                if (($key = array_search('auto-detect', $post_type_choose)) !== false && ( is_archive() || is_search() ) ) {
                    unset($post_type_choose[$key]);
                    $post_type_choose[] = $wp_query->query_vars['post_type'];
                }

                $post_type_choose = array_unique($post_type_choose);

                $link_whole_gird_new_tab  = $this->props['link_whole_gird_new_tab'];
                if ( $link_whole_gird_new_tab == 'on' ) {
                  $this->add_classname('link_whole_new_tab');
                }

                $show_in_section = ( $link_whole_gird == 'off' && $this->props['show_in_section'] == 'on' )?'on':'off';
                $content_section_layout = ($show_in_section == 'on')?$this->props['content_section_layout']:'';
                $content_section_selector = ($show_in_section == 'on')?$this->props['content_section_selector']:'';
                $show_in_same_row_mobile = ($show_in_section == 'on')?$this->props['show_in_same_row_mobile']:'off';

                if ($is_main_loop == 'on') {
                  $this->add_classname('main-loop');
                }

                if( $button_use_icon == 'on' && $custom_icon != '' ){
                  $custom_icon_arr = explode('||', $custom_icon);
                  $custom_icon_font_family = ( !empty( $custom_icon_arr[1] ) && $custom_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
                  $custom_icon_font_weight = ( !empty( $custom_icon_arr[2] ))?$custom_icon_arr[2]:'400';
                  $custom_icon = DEDMACH_INIT::et_icon_css_content(esc_attr($custom_icon));//'data-icon="'. esc_attr( et_pb_process_font_icon( $custom_icon ) ) .'"';
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => 'body #page-container %%order_class%% .dmach-loadmore:after',
                    'declaration' => "content: \"{$custom_icon}\"!important;
                      font-family:{$custom_icon_font_family}!important;
                      font-weight:{$custom_icon_font_weight};",
                  ) );
                }else{
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => 'body #page-container %%order_class%% .dmach-loadmore:hover',
                    'declaration' => "padding: .3em 1em;",
                  ) );
                }

                if( !empty( $button_bg_color ) ){

                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => 'body #page-container %%order_class%% .dmach-loadmore',
                    'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
                  ) );
                }

                $this->add_classname( 'loadmore-align-' . $button_alignment );

                $this->add_classname('grid-layout-' . $grid_layout);

                if ( isset( $is_main_loop ) && $is_main_loop == 'on' ){
                  $this->add_classname( 'main-archive-loop' );
                }

                if ( $equal_height == 'on' ) {
                  $this->add_classname('same-height-cards');
                }

                if ( $align_last_bottom == 'on' ) {
                  $this->add_classname('align-last-module');
                }

                if ($enable_loadmore == 'on') {
                  $this->add_classname('loadmore-enabled');
                }

                if ($post_display_type == "wishlist") {
                    $this->add_classname(implode(' ', $saved_type));
                    // $this->add_classname("remove_wishlist");
                    $this->add_classname("wishlist_loop");
                }

                if ($post_display_type == "users_posts") {
                    $this->add_classname(implode(' ', $saved_type));
                    $this->add_classname("users_posts_loop");
                }


                wp_enqueue_script('divi-filter-js');
                wp_enqueue_script('markerclusterer-js');
                wp_enqueue_script('divi-filter-masonry-js');

                if ('on' === $custom_gutter_width) {
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .divi-filter-archive-loop > :not(.no-results-layout)',
                    'declaration' => sprintf(
                      'grid-row-gap: %1$s !important;',
                      esc_html( $gutter_row_gap )
                    ),
                  ) );
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .divi-filter-archive-loop > :not(.no-results-layout)',
                    'declaration' => sprintf(
                      'grid-column-gap: %1$s !important;',
                      esc_html( $gutter_row_column )
                    ),
                  ) );
                }


                if ( '' !== $loading_bg_color ) {
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .ajax-loading',
                    'declaration' => sprintf(
                      'background-color: %1$s !important;',
                      esc_html( $loading_bg_color )
                    ),
                  ) );
                }

                if ( '' !== $animation_color ) {
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .line',
                    'declaration' => sprintf(
                      'background-color: %1$s !important;',
                      esc_html( $animation_color )
                    ),
                  ) );
                }

                if ( '' !== $animation_color ) {
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .donut',
                    'declaration' => sprintf(
                      'border-top-color: %1$s !important;',
                      esc_html( $animation_color )
                    ),
                  ) );
                }

                if ( '' !== $animation_color ) {
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .donut.multi',
                    'declaration' => sprintf(
                      'border-bottom-color: %1$s !important;',
                      esc_html( $animation_color )
                    ),
                  ) );
                }

                if ( '' !== $animation_color ) {
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .ripple',
                    'declaration' => sprintf(
                      'border-color: %1$s !important;',
                      esc_html( $animation_color )
                    ),
                  ) );
                }

                //////////////////////////////////////////////////////////////////////

                ob_start();

                if ($post_display_type == "wishlist") {
                  ?>
                  <span id="wishlist_types" class="hidethis" data-types="<?php echo esc_attr( implode(',', $saved_type) ) ?>"></span>
                  <?php
              }

                $post_id = get_the_ID();
                $current_post_type = get_post_type( $post_id );

                $initial_query_vars = $wp_query->query_vars;
                $current_taxonomy = '';
                $current_tax_term = '';
                if ( !empty($initial_query_vars['taxonomy'] ) && !empty( $initial_query_vars['term'] ) ) {
                    $current_taxonomy = $initial_query_vars['taxonomy'];
                    $current_tax_term = $initial_query_vars['term'];
                }

                $et_paged = is_front_page() ? get_query_var( 'page' ) : (get_query_var( 'paged' )?get_query_var( 'paged' ):(!empty($_GET['page'])? $_GET['page'] :1) );

                if ( $is_main_loop == 'off' || !$et_paged ){
                    $et_paged = 1;
                }

                $cpt_taxonomies = get_object_taxonomies( $post_type_choose );

                $default_taxonomy_existing = false;

                if ( $post_display_type == "linked_post") {

                  if (is_array(get_sub_field_object($acf_linked_acf))) {
                    $acf_linked_acf_get = get_sub_field_object($acf_linked_acf);
                  } else {
                    $acf_linked_acf_get = get_field_object($acf_linked_acf);
                  }



                    if ( $acf_linked_acf_get['type'] == 'post_object' ||  $acf_linked_acf_get['type'] == 'relationship' ) {
                        if ( in_array( $current_post_type, $acf_linked_acf_get['post_type'] ) ) {

                            // In Linked Post type page, show post types that assigned to current post.  No 4.



                            $args = array(
                                'post_type'         => $post_type_choose,
                                'post_status'       => $post_status,
                                'posts_per_page'    => (int) $posts_number,
                                'offset'            => (int) $post_offset
                            );

                            if ( $acf_linked_acf_get['multiple'] == true ){
                                $args['meta_query'] = array(
                                    array(
                                        'key' => $acf_linked_acf_get['name'],
                                        'value' => get_the_ID(),
                                        'compare' => 'LIKE'
                                    )
                                );
                            }else{
                                //$args['meta_key'] = $acf_linked_acf_get['name'];
                                //$args['meta_value'] = get_the_ID();
                                $args['meta_query'] = array(
                                    array(
                                        'key' => $acf_linked_acf_get['name'],
                                        'value' => get_the_ID(),
                                    )
                                );
                            }
                        } else {



                            $post_type_in_acf = false;
                            foreach ( $post_type_choose as $key => $type ) {
                                if ( in_array( $type, $acf_linked_acf_get['post_type'] ) ) {
                                    $post_type_in_acf = true;
                                    break;
                                }
                            }

                            if ( $post_type_in_acf ) {
                                // In Main Post type page, display post types linked to current post. No 1.

                                $linked_post_ids = array();

                                if ( $acf_linked_acf_get['return_format'] == 'object' ) {
                                    if ( !empty( $acf_linked_acf_get['value'] ) ) {
                                      if (is_array($acf_linked_acf_get['value'])) {

                                        foreach( $acf_linked_acf_get['value'] as $key => $linked_post ) {
                                            $linked_post_ids[] = $linked_post->ID;
                                        }
                                      } else {

                                        $linked_post_ids[] = $acf_linked_acf_get['value']->ID;
                                      }
                                    }
                                } else {
                                    if(isset($linked_posts)){
$linked_post_ids = is_array( $linked_posts )?$linked_posts:array($linked_posts);
}
                                }

                                if ( empty( $linked_post_ids ) ) {
                                    $linked_post_ids = array( -1 );
                                }

                                $args = array(
                                    'post_type'         => $post_type_choose,
                                    'post_status'       => $post_status,
                                    'posts_per_page'    => (int) $posts_number,
                                    'offset'            => (int) $post_offset,
                                    'post__in'          => $linked_post_ids
                                );

                            }
                        }
                    } else if ( $acf_linked_acf_get['type'] == 'taxonomy' ) {
                      $args = array(
                          'post_type'         => $post_type_choose,
                          'post_status'       => $post_status,
                          'posts_per_page'    => (int) $posts_number,
                          'offset'            => (int) $post_offset,
                          'tax_query'         => array(
                            'relation'        => 'AND',
                            array(
                              'taxonomy'      => $acf_linked_acf_get['taxonomy'],
                              'field'         => 'term_id',
                              'terms'         => $acf_linked_acf_get['value'],
                              'operator'      => 'IN'
                            )
                          )
                      );
                    }

                    $args['tax_query']['relation'] = 'AND';

                    if ($include_cats != "") {

                        $include_cats_arr = explode(',', $include_cats);

                        $tax_query = array( 'relation' => 'OR' );

                        foreach ($post_type_choose as $key => $post_type ) {
                            if ( $post_type == "post") {
                                $tax_query[] = array(
                                    'taxonomy'  => 'category',
                                    'field'     => 'slug',
                                    'terms'     => $include_cats_arr,
                                    'operator' => 'IN'
                                );
                            } else {

                                $ending = "_category";
                                $cat_key = $post_type . $ending;
                                if ($cat_key == "product_category") {
                                    $cat_key = "product_cat";
                                }

                                if ( !empty( $cpt_taxonomies ) && in_array( $cat_key, $cpt_taxonomies ) ){
                                    $tax_query[] = array(
                                        'taxonomy'  => $cat_key,
                                        'field'     => 'slug',
                                        'terms'     => $include_cats_arr,
                                        'operator' => 'IN'
                                    );
                                }else if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                                    $tax_query[] = array(
                                        'taxonomy'  => 'category',
                                        'field'     => 'slug',
                                        'terms'     => $include_cats_arr,
                                        'operator' => 'IN'
                                    );

                                    //$GLOBALS['my_query_filters']['tax_query'] = $post_type_choose . '_category';
                                }
                            }
                        }

                        $args['tax_query'][] = $tax_query;
                    }

                    if ($show_current_post == "off") {
                        $args['post__not_in'] = array($post->ID);
                    }
                } else if ($post_display_type == "related") {


                    if (isset($post->ID)) {

                        $tax_array[] = "";

                        $related_exclude_cats_arr = explode(',', $related_exclude_cats);
                        $related_exclude_tags_arr = explode(',', $related_exclude_tags);

                        if ( in_array( "post", $post_type_choose ) ) {


                            $args = array(
                                'post_type'         => $post_type_choose,
                                'post_status'       => $post_status,
                                'posts_per_page'    => (int) $posts_number,
                                'offset'            => (int) $post_offset,
                                'meta_query'        => array(
                                    'relation'      => 'AND'
                                )
                            );

                            if ($related_content == "categories"){

                                $cats = wp_get_post_terms( $post->ID, 'category' );
                                foreach ( $cats as $cat ) {
                                    if( in_array( $cat->term_id ,$related_exclude_cats_arr ) )
                                    {

                                    } else {
                                        $tax_array[] = $cat->term_id;
                                    }
                                }

                                $args['cat'] = $tax_array;

                            } else if ($related_content == "post-object"){

                                $post_objects = get_field_object($acf_name_related);

                                $post_type_in_acf = false;
                                foreach ( $post_type_choose as $key => $type ) {
                                    if ( in_array( $type, $post_objects['post_type'] ) ) {
                                        $post_type_in_acf = true;
                                        break;
                                    }
                                }

                                // This is case No 3:

                                if ( $post_objects['type'] == 'post_object' && !$post_type_in_acf ){
                                    $linked_post_id = "";

                                    if ( $post_objects['multiple'] == true || $post_objects['multiple'] == 1 ){

                                        $get_value_arrs = $post_objects['value'];

                                        if ($specific_post_objects = 'on') {

                                          $posts_in_array = array();
                                            foreach ($get_value_arrs as $get_value_arr)
                                            {

                                          array_push($posts_in_array, $get_value_arr->ID);
                                              // array_push($meta_query, array(
                                              //     'key' => $post_objects['name'],
                                              //     'value' => '"' . $get_value_arr->ID . '"',
                                              //     'compare' => 'LIKE'
                                              // ));
                                          }
                                          $args['post__in'] = $posts_in_array;

                                        } else {
                                          if ( !empty( $get_value_arrs ) ) {
                                            $meta_query = array(
                                              'relation' => 'OR'
                                            );

                                            foreach ($get_value_arrs as $get_value_arr) {
                                                array_push($meta_query, array(
                                                    'key' => $post_objects['name'],
                                                    'value' => '"' . $get_value_arr->ID . '"',
                                                    'compare' => 'LIKE'
                                                ));
                                            }
                                        } else {
                                            $args['post__in'] = array( -1 );
                                        }
                                        }


                                    } else {

                                        $get_value = $post_objects['value'];
                                        $linked_post_id = $get_value->ID;

                                      if ($specific_post_objects = 'on') {
                                        $args['post__in'] = array($linked_post_id);
                                      } else {

                                        $meta_query = array(
                                            array(
                                                'key' => $post_objects['name'],
                                                'value' =>  $linked_post_id,
                                                'compare' => 'LIKE'
                                            )
                                        );

                                      }
                                    }

                                    $args['meta_query'][] = $meta_query ?? '';
                                } else if ( $post_objects['type'] == 'post_object' && $post_type_in_acf ) {

                                    // Case No 2:
                                    $related_post_ids = array();
                                    if ( $post_objects['return_format'] == 'object' ) {
                                        if ( !empty( $post_objects['value'] ) ) {
                                            foreach ( $post_objects['value'] as $post_ind => $post_obj ) {
                                                $related_post_ids[] = $post_obj->ID;
                                            }
                                        }
                                    } else if ( $post_objects['return_format'] == 'id' ) {
                                        $related_post_ids = is_array( $post_objects['value'] ) ? $post_objects['value']: array($post_objects['value']);
                                    }

                                    if ( !empty( $related_post_ids ) ) {
                                        $args['post__in'] = $related_post_ids;
                                    }
                                }
                              } else if ( $related_content == 'tags' ) {

                                $cats = wp_get_post_terms( $post->ID, 'post_tag' );
                                foreach ( $cats as $cat ) {
                                  if( in_array( $cat->term_id ,$related_exclude_tags_arr ) )
                                  {

                                  } else {
                                    $tax_array[] = $cat->term_id;
                                  }
                                }

                                if ( in_array( "post", $post_type_choose ) ) {
                                    $args['tag__in'] = $tax_array;
                                } else {
                                    $args['tag'] = $tax_array;
                                }
                            } else if ( $related_content == 'taxonomy' ) {
                                $terms = wp_get_post_terms( $post->ID, $tax_name_related );
                                foreach ($terms  as $key => $term) {
                                    $tax_array[] = $term->term_id;  
                                }

                                if ( !isset($args['tax_query']) ) {
                                    $args['tax_query'] = array(
                                      'relation'  => 'AND'
                                    );
                                }

                                $args['tax_query'][] = array(
                                    'taxonomy'  => $tax_name_related,
                                    'field'     => 'id',
                                    'terms'     => $tax_array
                                );
                            }
                        } else {

                            if ($related_content == "categories"){

                                $args = array(
                                    'post_type'         => $post_type_choose,
                                    'post_status'       => $post_status,
                                    'posts_per_page'    => (int) $posts_number,
                                    'offset'            => (int) $post_offset
                                );


                                $tax_query = array( 'relation' => 'OR' );
                                $tax_array = array();
                                foreach ( $post_type_choose as $key => $type ){
                                    if ($related_content_categories == "post_cats") {
                                        $category_name = 'category';
                                    } else {
                                        $category_name = $type . '_category';

                                        if ($category_name == "product_category") {
                                            $category_name = "product_cat";
                                        } else {
                                            $category_name = $category_name;
                                        }
                                    }

                                    $cats = wp_get_post_terms( $post->ID, $category_name );

                                    foreach ( $cats as $cat ) {
                                        if( $cat->term_id != 0 && !in_array( $cat->term_id ,$related_exclude_cats_arr ) ) {
                                            $tax_array[] = $cat->term_id;
                                        }
                                    }

                                    $tax_query[] = array(
                                        'taxonomy' => $category_name,
                                        'field' => 'id',
                                        'terms' => $tax_array
                                    );
                                }

                                $args['tax_query'] = array(
                                    'relation' => 'AND',
                                    array(
                                        $tax_query
                                    )
                                );

                            } else if ($related_content == "post-object"){

                                $args = array(
                                    'post_type'         => $post_type_choose,
                                    'post_status'       => $post_status,
                                    'posts_per_page'    => (int) $posts_number,
                                    'offset'            => (int) $post_offset,
                                    'meta_query'        => array(
                                        'relation'      => 'AND'
                                    )
                                );

                                $post_objects = get_field_object($acf_name_related);

                                $post_type_in_acf = false;
                                foreach ( $post_type_choose as $key => $type ) {
                                    if ( isset( $post_objects['post_type'] ) && in_array( $type, $post_objects['post_type'] ) ) {
                                        $post_type_in_acf = true;
                                        break;
                                    }
                                }

                                // This is case No 3:

                                if ( $post_objects['type'] == 'post_object' && !$post_type_in_acf ){

                                    $linked_post_id = "";

                                    if ( $post_objects['multiple'] == true || $post_objects['multiple'] == 1 ){
                                        $get_value_arrs = $post_objects['value'];
                                        if ( !empty( $get_value_arrs ) ) {
                                            $meta_query = array(
                                                'relation' => 'OR'
                                            );

                                            foreach ($get_value_arrs as $get_value_arr) {
                                                array_push($meta_query, array(
                                                    'key' => $post_objects['name'],
                                                    'value' => '"' . $get_value_arr->ID . '"',
                                                    'compare' => 'LIKE'
                                                ));
                                            }
                                        } else {
                                            $args['post__in'] = array( -1 );
                                        }
                                    } else {
                                        $get_value = $post_objects['value'];
                                        $linked_post_id = $get_value->ID;

                                        $meta_query = array(
                                            array(
                                                'key' => $post_objects['name'],
                                                'value' =>  $linked_post_id,
                                                'compare' => 'LIKE'
                                            )
                                        );
                                    }

                                    $args['meta_query'][] = $meta_query ?? '';
                                } else if ( $post_objects['type'] == 'post_object' && $post_type_in_acf ) {

                                    // Case No 2:
                                    $related_post_ids = array();
                                    if ( $post_objects['return_format'] == 'object' ) {
                                        if ( !empty( $post_objects['value'] ) ) {
                                            foreach ( $post_objects['value'] as $post_ind => $post_obj ) {
                                                $related_post_ids[] = $post_obj->ID;
                                            }
                                        }
                                    } else if ( $post_objects['return_format'] == 'id' ) {
                                        $related_post_ids = is_array( $post_objects['value'] ) ? $post_objects['value']: array($post_objects['value']);
                                    }

                                    if ( !empty( $related_post_ids ) ) {
                                        $args['post__in'] = $related_post_ids;
                                    }
                                }
                              } else if ( $related_content == 'tags' ) {

                                $args = array(
                                    'post_type'         => $post_type_choose,
                                    'post_status'       => $post_status,
                                    'posts_per_page'    => (int) $posts_number,
                                    'offset'            => (int) $post_offset,
                                );

                                $tax_query = array( 'relation' => 'OR' );
                                $tax_array = array();
                                foreach ( $post_type_choose as $key => $type ){
                                    if ($related_content_categories == "post_cats") {
                                        $category_name = 'tag';
                                    } else {
                                        $category_name = $type . '_tag';
                                    }

                                    $cats = wp_get_post_terms( $post->ID, $category_name );

                                    foreach ( $cats as $cat ) {
                                        if( $cat->term_id != 0 && !in_array( $cat->term_id ,$related_exclude_tags_arr ) ) {
                                            $tax_array[] = $cat->term_id;
                                        }
                                    }

                                    $tax_query[] = array(
                                        'taxonomy' => $category_name,
                                        'field' => 'id',
                                        'terms' => $tax_array
                                    );
                                }

                                $args['tax_query'] = array(
                                    'relation' => 'AND',
                                    array(
                                        $tax_query
                                    )
                                );
                          
                                /*if ($related_content == "categories" && $related_content_categories == "post_cats") {

                                    $cats = wp_get_post_terms( $post->ID, 'category' );
                                    foreach ( $cats as $cat ) {
                                        if( in_array( $cat->term_id ,$related_exclude_cats_arr ) )
                                        {
                                        } else {
                                            $tax_array[] = $cat->term_id;
                                        }
                                    }

                                    $args['cat'] = $tax_array;
                                } else if ($related_content == "tags" && $related_content_tags == "post_tags") {
                                    $cats = wp_get_post_terms( $post->ID, 'post_tag' );
                                    foreach ( $cats as $cat ) {
                                        if( in_array( $cat->term_id ,$related_exclude_tags_arr ) )
                                        {
                                        } else {
                                            $tax_array[] = $cat->term_id;
                                        }
                                    }

                                    $args['tag__in'] = $tax_array;
                                } else {
                                    if ( $category_name != '' ) {
                                        $args['tax_query'] = array(
                                            'relation' => 'AND',
                                            array(
                                                'taxonomy' => $category_name,
                                                'field' => 'id',
                                                'terms' => $tax_array
                                            )
                                        );
                                    }
                                }*/
                            } else if ( $related_content == 'taxonomy' ) {

                                $args = array(
                                    'post_type'         => $post_type_choose,
                                    'post_status'       => $post_status,
                                    'posts_per_page'    => (int) $posts_number,
                                    'offset'            => (int) $post_offset,
                                );
                                
                                $terms = wp_get_post_terms( $post->ID, $tax_name_related );
                                foreach ($terms  as $key => $term) {
                                    $tax_array[] = $term->term_id;  
                                }

                                if ( !isset($args['tax_query']) ) {
                                    $args['tax_query'] = array(
                                      'relation'  => 'AND'
                                    );
                                }

                                $args['tax_query'][] = array(
                                    'taxonomy'  => $tax_name_related,
                                    'field'     => 'id',
                                    'terms'     => $tax_array
                                );
                            }
                        }
                    }

                    if ($acf_name != "none") {

                        if ($acf_value != "") {

                            $acf_name_get = get_field_object($acf_name);


                            if ($acf_name_get['type'] == "radio" || $acf_name_get['type'] == "checkbox") {
                              $val_array = explode(',', $acf_value);
                              if ( is_array( $val_array ) && count( $val_array ) > 1 ){
                                  $query_arr = array( 'relation' => 'OR' );
                                  foreach ( $val_array as $meta_val ) {
                                    if ( isset( $acf_name_get['multiple'] ) && $acf_name_get['multiple'] == 1 ) {
                                      $query_arr[] = array(
                                          'key'       => $acf_name_get['name'],
                                          'value'     => '"' . $meta_val . '"',
                                          'compare'   => 'LIKE',
                                      );
                                    }else{
                                      if ( $acf_name_get['type'] == "checkbox" )  {
                                        $query_arr[] = array(
                                          'key'       => $acf_name_get['name'],
                                          'value'     => $meta_val,
                                          'compare'   => 'LIKE',
                                        );
                                      }else{
                                        $query_arr[] = array(
                                          'key'       => $acf_name_get['name'],
                                          'value'     => $meta_val,
                                        );
                                      }

                                    }
                                  }
                                  $meta_query[] = $query_arr;
                              }else{
                                  if ( isset( $acf_name_get['multiple'] ) && $acf_name_get['multiple'] == 1 ) {
                                    $meta_query[] = array(
                                        'key' => $acf_name_get['name'],
                                        'value' => '"' . $acf_value . '"',
                                        'compare' => 'LIKE'
                                    );
                                  } else{
                                    if ( $acf_name_get['type'] == 'checkbox' ) {
                                      $meta_query[] = array(
                                        'key' => $acf_name_get['name'],
                                        'value' => $acf_value,
                                        'compare' => 'LIKE',
                                      );
                                    }else{
                                      $meta_query[] = array(
                                        'key' => $acf_name_get['name'],
                                        'value' => $acf_value,
                                      );
                                    }

                                  }
                              }
                            } else if (isset($acf_name_get['type']) && $acf_name_get['type'] == "range") {

                              $price_value = (explode(";",$acf_value));

                              if ( count( $price_value ) == 1 ){
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
                              if ( isset( $acf_name_get['multiple'] ) && $acf_name_get['multiple'] == true ){
                                $meta_query[] = array(
                                    'key' => $acf_name_get['name'],
                                    'value' => '"' .$acf_value . '"',
                                    'compare' => 'LIKE'
                                );
                              } else{
                              $meta_query[] = array(
                                  'key' => $acf_name_get['name'],
                                  'value' => $acf_value,
                                  'compare' => 'IN'
                                );
                              }
                            }




                            $args['meta_query'][] = $meta_query ?? '';

                            // $args['meta_key']    = $acf_name_get['name'];
                            // $args['meta_value']  = $acf_value;
                        } else {
                            $acf_name_get = get_field_object($acf_name);

                            if ( $acf_name_get ) {
                            $meta_query[] = array(
                                'key' => $acf_name_get['name'],
                                'value' => '',
                                'compare' => '!='
                            );

                            $args['meta_query'][] = $meta_query;
                        }
                    }
                    }

                    if ($show_current_post == "off") {
                        $args['post__not_in'] = array($post->ID);
                    }
                } else if ($post_display_type == "wishlist") {


                    // TODO: Get wishlist IDs from database

                    $user_id = get_current_user_id();


                    $wishlist_ids = '';

                    $wishlist_ids_arr = array();


                    foreach($saved_type as $saved_type_multiple_name) {
                        $saved_type_multiple_name_settings = get_user_meta( $user_id, 'machine_' . $saved_type_multiple_name , true );

                        if (is_array($saved_type_multiple_name_settings)) {
                            foreach ( $post_type_choose as $key => $type ) {
                                if(array_key_exists($type,$saved_type_multiple_name_settings)){
                                    if ($saved_type_multiple_name_settings[$type]) {
                                        $wishlist_ids_add = $saved_type_multiple_name_settings[$type];
                                    }
                                }

                                if(!empty($wishlist_ids_add)){
                                    $wishlist_ids_arr = (array_merge($wishlist_ids_arr,$wishlist_ids_add));
                                }
                            }
                        }

                    }


                    if ( !empty($wishlist_ids_arr)) {
                        $wishlist_ids = $wishlist_ids_arr;
                    } else {
                        $wishlist_ids = array("9824139842183412321348912");
                    }


                    // REMOVE DISLIKE POSTS
                    $dislike_ids_arr = array();

                    $dmach_acc_types_dislike = de_get_option_value( 'divi-machine', 'dmach_acc_types_dislike' );
                    $dmach_acc_types_dislike_array = explode(',', $dmach_acc_types_dislike);

                    foreach($dmach_acc_types_dislike_array as $value) {
                        $dmach_acc_types_dislike_settings = get_user_meta( $user_id, 'machine_' . $value , true );

                        if (is_array($dmach_acc_types_dislike_settings)) {
                            foreach ( $post_type_choose as $key => $type ) {
                                if ($dmach_acc_types_dislike_settings[$type]) {
                                    $dislike_ids_add = $dmach_acc_types_dislike_settings[$type];
                                }

                                if(isset($dislike_ids_add)){
$dislike_ids_arr = (array_merge($dislike_ids_arr,$dislike_ids_add));
}
                            }
                        }

                    }

                    $wishlist_ids = array_diff($wishlist_ids, $dislike_ids_arr);


                    $args = array(
                        'post_type'         => $post_type_choose,
                        'post_status'       => $post_status,
                        'posts_per_page'    => (int) $posts_number,
                        'offset'            => (int) $post_offset,
                        'post__in'          => $wishlist_ids,
                        'post__not_in'      => $dislike_ids_arr,
                        'orderby' => 'post__in'
                    );

                } else {


                    $args = array(
                        'post_type'         => $post_type_choose,
                        'post_status'       => $post_status,
                        'posts_per_page'    => (int) $posts_number,
                        'offset'            => (int) $post_offset,
                        'post__not_in'      => explode(',', $exclude_products),
                    );

                    // Check current page is single post page for selected post type and get current post id

                    $meta_query = array('relation' => 'AND');

                    $current_post = 0;
                    if ( $wp_query->is_main_query()
                        && $wp_query->is_singular()
                        && $wp_query->is_single()
                        && in_array( $wp_query->post->post_type,  $post_type_choose ) ){
                        $current_post = $wp_query->post->ID;
                    }

                    if ( $current_post != 0 && $show_current_post == "off"){
                        $args['post__not_in'][] = $current_post;
                    }

                    $args['tax_query']['relation'] = 'AND';

                    if ($include_cats != "") {

                        $include_cats_arr = explode(',', $include_cats);

                        $tax_query = array( 'relation' => 'OR' );

                        foreach ($post_type_choose as $key => $post_type ) {
                            if ( $post_type == "post") {
                                $tax_query[] = array(
                                    'taxonomy'  => 'category',
                                    'field'     => 'slug',
                                    'terms'     => $include_cats_arr,
                                    'operator' => 'IN'
                                );
                            } else {

                                $ending = "_category";
                                $cat_key = $post_type . $ending;
                                if ($cat_key == "product_category") {
                                    $cat_key = "product_cat";
                                }

                                if ( !empty( $cpt_taxonomies ) && in_array( $cat_key, $cpt_taxonomies ) ){
                                    $tax_query[] = array(
                                        'taxonomy'  => $cat_key,
                                        'field'     => 'slug',
                                        'terms'     => $include_cats_arr,
                                        'operator' => 'IN'
                                    );
                                }else if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                                    $tax_query[] = array(
                                        'taxonomy'  => 'category',
                                        'field'     => 'slug',
                                        'terms'     => $include_cats_arr,
                                        'operator' => 'IN'
                                    );

                                    //$GLOBALS['my_query_filters']['tax_query'] = $post_type_choose . '_category';
                                }
                            }
                        }

                        $args['tax_query'][] = $tax_query;
                    }

                    if ($exclude_cats != "") {
                        $exclude_cats_arr = explode(',', $exclude_cats);
                        $tax_query = array( 'relation' => 'AND' );

                        foreach ($post_type_choose as $key => $post_type ) {
                            if ( $post_type == "post") {
                                $tax_query[] = array(
                                    'taxonomy'  => 'category',
                                    'field'     => 'slug',
                                    'terms'     => $exclude_cats_arr,
                                    'operator' => 'NOT IN'
                                );
                            } else {
                                $ending = "_category";
                                $cat_key = $post_type . $ending;
                                if ($cat_key == "product_category") {
                                    $cat_key = "product_cat";
                                }

                                if ( !empty( $cpt_taxonomies ) && in_array( $cat_key, $cpt_taxonomies ) ){
                                    $tax_query[] = array(
                                        'taxonomy'  => $cat_key,
                                        'field'     => 'slug',
                                        'terms'     => $exclude_cats_arr,
                                        'operator' => 'NOT IN'
                                    );
                                }else if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                                    $tax_query[] = array(
                                        'taxonomy'  => 'category',
                                        'field'     => 'slug',
                                        'terms'     => $exclude_cats_arr,
                                        'operator' => 'NOT IN'
                                    );
                                }
                            }
                        }

                        $args['tax_query'][] = $tax_query;
                    }

                    if ($include_tags != "") {

                        $include_tags_arr = explode(',', $include_tags);

                        $tax_query = array( 'relation' => 'OR' );

                        foreach ($post_type_choose as $key => $post_type ) {
                                $ending = "_tag";
                                $cat_key = $post_type . $ending;

                                $tax_query[] = array(
                                    'taxonomy'  => $cat_key,
                                    'field'     => 'slug',
                                    'terms'     => $include_tags_arr,
                                    'operator' => 'IN'
                                );
                            }

                        $args['tax_query'][] = $tax_query;
                    }

                    if ($exclude_tags != "") {
                        $exclude_tags_arr = explode(',', $exclude_tags);
                        $tax_query = array( 'relation' => 'AND' );

                        foreach ($post_type_choose as $key => $post_type ) {
                            $ending = "_tag";
                            $cat_key = $post_type . $ending;

                            $tax_query[] = array(
                                'taxonomy'  => $cat_key,
                                'field'     => 'slug',
                                'terms'     => $exclude_tags_arr,
                                'operator' => 'NOT IN'
                            );
                        }

                        $args['tax_query'][] = $tax_query;
                    }



                    if ( $include_taxomony != "" ) {
                        $args['tax_query'][] = array(
                            'taxonomy'  => $custom_tax_choose,
                            'field'     => 'slug',
                            'terms'     => explode(',', $include_taxomony),
                            'operator' => 'IN'
                        );
                    }

                    if ($acf_name != "none") {

                        if ($acf_value != "") {

                            $acf_name_get = get_field_object($acf_name);


                            if ($acf_name_get['type'] == "radio" || $acf_name_get['type'] == "checkbox") {
                              $val_array = explode(',', $acf_value);
                              if ( is_array( $val_array ) && count( $val_array ) > 1 ){
                                  $query_arr = array( 'relation' => 'OR' );
                                  foreach ( $val_array as $meta_val ) {
                                    if ( isset( $acf_name_get['multiple'] ) && $acf_name_get['multiple'] == 1 ) {
                                      $query_arr[] = array(
                                          'key'       => $acf_name_get['name'],
                                          'value'     => '"' . $meta_val . '"',
                                          'compare'   => 'LIKE',
                                      );
                                    }else{
                                      if ( $acf_name_get['type'] == "checkbox" )  {
                                        $query_arr[] = array(
                                          'key'       => $acf_name_get['name'],
                                          'value'     => $meta_val,
                                          'compare'   => 'LIKE',
                                        );
                                      }else{
                                        $query_arr[] = array(
                                          'key'       => $acf_name_get['name'],
                                          'value'     => $meta_val,
                                        );
                                      }

                                    }
                                  }
                                  $meta_query[] = $query_arr;
                              }else{
                                  if ( isset( $acf_name_get['multiple'] ) && $acf_name_get['multiple'] == 1 ) {
                                    $meta_query[] = array(
                                        'key' => $acf_name_get['name'],
                                        'value' => '"' . $acf_value . '"',
                                        'compare' => 'LIKE'
                                    );
                                  } else{
                                    if ( $acf_name_get['type'] == 'checkbox' ) {
                                      $meta_query[] = array(
                                        'key' => $acf_name_get['name'],
                                        'value' => $acf_value,
                                        'compare' => 'LIKE',
                                      );
                                    }else{
                                      $meta_query[] = array(
                                        'key' => $acf_name_get['name'],
                                        'value' => $acf_value,
                                      );
                                    }

                                  }
                              }
                            } else if (isset($acf_name_get['type']) && $acf_name_get['type'] == "range") {

                              $price_value = (explode(";",$acf_value));

                              if ( count( $price_value ) == 1 ){
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
								$meta_query[] = array(
									'key'	=> $acf_name_get['name'],
									'value'	=> $acf_value
								);
                            } else {
                              if ( isset( $acf_name_get['multiple'] ) && $acf_name_get['multiple'] == true ){
                                $meta_query[] = array(
                                    'key' => $acf_name_get['name'],
                                    'value' => $acf_value,
                                    'compare' => 'LIKE'
                                );
                              } else{
                              $meta_query[] = array(
                                  'key' => $acf_name_get['name'],
                                  'value' => $acf_value,
                                  'compare' => 'IN'
                                );
                              }
                            }




                            $args['meta_query'] = $meta_query;

                            // $args['meta_key']    = $acf_name_get['name'];
                            // $args['meta_value']  = $acf_value;
                        } else {
                            $acf_name_get = get_field_object($acf_name);

                            if ( $acf_name_get ) {
                            $meta_query[] = array(
                                'key' => $acf_name_get['name'],
                                'value' => '',
                                'compare' => '!='
                            );

                            $args['meta_query'][] = $meta_query;
                        }
                    }
                    }


                  /////////////////////////////////// ON LOAD TERMS


                  if ($onload_cats != "" ) {

                    $onload_cats_arr = explode(',', $onload_cats);

                    $tax_query = array( 'relation' => 'OR' );

                    foreach ($post_type_choose as $key => $post_type ) {
                        if ( $post_type == "post") {
                        	if ( !isset($_GET['filter'] ) || !isset( $_GET['category'] ) ) {
                        		$tax_query[] = array(
	                                'taxonomy'  => 'category',
	                                'field'     => 'slug',
	                                'terms'     => $onload_cats_arr,
	                                'operator' => 'IN'
	                            );
                        	}
                        } else {

                            $ending = "_category";
                            $cat_key = $post_type . $ending;
                            if ($cat_key == "product_category") {
                                $cat_key = "product_cat";
                            }

                            if ( !empty( $cpt_taxonomies ) && in_array( $cat_key, $cpt_taxonomies ) ){
                            	if ( !isset($_GET['filter'] ) || !isset( $_GET[ $cat_key] ) ) {
                            		$tax_query[] = array(
	                                    'taxonomy'  => $cat_key,
	                                    'field'     => 'slug',
	                                    'terms'     => $onload_cats_arr,
	                                    'operator' => 'IN'
	                                );
                            	}
                            }else if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                            	if ( !isset($_GET['filter'] ) || !isset( $_GET['category'] ) ) {
	                                $tax_query[] = array(
	                                    'taxonomy'  => 'category',
	                                    'field'     => 'slug',
	                                    'terms'     => $onload_cats_arr,
	                                    'operator' => 'IN'
	                                );
                            	}
                                //$GLOBALS['my_query_filters']['tax_query'] = $post_type_choose . '_category';
                            }
                        }
                    }

                    $args['tax_query'][] = $tax_query;
                }

                if ($onload_tags != "") {

                  $onload_tags_arr = explode(',', $onload_tags);

                  $tax_query = array( 'relation' => 'OR' );

                  foreach ($post_type_choose as $key => $post_type ) {
                          $ending = "_tag";
                          $cat_key = $post_type . $ending;

                          if ( !isset($_GET['filter'] ) || !isset( $_GET[$cat_key] ) ) {
                          	$tax_query[] = array(
                              'taxonomy'  => $cat_key,
                              'field'     => 'slug',
                              'terms'     => $onload_tags_arr,
                              'operator' => 'IN'
                          	);
                          }
                      }

                  $args['tax_query'][] = $tax_query;
              }

              if ( $onload_taxomony != "" && (!isset($_GET['filter']) || !isset( $_GET[$onload_tax_choose] ) ) ) {
                $args['tax_query'][] = array(
                    'taxonomy'  => $onload_tax_choose,
                    'field'     => 'slug',
                    'terms'     => explode(',', $onload_taxomony),
                    'operator' => 'IN'
                );
              }

                  // if ($author != "") {
                  //   $args['author_name'] = $author;
                  // }

                  $args['tax_query']['relation'] = 'AND';

                  $args['paged'] = $et_paged;

                  if ( isset( $is_main_loop ) && $is_main_loop == 'on' ) {

                    if ( $wp_query->is_main_query()
                        && $wp_query->is_archive()
                        && !empty( $wp_query->query_vars['taxonomy'] )
                        && in_array( $wp_query->query_vars['taxonomy'], $cpt_taxonomies ) ){

                        $args['tax_query'][] = array(
                            'taxonomy'  => $wp_query->query_vars['taxonomy'],
                            'field'     => 'slug',
                            'terms'     => $wp_query->query_vars['term']
                        );

                        $GLOBALS['my_query_filters']['tax_query'] = $wp_query->query_vars['taxonomy'];
                        $default_taxonomy_existing = true;
                    }

                    if ( $wp_query->is_main_query() && $wp_query->is_archive() ){


                      if ( !empty( $wp_query->query['author_name'] ) ){
                        $args['author_name'] = $wp_query->query['author_name'];
                      }

                      if ( !empty( $wp_query->query_vars['cat'] ) ){
                        $args['cat'] = $wp_query->query_vars['cat'];
                      }

                      if ( !empty( $wp_query->query_vars['category'] ) ){
                        $args['category'] = $wp_query->query_vars['category'];
                      }

                      if ( !empty( $wp_query->query_vars['category_name'] ) ){
                        $args['category_name'] = $wp_query->query_vars['category_name'];
                      }

                      if ( !empty( $wp_query->query_vars['tag'] ) ){
                        $args['tag'] = $wp_query->query_vars['tag'];
                      }

                      if ( !empty( $wp_query->query_vars['year'] ) ){
                        $args['year'] = $wp_query->query_vars['year'];
                      }

                      if ( !empty( $wp_query->query_vars['monthnum'] ) ){
                        $args['monthnum'] = $wp_query->query_vars['monthnum'];
                      }

                      foreach( $post_type_choose as $key => $type ) {
                        if ( !empty( $wp_query->query_vars[$type . '_tag'] ) ){

                            $cat_key = $type . '_tag';
                            $cus_tag_show = $wp_query->query_vars[$type . '_tag'];
                            $args['tax_query'][] = array(
                              'taxonomy'  => $cat_key,
                              'field'     => 'slug',
                              'terms'     => $cus_tag_show,
                              'operator' => 'IN'
                            );

                        }

                        if ( !empty( $wp_query->query_vars[$type . '_category'] ) ){

                            $cat_key = $type . '_category';
                            $cus_tag_show = $wp_query->query_vars[$type . '_category'];

                            if ($cus_tag_show != "all"){

                                $val_and_array = explode( '|', $cus_tag_show );
                                if ( is_array( $val_and_array ) && count( $val_and_array ) > 1 ) {
                                    $sub_tax_query = array(
                                        'relation' => 'AND'
                                    );
                                    foreach ($val_and_array as $key => $or_value) {
                                        $sub_tax_query[] = array(
                                            'taxonomy'  => $cat_key,
                                            'field'     => 'slug',
                                            'terms'     => explode( ',' , $or_value ),
                                            'operator' => 'IN'
                                        );
                                    }
                                    $args['tax_query'][] = $sub_tax_query;
                                } else {
                                    $args['tax_query'][] = array(
                                        'taxonomy'  => $cat_key,
                                        'field'     => 'slug',
                                        'terms'     => explode( ',' , $cus_tag_show ),
                                        'operator' => 'IN'
                                    );
                                }
                            }
                        }
                      }
                    }

                    if ($is_category_loop == 'on') {
                      global $de_categoryloop_term;
                      if (isset($de_categoryloop_term)) {
                      } else {
                        $de_categoryloop_term = get_queried_object();
                      }

                      $args['tax_query'][] = array(
                        'taxonomy'  => $de_categoryloop_term->taxonomy,
                        'field'     => 'slug',
                        'terms'     => $de_categoryloop_term->slug,
                        'operator' => 'IN'
                      );
                    }

                    $field_keys = array();

                    foreach ( $post_type_choose as $key => $type ) {
                        $groups = acf_get_field_groups(array('post_type' => $type));
                        foreach( $groups as $group ){
                          $fields = acf_get_fields($group['ID']);
                          foreach( $fields as $field ){
                            $field_keys[] = $field['key'];
                          }
                        }
                    }

                    // loop over filters
                    foreach( $GLOBALS['my_query_filters'] as $key => $name ) {
                      if ( !in_array( $key, $field_keys ) ) {
                    continue;
                      }
                      if ( isset($_GET[ $name ]) && $_GET[ $name ] != "" ) {


                        if ( $key == 'tax_query') {
                          continue;
                        }

                        $acf_get = get_field_object($key);

                        $acf_type = $acf_get['type'];
                        $_GET[$name] = stripslashes(urldecode($_GET[$name]));

                      // append meta query
                      if ($acf_type == 'range') {

                        $value_between = str_replace("%3B",";", $_GET[ $name ]);

                        $value = ( explode( ";", $value_between ) );

                        if ( count( $value ) == 1 ) {
                          $meta_query[] = array(
                            'key' => $name,
                            'value' => $value[0],
                            'type' => 'NUMERIC',
                            'compare' => '<='
                          );
                        }else{
                          $meta_query[] = array(
                            'key' => $name,
                            'value' => $value,
                            'compare' => 'BETWEEN',
                            'type' => 'NUMERIC'
                          );
                        }

                      } else if ($acf_type == "checkbox" ) {
                        $range_values = explode(';', $_GET[ $name ] );
                        if ( is_array( $range_values ) && sizeof($range_values) > 1 ){
                          $sub_query = array();
                          foreach( $acf_get['choices'] as $choice_val => $choice_label ) {
                              if ( ( floatval($choice_val) >= floatval($range_values[0] ) )
                                      && ( floatval($choice_val) <= floatval($range_values[1] ) ) ) {
                                  $sub_query[] = array(
                                      'key' => $name,
                                      'value' => '"' . $choice_val . '"',
                                      'type'  => 'CHAR',
                                      'compare' => 'LIKE'
                                  );
                              }
                          }
                          if ( !empty( $sub_query ) ) {
                              $sub_query['relation'] = 'OR';
                              $meta_query[] = $sub_query;
                          } else {
                              $meta_query[] = array(
                                    'key' => $name,
                                    'value' => null,
                                    'compare' => 'IN'
                                );
                          }
                        } else {
                          $val_and_array = explode('|', $_GET[ $name ]);
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
                                              'key' => $name,
                                              'value' => '"' . $meta_val . '"',
                                              'type' => 'CHAR',
                                              'compare' => 'LIKE',
                                          );
                                      }
                                      $query_arr[] = $query_sub_arr;
                                  } else {
                                      $query_arr[] = array(
                                          'key' => $name,
                                          'value' => '"' . $or_value . '"',
                                          'type' => 'CHAR',
                                          'compare' => 'LIKE',
                                      );
                                  }
                              }
                              $meta_query[] = $query_arr;
                          } else {
                              $val_array = explode( ',',  $_GET[ $name ]  );
                              if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                  $query_arr = array( 'relation' => 'OR' );
                                  foreach ( $val_array as $meta_val ) {
                                      $query_arr[] = array(
                                          'key' => $name,
                                          'value' => '"' . $meta_val . '"',
                                          'type' => 'CHAR',
                                          'compare' => 'LIKE',
                                      );
                                  }
                                  $meta_query[] = $query_arr;
                              } else {
                                  $meta_query[] = array(
                                      'key' => $name,
                                      'value' => '"' . $_GET[ $name ] . '"',
                                      'type' => 'CHAR',
                                      'compare' => 'LIKE',
                                  );
                              }
                          }
                        }
                      } else if ( $acf_type == "google_map" ) {
                        $address =  $_GET[ $name ] ;
                        $address = str_replace(" ", "+", $address);

                        $et_google_api_settings = get_option( 'et_google_api_settings' );
                        if ( isset( $et_google_api_settings['api_key'] ) ) {
                          $key = $et_google_api_settings['api_key'];
                          $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=" . $key);
                          $json = json_decode($json);

                          $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                          $lng = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

                          $address_filter_var['is_filter']  = true;
                          $address_filter_var['lat']  = $lat;
                          $address_filter_var['lng']  = $lng;
                          $address_filter_var['radius']  = !empty($_GET['map_radius'])? $_GET['map_radius'] :30;
                          $address_filter_var['radius_unit']  = !empty($_GET['map_radius_unit'])? $_GET['map_radius_unit'] :'km';
                          $address_filter_var['address_field']  = $name;
                        }
                      } else {
                        $value = explode(',', $_GET[ $name ]);
                        $range_values = explode(';', $_GET[ $name ] );
                        if ( isset($acf_get['multiple']) && $acf_get['multiple'] == true ){
                          if ( is_array( $range_values ) && count($range_values) > 1 ){
                            $sub_query = array();
                            foreach( $acf_get['choices'] as $choice_val => $choice_label ) {
                                if ( ( floatval($choice_val) >= floatval($range_values[0] ) )
                                        && ( floatval($choice_val) <= floatval($range_values[1] ) ) ) {
                                    $sub_query[] = array(
                                        'key' => $name,
                                        'value' => '"' . $choice_val . '"',
                                        'type'  => 'CHAR',
                                        'compare' => 'LIKE'
                                    );
                                }
                            }
                            if ( !empty( $sub_query ) ) {
                                $sub_query['relation'] = 'OR';
                                $meta_query[] = $sub_query;
                            }
                          } else {
                            $val_and_array = explode('|', $_GET[ $name ]);
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
                                                'key' => $name,
                                                'value' => '"' . $meta_val . '"',
                                                'type' => 'CHAR',
                                                'compare' => 'LIKE',
                                            );
                                        }
                                        $query_arr[] = $query_sub_arr;
                                    } else {
                                        $query_arr[] = array(
                                            'key' => $name,
                                            'value' => '"' . $or_value . '"',
                                            'type' => 'CHAR',
                                            'compare' => 'LIKE',
                                        );
                                    }
                                }
                                $meta_query[] = $query_arr;
                            } else {
                                if ( is_array( $value ) && sizeof( $value ) > 1 ){
                                    $query_arr = array( 'relation' => 'OR' );
                                    foreach ( $value as $meta_val ) {
                                        $query_arr[] = array(
                                            'key' => $name,
                                            'value' => '"' . $meta_val . '"',
                                            'type' => 'CHAR',
                                            'compare' => 'LIKE',
                                        );
                                    }
                                    $meta_query[] = $query_arr;
                                } else {
                                    $meta_query[] = array(
                                        'key' => $name,
                                        'value' => '"' . $_GET[ $name ] . '"',
                                        'type' => 'CHAR',
                                        'compare' => 'LIKE',
                                    );
                                }
                            }

                          }
                        } else{
                          if ( is_array( $range_values ) && count($range_values) > 1 ){
                            $meta_query[] = array(
                                'key' => $name,
                                'value' => $range_values,
                                'compare' => 'BETWEEN',
                                'type' => 'DECIMAL(10,3)'
                            );
                          } else {
                            $val_and_array = explode('|', $_GET[ $name ]);
                            if (is_array($val_and_array) && count($val_and_array) > 1) {
                                $query_arr = array(
                                    'relation' => 'AND'
                                );
                                foreach ($val_and_array as $key => $or_value) {
                                    $val_array = explode(',', $or_value);

                                    $query_arr[] = array(
                                        'key' => $name,
                                        'value' => $val_array,
                                        'compare' => 'IN',
                                    );
                                }
                                $meta_query[] = $query_arr;
                            } else {
                                $meta_query[] = array(
                                  'key'       => $name,
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

                      }
                    }

                  }

                    if ( !empty( $_GET['s'] ) ){
                      $args['s'] = $_GET['s'];
                    }

                    $post_type_categories = array();

                    foreach ( $post_type_choose as $key => $type ) {
                        if ( $type != 'post' ) {
                            if ( $type == 'product' ) {
                              $post_type_categories[] = 'product_cat';
                            } else {
                              $post_type_categories[] = $type . '_category';
                            }
                        } else {
                            $post_type_categories[] = 'category';
                        }
                        $post_type_categories[] = $type . '_tag';
                    }

                    foreach ( $_GET as $key => $value ) {
                      if ( in_array( $key, $post_type_categories ) ||
                      ( in_array( 'post', $post_type_choose ) && $key == 'category') ){
                        if ( $value != 'all' && $value != '' ) {
                          $val_and_array = explode( '|', $value );
                          if ( is_array( $val_and_array ) && count( $val_and_array ) > 1 ) {
                              $sub_tax_query = array(
                                  'relation' => 'AND'
                              );
                              foreach ($val_and_array as $sub_key => $or_value) {
                                  $sub_tax_query[] = array(
                                      'taxonomy'  => $key,
                                      'field'     => 'slug',
                                      'terms'     => explode( ',' , $or_value ),
                                      'operator' => 'IN'
                                  );
                              }
                              $args['tax_query'][] = $sub_tax_query;
                          } else {
                              $args['tax_query'][] = array(
                                  'taxonomy'  => $key,
                                  'field'     => 'slug',
                                  'terms'     => explode( ',' , $value ),
                                  'operator' => 'IN'
                              );
                          }

                          $GLOBALS['my_query_filters']['tax_query'] = $post_type_categories;
                        }
                      }

                      if ( !in_array( $key, $post_type_categories ) && !( in_array( 'post', $post_type_choose ) && $key == 'category' ) && in_array( $key, $cpt_taxonomies ) ) {
                        if ( $value != '' && $value != 'all'){

                          $val_and_array = explode( '|', $value );
                          if ( is_array( $val_and_array ) && count( $val_and_array ) > 1 ) {
                                $sub_tax_query = array(
                                    'relation' => 'AND'
                                );
                                foreach ($val_and_array as $sub_key => $or_value) {
                                    $sub_tax_query[] = array(
                                        'taxonomy'  => $key,
                                        'field'     => 'slug',
                                        'terms'     => explode( ',' , $or_value ),
                                        'operator' => 'IN'
                                    );
                                }
                                $args['tax_query'][] = $sub_tax_query;
                          } else {
                              $args['tax_query'][] = array(
                                  'taxonomy'  => $key,
                                  'field'     => 'slug',
                                  'terms'     => explode( ',' , $value ),
                                  'operator' => 'IN'
                              );
                          }

                        }

                      }
                    }
                  }

                // get category page we are on for custom cat
                if ($wp_query) {


                  if (isset($wp_query->query_vars["tax_query"])) {
                    foreach($wp_query->query_vars["tax_query"] as $item) {
                      if (isset($item['taxonomy'])){
                      if (strpos($item['taxonomy'], '_cat') !== false) {
                        $curernt_custom_cat = $item['taxonomy'];
                        $curernt_custom_cat_terms = $item['terms'];

                        if (is_array($curernt_custom_cat_terms)) {
                          $curernt_custom_cat_terms = implode (", ", $curernt_custom_cat_terms);
                        }
                      } else if (strpos($item['taxonomy'], '_tag') !== false) {
                        $curernt_custom_cat = $item['taxonomy'];
                        $curernt_custom_cat_terms = $item['terms'];

                        if (is_array($curernt_custom_cat_terms)) {
                          $curernt_custom_cat_terms = implode (", ", $curernt_custom_cat_terms);
                        }
                      }
                    }
                    }
                  }

                  if (isset($wp_query->query['author_name'])) {
                    $authorname = $wp_query->query['author_name'];
                  } else {
                    $authorname = "";
                  }


                }

              }


            // START SORTING
            if ($sort_order == 'acf_date_picker') {

              $acf_get = get_field_object($acf_date_picker_field);
              $field_orderby = 'meta_value_num';
              $meta_type = 'DATE';
              if ( $acf_get['type'] == 'date_time_picker' ) {
                $field_orderby = 'meta_value';
                $meta_type = 'DATETIME';
              }

              if ($acf_date_picker_method == 'today') {

                $args['meta_key'] = $acf_get['name'];
                $args['orderby'] = $field_orderby;
                $args['order'] = $order_asc_desc;//'ASC';

                $meta_query[] = array(
                    'key' => $acf_get['name'],
                    'compare' => '=',
                    'value' => gmdate("Y-m-d"),
                    'type' => $meta_type
                  );

                if ($acf_get['type'] == 'date_time_picker') {
                  $args['meta_type'] = 'DATETIME';
                }

              } elseif ($acf_date_picker_method == 'today_future') {

                $args['meta_key'] = $acf_get['name'];
                $args['orderby'] = $field_orderby;
                $args['order'] = $order_asc_desc;//'ASC';

                $meta_query[] = array(
                    'key' => $acf_get['name'],
                    'compare' => '>=',
                    'value' => gmdate("Y-m-d"),
                    'type' => $meta_type
                  );
                if ($acf_get['type'] == 'date_time_picker') {
                  $args['meta_type'] = 'DATETIME';
                }

              } elseif ($acf_date_picker_method == 'today_30') {

                

                $args['meta_key'] = $acf_get['name'];
                $args['orderby'] = $field_orderby;
                $args['order'] = $order_asc_desc;//'ASC';

                $meta_query[] = array(
                  'key' => $acf_get['name'],
                  'compare' => '>=',
                  'value' => gmdate("Y-m-d"),
                  'type' => $meta_type
                );

                $meta_query[] = array(
                  'key' => $acf_get['name'],
                  'compare' => '<=',
                  'value' => gmdate("Y-m-d", strtotime("+".$acf_date_picker_custom_day." days")),
                  'type' => $meta_type
                );
                if ($acf_get['type'] == 'date_time_picker') {
                  $args['meta_type'] = 'DATETIME';
                }

              } elseif ($acf_date_picker_method == 'before_today') {
                
                $args['meta_key'] = $acf_get['name'];
                $args['orderby'] = $field_orderby;
                $args['order'] = $order_asc_desc;

                $meta_query[] = array(
                  'key' => $acf_get['name'],
                  'compare' => '<=',
                  'value' => gmdate('Y-m-d',strtotime("-1 days")),
                  'type' => $meta_type
              );
                if ($acf_get['type'] == 'date_time_picker') {
                  $args['meta_type'] = 'DATETIME';
                }

              } elseif ($acf_date_picker_method == 'last_week') {
                
                $args['meta_key'] = $acf_get['name'];
                $args['orderby'] = $field_orderby;
                $args['order'] = $order_asc_desc;

                $meta_query[] = array(
                  'key' => $acf_get['name'],
                  'compare' => 'BETWEEN',
                  'value' => array(gmdate("Y-m-d", strtotime("-7 days")), gmdate("Y-m-d")),
                  'type' => $meta_type
              );
                if ($acf_get['type'] == 'date_time_picker') {
                  $args['meta_type'] = 'DATETIME';
                }

              } elseif ($acf_date_picker_method == 'past_30') {
                
                $args['meta_key'] = $acf_get['name'];
                $args['orderby'] = $field_orderby;
                $args['order'] = $order_asc_desc;

                $meta_query[] = array(
                    'key' => $acf_get['name'],
                    'compare' => 'BETWEEN',
                    'value' => array(gmdate("Y-m-d", strtotime("-".$acf_date_picker_custom_day." days")), gmdate('Y-m-d',strtotime("-1 days"))),
                    'type' => $meta_type
                  );
                if ($acf_get['type'] == 'date_time_picker') {
                  $args['meta_type'] = 'DATETIME';
                }

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

              $args['orderby'] = $args['orderby'] . ' ID';
            } else if ( $sort_order == "acf_field") {
              $acf_get = get_field_object($acf_sort_field);
              if ( $acf_sort_type == 'string' ) {
                $args['orderby'] = 'meta_value';
              } else if ( $acf_sort_type == 'numeric') {
                $args['orderby'] = 'meta_value_num';
              }

              $args['meta_key'] = $acf_get['name'];
              $args['order'] = $order_asc_desc;

              $args['orderby'] = $args['orderby'] . ' ID';
            } else if ( $sort_order == "rand") {
              $args['orderby'] = 'rand(' . rand() . ')';
            } else {

              if ($post_display_type == "wishlist") {
              } else {
                $args['orderby'] = $sort_order;
                $args['order']= $order_asc_desc;
              }

            }

            // END SORTING

              if (isset($meta_query)) {
                $args['meta_query'] = $meta_query;
              }



              if ($post_display_type == "users_posts") {
                global $current_user;
                $args['author__in'] = array($current_user->ID);
              }




                if(isset($args)){
					$args = apply_filters('dmach_archive_post_args', $args);
				}

                if ( isset( $args['offset'] ) && $args['offset'] == 0 ){
                  unset( $args['offset'] );
                }
                if ( isset( $args['offset'] ) && $args['offset'] != -1 ) {
                    $temp_posts_count = $args['posts_per_page'];
                    $args['posts_per_page'] = $args['offset'];
                    unset( $args['offset'] );

                    $offset_posts_list = get_posts( $args );
                    $offset_ids = array();
                    foreach( $offset_posts_list as $offset_post ) {
                      $offset_ids[] = $offset_post->ID;
                    }

                    if ( !isset($args['post__not_in'] ) ) {
                        $args['post__not_in'] = array();
                    }

                    $args['post__not_in'] = array_merge( $args['post__not_in'], $offset_ids );
                    $args['posts_per_page'] = $temp_posts_count;

                    query_posts( $args );
                } else {
                    query_posts( $args );
                }

                $dmach_map_acf = de_get_option_value('divi-machine', 'dmach_map_acf'); //$titan->getOption( 'dmach_map_acf' );
                $dmach_post_type = array(de_get_option_value('divi-machine', 'dmach_post_type')); //$titan->getOption( 'dmach_post_type' );

                $dmach_post_type_custom = de_get_option_value('divi-machine', 'dmach_post_type_custom'); //$titan->getOption( 'dmach_post_type_custom' );

                if ($dmach_post_type_custom !== "") {
                  $dmach_post_type = explode(',', $dmach_post_type_custom);
                }

                if ( $has_map == 'on' && $dmach_map_acf !== "none" && $map_all_posts == 'on' ){
                  $map_post_args = $args;
                  $map_post_args['posts_per_page'] = $map_all_posts_limit;
                  unset($map_post_args['paged']);
                  $map_posts = get_posts( $map_post_args );

                  if ( $map_posts ) {

                    if ($map_infoview_layout == 'none' || $map_infoview_layout_ajax == "on") {

                    } else {
                    $map_layout_content = get_post_field('post_content', $map_infoview_layout );
                    }

                    foreach ( $map_posts as $post ){
                      setup_postdata( $post );
                      $current_post_type = get_post_type();
                      $map_array[] = get_field($dmach_map_acf);

                      $map_infoview_content = "";

                      if ($map_infoview_layout == 'none' && $map_tooltip_shortcode == "") {
                        $map_infoview_content = $post->post_title;
                      } else {
                        if ($map_infoview_layout_ajax == 'on') {
                          $get_post_id = get_the_ID();
                          $map_infoview_content = '<div style="position:relative;min-width:80px;min-height:80px;"><div class="ajax-loading"><div class="spinner ripple-cont" style="width:30px;height:30px;"><div class="ripple" style="margin:0;"></div></div></div></div>';
                          $map_array[count($map_array) - 1]['post_id'] = $get_post_id;
                        } else {
                          if ( $map_infoview_layout != "none" ) {
                            if(isset($map_layout_content)){
$map_infoview_content = apply_filters( 'the_content', $map_layout_content );
}
                          } else if ( $map_tooltip_shortcode != "" ) {
                            $map_infoview_content = do_shortcode('['.$map_tooltip_shortcode.']');
                          }

                          $map_infoview_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_${1}_${2}_tb_body', $map_infoview_content );
                          $map_infoview_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_dmach_${1}_${2}${3}', $map_infoview_content );
                        }
                      }

                      $map_array[count($map_array) - 1]['infoview'] = $map_infoview_content;
                      $map_array[count($map_array) - 1]['title'] = $post->post_title;//get_the_title();
                    }
                    wp_reset_postdata();
                  }
                    }

                if ( in_array( 'post', $post_type_choose ) ) {
                  if ( !empty( $include_cats ) && count( explode( ',', $include_cats ) ) > 1 ) {
                    $wp_query->query_vars['category_name'] = '';
                    $wp_query->query_vars['cat'] = '';
                  }

                  if ( !empty( $include_tags ) && count( explode(',', $include_tags ) ) > 1 ){
                    $wp_query->query_vars['tag_id'] = '';
                  }
                }

                if ( $default_taxonomy_existing == false && !empty( $wp_query->query_vars['taxonomy'] ) ) {
                  $wp_query->query_vars['taxonomy'] = '';
                  $wp_query->query_vars['term'] = '';
                }

                $address_filter_var['is_filter']  = false;

                $wp_query->is_tax = false;

                if ($enable_debug == "1") {
                  $acf_get = get_field_object($acf_name);
?>
                  <div class="reporting_args hidethis" style="white-space: pre;">
                  <p>ACF: <?php echo esc_html( $acf_name ) ?></p>
                    <?php  print_r($args); ?>
                  </div>
<?php
                }

                if (!isset($curernt_custom_cat)) {
                  $curernt_custom_cat = "";
                }

                if (!isset($curernt_custom_cat_terms)) {
                  $curernt_custom_cat_terms = "";
                }

                /*wp_localize_script( 'divi-filter-ajax-loadmore-js', 'divi_machine_var', array(
                'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
                ) );
                */

                wp_enqueue_script( 'divi-machine-ajax-loadmore-js' );

                $get_current_tax = get_query_var('taxonomy');
                $get_current_term = get_query_var( 'term' );

                global $current_in_archive_loop;

                $current_in_archive_loop = '';

                if ( !isset( $wp_archive_query) ) {
                  $wp_archive_query = $wp_query;
                }

                $wp_query_var = $wp_query->query_vars;

                $orderby_param = $wp_query_var['orderby'];

                if ( is_array( $orderby_param ) ) {
                  $orderby_param = array_keys( $orderby_param );
                  $orderby_param = $orderby_param[0];
                }

                $sorttype = 'string';

                if ( $orderby_param == 'meta_value_num' ){
                    $sorttype = 'num';
                }

                if ( strpos( $orderby_param, 'meta_value') === 0 ) {
                    $orderby_param = $wp_query_var['meta_key'];
                }

                if ($loop_layout == "none") {
                  echo "Please create a custom loop layout and specify it in the settings.";
                } else {
                  // FILTER PARAMS
                  ?>
                  <div class="dmach-before-posts"></div>
                  <div class="filter-param-tags"></div>
                  <div class="filtered-posts-cont" data-ajaxload-anim="<?php echo esc_html( $filter_update_animation )?>">
                    <div class="filtered-posts-loading <?php echo esc_attr( $filter_update_animation ) ?> "></div>
                    <div class="dmach-grid-sizes divi-filter-archive-loop <?php echo (isset($is_main_loop) && ($is_main_loop == 'on'))?'main-loop':'';?> <?php echo ($show_in_section == 'on')?'show_in_section':'';?> <?php echo ($show_in_same_row_mobile == 'on')?'show_in_same_row_mobile':'';?> <?php echo esc_attr( $grid_layout ) ?> col-desk-<?php echo esc_attr( $columns )?> col-tab-<?php echo esc_attr( $columns_tablet )?> col-mob-<?php echo esc_attr( $columns_mobile )?> <?php echo (isset($is_main_loop) && ($is_main_loop == 'on') && is_search())?'is_search_page':'';?>"
                      data-link_wholegrid="<?php echo esc_attr( $link_whole_gird ) ?>"
                      data-wholegrid-external="<?php echo esc_attr( $link_whole_gird_external )?>"
                      data-wholegrid-external_acf="<?php echo esc_attr( $external_acf )?>"
                    <?php if ( $show_in_section == 'on') { ?>
                      data-content_section_selector="<?php echo esc_attr( $content_section_selector );?>"
                      data-content_section_layout="<?php echo esc_attr( $content_section_layout );?>"
                    <?php } ?>
                      data-layoutid="<?php echo esc_attr( $loop_layout ) ?>"
                      data-posttype="<?php echo esc_attr( implode(',', $post_type_choose) ); ?>"
                      data-noresults="<?php echo esc_attr( $no_posts_layout ) ?>"
                      data-no_results_text="<?php echo esc_attr( $no_posts_layout_text ) ?>"
                      data-sortorder="<?php echo esc_attr( $orderby_param ) ?>"
                    <?php if ( $orderby_param == 'acf_date_picker' ) { ?>
                        data-acf-order-field="<?php echo esc_attr( $acf_date_picker_field ); ?>"
                        data-acf-order-method="<?php echo esc_attr( $acf_date_picker_method ); ?>"
                    <?php }?>
                      data-sorttype="<?php echo esc_attr( $sorttype );?>"
                      data-sortasc="<?php echo esc_attr( $order_asc_desc ) ?>"
                      data-gridstyle="<?php echo esc_attr( $grid_layout )?>"
                      data-masonry_ajax_buffer="<?php echo esc_attr( $masonry_ajax_buffer )?>"
                      data-columnscount="<?php echo esc_attr( $columns )?>"
                      data-pagi_scrollto="<?php echo esc_attr( $scrollto );?>"
                      data-pagi_scrollto_fine="<?php echo esc_attr( $scrollto_fine_tune );?>"
                      data-postnumber="<?php echo esc_attr( $posts_number ) ?>"
                      data-offset="<?php echo esc_attr( $post_offset ) ?>"
                      data-loadmore="<?php echo esc_attr( $enable_loadmore ) ?>"
                      data-resultcount="<?php echo esc_attr( $enable_resultcount );?>"
                      data-countposition="<?php echo esc_attr( $resultcount_position );?>"
                      data-result-count-single-text="<?php echo esc_attr( $result_count_single_text );?>"
                      data-result-count-all-text="<?php echo esc_attr( $result_count_all_text );?>"
                      data-result-count-pagination-text="<?php echo esc_attr( $result_count_pagination_text );?>"
                      data-btntext="<?php echo esc_attr( $loadmore_text ) ?>"
                      data-btntext_loading="<?php echo esc_attr( $loadmore_text_loading ) ?>"
                      data-posttax=""
                      data-postterm=""
                      data-search="<?php echo get_query_var("s");?>"
                      data-include_category="<?php echo esc_attr( $include_cats );?>"
                      data-include_tag="<?php echo esc_attr( $include_tags );?>"
                      data-exclude_category="<?php echo esc_attr( $exclude_cats );?>"
                      data-include_cats="<?php echo esc_attr( $include_cats );?>"
                      data-include_tags="<?php echo esc_attr( $include_tags );?>"
                      data-exclude_cats="<?php echo esc_attr( $exclude_cats );?>"
                      data-exclude_tags="<?php echo esc_attr( $exclude_tags );?>"
                      data-onload_cats="<?php echo esc_attr( $onload_cats );?>"
                      data-onload_tags="<?php echo esc_attr( $onload_tags );?>"
                      data-onload_tax="<?php echo esc_attr( $onload_tax_choose );?>"
                      data-onload_terms="<?php echo esc_attr( $onload_taxomony );?>"
                      data-current_category="<?php echo esc_attr( $wp_query->query_vars["category_name"] ) ?>"
                      data-current_custom_category="<?php echo esc_attr( $curernt_custom_cat ) ?>"
                      data-current_custom_category_terms="<?php echo esc_attr( $curernt_custom_cat_terms ) ?>"
                      data-current_author="<?php echo !empty($authorname)?esc_attr( $authorname ):''; ?>"
                      data-filter-var="<?php echo htmlspecialchars( json_encode( $wp_query->query_vars ) );?>"
                      data-current-page="<?php echo get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;?>"
                      <?php echo ( !empty( $current_taxonomy ) )?' data-current-taxonomy="' . esc_attr( $current_taxonomy ) . '"':'';?>
                      <?php echo ( !empty( $current_tax_term ) )?' data-current-taxterm="' . esc_attr( $current_tax_term ) . '"':'';?>
                      data-max-page="<?php echo esc_attr( $wp_query->max_num_pages );?>" style="grid-auto-rows: 1px;"
                      data-has-map="<?php echo esc_attr( $has_map );?>" data-map-selector="<?php echo esc_attr( $map_selector );?>"
                      data-hide-marker-label="<?php echo esc_attr( $hide_marker_label );?>"
                      data-map-cluster="<?php echo esc_attr( $map_cluster );?>" 
                      data-map-all-posts="<?php echo esc_attr( $map_all_posts );?>" data-map-marker-layout="<?php echo esc_attr( $map_infoview_layout );?>">
                      <?php
                       if ( have_posts() ) {
                        ?>
                        <div class="grid-posts loop-grid"> <?php

                        $loop_layout_content = get_post_field('post_content', $loop_layout);

                        $map_layout_content = '';

                        if ( $map_infoview_layout != "" ) {
                          $map_layout_content = get_post_field('post_content', $map_infoview_layout );
                        }

                        while ( have_posts() ) {
                          the_post();

                          $post_id = $post->ID;

                          if ( !isset( $de_loop_variable[$post_id] ) ) {
                            $de_loop_variable[$post_id] = array();
                          }

                          $current_post_type = get_post_type();
                          $current_in_archive_loop = 'archive_loop';

                          if ( $has_map == 'on' && $dmach_map_acf !== "none" && in_array($current_post_type, $dmach_post_type) && $map_all_posts == 'off' ){
                            $map_array[] = get_field($dmach_map_acf);
                            $post_title = '';
                            if ( isset( $de_loop_variable[$post_id]['title'] ) ) {
                              $post_title = $de_loop_variable[$post_id]['title'];
                            } else {
                              $de_loop_variable[$post_id]['title'] = $post_title = get_the_title();
                            }

                            $map_infoview_content = "";

                            if ($map_infoview_layout == 'none' && $map_tooltip_shortcode == "") {
                              $map_infoview_content = $post_title;
                            } else {
                              if ($map_infoview_layout_ajax == 'on') {
                                $map_infoview_content = '<div style="position:relative;min-width:80px;min-height:80px;"><div class="ajax-loading"><div class="spinner ripple-cont" style="width:30px;height:30px;"><div class="ripple" style="margin:0;"></div></div></div></div>';
                                $map_array[count($map_array) - 1]['post_id'] = $post_id;
                              } else {
                                if ( $map_infoview_layout != "none" ) {
                                  $map_infoview_content = apply_filters( 'the_content', $map_layout_content );
                                } else if ( $map_tooltip_shortcode != "" ) {
                                  $map_infoview_content = do_shortcode('['.$map_tooltip_shortcode.']');
                                }

                                $map_infoview_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_${1}_${2}_tb_body', $map_infoview_content );
                                $map_infoview_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_dmach_${1}_${2}${3}', $map_infoview_content );
                              }
                            }

                            $map_array[count($map_array) - 1]['infoview'] = $map_infoview_content;
                            $map_array[count($map_array) - 1]['title'] = $post_title;
                          }

                          $terms = wp_get_object_terms( $post_id, get_object_taxonomies($current_post_type) );
                          $terms_array = array();
                          foreach ( $terms as $term ) {
                            $terms_array[] = $term->taxonomy . '-' . $term->slug;
                          }
                          $terms_string = implode (" ", $terms_array);

                          if ($grid_layout == "masonry") {
                            ?>
                            <div class="grid-item dmach-grid-item <?php echo esc_attr( $terms_string ) ?> post_id_<?php echo esc_html($post_id) ?>" data-id="<?php echo esc_attr($post_id);?>" data-posttype="<?php echo esc_attr($current_post_type);?>">
                              <div class="grid-item-cont">
                                <?php
                              } else {
                                ?>
                                <div class="grid-col dmach-grid-item <?php echo esc_attr( $terms_string ) ?> post_id_<?php echo esc_html($post_id) ?>" data-id="<?php echo esc_attr($post_id);?>" data-posttype="<?php echo esc_attr($current_post_type);?>">
                                  <div class="grid-item-cont">
                                    <?php
                                  }

                                  if ($link_whole_gird == "on") {

                                    $post_link = isset( $de_loop_variable[$post_id]['permalink'] )?$de_loop_variable[$post_id]['permalink']:get_permalink();
                                    $de_loop_variable[$post_id]['permalink'] = $post_link;

                                    if ($link_whole_gird_external == "on") {
                                      $acf_get = get_field_object($external_acf);
                                      $post_link = $acf_get['value'];
                                    }

                                    ?>
                                    <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr( $post_link ) ?>">
                                    <?php
                                  }

                                  $post_content = apply_filters( 'the_content', $loop_layout_content );

                                  $post_content = preg_replace( '/et_pb_section_(\d+)_tb_body/', 'et_pb_dmach_section_${1}_tb_body', $post_content );
                                  $post_content = preg_replace( '/et_pb_row_(\d+)_tb_body/', 'et_pb_dmach_row_${1}_tb_body', $post_content );
                                  $post_content = preg_replace( '/et_pb_column_(\d+)_tb_body/', 'et_pb_dmach_column_${1}_tb_body', $post_content );

                                  $post_content = preg_replace( '/et_pb_section_(\d+)_tb_footer/', 'et_pb_dmach_section_${1}_tb_footer', $post_content );
                                  $post_content = preg_replace( '/et_pb_row_(\d+)_tb_footer/', 'et_pb_dmach_row_${1}_tb_footer', $post_content );
                                  $post_content = preg_replace( '/et_pb_column_(\d+)_tb_footer/', 'et_pb_dmach_column_${1}_tb_footer', $post_content );

                                  $post_content = preg_replace( '/et_pb_section_(\d+)_tb_header/', 'et_pb_dmach_section_${1}_tb_header', $post_content );
                                  $post_content = preg_replace( '/et_pb_row_(\d+)_tb_header/', 'et_pb_dmach_row_${1}_tb_header', $post_content );
                                  $post_content = preg_replace( '/et_pb_column_(\d+)_tb_header/', 'et_pb_dmach_column_${1}_tb_header', $post_content );

                                  $post_content = preg_replace( '/et_pb_section_(\d+)( |")/', 'et_pb_dmach_section_${1}${2}', $post_content );
                                  $post_content = preg_replace( '/et_pb_row_(\d+)( |")/', 'et_pb_dmach_row_${1}${2}', $post_content );
                                  $post_content = preg_replace( '/et_pb_column_(\d+)( |")/', 'et_pb_dmach_column_${1}${2}', $post_content );

                                  echo $post_content;

                                  // $content = apply_filters('the_content', get_post_field('post_content', $loop_layout));

                                  // echo et_builder_render_layout($content );

                                  if ($link_whole_gird == "on") {
                                    ?>
                                    </div>
                                    <?php
                                  }
                                  ?>
                                </div>
                              </div>
                              <?php
                            } // end while have posts

                            $current_in_archive_loop = '';
                            ?>
                          </div>
                      <?php
                        } else {
                          if ($no_posts_layout == "none") {
                            echo '<div class="no-results-layout">';
                            echo $no_posts_layout_text;
                            echo '</div>';
                          } else {
                            ?>
                            <div class="no-results-layout">
                              <?php
                              echo do_shortcode('[et_pb_row global_module="' . $no_posts_layout . '"][/et_pb_row]');
                              ?>
                            </div>
                            <?php
                          }
                        }
                        ?>
                      </div>
                    </div> <!-- filtered-posts-cont -->
                  <div class="dmach-after-posts"></div>
                    <?php
                      $position_class = '';
                      if ( $enable_resultcount == "on" ) {
                        $position_class = 'result_count_' . $resultcount_position;
                        $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
                        echo '<p class="divi-filter-result-count ' . esc_attr( $position_class ) . '">';
                        if ( $wp_query->found_posts == 1 ){
                          echo $result_count_single_text;
                        }else if ( $wp_query->found_posts == $wp_query->post_count ) {
                          printf( $result_count_all_text, esc_attr( $wp_query->found_posts ) );
                        }else {
                          printf( $result_count_pagination_text, (($current_page - 1) * $posts_number + 1), (($current_page - 1) * $posts_number + $wp_query->post_count), esc_html( $wp_query->found_posts ) );
                        }
                        echo '</p>';
                      }
                      if ($enable_loadmore == "on") {
                        if (  $wp_query->max_num_pages > 1 ){
                          ?>
                          <div class="dmach-loadmore et_pb_button <?php echo esc_attr( $position_class );?>" <?php echo esc_attr( $custom_icon ) ?>><?php echo esc_attr( $loadmore_text ) ?></div>
                          <?php
                        }
                      }else if ( $enable_loadmore == 'pagination' ) {
                      ?>
                        <div class="divi-filter-pagination <?php echo esc_attr( $position_class );?>"><?php echo paginate_links(array('type' => 'list')); ?></div>
                      <?php
                      }
                      if ( $has_map == 'on' && $dmach_map_acf !== "none" && !empty( array_intersect( $dmach_post_type, $post_type_choose ) ) ){

                        if ($map_cluster == "on") {
                          ?>
                          <script>
                                var locations = [];
                                var labels = [];
                                var i_windows = [];
                                var map_ids = [];
                                var markers = [];
                                var markerClusterer;
                          jQuery(document).ready(function($){
                            var current_infowindow;
                            var current_id;
                            if ( $('<?php echo esc_html( $map_selector );?>').length > 0 ){
                              $('<?php echo esc_html( $map_selector );?>').each( function(){
                                $(this).find('.et_pb_map_pin').remove();
                                <?php
                                $map_ids = array();
                                foreach ($map_array as $key => $map) {
                                  if (isset($map['lat']) && isset($map['lng']) && is_numeric($map['lat']) && is_numeric($map['lng'])) {
                                    if ( $map_infoview_layout_ajax == 'on' ) {
                                      $map_ids[] = $map['post_id'];
                                    }
                                    ?>
                                    var t = `<?php echo $map['infoview'] ;?>`;
                                    locations.push({ lat: <?php echo $map['lat'];?>, lng: <?php echo $map['lng'];?>});
                                    labels.push('<?php echo $map['title'][0];?>');
                                    i_windows.push(t);
                                    <?php
                                  }
                                }
                                if ( ($map_infoview_layout == 'none' && $map_tooltip_shortcode == "") || $map_infoview_layout_ajax != 'on' ) {
                                ?>
                                var markerCl_interval = setInterval(function(){
                                  var map_selector = $("<?php echo $map_selector;?>");
                                  if ( typeof map_selector.data("map") != 'undefined' ) {
                                    var map_obj = map_selector.data("map");

                                    var imagePath = "<?php echo DE_DF_PLUGIN_URL.'/images/markerClusterer/m';?>";

                                      markers = locations.map((location, i) => {
                                      var marker = new google.maps.Marker({
                                        position: location,
                                    <?php if ( $hide_marker_label !== 'on' ) { ?>
                                        label: labels[i],
                                    <?php }?>
                                      });
                                      if ( i == 0 && map_selector.find('.et_pb_map').data('center-lat') == "" && map_selector.find('.et_pb_map').data('center-lng') == "" ) {
                                        map_obj.setCenter(location);
                                      }
                                      var i_window = new google.maps.InfoWindow({
                                        content: i_windows[i]
                                      });

                                      google.maps.event.addListener(map_obj, "click", (function() {
                                        i_window.close()
                                      }
                                    ));

                                    google.maps.event.addListener(marker, "click", (function() {
                                      i_window.open(map_obj, marker);
                                      }
                                      ));

                                      return marker;
                                      });

                                      markerClusterer = new MarkerClusterer(map_obj, markers, {imagePath: imagePath});

                                      clearInterval( markerCl_interval );
                                  }
                                }, 100 );
                              <?php
                                } else {  // infoview ajax
                                  $tooltip_type = 'layout';
                                  if ( $map_infoview_layout == 'none' && $map_tooltip_shortcode != '' ) {
                                    $tooltip_type = 'shortcode';
                                  }
                                  $tooltip_layout = ( $map_infoview_layout != 'none' )?$map_infoview_layout:$map_tooltip_shortcode;
                              ?>
                                var map_ids = '<?php echo implode(',', $map_ids);?>'.split(',');
                                var markerCl_interval = setInterval(function(){
                                  var map_selector = $("<?php echo esc_html( $map_selector );?>");
                                  if ( typeof map_selector.data("map") != 'undefined' ) {
                                    var map_obj = map_selector.data("map");
                                    var imagePath = "<?php echo DE_DF_PLUGIN_URL.'/images/markerClusterer/m';?>";

                                      markers = locations.map((location, i) => {
                                      var marker = new google.maps.Marker({
                                        position: location,
                                      <?php if ( $hide_marker_label !== 'on' ) { ?>
                                        label: labels[i],
                                      <?php }?>
                                      });

                                      if ( i == 0 && map_selector.find('.et_pb_map').data('center-lat') == "" && map_selector.find('.et_pb_map').data('center-lng') == "" ) {
                                        map_obj.setCenter(location);
                                      }

                                      var i_window = new google.maps.InfoWindow({
                                        content: i_windows[i]
                                      });

                                      google.maps.event.addListener(map_obj, "click", (function() {
                                            i_window.close();
                                            current_infowindow = undefined;
                                            current_id = undefined;
                                      }
                                    ));

                                    google.maps.event.addListener(marker, "click", (function() {
                                      i_window.open(map_obj, marker);
                                            current_infowindow = i_window;
                                            current_id = map_ids[i];
                                      }
                                      ));

                                      return marker;
                                      });

                                      const markerClusterer = new MarkerClusterer(map_obj, markers, {imagePath: imagePath});

                                      clearInterval( markerCl_interval );
                                  }
                                }, 100 );
                                $.ajax({
                                  url: '<?php echo admin_url( 'admin-ajax.php' );?>',
                                  data: {
                                    action: 'ajax_marker_layout_ajax_handler',
                                    post_id: '<?php echo implode(',', $map_ids);?>',
                                    tooltip_layout: '<?php echo $tooltip_layout;?>',
                                    tooltip_type: '<?php echo $tooltip_type;?>',
                                    post_type: '<?php echo implode(',', $post_type_choose);?>'
                                  },
                                  type: 'POST',
                                  success: function( data ) {
                                    $('.main-loop').append(data.css_output);
                                    i_windows = new Array();
                                    for ( i = 0; i < map_ids.length; i++ ) {
                                      i_windows[i] = data.content[map_ids[i]];
                                    }

                                    if ( typeof current_infowindow  !== 'undefined' ) {
                                      current_infowindow.setContent( data.content[current_id] );
                                    }

                                    var map_selector = $("<?php echo $map_selector;?>");
                                    if ( typeof map_selector.data("map") != 'undefined' ) {
                                      var map_obj = map_selector.data("map");

                                      $.each( markers, function( key, marker ) {
                                        google.maps.event.clearListeners(markers[key], 'click');
                                        var i_window = new google.maps.InfoWindow({
                                          content: i_windows[key]
                                        });

                                        google.maps.event.addListener(map_obj, "click", (function() {
                                          i_window.close()
                                        }));

                                        google.maps.event.addListener(markers[key], "click", (function() {
                                          i_window.open(map_obj, markers[key]);
                                        }));
                                      });
                                    }
                                  }
                                });
                              <?php
                                }
                              ?>
                            });
                          }
                        });
                        </script>
                        <?php
                        } else {
                          ?>
                          <script>
                            var locations = [];
                            var labels = [];
                            var i_windows = [];
                            var map_ids = [];
                            var markers = [];
                          jQuery(document).ready(function($){
                            var current_infowindow;
                            var current_id;
                            if ( $('<?php echo esc_html( $map_selector );?>').length > 0 ){
                              $('<?php echo esc_html( $map_selector );?>').each( function(){
                                $(this).find('.et_pb_map_pin').remove();
                                <?php
                                $map_ids = array();
                                foreach ($map_array as $key => $map) {

                                  if (!empty($map['lat']) && !empty($map['lng']) && is_numeric($map['lat']) && is_numeric($map['lng'])) {
                                    $map_ids[] = $map['post_id'];
                                    if ( $key == 0 ) {
                                ?>
                                var map_obj = $(this).data("map");
                                if ( $(this).find('.et_pb_map').data('center-lat') == "" && $(this).find('.et_pb_map').data('center-lng') == "" ) {
                                    if ( map_obj ) {
                                      map_obj.setCenter({ lat: <?php echo $map['lat'];?>, lng: <?php echo $map['lng'];?>});
                                    }
                                }
                                <?php
                                    }
                                    ?>
                                    var t = `<?php echo $map['infoview'] ;?>`;
                                    locations.push({ lat: <?php echo $map['lat'];?>, lng: <?php echo $map['lng'];?>});
                                    labels.push('<?php echo $map['title'][0];?>');
                                    i_windows.push(t);
                                    <?php
                                  }
                                }
                                ?>
                                    var map_interval = setInterval(function(){
                                      var map_selector = $("<?php echo esc_html( $map_selector );?>");
                                      if ( typeof map_selector.data("map") != 'undefined' ) {
                                        var map_obj = map_selector.data("map");
                                        markers = locations.map((location, i) => {
                                          var marker = new google.maps.Marker({
                                            position: location,
                                          <?php if ( $hide_marker_label !== 'on' ) { ?>
                                            label: labels[i],
                                          <?php }?>
                                            map: map_obj
                                          });
                                          if ( i == 0 && map_selector.find('.et_pb_map').data('center-lat') == "" && map_selector.find('.et_pb_map').data('center-lng') == "" ) {
                                            map_obj.setCenter(location);
                                    }

                                          var i_window = new google.maps.InfoWindow({
                                            content: i_windows[i]
                                          });

                                          google.maps.event.addListener(map_obj, "click", (function() {
                                              i_window.close();
                                              current_infowindow = undefined;
                                              current_id = undefined;
                                            }
                                          ));

                                          google.maps.event.addListener(marker, "click", (function() {
                                              i_window.open(map_obj, marker);
                                              current_infowindow = i_window;
                                              current_id = map_ids[i];
                                }
                                          ));

                                          return marker;
                                        });

                                        clearInterval( map_interval );
                                }
                                    }, 100);
                                <?php
                                if ( $map_infoview_layout_ajax == 'on' && ($map_infoview_layout != 'none' || $map_tooltip_shortcode != '' ) ) {
                                  $tooltip_type = 'layout';
                                  if ( $map_infoview_layout == 'none' && $map_tooltip_shortcode != '' ) {
                                    $tooltip_type = 'shortcode';
                                  }
                                  $tooltip_layout = ( $map_infoview_layout != 'none' )?$map_infoview_layout:$map_tooltip_shortcode;
                                ?>
                                  var _map = $(this);
                                  map_ids = '<?php echo implode(',', $map_ids);?>'.split(',');
                                  $.ajax({
                                    url: '<?php echo admin_url( 'admin-ajax.php' );?>',
                                    data: {
                                      action: 'ajax_marker_layout_ajax_handler',
                                      post_id: '<?php echo implode(',', $map_ids);?>',
                                      tooltip_layout: '<?php echo $tooltip_layout;?>',
                                      tooltip_type: '<?php echo $tooltip_type;?>',
                                      post_type: '<?php echo implode(',', $post_type_choose);?>'
                                    },
                                    type: 'POST',
                                    success: function( data ) {
                                      $('.main-loop').append(data.css_output);
                                      i_windows = new Array();
                                      for ( i = 0; i < map_ids.length; i++ ) {
                                        i_windows[i] = data.content[map_ids[i]];
                                      }

                                      if ( typeof current_infowindow  !== 'undefined' ) {
                                        current_infowindow.setContent( data.content[current_id] );
                                      }

                                      var map_selector = $("<?php echo $map_selector;?>");
                                      if ( typeof map_selector.data("map") != 'undefined' ) {
                                        var map_obj = map_selector.data("map");

                                        $.each( markers, function( key, marker ) {
                                          google.maps.event.clearListeners(markers[key], 'click');
                                          var i_window = new google.maps.InfoWindow({
                                            content: i_windows[key]
                                          });

                                          google.maps.event.addListener(map_obj, "click", (function() {
                                            i_window.close()
                                          }));

                                          google.maps.event.addListener(markers[key], "click", (function() {
                                            i_window.open(map_obj, markers[key]);
                                          }));
                                      });
                                      }
                                    }
                              });
                                <?php
                                }
                                ?>
                              });

                            }
                          });
                          </script>
                          <?php
                        }

                          }
                    }

                  if ( isset( $wp_archive_query ) && ($wp_archive_query == $wp_query) ){
                  wp_reset_query();
                    $wp_archive_query = null;
                  } else if ( isset($wp_archive_query ) ){
                    $wp_query = $wp_archive_query;
                    wp_reset_postdata();
                  }

                  $end_time = microtime( true );
                  $duration = $end_time - $start_time;

                  if ( $enable_debug == "1" ) {
              ?>
                    <div class="reporting_args hidethis" style="white-space: pre;">
                      <span class="total_time"><?php echo esc_html( $duration ) . ' seconds';?></span>
                    </div>
              <?php
                  }

                  $data = ob_get_clean();
                  //////////////////////////////////////////////////////////////////////
                  return $data;
                }

	            /**
	             * @return string[]|WP_Taxonomy[]
	             */
	            public function getWP_taxonomies(): array {
                    $wp_taxonomies   = get_taxonomies( [ '_builtin' => false ] );
                    $additional_taxonomies = [
                        'category'=>'category',
                        'post_tag'=>'post_tag',
                    ];
		            return array_merge($wp_taxonomies,$additional_taxonomies);
	            }
            }

              new de_mach_archive_loop_code;
		}
	}

	if ( !function_exists('Divi_filter_restore_get_params') ) {
		add_action( 'template_redirect', 'Divi_filter_restore_get_params');

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

	add_action( 'wp_enqueue_scripts', 'divi_machine_loop_enqueue_scripts' );

	function divi_machine_loop_enqueue_scripts() {

		$ajax_nonce = wp_create_nonce('filter_object');
		wp_enqueue_script( 'divi-filter-loadmore-js', plugins_url( '../../../js/divi-filter-loadmore.min.js', __FILE__ ), array( 'jquery' ), DE_DF_VERSION );
		wp_localize_script( 'divi-filter-loadmore-js', 'loadmore_ajax_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'security' => $ajax_nonce
			)
		);

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