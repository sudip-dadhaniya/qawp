<?php
/**
 * Environment data collector.
 *
 * @package query-monitor
 */

class sm_environment {
	
	public $id = 'environment';
	public $php_vars = array(
		'max_execution_time',
		'memory_limit',
		'upload_max_filesize',
		'post_max_size',
		'display_errors',
		'log_errors',
	);
	public static $operater_array = array(
		'=='  => 'equal',
		'===' => 'totallyEqual',
		'!='  => 'notEqual',
		'>'   => 'greaterThan',
		'>='  => 'greaterThanOrEqual',
		'<'   => 'lessThan',
		'<='  => 'lessThanOrEqual',
		'in'  => 'inOperater',
	);
	public static $param_border_type = array(
		0  => 'red-border',
		1  => 'yellow-border',
		2  => 'green-border'
	);
	// public $embed = [
	// 	'per_embed_discover_plugins'  => 0,
	// 	'per_embed_discove'           => 0,
	// 	'per_disable_embeds_rewrites' => 0,
	// 	'oembed_register_route'       => 0,
	// 	'filter_oembed_result'        => 0,
	// 	'add_discovery_links'         => 0,
	// 	'oembed_add_host_js'          => 0,
	// 	'pre_oembed_result'           => 0,
	// ];
	// public $wlwmanifest_link = 0;
	// public $rsd_link = 0;
	// public $shortlink = 0;
	// public $rss_feed_links = 0;
	// public $rest_api_links = 0;
	// public $wp_generator = 0;

	public function __construct() {

		global $wpdb;

		# If QM_DB is in place then we'll use the values which were
		# caught early before any plugins had a chance to alter them

		foreach ( $this->php_vars as $setting ) {
			if ( isset( $wpdb->qm_php_vars ) && isset( $wpdb->qm_php_vars[ $setting ] ) ) {
				$val = $wpdb->qm_php_vars[ $setting ];
			} else {
				$val = ini_get( $setting );
			}
			$this->data['php']['variables'][ $setting ]['before'] = $val;
		}
		$this->data['php']['error_reporting'] = error_reporting();
		$this->data['php']['error_levels']    = self::get_error_levels( $this->data['php']['error_reporting'] );
		if ( ! defined("SM_COMPARE_ARRAY")){
			define('SM_COMPARE_ARRAY', sm_environment::$operater_array); //Constant for sanitize label & name.
		}
		
		self::process();
		self::process_scan_server();
		self::process_scan_backend_data();
		self::process_scan_database();
		self::process_scan_plugin();
		self::process_scan_themes();
		self::process_scan_perf();
		self::process_scan_wp_details();
		//self::wp_recommendation();
		self::dynamic_recommendation( self::sm_param_result_plugin( $this->data ) );
		foreach( array_keys($this->data) as $scan_key => $scan_result) {
			$this->data['sm_parameter'][$scan_result] = self::sm_param_result_plugin( $this->data[$scan_result] );
			foreach ($this->data['sm_parameter'][$scan_result] as $key => $value) {
				if (is_int($key)) {
					unset($this->data['sm_parameter'][$scan_result][$key]);
				}
			}
		}
		//self::dynamic_recommendation( $this->data['sm_parameter'] );
		
	}

	public function get_error_levels( $error_reporting ) {
		$levels = array(
			'E_ERROR'             => false,
			'E_WARNING'           => false,
			'E_PARSE'             => false,
			'E_NOTICE'            => false,
			'E_CORE_ERROR'        => false,
			'E_CORE_WARNING'      => false,
			'E_COMPILE_ERROR'     => false,
			'E_COMPILE_WARNING'   => false,
			'E_USER_ERROR'        => false,
			'E_USER_WARNING'      => false,
			'E_USER_NOTICE'       => false,
			'E_STRICT'            => false,
			'E_RECOVERABLE_ERROR' => false,
			'E_DEPRECATED'        => false,
			'E_USER_DEPRECATED'   => false,
			'E_ALL'               => false,
		);

		foreach ( $levels as $level => $reported ) {
			if ( defined( $level ) ) {
				$c = constant( $level );
				if ( $error_reporting & $c ) {
					$levels[ $level ] = true;
				}
			}
		}

		return $levels;
	}

	public function process() {

		global $wp_version;
		global $wpdb;

		$mysql_vars = array(
			'key_buffer_size'    => true,  # Key cache size limit
			'max_allowed_packet' => false, # Individual query size limit
			'max_connections'    => false, # Max number of client connections
			'query_cache_limit'  => true,  # Individual query cache size limit
			'query_cache_size'   => true,  # Total cache size limit
			'query_cache_type'   => 'ON',  # Query cache on or off
		);

		$this->data['php']['php_version'] = (float)phpversion();
		$this->data['php']['sapi']    = php_sapi_name();
		$this->data['php']['user']    = self::get_current_user();
		$this->data['php']['old']     = version_compare( $this->data['php']['php_version'], 7.1, '<' );

		foreach ( $this->php_vars as $setting ) {
			$this->data['php']['variables'][ $setting ]['after'] = ini_get( $setting );
		}

		if ( defined( 'SORT_FLAG_CASE' ) ) {
			// phpcs:ignore PHPCompatibility.Constants.NewConstants
			$sort_flags = SORT_STRING | SORT_FLAG_CASE;
		} else {
			$sort_flags = SORT_STRING;
		}

		if ( is_callable( 'get_loaded_extensions' ) ) {
			$extensions = get_loaded_extensions();
			sort( $extensions, $sort_flags );
			$this->data['php']['extensions'] = array_combine( $extensions, array_map( array( $this, 'get_extension_version' ), $extensions ) );
		} else {
			$this->data['php']['extensions'] = array();
		}

		$this->data['php']['error_reporting'] = error_reporting();
		$this->data['php']['error_levels']    = self::get_error_levels( $this->data['php']['error_reporting'] );

		$this->data['wp']['version']   = (float)$wp_version;
	
		$constants                     = array(
			'WP_DEBUG'            => self::format_bool_constant( 'WP_DEBUG' ),
			'WP_DEBUG_DISPLAY'    => self::format_bool_constant( 'WP_DEBUG_DISPLAY' ),
			'WP_DEBUG_LOG'        => self::format_bool_constant( 'WP_DEBUG_LOG' ),
			'SCRIPT_DEBUG'        => self::format_bool_constant( 'SCRIPT_DEBUG' ),
			'WP_CACHE'            => self::format_bool_constant( 'WP_CACHE' ),
			'CONCATENATE_SCRIPTS' => self::format_bool_constant( 'CONCATENATE_SCRIPTS' ),
			'COMPRESS_SCRIPTS'    => self::format_bool_constant( 'COMPRESS_SCRIPTS' ),
			'COMPRESS_CSS'        => self::format_bool_constant( 'COMPRESS_CSS' ),
			'WP_LOCAL_DEV'        => self::format_bool_constant( 'WP_LOCAL_DEV' ),
		);
		// $this->data['wp']['constants'] = apply_filters( 'qm/environment-constants', $constants );
		$this->data['wp']['constants']  = $constants;
		
		if ( is_multisite() ) {
			$this->data['wp']['constants']['SUNRISE'] = self::format_bool_constant( 'SUNRISE' );
		}

		if ( isset( $_SERVER['SERVER_SOFTWARE'] ) ) {
			$server = explode( ' ', wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) );
			$server = explode( '/', reset( $server ) );
		} else {
			$server = array( '' );
		}

