<?php
/**
 * Provide a admin area form view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    size-chart-for-woocommerce
 * @subpackage size-chart-for-woocommerce/admin/includes
 */
global $pagenow;
if ( empty( $this->size_chart_settings ) ) {
	$this->size_chart_settings = get_option( 'size_chart_settings' );
}
?>
<div class="wrap ajax_cart size-chart-setting">
    <fieldset class="custom-fieldset set-size-chart-fieldset set-size-chart-fieldset-container">
        <h1><?php esc_html_e( 'Size Chart Settings', 'size-chart-for-woocommerce' ); ?></h1>
        <h4><strong><?php esc_html_e( 'Default size chart template', 'size-chart-for-woocommerce' ); ?></strong></h4>
        <p><?php esc_html_e( 'This plugin have sample default size chart template, So you can direct apply to product or category.', 'size-chart-for-woocommerce' ); ?></p>
        <h4><strong><?php esc_html_e( 'Create your own size guide', 'size-chart-for-woocommerce' ); ?></strong></h4>
        <p><?php esc_html_e( 'This Plugin, you are able to customize/ clone the default size chart and create your own size guide for anything you imagine!', 'size-chart-for-woocommerce' ); ?></p>
        <h4><strong><?php esc_html_e( 'Comprehensive display', 'size-chart-for-woocommerce' ); ?> </strong></h4>
        <p><?php esc_html_e( 'Customers will be able to fully understand your product and buy it without making unnecessary questions regarding size.', 'size-chart-for-woocommerce' ); ?></p>
        <form method="post" action="<?php admin_url( 'admin.php?page=size_chart_setting_page' ); ?>" enctype="multipart/form-data">
			<?php wp_nonce_field( "size_chart_page" );
			$get_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
			if ( 'edit.php' === $pagenow && 'size_chart_setting_page' === $get_page ){
			?>
            <div id="size-chart-setting-fields">
                <fieldset class="custom-fieldset set-size-chart-fieldset">
                    <legend><?php esc_html_e( 'General Settings', 'size-chart-for-woocommerce' ); ?></legend>
                    <div class="setting-description">
                        <p><?php esc_html_e( 'With this setting you can configure size chart table style like table head font color, table row color, table head background color etc. Note: (For this setting you will have to select custom style from particular size chart.<a href="' . plugins_url( 'images/custom_style_size_chart.png', dirname( __FILE__ ) ) . '" target="_blank">Check Screenshot</a>)', 'size-chart-for-woocommerce' ); ?></p>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e( 'Table Head Background Color', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="hidden" name="size-chart-table-head-color" id="color-picker2" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-table-head-color'] ) ) ? $this->size_chart_settings['size-chart-table-head-color'] : '' ); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Table Head Font Color', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="hidden" name="size-chart-table-head-font-color" id="color-picker3" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-table-head-font-color'] ) ) ? $this->size_chart_settings['size-chart-table-head-font-color'] : '' ); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Table Even Row Color', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="hidden" name="size-chart-table-row-even-color" id="color-picker4" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-table-row-even-color'] ) ) ? $this->size_chart_settings['size-chart-table-row-even-color'] : '' ); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Table Odd Raw Color', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="hidden" name="size-chart-table-row-odd-color" id="color-picker5" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-table-row-odd-color'] ) ) ? $this->size_chart_settings['size-chart-table-row-odd-color'] : '' ); ?>"/>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset class="custom-fieldset set-size-chart-fieldset">
                    <legend><?php esc_html_e( 'Global Settings', 'size-chart-for-woocommerce' ); ?></legend>
                    <div class="setting-description">
                        <p><?php esc_html_e( 'With this setting you can add size chart label and it will same for all product size charts.', 'size-chart-for-woocommerce' ); ?></p>
                    </div>
                    <table class="form-table global-setting">
                        <tr>
                            <th><?php esc_html_e( 'Tab Label', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="text" name="size-chart-tab-label" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-tab-label'] ) && ! empty( $this->size_chart_settings['size-chart-tab-label'] ) ) ? $this->size_chart_settings['size-chart-tab-label'] : 'Size Chart' ); ?>"/>
                            </td>
                            <td>
                                <div class="setting-description"><?php esc_html_e( 'It is visible on product details page in the custom tab.', 'size-chart-for-woocommerce' ); ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Popup Label', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="text" name="size-chart-popup-label" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-popup-label'] ) && ! empty( $this->size_chart_settings['size-chart-popup-label'] ) ) ? $this->size_chart_settings['size-chart-popup-label'] : 'Size Chart' ); ?>"/>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset class="custom-fieldset set-size-chart-fieldset">
                    <legend><?php esc_html_e( 'Pop Up Settings', 'size-chart-for-woocommerce' ); ?></legend>
                    <div class="setting-description">
                        <p><?php esc_html_e( 'With this setting you can configure size chart popup link position, color and you can apply custom class also.', 'size-chart-for-woocommerce' ); ?></p>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th><h4><?php esc_html_e( 'Chart Popup Label Position', 'size-chart-for-woocommerce' ); ?></h4></th>
                            <td>
                                <select name="size-chart-button-position" id="size-chart-button-position">
                                    <option value="before-summary-text" <?php esc_attr_e( isset( $this->size_chart_settings['size-chart-button-position'] ) && selected( $this->size_chart_settings['size-chart-button-position'], 'before-summary-text' ) ); ?> ><?php esc_html_e( 'Before Summary Text', 'size-chart-for-woocommerce' ); ?></option>
                                    <option value="after-add-to-cart" <?php esc_attr_e( isset( $this->size_chart_settings['size-chart-button-position'] ) && selected( $this->size_chart_settings['size-chart-button-position'], 'after-add-to-cart' ) ); ?>><?php esc_html_e( 'After Add to Cart', 'size-chart-for-woocommerce' ); ?></option>
                                    <option value="before-add-to-cart" <?php esc_attr_e( isset( $this->size_chart_settings['size-chart-button-position'] ) && selected( $this->size_chart_settings['size-chart-button-position'], 'before-add-to-cart' ) ); ?>><?php esc_html_e( 'Before Add to Cart', 'size-chart-for-woocommerce' ); ?></option>
                                    <option value="after-product-meta" <?php esc_attr_e( isset( $this->size_chart_settings['size-chart-button-position'] ) && selected( $this->size_chart_settings['size-chart-button-position'], 'after-product-meta' ) ); ?>><?php esc_html_e( 'After Product Meta', 'size-chart-for-woocommerce' ); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Label Text Color', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="hidden" name="size-chart-title-color" id="color-picker1" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-title-color'] ) ) ? $this->size_chart_settings['size-chart-title-color'] : '' ); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Label Class', 'size-chart-for-woocommerce' ); ?></th>
                            <td>
                                <input type="text" name="size-chart-button-class" value="<?php esc_attr_e( ( isset( $this->size_chart_settings['size-chart-button-class'] ) ) ? $this->size_chart_settings['size-chart-button-class'] : '' ); ?>"/>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset class="custom-fieldset set-size-chart-fieldset">
                    <legend><?php esc_html_e( 'Custom CSS', 'size-chart-for-woocommerce' ); ?></legend>
                    <div class="setting-description">
                        <p><?php esc_html_e( 'With this setting you can configure size chart popup link position, color and you can apply custom class also.', 'size-chart-for-woocommerce' ); ?></p>
                    </div>
                    <table class="form-table">
                        <tr>
                            <textarea id="custom_css" name="custom_css"><?php esc_attr_e( ( isset( $this->size_chart_settings['custom_css'] ) ) ? $this->size_chart_settings['custom_css'] : '' ); ?></textarea>
                        </tr>
                    </table>
                </fieldset>
                <p class="submit">
                    <input type="submit" class="button-primary" name="size_chart_submit" value="<?php esc_html_e( 'Save Changes', 'size-chart-for-woocommerce' ) ?>"/>
                </p>
    </fieldset>
</div>

<?php } ?>
</form>