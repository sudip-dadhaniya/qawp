<?php

/**
 * Class Woocommerce_Product_Finder_Pro_Shortcode
 */
class Woocommerce_Product_Finder_Pro_Shortcode extends Woocommerce_Product_Finder_Pro_Settings {

	/**
	 * Post type name.
	 */
	const wpfp_post_type = 'wc_wpfp_wizard';

	/**
	 * Current object for shortcode.
	 * @var null
	 */
	private static $current = null;

	/**
	 * Wizard id.
	 * @var int
	 */
	private $wizard_id;

	/**
	 * Wizard status.
	 * @var string
	 */
	private $status;

	/**
	 * Wizard title.
	 * @var string
	 */
	private $wizard_title;

	/**
	 * Wizard selected categories.
	 * @var array
	 */
	private $categories = array();

	/**
	 * Wizard properties like meta.
	 * @var array
	 */
	private $properties = array();

	/**
	 * Uniq ID for tag.
	 * @var
	 */
	private $unit_tag;

	/**
	 * Current questions keys.
	 * @var string
	 */
	private $questions_keys;

	/**
	 * Current Questions keys array format.
	 * @var array
	 */
	private $questions_keys_array = array();


	/**
	 * Woocommerce_Product_Finder_Pro_Shortcode constructor.
	 *
	 * @param null $post post ID or post Object.
	 */
	private function __construct( $post = null ) {
		$post = get_post( $post );

		if ( $post and self::wpfp_post_type === get_post_type( $post ) ) {
			$this->set_wizard_id( $post->ID );
			$this->set_wizard_title( $post->post_title );

			$properties = $this->get_properties();

			foreach ( $properties as $key ) {
				if ( metadata_exists( 'post', $post->ID, '_' . $key ) ) {
					$properties[ $key ] = json_decode( get_post_meta( $post->ID, '_' . $key, true ), true );
				} elseif ( metadata_exists( 'post', $post->ID, $key ) ) {
					$properties[ $key ] = json_decode( get_post_meta( $post->ID, $key, true ), true );
				}
			}

			$this->set_wizard_status( $post->post_status );
			$this->set_categories( $post->ID );
			$this->set_properties( $properties );
			$this->set_question_keys();

		}

		do_action( 'wpfp_wizard', $this );
	}

	/**
	 * Get current object.
	 * @return null current object or null.
	 */
	public static function get_current() {
		return self::$current;
	}

	/**
	 * This function call instance of post.
	 *
	 * @param object $post current wizard post.
	 *
	 * @return bool|Woocommerce_Product_Finder_Pro_Shortcode
	 */
	public static function get_instance( $post ) {

		$post = get_post( $post );

		if ( ! $post or self::wpfp_post_type !== get_post_type( $post ) ) {
			return false;
		}

		return self::$current = new self( $post );
	}

	/**
	 * Inline style adding by wizard id.
	 *
	 * @param int $wizard_id
	 */
	public function wpfp_add_inline_css( $wizard_id = 0 ) {
		if ( 0 === $wizard_id ) {
			return;
		}

		$customization_css = '';
		if ( ! empty ( $this->get_text_color_wizard_title() ) ) {
			$customization_css .= "#wizard-id-{$wizard_id} h1{color:{$this->get_text_color_wizard_title()} !important}";
		}

		if ( ! empty ( $this->get_questions_background_image_id() ) ) {
			$attachment_url    = wp_get_attachment_url( $this->get_questions_background_image_id() );
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-question-list-wizard {background-image: url({$attachment_url}) !important}";
		}

		if ( ! empty ( $this->get_background_color() ) ) {
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-wizard-list-restart-button,";
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-question-title,";
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-product-headline,";
			$customization_css .= ".wpfp-wizard-{$wizard_id} .page-numbers.current";
			$customization_css .= "{background-color:{$this->get_background_color()} !important;}";
		}

		if ( ! empty ( $this->get_text_color() ) ) {
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-wizard-list-restart-button,";
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-question-title,";
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-product-headline,";
			$customization_css .= ".wpfp-wizard-{$wizard_id} .page-numbers.current";
			$customization_css .= "{color: {$this->get_text_color()} !important;}";
		}
		if ( ! empty ( $this->get_background_next_pre_button_color() ) ) {
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-page-nav-buttons .wpfp-button";
			$customization_css .= "{background-color:{$this->get_background_next_pre_button_color()} !important;}";
		}
		if ( ! empty ( $this->get_text_next_pre_button_color() ) ) {
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-page-nav-buttons .wpfp-button";
			$customization_css .= "{color:{$this->get_text_next_pre_button_color()} !important;}";
		}
		if ( ! empty ( $this->get_background_color_for_options() ) ) {
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-option-action";
			$customization_css .= "{background-color:{$this->get_background_color_for_options()} !important; border-color:{$this->get_background_color_for_options()} !important;}";
		}
		if ( ! empty ( $this->get_text_color_for_options() ) ) {
			$customization_css .= ".wpfp-wizard-{$wizard_id} .wpfp-option-action .wpfp-option-label-text";
			$customization_css .= "{color:{$this->get_text_color_for_options()} !important;}";
		}
		wp_register_style( 'wpfp-custom-wizard-style', false );
		wp_enqueue_style( 'wpfp-custom-wizard-style' );
		wp_add_inline_style( 'wpfp-custom-wizard-style', $customization_css );

	}

