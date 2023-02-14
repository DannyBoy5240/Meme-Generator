<?php

// Get the query data.
$query = FLBuilderLoop::query( $settings );


// Render the posts.
if ( $query->have_posts() ) :

	do_action( 'fl_builder_posts_module_before_posts', $settings, $query );

	$paged = ( FLBuilderLoop::get_paged() > 0 ) ? ' fl-paged-scroll-to' : '';

?>
<div class="fl-post-<?php echo $module->get_layout_slug() . $paged; ?>" itemscope="itemscope" itemtype="https://schema.org/Blog">
	<?php

	while ( $query->have_posts() ) {

    $query->the_post();
    
    ob_start();
    
    //echo $module->dir . 'includes/post-' . $module->get_layout_slug() . '.php';
    
    include apply_filters( 'fl_builder_ta_posts_module_layout_path', $module->dir . 'includes/post-' . $module->get_layout_slug() . '.php', $settings->layout, $settings );

		// Do shortcodes here so they are parsed in context of the current post.
		echo do_shortcode( ob_get_clean() );
	}

	?>
	<?php if ( 'grid' == $settings->layout ) : ?>
	<div class="fl-post-grid-sizer"></div>
	<?php endif; ?>
</div>
<div class="fl-clear"></div>
<?php endif; ?>
<?php

do_action( 'fl_builder_ta_posts_module_after_posts', $settings, $query );

// Render the pagination.
if ( 'none' != $settings->pagination && $query->have_posts() && $query->max_num_pages > 1 ) :

?>
<div class="fl-builder-pagination"<?php if ( in_array( $settings->pagination, array( 'scroll', 'load_more' ) ) ) { echo ' style="display:none;"';} ?>>
	<?php FLBuilderLoop::pagination( $query ); ?>
</div>
<?php if ( 'load_more' == $settings->pagination && $query->max_num_pages > 1 ) : ?>
<div class="fl-builder-pagination-load-more">
	<?php

	FLBuilder::render_module_html( 'button', array(
		'align'             => 'center',
		'bg_color'          => $settings->more_btn_bg_color,
		'bg_hover_color'    => $settings->more_btn_bg_hover_color,
		'border_radius'     => $settings->more_btn_border_radius,
		'font_size'         => $settings->more_btn_font_size,
		'icon'              => $settings->more_btn_icon,
		'icon_position'     => $settings->more_btn_icon_position,
		'icon_animation'    => $settings->more_btn_icon_animation,
		'link'              => '#',
		'link_target'       => '_self',
		'padding'           => $settings->more_btn_padding,
		'text'              => $settings->more_btn_text,
		'text_color'        => $settings->more_btn_text_color,
		'text_hover_color'  => $settings->more_btn_text_hover_color,
		'width'             => $settings->more_btn_width,
	));

	?>
</div>
<?php endif; ?>
<?php endif; ?>
<?php

do_action( 'fl_builder_ta_posts_module_after_pagination', $settings, $query );

// Render the empty message.
if ( ! $query->have_posts() ) :

?>
<div class="fl-post-grid-empty">
	<p><?php echo $settings->no_results_message; ?></p>
	<?php if ( $settings->show_search ) : ?>
	<?php get_search_form(); ?>
	<?php endif; ?>
</div>

<?php

endif;

wp_reset_postdata();

?>
