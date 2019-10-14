<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
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
 * @package    Woo_Checkout_For_Digital_Goods
 * @subpackage Woo_Checkout_For_Digital_Goods/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Checkout_For_Digital_Goods {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Checkout_For_Digital_Goods_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
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

		$this->plugin_name = 'woo-checkout-for-digital-goods';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_public_hooks();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Checkout_For_Digital_Goods_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Checkout_For_Digital_Goods_i18n. Defines internationalization functionality.
	 * - Woo_Checkout_For_Digital_Goods_Admin. Defines all hooks for the admin area.
	 * - Woo_Checkout_For_Digital_Goods_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-checkout-for-digital-goods-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-checkout-for-digital-goods-i18n.php';
		
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-checkout-for-digital-goods-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-checkout-for-digital-goods-admin.php';

		$this->loader = new Woo_Checkout_For_Digital_Goods_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Checkout_For_Digital_Goods_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_Checkout_For_Digital_Goods_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_Checkout_For_Digital_Goods_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $woo_checkout_unserlize_array = maybe_unserialize(get_option('wcdg_checkout_setting'));
        $woo_checkout_status = isset($woo_checkout_unserlize_array['wcdg_status'])? $woo_checkout_unserlize_array['wcdg_status'] : '';
        if ( wcfdg_fs()->is__premium_only() ) {
            if (wcfdg_fs()->can_use_premium_code()) {
                $woo_user_role_field = isset($woo_checkout_unserlize_array['wcdg_user_role_field']) ? $woo_checkout_unserlize_array['wcdg_user_role_field'] : '';
                $current_user = wp_get_current_user();
                $wcdg_user_role_restrict_flag = 0;
                if (empty($woo_user_role_field)) {
                    $wcdg_user_role_restrict_flag = 1; // apply for all users
                } else {
                    if (is_user_logged_in()) {
                        if (in_array($current_user->roles[0], $woo_user_role_field, true)) {
                            $wcdg_user_role_restrict_flag = 1;  // apply for user roles which is set by admin side
                        }
                    } else {
                        if (in_array('wcdg_guest_user', $woo_user_role_field, true)) {
                            $wcdg_user_role_restrict_flag = 1;  // apply for guest users
                        }
                    }
                }
            }
        }else{
            $wcdg_user_role_restrict_flag = 1;
        }
        
        if(!empty($woo_checkout_status) && (1 === $wcdg_user_role_restrict_flag)) {
            $this->loader->add_action('woocommerce_checkout_fields', $plugin_public, 'wcdg_override_checkout_fields', 10);		
            $woo_checkout_button_product = isset($woo_checkout_unserlize_array['wcdg_chk_details']) ? $woo_checkout_unserlize_array['wcdg_chk_details'] : '';
            if (!empty($woo_checkout_button_product)) {
                $this->loader->add_action('woocommerce_after_add_to_cart_button', $plugin_public, 'wcdg_add_quick_checkout_after_add_to_cart_product_page');
            }
            $woo_checkout_button_shop = isset($woo_checkout_unserlize_array['wcdg_chk_prod']) ? $woo_checkout_unserlize_array['wcdg_chk_prod'] : '';
            if (!empty($woo_checkout_button_shop)) {
                $this->loader->add_action('woocommerce_after_shop_loop_item', $plugin_public, 'wcdg_add_quick_checkout_after_add_to_cart_shop_page', 10);
            }
            $this->loader->add_filter('woocommerce_thankyou', $plugin_public, 'wcdg_delay_register_guests', 10, 1);
            $this->loader->add_filter('woocommerce_paypal_args', $plugin_public, 'paypal_bn_code_filter_woo_checkout_field', 99, 1);
        }
	}
	
	private function define_admin_hooks() {
		
		$plugin_admin = new Woo_Checkout_For_Digital_Goods_Admin( $this->get_plugin_name(), $this->get_version() );
	    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action('admin_init', $plugin_admin, 'wcdg_welcome_screen_do_activation_redirect');
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wcdg_checkout_for_digital_create_page' );
        $this->loader->add_action( 'admin_head', $plugin_admin, 'wcdg_remove_admin_submenus', 999 );
        if ( wcfdg_fs()->is__premium_only() ) {
            if ( wcfdg_fs()->can_use_premium_code() ) {
		        $this->loader->add_action('wp_ajax_wcdg_vartual_product_list_ajax__premium_only', $plugin_admin, 'wcdg_vartual_product_list_ajax__premium_only');
		        $this->loader->add_action('wp_ajax_wcdg_single_product_delete__premium_only', $plugin_admin, 'wcdg_single_product_delete__premium_only');
		        $this->loader->add_action('wp_ajax_wcdg_single_cat_delete__premium_only', $plugin_admin, 'wcdg_single_cat_delete__premium_only');
		        $this->loader->add_action('wp_ajax_wcdg_single_tag_delete__premium_only', $plugin_admin, 'wcdg_single_tag_delete__premium_only');
		        $this->loader->add_action('wp_ajax_wcdg_selected_delete__premium_only', $plugin_admin, 'wcdg_selected_delete__premium_only');
		    }
		}
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
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Checkout_For_Digital_Goods_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}