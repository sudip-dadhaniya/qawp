<?php
if (!defined('ABSPATH')) exit;
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/admin
 * @author     Multidots <info@multidots.com>
 */
class Advance_Ecommerce_Tracking_Admin {

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
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    function enqueue_styles() {

        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
        if (isset($page) && !empty($page) && 'ecommerce_tracking_pro' === $page) {
            wp_enqueue_style($this->plugin_name . 'font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style('fancybox-css', plugin_dir_url(__FILE__) . 'css/jquery.fancybox.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/advance-ecommerce-tracking-admin.css', array(), $this->version, 'all');
            wp_enqueue_style('advance-ecommerce-tracking-main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version);
            wp_enqueue_style('advance-ecommerce-tracking-media', plugin_dir_url(__FILE__) . 'css/media.css', array(), $this->version);
            wp_enqueue_style('advance-ecommerce-tracking-webkit', plugin_dir_url(__FILE__) . 'css/webkit.css', array(), $this->version);
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    function enqueue_scripts() {

        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
        if (isset($page) && !empty($page) && 'ecommerce_tracking_pro' === $page) {
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_script('fancy-box', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.js', array('jquery'), $this->version);
            wp_enqueue_script('fancybox', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.pack.js', array('jquery'), $this->version);
            wp_enqueue_script('fancybox-buttons', plugin_dir_url(__FILE__) . 'js/jquery.fancybox-buttons.js', array('jquery'), $this->version);
            wp_enqueue_script('fancybox-media', plugin_dir_url(__FILE__) . 'js/jquery.fancybox-media.js', array('jquery'), $this->version);
            wp_enqueue_script('fancybox-thumbs', plugin_dir_url(__FILE__) . 'js/jquery.fancybox-thumbs.js', array('jquery'), $this->version);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/advance-ecommerce-tracking-admin.js', array('jquery', 'jquery-ui-dialog'), $this->version, false);
        }
    }

    /**
     * Actions registered that should be performed when admin is initialized.
     *
     * @since    1.0.0
     */
    function do_admin_init_actions() {

        $submit_google_ecommerce_tracking_settings = filter_input(INPUT_POST, 'submit_google_ecommerce_tracking_settings', FILTER_SANITIZE_STRING);
        $google_analytics_submit_nonce             = filter_input(INPUT_POST, 'google-analytics-tracking-nonce', FILTER_SANITIZE_STRING);
        if (isset($submit_google_ecommerce_tracking_settings) && wp_verify_nonce($google_analytics_submit_nonce, 'google-analytics-tracking')) {
            $this->update_google_ecommerce_tracking_settings();
        }

        $submit_google_adwords_conversion_settings = filter_input(INPUT_POST, 'submit_google_adwords_conversion_settings', FILTER_SANITIZE_STRING);
        $google_adwords_conversion_submit_nonce    = filter_input(INPUT_POST, 'adwords-conversion-tracking-nonce', FILTER_SANITIZE_STRING);
        if (isset($submit_google_adwords_conversion_settings) && wp_verify_nonce($google_adwords_conversion_submit_nonce, 'adwords-conversion-tracking')) {
            $this->update_google_adwords_conversion_settings();
        }

        $submit_woopra_settings       = filter_input(INPUT_POST, 'submit_woopra_settings', FILTER_SANITIZE_STRING);
        $submit_woopra_settings_nonce = filter_input(INPUT_POST, 'woopra-tracking-nonce', FILTER_SANITIZE_STRING);
        if (isset($submit_woopra_settings) && wp_verify_nonce($submit_woopra_settings_nonce, 'woopra-tracking')) {
            $this->update_woopra_tracking_settings();
        }

        $submit_gosquared_settings       = filter_input(INPUT_POST, 'submit_gosquared_settings', FILTER_SANITIZE_STRING);
        $submit_gosquared_settings_nonce = filter_input(INPUT_POST, 'gosquared-tracking-nonce', FILTER_SANITIZE_STRING);
        if (isset($submit_gosquared_settings) && wp_verify_nonce($submit_gosquared_settings_nonce, 'gosquared-tracking')) {
            $this->update_gosquared_tracking_settings();
        }

        $submit_facebook_settings       = filter_input(INPUT_POST, 'submit_facebook_settings', FILTER_SANITIZE_STRING);
        $submit_facebook_settings_nonce = filter_input(INPUT_POST, 'facebook-tracking-nonce', FILTER_SANITIZE_STRING);
        if (isset($submit_facebook_settings) && wp_verify_nonce($submit_facebook_settings_nonce, 'facebook-tracking')) {
            $this->update_facebook_tracking_settings();
        }

        $submit_twitter_settings       = filter_input(INPUT_POST, 'submit_twitter_settings', FILTER_SANITIZE_STRING);
        $submit_twitter_settings_nonce = filter_input(INPUT_POST, 'twitter-tracking-nonce', FILTER_SANITIZE_STRING);
        if (isset($submit_twitter_settings) && wp_verify_nonce($submit_twitter_settings_nonce, 'twitter-tracking')) {
            $this->update_twitter_tracking_settings();
        }

    }

    /**
     * Redirect performed when plugin is successfully activated.
     *
     * @since    1.0.0
     */
    function welcome_ecommerce_tracking_do_activation_redirect() {
        // if no activation redirect
        if (!get_transient('_welcome_ecommerce_screen_activation_redirect_data')) {
            return;
        }

        // Delete the redirect transient
        delete_transient('_welcome_ecommerce_screen_activation_redirect_data');

        // if activating from network, or bulk
        $activate_multi = filter_input(INPUT_GET, 'activate-multi', FILTER_SANITIZE_STRING);
        if (is_network_admin() || isset($activate_multi)) {
            return;
        }
        // Redirect to extra cost welcome  page
        wp_safe_redirect(add_query_arg(array('page' => 'ecommerce_tracking_pro&tab=wc_pro_ecommerce_tracking_get_started_method'), admin_url('admin.php')));
        exit;
    }

    /**
     * Function for add custom dotstore menu in admin side
     *
     *
     */
    function dot_store_menu_advanced_ecommerce_tracking_pro() {

        global $GLOBALS;
        if (empty($GLOBALS['admin_page_hooks']['dots_store'])) {
            add_menu_page(
                'DotStore Plugins', 'DotStore Plugins', 'null', 'dots_store', array($this, 'dot_store_menu_advanced_ecommerce_tracking_pro_page'), plugin_dir_url(__FILE__) . 'images/menu-icon.jpg', 25
            );
        }
        add_submenu_page('dots_store', 'WooCommerce Enhanced Ecommerce Analytics Integration With Conversion Tracking Pro', 'Enhanced Ecommerce Analytics Integration With Conversion Tracking Pro', 'manage_options', 'ecommerce_tracking_pro', array($this, 'custom_ecommerce_tracking_add_new_function_extra'));

    }

    /**
     * Function for add active menu plugin
     *
     */
    function advanced_ecommerce_tracking_pro_active_menu() {

    }

    /**
     * Function for add active menu plugin
     *
     */
    function custom_ecommerce_tracking_add_new_function_extra() {

        $tab  = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING);
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
        include_once __DIR__ . '/partials/header/plugin-header.php';
        if (!empty($tab) && 'advance_ecommerce_tracking' === $tab) include_once __DIR__ . '/partials/settings/google-analytics.php';
        if (isset($page) && !empty($page) && 'ecommerce_tracking_pro' === $page && empty($tab)) include_once __DIR__ . '/partials/settings/google-analytics.php';
        if (isset($tab) && !empty($tab) && 'section-google-tracking' === $tab) include_once __DIR__ . '/partials/settings/google-adwords.php';
        if (isset($tab) && !empty($tab) && 'section-woopra-tracking' === $tab) include_once __DIR__ . '/partials/settings/woopra.php';
        if (isset($tab) && !empty($tab) && 'section-gosquared-tracking' === $tab) include_once __DIR__ . '/partials/settings/gosquared.php';
        if (isset($tab) && !empty($tab) && 'section-facebook-tracking' === $tab) include_once __DIR__ . '/partials/settings/facebook.php';
        if (isset($tab) && !empty($tab) && 'section-twitter-tracking' === $tab) include_once __DIR__ . '/partials/settings/twitter.php';
        if (isset($tab) && !empty($tab) && 'wc_pro_ecommerce_tracking_get_started_method' === $tab) include_once __DIR__ . '/partials/plugin/get-started.php';
        if (isset($tab) && !empty($tab) && 'dotstore_introduction_ecommerce_tracking_pro' === $tab) include_once __DIR__ . '/partials/plugin/introduction.php';
        include_once __DIR__ . '/partials/header/plugin-sidebar.php';

    }

    /**
     * Function to update the google ecommerce analytics settings.
     *
     * @since    1.0.0
     */
    function update_google_ecommerce_tracking_settings() {

        global $enable_tracking;
        $enable_tracking     = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_enable', FILTER_SANITIZE_STRING);
        $google_analytics_id = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_google_uid', FILTER_SANITIZE_STRING);
        $enable_tracking     = (isset($enable_tracking) && !empty($enable_tracking)) ? 'yes' : '';
        $google_analytics_id = (isset($google_analytics_id) && !empty($google_analytics_id)) ? $google_analytics_id : '';
        if ((empty($enable_tracking) && empty($google_analytics_id)) || (!empty($enable_tracking) && 'yes' === $enable_tracking && 1 === preg_match('/^ua-\d{4,9}-\d{1,4}$/i', $google_analytics_id))) {
            update_option('advance_ecommerce_tracking_section_enable', $enable_tracking, 'no');
            update_option('advance_ecommerce_tracking_section_google_uid', $google_analytics_id, 'no');
            ?>
            <div id="message" class="notice updated"><p>
                    <strong><?php esc_html_e('Your settings have been saved.', 'advance-ecommerce-tracking'); ?></strong>
                </p></div>
            <?php
        } else {
            ?>
            <div id="message" class="notice error"><p>
                    <strong><?php esc_html_e('Please enter the google analytics ID in the valid format.', 'advance-ecommerce-tracking'); ?></strong>
                </p></div>
            <?php
        }

    }

    /**
     * Function to update the Google AdWords conversion settings.
     *
     * @since    1.0.0
     */
    function update_google_adwords_conversion_settings() {

        global $adword_conversion_data;

        $adword_conversion_data = filter_input(INPUT_POST, 'advance_ecommerce_tracking_google_section_enable', FILTER_SANITIZE_STRING);
        $conversion_id          = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_google_conversion_id', FILTER_SANITIZE_STRING);
        $conversion_label       = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_google_conversion_label', FILTER_SANITIZE_STRING);
        $adword_conversion_data = (isset($adword_conversion_data) && !empty($adword_conversion_data)) ? 'yes' : 'no';

        if ('yes' === $adword_conversion_data) {
            update_option('advance_ecommerce_tracking_google_section_enable', $adword_conversion_data, 'no');
            update_option('advance_ecommerce_tracking_section_google_conversion_id', $conversion_id, 'no');
            update_option('advance_ecommerce_tracking_section_google_conversion_label', $conversion_label, 'no');
            ?>
            <div id="message" class="notice updated"><p>
                    <strong><?php esc_html_e('Your settings have been saved.', 'advance-ecommerce-tracking'); ?></strong>
                </p></div>
            <?php
        } else {
            delete_option('advance_ecommerce_tracking_google_section_enable');
        }

    }

    /**
     * Function to update the Woopra tracking settings.
     *
     * @since    1.0.0
     */
    function update_woopra_tracking_settings() {

        global $enable_woopra_traking, $woopra_traking_domain, $enable_track_event_add_to_cart, $enable_track_event_cart_qty_remove, $enable_track_event_cart_qty_update, $enable_track_event_place_order, $enable_track_after_complete_order, $enable_track_applied_coupon, $enable_track_user_register;

        $enable_woopra_traking              = filter_input(INPUT_POST, 'advance_ecommerce_tracking_woopra_section_enable', FILTER_SANITIZE_STRING);
        $woopra_traking_domain              = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_woopra_tracking_domain', FILTER_SANITIZE_STRING);
        $enable_track_event_add_to_cart     = filter_input(INPUT_POST, 'advance_ecommerce_tracking_woopra_add_to_cart_section_enable', FILTER_SANITIZE_STRING);
        $enable_track_event_cart_qty_remove = filter_input(INPUT_POST, 'advance_ecommerce_tracking_woopra_cart_qty_remove_section_enable', FILTER_SANITIZE_STRING);
        $enable_track_event_cart_qty_update = filter_input(INPUT_POST, 'advance_ecommerce_tracking_woopra_cart_qty_update_section_enable', FILTER_SANITIZE_STRING);
        $enable_track_event_place_order     = filter_input(INPUT_POST, 'advance_ecommerce_tracking_woopra_place_order_section_enable', FILTER_SANITIZE_STRING);
        $enable_track_after_complete_order  = filter_input(INPUT_POST, 'adavance_tracking_in_woopra_after_order_complete_enable', FILTER_SANITIZE_STRING);
        $enable_track_applied_coupon        = filter_input(INPUT_POST, 'advance_ecommerce_tracking_woopra_applied_coupon_section_enable', FILTER_SANITIZE_STRING);
        $enable_track_user_register         = filter_input(INPUT_POST, 'advance_ecommerce_tracking_woopra_user_register_section_enable', FILTER_SANITIZE_STRING);
        $enable_woopra_traking              = (isset($enable_woopra_traking) && !empty($enable_woopra_traking)) ? 'yes' : 'no';
        $enable_track_event_add_to_cart     = (isset($enable_track_event_add_to_cart) && !empty($enable_track_event_add_to_cart)) ? 'yes' : 'no';
        $enable_track_event_cart_qty_remove = (isset($enable_track_event_cart_qty_remove) && !empty($enable_track_event_cart_qty_remove)) ? 'yes' : 'no';
        $enable_track_event_cart_qty_update = (isset($enable_track_event_cart_qty_update) && !empty($enable_track_event_cart_qty_update)) ? 'yes' : 'no';
        $enable_track_event_place_order     = (isset($enable_track_event_place_order) && !empty($enable_track_event_place_order)) ? 'yes' : 'no';
        $enable_track_after_complete_order  = (isset($enable_track_after_complete_order) && !empty($enable_track_after_complete_order)) ? 'yes' : 'no';
        $enable_track_applied_coupon        = (isset($enable_track_applied_coupon) && !empty($enable_track_applied_coupon)) ? 'yes' : 'no';
        $enable_track_user_register         = (isset($enable_track_user_register) && !empty($enable_track_user_register)) ? 'yes' : 'no';

        if ('yes' === $enable_woopra_traking) {
            update_option('advance_ecommerce_tracking_woopra_section_enable', $enable_woopra_traking, 'no');
            update_option('advance_ecommerce_tracking_section_woopra_tracking_domain', $woopra_traking_domain, 'no');
            update_option('advance_ecommerce_tracking_woopra_add_to_cart_section_enable', $enable_track_event_add_to_cart, 'no');
            update_option('advance_ecommerce_tracking_woopra_cart_qty_remove_section_enable', $enable_track_event_cart_qty_remove, 'no');
            update_option('advance_ecommerce_tracking_woopra_cart_qty_update_section_enable', $enable_track_event_cart_qty_update, 'no');
            update_option('advance_ecommerce_tracking_woopra_place_order_section_enable', $enable_track_event_place_order, 'no');
            update_option('adavance_tracking_in_woopra_after_order_complete_enable', $enable_track_after_complete_order, 'no');
            update_option('advance_ecommerce_tracking_woopra_applied_coupon_section_enable', $enable_track_applied_coupon, 'no');
            update_option('advance_ecommerce_tracking_woopra_user_register_section_enable', $enable_track_user_register, 'no');
            ?>
            <div id="message" class="notice updated"><p>
                    <strong><?php esc_html_e('Your settings have been saved.', 'advance-ecommerce-tracking'); ?></strong>
                </p></div>
            <?php
        } else {
            delete_option('advance_ecommerce_tracking_woopra_section_enable');
        }

    }

    /**
     * Function to update the GoSquared tracking settings.
     *
     * @since    1.0.0
     */
    function update_gosquared_tracking_settings() {

        global $enable_gosquared_tracking, $gosquared_tracking_id, $gosquared_tracking_api, $gosquared_add_to_cart, $gosquared_item_update, $gosquared_cart_item_removed, $gosquared_place_order, $gosquared_order_complete, $gosquared_appiled_coupon, $gosquared_user_register;
        $enable_gosquared_tracking   = filter_input(INPUT_POST, 'advance_ecommerce_tracking_gosquared_section_enable', FILTER_SANITIZE_STRING);
        $gosquared_tracking_id       = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_gosquared_tracking_id', FILTER_SANITIZE_STRING);
        $gosquared_tracking_api      = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_gosquared_tracking_api_key', FILTER_SANITIZE_STRING);
        $gosquared_add_to_cart       = filter_input(INPUT_POST, 'adavance_tracking_in_gosquared_add_to_cart_enable', FILTER_SANITIZE_STRING);
        $gosquared_cart_item_removed = filter_input(INPUT_POST, 'adavance_tracking_in_gosquared_remove_cart_item_enable', FILTER_SANITIZE_STRING);
        $gosquared_item_update       = filter_input(INPUT_POST, 'adavance_tracking_gosquared_in_update_cart_enable', FILTER_SANITIZE_STRING);
        $gosquared_place_order       = filter_input(INPUT_POST, 'adavance_tracking_in_gosquared_place_order_enable', FILTER_SANITIZE_STRING);
        $gosquared_order_complete    = filter_input(INPUT_POST, 'adavance_tracking_in_gosquared_after_order_complete_enable', FILTER_SANITIZE_STRING);
        $gosquared_appiled_coupon    = filter_input(INPUT_POST, 'adavance_tracking_in_gosquared_applied_coupon_page_enable', FILTER_SANITIZE_STRING);
        $gosquared_user_register     = filter_input(INPUT_POST, 'advance_ecommerce_tracking_gosquared_user_register_section_enable', FILTER_SANITIZE_STRING);

        $enable_gosquared_tracking   = (isset($enable_gosquared_tracking) && !empty($enable_gosquared_tracking)) ? 'yes' : 'no';
        $gosquared_add_to_cart       = (isset($gosquared_add_to_cart) && !empty($gosquared_add_to_cart)) ? 'yes' : 'no';
        $gosquared_cart_item_removed = (isset($gosquared_cart_item_removed) && !empty($gosquared_cart_item_removed)) ? 'yes' : 'no';
        $gosquared_item_update       = (isset($gosquared_item_update) && !empty($gosquared_item_update)) ? 'yes' : 'no';
        $gosquared_place_order       = (isset($gosquared_place_order) && !empty($gosquared_place_order)) ? 'yes' : 'no';
        $gosquared_order_complete    = (isset($gosquared_order_complete) && !empty($gosquared_order_complete)) ? 'yes' : 'no';
        $gosquared_appiled_coupon    = (isset($gosquared_appiled_coupon) && !empty($gosquared_appiled_coupon)) ? 'yes' : 'no';
        $gosquared_user_register     = (isset($gosquared_user_register) && !empty($gosquared_user_register)) ? 'yes' : 'no';

        if ('yes' === $enable_gosquared_tracking) {
            update_option('advance_ecommerce_tracking_gosquared_section_enable', $enable_gosquared_tracking, 'no');
            update_option('advance_ecommerce_tracking_section_gosquared_tracking_id', $gosquared_tracking_id, 'no');
            update_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key', $gosquared_tracking_api, 'no');
            update_option('adavance_tracking_in_gosquared_add_to_cart_enable', $gosquared_add_to_cart, 'no');
            update_option('adavance_tracking_in_gosquared_remove_cart_item_enable', $gosquared_cart_item_removed, 'no');
            update_option('adavance_tracking_gosquared_in_update_cart_enable', $gosquared_item_update, 'no');
            update_option('adavance_tracking_in_gosquared_place_order_enable', $gosquared_place_order, 'no');
            update_option('adavance_tracking_in_gosquared_after_order_complete_enable', $gosquared_order_complete, 'no');
            update_option('adavance_tracking_in_gosquared_applied_coupon_page_enable', $gosquared_appiled_coupon, 'no');
            update_option('advance_ecommerce_tracking_gosquared_user_register_section_enable', $gosquared_user_register, 'no');
            ?>
            <div id="message" class="notice updated"><p>
                    <strong><?php esc_html_e('Your settings have been saved.', 'advance-ecommerce-tracking'); ?></strong>
                </p></div>
            <?php
        } else {
            delete_option('advance_ecommerce_tracking_gosquared_section_enable');
        }

    }

    /**
     * Function to update the Facebook tracking settings.
     *
     * @since    1.0.0
     */
    function update_facebook_tracking_settings() {

        global $facebook_enable;
        $facebook_enable           = filter_input(INPUT_POST, 'advance_ecommerce_tracking_facebook_section_enable', FILTER_SANITIZE_STRING);
        $facebook_enable           = (isset($facebook_enable) && !empty($facebook_enable)) ? 'yes' : 'no';
        $tracking_id               = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_facebook_tracking_id', FILTER_SANITIZE_STRING);
        $fb_add_to_cart_shop       = filter_input(INPUT_POST, 'fb_add_to_cart_shop', FILTER_SANITIZE_STRING);
        $fb_add_to_cart_shop       = (isset($fb_add_to_cart_shop) && !empty($fb_add_to_cart_shop)) ? 'yes' : 'no';
        $fb_add_to_cart_single_prd = filter_input(INPUT_POST, 'fb_add_to_cart_single_prd', FILTER_SANITIZE_STRING);
        $fb_add_to_cart_single_prd = (isset($fb_add_to_cart_single_prd) && !empty($fb_add_to_cart_single_prd)) ? 'yes' : 'no';
        $fb_purchase               = filter_input(INPUT_POST, 'fb_purchase', FILTER_SANITIZE_STRING);
        $fb_purchase               = (isset($fb_purchase) && !empty($fb_purchase)) ? 'yes' : 'no';
        $fb_view_content           = filter_input(INPUT_POST, 'fb_view_content', FILTER_SANITIZE_STRING);
        $fb_view_content           = (isset($fb_view_content) && !empty($fb_view_content)) ? 'yes' : 'no';
        $fb_view_product_category  = filter_input(INPUT_POST, 'fb_view_product_category', FILTER_SANITIZE_STRING);
        $fb_view_product_category  = (isset($fb_view_product_category) && !empty($fb_view_product_category)) ? 'yes' : 'no';

        if ('yes' === $facebook_enable) {
            update_option('advance_ecommerce_tracking_facebook_section_enable', $facebook_enable, 'no');
            update_option('advance_ecommerce_tracking_section_facebook_tracking_id', $tracking_id);
            update_option('fb_add_to_cart_shop', $fb_add_to_cart_shop, 'no');
            update_option('fb_add_to_cart_single_prd', $fb_add_to_cart_single_prd, 'no');
            update_option('fb_purchase', $fb_purchase, 'no');
            update_option('fb_view_content', $fb_view_content, 'no');
            update_option('fb_view_product_category', $fb_view_product_category, 'no');
            ?>
            <div id="message" class="notice updated"><p>
                    <strong><?php esc_html_e('Your settings have been saved.', 'advance-ecommerce-tracking'); ?></strong>
                </p></div>
            <?php
        } else {
            delete_option('advance_ecommerce_tracking_facebook_section_enable');
        }

    }

    /**
     * Function to update the Twitter tracking settings.
     *
     * @since    1.0.0
     */
    function update_twitter_tracking_settings() {

        global $twitter_enable;
        $twitter_enable = filter_input(INPUT_POST, 'advance_ecommerce_tracking_twitter_section_enable', FILTER_SANITIZE_STRING);
        $tracking_id    = filter_input(INPUT_POST, 'advance_ecommerce_tracking_section_twitter_conversion_id', FILTER_SANITIZE_STRING);
        $twitter_enable = (isset($twitter_enable) && !empty($twitter_enable)) ? 'yes' : 'no';
        if ('yes' === $twitter_enable) {
            update_option('advance_ecommerce_tracking_twitter_section_enable', $twitter_enable, 'no');
            update_option('advance_ecommerce_tracking_section_twitter_conversion_id', $tracking_id, 'no');
            ?>
            <div id="message" class="notice updated"><p>
                    <strong><?php esc_html_e('Your settings have been saved.', 'advance-ecommerce-tracking'); ?></strong>
                </p></div>
            <?php
        } else {
            delete_option('advance_ecommerce_tracking_twitter_section_enable');
        }

    }

}