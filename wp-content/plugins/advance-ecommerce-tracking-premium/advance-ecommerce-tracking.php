<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.multidots.com
 * @since             1.0.0
 * @package           Advance_Ecommerce_Tracking
 *
 * @wordpress-plugin
 * Plugin Name: Advance Ecommerce Tracking Premium
 * Plugin URI:        http://www.multidots.com
 * Description:       allows you to use Enhanced Ecommerce tracking without adding any new complex codes on your WooCommerce.
 * Version:           1.5.2
 * Author:            Multidots
 * Author URI:        http://www.multidots.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advance-ecommerce-tracking
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'aet_fs' ) ) {
    aet_fs()->set_basename( true, __FILE__ );
    return;
}


if ( !function_exists( 'aet_fs' ) ) {
    // Create a helper function for easy SDK access.
    function aet_fs()
    {
        global  $aet_fs ;
        
        if ( !isset( $aet_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $aet_fs = fs_dynamic_init( array(
                'id'               => '3475',
                'slug'             => 'advance-ecommerce-tracking',
                'type'             => 'plugin',
                'public_key'       => 'pk_0dbe70558f17f7a0881498011f656',
                'is_premium'       => true,
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'menu'             => array(
                'slug'       => 'wc_pro_ecommerce_tracking_get_started_method',
                'first-path' => 'admin.php?page=ecommerce_tracking_pro&tab=wc_pro_ecommerce_tracking_get_started_method',
                'contact'    => false,
                'support'    => false,
            ),
                'is_live'          => true,
            ) );
        }
        
        return $aet_fs;
    }
    
    aet_fs();
    do_action( 'aet_fs_loaded' );
    aet_fs()->get_upgrade_url();
    aet_fs()->add_action( 'after_uninstall', 'aet_fs_uninstall_cleanup' );
}

if ( aet_fs()->is__premium_only() ) {
    // This IF will be executed only if the user in a trial mode or have a valid license.
    
    if ( aet_fs()->can_use_premium_code() ) {
        if ( !defined( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL' ) ) {
            define( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        }
        if ( !defined( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_TEXT_DOMAIN' ) ) {
            define( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_TEXT_DOMAIN', 'advance-ecommerce-tracking' );
        }
        if ( !defined( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_BASENAME' ) ) {
            define( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_BASENAME', plugin_dir_path( __FILE__ ) . 'goSquared-php-sdk' );
        }
        if ( !defined( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_BASENAME_FILE' ) ) {
            define( 'ADVANCE_ECOMMERCE_TRACKING_PLUGIN_BASENAME_FILE', plugin_basename( __FILE__ ) );
        }
        /**
         * The code that runs during plugin activation.
         * This action is documented in includes/class-advance-ecommerce-tracking-activator.php
         */
        function activate_advance_ecommerce_tracking()
        {
            require_once __DIR__ . '/includes/class-advance-ecommerce-tracking-activator.php';
            Advance_Ecommerce_Tracking_Activator::activate();
        }
        
        /**
         * The code that runs during plugin deactivation.
         * This action is documented in includes/class-advance-ecommerce-tracking-deactivator.php
         */
        function deactivate_advance_ecommerce_tracking()
        {
            require_once __DIR__ . '/includes/class-advance-ecommerce-tracking-deactivator.php';
            Advance_Ecommerce_Tracking_Deactivator::deactivate();
        }
        
        register_activation_hook( __FILE__, 'activate_advance_ecommerce_tracking' );
        register_deactivation_hook( __FILE__, 'deactivate_advance_ecommerce_tracking' );
        /**
         * The core plugin class that is used to define internationalization,
         * admin-specific hooks, and public-facing site hooks.
         */
        require __DIR__ . '/includes/class-advance-ecommerce-tracking.php';
        require __DIR__ . '/woopra-php-sdk-master/woopra_tracker.php';
        require __DIR__ . '/goSquared-php-sdk/main.php';
        /**
         * include constant file
         */
        require __DIR__ . '/includes/constant.php';
        if ( !defined( 'ECOMMERCE_TRACKING_PLUGIN_URL' ) ) {
            define( 'ECOMMERCE_TRACKING_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        }
        /**
         * Begins execution of the plugin.
         *
         * Since everything within the plugin is registered via hooks,
         * then kicking off the plugin from this point in the file does
         * not affect the page life cycle.
         *
         * @since    1.0.0
         */
        function run_advance_ecommerce_tracking()
        {
            $plugin = new Advance_Ecommerce_Tracking();
            $plugin->run();
        }
        
        run_advance_ecommerce_tracking();
    }

}

if (!function_exists('debug')) {
    function debug($params) {

        echo '<pre>';
        print_r($params);
        echo '</pre>';

    }
}