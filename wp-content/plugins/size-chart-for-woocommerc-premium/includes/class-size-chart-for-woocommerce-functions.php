<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get the size chart setting.
 * @return mixed|void
 */
function size_chart_get_settings() {
	$size_chart_setting = get_option( 'size_chart_settings' );

	return $size_chart_setting;
}

/**
 * Get the size chart setting by field.
 *
 * @param $field_name
 *
 * @return mixed|string
 */
function size_chart_get_setting( $field_name ) {
	$size_chart_setting = size_chart_get_settings();
	if ( isset( $size_chart_setting[ $field_name ] ) ) {
		return $size_chart_setting[ $field_name ];
	}

	return '';
}


/**
 * Get the table head color from default setting.
 * @return mixed|string
 */
function size_chart_get_table_head_color() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-table-head-color' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '#000';
}

/**
 * Get the table head font color from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_table_head_font_color() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-table-head-font-color' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '#fff';
}

/**
 * Get the table row even color from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_table_row_even_color() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-table-row-even-color' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '#fff';
}

/**
 * Get the table row odd color from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_table_row_odd_color() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-table-row-odd-color' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '#ebe9eb';
}

/***
 * Get the tab label from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_tab_label() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-tab-label' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return esc_html__( 'Size Chart', 'size-chart-for-woocommerce' );
}

/**
 * Get the popup label from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_popup_label() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-popup-label' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return esc_html__( 'Size Chart', 'size-chart-for-woocommerce' );
}

/**
 * Get the sub title text from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_sub_title_text() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-sub-title-text' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return esc_html__( 'How to measure', 'size-chart-for-woocommerce' );
}

/**
 * Get the button position from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_button_position() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-button-position' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '';
}

/**
 * Get the title color from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_title_color() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-title-color' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '#007acc';
}

/**
 * Get the button class from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_button_class() {
	$size_chart_field_value = size_chart_get_setting( 'size-chart-button-class' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '';
}

/**
 * Get the custom css from default setting.
 *
 * @return mixed|string
 */
function size_chart_get_custom_css() {
	$size_chart_field_value = size_chart_get_setting( 'custom_css' );
	if ( isset( $size_chart_field_value ) && ! empty( $size_chart_field_value ) ) {
		return $size_chart_field_value;
	}

	return '';
}

/**
 * Get the inline styles for size chart by post id.
 *
 * @param int $post_id
 *
 * @return mixed|string
 */
function size_chart_get_inline_styles_by_post_id( $post_id = 0 ) {
	$table_style = size_chart_get_chart_table_style_by_chart_id( $post_id );

	$size_chart_title_color  = size_chart_get_title_color();
	$size_chart_inline_style = size_chart_get_custom_css();

	if ( 'minimalistic' === $table_style ) {
		$size_chart_inline_style .= "#size-chart tr:nth-child(2n+1){ background:none;}
				.button-wrapper #chart-button{color: $size_chart_title_color}";
	} elseif ( 'classic' === $table_style ) {
		$size_chart_inline_style .= "table#size-chart tr th {background: #000;color: #fff;}.button-wrapper #chart-button {color: {$size_chart_title_color}}";
	} elseif ( 'modern' === $table_style ) {
		$size_chart_inline_style .= "table#size-chart tr th {background: none;;color: #000;} table#size-chart, table#size-chart tr th, table#size-chart tr td {border: none;background: none;} #size-chart tr:nth-child(2n+1) {background: #ebe9eb;} .button-wrapper #chart-button {color: {$size_chart_title_color}}";
	} elseif ( 'custom-style' === $table_style ) {
		$size_chart_table_head_color      = size_chart_get_table_head_color();
		$size_chart_table_head_font_color = size_chart_get_table_head_font_color();
		$size_chart_table_row_even_color  = size_chart_get_table_row_even_color();
		$size_chart_table_row_odd_color   = size_chart_get_table_row_odd_color();
		$size_chart_inline_style          .= "table#size-chart tr th {background: {$size_chart_table_head_color};color: {$size_chart_table_head_font_color};} #size-chart tr:nth-child(even) {background: {$size_chart_table_row_even_color}}#size-chart td:nth-child(even) {background: none;}
                #size-chart tr:nth-child(odd) {background: {$size_chart_table_row_odd_color}}
                #size-chart td:nth-child(odd) {background: none;}
                .button-wrapper #chart-button {color: {$size_chart_title_color}}";
	} else {
		$size_chart_inline_style .= "table#size-chart tr th {background: #000;color: #fff;}#size-chart tr:nth-child(2n+1) {background: #ebe9eb;}.button-wrapper #chart-button {color: {$size_chart_title_color}}";
	}

	return apply_filters( 'size_chart_inline_style', $size_chart_inline_style );
}

