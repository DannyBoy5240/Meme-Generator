<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> form.edd_download_purchase_form .edd-submit,
.fl-node-<?php echo $id; ?> form.edd_download_purchase_form .edd-submit:hover,
.fl-node-<?php echo $id; ?> form.edd_download_purchase_form .edd-submit:focus {
	background: #<?php echo $settings->bg_color; ?>;
	border-color: #<?php echo FLBuilderColor::adjust_brightness( $settings->bg_color, 12, 'darken' ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> form.edd_download_purchase_form .edd-submit,
.fl-node-<?php echo $id; ?> form.edd_download_purchase_form .edd-submit:hover,
.fl-node-<?php echo $id; ?> form.edd_download_purchase_form .edd-submit:focus {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>
