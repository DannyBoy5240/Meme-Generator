<?php
$post_spacing            = floatval( $settings->post_spacing );
$post_width              = floatval( $settings->post_width );
$post_columns            = $module->get_columns_count();
$post_columns_large      = $module->get_columns_count( 'large' );
$post_columns_medium     = $module->get_columns_count( 'medium' );
$post_columns_responsive = $module->get_columns_count( 'responsive' );

if ( 'grid' == $settings->layout ) : ?>
.fl-node-<?php echo $id; ?> <?php echo $module->get_posts_container(); ?>.fl-post-grid-post {
	margin-bottom: <?php echo $post_spacing; ?>px;
	width: <?php echo $post_width; ?>px;
}
.fl-node-<?php echo $id; ?> .fl-post-grid-sizer {
	width: <?php echo $post_width; ?>px;
}
@media screen and (max-width: <?php echo $post_width + $post_spacing; ?>px) {
	.fl-node-<?php echo $id; ?> .fl-post-grid,
	.fl-node-<?php echo $id; ?> .fl-post-grid-post,
	.fl-node-<?php echo $id; ?> .fl-post-grid-sizer {
		width: 100% !important;
	}
}
<?php elseif ( 'columns' == $settings->layout ) : ?>

.fl-node-<?php echo $id; ?> .fl-post-grid {
	margin-left: -<?php echo $post_spacing / 2; ?>px;
	margin-right: -<?php echo $post_spacing / 2; ?>px;
}
.fl-node-<?php echo $id; ?> .fl-post-column {
	padding-bottom: <?php echo $post_spacing; ?>px;
	padding-left: <?php echo $post_spacing / 2; ?>px;
	padding-right: <?php echo $post_spacing / 2; ?>px;
	width: <?php echo 100 / $post_columns; ?>%;
}
.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $post_columns; ?>n + 1) {
	clear: both;
}
	<?php if ( ! empty( $post_columns_large ) ) : ?>
	@media screen and (max-width: <?php echo $global_settings->large_breakpoint; ?>px) {
		.fl-node-<?php echo $id; ?> .fl-post-column {
			width: <?php echo 100 / $post_columns_large; ?>%;
		}
		.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $post_columns; ?>n + 1) {
			clear: none;
		}
		.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $post_columns_large; ?>n + 1) {
			clear: both;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $post_columns_medium ) ) : ?>
	@media screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
		.fl-node-<?php echo $id; ?> .fl-post-column {
			width: <?php echo 100 / $post_columns_medium; ?>%;
		}
		.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $post_columns_large; ?>n + 1) {
			clear: none;
		}
		.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $post_columns_medium; ?>n + 1) {
			clear: both;
		}
	}
	<?php endif; ?>
	<?php if ( ! empty( $post_columns_responsive ) ) : ?>
	@media screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
		.fl-node-<?php echo $id; ?> .fl-post-column {
			width: <?php echo 100 / $post_columns_responsive; ?>%;
		}
		.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $post_columns_medium; ?>n + 1) {
			clear: none;
		}
		.fl-node-<?php echo $id; ?> .fl-post-column:nth-child(<?php echo $post_columns_responsive; ?>n + 1) {
			clear: both;
		}
	}
	<?php endif; ?>
<?php endif; ?>
