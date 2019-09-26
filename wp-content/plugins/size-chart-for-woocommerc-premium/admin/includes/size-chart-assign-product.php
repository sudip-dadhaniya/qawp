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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$current_paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$current_size_chart_id  = get_the_ID();
$current_posts_per_page = apply_filters( 'size_chart_products_listing_per_page', 10 );

$meta_query_args = array(
	'post_type'              => 'product',
	'order'                  => 'DESC',
	'posts_per_page'         => $current_posts_per_page,
	'update_post_term_cache' => false,
	'fields'                 => 'ids',
	'paged'                  => $current_paged,
	'orderby'                => 'meta_value',
	'meta_query'             => array(
		array(
			'key'   => 'prod-chart',
			'value' => $current_size_chart_id
		)
	)
);
$wp_posts_query  = new WP_Query( $meta_query_args );
$post_type_name  = 'size-chart';
?>
    <div class="<?php esc_attr_e( $post_type_name ); ?>-accordion-section-content">
        <div id="<?php esc_attr_e( $post_type_name ); ?>-menu-settings-column">

            <div id="posttype-<?php esc_attr_e( $post_type_name ); ?>" class="posttypediv">
                <ul id="posttype-<?php esc_attr_e( $post_type_name ); ?>-tabs" class="posttype-tabs add-menu-item-tabs">
                    <li class="tabs">
                        <a class="nav-tab-link" data-type="tabs-panel-posttype-<?php esc_attr_e( $post_type_name ); ?>-all" href="#tabs-panel-posttype-<?php esc_attr_e( $post_type_name ); ?>-all">
                            <span class="spinner"></span><?php esc_html_e( 'Products' ); ?>
                        </a>
                    </li>
                    <li>
                        <a class="nav-tab-link" data-type="tabs-panel-posttype-<?php esc_attr_e( $post_type_name ); ?>-search" href="#tabs-panel-posttype-<?php esc_attr_e( $post_type_name ); ?>-search">
							<?php esc_html_e( 'Search' ); ?>
                        </a>
                    </li>
                </ul><!-- .posttype-tabs -->
                <div id="tabs-panel-posttype-<?php esc_attr_e( $post_type_name ); ?>-all" class="tabs-panel tabs-panel-active">
                    <ul id="<?php esc_attr_e( $post_type_name ); ?>-checklist-all" class="<?php esc_attr_e( $post_type_name ); ?>-checklist form-no-clear">
						<?php
						if ( ! empty( $wp_posts_query ) && $wp_posts_query->have_posts() ) {
							foreach ( $wp_posts_query->posts as $wp_product_id ) {
								printf(
									"<li><a href='%s'>%s</a></li>",
									esc_url( get_edit_post_link( $wp_product_id ) ),
									esc_html__( get_the_title( $wp_product_id ), 'size-chart-for-woocommerce' )
								);
							}
						} else {
							esc_html_e( 'No Product Assign', 'size-chart-for-woocommerce' );
						}
						?>
                    </ul>
					<?php size_chart_pagination_html( $wp_posts_query, $current_size_chart_id, $current_posts_per_page ); ?>
                </div>

                <div id="tabs-panel-posttype-<?php esc_attr_e( $post_type_name ); ?>-search" class="tabs-panel tabs-panel-inactive">
                    <p class="quick-search-wrap">
                        <label for="quick-search-posttype-<?php esc_attr_e( $post_type_name ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search' ); ?></label>
                        <input type="search" class="quick-search" name="quick-search-posttype-<?php esc_attr_e( $post_type_name ); ?>" id="quick-search-posttype-<?php esc_attr_e( $post_type_name ); ?>" data-post_type="product" data-nonce="<?php esc_attr_e( wp_create_nonce( 'size_chart_quick_search_nonoce' ) ); ?>"/>
                        <span class="spinner"></span>
                    </p>
                    <ul id="<?php esc_attr_e( $post_type_name ); ?>-search-checklist" data-wp-lists="list:" class="categorychecklist form-no-clear"></ul>
                </div><!-- /.tabs-panel -->
            </div>
        </div>
    </div>

<?php wp_reset_postdata(); ?>