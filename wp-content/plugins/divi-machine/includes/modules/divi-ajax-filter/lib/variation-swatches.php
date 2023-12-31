<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

if ( ! function_exists( 'bodycommerce_get_all_image_sizes' ) ):
  function bodycommerce_get_all_image_sizes() {
    return apply_filters( 'bodycommerce_get_all_image_sizes', array_reduce( get_intermediate_image_sizes(), function ( $carry, $item ) {
      $carry[ $item ] = ucwords( str_ireplace( array( '-', '_' ), ' ', $item ) );

      return $carry;
    }, array() ) );
  }
endif;



if ( ! function_exists( 'bodycommerce_available_attributes_types' ) ):
    function bodycommerce_available_attributes_types( $type = false ) {
        $types = array();

        $types[ 'color' ] = array(
            'title'   => esc_html__( 'Color', 'divi-bodyshop-woocommerce' ),
            'output'  => 'bodycommerce_color_variation_attribute_options',
            'preview' => 'bodycommerce_color_variation_attribute_preview'
        );

        $types[ 'image' ] = array(
            'title'   => esc_html__( 'Image', 'divi-bodyshop-woocommerce' ),
            'output'  => 'bodycommerce_image_variation_attribute_options',
            'preview' => 'bodycommerce_image_variation_attribute_preview'
        );

        $types[ 'button' ] = array(
            'title'   => esc_html__( 'Label', 'divi-bodyshop-woocommerce' ),
            'output'  => 'bodycommerce_button_variation_attribute_options',
            'preview' => 'bodycommerce_button_variation_attribute_preview'
        );

        if ( $type ) {
          return isset( $types[ $type ] ) ? $types[ $type ] : array();
        }

        return $types;
    }
endif;

if ( ! function_exists( 'bodycommerce_color_variation_attribute_preview' ) ):
  function bodycommerce_color_variation_attribute_preview( $term_id, $attribute, $fields ) {

    $key   = $fields[ 0 ][ 'id' ];
    $value = sanitize_hex_color( get_term_meta( $term_id, $key, TRUE ) );
    $color = get_term_meta( $term_id, 'product_attribute_color', TRUE );

    printf( '<div class="wvs-preview wvs-color-preview" style="width: 40px;height: 40px;background-color:%s;"></div>', esc_attr( $color ) );
  }
endif;


if ( ! function_exists( 'bodycommerce_image_variation_attribute_preview' ) ):
  function bodycommerce_image_variation_attribute_preview( $term_id, $attribute, $fields ) {

    $key           = $fields[ 0 ][ 'id' ];
    $attachment_id = absint( get_term_meta( $term_id, $key, TRUE ) );
    $image         = wp_get_attachment_image_url( $attachment_id );
   $image_url = get_term_meta( $term_id, 'product_attribute_image', TRUE );

    printf( '<img src="%s" class="wvs-preview wvs-image-preview" style="width: 40px;"/>', esc_attr( $image_url ) );
  }
endif;


if ( ! function_exists( 'bodycommerce_product_attributes_types' ) ):
  function bodycommerce_product_attributes_types( $selector ) {

    foreach ( bodycommerce_available_attributes_types() as $key => $options ) {
      $selector[ $key ] = $options[ 'title' ];
    }

    return $selector;
  }
endif;


if ( !function_exists( 'bodycommerce_get_available_product_variations' ) ) :
function bodycommerce_get_available_product_variations() {
		if ( is_ajax() && isset( $_GET[ 'product_id' ] ) ) {
			$product_id           = absint( $_GET[ 'product_id' ] );
			$product              = wc_get_product( $product_id );
			$available_variations = array_values( $product->get_available_variations() );

			wp_send_json_success( wp_json_encode( $available_variations ) );
		} else {
			wp_send_json_error();
		}
}
endif;


if ( ! function_exists( 'bodycommerce_taxonomy_meta_fields' ) ):
  function bodycommerce_taxonomy_meta_fields( $field_id = false ) {

    $fields = array();

    $fields[ 'color' ] = array(
      array(
        'label' => esc_html__( 'Color', 'divi-bodyshop-woocommerce' ), // <label>
        'desc'  => esc_html__( 'Enter in the color code', 'divi-bodyshop-woocommerce' ), // description
        'id'    => 'product_attribute_color', // name of field
        'type'  => 'color'
      )
    );

    $fields[ 'image' ] = array(
      array(
        'label' => esc_html__( 'Image', 'divi-bodyshop-woocommerce' ), // <label>
        'desc'  => esc_html__( 'Enter Image URL Here', 'divi-bodyshop-woocommerce' ), // description
        'id'    => 'product_attribute_image', // name of field
        'type'  => 'image'
      )
    );

    $fields = apply_filters( 'bodycommerce_product_taxonomy_meta_fields', $fields );

    if ( $field_id ) {
      return isset( $fields[ $field_id ] ) ? $fields[ $field_id ] : array();
    }

    return $fields;

  }
