<?php

require_once( SHIFTNAV_DIR.'customizer/customizer.styles.generator.php' );
require_once( SHIFTNAV_DIR.'customizer/customizer.styles.manager.php' );
require_once( SHIFTNAV_DIR.'customizer/customizer.styles.menu-item.php' );

function shiftnav_register_customizers( $wp_customize ){

	require_once( SHIFTNAV_DIR.'customizer/customizer.controls.php' );

	//shiftnav_register_customizer( 'togglebar' , 'togglebar' , $wp_customize );

	$section_id = $panel_id = 'shiftnav_config_togglebar'; //.$variation_string;
	$wp_customize->add_panel( $panel_id, array(
		'title'			=> __( 'ShiftNav - Toggle Bar', 'shiftnav' ),
		'priority'		=> 30,
	) );
	$wp_customize->add_section( $panel_id.'_config', array(
		'title'		=> __( 'Configuration', 'shiftnav' ),
		'priority'	=> 10,
		'panel'		=> $panel_id,
	) );
	$wp_customize->add_section( $panel_id.'_styles', array(
		'title'		=> __( 'Styles', 'shiftnav' ),
		'priority'	=> 20,
		'panel'		=> $panel_id,
	) );
	$all_fields = shiftnav_get_settings_fields();
	$togglebar_fields = $all_fields['shiftnav_togglebar'];
	shiftnav_build_customizer_settings( $wp_customize , $togglebar_fields , SHIFTNAV_PREFIX.'togglebar' , $panel_id );


	$configs = shiftnav_get_menu_configurations( true );
	foreach( $configs as $config_id ){
		//echo $config_id;
		shiftnav_register_customizer( $config_id , $config_id , $wp_customize );
		//shiftnav_register_theme_customizer( $instance.'_responsive' , $instance , $wp_customize );
	}

}
add_action( 'customize_register', 'shiftnav_register_customizers' );

function shiftnav_register_customizer( $config_id , $config_id_root , $wp_customize ) {

	$config_tag = SHIFTNAV_PREFIX.$config_id;
	$prefixed_config_id_root = SHIFTNAV_PREFIX.$config_id_root;

	//$section_id = 
	$panel_id = 'shiftnav_config_'.$config_id; //.$variation_string;

	$wp_customize->add_panel( $panel_id, array(
		'title'			=> __( 'ShiftNav - Panel', 'shiftnav' ) . ' ['.$config_id.']',
		'priority'		=> 35,
	) );


	$wp_customize->add_section( $panel_id.'_config', array(
		'title'		=> __( 'Configuration', 'shiftnav' ),
		'priority'	=> 10,
		'panel'		=> $panel_id,
	) );

	$wp_customize->add_section( $panel_id.'_content', array(
		'title'		=> __( 'Content', 'shiftnav' ),
		'priority'	=> 20,
		'panel'		=> $panel_id,
	) );

	if( SHIFTNAV_PRO ){
		$wp_customize->add_section( $panel_id.'_styles_panel', array(
			'title'		=> __( 'Styles - Panel', 'shiftnav' ),
			'priority'	=> 30,
			'panel'		=> $panel_id,
		) );
		$wp_customize->add_section( $panel_id.'_styles_menu_items', array(
			'title'		=> __( 'Styles - Menu Items', 'shiftnav' ),
			'priority'	=> 40,
			'panel'		=> $panel_id,
		) );
		$wp_customize->add_section( $panel_id.'_styles_activators', array(
			'title'		=> __( 'Styles - Activators &amp; Retractors', 'shiftnav' ),
			'priority'	=> 50,
			'panel'		=> $panel_id,
		) );
		$wp_customize->add_section( $panel_id.'_styles_submenus', array(
			'title'		=> __( 'Styles - Submenus', 'shiftnav' ),
			'priority'	=> 60,
			'panel'		=> $panel_id,
		) );
		$wp_customize->add_section( $panel_id.'_styles_font', array(
			'title'		=> __( 'Styles - Font', 'shiftnav' ),
			'priority'	=> 70,
			'panel'		=> $panel_id,
		) );
	}

	// $wp_customize->add_section( $panel_id.'_top_level', array(
	// 	'title'		=> __( 'Top Level Styles', 'shiftnav' ),
	// 	'priority'	=> 30,
	// 	'panel'		=> $panel_id,
	// ) );


	// $wp_customize->add_section( $panel_id.'_submenu', array(
	// 	'title'		=> __( 'Submenu Styles', 'shiftnav' ),
	// 	'priority'	=> 40,
	// 	'panel'		=> $panel_id,
	// ) );

	// $wp_customize->add_section( $panel_id.'_font', array(
	// 	'title'		=> __( 'Fonts', 'shiftnav' ),
	// 	'priority'	=> 50,
	// 	'panel'		=> $panel_id,
	// ) );

	// $wp_customize->add_section( $panel_id.'_markup', array(
	// 	'title'		=> __( 'Markup', 'shiftnav' ),
	// 	'priority'	=> 10,
	// 	'panel'		=> $panel_id,
	// ) );



	$setting_op = $config_tag;
	$all_fields = shiftnav_get_settings_fields();
	// echo 'GOGO'. $prefixed_config_id_root;
	// foreach( $all_fields as $_id => $blah ){
	// 	echo "\n".$_id;
	// }
	//echo shiftp( $all_fields );
	$fields = $all_fields[$prefixed_config_id_root];

	shiftnav_build_customizer_settings( $wp_customize , $fields , $setting_op , $panel_id , 0 );

	//shiftp( $fields );
}


