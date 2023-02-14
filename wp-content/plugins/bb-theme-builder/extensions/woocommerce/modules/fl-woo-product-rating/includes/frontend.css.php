.fl-node-<?php echo $id; ?> .fl-module-content {

	text-align: <?php echo $settings->align; ?>;

	<?php if ( ! empty( $settings->font_size ) ) : ?>
	font-size: <?php echo $settings->font_size; ?>px;
	<?php endif; ?>
}

<?php if ( ! empty( $settings->fg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content a.woocommerce-review-link,
.fl-node-<?php echo $id; ?> .fl-module-content .star-rating span:before {
	color: #<?php echo $settings->fg_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .star-rating:before {
	color: #<?php echo $settings->bg_color; ?>;
}
<?php endif; ?>
