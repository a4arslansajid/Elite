<?php
if (!defined('ABSPATH')) exit;

function divi_filter_ajax_handler() {
    $divi_machine_options = maybe_unserialize(get_option('divi-machine_options'));

    global $wp_query, $wpdb, $post, $woocommerce, $address_filter_var, $price_filter_var, $wp_archive_query;

    $domain_name = '';

    $wc_product_attributes = array();

    if (defined('DE_DB_WOO_VERSION')) {
        $domain_name = 'divi-bodyshop-woocommerce';
    } else if (defined('DE_DMACH_VERSION')) {
        $domain_name = 'divi-machine';
    } else {
        $domain_name = 'divi-filter';
    }

    if (!check_ajax_referer('filter_object', 'security')) {
        wp_send_json_error('Nonce verification failed');
    }

    if (isset($_POST['query'])) {
        $args = json_decode(stripslashes($_POST['query']) , true);
    }

    ////
    if (isset($_POST['filter_item_id'])) {
        $filter_item_id = $_POST['filter_item_id'];
    }

    if (isset($_POST['filter_item_name'])) {
        $filter_item_name = $_POST['filter_item_name'];
    }

    if (isset($_POST['filter_item_name'])) {
        $filter_item_name = $_POST['filter_item_name'];
    }

    if (isset($_POST['filter_item_val'])) {
        $filter_item_val = $_POST['filter_item_val'];
    }

    if (isset($_POST['filter_input_type'])) {
        $filter_input_type = $_POST['filter_input_type'];
    }

    if(isset($filter_item_id)){
$filter_item_id_array = array_map('trim', explode(', ', $filter_item_id));
}
    if(isset($filter_item_name)){
$filter_item_name_array = array_map('trim', explode(', ', $filter_item_name));
}
    if(isset($filter_item_val)){
$filter_item_val_array = array_map('trim', explode(', ', $filter_item_val));
}
    if(isset($filter_input_type)){
$filter_input_type_array = array_map('trim', explode(', ', $filter_input_type));
}

    if(isset($filter_item_val_array)){
$filter_name_and_val_array = array_combine($filter_item_name_array, $filter_item_val_array);
}

    $all_filters_array = array_map(function ($filter_item_id_array, $filter_item_name_array, $filter_item_val_array, $filter_input_type_array) {
        return array_combine(['filter_item_id', 'filter_item_name', 'filter_item_val', 'filter_input_type'], [$filter_item_id_array, $filter_item_name_array, $filter_item_val_array, $filter_input_type_array]);
    }
    , $filter_item_id_array, $filter_item_name_array, $filter_item_val_array, $filter_input_type_array);

    $looptype = !empty($_POST['looptype']) ? $_POST['looptype'] : '';
    $get_saved_types = !empty($_POST['get_saved_types']) ? $_POST['get_saved_types'] : '';
    $layoutid = !empty($_POST['layoutid']) ? $_POST['layoutid'] : '';
    $noresults = !empty($_POST['noresults']) ? $_POST['noresults'] : '';
    $no_results_text = !empty($_POST['no_results_text']) ? $_POST['no_results_text'] : '';
    $current_page = !empty($_POST['current_page']) ? $_POST['current_page'] : '';

    $args['paged'] = $current_page;
    $sortorder = !empty($_POST['sortorder']) ? $_POST['sortorder'] : '';
    $sortasc = !empty($_POST['sortasc']) ? $_POST['sortasc'] : '';
    $orderby_param = !empty($_POST['orderby_param']) ? $_POST['orderby_param'] : '';
    $columnscount = !empty($_POST['columnscount']) ? $_POST['columnscount'] : '';
    $link_whole_gird = !empty($_POST['link_wholegrid']) ? $_POST['link_wholegrid'] : '';
    $link_wholegrid_external = !empty($_POST['link_wholegrid_external']) ? $_POST['link_wholegrid_external'] : '';
    $link_wholegrid_external_acf = !empty($_POST['link_wholegrid_external_acf']) ? $_POST['link_wholegrid_external_acf'] : '';

    $loadmore = !empty($_POST['loadmore']) ? $_POST['loadmore'] : 'off';
    $gridstyle = !empty($_POST['gridstyle']) ? $_POST['gridstyle'] : 'grid';
    $loadmoretext = !empty($_POST['loadmoretext']) ? $_POST['loadmoretext'] : '';
    $loadmoretextloading = !empty($_POST['loadmoretextloading']) ? $_POST['loadmoretextloading'] : '';
    $loadmore_icon = !empty($_POST['loadmore_icon']) ? $_POST['loadmore_icon'] : '';
    $resultcount = !empty($_POST['resultcount']) ? $_POST['resultcount'] : 'on';
    $countposition = !empty($_POST['countposition']) ? $_POST['countposition'] : 'left';
    $result_count_single_text = !empty($_POST['result_count_single_text']) ? $_POST['result_count_single_text'] : 'Showing the single result';
    $result_count_all_text = !empty($_POST['result_count_all_text']) ? $_POST['result_count_all_text'] : 'Showing all %d results';
    $result_count_pagination_text = !empty($_POST['result_count_pagination_text']) ? $_POST['result_count_pagination_text'] : 'Showing %d-%d of %d results';

    $postnumber = !empty($_POST['postnumber']) ? $_POST['postnumber'] : $args['posts_per_page'];
    $include_cats = !empty($_POST['include_cats']) ? $_POST['include_cats'] : '';
    $include_tags = !empty($_POST['include_tags']) ? $_POST['include_tags'] : '';
    $include_taxomony = !empty($_POST['include_taxomony']) ? $_POST['include_taxomony'] : '';
    $include_term = !empty($_POST['include_term']) ? $_POST['include_term'] : '';

    $exclude_cats = !empty($_POST['exclude_cats']) ? $_POST['exclude_cats'] : '';

    $has_map = !empty($_POST['has_map']) ? $_POST['has_map'] : '';
    $map_all_posts = !empty($_POST['map_all_posts']) ? $_POST['map_all_posts'] : 'off';
    $map_selector = !empty($_POST['map_selector']) ? $_POST['map_selector'] : '';
    $marker_layout = !empty($_POST['marker_layout']) ? $_POST['marker_layout'] : '';
    $hide_non_purchasable = !empty($_POST['hide_non_purchasable']) ? $_POST['hide_non_purchasable'] : '';
    $show_hidden_prod = !empty($_POST['show_hidden_prod']) ? $_POST['show_hidden_prod'] : '';

    $sorttype = isset($_POST['sorttype']) ? $_POST['sorttype'] : '';

    $posttax = isset($_POST['posttax']) ? $_POST['posttax'] : '';
    $postterm = isset($_POST['postterm']) ? $_POST['postterm'] : '';
    $category_currently_in = isset($_POST['category_currently_in']) ? $_POST['category_currently_in'] : '';
    $current_custom_category = isset($_POST['current_custom_category']) ? $_POST['current_custom_category'] : '';
    $current_custom_category_terms = isset($_POST['current_custom_category_terms']) ? $_POST['current_custom_category_terms'] : '';
    $current_author = isset($_POST['current_author']) ? $_POST['current_author'] : '';
    $current_loop_taxonomy = isset($_POST['current_loop_taxonomy']) ? $_POST['current_loop_taxonomy'] : '';
    $current_loop_taxterm = isset($_POST['current_loop_taxterm']) ? $_POST['current_loop_taxterm'] : '';

    $dmach_map_acf = !empty($divi_machine_options['dmach_map_acf']) ? $divi_machine_options['dmach_map_acf'] : '';
    $dmach_post_type = !empty($divi_machine_options['dmach_post_type']) ? $divi_machine_options['dmach_post_type'] : '';
    $dmach_post_type_custom = !empty($divi_machine_options['dmach_post_type_custom'])?$divi_machine_options['dmach_post_type_custom']:'';

    if ($dmach_post_type_custom !== "") {
      $dmach_post_type = $dmach_post_type_custom;
    }

    $acf_map_lat = isset($_POST['acf_map_lat']) ? $_POST['acf_map_lat'] : '';
    $acf_map_lng = isset($_POST['acf_map_lng']) ? $_POST['acf_map_lng'] : '';
    $acf_map_radius = isset($_POST['acf_map_radius']) ? $_POST['acf_map_radius'] : '';
    $acf_map_radius_type = isset($_POST['acf_map_radius_type']) ? $_POST['acf_map_radius_type'] : '';
    $acf_map_field = isset($_POST['acf_map_field']) ? $_POST['acf_map_field'] : '';

    $ul_classes = !empty($_POST['ul_classes']) ? $_POST['ul_classes'] : '';

    $filter_has_current_tax_term = !empty($_POST['filter_has_current_tax_term']) ? $_POST['filter_has_current_tax_term'] : 'false';

    $onload_cats = !empty($_POST['onload_cats']) ? $_POST['onload_cats'] : '';
    $onload_tags = !empty($_POST['onload_tags']) ? $_POST['onload_tags'] : '';
    $onload_taxomony = !empty($_POST['onload_taxomony']) ? $_POST['onload_taxomony'] : '';
    $onload_terms = !empty($_POST['onload_terms']) ? $_POST['onload_terms'] : '';

    $meta_query = array('relation' => 'AND');
    $tax_query = array('relation' => 'AND');

    $args_url_acf = [];

    $posttype = $args['post_type'];

    $args['posts_per_page'] = $postnumber;

    $args['relevanssi'] = "true";  // This is for relevanssi search, i.e. Synonym search

    if ( !is_array($posttype) )  {
        $posttype = array( $posttype );
    }

    $post_taxonomies = get_object_taxonomies($posttype);

    // FiboSearch Compatibility
    if ( !empty( $args['s'] ) && !empty( $args['dgwt_wcas'] ) && ( $args['s'] == $args['dgwt_wcas'] ) ) {
        add_filter('dgwt/wcas/helpers/is_search_query', function( $enabled, $query){
            return true;
        }, 135, 2 );
    }

    $current_loop_taxonomy_in_request = false;

    if (!isset($args['tax_query'])) {
        $args['tax_query'] = array();
    }

    if (!isset($args['meta_query'])) {
        $args['meta_query'] = array();
    }

    $stock_status = '';

    if (!empty($filter_item_name_array)) {
        foreach ($filter_item_name_array as $filter_name) {

            // IF OUR CATEGORY
            if (in_array($filter_name, $post_taxonomies)) {
                foreach ($args['tax_query'] as $key => $meta) {
                    if (is_array($meta) && !empty($meta['taxonomy']) && ($filter_name == $meta['taxonomy'])) {
                        unset($args['tax_query'][$key]);
                    } else if (is_array($meta)) {
                        foreach ($meta as $subkey => $subMeta) {
                            if (is_array($subMeta) && !empty($subMeta['taxonomy']) && ($filter_name == $subMeta['taxonomy'])) {
                                unset($args['tax_query'][$key]);
                            }
                        }
                    }
                }

                if ($filter_name == "category") {
                    unset($args['category_name']);
                    unset($args['cat']);
                }

                if ($filter_name == "post_tag") {
                    unset($args['tag']);
                    unset($args['tag_id']);
                    unset($args['tag_slug__in']);
                }

                if (!empty($args['taxonomy']) && ($args['taxonomy'] == $filter_name)) {
                    unset($args['taxonomy']);
                    unset($args['term']);
                }

                if (!empty($args[$filter_name])) {
                    unset($args[$filter_name]);
                }

                if (($posttype == 'product' || $posttype == 'product_variation') && $filter_name == 'product_cat') {
                    unset($args['product_cat']);
                }

                if ($filter_has_current_tax_term == 'true') {
                    $current_loop_taxonomy_in_request = true;
                }
            }

            if ($filter_name == 'product_price') {
                //$args['post__in'] = array();
            } else {
                // IF SEARCH TEXT
                if ($filter_name == "s") {
                    unset($args['s']);
                    // IF POST CATEGORY

                } else if ($filter_name == "category") {
                    unset($args['category_name']);
                    unset($args['cat']);
                    foreach ($args['meta_query'] as $key => $meta) {
                        if (is_array($meta) && !empty($meta['key']) && ($filter_name == $meta['key'])) {
                            unset($args['meta_query'][$key]);
                        } else if (is_array($meta)) {
                            foreach ($meta as $subkey => $subMeta) {
                                if (is_array($subMeta) && !empty($subMeta['key']) && ($filter_name == $subMeta['key'])) {
                                    unset($args['meta_query'][$key]);
                                }
                            }
                        }
                    }
                    // ELSE ACF OR CUSTOM TAX

                } else {
                    if ($filter_name == 'product_weight') {
                        $filter_name = '_weight';
                    }
                    if ($filter_name == 'product_rating') {
                        $filter_name = '_wc_average_rating';
                    }
                    if ( $filter_name == 'stock_status' ) {
                        $filter_name = '_stock_status';
                    }
                    foreach ($args['meta_query'] as $key => $meta) {
                        if (is_array($meta) && !empty($meta['key']) && ($filter_name == $meta['key'])) {
                            unset($args['meta_query'][$key]);
                        } else if (is_array($meta)) {
                            foreach ($meta as $subkey => $subMeta) {
                                if (is_array($subMeta) && !empty($subMeta['key']) && ($filter_name == $subMeta['key'])) {
                                    unset($args['meta_query'][$key]);
                                }
                            }
                        }
                    }

                    foreach ($args['tax_query'] as $key => $meta) {
                        if (is_array($meta) && !empty($meta['taxonomy']) && ($filter_name == $meta['taxonomy'])) {
                            unset($args['tax_query'][$key]);
                        } else if (is_array($meta)) {
                            foreach ($meta as $subkey => $subMeta) {
                                if (is_array($subMeta) && !empty($subMeta['taxonomy']) && ($filter_name == $subMeta['taxonomy'])) {
                                    unset($args['tax_query'][$key]);
                                }
                            }
                        }
                    }

                    if (!empty($args['taxonomy']) && ($args['taxonomy'] == $filter_name)) {
                        unset($args['taxonomy']);
                        unset($args['term']);
                    }
                }
            }
        }
    }

    $product_price_val = '';

    $post_cat_array = [];

    foreach ($posttype as $index => $post_type) {
        if ($post_type != 'post') {
            if ($post_type == 'product') {
                $post_cat_array[] = 'product_cat';
            } else if ( $post_type != 'product_variation' ){
                $post_cat_array[] = $post_type . '_category';
            }
        } else {
            $post_cat_array[] = 'category';
        }
    }

    if ( in_array('product', $posttype) && function_exists( 'wc_get_attribute_taxonomies' ) ) {
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        if ( $attribute_taxonomies ) {
            foreach ( $attribute_taxonomies as $tax ) {
                $wc_product_attributes[]  = 'pa_' . $tax->attribute_name;
            }
        }
    }

    $current_product_attributes = array();

    if (isset($_POST['data_fields'])) {
        foreach ($_POST['data_fields'] as $items) {
            foreach ($items as $item) {
                foreach ($item as $key => $value) {
                    $value['val'] = stripslashes(urldecode( $value['val'] ));

                    if ($filter_has_current_tax_term == 'true') {
                        $current_loop_taxonomy_in_request = true;
                    }
                    if (isset($value['val']) && $value['val'] != "") {
                        // IF OUR CATEGORY
                        if (substr($value['name'], -9) == '_category' && in_array($value['name'], $post_cat_array) && in_array($value['name'], $post_taxonomies)) {

                            if ($value['val'] != 'all') {
                                $cat_show = $value['val'];
                            } else {
                                $cat_show = "all";
                            }
                            // IF OUR TAG

                        } else if (substr($value['name'], -4) == '_tag' && in_array($value['name'], $post_taxonomies)) {

                            if ($value['name'] == "post_tag") {
                                if ($value['val'] != 'all') {
                                    $post_tag_show = $value['val'];
                                } else {
                                    $post_tag_show = "all";
                                }
                            } else {
                                if ($value['val'] != 'all') {
                                    $cus_tag_show = $value['val'];
                                } else {
                                    $cus_tag_show = "all";
                                }
                            }
                        } else if (in_array($value['name'], $post_taxonomies)) {

                            if ( in_array( $value['name'], $wc_product_attributes ) ) {
                                $current_product_attributes[] = array( 'attr_name' => $value['name'], 'attr_val' => $value['val'] );
                            }

                            foreach ($args['tax_query'] as $key => $meta) {
                                if (is_array($meta) && !empty($meta['taxonomy']) && ($value['name'] == $meta['taxonomy'])) {
                                    unset($args['tax_query'][$key]);
                                } else if (is_array($meta)) {
                                    foreach ($meta as $subkey => $subMeta) {
                                        if (is_array($subMeta) && !empty($subMeta['taxonomy']) && ($value['name'] == $subMeta['taxonomy'])) {
                                            unset($args['tax_query'][$key]);
                                        }
                                    }
                                }
                            }

                            if ($value['type'] == 'range') {
                                $range_value = (explode(";", $value['val']));

                                if (count($range_value) == 1) {
                                    $term_value = $range_value[0];
                                    if ($value['val_type'] == 'decimal') {
                                        $term_value = str_replace('.', '-', strval($range_value[0]));
                                    }
                                    $tax_query[] = array(
                                        'taxonomy' => $value['name'],
                                        'field' => 'slug',
                                        'terms' => $term_value,
                                    );
                                }else{
                                    if ( $value['val_type'] == 'decimal' ) {
                                        $terms = get_terms( array( 'taxonomy' => $value['name'], 'hide_empty' => true ) );
                                        $term_id_array = array();
                                        foreach ($terms as $term) {
                                            $term_slug = floatval(str_replace('-', '.', $term->slug));
                                            if ($term_slug >= $range_value[0] && $term_slug <= $range_value[1]) {
                                                $term_id_array[] = $term->term_id;
                                            }
                                        }
                                        $tax_query[] = array(
                                            'taxonomy' => $value['name'],
                                            'field' => 'term_id',
                                            'terms' => $term_id_array,
                                            'operator' => 'IN'
                                        );
                                    } else {
                                        $tax_query[] = array(
                                            'taxonomy' => $value['name'],
                                            'field' => 'slug',
                                            'terms' => range($range_value[0], $range_value[1]) ,
                                            'operator' => 'IN'
                                        );
                                    }
                                }
                            } else {
                                if ($value['val'] != "all") {
                                    $val_and_array = explode('|', $value['val']);
                                    if (is_array($val_and_array) && count($val_and_array) > 1) {
                                        $sub_tax_query = array(
                                            'relation' => 'AND'
                                        );
                                        foreach ($val_and_array as $key => $or_value) {
                                            $sub_tax_query[] = array(
                                                'taxonomy' => $value['name'],
                                                'field' => 'slug',
                                                'terms' => explode(',', $or_value) ,
                                                'operator' => 'IN'
                                            );
                                        }
                                        $tax_query[] = $sub_tax_query;
                                    } else {
                                        $tax_query[] = array(
                                            'taxonomy' => $value['name'],
                                            'field' => 'slug',
                                            'terms' => explode(',', $value['val']) ,
                                            'operator' => 'IN'
                                        );
                                    }
                                }
                            }

                            // ELSE EVERYTHING ELSE

                        } else if ($value['name'] == 'product_price') {

                            $product_price_val = $value['val'];
                            global $wpdb;

                            $price_value = (explode(';', $value['val']));

                            if (count($price_value) == 1) {
                                $min_filter_price = 0;
                                $max_filter_price = floatval($price_value[0]);
                            } else {
                                $max_filter_price = floatval($price_value[1]);
                                $min_filter_price = floatval($price_value[0]);
                            }

                            if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
                                $tax_class = apply_filters('woocommerce_price_filter_widget_tax_class', ''); // Uses standard tax class.
                                $tax_rates = WC_Tax::get_rates($tax_class);

                                if ($tax_rates) {
                                    $min_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($min_filter_price, $tax_rates));
                                    $max_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($max_filter_price, $tax_rates));
                                }
                            }

                            $price_filter_var['is_filter'] = true;
                            $price_filter_var['min_price'] = $min_filter_price;
                            $price_filter_var['max_price'] = $max_filter_price;

                        } else {
                            // IF SEARCH TEXT
                            if ($value['name'] == "s") {
                                $search_keyword = $value['val'];
                                // IF POST CATEGORY

                            } else {
                                // IF TYPE IS RADIO OR CHECKBOX
                                if ($value['type'] == "radio" || $value['type'] == "checkbox") {

                                    if ($value['name'] == 'product_rating') {
                                        $value['name'] = '_wc_average_rating';
                                    }

                                    if ($value['name'] == 'stock_status') {
                                        $value['name'] = '_stock_status';
                                        $stock_status = $value['val'];
                                    }

                                    $val_array = explode(',', $value['val']);

                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if (is_array($meta) && !empty($meta['key']) && ($value['name'] == $meta['key'])) {
                                            unset($args['meta_query'][$key]);
                                        } else if (is_array($meta)) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if (is_array($subMeta) && !empty($subMeta['key']) && ($value['name'] == $subMeta['key'])) {
                                                    unset($args['meta_query'][$key]);
                                                }
                                            }
                                        }
                                    }

                                    if ($value['name'] == '_wc_average_rating') {
                                        if (is_array($val_array) && count($val_array) > 1) {
                                            $rating_query = array( 'relation' => 'OR' );
                                            foreach ($val_array as $key => $p_rating) {
                                                if ($p_rating == 0) {
                                                    $rating_query[] = array(
                                                        'key' => '_wc_average_rating',
                                                        'value' => $p_rating,
                                                    );
                                                } else {
                                                    $rating_query[] = array(
                                                        'key' => '_wc_average_rating',
                                                        'value' => array( $p_rating - 1, (int)$p_rating ),
                                                        'type' => 'DECIMAL(10,3)',
                                                        'compare' => 'BETWEEN',
                                                    );
                                                }
                                            }
                                            $meta_query[] = $rating_query;
                                        } else {
                                            if ($val_array[0] == 0) {
                                                $meta_query[] = array(
                                                    'key' => '_wc_average_rating',
                                                    'value' => $val_array[0],
                                                );
                                            } else {
                                                $meta_query[] = array(
                                                    'key' => '_wc_average_rating',
                                                    'value' => array( $val_array[0] - 1, (int)$val_array[0] ),
                                                    'type' => 'DECIMAL(10,3)',
                                                    'compare' => 'BETWEEN'
                                                );
                                            }
                                        }
                                    } else {
                                        $type = '';
                                        //if ( $value['val_type'] != 'string' ){
                                        //    $type = strtoupper( $value['val_type']);
                                        //}else{
                                        $type = 'CHAR';
                                        //}
                                        if ($value['acf_type'] == 'checkbox' || $value['acf_type'] == 'post_object') {

                                            $val_and_array = explode('|', $value['val']);

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
                                                                'key' => $value['name'],
                                                                'value' => '"' . $meta_val . '"',
                                                                'type' => $type,
                                                                'compare' => 'LIKE',
                                                            );
                                                        }
                                                        $query_arr[] = $query_sub_arr;
                                                    } else {
                                                        $query_arr[] = array(
                                                            'key' => $value['name'],
                                                            'value' => '"' . $or_value . '"',
                                                            'type' => $type,
                                                            'compare' => 'LIKE',
                                                        );
                                                    }
                                                }
                                                $meta_query[] = $query_arr;
                                            } else {
                                                $val_array = explode( ',', $value['val'] );
                                                if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                                    $query_arr = array( 'relation' => 'OR' );
                                                    foreach ( $val_array as $meta_val ) {
                                                        $query_arr[] = array(
                                                            'key' => $value['name'],
                                                            'value' => '"' . $meta_val . '"',
                                                            'type' => $type,
                                                            'compare' => 'LIKE',
                                                        );
                                                    }
                                                    $meta_query[] = $query_arr;
                                                } else {
                                                    $meta_query[] = array(
                                                        'key' => $value['name'],
                                                        'value' => '"' . $value['val'] . '"',
                                                        'type' => $type,
                                                        'compare' => 'LIKE',
                                                    );
                                                }
                                            }
                                        } else {
                                            if (is_array($val_array) && count($val_array) > 1) {
                                                $meta_query[] = array(
                                                    'key' => $value['name'],
                                                    'value' => $val_array,
                                                    'type' => $type,
                                                    'compare' => 'IN',
                                                );
                                            } else {
                                                $meta_query[] = array(
                                                    'key' => $value['name'],
                                                    'value' => $value['val'],
                                                    'type' => $type,
                                                );
                                            }
                                        }
                                    }
                                    // IF TYPE IS RANGE

                                } else if ($value['type'] == "range") {

                                    if ($value['name'] == 'product_weight') {
                                        $value['name'] = '_weight';
                                    } else if ($value['name'] == 'product_rating') {
                                        $value['name'] = '_wc_average_rating';
                                    }

                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if (is_array($meta) && !empty($meta['key']) && ($value['name'] == $meta['key'])) {
                                            unset($args['meta_query'][$key]);
                                        } else if (is_array($meta)) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if (is_array($subMeta) && !empty($subMeta['key']) && ($value['name'] == $subMeta['key'])) {
                                                    unset($args['meta_query'][$key]);
                                                }
                                            }
                                        }
                                    }

                                    $range_value = (explode(";",$value['val']));

                                    if ( in_array($value['acf_type'], array("checkbox", "radio", "select") ) ) {
                                        if ( function_exists('acf_get_field_groups' ) ) {
                                            foreach( $posttype as $post_type ) {
                                                $groups = acf_get_field_groups(array('post_type' => $post_type ) );
                                                if ( !empty( $groups ) ) {
                                                    foreach ( $groups as $field_group) {
                                                        $fields = acf_get_fields($field_group);
                                                        foreach ($fields as $field) {
                                                            if ( $field['name'] == $value['name'] ) {
                                                                $acf_object = $field;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if ( !empty( $acf_object ) ) {

                                                $is_multiple = false;

                                                if ( $acf_object['type'] == 'checkbox' || ($acf_object['type'] == 'select' && $acf_object['multiple'] == 1 ) ) {
                                                    $is_multiple = true;
                                                }
                                                if ( sizeof( $range_value ) == 1 ){
                                                    foreach( $acf_object['choices'] as $choice_val => $choice_label ) {
                                                        if ( floatval($choice_val) == floatval($value['val'] ) ) {
                                                            if ( $is_multiple ) {
                                                                $meta_query[] = array(
                                                                    'key' => $value['name'],
                                                                    'value' => '"' . $choice_val . '"',
                                                                    'type'  => 'CHAR',
                                                                    'compare' => 'LIKE'
                                                                );
                                                            } else {
                                                                $meta_query[] = array(
                                                                    'key' => $value['name'],
                                                                    'value' => $choice_val,
                                                                    'type'  => 'DECIMAL(10,3)',
                                                                    'compare' => '='
                                                                );
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    if ( $is_multiple ) {
                                                        $sub_query = array();
                                                        foreach( $acf_object['choices'] as $choice_val => $choice_label ) {
                                                            if ( ( floatval($choice_val) >= floatval($range_value[0] ) )
                                                                    && ( floatval($choice_val) <= floatval($range_value[1] ) ) ) {
                                                                $sub_query[] = array(
                                                                    'key' => $value['name'],
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
                                                                'key' => $value['name'],
                                                                'value' => null,
                                                                'compare' => 'IN'
                                                            );
                                                        }
                                                    } else {
                                                        $meta_query[] = array(
                                                            'key' => $value['name'],
                                                            'value' => $range_value,
                                                            'compare' => 'BETWEEN',
                                                            'type' => 'DECIMAL(10,3)'
                                                        );
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                    $type = '';
                                    if ($value['val_type'] != 'string') {
                                        $type = strtoupper($value['val_type']);
                                        if ($type == 'DECIMAL') {
                                            $type = 'DECIMAL(10,3)';
                                        }
                                    } else {
                                        $type = 'CHAR';
                                    }

                                    if ($value['name'] == '_weight' || $value['name'] == '_wc_average_rating') {
                                        $type = 'DECIMAL';
                                    }

                                        if ( $value['name'] == '_wc_average_rating' ) {
                                            if ( count( $range_value ) == 1 ){
                                                if ( $range_value[0] == 0 ) {
                                                $meta_query[] = array(
                                                    'key' => '_wc_average_rating',
                                                    'value' => $range_value[0],
                                                );
                                            } else {
                                                $meta_query[] = array(
                                                    'key' => '_wc_average_rating',
                                                        'value' => array( $range_value[0] - 1, (int)$range_value[0] ),
                                                    'type' => 'DECIMAL',
                                                    'compare' => 'BETWEEN'
                                                );
                                            }
                                        } else {
                                            $meta_query[] = array(
                                                'key' => '_wc_average_rating',
                                                'value' => $range_value,
                                                'compare' => 'BETWEEN',
                                                'type' => 'DECIMAL'
                                            );
                                        }
                                    } else {
                                        if (count($range_value) == 1) {
                                            $meta_query[] = array(
                                                'key' => $value['name'],
                                                'value' => $range_value[0],
                                                'type' => $type,
                                                'compare' => '<='
                                            );
                                        } else {
                                            $meta_query[] = array(
                                                'key' => $value['name'],
                                                'value' => $range_value,
                                                'compare' => 'BETWEEN',
                                                'type' => $type
                                            );
                                        }
                                    }
                                    }

                                    // IF TYPE is CUSTOM TAXONOMY

                                } else if ($value['type'] == "customtaxonomy") {

                                    foreach ($args['tax_query'] as $key => $meta) {
                                        if (is_array($meta) && !empty($meta['taxonomy']) && ($value['name'] == $meta['taxonomy'])) {
                                            unset($args['tax_query'][$key]);
                                        } else if (is_array($meta)) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if (is_array($subMeta) && !empty($subMeta['taxonomy']) && ($value['name'] == $subMeta['taxonomy'])) {
                                                    unset($args['tax_query'][$key]);
                                                }
                                            }
                                        }
                                    }

                                    $tax_query[] = array(
                                        'taxonomy' => $value['name'],
                                        'field' => 'slug',
                                        'terms' => explode(',', $value['val']) ,
                                        'operator' => 'IN'
                                    );
                                    // IF TYPE is MULTIPLE SELECT

                                } else if ($value['type'] == "acfselectmulitple") {
                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if (is_array($meta) && !empty($meta['key']) && ($value['name'] == $meta['key'])) {
                                            unset($args['meta_query'][$key]);
                                        } else if (is_array($meta)) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if (is_array($subMeta) && !empty($subMeta['key']) && ($value['name'] == $subMeta['key'])) {
                                                    unset($args['meta_query'][$key]);
                                                }
                                            }
                                        }
                                    }

                                    $type = '';
                                    if ($value['val_type'] != 'string') {
                                        $type = strtoupper($value['val_type']);
                                    } else {
                                        $type = 'CHAR';
                                    }

                                    $meta_query[] = array(
                                        'key' => $value['name'],
                                        'value' => '"' . $value['val'] . '"',
                                        'type' => $type,
                                        'compare' => 'LIKE'
                                    );
                                    // ELSE REST

                                } else if ($value['type'] == "map_address") {

                                    $address = str_replace(" ", "+", $value['val']);

                                    if ($acf_map_lat == '' && $acf_map_lng == '') {
                                        $et_google_api_settings = get_option('et_google_api_settings');
                                        if (isset($et_google_api_settings['api_key'])) {
                                            $key = $et_google_api_settings['api_key'];
                                            $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=" . $key);
                                            $json = json_decode($json);

                                            $acf_map_lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                                            $acf_map_lng = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                                        }
                                    }

                                    if ($acf_map_lat != '' && $acf_map_lng != '' && $acf_map_radius != '' && $acf_map_radius_type != '') {
                                        $address_filter_var['is_filter'] = true;
                                        $address_filter_var['lat'] = $acf_map_lat;
                                        $address_filter_var['lng'] = $acf_map_lng;
                                        $address_filter_var['radius'] = $acf_map_radius;
                                        $address_filter_var['radius_unit'] = $acf_map_radius_type;
                                        $address_filter_var['address_field'] = $acf_map_field;
                                    }
                                } else if ($value['type'] == "map_radius") {
                                } else {

                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if (is_array($meta) && !empty($meta['key']) && ($value['name'] == $meta['key'])) {
                                            unset($args['meta_query'][$key]);
                                        } else if (is_array($meta)) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if (is_array($subMeta) && !empty($subMeta['key']) && ($value['name'] == $subMeta['key'])) {
                                                    unset($args['meta_query'][$key]);
                                                }
                                            }
                                        }
                                    }

                                    $type = '';
                                    if ($value['val_type'] != 'string') {
                                        $type = strtoupper($value['val_type']);
                                    } else {
                                        $type = 'CHAR';
                                    }

                                    $meta_query[] = array(
                                        'key' => $value['name'],
                                        'value' => $value['val'],
                                        'type' => $type,
                                    );
                                }

                                $args_url_acf[$value['name']] = $value['val'];
                            }
                        }
                    }
                }
            }
        }
    }

    if ($include_cats != "" && count($posttype) != 0) {
        $include_cats_arr = explode(',', $include_cats);
        $cat_tax_query = array(
            'relation' => 'OR'
        );

        if (count($posttype) > 1) {
            foreach ($posttype as $index => $post_type) {
                $cat_key = 'category';
                if ($post_type != 'post') {
                    $ending = "_category";
                    $cat_key = $post_type . $ending;
                    if ($cat_key == "product_category") {
                        $cat_key = "product_cat";
                    }
                }

                if ( $post_type != 'product_variation' ) {
                    $cat_tax_query[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => $include_cats_arr,
                        'operator' => 'IN'
                    );
                }
            }
            $args['tax_query'][] = $cat_tax_query;
        } else {
            if (in_array("post", $posttype)) {
                $args['category_name'] = $include_cats;
            } else {

                if (!empty($post_taxonomies) && in_array('category', $post_taxonomies)) {
                    $args['category_name'] = $include_cats;
                } else {
                    $ending = "_category";
                    $cat_key = $posttype[0] . $ending;
                    if ($cat_key == "product_category") {
                        $cat_key = "product_cat";
                    }

                    $args['tax_query'][] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => $include_cats_arr,
                        'operator' => 'IN'
                    );
                }
            }
        }
    }

    if ($exclude_cats != "" && count($posttype) != 0) {

        $exclude_cats_arr = explode(',', $exclude_cats);

        $cat_tax_query = array(
            'relation' => 'AND'
        );

        if (count($posttype) > 1) {
            foreach ($posttype as $index => $post_type) {
                $cat_key = 'category';
                if ($post_type != 'post') {
                    $ending = "_category";
                    $cat_key = $post_type . $ending;
                    if ($cat_key == "product_category") {
                        $cat_key = "product_cat";
                    }
                }

                if ( $post_type != 'product_variation' ) {
                    $cat_tax_query[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => $exclude_cats_arr,
                        'operator' => 'NOT IN'
                    );
                }                
            }
            $args['tax_query'][] = $cat_tax_query;
        } else {
            if (in_array("post", $posttype)) {
                //$args['category__not_in'] = $exclude_cats_arr;
                $args['tax_query'][] = array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $exclude_cats_arr,
                    'operator' => 'NOT IN'
                );
            } else {

                if (!empty($post_taxonomies) && in_array('category', $post_taxonomies)) {
                    //$args['category__not_in'] = $exclude_cats_arr;
                    $args['tax_query'][] = array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $exclude_cats_arr,
                        'operator' => 'NOT IN'
                    );
                } else {
                    $ending = "_category";
                    $cat_key = $posttype[0] . $ending;
                    if ($cat_key == "product_category") {
                        $cat_key = "product_cat";
                    }

                    $args['tax_query'][] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => $exclude_cats_arr,
                        'operator' => 'NOT IN'
                    );
                }
            }
        }
    }

    if ($include_tags != "" && count($posttype) != 0) {

        $tag_tax_query = array(
            'relation' => 'OR'
        );

        $include_tags_arr = explode(',', $include_tags);

        if (count($posttype) > 1) {
            foreach ($posttype as $index => $post_type) {
                $cat_key = $post_type . "_tag";

                if ( $post_type != 'product_variation' ) {
                    $tag_tax_query[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => $include_tags_arr,
                        'operator' => 'NOT IN'
                    );
                }
            }

            $args['tax_query'][] = $tag_tax_query;
        } else {
            if ($posttype[0] == "post") {
                $args['tag'] = $include_tags;
            } else {
                $ending = "_tag";
                $cat_key = $posttype[0] . $ending;

                $args['tax_query'][] = array(
                    'taxonomy' => $cat_key,
                    'field' => 'slug',
                    'terms' => $include_tags_arr,
                    'operator' => 'IN'
                );
            }
        }
    }

    if ($include_term != "" && count($posttype) != 0) {

        $include_term_arr = explode(',', $include_term);

        $args['tax_query'][] = array(
            'taxonomy' => $include_taxomony,
            'field' => 'slug',
            'terms' => $include_term_arr,
            'operator' => 'IN'
        );
    }

    //////////////////////////////////////////////
    if ($current_loop_taxonomy_in_request == false) {
        if ($current_loop_taxonomy != '' && $current_loop_taxterm != '') {
            $args['taxonomy'] = $current_loop_taxonomy;
            $args['term'] = $current_loop_taxterm;
        } else if ($current_loop_taxonomy != '') {
            if ($args['taxonomy'] == $current_loop_taxonomy) {
                $args['taxonomy'] = '';
                $args['term'] = '';
            }
            foreach ($args['tax_query'] as $key => $meta) {
                if (is_array($meta) && !empty($meta['taxonomy']) && ($current_loop_taxonomy == $meta['taxonomy'])) {
                    unset($args['tax_query'][$key]);
                } else if (is_array($meta)) {
                    foreach ($meta as $subkey => $subMeta) {
                        if (is_array($subMeta) && !empty($subMeta['taxonomy']) && ($current_loop_taxonomy == $subMeta['taxonomy'])) {
                            unset($args['tax_query'][$key]);
                        }
                    }
                }
            }
        }
    }

    if ($onload_cats != "" && count($posttype) != 0) {

        $onload_cats_arr = explode(',', $onload_cats);

        $tax_query = array( 'relation' => 'OR' );

        foreach ($posttype as $key => $post_type) {
            if ($post_type == "post") {
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $onload_cats_arr,
                    'operator' => 'IN'
                );
            } else {

                $ending = "_category";
                $cat_key = $post_type . $ending;
                if ($cat_key == "product_category") {
                    $cat_key = "product_cat";
                }

                if (!empty($cpt_taxonomies) && in_array($cat_key, $cpt_taxonomies)) {
                    $tax_query[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => $onload_cats_arr,
                        'operator' => 'IN'
                    );
                } else if (!empty($cpt_taxonomies) && in_array('category', $cpt_taxonomies)) {
                    $tax_query[] = array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $onload_cats_arr,
                        'operator' => 'IN'
                    );

                    //$GLOBALS['my_query_filters']['tax_query'] = $post_type_choose . '_category';

                }
            }
        }

        $args['tax_query'][] = $tax_query;
    }

    if ($onload_tags != "" && count($posttype) != 0) {

        $onload_tags_arr = explode(',', $onload_tags);

      $tax_query = array( 'relation' => 'OR' );

        foreach ($posttype as $key => $post_type) {
            $ending = "_tag";
            $cat_key = $post_type . $ending;

            if ( $post_type != 'product_variation' ) {
                $tax_query[] = array(
                    'taxonomy' => $cat_key,
                    'field' => 'slug',
                    'terms' => $onload_tags_arr,
                    'operator' => 'IN'
                );    
            }            
        }

        $args['tax_query'][] = $tax_query;
    }

    //////////////////////////////////////////////
    $args_url = array(
        'post_type' => $posttype,
        'post_status' => 'publish',
        'orderby' => $sortorder,
        'order' => $sortasc
    );

    $args_url_final = array_merge($args_url, $args_url_acf);
    $args = array_merge($args, $args_url_final);

    // $args_url_final_send = add_query_arg( $args_url_final, 'http://localhost/divi-machine/' );
    // echo $args_url_final_send;
    $_GET['orderby'] = !empty($orderby_param) ? $orderby_param : '';

    if ( in_array( $sortorder, array("date", "relevance", "ID", "rand", "menu_order", "name", "modified", "title", "popularity", "rating" ) )
        || ( $sortorder == 'price' && class_exists( 'woocommerce' ) && ($posttype == 'product' || $posttype == 'product_variation') ) ) {
        $args1 = array(
            'post_type' => $posttype,
            'post_status' => 'publish',
            'orderby' => $sortorder,
            'order' => $sortasc
        );

        $args = array_merge($args, $args1);

        if ($sortorder == "price" && $sortasc == "desc") {
            $_GET['orderby'] = 'price-desc';
        } else {
            $_GET['orderby'] = $sortorder;
        }

        if ($sortorder == "rand") {
            $args['orderby'] = 'rand(' . rand() . ')';
        }

    } else if ($sortorder == 'acf_date_picker') {
        if (isset($_POST['acf_order_field'])) {
            $acf_date_picker_field = $_POST['acf_order_field'];
        }

        if (isset($_POST['acf_order_method'])) {
            $acf_date_picker_method = $_POST['acf_order_method'];
        }

        if(isset($acf_date_picker_field)){
$acf_get = get_field_object($acf_date_picker_field);
}

        foreach ($args['meta_query'] as $key => $meta) {
            if (is_array($meta) && !empty($meta['key']) && ($acf_get['name'] == $meta['key'])) {
                unset($args['meta_query'][$key]);
            } else if (is_array($meta)) {
                foreach ($meta as $subkey => $subMeta) {
                    if (is_array($subMeta) && !empty($subMeta['key']) && ($acf_get['name'] == $subMeta['key'])) {
                        unset($args['meta_query'][$key]);
                    }
                }
            }
        }
        if (isset($acf_date_picker_method) && $acf_date_picker_method == 'today_future') {

            if(isset($acf_get)){
$args['meta_key'] = $acf_get['name'];
}
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';

            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '>',
                'value' => gmdate("Y-m-d") ,
                'type' => 'DATE'
            );

        } elseif ($acf_date_picker_method == 'today_30') {

            $args['meta_key'] = $acf_get['name'];
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';

            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '>',
                'value' => gmdate("Y-m-d") ,
                'type' => 'DATE'
            );
            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '<=',
                'value' => gmdate("Y-m-d", strtotime("+30 days")) ,
                'type' => 'DATE'
            );

        } elseif ($acf_date_picker_method == 'before_today') {

            $args['meta_key'] = $acf_get['name'];
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';

            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '<=',
                'value' => gmdate('Y-m-d', strtotime("-1 days")) ,
                'type' => 'DATE'
            );

        } else {

            $args['meta_key'] = $acf_get['name'];
            $args['orderby'] = 'meta_value_num';
            $args['order'] = $sortasc;

        }
    } else if (strpos($sortorder, 'rand') === 0) {
        $args['orderby'] = $sortorder;
    } else if (strpos($sortorder, 'menu_order') === 0) {
        $args['orderby'] = $sortorder;
    } else if ($looptype == 'wishlist' && !empty($get_saved_types) && in_array($sortasc, explode(',', $get_saved_types))) {
        $args['orderby'] = 'post__in';
    } else {
        $sortorder_arr = explode(' ', $sortorder);

        if (is_array($sortorder_arr) && count($sortorder_arr) > 1) {
            $is_default = true;
            foreach ($sortorder_arr as $key => $sort) {
                if ( !in_array( $sort, array("date", "relevance", "ID", "rand", "menu_order", "name", "modified", "title", "popularity", "rating") )
                    && !( $sortorder == 'price' && class_exists( 'woocommerce' ) && ($posttype == 'product' || $posttype == 'product_variation') ) ) {
                    $is_default = false;
                }
            }

            if ($is_default) {
                $args['orderby'] = $sortorder;
            } else {
                $meta_value_type = 'meta_value';
                if ($sorttype == 'range' || $sorttype == 'num' || $sorttype == 'number') {
                    $meta_value_type = 'meta_value_num';
                }
                $args1 = array(
                    'post_type' => $posttype,
                    'post_status' => 'publish',
                    'meta_key' => $sortorder,
                    'orderby' => $meta_value_type,
                    'order' => $sortasc
                );
                $args = array_merge($args, $args1);
            }
        } else {
            $meta_value_type = 'meta_value';
            if ($sorttype == 'range' || $sorttype == 'num' || $sorttype == 'number') {
                $meta_value_type = 'meta_value_num';
            }
            $args1 = array(
                'post_type' => $posttype,
                'post_status' => 'publish',
                'meta_key' => $sortorder,
                'orderby' => $meta_value_type,
                'order' => $sortasc
            );
            $args = array_merge($args, $args1);
        }
    }

    $args['meta_query'] = array_merge($args['meta_query'], $meta_query);

    $args['tax_query'] = array_merge($args['tax_query'], $tax_query);

    if (isset($cat_show)) {
        if ($cat_show != "all" && count($posttype) > 1) {
            $subQuery = array(
                'relation' => 'OR'
            );
            foreach ($posttype as $key => $post_type) {
                $ending = "_category";
                $cat_key = $post_type . $ending;
                if ($post_type == 'product' || $post_type == 'product_variation') {
                    $cat_key = 'product_cat';
                }

                $val_and_array = explode('|', $cat_show);
                if (is_array($val_and_array) && count($val_and_array) > 1) {
                    $sub_tax_query = array(
                        'relation' => 'AND'
                    );
                    foreach ($val_and_array as $key => $or_value) {
                        $sub_tax_query[] = array(
                            'taxonomy' => $cat_key,
                            'field' => 'slug',
                            'terms' => explode(',', $or_value) ,
                            'operator' => 'IN'
                        );
                    }
                    $subQuery[] = $sub_tax_query;
                } else {
                    $subQuery[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => explode(',', $cat_show) ,
                        'operator' => 'IN'
                    );
                }
            }

            $args['tax_query'][] = $subQuery;
        } else if ($cat_show != "all" && count($posttype) == 1) {
            $ending = "_category";
            $cat_key = $posttype[0] . $ending;
            if ($posttype[0] == 'product' || $posttype[0] == 'product_variation') {
                $cat_key = 'product_cat';
            }

            $val_and_array = explode('|', $cat_show);
            if (is_array($val_and_array) && count($val_and_array) > 1) {
                $sub_tax_query = array(
                    'relation' => 'AND'
                );
                foreach ($val_and_array as $key => $or_value) {
                    $sub_tax_query[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => explode(',', $or_value) ,
                        'operator' => 'IN'
                    );
                }
                $args['tax_query'][] = $sub_tax_query;
            } else {
                $args['tax_query'][] = array(
                    'taxonomy' => $cat_key,
                    'field' => 'slug',
                    'terms' => explode(',', $cat_show) ,
                    'operator' => 'IN'
                );
            }
        }
    }

    if (isset($cus_tag_show)) {
        if ($cus_tag_show != "all" && count($posttype) > 1) {
            $subQuery = array(
                'relation' => 'OR'
            );

            foreach ($posttype as $key => $post_type) {
                $ending = "_tag";
                $cat_key = $post_type . $ending;

                $val_and_array = explode('|', $cus_tag_show);
                if (is_array($val_and_array) && count($val_and_array) > 1) {
                    $sub_tax_query = array(
                        'relation' => 'AND'
                    );
                    foreach ($val_and_array as $key => $or_value) {
                        $sub_tax_query[] = array(
                            'taxonomy' => $cat_key,
                            'field' => 'slug',
                            'terms' => explode(',', $or_value) ,
                            'operator' => 'IN'
                        );
                    }
                    $subQuery[] = $sub_tax_query;
                } else {
                    $subQuery[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => explode(',', $cus_tag_show) ,
                        'operator' => 'IN'
                    );
                }
            }

            $args['tax_query'][] = $subQuery;
        } else if ($cus_tag_show != "all" && count($posttype) == 1) {
            $ending = "_tag";
            $cat_key = $posttype[0] . $ending;

            $val_and_array = explode('|', $cus_tag_show);
            if (is_array($val_and_array) && count($val_and_array) > 1) {
                $sub_tax_query = array(
                    'relation' => 'AND'
                );
                foreach ($val_and_array as $key => $or_value) {
                    $sub_tax_query[] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => explode(',', $or_value) ,
                        'operator' => 'IN'
                    );
                }
                $args['tax_query'][] = $sub_tax_query;
            } else {
                $args['tax_query'][] = array(
                    'taxonomy' => $cat_key,
                    'field' => 'slug',
                    'terms' => explode(',', $cus_tag_show) ,
                    'operator' => 'IN'
                );
            }
        }
    }

    if (isset($tag_show)) {
        if ($tag_show != "all") {

            $prefix = 'tag-link-';
            $str = $tag_show;

            if (substr($str, 0, strlen($prefix)) == $prefix) {
                $str = substr($str, strlen($prefix));
            }
            $args['tag__in'] = $str;
        }
    }

    if (isset($search_keyword)) {
        $args['s'] = $search_keyword;
    }

    if (isset($posttax) && $posttax !== "") {
        $args['tax_query'][] = array(
            'taxonomy' => $posttax,
            'field' => 'slug',
            'terms' => $postterm,
            'operator' => 'IN'
        );
    }

    if (isset($post_category)) {
        $args['category_name'] = $post_category;
    }

    if (isset($post_tag_show)) {
        $val_and_array = explode('|', $post_tag_show);
        if (is_array($val_and_array) && count($val_and_array) > 1) {
            $sub_tax_query = array(
                'relation' => 'AND'
            );
            foreach ($val_and_array as $key => $or_value) {
                $sub_tax_query[] = array(
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => explode(',', $or_value) ,
                    'operator' => 'IN'
                );
            }
            $args['tax_query'][] = $sub_tax_query;
        } else {
            $args['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => explode(',', $post_tag_show) ,
                'operator' => 'IN'
            );
        }
    }

    if (isset($category_currently_in) && $category_currently_in !== "") {
        $args['category_name'] = $category_currently_in;
    }

    if (isset($current_author) && $current_author !== "") {
        $args['author_name'] = $current_author;
    }

    if ($current_custom_category !== "") {

        if (in_array($args['tax_query'], $args)) {
        } else {
            if(isset($tax_key)){
$args['tax_query'][$tax_key] = array(
                'taxonomy' => $current_custom_category,
                'field' => 'slug',
                'terms' => $current_custom_category_terms
);
}
        }
    }

    if (class_exists('woocommerce') && ($posttype == 'product' || $posttype == 'product_variation')) {
        $product_visibility_terms = wc_get_product_visibility_term_ids();
        $product_visibility_not_in = array(
            $product_visibility_terms['exclude-from-catalog']
        );
        if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
            $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
        }

        if ($hide_non_purchasable == "on" || $show_hidden_prod == "off") {

            if (!empty($product_visibility_not_in)) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'term_taxonomy_id',
                    'terms' => $product_visibility_not_in,
                    'operator' => 'NOT IN',
                );
            }
        }

        if ($hide_non_purchasable == "on") {
            $args['meta_query'] = array(
                array(
                    'key' => '_price',
                    'value' => '',
                    'compare' => '!='
                )
            );
        }
    }

    if ($onload_taxomony != "" && count($posttype) != 0) {
        if(isset($onload_tax_choose)){
$args['tax_query'][] = array(
            'taxonomy' => $onload_tax_choose,
            'field' => 'slug',
            'terms' => explode(',', $onload_taxomony) ,
            'operator' => 'IN'
);
}
    }

    $args = apply_filters('divi_archive_post_args', $args);

    if ( in_array( 'product', $args['post_type'] ) || in_array( 'product_variation', $args['post_type'] ) ){
        if ( in_array($sortorder, array("date", "relevance", "ID", "menu_order", "name", "modified", "title", "popularity", "rating", "price") ) ){
            if ( function_exists('WC') ) {
                $order_by = WC()->query->get_catalog_ordering_args( $sortorder, $sortasc );
                $args = array_merge($args, $order_by);
            }
        }
    }

    // Add wishlist code here
    if ($looptype == 'wishlist') {

        $user_id = get_current_user_id();
        $wishlist_ids = '';
        $wishlist_ids_arr = array();

        $saved_type = explode(',', $get_saved_types);

        if (in_array($sortasc, $saved_type)) {
            array_splice($saved_type, array_search($sortasc, $saved_type) , 1);
            array_unshift($saved_type, $sortasc);
        }

        foreach ($saved_type as $saved_type_multiple_name) {
            $saved_type_multiple_name_settings = get_user_meta($user_id, 'machine_' . $saved_type_multiple_name, true);
            if (is_array($saved_type_multiple_name_settings)) {
                foreach ($posttype as $key => $type) {
                    if ($saved_type_multiple_name_settings[$type]) {
                        $wishlist_ids_add = $saved_type_multiple_name_settings[$type];
                    }

                    if(isset($wishlist_ids_add)){
$wishlist_ids_arr = (array_merge($wishlist_ids_arr, $wishlist_ids_add));
}
                }
            }
        }

        if (!empty($wishlist_ids_arr)) {
            $wishlist_ids = $wishlist_ids_arr;
        } else {
            $wishlist_ids = array(
                "9824139842183412321348912"
            );
        }

        $args = array(
            'post_type' => $posttype,
            'post_status' => 'publish',
            'posts_per_page' => (int)$postnumber,
            'post__in' => $wishlist_ids,
            'orderby' => 'post__in'
        );

    }

    if ( in_array( 'product_variation', $posttype ) ) {

        add_filter( 'posts_clauses', function( $clauses, $w_query ) {
            global $wpdb;

            $clauses['fields'] = "IFNULL(child_posts.ID, {$wpdb->posts}.ID) ID, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_date, child_posts.post_date) post_date, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_author, child_posts.post_author) post_author, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_content, child_posts.post_content) post_content, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_title, child_posts.post_title) post_title, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_name, child_posts.post_name) post_name, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_parent, child_posts.post_parent) post_parent,  
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.guid, child_posts.guid) guid, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.menu_order, child_posts.menu_order) menu_order, 
                IF(ISNULL(child_posts.ID), {$wpdb->posts}.post_type, child_posts.post_type) post_type";
            $clauses['join'] = $clauses['join'] . " LEFT JOIN {$wpdb->posts} AS child_posts ON ({$wpdb->posts}.ID = child_posts.post_parent) AND child_posts.post_type = 'product_variation' ";
            $clauses['groupby'] = "ID";
            $clauses['orderby'] = str_ireplace( $wpdb->posts . ".", "", $clauses['orderby']);

            return $clauses;
        }, 129, 2);

    }

    if ( !empty( $current_product_attributes ) ) {
        $sql = "
            SELECT child_posts.post_parent
              FROM {$wpdb->posts} as child_posts            
        ";

        if ( $stock_status == '' ) {
            $stock_status = 'instock';
        }

        foreach ( $current_product_attributes as $ind => $attr ) {
            $sql .= " 
                INNER JOIN {$wpdb->postmeta} AS child_meta{$ind} ON child_meta{$ind}.post_id = child_posts.id AND child_meta{$ind}.meta_key = 'attribute_{$attr['attr_name']}' AND child_meta{$ind}.meta_value='{$attr['attr_val']}'
                INNER JOIN {$wpdb->postmeta} AS child_stock{$ind} ON child_stock{$ind}.post_id = child_posts.id AND child_stock{$ind}.meta_key = '_stock_status' AND child_stock{$ind}.meta_value != '{$stock_status}'
            ";
        }

        $sql .= " WHERE child_posts.post_type = 'product_variation'";

        $unavailable_posts = $wpdb->get_results( $sql, ARRAY_A );

        if ( !empty( $unavailable_posts ) ) {
            $unavailable_posts = array_column($unavailable_posts, 'post_parent');
            $args['post__not_in'] = $unavailable_posts;
        }
    }

    query_posts( $args );

    remove_all_filters( 'dgwt/wcas/helpers/is_search_query', 135 );

    if ( in_array( 'product_variation', $posttype ) ) {
        remove_all_filters( 'posts_clauses', 129 );
    }

    $price_filter_var['is_filter'] = false;
    $address_filter_var['is_filter'] = false;

    if (in_array('product', $args['post_type']) || in_array('product_variation', $args['post_type'])) {
        $wp_query->set('wc_query', 'product_query');
    }

    $wp_query->is_tax = false;

    $wp_query_var = $wp_query->query_vars;

    if (!isset($wp_archive_query)) {
        $wp_archive_query = $wp_query;
    }

    foreach ($args['tax_query'] as $tax_key => $tax_val) {
        if (is_array($tax_val) && !empty($tax_val['taxonomy']) && ($wp_query_var['taxonomy'] == $tax_val['taxonomy'])) {
            if (is_array($tax_val['terms']) && count($tax_val['terms']) > 1) {
                $wp_query_var['taxonomy'] = '';
                $wp_query_var['term_id'] = '';
                $wp_query_var['term'] = '';
            }
        } else if (is_array($tax_val)) {
            foreach ($tax_val as $subkey => $subTax) {
                if (is_array($subTax) && !empty($subTax['taxonomy']) && ($wp_query_var['taxonomy'] == $subTax['taxonomy'])) {
                    $wp_query_var['taxonomy'] = '';
                    $wp_query_var['term'] = '';
                    $wp_query_var['term_id'] = '';
                }
            }
        }
    }

    if ($product_price_val != '') {
        $wp_query_var['product_price'] = $product_price_val;
    }

    $loadmore_param = array(
        'post_var' => json_encode($wp_query_var) ,
        'max_num_pages' => $wp_query->max_num_pages,
        'current_page' => (get_query_var('paged')) ? get_query_var('paged') : 1
    );

    $filter_item_name_array_removeduplicates = array_unique($filter_name_and_val_array);
    $filter_item_name_collate = [];

    if ( $loadmore != 'pagination' ) {
        remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
    }

    if ((in_array('product', $args['post_type']) || in_array('product_variation', $args['post_type'])) && $layoutid == 'none') {
        if (isset($_POST['show_rating'])) {
            $show_rating = $_POST['show_rating'];
        }

        if (isset($_POST['show_price'])) {
            $show_price = $_POST['show_price'];
        }

        if (isset($_POST['show_excerpt'])) {
            $show_excerpt = $_POST['show_excerpt'];
        }

        if (isset($_POST['show_add_to_cart'])) {
            $show_add_to_cart = $_POST['show_add_to_cart'];
        }

        if(isset($show_rating)){
if ($show_rating == 'off') {
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
}
}
        if(isset($show_price)){
if ($show_price == 'off') {
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
}
}
        if(isset($show_excerpt)){
if ($show_excerpt == 'on') {
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8);
}
}
        if(isset($show_add_to_cart)){
if ($show_add_to_cart == 'on') {
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9);
}
}

        add_action( 'woocommerce_shop_loop_item_title', array( 'db_filter_loop_code', 'product_details_wrapper_start' ), 0 );
        add_action( 'woocommerce_after_shop_loop_item', array( 'db_filter_loop_code', 'product_details_wrapper_end' ), 10 );

        add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_filter_loop_code', 'product_image_wrapper_start' ), 0 );
        add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_filter_loop_code', 'product_image_wrapper_end' ), 20 );
    }

    $show_sorting_menu = isset($_POST['show_sort']) ? $_POST['show_sort'] : 'off';

    if ($show_sorting_menu == 'off') {
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    } else {
        add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    }
    if ($resultcount == 'off' || $countposition == 'bottom' ) {
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    } else {
        add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    }

    if ( $resultcount == 'on' && $countposition == 'bottom' ) {
        add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 5);
    }

    global $shop_columns;
    $shop_columns = $columnscount;

    add_filter('loop_shop_columns', function ($columns) {
        global $shop_columns;
        return $shop_columns;
    }
    , 9999);

    $before_shop_loop = '';
    if (in_array('product', $args['post_type']) || in_array('product_variation', $args['post_type'])) {
        ob_start();
        do_action('woocommerce_before_shop_loop');
        $before_shop_loop = ob_get_contents();
        ob_end_clean();
    }

    $filter_result = '';

    ob_start();

    if (in_array('product', $args['post_type']) || in_array('product_variation', $args['post_type'])) {
        if (have_posts()) {

            $mas_style = '';
            if ($gridstyle == 'masonry') {
                $mas_style = 'style="grid-auto-rows: 1px;"';
            }

            if (strpos($ul_classes, "products") === false) {
                $ul_classes = 'products ' . esc_attr($ul_classes);
            }

            echo '<ul class="' . esc_attr($ul_classes) . '" ' . esc_attr($mas_style) . '>';
            while (have_posts()) {
                the_post();
                global $product;

                $post_link = get_permalink(get_the_ID());
                $product_id = get_the_ID();

                if (get_option('woocommerce_hide_out_of_stock_items') == "yes" && (!$product->managing_stock() && !$product->is_in_stock())) {
                } else {
                    if ($layoutid != 'none') {

                        if ($gridstyle == "masonry") {
                            $grid_class = "grid-item";
                        } else {
                            $grid_class = "grid-col";
                        }

                            $product_classes = '';

                            if ( function_exists( 'wc_get_product_class' ) ) {
                                $product_classes = implode( " ", wc_get_product_class( '', $product_id ) );
                            }

                            echo '<li class="'.esc_attr($grid_class).' '. esc_attr( $product_classes ) . ' ">';
                            ?>
                            <div class="grid-item-cont">
                            <?php
                        if ($link_whole_gird == "on") {

                            if ($link_wholegrid_external == "on") {
                                $acf_get = get_field_object($link_wholegrid_external_acf);
                                $post_link = $acf_get['value'];
                            }

?>
                            <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr($post_link) ?>">
<?php
                        }

                        do_action('de_ajaxfilter_before_shop_loop_item');

                        $product_content = apply_filters('the_content', get_post_field('post_content', wp_kses_post($layoutid)));

                        $product_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $product_content);
                        $product_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $product_content);

                        echo et_core_esc_previously($product_content);

                        do_action('de_ajaxfilter_after_shop_loop_item');

                        if ($link_whole_gird == "on") {
?>
                            </div>
<?php
                        }
?>
                            </div>
                            <?php
                        echo '</li>';
                    } else {
                        do_action('woocommerce_shop_loop');

                        wc_get_template_part('content', 'product');
                    }
                }
            } // endwhile
            echo '</ul>';

            if ((in_array('product', $args['post_type']) || in_array('product_variation', $args['post_type'])) && $layoutid == 'none') {
                if(isset($show_rating)){
if ($show_rating == 'off') {
                    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
}
}
                if(isset($show_price)){
if ($show_price == 'off') {
                    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
}
}
                if(isset($show_excerpt)){
if ($show_excerpt == 'on') {
                    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8);
}
}
                if(isset($show_add_to_cart)){
if ($show_add_to_cart == 'on') {
                    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9);
}
}

                remove_action( 'woocommerce_shop_loop_item_title', array( 'db_filter_loop_code', 'product_details_wrapper_start' ), 0 );
                remove_action( 'woocommerce_after_shop_loop_item', array( 'db_filter_loop_code', 'product_details_wrapper_end' ), 10 );
                remove_action( 'woocommerce_before_shop_loop_item_title', array( 'db_filter_loop_code', 'product_image_wrapper_start' ), 0 );
                remove_action( 'woocommerce_before_shop_loop_item_title', array( 'db_filter_loop_code', 'product_image_wrapper_end' ), 20 );
            }
            $filter_result = 'has-result';
        } else {
            echo '<div class="no-results-layout" data-classes="' . esc_attr($ul_classes) . '">';
            if ($noresults == "none") {
                if (et_is_builder_plugin_active()) {
                    if(defined('ET_BUILDER_PLUGIN_DIR')){
                    include (ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php');
                    }
                } else {
                    get_template_part('includes/no-results', 'index');
                }
            } else {
                $noresult_content = apply_filters('the_content', get_post_field('post_content', wp_kses_post($noresults)));
                $noresult_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $noresult_content);
                $noresult_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $noresult_content);

                echo et_core_esc_previously($noresult_content);
            }
            echo '</div>';
            $filter_result = 'no-results-layout';
        }
    } else {
        if (have_posts()) {
?>
        <div class="grid-posts loop-grid">
<?php

            $marker_layout_content = '';
            if ( $marker_layout != 'none' ) {
                $marker_layout_content = get_post_field( 'post_content', $marker_layout );
            }
            while ( have_posts() ) {
                the_post();
                if ($has_map == 'on' && $dmach_map_acf !== "none" && in_array($dmach_post_type, $posttype) && $map_all_posts == 'off') {
                    $address_data = get_field($dmach_map_acf);
                    if (empty($address_data)) {
                        if ( isset( $address_filter_var['address_field'] ) && !empty( $address_filter_var['address_field'] ) ) {
                            $address_data = get_post_meta(get_the_ID() , $address_filter_var['address_field'], true);
                        }
                    }

                    if ( !empty( $address_data ) ) {
                        $map_array[] = $address_data;
                        if ($marker_layout == 'none') {
                            $map_infoview_content = get_the_title();
                        } else {
                            $map_infoview_content = apply_filters( 'the_content', $marker_layout_content );
                        }

                        $map_infoview_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ml_${1}_${2}_tb_body', $map_infoview_content);
                        $map_infoview_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ml_${1}_${2}${3}', $map_infoview_content);

                        $map_array[count($map_array) - 1]['infoview'] = $map_infoview_content;
                        $map_array[count($map_array) - 1]['title'] = get_the_title();
                    }
                }

                $post_link = get_permalink(get_the_ID());

                $post_id = get_the_ID();

                $current_post_type = get_post_type();

                $terms = wp_get_object_terms($post_id, get_object_taxonomies($posttype));
                $terms_array = array();
                foreach ($terms as $term) {
                    $terms_array[] = $term->taxonomy . '-' . $term->slug;
                }
                $terms_string = implode(" ", $terms_array);

                if ($gridstyle == "masonry") {
?>
            <div class="grid-item dmach-grid-item <?php echo esc_attr($terms_string) ?> post_id_<?php echo esc_html($post_id) ?>" data-id="<?php echo esc_attr($post_id);?>" data-posttype="<?php echo esc_attr($current_post_type);?>">
                <div class="grid-item-cont">
<?php
                } else {
?>
            <div class="grid-col dmach-grid-item <?php echo esc_attr($terms_string) ?> post_id_<?php echo esc_html($post_id) ?>" data-id="<?php echo esc_attr($post_id);?>" data-posttype="<?php echo esc_attr($current_post_type);?>">
                <div class="grid-item-cont">
<?php
                }

                if ($link_whole_gird == "on") {
                    if ($link_wholegrid_external == "on") {
                        $acf_get = get_field_object($link_wholegrid_external_acf);
                        $post_link = $acf_get['value'];
                    }
?>
                    <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_url($post_link) ?>">
<?php
                }

                $meta = get_post_meta(get_the_ID());
                $post_tags = get_the_tags(get_the_ID());

                foreach ($filter_name_and_val_array as $key => $value) {

                    // check meta for refine filters
                    if (array_key_exists($key, $meta)) {

                        $meta_get = get_post_meta(get_the_ID() , $key, true);

                        if (array_key_exists($key, $filter_item_name_collate)) {
                            $filter_item_name_collate[$key][] = $meta_get;
                        } else {
                            $filter_item_name_collate[$key] = array(
                                $meta_get
                            );
                        }
                    }
                }

                $post_content = apply_filters('the_content', get_post_field('post_content', $layoutid));

                $post_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $post_content);
                $post_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $post_content);

                echo $post_content;

                if ($link_whole_gird == "on") {
?>
                    </div>
<?php
                }
?>
            </div>
        </div>
<?php
            }
            $have_post = false;
            $current_in_archive_loop = '';
            $filter_result = 'has-result';
