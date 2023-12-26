<?php

add_action( 'init', 'df_tool' );
if( !function_exists( 'df_tool' ) ){
    function df_tool () {
        if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) )
        return;

        add_filter( 'et_builder_settings_tabs', 'df_page_settings_tabs' );
        add_filter( 'et_builder_page_settings_modal_toggles', 'df_page_settings_toggles' );
        add_filter( 'et_builder_page_settings_definitions', 'df_page_settings_fields' );
        add_filter( 'et_builder_page_settings_values', 'df_page_settings_values', 10, 2 );
    }
}

if( !function_exists( 'df_page_settings_tabs' ) ){
    function df_page_settings_tabs( $tabs ) {
        if ( empty( $tabs['visual_builder'] ) ) {
            $tabs['divi_engine'] = esc_html__( 'Divi Engine', 'divi-filter' );
        }

        return $tabs;
    }
}

if( !function_exists( 'df_page_settings_toggles' ) ){
    function df_page_settings_toggles( $toggles ) {
        if ( empty( $toggles['visual_builder'] ) ) {
            $toggles['visual_builder'] = esc_html__( 'Visual Builder', 'divi-filter' );
        }

        return $toggles;
    }
}

if( !function_exists( 'df_page_settings_fields' ) ){
    function df_page_settings_fields( $fields ) {

        if ( empty( $fields['divi_filters_post_type'] ) ) {
            $fields['divi_filters_post_type'] = array(
                'type'        => 'select',
                'options'     => df_get_options(),
                'id'          => 'divi_filters_post_type',
                'show_in_bb'  => false,
                'default'     => 'post',
                'label'       => 'Example Post Type',
                'tab_slug'    => 'divi_engine',
                'toggle_slug' => 'visual_builder',
                'description' => esc_html__( 'Choose the type of post you\'d like to display in the visual builder preview. Requires reload to take effect', 'divi-filter' ),
            );
        }

        return $fields;
    }
}

if( !function_exists( 'df_page_settings_values' ) ){
    function df_page_settings_values( $values, $post_id ) {
        if ( ! isset( $values['divi_filters_post_type'] ) ) {
            $values['divi_filters_post_type'] = get_post_meta( $post_id, '_divi_filters_post_type', true );
        }

        return $values;
    }
}

if( !function_exists( 'df_get_options' ) ){
    function df_get_options() {

        $registered_post_types = et_get_registered_post_type_options( false, false );

        unset( $registered_post_types['attachment'] );

        return $registered_post_types;
    }
}