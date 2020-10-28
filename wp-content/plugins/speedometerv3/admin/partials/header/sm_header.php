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
 * @subpackage Speedometerv3/admin/partials/header
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
$pluginSettingBtnValue = __( 'Save Setting', SPEEDOMETERV3_TEXT_DOMAIN );
$scanBtnValue = __( 'SCAN', SPEEDOMETERV3_TEXT_DOMAIN );
$syncBtnValue = __( 'SYNC', SPEEDOMETERV3_TEXT_DOMAIN );
?>

<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />
<div class="Speedometer-main">
	<header>
		<div class="container">
			<div class="head-wrap">
				<div class="logo">
					<a href="#"><img src="<?php echo esc_url( SPEEDOMETERV3_PLUGIN_URL . 'admin/images/logo.png' ); ?>"></a>
				</div>
			</div>
		</div>
	</header>
	<div class="content-part">
			<div class="tab-main">
				<div class="tab-wrap">
					<div class="container">
						<ul class="tabs">
						<li class="<?php echo esc_attr( $speedometerv3_list_dashboard );?>">
							<a class="dotstore_plugin" href="<?php
							echo esc_url( site_url( '/wp-admin/admin.php?page=speedometer' ) );
							?>"><?php
								esc_html_e( 'Dashboard', SPEEDOMETERV3_TEXT_DOMAIN );
								?></a>
						</li>
						<li class="<?php echo esc_attr( $speedometerv3_settings ); ?>">
							<a class="dotstore_plugin" href="<?php
							echo esc_url( admin_url( '/admin.php?page=speedometer-setting' ) );
							?>"> <?php
								esc_html_e( 'Settings', SPEEDOMETERV3_TEXT_DOMAIN );
								?></a>
						</li>
						<!-- <li class="<?php echo esc_attr( $speedometerv3_scan ); ?>">
							<a class="dotstore_plugin" href="<?php
							echo esc_url( admin_url( '/admin.php?page=speedometer-scan' ) );
							?>"> <?php
								esc_html_e( 'Scan', SPEEDOMETERV3_TEXT_DOMAIN );
								?></a>
						</li> -->
						</ul>
					</div>
				</div>
			