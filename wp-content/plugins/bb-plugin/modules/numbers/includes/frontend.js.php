<?php

	// set defaults
	$layout       = isset( $settings->layout ) ? $settings->layout : 'default';
	$type         = isset( $settings->number_type ) ? $settings->number_type : 'percent';
	$speed        = ! empty( $settings->animation_speed ) && is_numeric( $settings->animation_speed ) ? $settings->animation_speed * 1000 : 1000;
	$delay        = ! empty( $settings->delay ) && is_numeric( $settings->delay ) && $settings->delay > 0 ? $settings->delay : 0;
	$start_number = isset( $settings->start_number ) && is_numeric( $settings->start_number ) ? $settings->start_number : 0;
	$number       = isset( $settings->number ) && is_numeric( $settings->number ) ? $settings->number : 100;
	$max          = isset( $settings->max_number ) && is_numeric( $settings->max_number ) ? $settings->max_number : $number;

?>

(function($) {

	$(function() {
		var numModule = window.number_module_<?php echo $id; ?>;

		new FLBuilderNumber({
			id: '<?php echo $id; ?>',
			layout: '<?php echo $layout; ?>',
			type: '<?php echo $type; ?>',
			start_number: parseFloat( ( 'undefined' !== typeof numModule ) ? numModule.start_number : <?php echo $start_number; ?> ),
			number: parseFloat( ( 'undefined' !== typeof numModule ) ? numModule.number : <?php echo $number; ?> ),
			max: parseFloat( ( 'undefined' !== typeof numModule ) ? numModule.max : <?php echo $max; ?> ),
			speed: <?php echo $speed; ?>,
			delay: <?php echo $delay; ?>,
		});
	});
})(jQuery);
