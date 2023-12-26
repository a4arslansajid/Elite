<?php
if ( ! defined( 'ABSPATH' ) ) exit;

    class DE_DMACH_options_interface
        {

            var $licence;

            const P_CODE = 'DE_DM';

            function __construct()
                {

                    $this->licence          =   new DE_DMACH_licence();

                    if (isset($_GET['page']) && ($_GET['page'] == 'woo-ms-options'  ||  $_GET['page'] == 'divi-engine_page_dm-options'))
                        {
                          $this->options_update();
                          $this->admin_notices();
                        }

                        $de_get = get_option( 'de_plugins', array() );

                        $product_key = array_search( self::P_CODE, $de_get);

                        if(!$this->licence->licence_key_verify())
                        {
                            add_action('admin_notices', array($this, 'admin_no_key_notices'));
                            add_action('network_admin_notices', array($this, 'admin_no_key_notices'));
                            if ( $product_key === false ) {
                                $de_get[] = self::P_CODE;
                            }
                        } else {
                            if ( $product_key !== false  ) {
                                unset( $de_get[ $product_key ] );
                            }
                        }
                }

            function __destruct()
                {

                }

            function network_admin_menu()
                {
                    if(!$this->licence->licence_key_verify()) {
                        return $this->licence_form_machine();
                    } else {
                        return $this->licence_deactivate_form();
                    }
                    add_action('load-' . $hookID , array($this, 'load_dependencies'));
                    add_action('load-' . $hookID , array($this, 'admin_notices'));

                    add_action('admin_print_styles-' . $hookID , array($this, 'admin_print_styles'));
                    add_action('admin_print_scripts-' . $hookID , array($this, 'admin_print_scripts'));
                }

            function admin_menu() {
                if (!$this->licence->licence_key_verify()) {
                    return $this->licence_form_machine();
                } else {
                    return $this->licence_deactivate_form();
                }
                add_action('admin_print_styles-' . $hookID, array($this, 'admin_print_styles'));
                add_action('admin_print_scripts-' . $hookID, array($this, 'admin_print_scripts'));
            }


            function options_interface()
                {

                    if(!$this->licence->licence_key_verify() && !is_multisite())
                        {
                            $this->licence_form_machine();
                            return;
                        }

                    if(!$this->licence->licence_key_verify() && is_multisite())
                        {
                            $this->licence_multisite_require_nottice();
                            return;
                        }
                }

            function options_update()
            {

                if (isset($_POST['machine_licence_form_submit']))
                {
                    return $this->licence_form_submit();
                }

            }

            function load_dependencies()
                {




                }

            function admin_notices()
                {
                    global $slt_form_submit_messages;

                    if($slt_form_submit_messages == '')
                        return;

                    $messages = $slt_form_submit_messages;


                    if(count($messages) > 0)
                        {
                            echo "<div id='notice' class='updated error'><p>". implode("</p><p>", $messages )  ."</p></div>";
                        }

                }

            function admin_print_styles()
                {

                }

            function admin_print_scripts()
                {

                }


            function admin_no_key_notices()
                {
                    if ( !current_user_can('manage_options'))
                        return;

                    $screen = get_current_screen();

                    if( ! is_network_admin()   )
                        {
                            if(isset($screen->id) && $screen->id == 'divi-engine_page_dm-options')
                                return;

                            ?><div class="updated error"><p><?php _e( "Divi Machine is inactive, please enter your", 'divi-machine' ) ?> <a href="admin.php?page=dm-options#wrap-license"><?php _e( "License Key", 'divi-machine' ) ?></a> to get updates</p></div><?php
                        }

                }

            function licence_form_submit()
                {
                    global $slt_form_submit_messages;

                    //check for de-activation
                    if (isset($_POST['machine_licence_form_submit']) && isset($_POST['machine_licence_deactivate']) && ( $_POST['machine_licence_deactivate'] == "true" ) && wp_verify_nonce($_POST['divi_machine_license_nonce'],'divi_machine_license'))
                    {
                        global $slt_form_submit_messages;

                        $license_data = DE_DMACH_licence::get_licence_data();
                        $license_key = $license_data['key'];

                        //build the request query
                        $args = array(
                                            'woo_sl_action'         => 'deactivate',
                                            'licence_key'           => $license_key,
                                            'product_unique_id'     => DE_DMACH_PRODUCT_ID,
                                            'domain'                => DE_DMACH_INSTANCE
                                        );
                        $request_uri    = DE_DMACH_APP_API_URL . '?' . http_build_query( $args , '', '&');
                        $data           = wp_remote_get( $request_uri );

                        //log if debug
                        if (defined('WP_DEBUG') &&  WP_DEBUG    === TRUE)
                        {
                            DE_DMACH::log_data("------\nArguments:");
                            DE_DMACH::log_data($args);

                            if( is_wp_error( $data ) || $data['response']['code'] != 200) {
                                DE_DMACH::log_data("\nResult - Failed:");
                                DE_DMACH::log_data($data);
                            } else {
                                DE_DMACH::log_data("\nResponse Body:");
                                DE_DMACH::log_data($data['body']);
                                DE_DMACH::log_data("\nResponse Server Response:");
                                DE_DMACH::log_data($data['response']);
                            }
                        }

                        if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        {
                            if ( $data['response']['code'] == 403 ) {
                                $header_data = $data['headers']->getAll();
                                $cf_ray = $header_data['cf-ray'];
                                $slt_form_submit_messages[] .= __('There was a problem connecting to diviengine.com. It seems our firewall blocked you from accessing our server. Please contact support with this Ray ID: ', 'divi-machine') . $cf_ray;
                            } else {
                                $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'divi-machine') . DE_DMACH_APP_API_URL;    
                            }

                            $result = array(
                                'result'    => 'error',
                                'message'   => $slt_form_submit_messages
                            );
                            
                            return $result;
                        }

                        $response_block = json_decode($data['body']);
                        //retrieve the last message within the $response_block
                        $response_block = $response_block[count($response_block) - 1];
                        $response = $response_block->message;

                        if(isset($response_block->status))
                        {
                            if($response_block->status == 'success' && $response_block->status_code == 's201')
                            {
                                //the license is active and the software is active
                                $slt_form_submit_messages[] = $response_block->message;

                                $license_data = DE_DMACH_licence::get_licence_data();

                                //save the license
                                $license_data['key']          = '';
                                $license_data['last_check']   = time();

                                DE_DMACH_licence::update_licence_data ( $license_data );
                            }

                            else //if message code is e104  force de-activation
                                if ($response_block->status_code == 'e002' || $response_block->status_code == 'e104' || $response_block->status_code == 'e110')
                                {
                                    $license_data = DE_DMACH_licence::get_licence_data();

                                    //save the license
                                    $license_data['key']          = '';
                                    $license_data['last_check']   = time();

                                    DE_DMACH_licence::update_licence_data ( $license_data );
                                }
                                else
                                {
                                    $slt_form_submit_messages[] = __('There was a problem deactivating the licence: ', 'divi-machine') . $response_block->message;

                                    $result = array(
                                        'result'    => 'error',
                                        'message'   => $slt_form_submit_messages
                                    );
                                    
                                    return $result;
                                }
                        }
                        else
                        {
                            $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . DE_DMACH_APP_API_URL, 'divi-machine');
                            $result = array(
                                'result'    => 'error',
                                'message'   => $slt_form_submit_messages
                            );
                            
                            return $result;
                        }

                        //redirect
                        /*$current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                        wp_redirect($current_url);
                        die();*/

                        $result = array(
                            'result'    => 'success',
                            'message'   => ''
                        );
                        
                        return $result;
                    }



                    if (isset($_POST['machine_licence_form_submit']) && wp_verify_nonce($_POST['divi_machine_license_nonce'], 'divi_machine_license'))
                    {

                        $license_key = isset($_POST['license_key'])? sanitize_key(trim($_POST['license_key'])) : '';

                        if($license_key == '')
                        {
                            $slt_form_submit_messages[] = __("License Key can't be empty", 'divi-machine');

                            $result = array(
                                'result'    => 'error',
                                'message'   => $slt_form_submit_messages,
                                'message_type' => 'empty_license'
                            );
                            
                            return $result;
                        }

                        //build the request query
                        $args = array(
                                            'woo_sl_action'         => 'activate',
                                            'licence_key'       => $license_key,
                                            'product_unique_id'        => DE_DMACH_PRODUCT_ID,
                                            'domain'          => DE_DMACH_INSTANCE
                                        );
                        $request_uri    = DE_DMACH_APP_API_URL . '?' . http_build_query( $args , '', '&');
                        $data           = wp_remote_get( $request_uri );

                        //log if debug
                        if (defined('WP_DEBUG') &&  WP_DEBUG    === TRUE)
                        {
                            DE_DMACH::log_data("------\nArguments:");
                            DE_DMACH::log_data($args);

                            if( is_wp_error( $data ) || $data['response']['code'] != 200) {
                                DE_DMACH::log_data("\nResult - Failed:");
                                DE_DMACH::log_data($data);
                            } else {
                                DE_DMACH::log_data("\nResponse Body:");
                                DE_DMACH::log_data($data['body']);
                                DE_DMACH::log_data("\nResponse Server Response:");
                                DE_DMACH::log_data($data['response']);
                            }
                        }

                        if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        {
                            if ( $data['response']['code'] == 403 ) {
                                $header_data = $data['headers']->getAll();
                                $cf_ray = $header_data['cf-ray'];
                                $slt_form_submit_messages[] .= __('There was a problem connecting to diviengine.com. It seems our firewall blocked you from accessing our server. Please contact support with this Ray ID: ', 'divi-machine') . $cf_ray;
                            } else {
                                $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'divi-machine') . DE_DMACH_APP_API_URL;    
                            }

                            $result = array(
                                'result'    => 'error',
                                'message'   => $slt_form_submit_messages
                            );
                            
                            return $result;
                        }

                        $response_block = json_decode($data['body']);
                        //retrieve the last message within the $response_block
                        $response_block = $response_block[count($response_block) - 1];
                        $response = $response_block->message;

                        if(isset($response_block->status))
                        {
                            if($response_block->status == 'success' && ( $response_block->status_code == 's100' || $response_block->status_code == 's101' ) )
                                {
                                    //the license is active and the software is active
                                    $slt_form_submit_messages[] = $response_block->message;

                                    $license_data = DE_DMACH_licence::get_licence_data();

                                    //save the license
                                    $license_data['key']          = $license_key;
                                    $license_data['last_check']   = time();

                                    DE_DMACH_licence::update_licence_data ( $license_data );

                                }
                                else
                                {
                                    $slt_form_submit_messages[] = __('There was a problem activating the licence: ', 'divi-machine') . $response_block->message;
                                    $result = array(
                                        'result'    => 'error',
                                        'message'   => $slt_form_submit_messages
                                    );
                                    
                                    return $result;
                                }
                        }
                        else
                        {
                            $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . DE_DMACH_APP_API_URL, 'divi-machine');
                            $result = array(
                                'result'    => 'error',
                                'message'   => $slt_form_submit_messages
                            );
                            
                            return $result;
                        }
                        
                        //redirect
                        /*$current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                        wp_redirect($current_url);
                        die();*/

                        $result = array(
                            'result'    => 'success',
                            'message'   => ''
                        );
                        
                        return $result;
                    }

                    $result = array(
                        'result'    => 'error',
                        'message'   => ''
                    );
                    
                    return $result;

                }

            function licence_form_machine()
                {
                ob_start();
                ?>
                <div class="wrap">
                    <?php wp_nonce_field('divi_machine_license', 'divi_machine_license_nonce') ?>
                    <input type="hidden" name="machine_licence_form_submit" value="true" />
                    <input type="text" value="" name="license_key" class="text-input">
                    <div class="explain" style="font-style: italic;">
                        <?php echo esc_html__(" Please enter your personal license key from your Divi Engine account. You can find it at: ", 'divi-machine'  ) ?>    '<a href="https://diviengine.com/my-account/" target="_blank"><?php echo esc_html__("My Account", 'divi-machine'  ) ?> </a>'<br />
                        <?php echo esc_html__("More keys can be generate from ", 'divi-machine' ) ?> <a href="https://diviengine.com/my-account/" target="_blank"><?php echo esc_html__("My Account", 'divi-machine'  ) ?></a>
                    </div>
                </div>
            <?php
                return ob_get_clean();

            }

            function licence_deactivate_form()
            {
                $license_data = DE_DMACH_licence::get_licence_data();
                
                ob_start();
            ?>
                <div class="wrap">
                    <?php wp_nonce_field('divi_machine_license', 'divi_machine_license_nonce') ?>
                    <input type="hidden" name="machine_licence_form_submit" value="true" />
                    <input type="hidden" name="machine_licence_deactivate" class="licence_deactivate" value="false" />
                    <div class="option">
                        <div class="controls">
            <?php
                if ($this->licence->is_local_instance()) {
            ?>
                            <p>Local instance, no key applied.</p>
            <?php
                } else {
            ?>
                            <p><b><?php echo substr($license_data['key'], 0, 20)?>-xxxxxxxx-xxxxxxxx</b> &nbsp;&nbsp;&nbsp;
                                <button class="et-save-button button-primary" title="Deactivate" id="license_deactivate">Deactivate</button>
                            </p>
            <?php
                }
            ?>
                        </div>
                        <div class="explain" style="font-style:italic;">
                            <?php echo esc_html__("You can generate more keys from ", 'divi-machine') ?><a href="https://diviengine.com/my-account/" target="_blank">My Account</a>
                        </div>
                    </div>
                </div>
            <?php
                return ob_get_clean();
            }

            function licence_multisite_require_nottice()
                {
                    ?>
                        <div class="wrap">
                            <div id="icon-settings" class="icon32"></div>
                            <h2><?php _e( "General Settings", 'divi-machine' ) ?></h2>

                            <h2 class="subtitle"><?php _e( "Divi Machine Software License", 'divi-machine' ) ?></h2>
                            <div id="form_data">
                                <div class="postbox">
                                    <div class="section section-text ">
                                        <h4 class="heading"><?php _e( "License Key Required", 'divi-machine' ) ?>!</h4>
                                        <div class="option">
                                            <div class="explain"><?php _e( "Enter the License Key you got when bought this product. If you lost the key, you can always retrieve it from", 'divi-machine' ) ?> <a href="http://diviengine.com/my-account/" target="_blank"><?php _e( "My Account", 'divi-machine' ) ?></a><br />
                                            <?php _e( "More keys can be generate from", 'divi-machine' ) ?> <a href="http://diviengine.com/my-account/" target="_blank"><?php _e( "My Account", 'divi-machine' ) ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php

                }


        }



?>
