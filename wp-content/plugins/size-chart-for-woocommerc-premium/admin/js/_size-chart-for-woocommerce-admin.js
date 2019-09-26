/*
 * Custom Script file
 */
(function($, window, document) {
	'use strict';
	var searchTimer;
	var sizeChartScripts = {
		init: function() {
			sizeChartScripts.loadChartCategorySelect2();
			sizeChartScripts.loadProductChartSelect2();
			sizeChartScripts.loadColorPicker();
			sizeChartScripts.loadPreviewSizeChart();
			sizeChartScripts.loadSizeChartProductMetaColumn();
			sizeChartScripts.loadSizeChartProductMetaAjax();
			sizeChartScripts.deleteSizeChartImage();
			sizeChartScripts.closeSizeChartModal();
			sizeChartScripts.requiredSizeChartTitle();

		},
		loadChartCategorySelect2: function() {
			$('#chart-categories').select2({
				maximumSelectionLength: 100,
			});
		},
		loadProductChartSelect2: function() {

			// Ajax customer search boxes
			$(':input#prod-chart').filter(':not(.enhanced)').each(function() {
				var terms = [];
				var select2Args = {
					allowClear: $(this).data('allow_clear') ? true : false,
					placeholder: $(this).data('placeholder'),
					minimumInputLength: $(this).data('minimum_input_length') ? $(this).data('minimum_input_length') : '1',
					escapeMarkup: function(m) {
						return m;
					},
					ajax: {
						url: sizeChartScriptObject.size_chart_admin_url,
						dataType: 'json',
						delay: 1000,
						data: function(params) {
							return {
								'searchQueryParameter': params.term,
								action: 'size_chart_search_chart',
								security: $(this).data('nonce'),
								exclude: $(this).data('exclude'),
							};
						},
						processResults: function(data) {
							terms = [];
							if (data) {
								$.each(data, function(id, text) {
									terms.push({
										id: id,
										text: text,
									});
								});
							}
							return {
								results: terms,
							};
						},
						cache: true,
					},
				};

				$(this).selectWoo(select2Args).addClass('enhanced');

			});
		},
		loadColorPicker: function() {
			$('#color-picker1,#color-picker2,#color-picker3,#color-picker4,#color-picker5,#color-picker6').wpColorPicker();
		},
		loadPreviewSizeChart: function() {

			// Preview Chart.
			$('a.preview_chart').click(function() {
				var data = {},
chartID = $(this).attr('id'),
modal = '';
				$('.size-chart-model').css('padding', '0');
				$('#wait').show();
				$('[data-remodal-id=modal]').html('');
				data = {
					'action': 'size_chart_preview_post',
					chartID: chartID,
					'security': sizeChartScriptObject.size_chart_nonce,
				};

				$.ajax({
					type: 'GET',
					url: sizeChartScriptObject.size_chart_admin_url,
					data: data,
					beforeSend: function() {
						$('#wait').css('position', 'fixed').show();
					}, complete: function() {
						$('#wait').hide();
					}, success: function(response) {
						var result = $.parseJSON(response);

						if (1 === result.success) {
							$('.size-chart-model').css('padding', '35px');
							modal = document.getElementById('md-size-chart-modal');
							modal.style.display = 'block';
							$('#md-poup').after(result.html);
							$('#size-chart-for-woocommerce-inline-css').text(result.css);
						} else {
							alert('size-chart-for-woocommerc-premium==>' + result.msg);
						}
					},
				});
			});
		},
		loadSizeChartProductMetaColumn: function() {
			$('#size-chart-menu-settings-column').bind('click', function(e) {
				var panelId, wrapper,
					target = $(e.target);
				if (target.hasClass('nav-tab-link')) {
					panelId = target.data('type');
					wrapper = target.parents('.size-chart-accordion-section-content').first();

					// upon changing tabs, we want to uncheck all checkboxes
					$('input', wrapper).removeAttr('checked');
					$('.tabs-panel-active', wrapper).removeClass('tabs-panel-active').addClass('tabs-panel-inactive');
					$('#' + panelId, wrapper).removeClass('tabs-panel-inactive').addClass('tabs-panel-active');
					$('.tabs', wrapper).removeClass('tabs');
					target.parent().addClass('tabs');

					// select the search bar
					$('.quick-search', wrapper).focus();

					// Hide controls in the search tab if no items found.
					if ( ! wrapper.find('.tabs-panel-active .menu-item-title').length) {
						wrapper.addClass('has-no-menu-item');
					} else {
						wrapper.removeClass('has-no-menu-item');
					}
					e.preventDefault();
				}
			});
		},
		loadSizeChartProductMetaAjax: function() {

			$('div#tabs-panel-posttype-size-chart-all').on('click', 'ul.pagination li a.page-numbers', function(e) {
				var pageNumber, postID, postPerPage, data, subLiTag, subATag, paginationSubLiTag, paginationSubTag, paginationClass;
				e.preventDefault();
				pageNumber = $(this).data('page-number');
				postID = $(this).data('post-id');
				postPerPage = $(this).data('post-per-page');
				data = {
					'action': 'size_chart_product_assign',
					'pageNumber': pageNumber,
					'postID': postID,
					'postPerPage': postPerPage,
					'security': $(this).parent().parent().data('nonce'),
				};

				$.ajax({
					type: 'GET',
					url: sizeChartScriptObject.size_chart_admin_url,
					data: data,
					dataType: 'json',
					beforeSend: function() {

						// Loader start
					}, complete: function() {

						// Loader end
					}, success: function(response) {

						if (true === response.success) {
							$('ul#size-chart-checklist-all').empty();
							$.each(response.found_products, function(loopKey, loopValue) {
								subLiTag = $('<li/>');
								subATag = $('<a />', {'href': loopValue.href, text: loopValue.title});
								subATag.appendTo(subLiTag);
								subLiTag.appendTo('ul#size-chart-checklist-all');
							});

							$('nav.pagination-box ul.pagination').empty();
							$.each(response.load_pagination, function(paginationKey, paginationValue) {
								paginationSubLiTag = $('<li/>');
								if ('number' === paginationValue.pagination_mode) {
									if ('span' === paginationValue.pagination_tag) {
										paginationSubTag = $('<span />', {
											class: 'page-numbers ' + paginationValue.pagination_class,
											text: paginationValue.page_text,
										});

									} else {
										paginationClass = 'page-numbers ';
										if ('' !== paginationValue.pagination_class) {
											paginationClass += paginationValue.pagination_class;
										}

										paginationSubTag = $('<a />', {
											href: 'javascript:void(0);',
											class: paginationClass,
											text: paginationValue.page_text,
											'data-post-id': paginationValue.post_id,
											'data-post-per-page': paginationValue.post_per_page,
											'data-page-number': paginationValue.page_number,
										});
									}
								} else if ('dots' === paginationValue.pagination_mode) {
									paginationSubTag = $('<span />', {
										class: 'page-numbers ' + paginationValue.pagination_class,
										text: paginationValue.page_text,
									});
								}
								paginationSubTag.appendTo(paginationSubLiTag);
								paginationSubLiTag.appendTo('nav.pagination-box ul.pagination');
							});

						}
					},
				});
			});


			$('div#tabs-panel-posttype-size-chart-search').on('input', '.quick-search', function() {
				var $this = $(this);
				$this.attr('autocomplete', 'off');
				if (searchTimer) {
					clearTimeout(searchTimer);
				}
				searchTimer = setTimeout(function() {
					var panel, params,
						minSearchLength = 2,
						searchQueryParameter = $this.val(),
						subLiTag, subLabel, inputCheckbox;

					if (searchQueryParameter.length < minSearchLength) {
						return;
					}

					panel = $this.parents('.tabs-panel');
					params = {
						'action': 'size_chart_quick_search_products',
						'security': $this.data('nonce'),
						'postType': $this.data('post_type'),
						'searchQueryParameter': searchQueryParameter,
						'type': $this.attr('name'),
					};

					$.ajax({
						type: 'GET',
						url: sizeChartScriptObject.size_chart_admin_url,
						data: params,
						dataType: 'json',
						beforeSend: function() {
							$('.quick-search-wrap .spinner', panel).show().addClass('is-active');
						}, complete: function() {
							$('.quick-search-wrap .spinner', panel).hide().removeClass('is-active');
						}, success: function(response) {
							$('ul#size-chart-search-checklist').empty();
							if (true === response.success) {
								$.each(response.found_products, function(loopKey, loopValue) {
									subLiTag = $('<li/>').appendTo('ul#size-chart-search-checklist');
									subLabel = $('<label />', {'for': 'size-chart-product-' + loopKey, text: loopValue.title});
									inputCheckbox = $('<input />', {type: 'checkbox', id: 'size-chart-product-' + loopKey, value: loopValue.id, class: 'product-item-checkbox', name: 'product-item[' + loopValue.id + ']'});
									inputCheckbox.prependTo(subLabel);
									subLabel.appendTo(subLiTag);
								});
							} else {
								subLiTag = $('<li/>').appendTo('ul#size-chart-search-checklist');
								subLabel = $('<p />', {text: response.msg});
								subLabel.appendTo(subLiTag);
							}
						},
					});

				}, 500);
			});

		},
		deleteSizeChartImage: function() {

			// Ajax for delete image.
			$('a.delete-chart-image').click(function() {
				var postID = $(this).attr('id');
				var data = {
					'action': 'size_chart_delete_image',
					'postID': postID,
					'security': sizeChartScriptObject.size_chart_nonce,
				};

				$.ajax({
					type: 'GET',
					url: sizeChartScriptObject.size_chart_admin_url,
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
							$('#primary-chart-image').val('');
							$('.delete-chart-image').css('display', 'none');
							alert(result.msg);
						} else {
							alert(result.msg);
						}
					},
				});
			});
		},
		closeSizeChartModal: function() {

			/*** Close popup ***/
			$('div#md-size-chart-modal .remodal-close').click(function() {
				var modal = document.getElementById('md-size-chart-modal');
				$('.chart-container').remove();
				modal.style.display = 'none';
			});

			$('div.md-size-chart-overlay').click(function() {
				var modal = document.getElementById('md-size-chart-modal');
				$('.chart-container').remove();
				modal.style.display = 'none';
			});
		},
		requiredSizeChartTitle: function() {
			$('body').on('submit.edit-post', '#post', function() {
				var getPostType, sizeChartTitleSelector, sizeChartPostTitleRequiredMsg;
				getPostType = $('input#post_type').val();
				if (sizeChartScriptObject.size_chart_post_type_name === getPostType) {
					sizeChartTitleSelector = $('#title');
					if (0 === sizeChartTitleSelector.val().replace(/ /g, '').length) {
						if ( ! $('#size-chart-title-required-msg').length) {
							sizeChartPostTitleRequiredMsg = sizeChartScriptObject.size_chart_post_title_required;

							$('<div/>', {
								'id': 'size-chart-title-required-msg',
							}).appendTo('div#titlewrap');

							$('<em/>', {
								text: sizeChartPostTitleRequiredMsg,
							}).appendTo('#size-chart-title-required-msg');

							$('input#title').css({
								'border': '1px solid #c00',
								'box-shadow': '0 0 2px rgb(204, 0, 0, 0.8)',
							});

						}
						$('#major-publishing-actions .spinner').hide();
						$('#major-publishing-actions').find(':button, :submit, a.submitdelete, #post-preview').removeClass('disabled');
						sizeChartTitleSelector.focus();
						return false;
					}
				}
			});
			$('input#title').on('change', function() {
				$('#size-chart-title-required-msg').remove();
				$('input#title').css({
					'border': '1px solid #ddd',
				});
			});

		},
		load: function() {
		},
		resize: function() {
		},
		scroll: function() {
		},
	};
	$(document).ready(sizeChartScripts.init);
	$(window).on({
		'load': sizeChartScripts.load,
		'resize': sizeChartScripts.resize,
		'scroll': sizeChartScripts.scroll,
	});
})(jQuery, window, document);
