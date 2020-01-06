<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.multidots.com/
 * @since             1.0.0
 * @package           Woocommerce_Product_Attachment
 *
 * @wordpress-plugin
 * Plugin Name: WooCommerce Product Attachment Premium
 * Plugin URI:        http://www.multidots.com/
 * Description:       WooCommerce Product Attachment Plugin will help you to attach/ upload any kind of files for a customer orders.You can attach any type of file like Images, documents, videos and many more..
 * Version:           1.5
 * Author:            Multidots
 * Author URI:        https://profiles.wordpress.org/dots
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-product-attachment-pro-
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'wpap_fs' ) ) {
    wcfdg_fs()->set_basename( true, __FILE__ );
    return;
}

add_action( 'plugins_loaded', 'wcpoa_initialize_plugin' );
$wc_active = in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true );
// Migration Cron Start
$wcpoa_upgrade_product_data = get_option( 'wcpoa_upgrade_product_data' );
$wcpoa_upgrade_setting_page = get_option( 'wcpoa_upgrade_setting_page' );
if ( empty($wcpoa_upgrade_product_data) || empty($wcpoa_upgrade_setting_page) ) {
    add_action( 'admin_notices', 'wcpoa_migration_notice' );
}
add_filter( 'cron_schedules', 'wcpoa_every_one_minute' );
add_action( 'wcpoa_migration_new_version_order_cron', 'wcpoa_migration_new_version_order' );
add_action( 'wcpoa_migration_new_version_product_cron', 'wcpoa_migration_new_version_product' );
// Migration Cron End

