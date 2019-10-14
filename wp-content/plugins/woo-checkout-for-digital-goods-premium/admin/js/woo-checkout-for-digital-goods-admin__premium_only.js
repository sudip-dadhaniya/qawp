(function($) {
    'use strict';
    $(document).ready(function() {

        // Ajax Search Product
        $(':input#wcdg-chk-product-filter').filter(':not(.enhanced)').each(function() {
          var terms = [];
          var select2Args = {
            allowClear: $(this).data('allow_clear') ? true : false,
            placeholder: $(this).data('placeholder'),
            minimumInputLength: $(this).data('minimum_input_length') ? $(this).data('minimum_input_length') : '1',
            escapeMarkup: function(m) {
              return m;
            },
            ajax: {
              url: ajaxurl,
              dataType: 'json',
              delay: 1000,
              data: function(params) {
                return {
                  'searchQueryParameter': params.term,
                  action: 'wcdg_vartual_product_list_ajax__premium_only',
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

        /*Delete single product using delete button*/
        $('body').on('click', '.delete_single_selected_product', function(e) {
            var singleSelectedProduct = $(this).attr('id');
            var singleSelectedProductIntId = singleSelectedProduct.substr(singleSelectedProduct.lastIndexOf("_") + 1);
            var confrim = confirm("Are you sure want to delete this product?");

            if (confrim == true) {
                $.ajax({
                    type: 'GET',
                    url: ajaxurl,
                    data: {
                        action: "wcdg_single_product_delete__premium_only",
                        single_selected_product_id: singleSelectedProductIntId
                    },
                    success: function(response) {
                        if (response == 'true') {
                            $('#product_' + singleSelectedProductIntId).remove();
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Delete single category using delete button*/
        $('body').on('click', '.delete_single_selected_cat', function(e) {

            var singleSelectedCat = $(this).attr('id');
            var singleSelectedCatIntId = singleSelectedCat.substr(singleSelectedCat.lastIndexOf("_") + 1);
            var confrim = confirm("Are you sure want to delete this category?");

            if (confrim == true) {
                $.ajax({
                    type: 'GET',
                    url: ajaxurl,
                    data: {
                        action: "wcdg_single_cat_delete__premium_only",
                        single_selected_cat_id: singleSelectedCatIntId
                    },
                    success: function(response) {
                        if (response == 'true') {
                            $('#cat_' + singleSelectedCatIntId).remove();
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Delete single tag using delete button*/
        $('body').on('click', '.delete_single_selected_tag', function(e) {

            var singleSelectedTag = $(this).attr('id');
            var singleSelectedTagIntId = singleSelectedTag.substr(singleSelectedTag.lastIndexOf("_") + 1);
            var confrim = confirm("Are you sure want to delete this tag?");

            if (confrim == true) {
                $.ajax({
                    type: 'GET',
                    url: ajaxurl,
                    data: {
                        action: "wcdg_single_tag_delete__premium_only",
                        single_selected_tag_id: singleSelectedTagIntId
                    },
                    success: function(response) {
                        if (response == 'true') {
                            $('#tag_' + singleSelectedTagIntId).remove();
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                return false;
            }
        });
        /*Check all checkbox wizard*/
        $('body').on('click', '.wcdg_chk_all', function(e) {

            $('input.wcdg_chk_single:checkbox').not(this).prop('checked', this.checked);

            var numberOfChecked = $("input.wcdg_chk_single:checked").length;

            if (numberOfChecked >= 1) {
                $('.wcdg_detete_all_selected').removeAttr("disabled");
            } else {
                $('.wcdg_detete_all_selected').attr("disabled", "disabled");
            }
        });

        /*Get all checkbox checked value*/
        $('body').on('click', '.wcdg_detete_all_selected', function(e) {
            var deleteLabel = $(this).attr('id');
            var numberOfChecked = $("input.wcdg_chk_single:checked").length;

            if (numberOfChecked >= 1) {
                var confrim = confirm("Are you sure want to delete selected items?");
                if (confrim == true) {

                    var selectedItemIdArr = [];
                    $.each($("input.wcdg_chk_single:checked"), function() {
                        selectedItemIdArr.push($(this).val());
                    });
                    var selectedItemId = selectedItemIdArr;
                    $.ajax({
                        type: 'GET',
                        url: ajaxurl,
                        data: {
                            action: "wcdg_selected_delete__premium_only",
                            selected_item_id: selectedItemId,
                            delete_label: deleteLabel
                        },
                        success: function(response) {
                            if (response == 'true') {
                                $.each(selectedItemId, function(index, value) {
                                    if(deleteLabel == 'wcdg_detete_all_selected_product'){
                                        $('#product_' + value).remove();
                                    }else if(deleteLabel == 'wcdg_detete_all_selected_cat'){
                                        $('#cat_' + value).remove();
                                    }else if(deleteLabel == 'wcdg_detete_all_selected_tag'){
                                        $('#tag_' + value).remove();
                                    }
                                    window.location.reload();
                                });
                                $('.wcdg_chk_all').prop('checked', false);
                                $('.wcdg_detete_all_selected').attr("disabled", "disabled");
                            } else {
                                return false;
                            }
                        }
                    });
                } else {
                    return false;
                }
            }
        });

        /*Check single checkbox items*/
        $('body').on('click', '.wcdg_chk_single', function(e) {

            var numberOfChecked = $("input[name='wcdg_single_item']:checked").length;
            if (numberOfChecked >= 1) {
                $('.wcdg_detete_all_selected').removeAttr("disabled");
            } else {
                $('.wcdg_detete_all_selected').attr("disabled", "disabled");
            }
        });
    });
})(jQuery);