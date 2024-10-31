<?php

class Toast_Norole_Controller extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'norole/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		$post_id  = intval($request['post_id']);
		$norole = wpt_norole($post_id);
		return new WP_REST_Response( $norole, 200 );
	}
}

class WPTContest_Order_Controller extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'order/(?P<post_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		global $wpdb;
		$order = get_post_meta( $request['post_id'], 'tm_scoring_order', true );
		return new WP_REST_Response( $order, 200 );
	}
}

class WPTContest_Send_Link extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'send_link';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return is_user_logged_in();
	}

	public function get_items( $request ) {
		global $current_user;
		$email            = sanitize_text_field($_POST['email']);
		$note             = wpautop( wp_kses_post(stripslashes( $_POST['note'] ) ) );
		$mail['subject']  = sanitize_text_field(stripslashes( $_POST['subject'] ));
		$code             = sanitize_text_field($_POST['code']);
		$post_id          = (int) $_POST['post_id'];
		$mail['to']       = $email;
		$mail['html']     = $note;
		$mail['from']     = $current_user->user_email;
		$mail['fromname'] = $current_user->display_name;
		$error            = rsvpmailer( $mail );
		if ( $error ) {
			return new WP_REST_Response( $error, 200 );
		}
		return new WP_REST_Response( $mail, 200 );
	}
}

class WPTContest_VoteCheck extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'votecheck/(?P<post_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		global $current_user;
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}
		$post_id         = $request['post_id'];
		$dashboard_users = get_post_meta( $post_id, 'tm_contest_dashboard_users', true );
		return in_array( $current_user->ID, $dashboard_users );
	}

	public function get_items( $request ) {
		global $wpdb, $current_user;
		$post_id = $request['post_id'];
		$votes   = toast_scoring_update_get( $post_id );
		return new WP_REST_Response( $votes, 200 );
	}
}


class WPTContest_GotVote extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'votereceived/(?P<post_id>[0-9]+)/(?P<judge_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		global $wpdb;
		$confirmed = (bool) get_post_meta( $request['post_id'], 'tm_vote_received' . $request['judge_id'], true );
		return new WP_REST_Response( $confirmed, 200 );
	}
}
// check for update_post_meta($post_id,'tm_vote_received'.$index,true);

class WPT_Timer_Control extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'toasttimer/v1';
		$path      = 'control/(?P<post_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => array( 'GET', 'POST' ),
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		if ( ! empty( $_POST ) ) {
			$control = array_map('sanitize_text_field',$_POST);
			update_post_meta( $request['post_id'], 'timing_light_control', $control );
		}
		// else
		$control = get_post_meta( $request['post_id'], 'timing_light_control', true );
		return new WP_REST_Response( $control, 200 );
	}
}

class Toast_Agenda_Timing extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'agendatime/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		$timing = get_agenda_timing( $request['post_id'] );
		return new WP_REST_Response( $timing, 200 );
	}
}

class Toast_Manual_Lookup extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'type_to_manual/(?P<type>.+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		$type     = urldecode( $request['type'] );
		$options  = get_manuals_by_type_options( $type );
		$projects = '';
		$pa       = get_projects_array( 'options' );
		/*
		  echo '<br />';
		print_r($type);
		echo '<br />';
		print_r($pa);
		echo '<br />Options<br />';
		print_r($options);
		*/
		if ( $type == 'Other' ) {
			$manual = 'Other Manual or Non Manual Speech';
		} elseif ( $type == 'Manual' ) {
			$manual = 'COMPETENT COMMUNICATION';
		} elseif ( $type == 'Pathways 360' ) {
			$manual = 'Pathways 360 Level 5 Demonstrating Expertise';
		} elseif ( $type == 'Pathways Mentor Program' ) {
			$manual = 'Pathways Mentor Program Level 1 Educational Program';
		} else {
			$manual = $type . ' Level 1 Mastering Fundamentals';
		}
		if ( strpos( $manual, 'ways 360' ) ) {
			$projects = '<option value="Pathways 360 Level 5 Demonstrating Expertise 99">Pathways 360° Evaluation</option>';
		} else {
			$projects = '<option value="">Select Project</option>' . $pa[ $manual ];
		}
		return new WP_REST_Response(
			array(
				'list'     => $options,
				'projects' => $projects,
			),
			200
		);
	}
}

class Editor_Assign extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'editor_assign';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) && is_user_logged_in() && current_user_can( 'edit_signups' ) );
	}

	public function handle( $request ) {
		global $wpdb, $current_user;
		$post_id   = (int) $_POST['post_id'];
		$user_id   = (int) $_POST['user_id'];
		$role      = sanitize_text_field( $_POST['role'] );
		$editor_id = ( empty( $_POST['editor_id'] ) ) ? $current_user->ID : (int) $_POST['editor_id'];
		$timestamp = get_rsvp_date( $post_id );
		$was       = (int) get_post_meta( $post_id, $role, true );
		do_action('toastmasters_agenda_change',$post_id,$role,$user_id,$was,$editor_id);
		update_post_meta( $post_id, $role, $user_id );
		if ( strpos( $role, 'Speaker' ) ) {
			delete_post_meta( $post_id, '_manual' . $role );
			delete_post_meta( $post_id, '_project' . $role );
			delete_post_meta( $post_id, '_title' . $role );
			delete_post_meta( $post_id, '_intro' . $role );
		}
		$name   = get_member_name( $user_id );
		$status = sprintf( '%s assigned to %s', preg_replace( '/[\_0-9]/', ' ', $role ), $name );
		$log    = get_member_name( $editor_id ) . ' assigned ' . clean_role( $role ) . ' to ' . get_member_name( $user_id ) . ' for ' . $timestamp;
		if ( $was ) {
			$log .= ' (was: ' . get_member_name( $was ) . ')';
		}
		$log .= ' <small><em>(Posted: ' . rsvpmaker_date( 'm/d/y H:i' ) . ')</em></small>';

		add_post_meta( $post_id, '_activity_editor', $log );
		$type     = '';
		$manual   = '';
		$projects = '';
		$options  = '';
		if ( strpos( $role, 'peaker' ) ) {
			$track  = get_speaking_track( $user_id );
			$type   = $track['type'];
			$manual = $track['manual'];
			if ( ! empty( $manual ) && ! strpos( $manual, 'Manual' ) ) {
				update_post_meta( $post_id, '_manual' . $role, $manual );
			}
			$options  = sprintf( '<option value="%s">%s</option>', $track['manual'], $track['manual'] );
			$options .= get_manuals_by_type_options( $type );
			$projects = '<option value="">Select Project</option>' . $track['projects'];
		}
		return new WP_REST_Response(
			array(
				'status'   => $status,
				'name'   => $name,
				'type'     => $type,
				'list'     => $options,
				'projects' => $projects,
			),
			200
		);
	}
}

class TM_Role extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'tm_role';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() );
	}

	public function handle( $request ) {

		if(isset($_POST['suggest_note']))
			$response['content'] = wpt_suggest_role();
		elseif(isset($_POST['away_user_id']))
			$response['content'] = wpt_api_add_absence();
		else
			$response['content'] = toastmasters_role_signup();
		do_action('rsvpmaker_log_array',
		array('meta_key' => 'agenda_activity',
		'meta_value' => $response['content'],
		));		
		return new WP_REST_Response( $response, 200 );
	}
}

function wpt_api_add_absence() {
	$away_user_id = intval($_POST['away_user_id']);
	$post_id = intval($_POST['post_id']);
	add_post_meta( $post_id, 'tm_absence', $away_user_id );
	return get_member_name($away_user_id)." added to absences.";
}