endif;

if ( ! function_exists( 'bodycommerce_is_color_attribute' ) ):
  function bodycommerce_is_color_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'color';
  }
endif;


if ( ! function_exists( 'bodycommerce_is_image_attribute' ) ):
  function bodycommerce_is_image_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'image';
  }
endif;

if ( ! function_exists( 'bodycommerce_is_button_attribute' ) ):
  function bodycommerce_is_button_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'button';
  }
endif;


if ( ! function_exists( 'bodycommerce_is_radio_attribute' ) ):
  function bodycommerce_is_radio_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'radio';
  }
endif;


if ( ! function_exists( 'bodycommerce_is_select_attribute' ) ):
  function bodycommerce_is_select_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'select';
  }
endif;

if ( ! function_exists( 'bodycommerce_get_product_attribute_color' ) ):
  function bodycommerce_get_product_attribute_color( $term ) {
    if ( ! is_object( $term ) ) {
      return false;
    }

    return get_term_meta( $term->term_id, 'product_attribute_color', TRUE );
  }
endif;


if ( ! function_exists( 'bodycommerce_get_product_attribute_image' ) ):
  function bodycommerce_get_product_attribute_image( $term ) {
    if ( ! is_object( $term ) ) {
      return false;
    }

    return get_term_meta( $term->term_id, 'product_attribute_image', TRUE );
  }
endif;


if ( ! function_exists( 'bodycommerce_add_product_taxonomy_meta' ) ) {
  function bodycommerce_add_product_taxonomy_meta() {

    $fields         = bodycommerce_taxonomy_meta_fields();
    $meta_added_for = apply_filters( 'bodycommerce_product_taxonomy_meta_for', array_keys( $fields ) );

    if ( function_exists( 'wc_get_attribute_taxonomies' ) ):

      $attribute_taxonomies = wc_get_attribute_taxonomies();
      if ( $attribute_taxonomies ) :
        foreach ( $attribute_taxonomies as $tax ) :
          $product_attr      = wc_attribute_taxonomy_name( $tax->attribute_name );
          $product_attr_type = $tax->attribute_type;
          if ( in_array( $product_attr_type, $meta_added_for ) ) :
            bodyc_commerce_add_term_meta( $product_attr, 'product', $fields[ $product_attr_type ] );

            do_action( 'bodycommerce_wc_attribute_taxonomy_meta_added', $product_attr, $product_attr_type );
          endif;
        endforeach;
      endif;
    endif;
  }
}


if ( ! function_exists( 'bodycommerce_product_option_terms' ) ) :
  function bodycommerce_product_option_terms( $attribute_taxonomy, $i ) {

			global $post, $thepostid, $product_object;
			if ( in_array( $attribute_taxonomy->attribute_type, array_keys( bodycommerce_available_attributes_types() ) ) ) {

				$taxonomy = wc_attribute_taxonomy_name( $attribute_taxonomy->attribute_name );

				$product_id = $thepostid;

				if ( is_null( $thepostid ) && isset( $_POST[ 'post_id' ] ) ) {
					$product_id = absint( $_POST[ 'post_id' ] );
				}

				$args = array(
					'orderby'    => 'name',
					'hide_empty' => 0,
				);

				?>
                <select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'divi-bodyshop-woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr( $i ); ?>][]">
					<?php
						$all_terms = get_terms( $taxonomy, apply_filters( 'woocommerce_product_attribute_terms', $args ) );
						if ( $all_terms ) :
							foreach ( $all_terms as $term ) :
								echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy, $product_id ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
							endforeach;
						endif;
					?>
                </select>
				<?php do_action( 'before_bodycommerce_product_option_terms_button', $attribute_taxonomy, $taxonomy ); ?>
                <button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'divi-bodyshop-woocommerce' ); ?></button>
                <button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'divi-bodyshop-woocommerce' ); ?></button>

				<?php
				$fields = bodycommerce_taxonomy_meta_fields( $attribute_taxonomy->attribute_type );

				if ( ! empty( $fields ) ): ?>
                    <button class="button fr plus bodycommerce_add_new_attribute" data-dialog_title="<?php printf( esc_html__( 'Add new %s', 'divi-bodyshop-woocommerce' ), esc_attr( $attribute_taxonomy->attribute_label ) ) ?>"><?php esc_html_e( 'Add new', 'divi-bodyshop-woocommerce' ); ?></button>
				<?php else: ?>
                    <button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'divi-bodyshop-woocommerce' ); ?></button>
				<?php endif; ?>
				<?php
				do_action( 'after_bodycommerce_product_option_terms_button', $attribute_taxonomy, $taxonomy, $product_id );
			}
		}
