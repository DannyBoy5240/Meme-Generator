<?php

if ( is_tax( 'tribe_events_cat' ) ) {
	echo term_description( get_queried_object_id(), 'tribe_events_cat' );
} else {
	echo get_the_archive_description();
}