	/**
	 * Set the wizard id.
	 *
	 * @param int $id current wizard id.
	 */
	public function set_wizard_id( $id ) {
		$this->set_wizard_setting_data( wpfp_get_wizard_setting_data( $id ) );
		$this->wpfp_add_inline_css( $id );
		$this->wizard_id = (int) $id;
	}

	/**
	 * Get wizard id.
	 * @return int current wizard id.
	 */
	public function get_wizard_id() {
		return $this->wizard_id;
	}

	/**
	 * Set wizard title.
	 *
	 * @param string $title current wizard title.
	 */
	public function set_wizard_title( $title ) {
		$this->wizard_title = (string) $title;
	}

	/**
	 * Get wizard title.
	 * @return string current wizard title.
	 */
	public function get_wizard_title() {
		return $this->wizard_title;
	}

	/**
	 * Set wizard status.
	 *
	 * @param $status
	 */
	public function set_wizard_status( $status ) {
		$this->status = $status;
	}

	/**
	 * Get wizard status.
	 * @return string
	 */
	public function get_wizard_status() {
		return $this->status;
	}

	/**
	 * Set wizard properties.
	 *
	 * @param array $properties current wizard properties.
	 */
	public function set_properties( $properties ) {
		$this->properties = (array) $properties;
	}

	/**
	 * Get wizard properties.
	 * @return array current wizard properties.
	 */
	public function get_properties() {
		$properties = (array) $this->properties;

		$properties = wp_parse_args( $properties, array(
			'wpfp_questions_and_options_data',
			'wpfp_wizard_setting_data'

		) );

		$properties = (array) apply_filters( 'wpfp_wizard_properties', $properties, $this );

		return $properties;
	}

	/**
	 * Set wizard question keys.
	 */
	public function set_question_keys() {
		$question_keys = isset( $this->properties['wpfp_questions_and_options_data'] ) ? array_keys( $this->properties['wpfp_questions_and_options_data'] ) : array();

		if ( array_filter( $question_keys ) ) {
			$this->questions_keys       = get_imploded_array( $question_keys );
			$this->questions_keys_array = $question_keys;
		}
	}

	/**
	 * Get the wizard questions and options data.
	 * @return mixed
	 */
	public function get_wizard_questions_and_options_data() {
		return isset( $this->properties['wpfp_questions_and_options_data'] ) ? $this->properties['wpfp_questions_and_options_data'] : array();
	}

	public function get_wizard_questions_count() {
		return count( $this->properties['wpfp_questions_and_options_data'] );
	}

	/**
	 * Get the wizard setting data.
	 * @return mixed
	 */
	public function get_wizard_setting_data() {
		return $this->properties['wpfp_wizard_setting_data'];
	}

	/**
	 * Get wizard question keys.
	 *
	 * @param bool $array
	 *
	 * @return array|string
	 */
	public function get_question_keys( $array = false ) {
		if ( true === $array ) {
			return $this->questions_keys_array;
		}

		return $this->questions_keys;
	}