?>
        </div>
<?php
        } else {

            if ($noresults == "none") {
                echo '<div class="no-results-layout">';
                echo $no_results_text;
                echo '</div>';
            } else {
?>
            <div class="no-results-layout">
<?php
                $content = do_shortcode('[et_pb_row global_module="' . $noresults . '"][/et_pb_row]');

                $content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $content);
                $content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $content);

                echo et_core_esc_previously($content);
?>
            </div>
<?php
            }
            $filter_result = 'no-results-layout';
        }
    }

    $posts = ob_get_contents();
    ob_end_clean();

    $after_shop_loop = '';
    if (in_array('product', $args['post_type'])) {
        ob_start();

        if ($loadmore == 'pagination' || ( $resultcount == 'on' && $countposition == 'bottom' ) ) {
            do_action('woocommerce_after_shop_loop');
        }
        if ($loadmore == 'on') {
            if ($wp_query->max_num_pages > 1) {
?>
            <div class="dmach-loadmore et_pb_button <?php echo (isset($position_class) ? esc_attr($position_class) : ''); ?>" data-btntext="<?php echo esc_attr($loadmoretext) ?>" data-btntext_loading="<?php echo esc_attr($loadmoretextloading) ?>" data-icon="<?php echo esc_attr($loadmore_icon) ?>"><?php echo esc_html($loadmoretext) ?></div>
<?php
            }
        }

        // JS LINKS
        // Data shouldn't be loaded in Builder, so always pass an empty array there.
        $animation_data = et_core_is_fb_enabled() ? array() : et_builder_handle_animation_data();
        $animation_data_json = json_encode($animation_data);

        $link_options_data = et_core_is_fb_enabled() ? array() : et_builder_handle_link_options_data();
        $link_options_data_json = json_encode($link_options_data);

        $link_options_data_json = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $link_options_data_json);
        $link_options_data_json = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $link_options_data_json);

        /*if ( empty( $animation_data ) && empty( $link_options_data ) ) {
        return;
        }*/

