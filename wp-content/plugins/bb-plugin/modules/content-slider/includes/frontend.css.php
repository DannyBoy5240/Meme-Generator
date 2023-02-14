.fl-node-<?php echo $id; ?> .fl-content-slider-wrapper {
	opacity: 0;
}
.fl-node-<?php echo $id; ?> .fl-content-slider,
.fl-node-<?php echo $id; ?> .fl-slide {
	min-height: <?php echo $settings->height; ?>px;
}
.fl-node-<?php echo $id; ?> .fl-slide-foreground {
	margin: 0 auto;
	max-width: <?php echo $settings->max_width; ?>px;
}
<?php
if ( $settings->arrows ) :
	if ( isset( $settings->arrows_bg_color ) && ! empty( $settings->arrows_bg_color ) ) :
		?>
	.fl-node-<?php echo $id; ?> .fl-content-slider-svg-container {
		background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->arrows_bg_color ); ?>;
		width: 40px;
		height: 40px;

		<?php if ( isset( $settings->arrows_bg_style ) && 'circle' == $settings->arrows_bg_style ) : ?>
		-webkit-border-radius: 50%;
		-moz-border-radius: 50%;
		-ms-border-radius: 50%;
		-o-border-radius: 50%;
		border-radius: 50%;
		<?php endif; ?>
	}
	.fl-node-<?php echo $id; ?> .fl-content-slider-navigation svg {
		height: 100%;
		width: 100%;
		padding: 5px;
	}
		<?php
	endif;

	if ( isset( $settings->arrows_text_color ) && ! empty( $settings->arrows_text_color ) ) :
		?>
	.fl-node-<?php echo $id; ?> .fl-content-slider-navigation path {
		fill: <?php echo FLBuilderColor::hex_or_rgb( $settings->arrows_text_color ); ?>;
	}
		<?php
	endif;
endif;

