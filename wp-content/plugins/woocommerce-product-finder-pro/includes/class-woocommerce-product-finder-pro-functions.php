<?php

/**
 * Get the wizard setting data.
 *
 * @param int $wizard_id pass the wizard id.
 *
 * @return array default wizard setting or wizard setting by id.
 */
function wpfp_get_wizard_setting_data( $wizard_id = 0 ) {

	$wpfp_wizard_setting_data_result = array();
	$wizard_default_setting_data     = array(
		'perfect_match_title'              => __( 'Top Product( s )', 'woo-product-finder' ),
		'recent_match_title'               => __( 'Products meeting most of your requirements', 'woo-product-finder' ),
		'show_attribute'                   => 3,
		'backend_per_page_limit'           => 5,
		'option_row_item'                  => 2,
		'text_color_wizard_title'          => '#ffffff',
		'questions_background_image_id'    => 0,
		'background_color'                 => '#434344',
		'text_color'                       => '#ffffff',
		'background_next_pre_button_color' => '#434344',
		'text_next_pre_button_color'       => '#ffffff',
		'background_color_for_options'     => '#ffffff',
		'text_color_for_options'           => '#000000',
		'reload_title'                     => __( 'Reload Title', 'woo-product-finder' ),
		'next_title'                       => __( 'Next', 'woo-product-finder' ),
		'back_title'                       => __( 'Back', 'woo-product-finder' ),
		'show_result_title'                => __( 'Show Result', 'woo-product-finder' ),
		'restart_title'                    => __( 'Restart', 'woo-product-finder' ),
		'detail_title'                     => __( 'Detail', 'woo-product-finder' ),
		'total_count_title'                => __( 'Total Count Title', 'woo-product-finder' )
	);

	if ( wpfp_fs()->is__premium_only() ) {
		if ( wpfp_fs()->can_use_premium_code() ) {
			$transient_key            = "wpfp_wizard_setting_{$wizard_id}";
			$wpfp_wizard_setting_data = get_transient( $transient_key );
			if ( false === $wpfp_wizard_setting_data ) {
				$wpfp_wizard_setting_meta_data = get_post_meta( $wizard_id, '_wpfp_wizard_setting_data', true );
				$wpfp_wizard_setting_data      = json_decode( $wpfp_wizard_setting_meta_data, true );
				set_transient( $transient_key, $wpfp_wizard_setting_data, WEEK_IN_SECONDS );
			}

			if ( isset( $wpfp_wizard_setting_data ) && ! empty( $wpfp_wizard_setting_data ) && array_filter( $wpfp_wizard_setting_data ) ) {

				if ( isset( $wpfp_wizard_setting_data['perfect_match_title'] ) && ! empty( $wpfp_wizard_setting_data['perfect_match_title'] ) ) {
					$wpfp_wizard_setting_data_result['perfect_match_title'] = $wpfp_wizard_setting_data['perfect_match_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['recent_match_title'] ) && ! empty( $wpfp_wizard_setting_data['recent_match_title'] ) ) {
					$wpfp_wizard_setting_data_result['recent_match_title'] = $wpfp_wizard_setting_data['recent_match_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['show_attribute'] ) && ! empty( $wpfp_wizard_setting_data['show_attribute'] ) ) {
					$wpfp_wizard_setting_data_result['show_attribute'] = $wpfp_wizard_setting_data['show_attribute'];
				}
				if ( isset( $wpfp_wizard_setting_data['backend_per_page_limit'] ) && ! empty( $wpfp_wizard_setting_data['backend_per_page_limit'] ) ) {
					$wpfp_wizard_setting_data_result['backend_per_page_limit'] = $wpfp_wizard_setting_data['backend_per_page_limit'];
				}
				if ( isset( $wpfp_wizard_setting_data['option_row_item'] ) && ! empty( $wpfp_wizard_setting_data['option_row_item'] ) ) {
					$wpfp_wizard_setting_data_result['option_row_item'] = $wpfp_wizard_setting_data['option_row_item'];
				}
				if ( isset( $wpfp_wizard_setting_data['text_color_wizard_title'] ) && ! empty( $wpfp_wizard_setting_data['text_color_wizard_title'] ) ) {
					$wpfp_wizard_setting_data_result['text_color_wizard_title'] = $wpfp_wizard_setting_data['text_color_wizard_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['questions_background_image_id'] ) && ! empty( $wpfp_wizard_setting_data['questions_background_image_id'] ) ) {
					$wpfp_wizard_setting_data_result['questions_background_image_id'] = $wpfp_wizard_setting_data['questions_background_image_id'];
				}
				if ( isset( $wpfp_wizard_setting_data['background_color'] ) && ! empty( $wpfp_wizard_setting_data['background_color'] ) ) {
					$wpfp_wizard_setting_data_result['background_color'] = $wpfp_wizard_setting_data['background_color'];
				}
				if ( isset( $wpfp_wizard_setting_data['text_color'] ) && ! empty( $wpfp_wizard_setting_data['text_color'] ) ) {
					$wpfp_wizard_setting_data_result['text_color'] = $wpfp_wizard_setting_data['text_color'];
				}
				if ( isset( $wpfp_wizard_setting_data['background_next_pre_button_color'] ) && ! empty( $wpfp_wizard_setting_data['background_next_pre_button_color'] ) ) {
					$wpfp_wizard_setting_data_result['background_next_pre_button_color'] = $wpfp_wizard_setting_data['background_next_pre_button_color'];
				}
				if ( isset( $wpfp_wizard_setting_data['text_next_pre_button_color'] ) && ! empty( $wpfp_wizard_setting_data['text_next_pre_button_color'] ) ) {
					$wpfp_wizard_setting_data_result['text_next_pre_button_color'] = $wpfp_wizard_setting_data['text_next_pre_button_color'];
				}
				if ( isset( $wpfp_wizard_setting_data['background_color_for_options'] ) && ! empty( $wpfp_wizard_setting_data['background_color_for_options'] ) ) {
					$wpfp_wizard_setting_data_result['background_color_for_options'] = $wpfp_wizard_setting_data['background_color_for_options'];
				}
				if ( isset( $wpfp_wizard_setting_data['text_color_for_options'] ) && ! empty( $wpfp_wizard_setting_data['text_color_for_options'] ) ) {
					$wpfp_wizard_setting_data_result['text_color_for_options'] = $wpfp_wizard_setting_data['text_color_for_options'];
				}
				if ( isset( $wpfp_wizard_setting_data['reload_title'] ) && ! empty( $wpfp_wizard_setting_data['reload_title'] ) ) {
					$wpfp_wizard_setting_data_result['reload_title'] = $wpfp_wizard_setting_data['reload_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['next_title'] ) && ! empty( $wpfp_wizard_setting_data['next_title'] ) ) {
					$wpfp_wizard_setting_data_result['next_title'] = $wpfp_wizard_setting_data['next_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['back_title'] ) && ! empty( $wpfp_wizard_setting_data['back_title'] ) ) {
					$wpfp_wizard_setting_data_result['back_title'] = $wpfp_wizard_setting_data['back_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['show_result_title'] ) && ! empty( $wpfp_wizard_setting_data['show_result_title'] ) ) {
					$wpfp_wizard_setting_data_result['show_result_title'] = $wpfp_wizard_setting_data['show_result_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['restart_title'] ) && ! empty( $wpfp_wizard_setting_data['restart_title'] ) ) {
					$wpfp_wizard_setting_data_result['restart_title'] = $wpfp_wizard_setting_data['restart_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['detail_title'] ) && ! empty( $wpfp_wizard_setting_data['detail_title'] ) ) {
					$wpfp_wizard_setting_data_result['detail_title'] = $wpfp_wizard_setting_data['detail_title'];
				}
				if ( isset( $wpfp_wizard_setting_data['total_count_title'] ) && ! empty( $wpfp_wizard_setting_data['total_count_title'] ) ) {
					$wpfp_wizard_setting_data_result['total_count_title'] = $wpfp_wizard_setting_data['total_count_title'];
				}

			}

			return wp_parse_args( $wpfp_wizard_setting_data_result, $wizard_default_setting_data );
		}
	}

	return $wizard_default_setting_data;


}

/**
 * Display a WooCommerce Product finder pro help tip.
 *
 * @param string $tip Help tip text.
 * @param bool $allow_html Allow sanitized HTML if true or escape.
 */
function wpfp_help_tip( $tip, $allow_html = false ) {
	if ( false !== $allow_html ) {
		$tip = wc_sanitize_tooltip( $tip );
	} else {
		$tip = esc_attr( $tip );
	}
	$allow_html = array(
		'span' => array(
			'class'    => array(),
			'data-tip' => array()
		)
	);

	echo wp_kses( '<span class="wpfp-help-tip" data-tip="' . $tip . '"></span>', $allow_html );
}

/**
 * Support html 5.
 * @return bool
 */
function wpfp_support_html5() {
	return (bool) apply_filters( 'wpfp_support_html5', true );
}

/**
 * Request url
 * @return string
 */
function wpfp_get_request_uri() {
	static $request_uri = '';

	if ( empty( $request_uri ) ) {
		$request_uri = add_query_arg( array() );
	}

	return esc_url_raw( $request_uri );
}

/**
 * Enc type.
 *
 * @param $enctype
 *
 * @return mixed|string
 */
function wpfp_enctype_value( $enctype ) {
	$enctype = trim( $enctype );

	if ( empty( $enctype ) ) {
		return '';
	}

	$valid_enctypes = array(
		'application/x-www-form-urlencoded',
		'multipart/form-data',
		'text/plain',
	);

	if ( in_array( $enctype, $valid_enctypes, true ) ) {
		return $enctype;
	}

	$pattern = '%^enctype="(' . get_imploded_array( $valid_enctypes, '|' ) . ')"$%';

	if ( preg_match( $pattern, $enctype, $matches ) ) {
		return $matches[1]; // for back-compat
	}

	return '';
}

/**
 * Form format attribute.
 *
 * @param $atts
 *
 * @return string
 */
function wpfp_format_atts( $atts ) {
	$html = '';

	$prioritized_atts = array( 'type', 'name', 'value' );

	foreach ( $prioritized_atts as $att ) {
		if ( isset( $atts[ $att ] ) ) {
			$value = trim( $atts[ $att ] );
			$html  .= sprintf( ' %s="%s"', $att, esc_attr( $value ) );
			unset( $atts[ $att ] );
		}
	}

	foreach ( $atts as $key => $value ) {
		$key = strtolower( trim( $key ) );

		if ( ! preg_match( '/^[a-z_:][a-z_:.0-9-]*$/', $key ) ) {
			continue;
		}

		$value = trim( $value );

		if ( '' !== $value ) {
			$html .= sprintf( ' %s="%s"', $key, esc_attr( $value ) );
		}
	}

	$html = trim( $html );

	return $html;
}

/**
 * Imploded the value.
 *
 * @param $array
 * @param string $glue
 *
 * @return string
 */
function get_imploded_array( $array, $glue = ',' ) {
	return implode( $glue, $array );
}

/**
 * Exploded string value.
 *
 * @param $string
 * @param string $glue
 *
 * @return array
 */
function get_exploded_string( $string, $glue = ',' ) {
	return explode( $glue, $string );
}