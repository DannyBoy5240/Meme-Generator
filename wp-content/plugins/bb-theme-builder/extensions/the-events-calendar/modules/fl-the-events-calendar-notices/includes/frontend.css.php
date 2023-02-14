<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-events-notices {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-events-notices {
	background-color: #<?php echo $settings->bg_color; ?>;
	border-color: #<?php echo FLBuilderColor::adjust_brightness( $settings->bg_color, 25, 'darken' ); ?>;
}
<?php endif; ?>
