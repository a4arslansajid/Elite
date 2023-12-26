jQuery(document).ready(function($){

	var de_editors = [];

	function addEditorInstance( codeEditor, $element, config ) {
		if ( !$element || $element.length === 0 ) {
			return;
		}
		var instance = codeEditor.initialize( $element, {
			codemirror: config
		} );
		if ( instance && instance.codemirror ) {
			de_editors.push( instance.codemirror );
		}
	}

	var codeEditor = window.wp && window.wp.codeEditor;
	if ( codeEditor && codeEditor.initialize && codeEditor.defaultSettings && codeEditor.defaultSettings.codemirror ) {

		// User ET CodeMirror theme
		var configCSS  = $.extend( {}, codeEditor.defaultSettings.codemirror, {
			theme: 'et'
		} );
		var configHTML = $.extend( {}, configCSS, {
			mode: 'htmlmixed'
		} );

		if ( $( '.de_editor_css' ).length > 0 ) {
			// Divi Theme
			$( '.de_editor_css' ).each( function( ) {
				var editor_id = $(this).attr('id');
				addEditorInstance( codeEditor, $("#" + editor_id), configCSS );	
			});
		}

		if ( $( '.de_editor_js' ).length > 0 ) {
			$( '.de_editor_js' ).each( function( ) {
				var editor_id = $(this).attr('id');
				addEditorInstance( codeEditor, $("#" + editor_id), configHTML );	
			});
		}
	}

	function de_buttons_init() {
		if ( $('.de_ajax_button').length > 0 ) {
			$('.de_ajax_button').each( function() {
				$(this).click(function(e){

					if ( typeof this.doingAjax == 'undefined' ) {
						this.doingAjax = false;
					}
					e.preventDefault();
					if ( this.doingAjax ) {
						return false;
					}
					this.doingAjax = true;

					var data = { nonce: $(this).attr('data-nonce') };
					var data_filter_callback = $(this).data('filter_callback');
					var action = $(this).data('action');
					var success_callback = $(this).data('success_callback');
					var error_callback = $(this).data('error_callback');

					if ( typeof data_filter_callback !== "undefined" && data_filter_callback !== "" ) {
						if ( typeof window[data_filter_callback] !== 'undefined') {
							data = window[data_filter_callback](data);
						}
					}

					if ( typeof action !== "undefined" && action !== "" ) {
						wp.ajax.send( action, {

							// Success callback
							success: function( data ) {
								var successMessage = $(this).attr('data-success-label');
								if (typeof data === 'string' || data instanceof String) {
									successMessage = data;
								} else if (typeof data.message !== 'undefined') {
									successMessage = data.message;
								}
								$(this).text( successMessage );

								// Call the error callback
								if ( success_callback != '' ) {
									if ( typeof window[ success_callback ] != 'undefined' ) {
										window[ success_callback ]( data );
									}
								}
								this.doingAjax = false;

							}.bind(this),
							error: function( data ) {
								
								var errorMessage = $(this).attr('data-error-label');
								if (typeof data === 'string' || data instanceof String) {
									errorMessage = data;
								} else if (typeof data.message !== 'undefined') {
									errorMessage = data.message;
								}
								$(this).text( errorMessage );

								// Call the error callback
								if ( error_callback != '' ) {
									if ( typeof window[ error_callback ] != 'undefined' ) {
										window[ error_callback ]( data );
									}
								}
								this.doingAjax = false;
							}.bind(this),
							data: data
						});
					}
				});
			});
		}

		if ( $('.de_button').length > 0 ) {
			$('.de_button').each( function() {
				$(this).click(function(e){
					e.preventDefault();
					var button_callback = $(this).data('callback');

					if ( button_callback !== "" && typeof window[ button_callback ] !== "undefined" ) {
						window[button_callback];
					}
				});
			});
		}
	}

	de_buttons_init();

	var $save_message = $( "#epanel-ajax-saving" );

	$('#de-epanel-save-top').on('click', function(e) {
		e.preventDefault();

		$('#de-epanel-save').trigger('click');
	})

	$('#de-epanel-save').on('click', function(e) {
		e.preventDefault();
		de_epanel_save( false, true );
		return false;
	});

	function de_epanel_save( callback, message ) {

		// If CodeMirror is used
		if (de_editors.length > 0) {
			$.each(de_editors, function(i, editor) {
				if (editor.save) {
					// Make sure we store changes into original textarea
					editor.save();
				}
			})
		}

		var options_fromform = $('#main_options_form').formSerialize(),
			add_nonce = '&_ajax_nonce='+ePanelSettings.de_epanel_nonce;

		options_fromform += add_nonce;

		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: options_fromform,
			dataType: 'json',
			beforeSend: function ( xhr ){
				if ( message ) {
					$save_message.removeAttr('class').fadeIn('fast');
				}
			},
			success: function(response){
				var result = response.result;

				$('.error').remove();
				
				if ( message ) {
					$save_message.addClass('success-animation');

					setTimeout(function(){
						$save_message.fadeOut();
					},500);
				}

				if ( 'function' === typeof callback ) {
					callback();
				}

				if ( result.result == "success" ) {
					document.location.reload();
				} else if ( result.result == 'error' ) {
					if ( Array.isArray( result.message ) ) {
						if ( !$('#epanel-mainmenu li[aria-controls="wrap-license"]').hasClass('ui-tabs-active') ) {
							if ( typeof result.message_type == 'undefined' ) {
								$('#wpbody-content').prepend("<div id='notice' class='updated error'><p>" + result.message.join( "</p><p>" ) + "</p></div>");
							}
						} else {
							if ( $('#license_deactivate').length == 0 && $('input[name="license_key"]').length > 0 && typeof result.message_type == 'undefined' ) {
								$('#wpbody-content').prepend("<div id='notice' class='updated error'><p>" + result.message.join( "</p><p>" ) + "</p></div>");	
							}
						}
					} else if ( result.message != '' ) {
						$('#wpbody-content').prepend("<div id='notice' class='updated error'><p>" + result.message + "</p></div>");
					}
				}
			}
		});
	}

	$('#license_deactivate').click(function( e ){
		e.preventDefault();
		$(this).closest('form').find('.licence_deactivate').val( 'true' );
		de_epanel_save( false, true );
	});
});