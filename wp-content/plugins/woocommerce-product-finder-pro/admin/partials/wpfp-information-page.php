<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$file_dir_path = 'header/plugin-header.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	include_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}
?>
    <div class="wpfp-main-table">
        <h2>
			<?php esc_html_e( 'Quick info', 'woo-product-finder' ); ?>
        </h2>
        <table class="table-outer">
            <tbody>
            <tr>
                <td class="fr-1">
					<?php esc_html_e( 'Product Type', 'woo-product-finder' ); ?>
                </td>
                <td class="fr-2">
					<?php esc_html_e( 'WooCommerce Plugin', 'woo-product-finder' ); ?>
                </td>
            </tr>
            <tr>
                <td class="fr-1">
					<?php esc_html_e( 'Product Name', 'woo-product-finder' ); ?>
                </td>
                <td class="fr-2">
					<?php echo esc_html( $this->get_plugin_name() ); ?>
                </td>
            </tr>
            <tr>
                <td class="fr-1">
					<?php esc_html_e( 'Installed Version', 'woo-product-finder' ); ?>
                </td>
                <td class="fr-2">
					<?php esc_html_e( 'Pro Version', 'woo-product-finder' ); ?>
					<?php echo esc_html( $this->get_plugin_version() ); ?>
                </td>
            </tr>
            <tr>
                <td class="fr-1">
					<?php esc_html_e( 'License & Terms of use', 'woo-product-finder' ); ?>
                </td>
                <td class="fr-2">
                    <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/terms-and-conditions/" ); ?>">
						<?php esc_html_e( 'Click here', 'woo-product-finder' ); ?>
                    </a>
					<?php esc_html_e( 'to view license and terms of use.', 'woo-product-finder' ); ?>
                </td>
            </tr>
            <tr>
                <td class="fr-1">
					<?php esc_html_e( 'Help & Support', 'woo-product-finder' ); ?>
                </td>
                <td class="fr-2 wpfp-information">
                    <ul>
                        <li>
                            <a href="<?php echo esc_url( site_url( 'wp-admin/admin.php?page=wpfp-get-started' ) ); ?>" target="_blank">
								<?php esc_html_e( 'Quick Start', 'woo-product-finder' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( 'http://www.thedotstore.com/docs/plugin/woocommerce-product-finder/' ); ?>" target="_blank">
								<?php esc_html_e( 'Guide Documentation', 'woo-product-finder' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( "https://www.thedotstore.com/support/" ); ?>" target="_blank">
								<?php esc_html_e( 'Support Forum', 'woo-product-finder' ); ?>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="fr-1">
					<?php esc_html_e( 'Localization', 'woo-product-finder' ); ?>
                </td>
                <td class="fr-2">
					<?php esc_html_e( 'English', 'woo-product-finder' ); ?>,
					<?php esc_html_e( 'Spanish', 'woo-product-finder' ); ?>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
<?php
$file_dir_path = 'header/plugin-sidebar.php';
if ( file_exists( plugin_dir_path( __FILE__ ) . $file_dir_path ) ) {
	require_once plugin_dir_path( __FILE__ ) . $file_dir_path;
}