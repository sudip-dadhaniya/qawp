<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="dotstore_plugin_sidebar">
    <div class="dotstore-important-link">
        <h2>
            <span class="dotstore-important-link-title">
                <?php esc_html_e( 'Important link', 'woo-product-finder' ); ?>
            </span>
        </h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/check-mark.png' ); ?>" alt="<?php esc_attr_e( 'right click', 'woo-product-finder' ); ?>">
                    <a href="<?php echo esc_url( "http://www.thedotstore.com/docs/plugin/woocommerce-product-finder" ); ?>" target="_blank">
						<?php esc_html_e( 'Plugin documentation', 'woo-product-finder' ); ?>
                    </a>
                </li>
                <li>
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/check-mark.png' ); ?>" alt="<?php esc_attr_e( 'right click', 'woo-product-finder' ); ?>">
                    <a href="<?php echo esc_url( "https://www.thedotstore.com/support" ); ?>" target="_blank">
						<?php esc_html_e( 'Support platform', 'woo-product-finder' ); ?>
                    </a>
                </li>
                <li>
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/check-mark.png' ); ?>" alt="<?php esc_attr_e( 'right click', 'woo-product-finder' ); ?>">
                    <a href="<?php echo esc_url( "https://www.thedotstore.com/suggest-a-feature/" ); ?>" target="_blank">
						<?php esc_html_e( 'Suggest A Feature', 'woo-product-finder' ); ?>
                    </a>
                </li>
                <li>
                    <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/check-mark.png' ); ?>" alt="<?php esc_attr_e( 'right click', 'woo-product-finder' ); ?>">
                    <a href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-product-finder#tab-change-log" ); ?>" target="_blank">
						<?php esc_html_e( 'Changelog', 'woo-product-finder' ); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="dotstore-important-link">
        <h2>
            <span class="dotstore-important-link-title">
                <?php esc_html_e( 'Our Popular plugins', 'woo-product-finder' ); ?>
            </span>
        </h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Advanced-Flat-Rate-Shipping-Method.png' ); ?>" alt="<?php esc_attr_e( 'Advanced Flat Rate Shipping Method', 'woo-product-finder' ); ?>">
                    <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/advanced-flat-rate-shipping-method-for-woocommerce" ); ?>">
						<?php esc_html_e( 'Advanced Flat Rate Shipping Method', 'woo-product-finder' ); ?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Conditional-Product-Fees-For-WooCommerce-Checkout.png' ); ?>" alt="<?php esc_attr_e( 'Conditional Product Fees For WooCommerce Checkout', 'woo-product-finder' ); ?>">
                    <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-conditional-product-fees-checkout/" ); ?>">
						<?php esc_html_e( 'Conditional Product Fees For WooCommerce Checkout', 'woo-product-finder' ); ?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Advance-Menu-Manager-For-WordPress.png' ); ?>" alt="<?php esc_attr_e( 'Advance Menu Manager For WordPress', 'woo-product-finder' ); ?>">
                    <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/advance-menu-manager-wordpress/" ); ?>">
						<?php esc_html_e( 'Advance Menu Manager For WordPress', 'woo-product-finder' ); ?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Enhanced-Ecommerce-Google-Analytics-For-WooCommerce.png' ); ?>" alt="<?php esc_attr_e( 'Enhanced Ecommerce Google Analytics for WooCommerce', 'woo-product-finder' ); ?>">
                    <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-enhanced-ecommerce-analytics-integration-with-conversion-tracking" ); ?>">
						<?php esc_html_e( 'Enhanced Ecommerce Google Analytics for WooCommerce', 'woo-product-finder' ); ?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/WooCommerce-Blocker-Prevent-Fake-Orders.png' ); ?>" alt="<?php esc_attr_e( 'WooCommerce Blocker – Prevent Fake Orders', 'woo-product-finder' ); ?>">
                    <a target="_blank" href="<?php echo esc_url( "https://www.thedotstore.com/product/woocommerce-blocker-lite-prevent-fake-orders-blacklist-fraud-customers/" ); ?>">
						<?php esc_html_e( 'WooCommerce Blocker – Prevent Fake Orders', 'woo-product-finder' ); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="view-button">
            <a class="view_button_dotstore" href="<?php echo esc_url( "http://www.thedotstore.com/plugins/" ); ?>" target="_blank"><?php esc_html_e( 'View All', 'woo-product-finder' ); ?></a>
        </div>
    </div>
    <!-- html end for popular plugin !-->
</div>
</div>
</body>
</html>