?>
    <div class="df-inner-js">
    <script type="text/javascript">
        <?php if ($animation_data): ?>
        var et_animation_data = <?php echo et_core_esc_previously($animation_data_json); ?>;
            <?php
        endif;

        if ($link_options_data):
?>
        var et_link_options_data_ajax = <?php echo et_core_esc_previously($link_options_data_json); ?>;

        jQuery.each(et_link_options_data_ajax, function(index, element) {
            var class_name = element.class,
            url_name = element.url ,
            target_name = element.target;

            jQuery("." + class_name).click(function (event) {
                event.stopPropagation();
                if (target_name == "_blank") {
                window.open(url_name,"_blank");
                } else {
                window.open(url_name,"_self");
                }
            });
        });

        <?php
        endif; ?>
    </script>
    </div>
    <?php

        // JS LINKS
        $after_shop_loop = ob_get_contents();
        ob_end_clean();

    } else {
        ob_start();
        $position_class = '';
        $posts_number = $args['posts_per_page'];
        if ($resultcount == "on") {
            $position_class = 'result_count_' . $countposition;
            echo '<p class="divi-filter-result-count ' . esc_attr($position_class) . '">';
            if ($wp_query->found_posts == 1) {
                echo $result_count_single_text;
            } else if ($wp_query->found_posts == $wp_query->post_count) {
                printf(esc_html__($result_count_all_text, $domain_name) , $wp_query->found_posts);
            } else {
                //printf( __( 'Showing %1$d&ndash;%2$d of %3$d result', 'woocommerce' ), $first, $last, $total );
                printf(esc_html__($result_count_pagination_text, $domain_name) , (($current_page - 1) * $posts_number + 1) , (($current_page - 1) * $posts_number + $wp_query->post_count) , $wp_query->found_posts);

                //printf( __('Showing %d-%d of %d results', 'divi-filter'), (($current_page - 1) * $posts_number + 1), (($current_page - 1) * $posts_number + $wp_query->post_count), $wp_query->found_posts );

            }
            echo '</p>';
        }
        if ($loadmore == "on") {
            if ($wp_query->max_num_pages > 1) {
?>
            <div class="dmach-loadmore et_pb_button <?php echo esc_attr($position_class); ?>" data-btntext="<?php echo esc_attr($loadmoretext) ?>" data-btntext_loading="<?php echo esc_attr($loadmoretextloading) ?>" data-icon="<?php echo esc_attr($loadmore_icon) ?>"><?php echo esc_html($loadmoretext) ?></div>
<?php
            }
        } else if ($loadmore == "pagination") {
?>
            <div class="divi-filter-pagination <?php echo esc_attr($position_class); ?>"><?php echo paginate_links(array(
                'type' => 'list'
            )); ?></div>
<?php
        }

        $animation_data = et_core_is_fb_enabled() ? array() : et_builder_handle_animation_data();
        $animation_data_json = json_encode($animation_data);

        $link_options_data = et_core_is_fb_enabled() ? array() : et_builder_handle_link_options_data();
        $link_options_data_json = json_encode($link_options_data);

        $link_options_data_json = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $link_options_data_json);
        $link_options_data_json = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $link_options_data_json);

