<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Speedometerv3
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
global $wpdb;

// Check if we are on a Multisite or not.
if ( is_multisite() ) {
	// Retrieve all site IDs from all networks (WordPress >= 4.6 provides easy to use functions for that).
	if ( function_exists( 'get_sites' ) ) {
		$site_ids = get_sites( array( 'fields' => 'ids' ) );
	} else {
		$site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs;" );
	}

	// Uninstall the plugin for all these sites.
	foreach ( $site_ids as $site_id ) {
		switch_to_blog( $site_id );
		myplugin_uninstall_single_site();
		restore_current_blog();
	}
} else {
	myplugin_uninstall_single_site();
}

function myplugin_uninstall_single_site() {
	global $wpdb;
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'speedometerv3/includes/class-speedometerv3-constant.php';
	$tableArray = [
		$wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'sync_log',
		$wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration',
		$wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'scan_log',
		$wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_bank',
		$wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_scan_display',
	];
	foreach ( $tableArray as $tablename ) {
		$wpdb->query( "DROP TABLE IF EXISTS $tablename" );
	}
}









