<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.multidots.com/
 * @since             1.0.0
 * @package           Speedometerv3
 *
 * @wordpress-plugin
 * Plugin Name:       Speedometerv3
 * Plugin URI:        https://www.multidots.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Multidots
 * Author URI:        https://www.multidots.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       speedometerv3
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if ( ! defined( 'SPEEDOMETERV3_VERSION' ) ) {
	define( 'SPEEDOMETERV3_VERSION', '3.0' );
}
if ( ! defined( 'SPEEDOMETERV3_PLUGIN_URL' ) ) {
	define( 'SPEEDOMETERV3_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'SPEEDOMETERV3_PLUGIN_DIR' ) ) {
	define( 'SPEEDOMETERV3_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'SPEEDOMETERV3_PLUGIN_DIR_PATH' ) ) {
	define( 'SPEEDOMETERV3_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'SPEEDOMETERV3_PLUGIN_BASENAME' ) ) {
	define( 'SPEEDOMETERV3_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-speedometerv3-activator.php
 */
function activate_speedometerv3() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-speedometerv3-activator.php';
	Speedometerv3_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-speedometerv3-deactivator.php
 */
function deactivate_speedometerv3() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-speedometerv3-deactivator.php';
	Speedometerv3_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_speedometerv3' );
register_deactivation_hook( __FILE__, 'deactivate_speedometerv3' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-speedometerv3.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_speedometerv3() {

	$plugin = new Speedometerv3();
	$plugin->run();

}
run_speedometerv3();

add_action("wp_ajax_sm_sync_update", "sm_sync_update");
add_action("wp_ajax_nopriv_sm_sync_update", "sm_sync_update");

function sm_sync_update() {
	if ( !wp_verify_nonce( $_POST['nonce'], "pluginSetting")) {
		exit("No naughty business please");
	}
	$token = filter_input(INPUT_POST, 'token_val', FILTER_SANITIZE_STRING);
	$status = filter_input(INPUT_POST, 'sync_status', FILTER_SANITIZE_NUMBER_INT);
	global $wpdb;
	if ( empty( $token ) ) {
		return false;
	}
	$config_tbl = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration';
	$rows_affected = $wpdb->query(
		$wpdb->prepare(
			"UPDATE {$config_tbl} SET sync_data_pause = '%d' WHERE mercury_token = '%s'", 
					$status,$token
		) // $wpdb->prepare
	); // $wpdb->query
	if( $rows_affected )
		$response_array['status'] = 'success';
	echo json_encode($response_array);
	die;
}