function wpt_suggest_role() {
	global $current_user, $rsvp_options;
	$post_id = intval($_POST['post_id']);
	$roletag = sanitize_text_field($_POST['role']);
	$role = clean_role($roletag);
	$member_id = intval($_POST['user_id']);
	$member = get_userdata($member_id);
	$post_id = intval($_POST['post_id']);
	$t = get_rsvpmaker_timestamp( $post_id );
	$date = rsvpmaker_date($rsvp_options['short_date'],$t);
	$cleanrole = clean_role($_POST['role']);
	$nonce = get_post_meta($post_id,'oneclicknonce',true);
	if(empty($nonce)) {
		$nonce = wp_create_nonce('oneclick');
		update_post_meta($post_id,'oneclicknonce',$nonce);
	}
	$url = add_query_arg(array('oneclick' => $nonce,'role' => rawurlencode($role),'member' => $member_id,'by'=>$current_user->ID),get_permalink($post_id)).'#oneclick';
	$link = sprintf('<a href="%s" style="display:block; width: 150px; text-align: center; text-decoration: none; background-color: black; color: white; border: thin solid gray; font-weight:bold; font-size:large; padding: 5px; margin: 15px;">%s</a>', $url, __('Take Role','rsvpmaker-for-toastmasters') );
	$absence = add_query_arg(array('oneclick' => $nonce,'role' => 'absent','e' => '*|EMAIL|*','mode' => 'suggestall','by'=>$current_user->ID),get_permalink($post_id));
	$link .= '<p>Or let us know if you will not be able to attend.</p>'.sprintf('<a style="width: 150px; text-align: center; text-decoration: none; font-weight: bold; display: block; background-color: red; color: #FFFFFF; padding: 10px; margin: 15px;" href="%s#oneclick">Will Not Attend</a>',$absence);
	$templates = get_rsvpmaker_notification_templates();
	$template = $templates['suggest'];
	$note = '';
	if(!empty($_POST['suggest_note'])){
		$note = wpautop(stripslashes($_POST['suggest_note']));
		$note = wp_kses_post($note);	
	}
	$mail['subject'] = str_replace('[rsvpdate]',$date,str_replace('[wptrole]',$cleanrole,$template['subject']));//$cleanrole,$date);
	$mail['html'] = wpautop(str_replace('[custom_message]',$note,$template['body']));//$cleanrole,$date);
	$mail['html'] = str_replace('[oneclicklink]',$link,$mail['html']);
	$mail['fromname'] = $current_user->display_name;
	$mail['from'] = $current_user->user_email;
	$mail['to'] = $member->user_email;
	$mail['override'] = 1;//works with rsvpmailer override on toastmost
	if(2 != (int) $_POST['ccme'])
		rsvpmailer($mail);
	$msg = $mail['html'];
	if(!empty($_POST['ccme']))
	{
		$mail['to'] = $current_user->user_email;
		$mail['subject'] = '(For '.$member->user_email.') '.$mail['subject'];
		if(!empty($member->mobile_phone)) {
			$mail['html'] .= "\n" . sprintf('<p><br><br>Mobile: <a href="tel:%s">%s</p>',$member->mobile_phone,$member->mobile_phone);
			$mail['html'] .= sprintf("<p>Text message version<br><br></p><p>Nominating you for %s on %s<br>To accept %s<br>(no password required)<br><br></p>",$cleanrole, $date, $url);
		}
		if(!empty($member->home_phone)) {
			$mail['html'] .= "\n" . sprintf('<p>Home: <a href="tel:%s">%s</p>',$member->home_phone,$member->home_phone);
		}
		if(!empty($member->work_phone)) {
			$mail['html'] .= "\n" . sprintf('<p>Work: <a href="tel:%s">%s</p>',$member->work_phone,$member->work_phone);
		}
		$mail['html'] .= (1 == (int) $_POST['ccme']) ? '<p>'.__('Sent to member','rsvpmaker-for_toastmasters').'</p>' : '<p>'.__('Sent ONLY to you','rsvpmaker-for_toastmasters').'</p>';
		rsvpmailer($mail);
	}
	add_post_meta($post_id,'_suggest'.$roletag,$member_id);
	return '<p>From: '.$current_user->display_name.'<br>To: '.$member->display_name.'</p>'.$msg;
}

class WPTM_Reports extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'reports/(?P<report>.+)/(?P<user_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		global $wpdb;
		$report  = $request['report'];
		$user_id = $request['user_id'];
		$content = '';
		if ( $report == 'speeches_by_manual' ) {
			$content = speeches_by_manual( $user_id );
		} elseif ( $report == 'traditional_program' ) {
			$content = toastmasters_progress_report( $user_id );
		} elseif ( $report == 'traditional_advanced' ) {
			ob_start();
			if ( $user_id ) {
				$userdata = get_userdata( $user_id );
				toastmasters_advanced_user( $userdata, true );
			} else {
				echo 'Select member from the list above';
				echo toastmasters_advanced();
			}
			$content = ob_get_clean();
		} elseif ( $report == 'pathways' ) {
			ob_start();
			pathways_report( $user_id );
			$content = ob_get_clean();
		}
		return new WP_REST_Response(
			array(
				'report'  => $report,
				'content' => $content,
			),
			200
		);
	}
}

class WPTM_Dues extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'dues';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		$nonce = sanitize_text_field($_POST['tmn']);
		return ( wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) && is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		global $wpdb, $current_user;
		$confirmation = array();
		$paidkey      = sanitize_text_field($_POST['paidkey']);
		$norenew      = sanitize_text_field($_POST['norenew']);
		$member_id = intval($_POST['member_id']);
		$blog_id = intval($_POST['blog_id']);
		$paidkey = "TIpayment_".get_current_blog_id()."_".$_POST['until'];
		$until_key = "paid_until_".get_current_blog_id();
		$paid_to_ti = (empty($_POST['paid_to_ti'])) ? 0 : sanitize_text_field($_POST['paid_to_ti']);
		if ( isset( $_POST['markpaid'] ) && ('1' == $_POST['markpaid']) ) {
			$until = sanitize_text_field($_POST['until']);
			update_user_meta( $member_id, $until_key, $until );
			delete_user_meta( $member_id, $norenew );
			$confirmation['marked_paid'] = 'Marked paid until ' . $until;
		}
		if($paid_to_ti) {
			update_user_meta($member_id,$paidkey,$paid_to_ti);
			$confirmation['paid_to_ti'] = "$member_id $paidkey $paid_to_ti";
		}

		if ( isset( $_POST['updatevoid'] ) && is_numeric( $_POST['updatevoid'] ) ) {
			$member_id = (int) $_POST['updatevoid'];
			delete_user_meta( $member_id, $ti_paid_key );
			delete_user_meta( $member_id, $paidkey );
			delete_user_meta( $member_id, $norenew );
			$confirmation['paid_ti'] = 'Voided ';
		}

		if ( isset( $_POST['no'] ) ) {
			foreach ( $_POST['no'] as $member_id => $until ) {
				$member_id = (int) $member_id;
				$until = sanitize_text_field($until);
				update_user_meta( $member_id, $norenew, $until );
				$confirmation['no_renewal'] = 'Marked not planning to renew';
			}
		}

		if ( ! empty( $_POST['note'] ) ) {
			$member_id = sanitize_text_field($_POST['member_id']);
			$note      = '<strong>' . sanitize_textarea_field(stripslashes( $_POST['note'] )) . '</strong> (' . $current_user->display_name . ') ' . rsvpmaker_date( 'F j, Y' );
			$key       = sanitize_text_field($_POST['treasurer_note_key']);
			add_user_meta( $member_id, $key, $note );
			$confirmation['note'] = $note;
		}

		$confirmation['member_id'] = $member_id;
		return new WP_REST_Response( $confirmation, 200 );
	}
}

class WPTM_Money extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'money';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		$result = wpt_stripe_transactions();
		return new WP_REST_Response( $result, 200 );
	}
}

class WPTM_Reminders extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'duesreminders';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		$result['content'] = wpt_dues_reminders();
		return new WP_REST_Response( $result, 200 );
	}
}

class WPTM_Verify extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'verify/(?P<action>[a-z_]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$result['action'] = $request['action'];
		$result['result'] = get_transient( $request['action'] );
		return new WP_REST_Response( $result, 200 );
	}
}

