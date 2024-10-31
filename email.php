<?php
/*
Email routines
*/

add_action( 'wp4toast_reminders_cron', 'wp4toast_reminders_cron', 10, 1 );

function wp4toast_reminders_cron( $meeting_hours ) {
	wp_suspend_cache_addition(true);
	email_with_without_role( $meeting_hours );
	wp_suspend_cache_addition(false);
	return;
}

function wp4t_role($role) {
	global $toast_roles;
	if(empty($toast_roles))
		wp4t_role_array();
	return (isset($toast_roles[$role])) ? $toast_roles[$role] : $role;
}

function wpt_notification_from($post_id) {
/* have replies go to tod or vpe */
	$mail['fromname'] = get_bloginfo( 'name' );	
	$toastmaster = (int) get_post_meta( $post_id, '_Toastmaster_of_the_Day_1', true );
	$mail['tmid'] = $toastmaster;
	if ( $toastmaster )
		$tmdata       = get_userdata( $toastmaster );
	if(!empty($tmdata))
		$mail['from'] = $tmdata->user_email;
	else {
		$blog_id = get_current_blog_id();
		$officer_ids    = (is_multisite()) ? get_blog_option( $blog_id, 'wp4toastmasters_officer_ids' ) : get_option( 'wp4toastmasters_officer_ids' );
        $officer_titles = (is_multisite()) ? get_blog_option( $blog_id, 'wp4toastmasters_officer_titles' ) : get_option( 'wp4toastmasters_officer_titles' );
        if(is_array($officer_ids))
        {
            foreach($officer_titles as $index => $title) {
                    if(strpos($title,'Education') && !empty($officer_ids[$index]))
                        $vpe = get_userdata($officer_ids[$index]);
			}
		}
		if(!empty($vpe))
			$mail['from'] = $vpe->user_email;
		else
			$mail['from']     = get_option( 'admin_email' );
	}
	return $mail;
}

function email_with_without_role_test( $meeting_hours, $test = false ) {
	global $wpdb, $email_context, $post, $rsvp_options, $toast_roles;
	$waspost       = $post;
	$email_context = true;
	$output = '';
	if ( empty( $meeting_hours ) ) {
		$output .= 'empty meeting hours ';
		$meetings      = future_toastmaster_meetings( 1 );
		$next          = $meetings[0];
		$date          = $next->date;
		$meeting_hours = $next->ID . ':0';
		if ( $test ) {
			$meeting_hours .= time();
		}
	} elseif ( ! strpos( $meeting_hours, ':' ) ) {
		return;
	} else {
		$p    = explode( ':', $meeting_hours );
		$next = get_post( $p[0] );
	}
	if ( empty( $next ) ) {
		return;
	}
	$t      = (!empty($next->ts_start)) ? (int) $next->ts_start : get_rsvpmaker_timestamp( $next->ID );
	$date   = rsvpmaker_date( $rsvp_options['short_date'], $t );
	$output .= ' t = '.$t . ' date '.$date .' next '.var_export($next,true);
	return $output;
}