/**
 * Create size chart table html.
 *
 * @param $chart_table
 *
 * @return false|string
 */
function size_chart_get_chart_table( $chart_table ) {
	ob_start();

	if ( ! empty( $chart_table ) && array_filter( $chart_table ) ) {
		echo "<table id='size-chart'>";
		$i = 0;
		foreach ( $chart_table as $chart ) {

			if ( array_filter( $chart ) ) {
				echo "<tr>";
				for ( $j = 0; $j < count( $chart ); $j ++ ) {
					//If data available.
					if ( isset( $chart[ $j ] ) && '' !== $chart[ $j ] ) {
						echo ( 0 === $i ) ? "<th>" . esc_html__( $chart[ $j ], 'size-chart-for-woocommerce' ) . "</th>" : "<td>" . esc_html__( $chart[ $j ], 'size-chart-for-woocommerce' ) . "</td>";
					} else {
						echo ( 0 === $i ) ? "<th>" . esc_html__( $chart[ $j ], 'size-chart-for-woocommerce' ) . "</th>" : "<td>" . esc_html__( 'N/A', 'size-chart-for-woocommerce' ) . "</td>";
					}
				}
				echo "</tr>";
				$i ++;
			}
		}
		echo "</table>";
	}

	return apply_filters( 'size_chart_table_html', ob_get_clean() );
}

/**
 * Get the default size chart post ids.
 * @return mixed|void
 */
function size_chart_get_default_post_ids() {
	return get_option( 'default_size_chart_posts_ids' );
}

/**
 * Check the is default size chart post id.
 *
 * @param int $size_chart_id
 *
 * @return bool
 */
function size_chart_is_default_post_id( $size_chart_id = 0 ) {
	$default_size_chart_ids = size_chart_get_default_post_ids();
	if ( isset( $default_size_chart_ids ) && ! empty( $default_size_chart_ids ) && array_filter( $default_size_chart_ids ) ) {
		if ( in_array( $size_chart_id, $default_size_chart_ids, true ) ) {
			return true;
		}

		return false;
	}

	return false;
}

/**
 * Update the default size chart post ids.
 *
 * @param $default_size_chart_ids
 */
function size_chart_update_default_post_ids( $default_size_chart_ids ) {
	update_option( 'default_size_chart_posts_ids', $default_size_chart_ids );
}

/**
 * Get the size chart categories.
 *
 * @param $size_chart_id
 *
 * @return mixed
 */
function size_chart_get_categories( $size_chart_id ) {
	$size_cart_cat_id = get_post_meta( $size_chart_id, 'chart-categories', true );
	if ( is_serialized( $size_cart_cat_id, true ) ) {
		$size_cart_cat_id = maybe_unserialize( $size_cart_cat_id );
	}

	return $size_cart_cat_id;
}

/**
 * Get the label value.
 *
 * @param $size_chart_id
 *
 * @return mixed|string
 */
function size_chart_get_label_by_chart_id( $size_chart_id ) {
	$chart_label = get_post_meta( $size_chart_id, 'label', true );
	if ( isset( $chart_label ) && ! empty( $chart_label ) ) {
		return $chart_label;
	}

	return get_the_title( $size_chart_id );
}

/**
 * Get the primary chart image data.
 *
 * @param $size_chart_id
 *
 * @return array
 */
