<div class="ta-button-module ta-button-align-<?php echo $settings->align ?> ta-button-style-<?php echo $settings->color ?>">
	<a href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>" class="ta-button">
		<?php if ( ! empty( $settings->text ) ) : ?>
		<span class="ta-button-text"><?php echo $settings->text; ?></span>
		<?php endif; ?>
	</a>
</div>
