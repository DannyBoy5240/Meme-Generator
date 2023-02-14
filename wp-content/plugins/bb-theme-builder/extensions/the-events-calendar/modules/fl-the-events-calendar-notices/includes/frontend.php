<?php

if ( FLBuilderModel::is_builder_active() ) {
	?>
	<div class="tribe-events-notices">
		<ul>
			<li><?php _e( 'Event notices will appear here.', 'bb-theme-builder' ); ?></li>
		</ul>
	</div>
	<?php

} else {

	$events_label = tribe_get_event_label_singular_lowercase();

	if ( ! tribe_is_showing_all() && tribe_is_past_event() ) {
		/* translators: %s: event label */
		Tribe__Notices::set_notice( 'event-past', sprintf( esc_html__( 'This %s has passed.', 'bb-theme-builder' ), $events_label ) );
	}

	$notices = tribe_the_notices( false );
	if ( ! empty( $notices ) ) {
		echo $notices;
	} else {
		?>
		<style>
		.fl-node-<?php echo $id; ?> {
			display:none;
		}
		</style>
		<?php
	}
}
