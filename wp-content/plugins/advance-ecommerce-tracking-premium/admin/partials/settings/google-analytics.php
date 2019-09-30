<?php
if(! defined('ABSPATH')) exit;
$advance_ecommerce_tracking_section_enable = get_option('advance_ecommerce_tracking_section_enable');
$google_analytics_id                       = get_option('advance_ecommerce_tracking_section_google_uid');
?>
<div class="waet-table res-cl">
    <form id="cw_plugin_form_id" method="POST" action="">

        <div class="under-table third-tab">
            <div class="set">
                <h2><?php esc_html_e('Google Ecommerce Tracking Settings', 'advance-ecommerce-tracking'); ?></h2>
            </div>
            <div class="set">
                <p><?php echo sprintf(esc_html__('Sign in to your %1$sGoogle Analytics Account%2$s.', 'advance-ecommerce-tracking'), '<a href="https://www.google.com/analytics/web/provision/?authuser=0#provision/SignUp/" target="_blank">', '</a>'); ?></p>
            </div>
            <table class="form-table table-outer">
                <tbody>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                            for="advance_ecommerce_tracking_section_enable"><?php esc_html_e('Enable', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input name="advance_ecommerce_tracking_section_enable"
                                   id="advance_ecommerce_tracking_section_enable" type="checkbox"
                                <?php echo (isset($advance_ecommerce_tracking_section_enable) && !empty($advance_ecommerce_tracking_section_enable) && 'yes' === $advance_ecommerce_tracking_section_enable) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                class="fa fa-question-circle "></i></span>
                        <p class="description" style="display: none;">
                            <?php echo sprintf(esc_html__('Please follow %1$sthis guide%2$s to setup your Google Analytics Account.', 'advance-ecommerce-tracking'), '<a href="javascript:void(0);" id="fancybox_guid_google_ecommerce_tracking">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                            for="advance_ecommerce_tracking_section_google_uid"><?php esc_html_e('Google Analytics ID', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <input name="advance_ecommerce_tracking_section_google_uid"
                               id="advance_ecommerce_tracking_section_google_uid" type="text"
                               value="<?php echo esc_attr($google_analytics_id); ?>" class="regular-text"
                               placeholder="E.g.: UA-******-**">
                        <span class="ecommerce_tracking_description_tab"><i class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display: none;"><?php echo sprintf(esc_html__('Where can I find my %1$stracking ID%2$s? Format: UA-000000-01.', 'advance-ecommerce-tracking'), '<a target="_blank" href="https://support.google.com/analytics/answer/1032385?hl=en">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><?php esc_html_e('What will it track?', 'advance-ecommerce-tracking'); ?> </th>
                    <td class="forminp">
                        <label class="label_event">
                            <?php esc_html_e('You can see multiple events in google analytics. EX: Add To Cart, Apply Coupon On Cart, Apply Coupon On Checkout, Purchase, Remove From Cart, Update Cart, Ecommerce Search. (Please click on tooltip icon. You can see screenhsot for all the tracking event).', 'advance-ecommerce-tracking'); ?>
                            <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                            <p class="description" style="display:none;">
                                <?php esc_html_e('Please check screenshot for that: ', 'advance-ecommerce-tracking'); ?>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/event_category.png'); ?>"
                                   target="_blank"><?php esc_html_e('Event Catgeory, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/event_action.png'); ?>"
                                   target="_blank"><?php esc_html_e('Event Action, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/event_label.png'); ?>"
                                   target="_blank"><?php esc_html_e('Event Label', 'advance-ecommerce-tracking'); ?></a>
                            </p>
                        </label>
                        <br>
                        <label class="label_event">
                            <?php esc_html_e('You can also see activity in Ecommerce section in google analytics. EX: Revenue, Shopping Behavior, Checkout Behavior, Product Performance, Sales Performance, Product List Performance, Order Coupon. (Please click on tooltip icon. You can see screenhsot for all the activity).', 'advance-ecommerce-tracking'); ?>
                            <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                            <p class="description" style="display:none;">
                                <?php esc_html_e('Please check screenshot for that: ', 'advance-ecommerce-tracking'); ?>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/revenue.png'); ?>"
                                   target="_blank"><?php esc_html_e('Revenue, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/shopping_behavior.png'); ?>"
                                   target="_blank"><?php esc_html_e('Shopping Behavior, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/checkout_behavior.png'); ?>"
                                   target="_blank"><?php esc_html_e('Checkout Behavior, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/product_performance.png'); ?>"
                                   target="_blank"><?php esc_html_e('Product Performance, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/sales_performance.png'); ?>"
                                   target="_blank"><?php esc_html_e('Sales Performance, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/product_list_performance.png'); ?>"
                                   target="_blank"><?php esc_html_e('Product List Performance, ', 'advance-ecommerce-tracking'); ?></a>
                                <a href="<?php echo esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/order_coupon.png'); ?>"
                                   target="_blank"><?php esc_html_e('Order Coupon', 'advance-ecommerce-tracking'); ?></a>
                            </p>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="forminp">
                        <?php wp_nonce_field('google-analytics-tracking', 'google-analytics-tracking-nonce'); ?>
                        <?php submit_button(esc_html__('Save Changes', 'advance-ecommerce-tracking'), 'primary', 'submit_google_ecommerce_tracking_settings'); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>