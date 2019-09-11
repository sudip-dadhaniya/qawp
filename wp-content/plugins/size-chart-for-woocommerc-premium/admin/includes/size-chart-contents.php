<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    size-chart-for-woocommerce
 * @subpackage size-chart-for-woocommerce/public/includes
 * @author     Multidots
 */
$chart_label    = get_post_meta( $chart_id, 'label', true );
$chart_table    = get_post_meta( $chart_id, 'chart-table', true );
$chart_position = get_post_meta( $chart_id, 'position', true );
if ( isset( $chart_label ) && ! empty( $chart_label ) ) {
	?>
    <h3><?php esc_html_e( $chart_label ); ?></h3>
	<?php
}

$post_data = get_post( $chart_id );
if ( $post_data->post_content ) {
	$content   = apply_filters( 'the_content', $post_data->post_content );
	$guid_text = esc_html__( 'How to measure', 'size-chart-for-woocommerce' );
	echo wp_kses_post( '<div class="chart-content"><span>' . $guid_text . '</span>' . $content . '</div>' );
}

$chart_image = get_post_meta( $post_data->ID, 'primary-chart-image', true );
if ( $chart_image ) {
	$chart_image = wp_get_attachment_image_src( $chart_image, 'full' );
	?>
    <div class="chart-image">
        <img src="<?php echo esc_url( $chart_image[0] ); ?> " alt="<?php esc_attr_e( $post->post_title, 'size-chart-for-woocommerce' ); ?>" title="<?php esc_attr_e( $chart_label ); ?>"/>
    </div>
	<?php
}

if ( isset( $chart_table ) ) {
	?>
    <div class="chart-table">
		<?php $this->size_chart_display_table( $chart_table ); ?>
    </div>
	<?php
}
?>
