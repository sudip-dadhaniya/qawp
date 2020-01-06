<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$file_dir_path = 'header/plugin-header.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	include_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}
$get_page_name = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
$get_action    = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
$wizard_id     = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_STRING );
$wpfp_nonce    = filter_input( INPUT_GET, 'wpfp_nonce', FILTER_SANITIZE_STRING );

if ( self::wpfp_post_type !== get_post_type( $wizard_id ) || ! wp_verify_nonce( $wpfp_nonce, 'wpfp_setting_wizard' ) ) {
	wp_safe_redirect(
		html_entity_decode(
			esc_url(
				add_query_arg( array(
					'page' => 'wpfp-list',
				), admin_url( 'admin.php' ) )
			)
		)
	);
	exit;
}

$wizard_id                          = isset( $wizard_id ) ? $wizard_id : 0;
$this->wpfp_get_wizard_setting_data = wpfp_get_wizard_setting_data( $wizard_id );
$wizard_edit_url                    = $this->get_edit_wizard_url( $wizard_id );
?>
    <div class="wpfp-main-table">
        <h2>
            <span class="wpfp-setting-header">
                <?php esc_html_e( 'Wizard Setting For ', 'woo-product-finder' ); ?>
                <a href="<?php echo esc_url( $wizard_edit_url ); ?>" title="<?php esc_attr_e( 'Edit current Wizard.', 'woo-product-finder' ); ?>">
                    <?php echo esc_html( get_the_title( $wizard_id ) ); ?>
                </a>
            </span>
            <a class="wpfp-btn back-button" id="back_button" href="<?php echo esc_url( admin_url( 'admin.php?page=wpfp-list' ) ); ?>">
				<?php esc_html_e( 'Back to wizard list', 'woo-product-finder' ); ?>
            </a>
        </h2>
        <form name="wpfp-wizard-setting-form" id="wpfp-wizard-setting-form" class="wpfp-wizard-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">
			<?php wp_nonce_field( 'wpfp_setting_nonce', 'wpfp_nonce' ); ?>
            <input type="hidden" name="action" value="wpfp_setting_wizard">
            <input type="hidden" name="wizard_post_id" id="wizard_post_id" value="<?php echo esc_attr( $wizard_id ); ?>">
            <input type="hidden" name="post_type" value="<?php echo esc_attr( self::wpfp_post_type ); ?>">
            <table class="form-table table-outer product-fee-table">
                <tbody>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="perfect_match_title">
							<?php esc_html_e( 'Top Product( s )', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[perfect_match_title]" id="perfect_match_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['perfect_match_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Top Product( s )', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'Complete matched product title based on your requirements.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="recent_match_title">
							<?php esc_html_e( 'Products meeting most of your requirements', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[recent_match_title]" id="recent_match_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['recent_match_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Products meeting most of your requirements', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'Recently matched product title based on your requirements.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="show_attribute">
							<?php esc_html_e( 'Display Attribute Per Product', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="number" name="wpfp_wizard_setting[show_attribute]" id="show_attribute" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['show_attribute'] ); ?>" step="1" min="1" class="text-class" placeholder="<?php esc_attr_e( 'Display Attribute', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'How many attribute display per product?', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="backend_per_page_limit">
							<?php esc_html_e( 'Products Per Page', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="number" name="wpfp_wizard_setting[backend_per_page_limit]" id="backend_per_page_limit" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['backend_per_page_limit'] ); ?>" min="1" class="text-class" placeholder="<?php esc_attr_e( 'Products Per Page', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'How many product display per page?', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="option_row_item">
							<?php esc_html_e( 'How many options item display in a one row?', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <select name="wpfp_wizard_setting[option_row_item]" id="option_row_item">
                            <option value="1" <?php selected( $this->wpfp_get_wizard_setting_data['option_row_item'], 1, true ); ?>><?php esc_html_e( '1', 'woo-product-finder' ); ?></option>
                            <option value="2" <?php selected( $this->wpfp_get_wizard_setting_data['option_row_item'], 2, true ); ?>><?php esc_html_e( '2', 'woo-product-finder' ); ?></option>
                            <option value="3" <?php selected( $this->wpfp_get_wizard_setting_data['option_row_item'], 3, true ); ?>><?php esc_html_e( '3', 'woo-product-finder' ); ?></option>
                            <option value="4" <?php selected( $this->wpfp_get_wizard_setting_data['option_row_item'], 4, true ); ?>><?php esc_html_e( '4', 'woo-product-finder' ); ?></option>
                            <option value="5" <?php selected( $this->wpfp_get_wizard_setting_data['option_row_item'], 5, true ); ?>><?php esc_html_e( '5', 'woo-product-finder' ); ?></option>
                            <option value="6" <?php selected( $this->wpfp_get_wizard_setting_data['option_row_item'], 6, true ); ?>><?php esc_html_e( '6', 'woo-product-finder' ); ?></option>
                        </select>
						<?php wpfp_help_tip( __( 'Display options in a one row. (EX: Two Option name display in a one row).', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr class="text_color">
                    <th class="titledesc" scope="row">
                        <label for="text_color_wizard_title">
							<?php esc_html_e( 'Text color for wizard title', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[text_color_wizard_title]" id="text_color_wizard_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['text_color_wizard_title'] ); ?>" data-default-color="#ffffff" class="wp-color-picker-field"/>
						<?php wpfp_help_tip( __( 'Text color is display on wizard title.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="questions_background_image_id">
							<?php esc_html_e( 'Background Image For Question', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip question_background_image_section">
                        <div class="wpfp-uploader-wrapper">
                            <a class="option_single_upload_file button" id="question_background_uploader_image_id" data-uploader-title="Select File" data-uploader-button-text="Include File" data-uploadname="question_background_upload_file">
								<?php esc_html_e( 'Upload File', 'woo-product-finder' ); ?>
                            </a>
							<?php if ( isset( $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ) && ! empty( $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ) && 0 !== $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ) { ?>
                                <a class="option_single_remove_file button" id="question_background_remove_image_id" data-uploadname="question_background_upload_file">
									<?php esc_html_e( 'Remove File', 'woo-product-finder' ); ?>
                                </a>
							<?php } ?>
							<?php wpfp_help_tip( __( 'Upload Background image here which is display in front side background of all question list.', 'woo-product-finder' ) ); ?>
                        </div>
                        <div class="wpfp-image-preview" id="wpfp-image-preview">
							<?php if ( isset( $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ) && ! empty( $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ) && 0 !== $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ) { ?>
								<?php echo wp_get_attachment_image( $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ); ?>
                                <input type="hidden" name="wpfp_wizard_setting[questions_background_image_id]" id="questions_background_image_id" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['questions_background_image_id'] ); ?>">
							<?php } ?>
                        </div>
                    </td>
                </tr>
                <tr class="background_color">
                    <th class="titledesc" scope="row">
                        <label for="background_color">
							<?php esc_html_e( 'Background color', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[background_color]" id="background_color" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['background_color'] ); ?>" data-default-color="#434344" class="wp-color-picker-field"/>
						<?php wpfp_help_tip( __( 'Background color is display on specific button,Top Product Title,Products meeting most of your requirements title and pagination.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr class="text_color">
                    <th class="titledesc" scope="row">
                        <label for="text_color">
							<?php esc_html_e( 'Text color', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[text_color]" id="text_color" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['text_color'] ); ?>" data-default-color="#ffffff" class="wp-color-picker-field"/>
						<?php wpfp_help_tip( __( 'Text color is display on specific button,Top Product Title,Products meeting most of your requirements title and pagination text.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr class="background_next_pre_button_color">
                    <th class="titledesc" scope="row">
                        <label for="background_next_pre_button_color">
							<?php esc_html_e( 'Background color for next and prev button', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[background_next_pre_button_color]" id="background_next_pre_button_color" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['background_next_pre_button_color'] ); ?>" data-default-color="#434344" class="wp-color-picker-field"/>
						<?php wpfp_help_tip( __( 'Background color is display on next and prev button.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr class="text_np_button_color">
                    <th class="titledesc" scope="row">
                        <label for="text_next_pre_button_color">
							<?php esc_html_e( 'Text color for next and prev button', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[text_next_pre_button_color]" id="text_next_pre_button_color" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['text_next_pre_button_color'] ); ?>" data-default-color="#ffffff" class="wp-color-picker-field"/>
						<?php wpfp_help_tip( __( 'Text color is display on next and prev button.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr class="background_color">
                    <th class="titledesc" scope="row">
                        <label for="background_color_for_options">
							<?php esc_html_e( 'Background color for options', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[background_color_for_options]" id="background_color_for_options" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['background_color_for_options'] ); ?>" data-default-color="#ffffff" class="wp-color-picker-field"/>
						<?php wpfp_help_tip( __( 'Background color is display on option title.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr class="text_color">
                    <th class="titledesc" scope="row">
                        <label for="text_color_for_options">
							<?php esc_html_e( 'Text color for options', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[text_color_for_options]" id="text_color_for_options" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['text_color_for_options'] ); ?>" data-default-color="#000000" class="wp-color-picker-field"/>
						<?php wpfp_help_tip( __( 'Text color is display on option title.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="reload_title">
							<?php esc_html_e( 'Reload Title', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[reload_title]" id="reload_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['reload_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Reload Title', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'When you restart the filtering for finder using reload button then this text will display there.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="next_title">
							<?php esc_html_e( 'Next', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[next_title]" id="next_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['next_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Next Title', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'You can add your own Next button text which display at front on pagination.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>

                <tr>
                    <th class="titledesc" scope="row">
                        <label for="back_title">
							<?php esc_html_e( 'Back', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[back_title]" id="back_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['back_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Back Title', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'You can add your own Back button text which display at front on pagination.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="show_result_title">
							<?php esc_html_e( 'Show Result', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[show_result_title]" id="show_result_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['show_result_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Show Result Title', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'You can add your own Show result button text which display at front on pagination.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="restart_title">
							<?php esc_html_e( 'Restart', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[restart_title]" id="restart_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['restart_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Restart Title', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'You can add your own Restart button text which display at front on pagination.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="detail_title">
							<?php esc_html_e( 'Detail', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[detail_title]" id="detail_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['detail_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'Detail Title', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'You can add your own Product filtered detail link label at front side.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="total_count_title">
							<?php esc_html_e( 'Total Count Title', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wpfp_wizard_setting[total_count_title]" id="total_count_title" value="<?php echo esc_attr( $this->wpfp_get_wizard_setting_data['total_count_title'] ); ?>" class="text-class half_width" placeholder="<?php esc_attr_e( 'item(s)', 'woo-product-finder' ); ?>">
						<?php wpfp_help_tip( __( 'You can add your own Label for total count items after filter.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>

                </tbody>
            </table>
			<?php submit_button( 'Save Settings', 'button-primary', 'wizard_setting' ); ?>
        </form>
    </div>
<?php
$file_dir_path = 'header/plugin-sidebar.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}