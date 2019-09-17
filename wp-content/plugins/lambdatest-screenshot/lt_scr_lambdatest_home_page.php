<?php
if (!defined('ABSPATH')) {
    exit;
}

include_once 'lt_scr_lambdatest_config.php';
if (isset($_POST['submit'])) {
    if (wp_verify_nonce($_POST['lt_scr_login_detail_nonce'], 'lt_scr_login_detail_nonce')) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'lt_src_lambdatest';
        $truncate_sql = "TRUNCATE TABLE " . $table_name;
        $wpdb->query($truncate_sql);
        $email = sanitize_email(trim($_POST['email']));
        $token = sanitize_text_field(trim($_POST['token']));
        $draft_preview_secret = sanitize_text_field(trim($_POST['draft_preview_secret']));
        if (is_email($email) && strlen($token) > 0) {
            $wpdb->insert(
                $table_name,
                array(
                    'time' => current_time('mysql'),
                    'email' => $email,
                    'token' => $token,
                    'draft_preview_secret' => $draft_preview_secret,
                )
            );
        };
    } else {
        echo "Nonce not verified";
        exit;
    }
}
wp_register_style('lt_scr_lambdatest_home_css', plugins_url('css/lt_scr_lambdatest_home.css', __FILE__), array(), null);
wp_enqueue_style('lt_scr_lambdatest_home_css');
?>
<div class="main-section" id="ltScrHomeApp">
    <template>
        <div class="col-sm-11 white-bg">
            <div class="col-sm-8">
                <div class="col-sm-3">
                    <img width="80" src="<?php echo plugins_url('icons/lambda-logo-icon.png', __FILE__); ?>" class="img-circle dropShadow">
                </div>
                <div class="col-sm-9">
                    <h2 class="name-lable">Screenshot Testing</h2>
                    <p class="name-discri">Powered by Lambdatest</p>
                </div>
                <div class="col-sm-12 form-section">
                    <form class="form-horizontal" action="<?php the_permalink(); ?>" method="post">
                        <input type="hidden" name="lt_scr_login_detail_nonce" value="<?php echo wp_create_nonce('lt_scr_login_detail_nonce'); ?>">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email Address: </label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control _activate" placeholder="Email" id="lt_scr_email" name="email" :value="email" required>
                                <span class="edited"> {{email}}</span> &nbsp; &nbsp;
                                <a class="edited" @click="editForm()">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="token" class="col-sm-3 control-label">Access Key: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control _activate" id="token" name="token" :value="token" required>
                                <span class="edited">{{token}}</span> &nbsp;&nbsp;
                                <a class="edited" @click="editForm()">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="draft_preview_secret" class="col-sm-3 control-label">Draft Preview Secret: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control _activate" id="draft_preview_secret" name="draft_preview_secret" :value="draft_preview_secret" required>
                                <span class="edited">{{draft_preview_secret}}</span> &nbsp;&nbsp;
                                <a class="edited" @click="editForm()">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-10">
                                <button type="submit" name="submit" class="btn btn-default active-btn _activate">Activate</button>
                                <i id="verified" class="fa fa-check-circle" style="font-size:10px;color:green"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12 border-top" v-if="subscriptionDetails.plan">
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <h4>Current Plan: {{subscriptionDetails.plan}}</h4>
                        <p class="small-size">Plan Type: {{subscriptionDetails.subscription_type}}</p>
                        <!-- <p class="small-size">Free Screenshots Sessions Remaining : <b>{{subscriptionDetails.remaining_monthly_screenshot_test_count == -1 ? 'Unlimited' : subscriptionDetails.remaining_monthly_screenshot_test_count}}</b></p> -->
                        <h4 v-if="subscriptionDetails.plan.plan_code === 'FREE'">You are subscribed to freemium at the moment</h4>
                        <p class="btn-link1"><a href="<?php echo $lt_lums_url; ?>/billing/plans" target="_blank">{{subscriptionDetails.subscription_type === 'FREE' ? 'UPGRADE NOW':'SEE PLANS'}}</a></p>
                    </div>
                    <div class="col-sm-12 top-30">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/wpI6XAteXOI" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                    <div class="col-sm-12">
                        <p class="small-size">How it works</p>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 border-top" style="min-height:300px" v-if="verified === false">
                <p>1. Signup for a free LambdaTest account at <a href="<?php echo $lt_lums_url; ?>/register" target="_blank"><?php echo $lt_lums_url; ?>/register</a></p>
                <p>2. Upon verification of the email address go to Profile page at: <a href="<?php echo $lt_lums_url; ?>/user/profile" target="_blank"><?php echo $lt_lums_url; ?>/user/profile</a></p>
                <p>3. Copy the Access Key from the profile page and use the same to activate this plugin</p>
            </div>
        </div>
    </template>
