<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Checkout_For_Digital_Goods
 * @subpackage Woo_Checkout_For_Digital_Goods/public
 */
class Woo_Checkout_For_Digital_Goods_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     *
     * @param string $hook display current page name
     */
    public function enqueue_styles($hook) {

       if ( (false !== strpos($hook, 'dotstore-plugins_page_wcdg-general-setting')) || (false !== strpos($hook, 'dotstore-plugins_page_wcdg-quick-checkout')) || (false !== strpos($hook, 'dotstore-plugins_page_wcdg-get-started')) || (false !== strpos($hook, 'dotstore-plugins_page_wcdg-information')) ) {
			wp_enqueue_style($this->plugin_name.'-select2-style', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-checkout-for-digital-goods-admin.css', array(), $this->version, 'all');
			wp_enqueue_style('wp-pointer');
            wp_enqueue_style($this->plugin_name . 'choose-css', plugin_dir_url(__FILE__) . 'css/chosen.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'datatable-css', plugin_dir_url(__FILE__) . 'css/woo-checkout-for-digital-goods-data-tables.min.css', array(), $this->version, 'all');
		}
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     *
     * @param string $hook display current page name
     */
    public function enqueue_scripts($hook) {
        if ( (false !== strpos($hook, 'dotstore-plugins_page_wcdg-general-setting')) || (false !== strpos($hook, 'dotstore-plugins_page_wcdg-quick-checkout')) || (false !== strpos($hook, 'dotstore-plugins_page_wcdg-get-started')) || (false !== strpos($hook, 'dotstore-plugins_page_wcdg-information')) ) {
            if ( wcfdg_fs()->is__premium_only() ) {
                if ( wcfdg_fs()->can_use_premium_code() ) {
                    wp_enqueue_script( 'selectWoo');
        			wp_enqueue_script($this->plugin_name . 'wcdg-admin-default-js-pro', plugin_dir_url(__FILE__) . 'js/woo-checkout-for-digital-goods-admin__premium_only.js', array('jquery', 'jquery-ui-dialog','selectWoo'), $this->version, false);
                }
            }
            wp_enqueue_script($this->plugin_name . 'wcdg-admin-default-js', plugin_dir_url(__FILE__) . 'js/woo-checkout-for-digital-goods-admin.js', array('jquery', 'jquery-ui-dialog'), $this->version, false);
			wp_enqueue_script('wp-pointer');
            wp_enqueue_script($this->plugin_name . 'choose-js', plugin_dir_url(__FILE__) . 'js/chosen.jquery.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . 'datatable-js', plugin_dir_url(__FILE__) . 'js/woo-checkout-for-digital-goods-data-tables.min.js', array('jquery'), $this->version, false);
		}
    }
    /*
     * Digital Checkout Menu
     *
     * @since 1.0.0
     */
    public function wcdg_checkout_for_digital_create_page() {
        global $GLOBALS;
        if (empty($GLOBALS['admin_page_hooks']['dots_store'])) {
            add_menu_page('DotStore Plugins', __('DotStore Plugins'), 'null', 'dots_store', array($this, 'dot_store_menu_page'), WCDG_PLUGIN_URL . 'admin/images/menu-icon.png', 25);
        }
        if ( wcfdg_fs()->is__premium_only() ) {

            if ( wcfdg_fs()->can_use_premium_code() ) {
                add_submenu_page( 'dots_store', 'Digital Goods for Woo Checkout Pro','Digital Goods for Woo Checkout Pro', 'manage_options', 'wcdg-general-setting', array( $this, 'wcdg_general_setting_page' ) );
                add_submenu_page('dots_store', 'Getting Started', 'Getting Started', 'manage_options', 'wcdg-get-started', array($this, 'wcdg_get_started_page'));
                add_submenu_page('dots_store', 'Quick info', 'Quick info', 'manage_options', 'wcdg-information', array($this, 'wcdg_information_page'));
                add_submenu_page('dots_store', 'Quick Checkout', 'Quick Checkout', 'manage_options', 'wcdg-quick-checkout', array($this, 'wcdg_quick_checkout_page__premium_only'));
            }
            if ( wcfdg_fs()->is_plan( 'free', true ) ) {
                add_submenu_page( 'dots_store', 'Digital Goods for Woo Checkout', 'Digital Goods for Woo Checkout', 'manage_options', 'wcdg-general-setting', array( $this, 'wcdg_general_setting_page' ) );
                add_submenu_page('dots_store', 'Getting Started', 'Getting Started', 'manage_options', 'wcdg-get-started', array($this, 'wcdg_get_started_page'));
                add_submenu_page('dots_store', 'Quick info', 'Quick info', 'manage_options', 'wcdg-information', array($this, 'wcdg_information_page'));
            }
        }else{
            add_submenu_page( 'dots_store', 'Digital Goods for Woo Checkout', 'Digital Goods for Woo Checkout', 'manage_options', 'wcdg-general-setting', array( $this, 'wcdg_general_setting_page' ) );
            add_submenu_page('dots_store', 'Getting Started', 'Getting Started', 'manage_options', 'wcdg-get-started', array($this, 'wcdg_get_started_page'));
            add_submenu_page('dots_store', 'Quick info', 'Quick info', 'manage_options', 'wcdg-information', array($this, 'wcdg_information_page'));
        }
        
    }

    /**
     * General Setting Page
     *
     * @since    1.0.0
     */
    public function wcdg_general_setting_page()
    {
        require_once( plugin_dir_path( __FILE__ ).'partials/wcdg-general-setting.php' );
    }
    /**
     * Quick Checkout Page
     *
     * @since    1.0.0
     */
    public function wcdg_quick_checkout_page__premium_only()
    {
        require_once( plugin_dir_path( __FILE__ ).'partials/wcdg-quick-checkout__premium_only.php' );
    }

    /**
     * Quick guide page
     *
     * @since    1.0.0
     */
    public function wcdg_get_started_page() {
        require_once(plugin_dir_path( __FILE__ ).'partials/wcdg-get-started-page.php');
    }

    /**
     * Plugin information page
     *
     * @since    1.0.0
     */
    public function wcdg_information_page() {
        require_once(plugin_dir_path( __FILE__ ).'partials/wcdg-information-page.php');
    }


    /**
     * Remove the Extra flate rate menu in dashboard
     *
     */
    public function wcdg_remove_admin_submenus() {
        if ( wcfdg_fs()->is__premium_only() ) {
            if ( wcfdg_fs()->can_use_premium_code()) {
                remove_submenu_page('dots_store', 'wcdg-quick-checkout');
            }
        }
        remove_submenu_page('dots_store', 'wcdg-get-started');
        remove_submenu_page('dots_store', 'wcdg-information');
    }

    /**
     * Redirect to quick start guide after plugin activation
     *
     * @since    1.0.0
     */
    public function wcdg_welcome_screen_do_activation_redirect() {

        // if no activation redirect
        if (!get_transient('_welcome_screen_wcdg_mode_activation_redirect_data')) {
            return;
        }

        // Delete the redirect transient
        delete_transient('_welcome_screen_wcdg_mode_activation_redirect_data');

        // if activating from network, or bulk
        $activate_multi = filter_input(INPUT_GET,'activate-multi',FILTER_SANITIZE_STRING);
        if (is_network_admin() || isset($activate_multi)) {
            return;
        }
        // Redirect to extra cost welcome  page
        wp_safe_redirect(add_query_arg(array('page' => 'wcdg-get-started'), admin_url('admin.php')));
        exit;
    }

    /**
     * Get Virtual Product List AJAX
     *
     * @since    1.0.0
     *
     */
    public function wcdg_vartual_product_list_ajax__premium_only(){
        ob_start();
        check_ajax_referer( 'woo_checkout_digital_goods_product', 'security' );

        $search_query_parameter   = filter_input( INPUT_GET, 'searchQueryParameter', FILTER_SANITIZE_STRING );
        $searched_term = isset( $search_query_parameter ) ? (string) wc_clean( wp_unslash( $search_query_parameter ) ) : '';

        if ( empty( $searched_term ) ) {
            wp_die();
        }

        $search_query_parameter = str_replace( "’", "'", $search_query_parameter );

        $product_args     = array(
            'post_type'              => 'product',
            's'                      => html_entity_decode( $search_query_parameter, ENT_QUOTES, 'UTF-8' ),
            'post_status'            => 'publish',
            'orderby'                => 'title',
            'order'                  => 'ASC',
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'meta_query' => array(
                'relation'    => 'OR',
                array(
                    'key' => '_downloadable',
                    'value' => 'yes',
                    'compare' => '='
                ),
                array(
                    'key' => '_virtual',
                    'value' => 'yes',
                    'compare' => '='
                )
            )
        );
        $wp_query = new WP_Query( $product_args );

        $found_product = array();

        if ( $wp_query->have_posts() ) {
            foreach ( $wp_query->posts as $digi_product ) {
                $found_product[ $digi_product->ID ] = sprintf(
                    esc_html__( '%1$s (#%2$s)', WCDG_TEXT_DOMAIN ),
                    $digi_product->post_title,
                    $digi_product->ID
                );
            }
        }
        wp_send_json( $found_product );
    }


    /**
     * Delete Single product Using AJAX
     *
     * @since    1.0.0
     *
     */
    public function wcdg_single_product_delete__premium_only(){
        $id = filter_input(INPUT_GET,'single_selected_product_id',FILTER_SANITIZE_STRING);
        delete_post_meta($id, '_wcdg_chk_product', 'yes');
        echo esc_html__( 'true', WCDG_TEXT_DOMAIN );
        wp_die();
    }
    /**
     * Delete Single Category Using AJAX
     *
     * @since    1.0.0
     *
     */
    public function wcdg_single_cat_delete__premium_only(){
        $id = filter_input(INPUT_GET,'single_selected_cat_id',FILTER_SANITIZE_STRING);
        delete_term_meta($id, 'wcdg_chk_category', 'yes');
        echo esc_html__( 'true', WCDG_TEXT_DOMAIN );
        wp_die();
    }
    /**
     * Delete Single Tag Using AJAX
     *
     * @since    1.0.0
     *
     */
    public function wcdg_single_tag_delete__premium_only(){
        $id = filter_input(INPUT_GET,'single_selected_tag_id',FILTER_SANITIZE_STRING);
        delete_term_meta($id, 'wcdg_chk_tag', 'yes');
        echo esc_html__( 'true', WCDG_TEXT_DOMAIN );
        wp_die();
    }
    /**
     * Delete All Item Using AJAX
     *
     * @since    1.0.0
     *
     */
    public function wcdg_selected_delete__premium_only(){
        $all_id   = filter_input(INPUT_GET, 'selected_item_id', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        $selected_label = filter_input(INPUT_GET,'delete_label',FILTER_SANITIZE_STRING);

        if('wcdg_detete_all_selected_product' === $selected_label){
            foreach($all_id as $id){
                delete_post_meta($id, '_wcdg_chk_product', 'yes');
            }
        }elseif('wcdg_detete_all_selected_cat' === $selected_label){
            foreach($all_id as $id){
                delete_term_meta($id, 'wcdg_chk_category', 'yes');
            }
        }elseif('wcdg_detete_all_selected_tag' === $selected_label){
            foreach($all_id as $id){
                delete_term_meta($id, 'wcdg_chk_tag', 'yes');
            }
        }
        echo esc_html__( 'true', WCDG_TEXT_DOMAIN );
        wp_die();
    }
}

