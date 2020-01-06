<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/dots
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/public
 * @author     Multidots <hello@multidots.com>
 */
class Woocommerce_Product_Finder_Pro_Public extends Woocommerce_Product_Finder_Pro_Settings {

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


	private $wpfp_attribute_filter_data = array();
	private $wpfp_product_headline = '';
	private $wpfp_identity = '';
	private $wpfp_wizard_id = 0;


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
	 * Register the stylesheets and JavaScript files for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wpfp_public_enqueue_styles_scripts_callback() {
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


		wp_register_style( $this->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/woocommerce-product-finder-pro-public.css', array(), $this->get_plugin_version(), 'all' );
		wp_register_style( $this->get_plugin_name() . '-product-list', plugin_dir_url( __FILE__ ) . 'css/wpfp-product-list-style.css', array(), $this->get_plugin_version(), 'all' );
		wp_enqueue_style( $this->get_plugin_name() );
		wp_enqueue_style( $this->get_plugin_name() . '-product-list' );

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

		wp_register_script( $this->get_plugin_name(), plugin_dir_url( __FILE__ ) . "js/woocommerce-product-finder-pro-public{$suffix}.js", array(
			'jquery',
			'jquery-blockui'
		), $this->get_plugin_version(), false );

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
			'wpfp_option_attribute_name_text'              => __( 'Attribute Name', 'woo-product-finder' ),
			'wpfp_option_attribute_name_placeholder_text'  => __( 'Please type attribute slug', 'woo-product-finder' ),
			'wpfp_option_attribute_name_description_text'  => __( 'Select attribute name which is created in Product attribute section (Ex. Attribute name: Gender Attribute value: gender) type attribute value gender', 'woo-product-finder' ),
			'wpfp_option_attribute_value_text'             => __( 'Attribute Value', 'woo-product-finder' ),
			'wpfp_option_attribute_value_placeholder_text' => __( 'Select Attribute Value', 'woo-product-finder' ),
			'wpfp_option_attribute_value_description_text' => __( 'Select attribute value which is created in Product attribute section', 'woo-product-finder' ),
			'wpfp_result_display_mode'                     => 'no',
		);

		if ( wpfp_fs()->is__premium_only() ) {
			if ( wpfp_fs()->can_use_premium_code() ) {
				$wpfp_localize_script['wpfp_result_display_mode'] = $this->get_wizard_result_display_mode();
			}
		}

		wp_localize_script( $this->get_plugin_name(), 'wpfpPublicScriptObj', $wpfp_localize_script );
		wp_enqueue_script( $this->get_plugin_name() );
	}


	/**
	 * Create shortcode callback function.
	 *
	 * @param array $atts shortcode attribute.
	 * @param null $content content value
	 * @param string $code string html.
	 *
	 * @return string|void shortcode html or string.
	 */
	public function wpfp_shortcode_callback( $atts, $content = null, $code = '' ) {

		if ( is_feed() ) {
			return '[wpfp]';
		}

		if ( 'wpfp' === $code ) {
			$atts = shortcode_atts(
				array(
					'id' => 0,
				),
				$atts, 'wpfp'
			);

			$id          = (int) $atts['id'];
			$wpfp_wizard = $this->wpfp_get_wizard_form_by_id( $id );
		}

		if ( ! $wpfp_wizard ) {
			return '[wpfp 404 "Not Found"]';
		}

		if ( 'publish' !== $wpfp_wizard->get_wizard_status() ) {

			return '[wpfp 404 "' . esc_html__( 'Wizard is disable', 'woo-product-finder' ) . '"]';
		}

		return $wpfp_wizard->wizard_output();
	}

	/**
	 * Get the instance of shprtcode wizard.
	 *
	 * @param $id
	 *
	 * @return bool|Woocommerce_Product_Finder_Pro_Shortcode
	 */
	public function wpfp_wizard( $id ) {

		return Woocommerce_Product_Finder_Pro_Shortcode::get_instance( $id );
	}

	/**
	 * Get the wizard shortcode data.
	 *
	 * @param int $id wizard id
	 *
	 * @return bool|Woocommerce_Product_Finder_Pro_Shortcode|null
	 */
	public function wpfp_get_wizard_form_by_id( $id ) {

		if ( Woocommerce_Product_Finder_Pro_Shortcode::wpfp_post_type === get_post_type( $id ) ) {
			return $this->wpfp_wizard( $id );
		}

		return null;
	}

	/**
	 * Serialize attribute name for matching attribute in database.
	 *
	 * @param string $attribute_name attribute name string
	 *
	 * @return string
	 */
	public function get_serialize_attribute_name( $attribute_name ) {
		return serialize( 'name' ) . serialize( trim( stripslashes( strtolower( $attribute_name ) ) ) );
	}


	/**
	 * Wizard product listing product id by get product attributes.
	 *
	 * @param int $product_id product id
	 * @param null|array $variation_data variation product data.
	 *
	 * @return mixed|array value of product attribute data with product array.
	 * @uses  wpfp-wizard-product-html.php
	 *
	 */
	public function wpfp_get_attribute_data_by_product_id( $product_id, $variation_data = null ) {
		if ( null === $variation_data ) {
			$product        = new WC_Product( $product_id );
			$variation_data = $product->get_attributes();
		}

		$product_attributes_custom_format = array();
		if ( ! empty( $variation_data ) && isset( $variation_data ) ) {
			foreach ( $variation_data as $attribute ) {
				if ( ( $attribute['is_taxonomy'] ) ) {
					$values     = wc_get_product_terms( $product_id, $attribute['name'], array( 'fields' => 'names' ) );
					$att_val    = apply_filters( 'woocommerce_attribute', wptexturize( get_imploded_array( str_replace( "'", "", $values ), ' | ' ) ), $attribute, str_replace( "'", "", $values ) );
					$att_val_ex = trim( $att_val );
				} else {
					$att_val_ex = trim( str_replace( "'", "", $attribute['value'] ) );
				}
				$product_attributes_custom_format[ $product_id ][ wc_attribute_label( $attribute['name'] ) ] = $att_val_ex;
			}
		}

		return $product_attributes_custom_format;
	}

	/**
	 * Product query default.
	 * @return array
	 */
	public function wpfp_default_query() {
		return apply_filters( 'wpfp_default_query', array(
			'post_type'      => 'product',
			'posts_per_page' => 10,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		) );
	}

