<?php
if ( ! defined( 'ABSPATH' ) ) exit;


class DiviAjaxFilter_Admin {

    function __construct(){
        add_action( 'admin_init', array( $this, 'admin_init' ) );
        
    }
    
    function add_daf_box() {
        $screens = [ 'et_pb_layout' ];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'daf_meta_box' ,
                'Divi Engine',
                array( $this, 'daf_meta_box_html' ),
                $screen,
                'side'
            );
        }
    }
    
    function daf_meta_box_html( $post ) {
        wp_nonce_field("daf-override", "daf-override-nonce"); ?>
        <h3>Visual Builder</h3>
        <label style="margin-bottom: 10px;" for="daf_post_type">Example Post Type</label><br />
        <p></p>
        <select type="select" name="daf_post_type" id="daf_post_type">
    <?php 


        $post_type_args = array(
            'public' => true
        );
        $selected = '';
        $post_types = get_post_types($post_type_args, 'objects');

        unset( $post_types['attachment'] );

        foreach($post_types as $post_type){
            if($post_type->name == get_post_meta( $post->ID, '_daf_post_type', true ) ){
                $selected = "selected='selected'";
            }
            $labels = get_post_type_labels( $post_type );
            echo '<option ' . esc_attr( $selected ) . 'value="' . esc_attr( $post_type->name ) . '">' . esc_html( $labels->name ) . '</option>';
            $selected = "";
        }

    ?>
        </select>
        <p>Choose the type of post you'd like to display in the visual builder preview. Requires reload to take effect</p>
    <?php		
        }
    
        function save_daf_assets ( $post_id ) {
    
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $post_id;
            }

            if ( !isset( $_POST['daf-override-nonce'] ) ) {
                return;
            }
    
            $nonce =  wp_unslash( $_POST['daf-override-nonce'] ) ;
            if ( ! wp_verify_nonce( $nonce, "daf-override" ) ) {
                return $post_id;
            }
            
            if( isset( $_POST['daf_post_type'] ) ){
                $nitro_except_js =  $_POST['daf_post_type'] ;
            } 
    
            // Update the meta field.
	        if ( isset( $nitro_except_js ) ) {
            update_post_meta( $post_id, '_daf_post_type', $nitro_except_js );
        }
        }

        function admin_init(){
            add_action( 'add_meta_boxes', array( $this, 'add_daf_box' ) );
            add_action( 'save_post', array( $this, 'save_daf_assets' ) );
        }
    }
