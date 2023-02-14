
jQuery( document ).ready( function($){

	var $current_menu_item = null;
	var current_menu_item_id = '';	//menu-item-x
	var $current_panel = null;

	var $settingswrap = $( '.shiftnav-menu-item-settings-wrapper' );

	//remove loading notice
	$( '.shiftnav-js-check' ).remove();

	//handle adding the "Shift" button on each menu item upon first interaction
	$( '#menu-management' ).on( 'mouseenter touchEnd MSPointerUp pointerup' , '.menu-item:not(.shiftnav-processed)' , function(e){
		$(this).addClass( 'shiftnav-processed' );
		$(this).find( '.item-title' ).append( '<span class="shiftnav-settings-toggle" data-shift-toggle="' + $(this).attr('id') + '"><i class="fa fa-gear"></i> Shift <span class="shiftnav-unsaved-alert"><i class="fa fa-warning"></i> <span class="shiftnav-unsaved-alert-message">Unsaved</span></span></span>' );
	});

	//Don't allow clicks to propagate when clicking the toggle button, to avoid drag-starts of the menu item
	$( '#menu-management' ).on( 'mousedown' , '.shiftnav-settings-toggle' , function( e ){
		e.preventDefault();
		e.stopPropagation();

		return false;
	});

	//Handle clicking the "Shift" button on each menu item - open settings
	$( '#menu-management' ).on( 'click' , '.shiftnav-settings-toggle' , function( e ){
		
		var this_menu_item_id = $(this).attr( 'data-shift-toggle' );
		var this_menu_item_id_num = this_menu_item_id.substr(10);
		
		$current_menu_item = $(this).parents( 'li.menu-item' );

		//This is already the current item
		if( this_menu_item_id == current_menu_item_id ){
			$settingswrap.toggleClass( 'shiftnav-menu-item-settings-open' );
			$( 'body' ).toggleClass( 'shiftnav-settings-panel-is-open' );
		}
		//Switching to a different item
		else{
			$settingswrap.addClass( 'shiftnav-menu-item-settings-open' );
			$( 'body' ).addClass( 'shiftnav-settings-panel-is-open' );

			//Update
			
			$current_panel = $settingswrap.find( '.shiftnav-menu-item-panel-' + this_menu_item_id );
			
			//Create Panel if it doesn't exist
			if( $current_panel.size() === 0 ){
				$current_panel = $( '.shiftnav-menu-item-panel-negative' ).clone();
				$current_panel.removeClass( 'shiftnav-menu-item-panel-negative' );
				$current_panel.addClass( 'shiftnav-menu-item-panel-' + this_menu_item_id );
				$current_panel.attr( 'data-menu-item-target-id' , this_menu_item_id_num );
			
				var hash = '#' + this_menu_item_id;

				$current_panel.find( '.shiftnav-menu-item-title' ).text( $current_menu_item.find('.menu-item-title').text() );
				$current_panel.find( '.shiftnav-menu-item-id' ).html( '<a href="'+hash+'">'+hash+'</a>' );
				$current_panel.find( '.shiftnav-menu-item-type' ).text( $current_menu_item.find('.item-type').text() );
				var item_data = shiftnav_menu_item_data[this_menu_item_id_num];
				if( item_data ){
				
					$current_panel.find( '[data-shiftnav-setting]' ).each( function(){
						var _data_name = $(this).data( 'shiftnav-setting' );

						if( item_data[_data_name] ){
							switch( $(this).attr('type') ){
							
								case 'checkbox':
									if( item_data[_data_name] == 'on' ){
										$(this).prop( 'checked' , true );
									}
									break;

								default:
									$(this).val( item_data[_data_name] );
							}
						}

						switch( _data_name ){

							case 'icon':
								var $icon_wrap = $( this ).parents( '.shiftnav-icon-settings-wrap' );
								//console.log( item_data.icon );
								$icon_wrap.find( '.shiftnav-icon-selected i' ).attr( 'class' , item_data.icon );
								break;

						}
					});

					//for( _setting in item_data ){
						//console.log( _setting + ' :: ' + item_data[_setting] );
					//}
				
				}

				$current_panel.find( '.shiftnav-menu-item-tab-content' ).hide();

				$current_panel.on( 'click' , '.shiftnav-menu-item-tab a' , function( e ){
					e.preventDefault();
					e.stopPropagation();
//console.log( $(this).data('shiftnav-tab') );
//console.log( $current_panel.find( '[data-shiftnav-tab-content="'+$(this).data('shiftnav-tab') + '"]' ).size() );
//
					$current_panel.find( '.shiftnav-menu-item-tab > a' ).removeClass( 'shiftnav-menu-item-tab-current' );
					$(this).addClass( 'shiftnav-menu-item-tab-current' );
					$current_panel.find( '.shiftnav-menu-item-tab-content' ).slideUp();
					$current_panel.find( '[data-shiftnav-tab-content="'+$(this).data('shiftnav-tab') + '"]' ).slideDown();

					return false;
				});

				$current_panel.find( '.shiftnav-menu-item-tab > a' ).first().trigger('click');

				$settingswrap.append( $current_panel );
			}

			//Hide all other panels
			$settingswrap.find( '.shiftnav-menu-item-panel' ).hide();
			$current_panel.fadeIn();


			
		}

		current_menu_item_id = this_menu_item_id;

		return false;
	});

	//When a setting is changed, set the flag on the settings panel and on the menu item itself
	$settingswrap.on( 'change' , '.shiftnav-menu-item-setting-input' , function( e ){

		//Flag Settings Panel
		var $form = $(this).parents( 'form.shiftnav-menu-item-settings-form' );
		$form.find( '.shiftnav-menu-item-status' ).attr( 'class' , 'shiftnav-menu-item-status shiftnav-menu-item-status-warning' );
		$form.find( '.shiftnav-status-message' ).html( 'Settings have changed.  Click <strong>Save Menu Item</strong> to preserve these changes.' );

		//Flag Menu Item
		var item_id = $form.parents( '.shiftnav-menu-item-panel' ).data( 'menu-item-target-id' );
		$( '#menu-item-' + item_id ).addClass( 'shiftnav-unsaved' );
	});


	//Save Settings Button
	$settingswrap.on( 'click' , '.shiftnav-menu-item-save-button', function( e ){
		e.preventDefault();
		e.stopPropagation();

		var $form = $(this).parents('form.shiftnav-menu-item-settings-form' );
		var serialized = $form.serialize();
		//console.log( 'serial: ' + serialized );

		//return;
		
		var data = {
			action: 'shiftnav_save_menu_item',
			settings: serialized,
			menu_item_id: current_menu_item_id,
			shiftnav_nonce: shiftnav_meta.nonce
		};

		$formStatus = $form.find( '.shiftnav-menu-item-status' );
		$formStatusMessage = $form.find( '.shiftnav-status-message' );
		$formStatus.attr( 'class', 'shiftnav-menu-item-status shiftnav-menu-item-status-working' );
		$formStatusMessage.text( 'Processing save request...' );

		$.post( shiftnav_meta.ajax_url, data, function( response ) {
			//console.log('Got this from the server: ' , response );
			if( response == -1 ){
				$formStatus.attr( 'class', 'shiftnav-menu-item-status shiftnav-menu-item-status-error' );
				$formStatusMessage.html( '<strong>Error encountered.  Settings could not be saved.</strong>  Your login/nonce may have expired.  Please try refreshing the page.');
				//console.log( response );
			}
			else{
				//$( '.shiftnav-menu-item-panel-' + response.menu_item_id )
				$formStatus.attr( 'class', 'shiftnav-menu-item-status shiftnav-menu-item-status-success' );
				$formStatusMessage.text( 'Settings Saved' );
				shiftnav_meta.nonce = response.nonce;	//update nonce

				//Remove flag on menu item
				var item_id = $form.parents( '.shiftnav-menu-item-panel' ).data( 'menu-item-target-id' );
				$( '#menu-item-' + item_id ).removeClass( 'shiftnav-unsaved' );
			}

		}, 'json' ).fail( function( d ){
			$formStatus.attr( 'class', 'shiftnav-menu-item-status shiftnav-menu-item-status-error' );
			$formStatusMessage.html( '<strong>Error encountered.  Settings could not be saved.</strong>  Response Text: <br/><textarea>' + d.responseText + '</textarea>');
			//console.log( d.responseText );
			//console.log( d );
		});

		return false;
	});

	//Close Settings Button
	$settingswrap.on( 'click' , '.shiftnav-menu-item-settings-close' , function( e ){
		e.preventDefault();
		e.stopPropagation();

		$settingswrap.removeClass( 'shiftnav-menu-item-settings-open' );
		$( 'body' ).removeClass( 'shiftnav-settings-panel-is-open' );
	});

	//Scroll to the menu item when the ID is clicked
	$settingswrap.on( 'click' , '.shiftnav-menu-item-id a' , function( e ){
		var $item = $( $(this).attr( 'href' ) );
		//console.log( $item.offset() );
		var y = $item.offset().top - 50;
		$('html, body').animate({scrollTop:y}, 'normal');
		return false;
	});

	//Show Icon Selection panel when icon is clicked
	$settingswrap.on( 'click' , '.shiftnav-icon-selected' , function( e ){
		$icon_set = $( this ).parents( '.shiftnav-icon-settings-wrap' );
		$icon_set.find( '.shiftnav-icons' ).fadeToggle();
		$icon_set.find( '.shiftnav-icons-search' ).focus();
	});


	$settingswrap.on( 'click' , '.shiftnav-icon-settings-wrap .shiftnav-icon-wrap' , function( e ){
		$icon = $( this ).find( '.shiftnav-icon' );
		$icon_set = $( this ).parents( '.shiftnav-icon-settings-wrap' );
		console.log( $icon.attr( 'class' ) + ' | ' + $icon.data( 'shiftnav-icon' )  );
		$icon_set.find( '.shiftnav-icon-selected i' ).attr( 'class' , $icon.attr( 'class' ) );
		$icon_set.find( 'select' ).val( $icon.data( 'shiftnav-icon' ) ).change();
		$( this ).parents( '.shiftnav-icons' ).fadeOut();
	});

	/* Filter Icons */
	$settingswrap.on( 'keyup' , '.shiftnav-icons-search' , function( e ){
		$icon_set = $( this ).parents( '.shiftnav-icon-settings-wrap' ).find( '.shiftnav-icon-wrap' );
		var val = $(this).val();
		if( val == '' ){
			$icon_set.show();
		}
		else{
			$icon_set.filter( ':not( [data-shiftnav-search-terms*=' +val+ '] )' ).hide();
			console.log( 'not( [data-shiftnav-search-terms*=' +$(this).val().toLowerCase()+ '] )' );
		}
	});


});