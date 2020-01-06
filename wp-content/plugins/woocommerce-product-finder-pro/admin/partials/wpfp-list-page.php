<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$file_dir_path = 'header/plugin-header.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	include_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}

$current_page            = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
$query_parameter_orderby = filter_input( INPUT_GET, 'orderby', FILTER_SANITIZE_STRING );
$query_parameter_orderby = isset( $query_parameter_orderby ) && ! empty( $query_parameter_orderby ) ? $query_parameter_orderby : 'date';
$order_type              = filter_input( INPUT_GET, 'order', FILTER_SANITIZE_STRING );
$order_type              = isset( $order_type ) && ! empty( $order_type ) ? $order_type : 'DESC';
if ( empty( $current_page ) && 0 === $current_page ) {
	$current_page = 1;
}
$current_posts_per_page = apply_filters( 'size_chart_products_listing_per_page', 10 );

$wizard_query_args = array(
	'post_type'      => self::wpfp_post_type,
	'posts_per_page' => $current_posts_per_page,
	'paged'          => $current_page,
	'order'          => $order_type,
	'orderby'        => $query_parameter_orderby,
	'post_status'    => array(
		'publish',
		'draft'
	),
);
$wp_wizard_query   = new WP_Query( $wizard_query_args );
?>
    <div class="wpfp-main-table">
        <div class="product_header_title">
            <h2>
				<?php esc_html_e( 'Manage Wizards', 'woo-product-finder' ); ?>
                <a class="add-new-btn" href="<?php echo esc_url( $this->get_wpfp_url( array( 'page' => 'wpfp-add-wizard' ) ) ); ?>">
					<?php esc_html_e( 'Add New Wizard', 'woo-product-finder' ); ?>
                </a>
                <a id="detete_all_selected_wizard" class="detete_all_select_wizard_list button-primary" href="javascript:void(0);" disabled="disabled">
					<?php esc_html_e( 'Delete ( Selected )', 'woo-product-finder' ); ?>
                </a>
            </h2>
        </div>
		<?php if ( $wp_wizard_query->have_posts() ) {
			$orderby_name_argument        = array(
				'page'    => 'wpfp-list',
				'orderby' => 'title',
				'order'   => ( 'ASC' === $order_type ) ? 'DESC' : 'ASC'
			);
			$orderby_ID_argument          = array(
				'page'    => 'wpfp-list',
				'orderby' => 'ID',
				'order'   => ( 'ASC' === $order_type ) ? 'DESC' : 'ASC'
			);
			$orderby_post_status_argument = array(
				'page'    => 'wpfp-list',
				'orderby' => 'post_status',
				'order'   => ( 'ASC' === $order_type ) ? 'DESC' : 'ASC'
			);

			if ( 0 !== $current_page ) {
				$orderby_name_argument        = wp_parse_args( $orderby_name_argument, array( 'paged' => $current_page ) );
				$orderby_ID_argument          = wp_parse_args( $orderby_ID_argument, array( 'paged' => $current_page ) );
				$orderby_post_status_argument = wp_parse_args( $orderby_post_status_argument, array( 'paged' => $current_page ) );
			}

			$orderby_name_url        = $this->get_wpfp_url( $orderby_name_argument );
			$orderby_ID_url          = $this->get_wpfp_url( $orderby_ID_argument );
			$orderby_post_status_url = $this->get_wpfp_url( $orderby_post_status_argument );

			?>
            <form name="wpfp-wizard-list-form" id="wpfp-wizard-list-form" class="wpfp-wizard-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">
				<?php wp_nonce_field( 'wpfp_wizard_list_nonce', 'wpfp_nonce' ); ?>
                <input type="hidden" name="action" value="wpfp_wizard_list">
                <table id="wizard-listing" class="table-outer form-table all-table-listing tablesorter">
                    <thead>
                    <tr class="wpfp-head">
                        <th>
                            <label for="chk_all_wizard">
                                <input type="checkbox" name="check_all" class="chk_all_wizard_class" id="chk_all_wizard">
                            </label>
                        </th>
                        <th>
                            <a href="<?php echo esc_url( $orderby_name_url ); ?>">
								<?php esc_html_e( 'Name', 'woo-product-finder' ); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php echo esc_url( $orderby_ID_url ); ?>">
								<?php esc_html_e( 'Shortcode', 'woo-product-finder' ); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php echo esc_url( $orderby_post_status_url ); ?>">
								<?php esc_html_e( 'Status', 'woo-product-finder' ); ?>
                            </a>
                        </th>
                        <th><?php esc_html_e( 'Action', 'woo-product-finder' ); ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					while ( $wp_wizard_query->have_posts() ) {
						$wp_wizard_query->the_post();
						$wizard_id          = get_the_ID();
						$wizard_title       = get_the_title();
						$wizard_shortcode   = $this->wpfp_get_wizard_shortcode( $wizard_id );
						$wizard_status      = $this->filter_wizard_status_value( get_post_status(), false );
						$wizard_edit_url    = $this->get_edit_wizard_url( $wizard_id, $current_page );
						$wizard_setting_url = $this->get_setting_wizard_url( $wizard_id, $current_page );
						$wizard_delete_url  = $this->get_delete_wizard_url( $wizard_id, $current_page, true );
						?>
                        <tr id="wizard_row_<?php echo esc_attr( $wizard_id ); ?>">
                            <td>
                                <label>
                                    <input type="checkbox" class="chk_single_wizard" name="wpfp_single_wizard_checkbox[]" value="<?php echo esc_attr( $wizard_id ); ?>">
                                </label>
                            </td>
                            <td>
                                <a href="<?php echo esc_url( $wizard_edit_url ); ?>">
									<?php echo esc_html( $wizard_title ); ?>
                                </a>
                            </td>
                            <td>
                                <label for="wpfp-shortcode">
                                    <input type="text" id="wpfp-shortcode" onfocus="this.select();" readonly="readonly" class="large-text code" value="<?php echo esc_attr( $wizard_shortcode ); ?>">
                                </label>
                            </td>
                            <td>
								<?php echo ( ! empty( $wizard_status ) && 1 === $wizard_status ) ? '<span class="active-status">' . esc_html_e( 'Enabled', 'woo-product-finder' ) . '</span>' : '<span class="inactive-status">' . esc_html_e( 'Disabled', 'woo-product-finder' ) . '</span>'; ?>
                            </td>
                            <td>
                                <a class="button-primary" href="<?php echo esc_url( $wizard_edit_url ); ?>">
									<?php esc_html_e( 'Edit', 'woo-product-finder' ); ?>
                                </a>
                                <a class="button-primary delete_single_selected_wizard" href="<?php echo esc_url( $wizard_delete_url ); ?>" id="delete_single_selected_wizard_<?php echo esc_attr( $wizard_id ); ?>" data-attr_name="<?php echo esc_attr( $wizard_title ); ?>">
									<?php esc_html_e( 'Delete', 'woo-product-finder' ); ?>
                                </a>
								<?php
								if ( wpfp_fs()->is__premium_only() ) {
									if ( wpfp_fs()->can_use_premium_code() ) {
										?>
                                        <a class="button-primary setting_single_selected_wizard" href="<?php echo esc_url( $wizard_setting_url ); ?>" id="setting_single_selected_wizard_<?php echo esc_attr( $wizard_id ); ?>" data-attr_name="<?php echo esc_attr( $wizard_title ); ?>">
											<?php esc_html_e( 'Setting', 'woo-product-finder' ); ?>
                                        </a>
										<?php
									} else {
										?>
                                        <a class="button-primary wpfp-list-button is_disabled" disabled>
											<?php esc_html_e( 'Setting', 'woo-product-finder' ); ?>
                                        </a>
										<?php
									}
								} else {
									?>
                                    <a class="button-primary wpfp-list-button is_disabled" disabled>
										<?php esc_html_e( 'Setting', 'woo-product-finder' ); ?>
                                    </a>
									<?php
								}
								?>

                            </td>
                        </tr>
						<?php
					}
					wp_reset_postdata();
					?>
                    </tbody>
                </table>
                <nav class="navigation paging-navigation" role="navigation">
                    <div class="pagination loop-pagination">
						<?php
						$allow_html = array(
							'span' => array(
								'class'        => array(),
								'aria-current' => array(),
							),
							'a'    => array(
								'class' => array(),
								'href'  => array()
							)

						);
						echo wp_kses(
							paginate_links(
								array(
									'base'    => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
									'format'  => '?paged=%#%',
									'current' => max( 1, $current_page ),
									'total'   => $wp_wizard_query->max_num_pages,
								)
							),
							$allow_html );
						?>
                    </div>
                </nav>
            </form>
			<?php
		} else {
			?>
            <table id="wizard-listing" class="table-outer form-table all-table-listing tablesorter">
                <thead>
                <tr class="wpfp-head">
                    <th><input type="checkbox" name="check_all"></th>
                    <th><?php esc_html_e( 'Name', 'woo-product-finder' ); ?></th>
                    <th><?php esc_html_e( 'Shortcode', 'woo-product-finder' ); ?></th>
                    <th><?php esc_html_e( 'Status', 'woo-product-finder' ); ?></th>
                    <th><?php esc_html_e( 'Action', 'woo-product-finder' ); ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="5">
						<?php esc_html_e( 'No List Available', 'woo-product-finder' ); ?>
                    </td>
                </tr>
                </tbody>
            </table>
			<?php
		}
		$is_disabled = ' is_disabled_section';
		if ( wpfp_fs()->is__premium_only() ) {
			if ( wpfp_fs()->can_use_premium_code() ) {
				$is_disabled = '';
			}
		}
		?>

        <div class="wpfpro-mastersettings<?php echo esc_attr($is_disabled); ?>">
            <div class="mastersettings-title">
                <h2><?php esc_html_e( 'Master Settings', 'woo-product-finder' ); ?></h2>
            </div>
            <div class="wpfp-master-form<?php echo esc_attr($is_disabled); ?>">
            <form name="wpfp-master-setting-form" id="wpfp-master-setting-form" class="wpfp-wizard-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">
				<?php wp_nonce_field( 'wpfp_master_setting_nonce', 'wpfp_nonce' ); ?>
                <input type="hidden" name="action" value="wpfp_master_setting_wizard">

                <table class="table-mastersettings table-outer">
                    <tbody>
                    <tr>
                        <td class="table-whattodo">
                            <b><?php esc_html_e( 'Want to display product finder result at last?', 'woo-product-finder' ); ?></b></td>
                        <td>
                            <label for="result_display_mode">
								<?php
								if ( wpfp_fs()->is__premium_only() ) {
									if ( wpfp_fs()->can_use_premium_code() ) {
										$wpfp_result_display_mode = get_option( 'wpfp_result_display_mode' );
										?>
                                        <select name="result_display_mode" id="result_display_mode" data-minimum-results-for-search="<?php esc_html_e( 'Infinity', 'woo-product-finder' ); ?>">
                                            <option value="no" <?php selected( $wpfp_result_display_mode, 'no', true ); ?>><?php esc_html_e( 'No', 'woo-product-finder' ); ?></option>
                                            <option value="yes" <?php selected( $wpfp_result_display_mode, 'yes', true ); ?>><?php esc_html_e( 'Yes', 'woo-product-finder' ); ?></option>
                                        </select>
										<?php
									} else {
										?>
                                        <select class="wpfp-master is-disabled" disabled>
                                            <option value="no"><?php esc_html_e( 'No', 'woo-product-finder' ); ?></option>
                                            <option value="yes"><?php esc_html_e( 'Yes', 'woo-product-finder' ); ?></option>
                                        </select>
										<?php
									}
								} else {
									?>
                                    <select class="wpfp-master is-disabled" disabled>
                                        <option value="no"><?php esc_html_e( 'No', 'woo-product-finder' ); ?></option>
                                        <option value="yes"><?php esc_html_e( 'Yes', 'woo-product-finder' ); ?></option>
                                    </select>
									<?php
								}
								?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
							<?php
							if ( wpfp_fs()->is__premium_only() ) {
								if ( wpfp_fs()->can_use_premium_code() ) {
									submit_button( __( 'Save Master Settings', 'woo-product-finder' ), 'button-primary', 'save_master_settings', false );
								} else {
									?>
                                    <input type="button" class="button-primary wpfp-list-button is_disabled" disabled value="<?php esc_html_e( 'Save Master Settings', 'woo-product-finder' ); ?>">
									<?php
								}
							} else {
								?>
                                <input type="button" class="button-primary wpfp-list-button is_disabled" disabled value="<?php esc_html_e( 'Save Master Settings', 'woo-product-finder' ); ?>">
								<?php
							}
							?>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>

<?php
$file_dir_path = 'header/plugin-sidebar.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}