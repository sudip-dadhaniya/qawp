<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
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

    if ((int)$field['max'] <= (int)$field['min']) {

        $show_remove = false;
        $show_add = false;
    }
}

// field wrap
$el = 'td';
$before_fields = '';
$after_fields = '';

if ('row' === 'row') {

    $el = 'div';
    $before_fields = '<td class="wcpoa-fields -left">';
    $after_fields = '</td>';
}

// layout
$div['class'] .= ' -' . 'row';
$plugin_txt_domain = WCPOA_PLUGIN_TEXT_DOMAIN;
$plugin_url = WCPOA_PLUGIN_URL;

wp_nonce_field(plugin_basename(__FILE__), 'wcpoa_attachment_nonce');

$wcpoa_bulk_att_data = get_option('wcpoa_bulk_attachment_data');


?>
<div class="wcpoa-field wcpoa-field-repeater" data-name="attachments" data-type="repeater" data-key="attachments">
    <div class="wcpoa-label">
        <label for="wcpoa-pro"><?php esc_html_e('Attachments', $plugin_txt_domain) ?></label>
        <span><?php esc_html_e('Enhance your customer experience of product pages with downloadable files, such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. A plugin will help you to attach/ upload any kind of files (doc, jpg, videos, pdf) for a customer orders.', $plugin_txt_domain) ?></span><br>

        <span><?php esc_html_e('Attachments can be downloadable/viewable on the Order details and/or Product pages. This will help customers to get more details about products they purchase.', $plugin_txt_domain) ?></span>

    </div>
        <div <?php $this->wcpoa_esc_attr_e($div); ?>>
            <table class="wcpoa-table">
                <tbody class="wcpoa-ui-sortable" id='wcpoa-ui-tbody'>
                    <?php
                    $wcpoa_assignment = "";
                    $wcpoa_attachments_id = "";
                    if($wcpoa_bulk_att_data) {
                        $i = 0;
                        foreach ($wcpoa_bulk_att_data as $key => $wcpoa_bulk_att_data_value) {

                            if (!empty($wcpoa_bulk_att_data_value)) {

                                $wcpoa_attachments_id = $key; //attachement id  

                                $attachment_name = isset($wcpoa_bulk_att_data[$key]['wcpoa_attachment_name']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_attachment_name']) ? $wcpoa_bulk_att_data[$key]['wcpoa_attachment_name'] : '';


                                $wcpoa_attach_type = isset($wcpoa_bulk_att_data[$key]['wcpoa_attach_type']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_attach_type']) ? $wcpoa_bulk_att_data[$key]['wcpoa_attach_type'] : '';
                                $wcpoa_attachment_url = isset($wcpoa_bulk_att_data[$key]['wcpoa_attachment_url']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_attachment_url']) ? $wcpoa_bulk_att_data[$key]['wcpoa_attachment_url'] : '';
                                $wcpoa_attachment_file_id = isset($wcpoa_bulk_att_data[$key]['wcpoa_attachment_file']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_attachment_file']) ? $wcpoa_bulk_att_data[$key]['wcpoa_attachment_file'] : '';



                                $wcpoa_product_list_sel = isset($wcpoa_bulk_att_data[$key]['wcpoa_product_list']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_product_list']) ? $wcpoa_bulk_att_data[$key]['wcpoa_product_list'] : '';

                                $wcpoa_category_list_sel = isset($wcpoa_bulk_att_data[$key]['wcpoa_category_list']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_category_list']) ? $wcpoa_bulk_att_data[$key]['wcpoa_category_list'] : '';
                                $wcpoa_tag_list_sel = isset($wcpoa_bulk_att_data[$key]['wcpoa_tag_list']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_tag_list']) ? $wcpoa_bulk_att_data[$key]['wcpoa_tag_list'] : '';


                                $wcpoa_assignment = isset($wcpoa_bulk_att_data_value['wcpoa_assignment']) && !empty($wcpoa_bulk_att_data_value['wcpoa_assignment']) ? $wcpoa_bulk_att_data_value['wcpoa_assignment'] : '';  


                                $wcpoa_apply_cat = isset($wcpoa_bulk_att_data_value['wcpoa_apply_cat']) && !empty($wcpoa_bulk_att_data_value['wcpoa_apply_cat']) ? $wcpoa_bulk_att_data_value['wcpoa_apply_cat'] : '';
                                $wcpoa_attachment_descriptions = isset($wcpoa_bulk_att_data[$key]['wcpoa_attachment_description']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_attachment_description']) ? $wcpoa_bulk_att_data[$key]['wcpoa_attachment_description'] : '';
                                $wcpoa_is_condition = isset($wcpoa_bulk_att_data[$key]['wcpoa_is_condition']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_is_condition']) ? $wcpoa_bulk_att_data[$key]['wcpoa_is_condition'] : '';
                                $visible=isset($wcpoa_is_condition) && $wcpoa_is_condition==='yes'?'':'hide';
                                $wcpoa_visibility = isset($wcpoa_bulk_att_data[$key]['wcpoa_att_visibility']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_att_visibility']) ? $wcpoa_bulk_att_data[$key]['wcpoa_att_visibility'] : '';
                                $wcpoa_product_date_enable = isset($wcpoa_bulk_att_data[$key]['wcpoa_expired_date_enable']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_expired_date_enable']) ? $wcpoa_bulk_att_data[$key]['wcpoa_expired_date_enable'] : '';
                                $wcpoa_expired_dates = isset($wcpoa_bulk_att_data[$key]['wcpoa_expired_date']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_expired_date']) ? $wcpoa_bulk_att_data[$key]['wcpoa_expired_date'] : '';    

                                $wcpoa_att_time_amount = isset($wcpoa_bulk_att_data[$key]['wcpoa_attachment_time_amount']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_attachment_time_amount']) ? $wcpoa_bulk_att_data[$key]['wcpoa_attachment_time_amount'] : '';    
                                $wcpoa_att_time_type = isset($wcpoa_bulk_att_data[$key]['wcpoa_attachment_time_type']) && !empty($wcpoa_bulk_att_data[$key]['wcpoa_attachment_time_type']) ? $wcpoa_bulk_att_data[$key]['wcpoa_attachment_time_type'] : '';    

                                $wcpoa_order_status_value = isset($wcpoa_bulk_att_data_value['wcpoa_order_status']) && !empty($wcpoa_bulk_att_data_value['wcpoa_order_status']) ? $wcpoa_bulk_att_data_value['wcpoa_order_status'] : '';
                                if( empty( $wcpoa_order_status_value )) {
                                    $wcpoa_order_status = array();
                                } else {
                                    $wcpoa_order_status = $wcpoa_order_status_value;
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
                                    if ($o['url']) {

                                        $filediv['class'] .= ' has-value';
                                    }
                                }
                                ?>
                                <tr  class="wcpoa-row wcpoa-has-value -collapsed" id="<?php echo esc_attr($wcpoa_attachments_id) ?>" data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>">

                                    <?php if ($show_order) { ?>
                                        <td class="wcpoa-row-handle order" title="<?php esc_html_e('Drag to reorder', $plugin_txt_domain); ?>">
                                            <a class="wcpoa-icon -collapse small" href="#" data-event="collapse-row" title="<?php esc_html_e('Click to toggle', $plugin_txt_domain); ?>"></a>
                                               <?php // } ?>
                                            <span><?php echo intval($i) + 1; ?></span>
                                        </td>
                                    <?php } ?>
                                    <?php echo wp_kses($before_fields,$this->allowed_html_tags()); ?>
                                    <div class="wcpoa-field -collapsed-target group-title" data-name="_name" data-type="text" data-key="">
                                        <div class="wcpoa-label">
                                            <label for="attchment_name"><?php esc_html_e('Attachment : ',$plugin_txt_domain); ?><?php echo intval($i+1); $i++; ?></label>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-text" data-name="id" data-type="text" data-key="">
                                        <div class="wcpoa-label">
                                            <label for=""><?php esc_html_e('Id',$plugin_txt_domain) ?> </label>
                                            <p class="description"><?php esc_html_e('Attachments Id used to identify each product attachment.This value is automatically generated.',$plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-input-wrap">
                                                <input readonly="" class="wcpoa_attachments_id" name="wcpoa_attachments_id[]" value="<?php echo esc_attr($wcpoa_attachments_id); ?>" placeholder="" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field -collapsed-target" data-name="_name" data-type="text" data-key="">
                                        <div class="wcpoa-label">
                                            <label for="attchment_name"><?php esc_html_e('Attachment Name',$plugin_txt_domain); ?><span class="wcpoa-required"> *</span></label>
                                            <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input wcpoa-att-name-parent">
                                            <input class="wcpoa-attachment-name"  type="text" name="wcpoa_attachment_name[]"  value="<?php echo esc_attr($attachment_name); ?>">
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-textarea " data-name="description" data-type="textarea" data-key="" data-required="1">
                                        <div class="wcpoa-label">
                                            <label for="attchment_desc"><?php esc_html_e('Attachment Description',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('You can type a short description of the attachment file. So User will get details about attachment file.', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <textarea class="" name="wcpoa_attachment_description[]" placeholder="" rows="8"><?php echo esc_html($wcpoa_attachment_descriptions); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-select -collapsed-target">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_attach_type"><?php esc_html_e('Attachment Type',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Attachment Type?',$plugin_txt_domain); ?></p>
                                        </div>

                                        <div class="wcpoa-input wcpoa_attach_type">
                                            <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                                <option name="file_upload" <?php echo ($wcpoa_attach_type === "file_upload") ? 'selected' : '';  ?> value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                                <option name="external_ulr" <?php echo ($wcpoa_attach_type === "external_ulr") ? 'selected' : '';  ?> value="external_ulr" class=""><?php esc_html_e('External URL', $plugin_txt_domain) ?></option>
                                            </select>
                                        </div> 
                                    </div>
                                    <?php  $is_show= $wcpoa_attach_type!=='file_upload'?"none":""?>  
                                    <div style='display:<?php  echo esc_attr($is_show);  ?>' class="wcpoa-field file_upload wcpoa-field-file -collapsed-target required" data-name="file" data-type="file" data-key="" data-required="1">
                                        <div class="wcpoa-label">
                                            <label for=""><?php esc_html_e('Upload Attachment',$plugin_txt_domain); ?>
                                                <span class="wcpoa-required"> *</span></label>
                                            <p  class="description"><?php esc_html_e('Upload Attachment File.', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div <?php $this->wcpoa_esc_attr_e($filediv); ?> data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>">
                                                <div class="wcpoa-error-message"><p><?php echo 'File value is required'; ?></p>
                                                    <input name="wcpoa_attachment_file[]" value="<?php echo esc_attr($wcpoa_attachment_file_id) ?>" data-name="id" type="hidden" required="required">
                                                </div>    
                                                <div class="show-if-value file-wrap wcpoa-soh">
                                                    <div class="file-icon">
                                                        <img data-name="icon" src="<?php echo esc_url($o['icon']); ?>" alt=""/>
                                                    </div>
                                                    <div class="file-info">
                                                        <p>
                                                            <strong data-name="title"><?php echo esc_html($o['title']); ?></strong>
                                                        </p>
                                                        <p>
                                                            <strong><?php esc_html_e('File name', $plugin_txt_domain); ?>:</strong>
                                                            <a data-name="filename" href="<?php echo esc_url($o['url']); ?>" target="_blank"><?php echo esc_html($o['filename']); ?></a>
                                                        </p>
                                                        <p>
                                                            <strong><?php esc_html_e('File size', $plugin_txt_domain); ?>:</strong>
                                                            <span data-name="filesize"><?php echo esc_html($o['filesize']); ?></span>
                                                        </p>

                                                        <ul class="wcpoa-hl wcpoa-soh-target">
                                                            <?php if ($uploader !== 'basic'): ?>
                                                                <li><a class="wcpoa-icon -pencil dark" data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>" data-name="edit" href="#"></a></li>
                                                            <?php endif; ?>
                                                            <li><a class="wcpoa-icon -cancel dark" data-id="<?php echo esc_attr($wcpoa_attachments_id) ?>" data-name="remove" href="#"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="hide-if-value">
                                                    <?php echo wp_kses($this->misha_image_uploader_field($wcpoa_attachments_id),$this->allowed_html_tags()); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php  $is_show= $wcpoa_attach_type!=='external_ulr'?"none":""?>     
                                    <div style='display:<?php  echo esc_attr($is_show)  ?>' class="wcpoa-field -collapsed-target external_ulr" style=''>
                                        <div class="wcpoa-label">
                                            <label for="attchment_name"><?php esc_html_e('Attach an external URL',$plugin_txt_domain); ?><span class="wcpoa-required"> *</span></label>
                                            <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <input class="wcpoa-attachment-url" type="text" name="wcpoa_attachment_url[]" value="<?php echo esc_attr($wcpoa_attachment_url); ?>">
                                        </div>
                                    </div>

                                    <!-- nirav code start --> 
                                    <div class="wcpoa-field wcpoa-field-select" data-type="select">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_sel_product"><?php esc_html_e('Attachment Condition', $plugin_txt_domain); ?></label>
                                            <p></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select name="wcpoa_is_condition[]" class="is_condition_select" >
                                                <option value="no" <?php echo $wcpoa_is_condition==='no'?"selected":'' ?>><?php esc_html_e('Attachment For All Product', $plugin_txt_domain); ?></option>
                                                <option value="yes" <?php echo $wcpoa_is_condition==='yes'?"selected":'' ?>><?php esc_html_e('Attachment For Specific item(s)/category(ies)/tag(s)', $plugin_txt_domain); ?></option>
                                            </select>
                                        </div>
                                    </div> 

                                    <!-- nirav code start --> 
                                    <div class="wcpoa-field wcpoa-field-select is_condition <?php echo esc_attr($visible) ?>" data-type="select">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_sel_product"><?php esc_html_e('Select Product', $plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Select products for bulk attachment apply.',$plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select name="wcpoa_product_list[<?php echo esc_attr($wcpoa_attachments_id) ?>][]" class="productlist select2 select2-hidden-accessible wcpoa_product_value" multiple="multiple">
                                               <?php echo wp_kses($this->wcpoa_get_product_list__premium_only($wcpoa_product_list_sel),$this->allowed_html_tags()); ?>
                                            </select>
                                        </div>
                                    </div> 
                                    <!-- nirav code end -->  
                                    <div class="wcpoa-field wcpoa-field-select is_condition <?php echo esc_attr($visible) ?>" data-type="select">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_sel_cat"><?php esc_html_e('Select Category',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Select category for bulk attachment apply.',$plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input wcpoa-pro-category-parent">
                                            <select name="wcpoa_category_list[<?php echo esc_attr($wcpoa_attachments_id) ?>][]" class="catlist select2 select2-hidden-accessible wcpoa_product_value" multiple="multiple">
                                                <?php echo wp_kses($this->wcpoa_get_category_list__premium_only( $wcpoa_category_list_sel ),$this->allowed_html_tags()); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="wcpoa-field wcpoa-field-select is_condition <?php echo esc_attr($visible) ?>" data-type="select">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_sel_cat"><?php esc_html_e('Select Tag',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Select Tag for bulk attachment apply.',$plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input wcpoa-pro-tag-parent">
                                            <input idata-ui="1" data-ajax="0" data-multiple="1" data-placeholder="Select" data-allow_null="0" multiple="" size="5" tabindex="-1" aria-hidden="true"d="" name="" value="" type="hidden" >
                                            <select name="wcpoa_tag_list[<?php echo esc_attr($wcpoa_attachments_id) ?>][]" class="taglist select2 select2-hidden-accessible wcpoa_product_value" multiple="multiple">
                                                <?php echo wp_kses($this->wcpoa_get_tag_list__premium_only( $wcpoa_tag_list_sel),$this->allowed_html_tags()); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- nirav code start -->
                                    <div class="wcpoa-field is_condition <?php echo esc_attr($visible) ?>">
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_assignment"><?php esc_html_e('Assignment',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('You can assign a scheduling rule to selected items/categories or to all excluding the selected ones.',$plugin_txt_domain); ?></p>
                                        </div>

                                        <div class="wcpoa-input">
                                            <select name="wcpoa_assignment[]" class="<?php echo esc_attr($wcpoa_assignment); ?>" data-type="" data-key="">
                                                <option name="include" <?php echo ( 'include' === $wcpoa_assignment  ? 'selected' : ''); ?> value="include"><?php esc_html_e('For all selected item',$plugin_txt_domain) ?></option>
                                                
                                                <option name="exclude" <?php echo ( 'exclude' === $wcpoa_assignment  ? 'selected' : ''); ?> value="exclude"><?php esc_html_e('Except the selected item(s)/category(ies)/tag(s)',$plugin_txt_domain) ?></option>
                                            </select>
                                        </div>.
                                    </div>
                                    <!-- nirav code end -->
                                    <div class="wcpoa-field is_condition <?php echo esc_attr($visible) ?>" data-name="wcam_categories_children" data-key="children-categories" data-required="1">
                                            <div class="wcpoa-label">
                                                <label for="wcpoa-field_children_categories"><?php esc_html_e('Children categories', $plugin_txt_domain)?></label>
                                                    <p class="description"><?php esc_html_e('If at least one category has been selected, you can decide to apply the scheduling rule also to children categories items.', $plugin_txt_domain)?></p>
                                            </div>
                                            <div class="wcpoa-input">
                                                <select id="wcpoa_product_page_enable" name="wcpoa_apply_cat[]">
                                                    <option name="wcpoa_cat_selected_only" <?php echo ( 'wcpoa_cat_selected_only' === $wcpoa_apply_cat  ? 'selected' : ''); ?> value="wcpoa_cat_selected_only"><?php esc_html_e('Apply to selected categories only',$plugin_txt_domain) ?></option>
                                                    <option name="wcpoa_all_childcategories" <?php echo ( 'wcpoa_all_childcategories' === $wcpoa_apply_cat  ? 'selected' : ''); ?> value="wcpoa_all_childcategories"><?php esc_html_e('Apply to selected categories and all its children',$plugin_txt_domain) ?></option>
                                                </select>	
                                            </div>
                                    </div>
                                    
                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                        <label for="product_page_enable">
                                            <?php esc_html_e('Attachment Visibility',$plugin_txt_domain); ?></label>
                                            <p  class="description"><?php esc_html_e('Show on Product Details Page / Order Page.',$plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select id="wcpoa_product_page_enable" name="wcpoa_att_visibility[]">
                                                <option name="order_details_page" <?php echo ($wcpoa_visibility === "order_details_page") ? 'selected' : '';  ?> value="order_details_page"><?php esc_html_e('Order Details Page',$plugin_txt_domain) ?></option>
                                                <option name="product_details_page" <?php echo ($wcpoa_visibility === "product_details_page") ? 'selected' : ''; ?> value="product_details_page"><?php esc_html_e('Product Details Page',$plugin_txt_domain) ?></option>
                                                <option name="wcpoa_all" <?php echo ($wcpoa_visibility === "wcpoa_all") ? 'selected' : '';  ?> value="wcpoa_all"><?php esc_html_e('Both',$plugin_txt_domain) ?></option>                                          
                                            </select>

                                        </div>
                                    </div>
                                    <div class="wcpoa-field">
                                        <div class="wcpoa-label">
                                            <label for="attchment_order_status">
                                                <?php esc_html_e('Order status',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Select order status for which the attachment(s) will be visible.Leave unselected to apply to all.',$plugin_txt_domain); ?></p>
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
                                            <label for="wcpoa_expired_date_enable"><?php esc_html_e('Set expire date/time ',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('Expires?',$plugin_txt_domain); ?></p>
                                        </div>
                                        <div class="wcpoa-input enable_expire_date">
                                            <select name="wcpoa_expired_date_enable[]" class="enable_date_time" data-type="enable_date_<?php echo esc_attr($wcpoa_attachments_id); ?>" data-key="">                       
                                                <option name="no" <?php  echo ($wcpoa_product_date_enable === "no") ? 'selected' : '';  ?> value="no" class=""><?php esc_html_e('No',$plugin_txt_domain) ?></option>
                                                <option name="yes" <?php  echo ($wcpoa_product_date_enable === "yes") ? 'selected' : ''; ?> value="yes"><?php esc_html_e('Specific Date',$plugin_txt_domain) ?></option>
                                                <option name="time_amount" <?php  echo ($wcpoa_product_date_enable === "time_amount") ? 'selected' : ''; ?> value="time_amount"><?php esc_html_e('Selected time period after purchase',$plugin_txt_domain) ?></option>
                                            </select>


                                        </div>
                                    </div>
                                        <?php $is_date=$wcpoa_product_date_enable!=='yes'?'none':''; ?>   
                                        <div style="display:<?php  echo esc_attr($is_date)  ?>"class="wcpoa-field enable_date enable_date_<?php echo esc_attr($wcpoa_attachments_id); ?> wcpoa-field-date-picker" data-name="date" data-type="date_picker" data-key="" data-required="1" style=''>
                                        <div class="wcpoa-label">
                                            <label for="wcpoa_expired_date"><?php esc_html_e('Set Date',$plugin_txt_domain); ?></label>
                                            <p class="description"><?php esc_html_e('If an order is placed after the selected date, the attachments will be no longer visible for download',$plugin_txt_domain) ?></p>
                                        </div>
                                        <div class="wcpoa-input">
                                            <div class="wcpoa-date-picker wcpoa-input-wrap" data-date_format="yy/mm/dd">
                                                
                                                <input name="wcpoa_expired_date[]" class="input wcpoa-php-date-picker" value="<?php echo esc_attr(($wcpoa_product_date_enable === "yes") ? $wcpoa_expired_dates : ''); ?>" type="text">
                                            </div>
                                        </div>

                                    </div>
                                        <?php $is_time=$wcpoa_product_date_enable!=='time_amount'?'none':''; ?> <div class="wcpoa-field enable_time" style='display:<?php  echo esc_attr($is_time)  ?>'>
                                        <div class="wcpoa-label">
                                            <label for="attchment_time_amount"><?php esc_html_e('Time Period',$plugin_txt_domain); ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <input class="wcpoa-attachment-_time-amount" type="number" name="wcpoa_attachment_time_amount[]" value="<?php echo esc_attr($wcpoa_att_time_amount); ?>" >
                                        </div>

                                        <div class="wcpoa-label">
                                            <label for="attchment_time_type"><?php esc_html_e('Time Period Type',$plugin_txt_domain); ?></label>
                                        </div>
                                        <div class="wcpoa-input">
                                            <select name="wcpoa_attachment_time_type[]" class="wcpoa-attachment-time-type" data-type="" data-key="">
                                                <option name="seconds" value="seconds" <?php  echo ($wcpoa_att_time_type === "seconds") ? 'selected' : '';  ?>><?php esc_html_e('Seconds', $plugin_txt_domain) ?></option>
                                                <option name="minutes" value="minutes" <?php  echo ($wcpoa_att_time_type === "minutes") ? 'selected' : '';  ?>><?php esc_html_e('Minutes', $plugin_txt_domain) ?></option>
                                                <option name="hours" value="hours" <?php  echo ($wcpoa_att_time_type === "hours") ? 'selected' : '';  ?>><?php esc_html_e('Hours', $plugin_txt_domain) ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php echo wp_kses($after_fields,$this->allowed_html_tags()); ?>
                                    <?php if ($show_remove): ?>
                                        <td class="wcpoa-row-handle remove">
                                            <a class="wcpoa-icon -plus small wcpoa-js-tooltip" href="#" data-event="add-row" title="<?php esc_html_e('Add row',$plugin_txt_domain); ?>"></a>
                                            <a class="wcpoa-icon -minus small wcpoa-js-tooltip" href="#" data-event="remove-row" title="<?php esc_html_e('Remove row',$plugin_txt_domain); ?>"></a>
                                        </td>
                                    <?php endif; ?>

                                </tr>
                            <?php
                            }
                        }   
                    }  ?>
                    <tr  class="hidden trr wcpoa-row wcpoa-has-value" data-id="">

                        <?php if ($show_order) { ?>
                            <td class="wcpoa-row-handle order" title="<?php esc_html_e('Drag to reorder', $plugin_txt_domain); ?>">
                                <a class="wcpoa-icon -collapse small" href="#" data-event="collapse-row" title="<?php esc_html_e('Click to toggle', $plugin_txt_domain); ?>"></a>
                                   <?php // } ?>
                                <span><?php echo intval($i) + 1; ?></span>
                            </td>
                        <?php } ?>
                        <?php echo wp_kses($before_fields,$this->allowed_html_tags()); ?>
                        <div class="wcpoa-field -collapsed-target group-title" data-name="_name" data-type="text" data-key="">
                            <div class="wcpoa-label">
                                <label for="attchment_name"><?php esc_html_e('Attachment : ',$plugin_txt_domain); ?><?php echo intval($i+1); $i++; ?></label>
                            </div>
                        </div>
                        <div class="wcpoa-field wcpoa-field-text" data-name="id" data-type="text" data-key="">
                            <div class="wcpoa-label">
                                <label for=""><?php esc_html_e('Id',$plugin_txt_domain) ?> </label>
                                <p class="description"><?php esc_html_e('Attachments Id used to identify each product attachment.This value is automatically generated.',$plugin_txt_domain) ?></p>
                            </div>
                            <div class="wcpoa-input">
                                <div class="wcpoa-input-wrap">
                                    <input readonly="" class="wcpoa_attachments_id" name="wcpoa_attachments_id[]" value="" placeholder="" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="wcpoa-field -collapsed-target" data-name="_name" data-type="text" data-key="">
                            <div class="wcpoa-label">
                                <label for="attchment_name"><?php esc_html_e('Attachment Name',$plugin_txt_domain); ?><span class="wcpoa-required"> *</span></label>
                                <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                            </div>
                            <div class="wcpoa-input wcpoa-att-name-parent">
                                <input class="wcpoa-attachment-name" type="text" name="wcpoa_attachment_name[]"  value=""  >
                            </div>
                        </div>
                        <div class="wcpoa-field wcpoa-field-textarea " data-name="description" data-type="textarea" data-key="" data-required="1">
                            <div class="wcpoa-label">
                                <label for="attchment_desc"><?php esc_html_e('Attachment Description',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('You can type a short description of the attachment file. So User will get details about attachment file.', $plugin_txt_domain) ?></p>
                            </div>
                            <div class="wcpoa-input">
                                <textarea class="" name="wcpoa_attachment_description[]" placeholder="" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="wcpoa-field wcpoa-field-select -collapsed-target">
                            <div class="wcpoa-label">
                                <label for="wcpoa_attach_type"><?php esc_html_e('Attachment Type',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('Attachment Type?',$plugin_txt_domain); ?></p>
                            </div>

                            <div class="wcpoa-input wcpoa_attach_type">
                                <select name="wcpoa_attach_type[]" class="wcpoa_attach_type_list" data-type="" data-key="">
                                    <option name="file_upload"  value="file_upload"><?php esc_html_e('File Upload', $plugin_txt_domain) ?></option>
                                    <option name="external_ulr"  value="external_ulr" class=""><?php esc_html_e('External URL', $plugin_txt_domain) ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="wcpoa-field file_upload wcpoa-field-file -collapsed-target required" data-name="file" data-type="file" data-key="" data-required="1">
                            <div class="wcpoa-label">
                                <label for=""><?php esc_html_e('Upload Attachment',$plugin_txt_domain); ?>
                                    <span class="wcpoa-required"> *</span></label>
                                <p  class="description"><?php esc_html_e('Upload Attachment File.', $plugin_txt_domain) ?></p>
                            </div>
                            <div class="wcpoa-input">

                                <div class="wcpoa-file-uploader wcpoa-cf">
                                    <div class="wcpoa-error-message"><p><?php echo 'File value is required'; ?></p>
                                        <input name="wcpoa_attachment_file[]"  data-name="id" type="hidden" required="required">
                                    </div>    
                                    <div class="show-if-value file-wrap wcpoa-soh">
                                        <div class="file-icon">
                                            <img data-name="icon" src="<?php echo esc_url($plugin_url).'admin/images/default.png';?>" alt="" title="">
                                        </div>
                                        <div class="file-info">
                                            <p>
                                                <strong data-name="title"></strong>
                                            </p>
                                            <p>
                                                <strong><?php esc_html_e('File name', $plugin_txt_domain); ?>:</strong>
                                                <a data-name="filename" href="" target="_blank"></a>
                                            </p>
                                            <p>
                                                <strong><?php esc_html_e('File size', $plugin_txt_domain); ?>:</strong>
                                                <span data-name="filesize"></span>
                                            </p>

                                            <ul class="wcpoa-hl wcpoa-soh-target">
                                                <li><a class="wcpoa-icon -pencil dark" data-name="edit" href="#"></a></li>
                                                <li><a class="wcpoa-icon -cancel dark" data-name="remove" href="#"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="hide-if-value">
                                        <?php echo wp_kses($this->misha_image_uploader_field('test'),$this->allowed_html_tags()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div style='display: none' class="wcpoa-field -collapsed-target external_ulr" style=''>
                            <div class="wcpoa-label">
                                <label for="attchment_name"><?php esc_html_e('Attach an external URL',$plugin_txt_domain); ?><span class="wcpoa-required"> *</span></label>
                                <p class="description"><?php esc_html_e('Add a product attachment (downloadable files) name like such as technical descriptions, certificates, and licenses, user guides, and manuals, etc. It will be displayed in the front end', $plugin_txt_domain) ?></p>
                            </div>
                            <div class="wcpoa-input">
                                <input class="wcpoa-attachment-url" type="text" name="wcpoa_attachment_url[]" value="">
                            </div>
                        </div>


                        <!-- nirav code start --> 
                        <div class="wcpoa-field wcpoa-field-select" data-type="select">
                            <div class="wcpoa-label">
                                <label for="wcpoa_sel_product"><?php esc_html_e('Attachment Condition', $plugin_txt_domain); ?></label>
                                <p></p>
                            </div>
                            <div class="wcpoa-input">
                                <select name="wcpoa_is_condition[]" class="is_condition_select" >
                                    <option value="no" ><?php esc_html_e('Attachment For All Product', $plugin_txt_domain); ?></option>
                                    <option value="yes"><?php esc_html_e('Attachment For Specific item(s)/category(ies)/tag(s)', $plugin_txt_domain); ?></option>
                                </select>
                            </div>
                        </div> 

                        <!-- nirav code start --> 
                        <div class="wcpoa-field wcpoa-field-select is_condition hide" data-type="select">
                            <div class="wcpoa-label">
                                <label for="wcpoa_sel_product"><?php esc_html_e('Select Product', $plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('Select products for bulk attachment apply.',$plugin_txt_domain); ?></p>
                            </div>
                            <div class="wcpoa-input">

                                <select  name="wcpoa_product_list[][]" class="productlist wcpoa_product_list select2 select2-hidden-accessible wcpoa_product_value" multiple="multiple">
                                   <?php echo wp_kses($this->wcpoa_get_product_list__premium_only(),$this->allowed_html_tags()); ?>
                                </select>
                            </div>
                        </div> 
                        <!-- nirav code end -->  
                        <div class="wcpoa-field wcpoa-field-select is_condition hide"  data-type="select">
                            <div class="wcpoa-label">
                                <label for="wcpoa_sel_cat"><?php esc_html_e('Select Category',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('Select category for bulk attachment apply.',$plugin_txt_domain); ?></p>
                            </div>
                            <div class="wcpoa-input wcpoa-pro-category-parent">
                                
                                <select   name="wcpoa_category_list[][]" class="catlist wcpoa_category_list select2 select2-hidden-accessible wcpoa_category_value" multiple="multiple" >
                                    <?php echo wp_kses($this->wcpoa_get_category_list__premium_only(),$this->allowed_html_tags()); ?>
                                </select>
                            </div>
                        </div>
                        <div class="wcpoa-field wcpoa-field-select is_condition hide" data-type="select">
                            <div class="wcpoa-label">
                                <label for="wcpoa_sel_cat"><?php esc_html_e('Select Tag',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('Select Tag for bulk attachment apply.',$plugin_txt_domain); ?></p>
                            </div>
                            <div class="wcpoa-input wcpoa-pro-tag-parent">

                                <select  name="wcpoa_category_list[][]" class="taglist wcpoa_tag_list select2 select2-hidden-accessible wcpoa_tag_value" multiple="multiple" >
                                    <?php echo wp_kses($this->wcpoa_get_tag_list__premium_only(),$this->allowed_html_tags()); ?>
                                </select>


                            </div>
                        </div>
                        <!-- nirav code start -->
                        <div class="wcpoa-field is_condition hide">
                            <div class="wcpoa-label">
                                <label for="wcpoa_assignment"><?php esc_html_e('Assignment',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('You can assign a scheduling rule to selected items/categories or to all excluding the selected ones.',$plugin_txt_domain); ?></p>
                            </div>
                            <div class="wcpoa-input">
                                <select name="wcpoa_assignment[]" class="<?php echo esc_attr($wcpoa_assignment); ?>" data-type="" data-key="">
                                    <option name="include"  value="include"><?php esc_html_e('For all selected item',$plugin_txt_domain) ?></option>
                                    
                                    <option name="exclude"  value="exclude"><?php esc_html_e('Except the selected item(s)/category(ies)/tag(s)',$plugin_txt_domain) ?></option>
                                </select>
                            </div>
                        </div>
                        <!-- nirav code end -->
                        <div class="wcpoa-field is_condition hide" data-name="wcam_categories_children" data-key="children-categories" data-required="1">
                                <div class="wcpoa-label">
                                    <label for="wcpoa-field_children_categories"><?php esc_html_e('Children categories', $plugin_txt_domain)?></label>
                                        <p class="description"><?php esc_html_e('If at least one category has been selected, you can decide to apply the scheduling rule also to children categories items.', $plugin_txt_domain)?></p>
                                </div>
                                <div class="wcpoa-input">
                                    <select id="wcpoa_product_page_enable"  name="wcpoa_apply_cat[]">
                                        <option name="wcpoa_cat_selected_only"  value="wcpoa_cat_selected_only"><?php esc_html_e('Apply to selected categories only',$plugin_txt_domain) ?></option>
                                        <option name="wcpoa_all_childcategories"  value="wcpoa_all_childcategories"><?php esc_html_e('Apply to selected categories and all its children',$plugin_txt_domain) ?></option>
                                    </select>   
                                </div>
                        </div>

                        <div class="wcpoa-field">
                            <div class="wcpoa-label">
                            <label for="product_page_enable">
                                <?php esc_html_e('Attachment Visibility',$plugin_txt_domain); ?></label>
                                <p  class="description"><?php esc_html_e('Show on Product Details Page / Order Page.',$plugin_txt_domain); ?></p>
                            </div>
                            <div class="wcpoa-input">
                                <select id="wcpoa_product_page_enable" name="wcpoa_att_visibility[]">
                                    <option name="order_details_page"  value="order_details_page"><?php esc_html_e('Order Details Page',$plugin_txt_domain) ?></option>
                                    <option name="product_details_page"  value="product_details_page"><?php esc_html_e('Product Details Page',$plugin_txt_domain) ?></option>
                                    <option name="wcpoa_all"  value="wcpoa_all"><?php esc_html_e('Both',$plugin_txt_domain) ?></option>                                          
                                </select>

                            </div>
                        </div>
                        <div class="wcpoa-field">
                            <div class="wcpoa-label">
                                <label for="attchment_order_status">
                                    <?php esc_html_e('Order status',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('Select order status for which the attachment(s) will be visible.Leave unselected to apply to all.',$plugin_txt_domain); ?></p>
                            </div>
                            <div class="wcpoa-input">
                                <ul class="wcpoa-checkbox-list wcpoa-order-checkbox-list">
                                    <li><label for="wcpoa_wc_order_completed">
                                            <input name="wcpoa_order_status[][]"
                                                   class="" value="wcpoa-wc-completed" type="checkbox">
                                                   <?php esc_html_e('Completed', $plugin_txt_domain); ?>
                                        </label>
                                    </li>
                                    <li><label for="wcpoa_wc_order_on_hold">
                                            <input name="wcpoa_order_status[][]"
                                                   class="" value="wcpoa-wc-on-hold" type="checkbox">
                                                   <?php esc_html_e('On Hold', $plugin_txt_domain); ?>
                                        </label>
                                    </li>
                                    <li><label for="wcpoa_wc_order_pending">
                                            <input name="wcpoa_order_status[][]"
                                                   class="" value="wcpoa-wc-pending" type="checkbox">
                                                   <?php esc_html_e('Pending payment', $plugin_txt_domain); ?>
                                        </label>
                                    </li>
                                    <li><label for="wcpoa_wc_order_processing">
                                            <input name="wcpoa_order_status[][]"
                                                   class="" value="wcpoa-wc-processing" type="checkbox">
                                                   <?php esc_html_e('Processing', $plugin_txt_domain); ?>
                                        </label>
                                    </li>
                                    <li><label for="wcpoa_wc_order_cancelled">
                                            <input name="wcpoa_order_status[][]"
                                                   class="" value="wcpoa-wc-cancelled" type="checkbox">
                                                   <?php esc_html_e('Cancelled', $plugin_txt_domain); ?>
                                        </label>
                                    </li>
                                    <li><label for="wcpoa_wc_order_failed">
                                            <input name="wcpoa_order_status[][]"
                                                   class="" value="wcpoa-wc-failed" type="checkbox">
                                                   <?php esc_html_e('Failed', $plugin_txt_domain); ?>
                                        </label>
                                    </li>
                                    <li><label for="wcpoa_wc_order_refunded">
                                            <input name="wcpoa_order_status[][]"
                                                   class="" value="wcpoa-wc-refunded" type="checkbox">
                                                   <?php esc_html_e('Refunded', $plugin_txt_domain); ?>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="wcpoa-field">
                            <div class="wcpoa-label">
                                <label for="wcpoa_expired_date_enable"><?php esc_html_e('Set expire date/time ',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('Expires?',$plugin_txt_domain); ?></p>
                            </div>
                            <div class="wcpoa-input enable_expire_date">
                                <select name="wcpoa_expired_date_enable[]" class="enable_date_time" data-type="enable_date_<?php echo esc_attr($wcpoa_attachments_id); ?>" data-key="">                       
                                    <option name="no" value="no" class=""><?php esc_html_e('No',$plugin_txt_domain) ?></option>
                                    <option name="yes"  value="yes"><?php esc_html_e('Specific Date',$plugin_txt_domain) ?></option>
                                    <option name="time_amount"  value="time_amount"><?php esc_html_e('Selected time period after purchase',$plugin_txt_domain) ?></option>
                                </select>


                            </div>
                        </div>

                        <div style="display: none;" class="wcpoa-field enable_date enable_date_<?php echo esc_attr($wcpoa_attachments_id); ?> wcpoa-field-date-picker" data-name="date" data-type="date_picker" data-key="" data-required="1" style=''>
                            <div class="wcpoa-label">
                                <label for="wcpoa_expired_date"><?php esc_html_e('Set Date',$plugin_txt_domain); ?></label>
                                <p class="description"><?php esc_html_e('If an order is placed after the selected date, the attachments will be no longer visible for download',$plugin_txt_domain) ?></p>
                            </div>
                            <div class="wcpoa-input">
                                <div class="wcpoa-date-picker wcpoa-input-wrap" data-date_format="yy/mm/dd">
                                  
                                    <input class="input wcpoa-php-date-picker" name="wcpoa_expired_date[]"  type="text">
                                </div>
                            </div>

                        </div>
                        <div style="display: none;" class="wcpoa-field enable_time" style=''>
                            <div class="wcpoa-label">
                                <label for="attchment_time_amount"><?php esc_html_e('Time Period',$plugin_txt_domain); ?></label>
                            </div>
                            <div class="wcpoa-input">
                                <input class="wcpoa-attachment-_time-amount" type="number" name="wcpoa_attachment_time_amount[]" value="" >
                            </div>

                            <div class="wcpoa-label">
                                <label for="attchment_time_type"><?php esc_html_e('Time Period Type',$plugin_txt_domain); ?></label>
                            </div>
                            <div class="wcpoa-input">
                                <select name="wcpoa_attachment_time_type[]" class="wcpoa-attachment-time-type" data-type="" data-key="">
                                    <option name="seconds" value="seconds" ><?php esc_html_e('Seconds', $plugin_txt_domain) ?></option>
                                    <option name="minutes" value="minutes" ><?php esc_html_e('Minutes', $plugin_txt_domain) ?></option>
                                    <option name="hours" value="hours" ><?php esc_html_e('Hours', $plugin_txt_domain) ?></option>
                                </select>
                            </div>
                        </div>
                        <?php echo wp_kses($after_fields,$this->allowed_html_tags()); ?>
                        <?php if ($show_remove): ?>
                            <td class="wcpoa-row-handle remove">
                                <a class="wcpoa-icon -plus small wcpoa-js-tooltip" href="#" data-event="add-row" title="<?php esc_html_e('Add row',$plugin_txt_domain); ?>"></a>
                                <a class="wcpoa-icon -minus small wcpoa-js-tooltip" href="#" data-event="remove-row" title="<?php esc_html_e('Remove row',$plugin_txt_domain); ?>"></a>
                            </td>
                        <?php endif; ?>

                    </tr>
                </tbody>
            </table>
            <?php if ($show_add): ?>

                <ul class="wcpoa-actions wcpoa-hl">
                    <li>
                        <a class="wcpoa-button button button-primary"data-event="add-row"><?php esc_html_e('Add Attchment', $plugin_txt_domain) ?></a>
                    </li>
                    <li id="publishing-action">
                        <span class="spinner"></span>
                        <input type="submit" accesskey="p" value="Publish"
                               class="button button-primary button-large" id="publish" name="submitwcpoabulkatt">
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
<!--File validation-->

<!--End file validation-->
