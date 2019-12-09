<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/dots
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/includes
 * @author     Multidots <hello@multidots.com>
 */
class Woocommerce_Product_Finder_Pro_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ),true ) && ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
			wp_die(
				sprintf(
					"<strong>%s</strong> %s <strong>%s</strong> <a href='%s'>%s</a>",
					esc_html__( 'WooCommerce Product Finder Pro' , 'woo-product-finder' ),
					esc_html__( 'Plugin requires' , 'woo-product-finder' ),
					esc_html__( 'WooCommerce', 'woo-product-finder' ),
					esc_url( get_admin_url( null, 'plugins.php' ) ),
					esc_html__( 'Plugins page', 'woo-product-finder' )
				)
			);
		}
	}

}
