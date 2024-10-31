<?php

function add_contest_userlink( $user_id, $link, $post_id = 0 ) {

	global $post;

	if ( ! $post_id && isset( $post->ID ) ) {

		$post_id = $post->ID;

	}

	$contest_users = get_post_meta( $post_id, 'contest_user' );

	if ( ! in_array( $user_id, $contest_users ) ) {

		add_post_meta( $post_id, 'contest_user', $user_id );

	}

	update_post_meta( $post_id, 'contest_link_' . $user_id, $link );

}



function wpt_get_contest_array( $type = 'selection' ) {

	$contest_selection['International Speech Contest'] = array(

		'Speech Development' => 20,

		'Effectiveness'      => 15,

		'Speech Value'       => 15,

		'Physical'           => 10,

		'Voice'              => 10,

		'Manner'             => 10,

		'Appropriateness'    => 10,

		'Correctness'        => 10,

	);

	$contest_selection['Video Speech Contest']         = array(

		'Speech Development' => 20,

		'Effectiveness'      => 15,

		'Speech Value'       => 15,

		'Physical'           => 10,

		'Voice'              => 10,

		'Manner'             => 10,

		'Appropriateness'    => 10,

		'Correctness'        => 10,

	);

	$contest_selection['Humorous Speech Contest']      = array(

		'Speech Development' => 15,

		'Effectiveness'      => 10,

		'Speech Value'       => 15,

		'Audience Response'  => 15,

		'Physical'           => 10,

		'Voice'              => 10,

		'Manner'             => 10,

		'Appropriateness'    => 10,

		'Correctness'        => 5,

	);

	$contest_selection['Table Topics Contest']         = array(

		'Speech Development' => 30,

		'Effectiveness'      => 25,

		'Physical'           => 15,

		'Voice'              => 15,

		'Appropriateness'    => 10,

		'Correctness'        => 5,

	);

	$contest_selection['Evaluation Contest']           = array(

		'Analytical Quality' => 40,

		'Recommendations'    => 30,

		'Technique'          => 15,

		'Summation'          => 15,

	);

	$contest_selection['Webinar Contest']  = array(

		'Speech Development'          => 15,

		'Audience Engagement'         => 15,

		'Speech Value'                => 15,

		'Call to Action'              => 15,

		'Visual'                      => 15,

		'Voice'                       => 10,

		'Manner'                      => 5,

		'Appropriateness/Correctness' => 10,

	);



	$contest_timing['International Speech Contest'] = '5 to 7';

	$contest_timing['Video Speech Contest']         = '5 to 7';

	$contest_timing['Humorous Speech Contest']      = '5 to 7';

	$contest_timing['Table Topics Contest']         = '1 to 2';

	$contest_timing['Evaluation Contest']           = '2 to 3';

	$contest_timing['Webinar Contest']  = '5 to 7';

	if ( $type == 'timing' ) {

		return $contest_timing;

	} else {

		return $contest_selection;

	}

}



function wpt_get_contest_default($role) {

	$contest['International Contest Speaker'] = '<option value="International Speech Contest">International Speech Contest</option>';

	$contest['Video Contest Speaker']         = '<option value="Video Speech Contest">Video Speech Contest</option>';

	$contest['Humorous Contest Speaker']      = '<option value="Humorous Speech Contest">Humorous Speech Contest</option>';

	$contest['Table Topics Contestant']         = '<option value="Table Topics Contest">Table Topics Contest</option>';

	$contest['Evaluation Contestant']           = '<option value="Evaluation Contest">Evaluation Contest</option>';

	return (isset($contest[$role])) ? $contest[$role] : '';

}



function set_contest_parameters( $post_id, $contest ) {

	global $current_user;

	$contest_selection = wpt_get_contest_array();

	$contest_timing    = wpt_get_contest_array( 'timing' );

	update_post_meta( $post_id, 'toast_contest_name', $contest );

	update_post_meta( $post_id, 'toast_contest_scoring', $contest_selection[ $contest ] );

	update_post_meta( $post_id, 'toast_timing', $contest_timing[ $contest ] );

	update_post_meta( $post_id, 'tm_contest_dashboard_users', array( $current_user->ID ) );

}



function toast_contest( $mode ) {

	global $post, $rsvp_options;

	$contest_name   = get_post_meta( $post->ID, 'toast_contest_name', true );

	$dashboard_name = ( empty( $contest_name ) ) ? $post->post_title : $contest_name;

	$date           = rsvpmaker_date( $rsvp_options['long_date'], get_rsvpmaker_timestamp( $post->ID ) );

	$output         = '<div id="scoring">';

	$practice       = get_practice_contest_links();

	$output        .= wpt_mycontests_links( $practice );
	$related = 0;

	if ( $mode == 'dashboard' ) {

		$output .= '<h1>Scoring Dashboard - ' . $date . ' ' . $dashboard_name . '</h1>';

		$output .= toast_scoring_dashboard( $related, $practice );

	} elseif ( $mode == 'voting' ) {

		$output .= '<h1>Voting - ' . $date . ' ' . $dashboard_name . '</h1>';

		$output .= toast_scoring_sheet();

	} elseif ( $mode == 'mycontests' ) {

		$output .= '<h1>My Contests</h1>';

		$output .= wpt_mycontests();

	} elseif ( $mode == 'shuffle' ) {

			$output .= wpt_shuffle_contestants();

	} else {

		return '<div>Error: scoring mode not recognized</div>';

	}

	$output .= '</div>';// close wrapper

	return $output;

}



add_shortcode( 'wpt_contests_prompt', 'wpt_contests_prompt' );

function wpt_contests_prompt( $atts ) {

	if ( is_user_logged_in() ) {

		return sprintf( '<p>Judges/Organizers: see <a href="%s">contest links</a></p>', get_permalink() . '?scoring=mycontests' );

	} else {

		return sprintf( '<p>Judges/Organizers: <a href="%s">login</a> to see assignments</p>', wp_login_url( get_permalink() . '?scoring=mycontests' ) );

	}

}



