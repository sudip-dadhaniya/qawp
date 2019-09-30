<?php
if (!defined('ABSPATH')) exit;
$enable_facebook_conversion = get_option('advance_ecommerce_tracking_facebook_section_enable');
$facebook_tracking_id       = get_option('advance_ecommerce_tracking_section_facebook_tracking_id');
$fb_add_to_cart_shop        = get_option('fb_add_to_cart_shop');
$fb_add_to_cart_single_prd  = get_option('fb_add_to_cart_single_prd');
$fb_purchase                = get_option('fb_purchase');
$fb_view_content            = get_option('fb_view_content');
$fb_view_product_category   = get_option('fb_view_product_category');
?>
<div class="waet-table res-cl">
    <form id="cw_plugin_form_id" method="POST" action="">
        <div class="under-table third-tab">
            <div class="set">
                <h2><?php esc_html_e('Facebook Conversion Pixel Settings', 'advance-ecommerce-tracking'); ?></h2>
            </div>
            <div class="set">
                <p><?php echo sprintf(esc_html__('%1$sSign in%2$s to your facebook conversion pixel account.', 'advance-ecommerce-tracking'), '<a href="https://www.facebook.com/ads/manage" target="_blank">', '</a>'); ?></p>
            </div>
            <table class="form-table table-outer">
                <tbody>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_facebook_section_enable"><?php esc_html_e('Enable', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="advance_ecommerce_tracking_facebook_section_enable"
                                   id="advance_ecommerce_tracking_facebook_section_enable"
                                <?php echo (isset($enable_facebook_conversion) && !empty($enable_facebook_conversion) && 'yes' === $enable_facebook_conversion) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php esc_html_e('Enabling this button will add facebook conversion pixel code to your store.', 'advance-ecommerce-tracking'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_section_facebook_tracking_id"><?php esc_html_e('Pixel ID', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <span class="woocommerce-help-tip"></span>
                        <input type="text" name="advance_ecommerce_tracking_section_facebook_tracking_id"
                               id="advance_ecommerce_tracking_section_facebook_tracking_id"
                               value="<?php echo esc_attr($facebook_tracking_id); ?>"
                               class="regular-text"
                               placeholder="<?php esc_html_e('Pixel ID goes here..', 'advance-ecommerce-tracking'); ?>">
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description"
                           style="display:none;"><?php echo sprintf(esc_html__('Click %1$shere%2$s to find your pixel ID and follow this %3$sguide%2$s to setup your facebook conversion pixel. Watch %4$sdemo video%2$s.', 'advance-ecommerce-tracking'), '<a target="_blank" href="https://www.facebook.com/ads/manager">', '</a>', '<a href="javascript:void(0);" id="fancybox_guid_facebook_ecommerce_tracking">', '<a target="_blank" href="http://www.screencast.com/t/aUVHMFOxpm">'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><?php esc_html_e('Trackable Events', 'advance-ecommerce-tracking'); ?></th>
                    <td class="forminp">
                        <div id="add-to-cart-shop-page" class="facebook-events-switch">
                            <label class="switch">
                                <input type="checkbox" name="fb_add_to_cart_shop" class="tracking_event"
                                    <?php echo (isset($fb_add_to_cart_shop) && !empty($fb_add_to_cart_shop) && 'yes' === $fb_add_to_cart_shop) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                            <?php esc_html_e('Add to Cart - Shop', 'advance-ecommerce-tracking'); ?>
                            <span class="ecommerce_tracking_description_tab"><i
                                        class="fa fa-question-circle "></i></span>
                            <p class="description"
                               style="display:none;"><?php esc_html_e('This event will fire on ajax add to cart on shop page.', 'advance-ecommerce-tracking'); ?></p>
                        </div>

                        <div id="add-to-cart-product-single" class="facebook-events-switch">
                            <label class="switch">
                                <input type="checkbox" name="fb_add_to_cart_single_prd" class="tracking_event"
                                    <?php echo (isset($fb_add_to_cart_single_prd) && !empty($fb_add_to_cart_single_prd) && 'yes' === $fb_add_to_cart_single_prd) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                            <?php esc_html_e('Add to Cart - Product Description', 'advance-ecommerce-tracking'); ?>
                            <span class="ecommerce_tracking_description_tab"><i
                                        class="fa fa-question-circle "></i></span>
                            <p class="description"
                               style="display:none;"><?php esc_html_e('This event will fire on ajax add to cart on single product page. Please make sure it will count whole total cart value.', 'advance-ecommerce-tracking'); ?></p>
                        </div>

                        <div id="purchase" class="facebook-events-switch">
                            <label class="switch">
                                <input type="checkbox" name="fb_purchase" class="tracking_event"
                                    <?php echo (isset($fb_purchase) && !empty($fb_purchase) && 'yes' === $fb_purchase) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                            <?php esc_html_e('Purchase', 'advance-ecommerce-tracking'); ?>
                            <span class="ecommerce_tracking_description_tab"><i
                                        class="fa fa-question-circle "></i></span>
                            <p class="description"
                               style="display:none;"><?php esc_html_e('This event will fire on order purchase.', 'advance-ecommerce-tracking'); ?></p>
                        </div>

                        <div id="view-content" class="facebook-events-switch">
                            <label class="switch">
                                <input type="checkbox" name="fb_view_content" class="tracking_event"
                                    <?php echo (isset($fb_view_content) && !empty($fb_view_content) && 'yes' === $fb_view_content) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                            <?php esc_html_e('View Content', 'advance-ecommerce-tracking'); ?>
                            <span class="ecommerce_tracking_description_tab"><i
                                        class="fa fa-question-circle "></i></span>
                            <p class="description"
                               style="display:none;"><?php esc_html_e('This event will fire when any user or customer views product.', 'advance-ecommerce-tracking'); ?></p>
                        </div>

                        <div id="view-category" class="facebook-events-switch">
                            <label class="switch">
                                <input type="checkbox" name="fb_view_product_category" class="tracking_event"
                                    <?php echo (isset($fb_view_product_category) && !empty($fb_view_product_category) && 'yes' === $fb_view_product_category) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                            <?php esc_html_e('View Category', 'advance-ecommerce-tracking'); ?>
                            <span class="ecommerce_tracking_description_tab"><i
                                        class="fa fa-question-circle "></i></span>
                            <p class="description"
                               style="display:none;"><?php esc_html_e('This event will fire when any user or customer views category of the products.', 'advance-ecommerce-tracking'); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="forminp" colspan="2">
                        <?php
                        wp_nonce_field('facebook-tracking', 'facebook-tracking-nonce');
                        submit_button(esc_html__('Save Changes', 'advance-ecommerce-tracking'), 'primary', 'submit_facebook_settings');
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>