<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-tickets-rsvp .tribe-events-tickets,
.fl-node-<?php echo $id; ?> .tribe-common,
.fl-node-<?php echo $id; ?> .tribe-modal__content form {
	background: #<?php echo $settings->bg_color; ?>;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> form.tribe-tickets{
	max-width: 100%;
}
.fl-node-<?php echo $id; ?> .tribe-modal__content form {
	padding: 20px;
}

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-tickets-rsvp .tribe-events-tickets *:not(input):not(button):not(select),
.fl-node-<?php echo $id; ?> .tribe-common *:not(input):not(button):not(select),
.fl-node-<?php echo $id; ?> .tribe-common .tribe-tickets-quantity,
.fl-node-<?php echo $id; ?> .tribe-common .screen-reader-text,
.fl-node-<?php echo $id; ?> .tribe-common button.tribe-tickets__item__quantity__add, 
.fl-node-<?php echo $id; ?> .tribe-common button.tribe-tickets__item__quantity__remove,
.fl-node-<?php echo $id; ?> .tribe-common button.tribe-tickets__item__quantity__add:hover, 
.fl-node-<?php echo $id; ?> .tribe-common button.tribe-tickets__item__quantity__remove:hover {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->sep_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-events-tickets-rsvp tr.tribe-event-tickets-plus-meta,
.fl-node-<?php echo $id; ?> .tribe-events-tickets-rsvp tr.tribe-tickets-meta-row,
.fl-node-<?php echo $id; ?> .tribe-events-tickets-rsvp tr:last-child,
.fl-node-<?php echo $id; ?> .tribe-common .tribe-tickets__item,
.fl-node-<?php echo $id; ?> .tribe-common .tribe-tickets__footer {
	border-top: 1px solid #<?php echo $settings->sep_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->btn_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-common .tribe-tickets__footer button,
.fl-node-<?php echo $id; ?> button.tribe-button {
	background: #<?php echo $settings->btn_bg_color; ?>;
	border: 1px solid #<?php echo FLBuilderColor::adjust_brightness( $settings->btn_bg_color, 12, 'darken' ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->btn_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-common .tribe-tickets__footer button,
.fl-node-<?php echo $id; ?> button.tribe-button {
	color: #<?php echo $settings->btn_text_color; ?>;
}
<?php endif; ?>


<?php if ( ! empty( $settings->disabled_btn_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-common .tribe-tickets__footer button[disabled=disabled] {
	background: #<?php echo $settings->disabled_btn_bg_color; ?>;
	border: 1px solid #<?php echo FLBuilderColor::adjust_brightness( $settings->disabled_btn_bg_color, 12, 'darken' ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->disabled_btn_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-common .tribe-tickets__footer button[disabled=disabled] {
	color: #<?php echo $settings->disabled_btn_text_color; ?>;
}
<?php endif; ?>
