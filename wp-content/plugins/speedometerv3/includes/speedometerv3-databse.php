<?php

/**
 * Fired during plugin activation create the databse table
 *
 * @link       https://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Speedometerv3
 * @subpackage Speedometerv3/includes
 */
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$sm_domain_list = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'sync_log';

$sql = "CREATE TABLE IF NOT EXISTS {$sm_domain_list} (
	id int(20) NOT NULL AUTO_INCREMENT,
	sync_date timestamp,
	sync_data text NULL,
	other_details text NULL,
	status enum('SUCCESS', 'FAIL', 'PROCESSING') NULL,
	PRIMARY KEY  (id)
	) {$charset_collate};";
dbDelta( $sql );



$sm_domain_list = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration';

$sql = "CREATE TABLE IF NOT EXISTS {$sm_domain_list} (
	id int(20) NOT NULL AUTO_INCREMENT,
	mercury_token varchar(255) NOT NULL,
	sync_data_pause int(11) NOT NULL DEFAULT 0,
	scan_frequency enum('DAILY', 'WEEKLY') NOT NULL DEFAULT'DAILY',
	website_url varchar(255) NULL ,
	created_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY  (id)
	) {$charset_collate};";
dbDelta( $sql );



$sm_domain_list = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'scan_log';

$sql = "CREATE TABLE IF NOT EXISTS {$sm_domain_list} (
	id int(20) NOT NULL AUTO_INCREMENT,
	data text NULL,
	other_details text NULL,
	is_send int(11) NOT NULL DEFAULT 0,
	PRIMARY KEY  (id)
	) {$charset_collate};";
dbDelta( $sql );