function email_with_without_role( $meeting_hours, $test = false ) {
	global $wpdb, $email_context, $post, $rsvp_options, $toast_roles;
	$waspost       = $post;
	$email_context = true;
	if ( empty( $meeting_hours ) ) {
		$meetings      = future_toastmaster_meetings( 1 );
		$next          = $meetings[0];
		$date          = $next->date;
		$meeting_hours = $next->ID . ':0';
		if ( $test ) {
			$meeting_hours .= time();
		}
	} elseif ( ! strpos( $meeting_hours, ':' ) ) {
		return;
	} else {
		$p    = explode( ':', $meeting_hours );
		$next = get_post( $p[0] );
	}
	if ( empty( $next ) ) {
		return;
	}
	$t      = (!empty($next->ts_start)) ? (int) $next->ts_start : get_rsvpmaker_timestamp( $next->ID );
	$date   = rsvpmaker_date( $rsvp_options['short_date'], $t );

	$post   = $next;
	if(!$test)
	{
		$dupkey = 'email_reminder_' . $meeting_hours;
		if ( get_post_meta( $post->ID, $dupkey, true ) ) {
			return; // don't do more than once
		}
		update_post_meta( $post->ID, $dupkey, true );
	}
	$members   = get_club_members();
	$templates = get_rsvpmaker_notification_templates();
	$permalink = get_permalink( $next->ID );
	$content   = do_shortcode( $templates['norole']['body'] );
	$absences  = get_absences_array( $next->ID );
	$summary = 	empty(get_option('wpt_notification_summary_off'));
	$reminders = array();
	$absent    = array();
	$norole    = array();
	foreach ( $members as $member ) {
		$sql                             = "SELECT * FROM `$wpdb->postmeta` where post_id=" . $next->ID . '  AND meta_value=' . $member->ID . " AND meta_key LIKE '_role%' ";
		$role_results                    = $wpdb->get_results( $sql );
		$roles                           = array();
		$reminder_details[ $member->ID ] = '';
        $reminder_body[ $member->ID ] = '';
        $reminder_subject[ $member->ID ] = '';
		if ( in_array( $member->ID, $absences ) ) {
			$absent[] = $member->user_email;
		} elseif ( $role_results ) {
			foreach ( $role_results as $index => $role_row ) {
				$role    = trim( preg_replace( '/[^A-Za-z]/', ' ', $role_row->meta_key ) );
				$rt = wp4t_role($role);
				if(sizeof($role_results) > 1)
					$reminder_body[$member->id] .= '<h1>'.$rt.'</h1>';
				$roles[] = $rt;
				if ( $role == 'Speaker' ) {
					$manual                           = get_post_meta( $next->ID, '_manual' . $role_row->meta_key, true );
					$title                            = get_post_meta( $next->ID, '_title' . $role_row->meta_key, true );
					$project_key                      = get_post_meta( $next->ID, '_project' . $role_row->meta_key, true );
					$project                          = ( $project_key ) ? get_project_text( $project_key ) : 'Please specify project';
					$intro                            = get_post_meta( $next->ID, '_intro' . $role_row->meta_key, true );
					$speaker_details = sprintf( '<p>Manual: %s<br />Project: %s<br />Title: %s<br />Intro: %s</p>', $manual, $project, $title, $intro );
                    $reminder_body[$member->id] .= str_replace('[wpt_speech_details]',$speaker_details,str_replace('[wptrole]',$rt,wpautop($templates['Speaker']['body'])));
                    $reminder_subject[ $member->ID ] .= str_replace('[wptrole]',$rt,$templates['Speaker']['subject']);
				}
                elseif(isset($templates[$role]['body'])) {
                    $reminder_body[$member->id] .= str_replace('[wptrole]',$rt,wpautop($templates[$role]['body']));
                    $reminder_subject[ $member->ID ] .= str_replace('[wptrole]',$rt,$templates[$role]['subject']);
                }
                else {
                    $reminder_body[$member->id] .= str_replace('[wptrole]',$rt,wpautop($templates['role_reminder']['body']));
                    $reminder_subject[ $member->ID ] .= str_replace('[wptrole]',$rt,$templates['role_reminder']['subject']);
                }
			}
			$reminders[ $member->ID ]      = $member->user_email;
            if(sizeof($roles) > 1) {
				// member has multiple roles
                $multirole = implode(', ',$roles);
                $reminder_subject[ $member->ID ] = str_replace('[wptrole]',$multirole,$templates['role_reminder']['subject']);
                //$reminder_body[ $member->ID ] = str_replace('[wptrole]',$multirole,$templates['role_reminder']['body']);
            } 
            if($summary && !strpos($reminder_body[$member->id],'[wpt_open_roles]') && !strpos($reminder_body[$member->id],'[wp4t_assigned_open] '))
                $reminder_body[$member->id] .= $content;
		} else {
			$norole[] = $member->user_email;
		}
	}

	$output = '';
	if(isset($_GET['debug']))
	$output = '<pre>'.var_export($toast_roles,true).'</pre>';
	$mail = wpt_notification_from($next->ID);
	foreach ( $reminders as $index => $email ) {
		$mail['to']      = ( $test ) ? $mail['from'] : $email;
		$testtext        = ( $test ) ? "<p>$email</p>" : '';
        $mail['html'] = str_replace('[wpt_open_roles]',$content,$reminder_body[$index]);
        $mail['html'] = str_replace('[rsvpdate]',$date,$mail['html']);
        $mail['html'] = str_replace('[rsvptitle]',$next->post_title,$mail['html']);
		$mail['html']    = wpt_email_agenda_wrapper(do_shortcode($mail['html']));
		$mail['subject'] = $reminder_subject[$index];
        $mail['subject'] = str_replace('[rsvpdate]',$date,$mail['subject']);
        $mail['subject'] = str_replace('[rsvptitle]',$next->post_title,$mail['subject']);
        $mail['subject'] = do_shortcode($mail['subject']);
		$role = array_shift($reminder_roles[ $index ]);
		if($test) {
			$output .= sprintf('<h3>Subject: %s</h3><p><strong>To:</strong> %s</p>%s',$mail['subject'],$mail['to'],$mail['html']);
		}
		else {
			$result          = rsvpmaker_qemail( $mail, array($mail['to']) );
			update_post_meta( $post->ID, 'reminder', $mail );	
		}
	}
	if(!empty($norole)) {
		$mail['html'] = wpt_email_agenda_wrapper("<p>".__("You're not yet signed up for a role",'rsvpmaker-for-toastmasters')."</p>\n" . $content);
		$mail['subject'] = 'Reminder: ' . $date . ' - ' . $next->post_title;
		if($test) {
			$output .= sprintf('<h2>Subject: %s</h3><p><strong>To:</strong> %s</p>%s',$mail['subject'],implode(', ',$norole),$mail['html']);
		}
		else {
			rsvpmaker_qemail($mail,$norole);
		}
	}
	if(!$test)
		update_post_meta( $post->ID, '_reminder_email', 'Role reminders ' . implode( ',', $reminders ) . ' prompt: ' . implode( ',', $norole ).rsvpmaker_date('r') );
	$post = $waspost;
	return $output;
}

function awemailer( $mail ) {

	global $rsvp_options;

	if ( strpos( $mail['to'], 'example.com' ) ) {
		return;
	}

	if ( get_option( 'wp4toastmasters_disable_email' ) ) {
			return false;
	}

	$result = rsvpmailer( $mail );
	return $result;
}

