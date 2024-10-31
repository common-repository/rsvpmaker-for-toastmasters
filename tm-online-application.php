<?php

//do_action('rsvpmaker_paypal_record_payment',$response,$_REQUEST);

add_action('rsvpmaker_paypal_record_payment',10,2);

function wp4t_paypal_application_payment($response,$get) {

	rsvpmaker_debug_log($response,'wp4t_paypal_application_payment');

	rsvpmaker_debug_log($get,'wp4t_paypal_application_payment http request');

	global $wpdb;

}

function tm_member_application( $atts ) {

	global $rsvp_options;

	rsvpmaker_fix_timezone();

	if ( isset( $_GET['rsvpstripeconfirm'] ) ) {

		return; // let rsvpmaker show payment message

	}



	if ( isset( $_GET['paydues'] ) ) {

		return paydues_later();

	}



	global $post;

	if ( empty( $_POST['user_email'] ) ) {

		return tm_application_form_start( $atts );

	}

	$notifications = get_option( 'tm_application_notifications' );

	$titles = get_option('tm_application_titles');

	if(!empty($titles))

		{

			foreach($titles as $title)

			{

				$officer_email = toastmasters_officer_email_by_title($title);

				if(!empty($notifications) && !empty($officer_email))

					$notifications .= ", ";

				if(!empty($officer_email))

					$notifications .= $officer_email;

			}

		}

	if ( empty( $notifications ) ) {

		$notifications = get_option( 'admin_email' );

	}



	// add code to buffer output, write to file on post

	ob_start();



	if ( ! is_admin() ) {

		?>

<style>

label {

	display: inline-block;

	width: 150px;

}

</style>

		<?php

	}



	include 'application-form.php';

	$output    = ob_get_clean();

	$payprompt = '';

	if(isset( $_POST['applicant_signature'] ) && empty( $_POST['applicant_signature'] ))
		{
			echo '<h2>Missing signature error</h2>';
			return;//should have been caught with client side validation
		}

	if ( ! empty( $_POST['applicant_signature'] ) ) {

		if(!wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) )

			wp_die('security error');

		$content                 = preg_replace( '/(<(style)\b[^>]*>).*?(<\/\2>)/is', '$1$3', $output );

		$newpost['post_type']    = 'tmapplication';

		$newpost['post_status']  = 'private';

		$newpost['post_content'] = wp_kses_post($content);

		$newpost['post_title']   = 'Membership Application: ' . sanitize_text_field($_POST['first_name'] . ' ' . $_POST['last_name']);

		$post_id                 = wp_insert_post( $newpost );

		foreach ( $_POST as $slug => $value ) {

			update_post_meta( $post_id, $slug, sanitize_text_field($value) );

		}

		$chosen_gateway = get_rsvpmaker_payment_gateway ();
		$payprompt = '';

		$vars['amount'] = get_post_meta( $post->ID, 'tm_application_fee', true );// fetch from page for form
		if(empty($vars['amount']) && !empty($_POST['tm_application_fee']))
			$vars['amount'] = sanitize_text_input($_POST['tm_application_fee']);
		if(empty($vars['amount']))
			$payprompt .= '<p style="color:red">Error recording dues amount.</p>';		

		update_post_meta( $post_id, 'tm_application_fee', $vars['amount'] );// record to app document

		$until = get_post_meta( $post->ID, 'tm_application_until', true );// fetch from page for form

		update_post_meta( $post_id, 'tm_application_until', $until );// record to app document

		$vars['name']        = sanitize_text_field($_POST['first_name'] . ' ' . $_POST['last_name']);

		$vars['email']       = sanitize_text_field($_POST['user_email']);

		$vars['tracking']    = 'tmapplication' . $post_id;

		$vars['description'] = 'Toastmasters Application '.$post_id.' '.$vars['name'];

		$vars['name']        = sanitize_text_field($_POST['first_name'] . ' ' . $_POST['last_name']);

		$vars['email']       = sanitize_text_field($_POST['user_email']);

		$vars['tracking']    = 'tmapplication' . $post_id;

		if ( ('Stripe' == $chosen_gateway ) || strpos($chosen_gateway,'Stripe') !== false ) {

			$payprompt           .= rsvpmaker_stripe_form( $vars );

		}

		if ( ('PayPal' == $chosen_gateway ) || strpos($chosen_gateway,'PayPal') !== false ) {

			if(!empty($payprompt))

				$payprompt .= '<p>Or pay with PayPal</p>';

			$payprompt .= rsvpmaker_paypal_button( $vars['amount'], $rsvp_options['paypal_currency'], $vars['description'], array('tracking_key' => 'tm_application', 'tracking_value' => $post_id) );

		}



		$mail['subject']  = 'PENDING ' . $newpost['post_title'];

		$mail['html']     = '<p>Verify with officer signature <a href="';

		$mail['html']    .= admin_url( 'admin.php?page=member_application_approval&app=' . $post_id );

		$mail['html']    .= '">' . admin_url( 'admin.php?page=member_application_approval&app=' . $post_id ) . '</a></p>' . "\n\n";

		$mail['html']    .= $output;

		$mail['fromname'] = $vars['name'];

		$mail['from']     = $vars['email'];



		$duesmessage = get_option('tm_application_dues_message');



		$payprompt .= sprintf('<p>%s: %s</p>',__('Dues amount','rsvpmaker-for-toastmasters'),number_format($vars['amount'],2));

		$payprompt .= wp_kses_post($duesmessage);



		$n = explode( ',', $notifications );

		foreach ( $n as $to ) {

			$mail['to'] = $to;

			rsvpmailer( $mail );

			$payprompt .= sprintf( '<p>Pending application emailed to %s</p>', $to );

		}

	}



	return $payprompt . $output;

}



