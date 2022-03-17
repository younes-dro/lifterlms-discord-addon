(function ($) {
	'use strict';

	/* Select2 -Plugin jquery */
	$('document').ready(function () {

		/*Load all roles from discord server
		1) Call discord API to get bot status.
		*/
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: ets_lifterlms_js_params.admin_ajax,
			data: { 'action': 'ets_lifterlms_load_discord_roles', 'ets_lifterlms_discord_nonce': ets_lifterlms_js_params.ets_lifterlms_discord_nonce, },
			beforeSend: function () {
				$(".discord-roles .spinner").addClass("is-active");
				$(".initialtab.spinner").addClass("is-active");
			},

			success: function (response) {
				console.log(response);
				if (response != null && response.hasOwnProperty('code') && response.code == 50001 && response.message == 'Missing Access')
				{
					$(".btn-connect-to-bot").show();
				} 
				else if (response == null || response.message == '401: Unauthorized' || response.hasOwnProperty('code') || response == 0) {
					$("#connect-discord-bot").show().html("Error: Please check all details are correct").addClass('error-bk');
				} else {
					if ($('.ets-tabs button[data-identity="level-mapping"]').length) {
						$('.ets-tabs button[data-identity="level-mapping"]').show();
					}
					$("#connect-discord-bot").show().html("Bot Connected <i class='fab fa-discord'></i>").addClass('not-active');
					
					var activeTab = localStorage.getItem('activeTab');
						if ($('.ets-tabs button[data-identity="level-mapping"]').length == 0 && activeTab == 'level-mapping') {
							$('.ets-tabs button[data-identity="lifterlms_application"]').trigger('click');
						}

					$.each(response, function (key, val) {
						var isbot = false;
						
						if (val.hasOwnProperty('tags')) {
							if (val.tags.hasOwnProperty('bot_id')) {
								isbot = true;
							}
						}
						
					});

			}

			},
			error: function (response) {
				$("#connect-discord-bot").show().html("Error: Please check all details are correct").addClass('error-bk');
				console.error(response);
			},
			complete: function () {
				$(".discord-roles .spinner").removeClass("is-active").css({ "float": "right" });
				$("#skeletabsTab1 .spinner").removeClass("is-active").css({ "float": "right", "display": "none" });
			}	
			
		});
		

		
		/*Select-tabs plugin options*/

		let select2 = jQuery(".ets_wp_pages_list").select2({
			placeholder: "Select a Pages",
			allowClear: true
		})


		/*Tab options*/
		$.skeletabs.setDefaults({
			keyboard: false,
		});
		$(document.body).on('change', '.ets_wp_pages_list', function (e) {
			var page_url = $(this).find(':selected').data('page-url');

			$('p.redirect-url').html('<b>' + page_url + '</b>');
		});

	});
})(jQuery);
