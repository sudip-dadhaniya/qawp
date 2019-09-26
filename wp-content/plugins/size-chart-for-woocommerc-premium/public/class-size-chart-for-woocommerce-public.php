<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/public
 * @link       http://www.multidots.com/
 * @since      1.0.0
 */
/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

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
	 * @since  1.0.0
	 * @access private
	 * @var    string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles_callback() {

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
	 * @since 1.0.0
	 */
	public function enqueue_scripts_callback() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/size-chart-for-woocommerce-public' . $suffix . '.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * size chart product custom tab
	 *
	 * @since 1.0.0
	 */
	public function size_chart_custom_product_tab_callback( $tabs ) {
		global $post;
		$prod_id = size_chart_get_product_chart_id( $post->ID );
		if ( isset( $prod_id ) && ! empty( $prod_id ) && '' !== get_post_status( $prod_id ) && 'publish' === get_post_status( $prod_id ) ) {
			$chart_id = $prod_id;
		} else {
			$chart_id = $this->size_chart_id_by_category( $post->ID );
		}
		$chart_label    = size_chart_get_label_by_chart_id( $chart_id );
		$chart_position = size_chart_get_position_by_chart_id( $chart_id );
		if ( ! $chart_id ) {
			return $tabs;
		}
		if ( 'tab' === $chart_position ) {
			$size_chart_tab_label = size_chart_get_tab_label();
			if ( isset( $size_chart_tab_label ) && ! empty( $size_chart_tab_label ) ) {
				$tab_label = size_chart_get_tab_label();
			} else {
				$tab_label = $chart_label;
			}

			$tabs['custom_tab'] = array(
				'title'    => __( $tab_label, 'size-chart-for-woocommerce' ),
				'priority' => 50,
				'callback' => array( $this, 'size_chart_custom_product_tab_content_callback' ),
			);

			return $tabs;
		}

		return $tabs;
	}

	/**
	 * Check popup button position.
	 *
	 * @since 1.0.0
	 */
	public function size_chart_popup_button_position_callback() {
		$position = size_chart_get_button_position();
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
		add_action( $hook, array( $this, 'size_chart_popup_button_callback' ), $priority );
	}

	/**
	 * size chart new tab content
	 *
	 * @since 1.0.0
	 */
	public function size_chart_custom_product_tab_content_callback() {
		global $post;
		$prod_id = size_chart_get_product_chart_id( $post->ID );
		if ( isset( $prod_id ) && ! empty( $prod_id ) && '' !== get_post_status( $prod_id ) && 'publish' === get_post_status( $prod_id ) ) {
			$chart_id = $prod_id;
		} else {
			$chart_id = $this->size_chart_id_by_category( $post->ID );
		}
		if ( $chart_id ) {
			$file_dir_path = 'includes/comman-files/size-chart-contents.php';
			if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . $file_dir_path ) ) {
				include_once plugin_dir_path( dirname( __FILE__ ) ) . $file_dir_path;
			}
		}
	}

	/**
	 * hook to display chart button.
	 *
	 * @since 1.0.0
	 */
	public function size_chart_popup_button_callback() {
		global $post;
		$prod_id = size_chart_get_product_chart_id( $post->ID );
		if ( isset( $prod_id ) && ! empty( $prod_id ) && '' !== get_post_status( $prod_id ) && 'publish' === get_post_status( $prod_id ) ) {
			$chart_id = $prod_id;
		} else {
			$chart_id = $this->size_chart_id_by_category( $post->ID );
		}
		$chart_label    = size_chart_get_label_by_chart_id( $chart_id );
		$chart_position = size_chart_get_position_by_chart_id( $chart_id );
		if ( ! $chart_id ) {
			return 0;
		}

		if ( 'popup' === $chart_position ) {
			$size_chart_popup_label = size_chart_get_popup_label();
			if ( isset( $size_chart_popup_label ) && ! empty( $size_chart_popup_label ) ) {
				$popup_label = $size_chart_popup_label;
			} else {
				$popup_label = $chart_label;
			}
			?>
            <div class="button-wrapper">
                <a class="<?php esc_attr_e( size_chart_get_button_class() ); ?>" href="javascript:void(0);" id="chart-button"><?php esc_html_e( $popup_label, 'size-chart-for-woocommerce' ); ?></a>
            </div>
            <div id="md-size-chart-modal" class="md-size-chart-modal">
                <!-- Modal content -->
                <div class="md-size-chart-modal-content">
                    <div class="md-size-chart-overlay"></div>
                    <div class="md-size-chart-modal-body">
                        <button data-remodal-action="close" id="md-poup" class="remodal-close" aria-label="Close"></button>
                        <div class="chart-container">
							<?php
							$file_dir_path = 'includes/comman-files/size-chart-contents.php';
							if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . $file_dir_path ) ) {
								include_once plugin_dir_path( dirname( __FILE__ ) ) . $file_dir_path;
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
	 * BN code added
	 */
	public function paypal_bn_code_filter_callback( $paypal_args ) {
		$paypal_args['bn'] = 'Multidots_SP';

		return $paypal_args;
	}

	/**
	 * chart table content
	 *
	 * @param string $chart_content display chart details with table
	 *
	 * @since 1.0.0
	 */
	public function size_chart_display_table( $chart_content ) {
		echo wp_kses_post( size_chart_get_chart_table( $chart_content ) );
	}

	/**
	 * Check if product belongs to a category
	 *
	 * @since 1.0.0
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
				$chart_categories = size_chart_get_categories( $chart_array_id );
				if ( $chart_categories ) :
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
	 * Create and get the inline style.
	 *
	 * @return bool|string
	 */
	public function get_inline_style_for_size_chart() {
		global $post;
		if ( isset( $post ) && ! empty( $post ) ) {
			$prod_id = size_chart_get_product_chart_id( $post->ID );

			if ( isset( $prod_id ) && ! empty( $prod_id ) ) {
				$chart_id = $prod_id;
			} else {
				$chart_id = $this->size_chart_id_by_category( $post->ID );
			}

			return size_chart_get_inline_styles_by_post_id( $chart_id );
		}

		return false;

	}

}
