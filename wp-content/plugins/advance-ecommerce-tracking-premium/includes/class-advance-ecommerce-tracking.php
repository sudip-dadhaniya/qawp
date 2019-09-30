<?php
if (!defined('ABSPATH')) exit;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/includes
 * @author     Multidots <info@multidots.com>
 */
class Advance_Ecommerce_Tracking {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Advance_Ecommerce_Tracking_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'advance-ecommerce-tracking';
        $this->version     = '1.5.2';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

        $prefix = is_network_admin() ? 'network_admin_' : '';
        add_filter("{$prefix}plugin_action_links_" . ADVANCE_ECOMMERCE_TRACKING_PLUGIN_BASENAME_FILE, array($this, 'plugin_action_links'), 10, 4);
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Advance_Ecommerce_Tracking_Loader. Orchestrates the hooks of the plugin.
     * - Advance_Ecommerce_Tracking_i18n. Defines internationalization functionality.
     * - Advance_Ecommerce_Tracking_Admin. Defines all hooks for the admin area.
     * - Advance_Ecommerce_Tracking_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-advance-ecommerce-tracking-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-advance-ecommerce-tracking-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-advance-ecommerce-tracking-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-advance-ecommerce-tracking-public.php';

        $this->loader = new Advance_Ecommerce_Tracking_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Advance_Ecommerce_Tracking_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Advance_Ecommerce_Tracking_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Advance_Ecommerce_Tracking_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_init', $plugin_admin, 'welcome_ecommerce_tracking_do_activation_redirect');
        $this->loader->add_action('admin_init', $plugin_admin, 'do_admin_init_actions');
        $this->loader->add_action('admin_menu', $plugin_admin, 'dot_store_menu_advanced_ecommerce_tracking_pro');
        $this->loader->add_action('admin_head', $plugin_admin, 'advanced_ecommerce_tracking_pro_active_menu');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        $plugin_public = new Advance_Ecommerce_Tracking_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

        $advance_ecommerce_tracking_section_enable = get_option('advance_ecommerce_tracking_section_enable');
        $advance_ecommerce_tracking_gosquared_section_enable = get_option('advance_ecommerce_tracking_gosquared_section_enable');
        $advance_ecommerce_tracking_woopra_section_enable = get_option('advance_ecommerce_tracking_woopra_section_enable');
        $advance_ecommerce_tracking_facebook_conversion_enable = get_option('advance_ecommerce_tracking_facebook_section_enable');
        $advance_ecommerce_tracking_google_conversion_enable = get_option('advance_ecommerce_tracking_google_section_enable');
        $advance_ecommerce_tracking_twitter_conversion_enable = get_option('advance_ecommerce_tracking_twitter_section_enable');

        if ('yes' === $advance_ecommerce_tracking_facebook_conversion_enable) {
            $this->loader->add_action('wp_head', $plugin_public, 'fb_tracking_enqueue_scripts');
            $fb_add_to_cart_single_prd = get_option('fb_add_to_cart_single_prd');
            if (!empty($fb_add_to_cart_single_prd) && 'yes' === $fb_add_to_cart_single_prd) {
                $this->loader->add_action('woocommerce_add_to_cart', $plugin_public, 'fb_track_add_to_cart', 10, 4);
            }
            $fb_purchase = get_option('fb_purchase');
            if (!empty($fb_purchase) && 'yes' === $fb_purchase) {
                $this->loader->add_action('woocommerce_thankyou', $plugin_public, 'fb_track_purchase', 10, 4);
            }

            $fb_view_content = get_option('fb_view_content');
            if (!empty($fb_view_content) && 'yes' === $fb_view_content) {
                $this->loader->add_action('woocommerce_after_single_product', $plugin_public, 'fb_track_view_content', 5);
            }

            $fb_view_product_category = get_option('fb_view_product_category');
            if (!empty($fb_view_product_category) && 'yes' === $fb_view_product_category) {
                $this->loader->add_action('woocommerce_after_shop_loop', $plugin_public, 'fb_track_category_view');
            }

            $this->loader->add_action('wp_ajax_aetp_get_current_product_detail_for_fb_track', $plugin_public, 'aetp_get_current_product_detail_for_fb_track');
            $this->loader->add_action('wp_ajax_nopriv_aetp_get_current_product_detail_for_fb_track', $plugin_public, 'aetp_get_current_product_detail_for_fb_track');
        }

        if ('yes' === $advance_ecommerce_tracking_google_conversion_enable) {
            $this->loader->add_action('woocommerce_thankyou', $plugin_public, 'advance_ecommerce_google_conversion_tracking', 10, 1);
        }

        if ('yes' === $advance_ecommerce_tracking_twitter_conversion_enable) {
            $this->loader->add_action('woocommerce_thankyou', $plugin_public, 'advance_ecommerce_twitter_conversion_tracking', 10, 1);
        }