	/**
	 * Set wizard selected categories.
	 *
	 * @param $id
	 */
	public function set_categories( $id ) {
		$wizard_woo_cat = wp_get_post_terms( $id, 'product_cat', array( 'fields' => 'ids' ) );
		if ( ! empty( $wizard_woo_cat ) && ! is_wp_error( $wizard_woo_cat ) ) {
			$this->categories = $wizard_woo_cat;
		}
	}

	/**
	 * Get wizard selected categories.
	 *
	 * @param bool $implode
	 * @param string $glue
	 *
	 * @return string|array
	 */
	public function get_categories( $implode = false, $glue = ',' ) {
		if ( true === $implode ) {
			return get_imploded_array( $this->categories, $glue );
		}

		return $this->categories;
	}

	/**
	 * Get unit tag.
	 * @return mixed
	 */
	public function get_unit_tag() {
		return $this->unit_tag;
	}

	/**
	 * Wizard output html.
	 * @return string HTML of wizard.
	 */
	public function wizard_output() {
		$url = wpfp_get_request_uri();

		$frag = strstr( $url, '#' );
		if ( isset( $frag ) ) {
			$url = substr( $url, 0, - strlen( $frag ) );
		}

		$class        = 'wpfp-wizard';
		$class        = apply_filters( 'wpfp_wizard_class_attr', $class );
		$enctype      = apply_filters( 'wpfp_wizard_enctype', '' );
		$autocomplete = apply_filters( 'wpfp_wizard_autocomplete', '' );

		$novalidate = apply_filters( 'wpfp_wizard_novalidate',
			wpfp_support_html5() );

		$this->unit_tag = self::generate_unit_tag( $this->get_wizard_id() );

		$html = sprintf( '<div %s>',
			wpfp_format_atts( array(
				'role'  => 'form',
				'class' => 'wpfp wpfp-wizard-' . $this->get_wizard_id(),
				'id'    => $this->get_unit_tag(),
			) )
		);

		$url  = apply_filters( 'wpcf7_wizard_action_url', $url );
		$atts = array(
			'action'       => esc_url( $url ),
			'method'       => 'post',
			'class'        => $class,
			'enctype'      => wpfp_enctype_value( $enctype ),
			'autocomplete' => $autocomplete,
			'novalidate'   => $novalidate ? 'novalidate' : '',
		);

		$atts = wpfp_format_atts( $atts );

		$html .= sprintf( '<form %s>', $atts ) . "\n";
		$html .= $this->wizard_hidden_fields();
		$html .= $this->create_wizard_html();

		$html .= '</form>';
		$html .= '</div>';

		return $html;


	}

	/**
	 * Question class.
	 *
	 * @param int $number number if question count.
	 * @param int $wizard_id wizard id.
	 *
	 * @return mixed|void array of class for question.
	 */
	public function get_questions_class( $number, $wizard_id ) {
		$question_class = array(
			'wpfp-question wpfp-question-li wpfp-hidden'
		);
		if ( 1 === $number ) {
			$question_class[] = 'wpfp-current';
		}
		if ( 2 === $number ) {
			$question_class[] = 'wpfp-next';
		}

		return apply_filters( 'wpfp_questions_class', $question_class, $wizard_id );
	}

