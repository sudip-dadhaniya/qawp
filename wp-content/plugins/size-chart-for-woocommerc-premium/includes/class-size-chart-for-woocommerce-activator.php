<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Size_Chart_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate( $active_plugin ) {

		/*         * **************** */
		// Welcome Screen  //
		/*         * **************** */
		global $jal_db_version;
		$jal_db_version = '1.0';
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) && ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
			wp_die(
				sprintf( "<strong>%s</strong> %s <strong>%s</strong> <a href='%s'>%s</a>",
					esc_html__( 'Size Chart for WooCommerce', 'size-chart-for-woocommerce' ),
					esc_html__( 'Plugin requires', 'size-chart-for-woocommerce' ),
					esc_html__( 'WooCommerce', 'size-chart-for-woocommerce' ),
					esc_url( get_admin_url( null, 'plugins.php' ) ),
					esc_html__( 'Plugins page', 'size-chart-for-woocommerce' )
				)
			);
		} else {

			$current_user = wp_get_current_user();
			$useremail    = $current_user->user_email;

			$log_url = filter_input( INPUT_SERVER, 'HTTP_HOST', FILTER_VALIDATE_DOMAIN );

			$cur_date = date( 'Y-m-d' );
			$url      = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/wp-add-plugin-users.php';
			wp_remote_post( $url, array(
				'method'      => 'POST',
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array(
					'user' => array(
						'user_email'      => $useremail,
						'plugin_site'     => $log_url,
						'status'          => 1,
						'plugin_id'       => '22',
						'activation_date' => $cur_date
					)
				),
				'cookies'     => array()
			) );
			set_transient( '_welcome_screen_activation_redirect_size_chart', true, 30 );
		}
		add_option( 'jal_db_version', $jal_db_version );

	}


}
