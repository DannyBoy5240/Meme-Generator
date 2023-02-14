<?php if ( ! empty( $settings->fg_color ) ) : // Foreground Color
	$placeholder_color = 'rgba(' . implode( ',', FLBuilderColor::hex_to_rgb( $settings->fg_color ) ) . ', .5);';
	?>
.fl-node-<?php echo $id; ?> #tribe-events-bar,
.fl-node-<?php echo $id; ?> #tribe-events-bar input,
.fl-node-<?php echo $id; ?> #tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option a,
.fl-node-<?php echo $id; ?> #tribe-bar-form .tribe-bar-submit input[type=submit],
.fl-node-<?php echo $id; ?> .tribe-events-filters-content *,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper .tribe_events_slider_val,
.fl-node-<?php echo $id; ?> .tribe-events-calendar thead th,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> #tribe-events-content table.tribe-events-calendar .type-tribe_events.tribe-event-featured,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-present.mobile-active:hover,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present.mobile-active,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.mobile-active,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar .mobile-active:hover,
.fl-node-<?php echo $id; ?> .tribe-events-calendar .mobile-active div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> .tribe-events-calendar .mobile-active div[id*=tribe-events-daynum-] a,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present.mobile-active div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present.mobile-active div[id*=tribe-events-daynum-] a,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*=tribe-events-daynum-] a,
.fl-node-<?php echo $id; ?> .tribe-grid-header,
.fl-node-<?php echo $id; ?> .tribe-grid-body .tribe-event-featured.tribe-events-week-hourly-single,
.fl-node-<?php echo $id; ?> .tribe-grid-allday .tribe-event-featured.tribe-events-week-allday-single,
.fl-node-<?php echo $id; ?> .tribe-mobile-day-date,
.fl-node-<?php echo $id; ?> .tribe-events-day .tribe-events-day-time-slot h5,
.fl-node-<?php echo $id; ?> .tribe-events-list #tribe-events-day.tribe-events-loop .tribe-event-featured,
.fl-node-<?php echo $id; ?> .tribe-events-list .tribe-events-event-cost span,
.fl-node-<?php echo $id; ?> .tribe-events-list .tribe-events-loop .tribe-event-featured,
.fl-node-<?php echo $id; ?> .type-tribe_events.tribe-events-photo-event.tribe-event-featured .tribe-events-photo-event-wrap,
.fl-node-<?php echo $id; ?> #tribe-events .tribe-events-ical.tribe-events-button {
	color: #<?php echo $settings->fg_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe-events-bar input,
