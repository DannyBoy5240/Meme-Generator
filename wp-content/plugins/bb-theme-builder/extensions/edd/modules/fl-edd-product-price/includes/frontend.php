<?php
$item_props = '';
if ( version_compare( EDD_VERSION, '3.0', '<' ) ) {
	$item_props = edd_add_schema_microdata() ? ' itemprop="offers" itemscope itemtype="http://schema.org/Offer"' : '';
}
?>
<div<?php echo $item_props; ?>>
	<div itemprop="price" class="edd_price">
	<?php echo FLPageDataEDD::get_product_price(); ?>
	</div>
</div>
<?php

do_action( 'edd_download_after_price' );
