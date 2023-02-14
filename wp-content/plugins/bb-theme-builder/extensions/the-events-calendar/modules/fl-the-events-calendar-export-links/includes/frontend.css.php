.fl-node-<?php echo $id; ?> .tribe-events-cal-links {
	text-align: <?php echo $settings->align; ?>;
}

<?php if ( is_numeric( $settings->border_radius ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-events-cal-links a.tribe-events-button {
	border-radius: <?php echo $settings->border_radius; ?>px;
}
<?php endif ?>

<?php

FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id a.tribe-events-button",
	'props'    => array(
		'color'            => $settings->text_color,
		'background-color' => $settings->bg_color,
	),
) );

FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id a.tribe-events-button:hover",
	'props'    => array(
		'color'            => $settings->hover_text_color,
		'background-color' => $settings->hover_bg_color,
	),
) );

// Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'padding',
	'selector'     => ".fl-node-$id a.tribe-events-button, .fl-node-$id a.tribe-events-button:hover",
	'unit'         => 'px',
	'props'        => array(
		'padding-top'    => 'padding_top',
		'padding-right'  => 'padding_right',
		'padding-bottom' => 'padding_bottom',
		'padding-left'   => 'padding_left',
	),
) );
