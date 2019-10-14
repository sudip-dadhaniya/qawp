<?php

/**
 * Plugin Name: Digital Goods for WooCommerce Checkout Pro
 * Plugin URI:        https://www.thedotstore.com/
 * Description:       This plugin will remove billing address fields for downloadable and virtual products.
 * Version:           2.7
 * Author:            Thedotstore
 * Author URI:        https://www.thedotstore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-checkout-for-digital-goods
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    die;
}

if ( function_exists( 'wcfdg_fs' ) ) {
    wcfdg_fs()->set_basename( true, __FILE__ );
    return;
}


if ( !function_exists( 'wcfdg_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wcfdg_fs()
    {
        global  $wcfdg_fs ;
        
        if ( !isset( $wcfdg_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $wcfdg_fs = fs_dynamic_init( array(
                'id'             => '4703',
                'slug'           => 'woo-checkout-for-digital-goods',
                'type'           => 'plugin',
                'public_key'     => 'pk_2eb1a2c306bc0ab838b9439f8fa73',
                'is_premium'     => true,
                'premium_suffix' => 'Pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'       => 'wcdg-get-started',
                'first-path' => 'admin.php?page=wcdg-get-started',
                'support'    => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $wcfdg_fs;
    }
    
    // Init Freemius.
    wcfdg_fs();
    // Signal that SDK was initiated.
    do_action( 'wcfdg_fs_loaded' );
    wcfdg_fs()->get_upgrade_url();
    wcfdg_fs()->add_action( 'after_uninstall', 'wcfdg_fs_uninstall_cleanup' );
}

if ( !defined( 'WCDG_TEXT_DOMAIN' ) ) {
    define( 'WCDG_TEXT_DOMAIN', 'woo-checkout-for-digital-goods' );
}
if ( !defined( 'WCDG_PLUGIN_URL' ) ) {
    define( 'WCDG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WCDG_PLUGIN_VERSION' ) ) {
    define( 'WCDG_PLUGIN_VERSION', '2.7' );
}
if ( !defined( 'WCDG__TEXT_DOMAIN' ) ) {
    define( 'WCDG__TEXT_DOMAIN', 'woo-checkout-for-digital-goods' );
}
if ( !function_exists( 'wp_get_current_user' ) ) {
    include ABSPATH . "wp-includes/pluggable.php";
}

if ( wcfdg_fs()->is__premium_only() ) {
    
    if ( wcfdg_fs()->can_use_premium_code() ) {
        if ( !defined( 'WCDG_PLUGIN_NAME' ) ) {
            define( 'WCDG_PLUGIN_NAME', 'Digital Goods for WooCommerce Checkout Pro' );
        }
        if ( !defined( 'WCDG_TEXT_DOMAIN' ) ) {
            define( 'WCDG_TEXT_DOMAIN', 'woo-checkout-for-digital-goods-pro' );
        }
        if ( !defined( 'WCDG_VERSION_TEXT' ) ) {
            define( 'WCDG_VERSION_TEXT', __( 'Pro Version' ) );
        }
    }
    
    
    if ( wcfdg_fs()->is_plan( 'free', true ) ) {
        if ( !defined( 'WCDG_PLUGIN_NAME' ) ) {
            define( 'WCDG_PLUGIN_NAME', 'Digital Goods for WooCommerce Checkout' );
        }
        if ( !defined( 'WCDG_TEXT_DOMAIN' ) ) {
            define( 'WCDG_TEXT_DOMAIN', 'woo-checkout-for-digital-goods' );
        }
        if ( !defined( 'WCDG_VERSION_TEXT' ) ) {
            define( 'WCDG_VERSION_TEXT', __( 'Free Version' ) );
        }
    }

} else {
    if ( !defined( 'WCDG_PLUGIN_NAME' ) ) {
        define( 'WCDG_PLUGIN_NAME', 'Digital Goods for WooCommerce Checkout' );
    }
    if ( !defined( 'WCDG_TEXT_DOMAIN' ) ) {
        define( 'WCDG_TEXT_DOMAIN', 'woo-checkout-for-digital-goods' );
    }
    if ( !defined( 'WCDG_VERSION_TEXT' ) ) {
        define( 'WCDG_VERSION_TEXT', __( 'Free Version' ) );
    }
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-checkout-for-digital-goods-activator.php
 */
function activate_woo_checkout_for_digital_goods()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-checkout-for-digital-goods-activator.php';
    Woo_Checkout_For_Digital_Goods_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-checkout-for-digital-goods-deactivator.php
 */
function deactivate_woo_checkout_for_digital_goods()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-checkout-for-digital-goods-deactivator.php';
    Woo_Checkout_For_Digital_Goods_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_checkout_for_digital_goods' );
register_deactivation_hook( __FILE__, 'deactivate_woo_checkout_for_digital_goods' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-checkout-for-digital-goods.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_checkout_for_digital_goods()
{
    $plugin = new Woo_Checkout_For_Digital_Goods();
    $plugin->run();
}

run_woo_checkout_for_digital_goods();