endif;

if ( ! function_exists( 'bodycommerce_get_wc_attribute_taxonomy' ) ):
  function bodycommerce_get_wc_attribute_taxonomy( $attribute_name ) {

    $transient = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', $attribute_name );

    if ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || isset( $_GET[ 'bodycommerce_clear_transient' ] ) ) {
      delete_transient( $transient );
    }

    if ( false === ( $attribute_taxonomy = get_transient( $transient ) ) ) {
      global $wpdb;

      $attribute_name     = str_replace( 'pa_', '', wc_sanitize_taxonomy_name( $attribute_name ) );
      $attribute_taxonomy = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name=%s", $attribute_name ) );
      set_transient( $transient, $attribute_taxonomy );
    }

    return apply_filters( 'bodycommerce_get_wc_attribute_taxonomy', $attribute_taxonomy, $attribute_name );
  }
endif;


add_action( 'woocommerce_attribute_updated', function ( $attribute_id, $attribute, $old_attribute_name ) {
  $transient     = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', wc_attribute_taxonomy_name( $attribute[ 'attribute_name' ] ) );
  $old_transient = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', wc_attribute_taxonomy_name( $old_attribute_name ) );
  delete_transient( $transient );
  delete_transient( $old_transient );
}, 20, 3 );

add_action( 'woocommerce_attribute_deleted', function ( $attribute_id, $attribute_name, $taxonomy ) {
  $transient = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', $taxonomy );
  delete_transient( $transient );
}, 20, 3 );

if ( ! function_exists( 'bodycommerce_wc_product_has_attribute_type' ) ):
  function bodycommerce_wc_product_has_attribute_type( $type, $attribute_name ) {
    $attribute = bodycommerce_get_wc_attribute_taxonomy( $attribute_name );

    return apply_filters( 'bodycommerce_wc_product_has_attribute_type', ( isset( $attribute->attribute_type ) && ( $attribute->attribute_type == $type ) ), $type, $attribute_name, $attribute );
  }
endif;

if ( ! function_exists( 'bodycommerce_variable_items_wrapper' ) ):
  function bodycommerce_variable_items_wrapper( $contents, $type, $args, $saved_attribute = array() ) {

    $attribute = $args[ 'attribute' ];

    $css_classes = apply_filters( 'bodycommerce_variable_items_wrapper_class', array( "{$type}-variable-wrapper" ), $type, $args, $saved_attribute );


    $data = sprintf( '<span class="active-option"></span><ul class="%s variable-items-wrapper %s" data-attribute_name="%s" data-attribute_name_title="%s">%s</ul>', esc_attr( wc_variation_attribute_name( $attribute ) ) , implode( ' ', $css_classes ), esc_attr( wc_variation_attribute_name( $attribute ) ), esc_attr( wc_attribute_label( $attribute ) ), $contents );

    return apply_filters( 'bodycommerce_variable_items_wrapper', $data, $contents, $type, $args, $saved_attribute );
  }
endif;

