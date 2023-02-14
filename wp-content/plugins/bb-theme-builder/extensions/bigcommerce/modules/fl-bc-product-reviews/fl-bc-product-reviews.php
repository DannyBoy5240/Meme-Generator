<?php

/**
 * @class FLBCProductRatingModule
 */
class FLBCProductReviewsModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Product Reviews', 'bb-theme-builder' ),
			'description'     => __( 'Displays customer reviews.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-product-reviews/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-product-reviews/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCProductReviewsModule', array(
	'header'      => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'review_title' => array(
				'title'  => __( 'Reviews Title', 'bb-theme-builder' ),
				'fields' => array(
					'bc_reviews_title_typography' => array(
						'type'       => 'typography',
						'label'      => __( 'Product Reviews Title', 'bb-theme-builder' ),
						'help'       => __( 'Title text for product reviews module', 'bb-theme-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-module-content .bc-product-reviews__title',
							'important' => true,
						),
					),
					'bc_reviews_title_color'      => array(
						'type'       => 'color',
						'label'      => __( 'Product Reviews Title Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-module-content .bc-product-reviews__title',
							'property'  => 'color',
							'important' => true,
						),
					),
				),
			),
			'star_rating'  => FLThemeBuilderBigCommerceSettings::get( 'ratings/star-rating' ),

		),
	),

	'review_form' => array(
		'title'    => __( 'Review Form', 'bb-theme-builder' ),
		'sections' => array(
			'general'       => array(
				'title'  => __( 'Preview Options', 'bb-theme-builder' ),
				'fields' => array(
					'bc_show_review_form' => array(
						'type'    => 'select',
						'label'   => __( 'Show "Write A Review" form in preview', 'bb-theme-builder' ),
						'help'    => __( 'Toggle display of "Write a Review" form.  Note this only applies to preview mode', 'bb-theme-builder' ),
						'default' => 'hide',
						'options' => array(
							'show' => __( 'Show', 'bb-theme-builder' ),
							'hide' => __( 'Hide', 'bb-theme-builder' ),
						),
						'preview' => array(
							'type'     => 'callback',
							'callback' => 'toggleReviewForm',
						),
					),
				),
			),
			'form_title'    => array(
				'title'  => __( 'Form Title', 'bb-theme-builder' ),
				'fields' => array(
					'bc_review_form_title_typography' => array(
						'type'       => 'typography',
						'label'      => __( 'Review Form Title', 'bb-theme-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-module-content .bc-product-review-form__title',
							'important' => true,
						),
					),
					'bc_review_form_title_color'      => array(
						'type'       => 'color',
						'label'      => __( 'Review Form Title Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product-review-form__title',
							'property' => 'color',
						),
					),
				),
			),
			'submit_button' => array(
				'title'  => __( 'Submit Button', 'bb-theme-builder' ),
				'fields' => array(
					'bc_review_form_submit_button_background_color' => array(
						'type'       => 'color',
						'label'      => __( 'Button Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-btn--review',
							'property' => 'background-color',
						),
					),
					'bc_review_form_submit_button_text'   => array(
						'type'       => 'typography',
						'label'      => __( 'Submit Button Text', 'bb-theme-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-module-content .bc-btn--review',
							'important' => true,
						),
					),
					'bc_review_form_submit_button_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Button Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-btn--review',
							'property' => 'color',
						),
					),
					'bc_review_form_submit_button_border' => array(
						'type'    => 'border',
						'label'   => __( 'Submit Button Border', 'bb-theme-builder' ),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-btn--review',
						),
					),
				),
			),
		),
	),
) );
