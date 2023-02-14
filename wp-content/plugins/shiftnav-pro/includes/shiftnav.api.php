<?php

function shiftnav( $id , $settings = array() ){

	_SHIFTNAV()->set_current_instance( $id );

	$ops = shiftnav_get_instance_options( $id );

	extract( wp_parse_args( $settings , array(
		'theme_location'	=> !empty( $ops['theme_location'] ) ? $ops['theme_location'] : '_none',
		'menu'				=> !empty( $ops['menu'] ) ? $ops['menu'] : '_none',
		'container' 		=> 'nav',
		'edge'				=> !empty( $ops['edge'] ) ? $ops['edge'] : 'left',
		'skin'				=> !empty( $ops['skin'] ) ? $ops['skin'] : 'standard-dark',
	)));

	$class = "shiftnav shiftnav-nojs";
	$class.= " shiftnav-$id";
	$class.= " shiftnav-$edge-edge";
	$class.= " shiftnav-skin-$skin";
	$class.= " shiftnav-transition-standard";

	$id_att = strpos( $id , 'shiftnav' ) !== 0 ? 'shiftnav-'.$id : $id;

	?>



	<!-- ShiftNav #<?php echo $id; ?> -->
	<div class="<?php echo $class; ?>" id="<?php echo $id_att; ?>" data-shiftnav-id="<?php echo $id; ?>">
		<div class="shiftnav-inner">

		<?php if( shiftnav_op( 'display_panel_close_button' , $id ) == 'on' ): ?>
			<button class="shiftnav-panel-close"><i class="fa fa-times"></i></button>
		<?php endif; ?>

		<?php

		do_action( 'shiftnav_before' , $id );

		$disable_menu = shiftnav_op( 'disable_menu' , $id , 'off' ) == 'on' ? true : false;

		if( !$disable_menu ){

			$args = array(
				//'container_class' 	=> 'shiftnav-nav', //$container_class,	//shiftnav-transition-standard
				//'container_id'		=> $id,
				'container'			=> $container,
				// 'menu_class' 		=> 'shiftnav-menu',
				// 'walker'			=> new ShiftNavWalker,
				// 'fallback_cb'		=> 'shiftnav_fallback',
				// 'depth'				=> 0,
				'shiftnav'			=> $id,
			);

			$args = shiftnav_get_menu_args( $args , $id );


			// //Target size
			// $args['menu_class'].= ' shiftnav-targets-'.shiftnav_op( 'target_size' , 'general' );

			// //Text size
			// $args['menu_class'].= ' shiftnav-targets-text-'.shiftnav_op( 'text_size' , 'general' );

			// //Icon size
			// $args['menu_class'].= ' shiftnav-targets-icon-'.shiftnav_op( 'icon_size' , 'general' );

			// //Submenu indent
			// if( shiftnav_op( 'indent_submenus' , $id ) == 'on' ) $args['menu_class'].= ' shiftnav-indent-subs';

			// //Active on hover
			// if( shiftnav_op( 'active_on_hover' , 'general' ) == 'on' ) $args['menu_class'].= ' shiftnav-active-on-hover';

			// //Active Highlight
			// if( shiftnav_op( 'active_highlight' , 'general' ) == 'on' ) $args['menu_class'].= '	shiftnav-active-highlight';


			if( $menu != '_none' ){
				$args['menu'] = $menu;
			}
			else if( $theme_location != '_none' ){
				$args['theme_location'] = $theme_location;
				if( !has_nav_menu( $theme_location ) ){

					shiftnav_count_menus();

					$locs = get_registered_nav_menus();
					$loc = $locs[$theme_location];
					shiftnav_show_tip( 'Please <a href="'.admin_url('nav-menus.php?action=locations').'">assign a menu</a> to the <strong>'.$loc.'</strong> theme location' );
				}
			}
			else{
				shiftnav_count_menus();
				shiftnav_show_tip( 'Please <a href="'.admin_url( 'themes.php?page=shiftnav-settings#shiftnav_'.$id ).'">set a Theme Location or Menu</a> for this instance' );
			}

			wp_nav_menu( $args );

		}

		else{
			echo "\n\n\t\t<!-- ShiftNav Menu Disabled --> \n\n";
		}

		do_action( 'shiftnav_after' , $id );

		?>

		<button class="shiftnav-sr-close shiftnav-sr-only shiftnav-sr-only-focusable">
			<?php echo apply_filters( 'shiftnav_panel_sr_close_text' , '&times; Close Panel' ); ?>
		</button>

		</div><!-- /.shiftnav-inner -->
	</div><!-- /.shiftnav #<?php echo $id; ?> -->


	<?php
}

function shiftnav_toggle( $target_id , $content = null, $args = array() ){

	//echo $target_id;

	$ops = shiftnav_get_instance_options( $target_id );
	//shiftp( $ops );

	if( $content == null && $content !== false ){
		$content = isset( $ops['toggle_content'] ) ? $ops['toggle_content'] : '';
		//if( !$content ) $content = __( 'Toggle ShiftNav' , 'shiftnav' );
	}

	_shiftnav_toggle( $target_id , $content, $args );
}