class WPTM_Tweak_Times extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'tweak_times';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST,GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return is_user_logged_in();
	}

	public function handle( $request ) {
		global $wpdb, $current_user;

		if ( isset( $_GET['post_id'] ) ) {
			global $rsvp_options;
			$post  = get_post( (int) $_GET['post_id'] );
			if(!$post)
				return new WP_REST_Response( array('error' => 'no post found'), 200 );
			$time_format = str_replace( 'T', '', $rsvp_options['time_format'] );
			if ( rsvpmaker_is_template( $post->ID ) ) {
				$sked = get_template_sked( $post->ID );
				$date = '2030-01-01 ' . $sked['hour'] . ':' . $sked['minutes'];
			} else {
				$date = get_rsvp_date( $post->ID );
			}

			$ts_start   = rsvpmaker_strtotime( $date );
			$elapsed    = 0;
			$time_array = array();
			$pattern    = '|<!-- wp:wp4toastmasters/agendanoterich2[^>]+>(.+)<!-- /wp:wp4toastmasters/agendanoterich2 -->|sU';
			$pattern    = '/<p class="wp-block-wp4toastmasters-agendanoterich2">(.+)/';
			preg_match_all( $pattern, $post->post_content, $matches );
			$notes       = $matches[1];
			$output      = '';
			$lines       = explode( "\n", $post->post_content );
			$block_count = 0;
			$update      = false;
			$new         = '';
			foreach ( $lines as $index => $line ) {
				$pattern = '/{"role":[^}]+}/';
				preg_match( $pattern, $line, $match );
				if ( ! empty( $match[0] ) ) {
					$data[] = (array) json_decode( $match[0] );
				} elseif ( strpos( $line, '-- wp:wp4toastmasters/agendanoterich2' ) || strpos( $line, '-- wp:wp4toastmasters/agendaedit' ) ) {
					$pattern = '/{.+}/';
					preg_match( $pattern, $line, $match );
					if ( ! empty( $match[0] ) ) {
						$atts   = (array) json_decode( $match[0] );
						$data[] = $atts;
						// $block_count++;
					}
				}
				$new .= $line . "\n";
			}

			$block_count = 0;
			$output      = array();
			$rawdata     = wpt_blocks_to_data( $new );
			foreach ( $data as $d ) {
				$t               = $ts_start + ( $elapsed * 60 );
				$waselapsed      = $elapsed;
				$start_time_text = rsvpmaker_date( $time_format, $t );
				if ( ! $start_time_text ) {
					$start_time_text = rsvpmaker_date( 'h:i A', $t );
				}
				$start_time = $elapsed;

				$time_allowed = ( empty( $d['time_allowed'] ) ) ? 0 : (int) $d['time_allowed'];

				$padding_time = ( ! empty( $d['role'] ) && ( $d['role'] == 'Speaker' ) && ! empty( $d['padding_time'] ) ) ? (int) $d['padding_time'] : 0;

				$add = $time_allowed + $padding_time;

				$elapsed += $add;

				if ( ! empty( $d['role'] ) ) {
					  $start = ( empty( $d['start'] ) ) ? 1 : $d['start'];
					  $index = str_replace( ' ', '_', $d['role'] );
					  $label = $d['role'];
				} elseif ( ! empty( $d['uid'] ) ) {
					$start = 1;
					$label = $d['uid'];
					if ( strpos( $label, 'ote' ) ) {
						$note = array_shift( $notes );
						if ( $note ) {
							$label = trim( strip_tags( $note ) );
						}
					}
					if ( ! empty( $d['editable'] ) ) {
						$label = $d['editable'];
					}
				} else {
					continue;
				}
				$output[] = array(
					'label'   => $label,
					'time'    => $start_time_text,
					'elapsed' => $waselapsed,
					'add'     => $add,
				);
				$block_count++;
			}
			$t               = $ts_start + ( $elapsed * 60 );
			$start_time_text = rsvpmaker_date( $time_format, $t );
			$start_time_text = rsvpmaker_date( $time_format, $t );
			if ( ! $start_time_text ) {
				$start_time_text = rsvpmaker_date( 'h:i A', $t );
			}

			$output[] = array(
				'label'   => 'End',
				'time'    => $start_time_text,
				'elapsed' => $elapsed,
				'add'     => 0,
			);
			return new WP_REST_Response( $output, 200 );
		}
		// }

		$post_id     = (int) $_POST['post_id'];
		$post        = get_post( $post_id );
		$lines       = explode( "\n", $post->post_content );
		$block_count = 0;
		$update      = '';
		$log         = '';
		foreach ( $lines as $line ) {
			$pattern = '/{"role":[^}]+}/';
			preg_match( $pattern, $line, $match );
			if ( ! empty( $match[0] ) ) {
				$atts   = json_decode( $match[0] );
				$index  = str_replace( ' ', '_', $atts->role ) . '-';
				$index .= ( empty( $atts->start ) ) ? '1' : $atts->start;
				$log   .= $index . "\n";
				if ( isset( $_POST['remove'][ $index ] ) ) {
					$update .= "\n";
					$log .= "remove $index \n";
					continue;
				} else {
					$log               .= "update $index \n";
					$atts->time_allowed = sanitize_text_field($_POST['time_allowed'][ $index ]); // numeric string
					$atts->padding_time = sanitize_text_field($_POST['padding_time'][ $index ]);
					$atts->count        = (int) $_POST['count'][ $index ];
				}
				$line = preg_replace( $pattern, json_encode( $atts ), $line );
			} elseif ( strpos( $line, '-- wp:wp4toastmasters/agendanoterich2' ) || strpos( $line, '-- wp:wp4toastmasters/agendaedit' ) ) {
				// if(!is_numeric(trim($_POST['time_allowed'][$block_count])))
				// return new WP_REST_Response(array('error' => 'non-numeric data'), 200);
				$pattern = '/{.+}/';
				preg_match( $pattern, $line, $match );
				if ( ! empty( $match[0] ) ) {
					$atts  = json_decode( $match[0] );
					$index = str_replace( '.', '_', $atts->uid );
					$log  .= "$index \n";
					if ( isset( $_POST['remove'][ $index ] ) ) {
						$log    .= "remove $index \n";
						$update .= "\n";
						if ( ! strpos( $line, 'editable' ) ) {
							foreach ( $lines as $line ) {
								if ( strpos( $line, 'wp:wp4toastmasters' ) ) {
									break;// eat up lines until close
								}
							}
							continue;
						}
					} else {
						$log .= "update $index \n";
						if ( isset( $atts->editable ) ) {
							  $labels[ $atts->uid ] = $atts->editable;
						}
						$atts->time_allowed = sanitize_text_field($_POST['time_allowed'][ $index ]);
						$line               = preg_replace( $pattern, json_encode( $atts ), $line );
					}
				}
			}
			$log    .= "line: $line\n";
			$update .= $line . "\n";
		}
		$edits = array();
		if ( isset( $_POST['edits'] ) ) {
			foreach ( $_POST['edits'] as $index ) {
				$index = sanitize_text_field($index);
				$note  = stripslashes( $_POST[ $index ] );
				$note  = preg_replace( '/(style=("|\Z)(.*?)("|\Z))/', '', $note );
				$note  = wp_filter_post_kses( $note );
				$index = str_replace( '_', '.', $index );
				update_post_meta( $post_id, 'agenda_note_' . $index, $note );
				$edits[] = $labels[ $index ];
			}
		}
		$up['ID']           = $post->ID;
		$up['post_content'] = $update;
		$response['return'] = wp_update_post( $up );
		$response['blocks'] = $block_count;
		$response['next']   = sprintf(
			'<p><a href="%s" target="_blank">View Agenda</a></p>',
			add_query_arg(
				array(
					'print_agenda' => 1,
					'no_print'     => 1,
				),
				get_permalink( $post->ID )
			)
		);
		$response['next']  .= sprintf( '<p><a href="%s">Signup</a></p>', get_permalink( $post->ID ) );
		$response['edits']  = $edits;
		if ( current_user_can( 'edit_post', $post ) ) {
			$edit              = get_edit_post_link( $post->ID );
			$response['next'] .= sprintf( '<p><a href="%s">Edit Event</a></p>', $edit );
		}
		if ( rsvpmaker_is_template( $post->ID ) ) {
			$response['next'] .= sprintf( '<p><a href="%s">Create/Update</a> events from tempate</p>', admin_url( 'edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=' . $post->ID ) );
		}
		rsvpmaker_fix_timezone();
		$response['next'] .= sprintf( '<p>Updated: %s</p>', rsvpmaker_date( 'r' ) );
		$response['note']  = $note;
		$response['log']   = $log;
		return new WP_REST_Response( $response, 200 );
	}
}

