var FLBuilderNumber;

(function($) {

	/**
	 * Class for Number Counter Module
	 *
	 * @since 1.6.1
	 */
	FLBuilderNumber = function( settings ){

		// set params
		this.nodeClass           = '.fl-node-' + settings.id;
		this.wrapperClass        = this.nodeClass + ' .fl-number';
		this.layout              = settings.layout;
		this.type                = settings.type;
		this.startNumber         = parseFloat( ( 'undefined' !== typeof window["number_module_" + settings.id] ) ? window["number_module_" + settings.id].start_number : settings.start_number );
		this.number              = parseFloat( ( 'undefined' !== typeof window["number_module_" + settings.id] ) ? window["number_module_" + settings.id].number : settings.number );
		this.max                 = parseFloat( ( 'undefined' !== typeof window["number_module_" + settings.id] ) ? window["number_module_" + settings.id].max : settings.max );
		this.locale              = ( 'undefined' !== typeof window["number_module_" + settings.id] ) ? window["number_module_" + settings.id].locale : 'en_US';
		this.speed               = settings.speed;
		this.delay               = settings.delay;
		this.breakPoints         = settings.breakPoints;
		this.currentBrowserWidth = $( window ).width();
		this.animated            = false;

		// initialize the menu
		this._initNumber();

	};

	FLBuilderNumber.prototype = {
		nodeClass               : '',
		wrapperClass            : '',
		layout                  : '',
		type                    : '',
		startNumber             : 0,
		number                  : 0,
		max                     : 0,
		speed                   : 0,
		delay                   : 0,

		_initNumber: function(){

			var self = this;

			if( typeof jQuery.fn.waypoint !== 'undefined' && ! this.animated ) {
				$( this.wrapperClass ).waypoint({
					offset: FLBuilderLayoutConfig.waypoint.offset + '%',
					triggerOnce: true,
					handler: function( direction ){
						self._initCount();
					}
				});
			} else {
				self._initCount();
			}
		},

		_initCount: function(){

			var $number = $( this.wrapperClass ).find( '.fl-number-string' );

			this.animated = false;

			if( !isNaN( this.delay ) && this.delay > 0 ) {
				setTimeout( function(){
					if( this.layout == 'circle' ){
						this._triggerCircle();
					} else if( this.layout == 'bars' ){
						this._triggerBar();
					}
					this._countNumber();
				}.bind( this ), this.delay * 1000 );
			}
			else {
				if( this.layout == 'circle' ){
					this._triggerCircle();
				} else if( this.layout == 'bars' ){
					this._triggerBar();
				}
				this._countNumber();
			}
		},

		_countNumber: function(){

			var $number    = $( this.wrapperClass ).find( '.fl-number-string' ),
				$string    = $number.find( '.fl-number-int' ),
				number     = parseFloat( $string.data( 'number' ) ),
				current    = 0,
				self       = this,
				startNum   = parseFloat( $string.data( 'start-number' ) ),
				endNum     = parseFloat( $string.data( 'number' ) ),
				countUp    = startNum < endNum,
				startStep  = countUp ? startNum : endNum,
				endStep    = countUp ? endNum : startNum,
				stepNum    = 0,
				counterNum = startNum;

			if ( ! this.animated ) {

				$string.prop( 'Counter', startStep ).animate({
					Counter: endStep
				}, {
					duration: this.speed,
					easing: 'swing',
					step: function (now, fx) {
						counterNum = Math.ceil(this.Counter);
						if (countUp) {
							stepNum = counterNum;
						} else {
							stepNum = (startStep + endStep - counterNum);
						}
						locale  = self.locale.replace('_', '-' );
						stepNumText = new Intl.NumberFormat(locale).format(stepNum)
						if ( countUp ) {
							if ( stepNum < endStep ) {
								$string.text( stepNumText );
							}
						} else {
							$string.text( stepNumText );
						}
					},
					complete: function() {
						locale  = self.locale.replace('_', '-' );
						endNum = new Intl.NumberFormat(locale).format(endNum)
						$string.text( endNum );
						self.animated = true;
					}
				});

			}

		},

		_triggerCircle: function(){

			var $bar   = $(this.wrapperClass).find('.fl-bar'),
				r 	   = $bar.attr('r'),
				circle = Math.PI * (r * 2),
				startNumber = parseInt( $(this.wrapperClass).find('.fl-number-int').data('start-number') ),
				number = parseInt( $(this.wrapperClass).find('.fl-number-int').data('number') ),
				total  = parseInt( $(this.wrapperClass).find('.fl-number-int').data('total') ),
				val    = parseInt( number ),
				max    = parseInt( total ),
			    startPct = 0,
				endPct =  max;

			if (val < 0) { val = 0;}
			if (val > max) { val = max;}

			if( this.type == 'percent' ){
				startPct = ( ( max - startNumber ) / max ) * circle;
				endPct = ( ( max - val ) / max ) * circle;
			} else {
				startPct = ( 1 - ( startNumber / max ) ) * circle;
				endPct = ( 1 - ( val / max ) ) * circle;
			}

			$bar.css('stroke-dashoffset', startPct);
			$bar.animate({
				strokeDashoffset: endPct
			}, {
				duration: this.speed,
				easing: 'swing',
				complete: function() {
					this.animated = true;
				}
			});

		},

		_triggerBar: function(){

			var $bar       = $( this.wrapperClass ).find( '.fl-number-bar' ),
				startNum   = parseInt( $(this.wrapperClass).find('.fl-number-int').data('start-number') ),
				number     = parseInt( $(this.wrapperClass).find('.fl-number-int').data('number') ),
				total      = parseInt( $(this.wrapperClass).find('.fl-number-int').data('total') ),
				initWidth  = 0,
				finalWidth = 0;

			// total is also equal to this.max
			if ( isNaN( total ) || total <= 0 ) {
				return;
			}

			if ( number > startNum && total < number ) {
				total = number;
			} else if ( startNum > number && total < startNum ) {
				total = startNum;
			}

			initWidth = Math.ceil( (startNum / total) * 100 );
			finalWidth = Math.ceil( (number / total) * 100 );

			// Set the initial indicator bar value.
			$bar.css('width', initWidth + '%');

			if( ! this.animated ) {
				$bar.animate({
					width: finalWidth + '%'
				}, {
					duration: this.speed,
					easing: 'swing',
					complete: function() {
						this.animated = true;
					}
				});
			}
		}
	};

})(jQuery);