if ( true === $wc_active ) {
    
    if ( !function_exists( 'wpap_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wpap_fs()
        {
            global  $wpap_fs ;
            
            if ( !isset( $wpap_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wpap_fs = fs_dynamic_init( array(
                    'id'              => '3473',
                    'slug'            => 'woo-product-attachment',
                    'type'            => 'plugin',
                    'public_key'      => 'pk_eac499ce039e8334a8d30870fd1fd',
                    'is_premium'      => true,
                    'premium_suffix'  => 'Premium',
                    'has_addons'      => false,
                    'has_paid_plans'  => true,
                    'has_affiliation' => 'selected',
                    'menu'            => array(
                    'slug'       => 'woocommerce_product_attachment',
                    'first-path' => 'admin.php?page=woocommerce_product_attachment&tab=wcpoa-plugin-getting-started',
                    'contact'    => false,
                    'support'    => false,
                ),
                    'is_live'         => true,
                ) );
            }
            
            return $wpap_fs;
        }
        
        // Init Freemius.
        wpap_fs();
        // Signal that SDK was initiated.
        do_action( 'wpap_fs_loaded' );
        wpap_fs()->get_upgrade_url();
        wpap_fs()->add_action( 'after_uninstall', 'wpap_fs_uninstall_cleanup' );
    }
    
    if ( !defined( 'WCPOA_PLUGIN_URL' ) ) {
        define( 'WCPOA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }
    if ( !defined( 'WCPOA_PLUGIN_VERSION' ) ) {
        define( 'WCPOA_PLUGIN_VERSION', '1.5' );
    }
    if ( !defined( 'WCPOA_PLUGIN_BASENAME' ) ) {
        define( 'WCPOA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
    }
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-woocommerce-product-attachment-activator.php
     */
    function activate_woocommerce_product_attachment()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-activator.php';
        Woocommerce_Product_Attachment_Activator::activate();
    }
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-woocommerce-product-attachment-deactivator.php
     */
    function deactivate_woocommerce_product_attachment()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-deactivator.php';
        Woocommerce_Product_Attachment_Deactivator::deactivate();
    }
    
    register_activation_hook( __FILE__, 'activate_woocommerce_product_attachment' );
    register_deactivation_hook( __FILE__, 'deactivate_woocommerce_product_attachment' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment.php';
    /**
     * Define all constants
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-product-attachment-constants.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function convert_array_to_int( $arr )
    {
        foreach ( $arr as $key => $value ) {
            $arr[$key] = (int) $value;
        }
        return $arr;
    }
    
    function run_woocommerce_product_attachment()
    {
        $plugin = new Woocommerce_Product_Attachment();
        $plugin->run();
    }

}

/**
 * Check Initialize plugin in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
function wcpoa_initialize_plugin()
{
    $wc_active = in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true );
    
    if ( current_user_can( 'activate_plugins' ) && $wc_active !== true || $wc_active !== true ) {
        add_action( 'admin_notices', 'wcpoa_plugin_admin_notice' );
    } else {
        run_woocommerce_product_attachment();
    }

}

/**
 * Show admin notice in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
function wcpoa_plugin_admin_notice()
{
    $vpe_plugin = esc_html__( 'WooCommerce Product Attachment', 'woocommerce-product-attachment' );
    $wc_plugin = esc_html__( 'WooCommerce', 'woocommerce-product-attachment' );
    ?>
    <div class="error">
        <p>
            <?php 
    echo  sprintf( esc_html__( '%1$s is ineffective as it requires %2$s to be installed and active.', 'woocommerce-product-attachment' ), '<strong>' . esc_html( $vpe_plugin ) . '</strong>', '<strong>' . esc_html( $wc_plugin ) . '</strong>' ) ;
    ?>
        </p>
    </div>
    <?php 
}

/**
 * Every one minute schedules cron
 *
 * @return array
 * @since    1.0.0
 *
 * */
function wcpoa_every_one_minute( $schedules )
{
    $schedules['wcpoa_every_one_minute'] = array(
        'interval' => 60,
        'display'  => __( 'Every 1 Minute' ),
    );
    return $schedules;
}

/**
 * Data Migration of order meta on plugin update
 *
 * @since    1.0.0
 *
 * */
function wcpoa_migration_new_version_order()
{
    global  $wpdb ;
    $oder_table_meta = $wpdb->prefix . 'woocommerce_order_itemmeta';
    $order_change_bulk_attachment_key = array(
        'wcpoa_pro_attachment_ids'               => 'wcpoa_attachments_id',
        'wcpoa_pro_attachment_name'              => 'wcpoa_is_condition',
        'wcpoa_pro_att_order_description'        => 'wcpoa_attachment_name',
        'wcpoa_pro_attachment_url'               => 'wcpoa_attach_type',
        'wcpoa_pro_attach_type'                  => 'wcpoa_attachment_file',
        'wcpoa_pro_attachment_ext_url'           => 'wcpoa_attachment_url',
        'wcpoa_pro_order_status'                 => 'wcpoa_attachment_description',
        'wcpoa_pro_order_product_variation'      => 'wcpoa_order_status',
        'wcpoa_pro_expired_date_enable'          => 'wcpoa_category_list',
        'wcpoa_pro_order_attachment_expired'     => 'wcpoa_product_list',
        'wcpoa_pro_order_attachment_time_amount' => 'wcpoa_tag_list',
        'wcpoa_pro_order_attachment_time_type'   => 'wcpoa_assignment',
    );
    $oder_meta_data = $wpdb->get_results( "SELECT meta_id,meta_key,meta_value FROM {$oder_table_meta} WHERE meta_key = 'wcpoa_pro_order_attachment_order_arr' LIMIT 20 " );
    
    if ( $oder_meta_data ) {
        foreach ( $oder_meta_data as $oder_meta ) {
            $data_arr = unserialize( $oder_meta->meta_value );
            $order_meta_id = $oder_meta->meta_id;
            $oder_meta_key = 'wcpoa_order_attachment_order_arr';
            foreach ( $data_arr as $data_arr_key => $data_arr_value ) {
                $new_data_arr_key = str_replace( "_pro_", "_", $data_arr_key );
                $data_arr[$new_data_arr_key] = $data_arr[$data_arr_key];
                unset( $data_arr[$data_arr_key] );
            }
            $oder_meta_value = maybe_serialize( $data_arr );
            $wpdb->query( $wpdb->prepare( "UPDATE {$oder_table_meta} SET meta_value=%s WHERE meta_id=%d", $oder_meta_value, $order_meta_id ) );
            $wpdb->query( $wpdb->prepare( "UPDATE {$oder_table_meta} SET meta_key=%s WHERE meta_id=%d", $oder_meta_key, $order_meta_id ) );
        }
    } else {
        update_option( 'wcpoa_upgrade_order_data', 'required' );
        wp_clear_scheduled_hook( "wcpoa_migration_new_version_order_cron" );
    }

}

/**
 * Data Migration of product meta on plugin update
 *
 * @since    1.0.0
 *
 * */
function wcpoa_migration_new_version_product()
{
    global  $wpdb ;
    $change_all_product_attachment_key = array(
        'wcpoa_pro_attachments_id'         => 'wcpoa_attachments_id',
        'wcpoa_pro_attachment_name'        => 'wcpoa_attachment_name',
        'wcpoa_pro_attachment_description' => 'wcpoa_attachment_description',
        'wcpoa_pro_attach_type'            => 'wcpoa_attach_type',
        'wcpoa_pro_attachment_ext_url'     => 'wcpoa_attachment_ext_url',
        'wcpoa_pro_attachment_url'         => 'wcpoa_attachment_url',
        'wcpoa_pro_attachment_file'        => 'wcpoa_attachment_file',
        'wcpoa_pro_product_page_enable'    => 'wcpoa_product_page_enable',
        'wcpoa_pro_variation'              => 'wcpoa_variation',
        'wcpoa_pro_order_status'           => 'wcpoa_order_status',
        'wcpoa_pro_expired_date_enable'    => 'wcpoa_expired_date_enable',
        'wcpoa_pro_expired_date'           => 'wcpoa_expired_date',
        'wcpoa_pro_attachment_time_amount' => 'wcpoa_attachment_time_amount',
        'wcpoa_pro_expired_time_amount'    => 'wcpoa_expired_time_amount',
        'wcpoa_pro_attachment_time_type'   => 'wcpoa_attachment_time_type',
        'wcpoa_pro_expired_time_type'      => 'wcpoa_expired_time_type',
    );
    $product_meta_data = $wpdb->get_results( "SELECT meta_id FROM {$wpdb->postmeta} WHERE meta_key IN ('wcpoa_pro_attachments_id','wcpoa_pro_attachment_name','wcpoa_pro_attachment_description','wcpoa_pro_attach_type','wcpoa_pro_attachment_ext_url','wcpoa_pro_attachment_url','wcpoa_pro_attachment_file','wcpoa_pro_product_page_enable','wcpoa_pro_variation','wcpoa_pro_order_status','wcpoa_pro_expired_date_enable','wcpoa_pro_expired_date','wcpoa_pro_attachment_time_amount','wcpoa_pro_expired_time_amount','wcpoa_pro_attachment_time_type','wcpoa_pro_expired_time_type'); LIMIT 1 " );
    
    if ( $product_meta_data ) {
        foreach ( $change_all_product_attachment_key as $prod_oldkey => $prod_newkey ) {
            $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_key=%s WHERE meta_key=%s LIMIT 20", $prod_newkey, $prod_oldkey ) );
        }
    } else {
        update_option( 'wcpoa_upgrade_product_data', 'required' );
        wp_clear_scheduled_hook( "wcpoa_migration_new_version_product_cron" );
    }

}

/**
 * Show admin notice when migration running.
 *
 * @since    1.0.0
 */
function wcpoa_migration_notice()
{
    $vpe_plugin = esc_html__( 'WooCommerce Product Attachment', 'woocommerce-product-attachment' );
    ?>
    <div class="error">
        <p>
            <?php 
    echo  sprintf( esc_html__( 'Data migration is running in %1$s plugin.', 'woocommerce-product-attachment' ), '<strong>' . esc_html( $vpe_plugin ) . '</strong>' ) ;
    ?>
        </p>
    </div>
    <?php 
}
