<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function divi_machine_filterposts_handler() {

  /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-machine' );*/
  $enable_debug = de_get_option_value('divi-machine', 'enable_debug');//$titan->getOption( 'enable_debug' );


    global $wp_query, $wpdb, $post, $woocommerce;

    ////
    $filter_item_id = esc_attr( $_POST['filter_item_id'] );
    $filter_item_name = esc_attr( $_POST['filter_item_name'] );
    $filter_item_val = esc_attr( $_POST['filter_item_val'] );
    $filter_input_type = esc_attr( $_POST['filter_input_type'] );

    $filter_item_id_array = array_map('trim',explode(', ', $filter_item_id));
    $filter_item_name_array = array_map('trim',explode(', ', $filter_item_name));
    $filter_item_val_array = array_map('trim',explode(', ', $filter_item_val));
    $filter_input_type_array = array_map('trim',explode(', ', $filter_input_type));

    $filter_name_and_val_array = array_combine($filter_item_name_array, $filter_item_val_array);

    $all_filters_array = array_map(function ($filter_item_id_array, $filter_item_name_array, $filter_item_val_array, $filter_input_type_array) {
        return array_combine(
            ['filter_item_id', 'filter_item_name', 'filter_item_val', 'filter_input_type'],
            [$filter_item_id_array, $filter_item_name_array, $filter_item_val_array, $filter_input_type_array]
        );
    }, $filter_item_id_array, $filter_item_name_array, $filter_item_val_array, $filter_input_type_array);

    $args = json_decode( stripslashes( $_POST['query'] ), true );

    ////

    ob_start();

    $layoutid = esc_attr( $_POST['layoutid'] );
    $posttype = esc_attr( $_POST['posttype'] );
    $noresults = esc_attr( $_POST['noresults'] );
    $sortorder = esc_attr( $_POST['sortorder'] );
    $sortasc = esc_attr( $_POST['sortasc'] );
    $sorttype = isset( $_POST['sorttype'] ) ? esc_attr( $_POST['sorttype'] ) : '';
    $gridstyle = esc_attr( $_POST['gridstyle'] );
    $columnscount = esc_attr( $_POST['columnscount'] );
    $postnumber = esc_attr( $_POST['postnumber'] );
    $loadmore = esc_attr( $_POST['loadmore'] );
    $loadmoretext = esc_attr( $_POST['loadmoretext'] );
    $loadmoretextloading = esc_attr( $_POST['loadmoretextloading'] );
    $posttax = esc_attr( $_POST['posttax'] );
    $postterm = esc_attr( $_POST['postterm'] );
    $current_page = esc_attr( $_POST['current_page'] );
    $category_currently_in = esc_attr( $_POST['category_currently_in'] );
    $current_custom_category = esc_attr( $_POST['current_custom_category'] );
    $current_custom_category_terms = esc_attr( $_POST['current_custom_category_terms'] );
    $current_author = esc_attr( $_POST['current_author'] );
    $link_whole_gird = esc_attr( $_POST['linklayout'] );
    $loadmore_icon = esc_attr( $_POST['loadmore_icon'] );
    $has_map = esc_attr( $_POST['has_map'] );
    $map_selector = esc_attr( $_POST['map_selector'] );
    $marker_layout = esc_attr( $_POST['marker_layout'] );

    
    $looptype = esc_attr( $_POST['looptype'] );
    $get_saved_types = esc_attr( $_POST['get_saved_types'] );

    $dmach_map_acf = de_get_option_value('divi-machine', 'dmach_map_acf');//$titan->getOption( 'dmach_map_acf' );
    $dmach_post_type = de_get_option_value('divi-machine', 'dmach_post_type');//$titan->getOption( 'dmach_post_type' );


    if ($enable_debug == "1") { 
        ?>
        <div class="reporting_args get_$_post hidethis" style="white-space: pre;">
            layoutid = <?php echo $layoutid ?><br>
            posttype = <?php echo $posttype ?><br>
            noresults = <?php echo $noresults ?><br>
            sortorder = <?php echo $sortorder ?><br>
            sortasc = <?php echo $sortasc ?><br>
            sorttype = <?php echo $sorttype ?><br>
            gridstyle = <?php echo $gridstyle ?><br>
            columnscount = <?php echo $columnscount ?><br>
            postnumber = <?php echo $postnumber ?><br>
            loadmore = <?php echo $loadmore ?><br>
            loadmoretext = <?php echo $loadmoretext ?><br>
            loadmoretextloading = <?php echo $loadmoretextloading ?><br>
            posttax = <?php echo $posttax ?><br>
            postterm = <?php echo $postterm ?><br>
            current_page = <?php echo $current_page ?><br>
            category_currently_in = <?php echo $category_currently_in ?><br>
            current_custom_category = <?php echo $current_custom_category ?><br>
            current_custom_category_terms = <?php echo $current_custom_category_terms ?><br>
            current_author = <?php echo $current_author ?><br>
            link_whole_gird = <?php echo $link_whole_gird ?><br>
            loadmore_icon = <?php echo $loadmore_icon ?><br>
            has_map = <?php echo $has_map ?><br>
            map_selector = <?php echo $map_selector ?><br>
            marker_layout = <?php echo $marker_layout ?><br>
        </div>
      <?php 
      }

    $meta_query = array('relation' => 'AND');
    $tax_query = array('relation' => 'AND');

    $args_url_acf = [];

    $post_taxonomies = get_object_taxonomies( $posttype );

    if ( !empty( $filter_item_name_array ) ){
        foreach ( $filter_item_name_array as $filter_name ) {

            // IF OUR CATEGORY
            if ( in_array( $filter_name , $post_taxonomies ) ) {
                foreach ($args['tax_query'] as $key => $meta) {
                    if ( is_array( $meta ) && !empty( $meta['taxonomy'] ) && ( $filter_name == $meta['taxonomy'] ) ){
                        unset( $args['tax_query'][$key] );
                    }else if ( is_array( $meta ) ) {
                        foreach ($meta as $subkey => $subMeta) {
                            if ( is_array( $subMeta ) && !empty( $subMeta['taxonomy'] ) && ( $filter_name == $subMeta['taxonomy'] ) ){
                                unset( $args['tax_query'][$key] );
                            }
                        }
                    }
                }
                if ( !empty( $args['taxonomy']) && ( $args['taxonomy'] == $filter_name ) ){
                    unset( $args['taxonomy']);
                    unset( $args['term'] );
                }
            }
            if (substr($filter_name, -9) == '_category') { 

                $ending = "_category";
                $cat_key = $posttype . $ending;

                foreach ($args['tax_query'] as $key => $meta) {
                    if ( is_array( $meta ) && !empty( $meta['taxonomy'] ) && ( $cat_key == $meta['taxonomy'] ) ){
                        unset( $args['tax_query'][$key] );
                    }else if ( is_array( $meta ) ) {
                        foreach ($meta as $subkey => $subMeta) {
                            if ( is_array( $subMeta ) && !empty( $subMeta['taxonomy'] ) && ( $cat_key == $subMeta['taxonomy'] ) ){
                                unset( $args['tax_query'][$key] );
                            }
                        }
                    }
                }
                if ( !empty( $args['taxonomy']) && ( $args['taxonomy'] == $cat_key ) ){
                    unset( $args['taxonomy']);
                    unset( $args['term'] );
                }
            // IF OUR TAG
            } else if (substr($filter_name, -4) == '_tag') { 

                if ($filter_name == "post_tag") {
                    unset( $args['tag'] );
                } else {
                    $ending = "_tag";
                    $cat_key = $posttype . $ending;

                    foreach ($args['tax_query'] as $key => $meta) {
                        if ( is_array( $meta ) && !empty( $meta['taxonomy'] ) && ( $cat_key == $meta['taxonomy'] ) ){
                            unset( $args['tax_query'][$key] );
                        }else if ( is_array( $meta ) ) {
                            foreach ($meta as $subkey => $subMeta) {
                                if ( is_array( $subMeta ) && !empty( $subMeta['taxonomy'] ) && ( $cat_key == $subMeta['taxonomy'] ) ){
                                    unset( $args['tax_query'][$key] );
                                }
                            }
                        }
                    }

                    if ( !empty( $args['taxonomy']) && ( $args['taxonomy'] == $cat_key ) ){
                        unset( $args['taxonomy']);
                        unset( $args['term'] );
                    }
                }
            
            // ELSE EVERYTHING ELSE
            } else {
                // IF SEARCH TEXT
                if ($filter_name == "s") {
                    unset( $args['s'] );
                // IF POST CATEGORY
                } else if ($filter_name == "category") {
                    unset( $args['category_name'] );
                    unset( $args['cat'] );
                // ELSE ACF OR CUSTOM TAX
                } else {

                    foreach ($args['meta_query'] as $key => $meta) {
                        if ( is_array( $meta ) && !empty( $meta['key'] ) && ( $filter_name == $meta['key'] ) ){
                            unset( $args['meta_query'][$key] );
                        }else if ( is_array( $meta ) ) {
                            foreach ($meta as $subkey => $subMeta) {
                                if ( is_array( $subMeta ) && !empty( $subMeta['key'] ) && ( $filter_name == $subMeta['key'] ) ){
                                    unset( $args['meta_query'][$key] );
                                }
                            }
                        }
                    }

                    foreach ($args['tax_query'] as $key => $meta) {
                        if ( is_array( $meta ) && !empty( $meta['taxonomy'] ) && ( $filter_name == $meta['taxonomy'] ) ){
                            unset( $args['tax_query'][$key] );
                        }else if ( is_array( $meta ) ) {
                            foreach ($meta as $subkey => $subMeta) {
                                if ( is_array( $subMeta ) && !empty( $subMeta['taxonomy'] ) && ( $filter_name == $subMeta['taxonomy'] ) ){
                                    unset( $args['tax_query'][$key] );
                                }
                            }
                        }
                    }

                    if ( !empty( $args['taxonomy']) && ( $args['taxonomy'] == $filter_name ) ){
                        unset( $args['taxonomy']);
                        unset( $args['term'] );
                    }
                }
            }
        }
    }

    if (isset($_POST['data_fields'])) {
        foreach($_POST['data_fields'] as $items)
        {
            foreach($items as $item ) {
                foreach($item as $key => $value) {
                    if ( isset($value['val']) && $value['val'] != "")  {
                        // IF OUR CATEGORY
                        if (substr($value['name'], -9) == '_category') { 

                            if ( $value['val'] != 'all' ) {
                                $cat_show = $value['val'];
                            } else {
                                $cat_show = "all";
                            }
                        // IF OUR TAG
                        } else if (substr($value['name'], -4) == '_tag') { 

                            if ($value['name'] == "post_tag") {
                                if ( $value['val'] != 'all' ) {
                                    $post_tag_show = $value['val'];
                                } else {
                                    $post_tag_show = "all";
                                }
                            } else {
                                if ( $value['val'] != 'all' ) {
                                    $cus_tag_show = $value['val'];
                                } else {
                                    $cus_tag_show = "all";
                                }
                            }
                        }else if ( in_array( $value['name'], $post_taxonomies ) ) {
                            foreach ($args['tax_query'] as $key => $meta) {
                                if ( is_array( $meta ) && !empty( $meta['taxonomy'] ) && ( $value['name'] == $meta['taxonomy'] ) ){
                                    unset( $args['tax_query'][$key] );
                                }else if ( is_array( $meta ) ) {
                                    foreach ($meta as $subkey => $subMeta) {
                                        if ( is_array( $subMeta ) && !empty( $subMeta['taxonomy'] ) && ( $value['name'] == $subMeta['taxonomy'] ) ){
                                            unset( $args['tax_query'][$key] );
                                        }
                                    }
                                }
                            }

                            if ( $value['val'] != "all" ){
                                $tax_query[] = array(
                                    'taxonomy'  => $value['name'],
                                    'field'     => 'slug',
                                    'terms'     => explode( ',' , $value['val'] ),
                                    'operator' => 'IN'
                                );    
                            }                            
                        // ELSE EVERYTHING ELSE
                        } else {
                            // IF SEARCH TEXT
                            if ($value['name'] == "s") {
                                $search_keyword = $value['val'];
                            // IF POST CATEGORY
                            } else if ($value['name'] == "category") {
                                $post_category = $value['val'];
                            // ELSE ACF OR CUSTOM TAX
                            } else {
                                // IF TYPE IS RADIO OR CHECKBOX
                                if ($value['type'] == "radio" || $value['type'] == "checkbox") {
                                    $val_array = explode(',', $value['val']);

                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if ( is_array( $meta ) && !empty( $meta['key'] ) && ( $value['name'] == $meta['key'] ) ){
                                            unset( $args['meta_query'][$key] );
                                        }else if ( is_array( $meta ) ) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if ( is_array( $subMeta ) && !empty( $subMeta['key'] ) && ( $value['name'] == $subMeta['key'] ) ){
                                                    unset( $args['meta_query'][$key] );
                                                }
                                            }
                                        }
                                    }

                                    if ( $value['acf_type'] == 'checkbox' ){
                                        if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                            $query_arr = array( 'relation' => 'OR' );
                                            foreach ( $val_array as $meta_val ) {
                                                $query_arr[] = array(
                                                    'key'       => $value['name'],
                                                    'value'     => '"' . $meta_val . '"',
                                                    'compare'   => 'LIKE',
                                                );
                                            }
                                            $meta_query[] = $query_arr;
                                        }else{
                                            $meta_query[] = array(
                                                'key'       => $value['name'],
                                                'value'     => '"' . $value['val'] . '"',
                                                'compare'   => 'LIKE',
                                            );
                                        }
                                    }else{
                                        if ( is_array( $val_array ) && sizeof( $val_array ) > 1 ){
                                            $meta_query[] = array(
                                                    'key'       => $value['name'],
                                                    'value'     => $val_array,
                                                    'compare'   => 'IN',
                                                );
                                        }else{
                                            $meta_query[] = array(
                                                'key' => $value['name'],
                                                'value' => $value['val'],
                                                'compare' => 'IN'
                                            );
                                        }
                                    }
                                // IF TYPE IS RANGE
                                } else if ($value['type'] == "range") {

                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if ( is_array( $meta ) && !empty( $meta['key'] ) && ( $value['name'] == $meta['key'] ) ){
                                            unset( $args['meta_query'][$key] );
                                        }else if ( is_array( $meta ) ) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if ( is_array( $subMeta ) && !empty( $subMeta['key'] ) && ( $value['name'] == $subMeta['key'] ) ){
                                                    unset( $args['meta_query'][$key] );
                                                }
                                            }
                                        }
                                    }

                                    $price_value = (explode(";",$value['val']));

                                    if ( sizeof( $price_value ) == 1 ){
                                        $meta_query[] = array(
                                            'key' => $value['name'],
                                            'value' => $price_value[0],
                                            'type' => 'NUMERIC',
                                            'compare' => '<='
                                        );
                                    }else{
                                        $meta_query[] = array(
                                            'key' => $value['name'],
                                            'value' => $price_value,
                                            'compare' => 'BETWEEN',
                                            'type' => 'NUMERIC'
                                        );
                                    }
                                // IF TYPE is CUSTOM TAXONOMY
                                } else if ( $value['type'] == "customtaxonomy") {

                                    foreach ($args['tax_query'] as $key => $meta) {
                                        if ( is_array( $meta ) && !empty( $meta['taxonomy'] ) && ( $value['name'] == $meta['taxonomy'] ) ){
                                            unset( $args['tax_query'][$key] );
                                        }else if ( is_array( $meta ) ) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if ( is_array( $subMeta ) && !empty( $subMeta['taxonomy'] ) && ( $value['name'] == $subMeta['taxonomy'] ) ){
                                                    unset( $args['tax_query'][$key] );
                                                }
                                            }
                                        }
                                    }

                                    $tax_query[] = array(
                                        'taxonomy'  => $value['name'],
                                        'field'     => 'slug',
                                        'terms'     => explode( ',' , $value['val'] ),
                                        'operator' => 'IN'
                                    );
                                // IF TYPE is MULTIPLE SELECT
                                } else if ( $value['type'] == "acfselectmulitple") {
                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if ( is_array( $meta ) && !empty( $meta['key'] ) && ( $value['name'] == $meta['key'] ) ){
                                            unset( $args['meta_query'][$key] );
                                        }else if ( is_array( $meta ) ) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if ( is_array( $subMeta ) && !empty( $subMeta['key'] ) && ( $value['name'] == $subMeta['key'] ) ){
                                                    unset( $args['meta_query'][$key] );
                                                }
                                            }
                                        }
                                    }

                                    $meta_query[] = array(
                                        'key' => $value['name'],
                                        'value' => $value['val'],
                                        'compare' => 'LIKE'
                                    );
                                // ELSE REST
                                } else {

                                    foreach ($args['meta_query'] as $key => $meta) {
                                        if ( is_array( $meta ) && !empty( $meta['key'] ) && ( $value['name'] == $meta['key'] ) ){
                                            unset( $args['meta_query'][$key] );
                                        }else if ( is_array( $meta ) ) {
                                            foreach ($meta as $subkey => $subMeta) {
                                                if ( is_array( $subMeta ) && !empty( $subMeta['key'] ) && ( $value['name'] == $subMeta['key'] ) ){
                                                    unset( $args['meta_query'][$key] );
                                                }
                                            }
                                        }
                                    }

                                    $meta_query[] = array(
                                        'key' => $value['name'],
                                        'value' => $value['val'],
                                        'compare' => 'IN'
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

    //////////////////////////////////////////////


    //////////////////////////////////////////////

    $args_url = array(
        'post_type' => $posttype,
        'post_status' => 'publish',
        'posts_per_page' => $postnumber,
        'orderby' => $sortorder,
        'order' => $sortasc
    );

    $args_url_final = array_merge($args_url, $args_url_acf);

    // $args_url_final_send = add_query_arg( $args_url_final, 'http://localhost/divi-machine/' );
    // echo $args_url_final_send;

    if ( in_array( $sortorder, array("date", "relevance", "ID", "rand", "menu_order", "name", "modified", "title") ) ) {
        $args1 = array(
            'post_type' => $posttype,
            'post_status' => 'publish',
            'posts_per_page' => $postnumber,
            'orderby' => $sortorder,
            'order' => $sortasc
        );

        $args = array_merge( $args, $args1 );

        if ( $sortorder == "rand") {
            $args['orderby'] = 'rand(' . get_random_post() . ')';
        }

        $args['meta_query'] = array_merge( $args['meta_query'], $meta_query );
    } else if ( $sortorder == 'acf_date_picker' ) {
        $acf_date_picker_field = esc_attr( $_POST['acf_order_field']);
        $acf_date_picker_method = esc_attr( $_POST['acf_order_method']);
        
        $acf_get = get_field_object($acf_date_picker_field);

        foreach ($args['meta_query'] as $key => $meta) {
            if ( is_array( $meta ) && !empty( $meta['key'] ) && ( $acf_get['name'] == $meta['key'] ) ){
                unset( $args['meta_query'][$key] );
            }else if ( is_array( $meta ) ) {
                foreach ($meta as $subkey => $subMeta) {
                    if ( is_array( $subMeta ) && !empty( $subMeta['key'] ) && ( $acf_get['name'] == $subMeta['key'] ) ){
                        unset( $args['meta_query'][$key] );
                    }
                }
            }
        }
        if ($acf_date_picker_method == 'today_future') {

            $args['meta_key'] = $acf_get['name'];
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';

            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '>',
                'value' => date("Y-m-d"),
                'type' => 'DATE'
            );

        } elseif ($acf_date_picker_method == 'today_30') {

            $args['meta_key'] = $acf_get['name'];
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';

            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '>',
                'value' => date("Y-m-d"),
                'type' => 'DATE'
            );
            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '<=',
                'value' => date("Y-m-d", strtotime("+30 days")),
                'type' => 'DATE'
            );

        } elseif ($acf_date_picker_method == 'before_today') {

            $args['meta_key'] = $acf_get['name'];
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';

            $meta_query[] = array(
                'key' => $acf_get['name'],
                'compare' => '<=',
                'value' => date('Y-m-d',strtotime("-1 days")),
                'type' => 'DATE'
            );

        } else {

            $args['meta_key'] = $acf_get['name'];
            $args['orderby'] = 'meta_value_num';
            $args['order'] = $sortasc;

        }
    } else {
        $meta_value_type = 'meta_value';
        if ( $sorttype == 'range' || $sorttype == 'num' ) {
            $meta_value_type = 'meta_value_num';
        }
        $args1 = array(
            'post_type' => $posttype,
            'post_status' => 'publish',
            'posts_per_page' => $postnumber,
            'meta_key'       => $sortorder,
            'orderby'           => $meta_value_type,
            'order' => $sortasc
        );
        $args = array_merge( $args, $args1 );
        $args['meta_query'] = array_merge( $args['meta_query'], $meta_query );
    }

    $args['tax_query'] = array_merge( $args['tax_query'], $tax_query );

    if (isset($cat_show)){
        if ($cat_show != "all"){
            $ending = "_category";
            $cat_key = $posttype . $ending;

            $args['tax_query'][] = array(
                'taxonomy'  => $cat_key,
                'field'     => 'slug',
                'terms'     => explode(',', $cat_show),
                /*'operator' => 'IN'*/
            );
        }
    }

    if (isset($cus_tag_show)){
        if ($cus_tag_show != "all"){
            $ending = "_tag";
            $cat_key = $posttype . $ending;

            $args['tax_query'][] = array(
                'taxonomy'  => $cat_key,
                'field'     => 'slug',
                'terms'     => $cus_tag_show,
                'operator' => 'IN'
            );
        }
    }

    if (isset($tag_show)){
        if ($tag_show != "all"){

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
            'taxonomy'  => $posttax,
            'field'     => 'slug',
            'terms'     => $postterm,
            'operator' => 'IN'
        );
    }

    if (isset($post_category)) {
        $args['category_name'] = $post_category;
    }

    if (isset($post_tag_show)) {
        $args['tag'] = $post_tag_show;
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



    $args = apply_filters('dmach_archive_post_args', $args);

    query_posts( $args );

    $wp_query->is_tax = false;

if ($enable_debug == "1") {
    ?>
  <div class="reporting_args hidethis" style="white-space: pre;">
        <?php  print_r($args); ?>
  </div>
    <?php
  }

    $loadmore_param = array(
        'post_var' => json_encode( $wp_query->query_vars ),
        'max_num_pages' => $wp_query->max_num_pages,
        'current_page'  => $current_page
    );

    $filter_item_name_array_removeduplicates = array_unique($filter_name_and_val_array);
    $filter_item_name_collate =[];

    global $current_in_archive_loop;

    $current_in_archive_loop = '';

    $map_array = array();

    if ( have_posts() ) {
?>
      <div class="grid-posts loop-grid">
<?php
        while ( have_posts() ) {
            $current_in_archive_loop = 'ajax_filter';
            the_post();
            setup_postdata( $post );

            $post_id = $post->ID;

            $terms = wp_get_object_terms( $post_id, get_object_taxonomies($posttype) ); 

            $terms_array = array();
            foreach ( $terms as $term ) {
              $terms_array[] = $term->taxonomy . '-' . $term->slug;
            }
            $terms_string = implode (" ", $terms_array);

            if ( $has_map == 'on' && $dmach_map_acf !== "none" && $posttype == $dmach_post_type ){
                $map_array[] = get_field($dmach_map_acf);
                $map_infoview_content = apply_filters( 'the_content', get_post_field('post_content', $marker_layout ) );
                $map_array[count($map_array) - 1]['infoview'] = $map_infoview_content;
                $map_array[count($map_array) - 1]['title'] = get_the_title();
            }
            if ($gridstyle == "masonry") {
?>
                <div class="grid-item dmach-grid-item <?php echo $terms_string ?>">
                  <div class="grid-item-cont">
<?php
            } else {
?>
                    <div class="grid-col dmach-grid-item <?php echo $terms_string ?>">
                      <div class="grid-item-cont">
<?php

            }

            
if ($link_whole_gird == "on") {
    $post_link = get_permalink(get_the_ID());
    ?>
    <div class="dmach-link-whole-grid-card" data-link-url="<?php echo $post_link ?>">
    <?php   
  }

            //$post = get_post( get_the_ID() );

            //setup_postdata( $post );

            $meta = get_post_meta( get_the_ID() );
            $post_tags = get_the_tags( get_the_ID() );
if ($enable_debug == "1") {
            print_r( $post_tags );
}
            foreach ($filter_name_and_val_array as $key => $value ) {

                // check meta for refine filters
                if( array_key_exists( $key , $meta ) )
                {

                    $meta_get = get_post_meta( get_the_ID(), $key, true );

                    if(array_key_exists($key, $filter_item_name_collate)){
                        $filter_item_name_collate[$key][] = $meta_get;
                    } else {
                        $filter_item_name_collate[$key] = array($meta_get);
                    }
                }
            }

            $post_content = apply_filters( 'the_content', get_post_field('post_content', $layoutid) );

            $post_content = preg_replace( '/et_pb_section_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_section_${1}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_row_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_row_${1}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_column_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_column_${1}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_section_(\d+)( |")/', 'et_pb_dmach_ajax_filter_section_${1}${2}', $post_content );
            $post_content = preg_replace( '/et_pb_row_(\d+)( |")/', 'et_pb_dmach_ajax_filter_row_${1}${2}', $post_content );
            $post_content = preg_replace( '/et_pb_column_(\d+)( |")/', 'et_pb_dmach_ajax_filter_column_${1}${2}', $post_content );

            $post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_${1}_${2}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_dmach_ajax_filter_${1}_${2}${3}', $post_content );

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

        $current_in_archive_loop = '';

        if ($loadmore == "on") {
            if (  $wp_query->max_num_pages > 1 ){
?>
    <div class="dmach-loadmore et_pb_button" data-btntext="<?php echo $loadmoretext ?>" data-btntext_loading="<?php echo $loadmoretextloading ?>" data-icon="<?php echo $loadmore_icon ?>"><?php echo $loadmoretext ?></div>
<?php
            }
        }

        ?>
      </div>
      <?php

        //wp_reset_query();

    } else {
        
        if ($enable_debug == "1") {
            ?>
          <div class="reporting_args hidethis" style="white-space: pre;">
                <?php  print_r($args); ?>
          </div>
            <?php
          }
          
        if ($noresults == "none") {
            echo "No " . $posttype;
        } else {
?>

    <div class="no-results-layout">
    <?php
                $post_content = apply_filters( 'the_content', get_post_field('post_content', $noresults) );

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

<?php
        }
    }

    $posts = ob_get_contents();
    ob_end_clean();

    ob_start();

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
    $cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_filter_${1}_${2}_tb_body', $cleaned_styles );
    $cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)( |"|.)/', 'et_pb_dmach_ajax_filter_${1}_${2}${3}', $cleaned_styles ); 
    $cleaned_styles = str_replace( 'body #page-container .et_pb_section .et_pb_dmach_ajax_filter_button_0 {', '.et-db #et-boc .et-l .et_pb_button.et_pb_dmach_ajax_filter_button_0, body #page-container .et_pb_section.et_pb_dmach_ajax_filter_button_0 {', $cleaned_styles );
    $cleaned_styles = str_replace( 'body #page-container .et_pb_section .et_pb_dmach_ajax_filter_button_0:hover {', '.et-db #et-boc .et-l .et_pb_button.et_pb_dmach_ajax_filter_button_0:hover, body #page-container .et_pb_section.et_pb_dmach_ajax_filter_button_0:hover {', $cleaned_styles );
    $cleaned_styles = str_replace('.et_pb_extra_column_main', '', $cleaned_styles);
    
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

    $css_output = ob_get_contents();

    ob_end_clean();

    ///////////////////////////////////////////////////////////////////
    // FILTERS
    //////////////////////////////////////////////////////////////////

    ob_start();
?>
    <div class="refine-filters">
<?php
    foreach($filter_item_name_collate as $key => $item) {
        $filter_val = '';
        foreach($item as $value) {
            $single_val = '';
            if ( is_array( $value ) ){
                $single_val = implode( ',', $value );
            }else{
                $single_val = $value;
            }

            if ( $filter_val == '' ){
                $filter_val = $single_val;
            }else{
                $filter_val = $filter_val . ',' . $single_val;
            }
        }
?>
        <span class="active-filters" data-filter-name="<?php echo $key?>" data-filter-val="<?php echo $filter_val;?>"></span>
<?php
    }
?>
    </div>

<?php if ($enable_debug == "1") { ?>
    <div class="reporting_args hidethis" style="white-space: pre;">
        <?php print_r($filter_item_name_collate); ?>
    </div>
  <?php } ?>

<?php
    $filers_html = ob_get_contents();
    ob_end_clean();

    $return = array(
        'posts' => $posts,
        'filters' =>$filers_html,
        'loadmore_param' => $loadmore_param,
        'css_output' => $css_output
    );

    if ( $has_map == 'on' && $dmach_map_acf !== "none" && $posttype == $dmach_post_type ){
        $return['map_data'] = $map_array;
    }

    wp_send_json($return);
    wp_die();
}

add_action( 'wp_ajax_divi_machine_filterposts_handler', 'divi_machine_filterposts_handler' );
add_action( 'wp_ajax_nopriv_divi_machine_filterposts_handler', 'divi_machine_filterposts_handler' );


function divi_machine_loadmore_ajax_handler(){
    global $wp_query;

    ob_start();

    // prepare our arguments for the query
    $args = json_decode( stripslashes( $_POST['query'] ), true );
    $args['paged'] = $page_ind = $_POST['page'] + 1; // we need next page to be loaded
    $args['post_status'] = 'publish';
    $layoutid = esc_attr( $_POST['layoutid'] );
    $posttype = esc_attr( $_POST['posttype'] );
    $noresults = esc_attr( $_POST['noresults'] );
    $sortorder = esc_attr( $_POST['sortorder'] );
    $sortasc = esc_attr( $_POST['sortasc'] );
    $gridstyle = esc_attr( $_POST['gridstyle'] );
    $columnscount = esc_attr( $_POST['columnscount'] );
    $postnumber = esc_attr( $_POST['postnumber'] );
    $args['posts_per_page'] = $postnumber;
    $link_whole_gird = esc_attr( $_POST['linklayout'] );
    // it is always better to use WP_Query but not here

    query_posts( $args );
    $wp_query->is_tax = false;

    if( have_posts() ) :
        global $wp_query, $wpdb, $post, $woocommerce, $current_in_archive_loop;

        $current_in_archive_loop = '';

        // run the loop
        while( have_posts() ):
            the_post();
            setup_postdata( $post );

            $post_id = $post->ID;

            $terms = wp_get_object_terms( $post_id, get_object_taxonomies($posttype) ); 

            $terms_array = array();
            foreach ( $terms as $term ) {
              $terms_array[] = $term->taxonomy . '-' . $term->slug;
            }
            $terms_string = implode (" ", $terms_array);
            $current_in_archive_loop = 'ajax_loadmore';
            if ($gridstyle == "masonry") {
?>
    <div class="grid-item dmach-grid-item <?php echo $terms_string ?>">
        <div class="grid-item-cont">
<?php
            } else {
?>
    <div class="grid-col dmach-grid-item <?php echo $terms_string ?>">
        <div class="grid-item-cont">
<?php
            }

            if ($link_whole_gird == "on") {
                $post_link = get_permalink(get_the_ID());
                ?>
                <div class="dmach-link-whole-grid-card" data-link-url="<?php echo $post_link ?>">
                <?php   
              }

            $post_content = apply_filters( 'the_content', get_post_field('post_content', $layoutid) );
            $post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_loadmore_${1}'.$page_ind.'_${2}_tb_body', $post_content );
            $post_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_dmach_ajax_loadmore_${1}'.$page_ind.'_${2}${3}', $post_content );

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
        endwhile;

        $current_in_archive_loop = '';
        
    endif;

    $posts = ob_get_contents();
    ob_end_clean();

    ob_start();
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
$cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_loadmore_${1}'.$page_ind.'_${2}_tb_body', $cleaned_styles );
$cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)( |"|.)/', 'et_pb_dmach_ajax_loadmore_${1}'.$page_ind.'_${2}${3}', $cleaned_styles );
$cleaned_styles = str_replace('.et_pb_extra_column_main', '', $cleaned_styles);

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

    $css_output = ob_get_contents();
    ob_end_clean();

    $return = array(
        'posts' => $posts,
        'css_output' => $css_output
    );

    wp_send_json($return);

    die;
}

add_action('wp_ajax_divi_machine_loadmore_ajax_handler', 'divi_machine_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_divi_machine_loadmore_ajax_handler', 'divi_machine_loadmore_ajax_handler');

function divi_machine_get_count_ajax_handler(){

    ob_start();

    // prepare our arguments for the query
    $args = json_decode( stripslashes( $_POST['query'] ), true );

    $filter_options = explode( ',', esc_attr( $_POST['filters'] ) );
    $filter_types = explode(',', esc_attr( $_POST['filter_types'] ) );

    $result = array();

    foreach ($filter_options as $filter_ind => $option) {
        $filter_key = '';

        if ( $args['post_type'] != 'post'  ){
            if ( ( $option == $args['post_type'] . '_category' ) || ( $option == $args['post_type'] . '_tag' ) ) {
                $filter_key = 'tax_query';
                if ( isset( $args['taxonomy'] ) && $args['taxonomy'] == $option ){
                    unset( $args['taxonomy'] );
                    unset( $args['term'] );
                }
            }
        }
    }

    foreach ($filter_options as $filter_ind => $option) {
        $filter_key = '';
        $result[$option] = array();
        if ( $args['post_type'] == 'post' ){
            if ( $option == 'category' ){
                $filter_key = 'cat';
            }else if ( $option == 'post_tag' ) {
                $filter_key = 'post_tag';
            }
        }else if ( $args['post_type'] != 'post' ) {
            $cpt_taxonomies = get_object_taxonomies( $args['post_type'] );

                if ( !empty( $cpt_taxonomies ) && in_array( 'category', $cpt_taxonomies ) ){
                    if ( $option == 'category'){
                        $filter_key = 'cat';    
                    }                    
                }else{
                    if ( ( $option == $args['post_type'] . '_category' ) || ( $option == $args['post_type'] . '_tag' ) ) {
                        $filter_key = 'tax_query';
                    }
                }
            
        }

        if ( $option != 'category' && $option != $args['post_type'] . '_category' && $option != 'tag' ) {
            $acf_obj = get_field_object($option);
            $meta_key = 0;
            $original_val = '';
            if ( isset( $args['meta_query'] ) ){
                $last_key = '';
                foreach ( $args['meta_query'] as $key => $meta_query) {
                    $last_key = $key;
                    if ( $filter_types[$filter_ind] == 'single' ){
                        if (isset($meta_query['key'])) {
                        if ( $meta_query['key'] == $acf_obj['name'] ){
                            $meta_key = $key;
                            $original_val = $meta_query;
                            break;
                        }
                    }
                    }else{
                        if ( isset( $meta_query['key'] ) && $meta_query['key'] == $acf_obj['name'] ){
                            $meta_key = $key;
                            $original_val = $meta_query;
                            break;
                        }else if ( is_array( $meta_query ) && !isset( $meta_query['key'] ) ){
                            foreach( $meta_query as $subkey => $meta_subquery ) {
                                if ( isset( $meta_subquery['key'] ) && $meta_subquery['key'] == $acf_obj['name'] ){
                                    $meta_key = $key;
                                    $original_val = $meta_query;
                                }
                            }
                        }
                    }
                }
                if ( $last_key != 'relation' && $meta_key == 0 ){
                    $meta_key = $last_key + 1;
                }
            }else{
                $args['meta_query'] = array( 'relation' => 'AND' );
            }

            $args['meta_query'][$meta_key] = array(
                'key' => $acf_obj['name'],
                'value' => '',
                'compare' => "LIKE"
            );

            $option_query = new WP_Query( $args );
            $count = $option_query->found_posts;
            $result[$option]['all'] = $count;
            
            foreach ( $acf_obj['choices'] as $option_val ) {
                if ( $acf_obj['type'] == 'checkbox' || ( $acf_obj['type'] == 'select' && $acf_obj['multiple'] == '1' ) ){
                    $args['meta_query'][$meta_key] = array(
                        'key' => $acf_obj['name'],
                        'value' => '"' . $option_val . '"',
                        'compare' => "LIKE"
                    );
                }else{
                    $args['meta_query'][$meta_key] = array(
                        'key' => $acf_obj['name'],
                        /*'value' => '"' . $option_val . '"',*/
                        'value' => $option_val,
                        'compare' => "IN"
                    );
                }
                
                $option_query = new WP_Query( $args );
                $count = $option_query->found_posts;
                $result[$option][$option_val] = $count;
            }

            if ( $original_val == '' ){
                unset( $args['meta_query'][$meta_key] );
            }else{
                $args['meta_query'][$meta_key] = $original_val;
            }
        }

        if ( $filter_key == 'tax_query' ){
            $tax_key = 0;
            $original_val = '';
            if ( isset( $args[$filter_key] ) && is_array( $args[$filter_key] ) ) {
                $last_key = '';
                foreach ( $args['tax_query'] as $key => $tax_query) {
                    $last_key = $key;
                    if ( $filter_types[$filter_ind] == 'single' ){
                        if ( $tax_query['taxonomy'] == $option ){
                            $tax_key = $key;
                            $original_val = $tax_query;
                            break;
                        }
                    }else{
                        if ( isset( $tax_query['taxonomy'] ) && $tax_query['taxonomy'] == $option ){
                            $tax_key = $key;
                            $original_val = $tax_query;
                            break;
                        }else if ( is_array( $tax_query ) && !isset( $tax_query['taxonomy'] ) ){
                            foreach( $tax_query as $subkey => $tax_subquery ) {
                                if ( isset( $tax_subquery['taxonomy'] ) && $tax_subquery['taxonomy'] == $option ){
                                    $tax_key = $key;
                                    $original_val = $tax_query;
                                }
                            }
                        }
                    }
                }
                if ( $last_key != 'relation' && $tax_key == 0 ){
                    $tax_key = $last_key + 1;
                }
            }else{
                $args['tax_query'] = array( 'relation' => 'AND' );
            }

            $terms = get_terms( $option );
            $term_slugs = wp_list_pluck( $terms, 'slug' );

            $args['tax_query'][$tax_key] = array(
                'taxonomy' => $option,
                'field' => 'slug',
                'terms' => $term_slugs
            );

            $option_query = new WP_Query( $args );
            $count = $option_query->found_posts;
            $result[$option]['all'] = $count;

            foreach ( $term_slugs as $term_slug ) {
                $args['tax_query'][$tax_key] = array(
                    'taxonomy' => $option,
                    'field' => 'slug',
                    'terms' => $term_slug
                );

                $option_query = new WP_Query( $args );
                $count = $option_query->found_posts;
                $result[$option][$term_slug] = $count;
            }

            if ( $original_val == '' ){
                unset( $args['tax_query'][$tax_key] );
            }else{
                $args['tax_query'][$tax_key] = $original_val;
            }
        }else if ( $filter_key == 'cat' ){
            $original_val = $args['cat'];
            $terms = get_terms( $option );
            $term_slugs = wp_list_pluck( $terms, 'slug' );
            $term_ids = wp_list_pluck( $terms, 'term_id' );

            unset( $args['cat'] );
            unset( $args['category_name']);

            $args['category__in'] = $term_ids;

            $option_query = new WP_Query( $args );
            $count = $option_query->found_posts;
            $result[$option]['all'] = $count;

            unset( $args['category__in'] );

            foreach ( $term_ids as $term_key => $term_id ) {
                $args['cat'] = $term_id;

                $option_query = new WP_Query( $args );
                $count = $option_query->found_posts;
                $slug = $term_slugs[$term_key];
                $result[$option][$slug] = $count;
            }

            if ( $original_val == '' ){
                unset( $args['cat'] );
            }else{
                $args['cat'] = $original_val;
            }
        }else if ( $filter_key == 'post_tag' ){
            $original_val = $args['tag'];
            $terms = get_terms( $option );
            $term_slugs = wp_list_pluck( $terms, 'slug' );
            $term_ids = wp_list_pluck( $terms, 'term_id' );

            unset( $args['tag'] );
            unset( $args['tag_slug__in'] );

            $args['tag_slug__in'] = $term_slugs;

            $option_query = new WP_Query( $args );
            $count = $option_query->found_posts;
            $result[$option]['all'] = $count;

            unset( $args['tag_slug__in'] );

            foreach ( $term_slugs as $term_key => $term_slug ) {
                unset( $args['tag_id'] );
                $args['tag'] = $term_slug;
                $option_query = new WP_Query( $args );
                $count = $option_query->found_posts;
                $result[$option][$term_slug] = $count;
            }

            if ( $original_val == '' ){
                unset( $args['tag'] );
            }else{
                $args['tag'] = $original_val;
            }
        }
    }

    wp_send_json($result);

    die;
}

add_action( 'wp_ajax_divi_machine_get_count_ajax_handler', 'divi_machine_get_count_ajax_handler' );
add_action( 'wp_ajax_nopriv_divi_machine_get_count_ajax_handler', 'divi_machine_get_count_ajax_handler' );

function divi_machine_get_post_modal_ajax_handler(){

    global $post;

    // prepare our arguments for the query
    $post_ids = explode(',', $_POST['post_ids']);
    $post_type = $_POST['post_type'];
    $modal_layout = $_POST['modal_layout'];
    $modal_style = $_POST['modal_style'];
    
    $args = array(
        'post_type' => $post_type,
        'post__in' => $post_ids
    );

    query_posts( $args );
    
    global $current_in_archive_loop;

    $current_in_archive_loop = '';

    $result = array();

    if( have_posts() ) :
        // run the loop
        while( have_posts() ):
            $current_in_archive_loop = 'ajax_modal';
            the_post();
            $modal_content = apply_filters( 'the_content', get_post_field('post_content', $modal_layout ) );
    
            $modal_content = preg_replace( '/et_pb_section_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_section_${1}_tb_body', $modal_content );
            $modal_content = preg_replace( '/et_pb_row_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_row_${1}_tb_body', $modal_content );
            $modal_content = preg_replace( '/et_pb_column_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_column_${1}_tb_body', $modal_content );
            $modal_content = preg_replace( '/et_pb_section_(\d+)( |")/', 'et_pb_dmach_ajax_modal_section_${1}${2}', $modal_content );
            $modal_content = preg_replace( '/et_pb_row_(\d+)( |")/', 'et_pb_dmach_ajax_modal_row_${1}${2}', $modal_content );
            $modal_content = preg_replace( '/et_pb_column_(\d+)( |")/', 'et_pb_dmach_ajax_modal_column_${1}${2}', $modal_content );

            $modal_content = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_${1}_${2}_tb_body', $modal_content );
            $modal_content = preg_replace( '/et_pb_([a-z]+)_(\d+)( |")/', 'et_pb_dmach_ajax_modal_${1}_${2}${3}', $modal_content );
    
            $result['content']['show_modal_' . get_the_ID()] = $modal_content;

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
    if ( $internal_style ) {
?>
    <div class="dmach-modal-styles">
<?php
    $cleaned_styles = str_replace('#page-container', '#dmach-modal-wrapper', $internal_style);
    $cleaned_styles = str_replace('.et-db', '', $cleaned_styles);
    $cleaned_styles = str_replace('#et-boc .et-l', '', $cleaned_styles);
    $cleaned_styles = str_replace('content: attr(data-icon);', 'content: attr(data-icon) !important;', $cleaned_styles);    
    $cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)_tb_body/', 'et_pb_dmach_ajax_modal_${1}_${2}_tb_body', $cleaned_styles , -1);
    $cleaned_styles = preg_replace( '/et_pb_([a-z]+)_(\d+)( |"|.)/', 'et_pb_dmach_ajax_modal_${1}_${2}${3}', $cleaned_styles , -1);

        printf(
            '<style type="text/css" class="dmach_ajax_modal_styles">
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
    $result['args'] = $args;
    
    wp_send_json($result);

    wp_die();

}

add_action( 'wp_ajax_divi_machine_get_post_modal_ajax_handler', 'divi_machine_get_post_modal_ajax_handler' );
add_action( 'wp_ajax_nopriv_divi_machine_get_post_modal_ajax_handler', 'divi_machine_get_post_modal_ajax_handler' );