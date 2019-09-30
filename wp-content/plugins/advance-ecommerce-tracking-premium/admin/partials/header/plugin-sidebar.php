<?php
if (!defined('ABSPATH')) exit;
$image_url = ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/right_click.jpg';
?>
<div class="dotstore_plugin_sidebar">
    <div class="dotstore-important-link">
        <h2>
            <span class="dotstore-important-link-title"><?php esc_html_e('Important links', 'advance-ecommerce-tracking'); ?></span>
        </h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>" alt="Right Click">
                    <a target="_blank" href="javascript:void(0);">
                        <?php esc_html_e('Plugin documentation', 'advance-ecommerce-tracking'); ?>
                    </a>
                </li>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>" alt="Right Click">
                    <a target="_blank"
                       href="<?php echo esc_url("https://www.thedotstore.com/support/"); ?>"><?php esc_html_e('Support platform', 'advance-ecommerce-tracking'); ?></a>
                </li>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>" alt="Right Click">
                    <a target="_blank"
                       href="<?php echo esc_url("https://store.multidots.com/suggest-a-feature/"); ?>"><?php esc_html_e('Suggest A Feature', 'advance-ecommerce-tracking'); ?></a>
                </li>
                <li>
                    <img src="<?php echo esc_url($image_url); ?>" alt="Right Click">
                    <a target="_blank"
                       href="javascript:void(0);"><?php esc_html_e('Changelog', 'advance-ecommerce-tracking'); ?></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- html for popular plugin !-->
    <div class="dotstore-important-link">
        <h2>
            <span class="dotstore-important-link-title"><?php esc_html_e('OUR POPULAR PLUGINS', 'advance-ecommerce-tracking'); ?></span>
        </h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/Advance_Extra_Cost_WooCommerce_sidebar.png'); ?>"
                         alt="Advance Extra Cost Plugin for WooCommerce sidebar">
                    <a target="_blank"
                       href="<?php echo esc_url("https://store.multidots.com/go/flatrate-pro-new-interface--extra-cost"); ?>"><?php esc_html_e('Woocommerce Conditional Extra Fees', 'advance-ecommerce-tracking'); ?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/blocker_lite.png'); ?>"
                         alt="Woocommerce Blocker Lite Prevent fake orders and Blacklist fraud customers">
                    <a target="_blank"
                       href="<?php echo esc_url("https://store.multidots.com/go/flatrate-pro-new-interface-woo-blocker"); ?>"><?php esc_html_e('Woocommerce Blocker', 'advance-ecommerce-tracking'); ?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/size_chart.png'); ?>"
                         alt="Advanced Product Size Chart WooCommerce icon">
                    <a target="_blank"
                       href="<?php echo esc_url("https://store.multidots.com/go/flatrate-pro-new-interface-size-chart"); ?>"><?php esc_html_e('Woocommerce Advanced Product Size Charts', 'advance-ecommerce-tracking'); ?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/advance_ecommerce_tacking.png'); ?>"
                         alt="WooCommerce Enhanced Ecommerce Analytics Integration with Conversion Tracking">
                    <a target="_blank"
                       href="<?php echo esc_url("https://store.multidots.com/go/flatrate-pro-new-interface-ecommerce-tracking"); ?>"><?php esc_html_e('Woo Enhanced Ecommerce Analytics Integration', 'advance-ecommerce-tracking'); ?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/AMM.jpg'); ?>" alt="AMM">
                    <a target="_blank"
                       href="<?php echo esc_url('https://store.multidots.com/advance-menu-manager-wordpress/'); ?>"><?php esc_html_e('Advanced Menu Manager For WordPress', 'advance-ecommerce-tracking'); ?></a>
                </li>
            </ul>
        </div>
        <div class="view-button">
            <a class="view_button_dotstore" target="_blank"
               href="<?php echo esc_url('https://store.multidots.com/go/flatrate-pro-new-interface-viewall-plugin-button'); ?>"><?php esc_html_e('VIEW ALL', 'advance-ecommerce-tracking'); ?></a>
        </div>
    </div>
</div>