class WPTM_Regular_Voting extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'regularvoting/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$output = wptm_count_votes($request['post_id']);
		do_action('rsvpmaker_log_array',
	array('meta_key' => 'voting',
	'meta_value' => $output,
    ));

		return new WP_REST_Response( $output, 200 );
	}
}

class WPTM_Reorder extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'reorder';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$post_id = (int) $_POST['post_id'];
		if ( ! $post_id ) {
			die( 'Post ID not set' );
		}
		$test = '';
		foreach ( $_POST as $name => $value ) {
			if ( is_array( $value ) ) {
				if ( $name == '_role_Speaker' ) {
					// print_r($value);
					$neworder = array();
					foreach ( $value as $assigned ) {
							$neworder[] = get_speaker_array( sanitize_text_field($assigned), $post_id );
					}
					foreach ( $neworder as $index => $speaker ) {
						save_speaker_array( $speaker, $index + 1, $post_id );
						$assigned = $speaker['ID'];
						if ( empty( $assigned ) ) {
							$assigned = '?';
						} elseif ( is_numeric( $assigned ) ) {
							$assigned_member = get_userdata( $assigned );
							$assignee        = $assigned_member->first_name . ' ' . $assigned_member->last_name;
						} else {
							$assignee = $assigned;
						}
						$test .= ', ' . ( $index + 1 ) . ': ' . $assignee;
					}
				} else {
					foreach ( $value as $index => $assigned ) {
						if ( empty( $assigned ) ) {
							$assigned = '?';
						} elseif ( is_numeric( $assigned ) ) {
							$assigned_member = get_userdata( $assigned );
							$assignee        = $assigned_member->first_name . ' ' . $assigned_member->last_name;
						} else {
							$assignee = $assigned;
						}
						update_post_meta( $post_id, $name . '_' . ( $index + 1 ), $assigned );
						$test .= ', ' . ( $index + 1 ) . ': ' . $assignee;
					}
				}
			}
		}
		$output = 'Saved. <a href="' . get_permalink( $post_id ) . '">Verify updated order</a>';
		return new WP_REST_Response( $output, 200 );
	}
}

class Editable_Note extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'editable_note_update';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) && is_user_logged_in() && current_user_can( 'edit_signups' ) );
	}

	public function handle( $request ) {
		global $wpdb, $current_user;
		$post_id   = (int) $_POST['post_id'];
		$note      = wp_kses_post( stripslashes($_POST['agenda_note'][0]) );
		$note = preg_replace('/style=[\'"][^"]+[\'"]/','', $note); //strip inline style
		$note = preg_replace('/h[0-9][^>]*>/','p>', $note); //no headings
		$label = sanitize_text_field( $_POST['agenda_note_label'][0] );
		$result = update_post_meta($post_id,$label,$note);
		$message = '<p style="border: medium solid green; padding: 5px;">Updated. <a href="'.get_permalink($post_id).'">Reload the page</a> if you need to make further revisions.</p>';
		return new WP_REST_Response($message,200);
	}
}

class Editable_Note_Json extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'editable_note_json';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST,GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;// (!empty($_POST)) ? is_club_member() : true;
	}

	public function handle( $request ) {
		global $wpdb, $current_user;
		if(isset($_GET['post_id']) && isset($_GET['uid'])) {
			$post_id = intval($_GET['post_id']);
			$uid = sanitize_text_field($_GET['uid']);
			$note = get_post_meta($post_id,'agenda_note_'.$uid,true);
			return new WP_REST_Response(['post_id'=>$post_id,'uid'=>$uid,'note'=>$note],200);
		}
		else {
			$json = file_get_contents('php://input');
			$data = json_decode($json);
			$post_id = $data->post_id;
			$editable = $data->editable;
			if(current_user_can('edit_signups')) {
				$uid = $data->uid;
				$note = wp_kses_post($data->note);
				$note = preg_replace('/style=[\'"][^"]+[\'"]/','', $note); //strip inline style
				$note = preg_replace('/h[0-9][^>]*>/','p>', $note); //no headings
				update_post_meta($post_id,'agenda_note_'.$uid,$note);
				return new WP_REST_Response(['post_id'=>$post_id,'uid'=>$uid,'note'=>$note],200);
			}
			else 
				return new WP_REST_Response('failed permissions check user:'.$current_user->ID.' post '.$post->ID,200);
		}
	}
}

class WP4TBlocksData extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'blocks_data/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$agendadata = wpt_get_agendadata($request["post_id"]);
		return new WP_REST_Response($agendadata,
			200
		);
	}
}

