<?php
// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;
// check if class already exists
if( !class_exists('acf_field_phone') ) :
class acf_field_phone extends acf_field {


	function __construct( $settings = array() ) {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'dmachphone';


		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __('Phone Number', 'divi-machine');


		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'basic';


		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/

		$this->l10n = array(
			'error'	=> __('Error! Please enter a valid phone number.', 'divi-machine'),
		);

		$this->defaults = array(
			'default_value'	=> '',
			'placeholder'	=> '',
			'prepend'		=> '',
			'append'		=> ''
		);


		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/

		$this->settings = $settings;


		// do not delete!
    	parent::__construct();

	}

	/*
	*  render_field_settings()
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*/

	function render_field_settings( $field ) {

		// default_value
		acf_render_field_setting( $field, array(
			'label'			=> __('Default Value','divi-machine'),
			'instructions'	=> __('Appears when creating a new post','divi-machine'),
			'type'			=> 'text',
			'name'			=> 'default_value',
		));


		// placeholder
		acf_render_field_setting( $field, array(
			'label'			=> __('Placeholder Text','divi-machine'),
			'instructions'	=> __('Appears within the input','divi-machine'),
			'type'			=> 'text',
			'name'			=> 'placeholder',
		));


		// prepend
		acf_render_field_setting( $field, array(
			'label'			=> __('Prepend','divi-machine'),
			'instructions'	=> __('Appears before the input','divi-machine'),
			'type'			=> 'text',
			'name'			=> 'prepend',
		));


		// append
		acf_render_field_setting( $field, array(
			'label'			=> __('Append','divi-machine'),
			'instructions'	=> __('Appears after the input','divi-machine'),
			'type'			=> 'text',
			'name'			=> 'append',
		));

	}


	/*
	*  render_field()
	*  Create the HTML interface for your field
	*/

	function render_field( $field ) {

		// vars
		$atts = array();
		$o = array( 'type', 'id', 'class', 'name', 'value', 'placeholder' );
		$s = array( 'readonly', 'disabled' );
		$e = '';
		$field[ 'type' ] = 'text';

		// prepend
		if( $field['prepend'] !== "" ) {

			$field['class'] .= ' acf-is-prepended';
			$e .= '<div class="acf-input-prepend">' . $field['prepend'] . '</div>';

		}

		// append
		if( $field['append'] !== "" ) {

			$field['class'] .= ' acf-is-appended';
			$e .= '<div class="acf-input-append">' . $field['append'] . '</div>';

		}

		// append atts
		foreach( $o as $k ) {

			$atts[ $k ] = $field[ $k ];

		}

		// append special atts
		foreach( $s as $k ) {

			if( !empty($field[ $k ]) ) $atts[ $k ] = $k;

		}

		// render
		$e .= '<div class="acf-input-wrap">';
		$e .= '<input ' . acf_esc_attr( $atts ) . ' />';
		$e .= '</div>';

		// return
		echo $e;

	}

	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*/

	// function input_admin_enqueue_scripts() {

	// 	// vars
	// 	$url = $this->settings['url'];
	// 	$version = $this->settings['version'];


	// }

	/*
	*  load_value()
	*  This filter is applied to the $value after it is loaded from the db
	*/

	function load_value( $value, $post_id, $field ) {

		return $value;

	}


	/*
	*  update_value()
	*  This filter is applied to the $value before it is saved in the db
	*/

	function update_value( $value, $post_id, $field ) {

		return $value;

	}


	/*
	*  format_value()
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*/

	function format_value( $value, $post_id, $field ) {

		// bail early if no value
		if( empty($value) ) {

			return $value;

		}

		// return
		return $value;
	}


	/*
	*  validate_value()
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*/

	function validate_value( $valid, $value, $field, $input )
	{

		if ( empty( $value ) ) {
			return $valid;
		}

		// if( ! preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $value) )
		// {
		// 	if ( ! preg_match("/(\(\d{3}+\)+ \d{3}+\-\d{4}+)/", $value) )
		// 	{
		// 		$valid = __('Please enter valid phone number!','divi-machine');
		// 	}
		// }

		// return
		return $valid;

	}


	/*
	*  load_field()
	*  This filter is applied to the $field after it is loaded from the database
	*/

	function load_field( $field ) {

		return $field;

	}

	/*
	*  update_field()
	*  This filter is applied to the $field before it is saved to the database
	*/

	function update_field( $field ) {

		return $field;

	}


}
// initialize
new acf_field_phone( );
// class_exists check
endif;