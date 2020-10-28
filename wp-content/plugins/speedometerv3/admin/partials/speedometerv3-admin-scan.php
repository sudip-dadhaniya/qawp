<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Speedometerv3
 * @subpackage Speedometerv3/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/sm_header.php';
global $wpdb;
$plugin_name                  = SPEEDOMETERV3_PLUGIN_NAME;
$plugin_version               = SPEEDOMETERV3_VERSION;
$current_page                 = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
$speedometerv3_list_dashboard = ( isset( $current_page ) && 'speedometer' === $current_page ? 'active' : '' );
$speedometerv3_settings       = ( isset( $current_page ) && 'speedometer-setting' === $current_page ? 'active' : '' );
$speedometerv3_scan           = ( isset( $current_page ) && 'speedometer-scan' === $current_page ? 'active' : '' );

if ( $_GET['scan_id'] ) {

    // If so echo the value
    $scan_id = $_GET['scan_id'];
    $scan_table = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'scan_log';
    $query = 'SELECT data FROM '.$scan_table.' WHERE id = '.$scan_id;
    $results = $wpdb->get_var( $wpdb->prepare( $query ) );

    $scan_table = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_bank';
    $query = 'SELECT * FROM '.$scan_table;
    $suggestion_tbl = $wpdb->get_results( $wpdb->prepare( $query ), ARRAY_A );

    $scan_display_table = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'suggesation_scan_display';
    $query = 'SELECT scan_details FROM '.$scan_display_table.' WHERE scan_id = '.$scan_id;
    $scan_display_tbl = $wpdb->get_var( $wpdb->prepare( $query ) );
    $scan_display_tbl = json_decode( $scan_display_tbl, true );
    
    foreach( $suggestion_tbl as $result ){
        $tab_data[] = $result['param_type'];
    }
    $tab_titles = array_unique($tab_data);
    if( isset( $results ) && !empty( $results ) ) {
        $scan_data = json_decode( $results, true );
        ?>
       <div class="tab-wrap list-tab-wrap">
					<div class="container">
						<ul class="tabs scantab">
                            <?php
                                $counter = 1; 
                                foreach( array_values( $tab_titles ) as $title ){ ?>
                                    <?php 
                                        if( $counter == 1 ){ ?>
                                            <li class="active">
                                                <a href='#tab<?php echo $counter;?>'><?php esc_attr_e($title); ?></a>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <a href='#tab<?php echo $counter;?>'><?php esc_attr_e($title); ?></a>
                                            </li>
                                    <?php }
                                    $counter++;
                                }
                            ?>
						</ul>
					</div>
				</div>
				<div class="container">
					<div class="tab-content">
                            <?php
                            $tick = 1; 
                            foreach( array_values( $tab_titles ) as $title ){?>
                                           <div class="tab-cover <?php if($tick == 1){echo 'active';} ?>" id="tab<?php echo $tick; ?>">
                                                <div class="scan-data">
                                                    <table class="big-data">
                                                        <thead>
                                                            <tr>
                                                                <th class="number">No</th>
                                                                <th class="param_type">Parameter</th>
                                                                <th class="param_desc">Parameter Description</th>
                                                                <th class="param_value">Result</th>
                                                                <th class="param_ideal_value">Recommendation</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $active_counter = 0;
                                                        $suggestion_tbl_grp = group_by_type("param_type", $suggestion_tbl);
                                                        foreach( $suggestion_tbl_grp[$title] as $sugge_key => $title ){
                                                             if( $active_counter == 0 ) { 
                                                                    foreach( $scan_display_tbl as $scan_key => $scan_result_data ) {
                                                                        if( $scan_result_data['param_key'] === $title['param_key']){
                                                                            $suggestion_statement =  $scan_result_data['param_statement'];
                                                                            $param_value = $scan_result_data['param_value'];
                                                                            $param_ideal_value = $scan_result_data['param_ideal_value'];
                                                                            $param_border_type = $scan_result_data['param_border_type'];
                                                                        }
                                                                       
                                                                    }
                                                                ?>
                                                                <tr class="active" data-title="Recomended">
                                                                    <td class="number">
                                                                        <span>71</span>
                                                                    </td>
                                                                    <td class="title">
                                                                        <h3>Lorem ipsum dolor sit amet</h3>
                                                                        <p>consectetur adipisicing elit</p>
                                                                    </td>
                                                                    <td class="desc"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo distinctio incidunt deleniti quidem dolorum pariatur labore ducimus debitis ipsa atque.</p></td>
                                                                    <td class="tb-btn"><a href="#">Button</a></td>
                                                                    <td class="tb-btn"><a href="#" class="green-border">Button</a></td>
                                                                    <td class="expand"><i class="fa fa-angle-down" aria-hidden="true"></i></td>
                                                                    <td class="full-desc">
                                                                        <ul class="general-list">
                                                                            <li><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit Lorem ipsum dolor sit amet.</p></li>
                                                                            <li><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p></li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                <tr class="shadow-look">
                                                                    <?php 
                                                                        $param_key = $title['param_key']; 
                                                                        $param_type = $title['param_type'];
                                                                        
                                                                    ?>
                                                                    <td class="number">
                                                                        <span><?php echo $title['id']; ?></span>
                                                                    </td>
                                                                    <td class="title ">
                                                                        <h3 class="title"><?php echo $title['param_label']; ?>
                                                                    </td>
                                                                    <td class="desc"><p><?php echo $title['param_description']; ?></p></td>
                                                                    <td class="tb-btn"><a href="#" class="<?php echo $param_border_type; ?>"><?php echo $param_value; ?></a></td>
                                                                    <td class="tb-btn"><a href="#" class="green-border"><?php echo $param_ideal_value; ?></a></td>
                                                                    <td class="expand"><i class="fa fa-angle-down" aria-hidden="true"></i></td>
                                                                    <td class="full-desc">
                                                                        <ul class="general-list">
                                                                            <li><?php esc_html_e($suggestion_statement); ?></li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                            <?php } else { 
                                                                foreach( $scan_display_tbl as $scan_key => $scan_result_data ) {
                                                                    if( $scan_result_data['param_key'] === $title['param_key']){
                                                                        $suggestion_statement =  $scan_result_data['param_statement'];
                                                                        $param_value = $scan_result_data['param_value'];
                                                                        $param_ideal_value = $scan_result_data['param_ideal_value'];
                                                                        $param_border_type = $scan_result_data['param_border_type'];
                                                                    }
                                                                   
                                                                }
                                                                ?>
                                                            <tr class="shadow-look">
                                                                    <?php 
                                                                        $param_key = $title['param_key']; 
                                                                        $param_type = $title['param_type'];
                                                                    ?>
                                                                <td class="number">
                                                                        <span><?php echo $title['id']; ?></span>
                                                                    </td>
                                                                    <td class="title ">
                                                                        <h3 class="title"><?php echo $title['param_label']; ?>
                                                                    </td>
                                                                    <td class="desc"><p><?php echo $title['param_description']; ?></p></td>
                                                                    <td class="tb-btn"><a href="#" class="<?php echo $param_border_type; ?>"><?php echo $param_value; ?></a></td>
                                                                    <td class="tb-btn"><a href="#" class="green-border"><?php echo $param_ideal_value; ?></a></td>
                                                                    <td class="expand"><i class="fa fa-angle-down" aria-hidden="true"></i></td>
                                                                    <td class="full-desc">
                                                                        <ul class="general-list">
                                                                            <li><?php esc_html_e($suggestion_statement); ?></li>
                                                                        </ul>
                                                                    </td>
                                                            </tr>
                                                            <?php } 
                                                            $active_counter++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                <?php $tick++;
                                }
                        ?>
					</div>
				</div>
    <?php }
} else { ?>
    <div class="container">
        <div class="tab-content">
            <div class="tab-cover active">
                    <div class="scan-data">
                        <table class="small-data">
                            <thead>
                                    <tr>
                                        <th class="number">No</th>
                                        <th class="details">Scan Date</th>
                                        <th class="time">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $scan_table = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'scan_log';
                                    $query = 'SELECT * FROM '.$scan_table.' ORDER BY id DESC';
                                    $results = $wpdb->get_results( $wpdb->prepare( $query ) );
                                    foreach( $results as $result ){
                                ?>
                                    <tr>
                                        <td class="number"><span><?php echo $result->id; ?></span></td>
                                        <td class="details">
                                                <?php $date = date_create($result->updated_date);?>
                                            <a href="<?php echo ( site_url().'/wp-admin/admin.php?page=speedometer-scan&scan_id='.$result->id); ?>"><?php echo date_format($date, 'd-M-Y H:i:s'); ?></a>
                                        </td>
                                        <td class="time icons">
                                            <a href="<?php echo ( site_url().'/wp-admin/admin.php?page=speedometer-scan&scan_id='.$result->id); ?>" title="view this scan" class="btn btn-default btn-sm "> <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                            <a title="edit this scan" class="btn btn-default btn-sm "> <i class="fa fa-edit" aria-hidden="true"></i> </a>
                                            <a title="delete this scan" class="btn btn-default btn-sm "> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php }

function group_by_type($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}