?>

        <div class="df-inner-js">
    <script type="text/javascript">
        <?php if ($animation_data): ?>
        var et_animation_data = <?php echo et_core_esc_previously($animation_data_json); ?>;
            <?php
        endif;

        if ($link_options_data):
?>
        var et_link_options_data_ajax = <?php echo et_core_esc_previously($link_options_data_json); ?>;

        jQuery.each(et_link_options_data_ajax, function(index, element) {
            var class_name = element.class,
            url_name = element.url ,
            target_name = element.target;

            jQuery("." + class_name).click(function (event) {
                event.stopPropagation();
                if (target_name == "_blank") {
                window.open(url_name,"_blank");
                } else {
                window.open(url_name,"_self");
                }
            });
        });

        <?php
        endif; ?>
    </script>
    </div>

    <?php
        $after_shop_loop = ob_get_contents();
        ob_end_clean();
    }

    if ( $loadmore != 'pagination' ) {
        add_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
    }

    ob_start();

    // retrieve the styles for the modules
    $internal_style = ET_Builder_Element::get_style();
    // reset all the attributes after we retrieved styles
    ET_Builder_Element::clean_internal_modules_styles(false);
    $et_pb_rendering_column_content = false;

    // append styles
    if ($internal_style) {
?>
    <div class="df-inner-styles">
<?php
        $cleaned_styles = str_replace("body.et-db #page-container #et-boc .et-l .et_pb_section ", "", $internal_style);
        $cleaned_styles = str_replace("body.woocommerce.et-db #et-boc .et-l ", "", $cleaned_styles);
        $cleaned_styles = str_replace("body.et-db #page-container #et-boc .et-l ", "", $cleaned_styles);
        $cleaned_styles = str_replace("body #page-container .et_pb_section ", "", $cleaned_styles);
        $cleaned_styles = str_replace(".et-db #et-boc .et-l .et_pb_section ", "", $cleaned_styles);
        $cleaned_styles = str_replace(".et-db #et-boc .et-l ", "", $cleaned_styles);
        $temp_styles = $cleaned_styles;
        $temp_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}_${2}_tb_body', $temp_styles);
        $temp_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'et_pb_df_ajax_filter_${1}_${2}${3}', $temp_styles);

        $map_styles = '';

        if ($has_map == 'on' && $dmach_map_acf !== "none" && in_array($dmach_post_type, $posttype) && $map_all_posts == 'off') {
            $map_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ml_${1}_${2}_tb_body', $cleaned_styles);
            $map_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'et_pb_df_ml_${1}_${2}${3}', $map_styles);
            $map_cleaned_styles = preg_replace('/\.et_pb_([a-z|_]+)_(\d+)_tb_body/', 'body.et-db #et-boc .et-l .et_pb_df_ml_${1}_${2}_tb_body', $cleaned_styles);
            $map_cleaned_styles = preg_replace('/\.et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'body.et-db #et-boc .et-l .et_pb_df_ml_${1}_${2}${3}', $map_cleaned_styles);
            $map_styles = $map_styles . ' ' . $map_cleaned_styles;
        }
        $cleaned_styles = preg_replace('/\.et_pb_([a-z|_]+)_(\d+)_tb_body/', 'body.et-db #et-boc .et-l .et_pb_df_ajax_filter_${1}_${2}_tb_body', $cleaned_styles);
        $cleaned_styles = preg_replace('/\.et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'body.et-db #et-boc .et-l .et_pb_df_ajax_filter_${1}_${2}${3}', $cleaned_styles);
        $cleaned_styles = $temp_styles . ' ' . $cleaned_styles . ' ' . $map_styles;

        printf('<style type="text/css" class="dmach_ajax_inner_styles">
              %1$s
            </style>', et_core_esc_previously($cleaned_styles));
?>
    </div>
<?php
    }

    $css_output = ob_get_contents();

    ob_end_clean();

    ///////////////////////////////////////////////////////////////////
    // FILTERS
    //////////////////////////////////////////////////////////////////
    ob_start();
?>
    <div class="refine-filters">
<?php
    foreach ($filter_item_name_collate as $key => $item) {
        $filter_val = '';
        foreach ($item as $value) {
            $single_val = '';
            if (is_array($value)) {
                $single_val = implode(',', $value);
            } else {
                $single_val = $value;
            }

            if ($filter_val == '') {
                $filter_val = $single_val;
            } else {
                $filter_val = $filter_val . ',' . $single_val;
            }
        }
?>
        <span class="active-filters" data-filter-name="<?php echo esc_attr($key) ?>" data-filter-val="<?php echo esc_attr($filter_val); ?>"></span>
<?php
    }
?>
    </div>

<?php
    $filers_html = ob_get_contents();
    ob_end_clean();

    $return = array(
        'before_shop_loop' => $before_shop_loop,
        'after_shop_loop' => $after_shop_loop,
        'posts' => $posts,
        'filters' => $filers_html,
        'loadmore_param' => $loadmore_param,
        'css_output' => $css_output,
        'filter_result' => $filter_result
    );

    if ($has_map == 'on' && $dmach_map_acf !== "none" && in_array($dmach_post_type, $posttype)) {
        if (empty($map_array)) {
            $map_array = array();
        }
        $return['map_data'] = $map_array;
    }

    $wp_archive_query = null;

    wp_send_json($return);
    wp_die();
}

