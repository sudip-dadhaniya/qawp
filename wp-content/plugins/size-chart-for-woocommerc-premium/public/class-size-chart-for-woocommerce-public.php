<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/public
 * @author     Multidots <inquiry@multidots.in>
 */
class Size_Chart_For_Woocommerce_Public {

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
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Size_Chart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Size_Chart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/size-chart-for-woocommerce-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name . "-jquery-modal-default-theme", plugin_dir_url( __FILE__ ) . 'css/remodal-default-theme.css', array(), $this->version, 'all' );

		$inline_style_varibale = $this->get_inline_style_for_size_chart();
		if ( false !== $inline_style_varibale ) {
			wp_add_inline_style( 'size-chart-for-woocommerce', $inline_style_varibale );
		}
	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Size_Chart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Size_Chart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/size-chart-for-woocommerce-public.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * chart table content
	 *
	 * @param string $chart_content display chart details with table
	 *
	 * @since    1.0.0
	 */
	public function size_chart_display_table( $chart_content ) {
		$chart_table = json_decode( $chart_content );
		if ( ! empty( $chart_table ) ) {
			echo "<table id='size-chart'>";
			$i = 0;
			foreach ( $chart_table as $chart ) {
				echo "<tr>";
				for ( $j = 0; $j < count( $chart ); $j ++ ) {

					//If data avaible
					if ( ! empty( $chart[ $j ] ) ) {
						echo ( 0 === $i ) ? "<th>" . esc_html__( $chart[ $j ], 'size-chart-for-woocommerce' ) . "</th>" : "<td>" . esc_html__( $chart[ $j ], 'size-chart-for-woocommerce' ) . "</td>";
					} else {
						echo ( 0 === $i ) ? "<th>" . esc_html__( $chart[ $j ], 'size-chart-for-woocommerce' ) . "</th>" : "<td>" . esc_html__( '' ) . "</td>";
					}
				}
				echo "</tr>";
				$i ++;
			}
			echo "</table>";
		}
	}

	/**
	 * Check if product belongs to a category
	 *
	 * @since    1.0.0
	 */
	public function size_chart_id_by_category( $id ) {

		$terms = wp_get_post_terms( $id, 'product_cat' );

		$chart_terms = array();
		if ( $terms ) {
			foreach ( $terms as $term ) {
				$chart_terms[] = $term->term_id;
			}
		}

		$args                      = array(
			'posts_per_page'         => - 1,
			'order'                  => 'DESC',
			'post_type'              => 'size-chart',
			'post_status'            => 'publish',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'fields'                 => 'ids',
		);
		$size_chart_category_array = new WP_Query( $args );

		$cat_arr  = array();
		$chart_id = 0;
		if ( ! empty( $size_chart_category_array ) ) {
			foreach ( $size_chart_category_array->posts as $chart_array_id ) {
				$chart_categories = get_post_meta( $chart_array_id, 'chart-categories', true );
				if ( $chart_categories ):
					foreach ( $chart_categories as $key => $value ) {
						$cat_arr[ $key ] = $value;
					}
				endif;
				if ( ! empty( $chart_terms ) && ! empty( $cat_arr ) ) {
					if ( array_intersect( $cat_arr, $chart_terms ) ) {
						$chart_id = $chart_array_id;
					}
					if ( $chart_id ) {
						break;
					}
				}
			}
		}

		return $chart_id;
	}

	/**
	 * size chart product custom tab
	 *
	 * @since    1.0.0
	 */
	public function size_chart_custom_product_tab( $tabs ) {
		global $post;
		$prod_id = get_post_meta( $post->ID, 'prod-chart', true );
		if ( isset( $prod_id ) && ! empty( $prod_id ) && '' !== get_post_status( $prod_id ) && 'publish' === get_post_status( $prod_id ) ) {
			$chart_id = $prod_id;
		} else {
			$chart_id = $this->size_chart_id_by_category( $post->ID );
		}
		$chart_label    = get_post_meta( $chart_id, 'label', true );
		$chart_position = get_post_meta( $chart_id, 'position', true );
		if ( ! $chart_id ) {
			return $tabs;
		}
		if ( 'tab' === $chart_position ) {
			$size_chart_setting = get_option( 'size_chart_settings' );
			if ( isset( $size_chart_setting ) && ! empty( $size_chart_setting ) && '' !== $size_chart_setting['size-chart-tab-label'] ) {
				$tab_label = $size_chart_setting['size-chart-tab-label'];
			} else {
				$tab_label = $chart_label;
			}
			$tabs['custom_tab'] = array(
				'title'    => __( $tab_label, 'size-chart-for-woocommerce' ),
				'priority' => 50,
				'callback' => array( $this, 'size_chart_custom_product_tab_content' ),
			);

			return $tabs;
		}

		return $tabs;
	}

	/**
	 * size chart new tab content
	 *
	 * @since    1.0.0
	 */
	public function size_chart_custom_product_tab_content() {
		global $post;
		$prod_id = get_post_meta( $post->ID, 'prod-chart', true );
		if ( isset( $prod_id ) && ! empty( $prod_id ) && '' !== get_post_status( $prod_id ) && 'publish' === get_post_status( $prod_id ) ) {
			$chart_id = $prod_id;
		} else {
			$chart_id = $this->size_chart_id_by_category( $post->ID );
		}
		if ( $chart_id ) {
			$file_dir_path = 'includes/size-chart-contents.php';
			if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
				require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
			}
		}
	}

	/**
	 * hook to display chart button.
	 *
	 * @since    1.0.0
	 */
	public function size_chart_popup_button() {
		global $post;
		$prod_id = get_post_meta( $post->ID, 'prod-chart', true );
		if ( isset( $prod_id ) && ! empty( $prod_id ) && '' !== get_post_status( $prod_id ) && 'publish' === get_post_status( $prod_id ) ) {
			$chart_id = $prod_id;
		} else {
			$chart_id = $this->size_chart_id_by_category( $post->ID );
		}
		$chart_label    = get_post_meta( $chart_id, 'label', true );
		$chart_position = get_post_meta( $chart_id, 'position', true );
		if ( ! $chart_id ) {
			return 0;
		}

		if ( 'popup' === $chart_position ) {
			$size_chart_setting = get_option( 'size_chart_settings' );
			if ( isset( $size_chart_setting ) && ! empty( $size_chart_setting ) && isset( $size_chart_setting['size-chart-popup-label'] ) && '' !== $size_chart_setting['size-chart-popup-label'] ) {
				$popup_label = $size_chart_setting['size-chart-popup-label'];
			} else {
				$popup_label = $chart_label;
			}
			?>
            <div class="button-wrapper">
                <a class="<?php esc_attr_e( ( isset( $size_chart_setting['size-chart-button-class'] ) && ! empty( $size_chart_setting['size-chart-button-class'] ) ) ? $size_chart_setting['size-chart-button-class'] : '' ); ?>" href="javascript:void(0);" id="chart-button"><?php esc_html_e( $popup_label, 'size-chart-for-woocommerce' ); ?></a>
            </div>
            <div id="md-size-chart-modal" class="md-size-chart-modal">
                <!-- Modal content -->
                <div class="md-size-chart-modal-content">
                    <div class="md-size-chart-overlay"></div>
                    <div class="md-size-chart-modal-body">
                        <button data-remodal-action="close" id="md-poup" class="remodal-close" aria-label="Close"></button>
                        <div class="chart-container">
							<?php
							$file_dir_path = 'includes/size-chart-contents.php';
							if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
								require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
							}
							?>
                        </div>
                    </div>
                </div>

            </div>
			<?php
		}
	}

	/**
	 * Check popup button position.
	 *
	 * @since    1.0.0
	 */
	public function size_chart_popup_button_position() {
		$chart_settings = get_option( 'size_chart_settings' );
		$position       = ( isset( $chart_settings['size-chart-button-position'] ) && ! empty( $chart_settings['size-chart-button-position'] ) ) ? $chart_settings['size-chart-button-position'] : '';
		if ( 'before-summary-text' === $position ) {
			$hook     = 'woocommerce_single_product_summary';
			$priority = 11;
		} elseif ( 'after-add-to-cart' === $position ) {
			$hook     = 'woocommerce_single_product_summary';
			$priority = 31;
		} elseif ( 'before-add-to-cart' === $position ) {
			$hook     = 'woocommerce_single_product_summary';
			$priority = 29;
		} elseif ( 'after-product-meta' === $position ) {
			$hook     = 'woocommerce_single_product_summary';
			$priority = 41;
		} else {
			$hook     = 'woocommerce_single_product_summary';
			$priority = 11;
		}
		add_action( $hook, array( $this, 'size_chart_popup_button' ), $priority );
	}

	/**
	 * Create and get the inline style.
	 * @return bool|string
	 */
	public function get_inline_style_for_size_chart() {
		global $post;
		if ( isset( $post ) && ! empty( $post ) ) {
			$prod_id = get_post_meta( $post->ID, 'prod-chart', true );

			if ( isset( $prod_id ) && ! empty( $prod_id ) ) {
				$chart_id = $prod_id;
			} else {
				$chart_id = $this->size_chart_id_by_category( $post->ID );
			}

			$table_style = get_post_meta( $chart_id, 'table-style', true );

			$size_chart_setting = get_option( 'size_chart_settings' );

			$size_chart_title_color = ( isset( $size_chart_setting['size-chart-title-color'] ) && ! empty( $size_chart_setting['size-chart-title-color'] ) ) ? $size_chart_setting['size-chart-title-color'] : '#007acc';

			$inline_style = $size_chart_setting['custom_css'];

			if ( 'minimalistic' === $table_style ) {
				$inline_style .= "#size-chart tr:nth-child(2n+1){ background:none;}
				.button-wrapper #chart-button{color: $size_chart_title_color}";
			} elseif ( 'classic' === $table_style ) {
				$inline_style .= "table#size-chart tr th {background: #000;color: #fff;}.button-wrapper #chart-button {color: {$size_chart_title_color}}";
			} elseif ( 'modern' === $table_style ) {
				$inline_style .= "table#size-chart tr th {background: none;;color: #000;} table#size-chart, table#size-chart tr th, table#size-chart tr td {border: none;background: none;} #size-chart tr:nth-child(2n+1) {background: #ebe9eb;} .button-wrapper #chart-button {color: {$size_chart_title_color}}";
			} elseif ( 'custom-style' === $table_style ) {
				$size_chart_table_head_color      = ( isset( $size_chart_setting['size-chart-table-head-color'] ) && ! empty( $size_chart_setting['size-chart-table-head-color'] ) ) ? $size_chart_setting['size-chart-table-head-color'] : '#000';
				$size_chart_table_head_font_color = ( isset( $size_chart_setting['size-chart-table-head-font-color'] ) && ! empty( $size_chart_setting['size-chart-table-head-font-color'] ) ) ? $size_chart_setting['size-chart-table-head-font-color'] : '#fff';
				$size_chart_table_row_even_color  = ( isset( $size_chart_setting['size-chart-table-row-even-color'] ) && ! empty( $size_chart_setting['size-chart-table-row-even-color'] ) ) ? $size_chart_setting['size-chart-table-row-even-color'] : '#fff';
				$size_chart_table_row_odd_color   = ( isset( $size_chart_setting['size-chart-table-row-odd-color'] ) && ! empty( $size_chart_setting['size-chart-table-row-odd-color'] ) ) ? $size_chart_setting['size-chart-table-row-odd-color'] : '#ebe9eb';
				$inline_style                     .= "table#size-chart tr th {background: {$size_chart_table_head_color};color: {$size_chart_table_head_font_color};} #size-chart tr:nth-child(even) {background: {$size_chart_table_row_even_color}}#size-chart td:nth-child(even) {background: none;}
                #size-chart tr:nth-child(odd) {background: {$size_chart_table_row_odd_color}}
                #size-chart td:nth-child(odd) {background: none;}
                .button-wrapper #chart-button {color: {$size_chart_title_color}}";
			} else {
				$inline_style .= "table#size-chart tr th {background: #000;color: #fff;}#size-chart tr:nth-child(2n+1) {background: #ebe9eb;}.button-wrapper #chart-button {color: {$size_chart_title_color}}";
			}

			return $inline_style;
		}

		return false;

	}

	/**
	 * BN code added
	 */
	function paypal_bn_code_filter( $paypal_args ) {
		$paypal_args['bn'] = 'Multidots_SP';

		return $paypal_args;
	}

}
