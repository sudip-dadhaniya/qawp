<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/dots
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/includes
 * @author     Multidots <hello@multidots.com>
 */
class Woocommerce_Product_Finder_Pro_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-product-finder',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
