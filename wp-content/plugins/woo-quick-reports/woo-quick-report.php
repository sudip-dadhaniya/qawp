<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.thedotstore.com/
 * @since             1.0.0
 * @package           Woo_Quick_Report
 *
 * @wordpress-plugin
 * Plugin Name:       Quick Reports for WooCommerce
 * Plugin URI:        https://www.thedotstore.com/woocommerce-quick-reports/
 * Description:       Quick Reports shows you order information in one dashboard in very intuitive, easy to understand format which gives a quick information.You will see quick order reports like Devise wise, Browser wise, order status wise, shipping method wise and payment method wise.
 * Version:           2.3
 * Author:            Thedotstore
 * Author URI:        https://www.thedotstore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-quick-report
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if(!defined('WPINC')) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-quick-report-activator.php
 */
function activate_woo_quick_report() {
	require_once __DIR__ . '/includes/class-woo-quick-report-activator.php';
	Woo_Quick_Report_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-quick-report-deactivator.php
 */
function deactivate_woo_quick_report() {
	require_once __DIR__ . '/includes/class-woo-quick-report-deactivator.php';
	Woo_Quick_Report_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woo_quick_report');
register_deactivation_hook(__FILE__, 'deactivate_woo_quick_report');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_quick_report() {

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require __DIR__ . '/includes/class-woo-quick-report.php';
	$plugin = new Woo_Quick_Report();
	$plugin->run();

}

/**
 * Check plugin requirement on plugins loaded, this plugin requires WooCommerce to be installed and active.
 *
 * @since    1.0.0
 */
function wqr_initialize_plugin() {

	$wc_active = in_array('woocommerce/woocommerce.php', get_option('active_plugins'), true);
	if(current_user_can('activate_plugins') && true !== $wc_active) {
		add_action('admin_init', 'wqr_deactivate_plugin'); //Deactivate the plugin as it should not be activated.
	} else {
		run_woo_quick_report();
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wqr_plugin_links');
	}

}

add_action('plugins_loaded', 'wqr_initialize_plugin');

/**
 * Deactivate the plugin.
 */
function wqr_deactivate_plugin() {

	deactivate_plugins( plugin_basename( __FILE__ ) );
	wp_die(
		sprintf( "<strong>%s</strong> %s <strong>%s</strong> <a href='%s'>%s</a>",
			esc_html__( 'Quick Reports for WooCommerce', 'woo-quick-report' ),
			esc_html__( 'Plugin requires', 'woo-quick-report' ),
			esc_html__( 'WooCommerce. ', 'woo-quick-report' ),
			esc_url( get_admin_url( null, 'plugins.php' ) ),
			esc_html__( 'Back to plugins.', 'woo-quick-report' )
		)
	);

}

/**
 * Settings link on plugin listing page.
 *
 * @since    1.0.0
 */
function wqr_plugin_links($links) {

	$this_plugin_links = array(
		'<a title="' . esc_html__('WC Quick Reports Settings', 'woo-quick-report') . '" href="' . admin_url('admin.php?page=wc-quick-reports') . '">' . esc_html__('Settings', 'woo-quick-report') . '</a>'
	);

	return array_merge($links, $this_plugin_links);

}