for ( $i = 0; $i < count( $settings->slides ); $i++ ) {
	// Make sure we have a slide.
	if ( ! is_object( $settings->slides[ $i ] ) ) {
		continue;
	}

	// Slide Settings
	$slide = $settings->slides[ $i ];

	// Slide Background Photo
	if ( ! empty( $slide->bg_photo_src ) ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-bg-photo';
		echo '{';
		echo '   background-image: url("' . $slide->bg_photo_src . '");';
		echo '}';
	}

	// Slide Background Photo Color Overlay
	FLBuilderCSS::rule( array(
		'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-bg-photo:after",
		'enabled'  => 'photo' === $slide->bg_layout,
		'props'    => array(
			'background-color' => $slide->bg_photo_overlay_color,
			'content'          => '" "',
			'display'          => 'block',
			'position'         => 'absolute',
			'top'              => '0',
			'left'             => '0',
			'right'            => '0',
			'bottom'           => '0',
		),
	) );

	// Slide Background Color
	if ( 'color' == $slide->bg_layout && ! empty( $slide->bg_color ) ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i;
		echo ' { background-color: ' . FLBuilderColor::hex_or_rgb( $slide->bg_color ) . '; }';
	}

	// Foreground Photo/Video
	if ( 'photo' == $slide->content_layout || 'video' == $slide->content_layout ) {
		$photo_width = 100 - (int) $slide->text_width;

		// Foreground Photo/Video Width
		if ( 'center' != $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo-wrap ';
			echo '{ width: ' . $photo_width . '%; }';
		}

		// Foreground Photo/Video Margins
		if ( 'left' == $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo ';
			echo '{ margin-right: ' . $slide->text_margin_left . 'px; ';
			echo 'margin-top: ' . $slide->text_margin_top . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		} elseif ( 'center' == $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo ';
			echo '{ margin-left: ' . $slide->text_margin_left . 'px; ';
			echo 'margin-right: ' . $slide->text_margin_right . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		} elseif ( 'right' == $slide->text_position ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-photo ';
			echo '{ margin-left: ' . $slide->text_margin_right . 'px; ';
			echo 'margin-top: ' . $slide->text_margin_top . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		}
	}

	// Title, Text, Button
	if ( 'none' != $slide->content_layout ) {
		// Content wrap width
		FLBuilderCSS::rule( array(
			'selector' => '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content-wrap',
			'media'    => 'min-width:' . $global_settings->responsive_breakpoint . 'px',
			'props'    => array(
				'width' => $slide->text_width . '%',
			),
		) );

		// Margins
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
		echo '{ margin-right: ' . $slide->text_margin_right . 'px; ';
		echo 'margin-left: ' . $slide->text_margin_left . 'px; ';

		// 100% height, don't use top/bottom margins
		if ( '100%' == $slide->text_bg_height && ! empty( $slide->text_bg_color ) ) {

			// Content height
			echo ' min-height: ' . $settings->height . 'px; }';

			// Content wrap height
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content-wrap ';
			echo '{ min-height: ' . $settings->height . 'px; }';
		} else {
			echo 'margin-top: ' . $slide->text_margin_top . 'px; ';
			echo 'margin-bottom: ' . $slide->text_margin_bottom . 'px; }';
		}

		// BG Color
		if ( ! empty( $slide->text_bg_color ) ) {
			echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
			echo '{ background-color: ' . FLBuilderColor::hex_or_rgb( $slide->text_bg_color ) . ';';
			echo 'padding-top: ' . $slide->text_padding_top . 'px;';
			echo 'padding-right: ' . $slide->text_padding_right . 'px;';
			echo 'padding-bottom: ' . $slide->text_padding_bottom . 'px;';
			echo 'padding-left: ' . $slide->text_padding_left . 'px;}';
		}

		// Title
		FLBuilderCSS::rule( array(
			'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-title",
			'props'    => array(
				'color' => $slide->title_color,
			),
		) );

		FLBuilderCSS::typography_field_rule( array(
			'settings'     => $slide,
			'setting_name' => 'title_typography',
			'selector'     => ".fl-node-$id .fl-slide-$i .fl-slide-title",
		) );

		// Text
		FLBuilderCSS::rule( array(
			'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-text, .fl-node-$id .fl-slide-$i .fl-slide-text *",
			'props'    => array(
				'color' => $slide->text_color,
			),
		) );

		FLBuilderCSS::typography_field_rule( array(
			'settings'     => $slide,
			'setting_name' => 'text_typography',
			'selector'     => ".fl-node-$id .fl-slide-$i .fl-slide-text, .fl-node-$id .fl-slide-$i .fl-slide-text *",
		) );

		// Responsive Text Styles
		if ( $global_settings->responsive_enabled ) {
			echo '@media (max-width: ' . $global_settings->responsive_breakpoint . 'px) { ';

			// Responsive Content BG Color
			if ( ! empty( $slide->r_text_bg_color ) ) {
				echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
				echo '{ background-color: ' . FLBuilderColor::hex_or_rgb( $slide->r_text_bg_color ) . '; }';
			} else {
				echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content ';
				echo '{ background-color: transparent; }';
			}

			echo ' }';

			// Responsive Title Color
			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-title",
				'media'    => 'responsive',
				'enabled'  => ! empty( $slide->r_title_color ),
				'props'    => array(
					'color' => $slide->r_title_color,
				),
			) );

			// Responsive Text Color
			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-text, .fl-node-$id .fl-slide-$i .fl-slide-text *",
				'media'    => 'responsive',
				'enabled'  => ! empty( $slide->r_text_color ),
				'props'    => array(
					'color' => $slide->r_text_color,
				),
			) );

		}

		// Button Styles
		if ( 'button' == $slide->cta_type ) :

			if ( ! isset( $slide->btn_style ) ) {
				$slide->btn_style = 'flat';
			}

			FLBuilderCSS::dimension_field_rule( array(
				'settings'     => $slide,
				'unit'         => 'px',
				'setting_name' => 'btn_padding',
				'selector'     => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button",
				'props'        => array(
					'padding-top'    => 'btn_padding_top',
					'padding-right'  => 'btn_padding_right',
					'padding-bottom' => 'btn_padding_bottom',
					'padding-left'   => 'btn_padding_left',
				),
			) );

			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button",
				'enabled'  => ! empty( $slide->btn_bg_color ),
				'props'    => array(
					'background-color' => $slide->btn_bg_color,
				),
			) );

			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button:hover",
				'enabled'  => ! empty( $slide->btn_bg_hover_color ),
				'props'    => array(
					'background-color' => $slide->btn_bg_hover_color,
				),
			) );

			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button span.fl-button-text",
				'enabled'  => ! empty( $slide->btn_text_color ),
				'props'    => array(
					'color' => $slide->btn_text_color,
				),
			) );

			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button:hover span.fl-button-text",
				'enabled'  => ! empty( $slide->btn_text_hover_color ),
				'props'    => array(
					'color' => $slide->btn_text_hover_color,
				),
			) );

			if ( 'gradient' == $slide->btn_style ) {

				$auto_grad_bg_color       = empty( $slide->btn_bg_color ) ? 'a3a3a3' : $slide->btn_bg_color;
				$auto_grad_bg_color_start = FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $auto_grad_bg_color, 30, 'lighten' ) );
				$auto_grad_bg_color_end   = FLBuilderColor::hex_or_rgb( $auto_grad_bg_color );
				$auto_grad_border_color   = FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $auto_grad_bg_color, 12, 'darken' ) );
				FLBuilderCSS::rule( array(
					'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button a.fl-button, .fl-node-$id .fl-slide-$i .fl-slide-cta-button a.fl-button:hover",
					'props'    => array(
						'border'           => "1px solid $auto_grad_border_color",
						'background-image' => "linear-gradient(to bottom, $auto_grad_bg_color_start 0%, $auto_grad_bg_color_end 100%)",
					),
				) );

				$auto_grad_bg_hover_color       = empty( $slide->btn_bg_hover_color ) ? 'a3a3a3' : $slide->btn_bg_hover_color;
				$auto_grad_bg_hover_color_start = FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $auto_grad_bg_hover_color, 30, 'lighten' ) );
				$auto_grad_bg_hover_color_end   = FLBuilderColor::hex_or_rgb( $auto_grad_bg_hover_color );
				$auto_grad_border_hover_color   = FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $auto_grad_bg_hover_color, 12, 'darken' ) );
				FLBuilderCSS::rule( array(
					'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button a.fl-button:hover",
					'props'    => array(
						'border'           => "1px solid $auto_grad_border_hover_color",
						'background-image' => "linear-gradient(to bottom, $auto_grad_bg_hover_color_start 0%, $auto_grad_bg_hover_color_end 100%)",
					),
				) );
			}

			$slide_btn_grad       = is_array( $slide->btn_bg_gradient ) ? $slide->btn_bg_gradient : json_decode( json_encode( $slide->btn_bg_gradient ), true );
			$slide_btn_grad_hover = is_array( $slide->btn_bg_gradient_hover ) ? $slide->btn_bg_gradient_hover : json_decode( json_encode( $slide->btn_bg_gradient_hover ), true );

			// Advanced Background Gradient
			if ( 'adv-gradient' === $slide->btn_style ) :

				$adv_grad_css_rule             = array();
				$adv_grad_css_rule['selector'] = ".fl-node-$id .fl-slide-$i .fl-slide-cta-button a.fl-button, .fl-node-$id .fl-slide-$i .fl-slide-cta-button a.fl-button:hover";

				if ( empty( $slide_btn_grad['colors'][0] ) && empty( $slide_btn_grad['colors'][1] ) ) {

					$adv_grad_bg_color       = 'a3a3a3';
					$adv_grad_bg_color_start = FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $adv_grad_bg_color, 30, 'lighten' ) );
					$adv_grad_bg_color_end   = FLBuilderColor::hex_or_rgb( $adv_grad_bg_color );
					$adv_grad_border_color   = FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $adv_grad_bg_color, 12, 'darken' ) );

					$adv_grad_css_rule['props'] = array(
						'border'           => "1px solid $adv_grad_border_color",
						'background-image' => "linear-gradient(to bottom, $adv_grad_bg_color_start 0%, $adv_grad_bg_color_end 100%)",
					);

				} else {

					$adv_grad_css_rule['props'] = array(
						'background-image' => FLBuilderColor::gradient( $slide_btn_grad ),
					);
				}

				FLBuilderCSS::rule( $adv_grad_css_rule );

				// Advanced Background Gradient Hover
				FLBuilderCSS::rule( array(
					'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button a.fl-button:hover",
					'enabled'  => ! ( empty( $slide_btn_grad_hover['colors'][0] ) && empty( $slide_btn_grad_hover['colors'][1] ) ),
					'props'    => array(
						'background-image' => FLBuilderColor::gradient( $slide_btn_grad_hover ),
					),
				) );

			endif;

			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button",
				'enabled'  => ( isset( $slide->btn_button_transition ) && 'enable' === $slide->btn_button_transition && 'flat' === $slide->btn_style ),
				'props'    => array(
					'transition'         => 'all 0.2s linear',
					'-moz-transition'    => 'all 0.2s linear',
					'-webkit-transition' => 'all 0.2s linear',
					'-o-transition'      => 'all 0.2s linear',
				),
			) );

			FLBuilderCSS::typography_field_rule( array(
				'settings'     => $slide,
				'setting_name' => 'btn_typography',
				'selector'     => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap",
			) );

			FLBuilderCSS::typography_field_rule( array(
				'settings'     => $slide,
				'setting_name' => 'btn_typography',
				'selector'     => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button",
			) );

			FLBuilderCSS::border_field_rule( array(
				'settings'     => $slide,
				'setting_name' => 'btn_border',
				'selector'     => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button, .fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button:hover",
			) );

			FLBuilderCSS::rule( array(
				'enabled'  => ! empty( $slide->btn_border_hover_color ),
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button:hover",
				'props'    => array(
					'border-color' => $slide->btn_border_hover_color,
				),
			) );

			FLBuilderCSS::rule( array(
				'selector' => ".fl-node-$id .fl-slide-$i .fl-slide-cta-button .fl-button-wrap a.fl-button i.fl-button-icon",
				'enabled'  => ! empty( $slide->btn_text_color ),
				'props'    => array(
					'color' => $slide->btn_text_color,
				),
			) );

			if ( $slide->btn_duo_color1 && false !== strpos( $slide->btn_icon, 'fad fa' ) ) :
				?>
				.fl-node-<?php echo $id; ?> .fl-slide-<?php echo $i; ?> .fl-slide-cta-button .fl-button-wrap a.fl-button i.fl-button-icon.fad:before {
					color: <?php echo FLBuilderColor::hex_or_rgb( $slide->btn_duo_color1 ); ?>;
				}
				<?php
			endif;

			if ( $slide->btn_duo_color2 && false !== strpos( $slide->btn_icon, 'fad fa' ) ) :
				?>
				.fl-node-<?php echo $id; ?> .fl-slide-<?php echo $i; ?> .fl-slide-cta-button .fl-button-wrap a.fl-button i.fl-button-icon.fad:after {
					color: <?php echo FLBuilderColor::hex_or_rgb( $slide->btn_duo_color2 ); ?>;
					opacity: 1;
				}
				<?php
			endif;
		endif; // End Button Style
	}

	if ( 'none' === $slide->content_layout ) {
		echo '.fl-node-' . $id . ' .fl-slide-' . $i . ' .fl-slide-content-wrap { ';
		echo 'float: none;';
		echo '}';
	}
}
