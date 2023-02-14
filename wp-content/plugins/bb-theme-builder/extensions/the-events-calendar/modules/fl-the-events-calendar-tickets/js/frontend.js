( function( $ ) {

	var Tickets = {

		init: function() {
			$( '.fl-module .tribe-link-tickets-message a' ).on( 'click', this.viewTickets );
			$( '.fl-module .fl-view-tickets-form' ).on( 'click', this.viewTicketsForm );
		},

		viewTickets: function( e ) {
			e.preventDefault();
			window.location.href = $( this ).attr( 'href' ) + '#view-tickets';
		},

		viewTicketsForm: function( e ) {
			e.preventDefault();
			window.location.href = window.location.href.split( '/tickets/' ).shift();
		}
	};

	$( function() { Tickets.init(); } );

} )( jQuery );
