<?php

add_action( 'admin_menu', 'toastmasters_reports_menu' );

add_action( 'admin_menu', 'tm_welcome_screen_pages' );

add_action( 'admin_enqueue_scripts', 'tm_welcome_screen_assets' );

add_action( 'admin_init', 'tm_member_welcome_redirect' );

add_action( 'admin_head', 'tm_welcome_screen_remove_menus' );

function toastmasters_reports_menu() {

	if(wp4t_is_district())

		return;

	global $current_user;

	$security = get_tm_security();

	$beta     = get_option( 'wp4toastmasters_beta' );



	add_menu_page( __( 'Toastmasters', 'rsvpmaker-for-toastmasters' ), __( 'Toastmasters', 'rsvpmaker-for-toastmasters' ), 'read', 'toastmasters_screen', 'toastmasters_screen', 'dashicons-microphone', '2.01' );

	add_submenu_page( 'toastmasters_screen', __( 'My Progress', 'rsvpmaker-for-toastmasters' ), __( 'My Progress', 'rsvpmaker-for-toastmasters' ), 'read', 'my_progress_report', 'wp4toastmasters_history' );
	add_submenu_page( 'toastmasters_screen', __( 'Evaluations', 'rsvpmaker-for-toastmasters' ), __( 'Evaluations', 'rsvpmaker-for-toastmasters' ), 'read', 'wp4t_evaluations', 'wp4t_evaluations' );
	add_submenu_page( 'toastmasters_screen', __( 'Multi-Meeting Role Planner', 'rsvpmaker-for-toastmasters' ), __( 'Role Planner', 'rsvpmaker-for-toastmasters' ), 'read', 'toastmasters_planner', 'toastmasters_planner' );
	add_submenu_page( 'toastmasters_screen', __( 'NEW: Member Signups and Suggestions', 'rsvpmaker-for-toastmasters' ), __( 'NEW: Member Signups and Suggestions', 'rsvpmaker-for-toastmasters' ), 'read', 'wpt_member_signups_suggestions_screen', 'wpt_member_signups_suggestions_screen' );
	add_submenu_page( 'toastmasters_screen', __( 'Suggest All Roles', 'rsvpmaker-for-toastmasters' ), __( 'Suggest All Roles', 'rsvpmaker-for-toastmasters' ), 'read', 'wpt_suggest_all_roles', 'wpt_suggest_all_roles' );
	add_submenu_page( 'toastmasters_screen', __( 'Progress Reports (All Members)', 'rsvpmaker-for-toastmasters' ), __( 'Progress Reports (All Members)', 'rsvpmaker-for-toastmasters' ), $security['view_reports'], 'toastmasters_reports', 'wp4toastmasters_history' );
	add_submenu_page( 'toastmasters_screen', __( 'Pathways Progress', 'rsvpmaker-for-toastmasters' ), __( 'Pathways Progress', 'rsvpmaker-for-toastmasters' ), $security['view_reports'], 'pathways_report', 'pathways_report' );
	add_submenu_page( 'toastmasters_screen', __( 'Pathways/BaseCamp checklist', 'rsvpmaker-for-toastmasters' ), __( 'Base Camp Checklist', 'rsvpmaker-for-toastmasters' ), 'read', 'pathways_checklist', 'pathways_checklist' );
	add_submenu_page( 'toastmasters_screen', __( 'Reports Dashboard', 'rsvpmaker-for-toastmasters' ), __( 'Reports Dashboard', 'rsvpmaker-for-toastmasters' ), $security['view_reports'], 'toastmasters_reports_dashboard', 'toastmasters_reports_dashboard' );
	add_submenu_page( 'toastmasters_screen', __( 'Member List', 'rsvpmaker-for-toastmasters' ), __( 'Member List', 'rsvpmaker-for-toastmasters' ), 'view_contact_info', 'contacts_list', 'member_list' );
	add_submenu_page( 'toastmasters_screen', __( 'My Data', 'rsvpmaker-for-toastmasters' ), __( 'My Data', 'rsvpmaker-for-toastmasters' ), 'read', 'wpt_my_data', 'wpt_my_data' );
	add_submenu_page( 'toastmasters_screen', __( 'About WordPress for Toastmasters', 'rsvpmaker-for-toastmasters' ), __( 'About WordPress for Toastmasters', 'rsvpmaker-for-toastmasters' ), 'read', 'toastmasters_support', 'toastmasters_support' );

	add_menu_page( __( 'TM Administration', 'rsvpmaker-for-toastmasters' ), __( 'TM Administration', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'toastmasters_admin_screen', 'toastmasters_admin_screen', 'dashicons-microphone', '2.02' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Agenda Template Editor', 'rsvpmaker-for-toastmasters' ), __( 'Agenda Template Editor', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'agenda_template_editor', 'agenda_template_editor' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Update Roles & Attendance', 'rsvpmaker-for-toastmasters' ), __( 'Update Roles & Attendance', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'toastmasters_reconcile', 'toastmasters_reconcile' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Edit Records', 'rsvpmaker-for-toastmasters' ), __( 'Edit Records', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'wp4toastmasters_history_edit', 'wp4toastmasters_history_edit' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Add Speech', 'rsvpmaker-for-toastmasters' ), __( 'Add Speech', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'add_member_speech', 'add_member_speech' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Mentors', 'rsvpmaker-for-toastmasters' ), __( 'Mentors', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'toastmasters_mentors', 'toastmasters_mentors' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Track Dues', 'rsvpmaker-for-toastmasters' ), __( 'Track Dues', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'wpt_dues_report', 'wpt_dues_report' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Activity Log', 'rsvpmaker-for-toastmasters' ), __( 'Activity Log', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'toastmasters_activity_log', 'toastmasters_activity_log' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Import/Export', 'rsvpmaker-for-toastmasters' ), __( 'Import/Export', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'import_export', 'toastmasters_import_export' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Setup Wizard', 'rsvpmaker-for-toastmasters' ), __( 'Setup Wizard', 'rsvpmaker-for-toastmasters' ), 'manage_options', 'wp4t_setup_wizard', 'wp4t_setup_wizard' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'FreeToastHost Importer', 'rsvpmaker-for-toastmasters' ), __( 'FreeToastHost Importer', 'rsvpmaker-for-toastmasters' ), 'manage_options', 'fth_importer_docs', 'fth_importer_docs' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Review & Approve Member Applications', 'rsvpmaker-for-toastmasters' ), __( 'Review & Approve Member Applications', 'rsvpmaker-for-toastmasters' ), 'edit_users', 'member_application_approval', 'member_application_approval' );
	add_submenu_page( 'toastmasters_admin_screen', __( 'Member Application & Dues Setup', 'rsvpmaker-for-toastmasters' ), __( 'Member Application & Dues Setup', 'rsvpmaker-for-toastmasters' ), 'manage_options', 'member_application_settings', 'member_application_settings' );

	if(!is_toastmost_site())

		add_submenu_page( 'toastmasters_admin_screen', __( 'Include on Toastmost Calendar?', 'rsvpmaker-for-toastmasters' ), __( 'Include on Toastmost Calendar?', 'rsvpmaker-for-toastmasters' ), 'manage_options', 'include_toastmost_calendar', 'include_toastmost_calendar' );

	add_submenu_page( 'toastmasters_admin_screen', __( 'Settings', 'rsvpmaker-for-toastmasters' ), __( 'Settings', 'rsvpmaker-for-toastmasters' ), 'manage_options', 'wp4toastmasters_settings', 'wp4toastmasters_settings' );

	add_menu_page( __( 'TM Help', 'rsvpmaker-for-toastmasters' ), __( 'TM Help', 'rsvpmaker-for-toastmasters' ),'edit_users', 'toastmasters_admin_help', 'toastmasters_admin_help', 'dashicons-editor-help', '2.05' );

	add_submenu_page( 'toastmasters_admin_help', __( 'Todo List', 'rsvpmaker-for-toastmasters' ), __( 'Todo List', 'rsvpmaker-for-toastmasters' ), 'manage_options', 'wp4t_todolist_screen', 'wp4t_todolist_screen' );

	add_action( 'admin_enqueue_scripts', 'toastmasters_css_js' );

	add_submenu_page( 'edit.php?post_type=tmminutes', __( 'Minutes from Meeting Records', 'rsvpmaker-for-toastmasters' ), __( 'Minutes from Meeting Records', 'rsvpmaker-for-toastmasters' ), 'edit_others_posts', 'toastmasters_meeting_minutes', 'toastmasters_meeting_minutes' );

	add_submenu_page( 'edit.php?post_type=tmminutes', __( 'Minutes Templates', 'rsvpmaker-for-toastmasters' ), __( 'Minutes Templates', 'rsvpmaker-for-toastmasters' ), 'edit_others_posts', 'toastmasters_minutes_templates', 'toastmasters_minutes_templates' );

	add_submenu_page( 'edit.php?post_type=tmminutes', __( 'Minutes Help', 'rsvpmaker-for-toastmasters' ), __( 'Minutes Help', 'rsvpmaker-for-toastmasters' ), 'edit_others_posts', 'toastmasters_minutes_help', 'toastmasters_minutes_help' );

}



function toastmasters_admin_help() {

?>

<h1>Help for WordPress for Toastmasters Administrators</h1>

<p>Consult the <a href="<?php echo admin_url('admin.php?page=wp4t_todolist_screen'); ?>">Todo List</a> for a prioritized list of common tasks, with links to documentation and tutorial resources as well as links to where you can turn on features such as online payments.</p>

<p>The primary documentation is in the <a  target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/">Knowledge Base on wp4toastmasters.com</a>.</p>

<p>If you need more help, consider posting a question to the <a  target="_blank" href="https://www.facebook.com/groups/wp4toastmasters/">Facebook group for users of the software</a>.</p>

<p>Or contact David F. Carr, DTM at <a target="_blank" href="mailto:david@wp4toastmasters.com?subject=WP for Toastmasters question (<?php echo $_SERVER['SERVER_NAME'] ?>)">david@wp4toastmasters.com.</a></p>

<p>Volunteer help wanted: get in touch if you can help improve the documentation and training materials for this volunteer-led project. <a target="_blank" href="mailto:david@wp4toastmasters.com?subject=WP for Toastmasters documentation and raining">Volunteer</a></p>

<?php

}



function toastmasters_admin_screen() {

	global $submenu, $current_user, $rsvp_options;

	$hook = tm_admin_page_top( __( 'Toastmasters Administration', 'rsvpmaker-for-toastmasters' ) . ': ' . get_member_name( $current_user->ID ) );



	echo '<div style="width: 50%; float: right; padding-left: 10px;">';

	$templates    = array();

	$meetings     = future_toastmaster_meetings( 20 );

	$meetingslist = '<h2>' . __( 'Upcoming Meetings', 'rsvpmaker-for-toastmasters' ) . '</h2>';

	if ( empty( $meetings ) ) {

		$meetingslist .= '<p>No meetings found</p>';

	} else {

		foreach ( $meetings as $meeting ) {

			$editlink    = admin_url( 'post.php?action=edit&post=' . $meeting->ID );

			$viewlink    = get_permalink( $meeting->ID );

			$signupslink = add_query_arg( 'edit_roles_new', '1', $viewlink );

			$layout_id = wp4toastmasters_agenda_layout_check( );

			$layout_link = admin_url('post.php?post='.$layout_id.'&action=edit');

			$meetingslist .= sprintf(

				'<p>%s %s </p><ul>

	<li><a href="%s" target="_blank">%s</a></li>

	<li><a href="%s" target="_blank">%s</a></li>

	<li><a href="%s" >%s</a> - %s</li>

	<li><a href="%s" target="_blank">%s</a></li>

	</ul>',

				$meeting->post_title,

				rsvpmaker_date($rsvp_options['long_date'], intval($meeting->ts_start)),

				$signupslink,

				__( 'Edit Signups', 'rsvpmaker-for-toastmasters' ),

				$viewlink,

				__( 'View', 'rsvpmaker-for-toastmasters' ),

				$editlink,

				__( 'Edit Agenda Document' ),

				__( 'change agenda roles and text for this meeting only' ),

				$layout_link,

				__( 'Edit Agenda Layout' )

			);

					$recur = get_post_meta( $meeting->ID, '_meet_recur', true );

			if ( ! in_array( $recur, $templates ) ) {

				$templates[] = $recur;

			}

		}

	}



	if ( ! empty( $templates ) ) {

		echo '<h2>Active Templates</h2>';

		foreach ( $templates as $tid ) {

			$template = get_post( $tid );

			printf( '<p><a href="%s">Edit Template: %s</a></p>', admin_url( 'post.php?action=edit&post=' . $template->ID ), $template->post_title );

			printf( '<p><a href="%s">Create / Update Events based on %s</a></p>', admin_url( 'edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=' . $template->ID ), $template->post_title );

			// http://beta.local/wp-admin/edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=7

		}

	} else {

		$template = get_page_by_path( 'toastmasters-meeting', '', 'rsvpmaker' );

		// default template

		if ( ! empty( $template ) ) {

			echo '<h2>Default Template</h2>';

			printf( '<p><a href="%s">Edit Template: %s</a></p>', admin_url( 'post.php?action=edit&post=' . $template->ID ), $template->post_title );

			printf( '<p><a href="%s">Create / Update Events based on %s</a></p>', admin_url( 'edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=' . $template->ID ), $template->post_title );

		}

	}



	echo $meetingslist;



	echo '</div>'; // end float right section



	echo '<h2>Tools</h2>';



	$tip['toastmasters_reconcile']    = 'Update records for speech and role signups';

	$tip['toastmasters_activity_log'] = 'Log of who signed up, withdrew from a role, or edited signups';

	$tip['toastmasters_attendance']   = 'Check off who attended your meetings (members on record as holding a role already marked present)';

	$tip['wpt_dues_report']           = 'Shows recent online payments via Stripe and lets you record other payments. Send email reminders to renew. Export data to spreadsheet. Also provides access to application form, Stripe online payments setup';

	$tip['add_member_speech']         = 'Add a speech to a member\'s records (for example, a speech at another club)';

	$tip['wp4t_setup_wizard']         = 'Intended for initial site setup';

	$tip['toastmost_club_email_list'] = 'Settings for member discussion email list and officers discussion email list';

	$tip['findaclub']                 = 'Automatically respond to "Prospective new member" emails from toastmasters.org. Set forwarding for other notifications, such as Basecamp alerts';



	foreach ( $submenu['toastmasters_admin_screen'] as $index => $item ) {

		if ( $index == 0 ) {

			continue;

		}

		$cap   = $item[1];

		$slug  = $item[2];

		$text  = ( empty( $tip[ $slug ] ) ) ? '' : ' - ' . $tip[ $slug ];

		$title = $item[0];

		if ( current_user_can( $cap ) ) {

			printf( '<p><a href="%s">%s</a>%s</p>', admin_url( 'admin.php?page=' . $slug ), $title, $text );

		}

	}//end foreach



	echo '<h2>Website Administration</h2>';

	toastmasters_admin_widget();

	/*

	global $menu;

	echo '<pre>';

	print_r($menu);

	echo '</pre>';

	*/

	tm_admin_page_bottom( $hook );

}//end toastmasters_admin_screen()





function wp_ajax_add_speech() {

	$user_id = (int) $_REQUEST['user_id'];

	add_member_speech( $user_id );

	die();

}

add_action( 'wp_ajax_add_speech', 'wp_ajax_add_speech' );



function wp_ajax_remove_meta_speech() {

	global $wpdb;

	$user_id = (int) $_REQUEST['user_id'];

	$project = sanitize_text_field($_REQUEST['project']);

	$sql     = "DELETE FROM $wpdb->usermeta WHERE user_id=$user_id AND meta_key='Speaker' AND meta_value LIKE '%" . $project . "%' ";

	$wpdb->query( $sql );

	die( $sql );

}

add_action( 'wp_ajax_remove_meta_speech', 'wp_ajax_remove_meta_speech' );





function tm_select_member( $page, $field ) {

	$user_id = ( isset( $_REQUEST[ $field ] ) ) ? (int) $_REQUEST[ $field ] : 0;

	printf( '<form method="get" action="%s" id="tm_select_member"><input type="hidden" id="tm_page" name="page" value="%s" />', admin_url( 'admin.php' ), $page );

	echo awe_user_dropdown( $field, $user_id, true, __( 'Select Member', 'rsvpmaker-for-toastmasters' ) );

	echo '<button>' . __( 'Get', 'rsvpmaker-for-toastmasters' ) . '</button>';

	rsvpmaker_nonce();

	echo '</form>';

	return $user_id;

}



function add_member_speech(  ) {

		$user_id = (isset($_REQUEST['toastmaster'])) ? intval($_REQUEST['toastmaster']) : 0;

		printf( '<form method="get" action="%s" id="tm_select_member_tab"><input type="hidden" id="tm_page" name="page" value="add_member_speech" />', admin_url( 'admin.php' ) );

		echo awe_user_dropdown( 'toastmaster', $user_id, true, __( 'Select Member', 'rsvpmaker-for-toastmasters' ) );

		echo '<button>' . __( 'Get', 'rsvpmaker-for-toastmasters' ) . '</button>';

		echo '<input type="hidden" name="active" class="tab" value="add_member_speech">';

		rsvpmaker_nonce();

		echo '</form>';

		if(!$user_id)

			return;

	global $rsvp_options;

	if ( isset( $_REQUEST['_manual_meta'] ) ) {

		$manual = sanitize_text_field($_REQUEST['_manual_meta']);

		if ( isset( $_REQUEST['_project_meta'] ) ) {

			$p = sanitize_text_field($_REQUEST['_project_meta']);

		} elseif ( isset( $_REQUEST['project'] ) ) {

			$p = sanitize_text_field($_REQUEST['project']);

		}

		$title = sanitize_text_field($_REQUEST['_title_meta']);

		$intro        = sanitize_text_field($_REQUEST['_intro_meta']);

		$projectslug  = preg_replace( '/[ _]/', '', $manual ) . '_project';

		$year         = sanitize_text_field($_REQUEST['project_year']);

		$month        = sanitize_text_field($_REQUEST['project_month']);

		$day          = sanitize_text_field($_REQUEST['project_day']);

		if ( $year && $month && $day ) {

			$date = rsvpmaker_strtotime( $year . '-' . $month . '-' . $day.' 12:00:00' );

		} else {

			$date = time();

		}



		// new data model

		$role = 'Speaker_' . time();

		$timestamp = rsvpmaker_date( 'Y-m-d G:i:s', $date );

		$post_id = 0;

		$function = 'add_member_speech';

		wp4t_record_history_to_table($user_id, $role, $timestamp, 0, $function, $manual,$p,$title,$intro, sanitize_text_field($_SERVER['SERVER_NAME']));

		$speech_url = admin_url( 'admin.php?page=toastmasters_reports&tab=speeches&toastmaster=' . $user_id );



		echo '<em>' . __( 'Saved:', 'rsvpmaker-for-toastmasters' ) . ' ' . $manual . ' ' . $project_text . ' ' . $speech_title . ' for ' . rsvpmaker_date( 'F j, Y', $date ) . '</em> ';

		printf( '<a href="%s">%s</a>', $speech_url, __( 'Refresh speech list', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( isset( $_REQUEST['_role_meta'] ) || isset( $_REQUEST['project'] ) ) {

		if ( isset( $_REQUEST['project'] ) ) {

			$role = sanitize_text_field($_REQUEST['project']);

		} else {

			$role = sanitize_text_field($_REQUEST['_role_meta']);

		}

		$year  = sanitize_text_field($_REQUEST['project_year']);

		$month = sanitize_text_field($_REQUEST['project_month']);

		$day   = sanitize_text_field($_REQUEST['project_day']);

		if ( $year && $month && $day ) {

			$date = strtotime( $year . '-' . $month . '-' . $day );

		} else {

			$date = time();

		}

		$role .= '_'.time();

		$timestamp = rsvpmaker_date( 'Y-m-d G:i:s', $date );

		$post_id = 0;

		$function = 'add_member_role';

		wp4t_record_history_to_table($user_id, $role, $timestamp, 0, $function);



		$speech_url = admin_url( 'admin.php?page=toastmasters_reports&toastmaster=' . $user_id );



		echo '<em>' . __( 'Saved:', 'rsvpmaker-for-toastmasters' ) . ' ' . $role . ' for ' . rsvpmaker_date( 'F j, Y', $date ) . '</em> ';

		printf( '<a href="%s">%s</a>', $speech_url, __( 'Refresh to see changes', 'rsvpmaker-for-toastmasters' ) );

	} 

	

	if ( $user_id ) {

		global $post;

		$post = (object) array( 'ID' => 0 ); // fake post object, expected by speaker_details function

		printf( '<div id="add_speech_div"><h2>%s</h2><form id="add_speech_form" method="post" action="%s"><input type="hidden" name="toastmaster" id="toastmaster" value="%d" /><input type="hidden" name="add_speech" value="1" />', __( 'Add Speech' ), admin_url( 'admin.php?page=add_member_speech' ), $user_id );

		echo str_replace( '[]', '_meta', speaker_details( '', 0, array() ) );

		printf( '<div>%s: <input name="project_month" id="project_month_add" size="4" value="%s" /> %s: <input name="project_day" id="project_day_add" size="4" value="%s" /> %s: <input name="project_year" id="project_year_add" size="8" value="%s" /></div>', __( 'Month', 'rsvpmaker-for-toastmasters' ), rsvpmaker_date( 'm' ), __( 'Day', 'rsvpmaker-for-toastmasters' ), rsvpmaker_date( 'd' ), __( 'Year', 'rsvpmaker-for-toastmasters' ), rsvpmaker_date( 'Y' ) );

		submit_button( __( 'Save', 'rsvpmaker-for-toastmasters' ) );

		rsvpmaker_nonce();

		echo '</form></div><div id="add_speech_status"></div>';



		global $toast_roles;

		global $competent_leader;

		$projects  = get_advanced_projects();

		$role_list = '';

		foreach ( $toast_roles as $index => $role ) {

			$role_list .= '<option value="' . $index . '">' . $role . '</option>';

		}

		foreach ( $competent_leader as $role ) {

			$role_list .= '<option value="' . $role . '">' . $role . '</option>';

		}

		foreach ( $projects as $code => $role ) {

			$role_list .= '<option value="' . $code . '">' . $role . '</option>';

		}



		printf( '<div id="add_role_div"><h2>%s</h2><form id="add_role_form" method="post" action="%s"><input type="hidden" name="toastmaster" id="toastmaster" value="%d" /><input type="hidden" name="add_speech" value="1" />', __( 'Add Role' ), admin_url( 'admin.php?page=add_member_speech' ), $user_id );

		printf( '<p><select name="_role_meta" id="_role_meta">%s</select></p>', $role_list );

		printf( '<div>%s: <input name="project_month" id="role_month_add" size="4" value="%s" /> %s: <input name="project_day" id="role_day_add" size="4" value="%s" /> %s: <input name="role_year" id="role_year_add" size="8" value="%s" /></div>', __( 'Month', 'rsvpmaker-for-toastmasters' ), rsvpmaker_date( 'm' ), __( 'Day', 'rsvpmaker-for-toastmasters' ), rsvpmaker_date( 'd' ), __( 'Year', 'rsvpmaker-for-toastmasters' ), rsvpmaker_date( 'Y' ) );

		submit_button( __( 'Save', 'rsvpmaker-for-toastmasters' ) );

		rsvpmaker_nonce();

		echo '</form></div><div id="add_role_status"></div>';



	}



}



function tm_member_edit( $id = 0 ) {

	if ( ! $id ) {

		printf( '<form method="get" action="%s" id="tm_select_member_tab"><input type="hidden" id="tm_page" name="page" value="toastmasters_reports" />', admin_url( 'admin.php' ) );

		echo awe_user_dropdown( 'toastmaster', $user_id, true, __( 'Select Member', 'rsvpmaker-for-toastmasters' ) );

		echo '<button>' . __( 'Get', 'rsvpmaker-for-toastmasters' ) . '</button>';

		echo '<input type="hidden" name="active" class="tab" value="edit">';

		rsvpmaker_nonce();

		echo '</form>';

		?>

</section>

<section class="rsvpmaker"  id="edit_stats_count">

		<?php

		printf( '<form method="get" action="%s" id="tm_select_member_tab"><input type="hidden" id="tm_page" name="page" value="toastmasters_reports" />', admin_url( 'admin.php' ) );

		echo awe_user_dropdown( 'toastmaster', $user_id, true, __( 'Select Member', 'rsvpmaker-for-toastmasters' ) );

		echo '<button>' . __( 'Get', 'rsvpmaker-for-toastmasters' ) . '</button>';

		echo '<input type="hidden" name="active" class="tab" value="edit_stats">';

		rsvpmaker_nonce();

		echo '</form>';

		return;

	}

	global $wpdb;

	$wpdb->show_errors();

	$manuals = get_manuals_array();

	global $toast_roles;

	global $competent_leader;

	$projects = get_advanced_projects();



	$project_options_array = get_projects_array( 'options' );

	if ( isset( $_REQUEST['toastmaster'] ) && $_REQUEST['toastmaster'] ) {

		$id = (int) $_REQUEST['toastmaster'];

	}

	if ( $id ) {

		$userdata = get_userdata( $id );

		$tmstats  = get_tm_stats( $userdata->ID );

		$stats    = $tmstats['count'];



		if ( isset( $_REQUEST['debug'] ) ) {

			echo '<p>';

			print_r( $stats );

			echo '<br />Pure:';

			print_r( $tmstats['pure_count'] );

			echo '</p>';

		}

		echo '<h2>' . __( 'Edit Details', 'rsvpmaker-for-toastmasters' ) . ': ' . esc_html($userdata->first_name . ' ' . $userdata->last_name) . '</h2>';

		echo $tmstats['editdetail'];

		?>

</section>

<section class="rsvpmaker"  id="edit_stats_count">

		<?php

		if ( $_REQUEST['page'] == 'tm_member_edit' ) {

			tm_select_member( 'tm_member_edit', 'toastmaster' );

		}

		$hook = tm_admin_page_top( __( 'Edit Overview Stats', 'rsvpmaker-for-toastmasters' ) . ': ' . $userdata->first_name . ' ' . $userdata->last_name );



		if ( isset( $_POST['stat'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			$stats = $tmstats['pure_count'];

			if ( ! empty( $_POST['education_awards'] ) ) {

				update_user_meta( $id, 'education_awards', sanitize_text_field($_POST['education_awards']) );

			}

			foreach ( $_POST['stat'] as $field => $value ) {

				$field = sanitize_text_field($field);

				$value = sanitize_text_field($value);

				if ( ( $value == '' ) || ( $value == 0 ) ) {

					delete_user_meta( $id, 'tmstat:' . $field );

					continue;

				}

				if ( empty( $stats[ $field ] ) ) {

					$stats[ $field ] = 0;

				}

				$adj = $value - $stats[ $field ];

				if ( $adj == 0 ) {

					delete_user_meta( $id, 'tmstat:' . $field );

				} else {

					update_user_meta( $id, 'tmstat:' . $field, $adj );

				}

			}

			foreach ( $_POST['add_project'] as $manual => $p ) {

				if ( ! empty( $p ) ) {

					$manual = sanitize_text_field($manual);

					$p = sanitize_text_field($p);

					$projectslug = preg_replace( '/[ _]/', '', $manual ) . '_project';

					$year        = sanitize_text_field($_POST['project_year'][ $manual ]);

					$month       = sanitize_text_field($_POST['project_month'][ $manual ]);

					$day         = sanitize_text_field($_POST['project_day'][ $manual ]);

					if ( $year && $month && $day ) {

						$date = strtotime( $year . '-' . $month . '-' . $day );

					} else {

						$date = time();

					}

					$text = get_project_text( $p );

					$pa   = array(

						'title'  => $text,

						'date'   => $date,

						'source' => 'meta',

					);

					add_user_meta( $id, $projectslug, $pa );

				}

			}

			if ( isset( $_POST['delete_meta'] ) ) {

				foreach ( $_POST['delete_meta'] as $deletethis ) {

					$deletethis = str_replace( ' ', '_', sanitize_text_field($deletethis) );

					delete_user_meta( $id, $deletethis );



					echo "delete $deletethis <br />";

				}

			}



			echo '<div class="updated"><p>' . __( 'Updated', 'rsvpmaker-for-toastmasters' ) . '</p></div>';

		}



		// refresh the list now that changes have been posted

		$stats = awesome_get_stats( $userdata->ID );



		printf( '<form method="post" id="edit_member_stats" action="%s"><input type="hidden" name="action" value="edit_member_stats" /><input type="hidden" name="toastmaster" value="%s" />', admin_url( 'admin.php?page=' . sanitize_text_field($_REQUEST['page']) . '&toastmaster=' ) . $id, $id );



		echo '<table>';

		printf( '<tr><td>Educational Awards</td><td><input type="text" size="10" name="education_awards" value="%s"><br />Use the abbreviations CC,  ACB, ACS, ACG, CL, ALB, ALS, DTM</td><td></td></tr>', $userdata->education_awards );

		foreach ( $manuals as $role => $display ) {

			if ( strpos( $display, 'Manual/Path' ) ) { // don't include placeholder select manual field

				continue;

			}

			$stat     = ( isset( $stats[ $role ] ) ) ? $stats[ $role ] : 0;

			$pure     = ( isset( $tmstats['pure_count'][ $role ] ) ) ? $tmstats['pure_count'][ $role ] : 0;

			$difftext = ( $stat != $pure ) ? sprintf( 'detailed records: %s, adjustment: %s', $pure, ( $stat - $pure ) ) : '';

			printf( '<tr><td>%s</td><td><input type="text" size="4" name="stat[%s]" value="%s"></td><td>%s</td></tr>', $display, $role, $stat, $difftext );

		}

		foreach ( $toast_roles as $role ) {

			$stat     = ( isset( $stats[ $role ] ) ) ? $stats[ $role ] : 0;

			$pure     = ( isset( $tmstats['pure_count'][ $role ] ) ) ? $tmstats['pure_count'][ $role ] : 0;

			$difftext = ( $stat != $pure ) ? sprintf( 'detailed records: %s, adjustment: %s', $pure, ( $stat - $pure ) ) : '';

			printf( '<tr><td>%s</td><td><input type="text" size="4" name="stat[%s]" value="%s"></td><td>%s</td></tr>', $role, $role, $stat, $difftext );

		}

		foreach ( $competent_leader as $role ) {

			$stat     = ( isset( $stats[ $role ] ) ) ? $stats[ $role ] : 0;

			$pure     = ( isset( $tmstats['pure_count'][ $role ] ) ) ? $tmstats['pure_count'][ $role ] : 0;

			$difftext = ( $stat != $pure ) ? sprintf( 'detailed records: %s, adjustment: %s', $pure, ( $stat - $pure ) ) : '';

			printf( '<tr><td>%s</td><td><input type="text" size="4" name="stat[%s]" value="%s"></td><td>%s</td></tr>', $role, $role, $stat, $difftext );

		}

		echo '</table>';

		foreach ( $projects as $key => $project ) {

			$s = ( empty( $stats[ $key ] ) ) ? '' : ' checked="checked" ';

			printf( '<p><input type="checkbox" name="stat[%s]" value="1" %s> %s</p>', $key, $s, $project );

		}



		submit_button( 'Save Changes', 'primary', 'edit_stats' );

		rsvpmaker_nonce();

		printf( '<input type="hidden" name="edit" id="edit" value="%d"></form>', $id );



	}// edit member

	elseif ( isset( $_REQUEST['edit_all'] ) ) {

		$users = get_users();

		foreach ( $users as $user ) {

			$ud      = get_userdata( $user->ID );

			$tmstats = get_tm_stats( $user->ID );

			$listing[ $ud->last_name . $ud->first_name ] = '<h2>' . $ud->first_name . ' ' . $ud->last_name . "</h2>\n" . $tmstats['editdetail'];

		}

		ksort( $listing );

		echo implode( "\n", $listing );

	} else {

		printf( '<p><a href="%s">%s</a></p>', admin_url( 'admin.php?page=toastmasters_reports&edit_all#edit' ), __( 'Show editable data for all members', 'rsvpmaker-for-toastmasters' ) );

	}

	// tm_admin_page_bottom($hook);

}



function toastmasters_screen() {

	global $current_user;

	wpt_rsvpmaker_admin_heading(__('Toastmasters','rsvpmaker-for-toastmasters'),__FUNCTION__);

	awesome_dashboard_widget_function();

} // end toastmasters_screen



function wp4t_role_array() {

	global $toast_roles;

	$toast_roles = array(

		'Ah Counter' => __('Ah Counter','rsvpmaker-for-toastmasters'),

		'Body Language Monitor' => __('Body Language Monitor','rsvpmaker-for-toastmasters'),

		'Evaluator' => __('Evaluator','rsvpmaker-for-toastmasters'),

		'General Evaluator' => __('General Evaluator','rsvpmaker-for-toastmasters'),

		'Grammarian' => __('Grammarian','rsvpmaker-for-toastmasters'),

		'Humorist' => __('Humorist','rsvpmaker-for-toastmasters'),

		'Speaker' => __('Speaker','rsvpmaker-for-toastmasters'),

		'Topics Master' => __('Topics Master','rsvpmaker-for-toastmasters'),

		'Table Topics' => __('Table Topics','rsvpmaker-for-toastmasters'),

		'Timer' => __('Timer','rsvpmaker-for-toastmasters'),

		'Toastmaster of the Day' => __('Toastmaster of the Day','rsvpmaker-for-toastmasters'),

		'Vote Counter' => __('Vote Counter','rsvpmaker-for-toastmasters'),

		'Contest Master' => __('Contest Master','rsvpmaker-for-toastmasters'),

		'Chief Judge' => __('Chief Judge','rsvpmaker-for-toastmasters'),

		'Ballot Counter' => __('Ballot Counter','rsvpmaker-for-toastmasters'),

		'Evaluation Contestant' => __('Evaluation Contestant','rsvpmaker-for-toastmasters'),

		'Table Topics Contestant' => __('Table Topics Contestant','rsvpmaker-for-toastmasters'),

		'Humorous Contest Speaker' => __('Humorous Contest Speaker','rsvpmaker-for-toastmasters'),

		'International Contest Speaker' => __('International Contest Speaker','rsvpmaker-for-toastmasters'),

		'Tall Tales Contest Speaker' => __('Tall Tales Contest Speaker','rsvpmaker-for-toastmasters'),

	);

}



add_action('init','wp4t_role_array',15);



function wp4t_role_display ($role) {

	global $toast_roles;

	if(!empty($toast_roles[$role]))

		return $toast_roles[$role];

	return $role;

}



$competent_leader = array(

	'Help Organize a Club Speech Contest',

	'Help Organize a Club Special Event',

	'Help Organize a Club Membership Campaign or Contest',

	'Help Organize a Club PR Campaign',

	'Help Produce a Club Newsletter',

	'Assist the Club Webmaster',

	'Befriend a Guest',

	'PR Campaign Chair',

	'Mentor for a New Member',

	'Mentor for an Existing Member',

	'HPL Guidance Committee Member',

	'Membership Campaign Chair',

	'Club PR Campaign Chair',

	'Club Speech Contest Chair',

	'Club Special Event Chair',

	'Club Newsletter Editor',

	'Club Webmaster',

);



add_action( 'update_user_role_archive_all', 'update_user_role_archive_all' );

function update_user_role_archive_all() {

	$events = get_past_events('',5);

	foreach ( $events as $event ) {

		update_user_role_archive( $event->ID, $event->date );

		update_post_meta($event->ID,'role_data_archived',true);

	}

}



function awesome_get_stats( $user_id ) {

	$tmstats = get_tm_stats( $user_id );

	return $tmstats['count'];

}



add_shortcode( 'latest_manual_test', 'latest_manual_test' );



function latest_manual_test() {

	$output  = '';

	$members = get_club_members();

	foreach ( $members as $m ) {

		$l       = get_speaking_track( $m->ID );

		$output .= sprintf( '<p>%s %s</p>', $m->user_login, var_export( $l, true ) );

	}

	return $output;

}



function get_speaking_track( $user_id ) {

	if(is_null($user_id))

		return array();

	global $wpdb;

	global $current_user;

	$manuals  = get_manuals_options();

	$projects = get_projects_array( 'options' );

	$history_table = $wpdb->base_prefix.'tm_history';

	$speech_history_table = $wpdb->base_prefix.'tm_speech_history';

	

	$sql = "SELECT manual FROM `$history_table` JOIN `$speech_history_table` ON `$history_table`.id=`$speech_history_table`.history_id WHERE user_id=$user_id AND manual NOT LIKE 'Other%' ORDER BY datetime DESC";

	$manual = $wpdb->get_var($sql);

	if ( empty( $manual ) ) {

		$manual_type  = 'Path Not Set';

		$manual_label = 'Level 1 Mastering Fundamentals';

		$manual       = $manual_type . ' ' . $manual_label;

	} else {

		$parts = explode( ' Level ', $manual );

		if ( empty( $parts[1] ) ) {

			   $manual_type = 'Manual';

		} else {

			$manual_type = $parts[0];

		}

	}

		 return array(

			 'type'     => $manual_type,

			 'manual'   => $manual,

			 'projects' => $projects[ $manual ],

		 );

}



function get_latest_speeches( $user_id, $myroles = array() ) {

	global $wpdb;

	global $current_user;



	$wpdb->show_errors();

	$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, a1.date as datetime, a2.meta_key as speech

	 FROM " . $wpdb->posts . '

	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event

	 JOIN " . $wpdb->postmeta . ' a2 ON ' . $wpdb->posts . ".ID =a2.post_id AND a2.meta_key LIKE '_role_Speaker_%' AND a2.meta_value=" . $user_id . " 

	 WHERE a1.date < CURDATE() AND post_status='publish'

	 ORDER BY a1.date DESC";



	$speeches = $wpdb->get_results( $sql );



	$speech_array = array();

	$output       = '';

	if ( sizeof( $speeches ) ) {

		foreach ( $speeches as $s ) {

			$manual       = get_post_meta( $s->post_id, '_manual' . $s->speech, true );

			$project_key  = get_post_meta( $s->post_id, '_project' . $s->speech, true );

			$project_text = get_project_text( $project_key );

			if ( $manual ) {

				$parts = explode( ':', $manual );

				if ( ! empty( $parts[1] ) ) {

					$project_key = $project_text = $parts[1];

					if ( strpos( $parts[0], 'PETENT COMMUNICATION' ) ) {

						$manual = 'COMPETENT COMMUNICATION';

					} else {

						$manual = $parts[0];

					}

				}

			}

			$title  = get_post_meta( $s->post_id, '_title' . $s->speech, true );

			$action = admin_url( 'admin.php?page=' . sanitize_text_input($_REQUEST['page']) );

			if ( isset( $_REQUEST['toastmaster'] ) ) {

				$action .= '&toastmaster=' . (int) $_REQUEST['toastmaster'];

			}

			$field = $s->speech;

			$slug  = preg_replace( '/[^A-Za-z]/', '', $project_key ) . $s->post_id;

			if ( empty( $project ) || strpos( $project, 'hoose Manual' ) ) {

				$project = 'Project not recorded';

			}

			if ( ( current_user_can( 'edit_member_stats' ) ) || ( ( $user_id == $current_user->ID ) && current_user_can( 'edit_own_stats' ) ) ) {

				if ( empty( $project_key ) ) {

					$project_text = 'Choose Project';

					$project_key  = '';

				}

				$project_options  = sprintf( '<option value="%s">%s</option>', $project_key, $project_text );

				$pa               = get_projects_array( 'options' );

				$project_options .= $pa[ $manual ];

				$output          .= '<form method="post" action="' . $action . '" class="speech_update" id="' . $slug . '">

			<input type="hidden" name="post_id" value="' . $s->post_id . '" />

			<select class="speaker_details manual" name="_manual[' . $field . ']" id="_manual_' . $field . $s->post_id . '"">' . get_manuals_options( $manual ) . '</select><br /><select class="speaker_details project" name="_project[' . $field . ']" id="_project_' . $field . $s->post_id . '">' . $project_options . '</select>';

				$output          .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text' . $field . $s->post_id . '" name="_title[' . $field . ']" value="' . $title . '" /></div>';

				$output          .= rsvpmaker_nonce('return').'<button>Update</button></form>';

				$button           = sprintf( '<button class="edit_speech" slug="%s">Edit</button>', esc_attr($slug) ) . $output;

			} else {

				$button = '';

			}

			if ( $project_text == 'Choose Project' ) {

				$buff = sprintf( '<p>%s %s %s</p>', esc_html($manual), esc_html($title), $button );

			} else {

				$buff = sprintf( '<p>%s %s %s %s</p>', esc_html($manual), esc_html($project_text), esc_html($title), $button );

			}



			$ts                  = rsvpmaker_strtotime( $s->datetime );

			$speech_array[ $ts ] = ( empty( $speech_array[ $ts ] ) ) ? $buff : $speech_array[ $ts ] . $buff;

		}

	}



	$meta_speeches = get_user_meta( $user_id, 'Speaker' );

	if ( is_array( $meta_speeches ) ) {

		foreach ( $meta_speeches as $speech ) {

			$manual  = ( isset( $speech['manual'] ) ) ? $speech['manual'] : '';

			$ts      = ( isset( $speech['date'] ) ) ? (int) $speech['date'] : 0;

			$project = ( isset( $speech['project'] ) ) ? $speech['project'] : '';

			$title   = ( isset( $speech['speech_title'] ) ) ? $speech['speech_title'] : '';

			if ( ( current_user_can( 'edit_member_stats' ) ) || ( ( $user_id == $current_user->ID ) && current_user_can( 'edit_own_stats' ) ) ) {

				$button = sprintf( '<button class="remove_meta_speech" user_id="%d" project="%s">%s</button>', $user_id, $project, __( 'Remove', 'rsvpmaker-for-toastmasters' ) );

			} else {

				$button = '';

			}

			$buff                = sprintf( '<p>%s %s %s (%s) %s</p>', $manual, $project, $title, __( 'added', 'rsvpmaker-for-toastmasters' ), $button );

			$speech_array[ $ts ] = ( empty( $speech_array[ $ts ] ) ) ? $buff : $speech_array[ $ts ] . $buff;

		}

	}



	if ( empty( $speech_array ) ) {

		return;

	}



	global $rsvp_options;

	$buff = '<h2>Speech List</h2>';

	krsort( $speech_array );

	foreach ( $speech_array as $ts => $details ) {

		$buff .= '<h3>' . rsvpmaker_date( $rsvp_options['long_date'], $ts ) . '</h3>' . $details;

	}

	return $buff;

}



function toastmasters_reconcile() {

	rsvpmaker_admin_heading(__( 'Update Roles & Attendance', 'rsvpmaker-for-toastmasters' ), 'toastmasters_reconcile');

	global $wpdb, $post, $rsvp_options;

	$domain = $_SERVER['SERVER_NAME'];

	$history_table = $wpdb->base_prefix.'tm_history';

	update_user_role_archive_all();

	echo '<p><em>' . __( 'Use this form to reconcile and add to your record of roles filled at past meetings (members who signed up and did not attend and others who took roles at the last minute)', 'rsvpmaker-for-toastmasters' ) . '</em></p>';

	if(!empty($_POST['post_id'])) {

		$event_id = intval($_POST['post_id']);

		?>

		<p>If this information is now up to date, you have the option of creating meeting minutes that include this information. You'll be able to edit them and add further notes in the WordPress editor.</p>

		<?php

		printf('<p><a href="%s">Create Minutes</a></p>',admin_url("?draft=tmminutes&minutes_from_history=$event_id"));

	}



	echo '<style>.agenda_note{display: none;}</style>';



	if ( ! empty( $_POST['post_id'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$post_id = (int) $_POST['post_id'];

		update_post_meta( $post_id, '_reconciled', rsvpmaker_date( 'F j, Y' ) );

		do_action('toastmasters_update_history',$_POST);

		printf(

			'<div id="message" class="updated">

		<p><strong>%s. <a href="%s">%s</a></strong></p></div>',

			__( 'Reconciliation report updated', 'rsvpmaker-for-toastmasters' ),

			admin_url("post-new.php?post_type=tmminutes&minutes_from_history=$event_id"),

			__('Create Minutes','rsvpmaker-for-toastmasters')

		);



	}



	if ( ! empty( $_REQUEST['history'] ) ) {

		$r_post = get_post( intval($_REQUEST['history']) );

		printf( '<form action="%s" method="post">', admin_url( 'admin.php?page=toastmasters_reconcile&history=' . sanitize_text_field($_REQUEST['history']) ) );

		if ( ! isset( $nextdate ) ) {

			$nextdate = strtotime( '-1 year' );

		}

		$year  = rsvpmaker_date( 'Y', $nextdate );

		$month = rsvpmaker_date( 'n', $nextdate );

		$day   = rsvpmaker_date( 'j', $nextdate );

		echo '<p>Year <select name="year">';

		$yearback = (int) date( 'Y', strtotime( '-1 year' ) );

		$yearnow  = (int) date( 'Y' );

		for ( $i = $yearback; $i <= $yearnow; $i++ ) {

			$s = ( $i == $year ) ? ' selected="selected" ' : '';

			printf( '<option value="%d" %s>%d</option>', $i, $s, $i );

		}

		echo '<select> ';

		echo 'Month <select name="month">';

		for ( $i = 1; $i < 13; $i++ ) {

			$s = ( $i == $month ) ? ' selected="selected" ' : '';

			printf( '<option value="%d" %s>%d</option>', $i, $s, $i );

		}

		echo '<select> ';

		echo 'Day <select name="day">';

		for ( $i = 1; $i < 32; $i++ ) {

			$s = ( $i == $day ) ? ' selected="selected" ' : '';

			printf( '<option value="%d" %s>%d</option>', $i, $s, $i );

		}

		echo '<select></p>';



	} else {

		$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, date_format(a1.date,'%M %e, %Y') as date

	 FROM " . $wpdb->posts . '

	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event

	 WHERE a1.date < DATE_ADD('" . get_sql_now() . "',INTERVAL 5 HOUR) AND (post_status='publish' OR post_status='draft')  AND (post_content LIKE '%[toast%' OR post_content LIKE '%wp4toastmasters/role%') ORDER BY a1.date DESC";



		$results = $wpdb->get_results( $sql );

		if ( empty( $results ) ) {

			return 'No data';

		}

		$options = '';

		foreach ( $results as $row ) {

			$rdate = get_post_meta( $row->ID, '_reconciled', true );

			$s     = '';

			if ( isset( $_REQUEST['post_id'] ) && ( $row->ID == $_REQUEST['post_id'] ) ) {

				$s = ' selected="selected" ';

			}

			if ( $rdate ) {

				$r = " (reconciled $rdate)";

			} else {

				$r = '';

			}

			$options .= sprintf( '<option value="%d" %s>%s %s</option>', $row->ID, $s, $row->date, $r );

		}

		?>

<p><strong>Update Meeting Records</strong></p>

<form method="get" action="<?php echo admin_url( 'admin.php' ); ?>">

<input type="hidden" name="page" value="toastmasters_reconcile" />

<select id="pick_event" name="post_id">

		<?php echo $options; ?>

</select>

<br /><button><?php _e( 'Get', 'rsvpmaker-for-toastmasters' ); ?></button>

<?php rsvpmaker_nonce(); ?>

</form>



		<?php

		if ( isset( $_REQUEST['post_id'] ) ) {

			$id             = (int) $_REQUEST['post_id'];

			$r_post         = get_post( $id );

			$r_post->postID = $r_post->ID;

			$time           = get_rsvp_date( $id );

			$r_post->date   = rsvpmaker_date( $rsvp_options['long_date'], rsvpmaker_strtotime( $time ) );

		} else {

			$past   = get_past_events( " (post_content LIKE '%[toast%' OR post_content LIKE '%wp4toastmasters/role%') ", 1 );

			$r_post = $past[0];

		}

		printf( '<h2>%s</h2>', $r_post->date );

		printf( '<form action="%s" method="post">', admin_url( 'admin.php?page=toastmasters_reconcile' ) );

	} // not history



		if(isset($_POST['history_role_update'])) {

			foreach($_POST['history_role_update'] as $history_id => $user_id) {

				$was = $_POST['history_role_was'][$history_id];

				if($user_id != $was) {

					wpt_update_history_by_id($history_id, $user_id, $r_post->ID, $was);

				}

				if(isset($_POST['_manual'][$history_id]) && $user_id) {

					$manual = sanitize_text_field($_POST['_manual'][$history_id]);

					$project_key = sanitize_text_field($_POST['_project'][$history_id]);

					$title = stripslashes(sanitize_text_field($_POST['_title'][$history_id]));

					wpt_update_speech_history_by_id($history_id,$manual,$project_key,$title,$r_post->ID,$user_id);

				}

			}

		}



		if(isset($_POST['attended'])) {

			foreach($_POST['attended'] as $user_id) {

				wp4t_record_history_to_table($user_id, 'Attended', $r_post->datetime, $r_post->ID, 'toastmasters_reconcile');

			}

		}



		if(isset($_POST['history_add'])) {



			foreach($_POST['history_add'] as $index => $user_id) {

				$user_id = intval($user_id);

				$count = preg_replace('/[^0-9]/','',$index);

				$role = sanitize_text_field($_POST['history_add_role'][$index]);

				if($user_id) {

					$role = sanitize_text_field($_POST['history_add_role'][$index]);

					$manual = $project_key = $title = $speech_confirm = '';

					if(isset($_POST['history_add_manual'][$index])) {

						$manual = sanitize_text_field($_POST['history_add_manual'][$index]);

						$project_key = sanitize_text_field($_POST['history_add_project'][$index]);

						$title = stripslashes(sanitize_text_field($_POST['history_add_title'][$index]));

						$speech_confirm = sprintf('<p>%s %s %s</p>',$manual,$project_key,$title);

					}

					wp4t_record_history_to_table($user_id, $role, $r_post->datetime, $r_post->ID, 'toastmasters_reconcile', $manual,$project_key,$title,'', $_SERVER['SERVER_NAME'],$count);

					if(!empty($speech_confirm))

					echo '<div class="notice notice-success">'.$speech_confirm.'</div>';

				}

			}

		}



		$agenda_data = wpt_blocks_to_data($r_post->post_content);

		foreach($agenda_data as $index => $item) {

			if(!empty($item['role'])) {

				for($i=1; $i <= intval($item['count']); $i++)

				$allroles[wp4t_fieldbase($item['role'],$i)] = '';

				$agenda_order[$item['role']] = '';

			}

		}

		$additions = '';



		$attended = $role_holder = $present = array();

		$history_records = wpt_get_history_by_meeting(get_rsvp_date($r_post->ID));

	

		foreach($history_records as $record) {

			if(!in_array($record->user_id,$present))

				$present[] = $record->user_id;

			if($record->role == 'Attended') {

				if(!in_array($record->user_id,$attended))

					$attended[] = $record->user_id;

			}

			else {

				if(!in_array($record->user_id,$role_holder))

					$role_holder[] = $record->user_id;

			}

			$meta_index = '_role_'.str_replace(' ','_',$record->role).'_'.$record->rolecount;

			$dropdown = awe_user_dropdown( 'history_role_update['.$record->id.']', $record->user_id, true );

			$was = sprintf('<input type="hidden" name="history_role_was[%d]" value="%d">',$record->id,$record->user_id);

			if(empty($allroles[$meta_index]))

				$allroles[$meta_index] = '';

			$allroles[$meta_index] .= sprintf('<p><strong>%s</strong><br>%s %s</p>',$record->role,$dropdown,$was);

			if(!empty($record->speech_id)) {

				$allroles[$meta_index] .= new_speaker_details_history($record->history_id, $record->manual, $record->project_key, $record->project, $record->title );

			}

		}



		ksort($allroles);



		foreach($allroles as $index => $roleline) {

			$output = '';

			$role = trim(preg_replace('/[^A-Za-z]/',' ',$index));

			if(empty($roleline)) {

				$i = preg_replace('/[^0-9]/','',$index);

				$assigned = get_post_meta($r_post->ID,$index,true);

				$output .= '<p><strong>'.$role.'</strong> ';

				if(!empty($assigned) && (($assigned < '0') || !is_numeric($assigned)))

					$output .= sprintf('<em>Agenda shows %s</em>',get_member_name($assigned));

				$output .= '</p>';

				$dropdown = awe_user_dropdown( 'history_add['.$index.']', 0, true );

				$output .= sprintf('<p>%s <input type="hidden" name="history_add_role['.$index.']" value="%s"></p>',$dropdown, $role); 

				if($role == 'Speaker')

					$output .= add_speaker_details_history($i);

			}

			else {

				$output = $roleline;

			}

			if(isset($agenda_order[$role])) {

				$agenda_order[$role] .= $output;

			}

			else {

				$additions .= $output;

			}

		}



		echo implode("\n",$agenda_order).$additions;



		$roles = wpt_history_get_roles();

		if($roles) {

			$o = '<option value="">Choose Role</option>';

			foreach($roles as $role) {

				$o .= sprintf('<option value="%s">%s</option>',$role,$role);

			}

			$sql = "SELECT rolecount from $history_table WHERE domain='$domain' AND post_id=$r_post->ID ORDER BY rolecount DESC";

            $t = (int) $wpdb->get_var($sql);

            $t += 10;

			for($i = $t; $i < $t+5; $i++) {

				$dropdown = awe_user_dropdown( 'history_add['.$i.']', 0, true );

				printf('<p><strong>Add</strong> %s for <select name="history_add_role['.$i.']">%s</select></p>',$dropdown, $o); 

			}

			for($i = $t+5; $i < $t+8; $i++) {

				$dropdown = awe_user_dropdown( 'history_add['.$i.']', 0, true );

				printf('<p><strong>Add Speaker</strong><br>%s <input type="hidden" name="history_add_role['.$i.']" value="Speaker"></p>',$dropdown, $o); 

				echo add_speaker_details_history($i);

			}

		}



	$members   = array();

	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( ! empty( $present ) && in_array( $user->ID, $present ) ) {

			$email[] = $userdata->user_email;

			continue;

		}

		$index             = preg_replace( '/[^A-Za-z]/', '', $userdata->first_name . $userdata->last_name . $userdata->user_login );

		$members[ $index ] = $userdata;

	}

	ksort( $members );



	echo '<h2>' . __( 'Others attending', 'rsvpmaker-for-toastmasters' ) . '</h2>';



	$count = 0;

	foreach ( $members as $index => $userdata ) {

		if(in_array($userdata->ID,$present))

			continue;

		$att = sprintf( ' <input type="checkbox" name="attended[]" value="%d" />', $userdata->ID );

		if ( ( $count % 5 ) == 0 ) {

			echo '<br />';

		}

		$count++;

		printf( '%s %s %s', $att, $userdata->first_name, $userdata->last_name );

	}



	if ( ! empty( $role_holder ) ) {

		$marked_out = '<p>Held a role: ';

		foreach ( $role_holder as $index => $marked ) {

			$user = get_userdata( $marked );

			if ( $index ) {

				$marked_out .= ', ';

			}

			$marked_out .= esc_html($user->display_name);

		}

		echo $marked_out . '</p>';

	}



	if ( ! empty( $attended ) ) {

		$marked_out = '<p>No role but marked present: ';

		foreach ( $attended as $user_id ) {

			$marked_out .= esc_html(get_member_name($user_id)).', ';

		}

		echo $marked_out . '</p>';

	}



	submit_button( 'Save Changes', 'primary', 'edit_roles' );

	if ( isset( $_REQUEST['history'] ) ) {

		$post->ID = 0;

	}

	rsvpmaker_nonce();

	printf('<input type="hidden" name="post_id" value="%d"></form>',$r_post->ID);

	if ( ! empty( $email ) ) {

		$email_list = implode( ', ', $email );

		printf( '<p>Email attendees: <a href="mailto:%s">%s</a></p>', $email_list, $email_list );

	}



}



function toastmasters_minutes_exist($post_id) {

	global $wpdb;

	$sql = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='minutes_for' AND meta_value=$post_id";

	return $wpdb->get_var($sql);

}



function toastmasters_minutes_templates() {

global $current_user, $rsvp_options;

?>

<h1>Minutes Templates</h1>

<?php

if(isset($_POST['tid'])) {

	$new['post_content'] = get_the_content(null, false, intval($_POST['tid']));

	$new['post_title'] = sanitize_text_field(stripslashes($_POST['title']));

	$new['post_author'] = $current_user->ID;

	$new['post_type'] = 'tmminutes';

	$new['post_status'] = 'draft';

	if(isset($_POST['termids']))

		$new['tax_input'] = array('minutes-type' => explode(',',$_POST['termids']));

	$post_id = wp_insert_post($new);

	printf('<div class="notice notice-success"><p><strong>%s</strong> draft created: <a href="%s">Edit</a></p></div>',$new['post_title'],admin_url('post.php?action=edit&post='.$post_id));

}

?>

<p>You can designate one or more minutes documents to serve as templates for a board meeting or other meeting type. A template is simply an outline of the elements you expect to be included in meeting minutes.  An "Executive Board Minutes Template" (loosely based on one from Toastmasters International) is created by default as a starting point.</p>

<p>To prevent the template from appearing publicly, save it as a draft but do not publish it.</p>

<?php

$templates = get_option('toastmasters_minutes_templates');

if(empty($templates) || isset($_GET['reset'])) {

$new['post_title'] = 'Executive Board Minutes Template';

$new['post_content'] = '

<!-- wp:paragraph -->

<p>The Club Executive Committee convened on *Month Day, Year*, with *presiding officer* presiding. Officers present were: President, Vice President Education, Vice President Membership, Vice President Public Relations, Secretary, Treasurer, Sergeant at Arms. Officers absent were: *Officer Names*.</p>

<!-- /wp:paragraph -->



<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Minutes of the previous Executive Committee meeting were reviewed and approved.</li>

<!-- /wp:list-item --></ul>

<!-- /wp:list -->



<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Vice President Education provides report from Education Committee:<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Business Item 1</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Business Item 2</li>

<!-- /wp:list-item --></ul>

<!-- /wp:list --></li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Vice President Membership provides report from Membership Committee:<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Business Item 1</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Business Item 2</li>

<!-- /wp:list-item --></ul>

<!-- /wp:list --></li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Vice President Public Relations provides report from Public Relations Committee:<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Business Item 1</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Business Item 2</li>

<!-- /wp:list-item --></ul>

<!-- /wp:list --></li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Sergeant at Arms provides report from Social and Reception Committee:<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Business Item 1</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Business Item 2</li>

<!-- /wp:list-item --></ul>

<!-- /wp:list --></li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Additional committee reports provided by committee chair:<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Business Item 1</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Business Item 2</li>

<!-- /wp:list-item --></ul>

<!-- /wp:list --></li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Motions proposed to the committee requiring a vote:</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>*Officer Name* moved that “exact words after ‘I move that.’” The motion was adopted.</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>*Officer Name* moved that “exact words after ‘I move that.’” The motion was lost.</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>President/presiding officer discusses any unfinished and new items of Club Executive Committee:<!-- wp:list -->

<ul><!-- wp:list-item -->

<li>Business Item 1</li>

<!-- /wp:list-item -->



<!-- wp:list-item -->

<li>Business Item 2</li>

<!-- /wp:list-item --></ul>

<!-- /wp:list --></li>

<!-- /wp:list-item --></ul>

<!-- /wp:list -->



<!-- wp:paragraph -->

<p>Meeting adjourned at *Time*.</p>

<!-- /wp:paragraph -->



<!-- wp:columns -->

<div class="wp-block-columns"><!-- wp:column -->

<div class="wp-block-column"><!-- wp:spacer -->

<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>

<!-- /wp:spacer -->



<!-- wp:paragraph -->

<p></p>

<!-- /wp:paragraph -->



<!-- wp:separator -->

<hr class="wp-block-separator has-alpha-channel-opacity"/>

<!-- /wp:separator -->



<!-- wp:paragraph -->

<p>President</p>

<!-- /wp:paragraph --></div>

<!-- /wp:column -->



<!-- wp:column -->

<div class="wp-block-column"><!-- wp:spacer -->

<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>

<!-- /wp:spacer -->



<!-- wp:paragraph -->

<p></p>

<!-- /wp:paragraph -->



<!-- wp:separator -->

<hr class="wp-block-separator has-alpha-channel-opacity"/>

<!-- /wp:separator -->



<!-- wp:paragraph -->

<p>Date</p>

<!-- /wp:paragraph --></div>

<!-- /wp:column --></div>

<!-- /wp:columns -->



<!-- wp:columns -->

<div class="wp-block-columns"><!-- wp:column -->

<div class="wp-block-column"><!-- wp:spacer -->

<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>

<!-- /wp:spacer -->



<!-- wp:paragraph -->

<p></p>

<!-- /wp:paragraph -->



<!-- wp:separator -->

<hr class="wp-block-separator has-alpha-channel-opacity"/>

<!-- /wp:separator -->



<!-- wp:paragraph -->

<p>Secretary</p>

<!-- /wp:paragraph --></div>

<!-- /wp:column -->



<!-- wp:column -->

<div class="wp-block-column"><!-- wp:spacer -->

<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>

<!-- /wp:spacer -->



<!-- wp:paragraph -->

<p></p>

<!-- /wp:paragraph -->



<!-- wp:separator -->

<hr class="wp-block-separator has-alpha-channel-opacity"/>

<!-- /wp:separator -->



<!-- wp:paragraph -->

<p>Date</p>

<!-- /wp:paragraph --></div>

<!-- /wp:column --></div>

<!-- /wp:columns -->

';

$new['post_author'] = $current_user->ID;

$new['post_type'] = 'tmminutes';

$new['post_status'] = 'draft';

$post_id = wp_insert_post($new);

$templates = array($post_id);

update_option('toastmasters_minutes_templates',$templates);

}

elseif(isset($_POST['new_template_title'])) {

	$new['post_title'] = sanitize_text_field(stripslashes($_POST['new_template_title']));

	$new['post_content'] = '';

	$new['post_author'] = $current_user->ID;

	$new['post_type'] = 'tmminutes';

	$new['post_status'] = 'draft';

	$post_id = wp_insert_post($new);

	$templates[] = $post_id;

	update_option('toastmasters_minutes_templates',$templates);	

}

foreach($templates as $tid) {

	$title = get_the_title($tid);

	printf('<h2>%s</h2>',$title);

	printf('<p><a href="%s">Edit</a></p>',admin_url('post.php?action=edit&post='.$tid));

	$terms = wp_get_post_terms( $tid, array( 'minutes-type' ) );

foreach ( $terms as $term ) :

$termIds[] = $term->term_id;

echo $term->taxonomy .' '. $term->name.'<br />';

endforeach;

printf('<p>Create a minutes document based on <strong>%s</strong></p>

<form method="post" action="%s"><input type="hidden" name="tid" value="%d">',$title,admin_url('edit.php?post_type=tmminutes&page=toastmasters_minutes_templates'),$tid);

echo '<p>New Document Title:<br /><input type="text" name="title"></p>';

printf('<p>Example: <em>%s Executive Board Minutes for %s</em>',get_option('blogname'),rsvpmaker_date($rsvp_options['long_date']));

if(isset($termIds))

	printf('<input  type="hidden" name="termids" value="%s">',implode(',',$termIds));

submit_button('Create Draft');

echo '</form>';

}



printf('<h2>Create a New Minutes Template</h2>

<form method="post" action="%s">

Title <input type="text" name="new_template_title"></p>',admin_url('edit.php?post_type=tmminutes&page=toastmasters_minutes_templates'));

submit_button('Create New Template');

echo '</form>';



}



function toastmasters_minutes_help() {

	$minutes_archive = get_post_type_archive_link( 'tmminutes' );

?>

<h1>Toastmasters Meeting Minutes On Your Website</h1>

<p>You can record meeting minutes on the website to make them part of the permanent records of your club. Minutes documents can only be viewed by a logged in member of your club. To create a new minutes document for a board meeting or any other purpose, click <strong>Add New</strong> on the menu in this section.</p>

<p>If your club creates detailed minutes for each meeting, including speeches given and members present or absent, you can use the <a href="<?php echo admin_url('edit.php?post_type=tmminutes&page=toastmasters_meeting_minutes'); ?>">Minutes from Meeting Records</a> function to simplify that process.</p>

<p>The meeting listing can be viewed at <a href="<?php echo $minutes_archive; ?>"><?php echo $minutes_archive; ?></a>, and a link to it is at the top of the members dashboard. Optionally, you can add this link to the public menus of your website. However, website visitors who are not logged in or not members of the club will not see the contents of the minutes documents, only the headlines, followed by a login prompt.</p>

<?php

}



function toastmasters_meeting_minutes() {

	rsvpmaker_admin_heading(__( 'Minutes from Meeting Records', 'rsvpmaker-for-toastmasters' ), 'toastmasters_meeting_minutes');



	global $wpdb, $post, $rsvp_options, $current_user;

	if ( ! empty( $_REQUEST['history'] ) ) {

		$r_post = get_post( $_REQUEST['history'] );

		printf( '<form action="%s" method="post">', admin_url( 'admin.php?page=toastmasters_reconcile&history=' . sanitize_text_field($_REQUEST['history']) ) );

		if ( ! isset( $nextdate ) ) {

			$nextdate = strtotime( '-1 year' );

		}

		$year  = date( 'Y', $nextdate );

		$month = date( 'n', $nextdate );

		$day   = date( 'j', $nextdate );

		echo '<p>Year <select name="year">';

		$yearback = (int) date( 'Y', strtotime( '-10 year' ) );

		$yearnow  = (int) date( 'Y' );

		for ( $i = $yearback; $i <= $yearnow; $i++ ) {

				$s = ( $i == $year ) ? ' selected="selected" ' : '';

				printf( '<option value="%d" %s>%d</option>', $i, $s, $i );

		}

		echo '<select> ';

		echo 'Month <select name="month">';

		for ( $i = 1; $i < 13; $i++ ) {

				$s = ( $i == $month ) ? ' selected="selected" ' : '';

				printf( '<option value="%d" %s>%d</option>', $i, $s, $i );

		}

		echo '<select> ';

		echo 'Day <select name="day">';

		for ( $i = 1; $i < 32; $i++ ) {

				$s = ( $i == $day ) ? ' selected="selected" ' : '';

				printf( '<option value="%d" %s>%d</option>', $i, $s, $i );

		}

		echo '<select></p>';



	} else {

		$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, date_format(a1.date,'%M %e, %Y') as date

		 FROM " . $wpdb->posts . '

		 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event

		 WHERE a1.date < DATE_ADD('" . get_sql_now() . "',INTERVAL 5 HOUR) AND (post_status='publish' OR post_status='draft')  AND (post_content LIKE '%[toast%' OR post_content LIKE '%wp4toastmasters/role%') ORDER BY a1.date DESC";



		$results = $wpdb->get_results( $sql );

		if ( empty( $results ) ) {

			return 'No data';

		}

		$options = '';

		foreach ( $results as $row ) {

			$rdate = get_post_meta( $row->ID, '_reconciled', true );

			$s     = '';

			if ( isset( $_REQUEST['post_id'] ) && ( $row->ID == $_REQUEST['post_id'] ) ) {

				$s = ' selected="selected" ';

			}

			if ( $rdate ) {

				$r = " (reconciled $rdate)";

			} else {

				$r = '';

			}

			$options .= sprintf( '<option value="%d" %s>%s %s</option>', $row->ID, $s, $row->date, $r );

		}



if ( isset( $_REQUEST['post_id'] ) ) {

			$id             = (int) $_REQUEST['post_id'];

			$r_post         = get_post( $id );

			$r_post->postID = $r_post->ID;

			$time           = get_rsvp_date( $id );

			$r_post->date   = rsvpmaker_date( $rsvp_options['long_date'], strtotime( $time ) );

		} else {

			$past   = get_past_events( " (post_content LIKE '%[toast%' OR post_content LIKE '%wp4toastmasters/role%') ", 1 );

			$r_post = $past[0];

		}



	} // not history



	$minutes_content = wpt_minutes_from_history($r_post->ID);



	if(empty($_GET['rsvp_print'])) {

		?>

<p>Use this report to gather information recorded through the agenda and the <a href="<?php echo admin_url( 'admin.php?page=toastmasters_reconcile' ); ?>">Update History</a> screen for each meeting date. If your club publishes weekly meeting minutes, this gives you the raw data.</p>

	<form method="get" action="<?php echo admin_url( 'admin.php' ); ?>">

	<input type="hidden" name="page" value="toastmasters_meeting_minutes" />

	<select id="pick_event" name="post_id">

		<?php echo $options; ?>

	</select>

	<button><?php _e( 'Get', 'rsvpmaker-for-toastmasters' ); ?></button>

	<?php rsvpmaker_nonce(); ?>

	</form>

	

		<?php	

}



	if($r_post->ID && !isset($_REQUEST['rsvp_print'])) {

		printf( '<h2><a href="%s">Edit records for %s</a></h2>',admin_url('admin.php?page=toastmasters_reconcile&post_id='.$r_post->ID), $r_post->date );

		$existing = toastmasters_minutes_exist($r_post->ID);

		if($existing) {

			printf('<p><a href="%s">Edit existing minutes document for %s</a> | <a href="%s" target="_blank">Print or Copy and Paste to Word</a></p>',admin_url("post.php?post=$existing&action=edit"),$r_post->date,add_query_arg('print',1,get_permalink($existing)));

			$existing_post = get_post($existing);

			$minutes_content = do_blocks($existing_post->post_content);

		}

		else {

			printf('<p><a href="%s">Create minutes document for %s</a></p>',admin_url('?draft=tmminutes&minutes_from_history='.$r_post->ID),$r_post->date);

		}

	}



	echo $minutes_content;



if(empty($_GET['rsvp_print']))

	printf('<p><a href="%s">Make Corrections</a></p>',admin_url('admin.php?page=toastmasters_reconcile&post_id='.$r_post->ID.'&'.rsvpmaker_nonce('query')) );

}



add_action('admin_bar_menu', 'add_toolbar_items', 100);

function add_toolbar_items($admin_bar){

	global $post;

	if(isset($post->post_type) && 'tmminutes' == $post->post_type)

	{

		$admin_bar->add_menu( array(

			'id'    => 'email-minutes',

			'title' => __('Email Minutes','rsvpmaker-for-toastmasters'),

			'href'  => add_query_arg('send_by_email',1,get_permalink($post->ID)),

			'meta'  => array(

				'target'  => '_blank',

				'title' => __('Email_Minutes'),            

			),

		));	

		$admin_bar->add_menu( array(

			'id'    => 'print-minutes',

			'title' => __('Print','rsvpmaker-for-toastmasters'),

			'href'  => add_query_arg('print',1,get_permalink($post->ID)),

			'meta'  => array(

				'target'  => '_blank',

				'title' => __('Print'),           

			),

		));	

	}

}



function toastmaster_minutes_display( $atts ) {

	global $post;

	global $wpdb;

	$history_table = $wpdb->base_prefix.'tm_history';

	$speech_history_table = $wpdb->base_prefix.'tm_speech_history';

	$domain = $_SERVER['SERVER_NAME'];

	$start  = ( empty( $atts['start'] ) ) ? 1 : (int) $atts['start'];

	$count  = ( empty( $atts['count'] ) ) ? 1 : (int) $atts['count'];

	$role   = $atts['role'];

	$output = '';

	for ( $i = $start; $i < $count + $start; $i++ ) {

		$sql = $wpdb->prepare("SELECT * FROM $history_table WHERE domain=%s AND post_id=%d AND role=%s AND rolecount=%d ",$domain,$post->ID,$role,$i);

		$row = $wpdb->get_row($sql);

		if ( empty( $row ) ) {

			continue;

		}

		if(!$row->user_id)

			continue;

		$name = get_member_name( $row->user_id );

		if(empty($name) || empty($role))

			continue;

		$output .= sprintf( '<!-- wp:paragraph --><p><strong>%s:</strong> %s</p><!-- /wp:paragraph -->', $role, $name );

		if ( $role == 'Speaker' ) {

			$sql = "SELECT * FROM $speech_history_table WHERE history_id=$row->id ";

			$speech_row = $wpdb->get_row($sql);

			if(!empty($speech_row->manual) && !empty($speech_row->project))

			$manual = $speech_row->manual.': <span class="project">'.$speech_row->project.'</span>';

			$title   = ( empty( $speech_row->title) ) ? '' : '<span class="title">&quot;' . $speech_row->title . '&quot;</span> ';

			if(!empty($title) || !empty($manual))

				$output .= '<!-- wp:paragraph --><p>' . $title . '<span class="manual-project">' . $manual . '</span></p><!-- /wp:paragraph -->';

		}

	}

	return $output;

}



function toastmasters_attendance_report() {



	tm_reports_disclaimer();



	if ( is_admin() ) {



		if ( isset( $_GET['member'] ) ) {

			$user_id = (int) $_GET['member'];

			echo awesome_get_attendance_detail( $user_id );

		}



		if ( isset( $_REQUEST['start_month'] ) && $_REQUEST['start_month'] ) {

			$year     = (int) $_REQUEST['start_year'];

			$month    = (int) $_REQUEST['start_month'];

			$start    = sprintf( '&amp;start_year=%d&amp;start_month=%d', $year, $month );

			$startmsg = '';

		} else {

			$month    = 7;

			$year     = ( date( 'n' ) > 6 ) ? date( 'Y' ) : date( 'Y' ) - 1;

			$start    = '';

			$startmsg = ' <b>(not set)</b>';

		}

		?>

<form action="admin.php" method="get">

		<?php

		foreach ( $_GET as $name => $value ) {

			if ( ( $name != 'start_month' ) && ( $name != 'start_year' ) ) {

				printf( '<input type="hidden" name="%s" value="%s" />', $name, $value );

			}

		}

		?>

			

		<?php _e( 'Start Month', 'rsvpmaker-for-toastmasters' ); ?>: <input name="start_month" size="6" value="<?php echo esc_attr($month); ?>">

		<?php _e( 'Start Year', 'rsvpmaker-for-toastmasters' ); ?>: <input name="start_year"  size="6" value="<?php echo esc_attr($year); ?>">

<button><?php _e( 'Set', 'rsvpmaker-for-toastmasters' ); ?></button> <?php echo $startmsg; ?>

<?php rsvpmaker_nonce(); ?>

</form>

		<?php

	}



	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}

		$attendance[ $user->ID ] = awesome_get_attendance( $user->ID );

	}



	arsort( $attendance );



	echo '<table>';



	foreach ( $attendance as $user_id => $count ) {

		if ( empty( $user_id ) || ( $user_id == 0 ) ) {

			continue;

		}

		if ( ! isset( $d ) ) {

			$d = $count;

		}

		if ( $count > 0 ) {

			$bar = 500 * ( $count / $d );

			$bar = round( $bar );

		} else {

			$bar = 0;

		}

		if ( $bar > 20 ) {

			$barhtml = '<div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: ' . $bar . 'px"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">' . $count . '</span></div>';

		} else {

			$barhtml = '<div>' . esc_html($count) . '</div>';

		}



		$userdata = get_userdata( $user_id );



		echo '<tr><td>';

		printf( '<a href="%s&member=%d">', admin_url( 'admin.php?page=toastmasters_reports_dashboard&report=attendance'.$start ), intval($userdata->ID) );

		echo esc_attr($userdata->first_name);

		echo ' ';

		echo esc_attr($userdata->last_name);

		echo '</a></td><td>';

		echo $barhtml;

		echo '</td></tr>';

	}

	echo '</table>';

	// tm_admin_page_bottom($hook);

} // attendance report



function awesome_get_attendance_detail( $user_id ) {

	global $wpdb;

	global $rsvp_options;

	if ( isset( $_REQUEST['start_year'] ) && $_REQUEST['start_year'] ) {

		$year  = (int) $_REQUEST['start_year'];

		$month = (int) $_REQUEST['start_month'];

		if ( $month < 10 ) {

			$month = '0' . $month;

		}

		$start_date = " AND datetime > '" . $year . '-' . $month . "-01' ";

	} else {

		$start_date = '';

	}



	$results = wp4t_history_query("user_id=$user_id AND domain='".$_SERVER['SERVER_NAME']."' ".$start_date);

	$userdata = get_userdata( $user_id );

	$output   = sprintf( '<h2>%s %s</h2>', $userdata->first_name, $userdata->last_name );

	$dates    = array();

	foreach ( $results as $row ) {

		if ( ! in_array( $row->datetime, $dates ) ) {

			$dates[] = $row->datetime;

		}

	}

	sort( $dates );

	foreach ( $dates as $date ) {

		$t       = strtotime( $date );

		$output .= '<div>' . rsvpmaker_date( $rsvp_options['long_date'], $t ) . '</div>';

		$y       = date( 'Y', $t );

		if ( empty( $peryear[ $y ] ) ) {

			$peryear[ $y ] = 0;

		}

		$peryear[ $y ]++;

	}



	foreach ( $peryear as $year => $count ) {

		$output .= '<h3>' . $year . '</h3><div>' . $count . '</div>';

	}



	return $output;

}



function awesome_get_attendance( $user_id ) {

	global $wpdb;



	if ( isset( $_REQUEST['start_year'] ) && $_REQUEST['start_year'] ) {

		$year  = (int) $_REQUEST['start_year'];

		$month = (int) $_REQUEST['start_month'];

		if ( $month < 10 ) {

			$month = '0' . $month;

		}

		$start_date = " AND datetime > '" . $year . '-' . $month . "-01' ";

	} else {

		$start_date = '';

	}



	$appearances = array();

	$results     = wp4t_history_query( " user_id =$user_id AND domain='".$_SERVER['SERVER_NAME']."' ".$start_date );

	foreach ( $results as $row ) {

		if ( ! in_array( $row->post_id, $appearances ) ) {

			$appearances[] = $row->post_id;

		}

	}

	return sizeof( $appearances );

}



function get_speech_role_count( $user_id, $check_history = true ) {

	global $wpdb;

	$wpdb->show_errors();

	$counts = array();



	$count               = 0;

	$role_count_projects = array();



	$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, a1.date as datetime, a2.meta_key as manual

	 FROM " . $wpdb->posts . '

	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event

	 JOIN " . $wpdb->postmeta . ' a2 ON ' . $wpdb->posts . ".ID =a2.post_id AND a2.meta_key LIKE 'role_Speaker_%' AND a2.meta_value=" . $user_id . " 

	 WHERE a1.date < '" . get_sql_now() . "' AND post_status='publish'

	 ORDER BY a1.date DESC ";



	if ( isset( $_REQUEST['debug'] ) ) {

		echo esc_html($sql);

	}



	$results = $wpdb->get_results( $sql );

	if ( ! empty( $results ) ) {

		foreach ( $results as $row ) {

			$key         = '_manual' . $row->manual;

			$projectkey  = '_project' . $row->manual;

			$sql         = "SELECT meta_value FROM `$wpdb->postmeta` WHERE post_id=" . $row->post_id . " AND meta_key = '$key' ";

			$speech_role = $wpdb->get_var( $sql );

			if ( $speech_role ) {

				$parts = explode( ':', $speech_role );

				if ( strpos( $parts[0], 'PETENT COMMUNICATION' ) ) {

					$role = $manual = 'COMPETENT COMMUNICATION';

				} else {

					$role = $manual = $parts[0];

				}

			}

			$counts[ $role ] = isset( $counts[ $role ] ) ? $counts[ $role ] + 1 : 1;

			$project         = get_post_meta( $row->post_id, $projectkey, true );

			if ( ! empty( $project ) ) {

				$projectslug              = preg_replace( '/[ _]/', '', $role ) . '_project';

				$counts[ $projectslug ][] = array(

					'title'  => get_project_text( $project ),

					'date'   => strtotime( $row->datetime ),

					'source' => $row->post_id,

				);

			}

		}//end foreach

	}



	if ( isset( $_REQUEST['debug'] ) ) {

		print_r( $counts );

	}



	$manuals = get_manuals_array();



	// history - projects in user meta

	foreach ( $manuals as $role => $text ) {

			$projectslug = preg_replace( '/[ _]/', '', $role ) . '_project';

			$parray      = get_user_meta( $user_id, $projectslug );

		if ( ! empty( $parray ) ) {

			if ( empty( $counts[ $projectslug ] ) ) {

				$counts[ $projectslug ] = $parray;

			} else {

				$counts[ $projectslug ] = array_merge( $counts[ $projectslug ], $parray );

			}

			$counts[ $role ] = sizeof( $counts[ $projectslug ] );

		}

	}



	$meta_speeches = get_user_meta( $user_id, 'Speaker' );

	if ( is_array( $meta_speeches ) ) {

		foreach ( $meta_speeches as $speech ) {

			$manual                   = ( isset( $speech['manual'] ) ) ? $speech['manual'] : 'COMPETENT COMMUNICATION';

			$project                  = ( isset( $speech['project'] ) ) ? $speech['project'] : '';

			$date                     = ( isset( $speech['date'] ) ) ? $speech['date'] : '';

			$projectslug              = preg_replace( '/[ _]/', '', $manual ) . '_project';

			$counts[ $projectslug ][] = array(

				'title'  => $project,

				'date'   => $date,

				'source' => 'meta',

			);

			$counts[ $manual ]        = ( isset( $counts[ $manual ] ) ) ? $counts[ $manual ] + 1 : 1;

		}

	}



	return $counts;

}



function toastmasters_cc() {



	// if($_REQUEST["page"] == 'toastmasters_cc')

	// $hook = tm_admin_page_top(__('Competent Communicator Progress Report','rsvpmaker-for-toastmasters'));

	tm_reports_disclaimer();



	$ccs = array();

	global $wpdb;



	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}

		$stats             = get_tm_stats( $user->ID );

		$counts            = $stats['count'];

		$pure_counts       = $stats['pure_count'];

		$ccs[ $user->ID ]  = ( isset( $counts['COMPETENT COMMUNICATION'] ) ) ? $counts['COMPETENT COMMUNICATION'] : 0;

		$pure[ $user->ID ] = ( isset( $pure_counts['COMPETENT COMMUNICATION'] ) ) ? $pure_counts['COMPETENT COMMUNICATION'] : 0;

	}



	if ( isset( $_REQUEST['debug'] ) ) {

		echo '<br />CC array: ';

		print_r( $ccs );

	}

	arsort( $ccs );



	if ( ! isset( $_REQUEST['all'] ) ) {

		$datefilter = strtotime( '3 months ago' );

		printf( '<p><em>' . __( 'Filtered by default to show members active within the last 3 months (since %1$s) <a href="%2$s">(show all)', 'rsvpmaker-for-toastmasters' ) . '</a></em></p>', date( 'm/d/Y', $datefilter ), site_url( sanitize_text_field($_SERVER['REQUEST_URI']) ) . '&all=1' );

	}



	echo '<table>';



	foreach ( $ccs as $member => $count ) {

		$userdata = get_userdata( $member );

		if ( ! $userdata ) {

			continue;

		}



		$ts = strtotime( get_latest_visit( $userdata->ID ) );

		if ( $ts ) {

			$d = sprintf( '<br />' . __( 'Last attended', 'rsvpmaker-for-toastmasters' ) . ': %s', date( 'm/d/Y', $ts ) );

		} else {

			$d = '';

		}



		if ( ! isset( $_REQUEST['all'] ) ) {

			if ( $ts && ( $datefilter > $ts ) ) {

				continue;

			}

		}



		$barhtml = tm_barhtml( $count, 10 );

		echo '<tr><td><strong>';

		echo esc_html($userdata->first_name);

		echo ' ';

		echo esc_html($userdata->last_name);

		echo '</strong>' . $d . '</td><td>';

		echo $barhtml;

		if ( isset( $_REQUEST['debug'] ) && ( $count != $pure[ $member ] ) ) {

			printf( '<br />Detailed speech records: %d, adjusted total %d', $pure[ $member ], $count );

		}

		echo '<br />&nbsp;</td></tr>';

	}

	echo '</table>';



	// if($_REQUEST["page"] == 'toastmasters_cc')

	// tm_admin_page_bottom($hook);

}



function tm_barhtml( $count, $target ) {

	$barhtml = '';

	while ( $count > $target ) {

		$barhtml .= '<div style="width: 500px; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: 100%;"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">' . $target . '</span></div></div>';

		$count    = $count - $target;

	}



	$increment = 100 / $target;

	$bar       = $count * $increment;

	$barhtml  .= '<div style="width: 500px; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: ' . $bar . '%;"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">' . $count . '</span></div></div>';

	return $barhtml;

}



function toastmasters_advanced_user( $userdata, $showempty = false ) {

	$manuals                = get_manuals_array();

	$advanced_projects      = get_advanced_projects();

		$counts             = awesome_get_stats( $userdata->ID );

		$advanced_completed = 0;

		$user_id            = $userdata->ID;

		$progress           = '';

		$projects           = '';

	if ( $counts ) {

		foreach ( $counts as $manual => $count ) {

			if ( ! $count ) {

				continue;

			}

			if ( empty( $manual ) ) {

				continue;

			}

			if ( ( strpos( $manual, 'OMPETENT' ) ) || ( strpos( $manual, 'C Speeches' ) ) ) {

				continue;

			}

			if ( strpos( $manual, 'ETTER SPEAKER' ) || strpos( $manual, 'UCCESSFUL CLUB' ) || strpos( $manual, 'EADERSHIP EXCELLENCE' ) ) {

				continue;

			} elseif ( in_array( $manual, $manuals ) ) {

				$next      = '<div>' . $manuals[ $manual ] . tm_barhtml( $count, 5 ) . '</div>';

				$progress .= $next;

				if ( $count >= 5 ) {

					$advanced_completed++;

				}

			}

		}

	}



	if ( empty( $next ) && ! $showempty ) {

		return;

	}



	echo '<h3>' . esc_html($userdata->first_name . ' ' . $userdata->last_name) . '</h3>';

	echo wp_kses_post($progress);



	echo '<h4>' . __( 'Advanced Communicator Bronze', 'rsvpmaker-for-toastmasters' ) . '</h4>';

	$done = ( $advanced_completed >= 2 ) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : (int) $advanced_completed;

	echo '<p>' . __( 'Complete 2 advanced manuals', 'rsvpmaker-for-toastmasters' ) . ': ' . $done . '</p>';



	echo '<h4>' . __( 'Advanced Communicator Silver', 'rsvpmaker-for-toastmasters' ) . '</h4>';

	$done = ( $advanced_completed >= 4 ) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : (int) $advanced_completed;

	echo '<p>' . __( 'Complete 2 more advanced manuals (total 4)', 'rsvpmaker-for-toastmasters' ) . ': ' . $done . '</p>';

	echo '<p>' . __( 'Deliver 2 educational presentations', 'rsvpmaker-for-toastmasters' ) . '</p>';

	echo '<blockquote>';

	$ms = array(

		'BETTER SPEAKER SERIES'  => __( 'BETTER SPEAKER SERIES', 'rsvpmaker-for-toastmasters' ),

		'SUCCESSFUL CLUB SERIES' => __( 'SUCCESSFUL CLUB SERIES', 'rsvpmaker-for-toastmasters' ),

	);



	foreach ( $ms as $manual => $display ) {

		if ( empty( $counts[ $manual ] ) ) {

			$counts[ $manual ] = 0;

		}

		printf( '<p>%s: %s</p>', $display, $counts[ $manual ] );

		$project = preg_replace( '/[ _]/', '', $manual ) . '_project';

		if ( isset( $counts[ $project ] ) ) {

			echo '<ul>';

			$project_array = $counts[ $project ];

			foreach ( $project_array as $project_row ) {

				$t = (int) $project_row['date'];

				printf( '<li>%s - %s</li>', $project_row['title'], rsvpmaker_date( 'F jS, Y', $t ) );

			}

			echo '</ul>';

		}

	}

	echo '<p>' . __( 'Note: Successful Club series projects can also be applied to Advanced Leader Bronze (but same the project cannot be counted twice)', 'rsvpmaker-for-toastmasters' ) . '</p>';

	echo '</blockquote>';



	foreach ( $advanced_projects as $key => $project ) {

		if ( strpos( $key, 'CS' ) ) {

			$plus = '';// (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';



			$done = ( ! empty( $counts[ $key ] ) ) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> ' . $plus;

			printf( '<p>%s: %s</p>', $project, $done );

		}

	}



	echo '<h4>' . __( 'Advanced Communicator Gold', 'rsvpmaker-for-toastmasters' ) . '</h4>';

	$done = ( $advanced_completed >= 6 ) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : (int) $advanced_completed;

	echo '<p>' . __( 'Complete 2 more advanced manuals (6 total)', 'rsvpmaker-for-toastmasters' ) . ': ' . $done . '</p>';

	foreach ( $advanced_projects as $key => $project ) {

		if ( strpos( $key, 'CG' ) ) {

			$plus = '';// (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';



			$done = ( ! empty( $counts[ $key ] ) ) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> ' . $plus;

			printf( '<p>%s: %s</p>', $project, $done );

		}

	}



	echo '<h4>' . __( 'Advanced Leader Bronze', 'rsvpmaker-for-toastmasters' ) . '</h4>';

	echo '<p>' . __( 'Deliver 2 educational presentations', 'rsvpmaker-for-toastmasters' ) . '</p>';

	echo '<blockquote>';

	$ms = array(

		'SUCCESSFUL CLUB SERIES'       => __( 'SUCCESSFUL CLUB SERIES', 'rsvpmaker-for-toastmasters' ),

		'LEADERSHIP EXCELLENCE SERIES' => __( 'LEADERSHIP EXCELLENCE SERIES', 'rsvpmaker-for-toastmasters' ),

	);



	foreach ( $ms as $manual => $display ) {

		if ( empty( $counts[ $manual ] ) ) {

			$counts[ $manual ] = 0;

		}

		printf( '<p>%s: %s</p>', $display, $counts[ $manual ] );



		$project = preg_replace( '/[ _]/', '', $manual ) . '_project';

		if ( isset( $counts[ $project ] ) ) {

			echo '<ul>';

			$project_array = $counts[ $project ];

			foreach ( $project_array as $project_row ) {

				$t = (int) $project_row['date'];

				printf( '<li>%s - %s</li>', $project_row['title'], rsvpmaker_date( 'F jS, Y', $t ) );

			}

			echo '</ul>';

		}

	}

	echo '<p>' . __( 'Note: Successful Club series projects can also be applied to Advanced Communicator Silver (but the same project cannot be counted twice)', 'rsvpmaker-for-toastmasters' ) . '</p>';

	echo '</blockquote>';



	foreach ( $advanced_projects as $key => $project ) {

		if ( strpos( $key, 'LB' ) ) {

			$plus = '';// (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';

			$done = ( ! empty( $counts[ $key ] ) ) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> ' . $plus;

			printf( '<p>%s: %s</p>', $project, $done );

		}

	}



	echo '<h4>' . __( 'Advanced Leader Silver', 'rsvpmaker-for-toastmasters' ) . '</h4>';

	foreach ( $advanced_projects as $key => $project ) {

		if ( strpos( $key, 'LS' ) ) {

			$plus = ''; // (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';

			$done = ( ! empty( $counts[ $key ] ) ) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> ' . $plus;

			printf( '<p>%s: %s</p>', $project, $done );

		}

	}

}



function toastmasters_advanced() {

	// if($_REQUEST["page"] == 'toastmasters_advanced')

	// $hook = tm_admin_page_top(__('Advanced Award Progress','rsvpmaker-for-toastmasters'));

	tm_reports_disclaimer( '<em>This report is still under development.</em>' );



	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}



		$index             = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );

		$members[ $index ] = $userdata;

	}



	ksort( $members );

	foreach ( $members as $userdata ) {

		toastmasters_advanced_user( $userdata );

	} // end for each member



	/*

	II. Advanced Communicator Silver (ACS)

	4 Received Advanced Communicator Bronze

	(Or received Able Toastmaster award or __________________________________________________________

	Advanced Toastmaster Bronze award)

	4 Completed two Advanced Communication manuals.

	(Attach Project Completion Record from each manual.)

	4 Conducted two presentations from The Better Speaker Series and/or The Successful Club Series. (Success/Communication,

	Success/Leadership, Youth Leadership workshops and The Leadership Excellence Series do not qualify.) Presentation date may

	not be one used previously.

	Presentation Name Date Presented

	1. _________________________________________________________________________________________________

	2. _________________________________________________________________________________________________

	III. Advanced Communicator Gold (ACG)

	4 Received Advanced Communicator Silver

	(Or received Able Toastmaster Bronze or __________________________________________________________

	Advanced Toastmaster Silver)

	4 Completed two Advanced Communication manuals.

	(Attach Project Completion Record from each manual.)

	4 Coordinated and conducted one Success/Communication, Success/Leadership or Youth Leadership workshop. (The Better

	Speaker Series, The Successful Club Series, and The Leadership Excellence Series do not qualify.) Presentation date may not be

	one used previously.

	Workshop Name Date Presented

	______________________________________________________________________________________________________________

	4 Coached a new member with his or her first three speeches.

	Name of New Member New Member Number (if known) Year Coached

	_____________________________________________



	I. Advanced Leader Bronze (ALB)

	4 Achieved Competent Leader (CL) award

	for completing Competent Leadership manual Date ______________ Club/District No. ___________________

	4 Achieved Competent Communicator (CC) award

	(or achieved Competent Toastmaster award) Date ______________ Club/District No. ___________________

	4 Served at least six months* as a club officer (president, vice president education, vice president membership,

	vice president public relations, secretary, treasurer, or sergeant at arms) and participated in the preparation of a

	Club Success Plan while serving in this office.

	(*You must have served as an officer from July 1 through December 31 or January 1 through June 30 to fulfill this requirement. Other six-month

	periods do not qualify. The six months must be completed at the time you submit this application.)

	Office held ______________________________________________________________ in Club No. _______________

	Served six months as follows (check one and fill in year)

	______ July 1 – December 31, ______ ______ January 1 – June 30, ______

	Date you helped prepare a Club Success Plan for your club ________________________ ____________

	(must coincide with above officer term)

	4 While serving in above officer term, participated in a district-sponsored club-officer training program.

	(Applicants in undistricted clubs need not complete this requirement.)

	Date attended training _________________________________________________________________________________

	DTM APPLICANTS MUST PROVIDE A STREET ADDRESS, NOT A P. O. BOX

	MONTH YEAR

	REQUIRED FOR DTM APPLICATIONS

	TO APPLY:

	You must be a current member of the club listed below at the time your application is received at World

	Headquarters to be eligible for the award.

	4 Complete both sides of this application.

	4 A current club officer must sign and date the application.

	4 Ask a current club officer to submit your application online at www.toastmasters.org/members.

	If no current officer has online access, mail OR fax (one method only please) the completed form to:

	Member Services - Education Awards Fax: 949.858.1207

	Toastmasters International

	P.O. Box 9052, Mission Viejo, CA 92690 USA

	PLEASE PRINT OR TYPE (AS YOU WOULD LIKE IT TO APPEAR ON CERTIFICATE)

	LLLLLLLL

	4 Conducted two presentations from The Successful Club Series and/or The Leadership Excellence Series. (Success/Communication, Success/

	Leadership, Youth Leadership and The Better Speaker Series do not qualify.) Presentation date may not be one used previously.

	Presentation Name Date Presented

	1. _________________________________________________________________________________________________

	2. _________________________________________________________________________________________________

	II. Advanced Leader Silver (ALS)

	4 Received Advanced Leader Bronze award

	(or “old” Competent Leader award)

	4 Served a complete term* (July 1 – June 30) as a district officer (district governor, lieutenant governor, public relations officer,

	secretary, treasurer, division governor, area governor). (Applicants in undistricted clubs need not complete this requirement.)

	(*Term must be completed at the time you submit this application.)

	Office held ______________________________________________________________ District No. _______________

	Date served (fill in years) July 1, ____________ through June 30, ____________

	4 Completed the High Performance Leadership program.

	Club No. __________________ Certificate No. ____________________________ Date Received_____________________

	4 Served successfully as sponsor* (up to two allowed) or mentor** (up to two allowed, appointed by the district governor) of a

	new club. Name must appear on Application to Organize (Form 1).

	(*Members are successful sponsors when the new club charters and sends World Headquarters a letter from the charter president verifying that the

	sponsor performed his/her duties. World Headquarters must receive this letter no later than 90 days after the club charter date.)

	(**Members are successful mentors after they have worked with the new club for at least six months following its charter and the new club charter

	president sends World Headquarters a letter verifying that the mentor performed his/her duties for those six months.)

	*/



	// if($_REQUEST["page"] == 'toastmasters_advanced')

	// tm_admin_page_bottom($hook);

}



function get_advanced_projects() {

	$projects = array(

		'ACG1' => 'ACG: Coordinated and conducted one Success/Communication, Success/Leadership or Youth Leadership workshop',

		'ACG2' => 'ACG: Coached a new member with his or her first three speeches',

		'ALB1' => 'ALB: Served at least six months as a club officer',

		'ALB2' => 'ALB: Participated in a district-sponsored club-officer training program',

		'ALS1' => 'ALS: Served a complete term as a district officer',

		'ALS2' => 'ALS: Completed High Performance Leadership Program',

		'ALS3' => 'ALS: Served successfully as sponsor or mentor of a new club',

	);

	return $projects;

}



add_action( 'wp_ajax_increment_stat', 'wp_ajax_increment_stat' );



function wp_ajax_increment_stat() {

	if(!wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')))

		die('nonce security');	

	$role    = 'tmstat:' . sanitize_text_field($_POST['role']);

	$user_id = (int) $_POST['user_id'];

	$stat    = (int) get_user_meta( $user_id, $role, true );

	$stat++;

	update_user_meta( $user_id, $role, $stat );

	die( '+1 ' . sanitize_text_field($_POST['role']) );

}



function roledates_text( $datesarray ) {

	if ( sizeof( $datesarray ) > 5 ) {

		$buff  = ' ' . array_shift( $datesarray );

		$buff .= ', ' . array_shift( $datesarray );

		$end   = array_pop( $datesarray );

		$buff .= ' ... ' . array_pop( $datesarray ) . ', ' . $end;

		return $buff;

	} else {

		return ' ' . implode( ', ', $datesarray );

	}

}



function is_requirement_met( $user_id, $choices, $goal, $echo = true, $roledates = array() ) {

	global $myroles;

	$score = 0;



	foreach ( $choices as $choice ) {

		if ( ( $score < $goal ) && isset( $myroles[ $choice ] ) && ( $myroles[ $choice ] > 0 ) ) {

			$myroles[ $choice ]--;

			$score++;

			if ( $echo ) {

				echo '<div><span style="color: green; font-weight: bold">(x)</span> ' . $choice;

			}

			if ( ! empty( $roledates[ $choice ] ) ) {

				echo roledates_text( $roledates[ $choice ] );

			}

			echo "</div>\n";

		} elseif ( $echo ) {

			echo '<div>' . $choice;

			// if(current_user_can('edit_member_stats'))

				// echo increment_stat_button($user_id, $choice );

			if ( ! empty( $roledates[ $choice ] ) ) {

				echo roledates_text( $roledates[ $choice ] );

			}

			echo "</div>\n";

		}

	}

	if ( $score >= $goal ) {

		if ( $echo ) {

			echo '<div><span style="color: green; font-weight: bold">' . __( 'Goal Met!', 'rsvpmaker-for-toastmasters' ) . '</span>' . "</div>\n";

		}

		return true;

	} else {

		return false;

	}

}



function cl_report() {



	// $hook = tm_admin_page_top(__('Competent Leader Progress Report','rsvpmaker-for-toastmasters'));

	tm_reports_disclaimer( '<em>Member strategy for matching activities with projects may differ from the automated method used for this report.</em>' );



	global $project_gaps;



	$cl_leaders = array();

	$nocl       = array();

	$text2      = array();



	echo '

<style>

td {vertical-align: text-top;}

td.project, th.project, td.name, th.name {

width: 150px;

}

</style>

';



	if ( ! isset( $_REQUEST['all'] ) ) {

		$datefilter = strtotime( '3 months ago' );

		printf( __( '<p><em>Filtered by default to show members active within the last 3 months (since %1$s) <a href="%2$s">(show all)</a></em></p>', 'rsvpmaker-for-toastmasters' ), rsvpmaker_date( 'm/d/Y', $datefilter ), site_url( sanitize_text_field($_SERVER['REQUEST_URI']) ) . '&all=1' );

	}



	$text = '';



	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}

		if ( preg_match( '/[LD]/', $userdata->education_awards ) ) {

			continue;

		}

		$ts = strtotime( get_latest_visit( $userdata->ID ) );

		if ( $ts ) {

			$d = sprintf( '<br />' . __( 'Last attended', 'rsvpmaker-for-toastmasters' ) . ': %s', rsvpmaker_date( 'm/d/Y', $ts ) );

		} else {

			$d = '';

		}



		if ( ! isset( $_REQUEST['all'] ) ) {

			if ( $ts && ( $datefilter > $ts ) ) {

				continue;

			}

		}



		ob_start();

		$completed = cl_progress( $userdata );

		if ( $completed ) {

			$text[ $user->ID ]          = ob_get_clean();

			$cl_leaders[ $completed ][] = $userdata;

		} else {

			$text2[ $userdata->last_name . $userdata->first_name ] = ob_get_clean();

			$nocl[ $userdata->last_name . $userdata->first_name ]  = '<a href="#' . $userdata->ID . '">' . $userdata->first_name . ' ' . $userdata->last_name . '</a>';

		}

	}



	krsort( $cl_leaders );

	ksort( $nocl );

	ksort( $text2 );



	$output = $table2 = '';

	foreach ( $cl_leaders as $count => $users ) {



		foreach ( $users as $user ) {

			$output .= $text[ $user->ID ];



			$table2 .= '<tr><td>' . $count . '</td>' . $project_gaps[ $user->ID ] . '</tr>';

		}

	}



	echo '<table><tr><th>#</th><th class="name">Name</th><th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 1</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 2</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 3</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 4</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 5</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 6</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 7</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 8</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 9</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . " 10</th>

</tr>

$table2

</table>";



	echo '<h3>None</h3>';

	echo '<div>' . implode( '<br />', $nocl ) . '</div>';



	echo $output . implode( $text2 );



	// tm_admin_page_bottom($hook);

}



function cl_progress( $userdata ) {



	global $myroles;

	global $project_gaps;

	if ( empty( $project_gaps[ $userdata->ID ] ) ) {

		$project_gaps[ $userdata->ID ] = '';

	}

	printf( '<h2 id="%d">%s %s</h2>', $userdata->ID, $userdata->first_name, $userdata->last_name );

	$project_gaps[ $userdata->ID ] .= sprintf( '<td class="name"><a href="#%s">%s %s</a></td>', $userdata->ID, $userdata->first_name, $userdata->last_name );



	$tmstats   = get_tm_stats( $userdata->ID );

	$myroles   = $tmstats['count'];

	$roledates = $tmstats['roledates'];



	$completed = 0;



	echo '<h3>' . __( 'PROJECT 1: Listening', 'rsvpmaker-for-toastmasters' ) . '<br />

' . __( 'COMPLETE 3 OF 4', 'rsvpmaker-for-toastmasters' ) . '</h3>';



	$choices = array(

		'Ah Counter',

		'Grammarian',

		'Table Topics',

		'Evaluator',

	);

	$goal    = 3;

	$met     = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>' . __( 'Listening: 3 OF 4', 'rsvpmaker-for-toastmasters' ) . '</td>';

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . sprintf( '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Listening: 3 OF 4', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 2: Critical Thinking', 'rsvpmaker-for-toastmasters' ) . '<br />

 ' . __( 'COMPLETE 2 OF 3', 'rsvpmaker-for-toastmasters' ) . '</h3>';



	$choices = array(

		'Grammarian',

		'General Evaluator',

		'Evaluator',

	);



	$goal = 2;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>' . sprintf( '%s</td>', __( 'Critical Thinking: 2 OF 3', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Critical Thinking: 2 OF 3', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 3: Giving Feedback', 'rsvpmaker-for-toastmasters' ) . '<br />

' . __( 'COMPLETE 3 OF 3', 'rsvpmaker-for-toastmasters' ) . '</h3>';



	$choices = array(

		'Grammarian',

		'General Evaluator',

		'Evaluator',

	);



	$goal = 3;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '%s</td>', __( 'Feedback: 3 OF 3', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Feedback: 3 OF 3', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 4: Time Management', 'rsvpmaker-for-toastmasters' ) . '<br />

  ' . __( 'COMPLETE TIMER', 'rsvpmaker-for-toastmasters' ) . '</h3>';

	$choices = array(

		'Timer',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	echo '<h3>+1 ' . __( 'Other', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";



	$choices = array(

		'Grammarian',

		'Speaker',

		'Topics Master',

		'Toastmaster of the Day',

	);



	$goal = 1;

	$met2 = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met && $met2 ) {

		$completed++;

		echo '<h4 style="color: green;">Project Complete</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>' . sprintf( '%s</td>', __( 'Timer + One Other', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( $met ) {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">' . __( 'Goal 1', 'rsvpmaker-for-toastmasters' ) . '</div></div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'DONE Timer TO DO + One Other', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( $met2 ) {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">' . __( 'Goal 2', 'rsvpmaker-for-toastmasters' ) . '</div></div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'TO DO Timer DONE + One Other', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Timer + One Other', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 5: Planning and Implementation', 'rsvpmaker-for-toastmasters' ) . '<br />

  ' . __( 'COMPLETE 3 OF 4', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";



	$choices = array(

		'Speaker',

		'Topics Master',

		'General Evaluator',

		'Toastmaster of the Day',

	);



	$goal = 3;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>' . sprintf( '%s</td>', __( 'Planning & Implementation: 3 OF 4', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Planning & Implementation: 3 OF 4', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 6: Organization and Delegation', 'rsvpmaker-for-toastmasters' ) . '<br />

  ' . __( 'COMPLETE 1 OF 6', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";



	$choices = array(

		'Help Organize a Club Speech Contest',

		'Help Organize a Club Special Event',

		'Help Organize a Club Membership Campaign or Contest',

		'Help Organize a Club PR Campaign',

		'Help Produce a Club Newsletter',

		'Assist the Club’s Webmaster',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '%s</td>', __( 'Organization & Delegation: 1 of 6', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">TO DO</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Organization & Delegation: 1 of 6', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 7: Facilitation', 'rsvpmaker-for-toastmasters' ) . '<br />

  ' . __( 'COMPLETE 2 OF 4', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";



	$choices = array(

		'Befriend a Guest',

		'General Evaluator',

		'Topics Master',

		'Toastmaster of the Day',

	);



	$goal = 2;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '%s</td>', __( 'Facilitation: 2 OF 4', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">TO DO</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Facilitation: 2 of 4', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 8: Motivation', 'rsvpmaker-for-toastmasters' ) . '<br />

  ' . __( 'COMPLETE 1 CHAIR', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";



	$choices = array(

		'Membership Campaign Chair',

		'Club Speech Contest Chair',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	echo '<h3> +2 ' . __( 'OTHERS', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";



	$choices = array(

		'Evaluator',

		'General Evaluator',

		'Toastmaster of the Day',

		'PR Campaign Chair',

	);



	$goal = 2;

	$met2 = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met && $met2 ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '%s</td>', __( 'Motivation: Chair + 1 Other', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( $met ) {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">' . __( 'Goal 1', 'rsvpmaker-for-toastmasters' ) . '</div></div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'DONE Chair TO DO + One Other', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( $met2 ) {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">Goal 2</div></div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'TO DO Chair DONE + One Other', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Motivation: Chair + 1 Other', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 9: Mentoring', 'rsvpmaker-for-toastmasters' ) . '<br />

  ' . __( 'COMPLETE 1 OF 3', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";



	$choices = array(

		'Mentor for a New Member',

		'Mentor for an Existing Member',

		'HPL Guidance Committee Member',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>' . sprintf( '%s</td>', __( 'Mentoring: 1 of 3', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Mentoring: 1 of 3', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<h3>' . __( 'PROJECT 10: Team Building', 'rsvpmaker-for-toastmasters' ) . '<br />

  ' . __( 'COMPLETE TOASTMASTER + GENERAL EVALUATOR', 'rsvpmaker-for-toastmasters' ) . '</h3>';



	$choices = array(

		'Toastmaster of the Day',

		'General Evaluator',

	);



	$goal = 2;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	echo '<h3>' . __( 'OR 1 OF THE FOLLOWING', 'rsvpmaker-for-toastmasters' ) . '</h3>';



	$choices = array(

		'Membership Campaign Chair',

		'Club PR Campaign Chair',

		'Club Speech Contest Chair',

		'Club Special Event Chair',

		'Club Newsletter Editor',

		'Club Webmaster',

	);



	$goal = 1;

	$met2 = is_requirement_met( $userdata->ID, $choices, $goal, true, $roledates );



	if ( $met || $met2 ) {

		$completed++;

		echo '<h4 style="color: green;">' . __( 'Project Complete', 'rsvpmaker-for-toastmasters' ) . '</h4>';

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>' . sprintf( '%s</td>', __( 'Team Building', 'rsvpmaker-for-toastmasters' ) );

	} else {

		$project_gaps[ $userdata->ID ] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<a href="#%s">%s</a></td>', $userdata->ID, __( 'Team Building', 'rsvpmaker-for-toastmasters' ) );

	}



	return $completed;

}



function cl_project_gaps( $userdata ) {



	printf( '<tr><td class="name">%s %s</td>', $userdata->first_name, $userdata->last_name );



	$myroles = awesome_get_stats( $userdata->ID );



	$completed = 0;



	$choices = array(

		'Ah Counter',

		'Evaluator',

		'Grammarian',

		'Table Topics',

	);

	$goal    = 3;

	$met     = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met ) {

		$completed++;

		echo '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>' . __( 'Listening: 3 OF 4', 'rsvpmaker-for-toastmasters' ) . '</td>';

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Listening: 3 OF 4', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Grammarian',

		'Evaluator',

		'General Evaluator',

	);



	$goal = 2;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>%s</td>', __( 'Critical Thinking: 2 OF 3', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">TO DO</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Critical Thinking: 2 OF 3', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Grammarian',

		'Evaluator',

		'General Evaluator',

	);



	$goal = 3;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>%s</td>', __( 'Feedback: 3 OF 3', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Feedback: 3 OF 3', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Timer',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	$choices = array(

		'Grammarian',

		'Speaker',

		'Topics Master',

		'Toastmaster of the Day',

	);



	$goal = 1;

	$met2 = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met && $met2 ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>%s</td>', __( 'Timer + One Other', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( $met ) {

		printf( '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red;  color: #fff;">%s</div></div><a href="#%s">%s</a></td>', __( 'Goal 1', 'rsvpmaker-for-toastmasters' ), $userdata->ID, 'DONE Timer TO DO + One Other' );

	} elseif ( $met2 ) {

		printf( '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">%s</div></div><a href="#%s">%s</a></td>', __( 'Goal 2', 'rsvpmaker-for-toastmasters' ), $userdata->ID, 'TO DO Timer DONE + One Other' );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Timer + One Other', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Speaker',

		'Topics Master',

		'General Evaluator',

		'Toastmaster of the Day',

	);



	$goal = 3;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>%s</td>', __( 'Planning & Implementation: 3 OF 4', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Planning & Implementation: 3 OF 4', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Help Organize a Club Speech Contest',

		'Help Organize a Club Special Event',

		'Help Organize a Club Membership Campaign or Contest',

		'Help Organize a Club PR Campaign',

		'Help Produce a Club Newsletter',

		'Assist the Club’s Webmaster',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>%s</td>', __( 'Organization & Delegation: 1 of 6', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Organization & Delegation: 1 of 6', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'General Evaluator',

		'Topics Master',

		'Toastmaster of the Day',

		'Befriend a Guest',

	);



	$goal = 2;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>%s</td>', __( 'Facilitation: 2 OF 4', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Facilitation: 2 of 4', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Membership Campaign Chair',

		'Club Speech Contest Chair',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	$choices = array(

		'PR Campaign Chair',

		'Evaluator',

		'General Evaluator',

		'Toastmaster of the Day',

	);



	$goal = 2;

	$met2 = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met && $met2 ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>%s</td>', __( 'Motivation: Chair + 1 Other', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( $met ) {

		printf( '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red;  color: #fff;">' . __( 'Goal 1', 'rsvpmaker-for-toastmasters' ) . '</div></div><a href="#%s">%s</a></td>', $userdata->ID, __( 'DONE Chair TO DO + One Other', 'rsvpmaker-for-toastmasters' ) );

	} elseif ( $met2 ) {

		printf( '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red;  color: #fff;">' . __( 'Goal 2', 'rsvpmaker-for-toastmasters' ) . '</div></div><a href="#%s">%s</a></td>', $userdata->ID, __( 'TO DO Chair DONE + One Other', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Motivation: Chair + 1 Other', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Mentor for a New Member',

		'Mentor for an Existing Member',

		'HPL Guidance Committee Member',

	);



	$goal = 1;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>%s</td>', __( 'Mentoring: 1 of 3', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Mentoring: 1 of 3', 'rsvpmaker-for-toastmasters' ) );

	}



	$choices = array(

		'Toastmaster of the Day',

		'General Evaluator',

	);



	$goal = 2;

	$met  = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	$choices = array(

		'Membership Campaign Chair',

		'Club PR Campaign Chair',

		'Club Speech Contest Chair',

		'Club Special Event Chair',

		'Club Newsletter Editor',

		'Club Webmaster',

	);



	$goal = 1;

	$met2 = is_requirement_met( $userdata->ID, $choices, $goal, false, $roledates );



	if ( $met || $met2 ) {

		$completed++;

		printf( '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' . __( 'Done!', 'rsvpmaker-for-toastmasters' ) . '</div>%s</td>', __( 'Team Building', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __( 'TO DO', 'rsvpmaker-for-toastmasters' ) . '</div><a href="#%s">%s</a></td>', $userdata->ID, __( 'Team Building', 'rsvpmaker-for-toastmasters' ) );

	}



	return $completed;

}









function get_latest_visit( $user_id ) {

	global $wpdb;

	$wpdb->show_errors();



	$sql  = 'SELECT DISTINCT a1.date as datetime

	 FROM ' . $wpdb->posts . '

	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event

	 JOIN " . $wpdb->postmeta . ' a2 ON ' . $wpdb->posts . '.ID =a2.post_id AND a2.meta_value=' . $user_id . " AND a2.meta_key LIKE '_role_%'  

	 WHERE a1.date < '" . get_sql_now() . "' 

	 ORDER BY a1.date DESC";

	$date = $wpdb->get_var( $sql );

	if ( $date ) {

		return date( 'Y-m-d', strtotime( $date ) );

	} else {

		return 'N/A';

	}

}



function last_filled_role( $user_id, $role ) {

	global $wpdb, $rsvp_options, $post;

	if ( empty( $post->ID ) ) {

		return;

	}

	$histories = get_post_meta( $post->ID, '_histories', true );

	if ( ! $histories ) {

		return;

	}

	$role = clean_role( $role );

	if ( empty( $histories[ $user_id ] ) ) {

		return;

	}

	$held = $histories[ $user_id ]->get_last_held( $role );

	if ( $held ) {

		$result = array(

			'index' => date( 'Y-m-d', strtotime( $held ) ),

			'text'  => '<br />' . __( 'Last held role', 'rsvpmaker-for-toastmasters' ) . ': ' . $held,

		);

	} else {

		$result = array(

			'index' => '0000',

			'text'  => '?',

		);

	}

	return $result;

}



function toastmasters_mentors() {



	$hook = tm_admin_page_top( __( 'Mentors', 'rsvpmaker-for-toastmasters' ) );



	if ( isset( $_POST['mentor'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST['mentor'] as $user_id => $mentor ) {

			if ( ! empty( $mentor ) ) {

					update_user_meta( (int) $user_id, 'mentor', sanitize_text_field($mentor) );

			}

		}



		echo '<div id="message" class="updated">

		<p><strong>' . __( 'Mentor list updated', 'rsvpmaker-for-toastmasters' ) . '</strong></p>

	</div>';



	}



	if ( isset( $_REQUEST['edit'] ) ) {

		printf( '<h2><a class="add-new-h2" href="%s">%s</a></h2>', admin_url( 'admin.php?page=toastmasters_mentors' ), __( 'Return to Report', 'rsvpmaker-for-toastmasters' ) );

	} else {

		printf( '<h2><a class="add-new-h2" href="%s">%s</a></h2>', admin_url( 'admin.php?page=toastmasters_mentors&edit=1' ), __( 'Edit', 'rsvpmaker-for-toastmasters' ) );

	}



	echo '<p>Mentor: Mentee(s)</p>';



	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}

		$ts = strtotime( get_latest_visit( $user->ID ) );

		if ( ! isset( $_REQUEST['all'] ) ) {

			if ( $ts && ( $datefilter > $ts ) ) {

				continue;

			}

		}



		$index             = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );

		$members[ $index ] = $userdata;

	}



	if ( empty( $members ) ) {

		return;

	}

	ksort( $members );



	if ( isset( $_REQUEST['edit'] ) && current_user_can( 'edit_others_rsvpmakers' ) ) {

		printf( '<form action="%s" method="post">', admin_url( 'admin.php?page=toastmasters_mentors&edit=1' ) );

	}



	foreach ( $members as $userdata ) {

		if ( isset( $_REQUEST['edit'] ) && current_user_can( 'edit_others_rsvpmakers' ) ) {

			printf( '<p>%s %s: <input type="text" name="mentor[%d]" value="%s" /></p>', $userdata->first_name, $userdata->last_name, $userdata->ID, $userdata->mentor );

		} else {

			printf( '<p>%s %s: %s</p>', $userdata->first_name, $userdata->last_name, $userdata->mentor );

		}

	}



	if ( isset( $_REQUEST['edit'] ) && current_user_can( 'edit_others_rsvpmakers' ) ) {

		rsvpmaker_nonce();

		echo '<button>' . __( 'Save', 'rsvpmaker-for-toastmasters' ) . '</button></form>';

	}



	tm_admin_page_bottom( $hook );

}



function toastmasters_edit_stats() {



	$hook = tm_admin_page_top( __( 'Edit Member Stats', 'rsvpmaker-for-toastmasters' ) );



	global $wpdb;

	global $toast_roles;

	global $competent_leader;



	$tasks = '<option value="">' . __( 'Choose a Project', 'rsvpmaker-for-toastmasters' ) . '</option>';

	foreach ( $competent_leader as $task ) {

		$tasks .= sprintf( '<option value="%s">%s</option>', $task, $task );

	}

	?>

<style>

td,th {

border: thin solid #000;

text-align:center;	

	}

th.role {

	min-width: 90px;

	max-width: 100px;

	overflow: hidden;

	text-overflow: ellipsis;

	white-space: nowrap;



}

</style>

	<?php

	echo '<div class="wrap"><h2>' . __( 'Edit Member Stats', 'rsvpmaker-for-toastmasters' ) . '</h2>';

	if ( isset( $_POST['newstat'] ) && $_POST['newstat'] && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$wpdb->show_errors();

		foreach ( $_POST['newstat'] as $user_id => $newroles ) {

			foreach ( $newroles as $role => $count ) {

				$role = sanitize_text_field($role);

				$count = sanitize_text_field($count);

				$oldcount = (int) $_POST['oldstat'][ $user_id ][ $role ];

				if ( ! is_numeric( $count ) ) {

					update_user_meta( $user_id, $role, $count );

				} elseif ( $count != $oldcount ) {

					$adjustment = $count - $oldcount;

					$sql        = sprintf( "INSERT into %s SET user_id=%d, role='%s', quantity=%d, datetime=CURDATE() ", $wpdb->prefix . 'toastmasters_history', $user_id, $role, $adjustment );

					$wpdb->show_errors();

					$wpdb->query( $sql );

				}

			}

		}



		if ( isset( $_POST['editcl'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			foreach ( $_POST['editcl'] as $user_id => $cl_updates ) {

				foreach ( $cl_updates as $role ) {

					$role = sanitize_text_field($role);

					if ( ! empty( $role ) ) {

						$sql = sprintf( "INSERT into %s SET user_id=%d, role='%s', quantity=1, datetime=CURDATE() ", $wpdb->prefix . 'toastmasters_history', $user_id, $role );

						$wpdb->show_errors();

						$wpdb->query( $sql );

					}

				}

			}

		}



		printf(

			'<div id="message" class="updated">

		<p><strong>%s.</strong></p>

	</div>',

			__( 'Member stats updated', 'rsvpmaker-for-toastmasters' )

		);



	}



	printf( '<form action="%s" method="post">', admin_url( 'admin.php?page=toastmasters_edit_stats' ) );



	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}

		$index                  = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );

		$members[ $index ]      = $userdata;

		$achievements[ $index ] = awesome_get_stats( $userdata->ID );

	}



	$l = '<table class="wp-list-table widefat fixed posts" ><tr><th  class="role">' . __( 'COMPETENT COMMUNICATION', 'rsvpmaker-for-toastmasters' ) . '</th>';

	foreach ( $toast_roles as $role ) {

		if ( $role == 'Topics Master' ) {

			$role = 'TT Master';

		}

		$l .= '<th class="role">' . $role . '</th>';

	}

	$l .= '</tr>';



	ksort( $members );



	$ed = '';

	foreach ( $members as $index => $userdata ) {

		$myroles = $achievements[ $index ];

		printf( '<h3 id="%d">%s %s - <a href="%s">' . __( 'View', 'rsvpmaker-for-toastmasters' ) . '</a></h3>', intval($userdata->ID), esc_html($userdata->first_name), esc_html($userdata->last_name), admin_url( 'admin.php?page=toastmasters_reports&toastmaster=' ) . intval($userdata->ID) );

		echo $l;

		echo '<tr><td>';

			printf( '<input type="text" name="newstat[%d][%s]" value="%d" size="2" />', intval($userdata->ID), 'COMPETENT COMMUNICATION', $myroles['COMPETENT COMMUNICATION'] );

		if ( $myroles['COMPETENT COMMUNICATION'] ) {

			printf( '<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />', intval($userdata->ID), 'COMPETENT COMMUNICATION', $myroles['COMPETENT COMMUNICATION'] );

		}

		echo '</td>';

		foreach ( $toast_roles as $role ) {

				echo '<td>';

				printf( '<input type="text" name="newstat[%d][%s]" value="%d" size="2" />', intval($userdata->ID), esc_attr($role), esc_attr($myroles[ $role ]) );

			if ( $myroles[ $role ] ) {

				printf( '<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />', intval($userdata->ID), esc_attr($role), esc_attr($myroles[ $role ]) );

			}

				echo '</td>';

		}

		echo '</tr>';

		echo '</table>';

		$cl = array();

		foreach ( $competent_leader as $role ) {

			if ( isset( $myroles[ $role ] ) ) {

				$cl[] = $role;

			}

		}

		if ( sizeof( $cl ) ) {

			echo '<p>CL Projects: ';

			echo implode( ', ', $cl );

			echo '</p>';

		}



				printf(

					'<p><b>' . __( 'Additonal Competent Leader Credits for', 'rsvpmaker-for-toastmasters' ) . ' %s %s</b></p>

				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>

				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>

				',

					$userdata->first_name,

					$userdata->last_name,

					$userdata->ID,

					$tasks,

					$userdata->ID,

					$tasks,

					$userdata->ID,

					$tasks,

					$userdata->ID,

					$tasks

				);



	}



	submit_button();

	tm_admin_page_bottom( $hook );

}



function import_fth() {



	$hook = tm_admin_page_top( __( 'Import Free Toast Host Data', 'rsvpmaker-for-toastmasters' ) );



	?>

	<?php

	global $wpdb;

	global $toast_roles;



	$action = admin_url( 'admin.php?page=import_fth' );



	if ( isset( $_POST['speeches'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$fth_roles = array();

		?>

<form action="<?php echo esc_attr($action); ?>" method="post">

		<?php



		echo '<h3>' . __( 'Match Users', 'rsvpmaker-for-toastmasters' ) . '</h3><p>' . __( 'Either match with a WordPress user or leave blank (Match?) if there is no match, as with a former member.', 'rsvpmaker-for-toastmasters' ) . '</p>';



		$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

		foreach ( $blogusers as $user ) {

			$userdata = get_userdata( $user->ID );

			if ( $userdata->hidden_profile ) {

				continue;

			}

			$index                     = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );

			$members[ $index ]         = $userdata;

			$users_id[ $userdata->ID ] = sprintf( '<option value="%s">%s %s</option>', $userdata->ID, $userdata->first_name, $userdata->last_name );

		}

		ksort( $members );



		$userlist = '<option value="">Match?</option>';

		foreach ( $members as $userdata ) {

			$userlist .= sprintf( '<option value="%s">%s %s</option>', $userdata->ID, $userdata->first_name, $userdata->last_name );

		}



		if ( isset( $_POST['speeches'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {



			$lines = explode( "\n", sanitize_textarea_field($_POST['speeches'] ));

			foreach ( $lines as $index => $line ) {

				$cells = explode( "\t", $line );

				// echo "<h2>Line: $index </h2>";

				if ( sizeof( $cells ) == 6 ) {

					$name = array_shift( $cells );

					// echo "<h1>$name</h1>";

					$name                = trim( $name );

					$nameindex           = preg_replace( '/[^A-Za-z]/', '', $name );

					$names[ $nameindex ] = $name;

				}

				// print_r($cells);

				$speech['name'][ $nameindex ][]    = $name;

				$name                              = preg_replace( '/, [A-Z]{2,4}/', '', $name );

				$speech['date'][ $nameindex ][]    = trim( $cells[0] );

				$speech['project'][ $nameindex ][] = trim( $cells[3] );

				$speech['title'][ $nameindex ][]   = trim( $cells[2] . ' ' . $cells[4] );

			}

		}

		if ( isset( $_POST['stats'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

			$lines = explode( "\n", sanitize_textarea_field($_POST['stats']) );

			foreach ( $lines as $index => $line ) {

				$cells = explode( "\t", $line );

				if ( sizeof( $cells ) == 3 ) {

					$name                = array_shift( $cells );

					$name                = trim( $name );

					$nameindex           = preg_replace( '/[^A-Za-z]/', '', $name );

					$names[ $nameindex ] = $name;

				}

				$stats['date'][ $nameindex ][] = $cells[0];

				$stats['role'][ $nameindex ][] = $cells[1];

			}

			ksort( $names );

			foreach ( $names as $nameindex => $name ) {

				$p        = explode( ' ', trim( $name ) );

				$sql      = "SELECT user_id from $wpdb->usermeta WHERE meta_key='first_name' AND meta_value LIKE '" . $p[0] . "%'";

				$results  = $wpdb->get_results( $sql );

				$matching = '';

				foreach ( $results as $r ) {

					$matching .= $users_id[ $r->user_id ];

				}

				printf( '<p><select name="user[%s]">%s</select> = %s</p>', $nameindex, $matching . $userlist, $name );

			}



			foreach ( $stats['date'] as $nameindex => $daterow ) {

				// print_r($namerow);

				foreach ( $daterow as $i => $date ) {

					$t           = strtotime( $date );

					$dates[ $t ] = $t;

					$name        = $names[ $nameindex ];

					$role        = $stats['role'][ $nameindex ][ $i ];

					$role        = trim( preg_replace( '/ #[0-9]/', '', $role ) );

					if ( $role == 'Speaker' ) {

						continue; // track speakers through project list instead

					}

					if ( ! in_array( $role, $fth_roles ) ) {

						$fth_roles[] = $role;

					}

					printf( '<input type="hidden" name="role[%s][%s]" value="%s" />', $t, $nameindex, $role );

				}

			}

		}



		echo '<h3>Match Roles</h3>';

		sort( $fth_roles );

		foreach ( $fth_roles as $role ) {

			$options = '<option value="">Match?</option>';



			foreach ( $toast_roles as $tracked ) {

				$s = ( $role == $tracked ) ? ' selected="selected" ' : '';

				if ( ( $role == 'Toastmaster' ) && ( $tracked == 'Toastmaster of the Day' ) ) {

					$s = ' selected="selected" ';

				}

				if ( ( $role == 'Topic Master' ) && ( $tracked == 'Topics Master' ) ) {

					$s = ' selected="selected" ';

				}

				if ( ( $role == 'Table Topics Contestant' ) && ( $tracked == 'Table Topics' ) ) {

					$s = ' selected="selected" ';

				}



				$options .= sprintf( '<option value="%s" %s> %s</option>', $tracked, $s, $tracked );

			}

			printf( '<p><select name="rolelist[%s]">%s</select> = %s</p>', $role, $options, $role );

		}



		echo '<h3>Speech Projects</h3>';

		$project_options = get_toast_speech_options();

		foreach ( $speech['name'] as $nameindex => $namerow ) {

			// print_r($namerow);

			foreach ( $namerow as $i => $name ) {

				$date        = $speech['date'][ $nameindex ][ $i ];

				$t           = strtotime( $date );

				$dates[ $t ] = $t;

				$project     = $speech['project'][ $nameindex ][ $i ];

				$title       = $speech['title'][ $nameindex ][ $i ];

				printf(

					'<p>' . __( 'Member', 'rsvpmaker-for-toastmasters' ) . ': %s ' . __( 'Date', 'rsvpmaker-for-toastmasters' ) . ': <input type="text" name="speechdate[%s][]" value="%s"> <br />' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ': <select name="project[%s][%s]"><option value="%s">%s</option>%s</select>

			<br />Title: <input type="text" name="title[%s][%s]" value="%s"></p>',

					$name,

					$nameindex,

					$date,

					$t,

					$nameindex,

					$project,

					$project,

					$project_options,

					$t,

					$nameindex,

					$title

				);

			}

		}



		printf( '<input type="hidden" name="dates" value="%s" />', implode( ',', $dates ) );



		submit_button( __( 'Import Records (step 2)', 'rsvpmaker-for-toastmasters' ), 'primary' );

		rsvpmaker_nonce();

		?>

</form>

		<?php

	} elseif ( isset( $_POST['dates'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {



		printf( '<h3>' . __( 'Recording data. Verify by checking', 'rsvpmaker-for-toastmasters' ) . ' <a href="%s">' . __( 'Toastmaster Reports', 'rsvpmaker-for-toastmasters' ) . '</a>.</h3>', admin_url( 'admin.php?page=toastmasters_reports' ) );

		foreach ( $_POST['user'] as $nameindex => $id ) {

			if ( $id ) {

				$nameindex = sanitize_text_field($nameindex);

				$users[ $nameindex ] = (int) $id;

			}

		}



		$dates = explode( ',', sanitize_text_field($_POST['dates']) );

		sort( $dates );

		foreach ( $dates as $date ) {

			$t = (int) $date;

			if ( $t == 0 ) {

				continue;

			}

			$sqldate = date( 'Y-m-d H:i:s', $t );



			$p       = array(

				'post_title'   => __( 'Historical Data', 'rsvpmaker-for-toastmasters' ),

				'post_type'    => 'historical-toastmsters-data',

				'post_content' => __( 'used to track events imported from Free Toast Host. Do not delete.', 'rsvpmaker-for-toastmasters' ),

				'post_status'  => 'publish',

			);

			$post_id = wp_insert_post( $p );



			add_rsvpmaker_date( $post_id, $sqldate );



			if ( is_array( $_POST['project'][ $date ] ) ) {

					$count = 1;

				foreach ( $_POST['project'][ $date ] as $nameindex => $project ) {

					$nameindex = sanitize_text_field($nameindex);

					$project = sanitize_text_field($project);

					if ( isset( $users[ $nameindex ] ) ) {

						$user_id  = sanitize_text_field($users[ $nameindex ]);

						$meta_key = '_role_Speaker_' . $count;

						update_post_meta( $post_id, $meta_key, $user_id );

						$count++;

						if ( empty( $project ) ) {

							continue;

						}

						update_post_meta( $post_id, '_manual' . $meta_key, $project );

						$title = sanitize_text_field($_POST['title'][ $date ][ $nameindex ]);

						if ( ! empty( $title ) ) {

							// echo "title: $title <br />";

							update_post_meta( $post_id, '_title' . $meta_key, $project );

						}

					}

				}

			}

			if ( is_array( $_POST['role'][ $date ] ) ) {

				foreach ( $_POST['role'][ $date ] as $nameindex => $role ) {

					if ( $_POST['rolelist'][ $role ] ) {

						$role = sanitize_text_field($_POST['rolelist'][ $role ]);

					} else {

						continue;

					}

					if ( isset( $users[ $nameindex ] ) ) {

						$user = $users[ $nameindex ];

						update_post_meta( $post_id,wp4t_fieldbase($role,1), $user_id );

					}

				}

			}

		}

	} else { // step 1 form

		?>

<form action="<?php echo esc_attr($action); ?>" method="post">

<h3><?php _e( 'Paste in the contents of', 'rsvpmaker-for-toastmasters' ); ?> ...</h3>

		<?php _e( 'Member Speech Historical Report', 'rsvpmaker-for-toastmasters' ); ?>:<br />

<textarea name="speeches" cols="100" rows="10"></textarea>

<br />

		<?php _e( 'Member Role Historical Report', 'rsvpmaker-for-toastmasters' ); ?>:<br />

<textarea name="stats" cols="100" rows="10"></textarea>

		<?php submit_button( __( 'Import Records (step 1)', 'rsvpmaker-for-toastmasters' ), 'primary' ); ?>

		<?php rsvpmaker_nonce(); ?>

</form>

<div style="max-width: 605px;">

<h1>Directions</h1>

<p>This tool allows you to import some of the data collected through your use of Free Toast Host so that it will be reflected in the member performance reports for progress toward CC, CL, etc.</p>

<p>When you are viewing an agenda on Free Toast Host, the reports button is displayed at the top of the screen. Click it.</p>

<p><img src="<?php echo plugins_url( '/rsvpmaker-for-toastmasters/fth_agenda_role_rpt.png' ); ?>" width="600" height="80" alt="FTH agenda button" /></p>

<p>Free Toast Host displays a dialog box prompting you to choose the report you want to access. We are going to use the Member Speech Report and the Member Role Report (the html version, not the xls download). Under Select Start Date, make sure you select &quot;All.&quot; </p>

<p><img src="<?php echo plugins_url( '/rsvpmaker-for-toastmasters/fth-dialog.png' ); ?>" width="600" height="392" alt="FTH Dialog box" /></p>

<p>First, select &quot;Member Speech Report (html)&quot; and click <strong>Run/Download</strong>.</p>

<p>If you are prompted to print the document, click <strong>Cancel</strong>. Copy and Paste the all the data (not including the headers at the top) and paste it into the appropriate dialog on this form.</p>

<p><img src="<?php echo plugins_url( '/rsvpmaker-for-toastmasters/fth-speech-report.png' ); ?>" width="600" height="455" alt="Speech Report" /></p>

<p>Repeat the process for &quot;Member Role Report (html)&quot;.</p>

<p><img src="<?php echo plugins_url( '/rsvpmaker-for-toastmasters/fth_member_role_report.png' ); ?>" width="600" height="463" alt="Role Report" /></p>

<p>Click <strong>Import Records (step 1)</strong>.</p>

<p>On the next screen, you will be given the opportunity to make some corrections, matching up the names of members with the correct records recorded in WordPress for Toastmasters and matching the names of roles with the standard role names WordPress for Toastmasters uses for reporting.</p>

<p>Some data may not match up perfectly. You may have former members on the historical report for whom there is no matching record in WordPress. You may have roles that don't match up with the standard roles. If you leave those items with no selection, they simply will not be recorded.</p>

<p>If members speech projects were not recorded in Free Toast Host, you can add that information if you have it. Otherwise, leave it blank. The member will still be recorded as having given a speech, even though you haven't specified which one.</p>

<p>Click <strong>Import Records (step 2)</strong> and the data will be recorded.</p>



		<?php

		tm_admin_page_bottom( $hook );



	}



}





function toastmasters_activity_log() {



	$hook = tm_admin_page_top( __( 'Activity Log', 'rsvpmaker-for-toastmasters' ) );



	global $wpdb;

	$log = '';



	if ( isset( $_REQUEST['filter'] ) ) {

		$filter    = preg_replace( '[^a-zA-Z0-9 ]', '', sanitize_text_field($_REQUEST['filter']) );

		$filterSQL = " AND meta_value LIKE '%" . $filter . "%'";

	} else {

		$filterSQL = '';

	}



	$activity_sql = "SELECT meta_value from $wpdb->postmeta WHERE (meta_key='_activity' OR meta_key='_activity_editor') $filterSQL ORDER BY meta_id DESC LIMIT 0,1000";

	$log          = $wpdb->get_results( $activity_sql );

	$output       = '';

	foreach ( $log as $row ) {

		$output .= '<p>' . $row->meta_value . '</p>';

	}

	?>

<p><em><?php _e( 'Optionally, you can filter by the name of a member or by a keyword such as "edited" or "withdrawn."', 'rsvpmaker-for-toastmasters' ); ?></em></p>

<form method="get" action="<?php echo admin_url( 'admin.php' ); ?>">

<input type="hidden" name="page" value="toastmasters_activity_log" />

<input type="text" name="filter" value="

	<?php

	if ( isset( $_REQUEST['filter'] ) ) {

		echo esc_html($_REQUEST['filter']);}

	?>

	" />

<button>Filter</button>

<?php rsvpmaker_nonce(); ?>

</form>

	<?php

	if ( ! empty( $output ) ) {

		echo $output;

	}

	tm_admin_page_bottom( $hook );

}



function toastmasters_progress_report( $user_id ) {

	ob_start();

	if ( ! $user_id ) {

		?>

<p>Select member from the list above</p>

<h2>Competent Communicator Progress Report</h2>

		<?php

		return ob_get_clean();

	}



	echo '<style>

td,th {

border: thin solid #000;

text-align:center;	

	}

th.role {

	min-width: 80px;

    max-width: 100px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

}

</style>';



	global $competent_leader;

	global $toast_roles;

	$id         = (int) $user_id;

	$userdata   = get_userdata( $id );

	$stats      = get_tm_stats( $userdata->ID );

	$myroles    = $stats['count'];// awesome_get_stats($userdata->ID);

	$pure_count = $stats['pure_count'];

	if ( isset( $_REQUEST['debug'] ) ) {

		echo "<pre>Adjusted count:\n";

		print_r( $myroles );

		echo "\nDetailed Records:\n";

		print_r( $pure_count );

		echo '</pre>';



	}



	printf( '<h2>%s %s</h2>', $userdata->first_name, $userdata->last_name );



	echo '<h3>Competent Communication</h3>';

	$count = isset( $myroles['COMPETENT COMMUNICATION'] ) ? $myroles['COMPETENT COMMUNICATION'] : 0;

	while ( $count > 10 ) {

			echo '<div style="width: 100%; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: 100%"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">10</span></div></div><p>additional CC?</p>';

			$count -= 10;

	}

	$bar = $count * 10;

	echo '<div style="width: 100%; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: ' . $bar . '%"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">' . $count . '</span></div></div>';

	$table2 = '';

	echo '<h3>Competent Leader</h3>';

	ob_start();

	$count = cl_progress( $userdata );

	global $project_gaps;

	$cl_detail = ob_get_clean();

	$table2   .= '<tr><td>' . $count . '</td>' . $project_gaps[ $userdata->ID ] . '</tr>';



	echo '<style>

td {vertical-align: text-top;}

td.project, th.project, td.name, th.name {

width: 150px;

}

table {

margin-top: 15px;

width: 95%;

}

</style>

<table><tr><th>#</th><th class="name">Name</th><th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 1</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 2</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 3</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 4</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 5</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 6</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 7</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 8</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . ' 9</th>

<th class="project">' . __( 'Project', 'rsvpmaker-for-toastmasters' ) . " 10</th>

</tr>

$table2

</table>";



	$l = '<h3>Role Statistics</h3><table><tr><th  class="role">' . __( 'COMPETENT COMMUNICATION', 'rsvpmaker-for-toastmasters' ) . '</th>';

	foreach ( $toast_roles as $role ) {

		if ( $role == 'Topics Master' ) {

			$role = 'TT Master';

		}

		$l .= '<th class="role">' . $role . '</th>';

	}

	$l .= '</tr>';

	echo $l;



	$security = get_tm_security();



	if ( isset( $_REQUEST['edit'] ) && current_user_can( $security['edit_member_stats'] ) ) {

		echo '<tr><td>';

			printf( '<input type="text" name="newstat[%d][%s]" value="%d" size="2" />', $userdata->ID, 'COMPETENT COMMUNICATION', $myroles['COMPETENT COMMUNICATION'] );

		if ( $myroles['COMPETENT COMMUNICATION'] ) {

			printf( '<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />', $userdata->ID, 'COMPETENT COMMUNICATION', $myroles['COMPETENT COMMUNICATION'] );

		}

		echo '</td>';

		foreach ( $toast_roles as $role ) {

				echo '<td>';

				printf( '<input type="text" name="newstat[%d][%s]" value="%d" size="2" />', $userdata->ID, $role, $myroles[ $role ] );

			if ( $myroles[ $role ] ) {

				printf( '<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />', $userdata->ID, $role, $myroles[ $role ] );

			}

				echo '</td>';

		}

		echo '</tr>';

		echo '</table>';

		$cl = array();



		$tasks = '<option value="">Choose a Project</option>';



		foreach ( $competent_leader as $role ) {

				$tasks .= sprintf( '<option value="%s">%s</option>', $role, $role );

			if ( isset( $myroles[ $role ] ) ) {

				$cl[] = $role;

			}

		}

		if ( sizeof( $cl ) ) {

			echo '<p>CL Projects: ';

			echo implode( ', ', $cl );

			echo '</p>';

		}



				printf(

					'<p><b>' . __( 'Additonal Competent Leader Credits for', 'rsvpmaker-for-toastmasters' ) . ' %s %s</b></p>

				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>

				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>

				',

					$userdata->first_name,

					$userdata->last_name,

					$userdata->ID,

					$tasks,

					$userdata->ID,

					$tasks,

					$userdata->ID,

					$tasks,

					$userdata->ID,

					$tasks

				);



			echo '<p><b>' . __( 'Advanced Manuals', 'rsvpmaker-for-toastmasters' ) . '</b></p>';

			$manuals = get_manuals_array();

		foreach ( $manuals as $role => $manual_text ) {

			if ( ( $role == 'COMPETENT COMMUNICATION' ) || strpos( $role, 'Non Manual Speech' ) ) {

				continue;

			}

			echo '<p>';

			printf( '<input type="text" name="newstat[%d][%s]" value="%d" size="2" /> %s', $userdata->ID, $role, $myroles[ $role ], $role );

			if ( $myroles[ $role ] ) {

				printf( '<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />', $userdata->ID, $role, $myroles[ $role ] );

			}

			echo '</p>';

		}



		$manuals_options = get_manuals_options();

		$manuals         = sprintf(

			'<select class="manual" name="add_speeches_manual[%d][]">

%s</select>',

			$userdata->ID,

			$manuals_options

		);



		submit_button();

	} else {

		if ( empty( $myroles['COMPETENT COMMUNICATION'] ) ) {

			$myroles['COMPETENT COMMUNICATION'] = 0;

		}

		echo '<tr><td>' . $myroles['COMPETENT COMMUNICATION'] . '</td>';

		foreach ( $toast_roles as $role ) {

				echo ( isset( $myroles[ $role ] ) ) ? '<td>' . $myroles[ $role ] . '</td>' : '<td>&nbsp;</td>';

		}

		echo '</tr>';

		echo '</table>';



		$manuals = get_manuals_array();

		$adv     = '';

		foreach ( $manuals as $role => $manual_text ) {

			if ( ( $role == 'COMPETENT COMMUNICATION' ) || empty( $myroles[ $role ] ) ) {

				continue;

			}

				$adv .= sprintf( '<p>%s %s</p>', $role, $myroles[ $role ] );

		}

		if ( ! empty( $adv ) ) {

				echo '<h3>' . __( 'Advanced Manuals', 'rsvpmaker-for-toastmasters' ) . '</h3>' . $adv;

		}

	}



	echo '<h3>Competent Leader Detail</h3>';



	echo $cl_detail;

	return ob_get_clean();

}



function speeches_by_manual( $user_id ) {

	ob_start();

	if ( ! $user_id ) {

		printf( '<form method="get" action="%s" id="tm_select_member_tab"><input type="hidden" id="tm_page" name="page" value="toastmasters_reports" />', admin_url( 'admin.php' ) );

		echo awe_user_dropdown( 'toastmaster', $user_id, true, __( 'Select Member', 'rsvpmaker-for-toastmasters' ) );

		echo '<button>' . __( 'Get', 'rsvpmaker-for-toastmasters' ) . '</button>';

		echo '<input type="hidden" name="active" class="tab" value="speeches">';

		rsvpmaker_nonce();

		echo '</form>';

		return ob_get_clean();

	}

	$stats = get_tm_stats( $user_id );



	echo $stats['speech_list'];



	echo '<h2>Speeches by Manual</h2>';



	$manuals      = get_manuals_array();

	$speech_array = $stats['speeches'];

	foreach ( $manuals as $mkey ) {

		if ( strpos( $mkey, 'Manual' ) ) {

			continue;

		}

		if ( isset( $speech_array[ $mkey ] ) ) {

			echo '<h3>' . $mkey . '</h3>';

			echo $speech_array[ $mkey ];

		}

	}



	return ob_get_clean();

}



function my_progress_report() {

	toastmasters_reports();

}



function tm_sync_fields( $user ) {

	// don't override during sync with TI member spreadsheet

	unset( $user['home_phone'] );

	unset( $user['work_phone'] );

	unset( $user['mobile_phone'] );

	return $user;

}



function member_list() {

	$hook = tm_admin_page_top( __( 'Member List', 'rsvpmaker-for-toastmasters' ) );



	$q          = 'blog_id=' . get_current_blog_id();

	$joinedslug = 'joined' . get_current_blog_id();

	if ( isset( $_GET['new'] ) ) {

		printf( '<div>Sorted to show new members first - <a href="%s">Sort alphabetically</a></div>', admin_url( 'admin.php?page=contacts_list' ) );

	} else {

		printf( '<div><a href="%s">Sort newest to oldest</a></div>', admin_url( 'admin.php?page=contacts_list&new=1' ) );

	}



	$missing = false;



	$blogusers = get_users( $q );

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}

		$index = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );

		if ( isset( $_GET['new'] ) ) {

			if ( ! empty( $userdata->$joinedslug ) ) {

				$index = date( 'Y-m-d', strtotime( $userdata->$joinedslug ) ) . $index;

			} elseif ( ! empty( $userdata->club_member_since ) ) {

				$index = date( 'Y-m-d', strtotime( $userdata->club_member_since ) ) . $index;

			} else {

					$index   = '0000-00-00' . $index;

					$missing = true;

			}

		}

		$members[ $index ] = $userdata;

	}

	if ( isset( $_GET['new'] ) ) {

		krsort( $members );

	} else {

		ksort( $members );

	}

	foreach ( $members as $index => $userdata ) {

		?>



<h3><?php echo esc_html($userdata->first_name . ' ' . $userdata->last_name); ?></h3>



		<?php

		if(	$userdata->tm_directory_blocked	)

		{

			continue;

		}

		$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );

		$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );

		$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );

		$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );



		foreach ( $contactmethods as $name => $value ) {

			if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {

				printf( "<div>%s: %s</div>\n", $value, $userdata->$name );

			}

		}

		printf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );

		$emails[] = $userdata->user_email;

		$status = wp4t_get_member_status( $userdata->ID );

		if ( ! empty( $status ) ) {

			printf( '<div>' . __( 'Status', 'rsvpmaker-for-toastmasters' ) . ': %s</div>' . "\n", $status );

		}

		if ( isset( $_GET['new'] ) ) {

			if ( empty( $userdata->$joinedslug ) ) {

				printf( '<div>Joined: %s</div>', $userdata->club_member_since );

			} else {

				printf( '<div>Joined: %s</div>', $userdata->$joinedslug );

			}

		}

	}

	if ( $missing ) {

		echo '<p>Some entries missing join date. Sync with member roster spreadsheet from toastmasters.org to add the dates.</p>';

	}



	printf('<p><a href="mailto:%s">Email All</a></p>',implode(',',$emails));



	tm_admin_page_bottom( $hook );

}



function tm_member_welcome_redirect() {

	global $current_user;

	if ( !empty($_GET) ) // isset( $_GET['page'] ) && $_GET['page'] == 'wp4t_setup_wizard' ) 

	{

		// don't interfere with setup wizard or any admin or edit page

		add_user_meta( $current_user->ID, 'tm_member_welcome', time() );

		set_transient('todo_shown',1, time() +HOUR_IN_SECONDS);

		return;

	}

	if ( isset( $_REQUEST['forget_welcome'] ) ) {

		delete_user_meta( $current_user->ID, 'tm_member_welcome' );

		wp_logout();

		wp_safe_redirect( site_url( 'wp-login.php' ) );

		return;

	}

	if(current_user_can('manage_options') && !get_option('blog_public') && !get_transient('todo_shown')) {

	wp_safe_redirect( add_query_arg( array( 'page' => 'wp4t_todolist_screen' ), admin_url( 'admin.php' ) ) );

	set_transient('todo_shown',1, time() +HOUR_IN_SECONDS);

	return;

	}

	if ( get_user_meta( $current_user->ID, 'tm_member_welcome', true ) ) {

		return;

	}

	add_user_meta( $current_user->ID, 'tm_member_welcome', time() );

	wp_safe_redirect( add_query_arg( array( 'page' => 'toastmasters_welcome' ), admin_url( 'index.php' ) ) );

}



function tm_welcome_screen_pages() {

	add_dashboard_page(

		'Welcome To WordPress for Toastmasters',

		'Welcome To WordPress for Toastmasters',

		'read',

		'toastmasters_welcome',

		'toastmasters_welcome'

	);

}





function toastmasters_welcome() {

	$hook = tm_admin_page_top( __( 'Welcome to WordPress for Toastmasters', 'rsvpmaker-for-toastmasters' ) );

	global $wpdb;

	?>



	<h2 class="rsvpmaker-nav-tab-wrapper nav-tab-wrapper">

	  <a class="nav-tab nav-tab-active" href="#main">Quick Guide</a>

	  <a class="nav-tab" href="#TODO">To Do First</a>

	  <a class="nav-tab" href="#credits">Credits</a>

	</h2>



	<div id="sections" class="toastmasters rsvpmaker" >

	<section  id="main">

	<p>This website takes advantage of software from the <a href="http://wp4toastmasters.com">WordPress for Toastmasters</a> project, which adds Toastmasters-specific features such as meeting and membership management to WordPress, a popular web publishing and online marketing platform. Here is a quick orientation.</p>

	<p>You are viewing the website's administrative back end, or "Dashboard." This is where you come to <a href="<?php echo admin_url( 'profile.php' ); ?>">update your member profile</a> (please verify your contact information!) and <a href="<?php echo admin_url( 'profile.php#password' ); ?>">change your password</a>. Site administrators can also edit the content of the website and tweak settings from here. To sign up for meeting roles, you will want to return to the public website, as shown below.</p>

	<p>The basic dashboard menu for a member looks something like this:</p>

	<p><img src="<?php echo plugins_url( '/rsvpmaker-for-toastmasters/' ); ?>nav-toastmasters-menu.png" width="242" height="217" alt=""/></p>

	<p>Officers and administrators will see a more complicated menu, with options for adding members and editing site content.</p>

	<p>Do not let yourself get lost in the menus! WordPress has many capabilities, which is the rationale for using it for Toastmasters websites. As a regular member, most of the time you only need to do a few simple things. Click on the To Do First tab above for pointers on basic tasks like changing your password and signing up for a role at an upcoming meeting.</p>

	<p>Here is how you return to viewing the public website:</p>

	<p>

<img src="<?php echo plugins_url( '/rsvpmaker-for-toastmasters/' ); ?>nav-to-site.png" width="458" height="297" alt=""/>

<br /><em>At the top of every back end administrative screen, the Visit Site option is displayed under the name of the website, in the menu at the top of the screen.</em></p>

<p>When you are logged in with your user name and password, you should see a black bar across the top of the screen that contains a similar menu:</p>

<p>

<img src="<?php echo plugins_url( '/rsvpmaker-for-toastmasters/' ); ?>nav-to-dashboard.png" width="458" height="297" alt=""/>

<br /><em>When you are logged in and viewing the public website, the Dashboard option is displayed under the name of the website. Clicking there returns you to the administrative back end, or dashboard.</em></p>

	<?php

	if ( current_user_can( 'edit_others_posts' ) ) {

		?>

<!-- admins see -->

<h3>For Administrators and Editors</h3>

	<p>Everyone sees the message above the first time they visit the administrator's dashboard. If you will be responsible for editing the site and/or managing agendas, you should also review documentation in the <a href="https://www.wp4toastmasters.com/knowledge-base/">WordPress for Toastmasters knowledge base</a>.</p>

	<p>The two main content types in WordPress are pages and posts (blog posts), where pages hold content of more permanent interest included on your site menu and blog posts are news or feature articles.</p>

	<p>You can edit any page of your site by clicking Pages on this dashboard, then the edit link under the name of the page. To add a new page, click the Add New submenu item under Pages.</p>

	<p>You can edit any blog post by clicking Posts on this dashboard, then the edit link under the name of the post. To add a new blog post, click the Add New submenu item under Posts.</p>

	<p>Alternatively, you can use the Edit link that appears on the black bar at the top of the page when you are logged in. Click one of the items under New on that same menu to add new content. If you are a site administrator, you will also see the Customize menu link that allows you to change design elements such as the page headers and background colors (see below).</p>

	<p>The basics of adding and editing blocks of content (such as paragraphs, headlines, and images) are explained in this <a href="https://wordpress.com/support/wordpress-editor/">article from WordPress.com</a>.</p>

	<p>WordPress for Toastmasters incorporates <a href="https://rsvpmaker.com">RSVPMaker</a>, a WordPress plugin for event management and event marketing. Agendas are created as RSVPMaker event posts with additional content blocks representing meeting roles and notes about the organization of the agenda. See the <a href="https://rsvpmaker.com/documentation">documentation</a> for more information about how RSVPMaker can also be used to create and market other sorts of events and even charge for those events.</p>

<figure class="wp-block-image size-large"><img loading="lazy" width="614" height="237" src="https://i2.wp.com/www.wp4toastmasters.com/wp-content/uploads/2020/11/dashboard-pages.png?resize=614%2C237&#038;ssl=1" alt="" class="wp-image-1138630" srcset="https://i2.wp.com/www.wp4toastmasters.com/wp-content/uploads/2020/11/dashboard-pages.png?w=750&amp;ssl=1 750w, https://i2.wp.com/www.wp4toastmasters.com/wp-content/uploads/2020/11/dashboard-pages.png?resize=300%2C116&amp;ssl=1 300w" sizes="(max-width: 614px) 100vw, 614px" data-recalc-dims="1" /><figcaption>Pages Menu</figcaption></figure>

<figure class="wp-block-image size-large"><img loading="lazy" width="419" height="364" src="https://i0.wp.com/www.wp4toastmasters.com/wp-content/uploads/2020/11/admin-bar.png?resize=419%2C364&#038;ssl=1" alt="" class="wp-image-1138631" srcset="https://i0.wp.com/www.wp4toastmasters.com/wp-content/uploads/2020/11/admin-bar.png?w=419&amp;ssl=1 419w, https://i0.wp.com/www.wp4toastmasters.com/wp-content/uploads/2020/11/admin-bar.png?resize=300%2C261&amp;ssl=1 300w" sizes="(max-width: 419px) 100vw, 419px" data-recalc-dims="1" /><figcaption>Admin Bar Options</figcaption></figure>

   

		<?php

	}



	?>

<p><a href="<?php echo admin_url( '?forget_welcome=1' ); ?>">Reset welcome screen</a></p>

	</section><!-- end #main -->

	<section class="rsvpmaker"  id="TODO">

	<p>New members should start by:</p>

	<ul>

	<li><a href="<?php echo admin_url( 'profile.php#user_login' ); ?>"><?php _e( 'Editing your member profile', 'rsvpmaker-for-toastmasters' ); ?></a> (you can also change your password on this screen)</li>

	<li>Signing up for roles at upcoming meetings.

	<ul>

	<?php



	$results = future_toastmaster_meetings( 5 );

	if ( $results ) {

		foreach ( $results as $index => $row ) {

					$t         = (int)  $row->ts_start;

					$title     = $row->post_title . ' ' . rsvpmaker_date( 'F jS', $t );

					$permalink = rsvpmaker_permalink_query( $row->ID );

					printf( '<li><a href="%s">%s</a></li>', $permalink, $title );

		}

	} else {

		echo '<li>No upcoming meetings posted</li>';

	}

	?>

	  

	</ul>

	</li>

	<li>Checking out the <a href="http://wp4toastmasters.com/new-member-guide-to-wordpress-for-toastmasters/">New Member Guide to WordPress for Toastmasters</a>, which indludes a demo video.</li>

	</ul>



	</section><!-- end #TO DO -->

	<section class="rsvpmaker"  id="credits">

	<p>WordPress for Toastmasters is a volunteer project derived from customizations originally created by David F. Carr for <a href="http://www.clubawesome.org">Club Awesome Toastmasters</a> in Coral Springs, Florida and supported by <a href="http://www.carrcommunications.com">Carr Communications Inc</a>.</p>

	<p>Many improvements have been (and continue to be) suggested by the members of Club Awesome and by Toastmasters around the world who see the potential of this project.</p>

	<p>Some particularly important supporters include:

	<br />Lois Margolin

	<br />Marilyn Brown

	<br />Sue Ness

	<br />Lois Margolin

<br />Scott Friedman

<br />Blake Evans

<br />Juan Artigas

<br />Daniel Greenberg

	</p>

<p>All Toastmasters logos and other references to the brand are owned by <a href="http://www.toastmasters.org">Toastmasters International</a>, which provided guidance on conformity to the Toastmasters brand guidelines.</p>

	

	</section><!-- end #credits -->

	</div>



	<?php



	tm_admin_page_bottom( $hook );

}





function tm_welcome_screen_remove_menus() {

	// these menus will be active but not displayed

	remove_submenu_page( 'index.php', 'toastmasters_welcome' );

	remove_submenu_page( 'options-general.php', 'tm_security_caps' );

	remove_submenu_page( 'toastmasters_screen', 'tm_member_edit' );

	remove_submenu_page( 'toastmasters_screen', 'import_fth' );

	remove_submenu_page( 'toastmasters_screen', 'add_member_speech' );

}





function toastmasters_support() {

	global $current_user;

	$hook = tm_admin_page_top( __( 'About WordPress for Toastmasters', 'rsvpmaker-for-toastmasters' ) );

	echo '<div style="background-color: #fff; padding: 5px;">';

	show_wpt_promo();

	?>

<h2>How You Can Help</h2>

<p>Ideas for improvements are always welcome. Help with documentation and training materials would be appreciated, particularly from those with a training or technical writing background. Write to <a href="mailto:david@wp4toastmasters.com?subject=WordPress for Toastmasters">david@wp4toastmasters.com</a>.</p>

<p>The underlying software is available as open source code, meaning web developers and designers can contribute their own improvements. See the <a href="https://wordpress.org/plugins/rsvpmaker/">RSVPMaker</a> and <a href="https://wordpress.org/plugins/rsvpmaker-for-toastmasters/">RSVPMaker for Toastmasters</a> plugins and the <a href="https://wordpress.org/themes/lectern/">Lectern</a> theme in the WordPress.org repository and on <a href="https://github.com/davidfcarr">Github</a>.</p>

<p>&quot;Like&quot; the <a href="https://www.facebook.com/wp4toastmasters">WordPress for Toastmasters Facebook page</a> and join the <a href="https://www.facebook.com/groups/wp4toastmasters">Toastmost and WordPress for Toastmasters Users</a>  Facebook group.</p>

<!-- Begin MailChimp Signup Form -->

<link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">

<style type="text/css">

	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}

	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.

	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */

</style>

<div id="mc_embed_signup">

<form action="//carrcommunications.us1.list-manage.com/subscribe/post?u=98249af77569f1d331f14fb25&amp;id=5d7256b1ba" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

	<div id="mc_embed_signup_scroll">

	<label for="mce-EMAIL">Subscribe to the WordPress for Toastmasters mailing list</label>

	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" required value="<?php echo esc_attr($current_user->user_email); ?>">

	<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

	<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_98249af77569f1d331f14fb25_5d7256b1ba" tabindex="-1" value=""></div>

	<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>

	</div>

</form>

</div>

</div>

	<?php

	tm_admin_page_bottom( $hook );

}



add_action( 'init', 'tm_export' );

function tm_export() {

	if ( ! isset( $_REQUEST['tm_export'] ) ) {

		return;

	}

	if ( isset( $_GET['jout'] ) ) {

		$j     = sanitize_text_field($_GET['jout']);

		$parts = explode( ':', $j );

		$jt    = ( empty( $parts[1] ) ) ? 0 : (int) $parts[1];

		if ( $jt < time() ) {

			die( 'import code expired' );

		}

		$joutcode = get_option( 'joutcode' );

		if ( $j != $joutcode ) {

			die( 'invalid import code' );

		}

		global $wpdb;

		$users = get_club_members();

		foreach ( $users as $user ) {

			$u    = array(

				'user_login'    => $user->user_login,

				'user_nicename' => $user->user_nicename,

				'user_email'    => $user->user_email,

				'display_name'  => $user->display_name,

			);

			$sql  = "SELECT meta_key, meta_value from $wpdb->usermeta WHERE user_id=" . $user->ID;

			$res  = $wpdb->get_results( $sql );

			$meta = array();

			foreach ( $res as $row ) {

				$meta[ $row->meta_key ] = $row->meta_value;

			}

			$u['usermeta']     = $meta;

			$index             = ( empty( $meta['toastmasters_id'] ) ) ? $user->user_email : $meta['toastmasters_id'];

			$members[ $index ] = $u;

		}

		echo json_encode( $members );

		exit();

	}



	if ( ! wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key'))  ) {

		// This nonce is not valid.

		die( 'Failed security check' );

	} elseif ( isset( $_GET['json'] ) || isset( $_GET['jout'] ) ) {

		global $wpdb;

		$users = get_users('blog_id='.get_current_blog_id());

		foreach ( $users as $user ) {

			$u             = array(

				'user_login'    => $user->user_login,

				'user_nicename' => $user->user_nicename,

				'user_email'    => $user->user_email,

				'display_name'  => $user->display_name,

			);

			$sql           = "SELECT meta_key, meta_value from $wpdb->usermeta WHERE user_id=" . $user->ID;

			$u['usermeta'] = $wpdb->get_results( $sql );

			$members[]     = $u;

		}

		$json = json_encode( $members );

		if ( isset( $_GET['jout'] ) ) {

			echo $json;

		} 

		else {

			header( 'Content-Type: text/json' );

			header( 'Content-Disposition: attachment;filename="' . sanitize_text_field($_SERVER['SERVER_NAME']) . '-members-' . date( 'Y-m-d' ) . '.json"' );

			header( 'Cache-Control: max-age=0' );

			$out = fopen( 'php://output', 'w' );

			fputs( $out, $json );

			fclose( $out );

		}

		exit();

	}

	elseif (isset($_GET['role'])) {

		$users   = get_club_members();

		foreach($users as $user) {

			$index = preg_replace('[^a-z]','',strtolower(get_user_meta($user->ID,'last_name',true).get_user_meta($user->ID,'first_name',true).$user->user_login));

			$sortuser[$index] = $user;

		}

		ksort($sortuser);



		$header = ['Name','Toastmasters ID','Role','Count','Datetime','Domain','Manual','Project','Title'];



		header( 'Content-Type: text/csv' );

		header( 'Content-Disposition: attachment;filename="' . sanitize_text_field($_SERVER['SERVER_NAME']) . '-members-' . date( 'Y-m-d' ) . '.csv"' );

		header( 'Cache-Control: max-age=0' );

		$out = fopen( 'php://output', 'w' );

		fputcsv( $out, $header );



		foreach($sortuser as $user) {

			$tmid = get_user_meta($user->ID,'toastmasters_id',true);

			$results = wp4t_history_query(['select'=>'role,rolecount,datetime,domain,manual,project,title','where'=>"user_id=$user->ID",'orderby'=>'role, datetime']);

			foreach($results as $row) {

				$export = ['name'=>$user->display_name,'toastmasters_id'=>$tmid];

				$row = (array) $row;

				foreach($row as $key => $value)  {

					$export[$key] = $value;

				}

			fputcsv($out,$export);

			}

		}

		fclose( $out );

		exit();

	}

	else {

		$users   = get_club_members();

		$contact = array();

		$urls    = array( 'facebook_url', 'twitter_url', 'linkedin_url', 'business_url' );



		$header = array( 'user_id', 'user_login', 'first_name', 'last_name', 'user_email', 'toastmasters_id', 'home_phone', 'work_phone', 'mobile_phone' );



		$manuals = get_manuals_array();

		global $toast_roles;

		global $competent_leader;

		foreach ( $manuals as $manual => $manual_text ) {

			if ( ! strpos( $manual, 'Manual/Path' ) ) { // don't include placeholder select manual field

				$statfields[] = $manual;

			}

		}

		foreach ( $toast_roles as $column ) {

			$statfields[] = $column;

		}

		foreach ( $competent_leader as $column ) {

			$statfields[] = $column;

		}



		$header = array_merge( $header, $statfields, $urls );



		header( 'Content-Type: text/csv' );

		header( 'Content-Disposition: attachment;filename="' . sanitize_text_field($_SERVER['SERVER_NAME']) . '-members-' . date( 'Y-m-d' ) . '.csv"' );

		header( 'Cache-Control: max-age=0' );

		$out = fopen( 'php://output', 'w' );

		fputcsv( $out, $header );



		foreach ( $users as $user ) {

				$nextuser = array();

				$userdata = get_userdata( $user->ID );

				$stats    = awesome_get_stats( $userdata->ID );

			foreach ( $header as $field ) {

				if ( $field == 'user_id' ) {

					$field = 'ID'; // workaround for issue with excel

				}

				if ( in_array( $field, $statfields ) && isset( $stats[ $field ] ) ) {

					$nextuser[ $field ] = $stats[ $field ];

				} elseif ( isset( $userdata->$field ) ) {

					$nextuser[ $field ] = $userdata->$field;

				} else {

					$nextuser[ $field ] = '';

				}

			}

			fputcsv( $out, $nextuser );

		}

		fclose( $out );

		exit();

	}



}



function toastmasters_dues() {

	$hook = tm_admin_page_top( 'Track Dues' );



	$standard_dues = get_option( 'toastmasters_dues' );

	$newmember_fee = get_option( 'toastmasters_newmember_fee' );

	if ( empty( $newmember_fee ) ) {

		$newmember_fee = 20;

	}

	$blogusers = get_users();

	$paid      = '';

	if ( isset( $_POST['paid'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$t    = strtotime( $_POST['yearend'] . '-' . $_POST['monthend'] . '-1' );

		$dues = sanitize_text_field($_POST['dues']);

		if ( $dues != $standard_dues ) {

			update_option( 'toastmasters_dues', $dues );

			$standard_dues = $dues;

		}

		$newfee = sanitize_text_field($_POST['newfee']);

		if ( $newfee != $newmember_fee ) {

			update_option( 'toastmasters_newmember_fee', $newfee );

			$newmember_fee = $newfee;

		}

		foreach ( $_POST['paid'] as $paiduser ) {

				update_user_meta( $paiduser, 'paid_until', $t );

			if ( ! empty( $_POST['isnew'][ $paiduser ] ) ) {

				$payment = array(

					'timestamp' => time(),

					'new'       => 1,

					'USD'       => ( $dues + $newfee ),

				);

				update_user_meta( (int) $paiduser, 'dues_paid', $payment );

			} else {

				$payment = array(

					'timestamp' => time(),

					'new'       => 0,

					'USD'       => $dues,

				);

				update_user_meta( (int) $paiduser, 'dues_paid', $payment );

			}

				add_user_meta( $paiduser, 'paid_until', $t );

		}

	}



	// Array of WP_User objects.

	printf( '<form action="%s" method="post">', admin_url( 'admin.php?page=toastmasters_dues' ) );



	$y = date( 'Y' );

	$m = date( 'm' );

	if ( $m > 10 ) {

		$y++;

		printf( '<p>Until Month: <select name="monthend"><option value="4">4</option><option value="10">10</option></select> Year:<select name="yearend"><option value="%s">%s</option><option value="%s">%s</option></select></p>', $y, $y, ( $y + 1 ), ( $y + 1 ) );

	} elseif ( $m < 4 ) {

		printf( '<p>Until Month: <select name="monthend"><option value="4">4</option><option value="10">10</option></select> Year:<select name="yearend"><option value="%s">%s</option><option value="%s">%s</option></select></p>', $y, $y, ( $y + 1 ), ( $y + 1 ) );

	} else {

		printf( '<p>Until Month: <select name="monthend"><option value="10">10</option><option value="4">4</option></select> Year:<select name="yearend"><option value="%s">%s</option><option value="%s">%s</option></select></p>', $y, $y, ( $y + 1 ), ( $y + 1 ) );

	}



	printf( '<p>Dues: $ <input name="dues" value="%s"> USD New Member fee: $ <input type="text" name="newfee" value="%s"> USD</p>', $standard_dues, $newmember_fee );



	$paidcount = 0;

	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );

		if ( $userdata->hidden_profile ) {

			continue;

		}



		$payments       = get_user_meta( $user->ID, 'dues_paid' );

		$pay            = '';

		$order_payments = array();

		if ( ! empty( $payments ) ) {

			foreach ( $payments as $payment ) {

				if ( ! empty( $payment['timestamp'] ) ) {

					$order_payments[ $payment['timestamp'] ] = $payment['USD'];

				}

			}

			if ( ! empty( $order_payments ) ) {

				krsort( $order_payments );

				foreach ( $order_payments as $timestamp => $usd ) {

					$pay .= '$' . $usd . ' paid ' . rsvpmaker_date( 'F Y', (int) $timestamp ) . '<br />';

				}

			}

		}

		if ( empty( $userdata->paid_until ) || ( time() > $userdata->paid_until ) ) {

			printf( '<p><input type="checkbox" name="paid[]" value="%s" /> %s <input type="checkbox" name="isnew[%d]" value="1"> %s<br />%s %s (%s) <a href="mailto:%s">%s</a></p>', $user->ID, __( 'Dues', 'rsvpmaker-for-toastmasters' ), $user->ID, __( 'New Member Fee', 'rsvpmaker-for-toastmasters' ), $userdata->first_name, $userdata->last_name, $user->user_login, $user->user_email, $user->user_email );

			if ( ! empty( $pay ) ) {

				printf( '<p>Payment history: %s</p>', $pay );

			}

			$unpaid_email[] = $user->user_email;

		} else {

			$paidcount++;

			$d     = date( 'F Y', (int) $userdata->paid_until );

			$paid .= sprintf( '<p>%s: %s %s (%s) %s</p>', $paidcount, $userdata->first_name, $userdata->last_name, $user->user_login, $d );

			if ( ! empty( $pay ) ) {

				$paid .= sprintf( '<p>Payment history: %s</p>', $pay );

			}

			$paid_email[] = $user->user_email;

		}

	}

	submit_button();

	rsvpmaker_nonce();

	echo '</form>';



	if ( ! empty( $unpaid_email ) ) {

		printf( '<p><a href="mailto:%s">%s</a></p>', implode( ',', $unpaid_email ), __( 'Email all unpaid members', 'rsvpmaker-for-toastmasters' ) );

	}



	if ( ! empty( $paid_email ) ) {

		printf( '<h3>%s</h3>', __( 'Paid Members', 'rsvpmaker-for-toastmasters' ) );

		echo $paid;

		printf( '<p><a href="mailto:%s">%s</a></p>', implode( ',', $paid_email ), __( 'Email all PAID members', 'rsvpmaker-for-toastmasters' ) );

	}



	tm_admin_page_bottom( $hook );

}



function toastmasters_import_export() {

	$hook = tm_admin_page_top( 'Import/Export' );

	global $wpdb;



	$nonce       = wp_create_nonce( 'tm_export' );

	$timelord = rsvpmaker_nonce('query');

	$export_link = sprintf( '<a href="%s?page=%s&tm_export=%s&%s">Export Summary</a>', admin_url( 'admin.php' ), 'import_export', $nonce,$timelord );

	$export_role = sprintf( '<a href="%s?page=%s&tm_export=%s&%s&role=1">Export Role Report</a>', admin_url( 'admin.php' ), 'import_export', $nonce,$timelord );



	printf( '<p>Click %s for a listing of member contact info and a summary of their achievements or %s for a listing of all member roles and speeches.</p>', $export_link, $export_role );

	printf( '<p>%s <a href="%s">%s</a></p>', __( 'If you want to import or sync a member spreadsheet from toastmasters.org, see the', 'rsvpmaker-for-toastmasters' ), admin_url( 'users.php?page=add_awesome_member#import' ), __( 'Add Members page', 'rsvpmaker-for-toastmasters' ) );

?>

<h2>Importing Data from Free Toast Host or easySpeak</h2>

<p>If you want to importing data from one of the other club website platforms, contact <a href="mailto:david@wp4toastmasters.com">david@wp4toastmasters.com</a> to volunteer for a software beta test program.</p>

<?php

return;//disabled for now

?>



<h2>Transfer Member Accounts Between WP4Toastmasters Websites</h2>		

	<?php



	// print_r($_REQUEST);

	if ( isset( $_POST['importurl'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$message = file_get_contents( sanitize_url($_POST['importurl']) );

		if ( empty( $message ) ) {

			echo '<div style="color:red">error</div>';

		} elseif ( ! strpos( $message, '}' ) ) {

			echo '<div style="color:red">No data returned</div>' . $message;

		} else {

			$data = json_decode( trim( $message ) );

			foreach ( $data as $index => $user ) {

				$member_id  = 0;

				$usernumber = 0;

				$member     = get_user_by( 'email', $user->user_email );

				if ( empty( $member ) && ! strpos( $index, '@' ) ) {

					$member = get_user_by_tmid( $index );

				}

				if ( ! empty( $member->ID ) ) {

					$member_id = $member->ID;

				}

				if ( $member_id ) {

					printf( '<p>looked up %s = user #%d</p>', $user->user_login, $member_id );

				} else {

					while ( get_user_by( 'login', $user->user_login ) ) {

						printf( '<p>existing user by %s</p>', $user->user_login );

						$usernumber++;

						$user->user_login = $user->user_login . $usernumber;

						printf( '<p>login changed to %s</p>', $user->user_login );

					}

					$newuser   = array(

						'user_login'    => $user->user_login,

						'user_email'    => $user->user_email,

						'user_nicename' => $user->user_nicename,

						'display_name'  => $user->display_name,

						'user_pass'     => wp_generate_password(),

					);

					$member_id = wp_insert_user( $newuser );

					print_r( $member_id );

					printf( '<p>adding %s, user id %d</p>', $user->user_login, $member_id );

				}

				$record_count = 0;

				if ( ! empty( $user->usermeta ) ) {

					foreach ( $user->usermeta as $meta_key => $meta_value ) {

						// echo '<div>'.$meta_key.' value:</div>';

						if ( is_serialized( $meta_value ) ) {

							$value = unserialize( $meta_value );

						} else {

							$value = $meta_value;

						}

						// print_r($value);

						// echo '<br />';

						update_user_meta( $member_id, $meta_key, $value );

						$record_count++;

					}

				}

				printf( '<div>%d member records</div>', $record_count );

			}

		}

	}



	// $json_link = sprintf('<a href="%s?page=%s&tm_export=%s&json=1">Export</a>', admin_url('admin.php') ,'import_export',$nonce );



	$joutcode = get_option( 'joutcode' );

	$j        = explode( ':', $joutcode );

	$jt       = empty( $j[1] ) ? 0 : (int) $j[1];

	if ( isset( $_GET['joutcode'] ) || ( $jt < time() ) ) {

		$jt       = strtotime( '+ 24 hour' );

		$joutcode = rand() . ':' . $jt;

		update_option( 'joutcode', $joutcode );

	}

	rsvpmaker_fix_timezone();

	global $rsvp_options;

	printf(

		'<p><strong>Step 1. Export:</strong> To move your club\'s member records to another website that also uses this software, copy this web address:</p>

<pre>%s</pre>

<p>This link will expire at %s. (<a href="%s">reset</a>)</p>',

		site_url( '?jout=' . $joutcode . '&tm_export=' . $nonce ),

		rsvpmaker_date( $rsvp_options['short_date'] . ' ' . $rsvp_options['time_format'] . ' T', $jt ),

		admin_url( 'admin.php?page=import_export&joutcode=1' )

	);

	?>

<p>The next step will take place on your new website.</p>

<form method="post" action="<?php echo admin_url( 'admin.php?page=import_export' ); ?>">

	<p><strong>Step 2. Import:</strong> After obtaining the export link from your old website, paste it here to import.<br /><input type="text" name="importurl" value="

	<?php

	if ( isset( $_POST['importurl'] ) ) {

		echo esc_html(sanitize_url($_POST['importurl']));

	}

	?>

	" />

<br /><button>Import</button>

<?php rsvpmaker_nonce(); ?>

</form>



<?php

	?>

	<h2 class="rsvpmaker-nav-tab-wrapper nav-tab-wrapper">

	  <a class="nav-tab nav-tab-active" href="#main">WP4Toastmasters Data</a>

	  <a class="nav-tab" href="#fth">Import from Free Toast Host</a>

	</h2>

	<div id="sections" class="toastmasters rsvpmaker" >

	<section id="main">

	<?php

	$nonce       = wp_create_nonce( 'tm_export' );

	$timelord = rsvpmaker_nonce('query');

	$export_link = sprintf( '<a href="%s?page=%s&tm_export=%s&%s">Export</a>', admin_url( 'admin.php' ), 'import_export', $nonce,$timelord );



	printf( '<p>Click to %s a listing of member contact info and achievements. Use this for your own reference or make corrections to the spreadsheet and import your data into the website.</p>', $export_link );



	printf( '<p>%s <a href="%s">%s</a></p>', __( 'If you want to import or sync a member spreadsheet from toastmasters.org, see the', 'rsvpmaker-for-toastmasters' ), admin_url( 'users.php?page=add_awesome_member#import' ), __( 'Add Members page', 'rsvpmaker-for-toastmasters' ) );



	if ( isset( $_POST['import_ss'] )  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key'))  ) {

		$manuals = get_manuals_array();

		global $toast_roles;

		global $competent_leader;

		foreach ( $manuals as $manual => $manual_text ) {

			$statfields[] = $manual;

		}

		foreach ( $toast_roles as $column ) {

			$statfields[] = $column;

		}

		foreach ( $competent_leader as $column ) {

			$statfields[] = $column;

		}

		$lines = explode( "\n", sanitize_textarea_field(stripslashes( $_POST['import_ss']) ) );

		printf( '<p>%s %s %s</p>', __( 'Starting import on', 'rsvpmaker-for-toastmasters' ) . ' ', sizeof( $lines ), ' ' . __( 'lines of data', 'rsvpmaker-for-toastmasters' ) );

		$label     = array();

		$checkform = '';

		$row       = 0;



		foreach ( $lines as $linenumber => $line ) {

			$line  = trim( $line );

			$cells = explode( "\t", $line );

			if ( $linenumber == 0 ) {

				foreach ( $cells as $index => $cell ) {

					$label[] = trim( $cell );

				}

			} else {

				$cells[0] = preg_replace( '/[^0-9]/', '', $cells[0] );

				if ( ! empty( $cells[0] ) && ! is_numeric( $cells[0] ) ) {

					continue; // want either an ID # or a blank field for new member

				}

				if ( empty( $cells[2] ) || empty( $cells[3] ) || empty( $cells[4] ) ) {

					break;

				}

				$user     = array();

				$id       = $cells[0];

				$userdata = get_userdata( $id );

				if ( empty( $userdata ) || ( $userdata->user_login != $cells[1] ) ) {

					printf( '<p>id: %s login: %s does not match an existing user</p>', $cells[0], $cells[1] );

					if ( ! isset( $_POST['add_members'] ) ) {

						continue;

					}

					$user_fields = array( 'user_login', 'first_name', 'last_name', 'user_email', 'home_phone', 'work_phone', 'mobile_phone', 'facebook_url', 'twitter_url', 'linkedin_url', 'business_url' );

						$newuser = array();

					foreach ( $user_fields as $field ) {

						$newuser['user_login'] = $cells[1];

						$newuser['first_name'] = stripslashes( $cells[2] );

						$newuser['last_name']  = stripslashes( $cells[3] );

						$newuser['user_email'] = $cells[4];

					}

					$id = add_member_user( $newuser );

					// printf('<p>new: %s id: %d</p>',$newuser["user_login"],$id);

				}

				// if we've passed that test begin to update

				if ( ! $id ) {

					continue;

				}

				$stats = awesome_get_stats( $id );



				// printf('<p>start: %s %s %s</p>',$cell[0],$cell[1],$cell[2]);



				foreach ( $cells as $index => $cell ) {

					$cell  = trim( str_replace( '"', '', $cell ) );

					$field = $label[ $index ];

					// printf('<br />%d %s = %s',$id,$field,$cell);

					if ( $index < 3 ) {

						continue;

					} elseif ( in_array( $field, $statfields ) ) {

						if ( empty( $cell ) ) {

							// echo '<br >empty';

							continue;

						} elseif ( ! empty( $stats[ $field ] ) && ( $cell == $stats[ $field ] ) ) {

							// echo '<br />unchanged';

							continue; // if empty or didn't change, we don't need to update it

						}

						$current_meta = (int) get_user_meta( $id, 'tmstat:' . $field, true );

						if ( strpos( $field, '_' ) ) {

							$new_meta = $cell;

						} else {

							$new_meta = $cell - ( $stats[ $field ] - $current_meta );

						}

						update_user_meta( $id, 'tmstat:' . $field, $new_meta );

						printf( '<br />%s %s = %s', $cells[1], $field, $new_meta );

					} else {

						if ( $cell == $userdata->$field ) {

							// printf('<p>%s %s unchanged %s</p>',$field,$cell,$userdata->$field);

							continue; // if it didn't change, we don't need to update it

						}

						printf( '<br />%s %s = %s', $cells[1], $field, $cell );

						update_user_meta( $id, $field, $cell );

					}

				}

			}

		}

	}



	?>

<h2>Import or Update Member Records from Spreadsheet</h2>

<p>This allows you to make corrections to a spreadsheet of member facts and statistics, then import those updates. If you are just getting started with WordPress for Toastmasters, you can first import your members into the site, download the spreadsheet, fill in a starter set of statistics such as manual speeches completed for each member, and then use this tool to import that data.</p>

<p>Copy the spreadsheet to your computer clipboard, including the column headers, and paste it into the space below. This utility will update existing member records. If you also want to add new member records, check the "add members" box.</p>

<form method="post" action="<?php echo admin_url( 'admin.php?page=import_export' ); ?>">

<textarea rows="10" cols="80" name="import_ss"></textarea>

<br /><input type="checkbox" name="add_members" value="1"> Add members (if not already in user database)

<br /><button>Import</button>

<?php rsvpmaker_nonce(); ?>

</form>

		

		<h2>Transfer Member Accounts Between Websites</h2>		

	<?php



	// print_r($_REQUEST);

	if ( isset( $_POST['importurl'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$message = file_get_contents( sanitize_url($_POST['importurl']) );

		if ( empty( $message ) ) {

			echo '<div style="color:red">error</div>';

		} elseif ( ! strpos( $message, '}' ) ) {

			echo '<div style="color:red">No data returned</div>' . $message;

		} else {

			$data = json_decode( trim( $message ) );

			foreach ( $data as $index => $user ) {

				$member_id  = 0;

				$usernumber = 0;

				$member     = get_user_by( 'email', $user->user_email );

				if ( empty( $member ) && ! strpos( $index, '@' ) ) {

					$member = get_user_by_tmid( $index );

				}

				if ( ! empty( $member->ID ) ) {

					$member_id = $member->ID;

				}

				if ( $member_id ) {

					printf( '<p>looked up %s = user #%d</p>', $user->user_login, $member_id );

				} else {

					while ( get_user_by( 'login', $user->user_login ) ) {

						printf( '<p>existing user by %s</p>', $user->user_login );

						$usernumber++;

						$user->user_login = $user->user_login . $usernumber;

						printf( '<p>login changed to %s</p>', $user->user_login );

					}

					$newuser   = array(

						'user_login'    => $user->user_login,

						'user_email'    => $user->user_email,

						'user_nicename' => $user->user_nicename,

						'display_name'  => $user->display_name,

						'user_pass'     => wp_generate_password(),

					);

					$member_id = wp_insert_user( $newuser );

					print_r( $member_id );

					printf( '<p>adding %s, user id %d</p>', $user->user_login, $member_id );

				}

				$record_count = 0;

				if ( ! empty( $user->usermeta ) ) {

					foreach ( $user->usermeta as $meta_key => $meta_value ) {

						// echo '<div>'.$meta_key.' value:</div>';

						if ( is_serialized( $meta_value ) ) {

							$value = unserialize( $meta_value );

						} else {

							$value = $meta_value;

						}

						// print_r($value);

						// echo '<br />';

						update_user_meta( $member_id, $meta_key, $value );

						$record_count++;

					}

				}

				printf( '<div>%d member records</div>', $record_count );

			}

		}

	}



	// $json_link = sprintf('<a href="%s?page=%s&tm_export=%s&json=1">Export</a>', admin_url('admin.php') ,'import_export',$nonce );



	$joutcode = get_option( 'joutcode' );

	$j        = explode( ':', $joutcode );

	$jt       = empty( $j[1] ) ? 0 : (int) $j[1];

	if ( isset( $_GET['joutcode'] ) || ( $jt < time() ) ) {

		$jt       = strtotime( '+ 24 hour' );

		$joutcode = rand() . ':' . $jt;

		update_option( 'joutcode', $joutcode );

	}

	rsvpmaker_fix_timezone();

	global $rsvp_options;

	printf(

		'<p><strong>Step 1. Export:</strong> To move your club\'s member records to another website that also uses this software, copy this web address:</p>

<pre>%s</pre>

<p>This link will expire at %s. (<a href="%s">reset</a>)</p>',

		site_url( '?jout=' . $joutcode . '&tm_export=' . $nonce ),

		rsvpmaker_date( $rsvp_options['short_date'] . ' ' . $rsvp_options['time_format'] . ' T', $jt ),

		admin_url( 'admin.php?page=import_export&joutcode=1' )

	);

	?>

<p>The next step will take place on your new website.</p>

<form method="post" action="<?php echo admin_url( 'admin.php?page=import_export' ); ?>">

	<p><strong>Step 2. Import:</strong> After obtaining the export link from your old website, paste it here to import.<br /><input type="text" name="importurl" value="

	<?php

	if ( isset( $_POST['importurl'] ) ) {

		echo esc_html(sanitize_url($_POST['importurl']));

	}

	?>

	" />

<br /><button>Import</button>

<?php rsvpmaker_nonce(); ?>

</form>

</section>

<section class="rsvpmaker"  id="fth">

	<?php import_fth(); ?>

</section>

</div>

	<?php



	tm_admin_page_bottom( $hook );

}



function tm_reports_disclaimer( $extra = '' ) {

	echo '<p>These reports provide guidance on member activity but are not guaranteed to be complete. Site owners can make them more accurate by reconciling meeting signup data with who actually showed up and performed roles, by adding historical data, and by recording activities that happen outside of meetings. ' . $extra . '</p>';

}



function increment_stat_button( $user_id, $key ) {

	global $increment_stat_count;

	$increment_stat_count++;

	return sprintf( ' <button class="increment_stat" counter="%d" user_id="%s" role="%s">+1</button></span> <span id="increment_stat_result%d"></span>', $increment_stat_count, $user_id, $key, $increment_stat_count );

}







function update_user_role_archive( $post_id, $timestamp = '' ) {

	global $wpdb;

	global $current_user;

	$wpdb->show_errors();

	if ( empty( $timestamp ) ) {

		$timestamp = get_rsvp_date( $post_id );

	}

	$sql     = "SELECT *, meta_key as role FROM `$wpdb->postmeta` where post_id=" . $post_id . " AND meta_key LIKE '_role_%' ";

	$results = $wpdb->get_results( $sql );

	if ( $results ) {

		$archive_code = get_post_meta( $post_id, 'wpt_archive_code', true );

		$aggregated   = '';

		foreach ( $results as $row ) {

			$check = (int) $row->meta_value;

			if ( $check > 0 ) { // skip blanks and zeroes

				$aggregated .= $row->meta_value;

			}

			$speech_rows = $wpdb->get_results( "SELECT meta_value FROM `$wpdb->postmeta` where post_id=" . $post_id . " AND (meta_key LIKE '_manual%' OR meta_key LIKE '_project%') " );

			foreach ( $speech_rows as $srow ) {

				$aggregated .= $srow->meta_value;

			}

			$aggregated = md5( $aggregated );

		}

		if ( ! empty( $archive_code ) && ( $archive_code == $aggregated ) ) {

			//echo '<p>Nothing new</p>';

			return; // nothing new here

		}

		if ( empty( $aggregated ) ) {

			//echo '<p>Nothing to record</p>';

			return; // nothing to record

		}

		if(!isset($_GET['tm_ajax']))

			echo '<p>' . __( 'Updating', 'rsvpmaker-for-toastmasters' ) . '</p>';

		update_post_meta( $post_id, 'wpt_archive_code', $aggregated );

		foreach ( $results as $row ) {

			$user_id = (int) $row->meta_value;

			if ( $user_id < 1 ) {

				continue;

			}

			$function = 'update_user_role_archive';

			$role_count = preg_replace('/[^0-9]/','',$row->role);

			if ( strpos( $row->role, 'Speaker' ) ) {

				$manual        = get_post_meta( $post_id, '_manual' . $row->role, true );

				$project_index = get_post_meta( $post_id, '_project' . $row->role, true );

				$title         = get_post_meta( $post_id, '_title' . $row->role, true );

				$intro         = get_post_meta( $post_id, '_intro' . $row->role, true );

				wp4t_record_history_to_table($user_id, $row->role, $timestamp, $post_id, $function, $manual,$project_index,$title,$intro,'',$role_count);

			}

			else

				wp4t_record_history_to_table($user_id, $row->role, $timestamp, $post_id, $function,'','','','','',$role_count);

		}

	}

}



function wp_ajax_tm_edit_detail() {

	global $rsvp_options;

	global $wpdb;

	if(! wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) )

		die('nonce error');

	$roledata = make_tm_speechdata_array( make_tm_roledata_array( 'wp_ajax_tm_edit_detail' ), sanitize_text_field($_POST['manual']), sanitize_textarea_field($_POST['project']), sanitize_text_field( stripslashes( $_POST['title'] ) ), wp_kses_post(stripslashes( $_POST['intro'] )) );

	$user_id  = (int) $_POST['user_id'];

	update_user_meta( $user_id, sanitize_text_field($_POST['tm_details_update_key']), $roledata );

	$key_array  = explode( '|', sanitize_text_field($_POST['tm_details_update_key'] ));

	$role       = $key_array[1];

	$event_date = $key_array[2];

	$rolecount  = $key_array[3];

	$domain     = $key_array[4];

	$post_id    = $key_array[5];

	if ( $_POST['date'] ) {

		if ( ! strpos( $_POST['tm_details_update_key'], $_POST['date'] ) ) {

			$new_key = str_replace( $event_date, $_POST['date'] . ' 00:00:00', sanitize_text_field($_POST['tm_details_update_key'] ));

			$oldkey = sanitize_text_field($_POST['tm_details_update_key']);

			$sql     = "UPDATE $wpdb->usermeta set meta_key='$new_key' WHERE user_id=$user_id AND meta_key='$oldkey'";

			$wpdb->query( $sql );

			rsvpmaker_fix_timezone();

			$date = rsvpmaker_date( $rsvp_options['long_date'], strtotime( $_POST['date'] ) ) . ' (changed date)';

			add_user_meta( $user_id, 'wp4t_stats_delete', sanitize_text_field($_POST['tm_details_update_key']) );

		}

	}

	if ( $post_id && ( $domain == $_SERVER['SERVER_NAME'] ) ) {

		$p = get_post( $post_id ); // make sure it exists

		if ( $p ) {

			update_post_meta( $post_id, '_manual_role_Speaker_' . $rolecount, sanitize_text_field( $_POST['manual'] ) );

			update_post_meta( $post_id, '_project_role_Speaker_' . $rolecount, sanitize_text_field( $_POST['project'] ) );

			update_post_meta( $post_id, '_title_role_Speaker_' . $rolecount, sanitize_text_field( stripslashes( $_POST['title'] ) ) );

			update_post_meta( $post_id, '_intro_role_Speaker_' . $rolecount, sanitize_text_field( stripslashes( $_POST['intro'] ), '<p><br><em><strong><a>' ) );

		}

	}

	if ( empty( $date ) ) {

		$date = rsvpmaker_date( $rsvp_options['long_date'], strtotime( $event_date ) );

	}

	echo '<strong>Updating ' . $role . ' for ' . $date . '</strong>';

	printf( '<br />%s<br />%s<br />%s<br />%s', $_POST['manual'], get_project_text( $_POST['project'] ), stripslashes( $_POST['title'] ), stripslashes( $_POST['intro'] ) );

	echo ' <a href="' . admin_url( 'admin.php?page=toastmasters_reports&toastmaster=' . $user_id ) . '">refresh</a> to see changes.';

	wp_die();

}



add_action( 'wp_ajax_tm_edit_detail', 'wp_ajax_tm_edit_detail' );



function wp_ajax_delete_tm_detail() {

	if( ! wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) )

		die('nonce error');

	global $rsvp_options;

	$key     = sanitize_text_field($_POST['key']);

	$user_id = (int) $_POST['user_id'];

	delete_user_meta( $user_id, $key );

	add_user_meta( $user_id, 'wp4t_stats_delete', $key );

	$key_array = explode( '|', $key );

	// print_r($key_array);

	$role       = $key_array[1];

	$event_date = $key_array[2];

	$rolecount  = $key_array[3];

	$domain     = $key_array[4];

	$post_id    = $key_array[5];

	if ( $post_id && ( $domain = sanitize_text_field($_SERVER['SERVER_NAME']) ) ) {

		$p = get_post( $post_id ); // make sure it exists

		if ( $p ) {

			update_post_meta( $post_id, wp4t_fieldbase($role,$rolecount), 0 );

			if ( $role == 'Speaker' ) {

				delete_post_meta( $post_id, '_manual_role_Speaker_' . $rolecount );

				delete_post_meta( $post_id, '_project_role_Speaker_' . $rolecount );

				delete_post_meta( $post_id, '_title_role_Speaker_' . $rolecount );

				delete_post_meta( $post_id, '_intro_role_Speaker_' . $rolecount );

			}

		}

	}

	echo '<strong>Deleting ' . $role . ' for ' . rsvpmaker_date( $rsvp_options['long_date'], strtotime( $event_date ) ) . '</strong> <a href="' . admin_url( 'admin.php?page=toastmasters_reports&toastmaster=' . $user_id ) . '">refresh</a> to see changes.';

	wp_die();

}



add_action( 'wp_ajax_delete_tm_detail', 'wp_ajax_delete_tm_detail' );



function wp_ajax_editor_assign() {

	if ( !  wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key'))  ) {

		wp_die( 'security error' );

	}

	global $wpdb;

	$post_id   = (int) $_POST['post_id'];

	$user_id   = sanitize_text_field($_POST['user_id']);

	$role      = sanitize_text_field($_POST['role']);

	$editor_id = (int) $_POST['editor_id'];

	$timestamp = get_rsvp_date( $post_id );

	$was       = get_post_meta( $post_id, $role, true );

	update_post_meta( $post_id, $role, $user_id );

	if ( strpos( $role, 'Speaker' ) ) {

		delete_post_meta( $post_id, '_manual' . $role );

		delete_post_meta( $post_id, '_project' . $role );

		delete_post_meta( $post_id, '_title' . $role );

		delete_post_meta( $post_id, '_intro' . $role );

	}

	$name = get_member_name( $user_id );

	printf( '%s assigned to %s', preg_replace( '/[\_0-9]/', ' ', $role ), $name );

	$log = get_member_name( $editor_id ) . ' assigned ' . clean_role( $role ) . ' to ' . get_member_name( $user_id ) . ' for ' . rsvpmaker_date( 'F jS, Y', strtotime( $timestamp ) );

	if ( $was ) {

		$log .= ' (was: ' . get_member_name( $was ) . ')';

	}

	$log .= ' <small><em>(Posted: ' . rsvpmaker_date( 'm/d/y H:i' ) . ')</em></small>';



	add_post_meta( $post_id, '_activity_editor', $log );

	wp_die();

}



add_action( 'wp_ajax_editor_assign', 'wp_ajax_editor_assign' );



function wp_ajax_absences_remove() {

	global $wpdb;

	$post_id = (int) $_POST['post_id'];

	$user_id = (int) $_POST['user_id'];

	if ( $user_id < 1 ) {

		wp_die( 'user id was empty' );

	}

	$userdata = get_userdata( $user_id );

	if ( empty( $userdata->first_name ) ) {

		$name = $userdata->display_name;

	} else {

		$name = $userdata->first_name . ' ' . $userdata->last_name;

	}

	printf( '%s removed from absences list', $name );

	delete_post_meta( $post_id, 'tm_absence', $user_id );

	wp_die();

}



add_action( 'wp_ajax_absences_remove', 'wp_ajax_absences_remove' );



function wp_ajax_editor_absences() {

	global $wpdb;

	$post_id = (int) $_POST['post_id'];

	$user_id = (int) $_POST['user_id'];

	if ( $user_id < 1 ) {

		wp_die( 'user id was empty' );

	}

	$userdata = get_userdata( $user_id );

	if ( empty( $userdata->first_name ) ) {

		$name = $userdata->display_name;

	} else {

		$name = $userdata->first_name . ' ' . $userdata->last_name;

	}

	printf( '%s added to absences list', $name );

	add_post_meta( $post_id, 'tm_absence', $user_id );

	wp_die();

}



add_action( 'wp_ajax_editor_absences', 'wp_ajax_editor_absences' );



function get_tm_stats( $user_id = 0 ) {

	global $current_user;

	global $stats_array;

	if ( ! $user_id ) {

		$user_id = $current_user->ID;

	}



	if ( ! empty( $stats_array[ $user_id ] ) ) {

		return $stats_array[ $user_id ];

	}

	global $wpdb;

	global $rsvp_options;

	// if individual record, sync

	$wpdb->show_errors();

	$count        = array();

	$speech_count = array();

	$speeches     = array();

	$speech_list  = '';

	$editdetail   = array();

	$lastdate     = '';

	if ( isset( $_GET['start_date'] ) ) {

		$start_ts = strtotime( sanitize_text_field($_GET['start_date']) );

	}

    $history_table = $wpdb->base_prefix.'tm_history';

	$speech_history_table = $wpdb->base_prefix.'tm_speech_history';

	$sql     = "SELECT * FROM `$history_table`  LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id WHERE user_id = $user_id AND datetime < NOW()";

	$results = $wpdb->get_results( $sql );

	// print_r($results);

	if ( $results ) {

		foreach ( $results as $row ) {

			$role       = $row->role;

			$event_date = $row->datetime;

			$rolecount  = $row->rolecount;

			$domain     = $row->domain;

			$post_id    = $row->post_id;

			if ( empty( $count[ $role ] ) ) {

				$count[ $role ] = 1;

			} else {

				$count[ $role ]++;

			}

			$roledates[ $role ][] = rsvpmaker_date( 'M j Y', rsvpmaker_strtotime( $event_date ) );

			if ( $role == 'Speaker' ) {

				if ( !empty($row->manual) && empty( $speech_count[ $row->manual ] ) ) {

					$count[ $row->manual ] = $speech_count[ $row->manual ] = 1;

				} elseif ( !empty($row->manual) ) {

					$count[ $row->manual ] = $speech_count[ $row->manual ] = $speech_count[ $row->manual ] + 1;

				}

				if ( empty( $row->project_key ) ) {

					$speech_details = 'Project not specified';

				} else {

					$speech_details = $row->manual . ': ' . $row->project;

				}

				// $speech_details .= '<br />'.var_export($roledata,true);

				if ( ! empty( $row->title ) ) {

					$speech_details .= '<br />' . $row->title;

				}

				if ( !empty($row->intro) ) {

					$speech_details .= '<br />' . $row->intro;

				}

				if ( $domain != $_SERVER['SERVER_NAME'] ) {

					$speech_details .= '<br /><em>' . $domain . '</em>';

				}



				$speech_details = '<p>' . rsvpmaker_date( $rsvp_options['long_date'], strtotime( $event_date ) ) . '<br />' . $speech_details . '</p>';

				if ( empty( $speeches[ $row->manual ] ) ) {

					$speeches[ $row->manual ] = $speech_details;

				} else {

					$speeches[ $row->manual ] .= $speech_details;

				}

				$speech_list .= $speech_details;



			}

			if ( ( current_user_can( 'edit_member_stats' ) ) || ( ( $user_id == $current_user->ID ) && current_user_can( 'edit_own_stats' ) ) ) {

				$form = '';

				if ( $lastdate == $event_date . $role ) {

					$form .= '<div style="color:red; border: thin solid red;">' . __( 'Possible duplicate', 'rsvpmaker-for-toastmasters' ) . '</div>';

				}

				$lastdate = $event_date . $role;

				$field    = preg_replace( '/[^a-zA-Z0-9]/', '', $row->meta_key );

				$form    .= '<p id="delete' . $field . '"><strong>' . $role . ' ' . rsvpmaker_date( $rsvp_options['long_date'], strtotime( $event_date ) ) . ' </strong><button class="delete_tm_detail" key="' . $row->meta_key . '" status="' . $field . '">Delete</button></p>';

				$form    .= sprintf( '<form class="tm_edit_detail" status="%s" method="post" action="%s" id="form' . $field . '"><input type="hidden" name="action" value="tm_edit_detail"><input type="hidden" name="tm_details_update_key" class="tm_details_update_key" id="key_%s" value="%s" /><input type="hidden" name="user_id" id="user_id_%s" value="%d">', $field, admin_url( 'admin.php?page=toastmasters_reports&toastmaster=' ) . $user_id, $row->meta_key, $row->meta_key, $field, $user_id );

				if ( ( $role == 'Speaker' ) && ! empty( $roledata['manual'] ) ) {

					$manual  = ( empty( $roledata['manual'] ) ) ? '' : $roledata['manual'];

					$project = ( empty( $roledata['project'] ) ) ? '' : $roledata['project'];

					$title   = ( empty( $roledata['title'] ) ) ? '' : $roledata['title'];

					$intro   = ( empty( $roledata['intro'] ) ) ? '' : $roledata['intro'];

					$form   .= speaker_details_admin( $user_id, $row->meta_key, $manual, $project, $title, $intro ) . '<p><button>Update</button></p>';

					// sprintf('<p>Manual %s Project %s Title <input type="text" name="title" id="_title_%s" value="%s" /> Intro %s</p><p><button>Update</button></p>',$roledata['manual'],$roledata['project'],$roledata['title'],$roledata['intro']);

				}

				$form .= rsvpmaker_nonce('return').'</form>';

				if ( isset( $_REQUEST['debug'] ) ) {

					$form .= '<div>' . $field . '</div>';

				}

				$editdetail[ $event_date ] = ( isset( $editdetail[ $event_date ] ) ) ? $editdetail[ $event_date ] . $form : $form;

			}

		}// end for loop

	}



	$pure_count = $count;



	$manuals = get_manuals_array();

	$sql     = "SELECT * FROM $wpdb->usermeta where user_id = $user_id AND meta_key LIKE 'tmstat:%'";

	$results = $wpdb->get_results( $sql );

	if ( $results ) {

		foreach ( $results as $row ) {

			$role           = str_replace( 'tmstat:', '', $row->meta_key );

			$count[ $role ] = isset( $count[ $role ] ) ? $count[ $role ] + $row->meta_value : $row->meta_value;

			if ( in_array( $role, $manuals ) ) {

				// printf('<p>%s adjustment: %s</p>'."\n",$role,$row->meta_value);

				$speech_count[ $role ] = isset( $speech_count[ $role ] ) ? $speech_count[ $role ] + $row->meta_value : $row->meta_value;

			}

			if ( isset( $_REQUEST['debug'] ) ) {

				printf( '<p>%s adjustment: %s</p>', $role, $row->meta_value );

			}

		}

	}



	ksort( $editdetail );

	if ( empty( $roledates ) ) {

		$roledates = array();

	}

	$stats_array[ $user_id ] = array(

		'count'        => $count,

		'pure_count'   => $pure_count,

		'speech_count' => $speech_count,

		'speeches'     => $speeches,

		'speech_list'  => $speech_list,

		'editdetail'   => implode( "\n", $editdetail ),

		'roledates'    => $roledates,

	);



	return $stats_array[ $user_id ];

}



function show_evaluation_form( $project, $speaker_id, $meeting_id, $demo = false ) {

	global $wpdb;

	global $current_user;

	global $rsvp_options;

	$is_speech     = true;

	$speaker_email = '';



	if ( preg_match( '/:CL[0-9]/', $project ) ) {

		$manual    = 'Competent Leader';

		$is_speech = false;

	} else {

		$manual = preg_replace( '/\d*$/', '', $project );

	}

	$project_text = get_project_text( $project );

	if ( ! empty( $speaker_id ) ) {

		$speaker_user  = get_userdata( $speaker_id );

		$speaker_name  = $speaker_user->first_name . ' ' . $speaker_user->last_name;

		$speaker_email = $speaker_user->user_email;

	} elseif ( $demo ) {

		$speaker_name = '';

	} else {

		$speaker_name = 'Guest';

	}

	$evaluator = get_userdata( $current_user->ID );

	if ( isset( $_GET['project_year'] ) && ! $demo ) {

		$t         = strtotime( $_GET['project_year'] . '-' . $_GET['project_month'] . '-' . $_GET['project_day'] );

		$timestamp = rsvpmaker_date( 'Y-m-d', $t ) . ' 00:00:00';

		add_member_speech( $speaker_id );

	} else {

		$timestamp = get_rsvp_date( $meeting_id );

		$t         = ( empty( $timestamp ) ) ? time() : strtotime( $timestamp );

	}

	$date = rsvpmaker_date( $rsvp_options['long_date'], $t );

	$slug = $project;



	$name  = $project_text;

	$intro = $prompts = '';



	$form    = fetch_evaluation_form( $project );

	$intro   = $form->intro;

	add_shortcode('evaluation_link','wp4t_evaluation_link');//only used in this context

	$intro = do_shortcode($intro);

	$prompts = $form->prompts;



	// $prompts = get_option('evalprompts:'.$project);

	// $intro = get_option('evalintro:'.$project);

	$name = get_project_text( $project );

	if ( empty( $prompts ) ) {

		if ( $project == 'undefined' ) {

			$intro = '<h4>The specific speech project was not defined, but you can record your notes below.</h4>';

		} else {

				$intro = '<h4>We do not yet have a form with specific prompts for this project, but you can record your notes below.</h4>';

				do_action( 'log_evaluation_form_miss', $project );

		}

		$intro .= '

<p><strong>You excelled at</strong></p>

<p><textarea name="comment[0]" style="width: 100%; height: 3em;"></textarea></p>

<p><strong>You may want to work on</strong></p>

<p><textarea name="comment[1]" style="width: 100%; height: 3em;"></textarea></p>

<p><strong>To challenge yourself</strong></p>

<p><textarea name="comment[2]" style="width: 100%; height: 3em;"></textarea></p>

<p><strong>Other Comments</strong></p>

<p><textarea name="comment[3]" style="width: 100%; height: 6em;"></textarea></p>

';

	}

		// lookup role field, title

		$sql   = "SELECT meta_key from $wpdb->postmeta WHERE post_id=" . $meeting_id . " AND meta_key LIKE '_role_Speaker%' AND meta_value=" . $speaker_id;

		$field = $wpdb->get_var( $sql );

		$title = get_post_meta( $meeting_id, '_title' . $field, true );



	if ( isset( $_GET['_title_meta'] ) ) {

		$title = sanitize_text_field( stripslashes( $_GET['_title_meta'] ) );

		if ( $meeting_id ) {

			update_post_meta( $meeting_id, '_title' . $field, strip_tags( $title ) );

			update_post_meta( $meeting_id, '_manual' . $field, strip_tags( $manual ) );

			update_post_meta( $meeting_id, '_project' . $field, strip_tags( $project ) );

		}

	}



	if ( $project == 'unspecified' ) {

		$project_widget = str_replace( '[]', '_meta', speaker_details( '', 0, array( 'demo' => 1 ) ) );

		$project_widget = str_replace( 'name="_project_meta"', 'name="project"', $project_widget );

		printf(

			'<h2>Add Project Details</h2><form action="%s" method="get"><input type="hidden" name="page" value="wp4t_evaluations">

		<input type="hidden" name="speaker" value="%s" />

		<input type="hidden" name="meeting_id" value="%s" /><div>%s</div><p><button>Save</button></p>%s</form>',

			admin_url( 'admin.php' ),

			$speaker_id,

			$meeting_id,

			$project_widget,

			rsvpmaker_nonce('return')

		);

		echo '<h2>Or use the generic form shown below</h2>';

	}



	?>

<form action="

	<?php

	if ( $demo ) {



		echo get_permalink();

	} else {

		echo admin_url( 'admin.php?page=wp4t_evaluations' );

	}

	?>

			  " method="post">



<h3>Record Evaluation</h3>

<p>Speaker: <input type="text" name="speaker_name" value="<?php echo esc_attr($speaker_name); ?>" /><input type="hidden" name="speaker_id" value="<?php echo esc_attr($speaker_id); ?>" /></p>

<p>Manual/Path: <?php echo esc_attr($manual); ?><input type="hidden" name="manual" value="<?php echo esc_attr($manual); ?>" /></p>

<p>Project: <?php echo esc_attr($project_text); ?><input type="hidden" name="project" value="<?php echo esc_attr($project); ?>" /></p>

	<?php if ( $is_speech ) { ?>

<p>Speech Title: <input type="text" name="speech_title" value="<?php echo esc_attr($title); ?>" /></p>

<?php } ?>

<p>Evaluator: <input type="text" name="evaluator" value="<?php

	if ( ! $demo ) {

		echo esc_attr($evaluator->first_name . ' ' . $evaluator->last_name);

	}

	?>" /></p>

<p>Date: <input type="text" name="timestamp" value="<?php echo esc_attr($date); ?>" /></p>



	<?php

	printf( '<p>Speaker Email Address: <input type="text" name="speaker_email" value="%s"></p>', $speaker_email );

	if ( $demo ) {

		echo '<p>Evaluator Email Address: <input type="text" name="evaluator_email"></p>';

	}



		echo wpautop( $intro );

	if ( ! empty( $prompts ) ) {

		$lines = explode( "\n", $prompts );

		foreach ( $lines as $index => $line ) {

			$line = trim( $line );

			if ( empty( $line ) ) {

				continue;

			}

			if ( strpos( $line, '</h' ) ) {

				echo $line;

				continue;

			}

			$options = explode( '|', $line );

			$prompt  = array_shift( $options );

			echo wpautop( '<strong>' . str_replace( '!', '', $prompt ) . '</strong>' );

			if ( ! empty( $options ) ) {

				echo '<p>';

				foreach ( $options as $option ) {

					trim( $option );

					printf( '<input type="radio" name="check[%d]" value="%s" /> %s ', $index, $option, $option );

				}

				echo '</p>';

			}

			if ( strpos( $prompt, '!' ) ) {

				echo '<input type="hidden" name="comment[' . $index . ']" value="">';

			} else {

				echo '<p><textarea name="comment[' . $index . ']" style="width: 100%; height: 3em;"></textarea></p>';

			}

			$topcount = $index;

		}

	}



		$second_language = ($speaker_id) ? get_user_meta($speaker_id,'second_language_feedback',true) : false;

		if($second_language) {

			echo '<h3>This Member Has Requested Additional Feedback on Language Use</h3><p><strong>Pace: not too fast or too slow</strong><input type="hidden" name="prompt[11]" value="Pace: not too fast or too slow"></p><p><input type="radio" name="check[11]" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check[11]" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check[11]" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check[11]" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check[11]" value="1 (Developing)"> 1 (Developing) </p><p><textarea name="comment[11]" style="width: 100%; height: 3em;"></textarea></p><p><strong>Grammar and word usage</strong><input type="hidden" name="prompt[12]" value="Grammar and word usage"></p><p><input type="radio" name="check[12]" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check[12]" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check[12]" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check[12]" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check[12]" value="1 (Developing)"> 1 (Developing) </p><p><textarea name="comment[12]" style="width: 100%; height: 3em;"></textarea></p><p><strong>Word tense, gender, and pronouns</strong><input type="hidden" name="prompt[13]" value="Word tense, gender, and pronouns"></p><p><input type="radio" name="check[13]" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check[13]" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check[13]" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check[13]" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check[13]" value="1 (Developing)"> 1 (Developing) </p><p><textarea name="comment[13]" style="width: 100%; height: 3em;"></textarea></p><p><strong>Clear pronunciation</strong><input type="hidden" name="prompt[14]" value="Clear pronunciation"></p><p><input type="radio" name="check[14]" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check[14]" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check[14]" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check[14]" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check[14]" value="1 (Developing)"> 1 (Developing) </p><p><textarea name="comment[14]" style="width: 100%; height: 3em;"></textarea></p>';

		}

		else

			echo '<div id="second_language"><input type="checkbox" id="second_language_checkbox" value="'.$topcount.'" /> '.__('Show second language speaker prompts','rsvpmaker-for-toastmasters').'</div>';

	rsvpmaker_nonce();

	echo '<p><button>Submit</button></p>';

	?>

</form>

	<?php

}



add_shortcode( 'wp4t_evaluations_demo2021', 'wp4t_evaluations_demo2021' );



function wp4t_evaluations_demo2021() {

	if ( is_admin() ) {

		return;

	}

	if($_REQUEST['project']) {

		ob_start();

		echo '<style>.time_required, .speaker_introduction {display: none}</style>';

		wp4t_evaluations( true ); // show in demo mode

		return ob_get_clean();	

	}



	$projects = get_projects_array();

	$lastpath = '';

	$rsvpnonce = rsvpmaker_nonce('query');

	$output = '';

	$list = '';

	$pathways = false;

	$pattern = '<p><a href="'.get_permalink().'?meeting_id=0&post_id=425&_manual_meta=%s&project=%s&_display_time_meta&_maxtime_meta=0&_title_meta&_intro_meta&project_year='.date('Y').'&project_month='.date('m').'&project_day='.date('m').'&timelord='.$rsvpnonce.'">%s: %s</a></p>';

	foreach($projects as $index => $project) {

		if(strpos($index,'Not Set') )

			continue;

		if(!$pathways && !strpos($index,'Level') )

			continue;

		$pathways = true;

		$manual = preg_replace('/ \d{1,10}$/','',$index);

		if($manual == 'HIGH PERFORMANCE LEADERSHIP')

			break;

		$path = preg_replace('/ Level.+/','',$manual);

		if($path != $lastpath) {

			$anchor = str_replace(' ','',$path);

			$output .= sprintf('<h2 id="%s">%s</h2>',$anchor,$path);

			$list .= sprintf('<p><a href="#%s">%s</a></p>',$anchor,$path);

		}

		$lastpath = $path;

		$output .= sprintf($pattern, $manual, $index, $manual, $project);

	}

	return $list.$output;

	//if(is_user_logged_in())

		//return 'Please log out before using this version of the evaluation form.';

}



function get_evaluator_postdata() {

	$evaluator['display_name'] = ( isset( $_POST['evaluator'] ) ) ? sanitize_text_field($_POST['evaluator']) : '';

	$evaluator['user_email']   = ( isset( $_POST['evaluator_email'] ) ) ? sanitize_text_field($_POST['evaluator_email']) : '';

	return (object) $evaluator;

}



function wp4t_evaluations( $demo = false ) {

	global $current_user, $rsvp_options, $wpdb, $toast_roles, $competent_leader;



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



	if ( isset( $_GET['import_eval'] ) ) {

		$imports = 0;

		$url     = 'http://wp4toastmasters.com/wp-json/evaluation/v1/form/all';

		printf( '<p>Look up %s</a>', $url );

		$args    = array( 'timeout' => 20 );

		$request = wp_remote_get( $url, $args );

		if ( is_wp_error( $request ) ) {

			printf( '<div class="notice">Import failed: connection may have timed out. <a href="%s">retry</a></div>', admin_url( 'admin.php?page=wp4t_evaluations&import_eval=1' ) );

		} else {

			$body = wp_remote_retrieve_body( $request );

			$data = json_decode( $body );

			if ( empty( $data ) || ! is_array( $data ) ) {

				echo '<div class="notice">Import failed: data error</div>';

			} else {

				foreach ( $data as $row ) {

					$slug       = $row->option_name;

					$serialized = $row->option_value;

					$prompts    = (object) unserialize( $serialized );

					update_option( $slug, $prompts );

					$imports++;

				}

			}

			if ( $imports ) {

				echo '<div class="notice notice-success">' . $imports . ' forms imported</div>';

				update_option( 'evaluation_forms_updated', time() );

			}

		}

	} elseif ( current_user_can( 'manage_options' ) ) {

		$updated_text = 'Never';

		if ( $updated ) {

			$updated_text = rsvpmaker_date( 'r', $updated );

		}

		//printf( '<div class="notice notice-info"><p><a href="%s">Check for updates</a> from wp4toastmasters.com. Current as of: %s</p></div>', admin_url( 'admin.php?page=wp4t_evaluations&import_eval=1' ), $updated_text );

	}

?>

	<h2 class="rsvpmaker-nav-tab-wrapper nav-tab-wrapper">

	  <a class="nav-tab nav-tab-active" href="#main">Evaluations</a>

	  <a class="nav-tab" href="#myevaluations">Evaluations Received</a>

	  <a class="nav-tab" href="#others">Evaluations Given</a>

	</h2>

	<div id="sections" class="toastmasters rsvpmaker" >

	<section id="main">

	<div style="width: 800px;" mode="evaluation_admin" id="react-agenda">Loading &#8230;</div>

	</section>

	<section class="rsvpmaker" id="myevaluations">

			<?php

			global $current_user;

			$sql     = "SELECT * FROM $wpdb->usermeta WHERE user_id=" . $current_user->ID . " AND meta_key LIKE 'evaluation|%' ORDER BY meta_key DESC";

			$results = $wpdb->get_results( $sql );

			if ( $results ) {

				echo '<h3>Evaluations of My Speeches</h3>';

				foreach ( $results as $row ) {

					$key   = $row->meta_key;

					$parts = explode( '|', $key );

					// print_r($parts);

					$timestamp    = $parts[1];

					$project      = $parts[2];

					$project_text = get_project_text( $project );

					$excerpt      = substr( strip_tags( $row->meta_value ), 0, 200 );

					printf( '<p><a target="_blank" href="%s">%s %s</a><br />%s</p>', site_url( '?show_evaluation=' . $key ), $project_text, rsvpmaker_date( $rsvp_options['long_date'], strtotime( $timestamp ) ), $excerpt ) . "\n";

				}

			}



			?>

		</section>

		<section class="rsvpmaker" id="others">

			<?php



			$sql     = "SELECT * FROM $wpdb->usermeta WHERE meta_key LIKE 'evaluation|%|" . $current_user->user_login . "' ORDER BY meta_key DESC";

			$results = $wpdb->get_results( $sql );

			if ( $results ) {

				echo '<h3>My Evaluations of Others</h3>';

				foreach ( $results as $row ) {

					$key   = $row->meta_key;

					$parts = explode( '|', $key );

					// print_r($parts);

					$timestamp    = $parts[1];

					$project      = $parts[2];

					$project_text = get_project_text( $project );

					$excerpt      = substr( strip_tags( $row->meta_value ), 0, 200 );

					printf( '<p><a target="_blank" href="%s">%s %s</a><br />%s</p>', site_url( '?show_evaluation=' . $key . '&member_id=' . $row->user_id ), $project_text, rsvpmaker_date( $rsvp_options['long_date'], strtotime( $timestamp ) ), $excerpt ) . "\n";

				}

			}

			?>

		</section>

	</div>

	<?php

}



function clean_bullets( $text, $replace = '' ) {

	$newtext = '';

	$lines   = explode( "\n", $text );

	foreach ( $lines as $line ) {

		$line = trim( $line );

		if ( empty( $line ) ) {

			$newtext .= "\n";

			continue;

		}

		$newtext .= preg_replace( '/^[^A-Za-z\\&;]+/', $replace, $line ) . "\n";

	}

	return $newtext;

}



function show_evaluation() {

	if ( isset( $_REQUEST['show_evaluation'] ) && is_user_logged_in() ) {

		global $current_user;

		$user_id = ( isset( $_REQUEST['member_id'] ) ) ? (int) $_REQUEST['member_id'] : $current_user->ID;

		$eval    = get_user_meta( $user_id, sanitize_text_field($_REQUEST['show_evaluation']), true );

		printf( '<html><title>Evaluation</title><body>%s</body></html>', $eval );

		exit();

	}



}



add_action( 'init', 'show_evaluation' );



function pathways_checklist( ) {

	?>

<style>

.pathways_title {font-weight: bold;}

label {

	display: inline-block;

	width: 200px;

}

.speechdetails input {

	width: 400px;

}

</style>

	<h1>Base Camp Checklist</h1>

	<p>Use this screen to keep track of which Pathways projects recorded on the website have also been recorded in Base Camp. If you are a member of multiple clubs, you can track which club you credited a speech to (<a href="#addclubs">Add Clubs</a>).</p>

	<?php

	global $current_user, $rsvp_options, $wpdb;

	$speech_history = $wpdb->base_prefix."tm_speech_history";

	$clubs = get_user_meta($current_user->ID,'basecamp_clubs',true);

	if(empty($clubs))

		$clubs = array();



	if(isset($_POST['record'])) {

		foreach($_POST['record'] as $record) {

			$record = explode(':',sanitize_text_field($record));

			$sql = $wpdb->prepare("UPDATE $speech_history SET basecamp_record=%s WHERE speech_id=%d",$record[1],$record[0]);

			$wpdb->query($sql);

		}

	}

	if(isset($_POST['reset']))

		{

			foreach($_POST['reset'] as $reset) {

				$wpdb->query("UPDATE $speech_history set basecamp_record='' WHERE speech_id=".intval($reset));

			}

		}

	if(isset($_POST['moreclubs']))

	{

		$lines = explode("\n",$_POST['moreclubs']);

		foreach($lines as $line) {

			$line = trim(sanitize_text_field($line));

			if(!empty($line))

				$clubs[] = $line;

		}

		update_user_meta($current_user->ID,'basecamp_clubs',$clubs);

	}



	if(isset($_POST['speech_edit'])) {

		$speech_id = intval($_POST['speech_edit']);

		$manual = sanitize_text_field($_POST['path']);

		$project = sanitize_text_field(stripslashes($_POST['project']));

		$title = sanitize_text_field(stripslashes($_POST['title']));

		$basecamp_record = sanitize_text_field(stripslashes($_POST['basecamp_record']));

		$sql =	$wpdb->prepare("UPDATE $speech_history set manual=%s, project=%s, title=%s, basecamp_record=%s WHERE speech_id=%d",$manual, $project, $title, $basecamp_record, $speech_id);

		$wpdb->query($sql);

	}



	if(isset($_GET['speech_edit'])) {

		$speech_id = intval($_GET['speech_edit']);

		$sql = "SELECT * FROM `".$wpdb->base_prefix."tm_speech_history` JOIN ".$wpdb->base_prefix."tm_history ON history_id = ".$wpdb->base_prefix."tm_history.id WHERE speech_id=$speech_id";

		$row = $wpdb->get_row($sql);

		$pathways_levels = get_pathways();

		$path_options = '';

		foreach($pathways_levels as $pl) {

			$s = ($row->manual == $pl) ? ' selected="selected" ' : '';

			$path_options .= sprintf('<option value="%s" %s>%s</option>',$pl, $s, $pl);

		}



		printf('<form method="post" action="%s"><input type="hidden" name="speech_edit" value="%d">

		<p><label>Path/Level</label> <select name="path">%s</select></p>

		<div class="speechdetails">

		<p><label>Project</label> <input type="text" name="project" value="%s"></p>

		<p><label>Title</label> <input type="text" name="title" value="%s"></p>

		<p><label>Club Credited in Base Camp</label> <input type="text" name="basecamp_record" value="%s"></p>

		</div>

		<p><button>Update</button></p>

		</form>',admin_url('admin.php?page=pathways_checklist'),$speech_id, $path_options, $row->project, $row->title, $row->basecamp_record);

	}



	printf('<form method="post" action="%s">',admin_url('admin.php?page=pathways_checklist'));

	$startclubs = $clubs;

	$toastmasters_id = (isset($_REQUEST['toastmasters_id'])) ? intval($_REQUEST['toastmasters_id']) : $current_user->ID;

	$done = '';

	$sql = "SELECT * FROM `".$wpdb->base_prefix."tm_speech_history` JOIN ".$wpdb->base_prefix."tm_history ON history_id = ".$wpdb->base_prefix."tm_history.id WHERE `project_key` LIKE '%level%' AND `user_id`=$toastmasters_id ORDER BY datetime DESC";

	$results = $wpdb->get_results($sql);

	//(object) array( 'speech_id' => '1330', 'history_id' => '8716', 'manual' => 'Engaging Humor Level 3 Increasing Knowledge', 'project_key' => 'Engaging Humor Level 3 Increasing Knowledge 14085', 'project' => 'Focus on the Positive', 'title' => 'In praise of in person', 'intro' => '', 'id' => '8716', 'role' => 'Speaker', 'datetime' => '2022-02-04 07:00:00', 'rolecount' => '1', 'domain' => 'www.clubawesome.org', 'user_id' => '1', 'post_id' => '6936', 'metadata' => 'a:3:{s:13:"time_recorded";i:1643977517;s:11:"recorded_by";s:5:"abern";s:8:"function";s:24:"update_user_role_archive";}', 'timestamp' => '2022-02-04 12:25:17', )

	foreach($results as $row) {

		if($row->domain == 'demo.toastmost.org')

			continue;

		$name = $row->domain;

		if(!empty($clubs[$row->domain]))

			$name = $clubs[$row->domain];

		else 

		{

			if(is_multisite()) {

				$sql = "SELECT blog_id FROM $wpdb->blogs WHERE domain='$row->domain' ";

				//echo $sql;

				$blog_id = $wpdb->get_var($sql);

				if($blog_id) {

					$name = get_blog_option($blog_id,'blogname');

					//printf('<p>%d %s</p>',$blog_id, $name);

				}

			}

			$clubs[$row->domain] = $name;

		}

		$t = rsvpmaker_strtotime($row->datetime);

		$date = rsvpmaker_date($rsvp_options['long_date'],$t);



		$speech_data = sprintf('<p>%s: %s <span class="pathways_title">%s</span> %s @ %s (<a href="%s">Edit</a>)</p>', $row->manual, $row->project, $row->title, $date, $name, admin_url('admin.php?page=pathways_checklist&speech_edit='.$row->speech_id));

		if($row->basecamp_record) {

			$done .= $speech_data . sprintf('<p><span style="color: green;">&check; Recorded for </span>%s <input type="checkbox" name="reset[]" value="%d" > Reset</p>',$row->basecamp_record,$row->speech_id);

			if(empty($manual_speeches[$row->manual]))

				$manual_speeches[$row->manual] = 1;

			else

				$manual_speeches[$row->manual]++;

		}

		else 

			{

				echo $speech_data;

				echo '<p>Record for ';

				foreach($clubs as $club)

				printf('<input type="checkbox" name="record[]" value="%d:%s" > %s ',$row->speech_id,$club, $club);

				echo '</p>';

			}

	}

echo '<button>Update</button></form>';



if(!empty($done))

echo '<h2>Previously Recorded</h2>'.$done;



if(!empty($manual_speeches)) {

	ksort($manual_speeches);

	foreach($manual_speeches as $manual => $count)

		printf('<h3>%s: %d</h3>',$manual, $count);

}



printf('<h2 id="addclubs">Add Clubs</h2>

<form method="post" action="%s">

<p>List additional clubs, 1 per line</p>

<textarea name="moreclubs">

</textarea>

<button>Add</button></form><p>Current list: %s</p>',admin_url('admin.php?page=pathways_checklist'),implode(",",$clubs));



if($clubs != $startclubs)

	update_user_meta($current_user->ID,'basecamp_clubs',$clubs);

}



function pathways_report( $toastmaster = 0 ) {

	global $current_user;

	global $rsvp_options;

	?>

<p>This report is based on speech projects recorded through the agenda system. Check it against the reports in BaseCamp.</p>

	<?php

	if ( isset( $_REQUEST['toastmaster'] ) ) {

		$toastmaster = (int) $_REQUEST['toastmaster'];

	}

	if ( empty( $toastmaster ) ) {

		$users = get_users();

		foreach ( $users as $user ) {

			$userdata            = get_userdata( $user->ID );

			$key                 = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name );

			$indexeduser[ $key ] = sprintf( '<h3>%s %s (<a href="%s">details</a>)</h3>', $userdata->first_name, $userdata->last_name, admin_url( 'admin.php?page=toastmasters_reports&active=pathways&toastmaster=' ) . $user->ID );



			$stats     = get_tm_stats( $user->ID );

			$pathgraph = array();

			$p         = '';

			foreach ( $stats['count'] as $mkey => $count ) {

				if ( strpos( $mkey, 'Level' ) ) {

						$p         .= sprintf( '<p><strong>%s</strong> %s</p>', $count, $mkey );

						$parts      = explode( ' Level ', $mkey );

						$graphpath  = $parts[0];

						$graphlevel = (int) $parts[1];

					if ( empty( $pathgraph[ $graphpath ][0] ) || ( $pathgraph[ $graphpath ][0] < $graphlevel ) ) {

						$pathgraph[ $graphpath ][0] = $graphlevel;// highest level recorded

					}

						$pathgraph[ $graphpath ][ $graphlevel ] = $count;

				}

			}

			if ( ! empty( $p ) ) {

				$userdata              = get_userdata( $user->ID );

				$pathgraphsort[ $key ] = $pathgraph;

			}

		}

		// echo implode("\n",$path);

		echo '<style>

		.pathlevel {

			width: 19%;

			border: thin solid red;

			display: inline-block;

			height: 15px;

			text-align: center;

			padding: 5px;

		}

		.pathprogress {

			background-color: red;

		}

		.pathdata {

			background-color: #fff;

		}

		</style>';

		ksort( $indexeduser );

		foreach ( $indexeduser as $key => $name ) {

			printf( '<h3>%s</h3>', $name );

			if ( empty( $pathgraphsort[ $key ] ) ) {

					echo '<p>' . __( 'No Pathways projects recorded', 'rsvpmaker-for-toastmasters' ) . '</p>';

					continue;

			}

			$data = $pathgraphsort[ $key ];

			foreach ( $data as $manual => $levelprojects ) {

					printf( '<p>%s</p><div>', $manual );

				for ( $i = 1; $i <= 5; $i++ ) {

					if ( empty( $levelprojects[ $i ] ) ) {

						$otherclass = ( $levelprojects[0] > $i ) ? 'pathprogress' : 'other:' . $levelprojects[0] . ':' . $i;

						echo '<div class="pathlevel ' . $otherclass . '">-</div>';

					} else {

						printf( '<div class="pathlevel pathprogress"><span class="pathdata">Level %d: %d</span></div>', $i, $levelprojects[ $i ] );

					}

				}

					echo '</div>';

			}

		}

		return;

	}



	$stats   = get_tm_stats( $toastmaster );

	$manuals = get_manuals_array();

	foreach ( $manuals as $manual => $label ) {

		if ( ! strpos( $manual, 'Level' ) ) {

			continue; // no level, not pathways

		}

		$notes = get_user_meta( $toastmaster, 'tmnote_' . $manual );

		if ( ! empty( $stats['speeches'][ $manual ] ) || ! empty( $notes ) ) {

			printf( '<h2>%s</h2>', esc_html($label) );

			if ( ! empty( $stats['speeches'][ $manual ] ) ) {

				echo sanitize_text_field($stats['speeches'][ $manual ]);

			}

			if ( ! empty( $notes ) ) {

				echo '<p><strong>Notes</strong></p>';

				foreach ( $notes as $note ) {

					echo wpautop( sanitize_textarea_field($note) );

				}

			}

			$mslug = str_replace( ' ', '_', $manual );

			?>

<form action="<?php echo admin_url( 'admin.php?page=toastmasters_reports&toastmaster=' . intval($toastmaster) ); ?>" method="post" id="<?php echo esc_attr($mslug); ?>">

<div class="pathwaysnote_entry"><textarea name="pathwaysnote" rows="2" style="width: 100%"></textarea></div>

<input type="hidden" name="tmnote" value="tmnote_<?php echo esc_attr($manual); ?>">

<button target="<?php echo esc_attr($mslug); ?>">Add Note</button>

<?php rsvpmaker_nonce(); ?>

</form>

			<?php

		}

	}

	?>

<p><strong>About this screen:</strong> The preliminary support for Pathways in WordPress for Toastmasters includes tracking of speeches, along with a space to add notes about aspects of the program other than speeches.</p>

	<?php

}



add_action( 'wp_ajax_edit_member_stats', 'wp_ajax_edit_member_stats' );



function wp_ajax_edit_member_stats() {



			$id       = intval($_REQUEST['toastmaster']);

			$userdata = get_userdata( $id );

			$tmstats  = get_tm_stats( $userdata->ID );

			$stats    = $tmstats['pure_count'];

	if ( ! empty( $_POST['education_awards'] ) ) {

		update_user_meta( $id, 'education_awards', sanitize_text_field($_POST['education_awards']) );

	}

	foreach ( $_POST['stat'] as $field => $value ) {

		$field = sanitize_text_field($field);

		$value = sanitize_text_field($value);

		if ( ( $value == '' ) || ( $value == 0 ) ) {

			delete_user_meta( $id, 'tmstat:' . $field );

			continue;

		}

		if ( empty( $stats[ $field ] ) ) {

			$stats[ $field ] = 0;

		}

		$adj = $value - $stats[ $field ];

		if ( $adj != 0 ) {

			update_user_meta( $id, 'tmstat:' . $field, $adj );

		}

	}

	foreach ( $_POST['add_project'] as $manual => $p ) {

		if ( ! empty( $p ) ) {

				$projectslug = preg_replace( '/[ _]/', '', $manual ) . '_project';

				$year        = sanitize_text_field($_POST['project_year'][ $manual ]);

				$month       = sanitize_text_field($_POST['project_month'][ $manual ]);

				$day         = sanitize_text_field($_POST['project_day'][ $manual ]);

			if ( $year && $month && $day ) {

				$date = strtotime( $year . '-' . $month . '-' . $day );

			} else {

				$date = time();

			}

			$text = get_project_text( $p );

			$pa   = array(

				'title'  => $text,

				'date'   => $date,

				'source' => 'meta',

			);

			add_user_meta( $id, $projectslug, $pa );

		}

	}

	if ( isset( $_POST['delete_meta'] )  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST['delete_meta'] as $deletethis ) {

			$deletethis = str_replace( ' ', '_', sanitize_text_field($deletethis) );

			delete_user_meta( $id, $deletethis );

			add_user_meta( $id, 'wp4t_stats_delete', $deletethis );

			echo "delete $deletethis <br />";

		}

	}



		echo '<div class="updated"><p>' . __( 'Updated', 'rsvpmaker-for-toastmasters' ) . '</p></div>';

	wp_die();

}



function wpt_json_user_id( $user_id, $toastmasters_id ) {

	global $wpdb;

	global $rsvp_options;

	$history_table = $wpdb->base_prefix.'tm_history';



	$up   = 0;

	$down = 0;

	if ( ! get_option( 'wp4toastmasters_enable_sync' ) ) {

		return 'Data sync between WordPress for Toastmasters websites disabled';

	}

	if ( ! $toastmasters_id ) {

		return 'To sync data, first add Toastmasters ID to member profile';

	}

	$last_sync = (int) get_user_meta( $user_id, 'tm_last_stats_sync', true );

	if ( $last_sync && ( $last_sync > strtotime( '-1 day' ) ) && ! isset( $_REQUEST['debug'] ) && ! isset( $_REQUEST['syncnow'] ) ) {

		return 'Last data sync within 24 hours (<a href="' . $_SERVER['REQUEST_URI'] . '&syncnow=1">sync now</a>)';

	}

	update_user_meta( $user_id, 'tm_last_stats_sync', time() );

	$results = wp4t_history_query("user_id=" . $user_id . " AND domain='" . $_SERVER['SERVER_NAME'] . "' '");

	foreach ( $results as $row ) {

	$row->toastmasters_id = $toastmasters_id;

	$json_data[] = $row;

	}

	return wpt_json_send( $json_data ) . ' user id: ' . $user_id . ' toastmasters id: ' . $toastmasters_id;

}



function get_toastmasters_ids() {

	$users = get_users();

	$tmids = array();

	foreach ( $users as $user ) {

		$t = get_user_meta( $user->ID, 'toastmasters_id', true );

		if ( $t ) {

			$tmids[ $user->ID ] = $t;

		}

	}

	return $tmids;

}



function wpt_json_batch_upload() {

	global $wpdb;

	$wpdb->show_errors();

	$where = "domain='".$_SERVER['SERVER_NAME']."' ";

	$last_wpt_json_batch_upload_timestamp = get_option( 'last_wpt_json_batch_upload_timestamp' );

	if($last_wpt_json_batch_upload_timestamp)

		$where .= " AND timestamp > '$last_wpt_json_batch_upload_timestamp' ";

	$results = wp4t_history_query(['where' => $where, 'orderby' => 'timestamp', 'limit' => 500]);

	if ( $results ) {

		$tmids = get_toastmasters_ids();

		foreach ( $results as $row ) {

			$last = $row->timestamp;

			if ( isset( $tmids[ $row->user_id ] ) ) {

				$row->toastmasters_id = $tmids[ $row->user_id ];

				$json_data[] = $row;

			}

		}

		update_option( 'last_wpt_json_batch_upload_timestamp', $last );

	}

	if ( isset( $json_data ) ) {

		$result = wpt_json_send( $json_data, true );

		global $successful_upload;

		if ( $successful_upload ) {

			update_option( 'last_wpt_json_batch_upload', $last );

		}

		return $result;

	}

}



function wpt_json_send( $json_data, $upload_only = false ) {

	global $wpdb;

	$history_table = $wpdb->base_prefix.'tm_history';



	global $successful_upload;

	$successful_upload = false;

	$json              = json_encode( $json_data );

	$p = get_option( 'wpt_stats_warehouse_password' );

	if ( empty( $p ) ) {

		$p = wp_generate_password();

		update_option( 'wpt_stats_warehouse_password', $p );

	}

	$url = 'https://wp4toastmasters.com/?wpt_stats_warehouse=' . $_SERVER['SERVER_NAME'] . '&p=' . $p;

	if ( $upload_only ) {

		$url .= '&upload_only=1';

	}

	$args     = array(

		'method'      => 'POST',

		'body'        => $json,

		'headers'     => array(

			'Content-Type' => 'application/json',

		),

		'timeout'     => 60,

		'redirection' => 5,

		'blocking'    => true,

		'httpversion' => '1.0',

		'sslverify'   => false,

		'data_format' => 'body',

	);

	$response = wp_remote_request( $url, $args );

	$json_response = json_decode( $response['body'], true );



	if ( ! isset( $json_response['log'] ) ) {

		update_option( 'sync_error_json_log', $response );

		//return 'Sync error, logged to sync_error_json_log';

	}

	$log = $json_response['log'];

	if ( ! isset( $json_response['uploaded'] ) ) {

		update_option( 'sync_error_json_log', $json_response['log'] );

		//return 'Sync error, logged to sync_error_json_log';

	}

	update_option( 'last_sync_result', var_export( $json_response, true ) );

	$download = $json_response['download'];

	$uploaded = $json_response['uploaded'];

	$deleted  = $json_response['deleted'];

	$members  = $json_response['members'];

	if ( isset( $_REQUEST['debug'] ) ) {

		echo '<pre>';

		echo "JSON UP\n";

		print_r( $json_data );

		echo "response\n";

		print_r( $json_response );

		echo '</pre>';

	}

	$down = 0;

	if ( isset( $download ) && is_array( $download ) ) {

		$down = sizeof($download);

		foreach ( $download as $row ) {

			if ( ! $row["toastmasters_id"] ) {

				continue;

			}

			$sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key='toastmasters_id' AND meta_value='" . $row["toastmasters_id"]."' ";

			$user_id = $wpdb->get_var( $sql );

			if ( ! $user_id ) {

				continue;

			}

			$sql = $wpdb->prepare("SELECT timestamp from $history_table WHERE role=%s AND domain=%s AND datetime=%s",$row['role'],$row['domain'],$row['datetime']);

			$local_timestamp = $wpdb->get_var($sql);

			if(empty($local_timestamp) || ($local_timestamp < $row['timestamp_origin']) )//if we don't have it or our copy is older

				{

					wp4t_record_history_to_table($user_id, $row['role'], $row['datetime'], 0, 'sync with wp4toastmasters.com', $row["manual"],$row['project'],$row['title'],'', $row['domain'], $row['rolecount']);

					if(isset($_GET['debug']))

						printf('<p>Newer %s < %s</p>',$local_timestamp,$row['timestamp_origin']);

				}

			else {

				if(isset($_GET['debug']))

					printf('<p>Older %s > %s</p>',$local_timestamp,$row['timestamp_origin']);

			}

		}

	}

	$successful_upload = true;

	return "Data sync result uploaded $uploaded records, deleted $deleted, downloaded $down for $members members";

}



function toastmasters_role_report() {

	global $wpdb, $rsvp_options;

	echo '<p>' . __( 'This page shows the number of times a member has served in a given role, followed by the month and year of the most recent occurrance', 'rsvpmaker-for-toastmasters' ),'</p>';

	$allroles = array();

	$users    = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $users as $user ) {

		$ud = get_userdata( $user->ID );

		$userroles[ $ud->last_name . $ud->first_name ]['name'] = $ud->first_name . ' ' . $ud->last_name;

		if ( isset( $_GET['all'] ) ) {

			$where = " user_id=$user->ID ";

		} else {

			$where = " user_id=$user->ID AND domain='" . $_SERVER['SERVER_NAME'] . "' ";

		}

		$results = wp4t_history_query($where);

		if ( ! $results ) {

			continue;

		}

		foreach ( $results as $row ) {

			$role = $row->role;

			$date = $row->datetime;

			$userroles[ $ud->last_name . $ud->first_name ]['roledates'][ $role ][] = $date;

			if ( ! in_array( $role, $allroles ) ) {

				$allroles[] = $role;

			}

		}

	}

	ksort( $userroles );

	if ( isset( $_GET['details'] ) ) {

		foreach ( $userroles as $userroledata ) {

			echo '<h2>' . $userroledata['name'] . '</h2>';

			if ( empty( $userroledata['roledates'] ) ) {

				continue;

			}

			ksort( $userroledata['roledates'] );

			foreach ( $userroledata['roledates'] as $role => $dates ) {

				$d = '';

				if ( ! empty( $dates ) ) {

					foreach ( $dates as $date ) {

						$d .= rsvpmaker_date( 'M d, Y', rsvpmaker_strtotime( $date ) ) . ' ';

					}

				}

				printf( '<div>%s: <strong>%d</strong>, %s</div>', $role, count( $dates ), $d );

			}

		}

	}



	if ( isset($_POST['roles'])  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$report_roles = array_map('sanitize_text_field',$_POST['roles']);

		update_option( 'roles_report_roles', $report_roles );

	} else {

		$report_roles = get_option( 'roles_report_roles' );

	}

	if ( empty( $report_roles ) ) {

		global $toast_roles;

		$report_roles = $toast_roles;

	}



	$back6 = strtotime( '-6 month' );



	echo '

	<style>

	th.role {width: 50px;font-size: 10px;}

	td {text-align: center;}

	td.nope {

	background-color: #FFFF80;

	}

	.notlately {

	background-color: #FFFFE0;

	}

	</style>

	<p><span class="notlately">Highlighted items are from more than 6 months ago</span></p>

	<table border="1">';

	echo '<tr><th>Name</th>';

	foreach ( $report_roles as $index => $role ) {

		if ( ! in_array( $role, $allroles ) ) {

			continue;

		}

		printf( '<th class="role">%s</th>', $role );

	}

	echo '</tr>';

	foreach ( $userroles as $userroledata ) {

		echo '<tr><td>' . $userroledata['name'] . '</td>';

		foreach ( $report_roles as $role ) {

			if ( ! in_array( $role, $allroles ) ) {

				continue;

			}

			$class = '';

			if ( empty( $userroledata['roledates'][ $role ] ) ) {

				$out = '-<br />&nbsp;';

				// $class = 'nope';

			} else {

				$t   = strtotime( $userroledata['roledates'][ $role ][0] );

				$out = count( $userroledata['roledates'][ $role ] ) . '<br />' . date( 'My', $t );

				if ( $t < $back6 ) {

					$class = 'notlately';

				}

				// $out .= var_export($userroledata['roledates'][$role],true);

			}

			printf( '<td class="%s">%s</td>', $class, $out );// var_export($userroledata['roledates'][$role],true));

		}

		echo '</tr>';

	}

	echo '</table>';



	printf( '<p><a href="%s">Show more detail</a></p>', admin_url( 'admin.php?page=toastmasters_reports_dashboard&report=role&details=1' ) );



	printf( '<h2>Set Report Roles</h2><form action="%s" method="post">', site_url( sanitize_text_field($_SERVER['REQUEST_URI']) ) );

	sort( $allroles );

	foreach ( $allroles as $role ) {

		$checked = ( in_array( $role, $report_roles ) ) ? ' checked="checked" ' : '';

		printf( '<input type="checkbox" name="roles[]" value="%s" %s > ', $role, $checked );

		echo esc_html($role) . '<br />';

	}

	submit_button( 'Set Roles List' );

	rsvpmaker_nonce();

	echo '</form>';

	// tm_admin_page_bottom($hook);

}



function get_speech_points( $user_id ) {

	global $wpdb, $rsvp_options;

	$rules = get_option( 'toastmasters_rules' );

	if ( empty( $rules ) ) {
		$rules = array();
		$rules['cost']       = 2;
		$rules['start']      = 4;
		$rules['start_date'] = date( 'Y' ) . '-01-01';
	}

	$start_date = $rules['start_date'] . ' 00:00:00';

	$sname = sanitize_text_field($_SERVER['SERVER_NAME']);

	$results = wp4t_history_query(['where'=>"user_id=$user_id AND domain ='$sname'",'orderby'=>'datetime']);

	if ( ! $results ) {

		return sanitize_text_field($rules['start']);

	}



	$userroles = array();



	foreach ( $results as $row ) {

		$role = $row->role;

		$date = $row->datetime;

		if ( $date < $start_date ) {

			continue;

		}

		if ( empty( $userroles[ $role ] ) || ! in_array( $date, $userroles[ $role ] ) ) {

			$userroles[ $role ][] = $date;

		}

		// if(!in_array($role,$allroles)) $allroles[] = $role;

	}



	$speaking   = 0;

	$other_role = (int) $rules['start']; // starting score

	foreach ( $userroles as $role => $occurrences ) {

		if ( strpos( $role, 'ackup' ) ) {

		} elseif ( $role == 'Speaker' ) {

				$speaking = $speaking + sizeof( $occurrences );

				// print_r($occurrences);

		} else {

				$other_role = $other_role + sizeof( $occurrences );

		}

	}



	$speakingpoints = $speaking * $rules['cost'];

	$score          = $other_role - $speakingpoints;

	return $score;

}



function speech_points_report() {

	global $wpdb, $rsvp_options;

	echo '<p>' . __( 'This report shows how often a member speaks, versus serving the club in other supporting roles.', 'rsvpmaker-for-toastmasters' ),'</p>';



	$rules = get_option( 'toastmasters_rules' );

	if ( empty( $rules ) ) {

		$rules['cost']       = 2;

		$rules['start']      = 4;

		$rules['start_date'] = date( 'Y' ) . '-01-01';

	}

	$prettystart = date( 'M j, Y', strtotime( $rules['start_date'] ) );

	printf( '<p>Members start with %s points. They <em>earn</em> 1 point for each supporting role filled and <em>use %s points</em> for each speech. Statistics gathered from %s.</p>', $rules['start'], $rules['cost'], $prettystart );

	if ( current_user_can( 'manage_options' ) ) {

		printf( '<p>You can change these parameters on the Rules tab of the <a href="%s">Toastmasters Settings</a> screen.</p>', admin_url( 'http://beta.local/wp-admin/options-general.php?page=wp4toastmasters_settings' ) );

	} else {

		echo '<p>These parameters can be changed by a site administrator.</p>';

	}



	$start_date = $rules['start_date'] . ' 00:00:00';



	$allroles = array();

	$users    = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $users as $user ) {

		$ud = get_userdata( $user->ID );

		$userroles[ $ud->last_name . $ud->first_name ]['name'] = $ud->first_name . ' ' . $ud->last_name;

		$results = wp4t_history_query(['where'=>"user_id=$user->ID AND domain='" . $_SERVER['SERVER_NAME'] . "' ",'orderby'=>'datetime']);

		if ( ! $results ) {

			continue;

		}



		foreach ( $results as $row ) {

			$role = $row->role;

			$date = $row->datetime;

			if ( $date < $start_date ) {

				continue;

			}

			if ( ! in_array( $date, $userroles[ $ud->last_name . $ud->first_name ]['roledates'][ $role ] ) ) {

				$userroles[ $ud->last_name . $ud->first_name ]['roledates'][ $role ][] = $date;

			}

			// if(!in_array($role,$allroles)) $allroles[] = $role;

		}

	}

	ksort( $userroles );



	if ( isset($_POST['roles'])  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$report_roles = array_map('sanitize_text_field',$_POST['roles']);

		update_option( 'roles_report_roles', $report_roles );

	} else {

		$report_roles = get_option( 'roles_report_roles' );

	}

	if ( empty( $report_roles ) ) {

		global $toast_roles;

		$report_roles = $toast_roles;

	}



	foreach ( $userroles as $userroledata ) {

		echo '<p><strong>' . $userroledata['name'] . '</strong>';

		$speaking   = 0;

		$other_role = (int) $rules['start']; // starting score

		foreach ( $userroledata['roledates'] as $role => $occurrences ) {

			if ( strpos( $role, 'ackup' ) ) {

			} elseif ( $role == 'Speaker' ) {

					$speaking = $speaking + sizeof( $occurrences );

					// print_r($occurrences);

			} else {

					$other_role = $other_role + sizeof( $occurrences );

			}

		}



		$speakingpoints = $speaking * $rules['cost'];

		$score          = $other_role - $speakingpoints;

		$color          = ( $score >= 0 ) ? '#000' : 'red';

		printf( ' Spoke %s times (%s points used), filled other roles %s times<br /><span style="color: %s">point balance %s</span>', $speaking, $speakingpoints, $other_role, $color, $score );

		echo '</p>';

	}

}



function tm_participation_overview( $alldates = 0, $allclubs = 0, $toastmaster = 0 ) {

	?>

<style>

label {

	display: inline-block;

	width: 110px;

}

.bar {

	background-color: red;

	color: #fff;

	padding: 5px; 

	display:inline-block;

	font-size: large;

	font-weight: bold;

	max-width: 80%;

}

.nobar {

	padding: 5px;

	font-weight: bold;

	color: red;

	font-size: large;

	max-width: 100%;

}

.membername {

	font-size: larger;

}

</style>

<div id="participation_overview">

	<?php

	if ( isset( $_GET['alldates'] ) ) {

		$alldates = (int) $_GET['alldates'];

	}

	if ( isset( $_GET['allclubs'] ) ) {

		$allclubs = (int) $_GET['allclubs'];

	}

	if ( isset( $_GET['toastmaster'] ) ) {

		$toastmaster = (int) $_GET['toastmaster'];

	}

	if ( $toastmaster ) {

		$allclubs = $alldates = 1;

	}



	global $wpdb, $rsvp_options;

	echo '<p>' . __( 'This report shows how often a member speaks, versus serving supporting roles.', 'rsvpmaker-for-toastmasters' ),'</p>';



	$rules = get_option( 'tm_participation_rules' );

	if ( empty( $rules ) ) {

		$rules['start'] = '-6 months';

	}

	$start = strtotime( $rules['start'] );



	if ( $alldates ) {

		echo '<p>NOT filtered by date. ';

		$multiplier = 5;

	} else {

		$multiplier  = 10;

		$prettystart = date( 'M j, Y', $start );

		printf( '<p>Showing participation in the last 6 months (since %s). ', $prettystart );

	}



	if ( $allclubs ) {

		printf( ' NOT filtered by club (may include activity from other clubs that use this software).</p>', $prettystart );

	} else {

		printf( ' Filtered to activity from this club ONLY.</p>', $prettystart );

	}



	if ( ( $alldates || $allclubs ) && empty( $toastmaster ) ) {

		echo '<p>Switch view: <a href="' . admin_url( 'admin.php?page=toastmasters_reports&allclubs=0&alldates=0' ) . '">' . __( 'Filter to 6 month snapshot of activity within this club.', 'rsvpmaker-for-toastmasters' ),'</a></p>';

	} else {

		echo '<p>Switch view: <a href="' . admin_url( 'admin.php?page=toastmasters_reports&alldates=1' ) . '">' . __( 'Show all dates.', 'rsvpmaker-for-toastmasters' ),'</a> | <a href="' . admin_url( 'admin.php?page=toastmasters_reports&allclubs=1&alldates=1' ) . '">' . __( 'Show all clubs, all dates.', 'rsvpmaker-for-toastmasters' ),'</a></p>';

	}



	$allroles = array();

	if ( $toastmaster ) {

		$user['ID'] = $toastmaster;

		$users[]    = (object) $user;

	} else {

		$users = get_users( 'blog_id=' . get_current_blog_id() );

	}

	foreach ( $users as $user ) {

		$ud = get_userdata( $user->ID );

		$userroles[ $ud->last_name . $ud->first_name ]['name'] = '<strong>' . $ud->first_name . ' ' . $ud->last_name . '</strong>';

		if ( $allclubs ) {

			$where = "user_id=$user->ID";

		} else {

			$sname = sanitize_text_field($_SERVER['SERVER_NAME']);

			$where = "user_id=$user->ID AND domain LIKE '$sname'";

		}

		$results = wp4t_history_query( $where );

		if ( ! $results ) {

			continue;

		}



		$mostrecent = '';

		foreach ( $results as $row ) {

			$role = $row->role;

			$ts   = rsvpmaker_strtotime( $row->datetime );

			$date = rsvpmaker_date( 'F j, Y', $ts );

			// printf('<p>%s %s %s</p>',$ud->last_name,$role,$date);

			if ( ( $role == 'Speaker' ) && empty( $mostrecent ) ) {

				$mostrecent = ' Most recent speech: ' . $date;

			}

			if ( ! $alldates && ( $ts < $start ) ) {

				continue;

			}

			if ( $role == 'Speaker' ) {

				$manual = $row->manual;

				$manuals[ $ud->last_name . $ud->first_name ][ $data['manual'] ][] = $row->title . ' - ' . $row->project . ' - ' . $date;

			}

			$userroles[ $ud->last_name . $ud->first_name ]['roledates'][ $role ][] = $date;

		}

		$userroles[ $ud->last_name . $ud->first_name ]['name'] .= $mostrecent;

	}

	ksort( $userroles );



	foreach ( $userroles as $index => $userroledata ) {

		echo '<p class="membername">' . $userroledata['name'] . '</p>';

		$speaking   = 0;

		$other_role = 0;

		$otherroles = array();

		if ( ! empty( $userroledata['roledates'] ) ) {

			foreach ( $userroledata['roledates'] as $role => $occurrences ) {

				if ( strpos( $role, 'ackup' ) ) {

				} elseif ( $role == 'Speaker' ) {

					$speaking = $speaking + sizeof( $occurrences );

				} else {

					$other_role          = $other_role + sizeof( $occurrences );

					$otherroles[ $role ] = sizeof( $occurrences );// empty($otherroles[$role]) ? 1 : $otherroles[$role] + 1;

				}

			}

		}

		if ( $speaking ) {

			$bar = ( $speaking ) ? ( $speaking * $multiplier ) : $multiplier;

		}

		$class = ( $speaking ) ? 'bar' : 'nobar';

		$list  = '';

		if ( ! empty( $manuals[ $index ] ) ) {

			$ms = $manuals[ $index ];

			foreach ( $manuals[ $index ] as $manual => $titles ) {

				$list .= $manual . ' (' . sizeof( $titles ) . ') ';

			}

		}

		printf( '<p><label>Speaking: </label><span class="%s" style="width: %s"> %s</span><br />%s</p>', $class, $bar . 'px', $speaking, $list );

		$bar   = ( $other_role ) ? ( $other_role * $multiplier ) : $multiplier;

		$class = ( $other_role ) ? 'bar' : 'nobar';

		$other = '';

		foreach ( $otherroles as $role => $count ) {

			$other .= $role . ' (' . $count . ') ';

		}

		printf( '<p><label>Other Roles: </label><span class="%s" style="width: %s">%s</span><br />%s</p>', $class, $bar . 'px', $other_role, $other );

	}



	if ( ! empty( $ms ) ) {

		if ( $toastmaster ) {

			foreach ( $ms as $manual => $titles ) {

				printf( '<h3>%s</h3><p>%s</p>', $manual, implode( '<br />', $titles ) );

			}

		}

	}

	echo '</div>';// closing wrapper div

}



function toastmasters_reports_dashboard() {

	global $wpdb, $rsvp_options;

	$history_table = $wpdb->base_prefix.'tm_history';

	$speech_history_table = $wpdb->base_prefix.'tm_speech_history';



	$titles['pathways']      = 'Pathways Progress Report';

	$titles['cc']            = 'Competent Communication Progress Report';

	$titles['cl']            = 'Competent Leader Progress Report';

	$titles['advanced']      = 'Advanced Projects Progress Report';

	$titles['speeches']      = 'Past Speeches';

	$titles['no_assignment'] = 'Members Without an Assignment';

	$titles['role']          = 'Role Report';

	$titles['speaker']       = 'Speaker Points System Report';

	$titles['attendance']    = 'Attendance';

	$titles['participation'] = 'Participation Overview';

	$titles['minutes']       = 'Minutes';



	if ( isset( $_GET['report'] ) ) {

		$report_slug = sanitize_text_field($_GET['report']);

		$headline    = $titles[ $report_slug ];

		$sidebar = sprintf( '<div><a href="%s">Back to Reports Listing</a></div>', admin_url( 'admin.php?page=toastmasters_reports_dashboard' ) );

	} else {

		$headline = 'Report Dashboard';

		$sidebar = '';

	}

	$hook = tm_admin_page_top( $headline, $sidebar );



	if ( isset( $_GET['report'] ) ) {



		if ( $report_slug == 'speeches' ) {

			$sname = sanitize_text_field($_SERVER['SERVER_NAME']);

			$speakers = wp4t_history_query("role='Speaker' AND domain='$sname' ");// $wpdb->get_results( $sql );



			foreach ( $speakers as $row ) {

				$speaker_id = $row->user_id;

				$name       = get_member_name( $speaker_id );

				if ( empty( trim( $name ) ) ) {

					continue;

				}

				$manual       = $row->manual;

				$project_key  = $row->project_key;

				$project_text =  $row->project ;

				$title        = $row->title;

				if ( ! empty( $title ) ) {

					$title = ', "' . $title . '"';

				}

				$date    = rsvpmaker_date( $rsvp_options['long_date'], strtotime( $row->datetime ) );



				printf( '<p><strong>%s%s</strong><br />%s %s<br />%s</p>', $name, $title, $manual, $project_text, $date );

			}

		}//end speeches

		elseif ( $report_slug == 'no_assignment' ) {

			$where  = " (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ";

			$future = get_future_events( $where, 5 );

			if ( isset( $_GET['id'] ) ) {

				foreach ( $future as $f ) {

					if ( $f->ID == $_GET['id'] ) {

						$next = $f;

					}

				}

			} else {

				$next = $future[0];

			}

			$link = get_permalink( $next->ID );

			$link = add_query_arg( 'assigned_open', 1, $link );

			echo '<p><em>' . __( 'Members without a role for the meeting on ', 'rsvpmaker-for-toastmasters' ) . ' ' . $next->date . '</em></p>';

			if ( ! isset( $_GET['rsvp_print'] ) ) {

				echo '<p>Pick another date ';

				foreach ( $future as $index => $f ) {

					if ( $f->ID != $next->ID ) {

						printf( '| <a href="%s">%s</a> ', admin_url( 'admin.php?page=toastmasters_reports_dashboard&report=no_assignment' ) . '&id=' . $f->ID, $f->date );

					}

				}

				echo ' - see also <a target="_blank" href="' . $link . '">Agenda with Contacts</a></p>';

			}

			$ids = wp4t_unassigned_ids( $next->ID );

			foreach ( $ids as $id ) {

				$names[] = get_member_name( $id );

			}

			sort( $names );

			foreach ( $names as $name ) {

				printf( '<p>%s</p>', $name );

			}

		} elseif ( $report_slug == 'role' ) {

			toastmasters_role_report();

		} elseif ( $report_slug == 'speaker' ) {

			speech_points_report();

		} elseif ( $report_slug == 'cc' ) {

			toastmasters_cc();

		} elseif ( $report_slug == 'cl' ) {

			cl_report();

		} elseif ( $report_slug == 'advanced' ) {

			toastmasters_advanced();

		} elseif ( $report_slug == 'pathways' ) {

			echo '<p><em>' . __( 'This report is intended to give club leaders a rough idea of how active each member has been in the Pathways program, based on speech projects recorded on the agenda.' ) . '</em></p>';

			pathways_report();

		} elseif ( $report_slug == 'attendance' ) {

			toastmasters_attendance_report();

		} elseif ( $report_slug == 'participation' ) {

			tm_participation_overview();

		} elseif ( $report_slug == 'minutes' ) {

			toastmasters_meeting_minutes();

		}



	} else {

		foreach ( $titles as $slug => $title ) {

			printf( '<p><a href="%s&report=%s">%s</a></p>', admin_url( 'admin.php?page=toastmasters_reports_dashboard' ), $slug, $title );

		}

	}

	tm_admin_page_bottom( $hook );

}



function pathways_project_map( $slug ) {



	// projects repeated across paths

	$map = array(

		'Dynamic Leadership Level 1 Mastering Fundamentals 0' => 'Pathways:Ice Breaker',

		'Dynamic Leadership Level 1 Mastering Fundamentals 11' => 'Pathways:Researching and Presenting',

		'Dynamic Leadership Level 1 Mastering Fundamentals 5' => 'Pathways:Evaluation and Feedback - First Speech',

		'Dynamic Leadership Level 1 Mastering Fundamentals 6' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Dynamic Leadership Level 1 Mastering Fundamentals 7' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Dynamic Leadership Level 2 Learning Your Style 20' => 'Pathways:Understanding Your Leadership Style',

		'Dynamic Leadership Level 2 Learning Your Style 25' => 'Pathways:Understanding Your Communication Style',

		'Dynamic Leadership Level 2 Learning Your Style 31' => 'Pathways:Introduction to Toastmasters Mentoring',

		'Dynamic Leadership Level 3 Increasing Knowledge 105' => 'Pathways:Using Descriptive Language',

		'Dynamic Leadership Level 3 Increasing Knowledge 111' => 'Pathways:Using Presentation Software',

		'Dynamic Leadership Level 3 Increasing Knowledge 117' => 'Pathways:Understanding Vocal Variety',

		'Dynamic Leadership Level 3 Increasing Knowledge 45' => 'Pathways:Active Listening',

		'Dynamic Leadership Level 3 Increasing Knowledge 51' => 'Pathways:Connect with Storytelling',

		'Dynamic Leadership Level 3 Increasing Knowledge 57' => 'Pathways:Connect with Your Audience',

		'Dynamic Leadership Level 3 Increasing Knowledge 63' => 'Pathways:Creating Effective Visual Aids',

		'Dynamic Leadership Level 3 Increasing Knowledge 69' => 'Pathways:Deliver Social Speeches - First Speech',

		'Dynamic Leadership Level 3 Increasing Knowledge 70' => 'Pathways:Deliver Social Speeches - Second Speech',

		'Dynamic Leadership Level 3 Increasing Knowledge 75' => 'Pathways:Effective Body Language',

		'Dynamic Leadership Level 3 Increasing Knowledge 81' => 'Pathways:Focus on the Positive',

		'Dynamic Leadership Level 3 Increasing Knowledge 87' => 'Pathways:Inspire Your Audience',

		'Dynamic Leadership Level 3 Increasing Knowledge 89' => 'Pathways:Know Your Sense of Humor',

		'Dynamic Leadership Level 3 Increasing Knowledge 93' => 'Pathways:Make Connections Through Networking',

		'Dynamic Leadership Level 3 Increasing Knowledge 99' => 'Pathways:Prepare for an Interview',

		'Dynamic Leadership Level 4 Building Skills 131'   => 'Pathways:Building a Social Media Presence',

		'Dynamic Leadership Level 4 Building Skills 137'   => 'Pathways:Create a Podcast',

		'Dynamic Leadership Level 4 Building Skills 143'   => 'Pathways:Manage Online Meetings',

		'Dynamic Leadership Level 4 Building Skills 149'   => 'Pathways:Managing a Difficult Audience',

		'Dynamic Leadership Level 4 Building Skills 155'   => 'Pathways:Manage Projects Successfully - First Speech',

		'Dynamic Leadership Level 4 Building Skills 156'   => 'Pathways:Manage Projects Successfully - Second Speech',

		'Dynamic Leadership Level 4 Building Skills 161'   => 'Pathways:Public Relations Strategies',

		'Dynamic Leadership Level 4 Building Skills 167'   => 'Pathways:Question-and-Answer Session',

		'Dynamic Leadership Level 4 Building Skills 173'   => 'Pathways:Write a Compelling Blog',

		'Dynamic Leadership Level 5 Demonstrating Expertise 182' => 'Pathways:Lead in Any Situation',

		'Dynamic Leadership Level 5 Demonstrating Expertise 187' => 'Pathways:Reflect on Your Path',

		'Dynamic Leadership Level 5 Demonstrating Expertise 193'=>'Pathways:Ethical Leadership',

		'Dynamic Leadership Level 5 Demonstrating Expertise 199' => 'Pathways:High Performance Leadership - First Speech',

		'Dynamic Leadership Level 5 Demonstrating Expertise 200' => 'Pathways:High Performance Leadership - Second Speech',

		'Dynamic Leadership Level 5 Demonstrating Expertise 205' => 'Pathways:Leading in Your Volunteer Organization',

		'Dynamic Leadership Level 5 Demonstrating Expertise 211' => 'Pathways:Lessons Learned',

		'Dynamic Leadership Level 5 Demonstrating Expertise 218' => 'Pathways:Moderate a Panel Discussion',

		'Dynamic Leadership Level 5 Demonstrating Expertise 224' => 'Pathways:Prepare to Speak Professionally',

		'Effective Coaching Level 1 Mastering Fundamentals 233' => 'Pathways:Ice Breaker',

		'Effective Coaching Level 1 Mastering Fundamentals 240' => 'Pathways:Evaluation and Feedback - First Speech',

		'Effective Coaching Level 1 Mastering Fundamentals 241' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Effective Coaching Level 1 Mastering Fundamentals 242' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Effective Coaching Level 1 Mastering Fundamentals 246' => 'Pathways:Researching and Presenting',

		'Effective Coaching Level 2 Learning Your Style 256' => 'Pathways:Understanding Your Leadership Style',

		'Effective Coaching Level 2 Learning Your Style 263' => 'Pathways:Understanding Your Communication Style',

		'Effective Coaching Level 2 Learning Your Style 269' => 'Pathways:Introduction to Pathways Mentoring',

		'Effective Coaching Level 3 Increasing Knowledge 285' => 'Pathways:Active Listening',

		'Effective Coaching Level 3 Increasing Knowledge 291' => 'Pathways:Connect with Storytelling',

		'Effective Coaching Level 3 Increasing Knowledge 297' => 'Pathways:Connect with Your Audience',

		'Effective Coaching Level 3 Increasing Knowledge 303' => 'Pathways:Creating Effective Visual Aids',

		'Effective Coaching Level 3 Increasing Knowledge 309' => 'Pathways:Deliver Social Speeches - First Speech',

		'Effective Coaching Level 3 Increasing Knowledge 310' => 'Pathways:Deliver Social Speeches - Second Speech',

		'Effective Coaching Level 3 Increasing Knowledge 315' => 'Pathways:Effective Body Language',

		'Effective Coaching Level 3 Increasing Knowledge 321' => 'Pathways:Focus on the Positive',

		'Effective Coaching Level 3 Increasing Knowledge 327' => 'Pathways:Inspire Your Audience',

		'Effective Coaching Level 3 Increasing Knowledge 330' => 'Pathways:Know Your Sense of Humor',

		'Effective Coaching Level 3 Increasing Knowledge 333' => 'Pathways:Make Connections Through Networking',

		'Effective Coaching Level 3 Increasing Knowledge 339' => 'Pathways:Prepare for an Interview',

		'Effective Coaching Level 3 Increasing Knowledge 345' => 'Pathways:Understanding Vocal Variety',

		'Effective Coaching Level 3 Increasing Knowledge 351' => 'Pathways:Using Descriptive Language',

		'Effective Coaching Level 3 Increasing Knowledge 357' => 'Pathways:Using Presentation Software',

		'Effective Coaching Level 4 Building Skills 366'   => 'Pathways:Building a Social Media Presence',

		'Effective Coaching Level 4 Building Skills 373'   => 'Pathways:Create a Podcast',

		'Effective Coaching Level 4 Building Skills 385'   => 'Pathways:Manage Online Meetings',

		'Effective Coaching Level 4 Building Skills 391'   => 'Pathways:Manage Projects Successfully - First Speech',

		'Effective Coaching Level 4 Building Skills 392'   => 'Pathways:Manage Projects Successfully - Second Speech',

		'Effective Coaching Level 4 Building Skills 397'   => 'Pathways:Managing a Difficult Audience',

		'Effective Coaching Level 4 Building Skills 403'   => 'Pathways:Public Relations Strategies',

		'Effective Coaching Level 4 Building Skills 409'   => 'Pathways:Question-and-Answer Session',

		'Effective Coaching Level 4 Building Skills 415'   => 'Pathways:Write a Compelling Blog',

		'Effective Coaching Level 5 Demonstrating Expertise 424' => 'Pathways:High Performance Leadership - First Speech',

		'Effective Coaching Level 5 Demonstrating Expertise 425' => 'Pathways:High Performance Leadership - Second Speech',

		'Effective Coaching Level 5 Demonstrating Expertise 431' => 'Pathways:Reflect on Your Path',

		'Effective Coaching Level 5 Demonstrating Expertise 437' => 'Pathways:Ethical Leadership',

		'Effective Coaching Level 5 Demonstrating Expertise 443' => 'Pathways:Leading in Your Volunteer Organization',

		'Effective Coaching Level 5 Demonstrating Expertise 449' => 'Pathways:Lessons Learned',

		'Effective Coaching Level 5 Demonstrating Expertise 455' => 'Pathways:Moderate a Panel Discussion',

		'Effective Coaching Level 5 Demonstrating Expertise 461' => 'Pathways:Prepare to Speak Professionally',

		'Engaging Humor Level 1 Mastering Fundamentals 14004' => 'Pathways:Ice Breaker',

		'Engaging Humor Level 1 Mastering Fundamentals 14011' => 'Pathways:Evaluation and Feedback - First Speech',

		'Engaging Humor Level 1 Mastering Fundamentals 14012' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Engaging Humor Level 1 Mastering Fundamentals 14013' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Engaging Humor Level 1 Mastering Fundamentals 14017' => 'Pathways:Researching and Presenting',



		'Engaging Humor Level 2 Learning Your Style 14026' => 'Pathways:Know Your Sense of Humor',



		'Engaging Humor Level 2 Learning Your Style 14033' => 'Pathways:Connect with Your Audience',

		'Engaging Humor Level 2 Learning Your Style 14039' => 'Pathways:Introduction to Pathways Mentoring',

		'Engaging Humor Level 3 Increasing Knowledge 14055' => 'Pathways:Active Listening',

		'Engaging Humor Level 3 Increasing Knowledge 14061' => 'Pathways:Connect with Storytelling',

		'Engaging Humor Level 3 Increasing Knowledge 14067' => 'Pathways:Connect with Your Audience',

		'Engaging Humor Level 3 Increasing Knowledge 14073' => 'Pathways:Creating Effective Visual Aids',

		'Engaging Humor Level 3 Increasing Knowledge 14079' => 'Pathways:Deliver Social Speeches - First Speech',

		'Engaging Humor Level 3 Increasing Knowledge 14084' => 'Pathways:Effective Body Language',

		'Engaging Humor Level 3 Increasing Knowledge 14085' => 'Pathways:Focus on the Positive',

		'Engaging Humor Level 3 Increasing Knowledge 14091' => 'Pathways:Inspire Your Audience',

		'Engaging Humor Level 3 Increasing Knowledge 14097' => 'Pathways:Make Connections Through Networking',

		'Engaging Humor Level 3 Increasing Knowledge 15003' => 'Pathways:Prepare for an Interview',

		'Engaging Humor Level 3 Increasing Knowledge 15009' => 'Pathways:Understanding Vocal Variety',

		'Engaging Humor Level 3 Increasing Knowledge 150150' => 'Pathways:Using Descriptive Language',

		'Engaging Humor Level 3 Increasing Knowledge 15021' => 'Pathways:Using Presentation Software',

		'Engaging Humor Level 4 Building Skills 15030'     => 'Pathways:Managing a Difficult Audience',

		'Engaging Humor Level 4 Building Skills 15037'     => 'Pathways:Building a Social Media Presence',

		'Engaging Humor Level 4 Building Skills 15043'     => 'Pathways:Create a Podcast',

		'Engaging Humor Level 4 Building Skills 15049'     => 'Pathways:Manage Online Meetings',

		'Engaging Humor Level 4 Building Skills 15055'     => 'Pathways:Manage Projects Successfully - First Speech',

		'Engaging Humor Level 4 Building Skills 15056'     => 'Pathways:Manage Projects Successfully - Second Speech',

		'Engaging Humor Level 4 Building Skills 15061'     => 'Pathways:Public Relations Strategies',

		'Engaging Humor Level 4 Building Skills 15067'     => 'Pathways:Question-and-Answer Session',

		'Engaging Humor Level 4 Building Skills 15073'     => 'Pathways:Write a Compelling Blog',

		'Engaging Humor Level 5 Demonstrating Expertise 15089' => 'Pathways:Reflect on Your Path',

		'Engaging Humor Level 5 Demonstrating Expertise 15095' => 'Pathways:Ethical Leadership',

		'Engaging Humor Level 5 Demonstrating Expertise 16001' => 'Pathways:High Performance Leadership - First Speech',

		'Engaging Humor Level 5 Demonstrating Expertise 16002' => 'Pathways:High Performance Leadership - Second Speech',

		'Engaging Humor Level 5 Demonstrating Expertise 16007' => 'Pathways:Leading in Your Volunteer Organization',

		'Engaging Humor Level 5 Demonstrating Expertise 16013' => 'Pathways:Lessons Learned',

		'Engaging Humor Level 5 Demonstrating Expertise 16019' => 'Pathways:Moderate a Panel Discussion',

		'Engaging Humor Level 5 Demonstrating Expertise 16224' => 'Pathways:Prepare to Speak Professionally',

		'Innovative Planning Level 1 Mastering Fundamentals 470' => 'Pathways:Ice Breaker',

		'Innovative Planning Level 1 Mastering Fundamentals 477' => 'Pathways:Evaluation and Feedback - First Speech',

		'Innovative Planning Level 1 Mastering Fundamentals 478' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Innovative Planning Level 1 Mastering Fundamentals 479' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Innovative Planning Level 1 Mastering Fundamentals 483' => 'Pathways:Researching and Presenting',

		'Innovative Planning Level 2 Learning Your Style 492' => 'Pathways:Understanding Your Leadership Style',

		'Innovative Planning Level 2 Learning Your Style 499' => 'Pathways:Connect with Your Audience',

		'Innovative Planning Level 2 Learning Your Style 505' => 'Pathways:Introduction to Pathways Mentoring',

		'Innovative Planning Level 3 Increasing Knowledge 521' => 'Pathways:Active Listening',

		'Innovative Planning Level 3 Increasing Knowledge 527' => 'Pathways:Connect with Storytelling',

		'Innovative Planning Level 3 Increasing Knowledge 533' => 'Pathways:Creating Effective Visual Aids',

		'Innovative Planning Level 3 Increasing Knowledge 539' => 'Pathways:Deliver Social Speeches - First Speech',

		'Innovative Planning Level 3 Increasing Knowledge 545' => 'Pathways:Effective Body Language',

		'Innovative Planning Level 3 Increasing Knowledge 551' => 'Pathways:Focus on the Positive',

		'Innovative Planning Level 3 Increasing Knowledge 557' => 'Pathways:Inspire Your Audience',

		'Innovative Planning Level 3 Increasing Knowledge 560' => 'Pathways:Know Your Sense of Humor',

		'Innovative Planning Level 3 Increasing Knowledge 563' => 'Pathways:Make Connections Through Networking',

		'Innovative Planning Level 3 Increasing Knowledge 569' => 'Pathways:Prepare for an Interview',

		'Innovative Planning Level 3 Increasing Knowledge 575' => 'Pathways:Understanding Vocal Variety',

		'Innovative Planning Level 3 Increasing Knowledge 581' => 'Pathways:Using Descriptive Language',

		'Innovative Planning Level 3 Increasing Knowledge 587' => 'Pathways:Using Presentation Software',

		'Innovative Planning Level 4 Building Skills 596'  => 'Pathways:Manage Projects Successfully - First Speech',

		'Innovative Planning Level 4 Building Skills 598'  => 'Pathways:Manage Projects Successfully - Second Speech',

		'Innovative Planning Level 4 Building Skills 603'  => 'Pathways:Building a Social Media Presence',

		'Innovative Planning Level 4 Building Skills 609'  => 'Pathways:Create a Podcast',

		'Innovative Planning Level 4 Building Skills 615'  => 'Pathways:Manage Online Meetings',

		'Innovative Planning Level 4 Building Skills 621'  => 'Pathways:Managing a Difficult Audience',

		'Innovative Planning Level 4 Building Skills 627'  => 'Pathways:Public Relations Strategies',

		'Innovative Planning Level 4 Building Skills 633'  => 'Pathways:Question-and-Answer Session',

		'Innovative Planning Level 4 Building Skills 639'  => 'Pathways:Write a Compelling Blog',

		'Innovative Planning Level 5 Demonstrating Expertise 648' => 'Pathways:High Performance Leadership - First Speech',

		'Innovative Planning Level 5 Demonstrating Expertise 649' => 'Pathways:High Performance Leadership - Second Speech',

		'Innovative Planning Level 5 Demonstrating Expertise 655' => 'Pathways:Reflect on Your Path',

		'Innovative Planning Level 5 Demonstrating Expertise 661' => 'Pathways:Ethical Leadership',

		'Innovative Planning Level 5 Demonstrating Expertise 667' => 'Pathways:Leading in Your Volunteer Organization',

		'Innovative Planning Level 5 Demonstrating Expertise 673' => 'Pathways:Lessons Learned',

		'Innovative Planning Level 5 Demonstrating Expertise 679' => 'Pathways:Moderate a Panel Discussion',

		'Innovative Planning Level 5 Demonstrating Expertise 685' => 'Pathways:Prepare to Speak Professionally',

		'Leadership Development Level 1 Mastering Fundamentals 694' => 'Pathways:Ice Breaker',

		'Leadership Development Level 1 Mastering Fundamentals 701' => 'Pathways:Evaluation and Feedback - First Speech',

		'Leadership Development Level 1 Mastering Fundamentals 702' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Leadership Development Level 1 Mastering Fundamentals 703' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Leadership Development Level 1 Mastering Fundamentals 707' => 'Pathways:Researching and Presenting',

		'Leadership Development Level 2 Learning Your Style 723' => 'Pathways:Understanding Your Leadership Style',

		'Leadership Development Level 2 Learning Your Style 729' => 'Pathways:Introduction to Pathways Mentoring',

		'Leadership Development Level 3 Increasing Knowledge 745' => 'Pathways:Active Listening',

		'Leadership Development Level 3 Increasing Knowledge 751' => 'Pathways:Connect with Storytelling',

		'Leadership Development Level 3 Increasing Knowledge 757' => 'Pathways:Connect with Your Audience',

		'Leadership Development Level 3 Increasing Knowledge 763' => 'Pathways:Creating Effective Visual Aids',

		'Leadership Development Level 3 Increasing Knowledge 769' => 'Pathways:Deliver Social Speeches - First Speech',

		'Leadership Development Level 3 Increasing Knowledge 775' => 'Pathways:Effective Body Language',

		'Leadership Development Level 3 Increasing Knowledge 781' => 'Pathways:Focus on the Positive',

		'Leadership Development Level 3 Increasing Knowledge 787' => 'Pathways:Inspire Your Audience',

		'Leadership Development Level 3 Increasing Knowledge 789' => 'Pathways:Know Your Sense of Humor',

		'Leadership Development Level 3 Increasing Knowledge 793' => 'Pathways:Make Connections Through Networking',

		'Leadership Development Level 3 Increasing Knowledge 799' => 'Pathways:Prepare for an Interview',

		'Leadership Development Level 3 Increasing Knowledge 805' => 'Pathways:Understanding Vocal Variety',

		'Leadership Development Level 3 Increasing Knowledge 811' => 'Pathways:Using Descriptive Language',

		'Leadership Development Level 3 Increasing Knowledge 817' => 'Pathways:Using Presentation Software',

		'Leadership Development Level 4 Building Skills 833' => 'Pathways:Building a Social Media Presence',

		'Leadership Development Level 4 Building Skills 839' => 'Pathways:Create a Podcast',

		'Leadership Development Level 4 Building Skills 845' => 'Pathways:Manage Online Meetings',

		'Leadership Development Level 4 Building Skills 851' => 'Pathways:Manage Projects Successfully - First Speech',

		'Leadership Development Level 4 Building Skills 852' => 'Pathways:Manage Projects Successfully - Second Speech',

		'Leadership Development Level 4 Building Skills 857' => 'Pathways:Managing a Difficult Audience',

		'Leadership Development Level 4 Building Skills 863' => 'Pathways:Public Relations Strategies',

		'Leadership Development Level 4 Building Skills 869' => 'Pathways:Question-and-Answer Session',

		'Leadership Development Level 4 Building Skills 875' => 'Pathways:Write a Compelling Blog',

		'Leadership Development Level 5 Demonstrating Expertise 891' => 'Pathways:Reflect on Your Path',

		'Leadership Development Level 5 Demonstrating Expertise 897' => 'Pathways:Ethical Leadership',

		'Leadership Development Level 5 Demonstrating Expertise 903' => 'Pathways:High Performance Leadership - First Speech',

		'Leadership Development Level 5 Demonstrating Expertise 904' => 'Pathways:High Performance Leadership - Second Speech',

		'Leadership Development Level 5 Demonstrating Expertise 909' => 'Pathways:Leading in Your Volunteer Organization',

		'Leadership Development Level 5 Demonstrating Expertise 915' => 'Pathways:Lessons Learned',

		'Leadership Development Level 5 Demonstrating Expertise 921' => 'Pathways:Moderate a Panel Discussion',

		'Leadership Development Level 5 Demonstrating Expertise 927' => 'Pathways:Prepare to Speak Professionally',

		'Motivational Strategies Level 1 Mastering Fundamentals 937' => 'Pathways:Ice Breaker',

		'Motivational Strategies Level 1 Mastering Fundamentals 944' => 'Pathways:Evaluation and Feedback - First Speech',

		'Motivational Strategies Level 1 Mastering Fundamentals 945' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Motivational Strategies Level 1 Mastering Fundamentals 946' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Motivational Strategies Level 1 Mastering Fundamentals 950' => 'Pathways:Researching and Presenting',

		'Motivational Strategies Level 2 Learning Your Style 959' => 'Pathways:Understanding Your Communication Style',

		'Motivational Strategies Level 2 Learning Your Style 966' => 'Pathways:Active Listening',

		'Motivational Strategies Level 2 Learning Your Style 972' => 'Pathways:Introduction to Pathways Mentoring',

		'Motivational Strategies Level 3 Increasing Knowledge 1000' => 'Pathways:Creating Effective Visual Aids',

		'Motivational Strategies Level 3 Increasing Knowledge 1006' => 'Pathways:Deliver Social Speeches - First Speech',

		'Motivational Strategies Level 3 Increasing Knowledge 1012' => 'Pathways:Effective Body Language',

		'Motivational Strategies Level 3 Increasing Knowledge 1018' => 'Pathways:Focus on the Positive',

		'Motivational Strategies Level 3 Increasing Knowledge 1024' => 'Pathways:Inspire Your Audience',

		'Motivational Strategies Level 3 Increasing Knowledge 1026' => 'Pathways:Know Your Sense of Humor',

		'Motivational Strategies Level 3 Increasing Knowledge 1030' => 'Pathways:Make Connections Through Networking',

		'Motivational Strategies Level 3 Increasing Knowledge 1036' => 'Pathways:Prepare for an Interview',

		'Motivational Strategies Level 3 Increasing Knowledge 1042' => 'Pathways:Understanding Vocal Variety',

		'Motivational Strategies Level 3 Increasing Knowledge 1048' => 'Pathways:Using Descriptive Language',

		'Motivational Strategies Level 3 Increasing Knowledge 1054' => 'Pathways:Using Presentation Software',

		'Motivational Strategies Level 3 Increasing Knowledge 988' => 'Pathways:Connect with Storytelling',

		'Motivational Strategies Level 3 Increasing Knowledge 994' => 'Pathways:Connect with Your Audience',

		'Motivational Strategies Level 4 Building Skills 1063' => 'Pathways:Motivate Others',

		'Motivational Strategies Level 4 Building Skills 1070' => 'Pathways:Building a Social Media Presence',

		'Motivational Strategies Level 4 Building Skills 1076' => 'Pathways:Create a Podcast',

		'Motivational Strategies Level 4 Building Skills 1082' => 'Pathways:Manage Online Meetings',

		'Motivational Strategies Level 4 Building Skills 1088' => 'Pathways:Manage Projects Successfully - First Speech',

		'Motivational Strategies Level 4 Building Skills 1089' => 'Pathways:Manage Projects Successfully - Second Speech',

		'Motivational Strategies Level 4 Building Skills 1094' => 'Pathways:Managing a Difficult Audience',

		'Motivational Strategies Level 4 Building Skills 1100' => 'Pathways:Public Relations Strategies',

		'Motivational Strategies Level 4 Building Skills 1106' => 'Pathways:Question-and-Answer Session',

		'Motivational Strategies Level 4 Building Skills 1112' => 'Pathways:Write a Compelling Blog',

		'Motivational Strategies Level 5 Demonstrating Expertise 1128' => 'Pathways:Reflect on Your Path',

		'Motivational Strategies Level 5 Demonstrating Expertise 1134' => 'Pathways:Ethical Leadership',

		'Motivational Strategies Level 5 Demonstrating Expertise 1140' => 'Pathways:High Performance Leadership - First Speech',

		'Motivational Strategies Level 5 Demonstrating Expertise 1141' => 'Pathways:High Performance Leadership - Second Speech',

		'Motivational Strategies Level 5 Demonstrating Expertise 1146' => 'Pathways:Leading in Your Volunteer Organization',

		'Motivational Strategies Level 5 Demonstrating Expertise 1152' => 'Pathways:Lessons Learned',

		'Motivational Strategies Level 5 Demonstrating Expertise 1158' => 'Pathways:Moderate a Panel Discussion',

		'Motivational Strategies Level 5 Demonstrating Expertise 1164' => 'Pathways:Prepare to Speak Professionally',

		'Persuasive Influence Level 1 Mastering Fundamentals 1173' => 'Pathways:Ice Breaker',

		'Persuasive Influence Level 1 Mastering Fundamentals 1180' => 'Pathways:Evaluation and Feedback - First Speech',

		'Persuasive Influence Level 1 Mastering Fundamentals 1181' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Persuasive Influence Level 1 Mastering Fundamentals 1182' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Persuasive Influence Level 1 Mastering Fundamentals 1186' => 'Pathways:Researching and Presenting',

		'Persuasive Influence Level 2 Learning Your Style 1195' => 'Pathways:Understanding Your Leadership Style',

		'Persuasive Influence Level 2 Learning Your Style 1202' => 'Pathways:Active Listening',

		'Persuasive Influence Level 2 Learning Your Style 1208' => 'Pathways:Introduction to Pathways Mentoring',

		'Persuasive Influence Level 3 Increasing Knowledge 1224' => 'Pathways:Connect with Storytelling',

		'Persuasive Influence Level 3 Increasing Knowledge 1230' => 'Pathways:Connect with Your Audience',

		'Persuasive Influence Level 3 Increasing Knowledge 1236' => 'Pathways:Creating Effective Visual Aids',

		'Persuasive Influence Level 3 Increasing Knowledge 1242' => 'Pathways:Deliver Social Speeches - First Speech',

		'Persuasive Influence Level 3 Increasing Knowledge 1248' => 'Pathways:Effective Body Language',

		'Persuasive Influence Level 3 Increasing Knowledge 1254' => 'Pathways:Focus on the Positive',

		'Persuasive Influence Level 3 Increasing Knowledge 1260' => 'Pathways:Inspire Your Audience',

		'Persuasive Influence Level 3 Increasing Knowledge 1260' => 'Pathways:Know Your Sense of Humor',

		'Persuasive Influence Level 3 Increasing Knowledge 1266' => 'Pathways:Make Connections Through Networking',

		'Persuasive Influence Level 3 Increasing Knowledge 1272' => 'Pathways:Prepare for an Interview',

		'Persuasive Influence Level 3 Increasing Knowledge 1278' => 'Pathways:Understanding Vocal Variety',

		'Persuasive Influence Level 3 Increasing Knowledge 1284' => 'Pathways:Using Descriptive Language',

		'Persuasive Influence Level 3 Increasing Knowledge 1290' => 'Pathways:Using Presentation Software',

		'Persuasive Influence Level 4 Building Skills 1299' => 'Pathways:Building a Social Media Presence',

		'Persuasive Influence Level 4 Building Skills 1312' => 'Pathways:Create a Podcast',

		'Persuasive Influence Level 4 Building Skills 1318' => 'Pathways:Manage Online Meetings',

		'Persuasive Influence Level 4 Building Skills 1324' => 'Pathways:Manage Projects Successfully - First Speech',

		'Persuasive Influence Level 4 Building Skills 1325' => 'Pathways:Manage Projects Successfully - Second Speech',

		'Persuasive Influence Level 4 Building Skills 1330' => 'Pathways:Managing a Difficult Audience',

		'Persuasive Influence Level 4 Building Skills 1336' => 'Pathways:Public Relations Strategies',

		'Persuasive Influence Level 4 Building Skills 1342' => 'Pathways:Question-and-Answer Session',

		'Persuasive Influence Level 4 Building Skills 1348' => 'Pathways:Write a Compelling Blog',

		'Persuasive Influence Level 5 Demonstrating Expertise 1357' => 'Pathways:High Performance Leadership - First Speech',

		'Persuasive Influence Level 5 Demonstrating Expertise 1358' => 'Pathways:High Performance Leadership - Second Speech',

		'Persuasive Influence Level 5 Demonstrating Expertise 1364' => 'Pathways:Reflect on Your Path',

		'Persuasive Influence Level 5 Demonstrating Expertise 1370' => 'Pathways:Ethical Leadership',

		'Persuasive Influence Level 5 Demonstrating Expertise 1376' => 'Pathways:Leading in Your Volunteer Organization',

		'Persuasive Influence Level 5 Demonstrating Expertise 1382' => 'Pathways:Lessons Learned',

		'Persuasive Influence Level 5 Demonstrating Expertise 1388' => 'Pathways:Moderate a Panel Discussion',

		'Persuasive Influence Level 5 Demonstrating Expertise 1394' => 'Pathways:Prepare to Speak Professionally',

		'Presentation Mastery Level 1 Mastering Fundamentals 1404' => 'Pathways:Ice Breaker',

		'Presentation Mastery Level 1 Mastering Fundamentals 1411' => 'Pathways:Evaluation and Feedback - First Speech',

		'Presentation Mastery Level 1 Mastering Fundamentals 1412' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Presentation Mastery Level 1 Mastering Fundamentals 1413' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Presentation Mastery Level 1 Mastering Fundamentals 1417' => 'Pathways:Researching and Presenting',

		'Presentation Mastery Level 2 Learning Your Style 1426' => 'Pathways:Understanding Your Communication Style',

		'Presentation Mastery Level 2 Learning Your Style 1433' => 'Pathways:Effective Body Language',

		'Presentation Mastery Level 2 Learning Your Style 1439' => 'Pathways:Introduction to Pathways Mentoring',

		'Presentation Mastery Level 3 Increasing Knowledge 1455' => 'Pathways:Active Listening',

		'Presentation Mastery Level 3 Increasing Knowledge 1461' => 'Pathways:Connect with Storytelling',

		'Presentation Mastery Level 3 Increasing Knowledge 1467' => 'Pathways:Connect with Your Audience',

		'Presentation Mastery Level 3 Increasing Knowledge 1473' => 'Pathways:Creating Effective Visual Aids',

		'Presentation Mastery Level 3 Increasing Knowledge 1479' => 'Pathways:Deliver Social Speeches - First Speech',

		'Presentation Mastery Level 3 Increasing Knowledge 1485' => 'Pathways:Focus on the Positive',

		'Presentation Mastery Level 3 Increasing Knowledge 1491' => 'Pathways:Inspire Your Audience',

		'Presentation Mastery Level 3 Increasing Knowledge 1495' => 'Pathways:Know Your Sense of Humor',

		'Presentation Mastery Level 3 Increasing Knowledge 1497' => 'Pathways:Make Connections Through Networking',

		'Presentation Mastery Level 3 Increasing Knowledge 1503' => 'Pathways:Prepare for an Interview',

		'Presentation Mastery Level 3 Increasing Knowledge 1509' => 'Pathways:Understanding Vocal Variety',

		'Presentation Mastery Level 3 Increasing Knowledge 1515' => 'Pathways:Using Descriptive Language',

		'Presentation Mastery Level 3 Increasing Knowledge 1521' => 'Pathways:Using Presentation Software',

		'Presentation Mastery Level 4 Building Skills 1530' => 'Pathways:Managing a Difficult Audience',

		'Presentation Mastery Level 4 Building Skills 1537' => 'Pathways:Building a Social Media Presence',

		'Presentation Mastery Level 4 Building Skills 1543' => 'Pathways:Create a Podcast',

		'Presentation Mastery Level 4 Building Skills 1549' => 'Pathways:Manage Online Meetings',

		'Presentation Mastery Level 4 Building Skills 1555' => 'Pathways:Manage Projects Successfully - First Speech',

		'Presentation Mastery Level 4 Building Skills 1556' => 'Pathways:Manage Projects Successfully - Second Speech',

		'Presentation Mastery Level 4 Building Skills 1561' => 'Pathways:Public Relations Strategies',

		'Presentation Mastery Level 4 Building Skills 1567' => 'Pathways:Question-and-Answer Session',

		'Presentation Mastery Level 4 Building Skills 1573' => 'Pathways:Write a Compelling Blog',

		'Presentation Mastery Level 5 Demonstrating Expertise 1582' => 'Pathways:Prepare to Speak Professionally',

		'Presentation Mastery Level 5 Demonstrating Expertise 1589' => 'Pathways:Reflect on Your Path',

		'Presentation Mastery Level 5 Demonstrating Expertise 1595' => 'Pathways:Ethical Leadership',

		'Presentation Mastery Level 5 Demonstrating Expertise 1601' => 'Pathways:High Performance Leadership - First Speech',

		'Presentation Mastery Level 5 Demonstrating Expertise 1602' => 'Pathways:High Performance Leadership - Second Speech',

		'Presentation Mastery Level 5 Demonstrating Expertise 1607' => 'Pathways:Leading in Your Volunteer Organization',

		'Presentation Mastery Level 5 Demonstrating Expertise 1613' => 'Pathways:Lessons Learned',

		'Presentation Mastery Level 5 Demonstrating Expertise 1619' => 'Pathways:Moderate a Panel Discussion',

		'Strategic Relationships Level 1 Mastering Fundamentals 1628' => 'Pathways:Ice Breaker',

		'Strategic Relationships Level 1 Mastering Fundamentals 1635' => 'Pathways:Evaluation and Feedback - First Speech',

		'Strategic Relationships Level 1 Mastering Fundamentals 1636' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Strategic Relationships Level 1 Mastering Fundamentals 1637' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Strategic Relationships Level 1 Mastering Fundamentals 1641' => 'Pathways:Researching and Presenting',

		'Strategic Relationships Level 2 Learning Your Style 1650' => 'Pathways:Understanding Your Leadership Style',

		'Strategic Relationships Level 2 Learning Your Style 1663' => 'Pathways:Introduction to Pathways Mentoring',

		'Strategic Relationships Level 3 Increasing Knowledge 1672' => 'Pathways:Make Connections Through Networking',

		'Strategic Relationships Level 3 Increasing Knowledge 1679' => 'Pathways:Active Listening',

		'Strategic Relationships Level 3 Increasing Knowledge 1685' => 'Pathways:Connect with Storytelling',

		'Strategic Relationships Level 3 Increasing Knowledge 1691' => 'Pathways:Connect with Your Audience',

		'Strategic Relationships Level 3 Increasing Knowledge 1697' => 'Pathways:Creating Effective Visual Aids',

		'Strategic Relationships Level 3 Increasing Knowledge 1703' => 'Pathways:Deliver Social Speeches - First Speech',

		'Strategic Relationships Level 3 Increasing Knowledge 1709' => 'Pathways:Effective Body Language',

		'Strategic Relationships Level 3 Increasing Knowledge 1715' => 'Pathways:Focus on the Positive',

		'Strategic Relationships Level 3 Increasing Knowledge 1721' => 'Pathways:Inspire Your Audience',

		'Strategic Relationships Level 3 Increasing Knowledge 1725' => 'Pathways:Know Your Sense of Humor',

		'Strategic Relationships Level 3 Increasing Knowledge 1727' => 'Pathways:Prepare for an Interview',

		'Strategic Relationships Level 3 Increasing Knowledge 1733' => 'Pathways:Understanding Vocal Variety',

		'Strategic Relationships Level 3 Increasing Knowledge 1739' => 'Pathways:Using Descriptive Language',

		'Strategic Relationships Level 3 Increasing Knowledge 1745' => 'Pathways:Using Presentation Software',

		'Strategic Relationships Level 4 Building Skills 1754' => 'Pathways:Public Relations Strategies',

		'Strategic Relationships Level 4 Building Skills 1761' => 'Pathways:Building a Social Media Presence',

		'Strategic Relationships Level 4 Building Skills 1767' => 'Pathways:Create a Podcast',

		'Strategic Relationships Level 4 Building Skills 1773' => 'Pathways:Manage Online Meetings',

		'Strategic Relationships Level 4 Building Skills 1779' => 'Pathways:Manage Projects Successfully - First Speech',

		'Strategic Relationships Level 4 Building Skills 1780' => 'Pathways:Manage Projects Successfully - Second Speech',

		'Strategic Relationships Level 4 Building Skills 1785' => 'Pathways:Managing a Difficult Audience',

		'Strategic Relationships Level 4 Building Skills 1791' => 'Pathways:Question-and-Answer Session',

		'Strategic Relationships Level 4 Building Skills 1797' => 'Pathways:Write a Compelling Blog',

		'Strategic Relationships Level 5 Demonstrating Expertise 1806' => 'Pathways:Leading in Your Volunteer Organization',

		'Strategic Relationships Level 5 Demonstrating Expertise 1813' => 'Pathways:Reflect on Your Path',

		'Strategic Relationships Level 5 Demonstrating Expertise 1819' => 'Pathways:Ethical Leadership',

		'Strategic Relationships Level 5 Demonstrating Expertise 1825' => 'Pathways:High Performance Leadership - First Speech',

		'Strategic Relationships Level 5 Demonstrating Expertise 1826' => 'Pathways:High Performance Leadership - Second Speech',

		'Strategic Relationships Level 5 Demonstrating Expertise 1831' => 'Pathways:Lessons Learned',

		'Strategic Relationships Level 5 Demonstrating Expertise 1837' => 'Pathways:Moderate a Panel Discussion',

		'Strategic Relationships Level 5 Demonstrating Expertise 1843' => 'Pathways:Prepare to Speak Professionally',

		'Team Collaboration Level 1 Mastering Fundamentals 1852' => 'Pathways:Ice Breaker',

		'Team Collaboration Level 1 Mastering Fundamentals 1859' => 'Pathways:Evaluation and Feedback - First Speech',

		'Team Collaboration Level 1 Mastering Fundamentals 1860' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Team Collaboration Level 1 Mastering Fundamentals 1861' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Team Collaboration Level 1 Mastering Fundamentals 1865' => 'Pathways:Researching and Presenting',

		'Team Collaboration Level 2 Learning Your Style 1874' => 'Pathways:Understanding Your Leadership Style',

		'Team Collaboration Level 2 Learning Your Style 1881' => 'Pathways:Active Listening',

		'Team Collaboration Level 2 Learning Your Style 1887' => 'Pathways:Introduction to Pathways Mentoring',

		'Team Collaboration Level 3 Increasing Knowledge 1903' => 'Pathways:Connect with Storytelling',

		'Team Collaboration Level 3 Increasing Knowledge 1909' => 'Pathways:Connect with Your Audience',

		'Team Collaboration Level 3 Increasing Knowledge 1915' => 'Pathways:Creating Effective Visual Aids',

		'Team Collaboration Level 3 Increasing Knowledge 1921' => 'Pathways:Deliver Social Speeches - First Speech',

		'Team Collaboration Level 3 Increasing Knowledge 1927' => 'Pathways:Effective Body Language',

		'Team Collaboration Level 3 Increasing Knowledge 1933' => 'Pathways:Focus on the Positive',

		'Team Collaboration Level 3 Increasing Knowledge 1939' => 'Pathways:Inspire Your Audience',

		'Team Collaboration Level 3 Increasing Knowledge 1941' => 'Pathways:Know Your Sense of Humor',

		'Team Collaboration Level 3 Increasing Knowledge 1945' => 'Pathways:Make Connections Through Networking',

		'Team Collaboration Level 3 Increasing Knowledge 1951' => 'Pathways:Prepare for an Interview',

		'Team Collaboration Level 3 Increasing Knowledge 1957' => 'Pathways:Understanding Vocal Variety',

		'Team Collaboration Level 3 Increasing Knowledge 1963' => 'Pathways:Using Descriptive Language',

		'Team Collaboration Level 3 Increasing Knowledge 1969' => 'Pathways:Using Presentation Software',

		'Team Collaboration Level 4 Building Skills 1978'  => 'Pathways:Motivate Others',

		'Team Collaboration Level 4 Building Skills 1985'  => 'Pathways:Building a Social Media Presence',

		'Team Collaboration Level 4 Building Skills 1991'  => 'Pathways:Create a Podcast',

		'Team Collaboration Level 4 Building Skills 1997'  => 'Pathways:Manage Online Meetings',

		'Team Collaboration Level 4 Building Skills 2003'  => 'Pathways:Manage Projects Successfully - First Speech',

		'Team Collaboration Level 4 Building Skills 2004'  => 'Pathways:Manage Projects Successfully - Second Speech',

		'Team Collaboration Level 4 Building Skills 2009'  => 'Pathways:Managing a Difficult Audience',

		'Team Collaboration Level 4 Building Skills 2015'  => 'Pathways:Public Relations Strategies',

		'Team Collaboration Level 4 Building Skills 2021'  => 'Pathways:Question-and-Answer Session',

		'Team Collaboration Level 4 Building Skills 2027'  => 'Pathways:Write a Compelling Blog',

		'Team Collaboration Level 5 Demonstrating Expertise 2036' => 'Pathways:Lead in Any Situation',

		'Team Collaboration Level 5 Demonstrating Expertise 2043' => 'Pathways:Reflect on Your Path',

		'Team Collaboration Level 5 Demonstrating Expertise 2049' => 'Pathways:Ethical Leadership',

		'Team Collaboration Level 5 Demonstrating Expertise 2055' => 'Pathways:High Performance Leadership - First Speech',

		'Team Collaboration Level 5 Demonstrating Expertise 2056' => 'Pathways:High Performance Leadership - Second Speech',

		'Team Collaboration Level 5 Demonstrating Expertise 2061' => 'Pathways:Leading in Your Volunteer Organization',

		'Team Collaboration Level 5 Demonstrating Expertise 2067' => 'Pathways:Lessons Learned',

		'Team Collaboration Level 5 Demonstrating Expertise 2073' => 'Pathways:Moderate a Panel Discussion',

		'Team Collaboration Level 5 Demonstrating Expertise 2079' => 'Pathways:Prepare to Speak Professionally',

		'Visionary Communication Level 1 Mastering Fundamentals 2088' => 'Pathways:Ice Breaker',

		'Visionary Communication Level 1 Mastering Fundamentals 2095' => 'Pathways:Evaluation and Feedback - First Speech',

		'Visionary Communication Level 1 Mastering Fundamentals 2096' => 'Pathways:Evaluation and Feedback - Second Speech',

		'Visionary Communication Level 1 Mastering Fundamentals 2097' => 'Pathways:Evaluation and Feedback - Evaluator Speech',

		'Visionary Communication Level 1 Mastering Fundamentals 2101' => 'Pathways:Researching and Presenting',

		'Visionary Communication Level 2 Learning Your Style 2110' => 'Pathways:Understanding Your Leadership Style',

		'Visionary Communication Level 2 Learning Your Style 2117' => 'Pathways:Understanding Your Communication Style',

		'Visionary Communication Level 2 Learning Your Style 2123' => 'Pathways:Introduction to Pathways Mentoring',

		'Visionary Communication Level 3 Increasing Knowledge 2139' => 'Pathways:Active Listening',

		'Visionary Communication Level 3 Increasing Knowledge 2145' => 'Pathways:Connect with Storytelling',

		'Visionary Communication Level 3 Increasing Knowledge 2151' => 'Pathways:Connect with Your Audience',

		'Visionary Communication Level 3 Increasing Knowledge 2157' => 'Pathways:Creating Effective Visual Aids',

		'Visionary Communication Level 3 Increasing Knowledge 2163' => 'Pathways:Deliver Social Speeches - First Speech',

		'Visionary Communication Level 3 Increasing Knowledge 2169' => 'Pathways:Effective Body Language',

		'Visionary Communication Level 3 Increasing Knowledge 2175' => 'Pathways:Focus on the Positive',

		'Visionary Communication Level 3 Increasing Knowledge 2181' => 'Pathways:Inspire Your Audience',

		'Visionary Communication Level 3 Increasing Knowledge 2185' => 'Pathways:Know Your Sense of Humor',

		'Visionary Communication Level 3 Increasing Knowledge 2187' => 'Pathways:Make Connections Through Networking',

		'Visionary Communication Level 3 Increasing Knowledge 2193' => 'Pathways:Prepare for an Interview',

		'Visionary Communication Level 3 Increasing Knowledge 2199' => 'Pathways:Understanding Vocal Variety',

		'Visionary Communication Level 3 Increasing Knowledge 2205' => 'Pathways:Using Descriptive Language',

		'Visionary Communication Level 3 Increasing Knowledge 2211' => 'Pathways:Using Presentation Software',

		'Visionary Communication Level 4 Building Skills 2227' => 'Pathways:Building a Social Media Presence',

		'Visionary Communication Level 4 Building Skills 2233' => 'Pathways:Create a Podcast',

		'Visionary Communication Level 4 Building Skills 2239' => 'Pathways:Manage Online Meetings',

		'Visionary Communication Level 4 Building Skills 2245' => 'Pathways:Manage Projects Successfully - First Speech',

		'Visionary Communication Level 4 Building Skills 2246' => 'Pathways:Manage Projects Successfully - Second Speech',

		'Visionary Communication Level 4 Building Skills 2251' => 'Pathways:Managing a Difficult Audience',

		'Visionary Communication Level 4 Building Skills 2257' => 'Pathways:Public Relations Strategies',

		'Visionary Communication Level 4 Building Skills 2263' => 'Pathways:Question-and-Answer Session',

		'Visionary Communication Level 4 Building Skills 2269' => 'Pathways:Write a Compelling Blog',

		'Visionary Communication Level 5 Demonstrating Expertise 2285' => 'Pathways:Reflect on Your Path',

		'Visionary Communication Level 5 Demonstrating Expertise 2291' => 'Pathways:Ethical Leadership',

		'Visionary Communication Level 5 Demonstrating Expertise 2297' => 'Pathways:High Performance Leadership - First Speech',

		'Visionary Communication Level 5 Demonstrating Expertise 2298' => 'Pathways:High Performance Leadership - Second Speech',

		'Visionary Communication Level 5 Demonstrating Expertise 2303' => 'Pathways:Leading in Your Volunteer Organization',

		'Visionary Communication Level 5 Demonstrating Expertise 2309' => 'Pathways:Lessons Learned',

		'Visionary Communication Level 5 Demonstrating Expertise 2315' => 'Pathways:Moderate a Panel Discussion',

		'Visionary Communication Level 5 Demonstrating Expertise 2321' => 'Pathways:Prepare to Speak Professionally',

	);

	$paths = array('Dynamic Leadership',

	'Effective Coaching',

	'Engaging Humor',

	'Innovative Planning',

	'Leadership Development',

	'Motivational Strategies',

	'Persuasive Influence',

	'Presentation Mastery',

	'Strategic Relationships',

	'Team Collaboration',

	'Visionary Communication');

	foreach($paths as $path) {

		$map[$path.' Level 1 Mastering Fundamentals 12'] = 'Pathways:Writing a Speech with Purpose';

		$map[$path.' Level 1 Mastering Fundamentals 13'] = 'Pathways:Introduction to Vocal Variety and Body Language';

		$map[$path.' Level 1 Mastering Fundamentals 14'] = 'Pathways:Introduction to Vocal Variety and Body Language - Emphasis on Vocal Variety';

		$map[$path.' Level 3 Increasing Knowledge 512'] = 'Pathways:Researching and Presenting';

	}



	if(strpos($slug,'1233071'))

		return 'Pathways:DTM Project Speech 1';

	elseif(strpos($slug,'1233072'))

		return 'Pathways:DTM Project Speech 2';

	elseif(strpos($slug,'9999'))

		return 'Pathways 360 Level 5 Demonstrating Expertise 99';

	elseif(strpos($slug,'9999'))

		return 'Pathways 360 Level 5 Demonstrating Expertise 99';

	elseif ( ! empty( $map[ $slug ] ) ) {

		return $map[ $slug ];

	}

	return $slug;

}



function fetch_evaluation_form( $slug ) {



	$slug = pathways_project_map( $slug );



	$slug    = 'wpteval_' . $slug;

	$default = array(

		'intro'   => 'Specific evaluation form not found. The default Pathways evaluation criteria are shown below',

		'prompts' => 'You excelled at:

You may want to work on:

To challenge yourself:

Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)

Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)

Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)

Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)

Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)

Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)

Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)',

	);



	$form = get_option( $slug ); // check for cached copy

	if ( ! empty( $form ) ) {

		if ( is_array( $form ) ) {

			$form = (object) $form;

		}

		return $form;

	}

	$url = 'http://wp4toastmasters.com/wp-json/evaluation/v1/form/' . urlencode( $slug );

	if ( isset( $_GET['debug'] ) ) {

		printf( '<p>Look up %s</a>', $url );

	}

	$args    = array( 'timeout' => 20 );

	$request = wp_remote_get( $url, $args );

	if ( is_wp_error( $request ) ) {

		return $default; // Bail early

	}

	$body = wp_remote_retrieve_body( $request );



	if ( $body == 'false' ) {

		return $default;

	}

	$form = json_decode( $body );

	update_option( $slug, $form );

	set_transient( $slug, $form, WEEK_IN_SECONDS );

	return $form;

}



class DuesExtractor {

	public $reverse_dues_table = array();

	function __construct() {

		$expected_renewal = 60.00;

		$plus6            = array();

		$ti_dues          = get_option( 'ti_dues' );

		$club_dues        = get_option( 'club_dues' );

		$new_member_fee   = (int) get_option( 'club_new_member_fee' );

		if ( ! empty( $ti_dues ) ) {

			$expected_renewal  = $ti_dues[3];

			$expected_renewal += $club_dues[3];

			$expected_renewal  = number_format( $expected_renewal, 2 );

			foreach ( $ti_dues as $index => $amount ) {

				$total_dues[ $index ]     = number_format( $amount + $club_dues[2] + $new_member_fee, 2 );

				$total_dues_new[ $index ] = number_format( $amount + $club_dues[2] + 20 + $new_member_fee, 2 );

				if ( ( $amount + $club_dues[2] ) > $expected_renewal ) {

					if ( $index < 4 ) {

						$month = 9;

					} else {

						$month = 3;

					}

				} else {

					if ( $index < 4 ) {

						$month = 3;

					} else {

						$month = 9;

					}

				}

				$paid_month[ $index ] = $month;

			}

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][0]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 9,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][1]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 9,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][2]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 9,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][3]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 9,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][4]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 9,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][6]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 3,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][7]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 3,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][8]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 3,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][9]  = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 3,

			);

			$this->reverse_dues_table[ 'ifdues' . $expected_renewal ][10] = array(

				'owe_ti'     => $ti_dues[3],

				'paid_month' => 3,

			);

			foreach ( $total_dues as $index => $amount ) {

				$this->reverse_dues_table[ 'ifdues' . $amount ][ $index ] = array(

					'owe_ti'     => $ti_dues[ $index ],

					'paid_month' => $paid_month[ $index ],

				);

				$amount = $total_dues_new[ $index ];

				$this->reverse_dues_table[ 'ifdues' . $amount ][ $index ] = array(

					'owe_ti'     => $ti_dues[ $index ] + 20,

					'paid_month' => $paid_month[ $index ],

				);

			}

		}

	}



	function get_paid_owed( $payment, $payment_date, $already_paid_until ) {

		if ( empty( $this->reverse_dues_table ) || empty( $payment ) || empty( $payment_date ) ) {

			return;

		}

		$month = date( 'n', strtotime( $payment_date ) );

		$index = $month - 1;

		$year  = date( 'Y', strtotime( $payment_date ) );

		$key   = 'ifdues' . number_format( $payment, 2 );

		if ( empty( $this->reverse_dues_table[ $key ][ $index ] ) ) {

			return;

		} else {

			$answer = $this->reverse_dues_table[ $key ][ $index ];

			if ( $month > $answer['paid_month'] ) {

				$year++;

			}

			$day                  = ( $answer['paid_month'] == 3 ) ? 31 : 30;

			$answer['paid_month'] = $answer['paid_month'] . '/' . $day . '/' . $year;

			if ( isset( $_GET['debug'] ) ) {

				printf( '<p>paid/owed %s %s already: \'%s\' new: \'%s\'</p>', $payment, $payment_date, $already_paid_until, $answer['paid_month'] );

			}

			if ( $answer['paid_month'] == $already_paid_until ) {

				return; // nothing new

			}

			// printf('<p>%s %s %s</p>',$payment,$payment_date,var_export($answer,true));

			return $answer;

		}

	}



	function show_reverse() {

		echo '<pre>';

		print_r( $this->reverse_dues_table );

		echo '</pre>';

	}

}



function get_treasurer_notes( $member_id, $treasurer_note ) {

	global $wpdb;

	$sql     = "SELECT * FROM $wpdb->usermeta WHERE user_id= $member_id AND meta_key='$treasurer_note' ORDER BY umeta_id DESC";

	$results = $wpdb->get_results( $sql );

	if ( empty( $results ) ) {

		return;

	}

	foreach ( $results as $index => $row ) {

		if ( $index >= 5 ) {

			$wpdb->query( "DELETE FROM $wpdb->usermeta WHERE umeta_id=$row->umeta_id" );

			if ( $index == 5 ) {

				$notes[] = '<em>limited to 5 most recent</em>';

			}

		} else {

			$notes[] = $row->meta_value;

		}

	}

	return $notes;

}



function wpt_renewal_dates() {

	$t = strtotime('March');

	for($i = 0; $i < 6; $i++) {

		if($i > 0)

			$t += (182  * DAY_IN_SECONDS);

		$day = ('3' == date('m',$t)) ? '-31' : '-30';

		if($t > time())

			$renewal_dates[] = date('Y-m',$t).$day;

	}

	return $renewal_dates;

}



add_action('rsvpmaker_payments_setting_top','wpt_dues_navigation');

function wpt_dues_navigation () {

	echo '<p style="text-align: right; width: 100%;"><a href="'.admin_url('admin.php?page=wpt_dues_report').'">Dues Tracker</a> | <a href="'.admin_url('admin.php?page=wpt_dues_report&tx').'">Transaction List</a>  | <a href="'.admin_url('admin.php?page=wpt_dues_report&followup').'">Follow Up</a> | <a href="'.admin_url('options-general.php?page=member_application_settings').'">Dues & Application Setup</a>  | <a href="'.admin_url('options-general.php?page=rsvpmaker_settings').'">Online Payments Setup</a> </p>';

}



function wpt_dues_report() {



	wpt_dues_navigation();



	if(isset($_GET['tx']))

	{

		$tx = wpt_stripe_transactions();

		echo $tx['content'];

		echo '<div><textarea style="width: 100%" rows="20">'.$tx['export'].'</textarea></div>';

		return;	

	}

	if(isset($_GET['followup']))

	{

	echo wpt_dues_reminders();

	return;

	}



	global $wpdb, $rsvp_options;

	$nonce = wp_nonce_field( 'wpt_dues_report', 'tmn', true, false );

	$stripetable    = $wpdb->prefix . 'rsvpmaker_money';



	if ( isset( $_POST['manual_payment'] )  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$amount = sanitize_text_field($_POST['manual_payment']);

		$user_id = (isset($_POST['user_id'])) ? intval($_POST['user_id']) : -1;

		if($user_id > 0) {

			$name = get_member_name($user_id);

			update_user_meta($user_id,'paid_until_' . get_current_blog_id(),sanitize_text_field($_POST['until']));

		}

		else

			$name = sanitize_text_field($_POST['name']);

		$description = sanitize_text_field($_POST['description']);

		$date = rsvpmaker_date('Y-m-d H:i:s');

		$sql = $wpdb->prepare("INSERT INTO $stripetable SET amount=%s, name=%s, description=%s, user_id=%d, date=%s, status='Other' ",$amount,$name,$description,$user_id,$date);

		$wpdb->query($sql);

	}



	$keys      = get_rsvpmaker_stripe_keys();

	$stripe_on = ( empty( $keys ) || empty( $keys['pk'] ) ) ? false : true;

	$ti_dues   = get_option( 'ti_dues' );

	if ( empty( $stripe_on ) || empty( $ti_dues ) ) {

		printf( '<div class="notice notice-info"><p>If you set up Stripe online payments for dues renewals and specify your dues schedule as part of the <a href="https://www.wp4toastmasters.com/knowledge-base/web-based-toastmasters-membership-application/" target="_blank">online application form setup</a>. You can specify those settings on the <strong>Dues and Application</strong> tab, below.</p></div>' );

	}



	$action    = admin_url( 'admin.php?page=wpt_dues_report' );



	$norenew        = 'no_renew_' . get_current_blog_id();

	$treasurer_note = 'treasurer_note_' . get_current_blog_id();

	$renewal_dates = wpt_renewal_dates();

	$members        = get_club_members();

	$sql = "SELECT * FROM $stripetable WHERE (description LIKE '%Renewal %' OR description LIKE '%Application %' )  ORDER BY id DESC LIMIT 0,100";

	$results = $wpdb->get_results($sql);

	foreach($results as $row) {

		preg_match('/Renewal \(([0-9]+)\)/',$row->description,$match);

		//print_r($match);

		if(isset($match[1])) {

			$user_id = $match[1];

		}

		preg_match('/Application ([0-9]+)/',$row->description,$match);

		//echo '<br>application match';

		//print_r($match);

		if(isset($match[1])) {

			$app_id = $match[1];

			$email = get_post_meta($app_id,'user_email',true);

			$sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key='application_id_".get_current_blog_id()."' AND meta_value=$app_id ";

			//printf('<p>%s</p>',$sql);

			$user_id = $wpdb->get_var($sql);

			if($user_id) {

				$until = get_post_meta($app_id,'tm_application_until',true);

				update_user_meta($user_id,'tm_renew_until_'.get_current_blog_id(),$until);

				//printf('<p>until %s for %d</p>',$until,$user_id);

			}

		}

		if($user_id) {

			$sql = "update $stripetable SET user_id=$user_id WHERE id=$row->id";

			$wpdb->query($sql);

		}

	}



	$sql = "SELECT * FROM $stripetable WHERE user_id=0 ORDER BY id DESC LIMIT 0,100";

	$results = $wpdb->get_results($sql);

	foreach($results as $row) {

		$user = get_user_by('email',$row->email);

		if(isset($user->ID)) 

			$wpdb->query("update $stripetable SET user_id=$user->ID WHERE id=$row->id");

	}



	$sql = "SELECT $wpdb->usermeta.user_id, amount, meta_value FROM $stripetable JOIN $wpdb->usermeta ON $stripetable.user_id=$wpdb->usermeta.user_id WHERE meta_key='".'tm_renew_until_'.get_current_blog_id()."' AND (description LIKE '%Renewal%' OR description LIKE '%Application %' ) ";

	$results = $wpdb->get_results($sql); //recorded as intent

	foreach($results as $row) {

		if(empty($row->meta_value))

			continue;

		update_user_meta($row->user_id,'member_paid_' . get_current_blog_id().'_'.$row->meta_value,$row->amount);

		update_user_meta($row->user_id,'paid_until_' . get_current_blog_id(),$row->meta_value);

	}

	$wpdb->query("delete from $wpdb->usermeta WHERE meta_key='".'tm_renew_until_'.get_current_blog_id()."' ");



	if ( isset( $_POST['match'] )  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST['match'] as $row_id => $match ) {

			$row_id = (int) $row_id;

			$sql = "UPDATE $stripetable SET user_id=$match WHERE id=$row_id";

			$wpdb->query( $sql );

		}

	}

	if ( isset( $_GET['void'] ) ) {

		$user_id = (int) $_GET['void'];

		delete_user_meta( $user_id, $paidkey );

	}



	if ( isset( $_GET['check'] ) ) {

		stripe_balance_history( 50, false );

	}

	if ( isset( $_POST['markpaid'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST['markpaid'] as $member_id => $value ) {

			$member_id = (int) $member_id;

			$until = sanitize_text_field($_POST['until'][ $member_id ]);

			update_user_meta( $member_id, $paidkey, $until );

		}

	}

	if ( isset( $_POST['no'] )  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST['no'] as $member_id => $until ) {

			update_user_meta( (int) $member_id, $norenew, sanitize_text_field($until) );

		}

	}



	echo '<h1>Member Dues Status</h1>';



	$expected_renewal = 45;

	$plus6            = array();

	$ti_dues          = get_option( 'ti_dues' );

	$club_dues        = get_option( 'club_dues' );

	$new_member_fee   = (int) get_option( 'club_new_member_fee' );

	if ( ! empty( $ti_dues ) ) {

		$expected_renewal  = $ti_dues[3];

		$expected_renewal += $club_dues[3];

		$plus6[]           = $expected_renewal + 20 + $new_member_fee;

		if ( ( $ti_dues[2] + $club_dues[2] ) > $expected_renewal ) {

			$plus6[] = $ti_dues[2] + $club_dues[2];

			$plus6[] = $ti_dues[2] + $club_dues[2] + 20 + $new_member_fee;

		}

		if ( ( $ti_dues[1] + $club_dues[1] ) > $expected_renewal ) {

			$plus6[] = $ti_dues[1] + $club_dues[1];

			$plus6[] = $ti_dues[1] + $club_dues[1] + 20 + $new_member_fee;

		}

		// echo 'renewal: '.$expected_renewal; print_r($plus6);

	}



	$sql = "SELECT * FROM $stripetable WHERE user_id != 0 AND date > DATE_SUB(CURDATE(), INTERVAL 3 MONTH) ORDER BY date DESC LIMIT 0,10";

	$latest = $wpdb->get_results($sql);

	if($latest) {

	echo '<h2>Latest Payments</h2>';

		foreach($latest as $tx)

		{

			$status = '';

			if($tx->user_id == -1)

				$status = 'Not a member transaction';

			else {

				$member_name = get_member_name($tx->user_id);

				$paid_until = wpt_member_paid_until($tx->user_id);

				if($paid_until)

					$status = sprintf('<br>%s paid until %s <a href="%s">(Edit Dues Status)</a>',$member_name,date('F Y',strtotime($paid_until)), '#status'.$tx->user_id );

			}

			printf('<p>%s %s %s payment date: %s %s %s</p>', $tx->amount, $tx->name, $tx->description, rsvpmaker_date($rsvp_options['short_date'],rsvpmaker_strtotime($tx->date)), $tx->status, $status );

		}

	}



		$orphans = rsvpmaker_stripe_transactions_no_user();

		if ( $orphans ) {

			echo '<p>These transactions could not be automatically matched to a member record. Please assign them to a member or indicate if they are not member transactions.</p>';

			$member_options = '<option value="-1">Not a Member Transaction</option>';

			foreach ( $members as $member ) {

				$names[ $member->ID ]  = get_user_meta( $member->ID, 'first_name', true ) . ' ' . get_user_meta( $member->ID, 'last_name', true );

				$emails[ $member->ID ] = $member->user_email;

				$member_options       .= sprintf( '<option value="%s">%s %s</option>', $member->ID, $member->display_name, $member->user_email );

			}

			foreach ( $orphans as $orphan ) {

				printf( '<form method="post" action="%s">', $action );

				$possible_matches = '';

				foreach ( $names as $user_id => $name ) {

					similar_text( $orphan->name, $name, $perc );

					if ( $perc > 75 ) {

						$possible_matches .= sprintf( '<option value="%d">%s %s</option>', $user_id, $name, $emails[ $user_id ] );

					}

				}

				$appstatus = (preg_match('/Application [0-9]/',$orphan->description)) ? '<br><em>New member, account not yet created?</em>' : '';

				printf( '<p><select name="match[%d]">%s</select> %s %s %s %s %s %s</p>', $orphan->id, $possible_matches . $member_options, $orphan->name, $orphan->email, $orphan->amount, $orphan->date, $orphan->description,$appstatus );

				submit_button( 'Update' );

				rsvpmaker_nonce();

				echo '</form>';

			}

		}

		// print_r($orphans);



	$month = (int) date( 'n' );

	$year  = (int) date( 'Y' );

	if ( $month < 8 ) {

		$paid_until    = '9/30/' . $year;

		$ti_paid_key   = 'TIpayment_' . get_current_blog_id() . '_' . $year . '-09-30';

		$renewal_start = date( 'Y' ) . '-01-01 00:00:00';

	} else {

		$year++;

		$paid_until    = '3/31/' . $year;

		$ti_paid_key   = 'TIpayment_' . get_current_blog_id() . '_' . $year . '-03-31';

		$renewal_start = date( 'Y' ) . '-07-01 00:00:00';

	}

	printf( '<input type="hidden" id="tipaymentkey" value="%s" />', $ti_paid_key );

	if ( isset( $_POST[ $ti_paid_key ] )  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach ( $_POST[ $ti_paid_key ] as $member_id => $amount ) {

			update_user_meta( (int) $member_id, $ti_paid_key, sanitize_text_field($amount) );

		}





	if ( isset( $_GET['correct'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$member_id = (int) $_GET['correct'];

		delete_user_meta( $member_id, $ti_paid_key );

	}

}



	$members = get_club_members();

	foreach ( $members as $member ) {

		if ( isset( $_GET['reset'] ) ) {

			delete_user_meta( $member->ID, $paidkey );

		}



		$member      = get_userdata( $member->ID );

		$until = wpt_member_paid_until($member->ID);

		/*

		if(empty($until)) {

			$paidkey = '';

			$until = '0000-00-00';

		}

		else

			$paidkey = "TIpayment_".get_current_blog_id()."_".$until;

		$paid_to_ti = (empty($paidkey)) ? '' : get_user_meta($member->ID,$paidkey,true);

		*/

		$index       = $member->display_name;

		$last_stripe = $checked = '';

		$no          = get_user_meta( $member->ID, $norenew, true );

		if ( isset( $_GET['debug'] ) ) {

			printf( '<p>Check transactions for %s %s</p>', $member->ID, $member->display_name );

		}

		$tx = rsvpmaker_stripe_latest_transaction_by_user( $member->ID, $renewal_start );

		if ( $tx ) {

			$txdate = $tx->date;

			$amount = $tx->amount;

			$last_stripe = '<p>recent online payment ' . $amount . ' ' . $txdate . ' <span style="color:red">' . $tx->description . '</span> <p>';

		}



		$log = '';

		$renew_options = '';

		foreach($renewal_dates as $r) {

			$s = ($r == $until) ? ' selected="selected" ' : '';

			$renew_options .= sprintf('<option value="%s" %s>%s</option>',$r,$s,$r);

		}

		$log  .= '<form method="post" action="' . $action . '" class="member_dues_update" id="member_dues_update_' . $member->ID . '"><input type="hidden" name="norenew" value="' . $norenew . '" /><input type="hidden" name="blog_id" value="' . get_current_blog_id() . '" /><input type="hidden" name="member_id" value="' . $member->ID . '"><input type="hidden" name="treasurer_note_key" value="' . $treasurer_note . '" />' . $nonce;

		$log .= '<h3 id="status' . $member->ID . '">' . $member->display_name . ' ' . $member->user_email . ' <span id="confirm' . $member->ID . '"><button>Update</button> </span></h3>' . $last_stripe;

		$log .= sprintf( '<p id="data-entry-' . $member->ID . '"><input type="radio" name="markpaid" id="markpaid%d" class="markpaid" value="1" checked="checked" /> Mark paid until <select name="until">'.$renew_options.'</select> <input type="radio" name="markpaid" id="markpaid%d" class="markpaid" value="0" /> Other update <span id="paidplan%d"><input type="checkbox" name="no[%d]" value="%s"> Not planning to renew</span></p>', $member->ID, $member->ID, $paid_until, $member->ID, $paid_until );

		//$paidnote = ($paid_to_ti) ? $paid_to_ti.' '.__('recorded as paid for the period ending','rsvpmaker-for-toastmasters').' '.$until : '';

		//$log .= '<p id="paid-ti-'.$member->ID.'">'.__('Paid to TI','rsvpmaker-for-toastmasters').' <input type="text" name="paid_to_ti" value="'.$paid_to_ti.'"> '.$paidnote.'</p>';

		$log  .= ( empty( $no ) ) ? '' : sprintf( '<p id="editline%d">Not planning to renew <input type="checkbox" name="updatevoid" member_id="%d" class="editvoid" value="edit" until="%s" paid_to_ti="%s" /> Edit </p>', $member->ID, $member->ID, $paid_until, $paid_to_ti, $member->ID );

		$log  .= '<p class="enter_notes">Notes <input type="text" name="note">';

		$notes = get_treasurer_notes( $member->ID, $treasurer_note );

		if ( ! empty( $notes ) ) {

			$log .= '<br />' . implode( '<br />', $notes );

		}

		$log .= '</p>';

		if ( isset( $_GET['checkpaid'] ) ) {

			$log .= sprintf( '<p>paidkey "%s" paid until "%s"</p>', $member->$paidkey, $paid_until );

		}

		if($no)

			$notrenewing[ $index ] = $log . rsvpmaker_nonce('return').'</form>';

		$until_sort[$until][$index] = $log.rsvpmaker_nonce('return').'</form>';

/*

		if ( ! empty( $member->$paidkey ) && ( $member->$paidkey == $paid_until ) ) {

			$paid_ti = get_user_meta( $member->ID, $ti_paid_key, true );

			if ( $paid_ti ) {

				$ti_payment = sprintf( '<p id="editline%d">Paid to TI %s <input type="radio" name="updatevoid" member_id="%d" class="editvoid" value="edit" until="%s" paid_to_ti="%s" /> Edit <input type="radio" name="updatevoid" class="editvoid" value="%d" /> Void </p>', $member->ID, $paid_ti, $member->ID, $paid_until, $paid_ti, $member->ID, $member->ID );

			} else {

				$ti_payment = sprintf( '<p><input type="hidden" name="markpaid[%d]" value="1" /> Paid to TI <input type="text" name="%s[%d]" /></p>', $member->ID, $ti_paid_key, $member->ID );

			}

			$paid_emails[]   = $member->user_email;

			$log            .= $ti_payment;

			$logs2[ $index ] = $log . '</form>';

		} elseif ( $no ) {

			$notrenewing[ $index ] = $log . rsvpmaker_nonce('return').'</form>';

		} else {

			$logs[ $index ] = $log . rsvpmaker_nonce('return').'</form>';

		}

	*/

	}

	if(!empty($until_sort)) {

		ksort($until_sort);

		foreach($until_sort as $date => $records) {

			if(empty($date) || ('0000-00-00' == $date))

				$date = '?';

			printf('<h1>Paid until: %s</h1>',$date);

			foreach($records as $record) {

				echo $record;

			}

		} 

	}



	if ( ! empty( $logs ) ) {

		ksort( $logs );

		echo '<div style="padding: 5px; border: medium solid red">';

		printf( '<h3>Not Renewed (%s)</h3>%s', sizeof( $logs ), implode( "\n", $logs ) );

		echo '</div>';// end colored border

	}

	if ( ! empty( $logs2 ) ) {

		ksort( $logs2 );

		echo '<div style="padding: 5px; border: medium solid green; margin-top: 20px;">';

		printf( '<h3>Members Who Have Renewed (%s)</h3>%s', sizeof( $logs2 ), implode( "\n", $logs2 ) );



		echo '</div>';// end colored border

	}

	if ( ! empty( $notrenewing ) ) {

		ksort( $notrenewing );

		echo '<div style="padding: 5px; border: medium solid gray; margin-top: 20px;">';

		printf( '<h3>Not Planning to Renew (%s)</h3>%s', sizeof( $notrenewing ), implode( "\n", $notrenewing ) );

		echo '</div>';

	}



?>

<h3 id="manual_payment_dues">Record Dues Payment</h3>

<form method="post" action="<?php echo admin_url('admin.php?page=wpt_dues_report'); ?> ">

<p>Amount <input type="text" name="manual_payment"> Description <input type="text" name="description" value="Dues">

<?php 

echo __('for','rsvpmaker-for-toastmasters').' '.awe_user_dropdown('user_id',0,true,'').' ';

$renew_options = '';

foreach($renewal_dates as $r) {

	$renew_options .= sprintf('<option value="%s">%s</option>',$r,$r);

}

printf('until <select name="until">%s</select>',$renew_options);

rsvpmaker_nonce();

submit_button(); ?>

</form>

<h3 id="manual_payment_other">Other Payment</h3>

<form method="post" action="<?php echo admin_url('admin.php?page=wpt_dues_report'); ?> ">

<p>Amount <input type="text" name="manual_payment"> Description <input type="text" name="description" value="">

<?php 

echo __('from','rsvpmaker-for-toastmasters').' '.'<input type="text" name="name" >';

rsvpmaker_nonce();

submit_button(); ?>

</form>



<?php



}//end wpt_dues_report()



function wpt_member_paid_until($member_id) {

	global $wpdb;

	$until = get_user_meta($member_id,'paid_until_' . get_current_blog_id(),true);

	if(strpos($until,'/'))

	{

		$until = date('Y-m-d',strtotime($until));

	}

	if(empty($until)) {

		$lookup = "TIpayment_".get_current_blog_id().'_';

		$sql = "SELECT meta_key FROM $wpdb->usermeta WHERE user_id=$member_id AND meta_key LIKE '$lookup%' ORDER BY umeta_id ";

		$key = $wpdb->get_var($sql);

		$until = str_replace($lookup,'',$key);

	}

	return $until;

}



function wpt_dues_reminders() {

	global $current_user;

	$renewal_dates = wpt_renewal_dates();

	$earliest = strtotime($renewal_dates[0]);

	$now = time();

	$paidkey           = 'paid_until_' . get_current_blog_id();

	$norenew           = 'no_renew_' . get_current_blog_id();

	$members           = get_club_members();

	$reminder          = $thanks = '';

	$reminder_subject  = 'Please renew your dues for ' . get_bloginfo( 'name' );

	$thank_you_subject = 'Thank you for renewing your dues for ' . get_bloginfo( 'name' );

	$renew_id          = get_option( 'ti_dues_renewal_page' );

	$reminder_body     = ( $renew_id ) ? 'You can pay your dues online at ' . get_permalink( $renew_id ) : '';

	foreach ( $members as $member ) {

		$member = get_userdata( $member->ID );

		$index  = $member->display_name;

		$until  = wpt_member_paid_until($member->ID);

		if(empty($until))

			{

				$until = '0000-00-00';

				$t = 0;

			}

		else

			$t = strtotime($until);

		$phones = '';

		if ( ! empty( $member->home_phone ) ) {

			$phones .= ' Home Phone: ' . $member->home_phone;

		}

		if ( ! empty( $member->mobile_phone ) ) {

			$phones .= ' Mobile Phone: ' . $member->mobile_phone;

		}

		if ( ! empty( $member->work_phone ) ) {

			$phones .= ' Work Phone: ' . $member->work_phone;

		}

		$phones;

		$style = ($t < $now) ? ' style="color: red;" ' : '';

		if(!isset($reminders[$until]))

			{

				$reminders[$until] = '';

				$reminder_emails[$until] = array();

			}

		$reminders[$until] .= sprintf( '<p %s >Reminder: %s <a target="_blank" href="mailto:%s?subject=%s&body=%s">%s</a> %s</p> ', $style , $member->display_name, $member->user_email, $reminder_subject, $reminder_body, $member->user_email, $phones );

		$reminder_emails[$until][] = $member->user_email;

	}

	$output = '';

	if ( $reminders ) {

		ksort($reminders);

		ksort($reminder_emails);

		foreach($reminders as $until => $reminder) {

			$remindernote = ($until == '0000-00-00') ? '' : ' (Paid until '.$until.')';

			$output .= '<h2>Reminders '.$remindernote.'</h2>' . $reminder;

			$output .= sprintf( '<p><a target="_blank" href="mailto:%s?bcc=%s&subject=%s&body=%s">Email All</a></p> ', $current_user->user_email, implode( ',', $reminder_emails[$until] ), $reminder_subject, $reminder_body );

		}

	}

	return $output;

}



function wpt_stripe_transactions() {

	$transactions = rsvpmaker_stripe_transactions_list();

	if ( $transactions ) {



		$transaction = (array) $transactions[0];

		$th          = '<tr>';

		$td          = '';

		foreach ( $transaction as $column => $value ) {

			if ( ( $column == 'id' ) || ( $column == 'metadata' ) || ( $column == 'status' ) || ( $column == 'transaction_id' ) || ( $column == 'user_id' ) ) {

				continue;

			}

			$th     .= '<th>' . $column . '</th>';

			$export .= $column . ',';

		}

		//$th     .= '<th>paid ti</th></tr>';

		//$export .= "paid ti\n";

		foreach ( $transactions as $transaction ) {

			$line        = '';

			$td         .= '<tr>';

			$transaction = (array) $transaction;

			if ( ! empty( $transaction['metadata'] ) ) {

				// could be used for paid to toastmasters amount

				$metadata                = unserialize( $transaction['metadata'] );

				$transaction['metadata'] = var_export( $metadata, true );

			}



			foreach ( $transaction as $column => $value ) {

				if ( ( $column == 'id' ) || ( $column == 'metadata' ) || ( $column == 'status' ) || ( $column == 'transaction_id' ) || ( $column == 'user_id' ) ) {

					continue;

				}

				$td .= '<td>' . $value . '</td>';

				if ( strpos( $value, '"' ) ) {

					$value = str_replace( '"', '\"', $value );

				}

				if ( ! is_numeric( $value ) ) {

					$value = '"' . $value . '"';

				}

				$line .= $value . ',';

			}

			$lines[] = $line;

		}

		krsort( $lines );

		$export .= implode( "\n", $lines );

		return array(

			'content' => '<h3>50 Most Recent Stripe Transactions</h3><table>' . $th . $td . '</table>',

			'export'  => $export,

		);

	}

}



function wpt_my_data() {

	global $current_user, $wpdb;

	?>

<style>

label {font-weight: bold; display: inline-block; width: 200px;}

</style>

<h1>My Data</h1>

<p>This report aims to show the data gathered about your club participation in one place.</p>

<form method="get" action="admin.php">

<input type="hidden" name="page" value="wpt_my_data" />

Show <input type="checkbox" name="speeches" value="1" 

	<?php

	if ( isset( $_GET['speeches'] ) ) {

		echo ' checked="checked" ';}

	?>

 > Speeches

<input type="checkbox" name="evaluations" value="1" 

	<?php

	if ( isset( $_GET['evaluations'] ) ) {

		echo ' checked="checked" ';}

	?>

 > Evaluations 

<input type="checkbox" name="other_roles" value="1" 

	<?php

	if ( isset( $_GET['other_roles'] ) ) {

		echo ' checked="checked" ';}

	?>

> Other Roles 

<input type="checkbox" name="everything" value="1"

	<?php

	if ( isset( $_GET['everything'] ) ) {

		echo ' checked="checked" ';}

	?>

 > Everything 

<button>Show Report</button>

<?php rsvpmaker_nonce(); ?>

</form>

	<?php

	if ( isset( $_GET['speeches'] ) || isset( $_GET['everything'] ) ) {

		$links[] = '<a href="#my_data_speeches">Speeches</a>';

	}

	if ( isset( $_GET['evaluations'] ) || isset( $_GET['everything'] ) ) {

		$links[] = '<a href="#my_data_evaluations">Evaluations</a>';

	}

	if ( isset( $_GET['other_roles'] ) || isset( $_GET['everything'] ) ) {

		$links[] = '<a href="#my_data_other">Other Roles</a>';

	}

	if ( ! empty( $links ) ) {

		printf( '<p><strong>Showing</strong> %s</p>', implode( ' | ', $links ) );

	}



	$contact                = wp_get_user_contact_methods( $current_user );

	$contact['description'] = 'Description';

	$userdata               = get_userdata( $current_user->ID );

	printf( '<p>To change contact details, <a href="%s">Edit My Profile</a></p>', admin_url( 'profile.php' ) );

	printf( '<h1>%s %s</h1>', $userdata->first_name, $userdata->last_name );

	foreach ( $contact as $index => $label ) {

		if ( ! empty( $userdata->$index ) ) {

			printf( '<div><label>%s</label> %s</div>', $label, $userdata->$index );

		}

	}



	if ( isset( $_GET['speeches'] ) || isset( $_GET['everything'] ) ) {

		echo '<h2 id="my_data_speeches">Speeches</h2>';

		echo speeches_by_manual( $current_user->ID );

	}



	if ( isset( $_GET['evaluations'] ) || isset( $_GET['everything'] ) ) {

		echo '<h3 id="my_data_evaluations">Evaluations</h3>';

		$results = wp4t_history_query( ['where'=>"user_id=$current_user->ID AND role = 'Evaluator' ",'orderby'=>'datetime'] );

		if ( $results ) {

			foreach ( $results as $row ) {

				$t     = rsvpmaker_strtotime( $row->datetime );

				$date  = rsvpmaker_date( 'F j, Y', $t );

				printf( '<p>%s %s %s</p>', $row->role, $date, $row->domain );

			}

		}

	}



	if ( isset( $_GET['other_roles'] ) || isset( $_GET['everything'] ) ) {

		echo '<h2 id="my_data_other">Other Roles</h2>';

		$results = wp4t_history_query( ['where'=>"user_id=$current_user->ID AND role != 'Speaker' AND role != 'Evaluator' ",'orderby'=>'datetime'] );

		if ( $results ) {

			foreach ( $results as $row ) {

				$t     = rsvpmaker_strtotime( $row->datetime );

				$date  = rsvpmaker_date( 'F j, Y', $t );

				printf( '<p>%s %s %s</p>', $row->role, $date, $row->domain );

			}

		}

	}

	if ( is_plugin_active( 'delete-me/delete-me.php' ) ) {

		if ( current_user_can( 'manage_options' ) ) {

			echo '<p>Regular members (not administrators) will see a Delete My Profile option here.</p>';

		} else {

			printf( '<h2>Delete My Profile</h2><p>If you wish to delete your account and all associated data, follow <a href="%s">this link</a> and confirm the request with your password.</p>', admin_url( 'options.php?page=plugin_delete_me_confirmation' ) );

		}

	} elseif ( current_user_can( 'manage_options' ) ) {

		echo '<p><strong>Administrators</strong>: Consider installing the <a href="https://wordpress.org/plugins/delete-me/">Delete Me</a> plugin to allow users to delete their own accounts and data.</p>';

	}

	$data = wpt_data_disclosure( $current_user->ID );

	echo '<div>Data inventory: ' . implode( ', ', $data ) . '</div>';

}



function wpt_data_disclosure ($user_id) {

	global $wpdb;

	$history_table = $wpdb->base_prefix.'tm_history';



		$contact = wp_get_user_contact_methods($user_id);

		$contact['description'] = 'Description';

		$userdata = get_userdata($user_id);

		if(!empty($userdata->first_name))

			$data[] = 'First Name';

		if(!empty($userdata->last_name))

			$data[] = 'Last Name'.$userdata->last_name;

		foreach($contact as $index => $label) {

			if(!empty($userdata->$index))

				$data[] = $label;

		}

		$sql = "SELECT * FROM $history_table WHERE role='Speaker' AND user_id=".$user_id;

		$results = $wpdb->get_results($sql);

		$data[] = "Speech records: ".sizeof($results);

		$sql = "SELECT * FROM $history_table WHERE role!='Speaker' AND user_id=".$user_id;

		$results = $wpdb->get_results($sql);

		$data[] = "Other meeting role records: ".sizeof($results);

		$blogs = get_blogs_of_user($user_id);

		$data[] = 'Active club websites you are listed as a member of '.sizeof($blogs);

		if($blogs) {

			foreach($blogs as $blog)

				$bloglist[] = '<a href="'.$blog->siteurl.'">'.$blog->blogname.'</a>';// var_export($blog,true);

			$data[] = implode(', ',$bloglist);

		}

		return $data;

}



function wpt_evaluation_reminder() {

	global $wpdb;

	$output = '';

	$past = get_past_events( '', 1 );

	if(!empty($past[0])) {

		$date = preg_replace('/ [0-9]{2}:[0-9]{2}:[0-9]{2}/','',$past[0]->datetime);

		$mail['html'] = "<p>You are receiving this message as part of the evaluation team for $date</p>";

		$post_id = $past[0]->ID;

		$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post_id AND meta_key LIKE '_role_Speaker%' ORDER BY meta_key";

		$results = $wpdb->get_results($sql);

		foreach($results as $row) {

			if(is_numeric($row->meta_value) && $row->meta_value > 0)

			{

				$speaker_id = $row->meta_value;

				if(wpt_evaluation_check($speaker_id,$date)) {

					$output .= "<p>Evaluation recorded for $speaker_id $date</p>";

				}

				else

				{

					if(!$evaluators) {

						$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post_id AND meta_key LIKE '%Evaluator%' AND meta_value > 0 ORDER BY meta_key";

						$evalres = $wpdb->get_results($sql);

						foreach($evalres as $evrow) {

							if(is_numeric($evrow->meta_value))

							{

								$evaluators[] = get_userdata($evrow->meta_value);

							}

						}

					}

					$speaker_name = get_member_name($speaker_id);

					$project_index = get_post_meta($post_id,'_project'.$row->meta_key,true);

					$project_eval_url = add_query_arg('evalme',$speaker_id,get_permalink($post_id));

					$project_eval_output = "<p><a href=\"$project_eval_url\">Evaluation Link</a></p>\n";

					$mail['html'] .= sprintf('<p>%s may not yet have received a written evaluation for a speech on %s (at least not through the online system). If you were this speaker\'s evaluator, you can provide that feedback now.</p>'."\n",$speaker_name,$date).$project_eval_output;

					$output .= $project_eval_output;

				}

			}

		}

		if(!empty($evaluators)) {

			$mail['subject'] = 'Written evaluation reminder';

			foreach($evaluators as $ev) {

				$mail['to'] = $ev->user_email;

				$mail['toname'] = $ev->display_name;

				$mail['from'] = get_bloginfo('admin_email');

				$mail['fromname'] = get_bloginfo('name');

				rsvpmailer($mail);

				$output .= var_export($mail,true);

			}

		}

	}

	return $output;

}



add_action('wpt_evaluation_reminder','wpt_evaluation_reminder');

add_shortcode('wpt_evaluation_reminder','wpt_evaluation_reminder');



function wpt_evaluation_check($speaker_id,$date) {

	global $wpdb;

	$sql = "SELECT umeta_id FROM $wpdb->usermeta WHERE user_id=$speaker_id AND meta_key LIKE 'evaluation|".$date."%'";

	return $wpdb->get_var($sql);

}



function agenda_template_editor () {

	echo '<h1>Agenda Template Editor</h1>';

	echo '<div id="react-agenda" mode="settings_admin">Loading ... </div>

	<p id="loading-icon"><img width="256" height="256" src="'.plugins_url('images/load-32_256.gif', __FILE__).'" /></p>';

}

function tm_oneclick_message($post_id,$role,$nonce,$shortdate,$suggest_all_message) {
	global $current_user, $login_signup;
	if(empty($login_signup))
		{
			$url = wp_login_url(get_permalink($post_id));
			$login_signup = sprintf('<a href="%s">%s</a>',$url,__('login','rsvpmaker-for-toastmasters'));
		}
	$oneclick = add_query_arg(array('oneclick' => $nonce,'role' => $role,'e' => '*|EMAIL|*','mode' => 'suggestall','by'=>$current_user->ID),get_permalink($post_id));
	$oneclick = sprintf('<a style="width: 150px; text-align: center; text-decoration: none; font-weight: bold; display: block; background-color: #004165; color: #FFFFFF; padding: 10px;" href="%s#oneclick">Accept Role</a>',$oneclick);
	$absence = add_query_arg(array('oneclick' => $nonce,'role' => 'absent','e' => '*|EMAIL|*','mode' => 'suggestall','by'=>$current_user->ID),get_permalink($post_id));
	$absence = sprintf('<a style="width: 150px; text-align: center; text-decoration: none; font-weight: bold; display: block; background-color: red; color: #FFFFFF; padding: 10px;" href="%s#oneclick">Will Not Attend</a>',$absence);
	$message = str_replace('[yesbutton]',$oneclick,str_replace('[role]',$role,str_replace('[shortdate]',$shortdate,$suggest_all_message)));
	$message = str_replace('[absencebutton]',$absence,$message);
	$message = str_replace('[login]',$login_signup,$message);
	return $message;
}

function wpt_suggest_all_roles() {
	global $wpdb, $rsvp_options, $current_user;
	$history_table = $wpdb->base_prefix.'tm_history';
	if(isset($_POST['suggest_all_subject'])) {
		$suggest_all_subject = sanitize_text_field(stripslashes($_POST['suggest_all_subject']));
		$suggest_all_message = wp_kses_post(stripslashes($_POST['suggest_all_message']));
		$suggest_all_weeks = intval($_POST['suggest_all_weeks']);
		$suggest_all_active = intval($_POST['suggest_all_active']);
		update_option('tm_suggest_all_subject',$suggest_all_subject);
		update_option('tm_suggest_all_message',$suggest_all_message);
		update_option('tm_suggest_all_weeks',$suggest_all_weeks);
		update_option('tm_suggest_all_active',$suggest_all_active);
	}
	if(isset($_POST['reset_defaults'])) {
		delete_option('tm_suggest_all_weeks');
		delete_option('tm_suggest_all_active');
		delete_option('tm_suggest_all_subject');
		delete_option('tm_suggest_all_message');
		$suggest_all_weeks = $suggest_all_active = $suggest_all_subject = $suggest_all_message = false;
	}
	else {
		$suggest_all_weeks = get_option('tm_suggest_all_weeks');
		$suggest_all_active = get_option('tm_suggest_all_active');
		$suggest_all_subject = get_option('tm_suggest_all_subject');
		$suggest_all_message = get_option('tm_suggest_all_message');
	}
	if(!$suggest_all_weeks)
		$suggest_all_weeks = 3;
	if(!$suggest_all_active)
		$suggest_all_active = 12;	
	if(!$suggest_all_subject)
		$suggest_all_subject = 'Can we sign you up for [role] on [shortdate]?';
	if(!$suggest_all_message)
		$suggest_all_message = '<p>Can we sign you up for the role of [role] for [shortdate]?</p>

<p>[yesbutton]</p>

<p>Clicking the button above will allow you to accept the role without needing to enter your password. If you cannnot attend, letting us know that will also help us plan.</p>

<p>[absencebutton]</p>

<p>The buttons are meant to make it easy for you to respond, but you can also [login] to take any other role.</p>

<p>Thank you!</p>';
	
	$recent = [];
	$active = [];
	$sql = "SELECT * FROM `$history_table` WHERE datetime > DATE_SUB(CURDATE(), INTERVAL $suggest_all_weeks WEEK) AND domain='".$_SERVER['SERVER_NAME']."'";
	$results = $wpdb->get_results($sql);
	foreach($results as $row) {
		$recent[$row->role][] = $row->user_id;
	}
	$sql = "SELECT * FROM `$history_table` WHERE datetime > DATE_SUB(CURDATE(), INTERVAL $suggest_all_active WEEK) AND domain='".$_SERVER['SERVER_NAME']."'";
	$results = $wpdb->get_results($sql);
	foreach($results as $row) {
		if(!in_array($row->user_id,$active))
			$active[] = $row->user_id;
	}
	$meetings = future_toastmaster_meetings();
	if(empty($meetings)) {
		echo 'No meetings on record';
		return;
	}
	$meeting_id = (isset($_GET['meeting'])) ? intval($_GET['meeting']) : $meetings[0]->ID;
	$o = '';
	foreach($meetings as $index => $m) {
		if($m->ID == $meeting_id) {
			$meeting = $m;
			$meeting_index = $index;
		}
		$s = ($m->ID == $meeting_id) ? ' selected="selected" ' : '';
		$o .= sprintf('<option value="%d" %s>%s %s</option>',$m->ID,$s,rsvpmaker_date($rsvp_options['short_date'],$m->ts_start),$m->post_title);
	}

	$shortdate = rsvpmaker_date($rsvp_options['short_date'],$meeting->ts_start);
	$absences = get_absences_array( $meeting->ID );
	$exclude = $absences;
	$exclude[] = $current_user->ID;
	$members = get_club_members();
	$absent_members = [];
	$inactive_list = '';
	$member_list = [];
	foreach($members as $member) {
		if(in_array($member->ID,$absences))
			$absent_members[] = $member->display_name;
		elseif(in_array($member->ID,$active)) {
			$member_list[$member->ID] = $member->display_name;
			$member_email[$member->ID] = $member->user_email;
		}
		else
			$inactive_list .= sprintf('<option value="%d">%s</option>',$member->ID,$member->display_name);
	}
	if($inactive_list)
		$inactive_list = '<optgroup label="Has not taken a role in '.$suggest_all_active.' weeks">'.$inactive_list.'</optgroup>';

	if(isset($_POST['send'])) {
		$message_log = '';
		$blogname = get_option('blogname');
		foreach($_POST['send'] as $index) {
			$suggested = intval($_POST['suggested'][$index]);
			$subject = stripslashes($_POST['subject'][$index]);
			$email = $member_email[$suggested];
			$role = stripslashes($_POST['role'][$index]);
			$message = str_replace('*|EMAIL|*',$email,stripslashes($_POST['message'][$index]));
			$message_log .= sprintf('<h3>To %s %s</h3>',$email,$subject)."\n".$message;
			$mail['to'] = $email;
			$mail['subject'] = $subject;
			$mail['html'] = $message;
			$mail['from'] = $current_user->user_email;
			$mail['fromname'] = $current_user->display_name.', '.$blogname;
			rsvpmailer($mail);
			$suggestions[$role][] = $suggested;
		}
		$mail['subject'] = 'Suggest All Roles for '.rsvpmaker_date($rsvp_options['short_date'],$meeting->ts_start);
		$mail['html'] = $message_log;
		$mail['to'] = $current_user->user_email;
		rsvpmailer($mail);

		$message_log = sprintf('<p>Sent %s by %s</p>',date('r'),$current_user->display_name).$message_log;
		update_post_meta($meeting->ID,'suggestions',$suggestions);
		update_post_meta($meeting->ID,'suggest_all_roles_log',$message_log);
	}
	elseif(isset($_GET['clearlog'])) {
		delete_post_meta($meeting->ID,'suggest_all_roles_log');
		$message_log = '';
		delete_post_meta($meeting->ID,'suggestions');
	}
	else {
		$message_log = get_post_meta($meeting->ID,'suggest_all_roles_log',true);
		$suggestions = get_post_meta($meeting->ID,'suggestions',true);
		if(!$suggestions)
			$suggestions = array();
	}
	if($message_log) 
		printf('<div style="float: right; width: 300px; background-color: #fff; padding: 10px;"><h3>Messages sent previously for %s</h3>%s</p></div>',$shortdate,$message_log);
	$nonce = get_post_meta($meeting->ID,'oneclicknonce',true);
	if(!$nonce) {
		$nonce = wp_create_nonce('oneclick');
		update_post_meta($meeting->ID,'oneclicknonce',$nonce);	
	}

	$filled_roles = [];
	$data              = wpt_blocks_to_data( $meeting->post_content );
	foreach ( $data as $row => $item ) {
		if ( empty( $item['role'] ) ) {
			continue;
		}
		$role       = sanitize_text_field($item['role']);
		$count      = (empty($item['count'])) ? 1: (int) $item['count'];
		for ( $i = 1; $i <= $count; $i++ ) {
			$field    = wp4t_fieldbase($role,$i);
			$assigned = get_post_meta( $meeting->ID, $field, true );
			if ( empty( $assigned ) ) {
				$openroles[$role][] = $field;
			}
			elseif ( ! is_numeric( $assigned ) ) {
				$filled_roles[] = $role.': '.$assigned . ' (guest)';
			} else {
				//printf('<p>Assignment %s: %d</p>',$role,$assigned);
				$assigned = intval($assigned);
				if(empty($member_list[$assigned]))
					$name = get_member_name($assigned);
				else
					$name = empty($member_list[$assigned]) ? '??' : $member_list[$assigned];
				$filled_roles[] = '<strong>'.$role.'</strong>: '.$name;
				$exclude[] = intval($assigned);
				$hasrole[$assigned][] = $role;
			}
		}
	}

	$hasrole_options = '<optgroup label="Has a Role">';
	if(!empty($hasrole))
	foreach($hasrole as $assigned => $roles)
	{
		if(empty($member_list[$assigned]))
			$name = get_member_name($assigned);
		else
			$name = empty($member_list[$assigned]) ? '??' : $member_list[$assigned];
		$hasrole_options .= sprintf('<option value="%d">%s (%s)</option>',$assigned,$name,implode(', ',$roles));
	}
	$hasrole_options .= '</optgroup>';

	echo '<div style="width: 460px;"><h1>Suggest All Roles</h1>';

	printf('<form action="%s" method="get"><input type="hidden" name="page" value="wpt_suggest_all_roles"><p>Meeting <select name="meeting">%s</select> <button>Change</button></p></form>',admin_url('admin.php'),$o);
	printf('<p>The VP Education, Toastmaster of the Day, or other leader can use this form to quickly suggest roles to members who do not currently have one, with suggestions favoring members who have not held a given role recently.</p><p>Current settings: try to recommend members who have not held a given role in <strong>%d weeks</strong> but who have been active participants within <strong>%d weeks</strong> (<a href="#configure">configure</a>). If messages were sent previously for this meeting, a log will be shown to the right.</p>',$suggest_all_weeks,$suggest_all_active);
	if(!empty($filled_roles))
	echo '<p>Filled roles: '.implode(' ',$filled_roles).'</p>';
	if(!empty($absent_members))
	echo '<p>Planned absences: '.implode(' ',$absent_members).'</p>';
	printf('<form method="post" action="%s"><input type="hidden" name="post_id" value="%d">',admin_url('admin.php?page=wpt_suggest_all_roles&meeting='.$meeting_id),$meeting->ID);
	$count = 0;
	$priority_roles = ['Toastmaster of the Day','Speaker','Evaluator'];
	$allopen = [];
	foreach($priority_roles as $role) {
		if(!empty($openroles[$role])) {
		foreach($openroles[$role] as $item)
			$allroles[] = $role;
		}
	}

	foreach($openroles as $role => $items) {
		if(in_array($role,$priority_roles) || 'Backup Speaker' == $role)
			continue;
		foreach($items as $item)
			$allroles[] = $role;
	}

	foreach($allroles as $role) {
		$candidates = $other_candidates = [];
		$recently_held = empty($recent[$role]) ? [] : $recent[$role];
		foreach($member_list as $user_id => $name) {
			if(!in_array($user_id,$exclude)) {
				if(!in_array($user_id,$recently_held))
					$candidates[$user_id] = $name;
				else
					$other_candidates[$user_id] = $name;
			}
		}
		$keys = array_keys($candidates);
		shuffle($keys);
		$other_keys = array_keys($other_candidates);
		shuffle($other_keys);
		$count++;
		$previous_suggestion = '';
		if($suggestions[$role])
		{
			while($suggested = array_shift($suggestions[$role]))
			{
				if(empty($hasrole[$suggested])) {
					$previous_suggestion = sprintf('<option value="%d">%s (previously suggested)</option>',$suggested,$member_list[$suggested]);
					break;
				}
			}
		}
		$nominee = array_shift($keys);
		if(!$nominee)
			{
				$nominee = array_shift($other_keys);
			}
			if(!$nominee)
			{
				break;
			}
		$exclude[] = $nominee;
		//printf('<p>Nominee: %s %d</p>',$member_list[$nominee],$nominee);
		$nominee_dropdown = sprintf('<option value="%d">%s %s</option>',$nominee,$member_list[$nominee],$held);
		foreach($keys as $key) {
			$held = wp4t_last_held_role($key, $role);
			if($held)
				$held = '<em>Last held role: '.$held.'</em>';
			$nominee_dropdown .= sprintf('<option value="%d">%s %s</option>',$key,$member_list[$key],$held);
		}
		foreach($other_keys as $key) {
			$held = wp4t_last_held_role($key, $role);
			if($held)
				$held = '<em>Last held role: '.$held.'</em>';
			$nominee_dropdown .= sprintf('<option value="%d">%s %s</option>',$key,$member_list[$key],$held);
		}
		$dropdown = $previous_suggestion.$nominee_dropdown.$inactive_list.$hasrole_options;
		printf('<p><input type="checkbox" checked="checked" name="send[]" value="%d"> #%d %s<br><select name="suggested[%d]">%s</select></p>',$count,$count,$role,$count,$dropdown);
		$subject = str_replace('[role]',$role,str_replace('[shortdate]',$shortdate,$suggest_all_subject));
		printf('<input type="hidden" name="role[%d]" value="%s">',$count,$role);
		printf('<div><input type="text" name="subject[%d]" value="%s" style="width: 450px"></div>',$count,$subject);
		$message = tm_oneclick_message($meeting->ID,$role,$nonce,$shortdate,$suggest_all_message);
		printf('<div><textarea name="message[%d]" class="mce" style="width: 450px" rows="10">%s</textarea></div>',$count,$message);
	}
	submit_button('Send Suggestions');
	echo '</form></div>';
	
	echo '<h2>Recent Meeting Participants</h2>';
	foreach($recent as $role => $member_ids) {
		printf('<h2>%s</h2>',$role);
		foreach($member_ids as $id) {
			$name = get_member_name($id);
			printf('<p>%s</p>',$name);
		}
	}

	echo '<h2 id="configure">Configuration Options</h2>';
	printf('<form method="post" action="%s">',admin_url('admin.php?page=wpt_suggest_all_roles'));
	echo '<p>You can change the default message and recommencation criteria.</p>';
	printf('<div><input type="text" name="suggest_all_subject" style="width: 600px" value="%s"></div>',$suggest_all_subject);
	printf('<div><textarea name="suggest_all_message" class="mce" style="width: 600px" rows="10">%s</textarea></div>',$suggest_all_message);
	echo '<p>Placeholder codes [role] [shortdate] [yesbutton] [absencebutton]</p>';
	printf('<div>Favor recommending members who have not attended for <input type="number" name="suggest_all_weeks" value="%s"> weeks</div>',$suggest_all_weeks);
	printf('<div>Consider members active if they have attended / held a role within <input type="number" name="suggest_all_active" value="%s"> weeks</div>',$suggest_all_active);
	submit_button();
	echo '<p>To make the suggestion function more useful, be sure to reconcile the records for roles held after each meeting using the Update Roles and Attendance screen under TM Administration.</p></form>';

	printf('<form method="post" action="%s">',admin_url('admin.php?page=wpt_suggest_all_roles'));
	submit_button('Reset to Defaults');
	echo '<input type="hidden" name="reset_defaults" value="1"></form>';

}