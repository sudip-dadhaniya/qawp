<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class Size_Chart_For_Woocommerce_Admin {

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
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_style( $this->plugin_name . "-jquery-editable-style", plugin_dir_url( __FILE__ ) . 'css/jquery.edittable.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . "-select2", plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/size-chart-for-woocommerce-admin.css', array(), $this->version, 'all' );
		wp_add_inline_style( $this->plugin_name, 'body{}' );
		wp_enqueue_style( $this->plugin_name . "-jquery-modal-default-theme", plugin_dir_url( __FILE__ ) . 'css/remodal-default-theme.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( $this->plugin_name . "-jquery-editable-js", plugin_dir_url( __FILE__ ) . 'js/jquery.edittable.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . "-jquery-select2", plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/size-chart-for-woocommerce-admin.js', array(
			'jquery',
			'wp-color-picker'
		), $this->version, false );
		wp_localize_script( $this->plugin_name, 'size_chart_woo_ajax_object',
			array(
				'size_chart_nonce' => wp_create_nonce( 'size_chart_for_wooocmmerce_nonoce' ),
			)
		);
	}

	/**
	 * Register a new post type called chart.
	 *
	 * @since    1.0.0
	 */
	public function size_chart_register_post_type_chart() {
		$labels = array(
			'name'               => __( 'Size Charts', 'size-chart-for-woocommerce' ),
			'singular_name'      => __( 'Size Charts', 'size-chart-for-woocommerce' ),
			'menu_name'          => __( 'Size Charts', 'size-chart-for-woocommerce' ),
			'name_admin_bar'     => __( 'Size Charts', 'size-chart-for-woocommerce' ),
			'add_new'            => __( 'Add New', 'size-chart-for-woocommerce' ),
			'add_new_item'       => __( 'Add New Size Charts', 'size-chart-for-woocommerce' ),
			'new_item'           => __( 'New Size Charts', 'size-chart-for-woocommerce' ),
			'edit_item'          => __( 'Edit Size Charts', 'size-chart-for-woocommerce' ),
			'view_item'          => __( 'View Size Charts', 'size-chart-for-woocommerce' ),
			'all_items'          => __( 'All Size Charts', 'size-chart-for-woocommerce' ),
			'search_items'       => __( 'Search Size Charts', 'size-chart-for-woocommerce' ),
			'parent_item_colon'  => __( 'Parent Size Charts:', 'size-chart-for-woocommerce' ),
			'not_found'          => __( 'No chart found.', 'size-chart-for-woocommerce' ),
			'not_found_in_trash' => __( 'No charts found in Trash.', 'size-chart-for-woocommerce' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'size-chart-for-woocommerce' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => plugin_dir_url( __FILE__ ) . 'images/menu-icon.png',
			'supports'           => array( 'title', 'editor' )
		);
		register_post_type( 'size-chart', $args );
	}

	/**
	 * Adds the meta box container.
	 *
	 * @since    1.0.0
	 */
	public function size_chart_add_meta_box( $post_type ) {

		$post_types_chart = array( 'size-chart', 'product' );   //limit meta box to chart post type
		if ( in_array( $post_type, $post_types_chart, true ) ) {

			// chart setting meta box
			add_meta_box( 'chart-settings', __( 'Size Chart Settings', 'size-chart-for-woocommerce' ), array(
				$this,
				'size_chart_meta_box_content'
			), 'size-chart', 'advanced', 'high'
			);
			//meta box to select chart in product page
			add_meta_box( 'additional-chart', __( 'Select Size Chart', 'size-chart-for-woocommerce' ), array(
				$this,
				'size_chart_select_chart'
			), 'product', 'side', 'default'
			);
			//meta box to List of assign category
			add_meta_box( 'chart-assign-category', __( 'Assign Category', 'size-chart-for-woocommerce' ), array(
				$this,
				'size_chart_assign_category'
			), 'size-chart', 'side', 'default'
			);
			//meta box to List of assign Product
			add_meta_box( 'chart-assign-product', __( 'Assign Product', 'size-chart-for-woocommerce' ), array(
				$this,
				'size_chart_assign_product'
			), 'size-chart', 'side', 'default'
			);
		}
	}

	/**
	 * Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function size_chart_meta_box_content( $post ) {
		$file_dir_path = 'includes/size-chart-meta-box-content-form.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 *  Meta Box content to select chart on product page.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function size_chart_select_chart( $post ) {
		$file_dir_path = 'includes/size-chart-select-chart-form.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 *  Meta Box content to assign category list.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function size_chart_assign_category( $post ) {
		$file_dir_path = 'includes/size-chart-assign-category.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 *  Meta Box content to assign category list.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function size_chart_assign_product( $post ) {
		$file_dir_path = 'includes/size-chart-assign-product.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 * Save the meta when the chart post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 *
	 * @return mixed
	 */
	public function size_chart_content_meta_save( $post_id ) {

		$nonce = filter_input( INPUT_POST, 'size_chart_inner_custom_box', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		// Check if our nonce is set.
		if ( ! isset( $nonce ) ) {
			return $post_id;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'size_chart_inner_custom_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$post_type_name = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );

		// Check the user's permissions.
		if ( 'size-chart' === $post_type_name ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		// Sanitize the user input.
		$post_label               = filter_input( INPUT_POST, 'label', FILTER_SANITIZE_STRING );
		$chart_label              = sanitize_text_field( $post_label );
		$post_primary_chart_image = filter_input( INPUT_POST, 'primary-chart-image', FILTER_SANITIZE_STRING );
		$chart_img                = sanitize_text_field( $post_primary_chart_image );
		$post_position            = filter_input( INPUT_POST, 'position', FILTER_SANITIZE_STRING );
		$chart_position           = sanitize_text_field( $post_position );
		$post_chart_table         = filter_input( INPUT_POST, 'chart-table', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
		$chart_table              = sanitize_text_field( $post_chart_table );
		$post_table_style         = filter_input( INPUT_POST, 'table-style', FILTER_SANITIZE_STRING );
		$table_style              = sanitize_text_field( $post_table_style );

		$args                  = array(
			'chart-categories' => array(
				'filter' => FILTER_VALIDATE_INT,
				'flags'  => FILTER_REQUIRE_ARRAY,
			),
		);
		$post_chart_categories = filter_input_array( INPUT_POST, $args );
		$chart_categories      = ( isset( $post_chart_categories['chart-categories'] ) && array_filter( $post_chart_categories['chart-categories'] ) ) ? $post_chart_categories['chart-categories'] : '';

		/* save the data  */
		update_post_meta( $post_id, 'label', $chart_label );
		update_post_meta( $post_id, 'primary-chart-image', $chart_img );
		update_post_meta( $post_id, 'position', $chart_position );
		update_post_meta( $post_id, 'chart-categories', $chart_categories );
		update_post_meta( $post_id, 'chart-table', $chart_table );
		update_post_meta( $post_id, 'table-style', $table_style );

		return true;
	}

	/**
	 *  Save the meta when the product is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 *
	 * @return bool
	 */
	public function product_select_size_chart_save( $post_id ) {

		$nonce = filter_input( INPUT_POST, 'size_chart_select_custom_box', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		// Check if our nonce is set.
		if ( ! isset( $nonce ) ) {
			return $post_id;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'size_chart_select_custom_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$post_type_name = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );

		// Check the user's permissions.
		if ( 'product' === $post_type_name ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* save the data  */
		$post_prod_chart = filter_input( INPUT_POST, 'prod-chart', FILTER_SANITIZE_NUMBER_INT );
		if ( isset( $post_prod_chart ) && ! empty( $post_prod_chart ) ) {
			$chart_id = sanitize_text_field( $post_prod_chart );
			update_post_meta( $post_id, 'prod-chart', $chart_id );

			return true;
		}

		return true;
	}

	/**
	 * Loads the image iframe.
	 */
	public function size_chart_meta_image_enqueue() {
		global $typenow;
		if ( 'size-chart' === $typenow ) {
			wp_enqueue_media();

			// Registers and enqueues the required javascript.
			wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . '/js/images-frame.js', array( 'jquery' ) );
			wp_localize_script( 'meta-box-image', 'meta_image', array(
					'title'  => __( 'Upload an Image', 'size-chart-for-woocommerce' ),
					'button' => __( 'Use this image', 'size-chart-for-woocommerce' ),
				)
			);
			wp_enqueue_script( 'meta-box-image' );
		}
	}

	/**
	 * Register admin menu for the plugin
	 * @since      1.0.0
	 */
	public function size_chart_menu() {
		$settings = add_submenu_page( 'edit.php?post_type=size-chart', 'Settings', __( 'Settings', 'size-chart-for-woocommerce' ), 'manage_options', 'size_chart_setting_page', array(
			$this,
			'size_chart_settings_form'
		) );
		add_action( "load-{$settings}", array( $this, 'size_chart_settings_page' ) );
	}

	/**
	 *  size chart settings form
	 * @since      1.0.0
	 */
	public function size_chart_settings_form() {
		$file_dir_path = 'includes/size-chart-settings-form.php';
		if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
			include_once plugin_dir_path( __FILE__ ) . $file_dir_path;
		}
	}

	/**
	 *  size chart settings and redirection
	 * @since      1.0.0
	 */
	public function size_chart_settings_page() {

		$size_chart_submit = filter_input( INPUT_POST, 'size_chart_submit', FILTER_SANITIZE_STRING );
		$get_page_name     = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
		if ( isset( $size_chart_submit ) && isset( $get_page_name ) && 'size_chart_setting_page' === $get_page_name ) {
			$this->size_chart_settings = array();


			$size_chart_button_position       = filter_input( INPUT_POST, 'size-chart-button-position', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$size_chart_title_color           = filter_input( INPUT_POST, 'size-chart-title-color', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$size_chart_table_head_color      = filter_input( INPUT_POST, 'size-chart-table-head-color', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$size_chart_table_head_font_color = filter_input( INPUT_POST, 'size-chart-table-head-font-color', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$size_chart_tab_label             = filter_input( INPUT_POST, 'size-chart-tab-label', FILTER_SANITIZE_STRING );
			$size_chart_popup_label           = filter_input( INPUT_POST, 'size-chart-popup-label', FILTER_SANITIZE_STRING );
			$size_chart_button_class          = filter_input( INPUT_POST, 'size-chart-button-class', FILTER_SANITIZE_STRING );
			$size_chart_table_row_even_color  = filter_input( INPUT_POST, 'size-chart-table-row-even-color', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$size_chart_table_row_odd_color   = filter_input( INPUT_POST, 'size-chart-table-row-odd-color', FILTER_SANITIZE_STRING );
			$custom_css                       = filter_input( INPUT_POST, 'custom_css', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

			$this->size_chart_settings['size-chart-button-position']       = $size_chart_button_position;
			$this->size_chart_settings['size-chart-title-color']           = $size_chart_title_color;
			$this->size_chart_settings['size-chart-table-head-color']      = $size_chart_table_head_color;
			$this->size_chart_settings['size-chart-table-head-font-color'] = $size_chart_table_head_font_color;
			$this->size_chart_settings['size-chart-tab-label']             = $size_chart_tab_label;
			$this->size_chart_settings['size-chart-popup-label']           = $size_chart_popup_label;
			$this->size_chart_settings['size-chart-button-class']          = $size_chart_button_class;
			$this->size_chart_settings['size-chart-table-row-even-color']  = $size_chart_table_row_even_color;
			$this->size_chart_settings['size-chart-table-row-odd-color']   = $size_chart_table_row_odd_color;
			$this->size_chart_settings['custom_css']                       = $custom_css;
			//update option
			update_option( "size_chart_settings", $this->size_chart_settings );
			?>
            <div class="updated"><p><strong><?php esc_html_e( 'settings saved.', 'size-chart-for-woocommerce' ); ?></strong></p></div>
			<?php
		}
	}

	/**
	 * Chart table content.
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
					if ( 0 === $i ) {
						printf( "<th>%s</th>", esc_html( $chart[ $j ], 'size-chart-for-woocommerce' ) );
					} else {
						printf( "<td>%s</td>", esc_html( $chart[ $j ], 'size-chart-for-woocommerce' ) );
					}
				}
				echo "</tr>";
				$i ++;
			}
			echo "</table>";
		}
	}

	/**
	 * Function creates post duplicate as a draft and redirects then to the edit post screen.
	 */
	public function size_chart_duplicate_post() {
		global $wpdb;

		$get_request_get  = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_STRING );
		$get_request_post = filter_input( INPUT_POST, 'post', FILTER_SANITIZE_STRING );

		$post_id = ( isset( $get_request_get ) ? absint( $get_request_get ) : absint( $get_request_post ) );
		$post    = get_post( $post_id );
		$cntCoty = get_post_meta( $post_id, 'clone-cnt', true );
		if ( isset( $cntCoty ) && '' !== $cntCoty ) {
			$cnt = $cntCoty + 1;
		} else {
			$cnt = 0;
		}
		update_post_meta( $post_id, 'clone-cnt', $cnt );
		$count_clone       = get_post_meta( $post_id, 'clone-cnt', true );
		$current_user      = wp_get_current_user();
		$clone_post_author = $current_user->ID;
		$count             = ( isset( $count_clone ) && ( $count_clone !== 0 ) ) ? '(' . $count_clone . ')' : '';
		if ( isset( $post ) && ! empty( $post ) ) {

			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $clone_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title . ' - Copy' . $count,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);

			/*
			 * insert the clone post
			 */
			$clone_post_id = wp_insert_post( $args );
			/*
			 * duplicate all post meta
			 */
			$sql_query_prepare = $wpdb->prepare( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d", $post_id );

			$chart_post_meta = $wpdb->get_results( esc_sql( $sql_query_prepare ) );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$sql_sel         = array();
			if ( 0 !== count( $chart_post_meta ) ) {
				$sql_ins = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ( $chart_post_meta as $chart_meta ) {
					if ( 'post_status' !== $chart_meta->meta_key && 'clone-cnt' !== $chart_meta->meta_key ) {
						$meta_key   = $chart_meta->meta_key;
						$meta_value = addslashes( $chart_meta->meta_value );
						$sql_sel[]  = "SELECT " . $clone_post_id . ", '" . $meta_key . "', '" . $meta_value . "'";
					}
				}
				$sql_ins .= implode( " UNION ALL ", $sql_sel );
				$wpdb->query( $sql_ins ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.DirectDatabaseQuery
			}
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $clone_post_id ) );
			exit;
		} else {
			wp_die( esc_html__( 'could not find post: ' . $post_id ), 'size-chart-for-woocommerce' );
		}
	}

	/**
	 * Function creates post preview.
	 */
	public function size_chart_preview_post() {
		$result            = array();
		$result['success'] = 0;
		$result['msg']     = esc_html__( 'Something went wrong.', 'size-chart-for-woocommerce' );

		$nonce = filter_input( INPUT_GET, 'security', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'size_chart_for_wooocmmerce_nonoce' ) ) {
			$result['msg'] = esc_html__( 'Security check failed.', 'size-chart-for-woocommerce' );
			echo wp_json_encode( $result );
			wp_die();
		}
		$chart_id = filter_input( INPUT_GET, 'chart_id', FILTER_SANITIZE_NUMBER_INT );

		if ( isset( $chart_id ) && ! empty( $chart_id ) ) {
			$size_chart_setting = get_option( 'size_chart_settings' );
			$table_style        = get_post_meta( $chart_id, 'table-style', true );

			$size_chart_title_color = ( isset( $size_chart_setting['size-chart-title-color'] ) && ! empty( $size_chart_setting['size-chart-title-color'] ) ) ? $size_chart_setting['size-chart-title-color'] : '#007acc';

			$size_chart_inline_style = $size_chart_setting['custom_css'];

			if ( 'minimalistic' === $table_style ) {
				$size_chart_inline_style .= "#size-chart tr:nth-child(2n+1){ background:none;}
				.button-wrapper #chart-button{color: $size_chart_title_color}";
			} elseif ( 'classic' === $table_style ) {
				$size_chart_inline_style .= "table#size-chart tr th {background: #000;color: #fff;}.button-wrapper #chart-button {color: {$size_chart_title_color}}";
			} elseif ( 'modern' === $table_style ) {
				$size_chart_inline_style .= "table#size-chart tr th {background: none;;color: #000;} table#size-chart, table#size-chart tr th, table#size-chart tr td {border: none;background: none;} #size-chart tr:nth-child(2n+1) {background: #ebe9eb;} .button-wrapper #chart-button {color: {$size_chart_title_color}}";
			} elseif ( 'custom-style' === $table_style ) {
				$size_chart_table_head_color      = ( isset( $size_chart_setting['size-chart-table-head-color'] ) && ! empty( $size_chart_setting['size-chart-table-head-color'] ) ) ? $size_chart_setting['size-chart-table-head-color'] : '#000';
				$size_chart_table_head_font_color = ( isset( $size_chart_setting['size-chart-table-head-font-color'] ) && ! empty( $size_chart_setting['size-chart-table-head-font-color'] ) ) ? $size_chart_setting['size-chart-table-head-font-color'] : '#fff';
				$size_chart_table_row_even_color  = ( isset( $size_chart_setting['size-chart-table-row-even-color'] ) && ! empty( $size_chart_setting['size-chart-table-row-even-color'] ) ) ? $size_chart_setting['size-chart-table-row-even-color'] : '#fff';
				$size_chart_table_row_odd_color   = ( isset( $size_chart_setting['size-chart-table-row-odd-color'] ) && ! empty( $size_chart_setting['size-chart-table-row-odd-color'] ) ) ? $size_chart_setting['size-chart-table-row-odd-color'] : '#ebe9eb';
				$size_chart_inline_style          .= "table#size-chart tr th {background: {$size_chart_table_head_color};color: {$size_chart_table_head_font_color};} #size-chart tr:nth-child(even) {background: {$size_chart_table_row_even_color}}#size-chart td:nth-child(even) {background: none;}
                #size-chart tr:nth-child(odd) {background: {$size_chart_table_row_odd_color}}
                #size-chart td:nth-child(odd) {background: none;}
                .button-wrapper #chart-button {color: {$size_chart_title_color}}";
			} else {
				$size_chart_inline_style .= "table#size-chart tr th {background: #000;color: #fff;}#size-chart tr:nth-child(2n+1) {background: #ebe9eb;}.button-wrapper #chart-button {color: {$size_chart_title_color}}";
			}
			$result['css'] = $size_chart_inline_style;
			ob_start();
			?>
            <div class="chart-container" id="size-chart-id-<?php esc_attr_e( $chart_id ); ?>">
				<?php
				$file_dir_path = 'includes/size-chart-contents.php';
				if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
					require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
				}
				?>
            </div>
			<?php
			$result['html']    = ob_get_clean();
			$result['success'] = 1;
			$result['msg']     = esc_html__( 'Successfully...', 'size-chart-for-woocommerce' );
		} else {
			$result['msg'] = esc_html__( 'No Result Found', 'size-chart-for-woocommerce' );
		}
		echo wp_json_encode( $result );
		wp_die();
	}

	public function size_chart_preview_dialog_box() {
		?>
        <div id="wait">
            <img src="<?php echo esc_url( plugins_url( 'admin/images/loader.gif', dirname( __FILE__ ) ) ); ?>" width="64" height="64"/>
            <br><?php esc_html_e( 'Loading...', 'size-chart-for-woocommerce' ); ?>
        </div>

        <div id="md-size-chart-modal" class="md-size-chart-modal">
            <!-- Modal content -->
            <div class="md-size-chart-modal-content">
                <div class="md-size-chart-overlay"></div>
                <div class="md-size-chart-modal-body">
                    <button data-remodal-action="close" id="md-poup" class="remodal-close" aria-label="Close"></button>
                </div>
            </div>

        </div>
		<?php
	}

	/**
	 * Manage Size Chart Type And Action
	 */
	public function size_chart_column( $columns ) {
		$new_columns = ( is_array( $columns ) ) ? $columns : array();
		unset( $new_columns['date'] );
		$new_columns['size-chart-type'] = __( 'Size Chart Type', 'size-chart-for-woocommerce' );
		$new_columns['action']          = __( 'Action', 'size-chart-for-woocommerce' );

		return $new_columns;
	}

	/**
	 * Manage Size Chart Column
	 */
	public function size_chart_manage_column( $column ) {
		global $post;
		switch ( $column ) {
			case 'size-chart-type' :
				$size_chart_type = get_post_meta( $post->ID, 'post_status', true );
				if ( isset( $size_chart_type ) && 'default' === $size_chart_type ) {
					esc_html_e( 'Default Template', 'size-chart-for-woocommerce' );
				} else {
					esc_html_e( 'Custom Template', 'size-chart-for-woocommerce' );
				}
				break;
			case 'action' :

				echo sprintf(
					"<a href='%s' class='clone-chart' title='%s' rel='permalink'></a><a id='%s' href='javascript:void(0);' class='preview_chart' title='%s' rel='permalink'></a>",
					esc_url(
						wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'size_chart_duplicate_post',
									'post'   => $post->ID,
								),
								admin_url( 'admin.php' )
							),
							'size_chart_duplicate_post'
						)
					),
					esc_attr__( 'Clone', 'size-chart-for-woocommerce' ),
					esc_attr( $post->ID ),
					esc_attr__( 'Preview', 'size-chart-for-woocommerce' )
				);
				break;
		}
	}

	/**
	 * Delete size chart image.
	 */
	public function size_chart_delete_image() {
		$result            = array();
		$result['success'] = 0;
		$result['msg']     = esc_html__( 'Something went wrong.', 'size-chart-for-woocommerce' );

		$nonce = filter_input( INPUT_GET, 'security', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'size_chart_for_wooocmmerce_nonoce' ) ) {
			$result['msg'] = esc_html__( 'Security check failed.', 'size-chart-for-woocommerce' );
			echo wp_json_encode( $result );
			wp_die();
		}
		$post_id = filter_input( INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT );

		if ( isset( $post_id ) && ! empty( $post_id ) ) {
			update_post_meta( $post_id, 'primary-chart-image', '' );
			$result['msg']     = esc_html__( 'image successfully deleted...', 'size-chart-for-woocommerce' );
			$result['url']     = plugins_url( 'admin/images/chart-img-placeholder.jpg', dirname( __FILE__ ) );
			$result['success'] = 1;
		}
		echo wp_json_encode( $result );
		wp_die();
	}

	/**
	 * Size Chart welcome page.
	 *
	 */
	public function welcome_screen_do_activation_redirect() {
		// if no activation redirect
		if ( ! get_transient( '_welcome_screen_activation_redirect_size_chart' ) ) {
			return;
		}
		// Delete the redirect transient
		delete_transient( '_welcome_screen_activation_redirect_size_chart' );
		// if activating from network, or bulk
		$activate_multi = filter_input( INPUT_GET, 'activate-multi', FILTER_SANITIZE_STRING );
		if ( is_network_admin() || isset( $activate_multi ) ) {
			return;
		}
		// Redirect to size chart welcome  page
		wp_safe_redirect( add_query_arg( array( 'page' => 'size-chart-about&tab=about' ), admin_url( 'index.php' ) ) );
		exit();
	}

	/**
	 * Add size chart dashboard page.
	 */
	public function welcome_pages_screen() {
		add_dashboard_page( 'Size Chart Dashboard', 'Size Chart Dashboard', 'read', 'size-chart-about', array( &$this, 'welcome_screen_content' ) );
	}

	/**
	 * Size chart dashboard page callback function.
	 */
	public function welcome_screen_content() {
		?>
        <div class="wrap about-wrap">
            <div class="sfl-about-first-div">
                <h1 style="font-size: 2.1em;"><?php printf( esc_html__( 'Welcome to Size Chart for WooCommerce 1.9.1', 'size-chart-for-woocommerce' ) ); ?></h1>
                <div class="about-text woocommerce-about-text">
					<?php
					$allow_html = array(
						'p' => array( 'class' => array() )
					);
					echo wp_kses( "<p class='size-chart-div-congo'>Congratulations! You are about to use full Customize and easy to used Size Chart plugin as per your needs for your ECommerce store.</p>", $allow_html );
					?>
                </div>
                <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'images/version-logo.png' ); ?>">
            </div><!--aecw-about-first-div-->
			<?php
			do_action( 'size_chart_about', 'Overview' );
			?>
            <hr/>
            <div class="return-to-dashboard">
				<?php
				echo sprintf(
					"<a href='%s'>%s</a>",
					esc_url(
						add_query_arg(
							array(
								'post_type' => 'size-chart',
								'page'      => 'size_chart_setting_page',
							),
							admin_url( 'edit.php' )
						)
					),
					esc_html__( 'Go To Size Chart Settings', 'size-chart-for-woocommerce' )
				);
				?>
            </div>
        </div>
		<?php
	}

	/**
	 * Welcome overview tab.
	 *
	 */
	public function size_chart_about( $heading_name ) {
		?>
        <div class="changelog">
            <h3><?php esc_html_e( $heading_name ); ?></h3>
            <div class="changelog about-integrations">
                <div class="wc-feature feature-section col three-col">

                    <div class="size-chart-whatnew-main">

                        <div class="size-chart-whatn-right">
							<?php
							$allow_html = array(
								'p' => array()
							);
							?>
                            <h3><?php esc_html_e( 'Add product custom size guides to any of your WooCommerce products.', 'size-chart-for-woocommerce' ); ?></h3>
							<?php echo wp_kses( '<p>Size Chart For WooCommerce plugin opens the possibility to create customize size chart options. With this plugin has ready made size chart template and allows you to create custom Size Charts and apply to specific category and product in your online store.</p>', $allow_html ); ?>
                            <h3><?php esc_html_e( 'Default size chart template', 'size-chart-for-woocommerce' ); ?></h3>
							<?php echo wp_kses( '<p>With this plugin have sample default size chart template, So you can direct apply to product or category.</p>', $allow_html ); ?>
                            <h3><?php esc_html_e( 'Create your own size guide', 'size-chart-for-woocommerce' ); ?></h3>
							<?php echo wp_kses( '<p>With this Plugin, you are able to customize/ clone the default size chart and create your own size guide for anything you imagine!</p>', $allow_html ); ?>
                            <h3><?php esc_html_e( 'Comprehensive display', 'size-chart-for-woocommerce' ); ?></h3>
							<?php echo wp_kses( '<p>Customers will be able to fully understand your product and buy it without making unnecessary questions regarding size.</p>', $allow_html ); ?>
                        </div>

                    </div><!--aecw-whatnew-main-->
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Removed the index.php in submenu page.
	 */
	public function welcome_screen_remove_menus() {
		remove_submenu_page( 'index.php', 'size-chart-about' );
	}

	/**
	 * Disable the publish button on size chart.
	 *
	 * @param $hook_suffix
	 */
	public function size_chart_publish_button_disable( $hook_suffix ) {
		if ( 'post.php' === $hook_suffix ) {
			global $post;
			$post_status = get_post_meta( $post->ID, 'post_status', true );
			if ( 'size-chart' === $post->post_type && isset( $post_status ) && 'default' === $post_status ) {
				wp_add_inline_script( 'size-chart-for-woocommerce', "window.onload = function() {jQuery('#title').prop('disabled', true);};" );
			}
		}
	}

	/**
	 * Remove the row actions for default size chart.
	 *
	 * @param $actions
	 *
	 * @return mixed
	 */
	public function size_chart_remove_row_actions( $actions ) {
		global $post;
		$post_status = get_post_meta( $post->ID, 'post_status', true );
		if ( 'size-chart' === $post->post_type && isset( $post_status ) && 'default' === $post_status ) {
			unset( $actions['inline hide-if-no-js'] );
			unset( $actions['view'] );
			unset( $actions['edit'] );
			unset( $actions['trash'] );
		}


		return $actions;
	}

	/**
	 * Size chart default post publishing action hide.
	 */
	public function size_chart_pro_hide_publishing_actions() {
		global $post;
		$post_status = get_post_meta( $post->ID, 'post_status', true );
		if ( 'size-chart' === $post->post_type && isset( $post_status ) && 'default' === $post_status ) {
			echo '
                <style type="text/css">
                    #delete-action, .bulkactions, #duplicate-action, #misc-publishing-actions, #minor-publishing-actions{
                        display:none;
                    }
                </style>
            ';
		}
	}

	/**
	 * Size chart default template.
	 */
	public function size_chart_filter_default_template() {
		global $typenow;
		$current = filter_input( INPUT_GET, 'default_template', FILTER_SANITIZE_STRING );
		if ( 'size-chart' === $typenow ) {
			?>
            <select name="default_template" id="issue">
                <option value=""><?php esc_html_e( 'Show All Template', 'size-chart-for-woocommerce' ); ?></option>
                <option value="hide-default" <?php selected( 'hide-default', $current, true ); ?>><?php esc_html_e( 'Hide Default Template', 'size-chart-for-woocommerce' ); ?></option>
            </select>
			<?php
		}
	}

	/**
	 * Set size chart default template.
	 *
	 * @param $query
	 */
	public function size_chart_filter_default_template_query( $query ) {
		global $pagenow;
		$post_type        = filter_input( INPUT_GET, 'default_template', FILTER_SANITIZE_STRING );
		$default_template = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );
		if ( is_admin() && 'edit.php' === $pagenow && isset( $post_type ) && 'size-chart' === $post_type && isset( $default_template ) && ! empty( $default_template ) ) {
			set_query_var( 'meta_query', array( array( 'key' => 'post_status', 'value' => 'default', 'compare' => 'NOT EXISTS' ) ) );
		}
	}

	/**
	 * Size chart selected chart deleted.
	 *
	 * @param $post_id
	 */
	public function size_chart_selected_chart_delete( $post_id ) {
		global $wpdb;
		if ( isset( $post_id ) && ! empty( $post_id ) && 'size-chart' === get_post_type( $post_id ) ) {
			$result = wp_cache_get( 'meta_key_prod_chart' . $post_id );
			if ( false === $result ) {
				$sql    = $wpdb->prepare( "SELECT post_id  FROM $wpdb->postmeta where meta_key='prod-chart' AND meta_value=%s", array( $post_id ) );
				$result = $wpdb->get_results( esc_sql( $sql ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				wp_cache_set( 'meta_key_prod_chart' . $post_id, $result );
			}
			if ( ! empty( $result ) ) {
				foreach ( $result as $value ) {
					delete_post_meta( $value->post_id, 'prod-chart', $post_id );
				}
			}
		}
	}

	/**
	 * Size chart pro plugin admin review in footer.
	 */
	function size_chart_pro_admin_footer_review() {
		$allow_html = array(
			'p'      => array(
				'id'    => array(),
				'class' => array()
			),
			'strong' => array(),
			'a'      => array(
				'href'   => array(),
				'target' => array()
			)
		);
		echo wp_kses( '<p id="footer-left " class="alignleft size-chart-ft">Hello! If you are happy with the <strong>WooCommerce Advanced Product Size Chart</strong>, we would really appreciate if you could give <a href="https://www.thedotstore.com/woocommerce-advanced-product-size-charts/" target="_blank">★★★★★ rating and post your review on DotStore</a> or <a href="https://codecanyon.net/item/advanced-product-size-chart-for-woocommerce/reviews/17465337" target="_blank">CodeCanyon</a>.</p>', $allow_html );
	}

	/**
	 * Size chart pro plugin admin review notice.
	 */
	function size_chart_pro_admin_notice_review() {
		?>
        <div class="notice notice-success is-dismissible">
			<?php
			$allow_html = array(
				'p'      => array(
					'id'    => array(),
					'class' => array()
				),
				'strong' => array(),
				'a'      => array(
					'href'   => array(),
					'target' => array()
				)
			);
			echo wp_kses( '<p>Hello! If you are happy with the <strong>WooCommerce Advanced Product Size Chart</strong>, we would really appreciate if you could give <a href="https://www.thedotstore.com/woocommerce-advanced-product-size-charts/" target="_blank">★★★★★ rating and post your review on DotStore</a> or <a href="https://codecanyon.net/item/advanced-product-size-chart-for-woocommerce/reviews/17465337" target="_blank">CodeCanyon</a>.</p>', $allow_html );
			?>
        </div>
		<?php
	}

	/**
	 * Default Template.
	 * Created default size chart posts.
	 */
	function size_chart_pro_default_posts() {

		if ( ! get_option( 'default_size_chart' ) ) {
			/* Get current user to assign a post */
			$user_id = get_current_user_id();
			/**
			 *  Women's Shoe Size Chart Default Post
			 */
			$women_shoes_chart_content = $this->size_chart_cloth_template_html_content( 'women-shoes' );
			$women_shoes_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $women_shoes_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Women's Shoes Size Chart" ),
			);
			$post_id                   = wp_insert_post( $women_shoes_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'women-shoes' );
			}

			/**
			 *  Cloth size chart Default Post
			 */
			$cloth_chart_content = $this->size_chart_cloth_template_html_content( 'women-cloth' );
			$cloth_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $cloth_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Women's Cloth size chart" ),
			);

			$post_id = wp_insert_post( $cloth_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'women-cloth' );
			}
			/**
			 *  Women T-shirt / Tops size chart Default Post
			 */
			$women_top_chart_content = $this->size_chart_cloth_template_html_content( 'womens-tshirt' );
			$women_top_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $women_top_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Women's T-shirt / Tops size chart" ),
			);
			$post_id                 = wp_insert_post( $women_top_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'womens-tshirt' );
			}
			/**
			 *  Women Jeans And Jeggings size chart
			 */
			$women_jeans_chart_content = $this->size_chart_cloth_template_html_content( 'womens-jeans' );
			$women_jeans_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $women_jeans_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Women's Jeans And Jeggings Size Chart" ),
			);
			$post_id                   = wp_insert_post( $women_jeans_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'womens-jeans' );
			}
			/**
			 *  Women Dress size chart
			 */
			$women_dress_chart_content = $this->size_chart_cloth_template_html_content( 'womens-dress' );
			$women_dress_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $women_dress_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Women's Dress Size Chart " ),
			);
			$post_id                   = wp_insert_post( $women_dress_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'womens-dress' );
			}
			/**
			 * Men's Shoe Size Chart Default Post
			 */
			$men_shoes_chart_content = $this->size_chart_cloth_template_html_content( 'men-shoes' );
			$men_shoes_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $men_shoes_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Men's Shoes Size Chart" ),
			);
			$post_id                 = wp_insert_post( $men_shoes_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'men-shoes' );
			}
			/**
			 *  Men's Jeans and Trouser
			 */
			$jeans_chart_content = $this->size_chart_cloth_template_html_content( 'jeans-trouser' );
			$jeans_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $jeans_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Men's Jeans & Trousers Size Chart" ),
			);
			$post_id             = wp_insert_post( $jeans_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'jeans-trouser' );
			}
			/**
			 * LONG & SHORT SLEEVE T-SHIRTS & POLO SHIRTS
			 */
			$tshirt_chart_content = $this->size_chart_cloth_template_html_content( 'tshirt-shirt' );
			$tshirt_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $tshirt_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Men's T-Shirts & Polo Shirts Size Chart" ),
			);
			$post_id              = wp_insert_post( $tshirt_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'tshirt-shirt' );
			}
			/**
			 * MEN'S SHIRTS
			 */
			$shirt_chart_content = $this->size_chart_cloth_template_html_content( 'mens-shirts' );
			$shirt_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $shirt_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Men's Shirts Size Chart" ),
			);
			$post_id             = wp_insert_post( $shirt_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'mens-shirts' );
			}
			/**
			 * MEN'S WAISTCOATS
			 */
			$waistcoats_chart_content = $this->size_chart_cloth_template_html_content( 'mens-waistcoats' );
			$waistcoats_post_arg      = array(
				'post_author'  => $user_id,
				'post_content' => $waistcoats_chart_content,
				'post_excerpt' => '',
				'post_type'    => 'size-chart',
				'post_status'  => 'publish',
				'post_title'   => __( "Men's Waistcoats Size Chart" ),
			);
			$post_id                  = wp_insert_post( $waistcoats_post_arg );
			if ( 0 !== $post_id ) {
				$this->size_chart_add_post_meta( $post_id, 'mens-waistcoats' );
			}
		}
		/* Add option for check default size chart */
		update_option( 'default_size_chart', 'true' );
	}

	/**
	 * Default Chart Content HTML.
	 *
	 * @param $template
	 *
	 * @return false|string
	 */
	function size_chart_cloth_template_html_content( $template ) {
		ob_start();
		?>
        <div class="chart-container">
            <div class="chart-content">
                <div class="chart-content-list">
					<?php if ( 'women-cloth' === $template ) { ?>
                        <ul>
                            <li><strong>Chest :</strong> Measure around the fullest part of the bust, keeping the tape parallel to the floor.</li>
                            <li><strong>Waist :</strong> Measure around the narrowest point, keeping the tape parallel to the floor.</li>
                            <li><strong>Hip :</strong> Stand with feet together and measure around the fullest point of the hip, keep the tape
                                parallel to the floor.
                            </li>
                            <li><strong>Inseam :</strong> Measure inside length of leg from your crotch to the bottom of ankle.</li>
                        </ul>
					<?php } elseif ( 'womens-tshirt' === $template ) { ?>
                        <ul>
                            <li><strong>Chest :</strong> Measure under your arms, around the fullest part of the your chest.</li>
                            <li><strong>Waist :</strong> Measure around your natural waistline, keeping the tape a bit loose.</li>
                        </ul>
					<?php } elseif ( 'womens-jeans' === $template ) { ?>
                        <ul>
                            <li><strong>Waist :</strong> Measure around your natural waistline,keeping the tape bit loose.</li>
                            <li><strong>Hips :</strong> Measure around the fullest part of your body at the top of your leg.</li>
                            <li><strong>Inseam</strong> : Wearing pants that fit well, measure from the crotch seam to the bottom of the leg.</li>
                        </ul>
					<?php } elseif ( 'womens-dress' === $template ) { ?>
                        <ul>
                            <li><strong>Chest :</strong> Measure under your arms, around the fullest part of the your chest.</li>
                            <li><strong>Waist :</strong> Measure around your natural waistline, keeping the tape a bit loose.</li>
                            <li><strong>Hips :</strong> Measure around the fullest part of your body at the top of your leg.</li>
                        </ul>
					<?php } elseif ( 'jeans-trouser' === $template ) { ?>
                        <p>To choose the correct size for you, measure your body as follows:</p>
                        <ul>
                            <li><strong>Waist :</strong> Measure around natural waistline.</li>
                            <li><strong>Inside leg :</strong> Measure from top of inside leg at crotch to ankle bone.</li>
                        </ul>
					<?php } elseif ( 'tshirt-shirt' === $template ) { ?>
                        <p>To choose the correct size for you, measure your body as follows:</p>
                        <ul>
                            <li><strong>Chest :</strong> Measure around the fullest part, place the tape close under the arms and make sure the tape
                                is flat across the back.
                            </li>
                        </ul>
					<?php } elseif ( 'mens-shirts' === $template ) { ?>
                        <p>To choose the correct size for you, measure your body as follows:</p>
                        <ul>
                            <li><strong>Chest :</strong> Measure around the fullest part, place the tape close under the arms and make sure the tape
                                is flat across the back.
                            </li>
                        </ul>
					<?php } elseif ( 'mens-waistcoats' === $template ) { ?>
                        <ul>
                            <li><strong>Chest :</strong> Measure around the fullest part, place the tape close under the arms and make sure the tape
                                is flat across the back.
                            </li>
                        </ul>
					<?php } ?>
                </div>
                <div class="chart-content-image">
					<?php if ( 'women-cloth' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/cloth_size_chart.png', dirname( __FILE__ ) ) ); ?>" alt="cloth-chart" width="300" height="300"/>
					<?php } elseif ( 'womens-tshirt' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/women-t-shirt-top.png', dirname( __FILE__ ) ) ); ?>" alt="womens-tshirt" width="300" height="300"/>
					<?php } elseif ( 'women-shoes' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/women-shoes-size-image.jpg', dirname( __FILE__ ) ) ); ?>" alt="womens-shoe-chart" width="300" height="300"/>
					<?php } elseif ( 'women-jeans' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/women-jeans-size-chart.png', dirname( __FILE__ ) ) ); ?>" alt="womens-jeans-chart" width="300" height="300"/>
					<?php } elseif ( 'womens-dress' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/women-dress-size-chart.png', dirname( __FILE__ ) ) ); ?>" alt="womens-dress-chart" width="300" height="300"/>
					<?php } elseif ( 'jeans-trouser' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/mens-jeans-and-trousers.jpg', dirname( __FILE__ ) ) ); ?>" alt="jeans-chart" width="300" height="300"/>
					<?php } elseif ( 'tshirt-shirt' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/mens-tshirts-and-polo-shirts.jpg', dirname( __FILE__ ) ) ); ?>" alt="tshirt-shirt-chart" width="300" height="300"/>
					<?php } elseif ( 'men-shoes' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/mens-shoes-size-chart.png', dirname( __FILE__ ) ) ); ?>" alt="mens-shoe-chart" width="300" height="300"/>
					<?php } elseif ( 'mens-shirts' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/mens-shirts.jpg', dirname( __FILE__ ) ) ); ?>" alt="mens-shirts" width="300" height="300"/>
					<?php } elseif ( 'mens-waistcoats' === $template ) { ?>
                        <img class="alignnone size-medium alignright" src="<?php echo esc_url( plugins_url( 'admin/images/default-chart/mens-waistcoats.jpg', dirname( __FILE__ ) ) ); ?>" alt="mens-waistcoats" width="300" height="300"/>
					<?php } ?>
                </div>
            </div>
        </div>

		<?php
		return ob_get_clean();
	}

	/**
	 * Default Chart Add Post Meta.
	 *
	 * @param $post_id
	 * @param $template
	 */
	function size_chart_add_post_meta( $post_id, $template ) {
		if ( 'women-shoes' === $template ) {
			$label       = "Women's Sizes";
			$chart_table = stripcslashes( '[["US","Euro","UK","Inches","CM"],["4","35","2","8.1875","20.8"],["4.5","35","2.5","8.375","21.3"],["5","35-36","3","8.5","21.6"],["5.5","36","3.5","8.75","22.2"],["6","36-37","4","8.875","22.5"],["6.5","37","4.5","9.0625","23"],["7","37-38","5","9.25","23.5"],["7.5","38","5.5","9.375","23.8"],["8","38-39","6","9.5","24.1"],["8.5","39","6.5","9.6875","24.6"],["9","39-40","7","9.875","25.1"],["9.5","40","7.5","10","25.4"],["10","40-41","8","10.1875","25.9"],["10.5","41","8.5","10.3125","26.2"],["11","41-42","9","10.5","26.7"],["11.5","42","9.5","10.6875","27.1"],["12","42-43","10","10.875","27.6"]]' );
		} elseif ( 'women-cloth' === $template ) {
			$label       = "Women's Sizes";
			$chart_table = stripcslashes( '[["UK SIZE","BUST","BUST","WAIST","WAIST","HIPS","HIPS"],["","INCHES","CM","INCHES","CM","INCHES","CM"],["4","31","78","24","60","33","83.5"],["6","32","80.5","25","62.5","34","86"],["8","33","83","26","65","35","88.5"],["10","35","88","28","70","37","93.5"],["12","37","93","30","75","39","98.5"],["14","39","98","31","80","41","103.5"],["16","41","103","33","85","43","108.5"],["18","44","110.5","36","92.5","46","116"]]' );
		} elseif ( 'womens-tshirt' === $template ) {
			$label       = "Women's Sizes";
			$chart_table = stripcslashes( '[["UK SIZE","BUST","BUST","WAIST","WAIST","HIPS","HIPS"],["","INCHES","CM","INCHES","CM","INCHES","CM"],["4","31","78","24","60","33","83.5"],["6","32","80.5","25","62.5","34","86"],["8","33","83","26","65","35","88.5"],["10","35","88","28","70","37","93.5"],["12","37","93","30","75","39","98.5"],["14","39","98","31","80","41","103.5"],["16","41","103","33","85","43","108.5"],["18","44","110.5","36","92.5","46","116"]]' );
		} elseif ( 'womens-jeans' === $template ) {
			$label       = "Women's Jeans Sizes";
			$chart_table = stripcslashes( '[["Size","Waist","Hip"],["24","24","35"],["25","25","36"],["26","26","37"],["27","27","38"],["28","28","39"],["29","29","40"],["30","30","41"],["31","31","42"],["32","32","43"],["33","33","44"],["34","34","45"]]' );
		} elseif ( 'womens-dress' === $template ) {
			$label       = "Women's Dress Sizes";
			$chart_table = stripcslashes( '[["SIZE","NUMERIC SIZE","BUST","WAIST","HIP"],["XXXS","000","30","23","33"],["XXS","00","31.5","24","34"],["XS","0","32.5","25","35"],["XS","2","33.5","26","36"],["S","4","34.5","27","37"],["S","6","35.5","28","38"],["M","8","36.5","29","39"],["M","10","37.5","30","40"],["L","12","39","31.5","41.5"],["L","14","40.5","33","43"],["XL","16","42","34.5","44.5"],["XL","18","44","36","46.5"],["XXL","20","46","37.5","48.5"]]' );
		} elseif ( 'jeans-trouser' === $template ) {
			$label       = "Men's Jeans & Trousers Size";
			$chart_table = stripcslashes( '[["TO FIT WAIST SIZE","INCHES","CM"],["26","26","66"],["28","28","71"],["29","29","73.5"],["30","30","76"],["31","31","78.5"],["32","32","81"],["33","33","83.5"],["34","34","86"],["36","36","91"],["38","38","96"],["40","40","101"],["","",""],["TO FIT INSIDE LEG LENGTH","INCHES","CM"],["Short","30","76"],["Regular","32","81"],["Long","34","86"]]' );
		} elseif ( 'men-shoes' === $template ) {
			$label       = "Men's Shoes Size";
			$chart_table = stripcslashes( '[["US","Euro","UK","Inches","CM"],["6","39","5.5","9.25","23.5"],["6.5","39","6","9.5","24.1"],["7","40","6.5","9.625","24.4"],["7.5","40-41","7","9.75","24.8"],["8","41","7.5","9.9375","25.4"],["8.5","41-42","8","10.125","25.7"],["9","42","8.5","10.25","26"],["9.5","42-43","9","10.4375","26.7"],["10","43","9.5","10.5625","27"],["10.5","43-44","10","10.75","27.3"],["11","44","10.5","10.9375","27.9"],["11.5","44-45","11","11.125","28.3"],["12","45","11.5","11.25","28.6"],["13","46","12.5","11.5625","29.4"],["14","47","13.5","11.875","30.2"],["15","48","14.5","12.1875","31"],["16","49","15.5","12.5","31.8"]]' );
		} elseif ( 'tshirt-shirt' === $template ) {
			$label       = "T-Shirts & Polo Shirts";
			$chart_table = stripcslashes( '[["TO FIT CHEST SIZE","INCHES","CM"],["XXXS","30-32","76-81"],["XXS","32-34","81-86"],["XS","34-36","86-91"],["S","36-38","91-96"],["M","38-40","96-101"],["L","40-42","101-106"],["XL","42-44","106-111"],["XXL","44-46","111-116"],["XXXL","46-48","116-121"]]' );
		} elseif ( 'mens-shirts' === $template ) {
			$label       = "Men's Shirts";
			$chart_table = stripcslashes( '[["TO FIT CHEST SIZE","INCHES","CM","TO FIT NECK SIZE","INCHES","CM"],["XXXS","30-32","76-81","XXXS","14","36"],["XXS","32-34","81-86","XXS","14.5","37.5"],["XS","34-36","86-91","XS","15","38.5"],["S","36-38","91-96","S","15.5","39.5"],["M","38-40","96-101","M","16","41.5"],["L","40-42","101-106","L","17","43.5"],["XL","42-44","106-111","XL","17.5","45.5"],["XXL","44-46","111-116","XXL","18.5","47.5"],["XXXL","46-48","116-121","XXXL","19.5","49.5"]]' );
		} elseif ( 'mens-waistcoats' === $template ) {
			$label       = "Men's Waistcoats";
			$chart_table = stripcslashes( '[["CHEST MEASUREMENT","INCHES","CM"],["32","32","81"],["34","34","86"],["36","36","91"],["38","38","96"],["40","40","101"],["42","42","106"],["44","44","111"],["46","46","116"]]' );
		}
		update_post_meta( $post_id, 'label', $label );
		update_post_meta( $post_id, 'position', 'popup' );
		update_post_meta( $post_id, 'post_status', 'default' );
		update_post_meta( $post_id, 'chart-table', $chart_table );
	}

}
