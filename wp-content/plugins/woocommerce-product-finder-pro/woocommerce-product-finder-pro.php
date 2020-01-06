<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/dots
 * @since             1.0.0
 * @package           Woocommerce_Product_Finder_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       Product Finder for WooCommerce
 * Plugin URI:        http://www.multidots.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.3.0
 * Author:            Multidots
 * Author URI:        https://profiles.wordpress.org/dots
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-product-finder-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if ( function_exists( 'wpfp_fs' ) ) {
	wpfp_fs()->set_basename( true, __FILE__ );

	return;
}


if ( ! function_exists( 'wpfp_fs' ) ) {
	// Create a helper function for easy SDK access.
	function wpfp_fs() {
		global $wpfp_fs;

		if ( ! isset( $wpfp_fs ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/freemius/start.php';
			$wpfp_fs = fs_dynamic_init( array(
				'id'               => '3474',
				'slug'             => 'woo-product-finder-pro',
				'type'             => 'plugin',
				'public_key'       => 'pk_283cce2c62f26271f3c6e2418df8a',
				'is_premium'       => true,
				'has_addons'       => false,
				'has_paid_plans'   => true,
				'is_org_compliant' => false,
				'menu'             => array(
					'slug'       => 'wpfp-list',
					'first-path' => 'admin.php?page=wpfp-get-started',
					'contact'    => false,
					'support'    => false,
				),
				'is_live'          => true,
			) );
		}

		return $wpfp_fs;
	}

	// Init Freemius.
	wpfp_fs();
	// Signal that SDK was initiated.
	do_action( 'wpfp_fs_loaded' );
	wpfp_fs()->get_upgrade_url();
	// Not like register_uninstall_hook(), you do NOT have to use a static function.
	wpfp_fs()->add_action( 'after_uninstall', 'wpfp_fs_uninstall_cleanup' );
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-product-finder-pro-activator.php
 */
function activate_woocommerce_product_finder_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-finder-pro-activator.php';
	Woocommerce_Product_Finder_Pro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-product-finder-pro-deactivator.php
 */
function deactivate_woocommerce_product_finder_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-finder-pro-deactivator.php';
	Woocommerce_Product_Finder_Pro_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_product_finder_pro' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_product_finder_pro' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-finder-pro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_product_finder_pro() {

	//$plugin_post_type_name = esc_attr__( 'size-chart', 'woo-product-finder' );
	$plugin_name           = esc_attr__( 'Product Finder for WooCommerce', 'woo-product-finder' );
	$plugin_version        = esc_attr__( '1.3', 'woo-product-finder' );

	if ( wpfp_fs()->is__premium_only() ) {
		if ( wpfp_fs()->can_use_premium_code() ) {
			$plugin_name    = esc_attr__( 'Product Finder for WooCommerce Pro', 'woo-product-finder' );
			$plugin_version = esc_attr__( '1.3', 'woo-product-finder' );
		}
	}
	$plugin = new Woocommerce_Product_Finder_Pro( $plugin_name, $plugin_version );
	$plugin->run();

}

/**
 * Check Initialize plugin in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
function wpfp_initialize_plugin() {
	$wc_active = in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true );
	if ( ( current_user_can( 'activate_plugins' ) && $wc_active !== true ) || $wc_active !== true ) {
		add_action( 'admin_notices', 'wpfp_plugin_admin_notice' );
	} else {
		run_woocommerce_product_finder_pro();
	}
}

add_action( 'plugins_loaded', 'wpfp_initialize_plugin' );

/**
 * Show admin notice in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
function wpfp_plugin_admin_notice() {
	$wpfp_plugin = esc_html__( 'Product Finder for WooCommerce', 'woo-product-finder' );
	$wc_plugin   = esc_html__( 'WooCommerce', 'woo-product-finder' );
	if ( wpfp_fs()->is__premium_only() ) {
		if ( wpfp_fs()->can_use_premium_code() ) {
			$wpfp_plugin = esc_html__( 'Product Finder for WooCommerce pro', 'woo-product-finder' );
		}
	}
	?>
    <div class="error">
        <p>
			<?php
			printf(
				esc_html__( '%1$s is ineffective as it requires %2$s to be installed and active.' ),
				'<strong>' . esc_html( $wpfp_plugin ) . '</strong>',
				'<strong>' . esc_html( $wc_plugin ) . '</strong>' );
			?>
        </p>
    </div>
	<?php
}
