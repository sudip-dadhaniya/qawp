jQuery(document).ready(function ($) {
    'use-strict';
    var AET_Admin_JS_Fields = {
        init: function () {
            $('div.dialogButtons .ui-dialog-buttonset button').removeClass('ui-state-default').addClass("button-primary woocommerce-save-button");
            $(document).on('click', 'span.ecommerce_tracking_description_tab', this.aetOpenDescriptionText);
            $(document).on('click', '#fancybox_guid_gosquard_ecommerce_tracking', this.aetOpenGoSquaredImages);
            $(document).on('click', '#fancybox_guid_facebook_ecommerce_tracking', this.aetOpenFacebookImages);
            $(document).on('click', '#fancybox_guid_google_conversion_tracking_id', this.aetOpenGoogleImages);
            $(document).on('click', '#fancybox_guid_google_conversion_tracking', this.aetOpenGoogleACTImages);
            $(document).on('click', '#find_gosquard_tracking_api_key', this.aetFindGoSquaredImages);
            $(document).on('click', '#twitter_conversion_guide', this.aetOpenTwitterImages);
            $(document).on('click', '#fancybox_guid_google_ecommerce_tracking', this.aetOpenGAImages);
            $("#enabled_add_to_cart").fancybox();
        },

        aetOpenDescriptionText: function (event) {
            event.preventDefault();
            $(this).next('p.description').toggle();
        },

        aetOpenGoSquaredImages: function (event) {
            event.preventDefault();
            var advance_ecommerce_tracking_pluign_url = $("#advance_ecommerce_tracking_plug_url").val();
            var image_one = advance_ecommerce_tracking_pluign_url + "admin/images/gosquard-step-1.jpg";
            var image_two = advance_ecommerce_tracking_pluign_url + "admin/images/gosquard-step-2.jpg";
            var image_three = advance_ecommerce_tracking_pluign_url + "admin/images/gosquard-step-3.jpg";

            $.fancybox.open([
                {
                    href: image_one,
                    title: 'My title 1'
                }, {
                    href: image_two,
                    title: 'My title 2'
                }, {
                    href: image_three,
                    title: 'My title 3'
                }
            ], {
                helpers: {
                    thumbs: {
                        width: 75,
                        height: 50
                    }
                }
            });
        },

        aetOpenFacebookImages: function (event) {
            event.preventDefault();
            var advance_ecommerce_tracking_pluign_url = $("#advance_ecommerce_tracking_plug_url").val();
            var image_one = advance_ecommerce_tracking_pluign_url + "admin/images/fb-step-1.jpg";
            var image_two = advance_ecommerce_tracking_pluign_url + "admin/images/fb-step-2.jpg";
            var image_three = advance_ecommerce_tracking_pluign_url + "admin/images/fb-step-3.jpg";
            var image_four = advance_ecommerce_tracking_pluign_url + "admin/images/fb-step-4.jpg";
            var image_five = advance_ecommerce_tracking_pluign_url + "admin/images/fb-step-5.jpg";
            var image_six = advance_ecommerce_tracking_pluign_url + "admin/images/fb-step-6.jpg";

            $.fancybox.open([
                {
                    href: image_one,
                    title: 'My title 1'
                }, {
                    href: image_two,
                    title: 'My title 2'
                }, {
                    href: image_three,
                    title: 'My title 3'
                }
                , {
                    href: image_four,
                    title: 'My title 4'
                }
                , {
                    href: image_five,
                    title: 'My title 5'
                }
                , {
                    href: image_six,
                    title: 'My title 6'
                }
            ], {
                helpers: {
                    thumbs: {
                        width: 75,
                        height: 50
                    }
                }
            });
        },

        aetOpenGoogleImages: function (event) {
            event.preventDefault();
            var advance_ecommerce_tracking_pluign_url = $("#advance_ecommerce_tracking_plug_url").val();
            var image_five = advance_ecommerce_tracking_pluign_url + "admin/images/google-conversion-five.jpg";
            $.fancybox.open([
                {
                    href: image_five,
                    title: 'My title 1'
                }], {
                helpers: {
                    thumbs: {
                        width: 75,
                        height: 50
                    }
                }
            });
        },

        aetOpenGoogleACTImages: function (event) {
            event.preventDefault();
            var advance_ecommerce_tracking_pluign_url = $("#advance_ecommerce_tracking_plug_url").val();
            var image_one = advance_ecommerce_tracking_pluign_url + "admin/images/google-conversion-one.jpg";
            var image_two = advance_ecommerce_tracking_pluign_url + "admin/images/google-conversion-two.jpg";
            var image_three = advance_ecommerce_tracking_pluign_url + "admin/images/google-conversion-three.jpg";
            var image_four = advance_ecommerce_tracking_pluign_url + "admin/images/google-conversion-four.jpg";
            var image_five = advance_ecommerce_tracking_pluign_url + "admin/images/google-conversion-five.jpg";
            var image_six = advance_ecommerce_tracking_pluign_url + "admin/images/google-conversion-six.jpg";

            $.fancybox.open([
                {
                    href: image_one,
                    title: 'My title 1'
                }, {
                    href: image_two,
                    title: 'My title 2'
                }, {
                    href: image_three,
                    title: 'My title 3'
                }
                , {
                    href: image_four,
                    title: 'My title 4'
                }
                , {
                    href: image_five,
                    title: 'My title 5'
                }
                , {
                    href: image_six,
                    title: 'My title 5'
                }

            ], {
                helpers: {
                    thumbs: {
                        width: 75,
                        height: 50
                    }
                }
            });
        },

        aetOpenTwitterImages: function (event) {
            event.preventDefault();
            var advance_ecommerce_tracking_pluign_url = $("#advance_ecommerce_tracking_plug_url").val();
            var image_one = advance_ecommerce_tracking_pluign_url + "admin/images/twiiter-1.jpg";
            var image_two = advance_ecommerce_tracking_pluign_url + "admin/images/twiiter-2.jpg";
            var image_three = advance_ecommerce_tracking_pluign_url + "admin/images/twiiter-3.jpg";
            var image_four = advance_ecommerce_tracking_pluign_url + "admin/images/twitter-4.jpg";
            var image_five = advance_ecommerce_tracking_pluign_url + "admin/images/twitter-5.jpg";

            $.fancybox.open([
                {
                    href: image_one,
                    title: 'My title 1'
                }, {
                    href: image_two,
                    title: 'My title 2'
                }, {
                    href: image_three,
                    title: 'My title 3'
                }
                , {
                    href: image_four,
                    title: 'My title 4'
                }
                , {
                    href: image_five,
                    title: 'My title 5'
                }

            ], {
                helpers: {
                    thumbs: {
                        width: 75,
                        height: 50
                    }
                }
            });
        },

        aetFindGoSquaredImages: function (event) {
            event.preventDefault();
            var advance_ecommerce_tracking_pluign_url = $("#advance_ecommerce_tracking_plug_url").val();
            var image_one = advance_ecommerce_tracking_pluign_url + "admin/images/gosquard-step-6.jpg";
            var image_two = advance_ecommerce_tracking_pluign_url + "admin/images/gosquard-step-7.jpg";
            var image_three = advance_ecommerce_tracking_pluign_url + "admin/images/gosquard-step-8.jpg";

            $.fancybox.open([
                {
                    href: image_one,
                    title: 'Step 1'
                }, {
                    href: image_two,
                    title: 'Step 2'
                }, {
                    href: image_three,
                    title: 'Step 3'
                }
            ], {
                helpers: {
                    thumbs: {
                        width: 75,
                        height: 50
                    }
                }
            });
        },

        aetOpenGAImages: function (event) {
            event.preventDefault();
            var advance_ecommerce_tracking_pluign_url = $("#advance_ecommerce_tracking_plug_url").val();
            var image_one = advance_ecommerce_tracking_pluign_url + "admin/images/ge-1.jpg";
            var image_two = advance_ecommerce_tracking_pluign_url + "admin/images/ge-2.jpg";
            var image_three = advance_ecommerce_tracking_pluign_url + "admin/images/ge-3.jpg";
            var image_four = advance_ecommerce_tracking_pluign_url + "admin/images/ge-4.jpg";
            var image_five = advance_ecommerce_tracking_pluign_url + "admin/images/ge-5.jpg";
            var image_six = advance_ecommerce_tracking_pluign_url + "admin/images/ge-6.jpg";
            var image_seven = advance_ecommerce_tracking_pluign_url + "admin/images/ge-7.jpg";
            var image_eight = advance_ecommerce_tracking_pluign_url + "admin/images/ge-8.jpg";
            var image_nine = advance_ecommerce_tracking_pluign_url + "admin/images/ge-9.jpg";
            var image_ten = advance_ecommerce_tracking_pluign_url + "admin/images/ge-10.jpg";

            $.fancybox.open([
                {
                    href: image_one,
                    title: 'My title 1'
                }, {
                    href: image_two,
                    title: 'My title 2'
                }, {
                    href: image_three,
                    title: 'My title 3'
                }
                , {
                    href: image_four,
                    title: 'My title 4'
                }
                , {
                    href: image_five,
                    title: 'My title 5'
                }
                , {
                    href: image_six,
                    title: 'My title 6'
                }
                , {
                    href: image_seven,
                    title: 'My title 7'
                }
                , {
                    href: image_eight,
                    title: 'My title 8'
                }
                , {
                    href: image_nine,
                    title: 'My title 9'
                }
                , {
                    href: image_ten,
                    title: 'My title 10'
                }

            ], {
                helpers: {
                    thumbs: {
                        width: 75,
                        height: 50
                    }
                }
            });
        }
    };
    AET_Admin_JS_Fields.init();

});