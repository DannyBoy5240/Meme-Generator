<?php

/**
 * weDevs Settings API wrapper class
 *
 * @author Tareq Hasan <tareq@weDevs.com>
 * @link http://tareq.weDevs.com Tareq's Planet
 * @example settings-api.php How to use the class
 */
if ( !class_exists( 'ShiftNav_Settings_API' ) ):
class ShiftNav_Settings_API {

	/**
	 * settings sections array
	 *
	 * @var array
	 */
	private $settings_sections = array();

	/**
	 * Settings fields array
	 *
	 * @var array
	 */
	private $settings_fields = array();

	private $settings_defaults = null;

	/**
	 * Singleton instance
	 *
	 * @var object
	 */
	private static $_instance;

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts and styles
	 */
	function admin_enqueue_scripts( $hook ) {
		if( $hook == 'appearance_page_shiftnav-settings' ){
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script( 'jquery' );
			//wp_enqueue_script( 'media-upload' );
			//wp_enqueue_script( 'thickbox' );

			wp_enqueue_media();
		}
	}



	/**
	 * Set settings sections
	 *
	 * @param array   $sections setting sections array
	 */
	function set_sections( $sections ) {
		$this->settings_sections = $sections;

		return $this;
	}

	/**
	 * Add a single section
	 *
	 * @param array   $section
	 */
	function add_section( $section ) {
		$this->settings_sections[] = $section;

		return $this;
	}

	/**
	 * Set settings fields
	 *
	 * @param array   $fields settings fields array
	 */
	function set_fields( $fields ) {
		$this->settings_fields = $fields;

		return $this;
	}

	function add_field( $section, $field ) {
		$defaults = array(
			'name' => '',
			'label' => '',
			'desc' => '',
			'type' => 'text'
		);

		$arg = wp_parse_args( $field, $defaults );
		$this->settings_fields[$section][] = $arg;

		return $this;
	}

	/**
	 * Initialize and registers the settings sections and fileds to WordPress
	 *
	 * Usually this should be called at `admin_init` hook.
	 *
	 * This function gets the initiated settings sections and fields. Then
	 * registers them to WordPress and ready for use.
	 */
	function admin_init() {
		//register settings sections
		foreach ( $this->settings_sections as $section ) {
			if ( false == get_option( $section['id'] ) ) {
				add_option( $section['id'] );
			}

			if ( isset($section['desc']) && !empty($section['desc']) ) {
				$section['desc'] = '<div class="inside">'.$section['desc'].'</div>';
				$callback = function() use ( $section ){
					echo str_replace('"', '\"', $section['desc']);
				};
			} else {
				$callback = '__return_false';
			}

			add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
		}

		//register settings fields
		foreach ( $this->settings_fields as $section => $field ) {
			foreach ( $field as $option ) {

				$type = isset( $option['type'] ) ? $option['type'] : 'text';

				$args = array(
					'id' => $option['name'],
					'desc' => isset( $option['desc'] ) ? $option['desc'] : '',
					'name' => $option['label'],
					'section' => $section,
					'size' => isset( $option['size'] ) ? $option['size'] : null,
					'options' => isset( $option['options'] ) ? $option['options'] : '',
					'std' => isset( $option['default'] ) ? $option['default'] : '',
					'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
					'input_type' => isset( $option['input_type'] ) ? $option['input_type'] : 'text',
				);
				add_settings_field( $section . '[' . $option['name'] . ']', $option['label'], array( $this, 'callback_' . $type ), $section, $section, $args );
			}
		}

		// creates our settings in the options table
		foreach ( $this->settings_sections as $section ) {
			register_setting( $section['id'], $section['id'], array( $this, 'sanitize_options' ) );
		}
	}

