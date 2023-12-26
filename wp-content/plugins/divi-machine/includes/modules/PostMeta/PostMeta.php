<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_post_meta_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMACH_PRODUCT_URL,
  'author'     => DE_DMACH_AUTHOR,
  'author_uri' => DE_DMACH_URL,
);

                function init() {
                    $this->name       = esc_html__( 'Post Meta - Divi Machine', 'divi-machine' );
                    $this->slug = 'et_pb_de_mach_post_meta';
                		$this->vb_support      = 'on';
                		$this->child_slug      = 'et_pb_de_mach_post_meta_item';
                		$this->child_item_text = esc_html__( 'Meta Item', 'et_builder' );
						$this->folder_name = 'divi_machine';


                    $this->fields_defaults = array(
                    // 'loop_layout'         => array( 'on' ),
                    );

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Main Options', 'divi-machine' ),
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
                  					'label'    => esc_html__( 'Title', 'divi-machine' ),
                  					'css'      => array(
                  						'main' => "%%order_class%% .dmach-post-title",
                  						'important' => 'plugin_only',
                  					),
                  					'font_size' => array(
                  						'default' => '14px',
                  					),
                  					'line_height' => array(
                  						'default' => '1em',
                  					),
                  				),
                  				'meta_item' => array(
                  					'label'    => esc_html__( 'Meta Item', 'divi-machine' ),
                  					'css'      => array(
                  						'main' => "%%order_class%% .dmach-postmeta-value",
                  						'important' => 'all',
                  					),
                  					'font_size' => array(
                  						'default' => '14px',
                  					),
                  					'line_height' => array(
                  						'default' => '1em',
                  					),
                  				),
                    				'meta_label' => array(
                    					'label'    => esc_html__( 'Label', 'divi-machine' ),
                    					'css'      => array(
                    						'main' => "%%order_class%% .dmach-acf-label",
                    						'important' => 'all',
                    					),
                    					'font_size' => array(
                    						'default' => '14px',
                    					),
                    					'line_height' => array(
                    						'default' => '1em',
                    					),
                    				),
                      				'meta_link' => array(
                      					'label'    => esc_html__( 'Link (not button)', 'divi-machine' ),
                      					'css'      => array(
                      						'main' => "%%order_class%% .dmach-postmeta-value a",
                      						'important' => 'all',
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
												'custom_margin_padding' => array(
													'css' => array(
														'important' => 'all',
													),
												),
                  		);


                      $this->custom_css_fields = array(
                  		);


            $this->help_videos = array(
            );
          }

                  function get_fields() {

                      $fields = array(
                        'display_inline' => array(
                        'toggle_slug'       => 'main_content',
                          'label' => esc_html__( 'Display Inline', 'divi-machine' ),
                          'type' => 'yes_no_button',
                          'options_category' => 'configuration',
                          'options' => array(
                            'on' => esc_html__( 'Yes', 'divi-machine' ),
                            'off' => esc_html__( 'No', 'divi-machine' ),
                          ),
                          'default' => 'off',
                          'description' => esc_html__( 'If you want to have your meta items appear on the same line, enable this.', 'divi-machine' )
                        ),
                      );

                      return $fields;
                  }

                  public function get_search_items_content() {
                		return $this->content;
                	}

                  function render($attrs, $content, $render_slug){

                    // if (is_admin()) {
                    //     return;
                    // }

                    $display_inline     = $this->props['display_inline'];

                    if ( $display_inline == 'on' ) {
                      $this->add_classname('inline_meta_items');
                    }

                    $all_tabs_content = $this->get_search_items_content();

                  //////////////////////////////////////////////////////////////////////

                    ob_start();
                    echo $all_tabs_content;

                    $data = ob_get_clean();



                   //////////////////////////////////////////////////////////////////////

                  return $data;



              }

            }

            new de_mach_post_meta_code;

?>
