<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once(plugin_dir_path( __FILE__ ).'header/plugin-header.php');

$wcdg_get_tab = filter_input(INPUT_GET,'tab',FILTER_SANITIZE_STRING);
$wcdg_get_action = filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING);
?>
    <div class="wcdg-main-left-section res-cl">
        <div class="product_header_title">
            <h2><?php esc_html_e( 'Setting', WCDG_TEXT_DOMAIN ); ?></h2>
        </div>
        <?php
        if('products' === $wcdg_get_tab && 'insert' === $wcdg_get_action){
            if (isset($_POST['wcdg_submit_product'])) {
                // verify nonce
                if (isset($_POST['woo_checkout_digital_goods_product']) && !wp_verify_nonce(sanitize_text_field($_POST['woo_checkout_digital_goods_product'], basename(__FILE__)))) {
                    die('Failed security check');
                }else{

                    $product_data_post = $_POST;
                    if( isset($product_data_post['wcdg_chk_product']) ){
                        $wcdg_chk_product = $product_data_post['wcdg_chk_product'];
                        foreach($wcdg_chk_product as $product){
                            add_post_meta( $product, '_wcdg_chk_product', 'yes', true );
                        } ?>
                        <p class="wcdg_update"><?php esc_html_e('Product inserted Successfully!!', WCDG_TEXT_DOMAIN); ?></p>
                    <?php }else{ ?>
                        <p class="wcdg_error"><?php esc_html_e('Please select at least one product..!!', WCDG_TEXT_DOMAIN); ?></p>
                    <?php }
                }
            } ?>
            <div class="wcdg-data-container">
                <form method="post" action="" class="wrap wcdg_chk_form wcdg_product_form">
                    <?php wp_nonce_field('woo_checkout_digital_goods_product'); ?>
                    <label><?php esc_html_e('Select Digital Product', WCDG_TEXT_DOMAIN); ?></label>
                    <?php $security_nonce =  wp_create_nonce( 'woo_checkout_digital_goods_product' ); ?>
                    <select name="wcdg_chk_product[]" id="wcdg-chk-product-filter" data-allow_clear="true" data-placeholder="Type the product name" data-minimum_input_length="3" data-nonce="<?php echo esc_attr( $security_nonce ); ?>" multiple="multiple">
                    </select>
                    <div class="group-button">
                        <p class="submit"><input type="submit" name="wcdg_submit_product" class="button button-primary button-large" value="<?php esc_html_e('Add Product', WCDG_TEXT_DOMAIN); ?>"></p>
                        <a class="add-new-h2" href="<?php echo esc_url( site_url( '/wp-admin/admin.php?page=wcdg-quick-checkout&tab=products' ) ); ?>"><?php esc_html_e('Back', WCDG_TEXT_DOMAIN); ?></a>
                    </div>
                </form>
            </div>
            <?php
        }elseif('categories' === $wcdg_get_tab && 'insert' === $wcdg_get_action){
            if (isset($_POST['wcdg_submit_category'])) {
                // verify nonce
                if (isset($_POST['woo_checkout_digital_goods_category']) && !wp_verify_nonce(sanitize_text_field($_POST['woo_checkout_digital_goods_category'], basename(__FILE__)))) {
                    die('Failed security check');
                }else{
                    $category_data_post = $_POST;
                    if( isset($category_data_post['wcdg_chk_category']) ){
                        $wcdg_chk_category = $category_data_post['wcdg_chk_category'];
                        foreach($wcdg_chk_category as $category ){
                            add_term_meta( $category, "wcdg_chk_category" , 'yes' );
                        } ?>
                        <p class="wcdg_update"><?php esc_html_e('Category inserted Successfully!!', WCDG_TEXT_DOMAIN); ?></p>
                    <?php }else{ ?>
                        <p class="wcdg_error"><?php esc_html_e('Please select at least one category..!!', WCDG_TEXT_DOMAIN); ?></p>
                    <?php }
                }
            } ?>
            <div class="group-button">
                <form method="post" action="" class="wrap wcdg_chk_form wcdg_category_form">
                    <?php wp_nonce_field('woo_checkout_digital_goods_category'); ?>
                    <label><?php esc_html_e('Select Category', WCDG_TEXT_DOMAIN); ?></label>
                    <?php
                    $cat_args = array(
                    'orderby'    => 'name',
                    'order'      => 'asc',
                    'hide_empty' => false,
                    );
                    $get_all_categories = get_terms( 'product_cat', $cat_args ); ?>
                    <select id="wcdg-chk-category-filter" name="wcdg_chk_category[]" multiple="multiple" class="multiselect2">
                        <?php
                        if (isset($get_all_categories) && !empty($get_all_categories)) {
                            foreach ($get_all_categories as $get_all_category) {
                                $new_cat_id = $get_all_category->term_id;
                                $category = get_term_by('id', $new_cat_id, 'product_cat');
                                $parent_category = get_term_by('id', $category->parent, 'product_cat');

                                if ($category->parent > 0) {
                                    echo '<option value="' . esc_attr($category->term_id) . '">' . '#' . esc_html__($parent_category->name, WCDG_TEXT_DOMAIN) . '->' . esc_html__($category->name, WCDG_TEXT_DOMAIN) . '</option>';
                                } else {
                                    echo '<option value="' . esc_attr($category->term_id ). '">' . esc_html__($category->name, WCDG_TEXT_DOMAIN) . '</option>';
                                }
                            }
                        } ?>
                    </select>
                    <div class="group-button">
                        <p class="submit"><input type="submit" name="wcdg_submit_category" class="button button-primary button-large" value="<?php esc_html_e('Add Category', WCDG_TEXT_DOMAIN); ?>"></p>
                        <a class="add-new-h2" href="<?php echo esc_url( site_url( '/wp-admin/admin.php?page=wcdg-quick-checkout&tab=categories' ) ); ?>"><?php esc_html_e('Back', WCDG_TEXT_DOMAIN); ?></a>
                    </div>
                </form>
            </div>
            <?php
        }elseif('tags' === $wcdg_get_tab && 'insert' === $wcdg_get_action) {
            if (isset($_POST['wcdg_submit_tag'])) {
                // verify nonce
                if (isset($_POST['woo_checkout_digital_goods_tag']) && !wp_verify_nonce(sanitize_text_field($_POST['woo_checkout_digital_goods_tag'], basename(__FILE__)))) {
                    die('Failed security check');
                }else{
                    $tag_data_post = $_POST;
                    if( isset($tag_data_post['wcdg_chk_tag']) ){
                        $wcdg_chk_tag = $tag_data_post['wcdg_chk_tag'];
                        foreach($wcdg_chk_tag as $w_tag ){
                            add_term_meta( $w_tag, "wcdg_chk_tag" , 'yes' );
                        } ?>
                        <p class="wcdg_update"><?php esc_html_e('Tag inserted Successfully!!', WCDG_TEXT_DOMAIN); ?></p>
                    <?php }else{ ?>
                        <p class="wcdg_error"><?php esc_html_e('Please select at least one tag..!!', WCDG_TEXT_DOMAIN); ?></p>
                    <?php }
                }
            } ?>
            <div class="group-button">
                <form method="post" action="" class="wrap wcdg_chk_form wcdg_tag_form">
                    <?php wp_nonce_field('woo_checkout_digital_goods_tag'); ?>
                    <label><?php esc_html_e('Select Tag', WCDG_TEXT_DOMAIN); ?></label>
                    <?php
                    $tag_args = array(
                    'orderby'    => 'name',
                    'order'      => 'asc',
                    'hide_empty' => false,
                    );
                    $get_all_tags = get_terms( 'product_tag', $tag_args ); ?>
                    <select id="wcdg-chk-tag-filter" name="wcdg_chk_tag[]" multiple="multiple" class="multiselect2">
                    <?php
                    if (isset($get_all_tags) && !empty($get_all_tags)) {
                        foreach ($get_all_tags as $c_tag) {
                            $new_tag_id = $c_tag->term_id;
                            $tag_data = get_term_by('id', $new_tag_id, 'product_tag');
                            echo '<option value="' . esc_attr($tag_data->term_id) . '">' . esc_html__($tag_data->name, WCDG_TEXT_DOMAIN) . '</option>';
                        }
                    }?>
                    </select>
                    <div class="group-button">
                        <p class="submit"><input type="submit" name="wcdg_submit_tag" class="button button-primary button-large" value="<?php esc_html_e('Add Tag', WCDG_TEXT_DOMAIN); ?>"></p>
                        <a class="add-new-h2" href="<?php echo esc_url( site_url( '/wp-admin/admin.php?page=wcdg-quick-checkout&tab=tags' ) ); ?>"><?php esc_html_e('Back', WCDG_TEXT_DOMAIN); ?></a>
                    </div>
                </form>
            </div>
            <?php
        }else{
            $tab_type  = filter_input(INPUT_GET,'tab',FILTER_SANITIZE_STRING);
            $product_type = isset($tab_type) && 'products' === $tab_type ? 'active' : '';
            $cat_type = isset($tab_type) && 'categories' === $tab_type ? 'active' : '';
            $tag_type = isset($tab_type) && 'tags' === $tab_type ? 'active' : '';
            ?>
            <div class="wcdg-data-container">
                <ul class="wcdg-tab">
                    <li><a class="pvcp-action-link <?php echo esc_attr($product_type); ?>" href="<?php echo esc_url( site_url( '/wp-admin/admin.php?page=wcdg-quick-checkout&tab=products' ) ); ?>"><?php esc_html_e('Products', WCDG_TEXT_DOMAIN); ?></a></li>
                    <li><a class="pvcp-action-link <?php echo esc_attr($cat_type); ?>" href="<?php echo esc_url( site_url( '/wp-admin/admin.php?page=wcdg-quick-checkout&tab=categories' ) ); ?>"><?php esc_html_e('Categories', WCDG_TEXT_DOMAIN); ?></a></li>
                    <li><a class="pvcp-action-link <?php echo esc_attr($tag_type); ?>" href="<?php echo esc_url( site_url( '/wp-admin/admin.php?page=wcdg-quick-checkout&tab=tags' ) ); ?>"><?php esc_html_e('Tags', WCDG_TEXT_DOMAIN); ?></a></li>
                </ul>
                <?php if( empty( $wcdg_get_tab ) || 'products' === $wcdg_get_tab ){ ?>
                    <div class="wrap">
                        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                        <h2><?php esc_html_e('Digital Products List', WCDG_TEXT_DOMAIN)?>
                            <a class="add-new-h2" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=wcdg-quick-checkout&tab=products&action=insert'));?>"><?php esc_html_e('Add new', WCDG_TEXT_DOMAIN)?></a>
                            <a id="wcdg_detete_all_selected_product" class="wcdg_detete_all_selected button-primary" href="javascript:void(0);" disabled="disabled"><?php esc_html_e('Delete ( Selected )', WCDG_TEXT_DOMAIN)?></a>
                        </h2>
                        <table id="wcdg-product-listing" class="wcdg-data-table table-outer form-table all-table-listing">
                            <thead>
                            <tr class="pvcp-head">
                                <th><input type="checkbox" name="wcdg_check_all_product" class="wcdg_chk_all" id="wcdg_chk_all_product"></th>
                                <th><?php esc_html_e( 'Product', WCDG_TEXT_DOMAIN ); ?></th>
                                <th><?php esc_html_e( 'Action', WCDG_TEXT_DOMAIN ); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $product_args = array(
                                'post_type' => 'product',
                                'orderby' => 'title',
                                'order' => 'ASC',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'key' => '_wcdg_chk_product',
                                        'value' => 'yes',
                                        'compare' => '='
                                    )
                                )
                            );
                            $query = new WP_Query($product_args);
                            $get_all_products = $query->posts;
                            if($get_all_products){
                                foreach ($get_all_products as $get_product) { ?>
                                    <tr id="product_<?php echo esc_attr( $get_product->ID ); ?>">
                                        <td><input type="checkbox" class="wcdg_chk_single" name="wcdg_single_item" value="<?php echo esc_attr( $get_product->ID ); ?>"></td>
                                        <td><?php esc_html_e( $get_product->post_title, WCDG_TEXT_DOMAIN ); ?></td>
                                        <td>
                                            <a class="wcdg-action-button button-primary" target="_blank" href="<?php echo esc_url( get_edit_post_link($get_product->ID)); ?>"><?php esc_html_e( 'Edit', WCDG_TEXT_DOMAIN ); ?></a>
                                            <a class="wcdg-action-button button-primary delete_single_selected_product" href="javascript:void(0);" id="delete_single_selected_product_<?php echo esc_attr( $get_product->ID ); ?>"><?php esc_html_e( 'Delete', WCDG_TEXT_DOMAIN ); ?></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>

                    </div>
                <?php }elseif('categories' === $wcdg_get_tab){ ?>
                    <div class="wrap">
                        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                        <h2><?php esc_html_e('Categories List', WCDG_TEXT_DOMAIN)?>
                            <a class="add-new-h2" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=wcdg-quick-checkout&tab=categories&action=insert'));?>"><?php esc_html_e('Add new', WCDG_TEXT_DOMAIN)?></a>
                            <a id="wcdg_detete_all_selected_cat" class="wcdg_detete_all_selected button-primary" href="javascript:void(0);" disabled="disabled"><?php esc_html_e('Delete ( Selected )', WCDG_TEXT_DOMAIN)?></a>
                        </h2>

                        <table id="wcdg-categories-listing" class="wcdg-data-table table-outer form-table all-table-listing">
                            <thead>
                            <tr class="pvcp-head">
                                <th><input type="checkbox" name="wcdg_check_all_cat" class="wcdg_chk_all" id="wcdg_chk_all_cat"></th>
                                <th><?php esc_html_e( 'Category', WCDG_TEXT_DOMAIN ); ?></th>
                                <th><?php esc_html_e( 'Action', WCDG_TEXT_DOMAIN ); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $args = array(
                                'hide_empty' => false, // also retrieve terms which are not used yet
                                'meta_query' => array(
                                    array(
                                        'key'       => 'wcdg_chk_category',
                                        'value'     => 'yes',
                                        'compare'   => '='
                                    )
                                ),
                                'taxonomy'  => 'product_cat',
                            );
                            $terms = get_terms( $args );
                            if($terms){
                                foreach ($terms as $w_term) { ?>
                                    <tr id="cat_<?php echo esc_attr( $w_term->term_id ); ?>">
                                        <td><input type="checkbox" name="wcdg_single_item" class="wcdg_chk_single" value="<?php echo esc_attr( $w_term->term_id ); ?>"></td>
                                        <td><?php esc_html_e( $w_term->name, WCDG_TEXT_DOMAIN ); ?></td>
                                        <td>
                                            <a class="wcdg-action-button button-primary" target="_blank" href="<?php echo esc_url( admin_url('/term.php?taxonomy=product_cat&tag_ID='.$w_term->term_id.'&post_type=product') ); ?>"><?php esc_html_e( 'Edit', WCDG_TEXT_DOMAIN ); ?></a>
                                            <a class="wcdg-action-button button-primary delete_single_selected_cat" href="javascript:void(0);" id="delete_single_selected_cat_<?php echo esc_attr( $w_term->term_id ); ?>"><?php esc_html_e( 'Delete', WCDG_TEXT_DOMAIN ); ?></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php }elseif('tags' === $wcdg_get_tab){ ?>
                    <div class="wrap">
                        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                        <h2><?php esc_html_e('Tags List', WCDG_TEXT_DOMAIN)?>
                            <a class="add-new-h2" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=wcdg-quick-checkout&tab=tags&action=insert'));?>"><?php esc_html_e('Add new', WCDG_TEXT_DOMAIN)?></a>
                            <a id="wcdg_detete_all_selected_tag" class="wcdg_detete_all_selected button-primary" href="javascript:void(0);" disabled="disabled"><?php esc_html_e('Delete ( Selected )', WCDG_TEXT_DOMAIN)?></a>
                        </h2>

                        <table id="wcdg-tag-listing" class="wcdg-data-table table-outer form-table all-table-listing">
                            <thead>
                            <tr class="pvcp-head">
                                <th><input type="checkbox" name="wcdg_check_all_tag" class="wcdg_chk_all" id="wcdg_chk_all_tag"></th>
                                <th><?php esc_html_e( 'Tag', WCDG_TEXT_DOMAIN ); ?></th>
                                <th><?php esc_html_e( 'Action', WCDG_TEXT_DOMAIN ); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $args = array(
                                'hide_empty' => false, // also retrieve terms which are not used yet
                                'meta_query' => array(
                                    array(
                                        'key'       => 'wcdg_chk_tag',
                                        'value'     => 'yes',
                                        'compare'   => '='
                                    )
                                ),
                                'taxonomy'  => 'product_tag',
                            );
                            $tags = get_terms( $args );
                            if($tags){
                                foreach ($tags as $w_tag) { ?>
                                    <tr id="tag_<?php echo esc_attr( $w_tag->term_id ); ?>">
                                        <td><input type="checkbox" name="wcdg_single_item" class="wcdg_chk_single" value="<?php echo esc_attr( $w_tag->term_id ); ?>"></td>
                                        <td><?php esc_html_e( $w_tag->name, WCDG_TEXT_DOMAIN ); ?></td>
                                        <td>
                                            <a class="wcdg-action-button button-primary" target="_blank" href="<?php echo esc_url( admin_url('/term.php?taxonomy=product_tag&tag_ID='.$w_tag->term_id.'&post_type=product') ); ?>"><?php esc_html_e( 'Edit', WCDG_TEXT_DOMAIN ); ?></a>
                                            <a class="wcdg-action-button button-primary delete_single_selected_tag" href="javascript:void(0);" id="delete_single_selected_tag_<?php echo esc_attr( $w_tag->term_id ); ?>"><?php esc_html_e( 'Delete', WCDG_TEXT_DOMAIN ); ?></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
        ?>
    </div>


<?php require_once(plugin_dir_path( __FILE__ ).'header/plugin-sidebar.php'); ?>