	/**
	 * Displays a text field for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_text( $args ) {
		
		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
		$input_type = isset( $args['input_type'] ) ? $args['input_type'] : 'text';

		$html = sprintf( '<input type="%5$s" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value, $input_type );
		$html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a checkbox for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_checkbox( $args ) {

		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );

		$html = sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
		$html .= sprintf( '<input type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="on"%4$s />', $args['section'], $args['id'], $value, checked( $value, 'on', false ) );
		$html .= sprintf( '<label for="%1$s[%2$s]"> %3$s</label>', $args['section'], $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a multicheckbox a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_multicheck( $args ) {

		$value = $this->get_option( $args['id'], $args['section'], $args['std'] );

		$html = '';
		foreach ( $args['options'] as $key => $label ) {
			$checked = isset( $value[$key] ) ? $value[$key] : '0';
			$html .= sprintf( '<input type="checkbox" class="checkbox" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
			$html .= sprintf( '<label for="%1$s[%2$s][%4$s]"> %3$s</label><br>', $args['section'], $args['id'], $label, $key );
		}
		$html .= sprintf( '<span class="description"> %s</label>', $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a multicheckbox a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_radio( $args ) {

		$value = $this->get_option( $args['id'], $args['section'], $args['std'] );

		$html = '';
		foreach ( $args['options'] as $key => $label ) {
			$html .= sprintf( '<input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s"%4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
			$html .= sprintf( '<label for="%1$s[%2$s][%4$s]"> %3$s</label><br>', $args['section'], $args['id'], $label, $key );
		}
		$html .= sprintf( '<span class="description"> %s</label>', $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a selectbox for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_select( $args ) {

		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

		$html = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );
		foreach ( $args['options'] as $key => $label ) {
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
		}
		$html .= sprintf( '</select>' );
		$html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a textarea for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_textarea( $args ) {

		$value = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

		$html = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]">%4$s</textarea>', $size, $args['section'], $args['id'], $value );
		$html .= sprintf( '<br><span class="description"> %s</span>', $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a custom html for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_html( $args ) {
		echo $args['desc'];
	}

	/**
	 * Displays a rich text textarea for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_wysiwyg( $args ) {

		$value = wpautop( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '500px';

		echo '<div style="width: ' . $size . ';">';

		wp_editor( $value, $args['section'] . '[' . $args['id'] . ']', array( 'teeny' => true, 'textarea_rows' => 10 ) );

		echo '</div>';

		echo sprintf( '<br><span class="description"> %s</span>', $args['desc'] );
	}

	/**
	 * Displays a file upload field for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_file( $args ) {

		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
		$id = $args['section']  . '[' . $args['id'] . ']';
		$js_id = $args['section']  . '\\\\[' . $args['id'] . '\\\\]';
		$html = sprintf( '<input type="text" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
		$html .= '<input type="button" class="button wpsf-browse" id="'. $id .'_button" value="Browse" />
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#'. $js_id .'_button").on("click", function() {
				tb_show("", "media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true");
				window.original_send_to_editor = window.send_to_editor;
				window.send_to_editor = function(html) {
					var url = $(html).attr(\'href\');
					if ( !url ) {
						url = $(html).attr(\'src\');
					};
					$("#'. $js_id .'").val(url);
					tb_remove();
					window.send_to_editor = window.original_send_to_editor;
				};
				return false;
			});
		});
		</script>';
		$html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a password field for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_password( $args ) {

		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

		$html = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
		$html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

		echo $html;
	}

	/**
	 * Displays a color picker field for a settings field
	 *
	 * @param array   $args settings field args
	 */
	function callback_color( $args ) {

		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

		$html = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
		$html .= sprintf( '<span class="description" style="display:block;"> %s</span>', $args['desc'] );

		echo $html;
	}



	function callback_image( $args ) {

		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

		$html = '<div class="set-image-wrapper">';
		$html.= '<span class="image-setting-wrap">';
		if( $value ){
			$src = '';
			if( is_numeric( $value ) ){
				$img_src = wp_get_attachment_image_src( $value , 'medium' );
				$src = $img_src[0];
			}
			else{
				$src = $value;
			}
			$html.= '<img width="200" src="'.$src.'" />';
		}
		$html.= '</span>';
		$html.= sprintf( '<input type="hidden" class="%1$s-text image-url" id="%2$s-%3$s" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
		$html.= sprintf( '<input type="button" class="button" id="%2$s-%3$s_button" name="%2$s[%3$s]_button" value="Select"/>', $size, $args['section'], $args['id'] );
		$html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );
		$html.= '<a href="#" class="remove-button" data-target-id="'.$args['section'] .'-'. $args['id'].'">remove</a>';
		$html.= '</div>';

		echo $html;
	}

/*
	function callback_newfield( $args ){
		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

		$html = sprintf( '<input type="text" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
		$html .= sprintf( '<span class="description"> %s</span>', $args['desc'] );

		echo $html;
	}
*/


