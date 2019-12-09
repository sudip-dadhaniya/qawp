<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/dots
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/includes
 */

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
 * @package    Woocommerce_Product_Finder_Pro
 * @subpackage Woocommerce_Product_Finder_Pro/includes
 * @author     Multidots <hello@multidots.com>
 */
class Woocommerce_Product_Finder_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_Product_Finder_Pro_Loader $loader Maintains and registers all hooks for the plugin.
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
	 * @param $name
	 * @param $version
	 *
	 * @since    1.0.0
	 */
	public function __construct($name, $version) {


		$this->plugin_name = $name;
		$this->version     = $version;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_Product_Finder_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_Product_Finder_Pro_i18n. Defines internationalization functionality.
	 * - Woocommerce_Product_Finder_Pro_Admin. Defines all hooks for the admin area.
	 * - Woocommerce_Product_Finder_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {



		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-product-finder-pro-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-product-finder-pro-i18n.php';

		/**
		 * The functions responsible for common functions functionality.
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-product-finder-pro-functions.php';

		/**
		 * The class responsible for Wizard setting functions.
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-product-finder-pro-settings.php';

		/**
		 * The file responsible for Shortcode functionality.
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-product-finder-pro-shortcode.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-product-finder-pro-admin.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-product-finder-pro-public.php';

		$this->loader = new Woocommerce_Product_Finder_Pro_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_Product_Finder_Pro_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_Product_Finder_Pro_i18n();

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

		$plugin_admin = new Woocommerce_Product_Finder_Pro_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'wpfp_admin_enqueue_styles_scripts_callback' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpfp_dot_store_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wpfp_welcome_plugin_screen_do_activation_redirect' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'wpfp_remove_admin_submenus' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'wpfp_admin_notices' );

		// Form post callback functions.
		$this->loader->add_action( 'admin_post_wpfp_add_wizard', $plugin_admin, 'wpfp_add_wizard_callback' );
		$this->loader->add_action( 'admin_post_wpfp_edit_wizard', $plugin_admin, 'wpfp_edit_wizard_callback' );
		$this->loader->add_action( 'admin_post_wpfp_setting_wizard', $plugin_admin, 'wpfp_setting_wizard_callback' );
		$this->loader->add_action( 'admin_post_wpfp_master_setting_wizard', $plugin_admin, 'wpfp_master_setting_wizard_callback' );
		$this->loader->add_action( 'admin_post_wpfp_delete_wizard', $plugin_admin, 'wpfp_delete_wizard_callback' );
		$this->loader->add_action( 'admin_post_wpfp_wizard_list', $plugin_admin, 'wpfp_wizard_list_delete_callback' );

		// Ajax callback functions.
		$this->loader->add_action( 'wp_ajax_wpfp_search_attribute_name', $plugin_admin, 'wpfp_search_attribute_name_ajax_callback' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woocommerce_Product_Finder_Pro_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wpfp_public_enqueue_styles_scripts_callback' );

		// Ajax callback functions.
		$this->loader->add_action( 'wp_ajax_wpfp_get_ajax_product_list', $plugin_public, 'wpfp_get_ajax_product_list_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_ajax_product_list', $plugin_public, 'wpfp_get_ajax_product_list_callback' );
		$this->loader->add_action( 'wp_ajax_wpfp_ajax_product_pagination', $plugin_public, 'wpfp_ajax_product_pagination_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_wpfp_ajax_product_pagination', $plugin_public, 'wpfp_ajax_product_pagination_callback' );

		// Publish Shortcode.
		$this->loader->add_shortcode( 'wpfp', $plugin_public, 'wpfp_shortcode_callback' );

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
	 * @return    Woocommerce_Product_Finder_Pro_Loader    Orchestrates the hooks of the plugin.
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
