<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class de_mach_acf_slider_code extends ET_Builder_Module {

  public $vb_support = 'on';

  protected $module_credits = array(
    'module_uri' => DE_DMACH_PRODUCT_URL,
    'author'     => DE_DMACH_AUTHOR,
    'author_uri' => DE_DMACH_URL,
  );

  function init() {
    $this->name       = esc_html__( 'Gallery/Slider - Divi Machine', 'divi-machine' );
    $this->slug = 'et_pb_de_mach_acf_slider';
    $this->folder_name = 'divi_machine';


    $this->fields_defaults = array(
      // 'loop_layout'         => array( 'on' ),  
    );

    $this->settings_modal_toggles = array(
      'general' => array(
        'toggles' => array(
          'main_content' => esc_html__( 'Main Settings', 'divi-machine' ),
          'group_options' => esc_html__( 'Group Settings', 'divi-machine' ),
          'slider_options' => esc_html__( 'Slider Settings', 'divi-machine' ),
          'slider_desktop_options' => esc_html__( 'Slider Desktop Settings', 'divi-machine' ),
          'slider_tablet_options' => esc_html__( 'Slider Tablet Settings', 'divi-machine' ),
          'slider_mobile_options' => esc_html__( 'Slider Mobile Settings', 'divi-machine' ),
          'grid_options' => esc_html__( 'Grid Settings', 'divi-machine' ),
          'elements'     => esc_html__( 'Elements', 'divi-machine' ),
        ),
      ),
      'advanced' => array(
        'toggles' => array(
          'dots'  => esc_html__( 'Dots', 'divi-machine' ),
          'arrows'  => esc_html__( 'Arrows', 'divi-machine' ),
          'layout'  => esc_html__( 'Layout', 'divi-machine' ),
          'overlay' => esc_html__( 'Overlay', 'divi-machine' ),
          'image' => array(
            'title' => esc_html__( 'Image', 'divi-machine' ),
          ),
          'text'    => array(
            'title'    => esc_html__( 'Text', 'divi-machine' ),
            'priority' => 49,
          ),
        ),
      ),
      'custom_css' => array(
        'toggles' => array(
          'animation' => array(
            'title'    => esc_html__( 'Animation', 'divi-machine' ),
            'priority' => 90,
          ),
        ),
      ),

    );


    $this->main_css_element = '%%order_class%%';


    $this->advanced_fields = array(
      'fonts'                 => array(
      ),
      'borders'               => array(
        'default' => array(
          'css' => array(
            'main' => array(
              'border_radii'  => "{$this->main_css_element} .et_pb_gallery_item",
              'border_styles' => "{$this->main_css_element} .et_pb_gallery_item",
            ),
          ),
        ),
        'image' => array(
          'css' => array(
            'main' => array(
              'border_radii'  => "{$this->main_css_element} .et_pb_gallery_image img",
              'border_styles' => "{$this->main_css_element} .et_pb_gallery_image img",
            )
          ),
          'label_prefix'    => esc_html__( 'Image', 'divi-machine' ),
          'tab_slug'        => 'advanced',
          'toggle_slug'     => 'image',
          'depends_on'      => array( 'fullwidth' ),
          'depends_show_if' => 'off',
        ),
      ),
      'box_shadow'            => array(
        'default' => array(
          'show_if' => array(
            'fullwidth' => 'on',
          ),
        ),
        'image'   => array(
          'label'           => esc_html__( 'Image Box Shadow', 'divi-machine' ),
          'option_category' => 'layout',
          'tab_slug'        => 'advanced',
          'toggle_slug'     => 'image',
          'show_if'         => array(
            'fullwidth' => 'off',
          ),
          'css' => array(
            'main'         => '%%order_class%% .et_pb_gallery_image',
            'overlay' => 'inset',
          ),
          'default_on_fronts'  => array(
            'color'    => '',
            'position' => '',
          ),
        ),
      ),
      'margin_padding' => array(
        'css' => array(
          'important' => array( 'custom_margin' ), // needed to overwrite last module margin-bottom styling
        ),
      ),
      'max_width'             => array(
        'css' => array(
          'module_alignment' => '%%order_class%%.et_pb_gallery.et_pb_module',
        ),
      ),
      'filters'               => array(
        'css' => array(
          'main' => '%%order_class%%',
        ),
        'child_filters_target' => array(
          'tab_slug' => 'advanced',
          'toggle_slug' => 'image',
        ),
      ),
      'image'                 => array(
        'css' => array(
          'main'    => '%%order_class%% .et_pb_gallery_image img',
        ),
      ),
      'button' => false,
    );

    $this->custom_css_fields = array(
      'gallery_item' => array(
        'label'       => esc_html__( 'Gallery Item', 'divi-machine' ),
        'selector'    => '.et_pb_gallery_item',
      ),
    );


    $this->help_videos = array(
    );
  }

  function get_fields() {

    ///////////////////////////////


    $acf_fields = DEDMACH_INIT::get_acf_fields();

    //////////////////////////////


    $fields = array(
      'galery_layout' => array(
        'toggle_slug'       => 'main_content',
        'option_category'   => 'configuration',
        'label'             => esc_html__( 'Gallery Layout', 'divi-machine' ),
        'type'              => 'select',
        'options'           => array(
          'slider' => esc_html__( 'Slider', 'divi-machine' ),
          'grid' => sprintf( esc_html__( 'grid', 'divi-machine' ) ),
        ),
        'default' => 'slider',
        'affects'           => array(
          'slider_style',
          'slides_to_show',
          'slides_to_scroll',
          'infinate',
          'arrows',
          'dots',
          'speed',
          'center_mode',
          'variable_width',
          'adaptive_height',
          'autoplay',
          'autoplay_speed',
          'fade',
          'fade_animation',
          'same_height_slides',
          'same_height_slides_height',
          'slide_gap',
          'use_icon',
          'font_icon',
          'icon_color',
          'icon_font_size',
          'icon_font_top',
          'font_icon_next',
          'icon_font_size_next',
          'icon_font_top_next',
          'dots_color',
          'active_color',
          'deactive_color',
          'dots_size',
          'columns',
          'columns_tablet',
          'columns_mobile',
        ),
        'computed_affects' => array(
          '__gallery',
        ),
        'description'       => esc_html__( 'Choose the gallery type that you want to display.', 'divi-machine' ),
      ),
      'gallery_type' => array(
        'toggle_slug'       => 'main_content',
        'option_category'   => 'configuration',
        'label'             => esc_html__( 'ACF Gallery Type', 'divi-machine' ),
        'type'              => 'select',
        'affects'           => array(
          'group_name',
          'group_subfield',
          'gallery_acf',
        ),
        'options'           => array(
          'group' => esc_html__( 'Group field with image fields inside', 'divi-machine' ),
          'gallery' => sprintf( esc_html__( 'Gallery field (ACF pro only)', 'divi-machine' ) ),
        ),
        'default' => 'group',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'description'       => esc_html__( 'Choose the ACF type you are using, pro or free version (group).', 'divi-machine' ),
      ),
      'group_name' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'ACF Group Name', 'divi-machine' ),
        'type'              => 'select',
        'options'           => $acf_fields,
        'option_category'   => 'configuration',
        'depends_show_if'    => 'group',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'description'       => esc_html__( 'Add the name of the group you specified in ACF settings', 'divi-machine' ),
      ),
      'group_subfield' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'ACF Group Image Name', 'divi-machine' ),
        'type'              => 'text',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'group',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'description'       => esc_html__( 'Name add your images the same just with "_1", "_2" and so on after each. For example you could name the first one as "gallery_image_1" and the next as "gallery_image_2". Now, in this settings box, add the image name for example as "gallery_image", without the _1 or _2 extentions. We will loop through all the images with the same name and numbers to create the gallery from.', 'divi-machine' ),
      ),
      'gallery_acf' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'ACF Gallery Name', 'divi-machine' ),
        'type'              => 'select',
        'options'           => $acf_fields,
        'option_category'   => 'configuration',
        'depends_show_if'    => 'gallery',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'description'       => esc_html__( 'Choose the ACF gallery field to show the images', 'divi-machine' ),
      ),
      'gallery_repeater' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'Is this inside a repeater loop layout?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'show_if'           => array('gallery_type' => 'gallery'),
        'default'           => 'off',
        'description'       => esc_html__( 'Enable this if it is inside the repeater loop layout.', 'divi-machine' ),
      ),
      'include_featured' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'Include Featured Image in Gallery?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'           => 'on',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'description'       => esc_html__( 'If you have a featured image and want this part of the gallery (positon 1) - leave this enabled.', 'divi-machine' ),
      ),
      'enable_lightbox' => array(
        'toggle_slug'       => 'main_content',
        'label'             => esc_html__( 'Enable Lightbox?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'           => 'on',
        'description'       => esc_html__( 'Enable this if you want a lightbox to open when you click on the image.', 'divi-machine' ),
      ),
			'image_count'           => array(
				'default'         => "",
				'label'           => esc_html__( 'Image Count', 'divi-machine' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'Define the number of images that should be displayed.', 'et_builder' ),
        'computed_affects' => array(
          '__getgalleryslider',
        ),
				'toggle_slug'     => 'main_content',
			),
      'slider_style' => array(
        'label'           => __( 'Slider Style', 'divi-machine' ),
        'type'            => 'select',
        'option_category' => 'configuration',
        'options'           => array(
          'single'  => esc_html__( 'Single Slider', 'divi-machine' ),
          'horizontal'  => esc_html__( 'Horizontal Slider', 'divi-machine' ),
        ),
        'default'             => 'horizontal',
        'depends_show_if'    => 'slider',
        'toggle_slug'         => 'slider_options',
        'description'       => __( 'Choose the slider style you want. For just one image sliding, choose single or if you want to have thumbnails with a single slider, choose horizontal slider.', 'divi-machine' ),
        'affects'         => array(
          'slider_margin_top'
        ),
        'computed_affects' => array(
          '__getgalleryslider',
        )
      ),
      'slider_margin_top' => array(
        'label'           => esc_html__( 'Slider Top Space', 'divi-bodyshop-woocommerce' ),
        'type'            => 'range',
        'option_category' => 'configuration',
        'toggle_slug'     => 'slider_options',
        'description'       => esc_html__( 'Choose how far from the top you want the icon', 'divi-bodyshop-woocommerce' ),
        'default'         => '0px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'range_settings' => array(
          'min'  => '0',
          'max'  => '500',
          'step' => '1',
        ),
        'depends_show_if' => 'horizontal',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
      ),
      'infinate' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Infinite scrolling?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'description'       => esc_html__( 'Do you want your images to slide infinite so it looks like an endless amount of images.', 'divi-machine' ),
      ),
      'arrows' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Enable arrows?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'         => 'on',
        'affects'         => array(
          'use_icon',
        ),
        'description'       => esc_html__( 'Do you want to enable arrows to navigate images?', 'divi-machine' ),
      ),
      'dots' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Enable dots?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'affects'         => array(
          'dots_color',
        ),
        'description'       => esc_html__( 'Do you want to enable dot navigation?.', 'divi-machine' ),
      ),
      'speed' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Animation speed', 'divi-machine' ),
        'type'              => 'text',
        'depends_show_if'    => 'slider',
        'default'           => '300',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose the speed of the images when scrolling.', 'divi-machine' ),
      ),
      'center_mode' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Center Mode', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'description'       => esc_html__( 'Do you want the active image in the center?', 'divi-machine' ),
      ),
      'variable_width' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Variable width', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'description'       => esc_html__( 'Enable this if you want the slides to preserve each image width (Remember to disable Adaptive Height and Same Height Slides)', 'divi-machine' ),
      ),
      'adaptive_height' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Adaptive height', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'description'       => esc_html__( 'Enable this if you want the slides to preserve each image height. (Remember to disable Variable Width and Same Height Slides)', 'divi-machine' ),
      ),
      'autoplay' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Autoplay?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'description'       => esc_html__( 'Do you want to autoplay the sliding images?', 'divi-machine' ),
        'affects'           => array(
          'autoplay_speed',
        ),
      ),
      'autoplay_speed' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Autoplay speed', 'divi-machine' ),
        'type'              => 'range',
        'default'           => '2000',
        'default_unit'              => 'ms',
        'range_settings' => array(
          'min'  => '100',
          'max'  => '20000',
          'step' => '100',
        ),
        'depends_show_if'    => 'on',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose the speed of the autoplaying.', 'divi-machine' ),
      ),
      'fade' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Fade images?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'description'       => esc_html__( 'Do you want to fade the images?', 'divi-machine' ),
        'affects'           => array(
          'fade_animation',
        ),
      ),
      'fade_animation'            => array(
        'toggle_slug'       => 'slider_options',
        'label'              => esc_html__( 'Fade animation', 'divi-machine' ),
        'type'               => 'select',
        'options_category'   => 'configuration',
        'options'            => array(
          'linear' => esc_html__( 'linear', 'divi-machine' ),
          'ease'  => esc_html__( 'ease', 'divi-machine' ),
          'ease-in'  => esc_html__( 'ease-in', 'divi-machine' ),
          'ease-out'  => esc_html__( 'ease-out', 'divi-machine' ),
          'ease-in-out'  => esc_html__( 'ease-in-out', 'divi-machine' ),
        ),
        'depends_show_if'    => 'on',
      ),
      'same_height_slides' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Same height slides?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'slider',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'affects'           => array(
          'same_height_slides_height',
          'same_height_slides_all',
        ),
        'description'       => esc_html__( 'Enable this If you want to have the images all the same height (Remember to disable Variable Width and Adaptive Height)', 'divi-machine' ),
      ),
      'same_height_slides_all' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Same height thumbnails too?', 'divi-machine' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'depends_show_if'    => 'on',
        'default'           => 'on',
        'options'           => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'description'       => esc_html__( 'Enable this if you want the thumbnails and slider to be the same height. Disable if you just want the slider.', 'divi-machine' ),
      ),
      'same_height_slides_height' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Min height', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '600',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose the height of the images.', 'divi-machine' ),
        'depends_show_if'     => 'on',
      ),
      'slide_gap' => array(
        'toggle_slug'       => 'slider_options',
        'label'             => esc_html__( 'Slide Gap', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '0',
        'depends_show_if'    => 'slider',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose the gap between the images.', 'divi-machine' ),
      ),



      'slides_to_show' => array(
        'toggle_slug'       => 'slider_desktop_options',
        'label'             => esc_html__( 'Slides to show', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '5',
        'depends_show_if'    => 'slider',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose how many images to show at one time (not how many images are loaded)', 'divi-machine' ),
      ),
      'slides_to_scroll' => array(
        'toggle_slug'       => 'slider_desktop_options',
        'label'             => esc_html__( 'Slides to scroll', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '1',
        'depends_show_if'    => 'slider',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose how many images to scroll when clicking next or previous', 'divi-machine' ),
      ),

      'slides_to_show_tablet' => array(
        'toggle_slug'       => 'slider_tablet_options',
        'label'             => esc_html__( 'Slides to show on Tablet', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '2',
        'depends_show_if'    => 'slider',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose how many images to show at one time (not how many images are loaded) on tablet', 'divi-machine' ),
      ),
      'slides_to_scroll_tablet' => array(
        'toggle_slug'       => 'slider_tablet_options',
        'label'             => esc_html__( 'Slides to scroll on Tablet', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '1',
        'depends_show_if'    => 'slider',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose how many images to scroll when clicking next or previous on tablet', 'divi-machine' ),
      ),

      'slides_to_show_mobile' => array(
        'toggle_slug'       => 'slider_mobile_options',
        'label'             => esc_html__( 'Slides to show on Mobile', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '1',
        'depends_show_if'    => 'slider',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose how many images to show at one time (not how many images are loaded) on mobile', 'divi-machine' ),
      ),
      'slides_to_scroll_mobile' => array(
        'toggle_slug'       => 'slider_mobile_options',
        'label'             => esc_html__( 'Slides to scroll on Mobile', 'divi-machine' ),
        'type'              => 'text',
        'default'           => '1',
        'depends_show_if'    => 'slider',
        'option_category'   => 'configuration',
        'description'       => esc_html__( 'Choose how many images to scroll when clicking next or previous on mobile', 'divi-machine' ),
      ),
      



      'grid_layout' => array(
        'toggle_slug'       => 'grid_options',
        'label'             => esc_html__( 'Grid Style', 'divi-machine' ),
        'type'              => 'select',
        'options'           => array(
          'grid'       => esc_html__( 'Grid', 'divi-machine' ),
          'masonry'       => esc_html__( 'Masonry', 'divi-machine' ),
        ),
        'option_category'   => 'configuration',
        'default'           => 'grid',
        'description'       => esc_html__( 'Choose how you want your posts to be shown', 'divi-machine' ),
      ),
      'show_title_and_caption' => array(
        'label'              => esc_html__( 'Show Title and Caption', 'divi-machine' ),
        'type'               => 'yes_no_button',
        'option_category'    => 'configuration',
        'options'            => array(
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
          'off' => esc_html__( 'No', 'divi-machine' ),
        ),
        'default'   => 'off',
        'description'        => esc_html__( 'Whether or not to show the title and caption for images (if available).', 'divi-machine' ),
        'depends_show_if'    => 'grid',
        'toggle_slug'        => 'grid_options',
        'option_category'   => 'layout',
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
        'depends_show_if' => 'grid',
        'computed_affects' => array(
          '__getgalleryslider',
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
        'depends_show_if' => 'grid',
        'computed_affects' => array(
          '__getgalleryslider',
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
        'depends_show_if' => 'grid',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
        'description'        => esc_html__( 'How many columns do you want to see on mobile', 'divi-machine' ),
      ),

      
      'grid_gap_size' => array(
        'label'           => esc_html__( 'Grid Gap Size', 'divi-machine' ),
        'type'            => 'range',
        'toggle_slug'       => 'grid_options',
        'option_category'   => 'layout',
        'default'         => '25px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'range_settings' => array(
          'min'  => '1',
          'max'  => '120',
          'step' => '1',
        ),
        'show_if' => array('grid_layout' => 'grid'),
      ),


      'grid_hover_icon' => array(
        'label'               => esc_html__( 'Overlay Icon', 'divi-machine' ),
        'description'         => esc_html__( 'Here you can define a custom icon for the overlay', 'divi-machine' ),
        'type'                => 'select_icon',
        'class'               => array( 'et-pb-font-icon' ),
        'toggle_slug'       => 'grid_options',
        'option_category'   => 'layout',
        'default'           => '%%200%%'
      ),
      'zoom_icon_color' => array(
        'label'             => esc_html__( 'Overlay Icon Color', 'divi-machine' ),
        'description'       => esc_html__( 'Here you can define a custom color for the zoom icon.', 'divi-machine' ),
        'type'              => 'color-alpha',
        'custom_color'      => true,
        'depends_show_if'   => 'off',
        'toggle_slug'       => 'grid_options',
        'option_category'   => 'layout',
      ),
      'hover_overlay_color' => array(
        'label'             => esc_html__( 'Overlay Background Color', 'divi-machine' ),
        'description'       => esc_html__( 'Here you can define a custom color for the overlay', 'divi-machine' ),
        'type'              => 'color-alpha',
        'custom_color'      => true,
        'depends_show_if'   => 'off',
        'toggle_slug'       => 'grid_options',
        'option_category'   => 'layout',
      ),
      

			'grid_custom_code' => array(
				'label'           => esc_html__( 'Grid Custom Code', 'et_builder' ),
				'type'            => 'codemirror',
				'mode'            => 'html',
        'toggle_slug'       => 'grid_options',
        'option_category'   => 'layout',
        'computed_affects' => array(
          '__getgalleryslider',
        ),
				'description'     => esc_html__( 'Here you can define a custom grid for your gallery (advanced users only). See this doc here:', 'et_builder' ),
        'show_if'   => array (
          'grid_layout'  => 'grid',
        )
			),


      'use_icon' => array(
        'label'           => esc_html__( 'Custom arrows icon & color?', 'divi-machine' ),
        'type'            => 'yes_no_button',
        'options'         => array(
          'off' => esc_html__( 'No', 'divi-machine' ),
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
        ),
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
        'affects'         => array(
          'font_icon',
          'icon_color',
          'font_icon_next',
          'icon_color_next',
          'icon_font_size',
          'icon_font_size_next',
          'icon_font_top',
          'icon_font_top_next',
        ),
        'description' => esc_html__( 'Customise the custom gallery slider icons here.', 'divi-machine' ),
        'depends_show_if'     => 'on',
      ),
      'font_icon' => array(
        'label'               => esc_html__( 'Previous Icon', 'divi-machine' ),
        'type'                => 'select_icon',
        'class'               => array( 'et-pb-font-icon' ),
        'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'divi-machine' ),
        'depends_show_if'     => 'on',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
      ),
      'icon_color' => array(
        'default'           => '#2ea3f2',
        'label'             => esc_html__( 'Previous Icon Color', 'divi-machine' ),
        'type'              => 'color-alpha',
        'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi-machine' ),
        'depends_show_if'   => 'on',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
      ),
      'icon_font_size' => array(
        'label'           => esc_html__( 'Previous Icon Font Size', 'divi-machine' ),
        'type'            => 'range',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
        'default'         => '56px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'range_settings' => array(
          'min'  => '1',
          'max'  => '120',
          'step' => '1',
        ),
        'depends_show_if' => 'on',
      ),
      'icon_font_top' => array(
        'label'           => esc_html__( 'Previous Icon Top', 'divi-machine' ),
        'type'            => 'range',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
        'description'       => esc_html__( 'Choose how far from the top you want the icon', 'divi-machine' ),
        'default'         => '0px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'range_settings' => array(
          'min'  => '0',
          'max'  => '500',
          'step' => '1',
        ),
        'depends_show_if' => 'on',
      ),
      'font_icon_next' => array(
        'label'               => esc_html__( 'Next Icon', 'divi-machine' ),
        'type'                => 'select_icon',
        'class'               => array( 'et-pb-font-icon' ),
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
        'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'divi-machine' ),
        'depends_show_if'     => 'on',
      ),
      'icon_color_next' => array(
        'default'           => '#2ea3f2',
        'label'             => esc_html__( 'Next Icon Color', 'divi-machine' ),
        'type'              => 'color-alpha',
        'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi-machine' ),
        'depends_show_if'   => 'on',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
      ),
      'icon_font_size_next' => array(
        'label'           => esc_html__( 'Next Icon Font Size', 'divi-machine' ),
        'type'            => 'range',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
        'default'         => '56px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'range_settings' => array(
          'min'  => '1',
          'max'  => '120',
          'step' => '1',
        ),
        'depends_show_if' => 'on',
      ),
      'icon_font_top_next' => array(
        'label'           => esc_html__( 'Next Icon Top', 'divi-machine' ),
        'type'            => 'range',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'arrows',
        'description'       => esc_html__( 'Choose how far from the top you want the icon', 'divi-machine' ),
        'default'         => '0px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'range_settings' => array(
          'min'  => '0',
          'max'  => '500',
          'step' => '1',
        ),
        'depends_show_if' => 'on',
      ),


      'dots_color' => array(
        'label'           => esc_html__( 'Custom navigation dots size & color', 'divi-machine' ),
        'type'            => 'yes_no_button',
        'options'         => array(
          'off' => esc_html__( 'No', 'divi-machine' ),
          'on'  => esc_html__( 'Yes', 'divi-machine' ),
        ),
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'dots',
        'depends_show_if' => 'on',
        'affects'         => array(
          'active_color',
          'deactive_color',
          'dots_size',
        ),
        'description' => esc_html__( 'Customise the custom gallery slider icons here.', 'divi-machine' ),
      ),
      'active_color' => array(
        'default'           => '#000000',
        'label'             => esc_html__( 'Active dot color', 'divi-machine' ),
        'type'              => 'color-alpha',
        'description'       => esc_html__( 'Change the color of the active dot.', 'divi-machine' ),
        'depends_show_if'   => 'on',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'dots',
      ),
      'deactive_color' => array(
        'default'           => '#ececec',
        'label'             => esc_html__( 'Deactive dot color', 'divi-machine' ),
        'type'              => 'color-alpha',
        'description'       => esc_html__( 'Change the color of the deactive dot.', 'divi-machine' ),
        'depends_show_if'   => 'on',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'dots',
      ),
      'dots_size' => array(
        'label'           => esc_html__( 'Dot size', 'divi-machine' ),
        'type'            => 'range',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'dots',
        'default'         => '20px',
        'default_unit'    => 'px',
        'default_on_front'=> '',
        'range_settings' => array(
          'min'  => '1',
          'max'  => '120',
          'step' => '1',
        ),
        'depends_show_if' => 'on',
      ),
      '__getgalleryslider' => array(
        'type' => 'computed',
        'computed_callback' => array( 'de_mach_acf_slider_code', 'get_gallery_slider' ),
        'computed_depends_on' => array(
          'gallery_type',
          'group_name',
          'group_subfield',
          'slides_to_show',
          'gallery_acf',
          'include_featured',
          'galery_layout',
          'columns',
          'columns_tablet',
          'columns_mobile',
          'image_count',
          'grid_custom_code',
          'slider_style',
          'slider_margin_top'
        ),
      ),

    );

    return $fields;
  }


  public static function get_gallery_slider ( $args = array(), $conditional_tags = array(), $current_page = array() ){
    if (!is_admin()) {
      return;
    }

    $galery_layout = $args['galery_layout'];
    $slider_style = $args['slider_style'];

    $gallery_type = $args['gallery_type'];
    $group_name = $args['group_name'];
    $group_subfield = $args['group_subfield'];
    $slides_to_show  = $args['slides_to_show'];
    $gallery_acf     = $args['gallery_acf'];
    $include_featured     = $args['include_featured'];
    $slider_margin_top    = $args['slider_margin_top'];

    $columns     = $args['columns'];
    $columns_tablet     = $args['columns_tablet'];
    $columns_mobile     = $args['columns_mobile'];
    
    $grid_custom_code     = $args['grid_custom_code'];

    $image_count           = $args['image_count'];
    $image_count = (int)$image_count;

    $grid_custom_code_var = "0";

    if ($grid_custom_code !== "") {
      $grid_custom_code_var = "1";
    }

    ob_start();

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

    $post_slug = $page_post_type;


    $get_cpt_args = array(
      'post_type' => $post_slug,
      'post_status' => 'publish',
      'posts_per_page' => '1',
      'orderby' => 'ID',
      'order' => 'ASC',
    );

    query_posts( $get_cpt_args );

    $first = true;

    if ( have_posts() ) {
      while ( have_posts() ) {
        the_post();
        // setup_postdata( $post );

        if ( $first )  {

          //////////////////////////////////////////////////


          global $post;

          $images = array();

          $get_id = get_the_ID();
          $get_title = get_the_title();

          if ($gallery_type == "group") {

            $images_get_pre = get_field_object($group_name);
            $acf_type = $images_get_pre['type'];

            if ($acf_type == 'group') {

              if ($include_featured == 'on') {

                $thumb_id = get_post_thumbnail_id($post->ID);
                $url = wp_get_attachment_url($thumb_id, 'full');
                $sizes = get_intermediate_image_sizes($thumb_id);

                $featured_image_array = array(
                  'ID'                        => $thumb_id,
                  'url'                       => $url,
                  /*                      'alt'                       => $alt,
                  'description'               => $description,
                  'caption'                   => $caption,
                  'title'                      => $title,
                  'sizes'                     => $sizes
                */                  );
                $images[]['image'] = $featured_image_array;
              }

              if( have_rows($group_name) ): ?>
              <?php while( have_rows($group_name) ): the_row();

              // Get sub field values.

              if ( $subfields = get_row() ){
                foreach ($subfields as $key => $field) {
                  if ( !empty( $field ) ){
                    $field_obj = get_sub_field_object( $key );
                    if ( $field_obj['type'] == 'image' ){
                      if ( $field_obj['value'] ){
                        $images[]['image'] = $field_obj['value'];
                      }
                    }
                  }
                }
              }
              ?>
            <?php endwhile; ?>
          <?php endif;


        } else {
          echo 'Please select a ACF that is a group type';
        }

      } else if ($gallery_type == "gallery") {

        if ($include_featured == 'on') {

          $thumb_id = get_post_thumbnail_id($post->ID);
          $url = wp_get_attachment_url($thumb_id, 'full');
          $sizes = get_intermediate_image_sizes($thumb_id);

          $featured_image_array = array(
            'ID'                        => $thumb_id,
            'url'                       => $url,
            'alt'                       => $alt ?? '',
            'description'               => $description ?? '',
            'caption'                   => $caption ?? '',
            'title'                      => $title  ?? '',
            'sizes'                     => $sizes
          );
          $images[]['image'] = $featured_image_array;
        }

        $images_get = get_field($gallery_acf);

        foreach( $images_get as $image_get ) {

          $images[]['image'] = $image_get;

        }

      } else {
        // code...
      }


      if (!$images) {
        echo 'this post has no images, please make sure your first post has images';
      } else {

        if ( $image_count == "0" ) {
        } else {
          $images = array_slice( $images, 0, $image_count, true );
        }


        if ($galery_layout == "slider") { ///////////////////////////// IF IS SLIDER
          ?>

          <div class="et_pb_de_mach_acf_slider_173492 et_pb_de_mach_acf_slider_containter slick-initialized slick-slider" style="<?php echo ( $slider_style == 'horizontal' && $slider_margin_top != "")?'margin-top:'.$slider_margin_top:'';?>">
            <button class="slick-prev slick-arrow single" type="button">Previous</button>
            <div class="slick-list draggable">

              <div class="slick-slide slick-current slick-active single">
                <?php
                $imagesreturned = 0;
                foreach($images as $image) {

                  $object = array();
                  $is_video = false;
                  if ( isset( $image['image'] ) ) {
                    $object = $image['image'];
                  } else if ( isset( $image['video'] ) ) {
                    $object = $image['video'];
                    $is_video = true;
                  }

                  if ($imagesreturned >= $slides_to_show) {

                  } else {
                    ?>
                    <div class="et_pb_de_mach_gallery_item" style="position: relative;">
                      <?php if ( $is_video == false ) { ?>
                        <img class="de_mach_gallery_image" src="<?php echo $object['url'] ?>" srcset="<?php echo !empty($image['srcset'])?$image['srcset']:'';?>">
                      <?php } else { ?>
                        <video class="de_mach_gallery_image" controls="controls">
                          <source src="<?php echo $object['url'];?>"/>
                        </video>
                      <?php } ?>
                    </div>

                    <?php
                    $imagesreturned ++;
                  }
                }
                ?>
              </div>


              <div class="slick-slide slick-current slick-active horizontal">
                <?php
                $first_image = true;
                foreach($images as $image) {
                  $object = array();
                  $is_video = false;
                  if ( isset( $image['image'] ) ) {
                    $object = $image['image'];
                  } else if ( isset( $image['video'] ) ) {
                    $object = $image['video'];
                    $is_video = true;
                  }

                  if ( $first_image )  {
                    ?>
                    <div class="et_pb_de_mach_gallery_item" style="position: relative;">
                      <?php if ( $is_video == false ) { ?>
                        <img class="de_mach_gallery_image" src="<?php echo $object['url'] ?>" srcset="<?php echo !empty($image['srcset'])?$image['srcset']:'';?>">
                      <?php } else { ?>
                        <video controls="controls" class="de_mach_gallery_image">
                          <source src="<?php echo $object['url'];?>"/>
                        </video>
                      <?php } ?>
                    </div>
                    <?php
                  }
                  $first_image = false;
                }
                ?>
              </div>


            </div>
            <button class="slick-next slick-arrow single" type="button">Next</button>
          </div>

          <div class="et_pb_de_mach_acf_slider_173492 et_pb_de_mach_acf_slider_containter_nav slick-initialized slick-slider">
            <button class="slick-prev slick-arrow horizonal" type="button">Previous</button>
            <div class="slick-list draggable">
              <?php
              $imagesreturned = 0;
              foreach($images as $image) {
                $object = array();
                $is_video = false;
                if ( isset( $image['image'] ) ) {
                  $object = $image['image'];
                } else if ( isset( $image['video'] ) ) {
                  $object = $image['video'];
                  $is_video = true;
                }

                if ($imagesreturned >= $slides_to_show) {

                } else {
                  ?>
                  <div class="slick-slide slick-active">

                    <div class="et_pb_de_mach_gallery_item" style="position: relative;">
                      <?php if ( $is_video == false ) { ?>
                        <img class="de_mach_gallery_image" src="<?php echo $object['url'] ?>" srcset="<?php echo !empty($image['srcset'])?$image['srcset']:'';?>">
                      <?php } else { ?>
                        <video class="de_mach_gallery_image" controls="controls">
                          <source src="<?php echo $object['url'];?>"/>
                        </video>
                      <?php } ?>
                    </div>
                  </div>
                  <?php
                  $imagesreturned ++;
                }
              }
              ?>
            </div>
            <button class="slick-next slick-arrow horizonal" type="button">Next</button>
          </div>

          <div class="slick-dots">
            <li class="slick-active" role="presentation"><button></button></li>
            <li role="presentation"><button></button></li>
            <li role="presentation"><button></button></li>
            <li role="presentation"><button></button></li>
            <li role="presentation"><button></button></li>
          </div>

          <style>
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


        //////////////////////////// ELSE IS GRID
      } else {
        ?>
        <div class="filtered-posts-cont et_pb_de_mach_archive_loop">
          <div class="filtered-posts col-desk-<?php echo $columns?> col-tab-<?php echo $columns_tablet?> col-mob-<?php echo $columns_mobile?>">
            <div class="grid-posts">
              <?php
              
            $image_num = 1;
              foreach($images as $image) {

                $object = array();
                $is_video = false;
                if ( isset( $image['image'] ) ) {
                  $object = $image['image'];
                } else if ( isset( $image['video'] ) ) {
                  $object = $image['video'];
                  $is_video = true;
                }

              $grid_custom_code_css = '';
              if ($grid_custom_code_var == "1") {
                $grid_custom_code_css = 'grid-area: mod-'.$image_num.';';
                $image_num ++;
              }

                if (isset($object['title'])) {
                  $title = $object['title'];
                } else {
                  $title = "";
                }

                if (isset($object['caption'])) {
                  $caption = $object['caption'];
                } else {
                  $caption = "";
                }
                ?>
                <div class="grid-item dmach-grid-item et_pb_de_mach_gallery_item et_pb_gallery_item et_pb_grid_item et_pb_bg_layout_light" style="<?php echo esc_attr($grid_custom_code_css); ?> position: relative;display: block;">
                  <div class="grid-item-cont et_pb_gallery_image">
                    <?php if ( $is_video == false ) { ?>
                      <img class="de_mach_gallery_image" src="<?php echo $object['url'] ?>" srcset="<?php echo !empty($image['srcset'])?$image['srcset']:'';?>">
                      <span class="et_overlay"></span>
                    <?php } else { ?>
                      <video class="de_mach_gallery_image" controls="controls">
                        <source src="<?php echo $object['url'];?>"/>
                      </video>
                      <span class="et_overlay"></span>
                    <?php } ?>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
        <?php
      }

    }




    //////////////////////////////////////////////////
    $first = false;
  } else {

  }

}
}

$data = ob_get_clean();

return $data;

}



function render($attrs, $content, $render_slug){

  $galery_layout                     = $this->props['galery_layout'];

  $gallery_type                     = $this->props['gallery_type'];
  $gallery_repeater                     = $this->props['gallery_repeater'];
  
  $group_name                       = $this->props['group_name'];
  $group_subfield                       = $this->props['group_subfield'];

  $slider_style                       = $this->props['slider_style'];
  $slider_margin_top                  = $this->props['slider_margin_top'];
  $slides_to_show                       = $this->props['slides_to_show'];
  $slides_to_scroll                       = $this->props['slides_to_scroll'];

  $slides_to_show_tablet                       = $this->props['slides_to_show_tablet'];
  $slides_to_scroll_tablet                       = $this->props['slides_to_scroll_tablet'];
  $slides_to_show_mobile                       = $this->props['slides_to_show_mobile'];
  $slides_to_scroll_mobile                       = $this->props['slides_to_scroll_mobile'];
  

  $infinate                       = $this->props['infinate'];
  $arrows                       = $this->props['arrows'];
  $dots                       = $this->props['dots'];
  $speed                       = $this->props['speed'];
  $center_mode                       = $this->props['center_mode'];
  $variable_width                       = $this->props['variable_width'];
  $adaptive_height                       = $this->props['adaptive_height'];
  $autoplay                       = $this->props['autoplay'];
  $autoplay_speed                       = $this->props['autoplay_speed'];
  $autoplay_speed = preg_replace("/[^0-9]/", "", $autoplay_speed );
  $fade                       = $this->props['fade'];
  $fade_animation                       = $this->props['fade_animation'];
  $same_height_slides                       = $this->props['same_height_slides'];
  $same_height_slides_all                       = $this->props['same_height_slides_all'];
  $same_height_slides_height_get                      = $this->props['same_height_slides_height'];
  $same_height_slides_height = str_replace('pxpx' , 'px' , $same_height_slides_height_get);


  $slide_gap                      = $this->props['slide_gap'];


  $use_icon                = $this->props['use_icon'];
  $font_icon               = $this->props['font_icon'];
  $font_icon_next          = $this->props['font_icon_next'];
  $icon_color              = $this->props['icon_color'];
  $icon_font_size          = $this->props['icon_font_size'];
  $icon_color_next         = $this->props['icon_color_next'];
  $icon_font_size_next     = $this->props['icon_font_size_next'];
  $icon_top                = $this->props['icon_font_top'];
  $icon_top_next           = $this->props['icon_font_top_next'];

  $gallery_acf           = $this->props['gallery_acf'];
  $include_featured           = $this->props['include_featured'];

  $enable_lightbox           = $this->props['enable_lightbox'];

  $grid_layout           = $this->props['grid_layout'];

  $grid_gap_size           = $this->props['grid_gap_size'];
  $image_count           = $this->props['image_count'];
  $image_count = (int)$image_count;


  $grid_custom_code           = $this->props['grid_custom_code'];
  
  
  $columns     = $this->props['columns'];
  $columns_tablet     = $this->props['columns_tablet'];
  $columns_mobile     = $this->props['columns_mobile'];


  $active_color         = $this->props['active_color'];
  $deactive_color          = $this->props['deactive_color'];
  $dots_size          = $this->props['dots_size'];

  $show_title_and_caption          = $this->props['show_title_and_caption'];

  $num = mt_rand(100000,999999);
  $css_class              = $render_slug . "_" . $num;

  wp_enqueue_script( 'dmach-carousel-js',  DE_DMACH_PATH_URL . '/js/carousel.min.js', array(), DE_DMACH_VERSION, true );
  wp_enqueue_style( 'dmach-carousel-css', DE_DMACH_PATH_URL . '/css/carousel.min.css', array(), DE_DMACH_VERSION );
  wp_enqueue_script( 'divi-filter-masonry-js', DE_DMACH_PATH_URL . 'includes/modules/divi-ajax-filter/js/masonry.min.js', array( 'jquery' ), DE_DMACH_VERSION, true );

  $zoom_icon_color     = $this->props['zoom_icon_color'];
  $hover_overlay_color     = $this->props['hover_overlay_color'];
  $grid_hover_icon    = $this->props['grid_hover_icon'];
  
  if ($galery_layout == "slider") {

  } else {


    $grid_custom_code_var = "0";

    if ($grid_custom_code !== "") {

      $grid_custom_code_var = "1";

      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% .filtered-posts > :not(.no-results-layout)',
        'declaration' => sprintf(
          'grid-template-areas: %1$s;',
          $grid_custom_code
        ),
        'media_query' => ET_Builder_Element::get_media_query( 'min_width_981' ),
      ) );

      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% .filtered-posts > :not(.no-results-layout) .grid-item',
        'declaration' => sprintf(
          'grid-area: inherit !important;'
        ),
        'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
      ) );

    } 

    if (!empty( $grid_hover_icon ) ) {
      if ( class_exists( 'DE_Filter' ) ) {
          $grid_hover_icon_rendered = DE_Filter::et_icon_css_content( esc_attr($grid_hover_icon) );
      } else if ( class_exists( 'DEBC_INIT' ) ) {
          $grid_hover_icon_rendered = DEBC_INIT::et_icon_css_content( esc_attr($grid_hover_icon) );
      } else if ( class_exists( 'DEDMACH_INIT' ) ) {
          $grid_hover_icon_rendered = DEDMACH_INIT::et_icon_css_content( esc_attr($grid_hover_icon) );
      }

      $grid_icon_arr = explode('||', $grid_hover_icon);
      $grid_icon_font_family = ( !empty( $grid_icon_arr[1] ) && $grid_icon_arr[1] == 'fa' )?'FontAwesome':'ETmodules';
      $grid_icon_font_weight = ( !empty( $grid_icon_arr[2] ))?$grid_icon_arr[2]:'400';

      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% .et_overlay:before',
        'declaration' => sprintf(
          'content: "%1$s";
          color: %2$s;
          font-family:"%3$s"!important;
          font-weight:%4$s;',
          isset ($grid_hover_icon_rendered) ? esc_html( $grid_hover_icon_rendered ): '',
          $zoom_icon_color,
          $grid_icon_font_family,
          $grid_icon_font_weight
        ),
      ) );
    }

    ET_Builder_Element::set_style( $render_slug, array(
      'selector'    => '%%order_class%% .et_overlay',
      'declaration' => sprintf(
        'background: %1$s',
        $hover_overlay_color
      ),
    ) );
    
    if ($grid_gap_size !== "") {
      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% .filtered-posts > :not(.no-results-layout)',
        'declaration' => sprintf(
          'grid-gap: %1$s',
          $grid_gap_size
        ),
        ) );
    }
  }

  if ( $galery_layout == 'slider' && $slider_style == 'horizontal' ) {
    ET_Builder_Element::set_style( $render_slug, array(
      'selector'    => '%%order_class%% .et_pb_de_mach_acf_slider_containter_nav',
      'declaration' => sprintf(
        'margin-top: %1$s',
        $slider_margin_top
      ),
    ) );
  }

  ob_start();

  global $post;

  $images = array();

  if ($include_featured == 'on') {

    $thumb_id = get_post_thumbnail_id($post->ID);
    $url = wp_get_attachment_url($thumb_id, 'full');
    $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
    $title = get_post($thumb_id)->post_title; //The Title
    $caption = get_post($thumb_id)->post_excerpt; //The Caption
    $description = get_post($thumb_id)->post_content; // The Description
    $sizes = get_intermediate_image_sizes($thumb_id);

    $featured_image_array = array(
      'ID'                        => $thumb_id,
      'url'                       => $url,
      'alt'                       => $alt,
      'description'               => $description,
      'caption'                   => $caption,
      'title'                      => $title,
      'sizes'                     => $sizes
    );

    $srcset = wp_get_attachment_image_srcset( $thumb_id, 'full' );
    $images[] = array( 'image' => $featured_image_array, 'srcset' => $srcset );
  }

  if ($gallery_type == "group") {
    

    if( have_rows($group_name) ):
      while( have_rows($group_name) ): the_row();

      if ( $subfields = get_row() ){
        foreach ($subfields as $key => $field) {
          if ( !empty( $field ) ){
            $field_obj = get_sub_field_object( $key );
            if (is_array($field_obj)) {
              if ( $field_obj['type'] == 'image' ){
                if ( $field_obj['value'] ){
                  $image_obj = $field_obj['value'];

                  if ( $field_obj['return_format'] == 'id' ){
                    $srcset = wp_get_attachment_image_srcset( $field_obj['value'], 'thumbnail' );
                  }else if ( $field_obj['return_format'] == 'array' ){
                    $srcset = wp_get_attachment_image_srcset( $field_obj['value']['id'], 'full' );
                  }else{
                    $srcset = "";
                    $image_obj = array( 'url' => $field_obj['value'] );
                  }
                  $images[] = array( 'image' => $image_obj, 'srcset' => $srcset );
                }
              } else if ( $field_obj['type'] == 'file' ) {
                if ( $field_obj['value'] ) {
                  $file_url = '';

                  if ( $field_obj['return_format'] == 'id' ) {
                    $file_url = wp_get_attachment_url( $field_obj['value'] );
                  } else if ( $field_obj['return_format'] == 'array' ) {
                    $file_url = $field_obj['value']['url'];
                  } else {
                    $file_url = $field_obj['value'];
                  }

                  $imagesizedata = getimagesize($file_url);
                  if ($imagesizedata ) {
                    $images[] = array( 'image' => array( 'url' => $file_url ), 'srcset' => '' );                    
                  } else {
                    $extension = pathinfo($file_url, PATHINFO_EXTENSION);

                    if ( strtolower( $extension ) == 'mp4' ) {
                      $images[] = array( 'video' => array( 'url' => $file_url ) );
                    }
                  }
                }
              }
            }
          }
        }
      }

    endwhile;
  endif;

} else if ($gallery_type == "gallery") {

  
  $author_id = get_the_author_meta('ID');
  $check_if_author_field = get_field_object($gallery_acf, 'user_'. $author_id);

  if ($gallery_repeater == 'on') {
    $images_get = get_sub_field($gallery_acf);
  } else { 

    // Check if it is in a group first, if so - we dont check for the other ways
    $images_get_pre = get_field_object($gallery_acf);
    if ( $images_get_pre['parent'] != 0 ) {
      global $post;
      $parent_obj = get_post( $images_get_pre['parent'] );
      $parent_acf_obj = get_field_object( $parent_obj->post_name );
      if ( $parent_obj->post_type == 'acf-field-group' || ( $parent_obj->post_type == 'acf-field' && isset($parent_acf_obj['type']) && $parent_acf_obj['type'] == 'repeater')) {
        $noacf = true;
      } else if ( isset($parent_acf_obj['type']) && $parent_acf_obj['type'] == 'group') {
        if ( have_rows( $parent_obj->post_name ) ) {
          while ( have_rows( $parent_obj->post_name ) ) : the_row();
              $images_get = get_sub_field( $gallery_acf );
              $noacf = false;
          endwhile;
        }
      }

    } else {
      $noacf = true;
    }

    if ($noacf == true) {
      if (!empty($check_if_author_field)) {
        $images_get = get_field($gallery_acf, 'user_'. $author_id);    
      } else if (!empty(get_field($gallery_acf))) {
        $images_get = get_field($gallery_acf);
      } else {
        $images_get = get_field($gallery_acf);
      }
  }

  }

  if (is_array($images_get) ) {
  } else {
    $images_get = get_field($gallery_acf);
  }


  if (is_array($images_get )) {

    foreach( $images_get as $image_get ) {
      $srcset = wp_get_attachment_image_srcset( $image_get['ID'], 'full' );
      $images[] = array( 'image' => $image_get, 'srcset' => $srcset );
    }

  }

} else {
  // code...
}



