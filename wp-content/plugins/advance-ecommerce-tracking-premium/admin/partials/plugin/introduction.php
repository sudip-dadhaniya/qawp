<?php
if (!defined('ABSPATH')) exit;
$plugin_name    = ADVANCED_ECOMMERCE_TRACKING_PLUGIN_NAME;
$plugin_version = ADVANCED_ECOMMERCE_TRACKING_PLUGIN_VERSION;
?>
<div class="waet-table res-cl">
    <h2><?php esc_html_e('Quick Info', 'advance-ecommerce-tracking'); ?></h2>
    <table class="form-table table-outer">
        <tbody>
        <tr>
            <td class="fr-1"><?php esc_html_e('Product Type', 'advance-ecommerce-tracking'); ?></td>
            <td class="fr-2"><?php esc_html_e('WooCommerce Plugin', 'advance-ecommerce-tracking'); ?></td>
        </tr>
        <tr>
            <td class="fr-1"><?php esc_html_e('Product Name', 'advance-ecommerce-tracking'); ?></td>
            <td class="fr-2"><?php echo esc_html($plugin_name); ?></td>
        </tr>
        <tr>
            <td class="fr-1"><?php esc_html_e('Installed Version', 'advance-ecommerce-tracking'); ?></td>
            <td class="fr-2"><?php echo esc_html($plugin_version); ?></td>
        </tr>
        <tr>
            <td class="fr-1"><?php esc_html_e('License & Terms of Use', 'advance-ecommerce-tracking'); ?></td>
            <td class="fr-2"><?php echo sprintf(esc_html__('%1$sClick here%2$s to view license and terms of use.', 'advance-ecommerce-tracking'), '<a target="_blank" href=" https://store.multidots.com/terms-and-conditions/">', '</a>'); ?></td>
        </tr>
        <tr>
            <td class="fr-1"><?php esc_html_e('Help & Support', 'advance-ecommerce-tracking'); ?></td>
            <td class="fr-2">
                <ul style="margin-left: 15px !important;list-style: inherit; ">
                    <li><a target="_blank"
                           href="<?php echo esc_url(admin_url('admin.php?page=ecommerce_tracking_pro&tab=wc_pro_ecommerce_tracking_get_started_method')); ?>"><?php esc_html_e('Quick Start Guide', 'advance-ecommerce-tracking'); ?></a>
                    </li>
                    <li><a target="_blank"
                           href="https://store.multidots.com/docs/plugins/woocommerce-enhanced-ecommerce-analytics-integration-conversion-tracking/"><?php esc_html_e('Documentation', 'advance-ecommerce-tracking'); ?></a>
                    </li>
                    <li><a target="_blank"
                           href="https://store.multidots.com/dotstore-support-panel/ "><?php esc_html_e('Support Forum', 'advance-ecommerce-tracking'); ?></a>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="fr-1"><?php esc_html_e('Localization', 'advance-ecommerce-tracking'); ?></td>
            <td class="fr-2"><?php esc_html_e('English ,Spanish', 'advance-ecommerce-tracking'); ?></td>
        </tr>
        </tbody>
    </table>
</div>