	/**
	 * Wizard action html.
	 */
	public function wpfp_wizard_action_html() {
		if ( 0 !== $this->get_wizard_questions_count() ) {
			?>
            <div class="wpfp-footer">
                <div class="wpfp-page-nav-buttons">
					<?php
					if ( 1 < $this->get_wizard_questions_count() ) {
						printf( '<button type="button" class="%1$s" data-wizard-id="%2$s" disabled>%3$s</button>',
							esc_attr( 'wpfp-button wpfp-button-previous' ),
							esc_attr( $this->get_wizard_id() ),
							esc_attr( $this->get_back_title() )
						);
					}
					if ( 1 !== $this->get_wizard_questions_count() ) {
						printf( '<button type="button" class="%1$s" data-wizard-id="%2$s">%3$s</button>',
							esc_attr( 'wpfp-button wpfp-button-next' ),
							esc_attr( $this->get_wizard_id() ),
							esc_attr( $this->get_next_title() )
						);
					}

					$one_question_class = '';
					if ( 1 === $this->get_wizard_questions_count() ) {
						$one_question_class = ' wpfp-one-question';
					}
					$wizard_result_display_mode = 'no';
					if ( wpfp_fs()->is__premium_only() ) {
						if ( wpfp_fs()->can_use_premium_code() ) {
							$wizard_result_display_mode = $this->get_wizard_result_display_mode();
						}
					}
					if ( 'yes' === $wizard_result_display_mode ) {
						printf( '<button type="button" class="%1$s" data-wizard-id="%2$s" data-nonce="%3$s" disabled>%4$s</button>',
							esc_attr( 'wpfp-button wpfp-button-show-result' . $one_question_class ),
							esc_attr( $this->get_wizard_id() ),
							esc_attr( wp_create_nonce( $this->get_wizard_id() . $this->get_wizard_result_display_mode() ) ),
							esc_attr( $this->get_show_result_title() )
						);
					} else {
						printf( '<button type="button" class="%1$s" data-wizard-id="%2$s" disabled>%3$s</button>',
							esc_attr( 'wpfp-button wpfp-button-show-result' . $one_question_class ),
							esc_attr( $this->get_wizard_id() ),
							esc_attr( $this->get_show_result_title() )
						);
					}
					?>
                </div>
                <div class="wpfp-step-wrapper">
					<?php
					for ( $question_number = 1; $question_number <= $this->get_wizard_questions_count(); $question_number ++ ) {
						$steps_class = array( 'wpfp-step' );
						if ( 1 === $question_number ) {
							$steps_class[] = 'active';
						}

						$is_pro = ( $question_number <= 2 );
						if ( wpfp_fs()->is__premium_only() ) {
							if ( wpfp_fs()->can_use_premium_code() ) {
								$is_pro = true;
							}
						}
						if ( true === $is_pro ) {
							printf( '<span class="%1$s" id="wpfp-step-number-%2$s"></span>',
								esc_attr( get_imploded_array( $steps_class, ' ' ) ),
								esc_attr( $question_number )
							);
						}
					}
					?>
                </div>
            </div>
			<?php
		}
	}

