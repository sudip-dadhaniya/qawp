<?php
if (!defined('ABSPATH')) exit;
?>
<div class="waet-table res-cl">
    <h2><?php esc_html_e('Thanks For Installing Ecommerce Tracking', 'advance-ecommerce-tracking'); ?></h2>
    <table class="form-table table-outer">
        <tbody>
        <tr>
            <td class="fr-2">
                <p class="block gettingstarted">
                    <strong><?php esc_html_e('Getting Started', 'advance-ecommerce-tracking'); ?></strong></p>
                <p class="block textgetting"><?php esc_html_e('The plugin allows you to easy Integration with Multiple Analytic tools with your WooCommres store. It will provide all the features to track your sales and product performance through different analytics tools.', 'advance-ecommerce-tracking'); ?></p>
                <p class="block textgetting"><?php esc_html_e('Plugin supports the following analytic tools:', 'advance-ecommerce-tracking'); ?></p>
                <ul>
                    <li><?php esc_html_e('WooCommerce Ecommerce Tracking', 'advance-ecommerce-tracking'); ?></li>
                    <li><?php esc_html_e('Google Conversion Tracking', 'advance-ecommerce-tracking'); ?></li>
                    <li><?php esc_html_e('Facebook Conversion Tracking', 'advance-ecommerce-tracking'); ?></li>
                    <li><?php esc_html_e('Woopra Ecommerce Tracking', 'advance-ecommerce-tracking'); ?></li>
                    <li><?php esc_html_e('Gosquared Ecommerce Tracking', 'advance-ecommerce-tracking'); ?></li>
                    <li><?php esc_html_e('Twitter Ecommerce Conversion', 'advance-ecommerce-tracking'); ?></li>
                </ul>
                <p class="block textgetting"><?php echo sprintf(esc_html__('%1$sStep 1:%2$s Google Ecommerce Tracking Settings.', 'advance-ecommerce-tracking'), '<strong>', '</strong>'); ?>
                </p>
                <p class="block textgetting">
                    <?php echo sprintf(esc_html__('Sign into your %1$sGoogle Analytics Account%2$s.', 'advance-ecommerce-tracking'), '<a href="https://analytics.google.com/analytics/web/provision/?authuser=0#provision/SignUp/" target="_blank">', '</a>'); ?>
                    <br/>
                    <?php esc_html_e('If you already have Google Analytics Account, please enable the option below and you shall be able to track WooCommerce orders in your store.', 'advance-ecommerce-tracking'); ?>
                </p>
                <p class="block textgetting"><?php esc_html_e('You can track events the listed below:', 'advance-ecommerce-tracking'); ?></p>
                <ul>
                    <li><?php esc_html_e('Orders', 'advance-ecommerce-tracking'); ?></li>
                    <li><?php esc_html_e('Order\'s Total Revenue', 'advance-ecommerce-tracking'); ?></li>
                    <li><?php esc_html_e('Transactions count', 'advance-ecommerce-tracking'); ?></li>
                </ul>
                <p>
                    <span class="gettingstarted">
                        <img style="border: 2px solid #e9e9e9;margin-top: 3%;"
                             src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'images/ecommerce_tracking_setting.png'); ?>">
                    </span>
                </p>
                <p class="block gettingstarted textgetting">
                    <?php echo sprintf(esc_html__('%1$sStep 2:%2$s you can view google e-commerce tracking reports.', 'advance-ecommerce-tracking'), '<strong>', '</strong>'); ?>
                    <span class="gettingstarted">
                                <img style="border: 2px solid #e9e9e9;margin-top: 3%;"
                                     src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'images/track-order-report.png'); ?>">
                            </span>
                </p>
                <p class="block gettingstarted textgetting">
                    <?php echo sprintf(esc_html__('%1$sNote:%2$s This plugin is compatible for WC v2.4.0 & above.', 'advance-ecommerce-tracking'), '<strong>', '</strong>'); ?>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>