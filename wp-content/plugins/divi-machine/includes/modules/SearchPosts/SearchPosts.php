<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_search_posts_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DMACH_PRODUCT_URL,
  'author'     => DE_DMACH_AUTHOR,
  'author_uri' => DE_DMACH_URL,
);

                function init() {
                    $this->name       = esc_html__( 'Search Posts - Divi Machine', 'divi-machine' );
                    $this->slug = 'et_pb_de_mach_search_posts';
                		$this->vb_support      = 'on';
                		$this->child_slug      = 'et_pb_de_mach_search_posts_item';
                		$this->child_item_text = esc_html__( 'Search Item', 'et_builder' );
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
                  			),
              			'background' => array(
              				'settings' => array(
              					'color' => 'alpha',
              				),
              			),
                    'button' => array(
            'button' => array(
              'label' => esc_html__( 'Button', 'divi-machine' ),
              'css' => array(
                'main' => "{$this->main_css_element} .et_pb_button",
                'important' => 'all',
              ),
              'box_shadow'  => array(
                'css' => array(
                  'main' => "{$this->main_css_element} .et_pb_button",
                      'important' => 'all',
                ),
              ),
              'margin_padding' => array(
              'css'           => array(
                'main' => "{$this->main_css_element} .et_pb_button",
                'important' => 'all',
              ),
              ),
                'use_alignment' => true,
            ),
          ),
                    'form_field'           => array(
                      'form_field' => array(
                        'label'         => esc_html__( 'Fields', 'et_builder' ),
                        'css'           => array(
                          'main'                   => '%%order_class%% .et_pb_contact_field select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                          'background_color'       => '%%order_class%% .et_pb_contact_field select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                          'background_color_hover' => '%%order_class%% .et_pb_contact_field select:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:hover + label i, %%order_class%% .et_pb_contact_field[type="radio"]:hover + label i',
                          'focus_background_color' => '%%order_class%% .et_pb_contact_field select:focus, %%order_class%% .et_pb_contact_field[type="checkbox"]:active + label i, %%order_class%% .et_pb_contact_field[type="radio"]:active + label i',
                          'focus_background_color_hover' => '%%order_class%% .et_pb_contact_field select:focus:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:active:hover + label i, %%order_class%% .et_pb_contact_field[type="radio"]:active:hover + label i',
                          'placeholder_focus'      => '%%order_class%% p .input:focus::-webkit-input-placeholder, %%order_class%% p .input:focus::-moz-placeholder, %%order_class%% p .input:focus:-ms-input-placeholder, %%order_class%% p textarea:focus::-webkit-input-placeholder, %%order_class%% p textarea:focus::-moz-placeholder, %%order_class%% p textarea:focus:-ms-input-placeholder',
                          'padding'                => '%%order_class%% .et_pb_contact_field select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                          'margin'                 => '%%order_class%% .et_pb_contact_field select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label i, %%order_class%% .et_pb_contact_field[type="radio"] + label i',
                          'form_text_color'        => '%%order_class%% .et_pb_contact_field select, %%order_class%% .et_pb_contact_field[type="checkbox"] + label, %%order_class%% .et_pb_contact_field[type="radio"] + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked + label i:before',
                          'form_text_color_hover'  => '%%order_class%% .et_pb_contact_field select:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:hover + label, %%order_class%% .et_pb_contact_field[type="radio"]:hover + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:hover + label i:before',
                          'focus_text_color'       => '%%order_class%% .et_pb_contact_field select:focus, %%order_class%% .et_pb_contact_field[type="checkbox"]:active + label, %%order_class%% .et_pb_contact_field[type="radio"]:active + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:active + label i:before',
                          'focus_text_color_hover' => '%%order_class%% .et_pb_contact_field select:focus:hover, %%order_class%% .et_pb_contact_field[type="checkbox"]:active:hover + label, %%order_class%% .et_pb_contact_field[type="radio"]:active:hover + label, %%order_class%% .et_pb_contact_field[type="checkbox"]:checked:active:hover + label i:before',
                        ),
                        'box_shadow'    => false,
                        'border_styles' => false,
                        'font_field'    => array(
                          'css' => array(
                            'main'  => implode( ', ', array(
                              "{$this->main_css_element} .input",
                              "{$this->main_css_element} .input::placeholder",
                              "{$this->main_css_element} .input::-webkit-input-placeholder",
                              "{$this->main_css_element} .input::-moz-placeholder",
                              "{$this->main_css_element} .input:-ms-input-placeholder",
                              "{$this->main_css_element} .input[type=checkbox] + label",
                              "{$this->main_css_element} .input[type=radio] + label",
                            ) ),
                            'hover' => array(
                              "{$this->main_css_element} .input:hover",
                              "{$this->main_css_element} .input:hover::placeholder",
                              "{$this->main_css_element} .input:hover::-webkit-input-placeholder",
                              "{$this->main_css_element} .input:hover::-moz-placeholder",
                              "{$this->main_css_element} .input:hover:-ms-input-placeholder",
                              "{$this->main_css_element} .input[type=checkbox]:hover + label",
                              "{$this->main_css_element} .input[type=radio]:hover + label",
                            ),
                          ),
                        ),
                        'margin_padding' => array(
                          'css'        => array(
                            'main'    => '%%order_class%% .et_pb_contact_field',
                            'padding' => '%%order_class%% .et_pb_contact_field .input',
                            'margin'  => '%%order_class%% .et_pb_contact_field',
                          ),
                        ),
                      ),
                    ),
                  			'box_shadow' => array(
                  				'default' => array(),
                  				'product' => array(
                  					'label' => esc_html__( 'Default Layout - Box Shadow', 'divi-machine' ),
                  					'css' => array(
                  						'main' => "%%order_class%%",
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

                    ///////////////////////////////


                    //////////////////////////////


                      $fields = array(
                      'post_type_choose' => array(
                      'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Search Post Type', 'divi-machine' ),
                        'type'              => 'select',
                				'options'           => et_get_registered_post_type_options( false, false ),
                        'option_category'   => 'configuration',
                        'default'           => 'post',
                        'description'       => esc_html__( 'Choose the post type you want to search', 'divi-machine' ),
                      ),
                      'search_button_text' => array(
                      'toggle_slug'       => 'main_content',
                        'label'             => esc_html__( 'Search Button Text', 'divi-machine' ),
                        'type'              => 'text',
                        'option_category'   => 'configuration',
                        'default'           => 'Search',
                        'description'       => esc_html__( 'Choose what you want the search button to say', 'divi-machine' ),
                      ),
                      'inline_search_btn' => array(
                        'label' => esc_html__( 'Make Button Inline?', 'divi-machine' ),
                        'type' => 'yes_no_button',
                        'toggle_slug'       => 'main_content',
                        'options_category' => 'configuration',
                        'options' => array(
                          'on' => esc_html__( 'Yes', 'divi-machine' ),
                          'off' => esc_html__( 'No', 'divi-machine' ),
                        ),
                        'default' => 'off',
                        'description' => esc_html__( 'Enable this if you want the search button to be the last item in the form.', 'divi-machine' ),
                      ),
                      'open_in_new_tab'   => array(
                        'label' => esc_html__( 'Show Search Result in New tab?', 'divi-machine' ),
                        'type' => 'yes_no_button',
                        'toggle_slug'       => 'main_content',
                        'options_category' => 'configuration',
                        'options' => array(
                          'on' => esc_html__( 'Yes', 'divi-machine' ),
                          'off' => esc_html__( 'No', 'divi-machine' ),
                        ),
                        'default' => 'off',
                        'description' => esc_html__( 'Enable this if you want to show the result on the new tab.', 'divi-machine' ),
                      ),
                      'link_archive_page' => array(
                        'label' => esc_html__( 'Submit to Specific Page?', 'divi-machine' ),
                        'type' => 'select',
                        'toggle_slug'       => 'main_content',
                        'options_category' => 'configuration',
                        'options' => array(
                          'on' => esc_html__( 'Post Archive Page', 'divi-machine' ),
                          'off' => esc_html__( 'Search Result Page', 'divi-machine' ),
                          'auto' => esc_html__( 'Wordpress Auto Redirect', 'divi-machine' ),
                        ),
                        'default' => 'off',
                        'description' => esc_html__( 'Select which page where search form should be redirect. If you select Wordpress Auto Redirect, it will depends on your search parameters by wordpress automatically.', 'divi-machine' ),
                      ),
                      );

                      return $fields;
                  }

                  public function get_search_items_content() {
                		return $this->content;
                	}


                  public function get_transition_fields_css_props() {
                    $fields = parent::get_transition_fields_css_props();

                    $fields['form_field_background_color'] = array(
                      'background-color' => implode(', ', array(
                        '%%order_class%% .et_pb_contact_field',
                        '%%order_class%% .et_pb_contact_field[type="checkbox"]+label i',
                        '%%order_class%% .et_pb_contact_field[type="radio"]+label i',
                      ))
                    );

                    return $fields;
                  }

                  public function get_button_alignment() {
                		$text_orientation = isset( $this->props['button_alignment'] ) ? $this->props['button_alignment'] : '';
                		return et_pb_get_alignment( $text_orientation );
                	}


                  function render($attrs, $content, $render_slug){

                    if (is_admin()) {
                        return;
                    }

                    $post_type_choose                         = $this->props['post_type_choose'];
                    $search_button_text                       = $this->props['search_button_text'];

                    $inline_search_btn                       = $this->props['inline_search_btn'];
                    $link_archive_page                       = $this->props['link_archive_page'];
                    $open_in_new_tab                          = $this->props['open_in_new_tab'];
                    
                    $button_alignment             = $this->get_button_alignment();

		                $all_tabs_content = $this->get_search_items_content();

                    $this->add_classname( 'et_pb_button_alignment_' . $button_alignment . '' );

                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    if ($link_archive_page == "on") {
                      $post_link = get_post_type_archive_link( $post_type_choose );
                    } else {
                      if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
                        $post_link = get_home_url();
                      } else {
                        $post_link = get_site_url();  
                      }
                    }

                    wp_enqueue_script('divi-filter-js');

                    $target_str = '';

                    if ( $open_in_new_tab == 'on' ){
                      $target_str = 'target="_blank"';
                    }

// $post_link = get_post_type_archive_link( $post_type_choose );
                    ?>
<form id="dmach-search-form" action="<?php echo $post_link ?>" method="GET" role="search" <?php echo $target_str;?> >
<div class="dmach-search-items">
<?php echo $all_tabs_content; ?>

<?php if ($inline_search_btn == "on") {
  ?>
  <div class="button_container hidden">
  <button class="et_pb_button search-btn button" type="submit"><?php echo $search_button_text ?></button>
  </div>
  <?php
}
?>
</div>
<?php if ($link_archive_page != 'auto' ) { ?>
<input id="filter" type="hidden" name="filter" value="true" />
<?php } ?>
<?php if ($link_archive_page == "off") { ?>
<input id="is_search" type="hidden" name="is_search" value="true" />
<?php } ?>
<input id="search_post_type" type="hidden" name="post_type" value="<?php echo $post_type_choose ?>" />
<?php if ($inline_search_btn == "off") {
  ?>
  <div class="button_container hidden">
  <button class="et_pb_button search-btn button" type="submit"><?php echo $search_button_text ?></button>
  </div>
  <?php
}
?>
</form>

<script>
  jQuery(document).ready(function($){
    $('.et_pb_de_mach_search_posts form').submit(function(){

      $(this).find('[data-name]').each(function(){
        $(this).attr('name', $(this).data('name') );
      });

      $('.search_filter_cont[data-conditional-logic]').each(function () {
        if ( $(this).closest('.et_pb_de_mach_search_posts_item').css('display') == 'none' ) {
          $(this).closest('.et_pb_de_mach_search_posts_item').remove();
        }
      });

      var form = $(this);

      var param_array = $(this).serializeArray();
      
      var output = [];

      param_array.forEach(function(item) {
        var existing = output.filter(function(v, i) {
          return v.name == item.name;
        });
        if (existing.length) {
          var existingIndex = output.indexOf(existing[0]);
          var current_checkbox_name = output[existingIndex].name;
          var filter_condition = form.find('input[name="' + current_checkbox_name + '"]').closest('.search_filter_cont').attr('data-filter-condition');
          if ( item.value != '' ) {
            if ( filter_condition == 'or' ) {
              output[existingIndex].value = output[existingIndex].value + ',' + item.value;
            } else if ( filter_condition == 'and' ) {
              output[existingIndex].value = output[existingIndex].value + '|' + item.value;
            } else if ( typeof filter_condition == 'undefined' ) {
              output[existingIndex].value = item.value;
            }
          }
        } else {
          output.push(item);
        }
      });
      var query_string = $.param( output );
      var url = form.attr('action') + '?' + query_string;
<?php if ( $open_in_new_tab == 'on' ) { ?>
      window.open( url );
<?php } else { ?>
      document.location.href = url;
<?php } ?>
      //$(this).off('submit').submit();
      return false;
    });
  });
</script>


                    <?php
                    $data = ob_get_clean();



                   //////////////////////////////////////////////////////////////////////

                  return $data;



              }

            }

            new de_mach_search_posts_code;

?>
