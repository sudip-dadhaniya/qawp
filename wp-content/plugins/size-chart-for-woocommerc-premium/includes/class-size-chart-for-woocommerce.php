<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/includes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Size_Chart_For_Woocommerce
 * @subpackage Size_Chart_For_Woocommerce/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Size_Chart_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Size_Chart_For_Woocommerce_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'size-chart-for-woocommerce';
		$this->version     = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$prefix = is_network_admin() ? 'network_admin_' : '';
		add_filter( "{$prefix}plugin_action_links_" . plugin_dir_path( plugin_basename( dirname( __FILE__ ) ) ) . 'size-chart-for-woocommerce.php', array( $this, 'plugin_action_links_callback' ), 10, 4 );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Size_Chart_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Size_Chart_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Size_Chart_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Size_Chart_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the core plugin.
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-size-chart-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality of the plugin.
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-size-chart-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining internationalization functionality of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-size-chart-for-woocommerce-functions.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-size-chart-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing side of the site.
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-size-chart-for-woocommerce-public.php';

		$this->loader = new Size_Chart_For_Woocommerce_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Size_Chart_For_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Size_Chart_For_Woocommerce_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Size_Chart_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles_callback' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts_callback' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'size_chart_meta_image_enqueue_callback' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'size_chart_publish_button_disable_callback' );

		$this->loader->add_action( 'init', $plugin_admin, 'size_chart_register_post_type_chart_callback' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'welcome_screen_do_activation_redirect_callback' );
		if ( ! get_option( 'default_size_chart' ) ) {
			$this->loader->add_action( 'admin_init', $plugin_admin, 'size_chart_pro_default_posts_callback' );
		}

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'size_chart_menu_callback' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'welcome_pages_screen_callback' );

		$this->loader->add_action( 'admin_head', $plugin_admin, 'welcome_screen_remove_menus_callback' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'size_chart_preview_dialog_box_callback' );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'size_chart_add_meta_box_callback' );

		$this->loader->add_action( 'save_post', $plugin_admin, 'product_select_size_chart_save_callback' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'size_chart_content_meta_save_callback' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'size_chart_save_in_products_callback' );

		$this->loader->add_action( 'admin_action_size_chart_duplicate_post', $plugin_admin, 'size_chart_duplicate_post_callback' );
		$this->loader->add_action( 'admin_action_size_chart_preview_post', $plugin_admin, 'size_chart_preview_post_callback' );

		$this->loader->add_action( 'wp_ajax_size_chart_delete_image', $plugin_admin, 'size_chart_delete_image_callback' );
		$this->loader->add_action( 'wp_ajax_size_chart_preview_post', $plugin_admin, 'size_chart_preview_post_callback' );
		$this->loader->add_action( 'wp_ajax_size_chart_search_chart', $plugin_admin, 'size_chart_search_chart_callback' );
		$this->loader->add_action( 'wp_ajax_size_chart_product_assign', $plugin_admin, 'size_chart_product_assign_callback' );
		$this->loader->add_action( 'wp_ajax_size_chart_quick_search_products', $plugin_admin, 'size_chart_quick_search_products_callback' );

		$this->loader->add_filter( 'manage_edit-size-chart_columns', $plugin_admin, 'size_chart_column_callback' );
		$this->loader->add_filter( 'manage_size-chart_posts_custom_column', $plugin_admin, 'size_chart_manage_column_callback' );
		$this->loader->add_filter( 'manage_size-chart_posts_custom_column', $plugin_admin, 'size_chart_manage_column_callback' );

		$this->loader->add_action( 'size_chart_about', $plugin_admin, 'size_chart_about_callback' );
		$this->loader->add_filter( 'post_row_actions', $plugin_admin, 'size_chart_remove_row_actions_callback', 10, 2 );
		$this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'size_chart_filter_default_template_callback' );
		$this->loader->add_filter( 'parse_query', $plugin_admin, 'size_chart_filter_default_template_query_callback' );
		$this->loader->add_action( 'trashed_post', $plugin_admin, 'size_chart_selected_chart_delete_callback' );

		$get_post_type = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );
		if ( ! empty( $get_post_type ) && ( 'size-chart' === $get_post_type ) ) {
			$this->loader->add_filter( 'admin_footer_text', $plugin_admin, 'size_chart_pro_admin_footer_review_callback' );
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'size_chart_pro_admin_notice_review_callback' );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Size_Chart_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles_callback' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts_callback' );
		$this->loader->add_filter( 'woocommerce_product_tabs', $plugin_public, 'size_chart_custom_product_tab_callback' );
		$this->loader->add_action( 'woocommerce_before_single_product', $plugin_public, 'size_chart_popup_button_position_callback' );
		$this->loader->add_filter( 'woocommerce_paypal_args', $plugin_public, 'paypal_bn_code_filter_callback', 99, 1 );
	}

	/**
	 * Return the plugin action links.  This will only be called if the plugin
	 * is active.
	 *
	 * @param array $actions associative array of action names to anchor tags
	 *
	 * @return array associative array of plugin action links
	 * @since 1.0.0
	 */
	public function plugin_action_links_callback( $actions, $plugin_file, $plugin_data, $context ) {
		$custom_actions = array(
			'configure' => sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=size-chart&page=size_chart_setting_page' ), __( 'Settings', 'size-chart-for-woocommerce' ) ),
			'docs'      => sprintf( '<a href="%s" target="_blank">%s</a>', SIZE_CHART_PLUGIN_DOC_URL, __( 'Docs', 'size-chart-for-woocommerce' ) ),
			'support'   => sprintf( '<a href="%s" target="_blank">%s</a>', 'https://www.thedotstore.com/support/', __( 'Support', 'size-chart-for-woocommerce' ) )
		);

		// add the links to the front of the actions list
		return array_merge( $custom_actions, $actions );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Size_Chart_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

}
