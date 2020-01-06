<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Product_Attachment
 * @subpackage Woocommerce_Product_Attachment/public
 * @author     multidots <nirav.soni@multidots.com>
 */
class Woocommerce_Product_Attachment_Public {

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
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-product-attachment-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

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
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-product-attachment-public.js', array('jquery'), $this->version, false);
    }

    // Start the download if there is a request for that
    function wcpoa_download_file() {
        $attachment_id=filter_input(INPUT_GET,'attachment_id',FILTER_SANITIZE_SPECIAL_CHARS);
        $download_file=filter_input(INPUT_GET,'download_file',FILTER_SANITIZE_SPECIAL_CHARS);
        $wcpoa_attachment_order_id=filter_input(INPUT_GET,'wcpoa_attachment_order_id',FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($attachment_id) && !empty($download_file) && !empty($wcpoa_attachment_order_id)) {
            $wcpoa_attachment_order_id = $wcpoa_attachment_order_id;
            $order = new WC_Order($wcpoa_attachment_order_id);
            $items = $order->get_items(array('line_item'));
            //Bulk Attachement 
            if (isset($items) && is_array($items)):
                
                foreach (array_keys($items) as $items_key) {

                    $wcpoa_order_attachment_items = wc_get_order_item_meta($items_key, 'wcpoa_order_attachment_order_arr', true);
                    $current_date = date("Y/m/d");
                    $wcpoa_today_date = strtotime($current_date);
                    $download_flag = 0;

                    if (!empty($wcpoa_order_attachment_items)) {

                        $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                        $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];

                        $wcpoa_order_attachment_expired_new = array();
                        $wcpoa_order_attachment_expired_new = array_combine($wcpoa_attachment_ids, $wcpoa_order_attachment_expired);

                        $download_file=filter_input(INPUT_GET,'download_file',FILTER_SANITIZE_SPECIAL_CHARS);
                        if (!empty($wcpoa_order_attachment_expired_new)) {
                            foreach ($wcpoa_order_attachment_expired_new as $attach_key => $attach_value) {
                                if ($attach_key === $download_file && ( (strtotime($attach_value) >= $wcpoa_today_date) || empty($attach_value) )) {
                                    $download_flag = 1;
                                }
                            }
                        }
                    }
                    if ( wpap_fs()->is__premium_only() ) {
                        if ( wpap_fs()->can_use_premium_code() ) {
                            $wcpoa_bulk_att_data = get_option('wcpoa_bulk_attachment_data');
                            if (!empty($wcpoa_bulk_att_data)) {
                                foreach ($wcpoa_bulk_att_data as $wcpoa_bulk_value) {
                                    $wcpoa_attachment_ids = !empty($wcpoa_bulk_value['wcpoa_attachments_id']) ? $wcpoa_bulk_value['wcpoa_attachments_id'] : array();
                                    $wcpoa_bulk_order_attachment_expired_new = $wcpoa_bulk_value['wcpoa_expired_date'];
                                    if ($wcpoa_attachment_ids === $download_file && ( (strtotime($wcpoa_bulk_order_attachment_expired_new) >= $wcpoa_today_date) || empty($wcpoa_bulk_order_attachment_expired_new) )) {
                                        $download_flag = 1;
                                    }
                                }
                            }
                        }
                    }

                    if ($download_flag === 1) {
                        $this->wcpoa_send_file();
                    }
                }
            endif;
            wp_die(sprintf(__('<strong>This Attachement is Expired.</strong> You are no longer to download this attachement.', 'woocommerce-product-attachment')));
        } else {
            $this->wcpoa_send_file();
        }
    }

    public function wcpoa_send_file() {
       $attachment_id=filter_input(INPUT_GET,'attachment_id',FILTER_SANITIZE_SPECIAL_CHARS);
       if (isset($attachment_id)) {
           $attID = $attachment_id;
           $theFile = wp_get_attachment_url($attID);
           if (!$theFile) {
               return;
           }
           //clean the fileurl
           $file_url = stripslashes(trim($theFile));
           //get filename
           $path_parts = pathinfo($file_url);
           $all_info_about_path = wp_parse_url($file_url);
           set_time_limit(0); // disable the time limit for this script
           $doc_root=filter_input(INPUT_SERVER,'DOCUMENT_ROOT',FILTER_SANITIZE_SPECIAL_CHARS);
           $path = $doc_root . $all_info_about_path['path']; // change the path to fit your websites document structure
           $fullPath = $path;
           if(get_option('wcpoa_is_viewable')){
                $wcpoa_is_viewable = get_option( 'wcpoa_is_viewable' );
                $pdf_download_mode = "attachment";
                if ( 'yes' === $wcpoa_is_viewable ) {
                    $pdf_download_mode = "inline";
                }
           }else{
                $pdf_download_mode = "attachment";
           }

           global $wp_filesystem;
           require_once ( ABSPATH . '/wp-admin/includes/file.php' );
           WP_Filesystem();
           if ( $wp_filesystem->exists( $fullPath ) ) {
               $fsize = filesize($fullPath);
               $path_parts = pathinfo($fullPath);
               $ext = strtolower($path_parts["extension"]);
               switch ($ext) {
                   case "pdf":
                       header("Content-type: application/pdf");
                       header("Content-Disposition: {$pdf_download_mode}; filename=\"" . $path_parts["basename"] . "\""); // use 'attachment' to force a file download
                       break;
                   case "jpg":
                       header("Content-type: image/jpg");
                       header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\""); // use 'attachment' to force a file download
                       header("Content-Length: $fsize");
                       break;
                   case "png":
                       header("Content-type: image/png");
                       header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\""); // use 'attachment' to force a file download
                       break;
                   // add more headers for other content types here
                   default;
                       header("Content-type: application/octet-stream");
                       header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
                       header('Accept-Ranges: bytes');
                       break;
               }
               header("Cache-control: private"); //use this to open files directly
               echo $wp_filesystem->get_contents( $fullPath ); //phpcs: ignore
           }
            exit;
       }
    }

    // Adds the new tab
    public function wcpoa_new_product_tab($tabs) {

        global $post;
        $product_id = $post->ID;
        $product_tab_name = get_option('wcpoa_product_tab_name');
        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                //Bulk Attachement 
                $wcpoa_bulk_att_data = get_option('wcpoa_bulk_attachment_data');
            }else{
                $wcpoa_bulk_att_data = "";
            }
        }else{
            $wcpoa_bulk_att_data = "";
        }
        $wcpoa_product_page_enable = get_post_meta($product_id, 'wcpoa_product_page_enable', true);

        if (!empty($wcpoa_product_page_enable) || !empty($wcpoa_bulk_att_data)) {
            $tabs['wcpoa_product_tab'] = array(
                'title' => $product_tab_name,
                'priority' => 50,
                'callback' => array($this, 'wcpoa_product_tab_content')
            );
            if (!empty($wcpoa_product_page_enable)) {
                foreach ($wcpoa_product_page_enable as $wcpoa_p_page_enable) {
 
                    if ($wcpoa_p_page_enable === 'yes') {

                        return $tabs;
                    }
                }
            }
            if (!empty($wcpoa_bulk_att_data)) {  
                return $tabs;
            }

        }
        return $tabs;             
    } 
    /*
     * The wcpoa_new_product_tab tab content
     */

    public function wcpoa_product_tab_content($attachment_id) {
        global  $post;
        $wcpoa_text_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        do_action('before_wcpoa_attachment_detail');
        // Product edit attachment.
        $product_id = $post->ID;
        $wcpoa_attachment_ids = get_post_meta($product_id, 'wcpoa_attachments_id', true);
        $wcpoa_attachment_name = get_post_meta($product_id, 'wcpoa_attachment_name', true);
        $wcpoa_attachment_description = get_post_meta($product_id, 'wcpoa_attachment_description', true);
        $wcpoa_product_page_enable = get_post_meta($product_id, 'wcpoa_product_page_enable', true);
        $wcpoa_attach_type = get_post_meta($product_id, 'wcpoa_attach_type', true);
        $wcpoa_attachment_ext_url = get_post_meta($product_id, 'wcpoa_attachment_ext_url', true);
        $wcpoa_attachment_url = get_post_meta($product_id, 'wcpoa_attachment_url', true);
        $wcpoa_expired_date_enable = get_post_meta($product_id, 'wcpoa_expired_date_enable', true);
        $wcpoa_expired_date = get_post_meta($product_id, 'wcpoa_expired_date', true);
        $get_permalink_structure = get_permalink();
        $wcpoa_expired_date_tlabel = get_option('wcpoa_expired_date_label');
        
        $user = wp_get_current_user();

        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                $wcpoa_attachments_action_on_click = get_option('wcpoa_attachments_action_on_click');
                $wcpoa_att_download_btn = get_option('wcpoa_att_download_btn');
                $wcpoa_att_download_restrict_flag = 0;
                $wcpoa_att_download_restrict = get_option('wcpoa_att_download_restrict');
                if ($wcpoa_att_download_restrict === 'wcpoa_att_download_loggedin') {
                    if (is_user_logged_in()) {
                        $wcpoa_att_download_restrict_flag = 1;
                    } else {
                        esc_html_e('Please Login To Download Attachment', $wcpoa_text_domain);
                    }
                } elseif ($wcpoa_att_download_restrict === 'wcpoa_att_download_guest') {
                    $wcpoa_att_download_restrict_flag = 1;
                }


                $wcpoa_att_download_visible_user = $user->roles;
                $prefixed_wcpoa_att_download_visible_user = preg_filter('/^/', 'wcpoa_att_download_', $wcpoa_att_download_visible_user);

                if( empty($wcpoa_att_download_restrict)){
                    $wcpoa_att_download_restrict_flag = 1; // apply for all users
                } elseif (in_array('wcpoa_att_download_guest', $wcpoa_att_download_restrict,true) && !is_user_logged_in()){
                    $wcpoa_att_download_restrict_flag = 1;  // apply for guest users
                } elseif (array_intersect($prefixed_wcpoa_att_download_visible_user, $wcpoa_att_download_restrict)) {
                    $wcpoa_att_download_restrict_flag = 1;  // apply for admin user roles which is set by admin side
                }else{
                    if (is_user_logged_in()) {
                        esc_html_e('Restrict To Download Attachment', $wcpoa_text_domain);
                    }else{
                        esc_html_e('Please Login To Download Attachment', $wcpoa_text_domain);
                    }
                }
            }else{
                $wcpoa_att_download_restrict_flag = 1;
            }
        }else{
            $wcpoa_att_download_restrict_flag = 1;
        }


        if (strpos($get_permalink_structure, "?")) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        $current_date = date("Y/m/d");
        $wcpoa_today_date = strtotime($current_date);
        $wcpoa_bulk_att_match = 'no';
        if ((int)$wcpoa_att_download_restrict_flag === 1) {
            if (!empty($wcpoa_attachment_ids)) {
                foreach ((array) $wcpoa_attachment_ids as $key => $wcpoa_attachments_id) {

                    if (!empty($wcpoa_attachments_id)) {

                        $wcpoa_attachments_name = isset($wcpoa_attachment_name[$key]) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '';

                        $wcpoa_attach_type_single = isset($wcpoa_attach_type[$key]) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '';
                        $wcpoa_attachment_file = isset($wcpoa_attachment_url[$key]) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '';
                        $wcpoa_attachment_ext_url_single = isset($wcpoa_attachment_ext_url[$key]) && !empty($wcpoa_attachment_ext_url[$key]) ? $wcpoa_attachment_ext_url[$key] : '';


                        $wcpoa_product_pages_enable = isset($wcpoa_product_page_enable[$key]) && !empty($wcpoa_product_page_enable[$key]) ? $wcpoa_product_page_enable[$key] : '';
                        $wcpoa_expired_dates_enable = isset($wcpoa_expired_date_enable[$key]) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '';
                        $wcpoa_expired_dates = isset($wcpoa_expired_date[$key]) && !empty($wcpoa_expired_date[$key]) ? $wcpoa_expired_date[$key] : '';
                        $wcpoa_attachment_descriptions = isset($wcpoa_attachment_description[$key]) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '';
                        $attachment_id = $wcpoa_attachment_file; // ID of attachment

                        $wcpoa_attachments_type = get_post_mime_type($attachment_id);
                        $wcpoa_mime_type = explode('/', $wcpoa_attachments_type);
                        $wcpoa_att_type = $wcpoa_mime_type['0'];
                        $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                        $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                        if ($wcpoa_att_type === 'image') {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                        } elseif ($wcpoa_attachments_type === 'text/csv') {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                        } elseif ($wcpoa_mime_type === 'video') {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                        } elseif ($wcpoa_mime_type === 'text/xml') {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                        } elseif ($wcpoa_mime_type === 'text/doc') {
                            $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                        } else {
                            $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                        }
                        
                        if ( wpap_fs()->is__premium_only() ) {
                            if ( wpap_fs()->can_use_premium_code() ) {
                                if ($wcpoa_att_download_btn === 'wcpoa_att_icon') {
                                    $wcpoa_att_icon_upload_url = get_option('wcpoa_att_icon_upload_url');
                                    if($wcpoa_att_icon_upload_url){
                                        $wcpoa_att_btn = '<img src=" ' . $wcpoa_att_icon_upload_url . ' " title="Download">';
                                    }else{
                                        $wcpoa_att_btn = '<img src=" ' . $wcpoa_attachments_icon . ' " title="Download">';
                                    }
                                    $wcpoa_att_ex_btn = '<img src=" ' . $wcpoa_attachments_expired_icons . ' " title="Expired">';
                                } else {
                                    $wcpoa_att_download_label = get_option('wcpoa_att_download_label');
                                    if($wcpoa_att_download_label){
                                        $wcpoa_att_btn = __($wcpoa_att_download_label, $wcpoa_text_domain);
                                    }else{
                                        $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                    }
                                    
                                    $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                                }
                            }else{
                                $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                            }
                        }else{
                           $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                           $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain); 
                        }
                        if ($wcpoa_product_pages_enable === "yes") {
                            $wcpoa_attachment_expired_date = strtotime($wcpoa_expired_dates);

                            $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name">' . __($wcpoa_attachments_name, $wcpoa_text_domain) . '</h4>';
                            
                            if ( wpap_fs()->is__premium_only() ) {
                                if ( wpap_fs()->can_use_premium_code() ) {
                                    $is_download=$wcpoa_attachments_action_on_click==='download'?'download':'';
                                    if($wcpoa_attach_type_single === "file_upload"){
                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow"> ' . $wcpoa_att_btn . '</a>';
                                    }elseif($wcpoa_attach_type_single === "external_ulr"){
                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_attachment_ext_url_single.'" '.$is_download.'> ' . $wcpoa_att_btn . ' </a>';
                                    }
                                }else{
                                    $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow"> ' . $wcpoa_att_btn . '</a>';
                                }    
                            }else{
                                $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '" rel="nofollow"> ' . $wcpoa_att_btn . '</a>';
                            }
                            $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> ' . $wcpoa_att_ex_btn . ' </a>';
                            $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __($wcpoa_attachment_descriptions, $wcpoa_text_domain) . '</p>';
                            if ($wcpoa_expired_date_tlabel === 'no') {
                                $wcpoa_expire_date_text = '';
                                $wcpoa_expired_date_text = '';
                            } else {
                                $wcpoa_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expiry Date : ', $wcpoa_text_domain) . $wcpoa_expired_dates . '</p>';
                                $wcpoa_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expired.', $wcpoa_text_domain) . '</p>';
                            }

                            echo '<div class="wcpoa_attachment">';
                            if('no' === $wcpoa_expired_dates_enable){
                                echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                $wcpoa_bulk_att_match='yes';
                            }else{
                                if (!empty($wcpoa_attachment_expired_date)) {
                                    if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                        echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                        echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                        $wcpoa_bulk_att_match='yes';
                                    } else {
                                        echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                        echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                        echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                        $wcpoa_bulk_att_match='yes';
                                    }
                                } else {
                                    echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                    echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                    $wcpoa_bulk_att_match='yes';
                                }
                            }
                            
                            echo '</div>';
                        }
                    }
                }
            }
            if ( wpap_fs()->is__premium_only() ) {
                if ( wpap_fs()->can_use_premium_code() ) {
                    //Bulk Attachment
                    $wcpoa_bulk_att_data = get_option('wcpoa_bulk_attachment_data');

                    $terms = get_the_terms($product_id, 'product_cat'); //Product Category Get
                    $wcpoa_bulk_att_values = array();
                    $wcpoa_bulk_att_values_key = array();
                    
                    $assigned_cat_list = $terms;

                    $wcpoa_bulk_att_values_key = array();

                    if (!empty($wcpoa_bulk_att_data) && is_array($wcpoa_bulk_att_data)) {

                        foreach ($wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values) {

                            if (!in_array($att_new_key, convert_array_to_int($wcpoa_bulk_att_values_key),true)) {

                                $wcpoa_bulk_att_visibility = isset($wcpoa_bulk_att_values['wcpoa_att_visibility']) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '';
                                $wcpoa_is_condition=isset($wcpoa_bulk_att_values['wcpoa_is_condition']) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '';

                                $wcpoa_bulk_applied_tag = !empty($wcpoa_bulk_att_values['wcpoa_tag_list']) ? $wcpoa_bulk_att_values['wcpoa_tag_list'] : array();
                                $wcpoa_bulk_applied_product = !empty($wcpoa_bulk_att_values['wcpoa_product_list']) ? $wcpoa_bulk_att_values['wcpoa_product_list'] : array();

                                 $wcpoa_assignment = !empty($wcpoa_bulk_att_values['wcpoa_assignment']) ? $wcpoa_bulk_att_values['wcpoa_assignment'] : array();
                               

                                $wcpoa_bulk_applied_cat = !empty($wcpoa_bulk_att_values['wcpoa_category_list']) ? $wcpoa_bulk_att_values['wcpoa_category_list'] : array();

                                $wcpoa_bulk_apply_cat = !empty($wcpoa_bulk_att_values['wcpoa_apply_cat']) ? $wcpoa_bulk_att_values['wcpoa_apply_cat'] : array();

                                if($wcpoa_bulk_apply_cat!=='wcpoa_cat_selected_only'){
                                    foreach($wcpoa_bulk_applied_cat as $value){
                                        $child_terms=get_term_children( $value, 'product_cat' ); 
                                    }
                                    $wcpoa_bulk_applied_cat=array_merge($wcpoa_bulk_applied_cat,$child_terms);
                                }
                                $tag_terms = get_the_terms($product_id, 'product_tag'); //Product tag Get
                                $product_tag_ids = array();
                                if(!empty($tag_terms)){
                                    foreach ($tag_terms as $tag_term) {
                                        $product_tag_ids[] = $tag_term->term_id;
                                    }                                    
                                }

                                $wcpoa_attachments_bulk_id = !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '';
                                $wcpoa_bulk_attachments_name = isset($wcpoa_bulk_att_values['wcpoa_attachment_name']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '';

                                $wcpoa_bulk_attachment_type = isset($wcpoa_bulk_att_values['wcpoa_attach_type']) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '';

                                if($wcpoa_bulk_attachment_type === "file_upload"){
                                    $wcpoa_bulk_attachment_file = isset($wcpoa_bulk_att_values['wcpoa_attachment_file']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '';
                                }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                    $wcpoa_bulk_attachment_url = isset($wcpoa_bulk_att_values['wcpoa_attachment_url']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_url']) ? $wcpoa_bulk_att_values['wcpoa_attachment_url'] : '';
                                }
                            
                                $wcpoa_attachment_descriptions = isset($wcpoa_bulk_att_values['wcpoa_attachment_description']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_description']) ? $wcpoa_bulk_att_values['wcpoa_attachment_description'] : '';
                                $wcpoa_expired_dates = isset($wcpoa_bulk_att_values['wcpoa_expired_date']) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '';
                                if(isset($wcpoa_bulk_attachment_file)){
                                    $attachment_id = $wcpoa_bulk_attachment_file;
                                    $wcpoa_attachments_type = get_post_mime_type($attachment_id);
                                    $wcpoa_mime_type = explode('/', $wcpoa_attachments_type);
                                    $wcpoa_att_type = $wcpoa_mime_type['0'];
                                } else {
                                    $wcpoa_attachments_type='default';
                                    $wcpoa_att_type='default';
                                }
                                $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                                $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                                if ($wcpoa_att_type === 'image') {
                                    $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                                } elseif ($wcpoa_attachments_type === 'text/csv') {
                                    $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                                } elseif ($wcpoa_att_type === 'video') {
                                    $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                                } elseif ($wcpoa_attachments_type === 'text/xml') {
                                    $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                                } elseif ($wcpoa_attachments_type === 'text/doc') {
                                    $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                                } else {
                                    $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                                }
                                if ($wcpoa_att_download_btn === 'wcpoa_att_icon') {
                                    $wcpoa_att_icon_upload_url = get_option('wcpoa_att_icon_upload_url');
                                    if($wcpoa_att_icon_upload_url){
                                        $wcpoa_att_btn = '<img src=" ' . $wcpoa_att_icon_upload_url . ' " title="Download">';
                                    }else{
                                        $wcpoa_att_btn = '<img src=" ' . $wcpoa_attachments_icon . ' " title="Download">';
                                    }
                                    $wcpoa_att_ex_btn = '<img src=" ' . $wcpoa_attachments_expired_icons . ' " title="Expired">';
                                } else {
                                    $wcpoa_att_download_label = get_option('wcpoa_att_download_label');
                                    if($wcpoa_att_download_label){
                                        $wcpoa_att_btn = __($wcpoa_att_download_label, $wcpoa_text_domain);
                                    }else{
                                        $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                    }
                                    
                                    $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                                }

                                $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name">' . esc_html__($wcpoa_bulk_attachments_name, $wcpoa_text_domain) . '</h4>';
                                $is_download=$wcpoa_attachments_action_on_click==='download'?'download':'target="_blank"';
                                if($wcpoa_bulk_attachment_type === "file_upload"){
                                    $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '" rel="nofollow"> ' . $wcpoa_att_btn . ' </a>';
                                }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                    $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_bulk_attachment_url.'" '.$is_download.'> ' . $wcpoa_att_btn . ' </a>';
                                }

                                $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">' . $wcpoa_att_ex_btn . '</a>';
                                $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __($wcpoa_attachment_descriptions, $wcpoa_text_domain) . '</p>';
                                if ( 'no'=== $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] || 'no' === $wcpoa_expired_date_tlabel) {
                                    $wcpoa_bulk_expired_date_text = '';
                                    $wcpoa_bulk_expire_date_text = '';
                                } else {
                                    $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expired.', $wcpoa_text_domain) . '</p>';
                                    $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expiry Date : ', $wcpoa_text_domain) . $wcpoa_expired_dates . '</p>';
                                }
                                $wcpoa_attachment_expired_date = strtotime($wcpoa_expired_dates);
                                $wcpoa_bulk_att_values_key[] = $att_new_key;
                                if ($wcpoa_bulk_att_visibility === 'product_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all') {
                                    echo '<div class="wcpoa_attachment">';
                                    //check that if category assigned
                                    $product_cats_id=[];

                                    if (isset($assigned_cat_list) && is_array($assigned_cat_list)):
                                        //check that if mathced category found than set to true
                                        foreach ($assigned_cat_list as $term_obj):
                                         
                                                $product_cats_id[] = $term_obj->term_id;
                                        endforeach;

                                    endif; 
                                    if (
                                            ($wcpoa_is_condition!=='yes')
                                            ||
                                            (
                                                (trim($wcpoa_assignment) === 'exclude'  && (
                                                    (empty($wcpoa_bulk_applied_cat) || empty(array_intersect($product_cats_id, $wcpoa_bulk_applied_cat))) &&
                                                    (empty($wcpoa_bulk_applied_tag) || empty(array_intersect($product_tag_ids, $wcpoa_bulk_applied_tag))) &&    
                                                    (empty($wcpoa_bulk_applied_product) || !in_array((int)$product_id, convert_array_to_int($wcpoa_bulk_applied_product),true))
                                                    )
                                                )
                                                ||                                                       (trim($wcpoa_assignment) !== 'exclude' && (
                                                    ( !empty(array_intersect($product_tag_ids, $wcpoa_bulk_applied_tag))) || 
                                                    ( !empty(array_intersect($product_cats_id, $wcpoa_bulk_applied_cat))) ||
                                                    (in_array((int)$product_id, convert_array_to_int($wcpoa_bulk_applied_product),true))
                                                 )
                                                ) 
                                            )                                                

                                        ) {
                                      

                                        if (!empty($wcpoa_attachment_expired_date)) {
                                            if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_file_expired_url_btn,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_expired_date_text,$this->allowed_html_tags());
                                                $wcpoa_bulk_att_match = 'yes';
                                            } else {
                                                echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                                echo wp_kses($wcpoa_bulk_expire_date_text,$this->allowed_html_tags());
                                                $wcpoa_bulk_att_match = 'yes';
                                            }
                                        } else {
                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                            echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                            echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                            $wcpoa_bulk_att_match = 'yes';
                                        }
                                    }                                          

                                    echo '</div>';
                                }
                            }
                        }
                    }
                }
            }
            if($wcpoa_bulk_att_match!=='yes'){
                ?>
                <style type="text/css">
                    #tab-title-wcpoa_product_tab{
                        display: none !important;
                    }
                </style>
                <?php
            }
            
        }
        do_action('after_wcpoa_attachment_detail');
    }

    /**
     * Product attachments data save in order table.
     *
     * @param $item_id
     * @param $item
     * @param $order_id
     */
    public function wcpoa_add_values_to_order_item_meta($item_id, $item, $order_id) {

        $item_product = new WC_Order_Item_Product($item);

        $product_id = $item_product->get_product_id();
        $wcpoa_attachment_ids = get_post_meta($product_id, 'wcpoa_attachments_id', true);
        $wcpoa_attachment_name = get_post_meta($product_id, 'wcpoa_attachment_name', true);
        $wcpoa_attachment_description = get_post_meta($product_id, 'wcpoa_attachment_description', true);

        $wcpoa_attachment_url = get_post_meta($product_id, 'wcpoa_attachment_url', true);
        $wcpoa_attach_type = get_post_meta($product_id, 'wcpoa_attach_type', true);
        
        $wcpoa_order_status = get_post_meta($product_id, 'wcpoa_order_status', true);
        $wcpoa_expired_date_enable = get_post_meta($product_id, 'wcpoa_expired_date_enable', true);
        $wcpoa_expired_date = get_post_meta($product_id, 'wcpoa_expired_date', true);

        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                $wcpoa_attachment_ext_url = get_post_meta($product_id, 'wcpoa_attachment_ext_url', true);
                $wcpoa_variation = get_post_meta($product_id, 'wcpoa_variation', true);
                $wcpoa_expired_time_amount = get_post_meta($product_id, 'wcpoa_expired_time_amount', true);
                $wcpoa_expired_time_type = get_post_meta($product_id, 'wcpoa_expired_time_type', true);
            }
        }


        if (!empty($wcpoa_attachment_ids)) {
            if ( wpap_fs()->is__premium_only() ) {
                if ( wpap_fs()->can_use_premium_code() ) {
                    $wcpoa_order_attachment_order_arr = array(
                        'wcpoa_attachment_ids' => $wcpoa_attachment_ids,
                        'wcpoa_attachment_name' => $wcpoa_attachment_name,
                        'wcpoa_att_order_description' => $wcpoa_attachment_description,
                        'wcpoa_attachment_url' => $wcpoa_attachment_url,
                        'wcpoa_attach_type' => $wcpoa_attach_type,
                        'wcpoa_attachment_ext_url' => $wcpoa_attachment_ext_url,
                        'wcpoa_order_status' => $wcpoa_order_status,
                        'wcpoa_order_product_variation' => $wcpoa_variation,
                        'wcpoa_expired_date_enable' => $wcpoa_expired_date_enable,
                        'wcpoa_order_attachment_expired' => $wcpoa_expired_date,
                        'wcpoa_order_attachment_time_amount' => $wcpoa_expired_time_amount,
                        'wcpoa_order_attachment_time_type' => $wcpoa_expired_time_type,
                    );
                }else{
                    $wcpoa_order_attachment_order_arr = array(
                        'wcpoa_attachment_ids' => $wcpoa_attachment_ids,
                        'wcpoa_attachment_name' => $wcpoa_attachment_name,
                        'wcpoa_att_order_description' => $wcpoa_attachment_description,
                        'wcpoa_attachment_url' => $wcpoa_attachment_url,
                        'wcpoa_attach_type' => $wcpoa_attach_type,
                        'wcpoa_order_status' => $wcpoa_order_status,
                        'wcpoa_expired_date_enable' => $wcpoa_expired_date_enable,
                        'wcpoa_order_attachment_expired' => $wcpoa_expired_date
                    );
                }
            }else{
                $wcpoa_order_attachment_order_arr = array(
                        'wcpoa_attachment_ids' => $wcpoa_attachment_ids,
                        'wcpoa_attachment_name' => $wcpoa_attachment_name,
                        'wcpoa_att_order_description' => $wcpoa_attachment_description,
                        'wcpoa_attachment_url' => $wcpoa_attachment_url,
                        'wcpoa_attach_type' => $wcpoa_attach_type,
                        'wcpoa_order_status' => $wcpoa_order_status,
                        'wcpoa_expired_date_enable' => $wcpoa_expired_date_enable,
                        'wcpoa_order_attachment_expired' => $wcpoa_expired_date
                    );
            }
            wc_add_order_item_meta($item_id, 'wcpoa_order_attachment_order_arr', $wcpoa_order_attachment_order_arr);
        }
    }

    /**
     * Product attachments data show on each order page.
     *
     * @since    1.0.0
     * @access   public
     */
    public function wcpoa_order_data_show($order_id) {
        $wcpoa_text_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
        $order = new WC_Order($order_id);

        $order_data = $order->get_data();
        $order_time = $order_data['date_created']->date('Y/m/d H:i:s');
        $items = $order->get_items(array('line_item'));
        $items_order_status = $order->get_status();
        $items_order_id = $order->get_order_number();
        $wcpoa_order_tab_name = get_option('wcpoa_order_tab_name'); //wcpoa order tab option name
        $wcpoa_expired_date_tlabel = get_option('wcpoa_expired_date_label');
        $wcpoa_attachments_action_on_click = get_option('wcpoa_attachments_action_on_click');
        
        $get_permalink_structure = get_permalink();
        if (strpos($get_permalink_structure, "?")) {
            $wcpoa_attachment_url_arg = '&';
        } else {
            $wcpoa_attachment_url_arg = '?';
        }
        $current_date = date("Y/m/d");
        $wcpoa_today_date = strtotime($current_date);
        $wcpoa_today_date_time = current_time( 'Y/m/d H:i:s');
        $wcpoa_end_div = '';
        $wcpoa_att_values_key = array();
        $tab_title_match = 'no';
        if ( wpap_fs()->is__premium_only() ) {
            if ( wpap_fs()->can_use_premium_code() ) {
                //Bulk Attachement 
                $wcpoa_att_download_btn = get_option('wcpoa_att_download_btn');
                $wcpoa_att_in_my_acc = get_option('wcpoa_att_in_my_acc');
                $wcpoa_bulk_att_data = get_option('wcpoa_bulk_attachment_data');
                $wcpoa_bulk_att_values_key = array();
                $wcpoa_bulk_att_product_key = array();
            }else{
                $wcpoa_att_in_my_acc = "wcpoa_att_in_my_acc_enable";
            }
        }else{
            $wcpoa_att_in_my_acc = "wcpoa_att_in_my_acc_enable";
        }
        if($wcpoa_att_in_my_acc === "wcpoa_att_in_my_acc_enable"){

            echo '<section class="woocommerce-attachment-details">';
            do_action('before_wcpoa_attachment_detail');
            if ($tab_title_match === 'no') {
                echo '<h2 class="woocommerce-order-details__title">' . esc_html($wcpoa_order_tab_name) . '</h2>';
            }
            $wcpoa_attachments_id_bulk = array();

            if (!empty($items) && is_array($items)):

                foreach ($items as $item_id => $item) {
                    $wcpoa_order_attachment_items = wc_get_order_item_meta($item_id, 'wcpoa_order_attachment_order_arr', true);
                    if ( wpap_fs()->is__premium_only() ) {
                        if ( wpap_fs()->can_use_premium_code() ) {
                            $wcpoa_order_product_variation_id = $item['variation_id'];
                        }
                    }
                    if (!empty($wcpoa_order_attachment_items)) {
                        $wcpoa_attachment_ids = $wcpoa_order_attachment_items['wcpoa_attachment_ids'];
                        $wcpoa_attachment_name = $wcpoa_order_attachment_items['wcpoa_attachment_name'];
                        $wcpoa_attachment_description = $wcpoa_order_attachment_items['wcpoa_att_order_description'];

                        $wcpoa_attachment_url = $wcpoa_order_attachment_items['wcpoa_attachment_url'];
                        $wcpoa_attach_type = $wcpoa_order_attachment_items['wcpoa_attach_type'];
                        $wcpoa_order_status = $wcpoa_order_attachment_items['wcpoa_order_status'];

                        
                        $wcpoa_expired_date_enable = $wcpoa_order_attachment_items['wcpoa_expired_date_enable'];
                        $wcpoa_order_attachment_expired = $wcpoa_order_attachment_items['wcpoa_order_attachment_expired'];
                        if ( wpap_fs()->is__premium_only() ) {
                            if ( wpap_fs()->can_use_premium_code() ) {
                                $wcpoa_attachment_ext_url = $wcpoa_order_attachment_items['wcpoa_attachment_ext_url'];
                                $wcpoa_order_product_variation = $wcpoa_order_attachment_items['wcpoa_order_product_variation'];
                                $wcpoa_order_attachment_time_amount = $wcpoa_order_attachment_items['wcpoa_order_attachment_time_amount'];
                                $wcpoa_order_attachment_time_type = $wcpoa_order_attachment_items['wcpoa_order_attachment_time_type'];
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
                                $selected_variation_id = "";
                                $attached_variations = array();
                            }
                        }else{
                            $selected_variation_id = "";
                            $attached_variations = array();
                        }

                        
                        if (!empty($selected_variation_id) && is_array($attached_variations) && in_array((int)$selected_variation_id, convert_array_to_int($attached_variations),true)) {
                            if ( wpap_fs()->is__premium_only() ) {
                                if ( wpap_fs()->can_use_premium_code() ) {
                                    if (!empty($wcpoa_attachment_ids) && is_array($wcpoa_attachment_ids)) {
                                        //End Woo Product Attachment Order Tab
                                        foreach ($wcpoa_attachment_ids as $key => $wcpoa_attachments_id) {
                                            if (!empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '') {
                                                if (!in_array($wcpoa_attachments_id, $wcpoa_att_values_key,true)) {

                                                    $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                                    $attachment_name = isset($wcpoa_attachment_name[$key]) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '';

                                                    $wcpoa_attachment_type = isset($wcpoa_attach_type[$key]) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '';
                                                    $wcpoa_attachment_ext_url = isset($wcpoa_attachment_ext_url[$key]) && !empty($wcpoa_attachment_ext_url[$key]) ? $wcpoa_attachment_ext_url[$key] : '';
                                                    $wcpoa_attachment_file = isset($wcpoa_attachment_url[$key]) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '';

                                                    $wcpoa_attachment_descriptions = isset($wcpoa_attachment_description[$key]) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '';
                                                    $wcpoa_order_status_val = isset($wcpoa_order_status[$wcpoa_attachments_id]) && !empty($wcpoa_order_status[$wcpoa_attachments_id]) && $wcpoa_order_status[$wcpoa_attachments_id] ? $wcpoa_order_status[$wcpoa_attachments_id] : '';
                                                    $wcpoa_order_status_new = str_replace('wcpoa-wc-', '', $wcpoa_order_status_val);
                                                    $wcpoa_expired_date_enable = isset($wcpoa_expired_date_enable[$key]) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '';
                                                    $wcpoa_order_attachment_expired_date = isset($wcpoa_order_attachment_expired[$key]) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '';
                                                    $wcpoa_order_attachment_exp_time_amount = isset($wcpoa_order_attachment_time_amount[$key]) && !empty($wcpoa_order_attachment_time_amount[$key]) ? $wcpoa_order_attachment_time_amount[$key] : '';
                                                    $wcpoa_order_attachment_exp_time_type = isset($wcpoa_order_attachment_time_type[$key]) && !empty($wcpoa_order_attachment_time_type[$key]) ? $wcpoa_order_attachment_time_type[$key] : '';

                                                    $wcpoa_attachment_time_amount = isset($wcpoa_bulk_att_values['wcpoa_attachment_time_amount']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_time_amount']) ? $wcpoa_bulk_att_values['wcpoa_attachment_time_amount'] : ''; //phpcs:ignore
                                                    $wcpoa_attachment_time_type = isset($wcpoa_bulk_att_values['wcpoa_attachment_time_type']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_time_type']) ? $wcpoa_bulk_att_values['wcpoa_attachment_time_type'] : ''; //phpcs:ignore
                                                    $wcpoa_time_amount_concate = $wcpoa_attachment_time_amount." ".$wcpoa_attachment_time_type;


                                                    $attachment_id = $wcpoa_attachment_file; // ID of attachment

                                                    $wcpoa_attachment_expired_date = strtotime($wcpoa_order_attachment_expired_date);
                                                    $wcpoa_attachments_type = get_post_mime_type($wcpoa_attachments_id);
                                                    $wcpoa_mime_type = explode('/', $wcpoa_attachments_type);
                                                    $wcpoa_att_type = $wcpoa_mime_type['0'];

                                                    $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                                                    $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                                                    if ($wcpoa_att_type === 'image') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                                                    } elseif ($wcpoa_attachments_type === 'text/csv') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                                                    } elseif ($wcpoa_mime_type === 'video') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                                                    } elseif ($wcpoa_attachments_type === 'text/xml') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                                                    } elseif ($wcpoa_attachments_type === 'text/doc') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                                                    } else {
                                                        $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                                                    }
                                                    if ($wcpoa_att_download_btn === 'wcpoa_att_icon') {
                                                        $wcpoa_att_icon_upload_url = get_option('wcpoa_att_icon_upload_url');
                                                        if($wcpoa_att_icon_upload_url){
                                                            $wcpoa_att_btn = '<img src=" ' . $wcpoa_att_icon_upload_url . ' " title="Download">';
                                                        }else{
                                                            $wcpoa_att_btn = '<img src=" ' . $wcpoa_attachments_icon . ' " title="Download">';
                                                        }
                                                        $wcpoa_att_ex_btn = '<img src=" ' . $wcpoa_attachments_expired_icons . ' " title="Expired">';
                                                    } else {
                                                        $wcpoa_att_download_label = get_option('wcpoa_att_download_label');
                                                        if($wcpoa_att_download_label){
                                                            $wcpoa_att_btn = __($wcpoa_att_download_label, $wcpoa_text_domain);
                                                        }else{
                                                            $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                                        }
                                                        
                                                        $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                                                    }

                                                    $attachment_order_name = '<h4 class="wcpoa_attachment_name">' . __($attachment_name, $wcpoa_text_domain) . '</h4>';


                                                    $is_download=$wcpoa_attachments_action_on_click==='download'?'download':'target="_blank"';
                                                    if($wcpoa_attachment_type === "file_upload"){
                                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                                    }elseif($wcpoa_attachment_type === "external_ulr"){
                                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_attachment_ext_url.'" '.$is_download.'> ' . $wcpoa_att_btn . ' </a>';
                                                    }



                                                    $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">' . $wcpoa_att_ex_btn . '</a>';
                                                    $wcpoa_order_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __($wcpoa_attachment_descriptions, $wcpoa_text_domain) . '</p>';
                                                    if ($wcpoa_expired_date_tlabel === 'no') {
                                                        $wcpoa_expire_date_text = '';
                                                        $wcpoa_expired_date_text = '';
                                                    } else {
                                                        $wcpoa_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expiry Date : ', $wcpoa_text_domain) . $wcpoa_order_attachment_expired_date . '</p>';
                                                        $wcpoa_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expired', $wcpoa_text_domain) . '</p>';

                                                    }

                                                    if (!empty($wcpoa_order_status_new)) {
                                                        if (!empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes") {
                                                            if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                                if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                                    if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    } else {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    }
                                                                }
                                                            } else {
                                                                if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                                    if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    } else {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                                if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                    $tab_title_match = 'yes';
                                                                } else {
                                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                    $tab_title_match = 'yes';
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        if (!empty($wcpoa_attachment_expired_date)) {
                                                            if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            } else {
                                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            }
                                                        } else {
                                                            echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                            $tab_title_match = 'yes';
                                                        }
                                                    }
                                                    echo wp_kses($wcpoa_end_div,$this->allowed_html_tags());
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            if (!empty($wcpoa_attachment_ids) && is_array($wcpoa_attachment_ids)) {
                                //End Woo Product Attachment Order Tab
                                foreach ($wcpoa_attachment_ids as $key => $wcpoa_attachments_id) {
                                    if (!empty($wcpoa_attachments_id) || $wcpoa_attachments_id !== '') {
                                        if (!in_array($wcpoa_attachments_id, $wcpoa_att_values_key,true)) {

                                            $wcpoa_att_values_key[] = $wcpoa_attachments_id;
                                            $attachment_name = isset($wcpoa_attachment_name[$key]) && !empty($wcpoa_attachment_name[$key]) ? $wcpoa_attachment_name[$key] : '';


                                            $wcpoa_attachment_type = isset($wcpoa_attach_type[$key]) && !empty($wcpoa_attach_type[$key]) ? $wcpoa_attach_type[$key] : '';
                                            
                                            $wcpoa_attachment_file = isset($wcpoa_attachment_url[$key]) && !empty($wcpoa_attachment_url[$key]) ? $wcpoa_attachment_url[$key] : '';


                                            $wcpoa_attachment_descriptions = isset($wcpoa_attachment_description[$key]) && !empty($wcpoa_attachment_description[$key]) ? $wcpoa_attachment_description[$key] : '';
                                            $wcpoa_order_status_val = isset($wcpoa_order_status[$wcpoa_attachments_id]) && !empty($wcpoa_order_status[$wcpoa_attachments_id]) && $wcpoa_order_status[$wcpoa_attachments_id] ? $wcpoa_order_status[$wcpoa_attachments_id] : '';
                                            $wcpoa_order_status_new = str_replace('wcpoa-wc-', '', $wcpoa_order_status_val);
                                            $wcpoa_expired_date_enable = isset($wcpoa_expired_date_enable[$key]) && !empty($wcpoa_expired_date_enable[$key]) ? $wcpoa_expired_date_enable[$key] : '';

                                            $wcpoa_order_attachment_expired_date = isset($wcpoa_order_attachment_expired[$key]) && !empty($wcpoa_order_attachment_expired[$key]) ? $wcpoa_order_attachment_expired[$key] : '';

                                            if ( wpap_fs()->is__premium_only() ) {
                                                if ( wpap_fs()->can_use_premium_code() ) {
                                                    $wcpoa_attachment_ext_url = isset($wcpoa_attachment_ext_url[$key]) && !empty($wcpoa_attachment_ext_url[$key]) ? $wcpoa_attachment_ext_url[$key] : '';
                                                    $wcpoa_order_attachment_exp_time_amount = isset($wcpoa_order_attachment_time_amount[$key]) && !empty($wcpoa_order_attachment_time_amount[$key]) ? $wcpoa_order_attachment_time_amount[$key] : '';
                                                    $wcpoa_order_attachment_exp_time_type = isset($wcpoa_order_attachment_time_type[$key]) && !empty($wcpoa_order_attachment_time_type[$key]) ? $wcpoa_order_attachment_time_type[$key] : '';
                                                    $wcpoa_order_attachment_time_amount_concate = $wcpoa_order_attachment_exp_time_amount." ".$wcpoa_order_attachment_exp_time_type; 
                                                    $wcpoa_attachment_time_amount_concate_single = strtotime($wcpoa_order_attachment_time_amount_concate);
                                                }else{
                                                    $wcpoa_attachment_time_amount_concate_single = "";
                                                }
                                            }else{
                                                $wcpoa_attachment_time_amount_concate_single = "";
                                            }        

                                            $attachment_id = $wcpoa_attachment_file; // ID of attachment

                                            $wcpoa_attachment_expired_date = strtotime($wcpoa_order_attachment_expired_date);
                                            if ( wpap_fs()->is__premium_only() ) {
                                                if ( wpap_fs()->can_use_premium_code() ) {
                                                    $wcpoa_attachments_type = get_post_mime_type($wcpoa_attachments_id);
                                                    $wcpoa_mime_type = explode('/', $wcpoa_attachments_type);
                                                    $wcpoa_att_type = $wcpoa_mime_type['0'];
                                                    $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                                                    $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                                                    if ($wcpoa_att_type === 'image') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                                                    } elseif ($wcpoa_attachments_type === 'text/csv') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                                                    } elseif ($wcpoa_mime_type === 'video') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                                                    } elseif ($wcpoa_attachments_type === 'text/xml') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                                                    } elseif ($wcpoa_attachments_type === 'text/doc') {
                                                        $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                                                    } else {
                                                        $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                                                    }
                                                    if ($wcpoa_att_download_btn === 'wcpoa_att_icon') {
                                                        $wcpoa_att_icon_upload_url = get_option('wcpoa_att_icon_upload_url');
                                                        if($wcpoa_att_icon_upload_url){
                                                            $wcpoa_att_btn = '<img src=" ' . $wcpoa_att_icon_upload_url . ' " title="Download">';
                                                        }else{
                                                            $wcpoa_att_btn = '<img src=" ' . $wcpoa_attachments_icon . ' " title="Download">';
                                                        }
                                                        $wcpoa_att_ex_btn = '<img src=" ' . $wcpoa_attachments_expired_icons . ' " title="Expired">';
                                                    } else {
                                                        $wcpoa_att_download_label = get_option('wcpoa_att_download_label');
                                                        if($wcpoa_att_download_label){
                                                            $wcpoa_att_btn = __($wcpoa_att_download_label, $wcpoa_text_domain);
                                                        }else{
                                                            $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                                        }
                                                        
                                                        $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                                                    }
                                                }else{
                                                    $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                                    $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                                                }
                                            }else{
                                                $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                                $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                                            }

                                            $attachment_order_name = '<h4 class="wcpoa_attachment_name">' . __($attachment_name, $wcpoa_text_domain) . '</h4>';
                                            $is_download=$wcpoa_attachments_action_on_click==='download'?'download':'';
                                            if ( wpap_fs()->is__premium_only() ) {
                                                if ( wpap_fs()->can_use_premium_code() ) {
                                                    if($wcpoa_attachment_type === "file_upload"){
                                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                                    }elseif($wcpoa_attachment_type === "external_ulr"){
                                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="'.$wcpoa_attachment_ext_url.'" '.$is_download.'> ' . $wcpoa_att_btn . ' </a>';
                                                    }
                                                }else{
                                                    if($wcpoa_attachment_type === "file_upload"){
                                                        $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                                    }
                                                }
                                            }else{
                                                if($wcpoa_attachment_type === "file_upload"){
                                                    $wcpoa_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $attachment_id . '&download_file=' . $wcpoa_attachments_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                                }
                                            }    

                                            $wcpoa_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow">' . $wcpoa_att_ex_btn . '</a>';
                                            $wcpoa_order_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __($wcpoa_attachment_descriptions, $wcpoa_text_domain) . '</p>';
                                            if ($wcpoa_expired_date_tlabel === 'no') {
                                                $wcpoa_expire_date_text = '';
                                                $wcpoa_expired_date_text = '';
                                            } else {
                                                $wcpoa_expire_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expiry Date : ', $wcpoa_text_domain) . $wcpoa_order_attachment_expired_date . '</p>';
                                                $wcpoa_expired_date_text = '<p class="order_att_expire_date"><span>*</span>' . __('This Attachment Expired', $wcpoa_text_domain) . '</p>';
                                            }

                                            if (!empty($wcpoa_order_status_new)) {
                                                if (!empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes") {
                                                    if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                        if (in_array($items_order_status, $wcpoa_order_status_new,true)){
                                                            if ( wpap_fs()->is__premium_only() ) {
                                                                if ( wpap_fs()->can_use_premium_code() ) {
                                                                    if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    } else {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    }
                                                                }else{
                                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                    $tab_title_match = 'yes';
                                                                }
                                                            }else{
                                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            }
                                                        }
                                                    } else {
                                                        if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                            if ( wpap_fs()->is__premium_only() ) {
                                                                if ( wpap_fs()->can_use_premium_code() ) {
                                                                    if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    } else {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    }
                                                                }else{
                                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                    $tab_title_match = 'yes';
                                                                }
                                                            }else{
                                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            }
                                                        }
                                                    }
                                                } elseif (!empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount") { 
                                                    if ( wpap_fs()->is__premium_only() ) {
                                                        if ( wpap_fs()->can_use_premium_code() ) {
                                                            $wcpoa_single_duration = '+'.$wcpoa_attachment_time_amount_concate_single;
                                                            $wcpoa_attachment_expired_time = date('Y/m/d H:i:s', strtotime($wcpoa_single_duration, strtotime($order_time)));
                                                            if ($wcpoa_today_date_time > $wcpoa_attachment_expired_time) {
                                                                if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                                    if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    } else {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    }
                                                                }
                                                            } else {
                                                                if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                                    if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_expire_date_text,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    } else {
                                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                        $tab_title_match = 'yes';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }else {
                                                    if ( wpap_fs()->is__premium_only() ) {
                                                        if ( wpap_fs()->can_use_premium_code() ) {
                                                            if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                                if (!empty($wcpoa_order_product_variation_id) && in_array((int)$wcpoa_order_product_variation_id, convert_array_to_int($wcpoa_order_product_variation[$wcpoa_attachments_id]),true)) {
                                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                    $tab_title_match = 'yes';
                                                                } else {
                                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                    $tab_title_match = 'yes';
                                                                }
                                                            }
                                                        }else{
                                                            if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            }
                                                        }
                                                    }else{
                                                        if (in_array($items_order_status, $wcpoa_order_status_new,true)) {
                                                            echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                            $tab_title_match = 'yes';
                                                        }
                                                    }
                                                }
                                            } else {
                                                if (!empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === "yes") {
                                                    if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                        $tab_title_match = 'yes';
                                                    } else {
                                                        echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                        echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                        $tab_title_match = 'yes';
                                                    }
                                                }elseif (!empty($wcpoa_attachment_time_amount_concate_single) && $wcpoa_expired_date_enable === "time_amount") { 
                                                    if ( wpap_fs()->is__premium_only() ) {
                                                        if ( wpap_fs()->can_use_premium_code() ) {
                                                            $wcpoa_single_duration = '+'.$wcpoa_order_attachment_time_amount_concate;
                                                            $wcpoa_attachment_expired_time = date('Y/m/d H:i:s', strtotime($wcpoa_single_duration, strtotime($order_time)));
                                                            if ($wcpoa_today_date_time > $wcpoa_attachment_expired_time) {
                                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_file_expired_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_expired_date_text,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            } else {
                                                                echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo wp_kses($attachment_order_name,$this->allowed_html_tags());
                                                    echo wp_kses($wcpoa_file_url_btn,$this->allowed_html_tags());
                                                    echo wp_kses($wcpoa_order_attachment_descriptions,$this->allowed_html_tags());
                                                    $tab_title_match = 'yes';
                                                }
                                            }
                                            echo wp_kses($wcpoa_end_div,$this->allowed_html_tags());
                                        }
                                    }
                                }
                            }
                       
                        }
                    }
                    if ( wpap_fs()->is__premium_only() ) {
                        if ( wpap_fs()->can_use_premium_code() ) {
                            //Bulk Attachment
                            if (!empty($items)) {
                                $terms = get_the_terms($item['product_id'], 'product_cat'); //Product Category Get

                                if (!empty($wcpoa_bulk_att_data)) {
                                    foreach ($wcpoa_bulk_att_data as $att_new_key => $wcpoa_bulk_att_values) {

                                        if (!in_array($att_new_key, $wcpoa_bulk_att_product_key,true)) {

                                            $wcpoa_bulk_applied_tag = !empty($wcpoa_bulk_att_values['wcpoa_tag_list']) ? $wcpoa_bulk_att_values['wcpoa_tag_list'] : array();

                                            $tag_terms = get_the_terms($item['product_id'], 'product_tag'); //Product tag Get
                                            $product_tag_ids = array();
                                            if(!empty($tag_terms)){
                                                foreach ($tag_terms as $tag_term) {
                                                    $product_tag_ids[] = $tag_term->term_id;
                                                }                                    
                                            }
                                            $product_cats_id = array();
                                                    if (!empty($terms)) {
                                                        foreach ($terms as $term) {
                                                            $product_cats_id[] = $term->term_id;
                                                        }
                                                    }

                                            $wcpoa_bulk_att_visibility = isset($wcpoa_bulk_att_values['wcpoa_att_visibility']) && !empty($wcpoa_bulk_att_values['wcpoa_att_visibility']) ? $wcpoa_bulk_att_values['wcpoa_att_visibility'] : '';
                                            $wcpoa_is_condition=isset($wcpoa_bulk_att_values['wcpoa_is_condition']) && !empty($wcpoa_bulk_att_values['wcpoa_is_condition']) ? $wcpoa_bulk_att_values['wcpoa_is_condition'] : '';
                                            $wcpoa_bulk_applied_cat = !empty($wcpoa_bulk_att_values['wcpoa_category_list']) ? $wcpoa_bulk_att_values['wcpoa_category_list'] : array();
                                            $wcpoa_assignment = !empty($wcpoa_bulk_att_values['wcpoa_assignment']) ? $wcpoa_bulk_att_values['wcpoa_assignment'] : array();
                                            
                                            $wcpoa_bulk_applied_product = !empty($wcpoa_bulk_att_values['wcpoa_product_list']) ? $wcpoa_bulk_att_values['wcpoa_product_list'] : array();

                                            $wcpoa_attachments_bulk_id = !empty($wcpoa_bulk_att_values['wcpoa_attachments_id']) ? $wcpoa_bulk_att_values['wcpoa_attachments_id'] : '';
                                            $wcpoa_bulk_attachments_name = isset($wcpoa_bulk_att_values['wcpoa_attachment_name']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_name']) ? $wcpoa_bulk_att_values['wcpoa_attachment_name'] : '';

                                            $wcpoa_bulk_attachment_type = isset($wcpoa_bulk_att_values['wcpoa_attach_type']) && !empty($wcpoa_bulk_att_values['wcpoa_attach_type']) ? $wcpoa_bulk_att_values['wcpoa_attach_type'] : '';

                                            if($wcpoa_bulk_attachment_type === "file_upload"){
                                                $wcpoa_bulk_attachment_file = isset($wcpoa_bulk_att_values['wcpoa_attachment_file']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_file']) ? $wcpoa_bulk_att_values['wcpoa_attachment_file'] : '';
                                            }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                                $wcpoa_bulk_attachment_url = isset($wcpoa_bulk_att_values['wcpoa_attachment_url']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_url']) ? $wcpoa_bulk_att_values['wcpoa_attachment_url'] : '';
                                            }

                                            $wcpoa_attachment_descriptions = isset($wcpoa_bulk_att_values['wcpoa_attachment_description']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_description']) ? $wcpoa_bulk_att_values['wcpoa_attachment_description'] : '';

                                            
                                            $wcpoa_expired_date_enable = isset($wcpoa_bulk_att_values['wcpoa_expired_date_enable']) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date_enable']) ? $wcpoa_bulk_att_values['wcpoa_expired_date_enable'] : '';

                                            $wcpoa_expired_dates = isset($wcpoa_bulk_att_values['wcpoa_expired_date']) && !empty($wcpoa_bulk_att_values['wcpoa_expired_date']) ? $wcpoa_bulk_att_values['wcpoa_expired_date'] : '';
                                            $wcpoa_attachment_time_amount = isset($wcpoa_bulk_att_values['wcpoa_attachment_time_amount']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_time_amount']) ? $wcpoa_bulk_att_values['wcpoa_attachment_time_amount'] : '';
                                            $wcpoa_attachment_time_type = isset($wcpoa_bulk_att_values['wcpoa_attachment_time_type']) && !empty($wcpoa_bulk_att_values['wcpoa_attachment_time_type']) ? $wcpoa_bulk_att_values['wcpoa_attachment_time_type'] : '';
                                            $wcpoa_time_amount_concate = $wcpoa_attachment_time_amount." ".$wcpoa_attachment_time_type; 

                                            $wcpoa_order_status = isset($wcpoa_bulk_att_values['wcpoa_order_status']) && !empty($wcpoa_bulk_att_values['wcpoa_order_status']) ? $wcpoa_bulk_att_values['wcpoa_order_status'] : '';

                                            if(isset($wcpoa_bulk_attachment_file)){
                                                $attachment_id = $wcpoa_bulk_attachment_file;
                                                $wcpoa_attachments_type = get_post_mime_type($attachment_id);
                                                $wcpoa_mime_type = explode('/', $wcpoa_attachments_type);
                                                $wcpoa_att_type = $wcpoa_mime_type['0'];
                                            } else {
                                                $wcpoa_attachments_type='default';
                                                $wcpoa_att_type='default';
                                            }
                                            $wcpoa_attachments_icons = WCPOA_PLUGIN_URL . 'public/images/default.png';
                                            $wcpoa_attachments_expired_icons = WCPOA_PLUGIN_URL . 'public/images/expired.png';
                                            if ($wcpoa_att_type === 'image') {
                                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/image.png';
                                            } elseif ($wcpoa_attachments_type === 'text/csv') {
                                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/csv.png';
                                            } elseif ($wcpoa_att_type === 'video') {
                                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/video.png';
                                            } elseif ($wcpoa_attachments_type === 'text/xml') {
                                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/xml.png';
                                            } elseif ($wcpoa_attachments_type === 'text/doc') {
                                                $wcpoa_attachments_icon = WCPOA_PLUGIN_URL . 'public/images/doc.png';
                                            } else {
                                                $wcpoa_attachments_icon = $wcpoa_attachments_icons;
                                            }
                                            if ($wcpoa_att_download_btn === 'wcpoa_att_icon') {
                                                $wcpoa_att_icon_upload_url = get_option('wcpoa_att_icon_upload_url');
                                                if($wcpoa_att_icon_upload_url){
                                                    $wcpoa_att_btn = '<img src=" ' . $wcpoa_att_icon_upload_url . ' " title="Download">';
                                                }else{
                                                    $wcpoa_att_btn = '<img src=" ' . $wcpoa_attachments_icon . ' " title="Download">';
                                                }
                                                $wcpoa_att_ex_btn = '<img src=" ' . $wcpoa_attachments_expired_icons . ' " title="Expired">';
                                            } else {
                                                $wcpoa_att_download_label = get_option('wcpoa_att_download_label');
                                                if($wcpoa_att_download_label){
                                                    $wcpoa_att_btn = __($wcpoa_att_download_label, $wcpoa_text_domain);
                                                }else{
                                                    $wcpoa_att_btn = __('Download', $wcpoa_text_domain);
                                                }
                                                
                                                $wcpoa_att_ex_btn = __('Download', $wcpoa_text_domain);
                                            }
                                            $wcpoa_attachments_name = '<h4 class="wcpoa_attachment_name">' . esc_html__($wcpoa_bulk_attachments_name, $wcpoa_text_domain) . '</h4>';
                                            $is_download=$wcpoa_attachments_action_on_click==='download'?'download':'target="_blank"';

                                            if($wcpoa_bulk_attachment_type === "file_upload"){
                                                $wcpoa_bulk_file_url_btn = '<a class="wcpoa_attachmentbtn" href="' . get_permalink() . $wcpoa_attachment_url_arg . 'attachment_id=' . $wcpoa_bulk_attachment_file . '&download_file=' . $wcpoa_attachments_bulk_id . '&wcpoa_attachment_order_id=' . $items_order_id . '" rel="nofollow">' . $wcpoa_att_btn . '</a>';
                                            }elseif($wcpoa_bulk_attachment_type === "external_ulr"){
                                                $wcpoa_bulk_file_url_btn = '<a '.$is_download.' class="wcpoa_attachmentbtn" href="'.$wcpoa_bulk_attachment_url.'" > ' . $wcpoa_att_btn . ' </a>';
                                            }
                                            $wcpoa_bulk_file_expired_url_btn = '<a class="wcpoa_order_attachment_expire" rel="nofollow"> ' . $wcpoa_att_ex_btn . ' </a>';
                                            $wcpoa_attachment_descriptions = '<p class="wcpoa_attachment_desc">' . __($wcpoa_attachment_descriptions, $wcpoa_text_domain) . '</p>';
                                            $wcpoa_bulk_expired_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expired.', $wcpoa_text_domain) . '</p>';
                                            $wcpoa_bulk_expire_date_text = '<p class="order_att_expire_date">' . __('This Attachment Expiry Date : ', $wcpoa_text_domain) . $wcpoa_expired_dates . '</p>';
                                            $wcpoa_attachment_expired_date = strtotime($wcpoa_expired_dates);
                                            $wcpoa_attachment_time_amount = strtotime($wcpoa_time_amount_concate);
                                            $wcpoa_order_status_val = str_replace('wcpoa-wc-', '', $wcpoa_order_status);
                                            $wcpoa_order_status_new = !empty($wcpoa_order_status_val) ? $wcpoa_order_status_val : array();
                                            $wcpoa_bulk_att_values_key[] = $att_new_key;
                                            $wcpoa_end_div = '';

                                            if ($wcpoa_bulk_att_visibility === 'order_details_page' || $wcpoa_bulk_att_visibility === 'wcpoa_all') {
                                                if( empty($wcpoa_order_status_new) || in_array($items_order_status, $wcpoa_order_status_new,true)){

                                                    if (

                                                        ($wcpoa_is_condition!=='yes')
                                                        ||
                                                        (
                                                            (trim($wcpoa_assignment) === 'exclude'  && ((empty($wcpoa_bulk_applied_cat) || empty(array_intersect($product_cats_id, $wcpoa_bulk_applied_cat))) &&
                                                            (empty($wcpoa_bulk_applied_tag) || empty(array_intersect($product_tag_ids, $wcpoa_bulk_applied_tag))) &&    
                                                            (empty($wcpoa_bulk_applied_product) || !in_array((int)$item['product_id'], convert_array_to_int($wcpoa_bulk_applied_product),true)))
                                                            )
                                                            || 
                                                            (trim($wcpoa_assignment) !== 'exclude' && (
                                                                ( !empty(array_intersect($product_tag_ids, $wcpoa_bulk_applied_tag))) ||
                                                                ( !empty(array_intersect($product_cats_id, $wcpoa_bulk_applied_cat))) ||
                                                                (in_array((int)$item['product_id'], convert_array_to_int($wcpoa_bulk_applied_product),true)))
                                                            )
                                                        )

                                                    ) 

                                                    {

                                                    $wcpoa_att_id = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                                    if(empty($wcpoa_attachments_id_bulk) || !in_array($wcpoa_att_id, $wcpoa_attachments_id_bulk,true)){
                                                        $wcpoa_attachments_id_bulk[] = $wcpoa_bulk_att_values['wcpoa_attachments_id'];
                                                        if (!empty($wcpoa_attachment_expired_date) && $wcpoa_expired_date_enable === 'yes') {
                                                            if ($wcpoa_today_date > $wcpoa_attachment_expired_date) {
                                                                echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_bulk_file_expired_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_bulk_expired_date_text,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            } else {
                                                                echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                                                echo wp_kses($wcpoa_bulk_expire_date_text,$this->allowed_html_tags());
                                                                $tab_title_match = 'yes';
                                                            }
                                                        }elseif (!empty($wcpoa_attachment_time_amount) && $wcpoa_expired_date_enable === 'time_amount') { 

                                                                $wcpoa_bulk_duration = '+'.$wcpoa_time_amount_concate;
                                                                $wcpoa_attachment_expired_time = date('Y/m/d H:i:s', strtotime($wcpoa_bulk_duration, strtotime($order_time)));
                                                                if ($wcpoa_today_date_time > $wcpoa_attachment_expired_time) {
                                                                    echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_bulk_file_expired_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_bulk_expired_date_text,$this->allowed_html_tags());
                                                                    $tab_title_match = 'yes';

                                                                } else {
                                                                    echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                                    echo wp_kses($wcpoa_bulk_expire_date_text,$this->allowed_html_tags());
                                                                    echo "<p>".wp_kses($wcpoa_attachment_expired_time,$this->allowed_html_tags())."</p>";
                                                                    $tab_title_match = 'yes';
                                                                }

                                                        } else {
                                                            echo wp_kses($wcpoa_attachments_name,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_bulk_file_url_btn,$this->allowed_html_tags());
                                                            echo wp_kses($wcpoa_attachment_descriptions,$this->allowed_html_tags());
                                                            $tab_title_match = 'yes';
                                                        }
                                                    }       
                                                } 
                                            } 
                                                echo wp_kses($wcpoa_end_div,$this->allowed_html_tags());
                                            }

                                        }
                                        
                                    }
                                    
                                }

                            }
                        }
                    }  
                }
            endif;

          
            if ($tab_title_match !== 'yes') {
                esc_html_e('No attachments...yet! ', $wcpoa_text_domain);
                $tab_title_match = 'yes';
            }
            echo '</section>';
            do_action('after_wcpoa_attachment_detail');
        }
        return null;

    }

    /*
     * Emails Attachment
     */

    public function wcpoa_woocommerce_email_order_attachment($fields, $sent_to_admin, $order_id) {

        $this->wcpoa_order_data_show($order_id);
        return $fields;
    }

    /*
     * Emails Attachment custome style
     */

    public function wcpoa_woocommerce_email_add_css_to_email_attachment() {
        echo '<st' . 'yle type="text/css">
                        a.wcpoa_attachmentbtn {padding: 10px;background: #35a87b;color: #fff;}
                        a.wcpoa_order_attachment_expire {padding: 10px;background: #ccc;color: #ffffff;cursor: no-drop;box-shadow: none;}
                        .wcpoa_attachment_desc{padding: 8px 0px;}
                        .order_att_expire_date { padding: 8px 0px; }

                </st' . 'yle>';
    }

    public function allowed_html_tags($tags=array()){
        $allowed_tags=array(
        'a' => array('href' => array(),'title' => array(),'target' => array(),'class' => array(), 'download' => array()),
        'ul' => array('class' => array()),
        'li' => array('class' => array()),
        'p' => array('class' => array()),
        'img' => array('href' => array(),'title' => array(),'class' => array(),'src' => array()),
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