function shiftnav_build_customizer_settings( $wp_customize , $fields , $setting_op , $panel_id , $priority = 0 ){

	foreach( $fields as $field ){

		$priority+= 10;

		if( isset( $field['customizer'] ) && $field['customizer'] ){
			$setting_id = $setting_op.'['.$field['name'].']';

			$default = isset( $field['default'] ) ? $field['default'] : '';
			if( $field['type'] == 'checkbox' ){
				$default = $default == 'on' ? true : false;
			}

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'		=> $default,
					'type'			=> 'option',
				)
			);

			$field_section_id = $panel_id; //$section_id;
			if( isset( $field['customizer_section'] ) ){
				$field_section_id = $panel_id.'_'.$field['customizer_section'];	//shiftnav_config_{config_id}_{section}
			}

			$args = array(
				'label'			=> $field['label'],
				'section'		=> $field_section_id,
				'settings'		=> $setting_id,
				'priority'		=> $priority,
			);

			if( isset( $field['desc'] ) ){
				$args['description'] = $field['desc'];
			}

			switch( $field['type'] ){

				case 'text':

					$args['type'] = 'text';
					$wp_customize->add_control(
						$setting_id,
						$args
					);
					break;

				case 'textarea': 
					$args['type'] = 'textarea';
					$wp_customize->add_control(
						$setting_id,
						$args
					);
					break;

				case 'checkbox':

					// $args['type'] = 'checkbox';
					// $wp_customize->add_control(
					// 	$setting_id,
					// 	$args
					// );
					// add_filter( 'customize_sanitize_js_'.$setting_id , 'shiftnav_adapt_checkbox_values' , 10 , 2 );
					// break;

					$args['type'] = 'checkbox';

					add_filter( 'customize_sanitize_js_'.$setting_id , 'shiftnav_adapt_checkbox_values' , 10 , 2 );
					$wp_customize->add_control( 
						new WP_Customize_Control_ShiftNav_Checkbox(
							$wp_customize,
							$setting_id,
							$args
						)
					);

					break;

				case 'select':

					$args['type'] = 'select';
					$ops = $field['options'];
					if( !is_array( $ops ) && function_exists( $ops ) ){
						$ops = $ops();
					}
					$args['choices'] = $ops;
					$wp_customize->add_control(
						$setting_id,
						$args
					);
					break;

				case 'radio':

					$args['type'] = 'radio';
					$args['choices'] = $field['options'];

					if( isset( $field['customizer_control'] ) && $field['customizer_control'] == 'radio_html' ){
						$wp_customize->add_control( 
							new WP_Customize_Control_ShiftNav_Radio_HTML(
								$wp_customize,
								$setting_id,
								$args
							)
						);
					}
					else{
						$wp_customize->add_control(
							$setting_id,
							$args
						);
					}
					break;



				case 'color':
					
					$wp_customize->add_control(
						new WP_Customize_Color_Control(
							$wp_customize,
							$setting_id,
							$args
						)
					);
					break;

				case 'image':

					$wp_customize->add_control(
						new WP_Customize_Image_Control(
							$wp_customize,
							$setting_id,
							$args
						)
					);
			}

		}
	}

}

function shiftnav_adapt_checkbox_values( $value , $setting ){
	//echo '[[[['.$value;
	$value = $value == 'on' ? true : false;
	return $value;
}




function shiftnav_customizer_assets(){
	wp_enqueue_style( 'shiftnav-font-awesome' , SHIFTNAV_URL.'assets/css/fontawesome/css/font-awesome.min.css' );
}
add_action( 'customize_controls_enqueue_scripts' , 'shiftnav_customizer_assets' );




function shiftnav_customizer_css() {

	//echo shiftnav_generate_custom_styles();

	global $wp_customize;
	if ( isset( $wp_customize ) ):
	?>
	<style type="text/css">
		<?php 
			echo shiftnav_generate_all_menu_preview_styles();
		?>
	</style>
	<?php endif;
}
add_action( 'wp_head', 'shiftnav_customizer_css' );


function shiftnav_generate_all_menu_preview_styles(){

	$all_styles = array();

	//$all_styles['main'] = shiftnav_generate_menu_preview_styles( 'main' );

	$all_styles['togglebar'] = shiftnav_generate_menu_preview_styles( 'togglebar' );
	$configs = shiftnav_get_menu_configurations( true );
	foreach( $configs as $config_id ){
		$all_styles[$config_id] = shiftnav_generate_menu_preview_styles( $config_id );
	}

	return shiftnav_generate_all_menu_styles( $all_styles );

}

function shiftnav_generate_menu_preview_styles( $config_id , $fields = false ){

	$menu_key = SHIFTNAV_PREFIX . $config_id;

	if( !$fields ){
		$all_fields = shiftnav_get_settings_fields();
		$fields = $all_fields[$menu_key];
	}

	$menu_styles = array();

	foreach( $fields as $field ){

		if( isset( $field['custom_style'] ) ){
			$callback = 'shiftnav_get_menu_style_'. $field['custom_style'];

			if( function_exists( $callback ) ){
				$callback( $field , $config_id , $menu_styles );
			}
		}

	}

	return $menu_styles;

}

