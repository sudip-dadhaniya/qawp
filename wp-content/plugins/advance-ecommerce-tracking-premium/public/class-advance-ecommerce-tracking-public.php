<?php
if (!defined('ABSPATH')) exit;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/public
 * @author     Multidots <info@multidots.com>
 */
class Advance_Ecommerce_Tracking_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    function enqueue_styles() {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/advance-ecommerce-tracking-public.css');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/advance-ecommerce-tracking-public.js', array('jquery'), $this->version, true);

    }

    /**
     * google conversion tracking.
     *
     * @param $orderid
     */
    public function advance_ecommerce_google_conversion_tracking($orderid) {

        $order    = new WC_Order($orderid);
        $currency = $order->get_currency();
        $total    = $order->get_total();

        $advance_google_currency = '';
        if (!empty($currency) ) {
            $advance_google_currency = $currency;
        }

        $advance_google_total = '';
        if (!empty($total) ) {
            $advance_google_total = $total;
        }

        //Set Google Conversion Label
        $advance_ecommerce_tracking_settings_google_conversion_label = get_option('advance_ecommerce_tracking_section_google_conversion_label');
        //Set Google Conversion Code
        $advance_ecommerce_tracking_settings_google_conversion_id = get_option('advance_ecommerce_tracking_section_google_conversion_id');
        $key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
        if (isset($key) && !empty($key) && !empty($advance_ecommerce_tracking_settings_google_conversion_label) && !empty($advance_ecommerce_tracking_settings_google_conversion_id) && !empty($advance_google_total)) {?>
            <script type="text/javascript">
                /* <![CDATA[ */
                var google_conversion_id = '<?php echo esc_attr($advance_ecommerce_tracking_settings_google_conversion_id); ?>';
                var google_conversion_language = "en";
                var google_conversion_format = "3";
                var google_conversion_color = "ffffff";
                var google_conversion_label = "<?php echo esc_attr($advance_ecommerce_tracking_settings_google_conversion_label); ?>";
                var google_conversion_value = <?php echo esc_attr($advance_google_total); ?>;
                var google_conversion_currency = "<?php echo esc_attr($advance_google_currency) ?>";
                var google_remarketing_only = false;
                /* ]]> */
            </script>
            <script type="text/javascript"
                    src="//www.googleadservices.com/pagead/conversion.js">
            </script>
            <noscript>
                <div style="display:inline;">
                    <?php echo '<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/' . esc_attr($advance_ecommerce_tracking_settings_google_conversion_id) . '/?value=' . esc_attr($advance_google_total) . '&amp;currency_code=' . esc_attr($advance_google_currency) . '&amp;label=' . esc_attr($advance_ecommerce_tracking_settings_google_conversion_label) . '&amp;guid=ON&amp;script=0"/>' ?>
                </div>
            </noscript>

            <?php
        }
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $orderid
     */
    public function advance_ecommerce_twitter_conversion_tracking($orderid) {

        //Set Twitter Conversion code
        $advance_ecommerce_tracking_section_twitter_conversion_id = get_option('advance_ecommerce_tracking_section_twitter_conversion_id');
        if (!empty($advance_ecommerce_tracking_section_twitter_conversion_id)) {
            $advance_ecommerce_tracking_section_twitter_conversion_id_results = $advance_ecommerce_tracking_section_twitter_conversion_id;
        } else {
            $advance_ecommerce_tracking_section_twitter_conversion_id_results = '';
        }
        $key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
        if (isset($key) && !empty($key) && !empty($advance_ecommerce_tracking_section_twitter_conversion_id_results)) {
            ?>

            <!-- Twitter universal website tag code -->
            <script>
                !function (e, n, u, a) {
                    e.twq || (a = e.twq = function () {
                        a.exe ? a.exe.apply(a, arguments) :
                            a.queue.push(arguments);
                    }, a.version = '1', a.queue = [], t = n.createElement(u),
                        t.async = !0, t.src = '//static.ads-twitter.com/uwt.js', s = n.getElementsByTagName(u)[0],
                        s.parentNode.insertBefore(t, s))
                }(window, document, 'script');
                // Insert Twitter Pixel ID and Standard Event data below
                twq('init', '<?php echo esc_attr($advance_ecommerce_tracking_section_twitter_conversion_id_results); ?>');
                twq('track', 'PageView');
            </script>
            <!-- End Twitter universal website tag code -->
            <?php
        }
    }

    /**
     * Load GA code into Header.
     */
    public function load_ga_code_in_header() {
        //Check Advance Ecommerce Tracking is Enable
        $advance_ecommerce_tracking_section_google_uid = get_option('advance_ecommerce_tracking_section_google_uid');

        if (!empty($advance_ecommerce_tracking_section_google_uid) && isset($advance_ecommerce_tracking_section_google_uid)) {
            ?>
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', '<?php echo esc_attr($advance_ecommerce_tracking_section_google_uid); ?>', 'auto');
            </script>
            <?php
        }
    }

    /**
     * Google analytics tracking content viewing.
     */
    public function gta_track_view_content() {
        if (is_product()) {
            global $product;

            $product_id = $product->get_id();
            ?>
            <script type="text/javascript">
                jQuery(function ($) {
                    ga("require", "ec");
                    ga("ec:addProduct", {
                        "id": "<?php echo esc_attr($product->get_id()); ?>",
                        "name": "<?php echo esc_attr($product->get_title()); ?>",
                        "price": "<?php echo esc_attr($this->aet_get_product_price_based_on_id($product_id, 1)); ?>",
                        "category": "<?php echo esc_attr(implode(', ', $this->aet_get_taxonomy_list('product_tag', $product_id))); ?>",
                        "tags": "<?php echo esc_attr(implode(', ', $this->aet_get_taxonomy_list('product_tag', $product_id))); ?>",
                        'currency': "<?php echo esc_attr(get_woocommerce_currency()); ?>",
                        'value': "<?php echo esc_attr($this->aet_get_product_price_based_on_id($product_id)); ?>"
                    });
                    ga("ec:setAction", "detail");
                    ga("send", "event", "View Content", "view_content", "<?php echo esc_attr($product->get_title()); ?>");
                });
            </script>
            <?php
        }
    }

    /**
     * Google analytics tracking product added to cart from shop page.
     */
    public function gta_track_add_to_cart_on_lopp() {
        global $product;
        if (is_woocommerce()) {
            $product_id = $product->get_id();

            $product = wc_get_product($product_id);
            ?>
            <script type="text/javascript">
                if (jQuery('.add_to_cart_button:not(.product_type_variable)').length) {
                    jQuery('.add_to_cart_button:not(.product_type_variable)').click(function (e) {
                        var product_id = jQuery(this).data('product_id');
                        if ('' !== product_id) {
                            var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: "aetp_get_current_product_detail_for_ga_track",
                                    get_product_id: product_id
                                },
                                success: function (response) {
                                    var new_response = JSON.parse(response);
                                    ga("require", "ec");
                                    ga('ec:addProduct', {
                                        'id': product_id, // Product ID/SKU - Type: string
                                        'name': new_response.prd_name, // Product name - Type: string
                                        'category': new_response.product_cat, // Product category - Type: string
                                        'tag': new_response.product_tag, // Product category - Type: string
                                        'brand': "", // Product brand - Type: string
                                        'variant': "", // Variant of the product like: color, size etc - Type: string
                                        'position': "", // Product position in a list - Type: numeric Example: 10
                                        'price': new_response.product_price,// Product position in a list - Type: numeric Example: 10
                                        'quantity': new_response.product_quantity // Product qty - Type: string
                                    });
                                    ga("ec:setAction", "add");
                                    ga("send", "event", "Add To Cart", "add_to_cart_click", new_response.prd_name);
                                }
                            });
                        }
                    });
                }
            </script>
            <?php
        }
    }

    /**
     * Google analytics tracking product details page.
     */
    public function aetp_get_current_product_detail_for_ga_track() {
        /* Check for post request */
        $get_product_id = filter_input(INPUT_POST, 'get_product_id', FILTER_SANITIZE_STRING);
        if (!(isset($get_product_id))) {
            echo '<strong>' . esc_html__('Something went wrong!', 'advance-ecommerce-tracking') . '</strong>';
            wp_die();
        }
        $get_product_detail = wc_get_product($get_product_id);
        $product_price      = $get_product_detail->get_price();
        $product_name       = $get_product_detail->get_name();
        $product_cat        = implode(', ', $this->aet_get_taxonomy_list('product_cat', $get_product_id));
        $product_tag        = implode(', ', $this->aet_get_taxonomy_list('product_tag', $get_product_id));
        $product_qty         = 1;
        $product_detail      = array(
            'prd_name' => $product_name,
            'product_price' => $product_price,
            'product_cat' => $product_cat,
            'product_tag' => $product_tag,
            'product_quantity' => $product_qty
        );
        echo esc_html(wp_json_encode($product_detail));
        wp_die();
    }

    /**
     * Google analytics tracking product adding to cart.
     */
    public function gta_track_add_to_cart() {
        global $product;
        $product_id = $product->get_id();

        $product = wc_get_product($product_id);
        ?>
        <script type="text/javascript">
            jQuery(function ($) {
                if (jQuery('.single_add_to_cart_button').length) {
                    jQuery('.single_add_to_cart_button').click(function (e) {
                        ga("require", "ec");
                        ga("ec:addProduct", {
                            "id": "<?php echo esc_attr($product_id); ?>",
                            "name": "<?php echo esc_attr($product->get_title()); ?>",
                            "price": "<?php echo esc_attr($this->aet_get_product_price_based_on_id($product_id, 1)); ?>",
                            "category": "<?php echo esc_attr(implode(', ', $this->aet_get_taxonomy_list('product_tag', $product_id))); ?>",
                            "tags": "<?php echo esc_attr(implode(', ', $this->aet_get_taxonomy_list('product_tag', $product_id))); ?>",
                            'currency': "<?php echo esc_attr(get_woocommerce_currency()); ?>",
                            'value': "<?php echo esc_attr($this->aet_get_product_price_based_on_id($product_id)); ?>"
                        });
                        ga("ec:setAction", "add");
                        ga("send", "event", "Add To Cart", "add_to_cart_click", "<?php echo esc_attr($product->get_title()); ?>");
                    });
                }
            });
        </script>
        <?php
    }

    /**
     * Google analytics tracking product purchase event.
     */
    public function gta_track_purchase($orderid) {
        $order = new WC_Order($orderid);
        /*Coupon*/
        $order_get_used_coupon       = $order->get_used_coupons();
        $count_order_get_used_coupon = count($order_get_used_coupon);
        if (isset($order_get_used_coupon) && !empty($order_get_used_coupon)) {
            if ($count_order_get_used_coupon > 1) {
                $coupon_name_implode = implode('/', $order_get_used_coupon);
            } else {
                $coupon_name_implode = $order_get_used_coupon['0'];
            }
        }
        if (!empty($_SERVER['HTTP_REFERER'])) {
            ?>
            <script type="text/javascript">
                ga("require", "ec");
                <?php
                //Item Details
                if (count($order->get_items()) > 0) {
                foreach ($order->get_items() as $item_product) {
                $product_id = $item_product->get_product_id(); //Get the product ID
                $quantity = $item_product->get_quantity(); //Get the product QTY
                $product_name = $item_product->get_name(); //Get the product NAME
                $product_line_subtotal = $order->get_line_subtotal($item_product); //Get the product NAME

                $product = $item_product->get_product();

                $attribute_value_implode = "";
                // Only for product variation
                if ($product->is_type('variation')) {
                    $attribute_value = array();
                    // Get the variation attributes
                    $variation_attributes = $product->get_variation_attributes();
                    // Loop through each selected attributes
                    foreach ($variation_attributes as $attribute_taxonomy => $term_slug) {
                        $taxonomy = str_replace('attribute_', '', $attribute_taxonomy);
                        // The name of the attribute
                        // $attribute_name = get_taxonomy($taxonomy)->labels->singular_name;
                        // The term name (or value) for this attribute
                        $attribute_value[] = get_term_by('slug', $term_slug, $taxonomy)->name;
                    }

                    $attribute_value_implode = '';
                    $total_attribute_value   = count($attribute_value);
                    if ($total_attribute_value > 1) {
                        $attribute_value_implode = implode('/', $attribute_value);
                    } else {
                        $attribute_value_implode = $attribute_value['0'];
                    }
                } else {
                    $attribute_value_implode = '';
                }

                $new_cat_array = array();
                $product_cats = get_the_terms(trim($product_id), 'product_cat');
                $total_products_cat = count($product_cats);
                $multiple_cat_impode = "";

                if ($total_products_cat > 1) {
                    foreach ($product_cats as $product_cat_val) {
                        $new_cat_array[] = $product_cat_val->name;
                    }
                    $multiple_cat_impode = implode('/', $new_cat_array);
                } else {
                    foreach ($product_cats as $product_cat_val) {
                        $multiple_cat_impode = $product_cat_val->name;
                    }
                }

                ?>
                ga("ec:addProduct", {
                    "id": '<?php echo esc_attr($product_id); ?>',
                    "name": '<?php echo esc_attr($product_name); ?>',
                    "price": '<?php echo esc_attr($product_line_subtotal); ?>',
                    "brand": '',
                    "category": '<?php echo esc_attr(!empty($multiple_cat_impode) ? $multiple_cat_impode : ''); ?>',
                    "variant": '<?php echo esc_attr($attribute_value_implode); ?>',
                    "dimension1": '',
                    "position": '',
                    "quantity": '<?php echo esc_attr($quantity); ?>',
                    'currency': '<?php echo esc_attr($order->get_currency()); ?>'
                });
                <?php
                }
                }
                ?>
                ga("ec:setAction", "purchase", {
                    "id": '<?php echo esc_attr($order->get_order_number()); ?>',
                    "affiliation": '<?php echo esc_attr(get_option("blogname")); ?>',
                    "revenue": '<?php echo esc_attr($order->get_total()); ?>',
                    "tax": '<?php echo esc_attr($order->get_total_tax()); ?>',
                    "shipping": '<?php echo esc_attr($order->get_total_shipping()); ?>',
                    'coupon': '<?php echo esc_attr($coupon_name_implode); ?>'
                });
                //ga("send", "event", "Purchase", "purchase", "Purchase");
                ga("send", "event", "Purchase", "purchase", "<?php echo esc_attr($order->get_order_number()); ?>");
                //ga("send", "pageview");
            </script>
            <?php
        }
    }

    /**
     * Google analytics tracking checkout initiation event.
     */
    public function gta_track_checkout_initate() {
        if (is_checkout()) {
            ?>
            <script type="text/javascript">
                jQuery(function ($) {
                    ga("require", "ec");
                    <?php
                    foreach (WC()->cart->cart_contents as $cart_item) {
                    $product = wc_get_product($cart_item['product_id']);
                    ?>
                    ga("ec:addProduct", {
                        "id": "<?php echo esc_attr($cart_item['product_id']); ?>",
                        "name": "<?php echo esc_attr($product->get_name()); ?>",
                        "price": "<?php echo esc_attr($cart_item['line_subtotal']); ?>",
                        "category": "<?php echo esc_attr(implode(', ', $this->aet_get_taxonomy_list('product_cat', $cart_item['product_id']))); ?>",
                        "tags": "<?php echo esc_attr(implode(', ', $this->aet_get_taxonomy_list('product_tag', $cart_item['product_id']))); ?>",
                        'currency': "<?php echo esc_attr(get_woocommerce_currency()); ?>",
                        'value': "<?php echo esc_attr($cart_item['line_subtotal']); ?>",
                        'quantity': "<?php echo esc_attr($cart_item['quantity']); ?>",
                    });
                    <?php
                    }
                    ?>
                    ga("ec:setAction", "checkout", {"step": 1});
                });
            </script>
            <?php
        }
    }

    /**
     * Google analytics tracking product removal from cart.
     */
    public function gta_track_remove_from_cart() {
        if (is_cart()) {
            ?>
            <script type="text/javascript">
                if (jQuery('form.woocommerce-cart-form .remove').length) {
                    jQuery(document).on('click', 'form.woocommerce-cart-form .remove', function (e) {
                        // console.log('remove from cart');
                        var product_id = jQuery(this).data('product_id');
                        if ('' !== product_id) {
                            var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: "aetp_get_remove_product_detail_from_cart_analytics_tracking",
                                    get_product_id: product_id
                                },
                                success: function (response) {
                                    var new_response = JSON.parse(response);
                                    ga("require", "ec");
                                    ga('ec:addProduct', {
                                        'id': product_id, // Product ID/SKU - Type: string
                                        'name': new_response.prd_name, // Product name - Type: string
                                        'category': new_response.product_cat, // Product category - Type: string
                                        'tag': new_response.product_tag, // Product category - Type: string
                                        'brand': "", // Product brand - Type: string
                                        'variant': "", // Variant of the product like: color, size etc - Type: string
                                        'position': "", // Product position in a list - Type: numeric Example: 10
                                        'price': new_response.product_price,// Product position in a list - Type: numeric Example: 10
                                        'quantity': new_response.product_quantity // Product name - Type: string
                                    });
                                    ga("ec:setAction", "remove");
                                    //ga("send", "event", "Remove From Cart", "remove_from_cart_on_click", "RemoveFromCart");
                                    ga("send", "event", "Remove From Cart", "remove_from_cart_on_click", new_response.prd_name);
                                }
                            });
                        }
                    });
                }
            </script>
            <?php
        }
    }

    /**
     * Google analytics tracking cart update event.
     */
    public function gta_track_update_cart() {
        if (is_cart()) {
            ?>
            <script type="text/javascript">
                if (jQuery('form.woocommerce-cart-form button[name="update_cart"]').length) {
                    jQuery(document).on('click', 'form.woocommerce-cart-form button[name="update_cart"]', function (e) {
                        ga("send", "event", "Update Cart", "update_cart", "UpdateCart");
                    });
                }
            </script>
            <?php
        }
    }

    /**
     * Google analytics tracking coupon applying.
     */
    public function gta_track_apply_coupon() {
        ?>
        <script type="text/javascript">
            <?php
            if (is_cart()) {
            ?>
            if (jQuery('form.woocommerce-cart-form button[name="apply_coupon"]').length) {
                jQuery(document).on('click', 'form.woocommerce-cart-form button[name="apply_coupon"]', function (e) {
                    var coupon_val = jQuery('#coupon_code').val();
                    //console.log("coupon_val " + coupon_val);
                    //ga("send", "event", "Apply Coupon On Cart", "apply_coupon_on_cart", "ApplyCouponOnCart", coupon_val);
                    ga("send", "event", "Apply Coupon On Cart", "apply_coupon_on_cart", coupon_val);
                });
            }
            <?php
            }
            if (is_checkout()) {
            ?>
            if (jQuery('form.woocommerce-form-coupon input[name="apply_coupon"]').length) {
                jQuery(document).on('click', 'form.woocommerce-form-coupon input[name="apply_coupon"]', function (e) {
                    var coupon_val = jQuery('#coupon_code').val();
                    //ga("send", "event", "Apply Coupon On Checkout", "apply_coupon_on_checkout", "ApplyCouponOnCheckout", coupon_val);
                    ga("send", "event", "Apply Coupon On Checkout", "apply_coupon_on_checkout", coupon_val);
                });
            }
            <?php
            }
            ?>
        </script>
        <?php
    }

    /**
     * Google Analytics tracking the search results.
     */
    public function gta_track_search() {

        $s = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
        if (isset($s) && !empty($s)) {
            ?>
            <script type="text/javascript">
                jQuery(function ($) {
                    ga("require", "ec");
                    ga("send", "event", "Ecommerce Search", "search", '<?php echo esc_attr($s); ?>');
                });
            </script>
            <?php
        }
    }

    /**
     * Google Analytics tracking product removal from cart.
     */
    public function aetp_get_remove_product_detail_from_cart_analytics_tracking() {
        /* Check for post request */
        $get_product_id = (int)filter_input(INPUT_POST, 'get_product_id', FILTER_SANITIZE_STRING);
        if (!(isset($get_product_id))) {
            echo '<strong>' . esc_html__('Something went wrong', 'advance_ecommerce_tracking') . '</strong>';
            die();

        }

        foreach (WC()->cart->cart_contents as $cart_item) {
            $product = wc_get_product($cart_item['product_id']);
            if ((int)$cart_item['product_id'] === $get_product_id) {
                $product        = wc_get_product($cart_item['product_id']);
                $product_price  = $cart_item['line_subtotal'];
                $product_name   = $product->get_name();
                $product_cat    = implode(', ', $this->aet_get_taxonomy_list('product_cat', $cart_item['product_id']));
                $product_tag    = implode(', ', $this->aet_get_taxonomy_list('product_tag', $cart_item['product_id']));
                $product_qty    = $cart_item['quantity'];
                $product_detail = array(
                    'prd_name' => $product_name,
                    'product_price' => $product_price,
                    'product_cat' => $product_cat,
                    'product_tag' => $product_tag,
                    'product_quantity' => $product_qty
                );
                echo esc_html(wp_json_encode($product_detail));
                wp_die();
            }
        }
    }

    /**
     * Google Analytics, track pageview.
     */
    public function gta_track_page_view() {
        ?>
        <script type="text/javascript">
            ga("send", "pageview");
        </script>
        <?php
    }

    /**
     * Add Script for add Ecommerce Tracking Facebook Conversion
     *
     */
    public function advance_ecommerce_tracking_facebook_conversion_page_view() {

        //Set Facebook Label
        $advance_ecommerce_tracking_settings_facebook_track_id = get_option('advance_ecommerce_tracking_section_facebook_tracking_id');
        if (!empty($advance_ecommerce_tracking_settings_facebook_track_id)) {
            $advance_ecommerce_tracking_settings_facebook_track_id_results = $advance_ecommerce_tracking_settings_facebook_track_id;
        } else {
            $advance_ecommerce_tracking_settings_facebook_track_id_results = '';
        }


        if (!empty($advance_ecommerce_tracking_settings_facebook_track_id_results)) {
            ?>
            <!-- Facebook Pixel Code -->
            <script>
                !function (f, b, e, v, n, t, s) {
                    if (f.fbq)
                        return;
                    n = f.fbq = function () {
                        n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                    };
                    if (!f._fbq)
                        f._fbq = n;
                    n.push = n;
                    n.loaded = !0;
                    n.version = '2.0';
                    n.queue = [];
                    t = b.createElement(e);
                    t.async = !0;
                    t.src = v;
                    s = b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t, s)
                }(window,
                    document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

                fbq('init', '<?php echo esc_attr($advance_ecommerce_tracking_settings_facebook_track_id_results); ?>');
                fbq('track', "PageView");</script>
            <noscript><img height="1" width="1" style="display:none"
                           src="https://www.facebook.com/tr?id=<?php echo esc_attr($advance_ecommerce_tracking_settings_facebook_track_id_results); ?>&ev=PageView&noscript=1"
                /></noscript>
            <!-- End Facebook Pixel Code -->
            <?php
        }
    }

    /**
     * Add Facebook Conversion code in Thank you page
     *
     * @param unknown_type $orderid
     */
    public function fb_tracking_enqueue_scripts() {
        $advance_ecommerce_tracking_settings_facebook_track_id = get_option('advance_ecommerce_tracking_section_facebook_tracking_id');
        $fb_add_to_cart_shop                                   = get_option('fb_add_to_cart_shop');
        ?>
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window,
                document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

            <?php
            if (is_user_logged_in()) {
                $user_email = wp_get_current_user()->user_email;
                echo esc_html($this->call_event($advance_ecommerce_tracking_settings_facebook_track_id, array('em' => $user_email), 'init'/*, 'track'*/));
            } else {
                echo esc_html($this->call_event($advance_ecommerce_tracking_settings_facebook_track_id, array(), 'init'/*, 'track'*/));
            }

            echo esc_html($this->call_event('PageView', array(), 'track'));
            ?>
        </script>

        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=<?php echo esc_attr($advance_ecommerce_tracking_settings_facebook_track_id); ?>&ev=PageView&noscript=1"
            /></noscript>
        <?php

        if (!empty($fb_add_to_cart_shop) && $fb_add_to_cart_shop === 'yes') {
            $this->fb_track_add_to_cart_ajax();
        }
    }

    /**
     * Function defined to track add-to-cart event in facebook.
     */
    public function fb_track_add_to_cart() {
        $fb_add_to_cart_single_prd = get_option('fb_add_to_cart_single_prd');
        if (empty($fb_add_to_cart_single_prd) && $fb_add_to_cart_single_prd === 'no') {
            return;
        }

        $product_ids = $this->get_product_data(WC()->cart->get_cart());

        $code = $this->call_event('AddToCart', array(
            'content_ids' => wp_json_encode($product_ids),
            'content_type' => 'product',
            'value' => WC()->cart->total ? WC()->cart->total : 0,
            'currency' => get_woocommerce_currency()
        ), 'track');

        wc_enqueue_js($code);
    }

    /**
     * Added to cart
     *
     * @return void
     */
    public function fb_track_add_to_cart_ajax() {
        $fb_add_to_cart_shop = get_option('fb_add_to_cart_shop');
        if (empty($fb_add_to_cart_shop) && $fb_add_to_cart_shop === 'no') {
            return;
        }
        ?>
        <script type="text/javascript">
            jQuery(function ($) {
                var product_price;
                jQuery('body').on('click', '.ajax_add_to_cart', function (e) {
                    var product_id = $(this).data('product_id');
                    var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: "aetp_get_current_product_detail_for_fb_track",
                            product_id: product_id
                        },
                        success: function (response) {
                            product_price = response;
                            fbq('track', 'AddToCart', {
                                content_ids: '[' + product_id + ']',
                                content_type: 'product',
                                value: product_price,
                                currency: '<?php echo esc_attr(get_woocommerce_currency()); ?>',
                            });
                        }
                    });
                });
            });
        </script>
        <?php
    }

    /**
     * Function defined to track the product details page in facebook.
     */
    public function aetp_get_current_product_detail_for_fb_track() {
        /* Check for post request */
        $product_id = (float)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_FLOAT);
        if (!(isset($product_id))) {

            echo '<strong>' . esc_html__('Something went wrong', 'advance-ecommerce-tracking') . '</strong>';
            die();

        }

        $get_product_detail = wc_get_product($product_id);
        $product_price      = $get_product_detail->get_price();
        echo (float)$product_price;
        wp_die();
    }


    protected function get_product_data($cart) {
        $product_ids = array();

        foreach ($cart as $item) {
            $product_ids[] = $item['data']->get_id();
        }

        return $product_ids;
    }

    /**
     * Function defined to track product purchase in facebook.
     *
     * @param $order_id
     */
    function fb_track_purchase($order_id) {
        $fb_purchase = get_option('fb_purchase');
        if (empty($fb_purchase) && $fb_purchase === 'no') {
            return;
        }

        $order        = new WC_Order($order_id);
        $content_type = 'product';
        $product_ids  = array();

        foreach ($order->get_items() as $item) {
            $product = wc_get_product($item['product_id']);

            $product_ids[] = $product->get_id();

            if ($product->get_type() === 'variable') {
                $content_type = 'product_group';
            }
        }

        $code = $this->call_event('Purchase', array(
            'content_ids' => wp_json_encode($product_ids),
            'content_type' => $content_type,
            'value' => $order->get_total() ? $order->get_total() : 0,
            'currency' => get_woocommerce_currency()
        ), 'track');

        wc_enqueue_js($code);
    }

    /**
     * Function defined to track the content in facebook.
     */
    function fb_track_view_content() {
        global $post;

        $fb_view_content = get_option('fb_view_content');
        if (empty($fb_view_content) && 'no' === $fb_view_content) {
            return;
        }

        $product       = wc_get_product($post->ID);
        $product_title = $product->get_title();
        $tags          = implode(', ', $this->aet_get_taxonomy_list('product_tag', $post->ID));
        $categories    = implode(', ', $this->aet_get_taxonomy_list('product_cat', $post->ID));

        $code = $this->call_event('ViewContent', array(
            'content_ids' => wp_json_encode($post->ID),
            'item_price' => $this->aet_get_product_price_based_on_id($post->ID),
            'content_name' => $product_title,
            'content_category' => $categories,
            'content_type' => $product->get_type(),
            'tags' => $tags,
            'currency' => get_woocommerce_currency(),
            'value' => $this->aet_get_product_price_based_on_id($post->ID)
        ), 'track');

        wc_enqueue_js($code);
    }

    /**
     * Function defined to track the category products viewing for facebook.
     */
    function fb_track_category_view() {

        if (is_category()) {
            $fb_view_product_category = get_option('fb_view_product_category');
            if (empty($fb_view_product_category) && 'no' === $fb_view_product_category) {
                return;
            }

            $data_array = array();
            $term_id    = get_queried_object()->term_id;
            if (!empty($term_id)) {
                $term                           = get_term_by('id', $term_id, 'product_cat');
                $data_array['content_name']     = $term->name;
                $data_array['content_category'] = $term->name;

                $args     = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => '-1',
                    'tax_query' => array( //phpcs : ignore
                                          array(
                                              'taxonomy' => 'product_cat',
                                              'field' => 'term_id',
                                              'terms' => $term_id,
                                          )
                    )
                );
                $products = new WP_Query($args);

                foreach ($products->posts as $post_id) {
                    $data_array['content_ids'][] = $post_id->ID;
                }

                $data_array['content_ids'] = implode(', ', $data_array['content_ids']);

                $code = $this->call_event('ViewCategory', $data_array, 'trackCustom');

                wc_enqueue_js($code);
            }
        }
    }

    function aet_get_taxonomy_list($taxonomy, $post_id) {

        $terms   = get_the_terms($post_id, $taxonomy);
        $results = array();

        if (is_wp_error($terms) || empty ($terms)) {
            return array();
        }

        foreach ($terms as $term) {
            $results[] = html_entity_decode($term->name);
        }

        return $results;

    }

    public function aet_get_product_price_based_on_id($product_id, $qty = 1) {

        $product = wc_get_product($product_id);
        if (!$product) {
            return;
        }

        $product_price = (float)wc_get_price_to_display($product, array('qty' => $qty));

        return $product_price;

    }

    /**
     * Add Facebook Conversion code in Thank you page
     *
     * @param unknown_type $orderid
     */
    public function advance_ecommerce_fb_conversion_tracking($orderid) {

        $order    = new WC_Order($orderid);
        $currency = $order->get_currency();
        $total    = $order->get_total();

        $advance_currency = "";
        if (!empty($currency)) {
            $advance_currency = $currency;
        }

        $advance_total = "";
        if (!empty($total)) {
            $advance_total = $total;
        }

        //Set Facebook Label
        $advance_ecommerce_tracking_settings_facebook_track_id = get_option('advance_ecommerce_tracking_section_facebook_tracking_id');
        if (!empty($advance_ecommerce_tracking_settings_facebook_track_id)) {
            $advance_ecommerce_tracking_settings_facebook_track_id_results = $advance_ecommerce_tracking_settings_facebook_track_id;
        } else {
            $advance_ecommerce_tracking_settings_facebook_track_id_results = '';
        }

        $key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
        if (isset($key) && !empty($key) && !empty($advance_currency) && !empty($advance_total) && !empty($advance_ecommerce_tracking_settings_facebook_track_id_results)) { ?>
            <!-- Facebook Pixel Code -->
            <script>
                !function (f, b, e, v, n, t, s) {
                    if (f.fbq)
                        return;
                    n = f.fbq = function () {
                        n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                    };
                    if (!f._fbq)
                        f._fbq = n;
                    n.push = n;
                    n.loaded = !0;
                    n.version = '2.0';
                    n.queue = [];
                    t = b.createElement(e);
                    t.async = !0;
                    t.src = v;
                    s = b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t, s)
                }(window,
                    document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

                fbq('init', '<?php echo esc_attr($advance_ecommerce_tracking_settings_facebook_track_id_results); ?>');
                fbq('track', 'Purchase', {
                    value: '<?php echo esc_attr($order->get_total()); ?>',
                    currency: '<?php echo esc_attr(get_woocommerce_currency()); ?>'
                });</script>
            <noscript><img height="1" width="1" style="display:none"
                           src="https://www.facebook.com/tr?id=<?php echo esc_attr($advance_ecommerce_tracking_settings_facebook_track_id_results); ?>&ev=Purchase&noscript=1"
                /></noscript>
            <!-- End Facebook Pixel Code -->

            <?php
        }
    }

    /**
     * Woopra Add to cart event
     */
    public function advance_ecommerce_woopra_tracking_add_to_cart_event($cart_item_key, $product_id = 0, $quantity = 1, $variation_id = 0, $variation = array(), $cart_item_data = array()) {

        global $woocommerce;

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');


        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $woopra = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));
            $cart   = $woocommerce->cart;
            $cart->calculate_totals();
            $content = $cart->get_cart();
            $item    = $content[$cart_item_key];
            $product = get_product($item['variation_id'] ? $item['variation_id'] : $item['product_id']);
            $params  = array(
                "item sku" => $product->get_sku(),
                "item title" => $product->get_title(),
                "item price" => $product->get_price(),
                "quantity" => $quantity,
                "value" => $quantity * $product->get_price()
            );

            if (is_user_logged_in()) {
                $current_user       = wp_get_current_user();
                $current_user_email = $current_user->user_email;
                $current_user_name  = $current_user->display_name;

                $woopra->identify(array(
                    "name" => $current_user_name,
                    "email" => $current_user_email
                ));
            }

            $woopra->track('advance tracking item added into cart', $params, true);
        }
    }

    /**
     * Load Woopra tracking in head
     *
     */
    public function advance_ecommerce_tracking_identify_woopra() {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');

        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {

            $woopra = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));

            if (is_user_logged_in()) {

                $current_user       = wp_get_current_user();
                $current_user_email = $current_user->user_email;
                $current_user_name  = $current_user->display_name;

                $woopra->identify(array(
                    "name" => $current_user_name,
                    "email" => $current_user_email
                ));

                $woopra->identify(array(
                    "name" => $current_user_name,
                    "email" => $current_user_email
                ))->push(TRUE);
            }
        }

        $woopra->set_woopra_cookie();
        $woopra->js_code();
    }

    /**
     * Woopra Removed item from cart event
     *
     */
    public function advance_ecommerce_woopra_tracking_cart_item_removed($removed_cart_item_key, $instance) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');
        $current_user                                              = wp_get_current_user();
        $current_user_email                                        = $current_user->user_email;
        $current_user_name                                         = $current_user->display_name;

        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $woopra    = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));
            $line_item = $instance->removed_cart_contents[$removed_cart_item_key];
            $product   = get_product($line_item['variation_id'] ? $line_item['variation_id'] : $line_item['product_id']);
            $quantity  = $line_item['quantity'];
            $params    = array(
                "item sku" => $product->get_sku(),
                "item title" => $product->get_title(),
                "item price" => $product->get_price(),
                "quantity" => -$quantity,
                "value" => -$quantity * $product->get_price()
            );

            if (is_user_logged_in()) {
                $woopra->identify(array(
                    "name" => $current_user_name,
                    "email" => $current_user_email
                ));
            }

            $woopra->track('advance tracking cart item removed and updated', $params, true);
        }
    }

    /**
     * Woopra Removed item quantity zero event
     *
     */
    public function advance_ecommerce_woopra_tracking_item_quantity_zero() {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');

        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $woopra = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                $woopra->identify(array(
                    "name" => $current_user->display_name,
                    "email" => $current_user->user_email
                ));
            }
            $woopra->track('advance tracking cart item removed', array(), true);
        }
    }

    /**
     * Woopra Item quanitity update
     *
     */
    public function advance_ecommerce_woopra_tracking_item_quantity_update($cart_item_key, $quantity = 1) {

        global $woocommerce;

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');

        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $woopra              = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));
            $cart                = $woocommerce->cart;
            $cart_quantity_array = array();

            $cart_quantity_array['cart_quantities'] = $cart->get_cart_item_quantities();
            $cart->calculate_totals();
            $content  = $cart->get_cart();
            $item     = $content[$cart_item_key];
            $product  = get_product($item['variation_id'] ? $item['variation_id'] : $item['product_id']);
            $quantity = $item["quantity"];

            $params = array(
                "item sku" => $product->get_sku(),
                "item title" => $product->get_title(),
                "item price" => $product->get_price(),
                "quantity" => $quantity,
                "value" => $quantity * $product->get_price()
            );

            if (is_user_logged_in()) {

                $current_user       = wp_get_current_user();
                $current_user_email = $current_user->user_email;
                $current_user_name  = $current_user->display_name;

                $woopra->identify(array(
                    "name" => $current_user_name,
                    "email" => $current_user_email
                ));
            }

            $woopra->track('advance tracking cart updated', $params, true);
        }
    }

    /**
     * Woopra Track Checkout
     *
     */
    public function advance_ecommerce_woopra_tracking_track_checkout($order_id, $params) {
        global $woocommerce;

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');
        $cart                                                      = $woocommerce->cart;
        $order                                                     = new WC_Order($order_id);

        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $woopra = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));

            if (!is_user_logged_in()) {
                $woopra->user['name']  = $params["billing_first_name"] . " " . $params["billing_last_name"];
                $woopra->user['email'] = $params["billing_email"];
                $woopra->identify($woopra->user);
            } else {
                $current_user       = wp_get_current_user();
                $current_user_email = $current_user->user_email;
                $current_user_name  = $current_user->display_name;

                $woopra->identify(array(
                    "name" => $current_user_name,
                    "email" => $current_user_email
                ));
            }

            $woopra_params = array(
                "cart subtotal" => $cart->subtotal,
                "cart value" => $order->get_total(),
                "cart size" => $order->get_item_count(),
                "payment method" => $params["payment_method"],
                "shipping method" => $order->get_shipping_method(),
                "order discount" => $order->get_total_discount(),
                "order number" => $order->get_order_number()
            );

            $woopra->track('advance tracking placed order', $woopra_params, true);
        }
    }

    /**
     * Woopra Track if coupon apply
     *
     */
    public function advance_ecommerce_woopra_tracking_track_coupon($coupon_code) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');
        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $woopra = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));
            $coupon = new WC_COUPON($coupon_code);

            if ($coupon->is_valid()) {

                $params = array(
                    "code" => $coupon->code,
                    "discount type" => $coupon->discount_type,
                    "amount" => $coupon->amount
                );

                $woopra->track('advance tracking coupon applied', $params, true);
            }
        }
    }

    /**
     * Woopra Track when User signup
     *
     */
    public function advance_ecommerce_woopra_tracking_track_signup($user_id) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');
        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $woopra          = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));
            $wp_advance_user = get_user_by('id', $user_id);
            if (!($wp_advance_user instanceof WP_User)) {
                return;
            }

            $user_firstname       = '';
            $user_lastname        = '';
            $user_full_name       = '';
            $user_email           = '';
            $user_nice_name       = '';
            $advance_user_details = array();

            if (!empty($wp_advance_user->user_firstname)) {
                $user_firstname                         = $wp_advance_user->user_firstname;
                $advance_user_details['user_firstname'] = $user_firstname;
            }

            if (!empty($wp_advance_user->user_lastname)) {
                $user_lastname                         = $wp_advance_user->user_lastname;
                $advance_user_details['user_lastname'] = $user_lastname;
            }

            if (!empty($user_firstname) && !empty($user_lastname)) {
                $user_full_name                         = $user_firstname . ' ' . $user_lastname;
                $advance_user_details['user_full_name'] = $user_full_name;
                $woopra->user['name']                   = $user_full_name;
            }

            if (!empty($wp_advance_user->user_email)) {
                $user_email                         = $wp_advance_user->user_email;
                $advance_user_details['user_email'] = $user_email;
                $woopra->user['email']              = $user_email;
            }

            if ($wp_advance_user->user_login) {
                $user_nice_name                   = $wp_advance_user->user_login;
                $advance_user_details['username'] = $user_nice_name;
                $woopra->identify($woopra->user);
            }

            $woopra->track('advance tracking user signup', $advance_user_details, true);
        }
    }

    /**
     * Woopra track after order complete
     *
     */
    public function advance_ecommerce_woopra_order_complete($order) {

        $order_id = $order->id;
        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_woopra_section_enable          = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_section_woopra_tracking_domain = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');


        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            if (!empty($_SERVER['HTTP_REFERER'])) {
                $woopra = new AdvanceWoopraTracker(array("domain" => $advance_ecommerce_tracking_section_woopra_tracking_domain));

                if (!is_user_logged_in()) {
                    $first_name            = get_post_meta($order_id, '_billing_first_name', true);
                    $last_name             = get_post_meta($order_id, '_billing_last_name', true);
                    $billing_email         = get_post_meta($order_id, '_billing_email', true);
                    $woopra->user['name']  = $first_name . " " . $last_name;
                    $woopra->user['email'] = $billing_email;
                    $woopra->identify($woopra->user);
                } else {
                    $current_user       = wp_get_current_user();
                    $current_user_email = $current_user->user_email;
                    $current_user_name  = $current_user->display_name;

                    $woopra->identify(array(
                        "name" => $current_user_name,
                        "email" => $current_user_email
                    ));
                }

                $cart_products = '';

                if (sizeof($order->get_items()) > 0) {
                    foreach ($order->get_items() as $item) {
                        $cart_products .= $item['name'] . ',';
                    }
                }

                $cart_products = rtrim($cart_products, ',');
                $order         = new WC_Order($order_id);
                $woopra_params = array(
                    "order number" => $order->get_order_number(),
                    "order subtotal" => $order->get_subtotal(),
                    "order total value" => $order->get_total(),
                    "order total line items quantity" => $order->get_item_count(),
                    "payment method" => $order->payment_method_title,
                    "shipping method" => $order->get_shipping_method(),
                    "order discount" => $order->get_total_discount(),
                    "order currency" => $order->get_currency(),
                    "order total tax" => $order->get_total_tax(),
                    "order total shipping" => $order->get_total_shipping(),
                    "order items" => $cart_products
                );

                $woopra->track('advance tracking order complete', $woopra_params, true);
            }
        }
    }

    /**
     * Load Gosquard in Header file
     *
     */
    public function advance_ecommerce_tracking_identify_gosquard() {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable = get_option('advance_ecommerce_tracking_gosquared_section_enable');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            if (!empty($advance_ecommerce_gosquard_id) && '' !== $advance_ecommerce_gosquard_id) {
                ?>

                <script>
                    !function (g, s, q, r, d) {
                        r = g[r] = g[r] || function () {
                            (r.q = r.q || []).push(
                                arguments)
                        };
                        d = s.createElement(q);
                        q = s.getElementsByTagName(q)[0];
                        d.src = '//d1l6p2sc9645hc.cloudfront.net/tracker.js';
                        q.parentNode.insertBefore(d, q)
                    }(window, document, 'script', '_gs');
                    _gs('<?php echo esc_attr($advance_ecommerce_gosquard_id); ?>');
                </script>
                <?php
                // Create anonymous Person
                if (is_user_logged_in()) {
                    $current_user = wp_get_current_user();
                    if (!empty($current_user->ID) && !empty($current_user->user_email)) {
                        ?>
                        <script>
                            //Identify People
                            _gs('identify', {
                                id: <?php echo esc_attr($current_user->ID); ?>,
                                name: '<?php echo esc_attr($current_user->display_name); ?>',
                                email: '<?php echo esc_attr($current_user->user_email); ?>'
                            });
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        _gs('event', 'Without Login', {});
                    </script>
                    <?php
                }
            }
        }
    }

    /**
     * Gosquard Add to cart event
     */
    public function advance_ecommerce_gosquared_tracking_add_to_cart_event($cart_item_key, $product_id = 0, $quantity = 1, $variation_id = 0, $variation = array(), $cart_item_data = array()) {

        global $woocommerce;

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';
            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }
        }

        if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
            $gosquard_option = array(
                'site_token' => $advance_ecommerce_gosquard_id,
                'api_key' => $advance_ecommerce_gosquard_api_key
            );

            $cart = $woocommerce->cart;
            $cart->calculate_totals();
            $content = $cart->get_cart();
            $item    = $content[$cart_item_key];
            $product = get_product($item['variation_id'] ? $item['variation_id'] : $item['product_id']);

            $gs_advance_tracking = new GoSquared($gosquard_option);

            $gs_advance_tracking->track_event('Advance Tracking Item Added to Cart', array(
                "item_sku" => $product->get_sku(),
                "item_title" => $product->get_title(),
                "item_price" => $product->get_price(),
                "quantity" => $quantity,
                "value" => $quantity * $product->get_price()
            ), array(
                    "item_sku" => $product->get_sku(),
                    "item_title" => $product->get_title(),
                    "item_price" => $product->get_price(),
                    "quantity" => $quantity,
                    "value" => $quantity * $product->get_price()
                )
            );

            if (is_user_logged_in()) {
                $current_user    = wp_get_current_user();
                $current_user_id = $current_user->ID;

                // Associate event with a user
                $person = $gs_advance_tracking->Person($current_user_id);

                $person->track_event('Advance Tracking Item Added to Cart', array(
                    "item_sku" => $product->get_sku(),
                    "item_title" => $product->get_title(),
                    "item_price" => $product->get_price(),
                    "quantity" => $quantity,
                    "value" => $quantity * $product->get_price()
                ), array(
                        "item_sku" => $product->get_sku(),
                        "item_title" => $product->get_title(),
                        "item_price" => $product->get_price(),
                        "quantity" => $quantity,
                        "value" => $quantity * $product->get_price()
                    )
                );
            }
        }
    }

    /**
     * Load script GoSquard into Header
     *
     */
    public function load_gosquard_script_in_header() {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {
            // Create anonymous Person
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                if (!empty($current_user->ID) && !empty($current_user->user_email)) {
                    ?>
                    <script>
                        //Identify People
                        _gs('identify', {
                            id: <?php echo esc_attr($current_user->ID); ?>,
                            name: '<?php echo esc_attr($current_user->display_name); ?>',
                            email: '<?php echo esc_attr($current_user->user_email); ?>'
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    _gs('event', 'Without Login', {});
                </script>
                <?php
            }
        }
    }

    /**
     * Gosquard tracking if item removed from cart
     *
     * @param unknown_type $removed_cart_item_key
     * @param unknown_type $instance
     */
    public function advance_ecommerce_gosquared_tracking_cart_item_removed($removed_cart_item_key, $instance) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';
            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }

            // Create anonymous Person
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                if (!empty($current_user->ID) && !empty($current_user->user_email)) {
                    ?>
                    <script>
                        //Identify People
                        _gs('identify', {
                            id: <?php echo esc_attr($current_user->ID); ?>,
                            name: '<?php echo esc_attr($current_user->display_name); ?>',
                            email: '<?php echo esc_attr($current_user->user_email); ?>'
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    _gs('event', 'Without Login', {});
                </script>
                <?php
            }
        }

        if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
            $gosquard_option = array(
                'site_token' => $advance_ecommerce_gosquard_id,
                'api_key' => $advance_ecommerce_gosquard_api_key
            );


            $gs_advance_tracking = new GoSquared($gosquard_option);
            $line_item           = $instance->removed_cart_contents[$removed_cart_item_key];
            $product             = get_product($line_item['variation_id'] ? $line_item['variation_id'] : $line_item['product_id']);

            $gs_advance_tracking->track_event('Advance Tracking Item Removed From Cart', array(
                "item_sku" => $product->get_sku(),
                "item_title" => $product->get_title(),
                "item_price" => $product->get_price(),
                "quantity" => -$line_item['quantity'],
                "value" => -$line_item['quantity'] * $product->get_price()
            ), array(
                    "item_sku" => $product->get_sku(),
                    "item_title" => $product->get_title(),
                    "item_price" => $product->get_price(),
                    "quantity" => -$line_item['quantity'],
                    "value" => -$line_item['quantity'] * $product->get_price()
                )
            );

            if (is_user_logged_in()) {
                $current_user    = wp_get_current_user();
                $current_user_id = $current_user->ID;

                // Associate event with a user
                $person = $gs_advance_tracking->Person($current_user_id);

                $person->track_event('Advance Tracking Item Removed From Cart', array(
                    "item_sku" => $product->get_sku(),
                    "item_title" => $product->get_title(),
                    "item_price" => $product->get_price(),
                    "quantity" => -$line_item['quantity'],
                    "value" => -$line_item['quantity'] * $product->get_price()
                ), array(
                        "item_sku" => $product->get_sku(),
                        "item_title" => $product->get_title(),
                        "item_price" => $product->get_price(),
                        "quantity" => -$line_item['quantity'],
                        "value" => -$line_item['quantity'] * $product->get_price()
                    )
                );
            }
        }
    }

    /**
     * Gosquard Item 0 cart empty
     *
     */
    public function advance_ecommerce_gosquared_tracking_item_quantity_zero() {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';
            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }

            // Create anonymous Person
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                if (!empty($current_user->ID) && !empty($current_user->user_email)) {
                    ?>
                    <script>
                        //Identify People
                        _gs('identify', {
                            id: <?php echo esc_attr($current_user->ID); ?>,
                            name: '<?php echo esc_attr($current_user->display_name); ?>',
                            email: '<?php echo esc_attr($current_user->user_email); ?>'
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    _gs('event', 'Without Login', {});
                </script>
                <?php
            }
        }

        if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
            $gosquard_option = array(
                'site_token' => $advance_ecommerce_gosquard_id,
                'api_key' => $advance_ecommerce_gosquard_api_key
            );

            $gs_advance_tracking = new GoSquared($gosquard_option);
            $gs_advance_tracking->track_event('Advance Tracking Cart Item Removed', array(
                'additional' => 'Cart Item Removed'
            ));

            if (is_user_logged_in()) {
                $current_user    = wp_get_current_user();
                $current_user_id = $current_user->ID;

                // Associate event with a user
                $person = $gs_advance_tracking->Person($current_user_id);
                $person->track_event('Advance Tracking Cart Item Removed', array(
                    'additional' => 'Cart Item Removed'
                ));
            }
        }
    }

    /**
     * Update Cart Item and Track
     *
     * @param unknown_type $cart_item_key
     * @param unknown_type $quantity
     */
    public function advance_ecommerce_gosquared_tracking_item_quantity_update($cart_item_key, $quantity = 1) {
        global $woocommerce;

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';
            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }

            // Create anonymous Person
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                if (!empty($current_user->ID) && !empty($current_user->user_email)) {
                    ?>
                    <script>
                        //Identify People
                        _gs('identify', {
                            id: <?php echo esc_attr($current_user->ID); ?>,
                            name: '<?php echo esc_attr($current_user->display_name); ?>',
                            email: '<?php echo esc_attr($current_user->user_email); ?>'
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    _gs('event', 'Without Login', {});
                </script>
                <?php
            }
        }

        if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
            $gosquard_option = array(
                'site_token' => $advance_ecommerce_gosquard_id,
                'api_key' => $advance_ecommerce_gosquard_api_key
            );

            $gs_advance_tracking                    = new GoSquared($gosquard_option);
            $cart                                   = $woocommerce->cart;
            $cart_quantity_array                    = array();
            $cart_quantity_array['cart_quantities'] = $cart->get_cart_item_quantities();
            $cart->calculate_totals();
            $content  = $cart->get_cart();
            $item     = $content[$cart_item_key];
            $product  = get_product($item['variation_id'] ? $item['variation_id'] : $item['product_id']);
            $quantity = $item["quantity"];

            $gs_advance_tracking->track_event('Advance Tracking Cart Updated', array(
                "item_sku" => $product->get_sku(),
                "item_title" => $product->get_title(),
                "item_price" => $product->get_price(),
                "quantity" => $quantity,
                "value" => $quantity * $product->get_price()
            ), array(
                    "item_sku" => $product->get_sku(),
                    "item_title" => $product->get_title(),
                    "item_price" => $product->get_price(),
                    "quantity" => $quantity,
                    "value" => $quantity * $product->get_price()
                )
            );

            if (is_user_logged_in()) {
                $current_user    = wp_get_current_user();
                $current_user_id = $current_user->ID;

                // Associate event with a user
                $person = $gs_advance_tracking->Person($current_user_id);

                $person->track_event('Advance Tracking Cart Updated', array(
                    "item_sku" => $product->get_sku(),
                    "item_title" => $product->get_title(),
                    "item_price" => $product->get_price(),
                    "quantity" => $quantity,
                    "value" => $quantity * $product->get_price()
                ), array(
                        "item_sku" => $product->get_sku(),
                        "item_title" => $product->get_title(),
                        "item_price" => $product->get_price(),
                        "quantity" => $quantity,
                        "value" => $quantity * $product->get_price()
                    )
                );
            }
        }
    }

    /**
     * Track Order while Place order through Gosquard
     *
     * @param unknown_type $order_id
     * @param unknown_type $params
     */
    public function advance_ecommerce_gosquared_tracking_track_checkout($order_id, $params) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');
        $order                                                         = new WC_Order($order_id);

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';
            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }

            // Create anonymous Person
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                if (!empty($current_user->ID) && !empty($current_user->user_email)) {
                    ?>
                    <script>
                        //Identify People
                        _gs('identify', {
                            id: <?php echo esc_attr($current_user->ID); ?>,
                            name: '<?php echo esc_attr($current_user->display_name); ?>',
                            email: '<?php echo esc_attr($current_user->user_email); ?>'
                        });
                    </script>
                    <?php
                }
            } else {

                $user_full_name     = '';
                $user_billing_email = '';
                if (!empty($params["billing_first_name"]) && !empty($params["billing_last_name"])) {
                    $user_full_name = $params["billing_first_name"] . " " . $params["billing_last_name"];
                }

                if (!empty($params["billing_email"])) {
                    $user_billing_email = $params["billing_email"];
                }
                ?>
                <script>
                    _gs('identify', {
                        name: '<?php echo esc_attr($user_full_name); ?>',
                        email: '<?php echo esc_attr($user_billing_email); ?>'
                    });
                </script>
                <?php
            }
        }

        if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
            $gosquard_option = array(
                'site_token' => $advance_ecommerce_gosquard_id,
                'api_key' => $advance_ecommerce_gosquard_api_key
            );

            $gs_advance_tracking = new GoSquared($gosquard_option);


            $advance_tracking_coupon_used = array();
            $advance_tracking_coupon_used = $order->get_used_coupons();

            $coupon_used = '';
            if (!empty($advance_tracking_coupon_used) && isset($advance_tracking_coupon_used)) {
                $coupon_used = $advance_tracking_coupon_used[0];
            }

            $cart_products = '';

            if (sizeof($order->get_items()) > 0) {
                foreach ($order->get_items() as $item) {
                    $cart_products .= $item['name'] . ',';
                }
            }

            $gs_advance_tracking->track_event('Advance Tracking Placed Order', array(
                "cart_subtotal" => $order->get_subtotal(),
                "cart_total" => $order->get_total(),
                "cart_total_quantity" => $order->get_item_count(),
                "payment_method" => $order->payment_method_title,
                "shipping_method" => $order->get_shipping_method(),
                "order_discount" => $order->get_total_discount(),
                "order_number" => $order->get_order_number(),
                "order_items" => $cart_products,
                "coupon_used" => $coupon_used
            ), array(
                    "cart_subtotal" => $order->get_subtotal(),
                    "cart_total" => $order->get_total(),
                    "cart_total_quantity" => $order->get_item_count(),
                    "payment_method" => $order->payment_method_title,
                    "shipping_method" => $order->get_shipping_method(),
                    "order_discount" => $order->get_total_discount(),
                    "order_number" => $order->get_order_number(),
                    "order_items" => $cart_products,
                    "coupon_used" => $coupon_used
                )
            );

            if (is_user_logged_in()) {
                $current_user    = wp_get_current_user();
                $current_user_id = $current_user->ID;

                // Associate event with a user
                $person = $gs_advance_tracking->Person($current_user_id);

                $person->track_event('Advance Tracking Placed Order', array(
                    "cart_subtotal" => $order->get_subtotal(),
                    "cart_total" => $order->get_total(),
                    "cart_total_quantity" => $order->get_item_count(),
                    "payment_method" => $order->payment_method_title,
                    "shipping_method" => $order->get_shipping_method(),
                    "order_discount" => $order->get_total_discount(),
                    "order_number" => $order->get_order_number(),
                    "order_items" => $cart_products,
                    "coupon_used" => $coupon_used
                ), array(
                        "cart_subtotal" => $order->get_subtotal(),
                        "cart_total" => $order->get_total(),
                        "cart_total_quantity" => $order->get_item_count(),
                        "payment_method" => $order->payment_method_title,
                        "shipping_method" => $order->get_shipping_method(),
                        "order_discount" => $order->get_total_discount(),
                        "order_number" => $order->get_order_number(),
                        "order_items" => $cart_products,
                        "coupon_used" => $coupon_used
                    )
                );
            }
        }
    }

    /**
     * Gosquard Tracking when Coupon applied
     *
     * @param unknown_type $coupon_code
     */
    public function advance_ecommerce_gosquared_tracking_track_coupon($coupon_code) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';
            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }

            // Create anonymous Person
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                if (!empty($current_user->ID) && !empty($current_user->user_email)) {
                    ?>
                    <script>
                        //Identify People
                        _gs('identify', {
                            id: <?php echo esc_attr($current_user->ID); ?>,
                            name: '<?php echo esc_attr($current_user->display_name); ?>',
                            email: '<?php echo esc_attr($current_user->user_email); ?>'
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    _gs('event', 'Without Login', {});
                </script>
                <?php
            }
        }

        if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
            $gosquard_option = array(
                'site_token' => $advance_ecommerce_gosquard_id,
                'api_key' => $advance_ecommerce_gosquard_api_key
            );

            $gs_advance_tracking = new GoSquared($gosquard_option);

            $coupon = new WC_COUPON($coupon_code);

            if ($coupon->is_valid()) {
                $gs_advance_tracking->track_event('Advance Tracking Coupon Applied', array(
                    "coupon_code" => $coupon->code,
                    "discount_type" => $coupon->discount_type,
                    "coupon_amount" => $coupon->amount
                ), array(
                        "coupon_code" => $coupon->code,
                        "discount_type" => $coupon->discount_type,
                        "coupon_amount" => $coupon->amount
                    )
                );

                if (is_user_logged_in()) {
                    $current_user    = wp_get_current_user();
                    $current_user_id = $current_user->ID;

                    // Associate event with a user
                    $person = $gs_advance_tracking->Person($current_user_id);

                    $person->track_event('Advance Tracking Coupon Applied', array(
                        "coupon_code" => $coupon->code,
                        "discount_type" => $coupon->discount_type,
                        "coupon_amount" => $coupon->amount
                    ), array(
                            "coupon_code" => $coupon->code,
                            "discount_type" => $coupon->discount_type,
                            "coupon_amount" => $coupon->amount
                        )
                    );
                }
            }
        }
    }

    /**
     * Gosquard Tracking register for User Register
     *
     * @param unknown_type $user_id
     */
    public function advance_ecommerce_gosquard_tracking_track_signup($user_id) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {

            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';
            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }
        }

        if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
            $gosquard_option = array(
                'site_token' => $advance_ecommerce_gosquard_id,
                'api_key' => $advance_ecommerce_gosquard_api_key
            );

            $gs_advance_tracking = new GoSquared($gosquard_option);

            $wp_advance_user = get_user_by('id', $user_id);

            if (!($wp_advance_user instanceof WP_User)) {
                return;
            }

            $user_email     = '';
            $user_nice_name = '';
            $user_email     = $wp_advance_user->user_email;
            $user_nice_name = $wp_advance_user->user_login;

            $gs_advance_tracking->track_event('Advance Tracking User Register', array(
                "user_email" => $user_email,
                "user_nice_name" => $user_nice_name
            ), array(
                    "user_email" => $user_email,
                    "user_nice_name" => $user_nice_name
                )
            );

            if (!empty($user_id)) {

                // Associate event with a user
                $person = $gs_advance_tracking->Person($user_id);

                $person->track_event('Advance Tracking User Register', array(
                    "user_email" => $user_email,
                    "user_nice_name" => $user_nice_name
                ), array(
                        "user_email" => $user_email,
                        "user_nice_name" => $user_nice_name
                    )
                );
            }
        }
    }

    /**
     * Load gosquard tracking script
     *
     */
    function advance_ecommerce_tracking_gosquard($order) {

        //Check Advance Go squard Tracking is Enable
        $advance_ecommerce_tracking_gosquared_section_enable           = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_section_gosquared_tracking_api_key = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');

        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {
            $transaction_id = $order->id;
            $cart_products  = '';

            if (sizeof($order->get_items()) > 0) {
                foreach ($order->get_items() as $item) {
                    $cart_products .= $item['name'] . ',';
                }
            }

            $cart_products                                            = rtrim($cart_products, ',');
            $current_user                                             = wp_get_current_user();
            $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
            $advance_ecommerce_gosquard_id                            = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
            } else {
                $advance_ecommerce_gosquard_id = '';
            }

            $advance_ecommerce_gosquard_api_key = '';

            if (isset($advance_ecommerce_tracking_section_gosquared_tracking_api_key) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_api_key)) {
                $advance_ecommerce_gosquard_api_key = $advance_ecommerce_tracking_section_gosquared_tracking_api_key;
            } else {
                $advance_ecommerce_gosquard_api_key = '';
            }

            if (!empty($_SERVER['HTTP_REFERER'])) {
                if (!empty($advance_ecommerce_gosquard_id) && !empty($advance_ecommerce_gosquard_api_key)) {
                    $opts = array(
                        'site_token' => $advance_ecommerce_gosquard_id,
                        'api_key' => $advance_ecommerce_gosquard_api_key
                    );

                    $gs_advance_tracking                                      = new GoSquared($opts);
                    $advance_ecommerce_tracking_section_gosquared_tracking_id = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
                    if (isset($advance_ecommerce_tracking_section_gosquared_tracking_id) && !empty($advance_ecommerce_tracking_section_gosquared_tracking_id)) {
                        $advance_ecommerce_gosquard_id = $advance_ecommerce_tracking_section_gosquared_tracking_id;
                    }

                    $advance_tracking_coupon_used = array();
                    $advance_tracking_coupon_used = $order->get_used_coupons();

                    $coupon_used = '';
                    if (!empty($advance_tracking_coupon_used) && isset($advance_tracking_coupon_used)) {
                        $coupon_used = $advance_tracking_coupon_used[0];
                    }

                    $gs_advance_tracking->track_event('Advance Tracking Order Completed', array(
                        "order_number" => $order->get_order_number(),
                        "cart_subtotal" => $order->get_subtotal(),
                        "cart_total" => $order->get_total(),
                        "cart_total_quantity" => $order->get_item_count(),
                        "payment_method" => $order->payment_method_title,
                        "shipping_method" => $order->get_shipping_method(),
                        "order_discount" => $order->get_total_discount(),
                        "order_currency" => $order->get_currency(),
                        "order_total_tax" => $order->get_total_tax(),
                        "order_total_shipping" => $order->get_total_shipping(),
                        "order_items" => $cart_products,
                        "coupon_used" => $coupon_used
                    ), array(
                            "order_number" => $order->get_order_number(),
                            "cart_subtotal" => $order->get_subtotal(),
                            "cart_total" => $order->get_total(),
                            "cart_total_quantity" => $order->get_item_count(),
                            "payment_method" => $order->payment_method_title,
                            "shipping_method" => $order->get_shipping_method(),
                            "order_discount" => $order->get_total_discount(),
                            "order_currency" => $order->get_currency(),
                            "order_total_tax" => $order->get_total_tax(),
                            "order_total_shipping" => $order->get_total_shipping(),
                            "order_items" => $cart_products,
                            "coupon_used" => $coupon_used
                        )
                    );

                    if (is_user_logged_in()) {
                        $current_user    = wp_get_current_user();
                        $current_user_id = $current_user->ID;

                        // Associate event with a user
                        $person = $gs_advance_tracking->Person($current_user_id);

                        $person->track_event('Advance Tracking Order Completed', array(
                            "order_number" => $order->get_order_number(),
                            "cart_subtotal" => $order->get_subtotal(),
                            "cart_total" => $order->get_total(),
                            "cart_total_quantity" => $order->get_item_count(),
                            "payment_method" => $order->payment_method_title,
                            "shipping_method" => $order->get_shipping_method(),
                            "order_discount" => $order->get_total_discount(),
                            "order_currency" => $order->get_currency(),
                            "order_total_tax" => $order->get_total_tax(),
                            "order_total_shipping" => $order->get_total_shipping(),
                            "order_items" => $cart_products,
                            "coupon_used" => $coupon_used
                        ), array(
                                "order_number" => $order->get_order_number(),
                                "cart_subtotal" => $order->get_subtotal(),
                                "cart_total" => $order->get_total(),
                                "cart_total_quantity" => $order->get_item_count(),
                                "payment_method" => $order->payment_method_title,
                                "shipping_method" => $order->get_shipping_method(),
                                "order_discount" => $order->get_total_discount(),
                                "order_currency" => $order->get_currency(),
                                "order_total_tax" => $order->get_total_tax(),
                                "order_total_shipping" => $order->get_total_shipping(),
                                "order_items" => $cart_products,
                                "coupon_used" => $coupon_used
                            )
                        );
                    }
                }

                $tracking_opts = array(
                    // if you wish to explicitly set revenue and quantity totals
                    // for this transaction, specify them here. They will be used
                    // instead of the default totals calculated from the items.
                    'revenue' => $order->get_subtotal(),
                    'quantity' => $order->get_item_count()
                );

                $transaction = $gs_advance_tracking->Transaction($transaction_id, $tracking_opts, $tracking_opts);

                if (sizeof($order->get_items()) > 0) {

                    $all_item_array = array();

                    $i = 0;
                    foreach ($order->get_items() as $item) {
                        $all_item_array[$i]['name']     = $item['name'];
                        $all_item_array[$i]['price']    = $item['line_subtotal'];
                        $all_item_array[$i]['quantity'] = $item['qty'];
                        $i++;
                    }

                    $transaction->add_items($all_item_array);
                }

                $transaction->track();

                if (is_user_logged_in()) {
                    $current_user    = wp_get_current_user();
                    $current_user_id = $current_user->ID;

                    // Associate event with a user
                    $person      = $gs_advance_tracking->Person($current_user_id);
                    $transaction = $person->Transaction($transaction_id, $tracking_opts, $tracking_opts);

                    if (sizeof($order->get_items()) > 0) {

                        $all_item_array = array();

                        $i = 0;
                        foreach ($order->get_items() as $item) {
                            $all_item_array[$i]['name']     = $item['name'];
                            $all_item_array[$i]['price']    = $item['line_subtotal'];
                            $all_item_array[$i]['quantity'] = $item['qty'];
                            $i++;
                        }

                        $transaction->add_items($all_item_array);
                    }

                    $transaction->track();
                }
            }
        }
    }

    /**
     * Call the event object
     *
     * @param string $event_name
     * @param array $params
     * @param string $method
     *
     * @return string
     */
    public function call_event($event_name, $params = array(), $method) {
        return sprintf("fbq('%s', '%s', %s);", $method, $event_name, wp_json_encode($params, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));
    }

    /**
     * Call the analytics event object
     *
     * @param string $event_name
     * @param array $params
     * @param string $method
     *
     * @return string
     */
    public function call_analytics_event($event_name, $params = array(), $method) {
        return sprintf("gtag('%s', '%s', %s);", $method, $event_name, wp_json_encode($params, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));
    }
}