	/**
	 * Sanitize callback for Settings API
	 */
	function sanitize_options( $options ) {
		foreach( $options as $option_slug => $option_value ) {
			$sanitize_callback = $this->get_sanitize_callback( $option_slug );

			// If callback is set, call it
			if ( $sanitize_callback ) {
				$options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
				continue;
			}

			// Treat everything that's not an array as a string
			if ( !is_array( $option_value ) ) {
				$options[ $option_slug ] = sanitize_text_field( $option_value );
				continue;
			}
		}
		return $options;
	}

	/**
	 * Get sanitization callback for given option slug
	 *
	 * @param string $slug option slug
	 *
	 * @return mixed string or bool false
	 */
	function get_sanitize_callback( $slug = '' ) {
		if ( empty( $slug ) )
			return false;
		// Iterate over registered fields and see if we can find proper callback
		foreach( $this->settings_fields as $section => $options ) {
			foreach ( $options as $option ) {
				if ( $option['name'] != $slug )
					continue;
				// Return the callback name
				return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
			}
		}
		return false;
	}

	/**
	 * Get the value of a settings field
	 *
	 * @param string  $option  settings field name
	 * @param string  $section the section name this field belongs to
	 * @param string  $default default text if it's not found
	 * @return string
	 */
	function get_option( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}

		return $default;
	}

// 	function set_defaults(){

// 		$this->settings_defaults = array();

// 		foreach( $this->settings_fields as $section_id => $ops ){

// 			$this->settings_defaults[$section_id] = array();
// 			//$section = $this->settings_defaults[$section_id];

// 			foreach( $ops as $op ){
// 				$this->settings_defaults[$section_id][$op['name']] = isset( $op['default'] ) ? $op['default'] : '';
// 			}
// 		}

// 		//shiftp( $this->settings_defaults );

// 	}

// 	function get_default( $option , $section ){

// 		if( $this->settings_defaults == null ) $this->set_defaults();