add_action('wp_ajax_divi_filter_ajax_handler', 'divi_filter_ajax_handler');
add_action('wp_ajax_nopriv_divi_filter_ajax_handler', 'divi_filter_ajax_handler');

function divi_filter_loadmore_ajax_handler() {
    global $wp_query, $wp_archive_query, $address_filter_var, $price_filter_var;

    $domain_name = '';

    if (defined('DE_DB_WOO_VERSION')) {
        $domain_name = 'divi-bodyshop-woocommerce';
    } else if (defined('DE_DMACH_VERSION')) {
        $domain_name = 'divi-machine';
    } else {
        $domain_name = 'divi-filter';
    }

    if (!check_ajax_referer('filter_object', 'security')) {
        wp_send_json_error('Nonce verification failed');
    }

    $divi_machine_options = maybe_unserialize(get_option('divi-machine_options'));

    ob_start();

    // prepare our arguments for the query
    if (isset($_POST['query'])) {
        $args = json_decode(stripslashes($_POST['query']) , true); //phpcs:ignore

    }

    if (isset($args['offset']) && $args['offset'] == 0) {
        unset($args['offset']);
    }
    isset($_POST['page']) ? $args['paged'] = $page_ind = $_POST['page'] + 1 : ''; // we need next page to be loaded
    $args['post_status'] = 'publish';
    $layoutid = !empty($_POST['layoutid']) ? $_POST['layoutid'] : '';
    $posttype = !empty($_POST['posttype']) ? $_POST['posttype'] : '';
    $noresults = !empty($_POST['noresults']) ? $_POST['noresults'] : '';
    $no_results_text = !empty($_POST['no_results_text']) ? $_POST['no_results_text'] : '';
    $sortorder = !empty($_POST['sortorder']) ? $_POST['sortorder'] : '';
    $sortasc = !empty($_POST['sortasc']) ? $_POST['sortasc'] : '';
    $gridstyle = !empty($_POST['gridstyle']) ? $_POST['gridstyle'] : '';
    $columnscount = !empty($_POST['columnscount']) ? $_POST['columnscount'] : '';
    $postnumber = !empty($_POST['postnumber']) ? $_POST['postnumber'] : '';
    $args['posts_per_page'] = $postnumber;
    $link_whole_gird = !empty($_POST['link_wholegrid']) ? $_POST['link_wholegrid'] : '';
    $link_wholegrid_external = !empty($_POST['link_wholegrid_external']) ? $_POST['link_wholegrid_external'] : '';
    $link_wholegrid_external_acf = !empty($_POST['link_wholegrid_external_acf']) ? $_POST['link_wholegrid_external_acf'] : '';
    $resultcount = !empty($_POST['resultcount']) ? $_POST['resultcount'] : '';
    $countposition = !empty($_POST['countposition']) ? $_POST['countposition'] : 'left';
    $loadmoretext = !empty($_POST['loadmoretext']) ? $_POST['loadmoretext'] : '';
    $loadmoretextloading = !empty($_POST['loadmoretextloading']) ? $_POST['loadmoretextloading'] : '';
    $loadmore_icon = !empty($_POST['loadmore_icon']) ? $_POST['loadmore_icon'] : '';
    $is_loadmore = !empty($_POST['is_loadmore']) ? $_POST['is_loadmore'] : '';
    $has_map = !empty($_POST['has_map']) ? $_POST['has_map'] : '';
    $map_all_posts = !empty($_POST['map_all_posts']) ? $_POST['map_all_posts'] : 'off';
    $map_selector = !empty($_POST['map_selector']) ? $_POST['map_selector'] : '';
    $marker_layout = !empty($_POST['marker_layout']) ? $_POST['marker_layout'] : '';

    $dmach_map_acf = !empty($divi_machine_options['dmach_map_acf']) ? $divi_machine_options['dmach_map_acf'] : '';
    $dmach_post_type = !empty($divi_machine_options['dmach_post_type']) ? $divi_machine_options['dmach_post_type'] : '';

    $dmach_post_type_custom = !empty($divi_machine_options['dmach_post_type_custom'])?$divi_machine_options['dmach_post_type_custom']:'';

    if ($dmach_post_type_custom !== "") {
      $dmach_post_type = $dmach_post_type_custom;
    }

    $_GET['orderby'] = !empty($args['orderby']) ? $args['orderby'] : '';

    $posttype = explode(',', $posttype);

    if ( !is_array( $posttype ) ) {
        $posttype = array( $posttype );
    }

    // it is always better to use WP_Query but not here
    if ( in_array('product', $posttype ) || in_array( 'product_variation', $posttype ) ){
        if ( in_array($sortorder, array("date", "relevance", "ID", "menu_order", "name", "modified", "title", "popularity", "rating", "price") ) ){
            $order_by = WC()->query->get_catalog_ordering_args( $args['orderby'], $args['order'] );
            $args = array_merge($args, $order_by);
        }
    }

    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);

    if ((in_array('product', $posttype) || in_array('product_variation', $posttype)) && $layoutid == 'none') {
        $show_rating = !empty($_POST['show_rating']) ? $_POST['show_rating'] : '';
        $show_price = !empty($_POST['show_price']) ? $_POST['show_price'] : '';
        $show_excerpt = !empty($_POST['show_excerpt']) ? $_POST['show_excerpt'] : '';
        $show_add_to_cart = !empty($_POST['show_add_to_cart']) ? $_POST['show_add_to_cart'] : '';

        if ($show_rating == 'off') {
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        }
        if ($show_price == 'off') {
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        }
        if ($show_excerpt == 'on') {
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8);
        }
        if ($show_add_to_cart == 'on') {
            add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9);
        }

        add_action( 'woocommerce_shop_loop_item_title', array( 'db_filter_loop_code', 'product_details_wrapper_start' ), 0 );
        add_action( 'woocommerce_after_shop_loop_item', array( 'db_filter_loop_code', 'product_details_wrapper_end' ), 10 );

        add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_filter_loop_code', 'product_image_wrapper_start' ), 0 );
        add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_filter_loop_code', 'product_image_wrapper_end' ), 20 );
    }

    if ( isset( $args['product_price'] ) && $args['product_price'] != '' ) {
        $price_value = (explode(';', $args['product_price']));

        if (count($price_value) == 1) {
            $min_filter_price = 0;
            $max_filter_price = floatval($price_value[0]);
        }
        else {
            $max_filter_price = floatval($price_value[1]);
            $min_filter_price = floatval($price_value[0]);
        }

        if ( function_exists('wc_tax_enabled') && wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
            $tax_class = apply_filters('woocommerce_price_filter_widget_tax_class', ''); // Uses standard tax class.
            $tax_rates = WC_Tax::get_rates($tax_class);

            if ($tax_rates) {
                $min_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($min_filter_price, $tax_rates));
                $max_filter_price -= WC_Tax::get_tax_total(WC_Tax::calc_inclusive_tax($max_filter_price, $tax_rates));
            }
        }

        $price_filter_var['is_filter'] = true;
        $price_filter_var['min_price'] = $min_filter_price;
        $price_filter_var['max_price'] = $max_filter_price;
    }

    query_posts($args);

    $wp_query->is_tax = false;

    if (!isset($wp_archive_query)) {
        $wp_archive_query = $wp_query;
    }

    if (have_posts()):
        global $wp_query, $wpdb, $post, $woocommerce, $current_in_archive_loop;

        $current_in_archive_loop = '';

        // run the loop
        do_action('woocommerce_before_shop_loop');

        $marker_layout_content = '';
        if ( $marker_layout != 'none' ) {
            $marker_layout_content = get_post_field( 'post_content', $marker_layout );
        }

        while( have_posts() ):
            the_post();
            setup_postdata($post);

            if ($has_map == 'on' && $dmach_map_acf !== "none" && in_array($dmach_post_type, $posttype) && $map_all_posts == 'off') {
                $address_data = get_field($dmach_map_acf);
                if (empty($address_data)) {
                    if ( isset( $address_filter_var['address_field'] ) && !empty( $address_filter_var['address_field'] ) ) {
                        $address_data = get_post_meta(get_the_ID() , $address_filter_var['address_field'], true);
                    }                        
                }
                
                if ( !empty( $address_data ) ) {
                    $map_array[] = $address_data;   
                    if ($marker_layout == 'none') {
                        $map_infoview_content = get_the_title();
                    } else {
                        $map_infoview_content = apply_filters( 'the_content', $marker_layout_content );
                    }

                    $map_infoview_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ml_${1}_${2}_tb_body', $map_infoview_content);
                    $map_infoview_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ml_${1}_${2}${3}', $map_infoview_content);

                    $map_array[count($map_array) - 1]['infoview'] = $map_infoview_content;
                    $map_array[count($map_array) - 1]['title'] = get_the_title();
                }                    
            }

            if (class_exists('woocommerce') && (in_array('product', $posttype) || in_array('product_variation', $posttype))) {

                global $product;

                $post_link = get_permalink(get_the_ID());
                $product_id = get_the_ID();

                if ($layoutid != 'none') {

                    if ($gridstyle == "masonry") {
                        $grid_class = "grid-item";
                    } else {
                        $grid_class = "grid-col";
                    }

                    echo '<li class="' . esc_attr($grid_class) . ' ' . esc_attr(implode(" ", wc_get_product_class('', $product_id))) . ' ">';
?>
                <div class="grid-item-cont">
                <?php
                    if ($link_whole_gird == "on") {
?>
                <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr($post_link) ?>">
<?php
                    }
                    do_action('de_ajaxfilter_before_shop_loop_item');

                    $product_content = apply_filters('the_content', get_post_field('post_content', wp_kses_post($layoutid)));
                    if(isset($page_ind)){
$product_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}_tb_body', $product_content);
}
                    $product_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $product_content);
                    $product_content = preg_replace('/et_pb_de_mach_([a-z|_]+)_(\d+)( |")/', 'et_pb_de_mach_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $product_content);

                    echo et_core_esc_previously($product_content);

                    do_action('de_ajaxfilter_after_shop_loop_item');

                    if ($link_whole_gird == "on") {
?>
                </div>  
<?php
                    }
?>
                </div>
<?php
                    echo '</li>';
                } else {
                    wc_get_template_part('content', 'product');
                }
            } else {
                $post_id = $post->ID;

                $terms = wp_get_object_terms($post_id, get_object_taxonomies($posttype));

                $terms_array = array();
                foreach ($terms as $term) {
                    $terms_array[] = $term->taxonomy . '-' . $term->slug;
                }
                $terms_string = implode(" ", $terms_array);
                $current_in_archive_loop = 'ajax_loadmore';
                if ($gridstyle == "masonry") {
?>
    <div class="grid-item <?php echo esc_attr($terms_string) ?> post_id_<?php echo esc_html($post_id) ?>">
        <div class="grid-item-cont">
<?php
                } else {
?>
    <div class="grid-col <?php echo esc_attr($terms_string) ?> post_id_<?php echo esc_html($post_id) ?>">
        <div class="grid-item-cont">
<?php
                }

                if ($link_whole_gird == "on") {
                    $post_link = get_permalink(get_the_ID());
                    if ($link_wholegrid_external == "on") {
                        $acf_get = get_field_object($link_wholegrid_external_acf);
                        $post_link = $acf_get['value'];
                    }
?>
                <div class="bc-link-whole-grid-card" data-link-url="<?php echo esc_attr($post_link) ?>">
<?php
                }

                $product_content = apply_filters('the_content', get_post_field('post_content', wp_kses_post($layoutid)));
                if(isset($page_ind)){
$product_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}_tb_body', $product_content);
}
                $product_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $product_content);
                $product_content = preg_replace('/et_pb_de_mach_([a-z|_]+)_(\d+)( |")/', 'et_pb_de_mach_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $product_content);

                echo et_core_esc_previously($product_content);

                if ($link_whole_gird == "on") {
?>
                </div>
<?php
                }
?>
        </div>
    </div>

<?php
            }
        endwhile;

        $current_in_archive_loop = '';

    endif;

    $posts = ob_get_contents();
    ob_end_clean();

    $after_post = '';
    $position_class = '';
    ob_start();
    if ($resultcount == "on") {
        if (!(class_exists('woocommerce') && (in_array('product', $posttype) || in_array('product_variation', $posttype)))) {
            $position_class = 'result_count_' . $countposition;
            echo '<p class="divi-filter-result-count ' . esc_attr($position_class) . '">';
            if (isset($page_ind) && $wp_query->max_num_pages == $page_ind) {
                printf(esc_html__('Showing all %d results', $domain_name) , $wp_query->found_posts);
            } else {
                printf(esc_html__('Showing 1-%d of %d results', $domain_name) , (($page_ind - 1) * $postnumber + $wp_query->post_count) , $wp_query->found_posts);
            }
            echo '</p>';
        }
    }

    if (isset($page_ind) && $wp_query->max_num_pages > $page_ind && $is_loadmore == 'on') {
?>
        <div class="dmach-loadmore et_pb_button <?php echo esc_attr($position_class); ?>" data-btntext="<?php echo esc_attr($loadmoretext) ?>" data-btntext_loading="<?php echo esc_attr($loadmoretextloading) ?>" data-icon="<?php echo esc_attr($loadmore_icon) ?>"><?php echo esc_html($loadmoretext) ?></div>
<?php
    }

    $after_post = ob_get_contents();
    ob_end_clean();

    ob_start();
    if ($resultcount == "on") {
        if (class_exists('woocommerce') && (in_array('product', $posttype) || in_array('product_variation', $posttype))) {
            //if ( $wp_query->max_num_pages == $page_ind ) {
            //printf( __('Showing all %d results', 'divi-filter'), $wp_query->found_posts );
            //}else {
            //printf( __('Showing 1-%d of %d results', 'divi-filter'), (($page_ind - 1) * $postnumber + $wp_query->post_count), $wp_query->found_posts );
            //printf( __('Showing %1$d&ndash;%2$d of %3$d result', 'woocommerce'), (($current_page - 1) * $posts_number + 1), (($current_page - 1) * $posts_number + $wp_query->post_count), $wp_query->found_posts );
            printf(_nx('Showing %d-%d of %d result', 'Showing %d-%d of %d results', $wp_query->found_posts, 'with first and last result', $domain_name) , 1, (($page_ind - 1) * $postnumber + $wp_query->post_count) , $wp_query->found_posts);
            //}
            
        }
    }

    $bc_result_count = ob_get_contents();
    ob_end_clean();

    ob_start();
    // retrieve the styles for the modules
    $internal_style = ET_Builder_Element::get_style();
    // reset all the attributes after we retrieved styles
    ET_Builder_Element::clean_internal_modules_styles(false);
    $et_pb_rendering_column_content = false;

    // append styles
    if ($internal_style) {
?>
    <div class="df-loadmore-inner-styles">
<?php
        $cleaned_styles = str_replace("body.et-db #page-container #et-boc .et-l .et_pb_section ", "", $internal_style);
        $cleaned_styles = str_replace("body.et-db #page-container #et-boc .et-l ", "", $cleaned_styles);
        $cleaned_styles = str_replace("body.woocommerce.et-db #et-boc .et-l ", "", $cleaned_styles);
        $cleaned_styles = str_replace("body #page-container .et_pb_section ", "", $cleaned_styles);
        $cleaned_styles = str_replace(".et-db #et-boc .et-l .et_pb_section ", "", $cleaned_styles);
        $cleaned_styles = str_replace(".et-db #et-boc .et-l ", "", $cleaned_styles);
        $temp_styles = $cleaned_styles;
        $temp_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}_tb_body', $temp_styles);
        $temp_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $temp_styles);
        $temp_styles = preg_replace('/et_pb_de_mach_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'et_pb_de_mach_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $temp_styles);
        $cleaned_styles = preg_replace('/\.et_pb_([a-z|_]+)_(\d+)_tb_body/', 'body.et-db #et-boc .et-l .et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}_tb_body', $cleaned_styles);
        $cleaned_styles = preg_replace('/\.et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'body.et-db #et-boc .et-l .et_pb_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $cleaned_styles);
        $cleaned_styles = preg_replace('/\.et_pb_de_mach_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'body.et-db #et-boc .et-l .et_pb_de_mach_df_ajax_filter_${1}' . $page_ind . '_${2}${3}', $cleaned_styles);
        $cleaned_styles = $temp_styles . ' ' . $cleaned_styles;

        printf('<style type="text/css" class="dmach_ajax_inner_styles">
      %1$s
    </style>', et_core_esc_previously($cleaned_styles));
?>
    </div>
<?php
    }

    $css_output = ob_get_contents();
    ob_end_clean();

    $return = array(
        'posts' => $posts,
        'after_post' => $after_post,
        'css_output' => $css_output
    );

    if ($has_map == 'on' && $dmach_map_acf !== "none" && in_array($dmach_post_type, $posttype)) {
        if (empty($map_array)) {
            $map_array = array();
        }
        $return['map_data'] = $map_array;
    }

    if ($bc_result_count != '') {
        $return['bc_result_count'] = $bc_result_count;
    }

    $wp_archive_query = null;

    wp_send_json($return);

    die;
}

add_action('wp_ajax_divi_filter_loadmore_ajax_handler', 'divi_filter_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_divi_filter_loadmore_ajax_handler', 'divi_filter_loadmore_ajax_handler');

function divi_filter_get_count_ajax_handler() {

    if (!check_ajax_referer('filter_object', 'security')) {
        wp_send_json_error('Nonce verification failed');
    }
    
    ob_start();

    $start_time = microtime( true );

    global $filter_count_params, $price_filter_var;

    $filter_count_params = array(
        'taxonomy'  => array(),
        'meta'      => array()
    );

    // prepare our arguments for the query
    if (isset($_POST['query'])) {
        $args = json_decode(stripslashes($_POST['query']) , true); //phpcs:ignore
        
    }

    if (isset($args['offset']) && $args['offset'] != 0) {

    } else {
        unset($args['paged']);
        $args['posts_per_page'] = 99999999;
    }

    if (isset($_POST['filters'])) {
        $filter_options = explode(',', $_POST['filters']);
    }

    if (isset($_POST['filter_types'])) {
        $filter_types = explode(',', $_POST['filter_types']);
    }

    if (isset($_POST['filter_parents'])) {
        $filter_parents = explode(',', $_POST['filter_parents']);
    }

    if (isset($_POST['filter_has_current_tax_term'])) {
        $filter_has_current_tax_term = $_POST['filter_has_current_tax_term'];
    }

    $has_default_tax = !empty($_POST['has_default_tax']) ? $_POST['has_default_tax'] : false;

    $current_taxonomy = $current_term = '';

    if ($has_default_tax == 'true') {
        $current_taxonomy = !empty($args['taxonomy']) ? $args['taxonomy'] : '';
        $current_term = !empty($args['term']) ? $args['term'] : '';
    }

    if ( isset( $args['product_price'] ) && $args['product_price'] != '' ) {
        $price_filter = explode(';', $args['product_price']);
        if ( is_array($price_filter) && sizeof( $price_filter ) > 1 ) {
            $price_filter_var['is_filter'] = true;
            $price_filter_var['min_price'] = $price_filter[0];
            $price_filter_var['max_price'] = $price_filter[1];
        }
    }

    $result = array();
    $result_ids = array();
    $origin_args = $args;
    $origin_tax_values = array();
    $origin_meta_values = array();

    $cpt_taxonomies = get_object_taxonomies( $args['post_type'] );

    if(isset($filter_options)){
$filter_options_a = array_unique( $filter_options );
}

    foreach ($filter_options_a as $filter_ind => $option) {
        $filter_key = '';

        $result[$option] = array();
        $result_ids[$option] = array();

        if ( is_array($args['post_type'] ) ) {
            foreach ( $args['post_type'] as $p_type ) {
                if ( $p_type != 'post'  ){
                    if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) && $option == 'category' ){
                        $filter_key = 'cat';
                    } else if ( ( $option == $p_type . '_category' ) || ( $option == $p_type . '_tag' ) || in_array( $option, $cpt_taxonomies ) ) {
                        $filter_key = 'tax_query';
                        }
                } else if ( $p_type == 'post' ) {
                    if ( $option == 'category' ){
                        $filter_key = 'cat';
                    }else if ( $option == 'post_tag' ) {
                        $filter_key = 'post_tag';
                    }else if ( in_array($option, $cpt_taxonomies) ) {
                        $filter_key = 'tax_query';
                    }
                }
            }
        } else {
            if ( $args['post_type'] != 'post'  ){
                if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) && $option == 'category' ){
                    $filter_key = 'cat';
                } else if ( ( $option == $args['post_type'] . '_category' ) || ( $option == $args['post_type'] . '_tag' ) || in_array( $option, $cpt_taxonomies ) ) {
                    $filter_key = 'tax_query';
                }
            } else if ( $args['post_type'] == 'post' ) {
                if ( $option == 'category' ){
                    $filter_key = 'cat';
                }else if ( $option == 'post_tag' ) {
                    $filter_key = 'post_tag';
                }else if ( in_array($option, $cpt_taxonomies) ) {
                    $filter_key = 'tax_query';
                }
            }
        }

        if ( in_array( $filter_key, array('cat', 'post_tag', 'tax_query') ) ) {
            $filter_count_params['taxonomy'][] = $option;
            if ( $filter_key == 'cat' ) {
                if ( !isset( $origin_tax_values['category'] ) ) {
                    $origin_tax_values['category'] = array();
                }
                if ( !empty( $args['cat'] ) ) {
                    $origin_tax_values['category'][] = $args['cat'];
                } else if ( !empty( $args['category_name'] ) ) {
                    $origin_tax_values['category'][] = $args['category_name'];
                }
                //unset( $args['cat'] );
                //unset( $args['category_name']);
            }

            if ( $filter_key == 'post_tag' ) {
                if ( !isset( $origin_tax_values['post_tag'] ) ) {
                    $origin_tax_values['post_tag'] = array();
                }
                if ( !empty( $args['tag'] ) ) {
                    $origin_tax_values['post_tag'][] = $args['tag'];
                } else if ( !empty( $args['tag_slug__in'] ) ) {
                    $origin_tax_values['post_tag'][] = $args['tag_slug__in'];
                }
                //unset( $args['tag'] );
                //unset( $args['tag_slug__in'] );
            }

            if ( isset( $args['taxonomy'] ) && $args['taxonomy'] == $option ){

                if ( !isset( $origin_tax_values[$option] ) ) {
                    $origin_tax_values[$option] = array();
                }

                if ( !empty( $args['term'] ) ) {
                    $origin_tax_values[$option][] = $args['term'];
                }
                //unset( $args['taxonomy'] );
                //unset( $args['term'] );
            }

            if ( isset( $args['tax_query'] ) && is_array( $args['tax_query'] ) ) {
                foreach ( $args['tax_query'] as $key => $tax_query) {
                    if ( isset( $tax_query['taxonomy'] ) && $tax_query['taxonomy'] == $option ){
                        if ( isset( $origin_tax_values[$option] ) ) {
                            $origin_tax_values[$option][] = $tax_query;    
                        } else {
                            $origin_tax_values[$option] = array( $tax_query );
                        }
                        //unset( $args['tax_query'][$key]);
                    }else if ( is_array( $tax_query ) && !isset( $tax_query['taxonomy'] ) ){
                        foreach( $tax_query as $subkey => $tax_subquery ) {
                            if ( isset( $tax_subquery['taxonomy'] ) && $tax_subquery['taxonomy'] == $option ){
                                if ( isset( $origin_tax_values[$option] ) ) {
                                    $origin_tax_values[$option][] = $tax_query;    
                                } else {
                                    $origin_tax_values[$option] = array( $tax_query );
                                }

                                //unset( $args['tax_query'][$key]);
                            }
                        }
                    }
                }
            }
        } else if ( $option != 'product_rating' ) {
            $meta_name = $option;

            if ( function_exists( 'get_field_object' ) ) {
            $acf_obj = get_field_object($option);
                $meta_name = $acf_obj['name'];
            }

            $filter_count_params['meta'][] = $meta_name;

            if ( isset( $args['meta_query'] ) ){
                foreach ( $args['meta_query'] as $key => $meta_query) {
                    if(isset($filter_types)){
if ( $filter_types[$filter_ind] == 'single' ){
                        if (isset($meta_query['key'])) {
                            if ( $meta_query['key'] == $meta_name ){
                                if ( isset( $origin_meta_values[$meta_name] ) ) {
                                    $origin_meta_values[$meta_name][] = $meta_query;
                                } else {
                                    $origin_meta_values[$meta_name] = array( $meta_query );
                                }
                                //unset( $args['meta_query'][$key] );
                            }
                        }
}else{
                        if ( isset( $meta_query['key'] ) && $meta_query['key'] == $meta_name ){
                            if ( isset( $origin_meta_values[$meta_name] ) ) {
                                $origin_meta_values[$meta_name][] = $meta_query;
                            } else {
                                $origin_meta_values[$meta_name] = array( $meta_query );
                            }
                            //unset( $args['meta_query'][$key] );
                        }else if ( is_array( $meta_query ) && !isset( $meta_query['key'] ) ){
                            foreach( $meta_query as $subkey => $meta_subquery ) {
                                if ( isset( $meta_subquery['key'] ) && $meta_subquery['key'] == $meta_name ){
                                    if ( isset( $origin_meta_values[$meta_name] ) ) {
                                        $origin_meta_values[$meta_name][] = $meta_query;
                                    } else {
                                        $origin_meta_values[$meta_name] = array( $meta_query );
                                    }
                                    //unset( $args['meta_query'][$key] );
                                }
                            }
                        }
}
}
                }
            }
        }
    }

    if(isset($filter_has_current_tax_term)){
if ( $filter_has_current_tax_term == 'false' ) {
        if ( $current_taxonomy != '' && $current_term != '' ) {
            $args['taxonomy'] = $current_taxonomy;
            $args['term'] = $current_term;
        } else if ( $current_taxonomy != '' ) {
            /*if ( $args['taxonomy'] == $current_taxonomy ) {
                unset( $args['taxonomy'] );
                unset( $args['term'] );
                            }
            foreach ($args['tax_query'] as $key => $meta) {
                if ( is_array( $meta ) && !empty( $meta['taxonomy'] ) && ( $current_taxonomy == $meta['taxonomy'] ) ){
                    unset( $args['tax_query'][$key] );
                }else if ( is_array( $meta ) ) {
                    foreach ($meta as $subkey => $subMeta) {
                        if ( is_array( $subMeta ) && !empty( $subMeta['taxonomy'] ) && ( $current_taxonomy == $subMeta['taxonomy'] ) ){
                            unset( $args['tax_query'][$key] );
                        }
                    }
                }
            }*/
        }
}
}

    add_filter( 'posts_clauses', function( $clauses, $w_query ) {
        global $wpdb, $filter_count_params;

        $query_vars = $w_query->tax_query->queried_terms;

        if ( !empty( $filter_count_params['taxonomy'] ) ) {
            foreach ( $filter_count_params['taxonomy'] as $key => $tax_name ) {
                $tax_name_for_sql = str_replace('-', '_',  $tax_name );
                $subquery = "
                    (
                    SELECT posts.ID, GROUP_CONCAT( f_wt{$key}.slug SEPARATOR ',' ) as {$tax_name_for_sql}
                      FROM {$wpdb->posts} posts 
                      LEFT JOIN {$wpdb->term_relationships} f_wtr{$key} ON f_wtr{$key}.object_id = posts.ID
                     INNER JOIN {$wpdb->term_taxonomy} f_wtt{$key} ON f_wtr{$key}.term_taxonomy_id = f_wtt{$key}.term_taxonomy_id 
                     INNER JOIN {$wpdb->terms} f_wt{$key} ON f_wtt{$key}.term_id = f_wt{$key}.term_id
                     WHERE f_wtt{$key}.taxonomy = '{$tax_name}'
                     GROUP BY posts.ID
                    ) as {$tax_name_for_sql}_tbl
                ";
                $clauses['join'] = $clauses['join'] . " LEFT JOIN " . $subquery . " ON {$wpdb->posts}.ID = {$tax_name_for_sql}_tbl.ID";
                $clauses['fields'] = $clauses['fields'] . ", {$tax_name_for_sql}_tbl.{$tax_name_for_sql} as {$tax_name_for_sql}";
                }
            }

        if ( !empty( $filter_count_params['meta'] ) ) {
            foreach ( $filter_count_params['meta'] as $key => $meta_name ) {
                $meta_name_for_sql = str_replace('-', '_',  $meta_name );
                $clauses['join'] = $clauses['join'] . " LEFT JOIN {$wpdb->postmeta} f_wpm{$key} ON {$wpdb->posts}.ID = f_wpm{$key}.post_id AND f_wpm{$key}.meta_key = '{$meta_name}'";
                $clauses['fields'] = $clauses['fields'] . ", f_wpm{$key}.meta_value as {$meta_name_for_sql}";
                }
            }

        return $clauses;
    }, 119, 2);

    $query_start_time = microtime(true);

    $filter_posts = new WP_Query( $args );

    $query_end_time = microtime( true );

    remove_all_filters( 'posts_clauses', 119 );
    $price_filter_var['is_filter'] = false;

    foreach ($filter_options as $filter_ind => $option) {
        $origin_option = $option;
        if ( in_array( $option, $filter_count_params['taxonomy'] ) ) {
            $term_args = array( 'taxonomy' => $option, 'hide_empty' => false );
            if(isset($filter_parents)){
if ( $filter_parents[$filter_ind] != '' ) {
                $parent_term = get_term_by( 'slug', $filter_parents[$filter_ind], $option );
                $term_args['child_of'] = $parent_term->term_id;
}
}
            $terms = get_terms( $term_args );
            $term_slugs = wp_list_pluck( $terms, 'slug' );
            $term_ids = wp_list_pluck( $terms, 'term_id' );
            $term_parents = wp_list_pluck( $terms, 'parent' );
            $term_parents = array_combine( $term_slugs, $term_parents );

            $term_ind = 0;
            $terms_array = array();
            foreach ( $terms as $term ) {
                if ( !isset( $result[$option][$term_slugs[$term_ind]] ) ) {
                    $result[$option][$term_slugs[$term_ind]] = 0;
                    $result_ids[$option][$term_slugs[$term_ind]] = array();    
                }
                $terms_array[ $term->term_id ] = $term;
                $term_ind++;
            }
            
        } else {
             if ( function_exists( 'get_field_object' ) ) {
                $acf_obj = get_field_object($option);
                $acf_choices = $acf_obj['choices'];
                $option = $acf_obj['name'];

                foreach ( $acf_choices as $choice_val => $choice ) {
                    $result[$origin_option][$choice_val] = 0;
                    $result_ids[$origin_option][$choice_val] = array();
                }
            }
        }

        if ( $filter_posts->posts ) {
            foreach( $filter_posts->posts as $c_post ) {
                $in_filter = true;
                foreach( $origin_tax_values as $tax_key => $tax_array ) {
                    if ( $tax_key == $option ) {
                        continue;
                    }

                    if ( $in_filter == false ) {
                        break;
                    }

                    $tax_key_for_sql = str_replace('-', '_',  $tax_key );

                    $current_post_tax_terms = explode(',', $c_post->{$tax_key_for_sql});

                    foreach ( $tax_array as $sub_key => $tax_val ) {
                        if ( is_array( $tax_val ) ) {
                            if ( isset( $tax_val['taxonomy'] ) && $tax_val['taxonomy'] == $tax_key ) {
                                if ( !is_array( $tax_val['terms'] ) ) {
                                    $tax_val['terms'] = explode(',', $tax_val['terms'] );
                                }
                                $check_arr = array_intersect( $current_post_tax_terms, $tax_val['terms'] );
                                if ( $tax_val['operator'] == 'IN' ) {
                                    if ( empty( $check_arr ) ) {
                                        $in_filter = false;
                                        break;
                                    }
                                } else if ( $tax_val['operator'] == 'NOT IN' ) {
                                    if ( !empty( $check_arr ) ) {
                                        $in_filter = false;
                                        break;
                                    }
                                }
                            } else if ( isset( $tax_val['relation'] ) ){
                                if ( strtolower( $tax_val['relation'] ) == 'or' )  {
                                    $sub_condition = false;
                                    foreach( $tax_val as $tax_sub_key => $sub_value ) {
                                        if ( $tax_sub_key == 'relation' ) {
                                            continue;
                                        }
                                        if ( isset( $sub_value['taxonomy'] ) && $sub_value['taxonomy'] == $tax_key ) {
                                            if ( !is_array( $sub_value['terms'] ) ) {
                                                $sub_value['terms'] = explode(',', $sub_value['terms'] );
                                            }
                                            $check_arr = array_intersect( $current_post_tax_terms, $sub_value['terms']  );

                                            if ( $sub_value['operator'] == 'IN' ) {
                                                if ( !empty( $check_arr ) )  {
                                                    $sub_condition = true;
                                                    break;
                                                }
                                            } else if ( $sub_value['operator'] == 'NOT IN') {
                                                if ( empty( $check_arr ) )  {
                                                    $sub_condition = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                } else if (strtolower( $tax_val['relation']) == 'and' ) {
                                    $sub_condition = true;
                                    foreach( $tax_val as $tax_sub_key => $sub_value ) {
                                        if ( $tax_sub_key == 'relation' ) {
                                            continue;
                                        }
                                        if ( isset( $sub_value['taxonomy'] ) && $sub_value['taxonomy'] == $tax_key ) {
                                            if ( !is_array( $sub_value['terms'] ) ) {
                                                $sub_value['terms'] = explode(',', $sub_value['terms'] );
                                            }
                                            $check_arr = array_intersect( $current_post_tax_terms, $sub_value['terms']  );
                                            if ( $sub_value['operator'] == 'IN' ) {
                                                if ( empty( $check_arr ) )  {
                                                    $sub_condition = false;
                                                    break;
                                                }
                                            } else if ( $sub_value['operator'] == 'NOT IN' ) {
                                                if ( !empty( $check_arr ) )  {
                                                    $sub_condition = false;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }

                                if(isset($sub_condition)){
if ( !$sub_condition ) {
                                    $in_filter = false;
                                    break;
}
}
                            }
                        } else {
                            if ( !in_array( $tax_val, $current_post_tax_terms ) ) {
                                $in_filter = false;
                                break;
                            }
                        }
                    }
                }

                if ( $in_filter == true ) {
                    foreach ( $origin_meta_values as $meta_key => $meta_array ) {
                        if ( $meta_key == $option ) {
                            continue;
                        }
                        if ( $in_filter == false ) {
                            break;
                        }

                        $meta_key_for_sql = str_replace('-', '_',  $meta_key );

                        $current_post_meta_value = $c_post->{$meta_key_for_sql};
                        $current_meta_value_array = maybe_unserialize( $c_post->{$meta_key_for_sql} );

                        if ( !is_array( $current_meta_value_array ) ) {
                            $current_meta_value_array = array( $current_meta_value_array );
                        }

                        foreach ( $meta_array as $sub_key => $meta_val ) {
                            if ( isset( $meta_val['key'] ) && $meta_val['key'] == $meta_key ) {
                                if ( !is_array( $meta_val['value'] ) ) {
                                    $c_meta_val = str_replace('"', '', $meta_val['value']);    
                                } else if ( count( $meta_val['value']) == 1 ) {
                                    $c_meta_val = str_replace('"', '', $meta_val['value'][0]);
                                }
                                
                                if(isset($c_meta_val)){
if ( !in_array( $c_meta_val, $current_meta_value_array )) {
                                    $in_filter = false;
                                    break;
}
}
                            } else if ( isset( $meta_val['relation'] ) ){
                                if ( strtolower( $meta_val['relation'] ) == 'or' )  {
                                    $sub_condition = false;
                                    foreach( $meta_val as $meta_sub_key => $sub_value ) {
                                        if ( $meta_sub_key == 'relation' ) {
                                            continue;
                                        }
                                        if ( isset( $sub_value['key'] ) && $sub_value['key'] == $meta_key ) {
                                            if ( !is_array( $sub_value['value'] ) ) {
                                                $c_meta_val = str_replace('"', '', $sub_value['value']);
                                            } else if ( count( $sub_value['value'] ) == 1 ) {
                                                $c_meta_val = str_replace('"', '', $sub_value['value'][0]);
                                            }
                                            
                                            if(isset($c_meta_val)){
if ( in_array( $c_meta_val, $current_meta_value_array ) )  {
                                                $sub_condition = true;
                                                break;
}
}
                                        }
                                    }
                                } else if (strtolower( $meta_val['relation']) == 'and' ) {
                                    $sub_condition = true;
                                    foreach( $meta_val as $meta_sub_key => $sub_value ) {
                                        if ( $meta_sub_key == 'relation' ) {
                                            continue;
                                        }
                                        if ( isset( $sub_value['key'] ) && $sub_value['key'] == $meta_key ) {
                                            if ( !is_array( $sub_value['value'] ) ) {
                                                $c_meta_val = str_replace('"', '', $sub_value['value']);
                                            } else if ( count( $sub_value['value'] ) == 1 ) {
                                                $c_meta_val = str_replace('"', '', $sub_value['value'][0]);
                                            }
                                            if(isset($c_meta_val)){
if ( !in_array( $c_meta_val, $current_meta_value_array ) )  {
                                                $sub_condition = false;
                                                break;
}
}
                                        }
                                    }
                                }

                                if(isset($sub_condition)){
if ( !$sub_condition ) {
                                    $in_filter = false;
                                    break;
}
}
                            }
                        }
                    }
                }

                if ( $in_filter == true ) {
                    $option_for_sql = str_replace( '-', '_', $option );
                    $option_values = $c_post->{$option_for_sql};
                    if(isset($filter_parents)){
if ( $filter_parents[$filter_ind] != '' ) {
                        $parent_option = $filter_parents[$filter_ind];

                        if ( in_array( $option, $filter_count_params['taxonomy'] ) ) {
                            $tax_terms = explode( ',', $option_values );
                            if ( in_array( $parent_option, $tax_terms ) || !empty( array_intersect( $term_slugs, $tax_terms ) ) ) {
                                if ( isset( $result[$origin_option]['all' . '_' . $parent_option ] ) ) {
                                    if ( !in_array( $c_post->ID, $result_ids[$origin_option]['all_' . $parent_option] ) ){
                                        $result[$origin_option]['all_' . $parent_option ]++;
                                        $result_ids[$origin_option]['all_' . $parent_option ][] = $c_post->ID;
                }
                                } else {
                                    $result[$origin_option]['all_' . $filter_parents[$filter_ind] ] = 1;
                                    $result_ids[$origin_option]['all_' . $parent_option ][] = $c_post->ID;
                                }
                            }
                        }
} else {
                        if ( isset( $result[$origin_option]['all'] ) ) {
                            if ( !in_array( $c_post->ID, $result_ids[$origin_option]['all'] ) ) {
                                $result[$origin_option]['all']++;
                                $result_ids[$origin_option]['all'][] = $c_post->ID;
        }
                        } else {
                            $result[$origin_option]['all'] = 1;
                            $result_ids[$origin_option]['all'][] = $c_post->ID;
                        }
}
}

                    if ( in_array( $option, $filter_count_params['taxonomy'] ) ) {
                        $tax_terms = explode( ',', $option_values );
                        foreach( $tax_terms as $c_term ) {
                            if ( isset( $result[$option][$c_term] ) && !in_array( $c_post->ID, $result_ids[$option][$c_term] ) ) {
                                $result[$option][$c_term]++;
                                $result_ids[$option][$c_term][] = $c_post->ID;
                            }

                            $p_term_id = isset($term_parents[$c_term])?$term_parents[$c_term]:0;
                            $c_cond = false;
                            if ( $p_term_id != 0 && isset( $terms_array[$p_term_id] ) && $terms_array[$p_term_id]->slug != $filter_parents[$filter_ind] ) {
                                while ( !$c_cond ) {
                                    $p_term_slug = $terms_array[$p_term_id]->slug;
                                    if ( isset( $result[$option][$p_term_slug] ) && !in_array( $c_post->ID, $result_ids[$option][$p_term_slug] ) ) {
                                        $result[$option][$p_term_slug]++;
                                        $result_ids[$option][$p_term_slug][] = $c_post->ID;
                                    }
                                    if(isset($term_parents)){
$p_term_id = $term_parents[ $p_term_slug ];
}
                                    $c_cond = ($p_term_id == 0) || !isset( $terms_array[$p_term_id] ) || ($terms_array[$p_term_id]->slug == $filter_parents[$filter_ind]);
                                }    
                            }
                        }
                    } else {
                        $meta_values = maybe_unserialize($option_values);
                        if ( is_array( $meta_values ) ) {
                            foreach( $meta_values as $m_val ) {
                                if ( isset( $result[$origin_option][$m_val]) && !in_array( $c_post->ID, $result_ids[$origin_option][$m_val] ) ) {
                                    $result[$origin_option][$m_val]++;
                                    $result_ids[$origin_option][$m_val][] = $c_post->ID;
                                }
                            }
                        } else {
                            if ( isset( $result[$origin_option][$meta_values]) && !in_array( $c_post->ID, $result_ids[$origin_option][$meta_values] ) ) {
                                $result[$origin_option][$meta_values]++;
                                $result_ids[$origin_option][$meta_values][] = $c_post->ID;
                            }
                        }
                    }
                }
            }
        }
    }

    $end_time = microtime( true );
    $duration = $end_time - $start_time;

    wp_send_json($result);

    die;
}

add_action('wp_ajax_divi_filter_get_count_ajax_handler', 'divi_filter_get_count_ajax_handler');
add_action('wp_ajax_nopriv_divi_filter_get_count_ajax_handler', 'divi_filter_get_count_ajax_handler');

function divi_filter_get_post_modal_ajax_handler() {

    global $post;

    // prepare our arguments for the query
    if (isset($_POST['post_ids'])) {
        $post_ids = explode(',', $_POST['post_ids']);
    }
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $modal_layout = isset($_POST['modal_layout']) ? $_POST['modal_layout'] : '';
    $modal_postype = isset($_POST['modal_postype']) ? $_POST['modal_postype'] : '';

    if (isset($modal_postype)) {
        if ($modal_postype == "auto") {

        } else {
            $post_type = $modal_postype;
        }
    }

    $args = array(
        'post_type' => $post_type,
        'post__in' => $post_ids ?? '',
        'posts_per_page' => - 1
    );

    query_posts($args);

    global $current_in_archive_loop;

    $current_in_archive_loop = '';

    $result = array();

    if (have_posts()):
        // run the loop
        while (have_posts()):
            $current_in_archive_loop = 'ajax_modal';
            the_post();
            $modal_content = apply_filters('the_content', get_post_field('post_content', $modal_layout));

            /*$modal_content = preg_replace( '/et_pb_section_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_section_${1}_tb_body', $modal_content );
            $modal_content = preg_replace( '/et_pb_row_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_row_${1}_tb_body', $modal_content );
            $modal_content = preg_replace( '/et_pb_column_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_column_${1}_tb_body', $modal_content );
            $modal_content = preg_replace( '/et_pb_section_(\d+)( |")/', 'et_pb_dmach_ajax_modal_section_${1}${2}', $modal_content );
            $modal_content = preg_replace( '/et_pb_row_(\d+)( |")/', 'et_pb_dmach_ajax_modal_row_${1}${2}', $modal_content );
            $modal_content = preg_replace( '/et_pb_column_(\d+)( |")/', 'et_pb_dmach_ajax_modal_column_${1}${2}', $modal_content );*/

            $modal_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_${1}_${2}_tb_body', $modal_content);
            $modal_content = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_dmach_ajax_modal_${1}_${2}${3}', $modal_content);

            $result['content']['show_modal_' . get_the_ID() ] = $modal_content;
        endwhile;
        $current_in_archive_loop = '';
    endif;

    ob_start();

    // retrieve the styles for the modules
    $internal_style = ET_Builder_Element::get_style();
    // reset all the attributes after we retrieved styles
    // ET_Builder_Element::clean_internal_modules_styles( false );
    $et_pb_rendering_column_content = false;

    // append styles
    if ($internal_style) {
?>
    <div class="dmach-modal-styles">
<?php
        $cleaned_styles = str_replace('#page-container', '#dmach-modal-wrapper', $internal_style);
        $cleaned_styles = str_replace('.et-db', '', $cleaned_styles);
        $cleaned_styles = str_replace('#et-boc .et-l', '', $cleaned_styles);
        $cleaned_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_${1}_${2}_tb_body', $cleaned_styles, -1);
        $cleaned_styles = preg_replace('/et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'et_pb_dmach_ajax_modal_${1}_${2}${3}', $cleaned_styles, -1);

        printf('<style type="text/css" class="dmach_ajax_modal_styles">
              %1$s
            </style>', et_core_esc_previously($cleaned_styles));
?>
    </div>
<?php
    }

    $css_output = ob_get_contents();
    ob_end_clean();

    $result['css_output'] = $css_output;

    wp_send_json($result);

    wp_die();

}

add_action('wp_ajax_divi_filter_get_post_modal_ajax_handler', 'divi_filter_get_post_modal_ajax_handler');
add_action('wp_ajax_nopriv_divi_filter_get_post_modal_ajax_handler', 'divi_filter_get_post_modal_ajax_handler');

function divi_filter_get_sub_category_handler() {
    $top_cat = isset($_POST['top_category']) ? $_POST['top_category'] : '0';
    $field_type = isset($_POST['field_type']) ? $_POST['field_type'] : '';
    $child_mode = isset($_POST['child_mode']) ? $_POST['child_mode'] : '';
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $cat_tag_hide_empty_dis = isset($_POST['hide_empty']) ? $_POST['hide_empty'] : '';
    $select_placeholder = isset($_POST['select_placeholder']) ? $_POST['select_placeholder'] : '';
    $cat_sub_prefix = isset($_POST['sub_prefix']) ? $_POST['sub_prefix'] : '';
    $only_show_avail = isset($_POST['show_available']) ? $_POST['show_available'] : 'off';
    $radio_all_hide = isset($_POST['radio_all_hide']) ? $_POST['radio_all_hide'] : 'off';
    $radio_select = isset($_POST['radio_select']) ? $_POST['radio_select'] : '';
    $radio_style = isset($_POST['radio_style']) ? $_POST['radio_style'] : '';
    $radio_all_text = isset($_POST['radio_all_text']) ? $_POST['radio_all_text'] : '';

    $domain_name = '';

    if (defined('DE_DB_WOO_VERSION')) {
        $domain_name = 'divi-bodyshop-woocommerce';
    } else if (defined('DE_DMACH_VERSION')) {
        $domain_name = 'divi-machine';
    } else {
        $domain_name = 'divi-filter';
    }

    if ($cat_tag_hide_empty_dis == "false") {
        $cat_args = array(
            'hide_empty' => false,
        );
    } else {
        $cat_args = array(
            'hide_empty' => true,
        );
    }

    if ($post_type == 'post') {
        $cat_key = 'category';
    } else if ($post_type == 'product' || $post_type == 'product_variation') {
        $cat_key = 'product_cat';
    } else {
        $cpt_taxonomies = get_object_taxonomies($post_type);

        if (!empty($cpt_taxonomies) && in_array('category', $cpt_taxonomies)) {
            $cat_key = 'category';
        } else {
            $ending = "_category";
            $cat_key = $post_type . $ending;
        }
    }

    $cat_args['taxonomy'] = $cat_key;

    $parent_term = get_term_by('slug', $top_cat, $cat_key);
    if ($parent_term) {
        $term_id = $parent_term->term_id;
        $cat_args['parent'] = $term_id;
    }

    if ($child_mode == 'on') {
        $get_categories = get_terms($cat_args);
    } else {
        getListTaxonomies($cat_args, $get_categories);
    }

    $num = wp_rand(100000, 999999);

    $first_parent_id = ( !empty( $get_categories) && is_array( $get_categories) )?$get_categories[0]->parent:0;
    $cat_depth = array( $first_parent_id => 0 );

    ob_start();

    if (!empty($get_categories)) {

        if ($field_type == 'select') {
?>
    <select id="<?php echo esc_attr($cat_key) . '_' . esc_attr($num); ?>" class="divi-acf et_pb_contact_select" data-filtertype="customcategory" data-field_type="select" name="<?php echo esc_attr($cat_key) . '_' . esc_attr($num); ?>" data-name="<?php echo esc_attr($cat_key); ?>">
      <option value="<?php echo esc_attr($top_cat); ?>"><?php echo esc_html($select_placeholder) ?></option>
<?php
            foreach ($get_categories as $cat):
                $parent_cat_id = $cat->parent;

                $children = get_categories(array(
                    'child_of' => $cat->term_id,
                    'taxonomy' => $cat_key,
                    'hide_empty' => false,
                    'fields' => 'ids',
                ));

                $data_type = '';

                if (!empty($children)) {
                    $data_type = 'has-child';
                }

                $prefix = '';
                if (isset($cat_depth[$parent_cat_id])) {
                    $prefix = str_repeat($cat_sub_prefix, $cat_depth[$parent_cat_id]);
                    $cat_depth[$cat->term_id] = $cat_depth[$parent_cat_id] + 1;
                }
?>
          <option id="<?php echo esc_attr($cat->term_id) . '_' . esc_attr($num); ?>" <?php echo ($data_type != '')?'data-type="' . esc_attr($data_type) . '"':''; ?> value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_attr($prefix) . esc_attr($cat->name); ?></option>
<?php
            endforeach;
?>
    </select>
<?php
        } else {
            if ($radio_select == "checkbox") {
                $checkboxtype = "divi-checkboxmulti";
            } else {
                $checkboxtype = "divi-checkboxsingle";
            }
            $filter_count = isset($_POST['filter_count']) ? $_POST['filter_count'] : '';
            $query = '';
            if ($filter_count == 'on') {
                $query = isset($_POST['query']) ? $_POST['query'] : '';
                $args = json_decode(stripslashes($query) , true);
                $tax_key = 0;
                if (isset($args['taxonomy']) && $args['taxonomy'] == $cat_key) {
                    unset($args['taxonomy']);
                    unset($args['term']);
                }

                if ($post_type == 'post') {
                    $filter_key = 'cat';
                } else if ($post_type != 'post') {
                    $filter_key = 'tax_query';
                }

                if (isset($args[$filter_key]) && is_array($args[$filter_key])) {
                    $last_key = '';
                    foreach ($args['tax_query'] as $key => $tax_query) {
                        $last_key = $key;
                        if (isset($tax_query['taxonomy']) && $tax_query['taxonomy'] == $cat_key) {
                            $tax_key = $key;
                            $original_val = $tax_query;
                            break;
                        }
                    }
                    if ($last_key != 'relation' && $tax_key == 0) {
                        $tax_key = $last_key + 1;
                    }
                } else {
                    $args['tax_query'] = array(
                        'relation' => 'AND'
                    );
                }

                $args['tax_query'][$tax_key] = array(
                    'taxonomy' => $cat_key,
                    'field' => 'slug',
                    'terms' => $top_cat
                );

                $option_query = new WP_Query($args);
                $all_count = $option_query->found_posts;

            }

            if (count($get_categories) > 0 && ($radio_select != 'checkbox') && ($radio_all_hide != 'on') && $only_show_avail == "off") {
?>
            <span class="et_pb_contact_field_radio">
              <input type="<?php echo esc_attr($radio_select) ?>" id="<?php echo esc_attr($cat_key); ?>_all_<?php echo esc_attr($num); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr($checkboxtype) ?>" value="<?php echo esc_attr($top_cat); ?>" name="<?php echo esc_attr($cat_key) . '_' . esc_attr($num); ?>" data-name="<?php echo esc_attr($cat_key); ?>" data-required_mark="required" data-field_type="radio" data-original_id="radio">
              <?php if ($radio_style == "tick_box") {
                    echo '<span class="checkmark"></span>';
                } ?>
              <label class="radio-label" data-value="<?php echo esc_attr($top_cat); ?>" for="<?php echo esc_attr($cat_key); ?>_all_<?php echo esc_attr($num); ?>" title="All"><i></i><?php echo esc_html__($radio_all_text, $domain_name); ?></label>
<?php
                if ($filter_count == 'on') {
                    echo '<span class="radio-count">' . esc_html($all_count) . '</span>';
                }
?>
            </span>
<?php
            }
            $cat_inx = 0;
            foreach ($get_categories as $cat):
                $parent_cat_id = $cat->parent;
                $prefix = '';
                $collapsible_class = '';
                /*if ( $cat_sub_collapsible == 'on' && ( $cat_inx < count($get_categories) - 1 ) && $cat->term_id == $get_categories[$cat_inx + 1]->parent ) {
                    $collapsible_class = 'is-collapsible';
                }*/
                $cat_inx++;
                if (isset($cat_depth[$parent_cat_id])) {
                    $prefix = str_repeat($cat_sub_prefix, $cat_depth[$parent_cat_id]);
                    $cat_depth[$cat->term_id] = $cat_depth[$parent_cat_id] + 1;
                }

                if ($filter_count == 'on') {
                    if(isset($tax_key)){
$args['tax_query'][$tax_key] = array(
                        'taxonomy' => $cat_key,
                        'field' => 'slug',
                        'terms' => $cat->slug
);
}

                    $option_query = new WP_Query($args);
                    $count = $option_query->found_posts;
                }

                $children = get_categories(array(
                    'child_of' => $cat->term_id,
                    'taxonomy' => $cat_key,
                    'hide_empty' => false,
                    'fields' => 'ids',
                ));

                $data_type = '';

                if (!empty($children)) {
                    $data_type = 'has-child';
                }
?>
            <span class="et_pb_contact_field_radio <?php echo esc_attr($collapsible_class); ?>">
                <input type="<?php echo esc_attr($radio_select) ?>" <?php echo ($data_type != '')?'data-type="' . esc_attr($data_type) . '"':''; ?> id="<?php echo esc_attr($cat->term_id); ?>_<?php echo esc_attr($cat->slug) . '_' . esc_attr($num); ?>" class="divi-acf input" data-filtertype="<?php echo esc_attr($checkboxtype) ?>" value="<?php echo esc_attr($cat->slug) ?>" name="<?php echo esc_attr($cat_key) . '_' . esc_attr($num); ?>" data-name="<?php echo esc_attr($cat_key); ?>" data-required_mark="required" data-field_type="<?php echo esc_attr($radio_select); ?>" data-original_id="radio">
                <?php if ($radio_style == "tick_box") {
                    echo '<span class="checkmark"></span>';
                } else {
                } ?>
                <label class="radio-label" data-value="<?php echo esc_attr($cat->slug) ?>" for="<?php echo esc_attr($cat->term_id); ?>_<?php echo esc_attr($cat->slug) . '_' . esc_attr($num); ?>" title="<?php echo esc_attr($cat->name); ?>"><i></i><?php echo esc_html($prefix) . esc_html($cat->name); ?></label>
<?php
                if ($filter_count == 'on') {
                    echo '<span class="radio-count">' . esc_html($count) . '</span>';
                }
?>
            </span>
<?php
            endforeach;
        }
    }

    $result = ob_get_clean();
    echo et_core_esc_previously($result);
    exit;
}

function getListTaxonomies($args, &$new_categories = array()) {

    $categories = get_terms($args);

    if ($categories) {
        foreach ($categories as $category) {
            $new_categories[] = $category;
            $args['parent'] = $category->term_id;
            getListTaxonomies($args, $new_categories);
        }
    }
}

add_action( 'wp_ajax_divi_filter_get_sub_category_handler', 'divi_filter_get_sub_category_handler' );
add_action( 'wp_ajax_nopriv_divi_filter_get_sub_category_handler', 'divi_filter_get_sub_category_handler' );

function ajax_marker_layout_ajax_handler(){

    global $post;
    
    $post_id_get = esc_html( $_POST['post_id'] );
    $tooltip_layout = esc_html( $_POST['tooltip_layout'] );
    $tooltip_type = esc_html( $_POST['tooltip_type'] );
    $post_type = esc_html( $_POST['post_type'] );
    $post_type = explode(',', $post_type);

    // $post   = get_post( $post_id );

    $post_id_get_array = explode( ',', $post_id_get );


    $args = array(
        'post_type' => $post_type,
        'post__in' => $post_id_get_array,
        'orderby' => 'post__in',
        'posts_per_page' => -1
    );

    query_posts( $args );

    $array_content_pass_to_js = array();

    if( have_posts() ) :
        // run the loop
        while( have_posts() ):
            the_post();
            $get_the_id = $post->ID;

            if ( $tooltip_type == 'layout' ) {
                $content = do_shortcode('[et_pb_row global_module="' . $tooltip_layout . '"][/et_pb_row]');
            } else {
                $content = do_shortcode('[' . $tooltip_layout . ']');
            }
            
            $content = preg_replace( '/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ml_${1}_${2}_tb_body', $content );
            $content = preg_replace( '/et_pb_([a-z|_]+)_(\d+)( |")/', 'et_pb_df_ml_${1}_${2}${3}', $content );
            
            $array_content_pass_to_js[$get_the_id] = $content;
        endwhile;
    endif;

    ob_start();

    // retrieve the styles for the modules
    $internal_style = ET_Builder_Element::get_style();
    // reset all the attributes after we retrieved styles
    ET_Builder_Element::clean_internal_modules_styles( false );
    $et_pb_rendering_column_content = false;

    // append styles
    if ( $internal_style ) {
?>
    <div class="dmach-map-modal-inner-styles">
<?php
    $cleaned_styles = str_replace("body.et-db #page-container #et-boc .et-l .et_pb_section ","", $internal_style);
    $cleaned_styles = str_replace("body.et-db #page-container #et-boc .et-l ","", $cleaned_styles);
    $cleaned_styles = str_replace("body #page-container .et_pb_section ","", $cleaned_styles);
    $cleaned_styles = str_replace(".et-db #et-boc .et-l .et_pb_section ","", $cleaned_styles);
    $cleaned_styles = str_replace(".et-db #et-boc .et-l ","", $cleaned_styles);
    $temp_styles = $cleaned_styles;
    $temp_styles = preg_replace( '/et_pb_([a-z|_]+)_(\d+)_tb_body/', 'et_pb_df_ml_${1}_${2}_tb_body', $temp_styles );
    $temp_styles = preg_replace( '/et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'et_pb_df_ml_${1}_${2}${3}', $temp_styles );
    $cleaned_styles = preg_replace( '/\.et_pb_([a-z|_]+)_(\d+)_tb_body/', 'body.et-db #et-boc .et-l .et_pb_df_ml_${1}_${2}_tb_body', $cleaned_styles );
    $cleaned_styles = preg_replace( '/\.et_pb_([a-z|_]+)_(\d+)( |"|\.|,|:)/', 'body.et-db #et-boc .et-l .et_pb_df_ml_${1}_${2}${3}', $cleaned_styles );
    $cleaned_styles = $temp_styles . ' ' . $cleaned_styles;

        printf(
            '<style type="text/css" class="dmach_map_modal_inner_styles">
              %1$s
            </style>',
            et_core_esc_previously( $cleaned_styles )
        );
?>
    </div>
<?php
    }

    $css_output = ob_get_contents();

    ob_end_clean();


$result['css_output'] = $css_output;
$result['content'] = $array_content_pass_to_js;
$restul['post_ids'] = $post_id_get_array;


    wp_reset_postdata();

    wp_send_json($result);
    wp_die();
}

add_action("wp_ajax_ajax_marker_layout_ajax_handler", "ajax_marker_layout_ajax_handler");
add_action("wp_ajax_nopriv_ajax_marker_layout_ajax_handler", "ajax_marker_layout_ajax_handler");