function wpt_get_agendadata($post_id = 0) {
	if(!$post_id)
		return [];
	global $current_user,$post;
	wpt_mobile_user_check();
	$agendadata = [];
	$post = false;
	$meetings = future_toastmaster_meetings( 10 );
	$templates = rsvpmaker_get_templates();
	if($meetings)
		$meetings = [];
	$agendadata['current_user_id'] = ($current_user->ID && (is_club_member($current_user->ID)) || current_user_can('manage_network')) ? $current_user->ID : false;
	$agendadata['is_user_logged_in'] = is_user_logged_in(); // true for logged in users who are not members
	$agendadata['current_user_name'] = ($current_user->ID) ? get_member_name($current_user->ID) : '';
	$agendadata['newSignupDefault'] = (bool) get_option('wp4t_newSignupDefault');
	$agendadata['admin_url'] = admin_url();
	$agendadata['second_language_feedback'] = boolval(get_user_meta($current_user->ID,'second_language_feedback',true));
	$agendadata['upcoming'] = [];
	if($post_id) {
		$post = get_post($post_id);
	}
	elseif(sizeof($meetings)) {
			$post = $meetings[0];
			$post_id = $post->ID;
		}
	else {
		$post = array_shift($templates);
		$post_id = $post->ID;
	}

	$agendadata['postdata'] = var_export($post,true);
	$absences = get_post_meta( $post_id, 'tm_absence' );
	if ( is_array( $absences ) ) {
		$absences = array_unique( $absences );
	}
	else 
		$absences = [];
	$agendadata['absences'] = [];
	foreach($absences as $ab) {
		$agendadata['absences'][] = array('ID' => $ab, 'name' => get_member_name($ab));
	}
		$r       = get_role( 'subscriber' );
		$agendadata['subscribers_can_edit_signups'] = $r->has_cap( 'edit_signups' );
		$agendadata['subscribers_can_organize_agenda'] = $r->has_cap( 'organize_agenda' );

		$agendadata['permissionsurl'] = admin_url('options-general.php?page=wp4toastmasters_settings&rules=1#rules');
		$agendadata['wpt_rest'] = wpt_rest_array();
		$agendadata['post_id'] = $post_id;
		$agendadata['editor'] = admin_url('post.php?action=edit&post='.$post_id);
		$agendadata['request_evaluation'] = ($current_user->ID && wpt_user_is_speaker($current_user->ID,$post_id) ) ? add_query_arg('evalme',$current_user->ID,get_permalink()) : admin_url('admin.php?page=wp4t_evaluations&speaker='.$current_user->ID);
		if($meetings) {
			foreach($meetings as $meeting)
			$agendadata['upcoming'][]= array('value' => $meeting->ID, 'permalink' => get_permalink($meeting->ID),'edit_link' => admin_url('wp-admin/post.php?post='.$meeting->ID.'&action=edit'),'label' => preg_replace('/ [0-9]{2}:[0-9]{2}:[0-9]{2}/','',$meeting->datetime) .' '.$meeting->post_title);
		}
		if(current_user_can('edit_rsvpmakers'))
		{
			foreach($templates as $template) {
				$agendadata['upcoming'][]= array('value' => $template->ID, 'permalink' => get_permalink($template->ID),'edit_link' => admin_url('wp-admin/post.php?post='.$template->ID.'&action=edit'),'label' => 'Template: '.$template->post_title);
				$tids[] = $template->ID;
			}
		}
		if(isset($_GET['mode']) && ('evaluation_demo' == $_GET['mode'] ))
			{
				$agendadata['post_id'] = 0;
				$blocksdata = parse_blocks('<!-- wp:wp4toastmasters/role {"role":"Speaker"} /-->');
			}
		elseif(isset($_GET['admin']) && ('true' == $_GET['admin'] ))
			{
				$default_template_id = get_option( 'default_toastmasters_template' );
				$index = array_search($default_template_id,$tids);
				if($index !== false)
					$template = $templates[$index];
				else {
					$template = $templates[0];
				}
				$agendadata['post_id'] = $post_id = $template->ID;
				$blocksdata = parse_blocks($template->post_content);
			}
		else
			$blocksdata = parse_blocks($post->post_content);
	
		$agendadata['has_template'] = rsvpmaker_has_template($post_id);
		$agendadata['is_template'] = rsvpmaker_is_template($post_id);
			
		if($agendadata['is_template'])
		{
			$agendadata['datetime'] = '1924-10-22 '.$agendadata['is_template']['hour'].':'.$agendadata['is_template']['minutes'].':00';
			$agendadata['agenda_preview'] = get_permalink($post_id).'?print_agenda=1&no_print=1&mode=reorg_admin';
		}
		else {
			$agendadata['datetime'] = get_rsvp_date($post_id);
		}
		$agendadata['permissions'] = array('member' => is_club_member(), 'edit_post' => current_user_can('edit_post',$post_id),'edit_signups' => current_user_can('edit_signups'),'organize_agenda'=>current_user_can('organize_agenda'),'manage_options' => current_user_can('manage_options'));
		$agendadata['allmembers'] = awe_rest_user_options('',$post_id);
	
		//filter empty blocks
		foreach($blocksdata as $block)
		{
			if(!empty($block["blockName"]))
				$agendadata['blocksdata'][] = $block; 
		}
		if(!empty($agendadata['blocksdata']))
		foreach($agendadata['blocksdata'] as $index => $block) {
			if('wp4toastmasters/agendaedit' == $block['blockName'] && !empty($block['attrs']['uid']))
				$agendadata['blocksdata'][$index]['edithtml'] = get_post_meta($post_id,'agenda_note_'.$block['attrs']['uid'],true);
			if(!empty($block['attrs']['custom_role']))
				$agendadata['blocksdata'][$index]['attrs']['role'] = $block['attrs']['custom_role'];
			$agendadata['blocksdata'][$index]['DnDid'] = 'dnd'.$index;
			if(isset($block['attrs']) && isset($block['attrs']['role']))
				{
					$agendadata['blocksdata'][$index]['memberoptions'] = awe_rest_user_options($block['attrs']['role'],$post_id);
					$agendadata['blocksdata'][$index]['assignments'] = [];
					$role = (!empty($block['attrs']['custom_role'])) ? $block['attrs']['custom_role'] : $block['attrs']['role'];
					$count = isset($block['attrs']['count']) ? $block['attrs']['count'] : 1;
					if('Speaker' == $role)
						pack_speakers($count,$agendadata['post_id']);
					$start = (isset($lastcount[$role])) ? $lastcount[$role] + 1 : 1;
					$agendadata['blocksdata'][$index]['attrs']['start'] = $start;
					$lastcount[$role] = (empty($lastcount[$role])) ? $count : + $count + $lastcount[$role];
					$backup = !empty($block['attrs']['backup']) ? 1 : 0;
					$blanks = array();
					for($i=$start; $i < ($count + $start); $i++)
					{
						$key = wp4t_fieldbase($role,$i);
						$assignment = array('post_id'=>$post_id);
						$assignment['ID'] = get_post_meta($post_id,$key, true);
						if(empty($assignment['ID'])) {
							$assignment['name'] = '';
						}
						elseif(is_numeric($assignment['ID']))
							$assignment['name'] = get_member_name($assignment['ID']);
						else
							$assignment['name'] = $assignment['ID'].' (guest)';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = get_speaker_array_by_field($key,$assignment['ID'],$agendadata['post_id']);
							$project_key = ($speakerdata['project']) ? $speakerdata['project'] : '';
							$speakerdata['evaluation_link'] = evaluation_form_url( $assignment['ID'], $post_id );//add_query_arg('evalme',$current_user->ID,get_permalink())
							$assignment = array_merge($assignment,$speakerdata);
						}
						if(isset($_GET['mode']) && 'reorg_admin' == $_GET['mode']) {
							if(!isset($democharacters)) {
								$democharacters = array('George Washington','John Adams','Thomas Jefferson','James Madison','James Monroe','John Quincy Adams','Andrew Jackson','Martin Van Buren','William Henry Harrison','John Tyler','James K. Polk','Zachary Taylor','Millard Fillmore','Franklin Pierce','James Buchanan','Abraham Lincoln');
								$demotitles = array('Immigration history in America','Society and life in the Dark Ages','The mystery of Leonardo DaVinci\'s Mona Lisa painting','Burial practices in ancient cultures and societies','Sculpture in the Renaissance','Fashion in Victorian Britain','The assassination of John FKennedy','Colonization and its impact on the European powers in the Age of Exploration and beyond','The Olympics in Ancient Greece','Explore the history of tattoos and body art','The  Spanish Flu','Innovations that came out of the great wars','Japanese Kamikaze fighters during World War II','Rum running during Prohibition','Mahatma Gandhi and Indian apartheid');
							}
							$assignment['ID'] = 999999999999 + sizeof($democharacters);
							$assignment['name'] = array_pop($democharacters);
							if('Speaker' == $role) {
								$assignment['manual'] = 'Dynamic Demos';
								$assignment['project'] = 'Dynamic Demos 123';
								$assignment['project_text'] = 'Dynamic Demos to Fill the Agenda';
								$assignment['title'] = array_pop($demotitles);
								$assignment['maxtime'] = 7;
							}

						}

						if(empty($assignment['ID']))
							$blanks[] = $i - 1;
						$agendadata['blocksdata'][$index]['assignments'][] = $assignment;
					}
					if($backup) {
						$key = wp4t_fieldbase('Backup '.$role,$start);
						$assignment = array();
						$assignment['ID'] = intval( get_post_meta($agendadata['post_id'],$key, true) );
						$assignment['name'] = ($assignment['ID']) ? get_member_name($assignment['ID']) : '';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = get_speaker_array_by_field($key,$assignment['ID'],$agendadata['post_id']);
							$assignment = array_merge($assignment,$speakerdata);
						}
					$agendadata['blocksdata'][$index]['assignments'][] = $assignment;
					}
				}
		}
	
	return $agendadata;
}

class WP4TRolesList extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'roles_list';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		global $toast_roles;
		$toast[] = array('value' =>'', 'label' => __('Select Role','rsvpmaker-for-toastmasters'));
		$toast[] = array('value' =>'custom', 'label' => __('Custom Role','rsvpmaker-for-toastmasters'));
		foreach($toast_roles as $key => $value)
			$toast[] = array('value' => $key, 'label' => $value);		
		return new WP_REST_Response($toast,
			200
		);
	}
}

//get_manuals_by_type()

class WP4TUpdateRole extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'update_role';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$post_id = $data->post_id;
		$role = $data->role;
		$keybase = wp4t_fieldbase($role).'_';
		$updated['status'] = 'updated';
		foreach($data->assignments as $index => $item) {
			//foreach($assignment as $item) {
				$item = (array) $item;
				foreach($item as $type => $value) {
					if(empty($type) || ('name' == $type))
						continue;
					elseif('ID' == $type)
						$key = $keybase.($index+1);
					else
						$key = '_role_'.$type.$keybase.($index+1);
					update_post_meta($post_id,$key,$value);
					$updated['status'] .= ' '.$key.' = '.$value;	
			}
			do_action('rsvpmaker_log_array',
			array('meta_key' => 'update_role',
			'meta_value' => $updated,
			));					//}
		}
		return new WP_REST_Response($updated,
			200
		);
	}
}

