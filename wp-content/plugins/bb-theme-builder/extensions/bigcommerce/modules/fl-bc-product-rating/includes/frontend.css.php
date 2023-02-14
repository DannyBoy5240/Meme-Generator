/* Link Typography */
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__reviews-anchor {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_link_typography );
foreach ( $props as $key => $value ) {
	printf( '%s: %s;', $key, $value );
}
?>
}

/* Link Color */
<?php if ( ! empty( $settings->bc_link_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__reviews-anchor {
	color: <?php printf( '#%s', $settings->bc_link_color ); ?>;
}
<?php endif; ?>

/* Link Hover Color */
<?php if ( ! empty( $settings->bc_link_hover_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__reviews-anchor:hover {
	color: <?php printf( '#%s', $settings->bc_link_hover_color ); ?>;
}
<?php endif; ?>

/* Star Rating Background Color */
<?php if ( ! empty( $settings->bc_star_background ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__rating--bottom {
	color: <?php printf( '#%s', $settings->bc_star_background ); ?>;
}
<?php endif; ?>

/* Star Rating Foreground Color */
<?php if ( ! empty( $settings->bc_star_foreground ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__rating--top {
	color: <?php printf( '#%s', $settings->bc_star_foreground ); ?>;
}
<?php endif; ?>
