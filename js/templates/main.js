/**
 * <%= rc.name %>
 * <%= rc.homepage %>
 *
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery */

window.<%= rc.classname %> = window.<%= rc.classname %> || (function(window, document, $, undefined) {

	var that = {},
		$c   = {};

	var init = function() {
		that.cache();
		that.bindEvents();
	};

	that.cache = function() {
		$c.window = $(window);
		$c.body   = $(document.body);
	};

	that.bindEvents = function() {
	};

	$(init);
})(window, document, jQuery);