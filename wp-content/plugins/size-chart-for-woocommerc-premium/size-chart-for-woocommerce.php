<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.multidots.com/
 * @since             1.0.0
 * @package           Size_Chart_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name: Size Chart for WooCommerce (Premium)
 * Plugin URI:        https://www.thedotstore.com/woocommerce-advanced-product-size-charts/
 * Description:       Add product size charts with default template or custom size chart to any of your WooCommerce products.
 * Version:           1.9.1
 * Author:            DotStore
 * Author URI:        https://store.multidots.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       size-chart-for-woocommerce
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( function_exists( 'scfw_fs' ) ) {
	scfw_fs()->set_basename( true, __FILE__ );

	return;
}


if ( ! function_exists( 'scfw_fs' ) ) {
	function scfw_fs() {
		global $scfw_fs;

		if ( ! isset( $scfw_fs ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/freemius/start.php';
			$scfw_fs = fs_dynamic_init( array(
				'id'               => '3495',
				'slug'             => 'size-chart-for-woocommerc',
				'type'             => 'plugin',
				'public_key'       => 'pk_921eefb3cf0a9c96d9d187aa72ad1',
				'is_premium'       => true,
				'has_addons'       => false,
				'has_paid_plans'   => true,
				'is_org_compliant' => false,
				'menu'             => array(
					'slug'       => 'size-chart-for-woocommerc',
					'first-path' => 'index.php?page=size-chart-about&tab=about',
					'contact'    => false,
					'support'    => false,
				),
				'is_live'          => true,
			) );
		}

		return $scfw_fs;
	}

	scfw_fs();
	do_action( 'scfw_fs_loaded' );
	scfw_fs()->get_upgrade_url();
	scfw_fs()->add_action( 'after_uninstall', 'scfw_fs_uninstall_cleanup' );
}

if ( scfw_fs()->get_activation_url() ) {
	function size_chart_validate_admin_init() {
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) && ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
			deactivate_plugins( array( scfw_fs()->get_plugin_basename() ) );
			wp_die(
				sprintf( "<strong>%s</strong> %s <strong>%s</strong> <a href='%s'>%s</a>",
					esc_html__( 'Size Chart for WooCommerce', 'size-chart-for-woocommerce' ),
					esc_html__( 'Plugin requires', 'size-chart-for-woocommerce' ),
					esc_html__( 'WooCommerce', 'size-chart-for-woocommerce' ),
					esc_url( get_admin_url( null, 'plugins.php' ) ),
					esc_html__( 'Plugins page', 'size-chart-for-woocommerce' )
				)
			);
		}
	}

	add_action( 'admin_init', 'size_chart_validate_admin_init' );
}

if ( scfw_fs()->is__premium_only() ) {

	if ( scfw_fs()->can_use_premium_code() ) {
		if ( ! defined( 'SIZE_CHART_PLUGIN_BASENAME' ) ) {
			define( 'SIZE_CHART_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		}

		if ( ! defined( 'SIZE_CHART_PLUGIN_DIR' ) ) {
			define( 'SIZE_CHART_PLUGIN_DIR', dirname( __FILE__ ) );
			// plugin dir
		}


		if ( ! defined( 'SIZE_CHART_PLUGIN_URL' ) ) {
			define( 'SIZE_CHART_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			// plugin url
		}


		if ( ! defined( 'SIZE_CHART_PLUGIN_DOC_URL' ) ) {
			define( 'SIZE_CHART_PLUGIN_DOC_URL', SIZE_CHART_PLUGIN_URL . 'help Doc/Size Chart For WooCommerce plugin - help document.pdf' );
			// plugin help document
		}

		/**
		 * The code that runs during plugin activation.
		 * This action is documented in includes/class-size-chart-for-woocommerce-activator.php
		 */
		function activate_size_chart_for_woocommerce() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-size-chart-for-woocommerce-activator.php';
			$active_plugin = new Size_Chart_For_Woocommerce_Activator();
			Size_Chart_For_Woocommerce_Activator::activate( $active_plugin );
		}

		/**
		 * The code that runs during plugin deactivation.
		 * This action is documented in includes/class-size-chart-for-woocommerce-deactivator.php
		 */
		function deactivate_size_chart_for_woocommerce() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-size-chart-for-woocommerce-deactivator.php';
			Size_Chart_For_Woocommerce_Deactivator::deactivate();
		}

		register_activation_hook( __FILE__, 'activate_size_chart_for_woocommerce' );
		register_deactivation_hook( __FILE__, 'deactivate_size_chart_for_woocommerce' );
		/**
		 * The core plugin class that is used to define internationalization,
		 * admin-specific hooks, and public-facing site hooks.
		 */
		require plugin_dir_path( __FILE__ ) . 'includes/class-size-chart-for-woocommerce.php';
		/**
		 * Begins execution of the plugin.
		 *
		 * Since everything within the plugin is registered via hooks,
		 * then kicking off the plugin from this point in the file does
		 * not affect the page life cycle.
		 *
		 * @since    1.0.0
		 */
		function run_size_chart_for_woocommerce() {
			$plugin = new Size_Chart_For_Woocommerce();
			$plugin->run();

		}

		run_size_chart_for_woocommerce();
	}

}