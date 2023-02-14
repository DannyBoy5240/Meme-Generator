<?php

function shiftnav_searchbar( $placeholder = "Search..." , $post_type = '' ){

	?>
	<!-- ShiftNav Search Bar -->
	<div class="shiftnav-search">
		<form role="search" method="get" class="shiftnav-searchform" action="<?php echo home_url( '/' ); ?>">
			<input type="text" placeholder="<?php echo $placeholder; ?>" value="" name="s" class="shiftnav-search-input" />
			<?php if( $post_type ): ?>
			<input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
			<?php endif; ?>
			<input type="submit" class="shiftnav-search-submit" value="&#xf002;" />
		</form>
	</div>
	<!-- end .shiftnav-search -->

	<?php
}
function shiftnav_searchbar_shortcode( $atts , $content ){

	extract( shortcode_atts( array(
		'placeholder' => __( 'Search...' , 'shiftnav' ),
		'post_type'	=> '',
	), $atts ) );

	ob_start();
	shiftnav_searchbar( $placeholder , $post_type );
	$s = ob_get_clean();
	return $s;
}
add_shortcode( 'shiftnav-search' , 'shiftnav_searchbar_shortcode' );

function shiftnav_content_searchbar(){
	shiftnav_searchbar();
}
//add_action( 'shiftnav_before' , 'shiftnav_content_searchbar' , 30 );




function shiftnav_searchtoggle( $placeholder = "Search..." , $position = '' , $post_type = '' ){
	?>

	<!-- ShiftNav Search Bar Toggle -->
	<a class="shiftnav-searchbar-toggle <?php if( $position ) echo 'shiftnav-searchbar-toggle-pos-'.$position; ?> shiftnav-toggle-main-block shiftnav-toggle-main-ontop" tabindex="1"><i class="fa fa-search"></i></a>

	<!-- ShiftNav Search Bar Drop -->
	<div class="shiftnav-searchbar-drop">
		<form role="search" method="get" class="shiftnav-searchform" action="<?php echo home_url( '/' ); ?>">
			<input type="text" placeholder="<?php echo $placeholder; ?>" value="" name="s" class="shiftnav-search-input" />
			<?php if( $post_type ): ?>
			<input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
			<?php endif; ?>
			<input type="submit" class="shiftnav-search-submit" value="&#xf002;" />
		</form>
	</div>
	<!-- end .shiftnav-searchbar-drop -->

	<?php
}

function shiftnav_search_toggle_shortcode( $atts , $content ){

	extract( shortcode_atts( array(
		'placeholder' 	=> __( 'Search...' , 'shiftnav' ),
		'position'		=> '',
		'post_type'		=> '',
	), $atts ) );


	ob_start();
	shiftnav_searchtoggle( $placeholder , $position , $post_type );
	$s = ob_get_clean();
	return $s;
}
add_shortcode( 'shiftnav-search-toggle' , 'shiftnav_search_toggle_shortcode' );
