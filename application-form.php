<?php

if ( empty( $_POST['applicant_signature'] ) ) {

	if($_POST['applicant_signature']) 
		echo '<h2 style="color:red">Signature left empty</h2><p>Application cannot be processed without a typed digital signature.</p>';
	?>

<form method="post" action="<?php echo get_permalink(); ?>" onsubmit="return validateForm()">
	<?php

}

?>

<p><strong>TOASTMASTERS INTERNATIONAL MEMBERSHIP APPLICATION</strong></p>



<div style="margin-left: 10px; width: 200px; float: right; padding: 5px; border: thin solid #000; font-size: small;">

Application Type <?php tm_application_form_hidden( 'membership_type' ); ?>

<br /><em>If applicant is transferring from another club, please fill in the three lines below.</em>

<br />Previous club name <?php tm_application_form_hidden( 'previous_club_name' ); ?><br >Previous club number<?php tm_application_form_hidden( 'previous_club_number' ); ?><br /> Member number<?php tm_application_form_hidden( 'toastmasters_id' ); ?>

</div>



<p>To become a club member, please</p>



<p>1. Completely fill out and sign the <strong>Membership Application</strong>.</p>



<p>2. Provide payment.</p>



<p>Do you need an assistive technology (such as a screen reader) to view educational materials <?php tm_application_form_choice( 'assistive_technology', array( 'No', 'Yes' ) ); ?></p>



<p>MEMBERSHIP APPLICATION</p>



<p><strong>Club Information</strong></p>



<p><label>Club name</label> <?php tm_application_form_field( 'club_name' ); ?><br><label>Club number</label> <?php tm_application_form_field( 'club_number' ); ?><br><label>Club city</label> <?php tm_application_form_field( 'club_city' ); ?></p>



<p><strong>Applicant Information</strong></p>



<p>Gender <?php tm_application_form_choice( 'gender', array( '', 'Male', 'Female', 'Non-binary', 'Decline to respond' ) ); ?></p>



<?php rsvphoney_ui(); ?>

<br><label>First name</label> <?php tm_application_form_field( 'first_name' ); ?>

<br><label>Middle name</label> <?php tm_application_form_field( 'middle_name' ); ?></p>

<p><label>Last name/Surname</label> <?php tm_application_form_field( 'last_name' ); ?>

<p>The monthly <em>Toastmaster&nbsp;</em>magazine will be sent to the following address:</p>

<p><label>Organization/In care of</label> <?php tm_application_form_field( 'address_organization' ); ?><br >

<label>Address line 1</label> <?php tm_application_form_field( 'address_line1' ); ?><br>

<label>Address line 2</label> <?php tm_application_form_field( 'address_line2' ); ?><br>

<label>City</label> <?php tm_application_form_field( 'address_city' ); ?><br>

<label>State or province</label> <?php tm_application_form_field( 'address_state' ); ?><br>

<label>Country</label> <?php tm_application_form_field( 'address_country' ); ?><br>

<label>Postal Code</label> <?php tm_application_form_field( 'address_postalcode' ); ?></p>



<p><label>Home phone number</label> <?php tm_application_form_field( 'home_phone' ); ?><br>

<label>Mobile phone number</label> <?php tm_application_form_field( 'mobile_phone' ); ?><br>

<label>Email address</label> <?php tm_application_form_hidden( 'user_email' ); ?></p>



<p><strong>Toastmasters International Dues and Fees</strong></p>



<div style="padding: 5px; border: thin dotted #000;">

<?php

tm_application_fee();

?>

</div>



<p>Dues and fees are payable in advance and are not refundable or transferable from one member to another.<br></p>

<p><strong>Sponsor of New, Reinstated or Dual Member</strong></p>



<?php

if ( isset( $_POST['sponsor'] ) ) {

	printf( '<p>%s</p>', esc_html( sanitize_text_field( stripslashes( $_POST['sponsor'] ) ) ) );

} else {

	$users = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $users as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( ! empty( $userdata->last_name ) ) {

			$name = $userdata->first_name . ' ' . $userdata->last_name;

		} else {

			$name = $userdata->display_name;

		}

		$names[] = $name;

	}

	sort( $names );

	$o = '<option value="">None Selected</option>';

	foreach ( $names as $name ) {

		$o .= sprintf( '<option value="%s">%s</option>', $name, $name );

	}

	printf( '<p><select name="sponsor">%s</select></p>', $o );

}

?>



<p><strong>A Toastmaster’s Promise</strong></p>



<p>As a member of Toastmasters International and my club, I promise</p>



<ul><li>To attend club meetings regularly</li><li>To prepare all of my projects to the best of my ability, basing them on the Toastmasters education program</li><li>To prepare for and fulfill meeting assignments</li><li>To provide fellow members with helpful, constructive evaluations</li><li>To help the club maintain the positive, friendly environment necessary for all members to learn and grow</li><li>To serve my club as an officer when called upon to do so</li><li>To treat my fellow club members and our guests with respect and courtesy</li><li>To bring guests to club meetings so they can see the benefits Toastmasters membership offers</li><li>To adhere to the guidelines and rules for all Toastmasters education and recognition programs</li><li>To act within Toastmasters core values of integrity, respect, service and excellence during the conduct of all Toastmasters activities</li></ul>



