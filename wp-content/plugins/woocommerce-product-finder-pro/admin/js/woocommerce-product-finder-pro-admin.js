(function($, window, document) {
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
	var wooProductFinderProScripts = {
		init: function() {
			wooProductFinderProScripts.loadDocumentCommonScripts();
			wooProductFinderProScripts.loadSelect2FieldScripts();
			wooProductFinderProScripts.loadSortableScripts();
			wooProductFinderProScripts.loadKeyEventScripts();
			wooProductFinderProScripts.loadToggleAndSwitch();
			wooProductFinderProScripts.loadAttributesNames();
			wooProductFinderProScripts.loadWizardImageUploader();
			wooProductFinderProScripts.loadSettingImageUploader();
			wooProductFinderProScripts.addNewQuestionHTML();
			wooProductFinderProScripts.addNewOptionHTML();
			wooProductFinderProScripts.removeQuestionHTML();
			wooProductFinderProScripts.removeOptionHTML();
			wooProductFinderProScripts.removeWizardOptionImage();
			wooProductFinderProScripts.removeWizardSettingImage();
			wooProductFinderProScripts.deleteSingleWizard();
			wooProductFinderProScripts.deleteMultipleWizard();
			wooProductFinderProScripts.submitAddNewWizard();
			wooProductFinderProScripts.wizardCheckBoxChecked();
		},
		load: function() {
			$('.wp-color-picker-field').wpColorPicker();
			$('<p/>', {class: 'wpfp-help-block'}).appendTo($('#wpfp_wizard_title'));
			$(document.body).on('input propertychange paste', '.wpfp-field-required', function(e) {
				if ($(this).val()) {
					$(this).parent().removeClass('wpfp-has-error').find('.wpfp-help-block').empty();
				} else {
					$(this).parent().addClass('wpfp-has-error').find('.wpfp-help-block').text(wpfpScriptObj.wpfp_validation_text);
				}
			});
			$(document.body).on('change', '.wpfp-field-required', function(e) {
				if ($(this).val()) {
					$(this).parent().removeClass('wpfp-has-error').find('.wpfp-help-block').empty();
				} else {
					$(this).parent().addClass('wpfp-has-error').find('.wpfp-help-block').text(wpfpScriptObj.wpfp_validation_text);
				}
			});

			if (wpfpScriptObj.wpfp_current_screen.match(/dotstore-/g)) {
				$('a[href="admin.php?page=wpfp-list"]').addClass('current').parent().addClass('current');
			}

		},
		loadDocumentCommonScripts: function() {
			$(document.body).on('init_wpfp_tooltips', function() {
				$('.wpfp-help-tip').tipTip({
					'attribute': 'data-tip',
					'fadeIn': 50,
					'fadeOut': 50,
					'delay': 200,
				}).css('cursor', 'help');
			});

			// Tooltips
			$(document.body).trigger('init_wpfp_tooltips');

			// Remove any lingering tooltips
			$('#tiptip_holder').removeAttr('style');
			$('#tiptip_arrow').removeAttr('style');
			$('.wpfp-tips').tipTip({
				'attribute': 'data-tip',
				'fadeIn': 50,
				'fadeOut': 50,
				'delay': 200,
			});
		},
		loadSelect2FieldScripts: function() {
			$('#result_display_mode, #question_type, #attribute_value, .wpfp-product-categories').selectWoo(wooProductFinderProScripts.wpfpSelectWooScript()).addClass('enhanced');
		},
		loadSortableScripts: function() {
			$('.wpfp-option-header-title').sortable({handle: '.wpfp-tips'});
			$('.wpfp-question-main-listing').sortable({handle: '.wpfp-tips'});
		},
		loadKeyEventScripts: function() {
			$(document).on('keyup', '#question_name', function() {
				var wpfpQuestionHeader = wpfpScriptObj.wpfp_question_configuration_text;
				if ('' !== $(this).val()) {
					wpfpQuestionHeader = $(this).val();
				}
				$(this).closest('.wpfp-question-wrapper').parent().find('.wpfp-question-header').text(wpfpQuestionHeader);
			});
			$(document).on('keyup', '#option_name', function() {
				var wpfpOptionHeader = wpfpScriptObj.wpfp_option_text;
				if ('' !== $(this).val()) {
					wpfpOptionHeader = $(this).val();
				}
				$(this).closest('.wpfp-option-wrapper').parent().find('.wpfp-option-header').text(wpfpOptionHeader);
			});
		},
		loadToggleAndSwitch: function() {
			$(document).on('click', '.wpfp-question-toggle', function(e) {
				var wpfpToggleID = $(this).data('toggle');
				$('#' + wpfpToggleID).slideToggle().parent().toggleClass('wpfp-question-toggle-open');
			});
			$(document).on('click', '.wpfp-option-toggle', function() {
				var wpfpToggleID = $(this).data('toggle');
				$('#' + wpfpToggleID).slideToggle().parent().toggleClass('wpfp-option-toggle-open');
			});

			$(document).on('change', '.wpfp-switch-input', function(e) {
				if ($(this).prop('checked')) {
					$('input[type="checkbox"]').prop('checked', true);
					$('.wpfp-switch').addClass('-on');
				} else {
					$('input[type="checkbox"]').prop('checked', false);
					$('.wpfp-switch').removeClass('-on');
				}
			});
		},
		loadAttributesNames: function() {

			// Ajax customer search boxes.
			$(':input.attribute-name').filter(':not(.enhanced)').each(function(index) {
				var wpfpSelect2Woo = {
					allowClear: $(this).data('allow-clear') ? true : false,
					placeholder: $(this).data('placeholder'),
					minimumInputLength: $(this).data('minimum-input-length') ? $(this).data('minimum-input-length') : 1,
				};
				wpfpSelect2Woo = $.extend(wpfpSelect2Woo, wooProductFinderProScripts.wpfpSelectWooScript(true));
				$(this).selectWoo(wpfpSelect2Woo).addClass('enhanced');
			});

			$(document).on('change', '#attribute_name', function(e) {
				var wpfpWizardID = wooProductFinderProScripts.getWizardId(),
					wpfpQuestionID = $(this).attr('data-question-id'),
					wpfpOptionID = $(this).attr('data-option-id'),
					selectedAttributesValueData = $(this).find(':selected').attr('data-value'),
					wpfpSelectorOptionMainWrapperID = 'div#wpfp-option-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID + '-' + wpfpOptionID,
					wpfpCreateOptions,
					resultData;

				$(wpfpSelectorOptionMainWrapperID).find('#attribute_value').empty();
				if (selectedAttributesValueData) {
					resultData = selectedAttributesValueData.split('|');
					$.each(resultData, function(id, value) {
						wpfpCreateOptions = $('<option></option>');
						wpfpCreateOptions.val(value.trim());
						wpfpCreateOptions.text(value.trim());
						wpfpCreateOptions.appendTo($(wpfpSelectorOptionMainWrapperID).find('#attribute_value'));
					});
				}
			});
		},
		loadWizardImageUploader: function() {
			$(document).on('click', '#option_uploader_image_id', function(e) {
				var wpfpWizardID = wooProductFinderProScripts.getWizardId(),
					wpfpQuestionID = $(this).attr('data-question-id'),
					wpfpOptionID = $(this).attr('data-option-id'),
					wpfpUploaderObject;
				e.preventDefault();
				wpfpUploaderObject = {
					title: $(this).attr('data-uploader-title'),
					text: $(this).attr('data-uploader-button-text'),
					inputTagName: 'wpfp[options][image_id][' + wpfpWizardID + '][' + wpfpQuestionID + '][' + wpfpOptionID + ']',
					inputTagID: 'wpfp[options][image_id][' + wpfpWizardID + '][' + wpfpQuestionID + '][' + wpfpOptionID + ']',
					imgSelector: 'div#wpfp-option-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID + '-' + wpfpOptionID,
				};
				wooProductFinderProScripts.wpfpImageUploader(wpfpUploaderObject);

			});
		},
		loadSettingImageUploader: function() {
			$(document).on('click', '#question_background_uploader_image_id', function(e) {
				var wpfpUploaderObject;
				e.preventDefault();
				wpfpUploaderObject = {
					title: $(this).attr('data-uploader-title'),
					text: $(this).attr('data-uploader-button-text'),
					inputTagName: 'wpfp_wizard_setting[questions_background_image_id]',
					inputTagID: 'questions_background_image_id',
					imgSelector: '.question_background_image_section',
				};
				wooProductFinderProScripts.wpfpImageUploader(wpfpUploaderObject);
			});
		},
		getWizardId: function() {
			return $('#wizard_post_id').val();
		},
		addNewQuestionHTML: function() {
			$(document).on('click', '.add-new-question', function(e) {
				var wpfpQuestionMainListingSelector = $('.wpfp-question-main-listing'),
					wpfpWizardID = wooProductFinderProScripts.getWizardId(),
					wpfpQuestionID = parseInt(wpfpQuestionMainListingSelector.attr('data-question-listed')) + 1,
					wpfpToggleID = 'wpfp_btn_toggle_' + wpfpWizardID + '_' + wpfpQuestionID,
					wpfpToggleAttr = 'wpfp-question-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID,
					wpfpDeleteID = 'wpfp_remove_option_' + wpfpWizardID + '_' + wpfpQuestionID,
					wpfpMainQuestionDivID = 'wpfp-question-main-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID,
					wpfpAddNewOptionID = wpfpQuestionID,
					wpfpOptionHeaderTitleID = 'wpfp-option-header-title-' + wpfpWizardID + '-' + wpfpQuestionID,
					wpfpQuestionName = 'wpfp[questions][name][' + wpfpWizardID + '][' + wpfpQuestionID + ']',
					wpfpQuestionType = 'wpfp[questions][question_type][' + wpfpWizardID + '][' + wpfpQuestionID + ']',
					wpfpQuestionKey = 'wpfp[questions][key][' + wpfpWizardID + '][' + wpfpQuestionID + ']',
					wpfpMainQuestion,
					wpfpH2,
					wpfpQuestionWrapper,
					wpfpTable,
					wpfpTbody,
					wpfpLabelObj,
					wpfpInputObj,
					wpfpSpanObj,
					wpfpOptionHeaderDiv,
					wpfpH3,
					wpfpOptionBoxDivID,
					wpfpOptionMainDiv,
					wpfpOptionWrapper,
					wpfpDivObj,
					wpfpToggleATag,
					wpfpDeleteATag,
					wpfpH3Obj,
					wpfpNewOptionATag,
					wpfpOptionToggleATag,
					wpfpOptionDeleteATag,
					wpfpOptionID,
					wpfpTableObj;
				e.preventDefault();

				// Question main wrapper div.
				wpfpDivObj = {
					class: 'wpfp-question-main-wrapper',
					id: wpfpMainQuestionDivID,
					dataQuestionID: wpfpQuestionID,
				};
				wpfpMainQuestion = wooProductFinderProScripts.createDivTagHTML(wpfpQuestionMainListingSelector, wpfpDivObj);

				// H2 section
				wpfpH2 = $('<h2/>');
				$('<span/>', {
					text: wpfpScriptObj.wpfp_question_configuration_text,
					class: 'wpfp-question-header',
				}).appendTo(wpfpH2);
				wpfpH2.appendTo(wpfpMainQuestion);

				// Delete A tag.
				wpfpDeleteATag = {
					class: 'wpfp-question-delete delete',
					href: 'javascript:void(0)',
					id: wpfpDeleteID,
					text: wpfpScriptObj.wpfp_delete_text,
					dataQuestionID: wpfpQuestionID,
				};
				wooProductFinderProScripts.createATagHTML(wpfpH2, wpfpDeleteATag);

				// Toggle A tag.
				wpfpToggleATag = {
					class: 'handlediv wpfp-question-toggle toggle',
					href: 'javascript:void(0)',
					id: wpfpToggleID,
					ariaLabelText: wpfpScriptObj.wpfp_toggle_arial_label_text,
					dataToggle: wpfpToggleAttr,
				};
				wooProductFinderProScripts.createATagHTML(wpfpH2, wpfpToggleATag);

				// Question wrapper Div tab.
				wpfpDivObj = {
					class: 'wpfp-tips wpfp-question-tips wpfp-sort',
				};
				wooProductFinderProScripts.createDivTagHTML(wpfpH2, wpfpDivObj);

				// Question wrapper Div tab.
				wpfpDivObj = {
					class: 'wpfp-question-wrapper',
					id: wpfpToggleAttr,
				};
				wpfpQuestionWrapper = wooProductFinderProScripts.createDivTagHTML(wpfpMainQuestion, wpfpDivObj);

				// Table tag.
				wpfpTableObj = {
					class: 'form-table table-outer question-table all-table-listing',
				};
				wpfpTable = wooProductFinderProScripts.createTableTagHTML(wpfpQuestionWrapper, wpfpTableObj);

				// Tbody tag.
				wpfpTbody = $('<tbody/>').appendTo(wpfpTable);

				// Input text box.
				wpfpLabelObj = {
					wpfpLabelFor: 'question_name',
					wpfpLabelText: wpfpScriptObj.wpfp_question_name_text,
					wpfpIsRequired: true,
				};
				wpfpInputObj = {
					inputType: 'text',
					inputClass: 'text-class half_width wpfp-field-required',
					inputID: 'question_name',
					inputName: wpfpQuestionName,
					inputRequired: true,
					inputPlaceHolder: wpfpScriptObj.wpfp_question_name_input_placeholder_text,
					inputHiddenField: {
						type: 'hidden',
						name: wpfpQuestionKey,
						id: 'question_field_key',
						value: wooProductFinderProScripts.uniqID('question_field_'),
					},
				};
				wpfpSpanObj = {
					dataTipText: wpfpScriptObj.wpfp_question_name_description_text,
				};
				wooProductFinderProScripts.createTrTagHTML(wpfpTbody, wpfpLabelObj, wpfpInputObj, wpfpSpanObj);

				// Input text box.
				wpfpLabelObj = {
					wpfpLabelFor: 'question_type',
					wpfpLabelText: wpfpScriptObj.wpfp_question_type_text,
				};
				wpfpInputObj = {
					inputType: 'select',
					inputClass: '',
					inputID: 'question_type',
					inputName: wpfpQuestionType,
					wpfpSelect2: true,
					dataSearch: wpfpScriptObj.wpfp_question_type_search_infinity_text,
					selectOption: {
						radio: wpfpScriptObj.wpfp_question_type_text_option_radio,
						checkbox: wpfpScriptObj.wpfp_question_type_text_option_checkbox,
					},
				};
				wpfpSpanObj = {
					dataTipText: wpfpScriptObj.wpfp_question_type_description_text,
				};
				wooProductFinderProScripts.createTrTagHTML(wpfpTbody, wpfpLabelObj, wpfpInputObj, wpfpSpanObj);

				// Option header title div tag.
				wpfpDivObj = {
					class: 'wpfp-option-header-title',
					id: wpfpOptionHeaderTitleID,
					dataOptionListed: 1,
				};
				wpfpOptionHeaderDiv = wooProductFinderProScripts.createDivTagHTML(wpfpQuestionWrapper, wpfpDivObj);

				wpfpOptionID = 1;

				// Option ids.
				wpfpDeleteID = 'wpfp_remove_option_' + wpfpWizardID + '_' + wpfpQuestionID + '_' + wpfpOptionID;
				wpfpToggleID = 'wpfp_btn_toggle_' + wpfpWizardID + '_' + wpfpQuestionID + '_' + wpfpOptionID;
				wpfpToggleAttr = 'wpfp-option-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID + '-' + wpfpOptionID;
				wpfpOptionBoxDivID = 'wpfp-options-box-' + wpfpWizardID + '-' + wpfpQuestionID + '-' + wpfpOptionID;

				// H3 section
				wpfpH3Obj = {
					text: wpfpScriptObj.wpfp_manage_option_text,
					class: 'wpfp-manage-option-h3',
				};
				wpfpH3 = wooProductFinderProScripts.createH3TagHTML(wpfpOptionHeaderDiv, wpfpH3Obj);

				// Option div tag.
				wpfpNewOptionATag = {
					class: 'wpfp-btn wpfp-add-new-option',
					href: 'javascript:void(0)',
					id: wpfpToggleID,
					text: wpfpScriptObj.wpfp_add_new_option_text,
					dataQuestionToggleID: wpfpAddNewOptionID,
				};
				wooProductFinderProScripts.createATagHTML(wpfpH3, wpfpNewOptionATag);

				// Option box div tag.
				wpfpDivObj = {
					class: 'wpfp-options-box',
					id: wpfpOptionBoxDivID,
					dataOptionID: wpfpOptionID,
				};
				wpfpOptionMainDiv = wooProductFinderProScripts.createDivTagHTML(wpfpOptionHeaderDiv, wpfpDivObj);

				// H3 tag
				wpfpH3Obj = {
					text: wpfpScriptObj.wpfp_option_text,
					wpfpWrap: true,
				};
				wpfpH3 = wooProductFinderProScripts.createH3TagHTML(wpfpOptionMainDiv, wpfpH3Obj);

				// Delete A tag.
				wpfpOptionDeleteATag = {
					class: 'wpfp-option-delete delete',
					href: 'javascript:void(0)',
					id: wpfpDeleteID,
					text: wpfpScriptObj.wpfp_delete_text,
					dataQuestionID: wpfpQuestionID,
					dataOptionID: wpfpOptionID,
				};
				wooProductFinderProScripts.createATagHTML(wpfpH3, wpfpOptionDeleteATag);

				// Toggle A tag.
				wpfpOptionToggleATag = {
					class: 'handlediv wpfp-option-toggle toggle',
					href: 'javascript:void(0)',
					id: wpfpToggleID,
					dataToggle: wpfpToggleAttr,
				};
				wooProductFinderProScripts.createATagHTML(wpfpH3, wpfpOptionToggleATag);

				// Question wrapper Div tab.
				wpfpDivObj = {
					class: 'wpfp-tips wpfp-option-tips wpfp-sort',
				};
				wooProductFinderProScripts.createDivTagHTML(wpfpH3, wpfpDivObj);

				// Option wrapper Div tag.
				wpfpDivObj = {
					class: 'wpfp-option-wrapper',
					id: wpfpToggleAttr,
					dataQuestionID: wpfpQuestionID,
					dataOptionID: wpfpOptionID,
				};
				wpfpOptionWrapper = wooProductFinderProScripts.createDivTagHTML(wpfpOptionMainDiv, wpfpDivObj);

				// Table tag.
				wpfpTableObj = {
					class: 'form-table table-outer product-fee-table',
					id: 'option_section',
				};
				wpfpTable = wooProductFinderProScripts.createTableTagHTML(wpfpOptionWrapper, wpfpTableObj);
				wooProductFinderProScripts.createOptionHTML(wpfpTable, wpfpWizardID, wpfpQuestionID, wpfpOptionID);
				wpfpQuestionMainListingSelector.attr('data-question-listed', wpfpQuestionID);
				wooProductFinderProScripts.loadSortableScripts();

				if ('false' === wpfpScriptObj.can_use_premium_code) {
					if (1 < parseInt($('.wpfp-question-main-listing .wpfp-question-main-wrapper').length)) {
						$(this).addClass('button-primary wpfp-list-button is_disabled');
						return false;
					}
				}
			});
		},
		addNewOptionHTML: function() {
			$(document).on('click', '.wpfp-add-new-option', function(e) {
				var wpfpCurrentQuestionID = $(this).data('question-toggle-id'),
					wpfpWizardID = wooProductFinderProScripts.getWizardId(),
					wpfpOptionHeaderTitleSelector = $('div#wpfp-option-header-title-' + wpfpWizardID + '-' + wpfpCurrentQuestionID),
					wpfpOptionID = parseInt(wpfpOptionHeaderTitleSelector.attr('data-option-listed')) + 1,
					wpfpToggleID = 'wpfp_btn_toggle_' + wpfpWizardID + '_' + wpfpCurrentQuestionID + '_' + wpfpOptionID,
					wpfpToggleAttr = 'wpfp-option-wrapper-' + wpfpWizardID + '-' + wpfpCurrentQuestionID + '-' + wpfpOptionID,
					wpfpDeleteID = 'wpfp_remove_option_' + wpfpWizardID + '_' + wpfpCurrentQuestionID + '_' + wpfpOptionID,
					wpfpOptionBoxDivID = 'wpfp-options-box-' + wpfpWizardID + '-' + wpfpCurrentQuestionID + '-' + wpfpOptionID,
					wpfpTable,
					wpfpH3,
					wpfpOptionMainDiv,
					wpfpOptionWrapper,
					wpfpDivObj,
					wpfpH3Obj,
					wpfpOptionToggleATag,
					wpfpOptionDeleteATag,
					wpfpTableObj;

				// Option box div tag.
				wpfpDivObj = {
					class: 'wpfp-options-box',
					id: wpfpOptionBoxDivID,
					dataOptionID: wpfpOptionID,
				};
				wpfpOptionMainDiv = wooProductFinderProScripts.createDivTagHTML('div#wpfp-question-main-wrapper-' + wpfpWizardID + '-' + wpfpCurrentQuestionID + ' .wpfp-option-header-title', wpfpDivObj);

				// H3 tag.
				wpfpH3Obj = {
					text: wpfpScriptObj.wpfp_option_text,
					wpfpWrap: true,
				};
				wpfpH3 = wooProductFinderProScripts.createH3TagHTML(wpfpOptionMainDiv, wpfpH3Obj);

				// Option wrapper div tag.
				wpfpDivObj = {
					class: 'wpfp-option-wrapper',
					id: wpfpToggleAttr,
					dataQuestionID: wpfpCurrentQuestionID,
					dataOptionID: wpfpOptionID,
				};
				wpfpOptionWrapper = wooProductFinderProScripts.createDivTagHTML(wpfpOptionMainDiv, wpfpDivObj);

				// Delete a tag.
				wpfpOptionDeleteATag = {
					class: 'wpfp-option-delete delete',
					href: 'javascript:void(0)',
					id: wpfpDeleteID,
					text: wpfpScriptObj.wpfp_delete_text,
					dataQuestionID: wpfpCurrentQuestionID,
					dataOptionID: wpfpOptionID,
				};
				wooProductFinderProScripts.createATagHTML(wpfpH3, wpfpOptionDeleteATag);

				// Toggle A tag.
				wpfpOptionToggleATag = {
					class: 'handlediv wpfp-option-toggle toggle',
					href: 'javascript:void(0)',
					id: wpfpToggleID,
					dataToggle: wpfpToggleAttr,
				};
				wooProductFinderProScripts.createATagHTML(wpfpH3, wpfpOptionToggleATag);

				// Question wrapper Div tab.
				wpfpDivObj = {
					class: 'wpfp-tips wpfp-option-tips wpfp-sort',
				};
				wooProductFinderProScripts.createDivTagHTML(wpfpH3, wpfpDivObj);

				// Table tag.
				wpfpTableObj = {
					class: 'form-table table-outer product-fee-table',
					id: 'option_section',
				};
				wpfpTable = wooProductFinderProScripts.createTableTagHTML(wpfpOptionWrapper, wpfpTableObj);
				wooProductFinderProScripts.createOptionHTML(wpfpTable, wpfpWizardID, wpfpCurrentQuestionID, wpfpOptionID);
				wpfpOptionHeaderTitleSelector.attr('data-option-listed', wpfpOptionID);
				wooProductFinderProScripts.loadSortableScripts();
			});
		},
		createOptionHTML: function(wpfpTable, wpfpWizardID, wpfpQuestionID, wpfpOptionID) {
			var wpfpTbody = $('<tbody/>').appendTo(wpfpTable),
				wpfpLabelObj,
				wpfpInputObj,
				wpfpSpanObj,

				// Option elements ids.
				wpfpOptionName = 'wpfp[options][name][' + wpfpWizardID + '][' + wpfpQuestionID + '][' + wpfpOptionID + ']',
				wpfpOptionAttributeName = 'wpfp[options][attribute_name][' + wpfpWizardID + '][' + wpfpQuestionID + '][' + wpfpOptionID + ']',
				wpfpOptionAttributeValue = 'wpfp[options][attribute_value][' + wpfpWizardID + '][' + wpfpQuestionID + '][' + wpfpOptionID + ']',
				wpfpOptionAttributeKey = 'wpfp[options][key][' + wpfpWizardID + '][' + wpfpQuestionID + '][' + wpfpOptionID + ']';

			wpfpLabelObj = {
				wpfpLabelFor: 'option_title',
				wpfpLabelText: wpfpScriptObj.wpfp_option_title_text,
				wpfpIsRequired: true,
			};
			wpfpInputObj = {
				inputType: 'text',
				inputClass: 'text-class half_width wpfp-field-required',
				inputID: 'option_name',
				inputName: wpfpOptionName,
				inputRequired: true,
				inputPlaceHolder: wpfpScriptObj.wpfp_option_title_input_placeholder_text,
				inputHiddenField: {
					type: 'hidden',
					name: wpfpOptionAttributeKey,
					id: 'option_field_key',
					value: wooProductFinderProScripts.uniqID('option_field_'),
				},
			};
			wpfpSpanObj = {
				dataTipText: wpfpScriptObj.wpfp_option_title_description_text,
			};
			wooProductFinderProScripts.createTrTagHTML(wpfpTbody, wpfpLabelObj, wpfpInputObj, wpfpSpanObj);

			wpfpLabelObj = {
				wpfpLabelFor: 'option_uploader',
				wpfpLabelText: wpfpScriptObj.wpfp_option_image_text,
			};
			if ('true' === wpfpScriptObj.can_use_premium_code) {
				wpfpInputObj = {
					inputType: 'a',
					elementCount: 2,
					aTagElement: {
						aTag1: {
							class: 'option_uploader_image button',
							id: 'option_uploader_image_id',
							aTagUploaderTitle: wpfpScriptObj.wpfp_option_image_uploader_title_text,
							aTagUploaderButtonText: wpfpScriptObj.wpfp_option_image_uploader_button_text,
							aTagUploaderName: 'option_single_upload_file',
							text: wpfpScriptObj.wpfp_option_image_uploader_text,
						},
						aTag2: {
							class: 'option_remove_image button',
							id: 'option_remove_image_id',
							aTagUploaderName: 'option_single_upload_file',
							text: wpfpScriptObj.wpfp_option_image_remove_text,
						},
					},
					dataQuestionID: wpfpQuestionID,
					dataOptionID: wpfpOptionID,
					previewElement: true,
				};
			} else {
				wpfpInputObj = {
					inputType: 'a',
					elementCount: 2,
					aTagElement: {
						aTag1: {
							isDisabled: true,
							class: 'is_disabled button',
							text: wpfpScriptObj.wpfp_option_image_uploader_text,
						},
						aTag2: {
							isDisabled: true,
							class: 'is_disabled button',
							text: wpfpScriptObj.wpfp_option_image_remove_text,
						},
					},
					dataQuestionID: wpfpQuestionID,
					dataOptionID: wpfpOptionID,
					previewElement: true,
				};
			}
			wpfpSpanObj = {
				dataTipText: wpfpScriptObj.wpfp_option_image_description_text,
			};
			wooProductFinderProScripts.createTrTagHTML(wpfpTbody, wpfpLabelObj, wpfpInputObj, wpfpSpanObj);

			wpfpLabelObj = {
				wpfpLabelFor: 'attribute_name',
				wpfpLabelText: wpfpScriptObj.wpfp_option_attribute_name_text,
				wpfpIsRequired: true,
			};
			wpfpInputObj = {
				inputType: 'select',
				inputClass: 'attribute-name wpfp-field-required',
				inputID: 'attribute_name',
				inputPlaceHolder: wpfpScriptObj.wpfp_option_attribute_name_placeholder_text,
				inputName: wpfpOptionAttributeName,
				inputRequired: true,
				selectOption: {},
				wpfpSelect2Ajax: true,
				inputMinimumInputLenght: 3,
				inputAllowClear: true,
				nonceSecurity: wpfpScriptObj.wpfp_script_nonce,
				dataQuestionID: wpfpQuestionID,
				dataOptionID: wpfpOptionID,
			};
			wpfpSpanObj = {
				dataTipText: wpfpScriptObj.wpfp_option_attribute_name_description_text,
			};
			wooProductFinderProScripts.createTrTagHTML(wpfpTbody, wpfpLabelObj, wpfpInputObj, wpfpSpanObj);

			wpfpLabelObj = {
				wpfpLabelFor: 'attributr_value',
				wpfpLabelText: wpfpScriptObj.wpfp_option_attribute_value_text,
				wpfpIsRequired: true,
			};
			wpfpInputObj = {
				inputType: 'select',
				inputClass: 'attribute-value wpfp-field-required',
				inputID: 'attribute_value',
				inputPlaceHolder: wpfpScriptObj.wpfp_option_attribute_value_placeholder_text,
				inputName: wpfpOptionAttributeValue,
				wpfpSelect2: true,
				inputRequired: true,
				multiple: true,
				dataQuestionID: wpfpQuestionID,
				dataOptionID: wpfpOptionID,
			};
			wpfpSpanObj = {
				dataTipText: wpfpScriptObj.wpfp_option_attribute_value_description_text,
			};
			wooProductFinderProScripts.createTrTagHTML(wpfpTbody, wpfpLabelObj, wpfpInputObj, wpfpSpanObj);
			$(document.body).trigger('init_wpfp_tooltips');
		},
		createTableTagHTML: function(appendToElement, wpfpTableObj) {
			var tableTag = $('<table/>');

			if ('undefined' !== typeof wpfpTableObj.class) {
				tableTag.attr('class', wpfpTableObj.class);
			}
			if ('undefined' !== typeof wpfpTableObj.id) {
				tableTag.attr('id', wpfpTableObj.id);
			}

			return tableTag.appendTo(appendToElement);
		},
		createTrTagHTML: function(appendToElement, wpfpLabelObj, wpfpInputObj, wpfpSpanObj) {
			var wpfpTR, wpfpTH, wpfpTD;
			wpfpTR = $('<tr/>').appendTo(appendToElement);
			wpfpTH = $('<th/>', {class: 'titledesc'}).appendTo(wpfpTR);
			if (true === wpfpInputObj.inputRequired) {
				wpfpTD = $('<td/>', {class: 'forminp mdtooltip wpfp-required'}).appendTo(wpfpTR);
			} else {
				wpfpTD = $('<td/>', {class: 'forminp mdtooltip'}).appendTo(wpfpTR);
			}

			wooProductFinderProScripts.createThTagHTML(wpfpTH, wpfpLabelObj);
			wooProductFinderProScripts.createTdTahHTML(wpfpTD, wpfpInputObj, wpfpSpanObj);
		},
		createThTagHTML: function(appendToElement, wpfpLabelObj) {
			var wpfpLabel = $('<label/>', {for: wpfpLabelObj.wpfpLabelFor, text: wpfpLabelObj.wpfpLabelText}).appendTo(appendToElement);
			if (true === wpfpLabelObj.wpfpIsRequired) {
				$('<span/>', {class: 'required-star', text: '*'}).appendTo(wpfpLabel);
			}
		},
		createTdTahHTML: function(appendToElement, wpfpInputObj, wpfpSpanObj) {
			var wpfpInput,
				wpfpSelect,
				wpfpSelect2Woo,
				wpfpExtraDivWrapper,
				wpfpDivObj,
				wpfpExtraData;

			if ('undefined' !== typeof wpfpInputObj.inputType) {

				if ('text' === wpfpInputObj.inputType) {
					wpfpInput = $('<input/>');
					if ('undefined' !== typeof wpfpInputObj.inputType) {
						wpfpInput.attr('type', wpfpInputObj.inputType);
					}
					if ('undefined' !== typeof wpfpInputObj.inputName) {
						wpfpInput.attr('name', wpfpInputObj.inputName);
					}

					if ('undefined' !== typeof wpfpInputObj.inputClass) {
						wpfpInput.attr('class', wpfpInputObj.inputClass);
					}

					if ('undefined' !== typeof wpfpInputObj.inputID) {
						wpfpInput.attr('id', wpfpInputObj.inputID);
					}

					if ('undefined' !== typeof wpfpInputObj.inputRequired) {
						wpfpInput.attr('placeholder', wpfpInputObj.inputPlaceHolder);
					}

					if ('undefined' !== typeof wpfpInputObj.inputHiddenField) {
						$('<input/>', wpfpInputObj.inputHiddenField).appendTo(appendToElement);
					}

					wpfpInput.appendTo(appendToElement);

				} else if ('select' === wpfpInputObj.inputType) {

					wpfpSelect = $('<select/>').appendTo(appendToElement);

					if ('undefined' !== typeof wpfpInputObj.inputName) {
						if ('undefined' !== typeof wpfpInputObj.multiple) {
							wpfpSelect.attr('multiple', wpfpInputObj.multiple);
							wpfpSelect.attr('name', wpfpInputObj.inputName + '[]');
						} else {
							wpfpSelect.attr('name', wpfpInputObj.inputName);
						}
					}

					if ('undefined' !== typeof wpfpInputObj.inputID) {
						wpfpSelect.attr('id', wpfpInputObj.inputID);
					}

					if ('undefined' !== typeof wpfpInputObj.inputClass) {
						wpfpSelect.attr('class', wpfpInputObj.inputClass);
					}

					if ('undefined' !== typeof wpfpInputObj.inputPlaceHolder) {
						wpfpSelect.attr('data-placeholder', wpfpInputObj.inputPlaceHolder);
						wpfpSelect2Woo = {placeholder: wpfpInputObj.inputPlaceHolder};
					}

					if ('undefined' !== typeof wpfpInputObj.inputMinimumInputLenght) {
						wpfpSelect.attr('data-minimum-input-length', wpfpInputObj.inputMinimumInputLenght);
						wpfpSelect2Woo = {minimumInputLength: wpfpInputObj.inputMinimumInputLenght ? wpfpInputObj.inputMinimumInputLenght : '1'};
					}

					if ('undefined' !== typeof wpfpInputObj.inputAllowClear) {
						wpfpSelect.attr('data-allow-clear', wpfpInputObj.inputAllowClear);
						wpfpSelect2Woo = {allowClear: wpfpInputObj.inputAllowClear};
					}

					if ('undefined' !== typeof wpfpInputObj.inputRequired) {
						wpfpSelect.attr('required', wpfpInputObj.inputRequired);
					}

					if ('undefined' !== typeof wpfpInputObj.nonceSecurity) {
						wpfpSelect.attr('data-nonce', wpfpInputObj.nonceSecurity);

					}

					if ('undefined' !== typeof wpfpInputObj.dataQuestionID) {
						wpfpSelect.attr('data-question-id', wpfpInputObj.dataQuestionID);

					}
					if ('undefined' !== typeof wpfpInputObj.dataOptionID) {
						wpfpSelect.attr('data-option-id', wpfpInputObj.dataOptionID);

					}
					if ('undefined' !== typeof wpfpInputObj.dataSearch) {
						wpfpSelect.attr('data-minimum-results-for-search', wpfpInputObj.dataSearch);
					}

					wpfpSelect.appendTo(appendToElement);
					if ('undefined' !== typeof wpfpInputObj.selectOption) {
						$.each(wpfpInputObj.selectOption, function(wpfpKey, wpfpVal) {
							if ('false' === wpfpScriptObj.can_use_premium_code && 'checkbox' === wpfpKey) {
								$('<option></option>', {value: wpfpKey, text: wpfpVal, disabled: true}).appendTo(wpfpSelect);
							} else {
								$('<option></option>', {value: wpfpKey, text: wpfpVal}).appendTo(wpfpSelect);
							}
						});
					}

					if (true === wpfpInputObj.wpfpSelect2Ajax) {
						wpfpSelect2Woo = $.extend(wpfpSelect2Woo, wooProductFinderProScripts.wpfpSelectWooScript(true));
						wpfpSelect.selectWoo(wpfpSelect2Woo).addClass('enhanced');
					}
					if (true === wpfpInputObj.wpfpSelect2) {
						wpfpSelect2Woo = $.extend(wpfpSelect2Woo, wooProductFinderProScripts.wpfpSelectWooScript());
						wpfpSelect.selectWoo(wpfpSelect2Woo).addClass('enhanced');
					}

				} else if ('a' === wpfpInputObj.inputType) {

					if ('undefined' !== typeof wpfpInputObj.elementCount) {

						wpfpDivObj = {
							class: 'wpfp-uploader-wrapper',
							dataQuestionID: wpfpInputObj.dataQuestionID,
							dataOptionID: wpfpInputObj.dataOptionID,
						};

						wpfpExtraDivWrapper = wooProductFinderProScripts.createDivTagHTML(appendToElement, wpfpDivObj);

						wpfpExtraData = {
							dataQuestionID: wpfpInputObj.dataQuestionID,
							dataOptionID: wpfpInputObj.dataOptionID,
						};
						if (1 < wpfpInputObj.elementCount) {
							$.each(wpfpInputObj.aTagElement, function(i) {
								wpfpInputObj.aTagElement[i] = $.extend(true, wpfpInputObj.aTagElement[i], wpfpExtraData);
								wooProductFinderProScripts.createATagHTML(wpfpExtraDivWrapper, wpfpInputObj.aTagElement[i]);
							});
						}

						if (wpfpInputObj.previewElement) {

							// Question main wrapper div.
							$('<span/>', {class: 'wpfp-help-tip', 'data-tip': wpfpSpanObj.dataTipText}).appendTo(wpfpExtraDivWrapper);
							wpfpExtraDivWrapper.appendTo(appendToElement);

							wpfpDivObj = {
								class: 'wpfp-image-preview',
								id: 'wpfp-image-preview',
								dataQuestionID: wpfpInputObj.dataQuestionID,
								dataOptionID: wpfpInputObj.dataOptionID,
							};
							wooProductFinderProScripts.createDivTagHTML(appendToElement, wpfpDivObj);
						}
					}
				}
				if ('a' !== wpfpInputObj.inputType) {
					$('<span/>', {class: 'wpfp-help-tip', 'data-tip': wpfpSpanObj.dataTipText}).appendTo(appendToElement);
					if ('undefined' !== typeof wpfpInputObj.inputRequired) {
						$('<p/>', {class: 'wpfp-help-block'}).appendTo(appendToElement);
					}
				}
			}

		},
		createATagHTML: function(appendToElement, aTagElement) {
			var createdATag = $('<a/>');
			if ('undefined' !== typeof aTagElement.text) {
				createdATag.text(aTagElement.text);
			}
			if ('undefined' !== typeof aTagElement.class) {
				createdATag.attr('class', aTagElement.class);
			}
			if ('undefined' !== typeof aTagElement.href) {
				createdATag.attr('href', aTagElement.href);
			}
			if ('undefined' !== typeof aTagElement.id) {
				createdATag.attr('id', aTagElement.id);
			}
			if ('undefined' !== typeof aTagElement.isDisabled) {
				createdATag.attr('disabled', aTagElement.isDisabled);
			}
			if ('undefined' !== typeof aTagElement.dataToggle) {
				createdATag.attr('data-toggle', aTagElement.dataToggle);
			}
			if ('undefined' !== typeof aTagElement.dataQuestionToggleID) {
				createdATag.attr('data-question-toggle-id', aTagElement.dataQuestionToggleID);
			}
			if ('undefined' !== typeof aTagElement.aTagUploaderTitle) {
				createdATag.attr('data-uploader-title', aTagElement.aTagUploaderTitle);
			}
			if ('undefined' !== typeof aTagElement.aTagUploaderButtonText) {
				createdATag.attr('data-uploader-button-text', aTagElement.aTagUploaderButtonText);
			}
			if ('undefined' !== typeof aTagElement.aTagUploaderName) {
				createdATag.attr('data-uploadname', aTagElement.aTagUploaderName);
			}
			if ('undefined' !== typeof aTagElement.dataQuestionID) {
				createdATag.attr('data-question-id', aTagElement.dataQuestionID);
			}
			if ('undefined' !== typeof aTagElement.dataOptionID) {
				createdATag.attr('data-option-id', aTagElement.dataOptionID);
			}
			if ('undefined' !== typeof aTagElement.ariaLabelText) {
				createdATag.attr('aria-label', aTagElement.ariaLabelText);
			}

			createdATag.appendTo(appendToElement);
		},
		createH3TagHTML: function(appendToElement, wpfpH3Obj) {
			var wpfpH3Tag = $('<h3/>');
			var wpfpSpan = $('<span/>', {class: 'wpfp-option-header'});

			if ('undefined' !== typeof wpfpH3Obj.text && true === wpfpH3Obj.wpfpWrap) {
				wpfpSpan.text(wpfpH3Obj.text);
				wpfpSpan.appendTo(wpfpH3Tag);
			} else if ('undefined' !== typeof wpfpH3Obj.text) {
				wpfpH3Tag.text(wpfpH3Obj.text);
			}
			if ('undefined' !== typeof wpfpH3Obj.class) {
				wpfpH3Tag.attr('class', wpfpH3Obj.class);
			}

			return wpfpH3Tag.appendTo(appendToElement);

		},
		createDivTagHTML: function(appendToElement, wpfpDivObj, returnElement = true) {
			var wpfpDiv = $('<div/>');
			if ('undefined' !== typeof wpfpDivObj.class) {
				wpfpDiv.attr('class', wpfpDivObj.class);
			}
			if ('undefined' !== typeof wpfpDivObj.id) {
				wpfpDiv.attr('id', wpfpDivObj.id);
			}
			if ('undefined' !== typeof wpfpDivObj.dataQuestionID) {
				wpfpDiv.attr('data-question-id', wpfpDivObj.dataQuestionID);
			}
			if ('undefined' !== typeof wpfpDivObj.dataOptionID) {
				wpfpDiv.attr('data-option-id', wpfpDivObj.dataOptionID);
			}
			if ('undefined' !== typeof wpfpDivObj.dataOptionListed) {
				wpfpDiv.attr('data-option-listed', wpfpDivObj.dataOptionListed);
			}
			if (true === returnElement) {
				return wpfpDiv.appendTo(appendToElement);
			}
		},
		removeQuestionHTML: function() {
			$(document).on('click', '.wpfp-question-delete', function(e) {
				var wpfpWizardID = wooProductFinderProScripts.getWizardId(),
					wpfpQuestionID = $(this).attr('data-question-id');
				if (confirm(wpfpScriptObj.wpfp_option_image_remove_alert_text)) {

					e.preventDefault();
					$('div#wpfp-question-main-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID).remove();
					if ('false' === wpfpScriptObj.can_use_premium_code) {
						if (1 >= parseInt($('.wpfp-question-main-listing .wpfp-question-main-wrapper').length)) {
							$('.wpfp-manage-question-h2 a').removeClass('button-primary wpfp-list-button is_disabled');
						}
					}
				}
			});
		},
		removeOptionHTML: function() {
			$(document).on('click', '.wpfp-option-delete', function(e) {
				var wpfpWizardID = wooProductFinderProScripts.getWizardId(),
					wpfpQuestionID = $(this).attr('data-question-id'),
					wpfpOptionID = $(this).attr('data-option-id');
				e.preventDefault();
				$('div#wpfp-question-main-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID + ' #wpfp-options-box-' + wpfpWizardID + '-' + wpfpQuestionID + '-' + wpfpOptionID).remove();
			});
		},
		removeWizardOptionImage: function() {
			$(document).on('click', '#option_remove_image_id', function(e) {
				var wpfpWizardID = wooProductFinderProScripts.getWizardId(),
					wpfpQuestionID = $(this).attr('data-question-id'),
					wpfpOptionID = $(this).attr('data-option-id'),
					wpfpSelectorOptionMainWrapperID = 'div#wpfp-option-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID + '-' + wpfpOptionID;
				$(wpfpSelectorOptionMainWrapperID).find('.wpfp-image-preview').empty();
			});
		},
		removeWizardSettingImage: function() {
			$(document).on('click', '#question_background_remove_image_id', function(e) {
				if (confirm(wpfpScriptObj.wpfp_option_image_remove_alert_text)) {
					$('.question_background_image_section').find('.wpfp-image-preview').empty();
					$(this).remove();
				}
			});
		},
		deleteSingleWizard: function() {
			$(document).on('click', '.delete_single_selected_wizard', function(e) {
				if (false === confirm(wpfpScriptObj.wpfp_wizard_delete_alert_text)) {
					e.preventDefault();
					return false;
				}
			});
		},
		deleteMultipleWizard: function() {
			$(document).on('click', '#detete_all_selected_wizard', function(e) {
				if (true === confirm(wpfpScriptObj.wpfp_wizard_delete_alert_text)) {
					$('#wpfp-wizard-list-form').submit();
				}
			});
		},
		submitAddNewWizard: function() {
			$(document).on('click', '#submit_wizard', function() {
				var wpfpFormSubmit = true;
				$($(this).closest('.wpfp-wizard-form').find('.wpfp-field-required')).each(function(index, value) {
					var wpfpWizardEditForm = $(this).closest('.wpfp-wizard-form'),
						wpfpRequiredFieldName = $(this).attr('name'),
						wpfpRequiredFieldType = $(this).prop('type'),
						wpfpWizardID = $('#wizard_post_id').val(),
						wpfpInputRequiredField = 'input[name="' + wpfpRequiredFieldName + '"]',
						wpfpSelectRequiredField = 'select[name="' + wpfpRequiredFieldName + '"]',
						wpfpQuestionID = $(this).closest('.wpfp-wizard-form').find(wpfpInputRequiredField).closest('.wpfp-question-main-wrapper').attr('data-question-id'),
						wpfpOptionId = $(this).closest('.wpfp-wizard-form').find(wpfpInputRequiredField).closest('.wpfp-options-box').attr('data-option-id'),
						wpfpQuestionWrapperID = '#wpfp-question-main-wrapper-' + wpfpWizardID + '-' + wpfpQuestionID,
						wpfpOptionBoxId = '#wpfp-options-box-' + wpfpWizardID + '-' + wpfpQuestionID + '-' + wpfpOptionId,
						wpfpSelectQuestionID = $(this).closest('.wpfp-wizard-form').find(wpfpSelectRequiredField).closest('.wpfp-question-main-wrapper').attr('data-question-id'),
						wpfpSelectOptionId = $(this).closest('.wpfp-wizard-form').find(wpfpSelectRequiredField).closest('.wpfp-options-box').attr('data-option-id'),
						wpfpSelectOptionBoxId = '#wpfp-options-box-' + wpfpWizardID + '-' + wpfpSelectQuestionID + '-' + wpfpSelectOptionId,
						wpdpQuestionString = 'questions',
						wpdpOptionString = 'options',
						isQuestion = false,
						isOption = false,
						wpfpInputRequiredFieldValue = $(wpfpInputRequiredField).val(),
						wpfpCurrentElementValidation = wpfpWizardEditForm.find(wpfpInputRequiredField).closest('.wpfp-required'),
						wpfpCurrentSelectElementValidation = wpfpWizardEditForm.find(wpfpSelectRequiredField).closest('.wpfp-required');

					if (-1 !== wpfpRequiredFieldName.indexOf(wpdpQuestionString)) {
						isQuestion = true;
					}

					if (-1 !== wpfpRequiredFieldName.indexOf(wpdpOptionString)) {
						isOption = true;
					}

					if ('' === $(this).val()) {
						if ('undefined' !== typeof wpfpQuestionID && '' === wpfpInputRequiredFieldValue && true === isQuestion) {
							wpfpWizardEditForm.find(wpfpInputRequiredField).closest(wpfpQuestionWrapperID).addClass('wpfp-has-box-error wpfp-has-question-box-error');
						} else if ('undefined' !== typeof wpfpQuestionID && 'undefined' !== typeof wpfpOptionId && '' === wpfpInputRequiredFieldValue && true === isOption) {
							wpfpWizardEditForm.find(wpfpInputRequiredField).closest(wpfpOptionBoxId).addClass('wpfp-has-box-error wpfp-has-option-box-error');
						} else {
							wpfpWizardEditForm.find(wpfpInputRequiredField).addClass('wpfp-has-box-error');
						}
						wpfpCurrentElementValidation.addClass('wpfp-has-error').find('.wpfp-help-block').text(wpfpScriptObj.wpfp_validation_text);
						wpfpFormSubmit = false;
					} else {
						if ('undefined' !== typeof wpfpQuestionID && '' !== wpfpInputRequiredFieldValue && true === isQuestion) {
							wpfpWizardEditForm.find(wpfpInputRequiredField).closest(wpfpQuestionWrapperID).removeClass('wpfp-has-box-error wpfp-has-question-box-error');
						} else if ('undefined' !== typeof wpfpQuestionID && 'undefined' !== typeof wpfpOptionId && '' !== wpfpInputRequiredFieldValue && true === isOption) {
							wpfpWizardEditForm.find(wpfpInputRequiredField).closest(wpfpOptionBoxId).removeClass('wpfp-has-box-error wpfp-has-option-box-error');
						} else {
							wpfpWizardEditForm.find(wpfpInputRequiredField).removeClass('wpfp-has-box-error');
						}
						wpfpCurrentElementValidation.removeClass('wpfp-has-error').find('.wpfp-help-block').empty();
					}

					/**
					 * Select2 option validation.
					 */
					if ('select-one' === wpfpRequiredFieldType || 'select-multiple' === wpfpRequiredFieldType) {
						if (null === $(wpfpSelectRequiredField).val() && $(wpfpSelectRequiredField).attr('required')) {
							wpfpCurrentSelectElementValidation.addClass('wpfp-has-error').find('.wpfp-help-block').text(wpfpScriptObj.wpfp_validation_text);
							wpfpWizardEditForm.find(wpfpSelectRequiredField).closest(wpfpSelectOptionBoxId).addClass('wpfp-has-box-error wpfp-has-option-box-error');
							wpfpFormSubmit = false;
						} else {
							wpfpCurrentSelectElementValidation.removeClass('wpfp-has-error').find('.wpfp-help-block').empty();
							wpfpWizardEditForm.find(wpfpSelectRequiredField).closest(wpfpSelectOptionBoxId).removeClass('wpfp-has-box-error wpfp-has-option-box-error');
						}
					}
				});

				if (false === wpfpFormSubmit) {

					return false;
				}
				return wpfpFormSubmit;
			});

		},
		wpfpImageUploader: function(wpfpUploaderObj) {
			var wpfpFileFrame, wpfpImageTag, wpfpImageInputHiddenTag;
			if (wpfpFileFrame) {
				wpfpFileFrame.open();
				return;
			}

			wpfpFileFrame = wp.media.frames.wpfpFileFrame = wp.media({
				title: wpfpUploaderObj.title,
				button: {
					text: wpfpUploaderObj.text,
				},
				library: {
					type: ['image'],
				},
				multiple: false,
			});

			// When an image is selected in the media frame...
			wpfpFileFrame.on('select', function() {

				// Get media attachment details from the frame state
				var wpfpSelectedImage = wpfpFileFrame.state().get('selection').first().toJSON();
				var wpfpSelectedImageName = wpfpSelectedImage.filename;
				var wpfpFileExtension = wpfpSelectedImageName.substr((wpfpSelectedImageName.lastIndexOf('.') + 1));
				if ('' !== wpfpSelectedImage.url) {
					if (-1 === $.inArray(wpfpFileExtension, ['gif', 'png', 'jpg', 'jpeg'])) {
						alert(wpfpScriptObj.wpfp_image_required_format_text);
					} else {
						wpfpImageTag = $('<img/>', {
							'src': wpfpSelectedImage.url,
							'data-id': wpfpSelectedImage.id,
							'alt': (wpfpSelectedImage.alt) ? wpfpSelectedImage.alt : wpfpSelectedImage.title,
							'width': '100px',
							'height': '100px',
						});

						wpfpImageInputHiddenTag = $('<input/>', {
							type: 'hidden',
							name: wpfpUploaderObj.inputTagName,
							id: wpfpUploaderObj.inputTagID,
							value: wpfpSelectedImage.id,
						});

						$('#question_background_remove_image_id').remove();

						$('<a>', {
							class: 'option_single_remove_file button',
							id: 'question_background_remove_image_id',
							text: wpfpScriptObj.wpfp_option_image_remove_text,
							'data-uploadname': 'question_background_upload_file',
						}).insertAfter('#question_background_uploader_image_id');

						$(wpfpUploaderObj.imgSelector).find('.wpfp-image-preview').empty();
						wpfpImageTag.appendTo($(wpfpUploaderObj.imgSelector).find('.wpfp-image-preview'));
						wpfpImageInputHiddenTag.appendTo($(wpfpUploaderObj.imgSelector).find('.wpfp-image-preview'));

					}
				}
			});
			wpfpFileFrame.open();
		},
		wpfpSelectWooScript: function(wpfpAjax = false) {
			var wpfpResponseData, wpfpTemplateSelectionResult;
			if (true !== wpfpAjax) {
				return {
					escapeMarkup: function(m) {
						return m;
					},
				};
			}

			return {
				escapeMarkup: function(m) {
					return m;
				},
				templateSelection: function(wpfpContainer) {
					if (wpfpContainer.id) {
						wpfpTemplateSelectionResult = wpfpContainer.id.split(',');
						if (wpfpTemplateSelectionResult[0]) {
							$(wpfpContainer.element).val(wpfpTemplateSelectionResult[0]);
						}
						if (wpfpTemplateSelectionResult[1]) {
							$(wpfpContainer.element).attr('data-name', wpfpTemplateSelectionResult[1]);
						}
						if (wpfpTemplateSelectionResult[2]) {
							$(wpfpContainer.element).attr('data-value', wpfpTemplateSelectionResult[2]);
						}
					}
					return wpfpContainer.text;
				},
				ajax: {
					url: wpfpScriptObj.wpfp_ajax_url,
					dataType: 'json',
					delay: 1000,
					data: function(params) {
						return {
							'searchQueryParameter': params.term,
							action: 'wpfp_search_attribute_name',
							wizardID: wooProductFinderProScripts.getWizardId(),
							security: $(this).data('nonce'),
						};
					},
					processResults: function(data, container) {
						wpfpResponseData = [];
						if (data) {
							$.each(data, function(id, responseObj) {
								wpfpResponseData.push({
									id: responseObj.value + ',' + responseObj.data_name + ',' + responseObj.data_value,
									text: responseObj.label,
								});
							});
						}
						return {
							results: wpfpResponseData,
						};
					},
					cache: true,
				},
			};
		},
		wizardCheckBoxChecked: function() {
			$('.chk_all_wizard_class').on('click', function() {
				$('input.chk_single_wizard:checkbox').not(this).prop('checked', this.checked);
				if (true === this.checked) {
					$('#detete_all_selected_wizard').removeAttr('disabled');
				} else {
					$('#detete_all_selected_wizard').attr('disabled', true);
				}
			});

			$('.chk_single_wizard').on('click', function() {
				var isChecked = false,
					singleCheckbox = $('input.chk_single_wizard:checked');

				singleCheckbox.each(function(index, element) {
					if (true === element.checked) {
						isChecked = true;
					}
				});

				if ($('input.chk_single_wizard').length === singleCheckbox.length) {
					$('input.chk_all_wizard_class').prop('checked', true);
				} else {
					$('input.chk_all_wizard_class').prop('checked', false);
				}

				if (true === isChecked) {
					$('#detete_all_selected_wizard').removeAttr('disabled');
				} else {
					$('#detete_all_selected_wizard').attr('disabled', true);
					$('input.chk_all_wizard_class').prop('checked', this.checked);
				}
			});
		},
	};

	/**
	 *  uniqid
	 *
	 *  Returns a unique ID (PHP version)
	 *
	 *  @date	9/11/17
	 *  @since	5.6.3
	 *  @source	http://locutus.io/php/misc/uniqid/
	 *
	 *  @param	string prefix Optional prefix.
	 *  @return	string
	 */

	var uniqidSeed = '';
	wooProductFinderProScripts.uniqID = function(prefix, moreEntropy) {
		var retId, formatSeed;

		//  discuss at: http://locutus.io/php/uniqid/
		// original by: Kevin van Zonneveld (http://kvz.io)
		//  revised by: Kankrelune (http://www.webfaktory.info/)
		//      note 1: Uses an internal counter (in locutus global) to avoid collision
		//   example 1: var $id = uniqid()
		//   example 1: var $result = $id.length === 13
		//   returns 1: true
		//   example 2: var $id = uniqid('foo')
		//   example 2: var $result = $id.length === (13 + 'foo'.length)
		//   returns 2: true
		//   example 3: var $id = uniqid('bar', true)
		//   example 3: var $result = $id.length === (23 + 'bar'.length)
		//   returns 3: true
		if ('undefined' === typeof prefix) {
			prefix = '';
		}

		formatSeed = function(seed, reqWidth) {
			seed = parseInt(seed, 10).toString(16); // to hex str
			if (reqWidth < seed.length) { // so long we split
				return seed.slice(seed.length - reqWidth);
			}
			if (reqWidth > seed.length) { // so short we pad
				return Array(1 + (reqWidth - seed.length)).join('0') + seed;
			}
			return seed;
		};

		if ( !uniqidSeed) { // init seed with big random int
			uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
		}
		uniqidSeed++;

		retId = prefix; // start with prefix, add current milliseconds hex string
		retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
		retId += formatSeed(uniqidSeed, 5); // add seed hex string
		if (moreEntropy) {

			// for more entropy we add a float lower to 10
			retId += (Math.random() * 10).toFixed(8).toString();
		}

		return retId;
	};

	$(document).ready(wooProductFinderProScripts.init);
	$(window).on({
		'load': wooProductFinderProScripts.load,
		'resize': wooProductFinderProScripts.resize,
		'scroll': wooProductFinderProScripts.scroll,
	});
})(jQuery, window, document);