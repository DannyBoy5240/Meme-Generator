.fl-node-<?php echo $id; ?> .fl-separator {
	border-top-width: <?php echo $settings->height; ?>px;
	border-top-style: <?php echo $settings->style; ?>;
	border-top-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->color ); ?>;
	max-width: <?php echo $settings->width . $settings->width_unit; ?>;
	margin: <?php echo $settings->align; ?>;
}

<?php if ( $global_settings->responsive_enabled ) { ?>
	<?php if ( ! empty( $settings->height_large ) || ! empty( $settings->width_large ) || ! empty( $settings->align_large ) ) { ?>
	@media (max-width: <?php echo $global_settings->large_breakpoint; ?>px) {
		.fl-node-<?php echo $id; ?> .fl-separator {
			<?php if ( ! empty( $settings->height_large ) ) { ?>
				border-top-width: <?php echo $settings->height_large; ?>px;
			<?php } ?>
			<?php if ( ! empty( $settings->width_large ) ) { ?>
				max-width: <?php echo $settings->width_large . $settings->width_large_unit; ?>;
			<?php } ?>
			<?php if ( ! empty( $settings->align_large ) ) { ?>
				margin: <?php echo $settings->align_large; ?>;
			<?php } ?>
		}
	}
	<?php } ?>
	<?php if ( ! empty( $settings->height_medium ) || ! empty( $settings->width_medium ) || ! empty( $settings->align_medium ) ) { ?>
	@media (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
		.fl-node-<?php echo $id; ?> .fl-separator {
			<?php if ( ! empty( $settings->height_medium ) ) { ?>
				border-top-width: <?php echo $settings->height_medium; ?>px;
			<?php } ?>
			<?php if ( ! empty( $settings->width_medium ) ) { ?>
				max-width: <?php echo $settings->width_medium . $settings->width_medium_unit; ?>;
			<?php } ?>
			<?php if ( ! empty( $settings->align_medium ) ) { ?>
				margin: <?php echo $settings->align_medium; ?>;
			<?php } ?>
		}
	}
	<?php } ?>
	<?php if ( ! empty( $settings->height_responsive ) || ! empty( $settings->width_responsive ) || ! empty( $settings->align_responsive ) ) { ?>
	@media (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
		.fl-node-<?php echo $id; ?> .fl-separator {
			<?php if ( ! empty( $settings->height_responsive ) ) { ?>
				border-top-width: <?php echo $settings->height_responsive; ?>px;
			<?php } ?>
			<?php if ( ! empty( $settings->width_responsive ) ) { ?>
				max-width: <?php echo $settings->width_responsive . $settings->width_responsive_unit; ?>;
			<?php } ?>
			<?php if ( ! empty( $settings->align_responsive ) ) { ?>
				margin: <?php echo $settings->align_responsive; ?>;
			<?php } ?>
		}
	}
	<?php } ?>
<?php } ?>
