<?php

function register_rsvptoast_exporter( $exporters ) {
	$exporters['rsvpmaker-for-toastmasters'] = array(
		'exporter_friendly_name' => __( 'RSVPMaker for Toastmasters' ),
		'callback'               => 'rsvptoast_exporter',
	);
	return $exporters;
}

add_filter(
	'wp_privacy_personal_data_exporters',
	'register_rsvptoast_exporter',
	10
);

function rsvptoast_exporter( $email_address, $page = 1 ) {
	global $wpdb;
	global $rsvp_options;
	$number = 500; // Limit us to avoid timing out
	$page   = (int) $page;
	$start  = ( $page > 1 ) ? ( $page - 1 ) * 500 : 0;

	$export_items = array();
	$group_id     = 'toastmasters_profile';
	$group_label  = 'Toastmasters Profile Fields';

	$user = get_user_by( 'email', $email_address );
	if ( empty( $user->ID ) ) {
		$group_label = 'Toastmasters Profile Fields (archived)';
		$sql         = 'SELECT * FROM ' . $wpdb->prefix . "users_archive WHERE email='$email_address'";
		$row         = $wpdb->get_row( $sql );
		if ( ! empty( $row->data ) ) {
			$userdata = (array) unserialize( $row->data );

			foreach ( $userdata as $field => $value ) {
				if ( empty( $value ) ) {
					continue;
				}
				$data[] = array(
					'name'  => $field,
					'value' => $value,
				);
			}
		}
	} else {
		$userdata = get_userdata( $user->ID );

		$extra = array( 'educational_awards', 'home_phone', 'work_phone', 'mobile_phone', 'toastmasters_id', 'club_member_since', 'original_join_date', 'facebook_url', 'twitter_url', 'linkedin_url', 'business_url' );

		foreach ( $extra as $slug ) {
			if ( empty( $userdata->$slug ) ) {
				continue;
			}
			$data[] = array(
				'name'  => $slug,
				'value' => $userdata->$slug,
			);
		}
	}

	if ( ! empty( $data ) ) {
		$export_items[] = array(
			'group_id'    => $group_id,
			'group_label' => $group_label,
			'item_id'     => 'toastprofile-' . $slug,
			'data'        => $data,
		);
	}
	if ( ! empty( $user->ID ) ) {
		$results = $wp4t_history_query( "user_id=$user->ID" );
		if ( $results ) {
			foreach ( $results as $row ) {
				$data      = array();
				$role      = $row->role;
				$data[]    = array(
					'name'  => 'role',
					'value' => $role,
				);
				$data[]    = array(
					'name'  => 'event_date',
					'value' => $row->datetime,
				);
				if ( $role == 'Speaker' ) {
					if ( ! empty( $row->manual ) ) {
						$data[] = array(
							'name'  => 'manual',
							'value' => $row->manual,
						);
					}
					if ( ! empty( $row->project ) ) {
						$data[] = array(
							'name'  => 'project',
							'value' => $row->project,
						);
					}
					if ( ! empty( $row->title ) ) {
						$data[] = array(
							'name'  => 'title',
							'value' => $row->title,
						);
					}
				}
				$data[] = array(
					'name'  => 'domain',
					'value' => $row->domain,
				);

				$export_items[] = array(
					'group_id'    => 'tm_activity',
					'group_label' => 'Toastmasters Activity',
					'item_id'     => 'toastmasters_' . $row->umeta_id,
					'data'        => $data,
				);

			}
		}
	}

	// Tell core if we have more comments to work on still
	$done = true; // revisit?
	return array(
		'data' => $export_items,
		'done' => $done,
	);
}

// other data is metadata attached to user record, but we should delete the user archive
function rsvptoast_eraser( $email_address, $page = 1 ) {
	global $wpdb;
	$sql = 'DELETE FROM ' . $wpdb->prefix . "users_archive WHERE email='$email_address'";
	$wpdb->query( $sql );
	return array(
		'items_removed'  => true,
		'items_retained' => false, // always false in this example
		'messages'       => array(), // no messages in this example
		'done'           => true,
	);
}

function register_rsvptoast_eraser( $erasers ) {
	$erasers['rsvmaker-for-toastmasters'] = array(
		'eraser_friendly_name' => __( 'rsvptoast' ),
		'callback'             => 'rsvptoast_eraser',
	);
	return $erasers;
}

add_filter(
	'wp_privacy_personal_data_erasers',
	'register_rsvptoast_eraser',
	10
);

function rsvptoast_plugin_add_privacy_policy_content() {
	if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
		return;
	}

	$content = sprintf(
		__(
			"Toastmasters agenda data including speech titles are tracked in the website database, as are additional member profile fields. Club officers and the club webmaster may record data such as contact information from your member registration to your member profile. Members may log in to delete personal information they do not wish to share, or an officer/webmaster can do it for them.\n\nBy default, the contact information of former members is retained for future use, but it can be removed from the website database upon request.",
			'rsvpmaker-for-toastmasters'
		)
	);

	wp_add_privacy_policy_content(
		'RSVPMaker for Toastmasters',
		wp_kses_post( wpautop( $content, false ) )
	);
}
add_action( 'admin_init', 'rsvptoast_plugin_add_privacy_policy_content' );
