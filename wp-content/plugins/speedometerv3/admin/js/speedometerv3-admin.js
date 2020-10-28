(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	$(document).ready(function() {

		$('ul.scantab li').click(function(e){
			e.preventDefault();
			var abc = $(this).find('a').attr('href');
			$('ul.scantab li').removeClass('active');
			$('.tab-cover').hide();
			$(abc).show();
		})
	
		 $(document).on('click', '.expand', function () {
			$(this).parents('tr').toggleClass('active');
		});


		$('#btn_id').on('click',function(e){
			var copyText = document.getElementById("key-valid-input");
			copyText.select();
			copyText.setSelectionRange(0, 99999);
			document.execCommand("copy");
			
			var tooltip = document.getElementById("myTooltip");
			tooltip.innerHTML = "Copied: " + copyText.value;
		});
		$('#btn_id').on('mouseout',function(e){
			var tooltip = document.getElementById("myTooltip");
			tooltip.innerHTML = "Copy to clipboard";
		});
		$(".tbtn").click(function () {
			$(this).parents(".custom-table").find(".toggler1").removeClass("toggler1");
			$(this).parents("tbody").find(".toggler").addClass("toggler1");
			$(this).parents(".custom-table").find(".fa-minus-circle").removeClass("fa-minus-circle");
			$(this).parents("tbody").find(".fa-plus-circle").addClass("fa-minus-circle");
		});

		$('#submitPluginSetting').on('click',function(e){
			document.getElementById('pln_setting').submit();
		});

		//ajax for change scaning option
		$('#cmn-toggle-1').on('change',function(e){
			e.preventDefault(); 
			if($(this).prop("checked") == true){
				var sync_status = 1
			}else{
				var sync_status = 0
			}
			var token_val = $("#token_val").val();
			$.ajax({
				type : "post",
				dataType : 'json',
				url : settingAjax.ajaxurl,
				data : {action: "sm_sync_update", token_val : token_val, sync_status: sync_status, nonce: settingAjax.nonce},
				success: function(response) {
				   if(response.status == "success") {
						alert('Setting Saved');
				   } else {
						alert('Something went to wrong');
				   }
				}
			}); 

			return false;
		});
	});

})( jQuery );