		if ( isset( $server[1] ) ) {
			$server_version = $server[1];
		} else {
			$server_version = null;
		}

		if ( isset( $_SERVER['SERVER_ADDR'] ) ) {
			$address = wp_unslash( $_SERVER['SERVER_ADDR'] );
		} else {
			$address = null;
		}

		$this->data['server'] = array(
			'name'    => $server[0],
			'server_version' => $server_version,
			'address' => $address,
			'host'    => null,
			'OS'      => null,
		);

		if ( function_exists( 'php_uname' ) ) {
			$this->data['server']['host'] = php_uname( 'n' );
			$this->data['server']['OS']   = php_uname( 's' ) . ' ' . php_uname( 'r' );
		}

	}

	public static function get_current_user() {

		$php_u = null;

		if ( function_exists( 'posix_getpwuid' ) ) {
			$u     = posix_getpwuid( posix_getuid() );
			$g     = posix_getgrgid( $u['gid'] );
			$php_u = $u['name'] . ':' . $g['name'];
		}

		if ( empty( $php_u ) && isset( $_ENV['APACHE_RUN_USER'] ) ) {
			$php_u = $_ENV['APACHE_RUN_USER'];
			if ( isset( $_ENV['APACHE_RUN_GROUP'] ) ) {
				$php_u .= ':' . $_ENV['APACHE_RUN_GROUP'];
			}
		}

		if ( empty( $php_u ) && isset( $_SERVER['USER'] ) ) {
			$php_u = wp_unslash( $_SERVER['USER'] );
		}

		if ( empty( $php_u ) && function_exists( 'exec' ) ) {
			$php_u = exec( 'whoami' ); // @codingStandardsIgnoreLine
		}

		if ( empty( $php_u ) && function_exists( 'getenv' ) ) {
			$php_u = getenv( 'USERNAME' );
		}

		return $php_u;

	}

	public static function format_bool_constant( $constant ) {
		// @TODO this should be in QM_Util

		if ( ! defined( $constant ) ) {
			/* translators: Undefined PHP constant */
			return __( 'undefined', SPEEDOMETERV3_TEXT_DOMAIN );
		} elseif ( is_string( constant( $constant ) ) && ! is_numeric( constant( $constant ) ) ) {
			return constant( $constant );
		} elseif ( ! constant( $constant ) ) {
			return false;
		} else {
			return true;
		}
	}

	public function process_scan_server( $request = '' ) {

		$page_url = site_url();

		$server_data = array();

		$object_cache = '';
		$mem_cache    = '';
		$redis_cache  = '';

		$path = ABSPATH . 'wp-content/object-cache.php';
		if ( file_exists( $path ) ) {
			$object_cache = 1;
		} else {
			$object_cache = 0;
		}

		if ( extension_loaded( 'redis' ) ) {
			$redis_cache = 1;
		} else {
			$redis_cache = 0;
		}

		if ( extension_loaded( 'memcached' ) ) {
			$mem_cache = 1;
		} else {
			$mem_cache = 0;
		}

		if ( ! defined( 'WP_CACHE' ) ) {
			return __( 'undefined', 'MERCURY' );
		} elseif ( ! constant( 'WP_CACHE' ) ) {
			$wp_cache = 0;
		} else {
			$wp_cache = 1;
		}

		$ch = curl_init( $page_url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		if ( curl_exec( $ch ) ) {
			$info                         = curl_getinfo( $ch );
			$server_data['response_time'] = array( 'time' => $info['total_time'] );
		} else {
			$server_data['response_time'] = array( 'time' => '' );
		}

		if ( isset( $server ) ) {
			$server_detail = explode( '/', $server );
		} else {
			$server_detail = array( '' );
		}

		if ( isset( $server_detail[1] ) && $server_detail[0] !== 'nginx' ) {
			$server_version = $server_detail[1];
		} else if ( isset( $server_detail[1] ) && $server_detail[0] === 'nginx' ) {

			$server_version = str_replace( "\n", "", $server_detail[1] );
		} else {
			$server_version = null;
		}

		$this->data['server']['object_cache']   = $object_cache;
		$this->data['server']['mem_cache']      = $mem_cache;
		$this->data['server']['redish_cache']   = $redis_cache;
		$this->data['server']['wp_cache']       = $wp_cache;
		$this->data['server']['wp_upgrade_url'] = get_admin_url() . 'update-core.php';

		//return $server_data;
	}

	public function process_scan_backend_data() {

		global $wpdb;

		/*Post Revision*/

		$wp_post_revision = WP_POST_REVISIONS;
		
		$result = [];
		if ( ( $wp_post_revision === true || $wp_post_revision === 'true' ) || ( gettype( $wp_post_revision ) === 'boolean' && $wp_post_revision === true ) ) {
			$result['control_revision_enable'] = true;
			$result['control_revision_count']  = true;
		} else if ( $wp_post_revision >= 2 ) {
			$result['control_revision_enable'] = true;
			$result['control_revision_count']  = true;
		} else if ( ($wp_post_revision === false || $wp_post_revision === 'false' ) || ( gettype( $wp_post_revision ) === 'boolean' && $wp_post_revision === false ) ) {
			$result['control_revision_enable'] = false;
			$result['control_revision_count']  = false;
		}

		/*Pingback*/
		$wp_pingback = get_option( 'default_pingback_flag' );
		if ( isset( $wp_pingback ) && $wp_pingback === 1 ) {
			$result['pingback_enable'] = 1;
		} else {
			$result['pingback_enable'] = 0;
		}

		/*Expired Transiete*/


		$expired_transiet_result = $wpdb->get_results( $wpdb->prepare( "SELECT count(option_id) as expired_transiet_count FROM " . $wpdb->options . " where option_name LIKE %s", '%_transient_timeout_%' ), 'ARRAY_A' );
		if ( isset( $expired_transiet_result ) && $expired_transiet_result > 0 ) {
			$result['expired_transiet_count'] = (int) $expired_transiet_result[0]['expired_transiet_count'];
		} else {
			$result['expired_transiet_count'] = 0;
		}

		/*Comments*/

		$wp_comments          = get_option( 'default_comment_status' );
		$wp_comments_per_page = get_option( 'comments_per_page' );
		if ( isset( $wp_comments ) ) {
			if ( $wp_comments === 'closed' ) {
				$result['comments_status'] = 1;
			} else {
				$result['comments_status'] = 0;
			}
		}
		if ( isset( $wp_comments_per_page ) ) {
			$result['wp_comments_per_page'] = (int) $wp_comments_per_page;
		}

		/* Server */

		$php_max_execution_time  = ini_get( 'max_execution_time' );
		$php_memory_limit        = ini_get( 'memory_limit' );
		$php_upload_max_filesize = ini_get( 'upload_max_filesize' );
		$php_post_max_size       = ini_get( 'post_max_size' );
		if ( isset( $php_max_execution_time ) ) {
			$result['max_execution_time'] = (int) $php_max_execution_time;
		}
		if ( isset( $php_memory_limit ) ) {
			$result['memory_limit'] = (int)$php_memory_limit;
		}
		if ( isset( $php_upload_max_filesize ) ) {
			$result['upload_max_filesize'] = (int)$php_upload_max_filesize;
		}
		if ( isset( $php_post_max_size ) ) {
			$result['post_max_size'] = (int)$php_post_max_size;
		}

		/* Check SSL */
		$wp_ssl = is_ssl();
		if ( $wp_ssl === true ) {
			$result['is_ssl'] = true;
		} else {
			$result['is_ssl'] = false;
		}
		/* Trash post and page ccount */


		$trashed_post_page_result = $wpdb->get_results( $wpdb->prepare( "SELECT count(ID) as trashed_post_page FROM " . $wpdb->posts . " where post_status = %s and (post_type = 'post' OR post_type= 'page')", 'trash' ), 'ARRAY_A' );
		if ( isset( $trashed_post_page_result ) && $trashed_post_page_result > 0 ) {
			$result['trashed_post_page'] = $trashed_post_page_result[0]['trashed_post_page'];
		} else {
			$result['trashed_post_page'] = 0;
		}

		/* Define auto trash days */

		$wp_auto_trash = EMPTY_TRASH_DAYS;

		if ( gettype( $wp_auto_trash ) === 'boolean' && $wp_auto_trash === true ) {
			$result['empty_auto_trash_days'] = 0;
		} else if ( gettype( $wp_auto_trash ) === 'integer' ) {
			$result['empty_auto_trash_days'] = $wp_auto_trash;
		} else if ( gettype( $wp_auto_trash ) === 'boolean' && $wp_auto_trash === false ) {
			$result['empty_auto_trash_days'] = 0;
		}

		/*Check apache mode rewrite */

		if ( function_exists( 'apache_get_modules' ) ) {
			if ( in_array( 'mod_rewrite', apache_get_modules() ) ) {
				$result['mod_rewrite'] = 'enabled';
			} else {
				$result['mod_rewrite'] = 'disabled';
			}

			if ( in_array( 'mod_security', apache_get_modules() ) ) {
				$result['mod_security'] = 'enabled';
			} else {
				$result['mod_security'] = 'disabled';
			}
		} else {
			$result['mod_rewrite']  = 'Not Detected!';
			$result['mod_security'] = 'Not Detected!';
		}

		/*Check enable logs */
		if ( ini_get( 'log_errors' ) === '1' ) {
			$result['log_errors'] = true;
		} else {
			$result['log_errors'] = false;
		}

		/*Check display errors logs */
		if ( ini_get( 'display_errors' ) === '1'  ) {
			$result['display_errors'] = true;
		} else {
			$result['display_errors'] = false;
		}
		
		$this->data['wp']['extrafields'] = $result;

		return $result;
	}

	public function process_scan_database() {
		global $wpdb;

		$wp_db_tables     = array();
		$noneWp_db_tables = array();
		$database_data    = [];

		$result                = $wpdb->get_results( $wpdb->prepare( "SHOW TABLES FROM `$wpdb->dbname`", "" ), 'ARRAY_A' );
		$wp_db_table_count     = 0;
		$noneWp_db_table_count = 0;
		foreach ( $result as $table ) {
			if ( strpos( $table[ 'Tables_in_' . $wpdb->dbname ], $wpdb->base_prefix ) !== false ) {
				array_push( $wp_db_tables, $table[ 'Tables_in_' . $wpdb->dbname ] );
				$wp_db_table_count ++;
			} else {
				array_push( $noneWp_db_tables, $table[ 'Tables_in_' . $wpdb->dbname ] );
				$noneWp_db_table_count ++;
			}
		}


		$autoLoader_result = $wpdb->get_results( $wpdb->prepare( "SELECT SUM(LENGTH(option_value)) as autoload_size FROM %s WHERE autoload='yes'", $wpdb->prefix . " options" ), 'ARRAY_A' );
		$option_tbl_result = $wpdb->get_results( $wpdb->prepare( "SELECT SUM(LENGTH(option_value)) as option_tbl_size FROM %s", $wpdb->prefix . "options" ), 'ARRAY_A' );

		$sqlversion = $wpdb->get_var( "SELECT VERSION() AS version" );
		$sqlversion = preg_match( "#^\d+(\.\d+)*#", $sqlversion, $match );
		$sqlversion = $match[0];

		$Dbversion_info_result = $wpdb->get_results( $wpdb->prepare( "SHOW VARIABLES LIKE \"%version%\"", "" ), 'ARRAY_A' );
		$Dbversion             = array_column( $Dbversion_info_result, 'Value', 'Variable_name' );

		if ( $wpdb->is_mysql === '1' ) {
			$Dbversion_info = 'Mysql';
		} else {
			$Dbversion_info = 'MariaDB';
		}

		/* check query_cache_size  */

		$result_cache = $wpdb->get_results( $wpdb->prepare( "SHOW STATUS LIKE '%Qcache_queries_in_cache%'", '' ), 'ARRAY_A' );

		if ( count( $result_cache ) > 0 ) {
			$database_data['query_cache_size'] = $result_cache[0]['Value'];
		} else {
			$database_data['query_cache_size'] = '0';
		}

		/* check key_buffer  */
		$result_key_buffer = $wpdb->get_results( $wpdb->prepare( "SHOW VARIABLES LIKE '%key_buffer%'", '' ), 'ARRAY_A' );

		if ( count( $result_key_buffer ) > 0 ) {
			$database_data['key_buffer_size'] = $result_key_buffer[0]['Value'];
		} else {
			$database_data['key_buffer_size'] = '0';
		}

		$database_data['wp_tables']            = $wp_db_tables;
		$database_data['none_wp_tables']       = $noneWp_db_tables;
		$database_data['wp_tables_count']      = $wp_db_table_count;
		$database_data['none_wp_tables_count'] = $noneWp_db_table_count;
		$database_data['autoload_option_size'] = (int) $autoLoader_result[0]['autoload_size'];
		$database_data['option_tbl_size']      = (int) $option_tbl_result[0]['option_tbl_size'];
		$database_data['db_server_version']    = $sqlversion;
		$database_data['db_server_type']       = $Dbversion_info . ' - ' . $Dbversion['version_comment'];

		$this->data['database'] = $database_data;

		//return $database_data;
	}

	public function process_scan_plugin( $request = '' ) {

		// Gets all active plugins on the current site
		$activePlugins = get_option( 'active_plugins' );

		if ( is_multisite() ) {
			$network_active_plugins = get_site_option( 'active_sitewide_plugins' );
			if ( ! empty( $network_active_plugins ) ) {
				$network_active_plugins = array_keys( $network_active_plugins );
				$activePlugins          = array_merge( $activePlugins, $network_active_plugins );
			}
		}


		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$allPlugins           = get_plugins();
		$plugin_counter       = 0;
		$plugin_data          = array();
		$plugin_details       = array();
		$upgrade_plugin_count = 0;
		$active_plugin_count  = 0;

		foreach ( $allPlugins as $key => $plugin ) {

			$latest_version['version'] = $this->sm_get_plugin_latest_version( $plugin['TextDomain'] );

			$plugin_details[ $plugin_counter ]['plugin_name']        = $plugin['Name'];
			$plugin_details[ $plugin_counter ]['plugin_slug']        = $plugin['TextDomain'];
			$plugin_details[ $plugin_counter ]['plugin_source_url']  = $plugin['PluginURI'];
			$plugin_details[ $plugin_counter ]['plugin_description'] = $plugin['Description'];
			$plugin_details[ $plugin_counter ]['plugin_author']      = $plugin['Author'];
			$plugin_details[ $plugin_counter ]['plugin_author_uri']  = $plugin['AuthorURI'];
			$plugin_details[ $plugin_counter ]['plugin_textdomain']  = $plugin['TextDomain'];


			if ( $latest_version['version'] !== '' && version_compare( $plugin['Version'], $latest_version['version'], '<' ) ) {

				if ( isset( $latest_version['version'] ) && $latest_version['version'] !== '' ) {
					$plugin_details[ $plugin_counter ]['plugin_current_version'] = $plugin['Version'];
					$plugin_details[ $plugin_counter ]['plugin_latest_version']  = $latest_version['version'];
				}
				$plugin_details[ $plugin_counter ]['is_update'] = 1;
				$upgrade_plugin_count ++;
			} else {
				$plugin_details[ $plugin_counter ]['is_update']             = 0;
				$plugin_details[ $plugin_counter ]['plugin_latest_version'] = $plugin['Version'];
			}

			if ( in_array( $key, $activePlugins, true ) ) {
				$plugin_details[ $plugin_counter ]['is_active'] = 1;
				$active_plugin_count ++;
			} else {
				$plugin_details[ $plugin_counter ]['is_active'] = 0;
			}
			$plugin_counter ++;
		}
		$plugin_data['plugin_data']            = $plugin_details;
		$plugin_data['activated_plugin_count'] = $active_plugin_count;
		$plugin_data['total_plugin_count']     = count( $allPlugins );
		$plugin_data['upgrade_plugin_count']   = $upgrade_plugin_count;
		
		$this->data['wp']['plugin'] = $plugin_data;
	}

	public function sm_get_plugin_latest_version( $plugin_slug = '' ) {

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		}

		if ( ! empty( $plugin_slug ) ) {
			$args = array(
				'slug' => $plugin_slug,
			);
		}

		/** Prepare our query */
		$call_api = plugins_api( 'plugin_information', $args );
		/** Check for Errors & Display the results */
		if ( is_wp_error( $call_api ) ) {

			$api_error = $call_api->get_error_message();

			return '';

		} else {

			if ( ! empty( $call_api->version ) ) {

				$version_latest = $call_api->version;

				return $version_latest;
			}
		}
	}

	public function process_scan_themes( $request = '' ) {

		$allThemes = wp_get_themes();

		$activeTheme         = wp_get_theme();
		$theme_data          = array();
		$theme_details       = array();
		$upgrade_theme_count = 0;
		$theme_counter       = 0;
		foreach ( $allThemes as $key => $theme ) {

			$latest_version['version'] = $this->sm_get_theme_latest_version( $theme->get( 'TextDomain' ) );

			$theme_details[ $theme_counter ]['theme_name']             = $theme->Name;
			$theme_details[ $theme_counter ]['theme_currrent_version'] = $theme->get( 'Version' );
			$theme_details[ $theme_counter ]['theme_slug']             = $theme->get( 'TextDomain' );
			$theme_details[ $theme_counter ]['theme_source_url']       = $theme->get( 'ThemeURI' );
			$theme_details[ $theme_counter ]['theme_author']           = $theme->get( 'Author' );
			$theme_details[ $theme_counter ]['theme_author_url']       = $theme->get( 'AuthorURI' );
			$theme_details[ $theme_counter ]['theme_textdomain']       = $theme->get( 'TextDomain' );
			$theme_details[ $theme_counter ]['theme_description']      = $theme->get( 'Description' );
			$theme_details[ $theme_counter ]['theme_tags']             = $theme->get( 'Tags' );


			if ( $latest_version['version'] !== '' && version_compare( $theme->get( 'Version' ), $latest_version['version'], '<' ) ) {

				if ( isset( $latest_version['version'] ) && $latest_version['version'] !== '' ) {
					$theme_details[ $theme_counter ]['theme_currrent_version'] = $theme->get( 'Version' );
					$theme_details[ $theme_counter ]['theme_latest_version']   = $latest_version['version'];
				}
				$theme_details[ $theme_counter ]['is_update'] = 1;
				$upgrade_theme_count ++;
			} else {
				$theme_details[ $theme_counter ]['is_update']            = 0;
				$theme_details[ $theme_counter ]['theme_latest_version'] = $theme->get['Version'];
			}

			if ( $key === $activeTheme->get( 'TextDomain' ) ) {
				$theme_details[ $theme_counter ]['is_active'] = 1;
			} else {
				$theme_details[ $theme_counter ]['is_active'] = 0;
			}

			$theme_counter ++;
		}

		$theme_data['theme_data']          = $theme_details;
		$theme_data['upgrade_theme_count'] = $upgrade_theme_count;
		$theme_data['total_theme_count']   = count( $allThemes );
		$theme_data['upgrade_theme_count'] = $upgrade_theme_count;

		$this->data['wp']['themes'] = $theme_data;

		//return $theme_data;
	}

	public function sm_get_theme_latest_version( $theme_slug = '' ) {

		if ( ! function_exists( 'themes_api' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/theme.php' );
		}

		if ( ! empty( $theme_slug ) ) {
			$args = array(
				'slug' => $theme_slug,
			);
		}

		/** Prepare our query */
		$call_api = themes_api( 'theme_information', $args );

		/** Check for Errors & Display the results */
		if ( is_wp_error( $call_api ) ) {

			$api_error = $call_api->get_error_message();

			return '';

		} else {

			if ( ! empty( $call_api->version ) ) {

				$version_latest = $call_api->version;

				return $version_latest;
			}
		}
	}

	public function process_scan_perf() {

		global $wp;
		$scan_perf                                                 = [];
		$scan_perf['emoji']['print_emoji_detection_script_head']   = 0;
		$scan_perf['emoji']['print_emoji_detection_script_admin']  = 0;
		$scan_perf['emoji']['print_emoji_styles']                  = 0;
		$scan_perf['emoji']['admin_print_styles_admin']            = 0;
		$scan_perf['emoji']['wp_staticize_emoji_content']          = 0;
		$scan_perf['emoji']['wp_staticize_emoji_comment_text_rss'] = 0;
		$scan_perf['emoji']['wp_staticize_emoji_for_email']        = 0;
		// $process_scan_perf['embed']['oembed_register_route']               = 0;
		// $process_scan_perf['embed']['filter_oembed_result']                = 0;
		// $process_scan_perf['embed']['add_discovery_links']                 = 0;
		// $process_scan_perf['embed']['oembed_add_host_js']                  = 0;
		// $process_scan_perf['embed']['pre_oembed_result']                   = 0;

		if ( has_action( 'wp_head', 'print_emoji_detection_script' ) ) {
			$scan_perf['emoji']['print_emoji_detection_script_head'] = 1;
		}
		if ( has_action( 'admin_print_scripts', 'print_emoji_detection_script' ) ) {
			$scan_perf['emoji']['print_emoji_detection_script_admin'] = 1;
		}
		if ( has_action( 'wp_print_styles', 'print_emoji_styles' ) ) {
			$scan_perf['emoji']['print_emoji_styles'] = 1;
		}
		if ( has_action( 'admin_print_styles', 'print_emoji_styles' ) ) {
			$scan_perf['emoji']['admin_print_styles_admin'] = 1;
		}
		if ( has_filter( 'the_content_feed', 'wp_staticize_emoji' ) ) {
			$scan_perf['emoji']['wp_staticize_emoji_content'] = 1;
		}
		if ( has_filter( 'comment_text_rss', 'wp_staticize_emoji' ) ) {
			$scan_perf['emoji']['wp_staticize_emoji_comment_text_rss'] = 1;
		}
		if ( has_filter( 'wp_mail', 'wp_staticize_emoji_for_email' ) ) {
			$scan_perf['emoji']['wp_staticize_emoji_for_email'] = 1;
		}

		if( in_array( 1, $scan_perf['emoji']  ) ) {
			$process_scan_perf['emoji'] = 0;
		} else {
			$process_scan_perf['emoji'] = 1;
		}

		// $wp->public_query_vars = array_diff( $wp->public_query_vars, array( 'embed', ) );
		// if ( has_action( 'rest_api_init', 'wp_oembed_register_route', 1 ) ) {
		// 	$process_scan_perf['embed']['oembed_register_route'] = 1;
		// }
		// if ( has_action( 'oembed_dataparse', 'wp_filter_oembed_result' ) ) {
		// 	$process_scan_perf['embed']['filter_oembed_result'] = 1;
		// }
		// if ( has_action( 'wp_head', 'wp_oembed_add_discovery_links' ) ) {
		// 	$process_scan_perf['embed']['add_discovery_links'] = 1;
		// }
		// if ( has_action( 'wp_head', 'wp_oembed_add_host_js' ) ) {
		// 	$process_scan_perf['embed']['oembed_add_host_js'] = 1;
		// }
		// if ( has_action( 'pre_oembed_result', 'wp_filter_pre_oembed_result' ) ) {
		// 	$process_scan_perf['embed']['pre_oembed_result'] = 1;
		// }

		if ( has_action( 'wp_head', 'wlwmanifest_link' ) ) {
			$process_scan_perf['wlwmanifest_link'] = 0;
		} else {
			$process_scan_perf['wlwmanifest_link'] = 1;
		}


		if ( has_action( 'wp_head', 'rsd_link' ) ) {
			$process_scan_perf['rsd_link'] = 0;
		} else {
			$process_scan_perf['rsd_link'] = 1;
		}

		if ( has_action( 'wp_head', 'wp_shortlink_wp_head' ) && has_action( 'template_redirect', 'wp_shortlink_header' ) ) {
			$process_scan_perf['shortlink'] = 0;
		} else {
			$process_scan_perf['shortlink'] = 1;
		}

		if ( has_action( 'wp_head', 'feed_links' ) && has_action( 'wp_head', 'feed_links_extra' ) ) {
			$process_scan_perf['rss_feed_links'] = 0;
		} else {
			$process_scan_perf['rss_feed_links'] = 1;
		}

		if ( has_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' ) && has_action( 'wp_head', 'rest_output_link_wp_head' ) && has_action( 'template_redirect', 'rest_output_link_header' ) ) {
			$process_scan_perf['rest_api_links'] = 0;
		} else {
			$process_scan_perf['rest_api_links'] = 1;
		}

		if ( has_action( 'wp_head', 'wp_generator' ) ) {
			$process_scan_perf['hide_wp_version'] = 0;
		} else {
			$process_scan_perf['hide_wp_version'] = 1;
		}

		//XML-RPC Status check
		$enabled = apply_filters( 'pre_option_enable_xmlrpc', false );
		if ( false === $enabled ) {
			$enabled = apply_filters( 'option_enable_xmlrpc', true );
		}
		$process_scan_perf['xml_rpc_status'] = apply_filters( 'xmlrpc_enabled', $enabled );
		
		if( $process_scan_perf['xml_rpc_status'] ) {
			$process_scan_perf['xml_rpc_status'] = 0;
		} else {
			$process_scan_perf['xml_rpc_status'] = 1;
		}

		//Disable Embeds status check
		// $handle = 'wp-embed';
		// $list = 'enqueued';
		// if ( wp_script_is( $handle, $list ) ) {
		// 	$process_scan_perf['wp_embed'] = 0;
		// } else {
		// 	$process_scan_perf['wp_embed'] = 1;
		// }

		//Disable dashicons status check
		$handle = 'dashicons';
		$list = 'registered';
		if ( wp_style_is( $handle, $list ) ) {
			$process_scan_perf['wp_dashicons'] = 0;
		} else {
			$process_scan_perf['wp_dashicons'] = 1;
		}
		
		$this->data['perf'] = $process_scan_perf;

	}

	public function process_scan_wp_details() {
		$count_posts = array();

		$count_posts['post'] = wp_count_posts( 'post' );
		$count_posts['page'] = wp_count_posts( 'page' );

		$args = array(
			'public'   => true,
			'_builtin' => false
		);

		$output   = 'names'; // 'names' or 'objects' (default: 'names')
		$operator = 'and'; // 'and' or 'or' (default: 'and')

		$get_custom_post_types = get_post_types( $args, $output, $operator );

		if ( ! empty( $get_custom_post_types ) && is_array( $get_custom_post_types ) ) {
			foreach ( $get_custom_post_types as $post ) {
				$count_posts['custom_posts'][ $post ] = wp_count_posts( $post );
			}
		}

		$this->data['wp_details'] = $count_posts;

		$comments       = array();
		$comments_count = wp_count_comments();

		$comments['approved']       = $comments_count->approved;
		$comments['spam']           = $comments_count->spam;
		$comments['trash']          = $comments_count->trash;
		$comments['moderated']      = $comments_count->moderated;
		$comments['total_comments'] = $comments_count->total_comments;

		$this->data['wp_details']['comments'] = $comments;


		$result            = [];
		$result['scripts'] = [];
		$result['styles']  = [];

		// Print all loaded Scripts
		global $wp_scripts;
		foreach ( $wp_scripts->queue as $script ) :
			$result['scripts'][] = $wp_scripts->registered[ $script ]->src . ";";
		endforeach;

		// Print all loaded Styles (CSS)
		global $wp_styles;
		foreach ( $wp_styles->queue as $style ) :
			$result['styles'][] = $wp_styles->registered[ $style ]->src . ";";
		endforeach;

		$this->data['wp_details']['scripts'] = $result['scripts'];
		$this->data['wp_details']['styles']  = $result['styles'];

		$site_url       = rtrim( site_url(), "/" ) . '/';
		$site_login_url = $site_url . "wp-admin/";
		$response       = wp_remote_get( $site_login_url );
		$response_code  = wp_remote_retrieve_response_code( $response );

		if ( $response_code === 200 ) {
			$this->data['wp_details']['change_login_url'] = 0;
		} else {
			$this->data['wp_details']['change_login_url'] = 1;
		}

		$accept_encoding = @getallheaders()['Accept-Encoding'];
		if ( $accept_encoding && preg_match( '/ *gzip *,?/', $accept_encoding ) ) {
			$this->data['wp_details']['gzip'] = 1;
		} else {
			$this->data['wp_details']['gzip'] = 0;
		}
	}

	public static function get_extension_version( $extension ) {
		// Nothing is simple in PHP. The exif and mysqlnd extensions (and probably others) add a bunch of
		// crap to their version number, so we need to pluck out the first numeric value in the string.
		$version = trim( phpversion( $extension ) );

		if ( ! $version ) {
			return $version;
		}

		$parts = explode( ' ', $version );

		foreach ( $parts as $part ) {
			if ( $part && is_numeric( $part[0] ) ) {
				$version = $part;
				break;
			}
		}

		return $version;
	}

	public static function get_client_version( $client ) {

		$client = intval( $client );

		$hello = $client % 10000;

		$major = intval( floor( $client / 10000 ) );
		$minor = intval( floor( $hello / 100 ) );
		$patch = intval( $hello % 100 );

		return compact( 'major', 'minor', 'patch' );

	}

	public function wp_recommendation() {
		global $wpdb;
		$recommendation = array();
		$table_nm = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'recommendation';
		$website_name      = site_url();
		$recommendation_data = $wpdb->get_results( "SELECT * FROM $table_nm" ); //db call ok; no-cache ok
		if( isset( $recommendation_data ) && !empty( $recommendation_data ) ) {


			//1. WordPress Version check
			$wp_version_key = array_search('wp_version', array_column($recommendation_data, 'parameters'));
			$version_response = wp_remote_get( SPEEDOMETERV3_WP_LATEST_VERSION_URL );
			if( !empty( $version_response ) ) {
				$json = $version_response['body'];
				$obj = json_decode($json);
				$upgrade = $obj->offers[0];
				$wp_latest_version = $upgrade->version;
				if ( version_compare($GLOBALS['wp_version'], $wp_latest_version ) >= 0) {
					if( isset( $wp_version_key ) ) {
						$this->data['recommendation']['wp_version_yes'] = $recommendation_data[$wp_version_key]->recommend_statement_yes;
					}
				} else {
					if( isset( $wp_version_key ) ) {
						$this->data['recommendation']['wp_version_no'] = $recommendation_data[$wp_version_key]->recommend_statement_no;
					}
				}  
			}

			if ( ! $this->data['perf']['xml_rpc_status'] ) {
				$this->data['recommendation']['XML-RPC Status'] = 'XML-RPC services are disabled on this site.';
			} else {
				$this->data['recommendation']['XML-RPC Status'] = 'XML-RPC services are enable on this site.';
			}

			//Disable Embeds status check
			if ( $this->data['perf']['wp_embed'] ) {
				$this->data['recommendation']['disable-embeds'] = 'scripts enqueued';
			} else {
				$this->data['recommendation']['disable-embeds'] = 'scripts not enqueued';
			}

			//Disable dashicons status check
			if ($this->data['perf']['wp_dashicons'] ) {
				$this->data['recommendation']['disable-dashicons'] = 'dashicons style enqueued';
			} else {
				$this->data['recommendation']['disable-dashicons'] = 'dashicons style not enqueued';
			}

			$wp_version_key = array_search('hide_wp_version', array_column($recommendation_data, 'parameters'));
			if( $this->data['perf']['hide_wp_version'] ) {
				$this->data['recommendation']['hide_wp_version_yes'] = $recommendation_data[$wp_version_key]->recommend_statement_yes;
			} else {
				$this->data['recommendation']['hide_wp_version_no'] = $recommendation_data[$wp_version_key]->recommend_statement_yes;
			}
			

			//4. Remove wlwmanifest link
			if ( $this->data['perf']['wlwmanifest_link'] ) {
				$this->data['recommendation']['wlwmanifest-link'] = 'Enable wlwmanifest link';
			} else {
				$this->data['recommendation']['wlwmanifest-link'] = 'Disable wlwmanifest link';
			}

			//5. Remove WordPress Version
			if ( $this->data['perf']['hide_wp_version'] ) {
				$this->data['recommendation']['wp_version_remove'] = 'Enable WordPress Version';
			} else {
				$this->data['recommendation']['wp_version_remove'] = 'Disable WordPress Version';
			}
			
			//7. Rest API status check
			if (  $this->data['perf']['rest_api_links'] ) {
				$this->data['recommendation']['rest-api'] = 'REST API Enabled';
			} else {
				$this->data['recommendation']['rest-api'] = 'REST API Disable';
			}
		}
	}

	public function dynamic_recommendation( $result ) {
		global $wpdb;
		$result_arr = [];
		$updated_arr = [];
		$recommendation_bank = array();
		$table_nm = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_bank';
		$recommendation_data = $wpdb->get_results( "SELECT * FROM $table_nm" ); //db call ok; no-cache ok
		if( isset( $recommendation_data ) && !empty( $recommendation_data ) ) {
			foreach( $recommendation_data as $suggestion_result ) {
				$data = '';
				$key = array_search( $suggestion_result->param_key, array_column( $recommendation_data, 'param_key' ) );
				$data = $result[$suggestion_result->param_key];
				$data_type = gettype( $data );
				if( ($data_type === 'integer') && ($data === 0 || $data === 1) ) {
					$data_check = (bool)$data;
				} else {
					$data_check = $data;
				}
				if( isset( $key ) ) {
					$recomm_results = $recommendation_data[$key];
					if( $recomm_results->conditional == 'API' ) {
						$this->sm_update_version( $recomm_results->param_key );
					}
					$recommendation_operator = $recomm_results->value_sep;
					for ($i=2; $i >= 0; $i--) {
						$value_var = 'value_'.$i;
						if( $i == 2 ){ 
							$parm_ideal_value = $recomm_results->$value_var;
						}
						$statement_var = 'statement_'.$i;
						$value = $recomm_results->$value_var;
						if($method = sm_environment::$operater_array[$recommendation_operator]){
							if( $recommendation_operator === 'in' ){
								$array = explode (",", $value);
								$searchstring = $data_check;
								if( is_array( $array ) ) {
									foreach($array as $string) {
										if(strpos($searchstring, $string) !== false) {
											$match =  true;
											break;
										}
									}
								}
								if( $match ) {
									$param_type = sm_environment::$param_border_type[2];
									$recomm_results->$statement_var = $recomm_results->statement_2;
								} else {
									$param_type = sm_environment::$param_border_type[0];
									$recomm_results->$statement_var = $recomm_results->statement_0;
								}
								break;
							} else {
								$oprater_result = self::$method( $data_check, $value );
								if( $oprater_result ){
									$param_type = sm_environment::$param_border_type[$i];
									break;
								}
							}
						}
					}
					
					$data_parm_ideal_value = reset( explode(',', $parm_ideal_value) );
					

					// if('none_wp_tables_count' === $suggestion_result->param_key){
					// 	if( $data === 'false' ) {
					// 		$data = 0;
					// 	}
					// }

					if('COUNT' != $suggestion_result->conditional){
						if( empty( $data ) && $data === false ){
							$data = 0;	
						} elseif( empty( $data ) ) {
							$data = 0;
						}

						if( $data == 0 )
							$data = 'false';
						elseif( $data == 1 )
							$data = 'true';
					}

					
					$arr = array(
						'param_key' => $suggestion_result->param_key,
						'param_name' => $recomm_results->param_label,
						'param_value' => $data,
						'param_ideal_value' => $data_parm_ideal_value,
						'param_border_type' => $param_type,
						'param_priority' => $recomm_results->priority
					);	
					$param_statement = str_replace( '{detected_value}', $data, $recomm_results->$statement_var);
					$param_statement = str_replace( '{value_2}', $parm_ideal_value, $param_statement);
					$arr['param_statement'] = $param_statement;
					$arr['type'] = $suggestion_result->param_type;
					$result_arr[] = $arr;	
				}
			}
		}
		$this->data['update_data'] = $result_arr;
	}

	function sm_param_result_plugin($array) { 
		if (!is_array($array)) { 
		  return FALSE; 
		} 
		$result = array(); 
		foreach ($array as $key => $value) { 
		  if (is_array($value)) { 
			$result = array_merge($result, self::sm_param_result_plugin($value)); 
		  } 
		  else { 
			$result[$key] = $value; 
		  } 
		} 
		return $result; 
	} 

	private function equal($data_check, $value){
		if( 'false' === $value ){
			return $data_check == false;
		} elseif( 'true' === $value ) {
			return $data_check == true;
		}
	}
	
	private function totallyEqual($data_check, $value){
		if( $data_check === 'Apache' || $data_check === 'apache' ){
			$data_check = 'apache';
			return $data_check === $value;
		}
		return $data_check === $value;
	}
	
	private function notEqual($data_check, $value){
		return $data_check != $value;
	}
	
	private function greaterThan($data_check, $value){
		return $data_check > $value;
	}
	
	private function lessThan($data_check, $value){
		return $data_check < $value;
	}
	
	private function greaterThanOrEqual($data_check, $value){
		return $data_check >= $value;
	}
	
	private function lessThanOrEqual($data_check, $value){
		return $data_check <= $value;
	}

	private function inOperater($data_check, $value){
		$array = explode (",", $value);
		$searchstring = $data_check;
		if( is_array( $array ) ) {
			foreach($array as $string) {
				if(strpos($searchstring, $string) !== false) {
					return true;
				}
			}
		}
		return false;
	}
	

	private function sm_update_version( $param_type ) {
		global $wpdb;
		$suggesation_bank = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_bank';
		if( empty( $param_type ) ){
			return;
		}
		if( $param_type === 'php_version' ) {
			$version_response = wp_remote_get( SPEEDOMETERV3_PHP_LATEST_VERSION_URL );
			if( !empty( $version_response ) ) {
				$php_json = $version_response['body'];
				$php_version_keys = array_reverse( array_keys( json_decode($php_json, true) ) );
				foreach( $php_version_keys as $key => $php_version ){
					$wpdb->update( $suggesation_bank, array( 'value_'.$key => (float)$php_version ), array( 'param_key' => 'php_version' ) );
				}
			}
		} elseif( $param_type === 'version' ) {
			$version_response = wp_remote_get( SPEEDOMETERV3_WP_LATEST_VERSION_URL );
			if( !empty( $version_response ) ) {
				$wp_json = $version_response['body'];
				$obj = json_decode($wp_json, true);
				$version_list = array_reverse( array_slice( array_keys( array_reverse( $obj ) ), 0, 3) );
				foreach ($version_list as $key => $value) {
					$wp_version_keys['value_'.$key] = (float)$value;
				}
				foreach( $wp_version_keys as $key => $wp_version ){
					$wpdb->update( $suggesation_bank, array( $key => $wp_version ), array( 'param_key' => 'version' ) );
				}
			}
		}
	}

}