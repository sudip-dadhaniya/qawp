<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Speedometerv3
 * @subpackage Speedometerv3/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Speedometerv3
 * @subpackage Speedometerv3/admin
 * @author     Multidots <multidots@multidots.com>
 */
class Speedometerv3_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Speedometerv3_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Speedometerv3_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/speedometerv3-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'sm-fontawesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Speedometerv3_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Speedometerv3_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/speedometerv3-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'settingAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'pluginSetting' ) ));
		wp_enqueue_script( 'sm-bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/speedometerv3-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register Plugin menu to display in admin side panel
	 */
	public function register_menu() {
		add_menu_page(
			'Speedometer',
			'Speedometer',
			'manage_options',
			'speedometer',
			array( $this, 'speedometer_form_page_handler' )
		);
		add_submenu_page(
			'speedometer',
			'Setting',
			'Setting',
			'manage_options',
			'speedometer-setting',
			array( $this, 'speedometer_setting' )
		);
		// add_submenu_page(
		// 	'speedometer',
		// 	'Scan',
		// 	'Scan',
		// 	'manage_options',
		// 	'speedometer-scan',
		// 	array( $this, 'speedometer_scan' )
		// );
	}

	public function speedometer_form_page_handler() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/speedometerv3-admin-display.php';
	}

	public function speedometer_setting() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/speedometerv3-admin-setting.php';
	}

	public function speedometer_scan() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/speedometerv3-admin-scan.php';
	}

	public function sm_notice( $message, $class ) { ?>
		<div class="sm-alert is-dismissible <?php echo $class; ?>">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>  
			<?php _e( $message, SPEEDOMETERV3_TEXT_DOMAIN ); ?>
		</div>
	<?php }

	public function sm_rest_environment() {
		register_rest_route( 'speedometer/v3', '/environment', array(
			'methods'  => WP_REST_Server::READABLE,
			'callback' => array( $this, 'sm_environment_reap_api' )
		) );
	}

	public function sm_environment_reap_api( $request ) {

		$sm_posts_environment = new sm_environment();

		$response = new WP_REST_Response( $sm_posts_environment );
		$response->set_status( 200 );

		return $response;
	}

	public function sm_sync_update( $token, $status ){
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
		return $rows_affected;
	}

	public function sm_data_save( $post, $extra_param ) {
		global $wpdb;
		if ( empty( $post ) ) {
			return false;
		}
		
		if ( $extra_param === 'scan' ) {

			$table_nm = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'scan_log';
			$table_nm_configuration = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration';

			if( is_array( $post ) ) {
				$post = json_encode( $post );
			} else {
				$post = (array) $post;
				$post = json_encode( $post );
			}

			$wpdb->query( $wpdb->prepare(
				"INSERT INTO $table_nm ( data, other_details, is_send, created_date, updated_date ) VALUES (  %s, %s, %s, %s, %s  )",
				$post,
				trim( sanitize_text_field( '' ) ),
				trim( '' ),
				date( "Y-m-d H:i:s" ),
				date( "Y-m-d H:i:s" )
			) );
			return $wpdb->insert_id;

		} elseif ( $extra_param === 'sync' ) {

			$table_nm_scan = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'scan_log';
			$table_nm_sync = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'sync_log';
			$table_nm_configuration = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration';

			$get_last_scan_log      = $wpdb->get_results( "SELECT * FROM $table_nm_scan ORDER BY id DESC LIMIT 1" );
			if ( !empty( $get_last_scan_log ) ) {
				$scan_data = $get_last_scan_log[0]->data;
				$wpdb->query( $wpdb->prepare(
					"INSERT INTO $table_nm_sync ( sync_date, sync_data, other_details, status ) VALUES (  %s, %s, %s, %s  )",
					date( "Y-m-d H:i:s" ),
					$scan_data,
					trim( sanitize_text_field( '' ) ),
					trim( '' )
				) );

				$get_tbl_config = $wpdb->get_results("SELECT * FROM $table_nm_configuration ORDER BY id DESC LIMIT 1");

				$scan_data = json_decode( $scan_data );
				$sentData =  array(
					'mercury_token' => $get_tbl_config[0]->mercury_token,
					'data' => (array)$scan_data
				);
				$sync_response = self::sm_remote_api( SPEEDOMETERV3_SITEAPI_URL.'mercuryData', $sentData );
			}

		} else {

		}
//		$latest_url = esc_url( admin_url( '/admin.php?page=speedometer' ) );
//		$newUrl     = html_entity_decode( $latest_url );
//		wp_safe_redirect( $newUrl );
//		exit;
	}

	//insert the scan_display table 
	public function sm_scan_display( $id, $result ){
		global $wpdb;
		if ( !is_array( $result ) || empty( $id ) ) {
			return false;
		}
		$scan_table = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_scan_display';
		$json_data = json_encode( $result );
		$wpdb->insert( $scan_table, array(
			'scan_id' => $id,
			'scan_details' => $json_data
		));
		// foreach( $result as $result_data ){
		// 	$wpdb->insert( $scan_table, $result_data );
		// }
	}

	public function sm_remote_api ( $site_url, $data ) {
		$args = array(
			'headers' => array(
				'Content-Type'   => 'application/json',
			),
			'body'      => json_encode($data),
			'method'    => 'POST'
		);
		$response = wp_remote_post( $site_url, $args );

		// Check the response code
		$response_code       = wp_remote_retrieve_response_code( $response );
		$response_message = wp_remote_retrieve_response_message( $response );

		if ( 200 != $response_code ) {
			$message = 'Something went to wrong. Please contact to administer';
			$this->sm_notice( $message, 'error');
		} elseif ( 200 === $response_code ) {
			$message = 'Congratulations! Your data is sync.';
			$this->sm_notice( $message, 'success');
		}
	}
}
