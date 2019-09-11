<?php
/**
 * Provide a admin area form view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    size-chart-for-woocommerce
 * @subpackage size-chart-for-woocommerce/admin/includes
 */
global $wp_query;
// Add an nonce field so we can check for it later.
wp_nonce_field( 'size_chart_select_custom_box', 'size_chart_select_custom_box' );

// Use get_post_meta to retrieve an existing value of chart 1 from the database.
$chart_id = get_post_meta( $post->ID, 'prod-chart', true );

$args                = array(
	'posts_per_page'         => - 1,
	'orderby'                => 'date',
	'order'                  => 'DESC',
	'post_type'              => 'size-chart',
	'post_status'            => 'publish',
	'no_found_rows'          => true,
	'update_post_meta_cache' => false,
	'update_post_term_cache' => false,
);
$wp_size_chart_query = new WP_Query( $args );
?>
<div id="size-chart-meta-fields">
    <div id="field">
        <div class="field-item">
            <select name="prod-chart" id="prod-chart">
                <option value=""><?php esc_html_e( 'Select Chart', 'size-chart-for-woocommerce' ); ?></option>
				<?php
				if ( $wp_size_chart_query->have_posts() ) {
					foreach ( $wp_size_chart_query->posts as $wp_size_chart_post ) {
						?>
                        <option value="<?php esc_attr_e( $wp_size_chart_post->ID ); ?>" <?php selected( $chart_id, $wp_size_chart_post->ID, true ); ?> >
							<?php esc_html_e( $wp_size_chart_post->post_title, 'size-chart-for-woocommerce' ); ?>
                        </option>
						<?php
					}
				}
				?>
            </select>
        </div>
    </div>
</div>
