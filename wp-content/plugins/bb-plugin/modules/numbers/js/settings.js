(function ($) {
	FLBuilder.registerModuleHelper("numbers", {
		init: function () {
			var form = $(".fl-builder-settings");

			this._toggleMaxNumber();
			form.find("select[name=layout]").on("change", this._toggleMaxNumber);
			form.find("select[name=number_type]").on("change", this._toggleMaxNumber);
			form.find("input[name=start_number]").on("input", this._startNumberChange.bind( this ) );
			form.find("input[name=number]").on("input", this._numberChange.bind( this ) );
			form.find("input[name=max_number]").on("input", this._totalChange);
			form.find("input[name=max_number]").on("focusout", this._finalizeTotal.bind( this ) );

			this._toggleNumberControls();
			form
				.find("select[name=layout]")
				.on("change", this._toggleNumberControls);
			form
				.find("select[name=number_position]")
				.on("change", this._toggleNumberControls);
			form
				.find("select[name=number_type]")
				.on("change", this._toggleNumberControls);

			this._validateNumber();
			form
				.find("input[name=number]")
				.bind("keyup mouseup", this._validateNumber);
		},

		/**
		 * Update the Number element's data-total attribute based on the larger value between startNum and endNum.
		 *
		 * @since TBD
		 * @access private
		 * @method _numberChange
		 */
		_updateTotal: function () {
			var preview = FLBuilder.preview,
				form = $('.fl-builder-settings'),
				startNumField = form.find('input[name=start_number]').val(),
				startNum = parseInt( startNumField ),
				endNumField = form.find('input[name=number]').val(),
				endNum = parseInt(endNumField),
				totalNum = 0,
				numberNode = FLBuilder.preview.elements.node.find( '.fl-number-int' ); 
			
			startNum = isNaN(startNum) ? 0 : startNum;
			endNum = isNaN(endNum) ? 0 : endNum;
			totalNum = startNum >= endNum ? startNum : endNum ;

			$(numberNode).data('total', totalNum );
			this._synchMaxNumber( totalNum );
		},

		/**
		 * Synch the Max Number (Total Field) value with Number element's data-total attribute.
		 * This should only be done for Circle and Bars layouts.
		 *
		 * @since TBD
		 * @access private
		 * @param  value The Number element's data-total attribute value.
		 * @method _synchMaxNumber
		 */
		_synchMaxNumber: function ( value ) {
			var form       = $('.fl-builder-settings'),
				layout     = form.find('input[name=layout]').val(),
				totalField = form.find('input[name=max_number]'),
				maxNum     = parseInt( totalField.val() );
			
			if ( 'default' === layout) {
				return;
			}

			if ( isNaN( maxNum ) || maxNum < value ) {
				totalField.val( value );
			}
		},
		 
		/**
		 * If the Start Number field is changed, update the Number element's data-start-number attribute.
		 *
		 * @since TBD
		 * @access private
		 * @method _startNumberChange
		 */
		 _startNumberChange: function ( e ) {
			var preview = FLBuilder.preview,
				form = $('.fl-builder-settings'),
				startNumberField = form.find('input[name=start_number]').val(),
				numberNode = FLBuilder.preview.elements.node.find( '.fl-number-int' ); 
			
			$(numberNode).data('number', startNumberField );
			this._updateTotal();
		},
		 
		/**
		 * If the Number field is changed, update the Number element's data-number attribute.
		 *
		 * @since TBD
		 * @access private
		 * @method _numberChange
		 */
		_numberChange: function ( e ) {
			var preview = FLBuilder.preview,
				form = $('.fl-builder-settings'),
				numberField = form.find('input[name=number]').val(),
				numberNode = FLBuilder.preview.elements.node.find( '.fl-number-int' ); 
			
			$(numberNode).data('number', numberField );
			this._updateTotal();
		},

		/**
		 * If the Total field is changed, update the Number element's data-total attribute.
		 *
		 * @since TBD
		 * @access private
		 * @method _totalChange
		 */
		_totalChange: function ( e ) {
			var preview          = FLBuilder.preview,
				form             = $('.fl-builder-settings'),
				startNumberField = form.find('input[name=start_number]'),
				endNumberField   = form.find('input[name=number]'),
				totalField       = form.find('input[name=max_number]'),
				startNumber      = parseInt( startNumberField.val() ),
				endNumber        = parseInt( endNumberField.val() ),
				total            = parseInt( totalField.val() ),
				numberNode       = FLBuilder.preview.elements.node.find( '.fl-number-int' ); 
			
			if ( isNaN(startNumber) ) {
				startNumber = 0;
			}

			if ( isNaN(endNumber) ) {
				endNumber = 0;
			}

			if ( isNaN(total) ) {
				total = 0;
			}

			if ( startNumber <= 0 && endNumber <= 0 && total <= 0 ) {
				total = 0;
			} else if ( total < startNumber && endNumber < total ) {
				total = startNumber > endNumber ? startNumber : endNumber;
			} 

			$(numberNode).data('total', total );
			
		},

		/**
		 * Called on Focus Out Event, this method finalizes the value of the Total Field to make sure 
		 * it's not less than both Start Number and End Number fields.
		 *
		 * @since TBD
		 * @access private
		 * @method _finalizeTotal
		 */
		_finalizeTotal: function ( e ) {
			var preview          = FLBuilder.preview,
					form             = $('.fl-builder-settings'),
					startNumberField = form.find('input[name=start_number]'),
					endNumberField   = form.find('input[name=number]'),
					totalField       = form.find('input[name=max_number]'),
					startNumber      = parseInt( startNumberField.val() ),
					endNumber        = parseInt( endNumberField.val() ),
					total            = parseInt( totalField.val() ),
					numberNode       = FLBuilder.preview.elements.node.find( '.fl-number-int' ); 
				
			if ( isNaN(startNumber) ) {
				startNumber = 0;
			}

			if ( isNaN(endNumber) ) {
				endNumber = 0;
			}

			if ( isNaN(total) ) {
				total = 0;
			}

			if ( startNumber <= 0 && endNumber <= 0 && total <= 0 ) {
				total = 0;
			} else if ( total < startNumber && endNumber < total ) {
				total = startNumber > endNumber ? startNumber : endNumber;
			}
			
			totalField.val(total);
			preview.delayPreview(e);
			this._updateTotal();
		},


		_toggleMaxNumber: function () {
			var form = $(".fl-builder-settings"),
				layout = form.find("select[name=layout]").val(),
				numberType = form.find("select[name=number_type]").val(),
				maxNumber = form.find("#fl-field-max_number");
			
			if ( 'default' == layout) {
				maxNumber.hide();
			} else {
				maxNumber.show();
			}

		},

		_toggleNumberControls: function () {
			var form = $(".fl-builder-settings"),
				layout = form.find("select[name=layout]").val(),
				numberPosition = form.find("select[name=number_position]").val(),
				numberPrefix = form.find("#fl-field-number_prefix"),
				numberSuffix = form.find("#fl-field-number_suffix"),
				numberType = form.find("select[name=number_type]").val(),
				numberColor = form.find("#fl-field-number_color");

			if ("bars" == layout && "hidden" == numberPosition) {
				numberPrefix.hide();
				numberSuffix.hide();
				numberColor.hide();
			} else {
				numberPrefix.show();
				numberSuffix.show();
				numberColor.show();
			}

			if ('percent' == numberType) {
				numberPrefix.hide();
				numberSuffix.hide();
			}
		},

		_validateNumber: function () {
			var form = $(".fl-builder-settings"),
				numberInput = form.find("input[name=number]");

			number = numberInput.val();

			// Match -00 or 00.4 which are invalid
			if (number.match(/^-?(0)\1+\.?/)) {
				numberInput.val("100");
				return false;
			}

			// if field is blank dont check if its a number
			if ("" === number) {
				return false;
			}

			// Finaly if number is invalid set to 100, the default
			if (!$.isNumeric(number)) {
				numberInput.val("100");
			}
		},

		submit: function ()
		{
			var form        = $('.fl-builder-settings'),
				maxNumberField = form.find('#fl-field-max_number'),
				startNumberField = form.find('#fl-field-start_number input[name=start_number]'),
				endNumberField = form.find('#fl-field-start_number input[name=number]'),
				maxNumber = 0,
				startNumber = 0,
				endNumber = 0,
				ok = false;
			
			if ($.isNumeric(startNumberField)) {
				startNumber = parseFloat( startNumberField );
			} 

			if ($.isNumeric(endNumberField)) {
				endNumber = parseFloat( endNumberField );
			}
			
			if ($.isNumeric(maxNumberField)) {
				maxNumber = parseFloat( maxNumberField );
			}

			if (maxNumberField.is(':visible') && ( startNumber > maxNumber || endNumber > maxNumber) ) {
				alert( 'Start Counter and End Counter must be less than the Total Units.');
			} else {
				ok = true;
			}
			return ok;
		}
		
	});
})(jQuery);
