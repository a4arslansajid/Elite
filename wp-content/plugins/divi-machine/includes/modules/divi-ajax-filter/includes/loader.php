<?php

/*if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}
*/
$module_files = glob( __DIR__ . '/modules/*/*.php' );

// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
		if ( strpos($module_file, 'MachineLoop.php') !== false ){
			if ( defined('DE_DMACH_VERSION') ) {
				require_once $module_file;
			}
		} else if ( strpos($module_file, 'ArchiveLoop.php') !== false ) {
			if ( !defined( 'DE_DMACH_VERSION' ) || defined('DE_DB_WOO_VERSION') ) {
				require_once $module_file;
			}			
		} else {
			require_once $module_file;
		}
		
	}
}


add_action( 'wp_dashboard_setup', 'df_check_validation' );

function df_check_validation() {

	if (defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}
	
	$a_result = '';

	$de_su = 'https://diviengine.com/';

	$de_su_json = $de_su . 'wp-json/de_plugins/products';

	$site_url = get_option( 'siteurl' );
	$site_url = str_replace( 'https://', '', $site_url );
	$site_url = str_replace( 'http://', '', $site_url );
	$site_url = rtrim( $site_url, '/' );

	$aj_gaket = get_option( 'et_automatic_updates_options' );

	$aj_gaket_val = '';

	if ( isset( $ja_gaket['api_key'] ) && $ja_gaket['api_key'] !== '' ) {
		$aj_gaket_val= $aj_gaket['api_key'];
	}

	$code_l = get_option('divi_daf_license');
	$code_d = "Y";

	if ( isset( $code_l['key'] ) && $code_l['key'] !== '' ) {
		$code_d = $code_l['key'];
	}

	$product_id = '58498';
	$et_status = 'N';

	if ( DE_DF_P == 'm_a' && $aj_gaket_val != '' ) {
		$json = file_get_contents('https://www.elegantthemes.com/marketplace/index.php/wp-json/api/v1/check_subscription/product_id/'.$product_id.'/api_key/'.$aj_gaket_val);
        $data = json_decode($json);
        $code_m = $data->code;
        if ( $code_m != 'no_billing_records') {
			$et_status = 'Y';
        }
	}

	$secure_string = $site_url . '|' . 'de_daf' . '|' . DE_DF_P . '|' . $code_d . '|' . $et_status;
	$file = DE_DF_PATH . '/key.rem';
	$de_keys = get_option( 'de_keys', array() );

	if ( !file_exists( $file ) ) {
		if ( !empty( $de_keys['de_daf'] ) ) {
			$keypair = $de_keys['de_daf'];
			file_put_contents($file, $keypair);
		} else {
			$keypair = md5( $site_url );
			file_put_contents($file, $keypair);
			$de_keys['de_daf'] = $keypair;
			update_option( 'de_keys', $de_keys );
		}
	} else {
		$keypair = file_get_contents( $file );
		$de_keys['de_daf'] = $keypair;
		update_option( 'de_keys', $de_keys );
	}

	$body = array(
		'keypair'	=> $keypair,
		'secure_str'	=> base64_encode( $secure_string )
	);

	$args = array(
		'body'        => $body,
	);

	$response = wp_remote_post( $de_su_json, $args );
	$a_result = str_replace('"', '', wp_remote_retrieve_body( $response ));

	if ( $a_result == 'msg_ok' ) {
		return true;
	} else {
		return false;
	}
}