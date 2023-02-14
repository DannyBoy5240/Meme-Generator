<?php if ( ! empty( $settings->align ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content {
	text-align: <?php echo $settings->align; ?>;
}

.fl-node-<?php echo $id; ?> .bc-product__spec-list {
	<?php
	switch ( $settings->align ) {
		case 'center':
			$align = 'center';
			break;
		case 'right':
			$align = 'flex-end';
			break;
		case 'left':
		default:
			$align = 'flex-start';
			break;
	}
	printf( 'justify-content: %s;', $align );
	?>
}
<?php endif; ?>


.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__section-title {
	<?php
		$props = FLBuilderCSS::typography_field_props( $settings->title_text );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			printf( '%s: %s;', $key, $value );
		}
	}

	if ( ! empty( $settings->title_text_color ) ) {
		printf( 'color: #%s;', $settings->title_text_color );
	}
	?>
}

<?php if ( ! empty( $settings->list_item_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__spec-list {
	<?php printf( 'color: #%s;', $settings->list_item_text_color ); ?>
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__spec-list {
	<?php
		$props = FLBuilderCSS::typography_field_props( $settings->list_item_text );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			printf( '%s: %s;', $key, $value );
		}
	}
	?>
}