// if (is_page()) {

//   if (!$images) {
//     $this->add_classname("hidethis");
//     return;
//   }

// } else {
//   $result = reset($images);

//   if (!$images || $result['image']['url'] == "") {
//     $this->add_classname("hidethis");
//     return;
//   }

// }


if ( $image_count == "0" ) {
} else {
  $images = array_slice( $images, 0, $image_count, true );
}



if ($galery_layout == "slider") { ///////////////////////////// IF IS SLIDER

  if ($infinate == "" || $infinate == "off") {
    $infinate_display = "'infinite': false,";
  } else {
    if ($infinate == "on") {
      $infinate = "true";
    }
    $infinate_display = "'infinite': " . $infinate . ',';
  };

  if ($arrows == "" || $arrows == "off") {
    $arrows_display = "'arrows': false,";
  } else {
    if ($arrows == "on") {
      $arrows = "true";
    }
    $arrows_display = "'arrows': " . $arrows . ',';
  };
  if ($dots == "" || $dots == "off") { $dots_display = ''; } else { if ($dots == "on") {$dots = "true";} $dots_display = "'dots': " . $dots . ','; };
  if ($center_mode == "" || $center_mode == "off") { $center_mode_display = ''; } else { if ($center_mode == "on") {$center_mode = "true";} $center_mode_display = "'centerMode': " . $center_mode . ','; };

  $variable_width_display = '';
  if ( $variable_width == "on") {
      if($adaptive_height=="off" && $same_height_slides=="off"){
          $variable_width_display = "'variableWidth': true,";
      }
  }
  $adaptive_height_display = '';
  if ( $adaptive_height == "on") {
	  if($variable_width=="off" && $same_height_slides=="off") {
		  $adaptive_height_display = "'adaptiveHeight': true,";
	  }
  }
  if ($autoplay == "" || $autoplay == "off") {
    $autoplay_display = '';
  } else {
    if ($autoplay == "on") {
      $autoplay = "true";
    }
    $autoplay_display = "'autoplay': " . $autoplay . ",
        'autoplaySpeed': " . $autoplay_speed . ',';
  };
  if ($fade == "" || $fade == "off") { $fade_display = ''; } else { if ($fade == "on") {$fade = "true";} $fade_display = "'fade': " . $fade . ','; };
  if ($fade_animation == "" || $fade_animation == "off") { $fade_animation_display = ''; } else { if ($fade_animation == "on") {$fade_animation = "true";} $fade_animation_display = "'fade_animation': '" . $fade_animation . "',"; };

  $rtl_atr  = "";
  $rtl_slick  = "";
  if (is_rtl()) {
    $rtl_slick = 'rtl: true,';
    $rtl_atr = 'dir="rtl"';
    
    ET_Builder_Element::set_style( $render_slug, array(
      'selector'    => '%%order_class%% .bc-simple-slider',
      'declaration' => 'direction: ltr;',
      ) );
      
    ET_Builder_Element::set_style( $render_slug, array(
      'selector'    => '%%order_class%% .bc-simple-slider+.bc-horizontal-slider-nav',
      'declaration' => 'display: none !important;',
    ) );    

    ET_Builder_Element::set_style( $render_slug, array(
      'selector'    => '%%order_class%% .slick-prev',
      'declaration' => 'left: 0;',
    ) );                                         
  }

  ?>

  <div <?php echo $rtl_atr ?> id="<?php echo $css_class?>" class="<?php echo $css_class?> et_pb_de_mach_acf_slider_containter  et_pb_gallery_items et_post_gallery clearfix" style="visibility: hidden;">
    <?php  foreach($images as $image) {

      $object = array();
      $is_video = false;
      if ( isset( $image['image'] ) ) {
        $object = $image['image'];
      } else if ( isset( $image['video'] ) ) {
        $object = $image['video'];
        $is_video = true;
      }


      if (isset($object['title'])) {
        $title = $object['title'];
      } else {
        $title = "";
      }

      if (isset($object['caption'])) {
        $caption = $object['caption'];
      } else {
        $caption = "";
      }

      if (isset($object['alt'])) {
        $alt = $object['alt'];
      } else {
        $alt = "";
      }
      

      ?>
      <div class="et_pb_de_mach_gallery_item et_pb_gallery_item et_pb_grid_item et_pb_bg_layout_light" style="position: relative;display: block;">
        <div class="et_pb_gallery_image">
        <?php if ($enable_lightbox == "on") { ?>
          <a href="<?php echo $object['url'] ?>" title="<?php echo $title ?>">
        <?php } ?>
            <?php if ( $is_video == false ) { ?>
              <img class="de_mach_gallery_image" src="<?php echo $object['url'] ?>" alt="<?php echo $alt ?>" title="<?php echo $title ?>" srcset="<?php echo $image['srcset'];?>">
            <?php } else { ?>
              <video class="de_mach_gallery_image" controls="controls">
                <source src="<?php echo $object['url'];?>"/>
              </video>
            <?php } ?>
            
         <?php if ($enable_lightbox == "on") { ?>
          </a>
         <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>


  <?php if ($slider_style == "horizontal") { ?>
    <div <?php echo $rtl_atr ?> id="<?php echo $css_class?>" class="<?php echo $css_class?> et_pb_de_mach_acf_slider_containter_nav" style="visibility: hidden;">
      <?php  foreach($images as $image) {

        $object = array();
        $is_video = false;
        if ( isset( $image['image'] ) ) {
          $object = $image['image'];
        } else if ( isset( $image['video'] ) ) {
          $object = $image['video'];
          $is_video = true;
        }
        
        if (isset($object['title'])) {
          $title = $object['title'];
        } else {
          $title = "";
        }

        if (isset($object['alt'])) {
          $alt = $object['alt'];
        } else {
          $alt = "";
        }

        ?>
        <div class="et_pb_de_mach_gallery_item" style="position: relative;">
            <?php if ( $is_video == false ) { ?>
              <img class="de_mach_gallery_image" src="<?php echo $object['url'] ?>" alt="<?php echo $alt ?>" title="<?php echo $title ?>" srcset="<?php echo $image['srcset'];?>">
            <?php } else { ?>
              <video class="de_mach_gallery_image" controls="controls">
                <source src="<?php echo $object['url'];?>"/>
              </video>
            <?php } ?>          
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
  <?php } ?>
  <?php if ( $slider_style == "single") { ?>
  <span class="gallery_vars hidethis" data-gallery_type="single" data-gallery_vars="'slidesToShow': <?php echo $slides_to_show ?>,'slidesToScroll': <?php echo $slides_to_scroll ?>,'speed': <?php echo $speed ?>,<?php if ($infinate_display !== "") { echo $infinate_display; } ?><?php if ($arrows_display !== "") { echo $arrows_display; } ?><?php if ($dots_display !== "") { echo $dots_display; } ?><?php if ($center_mode_display !== "") { echo $center_mode_display; } ?><?php if ($autoplay_display !== "") { echo $autoplay_display; } ?><?php if ($variable_width_display !== "") { echo $variable_width_display; } ?><?php if ($adaptive_height_display !== "") { echo $adaptive_height_display; } ?>"></span>
  <?php }else { ?>
  <span class="gallery_vars hidethis" data-gallery_type="gallery" data-gallery_vars="'slidesToShow': 1,'slidesToScroll': 1, 'arrows': false, 'fade':true, 'asNavFor' :'.et_pb_de_mach_acf_slider_containter_nav'" data-gallery_nav="'slidesToShow': <?php echo $slides_to_show ?>,'slidesToScroll': <?php echo $slides_to_scroll ?>,'speed': <?php echo $speed ?>,<?php if ($infinate_display !== "") { echo $infinate_display; } ?><?php if ($arrows_display !== "") { echo $arrows_display; } ?><?php if ($dots_display !== "") { echo $dots_display; } ?><?php if ($center_mode_display !== "") { echo $center_mode_display; } ?><?php if ($autoplay_display !== "") { echo $autoplay_display; } ?><?php if ($variable_width_display !== "") { echo $variable_width_display; } ?><?php if ($adaptive_height_display !== "") { echo $adaptive_height_display; } ?>"></span>
  <?php } ?>
  <script type="text/javascript">
  jQuery(document).on('ready divi_filter_completed', function($){
    <?php if ($slider_style == "single") { ?>
      jQuery('.et_pb_de_mach_acf_slider_containter').not('.slick-initialized').slick({
        'slidesToShow': <?php echo $slides_to_show ?>,
        'slidesToScroll': <?php echo $slides_to_scroll ?>,
        'speed': <?php echo $speed ?>,
        <?php if ($infinate_display !== "") { echo $infinate_display; } ?>
        <?php if ($arrows_display !== "") { echo $arrows_display; } ?>
        <?php if ($dots_display !== "") { echo $dots_display; } ?>
        <?php if ($center_mode_display !== "") { echo $center_mode_display; } ?>
        <?php if ($autoplay_display !== "") { echo $autoplay_display; } ?>
        <?php if ($variable_width_display !== "") { echo $variable_width_display; } ?>
        <?php if ($adaptive_height_display !== "") { echo $adaptive_height_display; } ?>
        <?php if ($slides_to_show == "1") { ?>
<?php echo $fade_display ?>
<?php echo $fade_animation_display ?>
          <?php } ?>
          
        responsive : [
           {
            breakpoint: 1024,
            settings: {
              slidesToShow: <?php echo $slides_to_show_tablet ?>,
              slidesToScroll: <?php echo $slides_to_scroll_tablet ?>
            }
          },
          {
            breakpoint: 767,
            settings: {
              slidesToShow: <?php echo $slides_to_show_mobile ?>,
              slidesToScroll: <?php echo $slides_to_scroll_mobile ?>
            }
          }
        ]
});
      jQuery('.et_pb_de_mach_acf_slider_containter').on('init', function(event, slick){
        jQuery(this).show();
      });
        <?php } else { ?>
          jQuery('.et_pb_de_mach_acf_slider_containter').on('init', function(event, slick){
            jQuery(this).css('visibility', 'visible');
          });
          jQuery('.et_pb_de_mach_acf_slider_containter').not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
    <?php echo $rtl_slick ?>
        <?php if ($autoplay_display !== "") { echo $autoplay_display; } ?>
            fade: true,
            <?php if ($adaptive_height_display !== "") { echo $adaptive_height_display; } ?>
          asNavFor: '.<?php echo $css_class?>.et_pb_de_mach_acf_slider_containter_nav',
          });
          jQuery('.et_pb_de_mach_acf_slider_containter_nav').on('init', function(event, slick){
            jQuery(this).css('visibility', 'visible');
          });

          jQuery('.<?php echo $css_class?>.et_pb_de_mach_acf_slider_containter_nav').not('.slick-initialized').slick({
            asNavFor: '.<?php echo $css_class?>.et_pb_de_mach_acf_slider_containter',
            focusOnSelect: true,
    <?php echo $rtl_slick ?>
            slidesToShow: <?php echo $slides_to_show ?>,
            slidesToScroll: <?php echo $slides_to_scroll ?>,
            speed: <?php echo $speed ?>,
        <?php if ($infinate_display !== "") { echo $infinate_display; } ?>
        <?php if ($arrows_display !== "") { echo $arrows_display; } ?>
        <?php if ($dots_display !== "") { echo $dots_display; } ?>
        <?php if ($center_mode_display !== "") { echo $center_mode_display; } ?>
        <?php if ($autoplay_display !== "") { echo $autoplay_display; } ?>
        <?php if ($variable_width_display !== "") { echo $variable_width_display; } ?>
        responsive : [
           {
            breakpoint: 1024,
            settings: {
              slidesToShow: <?php echo $slides_to_show_tablet ?>,
              slidesToScroll: <?php echo $slides_to_scroll_tablet ?>
            }
          },
          {
            breakpoint: 767,
            settings: {
              slidesToShow: <?php echo $slides_to_show_mobile ?>,
              slidesToScroll: <?php echo $slides_to_scroll_mobile ?>
            }
          }
        ]
          });
          <?php } ?>



          <?php if ($same_height_slides == "on" && $adaptive_height=="off" && $variable_width=="off") { ?>
            // same height slides
            jQuery(window).load(function() {
              jQuery('.<?php echo $css_class?>.et_pb_de_mach_acf_slider_containter').on('setPosition', function () {
                jQuery(this).find('.slick-slide').height('auto');
                var slickTrack = jQuery(this).find('.slick-track');
                var slickTrackHeight = jQuery(slickTrack).height();
                jQuery(this).find('.slick-slide').css('height', slickTrackHeight + 'px');
              });
            });
            <?php } ?>

          });
        </script>

        <?php if ($same_height_slides == "on" && $adaptive_height=="off" && $variable_width=="off") { ?>

            <?php 
            if ($same_height_slides_all == "on") {
              $css_classes_div = '
              .et_pb_de_mach_acf_slider_containter.'. $css_class .' .slick-slide div,
              .et_pb_de_mach_acf_slider_containter_nav.'. $css_class .' .slick-slide div
              ';
              $css_classes_img = '
              .et_pb_de_mach_acf_slider_containter.'. $css_class .' .slick-slide img,
              .et_pb_de_mach_acf_slider_containter_nav.'. $css_class .' .slick-slide img
              ';
            } else {
              $css_classes_div = '
              .et_pb_de_mach_acf_slider_containter.'. $css_class .' .slick-slide div
              ';
              $css_classes_img = '
              .et_pb_de_mach_acf_slider_containter.'. $css_class .' .slick-slide img
              ';
            }

            ?>

          <style>
           <?php echo $css_classes_div ?> {
            height: 100%;
            display: block !important;
            min-height: <?php echo $same_height_slides_height ?>px;
            position: relative;
          }
          <?php echo $css_classes_img ?> {
            display: block;
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            object-fit: cover;
            object-position: 50% 50%;
          }
        </style>
      <?php } ?>
      <?php if ($slide_gap != "0") { ?>
        <style>
        .et_pb_de_mach_acf_slider_containter.<?php echo $css_class?> .slick-slide,
        .et_pb_de_mach_acf_slider_containter_nav.<?php echo $css_class?> .slick-slide {
          margin: <?php echo $slide_gap ?>px;
        }
        .et_pb_de_mach_acf_slider_containter.<?php echo $css_class?> .slick-list,
        .et_pb_de_mach_acf_slider_containter_nav.<?php echo $css_class?> .slick-list {
          margin: 0 -<?php echo $slide_gap ?>px;
        }
        </style>
      <?php }
      if ($use_icon == "on") {

        $font_icon_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon ) );
        $font_icon_dis = preg_replace( '/(&#x)|;/', '', et_pb_process_font_icon( $font_icon_dis ) );
        $font_icon_next_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon_next ) );
        $font_icon_next_dis = preg_replace( '/(&#x)|;/', '', et_pb_process_font_icon( $font_icon_next_dis ) );


        if ($slider_style == "horizontal") {
          $content_prev =  sprintf('<style>.et_pb_de_mach_acf_slider_containter_nav.%5s .slick-prev::before {content:"\%1s" !important;font-size:%2s;color:%3s;top:%4s;}</style>',$css_class, $font_icon_dis, $icon_font_size, $icon_color, $icon_top);
          $content_next =  sprintf('<style>.et_pb_de_mach_acf_slider_containter_nav.%5s .slick-next::before {content:"\%1s" !important;font-size:%2s;color:%3s;top:%4s;}</style>',$css_class, $font_icon_next_dis, $icon_font_size_next, $icon_color_next, $icon_top_next );
        } else {
          $content_prev =  sprintf('<style>.et_pb_de_mach_acf_slider_containter.%5s .slick-prev::before {content:"\%1s" !important;font-size:%2s;color:%3s;top:%4s;}</style>',$css_class, $font_icon_dis, $icon_font_size, $icon_color, $icon_top);
          $content_next =  sprintf('<style>.et_pb_de_mach_acf_slider_containter.%5s .slick-next::before {content:"\%1s" !important;font-size:%2s;color:%3s;top:%4s;}</style>',$css_class, $font_icon_next_dis, $icon_font_size_next, $icon_color_next, $icon_top_next );
        }

        echo $content_prev;
        echo $content_next;

      }

      echo '<style>
      .'. $css_class .' .slick-dots li button {background: '. $deactive_color .' !important;width: '. $dots_size .';height: '. $dots_size .';}
      .'. $css_class .' .slick-dots li.slick-active button {background: '. $active_color .' !important;}
      .'. $css_class .' .slick-dots li {width: '. $dots_size .';height: '. $dots_size .';}
      </style>';




      //////////////////////////// ELSE IS GRID
    } else {
      if ($grid_layout == "masonry") {
        $css_add = "grid-auto-rows: 1px;";
        $masonry_class = "loop-grid";
      } else {
        $css_add = "";
        $masonry_class = "";
      }
      // wp_enqueue_script( 'hashchange' );
      ?>
      <div class="filtered-posts-cont et_pb_de_mach_archive_loop" >
        <div class="grid-item filtered-posts masonry et_pb_gallery_grid col-desk-<?php echo $columns?> col-tab-<?php echo $columns_tablet?> col-mob-<?php echo $columns_mobile?>" style="<?php echo $css_add ?>">
          <div class="grid-posts <?php echo esc_attr($masonry_class) ?> et_pb_gallery_items et_post_gallery clearfix">
            <?php
            
            $image_num = 1;
            foreach($images as $image) {

              $object = array();
              $is_video = false;
              if ( isset( $image['image'] ) ) {
                $object = $image['image'];
              } else if ( isset( $image['video'] ) ) {
                $object = $image['video'];
                $is_video = true;
              }

              $grid_custom_code_css = '';
              if (isset($grid_custom_code_var) && $grid_custom_code_var == "1") {
                $grid_custom_code_css = 'grid-area: mod-'.$image_num.';';
                $image_num ++;
              }


              if (isset($object['title'])) {
                $title = $object['title'];
              } else {
                $title = "";
              }
        
              if (isset($object['caption'])) {
                $caption = $object['caption'];
              } else {
                $caption = "";
              }
        
              if (isset($object['alt'])) {
                $alt = $object['alt'];
              } else {
                $alt = "";
              }
              

              ?>
              <div class="grid-item dmach-grid-item et_pb_de_mach_gallery_item et_pb_gallery_item et_pb_grid_item et_pb_bg_layout_light" style="<?php echo esc_attr($grid_custom_code_css); ?> position: relative;display: block;">
                <div class="grid-item-cont et_pb_gallery_image">
                <?php if ($enable_lightbox == "on") { ?>
                  <a href="<?php echo $object['url'] ?>" title="<?php echo $title ?>">
                <?php } ?>

                  <?php if ( $is_video == false ) { ?>
                    <img class="de_mach_gallery_image" src="<?php echo $object['url'] ?>" title="<?php echo esc_attr($title) ?>" alt="<?php echo esc_attr($alt) ?>" srcset="<?php echo $image['srcset'];?>">
                    <span class="et_overlay"></span>
                  <?php } else { ?>
                    <video class="de_mach_gallery_image" controls="controls">
                      <source src="<?php echo $object['url'];?>"/>
                    </video>
                    <span class="et_overlay"></span>
                  <?php } ?>
                    
                <?php if ($enable_lightbox == "on") { ?>
                  </a>
                <?php } ?>
                </div>
                <?php if ($show_title_and_caption == "on") { ?>
                  <h3 class="et_pb_gallery_title"><?php echo $title ?></h3>
                  <p class="et_pb_gallery_caption"><?php echo $caption ?></p>
                <?php } ?>
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

    //////////////////////////////////////////////////////////////////////

    return $data;

  }

}

new de_mach_acf_slider_code;

?>