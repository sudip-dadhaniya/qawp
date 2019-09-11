/*
 * Custom Script file
 */

jQuery(document).ready(function($) {

	// ******************************************//
	// ** Select Box Script for Category **
	// ******************************************//

	$('#chart-categories').select2({
		maximumSelectionLength: 100,
	});
	$('#color-picker1,#color-picker2,#color-picker3,#color-picker4,#color-picker5,#color-picker6').wpColorPicker();

	// ******************************************//
	// ** Ajax for delete image **
	// ******************************************//
	$('a.delete-chart-image').click(function() {
		var post_id = $(this).attr('id');
		var data = {
			'action': 'size_chart_delete_image',
			'post_id': post_id,
			'security': size_chart_woo_ajax_object.size_chart_nonce,
		};

		$.ajax({
			type: 'GET',
			url: ajaxurl,
			data: data,
			beforeSend: function() {
				$('#wait').show();
				$('#wait').css('position', 'fixed');
			}, complete: function() {
				$('#wait').hide();
			}, success: function(response) {
				var result = $.parseJSON(response);
				if (1 === result.success) {
					$('#field-image img').attr('src', result.url);
					$('#field-image img').attr('width', '');
					$('#field-image img').attr('height', '');
					$('.delete-chart-image').css('display', 'none');
					alert(result.msg);
				} else {
					alert(result.msg);
				}
			},
		});
	});
	// ******************************************//
	// ** Preview Chart **
	// ******************************************//
	$('a.preview_chart').click(function() {
		var chart_id = $(this).attr('id');
		$('.size-chart-model').css('padding', '0');
		$('#wait').show();
		$('[data-remodal-id=modal]').html('');
		var data = {
			'action': 'size_chart_preview_post',
			'chart_id': chart_id,
			'security': size_chart_woo_ajax_object.size_chart_nonce,
		};

		$.ajax({
			type: 'GET',
			url: ajaxurl,
			data: data,
			beforeSend: function() {
				$('#wait').show();
				$('#wait').css('position', 'fixed');
			}, complete: function() {
				$('#wait').hide();

			}, success: function(response) {
				var result = $.parseJSON(response);

				if (1 === result.success) {
					$('.size-chart-model').css('padding', '35px');
					var modal = document.getElementById("md-size-chart-modal");
					modal.style.display = "block";
					$('#md-poup').after(result.html);
					$('#size-chart-for-woocommerce-inline-css').text(result.css);
				} else {
					alert(result.msg);
				}
			},
		});
	});

	/*** Close popup ***/
	$('div#md-size-chart-modal .remodal-close').click(function() {
		var modal = document.getElementById("md-size-chart-modal");
		$('.chart-container').remove();
		modal.style.display = "none";
	});

	$('div.md-size-chart-overlay').click(function() {
		var modal = document.getElementById("md-size-chart-modal");
		$('.chart-container').remove();
		modal.style.display = "none";
	});


});