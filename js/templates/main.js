/**
 * <%= rc.name %>
 * <%= rc.homepage %>
 *
 * Licensed under the GPLv2+ license.
 */

window.<%= class_name %> = window.<%= class_name %> || {};

( function( window, document, $, that, undefined ) {
	'use strict';

	var $c   = {};

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

} ) ( window, document, jQuery, <%= class_name %> );
