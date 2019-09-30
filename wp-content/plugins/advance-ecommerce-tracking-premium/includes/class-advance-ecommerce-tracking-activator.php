<?php
if (!defined('ABSPATH')) exit;
/**
 * Fired during plugin activation
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/includes
 * @author     Multidots <info@multidots.com>
 */
class Advance_Ecommerce_Tracking_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wpdb, $woocommerce;
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && !is_plugin_active_for_network('woocommerce/woocommerce.php')) {
            wp_die("<strong> Ecommerce Tracking For WooCommerce</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . get_admin_url(null, 'plugins.php') . "'>Plugins page</a>.");
        } else {
            set_transient('_welcome_ecommerce_screen_activation_redirect_data', true, 30);
            global $wpdb, $woocommerce;

            $wpdb->hide_errors();

            $collate = '';

            if ($wpdb->has_cap('collation')) {
                if (!empty($wpdb->charset)) {
                    $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
                }
                if (!empty($wpdb->collate)) {
                    $collate .= " COLLATE $wpdb->collate";
                }
            }

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        }
    }

}
