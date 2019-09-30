<?php
if (!defined('ABSPATH')) exit;
$enable_gosquared         = get_option('advance_ecommerce_tracking_gosquared_section_enable');
$tracking_id              = get_option('advance_ecommerce_tracking_section_gosquared_tracking_id');
$tracking_api_key         = get_option('advance_ecommerce_tracking_section_gosquared_tracking_api_key');
$enable_add_to_cart       = get_option('adavance_tracking_in_gosquared_add_to_cart_enable');
$enable_update_cart       = get_option('adavance_tracking_gosquared_in_update_cart_enable');
$enable_remove_cart_item  = get_option('adavance_tracking_in_gosquared_remove_cart_item_enable');
$enable_order_placement   = get_option('adavance_tracking_in_gosquared_place_order_enable');
$enable_order_completion  = get_option('adavance_tracking_in_gosquared_after_order_complete_enable');
$enable_applying_coupon   = get_option('adavance_tracking_in_gosquared_applied_coupon_page_enable');
$enable_user_registration = get_option('advance_ecommerce_tracking_gosquared_user_register_section_enable');
?>
<div class="waet-table res-cl">
    <form id="cw_plugin_form_id" method="POST" action="">
        <div class="under-table third-tab">
            <div class="set">
                <h2><?php esc_html_e('GoSquared Tracking Settings', 'advance-ecommerce-tracking'); ?></h2>
            </div>
            <div class="set">
                <p><?php echo sprintf(esc_html__('GoSquared is easy to start converting more visitors into leads. It easy to see browsing activity that led them to get in touch, and if they leave their email address, you can even see their social profiles, job title and the company they work at. %1$sSign in%2$s to your gosquared account.', 'advance-ecommerce-tracking'), '<a href="https://www.gosquared.com/" target="_blank">', '</a>'); ?></p>
            </div>
            <table class="form-table table-outer">
                <tbody>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_gosquared_section_enable"><?php esc_html_e('Enable', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="advance_ecommerce_tracking_gosquared_section_enable"
                                   id="advance_ecommerce_tracking_gosquared_section_enable"
                                <?php echo (isset($enable_gosquared) && !empty($enable_gosquared) && 'yes' === $enable_gosquared) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Please follow this %1$sguide%2$s to setup your GoSquared Tracking and watch a demo %3$svideo%2$s to learn more.', 'advance-ecommerce-tracking'), '<a href="javascript:void(0);" id="fancybox_guid_gosquard_ecommerce_tracking">', '</a>', '<a target="_blank" href="http://www.screencast.com/t/cjRgOsX9D24c" id="fancybox_guid_gosquard_ecommerce_tracking_video">'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_section_gosquared_tracking_id"><?php esc_html_e('Tracking ID', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <span class="woocommerce-help-tip"></span>
                        <input type="text" name="advance_ecommerce_tracking_section_gosquared_tracking_id"
                               id="advance_ecommerce_tracking_section_gosquared_tracking_id"
                               value="<?php echo esc_attr($tracking_id); ?>" class="regular-text"
                               placeholder="<?php esc_html_e('Tracking ID goes here...', 'advance-ecommerce-tracking'); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_section_gosquared_tracking_api_key"><?php esc_html_e('Tracking API Key', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <input type="text" name="advance_ecommerce_tracking_section_gosquared_tracking_api_key"
                               id="advance_ecommerce_tracking_section_gosquared_tracking_api_key"
                               value="<?php echo esc_attr($tracking_api_key); ?>" class="regular-text"
                               placeholder="<?php esc_html_e('API Key goes here...', 'advance-ecommerce-tracking'); ?>">
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Click %1$shere%2$s to find your tracking API key.', 'advance-ecommerce-tracking'), '<a href="javascript:void(0);" id="find_gosquard_tracking_api_key">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="adavance_tracking_in_gosquared_add_to_cart_enable"><?php esc_html_e('Track Add to Cart', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="adavance_tracking_in_gosquared_add_to_cart_enable"
                                   id="adavance_tracking_in_gosquared_add_to_cart_enable"
                                <?php echo (isset($enable_add_to_cart) && !empty($enable_add_to_cart) && 'yes' === $enable_add_to_cart) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to track customer adding items to cart. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/gosquard-step-10-added-to-cart.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="adavance_tracking_gosquared_in_update_cart_enable"><?php esc_html_e('Track Cart Update', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="adavance_tracking_gosquared_in_update_cart_enable"
                                   id="adavance_tracking_gosquared_in_update_cart_enable"
                                <?php echo (isset($enable_update_cart) && !empty($enable_update_cart) && 'yes' === $enable_update_cart) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to track customer updating items in cart. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/gosquard-step-11-update-cart.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="adavance_tracking_in_gosquared_remove_cart_item_enable"><?php esc_html_e('Track Remove from Cart', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="adavance_tracking_in_gosquared_remove_cart_item_enable"
                                   id="adavance_tracking_in_gosquared_remove_cart_item_enable"
                                <?php echo (isset($enable_remove_cart_item) && !empty($enable_remove_cart_item) && 'yes' === $enable_remove_cart_item) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to track customer removing items from cart. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/gosquard-step-12-removed-item-cart.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="adavance_tracking_in_gosquared_place_order_enable"><?php esc_html_e('Track Order Placement', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="adavance_tracking_in_gosquared_place_order_enable"
                                   id="adavance_tracking_in_gosquared_place_order_enable"
                                <?php echo (isset($enable_order_placement) && !empty($enable_order_placement) && 'yes' === $enable_order_placement) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to track customer placing orders. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/gosquard-step-14-placed-order.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="adavance_tracking_in_gosquared_after_order_complete_enable"><?php esc_html_e('Track Order Completion', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="adavance_tracking_in_gosquared_after_order_complete_enable"
                                   id="adavance_tracking_in_gosquared_after_order_complete_enable"
                                <?php echo (isset($enable_order_completion) && !empty($enable_order_completion) && 'yes' === $enable_order_completion) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to track orders when marked as complete. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/gosquard-step-15-complete-order.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="adavance_tracking_in_gosquared_applied_coupon_page_enable"><?php esc_html_e('Track Applying Coupon', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="adavance_tracking_in_gosquared_applied_coupon_page_enable"
                                   id="adavance_tracking_in_gosquared_applied_coupon_page_enable"
                                <?php echo (isset($enable_applying_coupon) && !empty($enable_applying_coupon) && 'yes' === $enable_applying_coupon) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to track when coupons are applied. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/gosquard-step-13-coupon-applied.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_gosquared_user_register_section_enable"><?php esc_html_e('Track User Registration', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox"
                                   name="advance_ecommerce_tracking_gosquared_user_register_section_enable"
                                   id="advance_ecommerce_tracking_gosquared_user_register_section_enable"
                                <?php echo (isset($enable_user_registration) && !empty($enable_user_registration) && 'yes' === $enable_user_registration) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to track new customers registrations. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/gosquard-step-18-user-register-track.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="forminp">
                        <?php
                        wp_nonce_field('gosquared-tracking', 'gosquared-tracking-nonce');
                        submit_button(esc_html__('Save Changes', 'advance-ecommerce-tracking'), 'primary', 'submit_gosquared_settings');
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>