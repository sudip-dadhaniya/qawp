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
$retrieved_nonce = ( empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) );
$pluginSettingBtnValue = __( 'Save Setting', SPEEDOMETERV3_TEXT_DOMAIN );
$scanBtnValue = __( 'SCAN', SPEEDOMETERV3_TEXT_DOMAIN );
$syncBtnValue = __( 'SYNC', SPEEDOMETERV3_TEXT_DOMAIN );


if ( isset( $_POST['submitPluginSetting'] ) && sanitize_text_field( wp_unslash( $_POST['submitPluginSetting'] ) ) === $pluginSettingBtnValue ) {

	if ( ! wp_verify_nonce( $retrieved_nonce, 'pluginSetting' ) ) {
		die( 'Failed security check' );
	} else {
		if( isset( $_POST['sync_status'] ) && !empty( $_POST['sync_status'] ) ) {
			if( isset( $_POST['token_val'] ) && !empty( $_POST['token_val'] ) ) {
				if ( method_exists( $this, 'sm_sync_update' ) ) {
					$updated_data = $this->sm_sync_update($_POST['token_val'], 1);
					$message = 'Plugin settings Updated !!!';
					$this->sm_notice( $message, 'success');
				}
			} else { 
				$message = 'Something went to wrong ! Please Try again.';
				$this->sm_notice( $message, 'error');
			 }
		} else {
			if( isset( $_POST['token_val'] ) && !empty( $_POST['token_val'] ) ) {
				if ( method_exists( $this, 'sm_sync_update' ) ) {
					$updated_data = $this->sm_sync_update($_POST['token_val'], 0);
					$message = 'Plugin settings Updated !!!';
					$this->sm_notice( $message, 'success');
			 }
			} else { 
				$message = 'Something went to wrong ! Please Try again.';
				$this->sm_notice( $message, 'error');
			}	
		}
	}
}

if ( isset( $_POST['submitSetting'] ) && sanitize_text_field( wp_unslash( $_POST['submitSetting'] ) ) === $scanBtnValue ) {

	if ( ! wp_verify_nonce( $retrieved_nonce, 'smSetting' ) ) {
		die( 'Failed security check' );
	} else {
		$data_post = new sm_environment();
		$scan_data_post = (array) $data_post;
		if ( method_exists( $this, 'sm_data_save' ) ) {
			$insert_id = $this->sm_data_save( $scan_data_post, 'scan' );
			if( $insert_id ) { 
				if ( method_exists( $this, 'sm_scan_display' ) ) {
					$scan_display_arr = $scan_data_post['data']['update_data'];
					foreach($scan_display_arr as $key => $csm) {
						$scan_display_arr[$key]['scan_id'] = $insert_id;
					}
					$this->sm_scan_display( $insert_id, $scan_display_arr );
				}
				$message = 'Congratulations! Your scaning is completed.';
				$this->sm_notice( $message, 'success');
			} else { 
				$message = 'Something went to wrong ! Please Try again.';
				$this->sm_notice( $message, 'error');
			 }
		}
		?>
		
		<!-- <table class="sm_table">
			<?php
			foreach ( $data_post->data as $key => $value ) {
				?>
				<tr>
					<th><?php  print_r( $key ) ?></th>
					<td>
						<?php
							echo '<pre>';
							print_r( $value );
							echo '</pre>';
						?>
					</td>
				</tr>
			<?php } ?>
		</table> -->
	<?php }
}

