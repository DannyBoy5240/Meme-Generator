<?php if ( 'grid' == $settings->layout ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-grid-post {
	margin-bottom: <?php echo $settings->post_spacing; ?>px;
	width: <?php echo $settings->post_width; ?>px;
}
.fl-node-<?php echo $id; ?> .fl-post-grid-sizer {
	width: <?php echo $settings->post_width; ?>px;
}
@media screen and (max-width: <?php echo $settings->post_width + $settings->post_spacing; ?>px) {
	.fl-node-<?php echo $id; ?> .fl-post-grid,
	.fl-node-<?php echo $id; ?> .fl-post-grid-post,
	.fl-node-<?php echo $id; ?> .fl-post-grid-sizer {
		width: 100% !important;
	}
}
<?php elseif ( 'columns' == $settings->layout ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content {
	overflow: hidden;
}
.fl-node-<?php echo $id; ?> .fl-post-grid {
	margin-left: -<?php echo $settings->post_spacing / 2; ?>px;
	margin-right: -<?php echo $settings->post_spacing / 2; ?>px;
}
.fl-node-<?php echo $id; ?> .fl-post-column {
	padding-bottom: <?php echo $settings->post_spacing; ?>px;
	padding-left: <?php echo $settings->post_spacing / 2; ?>px;
	padding-right: <?php echo $settings->post_spacing / 2; ?>px;
	width: <?php echo 100 / $settings->post_columns; ?>%;
}
.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $settings->post_columns; ?>n + 1) {
	clear: both;
}
@media screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .fl-post-column {
		width: <?php echo 100 / $settings->post_columns_medium; ?>%;
	}
	.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $settings->post_columns; ?>n + 1) {
		clear: none;
	}
	.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $settings->post_columns_medium; ?>n + 1) {
		clear: both;
	}
}
@media screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .fl-post-column {
		width: <?php echo 100 / $settings->post_columns_responsive; ?>%;
	}
	.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $settings->post_columns_medium; ?>n + 1) {
		clear: none;
	}
	.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $settings->post_columns_responsive; ?>n + 1) {
		clear: both;
	}
}
<?php endif; ?>
