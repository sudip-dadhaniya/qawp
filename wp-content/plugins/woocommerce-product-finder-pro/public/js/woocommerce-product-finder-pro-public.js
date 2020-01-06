(function($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

	var wooProductFinderProPublicScripts = {
		init: function() {
			wooProductFinderProPublicScripts.clickNavigationButtonScripts();
			wooProductFinderProPublicScripts.onChangeInputScripts();
			wooProductFinderProPublicScripts.attributeViewMoreAndLessScript();
			wooProductFinderProPublicScripts.wizardShowResult();

		},

		load: function() {
			$(document).on('click', '.wpfp-wizard-list-restart-button', function(e) {
				var dataTitle = jQuery(this).attr('data-title');
				if (confirm(dataTitle)) {
					setTimeout(function() {
						location.reload();
					}, 1000);
				} else {
					return false;
				}
			});
		},
		attributeViewMoreAndLessScript: function() {

			/*View more button for product attribute*/
			$(document).on('click', '.wpfp_more', function(e) {
				var getShortCodeID = $(this).closest('div.wpfp').attr('id');
				var wpfpProductID = $.trim($(this).attr('id').substr($(this).attr('id').lastIndexOf('-') + 1)),
					wpfpProductSelector = $('#' + getShortCodeID + ' #wpfp_product_' + wpfpProductID),
					wpfpViewMoreSelector = $('#' + getShortCodeID + ' #wpfp-more-id-' + wpfpProductID),
					wpfpAttributesLength = wpfpProductSelector.find('.wpfp-product-body div.wpfp-product-attribute:hidden').length;

				wpfpProductSelector.find('.wpfp-product-body div.wpfp-product-attribute:hidden').slice(0, wpfpAttributesLength).slideDown();
				if (0 === wpfpAttributesLength) {
					wpfpViewMoreSelector.fadeOut('slow');
				}
				$('#' + getShortCodeID + ' #wpfp-less-id-' + wpfpProductID).show();
				wpfpViewMoreSelector.hide();
			});

			/*Show less button for product attribute*/
			$(document).on('click', '.wpfp_less', function(e) {
				var getShortCodeID = $(this).closest('div.wpfp').attr('id');
				var wpfpProductID = $.trim($(this).attr('id').substr($(this).attr('id').lastIndexOf('-') + 1)),
					wpfpProductSelector = $('#' + getShortCodeID + ' #wpfp_product_' + wpfpProductID),
					wpfpLessSelector = $('#' + getShortCodeID + ' #wpfp-less-id-' + wpfpProductID),
					wpfpAttributesLength = wpfpProductSelector.find('.wpfp-product-body div.wpfp-product-attribute:visible').length,
					showAttribute = $(this).attr('data-attributes-default'),
					showAttributeCount,
					hideAttributes;

				if (wpfpAttributesLength > showAttribute) {
					showAttributeCount = $.trim(+showAttribute + +1);
					hideAttributes = +(wpfpAttributesLength - showAttributeCount) + +1;
					wpfpProductSelector.find('.wpfp-product-body .wpfp-product-overlay-attributes').find('.wpfp-product-attribute:gt(-' + (+hideAttributes + +1) + ')').slideUp();
				}
				$('#' + getShortCodeID + '  #wpfp-more-id-' + wpfpProductID).show();
				wpfpLessSelector.hide();
			});
		},
		viewMoreAttributeSCript: function(ShortCodeID, showAttributeCount = 3) {

			$('#' + ShortCodeID + ' .wpfp-product-section .wpfp-product-attribute').each(function() {
				if ('wpfp-product-attribute' === $.trim($(this).attr('class'))) {
					$(this).addClass('wpfp-product-neutral-attributes');
				}
			});

			$('#' + ShortCodeID + ' .wpfp-product-section').each(function() {

				var wpfpProductID = $.trim($(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)),
					wpfpProductSelector = $('#' + ShortCodeID + ' #wpfp_product_' + wpfpProductID),
					wpfpProductAttributeOverlaySelector = $('#' + ShortCodeID + ' #wpfp_product_' + wpfpProductID + ' .wpfp-product-overlay-attributes'),
					wpfpNegativeValue = wpfpProductSelector.find('div.wpfp-product-negative-attribute').sort(sortMe),
					wpfpNeutralValue = wpfpProductSelector.find('div.wpfp-product-neutral-attributes').sort(sortMe),
					showAttribute = showAttributeCount, // Need to be dynamic.
					productWiseAttributeCount;

				function sortMe(a, b) {
					return a.className < b.className;
				}

				wpfpNegativeValue.appendTo(wpfpProductAttributeOverlaySelector);
				wpfpNeutralValue.appendTo(wpfpProductAttributeOverlaySelector);

				wpfpProductSelector.each(function() {
					productWiseAttributeCount = $(this).find('.wpfp-product-body .wpfp-product-attributes-list .wpfp-product-overlay-attributes').find('.wpfp-product-attribute').length;
					if (productWiseAttributeCount > showAttribute) {
						$('#' + ShortCodeID + ' #wpfp-more-id-' + wpfpProductID).show();
						$(this).find('.wpfp-product-body .wpfp-product-attributes-list .wpfp-product-overlay-attributes .wpfp-product-attribute:lt(' + (productWiseAttributeCount) + ')').show();
						$(this).find('.wpfp-product-body .wpfp-product-attributes-list .wpfp-product-overlay-attributes .wpfp-product-attribute:gt(' + (showAttribute - 1) + ')').hide();
					} else {
						$(this).find('.wpfp-product-body .wpfp-product-attributes-list .wpfp-product-overlay-attributes').find('.wpfp-product-attribute').show();
						$('#' + ShortCodeID + ' #wpfp-more-id-' + wpfpProductID).hide();
					}
					$('.wpfp_less').hide();
				});
			});
		},
		clickNavigationButtonScripts: function() {

			$(document).on('click', '.wpfp-button-next', function(e) {
				var wizardID = $(this).attr('data-wizard-id'),
					getShortCodeID = $(this).closest('div.wpfp').attr('id'),
					wizardSelector = $('#' + getShortCodeID + ' .wpfp-wizard-' + wizardID),
					questionID = wizardSelector.find('.wpfp-next').attr('id'),
					wpfpStepID,
					isHideBtn;
				e.preventDefault();
				wizardSelector.find('.wpfp-questions li').removeClass('wpfp-current').removeClass('wpfp-next').removeClass('wpfp-previous');
				wizardSelector.find('#' + questionID).prev().removeClass('wpfp-current').addClass('wpfp-previous');
				wizardSelector.find('#' + questionID).next().addClass('wpfp-next');
				wizardSelector.find('#' + questionID).removeClass('wpfp-next').addClass('wpfp-current');

				$('#' + getShortCodeID + ' .wpfp-button-previous').prop('disabled', false);
				if ( ! wizardSelector.find('.wpfp-questions li').hasClass('wpfp-next')) {
					$('#' + getShortCodeID + ' .wpfp-button-next').prop('disabled', true).hide();
					isHideBtn = true;
					$('#' + getShortCodeID + ' .wpfp-option-action input:checked').each(function(index) {
						isHideBtn = false;
					});
					if (false === isHideBtn) {
						$('#' + getShortCodeID + ' .wpfp-button-show-result').show().prop('disabled', false);
					} else {
						$('#' + getShortCodeID + ' .wpfp-button-show-result').show().prop('disabled', true);
					}
				}

				wpfpStepID = $('#' + getShortCodeID + ' .wpfp-step-wrapper .wpfp-step.active').attr('id');
				$('#' + getShortCodeID + ' .wpfp-step-wrapper .wpfp-step').removeClass('active');
				$('#' + getShortCodeID + ' #' + wpfpStepID).next().addClass('active');

			});
			$(document).on('click', '.wpfp-button-previous', function(e) {
				var wizardID = $(this).attr('data-wizard-id'),
					getShortCodeID = $(this).closest('div.wpfp').attr('id'),
					wizardSelector = $('#' + getShortCodeID + ' .wpfp-wizard-' + wizardID),
					questionID = wizardSelector.find('.wpfp-previous').attr('id'),
					wpfpStepID;
				e.preventDefault();
				wizardSelector.find('.wpfp-questions li').removeClass('wpfp-current').removeClass('wpfp-previous').removeClass('wpfp-next');
				wizardSelector.find('#' + questionID).prev().removeClass('wpfp-current').addClass('wpfp-previous');
				wizardSelector.find('#' + questionID).next().addClass('wpfp-next');
				wizardSelector.find('#' + questionID).removeClass('wpfp-previous').addClass('wpfp-current');

				$('#' + getShortCodeID + ' .wpfp-button-next').show().prop('disabled', false);
				$('#' + getShortCodeID + ' .wpfp-button-show-result').hide().prop('disabled', true);
				if ( ! wizardSelector.find('.wpfp-questions li').hasClass('wpfp-previous')) {
					$('#' + getShortCodeID + ' .wpfp-button-previous').prop('disabled', true);
				}

				wpfpStepID = $('#' + getShortCodeID + ' .wpfp-step-wrapper .wpfp-step.active').attr('id');
				$('#' + getShortCodeID + ' .wpfp-step-wrapper .wpfp-step').removeClass('active');
				$('#' + getShortCodeID + ' #' + wpfpStepID).prev().addClass('active');
			});
		},
		checkboxWizardOption: function(checkboxElement, wpfpSelectionObj, ShortCodeID) {
			var wpfpSelectioncheckboxObj = $('#' + ShortCodeID + ' .wpfp_wizard_selected_option_' + checkboxElement.data('question-key')),
				wpfpSelectionCheckboxOptionInput = wpfpSelectioncheckboxObj.val(),
				wpfpSelectedOptionTemp;

			var wpfpCheckboxOptions = {};
			if (checkboxElement.attr('checked')) {
				wpfpCheckboxOptions[checkboxElement.attr('id')] = wpfpSelectionObj;
				if ('' !== wpfpSelectionCheckboxOptionInput) {
					wpfpSelectionCheckboxOptionInput = JSON.parse(wpfpSelectionCheckboxOptionInput);
					wpfpSelectedOptionTemp = wpfpSelectionCheckboxOptionInput.checkbox;
					wpfpSelectionCheckboxOptionInput = {
						'checkbox': $.extend(wpfpCheckboxOptions, wpfpSelectedOptionTemp),
					};
				} else {
					wpfpSelectionCheckboxOptionInput = {
						'checkbox': wpfpCheckboxOptions,
					};
				}
			} else {
				wpfpSelectionCheckboxOptionInput = JSON.parse(wpfpSelectionCheckboxOptionInput);
				delete wpfpSelectionCheckboxOptionInput.checkbox[checkboxElement.attr('id')];
			}
			if ($.isEmptyObject(wpfpSelectionCheckboxOptionInput.checkbox)) {
				wpfpSelectionCheckboxOptionInput = '';
			}

			wpfpSelectioncheckboxObj.val(JSON.stringify(wpfpSelectionCheckboxOptionInput));
		},
		selectionWizardOption: function(element, wpfpSelectionObj, ShortCodeID) {
			var wpfpSelectionOptionObj = $('#' + ShortCodeID + ' #wpfp_wizard_options_selected'),
				wpfpSelectionOptionInput = wpfpSelectionOptionObj.val();
			if ('' === wpfpSelectionOptionInput) {
				wpfpSelectionOptionInput = {};
				wpfpSelectionOptionInput[element.data('question-key')] = wpfpSelectionObj;
			} else {
				wpfpSelectionOptionInput = JSON.parse(wpfpSelectionOptionInput);
				wpfpSelectionOptionInput[element.data('question-key')] = wpfpSelectionObj;
			}

			wpfpSelectionOptionObj.val(JSON.stringify(wpfpSelectionOptionInput));

		},
		onChangeInputScripts: function() {
			$(document).on('change', '.wpfp-input-option', function() {
				var wpfpSelectionCheckboxObj,
					isHideBtn,
					getShortCodeID = $(this).closest('div.wpfp').attr('id'),
					nextBtnSelector = $('#' + getShortCodeID + ' .wpfp-button-next'),
					wpfpSelectionObj = {
						'questionKey': $(this).data('question-key'),
						'optionKey': $(this).data('id'),
						'attributeName': $(this).data('attribute-name'),
						'attributeNameDB': $(this).data('attribute-name-db'),
						'attributeValue': $(this).data('attribute-value'),
					};

				if (nextBtnSelector.prop('disabled') || 'undefined' === typeof nextBtnSelector.prop('disabled')) {
					isHideBtn = true;
					$('#' + getShortCodeID + ' .wpfp-option-action input:checked').each(function(index) {
						isHideBtn = false;
					});
					if (false === isHideBtn) {
						$('#' + getShortCodeID + ' .wpfp-button-show-result').show().prop('disabled', false);
					} else {
						$('#' + getShortCodeID + ' .wpfp-button-show-result').show().prop('disabled', true);
					}
				}

				if ('checkbox' === $(this).attr('type')) {
					wooProductFinderProPublicScripts.checkboxWizardOption($(this), wpfpSelectionObj, getShortCodeID);
					wpfpSelectionCheckboxObj = $('#' + getShortCodeID + ' .wpfp_wizard_selected_option_' + $(this).data('question-key')).val();
					wpfpSelectionObj = JSON.parse(wpfpSelectionCheckboxObj);
				}
				wooProductFinderProPublicScripts.selectionWizardOption($(this), wpfpSelectionObj, getShortCodeID);
				if ('yes' !== wpfpPublicScriptObj.wpfp_result_display_mode) {
					wooProductFinderProPublicScripts.wizardAjaxCall($(this), getShortCodeID);
				}

			});
		},
		wizardAjaxCall: function($thisSelector, ShortCodeID) {
			var wpfpData = {
				'action': 'wpfp_get_ajax_product_list',
				'wizardID': $thisSelector.data('wizard-id'),
				'wizardSelectedOptions': $('#' + ShortCodeID + ' #wpfp_wizard_options_selected').val(),
				'wizardCategoriesIDs': $('#' + ShortCodeID + ' #wpfp_wizard_categories_ids').val(),
				'optionKey': $thisSelector.data('id'),
				'security': $thisSelector.data('nonce'),
			};
			$.ajax({
				type: 'GET',
				url: wpfpPublicScriptObj.wpfp_ajax_url,
				data: wpfpData,
				beforeSend: function() {
					$('#' + ShortCodeID).block({
						message: null,
						overlayCSS: {
							background: '#fff',
							opacity: 0.6,
						},
					});
				}, complete: function() {
					$('#' + ShortCodeID).unblock();
				}, success: function(response) {
					var result = $.parseJSON(response);

					if (1 === result.success) {
						$('#' + ShortCodeID + ' .wpfp-product-list').html(result.html);
						wooProductFinderProPublicScripts.viewMoreAttributeSCript(ShortCodeID, result.showAttributeCount);
						wooProductFinderProPublicScripts.wpfpWizardProductPagination(ShortCodeID);
					} else {
						$('#' + ShortCodeID + ' .wpfp-product-list').empty();
					}
				},
			});
		},
		wpfpWizardProductPagination: function(ShortCodeID) {

			/**
			 * Wizard product pagination.
			 */
			$(document).on('click', '#' + ShortCodeID + ' .wpfp-match-pagination a.page-numbers', function(e) {
				var wpfpData,
					wpfpIdentity = $(this).parent().data('identity');
				e.preventDefault();

				wpfpData = {
					'action': 'wpfp_ajax_product_pagination',
					'wizardID': $(this).data('wizard-id'),
					'wizardSelectedOptions': $('#' + ShortCodeID + ' #wpfp_wizard_options_selected').val(),
					'wizardCategoriesIDs': $('#' + ShortCodeID + ' #wpfp_wizard_categories_ids').val(),
					'optionKey': $(this).data('id'),
					'security': $(this).parent().data('nonce'),
					'pageNumber': $(this).data('page-number'),
					'wizardIdentity': wpfpIdentity,
				};

				$.ajax({
					type: 'GET',
					url: wpfpPublicScriptObj.wpfp_ajax_url,
					data: wpfpData,
					beforeSend: function() {
						$('#' + ShortCodeID).block({
							message: null,
							overlayCSS: {
								background: '#fff',
								opacity: 0.6,
							},
						});
					}, complete: function() {
						$('#' + ShortCodeID).unblock();
					}, success: function(response) {
						var result = $.parseJSON(response);

						if (1 === result.success) {
							$('#' + ShortCodeID + ' .wpfp-product-' + wpfpIdentity).html(result.html);
							wooProductFinderProPublicScripts.viewMoreAttributeSCript(ShortCodeID, result.showAttributeCount);
						} else {
							$('#' + ShortCodeID + ' .wpfp-product-list').empty();
						}
					},
				});
			});
		},
		wizardShowResult: function() {
			$('.wpfp-button-show-result').on('click', function(e) {
				var getShortCodeID = $(this).closest('div.wpfp').attr('id');

				if ('yes' === wpfpPublicScriptObj.wpfp_result_display_mode) {
					wooProductFinderProPublicScripts.wizardAjaxCall($(this), getShortCodeID);
				}

				if ($('body').hasClass('logged-in')) {
					$('html, body').animate({
						scrollTop: $('#' + getShortCodeID + ' .wpfp-product-list').offset().top - 30,
					}, 1000);
				} else {
					$('html, body').animate({
						scrollTop: $('#' + getShortCodeID + ' .wpfp-product-list').offset().top,
					}, 1000);
				}

			});
		},
	};

	$(document).ready(wooProductFinderProPublicScripts.init);
	$(window).on({
		'load': wooProductFinderProPublicScripts.load,
		'resize': wooProductFinderProPublicScripts.resize,
		'scroll': wooProductFinderProPublicScripts.scroll,
	});
})(jQuery, window, document);