<?php if ( 'columns' == $settings->layout ) : ?>
<div class="fl-post-column">
<?php endif; ?>

<<?php echo $module->get_posts_container(); ?> <?php $module->render_post_class(); ?><?php FLPostGridModule::print_schema( ' itemscope="itemscope" itemtype="' . FLPostGridModule::schema_itemtype() . '"' ); ?>>
	<?php

	FLPostGridModule::schema_meta();

	do_action( 'fl_builder_post_grid_before_content', $settings, $module );

	$content = apply_filters( 'fl_theme_builder_custom_post_grid_html', $settings->custom_post_layout->html, $settings );

	echo do_shortcode( FLThemeBuilderFieldConnections::parse_shortcodes( $content ) );

	do_action( 'fl_builder_post_grid_after_content', $settings, $module );

	?>
</<?php echo $module->get_posts_container(); ?>>

<?php if ( 'columns' == $settings->layout ) : ?>
</div>
<?php endif; ?>
