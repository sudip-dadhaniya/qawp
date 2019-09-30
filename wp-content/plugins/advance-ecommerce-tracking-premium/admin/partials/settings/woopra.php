<?php
if (!defined('ABSPATH')) exit;
$enable_woopra_tracking   = get_option('advance_ecommerce_tracking_woopra_section_enable');
$tracking_domain          = get_option('advance_ecommerce_tracking_section_woopra_tracking_domain');
$enable_add_to_cart       = get_option('advance_ecommerce_tracking_woopra_add_to_cart_section_enable');
$enable_remove_from_cart  = get_option('advance_ecommerce_tracking_woopra_cart_qty_remove_section_enable');
$enable_update_cart       = get_option('advance_ecommerce_tracking_woopra_cart_qty_update_section_enable');
$enable_order_placement   = get_option('advance_ecommerce_tracking_woopra_place_order_section_enable');
$enable_order_completion  = get_option('adavance_tracking_in_woopra_after_order_complete_enable');
$enable_applying_coupon   = get_option('advance_ecommerce_tracking_woopra_applied_coupon_section_enable');
$enable_user_registration = get_option('advance_ecommerce_tracking_woopra_user_register_section_enable');
?>
<div class="waet-table res-cl">
    <form id="cw_plugin_form_id" method="POST" action="">
        <div class="under-table third-tab">
            <div class="set">
                <h2><?php esc_html_e('Woopra Tracking Settings', 'advance-ecommerce-tracking'); ?></h2>
            </div>
            <div class="set">
                <p><?php echo sprintf(esc_html__('Woopra is the world\'s most comprehensive, information rich, easy to use, real-time web tracking and analysis application. %1$sSign in%2$s to your woopra account.', 'advance-ecommerce-tracking'), '<a href="https://www.woopra.com/" target="_blank">', '</a>'); ?></p>
            </div>
            <table class="form-table table-outer">
                <tbody>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_woopra_section_enable"><?php esc_html_e('Enable', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="advance_ecommerce_tracking_woopra_section_enable"
                                   id="advance_ecommerce_tracking_woopra_section_enable"
                                <?php echo (isset($enable_woopra_tracking) && !empty($enable_woopra_tracking) && 'yes' === $enable_woopra_tracking) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Add woopra tracking code to your store. Watch %1$show%2$s!', 'advance-ecommerce-tracking'), '<a target="_blank" href="http://www.screencast.com/t/2Olj0ovxqwI">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_section_woopra_tracking_domain"><?php esc_html_e('Domain', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <input type="text" name="advance_ecommerce_tracking_section_woopra_tracking_domain"
                               id="advance_ecommerce_tracking_section_woopra_tracking_domain" class="regular-text"
                               value="<?php echo esc_attr($tracking_domain); ?>"
                               placeholder="<?php esc_html_e('Domain goes here..', 'advance-ecommerce-tracking'); ?>">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_woopra_add_to_cart_section_enable"><?php esc_html_e('Track Add to Cart', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="advance_ecommerce_tracking_woopra_add_to_cart_section_enable"
                                   id="advance_ecommerce_tracking_woopra_add_to_cart_section_enable"
                                <?php echo (isset($enable_add_to_cart) && !empty($enable_add_to_cart) && 'yes' === $enable_add_to_cart) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to enable customer adding item to cart event tracking. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/woopra-step-5-add-item-cart.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_woopra_cart_qty_remove_section_enable"><?php esc_html_e('Track Remove from Cart', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox"
                                   name="advance_ecommerce_tracking_woopra_cart_qty_remove_section_enable"
                                   id="advance_ecommerce_tracking_woopra_cart_qty_remove_section_enable"
                                <?php echo (isset($enable_remove_from_cart) && !empty($enable_remove_from_cart) && 'yes' === $enable_remove_from_cart) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to enable customer removing item from cart event tracking. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/woopra-step-7-remove-item-from-cart.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_woopra_cart_qty_update_section_enable"><?php esc_html_e('Track Update Cart', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox"
                                   name="advance_ecommerce_tracking_woopra_cart_qty_update_section_enable"
                                   id="advance_ecommerce_tracking_woopra_cart_qty_update_section_enable"
                                <?php echo (isset($enable_update_cart) && !empty($enable_update_cart) && 'yes' === $enable_update_cart) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to enable customer updating item(s) in cart event tracking. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/woopra-step-6-update-cart.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_woopra_place_order_section_enable"><?php esc_html_e('Track Order Placement', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input name="advance_ecommerce_tracking_woopra_place_order_section_enable"
                                   id="advance_ecommerce_tracking_woopra_place_order_section_enable" type="checkbox"
                                <?php echo (isset($enable_order_placement) && !empty($enable_order_placement) && 'yes' === $enable_order_placement) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to enable customer placing orders event tracking. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/woopra-step-8-place-order.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="adavance_tracking_in_woopra_after_order_complete_enable"><?php esc_html_e('Track Order Completion', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="adavance_tracking_in_woopra_after_order_complete_enable"
                                   id="adavance_tracking_in_woopra_after_order_complete_enable"
                                <?php echo (isset($enable_order_completion) && !empty($enable_order_completion) && $enable_order_completion === 'yes') ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to enable order when marked as complete event tracking. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/woopra-step-9-complete-order.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_woopra_applied_coupon_section_enable"><?php esc_html_e('Track Applying Coupons', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox"
                                   name="advance_ecommerce_tracking_woopra_applied_coupon_section_enable"
                                   id="advance_ecommerce_tracking_woopra_applied_coupon_section_enable"
                                <?php echo (isset($enable_applying_coupon) && !empty($enable_applying_coupon) && 'yes' === $enable_applying_coupon) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to enable customer applying coupons event tracking. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/woopra-step-10-coupon-apply.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_woopra_user_register_section_enable"><?php esc_html_e('Track User Registration', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="advance_ecommerce_tracking_woopra_user_register_section_enable"
                                   id="advance_ecommerce_tracking_woopra_user_register_section_enable"
                                <?php echo (isset($enable_user_registration) && !empty($enable_user_registration) && 'yes' === $enable_user_registration) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Enable this if you wish to enable customer registration event tracking. %1$sExample%2$s.', 'advance-ecommerce-tracking'), '<a href="' . esc_url(ADVANCE_ECOMMERCE_TRACKING_PLUGIN_URL . 'admin/images/woopra-step-11-signup-tracking.jpg') . '" id="enabled_add_to_cart">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <td class="forminp" colspan="2">
                        <?php
                        wp_nonce_field('woopra-tracking', 'woopra-tracking-nonce');
                        submit_button(esc_html__('Save Changes', 'advance-ecommerce-tracking'), 'primary', 'submit_woopra_settings');
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>