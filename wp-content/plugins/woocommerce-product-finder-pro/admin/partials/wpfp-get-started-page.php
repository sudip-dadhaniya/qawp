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
			<?php esc_html_e( 'Thanks For Installing WooCommerce Product Finder Pro', 'woo-product-finder' ); ?>
        </h2>
        <table class="table-outer">
            <tbody>
            <tr>
                <td class="fr-2">
                    <p class="block gettingstarted">
                        <strong>
							<?php esc_html_e( 'Getting Started', 'woo-product-finder' ); ?>
                        </strong>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'WooCommerce Product Finder Pro let customers narrow down the product list on the basis of their choices. It enables the store owners to add a questionnaire to the product page. The product recommendations are then rendered according to the answers, given by the users. You can showcase ‘n’ number of products, matching the answers and query.', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
                        <strong><?php esc_html_e( 'Step 1', 'woo-product-finder' ); ?>:</strong>
						<?php esc_html_e( 'Create Wizard ( Questions and answers )', 'woo-product-finder' ); ?>
                    <p class="block textgetting">
						<?php esc_html_e( 'Before add wizard you will have to create attribute and select these attribute in particular product.', 'woo-product-finder' ); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/add_attribute_in_product.png' ); ?>" alt="<?php esc_attr_e( 'attribute add in product', 'woo-product-finder' ); ?>">
                        </span>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'Enter Wizard title, select category and enable status. (If you want to search product based on catgeory that you will have to select category.)', 'woo-product-finder' ); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/Getting_Started_01.png' ); ?>" alt="<?php esc_attr_e( 'Wizard listing', 'woo-product-finder' ); ?>">
                        </span>
                    </p>
                    <p class="block gettingstarted textgetting">
                        <strong><?php esc_html_e( 'Step 2', 'woo-product-finder' ); ?>:</strong>
						<?php esc_html_e( 'Manage Question: Add New Question', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'Create question option like a radio button or Multi-select check box.', 'woo-product-finder' ); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/Getting_Started_02.png' ); ?>" alt="<?php esc_attr_e( 'Edit Wizard page', 'woo-product-finder' ); ?>">
                        </span>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'Provide Corresponding answers ( options ), upload pictures, select Attributes name and attribute values.', 'woo-product-finder' ); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/Getting_Started_03.png' ); ?>" alt="<?php esc_attr_e( 'Wizard Question page', 'woo-product-finder' ); ?>">
                        </span>
                    </p>
                    <p class="block gettingstarted textgetting">
                        <strong><?php esc_html_e( 'Step 3', 'woo-product-finder' ); ?>:</strong>
						<?php esc_html_e( 'Wizard Setting', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'With this Wizard Setting, you can change the defaule setting as per below:', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'Change matched product and recently matched product title.( on Recommendation Wizard page ).', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'How many products displays per page.( on Recommendation Wizard page ).', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'How many attribute show per Product in product recommendation Wizard page.', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'Upload background image, Change background color and also change text color.( on Recommendation Wizard page ).', 'woo-product-finder' ); ?>
                    </p>
                    <span class="gettingstarted">
                        <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/wizard_setting.png' ); ?>" alt="<?php esc_attr_e( 'Wizard setting', 'woo-product-finder' ); ?>">
                    </span>
                    <p class="block gettingstarted textgetting">
                        <strong><?php esc_html_e( 'Step 4', 'woo-product-finder' ); ?>:</strong>
						<?php esc_html_e( 'Copy and past Wizard shortcode in page/ post and publish Product Recommendation Wizard', 'woo-product-finder' ); ?>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'All you need to do is to copy & paste Wizard shortcode page or post.', 'woo-product-finder' ); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/edit_page.png' ); ?>" alt="<?php esc_attr_e( 'edit page', 'woo-product-finder' ); ?>">
                        </span>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'Front side you want to display as per screenshot', 'woo-product-finder' ); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/Getting_Started_05.png' ); ?>" alt="<?php esc_attr_e( 'output page', 'woo-product-finder' ); ?>">
                        </span>
                    </p>
                    <p class="block textgetting">
						<?php esc_html_e( 'Product result display as per below screenshot', 'woo-product-finder' ); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'admin/images/thedotstore-images/screenshots/Getting_Started_06.png' ); ?>" alt="<?php esc_attr_e( 'result page', 'woo-product-finder' ); ?>">
                        </span>
                    </p>
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