if ( ! function_exists( 'bodycommerce_variable_item' ) ):
  function bodycommerce_variable_item( $type, $options, $args, $saved_attribute = array() ) {

    $variation_label_width = 32;
    $variation_label_height = 32;

    $variation_image_width = 32;
    $variation_image_hieght = 32;

    $variation_color_width = 32;
    $variation_color_height = 32;

    $product   = $args[ 'product' ];
    $attribute = $args[ 'attribute' ];
    $data      = '';

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
        $name  = uniqid( wc_variation_attribute_name( $attribute ) );
        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'active-variation' : '';
            $tooltip        = trim( apply_filters( 'bodycommerce_color_variable_item_tooltip', $term->name, $term, $args ) );

            $tooltip_html_attr = ! empty( $tooltip ) ? sprintf( 'data-bc-swatch-tooltip="%s"', esc_attr( $tooltip ) ) : '';

            if ( wp_is_mobile() ) {
              $tooltip_html_attr .= ! empty( $tooltip ) ? ' tabindex="2"' : '';
            }


            switch ( $type ):
              case 'color':
              $data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s" style="width:%6$spx;height:%7$spx;">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ), $variation_color_width, $variation_color_height );


                 $color = get_term_meta( $term->term_id, 'product_attribute_color', TRUE );
                $data  .= sprintf( '<span class="variable-item-span variable-item-span-%s" style="background-color:%s;"></span>', esc_attr( $type ), esc_attr( $color ) );
                break;

              case 'image':
              $data .= sprintf( '<li %1$s class="variable-item image-variation %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s" style="width:%6$spx;height:%7$spx;">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ), $variation_image_width, $variation_image_hieght );

                 $image_url = get_term_meta( $term->term_id, 'product_attribute_image', TRUE );
                $data          .= sprintf( '<span></span><img class="bc-variation-image" alt="%s" src="%s" width="%s" height="%s" style="width:%spx;height:%spx;"/>', esc_attr( $term->name ), esc_attr( $image_url ), $variation_image_width, $variation_image_hieght, $variation_image_width, $variation_image_hieght );
                break;

              case 'button':
              $data .= sprintf( '<li %1$s class="variable-item label-variation %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s" style="width:%6$spx;height:%7$spx;line-height:%7$spx;">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ), $variation_label_width, $variation_label_height );

                $data .= sprintf( '<span class="variable-item-span variable-item-span-%s">%s</span>', esc_attr( $type ), esc_html( $term->name ) );
                break;

              case 'radio':
              $data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ) );

                $id   = uniqid( $term->slug );
                $data .= sprintf( '<input name="%1$s" id="%2$s" class="wvs-radio-variable-item" %3$s  type="radio" value="%4$s" data-value="%4$s" /><label for="%2$s">%5$s</label>', $name, $id, checked( sanitize_title( $args[ 'selected' ] ), $term->slug, false ), esc_attr( $term->slug ), esc_html( $term->name ) );
                break;

              default:
                $data .= apply_filters( 'bodycommerce_variable_default_item_content', '', $term, $args, $saved_attribute );
                break;
            endswitch;
            $data .= '</li>';
          }
        }
      }
    }

    return apply_filters( 'bodycommerce_variable_item', $data, $type, $options, $args, $saved_attribute );
  }
endif;


if ( ! function_exists( 'bodycommerce_color_variation_attribute_options' ) ) :
  function bodycommerce_color_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }

    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }

    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . esc_attr( $selected ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args ); 

  }
endif;


if ( ! function_exists( 'bodycommerce_image_variation_attribute_options' ) ) :
  function bodycommerce_image_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }


    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }


    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . esc_attr( $selected ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args );
  }
endif;

if ( ! function_exists( 'bodycommerce_button_variation_attribute_options' ) ) :
  function bodycommerce_button_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }

    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }

    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . esc_attr( $selected ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args );
  }
endif;


if ( ! function_exists( 'bodycommerce_radio_variation_attribute_options' ) ) :
  function bodycommerce_radio_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' );

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }

    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }

    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . esc_attr( $selected ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args );
  }
endif;

if ( ! function_exists( 'bodycommerce_variation_attribute_options_html' ) ):
  function bodycommerce_variation_attribute_options_html( $html, $args ) {

    ob_start();

    $available_type_keys = array_keys( bodycommerce_available_attributes_types() );
    $available_types     = bodycommerce_available_attributes_types();
    $default             = TRUE;

    foreach ( $available_type_keys as $type ) {
      if ( bodycommerce_wc_product_has_attribute_type( $type, $args[ 'attribute' ] ) ) {
        $output_callback = apply_filters( 'bodycommerce_variation_attribute_options_callback', $available_types[ $type ][ 'output' ], $available_types, $type, $args, $html );
        $output_callback( apply_filters( 'bodycommerce_variation_attribute_options_args', array(
          'options'    => $args[ 'options' ],
          'attribute'  => $args[ 'attribute' ],
          'product'    => $args[ 'product' ],
          'selected'   => $args[ 'selected' ],
          'type'       => $type,
          'is_archive' => ( isset( $args[ 'is_archive' ] ) && $args[ 'is_archive' ] )
        ) ) );
        $default = false;
      }
    }

    if ( $default ) {
      echo et_core_esc_previously( $html );
    }

    $data = ob_get_clean();

    return apply_filters( 'bodycommerce_variation_attribute_options_html', $data, $args );
  }
endif;

if ( !function_exists( 'add_bodycommerce_pro_preview_tab' ) ):
function add_bodycommerce_pro_preview_tab( $tabs ) {
  $tabs[ 'bodycommerce-variation-swatches-pro' ] = array(
    'label'    => esc_html__( 'Swatches Settings', 'divi-bodyshop-woocommerce' ),
    'target'   => 'wvs-pro-product-variable-swatches-options',
    'class'    => array( 'show_if_variable', 'variations_tab' ),
    'priority' => 65,
  );

  return $tabs;
}
endif;



