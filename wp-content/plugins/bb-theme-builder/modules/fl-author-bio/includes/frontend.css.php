<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content {
	background: #<?php echo $settings->bg_color; ?>;
	padding: 30px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content,
.fl-node-<?php echo $id; ?> .fl-module-content h3 {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>