.fl-node-<?php echo $id; ?> .tribe-events-loop .tribe-event-featured .tribe-events-event-meta,
.fl-node-<?php echo $id; ?> .tribe-events-list .tribe-event-featured .tribe-events-venue-details {
	border-color: <?php echo $placeholder_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe_events_filter_control #tribe_events_filters_toggle,
.fl-node-<?php echo $id; ?> #tribe_events_filter_control #tribe_events_filters_reset {
	border: none;
	border-top: 1px solid <?php echo $placeholder_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe-events-bar input:focus {
	border-bottom: 1px dashed <?php echo $placeholder_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe-events-bar input::-webkit-input-placeholder {
	color: <?php echo $placeholder_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe-events-bar input::-moz-placeholder {
	color: <?php echo $placeholder_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe-events-bar input:-ms-input-placeholder {
	color: <?php echo $placeholder_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe-events-bar input:-moz-placeholder {
	color: <?php echo $placeholder_color; ?>;
}

@media only screen and (max-width: 767px) {

	.fl-node-<?php echo $id; ?> #tribe_events_filter_control #tribe_events_filters_toggle,
	.fl-node-<?php echo $id; ?> .tribe-events-sub-nav li a,
	.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present {
		color: #<?php echo $settings->fg_color; ?>;
	}
}
@media only screen and (min-width: 767px) {

	.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper.tribe-events-filters-horizontal,
	.fl-node-<?php echo $id; ?> .tribe-filters-closed #tribe_events_filters_wrapper.tribe-events-filters-horizontal {
		color: #<?php echo $settings->fg_color; ?>;
	}
}
<?php endif; ?>

<?php if ( ! empty( $settings->bg_color ) ) : // Background Color ?>
.fl-node-<?php echo $id; ?> #tribe-bar-form,
.fl-node-<?php echo $id; ?> #tribe-bar-collapse-toggle,
.fl-node-<?php echo $id; ?> #tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option a:hover,
.fl-node-<?php echo $id; ?> .tribe-events-filters-content,
.fl-node-<?php echo $id; ?> .tribe-events-filter-group li,
.fl-node-<?php echo $id; ?> .tribe-events-filter-group li:hover,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper.tribe-events-filters-vertical .tribe-events-filter-group li:hover,
.fl-node-<?php echo $id; ?> .tribe-events-filter-group.tribe-events-filter-select,
.fl-node-<?php echo $id; ?> .tribe-events-filter-group.tribe-events-filter-range,
.fl-node-<?php echo $id; ?> #tribe_events_filter_control #tribe_events_filters_reset,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper.tribe-events-filters-horizontal,
.fl-node-<?php echo $id; ?> #tribe_events .tribe-filters-closed #tribe_events_filters_wrapper.tribe-events-filters-horizontal,
.fl-node-<?php echo $id; ?> .tribe-events-filters-horizontal .tribe-events-filter-group,
.fl-node-<?php echo $id; ?> .tribe-events-calendar thead th,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> #tribe-events-content table.tribe-events-calendar .type-tribe_events.tribe-event-featured,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-present.mobile-active:hover,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present.mobile-active,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.mobile-active,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar .mobile-active:hover,
.fl-node-<?php echo $id; ?> .tribe-events-calendar .mobile-active div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> .tribe-events-calendar .mobile-active div[id*=tribe-events-daynum-] a,
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present.mobile-active div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present.mobile-active div[id*=tribe-events-daynum-] a,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active,
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*=tribe-events-daynum-],
.fl-node-<?php echo $id; ?> #tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*=tribe-events-daynum-] a,
.fl-node-<?php echo $id; ?> .tribe-grid-header,
.fl-node-<?php echo $id; ?> .tribe-grid-body .tribe-event-featured.tribe-events-week-hourly-single:hover,
.fl-node-<?php echo $id; ?> .tribe-grid-allday .tribe-event-featured.tribe-events-week-allday-single,
.fl-node-<?php echo $id; ?> .tribe-mobile-day-date,
.fl-node-<?php echo $id; ?> .tribe-events-day .tribe-events-day-time-slot h5,
.fl-node-<?php echo $id; ?> .tribe-events-list #tribe-events-day.tribe-events-loop .tribe-event-featured,
.fl-node-<?php echo $id; ?> .tribe-events-list .tribe-events-event-cost span,
.fl-node-<?php echo $id; ?> .tribe-events-list .tribe-events-loop .tribe-event-featured,
.fl-node-<?php echo $id; ?> .type-tribe_events.tribe-events-photo-event.tribe-event-featured .tribe-events-photo-event-wrap,
.fl-node-<?php echo $id; ?> .type-tribe_events.tribe-events-photo-event.tribe-event-featured .tribe-events-photo-event-wrap:hover,
.fl-node-<?php echo $id; ?> #tribe-events .tribe-events-ical.tribe-events-button {
	background-color: #<?php echo $settings->bg_color; ?>;
}
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper label.tribe-events-filters-label,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper .tribe-events-filters-group-heading,
.fl-node-<?php echo $id; ?> .tribe-events-filter-group,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper .tribe-events-filter-group label,
.fl-node-<?php echo $id; ?> .tribe-events-grid .tribe-grid-header .tribe-grid-content-wrap .column,
.fl-node-<?php echo $id; ?> .tribe-grid-body .tribe-event-featured.tribe-events-week-hourly-single,
.fl-node-<?php echo $id; ?> .tribe-events-list .tribe-events-event-cost span {
	border-color: #<?php echo $settings->bg_color; ?>;
}
.fl-node-<?php echo $id; ?> .tribe-grid-body .tribe-event-featured.tribe-events-week-hourly-single {
	background-color: rgba(<?php echo implode( ',', FLBuilderColor::hex_to_rgb( $settings->bg_color ) ); ?>, .7);
}
.fl-node-<?php echo $id; ?> .tribe-bar-views-inner,
.fl-node-<?php echo $id; ?> #tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option a,
.fl-node-<?php echo $id; ?> #tribe-bar-form .tribe-bar-submit input[type=submit],
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper .tribe-events-filters-group-heading,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper .tribe-events-filters-group-heading:hover,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper .closed .tribe-events-filters-group-heading:hover,
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper input[type=submit],
.fl-node-<?php echo $id; ?> #tribe_events_filters_wrapper input[type=submit]:hover,
.fl-node-<?php echo $id; ?> .tribe-events-grid .tribe-grid-header .tribe-week-today {
	background-color: #<?php echo FLBuilderColor::adjust_brightness( $settings->bg_color, 25, 'darken' ); ?>;
}

@media only screen and (max-width: 767px) {

	.fl-node-<?php echo $id; ?> #tribe_events_filter_control #tribe_events_filters_toggle,
	.fl-node-<?php echo $id; ?> .tribe-events-sub-nav li a,
	.fl-node-<?php echo $id; ?> .tribe-events-calendar td.tribe-events-present {
		background-color: #<?php echo $settings->bg_color; ?>;
	}
}
@media only screen and (min-width: 767px) {

	.fl-node-<?php echo $id; ?> #tribe-events #tribe_events_filters_wrapper.tribe-events-filters-horizontal,
	.fl-node-<?php echo $id; ?> #tribe-events .tribe-filters-closed #tribe_events_filters_wrapper.tribe-events-filters-horizontal {
		background-color: #<?php echo $settings->bg_color; ?>;
	}
}
<?php endif; ?>

<?php if ( ! empty( $settings->notice_text_color ) ) : // Notice Text Color ?>
.fl-node-<?php echo $id; ?> .tribe-events-notices {
	color: #<?php echo $settings->notice_text_color; ?>;
	text-shadow:none;
}
<?php endif; ?>

<?php if ( ! empty( $settings->notice_bg_color ) ) : // Notice Background Color ?>
.fl-node-<?php echo $id; ?> .tribe-events-notices {
	background-color: #<?php echo $settings->notice_bg_color; ?>;
	border-color: #<?php echo FLBuilderColor::adjust_brightness( $settings->notice_bg_color, 25, 'darken' ); ?>;
}
<?php endif; ?>
<?php $icons = ( ! apply_filters( 'fl_enable_fa5_pro', false ) ) ? 'Free' : 'Pro'; ?>
.fl-node-<?php echo $id; ?> .tribe-bar-views-list a span:before {
	font-family: "Font Awesome 5 <?php echo $icons; ?>";
}