if ( !function_exists( 'variant_swatches_footer' ) && class_exists( 'DEBC_INIT' ) ):
add_action('wp_footer', 'variant_swatches_footer');
function variant_swatches_footer(){

    $variation_swatch_active_colour = "fade";
  
    $variant_options = get_option( '_transient_wc_attribute_taxonomies' );

   ?>

<script>
jQuery(document).ready(function( $ ) {

  <?php if ($variation_swatch_active_colour == "fade") { ?>
    $(document).on('touchstart click', ".reset_variations", function (event) {
      $('.variable-items-wrapper').each(function (i, obj) {
        $(this).find("li.variable-item").css("opacity","0.3");
    });
  });
  <?php } ?>

    $(".variations select.bodycommerce-variation-raw-select").each(function(){
        var select_name = $(this).attr("data-attribute_name");
        var value = $(this).val();
<?php 
        if ($variation_swatch_active_colour == "fade") { 
?>
            $("."+select_name+" .variable-item").css("opacity","0.3");
            $(this).closest(".value").find(".variable-item[data-value='"+value+"']").addClass("active");
<?php 
        }
?>
    });
    $(".variable-item.outofstock").unbind("click");
        $(".reset_variations").click(function() {
            $(".variable-item").css("opacity","1");
        });
    });
</script>

<script>
jQuery(document).ready(function(a){
  a(document).on("click",".variable-item",function(){
    a(this).closest(".variations").find(".variable-item").addClass("outofstock"),
    a(this).closest(".variations_form").find(".variations select.bodycommerce-variation-raw-select option").each(function(){
      var e=a(this).val();
      a(this).closest(".variations_form").find(".variable-item[data-value='"+e+"']").removeClass("outofstock");
      if(a(this).hasClass("enabled"))
      var t="instock";
      // else t="outofstock";
      a(this).closest(".variations_form").find(".variable-item[data-value='"+e+"']").addClass(t)
    })
  })
});
</script>
<?php

}

endif;

add_action( 'wp_ajax_nopriv_bodycommerce_get_available_variations', 'bodycommerce_get_available_product_variations' );

add_action( 'wp_ajax_bodycommerce_get_available_variations', 'bodycommerce_get_available_product_variations' );

add_filter( 'product_attributes_type_selector', 'bodycommerce_product_attributes_types' );



add_action( 'admin_init', 'bodycommerce_add_product_taxonomy_meta' );

add_action( 'woocommerce_product_option_terms', 'bodycommerce_product_option_terms', 10, 2 );


//add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'bodycommerce_variation_attribute_options_html', 200, 2 );


if ( !function_exists( 'bodyc_commerce_add_term_meta' ) ):
function bodyc_commerce_add_term_meta( $taxonomy, $post_type, $fields ) {
	return new divifilter_Term_Meta( $taxonomy, $post_type, $fields );
}
endif;

if ( !function_exists( 'divifilter_admin_enqueue_scripts') && class_exists( 'DEBC_INIT' ) ):
add_action( 'admin_enqueue_scripts', 'divifilter_admin_enqueue_scripts'  );
function divifilter_admin_enqueue_scripts() {
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    
    wp_localize_script( 'bodycommerce-variation-swatches-admin', 'WVSPluginObject', array(
        'media_title'   => esc_html__( 'Enter Image URL Here', 'divi-bodyshop-woocommerce' ),
        'dialog_title'  => esc_html__( 'Add Attribute', 'divi-bodyshop-woocommerce' ),
        'dialog_save'   => esc_html__( 'Add', 'divi-bodyshop-woocommerce' ),
        'dialog_cancel' => esc_html__( 'Cancel', 'divi-bodyshop-woocommerce' ),
        'button_title'  => esc_html__( 'Use Image', 'divi-bodyshop-woocommerce' ),
        'add_media'     => esc_html__( 'Add Media', 'divi-bodyshop-woocommerce' ),
        'ajaxurl'       => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
        'nonce'         => wp_create_nonce( 'bodycommerce_plugin_nonce' ),
    ) );
}
endif;

if ( !function_exists( 'variant_swatches_header' ) && class_exists( 'DEBC_INIT' ) ):
add_action('wp_head', 'variant_swatches_header');
function variant_swatches_header(){
  ?>
  <style>
.et_pb_wc_add_to_cart form.cart .variations td.value span:after {
  display: none !important;
}
</style>
<?php
}
endif;