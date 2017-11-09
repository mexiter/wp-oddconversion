(function( $ ) {
	'use strict';

	/**
	 * AJAX
	 *
	 * Calls an AJAX callback for the site front-end.
	 * Add a button with class ".ajax" to test.
	 */
	$(document).on( 'click', '.qb-btn-convert', function() {
		var qbo_user_odds = $('#qbo_user_odds').val();
	 	var odds_type = $('#odds_type').val();
		$.ajax( {

			// Set the call parameters.
			url    : oddsconverter.ajax_url,
			type   : 'POST',
			data   : {
				action  : 'callback',
				nonce   : oddsconverter.nonce,
				qbo_user_odds : qbo_user_odds,
				odds_type : odds_type,
			},
			//dataType: 'json',

			// When an error is encountered.
			error : function( MLHttpRequest, textStatus, errorThrown ) {
				console.error(errorThrown);
			},

			// When the call succeeds.
			success : function( response, textStatus, XMLHttpRequest ) {
				console.log( response );
			},

			// When the call is complete.
			complete : function( reply, textStatus ) {
				console.log( textStatus );
			}

		} );

	} );





 //Check if default is prevented
 // $('.qb-btn-convert').on("click", function(event) {
	//  console.log('test');
 // 	if(event.isDefaultPrevented()) {
 // 		formError();
 // 		console.log('error');
 //
 // 	} else {
 // 		event.preventDefault();
 // 		submitForm();
 // 		console.log('submited');
 //
 // 	}
 // });

})( jQuery );
