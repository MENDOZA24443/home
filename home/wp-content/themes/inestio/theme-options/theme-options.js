/* global jQuery:false */
/* global INESTIO_STORAGE:false */

//-------------------------------------------
// Theme Options fields manipulations
//-------------------------------------------

jQuery( window ).on( 'scroll', function() {

	"use strict";

	var header = jQuery( '.inestio_options_header' );
	if ( header.length !== 0 ) {
		var placeholder = jQuery( '.inestio_options_header_placeholder' );
		if ( jQuery( '.inestio_options_header_placeholder' ).length === 0 ) {
			jQuery( '.inestio_options_header' ).before( '<div class="inestio_options_header_placeholder"></div>' );
			placeholder = jQuery( '.inestio_options_header_placeholder' );
		}
		if ( placeholder.length !== 0 ) {
			header.toggleClass( 'sticky', placeholder.offset().top <= jQuery( window ).scrollTop() + jQuery( '#wpadminbar' ).height() );
		}
	}
} );


jQuery( document ).ready( function() {

	"use strict";

	// Mark field as 'changed' on any field change
	jQuery( '.inestio_options .inestio_options_item_field [name^="inestio_options_field_"]' )
		.on( 'change', function () {
			var obj = jQuery( this ),
				par = obj.parents('.inestio_options_group');
			if ( par.length > 0 ) {
				// On change any field of a group - mark all fields in this group as changed
				par.find('[data-param]').data( 'param-changed', 1 );
			} else {
				// On change other fields - mark only this field
				obj.parents('[data-param]').eq(0).data( 'param-changed', 1 );
			}
		} );


	// Save options
	jQuery( '.inestio_options_button_submit' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.inestio_options' ).find( 'form' );
			// Prevent to send unchanged values
			if ( inestio_options_vars['save_only_changed_options'] ) {
				form.find('[data-param]').each( function() {
					if ( jQuery( this ).data( 'param-changed' ) === undefined ) {
						jQuery( this ).find( 'input,select,textarea' ).each( function() {
							// Disable fields to prevent send to the server
							jQuery( this ).get( 0 ).disabled = true;
							// or another way - remove fields: jQuery( this ).remove()
						} );
					}
				});
			}
			// Send data to the server
			form.submit();
			e.preventDefault();
			return false;
		} );

	// Reset options
	jQuery( '.inestio_options_button_reset' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.inestio_options' ).find( 'form' );
			if ( typeof trx_addons_msgbox_confirm != 'undefined' ) {
				trx_addons_msgbox_confirm(
					INESTIO_STORAGE[ 'msg_reset_confirm' ],
					INESTIO_STORAGE[ 'msg_reset' ],
					function( btn ) {
						if ( btn === 1 ) {
							form.find( 'input[name="inestio_options_field_reset_options"]' ).val( 1 );
							form.submit();
						}
					}
				);
			} else if ( confirm( INESTIO_STORAGE[ 'msg_reset_confirm' ] ) ) {
				form.find( 'input[name="inestio_options_field_reset_options"]' ).val( 1 );
				form.submit();
			}
			e.preventDefault();
			return false;
		} );

	// Export options
	jQuery( '.inestio_options_button_export' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.inestio_options' ).find( 'form' ),
				data = '';
			form.find('[data-param]').each( function() {
				jQuery( this )
					.find('[name^="inestio_options_field_' + jQuery(this).data('param') + '"]')
					.each(function() {
						var fld = jQuery(this),
							fld_name = fld.attr('name'),
							fld_type = fld.attr('type') ? fld.attr('type') : fld.get(0).tagName.toLowerCase();
						if ( fld_type == 'checkbox' ) {
							data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.get(0).checked ? fld.val() : 0 );
						} else if ( fld_type != 'radio' || fld.get(0).checked ) {
							data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.val() );
						}
					});
			});
			if ( typeof trx_addons_msgbox_info != 'undefined' ) {
				trx_addons_msgbox_info(
					jQuery.inestio_encoder.encode( data ),
					INESTIO_STORAGE[ 'msg_export' ] + ': ' + INESTIO_STORAGE[ 'msg_export_options' ],
					'info',
					0
				);
			} else {
				alert( INESTIO_STORAGE[ 'msg_export_options' ] + ':\n\n' + jQuery.inestio_encoder.encode( data ) );
			}
			e.preventDefault();
			return false;
		} );

	// Import options
	jQuery( '.inestio_options_button_import' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.inestio_options' ).find( 'form' ),
				data = '';
			if ( typeof trx_addons_msgbox_dialog != 'undefined' ) {
				trx_addons_msgbox_dialog(
					'<textarea rows="10" cols="100"></textarea>',
					INESTIO_STORAGE[ 'msg_import' ] + ': ' + INESTIO_STORAGE[ 'msg_import_options' ],
					null,
					function(btn, box) {
						if ( btn === 1 ) {
							inestio_options_import_data( box.find('textarea').val() );
						}
					}
				);
			} else if ( ( data = prompt( INESTIO_STORAGE[ 'msg_import_options' ], '' ) ) !== '' ) {
				inestio_options_import_data( data );
			}

			function inestio_options_import_data( data ) {
				if ( data ) {
					data = jQuery.inestio_encoder.decode( data ).split( '&' );
					for ( var i in data ) {
						var param = data[i].split('=');
						if ( param.length == 2 && param[0].substr(-6) != '_nonce' ) {
							var fld = form.find('[name="'+param[0]+'"]'),
								val = decodeURIComponent(param[1]);
							if ( fld.attr('type') == 'radio' || fld.attr('type') == 'checkbox' ) {
								fld.removeAttr( 'checked' );
								fld.each( function() {
									var item = jQuery(this);
									if ( item.val() == val ) {
										item.get(0).checked = true;
										item.attr('checked', 'checked');
									}
								} );
							} else {
								fld.val( val );
							}
						}
					}
					form.submit();
				} else {
					if ( typeof trx_addons_msgbox_warning != 'undefined' ) {
						trx_addons_msgbox_warning(
							INESTIO_STORAGE[ 'msg_import_error' ],
							INESTIO_STORAGE[ 'msg_import' ]
						);
					}
				}
			}

			e.preventDefault();
			return false;

		} );

	// Create preset with options
	jQuery( '.inestio_options_presets_add' )
		.on( 'click', function( e ) {
			if ( typeof trx_addons_msgbox_dialog != 'undefined' ) {
				var preset_name = '';
				trx_addons_msgbox_dialog(
					'<label>' + INESTIO_STORAGE[ 'msg_presets_add' ]
						+ '<br><input type="text" value="" name="preset_name">'
						+ '</label>',
					INESTIO_STORAGE[ 'msg_presets' ],
					null,
					function(btn, box) {
						if ( btn === 1 ) {
							var preset_name = box.find('input[name="preset_name"]').val();
							if ( preset_name !== '' ) {
								inestio_options_presets_create( preset_name );
							}
						}
					}
				);
			} else if ( ( preset_name = prompt( INESTIO_STORAGE[ 'msg_presets_add' ], '' ) ) !== '' ) {
				inestio_options_presets_create( preset_name );
			}
			// Create new preset: send it to server and add to the presets list
			function inestio_options_presets_create( preset_name ) {
				var form = jQuery( '.inestio_tabs' ),
					data = '';
				form.find('[data-param]').each( function() {
					jQuery( this )
						.find('[name^="inestio_options_field_' + jQuery(this).data('param') + '"]')
						.each(function() {
							var fld = jQuery(this),
								fld_name = fld.attr('name'),
								fld_type = fld.attr('type') ? fld.attr('type') : fld.get(0).tagName.toLowerCase(),
								in_group = fld_name.indexOf('[') > 0;
							if ( fld_name == 'inestio_options_field_presets' ) {
								return;
							} else if ( fld.parents( in_group ? '.inestio_options_group' : '.inestio_options_item' ).hasClass( 'inestio_options_inherit_on' ) ) {
								data += ( data ? '&' : '' ) + fld_name + '=inherit';
							} else if ( fld_type == 'checkbox' ) {
								data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.get(0).checked ? fld.val() : 0 );
							} else if ( fld_type != 'radio' || fld.get(0).checked ) {
								data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.val() );
							}
						});
				});
				data = jQuery.inestio_encoder.encode( data );
				jQuery.post(INESTIO_STORAGE['ajax_url'], {
					action: 'inestio_add_options_preset',
					nonce: INESTIO_STORAGE['ajax_nonce'],
					preset_name: preset_name,
					preset_data: data,
					preset_type: jQuery( '.inestio_options_presets_list' ).data( 'type' )
				}).done(function(response) {
					var rez = {};
					if (response === '' || response === 0) {
						rez = { error: INESTIO_STORAGE['msg_ajax_error'] };
					} else {
						try {
							rez = JSON.parse(response);
						} catch (e) {
							rez = { error: INESTIO_STORAGE['msg_ajax_error'] };
							console.log(response);
						}
					}
					if ( rez.success ) {
						var presets_list = jQuery( '.inestio_options_presets_list' ).get(0),
							idx = inestio_find_listbox_item_by_text( presets_list, preset_name );
						if ( idx >= 0 ) {
							presets_list.options[idx].value = data;
						} else {
							inestio_add_listbox_item( presets_list, data, preset_name );
						}
						inestio_select_listbox_item_by_text( presets_list, preset_name );
					}
					if ( typeof window.trx_addons_msgbox != 'undefined' ) {
						trx_addons_msgbox({
							msg: rez.error ? rez.error : rez.success,
							hdr: INESTIO_STORAGE[ 'msg_presets' ],
							icon: rez.error ? 'cancel' : 'check',
							type: rez.error ? 'error' : 'success',
							delay: 0,
							buttons: [ TRX_ADDONS_STORAGE['msg_caption_ok'] ],
							callback: null
						});
					} else {
						alert( rez.error ? rez.error : rez.success );
					}
				});
			}
			e.preventDefault();
			return false;
		} );

	// Apply selected preset
	jQuery( '.inestio_options_presets_apply' )
		.on( 'click', function( e ) {
			var preset_data = jQuery( '.inestio_options_presets_list' ).val();
			if ( preset_data !== '' ) {
				if ( typeof trx_addons_msgbox_confirm != 'undefined' ) {
					trx_addons_msgbox_confirm(
						INESTIO_STORAGE[ 'msg_presets_apply' ],
						INESTIO_STORAGE[ 'msg_presets' ],
						function(btn, box) {
							if ( btn === 1 ) {
								inestio_options_presets_apply( preset_data );
							}
						}
					);
				} else if ( confirm( INESTIO_STORAGE[ 'msg_presets_apply' ] ) ) {
					inestio_options_presets_apply( preset_data );
				}
			}
			function inestio_options_presets_apply( data ) {
				var form = jQuery( '.inestio_tabs' );
				data = jQuery.inestio_encoder.decode( data ).split( '&' );
				for ( var i in data ) {
					var param = data[i].split('=');
					if ( param.length == 2 && param[0].substr(-6) != '_nonce' && param[0].substr(-8) != '_presets' ) {
						var fld = form.find('[name="'+param[0]+'"]'),
							val = decodeURIComponent(param[1]),
							pos = param[0].indexOf('[');
						if ( pos > 0 ) {
							var base = param[0].substring(0, pos),
								fields = form.find( '[name^="' + base + '["]' ).eq(0).parents('.inestio_options_group_fields');
							if ( fields.length > 0 ) {
								if ( ! fields.data( 'clear' ) ) {
									fields.data( 'clear', true );
									var items = fields.find( '.inestio_options_clone' );
									items.each( function( idx ) {
										if ( idx > 0 ) {
											jQuery(this).remove();
										}
									} );
								}
								if ( fld.length == 0 ) {									
									fields.find( '.inestio_options_clone_button_add' ).trigger( 'click' );
									fld = form.find('[name="'+param[0]+'"]');
								}
							}
						} else if ( fld.length == 0 ) {
							continue;
						}
						var type = fld.parents('[data-type]').data( 'type' );
						if ( val != 'inherit' ) {
							if ( type == 'switch' ) {
								fld.next().get( 0 ).checked = val == 1;
								fld.next().trigger('change');
							} else if ( fld.attr('type') == 'radio' || fld.attr('type') == 'checkbox' ) {
								fld.removeAttr( 'checked' );
								fld.each( function() {
									var item = jQuery(this);
									if ( item.val() == val ) {
										item.get(0).checked = true;
										item.attr('checked', 'checked');
									}
								} );
							} else {
								fld.val( val );
								if ( type == 'choice' ) {
									var choices = fld.next();
									choices.find('.inestio_list_active').removeClass('inestio_list_active');
									choices.find('[data-choice="'+val+'"]').addClass('inestio_list_active');
								} else if ( type == 'image' ) {
									var images = val.split( ','),
										preview = fld.next();
									preview.empty();
									for (var img=0; img < images.length; img++) {
										if ( images[img].trim() !== '' ) {
											preview
												.append(
													'<span class="inestio_media_selector_preview_image" tabindex="0">'
														+ '<img src="' + images[img].trim() + '">'
														+ '</span>'
												)
												.css( {
													'display': 'block'
												} );
										}
									}
								}
							}
							fld.trigger( 'change' );
						}
						var item = pos > 0 ? fld.parents( '.inestio_options_group ' ) : fld.parents( '.inestio_options_item' );
						if ( ( val == 'inherit' && ! item.hasClass( 'inestio_options_inherit_on' ) )
							|| ( val != 'inherit' && ! item.hasClass( 'inestio_options_inherit_off' ) )
						) {
							item.find( '.inestio_options_inherit_lock' ).trigger( 'click' );
						}
					}
				}
				// Remove data from groups
				form.find( '.inestio_options_group_fields' ).each( function() {
					jQuery(this).data( 'clear', false );
				} );
			}
			e.preventDefault();
			return false;
		} );

	// Delete selected preset
	jQuery( '.inestio_options_presets_delete' )
		.on( 'click', function( e ) {
			var presets_list = jQuery( '.inestio_options_presets_list' ).get(0),
				preset_data  = inestio_get_listbox_selected_value( presets_list ),
				preset_name  = inestio_get_listbox_selected_text( presets_list );
			if ( preset_data ) {
				if ( typeof trx_addons_msgbox_confirm != 'undefined' ) {
					trx_addons_msgbox_confirm(
						INESTIO_STORAGE[ 'msg_presets_delete' ],
						INESTIO_STORAGE[ 'msg_presets' ],
						function(btn, box) {
							if ( btn === 1 ) {
								inestio_options_presets_delete( preset_name );
							}
						}
					);
				} else if ( confirm( INESTIO_STORAGE[ 'msg_presets_delete' ] ) ) {
					inestio_options_presets_delete( preset_name );
				}
			}
			function inestio_options_presets_delete( preset_name ) {
				jQuery.post(INESTIO_STORAGE['ajax_url'], {
					action: 'inestio_delete_options_preset',
					nonce: INESTIO_STORAGE['ajax_nonce'],
					preset_name: preset_name,
					preset_type: jQuery( '.inestio_options_presets_list' ).data( 'type' )
				}).done(function(response) {
					var rez = {};
					if (response === '' || response === 0) {
						rez = { error: INESTIO_STORAGE['msg_ajax_error'] };
					} else {
						try {
							rez = JSON.parse(response);
						} catch (e) {
							rez = { error: INESTIO_STORAGE['msg_ajax_error'] };
							console.log(response);
						}
					}
					if ( rez.success ) {
						inestio_del_listbox_item_by_text( presets_list, preset_name );
						inestio_select_listbox_item_by_value( presets_list, '' );
					}
					if ( typeof window.trx_addons_msgbox != 'undefined' ) {
						trx_addons_msgbox({
							msg: rez.error ? rez.error : rez.success,
							hdr: INESTIO_STORAGE[ 'msg_presets' ],
							icon: rez.error ? 'cancel' : 'check',
							type: rez.error ? 'error' : 'success',
							delay: 0,
							buttons: [ TRX_ADDONS_STORAGE['msg_caption_ok'] ],
							callback: null
						});
					} else {
						alert( rez.error ? rez.error : rez.success );
					}
				});
			}
			e.preventDefault();
			return false;
		} );


	// Toggle inherit button and cover
	jQuery( '#inestio_options_tabs' )
		.on( 'keydown', '.inestio_options_inherit_lock', function( e ) {
			// If 'Enter' or 'Space' is pressed - trigger click on this object
			if ( [ 13, 32 ].indexOf( e.which ) >= 0 ) {
				jQuery( this ).trigger( 'click' );
				e.preventDefault();
				return false;
			}
			return true;
		} )
		.on( 'click', '.inestio_options_inherit_lock,.inestio_options_inherit_cover', function (e) {
			var parent  = jQuery( this ).parents( '.inestio_options_item,.inestio_options_group' );
			var inherit = parent.hasClass( 'inestio_options_inherit_on' );
			if (inherit) {
				parent.removeClass( 'inestio_options_inherit_on' ).addClass( 'inestio_options_inherit_off' );
				parent.find( '.inestio_options_inherit_cover' ).fadeOut().find( 'input[type="hidden"]' ).val( '' ).trigger('change');
			} else {
				parent.removeClass( 'inestio_options_inherit_off' ).addClass( 'inestio_options_inherit_on' );
				parent.find( '.inestio_options_inherit_cover' ).fadeIn().find( 'input[type="hidden"]' ).val( 'inherit' ).trigger('change');

			}
			e.preventDefault();
			return false;
		} );


	// Refresh linked field
	jQuery( '#inestio_options_tabs' )
		.on( 'change', '[data-linked] select,[data-linked] input', function (e) {
			var chg_name          = jQuery( this ).parent().data( 'param' );
			var chg_value         = jQuery( this ).val();
			var linked_name       = jQuery( this ).parent().data( 'linked' );
			var linked_data       = jQuery( '#inestio_options_tabs [data-param="' + linked_name + '"]' );
			var linked_field      = linked_data.find( 'select' );
			var linked_field_type = 'select';
			if (linked_field.length == 0) {
				linked_field      = linked_data.find( 'input' );
				linked_field_type = 'input';
			}
			var linked_lock = linked_data.parent().parent().find( '.inestio_options_inherit_lock' ).addClass( 'inestio_options_wait' );
			// Prepare data
			var data = {
				action: 'inestio_get_linked_data',
				nonce: INESTIO_STORAGE['ajax_nonce'],
				chg_name: chg_name,
				chg_value: chg_value
			};
			jQuery.post(
				INESTIO_STORAGE['ajax_url'], data, function(response) {
					var rez = {};
					try {
						rez = JSON.parse( response );
					} catch (e) {
						rez = { error: INESTIO_STORAGE['msg_ajax_error'] };
						console.log( response );
					}
					if (rez.error === '') {
						if (linked_field_type == 'select') {
							var opt_list = '';
							for (var i in rez.list) {
								opt_list += '<option value="' + i + '">' + rez.list[i] + '</option>';
							}
							linked_field.html( opt_list );
						} else {
							linked_field.val( rez.value );
						}
						linked_lock.removeClass( 'inestio_options_wait' );
					}
				}
			);
			e.preventDefault();
			return false;
		} );

	// Blur the "load fonts" fields - regenerate options lists in the font-family controls
	jQuery( '.inestio_options [name^="inestio_options_field_load_fonts"]' ).on( 'focusout', inestio_options_update_load_fonts );

	// Change theme fonts options if load fonts is changed
	function inestio_options_update_load_fonts() {
		var opt_list = [], i, tag, sel, opt, name = '', family = '', val = '', new_val = '', sel_idx = 0;
		for (i = 1; i <= inestio_options_vars['max_load_fonts']; i++) {
			name = jQuery( '[name="inestio_options_field_load_fonts-' + i + '-name"]' ).val();
			if (name == '') {
				continue;
			}
			family = jQuery( '[name="inestio_options_field_load_fonts-' + i + '-family"]' ).val();
			opt_list.push( [name, family] );
		}
		for (tag in inestio_theme_fonts) {
			sel = jQuery( '[name="inestio_options_field_' + tag + '_font-family"]' );
			if (sel.length == 1) {
				opt     = sel.find( 'option' );
				sel_idx = sel.find( ':selected' ).index();
				// Remove empty options
				if (opt_list.length < opt.length - 1) {
					for (i = opt.length - 1; i > opt_list.length; i--) {
						opt.eq( i ).remove();
					}
				}
				// Add new options
				if (opt_list.length >= opt.length) {
					for (i = opt.length - 1; i <= opt_list.length - 1; i++) {
						val = '&quot;' + opt_list[i][0] + '&quot;' + (opt_list[i][1] != 'inherit' ? ',' + opt_list[i][1] : '');
						sel.append( '<option value="' + val + '">' + opt_list[i][0] + '</option>' );
					}
				}
				// Set new value
				new_val = '';
				for (i = 0; i < opt_list.length; i++) {
					val = '"' + opt_list[i][0] + '"' + (opt_list[i][1] != 'inherit' ? ',' + opt_list[i][1] : '');
					if (sel_idx - 1 == i) {
						new_val = val;
					}
					opt.eq( i + 1 ).val( val ).text( opt_list[i][0] );
				}
				sel.val( sel_idx > 0 && sel_idx <= opt_list.length && new_val ? new_val : 'inherit' );
			}
		}
	}


	// Init fields
	//-----------------------------------------------------------------------------
	inestio_options_init_fields();
	jQuery(document).on('action.init_hidden_elements', inestio_options_init_fields);

	// Init fields at first run and after clone group
	function inestio_options_init_fields(e, container) {
		
		if (container === undefined) {
			container = jQuery('.inestio_options,body').eq(0);
		}

		// Toggle checkbox value
		container.find( '.inestio_options_item input[type="checkbox"]:not(.inited)' ).addClass( 'inited' )
			.on( 'change', function() {
				var fld = jQuery(this).prev();
				fld.val( jQuery(this).get(0).checked ? 1 : 0 );
			} );

		// Init checkbox
		container.find( '.inestio_options_item_checkbox:not(.inited)' ).addClass( 'inited' )
			.on( 'keydown', '.inestio_options_item_holder', function( e ) {
				// If 'Enter' or 'Space' is pressed - switch state of the checkbox
				if ( [ 13, 32 ].indexOf( e.which ) >= 0 ) {
					jQuery( this ).prev().get( 0 ).checked = ! jQuery( this ).prev().get( 0 ).checked;
					e.preventDefault();
					return false;
				}
				return true;
			} );
		
		// Init switch
		container.find( '.inestio_options_item_switch:not(.inited)' ).addClass( 'inited' )
			.on( 'keydown', '.inestio_options_item_holder', function( e ) {
				// If 'Enter', 'Space',  Left' or 'Right' arrow is pressed - switch state of the checkbox
				if ( [ 13, 32, 37, 39 ].indexOf( e.which ) >= 0 ) {
					jQuery( this ).prev().get( 0 ).checked = ! jQuery( this ).prev().get( 0 ).checked;
					e.preventDefault();
					return false;
				}
				return true;
			} );
		
		// Init radio
		container.find( '.inestio_options_item_radio:not(.inited)' ).addClass( 'inited' )
			.on( 'keydown', '.inestio_options_item_holder', function( e ) {
				// If 'Enter' or 'Space' is pressed - switch state of the checkbox
				if ( [ 13, 32 ].indexOf( e.which ) >= 0 ) {
					jQuery( this ).parents( 'inestio_options_item_field' ).find( 'input:checked' ).each( function() {
						this.checked = false;
					});
					jQuery( this ).prev().get( 0 ).checked = true;
					e.preventDefault();
					return false;
				}
				return true;
			} );

		// Button with action
		container.find('.inestio_options_item_button input[type="button"]:not(.inited),.inestio_options_item_button .inestio_options_button:not(.inited)').addClass('inited')
			.on('click', function(e) {
				var button = jQuery(this),
					cb = button.data('callback');
				if (cb !== undefined && typeof window[cb] !== 'undefined') {
					window[cb]();
				} else {
					jQuery.post(INESTIO_STORAGE['ajax_url'], {
						action: button.data('action'),
						nonce: INESTIO_STORAGE['ajax_nonce']
					}).done(function(response) {
						var rez = {};
						if (response === '' || response === 0) {
							rez = { error: INESTIO_STORAGE['msg_ajax_error'] };
						} else {
							try {
								rez = JSON.parse(response);
							} catch (e) {
								rez = { error: INESTIO_STORAGE['msg_ajax_error'] };
								console.log(response);
							}
						}
						if ( typeof window.trx_addons_msgbox != 'undefined' ) {
							trx_addons_msgbox({
								msg: typeof rez.data != 'undefined' ? rez.data : '',
								hdr: '',
								icon: 'check',
								type: 'success',
								delay: 0,
								buttons: [ TRX_ADDONS_STORAGE['msg_caption_ok'] ],
								callback: null
							});
						} else {
							alert(rez.error ? rez.error : rez.success);
						}
					});
				}
				e.preventDefault();
				return false;
			} );


		// Init cloned fields
		//--------------------------------------
		inestio_options_clone_toggle_buttons( container );
		container.find( '.inestio_options_group:not(.inited)' ).addClass( 'inited' ).each(function() {
			// Clone buttons
			jQuery( this )
				// Button 'Add new'
				.on( 'click', '.inestio_options_clone_button_add', function ( e ) {
					var clone_obj = jQuery(this).parents('.inestio_options_clone_buttons').prev('.inestio_options_clone').eq(0),
						group = clone_obj.parents('.inestio_options_group');
					// Clone fields
					inestio_options_clone(clone_obj);
					// Enable/Disable clone buttons
					inestio_options_clone_toggle_buttons(group);
					// Prevent bubble event
					e.preventDefault();
					return false;
				} )
				// Button 'Clone'
				.on( 'click', '.inestio_options_clone > .inestio_options_clone_control_add', function ( e ) {
					var clone_obj = jQuery(this).parents('.inestio_options_clone'),
						group = clone_obj.parents('.inestio_options_group');
					// Clone fields
					inestio_options_clone(clone_obj);
					// Enable/Disable clone buttons
					inestio_options_clone_toggle_buttons(group);
					// Prevent bubble event
					e.preventDefault();
					return false;
				} )
				// Button 'Delete'
				.on( 'click', '.inestio_options_clone > .inestio_options_clone_control_delete', function ( e ) {
					var clone_obj = jQuery(this).parents('.inestio_options_clone'),
						clone_idx = clone_obj.prev('.inestio_options_clone').length,
						group = clone_obj.parents('.inestio_options_group');
					// Delete clone
					clone_obj.remove();
					// Change fields index
					inestio_options_clone_change_index(group, clone_idx);
					// Enable/Disable clone buttons
					inestio_options_clone_toggle_buttons(group);
					// Prevent bubble event
					e.preventDefault();
					return false;
				} );
			
			// Sort clones
			if ( jQuery.ui.sortable ) {
				var id = jQuery(this).attr( 'id' );
				if ( id === undefined ) {
					jQuery( this ).attr( 'id', 'inestio_options_sortable_' + ( '' + Math.random() ).replace( '.', '' ) );
				}
				jQuery( this )
					.sortable( {
						items: '.inestio_options_clone',
						handle: '.inestio_options_clone_control_move',
						placeholder: ' inestio_options_clone inestio_options_clone_placeholder',
						start: function( event, ui ) {
							// Make the placeholder has the same height as dragged item
							ui.placeholder.height( ui.item.height() );
						},
						update: function( event, ui ) {
							// Change fields index
							inestio_options_clone_change_index( ui.item.parents('.inestio_options_group'), 0 );
						}
					});
			}
		});
		
		// Check clone controls for enable/disable
		function inestio_options_clone_toggle_buttons( container ) {
			if ( ! container.hasClass('inestio_options_group') ) {
				container = container.find('.inestio_options_group');
			}
			container.each( function() {
				var group = jQuery(this);
				if ( group.find('.inestio_options_clone').length > 1 ) {
					group.find('.inestio_options_clone_control_delete,.inestio_options_clone_control_move').show();
				} else {
					group.find('.inestio_options_clone_control_delete,.inestio_options_clone_control_move').hide();
				}
			});
		}
		
		// Replace number in the param's name like 'floor_plans[0][image]'
		function inestio_options_clone_replace_index( name, idx_new ) {
			name = name.replace(/\[\d{1,2}\]/, '['+idx_new+']');
			return name;
		}
		
		// Change index in each field in the clone
		function inestio_options_clone_change_index( group, from_idx ) {
			group.find('.inestio_options_clone').each( function( idx ) {
				if ( idx < from_idx ) return;
				jQuery(this).find('.inestio_options_item_field').each( function() {
					var field = jQuery(this);
					field.attr('data-param', inestio_options_clone_replace_index( field.data('param'), idx) );
					field.find(':input').each( function() {
						var input = jQuery(this),
							id = input.attr('id'),
							name = input.attr('name');
						if (!name) return;
						name = inestio_options_clone_replace_index(name, idx);
						input.attr( 'name', name );
						if ( id ) {
							var id_new = name.replace(/\[/g, '_').replace(/\]/g, '');
							input.attr('id', id_new);
							var linked_field = field.find('[data-linked-field="'+id+'"]');
							if ( linked_field.length > 0 ) {
								linked_field.attr('data-linked-field', id_new);
								if ( linked_field.attr('id') ) {
									linked_field.attr('id', linked_field.attr('id').replace(id, id_new));
								}
							}
						}
					} );
				} );
			} );
		}
		
		// Clone set of the fields
		function inestio_options_clone( obj ) {
			var group = obj.parent(),
				clone = obj.clone(),
				inputs = clone.find('.inestio_options_item_field :input'),
				obj_idx = obj.prev('.inestio_options_clone').length;
			// Remove class 'inited' from all elements
			clone.find('.inited').removeClass('inited');
			clone.find('.icons_inited').removeClass('icons_inited');
			// Reset value for fields
			inputs.each( function() {
				var input = jQuery(this);
				if ( input.is(':radio') || input.is(':checkbox') ) {
					input.prop('checked', false);
				} else if ( input.is('select') ) {
					input.prop('selectedIndex', -1);
				} else if ( ! input.is(':button') ) {
					input.val('');
				}
				// Remove image preview
				input.parents('.inestio_options_item_field').find('.inestio_media_selector_preview').empty();
				// Remove class 'inited' from selectors
				input.next('[class*="_selector"].inited').removeClass('inited');
				// Mark all cloned fields as 'changed' on any cloned field is changed
				if (input.attr('name') && input.attr('name').indexOf("inestio_options_field_") == 0) {
					input.on( 'change', function () {
						jQuery( this ).parents('.inestio_options_group').find('[data-param]').data( 'param-changed', 1 );
					} );
				}
			});
			//Remove UI sliders
			clone.find('.ui-slider-range, .ui-slider-handle').remove();
			// Insert Clone
			clone.insertAfter(obj);
			// Change fields index. Must run before trigger clone event
			inestio_options_clone_change_index(group, obj_idx);
			// Fire init actions for cloned fields
			jQuery(document).trigger('action.init_hidden_elements', [clone.parents('.inestio_options')]);
		}

	}


	// Check for dependencies
	//-----------------------------------------------------------------------------
	function inestio_options_start_check_dependencies() {
		jQuery( '.inestio_options .inestio_options_section' ).each(
			function () {
				inestio_options_check_dependencies( jQuery( this ) );
			}
		);
	}
	// Check all inner dependencies
	jQuery( document ).ready( inestio_options_start_check_dependencies );
	// Check external dependencies (for example, "Page template" in the page edit mode)
	jQuery( window ).load( inestio_options_start_check_dependencies );
	// Check dependencies on any field change
	jQuery( '.inestio_options .inestio_options_item_field [name^="inestio_options_field_"]' ).on(
		'change', function () {
			inestio_options_check_dependencies( jQuery( this ).parents( '.inestio_options_section' ) );
		}
	);

	// Return value of the field
	function inestio_options_get_field_value(fld, num) {
		var ctrl = fld.parents( '.inestio_options_item_field' );
		var val  = fld.attr( 'type' ) == 'checkbox' || fld.attr( 'type' ) == 'radio'
				? (ctrl.find( '[name^="inestio_options_field_"]:checked' ).length > 0
					? (num === true
						? ctrl.find( '[name^="inestio_options_field_"]:checked' ).parent().index() + 1
						: (ctrl.find( '[name^="inestio_options_field_"]:checked' ).val() !== ''
							&& '' + ctrl.find( '[name^="inestio_options_field_"]:checked' ).val() != '0'
								? ctrl.find( '[name^="inestio_options_field_"]:checked' ).val()
								: 1
							)
						)
					: 0
					)
				: (num === true ? fld.find( ':selected' ).index() + 1 : fld.val());
		if (val === undefined || val === null) {
			val = '';
		}
		return val;
	}

	// Check for dependencies
	function inestio_options_check_dependencies(cont) {
		cont.find( '.inestio_options_item_field,.inestio_options_group[data-param]' ).each(
			function() {
				var ctrl = jQuery( this ), id = ctrl.data( 'param' );
				if (id === undefined) {
					return;
				}
				var depend = false;
				for (var fld in inestio_dependencies) {
					if (fld == id) {
						depend = inestio_dependencies[id];
						break;
					}
				}
				if (depend) {
					var dep_cnt    = 0, dep_all = 0;
					var dep_cmp    = typeof depend.compare != 'undefined' ? depend.compare.toLowerCase() : 'and';
					var dep_strict = typeof depend.strict != 'undefined';
					var fld        = null, val = '', name = '', subname = '';
					var parts      = '', parts2 = '';
					for (var i in depend) {
						if (i == 'compare' || i == 'strict') {
							continue;
						}
						dep_all++;
						name    = i;
						subname = '';
						if (name.indexOf( '[' ) > 0) {
							parts   = name.split( '[' );
							name    = parts[0];
							subname = parts[1].replace( ']', '' );
						}
						if (name.charAt( 0 ) == '#' || name.charAt( 0 ) == '.') {
							fld = jQuery( name );
							if (fld.length > 0 && ! fld.hasClass( 'inestio_inited' )) {
								fld.addClass( 'inestio_inited' ).on(
									'change', function () {
										jQuery( '.inestio_options .inestio_options_section' ).each(
											function () {
												inestio_options_check_dependencies( jQuery( this ) );
											}
										);
									}
								);
							}
						} else {
							fld = cont.find( '[name="inestio_options_field_' + name + '"]' );
						}
						if (fld.length > 0) {
							val = inestio_options_get_field_value( fld );
							if (subname !== '') {
								parts = val.split( '|' );
								for (var p = 0; p < parts.length; p++) {
									parts2 = parts[p].split( '=' );
									if (parts2[0] == subname) {
										val = parts2[1];
									}
								}
							}
							for (var j in depend[i]) {
								if (
									(depend[i][j] == 'not_empty' && val !== '')   // Main field value is not empty - show current field
									|| (depend[i][j] == 'is_empty' && val === '') // Main field value is empty - show current field
									|| (val !== '' && ( ! isNaN( depend[i][j] )   // Main field value equal to specified value - show current field
													? val == depend[i][j]
													: (dep_strict
															? val == depend[i][j]
															: ('' + val).indexOf( depend[i][j] ) == 0
														)
												)
									)
									|| (val !== '' && ("" + depend[i][j]).charAt( 0 ) == '^' && ('' + val).indexOf( depend[i][j].substr( 1 ) ) == -1)
																				// Main field value not equal to specified value - show current field
								) {
									dep_cnt++;
									break;
								}
							}
						} else {
							dep_all--;
						}
						if (dep_cnt > 0 && dep_cmp == 'or') {
							break;
						}
					}
					if ( ! ctrl.hasClass('inestio_options_group') ) {
						ctrl = ctrl.parents('.inestio_options_item');
					}
					if (((dep_cnt > 0 || dep_all == 0) && dep_cmp == 'or') || (dep_cnt == dep_all && dep_cmp == 'and')) {
						ctrl.show().removeClass( 'inestio_options_no_use' );
					} else {
						ctrl.hide().addClass( 'inestio_options_no_use' );
					}
				}

				// Individual dependencies
				//------------------------------------

				// Remove 'false' to disable color schemes less then main scheme!
				// This behavious is not need for the version with sorted schemes (leave false)
				if (false && id == 'color_scheme') {
					fld = ctrl.find( '[name="inestio_options_field_' + id + '"]' );
					if (fld.length > 0) {
						val     = inestio_options_get_field_value( fld );
						var num = inestio_options_get_field_value( fld, true );
						cont.find( '.inestio_options_item_field' ).each(
							function() {
								var ctrl2 = jQuery( this ), id2 = ctrl2.data( 'param' );
								if (id2 == undefined) {
									return;
								}
								if (id2 == id || id2.substr( -7 ) != '_scheme') {
									return;
								}
								var fld2 = ctrl2.find( '[name="inestio_options_field_' + id2 + '"]' ),
								val2     = inestio_options_get_field_value( fld2 );
								if (fld2.attr( 'type' ) != 'radio') {
									fld2 = fld2.find( 'option' );
								}
								fld2.each(
									function(idx2) {
										var dom_obj      = jQuery( this ).get( 0 );
										dom_obj.disabled = idx2 != 0 && idx2 < num;
										if (dom_obj.disabled) {
											if (jQuery( this ).val() == val2) {
												if (fld2.attr( 'type' ) == 'radio') {
													fld2.each(
														function(idx3) {
															jQuery( this ).get( 0 ).checked = idx3 == 0;
														}
													);
												} else {
													fld2.each(
														function(idx2) {
																						jQuery( this ).get( 0 ).selected = idx3 == 0;
														}
													);
												}
											}
										}
									}
								);
							}
						);
					}
				}
			}
		);
	}

} );
