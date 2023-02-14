jQuery( document ).ready( function($){
	$( '.shiftnav_instance_notice_close, .shiftnav_instance_close' ).on( 'click' , function(){
		$( '.shiftnav_instance_wrap' ).fadeOut();
	});
	$( '.shiftnav_instance_wrap' ).on( 'click' , function(e){
		if( $( e.target ).hasClass( 'shiftnav_instance_wrap' ) ){
			$(this).fadeOut();
		}
	});

	$( '.shiftnav_instance_toggle' ).on( 'click' , function(){
		$( '.shiftnav_instance_container_wrap' ).fadeIn();
		$( '.shiftnav_instance_container_wrap .shiftnav_instance_input' ).focus();
	});

	$form = $( 'form.shiftnav_instance_form' );
	$form.on( 'submit' , function(e){
		e.preventDefault();
		shiftnav_save_instance();
		return false;
	});

	$( '.shiftnav_instance_create_button' ).on( 'click' , function(e){
		e.preventDefault();
		shiftnav_save_instance();
		return false;
	});

	$( '.shiftnav_button_reset' ).on( 'click' , function(e){
		var r = confirm( 'Are you sure you want to do this?  Clicking "OK" will reset all settings in this tab.  This cannot be undone.' );
		if( r == false ){
			e.preventDefault();
			return false;
		}
	});

	function shiftnav_save_instance(){
		var data = {
			action: 'shiftnav_add_instance',
			shiftnav_data: $form.serialize(),
			shiftnav_nonce: $form.find( '#_wpnonce' ).val()
		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post( ajaxurl, data, function(response) {
			console.log( response );

			if( response == -1 ){
				$( '.shiftnav_instance_container_wrap' ).fadeOut();
				$( '.shiftnav_instance_notice_error' ).fadeIn();

				$( '.shiftnav-error-message' ).text( 'Please try again.' );

				return;
			}
			else if( response.error ){
				$( '.shiftnav_instance_container_wrap' ).fadeOut();
				$( '.shiftnav_instance_notice_error' ).fadeIn();

				$( '.shiftnav-error-message' ).text( response.error );

				return;
			}
			else{
				$( '.shiftnav_instance_container_wrap' ).fadeOut();
				$( '.shiftnav_instance_notice_success' ).fadeIn();
			}

		}, 'json' ).fail( function(){
			$( '.shiftnav_instance_container_wrap' ).fadeOut();
			$( '.shiftnav_instance_notice_error' ).fadeIn();
		});
	}


	$( '.shiftnav_instance_button_delete' ).on( 'click' , function( e ){
		e.preventDefault();
		if( confirm( 'Are you sure you want to delete this ShiftNav Instance?' ) ){
			shiftnav_delete_instance( $(this) );
		}
		return false;
	});

	function shiftnav_delete_instance( $a ){
		var data = {
			action: 'shiftnav_delete_instance',
			shiftnav_data: {
				'shiftnav_instance_id' : $a.data( 'shiftnav-instance-id' )
			},
			shiftnav_nonce: $a.data( 'shiftnav-nonce' )
		};

		//console.log( data );

		jQuery.post( ajaxurl, data, function(response) {
			console.log( response );

			if( response == -1 ){
				$( '.shiftnav_instance_container_wrap' ).fadeOut();
				$( '.shiftnav_instance_delete_notice_error' ).fadeIn();

				$( '.shiftnav-delete-error-message' ).text( 'Please try again.' );

				return;
			}
			else if( response.error ){
				$( '.shiftnav_instance_container_wrap' ).fadeOut();
				$( '.shiftnav_instance_delete_notice_error' ).fadeIn();

				$( '.shiftnav-delete-error-message' ).text( response.error );

				return;
			}
			else{
				$( '.shiftnav_instance_container_wrap' ).fadeOut();
				$( '.shiftnav_instance_delete_notice_success' ).fadeIn();

				var id = response.id;
				$( '#shiftnav_'+id+', #shiftnav_'+id+'-tab' ).remove();	//delete tab and content
				$( '.nav-tab-wrapper > a' ).first().trigger('click');			//switch to first tab
			}

		}, 'json' ).fail( function(){
			$( '.shiftnav_instance_container_wrap' ).fadeOut();
			$( '.shiftnav_instance_delete_notice_error' ).fadeIn();
		});

		
	}

	function shift_selectText( element ) {
		var doc = document
			//, text = element //doc.getElementById(element)
			, range, selection
		;
		if (doc.body.createTextRange) { //ms
			range = doc.body.createTextRange();
			range.moveToElementText( element );
			range.select();
		} else if (window.getSelection) { //all others
			selection = window.getSelection();        
			range = doc.createRange();
			range.selectNodeContents( element );
			selection.removeAllRanges();
			selection.addRange(range);
		}
	}

	$( '.shiftnav-highlight-code' ).on( 'click' , function(e){
		shift_selectText( $(this)[0] );
	});

	//Open Hash Tab
	setTimeout( function(){
		if( window.location.hash ){
			//console.log( window.location.hash + '-tab ' + $( window.location.hash + '-tab' ).size() );

			$( window.location.hash + '-tab' ).trigger('click');
		}
	} , 500 );
});