</div>

<?php
function lt_scr_lambdatest_home_page_script($lt_lums_url)
{
    ?>
    <script>
        jQuery(document).ready(function() {
            if (jQuery.trim(jQuery(`#lt_scr_email`).val())) {
                jQuery(`._activate`).addClass('display_none');
            } else {
                jQuery(`.edited`).addClass('display_none');
            }
        })
        var ltScrHomeApp = new Vue({
            el: '#ltScrHomeApp',
            data: {
                email: "",
                token: "",
                draft_preview_secret: "",
                verified: true,
                subscriptionDetails: {

                },
                details: {

                }
            },
            created() {
                this.getUserDetails();
            },
            methods: {
                getUserDetails: function() {
                    <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'lt_src_lambdatest';
                    $row_1_sql = "SELECT * FROM " . $table_name . " WHERE id = 1";
                    $cur_user = $wpdb->get_row($row_1_sql);
                    if (isset($cur_user->id)) {
                        ?>
                        this.email = `<?php echo sanitize_email(trim($cur_user->email)); ?>`;
                        this.token = `<?php echo sanitize_text_field(trim($cur_user->token)); ?>`;
                        this.draft_preview_secret = `<?php echo sanitize_text_field(trim($cur_user->draft_preview_secret)); ?>`;
                    <?php
                }
                ?>
                    if (this.email && this.token) {
                        this.getTokenOnHomePgae();
                    } else {
                        this.verified = false;
                    }
                },
                getUserSubscriptionDetails: function() {
                    if (this.email && this.token && this.verified === true) {
                        this.subscriptionDetails = this.details;
                        this.is_loading_active = false;

                        // axios.get('<?php echo $lt_lums_url; ?>/api/user/subscription',{
                        //     headers: {
                        //         "Content-type": "application/json",
                        //         "Authorization":`Bearer ${localStorage.getItem('lt_scr_access_token')}`
                        //     }
                        // }).then(function (response) {
                        //     if(response.status === 401){
                        //         throw Error(response.statusText);
                        //     } else{
                        //         this.subscriptionDetails = response.data;
                        //         if(this.subscriptionDetails.type === 'error'){
                        //             alert(`Please contact support`);
                        //         }
                        //     }
                        // }.bind(this))
                        // .catch(function (error) {
                        //     console.log(`${error} is Error`);
                        // }.bind(this));
                    } else {
                        alert(`Please contact support`);
                    }
                },
                editForm: function() {
                    jQuery(`._activate`).removeClass(`display_none`);
                    jQuery(`.edited`).addClass(`display_none`);
                    jQuery(`button[type="submit"]`).text('Update');
                },
                getTokenOnHomePgae: function() {
                    axios.post('<?php echo $lt_lums_url; ?>/api/user/token/auth', {
                            email: this.email,
                            token: this.token
                        }).then(function(response) {
                            if (response.status === 401) {
                                throw Error(response.statusText);
                            } else if (response.status === 412) {
                                throw Error(response.statusText);
                            } else {
                                let authData = response.data;
                                let config = response.config;

                                if (response.status === 200) {
                                    this.verified = true;
                                    configData = JSON.parse(config.data)
                                    this.details = authData.organization

                                    jQuery(`#verified`).css('color', 'green').text(`Verified`);
                                    localStorage.setItem('lt_scr_access_token', configData.token);
                                    localStorage.setItem('lt_scr_draft_preview_secret', this.draft_preview_secret);
                                    localStorage.setItem('lt_scr_organization_id', authData.organization.id);
                                    localStorage.setItem('lt_user_name', authData.username);

                                    this.getUserSubscriptionDetails();
                                }
                            }
                        }.bind(this))
                        .catch(function(error) {
                            this.verified = false;
                            jQuery(`#verified`).css('color', 'red').text(`UnVerified`);
                            jQuery(`._activate`).removeClass(`display_none`);
                            jQuery(`.edited`).addClass(`display_none`);
                            jQuery(`button[type="submit"]`).text('Update');
                            console.log(`${error} is Error`);
                        }.bind(this));
                }
            }
        })
    </script>
<?php
}

// this.details = authData.organization

lt_scr_lambdatest_home_page_script($lt_lums_url);
?>