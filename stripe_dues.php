<?php
function wpt_dues_report () {
	global $wpdb;
	echo '<h1>Member Dues Status</h1>';
	
	if(isset($_POST['paid_until'])) {
		$until = $_POST['paid_until'];
		$member_id = $_POST['member_id'];
	}

	$members = get_club_members ();
	foreach($members as $member) {
		$member = get_userdata($member->ID);
		print_r($member);
		echo '<br />';
		$log = stripe_log_by_email ($member->user_email);
		echo $log;
	}
}
