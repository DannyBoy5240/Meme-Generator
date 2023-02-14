<?php
if ( is_post_type_archive( 'tribe_events' ) ) {
		echo tribe( \Tribe\Events\Views\V2\Template_Bootstrap::class )->get_view_html();
}