<p><strong>Member’s Agreement and Release</strong></p>



<p>Consistent with my desire to take personal responsibility for my conduct, individually and as a member of a Toastmasters club, I agree to abide by the principles contained in A Toastmaster’s Promise and the Toastmasters International Governing Documents and my club. I will refrain from any form of discrimination, harassment, bullying, derogatory, illegal, or unethical conduct, and I understand that if I engage in such conduct, I agree to reimburse Toastmasters International, my club or other clubs, or other individuals involved with Toastmasters, for any damages, losses or costs resulting from my conduct. Understanding that Toastmasters programs are conducted by volunteers who cannot be effectively screened or supervised by Toastmasters International or its clubs, I release and discharge Toastmasters International, its clubs, governing bodies, officers, employees, agents, and representatives from any liability for the intentional or negligent acts or omissions of any member or officer of my club or other clubs, or any officer of Toastmasters International. Should a dispute of some nature arise, I expressly agree to resolve all disputes, claims, and charges relating to Toastmasters, districts, clubs and Toastmasters members in accordance with Protocol 3.0: Ethics and Conduct.</p>



<p>By submitting this application, I expressly agree to the following:</p>

<ul>

<li>The collection, use and processing of the personal information I provide to Toastmasters in this membership application for the purposes of organization administration, payment of my dues, and inclusion of my contact information in a members’directory that will be distributed to members and employees of Toastmasters. In addition, the collection, use and processing of my personal information collected by Toastmasters International through Toastmasters website and by electronic communications.</li>

<li>That my information may be accessed and used by Toastmasters, its employees and agents, district officers and club officers.</li>

<li>Maintain&nbsp;changes to my personal contact information to ensure it is accurate and current by updating my personal profile page located on the Toastmasters International website:&nbsp;<strong>www.toastmasters.org/login</strong>. I understand that the majority of the data requested in this application is necessary for administrative and planning purposes.</li>

</ul>



<p>Occasionally we would like to contact you with details of services, educational updates, and organizational updates. If you consent to us contacting you for this purpose, please check the box below corresponding to acceptable contact methods:<br> Mail <?php tm_application_form_radio( 'mail_ok', array( 'Yes', 'No' ) ); ?> <br>Email <?php tm_application_form_radio( 'email_ok', array( 'Yes', 'No' ) ); ?> <br>Phone <?php tm_application_form_radio( 'phone_ok', array( 'Yes', 'No' ) ); ?></p>



<p>If you would rather not receive non-essential communications from us, please select "No" <?php tm_application_form_choice( 'opt_out', array( 'Yes, communication is welcome', 'No, I wish to opt out of non-esssential communications' ) ); ?></p>



<p>For our full privacy policy, you may visit&nbsp;<strong><a target="_blank" href="https://www.toastmasters.org/footer/privacy-policy">www.toastmasters.org/footer/privacy-policy</a></strong>.</p>



<p><strong>Club email and privacy settings</strong></p>

<p>Do you grant the club permission to send you email communications such as meeting updates.<br><?php tm_application_form_radio( 'tm_privacy_prompt', array( '0' => 'Yes, permission granted', '2' => 'No, permission DENIED' ) ); ?> </p>

<p>Do you grant permission for your contact information to be shared with other members in the member directory.<br><?php tm_application_form_radio( 'tm_directory_blocked', array( '0' => 'Yes, permission granted', '1' => 'No, permission DENIED' ) ); ?> </p>



<p><strong>Verification of Applicant</strong></p>



<p>By my signature below, I agree to the terms of A Toastmaster’s Promise and the Member’s Agreement and Release stated above, and certify that I am 18 years of age or older (in compliance with the Toastmasters Club Constitution for Clubs of Toastmasters International).</p>



<p><em>I acknowledge that my electronic signature on this document is legally equivalent to my handwritten signature.</em> Type your name as the electronic signature.</p>

<p><label>Applicant’s signature</label> <?php tm_application_form_field( 'applicant_signature' ); ?><br >

<label>Date</label> <?php tm_application_form_field( 'applicant_signature_date' ); ?>

</p>

<?php

rsvpmaker_nonce();

if ( empty( $_POST['applicant_signature'] ) ) {

	echo '<p><button>Submit</button></p></form>';

}

?>
<script>
	function validateForm() {
		const sig = document.getElementById('applicant_signature').value;
		const first_name = document.getElementById('first_name').value;
		const last_name = document.getElementById('last_name').value;
		console.log('signature',sig);
		if('' == sig) {
			alert('A typed signature is required');
			return false;
		}
		else if (('' == first_name) || ('' == last_name)) {
			alert('You must enter a first and last name');
			return false;
		}  
		else {
			return true;
		}
	}
</script>
<p>&nbsp;</p>

