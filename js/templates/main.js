/**
 * <%= rc.name %>
 * <%= rc.homepage %>
 *
 * Licensed under the GPLv2+ license.
 */

window.<%= rc.classname %> = window.<%= rc.classname %> || {};

( function( window, document, $, that ) {
	let $c = {};

	that.init = function() {
		that.cache();
		that.bindEvents();
	};

	that.cache = function() {
		$c.window = $( window );
		$c.body   = $( document.body );
	};

	that.bindEvents = function() {
	};

	$( that.init );

}( window, document, <% if ( type === 'Browserify' ) {%>require('jquery')<%} else {%>jQuery<%}%>, window.<%= rc.classname %> ) );
