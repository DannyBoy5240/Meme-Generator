.fl-node-<?php echo $id; ?> .fl-post-grid-post {

	<?php if ( ! empty( $settings->bg_color ) ) : ?>
	background-color: #<?php echo $settings->bg_color; ?>;
	background-color: rgba(<?php echo implode( ',', FLBuilderColor::hex_to_rgb( $settings->bg_color ) ) ?>, <?php echo $settings->bg_opacity / 100; ?>);
	<?php endif; ?>

	<?php if ( 'default' != $settings->border_type && 'none' != $settings->border_type && ! empty( $settings->border_color ) ) : ?>
	border: <?php echo $settings->border_size; ?>px <?php echo $settings->border_type; ?> #<?php echo $settings->border_color; ?>;
	<?php endif; ?>

	<?php if ( 'none' == $settings->border_type ) : ?>
	border: none;
	<?php endif; ?>

	<?php if ( 'default' != $settings->post_align ) : ?>
	text-align: <?php echo $settings->post_align; ?>;
	<?php endif; ?>
}

.fl-node-<?php echo $id; ?> .fl-post-grid-text {
	padding: <?php echo $settings->post_padding; ?>px;
}

<?php if ( ! empty( $settings->title_color ) ) : ?>
.fl-node-<?php echo $id; ?> h2.fl-post-grid-title a {
	color: #<?php echo $settings->title_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->title_font_size ) ) : ?>
.fl-node-<?php echo $id; ?> h2.fl-post-grid-title a {
	font-size: <?php echo $settings->title_font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->info_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-grid-meta,
.fl-node-<?php echo $id; ?> .fl-post-grid-meta a {
	color: #<?php echo $settings->info_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->info_font_size ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-grid-meta,
.fl-node-<?php echo $id; ?> .fl-post-grid-meta a {
	font-size: <?php echo $settings->info_font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->content_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-grid-content,
.fl-node-<?php echo $id; ?> .fl-post-grid-content p {
	color: #<?php echo $settings->content_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->content_font_size ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-grid-content,
.fl-node-<?php echo $id; ?> .fl-post-grid-content p {
	font-size: <?php echo $settings->content_font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->link_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-grid-content a {
	color: #<?php echo $settings->link_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->link_hover_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-grid-content a:hover {
	color: #<?php echo $settings->link_hover_color; ?>;
}
<?php endif; ?>

<?php if ( $settings->show_image && ! empty( $settings->grid_image_spacing ) ) : ?>
	<?php if ( 'above' == $settings->grid_image_position ) : ?>
	.fl-node-<?php echo $id; ?> .fl-post-grid-image {
		padding: 0 <?php echo $settings->grid_image_spacing; ?>px;
	}
	<?php elseif ( 'above-title' == $settings->grid_image_position ) : ?>
	.fl-node-<?php echo $id; ?> .fl-post-grid-image {
		padding: <?php echo $settings->grid_image_spacing; ?>px <?php echo $settings->grid_image_spacing; ?>px 0 <?php echo $settings->grid_image_spacing; ?>px;
	}
	<?php endif; ?>
<?php endif; ?>