function rsvptoast_email( $postdata, $rsvp_html, $rsvp_text ) {
	if ( empty( $postdata['guests'] ) && empty( $postdata['ex'] ) ) {
		return;
	}

	global $wpdb;
	global $unsubscribed;
	global $current_user;
	$unsub = get_option( 'rsvpmail_unsubscribed' );

	if ( ! empty( $postdata['guests'] ) ) {
		// guests
		$sql    = 'SELECT email FROM `' . $wpdb->prefix . 'users_archive` WHERE `' . $wpdb->prefix . 'users_archive`.guest AND user_id=0 ORDER BY updated DESC'; // limit?
		$guests = $wpdb->get_results( $sql );
		if ( ! empty( $guests ) ) {
			printf( '<p>Sending to %s guests</p>', sizeof( $guests ) );
			foreach ( $guests as $guest ) {
				// printf('<div>Guest %s</div>',$guest->email);
				if ( is_array( $unsub ) && in_array( strtolower( $guest->email ), $unsub ) ) {
					$unsubscribed[] = $guest->email;
					continue;
				}
				$mail['to']       = $guest->email;
				$mail['from']     = ( isset( $_POST['user_email'] ) ) ? $current_user->user_email : sanitize_text_field($_POST['from_email']);
				$mail['fromname'] = sanitize_text_field(stripslashes( $_POST['from_name'] ));
				$mail['subject']  = sanitize_text_field(stripslashes( $_POST['subject'] ));
				$mail['html']     = rsvpmaker_personalize_email( $rsvp_html, $mail['to'], __( 'This message was sent to you as a guest of ', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$mail['text']     = rsvpmaker_personalize_email( $rsvp_text, $mail['to'], __( 'This message was sent to you as a guest of', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$result           = rsvpmailer( $mail );
			}
		} // end db lookup
	}

	if ( ! empty( $postdata['ex'] ) ) {
		// former members
		$exes = wpt_get_former_member_emails();
		if ( ! empty( $exes ) ) {
			printf( '<p>Sending to %s former members</p>', sizeof( $exes ) );
			foreach ( $exes as $ex ) {
				if ( is_array( $unsub ) && in_array( strtolower( $ex->email ), $unsub ) ) {
					$unsubscribed[] = $ex->email;
					continue;
				}
				$mail['to']       = $ex->email;
				$mail['from']     = ( isset( $_POST['user_email'] ) ) ? $current_user->user_email : sanitize_text_field($_POST['from_email']);
				$mail['fromname'] = sanitize_text_field(stripslashes( $_POST['from_name'] ));
				$mail['subject']  = sanitize_text_field(stripslashes( $_POST['subject'] ));
				$mail['html']     = rsvpmaker_personalize_email( $rsvp_html, $mail['to'], __( 'This message was sent to you as a guest of ', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$mail['text']     = rsvpmaker_personalize_email( $rsvp_text, $mail['to'], __( 'This message was sent to you as a guest of', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$result           = rsvpmailer( $mail );
			}
		} // end db lookup
	}
}

add_action( 'rsvpmaker_email_send_ui_submit', 'rsvptoast_email', 10, 3 );

function rsvptoast_email_ui() { ?><div><input type="checkbox" name="guests" value="1"> <?php _e( 'Guests', 'rsvpmaker' ); ?> </div>
<div><input type="checkbox" name="ex" value="1"> <?php _e( 'Former Members', 'rsvpmaker' ); ?> </div><?php }

add_action( 'rsvpmaker_email_send_ui_options', 'rsvptoast_email_ui' );

function toastmasters_rsvpmailer_rule( $content, $email, $message_type ) {
	if ( empty( $message_type ) ) {
		return;
	}
	$user = get_user_by( 'email', $email );
	if ( ! $user ) {
		return '';
	}
	if(get_user_meta($user->ID,'tm_privacy_prompt',true) == '2')
		return 'deny';
	return get_user_meta( $user->ID, 'email_rule_' . $message_type, true );
}

add_filter( 'rsvpmailer_rule', 'toastmasters_rsvpmailer_rule', 10, 3 );

function wp4t_intro_notification( $post_id, $actiontext, $user_id, $field = '', $actiontype = '' ) {
	global $rsvp_options;

	if ( $actiontype != 'intro' ) {
		return;
	}

	$meeting_leader = get_post_meta( $post_id, 'meeting_leader', true );
	if ( empty( $meeting_leader ) ) {
		$meeting_leader = '_Toastmaster_of_the_Day_1';
	}

	$toastmaster = get_post_meta( $post_id, $meeting_leader, true );

	if ( $toastmaster && is_numeric( $toastmaster ) ) {
		$speaker       = get_userdata( $user_id );
		$manual        = get_post_meta( $post_id, '_manual' . $field, true );
		$project_index = get_post_meta( $post_id, '_project' . $field, true );
		if ( ! empty( $project_index ) ) {
			$project = get_project_text( $project_index );
			$manual .= ': ' . $project;
		}
		$title = get_post_meta( $post_id, '_title' . $field, true );

		$t        = get_rsvpmaker_timestamp( $post_id );
		$date     = rsvpmaker_date( $rsvp_options['short_date'], $t );
		$userdata = get_userdata( $toastmaster );
		$url      = get_permalink( $post_id );

		$subject = $speaker->first_name . ' ' . $speaker->last_name . ' ' . __( 'Speech Intro for', 'rsvpmaker-for-toastmasters' ) . ' ' . $date;

		$message = $speaker->first_name . ' ' . $speaker->last_name . ' ' . __( 'Speech for', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . $url . '">' . $date . "</a>\n\n" . $manual . "\n\n" . $title . "\n\n" . $actiontext;

		$toastmaster_email = $userdata->user_email;
		$message          .= "\n\nThis is an automated message. Replies will be sent to " . $speaker->user_email;
		$mail['subject']   = substr( strip_tags( $subject ), 0, 100 );
		$mail['replyto']   = $speaker->user_email;
		$mail['html']      = "<html>\n<body>\n" . wpautop( $message ) . "\n</body></html>";
		$mail['to']        = $toastmaster_email;
		$mail['from']      = $speaker->user_email;
		$mail['fromname']  = $speaker->display_name;
		awemailer( $mail );
	}
}

function editor_signup_notification( $post_id, $user_id, $role, $manual = '', $project = '', $title = '' ) {
	if ( is_admin() ) {
		return; // don't do this on the reconcile screen
	}

	$role = clean_role( $role );
	global $current_user;
	global $wpdb;
	global $rsvp_options;
	$meetingdate = rsvpmaker_date( $rsvp_options['short_date'], get_rsvpmaker_timestamp( $post_id ) );
	if ( ! is_numeric( $user_id ) ) {
		return;
	}
	$speakerdata = get_userdata( $user_id );
	if ( ! isset( $speakerdata->user_email ) ) {
		return;
	}
	if ( $project ) {
		$project = get_project_text( $project );
	}

	$subject = $message = sprintf( __( 'Your role: %1$s for %2$s %3$s', 'rsvpmaker-for-toastmasters' ), clean_role( $role ), $meetingdate, get_bloginfo( 'name' ) );

		$message .= "\n\n";
	if ( strpos( $role, 'peaker' ) ) {
		$message .= sprintf(
			'Manual: %s
Project: %s
Title: %s',
			$manual,
			$project,
			$title
		);
		if ( ! $project ) {
			$message .= "\n\n" . __( 'Please sign into the website to add speech project details, particularly if the speech project will require more than the default 7 minutes on the agenda.', 'rsvpmaker-for-toastmasters' );
			$subject .= ' (' . __( 'Please add project/timing', 'rsvpmaker-for-toastmasters' ) . ')';
		}
	}
		$message .= "\n\n" . __( 'If this information is not correct, or if you cannot attend on this date, please let us know as soon as possible.', 'rsvpmaker-for-toastmasters' );

		$meeting_leader = get_post_meta( $post_id, 'meeting_leader', true );
	if ( empty( $meeting_leader ) ) {
		$meeting_leader = '_Toastmaster_of_the_Day_1';
	}
		$toastmaster = (int) get_post_meta( $post_id, $meeting_leader, true );

	if ( $toastmaster && ( $user_id != $toastmaster ) ) {
		$tmdata       = get_userdata( $toastmaster );
		$leader_email = $tmdata->user_email;
	} else {
		$leader_email = get_option( 'admin_email' );
	}

		$p      = get_permalink( $post_id );
		$footer = "\n\nTo update this information, visit " . sprintf( '<a href="%s">%s</a>', $p, $p );

		$mail['subject']  = $subject;
		$mail['html']     = "<html>\n<body>\n" . wpautop( $message . $footer ) . "\n</body></html>";
		$mail['replyto']  = $leader_email;
		$mail['to']       = $speakerdata->user_email;
		$mail['from']     = $current_user->user_email;
		$mail['fromname'] = $current_user->display_name;
		awemailer( $mail ); // notify member
}

function tm_recommend_send( $name, $value, $permalink, $count, $post_id, $editor_id ) {
	global $wpdb;
	global $rsvp_options;
	$code = get_post_meta( $post_id, 'suggest_code', true );
	if ( ! $code ) {
			$code = wp_generate_password();
			update_post_meta( $post_id, 'suggest_code', $code );
	}
		$invite_check = $value . ':' . $post_id;
	if ( isset( $_SESSION[ $invite_check ] ) ) { // prevent double notifications
		return;
	}
		$_SESSION[ $invite_check ] = 1;
		$date     = rsvpmaker_date( $rsvp_options['long_date'], get_rsvpmaker_timestamp( $post_id ) );
		$neatname = trim( preg_replace( '/[_\-0-9]/', ' ', $name ) );
		$user     = get_userdata( $editor_id );
		$msg      = sprintf( '<p>Toastmaster %s %s %s %s %s %s</p>', $user->first_name, $user->last_name, __( 'has recomended you for the role of', 'rsvpmaker-for-toastmasters' ), $neatname, __( 'for', 'rsvpmaker-for-toastmasters' ), $date );
		$member   = get_userdata( $value );
		$email    = $member->user_email;
		$hash     = recommend_hash( $name, $value, $post_id );

		$url  = add_query_arg(
			array(
				'key'   => $name,
				'you'   => $value,
				'code'  => $hash,
				'count' => $count,
			),
			$permalink
		);
		$msg .= sprintf( "\n\n" . __( '<p>Click here to <a href="%s">ACCEPT</a> (no password required if you act before someone else takes this role)</p>', 'rsvpmaker-for-toastmasters' ), $url );
	if ( ! empty( $_POST['editor_suggest_note'][ $name ] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$msg .= "\n\n<p><b>" . __( 'Note from', 'rsvpmaker-for-toastmasters' ) . ' ' . $user->first_name . ' ' . $user->last_name . ': </b>' . wp_kses_post(stripslashes( $_POST['editor_suggest_note'][ $name ]) ) . '</p>';
	}
		$mail['html']     = $msg;
		$mail['to']       = $email;
		$mail['from']     = $user->user_email;
		$mail['cc']       = $user->user_email;
		$mail['fromname'] = $user->first_name . ' ' . $user->last_name;
		$mail['subject']  = 'You have been recommended for the role of ' . $neatname . ' on ' . $date;
		awemailer( $mail );
		$msg = '<div style="background-color: #eee; border: thin solid #000; padding: 5px; margin-5px;">' . $msg . '<p><em>' . __( 'Recommendation sent by email to', 'rsvpmaker-for-toastmasters' ) . ' <b>' . $email . '</b></em></p></div>';
		add_post_meta( $post_id, '_activity_editor', $user->first_name . ' ' . $user->last_name . ' recommended ' . $member->first_name . ' ' . $member->last_name . ' for ' . $neatname . ' on ' . $date . ', email sent to ' . $email );
		update_option( '_tm_updates_logged', strtotime( '+ 2 minutes' ) );
}

function wpt_email_agenda_wrapper($content) {
ob_start();
?>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<head>
<body>
<?php
$header = ob_get_clean();
return $header.$content.'<body></html>';
}

function awesome_open_roles( $post_id = null, $scheduled = false ) {

	if ( ! isset( $_REQUEST['open_roles'] ) && ! $post_id ) {
		return;
	}
	if ( ! is_club_member() ) {
		echo 'This function is only available to club members';
		return;
	}

	if ( function_exists( 'email_content_minfilters' ) ) {
		email_content_minfilters();
	} else {
		global $wp_filter;
		$corefilters = array( 'convert_chars', 'wpautop', 'wptexturize' );
		foreach ( $wp_filter['the_content'] as $priority => $filters ) {
			foreach ( $filters as $name => $details ) {
				// keep only core text processing or shortcode
				if ( ! in_array( $name, $corefilters ) && ! strpos( $name, 'hortcode' ) ) {
					remove_filter( 'the_content', $name, $priority );
				}
			}
		}
	}
	global $post;
	the_post();
	$content = tm_agenda_content();
	$content = apply_filters( 'email_agenda', $content );

	global $wpdb;
	global $rsvp_options;
	global $current_user;
	global $open;
	if ( ! $post_id ) {
		$post_id = (int) $_REQUEST['open_roles'];
	}
	$permalink = rsvpmaker_permalink_query( $post_id );
	$event       = get_rsvpmaker_event( $post_id );
	// year not necessary in this context
	$dateformat = str_replace( ', ', '', str_replace( 'Y', '', $rsvp_options['long_date'] ) );

	if ( get_option( 'wp4toastmasters_agenda_timezone' ) ) {
		$time_format = $dateformat . ' ' . $rsvp_options['time_format'];
	} else {
		$time_format = $dateformat;
	}
	$date = rsvpmaker_date( $time_format, $event->ts_start );

	$header   = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Email: '.$post->post_title.'</title>';
//
//'js/tinymce/plugins/compat3x/plugin.min.js?ver='.time()
if(empty($_POST))
$header .= sprintf("<script src='%s' id='wp-tinymce-js'></script>",includes_url('/js/tinymce/tinymce.min.js?ver='.time()));
$header .= '</head>
<body>
';
	$output   = '';
	if(isset($_GET['test'])) {
		$members = get_users('blog_id='.get_current_blog_id());
		foreach($members as $index => $member) 
			$output .= $index.': '.$member->display_name.'<br />';	
	}
	
	$openings = 0;
	if ( $open ) {

		if(isset($_GET['debug']))
			$output .= var_export($open, true);

		$output .= '<h3>' . __( 'Open Roles', 'rsvpmaker-for-toastmasters' ) . "</h3>\n<p>";

		foreach ( $open as $role => $count ) {
			$output .= wp4t_role($role);
			if ( $count > 1 ) {
				$output .= ' (' . $count . ')';
			}
			$output   .= "<br />\n";
			$openings += $count;
		}
		$output .= "</p>\n<p>" . __( 'Sign up at', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . $permalink . '">' . $permalink . "</a></p>\n<p>" . __( 'Forgot your password?', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . site_url( '/wp-login.php?action=lostpassword' ) . '">' . __( 'Reset your password here', 'rsvpmaker-for-toastmasters' ) . "</a></p>\n<h3>" . __( 'Roster', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";
	}
	// print_r($open);
	$output .= $content;
	$output = preg_replace('/<p[^>]+wp-block-wp4toastmasters-signupnote.+<\/p>/','',$output);
	if('rsvpmaker' != $post->post_type)
		$output = '<h1>'.$post->post_title."</h1>\n".$output;
	$output = rsvpmail_filter_style( rsvpmailer_default_block_template_wrapper($output) );

	$output = "<div id=\"agenda-email\">\n".$output."\n</div>\n";

	$shortmessage = ('rsvpmaker' == $post->post_type) ? 'Sign up at '.get_permalink() : '';

	if ( isset($_POST) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$send = $_POST['send'];
		echo 'send: '.$send;
		if ( ('test' == $send ) && ! empty( $_POST['testto'] ) ) {
			$mail['to'] = sanitize_text_field($_POST['testto']);
			printf('<p>Sending to %s</p>',$mail['to']);
		} elseif('members' == $send) {
			$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
			printf('<p>Sending to %s members</p>',sizeof($blogusers));
			foreach ( $blogusers as $user ) {
				// print_r($user);
				$emails[] = $user->user_email;
			}
		}
		elseif('members_without' == $send) {
			$emails = wpt_get_norole_email($post->ID);
			printf('<p>Sending to %s members <em>without a role</em></p>',sizeof($emails));
		}
		elseif('officers' == $send) {
			$emails = wpt_get_officer_emails();
			printf('<p>Sending to %s officers</p>',sizeof($emails));
		}
		else {
			echo 'no match for $send';
		}
		if ( isset( $_POST['note'] ) && $_POST['note'] && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			$output = '<div id="message">' . wp_kses_post(stripslashes( $_POST['note'] )) . "</div>\n<p>Sent by: " . $current_user->display_name . ' <a href="mailto:' . $current_user->user_email . '">' . $current_user->user_email . "</a>\n" . $output;
		}
		$mail['html']     = $header . $output . '</body></html>';
		$mail['replyto'] = $mail['from']     = $current_user->user_email;
		$mail['fromname'] = (!empty($_POST['fromname'])) ? $current_user->display_name. ' via ' .get_bloginfo( 'name' ) : get_bloginfo( 'name' ) . ' / ' . $current_user->display_name;
		$mail['subject']  = sanitize_text_field( stripslashes( $_POST['subject'] ) );
		update_user_meta($current_user->ID,'agenda_fromname',intval($_POST['fromname']));

if ( isset( $emails ) && is_array( $emails ) ) {
			rsvpmaker_qemail ($mail, $emails);
		} else {
			echo awemailer( $mail );
		}
		// output without form
		$output = $header . $output . '</body></html>';
	} elseif ( ! $scheduled ) {
		if('rsvpmaker' == $post->post_type) {
			$subject = __( 'Agenda for', 'rsvpmaker-for-toastmasters' ) . ' ' . $date;
			if ( $openings ) {
				$subject .= ' (' . $openings . ' ' . __( 'open roles', 'rsvpmaker-for-toastmasters' ) . ')';
			}
			$subject = get_bloginfo( 'name' ) . ' ' . $subject;	
		}
		else
			$subject = $post->post_title;
		$role_only = (isset($_REQUEST['role_only'])) ? '<input type="hidden" name="role_only" value="1" />' : '';
		$from_preference = get_user_meta($current_user->ID,'agenda_fromname',true);
		if($from_preference == '')
			$from_preference = 1;

		$mailform = '<script>
	tinymce.init({
		selector:"textarea",plugins: "link",
		block_formats: "Paragraph=p",
		menu: {
		format: { title: "Format", items: "bold italic | removeformat" },
		style_formats: [
		{ title: "Inline", items: [
			{ title: "Bold", format: "bold" },
			{ title: "Italic", format: "italic" },
		]},]},
		toolbar: "bold italic link",
		relative_urls: false,
		remove_script_host : false,
		document_base_url : "'.site_url().'/",
	});
	function checkTest() {
		document.getElementById("sendtest").checked = true;
	}	
	</script>
	<p>Use the form below to send the agenda as shown below with a note and the subject line of your choice. Alternatively, you can use the '.club_member_mailto($subject, $shortmessage).' link to send to the members by BCC from your own email client.</p>
	<h3>' . __( 'Add a Note (optional)', 'rsvpmaker-for-toastmasters' ) . '</h3>
	<p>' . __( 'Your note will be emailed along with the details shown below.','rsvpmaker-for-toastmasters').'</p><p>'.__('You can also change the subject line. For example, when emailing the agenda you may want to emphasize the roles you need filled or special plans for a meeting (such as a contest).', 'rsvpmaker-for-toastmasters' ) . '</p>
	<form method="post" action="' . $permalink . 'email_agenda=1">
	From: <input type="radio" name="fromname" value="1" '.(($from_preference) ? 'checked="checked"' : '') .' /> '.$current_user->display_name. ' via ' .get_bloginfo( 'name' ) .'<input type="radio" name="fromname" value="0" '.(($from_preference) ? '': 'checked="checked"') .' /> '. get_bloginfo( 'name' ) . ' / ' . $current_user->display_name .'<br />
	Subject: <input type="text" name="subject" value="' . $subject . '" size="60"><br />
<textarea name="note" rows="5" cols="80"></textarea><br />
Send to <input type="radio" name="send" value="members" checked="checked" > ' . __( 'all members', 'rsvpmaker-for-toastmasters' ) . ' <input type="radio" name="send" value="members_without" > ' . __( 'members without a role', 'rsvpmaker-for-toastmasters' ) . ' <input type="radio" name="send" value="officers"  > ' . __( 'officers', 'rsvpmaker-for-toastmasters' ) . '  <input id="sendtest" type="radio" name="send" value="test" > ' . __( 'this address', 'rsvpmaker-for-toastmasters' ) . ': <input type="text" id+"testto" onkeypress="checkTest()" name="testto" /><br />
<input type="submit" value="Send" />
' . rsvpmaker_nonce('return'). $role_only. '
</form>';

		$output = $header . $mailform . $output.'</body></html>';
	}

	echo $output;

	exit();
}

function backup_speaker_notify( $assigned, $post_id = null ) {
	global $post;
	global $wpdb;
	global $rsvp_options;

	if(!$post_id)
		$post_id = $post->ID;

	if ( ! is_rsvpmaker_future( $post_id ) ) {
		return;
	}

		$meetingdate = rsvpmaker_date( $rsvp_options['short_date'], get_rsvpmaker_timestamp( $post_id ) );

		$meeting_leader = get_post_meta( $post_id, 'meeting_leader', true );
	if ( empty( $meeting_leader ) ) {
		$meeting_leader = '_Toastmaster_of_the_Day_1';
	}
		$toastmaster = (int) get_post_meta( $post_id, $meeting_leader, true );

	if ( $toastmaster ) {
		$tmdata       = get_userdata( $toastmaster );
		$leader_email = $tmdata->user_email;
	} else {
		$leader_email = get_option( 'admin_email' );
	}

			$speakerdata     = get_userdata( $assigned );
			$subject         = $message = sprintf( '%s %s ', $speakerdata->first_name, $speakerdata->last_name ) . __( 'now scheduled to speak on', 'rsvpmaker-for-toastmasters' ) . ' ' . $meetingdate;
			$url             = rsvpmaker_permalink_query( $post_id );
			$mail['subject'] = substr( strip_tags( $subject ), 0, 100 );
			$message        .= "\n\n" . __( 'Backup speaker promoted to speaker following a cancellation.', 'rsvpmaker-for-toastmasters' );

			$footer = "\n\n" . __( 'This is an automated message. Replies will be sent to', 'rsvpmaker-for-toastmasters' ) . ' ' . $leader_email;
	if ( $toastmaster ) {
		$footer .= ' Toastmaster of the Day ' . $tmdata->display_name;
	}
			$p                = get_permalink( $post_id );
			$footer          .= "\n\nTo remove yourself from the agenda, visit " . sprintf( '<a href="%s">%s</a>', $p, $p );
			$mail['html']     = "<html>\n<body>\n" . wpautop( $message . $footer ) . "\n</body></html>";
			$mail['replyto']  = $leader_email;
			$mail['to']       = $speakerdata->user_email;
			$mail['from']     = $leader_email;
			$mail['fromname'] = get_bloginfo( 'name' );
			$result           = awemailer( $mail ); // notify speaker

			$footer           = "\n\nThis is an automated message. Replies will be sent to " . $speakerdata->user_email;
			$mail['html']     = "<html>\n<body>\n" . wpautop( $message . $footer ) . "\n</body></html>";
			$mail['replyto']  = $speakerdata->user_email;
			$mail['to']       = $leader_email;
			$mail['from']     = $speakerdata->user_email;
			$mail['fromname'] = $speakerdata->display_name;
			$result           = awemailer( $mail ); // notify leader
}

function is_tm_privacy_pending($id_or_email, $return_not_set = false) {
	global $wpdb;
	if(is_numeric($id_or_email)) {
		$sql = "SELECT meta_value fROM $wpdb->usermeta WHERE user_id=$id_or_email AND meta_key='tm_privacy_prompt'";
	}
	else { // by email
		$sql = $wpdb->prepare("SELECT meta_value FROM $wpdb->users JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id WHERE user_email LIKE %s AND meta_key='tm_privacy_prompt'",$id_or_email);
	}
	//echo $sql;
	$status = $wpdb->get_var($sql);
	if(($status == '') && $return_not_set)
		return 'not set';
	else
		return $status;
}

function tm_privacy_prompt() {
?>
<h1>User Privacy Preferences</h1>
<p>Use this screen to see which users have given permission for club email and for their information to be included in the member directory. You can send a prompt to their email address asking them to grant permission. If their status is set to "permission pending" or "permission DENIED," any other Toastmasters email will be blocked from being sent to their address. The goal of these functions is to improve compliance with privacy regulations such as the EU's GDPR.</p>
<p>A status of "not set" means the member was not asked to grant permission when their account was set up. New member accounts are now set to "permission pending" until the member grants permission.</p>
<?php
	$current_user;
	if(isset($_POST['prompt'])) {
		foreach($_POST['prompt'] as $id) {
			update_user_meta($id,'tm_privacy_prompt',1);
			$user = get_userdata($id);
			$message = sprintf("Please log into the website at %s to grant permission for the Toastmasters club to send you email, including club news and email notifications. There is also an option for you to DENY permission, although this may hinder our ability to communicate with you.",admin_url());
			wp_mail($user->user_email,'Please set your preference for Toastmasters email privacy',$message);
		}
	}
	$members = get_club_members();
	$permission_given = $permission_denied = array();
	printf('<form method="post" action="%s"><p><input type="checkbox" id="checkAll"> %s</p>',admin_url('users.php?page=tm_privacy_prompt'),__('Check All','rsvpmaker-for-toastmasters'));
	foreach($members as $member) {
		$capsemail = strtoupper($member->user_email);
		/*
		if($code = rsvpmail_is_problem($capsemail))
		{
			echo $capsemail .':' .$code;
		}
		*/
		$pending = is_tm_privacy_pending($member->ID, true);
		$checkbox = sprintf('<input type="checkbox" name="prompt[]" value="%d"> Request permission ',$member->ID);
		if($pending == '0') {
			$permission_given[] = $member->display_name;
			continue;
		}
		elseif($pending == '1')
			$pending = 'permission pending';
		elseif($pending == '2') {
			$checkbox = sprintf('<input type="checkbox" name="prompt[]" value="%d"> Reset ',$member->ID);
			$permission_denied[] = sprintf('<p>%s <strong>%s</strong></p>',$checkbox,$member->display_name);
			continue;
		}
		printf('<p>%s <strong>%s</strong>: %s</p>',$checkbox,$member->display_name,$pending);	
	}
	submit_button();
	echo '</form>';
	if(!empty($permission_given))
		printf('<p>%s %s</p>',__('Permission given','rsvpmaker-for-toastmasters'),implode(', ',$permission_given));
	if(!empty($permission_denied)) {
		printf('<form method="post" action="%s">',admin_url('users.php?page=tm_privacy_prompt'));
		printf('<p>%s %s</p>',__('Permission denied','rsvpmaker-for-toastmasters'),implode(', ',$permission_denied));
		submit_button();
		echo '</form>';
	}
?>
<script>
jQuery(document).ready(function($) {

$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

});
</script>
<?php
}

add_action('admin_notices', 'tm_grant_privacy_permission_ui',1);

function tm_grant_privacy_permission_ui ($return = false, $profile_form = false, $userdata = NULL) {
	return;
if(!$return && (!empty($_GET['action']) || strpos($_SERVER['REQUEST_URI'],'post-new.php') ))
global $current_user;
if(!$userdata)
	$userdata = $current_user;
$output = '';
$pending = is_tm_privacy_pending($userdata->ID);
if($pending == '')
	$pending = '1';
	if(isset($_POST['tm_privacy_permission'])) {
		$pending = sanitize_text_field($_POST['tm_privacy_permission']);
		$value = intval($pending);
		update_user_meta($userdata->ID,'tm_privacy_prompt',$value);
		update_user_meta($userdata->ID,'tm_directory_blocked',intval($_POST['tm_directory_blocked']));
	}
	if($profile_form || ($pending == '1'))
	{
	$current = get_user_meta($userdata->ID,'tm_privacy_prompt',true);
	if($return)
		ob_start();
	if(!$profile_form)
		printf('<form method="post" action="%s" style="margin-bottom: 20px;">',admin_url('profile.php'));
	$checked = ($current == '0') ? ' checked="checked" ' : '';
	printf('<h1>%s</h1><p>%s</p>',__('Please set your club privacy preference.','rsvpmaker-for-toastmasters'),__('Allow club websites to send you email such as meeting notifications'));
	printf('<p><input type="radio" name="tm_privacy_permission" value="0" %s> %s</p> ',$checked,__('Yes, give permission','rsvpmaker-for-toastmasters'));
	$checked = ($current == '2') ? ' checked="checked" ' : '';
	printf('<p><input type="radio" name="tm_privacy_permission" value="2" %s> %s</p> ',$checked,__('No, DENY permission','rsvpmaker-for-toastmasters'));
	printf('<p>%s <a href="%s">%s</a></p>',__("Allow contact information to be shared with other members in the private"),admin_url('admin.php?page=contacts_list'),__('Member Directory','rsvpmaker-for-toastmasters'));
	$current = get_user_meta($userdata->ID,'tm_directory_blocked',true);
	$checked = ($current == '0') ? ' checked="checked" ' : '';
	printf('<p><input type="radio" name="tm_directory_blocked" value="0" %s> %s</p> ',$checked,__('Yes, give permission','rsvpmaker-for-toastmasters'));
	$checked = ($current) ? ' checked="checked" ' : '';
	printf('<p><input type="radio" name="tm_directory_blocked" value="1" %s> %s</p> ',$checked,__('No, DENY permission','rsvpmaker-for-toastmasters'));
	if(!$profile_form) {
		echo '<button>'.__('Save Changes').'</button></form>';	
	}
	if($return)
		return ob_get_clean();
	}
}

add_action('login_footer','login_footer_tm_privacy',1);
function login_footer_tm_privacy() {
	global $current_user;
	if(isset($_GET['action']) && ($_GET['action'] == 'resetpass') )
	{
		printf('<p style="text-align:center; border: thin solid red"><strong>%s</strong> %s</p>',__('IMPORTANT','rsvpmaker-for-toastmasters'),__('If you are a new member, please log in to set your email and privacy preference.','rsvpmaker-for-toastmasters'));
	}
}

function club_member_mailto($subject = '', $body = '') {
	global $current_user;
	$emails = array();
	$members = get_club_members();
	foreach($members as $member) {
		$emails[] = $member->user_email;
	}
	$querystring = (empty($subject)) ? 'subject='.get_bloginfo('name') : 'subject='.$subject;
	$querystring .= '&bcc='.implode(', ',$emails);
	if(!empty($body))
		$querystring .= '&body='.$body;
	return sprintf('<a target="_blank" href="mailto:%s?%s">Email All Members</a>',$current_user->user_email, $querystring);
}

function wpt_get_norole_email($post_id) {
	global $wpdb;
	$emails    = array();
	$absences  = get_absences_array( $post_id );
	$members   = get_club_members();
	foreach ( $members as $member ) {
		if(in_array( $member->ID, $absences ))
			continue;
		$sql                             = "SELECT * FROM `$wpdb->postmeta` where post_id=" . $post_id . '  AND meta_value=' . $member->ID . " AND meta_key LIKE '_role%' ";
		$role_results                    = $wpdb->get_results( $sql );
		if ( $role_results ) {
			continue;
		}
		 else {
			$emails[] = $member->user_email;
		}
	}
	return $emails;
}

function show_role_blocks_only($block_content, $block) {
	if(isset($_REQUEST['role_only']) && ('wp4toastmasters/role' != $block['blockName']))
		return '';
	return $block_content;
}

add_filter('render_block', 'show_role_blocks_only', 10, 2);