<?php if ( ! empty( $settings->events_button_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-event-calendar-cost a.tribe-common-c-btn,
.fl-node-<?php echo $id; ?> .fl-post-module-event-calendar-cost button.tribe-button {
	background: #<?php echo $settings->events_button_bg_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->events_button_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-event-calendar-cost a.tribe-common-c-btn,
.fl-node-<?php echo $id; ?> .fl-post-module-event-calendar-cost button.tribe-button {
	color: #<?php echo $settings->events_button_text_color; ?>;
}
<?php endif; ?>
