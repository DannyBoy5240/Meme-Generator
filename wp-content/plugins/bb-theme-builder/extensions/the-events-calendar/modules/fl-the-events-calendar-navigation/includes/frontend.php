<?php

$events_label_singular = tribe_get_event_label_singular();
?>
<div id="tribe-events-footer">
	<?php /* translators: %s: Event Label */ ?>
	<h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'bb-theme-builder' ), $events_label_singular ); ?></h3>
	<ul class="tribe-events-sub-nav">
		<?php if ( tribe_is_event() && is_single() ) : ?>
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( $settings->previous ); ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( $settings->next ); ?></li>
		<?php endif; ?>
	</ul>
</div>
