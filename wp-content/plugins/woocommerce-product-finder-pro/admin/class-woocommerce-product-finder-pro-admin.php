<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/dots
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/admin
 * @author     Multidots <hello@multidots.com>
 */
class Woocommerce_Product_Finder_Pro_Admin {
	const wpfp_post_type = 'wc_wpfp_wizard';
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
	 * Get the plugin name.
	 * @return string
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Get the plugin version.
	 * @return string
	 */
	public function get_plugin_version() {
		return $this->version;
	}

	/**
	 * Enqueue the style and script in one function.
	 */
	public function wpfp_admin_enqueue_styles_scripts_callback() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Product_Finder_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Product_Finder_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_media();
		wp_enqueue_style( $this->get_plugin_name() . 'main-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->get_plugin_version(), 'all' );
		wp_enqueue_style( $this->get_plugin_name() . 'media-css', plugin_dir_url( __FILE__ ) . 'css/media.css', array(), $this->get_plugin_version(), 'all' );
		wp_enqueue_style( $this->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/woocommerce-product-finder-pro-admin.css', array(
			'wp-color-picker',
			'woocommerce_admin_styles'
		), $this->get_plugin_version(), 'all' );


		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Product_Finder_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Product_Finder_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script( $this->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/woocommerce-product-finder-pro-admin' . $suffix . '.js', array(
			'jquery',
			'selectWoo',
			'jquery-tiptip',
			'wp-color-picker',
			'jquery-ui-sortable'
		), $this->get_plugin_version(), false );
		$currentScreen        = get_current_screen();
		$wpfp_localize_script = array(
			'wpfp_ajax_url'                                => admin_url( 'admin-ajax.php' ),
			'wpfp_script_nonce'                            => wp_create_nonce( 'wpfp_script_security_nonce' ),
			'wpfp_question_configuration_text'             => __( 'Question Configuration', 'woo-product-finder' ),
			'wpfp_toggle_text'                             => __( 'Toggle', 'woo-product-finder' ),
			'wpfp_toggle_arial_label_text'                 => __( 'Click to toggle', 'woo-product-finder' ),
			'wpfp_delete_text'                             => __( 'Remove', 'woo-product-finder' ),
			'wpfp_question_name_text'                      => __( 'Question Title', 'woo-product-finder' ),
			'wpfp_question_name_input_placeholder_text'    => __( 'Enter Question Title Here', 'woo-product-finder' ),
			'wpfp_question_name_description_text'          => __( 'Question Description Here ( EX: I prefer my shoes to be )', 'woo-product-finder' ),
			'wpfp_question_type_text'                      => __( 'Question Type', 'woo-product-finder' ),
			'wpfp_question_type_remove_alert_text'         => __( 'Do you want to remove this question?', 'woo-product-finder' ),
			'wpfp_question_type_search_infinity_text'      => __( 'Infinity', 'woo-product-finder' ),
			'wpfp_question_type_text_option_radio'         => __( 'Radio', 'woo-product-finder' ),
			'wpfp_question_type_text_option_checkbox'      => __( 'Checkbox (Pro version only)', 'woo-product-finder' ),
			'wpfp_question_type_description_text'          => __( 'Select questions type radio or checkbox', 'woo-product-finder' ),
			'wpfp_manage_option_text'                      => __( 'Manage Options', 'woo-product-finder' ),
			'wpfp_add_new_option_text'                     => __( 'Add New Option', 'woo-product-finder' ),
			'wpfp_option_text'                             => __( 'Option', 'woo-product-finder' ),
			'wpfp_option_title_text'                       => __( 'Options Title', 'woo-product-finder' ),
			'wpfp_option_title_input_placeholder_text'     => __( 'Enter Options Title Here', 'woo-product-finder' ),
			'wpfp_option_title_description_text'           => __( 'If you are creating wizard based on shoes, then you want to enter option title related to attribute value ( EX: Attribute value is male, then you should keep option name : Male )', 'woo-product-finder' ),
			'wpfp_option_image_text'                       => __( 'Options Image', 'woo-product-finder' ),
			'wpfp_option_image_uploader_title_text'        => __( 'Select File', 'woo-product-finder' ),
			'wpfp_option_image_uploader_button_text'       => __( 'Include File', 'woo-product-finder' ),
			'wpfp_option_image_uploader_text'              => __( 'Upload File', 'woo-product-finder' ),
			'wpfp_option_image_remove_text'                => __( 'Remove File', 'woo-product-finder' ),
			'wpfp_option_image_description_text'           => __( 'Upload Options Image Here', 'woo-product-finder' ),
			'wpfp_option_image_remove_alert_text'          => __( 'Remove this file?', 'woo-product-finder' ),
			'wpfp_image_required_format_text'              => __( 'Please select png,jpg,jpeg and gif file.', 'woo-product-finder' ),
			'wpfp_option_attribute_name_text'              => __( 'Attribute Name', 'woo-product-finder' ),
			'wpfp_option_attribute_name_placeholder_text'  => __( 'Please type attribute slug', 'woo-product-finder' ),
			'wpfp_option_attribute_name_description_text'  => __( 'Select attribute name which is created in Product attribute section (Ex. Attribute name: Gender Attribute value: gender) type attribute value gender', 'woo-product-finder' ),
			'wpfp_option_attribute_value_text'             => __( 'Attribute Value', 'woo-product-finder' ),
			'wpfp_option_attribute_value_placeholder_text' => __( 'Select Attribute Value', 'woo-product-finder' ),
			'wpfp_option_attribute_value_description_text' => __( 'Select attribute value which is created in Product attribute section', 'woo-product-finder' ),
			'wpfp_validation_text'                         => __( 'This field is required', 'woo-product-finder' ),
			'wpfp_wizard_delete_alert_text'                => __( 'Are you sure want to delete selected wizard?', 'woo-product-finder' ),
			'wpfp_current_screen'                          => $currentScreen->id,
			'can_use_premium_code'                         => wp_json_encode( wpfp_fs()->can_use_premium_code() ),
		);

		if ( wpfp_fs()->is__premium_only() ) {
			if ( wpfp_fs()->can_use_premium_code() ) {
				$wpfp_localize_script['wpfp_question_type_text_option_checkbox'] = __( 'Checkbox', 'woo-product-finder' );
			}
		}

		wp_localize_script( $this->get_plugin_name(), 'wpfpScriptObj', $wpfp_localize_script );
		wp_enqueue_script( $this->get_plugin_name() );
	}

	/**
	 *
	 * Add the dotStore menus.
	 */
	public function wpfp_dot_store_menu() {
		global $GLOBALS;
		if ( empty( $GLOBALS['admin_page_hooks']['dots_store'] ) ) {
			add_menu_page(
				'DotStore Plugins', __( 'DotStore Plugins' ), 'manage_option', 'dots_store',
				array(
					$this,
					'wpfp_wizrd_list_page',
				), plugin_dir_url( __FILE__ ) . 'images/thedotstore-images/menu-icon.png', 25 );
		}
		add_submenu_page( 'dots_store', __( 'Get Started', 'woo-product-finder' ), __( 'Get Started', 'woo-product-finder' ), 'manage_options', 'wpfp-get-started',
			array(
				$this,
				'wpfp_get_started_page'
			) );
		add_submenu_page( 'dots_store', __( 'Introduction', 'woo-product-finder' ), __( 'Introduction', 'woo-product-finder' ), 'manage_options', 'wpfp-information',
			array(
				$this,
				'wpfp_information_page'
			) );
		add_submenu_page( 'dots_store', __( 'WooCommerce Product Finder Pro', 'woo-product-finder' ), __( 'WooCommerce Product Finder Pro' ), 'manage_options', 'wpfp-list',
			array(
				$this,
				'wpfp_wizrd_list_page',
			) );
		add_submenu_page( 'dots_store', __( 'Add New', 'woo-product-finder' ), __( 'Add New', 'woo-product-finder' ), 'manage_options', 'wpfp-add-wizard',
			array(
				$this,
				'wpfp_add_new_wizard_page'
			) );
		add_submenu_page( 'dots_store', __( 'Edit Wizard', 'woo-product-finder' ), __( 'Edit Wizard', 'woo-product-finder' ), 'manage_options', 'wpfp-edit-wizard',
			array(
				$this,
				'wpfp_edit_wizard_page'
			) );
		if ( wpfp_fs()->is__premium_only() ) {
			if ( wpfp_fs()->can_use_premium_code() ) {
				add_submenu_page( 'dots_store', __( 'Wizard Setting', 'woo-product-finder' ), __( 'Wizard Setting', 'woo-product-finder' ), 'manage_options', 'wpfp-wizard-setting',
					array(
						$this,
						'wpfp_wizard_setting_page'
					) );
			}
		}
	}

	/**
	 * Remove Menu from toolbar which is display in admin section.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_remove_admin_submenus() {
		remove_submenu_page( 'dots_store', 'wpfp-information' );
		remove_submenu_page( 'dots_store', 'wpfp-premium' );
		remove_submenu_page( 'dots_store', 'wpfp-add-wizard' );
		remove_submenu_page( 'dots_store', 'wpfp-edit-wizard' );
		remove_submenu_page( 'dots_store', 'wpfp-get-started' );
		remove_submenu_page( 'dots_store', 'wpfp-add-new-question' );
		remove_submenu_page( 'dots_store', 'wpfp-edit-question' );
		if ( wpfp_fs()->is__premium_only() ) {
			if ( wpfp_fs()->can_use_premium_code() ) {
				remove_submenu_page( 'dots_store', 'wpfp-wizard-setting' );
			}
		}
	}

	/**
	 * Redirect to quick start guide after plugin activation.
	 *
	 * @uses wpfp_register_post_type()
	 *
	 * @since    1.0.0
	 */
	public function wpfp_welcome_plugin_screen_do_activation_redirect() {
		$this->wpfp_register_post_type();

		// if no activation redirect
		if ( ! get_transient( '_welcome_screen_afrsm_pro_mode_activation_redirect_data' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( '_welcome_screen_afrsm_pro_mode_activation_redirect_data' );

		// if activating from network, or bulk
		$activate_multi = filter_input( INPUT_GET, 'activate-multi', FILTER_SANITIZE_STRING );
		if ( is_network_admin() || isset( $activate_multi ) ) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect( esc_url( $this->get_wpfp_url( array( 'page' => 'wpfp-get-started' ) ) ) );
		exit;
	}

	/**
	 * Register post type.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_register_post_type() {
		register_post_type( self::wpfp_post_type, array(
			'labels' => array(
				'name'          => __( 'WooCommerce Product Finder premium', 'woo-product-finder' ),
				'singular_name' => __( 'WooCommerce Product Finder premium', 'woo-product-finder' ),
			),
		) );
	}

	/**
	 * Get all woocommerce category for admin area.
	 *
	 * @return array product categories.
	 * @since    1.0.0
	 *
	 */
	public function wpfp_get_woocommerce_category() {

		$woo_terms = get_terms( 'product_cat', array(
			'hide_empty' => 0,
			'order'      => 'ASC',
			'orderby'    => 'id',
		) );

		$wpfp_cat_array = array();
		if ( ! empty( $woo_terms ) && ! is_wp_error( $woo_terms ) ) {
			foreach ( $woo_terms as $woo_term ) {
				$wpfp_cat_array[ $woo_term->term_id ] = trim( $woo_term->name );
			}
		}

		return $wpfp_cat_array;
	}

	/**
	 * Register the Get Started Page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_get_started_page() {
		$file_dir_path = 'partials/wpfp-get-started-page.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 * Register the Information Page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_information_page() {
		$file_dir_path = 'partials/wpfp-information-page.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 * Register the Wizard List for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_wizrd_list_page() {
		$file_dir_path = 'partials/wpfp-list-page.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 * Register the Add New Wizard for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_add_new_wizard_page() {
		$file_dir_path = 'partials/wpfp-edit-page.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 * Register the Edit Wizard Page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_edit_wizard_page() {
		$file_dir_path = 'partials/wpfp-edit-page.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 * Register the Wizard Setting Page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_wizard_setting_page() {
		if ( wpfp_fs()->is__premium_only() ) {
			if ( wpfp_fs()->can_use_premium_code() ) {
				$file_dir_path = 'partials/wpfp-wizard-setting__premium_only.php';
				if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
					require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
				}
			}
		}
	}

	/**
	 * Save the new wizard.
	 */
	public function wpfp_add_wizard_callback() {
		// Post Methods.
		$wpfp_nonce = filter_input( INPUT_POST, 'wpfp_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ( isset( $wpfp_nonce ) && ! empty( $wpfp_nonce ) ) && wp_verify_nonce( $wpfp_nonce, 'wpfp_add_nonce' ) ) {
			$wizard_post_type = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );
			if ( ( isset( $wizard_post_type ) && ! empty( $wizard_post_type ) ) && self::wpfp_post_type === $wizard_post_type ) {

				$wizard_title  = filter_input( INPUT_POST, 'wizard_title', FILTER_SANITIZE_STRING );
				$wizard_status = filter_input( INPUT_POST, 'wizard_status', FILTER_SANITIZE_STRING );

				if ( wpfp_fs()->is__premium_only() ) {
					if ( wpfp_fs()->can_use_premium_code() ) {
						$args      = array(
							'wizard_category' => array(
								'filter' => FILTER_VALIDATE_INT,
								'flags'  => FILTER_REQUIRE_ARRAY,
							)
						);
						$wpfp_data = filter_input_array( INPUT_POST, $args );

						$wizard_category = array();
						if ( isset( $wpfp_data['wizard_category'] ) && is_array( $wpfp_data['wizard_category'] ) && array_filter( $wpfp_data['wizard_category'] ) ) {
							$wizard_category = $wpfp_data['wizard_category'];
						}
					}
				}

				$post_status = $this->filter_wizard_status_value( $wizard_status, true );

				if ( ( isset( $wizard_title ) && ! empty( $wizard_title ) ) ) {
					$wpfp_post_args = array(
						'post_title'  => $wizard_title,
						'post_status' => $post_status,
						'post_type'   => self::wpfp_post_type,
					);
					$wizard_id      = wp_insert_post( $wpfp_post_args );

					if ( wpfp_fs()->is__premium_only() ) {
						if ( wpfp_fs()->can_use_premium_code() ) {
							if ( array_filter( $wizard_category ) ) {
								wp_set_post_terms( $wizard_id, $wizard_category, 'product_cat' );
							}
						}
					}

					// Notice Actions: error,warning,success,info.
					$notice_json_encode = wp_json_encode( array(
						'notice_action'  => 'success',
						'is_dismissible' => true,
						'message'        => __( 'New wizard successfully added.', 'woo-product-finder' )
					) );
					set_transient( 'wpfp_admin_notice', $notice_json_encode, MINUTE_IN_SECONDS );
					wp_safe_redirect( html_entity_decode( esc_url( $this->get_edit_wizard_url( $wizard_id ) ) ) );
					exit;
				} else {
					wp_die( esc_html__( 'Wizard title must required.', 'woo-product-finder' ),
						esc_html__( 'Error', 'woo-product-finder' ), array(
							'response'  => 403,
							'back_link' => true,
						)
					);
				}
			} else {
				wp_die( esc_html__( 'Somgthing went wrong.', 'woo-product-finder' ),
					esc_html__( 'Error', 'woo-product-finder' ), array(
						'response'  => 403,
						'back_link' => true,

					)
				);
			}
		} else {
			wp_die( esc_html__( 'Invalid nonce specified', 'woo-product-finder' ),
				esc_html__( 'Error', 'woo-product-finder' ), array(
					'response'  => 403,
					'back_link' => true,

				)
			);
		}
	}

	/**
	 * Edited wizard saved.
	 */
	public function wpfp_edit_wizard_callback() {

		$wpfp_nonce = filter_input( INPUT_POST, 'wpfp_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ( isset( $wpfp_nonce ) && ! empty( $wpfp_nonce ) ) && wp_verify_nonce( $wpfp_nonce, 'wpfp_edit_nonce' ) ) {
			$wizard_post_type = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );
			$wizard_post_id   = filter_input( INPUT_POST, 'wizard_post_id', FILTER_SANITIZE_STRING );
			if ( ( isset( $wizard_post_type ) && ! empty( $wizard_post_type ) ) && $wizard_post_type === get_post_type( $wizard_post_id ) ) {
				$wizard_title = filter_input( INPUT_POST, 'wizard_title', FILTER_SANITIZE_STRING );

				if ( wpfp_fs()->is__premium_only() ) {
					if ( wpfp_fs()->can_use_premium_code() ) {
						$pro_args        = array(
							'wizard_category' => array(
								'filter' => FILTER_VALIDATE_INT,
								'flags'  => FILTER_REQUIRE_ARRAY,
							),
						);
						$wpfp_pro_data   = filter_input_array( INPUT_POST, $pro_args );
						$wizard_category = array();
						if ( isset( $wpfp_pro_data['wizard_category'] ) && ! empty( $wpfp_pro_data['wizard_category'] ) && is_array( $wpfp_pro_data['wizard_category'] ) && array_filter( $wpfp_pro_data['wizard_category'] ) ) {
							$wizard_category = $wpfp_pro_data['wizard_category'];
						}
					}
				}

				$args      = array(
					'wpfp' => array(
						'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
						'flags'  => FILTER_REQUIRE_ARRAY,
					)
				);
				$wpfp_data = filter_input_array( INPUT_POST, $args );

				if ( isset( $wpfp_data['wpfp'] ) ) {

					if ( ! array_filter( $wpfp_data['wpfp']['questions']['name'][ $wizard_post_id ] ) ) {
						wp_die( esc_html__( 'Something went wrong in manage questions. please check and submit again.', 'woo-product-finder' ),
							esc_html__( 'Error', 'woo-product-finder' ), array(
								'response'  => 403,
								'back_link' => true,
							) );
					}

					foreach ( $wpfp_data['wpfp']['options']['name'][ $wizard_post_id ] as $options_fields ) {
						if ( ! array_filter( $options_fields ) ) {
							wp_die( esc_html__( 'Something went wrong in manage options. please check and submit again.', 'woo-product-finder' ),
								esc_html__( 'Error', 'woo-product-finder' ), array(
									'response'  => 403,
									'back_link' => true,
								) );
						}
					}
					$wpfp_questions_and_options_array = array();
					if ( isset( $wpfp_data['wpfp'] ) && ! empty( $wpfp_data['wpfp'] ) && is_array( $wpfp_data['wpfp'] ) && array_filter( $wpfp_data['wpfp'] ) ) {
						foreach ( $wpfp_data['wpfp'] as $wpfp_value ) {
							if ( isset( $wpfp_value ) ) {
								foreach ( $wpfp_value as $inner_key => $inner_value ) {
									if ( isset( $inner_value[ $wizard_post_id ] ) ) {
										foreach ( $inner_value[ $wizard_post_id ] as $sub_inner_key => $sub_inner_value ) {
											if ( is_array( $sub_inner_value ) && array_filter( $sub_inner_value ) ) {
												foreach ( $sub_inner_value as $key => $value ) {
													$wpfp_questions_and_options_array[ $sub_inner_key ]['options'][ $key ][ $inner_key ] = isset( $value ) ? $value : '';
												}
											} else {
												$wpfp_questions_and_options_array[ $sub_inner_key ]['questions'][ $inner_key ] = isset( $sub_inner_value ) ? $sub_inner_value : '';
											}
										}
									}
								}
							}
						}
					}
				}

				$wpfp_new_order_questions_and_options_array = array();
				if ( isset( $wpfp_questions_and_options_array ) && ! empty( $wpfp_questions_and_options_array ) && is_array( $wpfp_questions_and_options_array ) && array_filter( $wpfp_questions_and_options_array ) ) {
					foreach ( $wpfp_questions_and_options_array as $question_array ) {
						$options = $question_array['options'];

						$wpfp_new_order_questions_and_options_array[ $question_array['questions']['key'] ]['questions'] = $question_array['questions'];
						foreach ( $options as $option_array ) {
							$wpfp_new_order_questions_and_options_array[ $question_array['questions']['key'] ]['options'][ $option_array['key'] ] = $option_array;
						}
					}
				}

				$wpfp_questions_and_options_array = $wpfp_new_order_questions_and_options_array;

				$wizard_status = filter_input( INPUT_POST, 'wizard_status', FILTER_SANITIZE_STRING );
				$post_status   = $this->filter_wizard_status_value( $wizard_status, true );

				if ( ( isset( $wizard_post_id ) && ! empty( $wizard_post_id ) ) && ( isset( $wizard_title ) && ! empty( $wizard_title ) ) ) {

					$wpfp_post_args    = array(
						'ID'          => $wizard_post_id,
						'post_title'  => $wizard_title,
						'post_status' => $post_status,
						'post_type'   => self::wpfp_post_type,
					);
					$updated_wizard_id = wp_update_post( $wpfp_post_args );

					if ( wpfp_fs()->is__premium_only() ) {
						if ( wpfp_fs()->can_use_premium_code() ) {
							if ( array_filter( $wizard_category ) ) {
								wp_set_post_terms( $updated_wizard_id, $wizard_category, 'product_cat' );
							} else {
								wp_set_post_terms( $updated_wizard_id, array(), 'product_cat' );
							}
						}
					}

					if ( isset( $wpfp_data['wpfp'] ) && array_filter( $wpfp_questions_and_options_array ) ) {
						$wpfp_questions_and_options_data = wp_json_encode( $wpfp_questions_and_options_array );
						update_post_meta( $updated_wizard_id, '_wpfp_questions_and_options_data', $wpfp_questions_and_options_data );
					} else {
						delete_post_meta( $updated_wizard_id, '_wpfp_questions_and_options_data' );
					}

					// Notice Actions: error,warning,success,info.
					$notice_json_encode = wp_json_encode( array(
						'notice_action'  => 'success',
						'is_dismissible' => true,
						'message'        => __( 'Wizard successfully saved.', 'woo-product-finder' )
					) );
					set_transient( 'wpfp_admin_notice', $notice_json_encode, MINUTE_IN_SECONDS );
					wp_safe_redirect( html_entity_decode( esc_url( $this->get_edit_wizard_url( $wizard_post_id ) ) ) );
					exit;
				} else {
					wp_die( esc_html__( 'Wizard title must required.', 'woo-product-finder' ),
						esc_html__( 'Error', 'woo-product-finder' ), array(
							'response'  => 403,
							'back_link' => true,
						)
					);
				}
			} else {
				wp_die( esc_html__( 'Something went wrong.', 'woo-product-finder' ),
					esc_html__( 'Error', 'woo-product-finder' ), array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}
		} else {
			wp_die( esc_html__( 'Invalid nonce specified', 'woo-product-finder' ),
				esc_html__( 'Error', 'woo-product-finder' ), array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	/**
	 * Save the setting of the wizard.
	 */
	public function wpfp_setting_wizard_callback() {
		// Post Methods.
		$wpfp_nonce = filter_input( INPUT_POST, 'wpfp_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ( isset( $wpfp_nonce ) && ! empty( $wpfp_nonce ) ) && wp_verify_nonce( $wpfp_nonce, 'wpfp_setting_nonce' ) ) {
			$wizard_post_type = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );
			$wizard_post_id   = filter_input( INPUT_POST, 'wizard_post_id', FILTER_SANITIZE_NUMBER_INT );

			if ( ( isset( $wizard_post_type ) && ! empty( $wizard_post_type ) ) && $wizard_post_type === get_post_type( $wizard_post_id ) ) {
				$args                     = array(
					'wpfp_wizard_setting' => array(
						'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
						'flags'  => FILTER_REQUIRE_ARRAY,
					)
				);
				$wpfp_data                = filter_input_array( INPUT_POST, $args );
				$wpfp_wizard_setting_data = wp_json_encode( $wpfp_data['wpfp_wizard_setting'] );
				$transient_key            = "wizard_setting_{$wizard_post_id}";
				delete_transient( $transient_key );
				update_post_meta( $wizard_post_id, '_wpfp_wizard_setting_data', $wpfp_wizard_setting_data );

				// Notice Actions: error,warning,success,info.
				$notice_json_encode = wp_json_encode( array(
					'notice_action'  => 'success',
					'is_dismissible' => true,
					'message'        => __( 'Wizard setting successfully saved.', 'woo-product-finder' )
				) );
				set_transient( 'wpfp_admin_notice', $notice_json_encode, MINUTE_IN_SECONDS );
				wp_safe_redirect( html_entity_decode( esc_url( $this->get_setting_wizard_url( $wizard_post_id, 0 ) ) ) );
				exit;
			} else {
				wp_die( esc_html__( 'Somgthing went wrong.', 'woo-product-finder' ),
					esc_html__( 'Error', 'woo-product-finder' ), array(
						'response'  => 403,
						'back_link' => true,
					)
				);
			}
		} else {
			wp_die( esc_html__( 'Invalid nonce specified', 'woo-product-finder' ),
				esc_html__( 'Error', 'woo-product-finder' ), array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	/**
	 * Save the master setting.
	 */
	public function wpfp_master_setting_wizard_callback() {
		// Post Methods.
		$wpfp_nonce = filter_input( INPUT_POST, 'wpfp_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ( isset( $wpfp_nonce ) && ! empty( $wpfp_nonce ) ) && wp_verify_nonce( $wpfp_nonce, 'wpfp_master_setting_nonce' ) ) {
			$result_display_mode = filter_input( INPUT_POST, 'result_display_mode', FILTER_SANITIZE_STRING );
			update_option( 'wpfp_result_display_mode', $result_display_mode );
			// Notice Actions: error,warning,success,info.
			$notice_json_encode = wp_json_encode( array(
				'notice_action'  => 'success',
				'is_dismissible' => true,
				'message'        => __( 'Wizard master setting successfully saved.', 'woo-product-finder' )
			) );
			set_transient( 'wpfp_admin_notice', $notice_json_encode, MINUTE_IN_SECONDS );
			wp_safe_redirect( html_entity_decode( esc_url( $this->get_wizard_list_url() ) ) );
			exit;
		} else {
			wp_die( esc_html__( 'Invalid nonce specified', 'woo-product-finder' ),
				esc_html__( 'Error', 'woo-product-finder' ), array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	/**
	 * Delete wizard callback function.
	 */
	public function wpfp_delete_wizard_callback() {

		$wpfp_nonce = filter_input( INPUT_GET, 'wpfp_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ( isset( $wpfp_nonce ) && ! empty( $wpfp_nonce ) ) && wp_verify_nonce( $wpfp_nonce, 'wpfp_delete_nonce' ) ) {
			$wizard_post_id = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_NUMBER_INT );
			$wizard_paged   = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );

			// Delete the wizard.
			$this->wpfp_delete_wizard( $wizard_post_id );
			// Notice Actions: error,warning,success,info.
			$notice_json_encode = wp_json_encode( array(
				'notice_action'  => 'success',
				'is_dismissible' => true,
				'message'        => __( 'Wizard successfully deleted.', 'woo-product-finder' )
			) );
			set_transient( 'wpfp_admin_notice', $notice_json_encode, MINUTE_IN_SECONDS );
			wp_safe_redirect( html_entity_decode( esc_url( $this->get_wizard_list_url( $wizard_paged ) ) ) );
			exit;
		} else {
			wp_die( esc_html__( 'Invalid nonce specified', 'woo-product-finder' ),
				esc_html__( 'Error', 'woo-product-finder' ), array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}
	}

	/**
	 * Delete wizard callback function.
	 */
	public function wpfp_wizard_list_delete_callback() {

		$wpfp_nonce = filter_input( INPUT_POST, 'wpfp_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ( isset( $wpfp_nonce ) && ! empty( $wpfp_nonce ) ) && wp_verify_nonce( $wpfp_nonce, 'wpfp_wizard_list_nonce' ) ) {
			$args      = array(
				'wpfp_single_wizard_checkbox' => array(
					'filter' => FILTER_SANITIZE_NUMBER_INT,
					'flags'  => FILTER_REQUIRE_ARRAY,
				)
			);
			$wpfp_data = filter_input_array( INPUT_POST, $args );
			if ( is_array( $wpfp_data['wpfp_single_wizard_checkbox'] ) && array_filter( $wpfp_data['wpfp_single_wizard_checkbox'] ) ) {
				foreach ( $wpfp_data['wpfp_single_wizard_checkbox'] as $wizard_post_id ) {
					// Delete the wizard.
					$this->wpfp_delete_wizard( $wizard_post_id );
				}
			}
			// Notice Actions: error,warning,success,info.
			$notice_json_encode = wp_json_encode( array(
				'notice_action'  => 'success',
				'is_dismissible' => true,
				'message'        => __( 'Selected wizard successfully deleted.', 'woo-product-finder' )
			) );
			set_transient( 'wpfp_admin_notice', $notice_json_encode, MINUTE_IN_SECONDS );
			wp_safe_redirect( html_entity_decode( esc_url( $this->get_wizard_list_url() ) ) );
			exit;
		} else {
			wp_die( esc_html__( 'Somgthing went wrong.', 'woo-product-finder' ),
				esc_html__( 'Error', 'woo-product-finder' ), array(
					'response'  => 403,
					'back_link' => true,
				)
			);
		}

	}

	/**
	 * Delete wizard.
	 *
	 * @param int $wizard_id post type id.
	 */
	public function wpfp_delete_wizard( $wizard_id ) {
		if ( self::wpfp_post_type === get_post_type( $wizard_id ) ) {
			wp_delete_post( $wizard_id, true );
		}
	}


	/**
	 * Filter the wizard status with post status.
	 *
	 * @param string $string current status of wizard.
	 * @param bool $status_db_value wizard status and post type status verify.
	 *
	 * @return int|string wizard status result.
	 */
	public function filter_wizard_status_value( $string, $status_db_value = true ) {
		if ( true === $status_db_value ) {
			if ( isset( $string ) && 1 === (int) $string ) {
				$string = 'publish';
			} else {
				$string = 'draft';
			}
		} else {
			if ( isset( $string ) && ! empty( $string ) && 'publish' === $string ) {
				$string = 1;
			} else {
				$string = 0;
			}
		}

		return $string;
	}

	/**
	 * Get the wizard data.
	 *
	 * @param int $wizard_id pass the wizard id.
	 *
	 * @return array default wizard or wizard data by id.
	 */
	public function wpfp_get_wizard_data( $wizard_id = 0 ) {
		$wizard_data         = array();
		$wizard_default_data = array(
			'wizard_id'          => 0,
			'wizard_title'       => '',
			'wizard_shortcode'   => $this->wpfp_get_wizard_shortcode(),
			'wizard_status'      => $this->filter_wizard_status_value( '', false ),
			'wizard_button_text' => __( 'Save & Continue', 'woocommrece-product-finder-pro' ),
		);

		if ( wpfp_fs()->is__premium_only() ) {
			if ( wpfp_fs()->can_use_premium_code() ) {
				$wizard_default_data['wizard_category'] = array();
			}
		}

		$wpfp_nonce = filter_input( INPUT_GET, 'wpfp_nonce', FILTER_SANITIZE_STRING );
		if ( isset( $wpfp_nonce ) && wp_verify_nonce( $wpfp_nonce, 'wpfp_edit_wizard' ) && self::wpfp_post_type === get_post_type( $wizard_id ) ) {

			$wpfp_wizard_post = get_post( $wizard_id );

			if ( isset( $wpfp_wizard_post->ID ) && ! empty( $wpfp_wizard_post->ID ) ) {
				$wizard_data['wizard_id']        = $wpfp_wizard_post->ID;
				$wizard_data['wizard_shortcode'] = $this->wpfp_get_wizard_shortcode( $wpfp_wizard_post->ID );
			}

			if ( isset( $wpfp_wizard_post->post_title ) && ! empty( $wpfp_wizard_post->post_title ) ) {
				$wizard_data['wizard_title'] = $wpfp_wizard_post->post_title;
			}

			if ( isset( $wpfp_wizard_post->post_status ) && ! empty( $wpfp_wizard_post->post_status ) ) {
				$wizard_data['wizard_status'] = $this->filter_wizard_status_value( $wpfp_wizard_post->post_status, false );
			}
			if ( wpfp_fs()->is__premium_only() ) {
				if ( wpfp_fs()->can_use_premium_code() ) {
					$wizard_woo_cat = wp_get_post_terms( $wizard_id, 'product_cat', array( 'fields' => 'ids' ) );
					if ( ! empty( $wizard_woo_cat ) && ! is_wp_error( $wizard_woo_cat ) ) {
						$wizard_data['wizard_category'] = $wizard_woo_cat;
					}
				}
			}
		}

		return wp_parse_args( $wizard_data, $wizard_default_data );
	}


	/**
	 * Get shortcode.
	 *
	 * @param int $wizard_id post wizard id.
	 *
	 * @return string
	 * @since    1.0.0
	 *
	 */
	public function wpfp_get_wizard_shortcode( $wizard_id = 0 ) {
		if ( 0 !== $wizard_id ) {
			return '[wpfp id=' . $wizard_id . ']';
		}

		return '[wpfp]';
	}


	/**
	 * Search the attribute name ajax.
	 */
	public function wpfp_search_attribute_name_ajax_callback() {

		check_ajax_referer( 'wpfp_script_security_nonce', 'security' );

		$wizard_id              = filter_input( INPUT_GET, 'wizardID', FILTER_SANITIZE_STRING );
		$search_query_parameter = filter_input( INPUT_GET, 'searchQueryParameter', FILTER_SANITIZE_STRING );
		$search_query_parameter = isset( $search_query_parameter ) ? (string) wc_clean( wp_unslash( $search_query_parameter ) ) : '';
		$wizard_selected_terms  = wp_get_post_terms( $wizard_id, 'product_cat', array( "fields" => "ids" ) );

		if ( empty( $search_query_parameter ) ) {
			wp_die();
		}

		global $wpdb;
		$search_custom_value = isset( $search_query_parameter ) ? $search_query_parameter : '';
		if ( ! empty( $wizard_selected_terms ) && isset( $wizard_selected_terms ) && array_filter( $wizard_selected_terms ) ) {
			$wizard_selected_terms_implode = get_imploded_array( $wizard_selected_terms );
			$wpfp_query_results            = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT ID,wpfp_pm.meta_value FROM {$wpdb->prefix}posts wpfp_p 
					INNER JOIN {$wpdb->prefix}postmeta wpfp_pm ON ( wpfp_p.ID = wpfp_pm.post_id ) 
					LEFT JOIN {$wpdb->prefix}term_relationships wpfp_tr ON wpfp_tr.object_id = wpfp_p.ID 
					LEFT JOIN {$wpdb->prefix}term_taxonomy wpfp_tt on wpfp_tt.term_taxonomy_id = wpfp_tr.term_taxonomy_id
					LEFT JOIN {$wpdb->prefix}terms wpfp_t ON wpfp_t.term_id = wpfp_tr.term_taxonomy_id 
					WHERE post_type ='%s' 
					AND wpfp_t.term_id IN('%s')
					AND ( wpfp_pm.meta_key = '%s' )
					AND ( wpfp_pm.meta_value LIKE '%s' )
					AND post_status = '%s'",
					array(
						'product',
						$wizard_selected_terms_implode,
						'_product_attributes',
						'%' . $search_custom_value . '%',
						'publish'
					)
				)
			);
		} else {
			$wpfp_query_results = $wpdb->get_results(
				$wpdb->prepare( "SELECT ID,wpfp_pm.meta_value FROM {$wpdb->prefix}posts wpfp_p 
					INNER JOIN {$wpdb->prefix}postmeta wpfp_pm ON ( wpfp_p.ID = wpfp_pm.post_id )
					WHERE post_type ='%s' 
					AND ( wpfp_pm.meta_key = '%s' )
					AND ( wpfp_pm.meta_value LIKE '%s' )
					AND post_status = '%s'", array(
						'product',
						'_product_attributes',
						'%' . $search_custom_value . '%',
						'publish'
					)
				)
			);
		}

		$attribute_name_array = array();
		if ( ! empty( $wpfp_query_results ) && is_array( $wpfp_query_results ) ) {
			$attributes_name_and_value_array        = array();
			$custom_attributes_name_and_value_array = array();

			if ( ! empty( $wpfp_query_results ) && is_array( $wpfp_query_results ) ) {
				foreach ( $wpfp_query_results as $wpfp_query_result ) {
					$maybe_unserialize_product_attributes = maybe_unserialize( $wpfp_query_result->meta_value );
					$custom_product_attributes_array      = array();
					if ( isset( $maybe_unserialize_product_attributes ) && is_array( $maybe_unserialize_product_attributes ) ) {
						foreach ( $maybe_unserialize_product_attributes as $unserialize_pa_key => $unserialize_pa_value ) {
							if ( strpos( $unserialize_pa_key, 'pa_' ) !== false ) {
								$wpfp_product_terms       = wc_get_product_terms( $wpfp_query_result->ID, $unserialize_pa_value['name'], array( 'fields' => 'names' ) );
								$wpfp_attributes_value    = apply_filters( 'woocommerce_attribute', wptexturize( get_imploded_array( $wpfp_product_terms, ' | ' ) ), ' ', $wpfp_product_terms );
								$wpfp_attributes_value_ex = trim( $wpfp_attributes_value );
								if ( ! empty( $wpfp_attributes_value_ex ) ) {
									$attributes_name_and_value_array[ $unserialize_pa_key ][] = trim( $wpfp_attributes_value_ex );
								}
							} else {
								if ( ! empty( $unserialize_pa_value['value'] ) ) {
									$custom_attributes_name_and_value_array[ $unserialize_pa_key ][] = $unserialize_pa_value['name'] . "==" . trim( $unserialize_pa_value['value'] );
								}
							}
							$custom_product_attributes_array[ $unserialize_pa_key ] = $wpfp_attributes_value_ex;
						}
					}
				}
			}

			if ( ! empty( $attributes_name_and_value_array ) && is_array( $attributes_name_and_value_array ) ) {
				foreach ( $attributes_name_and_value_array as $n_key => $n_value ) {
					if ( ! empty( $n_value ) ) {
						$value_ex     = array();
						$value_simple = array();
						foreach ( $n_value as $value ) {
							if ( ! empty( $value ) || '' !== $value ) {
								if ( strpos( $value, ' | ' ) !== false ) {
									$value_ex[] = get_exploded_string( trim( $value ), ' | ' );
								} else {
									$value_simple[] = array( trim( $value ) );
								}
							}
						}
						$nwe_value_arr  = array();
						$value_ex_array = array_merge( $value_ex, $value_simple );
						foreach ( $value_ex_array as $value_ex_array_val ) {
							foreach ( $value_ex_array_val as $n_sub_val ) {
								$nwe_value_arr[] = trim( $n_sub_val );
							}
						}
						$unique_array_value = array_unique( $nwe_value_arr );
						$unique_array       = get_imploded_array( $unique_array_value, '|' );
					}
					$attribute_name_array[] = array(
						'value'      => addslashes( wc_attribute_label( $n_key ) ) . '==' . trim( $n_key ),
						'data_name'  => $n_key,
						'data_value' => $unique_array,
						'label'      => wc_attribute_label( $n_key )
					);
				}
			}

			if ( ! empty( $custom_attributes_name_and_value_array ) && is_array( $custom_attributes_name_and_value_array ) ) {
				foreach ( $custom_attributes_name_and_value_array as $c_n_key => $c_n_value ) {
					foreach ( $c_n_value as $value ) {
						$val_ex                 = get_exploded_string( $value, '==' );
						$attribute_name_array[] = array(
							'value'      => addslashes( $val_ex[0] ) . '==' . trim( $c_n_key ),
							'data_name'  => $c_n_key,
							'data_value' => $val_ex[1],
							'label'      => wc_attribute_label( $val_ex[0] )
						);
					}
				}
			}
		}
		wp_send_json( $attribute_name_array );
		wp_die();
	}

	/**
	 * Admin notice.
	 */
	public function wpfp_admin_notices() {
		$wpfp_admin_notice = get_transient( 'wpfp_admin_notice' );
		if ( false !== $wpfp_admin_notice ) {
			$notice_array = json_decode( $wpfp_admin_notice, true );
			if ( true === $notice_array['is_dismissible'] ) {
				$class = "notice notice-{$notice_array['notice_action']} is-dismissible";
			} else {
				$class = "notice notice-{$notice_array['notice_action']}";
			}
			$message = $notice_array['message'];
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
			delete_transient( 'wpfp_admin_notice' );
		}
	}

	/**
	 * Create a menu for plugin.
	 *
	 * @param string $current current poge.
	 */
	public function wpfp_menus( $current = 'wpfp-list' ) {

		$menu_slug   = 'wpfp-add-wizard';
		$menu_title  = __( 'Add New Wizard', 'woo-product-finder' );
		$menu_url    = esc_url( $this->get_wpfp_url( array( 'page' => 'wpfp-add-wizard' ) ) );
		$wpfp_action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
		if ( ( 'edit' === $wpfp_action && 'wpfp-edit-wizard' === $current ) || 'setting' === $wpfp_action && 'wpfp-wizard-setting' === $current ) {
			$wizard_id  = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_STRING );
			$menu_slug  = $current;
			$menu_title = __( 'Edit Wizard', 'woo-product-finder' );
			$menu_url   = esc_url( $this->get_edit_wizard_url( $wizard_id ) );
		}

		$wpfp_menus = array(
			'main_menu' => array(
				'wpfp-list'        => array(
					'menu_title' => __( 'Manage Questions', 'woo-product-finder' ),
					'menu_slug'  => 'wpfp-list',
					'menu_url'   => esc_url( $this->get_wizard_list_url() )
				),
				$menu_slug         => array(
					'menu_title' => $menu_title,
					'menu_slug'  => $menu_slug,
					'menu_url'   => $menu_url
				),
				'wpfp-get-started' => array(
					'menu_title' => __( 'About Plugin', 'woo-product-finder' ),
					'menu_slug'  => 'wpfp-get-started',
					'menu_url'   => esc_url( $this->get_wpfp_url( array( 'page' => 'wpfp-get-started' ) ) ),
					'sub_menu'   => array(
						'wpfp-get-started' => array(
							'menu_title' => __( 'Getting Started', 'woo-product-finder' ),
							'menu_slug'  => 'wpfp-get-started',
							'menu_url'   => esc_url( $this->get_wpfp_url( array( 'page' => 'wpfp-get-started' ) ) )
						),
						'wpfp-information' => array(
							'menu_title' => __( 'Quick info', 'woo-product-finder' ),
							'menu_slug'  => 'wpfp-information',
							'menu_url'   => esc_url( $this->get_wpfp_url( array( 'page' => 'wpfp-information' ) ) )
						),
					)
				),
				'dotstore'         => array(
					'menu_title' => __( 'Dotstore', 'woo-product-finder' ),
					'menu_slug'  => 'dotstore',
					'menu_url'   => 'javascript:void(0)',
					'sub_menu'   => array(
						'woocommerce-plugins' => array(
							'menu_title'  => __( 'WooCommerce Plugins', 'woo-product-finder' ),
							'menu_slug'   => 'woocommerce-plugins',
							'menu_url'    => esc_url( 'http://www.thedotstore.com/woocommerce-plugins/' ),
							'menu_target' => '_blank'
						),
						'wordpress-plugins'   => array(
							'menu_title'  => __( 'Wordpress Plugins', 'woo-product-finder' ),
							'menu_slug'   => 'wordpress-plugins',
							'menu_url'    => esc_url( 'http://www.thedotstore.com/wordpress-plugins/' ),
							'menu_target' => '_blank'
						),
						'contact-support'     => array(
							'menu_title'  => __( 'Contact Support', 'woo-product-finder' ),
							'menu_slug'   => 'contact-support',
							'menu_url'    => esc_url( 'https://www.thedotstore.com/support/' ),
							'menu_target' => '_blank'
						),
					)
				),
			),
		);
		?>
        <div class="dots-menu-main">
            <nav>
                <ul>
					<?php
					$main_current = $current;
					$sub_current  = $current;
					foreach ( $wpfp_menus['main_menu'] as $menu_slug => $wpfp_menu ) {
						if ( 'wpfp-information' === $main_current ) {
							$main_current = 'wpfp-get-started';
						}
						$class = ( $menu_slug === $main_current ) ? 'active' : '';
						?>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $wpfp_menu['menu_url'] ); ?>">
								<?php echo esc_html( $wpfp_menu['menu_title'] ); ?>
                            </a>
							<?php if ( isset( $wpfp_menu['sub_menu'] ) && ! empty( $wpfp_menu['sub_menu'] ) ) { ?>
                                <ul class="sub-menu">
									<?php foreach ( $wpfp_menu['sub_menu'] as $sub_menu_slug => $wpfp_sub_menu ) {
										$sub_class   = ( $sub_current === $sub_menu_slug ) ? 'active' : '';
										$menu_target = isset( $wpfp_sub_menu['menu_target'] ) ? $wpfp_sub_menu['menu_target'] : '';
										?>
                                        <li>
                                            <a class="dotstore_plugin <?php echo esc_attr( $sub_class ); ?>" href="<?php echo esc_url( $wpfp_sub_menu['menu_url'] ); ?>" target="<?php echo esc_attr( $menu_target ); ?>">
												<?php echo esc_html( $wpfp_sub_menu['menu_title'] ); ?>
                                            </a>
                                        </li>
									<?php } ?>
                                </ul>
							<?php } ?>
                        </li>
						<?php
					}
					?>
                </ul>
            </nav>
        </div>
		<?php
	}

	/**
	 * Get the edit wizard URL.
	 *
	 * @param int $wizard_id Wizard Post ID.
	 * @param int $current_page Current page ID.
	 * @param bool $wpfp_post_url Is admin Post url or not.
	 *
	 * @return string Wizard edit URL.
	 */
	public function get_edit_wizard_url( $wizard_id, $current_page = 0, $wpfp_post_url = false ) {

		$query_argument = array(
			'wrd_id' => esc_attr( $wizard_id ),
			'page'   => 'wpfp-edit-wizard',
			'action' => 'edit',
		);
		if ( 0 !== $current_page ) {
			$query_argument['paged'] = $current_page;
		}

		return wp_nonce_url( $this->get_wpfp_url( $query_argument, $wpfp_post_url ), 'wpfp_edit_wizard', 'wpfp_nonce' );
	}


	/**
	 * Get Setting wizard URL.
	 *
	 * @param int $wizard_id Wizard Post ID.
	 * @param int $current_page Current page ID.
	 * @param bool $wpfp_post_url Is admin Post url or not.
	 *
	 * @return string Wizard setting URL.
	 */
	public function get_setting_wizard_url( $wizard_id, $current_page = 0, $wpfp_post_url = false ) {

		$query_argument = array(
			'wrd_id' => esc_attr( $wizard_id ),
			'page'   => 'wpfp-wizard-setting',
			'action' => 'setting',
		);
		if ( 0 !== $current_page ) {
			$query_argument['paged'] = $current_page;
		}

		return wp_nonce_url( $this->get_wpfp_url( $query_argument, $wpfp_post_url ), 'wpfp_setting_wizard', 'wpfp_nonce' );
	}

	/**
	 * Delete Wizard URL.
	 *
	 * @param int $wizard_id Wizard Post ID.
	 * @param int $current_page Current page ID.
	 * @param bool $wpfp_post_url Is admin Post url or not.
	 *
	 * @return string Wizard delete URL.
	 */
	public function get_delete_wizard_url( $wizard_id, $current_page = 0, $wpfp_post_url = false ) {

		$query_argument = array(
			'wrd_id' => esc_attr( $wizard_id ),
			'action' => 'wpfp_delete_wizard',
		);

		if ( 0 !== $current_page ) {
			$query_argument['paged'] = $current_page;
		}

		return wp_nonce_url( $this->get_wpfp_url( $query_argument, $wpfp_post_url ), 'wpfp_delete_nonce', 'wpfp_nonce' );

	}

	/**
	 * Wizard list page URL.
	 *
	 * @param int $current_page Current page ID.
	 * @param bool $wpfp_post_url Is admin Post url or not.
	 *
	 * @return string Wizard list page.
	 */
	public function get_wizard_list_url( $current_page = 0, $wpfp_post_url = false ) {
		$query_argument = array(
			'page' => 'wpfp-list',
		);
		if ( 0 !== $current_page ) {
			$query_argument['paged'] = $current_page;
		}

		return $this->get_wpfp_url( $query_argument, $wpfp_post_url );
	}

	/**
	 * Create a URL based on argument.
	 *
	 * @param array $wpfp_argument Query argument array.
	 * @param bool $wpfp_post_url Is admin Post url or not.
	 *
	 * @return string URL with adding argument value.
	 */
	public function get_wpfp_url( $wpfp_argument, $wpfp_post_url = false ) {

		if ( true === $wpfp_post_url ) {
			return add_query_arg( $wpfp_argument, admin_url( 'admin-post.php' ) );
		}

		return add_query_arg( $wpfp_argument, admin_url( 'admin.php' ) );
	}

	/**
	 * Create input html.
	 *
	 * @param array $args attribute array for input.
	 */
	public function wpfp_input_fields( $args ) {

		if ( ! isset( $args['id'] ) ) {
			$args['id'] = '';
		}
		if ( ! isset( $args['name'] ) ) {
			$args['name'] = '';
		}
		if ( ! isset( $args['class'] ) ) {
			$args['class'] = '';
		}

		if ( ! isset( $args['placeholder'] ) ) {
			$args['placeholder'] = '';
		}
		if ( ! isset( $args['value'] ) ) {
			$args['value'] = '';
		}

		if ( isset( $args['extra'] ) ) {
			if ( isset( $args['type'] ) ) {
				printf(
					'<input type="%1$s" name="%2$s" value="%3$s" id="%4$s" class="%5$s" placeholder="%6$s" onfocus="%7$s" %8$s %9$s %10$s  />',
					esc_attr( $args['type'] ),
					esc_attr( $args['name'] ),
					esc_attr( $args['value'] ),
					esc_attr( $args['id'] ),
					esc_attr( $args['class'] ),
					esc_attr( $args['placeholder'] ),
					( isset( $args['extra']['onfocus'] ) && ( true === $args['extra']['onfocus'] ) ) ? esc_js( 'this.select();' ) : '',
					esc_attr( ( isset( $args['extra']['required'] ) && ( true === $args['extra']['required'] ) ) ? 'required' : '' ),
					esc_attr( ( isset( $args['extra']['readonly'] ) && ( true === $args['extra']['readonly'] ) ) ? 'readonly' : '' ),
					esc_attr( ( isset( $args['extra']['is_add'] ) && ( true === $args['extra']['is_add'] ) ) ? 'disabled' : '' )
				);
			}
		} else {
			if ( isset( $args['type'] ) ) {
				printf(
					'<input type="%1$s" name="%2$s" value="%3$s" id="%4$s" class="%5$s" placeholder="%6$s"  />',
					esc_attr( $args['type'] ),
					esc_attr( $args['name'] ),
					esc_attr( $args['value'] ),
					esc_attr( $args['id'] ),
					esc_attr( $args['class'] ),
					esc_attr( $args['placeholder'] ) );
			}
		}
	}


}


