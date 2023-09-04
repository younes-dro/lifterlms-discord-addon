(function ($) {
	'use strict';


		/*Load all roles from discord server*/
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
				//console.log(response);
				if (response != null && response.hasOwnProperty('code') && response.code == 50001 && response.message == 'Missing Access'){
					$(".btn-connect-to-bot").show();
				} else if ( response.code === 10004 && response.message == 'Unknown Guild' ) {
					$(".btn-connect-to-bot").show().after('<p><b>The server ID is wrong or you did not connect the Bot.</b></p>');
				}else if( response.code === 0 && response.message == '401: Unauthorized' ) {
					$(".btn-connect-to-bot").show().html("Error: Unauthorized - The Bot Token is wrong").addClass('error-bk');										
				} else if (response == null || response.message == '401: Unauthorized' || response.hasOwnProperty('code') || response == 0) {
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
/* fetch all roles from discord server */

					$.each(response, function (key, val) {
						var isbot = false; 
						
						if (val.hasOwnProperty('tags')) {
							if (val.tags.hasOwnProperty('bot_id')) {
								isbot = true;
							}
						}
						if (key != 'previous_mapping' && isbot == false && val.name != '@everyone') {
							$('.discord-roles').append('<div class="makeMeDraggable" style="background-color:#' + val.color.toString(16) + '" data-role_id="' + val.id + '" >' + val.name + '</div>');
							$('#defaultRole').append('<option value="' + val.id + '" >' + val.name + '</option>');
							makeDrag($('.makeMeDraggable'));
						}
						
					});

					var defaultRole = $('#selected_default_role').val();
						if (defaultRole) {
							$('#defaultRole option[value=' + defaultRole + ']').prop('selected', true);
						}

						if (response.previous_mapping) {
							var mapjson = response.previous_mapping;
						} else {
							var mapjson = localStorage.getItem('LifterlmsMappingjson');
						}



					$("#maaping_json_val").html(mapjson);
						$.each(JSON.parse(mapjson), function (key, val) {
							var arrayofkey = key.split('id_');
							var preclone = $('*[data-role_id="' + val + '"]').clone();
							if(preclone.length>1){
								preclone.slice(1).hide();
							}
							if (jQuery('*[data-course_id="' + arrayofkey[1] + '"]').find('*[data-role_id="' + val + '"]').length == 0) {
								$('*[data-course_id="' + arrayofkey[1] + '"]').append(preclone).attr('data-drop-role_id', val).find('span').css({ 'order': '2' });
							}
							if ($('*[data-course_id="' + arrayofkey[1] + '"]').find('.makeMeDraggable').length >= 1) {
								$('*[data-course_id="' + arrayofkey[1] + '"]').droppable("destroy");
							}
							preclone.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '0px', 'order': '1' }).attr('data-course_id', arrayofkey[1]);
							makeDrag(preclone);
							
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

/*Create droppable element*/
		
		function init() {
			if ( $('.makeMeDroppable').length){
				$('.makeMeDroppable').droppable({
					drop: handleDropEvent,
					hoverClass: 'hoverActive',
				});
			}
			if ( $('.discord-roles-col').length){
				$('.discord-roles-col').droppable({
					drop: handlePreviousDropEvent,
					hoverClass: 'hoverActive',
				});
			}

		}

		$(init);

/*Create draggable element*/

	    function makeDrag(el) {
		
		el.draggable({
			revert: "invalid",
			helper: 'clone',
			start: function(e, ui) {
			ui.helper.css({"width":"45%"});
			}
		});
	}

	
	function handlePreviousDropEvent(event, ui) {
		var draggable = ui.draggable;
		if(draggable.data('course_id')){
			$(ui.draggable).remove().hide();
		}

		$(this).append(draggable);
		$('*[data-drop-role_id="' + draggable.data('role_id') + '"]').droppable({
			drop: handleDropEvent,
			hoverClass: 'hoverActive',
		});
		$('*[data-drop-role_id="' + draggable.data('role_id') + '"]').attr('data-drop-role_id', '');

		var oldItems = JSON.parse(localStorage.getItem('lifterlmsMapArray')) || [];
		$.each(oldItems, function (key, val) {
			if (val) {
				var arrayofval = val.split(',');
				if (arrayofval[0] == 'course_id_' + draggable.data('course_id') && arrayofval[1] == draggable.data('role_id')) {
					delete oldItems[key];
				}
			}
		});

		var jsonStart = "{";
		$.each(oldItems, function (key, val) {
			if (val) {
				var arrayofval = val.split(',');
				if (arrayofval[0] != 'course_id_' + draggable.data('course_id') || arrayofval[1] != draggable.data('role_id')) {
					jsonStart = jsonStart + '"' + arrayofval[0] + '":' + '"' + arrayofval[1] + '",';
				}
			}
		});
		localStorage.setItem('lifterlmsMapArray', JSON.stringify(oldItems));
		var lastChar = jsonStart.slice(-1);
		if (lastChar == ',') {
			jsonStart = jsonStart.slice(0, -1);
		}

		var LifterlmsMappingjson = jsonStart + '}';
		$("#maaping_json_val").html(LifterlmsMappingjson);
		localStorage.setItem('LifterlmsMappingjson', LifterlmsMappingjson);
		draggable.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '10px' });
	}

	
	function handleDropEvent(event, ui) {
		var draggable = ui.draggable;
		var newItem = [];
		
		var newClone = $(ui.helper).clone();
		if($(this).find(".makeMeDraggable").length >= 1){
			return false;
		}
		$('*[data-drop-role_id="' + newClone.data('role_id') + '"]').droppable({
			drop: handleDropEvent,
			hoverClass: 'hoverActive',
		});
		$('*[data-drop-role_id="' + newClone.data('role_id') + '"]').attr('data-drop-role_id', '');
		if ($(this).data('drop-role_id') != newClone.data('role_id')) {
			var oldItems = JSON.parse(localStorage.getItem('lifterlmsMapArray')) || [];
			$(this).attr('data-drop-role_id', newClone.data('role_id'));
			newClone.attr('data-course_id', $(this).data('course_id'));

			$.each(oldItems, function (key, val) {
				if (val) {
					var arrayofval = val.split(',');
					if (arrayofval[0] == 'course_id_' + $(this).data('course_id') ) {
						delete oldItems[key];
					}
				}
			});

			var newkey = 'course_id_' + $(this).data('course_id');
			oldItems.push(newkey + ',' + newClone.data('role_id'));
			var jsonStart = "{";
			$.each(oldItems, function (key, val) {
				if (val) {
					var arrayofval = val.split(',');
					if (arrayofval[0] == 'course_id_' + $(this).data('course_id') || arrayofval[1] != newClone.data('role_id') && arrayofval[0] != 'course_id_' + $(this).data('course_id') || arrayofval[1] == newClone.data('role_id')) {
						jsonStart = jsonStart + '"' + arrayofval[0] + '":' + '"' + arrayofval[1] + '",';
					}
				}
			});

			localStorage.setItem('lifterlmsMapArray', JSON.stringify(oldItems));
			var lastChar = jsonStart.slice(-1);
			if (lastChar == ',') {
				jsonStart = jsonStart.slice(0, -1);
			}

			var LifterlmsMappingjson = jsonStart + '}';
			localStorage.setItem('LifterlmsMappingjson', LifterlmsMappingjson);
			$("#maaping_json_val").html(LifterlmsMappingjson);
		}

		$(this).append(newClone);
		$(this).find('span').css({ 'order': '2' });
		if (jQuery(this).find('.makeMeDraggable').length >= 1) {
			$(this).droppable("destroy");
		}
		makeDrag($('.makeMeDraggable'));

		newClone.css({ 'width': '100%','margin-bottom': '0px', 'left': '0', 'position':'unset', 'order': '1' });
		
	}
		/*Flush settings from local storage*/
		$("#lifterlmsRevertMapping").on('click', function () {
			localStorage.removeItem('lifterlmsMapArray');
			localStorage.removeItem('LifterlmsMappingjson');
			window.location.href = window.location.href;
		}); 

	if(jQuery().select2) {
		/*Select-tabs plugin options*/
		let select2 = jQuery(".ets_wp_pages_list").select2({
			placeholder: "Select a Pages",
			allowClear: true,
                        width: "resolve"
		});              
		$('.ets_wp_pages_list').on('change', function(){

			$.ajax({
				url: ets_lifterlms_js_params.admin_ajax,
				type: "POST",
				context: this,
				data: { 'action': 'ets_lifterlms_discord_update_redirect_url', 'ets_lifterlms_page_id': $(this).val() , 'ets_lifterlms_discord_nonce': ets_lifterlms_js_params.ets_lifterlms_discord_nonce },
				beforeSend: function () {
					$('p.redirect-url').find('b').html("");
					$('p.ets-discord-update-message').css('display','none');                                               
					$(this).siblings('p.description').find('span.spinner').addClass("ets-is-active").show();
                                       
				},
				success: function (data) { 
					$('p.redirect-url').find('b').html(data.formated_discord_redirect_url);
					$('p.ets-discord-update-message').css('display','block'); 
				},
				error: function (response, textStatus, errorThrown ) {
					console.log( textStatus + " :  " + response.status + " : " + errorThrown );
				},
				complete: function () {
					$(this).siblings('p.description').find('span.spinner').removeClass("ets-is-active").hide();
				}
			});

		});                        
	}
		$('#ets_lifterlms_discord_connect_button_bg_color').wpColorPicker();
		$('#ets_lifterlms_discord_disconnect_button_bg_color').wpColorPicker();  
		
		/* RUN Discord API */
		$('.ets-lifterlms-discord-run-api').click(function (e) {
			e.preventDefault();
			$.ajax({
				url: ets_lifterlms_js_params.admin_ajax,
				type: "POST",
				context: this,
				data: { 'action': 'ets_lifterlms_discord_run_api', 'ets_lifterlms_discord_user_id': $(this).data('user-id') , 'ets_lifterlms_discord_nonce': ets_lifterlms_js_params.ets_lifterlms_discord_nonce },
				beforeSend: function () {
					$(this).siblings("div.run-api-success").html("");
					$(this).siblings('span.spinner').addClass("is-active").show();
				},
				success: function (data) {        
					if (data.error) {
						// handle the error
						alert(data.error.msg);
					} else {
                                            
						$(this).siblings("div.run-api-success").html("Update Discord Roles Sucesssfully !");
					}
				},
				error: function (response, textStatus, errorThrown ) {
					console.log( textStatus + " :  " + response.status + " : " + errorThrown );
				},
				complete: function () {
					$(this).siblings('span.spinner').removeClass("is-active").hide();
				}
			});
		});

		$('.lifterlms-disconnect-discord-user').click(function (e) {
			e.preventDefault();
			$.ajax({
				url: ets_lifterlms_js_params.admin_ajax,
				type: "POST",
				context: this,
				data: { 'action': 'ets_lifterlms_discord_disconnect_user', 'ets_lifterlms_discord_user_id': $(this).data('user-id') , 'ets_lifterlms_discord_nonce': ets_lifterlms_js_params.ets_lifterlms_discord_nonce },
				beforeSend: function () {
					$(this).find('span').addClass("is-active").show();
				},
				success: function (data) {       
					if (data.error) {
						// handle the error
						alert(data.error.msg);
					} else {
						$(this).prop('disabled', true);
						console.log(data);
					}
				},
				error: function (response, textStatus, errorThrown ) {
					console.log( textStatus + " :  " + response.status + " : " + errorThrown );
				},
				complete: function () {
					$(this).find('span').removeClass("is-active").hide();
				}
			});
		});
		/*Clear log log call-back*/
		$('#ets-lifterlms-clrbtn').click(function (e) {
			e.preventDefault();
			$.ajax({
				url: ets_lifterlms_js_params.admin_ajax,
					type: "POST",
					data: { 'action': 'ets_lifterlms_discord_clear_logs', 'ets_lifterlms_discord_nonce': ets_lifterlms_js_params.ets_lifterlms_discord_nonce },
					beforeSend: function () {
						$(".clr-log.spinner").addClass("is-active").show();
					},
					success: function (data) {
			 
						if (data.error) {
							// handle the error
							alert(data.error.msg);
						} else {
													
							$('.error-log').html("Clear logs Sucesssfully !");
						}
					},
					error: function (response, textStatus, errorThrown ) {
						console.log( textStatus + " :  " + response.status + " : " + errorThrown );
					},
					complete: function () {
						$(".clr-log.spinner").removeClass("is-active").hide();
					}
			});
		});	
		
		$(document).ready(function(){
			$(' .ets-lifterlms-discord-review-notice > button.notice-dismiss' ).on('click', function() {

				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: ets_lifterlms_js_params.admin_ajax,
					data: { 
						'action': 'ets_lifterlms_discord_notice_dismiss', 
						'ets_lifterlms_discord_nonce': ets_lifterlms_js_params.ets_lifterlms_discord_nonce
					},
					beforeSend: function () {
						console.log('sending...');
					},
					success: function (response) {
						console.log(response);
					},
					error: function (response) {
						console.error(response);
					},
					complete: function () {
						// 
					}
				});
			});			
		});		

		/*Tab options*/
		if ($.skeletabs ) {
		$.skeletabs.setDefaults({
			keyboard: false,
		});
	}

})(jQuery);