<?php

// Custom Width
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id a.fl-button",
	'enabled'  => ! empty( $settings->width ) && 'custom' === $settings->width,
	'props'    => array(
		'width' => ( '' === trim( $settings->custom_width ) ? '200' : abs( $settings->custom_width ) ) . $settings->custom_width_unit,
	),
) );

// Alignment
FLBuilderCSS::responsive_rule( array(
	'settings'     => $settings,
	'setting_name' => 'align',
	'selector'     => ".fl-node-$id .fl-button-wrap",
	'prop'         => 'text-align',
) );

// Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'padding',
	'selector'     => ".fl-builder-content .fl-node-$id .fl-button-wrap a.fl-button",
	'unit'         => 'px',
	'props'        => array(
		'padding-top'    => 'padding_top',
		'padding-right'  => 'padding_right',
		'padding-bottom' => 'padding_bottom',
		'padding-left'   => 'padding_left',
	),
) );

// Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'typography',
	'selector'     => ".fl-builder-content .fl-node-$id a.fl-button, .fl-builder-content .fl-node-$id a.fl-button:visited",
) );

// Default background hover color
if ( ! empty( $settings->bg_color ) && empty( $settings->bg_hover_color ) ) {
	$settings->bg_hover_color = $settings->bg_color;
}

// Default background color for gradient styles.
if ( empty( $settings->bg_color ) && 'gradient' === $settings->style ) {
	$settings->bg_color = 'a3a3a3';
}

// Background Gradient
if ( ! empty( $settings->bg_color ) ) {
	$bg_grad_start = FLBuilderColor::adjust_brightness( $settings->bg_color, 30, 'lighten' );
}

// Set Default BG Color for Gradient
$bg_gradient_color             = '';
$bg_gradient_hover_color       = '';
$bg_gradient_color_start       = '';
$bg_gradient_hover_color_start = '';
if ( 'gradient' === $settings->style ) {
	$bg_gradient_color             = empty( $settings->bg_color ) ? 'a3a3a3' : $settings->bg_color;
	$bg_gradient_hover_color       = empty( $settings->bg_hover_color ) ? $bg_gradient_color : $settings->bg_hover_color;
	$bg_gradient_color_start       = FLBuilderColor::adjust_brightness( $bg_gradient_color, 30, 'lighten' );
	$bg_gradient_hover_color_start = FLBuilderColor::adjust_brightness( $bg_gradient_hover_color, 30, 'lighten' );
} elseif ( 'adv-gradient' === $settings->style ) {
	$bg_gradient_color             = 'a3a3a3';
	$bg_gradient_hover_color       = 'a3a3a3';
	$bg_gradient_color_start       = FLBuilderColor::adjust_brightness( $bg_gradient_color, 30, 'lighten' );
	$bg_gradient_hover_color_start = FLBuilderColor::adjust_brightness( $bg_gradient_hover_color, 30, 'lighten' );
}

// Border - Default
FLBuilderCSS::rule( array(
	'selector' => ".fl-builder-content .fl-node-$id a.fl-button, .fl-builder-content .fl-node-$id a.fl-button:visited",
	'enabled'  => ! empty( $settings->bg_color ) && 'adv-gradient' !== $settings->style,
	'props'    => array(
		'border' => '1px solid ' . FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $settings->bg_color, 12, 'darken' ) ),
	),
) );

// Border - Hover Default
FLBuilderCSS::rule( array(
	'selector' => ".fl-builder-content .fl-node-$id a.fl-button:hover, .fl-builder-content .fl-node-$id a.fl-button:focus",
	'enabled'  => ! empty( $settings->bg_hover_color ) && 'adv-gradient' !== $settings->style,
	'props'    => array(
		'border' => '1px solid ' . FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $settings->bg_hover_color, 12, 'darken' ) ),
	),
) );

$border_color_backup = '';
if ( 'adv-gradient' === $settings->style ) {
	if ( empty( $settings->border['color'] ) ) {
		$settings->border['color'] = FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( 'a3a3a3', 12, 'darken' ) );
	} else {
		$border_color_backup = $settings->border['color'];
	}
}
// Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'border',
	'selector'     => ".fl-builder-content .fl-node-$id a.fl-button, .fl-builder-content .fl-node-$id a.fl-button:visited",
) );
if ( 'adv-gradient' === $settings->style ) {
	$settings->border['color'] = $border_color_backup;
}

// Border - Hover Settings
if ( ! empty( $settings->border_hover_color ) && is_array( $settings->border ) ) {
	$settings->border['color'] = $settings->border_hover_color;
}

FLBuilderCSS::border_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'border',
	'selector'     => ".fl-builder-content .fl-node-$id a.fl-button:hover, .fl-builder-content .fl-node-$id a.fl-button:focus",
) );

?>

