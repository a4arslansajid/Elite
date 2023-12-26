<?php
if ( ! defined( 'ABSPATH' ) ) exit;

final class DOMWordsIterator implements Iterator {
    
    private $start, $current;
    private $offset, $key, $words;

    /**
     * expects DOMElement or DOMDocument (see DOMDocument::load and DOMDocument::loadHTML)
     */
    function __construct(DOMNode $el)
    {
        if ($el instanceof DOMDocument) $this->start = $el->documentElement;
        else if ($el instanceof DOMElement) $this->start = $el;
        else throw new InvalidArgumentException("Invalid arguments, expected DOMElement or DOMDocument");
    }
    
    /**
     * Returns position in text as DOMText node and character offset.
     * (it's NOT a byte offset, you must use mb_substr() or similar to use this offset properly).
     * node may be NULL if iterator has finished.
     *
     * @return array
     */
    function currentWordPosition()
    {
        return array($this->current, $this->offset, $this->words);
    }

    /**
     * Returns DOMElement that is currently being iterated or NULL if iterator has finished.
     *
     * @return DOMElement
     */
    function currentElement()
    {
        return $this->current ? $this->current->parentNode : NULL;
    }
    
    // Implementation of Iterator interface
    function key()
    {
        return $this->key;
    }
    
    function next()
    {
        if (!$this->current) return;

        if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE)
        {
            if ($this->offset == -1)
            {
                $this->words = preg_split("/[\n\r\t ]+/", $this->current->textContent, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_OFFSET_CAPTURE);
            }
            $this->offset++;
            
            if ($this->offset < count($this->words)) { 
                $this->key++;
                return;
            }
            $this->offset = -1;
        }

        while($this->current->nodeType == XML_ELEMENT_NODE && $this->current->firstChild)
        {
            $this->current = $this->current->firstChild;
            if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE) return $this->next();
        }

        while(!$this->current->nextSibling && $this->current->parentNode)
        {
            $this->current = $this->current->parentNode;
            if ($this->current === $this->start) {$this->current = NULL; return;}
        }

        $this->current = $this->current->nextSibling;

        return $this->next();
    }

    function current()
    {
        if ($this->current) return $this->words[$this->offset][0];
        return NULL;
    }

    function valid()
    {
        return !!$this->current;
    }

    function rewind()
    {
        $this->offset = -1; $this->words = array();
        $this->current = $this->start;
        $this->next();
    }
}

class de_mach_content_code extends ET_Builder_Module {

  public $vb_support = 'on';

  protected $module_credits = array(
    'module_uri' => DE_DMACH_PRODUCT_URL,
    'author'     => DE_DMACH_AUTHOR,
    'author_uri' => DE_DMACH_URL,
  );

