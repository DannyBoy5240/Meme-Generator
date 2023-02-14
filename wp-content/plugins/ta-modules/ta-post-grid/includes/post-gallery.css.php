<?php

	$text_bg_color    = ! empty( $settings->text_bg_color ) ? $settings->text_bg_color : 'ffffff';
	$text_bg_opacity  = ! empty( $settings->text_bg_opacity ) ? $settings->text_bg_opacity : '100';
	$text_bg          = 'rgba(' . implode( ',', FLBuilderColor::hex_to_rgb( $text_bg_color ) ) . ',' . ( $text_bg_opacity / 100 ) . ')';

	?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-link,
.fl-node-<?php echo $id; ?> .fl-post-gallery-link .fl-post-gallery-title{
	color: #<?php echo $settings->text_color ?>;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap{
	background-color: #<?php echo $text_bg_color; ?>;
	background-color: <?php echo $text_bg; ?>;
}

<?php if ( isset( $settings->has_icon ) && 'yes' == $settings->has_icon ) : ?>

	.fl-node-<?php echo $id ?> .fl-post-gallery .fl-gallery-icon{
	<?php if ( 'above' == $settings->icon_position ) : ?>
		margin-bottom: 10px;
	<?php else : ?>
		margin-top: 10px;
	<?php endif; ?>
	}

	<?php if ( ! empty( $settings->icon_size ) || ! empty( $settings->icon_color ) ) : ?>
		.fl-node-<?php echo $id ?> .fl-post-gallery .fl-gallery-icon i,
		.fl-node-<?php echo $id ?> .fl-post-gallery .fl-gallery-icon i:before {
		<?php if ( ! empty( $settings->icon_size ) ) : ?>
			width: <?php echo $settings->icon_size ?>px;
			height: <?php echo $settings->icon_size ?>px;
			font-size: <?php echo $settings->icon_size ?>px;
		<?php endif; ?>
		<?php if ( ! empty( $settings->icon_color ) ) : ?>
			color: #<?php echo $settings->icon_color ?>;
		<?php endif; ?>
		}
	<?php endif; ?>

<?php endif; ?>

<?php if ( isset( $settings->hover_transition ) && 'fade' != $settings->hover_transition ) : ?>
	.fl-node-<?php echo $id ?> .fl-post-gallery-text{
	<?php if ( 'slide-up' == $settings->hover_transition ) : ?>
		-webkit-transform: translate3d(-50%,-30%,0);
		   -moz-transform: translate3d(-50%,-30%,0);
			-ms-transform: translate(-50%,-30%);
				transform: translate3d(-50%,-30%,0);
	<?php elseif ( 'slide-down' == $settings->hover_transition ) : ?>
		-webkit-transform: translate3d(-50%,-70%,0);
		   -moz-transform: translate3d(-50%,-70%,0);
			-ms-transform: translate(-50%,-70%);
				transform: translate3d(-50%,-70%,0);
	<?php elseif ( 'scale-up' == $settings->hover_transition ) : ?>
		-webkit-transform: translate3d(-50%,-50%,0) scale(.7);
		   -moz-transform: translate3d(-50%,-50%,0) scale(.7);
			-ms-transform: translate(-50%,-50%) scale(.7);
				transform: translate3d(-50%,-50%,0) scale(.7);
	<?php elseif ( 'scale-down' == $settings->hover_transition ) : ?>
		-webkit-transform: translate3d(-50%,-50%,0) scale(1.3);
		   -moz-transform: translate3d(-50%,-50%,0) scale(1.3);
			-ms-transform: translate(-50%,-50%) scale(1.3);
				transform: translate3d(-50%,-50%,0) scale(1.3);
	<?php endif; ?>
	}

<?php endif; ?>