function wpt_shuffle_contestants() {

	global $post;

	$contestants  = get_post_meta( $post->ID, 'tm_scoring_contestants', true );

	$order        = get_post_meta( $post->ID, 'tm_scoring_order', true );

	$contest_name = get_post_meta( $post->ID, 'toast_contest_name', true );

	if ( isset( $_POST['shuffle'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$order = $contestants;

		shuffle( $order );

		update_post_meta( $post->ID, 'tm_scoring_order', $order );

		echo '<p>Speaking order set</p>';

	}

	if ( empty( $order ) ) {

		echo '<h1>Order Not Set - ' . esc_html($contest_name) . '</h1>';

		sort( $contestants );

		foreach ( $contestants as $contestant ) {

			printf( '<p>%s</p>', esc_html($contestant) );

		}

		printf( '<form method="post" action="%s"><button>Set Speaking Order</button><input type="hidden" name="shuffle" value="1">%s</form>', get_permalink( $post->ID ) . '?scoring=shuffle', rsvpmaker_nonce('return') );

	} else {

		echo '<h1>Speaker Order  - ' . esc_html($contest_name) . '</h1>';

		foreach ( $order as $index => $contestant ) {

			printf( '<p id="text%d">%s</p>', $index, esc_html($contestant) );

		}

	}

}



function wpt_mycontests() {

	if ( ! is_user_logged_in() ) {

		printf( '<p>You must <a href="%s">login</a> to see assignments</p>', wp_login_url( get_permalink() . '?scoring=mycontests' ) );

		return;

	}



	// if(current_user_can('manage_network')) contest_user_fix();

	global $wpdb, $current_user;

	$action = get_permalink();

	if(isset($_POST['trash_event'])) {

		foreach($_POST['trash_event'] as $id) {

			$sql = $wpdb->prepare("UPDATE $wpdb->posts SET post_status='trash' WHERE post_author=%d AND ID=%d",$current_user->ID,$id);

			echo "<p>Moved event id #$id to the trash</p>";

			$wpdb->query($sql);

		}

	}

	$output    = $past = '';

	$displayed = array();

	$now       = time();

	$results   = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key='contest_user' AND meta_value='" . $current_user->ID . "' ORDER BY meta_id" );

	foreach ( $results as $row ) {

		if ( in_array( $row->post_id, $displayed ) ) {

			continue;

		}

			$displayed[] = $row->post_id;

			$post        = get_post( $row->post_id );

		if ( empty( $post ) || ( $post->post_status != 'publish' ) ) {

			continue;

		}

			$event = get_rsvpmaker_event( $row->post_id );

			$t        = intval( $event->ts_start );

		// if($_GET['debug'])

			// print_r($row);

		if ( isset( $_GET['debug'] ) ) {

			print_r( $row );

		}

			$date      = rsvpmaker_date( 'F j, Y', $t );

			$link      = get_post_meta( $row->post_id, 'contest_link_' . $current_user->ID, true );

			$permalink = get_permalink( $row->post_id );

		if ( strpos( $link, $permalink ) === false ) {

			$p    = explode( '?', $link );

			$link = $permalink . '?' . $p[1];

			update_post_meta( $row->post_id, 'contest_link_' . $current_user->ID, $link );

		}

			$label = '';

		if ( strpos( $link, 'dashboard' ) ) {

			$label = '(dashboard)';

		}

		if ( strpos( $link, 'judge' ) ) {

			$label = '(judge)';

		}

		if ( strpos( $link, 'timer' ) ) {

			$label = '(timer)';

		}

		$checkbox = ($post->post_author == $current_user->ID) ? '<input type="checkbox" name="trash_event[]" value="'.$event->event.'" />' : '';

		$item = sprintf( '<p>%s <a href="%s">%s - %s %s</a></p>', $checkbox, $link, $event->post_title, $date, $label );// .$datetime;

		if(!empty($checkbox))

			$item .= '<p><button>Move checked items to trash</button></p>';

		if ( $t < $now ) {

			$past .= $item;

		} else {

			$output .= $item;

		}

	}

	if ( empty( $output ) ) {

		$output = '<p>None</p>';

	}

	if ( ! empty( $past ) ) {

		$output .= '<h3>Past Events</h3>' . $past;

	}

	$output = '<p>Contest links you have access to:</p><form method="post" action="'.$action.'">' . $output.'</form>';

	return $output;

}



function contest_get_master($post_id) {

	global $master;

	if(!empty($master))

		return $master;

	$master = get_post_meta($post_id,'_contest_tracking_post',true);

	if(empty($master))

		$master = $post_id;

	return $master;

}



function toast_related_contests($post_id) {

	$master = get_post_meta($post_id,'_contest_tracking_post',true);

	$all_related = array();

	if($master) {

		$all_related = get_post_meta( $master, '_contest_related' );

		array_unshift($all_related,$master);

	}

	else {

		$all_related = get_post_meta( $post_id, '_contest_related' );

		array_unshift($all_related,$post_id);

	}

	return $all_related;

}



function contest_get_edits($master) {

	global $post;

	$edits = array($master);

	$temp = get_post_meta($master,'contest_sync_to');

	if(!empty($temp) && is_array($temp)) {

		foreach($temp as $value)

		$edits[] = $value;

	}

	else {

		//check old method

		$sync = get_post_meta( $post->ID, 'tm_contest_sync', true );

		if(isset($sync['copy_to']) && $sync['copy_from'])

			{

				add_post_meta($sync['copy_from'],'contest_sync_to',$sync['copy_to']);

				add_post_meta($sync['copy_to'],'contest_sync_from',$sync['copy_from']);

				delete_post_meta( $sync['copy_from'], 'tm_contest_sync' );

				delete_post_meta( $sync['copy_to'], 'tm_contest_sync' );

				$edits[] = $sync['copy_to'];

			}

	}

	return $edits;

}



function toast_scoring_dashboard( $related = 0, $practice = array() ) {

	ob_start();

	global $post, $wpdb;

	global $current_user;

	$master = contest_get_master($post->ID);

	$contest_name = get_post_meta( $post->ID, 'toast_contest_name', true );

	if ( isset( $_POST['break_connection'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		delete_post_meta(intval($_POST['break_connection']),'contest_sync_to',$post->ID);

		delete_post_meta($post->ID,'contest_sync_from');

	}

	if ( isset( $_POST['dashboardvote'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$id = sanitize_text_field($_POST['judge_id']);

		update_post_meta( $post->ID, 'tm_scoring_vote' . $id, array_map('sanitize_text_field',$_POST['vote']) );

		add_post_meta( $post->ID, 'dashboard_vote', $id );

	}

	$output     = '';

	$votinglink = $actionlink = get_permalink( $post->ID );

	if ( strpos( $actionlink, '?' ) ) {

		$actionlink .= '&scoring=dashboard';

		$votinglink .= '&scoring=voting';

	} else {

		$actionlink .= '?scoring=dashboard';

		$votinglink .= '?scoring=voting';

	}

	do_action( 'wpt_scoring_dashboard_top' );

	$link = sprintf( '<div id="agendalogin"><a href="%s">' . __( 'Login', 'rsvpmaker-for-toastmasters' ) . '</a></div>', site_url() . '/wp-login.php?redirect_to=' . urlencode( $actionlink ) );

	$contest_selection = wpt_get_contest_array();

	$contest_timing    = wpt_get_contest_array( 'timing' );

	$demo = get_post_meta( $post->ID, '_contest_demo', true );

	// $master ?

	$dashboard_users = get_post_meta( $master, 'tm_contest_dashboard_users', true );

	if(!$dashboard_users)

		$dashboard_users = array();

	if(!in_array($post->post_author,$dashboard_users)) {

		$dashboard_users[] = $post->post_author;

	}

	$is_setup =	get_post_meta( $post->ID, 'toast_contest_scoring' );

	if(empty($is_setup))

		; //if not yet set up, don't require login

	elseif ( $demo ) {

		$output .= '<p>This page is configured as a demo, no password required.</p>';

	} elseif ( ! is_user_logged_in() ) {

		return '<p>You must be logged in as the site administrator or editor, chief judge, or ballot counter.</p>' . $link;

	} else {

		if ( ! current_user_can( 'edit_others_posts' ) ) {

			if ( ! is_array( $dashboard_users ) ) {

				return '<p>Logged in user not recognized as a site editor, administrator, chief judge, or ballot counter (empty list).</p>' . wpt_mycontests();

			}

			if ( ! in_array( $current_user->ID, $dashboard_users ) ) {

				return '<p>Logged in user not recognized as a site editor, administrator, chief judge, or ballot counter.'.var_export($dashboard_users,true).'</p>' . wpt_mycontests();

			}

		}

	}

	$default_dashboard_users = array( $current_user->ID );

	if ( ! empty( $_POST['contest_scoring_more'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$backup = $post;
		update_post_meta($post->ID,'contest_data_model',1);

		foreach($_POST['contest_scoring_more'] as $index => $scoring_index) {

			if(empty($scoring_index))

				continue;

			$scoring_index        = sanitize_text_field($scoring_index);

			$contest_scoring      = $contest_selection[ $scoring_index ];

			$timing               = $contest_timing[ $scoring_index ];

			$data['post_title']   = $scoring_index;

			$data['post_content'] = '[wpt_contests_prompt]';

			$data['post_author']  = $current_user->ID;

			$data['post_type']    = 'rsvpmaker';

			$data['post_status']  = 'publish';

			$id                   = wp_insert_post( $data );

			if ( ! empty( $contest_scoring ) ) {

				add_contest_userlink( $current_user->ID, add_query_arg('scoring','dashboard',get_permalink($id)), $id );

				update_post_meta( $id, 'toast_contest_name', $scoring_index );

				update_post_meta( $id, 'toast_contest_scoring', $contest_scoring );

				update_post_meta( $id, 'toast_timing', $timing );

				update_post_meta( $id, '_rsvpmaker_special', 'Contest document' );

				update_post_meta( $id, '_contest_tracking_post', $post->ID );

				add_post_meta( $id, '_contest_related', $backup->ID );

				add_rsvpmaker_event( $id, get_rsvp_date( $backup->ID ) );

				add_post_meta( $backup->ID, '_contest_related', $id );

				update_post_meta( $id, 'tm_contest_dashboard_users', $default_dashboard_users );

				$track_role = sanitize_text_field($_POST['track_role_more'][$index]);

				if ( ! empty( $track_role ) ) {

					update_post_meta( $id, 'tm_track_role', $track_role );

				}

				if ( $id ) {

					$rp = get_post( $id );

					printf( '<p>Created related contest: <a target="_blank" href="%s">%s</a></p>', add_query_arg('scoring','dashboard',get_permalink( $id )), $rp->post_title );

				}

				if ( ! empty( $_POST['syncwith1'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

					add_post_meta($post->ID,'contest_sync_to',$id);

					add_post_meta($id,'contest_sync_from',$post->ID);

				}

			}	

		}
		$post = $backup;
	}


	if(isset($_GET['snycfrom'])) {
		update_post_meta($post->ID,'contest_sync_from',intval($_GET['snycfrom']));
		add_post_meta(intval($_GET['snycfrom']),'contest_sync_to',$post->ID);
		$judges   = get_post_meta( intval($_GET['snycfrom']), 'tm_scoring_judges', true );
		update_post_meta( $post->ID, 'tm_scoring_judges', $judges );
		update_post_meta( $post->ID, 'tm_scoring_tiebreaker', get_post_meta( intval($_GET['snycfrom']), 'tm_scoring_tiebreaker', true ) );
	}

	if ( ! empty( $_POST['contest_scoring'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$scoring_index   = sanitize_text_field($_POST['contest_scoring']);

		$contest_scoring = $contest_selection[ $scoring_index ];

		printf('<p>New contest scoring %s</p>',var_export($contest_scoring,true));

		$timing          = $contest_timing[ $scoring_index ];

		if ( ! empty( $contest_scoring ) ) {

			update_post_meta( $post->ID, 'toast_contest_name', $scoring_index );

			update_post_meta( $post->ID, 'toast_contest_scoring', $contest_scoring );
			printf('<p>Record New contest scoring %s, %d</p>',var_export($contest_scoring,true),$post->ID);

			update_post_meta( $post->ID, 'toast_timing', $timing );

			update_post_meta( $post->ID, 'tm_contest_dashboard_users', $default_dashboard_users );

			add_contest_userlink( $current_user->ID, add_query_arg('scoring','dashboard',get_permalink($post->ID)), $post->ID );

		}

	} elseif ( ! empty( $_POST['scoring_label'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST['scoring_label'] as $index => $label ) {

			$label = sanitize_text_field( stripslashes( $label ) );

			$score = (int) $_POST['scoring_score'][ $index ];

			if ( ! empty( $label ) && ! empty( $score ) ) {

				$contest_scoring[ $label ] = $score;

				$foropt[]                  = $label . ':' . $score;

			}

		}

		if ( ! empty( $contest_scoring ) ) {

			$custom    = get_option( 'toast_custom_contest' );

			$newcustom = sprintf( '<option value="%s">%s</option>', implode( ',', $foropt ), sanitize_text_field(stripslashes( $_POST['contest_name'] ) ) );

			update_option( 'toast_custom_contest', $custom . $newcustom );

			update_post_meta( $post->ID, 'toast_contest_scoring', $contest_scoring );

			update_post_meta( $post->ID, 'toast_timing', sanitize_text_field($_POST['toast_timing']) );

		}

	} else {

		$contest_scoring = get_post_meta( $post->ID, 'toast_contest_scoring', true );

	}

	if ( empty( $contest_scoring ) || isset( $_GET['reset_scoring'] ) ) {

		$options = '<option value="">Select Contest</option>';

		foreach ( $contest_selection as $contest => $score_array ) {
			$options .= sprintf( '<option value="%s">%s</option>', $contest, $contest );
		}

		if ( isset( $_GET['clear_custom_scoring'] ) ) {
			delete_option( 'toast_custom_contest' );
		} else {
			$options .= get_option( 'toast_custom_contest' );
		}

		preg_match_all('/{"role":"([a-zA-Z ]+ Contest[^"]+)/',$post->post_content,$matches);

		$roles = (isset($matches[1])) ? $matches[1] : array();

		if(!empty($roles)) {

			foreach($roles as $role){

				$default_option = wpt_get_contest_default($role);

				$contest_defaults[] = array('role' => $role, 'option' => $default_option);

			}

		}			

		$output  .= '<p>Use this dashboard to pick a contest, add your list of contestants and judges, and generate personalized links to a page where each judge can score contestants and enter their votes.</p><p>As the judges vote, you will see their votes appear on the dashboard within seconds. If you have the Timer and Tiebreaking Judge record their work online, their input can also be factored in to show if any contestants were disqualified or how any ties were broken.</p><p><a href="https://www.wp4toastmasters.com/knowledge-base/contest-setup/" target="_blank">Step-By-Step Directions</a></p>';

		$default_option = (isset($contest_defaults[0])) ? $contest_defaults[0]['option'] : '';

		$default_role = (isset($contest_defaults[0])) ? $contest_defaults[0]['role'] : '';

		$output  .= '<h1>Choose Contest</h1>' . sprintf('<form method="post" action="%s">

	<div>Contest:<br /><select name="contest_scoring" class="contest_scoring">%s</select> %s</div>',$actionlink,$default_option.$options,track_roles_ui($default_role));

	$i = 2;

	if(isset($contest_defaults) && (sizeof($contest_defaults) > 1)) {

		array_shift($contest_defaults);

		foreach($contest_defaults as $defaults)

		{

			$output .= sprintf('<div class="more">Contest #%s <select name="contest_scoring_more[]">%s</select> %s</div>',$i,$defaults['option'].$options,track_roles_ui($defaults['role'],'_more[]'));

			$i++;

		}

	}

	$output .= '<p><a href="#morecontests" id="multicontest">+ Show options for multiple contests</a> (optionally, you can set the judges to be the same for all contests held on the same day)</p><div id="morecontests">';

	for($i; $i < 6; $i++)

		$output .= sprintf('<div class="more">Contest #%s <select name="contest_scoring_more[]">%s</select> %s</div>',$i,$options,track_roles_ui('','_more[]'));

	$output .= '<p><input type="checkbox" name="syncwith1" value="checked" checked="checked" /> Use same list of judges and functionaries for all contests</p></div>';

	$output .= sprintf('<p><input type="radio" name="ballot_no_password" value="0"  checked="checked" /> User password required for access to ballot, timer\'s report form</p>

	<p><input type="radio" name="ballot_no_password" value="1"  /> No password. Ballots protected by coded links</p>

	<p><em>By default, a password is required for all voting forms associated with a user account. You may turn off password protection to make it easier for judges to access thier ballots, which will still be private as long as the link is only shared with the individual judges. This setting also applies to the timer\'s report. Guest judge links, created by entering a name rather than choosing a user account, are not password protected. The contest dashboard is always password protected.</em></p>

		<button>Set</button></div>

%s</form>',rsvpmaker_nonce('return'));

$output .= '<div id="custom_contest"><h1>Custom Contest</h1>' . sprintf(	'<form method="post" action="%s" id="custom_contest"><p>Contest Name: <input type="input" name="contest_name" value="My Custom Contest" /></p>

',	$actionlink);



		for ( $i = 1; $i < 15; $i++ ) {

			$output .= sprintf( '<div>Label: <input type="text" name="scoring_label[%d]" /> Score: <input class="setscore" type="text" name="scoring_score[%d]" /></div>', $i, $i );

		}

		$output .= '<div>Timing <input type="text" name="toast_timing" value="5 to 7" size="10"> minutes</div>';

		$output .= '<div id="readyprompt"></div><button>Set</button></div>'.rsvpmaker_nonce('return').'

</form></div>';

		return $output;

	}



	if ( true ) { // kludge

		$master = contest_get_master($post->ID);

		$edits = contest_get_edits($master);



		if ( ! empty( $_POST['copy_judges'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			$copyfrom = (int) $_POST['copy_judges'];

			$judges   = get_post_meta( $copyfrom, 'tm_scoring_judges', true );

			update_post_meta( $post->ID, 'tm_scoring_judges', $judges );

			update_post_meta( $post->ID, 'tm_scoring_tiebreaker', get_post_meta( $copyfrom, 'tm_scoring_tiebreaker', true ) );

			update_post_meta( $post->ID, 'contest_timer', get_post_meta( $copyfrom, 'contest_timer', true ) );

			foreach ( $judges as $index => $judge_id ) {

				if ( is_numeric( $judge_id ) ) {

					$arg  = array(

						'scoring' => 'voting',

						'judge'   => $index,

					);

					$link = add_query_arg( $arg, get_permalink() );

					add_contest_userlink( $judge_id, $link, $post->ID );

				}

			}

		}



		if ( isset( $_POST['track_role'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			$track_role = sanitize_text_field($_POST['track_role']);

			if ( $track_role == 'cancel' ) {

				$track_role = '';

				delete_post_meta( $post->ID, 'tm_track_role' );

			} else {

				update_post_meta( $post->ID, 'tm_track_role', $track_role );

			}

		} else {

			$track_role = get_post_meta( $post->ID, 'tm_track_role', true );

		}



		if ( isset( $_POST['make_order'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			// don't keep checking against agenda

			$track_role = '';

			delete_post_meta( $post->ID, 'tm_track_role' );

		}



		if ( isset( $_POST['tm_tiebreaker'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			$tiebreaker = (int) $_POST['tm_tiebreaker'];

			foreach($edits as $edit)

			update_post_meta( $edit, 'tm_scoring_tiebreaker', $tiebreaker );

		} else {

			$tiebreaker = get_post_meta( $post->ID, 'tm_scoring_tiebreaker', true );

		}



		if ( isset( $_POST['contest_timer_user'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			foreach($edits as $edit)

			update_post_meta( $edit, 'contest_timer', (int) $_POST['contest_timer_user'] );

		}



		if ( isset( $_POST['timer_named'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			foreach($edits as $edit)

			update_post_meta( $edit, 'contest_timer_named', sanitize_text_field($_POST['timer_named']) );

		}



		if ( isset( $_POST['tm_scoring_dashboard_users'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			$dashboard = add_query_arg( 'scoring', 'dashboard', get_permalink() );

			if ( empty( $dashboard_users ) ) {

				$dashboard_users = array(); // reset

			}

			foreach ( $_POST['tm_scoring_dashboard_users'] as $user_id ) {

				$user_id = (int) $user_id;

				if ( $user_id && ! in_array( $user_id, $dashboard_users ) ) {

					foreach($edits as $edit){

						add_contest_userlink( $user_id, add_query_arg('scoring','dashboard',get_permalink($edit)), $edit );

					}

					$dashboard_users[] = $user_id;

				}

			}

			foreach($edits as $edit)

			update_post_meta( $edit, 'tm_contest_dashboard_users', $dashboard_users );

		}



		if ( ! empty( $track_role ) ) {

			$signup     = get_post_meta( $post->ID, '_contest_tracking_post', true );

			$track_from = ( $signup ) ? $signup : $post->ID;

			$miss       = 0;

			$field_base = '_role_' . preg_replace( '/[^a-zA-Z0-9]/', '_', $track_role );

			for ( $i = 1; $i < 20; $i++ ) {

				$lookup     = $field_base . '_' . $i;

				$contestant = get_post_meta( $track_from, $lookup, true );

				if ( empty( $contestant ) ) {

					$miss++;

					if ( $miss > 5 ) {

						break;

					} else {

						continue;

					}

				} elseif ( is_numeric( $contestant ) ) {

					$userdata   = get_userdata( $contestant );

					$contestant = $userdata->first_name . ' ' . $userdata->last_name;

				} elseif ( $contestant == '?' ) {

					continue;

				}

				$contestants[] = $contestant;

			}

		} elseif ( isset( $_POST['contestant'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			foreach ( $_POST['contestant'] as $contestant ) {

				if ( ! empty( $contestant ) ) {

					$contestants[] = sanitize_text_field($contestant);

				}

			}

			// allow user to clear the list of contestants by submitting an empty list

			if ( empty( $contestants ) ) {

				delete_post_meta( $post->ID, 'tm_scoring_contestants' );

			}

		}

		if ( ! empty( $contestants ) ) {

			update_post_meta( $post->ID, 'tm_scoring_contestants', $contestants );

			if ( isset( $_POST['make_order'] ) && ! empty( $_POST['contestant'] ) ) {

				foreach ( $_POST['contestant'] as $contestant ) {

					if ( ! empty( $contestant ) ) {

						$order[] = sanitize_text_field($contestant);

					}

				}

				update_post_meta( $post->ID, 'tm_scoring_order', $order );

				delete_post_meta( $post->ID, 'tm_track_role' );

			}

		}



		if ( isset( $_POST['judge'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			foreach ( $_POST['judge'] as $index => $judge_id ) {

				$judge_id = sanitize_text_field($judge_id);

				if ( ! empty( $judge_id ) ) {

					foreach($edits as $edit){

						$link = add_query_arg(

							array(

								'scoring' => 'voting',

								'judge'   => $index,

							),

							get_permalink($edit)

						);

							add_contest_userlink( $judge_id, $link, $edit );

					}

					$judge[ $index ] = $judge_id;

				}

			}

			foreach ( $_POST['judge_name'] as $index => $judge_name ) {

				if ( ! empty( $judge_name ) ) {

					$judge[ $index ] = sanitize_text_field($judge_name);

					$email = ( empty( $_POST['judge_email'][ $index ] ) ) ? '' : sanitize_text_field($_POST['judge_email'][ $index ]);

					if ( ! empty( $email ) && rsvpmail_contains_email( $email ) ) {

						echo "<p>judge email $email</p>";

						foreach($edits as $edit)

						update_post_meta( $edit, 'judge_email' . $index, $email );

					}

				}

			}

		}

		if ( isset( $_POST['remove_judge'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			foreach ( $_POST['remove_judge'] as $judge_index ) {

				$judge_index = sanitize_text_field($judge_index);

				$judge_id = $judge[ $judge_index ];

				unset( $judge[ $judge_index ] );

				if ( is_numeric( $judge_id ) ) {

					foreach($edits as $edit)

					{

						delete_post_meta( $edit, 'contest_user', $judge_id );

						delete_post_meta( $edit, 'contest_link_' . $judge_id );	

					}

					echo 'delete contest_link_' . $judge_id . ' post ' . $post->ID;

				}

			}

		}



		if ( isset( $judge ) ) {

			foreach($edits as $edit)

			update_post_meta( $edit, 'tm_scoring_judges', $judge );

		}

	}



	if ( empty( $contestants ) ) {

		$contestants = toast_get_contestants( $post->ID );

	}

	$contests = toast_related_contests($post->ID);

	$master = contest_get_master($post->ID);

	$edits = contest_get_edits($master);



	$judges = get_post_meta( $master, 'tm_scoring_judges', true );

	$timer_user = (int) get_post_meta( $master, 'contest_timer', true );

	$dashboard_users = get_post_meta( $master, 'tm_contest_dashboard_users', true );

	if ( empty( $dashboard_users ) ) {

		$dashboard_users = array();

	}

	if ( ! in_array( $post->post_author, $dashboard_users ) ) {

		$dashboard_users[] = $post->post_author;

		update_post_meta( $master, 'tm_contest_dashboard_users', $dashboard_users );

	}



	$is_locked = get_post_meta( $post->ID, 'contest_locked', true );



	if ( isset( $_POST['contest_locked'] ) ) {

		$is_locked = true;

		update_post_meta( $post->ID, 'contest_locked', $current_user->ID );

	} elseif ( isset( $_POST['contest_unlock'] ) && ( ( $is_locked == $current_user->ID ) || current_user_can( 'manage_options' ) ) ) {

		$is_locked = false;

		update_post_meta( $post->ID, 'contest_locked', false );

	}



	if ( isset( $_POST['resetit'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {



		foreach ( $_POST['resetit'] as $reset ) {

			if ( $reset == 'scores' ) {

				foreach ( $judges as $i => $value ) {

					delete_post_meta( $post->ID, 'tm_scoring_vote' . $i );

					delete_post_meta( $post->ID, 'tm_vote_received' . $i );

					delete_post_meta( $post->ID, 'tm_subscore' . $i );

				}

				delete_post_meta( $post->ID, '_time_report' );

				delete_post_meta( $post->ID, '_time_disqualified' );

				echo '<p>Scores reset</p>';

			}



			if ( $reset == 'judges' ) {

				delete_post_meta( $post->ID, 'tm_scoring_judges' );

			}

			if ( $reset == 'deleteorder' ) {

				delete_post_meta( $post->ID, 'tm_scoring_order' );

				echo '<p>Speaking order deleted</p>';

				unset( $order );

			} elseif ( $reset == 'order' ) {

				$order = $contestants;

				shuffle( $order );

				update_post_meta( $post->ID, 'tm_scoring_order', $order );

				echo '<p>Speaking order reset (reshuffled)</p>';

			}

		}

	}



	if ( empty( $order ) ) {

		$order = get_post_meta( $post->ID, 'tm_scoring_order', true );

	}



	if ( ! empty( $judges ) && ! empty( $order ) ) {

		echo '<p><button id="votecheck">Start</button> checking for votes</p>';

		echo '<div id="score_status"></div><div id="scores">' . toast_scoring_update_get( $post->ID ) . '</div>';

	}



	if ( isset( $_POST['hide_ballot_links'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$nolinks = (int) $_POST['hide_ballot_links'];

		update_post_meta( $post->ID, 'hide_ballot_links', $nolinks );

	} else {

		$nolinks = (int) get_post_meta( $post->ID, 'hide_ballot_links', true );

	}



	if ( ! empty( $contestants ) && empty( $order ) ) {

		?>

<form method="post" action="<?php echo esc_attr($actionlink); ?>">

	<h2>Set Speaking Order</h2>

	<p><em>Randomized speaking order has not been set.</em></p>

	<div><input type="hidden" name="resetit[]" value="order">

		<button>Set</button></div>

<?php rsvpmaker_nonce(); ?>

</form>

		<?php

		$shuffle_link = add_query_arg(

			array(

				'scoring' => 'shuffle',

			),

			get_permalink( $post->ID )

		);

		printf( '<p>Set order for %s <a target="_blank" href="%s">open in new tab</a></p>', $contest_name, $shuffle_link );

		$all_related = toast_related_contests($post->ID);

		if ( !empty($all_related) ) {

			foreach($all_related as $related) {

				$other_shuffle_link = add_query_arg(

					array(

						'scoring' => 'shuffle',

					),

					get_permalink( $related )

				);

				$other_contest_name = get_post_meta( $related, 'toast_contest_name', true );

				printf( '<p class="other">Set order for %s <a target="_blank" href="%s">open in new tab</a></p>', $other_contest_name, $other_shuffle_link );	

			}

		}

	} elseif ( ! empty( $order ) ) {

		echo '<h3>Speaking Order</h3>';

		if ( sizeof( $order ) != sizeof( $contestants ) ) {

			echo '<div style="color: red; font-weight: bold;">Order appears to be out of sync with contestant list.</div>';

		}

		foreach ( $contestants as $contestant ) {

			if ( ! in_array( $contestant, $order ) ) {

				printf( '<div style="color: red; font-weight: bold;">Missing: %s</div>', $contestant );

			}

		}

		foreach ( $order as $index => $next ) {

			printf( '<div>#%d %s</div>', $index + 1, $next );

		}

	}



	if ( isset( $_POST['ballot_no_password'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$ballot_no_password = (int) $_POST['ballot_no_password'];

		foreach($edits as $edit) {

			update_post_meta( $edit, 'ballot_no_password', $ballot_no_password );

		}

	} else {

		$ballot_no_password = get_post_meta( $post->ID, 'ballot_no_password', true );

	}



	if ( ! $is_locked ) {

		if ( isset( $_POST['importfrom'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			echo 'Copying setup from event post #' . $import = (int) $_POST['importfrom'];

			$users = get_post_meta( $import, 'contest_user' );

			if ( $users ) {

				foreach ( $users as $user ) {

					add_post_meta( $post->ID, 'contest_user', $user );

				}

			}

			$judges = get_post_meta( $import, 'tm_scoring_judges', true );

			if ( $judges ) {

				update_post_meta( $post->ID, 'tm_scoring_judges', $judges );

			}

			$dashboard_users = get_post_meta( $import, 'tm_contest_dashboard_users', true );

			if ( $dashboard_users ) {

				update_post_meta( $post->ID, 'tm_contest_dashboard_users', $dashboard_users );

			}

			$timer_user = (int) get_post_meta( $import, 'contest_timer', true );

			if ( $timer_user ) {

				update_post_meta( $post->ID, 'contest_timer', $timer_user );

			}

			$tie_breaker = get_post_meta( $import, 'tm_scoring_tiebreaker', true );

			if ( $tie_breaker ) {

				update_post_meta( $post->ID, 'tm_scoring_tiebreaker', $tie_breaker );

			}



			$sql     = "SELECT * FROM $wpdb->postmeta WHERE post_id=$import AND meta_key LIKE 'contest_link%' ";

			$results = $wpdb->get_results( $sql );

			if ( $results ) {

				foreach ( $results as $row ) {

					$p   = explode( '?', $row->meta_value );

					$url = get_permalink() . '?' . $p[1];

					update_post_meta( $post->ID, $row->meta_key, $url );

					// printf('<p>Setting %s %s %s</p>',$post->ID,$row->meta_key,$row->meta_value);

				}

			}

		}

	}// end locked test



	if ( ! empty( $judges ) ) {

		$dashboard_forms = '';

		$checked          = ( $nolinks ) ? '' : ' checked="checked" ';

		$practice_contest = get_option( 'tm_practice_contest' );

		$practice_judges  = get_post_meta( $practice_contest, 'tm_scoring_judges', true );

		$update_practice = false;

		echo '<h2>Voting Links</h2><p><input type="checkbox" id="showlinks" value="1" ' . $checked . ' /> Show Links </p><p class="votinglink">Share these personalized voting links with the judges. </p> ';

		wpt_contest_emaillinks_post();

		if ( empty( $_POST['email_link'] ) ) {

			echo '<p>To send these links by email, see the Email Links tab, below.</p>';

		}

		?>

		

<p class="votinglink">



		<?php

		$email_links = '';



		foreach ( $judges as $key => $value ) {



			$name = get_member_name( $value );

			if ( is_numeric( $value ) ) {

				$userdata = get_userdata( $value );

				$username = $userdata->user_login;

			} else {

				$username = '';

			}

			$is_tiebreaker = ( $key == $tiebreaker );

			if ( $is_tiebreaker ) {

				$name = 'Tie Breaker';

				if ( ! empty( $username ) ) {

					$username = "(tiebreaker's username)";

				}

			}

			echo '<div class="votinglink">';

			$plainlinks = $links  = '';

			$links .= '<h4>Voting for ' . esc_attr($name) . '</h4>' . "\n";

			foreach($contests as $c) {

				$votinglink = add_query_arg('scoring','voting',get_permalink($c));

				$contest_name   = get_post_meta( $c, 'toast_contest_name', true );

				$v = $votinglink . '&judge=' . $key;

				$links .= sprintf( '<p>%s <a target="_blank" href="%s">%s</a></p>', esc_html($contest_name), esc_attr($v), esc_html($v) );

				$plainlinks .= esc_html($contest_name)."\n".$v."\n\n";

			}

	

			if ( ! empty( $username ) && ! $ballot_no_password ) {

				$links .= sprintf( '<p>Voting links are password protected, user name: <strong>%s</strong> | <a href="%s">Login</a> | <a href="%s">Set/Reset password</a></p>', $username, wp_login_url( $v ), wp_login_url() . '?action=lostpassword' );

			}

			echo $links;

			if ( empty( $practice_judges[ $key ] ) ) {

				$practice_judges[ $key ] = $value;

				$update_practice         = true;

			}

			$v      = add_query_arg(

				array(

					'scoring' => 'voting',

					'judge'   => $key,

					'reset'   => 1,

				),

				get_permalink( $practice_contest )

			);

			$links .= sprintf( '<p>%s <a target="_blank" href="%s">%s</a></p>', 'Practice Contest Ballot for ' . esc_html($name), esc_attr($v), esc_html($v) );

			$plainlinks .= "Practice Ballot\n".$v."\n\n";



			$links .= '<p>See this <a href="https://www.wp4toastmasters.com/knowledge-base/digital-ballot-for-toastmasters-contests/">tutorial</a> on how the digital ballot works.</a>';

			$plainlinks .= "Tutorial\nhttps://www.wp4toastmasters.com/knowledge-base/digital-ballot-for-toastmasters-contests/\n\n";

			// $email_links .= $links;

			$email_links .= wpt_contest_emaillinks( $plainlinks, $key, 'judge', $value ); // value is user id or name

			echo '</div>';

			//sanitization occurs within dashboard_vote function

			$dashboard_forms .= dashboard_vote( $contestants, $key, $name, $actionlink, $is_tiebreaker );

		}



		if ( $update_practice ) {

			update_post_meta( $practice_contest, 'tm_scoring_judges', $practice_judges );

		}



		if ( ! empty( $other_judges ) ) {

			printf( '<p>%s judges only registered for other contest</p>', sizeof( $other_judges ) );

		}



		echo '<div class="votinglink">';

		$timer_code = get_post_meta( $post->ID, 'tm_timer_code', true );

		if ( empty( $timer_code ) ) {

			$timer_code = time() + rand( 1, 99 );

			update_post_meta( $post->ID, 'tm_timer_code', $timer_code );

		}





		$links      = '<h4>Timer</h4>' . "\n";

		$plainlinks = "Timer\n";

		foreach($contests as $c) {

			$timer_link = add_query_arg(

				array(

					'timer'       => 1,

					'claim_timer' => 1,

					'contest'     => $timer_code,

				),

				get_permalink( $c )

			);

			$contest_name   = get_post_meta( $c, 'toast_contest_name', true );

			$links .= sprintf( "<p>%s Timer's Report" . '<br /><a target="_blank" href="%s">%s</a></p>', $contest_name, $timer_link, $timer_link );

			$plainlinks .= $contest_name."\n".$timer_link."\n\n";		

			if ( $timer_user && ! $ballot_no_password ) {

				$userdata = get_userdata( $timer_user );

				$username = $userdata->user_login;

				$name     = $userdata->first_name . ' ' . $userdata->last_name;

				$links   .= sprintf( '<p>This link is password protected, user name: <strong>%s</strong> | <a href="%s">Login</a> | <a href="%s">Set/Reset password</a></p>', $username, wp_login_url( $timer_link ), wp_login_url() . '?action=lostpassword' );

				$plainlinks .= "Login required to access: ".wp_login_url( $timer_link )."\n";

			}

		}



		$timer_code          = get_post_meta( $practice_contest, 'tm_timer_code', true );

		$practice_timer_link = add_query_arg(

			array(

				'timer'       => 1,

				'claim_timer' => 1,

				'contest'     => $timer_code,

				'reset'       => 1,

			),

			get_permalink( $practice_contest )

		);

		$links              .= sprintf( "<p>%s Timer's Report" . '<br /><a target="_blank" href="%s">%s</a></p>', 'Practice Contest', $practice_timer_link, $practice_timer_link );

		$plainlinks .= "Practice Timer's Report\n$practice_timer_link\n\n";

		echo $links;

		// $email_links .= $links;

		$email_links .= wpt_contest_emaillinks( $plainlinks, $timer_code, 'timer', $timer_user );

		echo $links;

		echo '</div>';



	}



	?>

<div>

	<?php



	if ( $is_locked ) {

		echo '<h3>Settings Locked</h3><p>Contest settings are locked. Only a website administrator, or the user who locked the form, can remove the lock.</p>';

		if ( ( $is_locked == $current_user->ID ) || current_user_can( 'manage_options' ) ) {

			?>

			<form method="post" action="<?php echo esc_attr($actionlink); ?>">

				<h2>Unlock</h2>

				<input type="hidden" name="contest_unlock" value="1">

				<button>Unlock</button>

				<?php rsvpmaker_nonce(); ?>

			</form>

			<?php

		}

	} else {

		if(!isset($timer_user)) $timer_user = 0;

		$addtodrop   = contest_user_list_top( $judges, $timer_user, $dashboard_users );

		$genericdrop = wp_dropdown_users( array( 'echo' => false ) );

		$genericdrop = preg_replace( '/<select[^>]+>/', '$0' . $addtodrop . '<optgroup label="All Users">', $genericdrop );

		$genericdrop = str_replace( '</select>', '</optgroup></select>', $genericdrop );

		?>

	<h2>Setup</h2>

	<h3 class="rsvpmaker-nav-tab-wrapper nav-tab-wrapper">

	<a class="nav-tab nav-tab-active" href="#contestants">Contestants</a>

	<a class="nav-tab" href="#judges">Judges and Timer</a>

	<a class="nav-tab" href="#email_links">Email Links</a>

	<a class="nav-tab" href="#backup_ballots">Backup Ballots</a>

	  <a class="nav-tab" href="#security">Security</a>

	  <a class="nav-tab" href="#lock-reset">Lock/Reset</a>

	</h2>



	<div id="sections" class="rsvpmaker" >

	<section class="rsvpmaker"  id="contestants">

		<?php

		if ( $is_locked ) {

			echo '<p>Settings are locked</p>';

		} else {

			?>

	<form method="post" action="<?php echo esc_attr($actionlink); ?>" >

			<?php

			echo track_roles_ui( $track_role );



			?>

<div id="role_track_status">

			<?php

			if ( ! empty( $track_role ) ) {

				printf( '<p>Names pulled from %s role signups on the agenda.</p>', $track_role );}

			?>

	</div>

<div id="manual_contestants">

			<?php

			if ( empty( $track_role ) && ! empty( $track ) ) {

				echo '<p>or enter names</p>';

			}



			if ( is_array( $contestants ) ) {

				foreach ( $contestants as $value ) {

					// print_r($value);

					printf( '<div><input type="text" name="contestant[]" value="%s"></div>', $value );

				}

			}

			$stop = 10;

			if ( is_array( $contestants ) ) {

				$stop = $stop - sizeof( $contestants );

			}

			if ( $stop < 2 ) {

				$stop = 2;

			}

			for ( $i = 0; $i < $stop; $i++ ) {

				echo '<div><input type="text" name="contestant[]" value=""></div>';

			}

			?>

<p><input type="checkbox" name="make_order" value="1"> Record this as the official speaking order</p>

</div>

<p><button>Submit</button></p>

<?php rsvpmaker_nonce(); ?>

</form>

			<?php

		}

		?>

	</section>

	<section class="rsvpmaker"  id="judges">

		<?php

		if ( $is_locked ) {

			echo 'Settings are locked';

		} elseif ( $sync_from = get_post_meta($post->ID,'contest_sync_from',true) ) {

			contest_break_connection($sync_from);

		} else {

			$related = get_post_meta( $post->ID, '_contest_related', true );

			?>

		

	<form method="post" action="<?php echo esc_attr($actionlink); ?>" >

	<p>You can select judges from the drop-down list of users or enter the name and email address of guest judges who do not have a user account. Ballot links for guest judges will not be password protected, even if that feature is turned on (see the Security tab).</p>

			<?php

			do_action( 'wpt_contest_judges_form' );

			if ( is_array( $judges ) ) {

				foreach ( $judges as $index => $value ) {

					$selected_option = '';

					if ( ! empty( $tiebreaker ) && ( $tiebreaker == $index ) ) {

						$s = ' checked="checked" ';

					} else {

						$s = '';

					}

					if ( isset( $_GET['debug'] ) ) {

						printf( '<div>%s %s</div>', $index, $value );

					}

					if ( is_numeric( $value ) ) {

						$user            = $value;

						$name            = get_member_name( $value );

						$open            = 'Open';

						$selected_option = sprintf( '<option value="%s">%s</option>', $user, $name );

						printf( '<p><input type="hidden" name="judge[%s]" value="%s" /> %s<br /><input type="radio" name="tm_tiebreaker" value="%s" %s />Tiebreaker <input type="checkbox" name="remove_judge[]" value="%s" > Remove as judge</p>', $index, $user, $name, $index, $s, $index );

					} else {

						$user = 0;

						$name = $value;

						$open = 'Guest';

						$email = get_post_meta($post->ID,'judge_email'.$index, true);

						printf( '<p><input type="hidden" name="judge[%s]" value="%s" /><input type="text" name="judge_name[%s]" value="%s" /><br /><input type="text" name="judge_email[%s]" value="%s" /><br /><input type="radio" name="tm_tiebreaker" value="%s" %s />Tiebreaker <input type="checkbox" name="remove_judge[]" value="%s" > Remove as judge</p>', $index, $user, $index, $name, $index, $email, $index, $s, $index );

					}

				}

			}

			$t = time();

			for ( $i = 0; $i < 15; $i++ ) {

				$index = $t + ( $i * 100 ) + rand( 1, 99 );

				$drop  = str_replace( 'user', 'judge[' . $index . ']', $genericdrop );

				$class = ( $i > 5 ) ? ' class="morejudges" ' : '';

				printf( '<p %s>%s <input type="radio" name="tm_tiebreaker" value="%s" />Tiebreaker</p>', $class, $drop, $index );

			}

			for ( $i = 0; $i < 15; $i++ ) {

				$index = $t + ( $i * 100 ) + rand( 1, 99 );

				$class = ( $i > 5 ) ? ' class="morejudges" ' : '';

				printf( '<p %s>Name <input type="text" name="judge_name[%d]" value=""> Email <input type="text" name="judge_email[%d]" value=""><br /><input type="radio" name="tm_tiebreaker" value="%s" />Tiebreaker</p>', $class, $index, $index, $index );

			}

			?>

	<p><input type="checkbox" id="showmorejudges"> Show more judge assignment entries</p>

	

	<h3>Timer</h3>

			<?php

			$timer_user  = (int) get_post_meta( $post->ID, 'contest_timer', true );

			$timer_named = get_post_meta( $post->ID, 'contest_timer_named', true );

			if ( empty( $timer_named ) ) {

				$timer_named = array(

					'name'  => '',

					'email' => '',

				);

			}



			$selected_option = ( empty( $timer_user ) ) ? '' : sprintf( '<option value="%s">%s</option>', $timer_user, get_member_name( $timer_user ) );

			$drop            = str_replace( 'user', 'contest_timer_user', $genericdrop );// awe_user_dropdown ('judge['.$index.']', $user, true, $open);

			if ( ! empty( $selected_option ) ) {

				$drop = preg_replace( '/<select[^>]+>/', '$0' . $selected_option, $drop );

			}

			echo '<div><em>With</em> a user account ' . $drop . '</div>';

			printf( '<p><em>Without</em> without a user account: Name <input name="timer_named[name]" value="%s"> Email <input name="timer_named[email]" value="%s"> </p>', $timer_named['name'], $timer_named['email'] );

			?>

	<h3>Judging Links</h3>

<p><input type="radio" name="hide_ballot_links" value="0" 

			<?php

			if ( empty( $nolinks ) ) {

				echo ' checked="checked" ';}

			?>

	 /> Show judge ballot links</p>

<p><input type="radio" name="hide_ballot_links" value="1" 

			<?php

			if ( ! empty( $nolinks ) ) {

				echo ' checked="checked" ';}

			?>

	 /> Hide judge ballot links (if they're not being used)</p>

	<p><button>Update Judge Assignments/Options</button></p>

	<?php rsvpmaker_nonce(); ?>

</form>

			<?php

		}

		?>

	</section>

<section class="rsvpmaker"  id="email_links">

<p>Use this form to email links to the judges and timer. You can send them one at a time or use the Send All Links button at the bottom.</p>

<form method="post" action="<?php echo esc_attr($actionlink); ?>" >

<input type="hidden" id="send_link_action" value="<?php echo get_rest_url( null, 'wptcontest/v1/send_link' )?>">

<p>You can customize this introduction to the list of links:</p>

<textarea name="intro_note" id="intro_note" style="width: 90%" rows="3">Please confirm you received this email. We're planning to use a web-based voting / vote counting system for our upcoming contest, and these are the links we would like you to use for your role. You may want to try the practice link ahead of time.</textarea>

		<?php

		echo $email_links;

		?>

<p><br /><button>Send All Links</button></p>

	</section>

	<section class="rsvpmaker"  id="backup_ballots">

		<?php

		echo '<h3>Backup Voting Forms</h3><p>If judges have problems with the online voting, you can record votes on their behalf.</p>';

		echo '<div class="votingforms_tab">';

		//sanitization occurs within dashboard_vote function

		echo $dashboard_forms . '</div>';

		?>

	</section>

	<section class="rsvpmaker"  id="security">

		<?php

		//retrieved on judging screen

		if ( $sync_from ) {

			contest_break_connection($sync_from);

		} else {

			?>

	<form method="post" action="<?php echo esc_attr($actionlink); ?>" >

	<h3>Security Options</h3>

<p><input type="radio" name="ballot_no_password" value="0" 

			<?php

			if ( empty( $ballot_no_password ) ) {

				echo ' checked="checked" ';}

			?>

	 /> User password required for access to ballot, timer's report form</p>

<p><input type="radio" name="ballot_no_password" value="1" 

			<?php

			if ( ! empty( $ballot_no_password ) ) {

				echo ' checked="checked" ';}

			?>

	 /> No password. Ballots protected by coded links</p>

<p><em>By default, a password is required for all voting forms associated with a user account. You may turn off password protection to make it easier for judges to access thier ballots, which will still be private as long as the link is only shared with the individual judges. This setting also applies to the timer's report. Guest judge links, created by entering a name rather than choosing a user account, are not password protected. The contest dashboard is always password protected.</em></p>

<h3>Dashboard Users</h3>

	<p>Add chief judge, ballot counters</p>

			<?php

			$dashlimit = sizeof( $dashboard_users ) + 5;

			for ( $i = 0; $i < $dashlimit; $i++ ) {

				$user            = empty( $dashboard_users[ $i ] ) ? 0 : $dashboard_users[ $i ];

				$selected_option = ( ! $user ) ? '' : sprintf( '<option value="%s">%s</option>', $user, get_member_name( $user ) );

				$drop            = str_replace( 'user', 'tm_scoring_dashboard_users[]', str_replace( "id='user'", '', $genericdrop ) );// awe_user_dropdown ('judge['.$index.']', $user, true, $open);

				if ( ! empty( $selected_option ) ) {

					$drop = preg_replace( '/<select[^>]+>/', '$0' . $selected_option, $drop );

				}

				echo '<div>' . $drop . '</div>';

			}

			?>

	<p><button>Submit</button></p>

	<?php rsvpmaker_nonce(); ?>

</form>

			<?php

		}//end slaved

		?>

	</section>



	<section id="lock-reset">

<form method="post" action="<?php echo esc_attr($actionlink); ?>">

	<h2>Lock Settings</h2>

	<p>You can do this once the contest begins to disable the reset function or any other changing of settings while the contest is in progress.</p>

	<input type="hidden" name="contest_locked" value="1">

	<button>Lock</button>

	<?php rsvpmaker_nonce(); ?>

</form>



<form method="post" action="<?php echo esc_attr($actionlink); ?>">

	<h2>Reset</h2>

	<div><input type="checkbox" name="resetit[]" value="scores"> Scores and Timer's Report</div>

	<div><input type="checkbox" name="resetit[]" value="judges"> Judges List</div>

	<div><input type="checkbox" name="resetit[]" value="order"> Re-Shuffle Speaking Order</div>

	<div><input type="checkbox" name="resetit[]" value="deleteorder"> Delete Speaking Order</div>

	<button>Reset</button>

	<?php rsvpmaker_nonce(); ?>

</form>

	</section>

	</div><!--end of sections--->

</div>

		<?php

		judge_import_form( $actionlink );

	} //end test $is_locked

	do_action( 'wpt_scoring_dashboard_bottom' );

	?>

<p style="margin-top: 200px;"><a href="<?php echo esc_attr($actionlink) . '&reset_scoring=1'; ?>">Change Contest Type</a></p>

	<?php

	$output .= ob_get_clean();

	return $output;

}



function toast_get_contestants( $post_id ) {

	return get_post_meta( $post_id, 'tm_scoring_contestants', true );

}



function toast_scoring_update_get( $post_id ) {

	$judges = get_post_meta( $post_id, 'tm_scoring_judges', true );

	if ( empty( $judges ) ) {

		return 'Judges not set';

	}

	$contestants = toast_get_contestants( $post_id );

	if ( empty( $contestants ) ) {

		return 'Contestants not set';

	}



	$tiebreaker      = get_post_meta( $post_id, 'tm_scoring_tiebreaker', true );

	$tiebreaker_vote = array();



	$timer_report = get_post_meta( $post_id, '_time_report', true );

	$timer_report = ( empty( $timer_report ) ) ? "<p>Timer's report not submitted" : "<h3>Timer's Report</h3>" . $timer_report;

	$disqualified = get_post_meta( $post_id, '_time_disqualified', true );

	if ( empty( $disqualified ) ) {

		$disqualified = array();

	}



	$output            = '';

	$novote            = 0;

	$missing_votes     = [];

	$did_vote     = [];

	$tiebreaker_status = '<h3>Tiebreaker Ranking</h3>';

	foreach ( $judges as $index => $judge ) {

		$votes = get_post_meta( $post_id, 'tm_scoring_vote' . $index, true );

		if ( ! empty( $votes ) ) {

			update_post_meta( $post_id, 'tm_vote_received' . $index, true );

		}

		if ( is_numeric( $judge ) ) {

			$userdata = get_userdata( $judge );

			$judge    = $userdata->first_name . ' ' . $userdata->last_name;

		}

		if ( $index == $tiebreaker ) {

			if ( empty( $votes ) ) {

				$tiebreaker_status = '<div style="color: red;">Tiebreaking judge has not yet voted</div>';

			} else {

				$tiebreaker_vote = $votes;

				unset( $votes );

				foreach ( $tiebreaker_vote as $i => $vote ) {

					$tiebreaker_status .= sprintf( '<div>%s</div>', $vote );

				}

			}

		} elseif ( empty( $votes ) ) {

			$output .= '<h3>' . $judge . '</h3><p>no votes recorded</p>';

			$novote++;

			$missing_votes[] = $judge;

		} else {

			$did_vote[] = $judge;

			$output        .= '<h3>' . $judge . '</h3>';

			$signature      = get_post_meta( $post_id, 'tm_scoring_signature' . $index, true );

			$output        .= sprintf( '<div>Signed: %s</div>', $signature );

			$votes_recorded = true;

			foreach ( $votes as $i => $vote ) {

				$points  = 3 - $i;

				$output .= sprintf( '<div>%s %d points</div>', $vote, $points );

				if ( empty( $ranking[ $vote ] ) ) {

					$ranking[ $vote ] = $points;

				} else {

					$ranking[ $vote ] += $points;

				}

			}

		}

	}

	if ( ! isset( $votes_recorded ) ) {

		$output = 'No votes recorded';

	} else {

		$top       = '<div style="margin: 10px; padding: 10px; "><h2>Top Scores</h3>';

		$topscores = '<h3>Full Ranking with Scores</h3>';

		$topcount  = 0;

		foreach ( $contestants as $c ) {

			if ( empty( $ranking[ $c ] ) ) {

				$ranking[ $c ] = 0;

			}

		}

		if ( ! empty( $disqualified ) ) {

			$top .= sprintf('<p>%d contestant%s disqualificatied for time</p>',sizeof($disqualified),(sizeof($disqualified) > 1) ? 's':'');

			$order = get_post_meta( $post_id, 'tm_scoring_order', true );

			if ( ! empty( $order ) ) {

				foreach ( $disqualified as $id ) {

					$c              = $order[ $id ];

					$ranking[ $c ] -= 100;

				}

			}

		}

		arsort( $ranking );

		$last_contestant = '';

		$last_points     = 0;

		$inc             = 0.01;

		$tie             = false;

		foreach ( $ranking as $contestant => $points ) {

			if ( ! empty( $last_contestant ) && ( $points == $last_points ) ) {

				$tie = true;

			}

			$last_contestant = $contestant;

			$last_points     = $points;

		}



		if ( ! empty( $tiebreaker_vote ) ) {

			rsort($tiebreaker_vote);

			$top .= '<p>Tiebreaking judge vote applied</p>';

			foreach ( $tiebreaker_vote as $index => $contestant ) {

					if(!isset($ranking[ $contestant ]))

						$ranking[ $contestant ] = $inc;

					else

						$ranking[ $contestant ] += $inc;

					if(isset($_GET['debug']))

						printf('<p>Tiebreaker adjustment %s %s</p>',$contestant,$ranking[ $contestant ]);

				$inc += 0.01;

			}

			arsort( $ranking );

		}



		if ( $novote ) {

			$top .= sprintf( '<div style="color: red;">%s judges have not yet voted: %s</div>', $novote, implode(', ',$missing_votes) );

			if(!empty($did_vote))

				$top .= '<div>Did vote: '.implode(', ',$did_vote).'</div>';

		} else {

			$top .= '<div style="background-color: red; color: white; font-weight: bold; padding: 5px;">All judges have now voted</div>';

			$alljudgesvoted = true;

		}



		if(isset($_GET['debug']))

			print_r($ranking);



		$lastpoint     = 0;

		$lastpointsint = 0;

		$topnopoints   = '<h3>Without Scores</h3>';



		foreach ( $ranking as $contestant => $points ) {

			if ( ( $topcount < 3 ) && ( $points > 0 ) ) {

				$is_tie    = ( $points == $lastpoint ) ? ' (tied with #' . $topcount . ')' : '';

				$top      .= sprintf( '<div>#%d %s</div>', $topcount + 1, $contestant . $is_tie );

				$lastpoint = $points;

			}

			if ( $points >= -1 ) {

				$pointsint     = (int) $points;

				$tiemessage    = ( $pointsint == $lastpointsint ) ? ' (Tiebreaking Judge\'s vote applied)' : '';

				$lastpointsint = $pointsint;

				$topscores    .= sprintf( '<div>%s <span class="contestant_points">%s points %s</span></div>', $contestant, $points, $tiemessage );

				$topnopoints  .= sprintf( '<div>%s</div>', $contestant );

			} else {

				$topscores .= sprintf( '<div>%s (disqualified)</div>', $contestant, $points );

			}

			$topcount++;

		}

		$top .= $tiebreaker_status . $timer_report . '</div>';

		if ( ! empty( $alljudgesvoted ) && ! empty( $tiebreaker_status ) ) {

			$top = apply_filters( 'wpt_contest_alljudgesvoted', $top );

		}

		$output = $top . $topscores . $topnopoints . $output;

	}

	return $output;

}



function toast_scoring_update() {

	if ( ! isset( $_GET['toast_scoring_update'] ) ) {

		return;

	}

	$update = toast_scoring_update_get( sanitize_text_field($_GET['toast_scoring_update']) );

	die( $update );

}



add_action( 'init', 'toast_scoring_update' );



function toast_scoring_sheet() {

	ob_start();

	global $post;

	global $current_user;

	$votinglink = $actionlink = get_permalink( $post->ID );

	if ( strpos( $actionlink, '?' ) ) {

		$actionlink .= '&scoring=dashboard';

		$votinglink .= '&scoring=voting';

	} else {

		$actionlink .= '?scoring=dashboard';

		$votinglink .= '?scoring=voting';

	}



	$contestants        = toast_get_contestants( $post->ID );

	$judges             = get_post_meta( $post->ID, 'tm_scoring_judges', true );

	$tiebreaker         = get_post_meta( $post->ID, 'tm_scoring_tiebreaker', true );

	$ballot_no_password = get_post_meta( $post->ID, 'ballot_no_password', true );

	$is_demo = get_post_meta( $post->ID, 'ballot_demo', true );



	if ( isset( $_REQUEST['judge'] ) && !$is_demo ) {

		$id = (int) $_REQUEST['judge'];

		if ( ! isset( $judges[ $id ] ) ) {

			return 'Invalid judge code' . wpt_mycontests();

		}

		$judge_name = $judges[ $id ];

		if ( is_numeric( $judge_name ) ) {

			$dashboard_users = get_post_meta( $post->ID, 'tm_contest_dashboard_users', true );

			if ( empty( $dashbord_users ) ) {

				$dashboard_users = array();

			}

			if ( empty( $ballot_no_password ) && ( $current_user->ID != $judge_name ) && ! in_array( $current_user->ID, $dashboard_users ) ) {

				echo wpt_mycontests();

				printf( '<p>You must <a href="%s">login</a> to access this judge\'s voting form. %d</p>', wp_login_url( sanitize_text_field($_SERVER['REQUEST_URI']) ), $post->ID);

				return;

			}

			$judge_name = get_member_name( $judge_name );

		}

	} 

	elseif($is_demo) {

		$ballot_no_password = true;

		$id = 1;

		$judge_name = 'Demo Ballot';

	} 

	elseif ( is_user_logged_in() ) {

		$id   = $judge_id = array_search( $current_user->ID, $judges );

		$judge_name = $name = get_member_name( $judge_id );

		if ( ! $id ) {

			echo '<div style="color: red;">Logged in user is not on the list of judges</div>';

		}

	}



	$votinglink .= '&judge=' . $id;



	$link = sprintf( '<div id="agendalogin"><a href="%s">' . __( 'Login', 'rsvpmaker-for-toastmasters' ) . '</a></div>', site_url() . '/wp-login.php?redirect_to=' . urlencode( $votinglink ) );



	if ( ! $id ) {

		return sprintf( '<p>Before voting, you must either log in as a user authorized as a judge or access this page with a code provided for guest judges. %s</p>', $link ) . wpt_mycontests();

	}

	do_action( 'wpt_voting_form_top' );

	printf( '<p><em>Voting Form for %s</em></p>', $judge_name );



	if ( isset( $_POST['signature'] ) && empty( $_POST['signature'] ) ) {

		echo '<div style="color: red; padding: 20px;">Error: Signature left blank</div>';

	} elseif ( isset( $_POST['vote'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$vote = array_map('sanitize_text_field',$_POST['vote']);

		update_post_meta( $post->ID, 'tm_scoring_vote' . $id, $vote );

		update_post_meta( $post->ID, 'tm_scoring_signature' . $id, sanitize_text_field($_POST['signature'] . ' - ' . $_POST['signature_date'] ) );

	}



	if ( isset( $_GET['reset'] ) ) {

		$votes = false;

	} else {

		$votes = get_post_meta( $post->ID, 'tm_scoring_vote' . $id, true );

	}

	if ( is_array( $votes ) && ! isset( $_GET['judge_id'] ) ) {

		printf( '<form action="%s" method="post">', $votinglink . '&check=' . time() );

		echo '<h2>Recorded</h2>';

		$dashboard_users = get_post_meta( $post->ID, 'tm_contest_dashboard_users', true );
		if(!$dashboard_users)
			$dashboard_users = array();
		if(!in_array($post->post_author,$dashboard_users)) {
			$dashboard_users[] = $post->post_author;
		}
		$emails = [];
		foreach($dashboard_users as $did) {
			$userdata = get_userdata($did);
			$emails[] = $userdata->user_email;
		}
		$message = 'My choices: ';

		foreach ( $votes as $index => $vote ) {

			printf( '<p>#%d %s</p>', $index + 1, $vote );
			$message .= '#'.($index+1).' '.$vote.' ';

			printf( '<input type="hidden" name="vote[]" value="%s">', $vote );

			if ( empty( $vote ) ) {

				$blanks = true;

				echo '<div style="color: red;">Vote left blank</div>';

			}

		}

		if(!empty($_POST['signature']))
			$message .= ' -- Signed by '.sanitize_text_field(stripslashes($_POST['signature']));
		else
			$message .= ' -- votes from '.$judge_name;

		if ( empty( $blanks ) ) {

			printf('<p>Contest officials should see your votes within moments. As a backup, you can <a target="_blank" href="mailto:%s?subject=Toastmasters contest vote&body=%s">send your vote by email</a> if instructed to by the chief judge.</p>',implode(',',$emails),$message);

			echo '<p>Keep this page open until you confirm your votes have been received properly. Some contest organizers may require an analog signature on a printout or a paper ballot as a formality.</p>';

			echo '<p><button>Resubmit</button></p><p><em>Resubmit resubmits your previous vote (does not allow you to change your vote). Only use if there is a problem with votes showing up on the voting dashboard monitored by conference officials.</em></p>';

			do_action( 'wpt_contest_ballot_submitted' );

			// check for update_post_meta($post_id,'tm_vote_received'.$index,true);

			return ob_get_clean();

		} else {

			delete_post_meta( $post->ID, 'tm_scoring_vote' . $id );

			echo '<p>Please correct errors and re-submit.</p>';

		}

		echo rsvpmaker_nonce('return').'</form>';

	}



	$order = get_post_meta( $post->ID, 'tm_scoring_order', true );

	if ( empty( $order ) ) {

		printf(

			'<p>Contestant order not set. <a href="%s">Check Now</a></p>',

			add_query_arg(

				array(

					'scoring' => 'voting',

					'judge'   => sanitize_text_field($_GET['judge']),

					'check'   => time(),

				),

				get_permalink()

			)

		); // site_url($_SERVER['REQUEST_URI'])

		return ob_get_clean();

	}



	$scoring = get_post_meta( $post->ID, 'toast_contest_scoring', true );



	if ( isset( $_GET['clear_scores'] ) ) {

		$tm_subscores = array();

	} else {

		$tm_subscores = get_post_meta( $post->ID, 'tm_subscore' . $id, true );

	}

	echo '<style>th {font-size: 10px;} .criteria {width: 50px;} .max {width: 25px} .score {width: 25px;} select {min-width: 100px;} table {max-width: 400px;}</style>';



	foreach ( $order as $index => $name ) {

		if ( empty( $name ) ) {

			continue;

		}

		printf( '<h3>Contestant #%d %s</h3><input type="hidden" id="contestant%d" value="%s">', $index + 1, $name, $index, $name );

		echo "\n";

		echo '<table><tr><th class="criteria">Criteria</th><th class="max">Max</th><th class="score">Score</th></tr>';

		echo "\n";

		$category_count = 0;

		foreach ( $scoring as $category => $maxscore ) {

			echo '<tr>';

			printf( '<th  class="criteria">%s</th><td  class="max">%s</td>', $category, $maxscore );

			if ( ! isset( $score_me[ $index ] ) ) {

				$score_me[ $index ] = 0;

			}

			if ( isset( $tm_subscores[ $category_count ][ $index ] ) ) {

				$score_me[ $index ] += $tm_subscores[ $category_count ][ $index ];

			}

			if ( isset( $_GET['demo'] ) ) {

				$preselected = rand( 2, $maxscore );

			} else {

				$preselected = 0;

			}

			$category_count++;

			printf( '<td class="score"><input type="number" min="0" max="%d" name="scores[%s][%s]" contestant="%d" class="score score%d" value="%d" /> </td></tr>', $maxscore, $category_count, $index, $index, $index, $preselected );

			echo "\n";

		}//end foreach scoring

		echo '</table>';

		printf( '<p><strong>Total <span id="sum%d">%s</span></strong></p>', $index, $score_me[ $index ] );

	}//end foreach order



	?>



<div id="autorank"><button id="autorank_now">Show Ranking</button></div>

<?php

if($is_demo)

	echo '<hr><h2>Stand-alone demo mode</h2><p>The full-featured version of this contest voting tool allows judges to cast their vote and includes a scoring dashboard where the chief judge and vote counters can watch the votes come in. See <a href="https://contest.toastmost.org">contest.toastmost.org</a></p>';

else {

?>

<p>Use the scoresheet above to guide your vote. If two contestants have the same score, use your judgement to break the tie -- you must choose first, second, and third.</p>



<h2>Vote</h2>

	<?php

	echo '<form id="voting" method="post" action="' . $votinglink . '"><div id="nowvote"></div>';

	$vote_opt = '';

	if ( ! empty( $contestants ) ) {

		sort( $contestants );

		foreach ( $contestants as $contestant ) {

			$vote_opt .= sprintf( '<option value="%s">%s</option>', $contestant, $contestant );

		}

	}



	$contestant_count = sizeof( $contestants );

	if ( $tiebreaker == $id ) {

		echo '<h3>As the tiebreaking judge, you should rank order ALL contestants.</h3>';

	}

	$max = ( ( $tiebreaker == $id ) || ( $contestant_count < 3 ) ) ? $contestant_count : 3;



	for ( $i = 1; $i <= $max; $i++ ) {

		printf( '<div><select class="voteselect" name="vote[]"><option value="">Vote #%d</option>%s</select></div>', $i, $vote_opt );

	}

	global $rsvp_options;

	?>

<div><label>Signature:</label> <input type="text" name="signature" id="signature"> <br /><label>Date:</label> <input type="text" name="signature_date" value="<?php echo rsvpmaker_date( $rsvp_options['long_date'], time() ); ?>" />

<br /><em>By typing your name and verifying the date, you are signing this ballot as your official vote</em></div>



<div id="readyprompt"></div>

<input type="hidden" name="judge_id" value="<?php echo esc_attr($id); ?>" />

<button>Vote</button>

<?php rsvpmaker_nonce(); ?>

</form>

	<?php

}//end not demo

	return ob_get_clean();

}



function dashboard_vote( $contestants, $id, $judge_name, $votinglink, $tiebreaker = false ) {

	ob_start();

	if ( $tiebreaker ) {

		$judge_name = 'Tie Breaker';

	}

	echo '<h3>' . esc_html($judge_name) . '</h3><div id="votestatus' . esc_attr($id) . '"></div>';

	echo '<form class="dashboard_votes" class="dashboard_votes" method="post" action="' . esc_attr($votinglink) . '">';

	$vote_opt = '';

	if ( ! empty( $contestants ) ) {

		sort( $contestants );

		foreach ( $contestants as $contestant ) {

			$vote_opt .= sprintf( '<option value="%s">%s</option>', esc_attr($contestant), esc_attr($contestant) );

		}

	}



	$contestant_count = ( empty( $contestants ) ) ? 0 : sizeof( $contestants );

	if ( $tiebreaker == $id ) {

		echo '<h3>As the tiebreaking judge, you should rank order ALL contestants.</h3>';

	}

	$max = ( ( $tiebreaker ) || ( $contestant_count < 3 ) ) ? $contestant_count : 3;



	for ( $i = 1; $i <= $max; $i++ ) {

		printf( '<div><select class="voteselect" name="vote[]"><option value="">Vote #%d</option>%s</select></div>', esc_attr($i), $vote_opt );

	}

	?>

	<p><input type="checkbox" name="dashboardvote" value="1" /> Record these choices on behalf of <?php echo esc_html($judge_name); ?></p>

	<input type="hidden" name="judge_id" value="<?php echo esc_attr($id); ?>" />

	<button>Vote</button>

	<?php rsvpmaker_nonce(); ?>

	</form>

	<?php

	return ob_get_clean();

}



function contest_demo( $atts ) {

	global $post;

	$output = '';

	if ( isset( $atts['result'] ) ) {

		if ( isset( $_POST['demo_title'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			$demo['post_type']    = 'rsvpmaker';

			$demo['post_title']   = sanitize_text_field(stripslashes( $_POST['demo_title'] ));

			$demo['post_content'] = 'This is a contest demo post.

	

<a href="?scoring=dashboard">Scoring Dashboard</a>';

			$demo['post_author']  = 1;

			$demo['post_status']  = 'publish';

			$demo_id              = wp_insert_post( $demo );

			add_post_meta( $demo_id, '_contest_demo', sanitize_text_field($_SERVER['REMOTE_ADDR']) );

			$link    = get_permalink( $demo_id ) . '?scoring=dashboard';

			$output .= sprintf( '<h3>Contest Demo Created!</h3><p>Scoring Dashboard: <a href="%s">%s</a></p>', $link, $link );

		}

	}



	if ( isset( $atts['form'] ) ) {

		$output .= sprintf( '<form action="%s" method="post"><h3>Create Contest Page</h3><p><input type="text" name="demo_title" value="My Demo"><br /><em>Give your page a name, such as Area Contest or Video Speech Contest</em></p><button>Create</button>%s</form>', get_permalink( $post->ID ), rsvpmaker_nonce('return') );

	}

	return $output;

}



$myusers_indexed = array();



function check_contest_collaborators() {

	global $wpdb, $current_user, $myusers_indexed;

	$myusers = array();

	$results = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key='contest_user' AND meta_value='" . $current_user->ID . "' ORDER BY meta_id" );

	foreach ( $results as $row ) {

		$sql       = "SELECT * FROM $wpdb->postmeta WHERE meta_key='contest_user' AND post_id=" . $row->post_id;

		$myresults = $wpdb->get_results( $sql );



		foreach ( $myresults as $urow ) {

			if ( is_numeric( $urow->meta_value ) && ! in_array( $urow->meta_value, $myusers ) ) {

				$myusers[] = $urow->meta_value;

			}

		}

	}

	if ( isset( $options ) && ( empty( $myusers ) || ( sizeof( $myusers ) == 1 ) ) ) {

		return $options;

	}

	foreach ( $myusers as $user_id ) {

		$user = get_userdata( $user_id );

		if ( empty( $user ) || empty( $user->user_email ) ) {

			continue;

		}

		// $output .= sprintf('<div>%s %s %s</div>',$user->first_name,$user->last_name,$user->user_email);

		$index                     = preg_replace( '/[^a-zA-Z]/', '', $user->first_name . $user->last_name . $user->user_email ) . ':' . $user->ID;

		$myusers_indexed[ $index ] = sprintf( '%s %s (%s)', $user->first_name, $user->last_name, $user->user_login );

	}

	ksort( $myusers_indexed );

	return $myusers_indexed;

}



function judge_import_form( $action ) {

	global $post, $wpdb, $current_user;

	if( get_post_meta($post->ID,'contest_sync_from',true) )

		return;

	$judges = get_post_meta( $post->ID, 'tm_scoring_judges', true );

	if ( empty( $judges ) && check_contest_collaborators() ) {

		$opt     = '<option value="">Choose Previous Contest</option>';

		$results = $wpdb->get_results( "SELECT * FROM $wpdb->posts JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id WHERE meta_key='tm_scoring_judges' AND post_status='publish' ORDER BY ID DESC" );

		if ( $results ) {

			foreach ( $results as $event ) {

				$contest_users = get_post_meta( $event->ID, 'contest_user' );

				if ( $contest_users && ! in_array( $current_user->ID, $contest_users ) ) {

					continue;

				}

				$date = get_rsvp_date( $event->ID );

				$opt .= sprintf( '<option value="%d">%s %s</option>', $event->ID, $event->post_title, rsvpmaker_date( '', $date ) );

			}

		}

		if ( ! empty( $opt )  ) {

			printf(

				'<form action="%s" method="post"><h3>Import judges/settings (optional)</h3><p><select name="importfrom">%s</select></p>

			<p>If the list of judges will be the same (or mostly the same) as for another contest, you can import those settings rather than setting them individually.</p>

			<button>Import</button>%s</form>',

				$action,

				$opt,

				rsvpmaker_nonce('return')

			);

		}

	}

}



function track_roles_ui( $track_role = '', $slug = '' ) {

	global $post;

	if ( strpos( $post->post_content, 'wp:wp4toastmasters' ) ) {

		$data = wpt_blocks_to_data( $post->post_content );

		foreach ( $data as $item ) {

			if ( ! empty( $item['role'] ) ) {

				$roles[] = $item['role'];

			}

		}

	} else {

		preg_match_all( '/role="([^"]+)/', $post->post_content, $matches );

		$roles = ( empty( $matches[1] ) ) ? array() : $matches[1];

	}



	if ( ! empty( $roles ) ) {

		$track     = '';

		$track_top = '<option value="">Select Role</option>';



		foreach ( $roles as $role ) {

			$s = ( $role == $track_role ) ? ' selected="selected" ' : '';

			if ( strpos( $role, 'peaker' ) || strpos( $role, 'peech' ) || strpos( $role, 'ontest' ) ) {

				$track_top .= sprintf( '<option value="%s" %s>%s</option>', $role, $s, $role );

			} else {

				$track .= sprintf( '<option value="%s" %s>%s</option>', $role, $s, $role );

			}

		}



		return sprintf( '<p>Sync With Agenda Role for Contestants <br /><select id="track_role%s" name="track_role%s" >%s<option value="cancel">Cancel Selection</option></select></p>', $slug, $slug, $track_top . $track );

	}



}



function tm_contest_sync( $sync = null ) {

	global $post;

	if ( empty( $sync ) ) {

		$sync = get_post_meta( $post->ID, 'tm_contest_sync', true );

	}

	if ( empty( $sync ) ) {

		return;

	}

	$copyfrom = $sync['copy_from'];

	$copyto   = $sync['copy_to'];

	$judges   = get_post_meta( $copyfrom, 'tm_scoring_judges', true );

	update_post_meta( $copyto, 'tm_scoring_judges', $judges );

	update_post_meta( $copyto, 'tm_scoring_tiebreaker', get_post_meta( $copyfrom, 'tm_scoring_tiebreaker', true ) );

	update_post_meta( $copyto, 'contest_timer', get_post_meta( $copyfrom, 'contest_timer', true ) );

	if ( $judges ) {

		foreach ( $judges as $index => $judge_id ) {

			if ( is_numeric( $judge_id ) ) {

				$arg  = array(

					'scoring' => 'voting',

					'judge'   => $index,

				);

				$link = add_query_arg( $arg, get_permalink( $copyto ) );

				add_contest_userlink( $judge_id, $link, $copyto );

			}

		}

	}

	update_post_meta( $copyto, 'tm_contest_dashboard_users', get_post_meta( $copyfrom, 'tm_contest_dashboard_users', true ) );

	update_post_meta( $copyto, 'ballot_no_password', get_post_meta( $copyfrom, 'ballot_no_password', true ) );

}



function get_practice_contest_links() {

	global $current_user;

	$practice_contest = get_option( 'tm_practice_contest' );

	$timing           = '5 to 7';

	$scoring_index    = 'International Speech Contest';

	$contest_scoring  = array(

		'Speech Development' => 20,

		'Effectiveness'      => 15,

		'Speech Value'       => 15,

		'Physical'           => 10,

		'Voice'              => 10,

		'Manner'             => 10,

		'Appropriateness'    => 10,

		'Correctness'        => 10,

	);



	if ( empty( $practice_contest ) || empty( get_post( $practice_contest ) ) ) {

		$data['post_title']   = 'Demo: ' . $scoring_index;

		$data['post_content'] = '[wpt_contests_prompt]';

		$data['post_author']  = $current_user->ID;

		$data['post_type']    = 'rsvpmaker';

		$data['post_status']  = 'publish';

		$practice_contest     = wp_insert_post( $data );

	}

	if ( empty( $data ) ) { // if new, this won't be set

		$judges = get_post_meta( $practice_contest, 'tm_scoring_judges', true );

	}

	if ( empty( $judges ) ) {

		$judges = array();

	} else {

		$size = sizeof( $judges );

		// shorten the list

		if ( $size > 15 ) {

			$i    = 1;

			$stop = $size - 10;

			foreach ( $judges as $index => $value ) {

				if ( $i < $stop ) {

					unset( $judges[ $index ] );

				}

				$i++;

			}

			$judges['100000'] = 'Demo Judge';

			update_post_meta( $practice_contest, 'tm_scoring_judges', $judges );

		}

	}

	if ( ! empty( $data ) || isset( $_GET['reset'] ) ) {

		update_post_meta( $practice_contest, 'toast_contest_name', 'Demo: ' . $scoring_index );

		update_post_meta( $practice_contest, 'toast_contest_scoring', $contest_scoring );

		update_post_meta( $practice_contest, 'toast_timing', $timing );

		update_post_meta( $practice_contest, '_rsvpmaker_special', 'Contest document' );

		add_rsvpmaker_event( $practice_contest, '2000-01-01 07:00:00' );

		$contestants = array( 'Aaron Beverly', 'Mike Carr', 'Ramona J. Smith', 'Darren LaCroix', 'Mark Brown' );

		update_post_meta( $practice_contest, 'tm_scoring_contestants', $contestants );

		update_post_meta( $practice_contest, 'tm_scoring_order', $contestants );

		update_post_meta( $practice_contest, 'ballot_no_password', 1 );

		if ( ! empty( $data ) || ( isset( $_GET['reset'] ) && isset( $_GET['scoring'] ) && ( $_GET['scoring'] == 'dashboard' ) ) ) {

			if ( is_user_logged_in() ) {

				update_post_meta( $practice_contest, 'tm_contest_dashboard_users', array( $current_user->ID ) );

			}

		}

		$judges['100000'] = 'Demo Judge';

		update_post_meta( $practice_contest, 'tm_scoring_judges', $judges );

		update_post_meta( $practice_contest, 'tm_timer_code', '200000' );

		update_option( 'tm_practice_contest', $practice_contest );

	}

	if ( isset( $_GET['reset'] ) ) {

		delete_post_meta( $practice_contest, '_time_report' );

		if ( isset( $_GET['judge'] ) ) {

			$index = sanitize_text_field($_GET['judge']);

			delete_post_meta( $practice_contest, 'tm_scoring_vote' . $index );

		} elseif ( $_GET['scoring'] == 'dashboard' ) {

			foreach ( $judges as $index => $judge ) {

				delete_post_meta( $practice_contest, 'tm_scoring_vote' . $index );

			}

		}

	}



	$practicelinks['judge'] = add_query_arg(

		array(

			'scoring' => 'voting',

			'judge'   => '100000',

			'reset'   => 1,

		),

		get_permalink( $practice_contest )

	);

	if ( is_user_logged_in() ) {

		$practicelinks['dashboard'] = add_query_arg(

			array(

				'scoring' => 'dashboard',

				'reset'   => 1,

			),

			get_permalink( $practice_contest )

		);

	}

	return $practicelinks;

}



function wpt_mycontests_links( $practice ) {

	global $post;

	$mycontests = get_permalink() . '?scoring=mycontests';

	$output     = '<div style="width: 300px;text-align: center; float: right; background-color: #FFFF99; padding: 5px;"><a href="' . $mycontests . '">My Contests</a>';

	if ( isset( $practice['dashboard'] ) ) {

		$master = contest_get_master($post->ID);

		$edits = contest_get_edits($master);

		$all_related = toast_related_contests($post->ID);

		if ( !empty($all_related) ) {

			foreach($all_related as $index => $related) {

				if($related != $post->ID) {

					$other_contest_name = get_post_meta( $related, 'toast_contest_name', true );

					//fix to for multiple

					$output .= sprintf( '<div>Related: <a target="_blank" href="%s">%s</a></div>', add_query_arg('scoring','dashboard',get_permalink( $related )), $other_contest_name );

				}

			}

		}

		$output .= sprintf( '<div><a href="%s" target="_blank">Practice Contest Dashboard</a></div>', $practice['dashboard'] );

	}

	$output .= sprintf( '<div><a href="%s" target="_blank">Practice Contest Ballot</a></div>', esc_attr($practice['judge']) );

	$output .= apply_filters( 'my_contests_help', '' );

	$output .= '<div><a  target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/category/contests/">Help</a></div>';

	$output .= '</div>';

	return $output;

}



function wpt_contest_emaillinks_post() {

	global $current_user, $post;

	if ( isset( $_POST['email_link'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST['email_link'] as $code => $email ) {

			if ( ! empty( $email ) ) {

				$code = sanitize_text_field($code);

				$mail['to']       = sanitize_text_field($email);

				$mail['subject']  = stripslashes( $_POST['email_subject'][ $code ] );

				$mail['html']     = '<p>' . wpautop(stripslashes( sanitize_textarea_field($_POST['intro_note'] ))) . "\n\n" . wpautop(stripslashes( sanitize_textarea_field($_POST['email_link_note'][ $code ]) ) )  . "</p>\n";

				$mail['from']     = $current_user->user_email;

				$mail['fromname'] = $current_user->display_name;

				rsvpmailer( $mail );

				echo '<div>Emailing links to ' . sanitize_text_field($_POST['email_link'][ $code ]) . '</div>';

			}

		}

	}

}



function wpt_contest_emaillinks( $links, $code, $role, $user_id ) {

	global $post;

	ob_start();

	// printf("User ID $user_id");

	if ( is_numeric( $user_id ) && $user_id ) {

		$userdata = get_userdata( $user_id );

		$email    = $userdata->user_email;

		$name     = $userdata->display_name;

	} elseif ( $role == 'timer' ) {

		$timer_named = get_post_meta( $post->ID, 'contest_timer_named', true );

		$email       = ( empty( $timer_named['email'] ) ) ? '' : $timer_named['email'];

		$name        = ( empty( $timer_named['name'] ) ) ? '' : $timer_named['name'];

	} else {

		$email = get_post_meta( $post->ID, 'judge_email' . $code, true );

		$name  = $user_id;

	}

	$tiebreaker = get_post_meta( $post->ID, 'tm_scoring_tiebreaker', true );

	if ( $code == $tiebreaker ) {

		$role = 'Tie Breaker';

	}

	$subject = 'IMPORTANT for your role in our contest: ' . $role;

	printf(

		'<p class="email_links_new"><strong>Email links for %s</strong>',

		$name);

		echo '<input type="text" name="email_link['.$code.']" id="email_link'.$code.'" value="'.$email.'" />';

		if($problem = rsvpmail_is_problem($email))

			printf('<br /><span style="color:red">%s</span>',$problem);

		printf('<br /><input type="text" name="email_subject[%s]" id="email_subject%s" value="%s" size="80" />',

		$code,

		$code,

		$subject);

		

		printf('<br />Note:<br /><textarea name="email_link_note[%s]" id="email_link_note%s" rows="4">%s</textarea><br />',$code,

		$code,

		"Your role: $role\n\n" . $links );



		echo '<button class="send_contest_link" id="'.$code.'" >Send to '.$name.'</button>';



		printf(' * <button class="show_ballot_links_preview" id="%s">Show previews</button><div id="send_link_status%s"></p></div></p>',

		$code,

		$code);

	echo '<div class="ballot_links_preview">' . $links . '</div>';

	return ob_get_clean();

}



function contest_user_list_top( $judges, $timer_user, $dashboard_users ) {

	global $current_user, $wpdb, $post;

	$team = get_user_meta( $current_user->ID, 'my_contest_team', true );

	if ( empty( $team ) ) {

		$team = array();

	}

	$initial = $team;

	if ( empty( $team ) ) {

		$sql     = "SELECT * FROM $wpdb->postmeta WHERE meta_key='tm_contest_dashboard_users' AND meta_value LIKE '%\"$current_user->ID\"%' AND post_id != $post->ID";

		$results = $wpdb->get_results( $sql );

		if ( $results ) {

			foreach ( $results as $row ) {

				$otherpost   = $row->post_id;

				$otherjudges = get_post_meta( $otherpost, 'tm_scoring_judges', true );

				$otherdash   = get_post_meta( $otherpost, 'tm_contest_dashboard_users', true );

				$othertimer  = get_post_meta( $otherpost, 'contest_timer', true );

				if ( ! empty( $other_judges ) && is_array( $other_judges ) ) {

					foreach ( $other_judges as $id ) {

						if ( $id && is_numeric( $id ) && ! in_array( $id, $team ) ) {

							$team[] = $id;

						}

					}

				}

				if ( ! empty( $otherdash ) && is_array( $otherdash ) ) {

					foreach ( $otherdash as $id ) {

						if ( $id && ! in_array( $id, $team ) ) {

							$team[] = $id;

						}

					}

				}

				if ( $othertimer && is_numeric( $othertimer ) && ! in_array( $othertimer, $team ) ) {

					$team[] = $othertimer;

				}

			}

		}

	}

	if ( is_array( $judges ) ) {

		foreach ( $judges as $id ) {

			if ( $id && is_numeric( $id ) && ! in_array( $id, $team ) ) {

				$team[] = $id;

			}

		}

	}

	if ( is_array( $dashboard_users ) ) {

		foreach ( $dashboard_users as $id ) {

			if ( $id && ! in_array( $id, $team ) ) {

				$team[] = $id;

			}

		}

	}

	if ( $timer_user && is_numeric( $timer_user ) && ! in_array( $timer_user, $team ) ) {

		$team[] = $timer_user;

	}



	$top = '<option value="">Open</open><optgroup label="My Contest Team">';

	foreach ( $team as $id ) {

		$name         = get_member_name( $id );

		$opt[ $name ] = sprintf( '<option value="%s">%s</option>', $id, $name );

	}

	ksort( $opt );

	$top .= implode( '', $opt );

	$top .= '</optgroup>';

	if ( $initial != $team ) {

		update_user_meta( $current_user->ID, 'my_contest_team', $team );

	}



	return apply_filters( 'wpt_contest_user_dropdown', $top );

}



function contest_break_connection($sync_from) {

$contest_name   = get_post_meta( $sync_from, 'toast_contest_name', true );

$sync_link = add_query_arg('scoring','dashboard',get_permalink($sync_from));

?>

<p>Controlled from <a href="<?php echo $sync_link; ?>"><?php echo $contest_name; ?></a>. Use the button below if you wish to break the connection and edit judges, timer, and security settings for this contest independently.</p>

	<form method="post" action="<?php echo esc_attr($actionlink); ?>" >

	<button>Break Connection</button>

	<input type="hidden" name="break_connection" value="<?php echo $sync_from; ?>">

	<?php rsvpmaker_nonce(); ?>

	</form>

<?php

}



add_shortcode('toast_ballot_standalone','toast_ballot_standalone');



function toast_ballot_standalone() {

	$contest_selection = wpt_get_contest_array();

	$output = '';

	if ( ! empty( $_POST['contest_scoring_more'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		update_post_meta($post->ID,'contest_data_model',1);

		foreach($_POST['contest_scoring_more'] as $index => $scoring_index) {

			if(empty($scoring_index))

				continue;

			$scoring_index        = sanitize_text_field($scoring_index);

			$contest_scoring      = $contest_selection[ $scoring_index ];

			$timing               = $contest_timing[ $scoring_index ];

			$data['post_title']   = $scoring_index;

			$data['post_content'] = '[wpt_contests_prompt]';

			$data['post_author']  = $current_user->ID;

			$data['post_type']    = 'rsvpmaker';

			$data['post_status']  = 'publish';

			$id                   = wp_insert_post( $data );

			$contestants = sanitize_textarea_field(trim($_POST['contestants'][$index]));

			$contestants = explode("\n",$contestants);

			//echo '<div>'.$id;

			//print_r($contestants);

			update_post_meta($id,'tm_scoring_order',$contestants);

			update_post_meta($id,'toast_contest_scoring',$contest_scoring);

			update_post_meta( $id, 'ballot_demo', true );

			$permalink = get_permalink($id);

			$permalink = add_query_arg('scoring','voting',$permalink);

			$output .= sprintf('<p><a href="%s" target="_blank">%s voting link</a></p>',$permalink,$scoring_index);

			//echo '</div>';

	}

	$output .= sprintf('<hr><p><a href="%s">Reset</a></p>',get_permalink());

	return $output;

}

else {

	//setup form

	$options = '<option value="">Select Contest</option>';



	foreach ( $contest_selection as $contest => $score_array ) {

		$options .= sprintf( '<option value="%s">%s</option>', $contest, $contest );

	}



	if ( isset( $_GET['clear_custom_scoring'] ) ) {

		delete_option( 'toast_custom_contest' );

	} else {

		$options .= get_option( 'toast_custom_contest' );

	}

	preg_match_all('/{"role":"([a-zA-Z ]+ Contest[^"]+)/',$post->post_content,$matches);

	$roles = (isset($matches[1])) ? $matches[1] : array();

	if(!empty($roles)) {

		foreach($roles as $role){

			$default_option = wpt_get_contest_default($role);

			$contest_defaults[] = array('role' => $role, 'option' => $default_option);

		}

	}			

	$default_option = (isset($contest_defaults[0])) ? $contest_defaults[0]['option'] : '';

	$default_role = (isset($contest_defaults[0])) ? $contest_defaults[0]['role'] : '';

$output  .= '<h1>Choose One or More Contests</h1>' . sprintf('<form method="post" action="%s">',$actionlink);

$i = 1;

for($i; $i < 6; $i++) {

	$output .= sprintf('<div class="more">Contest #%s <select name="contest_scoring_more[]">%s</select> %s</div>',$i,$options,track_roles_ui('','_more[]'));

	$output .= '<p>Contestants (enter in order, one per line)<br /><textarea name="contestants[]"></textarea></p>';

}

$output .= sprintf('<button>Set</button></div>

%s</form>',rsvpmaker_nonce('return'));

	return $output;

}

}