function size_chart_get_primary_chart_image_data_by_chart_id( $size_chart_id ) {
	$chart_img_id         = size_chart_get_primary_chart_image_id( $size_chart_id );
	$size_chart_image_arr = array();
	$img_url              = size_chart_default_chart_image();
	$img_width            = '';
	$img_height           = '';
	$close_icon_enable    = false;
	if ( 0 !== $chart_img_id ) {
		// Display the form, using the current value.
		$size_chart_img_arr = wp_get_attachment_image_src( $chart_img_id, 'thumbnail' );
		if ( isset( $size_chart_img_arr[0] ) ) {
			$img_url           = $size_chart_img_arr[0];
			$img_width         = $size_chart_img_arr[1];
			$img_height        = $size_chart_img_arr[2];
			$close_icon_enable = true;
		}
	}
	$size_chart_image_arr['attachment_id']     = $chart_img_id;
	$size_chart_image_arr['url']               = $img_url;
	$size_chart_image_arr['width']             = $img_width;
	$size_chart_image_arr['height']            = $img_height;
	$size_chart_image_arr['close_icon_status'] = $close_icon_enable;

	return $size_chart_image_arr;

}

/**
 * Get the default chart image.
 * @return string
 */
function size_chart_default_chart_image() {
	return plugins_url( 'admin/images/chart-img-placeholder.jpg', dirname( __FILE__ ) );
}

/**
 * Get the primary chart image id.
 *
 * @param $size_chart_id
 *
 * @return int|mixed
 */
function size_chart_get_primary_chart_image_id( $size_chart_id ) {
	$chart_img_id = get_post_meta( $size_chart_id, 'primary-chart-image', true );
	if ( isset( $chart_img_id ) && ! empty( $chart_img_id ) ) {
		return $chart_img_id;
	}

	return 0;
}

/**
 * Get the position of the chart.
 *
 * @param $size_chart_id
 *
 * @return mixed|string
 */
function size_chart_get_position_by_chart_id( $size_chart_id ) {

	$chart_position = get_post_meta( $size_chart_id, 'position', true );
	if ( isset( $chart_position ) && ! empty( $chart_position ) ) {
		return $chart_position;
	}

	return '';
}

/**
 * Get the chart table and check is it not empty.
 *
 * @param $size_chart_id
 * @param bool $return_json_decode
 *
 * @return array|mixed|object
 */
function size_chart_get_chart_table_by_chart_id( $size_chart_id, $return_json_decode = true ) {
	$chart_table = get_post_meta( $size_chart_id, 'chart-table', true );

	if ( false === $return_json_decode ) {
		return $chart_table;
	}
	if ( isset( $chart_table ) && ! empty( $chart_table ) ) {
		if( false !== is_size_chart_table_empty( $chart_table ) ) {
			return json_decode( $chart_table );
		}
	}

	return array();
}

/**
 * Multidimensional array check is not empty.
 *
 * @param $chart_table
 *
 * @return bool
 */
function is_size_chart_table_empty( $chart_table ) {

	if ( ! is_array( $chart_table ) ) {
		$chart_table = json_decode( $chart_table );
	}

	if ( is_array( $chart_table ) ) {
		foreach ( $chart_table as $value ) {
			if ( ! array_filter( $value ) ) {
				return false;
			}
		}
	} elseif ( ! empty( $chart_table ) ) {
		return false;
	}

	return true;
}

/**
 * Get the chart table style class.
 *
 * @param $size_chart_id
 *
 * @return mixed|string
 */
function size_chart_get_chart_table_style_by_chart_id( $size_chart_id ) {
	$table_style = get_post_meta( $size_chart_id, 'table-style', true );
	if ( isset( $table_style ) && ! empty( $table_style ) ) {
		return $table_style;
	}

	return '';
}

/**
 * Get the size chart content.
 *
 * @param $size_chart_id
 *
 * @return mixed|string|void
 */
function size_chart_get_the_content( $size_chart_id ) {
	$size_chart_post         = get_post( $size_chart_id );
	$size_chart_post_content = $size_chart_post->post_content;
	$size_chart_post_content = apply_filters( 'the_content', $size_chart_post_content );
	$size_chart_post_content = str_replace( ']]>', ']]&gt;', $size_chart_post_content );

	return $size_chart_post_content;
}

/**
 * Get the size chart in product meta.
 *
 * @param $post_id
 *
 * @return int|mixed
 */