<?php if ( 'flat' === $settings->style ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited {
	<?php if ( ! empty( $settings->bg_color ) ) : ?>
	background: <?php echo FLBuilderColor::hex_or_rgb( $settings->bg_color ); ?>;
	<?php endif; ?>
}
<?php endif; ?>

<?php if ( 'gradient' === $settings->style ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited {
	background: linear-gradient(to bottom,  <?php echo FLBuilderColor::hex_or_rgb( $bg_gradient_color_start ); ?> 0%, <?php echo FLBuilderColor::hex_or_rgb( $bg_gradient_color ); ?> 100%);
}
<?php elseif ( 'adv-gradient' === $settings->style ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited {
	background-image: linear-gradient(to bottom,  <?php echo FLBuilderColor::hex_or_rgb( $bg_gradient_color_start ); ?> 0%, <?php echo FLBuilderColor::hex_or_rgb( $bg_gradient_color ); ?> 100%);
}
<?php elseif ( 'flat' === $settings->style && ! empty( $settings->bg_hover_color ) ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bg_hover_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button *,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited * {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color ); ?>;
}
<?php endif; ?>


<?php if ( $settings->duo_color1 && false !== strpos( $settings->icon, 'fad fa' ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .fl-button-icon:before {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->duo_color1 ); ?>;
}
<?php endif; ?>

<?php if ( $settings->duo_color2 && false !== strpos( $settings->icon, 'fad fa' ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .fl-button-icon:after {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->duo_color2 ); ?>;
	opacity: 1;
}
<?php endif; ?>


<?php // if ( ! empty( $settings->bg_hover_color ) ) : ?>
<?php if ( 'gradient' === $settings->style ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus {

	background: <?php echo FLBuilderColor::hex_or_rgb( $bg_gradient_hover_color ); ?>;

	<?php if ( 'gradient' == $settings->style ) : // Gradient ?>
	background: linear-gradient(to bottom,  <?php echo FLBuilderColor::hex_or_rgb( $bg_gradient_hover_color_start ); ?> 0%, <?php echo FLBuilderColor::hex_or_rgb( $bg_gradient_hover_color ); ?> 100%);
	<?php endif; ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_hover_color ) ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover span.fl-button-text,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover * {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_hover_color ); ?>;
}

<?php endif; ?>




<?php
// Transition
if ( 'enable' === $settings->button_transition && 'flat' === $settings->style ) :
	?>
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button * {
	transition: all 0.2s linear;
	-moz-transition: all 0.2s linear;
	-webkit-transition: all 0.2s linear;
	-o-transition: all 0.2s linear;
}
<?php endif; ?>

<?php if ( empty( $settings->text ) ) : ?>
	<?php if ( 'after' == $settings->icon_position ) : ?>
	.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button i.fl-button-icon-after {
		margin-left: 0;
	}
	<?php endif; ?>
	<?php if ( 'before' == $settings->icon_position ) : ?>
	.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button i.fl-button-icon-before {
		margin-right: 0;
	}
	<?php endif; ?>
<?php endif; ?>

<?php

	$button_node_id = "fl-node-$id";
if ( isset( $settings->id ) && ! empty( $settings->id ) ) {
	$button_node_id = $settings->id;
}

// Background Gradient
FLBuilderCSS::rule( array(
	'selector' => ".fl-builder-content .fl-node-$id a.fl-button, .fl-builder-content .fl-node-$id a.fl-button:hover",
	'enabled'  => 'adv-gradient' === $settings->style && FLBuilderColor::gradient( $settings->bg_gradient, true ),
	'props'    => array(
		'background-image' => FLBuilderColor::gradient( $settings->bg_gradient ),
	),
) );

FLBuilderCSS::rule( array(
	'selector' => ".fl-builder-content .fl-node-$id a.fl-button:hover",
	'enabled'  => 'adv-gradient' === $settings->style && FLBuilderColor::gradient( $settings->bg_gradient_hover, true ),
	'props'    => array(
		'background-image' => FLBuilderColor::gradient( $settings->bg_gradient_hover ),
	),
) );

// Click action - lightbox
if ( isset( $settings->click_action ) && 'lightbox' == $settings->click_action ) :
	if ( 'html' == $settings->lightbox_content_type ) :
		?>
	.<?php echo $button_node_id; ?>.fl-button-lightbox-content,
	.fl-node-<?php echo $id; ?>.fl-button-lightbox-content {
		background: #fff none repeat scroll 0 0;
		margin: 20px auto;
		max-width: 600px;
		padding: 20px;
		position: relative;
		width: auto;
	}

	.<?php echo $button_node_id; ?>.fl-button-lightbox-content .mfp-close,
	.<?php echo $button_node_id; ?>.fl-button-lightbox-content .mfp-close:hover,
	.fl-node-<?php echo $id; ?>.fl-button-lightbox-content .mfp-close,
	.fl-node-<?php echo $id; ?>.fl-button-lightbox-content .mfp-close:hover {
		top: -10px!important;
		right: -10px;
	}
	<?php endif; ?>

	<?php if ( 'video' == $settings->lightbox_content_type ) : ?>
	.fl-button-lightbox-wrap .mfp-content {
		background: #fff;
	}
	.fl-button-lightbox-wrap .mfp-iframe-scaler iframe {
		left: 2%;
		height: 94%;
		top: 3%;
		width: 96%;
	}
	.mfp-wrap.fl-button-lightbox-wrap .mfp-close,
	.mfp-wrap.fl-button-lightbox-wrap .mfp-close:hover {
		color: #333!important;
		right: -4px;
		top: -10px!important;
	}
	<?php endif; ?>

<?php endif; ?>
