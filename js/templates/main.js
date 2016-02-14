/**
 * <%= rc.name %>
 * <%= rc.homepage %>
 *
 * Licensed under the GPLv2+ license.
 */

window.<%= jsclassname %> = window.<%= jsclassname %> || {};

( function( window, document, $, plugin ) {
	let $c = {};

	plugin.init = function() {
		plugin.cache();
		plugin.bindEvents();
	};

	plugin.cache = function() {
		$c.window = $( window );
		$c.body = $( document.body );
	};

	plugin.bindEvents = function() {
	};

	$( plugin.init );
}( window, document, <% if ( type === 'Browserify' ) {%>require( 'jquery' )<%} else {%>jQuery<%}%>, window.<%= jsclassname %> ) );