// 		$default = '';
// echo '==========<br/>';
// shiftp( $this->settings_defaults );
// 		//echo "[[$section|$option]]  ";
// 		if( isset( $this->settings_defaults[$section] ) && isset( $this->settings_defaults[$section][$option] ) ){
// 			$default = $this->settings_defaults[$section][$option];
// 		}
// 		return $default;
// 	}

	/**
	 * Show navigations as tab
	 *
	 * Shows all the settings section labels as tab
	 */
	function show_navigation() {
		$html = '<h2 class="nav-tab-wrapper">';

		foreach ( $this->settings_sections as $tab ) {
			$html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
		}

		$html .= '</h2>';

		echo $html;
	}

	/**
	 * Show the section settings forms
	 *
	 * This function displays every sections in a different form
	 */
	function show_forms() {
		?>
		<div class="metabox-holder">
			<div class="postbox">
				<?php foreach ( $this->settings_sections as $form ) { ?>
					<div id="<?php echo $form['id']; ?>" class="group">
						<form method="post" action="options.php">

							<?php do_action( 'wsa_form_top_' . $form['id'], $form ); ?>
							<?php settings_fields( $form['id'] ); ?>
							<?php do_settings_sections( $form['id'] ); ?>
							<?php do_action( 'wsa_form_bottom_' . $form['id'], $form ); ?>

							<div style="padding-left: 10px">
								<?php submit_button(); ?>
							</div>
						</form>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
		$this->script();
	}

	/**
	 * Tabbable JavaScript codes & Initiate Color Picker
	 *
	 * This code uses localstorage for displaying active tabs
	 */
	function script() {
		?>
		<script>
			jQuery(document).ready(function($) {
				//Initiate Color Picker
				$('.wp-color-picker-field').wpColorPicker();
				// Switches option sections
				$('.group').hide();
				var activetab = '';
				if (typeof(localStorage) != 'undefined' ) {
					activetab = localStorage.getItem("activetab");
				}
				if (activetab != '' && $(activetab).length ) {
					$(activetab).fadeIn();
				} else {
					$('.group:first').fadeIn();
				}
				$('.group .collapsed').each(function(){
					$(this).find('input:checked').parent().parent().parent().nextAll().each(
					function(){
						if ($(this).hasClass('last')) {
							$(this).removeClass('hidden');
							return false;
						}
						$(this).filter('.hidden').removeClass('hidden');
					});
				});

				if (activetab != '' && $(activetab + '-tab').length ) {
					$(activetab + '-tab').addClass('nav-tab-active');
				}
				else {
					$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
				}
				$('.nav-tab-wrapper a').on( 'click', function(evt) {
					$('.nav-tab-wrapper a').removeClass('nav-tab-active');
					$(this).addClass('nav-tab-active').blur();
					var clicked_group = $(this).attr('href');
					if (typeof(localStorage) != 'undefined' ) {
						localStorage.setItem("activetab", $(this).attr('href'));
					}
					$('.group').hide();
					$(clicked_group).fadeIn();
					evt.preventDefault();
				});
			});


			jQuery(document).ready(function($){
				// Uploading files
				var file_frame;

				jQuery( '.set-image-wrapper' ).on( 'click', '.button' , function( event ){

					var $wrap = $( this ).parents( '.set-image-wrapper' );

				    event.preventDefault();

				    // If the media frame already exists, reopen it.
				    if ( file_frame ) {
				      file_frame.open();
				      return;
				    }

				    // Create the media frame.
				    file_frame = wp.media.frames.file_frame = wp.media({
				      title: jQuery( this ).data( 'uploader_title' ),
				      button: {
				        text: jQuery( this ).data( 'uploader_button_text' ),
				      },
				      multiple: false  // Set to true to allow multiple files to be selected
				    });

				    // When an image is selected, run a callback.
				    file_frame.on( 'select', function() {
				      // We set multiple to false so only get one image from the uploader
				      attachment = file_frame.state().get('selection').first().toJSON();

				      // Do something with attachment.id and/or attachment.url here
				      $wrap.find( '.image-setting-wrap' ).html( '<img width="200" src="' + attachment.url + '"/>' );
				      $wrap.find( 'input.image-url' ).val( attachment.id );
				    });

				    // Finally, open the modal
				    file_frame.open();
				});

				jQuery( '.set-image-wrapper' ).on( 'click' , '.remove-button' , function(e){
					var $wrap = $( this ).parents( '.set-image-wrapper' );
					$wrap.find( '.image-setting-wrap' ).html( '' );

					//ID contains [] so the brackets need to be escaped
					var _id = $( this ).data( 'target-id' ).replace( '[' , '\\[' ).replace( ']' , '\\]' );
					//console.log( _id );
					$( '#' + _id ).val('');
					return false;
				});
			});


			//Media Uploader
			/*
			jQuery(document).ready(function($){
			  var _custom_media = true,
			      _orig_send_attachment = wp.media.editor.send.attachment;

			  $('.set-image-wrapper' ).on( 'click' , '.button' , function(e) {
			    var send_attachment_bkp = wp.media.editor.send.attachment;
			    var button = $(this);
			    var id = button.attr('id').replace('_button', '');
			    _custom_media = true;
			    wp.media.editor.send.attachment = function(props, attachment){
			      if ( _custom_media ) {
			        $("#"+id).val(attachment.url);
			      } else {
			        return _orig_send_attachment.apply( this, [props, attachment] );
			      };
			    }

			    wp.media.editor.open(button);
			    return false;
			  });

			  $('.add_media').on('click', function(){
			    _custom_media = false;
			  });
			});
			*/
		</script>
		<?php
	}

}
endif;
