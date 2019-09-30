<?php
if (!defined('ABSPATH')) exit;
$enable_twitter_conversion = get_option('advance_ecommerce_tracking_twitter_section_enable');
$twitter_conversion_id     = get_option('advance_ecommerce_tracking_section_twitter_conversion_id');
?>
<div class="waet-table res-cl">
    <form id="cw_plugin_form_id" method="POST" action="">
        <div class="under-table third-tab">
            <div class="set">
                <h2><?php esc_html_e('Twitter Conversion Settings', 'advance-ecommerce-tracking'); ?></h2>
            </div>
            <div class="set">
                <p><?php echo sprintf( esc_html__('Tracked events include people clicking on links, retweeting, liking or even simply viewing your tweets. %1$sSign in%2$s to your twitter conversion account.', 'advance-ecommerce-tracking'), '<a href="https://ads.twitter.com/login" target="_blank">', '</a>' ); ?></p>
            </div>
            <table class="form-table table-outer">
                <tbody>
                <tr>
                    <th scope="row"
                        class="titledesc"><label for="advance_ecommerce_tracking_twitter_section_enable"><?php esc_html_e('Enable', 'advance-ecommerce-tracking'); ?></label></th>
                    <td class="forminp">
                        <label class="switch">
                            <input type="checkbox" name="advance_ecommerce_tracking_twitter_section_enable"
                                   id="advance_ecommerce_tracking_twitter_section_enable"
                                <?php echo (isset($enable_twitter_conversion) && !empty($enable_twitter_conversion) && 'yes' === $enable_twitter_conversion) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description" style="display:none;"><?php esc_html_e('Enabling this will add twitter conversion code to your store.', 'advance-ecommerce-tracking'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"
                        class="titledesc"><label for="advance_ecommerce_tracking_section_twitter_conversion_id"><?php esc_html_e('Conversion ID', 'advance-ecommerce-tracking'); ?></label></th>
                    <td class="forminp">
                        <input type="text" name="advance_ecommerce_tracking_section_twitter_conversion_id"
                               id="advance_ecommerce_tracking_section_twitter_conversion_id" value="<?php echo esc_attr( $twitter_conversion_id ); ?>"
                               class="regular-text" placeholder="<?php esc_html_e('Twitter conversion ID goes here..', 'advance-ecommerce-tracking'); ?>">
                        <span class="ecommerce_tracking_description_tab"><i
                                    class="fa fa-question-circle "></i></span>
                        <p class="description" style="display:none;"><?php echo sprintf( esc_html__('Please follow this %1$sguide%2$s to setup your twitter conversion and get twitter conversion ID.', 'advance-ecommerce-tracking'), '<a href="javascript:void(0);" id="twitter_conversion_guide">', '</a>' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="forminp" colspan="2">
                        <?php
                        wp_nonce_field('twitter-tracking', 'twitter-tracking-nonce');
                        submit_button(esc_html__('Save Changes', 'advance-ecommerce-tracking'), 'primary', 'submit_twitter_settings');
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>