class WP4TUpdateAgenda extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'update_agenda';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return (current_user_can('edit_rsvpmakers') || current_user_can('organize_agenda')); //or allowed to reorganize
	}

	public function handle( $request ) {
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$output = '';
		$post_id = $data->post_id;
		$post_type = get_post_type($post_id);
		if(('rsvpmaker' != $post_type) && ('rsvpmaker_template' != $post_type))
			return new WP_REST_Response(['status'=>'This function only works with event content'],401);
		if('rsvpmaker_template' != $post_type) {
			if(!current_user_can('edit_post',$post_id) && !current_user_can('organize_agenda'))
				return new WP_REST_Response(['status'=>'user is not allowed to update this document'],401);
		}
		foreach($data->blocksdata as $index => $block) {
			if($block->blockName)
				$output .= jsonBlockDataOutput($block, $post_id);
		}
		$updated['ID'] = $post_id;
		$updated['post_content'] = $output;
		$upid = wp_update_post($updated);
		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = "update agenda ".$upid;
		if(!empty($data->copyToTemplate)) {
			$updated['ID'] = $data->has_template;
			$updated['post_content'] = $output;
			wp_update_post($updated);
			$related = get_events_by_template($data->has_template);
			$agendadata['status'] .= " + template update";
			$related = get_events_by_template($data->has_template);
			foreach($related as $post_to_update) {
				if($post_id == $post_to_update->ID)
					continue;
				$updated['ID'] = $post_to_update->ID;
				$updated['post_content'] = $output;
				wp_update_post($updated);	
				$agendadata['status'] .= " + ".$post_to_update->ID;
			}
		}
	do_action('rsvpmaker_log_array',
	array('meta_key' => 'update_agenda',
	'meta_value' => $agendadata,
    ));

		return new WP_REST_Response($agendadata,
			200
		);
	}
}

class WP4T_Paths_and_Projects extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'paths_and_projects';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$manuals_by_type = get_manuals_by_type();
		$projects = get_projects_array();
		$program['maxtime'] = get_projects_array('times');
		$program['display_time'] = get_projects_array('display_times');
		foreach($manuals_by_type as $pathkey => $marray) {
			$program['paths'][] = array('label' => $pathkey,'value' => $pathkey);
			$program['manuals'][$pathkey][] = array('label' => 'Choose a Level', 'value' => '');
			foreach($marray as $mkey => $manual) {
				$program['manuals'][$pathkey][] = array('label' => $mkey, 'value' => $manual);
				$program['projects'][$manual][] = array('label' => 'Choose a Project', 'value' => '');
				$manuals[] = $manual;
			}
		}
		$program['manuals']['Other'][] = array('label' => 'Other','value' => 'Other');
		foreach($projects as $key => $project) {
			$manual = preg_replace('/([\s0-9]+)$/','',$key);
			if(in_array($manual,$manuals))
				$program['projects'][$manual][] = array('label' => $project, 'value' => $key);
			else
				$program['projects']['Other'][] = array('label' => $project, 'value' => $key);
		}

		return new WP_REST_Response($program,200);
	}
}

class WP4T_Members_for_Role extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'members_for_role/(?P<role>[a-zA-Z_]+)/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$options = awe_rest_user_options( clean_role($request['role']), $request['post_id'] );
		return new WP_REST_Response($options,200);
	}
}

class WptJsonAssignmentPost extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_assignment_post';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return (is_user_logged_in() || wpt_mobile_user_check());
	}

	public function handle( $request ) {
		global $current_user;
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$post_id = $data->post_id;
		$blockindex = $data->blockindex;
		$roleindex = $data->roleindex;
		$user_id = $data->ID;
		$role = $data->role;
		$start = $data->start;
		$count = $data->count;
		if($count == $roleindex) {
			$role = 'Backup '.$role;
			$roleindex = 0;
		}
		$name = get_member_name($user_id);
		$keybase = wp4t_fieldbase($role).'_';
		$updated = $item = (array) $data;
		$status = 'updated post id '.$post_id.' count: '.$count;
		$updated['name'] = $name;
		$control = ['role','blockindex','roleindex','name','post_id','start','count'];
		foreach($item as $type => $value) {
			if($type == "ID")
			$status .= ' item '.var_export($item,true).' '; 
			if(empty($type) || in_array($type,$control))
				continue;
			elseif('ID' == $type)
				$key = $keybase.($roleindex+$start);
			else
				$key = '_'.$type.$keybase.($roleindex+$start);
			//$updated[$type] = $value;
			update_post_meta($post_id,$key,$value);
			$status .= ' '.$key.' = '.$value;
			$updated['status'] .= ' '.$key.' = '.$value;
	}

	$key = (isset($item["ID"]) && ($item["ID"] == $current_user->ID)) ? 'role sign up' : 'role assignment';
	do_action('rsvpmaker_log_array',
	array('meta_key' => $key,
	'meta_value' => $updated['status'],
	'user_id' => $current_user->ID,
    ));

		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = $status;
		$agendadata['prompt'] = ($user_id == $current_user->ID);
		$agendadata['role'] = $role;
		return new WP_REST_Response($agendadata,
			200
		);
	}
}

class WptJsonMultiAssignmentPost extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_multi_assignment_post';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$blockindex = $data->blockindex;
		$assignments = $data->assignments;
		$start = $data->start;
		$updated['status'] = 'updated ';
		$updated['assignments'] = [];
		foreach($assignments as $roleindex => $assignment) {
			$post_id = $assignment->post_id;
			$user_id = $assignment->ID;
			$role = $assignment->role;
			$count = $assignment->count;
			if($roleindex == $count) {
				$role = "Backup ".$role;
				$roleindex = 0;
			}
			$name = get_member_name($user_id);
			$keybase = wp4t_fieldbase($role).'_';
			$item = (array) $data;
			$item['name'] = $name;
			array_push($updated['assignments'],$item);
			$control = ['role','blockindex','roleindex','name','post_id','count'];
			$item = (array) $assignment;
			foreach($item as $type => $value) {
				if(empty($type) || in_array($type,$control))
					continue;
				elseif('ID' == $type)
					$key = $keybase.($roleindex+$start);
				else
					$key = '_'.$type.$keybase.($roleindex+$start);
				$updated[$roleindex][$type] = $value;
				update_post_meta($post_id,$key,$value);
				$updated['status'] .= ' ' .$post_id.' '.$key.' = '.$value;	
				$status .=  ' ' .$post_id.' '.$key.' = '.$value;	
		}
	
		}
		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = $status;

		return new WP_REST_Response($agendadata,
			200
		);
	}
}

class WP4T_Copy_Post extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_copy_post';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return current_user_can('edit_posts');
	}

	public function handle( $request ) {
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$post_id = json_decode($post_id);
		if(!current_user_can('edit_post',$data->copyfrom) || !current_user_can('edit_post',$data->copyto))
		return new WP_REST_Response('User lacks sufficient editing rights.',
			200
		);
		$copyfrom = get_post($data->copyfrom);
		$update = array('ID' => $data->copyto,'post_content'=>$copyfrom->post_content);
		wp_update_post($update);
		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = var_export($data,true);
		return new WP_REST_Response($agendadata,
			200
		);
	}
}

class WP4T_Permissions extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_agenda_permissions';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return current_user_can('manage_options');
	}

	public function handle( $request ) {
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		if('newSignupDefault' == $data->key) {
		update_option('wp4t_newSignupDefault',$data->value);
		$response['status'] = "$data->key ".(($data->value) ? 'true' : 'false');
		return new WP_REST_Response($response,
			200
		);
		}

		$change = ['subscriber','contributor','author'];
		foreach($change as $label) {
			$r = get_role( $label );
			if($data->value)
				$r->add_cap($data->key);
			else
				$r->remove_cap($data->key);
		}
		//update_option($data->key,$data->value);
		$response['status'] = "$data->key ".(($data->value) ? 'true' : 'false')." for ".implode(', ',$change);
		return new WP_REST_Response($response,
			200
		);
	}
}

