<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$file_dir_path = 'header/plugin-header.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	include_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}
// Get methods.
$get_action    = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
$get_page_name = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
$wizard_id     = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_STRING );

$wizard_id = isset( $wizard_id ) ? $wizard_id : 0;

$wpfp_wizard_data = $this->wpfp_get_wizard_data( $wizard_id );

$wizard_id    = $wpfp_wizard_data['wizard_id'];
$wizard_title = $wpfp_wizard_data['wizard_title'];

$plugin_status             = 'is_disabled';
$question_type_action      = 'disabled';
$question_type_action_text = __( 'Checkbox (Pro version only)', 'woo-product-finder' );
if ( wpfp_fs()->is__premium_only() ) {
	if ( wpfp_fs()->can_use_premium_code() ) {
		$wizard_category           = $wpfp_wizard_data['wizard_category'];
		$plugin_status             = ' is_enabled';
		$question_type_action      = '';
		$question_type_action_text = __( 'Checkbox', 'woo-product-finder' );
	}
}
$wizard_shortcode   = $wpfp_wizard_data['wizard_shortcode'];
$wizard_status      = $wpfp_wizard_data['wizard_status'];
$wizard_button_text = $wpfp_wizard_data['wizard_button_text'];

$default_page = 'add';
if ( 'wpfp-edit-wizard' === $get_page_name ) {
	$default_page = 'edit';
}


