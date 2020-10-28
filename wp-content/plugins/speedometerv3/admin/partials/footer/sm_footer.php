<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Speedometerv3
 * @subpackage Speedometerv3/admin/partials/footer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb;
$plugin_name                  = SPEEDOMETERV3_PLUGIN_NAME;
$plugin_version               = SPEEDOMETERV3_VERSION;
$current_page                 = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
$speedometerv3_list_dashboard = ( isset( $current_page ) && 'speedometer' === $current_page ? 'active' : '' );
$speedometerv3_settings       = ( isset( $current_page ) && 'speedometer-setting' === $current_page ? 'active' : '' );
$speedometerv3_scan       = ( isset( $current_page ) && 'speedometer-scan' === $current_page ? 'active' : '' );
?>    
        </div>
	</div>
</div>