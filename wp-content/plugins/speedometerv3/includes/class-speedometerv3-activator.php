<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Speedometerv3
 * @subpackage Speedometerv3/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Speedometerv3
 * @subpackage Speedometerv3/includes
 * @author     Multidots <multidots@multidots.com>
 */
class Speedometerv3_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		if ( is_multisite() ) {
			$old_blog = $wpdb->blogid;
			// Get all blog data
			$blogids = $wpdb->get_results( "SELECT * FROM $wpdb->blogs" );
			foreach ( $blogids as $site ) {
				switch_to_blog( $site->blog_id );
				self::sm_database_create( $wpdb->prefix );
				$table_nm = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration';
//				$website_name      = $site->domain;
				$website_name      = site_url();
				$website_sh_record = $wpdb->get_var( "SELECT * FROM $table_nm WHERE website_url LIKE '%$website_name%'" ); //db call ok; no-cache ok
				if ( empty( $website_sh_record ) ) {
					$token           = 'MD_' . time() . '_' . rand( 1, 90000 );
					$wizard_sql_data = $wpdb->insert( $table_nm, array(
							//'id'              => '1',
							'mercury_token'   => $token,
							'sync_data_pause' => 1,
							'scan_frequency'  => 1,
							'plugin'          => 1,
							'website_url'     => $website_name,
							'created_date'    => date( "Y-m-d H:i:s" ),
							'updated_date'    => date( "Y-m-d H:i:s" ),
						)
					);
					dbDelta( $wizard_sql_data );
				} else {
					$wpdb->update( $table_nm, array( 'plugin' => 1 ), array( 'id' => $website_sh_record ) );
				}
				$get_last_scan_log = $wpdb->get_results( "SELECT * FROM $table_nm ORDER BY id DESC LIMIT 1", ARRAY_A );
				if ( is_array( $get_last_scan_log ) && ! empty( $get_last_scan_log ) ) {
					self::sm_remote_api( SPEEDOMETERV3_SITEAPI_URL . 'mercury', $get_last_scan_log[0] );
				}
			}
			switch_to_blog( $old_blog );
		} else {
			$current_blog_id = get_current_blog_id();
			$domain_url      = get_site_url( $current_blog_id );
			$disallowed      = array( 'http://', 'https://' );
			foreach ( $disallowed as $d ) {
				if ( strpos( $domain_url, $d ) === 0 ) {
					$domain_name = str_replace( $d, '', $domain_url );
				}
			}
			self::sm_database_create( $wpdb->prefix );
			$table_nm = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration';
			//$website_name      = $domain_name;
			$website_name      = site_url();
			$website_sh_record = $wpdb->get_var( "SELECT * FROM $table_nm WHERE website_url LIKE '%$website_name%'" ); //db call ok; no-cache ok
			if ( empty( $website_sh_record ) ) {
				$token           = 'MD_' . time() . '_' . rand( 1, 90000 );
				$wizard_sql_data = $wpdb->insert( $table_nm, array(
						//'id'              => '1',
						'mercury_token'   => $token,
						'sync_data_pause' => 1,
						'scan_frequency'  => 1,
						'plugin'          => 1,
						'website_url'     => $website_name,
						'created_date'    => date( "Y-m-d H:i:s" ),
						'updated_date'    => date( "Y-m-d H:i:s" ),
					)
				);
				dbDelta( $wizard_sql_data );
			} else {
				$wpdb->update( $table_nm, array( 'plugin' => 1 ), array( 'id' => $website_sh_record ) );
			}
			$get_last_scan_log = $wpdb->get_results( "SELECT * FROM $table_nm ORDER BY id DESC LIMIT 1", ARRAY_A );
			if ( is_array( $get_last_scan_log ) && ! empty( $get_last_scan_log ) ) {
				self::sm_remote_api( SPEEDOMETERV3_SITEAPI_URL . 'mercury', $get_last_scan_log[0] );
			}
		}
		self::suggesation_bank_create($wpdb->prefix);
		wp_redirect( esc_url( admin_url( 'admin.php?page=speedometer' ) ) );
//		exit();
	}

	public static function sm_database_create( $prefix = 'wp_' ) {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;
		$wpdb->prefix    = $prefix;
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
			sync_data_pause int(11) NOT NULL DEFAULT 1,
			scan_frequency int(11) NOT NULL DEFAULT 1,
			website_url varchar(255) NULL ,
			plugin int(11) NOT NULL DEFAULT 1,
			is_active int(11) NOT NULL DEFAULT 1,
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
			created_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";
		dbDelta( $sql );


		$sm_domain_list = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_scan_display';

		$sql = "CREATE TABLE IF NOT EXISTS {$sm_domain_list} (
			id int(20) NOT NULL AUTO_INCREMENT,
			scan_id int(20) NOT NULL,
			scan_details longtext NOT NULL,
			created_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) {$charset_collate};";
		dbDelta( $sql );
	}

	public static function suggesation_bank_create( $prefix = 'wp_' ) {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;
		$wpdb->prefix    = $prefix;
		$charset_collate = $wpdb->get_charset_collate();

		$suggesation_bank = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_bank';
		$sql = "CREATE TABLE IF NOT EXISTS {$suggesation_bank} (
			id int(20) NOT NULL AUTO_INCREMENT,
			param_key varchar(255) NOT NULL,
			param_type varchar(255) NOT NULL,
			param_label varchar(255) NOT NULL,
			param_description text NOT NULL,
			statement_0 text NOT NULL,
			statement_1 text NOT NULL,
			statement_2 text NOT NULL,
			value_0 varchar(255) NOT NULL,
			value_1 varchar(255) NOT NULL,
			value_2 varchar(255) NOT NULL,
			value_sep varchar(255) NOT NULL,
			priority  int(11) NOT NULL,
			conditional varchar(255) NOT NULL,
			PRIMARY KEY  (id)
		) {$charset_collate};";
		dbDelta( $sql );

		$sql_script = file_get_contents( SPEEDOMETERV3_SUGGESATION_BANK );
		$suggesation_bank_arr = json_decode($sql_script,true);
		if( !empty( $suggesation_bank_arr ) ) {
			foreach ($suggesation_bank_arr['data'] as $key => $value) {
				$wpdb->insert( $suggesation_bank, $value );
			}
		}
	}

	public function sm_remote_api( $site_url, $data ) {
		$args = array(
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'body'    => json_encode( $data ),
			'method'  => 'POST'
		);
		$response = wp_remote_request( $site_url, $args );
	}
}
