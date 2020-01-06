<?php


class Woocommerce_Product_Finder_Pro_Settings {

	protected $wpfp_wizard_setting_data;

	public function set_wizard_setting_data( $data ) {
		$this->wpfp_wizard_setting_data = $data;
	}

	/**
	 * Gets a prop for a getter method.
	 *
	 * Gets the value from either current pending changes, or the data itself.
	 * Context controls what happens to the value before it's returned.
	 *
	 * @param string $prop Name of prop to get.
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return mixed
	 * @since  3.0.0
	 */
	protected function get_settings_prop( $prop, $context = 'view' ) {
		$value = null;

		if ( isset( $this->wpfp_wizard_setting_data ) ) {
			if ( array_key_exists( $prop, $this->wpfp_wizard_setting_data ) ) {
				$value = $this->wpfp_wizard_setting_data[ $prop ];

				if ( 'view' === $context ) {
					$value = apply_filters( 'wpfp_get_setting_' . $prop, $value, $this );
				}
			}
		}

		return $value;
	}

	/**
	 * Get perfect match title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_perfect_match_title( $context = 'view' ) {
		return $this->get_settings_prop( 'perfect_match_title', $context );
	}

	/**
	 * Get recent match title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_recent_match_title( $context = 'view' ) {
		return $this->get_settings_prop( 'recent_match_title', $context );
	}

	/**
	 * Get show attributes number.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_show_attribute( $context = 'view' ) {
		return $this->get_settings_prop( 'show_attribute', $context );
	}

	/**
	 * Get perfect match title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_backend_per_page_limit( $context = 'view' ) {
		return $this->get_settings_prop( 'backend_per_page_limit', $context );
	}

	/**
	 * Get option row item.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_option_row_item( $context = 'view' ) {
		return $this->get_settings_prop( 'option_row_item', $context );
	}

	/**
	 * Get text color wizard title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_text_color_wizard_title( $context = 'view' ) {
		return $this->get_settings_prop( 'text_color_wizard_title', $context );
	}

	/**
	 * Get questions background image id.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_questions_background_image_id( $context = 'view' ) {
		return $this->get_settings_prop( 'questions_background_image_id', $context );
	}

	/**
	 * Get background color.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_background_color( $context = 'view' ) {
		return $this->get_settings_prop( 'background_color', $context );
	}

	/**
	 * Get text color.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_text_color( $context = 'view' ) {
		return $this->get_settings_prop( 'text_color', $context );
	}

	/**
	 * Get background next previous button color.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_background_next_pre_button_color( $context = 'view' ) {
		return $this->get_settings_prop( 'background_next_pre_button_color', $context );
	}

	/**
	 * Get text next previous button color.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_text_next_pre_button_color( $context = 'view' ) {
		return $this->get_settings_prop( 'text_next_pre_button_color', $context );
	}

	/**
	 * Get background color for options.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_background_color_for_options( $context = 'view' ) {
		return $this->get_settings_prop( 'background_color_for_options', $context );
	}

	/**
	 * Get text color for options.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_text_color_for_options( $context = 'view' ) {
		return $this->get_settings_prop( 'text_color_for_options', $context );
	}

	/**
	 * Get reload button title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_reload_title( $context = 'view' ) {
		return $this->get_settings_prop( 'reload_title', $context );
	}

	/**
	 * Get next button title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_next_title( $context = 'view' ) {
		return $this->get_settings_prop( 'next_title', $context );
	}

	/**
	 * Get back button title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_back_title( $context = 'view' ) {
		return $this->get_settings_prop( 'back_title', $context );
	}

	/**
	 * Get show result title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_show_result_title( $context = 'view' ) {
		return $this->get_settings_prop( 'show_result_title', $context );
	}

	/**
	 * Get restart title button.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_restart_title( $context = 'view' ) {
		return $this->get_settings_prop( 'restart_title', $context );
	}


	/**
	 * Get detail title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_detail_title( $context = 'view' ) {
		return $this->get_settings_prop( 'detail_title', $context );
	}

	/**
	 * Get total count title.
	 *
	 * @param string $context View or edit context.
	 *
	 * @return string
	 */
	public function get_total_count_title( $context = 'view' ) {
		return $this->get_settings_prop( 'total_count_title', $context );
	}

	/**
	 * Get the wizard mode.
	 * @return mixed|void
	 */
	public function get_wizard_result_display_mode() {
		return get_option( 'wpfp_result_display_mode' );
	}

}