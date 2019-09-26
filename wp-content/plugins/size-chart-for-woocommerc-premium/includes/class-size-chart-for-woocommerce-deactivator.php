<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/includes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Size_Chart_For_Woocommerce_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'default_size_chart' );
		$args             = array(
			'post_type'              => 'size-chart',
			'numberposts'            => - 1,
			'no_found_rows'          => true,
			'fields'                 => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);
		$size_chart_query = new WP_Query( $args );
		$i                = 0;
		if ( $size_chart_query->have_posts() ) {
			foreach ( $size_chart_query->posts as $size_chart ) {
				$i ++;
				wp_delete_post( $size_chart->ID, true );
				delete_post_meta( $size_chart->ID, 'label' );
				delete_post_meta( $size_chart->ID, 'position' );
				delete_post_meta( $size_chart->ID, 'post_status' );
				delete_post_meta( $size_chart->ID, 'chart-table' );
			}
		}
	}

}