	/**
	 * Created the Wizard html with steps.
	 * @return false|string HTML of Wizard.
	 */
	public function create_wizard_html() {
		ob_start();
		?>
        <div class="wpfp-wizard">
            <div class="wpfp-question-list-wizard">
                <div class="wpfp-head">
                    <div class="wpfp-wizard-header" id="wizard-id-<?php echo esc_attr( $this->get_wizard_id() ); ?>">
                        <h1><?php echo esc_html( $this->get_wizard_title() ); ?></h1>
                    </div>
					<?php if ( ! empty( $this->get_wizard_questions_and_options_data() ) && array_filter( $this->get_wizard_questions_and_options_data() ) ) { ?>
                        <div class="wpfp-wizard-list-restart">
                            <button class="wpfp-wizard-list-restart-button" type="reset" data-title="<?php echo esc_attr( $this->get_reload_title() ); ?>">
                                <span class="wpf-reset-icon">&#x21bb;</span>
                                <span class="wpfp-list-icon"><?php echo esc_attr( $this->get_restart_title() ); ?></span>
                            </button>
                        </div>
					<?php } ?>
                </div>
				<?php if ( ! empty( $this->get_wizard_questions_and_options_data() ) && array_filter( $this->get_wizard_questions_and_options_data() ) ) { ?>
                <div class="wpfp-wizard-body wpfp-wizard-<?php echo esc_attr( $this->get_wizard_id() ); ?>" data-wizard-id="<?php echo esc_attr( $this->get_wizard_id() ); ?>">
                    <ul class="wpfp-questions" id="wpfp_wizard_key_<?php echo esc_attr( $this->get_wizard_id() ); ?>">
						<?php
						$question_number_count = 1;
						$is_question_available = false;
						$is_option_available   = false;
						foreach ( $this->get_wizard_questions_and_options_data() as $questions_and_options_data ) {

							$is_pro = ( $question_number_count <= 2 );
							if ( wpfp_fs()->is__premium_only() ) {
								if ( wpfp_fs()->can_use_premium_code() ) {
									$is_pro = true;
								}
							}
							if ( true === $is_pro ) {

								$wpfp_questions      = $questions_and_options_data['questions'];
								$wpfp_questions_key  = $wpfp_questions['key'];
								$wpfp_questions_name = $wpfp_questions['name'];
								$wpfp_questions_type = 'radio';
								if ( wpfp_fs()->is__premium_only() ) {
									if ( wpfp_fs()->can_use_premium_code() ) {
										$wpfp_questions_type = $wpfp_questions['question_type'];
									}
								}

								if ( ( isset( $wpfp_questions_key ) && ! empty( $wpfp_questions_key ) ) && ( isset( $wpfp_questions_name ) && ! empty( $wpfp_questions_name ) ) ) {
									$is_question_available = true;
									$question_class        = $this->get_questions_class( $question_number_count, $this->get_wizard_id() );
									?>
                                    <li class="<?php echo esc_attr( get_imploded_array( $question_class, ' ' ) ); ?>" id="<?php echo esc_attr( $wpfp_questions_key ); ?>">
                                        <div class="wpfp-question-head">
                                            <div class="wpfp-question-title"><?php echo esc_html( $wpfp_questions_name ); ?></div>
                                        </div>
                                        <ul class="wpfp-options">
											<?php
											if ( isset( $questions_and_options_data['options'] ) && ! empty( $questions_and_options_data['options'] ) ) {
												$is_option_available = true;
												foreach ( $questions_and_options_data['options'] as $wpfp_option_key => $wpfp_option ) {
													$wpfp_option_name                   = $wpfp_option['name'];
													$wpfp_option_image_id               = ( isset( $wpfp_option['image_id'] ) && ! empty( $wpfp_option['image_id'] ) ) ? $wpfp_option['image_id'] : 0;
													$wpfp_option_attribute_name         = ( isset( $wpfp_option['attribute_name'] ) && ! empty( $wpfp_option['attribute_name'] ) ) ? $wpfp_option['attribute_name'] : '';
													$wpfp_option_attribute_name_explode = get_exploded_string( $wpfp_option_attribute_name, '==' );
													$wpfp_option_attribute_value_array  = ( isset( $wpfp_option['attribute_value'] ) && ! empty( $wpfp_option['attribute_value'] ) ) ? $wpfp_option['attribute_value'] : array();
													$wpfp_option_attribute_value        = get_imploded_array( $wpfp_option_attribute_value_array );
													if ( ( isset( $wpfp_option_key ) && ! empty( $wpfp_option_key ) ) && ( isset( $wpfp_option_name ) && ! empty( $wpfp_option_name ) ) ) {
														$div_class = "col-wpfp-md-" . $this->get_option_row_item();
														$input_id  = self::generate_unit_tag( $this->get_wizard_id(), $wpfp_option_key );
														?>
                                                        <li class="wpfp-option wpfp-option-li <?php echo esc_attr( $div_class ); ?>" id="wpfp_<?php echo esc_attr( $wpfp_option_key ); ?>">
															<?php if ( 0 !== $wpfp_option_image_id ) { ?>
                                                                <div class="wpfp-option-image wpfp-option-selector">
                                                                    <img class="wpfp-attachment wpfp-desktop-image wpfp-active-image" src="<?php echo esc_url( wp_get_attachment_url( $wpfp_option_image_id ) ); ?>" alt="<?php esc_html( $wpfp_option_name ); ?>">
                                                                </div>
															<?php } ?>
                                                            <div class="wpfp-option-action wpfp-option-<?php echo esc_attr( $wpfp_questions_type ); ?>">
                                                                <input type="<?php echo esc_attr( $wpfp_questions_type ); ?>" id="<?php echo esc_attr( $input_id ); ?>"
                                                                       data-id="<?php echo esc_attr( $wpfp_option_key ); ?>"
                                                                       name="option_name_<?php echo esc_attr( $wpfp_questions_key ); ?>"
                                                                       class="wpfp-input-option wpfp-<?php echo esc_attr( $wpfp_questions_type ); ?>"
                                                                       value="1"
                                                                       data-wizard-id="<?php echo esc_attr( $this->get_wizard_id() ); ?>"
                                                                       data-question-key="<?php echo esc_attr( $wpfp_questions_key ); ?>"
                                                                       data-attribute-name="<?php echo esc_attr( $wpfp_option_attribute_name_explode[0] ); ?>"
                                                                       data-attribute-name-db="<?php echo esc_attr( $wpfp_option_attribute_name_explode[1] ); ?>"
                                                                       data-attribute-value="<?php echo esc_attr( $wpfp_option_attribute_value ); ?>"
																	<?php
																	$wizard_result_display_mode = 'no';
																	if ( wpfp_fs()->is__premium_only() ) {
																		if ( wpfp_fs()->can_use_premium_code() ) {
																			$wizard_result_display_mode = $this->get_wizard_result_display_mode();
																		}
																	}
																	if ( 'yes' !== $wizard_result_display_mode ) {
																		?> data-nonce="<?php echo esc_attr( wp_create_nonce( $this->get_wizard_id() . $wpfp_option_key ) ); ?>" <?php
																	}
																	?>
                                                                />
                                                                <label for="<?php echo esc_attr( $input_id ); ?>" class="wpfp-option-selector-label">
                                                                    <span class="wpfp-option-label-text"><?php echo esc_html( $wpfp_option_name ); ?></span>
                                                                </label>
                                                            </div>
                                                        </li>
														<?php
													}
												}
											}
											?>
                                        </ul>
										<?php
										if ( wpfp_fs()->is__premium_only() ) {
											if ( wpfp_fs()->can_use_premium_code() ) {
												if ( 'checkbox' === $wpfp_questions_type ) {
													?>
                                                    <input type="hidden" name="wpfp_selection_option_<?php echo esc_attr( $wpfp_questions_key ); ?>" id="wpfp_wizard_selected_option_<?php echo esc_attr( $wpfp_questions_key ); ?>" class="wpfp_wizard_selected_option_<?php echo esc_attr( $wpfp_questions_key ); ?>">
													<?php
												}
											}
										}
										?>
                                    </li>
									<?php
								}
							}
							$question_number_count ++;
						}
						?>
                    </ul>
                    <input type="hidden" name="wpfp_wizard_options_selected" id="wpfp_wizard_options_selected" data-wizard-id="<?php echo esc_attr( $this->get_wizard_id() ); ?>">
                    <input type="hidden" name="wpfp_wizard_categories_ids" id="wpfp_wizard_categories_ids" value="<?php echo esc_attr( get_imploded_array( $this->get_categories() ) ); ?>">
                </div>
				<?php
				if ( true === $is_question_available && true === $is_option_available ) {
					$this->wpfp_wizard_action_html();
				}
				?>
            </div>
            <div class="wpfp-product-list"></div>
			<?php } ?>

        </div>

		<?php

		return ob_get_clean();
	}

