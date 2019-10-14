<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Checkout_For_Digital_Goods
 * @subpackage Woo_Checkout_For_Digital_Goods/public
 */
class Woo_Checkout_For_Digital_Goods_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-checkout-for-digital-goods-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-checkout-for-digital-goods-public.js', array('jquery'), $this->version, false);
    }

    /**
     * Function for remove checkout fields.
     */
    public function wcdg_override_checkout_fields($fields) {
        $woo_checkout_unserlize_array = maybe_unserialize(get_option('wcdg_checkout_setting'));
        $woo_checkout_field_array = isset($woo_checkout_unserlize_array['wcdg_chk_field'])? $woo_checkout_unserlize_array['wcdg_chk_field'] : '';
        $woo_checkout_order_note = isset($woo_checkout_unserlize_array['wcdg_chk_order_note'])? $woo_checkout_unserlize_array['wcdg_chk_order_note'] : '';

	    $temp_product_flag = 1;
        
        add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');

	    // basic checks
	    foreach (WC()->cart->get_cart() as $values) {
		    $_product = $values['data'];
		    if ( ! $_product->is_virtual() && ! $_product->is_downloadable()) {
			    $temp_product_flag = 0; break;
		    }
	    }
	    if (0 === $temp_product_flag ) {
            return $fields;
        } else {
            if(!empty($woo_checkout_order_note)){
                unset($fields['order']['order_comments']);
            }
            if (isset($woo_checkout_field_array) && !empty($woo_checkout_field_array)) {
                foreach ( $woo_checkout_field_array as $values ) {
                    unset( $fields['billing'][ $values ] );
                }
            } else{
                unset($fields['billing']['billing_first_name']);
                unset($fields['billing']['billing_last_name']);
                unset($fields['billing']['billing_company']);
                unset($fields['billing']['billing_address_1']);
                unset($fields['billing']['billing_address_2']);
                unset($fields['billing']['billing_city']);
                unset($fields['billing']['billing_postcode']);
                unset($fields['billing']['billing_country']);
                unset($fields['billing']['billing_state']);
                unset($fields['billing']['billing_phone']);
                return $fields;
            }
        }
        return $fields;
    }
    /**
     * Function for insert quick checkout button after add to cart button.
     */
    public function wcdg_add_quick_checkout_after_add_to_cart_product_page() {
        
        $woo_checkout_unserlize_array = maybe_unserialize(get_option('wcdg_checkout_setting'));
        global $product;
        if( 'wcdg_down_virtual' === $woo_checkout_unserlize_array['wcdg_chk_on'] ){

            if ($product-> is_virtual('yes') || $product->is_downloadable('yes')) {
                $addtocart_url = wc_get_checkout_url().'?add-to-cart='.$product->get_id();
                $button_class  = 'single_add_to_cart_button button alt custom-checkout-btn';

                if( $product->is_type( 'simple' ) && ($product-> is_virtual('yes') || $product->is_downloadable('yes'))) :
                ?>
                <script>
                jQuery(function($) {
                    var url    = '<?php echo esc_url($addtocart_url); ?>',
                        qty    = 'input.qty',
                        button = 'a.custom-checkout-btn';

                    // On input/change quantity event
                    $(qty).on('input change', function() {
                        $(button).attr('href', url + '&quantity=' + $(this).val() );
                    });
                });
                </script>
                <?php

                elseif( $product->is_type( 'variable' ) ) : 

                $addtocart_url = wc_get_checkout_url().'?add-to-cart=';
                ?>
                <script>
                jQuery(function($) {
                    var url    = '<?php echo esc_url($addtocart_url); ?>',
                        vid    = 'input[name="variation_id"]',
                        pid    = 'input[name="product_id"]',
                        qty    = 'input.qty',
                        button = 'a.custom-checkout-btn';

                    // Once DOM is loaded
                    setTimeout( function(){
                        if( $(vid).val() != '' ){
                            $(button).attr('href', url + $(vid).val() + '&quantity=' + $(qty).val() );
                        }
                    }, 300 );

                    // On input/change quantity event
                    $(qty).on('input change', function() {
                        if( $(vid).val() != '' ){
                            $(button).attr('href', url + $(vid).val() + '&quantity=' + $(this).val() );
                        }
                    });

                    // On select attribute field change event
                    $('.variations_form').on('change blur', 'table.variations select', function() {
                        if( $(vid).val() != '' ){
                            $(button).attr('href', url + $(vid).val() + '&quantity=' + $(qty).val() );
                        }
                    });
                });
                </script>
                <?php
                endif;
                echo '<a href="'.esc_url($addtocart_url).'" class="'.esc_attr($button_class).'">'.esc_html__( "Quick Checkout", WCDG_TEXT_DOMAIN).'</a>';
            }
        }
        if ( wcfdg_fs()->is__premium_only() ) {
            if ( wcfdg_fs()->can_use_premium_code() ) {
                if( 'wcdg_chk_list' === $woo_checkout_unserlize_array['wcdg_chk_on'] ) {
                    // Check List in Category 
                    $cat_terms = get_the_terms( get_the_ID(), 'product_cat' );
                    $cat_flag = 0;
                    if (is_array($cat_terms)) {
                        foreach($cat_terms as $c_term){
                            $c_term_id = $c_term->term_id;
                            if(get_term_meta( $c_term_id, 'wcdg_chk_category', true)){
                                $cat_flag = 1;
                                break;
                            }
                        }
                    }
                    // Check List in Tag 
                    $tag_terms = get_the_terms( get_the_ID(), 'product_tag' );
                    $tag_flag = 0;
                    if (is_array($tag_terms)) {
                        foreach($tag_terms as $t_term){
                            $t_term_id = $t_term->term_id;
                            if(get_term_meta( $t_term_id, 'wcdg_chk_tag', true)){
                                $tag_flag = 1;
                                break;
                            }
                        }
                    }
                    
                    if( get_post_meta(get_the_ID(),'_wcdg_chk_product',true) || ($cat_flag !== 0 ) || ($tag_flag !== 0 ) ){
                        $addtocart_url = wc_get_checkout_url().'?add-to-cart='.$product->get_id();
                        $button_class  = 'single_add_to_cart_button button alt custom-checkout-btn';

                        if( $product->is_type( 'simple' ) && ($product-> is_virtual('yes') || $product->is_downloadable('yes'))) :
                        ?>
                        <script>
                        jQuery(function($) {
                            var url    = '<?php echo esc_url($addtocart_url); ?>',
                                qty    = 'input.qty',
                                button = 'a.custom-checkout-btn';

                            // On input/change quantity event
                            $(qty).on('input change', function() {
                                $(button).attr('href', url + '&quantity=' + $(this).val() );
                            });
                        });
                        </script>
                        <?php

                        elseif( $product->is_type( 'variable' ) ) :

                        $addtocart_url = wc_get_checkout_url().'?add-to-cart=';
                        ?>
                        <script>
                        jQuery(function($) {
                            var url    = '<?php echo esc_url($addtocart_url); ?>',
                                vid    = 'input[name="variation_id"]',
                                pid    = 'input[name="product_id"]',
                                qty    = 'input.qty',
                                button = 'a.custom-checkout-btn';

                            // Once DOM is loaded
                            setTimeout( function(){
                                if( $(vid).val() != '' ){
                                    $(button).attr('href', url + $(vid).val() + '&quantity=' + $(qty).val() );
                                }
                            }, 300 );

                            // On input/change quantity event
                            $(qty).on('input change', function() {
                                if( $(vid).val() != '' ){
                                    $(button).attr('href', url + $(vid).val() + '&quantity=' + $(this).val() );
                                }
                            });

                            // On select attribute field change event
                            $('.variations_form').on('change blur', 'table.variations select', function() {
                                if( $(vid).val() != '' ){
                                    $(button).attr('href', url + $(vid).val() + '&quantity=' + $(qty).val() );
                                }
                            });
                        });
                        </script>
                        <?php
                        endif;
                        echo '<a href="'.esc_url($addtocart_url).'" class="'.esc_attr($button_class).'">'.esc_html__( "Quick Checkout", WCDG_TEXT_DOMAIN).'</a>';
                    }
                }
            }
        }
    }
    /**
     * Quick Checkout Button on shop page
    */
    public function wcdg_add_quick_checkout_after_add_to_cart_shop_page() {

        $woo_checkout_unserlize_array = maybe_unserialize(get_option('wcdg_checkout_setting'));
        global $product;
        if( 'wcdg_down_virtual' === $woo_checkout_unserlize_array['wcdg_chk_on'] ){

            if ($product-> is_virtual('yes') || $product->is_downloadable('yes')) {
                // get the current post/product ID
                $current_product_id = get_the_ID();

                // get the product based on the ID
                $product = wc_get_product( $current_product_id );

                // get the "Checkout Page" URL
                $checkout_url = wc_get_checkout_url();

                // run only on simple products
                if( $product->is_type( 'simple' ) ){
                    $url = $checkout_url.'?add-to-cart='.$current_product_id;
                    echo '<a href="'.esc_url($url).'" class="single_add_to_cart_button button alt">'.esc_html__( "Quick Checkout", WCDG_TEXT_DOMAIN).'</a>';
                }
            } 
        }
        if ( wcfdg_fs()->is__premium_only() ) {
            if ( wcfdg_fs()->can_use_premium_code() ) {
                if( 'wcdg_chk_list' === $woo_checkout_unserlize_array['wcdg_chk_on'] ){
                    $current_product_id = get_the_ID();
                    // Check List in Category 
                    $cat_terms = get_the_terms( $current_product_id, 'product_cat' );
                    $cat_flag = 0;
                    if (is_array($cat_terms)) {
                        foreach($cat_terms as $c_term){
                            $c_term_id = $c_term->term_id;
                            if(get_term_meta( $c_term_id, 'wcdg_chk_category', true)){
                                $cat_flag = 1;
                                break;
                            }
                        }
                    }
                    // Check List in Tag 
                    $tag_terms = get_the_terms( $current_product_id, 'product_tag' );
                    $tag_flag = 0;
                    if (is_array($tag_terms)) {
                        foreach($tag_terms as $t_term){
                            $t_term_id = $t_term->term_id;
                            if(get_term_meta( $t_term_id, 'wcdg_chk_tag', true)){
                                $tag_flag = 1;
                                break;
                            }
                        }
                    }
                    
                    if( get_post_meta($current_product_id,'_wcdg_chk_product',true) || ($cat_flag !== 0 ) || ($tag_flag !== 0 ) ){
                        if ($product-> is_virtual('yes') || $product->is_downloadable('yes')) {

                            // get the product based on the ID
                            $product = wc_get_product( $current_product_id );

                            // get the "Checkout Page" URL
                            $checkout_url = wc_get_checkout_url();

                            // run only on simple products
                            if( $product->is_type( 'simple' ) ){
                                $url = $checkout_url.'?add-to-cart='.$current_product_id;
                                echo '<a href="'.esc_url($url).'" class="single_add_to_cart_button button alt">'.esc_html__( "Quick Checkout", WCDG_TEXT_DOMAIN).'</a>';
                            }
                        }
                    } 
                } 
            }
        }      
    }
    /**
     * Delay account for new user registration
     */
    public function wcdg_delay_register_guests($order_id){ 
       // get all the order data
        $order = wc_get_order( $order_id );
        $order_data = $order->get_data();

        //get the user email from the order
        $order_email = $order_data['billing']['email'];
            
        // check if there are any users with the billing email as user or email
        $email = email_exists( $order_email );  
        $user = username_exists( $order_email );
          
        // if the UID is null, then it's a guest checkout
        if( false === $user && false === $email ){
            // random password with 12 chars
            $random_password = wp_generate_password();
            // create new user with email as username & newly created pw
            $user_id = wp_create_user( $order_email, $random_password, $order_email );
            $user_id_role = new WP_User($user_id);
            $user_id_role->set_role('customer');
            wc_update_new_customer_past_orders( $user_id );
            $wc_emails = WC()->mailer()->get_emails();
            $wc_emails['WC_Email_Customer_New_Account']->trigger( $user_id, $random_password, true);
             echo '<label class="wcdg_update">' . esc_html__( 'Please check your email for login details and update your remaining billing details.', WCDG_TEXT_DOMAIN ) . '</label>';
        }
       
        echo '<a href="'.esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )).'" class="button wcdg_delay_account">' . esc_html__( 'My Account', WCDG_TEXT_DOMAIN ) . '</a>';
    } 

    /**
     * BN code added
     */
    function paypal_bn_code_filter_woo_checkout_field($paypal_args) {
        $paypal_args['bn'] = 'Multidots_SP';
        return $paypal_args;
    }
}