  function init() {
    $this->name       = esc_html__( 'Post Content - Divi Machine', 'divi-machine' );
    $this->slug = 'et_pb_de_mach_content';
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
          'text' => array(
            'title'    => esc_html__( 'Content Text', 'divi-machine' ),
            'priority' => 45,
            'tabbed_subtoggles' => true,
            'bb_icons_support' => true,
            'sub_toggles' => array(
              'p'     => array(
                'name' => 'P',
                'icon' => 'text-left',
              ),
              'a'     => array(
                'name' => 'A',
                'icon' => 'text-link',
              ),
              'ul'    => array(
                'name' => 'UL',
                'icon' => 'list',
              ),
              'ol'    => array(
                'name' => 'OL',
                'icon' => 'numbered-list',
              ),
              'quote' => array(
                'name' => 'QUOTE',
                'icon' => 'text-quote',
              ),
            ),
          ),
        ),
      ),

    );


    $this->main_css_element = '%%order_class%%';


    $this->advanced_fields = array(
      'fonts' => array(
        'text'   => array(
          'label'    => esc_html__( 'Text', 'divi-machine' ),
          'css'      => array(
            'line_height' => "{$this->main_css_element} p",
            'color' => "{$this->main_css_element} p",
          ),
          'line_height' => array(
            'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
          ),
          'font_size' => array(
            'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
          ),
          'toggle_slug' => 'text',
          'sub_toggle'  => 'p',
        ),
        'link'   => array(
          'label'    => esc_html__( 'Link', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} a",
            'color' => "{$this->main_css_element} a",
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'font_size' => array(
            'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
          ),
          'toggle_slug' => 'text',
          'sub_toggle'  => 'a',
        ),
        'ul'   => array(
          'label'    => esc_html__( 'Unordered List', 'divi-machine' ),
          'css'      => array(
            'main'        => "{$this->main_css_element} ul",
            'color'       => "{$this->main_css_element} ul",
            'line_height' => "{$this->main_css_element} ul li",
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'toggle_slug' => 'text',
          'sub_toggle'  => 'ul',
        ),
        'ol'   => array(
          'label'    => esc_html__( 'Ordered List', 'divi-machine' ),
          'css'      => array(
            'main'        => "{$this->main_css_element} ol",
            'color'       => "{$this->main_css_element} ol",
            'line_height' => "{$this->main_css_element} ol li",
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'toggle_slug' => 'text',
          'sub_toggle'  => 'ol',
        ),
        'quote'   => array(
          'label'    => esc_html__( 'Blockquote', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} blockquote, {$this->main_css_element} blockquote p",
            'color' => "{$this->main_css_element} blockquote, {$this->main_css_element} blockquote p",
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'toggle_slug' => 'text',
          'sub_toggle'  => 'quote',
        ),
        'header_1'   => array(
          'label'    => esc_html__( 'Heading', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} h1",
          ),
          'font_size' => array(
            'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'toggle_slug' => 'header',
          'sub_toggle'  => 'h1',
        ),
        'header_2'   => array(
          'label'    => esc_html__( 'Heading 2', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} h2",
          ),
          'font_size' => array(
            'default' => '26px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'toggle_slug' => 'header',
          'sub_toggle'  => 'h2',
        ),
        'header_3'   => array(
          'label'    => esc_html__( 'Heading 3', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} h3",
          ),
          'font_size' => array(
            'default' => '22px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'toggle_slug' => 'header',
          'sub_toggle'  => 'h3',
        ),
        'header_4'   => array(
          'label'    => esc_html__( 'Heading 4', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} h4",
          ),
          'font_size' => array(
            'default' => '18px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'toggle_slug' => 'header',
          'sub_toggle'  => 'h4',
        ),
        'header_5'   => array(
          'label'    => esc_html__( 'Heading 5', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} h5",
          ),
          'font_size' => array(
            'default' => '16px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'toggle_slug' => 'header',
          'sub_toggle'  => 'h5',
        ),
        'header_6'   => array(
          'label'    => esc_html__( 'Heading 6', 'divi-machine' ),
          'css'      => array(
            'main' => "{$this->main_css_element} h6",
          ),
          'font_size' => array(
            'default' => '14px',
          ),
          'line_height' => array(
            'default' => '1em',
          ),
          'toggle_slug' => 'header',
          'sub_toggle'  => 'h6',
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

      'content_type' => array(
        'option_category' => 'configuration',
        'toggle_slug'     => 'main_content',
        'label'             => esc_html__( 'Content Type', 'divi-machine' ),
        'type'              => 'select',
        'options'           => array(
          'content' => esc_html__( 'Content (what is in the editor)', 'divi-machine' ),
          'excert' => sprintf( esc_html__( 'Excerpt', 'divi-machine' ) ),
          'category' => esc_html__( 'Taxonomy Description', 'divi-machine' ),
        ),
        'default' => 'content',
        'computed_affects' => array(
          '__getpostcontent',
        ),
        'description'       => esc_html__( 'Choose if you want to show the content or the excert (short description).', 'divi-machine' ),
      ),
      'content_wordcount' => array(
        'option_category' => 'configuration',
        'toggle_slug'     => 'main_content',
        'label'             => esc_html__( 'Content Word Count', 'divi-machine' ),
        'type'              => 'text',
        'computed_affects' => array(
          '__getpostcontent',
        ),
        'description'       => esc_html__( 'Input word count to show on this module.', 'divi-machine' ),
      ),
      'ul_type' => array(
        'label'             => esc_html__( 'Unordered List Style Type', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'options'           => array(
          'disc'    => esc_html__( 'Disc', 'divi-machine' ),
          'circle'  => esc_html__( 'Circle', 'divi-machine' ),
          'square'  => esc_html__( 'Square', 'divi-machine' ),
          'none'    => esc_html__( 'None', 'divi-machine' ),
        ),
        'priority'          => 80,
        'default'           => 'disc',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'text',
        'sub_toggle'        => 'ul',
      ),
      'ul_position' => array(
        'label'             => esc_html__( 'Unordered List Style Position', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'options'           => array(
          'outside' => esc_html__( 'Outside', 'divi-machine' ),
          'inside'  => esc_html__( 'Inside', 'divi-machine' ),
        ),
        'priority'          => 85,
        'default'           => 'outside',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'text',
        'sub_toggle'        => 'ul',
      ),
      'ul_item_indent' => array(
        'label'           => esc_html__( 'Unordered List Item Indent', 'divi-machine' ),
        'type'            => 'range',
        'option_category' => 'configuration',
        'tab_slug'        => 'advanced',
        'toggle_slug'     => 'text',
        'sub_toggle'      => 'ul',
        'priority'        => 90,
        'default'         => '0px',
        'range_settings'  => array(
          'min'  => '0',
          'max'  => '100',
          'step' => '1',
        ),
      ),
      'ol_type' => array(
        'label'             => esc_html__( 'Ordered List Style Type', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'options'           => array(
          'decimal'              => 'decimal',
          'armenian'             => 'armenian',
          'cjk-ideographic'      => 'cjk-ideographic',
          'decimal-leading-zero' => 'decimal-leading-zero',
          'georgian'             => 'georgian',
          'hebrew'               => 'hebrew',
          'hiragana'             => 'hiragana',
          'hiragana-iroha'       => 'hiragana-iroha',
          'katakana'             => 'katakana',
          'katakana-iroha'       => 'katakana-iroha',
          'lower-alpha'          => 'lower-alpha',
          'lower-greek'          => 'lower-greek',
          'lower-latin'          => 'lower-latin',
          'lower-roman'          => 'lower-roman',
          'upper-alpha'          => 'upper-alpha',
          'upper-greek'          => 'upper-greek',
          'upper-latin'          => 'upper-latin',
          'upper-roman'          => 'upper-roman',
          'none'                 => 'none',
        ),
        'priority'          => 80,
        'default'           => 'decimal',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'text',
        'sub_toggle'        => 'ol',
      ),
      'ol_position' => array(
        'label'             => esc_html__( 'Ordered List Style Position', 'divi-machine' ),
        'type'              => 'select',
        'option_category'   => 'configuration',
        'options'           => array(
          'outside' => esc_html__( 'Outside', 'divi-machine' ),
          'inside'  => esc_html__( 'Inside', 'divi-machine' ),
        ),
        'priority'          => 85,
        'default'           => 'outside',
        'tab_slug'          => 'advanced',
        'toggle_slug'       => 'text',
        'sub_toggle'        => 'ol',
      ),
      'ol_item_indent' => array(
        'label'           => esc_html__( 'Ordered List Item Indent', 'divi-machine' ),
        'type'            => 'range',
        'option_category' => 'configuration',
        'tab_slug'        => 'advanced',
        'toggle_slug'     => 'text',
        'sub_toggle'      => 'ol',
        'priority'        => 90,
        'default'         => '0px',
        'range_settings'  => array(
          'min'  => '0',
          'max'  => '100',
          'step' => '1',
        ),
      ),
      'quote_border_weight' => array(
        'label'           => esc_html__( 'Blockquote Border Weight', 'divi-machine' ),
        'type'            => 'range',
        'option_category' => 'configuration',
        'tab_slug'        => 'advanced',
        'toggle_slug'     => 'text',
        'sub_toggle'      => 'quote',
        'priority'        => 85,
        'default'         => '5px',
        'default_unit'    => 'px',
        'default_on_front' => '',
        'range_settings'  => array(
          'min'  => '0',
          'max'  => '100',
          'step' => '1',
        ),
      ),
      'quote_border_color' => array(
        'label'           => esc_html__( 'Blockquote Border Color', 'divi-machine' ),
        'type'            => 'color-alpha',
        'option_category' => 'configuration',
        'custom_color'    => true,
        'tab_slug'        => 'advanced',
        'toggle_slug'     => 'text',
        'sub_toggle'      => 'quote',
        'field_template'  => 'color',
        'priority'        => 90,
      ),
      '__getpostcontent' => array(
        'type' => 'computed',
        'computed_callback' => array( 'de_mach_content_code', 'get_post_content' ),
        'computed_depends_on' => array(
          'content_type',
        ),
      ),
    );

    return $fields;
  }

  public static function get_post_content ( $args = array(), $conditional_tags = array(), $current_page = array() ){
    if (!is_admin()) {
      return;
    }

    ob_start();

    $content_type = $args['content_type'];

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

          $is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
          if( $is_page_builder_used ) {
            $shop = "<div class='no-html-output'><p>We do not have support for when you use the Divi builder in the content yet.</p></div>";
            echo $shop;
          } else {
            if ($content_type == "excert") {
              the_excerpt();
            } else if ($content_type == 'category') {
              global $de_categoryloop_term;
              $description = $de_categoryloop_term->description;
              echo wp_kses_post($description);
            } else {
              the_content();
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

  public function get_search_items_content() {
    return $this->content;
  }

  private function countWords($text) {
    $words = preg_split("/[\n\r\t ]+/", $text, -1, PREG_SPLIT_NO_EMPTY);
    return count($words);
  }

  public function limit_text($html, $limit, $ellipsis = '...') {
    if($limit <= 0 || $limit >= $this->countWords(strip_tags($html)))
        return $html;

    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    
    $body = $dom->getElementsByTagName("body")->item(0);

    $it = new DOMWordsIterator($body);

    foreach($it as $word) {            
        if($it->key() >= $limit) {
            $currentWordPosition = $it->currentWordPosition();
            $curNode = $currentWordPosition[0];
            $offset = $currentWordPosition[1];
            $words = $currentWordPosition[2];
            
            $curNode->nodeValue = substr($curNode->nodeValue, 0, $words[$offset][1] + strlen($words[$offset][0]));
            
            $this->removeProceedingNodes($curNode, $body);
            $this->insertEllipsis($curNode, $ellipsis);
            break;
        }
    }

    return preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $dom->saveHTML());
  }

  private function removeProceedingNodes(DOMNode $domNode, DOMNode $topNode) {        
      $nextNode = $domNode->nextSibling;
      
      if($nextNode !== NULL) {
          $this->removeProceedingNodes($nextNode, $topNode);
          $domNode->parentNode->removeChild($nextNode);
      } else {
          //scan upwards till we find a sibling
          $curNode = $domNode->parentNode;
          while($curNode !== $topNode) {
              if($curNode->nextSibling !== NULL) {
                  $curNode = $curNode->nextSibling;
                  $this->removeProceedingNodes($curNode, $topNode);
                  $curNode->parentNode->removeChild($curNode);
                  break;
              }
              $curNode = $curNode->parentNode;
          }
      }
  }

  private function insertEllipsis(DOMNode $domNode, $ellipsis) {    
      $avoid = array('a', 'strong', 'em', 'h1', 'h2', 'h3', 'h4', 'h5'); //html tags to avoid appending the ellipsis to
      
      if( in_array($domNode->parentNode->nodeName, $avoid) && $domNode->parentNode->parentNode !== NULL) {
          // Append as text node to parent instead
          $textNode = new DOMText($ellipsis);
          
          if($domNode->parentNode->parentNode->nextSibling)
              $domNode->parentNode->parentNode->insertBefore($textNode, $domNode->parentNode->parentNode->nextSibling);
          else
              $domNode->parentNode->parentNode->appendChild($textNode);
      } else {
          // Append to current node
          $domNode->nodeValue = rtrim($domNode->nodeValue).$ellipsis;
      }
  }

  function render($attrs, $content, $render_slug){

    // if (is_admin()) {
    //     return;
    // }

    $ul_type              = $this->props['ul_type'];
    $ul_position          = $this->props['ul_position'];
    $ul_item_indent       = $this->props['ul_item_indent'];
    $ol_type              = $this->props['ol_type'];
    $ol_position          = $this->props['ol_position'];
    $ol_item_indent       = $this->props['ol_item_indent'];
    $quote_border_weight  = $this->props['quote_border_weight'];
    $quote_border_color   = $this->props['quote_border_color'];
    $content_wordcount    = !empty($this->props['content_wordcount'])?(int)$this->props['content_wordcount']:0;

    $content_type         = $this->props['content_type'];

    //////////////////////////////////////////////////////////////////////

    ob_start();

    if ($content_type == "excert") {
      the_excerpt();
    } else if ($content_type == 'category') {
      global $de_categoryloop_term;
      if (isset($de_categoryloop_term)) {
        $description = $de_categoryloop_term->description;
      } else {
        $term = get_queried_object();
        $description = $term->description;
      }
      echo wp_kses_post($description);
    } else {
      the_content();
    }

    $data = ob_get_clean();

    if ( $content_wordcount != 0 ){
      $data = $this->limit_text( $data, $content_wordcount );
    }



    //////////////////////////////////////////////////////////////////////

    if ( '' !== $ul_type || '' !== $ul_position || '' !== $ul_item_indent ) {
      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% ul',
        'declaration' => sprintf(
          '%1$s
          %2$s
          %3$s',
          '' !== $ul_type ? sprintf( 'list-style-type: %1$s !important;', esc_html( $ul_type ) ) : '',
          '' !== $ul_position ? sprintf( 'list-style-position: %1$s !important;', esc_html( $ul_position ) ) : '',
          '' !== $ul_item_indent ? sprintf( 'padding-left: %1$s !important;', esc_html( $ul_item_indent ) ) : ''
        ),
      ) );
    }

    if ( '' !== $ol_type || '' !== $ol_position || '' !== $ol_item_indent ) {
      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% ol',
        'declaration' => sprintf(
          '%1$s
          %2$s
          %3$s',
          '' !== $ol_type ? sprintf( 'list-style-type: %1$s !important;', esc_html( $ol_type ) ) : '',
          '' !== $ol_position ? sprintf( 'list-style-position: %1$s !important;', esc_html( $ol_position ) ) : '',
          '' !== $ol_item_indent ? sprintf( 'padding-left: %1$s !important;', esc_html( $ol_item_indent ) ) : ''
        ),
      ) );
    }

    if ( '' !== $quote_border_weight || '' !== $quote_border_color ) {
      ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => '%%order_class%% blockquote',
        'declaration' => sprintf(
          '%1$s
          %2$s',
          '' !== $quote_border_weight ? sprintf( 'border-width: %1$s;', esc_html( $quote_border_weight ) ) : '',
          '' !== $quote_border_color ? sprintf( 'border-color: %1$s;', esc_html( $quote_border_color ) ) : ''
        ),
      ) );
    }

    return $data;



  }

}

new de_mach_content_code;

?>
