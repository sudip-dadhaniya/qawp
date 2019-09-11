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
// Add an nonce field so we can check for it later.
wp_nonce_field( 'size_chart_inner_custom_box', 'size_chart_inner_custom_box' );
$post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );

// Use get_post_meta to retrieve an existing value from the database.
$chart_label      = get_post_meta( $post_id, 'label', true );
$chart_img        = get_post_meta( $post_id, 'primary-chart-image', true );
$chart_position   = get_post_meta( $post_id, 'position', true );
$chart_categories = (array) get_post_meta( $post_id, 'chart-categories', true );
$chart_table      = get_post_meta( $post_id, 'chart-table', true );
$table_style      = get_post_meta( $post_id, 'table-style', true );

// Display the form, using the current value.
$img               = wp_get_attachment_image_src( $chart_img, 'thumbnail' );
$image_url         = plugins_url( 'images/chart-img-placeholder.jpg', dirname( __FILE__ ) );
$img_width         = '';
$img_height        = '';
$close_icon_enable = false;

if ( $img[0] ) {
	$image_url         = $img[0];
	$img_width         = $img[1];
	$img_height        = $img[2];
	$close_icon_enable = true;
}
?>
<div id="size-chart-meta-fields">
    <div id="field">
        <div class="field-title"><h4><?php esc_html_e( 'Label', 'size-chart-for-woocommerce' ); ?></h4></div>
        <div class="field-description"><?php esc_html_e( 'Chart Label', 'size-chart-for-woocommerce' ); ?></div>
        <div class="field-item"><input type="text" id="label" name="label" value="<?php echo esc_attr( $chart_label ); ?>"/></div>
    </div>

    <div id="field">
        <div class="field-title"><h4><?php esc_html_e( 'Primary Chart Image', 'size-chart-for-woocommerce' ); ?></h4></div>
        <div class="field-description"><?php esc_html_e( 'Add/Edit primary chart image below', 'size-chart-for-woocommerce' ); ?></div>
        <div class="field-item">
            <input type="hidden" name="primary-chart-image" id="primary-chart-image" value="<?php echo esc_attr( $chart_img ); ?>"/></div>

        <div id="field-image">
            <div class="field_image_box">
                <img src="<?php echo esc_url( $image_url ); ?>" width="<?php esc_attr_e( $img_width ); ?>" height="<?php esc_attr_e( $img_height ); ?>" class="<?php esc_attr_e( $post_id ); ?>" id="meta_img"/>

				<?php if ( true === $close_icon_enable ) { ?>
                    <a id="<?php esc_attr_e( $post_id ); ?>" class="delete-chart-image">
                        <img src="<?php echo esc_url( plugins_url( 'images/close-icon.png', dirname( __FILE__ ) ) ); ?>"/>
                    </a>
				<?php } ?>
            </div>
        </div>
        <div class="field-item">
            <input type="button" id="meta-image-button" class="button" value="<?php esc_attr_e( 'Upload', 'size-chart-for-woocommerce' ) ?>"/></div>
    </div>

    <div id="field">
        <div class="field-title"><h4><?php esc_html_e( 'Chart Categories', 'size-chart-for-woocommerce' ); ?></h4></div>
        <div class="field-description"><?php esc_html_e( 'Select categories for chart to appear on.', 'size-chart-for-woocommerce' ); ?></div>
        <div class="field-item">
            <select name="chart-categories[]" id="chart-categories" multiple="multiple">
				<?php $term = get_terms( 'product_cat', array() ); ?>
				<?php if ( $term ): foreach ( $term as $cat ) { ?>
					<?php $selected = in_array( $cat->term_id, $chart_categories, true ) ? 'selected' : ''; ?>
                    <option value="<?php esc_attr_e( $cat->term_id ); ?>" <?php esc_attr_e( $selected ); ?> ><?php esc_html_e( $cat->name, 'size-chart-for-woocommerce' ); ?></option>
				<?php } endif; ?>

            </select>
        </div>
    </div>
    <div style="clear:both"></div>
    <div id="field">
        <div class="field-title"><h4><?php esc_html_e( 'Chart Position', 'size-chart-for-woocommerce' ); ?></h4></div>
        <div class="field-description"><?php esc_html_e( 'Select if the chart will display as a popup or as a additional tab', 'size-chart-for-woocommerce' ); ?></div>
        <div class="field-item">
            <select name="position" id="position">
                <option value="tab" <?php selected( $chart_position, 'tab', true ); ?> ><?php esc_html_e( 'Additional Tab', 'size-chart-for-woocommerce' ); ?></option>
                <option value="popup" <?php selected( $chart_position, 'popup', true ); ?>><?php esc_html_e( 'Modal Pop Up', 'size-chart-for-woocommerce' ); ?></option>
            </select>
        </div>
    </div>
    <div id="field">
        <div class="field-title"><h4><?php esc_html_e( 'Chart Table Style', 'size-chart-for-woocommerce' ); ?></h4></div>
        <div class="field-description"><?php esc_html_e( 'Chart Table Styles (Default Style)', 'size-chart-for-woocommerce' ); ?></div>
        <div class="field-item">
            <select name="table-style" id="table-style">
                <option value="default-style" <?php selected( $table_style, 'default-style', true ); ?> ><?php esc_html_e( 'Default Style', 'size-chart-for-woocommerce' ); ?></option>
                <option value="minimalistic" <?php selected( $table_style, 'minimalistic', true ); ?> ><?php esc_html_e( 'Minimalistic', 'size-chart-for-woocommerce' ); ?></option>
                <option value="classic" <?php selected( $table_style, 'classic', true ); ?> ><?php esc_html_e( 'Classic', 'size-chart-for-woocommerce' ); ?></option>
                <option value="modern" <?php selected( $table_style, 'modern', true ); ?>><?php esc_html_e( 'Modern', 'size-chart-for-woocommerce' ); ?></option>
                <option value="custom-style" <?php selected( $table_style, 'custom-style', true ); ?>><?php esc_html_e( 'Custom Style', 'size-chart-for-woocommerce' ); ?></option>
            </select>
        </div>
    </div>
    <div id="field">
        <div class="field-title"><h4><?php esc_html_e( 'Chart Table', 'size-chart-for-woocommerce' ); ?></h4></div>
        <div class="field-description"><?php esc_html_e( 'Add/Edit chart below', 'size-chart-for-woocommerce' ); ?></div>
        <div class="field-item">
            <textarea id="chart-table" name="chart-table"><?php esc_attr_e( $chart_table ); ?></textarea></div>
    </div>
</div>