<?php

if ( class_exists( 'Tribe__Tickets__Main' ) ) {
	$tickets    = Tribe__Tickets__Main::instance();
	$view       = $tickets->tickets_view();
	$rsvp       = $tickets->rsvp();
	$override   = $view->intercept_template( '', 'single-event.php' );
	$post_types = (array) tribe_get_option( 'ticket-enabled-post-types', array() );

	if ( ! in_array( get_post_type(), $post_types ) ) {
		return;
	}

	if ( ! empty( $override ) && file_exists( $override ) ) {
		echo '<div id="view-tickets" style="height: 1px;"></div>';
		echo '<a class="fl-view-tickets-form" href="#">' . __( 'View tickets form', 'bb-theme-builder' ) . '</a>';
		include $override;
	} else {
		$view->inject_link_template();
		$rsvp->front_end_tickets_form( '' );
		$rsvp->show_tickets_unavailable_message();

		if ( class_exists( '\TEC\Tickets\Commerce\Module' ) ) {
			$pp = \TEC\Tickets\Commerce\Module::get_instance();
			$pp->front_end_tickets_form( '' );
		}

		if ( class_exists( 'Tribe__Tickets__Commerce__PayPal__Main' ) ) {
			$pp = Tribe__Tickets__Commerce__PayPal__Main::get_instance();
			$pp->front_end_tickets_form( '' );
		}

		if ( class_exists( 'WooCommerce' ) && class_exists( 'Tribe__Tickets_Plus__Commerce__WooCommerce__Main' ) ) {
			$woo = Tribe__Tickets_Plus__Commerce__WooCommerce__Main::get_instance();
			$woo->front_end_tickets_form( '' );
		}

		if ( class_exists( 'Easy_Digital_Downloads' ) && class_exists( 'Tribe__Tickets_Plus__Commerce__EDD__Main' ) ) {
			$edd = Tribe__Tickets_Plus__Commerce__EDD__Main::get_instance();
			$edd->front_end_tickets_form( '' );
		}
	}
}
