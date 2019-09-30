<?php
if (!defined('ABSPATH')) exit;

$plugin_name        = ADVANCED_ECOMMERCE_TRACKING_PLUGIN_NAME;
$plugin_version     = ADVANCED_ECOMMERCE_TRACKING_PLUGIN_VERSION;
$ecommerce_tracking = $google_ecommerce_tracking = $goolge_adword_conversion = $woopra_tracking = $gosquared_tracking = $facebook_conversion = $twitter_conversion = $plugin_get_started_method = $plugin_dotstore_contact_support = '';
if (isset($tab) && !empty($tab) && 'advance_ecommerce_tracking' === $tab) $ecommerce_tracking = 'active';
if (isset($page) && !empty($page) && 'ecommerce_tracking_pro' === $page && empty($tab)) $ecommerce_tracking = 'active';
if (isset($tab) && !empty($tab) && 'section-google-tracking' === $tab) $goolge_adword_conversion = 'active';
if (isset($tab) && !empty($tab) && 'section-woopra-tracking' === $tab) $woopra_tracking = 'active';
if (isset($tab) && !empty($tab) && 'section-gosquared-tracking' === $tab) $gosquared_tracking = 'active';
if (isset($tab) && !empty($tab) && 'section-facebook-tracking' === $tab) $facebook_conversion = 'active';
if (isset($tab) && !empty($tab) && 'section-twitter-tracking' === $tab) $twitter_conversion = 'active';
if (isset($tab) && !empty($tab) && 'wc_pro_ecommerce_tracking_get_started_method' === $tab) $plugin_get_started_method = 'active';
if (isset($tab) && !empty($tab) && 'dotstore_introduction_ecommerce_tracking_pro' === $tab) $plugin_dotstore_contact_support = 'active';
$plugin_url = admin_url() . 'admin.php?page=ecommerce_tracking_pro&tab=';
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-logo-main">
                <img src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . '/admin/images/WSFL.jpg'); ?>">
            </div>
            <div class="dots-header-right">
                <div class="logo-detail">
                    <strong><?php esc_html_e($plugin_name, 'advance-ecommerce-tracking'); ?> </strong>
                    <span><?php echo sprintf(esc_html__('Premium Version %1$s', 'advance-ecommerce-tracking'), esc_html($plugin_version)); ?></span>
                </div>
                <div class="button-group">
                    <?php
                    if (aet_fs()->is__premium_only()) {
                        if (aet_fs()->can_use_premium_code()) {
                            global $aet_fs;
                            ?>
                            <div class="button-dots-left">
                                <span class="support_dotstore_image"><a target="_blank"
                                                                        href="<?php echo esc_url($aet_fs->get_account_url()); ?>">
                                        <img alt="Img"
                                             src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/account_new.png'); ?>"></a>
                                </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="button-dots">
                    <span class="support_dotstore_image"><a target="_blank"
                                                            href="<?php echo esc_url('https://www.thedotstore.com/support/'); ?>">
                            <img src="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/support_new.png'); ?>"></a>
                    </span>
                    </div>
                </div>
            </div>
            <div class="dots-menu-main">
                <nav>
                    <ul>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($ecommerce_tracking); ?>"
                               href="<?php echo esc_url("{$plugin_url}advance_ecommerce_tracking"); ?>"><?php esc_html_e('Google Analytics Tracking', 'advance-ecommerce-tracking'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($goolge_adword_conversion); ?>"
                               href="<?php echo esc_url("{$plugin_url}section-google-tracking"); ?>"><?php esc_html_e('Google AdWords Conversion', 'advance-ecommerce-tracking'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($woopra_tracking); ?>"
                               href="<?php echo esc_url("{$plugin_url}section-woopra-tracking"); ?>"><?php esc_html_e('Woopra Tracking', 'advance-ecommerce-tracking'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($gosquared_tracking); ?>"
                               href="<?php echo esc_url("{$plugin_url}section-gosquared-tracking"); ?>"><?php esc_html_e('GoSquared Tracking', 'advance-ecommerce-tracking'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($facebook_conversion); ?>"
                               href="<?php echo esc_url("{$plugin_url}section-facebook-tracking"); ?>"><?php esc_html_e('Facebook Conversion', 'advance-ecommerce-tracking'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($twitter_conversion); ?>"
                               href="<?php echo esc_url("{$plugin_url}section-twitter-tracking"); ?>"><?php esc_html_e('Twitter Conversion', 'advance-ecommerce-tracking'); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr("{$plugin_get_started_method} {$plugin_dotstore_contact_support}"); ?>"
                               href="<?php echo esc_url("{$plugin_url}wc_pro_ecommerce_tracking_get_started_method"); ?>"><?php esc_html_e('About Plugin', 'advance-ecommerce-tracking'); ?></a>
                            <ul class="sub-menu">
                                <li><a class="dotstore_plugin <?php echo esc_attr($plugin_get_started_method); ?> "
                                       href="<?php echo esc_url("{$plugin_url}wc_pro_ecommerce_tracking_get_started_method"); ?>"><?php esc_html_e('Getting Started', 'advance-ecommerce-tracking'); ?></a>
                                </li>
                                <li>
                                    <a class="dotstore_plugin <?php echo esc_attr($plugin_dotstore_contact_support); ?> "
                                       href="<?php echo esc_url("{$plugin_url}dotstore_introduction_ecommerce_tracking_pro"); ?>"><?php esc_html_e('Quick Info', 'advance-ecommerce-tracking'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="dotstore_plugin"
                               href="javascript:void(0);"><?php esc_html_e('DotStore', 'advance-ecommerce-tracking'); ?></a>
                            <ul class="sub-menu">
                                <li><a target="_blank"
                                       href="<?php echo esc_url('https://www.thedotstore.com/woocommerce-plugins/'); ?>"><?php esc_html_e('WooCommerce Plugins', 'advance-ecommerce-tracking'); ?></a>
                                </li>
                                <li><a target="_blank"
                                       href="<?php echo esc_url('https://www.thedotstore.com/wordpress-plugins/'); ?>"><?php esc_html_e('WordPress Plugins', 'advance-ecommerce-tracking'); ?></a>
                                </li>
                                <li><a target="_blank"
                                       href="<?php echo esc_url('https://www.thedotstore.com/support'); ?>"><?php esc_html_e('Contact Support', 'advance-ecommerce-tracking'); ?></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>