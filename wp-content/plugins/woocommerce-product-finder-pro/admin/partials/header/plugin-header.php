<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugin_mode                      = __( 'Free Version ', 'woo-product-finder' );
$plugin_header_button_image_alt   = __( 'Upgrade to pro plugin', 'woo-product-finder' );
$plugin_header_button_image_url   = plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/upgrade.png';
$plugin_header_button_account_url = wpfp_fs()->get_upgrade_url();
if ( wpfp_fs()->is__premium_only() ) {
	if ( wpfp_fs()->can_use_premium_code() ) {
		$plugin_mode                      = __( 'Premium Version ', 'woo-product-finder' );
		$plugin_header_button_image_alt   = __( 'My Account', 'woo-product-finder' );
		$plugin_header_button_image_url   = plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/account.png';
		$plugin_header_button_account_url = wpfp_fs()->get_account_url();
	}
}
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-logo-main">
                <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/wc_product_finder.png' ); ?>" alt="<?php esc_attr_e( 'Wizard logo', 'woo-product-finder' ); ?>">
            </div>
            <div class="dots-header-right">
                <div class="logo-detail">
                    <strong><?php echo esc_html( $this->get_plugin_name() ); ?></strong>
                    <span><?php echo esc_html( $plugin_mode ); ?><?php echo esc_html( $this->get_plugin_version() ); ?></span>
                </div>
                <div class="button-group">
                    <div class="button-dots">
                        <span class="support_dotstore_image">
                        <a target="_blank" href="<?php echo esc_url( $plugin_header_button_account_url ); ?>">
                            <img src="<?php echo esc_url( $plugin_header_button_image_url ); ?>" alt="<?php echo esc_attr( $plugin_header_button_image_alt ); ?>">
                        </a>
                        </span>
                        <span class="support_dotstore_image">
                            <a target="_blank" href="<?php echo esc_url( 'http://www.thedotstore.com/support/' ); ?>">
                                <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/support.png' ); ?>" alt="<?php esc_attr_e( 'support now', 'woo-product-finder' ); ?>">
                            </a>
                        </span>
                    </div>
                </div>
            </div>

			<?php
			$wpfp_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
			$this->wpfp_menus( $wpfp_page );
			?>
        </header>