if ( isset( $_POST['submitSetting'] ) && sanitize_text_field( wp_unslash( $_POST['submitSetting'] ) ) === $syncBtnValue ) {

	if ( !wp_verify_nonce( $retrieved_nonce, 'smSetting' ) ) {
		die( 'Failed security check' );
	} else {
		$data_post = $_POST;
		if ( method_exists( $this, 'sm_data_save' ) ) {
			$this->sm_data_save( $data_post, 'sync' );
		}
	}
}
global $wpdb;
$table_nm = $wpdb->prefix . SPEEDOMETERV3_TABLE_PREFIX . 'configuration';
if ( is_multisite() ) {
	$sm_blog_details   = get_blog_details( $wpdb->blogid );
	$website_name      = $sm_blog_details->domain;
	$website_name      = site_url();
	$website_sh_record = $wpdb->get_row( "SELECT mercury_token,sync_data_pause FROM $table_nm WHERE website_url LIKE '%$website_name%'" ); //db call ok; no-cache ok
} else {
	//$website_name      = get_bloginfo();
	$website_name      = site_url();
	$website_sh_record = $wpdb->get_row( "SELECT mercury_token,sync_data_pause FROM $table_nm WHERE website_url LIKE '%$website_name%'" ); //db call ok; no-cache ok
}
?>
<div class="container">
	<div class="tab-content">
		<div class="tab-cover active" id="tab1">
			<div class="welcome-note">
				<h3>Welcome to speedOmeter</h3>
				<p>speedOmeter makes it easy to connect your website with Google Analytics and see all important website stats right inside your WordPress dashboard. In order to setup website analytics, please take a look at our Getting started video or use our Onboarding Wizard to get you quickly set up.</p>
			</div>
			<div class="license-key">
				<span>License Key</span>
				<div class="license-box">
					<div class="network-notice">
						<img src="<?php echo esc_url( SPEEDOMETERV3_PLUGIN_URL . 'admin/images/network.png' );?>">
						<div class="net-text">
							<strong>Your license key has been set at the network level of your WordPress Multisite.</strong>
							<p>If you would like to use a different license for this subsite, you can enter it below.</p>
						</div>
					</div>
					<div class="account-area">
						<p>Add your speedOmeter license key from the email receipt or account area. <a href="#">Retrieve your license key.</a></p>
						<div class="license-field">
							<input type="text" id="key-valid-input" value="<?php echo $website_sh_record->mercury_token; ?>" readonly="readonly" autocomplete="off" placeholder="Paste your license key here" class="">
							<div class="cpy-text-tooltip">
								<button id="btn_id" class="cpy_token">
									<span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
									Copy Token
								</button>
							</div>
						</div>
						<p class="key-type"><strong>Your license key type for this site is <b>Free</b></strong> <i class="fa fa-info-circle" aria-hidden="true"></i></p>
					</div>
				</div>
			</div>
			<div class="license-key">
				<span>Sync Status</span>
				<div class="license-box">
					<form method="POST" name="pln_setting" id="pln_setting" action="" class="pln_setting">
						<?php $nonce = wp_nonce_field( 'pluginSetting' );?>
						<input type="text" id="token_val" value="<?php echo $website_sh_record->mercury_token; ?>" name="token_val" readonly class="hidden">
						<div class="switch-toggle">
							<p><?php esc_html_e( 'Sync status', SPEEDOMETERV3_TEXT_DOMAIN ); ?></p>
							<label class="switch">
								<input  id='cmn-toggle-1'  class='cmn-toggle cmn-toggle-round' type='checkbox' value=<?php echo $website_sh_record->sync_data_pause == '1' ? '1' : '0'; ?> name='sync_status' <?php echo $website_sh_record->sync_data_pause == '1' ? ' checked' : ''; ?> >
								<span class="slider round"></span>
							</label>
						</div>
						<input type="text" name="submitPluginSetting" class="button button-primary button-large hidden" value="<?php echo  esc_attr( $pluginSettingBtnValue ) ;?>">
					</form>
				</div>
			</div>
			<div class="license-key">
				<span>Scan and Syncing </span>
				<div class="license-box">
					<form method="POST" name="wizardfrm" action="" class="wizardfrm">
						<?php wp_nonce_field( 'smSetting' );?>
						<p class="submit">
							<input type="submit" name="submitSetting" class="button button-primary button-large" value="<?php echo  esc_attr( $scanBtnValue ) ;?>">
							<input type="submit" name="submitSetting" class="button button-primary button-large" value="<?php echo  esc_attr( $syncBtnValue ) ;?>">
						</p>
					</form>
				</div>
			</div>
			
		</div>
	</div>
</div>
</div>
</div>