class WP4T_Absences extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'absences';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;//return is_club_member();
	}

	public function handle( $request ) {
		global $rsvp_options;
		$response['absences'] = tm_absences_json();
		$future = future_toastmaster_meetings();
		$response['upcoming'][] = array('value'=>'','label'=>'Just this meeting');
		foreach($future as $f)
			$response['upcoming'][] = array('value'=>$f->datetime,'label'=>'until '.rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($f->datetime)));
		$response['memberlist'][] = array('value'=>'0','label'=>'Choose Member');
		$members = get_club_members();
		foreach($members as $m) {
			$response['memberlist'][] = array('value'=>$m->ID,'label'=>$m->display_name);
		}
		return new WP_REST_Response($response,
			200
		);
	}
}

class WP4T_Hybrid extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'hybrid';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$json = file_get_contents('php://input');
		$data = ($json) ? json_decode($json) : array();
		$response = tm_attend_in_person_json($data);
		return new WP_REST_Response($response,
			200
		);
	}
}

class WP4T_Evaluation extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'evaluation';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		global $wpdb, $rsvp_options;
		$json = file_get_contents('php://input');
		if(!empty($json))
		$data = json_decode($json);
		$speaker_id = (isset($_GET['speaker'])) ? intval($_GET['speaker']) : 0;
		if(!empty($data)) {
			global $current_user, $rsvp_options;
			$output = '';
			$speaker_id = $data->evaluate->ID;
			if(is_numeric($speaker_id))
				$speaker = get_userdata($speaker_id);
			if($speaker) {
				$mail['to'] = $speaker->user_email;
			}
			$name = sanitize_text_field($data->evaluate->name);
			$manual = sanitize_text_field($data->evaluate->manual);
			$project_text = ($data->evaluate->project) ? get_project_text($data->evaluate->project) : '';
			$title = sanitize_text_field($data->evaluate->title);
			$evaluator_name = (isset($current_user->display_name)) ? $current_user->display_name : sanitize_text_field($data->evaluator_name);
			$mail['subject'] = "Evaluation for ".$name.' '.$title;
			$output = sprintf("<h1>Evaluation for %s %s</h1>\n",$name,($title) ? "<em>$title</em>" : '');
			$output .= sprintf("<h2>Evaluator: %s</h2>\n",$evaluator_name);
			$output .= sprintf("<h2>Path: %s</h2>\n",$manual);
			$output .= sprintf("<h2>Project: %s</h2>\n",$project_text);
			$output .= sprintf("<p>Evaluator: %s</p>\n",$current_user->display_name);
			$output .= sprintf("<p>Date: %s</p>\n",rsvpmaker_date($rsvp_options['long_date'],time()));
			$sizeofprompts = sizeof($data->form->prompts);
			$sizeofresponses = sizeof($data->responses);
			$sizeofnotes = sizeof($data->notes);

			$prompts = ($sizeofprompts < $sizeofresponses || $sizeofprompts < $sizeofnotes) ? array_merge($data->form->prompts,$data->form->second_language) : $data->form->prompts;

			foreach($prompts as $index => $p) {
				$choice = empty($data->responses[$index]) ? '' : sanitize_text_field($data->responses[$index]);
				$output .= '<p><strong>'.sanitize_text_field($p->prompt).(($choice) ? ': <em>'.$choice.'</em>' : '')."</strong></p>\n";
				if($p->choices) {
					$output .= '<div style="display:flex;font-family: Arial, Helvetica, sans-serif;line-height:1em;">';
					foreach($p->choices as $option) {
						$output .= format_eval_opt($option->value,($choice == $option->value));
					}
					$output .= "</div>\n";
				}
				$note = empty($data->notes[$index]) ? '' : wpautop(sanitize_textarea_field($data->notes[$index]));
				$output .= '<div style="padding-left: 20px;">'.$note."</div>\n";
			}
			$response['message'] = $output;
			if(empty($current_user->user_email))
				$mail['from'] = (empty($data->evaluator_email) || !is_email($data->evaluator_email)) ? get_option('admin_email') : $data->evaluator_email;	
			else
				$mail['from'] = $current_user->user_email;
			$mail['html'] = $output;
			$mail['fromname'] = $current_user->display_name;
			if(!empty($mail['to'])) {
				rsvpmailer($mail);
				$project = (!empty($data->project)) ? $data->project : '';
				$eval_identify = empty($current_user->user_login) ? 'guest' : $current_user->user_login;
				$key = 'evaluation|' . date( 'Y-m-d' ) . ' 00:00:00|' . $project . '|' . sanitize_text_field($_SERVER['SERVER_NAME']) . '|' . $eval_identify;
				update_user_meta( $speaker_id, $key, $output );
				update_post_meta($data->post_id,'evaluation_given',$current_user->ID);
				update_post_meta($data->post_id,'evaluation_received',$speaker_id);
				$response['status'] = 'Sent by email. Copy saved to dashboard.';
			}
			else
				$response['status'] = 'Copy and paste to print or email';
			
			$response['message'] = '<div>'.$response['status']."</div>\n".$response['message'];

			do_action('rsvpmaker_log_array',
	array('meta_key' => 'evaluation',
	'meta_value' => $response,
    ));

			//process evaluation
			return new WP_REST_Response($response,
			200
		);
		}

		//get form
		$updated = (int) get_option( 'evaluation_forms_updated' );
		if ( empty( $updated ) || ( $updated < strtotime( 'February 25, 2023' ) ) ) {
			$json = file_get_contents( plugin_dir_path( __FILE__ ) . 'evaluation_forms.json' );
			if ( $json ) {
				$eval_data = json_decode( $json );
				foreach ( $eval_data as $eval_row ) {
					if ( isset( $eval_row->timestamp ) ) {
						update_option( 'evaluation_forms_updated', $eval_row->timestamp );
						$updated = $eval_row->timestamp;
					} elseif ( $eval_row->option_value ) {
						update_option( $eval_row->option_name, $eval_row->option_value );
					}
				}
			}
		}
	
		$project = 'Visionary Communication Level 5 Demonstrating Expertise 2278';
		$project = sanitize_text_field($_GET['project']);
		$form = null;
		if(!empty(trim($project)))
			$form    = fetch_evaluation_form( $project );
		if(empty($form) || empty($form->intro) ) {
			$response['project'] = 'Dynamic Leadership Level 1 Mastering Fundamentals 5';
			$form = fetch_evaluation_form( 'Dynamic Leadership Level 1 Mastering Fundamentals 5' );
			$response['intro'] = '<p>Showing a generic form because project not specified or not recognized.</p>';
		}
		else {
			$response['intro'] = (!empty($form->intro)) ? wpautop($form->intro) : '<p>Intro variables missing';
			$response['project'] = $project;
		}

		$response['timestamp'] = time();
		$prompts = explode("\n",$form->prompts);
		foreach($prompts as $index => $prompt) {
			$prompt = trim($prompt);
			$cells = explode('|',$prompt);
			$response['form'][$index]['prompt'] = array_shift($cells);
			// = $cells;
			$response['form'][$index]['choice'] = '';
			$response['form'][$index]['note'] = '';
			foreach($cells as $cell)
				$response['form'][$index]['choices'][] = array('label'=>$cell,'value'=>$cell);
		}

		$response['second_language_requested'] = ($speaker_id) ? get_user_meta($speaker_id,'second_language_feedback',true) : false;
		$response['second_language'][0]['prompt'] = 'Pace: not too fast or too slow';
		$response['second_language'][0]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][0]['note'] = ''; 
		$response['second_language'][0]['choice'] = ''; 
		$response['second_language'][1]['prompt'] = 'Grammar and word usage';
		$response['second_language'][1]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][1]['note'] = ''; 
		$response['second_language'][1]['choice'] = ''; 
		$response['second_language'][2]['prompt'] = 'Word tense, gender, and pronouns';
		$response['second_language'][2]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][2]['note'] = ''; 
		$response['second_language'][2]['choice'] = '';
		$response['second_language'][3]['prompt'] = 'Clear pronunciation';
		$response['second_language'][3]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][3]['note'] = ''; 
		$response['second_language'][3]['choice'] = ''; 

		$response['previous_speeches'] = [];
		$history_table = $wpdb->base_prefix.'tm_history';
		$speech_history_table = $wpdb->base_prefix.'tm_speech_history';	
		$userwhere = (isset($_GET['speaker'])) ? 'AND user_id='.intval($_GET['speaker']) : '';
		$sql = "SELECT user_id as ID, datetime, project_key as project, project as project_text, title, post_id FROM `$history_table` join $speech_history_table ON id=history_id WHERE `role` LIKE 'Speaker' AND `datetime` < NOW() AND `domain` LIKE '".sanitize_text_field($_SERVER['SERVER_NAME'])."' $userwhere order by datetime DESC LIMIT 0,15";
		$p = $wpdb->get_results($sql);
		foreach($p as $speech) {
			$speech->name = $label = get_member_name($speech->ID);
			if($speech->project_text)
				$label .= ' '.$speech->project_text;
			if($speech->title)
				$label .= ' '.$speech->title;
			$label .= ' '.rsvpmaker_date($rsvp_options['short_date'],rsvpmaker_strtotime($speech->datetime));
			$response['previous_speeches'][] = array('label' => $label,'value' => $speech);
		}

		return new WP_REST_Response($response,
			200
		);
		
	}
}

