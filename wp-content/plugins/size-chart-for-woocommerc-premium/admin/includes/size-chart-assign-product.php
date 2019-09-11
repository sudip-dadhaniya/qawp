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
// Use get_post to retrieve an existing value of chart 

$meta_query_args = array(
	'post_type'              => 'product',
	'order'                  => 'DESC',
	'no_found_rows'          => true,
	'update_post_term_cache' => false,
	'fields'                 => 'ids',
	'meta_key'               => 'prod-chart', // WPCS: slow query ok.
	'orderby'                => 'meta_value',
	'meta_query'             => array( // WPCS: slow query ok.
		array(
			'key'   => 'prod-chart',
			'value' => $post->ID
		)
	)
);
$wp_posts_query  = new WP_Query( $meta_query_args );
?>
    <div id="size-chart-meta-fields">
        <div id="assign-product">
            <div class="assign-item">
                <ul>
					<?php
					if ( $wp_posts_query->have_posts() ) {
						while ( $wp_posts_query->have_posts() ) {
							$wp_posts_query->the_post();
							?>
                            <li>
                                <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>"><?php esc_html_e( get_the_title( get_the_ID() ), 'size-chart-for-woocommerce' ); ?></a>
                            </li>
							<?php
						}
					} else {
						esc_html_e( 'No Product Assign', 'size-chart-for-woocommerce' );
					}
					?>
                </ul>
            </div>
        </div>
    </div>
<?php wp_reset_postdata(); ?>