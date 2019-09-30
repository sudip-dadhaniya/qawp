<?php
if (!defined('ABSPATH')) exit;
$google_adwords_conversion_enable = get_option('advance_ecommerce_tracking_google_section_enable');
$google_adwords_conversion_id     = get_option('advance_ecommerce_tracking_section_google_conversion_id');
$google_adwords_conversion_label  = get_option('advance_ecommerce_tracking_section_google_conversion_label');
?>
<div class="waet-table res-cl">
    <form id="cw_plugin_form_id" method="POST" action="">
        <div class="under-table third-tab">
            <div class="set">
                <h2><?php esc_html_e('Google Adwords Conversion Settings', 'advance-ecommerce-tracking'); ?></h2>
            </div>
            <div class="set">
                <p><?php echo sprintf(esc_html__('Sign in to your %1$sGoogle AdWords Account%2$s.', 'advance-ecommerce-tracking'), '<a href="https://www.google.com/adwords/?subid=in-en-or-ot-aw-c-dyn-ecommercetracking.dev2.in!o2" target="_blank">', '</a>'); ?></p>
            </div>
            <table class="form-table table-outer">
                <tbody>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label
                                for="advance_ecommerce_tracking_google_section_enable"><?php esc_html_e('Enable', 'advance-ecommerce-tracking'); ?></label>
                    </th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="advance_ecommerce_tracking_google_section_enable"
                                   id="advance_ecommerce_tracking_google_section_enable" <?php echo (isset($google_adwords_conversion_enable) && !empty($google_adwords_conversion_enable) && 'yes' === $google_adwords_conversion_enable) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label for="advance_ecommerce_tracking_section_google_conversion_id"><?php esc_html_e('Conversion ID', 'advance-ecommerce-tracking'); ?></label></th>
                    <td class="forminp">
                        <input name="advance_ecommerce_tracking_section_google_conversion_id"
                               id="advance_ecommerce_tracking_section_google_conversion_id" type="text"
                               value="<?php echo esc_attr($google_adwords_conversion_id); ?>"
                               class="regular-text" placeholder="E.g.: AW-*********">
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description" style="display:none;">
                            <?php echo sprintf(esc_html__('Please follow this guide to setup your %1$sGoogle Adwords Conversion ID%2$s.', 'advance-ecommerce-tracking'), '<a href="javascript:void(0);" id="fancybox_guid_google_conversion_tracking_id">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"
                        class="titledesc"><label for="advance_ecommerce_tracking_section_google_conversion_label"><?php esc_html_e('Conversion Label', 'advance-ecommerce-tracking'); ?></label></th>
                    <td class="forminp">
                        <input name="advance_ecommerce_tracking_section_google_conversion_label"
                               id="advance_ecommerce_tracking_section_google_conversion_label" type="text"
                               value="<?php echo esc_attr($google_adwords_conversion_label); ?>"
                               class="regular-text"
                               placeholder="<?php esc_html_e('Label goes here...', 'advance-ecommerce-tracking'); ?>">
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description" style="display:none;">
                            <?php echo sprintf(esc_html__('Please follow this guide to setup your %1$sGoogle Adwords Conversion Account%2$s.', 'advance-ecommerce-tracking'), '<a href="javascript:void(0);" id="fancybox_guid_google_conversion_tracking">', '</a>'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <td class="forminp" colspan="2">
                        <?php
                        wp_nonce_field('adwords-conversion-tracking', 'adwords-conversion-tracking-nonce');
                        submit_button(esc_html__('Save Changes', 'advance-ecommerce-tracking'), 'primary', 'submit_google_adwords_conversion_settings');
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>