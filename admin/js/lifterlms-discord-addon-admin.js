(function ($) {
	'use strict';
	/* Select2 -Plugin jquery */
	$('document').ready(function () {
		jQuery(".js-example-tags").select2({
			placeholder: "Select a Pages",
			allowClear: true
		});

		/*Tab options*/
		$.skeletabs.setDefaults({
			keyboard: false,
		});
	});
})(jQuery);