	/**
	 * Generate unit tab.
	 *
	 * @param int $id
	 *
	 * @return string string of tab.
	 */
	private static function generate_unit_tag( $id = 0, $input_id = null ) {
		static $global_count = 0;

		$global_count += 1;

		if ( in_the_loop() ) {
			$unit_tag = sprintf( 'wpfp-w%1$d-p%2$d-o%3$d-i%4$s',
				absint( $id ),
				get_the_ID(),
				$global_count,
				$input_id
			);
		} else {
			$unit_tag = sprintf( 'wpfp-w%1$d-o%2$d-i%3$s',
				absint( $id ),
				$global_count,
				$input_id
			);
		}

		return $unit_tag;
	}


	/**
	 * Create hidden fields.
	 * @return string
	 */
	private function wizard_hidden_fields() {
		$hidden_fields = array(
			'_wpfp_wizard'         => $this->get_wizard_id(),
			'_wpfp_unit_tag'       => $this->get_unit_tag(),
			'_wpfp_container_post' => 0,
			'_wpfp_question_ids'   => $this->get_question_keys(),
		);

		if ( in_the_loop() ) {
			$hidden_fields['_wpfp_container_post'] = (int) get_the_ID();
		}

		if ( is_user_logged_in() ) {
			$hidden_fields['_wpnonce'] = wp_create_nonce( 'wpfp_wizard_nonce' );
		}

		$hidden_fields += (array) apply_filters(
			'wpfp_wizard_hidden_fields', array() );

		$content = '';

		foreach ( $hidden_fields as $name => $value ) {
			$content .= sprintf( '<input type="hidden" name="%1$s" value="%2$s" />', esc_attr( $name ), esc_attr( $value ) ) . "\n";
		}

		return '<div style="display: none;">' . "\n" . $content . '</div>' . "\n";
	}


}