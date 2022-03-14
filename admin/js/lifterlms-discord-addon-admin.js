(function ($) {
	'use strict';
	/* Select2 -Plugin jquery */
	$('document').ready(function () {
		let select2 = jQuery(".ets_wp_pages_list").select2({
			placeholder: "Select a Pages",
			allowClear: true
		})


		/*Tab options*/
		$.skeletabs.setDefaults({
			keyboard: false,
		});
		$(document.body).on('change', '.ets_wp_pages_list', function(e){
			var page_url = $(this).find(':selected').data('page-url');
			
                       $('p.redirect-url').html('<b>'+page_url+'</b>');
		});  
	
	});
})(jQuery);
