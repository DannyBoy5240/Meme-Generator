<?php

$product = FLPageDataBigCommerce::get_product();
$content = FLPageDataBigCommerce::get_product_price();

if ( $product->on_sale() ) {
	echo '<div class="on_sale">';
	echo $content;
	echo '</div>';
} else {
	echo $content;
}


