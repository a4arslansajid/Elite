<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class DE_Machine extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divi-machine';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-machine';

	/**
	 * The extension's version
	 *
	 * @since 2.1.5
	 *
	 * @var string
	 */
	public $version = DE_DMACH_VERSION;
	/**
	 * DE_Machine constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-machine', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}

	public static function mach_create_modules_mw() {

		$de_plugin_array = array(
			'divi-machine' => array(
				'plugin_path'	=> 'divi-machine/divi-machine.php',
				'plugin_name'	=> 'Divi Machine',
				'plugin_de_id'	=> 'DE_DM',
				'plugin_et_id'	=> ''
			),
			'divi-bodycommerce' => array(
				'plugin_path'	=> 'divi-bodycommerce/divi-bodyshop-woocommerce.php',
				'plugin_name'	=> 'Divi BodyCommerce',
				'plugin_de_id'	=> 'DE_DB',
				'plugin_et_id'	=> ''
			),
			'divi-ajax-filter' => array(
				'plugin_path'	=> 'divi-ajax-filter/divi-ajax-filter.php',
				'plugin_name'	=> 'Divi Ajax Filter',
				'plugin_de_id'	=> 'DE_DAF',
				'plugin_et_id'	=> ''
			),
			'divi-form-builder' => array(
				'plugin_path' 	=> 'divi-form-builder/divi-form-builder.php',
				'plugin_name'	=> 'Divi Form Builder',
				'plugin_de_id'	=> 'DE_FB',
				'plugin_et_id'	=> ''
			),
			'divi-mega-menu'	=> array(
				'plugin_path'	=> 'divi-mega-menu/divi-mega-menu.php',
				'plugin_name'	=> 'Divi Mega Menu',
				'plugin_de_id'	=> 'DE_DMM',
				'plugin_et_id'	=> '352'
			),
			'divi-mobile'		=> array(
				'plugin_path'	=> 'divi-mobile/divi-mobile.php',
				'plugin_name'	=> 'Divi Mobile',
				'plugin_de_id'	=> 'DE_DM',
				'plugin_et_id'	=> '353'
			),
			'divi-nitro'		=> array(
				'plugin_path'	=> 'divi-nitro/divi-nitro.php',
				'plugin_name'	=> 'Divi Nitro',
				'plugin_de_id'	=> 'DE_DN',
				'plugin_et_id'	=> ''
			),
			'divi-protect'		=> array(
				'plugin_path'	=> 'divi-protect/divi-protect.php',
				'plugin_name'	=> 'Divi Protect',
				'plugin_de_id'	=> 'DE_DP',
				'plugin_et_id'	=> ''
			)
		);

		$de_get = get_option( 'de_plugins', array() );

		$result = array();

		$aj_gaket = get_option( 'et_automatic_updates_options' );
		$aj_gaket_val = $aj_gaket['api_key'];

		foreach( $de_plugin_array as $plugin_key => $plugin_data ) {

			if ( is_plugin_active( $plugin_data['plugin_path'] ) ) {
				$code_d = '0';

				if ( in_array( $plugin_data['plugin_de_id'] , $de_get ) ) {
					$code_d = '1';
				}

				$code_m = "na";

				if ( $plugin_data['plugin_et_id'] != '' ) {
					if ( isset( $product_id ) ) {
						$json = file_get_contents('https://www.elegantthemes.com/marketplace/index.php/wp-json/api/v1/check_subscription/product_id/'.$product_id.'/api_key/'.$aj_gaket_val);
					}
					$data = json_decode($json);
					$code_m = $data->code;
				}
				if(defined('DE_FB_P')){
					$result[ $plugin_data['plugin_name'] ] = array (
						'p_f' => DE_FB_P,
						'd_l' => $code_d,
						'm_l' => $code_m
					);
				}
			}			
		}

		return $result;
	}

	public function de_setup_rest_api() {
		register_rest_route( 'de_plugins', '/products/', array(
			'methods' => 'GET',
			'callback' => array( $this, 'mach_create_modules_mw' ),
		) );
	}


}

new DE_Machine;