        //Load Ecommerce Tracking code
        if ('yes' === $advance_ecommerce_tracking_section_enable) {
            $this->loader->add_action('wp_head', $plugin_public, 'load_ga_code_in_header');
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_add_to_cart_on_lopp'); //Track add to cart on lost of products
            $this->loader->add_action('woocommerce_after_add_to_cart_button', $plugin_public, 'gta_track_add_to_cart'); // Track add to cart on single product page
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_view_content'); // Track view content on single product page //woocommerce_after_single_product
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_checkout_initate', 3); //On Checkout Page (Checkout Behavior)
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_remove_from_cart', 3); //track remove from cart
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_update_cart', 3); //track remove from cart
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_apply_coupon', 3); //track remove from cart
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_search', 3); //track remove from cart
            $this->loader->add_action('woocommerce_order_details_after_order_table', $plugin_public, 'gta_track_purchase'); //After Purchase //advance_ecommerce_tracking_for_ecommerce
            $this->loader->add_action('wp_ajax_aetp_get_remove_product_detail_from_cart_analytics_tracking', $plugin_public, 'aetp_get_remove_product_detail_from_cart_analytics_tracking');
            $this->loader->add_action('wp_ajax_nopriv_aetp_get_remove_product_detail_from_cart_analytics_tracking', $plugin_public, 'aetp_get_remove_product_detail_from_cart_analytics_tracking');
            $this->loader->add_action('wp_ajax_aetp_get_current_product_detail_for_ga_track', $plugin_public, 'aetp_get_current_product_detail_for_ga_track');
            $this->loader->add_action('wp_ajax_nopriv_aetp_get_current_product_detail_for_ga_track', $plugin_public, 'aetp_get_current_product_detail_for_ga_track');
            $this->loader->add_action('wp_footer', $plugin_public, 'gta_track_page_view'); //On Checkout Page (Checkout Behavior)
        }

        /**
         * GoSquared Tracking Code.
         */
        if ('yes' === $advance_ecommerce_tracking_gosquared_section_enable) {
            $this->loader->add_action('wp_head', $plugin_public, 'advance_ecommerce_tracking_identify_gosquard');
            $adavance_tracking_in_gosquared_add_to_cart_enable = get_option('adavance_tracking_in_gosquared_add_to_cart_enable');
            $adavance_tracking_gosquared_in_update_cart_enable = get_option('adavance_tracking_gosquared_in_update_cart_enable');
            $adavance_tracking_in_gosquared_remove_cart_item_enable = get_option('adavance_tracking_in_gosquared_remove_cart_item_enable');
            $adavance_tracking_in_gosquared_place_order_enable = get_option('adavance_tracking_in_gosquared_place_order_enable');
            $adavance_tracking_in_gosquared_applied_coupon_page_enable = get_option('adavance_tracking_in_gosquared_applied_coupon_page_enable');
            $adavance_tracking_in_gosquared_after_order_complete_enable = get_option('adavance_tracking_in_gosquared_after_order_complete_enable');
            $advance_ecommerce_tracking_gosquared_user_register_section_enable = get_option('advance_ecommerce_tracking_gosquared_user_register_section_enable');
            if ('yes' === $adavance_tracking_in_gosquared_add_to_cart_enable) {
                $this->loader->add_action('woocommerce_add_to_cart', $plugin_public, 'advance_ecommerce_gosquared_tracking_add_to_cart_event', 10, 6);
            }

            if ('yes' === $adavance_tracking_in_gosquared_remove_cart_item_enable) {
                $this->loader->add_action('woocommerce_cart_item_removed', $plugin_public, 'advance_ecommerce_gosquared_tracking_cart_item_removed', 10, 2);
                $this->loader->add_action('woocommerce_before_cart_item_quantity_zero', $plugin_public, 'advance_ecommerce_gosquared_tracking_item_quantity_zero', 10, 1);
            }

            if ('yes' === $adavance_tracking_gosquared_in_update_cart_enable) {
                $this->loader->add_action('woocommerce_after_cart_item_quantity_update', $plugin_public, 'advance_ecommerce_gosquared_tracking_item_quantity_update');
            }

            if ('yes' === $adavance_tracking_in_gosquared_place_order_enable) {
                $this->loader->add_action('woocommerce_checkout_order_processed', $plugin_public, 'advance_ecommerce_gosquared_tracking_track_checkout', 10, 2);
            }

            if ('yes' === $adavance_tracking_in_gosquared_applied_coupon_page_enable) {
                $this->loader->add_action('woocommerce_applied_coupon', $plugin_public, 'advance_ecommerce_gosquared_tracking_track_coupon', 10, 1);
                $this->loader->add_action('wp_head', $plugin_public, 'load_gosquard_script_in_header');
            }

            if ('yes' === $advance_ecommerce_tracking_gosquared_user_register_section_enable) {
                $this->loader->add_action('user_register', $plugin_public, 'advance_ecommerce_gosquard_tracking_track_signup', 10, 1);
            }

            if ('yes' === $adavance_tracking_in_gosquared_after_order_complete_enable) {
                $this->loader->add_action('woocommerce_order_details_after_order_table', $plugin_public, 'advance_ecommerce_tracking_gosquard');
            }
        }