function paydues_later() {

	$id                  = (int) $_GET['paydues'];

	$vars['amount']      = get_post_meta( $id, 'tm_application_fee', true );

	$vars['description'] = 'Toastmasters Dues Payment';

	$vars['name']        = get_post_meta( $id, 'first_name', true ) . ' ' . get_post_meta( $id, 'last_name', true );

	$vars['email']       = get_post_meta( $id, 'user_email', true );

	$vars['tracking']    = 'tmapplication' . $id;

	$payprompt           = rsvpmaker_stripe_form( $vars );

	return sprintf( '<h2>Pay dues for %s</h2>', $vars['name'] ) . $payprompt;

}



add_shortcode( 'club_fee_schedule', 'club_fee_schedule' );



function club_fee_schedule() {

	$ti_dues             = get_option( 'ti_dues' );

	$club_dues           = get_option( 'club_dues' );

	$club_new_member_fee = (int) get_option( 'club_new_member_fee' );

	$new_member_fee      = 20 + $club_new_member_fee;

	$output              = '';

	$months              = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );

	if ( empty( $ti_dues ) ) {

		return 'not set';

	} else {

		$output .= '<style>.feeschedule th {text-align: center;} .feeschedule td {text-align: center; min-width: 100px;}</style>';

		$output .= sprintf( '<table class="feeschedule"><tr><th>%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr>', __( 'Month', 'rsvpmaker-for-toastmasters' ), __( 'TI Dues', 'rsvpmaker-for-toastmasters' ), __( 'Club Dues', 'rsvpmaker-for-toastmasters' ), __( 'Club New Member', 'rsvpmaker-for-toastmasters' ), __( 'Total', 'rsvpmaker-for-toastmasters' ), __( '+ New Member Fee', 'rsvpmaker-for-toastmasters' ) );

		foreach ( $months as $index => $month ) {

			$total   = number_format( $ti_dues[ $index ] + $club_dues[ $index ] + $club_new_member_fee, 2 );

			$new     = number_format( $total + 20, 2 );

			$output .= sprintf( '<tr><th>%s</th><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $month, number_format( $ti_dues[ $index ], 2 ), number_format( $club_dues[ $index ], 2 ), $club_new_member_fee, $total, $new );

		}

		$output .= '</table>';

	}

	return $output;

}



