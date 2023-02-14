<?php

use BigCommerce\Customizer\Sections\Buttons;
use BigCommerce\Post_Types\Product\Product;
use BigCommerce\Templates\Product_Brand;
use BigCommerce\Templates\Product_Card;
use BigCommerce\Templates\Product_Description;
use BigCommerce\Templates\Product_Form;
use BigCommerce\Templates\Product_Gallery;
use BigCommerce\Templates\Product_Price;
use BigCommerce\Templates\Product_Rating;
use BigCommerce\Templates\Product_Single;
use BigCommerce\Templates\Product_Specs;
use BigCommerce\Templates\Product_Title;
use BigCommerce\Templates\View_Product_Button;


/**
 * Handles logic for page data BigCommerce properties.
 *
 */
final class FLPageDataBigCommerce {

	/**
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'bigcommerce', array(
			'label' => __( 'BigCommerce', 'bb-theme-builder' ),
		) );
	}

	/**
	 * Construct a product instance from the current Post ID
	 *
	 * @return Product
	 */
	static public function get_product() {
		return new Product( get_the_ID() );
	}

	/**
	 * @return string
	 */
	static public function get_product_card() {
		$component = Product_Card::factory( array(
			Product_Card::PRODUCT => static::get_product(),
		) );

		return $component->render();
	}

	/**
	 * Renders a grid of related products
	 *
	 * @return mixed
	 */
	static public function get_related_products() {

		$component = Product_Single::factory( array(
			Product_Single::PRODUCT => static::get_product(),
		) );

		$subcomponents = $component->get_data();

		return $subcomponents[ Product_Single::RELATED ];
	}

	/**
	 * @return mixed
	 */
	static public function get_product_reviews() {
		$component = Product_Single::factory( array(
			Product_Single::PRODUCT => static::get_product(),
		) );

		$subcomponents = @$component->get_data(); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

		return $subcomponents[ Product_Single::REVIEWS ];
	}

	/**
	 * @return mixed
	 */
	static public function get_product_specs() {
		$component = Product_Specs::factory( array(
			Product_Specs::PRODUCT => static::get_product(),
		) );

		return $component->render();
	}

	/**
	 * Render product rating with stars
	 *
	 * @return string
	 */
	static public function get_product_rating_stars_html() {
		$product      = static::get_product();
		$product_link = get_the_permalink( $product->post_id() );

		// The anchor links to the product review list on the page (if it exists)
		$product_rating_link = sprintf( '%s#bc-single-product__reviews', $product_link );

		$component = Product_Rating::factory( array(
			Product_Rating::PRODUCT => $product,
			Product_Rating::LINK    => $product_rating_link,
		) );

		return $component->render();
	}

	/**
	 * Product rating - $x out of 5 stars
	 * @return float|int
	 */
	static public function get_product_rating_stars() {
		$product = static::get_product();
		$sum     = $product->reviews_rating_sum;
		$count   = $product->reviews_count;

		if ( $count < 1 ) {
			return 0;
		}

		return $sum / $count;
	}

	/**
	 * Product rating as percentage
	 *
	 * @return int
	 */
	static public function get_product_rating_percentage() {

		$product = static::get_product();
		$sum     = $product->reviews_rating_sum;
		$count   = $product->reviews_count;

		if ( $count < 1 ) {
			return 0;
		}

		return (int) ( $sum / $count * 20 );
	}

	/**
	 * Templatized product title
	 *
	 * @return string
	 */
	static public function get_product_title() {

		$component = Product_Title::factory( array(
			Product_Title::PRODUCT        => static::get_product(),
			Product_Title::USE_PERMALINK  => false,
			Product_Title::SHOW_INVENTORY => '',
		) );

		return $component->render();
	}

	/**
	 * Get product title as string.
	 * @return string
	 */
	static public function get_product_title_string() {
		return get_the_title();
	}


	/**
	 * @return mixed
	 */
	static public function get_cart_form( $show_options = true ) {

		$product = static::get_product();

		if ( @$product->out_of_stock() ) { // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			return false;
		}

		if ( $show_options ) {
			$component = Product_Form::factory( array(
				Product_Form::PRODUCT      => $product,
				Product_Form::SHOW_OPTIONS => true,
			) );
		} else {
			if ( $product->has_options() ) {
				$component = View_Product_Button::factory( array(
					View_Product_Button::PRODUCT => $product,
					View_Product_Button::LABEL   => get_option( Buttons::CHOOSE_OPTIONS, __( 'Choose Options', 'bb-theme-builder' ) ),
				) );
			} else {
				$component = Product_Form::factory( array(
					Product_Form::PRODUCT      => $product,
					Product_Form::SHOW_OPTIONS => false,
				) );
			}
		}

		$html  = '<div class="bc-product-card bc-product-card--single" data-js="bc-product-single">';
		$html .= @$component->render(); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		$html .= '</div>';

		return $html;
	}

	/**
	 * Renders a photo gallery component of product images.
	 * This template produces its own javascript and CSS
	 *
	 * @return string
	 */
	static public function get_product_images_component() {
		$component = Product_Gallery::factory( array(
			Product_Gallery::PRODUCT => static::get_product(),
		) );

		return $component->render();
	}

	/**
	 * Get a list of image id's for product.
	 * @return int[]
	 */
	static public function get_product_images() {
		return static::get_product()->get_gallery_ids();
	}

	/**
	 * Renders default price and/or current calculated price
	 * based on whether the product is on sale, or a coupon is applied
	 *
	 * @return string
	 */
	static public function get_product_price() {

		$component = Product_Price::factory( array(
			Product_Price::PRODUCT => static::get_product(),
		) );

		return $component->render();
	}

	/**
	 * @return mixed|string
	 */
	static public function get_product_original_price() {
		return static::get_product()->price_range();
	}

	/**
	 * @return mixed|string
	 */
	static public function get_product_sale_price() {
		return static::get_product()->calculated_price_range();
	}

	/**
	 * Render product description. This method may be redundant as
	 * this data is also just the post body.
	 *
	 * @return mixed
	 */
	static public function get_product_description() {

		$component = Product_Description::factory( array(
			Product_Description::PRODUCT => static::get_product(),
		) );

		return $component->render();
	}


	/**
	 * Render product brand image
	 *
	 * @return mixed
	 */
	static public function get_product_brand() {

		$component = Product_Brand::factory( array(
			Product_Brand::PRODUCT => static::get_product(),
		) );

		return $component->render();
	}

}

FLPageDataBigCommerce::init();