	/**
	 * Selected question options data.
	 *
	 * @param array $wpfp_wizard_data selected value of wizard.
	 *
	 * @return array option value with required format.
	 */
	public function wpfp_get_selected_options_values( $wpfp_wizard_data ) {
		$wpfp_wizard_selected_options = $wpfp_wizard_data['wizardSelectedOptions'];
		$wpfp_wizard_selected_options = json_decode( $wpfp_wizard_selected_options, true );
		$wpfp_selected_attribute      = array();
		foreach ( $wpfp_wizard_selected_options as $wpfp_wizard_selected_option ) {
			if ( isset( $wpfp_wizard_selected_option ) && ! empty( $wpfp_wizard_selected_option ) ) {
				if ( isset( $wpfp_wizard_selected_option['checkbox'] ) && ! empty( $wpfp_wizard_selected_option['checkbox'] ) ) {
					foreach ( $wpfp_wizard_selected_option['checkbox'] as $wpfp_options ) {
						$wpfp_selected_attribute[] = array(
							'name'    => $wpfp_options['attributeName'],
							'name_db' => $wpfp_options['attributeNameDB'],
							'value'   => $wpfp_options['attributeValue']
						);

					}
				} else {
					$wpfp_selected_attribute[] = array(
						'name'    => $wpfp_wizard_selected_option['attributeName'],
						'name_db' => $wpfp_wizard_selected_option['attributeNameDB'],
						'value'   => $wpfp_wizard_selected_option['attributeValue']
					);

				}
			}
		}

		return $wpfp_selected_attribute;
	}

	/**
	 * set the attribute string data.
	 *
	 * @param array $wpfp_attributes option selected attribute name and values.
	 *
	 */
	public function set_attribute_name_and_value( $wpfp_attributes ) {

		foreach ( $wpfp_attributes as $wpfp_attribute ) {
			$value = str_replace( "’", "", $wpfp_attribute['value'] );
			$value = trim( str_replace( ", ", ",", $value ) );

			$this->wpfp_attribute_filter_data[] = array(
				trim( stripslashes( strtolower( $wpfp_attribute['name'] ) ) ) => $value,
			);
		}
	}

	/**
	 * Get the attribute string data.
	 * @return array attribute name and value format.
	 */
	public function get_attribute_name_and_value() {
		return $this->wpfp_attribute_filter_data;
	}