function format_eval_opt($opt,$is_true) {
	$parts = preg_split('/[\(\)]/',$opt);
	//width: 30px; height: 30px; 
	//$opt = '<span style="font-size:20px;"><strong>'.$parts[0].'</strong></span><br><span style="font-size:10px;">'.$parts[1].'</span>';
	$outer_style = 'display: inline; margin-right: 10px; border: thick solid #000; border-radius: 50%; text-align: center; padding: 10px; font-size: 30px;';
	$outer_style .= ($is_true) ? 'font-weight: bold; color: #fff; background-color: #000' : 'opacity: 0.5';
	return sprintf('<div class="%s" style="%s">%s</div>',($is_true) ? 'evalchoice' : '', $outer_style,$parts[0]);
}

class WP4T_Member_Evaluation extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'member_evaluation';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		global $wpdb, $rsvp_options;
		$member = intval($_GET['member']);
		$project = sanitize_text_field($_GET['project']);

		$response = array('member'=>$member,'project'=>$project);
			//process evaluation
			return new WP_REST_Response($response,
			200
		);
		
	}
}

class WP4T_User_Meta extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'user_meta';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		global $current_user;
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$response['status'] = '';
		if(isset($data->key) && isset($data->value) && isset($current_user->ID))
			{
				update_user_meta($current_user->ID,sanitize_text_field($data->key),sanitize_text_field($data->value));
				$response['status'] = $data->key.' updated';
			}

		return new WP_REST_Response($response,
			200
		);
	}
}

class WP4T_Timer_Image extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'timerimage';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return current_user_can('edit_posts') && ($_POST['timer_upload'] == get_post_meta(intval($_POST['post_id']),'timer_nonce',true));
	}

	public function handle( $request ) {
		$upload_dir = wp_upload_dir();
		//checks suggested by https://www.wordfence.com/learn/how-to-prevent-file-upload-vulnerabilities/
			$allowedMimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
			);
			$fileInfo = wp_check_filetype($_FILES["colorimage"]["name"],$allowedMimes);
			if (empty($fileInfo['ext']) || !$fileInfo['type']) {
				error_log('timer file upload error '.var_export($_FILES,true));
				wp_die('invalid file type');
			}
			$check = getimagesize($_FILES["colorimage"]["tmp_name"]);
			if($check !== false) {
			$color = sanitize_text_field($_POST['color']);
			//$response['nonce_result'] = wp_verify_nonce($_POST['_wpnonce'],'timer_upload');
			//$response['nonce'] = $_POST['_wpnonce'];
			$response['color'] = $color;
			$ext = pathinfo($_FILES["colorimage"]["name"],PATHINFO_EXTENSION);
			$filename = preg_replace('/[^A-Za-z0-9\.]+/','_',$_POST['slug']).'_'.$color.'_'.time().'.'.$ext;
			$response['file'] = $filename;
			$target_file = trailingslashit($upload_dir['path']) . $filename;
			$target_url = trailingslashit($upload_dir['url']) . $filename;
			$response['url'] = $target_url;
			move_uploaded_file($_FILES["colorimage"]["tmp_name"], $target_file);
			require_once ABSPATH . 'wp-admin/includes/image.php';
			$filetype = wp_check_filetype( basename( $target_file ), null );
			$attachment = array(
				'guid'           => $target_url,
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);
			$attach_id = wp_insert_attachment( $attachment, $target_file, 0 );

			// Generate the metadata for the attachment, and update the database record.
			$attach_data = wp_generate_attachment_metadata( $attach_id, $target_file );
			wp_update_attachment_metadata( $attach_id, $attach_data );
		
			} else {
			  $response['error'] = "File is not an image.";
			}
		return new WP_REST_Response($response,
			200
		);
	}
}

/*
skeleton
class WP4T_XX extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'xx';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		return new WP_REST_Response($response,
			200
		);
	}
}

{'prompt':'You excelled at','choices':[],'choice':'','note':''},{'prompt':'You may want to work on','choices':[],'choice':'','note':''},{'prompt':'To challenge yourself','choices':[],'choice':'','note':''},{'prompt':'Clarity: Spoken language is clear and is easily understood','choices':[{'label':'5 (Exemplary)','value':'5 (Exemplary)'},{'label':'4 (Excels)','value':'4 (Excels)'},{'label':'3 (Accomplished)','value':'3 (Accomplished)'},{'label':'2 (Emerging)','value':'2 (Emerging)'},{'label':'1 (Developing)','value':'1 (Developing)'}],'choice':'','note':''}
*/

add_action(
	'rest_api_init',
	function () {
		$toastnorole = new Toast_Norole_Controller();
		$toastnorole->register_routes();
		$order_controller = new WPTContest_Order_Controller();
		$order_controller->register_routes();
		$contest_sendlink = new WPTContest_Send_Link();
		$contest_sendlink->register_routes();
		$votecheck_controller = new WPTContest_VoteCheck();
		$votecheck_controller->register_routes();
		$gotvote_controller = new WPTContest_GotVote();
		$gotvote_controller->register_routes();
		$timer_controller = new WPT_Timer_Control();
		$timer_controller->register_routes();
		$manual = new Toast_Manual_Lookup();
		$manual->register_routes();
		$assign = new Editor_Assign();
		$assign->register_routes();
		$repo = new WPTM_Reports();
		$repo->register_routes();
		$dues = new WPTM_Dues();
		$dues->register_routes();
		$money = new WPTM_Money();
		$money->register_routes();
		$reminders = new WPTM_Reminders();
		$reminders->register_routes();
		$verify = new WPTM_Verify();
		$verify->register_routes();
		$role = new TM_Role();
		$role->register_routes();
		$tweak = new WPTM_Tweak_Times();
		$tweak->register_routes();
		$reg = new WPTM_Regular_Voting();
		$reg->register_routes();
		$reorder = new WPTM_Reorder();
		$reorder->register_routes();
		$editable = new Editable_Note();
		$editable->register_routes();
		$wptb = new WP4TBlocksData();
		$wptb->register_routes();
		$wpup = new WP4TUpdateRole();
		$wpup->register_routes();
		$tpp = new WP4T_Paths_and_Projects();
		$tpp->register_routes();
		$m4r = new WP4T_Members_for_Role();
		$m4r->register_routes();
		$upagenda = new WP4TUpdateAgenda();
		$upagenda->register_routes();
		$jsonass = new WptJsonAssignmentPost();
		$jsonass->register_routes();
		$multiass = new WptJsonMultiAssignmentPost();
		$multiass->register_routes();
		$enj = new Editable_Note_Json();
		$enj->register_routes();
		$rl = new WP4TRolesList();
		$rl->register_routes();
		$wptcopy = new WP4T_Copy_Post();
		$wptcopy->register_routes();
		$wptpermissions = new WP4T_Permissions();
		$wptpermissions->register_routes();
		$abs = new WP4T_Absences();
		$abs->register_routes();
		$hybrid = new WP4T_Hybrid();
		$hybrid->register_routes();
		$eval = new WP4T_Evaluation();
		$eval->register_routes();
		$meval = new WP4T_Member_Evaluation();
		$meval->register_routes();
		$umeta = new WP4T_User_Meta();
		$umeta->register_routes();
		$timerimage = new WP4T_Timer_Image();
		$timerimage->register_routes();
	}
);
