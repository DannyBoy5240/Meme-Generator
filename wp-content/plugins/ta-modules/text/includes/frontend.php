<div class="fl-rich-text ta-rich-text ta-text-align-<?php echo $settings->text_align; ?> ta-text-width-<?php echo $settings->text_width; ?> ta-text-style-<?php echo $settings->text_style; ?> ta-text-size-<?php echo $settings->text_size; ?> ta-text-color-<?php echo $settings->text_color; ?>">
	<?php 

  global $wp_embed;

	echo wpautop( $wp_embed->autoembed( $settings->text ) );

	?>
</div>