function size_chart_get_product_chart_id( $post_id ) {
	$product_chart_id = get_post_meta( $post_id, 'prod-chart', true );
	if ( isset( $product_chart_id ) && ! empty( $product_chart_id ) ) {
		return $product_chart_id;
	}

	return 0;
}

/**
 * Create pagination html.
 *
 * @param $size_chart_query
 * @param int $current_post_id
 * @param int $posts_per_page
 * @param bool $html
 *
 * @return string
 */
function size_chart_pagination_html( $size_chart_query, $current_post_id = 0, $posts_per_page = 10, $html = true ) {

	// current page
	$current_page = (int) $size_chart_query->query_vars['paged'];
	// the overall amount of pages
	$max_page = $size_chart_query->max_num_pages;

	// we don't have to display pagination or load more button in this case
	if ( $max_page <= 1 ) {
		return '';
	}

	// set the current page to 1 if not exists
	if ( empty( $current_page ) || $current_page === 0 ) {
		$current_page = 1;
	}

	// you can play with this parameter - how much links to display in pagination
	$links_in_the_middle         = 3;
	$links_in_the_middle_minus_1 = $links_in_the_middle - 1;

	// the code below is required to display the pagination properly for large amount of pages
	$first_link_in_the_middle = $current_page - floor( $links_in_the_middle_minus_1 / 2 );
	$last_link_in_the_middle  = $current_page + ceil( $links_in_the_middle_minus_1 / 2 );

	// some calculations with $first_link_in_the_middle and $last_link_in_the_middle
	if ( $first_link_in_the_middle <= 0 ) {
		$first_link_in_the_middle = 1;
	}
	if ( ( $last_link_in_the_middle - $first_link_in_the_middle ) !== $links_in_the_middle_minus_1 ) {
		$last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_minus_1;
	}
	if ( $last_link_in_the_middle > $max_page ) {
		$first_link_in_the_middle = $max_page - $links_in_the_middle_minus_1;
		$last_link_in_the_middle  = (int) $max_page;
	}
	if ( $first_link_in_the_middle <= 0 ) {
		$first_link_in_the_middle = 1;
	}

	if ( true === $html ) {

		// begin to generate HTML of the pagination
		$pagination = '<nav class="pagination-box"><ul class="pagination" data-nonce="' . wp_create_nonce( 'size-chart-pagination' ) . '">';

		// arrow left (previous page)
		if ( $current_page !== 1 ) {
			$first_page_number = $current_page - 1;
			$pagination        .= size_chart_get_link_html( $first_page_number, $current_post_id, $posts_per_page, esc_html__( "<<", "size-chart-for-woocommerce" ), true, 'prev' );
		}

		// when to display "..." and the first page before it
		if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page ) {
			$pagination .= size_chart_get_link_html( 1, $current_post_id, $posts_per_page, esc_html__( "1", "size-chart-for-woocommerce" ) );

			if ( $first_link_in_the_middle !== 2 ) {
				$pagination .= '<li><span class="page-numbers dots">...</span></li>';
			}

		}

		// loop page links in the middle between "..." and "..."
		for ( $lopp_number = $first_link_in_the_middle; $lopp_number <= $last_link_in_the_middle; $lopp_number ++ ) {
			if ( $lopp_number === $current_page ) {
				$pagination .= '<li><span class="page-numbers current">' . $lopp_number . '</span></li>';
			} else {
				$pagination .= size_chart_get_link_html( $lopp_number, $current_post_id, $posts_per_page, esc_html__( $lopp_number, "size-chart-for-woocommerce" ) );
			}
		}

		// when to display "..." and the last page after it
		if ( $last_link_in_the_middle < $max_page ) {

			if ( $last_link_in_the_middle !== ( $max_page - 1 ) ) {
				$pagination .= '<li><span class="page-numbers dots">...</span></li>';
			}

			$pagination .= size_chart_get_link_html( $max_page, $current_post_id, $posts_per_page, esc_html__( $max_page, "size-chart-for-woocommerce" ) );
		}

		// arrow right (next page)
		if ( $current_page !== $last_link_in_the_middle ) {
			$next_page_number = $current_page + 1;
			$pagination       .= size_chart_get_link_html( $next_page_number, $current_post_id, $posts_per_page, esc_html__( ">>", "size-chart-for-woocommerce" ), true, 'next' );
		}
		// end HTML
		$pagination .= "</ul></nav>";

		$allow_html = array(
			'nav'  => array(
				'class' => array(),
			),
			'ul'   => array(
				'class'      => array(),
				'data-nonce' => array(),
			),
			'li'   => array(
				'class' => array(),
			),
			'a'    => array(
				'class'              => array(),
				'href'               => array(),
				'data-post-id'       => array(),
				'data-page-number'   => array(),
				'data-post-per-page' => array(),
			),
			'span' => array(
				'class' => array(),
			),
		);
		echo wp_kses( $pagination, $allow_html );

	} else {

		// begin to generate HTML of the pagination.

		// arrow left (previous page)
		if ( $current_page !== 1 ) {
			$first_page_number    = $current_page - 1;
			$pagination        [] = size_chart_get_link_html( $first_page_number, $current_post_id, $posts_per_page, __( "<<", "size-chart-for-woocommerce" ), false, 'prev' );
		}

		// when to display "..." and the first page before it
		if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page ) {
			$pagination [] = size_chart_get_link_html( 1, $current_post_id, $posts_per_page, esc_html__( "1", "size-chart-for-woocommerce" ), false );

			if ( $first_link_in_the_middle !== 2 ) {
				$pagination [] = array(
					'pagination_tag'   => 'span',
					'pagination_mode'  => 'dots',
					'pagination_class' => 'dots',
					'page_text'        => '...'
				);
			}

		}

		// loop page links in the middle between "..." and "..."
		for ( $lopp_number = $first_link_in_the_middle; $lopp_number <= $last_link_in_the_middle; $lopp_number ++ ) {
			if ( (int) $lopp_number === (int) $current_page ) {
				$pagination [] = array(
					'pagination_tag'   => 'span',
					'pagination_mode'  => 'number',
					'pagination_class' => 'current',
					'page_text'        => $lopp_number
				);
			} else {
				$pagination [] = size_chart_get_link_html( $lopp_number, $current_post_id, $posts_per_page, esc_html__( $lopp_number, "size-chart-for-woocommerce" ), false );
			}
		}

		// when to display "..." and the last page after it
		if ( $last_link_in_the_middle < $max_page ) {

			if ( $last_link_in_the_middle !== ( $max_page - 1 ) ) {
				$pagination [] = array(
					'pagination_tag'   => 'span',
					'pagination_mode'  => 'dots',
					'pagination_class' => 'dots',
					'page_text'        => '...'
				);
			}

			$pagination [] = size_chart_get_link_html( $max_page, $current_post_id, $posts_per_page, esc_html__( $max_page, "size-chart-for-woocommerce" ), false );
		}

		// arrow right (next page)
		if ( $current_page !== $last_link_in_the_middle ) {
			$next_page_number    = $current_page + 1;
			$pagination       [] = size_chart_get_link_html( $next_page_number, $current_post_id, $posts_per_page, __( ">>", "size-chart-for-woocommerce" ), false, 'next' );
		}

		return $pagination;
	}

	return 0;

}

/**
 * Get the size chart pagination html or array.
 *
 * @param $page_number
 * @param $post_id
 * @param $posts_per_page
 * @param $page_text
 * @param $class_name
 * @param $html
 *
 * @return string|array
 */
function size_chart_get_link_html( $page_number, $post_id, $posts_per_page, $page_text, $html = true, $class_name = '' ) {
	if ( true === $html ) {
		return sprintf(
			'<li><a href="#" data-page-number="%s" data-post-id="%s" data-post-per-page="%s" class="page-numbers %s">%s</a></li>',
			$page_number,
			$post_id,
			$posts_per_page,
			$class_name,
			$page_text
		);
	} else {
		return array(
			'pagination_mode'  => 'number',
			'page_number'      => $page_number,
			'post_id'          => $post_id,
			'post_per_page'    => $posts_per_page,
			'pagination_class' => $class_name,
			'page_text'        => $page_text
		);
	}
}