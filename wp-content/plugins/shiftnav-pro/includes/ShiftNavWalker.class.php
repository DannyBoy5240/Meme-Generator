<?php

/**
 * Create HTML list of nav menu items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker
 */
class ShiftNavWalker extends Walker_Nav_Menu {

	private $index = 0;
	protected $menuItemOptions;

	protected $submenu_type;
	protected $default_submenu_type = false;

	protected $offset_depth = 0;


	/**
	 * What the class handles.
	 *
	 * @see Walker::$tree_type
	 * @since 3.0.0
	 * @var string
	 */
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * Database fields to use.
	 *
	 * @see Walker::$db_fields
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$_depth = $depth+1;
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu sub-menu-$_depth\">\n";

		if( shiftnav_op( 'back_button_top' , 'general' ) == 'on' ){
			$output .= $this->get_back_retractor();
		}


	}

	function get_back_retractor(){

		$back_tag = shiftnav_op( 'back_tag' , 'general' );

		$back_text = shiftnav_op( 'back_text' , 'general' );
		$back_text = $back_text ? $back_text : __( 'Back' , 'shiftnav' );

		//Make Content Customizable
		$html = '<li class="shiftnav-retract"><'.$back_tag.' tabindex="0" class="shiftnav-target"><i class="fa fa-chevron-left"></i> '.$back_text.'</'.$back_tag.'></li>';

		return $html;
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {

		// $back_tag = shiftnav_op( 'back_tag' , 'general' );

		// $back_text = shiftnav_op( 'back_text' , 'general' );
		// $back_text = $back_text ? $back_text : __( 'Back' , 'shiftnav' );

		// //Make Content Customizable
		// $output.= '<li class="shiftnav-retract"><'.$back_tag.' class="shiftnav-target"><i class="fa fa-chevron-left"></i> '.$back_text.'</'.$back_tag.'></li>';
		// //$output.= '<li class="shiftnav-retract">BACK</li>';

		if( shiftnav_op( 'back_button_bottom' , 'general' ) != 'off' ){
			$output .= $this->get_back_retractor();
		}

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
// echo $item->ID."<br/>";
//if( $item->ID == 2120 ) shiftp( $item );

		//Menu Segments
		//shiftp( $item );
//echo $item->ID . ' :: ' . $item->object.'<br/>';
//if( $item->object == 'ubermenu-custom' ) shiftp( $item );

		if( $item->object == 'ubermenu-custom' && $item->type_label == '[UberMenu Menu Segment]' ){
			return $this->handle_menu_segment( $output , $item , $depth , $args , $id );
		}



		//$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		//shiftp( $item );

		$data = shiftnav_get_menu_item_data( $item->ID );
		//shiftp( $data );

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/** ShiftNav Stuff **/
		$shiftnav_atts = array();

		//Submenus
		$has_sub = $item->has_sub; //determined via children array in display_element()
		// $has_sub = false;
		// if( in_array( 'menu-item-has-children' , $classes ) ) $has_sub = true;

		if( SHIFTNAV_PRO ){
			$this->submenu_type = $submenu_type = isset( $data['submenu_type'] ) ? $data['submenu_type'] : 'default';
			if( $submenu_type == 'default' ){
				if( !$this->default_submenu_type ){
					$this->default_submenu_type = shiftnav_op( 'submenu_type_default' , '__current_instance__' );
				}
				$this->submenu_type = $submenu_type = $this->default_submenu_type;
			}
		}
		else $this->submenu_type = $submenu_type = 'always';

		if( $has_sub ){
			$classes[] = 'shiftnav-sub-'.$submenu_type;
		}

		//Depth
		$classes[] = 'shiftnav-depth-'.$depth;


		//Highlight
		if( isset( $data['highlight'] ) && ( $data['highlight'] == 'on' ) ){
			$classes[] = 'shiftnav-highlight';
		}

		//ScrollTo
		if( isset( $data['scrollto'] ) && $data['scrollto'] != '' ){
			$classes[] = 'shiftnav-scrollto';
			$shiftnav_atts['data-shiftnav-scrolltarget'] = $data['scrollto'];
		}

		//Icon
		$icon = $icon_class = '';
		//Main Icon Set
		if( isset( $data['icon'] ) && $data['icon'] != '' ){
			$icon_class = $data['icon'];
		}
		//Custom Icon Set
		if( isset( $data['icon_custom_class'] ) && $data['icon_custom_class'] != '' ){
			if( $icon_class ) $icon_class.= ' ';
			$icon_class.= $data['icon_custom_class'];
		}
		//If either has produced a class, create an icon
		if( $icon_class ){
			$classes[] = 'shiftnav-has-icon';
			$icon = '<i class="shiftnav-icon '.$icon_class.'"></i>';
		}


		//Disable Link
		$disable_link = isset( $data['disable_link'] ) && ( $data['disable_link'] == 'on' ) ? true : false;



		//Title
		$title = '';
		if( !( isset( $data['disable_text'] ) && $data['disable_text'] == 'on' ) ){
			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$title = do_shortcode( $title );
		}
		else{
			$classes[] = 'shiftnav-text-disabled';
		}


		/**
		 * Filter the CSS class(es) applied to a menu item's <li>.
		 *
		 * @since 3.0.0
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of arguments. @see wp_nav_menu()
		 */

		if( isset( $data['disable_current'] ) && $data['disable_current'] == 'on' ){
			$remove_current = array( 'current-menu-item' , 'current-menu-parent' , 'current-menu-ancestor' );
			foreach( $classes as $k => $c ){
				if( in_array( $c ,  $remove_current ) ){
					unset( $classes[$k] );
				}
			}
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args , $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';



		/**
		 * Filter the ID applied to a menu item's <li>.
		 *
		 * @since 3.0.1
		 *
		 * @param string The ID that is applied to the menu item's <li>.
		 * @param object $item The current menu item.
		 * @param array $args An array of arguments. @see wp_nav_menu()
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= /* $indent . */ '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';


		//Custom URL
		if( isset( $data['custom_url'] ) && $data['custom_url'] ){
			$atts['href'] = do_shortcode( $data['custom_url'] );
		}

		/**
		 * Filter the HTML attributes applied to a menu item's <a>.
		 *
		 * @since 3.6.0
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
		 *
		 *     @type string $title  The title attribute.
		 *     @type string $target The target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item The current menu item.
		 * @param array  $args An array of arguments. @see wp_nav_menu()
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args , $depth );

		//Merge ShiftNav atts
		$atts = array_merge( $atts , $shiftnav_atts );
		if( $disable_link ) unset( $atts['href'] );			//remove href for disabled links

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$el = 'a';
		if( $disable_link ) $el = 'span';

		// Anchor class
		$anchor_class = 'shiftnav-target';
		if( isset( $data['anchor_class'] ) && ( $data['anchor_class'] ) ) $anchor_class.= ' '.esc_attr( $data['anchor_class'] );


		$item_output = $args->before;
		$item_output .= '<'.$el.' class="'.$anchor_class.'" '. $attributes .'>';



		if( $icon ) $title = '<span class="shiftnav-target-text">'.$title.'</span>';
		$item_output .= $args->link_before . $icon . $title . $args->link_after;

		$item_output .= '</'.$el.'>';

		if( $has_sub ){
			switch( $submenu_type ){
				case 'shift':
					$item_output.= '<span tabindex="0" class="shiftnav-submenu-activation"><i class="fa fa-chevron-right"></i></span>';
					break;
				case 'accordion':
					$open_icon = shiftnav_op( 'accordion_toggle_icon_open' , '__current_instance__' );
					$close_icon = shiftnav_op( 'accordion_toggle_icon_close' , '__current_instance__' );
					$item_output.= '<span tabindex="0" class="shiftnav-submenu-activation shiftnav-submenu-activation-open"><i class="fa fa-'.$open_icon.'"></i></span>';
					$item_output.= '<span tabindex="0" class="shiftnav-submenu-activation shiftnav-submenu-activation-close"><i class="fa fa-'.$close_icon.'"></i></span>';
					break;
			}
		}

		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes $args->before, the opening <a>,
		 * the menu item's title, the closing </a>, and $args->after. Currently, there is
		 * no filter for modifying the opening and closing <li> for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of arguments. @see wp_nav_menu()
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if( $item->object != 'ubermenu-custom' ||
			$item->type_label != '[UberMenu Menu Segment]' ||
			shiftnav_op( 'process_uber_segments' , 'general' ) == 'off' ){

			$output .= "</li>";
		}
	}



	/* Recursive function to remove all children */
	function clear_children( &$children_elements , $id ){

		if( empty( $children_elements[ $id ] ) ) return;

		foreach( $children_elements[ $id ] as $child ){
			$this->clear_children( $children_elements , $child->ID );
		}
		unset( $children_elements[ $id ] );
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Calls parent function in UberMenuWalker.class.php
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		if ( !$element )
			return;

		//Offset Depth
		$original_depth = $depth;
		$depth = $depth + $this->offset_depth;



		$id_field = $this->db_fields['id'];
		$id = $element->$id_field;

//if( $element->ID == 1739 ) echo $element->ID.'<br/>';

		//Ignore UberMenu Elements
		if( $element->object == 'ubermenu-custom' ){
			// if( empty( $children_elements[ $id ] ) ) return;
			// foreach( $children_elements[ $id ] as $child ){
			// 	$this->clear_children( $children_elements , $child->ID );
			// }
			// unset( $children_elements[ $id ] );

			//This is the part of Walker_Nav_Menu:dispay_element that handles printing children
//echo $element->ID . ' :: ' . $element->type_label. '<br/>';
			if( $element->type_label == '[UberMenu Menu Segment]' && shiftnav_op( 'process_uber_segments' , 'general' ) !== 'off' ){
				//$element->shiftnav_menu_segment = 'hi';
				//echo $element->ID ;
			}
			else{
				if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
					foreach ( $children_elements[ $id ] as $child ){
						if ( !isset($newlevel) ) {
							$newlevel = true;
							//start the child delimiter
							$cb_args = array_merge( array(&$output, $depth), $args);
							//call_user_func_array(array($this, 'start_lvl'), $cb_args); // removed, as we don't want the opening UL
						}
						$this->display_element( $child, $children_elements, $max_depth, $depth+1, $args, $output );
					}
					unset( $children_elements[ $id ] );
				}

				return;
			}
		}






		$data = shiftnav_get_menu_item_data( $id );

		//If the item is disabled, kill its children, Lannister-style
		if( isset( $data['disable_item'] ) && ( $data['disable_item'] == 'on' ) ){
			$this->clear_children( $children_elements , $id );
			return;
		}

		//Disabled Submenu
		if( isset( $data['disable_submenu'] ) && ( $data['disable_submenu'] == 'on' ) ){
			$this->clear_children( $children_elements , $id );
		}

		if( isset( $children_elements[$element->ID] ) ){
			$element->has_sub = 1;
		}
		else{
			$element->has_sub = 0;
		}


		//UberMenu Conditionals
		if( shiftnav_op( 'inherit_ubermenu_conditionals' , 'general' ) == 'on' ){

			if( function_exists( 'ubermenu' ) ){

				$has_children = ! empty( $children_elements[$element->$id_field] );
				if ( isset( $args[0] ) && is_array( $args[0] ) ){
					$args[0]['has_children'] = $has_children;
				}
				$cb_args = array_merge( array(&$output, $element, $depth), $args);

				$umitem_object_class = apply_filters( 'ubermenu_item_object_class' , 'UberMenuItemDefault' , $element , $id , '' );
				//$umitem = new $umitem_object_class( $output , $element , $depth, $cb_args[3], $id , $this , $has_children );	//The $args that get passed to start_el are $cb[3] -- i.e. the 4the element in the array merged above
				$umitem = new dummy_um_item( $element->ID , $element );
				$display_on = apply_filters( 'ubermenu_display_item' , true , $this , $element , $max_depth, $depth, $args , $umitem );


			}
			else{
				$display_on = apply_filters( 'uberMenu_display_item' , true , $this , $element , $max_depth, $depth, $args );
			}

			if( !$display_on ){
				$this->clear_children( $children_elements , $id );
				return;
			}
		}

		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function getUberOption( $item_id , $id ){
		//get_post_meta or from uber_options, depending on whether uber_options is set

		$option_id = 'menu-item-'.$id;

		//Initialize array
		if( !is_array( $this->menuItemOptions ) ){
			$this->menuItemOptions = array();
			$this->noUberOps = array();
		}

		//We haven't investigated this item yet
		if( !isset( $this->menuItemOptions[ $item_id ] ) ){

			$uber_options = false;
			if( empty( $this->noUberOps[ $item_id ] ) ) {
				$uber_options = get_post_meta( $item_id , '_uber_options', true );	//TODO - wrap in API for UberMenu - ubermenu_get_menu_item_data()?
				if( !$uber_options ) $this->noUberOps[ $item_id ] = true; //don't check again for this menu item
			}

			//If $uber_options are set, use them
			if( $uber_options ){
				$this->menuItemOptions[ $item_id ] = $uber_options;
			}
			//Otherwise get the old meta
			else{
				$option_id = '_menu_item_'.$id; //UberMenu::convertToOldParameter( $id );
				return get_post_meta( $item_id, $option_id , true );
			}
		}
		return isset( $this->menuItemOptions[ $item_id ][ $option_id ] ) ? stripslashes( $this->menuItemOptions[ $item_id ][ $option_id ] ) : '';
	}





	function handle_menu_segment( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if( !defined( 'UBERMENU_MENU_ITEM_META_KEY' ) ){
			return;
		}

		$um_args = get_post_meta( $item->ID , UBERMENU_MENU_ITEM_META_KEY , true );
		$menu_segment = $um_args['menu_segment'];

		$output .= "<!-- begin Segment: Menu ID $menu_segment -->";

		if( $menu_segment == '_none' || !$menu_segment ){
			$output.='<!-- no menu set for segment-->';
		}

		$menu_object = wp_get_nav_menu_object( $menu_segment );
		if( !$menu_object ){
			return $html.'<!-- no menu exists with ID "'.$menu_segment.'" -->';
		}


//shiftp( $args );
		//Set Depth offset for segment
		$current_depth_offset = $this->offset_depth;	//potential issue?  Could set in $args and increment that way.
		$this->offset_depth = $depth;

		$menu_segment_args = array(
			'menu' 			=> $menu_segment,
			'menu_class'	=> 'na',	//just to prevent PHP notice
			'echo' 			=> false ,
			'container' 	=> false,
			'items_wrap'	=> '%3$s',
			'walker'		=> $this,
			'depth'			=> 0,
			'shiftnav_segment' => $item->ID,
			'shiftnav_instance' => $args->shiftnav,
			'shiftnav'		=> $args->shiftnav,
			//'uber_instance'	=> $this->args->uber_instance,
			//'uber_segment'	=> $this->ID,
		);

		//Record the settings so we can easily replace when force-filtering
		$menu_segment_args['shiftnav_segment_args'] = $menu_segment_args;

		//Generate the menu HTML
		$segment_html = wp_nav_menu( $menu_segment_args );

		$output .= $segment_html;


		$output .= "<!-- end Segment: Menu ID $menu_segment -->";

		$this->offset_depth = $current_depth_offset;

		//shiftp( $um_args );



	}

} // Walker_Nav_Menu



class dummy_um_item{
	private $ID;
	private $settings;
	private $shiftnav_item;
	private $url;

	function __construct( $id , &$item ){
		$this->ID = $id;
		$this->shiftnav_item = $item;
	}

	function getSetting( $key ){
		if( !isset( $this->settings ) ){
			$this->settings = get_post_meta( $this->ID, UBERMENU_MENU_ITEM_META_KEY , true );
		}
		if( isset( $this->settings[$key] ) ){
			return $this->settings[$key];
		}
		return false;
	}

	function set_url( $url ){
		$this->url = $url;
		$this->shiftnav_item->url = $url;
	}
	function get_url(){
		return $this->shiftnav_item->url;
	}
}
