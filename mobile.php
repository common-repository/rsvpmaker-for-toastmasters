<?php

function wp4t_enable_mobile() {
    global $current_user;
    if(isset($_POST['status'])) {
        if(empty($_POST['status'])) {
            $enabled = false;
            delete_user_meta($current_user->ID,'wpt_mobile_code');
        } 
        else {
            $enabled = true;
            $code = sanitize_text_field($_POST['status']);
            update_user_meta($current_user->ID,'wpt_mobile_code',$code);
        }
    } else {
        $code = get_user_meta($current_user->ID,'wpt_mobile_code',true);
        if($code)
            $enabled = true;
        else
            $enabled = false; 
    }
if(!$enabled)
    $code = wp_generate_password(20,false);
$enabled_checked = ($enabled) ? ' checked="checked" ' : '';
$disabled_checked = ($enabled) ? '' : ' checked="checked" ';
?>
<h1>Enable Mobile App</h2>
<form method="post" action="">
<input type="radio" name="status" value="<?php echo $code ?>" <?php echo $enabled_checked ?> > Enabled <input type="radio" name="status" value="" <?php echo $disabled_checked ?> > Disabled 
<button>Update</button>
</form>
<?php
if($enabled)
    printf('<p>Enter this code into the mobile app to enable role signups.</p><code>%s</code>',$code);
}

function wpt_mobile_user_check() {
    global $wpdb;
    if(isset($_GET['mobilekey'])) {
        $key = sanitize_text_field($_GET['mobilekey']);
        $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key='wpt_mobile_code' AND meta_value='$key' ";
        $user_id = $wpdb->get_var($sql);
        if($user_id) {
            wp_set_current_user($user_id);
            return true;
        }        
    }
    return false;
}