	/**
	 * Convert a multi-dimensional array into a single-dimensional array.
	 *
	 * @param array $array The multi-dimensional array.
	 *
	 * @return array|bool single-dimensional array.
	 */
	public function array_flatten( $array ) {
		if ( ! is_array( $array ) ) {
			return false;
		}
		$result = array();
		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$result = array_merge( $result, $this->array_flatten( $value ) );
			} else {
				$result[ $key ] = $value;
			}
		}

		return $result;
	}

	/**
	 * Get products based on categories.
	 *
	 * @param array $tax_ids categories ids.
	 *
	 * @return array product ids.
	 */
	public function wpfp_get_categories_wise_products( $tax_ids ) {
		$product_tax_args = array(
			'posts_per_page'         => - 1,
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'fields'                 => 'ids',
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);
		if ( ! empty( $tax_ids ) ) {
			$product_tax_args['tax_query'] = array(
				array(
					'taxonomy'         => 'product_cat',
					'field'            => 'id',
					'terms'            => $tax_ids,
					'include_children' => 0
				)
			);
		}

		$transient_key   = $this->wpfp_create_md5_key( 'wpfp_categories_wise_products_', $product_tax_args );
		$product_tax_ids = get_transient( $transient_key );
		if ( false === $product_tax_ids ) {
			$product_tax_result = new WP_Query( $product_tax_args );
			$product_tax_ids    = ( $product_tax_result->have_posts() ) ? $product_tax_result->posts : array();
			wp_reset_postdata();
			set_transient( $transient_key, $product_tax_ids, 12 * HOUR_IN_SECONDS );
		}

		return $product_tax_ids;
	}

	/**
	 * Get meta attributes available products ids.
	 *
	 * @param array $wpfp_attributes option selected attribute name and values.
	 * @param array $categories_products_ids product ids.
	 *
	 * @return array matched attribute product ids.
	 */
	public function wpfp_check_meta_attributes_available_or_not( $wpfp_attributes, $categories_products_ids ) {

		$product_meta_ids  = $this->wpfp_product_meta_ids( $categories_products_ids, $wpfp_attributes );
		$product_unique_id = $this->wpfp_product_meta_ids( $categories_products_ids, $wpfp_attributes, true );
		$product_tax_ids   = $this->wpfp_product_tax_ids( $wpfp_attributes );

		if ( ( is_array( $product_meta_ids ) && array_filter( $product_meta_ids ) ) && ( is_array( $product_unique_id ) && array_filter( $product_unique_id ) ) ) {
			$product_meta_common_id = array_merge( $product_meta_ids, $product_unique_id );
		} elseif ( is_array( $product_meta_ids ) && array_filter( $product_meta_ids ) ) {
			$product_meta_common_id = $product_meta_ids;
		} elseif ( is_array( $product_unique_id ) && array_filter( $product_unique_id ) ) {
			$product_meta_common_id = $product_unique_id;
		}

		$matched_products_ids = array();
		if ( ! empty( $product_meta_common_id ) && ! empty( $product_tax_ids ) ) {
			$matched_products_ids = array_merge( $product_meta_common_id, $product_tax_ids );
		} else if ( ! empty( $product_meta_common_id ) ) {
			$matched_products_ids = $product_meta_common_id;
		} else if ( ! empty( $product_tax_ids ) ) {
			$matched_products_ids = $product_tax_ids;
		}

		return ( array_filter( $matched_products_ids ) ) ? array_unique( array_filter( $matched_products_ids ) ) : array();
	}

	/**
	 * Get meta matching product ids.
	 *
	 * @param array $categories_products_ids product ids.
	 * @param array $wpfp_attributes option selected attribute name and values.
	 * @param bool $unique unique data fetch using this parameter.
	 *
	 * @return array product ids based on matching meta.
	 */
	public function wpfp_product_meta_ids( $categories_products_ids, $wpfp_attributes, $unique = false ) {
		global $wpdb;
		$prepare_args       = array();
		$product_meta_query = "";
		$product_meta_query .= "SELECT {$wpdb->prefix}posts.ID";
		$product_meta_query .= " FROM {$wpdb->prefix}posts";
		$product_meta_query .= " INNER JOIN {$wpdb->prefix}postmeta m1";
		$product_meta_query .= " ON ( {$wpdb->prefix}posts.ID = m1.post_id )";
		$product_meta_query .= " WHERE";
		$product_meta_query .= " {$wpdb->prefix}posts.post_type = '%s'";
		$prepare_args[]     = 'product';
		$product_meta_query .= " AND {$wpdb->prefix}posts.post_status = '%s'";
		$prepare_args[]     = 'publish';

		if ( is_array( $categories_products_ids ) && array_filter( $categories_products_ids ) ) {
			$tax_prepare_string = get_imploded_array( array_fill( 0, count( $categories_products_ids ), '%d' ) );
			$product_meta_query .= " AND {$wpdb->prefix}posts.ID IN ( {$tax_prepare_string} )";
			$prepare_args       = array_merge( $prepare_args, array_map( 'intval', $categories_products_ids ) );
		}

		$product_meta_query .= " AND ( m1.meta_key = '%s' )";
		$prepare_args[]     = '_product_attributes';
		if ( ! empty( $wpfp_attributes ) && is_array( $wpfp_attributes ) ) {
			foreach ( $wpfp_attributes as $all_fetch_key => $all_fetch_value ) {
				$serialized_attribute_name = $this->get_serialize_attribute_name( $all_fetch_key );
				$product_meta_query        .= " AND m1.meta_value LIKE %s";
				$prepare_args[]            = '%' . $serialized_attribute_name . '%';
				if ( false !== strpos( $all_fetch_value, ',' ) ) {
					$attribute_name_key       = get_exploded_string( trim( $all_fetch_value ) );
					$i                        = 0;
					$count_attribute_name_key = count( $attribute_name_key );
					foreach ( $attribute_name_key as $opt_ex_value ) {
						if ( $i === 0 ) {
							$product_meta_query .= " AND ( m1.meta_value REGEXP %s";
							$prepare_args[]     = '[[:<:]]' . trim( $opt_ex_value ) . '[[:>:]]';
						} else if ( $i > 0 ) {
							$product_meta_query .= " OR m1.meta_value REGEXP %s";
							$prepare_args[]     = '[[:<:]]' . trim( $opt_ex_value ) . '[[:>:]]';
						}
						$i ++;
						if ( $i === $count_attribute_name_key ) {
							$product_meta_query .= " ) ";
						};
					}
				} else {
					if ( true === $unique ) {
						$product_meta_query .= " OR m1.meta_value REGEXP %s";
						$prepare_args[]     = '[[:<:]]' . trim( $all_fetch_value ) . '[[:>:]]';
					} else {
						$product_meta_query .= " AND m1.meta_value REGEXP %s";
						$prepare_args[]     = '[[:<:]]' . trim( addslashes( $all_fetch_value ) ) . '[[:>:]]';
					}
				}
			}
		}
		$product_meta_query .= " GROUP BY {$wpdb->prefix}posts.ID";
		$product_meta_query .= " ORDER BY {$wpdb->prefix}posts.post_date";
		$product_meta_query .= " ASC";

		$transient_key = $this->wpfp_create_md5_key( 'wpfp_product_meta_ids_', $product_meta_query );
		$prd_meta_ids  = get_transient( $transient_key );
		if ( false === $prd_meta_ids ) {
			$prd_meta_ids        = array();
			$product_meta_result = $wpdb->get_results( $wpdb->prepare( $product_meta_query, $prepare_args ) );
			if ( ! empty( $product_meta_result ) && is_array( $product_meta_result ) ):
				foreach ( $product_meta_result as $value ) {
					$prd_meta_ids[ $value->ID ] = $value->ID;
				}
			endif;
			set_transient( $transient_key, $prd_meta_ids, 12 * HOUR_IN_SECONDS );
		}

		return $prd_meta_ids;
	}

	/**
	 * Get attribute taxonomy matching product ids.
	 *
	 * @param array $wpfp_attributes option selected attribute name and values.
	 *
	 * @return array product ids based on matching taxonomy attribute.
	 */
	public function wpfp_product_tax_ids( $wpfp_attributes ) {
		$tax_meta_query = array();

		if ( ! empty( $wpfp_attributes ) && is_array( $wpfp_attributes ) ) {

			foreach ( $wpfp_attributes as $all_fetch_key => $all_fetch_value ) {
				$attribute_slug_from_db = $this->wpfp_get_attribute_label_slug( $all_fetch_key );

				if ( false !== strpos( $all_fetch_value, ',' ) ) {
					$attribute_value_slug_from_db = $this->wpfp_get_attribute_values_slug( get_exploded_string( trim( $all_fetch_value ) ) );
					$tax_meta_query[]             = array(
						'taxonomy' => 'pa_' . $attribute_slug_from_db,//taxonomy
						'field'    => 'slug',
						'terms'    => $attribute_value_slug_from_db,
					);
				} else {
					$attribute_value_slug_from_db = $this->wpfp_get_attribute_values_slug( $all_fetch_value );
					$tax_meta_query[]             = array(
						'taxonomy' => 'pa_' . $attribute_slug_from_db,//taxonomy
						'field'    => 'slug',
						'terms'    => array( $attribute_value_slug_from_db ),
					);
				}
			}
		}
		$taxonomy_qry       = array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'tax_query'              => $tax_meta_query,
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'fields'                 => 'ids',
			'posts_per_page'         => - 1,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);
		$transient_key      = $this->wpfp_create_md5_key( 'wpfp_product_tax_ids_', $taxonomy_qry );
		$taxonomy_query_ids = get_transient( $transient_key );
		if ( false === $taxonomy_query_ids ) {
			$taxonomy_query     = new WP_Query( $taxonomy_qry );
			$taxonomy_query_ids = $taxonomy_query->posts;
			wp_reset_postdata();
			set_transient( $transient_key, $taxonomy_query_ids, 12 * HOUR_IN_SECONDS );
		}

		return $taxonomy_query_ids;
	}

	/**
	 * Get attribute name by label in custom query.
	 *
	 * @param string $attribute_label attribute label.
	 *
	 * @return mixed attribute name.
	 */
	public function wpfp_get_attribute_label_slug( $attribute_label ) {
		global $wpdb;

		$transient_key  = $this->wpfp_create_md5_key( 'wpfp_attribute_label_slug_', $attribute_label );
		$attribute_name = get_transient( $transient_key );
		if ( false === $attribute_name ) {
			$attribute_slug_row = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_label = %s",
					$attribute_label
				)
			);

			if ( isset( $attribute_slug_row ) && ! empty( $attribute_slug_row ) ) {
				$attribute_name = $attribute_slug_row->attribute_name;
			}
			set_transient( $transient_key, $attribute_name, 12 * HOUR_IN_SECONDS );
		}

		return $attribute_name;
	}

	/**
	 * Get attribute slug by attribute value.
	 *
	 * @param array $attribute_value attribute values.
	 *
	 * @return array|mixed|string attribute slug or null or attribute array.
	 */
	public function wpfp_get_attribute_values_slug( $attribute_value ) {

		global $wpdb;
		if ( ! empty( $attribute_value ) && is_array( $attribute_value ) ) {
			$transient_key            = $this->wpfp_create_md5_key( 'wpfp_wizard_attribute_value_', $attribute_value );
			$attribute_value_slug_arr = get_transient( $transient_key );

			if ( false === $attribute_value_slug_arr ) {
				foreach ( $attribute_value as $value ) {
					$attribute_value_replace = str_replace( "’", "'", $value );
					$get_att_value_rows      = $wpdb->get_row(
						$wpdb->prepare(
							"SELECT slug FROM {$wpdb->prefix}terms WHERE name = %s",
							stripslashes( $attribute_value_replace )
						)
					);
					if ( ! empty( $get_att_value_rows ) && $get_att_value_rows !== '' ) {
						$attribute_value_slug_arr[] = $get_att_value_rows->slug;
					}
				}
				set_transient( $transient_key, $attribute_value_slug_arr, 12 * HOUR_IN_SECONDS );
			}

			return $attribute_value_slug_arr;
		} else {
			$attribute_value_replace = str_replace( "’", "'", $attribute_value );

			$transient_key      = $this->wpfp_create_md5_key( 'wpfp_wizard_attribute_value_else_', $attribute_value_replace );
			$get_att_value_rows = get_transient( $transient_key );

			if ( false === $get_att_value_rows ) {
				$get_att_value_rows = $wpdb->get_row(
					$wpdb->prepare(
						"SELECT slug FROM {$wpdb->prefix}terms WHERE name = %s",
						stripslashes( $attribute_value_replace )
					)
				);
				set_transient( $transient_key, $get_att_value_rows, 12 * HOUR_IN_SECONDS );
			}
			if ( ! empty( $get_att_value_rows ) && $get_att_value_rows !== '' ) {
				return $get_att_value_rows->slug;
			}
		}

		return '';
	}

	/**
	 * Get all the product based on categories.
	 *
	 * @param array $categories_products_ids product ids.
	 *
	 * @return array products and attributes values.
	 */
	public function wpfp_get_all_products_and_attributes( $categories_products_ids ) {

		$all_products_args = array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'orderby'                => 'post_date',
			'order'                  => 'ASC',
			'fields'                 => 'ids',
			'posts_per_page'         => - 1,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);

		if ( is_array( $categories_products_ids ) && array_filter( $categories_products_ids ) ) {
			$all_products_args['post__in'] = $categories_products_ids;
		}

		$all_products_result      = new WP_Query( $all_products_args );
		$custom_product_id        = array();
		$all_attribute_of_product = array();
		if ( $all_products_result->have_posts() ) {
			foreach ( $all_products_result->posts as $wpfp_product_id ) {
				$custom_product_id[ $wpfp_product_id ] = trim( $wpfp_product_id );

				$product        = new WC_Product( $wpfp_product_id );
				$variation_data = $product->get_attributes();
				if ( ! empty( $variation_data ) && isset( $variation_data ) ) {
					foreach ( $variation_data as $attribute ) {
						if ( ( $attribute['is_taxonomy'] ) ) {
							$values     = wc_get_product_terms( $wpfp_product_id, $attribute['name'], array( 'fields' => 'names' ) );
							$att_val    = apply_filters( 'woocommerce_attribute', wptexturize( implode( ' | ', str_replace( "'", "", $values ) ) ), $attribute, str_replace( "'", "", $values ) );
							$att_val_ex = trim( $att_val );
						} else {
							$att_val_ex = trim( str_replace( "'", "", $attribute['value'] ) );
						}
						$all_attribute_of_product[ $wpfp_product_id ][ wc_attribute_label( $attribute['name'] ) ] = $att_val_ex;
					}
				}

			}
			wp_reset_postdata();
		}

		return array( 'product_ids' => $custom_product_id, 'all_attribute_value' => $all_attribute_of_product );
	}


	/**
	 * Get the attributes format product ids.
	 *
	 * @param array $wpfp_attributes option selected attribute name and values.
	 * @param array $get_all_product_attribute product all attributes.
	 * @param array $get_all_product_ids all product ids.
	 *
	 * @return array relevant attributes product ids.
	 */
	public function wpfp_order_result_ids( $wpfp_attributes, $get_all_product_attribute, $get_all_product_ids ) {

		$products_result_args  = array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'orderby'                => 'post_date',
			'order'                  => 'ASC',
			'posts_per_page'         => - 1,
			'fields'                 => 'ids',
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);
		$products_result_query = new WP_Query( $products_result_args );

		$wpfp_attributes_result_data = array();
		$attribute_record_array      = array();

		if ( ! empty( $wpfp_attributes ) && is_array( $wpfp_attributes ) ) {
			foreach ( $wpfp_attributes as $wpfp_attributes_result_key => $wpfp_attributes_result ) {
				// Remove single quote.
				$wpfp_attributes_result = array_unique( get_exploded_string( str_replace( "'", "", $wpfp_attributes_result ) ) );
				foreach ( $wpfp_attributes_result as $line ) {
					$attribute_record_array[][ $wpfp_attributes_result_key ] = strtolower( trim( $line ) );
				}

				$wpfp_attributes_result_data[ $wpfp_attributes_result_key ] = $wpfp_attributes_result;
			}
		}
		$id_to_order_by_product           = array();
		$id_to_order_by_not_match_product = array();
		if ( $products_result_query->have_posts() ) {

			$store_id             = array();
			$attribute_all_values = array();

			foreach ( $attribute_record_array as $attribute_record ) {
				foreach ( $attribute_record as $attribute_val ) {
					$attribute_all_values[] = $attribute_val;
				}
			}
			foreach ( $products_result_query->posts as $product_result_id ) {
				$match_id_and_counter     = 0;
				$not_match_id_and_counter = 0;
				if ( ! empty( $get_all_product_attribute ) && isset( $get_all_product_attribute ) ) {
					foreach ( $get_all_product_attribute as $attribute_product_id => $product_attributes ) {
						if ( $attribute_product_id === $product_result_id ) {
							foreach ( $product_attributes as $attribute_key => $value ) {
								if ( strpos( $value, '|' ) !== false ) {
									$attribute_value_exploded = get_exploded_string( trim( $value ), '|' );
								} else {
									$attribute_value_exploded = array( $value );
								}

								foreach ( $attribute_value_exploded as $attribute_value ) {
									if ( ! empty( $attribute_value ) && isset( $attribute_value ) ) {
										$get_option_key = $this->wpfp_get_option_key_based_on_attribute_data( trim( $attribute_value ), trim( $attribute_key ), $this->wpfp_wizard_id );
										if ( ! empty( $get_option_key ) ) {
											if ( strpos( $get_option_key, ',' ) !== false ) {
												$attribute_option_key = str_replace( ',', '_', $get_option_key );
											} else {
												$attribute_option_key = $get_option_key;
											}
										} else {
											$attribute_option_key = '';
										}

										if ( ! empty( $attribute_record_array ) && array_filter( $attribute_record_array ) ) {
											foreach ( $attribute_record_array as $attribute_result ) {

												foreach ( array_keys( $attribute_result ) as $record_key ) {

													if ( ! empty( $record_key ) &&
													     ( strtolower( $attribute_key ) === $record_key ) &&
													     ( in_array( trim( strtolower( $attribute_value ) ), $attribute_result, true ) )
													) {
														$match_id_and_counter ++;
														$id_to_order_by_product[ $product_result_id ] = $match_id_and_counter;

													} else if ( ! empty( $record_key ) &&
													            ( strtolower( $attribute_key ) === $record_key ) &&
													            ( ! in_array( trim( strtolower( $attribute_value ) ), $attribute_all_values, true ) ) &&
													            ( ! in_array( $product_result_id . "," . $attribute_option_key, $store_id, true ) )
													) {
														$not_match_id_and_counter ++;
														$store_id[] = $product_result_id . "," . $attribute_option_key;

														$id_to_order_by_not_match_product[ $product_result_id ] = $not_match_id_and_counter;
													} else if ( ! empty( $record_key ) &&
													            ( strtolower( $attribute_key ) === $record_key ) &&
													            ( ! in_array( trim( strtolower( $attribute_value ) ), $attribute_all_values, true ) ) &&
													            ( ! in_array( $product_result_id . "," . $attribute_option_key, $store_id, true ) )
													) {
														$not_match_id_and_counter ++;
														$store_id[] = $product_result_id . "," . $attribute_option_key;

														$id_to_order_by_not_match_product[ $product_result_id ] = $not_match_id_and_counter;
													}
												}
											}

										}
									}
								}
							}
						}
					}
				}
			}
		}
		$result_order_by_id = array();
		$order_result_test  = array();

		if ( ( is_array( $id_to_order_by_product ) && array_filter( $id_to_order_by_product ) ) || ( is_array( $id_to_order_by_not_match_product ) && array_filter( $id_to_order_by_not_match_product ) ) ) {

			$result_order_by_id = $id_to_order_by_product;
			arsort( $result_order_by_id );
			arsort( $id_to_order_by_product );

			$array_common_key              = array_intersect_key( $id_to_order_by_product, $id_to_order_by_not_match_product );
			$com_match_comm_key            = $id_to_order_by_product + $array_common_key;
			$diff_from_match_and_not_match = array_diff_key( $id_to_order_by_not_match_product, $id_to_order_by_product );
			$all_combine                   = $com_match_comm_key + $diff_from_match_and_not_match;
			$all_id_result                 = array_diff_key( $get_all_product_ids, $all_combine );
			$final_result                  = $all_combine + $all_id_result;
			$order_result_test             = array_keys( $final_result );
		}

		return array(
			'result_order_by_id' => $result_order_by_id,
			'order_result_test'  => $order_result_test
		);
	}


	/**
	 * Get option keys based attributes value data.
	 *
	 * @param string $option_name Attribute name based on option selection.
	 * @param string $option_attribute Attribute values based on option selection.
	 * @param int $wizard_id wizard id.
	 *
	 * @return string option key based on attribute matching.
	 */
	public function wpfp_get_option_key_based_on_attribute_data( $option_name, $option_attribute, $wizard_id ) {
		$_wpfp_questions_and_options_data = get_post_meta( $wizard_id, '_wpfp_questions_and_options_data', true );
		$wpfp_questions_and_options_array = json_decode( $_wpfp_questions_and_options_data, true );
		$wpfp_option_key                  = '';
		foreach ( $wpfp_questions_and_options_array as $wpfp_questions_and_options_data ) {
			foreach ( $wpfp_questions_and_options_data['options'] as $wpfp_option ) {
				$is_valid_attribute_name   = false;
				$is_valid_attribute_value  = false;
				$attribute_name            = $wpfp_option['attribute_name'];
				$wpfp_attribute_name_array = get_exploded_string( $attribute_name, '==' );

				if ( is_array( $wpfp_attribute_name_array ) && array_filter( $wpfp_attribute_name_array ) ) {

					$wpfp_attribute_name_array = array_map( 'trim', $wpfp_attribute_name_array );
					if ( in_array( $option_attribute, $wpfp_attribute_name_array, true ) ) {
						$is_valid_attribute_name = true;
					}
				}

				if ( in_array( $option_name, $wpfp_option['attribute_value'], true ) ) {
					$is_valid_attribute_value = true;
				}
				if ( true === $is_valid_attribute_name && true === $is_valid_attribute_value ) {
					$wpfp_option_key = $wpfp_option['key'];
				}
			}
		}

		return $wpfp_option_key;
	}

	/**
	 * Creating matching product query.
	 *
	 * @param array $categories_products_ids product ids.
	 * @param array $product_meta_attributes_ids product attribute meta available product ids.
	 * @param array $get_all_product_ids all products ids.
	 * @param bool $normal_match check matching perfect and normal product.
	 *
	 * @return array query.
	 */
	public function wpfp_matching_query( $categories_products_ids, $product_meta_attributes_ids, $get_all_product_ids, $normal_match = false ) {

		global $wpdb;

		if ( false === $normal_match ) {
			$match_query = "SELECT  {$wpdb->prefix}posts.ID AS common_id,{$wpdb->prefix}posts.ID AS perfect_id,0 as recently_id ";
		} else {
			$match_query = "SELECT  {$wpdb->prefix}posts.ID AS common_id,0 AS perfect_id,{$wpdb->prefix}posts.ID as recently_id ";
		}
		$match_query .= "FROM {$wpdb->prefix}posts ";


		if ( false === $normal_match ) {
			$inner_query   = $this->wpfp_create_inner_query( $categories_products_ids, $product_meta_attributes_ids, $get_all_product_ids );
			$match_query   .= $inner_query['perfect_match_query'];
			$match_prepare = $inner_query['perfect_match_prepare'];
		} else {
			$inner_query   = $this->wpfp_create_inner_query( $categories_products_ids, $product_meta_attributes_ids, $get_all_product_ids, true );
			$match_query   .= $inner_query['normal_match_query'];
			$match_prepare = $inner_query['normal_match_prepare'];
		}

		$match_query .= " GROUP by common_id";

		return array( 'match_query' => $match_query, 'match_prepare' => $match_prepare );

	}

	/**
	 * Creating inner query.
	 *
	 * @param array $categories_products_ids product ids.
	 * @param array $product_meta_attributes_ids product attribute meta available product ids.
	 * @param array $get_all_product_ids all products ids.
	 * @param bool $normal_match check matching perfect and normal product.
	 *
	 * @return array query.
	 */
	public function wpfp_create_inner_query( $categories_products_ids, $product_meta_attributes_ids, $get_all_product_ids, $normal_match = false ) {
		global $wpdb;
		$inner_prepare   = array();
		$inner_query     = "INNER JOIN {$wpdb->prefix}postmeta m1 ON ( {$wpdb->prefix}posts.ID = m1.post_id ) ";
		$inner_query     .= "WHERE {$wpdb->prefix}posts.post_type= '%s'";
		$inner_prepare[] = 'product';
		$inner_query     .= " AND {$wpdb->prefix}posts.post_status= '%s'";
		$inner_prepare[] = 'publish';

		if ( is_array( $categories_products_ids ) && ! empty( $categories_products_ids ) ) {
			$post_in_prepare = get_imploded_array( array_fill( 0, count( $categories_products_ids ), '%d' ) );
			$inner_query     .= " AND {$wpdb->prefix}posts.ID IN ( {$post_in_prepare})";
			$inner_prepare   = array_merge( $inner_prepare, array_map( 'intval', $categories_products_ids ) );
		}

		if ( false === $normal_match ) {
			if ( is_array( $product_meta_attributes_ids ) && array_filter( $product_meta_attributes_ids ) ) {
				$in_prepare    = get_imploded_array( array_fill( 0, count( $product_meta_attributes_ids ), '%d' ) );
				$inner_query   .= " AND ( {$wpdb->prefix}posts.ID IN ( {$in_prepare} ) )";
				$inner_prepare = array_merge( $inner_prepare, array_map( 'intval', $product_meta_attributes_ids ) );
			} else {
				$not_in_prepare = get_imploded_array( array_fill( 0, count( $get_all_product_ids ), '%d' ) );
				$inner_query    .= " AND ( {$wpdb->prefix}posts.ID NOT IN ( {$not_in_prepare} ) )";
				$inner_prepare  = array_merge( $inner_prepare, array_map( 'intval', $get_all_product_ids ) );
			}

		} else {

			if ( is_array( $product_meta_attributes_ids ) && array_filter( $product_meta_attributes_ids ) ) {
				$in_prepare    = get_imploded_array( array_fill( 0, count( $product_meta_attributes_ids ), '%d' ) );
				$inner_query   .= " AND ( {$wpdb->prefix}posts.ID NOT IN ( {$in_prepare} ) )";
				$inner_prepare = array_merge( $inner_prepare, array_map( 'intval', $product_meta_attributes_ids ) );
			} else {
				$not_in_prepare = get_imploded_array( array_fill( 0, count( $get_all_product_ids ), '%d' ) );
				$inner_query    .= " AND ( {$wpdb->prefix}posts.ID IN ( {$not_in_prepare} ) )";
				$inner_prepare  = array_merge( $inner_prepare, array_map( 'intval', $get_all_product_ids ) );
			}
		}
		if ( false === $normal_match ) {
			return array( 'perfect_match_query' => $inner_query, 'perfect_match_prepare' => $inner_prepare );
		} else {
			return array( 'normal_match_query' => $inner_query, 'normal_match_prepare' => $inner_prepare );
		}
	}

	/**
	 * Final wp query for perfect and normal result.
	 *
	 * @param array $combine_products_result final query result.
	 * @param int $paged
	 *
	 * @return string
	 */
	public function wpfp_wp_product_query( $combine_products_result, $paged = 1, $wpfp_identity = '' ) {
		$prefect_match_ids = array();
		$normal_match_ids  = array();
		if ( isset( $combine_products_result ) && ! empty( $combine_products_result ) ) {
			foreach ( $combine_products_result as $combine_products ) {
				if ( 0 !== (int) $combine_products->perfect_id ) {
					$prefect_match_ids[] = (int) $combine_products->perfect_id;
				}
				if ( 0 !== (int) $combine_products->recently_id ) {
					$normal_match_ids[] = (int) $combine_products->recently_id;
				}
			}
		}

		$template_html = '';
		if ( array_filter( $prefect_match_ids ) || array_filter( $normal_match_ids ) ) {

			if ( '' === $wpfp_identity || 'perfect-matching' === $wpfp_identity ) {

				if ( array_filter( $prefect_match_ids ) ) {
					$wpfp_args = array(
						'posts_per_page' => $this->get_backend_per_page_limit(),
						'paged'          => $paged,
						'orderby'        => 'post__in',
						'post__in'       => array_filter( $prefect_match_ids ),
					);
					$wpfp_args = wp_parse_args( $wpfp_args, $this->wpfp_default_query() );

					$transient_key   = $this->wpfp_create_md5_key( 'wpfp_wizard_perfect_matching_', $wpfp_args );
					$wizard_wp_query = get_transient( $transient_key );

					if ( false === $wizard_wp_query ) {
						$wizard_wp_query = new WP_Query( $wpfp_args );
						set_transient( $transient_key, $wizard_wp_query, 12 * HOUR_IN_SECONDS );
					}
					$this->wpfp_product_headline = $this->get_perfect_match_title();
					$this->wpfp_identity         = 'perfect-matching';


					$template_html .= $this->wpfp_product_list_html( $wizard_wp_query );
				}
			}

			if ( '' === $wpfp_identity || 'normal-matching' === $wpfp_identity ) {
				if ( array_filter( $normal_match_ids ) ) {
					$wpfp_args       = array(
						'posts_per_page' => $this->get_backend_per_page_limit(),
						'paged'          => $paged,
						'orderby'        => 'post__in',
						'post__in'       => array_filter( $normal_match_ids ),
					);
					$wpfp_args       = wp_parse_args( $wpfp_args, $this->wpfp_default_query() );
					$transient_key   = $this->wpfp_create_md5_key( 'wpfp_wizard_normal_matching_', $wpfp_args );
					$wizard_wp_query = get_transient( $transient_key );

					if ( false === $wizard_wp_query ) {
						$wizard_wp_query = new WP_Query( $wpfp_args );
						set_transient( $transient_key, $wizard_wp_query, 12 * HOUR_IN_SECONDS );
					}
					$this->wpfp_product_headline = $this->get_recent_match_title();
					$this->wpfp_identity         = 'normal-matching';
					$template_html               .= $this->wpfp_product_list_html( $wizard_wp_query );
				}
			}
		}

		return $template_html;
	}

	/**
	 * Get the HTML for product listing using executing wp_query.
	 *
	 * @param object $wpfp_query query result.
	 *
	 * @return bool|false|mixed|string HTML of result.
	 */
	public function wpfp_product_list_html( $wpfp_query ) {

		$cache_key     = $this->wpfp_create_md5_key( 'wpfp_wizard_html_template_', $wpfp_query );
		$template_html = wp_cache_get( $cache_key, 'product-finder-pro' );

		if ( false === $template_html ) {
			if ( $wpfp_query->have_posts() ) {

				ob_start();
				include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/wpfp-wizard-product-html.php';

				$template_html = ob_get_clean();
				wp_cache_set( $cache_key, $template_html, 'product-finder-pro' );
			} else {
				ob_start();
				include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/wpfp-wizard-no-product-found-html.php';

				$template_html = ob_get_clean();
			}

		}

		return $template_html;
	}

	/**
	 * Creating html for pagination for product result.
	 *
	 * @param object $wpfp_query query result.
	 * @param int $posts_per_page default posts per page set.
	 *
	 */
	public function wpfp_product_pagination_html( $wpfp_query, $posts_per_page = 10 ) {

		// Current page.
		$current_page = (int) $wpfp_query->query_vars['paged'];
		// The overall amount of pages.
		$max_page = $wpfp_query->max_num_pages;

		// We don't have to display pagination or load more button in this case.
		if ( $max_page <= 1 ) {
			echo '';
		}

		// Set the current page to 1 if not exists.
		if ( empty( $current_page ) || $current_page === 0 ) {
			$current_page = 1;
		}

		// You can play with this parameter - how much links to display in pagination.
		$links_in_the_middle         = 3;
		$links_in_the_middle_minus_1 = $links_in_the_middle - 1;

		// The code below is required to display the pagination properly for large amount of pages.
		$first_link_in_the_middle = $current_page - floor( $links_in_the_middle_minus_1 / 2 );
		$last_link_in_the_middle  = $current_page + ceil( $links_in_the_middle_minus_1 / 2 );


		// Some calculations with $first_link_in_the_middle and $last_link_in_the_middle.
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

		// Begin to generate HTML of the pagination.
		$pagination_html = sprintf( '<div class="wpfp-nav-pagination-pages">' );

		if ( $wpfp_query->found_posts > $posts_per_page ) {
			$pagination_html .= sprintf( '<span class="wpfp-pagination-links" data-nonce="%s" data-identity="%s">',
				esc_attr( wp_create_nonce( 'wpfp-pagination' ) ),
				esc_attr( $this->wpfp_identity )
			);
			// Arrow left (First page).
			if ( $current_page !== 1 ) {
				$pagination_html .= $this->wpfp_get_link_html( 1, __( "«", "woo-product-finder" ), 'first-prev' );
			}

			// Arrow left (previous page).
			if ( $current_page > 1 ) {
				$first_page_number = $current_page - 1;
				$pagination_html   .= $this->wpfp_get_link_html( $first_page_number, __( "‹", "woo-product-finder" ), 'prev' );
			}

			// When to display "..." and the first page before it.
			if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page ) {
				$pagination_html .= $this->wpfp_get_link_html( 1, __( "1", "woo-product-finder" ) );

				if ( $first_link_in_the_middle !== 2 ) {
					$pagination_html .= sprintf( '<span class="page-numbers dots">...</span>' );
				}

			}

			// Loop page links in the middle between "..." and "...".
			for ( $lopp_number = (int) $first_link_in_the_middle; (int) $lopp_number <= $last_link_in_the_middle; $lopp_number ++ ) {
				if ( $lopp_number === $current_page ) {
					$pagination_html .= sprintf( '<span class="page-numbers current">%d</span>',
						esc_html( $lopp_number )
					);
				} else {
					$pagination_html .= $this->wpfp_get_link_html( $lopp_number, $lopp_number );
				}
			}

			// When to display "..." and the last page after it.
			if ( $last_link_in_the_middle < $max_page ) {

				if ( $last_link_in_the_middle !== ( $max_page - 1 ) ) {
					$pagination_html .= sprintf( '<span class="page-numbers dots">...</span>' );
				}

				$pagination_html .= $this->wpfp_get_link_html( $max_page, $max_page );
			}

			// Arrow right (next page).
			if ( $current_page !== $last_link_in_the_middle ) {
				$next_page_number = $current_page + 1;
				$pagination_html  .= $this->wpfp_get_link_html( $next_page_number, __( "›", "woo-product-finder" ), 'next' );
			}
			// Arrow right (Last page).
			if ( $current_page < $max_page ) {
				$pagination_html .= $this->wpfp_get_link_html( $max_page, __( "»", "woo-product-finder" ), 'last' );
			}
			$pagination_html .= sprintf( '</span>' );
		}

		$pagination_html .= sprintf( '<span class="wpfp-nav-pagination-displaying-num">%d %s</span>',
			$wpfp_query->found_posts,
			$this->get_total_count_title() );

		if ( $wpfp_query->found_posts > $posts_per_page ) {
			$pagination_html .= sprintf( '
                <span id="table-paging" class="paging-input">
                    <span class="wpfp-nav-pagination-paging-text">1 of <span class="total-pages">%d</span></span>
                </span>',
				$max_page );
		}
		$pagination_html .= sprintf( '</div>' );


		$allow_html = array(
			'div'  => array(
				'class' => array(),
			),
			'a'    => array(
				'class'            => array(),
				'href'             => array(),
				'data-page-number' => array(),
				'data-wizard-id'   => array(),
			),
			'span' => array(
				'class'         => array(),
				'data-nonce'    => array(),
				'data-identity' => array(),
			),
		);
		echo wp_kses( $pagination_html, $allow_html );
	}

	/**
	 * Get the pagination html.
	 *
	 * @param int $page_number pagination page number.
	 * @param string $page_text text of button and tab string.
	 * @param string $class_name pagination class name.
	 *
	 * @return string|array
	 */
	public function wpfp_get_link_html( $page_number, $page_text, $class_name = '' ) {
		return sprintf(
			'<a href="#" data-page-number="%s" data-wizard-id="%s" class="page-numbers %s">%s</a>',
			$page_number,
			$this->wpfp_wizard_id,
			$class_name,
			$page_text
		);
	}

	/**
	 * Create a key for set transient.
	 *
	 * @param string $key_text text for prefix of transient key.
	 * @param array|string|object|mixed $args creating uniq id for transient key.
	 *
	 * @return string transient key.
	 */
	public function wpfp_create_md5_key( $key_text, $args ) {
		return $key_text . md5( wp_json_encode( $args ) );
	}

	/**
	 * Listing and pagination common function.
	 *
	 * @param array $wpfp_selected_attribute Selected attributes.
	 * @param array $wpfp_wizard_categories_ids Category wizard ids.
	 * @param int $page_number page number.
	 * @param string $wpfp_identity identity for command and recent.
	 *
	 * @return array output html.
	 */
	public function wpfp_common_function_for_list_and_pagination( $wpfp_selected_attribute, $wpfp_wizard_categories_ids, $page_number = 1, $wpfp_identity = '' ) {
		$result = array();

		$this->set_attribute_name_and_value( $wpfp_selected_attribute );
		$wpfp_attribute_data     = $this->get_attribute_name_and_value();
		$wpfp_attributes         = $this->array_flatten( $wpfp_attribute_data );
		$categories_products_ids = array();
		if ( isset( $wpfp_wizard_categories_ids ) && ! empty( $wpfp_wizard_categories_ids ) && is_array( $wpfp_wizard_categories_ids ) && array_filter( $wpfp_wizard_categories_ids ) ) {
			$categories_products_ids = $this->wpfp_get_categories_wise_products( $wpfp_wizard_categories_ids );
		}

		$product_meta_attributes_ids = $this->wpfp_check_meta_attributes_available_or_not( $wpfp_attributes, $categories_products_ids );
		$get_all_product_data        = $this->wpfp_get_all_products_and_attributes( $categories_products_ids );
		$get_all_product_ids         = $get_all_product_data['product_ids'];
		$get_all_product_attribute   = $get_all_product_data['all_attribute_value'];

		$wpfp_order_result = $this->wpfp_order_result_ids( $wpfp_attributes, $get_all_product_attribute, $get_all_product_ids );

		$perfect_matching_query = $this->wpfp_matching_query( $categories_products_ids, $product_meta_attributes_ids, $get_all_product_ids );
		$normal_matching_query  = $this->wpfp_matching_query( $categories_products_ids, $product_meta_attributes_ids, $get_all_product_ids, true );
		$result_order_by_id     = ( array_filter( $wpfp_order_result['result_order_by_id'] ) ) ? $wpfp_order_result['result_order_by_id'] : array();
		$order_result_test      = ( array_filter( $wpfp_order_result['order_result_test'] ) ) ? $wpfp_order_result['order_result_test'] : array();

		$combine_qry           = "( {$perfect_matching_query['match_query']} ) union all ( {$normal_matching_query['match_query']} )";
		$combine_query_prepare = array_merge( $perfect_matching_query['match_prepare'], $normal_matching_query['match_prepare'] );

		if ( ! empty( $result_order_by_id ) && ! empty( $order_result_test ) ) {
			$combine_result_prepare = get_imploded_array( array_fill( 0, count( $order_result_test ), '%d' ) );
			$combine_qry            .= " ORDER BY FIELD( common_id ,{$combine_result_prepare})";
			$combine_query_prepare  = array_merge( $combine_query_prepare, array_map( 'intval', $order_result_test ) );
		}
		$this->set_wizard_setting_data( wpfp_get_wizard_setting_data( $this->wpfp_wizard_id ) );

		global $wpdb;
		$combine_products_result = $wpdb->get_results( $wpdb->prepare( $combine_qry, $combine_query_prepare ) );

		$html = '';
		$html .= $this->wpfp_wp_product_query( $combine_products_result, $page_number, $wpfp_identity );

		$result['html']               = $html;
		$result['showAttributeCount'] = $this->get_show_attribute();
		$result['success']            = 1;
		$result['msg']                = esc_html__( 'Successfully...', 'woo-product-finder' );

		return $result;
	}

	/**
	 * Product listing ajax callback.
	 */
	public function wpfp_get_ajax_product_list_callback() {
		$result            = array();
		$result['success'] = 0;
		$result['msg']     = esc_html__( 'Something went wrong.', 'woo-product-finder' );

		$wpfp_wizard_args = array(
			'security'              => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
			'wizardID'              => FILTER_SANITIZE_NUMBER_INT,
			'optionKey'             => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
			'wizardCategoriesIDs'   => FILTER_SANITIZE_STRING,
			'wizardSelectedOptions' => array(
				'filter' => FILTER_FORCE_ARRAY,
				'flags'  => FILTER_REQUIRE_SCALAR,
			),
		);
		$wpfp_wizard_data = filter_input_array( INPUT_GET, $wpfp_wizard_args );


		$wpfp_wizard_id             = $wpfp_wizard_data['wizardID'];
		$wpfp_nonce                 = $wpfp_wizard_data['security'];
		$wpfp_option_key            = $wpfp_wizard_data['optionKey'];
		$wpfp_wizard_categories_ids = $wpfp_wizard_data['wizardCategoriesIDs'];
		$wpfp_wizard_categories_ids = isset( $wpfp_wizard_categories_ids ) && ! empty( $wpfp_wizard_categories_ids ) ? get_exploded_string( $wpfp_wizard_categories_ids ) : 0;
		$this->wpfp_wizard_id       = $wpfp_wizard_id;

		if ( ! isset( $wpfp_nonce ) || ( ! wp_verify_nonce( $wpfp_nonce, $this->wpfp_wizard_id . $wpfp_option_key ) && ! wp_verify_nonce( $wpfp_nonce, $this->wpfp_wizard_id . $this->get_wizard_result_display_mode() ) ) ) {
			$result['msg'] = esc_html__( 'Security check failed.', 'woo-product-finder' );
			echo wp_json_encode( $result );
			wp_die();
		}

		$wpfp_selected_attribute = $this->wpfp_get_selected_options_values( $wpfp_wizard_data );

		if ( ! isset( $wpfp_selected_attribute ) || ! array_filter( $wpfp_selected_attribute ) ) {
			wp_die( - 1 );
		}

		$result = $this->wpfp_common_function_for_list_and_pagination( $wpfp_selected_attribute, $wpfp_wizard_categories_ids, $wpfp_wizard_data );

		echo wp_json_encode( $result );
		wp_die();
	}

	/**
	 * Ajax product pagination callback.
	 */
	public function wpfp_ajax_product_pagination_callback() {
		$result            = array();
		$result['success'] = 0;
		$result['msg']     = esc_html__( 'Something went wrong.', 'woo-product-finder' );

		$wpfp_wizard_args           = array(
			'security'              => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
			'wizardID'              => FILTER_SANITIZE_NUMBER_INT,
			'pageNumber'            => FILTER_SANITIZE_NUMBER_INT,
			'wizardIdentity'        => FILTER_SANITIZE_STRING,
			'wizardCategoriesIDs'   => FILTER_SANITIZE_STRING,
			'wizardSelectedOptions' => array(
				'filter' => FILTER_FORCE_ARRAY,
				'flags'  => FILTER_REQUIRE_SCALAR,
			),
		);
		$wpfp_wizard_data           = filter_input_array( INPUT_GET, $wpfp_wizard_args );
		$wpfp_wizard_id             = $wpfp_wizard_data['wizardID'];
		$wpfp_nonce                 = $wpfp_wizard_data['security'];
		$wpfp_page_number           = $wpfp_wizard_data['pageNumber'];
		$wpfp_identity              = $wpfp_wizard_data['wizardIdentity'];
		$wpfp_wizard_categories_ids = $wpfp_wizard_data['wizardCategoriesIDs'];
		$wpfp_wizard_categories_ids = isset( $wpfp_wizard_categories_ids ) && ! empty( $wpfp_wizard_categories_ids ) ? get_exploded_string( $wpfp_wizard_categories_ids ) : 0;

		$this->wpfp_wizard_id = $wpfp_wizard_id;
		if ( ! isset( $wpfp_nonce ) || ! wp_verify_nonce( $wpfp_nonce, 'wpfp-pagination' ) ) {
			$result['msg'] = esc_html__( 'Security check failed.', 'woo-product-finder' );
			echo wp_json_encode( $result );
			wp_die();
		}
		$wpfp_selected_attribute = $this->wpfp_get_selected_options_values( $wpfp_wizard_data );

		if ( ! isset( $wpfp_selected_attribute ) || ! array_filter( $wpfp_selected_attribute ) ) {
			wp_die( - 1 );
		}

		$result = $this->wpfp_common_function_for_list_and_pagination( $wpfp_selected_attribute, $wpfp_wizard_categories_ids, $wpfp_page_number, $wpfp_identity );

		echo wp_json_encode( $result );
		wp_die();
	}


}
