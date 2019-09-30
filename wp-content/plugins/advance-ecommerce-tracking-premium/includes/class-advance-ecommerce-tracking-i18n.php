<?php
if (!defined('ABSPATH')) exit;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Advance_Ecommerce_Tracking
 * @subpackage Advance_Ecommerce_Tracking/includes
 * @author     Multidots <info@multidots.com>
 */
class Advance_Ecommerce_Tracking_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'advance-ecommerce-tracking',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
