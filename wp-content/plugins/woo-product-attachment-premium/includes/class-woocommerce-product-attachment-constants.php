<?php

/**
 * define constant variabes
 * define admin side constant
 * @since 1.0.0
 * @author Multidots
 * @param null
 */
/**
 * define constant for plugin name, slug, title and etc...
 *
 */
if ( wpap_fs()->is__premium_only() ) {
    if ( wpap_fs()->can_use_premium_code() ) {
		define('WCPOA_PLUGIN_NAME', 'WooCommerce Product Attachment Pro');
	}else{
		define('WCPOA_PLUGIN_NAME', 'WooCommerce Product Attachment');	
	}
}else{
	define('WCPOA_PLUGIN_NAME', 'WooCommerce Product Attachment');	
}
define('WCPOA_PLUGIN_TEXT_DOMAIN', 'woocommerce-product-attachment');
define('WCPOA_PLUGIN_SLUG', 'woocommerce_product_attachment');