?>
    <div class="wpfp-main-table">
        <h2>
            <span class="wpfp-edit-configuration-header">
			<?php esc_html_e( 'Wizard Configuration', 'woo-product-finder' ); ?>
            </span>
			<?php if ( 'edit' === $default_page ) { ?>
                <a class="wpfp-btn add-new-btn" href="<?php echo esc_url( admin_url( 'admin.php?page=wpfp-add-wizard' ) ); ?>">
					<?php esc_html_e( 'Add New Wizard', 'woo-product-finder' ); ?>
                </a>
				<?php
				if ( wpfp_fs()->is__premium_only() ) {
					if ( wpfp_fs()->can_use_premium_code() ) {
						?>
						<?php $wizard_setting_url = $this->get_setting_wizard_url( $wizard_id ); ?>
                        <a class="wpfp-btn setting-new-btn" href="<?php echo esc_url( $wizard_setting_url ); ?>">
							<?php esc_html_e( 'Setting', 'woo-product-finder' ); ?>
                        </a>
						<?php
					} else {
						?>
                        <a class="wpfp-btn <?php echo esc_attr( $plugin_status ); ?>" disabled>
							<?php esc_html_e( 'Setting', 'woo-product-finder' ); ?>
                        </a>
						<?php
					}
				} else {
					?>
                    <a class="wpfp-btn <?php echo esc_attr( $plugin_status ); ?>" disabled>
						<?php esc_html_e( 'Setting', 'woo-product-finder' ); ?>
                    </a>
					<?php
				}
				?>
			<?php } ?>
        </h2>
        <form name="wpfp-wizard-<?php echo esc_attr( $default_page ); ?>-form" id="wpfp-wizard-<?php echo esc_attr( $default_page ); ?>-form" class="wpfp-wizard-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">
			<?php wp_nonce_field( 'wpfp_' . esc_attr( $default_page ) . '_nonce', 'wpfp_nonce' ); ?>
			<?php
			$fields = array(
				'type'  => 'hidden',
				'name'  => 'action',
				'value' => 'wpfp_' . esc_attr( $default_page ) . '_wizard',
			);
			$this->wpfp_input_fields( $fields );
			$fields = array(
				'type'  => 'hidden',
				'name'  => 'wizard_post_id',
				'value' => esc_attr( $wizard_id ),
				'id'    => 'wizard_post_id'
			);
			$this->wpfp_input_fields( $fields );
			$fields = array(
				'type'  => 'hidden',
				'name'  => 'post_type',
				'value' => self::wpfp_post_type,
			);
			$this->wpfp_input_fields( $fields );
			?>

            <table class="form-table table-outer product-fee-table">
                <tbody>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="wizard_title">
							<?php esc_html_e( 'Wizard Title', 'woo-product-finder' ); ?>
                            <span class="required-star">*</span>
                        </label>
                    </th>
                    <td class="forminp mdtooltip wpfp-required " id="wpfp_wizard_title">
						<?php
						$fields = array(
							'type'        => 'text',
							'class'       => 'text-class half_width wpfp-field-required',
							'name'        => 'wizard_title',
							'id'          => 'wizard_title',
							'value'       => esc_attr( $wizard_title ),
							'placeholder' => esc_html__( 'Enter Wizard Title Here', 'woo-product-finder' )
						);
						$this->wpfp_input_fields( $fields );
						wpfp_help_tip( __( 'Text color is display on wizard title.', 'woo-product-finder' ) );
						?>
                    </td>
                </tr>
                <tr class="wizard_category_tr">
                    <th class="titledesc" scope="row">
                        <label for="wpfp-product-categories">
							<?php esc_html_e( 'Wizard Category', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip <?php echo esc_attr( $plugin_status ); ?>">
						<?php
						if ( wpfp_fs()->is__premium_only() ) {
							if ( wpfp_fs()->can_use_premium_code() ) {
								$wpfp_category = array();
								if ( class_exists( 'Woocommerce_Product_Finder_Pro_Admin' ) ) {
									$wpfp_object   = new Woocommerce_Product_Finder_Pro_Admin( $this->get_plugin_name(), $this->get_plugin_version() );
									$wpfp_category = $wpfp_object->wpfp_get_woocommerce_category();
								}
								?>
                                <select class="wpfp-product-categories" id="wpfp-product-categories" name="wizard_category[]" data-placeholder="<?php esc_html_e( 'Select Wizard Category', 'woo-product-finder' ); ?>" multiple="multiple">
									<?php
									if ( ! empty( $wpfp_category ) && is_array( $wpfp_category ) && array_filter( $wpfp_category ) ) {
										foreach ( $wpfp_category as $wpfp_cat_key => $wpfp_cat_values ) {
											?>
                                            <option value="<?php echo esc_attr( trim( $wpfp_cat_key ) ); ?>" <?php selected( true, in_array( $wpfp_cat_key, $wizard_category, true ), true ) ?>>
												<?php echo esc_attr( trim( $wpfp_cat_values ) ); ?>
                                            </option>
											<?php
										}
									}
									?>
                                </select>
								<?php
							} else {
								?>
                                <select class="wpfp-product-categories is-disable" id="wpfp-product-categories" name="wizard_category[]" data-placeholder="<?php esc_html_e( 'Select Wizard Category', 'woo-product-finder' ); ?>" disabled multiple="multiple">
                                    <option value="" selected><?php esc_html_e( 'Clothing', 'woo-product-finder' ); ?></option>
                                    <option value="" selected><?php esc_html_e( 'Accessories', 'woo-product-finder' ); ?></option>
                                </select>
								<?php
							}
						} else {
							?>
                            <select class="wpfp-product-categories is-disable" id="wpfp-product-categories" name="wizard_category[]" data-placeholder="<?php esc_html_e( 'Select Wizard Category', 'woo-product-finder' ); ?>" disabled multiple="multiple">
                                <option value="" selected><?php esc_html_e( 'Clothing', 'woo-product-finder' ); ?></option>
                                <option value="" selected><?php esc_html_e( 'Accessories', 'woo-product-finder' ); ?></option>
                            </select>
							<?php
						}
						?>
						<?php wpfp_help_tip( __( 'If you select category, then product will display based on these selected category.', 'woo-product-finder' ) ); ?>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="wizard_shortcode">
							<?php esc_html_e( 'Wizard Shortcode', 'woo-product-finder' ); ?>
                        </label>
                    </th>
                    <td class="forminp mdtooltip">
                        <div class="product_cost_left_div">
							<?php
							$fields = array(
								'type'        => 'text',
								'class'       => 'text-class',
								'name'        => 'wizard_shortcode',
								'id'          => 'wizard_shortcode',
								'value'       => esc_attr( $wizard_shortcode ),
								'placeholder' => esc_html__( 'Enter Wizard Title Here', 'woo-product-finder' ),
								'extra'       => array(
									'onfocus'  => true,
									'is_add'   => ( 'add' === $default_page ),
									'readonly' => true,
								),
							);
							$this->wpfp_input_fields( $fields );
							?>
							<?php wpfp_help_tip( __( 'Paste shortcode in that page where you want to configure recommandation wizard )', 'woo-product-finder' ) ); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="titledesc" scope="row">
                        <label for="wizard_status"><?php esc_html_e( 'Status', 'woo-product-finder' ); ?></label></th>
                    <td class="forminp mdtooltip md-switch">
                        <label class="switch">
                            <input type="checkbox" name="wizard_status" id="wizard_status" class="wpfp-switch-input" value="1" <?php checked( $wizard_status, 1 ); ?>>
                            <div class="wpfp-switch <?php echo ( $wizard_status === 1 ) ? esc_attr( '-on' ) : ''; ?> ">
                                <span class="wpfp-switch-on"><?php esc_html_e( 'Yes', 'woo-product-finder' ); ?></span>
                                <span class="wpfp-switch-off"><?php esc_html_e( 'No', 'woo-product-finder' ); ?></span>
                                <div class="wpfp-switch-slider"></div>
                            </div>
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>
			<?php if ( 'wpfp-edit-wizard' === $get_page_name ) {
				?>
                <div class="product_header_title">
                    <h2 class="wpfp-manage-question-h2">
						<?php
						esc_html_e( 'Manage Questions', 'woo-product-finder' );
						$wpfp_questions_and_options_data  = get_post_meta( $wizard_id, '_wpfp_questions_and_options_data', true );
						$wpfp_questions_and_options_array = json_decode( $wpfp_questions_and_options_data, true );
						$wpfp_question_listed_count       = 0;
						if ( isset( $wpfp_questions_and_options_array ) && ! empty( $wpfp_questions_and_options_array ) && is_array( $wpfp_questions_and_options_array ) && array_filter( $wpfp_questions_and_options_array ) ) {
							$wpfp_question_listed_count = count( $wpfp_questions_and_options_array );
						}

						$is_pro = ( $wpfp_question_listed_count < 2 );
						if ( wpfp_fs()->is__premium_only() ) {
							if ( wpfp_fs()->can_use_premium_code() ) {
								$is_pro = true;
							}
						}
						if ( true === $is_pro ) {
							?>
                            <a class="wpfp-btn add-new-btn add-new-question" href="javascript:void(0);"><?php esc_html_e( 'Add New Question', 'woo-product-finder' ); ?></a>
							<?php
						} else {
							?>
                            <a class="wpfp-btn add-new-btn add-new-question button-primary wpfp-list-button is_disabled" href="javascript:void(0);"> <?php esc_html_e( 'Add New Question', 'woo-product-finder' ); ?></a>
							<?php
						}
						?>

                    </h2>
                </div>
                <div class="wpfp-question-main-listing" data-question-listed="<?php echo esc_attr( $wpfp_question_listed_count ); ?>">
					<?php
					$wpfp_question_number = 1;
					if ( isset( $wpfp_questions_and_options_array ) && ! empty( $wpfp_questions_and_options_array ) && is_array( $wpfp_questions_and_options_array ) && array_filter( $wpfp_questions_and_options_array ) ) {
						foreach ( $wpfp_questions_and_options_array as $wpfp_question_count => $wpfp_question_options_data ) {
							$is_pro = ( $wpfp_question_number <= 2 );
							if ( wpfp_fs()->is__premium_only() ) {
								if ( wpfp_fs()->can_use_premium_code() ) {
									$is_pro = true;
								}
							}
							if ( true === $is_pro ) {
								$wpfp_questions_array = $wpfp_question_options_data['questions'];

								$wpfp_question_name = ( isset( $wpfp_questions_array['name'] ) && ! empty( $wpfp_questions_array['name'] ) ) ? $wpfp_questions_array['name'] : '';
								if ( wpfp_fs()->is__premium_only() ) {
									if ( wpfp_fs()->can_use_premium_code() ) {
										$wpfp_question_type = ( isset( $wpfp_questions_array['question_type'] ) && ! empty( $wpfp_questions_array['question_type'] ) ) ? $wpfp_questions_array['question_type'] : 'redio';
									} else {
										$wpfp_question_type = 'radio';
									}
								} else {
									$wpfp_question_type = 'radio';
								}

								$wpfp_question_key                     = ( isset( $wpfp_questions_array['key'] ) && ! empty( $wpfp_questions_array['key'] ) ) ? $wpfp_questions_array['key'] : uniqid( 'question_field_' );
								$wpfp_question_class_append_array      = '[' . $wizard_id . '][' . $wpfp_question_count . ']';
								$wpfp_question_class_append_dash       = $wizard_id . '-' . $wpfp_question_count;
								$wpfp_question_class_append_underscore = $wizard_id . '_' . $wpfp_question_count;
								?>
                                <!-- Question section start -->
                                <div class="wpfp-question-main-wrapper" id="wpfp-question-main-wrapper-<?php echo esc_attr( $wpfp_question_class_append_dash ); ?>" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>">

                                    <h2>
                                        <a class="wpfp-question-delete delete" href="javascript:void(0)" id="wpfp_remove_option_<?php echo esc_attr( $wpfp_question_class_append_underscore ); ?>" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>"><?php esc_html_e( 'Remove', 'woo-product-finder' ); ?></a>
                                        <a class="handlediv wpfp-question-toggle toggle" href="javascript:void(0)" aria-label="<?php esc_attr_e( 'Click to toggle', 'woo-product-finder' ); ?>" id="wpfp_btn_toggle_<?php echo esc_attr( $wpfp_question_class_append_underscore ); ?>>" data-toggle="wpfp-question-wrapper-<?php echo esc_attr( $wpfp_question_class_append_dash ); ?>"></a>
                                        <div class="wpfp-tips wpfp-question-tips wpfp-sort" data-tip="<?php esc_attr_e( 'Drag and drop, or click to set admin variation order', 'woo-product-finder' ); ?>"></div>
                                        <span class="wpfp-question-header"><?php echo esc_html( $wpfp_question_name ); ?></span>
                                    </h2>
                                    <div class="wpfp-question-wrapper" id="wpfp-question-wrapper-<?php echo esc_attr( $wpfp_question_class_append_dash ); ?>">

                                        <table class="form-table table-outer question-table all-table-listing">
                                            <tbody>
                                            <tr>
                                                <th class="titledesc">
                                                    <label for="question_name">
														<?php esc_html_e( 'Question Title', 'woo-product-finder' ); ?>
                                                        <span class="required-star">*</span>
                                                    </label>
                                                </th>
                                                <td class="forminp mdtooltip">
													<?php
													$fields = array(
														'type'  => 'hidden',
														'name'  => 'wpfp[questions][key]' . esc_attr( $wpfp_question_class_append_array ),
														'id'    => 'question_field_key',
														'value' => esc_attr( $wpfp_question_key ),
													);
													$this->wpfp_input_fields( $fields );

													$fields = array(
														'type'        => 'text',
														'class'       => 'text-class half_width wpfp-field-required',
														'name'        => 'wpfp[questions][name]' . esc_attr( $wpfp_question_class_append_array ),
														'id'          => 'question_name',
														'value'       => esc_attr( $wpfp_question_name ),
														'placeholder' => esc_html__( 'Enter Question Title Here', 'woo-product-finder' ),
														'extra'       => array(
															'required' => true,
														),
													);
													$this->wpfp_input_fields( $fields );
													wpfp_help_tip( __( 'Question Description Here ( EX: I prefer my shoes to be )', 'woo-product-finder' ) );
													?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="titledesc">
                                                    <label for="question_type"><?php esc_html_e( 'Question Type', 'woo-product-finder' ); ?></label>
                                                </th>
                                                <td class="forminp mdtooltip">
                                                    <select name="wpfp[questions][question_type]<?php echo esc_attr( $wpfp_question_class_append_array ); ?>" id="question_type" data-minimum-results-for-search="<?php esc_html_e( 'Infinity', 'woo-product-finder' ); ?>">
                                                        <option value="radio" <?php selected( $wpfp_question_type, 'radio', true ); ?>><?php esc_html_e( 'Radio', 'woo-product-finder' ); ?></option>
                                                        <option value="checkbox" <?php selected( $wpfp_question_type, 'checkbox', true ); ?> <?php echo esc_attr( $question_type_action ); ?>><?php echo esc_html( $question_type_action_text ); ?></option>
                                                    </select>
													<?php wpfp_help_tip( __( 'Select questions type radio or checkbox', 'woo-product-finder' ) ); ?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
										<?php
										$wpfp_option_listed_count = 0;
										if ( isset( $wpfp_question_options_data['options'] ) && ! empty( $wpfp_question_options_data['options'] ) && is_array( $wpfp_question_options_data['options'] ) && array_filter( $wpfp_question_options_data['options'] ) ) {
											$wpfp_option_listed_count = count( $wpfp_question_options_data['options'] );
										}
										$wpfp_option_add_new_id = $wizard_id . '_' . $wpfp_question_count . '_' . $wpfp_option_listed_count;
										?>
                                        <!-- Options section start. -->
                                        <div class="wpfp-option-header-title" id="wpfp-option-header-title-<?php echo esc_attr( $wpfp_question_class_append_dash ); ?>" data-option-listed="<?php echo esc_attr( $wpfp_option_listed_count ); ?>">
                                            <h3 class="wpfp-manage-option-h3">
												<?php esc_html_e( 'Manage Options', 'woo-product-finder' ); ?>
                                                <a class="wpfp-btn wpfp-add-new-option" href="javascript:void(0)" id="wpfp_btn_toggle_<?php echo esc_attr( $wpfp_option_add_new_id ); ?>" data-question-toggle-id="<?php echo esc_attr( $wpfp_question_count ); ?>"><?php esc_html_e( 'Add New Option', 'woo-product-finder' ); ?></a>
                                            </h3>
											<?php
											$wpfp_option_number = 1;
											if ( isset( $wpfp_question_options_data['options'] ) && ! empty( $wpfp_question_options_data['options'] ) && is_array( $wpfp_question_options_data['options'] ) && array_filter( $wpfp_question_options_data['options'] ) ) {
												foreach ( $wpfp_question_options_data['options'] as $wpfp_option_count => $wpfp_option_data ) {

													$wpfp_option_key       = ( isset( $wpfp_option_data['key'] ) && ! empty( $wpfp_option_data['key'] ) ) ? $wpfp_option_data['key'] : uniqid( 'question_field_' );
													$wpfp_option_name      = ( isset( $wpfp_option_data['name'] ) && ! empty( $wpfp_option_data['name'] ) ) ? $wpfp_option_data['name'] : '';
													$wpfp_option_image_id  = ( isset( $wpfp_option_data['image_id'] ) && ! empty( $wpfp_option_data['image_id'] ) ) ? $wpfp_option_data['image_id'] : 0;
													$wpfp_attribute_name   = ( isset( $wpfp_option_data['attribute_name'] ) && ! empty( $wpfp_option_data['attribute_name'] ) ) ? $wpfp_option_data['attribute_name'] : '';
													$wpfp_attribute_values = ( isset( $wpfp_option_data['attribute_value'] ) && ! empty( $wpfp_option_data['attribute_value'] ) ) ? $wpfp_option_data['attribute_value'] : '';

													$wpfp_option_class_append_array      = '[' . $wizard_id . '][' . $wpfp_question_count . '][' . $wpfp_option_count . ']';
													$wpfp_option_class_append_dash       = $wizard_id . '-' . $wpfp_question_count . '-' . $wpfp_option_count;
													$wpfp_option_class_append_underscore = $wizard_id . '_' . $wpfp_question_count . '_' . $wpfp_option_count;

													?>
                                                    <!-- Options loop start. -->
                                                    <div class="wpfp-options-box" id="wpfp-options-box-<?php echo esc_attr( $wpfp_option_class_append_dash ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
                                                        <h3>
                                                            <a class="wpfp-option-delete delete" href="javascript:void(0)" id="wpfp_remove_option_<?php echo esc_attr( $wpfp_option_class_append_underscore ); ?>" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>"><?php esc_html_e( 'Remove', 'woo-product-finder' ); ?></a>
                                                            <a class="handlediv wpfp-option-toggle toggle" aria-label="<?php esc_attr_e( 'Click to toggle', 'woo-product-finder' ); ?>" id="wpfp_btn_toggle_<?php echo esc_attr( $wpfp_option_class_append_underscore ); ?>" data-toggle="wpfp-option-wrapper-<?php echo esc_attr( $wpfp_option_class_append_dash ); ?>"></a>
                                                            <div class="wpfp-tips wpfp-option-tips wpfp-sort" data-tip="<?php esc_attr_e( 'Drag and drop, or click to set admin variation order', 'woo-product-finder' ); ?>"></div>
                                                            <span class="wpfp-option-header"><?php echo esc_html( $wpfp_option_name ); ?></span>
                                                        </h3>
                                                        <div class="wpfp-option-wrapper" id="wpfp-option-wrapper-<?php echo esc_attr( $wpfp_option_class_append_dash ); ?>" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
                                                            <table class="form-table table-outer product-fee-table" id="option_section">
                                                                <tbody>
                                                                <tr>
                                                                    <th class="titledesc">
                                                                        <label for="option_name">
																			<?php esc_html_e( 'Options Title', 'woo-product-finder' ); ?>
                                                                            <span class="required-star">*</span>
                                                                        </label>
                                                                    </th>
                                                                    <td class="forminp mdtooltip">
																		<?php
																		$fields = array(
																			'type'  => 'hidden',
																			'name'  => 'wpfp[options][key]' . esc_attr( $wpfp_option_class_append_array ),
																			'id'    => 'option_field_key',
																			'value' => esc_attr( $wpfp_option_key ),
																		);
																		$this->wpfp_input_fields( $fields );

																		$fields = array(
																			'type'        => 'text',
																			'class'       => 'text-class half_width wpfp-field-required',
																			'name'        => 'wpfp[options][name]' . esc_attr( $wpfp_option_class_append_array ),
																			'id'          => 'option_name',
																			'value'       => esc_attr( $wpfp_option_name ),
																			'placeholder' => esc_html__( 'Enter Options Title Here', 'woo-product-finder' ),
																			'extra'       => array(
																				'required' => true,
																			),
																		);
																		$this->wpfp_input_fields( $fields );
																		?>
																		<?php wpfp_help_tip( __( 'If you are creating wizard based on shoes, then you want to enter option title related to attribute value ( EX: Attribute value is male, then you should keep option name : Male )', 'woo-product-finder' ) ); ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="titledesc">
                                                                        <label for="option_title">
																			<?php esc_html_e( 'Options Image', 'woo-product-finder' ); ?>
                                                                            <span class="required-star">*</span>
                                                                        </label>
                                                                    </th>
                                                                    <td class="forminp mdtooltip">
																		<?php
																		if ( wpfp_fs()->is__premium_only() ) {
																			if ( wpfp_fs()->can_use_premium_code() ) {
																				?>
                                                                                <div class="wpfp-uploader-wrapper" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
                                                                                    <a class="option_uploader_image button" id="option_uploader_image_id" data-uploader-title="<?php esc_html_e( 'Select File', 'woo-product-finder' ); ?>" data-uploader-button-text="<?php esc_html_e( 'Include File', 'woo-product-finder' ); ?>" data-uploadname="option_single_upload_file" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
																						<?php esc_html_e( 'Upload File', 'woo-product-finder' ); ?>
                                                                                    </a>
                                                                                    <a class="option_remove_image button" id="option_remove_image_id" data-uploadname="option_single_upload_file" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
																						<?php esc_html_e( 'Remove File', 'woo-product-finder' ); ?>
                                                                                    </a>
																					<?php wpfp_help_tip( __( 'Upload Options Image Here', 'woo-product-finder' ) ); ?>
                                                                                </div>
                                                                                <div class="wpfp-image-preview" id="wpfp-image-preview" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
																					<?php if ( 0 !== $wpfp_option_image_id ) { ?>
                                                                                        <img src="<?php echo esc_url( wp_get_attachment_url( $wpfp_option_image_id ) ) ?>" data-id="<?php echo esc_attr( $wpfp_option_image_id ); ?>" alt="<?php echo esc_attr( get_the_title( $wpfp_option_image_id ) ); ?>">
																						<?php
																						$fields = array(
																							'type'  => 'hidden',
																							'name'  => 'wpfp[options][image_id]' . esc_attr( $wpfp_option_class_append_array ),
																							'id'    => 'option_image_id',
																							'value' => esc_attr( $wpfp_option_image_id ),
																						);
																						$this->wpfp_input_fields( $fields );
																						?>
																					<?php } ?>
                                                                                </div>
																				<?php
																			} else {
																				?>
                                                                                <div class="wpfp-uploader-wrapper" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
                                                                                    <a class="<?php echo esc_attr( $plugin_status ); ?> button" id="" disabled>
																						<?php esc_html_e( 'Upload File', 'woo-product-finder' ); ?>
                                                                                    </a>
                                                                                    <a class="<?php echo esc_attr( $plugin_status ); ?> button" id="" disabled>
																						<?php esc_html_e( 'Remove File', 'woo-product-finder' ); ?>
                                                                                    </a>
																					<?php wpfp_help_tip( __( 'Upload Options Image Here', 'woo-product-finder' ) ); ?>
                                                                                </div>
                                                                                <div class="wpfp-image-preview <?php echo esc_attr( $plugin_status ); ?>" id="wpfp-image-preview">
                                                                                    <img src="<?php echo esc_url( wc_placeholder_img_src() ) ?>" alt="<?php esc_html_e( 'Default preview image', 'woo-product-finder' ); ?>">
                                                                                </div>
																				<?php
																			}
																		} else {
																			?>
                                                                            <div class="wpfp-uploader-wrapper" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
                                                                                <a class="<?php echo esc_attr( $plugin_status ); ?> button" id="" disabled>
																					<?php esc_html_e( 'Upload File', 'woo-product-finder' ); ?>
                                                                                </a>
                                                                                <a class="<?php echo esc_attr( $plugin_status ); ?> button" id="" disabled>
																					<?php esc_html_e( 'Remove File', 'woo-product-finder' ); ?>
                                                                                </a>
																				<?php wpfp_help_tip( __( 'Upload Options Image Here', 'woo-product-finder' ) ); ?>
                                                                            </div>
                                                                            <div class="wpfp-image-preview <?php echo esc_attr( $plugin_status ); ?>" id="wpfp-image-preview">
                                                                                <img src="<?php echo esc_url( wc_placeholder_img_src() ) ?>" alt="<?php esc_html_e( 'Default preview image', 'woo-product-finder' ); ?>">
                                                                            </div>
																			<?php
																		}
																		?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="titledesc">
                                                                        <label for="attribute_name">
																			<?php esc_html_e( 'Attribute Name', 'woo-product-finder' ); ?>
                                                                            <span class="required-star">*</span>
                                                                        </label>
                                                                    </th>
                                                                    <td class="forminp mdtooltip">
                                                                        <select name="wpfp[options][attribute_name]<?php echo esc_attr( $wpfp_option_class_append_array ); ?>" id="attribute_name" class="attribute-name wpfp-field-required" data-placeholder="<?php esc_attr_e( 'Please type attribute slug', 'woo-product-finder' ); ?>" data-minimum-input-length="3" data-allow-clear="true" required="required" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wpfp_script_security_nonce' ) ); ?>" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>">
																			<?php
																			if ( isset( $wpfp_attribute_name ) && ! empty( $wpfp_attribute_name ) ) {
																				$wpfp_attribute_name_array = get_exploded_string( $wpfp_attribute_name, '==' );
																				?>
                                                                                <option value="<?php echo esc_attr( $wpfp_attribute_name ); ?>" selected><?php echo esc_html( $wpfp_attribute_name_array[0] ); ?></option>
																				<?php
																			}
																			?>
                                                                        </select>
																		<?php wpfp_help_tip( __( 'Select attribute name which is created in Product attribute section (Ex. Attribute name: Gender Attribute value: gender) type attribute value gender', 'woo-product-finder' ) ); ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="titledesc">
                                                                        <label for="attribute_value">
																			<?php esc_html_e( 'Attribute Value', 'woo-product-finder' ); ?>
                                                                            <span class="required-star">*</span>
                                                                        </label>
                                                                    </th>
                                                                    <td class="forminp mdtooltip">
                                                                        <select multiple="" name="wpfp[options][attribute_value]<?php echo esc_attr( $wpfp_option_class_append_array ); ?>[]" id="attribute_value" class="attribute-value wpfp-field-required" data-placeholder="<?php esc_attr_e( 'Select Attribute Value', 'woo-product-finder' ); ?>" data-question-id="<?php echo esc_attr( $wpfp_question_count ); ?>" data-option-id="<?php echo esc_attr( $wpfp_option_count ); ?>" required="required">
																			<?php
																			if ( isset( $wpfp_attribute_values ) && ! empty( $wpfp_attribute_values ) ) {
																				foreach ( $wpfp_attribute_values as $wpfp_attribute_value ) {
																					?>
                                                                                    <option value="<?php echo esc_attr( $wpfp_attribute_value ); ?>" selected>
																						<?php echo esc_html( $wpfp_attribute_value ); ?>
                                                                                    </option>
																					<?php
																				}
																			}
																			?>
                                                                        </select>
																		<?php wpfp_help_tip( __( 'Select attribute value which is created in Product attribute section', 'woo-product-finder' ) ); ?>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- Options loop end. -->
													<?php
													$wpfp_option_number ++;
												}
											}
											?>
                                        </div>
                                        <!-- Options section end. -->
                                    </div>
                                </div>
                                <!-- Question section end -->
								<?php
							}
							$wpfp_question_number ++;
						}
					}

					?>
                </div>
				<?php
			}
			submit_button(
				esc_html__( 'Save & Continue', 'woo-product-finder' ),
				'primary',
				'submit_wizard'
			);
			?>
        </form>

    </div>
<?php
$file_dir_path = 'header/plugin-sidebar.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}