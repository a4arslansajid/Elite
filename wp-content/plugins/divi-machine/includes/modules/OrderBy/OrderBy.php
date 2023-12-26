<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_orderby_code extends ET_Builder_Module {

    // Variables and functions should be started at 1 tab position.
    // Because class definition line has ended with '{'
    // So, put 1 tab after every block start '{'
    public $vb_support = 'on';

    // Array variables should have 1 tab
    // Just like '{', all lines should have 1 tab after '('
    protected $module_credits = array(
        'module_uri' => DE_DMACH_PRODUCT_URL,
        'author'     => DE_DMACH_AUTHOR,
        'author_uri' => DE_DMACH_URL,
    );

    function init() {
        $this->name       = esc_html__( 'Orderby - Divi Machine', 'divi-machine' );
        $this->slug = 'et_pb_de_mach_orderby';
    	$this->vb_support      = 'on';
    	$this->child_slug      = 'et_pb_de_mach_orderby_item';
        $this->child_item_text = esc_html__( 'Orderby Item', 'divi-machine' );
        $this->folder_name = 'divi_machine';
        
        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'main_content' => esc_html__( 'Main Options', 'divi-machine' ),
                    'layout' => esc_html__( 'Layout Options', 'divi-machine' ),
                    'filter_item' => esc_html__( 'Filter Item', 'divi-machine' ),
                    'toggle_appearance' => esc_html__( 'Toggle Appearance', 'divi-machine' ),
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

            'button'    => array(),
            'box_shadow' => array(
                'default' => array(),
                'filter_item'   => array(
                    'label'           => esc_html__( 'Filter Item Box Shadow', 'divi-machine' ),
                    'option_category' => 'layout',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'filter_item',
                    'css'             => array(
                        'main' => '%%order_class%% .dmach-filter-item',
                    ),
                    'default_on_fronts'  => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
            ),
            'margin_padding' => array(
              'css'        => array(
                  'main'    => '%%order_class%% .dmach-orderby-select',
                  'padding' => '%%order_class%% .dmach-orderby-select',
                  'margin'  => '%%order_class%% .dmach-orderby-select',
              ),
              'important' => 'all',
            ),
        );

        $this->custom_css_fields = array();
        $this->help_videos = array();
    }

    function get_fields() {

        ///////////////////////////////
        $acf_fields = DEDMACH_INIT::get_acf_fields();
        //////////////////////////////

        $fields = array(
            'filter_location' => array(
                'toggle_slug'       => 'main_content',
                'label'             => esc_html__( 'Orderby Location', 'divi-machine' ),
                'type'              => 'select',
                'options'           => array(
                    'left'       => esc_html__( 'Left', 'divi-machine' ),
                    'right'       => esc_html__( 'Right', 'divi-machine' ),
                ),
            )
        );

        return $fields;
    }

    public function get_search_items_content() {
        return $this->content;
    }

    function render($attrs, $content, $render_slug){

        $filter_location  = $this->props['filter_location'];
        $this->add_classname('align-' . $filter_location);

        if (is_admin()) {
            return;
        }

        $all_tabs_content = $this->get_search_items_content();
        $this->add_classname( 'main-orderby' );
        
        //////////////////////////////////////////////////////////////////////

        ob_start();
        global $post;

?>
        <div id="dmach_orderby">
            <p class="et_pb_contact_field" data-type="select">
                <select class="dmach-orderby-select et_pb_contact_select input">
                <?php echo $all_tabs_content; ?>
                </select>
            </p>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $('#dmach_orderby select').off('change').on('change', function() {
                    var select_val = $(this).val();
                    var ascdesc = $(this).find(':selected').attr("data-ascdec");
                    var ordertype = $(this).find(':selected').attr("data-order-type");
                    var $main_loop = $('.divi-filter-archive-loop.main-loop');
                    $main_loop.attr('data-sortorder', select_val);
                    $main_loop.attr('data-sortasc', ascdesc);
                    $main_loop.attr('data-sortchanged', 'true');
                    $main_loop.attr('data-sorttype', ordertype);
                    divi_find_filters_to_filter();
                });
            });
        </script>
<?php
        $data = ob_get_clean();
        //////////////////////////////////////////////////////////////////////
        return $data;
    }
}

new de_mach_orderby_code;

?>