        /**
         * Woopra Tracking Code.
         */
        if ('yes' === $advance_ecommerce_tracking_woopra_section_enable) {
            $advance_ecommerce_tracking_woopra_add_to_cart_section_enable       = get_option('advance_ecommerce_tracking_woopra_add_to_cart_section_enable');
            $advance_ecommerce_tracking_woopra_cart_item_removed_section_enable = get_option('advance_ecommerce_tracking_woopra_cart_qty_remove_section_enable');
            $advance_ecommerce_tracking_woopra_cart_item_update_section_enable  = get_option('advance_ecommerce_tracking_woopra_cart_qty_update_section_enable');
            $advance_ecommerce_tracking_woopra_place_order_section_enable       = get_option('advance_ecommerce_tracking_woopra_place_order_section_enable');
            $advance_ecommerce_tracking_woopra_applied_coupon_section_enable    = get_option('advance_ecommerce_tracking_woopra_applied_coupon_section_enable');
            $advance_ecommerce_tracking_woopra_user_register_section_enable     = get_option('advance_ecommerce_tracking_woopra_user_register_section_enable');
            $adavance_tracking_in_woopra_after_order_complete_enable            = get_option('adavance_tracking_in_woopra_after_order_complete_enable');
            $this->loader->add_action('wp_head', $plugin_public, 'advance_ecommerce_tracking_identify_woopra');

            if ('yes' === $advance_ecommerce_tracking_woopra_add_to_cart_section_enable) {
                $this->loader->add_action('woocommerce_add_to_cart', $plugin_public, 'advance_ecommerce_woopra_tracking_add_to_cart_event', 10, 6);
            }

            if ('yes' === $advance_ecommerce_tracking_woopra_cart_item_removed_section_enable) {
                $this->loader->add_action('woocommerce_cart_item_removed', $plugin_public, 'advance_ecommerce_woopra_tracking_cart_item_removed', 10, 2);
                $this->loader->add_action('woocommerce_before_cart_item_quantity_zero', $plugin_public, 'advance_ecommerce_woopra_tracking_item_quantity_zero', 10, 1);
            }

            if ('yes' === $advance_ecommerce_tracking_woopra_cart_item_update_section_enable) {
                $this->loader->add_action('woocommerce_after_cart_item_quantity_update', $plugin_public, 'advance_ecommerce_woopra_tracking_item_quantity_update');
            }

            if ('yes' === $advance_ecommerce_tracking_woopra_place_order_section_enable) {
                $this->loader->add_action('woocommerce_checkout_order_processed', $plugin_public, 'advance_ecommerce_woopra_tracking_track_checkout', 10, 2);
            }

            if ('yes' === $advance_ecommerce_tracking_woopra_applied_coupon_section_enable) {
                $this->loader->add_action('woocommerce_applied_coupon', $plugin_public, 'advance_ecommerce_woopra_tracking_track_coupon', 10, 1);
            }

            if ('yes' === $advance_ecommerce_tracking_woopra_user_register_section_enable) {
                $this->loader->add_action('user_register', $plugin_public, 'advance_ecommerce_woopra_tracking_track_signup', 10, 1);
            }

            if ('yes' === $adavance_tracking_in_woopra_after_order_complete_enable) {
                $this->loader->add_action('woocommerce_order_details_after_order_table', $plugin_public, 'advance_ecommerce_woopra_order_complete', 10, 1);
            }
        }
    }

    /**
     * Return the plugin action links.  This will only be called if the plugin
     * is active.
     *
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     * @since 1.0.0
     */
    function plugin_action_links($actions) {

        $aet_actions = array(
            'configure' => sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=ecommerce_tracking_pro&tab=advance_ecommerce_tracking'), esc_html__('Settings', 'advance-ecommerce-tracking')),
            'docs' => sprintf('<a href="%s" target="_blank">%s</a>', esc_url('https://www.thedotstore.com/woocommerce-enhanced-ecommerce-analytics-integration-with-conversion-tracking'), esc_html__('Docs', 'advance-ecommerce-tracking')),
            'support' => sprintf('<a href="%s" target="_blank">%s</a>', esc_url('https://www.thedotstore.com/support'), esc_html__('Support', 'advance-ecommerce-tracking'))
        );

        return array_merge($aet_actions, $actions);

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Advance_Ecommerce_Tracking_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version() {
        return $this->version;
    }

}
