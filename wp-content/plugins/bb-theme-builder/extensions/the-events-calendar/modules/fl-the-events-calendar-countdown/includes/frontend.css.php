<?php

$align          = $settings->align;
$time_alignment = $align;
if ( 'left' === $align ) {
	$time_alignment = 'flex-start';
} elseif ( 'right' === $align ) {
	$time_alignment = 'flex-end';
}

?>

.fl-node-<?php echo $id; ?> .tribe-events-widget-countdown {
	text-align: <?php echo $settings->align; ?>;
}
.fl-node-<?php echo $id; ?> time {
	justify-content: <?php echo $time_alignment; ?>;
}
