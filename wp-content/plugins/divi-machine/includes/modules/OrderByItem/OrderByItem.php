<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_orderby_item_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMACH_PRODUCT_URL,
  'author'     => DE_DMACH_AUTHOR,
  'author_uri' => DE_DMACH_URL,
);

                function init() {
                    $this->name       = esc_html__( 'Orderby Item', 'divi-machine' );
                    $this->slug = 'et_pb_de_mach_orderby_item';
                		$this->vb_support      = 'on';
                		$this->type                        = 'child';
                		$this->child_title_var             = 'title';
                    $this->advanced_setting_title_text = esc_html__( 'New Orderby Item', 'divi-machine' );
                		$this->settings_text               = esc_html__( 'Orderby Item Settings', 'divi-machine' );
                    $this->folder_name = 'divi_machine';


                    $this->fields_defaults = array(
                    // 'loop_layout'         => array( 'on' ),
                    );

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Main Options', 'divi-machine' ),
        					'layout' => esc_html__( 'Layout Options', 'divi-machine' ),
        				'text_filter' => esc_html__( 'Text Filter Options', 'divi-machine' ),
        				'select_filter' => esc_html__( 'Select Filter Options', 'divi-machine' ),
        				'radio_filter' => esc_html__( 'Checkbox / radio Filter Options', 'divi-machine' ),
        				'range_filter' => esc_html__( 'Number Range Filter Options', 'divi-machine' ),
        				'filter_style' => esc_html__( 'Filter Style', 'divi-machine' ),
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
                  					'label'    => esc_html__( 'Item', 'divi-machine' ),
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
                    				'radio_button_text' => array(
                    					'label'    => esc_html__( 'Checkbox / Radio Button Style', 'divi-machine' ),
                    					'css'      => array(
                    						'main' => "%%order_class%% .dmach-radio-buttons .et_pb_contact_field_radio label",
                    						'important' => 'plugin_only',
                    					),
                    					'font_size' => array(
                    						'default' => '14px',
                    					),
                    					'line_height' => array(
                    						'default' => '1em',
                    					),
                    				),
                    				'radio_button_text_checked' => array(
                    					'label'    => esc_html__( 'Checkbox / Radio Button Checked Style', 'divi-machine' ),
                    					'css'      => array(
                    						'main' => "%%order_class%% .dmach-radio-buttons .et_pb_contact_field_radio input:checked+label",
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
                  		);


            $this->help_videos = array(
            );
          }

                  function get_fields() {
                    $et_accent_color = et_builder_accent_color();

                    ///////////////////////////////

                  $acf_fields = DEDMACH_INIT::get_acf_fields();


                  
                $filter_post_type_fields = array();

                $post_display_type_fields['title'] = esc_html__('Post Title', 'divi-machine');
                $post_display_type_fields['relevance'] = esc_html__('Relevance', 'divi-machine');
                $post_display_type_fields['acf'] = esc_html__('Advanced Custom Field (ACF Plugin)', 'divi-machine');                
                $post_display_type_fields['date'] = esc_html__('Date', 'divi-machine');
                  
                if (class_exists('DMACHACC_DiviMachineAccount')) {
                  /*$titan = TitanFramework::getInstance( 'divi-machine' );*/
                  $dmach_acc_types_saved = de_get_option_value('divi-machine-acc', 'dmach_acc_types_saved'); //$titan->getOption( 'dmach_acc_types_saved' );
                  $dmach_acc_types_saved_array = explode(',', $dmach_acc_types_saved);

                  foreach ($dmach_acc_types_saved_array as $field) {
                    $post_display_type_fields[$field] = esc_html__($field, 'divi-machine');
                  }
              }

                    //////////////////////////////


                      $fields = array(
                        'title' => array(
                          'label'           => esc_html__( 'Orderby Name', 'divi-machine' ),
                          'type'            => 'text',
                          'description'     => esc_html__( 'Change the name for the filter for admin purposes ONLY, this is just used so you can see what the filter is.', 'divi-machine' ),
                          'toggle_slug'     => 'main_content',
                          'dynamic_content' => 'text',
                          'option_category' => 'configuration',
                        ),

                        'filter_post_type' => array(
                          'toggle_slug'       => 'main_content',
                          'label'             => esc_html__( 'What do you want to add to the orderby select option?', 'divi-machine' ),
                          'type'              => 'select',
                          'options'           => $post_display_type_fields,
                          'default'           => 'relevance',
                          'affects'         => array(
                            'acf_name',
                          ),
                          'option_category'   => 'configuration',
                          'description'       => esc_html__( 'Choose what you want added to the orderby select dropdown', 'divi-machine' ),
                        ),
                      'acf_name' => array(
                        'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'ACF Name', 'divi-machine' ),
                        'type'              => 'select',
                        'options'           => $acf_fields,
                        'default'           => 'none',
                        'depends_show_if'   => 'acf',
                        'option_category'   => 'configuration',
                        'description'       => esc_html__( 'Add the name of the ACF you want to display here', 'divi-machine' ),
                      ),
                      'asc_desc' => array(
                        'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Ascending or Descending?', 'divi-machine' ),
                        'type'              => 'select',
                        'options'           => array(
                          'ASC'        => 'Ascending',
                          'DESC'          => 'Descending',
                        ),
                        'default'           => 'ASC',
                        'option_category'   => 'configuration',
                        'description'       => esc_html__( 'Choose if you want the orderby to be ascending or descending', 'divi-machine' ),
                      ),

                      'order_type' => array(
                        'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Is Numeric?', 'divi-machine' ),
                        'type'              => 'yes_no_button',
                        'options'           => array(
                          'off'             => 'No',
                          'on'              => 'Yes',
                        ),
                        'default'           => 'off',
                        'option_category'   => 'configuration',
                        'description'       => esc_html__( 'Enable this option if order value are numeric.', 'divi-machine' ),
                      ),



                      );

                      return $fields;
                  }



                  function render($attrs, $content, $render_slug){

                    if (is_admin()) {
                        return;
                    }

                    /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
                    $titan = TitanFramework::getInstance( 'divi-machine' );*/
                    $enable_debug = de_get_option_value('divi-machine', 'enable_debug'); //$titan->getOption( 'enable_debug' );

                    $filter_post_type       = $this->props['filter_post_type'];
                    $acf_name               = $this->props['acf_name'];
                    $asc_desc               = $this->props['asc_desc'];
                    $title                  = $this->props['title'];
                    $order_type             = $this->props['order_type'];


                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    if ($enable_debug == "1") {
                    $acf_get = get_field_object($acf_name);
                      ?>
                      <div class="reporting_args hidethis">
                        Filter Post Type: <?php echo esc_html__($filter_post_type); ?><br>
                        ACF Name: <?php echo esc_html__($acf_name); ?><br>
                        ASC OR DESC: <?php echo esc_html__($asc_desc); ?><br>
                        Title: <?php echo esc_html__($title); ?><br><br>
                        ACF Data: <br>
                        <?php print_r($acf_get); ?>
                      </div>
                      <?php
                    }

if ($filter_post_type == "acf"){
                    $acf_get = get_field_object($acf_name);
                    $option_value = $acf_get['name'];
                    if ( isset( $acf_get['parent'] ) && $acf_get['parent'] != 0 ) {
                      $parent_obj = get_post( $acf_get['parent'] );
                      $parent_acf_obj = get_field_object( $parent_obj->post_name );
                      if ( $parent_acf_obj['type'] == 'group' ) {
                        $option_value = $parent_acf_obj['name'] . '_' . $acf_get['name'];
                      }
                    }

                    if ( in_array( $acf_get['type'], array( 'range', 'number' )) || $order_type == 'on' ) {
                      $data_order_type = 'number';
                    } else {
                      $data_order_type = $acf_get['type'];
                    }
                    
                  ?>
	                 <option value="<?php echo $option_value; ?>" data-ascdec="<?php echo $asc_desc; ?>" data-order-type="<?php echo $data_order_type;?>"><?php echo esc_html( $title ); ?></option>
                  <?php
} else if ($filter_post_type == "date"){
  ?>
   <option value="date" data-ascdec="<?php echo $asc_desc; ?>" data-order-type="num"><?php echo esc_html( $title ); ?></option>
   <?php
 } else if ($filter_post_type == "relevance"){
   ?>
    <option value="relevance" data-ascdec="<?php echo $asc_desc; ?>" data-order-type=""><?php echo esc_html( $title ); ?></option>
    <?php
 } else if ( $filter_post_type == "title" ) {
?>
    <option value="title" data-ascdec="<?php echo $asc_desc; ?>" data-order-type=""><?php echo esc_html( $title ); ?></option>
<?php  
 }else {
  ?>
   <option value="post__in" data-ascdec="<?php echo $filter_post_type; ?>" data-order-type=""><?php echo esc_html( $title ); ?></option>
   <?php

 }
                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;

              }

            }

            new de_mach_orderby_item_code;

?>
