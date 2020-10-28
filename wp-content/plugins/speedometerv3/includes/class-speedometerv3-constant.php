<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The file that defines constant variabes
 *
 * Defines admin side constant.
 *
 * @link       https://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Speedometerv3
 * @subpackage Speedometerv3/includes
 */
global $wpdb;
// Define constant for plugin
define( 'SPEEDOMETERV3_PLUGIN_SLUG', '' );
// Plugin Tables Constant
define( 'WP_TABLE_PREFIX', $wpdb->prefix );
define( 'SPEEDOMETERV3_TABLE_PREFIX', "speedometerv3_" );
define( 'SPEEDOMETERV3_PLUGIN_NAME', __( 'SpeedOmeter' ) );
define( 'SPEEDOMETERV3_TEXT_DOMAIN', 'speedometer' );
define( 'SPEEDOMETERV3_VERSION_TEXT', __( 'Free Version ' ) );
define( 'SPEEDOMETERV3_SITEAPI_URL', 'http://dev3.speedometer.ai/api/v3/' );
define( 'SPEEDOMETERV3_ORG_PLUGIN_URL', 'https://api.wordpress.org/plugins/info/1.2/?action=plugin_information&request[slugs][]=' );
// define( 'SPEEDOMETERV3_WP_LATEST_VERSION_URL', 'https://api.wordpress.org/core/version-check/1.7/' );
//define( 'SPEEDOMETERV3_PHP_LATEST_VERSION_URL','https://www.php.net/releases/?json');
define( 'SPEEDOMETERV3_WP_LATEST_VERSION_URL', 'http://api.wordpress.org/core/stable-check/1.0/');
define( 'SPEEDOMETERV3_PHP_LATEST_VERSION_URL','https://www.php.net/releases/index.php?json&version=7&max=3');
define( 'SPEEDOMETERV3_SUGGESATION_BANK', plugin_dir_path( __FILE__ ).'SPEEDOMETERV3_SUGGESATION_BANK.json' );