function tm_application_fee() {

	global $post;

	if ( isset( $_POST['membership_type'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$new     = ( $_POST['membership_type'] == 'New' ) ? 20 : 0;

		$ti_dues = get_option( 'ti_dues' );

		if ( empty( $ti_dues )  || $ti_dues[3] == '45.00' ) {
			$ti_dues = array( 30.00, 20.00, 10.00, 60.00, 50.00, 40.00, 30.00, 20.00, 10.00, 60.00, 50.00, 40.00 );
		}

		$club_dues = get_option( 'club_dues' );

		if ( empty( $club_dues ) ) {

			$club_dues = array( 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );

		}

		$monthindex     = (isset($_POST['monthindex'])) ? $_POST['monthindex'] : rsvpmaker_date( 'n' ) - 1;

		$t = mktime(12,0,0,$monthindex + 1);

		

		$club_new       = (int) get_option( 'club_new_member_fee' );

		$ti_dues_calc   = ( $_POST['membership_type'] == 'Transfer' ) ? 0 : $ti_dues[ $monthindex ];

		$club_dues_calc = $club_dues[ $monthindex ];

		$fee            = $ti_dues_calc + $club_dues_calc + $new + $club_new;

		$feetext        = sprintf( '<p>Membership Starting: %s</p>', rsvpmaker_date( 'F 1, Y',$t ));

		$feetext       .= sprintf(

			'<p>Toastmasters International Dues: <strong>%s</strong><br>

    <em>Paid twice a year by all members, membership dues are pro-rated from the member’s start month.</em></p>',

			number_format( $ti_dues_calc, 2 )

		);

		if ( $ti_dues_calc == 0 ) {

			$feetext .= '<p>(Paid member of another club requesting transfer.)</p>';

		}

		$feetext .= sprintf( '<p>New member fee (US$20): <strong>%s</strong><br /><em>Paid only by new members, this fee covers the cost of the first education path, online copy of The Navigator and processing</em></p>', number_format( $new, 2 ) );

		$renewal_dates = wpt_renewal_dates();

		if($ti_dues_calc > 60)

			array_shift($renewal_dates);

		$renew = array_shift($renewal_dates);

		//printf('<p>Pay Until: %s</p>',$renew);

		update_post_meta($post->ID,'tm_application_until',$renew);

		$feetext .= sprintf( '<p>Total Payment to Toastmasters International: %s</p>', number_format( $ti_dues_calc + $new, 2 ) );

		$feetext .= sprintf( '<p>Club Dues: <strong>%s</strong></p>', number_format( $club_dues_calc, 2 ) );

		$feetext .= sprintf( '<p>Club New Member Fee: <strong>%s</strong></p>', number_format( $club_new, 2 ) );

		$feetext .= sprintf( '<p>Total Payment to Club: <strong>%s</strong></p>', number_format( $club_dues_calc + $club_new, 2 ) );

		$feetext .= sprintf( '<p>Total: <strong>%s</strong></p>', number_format( $fee, 2 ) );

		echo wp_kses_post($feetext);

		echo '<input type="hidden" name="monthindex" value="'.$monthindex.'">';
		echo '<input type="hidden" name="tm_application_fee" value="'.$fee.'">';

		update_post_meta( $post->ID, 'tm_application_fee', $fee );

		update_post_meta( $post->ID, 'tm_application_feetext', $feetext );

	} else {

		echo get_post_meta( $post->ID, 'tm_application_feetext', true );

	}

}



function tm_application_form_start( $atts ) {

	$pdf = ( isset( $atts['pdf'] ) ) ? $atts['pdf'] : 'https://toastmasterscdn.azureedge.net/medias/files/membership-files/membership-applications/800-membership-application.pdf';

	if ( isset( $_POST['user_email'] ) && empty( $_POST['user_email'] ) ) {

		return 'Email address is required <a href="' . get_permalink() . '">Try again</a>';

	}

	ob_start();

	?>

<style>

label {

	display: inline-block;

	width: 150px;

}

</style>

<p>By submitting this online membership application, you agree to treat it as the legally binding equivalent of the standard Toastmasters International membership application, and you will be prompted to agree to all the same terms and conditions. If you prefer, you can download and sign the <a href="<?php echo esc_attr($pdf); ?>" target="_blank">PDF version</a>.</p>



<form method="post" action="<?php echo get_permalink(); ?>">



<p>Step 1: We need a little data to set up the application form and calculate the pro-rated dues (based on the month that you are joining). On the next screen, you will enter your personal data and electronically sign the application.</p>



<p>Email address <?php tm_application_form_field( 'user_email' ); ?> (required)</p>



<p>Application Type <?php tm_application_form_choice( 'membership_type', array( 'New', 'Dual', 'Transfer', 'Reinstated (break in membership)', 'Renewing (no break in membership)' ) ); ?></p>



<?php

$monthindex = date('n') - 1;

$monthtext = date('F');

$o = '<option value="'.$monthindex.'">'.$monthtext.' 1</option>';

$t = strtotime('Next month');

$monthindex = date('n',$t) - 1;

$monthtext = date('F',$t);

$o .= '<option value="'.$monthindex.'">'.$monthtext.' 1</option>';

?>

<p>Start membership: <select name="monthindex"><?php echo $o ?></select></p>

<p><em>&quot;New&quot; means the member is new to Toastmasters (not just new to this club).</em></p>



<p><em>"Transfer" means you are currently enrolled as a paying member of another club, which you wish to withdraw from and apply credit for your dues to our club.</em></p>



<p id="transferprompt">If you are transferring from another club, please provide as much information as possible so we can look up your records. The <a href="https://www.toastmasters.org/Find-a-Club">Find a Club</a> feature of the toastmasters.org website can help you look up club numbers.</p>



<p id="formerclubinfo"><label>Previous club name</label> <?php tm_application_form_field( 'previous_club_name' ); ?><br ><label>Previous club number</label><?php tm_application_form_field( 'previous_club_number' ); ?><br /> <label>Member number</label><?php tm_application_form_field( 'toastmasters_id' ); ?><br /><em>Appears above your name on the mailing label for Toastmaster magazine.</em></p>

<?php wp_nonce_field('application_email'); ?>

<button>Next Screen</button>

<?php rsvpmaker_nonce(); ?>

</form>

<p>&nbsp;</p>



<script>

jQuery(document).ready(function($) {



$('#transferprompt').hide();

$('#formerclubinfo').hide();

var membership_type = 'New';



$('#membership_type').change(function(){

	membership_type = $( "select#membership_type option:selected" ).val();

	if(membership_type != 'New')

		$('#formerclubinfo').show();

	if(membership_type == 'Transfer')

		$('#transferprompt').show();

	else

		$('#transferprompt').hide();



}); 



});

</script>



	<?php

	return ob_get_clean();

}



function tm_application_form_hidden( $slug ) {

	echo ' <strong>' . esc_html(stripslashes( $_POST[ $slug ] )) . '</strong>';

	printf( '<input type="hidden" name="%s" id="%s" value="%s" />', $slug, $slug, sanitize_text_field(stripslashes( $_POST[ $slug ]) ) );

}



function tm_application_form_field( $slug ) {

	global $post;

	$defaults = array(

		'club_name'   => get_option( 'club_name' ),

		'club_number' => get_option( 'club_number' ),

		'club_city'   => get_option( 'club_city' ),

		'date'        => rsvpmaker_date( 'F j, Y' ),

	);



	if ( isset( $_POST[ $slug ] ) ) {

		echo ' <strong>' . esc_html(stripslashes( sanitize_text_field($_POST[ $slug ]) )) . '</strong>';

	} else {

		$value = '';

		if ( ! empty( $defaults[ $slug ] ) ) {

			$value = $defaults[ $slug ];

		} elseif ( strpos( $slug, 'date' ) ) {

			$value = $defaults['date'];

		}

		if ( empty( $value ) ) {

			printf( ' <input type="text" name="%s" id="%s" value="" />', $slug, $slug );

		} else {

			printf( ' <input type="hidden" name="%s" id="%s" value="%s" /> <strong>%s</strong>', $slug, $slug, esc_attr($value), esc_html($value) );

		}

	}

}

function tm_application_form_choice( $slug, $choices ) {

	global $post;

	if ( isset( $_POST['first_name'] ) ) {

		echo ' <strong>' . $_POST[ $slug ] . '</strong>';

	} else {

		printf( '<select name="%s" id="%s">', $slug, $slug );

		foreach ( $choices as $choice ) {

			printf( '<option value="%s">%s</option>', $choice, $choice );

		}

		echo '</select>';

	}

}



function member_application_settings( $action = '' ) {

	rsvpmaker_admin_heading('Toastmasters Dues Schedule and Application Form',__FUNCTION__);

	wpt_dues_navigation();



	global $wpdb;

	if ( empty( $action ) ) {

		$action = admin_url( 'options-general.php?page=member_application_settings' );

	}

	$sql     = "SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%tm_member_application%' AND post_status='publish'";

	$apppage = $wpdb->get_var( $sql );



	if ( isset( $_POST['ti_dues'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		update_option( 'club_name', sanitize_text_field(stripslashes( $_POST['club_name'] ) ));

		update_option( 'club_number', sanitize_text_field($_POST['club_number']) );

		update_option( 'club_city', sanitize_text_field(stripslashes( $_POST['club_city'] ) ) );

		update_option( 'ti_dues', array_map('sanitize_text_field',$_POST['ti_dues']) );

		update_option( 'club_dues', array_map('sanitize_text_field',$_POST['club_dues']) );

		update_option( 'club_new_member_fee', sanitize_text_field($_POST['club_new_member_fee']) );

		update_option( 'tm_application_notifications', sanitize_text_field($_POST['tm_application_notifications']) );

		update_option( 'tm_application_titles', $_POST['tm_application_titles'] );

		if ( isset( $_POST['rsvpmaker_stripe_pk'] ) ) {

			update_option( 'rsvpmaker_stripe_pk', sanitize_text_field($_POST['rsvpmaker_stripe_pk']) );

			update_option( 'rsvpmaker_stripe_sk', sanitize_text_field($_POST['rsvpmaker_stripe_sk']) );

			update_option( 'rsvpmaker_stripe_notify', sanitize_text_field($_POST['tm_application_notifications']) );

		}

		if ( isset( $_POST['addpage'] ) ) {

			$page['post_title']   = 'Application';

			$page['post_content'] = '<!-- wp:shortcode -->

    [tm_member_application]

    <!-- /wp:shortcode -->';

			$page['post_status']  = 'publish';

			$page['post_type']    = 'page';

			$apppage              = wp_insert_post( $page );

		}

	}



	$ti_dues = get_option( 'ti_dues' );

	if ( empty( $ti_dues ) || $ti_dues[3] == '45.00' ) {
		$ti_dues = array( '30.00', '20.00', '10.00', '60.00', '50.00', '40.00', '30.00', '20.00', '10.00', '60.00', '50.00', '40.00' );
		update_option( 'ti_dues',$ti_dues );
	}

	$club_dues = get_option( 'club_dues' );

	if ( empty( $club_dues ) ) {

		$club_dues = array( '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0' );

	}

	if ( isset( $_GET['reset_renewal_page'] ) ) {

		delete_option( 'ti_dues_renewal_page' );

	}

	if ( isset( $_POST['ti_dues_renewal_page'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		if ( is_numeric( $_POST['ti_dues_renewal_page'] ) ) {

			update_option( 'ti_dues_renewal_page', $_POST['ti_dues_renewal_page'] );

		} elseif ( $_POST['ti_dues_renewal_page'] == 'create' ) {

			$renew                = $ti_dues[3] + $club_dues[3];

			$page['post_title']   = 'Dues Renewal';

			$page['post_name']    = 'renew';

			$page['post_content'] = '<!-- wp:wp4toastmasters/duesrenewal /-->';

			$page['post_status']  = 'publish';

			$page['post_type']    = 'page';

			$stripepage           = wp_insert_post( $page );

			update_option( 'ti_dues_renewal_page', $stripepage );

			printf( '<div class="notice notice-success"><p>Dues Renewal page added: <a href="%s">Edit</a></p></div>', admin_url( 'post.php?post=' . $stripepage . '&action=edit' ) );

		}

	}



	$notifications = get_option( 'tm_application_notifications' );

	$titles = get_option( 'tm_application_titles' );

	if(empty($titles))

		$titles = array();

	if ( empty( $notifications ) ) {

		$notifications = get_option( 'admin_email' );

	}



	$months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );

	?>

<form action="<?php echo esc_attr($action); ?>" method="post">

<input type="hidden" name="active" value="settings" />

<p><strong>Club Name:</strong><br /><input type="text" name="club_name" value="<?php echo esc_attr(get_option( 'club_name' )); ?>" /> </p>

<p><strong>Club Number:</strong><br /><input type="text" name="club_number" value="<?php echo esc_attr(get_option( 'club_number' )); ?>" /> </p>

<p><strong>Club City:</strong><br /><input type="text" name="club_city" value="<?php echo esc_attr(get_option( 'club_city' )); ?>" /> </p>

<table>

<tr><th>Month</th><th>TI Dues</th><th>Club Dues</th></tr>

	<?php

	foreach ( $months as $i => $month ) {

		?>

<tr><td><?php echo esc_attr($month); ?></td><td><input type="text" name="ti_dues[<?php echo $i; ?>]" id="ti_dues<?php echo $i; ?>" value="<?php echo esc_attr($ti_dues[ $i ]); ?>"  /></td><td><input type="text" name="club_dues[<?php echo $i; ?>]" id="club_dues<?php echo $i; ?>"" value="<?php echo esc_attr($club_dues[ $i ]); ?>"  /></td></tr>

		<?php

	}

	?>

</table>

<p><strong>Club New Member Fee:</strong><br /><input type="text" name="club_new_member_fee" value="<?php echo esc_attr(get_option( 'club_new_member_fee' )); ?>" /> </p>

<p><strong>Renewal Fee:</strong><br>

<?php

if(isset($_POST['tm_renew6_type'])) {

	$type = sanitize_text_field($_POST['tm_renew6_type']);

	if($type == 'auto')

		$tm_6momthfee = sanitize_text_field($_POST['tm_renew6_auto']);

	else

		$tm_6momthfee = sanitize_text_field($_POST['tm_6monthfee']);

	update_option('tm_renew6_type',$type);

	update_option('tm_6monthfee',$tm_6momthfee);

	update_option("tm_renew12",sanitize_text_field($_POST["tm_renew12"]));

}

$tm_renew6_type = get_option('tm_renew6_type') ?>

<input type="radio" name="tm_renew6_type" value="auto" <?php if(empty($tm_renew6_type) || ($tm_renew6_type == 'auto') ) echo ' checked="checked" ' ?> ><input type="hidden" name="tm_renew6_auto" id="tm_renew6_auto" value=""> Set the six month renewal fee to <strong><span id="renew6"></span></strong>, based on the schedule above.<br>

<input type="radio" name="tm_renew6_type" value="manual" <?php if($tm_renew6_type == 'manual') echo ' checked="checked" ' ?>> Set the six month renewal fee to <input type="text" name="tm_6monthfee" value="<?php echo esc_attr(get_option("tm_6monthfee")) ?>" ><br>

Optional: Offer a one-year renewal with a fee of <input type="text" name="tm_renew12" value="<?php echo esc_attr(get_option("tm_renew12")); ?>" >

</p>

<p><strong>Email Approval Notifications To:</strong><br /><input style="width: 90%" type="text" name="tm_application_notifications" value="<?php echo esc_attr($notifications); ?>" /><br />

Multiple email addresses may be entered, separated by a comma.</p>

	<?php

$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );

if($wp4toastmasters_officer_titles)

{

	echo '<p>'.__('Notification by Title','rsvpmaker-for-toastmasters').'</p>';

	foreach($wp4toastmasters_officer_titles as $title) {

		if(empty($title))

			continue;

		$checked = '';

		$email = toastmasters_officer_email_by_title( $title );

		if(!empty($titles)) {

			if(in_array($title,$titles))

			$checked = ' checked="checked" ';

		}

		elseif(('Treasurer' == $title) || strpos($title,'Membership') || (__('Treasurer','rsvpmaker-for-toastmasters') == $title)  || strpos($title,__('Membership','rsvpmaker-for-toastmasters')) )

			$checked = ' checked="checked" ';//defaults if this has not been set

		printf('<div><input type="checkbox" name="tm_application_titles[]" value="%s" %s>%s (%s)</div>',$title,$checked,$title,$email);

	}	

}



if(isset($_POST['tm_application_dues_message']))

	{

		$tm_application_dues_message = wp_kses_post(stripslashes($_POST['tm_application_dues_message']));

		update_option('tm_application_dues_message',$tm_application_dues_message);

	}

else

	$tm_application_dues_message = wp_kses_post(get_option('tm_application_dues_message'));



printf('<p>%s<br><textarea name="tm_application_dues_message" class="mce">%s</textarea></p>',__('Message to applicant about dues payment (for example, instructions for paying by check)','rsvpmaker-for-toastmasters'),$tm_application_dues_message);



printf('<h2>%s</h2>',__('Online Payments Services','rsvpmaker-for-toastmasters'));

$chosen_gateway = get_rsvpmaker_payment_gateway ();

if(empty($chosen_gateway) || ('Cash or Custom' == $chosen_gateway))

	printf('<p>%s</p>',__('Not configured'));

else

	printf('<p>%s %s</p>',__('Configured to use','rsvpmaker-for-toastmasters'),$chosen_gateway);

printf('<p><a href="%s">%s</a></p>',admin_url('options-general.php?page=rsvpmaker_settings'),__('Configure online payment service (Stripe or PayPal)','rsvpmaker-for-toastmasters'));



	$renew_page = get_option( 'ti_dues_renewal_page' );

	if ( $renew_page ) {

		printf( '<p><a href="%s">Edit page</a> with dues renewal button.</p>', admin_url( 'post.php?post=' . esc_attr($renew_page) . '&action=edit' ) );

	} else {

		$sql     = "SELECT * FROM $wpdb->posts WHERE post_status='publish' AND post_content LIKE '%wp:wp4toastmasters/duesrenewal%' ORDER BY ID DESC";

		$pages   = $wpdb->get_results( $sql );

		$create  = '<p><input type="radio" name="ti_dues_renewal_page" value="create" ';

		$create .= ( empty( $pages ) ) ? ' checked="checked" >' : '>';

		echo $create;

		echo ' Create dues renewal page</p>';

		echo '<p><input type="radio" name="ti_dues_renewal_page" value="" > No thanks</p>';

		if ( $pages ) {

			foreach ( $pages as $index => $page ) {

				$checked = ( $index == 0 ) ? ' checked="checked" ' : '';

				printf( '<p><input type="radio" name="ti_dues_renewal_page" value="%d" %s > Existing page: %s</p>', intval($page->ID), $checked, esc_html($page->post_title) );

			}

		}

	}



	if ( empty( $apppage ) ) {

		printf( '<p><input type="checkbox" name="addpage" value="1" checked="checked"> Create a page where the application will be displayed.</p>' );

	} else {

		printf( '<p>Application page: <a target="_blank" href="%s">View</a> or <a target="_blank" href="%s">Edit</a>', get_permalink( $apppage ), admin_url( 'post.php?action=edit&post=' . $apppage ) );

	}



	submit_button();

	rsvpmaker_nonce();

	?>

</form>

	<?php echo club_fee_schedule(); ?>

<p>To display this table on the website, use the shortcode [club_fee_schedule] as a placeholder in the text of a page or blog post.</p>

<script>

jQuery( document ).ready(

	function($) {

		var formatter = new Intl.NumberFormat('en-US', {

  style: 'currency',

  currency: 'USD',

});

		var renew = parseFloat($('#ti_dues3').val()) + parseFloat($('#club_dues3').val());

		$('#renew6').html(formatter.format(renew));

		$('#tm_renew6_auto').val(renew);

	}

);	

</script>

	<?php

}



function verification_by_officer() {

	rsvpmaker_fix_timezone();

	ob_start();

	?>

<p><strong>Verification of Club Officer</strong></p>



<p>I confirm that a complete membership application, including the signatures of the new member and a club officer, is on file with the club and will be retained by the club.</p>



<p>By my signature below, I certify that this individual has joined the Toastmasters club identified. As a club, we will ensure that this member receives proper orientation and mentoring.</p>



<p>I acknowledge that my electronic signature on this document is legally equivalent to my handwritten signature.</p>



<p><label>Club officer’s signature</label> <?php tm_application_form_field( 'officer_signature' ); ?> <br >

<label>Date</label> <?php tm_application_form_field( 'officer_signature_date' ); ?>

</p>

<!-- /wp:paragraph -->

	<?php

	wp_nonce_field('officer_signature');

	return ob_get_clean();

}



function check_application_payment( $app_id ) {

	global $wpdb;

	$money = $wpdb->prefix.'rsvpmaker_money';

	$row = $wpdb->get_row("select * from $money WHERE description LIKE 'Toastmasters Application $app_id%' ");

	if($row)

	{

		if(empty($row->name)) {

			$name = get_post_meta( $app_id, 'first_name', true ) . ' ' . get_post_meta( $app_id, 'last_name', true );

			$sql = $wpdb->prepare("UPDATE $money SET name=%s WHERE id=%d ",$name,$row->id);

			$wpdb->query($sql);

		}

		if($row->fee)
			return sprintf('<span style="color: green; font-weight: bold;">Paid: %s Fee: %s (%s)</span>',$row->amount,$row->fee,$row->status);
		else
			return sprintf('<span style="color: green; font-weight: bold;">Paid: %s (%s)</span>',$row->amount,$row->status);
	}

	$key      = 'tmapplication' . $app_id;

	$sql      = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='$key' ";

	$paid     = $wpdb->get_row( $sql );

	$sql      = "SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%tm_member_application%' AND post_status='publish'";

	$app_page = $wpdb->get_var( $sql );

	$paylink  = '';

	if ( $app_page ) {

		$paylink = add_query_arg( 'paydues', $app_id, get_permalink( $app_page ) );

		$paylink = sprintf( ' Payment link: <a href="%s">%s</a>', $paylink, $paylink );

	}

	if ( $paid ) {

		return sprintf( '<strong>Paid online: %s</strong>', number_format( $paid->meta_value, 2 ) );

	} else {

			$email = strtolower( get_post_meta( $app_id, 'user_email', true ) );

		if ( ! empty( $email ) ) {

			$log = stripe_log_by_email( $email );

		}

		if ( empty( $log ) ) {

			return '<span style="color: red;">No online payment recorded.</span>' . $paylink;

		} else {

			return '<span style="color: red;">Possible payment matches:</span></p>' . $log . '<p>' . $paylink;

		}

	}

}



function tm_note_format() {

	global $current_user;

	return '<p>Note: ' . stripslashes( $_POST['notes'] ) . ' <br /><small>(' . $current_user->user_email . ' ' . rsvpmaker_date( 'r' ) . ')</small></p>';

}





function member_application_approval() {

rsvpmaker_admin_heading('Member Application Approval',__FUNCTION__);

	echo '<style>

label {

display: inline-block;

width: 150px;

}

</style>

';

	global $wpdb, $current_user;



	if ( isset( $_POST['officer_signature'] ) ) {

		if(!wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')))

			wp_die('nonce error');

		$app_id                 = (int) $_POST['app'];

		$application            = get_post( $app_id );

		$verification           = verification_by_officer();

		$notes                  = ( empty( $_POST['notes'] ) ) ? '' : tm_note_format();

		$update['ID']           = $app_id;

		$update['post_content'] = $application->post_content . $verification . $notes;

		$return                 = wp_update_post( $update );

		update_post_meta( $app_id, 'officer_signature', $_POST['officer_signature'] );

		update_post_meta( $app_id, 'officer_signature_date', $_POST['officer_signature_date'] );

		$mail['subject']  = 'COMPLETED ' . $application->post_title;

		$mail['html']     = $update['post_content'];

		$mail['fromname'] = $current_user->display_name;

		$mail['from']     = $current_user->user_email;

		$notifications    = get_option( 'tm_application_notifications' );

		$titles = get_option('tm_application_titles');

		if(empty($titles))

			$titles = array();

		$n                = explode( ',', $notifications );



		foreach ( $n as $to ) {

			$mail['to'] = trim( $to );

			rsvpmailer( $mail );

			printf( '<p>Completed application emailed to %s</p>', $to );

		}



		$mail['to'] = get_post_meta( $app_id, 'user_email', true );

		rsvpmailer( $mail );

		printf( '<p>Completed application emailed to %s</p>', $mail['to'] );



		$member_factory          = new Toastmasters_Member();

		$user['first_name']      = get_post_meta( $app_id, 'first_name', true );

		$user['last_name']       = get_post_meta( $app_id, 'last_name', true );

		$user['user_email']      = get_post_meta( $app_id, 'user_email', true );

		$user['home_phone']      = get_post_meta( $app_id, 'home_phone', true );

		$user['mobile_phone']    = get_post_meta( $app_id, 'mobile_phone', true );

		$user['toastmasters_id'] = get_post_meta( $app_id, 'toastmasters_id', true );

		$user['application_id'] = $app_id;

		$email_choice = get_post_meta($app_id,'club_email_choice',true);

		$member_factory->check( $user );

		$member_factory->show_prompts();

	} elseif ( ! empty( $_POST['notes'] ) ) {

		$app_id                 = (int) $_POST['app'];

		$application            = get_post( $app_id );

		$notes                  = tm_note_format();

		$update['ID']           = $app_id;

		$update['post_content'] = $application->post_content . $notes;

		wp_update_post( $update );

	}



	if ( isset( $_POST['add_account'] ) ) {

		$app_id                  = (int) $_POST['add_account'];

		$member_factory          = new Toastmasters_Member();

		$user['first_name']      = get_post_meta( $app_id, 'first_name', true );

		$user['last_name']       = get_post_meta( $app_id, 'last_name', true );

		$user['user_email']      = get_post_meta( $app_id, 'user_email', true );

		$user['home_phone']      = get_post_meta( $app_id, 'home_phone', true );

		$user['mobile_phone']    = get_post_meta( $app_id, 'mobile_phone', true );

		$user['toastmasters_id'] = get_post_meta( $app_id, 'toastmasters_id', true );

		$user['application_id'] = $app_id;

		$member_factory->check( $user );

		$member_factory->show_prompts();

	}



	if ( isset( $_GET['app'] ) ) {

		echo '<div style="background-color: #fff; padding: 10px; margin: 10px; border: thin solid #000;">';

		printf( '<form action="%s" method="post"><input type="hidden" name="app" value="%s" />', admin_url( 'admin.php?page=member_application_approval' ), $_GET['app'] );

		// $vars['tracking'] = 'tmapplication'.$post_id;

		$app_id   = (int) $_GET['app'];

		$approval = get_post_meta( $app_id, 'officer_signature', true );

		if ( $approval ) {

			printf( '<p>Approved by %s on %s</p>', $approval, get_post_meta( $app_id, 'officer_signature_date', true ) );

			echo '<p>Notes</br><textarea style="width: 100%;" name="notes"></textarea></p>';

			echo submit_button();

		} else {

			printf( '<p>%s</p>', check_application_payment( $app_id ) );

			echo verification_by_officer();

			echo '<p>Notes</br><textarea style="width: 100%;" name="notes"></textarea></p>';

			echo submit_button( 'Approve' );

		}

		rsvpmaker_nonce();

		echo '</form>';

		echo '</div>';



		$application = get_post( $_GET['app'] );

		echo '<h2>' . esc_html($application->post_title) . '</h2>';

		echo wp_kses_post($application->post_content);

	}



	$emailopt = '';

	$emails   = array();

	$results  = $wpdb->get_results( 'SELECT ID, post_title, meta_value FROM ' . $wpdb->posts . ' JOIN ' . $wpdb->postmeta . ' on ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id WHERE post_status="private" AND post_type="tmapplication" AND meta_key="user_email" ORDER BY ID DESC' );

	if ( $results ) {

		foreach ( $results as $row ) {

			$p = explode( ': ', $row->post_title );

			if ( empty( $p[1] ) ) {

				continue;

			}

			$name  = $p[1];

			$email = $row->meta_value;

			if ( in_array( $email, $emails ) ) {

				continue;

			}

			$emails[] = $email;

			$user     = get_user_by( 'email', $email );

			if ( $user ) {

				continue;

			}

			$emailopt .= sprintf( '<option value="%d">%s %s</option>', $row->ID, $name, $email );

		}

	}



	$last    = '';

	$results = $wpdb->get_results( 'SELECT ID, post_title, post_modified FROM ' . $wpdb->posts . ' WHERE post_status="private" AND post_type="tmapplication" ORDER BY ID DESC' );

	if ( $results ) {

		if ( ! empty( $emailopt ) ) {

			printf( '<form method="post" action="%s"><p>%s <select name="add_account">%s</select> <button>%s</button></p>%s</form>', admin_url( 'admin.php?page=member_application_approval' ), __( 'Create user account for', 'rsvpmaker-for-toastmasters' ), $emailopt, __( 'Add', 'rsvpmaker-for-toastmasters' ),rsvpmaker_nonce('return') );

		}

		echo '<div style="border: thin solid #333; padding: 10px;">';

		foreach ( $results as $post ) {

			if ( $post->post_title == $last ) {

				continue;

			}

			$last     = $post->post_title;

			$verified = '';

			$approval = get_post_meta( $post->ID, 'officer_signature', true );

			if ( $approval ) {

				$verified = sprintf( '(Approved %s)', get_post_meta( $post->ID, 'officer_signature_date', true ) );

			} else {

				$verified = check_application_payment( $post->ID );

			}

			//echo esc_html($log);

			printf( '<p><a href="%s">%s</a> %s %s</p>', admin_url( 'admin.php?page=member_application_approval&app=' . $post->ID ), $post->post_title, $post->post_modified, $verified );

		}

		echo '<div>';

	}



}



function member_application_upload() {

	if ( ! empty( $_POST ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$upload_overrides = array(

			'test_form' => false,

		);

		$content          = '';

		foreach ( $_FILES as $file ) {

			if ( ! empty( $file[ tmp_name ] ) ) {

				$result = wp_handle_upload( $file, $upload_overrides );

				if ( $result['url'] ) {

					if ( strpos( $result['type'], 'png' ) || strpos( $result['type'], 'jpg' ) || strpos( $result['type'], 'gif' ) ) {

						$content .= sprintf( '<p><img src="%s" style="max-width: %s" /></p>', $result['url'], '95%' );

					} else {

						$content .= sprintf( '<p><a target="_blank" href="%s">Application file</a></p>', $result['url'] );

					}

				} else {

					echo '<p>Upload error ';

					print_r( $result );

					echo '</p>';

				}

			}

		}



		if ( ! empty( $_POST['application3'] ) ) {

			$content .= sprintf( '<p><a target="_blank" href="%s">Application file (external link)</a></p>', $_POST['application3'] );

		}



		if ( ! empty( $content ) ) {

			$newpost['post_type']    = 'tmapplication';

			$newpost['post_status']  = 'private';

			$newpost['post_content'] = $content;

			$newpost['post_title']   = 'Membership Application: ' . $_POST['first_name'] . ' ' . $_POST['last_name'];

			$post_id                 = wp_insert_post( $newpost );

			add_post_meta( $post_id, 'first_name', $_POST['first_name'] );

			add_post_meta( $post_id, 'last_name', $_POST['last_name'] );

			add_post_meta( $post_id, 'user_email', $_POST['user_email'] );

			add_post_meta( $post_id, 'toastmasters_id', $_POST['toastmasters_id'] );

			printf( '<p><a href="%s">Application posted</a></p>', admin_url( 'admin.php?page=member_application_approval&app=' . $post_id ) );

			if ( ! empty( $_POST['approved'] ) ) {

				echo '<p>Marking approved</p>';

				global $current_user;

				update_post_meta( $post_id, 'officer_signature', get_user_meta( $current_user->ID, 'first_name', false ) . ' ' . get_user_meta( $current_user->ID, 'last_name', false ) );

				update_post_meta( $post_id, 'officer_signature_date', rsvpmaker_date( 'F j, Y' ) );

				$member_factory          = new Toastmasters_Member();

				$user['first_name']      = get_post_meta( $post_id, 'first_name', true );

				$user['last_name']       = get_post_meta( $post_id, 'last_name', true );

				$user['user_email']      = get_post_meta( $post_id, 'user_email', true );

				$user['toastmasters_id'] = get_post_meta( $post_id, 'toastmasters_id', true );

				$member_factory->check( $user );

				$member_factory->show_prompts();

			}

		}

	}



	?>

<style>

label {

	display: inline-block;

	width: 125px;

}

</style>

<h1>Member Application Manual Upload</h1>

<p>When you receive an application as a PDF or image file, you can upload it to be tracked along with applications submitted as HTML. Alternatively, you can provide a link to a file sharing service like Dropbox or Google Drive.</p>

<form action="<?php echo admin_url( 'admin.php?page=member_application_upload' ); ?>" method="post" enctype="multipart/form-data">

<p><label>First name:</label> <input type="text" name="first_name"></p>

<p><label>Last name:</label> <input type="text" name="last_name"></p>

<p><label>Email:</label> <input type="text" name="user_email"></p>

<p><label>Toastmasters ID:</label> <input type="text" name="toastmasters_id"> <br />(optional, if available)</p>

<p>File: <input type="file" name="application" id="application"></p>

<p>File: <input type="file" name="application2" id="application2"> <br />(2nd page, if captured separately)</p>

<p><label>Link:</label> <input type="text" name="application3" id="application3"></p>

<p><input type="checkbox" name="approved"> Mark approved (signed by current user, today's date)</p>

<p><input type="submit" value="Submit" name="submit"></p>

<?php rsvpmaker_nonce(); ?>

</form>

	<?php

}



function tm_application_menus() {

	add_options_page( 'TM Application Form', 'TM Application Form', 'manage_options', 'member_application_settings', 'member_application_settings' );

	add_menu_page( 'Review/Approve Applications', 'Review/Approve Applications', 'edit_users', 'member_application_approval', 'member_application_approval' );

	add_submenu_page( 'member_application_approval', 'Add File or Link', 'Add File or Link', 'edit_users', 'member_application_upload', 'member_application_upload' );

}

add_action( 'admin_menu', 'tm_application_menus' );



add_shortcode('wp4t_dues_renewal','wp4t_dues_renewal');



function wp4t_dues_renewal($atts) {

	global $current_user;

	$payprompt = '';

	$renew6 = get_option('tm_6monthfee');

	$renew12 = get_option("tm_renew12");

	if(empty($renew6))

	{

		$ti_dues             = get_option( 'ti_dues' );

		$club_dues           = get_option( 'club_dues' );

		$renew6 = $ti_dues[3] + $club_dues[3];

	}

	if(isset($atts['amount']) && !empty($atts['amount']))

		$vars['amount'] = $atts['amount'];

	elseif(isset($_GET['renew12']) && $renew12)

		$vars['amount'] = $renew12;

	elseif($renew6) {

		$vars['amount'] = $renew6;

	}

	else 

		return '<p>Dues not set</p>';



	if((is_user_logged_in() && is_club_member()) || isset($_GET['user_id'])) {

		$user_id = 0;

		if(isset($_GET['user_id']))

		{

			$user_id = intval($_GET['user_id']);

			if(!$user_id)

				return '<p>Invalid user ID</p>';

		}

		else

			$user_id = $current_user->ID;

		$user = get_userdata($user_id);

		$vars['name']        = get_member_name($user_id);

		$vars['email']       = $user->user_email;

		$vars['description']    = $vars['name'].' Dues Renewal ('.$user_id.')';

		$chosen_gateway = get_rsvpmaker_payment_gateway ();

		if ( ('Stripe' == $chosen_gateway ) || strpos($chosen_gateway,'Stripe') ) {

			$payprompt           = rsvpmaker_stripe_form( $vars );

		}

		if ( ('PayPal' == $chosen_gateway ) || strpos($chosen_gateway,'PayPal') ) {

			if(!empty($payprompt))

				$payprompt .= '<p>Or pay with PayPal</p>';

			$payprompt .= rsvpmaker_paypal_button( $vars['amount'], $rsvp_options['paypal_currency'], $vars['description'], array('tracking_key' => 'tm_application', 'tracking_value' => $post_id) );

		}

		$rdates = wpt_renewal_dates();

		$paid_until = wpt_member_paid_until($user_id);

		$month = rsvpmaker_date('m');

		$renewal_months = array('1','2','3','7','8','9');

		if(empty($paid_until) && in_array($month,$renewal_months))

			array_shift($rdates);

		elseif($paid_until == $rdates[0])

			array_shift($rdates);

		if(isset($_GET['renew12']))

			array_shift($rdates);



		update_user_meta($user_id,'tm_renew_until_'.get_current_blog_id(),array_shift($rdates));

	}

	$output = $payprompt;

	$output .= sprintf('<h3>%s: %s</h3>',__('Dues','rsvpmaker-for-toastmasters'),number_format($vars['amount'],2));

	if($user_id)

		$output .= sprintf('<h3>%s: %s</h3>',__('Selected Member','rsvpmaker-for-toastmasters'),$vars['name']);

	else {

		$login = wp_login_url( get_permalink() );

		$output .= '<p>'.__('<a href="'.$login.'">Login</a> or select your name from the member list','rsvpmaker-for-toastmasters').'</p>';

	}

	$r12 = ($renew12) ? '<div><input type="checkbox" name="renew12" value="1" '.( (isset($_GET['renew12'])) ? 'checked="checked"' : '' ).'> '.__('Option: renew for 12 months, not 6. Fee:','rsvpmaker-for-toastmasters'). ' $'.$renew12.'</div>' : '';



	$output .= sprintf('<form method="get" action="%s" >%s %s %s <button>%s</button></form>',get_permalink(), __('Paying Dues For','rsvpmaker-for-toastmasters'),awe_user_dropdown('user_id',$user_id,true),$r12,__('Submit','rsvpmaker-for-toastmasters'));

	return $output;

}



function tm_application_form_radio( $slug, $choices ) {

	global $post;

	if ( isset( $_POST['first_name'] ) ) {

		$posted = sanitize_text_field($_POST[$slug]);

		foreach ( $choices as $value => $choice ) {

			$checked = tm_application_checked_display($value == $posted);

			echo ' '.$checked .' '.$choice.' ';

		}	

	}

	else {

		foreach ( $choices as $value => $choice ) {

			printf( ' <input type="radio" name="%s" value="%s">	%s ', $slug, $value, $choice );

		}	

	}

}



function tm_application_checked_display($is_checked) {

	if($is_checked)

		return '&#11044;';

	else

		return '&#9675;';

}