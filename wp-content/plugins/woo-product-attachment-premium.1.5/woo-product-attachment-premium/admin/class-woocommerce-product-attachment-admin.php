<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class Woocommerce_Product_Attachment_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Product_Attachment_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Product_Attachment_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $current_screen = get_current_screen();
        $post_type = $current_screen->post_type;
        $menu_page=filter_input(INPUT_GET,'page',FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($menu_page) && !empty($menu_page) && ($menu_page === "woocommerce_product_attachment" || $menu_page === "wcpoa_bulk_attachment") || !empty($post_type) && ($post_type === 'product')) {
            wp_enqueue_style('thickbox');
            wp_enqueue_style($this->plugin_name . '-wcpoa-main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-product-attachment-admin.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-wcpoa-main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-jquery-ui', plugin_dir_url(__FILE__) . 'css/jquery-ui.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-main-jquery-ui', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-select2.min', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woocommerce_Product_Attachment_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woocommerce_Product_Attachment_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $current_screen = get_current_screen();
        $post_type = $current_screen->post_type;
        $menu_page=filter_input(INPUT_GET,'page',FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($menu_page) && !empty($menu_page) && ($menu_page === "woocommerce_product_attachment" || $menu_page === "wcpoa_bulk_attachment") || !empty($post_type) && ($post_type === 'product')) {
            wp_enqueue_script('postbox');
            wp_enqueue_script('jquery');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_media();
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-product-attachment-admin.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . '-select2_js', plugin_dir_url(__FILE__) . 'js/select2.full.min.js?ver=4.0.3', array('jquery'), '4.0.3', false);
            wp_enqueue_script($this->plugin_name . '-pro', plugin_dir_url(__FILE__) . 'js/pro-wcpoa-input.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . '-datepicker', plugin_dir_url(__FILE__) . 'js/datepicker.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . '-validation', plugin_dir_url(__FILE__) . 'js/jquery.validation.js', array('jquery'), $this->version, false);
        }
        if (isset($menu_page) && !empty($menu_page) && ($menu_page === "wcpoa_bulk_attachment")) {
            wp_dequeue_script('wp-auth-check');
        }
    }

    public function welcome_wcpoa_plugin_screen_do_activation_redirect()
    {
        // if no activation redirect
        if (!get_transient('_welcome_screen_activation_redirect_data')) {
            return;
        }

        // Delete the redirect transient
        delete_transient('_welcome_screen_activation_redirect_data');

        // if activating from network, or bulk
        $activate_multi=filter_input(INPUT_GET,'activate-multi',FILTER_SANITIZE_SPECIAL_CHARS);
        if (is_network_admin() || isset($activate_multi)) {
            return;
        }
        // Redirect to extra cost welcome  page

        wp_safe_redirect(add_query_arg(array('page' => 'woocommerce_product_attachment&tab=wcpoa-plugin-getting-started'), admin_url('admin.php')));
        exit;
    }

    /**
     *
     * dotsstore menu add
     */
    public function dot_store_menu()
    {
        global $GLOBALS;
        if (empty($GLOBALS['admin_page_hooks']['dots_store'])) {
            add_menu_page(
                'DotStore Plugins', 'DotStore Plugins', 'null', 'dots_store', array($this, 'dot_store_menu_page'), plugin_dir_url(__FILE__) . 'images/menu-icon.png', 25
            );
        }
    }

    /**
     *
     * WooCommerce Product Attachment menu add
     */
    public function wcpoa_plugin_menu()
    {
        add_submenu_page("dots_store", "WooCommerce Product Attachment", "WooCommerce Product Attachment", "manage_options", "woocommerce_product_attachment", array($this, "wcpoa_options_page"));
        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                add_submenu_page("dots_store", 'WooCommerce Product Bulk Attachment', 'WooCommerce Product Bulk Attachment', 'edit_posts', 'wcpoa_bulk_attachment', array($this, "wcpoa_bulk_attachment__premium_only"));
            }
        }
    }

    /*
     * Active Menu
     */

    public function wcpoa_free_active_menu()
    {
        $screen = get_current_screen();
        //DotStore Menu Submenu based conditions
        if (!empty($screen) && ($screen->id === '' || $screen->id === 'dotstore-plugins_page_wcpoa_bulk_attachment')) {
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $('a[href="admin.php?page=woocommerce_product_attachment"]').parent().addClass('current');
                    $('a[href="admin.php?page=woocommerce_product_attachment"]').addClass('current');
                });
            </script>
            <?php
        }
    }

    /*
     * Remove Menu.
     */

    public function wcpoa_remove_admin_menus__premium_only()
    {
        remove_submenu_page('dots_store', 'wcpoa_bulk_attachment');
    }

    /**
     * WooCommerce Product Attachment Option Page HTML
     *
     */
    public function wcpoa_options_page()
    {

        require_once(plugin_dir_path( __FILE__ ).'partials/header/plugin-header.php');
        $menu_tab=filter_input(INPUT_GET,'tab',FILTER_SANITIZE_SPECIAL_CHARS);
        $wcpoa_attachment_tab = isset($menu_tab) && !empty($menu_tab) ? $menu_tab : '';

        if (!empty($wcpoa_attachment_tab)) {

            if ($wcpoa_attachment_tab === "wcpoa_plugin_setting_page") {
                self::wcpoa_setting_page();
            }
            if ($wcpoa_attachment_tab === "wcpoa-plugin-getting-started") {
                self::wcpoa_plugin_get_started();
            }
            if ($wcpoa_attachment_tab === "wcpoa-plugin-quick-info") {
                self::wcpoa_plugin_quick_info();
            }
        } else {
            self::wcpoa_setting_page();
        }
        require_once(plugin_dir_path( __FILE__ ).'partials/header/plugin-sidebar.php');
    }

    public function wcpoa_setting_page()
    {
        $plugin_txt_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        $wcpoa_product_tab_name = filter_input( INPUT_POST, 'wcpoa_product_tab_name', FILTER_SANITIZE_STRING );
        $wcpoa_order_tab_name = filter_input( INPUT_POST, 'wcpoa_order_tab_name', FILTER_SANITIZE_STRING );
        $wcpoa_expired_date_label = filter_input( INPUT_POST, 'wcpoa_expired_date_label', FILTER_SANITIZE_STRING );

        $wcpoa_product_tab = isset($wcpoa_product_tab_name) && !empty($wcpoa_product_tab_name) ? $wcpoa_product_tab_name : 'WooCommerce Product Attachment';
        $wcpoa_order_tab = isset($wcpoa_order_tab_name) && !empty($wcpoa_order_tab_name) ? $wcpoa_order_tab_name : 'WooCommerce Product Attachment';
        $wcpoa_expired_date_label = isset($wcpoa_expired_date_label) && !empty($wcpoa_expired_date_label) ? $wcpoa_expired_date_label : '';


        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                $wcpoa_attachments_action_on_click=filter_input(INPUT_POST,'wcpoa_attachments_action_on_click',FILTER_SANITIZE_SPECIAL_CHARS);
                $wcpoa_att_download_btn = filter_input( INPUT_POST, 'wcpoa_att_download_btn', FILTER_SANITIZE_STRING );
                $wcpoa_att_download_label = filter_input( INPUT_POST, 'wcpoa_att_download_label', FILTER_SANITIZE_STRING );
                $wcpoa_att_in_my_acc = filter_input( INPUT_POST, 'wcpoa_att_in_my_acc', FILTER_SANITIZE_STRING );
                $wcpoa_att_download_restrict = filter_input( INPUT_POST, 'wcpoa_att_download_restrict', FILTER_SANITIZE_STRING,FILTER_REQUIRE_ARRAY );
         
                $wcpoa_att_download_btn_val = isset($wcpoa_att_download_btn) && !empty($wcpoa_att_download_btn) ? $wcpoa_att_download_btn : '';
         
                $wcpoa_att_in_my_acc_val = isset($wcpoa_att_in_my_acc) && !empty($wcpoa_att_in_my_acc) ? $wcpoa_att_in_my_acc : '';
         
                $wcpoa_att_download_restrict_val = isset($wcpoa_att_download_restrict) && !empty($wcpoa_att_download_restrict) ? ($wcpoa_att_download_restrict) : '';
         
                $wcpoa_att_download_label = isset($wcpoa_att_download_label) && !empty($wcpoa_att_download_label) ? ($wcpoa_att_download_label) : '';
                if(isset($_FILES['wcpoa_att_icon_file']) && !empty($_FILES['wcpoa_att_icon_file']['name'])){ //phpcs:ignore

                  $errors= array();
                  $wcpoa_att_icon_file_name = $_FILES['wcpoa_att_icon_file']['name']; //phpcs:ignore
                  $wcpoa_att_icon_file_size = $_FILES['wcpoa_att_icon_file']['size']; //phpcs:ignore
                  $wcpoa_att_icon_file_tmp = $_FILES['wcpoa_att_icon_file']['tmp_name']; //phpcs:ignore
                  $wcpoa_att_icon_upload = wp_upload_dir();
                  $wcpoa_att_icon_upload_dir = $wcpoa_att_icon_upload['basedir'];
                    
                  $wcpoa_att_icon_upload_dir = $wcpoa_att_icon_upload_dir . '/woocommerce_product_attachment';

                    if (! is_dir($wcpoa_att_icon_upload_dir)) {
                       mkdir( $wcpoa_att_icon_upload_dir, 0700 ); //phpcs:ignore
                    }

                  $wcpoa_att_icon_exp_tmp = explode('.', $_FILES['wcpoa_att_icon_file']['name']); //phpcs:ignore
                  $wcpoa_att_fileExtension = end($wcpoa_att_icon_exp_tmp);


                  $wcpoa_att_icon_file_ext=strtolower($wcpoa_att_fileExtension);
                  
                  $wcpoa_att_icon_ext= array("jpeg","jpg","png");
                  
                  if(in_array($wcpoa_att_icon_file_ext,$wcpoa_att_icon_ext,true)=== false){ ?>
                    <p class="error"><?php esc_html_e('Extension not allowed, please choose a JPEG or PNG file.',$plugin_txt_domain); ?></p>
                  <?php   
                     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                  }
                  
                  if($wcpoa_att_icon_file_size > 2097152) { ?>
                    <p class="error"><?php esc_html_e('File size must be excately 2 MB',$plugin_txt_domain); ?></p>
                  <?php   
                     $errors[]="File size must be excately 2 MB";
                  }
                  $wcpoa_att_icon_upload_url_ex = $wcpoa_att_icon_upload_dir."/".$wcpoa_att_icon_file_name;

                  if(empty($errors)===true) {
                     move_uploaded_file($wcpoa_att_icon_file_tmp,$wcpoa_att_icon_upload_url_ex);
                  }
                  $wcpoa_att_icon_upload_dir_opt = $wcpoa_att_icon_upload['baseurl'];
                  $wcpoa_att_icon_upload_url = $wcpoa_att_icon_upload_dir_opt. '/woocommerce_product_attachment/'.$wcpoa_att_icon_file_name;
                  update_option('wcpoa_att_icon_upload_url', $wcpoa_att_icon_upload_url);
               }else{
                    $wcpoa_att_icon_upload_url = "";
               }

               $wcpoa_attachments_show_in_email=filter_input(INPUT_POST,'wcpoa_attachments_show_in_email',FILTER_SANITIZE_SPECIAL_CHARS);

                $wcpoa_attachments_show_in_email = isset($wcpoa_attachments_show_in_email) && !empty($wcpoa_attachments_show_in_email) ? $wcpoa_attachments_show_in_email : '';
            }else{
                $get_wcpoa_is_viewable = filter_input(INPUT_POST, 'wcpoa_is_viewable', FILTER_SANITIZE_STRING);
                $wcpoa_is_viewable = isset( $get_wcpoa_is_viewable ) && ! empty( $get_wcpoa_is_viewable ) ? sanitize_text_field( wp_unslash( $get_wcpoa_is_viewable ) ) : '';
            }
        }else{
            $get_wcpoa_is_viewable = filter_input(INPUT_POST, 'wcpoa_is_viewable', FILTER_SANITIZE_STRING);
            $wcpoa_is_viewable = isset( $get_wcpoa_is_viewable ) && ! empty( $get_wcpoa_is_viewable ) ? sanitize_text_field( wp_unslash( $get_wcpoa_is_viewable ) ) : '';
        }
        //save on database two tab value
        $menu_page=filter_input(INPUT_GET,'page',FILTER_SANITIZE_SPECIAL_CHARS);
        $attachment_submit=filter_input(INPUT_POST,'submit',FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($attachment_submit) && isset($menu_page) && $menu_page === 'woocommerce_product_attachment') {
            update_option('wcpoa_product_tab_name', $wcpoa_product_tab);
            update_option('wcpoa_order_tab_name', $wcpoa_order_tab);
            update_option('wcpoa_expired_date_label', $wcpoa_expired_date_label);
            if ( wpap_fs()->is__premium_only() ) {
                if ( wpap_fs()->can_use_premium_code() ) {
                    update_option('wcpoa_attachments_action_on_click', $wcpoa_attachments_action_on_click);
                    update_option('wcpoa_att_download_btn', $wcpoa_att_download_btn_val);
                    update_option('wcpoa_att_in_my_acc', $wcpoa_att_in_my_acc_val);
                    update_option('wcpoa_att_download_restrict', $wcpoa_att_download_restrict_val);
                    update_option('wcpoa_att_download_label', $wcpoa_att_download_label);
                    update_option('wcpoa_attachments_show_in_email', $wcpoa_attachments_show_in_email);
                }else{
                    update_option( 'wcpoa_is_viewable', $wcpoa_is_viewable );
                }
            }else{
                update_option( 'wcpoa_is_viewable', $wcpoa_is_viewable );
            }
        }
        //store value in variable
        $wcpoa_product_tname = get_option('wcpoa_product_tab_name');
        $wcpoa_order_tname = get_option('wcpoa_order_tab_name');
        $wcpoa_expired_date_tlabel = get_option('wcpoa_expired_date_label');
        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                $wcpoa_attachments_action_on_click=get_option('wcpoa_attachments_action_on_click');
                $wcpoa_att_download_btn = get_option('wcpoa_att_download_btn');
                $wcpoa_att_in_my_acc = get_option('wcpoa_att_in_my_acc');
                $wcpoa_att_download_restrict = get_option('wcpoa_att_download_restrict');
                $wcpoa_att_download_label = get_option('wcpoa_att_download_label');
                $wcpoa_att_icon_upload_url = get_option('wcpoa_att_icon_upload_url');
                $wcpoa_attachments_show_in_email = get_option('wcpoa_attachments_show_in_email');
            }else{
                $wcpoa_is_viewable = get_option( 'wcpoa_is_viewable' );
            }
        }else{
            $wcpoa_is_viewable = get_option( 'wcpoa_is_viewable' );
        }
        
        ?>
        <div class="wcpoa-table-main">
            <form method="post" action="#"  enctype="multipart/form-data">
                <table class="wcpoa-tableouter">
                    <tbody>
                    <tr>
                        <th>
                            <span class="wcpoa-name"><?php esc_html_e('Product Details Page Tab Title',$plugin_txt_domain) ?></span>
                        </th>
                        <td class="">
                            <div class="wcpoa-name-txtbox">
                                <input type="text" name="wcpoa_product_tab_name"
                                       value="<?php echo esc_attr($wcpoa_product_tname); ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <span class="wcpoa-name"><?php esc_html_e('Order Details Page Tab Title',$plugin_txt_domain) ?></span>
                        </th>
                        <td class="">
                            <div class="wcpoa-name-txtbox">
                                <input type="text" name="wcpoa_order_tab_name"
                                       value="<?php echo esc_attr($wcpoa_order_tname) ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <span class="wcpoa-name"><?php esc_html_e('Attachements Date Label Show', $plugin_txt_domain) ?></span>
                        </th>
                        <td class="">
                            <div class="wcpoa-name-txtbox">
                                <select name="wcpoa_expired_date_label" class="wcpoa_expired_date_label"
                                        data-type="" data-key="">
                                    <option name="yes"
                                            value="yes" <?php echo ($wcpoa_expired_date_tlabel === "yes") ? 'selected' : ''; ?>><?php esc_html_e('Yes', $plugin_txt_domain) ?></option>
                                    <option name="no" value="no"
                                            class="" <?php echo ($wcpoa_expired_date_tlabel === "no") ? 'selected' : ''; ?>><?php esc_html_e('No', $plugin_txt_domain) ?></option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <?php
                    if ( wpap_fs()->is__premium_only() ) {
                        if ( wpap_fs()->can_use_premium_code() ) { ?>
                            <tr>
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e('Show Attachements Icon/Download Button', $plugin_txt_domain) ?></span>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-txtbox">

                                            <input type="radio" name="wcpoa_att_download_btn" class="wcpoa_att_download_btn"
                                                    value="wcpoa_att_icon" <?php echo ($wcpoa_att_download_btn === "wcpoa_att_icon") ? 'checked' : ''; ?>><?php esc_html_e('Upload Icon', $plugin_txt_domain) ?>
                                            <input type="radio" name="wcpoa_att_download_btn" class="wcpoa_att_download_btn" value="wcpoa_att_btn" <?php echo ($wcpoa_att_download_btn === "wcpoa_att_btn") ? 'checked' : ''; ?>><?php esc_html_e('Default Button', $plugin_txt_domain) ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="wcpoa_att_icon_file_selected <?php echo ($wcpoa_att_download_btn==='wcpoa_att_btn')?'hide':'' ?>">
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e('Upload Attachment Icon', $plugin_txt_domain) ?></span>
                                    <p class="description"><?php esc_html_e('Attach Icon else set it default icon', $plugin_txt_domain) ?></p>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-txtbox">
                                        <?php if($wcpoa_att_icon_upload_url){ ?>
                                        <img src="<?php echo esc_url($wcpoa_att_icon_upload_url); ?>" width="75" height="75"></br>
                                        <?php } ?>
                                        <input type="file" name="wcpoa_att_icon_file" id="wcpoa_att_icon_file" value="">
                                    </div>
                                </td>
                            </tr>
                            <tr class="wcpoa_att_download_label_selected" style="display:none;">
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e('Download Button Label', $plugin_txt_domain) ?></span>
                                    <p class="description">Enter Download button label otherwise set it default label</p>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-txtbox">
                                        <input type="text" name="wcpoa_att_download_label" value="<?php echo esc_attr($wcpoa_att_download_label) ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e('Show Attachements in My Account', $plugin_txt_domain) ?></span>
                                    <p class="description">Disable will hide all attachments on thankyou and My account page, it will only visible on product detail page.</p>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-txtbox">
                                        <select name="wcpoa_att_in_my_acc" class="wcpoa_att_in_my_acc"
                                                data-type="" data-key="">
                                            <option name="wcpoa_att_in_my_acc_enable"
                                                    value="wcpoa_att_in_my_acc_enable" <?php echo ($wcpoa_att_in_my_acc === "wcpoa_att_in_my_acc_enable") ? 'selected' : ''; ?>><?php esc_html_e('Enable', $plugin_txt_domain) ?></option>
                                            <option name="wcpoa_att_in_my_acc_disable" value="wcpoa_att_in_my_acc_disable"
                                                    class="" <?php echo ($wcpoa_att_in_my_acc === "wcpoa_att_in_my_acc_disable") ? 'selected' : ''; ?>><?php esc_html_e('Disable', $plugin_txt_domain) ?></option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e('On Product Page Allow Attachements For:', $plugin_txt_domain) ?></span>
                                    <p class="description">If none is selected or leave blank, the attachment will be always visible for all user.</p>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-chxbox">
                                    
                                            <li>
                                                <label for="wcpoa_wc_order_pending">
                                                    <input name="wcpoa_att_download_restrict[]"
                                                           class="" value="wcpoa_att_download_guest" type="checkbox"
                                                        <?php 
                                                        if( empty($wcpoa_att_download_restrict)){
                                                            $wcpoa_att_download_restrict = array();
                                                        } 
                                                        if (!is_null($wcpoa_att_download_restrict) && in_array('wcpoa_att_download_guest', $wcpoa_att_download_restrict,true)) echo 'checked="checked"'; ?>><?php esc_html_e('Guest / Not logged In', $plugin_txt_domain); ?></label>
                                            </li>
                                        <?php 
                                            global $wp_roles;
                                            foreach ( $wp_roles->roles as $key=>$value ):
                                                if( empty($wcpoa_att_download_restrict)){
                                                    $wcpoa_att_download_restrict = array();
                                                } 
                                                $wcpoa_att_download_restric_key = "wcpoa_att_download_".$key;
                                                ?>
                                                <li>
                                                    <label for="wcpoa_wc_order_pending">
                                                        <input name="wcpoa_att_download_restrict[]"
                                                               class="" value="wcpoa_att_download_<?php echo esc_attr($key); ?>" type="checkbox"
                                                            <?php 
                                                            if (!is_null($wcpoa_att_download_restrict) && in_array($wcpoa_att_download_restric_key, $wcpoa_att_download_restrict,true)) echo 'checked="checked"'; ?>><?php esc_html_e($value['name'], $plugin_txt_domain); ?></label>
                                                </li>
                                                <?php
                                            endforeach;   
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e('Attachements Show In Email', $plugin_txt_domain) ?></span>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-txtbox">
                                        <select name="wcpoa_attachments_show_in_email" class="wcpoa_attachments_show_in_email"
                                                data-type="" data-key="">
                                            <option name="yes"
                                                    value="yes" <?php echo ($wcpoa_attachments_show_in_email === "yes") ? 'selected' : ''; ?>><?php esc_html_e('Yes', $plugin_txt_domain) ?></option>
                                            <option name="no" value="no"
                                                    class="" <?php echo ($wcpoa_attachments_show_in_email === "no") ? 'selected' : ''; ?>><?php esc_html_e('No', $plugin_txt_domain) ?></option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e('Action on click Attachment', $plugin_txt_domain) ?></span>
                                    <p class="description">Open in new tab will only applicable for External url not for uploaded file.</p>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-txtbox">
                                        <select name="wcpoa_attachments_action_on_click" class="wcpoa_attachments_action_on_click"
                                                data-type="" data-key="">
                                            <option value="download" <?php echo ($wcpoa_attachments_action_on_click === "download") ? 'selected' : ''; ?>><?php esc_html_e('Download', $plugin_txt_domain) ?></option>
                                            <option value="newtab"
                                                    class="" <?php echo ($wcpoa_attachments_action_on_click === "newtab") ? 'selected' : ''; ?>><?php esc_html_e('Open in new tab', $plugin_txt_domain) ?></option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                        }else{ ?>
                            <tr>
                                <th>
                                    <span class="wcpoa-name"><?php esc_html_e( 'Is default behavior of the attached PDF is viewable?', 'woocommerce-product-attachment' ) ?></span>
                                </th>
                                <td class="">
                                    <div class="wcpoa-name-txtbox">
                                        <select name="wcpoa_is_viewable" class="wcpoa_is_viewable" data-type="" data-key="">
                                            <option name="no" value="no" class="" <?php selected( $wcpoa_is_viewable, 'no', true ); ?>><?php esc_html_e( 'No', 'woocommerce-product-attachment' ) ?></option>
                                            <option name="yes" value="yes" <?php selected( $wcpoa_is_viewable, 'yes', true ); ?>><?php esc_html_e( 'Yes', 'woocommerce-product-attachment' ) ?></option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        <?php    
                        }
                    }else{ ?>
                        <tr>
                            <th>
                                <span class="wcpoa-name"><?php esc_html_e( 'Is default behavior of the attached PDF is viewable?', 'woocommerce-product-attachment' ) ?></span>
                            </th>
                            <td class="">
                                <div class="wcpoa-name-txtbox">
                                    <select name="wcpoa_is_viewable" class="wcpoa_is_viewable" data-type="" data-key="">
                                        <option name="no" value="no" class="" <?php selected( $wcpoa_is_viewable, 'no', true ); ?>><?php esc_html_e( 'No', 'woocommerce-product-attachment' ) ?></option>
                                        <option name="yes" value="yes" <?php selected( $wcpoa_is_viewable, 'yes', true ); ?>><?php esc_html_e( 'Yes', 'woocommerce-product-attachment' ) ?></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    <?php    
                    } ?>
                    
                    <tr>
                        <td colspan="2" class="wcpoa-setting-btn">
                            <?php submit_button(); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <?php
    }

    /**
     * Plugin Getting started
     *
     */
    function wcpoa_plugin_get_started()
    {
        require_once(plugin_dir_path( __FILE__ ).'partials/wcpoa-plugin-get-started.php');
    }

    /**
     * Plugin Quick Information
     *
     */
    function wcpoa_plugin_quick_info()
    {
        require_once(plugin_dir_path( __FILE__ ).'partials/wcpoa-plugin-quick-info.php');
    }

    public function wcpoa_add_meta_box($post_type)
    {
        $plugin_txt_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        $post_type = array('product');
        add_meta_box('wcpoa_attachment', __('WooCommerce Product Attachment', $plugin_txt_domain), array($this, 'wcpoa_attachment_product_page'), $post_type, 'advanced', 'high');
    }   

    public function wcpoa_get_hidden_input($atts)
    {
        $atts['type'] = 'hidden';

        return '<input ' . $this->wcpoa_esc_attr($atts) . ' />';
    }

    public function wcpoa_esc_attr($atts,$return=true)
    {
        // is string?
        if (is_string($atts)) {

            $atts = trim($atts);
            return esc_attr($atts);
        }


        // validate
        if (empty($atts)) {

            return '';
        }

        foreach ($atts as $key => $value) {
                 echo esc_html($key).'="'.esc_attr($value).'"';

        }
        return; 
    }

    /**
     *
     */
    public function wcpoa_attachment_product_page(){
        global $product, $post, $i, $field;

        // vars
        $div = array(
            'class' => 'wcpoa-repeater',
            'data-min' => $field['min'],
            'data-max' => $field['max']
        );

        // ensure value is an array
        if (empty($field['value'])) {

            $field['value'] = array();
  
            $div['class'] .= ' -empty';
        }

        // rows
        $field['min'] = empty($field['min']) ? 0 : $field['min'];
        $field['max'] = empty($field['max']) ? 0 : $field['max'];
        // populate the empty row data (used for wcpoacloneindex and min setting)
        $empty_row = array();

        // If there are less values than min, populate the extra values
        if ($field['min']) {

            for ($i = 0; $i < $field['min']; $i++) {

                // continue if already have a value
                if (array_key_exists($i, $field['value'])) {

                    continue;
                }
                // populate values
                $field['value'][$i] = $empty_row;
            }
        }

        // If there are more values than man, remove some values
        if ($field['max']) {

            for ($i = 0; $i < count($field['value']); $i++) {
 
                if ($i >= $field['max']) {
 
                    unset($field['value'][$i]);
                }
            } 
        }

        // setup values for row clone
        $field['value']['wcpoacloneindex'] = $empty_row;
        // show columns
        $show_order = true;
        $show_add = true;
        $show_remove = true;

        if ($field['max']) {

            if ((int)$field['max'] === 1) {

                $show_order = false;
            }

            if ($field['max'] <= $field['min']) {

                $show_remove = false;
                $show_add = false;
            }
        }

        // field wrap
        $before_fields = '';
        $after_fields = '';

        if ('row' === 'row') {

            $before_fields = '<td class="wcpoa-fields -left">';
            $after_fields = '</td>';
        }

        // layout
        $div['class'] .= ' -' . 'row';
        $plugin_txt_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        $plugin_url = WCPOA_PLUGIN_URL;
        $product_id = $post->ID;
        $product = wc_get_product($product_id);
        $wcpoa_attachment_ids = get_post_meta($product_id, 'wcpoa_attachments_id', true);
        $wcpoa_attachment_name = get_post_meta($product_id, 'wcpoa_attachment_name', true);
        $wcpoa_attach_type = get_post_meta($product_id, 'wcpoa_attach_type', true);
        $wcpoa_attachment_ext_url = get_post_meta($product_id, 'wcpoa_attachment_ext_url', true);
        $wcpoa_attachment_url = get_post_meta($product_id, 'wcpoa_attachment_url', true);
        $wcpoa_attachment_description = get_post_meta($product_id, 'wcpoa_attachment_description', true);
        $wcpoa_product_page_enable = get_post_meta($product_id, 'wcpoa_product_page_enable', true);
        $wcpoa_product_variation = get_post_meta($product_id, 'wcpoa_variation', true);
        $wcpoa_order_status = array();
        $wcpoa_pd_enable = get_post_meta($product_id, 'wcpoa_expired_date_enable', true);
        $wcpoa_expired_date = get_post_meta($product_id, 'wcpoa_expired_date', true);
        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                $wcpoa_expired_time_amount = get_post_meta($product_id, 'wcpoa_expired_time_amount', true);
                $wcpoa_expired_time_type = get_post_meta($product_id, 'wcpoa_expired_time_type', true);
            }
        }
        wp_nonce_field(plugin_basename(__FILE__), 'wcpoa_attachment_nonce');
        ?>
        <div class="wcpoa-field wcpoa-field-repeater" data-name="attachments" data-type="repeater"
             data-key="attachments">
            <div class="wcpoa-label">
                <label for="wcpoa-pro"><?php esc_html_e('Attachments', $plugin_txt_domain) ?></label>
                <span><?php esc_html_e('Enhance your customer experience of product pages with downloadable files, such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. A plugin will help you to attach/ upload any kind of files (doc, jpg, videos, pdf) for a customer orders.', $plugin_txt_domain) ?></span><br>

                <span><?php esc_html_e('Attachments can be downloadable/viewable on the Order details and/or Product pages. This will help customers to get more details about products they purchase.', $plugin_txt_domain) ?></span>
            </div>

            <div class="wcpoa-input">
                <div <?php $this->wcpoa_esc_attr_e($div); ?>>
                    <table class="wcpoa-table">
                        <tbody id="wcpoa-ui-tbody" class="wcpoa-ui-sortable">

                        <?php
                        if (!empty($wcpoa_attachment_ids) && is_array($wcpoa_attachment_ids)) {

                            foreach ($wcpoa_attachment_ids as $key => $wcpoa_attachments_id) {

                                if (!empty($wcpoa_attachments_id)) {
                                    $attachment_name = isset($wcpoa_attachment_name[$key]) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '';
                                    $wcpoa_attachment_file_id = isset($wcpoa_attachment_url[$key]) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '';

                                    $wcpoa_attach_type_single = isset($wcpoa_attach_type[$key]) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '';
                                    
                                    $wcpoa_attachment_description = isset($wcpoa_attachment_description[$key]) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '';
                                    $wcpoa_product_p_enable = isset($wcpoa_product_page_enable[$key]) && !empty($wcpoa_product_page_enable[$key]) ? $wcpoa_product_page_enable[$key] : '';
                                    $wcpoa_product_date_enable = isset($wcpoa_pd_enable[$key]) && !empty($wcpoa_pd_enable[$key]) ? $wcpoa_pd_enable[$key] : '';
                                    $wcpoa_expired_dates = isset($wcpoa_expired_date[$key]) && !empty($wcpoa_expired_date[$key]) ? $wcpoa_expired_date[$key] : '';

                                    if ( wpap_fs()->is__premium_only() ) {
                                        if ( wpap_fs()->can_use_premium_code() ) {
                                            $wcpoa_attachment_ext_url_single = isset($wcpoa_attachment_ext_url[$key]) && !empty($wcpoa_attachment_ext_url[$key]) ? $wcpoa_attachment_ext_url[$key] : '';    
                                            $wcpoa_exp_time_amount = isset($wcpoa_expired_time_amount[$key]) && !empty($wcpoa_expired_time_amount[$key]) ? $wcpoa_expired_time_amount[$key] : '';
                                            $wcpoa_exp_time_type = isset($wcpoa_expired_time_type[$key]) && !empty($wcpoa_expired_time_type[$key]) ? $wcpoa_expired_time_type[$key] : '';
                                        }        
                                    }    

                                    $wcpoa_order_status_value = get_post_meta($product_id, 'wcpoa_order_status', true);
                                    if ($wcpoa_order_status_value === 'wc-all') {
                                        $wcpoa_order_status = array();
                                    } else {
                                        $wcpoa_order_status = $wcpoa_order_status_value[$wcpoa_attachments_id];
                                    }
                                    //file upload
                                    // vars
                                    $uploader = 'uploader';

                                    // vars
                                    $o = array(
                                        'icon' => '',
                                        'title' => '',
                                        'url' => '',
                                        'filesize' => '',
                                        'filename' => '',
                                    );

                                    $filediv = array(
                                        'class' => 'wcpoa-file-uploader wcpoa-cf',
                                        'data-uploader' => $uploader
                                    );

                                    // has value?
                                    if (!empty($wcpoa_attachment_file_id)) {

                                        $file = get_post($wcpoa_attachment_file_id);

                                        if ($file) {

                                            $o['icon'] = wp_mime_type_icon($wcpoa_attachment_file_id);
                                            $o['title'] = $file->post_title;
                                            $o['filesize'] = size_format(filesize(get_attached_file($wcpoa_attachment_file_id)));
                                            $o['url'] = wp_get_attachment_url($wcpoa_attachment_file_id);

                                            $explode = explode('/', $o['url']);
                                            $o['filename'] = end($explode);
                                        }
                                        // url exists
                                        if ($o['url']) {

                                            $filediv['class'] .= ' has-value';
                                        }
                                    }
                                    ?>

                                    <tr class="wcpoa-row wcpoa-has-value -collapsed" data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>" id="<?php echo esc_attr($wcpoa_attachments_id) ?>">

                                        <?php if ($show_order) { ?>
                                            <td class="wcpoa-row-handle order"
                                                title="<?php esc_html_e('Drag to reorder', $plugin_txt_domain); ?>">
                                                <a class="wcpoa-icon -collapse small" href="#" data-event="collapse-row"
                                                   title="<?php esc_html_e('Click to toggle', $plugin_txt_domain); ?>"></a>
                                                <?php // }  ?>
                                                <span><?php echo intval($i++) + 1; ?></span>
                                            </td>
                                        <?php } ?>
                                        <?php echo wp_kses($before_fields,$this->allowed_html_tags()); ?>
                                        <div class="wcpoa-field wcpoa-field-text" data-name="id" data-type="text"
                                             data-key="">
                                            <div class="wcpoa-label">
                                                <label for=""><?php esc_html_e('Id', $plugin_txt_domain) ?> </label>
                                                <p class="description"><?php esc_html_e('Attachments Id used to identify each product attachment.This value is automatically generated.', $plugin_txt_domain) ?></p>
                                            </div>
                                            <div class="wcpoa-input">
                                                <div class="wcpoa-input-wrap">
                                                    <input readonly="" class="wcpoa_attachments_id"
                                                           name="wcpoa_attachments_id[]"
                                                           value="<?php echo esc_attr($wcpoa_attachments_id); ?>"
                                                           placeholder="" type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wcpoa-field -collapsed-target" data-name="_name" data-type="text"
                                             data-key="">
                                            <div class="wcpoa-label">
                                                <label for="attchment_name"><?php esc_html_e('Attachment Name', $plugin_txt_domain); ?>
                                                    <span class="wcpoa-required"> *</span></label>
                                                <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                                            </div>
                                            <div class="wcpoa-input wcpoa-att-name-parent">
                                                <input class="wcpoa-attachment-name" type="text"
                                                       name="wcpoa_attachment_name[]" 
                                                       value="<?php echo esc_attr($attachment_name); ?>" >
                                            </div>
                                        </div>
                                        <div class="wcpoa-field wcpoa-field-textarea " data-name="description"
                                             data-type="textarea" data-key="" data-required="1">
                                            <div class="wcpoa-label">
                                                <label for="attchment_desc"><?php esc_html_e('Attachment Description', $plugin_txt_domain); ?></label>
                                                <p class="description"><?php esc_html_e('You can type a short description of the attachment file. So User will get details about attachment file.', $plugin_txt_domain) ?></p>
                                            </div>
                                            <div class="wcpoa-input">
                                                <textarea class="" name="wcpoa_attachment_description[]"
                                                          placeholder=""
                                                          rows="8"><?php echo esc_html($wcpoa_attachment_description); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="wcpoa-field wcpoa-field-select -collapsed-target">
                                            <div class="wcpoa-label">
                                                <label for="wcpoa_attach_type"><?php esc_html_e('Attachment Type',$plugin_txt_domain); ?></label>
                                                <p class="description"><?php esc_html_e('Attachment Type?',$plugin_txt_domain); ?></p>
                                            </div>

                                            <div class="wcpoa-input wcpoa_attach_type">
                                                <?php
                                                if ( wpap_fs()->is__premium_only() ) {
                                                    if ( wpap_fs()->can_use_premium_code() ) { ?>
                                                        <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                                            <option name="file_upload" <?php echo ($wcpoa_attach_type_single === "file_upload") ? 'selected' : '';  ?> value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                                            <option name="external_ulr" <?php echo ($wcpoa_attach_type_single === "external_ulr") ? 'selected' : '';  ?> value="external_ulr" class=""><?php esc_html_e('External URL', $plugin_txt_domain) ?></option>
                                                        </select>
                                                    <?php }else{ ?>
                                                        <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                                            <option name="file_upload" <?php echo ($wcpoa_attach_type_single === "file_upload") ? 'selected' : '';  ?> value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                                            <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('External URL ( Pro Version )', $plugin_txt_domain) ?></option>
                                                        </select>
                                                    <?php } ?>    
                                                <?php }else{ ?>
                                                    <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                                        <option name="file_upload" <?php echo ($wcpoa_attach_type_single === "file_upload") ? 'selected' : '';  ?> value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                                        <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('External URL ( Pro Version )', $plugin_txt_domain) ?></option>
                                                    </select>
                                                <?php } ?>    
                                            </div>
                                        </div>
                                        <?php  $is_show= $wcpoa_attach_type_single!=='file_upload'?"none":""?>
                                        <div style="display:<?php   echo esc_attr($is_show) ?>" class="wcpoa-field file_upload wcpoa-field-file -collapsed-target required" data-name="file" data-type="file" data-key="" data-required="1">
                                            <div class="wcpoa-label">
                                                <div class="wcpoa-label">
                                                    <label for="fee_settings_start_date"><?php esc_html_e('Upload Attachment', $plugin_txt_domain); ?>
                                                        <span class="wcpoa-required">*</span>
                                                    </label>
                                                    <p class="description"><?php esc_html_e('Upload Attachment File.', $plugin_txt_domain) ?></p>
                                                </div>
                                            </div>
                                            <div class="wcpoa-input" data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>">
                                                <div <?php $this->wcpoa_esc_attr_e($filediv); ?>>
                                                    <div class="wcpoa-error-message">
                                                        <p><?php echo 'File value is required'; ?></p>
                                                        <input name="wcpoa_attachment_file[]"
                                                               data-validation="[NOTEMPTY]"
                                                               value="<?php echo esc_attr($wcpoa_attachment_file_id) ?>"
                                                               data-name="id" type="hidden" required="required">
                                                    </div>
                                                    <div class="show-if-value file-wrap wcpoa-soh">
                                                        <div class="file-icon">
                                                            <img data-name="icon" src="<?php echo esc_url($o['icon']); ?>"
                                                                 alt=""/>
                                                        </div>
                                                        <div class="file-info">
                                                            <p>
                                                                <strong data-name="title"><?php echo esc_html($o['title']); ?></strong>
                                                            </p>
                                                            <p>
                                                                <strong><?php esc_html_e('File name', $plugin_txt_domain); ?>
                                                                    :</strong>
                                                                <a data-name="filename" href="<?php echo esc_url($o['url']); ?>"
                                                                   target="_blank"><?php echo esc_html($o['filename']); ?></a>
                                                            </p>
                                                            <p>
                                                                <strong><?php esc_html_e('File size', $plugin_txt_domain); ?>
                                                                    :</strong>
                                                                <span data-name="filesize"><?php echo esc_html($o['filesize']); ?></span>
                                                            </p>

                                                            <ul class="wcpoa-hl wcpoa-soh-target">
                                                                <?php if ($uploader !== 'basic'): ?>
                                                                    <li><a data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>" class="wcpoa-icon -pencil dark"
                                                                           data-name="edit" href="#"></a></li>
                                                                <?php endif; ?>
                                                                <li><a data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>" class="wcpoa-icon -cancel dark"
                                                                       data-name="remove" href="#"></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="hide-if-value">
                                                        <?php if ($uploader === 'basic'): ?>
                                                            <?php if ($field['value'] && !is_numeric($field['value'])): ?>
                                                                <div class="wcpoa-error-message">
                                                                    <p><?php echo esc_html($field['value']); ?></p></div>
                                                            <?php endif; ?>
                                                            <input type="file" name="<?php echo esc_attr($field['name']); ?>"
                                                                   id="<?php echo esc_attr($field['id']); ?>"/>
                                                        <?php else: ?>
                                                            <p style="margin:0;"><?php esc_html_e('No file selected', $plugin_txt_domain); ?>
                                                                <?php echo wp_kses($this->misha_image_uploader_field($wcpoa_attachments_id),$this->allowed_html_tags()); ?></p>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if ( wpap_fs()->is__premium_only() ) {
                                            if ( wpap_fs()->can_use_premium_code() ) { ?>
                                                <?php  $is_show= $wcpoa_attach_type_single !=='external_ulr'?"none":""?>    
                                                <div style='display:<?php   echo esc_attr($is_show) ?>' class="wcpoa-field -collapsed-target external_ulr" style=''>
                                                    <div class="wcpoa-label">
                                                        <label for="attchment_name"><?php esc_html_e('Attach an external URL',$plugin_txt_domain); ?><span class="wcpoa-required"> *</span></label>
                                                        <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                                                    </div>
                                                    <div class="wcpoa-input">
                                                        <input class="wcpoa-attachment-url" type="text" name="wcpoa_attachment_url[]" value="<?php echo esc_attr($wcpoa_attachment_ext_url_single); ?>">
                                                    </div>
                                                </div>
                                            <?php }
                                        } ?>
                                        <div class="wcpoa-field">
                                            <div class="wcpoa-label">
                                                <label for="product_page_enable"><?php esc_html_e('Show on Product page', $plugin_txt_domain); ?></label>
                                                <p class="description"><?php esc_html_e('On Product Details page show attachment.', $plugin_txt_domain) ?></p>
                                            </div>
                                            <div class="wcpoa-input">
                                                <select id="wcpoa_product_page_enable"
                                                        name="wcpoa_product_page_enable[]">
                                                    <option name="yes" <?php echo ($wcpoa_product_p_enable === "yes") ? 'selected' : ''; ?>
                                                            value="yes"><?php esc_html_e('Yes', $plugin_txt_domain) ?></option>
                                                    <option name="no" <?php echo ($wcpoa_product_p_enable === "no") ? 'selected' : ''; ?>
                                                            value="no"><?php esc_html_e('No', $plugin_txt_domain) ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                        if ( wpap_fs()->is__premium_only() ) {
                                            if ( wpap_fs()->can_use_premium_code() ) {
                                                if ($product->is_type('variable')) {
                                                    $variations = $product->get_available_variations();
                                                    if (!empty($variations)) {
                                                        ?>
                                                        <div class="wcpoa-field">
                                                            <div class="wcpoa-label">
                                                                <label><?php esc_html_e('Variants', $plugin_txt_domain); ?></label>
                                                                <p class="description"><?php esc_html_e('In case of variable product, you can enable attachments only for specific variants. Leave unselected to apply to all', $plugin_txt_domain); ?></p>
                                                            </div>
                                                            <div class="wcpoa-input wcpoa_product_variation">
                                                                <?php foreach ($variations as  $variation) {
                                                                    ?>
                                                                    <input id="_checkbox1" type="checkbox" class=""
                                                                           value="<?php echo esc_attr($variation['variation_id']); ?>"
                                                                           name="wcpoa_variation[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                    <?php if (!is_null($wcpoa_product_variation) && (!is_null($wcpoa_product_variation[$wcpoa_attachments_id])) && in_array((int)$variation['variation_id'], convert_array_to_int($wcpoa_product_variation[$wcpoa_attachments_id]),true)) echo 'checked="checked"'; ?>>
                                                                    <label class="variation"><?php echo esc_html($variation['variation_id']); ?></label>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="wcpoa-field">
                                            <div class="wcpoa-label">
                                                <label for="attchment_order_status"><?php esc_html_e('Order status', $plugin_txt_domain); ?></label>
                                                <p class="description"><?php esc_html_e('Select order status for which the attachment(s) will be visible.Leave unselected to apply to all.', $plugin_txt_domain); ?></p>
                                            </div>
                                            <div class="wcpoa-input">
                                                <ul class="wcpoa-checkbox-list">
                                                    <li><label for="wcpoa_wc_order_completed">
                                                            <input name="wcpoa_order_status[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                   class="" value="wcpoa-wc-completed" type="checkbox"
                                                                <?php if (!is_null($wcpoa_order_status) && in_array('wcpoa-wc-completed', $wcpoa_order_status,true)) echo 'checked="checked"'; ?>>
                                                            <?php esc_html_e('Completed', $plugin_txt_domain); ?>
                                                        </label>
                                                    </li>
                                                    <li><label for="wcpoa_wc_order_on_hold">
                                                            <input name="wcpoa_order_status[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                   class="" value="wcpoa-wc-on-hold" type="checkbox"
                                                                <?php if (!is_null($wcpoa_order_status) && in_array('wcpoa-wc-on-hold', $wcpoa_order_status,true)) echo 'checked="checked"'; ?>>
                                                            <?php esc_html_e('On Hold', $plugin_txt_domain); ?>
                                                        </label>
                                                    </li>
                                                    <li><label for="wcpoa_wc_order_pending">
                                                            <input name="wcpoa_order_status[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                   class="" value="wcpoa-wc-pending" type="checkbox"
                                                                <?php if (!is_null($wcpoa_order_status) && in_array('wcpoa-wc-pending', $wcpoa_order_status,true)) echo 'checked="checked"'; ?>>
                                                            <?php esc_html_e('Pending payment', $plugin_txt_domain); ?>
                                                        </label>
                                                    </li>
                                                    <li><label for="wcpoa_wc_order_processing">
                                                            <input name="wcpoa_order_status[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                   class="" value="wcpoa-wc-processing" type="checkbox"
                                                                <?php if (!is_null($wcpoa_order_status) && in_array('wcpoa-wc-processing', $wcpoa_order_status,true)) echo 'checked="checked"'; ?>>
                                                            <?php esc_html_e('Processing', $plugin_txt_domain); ?>
                                                        </label>
                                                    </li>
                                                    <li><label for="wcpoa_wc_order_cancelled">
                                                            <input name="wcpoa_order_status[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                   class="" value="wcpoa-wc-cancelled" type="checkbox"
                                                                <?php if (!is_null($wcpoa_order_status) && in_array('wcpoa-wc-cancelled', $wcpoa_order_status,true)) echo 'checked="checked"'; ?>>
                                                            <?php esc_html_e('Cancelled', $plugin_txt_domain); ?>
                                                        </label>
                                                    </li>
                                                    <li><label for="wcpoa_wc_order_failed">
                                                            <input name="wcpoa_order_status[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                   class="" value="wcpoa-wc-failed" type="checkbox"
                                                                <?php if (!is_null($wcpoa_order_status) && in_array('wcpoa-wc-failed', $wcpoa_order_status,true)) echo 'checked="checked"'; ?>>
                                                            <?php esc_html_e('Failed', $plugin_txt_domain); ?>
                                                        </label>
                                                    </li>
                                                    <li><label for="wcpoa_wc_order_refunded">
                                                            <input name="wcpoa_order_status[<?php echo esc_attr($wcpoa_attachments_id); ?>][]"
                                                                   class="" value="wcpoa-wc-refunded" type="checkbox"
                                                                <?php if (!is_null($wcpoa_order_status) && in_array('wcpoa-wc-refunded', $wcpoa_order_status,true)) echo 'checked="checked"'; ?>>
                                                            <?php esc_html_e('Refunded', $plugin_txt_domain); ?>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="wcpoa-field">
                                            <div class="wcpoa-label">
                                                <label for="wcpoa_expired_date_enable"><?php esc_html_e('Set expire date/time ', $plugin_txt_domain); ?></label>
                                                <p class="description"><?php esc_html_e('Expires?', $plugin_txt_domain); ?></p>
                                            </div>
                                            <div class="wcpoa-input enable_expire_date">
                                                <select name="wcpoa_expired_date_enable[]" class="enable_date_time"
                                                        data-type="enable_date_<?php echo esc_attr($wcpoa_attachments_id); ?>"
                                                        data-key="">
                                                    <option name="no" <?php echo ($wcpoa_product_date_enable === "no") ? 'selected' : ''; ?>
                                                            value="no" class=""><?php esc_html_e('No', $plugin_txt_domain) ?></option>
                                                    <option name="yes" <?php echo ($wcpoa_product_date_enable === "yes") ? 'selected' : ''; ?>
                                                            value="yes"><?php esc_html_e('Specific Date', $plugin_txt_domain) ?></option>
                                                    <?php
                                                    if ( wpap_fs()->is__premium_only() ) {
                                                        if ( wpap_fs()->can_use_premium_code() ) { ?>
                                                            <option name="time_amount" <?php echo ($wcpoa_product_date_enable === "time_amount") ? 'selected' : ''; ?> value="time_amount"><?php esc_html_e('Selected time period after purchase',$plugin_txt_domain) ?></option>
                                                        <?php }else{ ?>
                                                            <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('Selected time period after purchase ( Pro Version )', $plugin_txt_domain) ?></option>
                                                        <?php } ?>
                                                    <?php }else{ ?>
                                                        <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('Selected time period after purchase ( Pro Version )', $plugin_txt_domain) ?></option>
                                                    <?php } ?>        
                                                </select>
                                            </div>
                                        </div>
                                         <?php $is_date=$wcpoa_product_date_enable !=='yes'?'none':''; ?>   
                                        <div style="display:<?php  echo esc_attr($is_date)  ?>" class="wcpoa-field enable_date enable_date_<?php echo esc_attr($wcpoa_attachments_id); ?> wcpoa-field-date-picker" data-name="date" data-type="date_picker" data-key="" data-required="1" style=''>
                                            <div class="wcpoa-label">
                                                <label for="wcpoa_expired_date"><?php esc_html_e('Set Date', $plugin_txt_domain); ?></label>
                                                <p class="description"><?php esc_html_e('If an order is placed after the selected date, the attachments will be no longer visible for download', $plugin_txt_domain) ?></p>
                                            </div>
                                            <div class="wcpoa-input">
                                                <div class="wcpoa-date-picker wcpoa-input-wrap"
                                                     data-date_format="yy/mm/dd">
                                                    <input class="input wcpoa-php-date-picker" name="wcpoa_expired_date[]"
                                                           value="<?php if ($wcpoa_product_date_enable === "yes") echo esc_attr($wcpoa_expired_dates) ?>"
                                                           type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if ( wpap_fs()->is__premium_only() ) {
                                            if ( wpap_fs()->can_use_premium_code() ) { ?>
                                                <?php $is_time=$wcpoa_product_date_enable !=='time_amount'?'none':''; ?>   
                                                <div class="wcpoa-field enable_time" style='display:<?php  echo esc_attr($is_time)  ?>'>
                                                    <div class="wcpoa-label">
                                                        <label for="attchment_time_amount"><?php esc_html_e('Time Period',$plugin_txt_domain); ?></label>
                                                    </div>
                                                    <div class="wcpoa-input">
                                                        <input class="wcpoa-attachment-_time-amount" type="text" name="wcpoa_attachment_time_amount[]" value="<?php echo esc_attr($wcpoa_exp_time_amount); ?>" >
                                                    </div>

                                                    <div class="wcpoa-label">
                                                        <label for="attchment_time_type"><?php esc_html_e('Time Period Type',$plugin_txt_domain); ?></label>
                                                    </div>
                                                    <div class="wcpoa-input">
                                                        <select name="wcpoa_attachment_time_type[]" class="wcpoa-attachment-time-type" data-type="" data-key="">
                                                            <option name="seconds" value="seconds" <?php  echo ($wcpoa_exp_time_type === "seconds") ? 'selected' : '';  ?>><?php esc_html_e('Seconds', $plugin_txt_domain) ?></option>
                                                            <option name="minutes" value="minutes" <?php  echo ($wcpoa_exp_time_type === "minutes") ? 'selected' : '';  ?>><?php esc_html_e('Minutes', $plugin_txt_domain) ?></option>
                                                            <option name="hours" value="hours" <?php  echo ($wcpoa_exp_time_type === "hours") ? 'selected' : '';  ?>><?php esc_html_e('Hours', $plugin_txt_domain) ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php }
                                        } ?>        

                                        <?php echo wp_kses($after_fields,$this->allowed_html_tags()); ?>

                                        <?php if ($show_remove): ?>
                                            <td class="wcpoa-row-handle remove">
                                                <a class="wcpoa-icon -plus small wcpoa-js-tooltip" href="#"
                                                   data-event="add-row"
                                                   title="<?php esc_html_e('Add row', $plugin_txt_domain); ?>"></a>
                                                <a class="wcpoa-icon -minus small wcpoa-js-tooltip" href="#"
                                                   data-event="remove-row"
                                                   title="<?php esc_html_e('Remove row', $plugin_txt_domain); ?>"></a>
                                            </td>
                                        <?php endif; ?>

                                    </tr>
                                    <?php
                                }
                            }
                        }

                        foreach ($field['value'] as $i => $row)
                        {
                            $row_att = implode(" ",$row);
                            $row_class = 'wcpoa-row trr hidden';


                            if ($i === 'wcpoacloneindex') {

                                $row_class .= ' wcpoa-clone';
                            }
                            ?>
                            <tr class="<?php echo esc_attr($row_class); ?>" rowatt="<?php echo esc_attr($row_att); ?>" data-id="<?php echo esc_attr($i); ?>">


                                <?php if ($show_order) { ?>

                                    <td class="wcpoa-row-handle order" title="<?php esc_html_e('Drag to reorder', $plugin_txt_domain); ?>">
                                        <a class="wcpoa-icon -collapse small" href="#" data-event="collapse-row"
                                           title="<?php esc_html_e('Click to toggle', $plugin_txt_domain); ?>"></a>
                                        <span><?php echo intval($i) + 1; ?></span>

                                    </td>
                                <?php } ?>
                                <td class="wcpoa-fields -left">

                                    <div class="wcpoa-field wcpoa-field-text wcpoa-field-58f4972436131" data-name="id"
                                         data-type="text" data-key="field_58f4972436131">
                                        <div class="wcpoa-label">
                                            <label for=""><?php esc_html_e('Id', $plugin_txt_domain) ?> </label>
                                            <p class="description"><?php esc_html_e('Attachments Id used to identify each product attachment.This value is automatically generated.', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-input-wrap">
                                                <input readonly=""
                                                       class="wcpoa_attachments_id"
                                                       name="wcpoa_attachments_id[]" value="" placeholder=""
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wcpoa-field -collapsed-target">
                                        <div class="wcpoa-label">
                                            <label for="attchment_name"><?php esc_html_e('Attachment Name', $plugin_txt_domain); ?>
                                                <span class="wcpoa-required"> *</span></label>
                                            <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <input class="wcpoa-attachment-name" type="text"
                                                   name="wcpoa_attachment_name[]" value="" >
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-textarea " data-name="description"
                                         data-type="textarea" data-key="" data-required="1">
                                        <div class="wcpoa-label">
                                            <label for="attchment_desc"><?php esc_html_e('Attachment Description', $plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('You can type a short description of the attachment file. So User will get details about attachment file.', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <textarea class="" name="wcpoa_attachment_description[]" placeholder=""
                                                      rows="8"></textarea>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_attach_type"><?php esc_html_e('Attachment Type',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Attachment Type?',$plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input wcpoa_attach_type">
                                            <?php
                                            if ( wpap_fs()->is__premium_only() ) {
                                                if ( wpap_fs()->can_use_premium_code() ) { ?>
                                                    <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                                        <option name="file_upload" value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                                        <option name="external_ulr" value="external_ulr" class=""><?php esc_html_e('External URL', $plugin_txt_domain) ?></option>
                                                    </select>
                                                <?php }else{ ?> 
                                                    <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                                        <option name="file_upload" value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                                        <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('External URL ( Pro Version )', $plugin_txt_domain) ?></option>
                                                    </select>
                                                <?php } ?> 
                                            <?php }else{ ?>
                                                <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                                    <option name="file_upload" value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                                    <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('External URL ( Pro Version )', $plugin_txt_domain) ?></option>
                                                </select>
                                            <?php } ?>       
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-file -collapsed-target file_upload" data-name="file" data-type="file" data-key="field_58f4974e36133" data-required="1">
                                        <div class="wcpoa-label">
                                            <div class="wcpoa-label">
                                                <label for="fee_settings_start_date"><?php esc_html_e('Upload Attachment', $plugin_txt_domain); ?>
                                                    <span class="wcpoa-required">*</span>
                                                </label>
                                                <p class="description"><?php esc_html_e('Upload Attachment File.', $plugin_txt_domain) ?></p>
                                            </div>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-file-uploader wcpoa-cf" data-uploader="uploader">
                                                <div class="wcpoa-error-message">
                                                    <p><?php echo 'File value is required'; ?></p>
                                                    <input name="wcpoa_attachment_file[]" value="" data-name="id"
                                                           type="hidden">
                                                </div>
                                                <div class="show-if-value file-wrap wcpoa-soh">
                                                    <div class="file-icon">
                                                        <img data-name="icon"
                                                             src="<?php echo esc_url($plugin_url) . 'admin/images/default.png'; ?>"
                                                             alt="" title="">
                                                    </div>
                                                    <div class="file-info">
                                                        <p>
                                                            <strong data-name="title"></strong>
                                                        </p>
                                                        <p>
                                                            <strong>File name:</strong>
                                                            <a data-name="filename" href="" target="_blank"></a>
                                                        </p>
                                                        <p>
                                                            <strong>File size:</strong>
                                                            <span data-name="filesize"></span>
                                                        </p>

                                                        <ul class="wcpoa-hl wcpoa-soh-target">
                                                            <li><a class="wcpoa-icon -pencil dark" data-name="edit"
                                                                   href="#"></a></li>
                                                            <li><a class="wcpoa-icon -cancel dark" data-name="remove"
                                                                   href="#"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="hide-if-value">
                                                    <p style="margin:0;">No file selected <?php echo wp_kses($this->misha_image_uploader_field('test'),$this->allowed_html_tags()); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ( wpap_fs()->is__premium_only() ) {
                                        if ( wpap_fs()->can_use_premium_code() ) { ?>
                                    <div class="wcpoa-field -collapsed-target external_ulr" style='display: none'>
                                        <div class="wcpoa-label">
                                            <label for="attchment_name"><?php esc_html_e('Attach an external URL',$plugin_txt_domain); ?><span class="wcpoa-required"> *</span></label>
                                            <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <input class="wcpoa-attachment-url" type="text" name="wcpoa_attachment_url[]" value="" >
                                        </div>
                                    </div>
                                        <?php }
                                    } ?>
                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label for="product_page_enable"><?php esc_html_e('Show on Product page', $plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('On Product Details page show attachment.', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select id="wcpoa_product_page_enable"
                                                    name="wcpoa_product_page_enable[]">
                                                <option name="yes" value="yes"><?php esc_html_e('Yes', $plugin_txt_domain) ?></option>
                                                <option name="no" value="no" selected><?php esc_html_e('No', $plugin_txt_domain) ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if ( wpap_fs()->is__premium_only() ) {
                                        if ( wpap_fs()->can_use_premium_code() ) {
                                            if ($product->is_type('variable')) {
                                                $variations = $product->get_available_variations();

                                                if (!empty($variations)) {
                                                    ?>
                                                    <div class="wcpoa-field">
                                                        <div class="wcpoa-label">
                                                            <label><?php esc_html_e('Variants', $plugin_txt_domain); ?></label>
                                                            <p class="description"><?php esc_html_e('In case of variable product, you can enable attachments only for specific variants. Leave unselected to apply to all', $plugin_txt_domain); ?></p>
                                                        </div>
                                                        <div class="wcpoa-input wcpoa_product_variation">
                                                            <?php foreach ($variations as $key => $variation) { ?>
                                                                <input id="_checkbox1" type="checkbox" class=""
                                                                       value="<?php echo esc_attr($variation['variation_id']); ?>"
                                                                       name="wcpoa_variation[][]" checked="">
                                                                <label class="variation"><?php echo esc_attr($variation['variation_id']); ?></label>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label for="attchment_order_status"><?php esc_html_e('Order status', $plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Select order status for which the attachment(s) will be visible.Leave unselected to apply to all.', $plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <ul class="wcpoa-order-checkbox-list">
                                                <li>
                                                    <label for="wcpoa_wc_order_completed">
                                                        <input name="wcpoa_order_status[]" class=""
                                                               value="wcpoa-wc-completed" <?php ?>
                                                               type="checkbox"><?php esc_html_e('Completed', $plugin_txt_domain) ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_on_hold">
                                                        <input name="wcpoa_order_status[]" class=""
                                                               value="wcpoa-wc-on-hold"
                                                               type="checkbox"><?php esc_html_e('On Hold', $plugin_txt_domain) ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_pending">
                                                        <input name="wcpoa_order_status[]" class=""
                                                               value="wcpoa-wc-pending"
                                                               type="checkbox"><?php esc_html_e('Pending payment', $plugin_txt_domain) ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_processing">
                                                        <input name="wcpoa_order_status[]" class=""
                                                               value="wcpoa-wc-processing"
                                                               type="checkbox"><?php esc_html_e('Processing', $plugin_txt_domain) ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_cancelled">
                                                        <input name="wcpoa_order_status[]" class=""
                                                               value="wcpoa-wc-cancelled"
                                                               type="checkbox"><?php esc_html_e('Cancelled', $plugin_txt_domain) ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_failed">
                                                        <input name="wcpoa_order_status[]" class=""
                                                               value="wcpoa-wc-failed"
                                                               type="checkbox"><?php esc_html_e('Failed', $plugin_txt_domain) ?>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="wcpoa_wc_order_refunded">
                                                        <input name="wcpoa_order_status[]" class=""
                                                               value="wcpoa-wc-refunded"
                                                               type="checkbox"><?php esc_html_e('Refunded', $plugin_txt_domain) ?>
                                                    </label>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-select">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_expired_date_enable"><?php esc_html_e('Set expire date/time', $plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Expires?', $plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input enable_expire_date">
                                            <select name="wcpoa_expired_date_enable[]" class="enable_date_time" data-type="" data-key="">
                                                <option name="no" value="no" class="" selected=""><?php esc_html_e('No', $plugin_txt_domain) ?></option>
                                                <option name="yes" value="yes"><?php esc_html_e('Specific Date', $plugin_txt_domain) ?></option>
                                                <?php
                                                if ( wpap_fs()->is__premium_only() ) {
                                                    if ( wpap_fs()->can_use_premium_code() ) { ?>
                                                        <option name="time_amount" value="time_amount" class="" ><?php esc_html_e('Selected time period after purchase', $plugin_txt_domain) ?></option>
                                                    <?php }else{ ?>
                                                        <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('Selected time period after purchase ( Pro Version )', $plugin_txt_domain) ?></option>
                                                    <?php } ?> 
                                                <?php }else{ ?>
                                                    <option name="" value="" class="wcpoa_pro_class" disabled><?php esc_html_e('Selected time period after purchase ( Pro Version )', $plugin_txt_domain) ?></option>
                                                <?php } ?>       
                                            </select>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field enable_date" data-key="" data-required="1" style='display: none'>
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_expired_date"><?php esc_html_e('Set Date', $plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('If an order is placed after the selected date, the attachments will be no longer visible for download', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-input-wrap" data-date_format="yy/mm/dd">
                                                <!--<input id="" class="input-alt" name="wcpoa_expired_date[]" value=""
                                                       type="hidden">-->
                                                <input class="wcpoa-php-date-picker" value="" name="wcpoa_expired_date[]" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ( wpap_fs()->is__premium_only() ) {
                                        if ( wpap_fs()->can_use_premium_code() ) { ?>
                                    <div class="wcpoa-field enable_time" style='display: none'>
                                        <div class="wcpoa-label">
                                            <label for="attchment_time_amount"><?php esc_html_e('Time Period',$plugin_txt_domain); ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <input class="wcpoa-attachment-_time-amount" type="text" name="wcpoa_attachment_time_amount[]" value="" >
                                        </div>

                                        <div class="wcpoa-label">
                                            <label for="attchment_time_type"><?php esc_html_e('Time Period Type',$plugin_txt_domain); ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select name="wcpoa_attachment_time_type[]" class="wcpoa-attachment-time-type" data-type="" data-key="">
                                                <option name="seconds" value="seconds" selected=""><?php esc_html_e('Seconds', $plugin_txt_domain) ?></option>
                                                <option name="minutes" value="minutes"><?php esc_html_e('Minutes', $plugin_txt_domain) ?></option>
                                                <option name="hours" value="hours"><?php esc_html_e('Hours', $plugin_txt_domain) ?></option>
                                            </select>
                                        </div>
                                    </div>
                                        <?php }
                                    } ?>
                                </td>
                                <?php if ($show_remove): ?>
                                    <td class="wcpoa-row-handle remove">
                                        <a class="wcpoa-icon -plus small wcpoa-js-tooltip" href="#" data-event="add-row"
                                           title="<?php esc_html_e('Add row', $plugin_txt_domain); ?>"></a>
                                        <a class="wcpoa-icon -minus small wcpoa-js-tooltip" href="#"
                                           data-event="remove-row"
                                           title="<?php esc_html_e('Remove row', $plugin_txt_domain); ?>"></a>
                                    </td>
                                <?php endif; ?>


                            </tr>
                        <?php }
                        ?>
                        </tbody>
                    </table>
                    <?php if ($show_add): ?>

                        <ul class="wcpoa-actions wcpoa-hl">
                            <li>
                                <a class="wcpoa-button button button-primary"
                                   data-event="add-row"><?php esc_html_e('Add Attchment', $plugin_txt_domain) ?></a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--File validation-->
        <!--End file validation-->
        <?php
    }


    public function wcpoa_esc_attr_e($atts)
    {
        echo wp_kses($this->wcpoa_esc_attr($atts), $this->allowed_html_tags());
    }

    /**
     * Save Meta for post types.
     *
     * @param $product_id
     */
    public function wcpoa_attachment_meta_data($product_id)
    {
      //  die;

        if (empty($product_id)) {
            return;
        }
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $post_type=filter_input(INPUT_POST,'post_type', FILTER_SANITIZE_SPECIAL_CHARS);
        // Check post type is product
        if (isset($post_type) && 'product' === $post_type) {
            
            
           
            $wcpoa_attachments_id=filter_input(INPUT_POST,'wcpoa_attachments_id', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_attachments_id = !empty($wcpoa_attachments_id) && isset($wcpoa_attachments_id) ? $wcpoa_attachments_id : '';
            update_post_meta($product_id, 'wcpoa_attachments_id', $wcpoa_attachments_id);


            $wcpoa_attachment_name=filter_input(INPUT_POST,'wcpoa_attachment_name', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_attachment_name = !empty($wcpoa_attachment_name) && isset($wcpoa_attachment_name) ? $wcpoa_attachment_name : '';
            update_post_meta($product_id, 'wcpoa_attachment_name', $wcpoa_attachment_name);
            
            $wcpoa_attach_type=filter_input(INPUT_POST,'wcpoa_attach_type', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_attach_type = !empty($wcpoa_attach_type) && isset($wcpoa_attach_type) ? $wcpoa_attach_type : '';
            update_post_meta($product_id, 'wcpoa_attach_type', $wcpoa_attach_type);


            $wcpoa_attachment_file=filter_input(INPUT_POST,'wcpoa_attachment_file', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
            $wcpoa_attachment_file = !empty($wcpoa_attachment_file) && isset($wcpoa_attachment_file) ? $wcpoa_attachment_file : '';

            update_post_meta($product_id, 'wcpoa_attachment_url', $wcpoa_attachment_file);

            $wcpoa_attachment_url=filter_input(INPUT_POST,'wcpoa_attachment_url', FILTER_VALIDATE_URL, FILTER_REQUIRE_ARRAY);
            $wcpoa_attachment_url = !empty($wcpoa_attachment_url) && isset($wcpoa_attachment_url) ? $wcpoa_attachment_url : '';
            update_post_meta($product_id, 'wcpoa_attachment_ext_url', $wcpoa_attachment_url);
            

            
            $wcpoa_attachment_description=filter_input(INPUT_POST,'wcpoa_attachment_description', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_attachment_description = !empty($wcpoa_attachment_description) && isset($wcpoa_attachment_description) ? $wcpoa_attachment_description : '';
            update_post_meta($product_id, 'wcpoa_attachment_description', $wcpoa_attachment_description);


            
            $wcpoa_order_status=filter_input(INPUT_POST,'wcpoa_order_status', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_order_status_all = !empty($wcpoa_order_status) ? $wcpoa_order_status : 'wc-all';
            update_post_meta($product_id, 'wcpoa_order_status', $wcpoa_order_status_all);

            $wcpoa_product_page_enable=filter_input(INPUT_POST,'wcpoa_product_page_enable', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

            $wcpoa_product_page_enable = !empty($wcpoa_product_page_enable) && isset($wcpoa_product_page_enable) ? $wcpoa_product_page_enable : '';
            update_post_meta($product_id, 'wcpoa_product_page_enable', $wcpoa_product_page_enable);


            $wcpoa_expired_date_enable=filter_input(INPUT_POST,'wcpoa_expired_date_enable', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_expired_date_enable = !empty($wcpoa_expired_date_enable) && isset($wcpoa_expired_date_enable) ? $wcpoa_expired_date_enable : '';
            update_post_meta($product_id, 'wcpoa_expired_date_enable', $wcpoa_expired_date_enable);
            

            $wcpoa_expired_date=filter_input(INPUT_POST,'wcpoa_expired_date', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_expired_date = !empty($wcpoa_expired_date) && isset($wcpoa_expired_date) ? $wcpoa_expired_date : '';
            update_post_meta($product_id, 'wcpoa_expired_date', $wcpoa_expired_date);
            
            if ( wpap_fs()->is__premium_only() ) {
                if ( wpap_fs()->can_use_premium_code() ) {
                    $wcpoa_attachment_time_amount=filter_input(INPUT_POST,'wcpoa_attachment_time_amount', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    $wcpoa_attachment_time_amount = !empty($wcpoa_attachment_time_amount) && isset($wcpoa_attachment_time_amount) ? $wcpoa_attachment_time_amount : '';
                    update_post_meta($product_id, 'wcpoa_expired_time_amount', $wcpoa_attachment_time_amount);
                    
                    $wcpoa_attachment_time_type=filter_input(INPUT_POST,'wcpoa_attachment_time_type', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    $wcpoa_attachment_time_type = !empty($wcpoa_attachment_time_type) && isset($wcpoa_attachment_time_type) ? $wcpoa_attachment_time_type : '';
                    update_post_meta($product_id, 'wcpoa_expired_time_type', $wcpoa_attachment_time_type);
                }
            }

            $wcpoa_variation=filter_input(INPUT_POST,'wcpoa_variation', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_variation = !empty($wcpoa_variation) && isset($wcpoa_variation) ? $wcpoa_variation : '';
            update_post_meta($product_id, 'wcpoa_variation', $wcpoa_variation);
            
        }
    }


    public function wcpoa_attachment_edit_form()
    {
        echo 'enctype="multipart/form-data" novalidate';
    }

    /**
     * Order wcpoa order meta fields.
     *
     */
    public function wcpoa_order_add_meta_boxes()
    {
        $plugin_txt_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        add_meta_box('wcpoa_order_meta_fields', __('WooCommerce Product Attachment', $plugin_txt_domain), array($this, 'wcpoa_order_fields_data'), 'shop_order', 'normal', 'low');
    }

    /**
     * Admin side:Product attachments order data.
     *
     */
    public function wcpoa_order_fields_data()
    {
        global $post;
        $wcpoa_order = wc_get_order($post->ID);

        $order_statuses = wc_get_order_statuses();
        $items = $wcpoa_order->get_items(array('line_item'));
        $wcpoa_text_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        $wcpoa_att_values_key = array();
        $current_date = date("Y/m/d");
        $wcpoa_today_date = strtotime($current_date);
        $wcpoa_att_values_product_key = array();
        $wcpoa_all_att_values_product_key = array();
        $get_permalink_structure = get_permalink();
        if (strpos($get_permalink_structure, "?")) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        if (!empty($items) && is_array($items)) :
            foreach ($items as $item_id => $item) {
                //single product page attachment
                $wcpoa_order_attachment_items = wc_get_order_item_meta($item_id, 'wcpoa_order_attachment_order_arr', true);
                if (!empty($wcpoa_order_attachment_items)) {
                    $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                    $wcpoa_attachment_name = $wcpoa_order_attachment_items['wcpoa_attachment_name'];

                    $wcpoa_attachment_url = $wcpoa_order_attachment_items['wcpoa_attachment_url'];
                    $wcpoa_attach_type = $wcpoa_order_attachment_items['wcpoa_attach_type'];
                    if ( wpap_fs()->is__premium_only() ) {
                        if ( wpap_fs()->can_use_premium_code() ) {
                            $wcpoa_attachment_ext_url = $wcpoa_order_attachment_items['wcpoa_attachment_ext_url'];
                        }
                    }

                    $wcpoa_order_status = $wcpoa_order_attachment_items['wcpoa_order_status'];
                    $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                    if ( wpap_fs()->is__premium_only() ) {
                        if ( wpap_fs()->can_use_premium_code() ) {
                            $wcpoa_order_product_variation = $wcpoa_order_attachment_items['wcpoa_order_product_variation'];
                            if (!empty($wcpoa_order_product_variation) && is_array($wcpoa_order_product_variation)):
                                $attached_variations = array();
                                foreach ($wcpoa_order_product_variation as $var_list) {
                                    if (!empty($var_list) && is_array($var_list))
                                        foreach ($var_list as $var_id)
                                            $attached_variations[] = $var_id;
                                }
                            endif;
                            $selected_variation_id = $item->get_variation_id();
                        }else{
                            $wcpoa_order_product_variation = "";
                            $selected_variation_id = '';
                        }
                    }else{
                        $wcpoa_order_product_variation = "";
                        $selected_variation_id = '';
                    }
                    
                    if (!empty($selected_variation_id) && is_array($attached_variations) && in_array((int)$selected_variation_id, convert_array_to_int($attached_variations),true)) {
                        if ( wpap_fs()->is__premium_only() ) {
                            if ( wpap_fs()->can_use_premium_code() ) {
                                foreach ((array)$wcpoa_attachment_ids as $key => $wcpoa_attachments_id) {
                                    if (!empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '') {
                                        if (!in_array($wcpoa_attachments_id, $wcpoa_att_values_key,true)) {
                                            if (!empty($wcpoa_attachment_ids)) {
                                                $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                                $attachment_name = isset($wcpoa_attachment_name[$key]) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '';

                                                $wcpoa_attachment_type = isset($wcpoa_attach_type[$key]) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '';
                                                $wcpoa_attachment_ext_url = isset($wcpoa_attachment_ext_url[$key]) && !empty($wcpoa_attachment_ext_url[$key]) ? $wcpoa_attachment_ext_url[$key] : '';
                                                $wcpoa_attachment_file = isset($wcpoa_attachment_url[$key]) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '';


                                                $wcpoa_order_status_val = isset($wcpoa_order_status[$wcpoa_attachments_id]) && !empty($wcpoa_order_status[$wcpoa_attachments_id]) && $wcpoa_order_status[$wcpoa_attachments_id] ? $wcpoa_order_status[$wcpoa_attachments_id] : array();
                                                $wcpoa_order_status_new = str_replace('wcpoa-', '', $wcpoa_order_status_val);
                                                $wcpoa_expired_dates = isset($wcpoa_order_attachment_expired[$key]) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '';
                                                $attachment_id = $wcpoa_attachment_file; // ID of attachment

                                                echo '<table class="wcpoa_order">';
                                                echo '<tbody>';
                                                $wcpoa_attachment_expired_date = strtotime($wcpoa_expired_dates);


                                                $attachment_order_name = '<h3 class="wcpoa_attachment_name">' . $attachment_name . '</h3>';
                                                $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                                if($wcpoa_attachment_type === "file_upload"){
                                                    $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                                }elseif($wcpoa_attachment_type === "external_ulr"){
                                                    $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_attachment_ext_url.'" download>Download</a>';
                                                }


                                                $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">Download</a>';
                                                $wcpoa_expire_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expire Date Is :: ') . $wcpoa_expired_dates . '</p>';
                                                $wcpoa_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expired') . '</p>';
                                                $wcpoa_never_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Is Never Expire') . '</p>';
                                                if (!empty($wcpoa_attachment_expired_date)) {
                                                    if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                    } else {
                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                    }
                                                } else {
                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                    echo wp_kses($wcpoa_never_expired_date_text,$this->allowed_html_tags());
                                                }
                                                echo '<div class="wcpoa-order-status">';
                                                foreach ($order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_value) {

                                                    if (in_array($wcpoa_order_status_key, $wcpoa_order_status_new,true)) {
                                                        $order_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_value . '</h4>';
                                                        echo wp_kses($order_status_available,$this->allowed_html_tags());
                                                        
                                                    } elseif (empty($wcpoa_order_status_new)) {
                                                        $order_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_value . '</h4>';
                                                        echo wp_kses($order_status_available,$this->allowed_html_tags());
                                                        
                                                    } else {
                                                        $order_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_value . '</h4>';
                                                        echo wp_kses($order_status_available,$this->allowed_html_tags());
                                                        
                                                    }
                                                }
                                                echo "</div>
                                                </tbody>
                                                </table>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        foreach ((array)$wcpoa_attachment_ids as $key => $wcpoa_attachments_id) {
                            if (!empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '') {
                                if (!in_array($wcpoa_attachments_id, $wcpoa_att_values_key,true)) {
                                    if (!empty($wcpoa_attachment_ids)) {
                                        $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                        $attachment_name = isset($wcpoa_attachment_name[$key]) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '';

                                        $wcpoa_attachment_type = isset($wcpoa_attach_type[$key]) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '';

                                        if ( wpap_fs()->is__premium_only() ) {
                                            if ( wpap_fs()->can_use_premium_code() ) {
                                                $wcpoa_attachment_ext_url = isset($wcpoa_attachment_ext_url[$key]) && !empty($wcpoa_attachment_ext_url[$key]) ? $wcpoa_attachment_ext_url[$key] : '';
                                            }
                                        }

                                        $wcpoa_attachment_file = isset($wcpoa_attachment_url[$key]) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '';


                                        $wcpoa_order_status_val = isset($wcpoa_order_status[$wcpoa_attachments_id]) && !empty($wcpoa_order_status[$wcpoa_attachments_id]) && $wcpoa_order_status[$wcpoa_attachments_id] ? $wcpoa_order_status[$wcpoa_attachments_id] : array();
                                        $wcpoa_order_status_new = str_replace('wcpoa-', '', $wcpoa_order_status_val);
                                        $wcpoa_expired_dates = isset($wcpoa_order_attachment_expired[$key]) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '';
                                        $attachment_id = $wcpoa_attachment_file; // ID of attachment

                                        echo '<table class="wcpoa_order">';
                                        echo '<tbody>';
                                        $wcpoa_attachment_expired_date = strtotime($wcpoa_expired_dates);


                                        $attachment_order_name = '<h3 class="wcpoa_attachment_name">' . $attachment_name . '</h3>';
                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                        if ( wpap_fs()->is__premium_only() ) {
                                            if ( wpap_fs()->can_use_premium_code() ) {
                                                if($wcpoa_attachment_type === "file_upload"){
                                                    $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                                }elseif($wcpoa_attachment_type === "external_ulr"){
                                                    $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_attachment_ext_url.'" download>Download</a>';
                                                }
                                            }else{
                                                $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                            }        
                                        }else{
                                            $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow">Download</a>';
                                        }    
                                        $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">Download</a>';
                                        $wcpoa_expire_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expire Date Is :: ') . $wcpoa_expired_dates . '</p>';
                                        $wcpoa_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expired') . '</p>';
                                        $wcpoa_never_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Is Never Expire') . '</p>';
                                        if (!empty($wcpoa_attachment_expired_date)) {
                                            if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                            } else {
                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                                           }
                                        } else {
                                            echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                            echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                            echo wp_kses($wcpoa_never_expired_date_text,$this->allowed_html_tags());
                                               
                                        }
                                        echo '<div class="wcpoa-order-status">';
                                        foreach ($order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_value) {

                                            if (in_array($wcpoa_order_status_key, $wcpoa_order_status_new,true)) {
                                                $order_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_value . '</h4>';
                                               echo wp_kses($order_status_available,$this->allowed_html_tags());
                                            } elseif (empty($wcpoa_order_status_new)) {
                                                $order_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_value . '</h4>';
                                                echo wp_kses($order_status_available,$this->allowed_html_tags());
                                            } else {
                                                $order_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_value . '</h4>';
                                                echo wp_kses($order_status_available,$this->allowed_html_tags());
                                            }
                                        }
                                        echo '</div>';
                                        echo '</tbody>';
                                        echo '</table>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        endif;
        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                //Bulk Attachement
                $wcpoa_bulk_att_data = get_option('wcpoa_bulk_attachment_data');

                if (!empty($items) && is_array($items)) {
                    $wcpoa_bulk_att_match = 'no';
                    foreach ($items as $key => $item_value) {
                        // for all product
                        if (!empty($wcpoa_bulk_att_data) && is_array($wcpoa_bulk_att_data)) {

                            foreach ($wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values) {
                                
                                if( 'no' === $wcpoa_bulk_att_values['wcpoa_is_condition'] ){

                                    if (!in_array($att_new_key, $wcpoa_all_att_values_product_key,true)) {
                                        
                                        $wcpoa_all_att_values_product_key[] = $att_new_key;
                                        $wcpoa_attachments_bulk_id = !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '';
                                        $wcpoa_bulk_applied_product = !empty($wcpoa_bulk_att_values['wcpoa_product_list']) ? $wcpoa_bulk_att_values['wcpoa_product_list'] : array();
                                        $wcpoa_bulk_applied_cat = !empty($wcpoa_bulk_att_values['wcpoa_category_list']) ? $wcpoa_bulk_att_values['wcpoa_category_list'] : array();
                                        $wcpoa_bulk_attachments_name = isset($wcpoa_bulk_att_values['wcpoa_attachment_name']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '';
                                        

                                        $wcpoa_bulk_attachment_type = isset($wcpoa_bulk_att_values['wcpoa_attach_type']) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '';
                                        if($wcpoa_bulk_attachment_type === "file_upload"){
                                            $wcpoa_bulk_attachment_file = isset($wcpoa_bulk_att_values['wcpoa_attachment_file']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '';
                                        }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                            $wcpoa_bulk_attachment_url = isset($wcpoa_bulk_att_values['wcpoa_attachment_url']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_url']) ? $wcpoa_bulk_att_values['wcpoa_attachment_url'] : '';
                                        }

                                                
                                        $wcpoa_expired_dates = isset($wcpoa_bulk_att_values['wcpoa_expired_date']) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '';
                                        $wcpoa_order_bulk_status = isset($wcpoa_bulk_att_values['wcpoa_order_status']) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '';
                                        $wcpoa_attachments_name = '<h3 class="wcpoa_attachment_name">' . esc_html__($wcpoa_bulk_attachments_name, $wcpoa_text_domain) . '</h3>';
                                        if($wcpoa_bulk_attachment_type === "file_upload"){
                                            $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . ' rel="nofollow">Download</a>';
                                        }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                            $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_bulk_attachment_url.'" download> Download </a>';
                                        }
                                        $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> Download </a>';
                                        $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expired.', $wcpoa_text_domain) . '</p>';
                                        $wcpoa_bulk_never_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Never Expires.', $wcpoa_text_domain) . '</p>';
                                        $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expiry Date :: ', $wcpoa_text_domain) . $wcpoa_expired_dates . '</p>';
                                        $wcpoa_order_status_bulknew = str_replace('wcpoa-wc-', '', $wcpoa_order_bulk_status);
                                        $wcpoa_order_status_bulknew_val = !empty($wcpoa_order_status_bulknew) ? $wcpoa_order_status_bulknew : array();

                                        if (!empty($wcpoa_expired_dates)) {
                                            if ($wcpoa_today_date > $wcpoa_expired_dates) {
                                                echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_file_expired_url_btn,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_expired_date_text,$this->allowed_html_tags());
                                           
                                                $wcpoa_bulk_att_match = 'yes';
                                            } else {
                                                echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_expire_date_text,$this->allowed_html_tags());
                                           
                                                $wcpoa_bulk_att_match = 'yes';
                                            }
                                        } else {
                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                            echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                            echo wp_kses($wcpoa_bulk_never_expired_date_text,$this->allowed_html_tags());
                                           
                                            $wcpoa_bulk_att_match = 'yes';
                                        }
                                        if (isset($order_statuses) && is_array($order_statuses)):
                                            echo '<div class="wcpoa-order-status">';
                                            foreach ($order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_bulkvalue) {
                                                $wcpoa_order_status_key_new = str_replace('wc-', '', $wcpoa_order_status_key);
                                                if (in_array($wcpoa_order_status_key_new, $wcpoa_order_status_bulknew_val,true)) {
                                                    $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                    echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());

                                                } elseif (empty($wcpoa_order_status_bulknew_val)) {
                                                    $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                    echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                } else {
                                                    $bulkorder_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                    echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                }
                                            }
                                            echo '</div>';
                                        endif;  
                                    }
                                }    
                            }
                        }  

                        $terms = get_the_terms($item_value['product_id'], 'product_cat'); //Product Category Get
                        $wcpoa_bulk_att_values = array();
                        if (!empty($terms) && is_array($terms)) {
                            foreach ($terms as $term) {
                                $product_cat_id = $term->term_id;
                                $parent_category = $term->parent;
                                if (!empty($wcpoa_bulk_att_data) && is_array($wcpoa_bulk_att_data)) {

                                    foreach ($wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values) {
                                        if( 'yes' === $wcpoa_bulk_att_values['wcpoa_is_condition'] ){

                                            if (!in_array($att_new_key, $wcpoa_att_values_key,true)) {    
                                                $wcpoa_att_values_key[] = $att_new_key;
                                                $wcpoa_attachments_bulk_id = !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '';
                                                $wcpoa_bulk_applied_cat = !empty($wcpoa_bulk_att_values['wcpoa_category_list']) ? $wcpoa_bulk_att_values['wcpoa_category_list'] : array();
                                                $wcpoa_bulk_attachments_name = isset($wcpoa_bulk_att_values['wcpoa_attachment_name']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '';
                                                
                                                $wcpoa_bulk_attachment_type = isset($wcpoa_bulk_att_values['wcpoa_attach_type']) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '';
                                                if($wcpoa_bulk_attachment_type === "file_upload"){
                                                    $wcpoa_bulk_attachment_file = isset($wcpoa_bulk_att_values['wcpoa_attachment_file']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '';
                                                }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                                    $wcpoa_bulk_attachment_url = isset($wcpoa_bulk_att_values['wcpoa_attachment_url']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_url']) ? $wcpoa_bulk_att_values['wcpoa_attachment_url'] : '';
                                                }


                                                $wcpoa_expired_dates = isset($wcpoa_bulk_att_values['wcpoa_expired_date']) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '';
                                                $wcpoa_order_bulk_status = isset($wcpoa_bulk_att_values['wcpoa_order_status']) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '';
                                                $wcpoa_attachments_name = '<h3 class="wcpoa_attachment_name">' . esc_html__($wcpoa_bulk_attachments_name, $wcpoa_text_domain) . '</h3>';

                                                if($wcpoa_bulk_attachment_type === "file_upload"){
                                                    $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . ' rel="nofollow">Download</a>';
                                                }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                                    $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_bulk_attachment_url.'" download> Download</a>';
                                                }

                                                $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> Download </a>';
                                                $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expired.', $wcpoa_text_domain) . '</p>';
                                                $wcpoa_bulk_never_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Never Expires.', $wcpoa_text_domain) . '</p>';
                                                $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expiry Date :: ', $wcpoa_text_domain) . $wcpoa_expired_dates . '</p>';
                                                $wcpoa_order_status_bulknew = str_replace('wcpoa-wc-', '', $wcpoa_order_bulk_status);
                                                $wcpoa_order_status_bulknew_val = !empty($wcpoa_order_status_bulknew) ? $wcpoa_order_status_bulknew : array();

                                                if (in_array((int)$product_cat_id, convert_array_to_int($wcpoa_bulk_applied_cat),true) || in_array((int)$parent_category, convert_array_to_int($wcpoa_bulk_applied_cat),true)) {

                                                    if (!empty($wcpoa_expired_dates)) {
                                                        if ($wcpoa_today_date > $wcpoa_expired_dates) {
                                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_file_expired_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_expired_date_text,$this->allowed_html_tags());
                                                            $wcpoa_bulk_att_match = 'yes';
                                                        } else {
                                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_expire_date_text,$this->allowed_html_tags());

                                                            $wcpoa_bulk_att_match = 'yes';
                                                        }
                                                    } else {

                                                        echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_bulk_never_expired_date_text,$this->allowed_html_tags());
                                                        $wcpoa_bulk_att_match = 'yes';
                                                    }
                                                    if (isset($order_statuses) && is_array($order_statuses)):
                                                        echo '<div class="wcpoa-order-status">';
                                                        foreach ($order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_bulkvalue) {
                                                            $wcpoa_order_status_key_new = str_replace('wc-', '', $wcpoa_order_status_key);
                                                            if (in_array($wcpoa_order_status_key_new, $wcpoa_order_status_bulknew_val,true)) {
                                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                                echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            } elseif (empty($wcpoa_order_status_bulknew_val)) {
                                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                                echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            } else {
                                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                                echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            }
                                                        }
                                                        echo '</div>';
                                                    endif;
                                                }
                                            }
                                        }    
                                    }
                                }
                            }
                        }
                        // Product
                        if (!empty($wcpoa_bulk_att_data) && is_array($wcpoa_bulk_att_data)) {
                            foreach ($wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values) {
                                if( 'yes' === $wcpoa_bulk_att_values['wcpoa_is_condition'] ){
                                    if (!in_array($att_new_key, $wcpoa_att_values_product_key,true)) {
                                        $wcpoa_att_values_product_key[] = $att_new_key;
                                        $wcpoa_attachments_bulk_id = !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '';
                                        $wcpoa_bulk_applied_product = !empty($wcpoa_bulk_att_values['wcpoa_product_list']) ? $wcpoa_bulk_att_values['wcpoa_product_list'] : array();
                                        $wcpoa_bulk_applied_cat = !empty($wcpoa_bulk_att_values['wcpoa_category_list']) ? $wcpoa_bulk_att_values['wcpoa_category_list'] : array();
                                        $wcpoa_bulk_attachments_name = isset($wcpoa_bulk_att_values['wcpoa_attachment_name']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '';
                                        

                                        $wcpoa_bulk_attachment_type = isset($wcpoa_bulk_att_values['wcpoa_attach_type']) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '';
                                        if($wcpoa_bulk_attachment_type === "file_upload"){
                                            $wcpoa_bulk_attachment_file = isset($wcpoa_bulk_att_values['wcpoa_attachment_file']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '';
                                        }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                            $wcpoa_bulk_attachment_url = isset($wcpoa_bulk_att_values['wcpoa_attachment_url']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_url']) ? $wcpoa_bulk_att_values['wcpoa_attachment_url'] : '';
                                        }

                                                
                                        $wcpoa_expired_dates = isset($wcpoa_bulk_att_values['wcpoa_expired_date']) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '';
                                        $wcpoa_order_bulk_status = isset($wcpoa_bulk_att_values['wcpoa_order_status']) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '';
                                        $wcpoa_attachments_name = '<h3 class="wcpoa_attachment_name">' . esc_html__($wcpoa_bulk_attachments_name, $wcpoa_text_domain) . '</h3>';
                                        if($wcpoa_bulk_attachment_type === "file_upload"){
                                            $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . ' rel="nofollow">Download</a>';
                                        }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                            $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_bulk_attachment_url.'" download> Download </a>';
                                        }
                                        $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> Download </a>';
                                        $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expired.', $wcpoa_text_domain) . '</p>';
                                        $wcpoa_bulk_never_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Never Expires.', $wcpoa_text_domain) . '</p>';
                                        $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expiry Date :: ', $wcpoa_text_domain) . $wcpoa_expired_dates . '</p>';
                                        $wcpoa_order_status_bulknew = str_replace('wcpoa-wc-', '', $wcpoa_order_bulk_status);
                                        $wcpoa_order_status_bulknew_val = !empty($wcpoa_order_status_bulknew) ? $wcpoa_order_status_bulknew : array();


                                        if (in_array((int)$item_value['product_id'], convert_array_to_int($wcpoa_bulk_applied_product),true)) {

                                            $product_cats_id = array();
                                            if (!empty($terms)) {
                                                foreach ($terms as $term) {
                                                    $product_cats_id[] = $term->term_id;
                                                }

                                                if (!array_intersect($product_cats_id, $wcpoa_bulk_applied_cat)) {
                                                    if (!empty($wcpoa_expired_dates)) {
                                                        if ($wcpoa_today_date > $wcpoa_expired_dates) {
                                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_file_expired_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_expired_date_text,$this->allowed_html_tags());
                                                       
                                                            $wcpoa_bulk_att_match = 'yes';
                                                        } else {
                                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_expire_date_text,$this->allowed_html_tags());
                                                       
                                                            $wcpoa_bulk_att_match = 'yes';
                                                        }
                                                    } else {
                                                        echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_bulk_never_expired_date_text,$this->allowed_html_tags());
                                                       
                                                        $wcpoa_bulk_att_match = 'yes';
                                                    }
                                                    if (isset($order_statuses) && is_array($order_statuses)):
                                                        echo '<div class="wcpoa-order-status">';
                                                        foreach ($order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_bulkvalue) {
                                                            $wcpoa_order_status_key_new = str_replace('wc-', '', $wcpoa_order_status_key);
                                                            if (in_array($wcpoa_order_status_key_new, $wcpoa_order_status_bulknew_val,true)) {
                                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                                echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());

                                                            } elseif (empty($wcpoa_order_status_bulknew_val)) {
                                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                                echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            } else {
                                                                $bulkorder_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                                echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            }
                                                        }
                                                        echo '</div>';
                                                    endif;
                                                }
                                            }     
                                            
                                        }
                                    }
                                }

                            }
                        }
                        //Tag Attachements
                        $tag_terms = get_the_terms($item_value['product_id'], 'product_tag'); //Product Tag Get
                        $wcpoa_att_values_tag_key = array();
                        if (!empty($tag_terms) && is_array($tag_terms)) {

                            foreach ($tag_terms as $tag_term) {
                                $product_tag_id = $tag_term->term_id;
                                if (!empty($wcpoa_bulk_att_data)) {

                                    foreach ($wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values) {
                                        if( 'yes' === $wcpoa_bulk_att_values['wcpoa_is_condition'] ){
                                            if (!in_array($att_new_key, $wcpoa_att_values_tag_key,true) && $wcpoa_bulk_att_match !== 'yes') {
                                                $wcpoa_attachments_bulk_id = !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '';
                                                $wcpoa_bulk_applied_tag = !empty($wcpoa_bulk_att_values['wcpoa_tag_list']) ? $wcpoa_bulk_att_values['wcpoa_tag_list'] : array();
                                                $wcpoa_bulk_attachments_name = isset($wcpoa_bulk_att_values['wcpoa_attachment_name']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '';
                                                $wcpoa_bulk_attachment_file = isset($wcpoa_bulk_att_values['wcpoa_attachment_file']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '';
                                                $wcpoa_expired_dates = isset($wcpoa_bulk_att_values['wcpoa_expired_date']) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '';
                                                $wcpoa_order_bulk_status = isset($wcpoa_bulk_att_values['wcpoa_order_status']) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '';
                                                $wcpoa_attachments_name = '<h3 class="wcpoa_attachment_name">' . esc_html__($wcpoa_bulk_attachments_name, $wcpoa_text_domain) . '</h3>';
                                                $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . ' rel="nofollow">Download</a>';
                                                $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> Download </a>';
                                                $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expired.', $wcpoa_text_domain) . '</p>';
                                                $wcpoa_bulk_never_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Never Expires.', $wcpoa_text_domain) . '</p>';
                                                $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expiry Date :: ', $wcpoa_text_domain) . $wcpoa_expired_dates . '</p>';
                                                $wcpoa_order_status_bulknew = str_replace('wcpoa-wc-', '', $wcpoa_order_bulk_status);
                                                $wcpoa_order_status_bulknew_val = !empty($wcpoa_order_status_bulknew) ? $wcpoa_order_status_bulknew : array();
                                                if (in_array((int)$product_tag_id, convert_array_to_int($wcpoa_att_values_tag_key),true)) {
                                                    $wcpoa_att_values_tag_key[] = $att_new_key;
                                                }
                                                if (in_array((int)$product_tag_id, convert_array_to_int($wcpoa_bulk_applied_tag),true) || in_array((int)$parent_category, convert_array_to_int($wcpoa_bulk_applied_tag),true)) {
                                                    if (!empty($wcpoa_expired_dates)) {
                                                        if ($wcpoa_today_date > $wcpoa_expired_dates) {
                                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_file_expired_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_expired_date_text,$this->allowed_html_tags());
                                                       
                                                        } else {
                                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_expire_date_text,$this->allowed_html_tags());
                                                       
                                                        }
                                                    } else {
                                                        echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_bulk_never_expired_date_text,$this->allowed_html_tags());
                                                       
                                                    }

                                                    echo '<div class="wcpoa-order-status">';
                                                    foreach ($order_statuses as $wcpoa_order_status_key => $wcpoa_order_status_bulkvalue) {
                                                        $wcpoa_order_status_key_new = str_replace('wc-', '', $wcpoa_order_status_key);
                                                        if (in_array($wcpoa_order_status_key_new, $wcpoa_order_status_bulknew_val,true)) {
                                                            $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                            echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            
                                                        } elseif ($wcpoa_order_status_bulknew_val) {
                                                            $bulkorder_status_available = '<h4><span class="dashicons dashicons-yes"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                            echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            
                                                        } else {
                                                            $bulkorder_status_available = '<h4><span class="dashicons dashicons-no"></span>' . $wcpoa_order_status_bulkvalue . '</h4>';
                                                            echo wp_kses($bulkorder_status_available,$this->allowed_html_tags());
                                                            
                                                        }
                                                    }
                                                    echo '</div>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /*
     * Bulk Attachment
     */

    public function wcpoa_bulk_attachment__premium_only()
    {

        $submitwcpoabulkatt=filter_input(INPUT_POST,'submitwcpoabulkatt', FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($submitwcpoabulkatt) && !empty($submitwcpoabulkatt)) {
            $this->wcpoa_bulk_attachment_data_save();
        }
        $screen = 'woocommerce_product_bulk_attachment_options';
        $plugin_txt_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        require_once(plugin_dir_path( __FILE__ )."partials/header/plugin-header.php");

        ?>
        <div class="wrap">

            <h2><?php esc_html_e('WooCommerce Product Bulk Attachments', $plugin_txt_domain); ?></h2>

            <form id="post" name="post" method="post" novalidate="novalidate">
                <input type="hidden" name="post_type" value="wcpoa_bulk_att">
                <?php
                wp_nonce_field('some-action-nonce');

                /* Used to save closed meta boxes and their order */
                wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
                wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
                ?>

                <div id="poststuff">

                    <div id="post-body"
                         class="metabox-holder columns-<?php echo 1 === (int)get_current_screen()->get_columns() ? '1' : '2'; ?>">

                        <div id="postbox-container-1" class="postbox-container">
                            <?php do_meta_boxes($screen, 'side', null); ?>
                        </div>

                        <div id="postbox-container-2" class="postbox-container">
                            <?php do_meta_boxes($screen, 'normal', null); ?>
                        </div>

                    </div> <!-- #post-body -->

                </div> <!-- #poststuff -->

            </form>

        </div><!-- .wrap -->

        <?php
    }

    public function wcpoa_add_my_meta_box__premium_only()
    {
        $plugin_txt_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        $screen = 'woocommerce_product_bulk_attachment_options';
        add_meta_box('wcpoasubmitdiv', __('Publish', $plugin_txt_domain), array($this, 'wcpoa_bulk_submitdiv'), $screen, 'side', 'high');
        add_meta_box('wcpoa_bulk_att', __('WooCommerce Product Attachment', $plugin_txt_domain), array($this, 'wcpoa_bulk_attachement__premium_only'), $screen, 'normal', 'high');
    }

    public function wcpoa_bulk_attachement__premium_only()
    {
        require_once(plugin_dir_path( __FILE__ )."partials/wcpoa-bulk-attachement-add.php");
    }

    /* Prints script in footer. This 'initialises' the meta boxes */

    function wcpoa_print_script_in_footer()
    {
        ?>
        <script>jQuery(document).ready(function () {
                postboxes.add_postbox_toggles(pagenow);
            });</script>
        <?php
    }

    function wcpoa_bulk_submitdiv($post, $args)
    {
        ?>
        <div id="major-publishing-actions">

            <div id="publishing-action">
                <span class="spinner"></span>
                <input type="submit" accesskey="p" value="Publish"
                       class="button button-primary button-large" id="publish" name="submitwcpoabulkatt">
            </div>

            <div class="clear"></div>

        </div>
        <?php
    }
    /**
     * Function for select product list
     *
     */
    public function wcpoa_get_product_list__premium_only($wcpoa_product_list_selected = array()){
        $html = '';
        $orderby = 'name';
        $order = 'asc';

        $product_query = new WC_Product_Query( array(
            'orderby' => $orderby,
            'order' => $order,
            'status' => 'publish',
            'posts_per_page' => -1,
        ) );
        $product_list = $product_query->get_products();

        if (!empty($product_list)) {
            foreach ($product_list as $get_all_product) {

                $html .= is_array($wcpoa_product_list_selected) && !empty($wcpoa_product_list_selected) && in_array((int)$get_all_product->get_id(), convert_array_to_int($wcpoa_product_list_selected),true) ? '<option value="' . $get_all_product->get_id() . '" selected>' . $get_all_product->get_name(). '</option>' : '';


            }
        }
        return $html;

    }
    /**
     * Function for select cat list
     *
     */
    public function wcpoa_get_category_list__premium_only($wcpoa_category_list_selected = array())
    {

        global $sitepress;
        $html = '';
        $orderby = 'name';
        $order = 'asc';
        $hide_empty = false;
        $cat_args = array(
            'orderby' => $orderby,
            'order' => $order,
            'hide_empty' => $hide_empty,
        );
        $default_lang='';
        $product_categories = get_terms('product_cat', $cat_args);
        if (!empty($product_categories)) {
            foreach ($product_categories as  $get_all_category) {
                if (!empty($sitepress)) {
                    $new_cat_id = apply_filters('wpml_object_id', $get_all_category->term_id, 'product_cat', TRUE, $default_lang);
                } else {
                    $new_cat_id = $get_all_category->term_id;
                }
                $parent_category = get_term_by('id', $get_all_category->parent, 'product_cat');
                
                $selectedVal = is_array($wcpoa_category_list_selected) && !empty($wcpoa_category_list_selected) && in_array((int)$new_cat_id, convert_array_to_int($wcpoa_category_list_selected),true) ? 'selected=selected' : '';

                $category = get_term_by('id', $new_cat_id, 'product_cat');
                if ($category->parent > 0) {
                    $html .= '<option value="' . $get_all_category->term_id . '" ' . $selectedVal . '>' . '#' . $parent_category->name . '->' . $get_all_category->name . '</option>';
                } else {
                    $html .= '<option value="' . $get_all_category->term_id . '" ' . $selectedVal . '>' . $get_all_category->name . '</option>';
                }
            }
        }
        return $html;
    }

    /**
     * Function for select cat list
     *
     */
    public function wcpoa_get_tag_list__premium_only($wcpoa_tag_list_selected = array())
    {
        global $sitepress;
        $html = '';
        $orderby = 'name';
        $order = 'asc';
        $hide_empty = false;
        $cat_args = array(
            'orderby' => $orderby,
            'order' => $order,
            'hide_empty' => $hide_empty,
        );
        $default_lang='';
        $product_tags = get_terms('product_tag', $cat_args);
        if (!empty($product_tags) && is_array($product_tags)) {
            foreach ($product_tags as $get_all_tag) {
                if (!empty($sitepress)) {
                    $new_cat_id = apply_filters('wpml_object_id', $get_all_tag->term_id, 'product_cat', TRUE, $default_lang);
                } else {
                    $new_cat_id = $get_all_tag->term_id;
                }

                $html .= is_array($wcpoa_tag_list_selected) && !empty($wcpoa_tag_list_selected) && in_array((int)$new_cat_id, convert_array_to_int($wcpoa_tag_list_selected),true) ? '<option value="' . $get_all_tag->term_id . '" selected>' . $get_all_tag->name . '</option>' : '';

                
            }
        }
        return $html;
    }

    /**
     * Save option for bulk attachment data save.
     *
     *
     */
        public function wcpoa_bulk_attachment_data_save()
    {
        $wcpoa_attachments_id=filter_input(INPUT_POST,'wcpoa_attachments_id', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

        unset($wcpoa_attachments_id[count($wcpoa_attachments_id)-1]);

        $wcpoa_attachments_id = !empty($wcpoa_attachments_id) ? $wcpoa_attachments_id : '';

        $wcpoa_attachment_name=filter_input(INPUT_POST,'wcpoa_attachment_name', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_attachment_name = !empty($wcpoa_attachment_name) ? $wcpoa_attachment_name : '';

        $wcpoa_attach_type=filter_input(INPUT_POST,'wcpoa_attach_type', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_attach_type = !empty($wcpoa_attach_type) ? $wcpoa_attach_type : '';

        $wcpoa_attachment_file=filter_input(INPUT_POST,'wcpoa_attachment_file', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_attachment_file = !empty($wcpoa_attachment_file) ? $wcpoa_attachment_file : '';
        
        $wcpoa_attachment_url=filter_input(INPUT_POST,'wcpoa_attachment_url', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_attachment_ext_url = !empty($wcpoa_attachment_url) ? $wcpoa_attachment_url : '';
        
        $wcpoa_attachment_description=filter_input(INPUT_POST,'wcpoa_attachment_description', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_attachment_description = !empty($wcpoa_attachment_description) ? $wcpoa_attachment_description : '';

        $wcpoa_order_status=filter_input(INPUT_POST,'wcpoa_order_status', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_order_status_all = !empty($wcpoa_order_status) ? $wcpoa_order_status : '';

        $wcpoa_product_list=filter_input(INPUT_POST,'wcpoa_product_list', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_product_list = !empty($wcpoa_product_list) ? $wcpoa_product_list : '';

        $wcpoa_category_list=filter_input(INPUT_POST,'wcpoa_category_list', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_category_list = !empty($wcpoa_category_list) ? $wcpoa_category_list : '';

        $wcpoa_assignment=filter_input(INPUT_POST,'wcpoa_assignment', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_assignment = !empty($wcpoa_assignment) ? $wcpoa_assignment : '';

        $wcpoa_tag_list=filter_input(INPUT_POST,'wcpoa_tag_list', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_tag_list = !empty($wcpoa_tag_list) ? $wcpoa_tag_list : '';
        
        $wcpoa_apply_cat=filter_input(INPUT_POST,'wcpoa_apply_cat', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_apply_cat = !empty($wcpoa_apply_cat) ? $wcpoa_apply_cat : '';
        
        $wcpoa_att_visibility=filter_input(INPUT_POST,'wcpoa_att_visibility', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_att_visibility = !empty($wcpoa_att_visibility) ? $wcpoa_att_visibility : '';

        $wcpoa_is_condition=filter_input(INPUT_POST,'wcpoa_is_condition', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_is_condition = !empty($wcpoa_is_condition) ? $wcpoa_is_condition : '';
        
        $wcpoa_expired_date_enable=filter_input(INPUT_POST,'wcpoa_expired_date_enable', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $wcpoa_expired_date_enable = !empty($wcpoa_expired_date_enable) ? $wcpoa_expired_date_enable : '';

        if($wcpoa_expired_date_enable){
            $wcpoa_attachment_time_amount=filter_input(INPUT_POST,'wcpoa_attachment_time_amount', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_attachment_time_amount = !empty($wcpoa_attachment_time_amount) ? $wcpoa_attachment_time_amount : '';

            $wcpoa_attachment_time_type=filter_input(INPUT_POST,'wcpoa_attachment_time_type', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_attachment_time_type = !empty($wcpoa_attachment_time_type) ? $wcpoa_attachment_time_type : '';

            $wcpoa_expired_date=filter_input(INPUT_POST,'wcpoa_expired_date', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
            $wcpoa_expired_date = !empty($wcpoa_expired_date) ? $wcpoa_expired_date : '';
        }
        $wcpoa_bulk_attachment_array=[];
        if (!empty($wcpoa_attachments_id) && is_array($wcpoa_attachments_id)) {
            $wcpoa_bulk_attachment_array=[];
            foreach ($wcpoa_attachments_id as $wcpoa_bulk_key => $wcpoa_bulk_key_value) {

                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachments_id'] = $wcpoa_attachments_id[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_is_condition'] = $wcpoa_is_condition[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_name'] = $wcpoa_attachment_name[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attach_type'] = $wcpoa_attach_type[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_file'] = $wcpoa_attachment_file[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_url'] = $wcpoa_attachment_ext_url[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_description'] = $wcpoa_attachment_description[$wcpoa_bulk_key];
                if (empty($wcpoa_order_status_all[$wcpoa_bulk_key_value])) {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_order_status'] = array();
                } else {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_order_status'] = $wcpoa_order_status_all[$wcpoa_bulk_key_value];
                }
                
                $wcpoa_attachment_time_amount=filter_input(INPUT_POST,'wcpoa_attachment_time_amount', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                $wcpoa_attachment_time_amount = !empty($wcpoa_attachment_time_amount) ? $wcpoa_attachment_time_amount : '';

                $wcpoa_attachment_time_type=filter_input(INPUT_POST,'wcpoa_attachment_time_type', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                $wcpoa_attachment_time_type = !empty($wcpoa_attachment_time_type) ? $wcpoa_attachment_time_type : '';

                $wcpoa_expired_date=filter_input(INPUT_POST,'wcpoa_expired_date', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                $wcpoa_expired_date = !empty($wcpoa_expired_date) ? $wcpoa_expired_date : '';

                if (empty($wcpoa_category_list[$wcpoa_bulk_key_value])) {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_category_list'] = array();
                } else {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_category_list'] = $wcpoa_category_list[$wcpoa_bulk_key_value];
                }
                if (empty($wcpoa_product_list[$wcpoa_bulk_key_value])) {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_product_list'] = array();
                } else {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_product_list'] = $wcpoa_product_list[$wcpoa_bulk_key_value];
                }


                if (empty($wcpoa_tag_list[$wcpoa_bulk_key_value])) {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_tag_list'] = array();
                } else {
                    $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_tag_list'] = $wcpoa_tag_list[$wcpoa_bulk_key_value];
                }

                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_assignment'] = $wcpoa_assignment[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_apply_cat'] = $wcpoa_apply_cat[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_att_visibility'] = $wcpoa_att_visibility[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_expired_date_enable'] = $wcpoa_expired_date_enable[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_expired_date'] = $wcpoa_expired_date[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_time_amount'] = $wcpoa_attachment_time_amount[$wcpoa_bulk_key];
                $wcpoa_bulk_attachment_array[$wcpoa_bulk_key_value]['wcpoa_attachment_time_type'] = $wcpoa_attachment_time_type[$wcpoa_bulk_key];
            }
        }
        update_option('wcpoa_bulk_attachment_data', $wcpoa_bulk_attachment_array);
    }

    public function misha_image_uploader_field( $attachment_id='') {
        $image = ' button">Upload image';
        return '
        <div>
            <a href="#" data-id="'.esc_attr($attachment_id).'" class="misha_upload_image_button' . $image . '</a>
           
        </div>';
    }
    public function get_product_ajax__premium_only(){
        $s=filter_input(INPUT_GET,'search',FILTER_SANITIZE_SPECIAL_CHARS);
        $product_args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            's' => $s,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'show_posts' => -1
        );
        $results=[];
        $wp_query = new WP_Query($product_args);
        while($wp_query->have_posts()){
            $wp_query->the_post();
            $results[]=['id' => $wp_query->post->ID,'text' => get_the_title()];
        }
        echo wp_json_encode([
            "results"=>$results,
            "pagination"=>[
                "more"=> true
            ]
        ]);
        die;
    }
    public function get_category_ajax__premium_only(){
        $s=filter_input(INPUT_GET,'search',FILTER_SANITIZE_SPECIAL_CHARS);
        $args = array(
            'taxonomy'      => array( 'product_cat' ), // taxonomy name
            'orderby'       => 'id', 
            'order'         => 'ASC',
            'hide_empty'    => false,
            'fields'        => 'all',
            'name__like'    =>  $s
        ); 
        $results=[];
        $terms = get_terms( $args );
        foreach ($terms as  $term) {
            $results[]=['id' => $term->term_id,'text' => $term->name];
        }
        echo wp_json_encode([
            "results"=>$results,
            "pagination"=>[
                "more"=> true
            ]
        ]);
        die;
    }
    public function get_tag_ajax__premium_only(){
        $s=filter_input(INPUT_GET,'search',FILTER_SANITIZE_SPECIAL_CHARS);
        $args = array(
            'taxonomy'      => array( 'product_tag' ), // taxonomy name
            'orderby'       => 'id', 
            'order'         => 'ASC',
            'hide_empty'    => false,
            'fields'        => 'all',
            'name__like'    =>  $s
        ); 
        $results=[];
        $terms = get_terms( $args );
        foreach ($terms as  $term) {
            $results[]=['id' => $term->term_id,'text' => $term->name];
        }
        echo wp_json_encode([
            "results"=>$results,
            "pagination"=>[
                "more"=> true
            ]
        ]);
        die;
    }
    public function allowed_html_tags($tags=array()){
            $allowed_tags=array(
            'a' => array('href' => array(),'title' => array(),'data-id' => array(),'class' => array()),
            'p' => array('href' => array(),'title' => array(),'class' => array()),
            'span' => array('href' => array(),'title' => array(),'class' => array()),
            'ul' => array('class' => array()),
            'img' => array('href' => array(),'title' => array(),'class' => array(),'src' => array()),
            'li' => array('class' => array()),
            'h1' => array('id' => array(),'name'=> array(),'class' => array()),
            'h2' => array('id' => array(),'name'=> array(),'class' => array()),
            'h3' => array('id' => array(),'name'=> array(),'class' => array()),
            'h4' => array('id' => array(),'name'=> array(),'class' => array()),
            'div' => array('class' => array(),'id' => array(),"data-max" => array(),"data-min" => array(),"stlye" => array() ,"data-name" => array(), "data-type" => array(), "data-key" => array()),
            'select' => array('id' => array(),'name'=> array(),'class' => array(),'multiple' => array(),'style' => array()),
            'input' => array('id' => array(),'value'=>array(),'name'=> array(),'class' => array(),'type' => array()),
            'textarea' => array('id' => array(),'name'=> array(),'class' => array()),
            'td' => array('id' => array(),'name'=> array(),'class' => array()),
            'tr' => array('id' => array(),'name'=> array(),'class' => array()),
            'tbody' => array('id' => array(),'name'=> array(),'class' => array()),
            'table' => array('id' => array(),'name'=> array(),'class' => array()),
            'option' => array('id' => array(),'selected'=>array(),'name'=> array(),'value' => array()),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'label' => array('for'=> array()),
            ); 
            if(!empty($tags)){
                foreach ($tags as $key => $value) {
                    $allowed_tags[$key]=$value;
                }            
            }
            return $allowed_tags;
    }

}

