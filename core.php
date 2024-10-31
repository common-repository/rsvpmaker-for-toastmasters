<?php

function minutes_post_type() {
    $labels = array(
        'name'                  => _x( 'Minutes', 'Post type general name', 'rsvpmaker-for-toastmasters' ),
        'singular_name'         => _x( 'Minutes Item', 'Post type singular name', 'rsvpmaker-for-toastmasters' ),
        'menu_name'             => _x( 'TM Minutes', 'Admin Menu text', 'rsvpmaker-for-toastmasters' ),
        'name_admin_bar'        => _x( 'Minutes', 'Add New on Toolbar', 'rsvpmaker-for-toastmasters' ),
        'add_new'               => __( 'Add New', 'rsvpmaker-for-toastmasters' ),
        'add_new_item'          => __( 'Add New Minutes', 'rsvpmaker-for-toastmasters' ),
        'new_item'              => __( 'New Minutes', 'rsvpmaker-for-toastmasters' ),
        'edit_item'             => __( 'Edit Minutes', 'rsvpmaker-for-toastmasters' ),
        'view_item'             => __( 'View Minutes', 'rsvpmaker-for-toastmasters' ),
        'all_items'             => __( 'All Minutes', 'rsvpmaker-for-toastmasters' ),
        'search_items'          => __( 'Search Minutes', 'rsvpmaker-for-toastmasters' ),
        'parent_item_colon'     => __( 'Parent Minutes:', 'rsvpmaker-for-toastmasters' ),
        'not_found'             => __( 'No minutes found.', 'rsvpmaker-for-toastmasters' ),
        'not_found_in_trash'    => __( 'No minutes found in Trash.', 'rsvpmaker-for-toastmasters' ),
        'featured_image'        => _x( 'Minutes Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'rsvpmaker-for-toastmasters' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'rsvpmaker-for-toastmasters' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'rsvpmaker-for-toastmasters' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'rsvpmaker-for-toastmasters' ),
        'archives'              => _x( 'Minutes archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'rsvpmaker-for-toastmasters' ),
        'insert_into_item'      => _x( 'Insert into minutes item', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'rsvpmaker-for-toastmasters' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this minutes item', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'rsvpmaker-for-toastmasters' ),
        'filter_items_list'     => _x( 'Filter minutes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'rsvpmaker-for-toastmasters' ),
        'items_list_navigation' => _x( 'Minutess list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'rsvpmaker-for-toastmasters' ),
        'items_list'            => _x( 'Minutess list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'rsvpmaker-for-toastmasters' ),
    );     
    $args = array(
        'labels'             => $labels,
        'description'        => 'Minutes custom post type.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'tm-minutes' ),
        'capability_type'    => 'page',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 3,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
        'taxonomies'         => array( 'minutes-type' ),
		'menu_icon' => 'dashicons-text',
        'show_in_rest'       => true
    );
      
    register_post_type( 'TM Minutes', $args );

		// Add new taxonomy, make it hierarchical (like categories)

		$labels = array(

			'name'              => _x( 'Minutes Types', 'taxonomy general name', 'rsvpmaker' ),
	
			'singular_name'     => _x( 'Minutes Type', 'taxonomy singular name', 'rsvpmaker' ),
	
			'search_items'      => __( 'Search Minutes Types', 'rsvpmaker' ),
	
			'all_items'         => __( 'All Minutes Types', 'rsvpmaker' ),
	
			'parent_item'       => __( 'Parent Minutes Type', 'rsvpmaker' ),
	
			'parent_item_colon' => __( 'Parent Minutes Type:', 'rsvpmaker' ),
	
			'edit_item'         => __( 'Edit Minutes Type', 'rsvpmaker' ),
	
			'update_item'       => __( 'Update Minutes Type', 'rsvpmaker' ),
	
			'add_new_item'      => __( 'Add New Minutes Type', 'rsvpmaker' ),
	
			'new_item_name'     => __( 'New Minutes Type', 'rsvpmaker' ),
	
			'menu_name'         => __( 'Minutes Type', 'rsvpmaker' ),
	
		);
	
		register_taxonomy(
			'minutes-type',
			array( 'tmminutes' ),
			array(
	
				'hierarchical' => true,
	
				'labels'       => $labels,
	
				'show_ui'      => true,
	
				'show_in_rest' => true,
	
				'query_var'    => true,
	
			)
		);
	
}

function profile_richtext() {
	$adminpages = ['member_application_settings','wpt_suggest_all_roles'];
	if ( strpos( $_SERVER['REQUEST_URI'], 'profile.php' ) || strpos( $_SERVER['REQUEST_URI'], 'user-edit.php' ) || (isset($_GET['page']) && in_array($_GET['page'], $adminpages)) ) {
		echo '<script>
tinymce.init({
	selector:"textarea#descriptiontextarea,textarea.mce",plugins: "link",
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
</script>';
	}
}

function speech_intro_data( $user_id, $post_id, $field ) {
	global $rsvp_options;
	if(empty($user_id))
		return '<h1>'.__('Open','rsvpmaker-for-toastmasters').'</h1>';
	if(is_numeric($user_id)) {
		$speaker       = get_userdata( $user_id );
		$speaker_name = $speaker->first_name . ' ' . $speaker->last_name;
	}
	else
		$speaker_name = $user_id;

	$manual        = get_post_meta( $post_id, '_manual' . $field, true );
	$project_index = get_post_meta( $post_id, '_project' . $field, true );
	if ( ! empty( $project_index ) ) {
		$project = get_project_text( $project_index );
		$manual .= ': ' . $project;
	}
	$title = get_post_meta( $post_id, '_title' . $field, true );
	$intro = get_post_meta( $post_id, '_intro' . $field, true );

	$t    = get_rsvpmaker_timestamp( $post_id );
	$date = rsvpmaker_date( $rsvp_options['short_date'], $t );
	$url  = get_permalink( $post_id );

	$message = '<h2>' . $speaker_name . "</h2>\n\n" . $manual;
	if ( ! empty( $title ) ) {
		$message .= "\n\n" . __( 'Title', 'rsvpmaker-for-toastmasters' ) . ': ' . $title;
	}
	if ( ! empty( $intro ) ) {
		$message .= "\n\n" . __( 'Introduction', 'rsvpmaker-for-toastmasters' ) . ': ' . $intro;
	}
	return $message;
}

function toastmost_other_sites() {
	global $current_user;
	if(is_multisite()) {
		$blog_id = get_current_blog_id();
		$blogs    = get_blogs_of_user( $current_user->ID );
		$bloglist = '';
		if ( ! empty( $blogs ) ) {
			foreach ( $blogs as $blog ) {
				if($blog_id != $blog->blog_id)
				$bloglist .= sprintf( '<li><a href="%s">%s</a></li>', $blog->siteurl, $blog->blogname );
			}
		}
	if($bloglist)
	echo "<p>In addition to this site, you are a member of:</p><ul>$bloglist</ul>";
	}	
}

function awesome_dashboard_widget_function() {
	global $rsvp_options;

	$pdir = str_replace( 'rsvpmaker-for-toastmasters/', '', plugin_dir_path( __FILE__ ) );
	if ( ! is_plugin_active( 'rsvpmaker/rsvpmaker.php' ) ) {
		if ( file_exists( $pdir . 'rsvpmaker/rsvpmaker.php' ) ) {
			echo '<div ><p>' . sprintf( __( 'The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker is installed but must be activated. <a href="%s#name">Activate now</a>', 'rsvpmaker-for-toastmasters' ), admin_url( 'plugins.php?s=rsvpmaker' ) ) . "</p></div>\n";
		} else {
			echo '<div><p>' . sprintf( __( 'The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker must be installed and activated. <a href="%s">Install now</a>', 'rsvpmaker-for-toastmasters' ), admin_url( 'plugin-install.php?tab=search&s=rsvpmaker#plugin-filter' ) ) . "</p></div>\n";
		}
		return; // if this is not configured, the rest doesn't matter
	}

	global $current_user;
	global $wpdb;
	$wp4toastmasters_member_message = get_option( 'wp4toastmasters_member_message' );
	if ( ! empty( $wp4toastmasters_member_message ) ) {
		$wp4toastmasters_member_message = wpautop( $wp4toastmasters_member_message );
	}

	?>
<p><?php echo sprintf( __( 'You are viewing the private members-only area of the website. For a basic orientation, see the <a href="%s">welcome page</a>.', 'rsvpmaker-for-toastmasters' ), admin_url( 'index.php?page=toastmasters_welcome' ) ); ?>
<br /></p>
	<?php
	toastmost_other_sites();
	//awesome_dashboard_widget_function();

echo '<p>'.club_member_mailto().'</p>';
	if ( function_exists( 'bp_core_get_userlink' ) ) {
		printf( '<p>%s: %s</p>', __( 'Post a message on your club social profile' ), bp_core_get_userlink( $current_user->ID ) );
	}

	$minutes_docs = get_posts('post_type=tmminutes');
	$minutes_updated = ($minutes_docs) ? 'Updated: '.rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($minutes_docs[0]->post_modified)) : ''; 
	$minutes_archive = get_post_type_archive_link( 'tmminutes' );
	printf('<p><a href="%s">See club minutes</a> (%d on website, %s)</p>',$minutes_archive, sizeof($minutes_docs), $minutes_updated);

	$count = 0;

	$allow_assign = get_option( 'allow_assign' );

	$results = get_future_events( " ( post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%' ) ", 3, OBJECT, 4 );
	if ( $results ) {
		  $upcoming_roles = '';
		foreach ( $results as $index => $row ) {
				$t            = rsvpmaker_strtotime( $row->datetime );
				$title        = $row->post_title . ' ' . rsvpmaker_date( 'F jS', $t );
				$permalink    = rsvpmaker_permalink_query( $row->postID );
				$sql          = "SELECT * FROM `$wpdb->postmeta` where post_id=" . $row->postID . '  AND meta_value=' . $current_user->ID . " AND meta_key LIKE '_role%' ";
				$role_results = $wpdb->get_results( $sql );
				$roles        = array();
				$absences     = get_absences_array( $row->postID );
			if ( in_array( $current_user->ID, $absences ) ) {
				$roles[] = 'planned abscence';
			}
			if ( $role_results ) {
				foreach ( $role_results as $role_row ) {
					$role            = trim( preg_replace( '/[^A-Za-z]/', ' ', $role_row->meta_key ) );
					$roles[]         = $role;
					$upcoming_roles .= sprintf( '<p><a href="%s">%s %s</a></p>', $permalink, $role, $title );
				}
			}
			if ( empty( $roles ) ) {
				$r = 'None';
			} else {
				$r = implode( ', ', $roles );
			}
				$title .= ' (Role: ' . $r . ')';

			if ( strpos( $row->post_content, 'role' ) ) {
				$link = dash_wptmagenda_menu( $row->ID, false );
				printf( '<div class="dashdate" id="dashdate' . $row->ID . '"><p><strong>%s</strong></p> %s</div>', $title, $link );
			}
		}
	}

	printf(
		'<p><a href="%s" target="_blank">%s</a>
<br /></p>',
		site_url( '/?signup2=1' ),
		__( 'Print Signup Sheet', 'rsvpmaker-for-toastmasters' )
	);

	if ( current_user_can( 'edit_signups' ) ) {
		printf( '<p><a href="%s">%s</a></p>', site_url( '?signup_sheet_editor=1' ), __( 'Edit Signups (multiple weeks)', 'rsvpmaker-for-toastmasters' ) );
	}

	$link = get_rsvpmaker_archive_link();
	printf( '<p><a href="%s">%s</a></p>', $link, __( 'View future events' ) );
	printf( '<p><a href="%s">%s</a></p>', admin_url( 'admin.php?page=toastmasters_planner' ), __( 'Sign up for roles on multiple dates using the Role Planner', 'rsvpmaker-for-toastmasters' ) );

	if ( ! empty( $upcoming_roles ) ) {
		printf(
			'<h3>%s</h3>
%s',
			__( 'Upcoming Roles', 'rsvpmaker-for-toastmasters' ),
			$upcoming_roles
		);
	}

	?>
<p><a href="./profile.php#user_login"><?php _e( 'Edit My Member Profile', 'rsvpmaker-for-toastmasters' ); ?></a>
<br /></p>
<!-- p><a href="< ?php echo site_url('/members/'); ?>">Member Directory</a>
<br /></p -->
<p><a href="<?php echo site_url( '/?print_contacts=1' ); ?>" target="_blank"><?php _e( 'Print Contacts List', 'rsvpmaker-for-toastmasters' ); ?></a>
<br /></p>
<p><a href="<?php echo site_url(); ?>"><?php _e( 'Home Page', 'rsvpmaker-for-toastmasters' ); ?></a>
<br /></p>
	<?php
	if ( function_exists( 'get_club_email_lists' ) ) {
		// toastmost specific
		$toastmost_lists = get_club_email_lists();
		if ( ! empty( $toastmost_lists['member'] ) ) {
			printf( '<p>' . __( 'Email all members', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s" target="_blank">%s</a> (' . __( 'for club business or social invitations, no spam please', 'rsvpmaker-for-toastmasters' ) . ')<br /></p>', $toastmost_lists['member'], $toastmost_lists['member'] );
		}
		if ( is_tm_officer() && ! empty( $toastmost_lists['officer'] ) ) {
			printf( '<p>' . __( 'Private email list for officers', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s" target="_blank">%s</a></p>', $toastmost_lists['officer'], $toastmost_lists['officer'] );
		}
	} elseif ( current_user_can( 'email_list' ) && function_exists( 'rsvpmaker_relay_active_lists' ) && $lists = rsvpmaker_relay_active_lists() ) {
		if ( ! empty( $lists['member'] ) ) {
			printf( '<p>' . __( 'Email all members', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s" target="_blank">%s</a> (' . __( 'for club business or social invitations, no spam please', 'rsvpmaker-for-toastmasters' ) . ')<br /></p>', $lists['member'], $lists['member'] );
		}
		if ( ! empty( $lists['officer'] ) && is_officer() ) {
			printf( '<p>' . __( 'Officers email list', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s" target="_blank">%s</a> (' . __( 'for club business or social invitations, no spam please', 'rsvpmaker-for-toastmasters' ) . ')<br /></p>', $lists['officer'], $lists['officer'] );
		}
	} elseif ( current_user_can( 'email_list' ) && function_exists( 'wpt_mailster_get_email' ) && $list_email = wpt_mailster_get_email() ) {
		printf( '<p>' . __( 'Email all members', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s" target="_blank">%s</a> (' . __( 'for club business or social invitations, no spam please', 'rsvpmaker-for-toastmasters' ) . ')<br /></p>', $list_email, $list_email );
	}
    elseif ( current_user_can( 'email_list' ) ) {
		printf( '<p>' . __( 'Email all members', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s?subject=%s" target="_blank">%s</a> (' . __( 'for club business or social invitations, no spam please', 'rsvpmaker-for-toastmasters' ) . ')<br /></p>', wp4t_emails(), get_bloginfo( 'name' ), __( 'Mailing list', 'rsvpmaker-for-toastmasters' ) );
	}

	echo wp_kses_post($wp4toastmasters_member_message);
	?>
<h3>Reports</h3>

<p>This website can be used to track member progress through the Toastmasters program.</p>

	<?php
	printf( '<p><a href="%s">%s</a>', admin_url( 'admin.php?page=my_progress_report' ), __( 'My Progress', 'rsvpmaker-for-toastmasters' ) );

	if ( current_user_can( 'edit_others_posts' ) ) {
		$wp4toastmasters_officer_message = get_option( 'wp4toastmasters_officer_message' );
		if ( ! empty( $wp4toastmasters_officer_message ) ) {
			$wp4toastmasters_officer_message = wpautop( $wp4toastmasters_officer_message );
		}
		?>
<div style="padding: 5px; border:thin solid red">
<p><em>This information is only shown to site editors, administrators, and managers.</em></p>
<p><strong><?php _e( 'Administration', 'rsvpmaker-for-toastmasters' ); ?>:</strong></p>
<p><a href="./users.php?page=add_awesome_member"><?php _e( 'Add Members', 'rsvpmaker-for-toastmasters' ); ?></a>
<br /></p>
<p><a href="./users.php?page=edit_members"><?php _e( 'Edit Members', 'rsvpmaker-for-toastmasters' ); ?></a>
<br /></p>
<p><a href="./users.php?page=wp4t_extended_list"><?php _e( 'Guests/Former Members', 'rsvpmaker-for-toastmasters' ); ?></a>
<br /></p>

		<?php

		$future    = get_future_events();
		$count     = sizeof( $future );
		$args      = array(
			'post_type'   => 'rsvpmaker',
			'post_status' => 'publish',
			'meta_key'    => '_sked_Varies',
		);
		$templates = get_posts( $args );
		if ( $count == 0 ) {

			?>
<h3><?php _e( 'You have no published events based on your club meeting template', 'rsvpmaker-for-toastmasters' ); ?>.</h3>
			<?php
		} elseif ( $count < 10 ) {
			printf( '<p><strong>' . __( 'Future events scheduled', 'rsvpmaker-for-toastmasters' ) . ': %s</strong></p>', $count );
		}

		if ( $templates ) {
			echo '<p><strong>Toastmasters ' . __( 'Event Templates', 'rsvpmaker-for-toastmasters' ) . '</strong></p>';
			foreach ( $templates as $template ) {
				if ( ! is_wp4t( $template->content ) ) {
					continue;
				}
				$permalink = rsvpmaker_permalink_query( $template->ID );
				printf( '<p>%s<br /><a href="%s">%s</a><br /><a href="%s">%s</a>', $template->post_title, add_from_template_url( $template->ID ), __( 'Add Events (based on template)', 'rsvpmaker-for-toastmasters' ), agenda_setup_url( $template->ID ), __( 'Agenda Setup (drag-and-drop editor)', 'rsvpmaker-for-toastmasters' ) );
			}
		}

		echo wp_kses_post($wp4toastmasters_officer_message);

		?>
</div>
		<?php
	} // end editor functions

	$args        = array(
		'post_type'   => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => null, // any parent
	);
	$attachments = get_posts( $args );
	if ( $attachments ) {
		printf( '<h3>%s</h3>', __( 'Member Files', 'rsvpmaker-for-toastmasters' ) );
		if ( current_user_can( 'edit_others_posts' ) ) {
			printf( '<p><em>%s (<a href="%s">%s</a>)</em></p>', __( 'This listing shows all files uploaded to the website, with the exception of images. As an editor or officer, you can hide any of these that should not be displayed to your members.', 'rsvpmaker-for-toastmasters' ), admin_url( '?show_all_files=1' ), __( 'Show all files' ) );
			if ( isset( $_REQUEST['hide_file'] ) ) {
				add_post_meta( sanitize_text_field($_REQUEST['hide_file']), 'hide', 1 );
			}
			if ( isset( $_REQUEST['show_file'] ) ) {
				delete_post_meta( $_REQUEST['show_file'], 'hide' );
			}
		}
		foreach ( $attachments as $post ) {
			$hide = get_post_meta( $post->ID, 'hide', true );
			if ( $hide && ! isset( $_REQUEST['show_all_files'] ) ) {
				continue;
			}

			setup_postdata( $post );
			if ( ! strpos( $post->post_mime_type, 'mage' ) ) {
				echo '<p>';
				the_attachment_link( $post->ID, false );
				if ( current_user_can( 'edit_others_posts' ) ) {
					if ( $hide ) {
						printf( ' | <a href="%s">%s</a>', admin_url( '?show_file=' . $post->ID ), __( 'Show This', 'rsvpmaker-for-toastmasters' ) );
					} else {
						printf( ' | <a href="%s">%s</a>', admin_url( '?hide_file=' . $post->ID ), __( 'Hide This', 'rsvpmaker-for-toastmasters' ) );
					}
					printf( ' | <a href="%s">%s</a>', admin_url( 'post.php?action=edit&post=' . $post->ID ), __( 'Edit', 'rsvpmaker-for-toastmasters' ) );
				}
				echo '</p>';
			}
		}
	}

}

function toastmasters_admin_widget() {
	global $rsvp_options, $menu;
	$publish_posts          = ( current_user_can( 'publish_posts' ) ) ? 'Yes' : 'No';
	$edit_others_posts      = ( current_user_can( 'edit_others_posts' ) ) ? 'Yes' : 'No';
	$publish_rsvpmaker      = ( current_user_can( 'publish_rsvpmakers' ) ) ? 'Yes' : 'No';
	$edit_others_rsvpmakers = ( current_user_can( 'edit_others_rsvpmakers' ) ) ? 'Yes' : 'No';
	$edit_users             = ( current_user_can( 'edit_users' ) ) ? 'Yes' : 'No';
	$blogusers              = get_users( 'blog_id=' . get_current_blog_id() );
	foreach ( $blogusers as $user ) {
		if ( user_can( $user->ID, 'manage_options' ) ) {
			$administrators[] = $user->display_name;
		}
	}
	printf( '<p>Your access level: Publish blog posts <strong>%s</strong>, Edit posts and pages <strong>%s</strong>, Publish events <strong>%s</strong>, Edit events <strong>%s</strong>, Create/edit user accounts <strong>%s</strong>.</p><p>Administrators: %s <a href="https://www.wp4toastmasters.com/knowledge-base/administrators/" target="_blank">Security roles explained</a></p>', $publish_posts, $edit_others_posts, $publish_rsvpmaker, $edit_others_rsvpmakers, $edit_users, implode( ', ', $administrators ) );
	if ( current_user_can( 'edit_others_pages' ) ) {
	$front_page_id = get_option('page_on_front');
	if($front_page_id && current_user_can('edit_post',$front_page_id))
		printf('<p><strong><a href="%s">Edit Home Page</a></strong></p>',admin_url('post.php?action=edit&post='.$front_page_id));
		?>
<p><strong><a href="edit.php?post_type=page">List Pages</a></strong> - pages of your site</p>
<ul>
	 <li><a href="post-new.php?post_type=page">Add New</a> - new page</li>
</ul>
		<?php
	}
	?>
<p><strong><a class="wp-first-item" href="edit.php">Posts</a></strong> - listing of blog posts</p>
<ul>
	 <li><a href="post-new.php">Add New</a> - new blog post (club news or article)</li>
</ul>
<p><strong><a href="edit.php?post_type=rsvpmaker">RSVP Events</a></strong> - list of event posts</p>
<ul>
	 <li><a href="post-new.php?post_type=rsvpmaker">Add New</a> - new event (not from template)</li>
	 <li><a href="edit.php?post_type=rsvpmaker&amp;page=rsvpmaker_template_list">Event Templates</a> - list of event templates for meetings</li>
	 <li><?php echo rsvpmaker_edit_link( $rsvp_options['rsvp_confirm'], 'Default RSVP Confirmation Message' ); ?></li>
	 <li><?php echo rsvpmaker_edit_link( $rsvp_options['rsvp_form'], 'Default RSVP Form' ); ?></li>
	 <li><a href="edit.php?post_type=rsvpemail&amp;page=rsvpmaker_notification_templates">Email Notification/Reminder Templates</a> - settings for automated role reminders, meeting reminders, RSVP confirmations</li>
</ul>
 
	<?php
	if ( current_user_can( 'manage_options' ) ) {
		?>
<p><strong>Appearance</strong></p>
<ul> <?php
if(wp_is_block_theme()) {
	printf('<li><a href="%s">Site Editor</a> - change menus, colors, and layouts of page and post templates. You are using one of the new, highly customizabble "block theme" designs.</li>',admin_url('site-editor.php'));
}
else {
	echo '<li id="menu-posts-rsvpmaker"><a class="hide-if-no-customize" href="customize.php">Customize</a> - tweak website design, including menu at top of the page, page header/banner, background color or image</li>
	<li><a href="widgets.php">Widgets</a> - add/update sidebar widgets</li>
	<li><a href="nav-menus.php">Menus</a> - update menu of pages, other links</li>';
}
?>	 
		<?php
		$layout_id = get_option( 'rsvptoast_agenda_layout' );
		if ( $layout_id ) {
			echo '<li><a href="' . admin_url( 'post.php?action=edit&post=' . $layout_id ) . '">' . __( 'Agenda Layout Editor (Advanced)', 'rsvpmaker-for-toastmasters' ) . '</a> - change the agenda HTML page structure or CSS.</li>';
		}
		?>
</ul>
		<?php
	}
	if ( current_user_can( 'edit_users' ) ) {
		?>
<p><strong><a href="users.php?page=add_awesome_member">Members / Users</strong> - list users/members</p>
<ul>
	 <li><a href="users.php?page=add_awesome_member">Add Members</a> - create user/member accounts</li>
	<li>
		<?php
		$wp4toastmasters_welcome_message = get_option( 'wp4toastmasters_welcome_message' );
		if ( $wp4toastmasters_welcome_message && ( $wpost = get_post( $wp4toastmasters_welcome_message ) ) ) {
			$is_blank = ( $wpost->post_content ) ? '' : '(blank)';
		} else {
			$wp4toastmasters_welcome_message = wp_insert_post(
				array(
					'post_title'  => 'Welcome to ' . get_option( 'blogname' ),
					'post_type'   => 'page',
					'post_status' => 'private',
				)
			);
			update_option( 'wp4toastmasters_welcome_message', $wp4toastmasters_welcome_message );
			$is_blank = '(blank)';
		}
		printf( '%s - edit new member welcome message %s', rsvpmaker_edit_link( $wp4toastmasters_welcome_message, '', true ), $is_blank );
		?>
	</li>
	<li><a href="<?php echo admin_url( 'admin.php?page=wpt_dues_report' ); ?>">Track Dues</a> - shows recent online payments via Stripe and lets you record other payments. Send email reminders to renew. Export data to spreadsheet. Also provides access to application form, Stripe online payments setup</li>
</ul>
		<?php
	}
	if ( current_user_can( 'manage_options' ) ) {
		?>
<p><strong>Settings</strong></p>
<ul>
	 <li><a href="options-general.php?page=wp4toastmasters_settings">Toastmasters</a> - set Officers list, agenda options, security for functions such as Edit Signups</li>
	 <li><a href="options-general.php?page=rsvpmaker_settings">RSVPMaker</a> - options for the calendar and event registration functions</li>
</ul>
		<?php
	}
	if ( function_exists( 'mailster_install' ) ) {
		printf(
			'<p><strong>Mailing List</strong></p>
	<ul>
	<li><a href="%s">Manage Mailster Mailing List</a> - add addresses to whitelist, tweak settings</li>
	<li><a href="%s">Unsubscribe List</a></li>
	</ul>',
			admin_url( 'admin.php?page=mailster_toastmasters' ),
			admin_url( 'edit.php?post_type=rsvpemail&page=unsubscribed_list' )
		);
	}

	global $submenu;
	foreach ($submenu['wpt_email_handler_page'] as $index => $item) {
		if($index) 
			printf('<li><a href="%s">%s</a></li>',admin_url('admin.php?page='.$item[2]),$item[3]);
		else
			printf('<p><strong><a href="%s">%s</a></strong></p><ul>',admin_url('admin.php?page='.$item[2]),$item[3]);
	}
	echo '</ul>';
	foreach ($submenu['toastmasters_admin_help'] as $index => $item) {
		if($index) 
			printf('<li><a href="%s">%s</a></li>',admin_url('admin.php?page='.$item[2]),$item[3]);
		else
			printf('<p><strong><a href="%s">%s</a></strong></p><ul>',admin_url('admin.php?page='.$item[2]),$item[3]);
	}
	echo '</ul>';

	do_action( 'toastmasters_admin_widget_end' );
}

function awesome_add_dashboard_widgets() {
	wp_add_dashboard_widget( 'awesome_dashboard_widget', 'WordPress for Toastmasters Dashboard', 'awesome_dashboard_widget_function' );

	// Globalize the metaboxes array, this holds all the widgets for wp-admin

	global $wp_meta_boxes;

	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );

	// Get the regular dashboard widgets array
	// (which has our new widget already but at the end)

	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

	// Backup and delete our new dashbaord widget from the end of the array

	$awesome_widget_backup = array(
		'awesome_dashboard_widget' =>
				$normal_dashboard['awesome_dashboard_widget'],
	);

	unset( $normal_dashboard['awesome_dashboard_widget'] );

	// Merge the two arrays together so our widget is at the beginning

	$sorted_dashboard = array_merge( $awesome_widget_backup, $normal_dashboard );

	// Save the sorted array back into the original metaboxes

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;

	if (current_user_can('edit_others_rsvpmakers'))  /*( current_user_can( 'edit_others_rsvpmakers' ) ) || current_user_can( 'add_members' ) )*/ {
		$wp_meta_boxes['dashboard']['side']['core'] = array();//remove default widgets
		wp_add_dashboard_widget( 'toastmasters_admin_widget', 'Club Website Administration', 'toastmasters_admin_widget', null, null, 'side','core' );
		/*
		wp_add_dashboard_widget( 'toastmasters_admin_widget', 'Club Website Administration', 'toastmasters_admin_widget' );
		$side_dashboard        = $wp_meta_boxes['dashboard']['side']['core'];
		$normal_dashboard      = $wp_meta_boxes['dashboard']['normal']['core'];
		$sidebar_widget_backup = array(
			'toastmasters_admin_widget' =>
			$normal_dashboard['toastmasters_admin_widget'],
		);
		unset( $wp_meta_boxes['dashboard']['normal']['core']['toastmasters_admin_widget'] );
		$wp_meta_boxes['dashboard']['side']['core'] = array_merge( $sidebar_widget_backup, $side_dashboard );
		*/
	}

	//mail('david@carrcommunications.com','dashboard meta_boxes',var_export($wp_meta_boxes['dashboard'],true));
}

function wpt_timecheck() {
	global $wpt_start;
	if ( empty( $wpt_start ) ) {
		$wpt_start = time();
	}
	$now        = time();
	$difference = $now - $wpt_start;
	// printf('<p>start %s now %s difference %s</p>',$wpt_start,$now,$difference);
	return $difference;
}

function toastmasters_reminder_preview() {
	global $email_context;
	$email_context = true;
	wpt_timecheck();
	$future = get_future_events( " (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ", 1 );
	if ( sizeof( $future ) ) {
		$next = $future[0];
		$content = email_with_without_role('',true);
	} else {
		$content = 'No upcoming meetings found';
	}
	wp_die( $content, 'Preview of Toastmasters reminders' );
}

if ( isset( $_GET['tm_reminders_preview'] ) ) {
	add_action( 'init', 'toastmasters_reminder_preview' );
}

function wp4toast_reminders() {
	if ( ! isset( $_REQUEST['cron_reminder'] ) ) {
		return;
	}
	wpt_timecheck();
	global $wpdb;
	$wp4toast_reminder = get_option( 'wp4toast_reminder' );
	if ( ! $wp4toast_reminder ) {
		die( 'no reminder set' );
	}

	$future = get_future_events( " (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ", 1 );
	if ( sizeof( $future ) ) {
		$next = $future[0];
	} else {
		$next = false;
	}

	if ( ! $next ) {
		die( 'no event scehduled' );
	}

	echo __( 'Next meeting', 'rsvpmaker-for-toastmasters' ) . " $next->datetime <br />";

	$nexttime = $next->datetime;

	$t   = strtotime( $nexttime . ' -' . $wp4toast_reminder );
	$now = current_time( 'timestamp' );
	if ( $now > $t ) {
		echo '<div>' . __( 'Reminder time is past', 'rsvpmaker-for-toastmasters' ) . '</div>';
		$reminder_run = (int) get_option( 'reminder_run' );
		if ( $reminder_run == $t ) {
			echo '<div>' . __( 'Reminder already ran', 'rsvpmaker-for-toastmasters' ) . '</div>';
		} else {
			echo '<div>' . __( 'Run reminder now', 'rsvpmaker-for-toastmasters' ) . ' </div>';
			wp4_speech_prompt( $next, strtotime( $next->datetime ) );
			update_option( 'reminder_run', $t );
		}
	} else {
		echo '<br />' . __( 'Reminder time is NOT past', 'rsvpmaker-for-toastmasters' );
	}

	die();
}

function wpt_open_roles( $atts = array() ) {
	global $post;
	$output = '';
	$open   = array();
	$signup = get_post_custom( $post->ID );
	$data   = wpt_blocks_to_data( $post->post_content, false );
	foreach ( $data as $item ) {
		if ( ! empty( $item['role'] ) ) {
			$role  = $item['role'];
			$count = (int) $item['count'];
			for ( $i = 1; $i <= $count; $i++ ) {
				$field = wp4t_fieldbase($role,$i);
				if ( ! empty( $signup[ $field ][0] ) && ! is_numeric( $signup[ $field ][0] ) ) {
					continue; // might be a guest signup
				}
				if ( empty( $signup[ $field ][0] ) ) {
					if ( isset( $open[ $role ] ) ) {
						$open[ $role ]++;
					} else {
						$open[ $role ] = 1;
					}
				}
			}
		}
	}
	$permalink = get_permalink( $post->ID );

	$openings = 0;
	if ( $open ) {
		$output .= '<h3 class="wpt_open_roles">' . __( 'Open Roles', 'rsvpmaker-for-toastmasters' ) . "</h3>\n<p>";

		foreach ( $open as $role => $count ) {
			$output .= wp4t_role($role);
			if ( $count > 1 ) {
				$output .= ' (' . $count . ')';
			}
			$output   .= "<br />\n";
			$openings += $count;
		}
	}
	$output .= "</p>\n<p>" . __( 'View agenda and sign up at', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . $permalink . '">' . $permalink . "</a></p>\n<p>" . __( 'Forgot your password?', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . site_url( '/wp-login.php?action=lostpassword' ) . '">' . __( 'Reset your password here', 'rsvpmaker-for-toastmasters' ) . '</a></p>';
	return $output;
}


function wp4toast_setup() {
	global $wpdb;
	$wpdb->show_errors();
	$setup = get_option( 'wp4toast_setup' );
	if ( empty( $setup ) ) {
		$success = $total = 0;
		echo '<ul>';
		// AND post_status='publish'
		$total++;
		if ( $wpdb->get_var( "SELECT post_title from $wpdb->posts WHERE post_type='page' AND post_content LIKE '%rsvpmaker_upcoming%' AND post_status='publish' " ) ) {
			echo '<li>(&#10004;) ' . __( 'Calendar page created', 'rsvpmaker-for-toastmasters' ) . '</li>';
			$success++;
		} else {
			echo '<li>(<b>X</b>) ' . __( 'To Do: Create a Calendar page including the shortcode/placeholder', 'rsvpmaker-for-toastmasters' ) . ' [rsvpmaker_upcoming calendar="1"]</li>';
		}

		$total++;
		if ( $wpdb->get_var( "SELECT post_title from $wpdb->posts WHERE post_type='page' AND post_status='publish' AND post_content LIKE '%[awesome_members%' " ) ) {
			echo '<li>(&#10004;) ' . __( 'Member page created', 'rsvpmaker-for-toastmasters' ) . '</li>';
			$success++;
		} else {
			echo '<li>(<b>X</b>) ' . __( 'To Do: Create a Calendar page including the shortcode/placeholder', 'rsvpmaker-for-toastmasters' ) . ' [awesome_members]</li>';
		}
		echo '<li>';

		$total++;
		$args      = array(
			'post_type'   => 'rsvpmaker',
			'post_status' => 'publish',
			'meta_key'    => '_sked_Varies',
		);
		$templates = get_posts( $args );
		$tcount    = sizeof( $templates );
		if ( $tcount ) {
			echo '(&#10004;) ' . __( 'Templates created', 'rsvpmaker-for-toastmasters' ) . " ($tcount)";
			$success++;
		} else {
			echo '(<b>X</b>) ' . __( 'To Do', 'rsvpmaker-for-toastmasters' ) . ': ' . '<a href="' . admin_url( 'edit.php?post_type=rsvpmaker&page=role_setup' ) . '">' . __( 'Create an event template for your regular meetings', 'rsvpmaker-for-toastmasters' ) . '</a>.';
		}

		echo '</li>';

		$total++;
		$users = get_users();
		$count = sizeof( $users );
		if ( $count > 5 ) {
			echo '<li>(&#10004;) ' . __( 'Members imported', 'rsvpmaker-for-toastmasters' ) . ": $count</li>";
			$success++;
		} else {
			echo '<li>(<b>X</b>) ' . __( 'To Do: Import members. Current members:', 'rsvpmaker-for-toastmasters' ) . ' $count). <a href="' . admin_url( 'users.php?page=add_awesome_member' ) . '">' . __( 'See add members screen', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
		}

		$total++;
		$officers = get_option( 'wp4toastmasters_officer_ids' );
		if ( is_array( $officers ) ) {
			echo '<li>(&#10004;) ' . __( 'Officer list recorded', 'rsvpmaker-for-toastmasters' ) . '</li>';
			$success++;
		} else {
			echo '<li>(<b>X</b>) ' . __( 'To Do', 'rsvpmaker-for-toastmasters' ) . ': <a href="' . admin_url( 'options-general.php?page=wp4toastmasters_settings' ) . '">' . __( 'Record list of officers on settings screen', 'rsvpmaker-for-toastmasters' ) . '</a>.</li>';
		}

		echo '</ul>';
		echo "<p>$success of $total </p>";
	}
}

function editable_note( $atts ) {
	//if(wp_is_json_request())
		//return summarize_agenda_times($atts);
	$atts['agenda_display'] = 'both';
	return agenda_note( $atts );
}

function agenda_note( $atts, $content = '' ) {
	if ( isset( $_GET['convert'] ) ) {
		return agenda_note_convert( $atts, $content );
	}

	if ( isset( $_REQUEST['reorder'] ) ) {
		return; // not needed in this context
	}
	global $post;
	global $rsvp_options;
	$output  = '';
	$display = isset( $atts['agenda_display'] ) ? $atts['agenda_display'] : 'agenda';

	if ( isset( $_REQUEST['page'] ) && ( $_REQUEST['page'] == 'agenda_timing' ) ) {
		return timeplanner( $atts, $content );
	}

	if ( isset( $_REQUEST['word_agenda'] ) && $_REQUEST['word_agenda'] ) {
		$atts['style'] = '';
		$atts['sep']   = ' ';
	}

	if ( ! empty( $atts['officers'] ) ) {
		$content .= toastmaster_officers( $atts );
	}

	$style = ( isset( $atts['style'] ) ) ? $atts['style'] . ';' : '';
	if ( ! empty( $atts['strong'] ) ) {
		$style .= 'font-weight: bold;';
	}
	if ( ! empty( $atts['italic'] ) ) {
		$style .= 'font-style: italic;';
	}
	if ( ! empty( $atts['size'] ) ) {
		$style .= 'font-size: ' . $atts['size'] . ';';
	}

	if ( ! empty( $style ) ) {
		$style = 'style="' . $style . '"';
	}

	if ( ! empty( $atts['alink'] ) && ( $url = esc_url( $atts['alink'] ) ) ) {
		$content .= ' <a href="' . $url . '">' . $url . '</a>';
	}

	if ( ! empty( $atts['editable'] ) ) {
		if ( isset( $atts['uid'] ) ) {
			$editid   = 'agenda_note_' . $atts['uid'];
			$editable = get_post_meta( $post->ID, $editid, true );
			if ( empty( $editable ) ) {
				$editable = get_post_meta( $post->ID, 'agenda_note_' . $atts['editable'], true );
			}
		} else {
			$editid   = 'agenda_note_' . $atts['editable'];
			$editable = trim( get_post_meta( $post->ID, 'agenda_note_' . $atts['editable'], true ) );
		}

		$slug = preg_replace( '/[^a-zA-Z_]/', '', $editid );

		if ( rsvpmaker_is_template() ) {
			$editable .= '<p>Editable note block will appear here</p>';
		} elseif ( is_club_member() && is_edit_roles() ) {
			$editable = '<div class="agenda_note_editable"><textarea class="mce" name="agenda_note[]" rows="5" cols="80" class="mce">' . $editable . '</textarea><input type="hidden" name="agenda_note_label[]" value="' . $editid . '" /></div>';
			$display  = 'both';
		} elseif ( empty( $editable ) ) {
			$editable = '';
		}
		if ( is_single() && is_club_member() && ! isset( $_REQUEST['edit_roles'] ) && ! isset( $_REQUEST['recommend_roles'] ) && ( current_user_can( 'edit_signups' ) || edit_signups_role() ) && ! isset( $_REQUEST['print_agenda'] ) && ! is_email_context() ) {
			$permalink     = get_permalink( $post->ID ) . '#' . $slug;
			$edit_editable = '<div class="agenda_note_editable_editone_wrapper"><a class="agenda_note_editable_editone_on">Edit</a></div><form method="post" action="' . $permalink . '" class="agenda_note_editable_editone"><div class="agenda_note_editable"><textarea name="agenda_note[]" rows="5" cols="80" class="mce">' . $editable . '</textarea><input type="hidden" name="agenda_note_label[]" value="' . $editid . '" /></div><button>Update</button><input type="hidden" name="post_id" value="' . intval($post->ID) . '" />'.rsvpmaker_nonce('return').' </form>';
		} else {
			$edit_editable = '';
		}
		$maxtime   = ( ! empty( $atts['time_allowed'] ) ) ? $atts['time_allowed'] : '';
		$timeblock = ( $maxtime ) ? '<span class="time_allowed" maxtime="' . $maxtime . '"></span>' : '<span class="notime"></span>';

		if ( ! empty( $editable ) ) {
			$editable = wpautop( $editable );
		}
		if ( ! empty( $atts['inline'] ) ) {
			$content .= '<p id="' . $slug . '" class="editable_content">' . $timeblock . '<strong>' . $atts['editable'] . '</strong> ' . $editable . '</p>' . $edit_editable;
		} else {
			$content .= $timeblock . '<h3 id="' . $slug . '">' . $atts['editable'] . '</h3><p class="editable_content">' . $editable . '</p>' . $edit_editable;
		}
		return force_balance_tags($content);
	}

	$maxtime = ( ! empty( $atts['time_allowed'] ) ) ? $atts['time_allowed'] : '';

	$timeblock = ( $maxtime ) ? '<span class="time_allowed" maxtime="' . $maxtime . '"></span>' : '<span class="notime"></span>';

	if ( isset( $_REQUEST['print_agenda'] ) || isset( $_REQUEST['email_agenda'] ) ) {
		if ( $display != 'web' ) {
			$output = '<p class="agenda_note" ' . $style . '>' . $timeblock . trim( $content ) . '</p>';
		}
	} elseif ( ( $display == 'web' ) || ( $display == 'both' ) ) {
		$output = '<p class="agenda_note" ' . $style . '>' . trim( $content ) . '</p>';
	} else {
		$output = '';
	}

	if ( isset( $_GET['debug'] ) ) {
		$output .= var_export( $atts, true );
	}

	return $output;
}

function agenda_timing_footer( $datestring ) {
	?>
<input type="hidden" id="start_time" value="<?php echo esc_html($datestring); ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
jQuery(document).ready(function($) {
var time_tally;

var agenda_add_minutes =  function (dt, minutes) {
	return new Date(dt.getTime() + minutes*60000);
}

var agenda_time_tally = function () {
	time_tally = new Date($('#start_time').val());//start time
	$('.timeblock').each(function(index) {
	 var addminutes = $(this).attr('maxtime');
		  var hour = time_tally.getHours();
		var minute = time_tally.getMinutes();
		hour = (hour >= 12)? hour - 12: hour;
		if(minute < 10)
		minute = '0' + minute;
	var tallyadd = 0;
	var addthis = Number(addminutes);
	if(isNaN(addthis) || isNaN(hour) || isNaN(minute))
		return;
	tallyadd += addthis;
	if(tallyadd) {
	time_tally = agenda_add_minutes(time_tally,tallyadd);
	$(this).html(hour + ":" + minute);		
	}
	});
}

agenda_time_tally();

});

</script>
	<?php
}


function get_role_signups( $post_id, $role, $count ) {
	$field_base = 'role_'.preg_replace( '/[^a-zA-Z0-9]/', '_', $role );
	$volunteers = array();
	for ( $i = 1; $i <= $count; $i++ ) {
		$field    = '_' . $field_base . '_' . $i;
		$assigned = get_post_meta( $post_id, $field, true );
		if ( $assigned == '-1' ) {
			continue;
		} elseif ( $assigned ) {
			if ( is_numeric( $assigned ) ) {
				$member     = get_userdata( $assigned );
				$assignedto = ( isset( $member->first_name ) && isset( $member->first_name ) ) ? $member->first_name . ' ' . $member->last_name : __( 'member name not found', 'rsvpmaker-for-toastmasters' );
				if ( ! empty( $member->education_awards ) ) {
					$assignedto .= ', ' . $member->education_awards;
				}
			} else {
				$assignedto = $assigned . ' (guest)';
			}
				$volunteers[] = $assignedto;
		}
	}
	return implode( ', ', $volunteers );
}

function speaker_details_agenda( $field, $assigned ) {
	global $post;
	$output  = '';
	$speaker = get_speaker_array_by_field( $field, $assigned, $post->ID );
	$manual  = '<span class="manual">' . $speaker['manual'] . '</span>';
	if ( ! empty( $speaker['project'] ) ) {
		$project  = get_project_text( $speaker['project'] );
		$project .= evaluation_form_link( $assigned, $post->ID, $speaker['project'] );
		$dt       = get_post_meta( $post->ID, '_display_time' . $field, true );
		if ( empty( $dt ) ) {
			$timing = get_projects_array( 'display_times' );
			$dt     = ( isset( $timing[ $project_index ] ) ) ? $timing[ $project_index ] : '';
		}
		$dt      = apply_filters( 'agenda_time_display', $dt );
		$manual .= ': <span class="project">' . $project . '</span>';
	} else {
		$manual .= evaluation_form_link( $assigned, $post->ID, '' );
	}

	$title   = ( empty( $speaker['title'] ) ) ? '' : '<span class="title">&quot;' . $speaker['title'] . '&quot;</span> ';
	$output .= '<div>' . $title . '<span class="manual-project">' . $manual . '</span></div>';
	if ( ! empty( $dt ) ) {
		$output .= '<p class="speechtime">' . $dt . '</p>';
	}
	if ( ! empty( $speaker['intro'] ) && ( isset( $_GET['showintros'] ) || get_option( 'wp4toastmasters_intros_on_agenda' ) ) ) {
		$output .= '<p class="intro">' . wpautop( '<strong>' . __( 'Introduction', 'rsvpmaker-for-toastmasters' ) . ':</strong> ' . $speaker['intro'] ) . '</p>';
	}

	$output = apply_filters( 'speaker_details_agenda', $output, $field );
	$output = "\n" . '<div class="speaker-details">' . $output . '</div>' . "\n";
	return $output;
}

function toastmasters_agenda_display( $atts, $assignments ) {
	global $post, $open;
	$field = $output = $startdiv = '';
	if ( function_exists( 'toastmasters_agenda_display_custom' ) ) {
		return toastmasters_agenda_display_custom( $atts, $assignments );
	}
	$output = apply_filters( 'toastmasters_agenda_role_display', $output, $atts, $assignments );
	if ( ! empty( $output ) ) {
		return $output;
	}

		$count = ( empty( $atts['count'] ) ) ? 1 : $atts['count'];
		$start = ( empty( $atts['start'] ) ) ? 1 : $atts['start'];

		$maxtime      = ( isset( $atts['time_allowed'] ) ) ? (int) $atts['time_allowed'] : 0;
		$padding_time = ( isset( $atts['padding_time'] ) ) ? (int) $atts['padding_time'] : 0;
		$speaktime    = 0;
	foreach ( $assignments as $field => $values ) {
		$role = $values['role'];
		$assigned   = $values['assigned'];
		$assignedto = $values['name'];
		$i          = $values['iteration'];
		$className  = ( isset( $atts['className'] ) ) ? $atts['className'] : '';
		if ( isset( $atts['indent'] ) && $atts['indent'] ) {
			$className .= ' indent';
		}
		$output .= "\n" . '<div class="role-agenda-item ' . $className . '">';
		if ( ! empty( $atts['time_allowed'] ) && strpos( $field, 'Speaker' ) && ! strpos( $field, 'Backup' ) ) {
				$speaktime += (int) get_post_meta( $post->ID, '_maxtime' . $field, true );
		}
		if ( ( $i == $start ) && ! strpos( $field, 'Backup' ) ) {
			$output .= 'TIMEBLOCKHERE';
		} else {
			$output .= '<span class="notime"></span>';
		}
		$output .= '<span class="role">' . wp4t_role_display ($role);
		if ( ( $count > 1 ) || ( $i > 1 ) ) {
			$output .= ' <span class="role_number">' . $i . '</span>';
		}
		if ( ! empty( $atts['evaluates'] ) ) {
			if ( ( ( strpos( $field, 'Evaluator' ) ) ) && ( $field != '_role_General_Evaluator_1' ) ) {
				$speechfield               = '_role_Speaker_' . $i;
				$speakerID_to_be_evaluated = get_post_meta( $post->ID, $speechfield, true );
				$user_info                 = get_userdata( $speakerID_to_be_evaluated );
				$speaker_to_be_evaluated   = $user_info->first_name . ' ' . $user_info->last_name;
				$output                   .= '<span class = "evaluates"> evaluates ' . $speaker_to_be_evaluated . '</span>';
			}
		}
		$output .= '</span>';
		$output .= ' <span class="member-role">';
		$output .= $assignedto;
		$output .= '</span></div>';
		if ( empty( $assigned ) ) {
			if ( isset( $open[ $atts['role'] ] ) ) {
				$open[ $atts['role'] ]++;
			} else {
				$open[ $atts['role'] ] = 1;
			}
		}
		if ( $assigned && ( strpos( $field, 'Speaker' ) == 1 ) ) {
			$output .= speaker_details_agenda( $field, $assigned );
		}
		if ( isset( $atts['agenda_note'] ) && ! empty( $atts['agenda_note'] ) && strpos( $atts['agenda_note'], 'Speaker}' ) ) {
			$speakerID_to_be_evaluated = get_post_meta( $post->ID, '_role_Speaker_' . $i, true );
			if ( $speakerID_to_be_evaluated > 0 ) {
				$note = str_replace( '{Speaker}', get_member_name( $speaker_to_be_evaluated ), $atts['agenda_note'] );
			} else {
				$note = str_replace( '{Speaker}', '?', $atts['agenda_note'] );
			}
			$output .= '<div class="role_agenda_note">' . $note . '</div>';
		}
	}//end for loop
	if(!empty($atts['backup']) && !empty($open[ $atts['role'] ]))
		$open[ $atts['role'] ]--;

	if ( isset( $atts['agenda_note'] ) && ! empty( $atts['agenda_note'] ) && ! strpos( $atts['agenda_note'], 'Speaker}' ) ) {
		$note    = $atts['agenda_note'];
		$output .= '<div class="role_agenda_note">' . $note . '</div>';
	}
	if ( ( strpos( $field, 'Evaluator' ) == 1 ) && get_option( 'wp4toastmasters_stoplight' ) ) {
		$output .= '<div class="role-timing">Each evaluator ' . get_stoplight( 2, 3 ) . '</div>';
	}
	if ( ( strpos( $field, 'Topics_Master' ) == 1 ) && get_option( 'wp4toastmasters_stoplight' ) ) {
		$output .= '<div class="role-timing">Each Table Topics Speaker ' . get_stoplight( 1, 2 ) . '</div>';
	}
		$output = apply_filters( 'agenda_role_bottom', $output, $field );
	if ( $speaktime > $maxtime ) {
		$maxtime = $speaktime;
	}
		$start_end = '';
	if ( $padding_time ) {
		$maxtime += $padding_time;
	}
		$timeblock = '<span class="time_allowed" maxtime="' . $maxtime . '"></span>';
	if ( $maxtime ) {
		$output = str_replace( 'TIMEBLOCKHERE', $timeblock, $output );
	} else {
		$output = str_replace( 'TIMEBLOCKHERE', '<span class="notime"></span>', $output );
	}
	if ( isset( $_REQUEST['word_agenda'] ) ) { // word doesn't handle the list numbering well
		$output = preg_replace( '/(<\/ul>|<\/li>|<ul>|<li>)/', '', $output );
	}
	return $output;
}

function wp4t_reconcile_roleblock( $atts ) {
	global $tmroles, $post, $wpdb;
	$history_table = $wpdb->base_prefix.'tm_history';
	$speech_history_table = $wpdb->base_prefix.'tm_speech_history';
	$output = '';
	$role = $atts['role'];

	$start = ( empty( $atts['start'] ) ) ? 1 : $atts['start'];
	$field_base = 'role_'.preg_replace( '/[^a-zA-Z0-9]/', '_', $atts['role'] );
	$count = (int) ( isset( $atts['count'] ) ) ? $atts['count'] : 1;
	for ( $i = $start; $i < ( $count + $start ); $i++ ) {
		$sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id WHERE post_id=$post->ID AND role='$role' AND rolecount=$i ";
		$row = $wpdb->get_row($sql);
		if(empty($row))
			$row = (object)['user_id' => 0, 'manual'=>'','project_key'=>'','project'=>'','title' => ''];
		$field = $field_base.'_'.$i;
		$detailsform = ($role == 'Speaker') ?  speaker_details_history($post->ID, $field, $row ) : '';
		$awe_user_dropdown = awe_user_dropdown( $field, $row->user_id );
		$output .= sprintf('<div><h3>%s</h3><div> %s %s </div></div>',$role,$awe_user_dropdown,$detailsform);
	}

	return $output;
}

function toastmaster_short( $atts = array(), $content = '' ) {
	if(empty($atts['role']) && wp_is_json_request())
		return __('Select a role or specify a custom role using the editor sidebar. If the sidebar is not displayed, click the gear icon in the upper right corner of the screen','rsvpmaker-for-toastmasters');

	if ( isset( $_GET['convert'] ) ) {
		return toastmaster_short_convert( $atts );
	}
	global $tmroles, $post, $current_user, $open, $role_counter;
	$assigned = 0;
	if ( isset( $_REQUEST['page'] ) && ( $_REQUEST['page'] == 'agenda_timing' ) ) {
		return timeplanner( $atts, $content );
	}
	elseif ( isset( $_REQUEST['page'] ) && ( $_REQUEST['page'] == 'toastmasters_reconcile' ) ) {
		return wp4t_reconcile_roleblock( $atts );
	} elseif ( ! empty( $content ) ) {
		return agenda_note( $atts, $content );
	} elseif ( isset( $atts['themewords'] ) ) {
		return themewords( $atts );
	} elseif ( isset( $atts['officers'] ) ) {
		return toastmaster_officers( $atts );
	} elseif ( isset( $atts['special'] ) ) {
		return '<div class="role-block role-agenda-item"><p><strong>' . $atts['special'] . '</strong></p></div>';
	} elseif ( empty( $atts['role'] ) ) {
		return;
	}
	if ( isset( $atts['role'] ) ) {
		$atts['role'] = trim( $atts['role'] );
	}
	if ( ( $atts['role'] == 'custom' ) ) {
		if ( empty( $atts['custom_role'] ) ) {
			$atts['role'] = 'Custom role undefined';
		} else {
			$atts['role'] = $atts['custom_role'];
		}
	}

	$backup     = $output = '';
	$field_base = 'role_'.preg_replace( '/[^a-zA-Z0-9]/', '_', $atts['role'] );

	$assignments = get_role_assignments( $post->ID, $atts );
	$permalink   = rsvpmaker_permalink_query( $post->ID );

	if ( isset( $_REQUEST['reorder'] ) ) {
		if ( empty($atts['count']) || 1 == $atts['count'] ) {
			return;
		}
		$output .= '<input type="hidden" id="_' . $field_base . 'post_id" value="' . $post->ID . '">';
		$output .= '<h3>' . $atts['role'] . '</h3><ul id="' . $field_base . '" class="tmsortable sortable">';
		foreach ( $assignments as $field => $values ) {
			$role       = $values['role'];
			$assigned   = $values['assigned'];
			$assignedto = $values['name'];
			$output    .= '<li class="sortableitem sortable_' . $field_base . '" id="' . $field . '" >' . $assignedto . '<input type="hidden" id="' . $field . '_assigned" value="' . $assigned . '"></li>';
		}
		$output .= '<li><div id="' . $field_base . '_sortresult" class="sortresult">' . __( 'Drag and drop assignments into the desired agenda order', 'rsvpmaker-for-toastmasters' ) . '</div></li></ul>';
		return $output . $backup;
	}
	// need to know what role to look up for notifications
	if ( isset( $atts['leader'] ) ) {
		update_post_meta( $post->ID, 'meeting_leader', '_' . $field_base . '_1' );
	}

	if ( isset( $_GET['print_agenda'] ) && strpos( $field_base, 'ackup' ) && ( $assigned < 1 ) ) {
		return; // don't need to output empty backup speaker slot on agenda
	}
	if ( isset( $_REQUEST['signup2'] ) ) {
		foreach ( $assignments as $field => $values ) {
			$role       = $values['role'];
			$assigned   = $values['assigned'];
			$assignedto = $values['name'];
			if ( $assignedto == 'Open' ) {
				$assignedto = '&nbsp;';
			}
			$output .= "\n" . '<div class="signuprole">' . $role . '<div class="assignedto">' . $assignedto . '</div></div>';
		}
		return $output . $backup;
	}
	if(wp_is_json_request())
		return toastmasters_agenda_display( $atts, $assignments );
	if( wp4t_hour_past($post->ID)) {
		return toastmasters_agenda_display( $atts, $assignments );
	}
	if ( ! is_edit_roles() && ( ( isset( $_REQUEST['print_agenda'] ) || is_email_context() || is_agenda_locked() ) ) ) {
		return toastmasters_agenda_display( $atts, $assignments );
	}

	if(strpos($post->post_content,'wp:wp4toastmasters/toastmasters-dynamic-agenda'))
		return;

	global $random_available;
	global $last_attended;
	global $last_filled;

	$output .= wp_nonce_field( 'wpt_role_update', 'tmn', true, false );
	foreach ( $assignments as $field => $values ) {
		$role       = $values['role'];
		$assigned   = $values['assigned'];
		$assignedto = $values['name'];
		if ( is_numeric( $assigned ) && ( $assigned > 0 ) ) {
			$tmroles[ $field ] = $assigned;
		}
		$output .= '<div class="role-block" id="' . $field . '"><div class="role-title" style="font-weight: bold;">';
		$output .= wp4t_role_display ($role) . ': </div><div class="role-data"> ';
		$ajaxclass = 'toastrole'; 
		if ( is_club_member() && ! ( is_edit_roles() || isset( $_REQUEST['recommend_roles'] ) ) ) {
			$output .= sprintf( ' <form id="%s_form" method="post" class="%s" action="%s" style="display: inline;"><input type="hidden" name="user_id" value="%d" /> <input type="hidden" name="role" value="%s"><input type="hidden" name="post_id" value="%d">', $field, $ajaxclass, $permalink, $current_user->ID, $field, $post->ID ).rsvpmaker_nonce('return');
		}
		$output .= '<div class="member-role">' . $assignedto . '</div>';

		if ( is_club_member() ) {
			if ( strpos( $field, 'Speaker' ) && ( $assigned != '-1' ) ) {
				$detailsform = speaker_details( $field, $atts );
			} else {
				$detailsform = '';
			}
			$random_available = random_available_check();
			if ( isset( $_GET['debug'] ) ) {
				echo 'random check</br>';
				print_r( $random_available );
			}
			if ( is_edit_roles() && ( current_user_can( 'edit_signups' ) || edit_signups_role() ) ) {
					$assign_ok = get_user_meta( $current_user->ID, 'assign_okay', true );
				if ( empty( $assign_ok ) || ( $assign_ok < time() ) ) {
					$output .= '<div>Suggested assignments not enabled</div>';
				} elseif ( ( empty( $assigned ) || ( $assigned == 0 ) ) && is_array( $random_available ) && ! empty( $random_available ) ) {
					$role     = preg_replace( '/[0-9]/', '', $field );// remove number
					$assigned = pick_random_member( $role );
					$output  .= '<em><span style="color:red;">' . __( 'Suggested assignment (unconfirmed)', 'rsvpmaker-for-toastmasters' ) . '</span><br />' . __( 'Last attended', 'rsvpmaker-for-toastmasters' ) . ': ' . $last_attended[ $assigned ] . ' ' . __( 'Last filled role', 'rsvpmaker-for-toastmasters' ) . ': ' . $last_filled[ $role ][ $assigned ] . '</em><br />';
				}
					// editor admin options
					$awe_user_dropdown = awe_user_dropdown( $field, $assigned );
					$output           .= 'Member: ' . $awe_user_dropdown;
					$guest             = ( is_numeric( $assigned ) ) ? '' : $assigned;
					$output .= '<br /><input type="checkbox" name="edit_default[' . $field . ']" value="1" /> '.__('Apply to all upcoming meetings','rsvpmaker-for-toastmasters');
					$output           .= '<br />'.__('Or guest','rsvpmaker-for-toastmasters').': <input type="text" name="edit_guest[' . $field . ']" value="' . $guest . '" />';
				if ( strpos( $field, 'Speaker' ) ) {
					$output .= $detailsform;
				}
			} elseif ( isset( $_REQUEST['recommend_roles'] ) && ( current_user_can( 'edit_roles' ) || edit_signups_role() ) ) { // && current_user_can('edit_posts') )
				// editor admin options
				if ( ! $assigned ) {
					$random_assigned = null;
					if ( is_array( $random_available ) && ! empty( $random_available ) ) {
						$role     = preg_replace( '/[0-9]/', '', $field );// remove number
						$assigned = pick_random_member( $role );
						$output  .= '<em><span style="color:red;">' . __( 'Suggested assignment (unconfirmed)', 'rsvpmaker-for-toastmasters' ) . '</span><br />' . __( 'Last attended', 'rsvpmaker-for-toastmasters' ) . ': ' . $last_attended[ $assigned ] . ' ' . __( 'Last filled role', 'rsvpmaker-for-toastmasters' ) . ': ' . $last_filled[ $role ][ $assigned ] . '</em><br />';
					}
					$awe_user_dropdown = awe_assign_dropdown( $field, $assigned );
					$output           .= $awe_user_dropdown;
					$output           .= sprintf( '<p>%s:<br /><textarea rows="3" cols="40" name="editor_suggest_note[%s]" class="mce"></textarea><br /><input type="checkbox" name="ccme" value="1" /> Send me a copy</p><input type="hidden" name="editor_suggest_count[%s]" value="%s" />', __( 'Add a personal note (optional)', 'rsvpmaker-for-toastmasters' ), $field, $field, $count );
				}
			} elseif ( ! $assigned ) {
				if ( rsvpmaker_is_template() ) {
					$output .= '('.__('Take Role button appears here','rsvpmaker-for-toastmasters').')';
				} elseif ( strpos( $field, 'Speaker' ) ) {
					$points = get_speech_points( $current_user->ID );
					$rules  = get_option( 'toastmasters_rules' );
					if ( ( $points < 0 ) && ! empty( $rules['points'] ) ) {
						global $points_warning;
						// $makeup = abs($points);
						if ( $rules['points'] == 'prevent' ) {
							if ( ! $points_warning ) {
								$output        .= '<p><strong>'.__('Based on the points system we use, you are at','rsvpmaker-for-toastmasters').' <span style="color: red">' . $points . '</span></strong></p><p>'.__('Take Role','rsvpmaker-for-toastmasters').'</p>';
								$points_warning = true;
							}
						} else {
							if ( ! $points_warning ) {
								$output        .= '<p><strong>'.__('Based on the points system we use, you are at','rsvpmaker-for-toastmasters').' <span style="color: red">' . $points . '</span></p>'.__('Please sign up for other supporting roles (if not for this meeting, then soon) to balance out your participation in the club.','rsvpmaker-for-toastmasters').'</p>';
								$points_warning = true;
							}
								$output .= sprintf( '<div class="update_form" id="update' . $field . '">%s</div>', $detailsform );
								$output .= '<button name="take_role" id="take_role' . $field . '" value="1">'.__('Take Role','rsvpmaker-for-toastmasters').'</button>';

						}
					} else {
							$output .= sprintf( '<div class="update_form" id="update' . $field . '">%s</div>', $detailsform );
							if(strpos($post->post_content,'tm_attend_in_person') || strpos($post->post_content,'wp4toastmasters/hybrid')) 
								$output .= tm_in_person_checkbox();
							$output .= '<button name="take_role" id="take_role' . $field . '" value="1">'.__('Take Role','rsvpmaker-for-toastmasters').'</button>';
					}
				} else {
					if(strpos($post->post_content,'tm_attend_in_person') || strpos($post->post_content,'wp4toastmasters/hybrid')) 
						$output .= tm_in_person_checkbox();	
					$output .= '<button name="take_role" id="take_role' . $field . '" value="1">'.__('Take Role','rsvpmaker-for-toastmasters').'</button>';
						$last    = last_filled_role( $current_user->ID, $field );
						$output .= (isset($last['text'])) ? $last['text'] : '';
				}
			} elseif ( $assigned == $current_user->ID ) {
				if ( strpos( $field, 'Speaker' ) ) {
					$in_person = (strpos($post->post_content,'tm_attend_in_person') || strpos($post->post_content,'wp4toastmasters/hybrid')) ? tm_in_person_checkbox() : '';	
					$output .= sprintf(
						'<div class="update_form" id="update' . $field . '">%s %s 
					<button name="update_role" value="1">' . __( 'Update Role', 'rsvpmaker-for-toastmasters' ) . '</button>
					<br />
					<em>or</em>
					</div><div></div>',
						$detailsform, $in_person
					);
				}
			} elseif ( strpos( $field, 'Speaker' ) && ( $assigned != '-1' ) ) {
				$output .= '<div class="update_form" id="update' . $field . '">' . speech_public_details( $field, $assigned ) . '</div>';
			}

			if ( is_single() && strpos( $field, 'Speaker' ) && ! strpos( $field, 'Backup' ) ) {
				$output .= '<div class="time_message"></div> ';
			}
		}

		if ( isset( $atts['agenda_note'] ) && ! empty( $atts['agenda_note'] ) ) {
			$note = $atts['agenda_note'];
			if ( strpos( $note, '{Speaker}' ) ) {
				$speaker_id = get_post_meta( $post->ID, '_role_Speaker_' . $i, true );
				if ( empty( $speaker_id ) ) {
					$speaker_name = '?';
				}
				$speaker_name = get_member_name( $speaker_id );
				$note         = str_replace( '{Speaker}', $speaker_name, $note );
			}
			$output .= '<div><em>' . $note . '</em></div>';
		}

		if ( is_club_member() && ! ( isset( $_REQUEST['edit_roles'] ) || isset( $_REQUEST['recommend_roles'] ) || ( isset( $_REQUEST['page'] ) && ( $_REQUEST['page'] == 'toastmasters_reconcile' ) ) ) ) {
			$output .= rsvpmaker_nonce('return').'</form>';
			if ( $assigned == $current_user->ID ) {
				$output .= sprintf( '<form id="remove%s_form" method="post" class="remove_me_form" action="%s" style="display: inline;"><input type="hidden" name="user_id" value="%d" /> <input type="hidden" name="remove_role" id="remove_role%s" value="%s"><input type="hidden" name="post_id" class="post_id" value="%d">', $field, $permalink, $current_user->ID, $field, $field, $post->ID ) . '<button name="delete_role" id="delete_role' . esc_attr($field) . '" value="1">' . __( 'Remove Me', 'rsvpmaker-for-toastmasters' ) . '</button>'.rsvpmaker_nonce('return').'</form>';
			}
			// hidden edit field
			if ( is_single() && current_user_can( 'edit_signups' ) ) {
				$awe_user_dropdown = awe_user_dropdown( $field, $assigned );
				$editone           = 'Member: ' . $awe_user_dropdown;
				$editone .= '<br /><input type="checkbox" name="edit_default[' . $field . ']" value="1" /> '.__('Apply to all upcoming meetings','rsvpmaker-for-toastmasters');
				$guest             = is_numeric( $assigned ) ? '' : $assigned;
				$editone          .= sprintf( '<br />'.__('Or guest','rsvpmaker-for-toastmasters').': <input id="%d_edit_guest%s" name="guest" value="%s">', $post->ID, $field, esc_attr( $guest ) );
				if ( strpos( $field, 'Speaker' ) ) {
					$editone .= str_replace( 'speaker_details maxtime', 'speaker_details', str_replace( 'id="', 'id="editone', $detailsform ) );
				}
				if($assigned == 0)
					$output .= sprintf( '<div id="edito newrapper%s" class="editone_wrapper" ><a class="editonelink" editone="%s">Edit</a> or <a class="suggestonelink" editone="%s">Suggest</a></div><form id="editone%s" method="post" class="edit_one_form" action="%s" style="display: block;"><div id="suggest%s"></div><input type="hidden" name="post_id" value="%d"><input type="hidden" name="role" value="%s"><div>%s</div>', $field, $field, $field, $field, $permalink, $field, $post->ID, $field, $editone ) . '<button name="edit_one" id="edit_one_button' . esc_attr($field) . '" value="1">' . __( 'Submit', 'rsvpmaker-for-toastmasters' ) . '</button>'.rsvpmaker_nonce('return').'</form>';
				else
					$output .= sprintf( '<div id="edito newrapper%s" class="editone_wrapper"><a class="editonelink" editone="%s">Edit</a></div><form id="editone%s" method="post" class="edit_one_form" action="%s" style="display: block;"><div id="suggest%s"></div><input type="hidden" name="post_id" value="%d"><input type="hidden" name="role" value="%s"><div>%s</div>', $field, $field, $field, $permalink, $field, $post->ID, $field, $editone ) . '<button name="edit_one" id="edit_one_button' . esc_attr($field) . '" value="1">' . __( 'Submit', 'rsvpmaker-for-toastmasters' ) . '</button>'.rsvpmaker_nonce('return').'</form>';
			}
		}
		$output .= '<div class="ajax_status" id="status' . $field . '"></div>';

		$output .= '</div></div><!-- end role block -->';
	} //end for loop

	if ( isset( $field ) && strpos( $field, 'Speaker' ) ) {
		$time_limit = ( isset( $atts['time_allowed'] ) ) ? (int) $atts['time_allowed'] : 0;
		$output    .= '<input type="hidden" class="time_limit" value="' . $time_limit . '" />';
	}

	return $output . $backup;
}

function tm_calc_time( $minutes ) {
	if ( empty( $minutes ) ) {
		return;
	}
	if ( $minutes == 'x' ) {
		$minutes = 0;
	} else {
		$minutes = (int) $minutes;
	}
		$seconds = 0;
		global $rsvp_options;
		global $post;
		global $time_count;
		global $end_time;
		global $wpdb;
	if ( empty( $time_count ) ) {
			$datetime = get_rsvp_date( $post->ID );
		if ( empty( $datetime ) ) {
				$sked = get_template_sked( $post->ID );
			if ( isset( $sked['hour'] ) ) {
				$datetime = '2017-01-01 ' . $sked['hour'] . ':' . $sked['minutes'] . ':00';
			}
		}
			$time_count = strtotime( $datetime );
			// todo also end time
	}
		$start_time = date( str_replace( 'T', '', $rsvp_options['time_format'] ), $time_count );
	if ( isset( $_GET['debug'] ) ) {
		$start_time .= $rsvp_options['time_format'];
	}

		$time_count = mktime( date( 'H', $time_count ), date( 'i', $time_count ) + $minutes, date( 's', $time_count ) + $seconds );
	if ( isset( $_REQUEST['end'] ) ) {
		$start_time .= '-' . date( $rsvp_options['time_format'], $time_count );
	}
		return $start_time;
}

function decode_timeblock( $matches ) {
	if(get_option('wp4t_disable_timeblock'))
	return '>';
	return '><span class="timeblock">' . tm_calc_time( $matches[1] ) . '&nbsp;</span>';
}

function agendanoterich2_timeblock( $matches ) {
	$props = ( empty( $matches[1] ) ) ? null : json_decode( $matches[1] );
	$time  = empty( $props->time_allowed ) ? 0 : $props->time_allowed;
	$timed = str_replace( '<p class="wp-block-wp4toastmasters-agendanoterich2"', '<p class="wp-block-wp4toastmasters-agendanoterich2" maxtime="' . $time . '"', $matches[0] );
	if ( $time ) {
		return $timed;
	} else {
		return $timed;//$matches[0];
	}
}

function tm_agenda_content($post_id = 0) {
	global $post, $rsvp_options;
	$notime = (bool) get_option('wp4t_disable_timeblock');
	if(is_admin())
		return;
	if(!$post_id)
		$post_id = $post->ID;
		if(!$post_id) {
			error_log('no agenda content, post_id 0');
			return '';
		}
	
	$has_assignment = array();
	$t = get_rsvpmaker_timestamp( $post_id );
	$agendadata = wpt_get_agendadata($post_id);
	if(empty($agendadata["blocksdata"]))
		return;
	$blocksdata = $agendadata["blocksdata"];
	$content = '';
	$totime = $time = '';
	$time_format = str_replace('T','',$rsvp_options['time_format']);
	$nonce = get_post_meta($post_id,'oneclicknonce',true);
	foreach($blocksdata as $blockindex => $block) {
		if(isset($_GET['debug'])) {
			$content .= '<pre>';
			$content .=  $blockindex.': '.htmlentities(var_export($block,true));
			$content .=  '</pre>';
		}
		$attrs = (isset($block['attrs'])) ? $block['attrs'] : array();
		if(in_array($block["blockName"],['wp4toastmasters/signupnote','wp4toastmasters/help']) )
			continue;
		if(isset($attrs['time_allowed']) || ('wp4toastmasters/milestone' == $block["blockName"]))
		{
			$time = rsvpmaker_date($time_format,$t);
			if(!empty($attrs['time_allowed'])) {
				$t += ($attrs['time_allowed'] * 60);
			if(!empty($attrs['padding_time']))
				$t += ($attrs['padding_time'] * 60);
			$time = preg_replace('/[AP]M/','',$time) .' to '.rsvpmaker_date($time_format,$t);
			}
		}
		else
			$time = '';

		$content .= (is_email_context() || $notime) ? '<div style="margin-top: 10px;">' : '<div class="agendaflex" style="display:flex">';
		if(!$notime && (!isset($_REQUEST['role_only'])))
			$content .= '<div class="timetoleft" style="width: max-content; min-width: 125px; font-size: 12px;">'.$time.'</div>';
		$content .= '<div class="blockcontent" >';
		if('wp4toastmasters/role' == $block["blockName"] && !empty($attrs['role'])) {
			$role = $attrs['role'];
			$count = isset($attrs['count']) ? intval($attrs['count']) : 1;
			$start = !empty($attrs['start']) ? intval($attrs['start']) : 1;
			$totaltime = 0;
			$time_allowed = (empty($attrs['time_allowed'])) ? 0 : $attrs['time_allowed'];
			if(strpos($post->post_content,'speaker-evaluator') && (('Speaker' == $role) || ('Evaluator' == $role)))
			{
				$content .= sprintf('<div><strong>%ss</strong> (%s)</div>',$role,$count);
				if('Speaker' == $role) {
					foreach($block['assignments'] as $roleindex => $assignment) {
						if(!empty($assignment['maxtime']))
							$totaltime += $assignment['maxtime'];
					}
				}
			}
			elseif(!empty($block['assignments'])) //normal output
			foreach($block['assignments'] as $roleindex => $assignment)
			{
				$number = $roleindex + $start;
				if($roleindex == $count) {
					$role = 'Backup '.$role;
					$number = '';
				}
				if(empty($assignment['name']) && is_email_context()) {
					if(empty($nonce)) {
						$nonce = wp_create_nonce('oneclick');
						update_post_meta($post_id,'oneclicknonce',$nonce);
					}
					$link = add_query_arg(array('oneclick' => $nonce,'role' => $role,'e' => '*|EMAIL|*'),get_permalink());
					$link = sprintf('Open - <a href="%s#oneclick">One-Click Signup</a>',$link);
					$assignment['name'] = $link;
				}
				$content .= sprintf('<div><strong>%s %s</strong> %s</div>',$role,($count > 1) ? $number : '',$assignment['name']);
				if(isset($_GET['contacts']) && is_numeric($assignment["ID"]) && ($assignment["ID"] > 0) && is_club_member())
				{
					$content .= wp4_format_contact(get_userdata($assignment["ID"]),false);
					$has_assignment[] = $assignment['ID'];
					//get contactinfo
				}
				if(('Speaker' == $role) && $number) {
					$details = '';
					if(!empty($assignment['manual']) && !strpos($assignment['manual'],'Not Set'))
						$details = $assignment['manual'].' ';
					if(!empty($assignment['project_text']))
						$details .= ' - '.$assignment['project_text'];
					if((is_email_context() || isset($_GET['no_print'])) && !empty($assignment['project']))
						$details .= evaluation_form_link( $assignment['ID'], $post_id, $assignment['project'] );
					if(!empty($details))
						$details = '<div>'.$details.'</div>';
					if(!empty($assignment['display_time']))
						$details .= '<div><strong>'.$assignment['display_time'].'</strong></div>';
					if(!empty($assignment['title']))
						$details .= '<div><em>'.$assignment['title'].'</em></div>';
					if(!empty($assignment['intro']) && get_option( 'wp4toastmasters_intros_on_agenda' )) //check preference
						$details .= wp_kses_post($assignment['intro']);
					if(($assignment['ID'] > 0) || (!is_numeric($assignment['ID']) && !empty($assignment['ID'])))
						{
							$totaltime += $assignment['maxtime'];
						}
					if(isset($_GET['debug']))
						$details = '<pre>'.var_export($assignment,true).'</pre>';
					$content .= $details;				
				}
			}
			if('Speaker' == $role) {
				$style = ($totaltime > $time_allowed) ? 'style="font-weight: bold;font-style:italic;"':'';
				$content .= sprintf('<p %s>Speakers have reserved %d minutes out of %s planned</p>',$style,$totaltime,$time_allowed);				
			}
		}
		elseif('wp4toastmasters/agendaedit' == $block["blockName"]) {
			if(!isset($_REQUEST['role_only'])) {
				$content .= sprintf('<h3>%s</h3>',$attrs['editable']);
				if(!empty($block['edithtml']))
					$content .= wp_kses_post($block['edithtml']);	
			}
		}
		else 
			$content .= render_block($block);
		$content .= '</div></div>'; //end blockcontent, flex wrapper
	}
	if(isset($_GET['contacts']) && is_club_member())
		$content .= wp4_email_contacts($has_assignment);
	if(isset($_GET['debug']))
		$content .= '<pre>'.var_export($blocksdata,true).'</pre>';
	return $content;
}

function toastmasters_officer_single( $atts ) {
	$title                          = ( isset( $atts['title'] ) ) ? $atts['title'] : 'VP of Education';
	$wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
	$index                          = array_search( $title, $wp4toastmasters_officer_titles );
	if ( $index === false ) {
		return;
	}
	$officer_id = $wp4toastmasters_officer_ids[ $index ];

	$contact = '';

	if ( $officer_id ) {
		$userdata                       = get_userdata( $officer_id );
		$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
		$contact                        = '<div><strong>' . $title . ': ' . $userdata->first_name . ' ' . $userdata->last_name . '</strong></div>';
		foreach ( $contactmethods as $name => $value ) {
			if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {
				$contact .= sprintf( "<div>%s: %s</div>\n", $value, $userdata->$name );
			}
		}
		$contact .= sprintf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );
	}
	return $contact;
}

function toastmasters_officer_email_by_title( $title, $site_id = 0 ) {
	$wp4toastmasters_officer_ids    = ($site_id) ? get_blog_option( $site_id, 'wp4toastmasters_officer_ids' ) : get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = ($site_id) ? get_blog_option( $site_id,'wp4toastmasters_officer_titles' ) : get_option( 'wp4toastmasters_officer_titles' );
	$index                          = array_search( $title, $wp4toastmasters_officer_titles );
	if ( $index === false ) {
		return;
	}
	$officer_id = $wp4toastmasters_officer_ids[ $index ];
	$userdata                       = get_userdata( $officer_id );
	if ( !empty($userdata->user_email) ) {
		return $userdata->user_email;
	}
}


$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );

function toastmaster_officers( $atts = array() ) {
	if ( !isset($_GET['context']) && ! isset( $_REQUEST['print_agenda'] ) && ! is_email_context() ) {
		return;
	}
	$label                          = isset( $atts['label'] ) ? $atts['label'] : __( 'Officers', 'rsvpmaker-for-toastmasters' );
	$wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
	$buffer                         = "\n<div class=\"officers\"><span class=\"officers_label\">" . $label . '</span>'; // .$label.": ";

	if ( is_array( $wp4toastmasters_officer_ids ) ) {
		foreach ( $wp4toastmasters_officer_ids as $index => $officer_id ) {
			if ( ! $officer_id ) {
				continue;
			}
			$officer = get_member_name( $officer_id );
			$title   = str_replace( ' ', '&nbsp;', $wp4toastmasters_officer_titles[ $index ] );
			$buffer .= sprintf( '<p class="officer_entity"><span class="officertitle">%s</span><br /><span class="officer">%s</span></p>', $title, $officer );
		}
	} else {
		$buffer .= '<p>' . __( 'Officers list not yet set', 'rsvpmaker-for-toastmasters' ) . '</p>';
	}
	$buffer .= "</div>\n";
	return $buffer;
}

function tm_get_histories() {
	global $post;
	$histories = array();
	$users     = get_users();
	foreach ( $users as $user ) {
		if ( empty( $post->ID ) ) {
			$histories[ $user->ID ] = new role_history( $user->ID );
		} else {
			$histories[ $user->ID ] = new role_history( $user->ID, get_rsvp_date( $post->ID ) );
		}
	}
	return $histories;
}


function wp4t_get_member_status( $member_id ) {
	$exp = (int) get_user_meta( $member_id, 'status_expires', true );
	if ( current_time( 'timestamp' ) > $exp ) {
		delete_user_meta( $member_id, 'status' );
		delete_user_meta( $member_id, 'status_expires' );
		return;
	}
	return get_user_meta( $member_id, 'status', true ) . ' ' . __( 'expires', 'rsvpmaker-for-toastmasters' ) . ': ' . rsvpmaker_date( 'r', $exp );
}

function wp4t_set_member_status( $member_id, $status, $status_expires ) {
	if ( empty( $status ) || empty( $status_expires ) ) {
		return;
	}
	rsvpmaker_fix_timezone();
	update_user_meta( $member_id, 'status_expires', strtotime( $status_expires ) );
	update_user_meta( $member_id, 'status', stripslashes( $status ) );
}

function role_post() {
	if ( ! is_club_member() || empty( $_POST['post_id'] ) || !wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		return;
	}
	if(isset($_POST['suggest_note']))
		return;

	global $current_user;
	global $wpdb, $post;
	$post_id = (int) $_POST['post_id'];
	if ( ! $post_id ) {
		$post_id = $post->ID;
	}
	if ( ! $post_id ) {
		return;
	}
	$is_past   = ( time() > get_rsvpmaker_timestamp( $post_id ) );

	if ( isset( $_POST['take_role'] ) || isset( $_POST['update_speaker_details'] ) ) {
		$role = sanitize_text_field( $_POST['role'] );
		do_action('toastmasters_agenda_change',$post_id,$role,$current_user->ID,0,0);
		update_post_meta( $post_id, $role, $current_user->ID );
		$actiontext = __( 'signed up for', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $role );
		do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $current_user->ID );
		if ( strpos( $role, 'peaker' ) ) {
			// clean any previous speech data
			// echo '_manual'.$role;
			delete_post_meta( $post_id, '_manual' . $role );
			delete_post_meta( $post_id, '_title' . $role );
			delete_post_meta( $post_id, '_project' . $role );
			delete_post_meta( $post_id, '_maxtime' . $role );
			delete_post_meta( $post_id, '_display_time' . $role );
			delete_post_meta( $post_id, '_intro' . $role );
		}
	}

	if ( isset( $_POST['agenda_note'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['agenda_note'] as $index => $note ) {
			$note = stripslashes( $note );
			$note = trim( str_replace( '&nbsp;', ' ', $note ) );
			if ( empty( $_POST['agenda_note_label'][ $index ] ) ) {
				continue;
			}
			$note = preg_replace( '/(style=("|\Z)(.*?)("|\Z))/', '', $note );
			update_post_meta( $post_id, sanitize_text_field($_POST['agenda_note_label'][ $index ]), wp_kses_post( $note ) );
		}
	}

	if ( isset( $_POST['editor_assign'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$edit_log  = array();
		$allzeroes = true;
		foreach ( $_POST['editor_assign'] as $role => $user_id ) {
			$role = sanitize_text_field($role);
			$user_id = sanitize_text_field($user_id);
			if ( isset( $_POST[ 'recommend_instead' . $role ] ) ) {
				$editor_id = (int) $_POST['editor_id'];
				tm_recommend_send( $role, $user_id, get_permalink( $post_id ), preg_replace( '/[^0-9]/', '', $role ), $post_id, $editor_id );
				// update_post_meta($post_id,$role,0);
				continue;
			}
			$was = get_post_meta( $post_id, $role, true );
			if ( $was != $user_id ) {
				do_action('toastmasters_agenda_change',$post_id,$role,$user_id,$was,$current_user->ID);
				update_post_meta( $post_id, $role, $user_id );
				$actiontext = __( 'signed up for', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $role );
				if ( is_numeric( $user_id ) ) {
					if ( $user_id > 0 ) {
						$allzeroes = false;
						do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $user_id );
					}
					$log = get_member_name( $current_user->ID ) . ' assigned ' . $role . ' to ' . get_member_name( $user_id ) . ' for ' . $timestamp;
					if ( $was ) {
						$log .= ' (was: ' . get_member_name( $was ) . ')';
					}
					$edit_log[] = $log;
				}
				if ( strpos( $role, 'peaker' ) && isset( $_POST['_project'] ) ) {
					editor_signup_notification( $post_id, $user_id, $role, sanitize_text_field( $_POST['_manual'][ $role ] ), sanitize_text_field( $_POST['_project'][ $role ] ), sanitize_text_field( $_POST['_title'][ $role ] ) );
				} else {
					editor_signup_notification( $post_id, $user_id, $role );
				}
			}
			if ( strpos( $role, 'peaker' ) && ( $user_id == '0' ) ) {
				// clean any previous speech data
				delete_post_meta( $post_id, '_manual' . $role );
				delete_post_meta( $post_id, '_title' . $role );
				delete_post_meta( $post_id, '_project' . $role );
				delete_post_meta( $post_id, '_maxtime' . $role );
				delete_post_meta( $post_id, '_display_time' . $role );
				delete_post_meta( $post_id, '_intro' . $role );
			}
		}

		if ( isset( $_POST['edit_guest'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			foreach ( $_POST['edit_guest'] as $role => $guest ) {
				$role = sanitize_text_field($role);
				$guest = sanitize_text_field($guest);
				$was = get_post_meta( $post_id, $role, true );
				if ( ! empty( $guest ) && ($was != $guest) ) {
					do_action('toastmasters_agenda_change',$post_id,$role,$guest,$was,$current_user->ID);
					update_post_meta( $post_id, $role, $guest );
					$log = get_member_name( $current_user->ID ) . ' assigned ' . $role . ' to ' . $guest . ' (guest) for ' . rsvpmaker_date( 'F jS, Y', rsvpmaker_strtotime( $timestamp ) );
					if ( $was ) {
						$log .= ' (was: ' . get_member_name( $was ) . ')';
					}
					$edit_log[] = $log;
				}
			}
		}

		if ( isset( $_POST['edit_default'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			foreach ( $_POST['edit_default'] as $role => $defaulton ) {
				$role = sanitize_text_field($role);
				$assign = intval($_POST['editor_assign'][$role]);
				$future = get_future_events();
				foreach($future as $event) {
					update_post_meta($event->ID,$role,$assign);
				}
			}
		}

		if ( ! empty( $edit_log ) ) {
			add_post_meta( $post_id, '_activity_editor', implode( '<br />', $edit_log ) );
			update_option( '_tm_updates_logged', strtotime( '+ 2 minutes' ) );
		}
	}

	if ( isset( $_POST['_manual'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['_manual'] as $basefield => $manual ) {
			$basefield = sanitize_text_field($basefield);
			$manual = sanitize_text_field($manual);
			if ( isset( $_POST['editor_assign'] ) ) {
				$user_id = sanitize_text_field( $_POST['editor_assign'][ $basefield ] );
			} else {
				$user_id = $current_user->ID;
			}

			$title        = sanitize_text_field( $_POST['_title'][ $basefield ] );
			$project      = sanitize_text_field( $_POST['_project'][ $basefield ] );
			$intro        = ( isset( $_POST['_intro'][ $basefield ] ) ) ? wp_kses_post( $_POST['_intro'][ $basefield ] ) : '';
			$time         = (int) ( isset( $_POST['_maxtime'][ $basefield ] ) ) ? sanitize_text_field( $_POST['_maxtime'][ $basefield ] ) : 0;
			$display_time = ( isset( $_POST['_display_time'][ $basefield ] ) ) ? sanitize_text_field( $_POST['_display_time'][ $basefield ] ) : '';
			if ( $time == 0 ) {
				$time = 7;
			}
			if ( $user_id < 1 ) { // unassigned or not available
				$time = 0;
			}
			if ( ! empty( $intro ) ) {
				$wasintro = get_post_meta( $post_id, '_intro' . $basefield, true );
				$intro    = stripslashes( $intro );
				if ( $intro != $wasintro ) {
					do_action( 'toastmasters_agenda_notification', $post_id, __( 'Speaker Introduction: ', 'rsvpmaker-for-toastmasters' ) . "\n\n" . $intro, $user_id, $basefield, 'intro' );
				}
			}
			update_user_meta( $user_id, 'current_manual', strip_tags( $manual ) );
			update_post_meta( $post_id, '_manual' . $basefield, strip_tags( $manual ) );
			update_post_meta( $post_id, '_title' . $basefield, strip_tags( $title ) );
			update_post_meta( $post_id, '_project' . $basefield, strip_tags( $project ) );
			if ( isset( $_POST['_display_time'][ $basefield ] ) ) {
				update_post_meta( $post_id, '_display_time' . $basefield, $display_time );
			}
			if ( isset( $_POST['_maxtime'][ $basefield ] ) ) {
				update_post_meta( $post_id, '_maxtime' . $basefield, $time );
			}
			if ( isset( $_POST['_intro'][ $basefield ] ) ) {
				update_post_meta( $post_id, '_intro' . $basefield, strip_tags( $intro, '<p><br><a><strong><em>' ) );
			}
			do_action( 'save_speaker_extra', $post_id, $basefield );
		}
	}

	if ( isset( $_POST['delete_speaker'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['delete_speaker'] as $field ) {
			$was = get_post_meta( $post_id, $field, true );
			do_action('toastmasters_agenda_change',$post_id,$role,0,$was,$current_user->ID);
			$field = sanitize_text_field($field);
			update_post_meta( $post_id, $field, 0 );
			delete_post_meta( $post_id, '_manual' . $field );
			delete_post_meta( $post_id, '_title' . $field );
			delete_post_meta( $post_id, '_intro' . $field );
			if ( $is_past ) {
				wp4t_delete_history($field, $timestamp, $post_id);
			}
		}
	}

	if ( isset( $_POST['remove_role'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$role = sanitize_text_field($_POST['remove_role']);
		do_action('toastmasters_agenda_change',$post_id,$role,0,$current_user->ID,0);
		update_post_meta( $post_id, $role, 0 );
		if ( strpos( $role, 'peaker' ) ) {
			delete_post_meta( $post_id, '_manual' . $role );
			delete_post_meta( $post_id, '_project' . $role );
			delete_post_meta( $post_id, '_title' . $role );
			delete_post_meta( $post_id, '_intro' . $role );
		}
		$actiontext = __( 'withdrawn: ', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $role );
		do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $current_user->ID );
	}

	if ( isset( $_POST['tweaktime'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$post    = get_post( $post_id );
		$content = $post->post_content;
		foreach ( $_POST['tweaktime'] as $role ) {
			$role = sanitize_text_field($role);
			if ( strpos( $role, 'ote' ) == 1 ) {
				// echo '/{"uid":"'.$role.'[^}]+}/';
				preg_match( '/{.+"uid":"' . $role . '[^}]+}/', $content, $matches );
				$roleindex = $role;
				// echo ' note match: ';
				// print_r($matches);
			} else {
				$roleindex = preg_replace( '/[^a-zA-Z]/', '', $role );
				preg_match( '/{"role":"' . $role . '[^}]+}/', $content, $matches );
				// echo ' role match: ';
				// print_r($matches);
			}
			if ( ! empty( $matches[0] ) ) {
				$minutes = sanitize_text_field($_POST['tweakminutes'][ $roleindex ]);
				$data    = json_decode( $matches[0] );
				if ( isset( $_POST['tweakcount'][ $roleindex ] ) ) {
					$count       = sanitize_text_field($_POST['tweakcount'][ $roleindex ]);
					$data->count = $count;
				}
				if ( isset( $_POST['tweakpadding'][ $roleindex ] ) ) {
					$padding_time       = sanitize_text_field( $_POST['tweakpadding'][ $roleindex ] );
					$data->padding_time = $padding_time;
				}
				$data->time_allowed = $minutes;
				$new                = json_encode( $data );
				$content            = str_replace( $matches[0], $new, $content );

				if ( ( $role == 'Speaker' ) && isset( $_POST['tweakevaltoo'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
					preg_match( '/{"role":"Evaluator[^}]+}/', $content, $matches );
					if ( ! empty( $matches[0] ) ) {
						$data               = json_decode( $matches[0] );
						$data->count        = $count;
						$data->time_allowed = round( $count * 3.5 );
						$new                = json_encode( $data );
						$content            = str_replace( $matches[0], $new, $content );
					}
				}
			}
		}
		wp_update_post(
			array(
				'ID'           => $post_id,
				'post_content' => $content,
			)
		);
	}

	// Make sure visitors see current data / Purge a single post / page by passing it's ID:
	if ( function_exists( 'w3tc_pgcache_flush_post' ) ) {
		w3tc_pgcache_flush_post( $post_id );
	}

}

function manual_type_options( $field, $type ) {
	$manuals_by_type = get_manuals_by_type();
	$options         = '';
	foreach ( $manuals_by_type as $index => $mtype ) {
		$s        = ( $type == $index ) ? ' selected="selected" ' : '';
		$options .= sprintf( '<option value="%s" %s>%s</option>', $index, $s, $index );
	}
	return sprintf( '<div><select id="_manualtype_%s" class="manualtype">%s</select></div>', $field, $options );
}

function type_from_manual( $manual ) {
	$type_manual = get_manuals_by_type();
	foreach ( $type_manual as $type => $manual_array ) {
		if ( in_array( $manual, $manual_array ) ) {
			return $type;
		}
	}
}

function speaker_details_history($post_id, $field, $row ) {

	$manual = $row->manual;
	$project_key = $row->project_key;
	$project_text = $row->project;
	$title = $row->title;
	$intro = $row->intro;

	if ( empty( $project_key ) ) {
			$project_text = 'Choose Project';
	}
	if ( empty( $project_options ) ) {
		$project_options  = sprintf( '<option value="%s">%s</option>', $project_key, $project_text );
		$pa               = get_projects_array( 'options' );
		$project_options .= isset( $pa[ $manual ] ) ? $pa[ $manual ] : $pa['COMPETENT COMMUNICATION'];
	}

		$output = '<div>
		<input type="hidden" name="post_id" value="' . $post_id . '" />
		<select class="speaker_details manual" name="_manual[' . $field . ']" id="_manual_' . $field . '"">' . get_manuals_options( $manual ) . '</select><br /><select class="speaker_details project" name="_project[' . $field . ']" id="_project_' . $field . '">' . $project_options . '</select> ' . $link;
		$output .= '<div id="_tmsg_' . $field . '"></div></div>';
		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text' . $field . '" name="_title[' . $field . ']" value="' . $title . '" /></div>';
		$output .= '<div class="speaker_introduction">Introduction: <br /><textarea class="intro_' . $field . ' mce" name="_intro[' . $field . ']" id="_intro_' . $field . '" style="width: 100%; height: 4em;" >' . $intro . '</textarea></div>';
	$output = '<div class="speaker_details_form">'.$output.'</div>';
	return $output;
}


function speaker_details( $field, $atts = array(), $user = null ) {
	$demo = ( isset( $atts['demo'] ) );
	global $post;
	global $current_user;
	if(!empty($user))
		$current_user = $user;//fake current user
	$post_id = ( isset( $post ) && isset( $post->ID ) ) ? $post->ID : 0;
	$output  = $title = $link = '';

		$manual = ( isset( $post->ID ) ) ? get_post_meta( $post->ID, '_manual' . $field, true ) : '';

	if ( ! empty( $manual ) ) {
		$type = type_from_manual( $manual );
		if ( strpos( $manual, 'Non Manual' ) ) {
			$type = 'Other';
		}
		$output .= manual_type_options( $field, $type );
	}

	if ( empty( $manual ) || strpos( $manual, 'hoose Manual' ) || strpos( $manual, 'elect Manual' ) ) {
		if ( is_edit_roles() || isset( $_REQUEST['recommend_roles'] ) ) {
			//rsvpmaker_debug_log(0,'user id - get speaking track called from recommend roles or edit roles');
			$track = get_speaking_track( 0 );
		} else {
			//rsvpmaker_debug_log($current_user->ID,'user id - get speaking track called from role signup');
			$track = get_speaking_track( $current_user->ID );
		}
		$current_manual = $track['manual'];

		$output .= manual_type_options( $field, $track['type'] );

		if ( empty( $current_manual ) ) {
			$manual          = 'Select Manual/Path';
			$time            = 0;
			$project_options = '<option value="">' . __( 'Select Manual/Path to See Options', 'rsvpmaker-for-toastmasters' ) . '</option>';
		} else {
			$project_options_array = get_projects_array( 'options' );
			$manual                = $current_manual;
			$time                  = 0;
			if ( isset( $project_options_array[ $manual ] ) ) {
				$project_options = '<option value="">' . __( 'Select Project', 'rsvpmaker-for-toastmasters' ) . '</option>' . $project_options_array[ $manual ];
			} else {
				$project_options = '<option value="">' . __( 'Select Manual/Path to See Options', 'rsvpmaker-for-toastmasters' ) . '</option>';
			}
		}

		// $output .= sprintf('<div>Empty, setting manual to %s</div>',$manual);
	} elseif ( strpos( $manual, ':' ) ) {
			$parts  = explode( ':', $manual );
			$manual = trim( $parts[0] );
		if ( strpos( $manual, '(CC) MANUAL' ) ) {
			$manual = 'COMPETENT COMMUNICATION';
		}
			$project_text = trim( $parts[1] );
			$project_key  = get_project_key( $project_text );
			$time         = 7;
	} else {
		$project_key = get_post_meta( $post->ID, '_project' . $field, true );
		if ( ! empty( $project_key ) ) {
				$speaker = get_post_meta( $post->ID, $field, true );
				$link    = evaluation_form_link( $speaker, $post->ID, $project_key );
		}
		$project_text = get_project_text( $project_key );
		$time         = get_post_meta( $post->ID, '_maxtime' . $field, true );
	}
	if ( empty( $project_key ) ) {
			$project_text = 'Choose Project';
			$project_key  = '';
	}
	if ( empty( $project_options ) ) {
		$project_options  = sprintf( '<option value="%s">%s</option>', $project_key, $project_text );
		$pa               = get_projects_array( 'options' );
		$project_options .= isset( $pa[ $manual ] ) ? $pa[ $manual ] : $pa['COMPETENT COMMUNICATION'];
	}

	if ( strpos( $field, 'Backup' ) ) {
		$maxclass = '';
	} else {
		$maxclass = 'maxtime';
	}

		$output .= '<div>
		<input type="hidden" name="post_id" value="' . $post_id . '" />
		<select class="speaker_details manual" name="_manual[' . $field . ']" id="_manual_' . $field . '"">' . get_manuals_options( $manual ) . '</select><br /><select class="speaker_details project" name="_project[' . $field . ']" id="_project_' . $field . '">' . $project_options . '</select> ' . $link;
		$output .= '<div id="_tmsg_' . $field . '"></div></div>';
	if ( ! $demo ) {
		$display_time = get_post_meta( $post_id, '_display_time' . $field, true );
		$output      .= '<div class="time_required">Timing: <input type="text"class="speaker_details" name="_display_time[' . $field . ']" id="_display_time_' . $field . '" size="10" value="' . $display_time . '">';
		$output      .= ' Maximum Time: <input type="text"class="speaker_details ' . $maxclass . '" name="_maxtime[' . $field . ']" id="_maxtime_' . $field . '" size="4" value="' . $time . '"></div>';
		$title        = get_post_meta( $post_id, '_title' . $field, true );
		$intro        = get_post_meta( $post_id, '_intro' . $field, true );
	}

		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text' . $field . '" name="_title[' . $field . ']" value="' . $title . '" /></div>';
	if ( ! $demo ) {
		$output .= '<div class="speaker_introduction">Introduction: <br /><textarea class="intro_' . $field . ' mce" name="_intro[' . $field . ']" id="_intro_' . $field . '" style="width: 100%; height: 4em;" >' . $intro . '</textarea></div>';
	}
		$output = apply_filters( 'speaker_form_extra', $output, $field );
	$output = '<div class="speaker_details_form">'.$output.'</div>';
	return $output;
}

function speaker_details_admin( $user_id, $key, $manual, $project_key, $title, $intro ) {
	global $post;
	global $current_user;
	$output = '';
	if ( empty( $manual ) || strpos( $manual, 'hoose Manual' ) ) {
			$manual          = 'Select Manual/Path';
			$project_options = '<option value="">' . __( 'Select Manual/Path to See Options', 'rsvpmaker-for-toastmasters' ) . '</option>';
	} else {
		$project_text = get_project_text( $project_key );
	}
	if ( empty( $project_key ) ) {
			$project_text = 'Choose Project';
	}
	if ( empty( $project_options ) ) {
		$project_options  = sprintf( '<option value="%s">%s</option>', $project_key, $project_text );
		$pa               = get_projects_array( 'options' );
		$project_options .= isset( $pa[ $manual ] ) ? $pa[ $manual ] : $pa['COMPETENT COMMUNICATION'];
	}
		$field = preg_replace( '/[^a-zA-Z0-9]/', '', $key );

		$output .= '<div>
		<select class="speaker_details manual" name="manual" id="_manual_' . $field . '"">' . get_manuals_options( $manual ) . '</select><br /><select class="speaker_details project" name="project" id="_project_' . $field . '">' . $project_options . '</select>';
		$output .= '</div>';
		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text' . $field . '" name="title" value="' . $title . '" /></div>';
		$output .= '<div class="speaker_introduction">Introduction: <br /><textarea class="intro" name="intro" id="_intro_' . $field . '" style="width: 100%; height: 4em;" class="mce">' . $intro . '</textarea></div>';
	if ( strpos( $key, '|0' ) ) {
		preg_match( '/\d{4}-\d{2}-\d{2}/', $key, $match );
		$output .= '<div><input type="text" id="date' . $field . '" name="date" value="' . $match[0] . '" > (added on dashboard)</div>';
	}
	return $output;
}

function speech_public_details( $field, $assigned ) {
	global $post;

		$manual        = get_post_meta( $post->ID, '_manual' . $field, true );
		$title         = get_post_meta( $post->ID, '_title' . $field, true );
		$project_key   = get_post_meta( $post->ID, '_project' . $field, true );
		$project_text  = get_project_text( $project_key );
		$project_text .= evaluation_form_link( $assigned, $post->ID, $project_key );
		$time          = (int) get_post_meta( $post->ID, '_maxtime' . $field, true );
		$output        = '';
	if ( $time == 0 ) {
		$time = 7;
	}

	if ( $manual ) {
		$output .= '<div class="manual">' . $manual . ' ' . $project_text . '</div>';
		if ( ! strpos( $field, 'Backup' ) ) {
			$output .= '<input type="hidden" class="speaker_details maxtime" name="_maxtime[' . $field . ']" id="_maxtime_' . $field . '" value="' . $time . '">';
		}
	}
	if ( $title ) {
		$output .= '<div class="speech_title">' . $title . '</div>';
	}
	if ( $time && ! strpos( $field, 'Backup' ) ) {
		$output .= '<div class="speech_time">' . __( 'Time reserved for this speech', 'rsvpmaker-for-toastmasters' ) . ': ' . $time . ' ' . __( 'minutes.', 'rsvpmaker-for-toastmasters' ) . '</div>';
	}
		return apply_filters( 'speech_details_public', $output, $field );
}

function evaluation_form_link( $speaker, $meeting_id, $project_key ) {
	if ( isset( $_GET['print_agenda'] ) ) {
		return '';
	}
	$slug = ( empty( $project_key ) ) ? 'unspecified' : urlencode( $project_key );
	if ( ! isset( $_GET['print_agenda'] ) ) {
		return sprintf( ' (<a href="%s" target="_blank">%s</a>)', admin_url( 'admin.php?page=wp4t_evaluations&speaker=' . $speaker . '&meeting_id=' . $meeting_id . '&project=' . $slug ), __( 'evaluation form', 'rsvpmaker-for-toastmasters' ) );
	}
}

function evaluation_form_url( $speaker, $meeting_id ) {
	return add_query_arg('evalme',$speaker,get_permalink($meeting_id)); 
}

function speech_progress() {
	global $wpdb;
	global $current_user;

	if ( isset( $_REQUEST['select_user'] ) ) {
		$user_id = (int) $_REQUEST['select_user'];
		$user    = get_userdata( $user_id );
		echo '<h2>' . __( 'Progress Report for', 'rsvpmaker-for-toastmasters' ) . ' ' . esc_html($user->display_name) . '</h2>';
	} else {
		$user_id = $current_user->ID;
		echo '<h2>' . __( 'Progress Report for You', 'rsvpmaker-for-toastmasters' ) . '</h2>';
	}

	echo '<p><form method="get" action="' . admin_url( 'edit.php' ) . '"><input type="hidden" name="post_type" value="rsvpmaker"><input type="hidden" name="page" value="speech_progress">' . awe_user_dropdown( 'select_user', 0, true ) . '<input type="submit" value="' . __( 'Get', 'rsvpmaker-for-toastmasters' ) . '" />'.rsvpmaker_nonce('return').'</form></p>' . "\n";

	echo '<h2>' . __( 'Speeches', 'rsvpmaker-for-toastmasters' ) . '</h2>';
	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.date as datetime, a2.meta_value as template
	 FROM " . $wpdb->posts . '
	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event
	 JOIN " . $wpdb->postmeta . ' a2 ON ' . $wpdb->posts . ".ID =a2.post_id AND a2.meta_key LIKE '_role_Speaker%' AND a2.meta_value=" . $user_id . ' 
	 WHERE date < CURDATE()
	 ORDER BY date DESC';

	$results = $wpdb->get_results( $sql );
	foreach ( $results as $row ) {
		$manual = $wpdb->get_var( 'SELECT meta_value FROM ' . $wpdb->prefix . "postmeta WHERE meta_key = '_manual" . $row->meta_key . "' AND post_id=" . $row->post_id );
		$date   = rsvpmaker_date( 'M jS', rsvpmaker_strtotime( $row->datetime ) );
		if ( ! $manual || strpos( $manual, 'Manual / Speech' ) ) {
			$permalink = rsvpmaker_permalink_query( $row->post_id );
			if ( isset( $_REQUEST['select_user'] ) && $_REQUEST['select_user'] ) {
				$permalink .= 'edit_roles=1';
			}
			$manual = 'Speech details not recorded (<a href="' . esc_attr($permalink) . '">set now?</a>)';
		}
		echo esc_html($manual . ' - ' . $date) . '<br /><br />';
	}

	echo '<h2>' . __( 'Other Roles', 'rsvpmaker-for-toastmasters' ) . "</h2>\n";

	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.date as datetime, a2.meta_value as template
	 FROM " . $wpdb->posts . '
	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event
	 JOIN " . $wpdb->postmeta . ' a2 ON ' . $wpdb->posts . ".ID =a2.post_id AND a2.meta_key NOT LIKE '%Speaker%' AND meta_key NOT LIKE '_edit_last' AND a2.meta_value=" . $user_id . ' 
	 WHERE a1.date < CURDATE()
	 ORDER BY a1.date DESC';

	$results = $wpdb->get_results( $sql );
	foreach ( $results as $row ) {
		$date = rsvpmaker_date( 'M jS', rsvpmaker_strtotime( $row->datetime ) );
		$role = str_replace( '_', ' ', $row->meta_key );
		$role = preg_replace( '/ [1-9]/', '', $role );
		printf( '<p>%s - %s</p>', $role, $date );
	}

	$wpdb->show_errors();
	$now = rsvpmaker_date( 'Y-m-d H:i:s' );
	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.date as datetime, a2.meta_value as template
	 FROM " . $wpdb->posts . '
	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event 
	 JOIN " . $wpdb->postmeta . ' a2 ON ' . $wpdb->posts . ".ID =a2.post_id AND a2.meta_key LIKE '_role_Speaker%' AND a2.meta_value=" . $user_id . "  AND concat('',a2.meta_value * 1) = a2.meta_value
	 WHERE a1.date < '" . $now . "'
	 ORDER BY a1.date DESC";

	$results = $wpdb->get_results( $sql );
	foreach ( $results as $row ) {
		$role = str_replace( '_', ' ', str_replace('_role_','',$row->meta_key) );
		$role = preg_replace( '/ [1-9]/', '', $role );
		$done[ $row->meta_value ][ $role ]++;
		// printf('<p>%s - %s</p>',$role,$date);
	}

	foreach ( $done as $index => $roles ) {
		echo '<p>' . __( 'user', 'rsvpmaker-for-toastmasters' ) . ': ' . $index;
		print_r( $roles );
		echo "</p>\n";
	}

}

function unpack_user_archive_data( $raw ) {
	if ( ! is_serialized( $raw ) ) {
		return;
	}
	$userdata = unserialize( $raw );
	if ( is_object( $userdata ) ) {
		if ( isset( $userdata->data ) ) {
			$userdata = (array) $userdata->data;
		} else {
			$userdata = (array) $userdata;
		}
	}
	if ( empty( $userdata['first_name'] ) && empty( $userdata['last_name'] ) ) {
		if ( ! empty( $userdata['display_name'] ) ) {
			$p                      = explode( ' ', $userdata['display_name'] );
			$userdata['first_name'] = array_shift( $p );
			$userdata['last_name']  = implode( ' ', $p );
		} else {
			$userdata['first_name'] = $userdata['last_name'] = '';
		}
	}
	return $userdata;
}

function wp4t_extended_list() {
	echo '<h2>' . __( 'Former Members', 'rsvpmaker-for-toastmasters' ) . '</h2>';
	echo '<p><em>' . __( 'This list includes inactive members and gives you the option of reactivating their accounts', 'rsvpmaker-for-toastmasters' ) . '</em></p>';
	echo '<p><a href="'.admin_url('users.php?page=wp4t_extended_list&sort=newest').'">Sort Newest to Oldest Records</a> | <a href="'.admin_url('users.php?page=wp4t_extended_list&sort=oldest').'">Sort Oldest to Newest Records</a></p>';

	$member_emails = [];
	$members = get_club_members();
	foreach($members as $m) {
		$member_emails[] = $m->user_email;
	}

	global $wpdb;
	$public_context = false;
	$archive_table = $wpdb->prefix . 'users_archive';
	if(isset($_POST['former_action']) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach($_POST['former_action'] as $action) {
			if('action' == $action)
				continue;
			if('reactivate' == $action && !empty($_POST['former'])) {
				foreach($_POST['former'] as $archive_id) {
					$archive_id = intval($archive_id);
					//printf('<p>Reactivate %d</p>',$archive_id);
					$archive = $wpdb->get_row("SELECT * FROM $archive_table WHERE id=$archive_id");
					printf('<p>Reactivate %s</p>',var_export($archive,true));
					$user_id = $archive->user_id;
					$exists = get_userdata($user_id);
					if($exists && is_multisite()) {
						printf('<p>Make Blog Member: User ID %d</p>',$user_id);
						make_blog_member( $user_id );
					}
					else {
						$newuser = unpack_user_archive_data( $archive->data );
						printf('<p>Recreate %s</p>',var_export($newuser,true));
						$old_id = $newuser['ID'];
						unset( $newuser['ID'] );
						$newuser['user_pass'] = wp_generate_password();
						$member_factory       = new Toastmasters_Member();
				
						// $result = wp_insert_user($newuser);
						$result = $member_factory->add( $newuser );
						$member_factory->show_confirmations();
				
						foreach ( $newuser as $key => $value ) {
							if ( is_serialized( $value ) ) {
								add_user_meta( $result, $key, unserialize( $value ) );
							} elseif ( strpos( $key, 'user' ) === false ) {
								add_user_meta( $result, $key, $value );
							}
						}				
					}
				}
			}
			if('delete' == $action && !empty($_POST['former'])) {
				foreach($_POST['former'] as $archive_id) {
					printf('<p>Delete %d</p>',$archive_id);
					$wpdb->query("DELETE FROM $archive_table WHERE id=".intval($archive_id));
				}
			}
		}
	}
	
if(isset($_GET['make_user_member']))
	echo '<p><strong>Confirm by clicking the Apply button</strong></p>';
if(isset($_GET['sort'])) {
	$sort = 'updated ';
	$sort .= ($_GET['sort'] == 'newest') ? 'DESC' : 'ASC';
}
else
	$sort = 'sort';
$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'users_archive ORDER BY '.$sort );
printf('<form method="post" action="%s">
<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label><select name="former_action[]" id="bulk-action-selector-top">
<option value="-1">Bulk actions</option>
	<option value="reactivate" %s>Reactivate</option>
	<option value="delete">Delete</option>
</select>
<input type="submit" id="doaction" class="button action" value="Apply">
</div>',admin_url('users.php?page=wp4t_extended_list'), (isset($_GET['make_user_member']) ? ' selected="selecte" ': '') );
printf('<table class="wp-list-table widefat fixed members" cellspacing="0"><thead><tr><th id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox"></th><th>%s</th><th>%s</th><th>%s</th></tr></thead><tbody>',  __( 'Name', 'rsvpmaker-for_toastmasters' ), __( 'Email', 'rsvpmaker-for_toastmasters' ), __( 'Phone', 'rsvpmaker-for_toastmasters' ) );
foreach($results as $row) {
	if(is_user_member_of_blog($row->user_id) )
		continue;
	if(in_array($row->email,$row->email))
		continue;	
	$user = unpack_user_archive_data( $row->data );
	$name = (empty($user["display_name"])) ? $user["first_name"].' '.$user["last_name"] : $user["display_name"];
	$phones = array();
	if(!empty($user["mobile_phone"]))
		$phones[] = 'Mobile: '.$user["mobile_phone"];
	if(!empty($user["home_phone"]))
		$phones[] = 'Home: '.$user["home_phone"];
	if(!empty($user["work_phone"]))
		$phones[] = 'Work: '.$user["work_phone"];
	$checked = (isset($_GET['make_user_member']) && ($row->id == $_GET['make_user_member']) ) ? ' checked="checked" ' : '';
	printf('<tr><td class="check-column">&nbsp;<input name="former[]" type="checkbox" %s class="subscriber" value="%d"></td><td>%s <span class="reactivate"><a href="%s">%s</a></td><td>%s</td><td>%s</td></tr>', $checked ,$row->id, $name, admin_url('users.php?page=wp4t_extended_list&make_user_member='.$row->id), __('Reactivate','rsvpmaker-for_toastmasters'), $row->email, implode('<br>',$phones));
}
echo '</tbody></table>';
rsvpmaker_nonce();
echo '<div class="alignleft actions bulkactions">
<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label><select name="former_action[]" id="bulk-action-selector-top">
<option value="-1">Bulk actions</option>
<option value="reactivate">Reactivate</option>
<option value="delete">Delete</option>
</select>
<input type="submit" id="doaction" class="button action" value="Apply">
</div></form>';

}

function edit_members() {

	$hook = tm_admin_page_top( __( 'Edit Member', 'rsvpmaker-for-toastmasters' ) );

	$security_roles = array( 'administrator', 'manager', 'editor', 'author', 'contributor', 'subscriber' );

	echo '<p>' . __( 'Authorized users can use this screen to edit member email addresses and other contact information.' ) . '</p>';

	if ( isset( $_POST['edit_member_nonce'] ) && wp_verify_nonce( $_POST['edit_member_nonce'], 'edit_member' ) ) {
		$user['ID']               = (int) $_POST['user_id'];
		$user['user_email']       = sanitize_text_field(trim( $_POST['email'] ));
		$user['first_name']       = sanitize_text_field( $_POST['first_name'] );
		$user['last_name']        = sanitize_text_field( $_POST['last_name'] );
		$user['nickname']         = $user['display_name'] = $user['first_name'] . ' ' . $user['last_name'];
		$user['home_phone']       = sanitize_text_field( $_POST['home_phone'] );
		$user['work_phone']       = sanitize_text_field( $_POST['work_phone'] );
		$user['mobile_phone']     = sanitize_text_field( $_POST['mobile_phone'] );
		$user['toastmasters_id']  = (int) preg_replace('/[^0-9]/','',$_POST['toastmasters_id']);
		$user['education_awards'] = sanitize_text_field( $_POST['education_awards'] );
		if ( current_user_can( 'manage_options' ) && isset( $_POST['user_role'] ) && in_array( $_POST['user_role'], $security_roles ) && ! user_can( $user['ID'], 'administrator' ) ) {
			$user['role'] = sanitize_text_field( $_POST['user_role'] );
		}
		$return = wp_update_user( $user );
		if ( is_int( $return ) ) {
			echo '<div class="updated">Updated member record: ' . esc_html($user['display_name']) . '</div>';
		} elseif ( is_wp_error( $return ) ) {
			echo '<div class="error">Error: ' . $return->get_error_message() . '</div>';
		}
		// update user
	}

	if ( isset( $_REQUEST['user_id'] ) ) {
		$user_id  = (int) $_REQUEST['user_id'];
		$userdata = get_userdata( $user_id );
		if ( ! $userdata ) {
			die( 'error' );
		}
		?>
<form action="<?php echo admin_url( 'users.php?page=edit_members' ); ?>" method="post" name="edituser" id="edituser" class="add:users: validate">
		<?php wp_nonce_field( 'edit_member', 'edit_member_nonce' ); ?>
<input type="hidden" name="user_id" value="<?php echo (int) $userdata->ID; ?>" />
<table class="form-table">
	<tr>
		<th scope="row"><label for="email"><?php _e( 'Email', 'rsvpmaker-for-toastmasters' ); ?></label></th>
		<td><input name="email" type="text" id="email" value="<?php echo esc_attr($userdata->user_email); ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e( 'First Name', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="first_name" type="text" id="first_name" value="<?php echo esc_attr($userdata->first_name); ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="last_name"><?php _e( 'Last Name', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="last_name" type="text" id="last_name" value="<?php echo esc_attr($userdata->last_name); ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="home_phone"><?php _e( 'Home Phone', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="home_phone" type="text" id="home_phone" value="<?php echo esc_attr($userdata->home_phone); ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="work_phone"><?php _e( 'Work Phone', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="work_phone" type="text" id="work_phone" value="<?php echo esc_attr($userdata->work_phone); ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="mobile_phone"><?php _e( 'Mobile Phone', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="mobile_phone" type="text" id="mobile_phone" value="<?php echo esc_attr($userdata->mobile_phone); ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="toastmasters_id"><?php _e( 'Toastmasters ID #', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="toastmasters_id" type="text" id="toastmasters_id" value="<?php echo esc_attr($userdata->toastmasters_id); ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="education_awards"><?php _e( 'Education Awards', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="education_awards" type="text" id="education_awards" value="<?php echo esc_attr($userdata->education_awards); ?>" />
		<br /><?php _e( 'Use the abbreviations', 'rsvpmaker-for-toastmasters' ); ?> CC, ACB, ACS, ACG, CL, ALB, ALS, DTM</td>
	</tr>
		<?php
		if ( current_user_can( 'manage_options' ) ) {
			$user         = new WP_User( $user_id );
			$current_role = $user->roles[0];
			$options      = '';
			foreach ( $security_roles as $role ) {
				$s     = ( $role == $current_role ) ? ' selected="selected" ' : '';
				$label = ucfirst( $role );
				if ( $role == 'subscriber' ) {
						$label .= ' (' . __( 'Member', 'rsvpmaker-for-toastmasters' ) . ')';
				}
				$options .= sprintf( '<option value="%s" %s>%s</option>', $role, $s, $label );
			}
			?>
	<tr class="form-field">
		<th scope="row"><label for="user_role"><?php _e( 'User Role', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><select name="user_role" id="user_role"><?php echo esc_attr($options); ?></select>
		</td>
	</tr>
			<?php
		}
		?>
	</table>
<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e( 'Save', 'rsvpmaker-for-toastmasters' ); ?>"  /></p>
<?php rsvpmaker_nonce(); ?>
</form>
		<?php

	}

	$blogusers = get_users( 'orderby=nicename' );
	foreach ( $blogusers as $user ) {

		$userdata = get_userdata( $user->ID );
		// if($userdata->hidden_profile)
		// continue;
		$index             = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );
		$members[ $index ] = $userdata;
	}

	ksort( $members );
	foreach ( $members as $userdata ) {
		printf( '<p><a href="' . admin_url( 'users.php?page=edit_members&user_id' ) . '=%d">%s %s</a></p></p>', $userdata->ID, $userdata->first_name, $userdata->last_name );
	}
	tm_admin_page_bottom( $hook );
}

function awesome_menu() {

	// defaults 'edit_signups' => 'read','email_list' => 'read','edit_member_stats' => 'edit_others_posts','view_reports' => 'read','view_attendance' => 'read','agenda_setup' => 'edit_others_posts'
	$security = get_tm_security();

	if ( ! function_exists( 'do_blocks' ) ) {
		add_submenu_page( 'edit.php?post_type=rsvpmaker', __( 'Agenda Timing', 'rsvpmaker-for-toastmasters' ), __( 'Agenda Timing', 'rsvpmaker-for-toastmasters' ), $security['edit_signups'], 'agenda_timing', 'agenda_timing' );
	}

	add_submenu_page( 'profile.php', __( 'Add Members', 'rsvpmaker-for-toastmasters' ), __( 'Add Members', 'rsvpmaker-for-toastmasters' ), 'edit_others_posts', 'add_awesome_member', 'add_awesome_member' );

	add_submenu_page( 'profile.php', __( 'Edit Members', 'rsvpmaker-for-toastmasters' ), __( 'Edit Members', 'rsvpmaker-for-toastmasters' ), 'edit_members', 'edit_members', 'edit_members' );

	add_submenu_page( 'profile.php', __( 'RSVP List to Members', 'rsvpmaker-for-toastmasters' ), __( 'RSVP List to Members', 'rsvpmaker-for-toastmasters' ), 'edit_members', 'rsvp_to_member', 'rsvp_to_member' );
	add_submenu_page('profile.php', __("Former Members",'rsvpmaker-for-toastmasters'), __("Former Members",'rsvpmaker-for-toastmasters'), 'edit_members', "wp4t_extended_list", "wp4t_extended_list" );
	add_submenu_page('profile.php', __("Enable Mobile App (experimental)",'rsvpmaker-for-toastmasters'), __("Enable Mobile App (experimental)",'rsvpmaker-for-toastmasters'), 'read', "wp4t_enable_mobile", "wp4t_enable_mobile" );

	$page_title = 'Toastmasters';
	$menu_title = $page_title;
	$capability = 'manage_options';
	$menu_slug  = 'wp4toastmasters_settings';
	$function   = 'wp4toastmasters_settings';
	add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	add_options_page( 'Toastmasters Security', 'TM Security', 'manage_options', 'tm_security_caps', 'tm_security_caps' );

	add_submenu_page( 'upload.php', __( 'YouTube Toastmasters', 'rsvpmaker-for-toastmasters' ), __( 'YouTube Toastmasters', 'rsvpmaker-for-toastmasters' ), 'edit_others_posts', 'tm_youtube_tool', 'tm_youtube_tool' );
	add_submenu_page( 'profile.php', __( 'Privacy Preferences', 'rsvpmaker-for-toastmasters' ), __( 'Privacy Preferences', 'rsvpmaker-for-toastmasters' ), 'edit_members', 'tm_privacy_prompt', 'tm_privacy_prompt' );

}

function wp4toastmasters_settings() {
	global $wpdb, $current_user;
	add_awesome_roles();
    rsvpmail_clear_allforwarders(get_current_blog_id());
	?>
<div class="wrap">
<?php rsvpmaker_admin_heading('Toastmasters '.__( 'Settings', 'rsvpmaker-for-toastmasters' ),__FUNCTION__);?>
	<h2 class="nav-tab-wrapper rsvpmaker-nav-tab-wrapper">
	  <a class="nav-tab <?php if(empty($_REQUEST['tab'])) echo 'nav-tab-active'; ?>" href="#basic">Basic Settings</a>
	  <a class="nav-tab <?php if(!empty($_REQUEST['tab']) && 'security' == $_REQUEST['tab'] ) echo 'nav-tab-active'; ?>" href="#security">Security</a>
	  <a class="nav-tab <?php if(!empty($_REQUEST['tab']) && 'rules' == $_REQUEST['tab'] ) echo 'nav-tab-active'; ?>" href="#rules">Rules</a>
	  <a class="nav-tab <?php if(!empty($_REQUEST['tab']) && 'notifications' == $_REQUEST['tab'] ) echo 'nav-tab-active'; ?>" href="#notifications">Notifications</a>
	</h2>

	<div id="sections" class="toastmasters-admin rsvpmaker" >
	<section class="toastmasters-admin" id="basic">

	<div class="toastmasters-see-also">
See also:
<ul>
<li><a href="<?php echo admin_url('options-general.php?page=rsvpmaker_settings'); ?>">RSVPMaker Settings</a> - events and guest registration</li>
<li><a href="<?php echo admin_url('edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list'); ?>">Event Templates</a> - meeting templates</li>
<ul>
<?php
if($district = wp4t_is_district())
{
echo '<h3>District: '.$district.'</h3>';
?>
<p>This website is set up as a district website.</p>
<form method="get" action="<?php echo admin_url('options-general.php'); ?>">
<input type="hidden" name="page" value="wp4toastmasters_settings">
<input type="hidden" name="clubreset" value="1">
<?php
rsvpmaker_nonce();
submit_button('Switch to Club');
?>
</form>
<?php	
}
else {
?>
<h3>Reconfigure as a district website?</h3>
<p>This website is set up for a club. Changing it to a district website will, among other things, change the default officer titles and email forwarding.</p>
<form method="get" action="<?php echo admin_url('options-general.php'); ?>">
<input type="hidden" name="page" value="wp4toastmasters_settings">
District <input name="district"> (number or designation, i.e. Founders)
<?php
rsvpmaker_nonce();
submit_button('Switch to District');
?>
</form>
<?php	
}
?>
</div>

<form method="post" action="options.php">
	<?php
	if(isset($_GET['clubreset'])) {
		delete_option ('wp4toastmasters_officer_titles' );
		delete_option( 'wp4toastmasters_officer_slugs' );
		delete_option('toastmasters_district');
	}
	if(isset($_GET['district']) && rsvpmaker_verify_nonce()) {
		update_option('toastmasters_district',sanitize_text_field($_GET['district']));
		$titles = array('District Director','Program Quality Director','Club Growth Director','Public Relations Manager','Administration Manager','Finance Manager','Logistics Manager','Immediate Past District Director');
		$slugs = array('dd','pqd','cgd','prm','administration','finance','logistics','ipdd');
		$divisions = array('A','B','C','D','E','F','G');
		foreach($divisions as $d) 
		{
			$titles[] = "Division $d Director";
			$slugs[] = "div_".strtolower($d);
		}
		update_option ('wp4toastmasters_officer_titles',$titles);
		update_option( 'wp4toastmasters_officer_slugs',$slugs );
		update_option( 'wp4toastmasters_officer_ids',array() );
		update_option('toastmasters_district',sanitize_text_field($_GET['district']));
	}

	settings_fields( 'wp4toastmasters-settings-group' );
	$wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
	$wp4toastmasters_officer_slugs = get_option( 'wp4toastmasters_officer_slugs' );
	if(empty($wp4toastmasters_officer_slugs))
		$wp4toastmasters_officer_slugs = array();
	if ( ! is_array( $wp4toastmasters_officer_titles ) ) {
		$wp4toastmasters_officer_titles = array( __( 'President', 'rsvpmaker-for-toastmasters' ), __( 'VP of Education', 'rsvpmaker-for-toastmasters' ), __( 'VP of Membership', 'rsvpmaker-for-toastmasters' ), __( 'VP of Public Relations', 'rsvpmaker-for-toastmasters' ), __( 'Secretary', 'rsvpmaker-for-toastmasters' ), __( 'Treasurer', 'rsvpmaker-for-toastmasters' ), __( 'Sgt. at Arms', 'rsvpmaker-for-toastmasters' ), __( 'Immediate Past President', 'rsvpmaker-for-toastmasters' ) );
		$wp4toastmasters_officer_ids = array();
	}
	$wp4toastmasters_member_message  = get_option( 'wp4toastmasters_member_message' );
	$wp4toastmasters_officer_message = get_option( 'wp4toastmasters_officer_message' );
	$wp4toastmasters_disable_email   = get_option( 'wp4toastmasters_disable_email' );
	if ( empty( $wp4toastmasters_disable_email ) ) {
		$wp4toastmasters_disable_email = 0;
	}
	$wp4toastmasters_enable_sync = get_option( 'wp4toastmasters_enable_sync' );

	$wp4toastmasters_agenda_timezone = get_option( 'wp4toastmasters_agenda_timezone' );
	if ( empty( $wp4toastmasters_agenda_timezone ) ) {
		$wp4toastmasters_agenda_timezone = 0;
	}

	$wp4toastmasters_agenda_layout   = get_option( 'wp4toastmasters_agenda_layout' );
	$wp4toastmasters_welcome_message = get_option( 'wp4toastmasters_welcome_message' );
	$tm_signup_count                 = get_option( 'tm_signup_count' );

	$public = get_option( 'blog_public' );

	?>

<h3><?php _e( 'Make the Website Public', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p><input type="radio" name="blog_public" value="1" 
	<?php
	if ( $public ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes, this website is open for business!', 'rsvpmaker-for-toastmasters' ); ?></p>
<p><input type="radio" name="blog_public" value="0" 
	<?php
	if ( ! $public ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( "No, I am still testing, so I don't want this site indexed by Google or other search engines", 'rsvpmaker-for-toastmasters' ); ?>.</p>

<h3><?php _e( 'Enable Email Functions', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p><input type="radio" name="wp4toastmasters_disable_email" value="0" 
	<?php
	if ( ! $wp4toastmasters_disable_email ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes, the email list is active', 'rsvpmaker-for-toastmasters' ); ?></p>
<p><input type="radio" name="wp4toastmasters_disable_email" value="1" 
	<?php
	if ( $wp4toastmasters_disable_email ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'No, do not sent automated email from the website', 'rsvpmaker-for-toastmasters' ); ?>.</p>

<h3><?php _e( 'Sync With WP4Toastmasters.com', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p><input type="radio" name="wp4toastmasters_enable_sync" value="1" 
	<?php
	if ( $wp4toastmasters_enable_sync ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes, sync member speech and role data with other sites', 'rsvpmaker-for-toastmasters' ); ?></p>
	<p><input type="radio" name="wp4toastmasters_enable_sync" value="0" 
	<?php
	if ( ! $wp4toastmasters_enable_sync ) {
		echo ' checked="checked" ';}
	?>
		 /> <?php _e( 'No, do not share data outside of this website', 'rsvpmaker-for-toastmasters' ); ?></p>
	<p><a href="<?php echo admin_url( 'options-general.php?page=wp4toastmasters_settings&reset_sync_count=1' ); ?>"><?php _e( 'Reset sync count', 'rsvpmaker-for-toastmasters' ); ?></a></p>
	<?php
	$tzstring = get_option( 'timezone_string' );
	if ( empty( $tzstring ) ) {
		echo '<p>' . __( 'Timezone not set - defaults to UTC 0 (UK time). Scroll to the top of the list for U.S. timezones', 'rsvpmaker-for-toastmasters' ) . '</p>';
	}

	$current_offset = get_option( 'gmt_offset' );

	$check_zone_info = true;

	// Remove old Etc mappings. Fallback to gmt_offset.
	if ( false !== strpos( $tzstring, 'Etc/GMT' ) ) {
		$tzstring = '';
	}

	if ( empty( $tzstring ) ) { // Create a UTC+- zone if no timezone string exists
		$check_zone_info = false;
		if ( 0 == $current_offset ) {
			$tzstring = 'UTC+0';
		} elseif ( $current_offset < 0 ) {
			$tzstring = 'UTC' . $current_offset;
		} else {
			$tzstring = 'UTC+' . $current_offset;
		}
	}

	?>
<h3><?php _e( 'Timezone', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p><label for="timezone_string"><?php _e( 'Timezone' ); ?></label>
<select id="timezone_string" name="timezone_string">
<optgroup label="U.S. Mainland">
<option value="America/New_York">New York</option>
<option value="America/Chicago">Chicago</option>
<option value="America/Denver">Denver</option>
<option value="America/Los_Angeles">Los Angeles</option>
</optgroup>
	<?php echo wp_timezone_choice( $tzstring ); ?>
</select>
<br /><?php _e( 'Choose a city in the same timezone as you.' ); ?>
</p>

<h3 id="officers"><?php _e( 'Officers List', 'rsvpmaker-for-toastmasters' ); ?></h3>
	<?php
    $root_domain = wpt_get_site_domain(1);
    $domain = wpt_get_site_domain();
	printf('<p>With email forwarding configured, addresses like %s / %s will forward messages to the officer\'s registered email account.</p>',wpt_format_email_forwarder('President'),wpt_format_email_forwarder('vpe'));
	foreach ( $wp4toastmasters_officer_titles as $index => $title ) {
		if ( empty( $title ) ) {
			break;
		}
		$current_officer = (isset($wp4toastmasters_officer_ids[ $index ])) ? $wp4toastmasters_officer_ids[ $index ] : 0;
		$title_slug = (isset($wp4toastmasters_officer_slugs[$index])) ? $wp4toastmasters_officer_slugs[$index] : wpt_officer_title_to_slug ($title); 
		$dropdown = awe_user_dropdown( 'wp4toastmasters_officer_ids[' . $index . ']', $current_officer, true );
		printf( '<p><input type="text" name="wp4toastmasters_officer_titles[%s]" value="%s" /> %s <input type="text" name="wp4toastmasters_officer_slugs[%s]" value="%s" /></p>', $index, $title, $dropdown, $index, $title_slug );
	}
	$limit = $index + 3;
	for ( $index = $index; $index < $limit; $index++ ) {
		$dropdown = awe_user_dropdown( 'wp4toastmasters_officer_ids[' . $index . ']', 0, true );
		printf( '<p><input type="text" name="wp4toastmasters_officer_titles[%s]" value="" /> %s <input type="text" name="wp4toastmasters_officer_slug[%s]" value="" /></p>', $index, $dropdown, $index );
	}
	?>
<p><input type="checkbox" name="make_manager" value="1"><?php _e( 'Grant all officers Manager security status (able to edit website content, agendas, and user accounts.)', 'rsvpmaker-for-toastmasters' ); ?>.</p>

<p><?php _e( 'Officers will be listed at the top of the members page and can also be displayed on the agenda', 'rsvpmaker-for-toastmasters' ); ?>.</p>

<p><?php _e( 'You may also want to appoint a backup administrator (who will have full rights to administer the site) and one or more site managers (who have editing rights and can also add and edit member records). Be judicious in awarding these additional responsibilities.', 'rsvpmaker-for-toastmasters' ); ?>.</p>

	<?php

	$sortmember = array();
	$blogusers  = get_users( 'blog_id=' . get_current_blog_id() );
	foreach ( $blogusers as $user ) {
		$member = get_userdata( $user->ID );

		// if($member->hidden_profile)
		// continue;

		$index = preg_replace( '/[^a-zA-Z]/', '', $member->last_name . $member->first_name . $member->user_login );
		if ( user_can( $user->ID, 'manage_options' ) ) {
			$administrators[ $user->ID ] = $member->first_name . ' ' . $member->last_name;
		} else {
			$sortmember[ $index ] = $member;
			if ( user_can( $user->ID, 'edit_users' ) ) {
				$managers[] = $member->first_name . ' ' . $member->last_name;
			} else {
				$manager_candidates_array[ $index ] = $member;
			}
		}
	}
	if ( ! empty( $sortmember ) ) {
		$candidates = '<option value="0">' . __( 'None', 'rsvpmaker-for-toastmasters' ) . '</option>';
		ksort( $sortmember );
		foreach ( $sortmember as $member ) {
			$candidates .= sprintf( '<option value="%d">%s</option>', $member->ID, $member->first_name . ' ' . $member->last_name );
		}
		printf(
			'<h3>%s</h3>
<select name="wp4toastmasters_admin_ids[]">%s</select>',
			__( 'Make Administrator', 'rsvpmaker-for-toastmasters' ),
			$candidates
		);
	}
	if ( ! empty( $manager_candidates_array ) ) {
		$candidates = '<option value="0">' . __( 'None', 'rsvpmaker-for-toastmasters' ) . '</option>';
		ksort( $manager_candidates_array );
		foreach ( $manager_candidates_array as $member ) {
			$candidates .= sprintf( '<option value="%d">%s</option>', $member->ID, $member->first_name . ' ' . $member->last_name );
		}
		printf(
			'<h3>%s</h3>
<p><select name="wp4toastmasters_manager_ids[]">%s</select></p>
<p><select name="wp4toastmasters_manager_ids[]">%s</select></p>
<p><select name="wp4toastmasters_manager_ids[]">%s</select></p>',
			__( 'Make Manager', 'rsvpmaker-for-toastmasters' ),
			$candidates,
			$candidates,
			$candidates
		);
	}

	$is_primary = false;
	$primary    = wpt_primary_admin();
	if ( ! $primary ) {
		echo '<p>No primary administrator set</p>';
	} elseif ( $current_user->ID == $primary ) {
		echo '<p>You are the primary administrator until you delegate that role to someone else.</p>';
		$is_primary = true;
	} else {
		$userdata = get_userdata( $primary );
		printf( '<p>Primary site administrator: %s</p>', $userdata->display_name );
	}

	echo '<p>Only the primary site administrator can remove administrator rights from other administrator.</p>';

	if ( ! empty( $administrators ) ) {
		printf( '<p>Administrators: %s</p>', implode( ', ', $administrators ) );
		if ( $is_primary || current_user_can('manage_network') ) {
			$remove_admin = '';
			foreach ( $administrators as $user_id => $name ) {
				if ( ( $user_id != $current_user->ID ) && ! user_can( $user_id, 'manage_network' ) ) {
					$remove_admin .= sprintf( '<option value="%d">%s</option>', $user_id, $name );
				}
			}
			if ( ! empty( $remove_admin ) ) {
				printf( '<p>%s <select name="wpt_remove_admin"><option value="0">%s</option>%s</select></p><p>%s</p>', __( 'Remove administrator', 'rsvpmaker-for-toastmasters' ), __( 'No change', 'rsvpmaker-for-toastmasters' ), $remove_admin, __( 'The additional administrator will be demoted to Manager. You can change the roles of users other than administrators on the Users screen.' ) );
			}
		}
		if ( current_user_can('manage_network') || ( ( sizeof( $administrators ) > 1 ) || ! $is_primary ) && ( $is_primary || ( $primary == 0 ) ) ) {
			$primary_admin_options = '';
			foreach ( $administrators as $user_id => $name ) {
				$primary_admin_options .= sprintf( '<option value="%d">%s</option>', $user_id, $name );
			}
			if ( ! empty( $primary_admin_options ) ) {
				printf( '<p>%s <select name="set_wpt_primary_admin"><option value="0">%s</option>%s</select></p>', __( 'Make primary administrator', 'rsvpmaker-for-toastmasters' ), __( 'No change', 'rsvpmaker-for-toastmasters' ), $primary_admin_options );
			}
		}
	}

	if ( ! empty( $managers ) ) {
		printf( '<p>Managers: %s</p>', implode( ', ', $managers ) );
	}
	$contributor_notification = get_option( 'wpt_contributor_notification' );
	if ( empty( $contributor_notification ) ) {
		$contributor_notification = get_option( 'admin_email' );
	}
	echo '<h3>Contributor Notifications</h3><p>' . __( 'Users assigned the Contributor role may submit blog posts for publication, but they must be approved by an author or editor. Who should be notified when contributor posts are submitted for review?', 'rsvpmaker-for-toastmasters' ) . '<p>';
	printf( '<p><input type="text" name="wpt_contributor_notification" value="%s" size="150" /><br /><em>%s</em></p>', $contributor_notification, __( 'One or more email addresses, separated by commas. If you do not want these notifications, enter "none"', 'rsvpmaker-for-toastmasters' ) );

	?>
<h3>Messages</h3>
<p><?php _e( 'Message for Login Page', 'rsvpmaker-for-toastmasters' ); ?><br />
<textarea name="wp4toastmasters_login_message" rows="3" cols="80" class="mce"><?php echo get_option( 'wp4toastmasters_login_message' ); ?></textarea></p>

<p><?php _e( 'Message To Members on Dashboard', 'rsvpmaker-for-toastmasters' ); ?><br />
<textarea name="wp4toastmasters_member_message" rows="3" cols="80" class="mce"><?php echo esc_attr($wp4toastmasters_member_message); ?></textarea></p>

<p><?php _e( 'Message To Officers on Dashboard', 'rsvpmaker-for-toastmasters' ); ?><br />
<textarea name="wp4toastmasters_officer_message" rows="3" cols="80" class="mce"><?php echo esc_attr($wp4toastmasters_officer_message); ?></textarea></p>

	<?php
	$reserved_label = get_option( 'wpt_reserved_role_label' );
	if ( empty( $reserved_label ) ) {
		$reserved_label = 'Ask VPE';
	}
	?>

<h3><?php _e( 'Reserved Role Label', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p>Reserved <input type="text" name="wpt_reserved_role_label" value="<?php echo esc_attr($reserved_label); ?>" /></p>

<h3><?php _e( 'Include Time/Timezone on Agenda Email', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p><input type="radio" name="wp4toastmasters_agenda_timezone" value="1" 
	<?php
	if ( $wp4toastmasters_agenda_timezone ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes', 'rsvpmaker-for-toastmasters' ); ?> <input type="radio" name="wp4toastmasters_agenda_timezone" value="0" 
	<?php
	if ( ! $wp4toastmasters_agenda_timezone ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'No', 'rsvpmaker-for-toastmasters' ); ?>.</p>

	<?php
	// $reminder_options = array('1 hours' => '1 hour before','2 hours' => '2 hours before','3 hours' => '3 hours before','4 hours' => '4 hours before','5 hours' => '5 hours before','6 hours' => '6 hours before','7 hours' => '7 hours before','8 hours' => '8 hours before','9 hours' => '9 hours before','10 hours' => '10 hours before','11 hours' => '11 hours before','12 hours' => '12 hours before','1 days' => '1 day before','2 days' => '2 days before','3 days' => '3 days before','4 days' => '4 days before','5 days' => '5 days before','6 days' => '6 days before');

	$end = 30 * 24;
	for ( $i = 1; $i <= $end; $i++ ) {
		if ( $i > 6 ) {
			$i += 5;
		}
		if ( ( $i >= 24 ) && ! ( $i % 24 ) ) {
			$key = $label = ( $i / 24 ) . ' days';
		} elseif ( $i >= 24 ) {
			$key   = $i . ' hours';
			$label = floor( $i / 24 ) . ' days ' . ( $i % 24 ) . ' hours';
		} else {
			$key   = $i . ' hours';
			$label = $i . ' hours';
		}
		$reminder_options[ $i . ' hours' ] = $label . ' before';
		// printf('<div>%s %s</div>',$i,$label);
	}

	$wp4toast_reminder = get_option( 'wp4toast_reminder' );
	$options           = '';
	foreach ( $reminder_options as $index => $value ) {
		if ( $index == $wp4toast_reminder ) {
			$s = ' selected="selected" ';
		} else {
			$s = '';
		}
		$options .= sprintf( '<option value="%s" %s>%s</option>', $index, $s, $value );
	}

	$wp4toast_reminder2 = get_option( 'wp4toast_reminder2' );

	$options2 = '';
	foreach ( $reminder_options as $index => $value ) {
		if ( $index == $wp4toast_reminder2 ) {
			$s = ' selected="selected" ';
		} else {
			$s = '';
		}
		$options2 .= sprintf( '<option value="%s" %s>%s</option>', $index, $s, $value );
	}

	$wp4toast_reminder_intros = get_option( 'wp4toast_reminder_intros' );

	$options_intros = '';
	foreach ( $reminder_options as $index => $value ) {
		if ( $index == $wp4toast_reminder_intros ) {
			$s = ' selected="selected" ';
		} else {
			$s = '';
		}
		$options_intros .= sprintf( '<option value="%s" %s>%s</option>', $index, $s, $value );
	}

	?>

<h3><?php _e( 'Email Reminders', 'rsvpmaker-for-toastmasters' ); ?></h3>
	<?php
	wp4t_reminders_nudge();
	echo wp4toast_reminders_cron_status();
	?>
<p><?php _e( 'Reminder', 'rsvpmaker-for-toastmasters' ); ?> 
<select name="wp4toast_reminder">
<option value=""><?php _e( 'None', 'rsvpmaker-for-toastmasters' ); ?></option>
	<?php echo $options; ?>
</select>
</p>
<p><?php _e( 'Reminder #2', 'rsvpmaker-for-toastmasters' ); ?> 
<select name="wp4toast_reminder2">
<option value=""><?php _e( 'None', 'rsvpmaker-for-toastmasters' ); ?></option>
	<?php echo $options2; ?>
</select>
<br /><input type="radio" name="wpt_remind_all" value="0" 
	<?php
	$all = get_option( 'wpt_remind_all' );
	if ( empty( $all ) ) {
		echo ' checked="checked" ';}
	?>
 /> Send automated reminders to members with a role
	<br /><input type="radio" name="wpt_remind_all" value="1" 
	<?php
	if ( ! empty( $all ) ) {
		echo ' checked="checked" ';}
	?>
		 /> Send role reminders and <strong>also send a meeting reminder to everyone else</strong>
</p>
<p>
<?php 
$summary_off = (int) get_option('wpt_notification_summary_off');
?>
<input type="radio" name="wpt_notification_summary_off" value="0" <?php if(!$summary_off) echo ' checked="checked" '; ?> > Append summary to reminder of member's specific role
<br>
<input type="radio" name="wpt_notification_summary_off" value="1"  <?php if($summary_off) echo ' checked="checked" '; ?> > Don't append summary to role reminders
</p>

<p><?php _e( 'Send Speech Introductions to Toastmaster of the Day', 'rsvpmaker-for-toastmasters' ); ?> 
<select name="wp4toast_reminder_intros">
<option value=""><?php _e( 'None', 'rsvpmaker-for-toastmasters' ); ?></option>
	<?php echo $options_intros; ?>
</select>

<p>Send written evaluation reminders to evaluators and general evaluator<br>
<?php 
$eval_reminder = (int) get_option('wpt_evaluation_reminder');
?>
<input type="radio" name="wpt_evaluation_reminder" value="1" <?php if($eval_reminder) echo ' checked="checked" '; ?> > ON
<br>
<input type="radio" name="wpt_evaluation_reminder" value="0"  <?php if(!$eval_reminder) echo ' checked="checked" '; ?> > OFF
</p>


<p>See also <a href="edit.php?post_type=rsvpemail&amp;page=rsvpmaker_notification_templates">Email Notification/Reminder Templates</a></p>

<h3><?php _e( 'Agenda Formatting', 'rsvpmaker-for-toastmasters' ); ?></h3>

<p><?php _e( 'Agenda Layout', 'rsvpmaker-for-toastmasters' ); ?> 
	<?php
	wp4toastmasters_agenda_layout_check(); // add layout post if doesn't already exist
	$layout_id = get_option( 'rsvptoast_agenda_layout' );
	if ( $layout_id ) {
		printf( '<br />&nbsp;<a href="%s">%s</a> | <a href="%s">%s</a>', admin_url( 'post.php?action=edit&post=' . $layout_id ), __( 'Edit Custom Agenda Layout', 'rsvpmaker-for-toastmasters' ), admin_url('?reset_agenda_layout=1'),__('Reset to Default','rsvpmaker-for-toastmasters') );
	}
	$layout_mod = get_the_modified_date( 'Y-m-d', $layout_id );
		echo '<p><em>Last updated ' . $layout_mod . '</em></p>';
	echo '<pre id="default_css">' . wpt_default_agenda_css() . '</pre><br /><a id="default_css_show" href="#default_css">Show default CSS styles</a>';
	?>
</p>

<div id="layoutcontrols">
<div>
Agenda Items Font <input class="fontcontrol" type="number" name="wp4toastmasters_agenda_font_main" value="<?php echo get_option( 'wp4toastmasters_agenda_font_main' ); ?>" />
</div>
<div>
Sidebar Items Font <input class="fontcontrol" type="number" name="wp4toastmasters_agenda_font_sidebar" value="<?php echo get_option( 'wp4toastmasters_agenda_font_sidebar' ); ?>" />
</div>
</div>

<p><?php _e( 'Agenda CSS Customization', 'rsvpmaker-for-toastmasters' ); ?> <br />
	<?php agenda_css_customization_form(); ?>
<h3><?php _e( 'Show Stoplight (green/yellow/red) times', 'rsvpmaker-for-toastmasters' ); ?></h3>
	<?php $stoplight = get_option( 'wp4toastmasters_stoplight' ); ?>
<p><input type="radio" name="wp4toastmasters_stoplight" value="1" 
	<?php
	if ( $stoplight == 1 ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes', 'rsvpmaker-for-toastmasters' ); ?></p>
<p><input type="radio" name="wp4toastmasters_stoplight" value="0" 
	<?php
	if ( $stoplight != 1 ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'No', 'rsvpmaker-for-toastmasters' ); ?>.</p>

 <h3><?php _e( 'Show Estimated Times Next to Roles and Notes', 'rsvpmaker-for-toastmasters' ); ?></h3>
	<?php $disable_timeblock = get_option('wp4t_disable_timeblock'); ?>
<p><input type="radio" name="wp4t_disable_timeblock" value="0" 
	<?php
	if ( empty($disable_timeblock) ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes', 'rsvpmaker-for-toastmasters' ); ?></p>
<p><input type="radio" name="wp4t_disable_timeblock" value="1" 
	<?php
	if ( !empty($disable_timeblock) ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'No', 'rsvpmaker-for-toastmasters' ); ?>.</p>

<h3><?php _e( 'Show Speech Introductions on Agenda', 'rsvpmaker-for-toastmasters' ); ?></h3>
	<?php $intros = get_option( 'wp4toastmasters_intros_on_agenda' ); ?>
<p><input type="radio" name="wp4toastmasters_intros_on_agenda" value="1" 
	<?php
	if ( $intros == 1 ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes', 'rsvpmaker-for-toastmasters' ); ?></p>
<p><input type="radio" name="wp4toastmasters_intros_on_agenda" value="0" 
	<?php
	if ( $intros != 1 ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'No', 'rsvpmaker-for-toastmasters' ); ?>.</p>


<h3><?php _e( 'Signup Sheet', 'rsvpmaker-for-toastmasters' ); ?> </h3>
<p><?php _e( 'Future Meetings Displayed', 'rsvpmaker-for-toastmasters' ); ?> <select name="tm_signup_count">
	<?php
	if ( empty( $tm_signup_count ) ) {
		$tm_signup_count = 3;
	}
	for ( $i = 1; $i < 11; $i++ ) {
		$s = ( $i == $tm_signup_count ) ? ' selected="selected" ' : '';
		printf( '<option value="%d" %s>%d</option>', $i, $s, $i );
	}
	?>
</select>
</p>

<h3><?php _e( 'Random Assignment', 'rsvpmaker-for-toastmasters' ); ?> </h3>
	<?php
	$allow_assign = get_option( 'allow_assign' );

	$last_filled_limit   = get_option( 'last_filled_limit' );
	$last_attended_limit = get_option( 'last_attended_limit' );
	$last_filled_option  = $last_attended_option = '<option value="">' . __( 'None', 'rsvpmaker-for-toastmasters' ) . '</option>';
	for ( $i = 7; $i < 90; $i += 7 ) {
		$s                   = ( $i == $last_filled_limit ) ? ' selected="selected" ' : '';
		$last_filled_option .= '<option value="' . $i . '" ' . $s . '>' . $i . '</option>';
	}
	for ( $i = 28; $i < ( 7 * 50 ); $i += 7 ) {
		$s                     = ( $i == $last_attended_limit ) ? ' selected="selected" ' : '';
		$last_attended_option .= '<option value="' . $i . '" ' . $s . '>' . $i . '</option>';
	}
	?>
	<p><?php _e( 'Enable &quot;Suggest Assignments&quot; mode', 'rsvpmaker-for-toastmasters' ); ?> <select name="allow_assign"><option value="">No</option><option value="yes" 
				 <?php
					if ( $allow_assign == 'yes' ) {
						echo 'selected="selcted"';}
					?>
		 >Yes</option><option value="editor" 
		<?php
		if ( $allow_assign == 'editor' ) {
				echo 'selected="selcted"';}
		?>
		 >Only for Editor, Manager, Administrator roles</option></select>
		<br /><em>In this mode, the software semi-randomly assigns members without a role to open roles on the agenda.</em>
	</p>
<p><?php _e( 'Avoid selecting members who have', 'rsvpmaker-for-toastmasters' ); ?><ul><li><?php _e( 'not attended in more than', 'rsvpmaker-for-toastmasters' ); ?> <select name="last_attended_limit"><?php echo $last_attended_option; ?></select> 
			 <?php
				_e( 'days' );
				echo '</li><li>';
				_e( 'or who have filled the same role within', 'rsvpmaker-for-toastmasters' );
				?>
 <select name="last_filled_limit"><?php echo $last_filled_option; ?></select> <?php _e( 'days' ); ?></li></ul> <p><?php _e( 'Note: If you use the random assignment of members to roles, you may wish to have the software favor members who have attended the club recently but have not filled the same role within the last few weeks. This works best after your club has built up some history recording meetings in the software. Recommended reasonable settings: members who have attended more recently than 56 days (2 months) but have not filled the same role in the last 14 days.', 'rsvpmaker-for-toastmasters' ); ?></p>

<h3><?php _e( 'Legacy Manuals', 'rsvpmaker-for-toastmasters' ); ?> </h3>
	<?php
	$legacy = get_option( 'show_legacy_manuals' );
	if ( $legacy == 'yes' ) {
		$yeschecked = ' checked="checked" ';
		$nochecked  = '';
	} else {
		$yeschecked = '';
		$nochecked  = ' checked="checked" ';
	}

	printf( '<p>%s<br /><input type="radio" name="show_legacy_manuals" value="yes" %s /> %s <input type="radio" name="show_legacy_manuals" value="no" %s /> %s</p>', __( 'Show manuals from the legacy educational program (pre-Pathways) on speech signup drop-down list.', 'rsvpmaker-for-toastmasters' ), $yeschecked, __( 'Yes', 'rsvpmaker-for-toastmasters' ), $nochecked, __( 'No', 'rsvpmaker-for-toastmasters' ) );
	?>

<h3><?php _e( 'Automatically Lock Agenda', 'rsvpmaker-for-toastmasters' ); ?> </h3>
<p><select name="wpt_agenda_lock_policy">
	<?php
	$lock = (int) get_option( 'wpt_agenda_lock_policy' );
	for ( $i = 0; $i <= 24; $i++ ) {
		$s     = ( $i == $lock ) ? ' selected="selected" ' : '';
		$label = ( $i == 0 ) ? 'No lock' : $i . ' hours before meeting';
		printf( '<option value="%s" %s>%s</option>', $i, $s, $label );
	}
	for ( $i = 30; $i <= 72; $i += 6 ) {
		$s     = ( $i == $lock ) ? ' selected="selected" ' : '';
		$label = ( ( $i == 48 ) || ( $i == 72 ) ) ? $i . ' hours (' . ( $i / 24 ) . ' days) before' : $i . ' hours before meeting';
		printf( '<option value="%s" %s>%s</option>', $i, $s, $label );
	}

	?>
</select>
<br /><em>You can set the agenda to be locked against changes one or more hours before the meeting start time. An administrator can remove the lock.</em>
</p>

<h3 id="welcome_message"><?php _e( 'New Member Welcome Message', 'rsvpmaker-for-toastmasters' ); ?> </h3>
	<?php
	if ( $wp4toastmasters_welcome_message && ( $wpost = get_post( $wp4toastmasters_welcome_message ) ) ) {
		$is_blank = ( $wpost->post_content ) ? '' : '(blank)';
	} else {
		$wp4toastmasters_welcome_message = wp_insert_post(
			array(
				'post_title'  => 'Welcome to ' . get_option( 'blogname' ),
				'post_type'   => 'page',
				'post_status' => 'private',
			)
		);
		update_option( 'wp4toastmasters_welcome_message', $wp4toastmasters_welcome_message );
		$is_blank = '(blank)';
	}
	printf( '<p>Edit %s %s</p>', rsvpmaker_edit_link( $wp4toastmasters_welcome_message, '', true ), $is_blank );
	?>
<p><em>The content of this page will be appended to the message sent when you add a new member user account.</em></p>

<h3><?php _e( 'Beta Software', 'rsvpmaker-for-toastmasters' ); ?></h3>
	<?php $wp4toastmasters_beta = get_option( 'wp4toastmasters_beta' ); ?>
<p><input type="radio" name="wp4toastmasters_beta" value="1" 
	<?php
	if ( $wp4toastmasters_beta ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'Yes, enable beta test features', 'rsvpmaker-for-toastmasters' ); ?></p>
<p><input type="radio" name="wp4toastmasters_beta" value="0" 
	<?php
	if ( ! $wp4toastmasters_beta ) {
		echo ' checked="checked" ';}
	?>
	 /> <?php _e( 'No, do not turn on beta features', 'rsvpmaker-for-toastmasters' ); ?>.</p>
	<?php
do_action( 'toastmasters_settings_extra' );
submit_button();
rsvpmaker_nonce(); ?>
</form>

</section>
<section class="toastmasters-admin"  id="security">
	<?php tm_security_caps(); ?>
</section>
<section class="toastmasters-admin"  id="rules">
<p><em>Optional rules for how your club operates.</em></p>
	<?php toastmasters_rule_setting(); ?>
</section>
<section class="toastmasters-admin" id="notifications">
<?php
if(isset($_POST['wpt_notification_emails'])) {
	update_option('wpt_notification_emails', sanitize_text_field($_POST['wpt_notification_emails']) );
	update_option('wpt_notification_leader', isset($_POST['wpt_notification_leader']) );
	if(isset($_POST['wpt_notification_titles'])) {
		$titles = array_map('sanitize_text_field', $_POST['wpt_notification_titles']);
		update_option('wpt_notification_titles',$titles);
	}
	else
		update_option('wpt_notification_titles',array());
}

$titles = get_option('wpt_notification_titles');
printf('<form method="post" action="%s">',admin_url('options-general.php?page=wp4toastmasters_settings'));
echo '<input type="hidden" name="tab" value="notifications">';
$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
echo '<p>'.__('Who gets email notifications of role signups?','rsvpmaker-for-toastmasters').'</p>';
$checked = !empty(get_option("wpt_notification_leader")) ? ' checked="checked" ': '';
printf('<div><input type="checkbox" name="wpt_notification_leader" value="1" %s>%s</div>',$checked,__('Meeting Leader (Toastmaster of the Day or Contest Master)','rsvpmaker-for-toastmasters'));
if($wp4toastmasters_officer_titles)
{
	foreach($wp4toastmasters_officer_titles as $title) {
		if(empty($title))
			continue;
		$checked = '';
		$email = toastmasters_officer_email_by_title( $title );
		if(empty($email))
			$email = __('member id / email not set','rsvpmaker-for-toastmasters');
		if(is_array($titles)) {
			if(in_array($title,$titles))
			$checked = ' checked="checked" ';
		}
		elseif(strpos($title,'Education') || strpos($title,__('Education','rsvpmaker-for-toastmasters')) )
			$checked = ' checked="checked" ';//defaults if this has not been set
		printf('<div><input type="checkbox" name="wpt_notification_titles[]" value="%s" %s>%s (%s)</div>',$title,$checked,$title,$email);
	}
}
printf('<p>%s <input name="wpt_notification_emails" value="%s" ></p>',__('Additional email addresses','rsvpmaker-for-toastmasters'),esc_attr(get_option('wpt_notification_emails')));
submit_button();
rsvpmaker_nonce();
?>
</form>
</section>
</div>

</div>
	<?php
}

function online_meeting_settings() {
	?>
<p>Jitsi online meeting integration, embedded in a web page with a speaker timing lights function, is enabled by default. You can remove it from the agenda menu by selecting None. For our current (2021) advice on using the timing lights feature with Zoom, see this <a href="https://www.wp4toastmasters.com/2021/02/02/showing-the-online-timer-in-zoom-with-obs-studio-2021-tutorial/">blog post</a>.</p>
	<?php
	if ( isset( $_POST['tm_online_meeting'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$online = sanitize_text_field($_POST['tm_online_meeting']);
		update_option( 'tm_online_meeting', $online );
		echo '<div class="updated"><p>Online meeting settings updated</p></div>';
	} else {
		$online = get_option( 'tm_online_meeting' );
	}

	$platform = ( empty( $online['platform'] ) ) ? 'Jitsi' : sanitize_text_field($online['platform']);
	?>
	<form action="<?php echo admin_url( 'options-general.php?page=wp4toastmasters_settings' ); ?>" method="post">
	<p>Platform
	<br /><select name="tm_online_meeting[platform]">
	<option value="Jitsi" 
	<?php
	if ( $platform == 'Jitsi' ) {
		echo ' selected="selected" ';}
	?>
		 >Jitsi</option>
	<option value="None" 
	<?php
	if ( $platform == 'None' ) {
		echo ' selected="selected" ';}
	?>
		 >None</option>
	</select>
	</p>
	
	<p><button>Submit</button></p>
	<?php rsvpmaker_nonce(); ?>
	</form>
	<?php

}

function toastmasters_rule_setting() {
	$security_roles = array( 'manager', 'editor', 'author', 'contributor', 'subscriber' );

	if ( isset( $_POST['signup_security'] ) || isset( $_POST['toastmasters_rules'] ) ) {
		echo '<div class="updated"><p>Updated Custom Rules</p></div>';
	}

	if ( isset( $_POST['signup_security'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $security_roles as $role ) {
				$tm_role = get_role( $role );
			if ( isset( $_POST['signup_security'][ $role ] ) ) {
				$tm_role->add_cap( 'edit_signups' );
			} else {
				$tm_role->remove_cap( 'edit_signups' );
			}
		}

		if ( isset( $_POST['edit_signups_meeting_roles'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			update_option( 'edit_signups_meeting_roles', array_map('sanitize_text_field',$_POST['edit_signups_meeting_roles']) );
		} else {
			delete_option( 'edit_signups_meeting_roles' );
		}
	}
	if ( isset( $_POST['toastmasters_rules'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		update_option( 'toastmasters_rules', array_map('sanitize_text_field',$_POST['toastmasters_rules']) );
	}

	$rules = get_option( 'toastmasters_rules' );
	if ( empty( $rules ) ) {
		$rules['cost']  = 2;
		$rules['start'] = 4;
	}
	if ( empty( $rules['start_date'] ) ) {
		$rules['start_date'] = date( 'Y' ) . '-01-01';
	}

	printf( '<form method="post" action="%s">', admin_url( 'options-general.php?page=wp4toastmasters_settings' ) );
	echo '<input type="hidden" name="tab" value="rules">';
	?>
<h3>Access to Edit Signups</h3>
<p>Security roles, in addition to administrator who can edit other members' role signups:</p>
	<?php
	foreach ( $security_roles as $role ) {
		$r       = get_role( $role );
		$cap     = $r->has_cap( 'edit_signups' );
		$ck      = ( $cap ) ? '<input type="checkbox" name="signup_security[' . $role . ']" value="1" checked="checked"/> ' : '<input type="checkbox"  name="signup_security[' . $role . ']" value="1" />';
		$regular = ( $role == 'subscriber' ) ? ' (Regular member)' : '';
		printf( '<p>%s %s %s</p>', $ck, ucfirst( $role ), $regular );
	}
	?>
<p>Meeting-specific roles who can edit other members' role signups:</p>
	<?php
	$meeting_roles              = array( 'Toastmaster of the Day', 'General Evaluator' );
	$edit_signups_meeting_roles = get_option( 'edit_signups_meeting_roles' );
	foreach ( $meeting_roles as $role ) {
		{
		$key = wp4t_fieldbase($role,1);
		$cap = ( ! empty( $edit_signups_meeting_roles[ $role ] ) );
		$ck  = ( $cap ) ? '<input type="checkbox" name="edit_signups_meeting_roles[' . $role . ']" value="' . $key . '" checked="checked"/> ' : '<input type="checkbox"  name="edit_signups_meeting_roles[' . $role . ']" value="' . $key . '"/> ';
		printf( '<p>%s %s</p>', $ck, ucfirst( $role ) );
		}
	}
	?>
<h3>Points System</h3>
<p>You can measure how well members balance their participation in the club using a system where speakers earn 1 point for each supporting role they fill in your meetings and are charged points for each speech they give. Optionally, members can be encouraged to pick another role or prevented from signing up for a speaker role if their score falls below zero. If neither of those options is selected, the information will simply be available on a <a href="<?php echo admin_url( 'admin.php?page=toastmasters_reports_dashboard&report=speaker' ); ?>">Speaker Points Report</a> club leaders can consult for a snapshot of member participation.</p>
<p><select name="toastmasters_rules[points]" >
<option value="">Use for reporting only</option>
<option value="warn" 
	<?php
	if ( $rules['points'] == 'warn' ) {
		echo ' selected="selected" ';}
	?>
	 >Warn member if score < 0</option>
<option value="prevent" 
	<?php
	if ( $rules['points'] == 'prevent' ) {
		echo ' selected="selected" ';}
	?>
	>Prevent self-service signup for score < 0</option>
<select></p>
<p><strong>Scoring rules</strong></p>
<p>Start count from <input type="text" name="toastmasters_rules[start_date]" value="<?php echo esc_attr($rules['start_date']); ?>" > <em>YEAR-MONTH-DAY format</em></p>
<p>Members start with <input type="text" name="toastmasters_rules[start]" value="<?php echo esc_attr($rules['start']); ?>" > points</p>
<p>Each speech signup uses <input type="text" name="toastmasters_rules[cost]" value="<?php echo esc_attr($rules['cost']); ?>" > points<br />
<em>Example: If you would like members to fill supporting roles about twice as often as they speak, you would make the value above 2. If you give each member 4 points to start with, an eager new member can still give an Ice Breaker and another speech without immediately needing to fill other roles.</em></p>
	<?php
	if ( isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] == 'rules' ) {
		?>
<input type="hidden" id="activetab" value="rules" />
		<?php
	}
	?>
<input type="hidden" name="tab" value="rules">
	<?php
	submit_button();
	rsvpmaker_nonce();
	echo '</form>';
}

function agenda_css_customization_form() {
	?>
<p><textarea rows="3" cols="80" name="wp4toastmasters_agenda_css"><?php echo get_option( 'wp4toastmasters_agenda_css' ); ?></textarea>
<br /><?php _e( 'Examples', 'rsvpmaker-for-toastmasters' ); ?>:<br /><code>p, div, li {font-family: Georgia, serif;}</code> - <?php _e( 'change the font for all text', 'rsvpmaker-for-toastmasters' ); ?>
<br /><code>#agenda, #agenda p, #agenda div, #agenda li  {font-family: Georgia, serif;font-style:italic}</code> - <?php _e( 'change the font of the actual agenda but not the sidebar content', 'rsvpmaker-for-toastmasters' ); ?>
<br /><code>#agenda-sidebar, #agenda-sidebar p, #agenda-sidebar div, #agenda-sidebar li  {font-size: 12px; font-family: Georgia, serif; }</code> - <?php _e( 'change the font for the agenda sidebar only', 'rsvpmaker-for-toastmasters' ); ?>
<br /><code>#agenda {border-left: thick dotted #000;}</code> - <?php _e( 'add a dotted black line to the left of sidebar', 'rsvpmaker-for-toastmasters' ); ?>
<br /><code>.titleblock {color:blue}</code> - change the font color of the header text
</p>
<p>When the agenda is displayed in "Show" rather than print mode, id="show" is added to the body tag. To increase the font for online viewing but not for print, you could do
<br /><code>#show p, #show div, #show li {font-size: 14px;}</code> or 
<br /><code>#show #agenda p, #show #agenda div, #show #agenda li {font-size: 14px;}</code>
	<?php
}

// call register settings function

function wptoast_reminder_clear() {
	$cron = _get_cron_array();
	if ( empty( $cron ) ) {
		return;
	}
	$newcron = array();
	foreach ( $cron as $timestamp => $events ) {
		foreach ( $events as $slug => $details ) {
			if ( $slug == 'wp4toast_reminders_cron' ) {
				$item = array_pop( $details );
				if ( isset( $item['args'] ) ) {
					$cronargs[] = $item['args'];
				}
			}
		}
	}

	if ( ! empty( $cronargs ) ) {
		foreach ( $cronargs as $args ) {
			wp_clear_scheduled_hook( 'wp4toast_reminders_cron', $args );
		}
	}
}

function register_wp4toastmasters_settings() {
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_officer_titles' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_officer_ids' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_officer_slugs' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_login_message' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_member_message' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_officer_message' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_disable_email' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_enable_sync' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_css' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_welcome_message' );
	register_setting( 'wp4toastmasters-settings-group', 'timezone_string' );
	register_setting( 'wp4toastmasters-settings-group', 'blog_public' );
	register_setting( 'wp4toastmasters-settings-group', 'tm_security' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_beta' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_font_main' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_font_sidebar' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_stoplight' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_intros_on_agenda' );
	register_setting( 'wp4toastmasters-settings-group', 'tm_signup_count' );
	register_setting( 'wp4toastmasters-settings-group', 'last_filled_limit' );
	register_setting( 'wp4toastmasters-settings-group', 'last_attended_limit' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toast_reminder' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toast_reminder2' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toast_reminder_intros' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_remind_all' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_notification_summary_off' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_reserved_role_label' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_timezone' );
	register_setting( 'wp4toastmasters-settings-group', 'allow_assign' );
	register_setting( 'wp4toastmasters-settings-group', 'hide_planner_promo' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_contributor_notification' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_agenda_lock_policy' );
	register_setting( 'wp4toastmasters-settings-group', 'show_legacy_manuals' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4t_disable_timeblock' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_evaluation_reminder' );

	if ( isset( $_POST['wp4toast_reminder'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
				// clear cron
			wptoast_reminder_clear();
		if ( ! empty( $_POST['wp4toast_reminder'] ) ) {
				$p = explode( ' ', sanitize_text_field($_POST['wp4toast_reminder']) );
			if ( $p[1] == 'hours' ) {
				$hours = $p[0];
			} else {
				$hours = $p[0] * 24;
			}

				$fudge  = $hours + 1;
				$future = get_future_events( " (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ", 1 );
			if ( sizeof( $future ) ) {
				$next = $future[0];
				$timestamp = rsvpmaker_strtotime( $next->datetime . ' -' . $hours . ' hours' );
				wp_schedule_event( $timestamp, 'weekly', 'wp4toast_reminders_cron', array( $next->ID . ':' . $hours ) );
				update_option( 'wp4toast_reminders_cron', 1 );
			}
		}
			// adjust for time change, which happens on a sunday
			wp_clear_scheduled_hook( 'wp4toast_reminders_dst_fix' );
			wp_schedule_event( strtotime( 'next Sunday 05:00:00' ), 'weekly', 'wp4toast_reminders_dst_fix' );
			$previous = get_option( 'wp4toast_reminder2' );
		if ( ! empty( $previous ) ) {
			$p = explode( ' ', $previous );
			if ( $p[1] == 'hours' ) {
				$hours = $p[0];
			} else {
				$hours = $p[0] * 24;
			}
			wp_clear_scheduled_hook( 'wp4toast_reminders_cron', array( $hours ) );
		}
		if ( ! empty( $_POST['wp4toast_reminder2'] ) ) {
				$p = explode( ' ', sanitize_text_field($_POST['wp4toast_reminder2']) );
			if ( $p[1] == 'hours' ) {
				$hours = $p[0];
			} else {
				$hours = $p[0] * 24;
			}

				$fudge  = $hours + 1;
				$future = get_future_events( " (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ", 1 );
			if ( sizeof( $future ) ) {
				$next = $future[0];
				rsvpmaker_fix_timezone();
				wp_schedule_event( strtotime( $next->datetime . ' -' . $hours . ' hours' ), 'weekly', 'wp4toast_reminders_cron', array( $next->ID . ':' . $hours ) );
				update_option( 'wp4toast_reminders_cron', 1 );
			}
		}
		if ( ! empty( $_POST['wp4toast_reminder_intros'] ) ) {
			$p = explode( ' ', sanitize_text_field($_POST['wp4toast_reminder_intros']) );
		if ( $p[1] == 'hours' ) {
			$hours = $p[0];
		} else {
			$hours = $p[0] * 24;
		}

			$fudge  = $hours + 1;
			$future = get_future_events( " (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ", 1 );
		if ( sizeof( $future ) ) {
			$next = $future[0];
		}
	}

	}
	if ( isset( $_POST['set_layout_default'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$agenda['ID']           = (int) $_POST['set_layout_default'];
		$agenda['post_content'] = wpt_custom_layout_default();
		wp_update_post( $agenda );
	}
}

add_action('wp4toast_reminders_intros','wp4toast_reminders_intros',10,2);
function wp4toast_reminders_intros($post_id, $hours = 0) {
if(!$hours)
	return;
global $wpdb, $rsvp_options;
$sql = "SELECT * FROM ".$wpdb->prefix."rsvpmaker_event WHERE event=$post_id AND date > NOW() AND date <= DATE_ADD(NOW(), INTERVAL $hours HOUR) ";
$row = $wpdb->get_row($sql);
//rsvpmaker_debug_log($sql,'speech intros sql');
//rsvpmaker_debug_log($row,'speech intros row');
if($row)
	{
		$date = rsvpmaker_date($rsvp_options['long_date'], (int) $row->ts_start);
		$msg = '';
		echo $sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post_id AND meta_key LIKE '_role_Speaker%' AND meta_value > 0";
		$results = $wpdb->get_results($sql);
		foreach($results as $row) {
			if($row->meta_value > 0)
				$msg .= '<div style="margin-bottom: 20px; padding: 10px; border: thin dotted #000;">' . wpautop( speech_intro_data( $row->meta_value, $post_id, $row->meta_key ) ) . '</div>';
		}
		if(!empty($msg))
		{
			$meeting_leader_tag = '_Toastmaster_of_the_Day_1';
			$meeting_leader_id = get_post_meta($post_id,$meeting_leader_tag,true);
			if($meeting_leader_id)
				{
				$user = get_userdata($meeting_leader_id);
				if($user) {
					$mail['to'] = $user->user_email;
					$mail['subject'] = __('Speech introductions for','rsvpmaker-for-toastmasters').' '.$date;
					$mail['html'] = $msg.'<p>Sent to meeting leader: '.$user->display_name.'</p>';
					rsvpmailer($mail);	
				}

				}
			$wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
			$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
			foreach($wp4toastmasters_officer_titles as $index => $title) {
				if(strpos($title,__('Education','rsvpmaker-for-toastmasters')))
				{
					if(!empty($wp4toastmasters_officer_ids[$index])) {
						$vpe_id = $wp4toastmasters_officer_ids[$index];
						$vpe = get_userdata($vpe_id);
						if($vpe) {
							$mail['to'] = $vpe->user_email;
							$mail['subject'] = __('Speech introductions for','rsvpmaker-for-toastmasters').' '.$date;
							$mail['html'] = $msg.'<p>Sent to VPE: '.$vpe->display_name.'</p>';
							if(!empty($user->display_name))
								$mail['html'] .= '<p>Also sent to meeting leader: '.$user->display_name.'</p>';
							rsvpmailer($mail);
						}
					}
				}
			}

		}
	}
}

function wp4toast_reminders_cron_status() {
	global $rsvp_options;
	$cron   = get_option( 'cron' );
	$output = '';
	// rsvpmaker_fix_timezone();
	$post = next_toastmaster_meeting();
	if ( empty( $post ) ) {
		return 'No future meeting events registered';
	}
	if(empty($post->ts_start))
		$t = rsvpmaker_strtotime( $post->date );
	else
		$t = (int) $post->ts_start;
	$output .= sprintf( '<p>Next meeting: %s</p>', rsvpmaker_date( $rsvp_options['long_date'] . ' ' . $rsvp_options['time_format'], $t ) );
	foreach ( $cron as $ts => $item ) {
		if ( isset( $item['wp4toast_reminders_cron'] ) ) {
			$output .= sprintf( '<p>Scheduled reminder %s</p>', rsvpmaker_date( $rsvp_options['long_date'] . ' ' . $rsvp_options['time_format'], (int) $ts ) );
		}
	}
	return $output;
}

add_action( 'wp4toast_reminders_dst_fix', 'wp4toast_reminders_dst_fix', 10, 1 );
function wp4toast_reminders_dst_fix( $args = array() ) {
			$previous = get_option( 'wp4toast_reminder' );
	if ( ! empty( $previous ) ) {
		$p = explode( ' ', $previous );
		if ( $p[1] == 'hours' ) {
			$hours = $p[0];
		} else {
			$hours = $p[0] * 24;
		}
		wp_clear_scheduled_hook( 'wp4toast_reminders_cron', array( $hours ) );
			$p = explode( ' ', $previous );
		if ( $p[1] == 'hours' ) {
			$hours = $p[0];
		} else {
			$hours = $p[0] * 24;
		}

			$fudge  = $hours + 1;
			$future = get_future_events( " (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ", 1 );
		if ( sizeof( $future ) ) {
				$next = $future[0];
				rsvpmaker_fix_timezone();
				wp_schedule_event( strtotime( $next->datetime . ' -' . $hours . ' hours' ), 'weekly', 'wp4toast_reminders_cron', array( $next->ID . ':' . $hours ) );
		}
	}
			$previous = get_option( 'wp4toast_reminder2' );
	if ( ! empty( $previous ) ) {
		$p = explode( ' ', $previous );
		if ( $p[1] == 'hours' ) {
			$hours = $p[0];
		} else {
			$hours = $p[0] * 24;
		}
		wp_clear_scheduled_hook( 'wp4toast_reminders_cron', array( $hours ) );
			$p = explode( ' ', $previous );
		if ( $p[1] == 'hours' ) {
			$hours = $p[0];
		} else {
			$hours = $p[0] * 24;
		}

			$fudge = $hours + 1;
		if ( ! empty( $next ) ) {
				wp_schedule_event( rsvpmaker_strtotime( $next->datetime . ' -' . $hours . ' hours' ), 'weekly', 'wp4toast_reminders_cron', array( $next->ID . ':' . $hours ) );
		}
	}
}

function wpt_default_agenda_css( $slug = '' ) {
	$segment['stoplight'] = '.stoplight_block {
display: inline-block; margin-bottom: 3px;
}
';

	if ( ! empty( $slug ) ) {
		if ( ! empty( $segment[ $slug ] ) ) {
			return $segment[ $slug ];
		}
		return;
	}

	return '
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	border: 0;
	font-family: inherit;
	font-size: 100%;
	font-style: inherit;
	font-weight: inherit;
	margin: 0;
	outline: 0;
	padding: 0;
	vertical-align: baseline;
}
a:link, a:visited {
	color: #004165;
}
body, p, div, td, th, li {
font-size: 12px;
line-height: 1.3;
font-family:"Times New Roman", Times, serif;
margin-left: 5px;
margin-right: 5px;
}
p, td, th, div {
margin-bottom: 2px;
}
blockquote {
margin-left: 10px;
}
h1 {font-size: 24px;  font-weight: bold;  margin-bottom: 5px;}
h2 {font-size: 18px; font-weight: bold; margin-bottom: 5px;}
h3 {font-size: 18px; font-weight: bold; margin-bottom: 5px; font-style: italic;}
td {vertical-align: top;}
strong { font-weight: bold; }
em {font-style: italic; }

@page Section1
   {size:8.5in 11.0in; 
   margin: 0.5in; 
   mso-header-margin:.5in;
   mso-footer-margin:.5in; mso-paper-source:0;}
 div.Section1
 {
page:Section1;
width: 750px;
 }
div, p, table, blockquote {
max-width: 750px;
}
#banner {
height: 80px;
}
#sidebar {
padding-right: 10px;
width: 25%;
}
#agenda {
padding: 0 10px 0 10px;
border-left: medium solid #DDD;
}
.role {
font-weight: bold;
}
.role_agenda_note {
font-style: italic;
}
.role-agenda-item ul {
  list-style-type: none;
  padding-left: 0;
  margin-left: 0;
}
p.speechtime {
	text-align: center;
}
.officers_label {font-weight: bold;}
.officer_entity {margin-top: 10px;}
p.agenda_note {padding-left: 0;}
span.timeblock, span.notime {display: inline-block; width: 6em; margin: 0px; font-weight: bold; text-indent: 0}
#agenda>div.indent {padding-left: 20px;}
p.signup_note, .hideonagenda, .wp-block-wp4toastmasters-signupnote {display: none;}

/**
 * The following styles get applied both on the front of your site
 * and in the editor.
 *
 * Replace them with your own styles or remove the file completely.
 */

table.speaker-evaluator-table, .speaker-evaluator-table td {
	border: thin solid #999;
	border-collapse: collapse;
}
.speakernumber {
	width: 20px;
	text-align: center;
}
.speaker-column, .evaluator-column {
	width: 250px;
	font-weight: bold;
}
table.speaker-evaluator-table td {
	padding: 3px;
	padding-left: 8px;
}

/*
alignment tweaks
*/
.speaker-details {
    margin-left: 6em;
}
.role_agenda_note, .role-timing {
    margin-left: 6em;
}
#agenda-sidebar {max-width: 175px; padding-right: 15px;}

/* selected Gutenberg block css */

.wp-block-columns {
	display: flex;
	margin-bottom: 28px;
	flex-wrap: nowrap; }
/*	@media (min-width: 782px) {
	  .wp-block-columns {
		flex-wrap: nowrap; } }

div.wp-block-column:first-of-type {
	flex-basis: 200px;
}
*/
  .wp-block-column {
	flex-grow: 1;
	min-width: 0;
	word-break: break-word;
	overflow-wrap: break-word; }
	@media (max-width: 599px) {
	  .wp-block-column {
		flex-basis: 100% !important; } }
	@media (min-width: 600px) {
	  .wp-block-column {
		flex-basis: calc(50% - 16px);
		flex-grow: 0; }
		.wp-block-column:nth-child(even) {
		  margin-left: 32px; } }
	@media (min-width: 782px) {
	  .wp-block-column:not(:first-child) {
		margin-left: 32px; } }
  
  /**
   * All Columns Alignment
   */
  .wp-block-columns.are-vertically-aligned-top {
	align-items: flex-start; }
  
  .wp-block-columns.are-vertically-aligned-center {
	align-items: center; }
  
  .wp-block-columns.are-vertically-aligned-bottom {
	align-items: flex-end; }
  
  /**
   * Individual Column Alignment
   */
  .wp-block-column.is-vertically-aligned-top {
	align-self: flex-start; }
  
  .wp-block-column.is-vertically-aligned-center {
	-ms-grid-row-align: center;
		align-self: center; }
  
  .wp-block-column.is-vertically-aligned-bottom {
	align-self: flex-end; }
  
  .wp-block-gallery,
  .blocks-gallery-grid {
	display: flex;
	flex-wrap: wrap;
	list-style-type: none;
	padding: 0;
	margin: 0; }
	.wp-block-gallery .blocks-gallery-image,
	.wp-block-gallery .blocks-gallery-item,
	.blocks-gallery-grid .blocks-gallery-image,
	.blocks-gallery-grid .blocks-gallery-item {
	  margin: 0 16px 16px 0;
	  display: flex;
	  flex-grow: 1;
	  flex-direction: column;
	  justify-content: center;
	  position: relative; }
	  .wp-block-gallery .blocks-gallery-image figure,
	  .wp-block-gallery .blocks-gallery-item figure,
	  .blocks-gallery-grid .blocks-gallery-image figure,
	  .blocks-gallery-grid .blocks-gallery-item figure {
		margin: 0;
		height: 100%; }
		@supports ((position: -webkit-sticky) or (position: sticky)) {
		  .wp-block-gallery .blocks-gallery-image figure,
		  .wp-block-gallery .blocks-gallery-item figure,
		  .blocks-gallery-grid .blocks-gallery-image figure,
		  .blocks-gallery-grid .blocks-gallery-item figure {
			display: flex;
			align-items: flex-end;
			justify-content: flex-start; } }
	  .wp-block-gallery .blocks-gallery-image img,
	  .wp-block-gallery .blocks-gallery-item img,
	  .blocks-gallery-grid .blocks-gallery-image img,
	  .blocks-gallery-grid .blocks-gallery-item img {
		display: block;
		max-width: 100%;
		height: auto; }
	  .wp-block-gallery .blocks-gallery-image img,
	  .wp-block-gallery .blocks-gallery-item img,
	  .blocks-gallery-grid .blocks-gallery-image img,
	  .blocks-gallery-grid .blocks-gallery-item img {
		width: 100%; }
		@supports ((position: -webkit-sticky) or (position: sticky)) {
		  .wp-block-gallery .blocks-gallery-image img,
		  .wp-block-gallery .blocks-gallery-item img,
		  .blocks-gallery-grid .blocks-gallery-image img,
		  .blocks-gallery-grid .blocks-gallery-item img {
			width: auto; } }
	  .wp-block-gallery .blocks-gallery-image figcaption,
	  .wp-block-gallery .blocks-gallery-item figcaption,
	  .blocks-gallery-grid .blocks-gallery-image figcaption,
	  .blocks-gallery-grid .blocks-gallery-item figcaption {
		position: absolute;
		bottom: 0;
		width: 100%;
		max-height: 100%;
		overflow: auto;
		padding: 40px 10px 9px;
		color: #fff;
		text-align: center;
		font-size: 13px;
		background: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 0, rgba(0, 0, 0, 0.3) 70%, transparent); }
		.wp-block-gallery .blocks-gallery-image figcaption img,
		.wp-block-gallery .blocks-gallery-item figcaption img,
		.blocks-gallery-grid .blocks-gallery-image figcaption img,
		.blocks-gallery-grid .blocks-gallery-item figcaption img {
		  display: inline; }
	.wp-block-gallery.is-cropped .blocks-gallery-image a,
	.wp-block-gallery.is-cropped .blocks-gallery-image img,
	.wp-block-gallery.is-cropped .blocks-gallery-item a,
	.wp-block-gallery.is-cropped .blocks-gallery-item img,
	.blocks-gallery-grid.is-cropped .blocks-gallery-image a,
	.blocks-gallery-grid.is-cropped .blocks-gallery-image img,
	.blocks-gallery-grid.is-cropped .blocks-gallery-item a,
	.blocks-gallery-grid.is-cropped .blocks-gallery-item img {
	  width: 100%; }
	  @supports ((position: -webkit-sticky) or (position: sticky)) {
		.wp-block-gallery.is-cropped .blocks-gallery-image a,
		.wp-block-gallery.is-cropped .blocks-gallery-image img,
		.wp-block-gallery.is-cropped .blocks-gallery-item a,
		.wp-block-gallery.is-cropped .blocks-gallery-item img,
		.blocks-gallery-grid.is-cropped .blocks-gallery-image a,
		.blocks-gallery-grid.is-cropped .blocks-gallery-image img,
		.blocks-gallery-grid.is-cropped .blocks-gallery-item a,
		.blocks-gallery-grid.is-cropped .blocks-gallery-item img {
		  height: 100%;
		  flex: 1;
		  -o-object-fit: cover;
			 object-fit: cover; } }
	.wp-block-gallery .blocks-gallery-image,
	.wp-block-gallery .blocks-gallery-item,
	.blocks-gallery-grid .blocks-gallery-image,
	.blocks-gallery-grid .blocks-gallery-item {
	  width: calc((100% - 16px) / 2); }
	  .wp-block-gallery .blocks-gallery-image:nth-of-type(even),
	  .wp-block-gallery .blocks-gallery-item:nth-of-type(even),
	  .blocks-gallery-grid .blocks-gallery-image:nth-of-type(even),
	  .blocks-gallery-grid .blocks-gallery-item:nth-of-type(even) {
		margin-right: 0; }
	.wp-block-gallery.columns-1 .blocks-gallery-image,
	.wp-block-gallery.columns-1 .blocks-gallery-item,
	.blocks-gallery-grid.columns-1 .blocks-gallery-image,
	.blocks-gallery-grid.columns-1 .blocks-gallery-item {
	  width: 100%;
	  margin-right: 0; }
	@media (min-width: 600px) {
	  .wp-block-gallery.columns-3 .blocks-gallery-image,
	  .wp-block-gallery.columns-3 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-3 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-3 .blocks-gallery-item {
		width: calc((100% - 16px * 2) / 3);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-3 .blocks-gallery-image,
		  .wp-block-gallery.columns-3 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-3 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-3 .blocks-gallery-item {
			width: calc((100% - 16px * 2) / 3 - 1px); } }
	  .wp-block-gallery.columns-4 .blocks-gallery-image,
	  .wp-block-gallery.columns-4 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-4 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-4 .blocks-gallery-item {
		width: calc((100% - 16px * 3) / 4);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-4 .blocks-gallery-image,
		  .wp-block-gallery.columns-4 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-4 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-4 .blocks-gallery-item {
			width: calc((100% - 16px * 3) / 4 - 1px); } }
	  .wp-block-gallery.columns-5 .blocks-gallery-image,
	  .wp-block-gallery.columns-5 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-5 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-5 .blocks-gallery-item {
		width: calc((100% - 16px * 4) / 5);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-5 .blocks-gallery-image,
		  .wp-block-gallery.columns-5 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-5 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-5 .blocks-gallery-item {
			width: calc((100% - 16px * 4) / 5 - 1px); } }
	  .wp-block-gallery.columns-6 .blocks-gallery-image,
	  .wp-block-gallery.columns-6 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-6 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-6 .blocks-gallery-item {
		width: calc((100% - 16px * 5) / 6);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-6 .blocks-gallery-image,
		  .wp-block-gallery.columns-6 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-6 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-6 .blocks-gallery-item {
			width: calc((100% - 16px * 5) / 6 - 1px); } }
	  .wp-block-gallery.columns-7 .blocks-gallery-image,
	  .wp-block-gallery.columns-7 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-7 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-7 .blocks-gallery-item {
		width: calc((100% - 16px * 6) / 7);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-7 .blocks-gallery-image,
		  .wp-block-gallery.columns-7 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-7 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-7 .blocks-gallery-item {
			width: calc((100% - 16px * 6) / 7 - 1px); } }
	  .wp-block-gallery.columns-8 .blocks-gallery-image,
	  .wp-block-gallery.columns-8 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-8 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-8 .blocks-gallery-item {
		width: calc((100% - 16px * 7) / 8);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-8 .blocks-gallery-image,
		  .wp-block-gallery.columns-8 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-8 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-8 .blocks-gallery-item {
			width: calc((100% - 16px * 7) / 8 - 1px); } }
	  .wp-block-gallery.columns-1 .blocks-gallery-image:nth-of-type(1n),
	  .wp-block-gallery.columns-1 .blocks-gallery-item:nth-of-type(1n),
	  .blocks-gallery-grid.columns-1 .blocks-gallery-image:nth-of-type(1n),
	  .blocks-gallery-grid.columns-1 .blocks-gallery-item:nth-of-type(1n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-2 .blocks-gallery-image:nth-of-type(2n),
	  .wp-block-gallery.columns-2 .blocks-gallery-item:nth-of-type(2n),
	  .blocks-gallery-grid.columns-2 .blocks-gallery-image:nth-of-type(2n),
	  .blocks-gallery-grid.columns-2 .blocks-gallery-item:nth-of-type(2n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-3 .blocks-gallery-image:nth-of-type(3n),
	  .wp-block-gallery.columns-3 .blocks-gallery-item:nth-of-type(3n),
	  .blocks-gallery-grid.columns-3 .blocks-gallery-image:nth-of-type(3n),
	  .blocks-gallery-grid.columns-3 .blocks-gallery-item:nth-of-type(3n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-4 .blocks-gallery-image:nth-of-type(4n),
	  .wp-block-gallery.columns-4 .blocks-gallery-item:nth-of-type(4n),
	  .blocks-gallery-grid.columns-4 .blocks-gallery-image:nth-of-type(4n),
	  .blocks-gallery-grid.columns-4 .blocks-gallery-item:nth-of-type(4n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-5 .blocks-gallery-image:nth-of-type(5n),
	  .wp-block-gallery.columns-5 .blocks-gallery-item:nth-of-type(5n),
	  .blocks-gallery-grid.columns-5 .blocks-gallery-image:nth-of-type(5n),
	  .blocks-gallery-grid.columns-5 .blocks-gallery-item:nth-of-type(5n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-6 .blocks-gallery-image:nth-of-type(6n),
	  .wp-block-gallery.columns-6 .blocks-gallery-item:nth-of-type(6n),
	  .blocks-gallery-grid.columns-6 .blocks-gallery-image:nth-of-type(6n),
	  .blocks-gallery-grid.columns-6 .blocks-gallery-item:nth-of-type(6n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-7 .blocks-gallery-image:nth-of-type(7n),
	  .wp-block-gallery.columns-7 .blocks-gallery-item:nth-of-type(7n),
	  .blocks-gallery-grid.columns-7 .blocks-gallery-image:nth-of-type(7n),
	  .blocks-gallery-grid.columns-7 .blocks-gallery-item:nth-of-type(7n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-8 .blocks-gallery-image:nth-of-type(8n),
	  .wp-block-gallery.columns-8 .blocks-gallery-item:nth-of-type(8n),
	  .blocks-gallery-grid.columns-8 .blocks-gallery-image:nth-of-type(8n),
	  .blocks-gallery-grid.columns-8 .blocks-gallery-item:nth-of-type(8n) {
		margin-right: 0; } }
	.wp-block-gallery .blocks-gallery-image:last-child,
	.wp-block-gallery .blocks-gallery-item:last-child,
	.blocks-gallery-grid .blocks-gallery-image:last-child,
	.blocks-gallery-grid .blocks-gallery-item:last-child {
	  margin-right: 0; }
	.wp-block-gallery.alignleft, .wp-block-gallery.alignright,
	.blocks-gallery-grid.alignleft,
	.blocks-gallery-grid.alignright {
	  max-width: 305px;
	  width: 100%; }
	.wp-block-gallery.aligncenter .blocks-gallery-item figure,
	.blocks-gallery-grid.aligncenter .blocks-gallery-item figure {
	  justify-content: center; }
  
  .wp-block-image {
	max-width: 100%;
	margin-bottom: 1em; }
	.wp-block-image img {
	  max-width: 100%; }
	.wp-block-image.aligncenter {
	  text-align: center; }
	.wp-block-image.alignfull img,
	.wp-block-image.alignwide img {
	  width: 100%; }
	.wp-block-image .alignleft,
	.wp-block-image .alignright,
	.wp-block-image .aligncenter, .wp-block-image.is-resized {
	  display: table;
	  margin-left: 0;
	  margin-right: 0; }
	  .wp-block-image .alignleft > figcaption,
	  .wp-block-image .alignright > figcaption,
	  .wp-block-image .aligncenter > figcaption, .wp-block-image.is-resized > figcaption {
		display: table-caption;
		caption-side: bottom; }
	.wp-block-image .alignleft {
	  /*rtl:ignore*/
	  float: left;
	  /*rtl:ignore*/
	  margin-right: 1em; }
	.wp-block-image .alignright {
	  /*rtl:ignore*/
	  float: right;
	  /*rtl:ignore*/
	  margin-left: 1em; }
	.wp-block-image .aligncenter {
	  margin-left: auto;
	  margin-right: auto; }
	.wp-block-image figcaption {
	  margin-top: 0.5em;
	  margin-bottom: 1em; }
  
  .wp-block-media-text {
	display: -ms-grid;
	display: grid;
	-ms-grid-rows: auto;
	grid-template-rows: auto;
	-ms-grid-columns: 50% 1fr;
	grid-template-columns: 50% 1fr; }
	.wp-block-media-text .has-media-on-the-right {
	  -ms-grid-columns: 1fr 50%;
	  grid-template-columns: 1fr 50%; }
  
  .wp-block-media-text.is-vertically-aligned-top .wp-block-media-text__content,
  .wp-block-media-text.is-vertically-aligned-top .wp-block-media-text__media {
	-ms-grid-row-align: start;
		align-self: start; }
  
  .wp-block-media-text .wp-block-media-text__content,
  .wp-block-media-text .wp-block-media-text__media,
  .wp-block-media-text.is-vertically-aligned-center .wp-block-media-text__content,
  .wp-block-media-text.is-vertically-aligned-center .wp-block-media-text__media {
	-ms-grid-row-align: center;
		align-self: center; }
  
  .wp-block-media-text.is-vertically-aligned-bottom .wp-block-media-text__content,
  .wp-block-media-text.is-vertically-aligned-bottom .wp-block-media-text__media {
	-ms-grid-row-align: end;
		align-self: end; }
  
  .wp-block-media-text .wp-block-media-text__media {
	-ms-grid-column: 1;
	grid-column: 1;
	-ms-grid-row: 1;
	grid-row: 1;
	margin: 0; }
  
  .wp-block-media-text .wp-block-media-text__content {
	-ms-grid-column: 2;
	grid-column: 2;
	-ms-grid-row: 1;
	grid-row: 1;
	word-break: break-word;
	padding: 0 8% 0 8%; }
  
  .wp-block-media-text.has-media-on-the-right .wp-block-media-text__media {
	-ms-grid-column: 2;
	grid-column: 2;
	-ms-grid-row: 1;
	grid-row: 1; }
  
  .wp-block-media-text.has-media-on-the-right .wp-block-media-text__content {
	-ms-grid-column: 1;
	grid-column: 1;
	-ms-grid-row: 1;
	grid-row: 1; }
  
  .wp-block-media-text > figure > img,
  .wp-block-media-text > figure > video {
	max-width: unset;
	width: 100%;
	vertical-align: middle; }
  
  .wp-block-media-text.is-image-fill figure {
	height: 100%;
	min-height: 250px;
	background-size: cover; }
  
  .wp-block-media-text.is-image-fill figure > img {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	border: 0; }
  
  .is-small-text {
	font-size: 14px; }
  
  .is-regular-text {
	font-size: 16px; }
  
  .is-large-text {
	font-size: 36px; }
  
  .is-larger-text {
	font-size: 48px; }
  
  .has-drop-cap:not(:focus)::first-letter {
	float: left;
	font-size: 8.4em;
	line-height: 0.68;
	font-weight: 100;
	margin: 0.05em 0.1em 0 0;
	text-transform: uppercase;
	font-style: normal; }
  
  .has-drop-cap:not(:focus)::after {
	content: "";
	display: table;
	clear: both;
	padding-top: 14px; }
  
  p.has-background {
	padding: 20px 30px; }
  
  p.has-text-color a {
	color: inherit; }
  
  .wp-block-pullquote {
	padding: 3em 0;
	margin-left: 0;
	margin-right: 0;
	text-align: center; }
	.wp-block-pullquote.alignleft, .wp-block-pullquote.alignright {
	  max-width: 305px; }
	  .wp-block-pullquote.alignleft p, .wp-block-pullquote.alignright p {
		font-size: 20px; }
	.wp-block-pullquote p {
	  font-size: 28px;
	  line-height: 1.6; }
	.wp-block-pullquote cite,
	.wp-block-pullquote footer {
	  position: relative; }
	.wp-block-pullquote .has-text-color a {
	  color: inherit; }
  
  .wp-block-pullquote:not(.is-style-solid-color) {
	background: none; }
  
  .wp-block-pullquote.is-style-solid-color {
	border: none; }
	.wp-block-pullquote.is-style-solid-color blockquote {
	  margin-left: auto;
	  margin-right: auto;
	  text-align: left;
	  max-width: 60%; }
	  .wp-block-pullquote.is-style-solid-color blockquote p {
		margin-top: 0;
		margin-bottom: 0;
		font-size: 32px; }
	  .wp-block-pullquote.is-style-solid-color blockquote cite {
		text-transform: none;
		font-style: normal; }
  
  .wp-block-pullquote cite {
	color: inherit; }
  
  .wp-block-quote.is-style-large, .wp-block-quote.is-large {
	margin: 0 0 16px;
	padding: 0 1em; }
	.wp-block-quote.is-style-large p, .wp-block-quote.is-large p {
	  font-size: 24px;
	  font-style: italic;
	  line-height: 1.6; }
	.wp-block-quote.is-style-large cite,
	.wp-block-quote.is-style-large footer, .wp-block-quote.is-large cite,
	.wp-block-quote.is-large footer {
	  font-size: 18px;
	  text-align: right; }
  
  .wp-block-separator.is-style-wide {
	border-bottom-width: 1px; }
  
  .wp-block-separator.is-style-dots {
	background: none !important;
	border: none;
	text-align: center;
	max-width: none;
	line-height: 1;
	height: auto; }
	.wp-block-separator.is-style-dots::before {
	  content: "\00b7 \00b7 \00b7";
	  color: currentColor;
	  font-size: 20px;
	  letter-spacing: 2em;
	  padding-left: 2em;
	  font-family: serif; }
  
  .wp-block-spacer {
	clear: both; }
  
  p.wp-block-subhead {
	font-size: 1.1em;
	font-style: italic;
	opacity: 0.75; }
  
  .wp-block-table {
	overflow-x: auto; }
	.wp-block-table table {
	  width: 100%; }
	.wp-block-table .has-fixed-layout {
	  table-layout: fixed;
	  width: 100%; }
	  .wp-block-table .has-fixed-layout td,
	  .wp-block-table .has-fixed-layout th {
		word-break: break-word; }
	.wp-block-table.alignleft, .wp-block-table.aligncenter, .wp-block-table.alignright {
	  display: table;
	  width: auto; }
	  .wp-block-table.alignleft td,
	  .wp-block-table.alignleft th, .wp-block-table.aligncenter td,
	  .wp-block-table.aligncenter th, .wp-block-table.alignright td,
	  .wp-block-table.alignright th {
		word-break: break-word; }
	.wp-block-table .has-subtle-light-gray-background-color {
	  background-color: #f3f4f5; }
	.wp-block-table .has-subtle-pale-green-background-color {
	  background-color: #e9fbe5; }
	.wp-block-table .has-subtle-pale-blue-background-color {
	  background-color: #e7f5fe; }
	.wp-block-table .has-subtle-pale-pink-background-color {
	  background-color: #fcf0ef; }
	.wp-block-table.is-style-stripes {
	  border-spacing: 0;
	  border-collapse: inherit;
	  background-color: transparent;
	  border-bottom: 1px solid #f3f4f5; }
	  .wp-block-table.is-style-stripes tbody tr:nth-child(odd) {
		background-color: #f3f4f5; }
	  .wp-block-table.is-style-stripes.has-subtle-light-gray-background-color tbody tr:nth-child(odd) {
		background-color: #f3f4f5; }
	  .wp-block-table.is-style-stripes.has-subtle-pale-green-background-color tbody tr:nth-child(odd) {
		background-color: #e9fbe5; }
	  .wp-block-table.is-style-stripes.has-subtle-pale-blue-background-color tbody tr:nth-child(odd) {
		background-color: #e7f5fe; }
	  .wp-block-table.is-style-stripes.has-subtle-pale-pink-background-color tbody tr:nth-child(odd) {
		background-color: #fcf0ef; }
	  .wp-block-table.is-style-stripes th,
	  .wp-block-table.is-style-stripes td {
		border-color: transparent; }
  
  .wp-block-text-columns {
	display: flex; }
	.wp-block-text-columns.aligncenter {
	  display: flex; }
	.wp-block-text-columns .wp-block-column {
	  margin: 0 16px;
	  padding: 0; }
	  .wp-block-text-columns .wp-block-column:first-child {
		margin-left: 0; }
	  .wp-block-text-columns .wp-block-column:last-child {
		margin-right: 0; }
	.wp-block-text-columns.columns-2 .wp-block-column {
	  width: calc(100% / 2); }
	.wp-block-text-columns.columns-3 .wp-block-column {
	  width: calc(100% / 3); }
	.wp-block-text-columns.columns-4 .wp-block-column {
	  width: calc(100% / 4); }
  
  pre.wp-block-verse {
	white-space: nowrap;
	overflow: auto; }
  
  :root .has-pale-pink-background-color {
	background-color: #f78da7; }
  
  :root .has-vivid-red-background-color {
	background-color: #cf2e2e; }
  
  :root .has-luminous-vivid-orange-background-color {
	background-color: #ff6900; }
  
  :root .has-luminous-vivid-amber-background-color {
	background-color: #fcb900; }
  
  :root .has-light-green-cyan-background-color {
	background-color: #7bdcb5; }
  
  :root .has-vivid-green-cyan-background-color {
	background-color: #00d084; }
  
  :root .has-pale-cyan-blue-background-color {
	background-color: #8ed1fc; }
  
  :root .has-vivid-cyan-blue-background-color {
	background-color: #0693e3; }
  
  :root .has-vivid-purple-background-color {
	background-color: #9b51e0; }
  
  :root .has-very-light-gray-background-color {
	background-color: #eee; }
  
  :root .has-cyan-bluish-gray-background-color {
	background-color: #abb8c3; }
  
  :root .has-very-dark-gray-background-color {
	background-color: #313131; }
  
  :root .has-pale-pink-color {
	color: #f78da7; }
  
  :root .has-vivid-red-color {
	color: #cf2e2e; }
  
  :root .has-luminous-vivid-orange-color {
	color: #ff6900; }
  
  :root .has-luminous-vivid-amber-color {
	color: #fcb900; }
  
  :root .has-light-green-cyan-color {
	color: #7bdcb5; }
  
  :root .has-vivid-green-cyan-color {
	color: #00d084; }
  
  :root .has-pale-cyan-blue-color {
	color: #8ed1fc; }
  
  :root .has-vivid-cyan-blue-color {
	color: #0693e3; }
  
  :root .has-vivid-purple-color {
	color: #9b51e0; }
  
  :root .has-very-light-gray-color {
	color: #eee; }
  
  :root .has-cyan-bluish-gray-color {
	color: #abb8c3; }
  
  :root .has-very-dark-gray-color {
	color: #313131; }
  
  .has-small-font-size {
	font-size: 13px; }
  
  .has-regular-font-size,
  .has-normal-font-size {
	font-size: 16px; }
  
  .has-medium-font-size {
	font-size: 20px; }
  
  .has-large-font-size {
	font-size: 36px; }
  
  .has-larger-font-size,
  .has-huge-font-size {
	font-size: 42px; }
  
  .has-text-align-center {
	text-align: center; }
  
  .has-text-align-left {
	/*rtl:ignore*/
	text-align: left; }
  
  .has-text-align-right {
	/*rtl:ignore*/
	text-align: right; }

.wp-block-columns {
	width: 100%;
	clear: both;
	margin-bottom: 0;
}
.titleblock h2 {
	margin-top: 25px;
}
	
' . $segment['stoplight'];
}

function display_time_stoplight( $content ) {
	preg_match_all( '/\d{1,3}/', $content, $matches );
	// return var_export($matches[0],true);
	$output = '';
	if ( ! empty( $matches ) ) {
		if ( sizeof( $matches[0] ) == 2 ) {
			// simple case
			$green = array_shift( $matches[0] );
			$red   = array_shift( $matches[0] );
			return get_stoplight( $green, $red );
		}
		while ( ( $green = array_shift( $matches[0] ) ) && ( $red = array_shift( $matches[0] ) ) ) {
			$output .= '<br />' . get_stoplight( $green, $red );
		}
	}
	return $content . $output;
}

function get_stoplight( $green, $red, $yellow = null ) {
	if ( empty( $yellow ) ) {
		$diff         = $red - $green;
		$plus_minutes = ( $diff - $diff % 2 ) / 2;
		$yellow       = $green + $plus_minutes;
		if ( $diff % 2 ) {
			if ( ( $green > 5 ) && ( $diff > 2 ) ) { // go tonext minute
				$yellow++;
			} else {
				$yellow = $yellow .= ':30';
			}
		}
	}
	return sprintf( '<span class="stoplight_block"><img alt="green" src="' . plugins_url( 'rsvpmaker-for-toastmasters/stoplight-green.png' ) . '" style="padding:0; border: thin solid #000; height: 0.8em; width: 0.8em; " />&nbsp;Green: ' . $green . ' ' . '<img alt="yellow" src="' . plugins_url( 'rsvpmaker-for-toastmasters/stoplight-yellow.png' ) . '" style="padding:0; border: thin solid #000; height: 0.8em; width: 0.8em; " />&nbsp;Yellow: ' . $yellow . ' ' . '<img alt="red" src="' . plugins_url( 'rsvpmaker-for-toastmasters/stoplight-red.png' ) . '" style="padding:0; border: thin solid #000;  height: 0.8em; width: 0.8em; " />&nbsp;Red: ' . $red . '</span>' );
}

function stoplight_shortcode( $atts ) {
	if ( ! isset( $atts['red'] ) || ! isset( $atts['green'] ) ) {
		return;
	}
	$red    = $atts['red'];
	$green  = $atts['green'];
	$yellow = ( isset( $atts['yellow'] ) ) ? $atts['yellow'] : null;
	return get_stoplight( $green, $red, $yellow );
}

function wpt_custom_layout_default($sidebar_officers = false) {
	global $wpdb;
	$sidebar_content = '<!-- wp:paragraph -->
		<p><br><strong>Club Mission: </strong>We provide a supportive and positive learning experience in which members are empowered to develop communication and leadership skills, resulting in greater self-confidence and personal growth.</p>
		<!-- /wp:paragraph -->';
	$officers_content = '<!-- wp:wp4toastmasters/officers /-->';

	return '<!-- wp:columns {"className":"titleblock"} -->
    <div class="wp-block-columns titleblock"><!-- wp:column {"width":"10%"} -->
    <div class="wp-block-column" style="flex-basis:10%"><!-- wp:image {"width":40,"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large is-resized"><img src="https://toastmost.org/tmbranding/ToastmastersAgendaLogo.png" alt="" style="width:40px" width="40"/></figure>
    <!-- /wp:image --></div>
    <!-- /wp:column -->
    
    <!-- wp:column {"width":"90%"} -->
    <div class="wp-block-column" style="flex-basis:90%"><!-- wp:heading {"style":{"typography":{"fontSize":22}}} -->
    <!-- wp:paragraph {"style":{"typography":{"fontSize":22}},"className":"agenda-title"} -->
    <p class="agenda-title" style="font-size:22px">'.esc_html(get_option('blogname')).' [tmlayout_post_title]</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:wp4toastmasters/meetingdate /--></div>
    <!-- /wp:column --></div>
    <!-- /wp:columns -->
	
	<!-- wp:columns -->
	<div class="wp-block-columns"><!-- wp:column {"width":"33.33%"} -->
	<div class="wp-block-column" style="flex-basis:33.33%" id="agenda-sidebar">'.$sidebar_content.'
	
	'.$officers_content.'</div>
	<!-- /wp:column -->
	
	<!-- wp:column {"width":"66.66%"} -->
	<div class="wp-block-column" style="flex-basis:66.66%" id="agenda"><!-- wp:wp4toastmasters/agendamain /--></div>
	<!-- /wp:column --></div>
	<!-- /wp:columns -->';
}

function wp4toastmasters_agenda_layout_check( $sidebar_officers = false ) {

	global $current_user;
		global $wpdb;
		$layout_id = get_option( 'rsvptoast_agenda_layout');
		if($layout_id && get_post($layout_id) && !isset($_GET['reset_layout'])) // if option set and post is valid
			return $layout_id;

		$layout['post_type']    = 'rsvpmaker';
		$layout['post_title']   = 'Agenda Layout';
		$layout['post_content'] = wpt_custom_layout_default($sidebar_officers);
		$layout['post_author']  = $current_user->ID;
		$layout['post_status']  = 'publish';
		$layout_id              = wp_insert_post( $layout );
		update_post_meta( $layout_id, '_rsvpmaker_special', 'Agenda Layout' );
		update_option( 'rsvptoast_agenda_layout', $layout_id );
	return $layout_id;
}

function agenda_add_editor_styles() {
	$layout_id = (int) get_option( 'rsvptoast_agenda_layout' );
	if(isset($_GET['post']) && ($_GET['post'] == $layout_id)) {
		wp4toastmasters_agenda_layout_check();
		remove_theme_support('editor-style');
		$css = wpt_default_agenda_css();
		$css .= '
		:root {
--global--color-background: #FFFFFF; 
}
.editor-styles-wrapper h1, .editor-styles-wrapper h2 {height: 50px; vertical-align: middle;}
		.editor-styles-wrapper {background: none; background-color: #fff;}
		.editor-styles-wrapper .wp-block-heading h1, .editor-styles-wrapper h1, .editor-styles-wrapper .h1, .editor-styles-wrapper .wp-block-heading h2, .editor-styles-wrapper h2, .editor-styles-wrapper .h2, .editor-styles-wrapper .wp-block-heading h3, .editor-styles-wrapper h3, .editor-styles-wrapper .h3, .editor-styles-wrapper .wp-block-heading h4, .editor-styles-wrapper h4, .editor-styles-wrapper .h4, .editor-styles-wrapper .wp-block-heading h5, .editor-styles-wrapper h5, .editor-styles-wrapper .h5, .editor-styles-wrapper .wp-block-heading h6, .editor-styles-wrapper h6, .editor-styles-wrapper .h6 {
			clear: none; color: red;
		}';
		//printf('<style>%s</style>',$css);
		$theme_root = get_stylesheet_directory();
		$file_path     = $theme_root . '/agenda-editor.css';
		file_put_contents($file_path,$css);
		add_editor_style('agenda-editor.css');
	}
}
add_action( 'after_setup_theme', 'agenda_add_editor_styles', 99 );

function get_tm_security() {
	return array(
		'edit_signups'      => 'edit_signups',
		'email_list'        => 'email_list',
		'edit_member_stats' => 'edit_member_stats',
		'edit_own_stats'    => 'edit_own_stats',
		'view_reports'      => 'view_reports',
		'view_attendance'   => 'view_reports',
		'agenda_setup'      => 'agenda_setup',
	);
}

function tm_security_options( $label ) {

	$current  = get_tm_security();
	$selected = $current[ $label ];

	$options = array(
		'read'              => 'Any Member',
		'edit_others_posts' => 'Officer or Editor',
		'manage_options'    => 'Administrator',
	);
	$list    = '';
	foreach ( $options as $key => $value ) {
		$s     = ( $key == $selected ) ? ' selected="selected" ' : '';
		$list .= sprintf( '<option value="%s" %s>%s</option>', $key, $s, $value );
	}
	return sprintf(
		'<label for="%s">Select:</label>
<select name="tm_security[%s]" id="%s">
%s
</select>',
		$label,
		$label,
		$label,
		$list
	);
}

function rsvpmaker_agenda_notifications( $permalink ) {
	global $current_user;
	$output  = '';
	$cleared = get_user_meta( $current_user->ID, 'rsvpmaker_agenda_notifications' );
	if ( empty( $cleared ) ) {
		$cleared = array();
	}
	if ( isset( $_GET['wpt_clear'] ) && ! in_array( $_GET['wpt_clear'], $cleared ) ) {
		$cleared[] = sanitize_text_field($_GET['wpt_clear']);
		add_user_meta( $current_user->ID, 'rsvpmaker_agenda_notifications', sanitize_text_field($_GET['wpt_clear']) );
	}

	if ( isset( $_GET['wpt_clear_reset'] ) ) {
		$cleared = array();
		delete_user_meta( $current_user->ID, 'rsvpmaker_agenda_notifications' );
	}
		$edlink       = add_query_arg( array( 'edit_roles' => 1 ), $permalink );
		$reclink      = add_query_arg(
			array(
				'recommend_roles' => 1,
				'rm'              => 1,
			),
			$permalink
		);
		$allow_assign = get_option( 'allow_assign' );
	if ( ( $allow_assign == 'yes' ) || ( ( $allow_assign == 'editor' ) && current_user_can( 'edit_others_rsvpmakers' ) ) ) {
		$assignlink = '<a href="%s' . add_query_arg(
			array(
				'edit_roles' => 1,
				'rm'         => 1,
			),
			$permalink
		) . '">Suggest Assignments</a>';
	} else {
		$assignlink = 'Suggest Assignments [not enabled]';
	}
		$signup    = $permalink;
		$permalink = add_query_arg( $_GET, $permalink );
	if ( isset( $_GET['rm'] ) ) {
		if ( is_edit_roles() ) {
			$notify['rmedit'] = sprintf( '<span style="color:red; font-weight: bold">Caution:</span> Open roles are shown below with suggested assignments. These are <strong>NOT yet</strong> saved to the agenda. To make assignments, accept or change each suggestion, then scroll to the bottom and click Save Changes.<br />Switch Mode:<ul><li><a href="%s">Edit Signups</a> (no suggestions)</li><li><a href="%s">Recommend (Member Must Confirm)</a> (suggestions, members must confirm)</li><li><a href="%s">Member Signup</a></li></ul>.', $edlink, $reclink, $signup );

			$assign_ok = get_user_meta( $current_user->ID, 'assign_okay', true );
			if ( empty( $assign_ok ) || ( $assign_ok < time() ) ) {
				$p                 = get_permalink();
				$notify['rmedit'] .= sprintf(
					'<div><h2 style="color:red;">Are you sure you know what you are doing?</h2>
	<p>In Suggest Assignment mode (as opposed to Edit), open roles are filled with members selected by the software. If you accept the suggestions and click Save Changes at the bottom of the form, they will be saved to the agenda.</p>
	<p>Do you want to turn on Suggest Assignments mode?</p>
	<p><a href="%s">Yes, just for now.</a></p>
	<p><a href="%s">Yes, and do not ask me again.</a></p>
	</div>',
					add_query_arg(
						array(
							'edit_roles' => 1,
							'rm'         => 1,
							'sure'       => strtotime( '+2 hours' ),
						),
						$p
					),
					add_query_arg(
						array(
							'edit_roles' => 1,
							'rm'         => 1,
							'sure'       => strtotime( '+10 years' ),
						),
						$p
					)
				);
			}
		} else {
			$notify['rmrec'] = sprintf( '<strong>Recommend</strong> mode shows suggested assignments for open roles. If you scroll to the bottom and click Save Changes, these members will receive an email saying you have recommended them for the role. The assignment is <strong>NOT</strong> saved to the agenda until the member confirms acceptance.<br />Switch Mode:<ul><li><a href="%s">Edit Signups (no suggestions)</a></li><li>%s</li><li><a href="%s">Member Signup</a></li></ul>', $edlink, $assignlink, $signup );
		}
	} elseif ( is_edit_roles() ) {
		$notify['edit'] = sprintf( 'Edit Signups mode allows you to assign other members to roles or change assignments. When done, scroll to the bottom and click <strong>Save Changes</strong>. <br />Switch Mode:<ul><li>%s</li><li><a href="%s">Recommend (suggestions, member must confirm)</a></li><li><a href="%s">Member Signup</a></li></ul>', $assignlink, $reclink, $signup );
	}

	if ( ! empty( $notify ) ) {
		foreach ( $notify as $slug => $value ) {
			$clearedurl = add_query_arg( 'wpt_clear', $slug, $permalink );
			if ( ! in_array( $slug, $cleared ) ) {
				$output .= sprintf( '<div class="wpt_notify %s"><div class="wpt_clear" title="Clear Notice"><a href="%s">&times;</a></div>%s</div>', $slug, $clearedurl, $value );
			}
		}
	}

	return $output;
}

function wpt_member_signups_suggestions_screen() {
	global $current_user;
?>
<h1>Member Signups and Suggestions</h1>
<p>Help your members plan future meeting roles and speeches. Use this tool to organize your outreach to them.</p>
<p>You can copy and paste the one-click signup links on each open role into a personal email, or share through a social messenger tool.</p>
<?	
	if(isset($_GET['member']))
		$user_id = intval($_GET['member']);
	else {
		echo '<p>Showing your own data by default.</p>';
		$user_id = $current_user->ID;
	}
	printf('<form method="get" action="%s">',admin_url('admin.php'));
	foreach($_GET as $name => $value) {
		if('sort' != $name)
		printf('<input type="hidden" name="%s" value="%s">',$name,$value);
	}
	echo awe_user_dropdown( 'member', $user_id, true, $openlabel = '' );
	printf('&nbsp; <input type="checkbox" name="sort" value="1" %s /> Sort seldom done roles to the top &nbsp; ',(isset($_GET['sort']) || empty($_GET['submit']) ) ? 'checked="checked"' : '');
	submit_button('Lookup','primary','submit',false);
	echo '</form>';
	
	printf('<h2>%s</h2>',get_member_name($user_id));
	echo wpt_get_member_profile($user_id,'?subject='.urlencode('Help fill the agenda for '.get_bloginfo('name')).'&body='.urlencode('Help fill the agenda for our upcoming meetings. The links on the roles included below will let you sign up with one click.'."\n\n"));
	echo '<div style="background-color: #fff; padding: 5px; margin-top: 5px;">'.wpt_member_signups_suggestions($user_id, empty($_GET['sort']) ).'</div>';
}

function wpt_member_signups_suggestions ($user_id = 0, $sortalpha = false) {
	global $post, $current_user,$wpdb, $rsvp_options;
	$output = '';
	$meetings = future_toastmaster_meetings(8);
	foreach($meetings as $meeting) {
		$output .= sprintf('<h4><a href="%s?mode=edit">%s %s</a></h4>', get_permalink($meeting->ID), $meeting->post_title, rsvpmaker_date($rsvp_options['long_date'],$meeting->ts_start));
		$ab = get_absences_array( $meeting->ID );
		if(in_array($user_id,$ab))
			{
				$output .= '<p><strong>Planned absence</strong></p>';
				continue;
			}
		$exists = $wpdb->get_var("select meta_key from $wpdb->postmeta where meta_key LIKE '_role_%' and post_id=$meeting->ID and meta_value=$user_id ");
		if($exists)
			{
				$output .= sprintf('<p><strong>Signed up for %s</strong></p>',clean_role($exists));
				continue; // skip if the user already has a role
			}
		$nonce = get_post_meta($meeting->ID,'oneclicknonce',true);
		if(empty($nonce)) {
			$nonce = wp_create_nonce('oneclick');
			update_post_meta($meeting->ID,'oneclicknonce',$nonce);
		}
		$openroles = [];
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
					if(!in_array($role,$openroles))
						$openroles[] = $role;
				}
			}
		}
		if(!empty($openroles))
		{
			$output .= '<p>Suggested:</p>';
			$outputarr = [];
			foreach($openroles as $index => $role) {
				if(strpos($role, 'Backup') !== false)
					continue;
				$last_did = wp4t_last_held_role($user_id, $role, true);
				if(empty($outputarr[$last_did[1]]))
					$outputarr[$last_did[1]] = sprintf('<p><a href="%s?member=%d&oneclick=%s&member=%d&role=%s">%s</a>, last did %s</p>',get_permalink($meeting->ID),$user_id,$user_id,$nonce,$role,$role,$last_did[0]);
				else
					$outputarr[$last_did[1]] .= sprintf('<p><a href="%s?member=%d&oneclick=%s&member=%d&role=%s">%s</a>, last did %s</p>',get_permalink($meeting->ID),$user_id,$user_id,$nonce,$role,$role,$last_did[0]);
			}
			if($sortalpha)
				sort($outputarr);
			else
				ksort($outputarr);
			$output .= implode("\n",$outputarr);
		}
		else 
			$output .= '<p>No open roles</p>';
	}
	return $output;
}

function oneclick_future ($user_id = 0) {
	global $post, $current_user,$wpdb, $rsvp_options;
	if(!$user_id && !empty($current_user->ID))
		$user_id = $current_user->ID;
	if(!$user_id)
		return;
	$output = '';
	$meetings = future_toastmaster_meetings(4);
	foreach($meetings as $meeting) {
		if(!empty($post->ID) && $meeting->ID == $post->ID)
			continue;
		$exists = $wpdb->get_results("select * from $wpdb->postmeta where meta_key LIKE '_role_%' and post_id=$meeting->ID and meta_value=$user_id ");
		if($exists)
			{
				continue; // skip if the user already has a role
			}
		$nonce = get_post_meta($meeting->ID,'oneclicknonce',true);
		if(empty($nonce)) {
			$nonce = wp_create_nonce('oneclick');
			update_post_meta($meeting->ID,'oneclicknonce',$nonce);
		}
		$openroles = [];
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
					if(!in_array($role,$openroles))
						$openroles[] = $role;
				}
			}
		}
		if(!empty($openroles))
		{
			$output .= sprintf('<h4>%s %s</h4>', $meeting->post_title, rsvpmaker_date($rsvp_options['long_date'],$meeting->ts_start));
			foreach($openroles as $role) {
				$last_did = wp4t_last_held_role($user_id, $role);
				if($last_did)
					$last_did = '?';
				$output .= sprintf('<p><a href="%s?member=%d&oneclick=%s&role=%s">%s</a>, last did %s</p>',get_permalink($meeting->ID),$user_id,$nonce,$role,$role,$last_did);
			}
		}
	}
	if(!empty($output))
		$output = '<h3>Openings for Upcoming Meetings</h3>'.$output;
	return $output;
}

function wpt_oneclick_signup() {
global $post, $rsvp_options;
$output = '';
$nonce = get_post_meta($post->ID,'oneclicknonce',true);
$code = sanitize_text_field($_REQUEST['oneclick']);
if($nonce != $code)
	return '<p>Security error.</p>';
$role = sanitize_text_field($_REQUEST['role']);
if(isset($_REQUEST['e'])) {
	$email = sanitize_text_field($_REQUEST['e']);
	$user = get_user_by('email',$email);
	$user_id = $user->ID;	
}
elseif(isset($_REQUEST['member'])) {
	$user_id = intval($_REQUEST['member']);
	$user = get_userdata($user_id);
}
if(!empty($user->display_name))
	$output .= sprintf('<h2 id="oneclick">One Click Signup</h2><p>Recognized member: %s</p>',$user->display_name);
else
	return 'Sorry, member account not recognized.';
if(strpos($role,'role_'))
	return wpt_oneclick_signup_post($user_id, $role); // signup for different role or speaker

if(isset($_REQUEST['abs'])) {
	foreach($_REQUEST['abs'] as $abs) {
		add_post_meta( $abs, 'tm_absence', $user_id );
		$event = get_rsvpmaker_event($abs);
		$output .= '<p>Added absence for  '.rsvpmaker_date($rsvp_options['short_date'],$event->ts_start).'</p>';
	}
	return $output;
}
elseif('absent' == $role) {
	add_post_meta( $post->ID, 'tm_absence', $user_id );
	$output .= '<p>Recording planned absence.</p>';
	$future = future_toastmaster_meetings();
	$checkbox = [];
	foreach($future as $meeting) {
		if($post->ID != $meeting->ID) {
			$checkbox[] = sprintf('<input type="checkbox" name="abs[]" value="%d"> %s',$meeting->ID,rsvpmaker_date($rsvp_options['short_date'],$meeting->ts_start));
		}
	}
	
	if(!empty($checkbox)) {
		$output .= sprintf('<form method="post" action="%s"><h3>Do you expect to be absent any of these future weeks?</h3><p>%s</p><button>Add Dates</button></form>',add_query_arg(array('role'=>'absent','oneclick'=>$code,'e'=>$email),get_permalink()),implode('<br>',$checkbox));
	}
	if(isset($_GET['by'])) {
		$event = get_rsvpmaker_event($post->ID);
		$date = rsvpmaker_date($rsvp_options['short_date'],$event->ts_start);
		$by = get_userdata(intval($_GET['by']));
		$mail['to'] = $by->user_email;
		$mail['from'] = $user->user_email;
		$mail['subject'] = $user->display_name.' will be ABSENT '.$date;
		$mail['html'] = '<p>'.$user->display_name.' response to role suggestion: ABSENT</p>';
		rsvpmailer($mail);
	}
	$output .= oneclick_future($user_id);
	$output .= sprintf('<p>Want first pick of roles for future meetings? <a href="%s">Sign up for multiple meetings</a> in advance.</p>',admin_url('admin.php?page=toastmasters_planner'));
	$output .= sprintf('<p><a href="%s">Exit one-click signup mode</a> to see the regular agenda signup sheet.</p><div style="height: 1000px; "></div>',get_permalink());
	
	return $output;
}
$mode = (isset($_GET['mode'])) ? ' '.sanitize_text_field($_GET['mode']) : '';
add_post_meta($post->ID,'oneclick_used',$user_id.$mode);

$toolate = true;
$already = false;
$data = wpt_blocks_to_data($post->post_content);
$formtop = sprintf('<form method="post" action="%s"><input type="hidden" name="oneclick" value="%s">',add_query_arg(array('oneclick'=>$code),get_permalink()),$code);
$formtop .= '<input type="hidden" name="member" value="'.$user_id.'">';
$formtop .= sprintf('<input type="hidden" name="by" value="%d" />',(isset($_GET['by'])) ? intval($_GET['by']) : 0 );
$formbottom = (strpos($post->post_content,'tm_attend_in_person') || strpos($post->post_content,'wp4toastmasters/hybrid')) ? tm_in_person_checkbox($user_id) : '';
$formbottom .= '<p><button style="background-color: #004165; color: #FFFFFF; border-radius: 3px; font-size: 16px; padding: 5px; font-weight: bold;">Take Role!</button></p></form>';
$debug = '';
foreach($data as $item){
	if(isset($item['role']) && (wp4t_fieldbase($item['role']) == wp4t_fieldbase($role)))
	{
		//print_r($item);
		$count = (isset($item['count'])) ? $item['count'] : 1;
		$start = (isset($item['start'])) ? $item['start'] : 1;
		$end = $start + $count;
		for($i = $start; $i < $end; $i++)
		{
			$field = wp4t_fieldbase($role,$i);
			$debug .= "<p>field $field</p>";
			$assigned = get_post_meta($post->ID,$field,true);
			if(!$assigned) {
				$output .= $formtop.sprintf('<input type="hidden" name="role" value="%s"><input type="hidden" name="user_id" value="%s">',$field,$user->ID);
				$output .= sprintf("<p>Let's sign you up for %s !</p>",$role);
				if($role == 'Speaker')
					$output .= speaker_details( $field, array(), $user );
				$output .= $formbottom;
				$toolate = false;
				break;
			}
			elseif($assigned == $user->ID)
			{
				$output .= sprintf("<p>We already have you signed up for %s! Thank you!</p>",$role);
				$output .= $formtop.sprintf('<input type="hidden" name="role" value="%s"><input type="hidden" name="user_id" value="%s">',$field,$user->ID);
				if($role == 'Speaker') {
					$output .= speaker_details( $field, array(), $user );
					$output .= $formbottom;
					$toolate = false;
					$already = true;	
				}
				break;
			}
		}
	}
}

add_post_meta($post->ID,'oneclick_debug',"Toolate $toolate already $already role $role");

if($toolate) {
	$output .= "<p>That role is no longer available, but let's sign you up for one of these:</p>";//.$debug;
	foreach($data as $item){
		if(isset($item['role']) && ($item['role'] != $role))
		{
			$altrole = $item['role'];
			$count = (isset($item['count'])) ? $item['count'] : 1;
			for($i = 1; $i <= $count; $i++)
			{
				$field = '_role_'.str_replace(' ','_',$altrole).'_'.$i;
				$assigned = get_post_meta($post->ID,$field,true);
				if(!$assigned) {
					$output .= "<p>".clean_role($field)."</p>";
					$output .= $formtop.sprintf('<input type="hidden" name="role" value="%s"><input type="hidden" name="user_id" value="%s">',$field,$user->ID);
					if($altrole == 'Speaker')
						$output .= speaker_details( $field, array(), $user );
					$output .= $formbottom;
					break;
				}
			}
		}
	}	
}

$output .= sprintf('<p><a href="%s">Exit one-click signup mode</a> to see the regular agenda signup sheet.</p><div style="height: 1000px; "></div>',get_permalink());

return $output;
}

function wpt_oneclick_signup_post($user_id = 0, $role= '') {
global $post, $rsvp_options;
$output = '';
if($user_id && $role) {
	update_post_meta($post->ID,$role,$user_id);
}
else {
	$role = $_REQUEST['role'];
	$nonce = get_post_meta($post->ID,'oneclicknonce',true);
	$code = sanitize_text_field($_REQUEST['oneclick']);
	if($nonce != $code)
		return '<p>Security error.</p>';
	if(isset($_REQUEST['user_id']))
		$user_id = intval($_REQUEST['user_id']);
	elseif($_REQUEST['e']) {
		$user = get_user_by('email',sanitize_text_field($_REQUEST['e']));
		if($user)
			$user_id = $user->ID;
	}
	update_post_meta($post->ID,$role,$user_id);	
}
if(strpos($role,'Speaker'))
{
	$manual = $_POST['_manual'][$role];
	update_post_meta($post->ID,'_manual'.$role,$manual);
	$project = $_POST['_project'][$role];
	update_post_meta($post->ID,'_project'.$role,$project);
	$display_time = $_POST['_display_time'][$role];
	update_post_meta($post->ID,'_display_time'.$role,$display_time);
	$maxtime = $_POST['_maxtime'][$role];
	update_post_meta($post->ID,'_maxtime'.$role,$maxtime);
	$title = $_POST['_title'][$role];
	update_post_meta($post->ID,'_title'.$role,$title);
	$intro = $_POST['_intro'][$role];
	update_post_meta($post->ID,'_intro'.$role,$intro);
}

$user = get_userdata($user_id);
$clean = clean_role($role);
if(!empty($_REQUEST['by'])) {
	$event = get_rsvpmaker_event($post->ID);
	$date = rsvpmaker_date($rsvp_options['short_date'],$event->ts_start);
	$user = get_userdata($user_id);
	$by = get_userdata(intval($_REQUEST['by']));
	if($by) {
		$mail['to'] = $by->user_email;
		$mail['from'] = $user->user_email;
		$mail['subject'] = $user->display_name.' confirmed for '.$clean.' on '.$date;
		$mail['html'] = '<p>'.$user->display_name.' responded YES to role suggestion: '.$clean.'</p>';
		rsvpmailer($mail);	
	}
}
$output .= sprintf('<p>%s signed up for %s. <a href="%s">View agenda</a></p>',$user->display_name,$clean,add_query_arg(array('print_agenda' =>1, 'no_print' =>1),get_permalink()) );
$output .= oneclick_future($user_id);
$output .= sprintf('<p>Want first pick of roles for future meetings? <a href="%s">Sign up for multiple meetings</a> in advance.</p>',admin_url('admin.php?page=toastmasters_planner'));
$output .= sprintf('<p><a href="%s">Exit one-click signup mode</a> to see the regular agenda signup sheet.</p><div style="height: 1000px; "></div>',get_permalink());

return $output;
}

function dash_wptmagenda_menu( $post_id ) {
	global $post, $rsvp_options;
	$post       = get_post( $post_id );
	$permalink  = get_permalink( $post_id );
	$permalink .= strpos( $permalink, '?' ) ? '&' : '?';
	$agenda_lock = is_agenda_locked();
	$link       = '';

	$blank = ' target="_blank" ';
	// defaults 'edit_signups' => 'read','email_list' => 'read','edit_member_stats' => 'edit_others_posts','view_reports' => 'read','view_attendance' => 'read','agenda_setup' => 'edit_others_posts'
	$security = get_tm_security();

	$link .= '<div id="cssmenu"><ul>';
	$link .= '<li><a href="' . $permalink . '" ' . $blank . '>' . __( 'Signup', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	if ( current_user_can( 'edit_signups' ) || edit_signups_role() ) {
		$link .= '<li><a href="' . $permalink . 'mode=edit" ' . $blank . '>' . __( 'Edit Signups', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
		$link .= '<li><a href="' . $permalink . 'mode=reorganize" ' . $blank . '>' . __( 'Organize', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	}
	$link .= '<li><a target="_blank" href="' . $permalink . 'print_agenda=1">' . __( 'Agenda Print', 'rsvpmaker-for-toastmasters' ) . '</a></li> ';
	if ( current_user_can( $security['email_list'] ) ) {
		$link .= '<li><a  target="_blank" href="' . $permalink . 'email_agenda=1">' . __( 'Agenda Email', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	}
	$link     .= '<li ><a target="_blank" href="' . $permalink . 'print_agenda=1&no_print=1">' . __( 'Agenda Show', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	if ( ! get_option( 'wp4toastmasters_intros_on_agenda' ) ) {
		$link .= '<li class="last"><a target="_blank" href="' . $permalink . 'print_agenda=1&no_print=1&showintros=1">' . __( 'Show with Introductions', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	}
	$link    .= '<li ><a href="' . $permalink . 'assigned_open=1" ' . $blank . '>' . __( 'Agenda with Contacts', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	$link    .= '<li ><a target="_blank" href="' . $permalink . 'intros=show">' . __( 'Speech Introductions', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	$link    .= '<li ><a target="_blank" href="' . $permalink . 'scoring=dashboard">' . __( 'Contest Scoring Dashboard', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	$link .= '</ul></div>';

	if ( $agenda_lock ) {
		$link .= '<p style="margin: 10px; padding: 5px; border: thin dotted red;">Agenda is locked against changes and can only be unlocked by an administrator.</p>';
	} elseif ( ! empty( $post_lock ) && strpos( $post_lock, 'admin' ) ) {
		$link .= '<p style="margin: 10px; padding: 5px; border: thin dotted red;">Agenda is locked (except for administrator).</p>';
	}
	return $link;
}

function tweak_agenda_times( $post ) {
	global $rsvp_options;
	if ( ! is_user_logged_in() ) {
		return 'Not logged in';
	}

	$time_format = str_replace( 'T', '', $rsvp_options['time_format'] );
	if ( rsvpmaker_is_template( $post->ID ) ) {
		$sked = get_template_sked( $post->ID );
		$date = '2030-01-01 ' . $sked['hour'] . ':' . $sked['minutes'];
	} else {
		$date = get_rsvp_date( $post->ID );
	}
	$ts_start = rsvpmaker_strtotime( $date );

	$elapsed = 0;

	$time_array = array();

	$output      = '';
	$lines       = explode( "\n", $post->post_content );
	$block_count = 0;
	$uids        = array();
	$update      = false;
	$new         = '';
	foreach ( $lines as $index => $line ) {
		$pattern = '/{"role":[^}]+}/';
		preg_match( $pattern, $line, $match );
		if ( ! empty( $match[0] ) ) {
			$data[] = (array) json_decode( $match[0] );
			// $block_count++;
		} elseif ( strpos( $line, '-- wp:wp4toastmasters/agendanoterich2' ) || strpos( $line, '-- wp:wp4toastmasters/agendaedit' ) ) {
			$pattern = '/{.+}/';
			preg_match( $pattern, $line, $match );
			if ( ! empty( $match[0] ) ) {
				$atts = (array) json_decode( $match[0] );
				if ( in_array( $atts['uid'], $uids ) ) {
						$atts['uid'] = 'note' . rand( 100, 10000 );
						$line        = preg_replace( '/{.+}/', json_encode( $atts ), $line );
						$update      = true;
				}
				$uids[] = $atts['uid'];
				$data[] = $atts;
				// $block_count++;
			}
		}
		$new .= $line . "\n";
	}

	if ( $update ) {
		$up['ID']           = $post->ID;
		$up['post_content'] = $new;
		wp_update_post( $up );
	}

	$block_count = 0;
	$output      = '<form id="tweak_times_form"><input type="hidden" name="post_id" value="' . $post->ID . '" /><input type="hidden" id="tweak_time_start" value="' . $date . '" />';
	$output     .= '<h2>Agenda Time Planner</h2>';
	$output     .= '<p>This screen allows you to see the time reserved for different parts of your meeting, which can be associated with either roles or notes on the agenda. Adding or rearranging elements of the agenda requires editing the underlying document, but this screen makes it easier to see how the times add up.</p>
	<p><strong>Time</strong> the base time for each activity</p>
	<p><strong>Count</strong> the number of occurrences for a role (Example: 3 Speakers, 3 Evaluators)</p>';

	$template_id = rsvpmaker_has_template( $post->ID );
	if ( $template_id ) {
		$output .= '<div style="margin: 5px; padding: 5px; border: medium solid gray;"><h4>Schedule for Single Event</h4><p>You are editing the schedule for a single event.</p><p>To change the schedule for most or all upcoming dates in this series, switch to the <a href="' . get_permalink( $template_id ) . '?tweak_times=1">event template</a></p>';
		$output .= ( current_user_can( 'edit_others_rsvpmakers' ) ) ? '<p>You will be prompted to update events based on the template</p>' : '<p>(You will need help from someone who can edit the template.)</p>';
		$output .= '</div>';
	}
	$output .= '<h4>Schedule</h4>';

	$rawdata = wpt_blocks_to_data( $new );

	foreach ( $data as $d ) {
		$t               = $ts_start + ( $elapsed * 60 );
		$start_time_text = rsvpmaker_date( $time_format, $t );
		if ( ! $start_time_text ) {
			$start_time_text = rsvpmaker_date( 'h:i A', $t );
		}
		$start_time = $elapsed;

		$time_allowed = ( empty( $d['time_allowed'] ) ) ? 0 : (int) $d['time_allowed'];

		$padding_time = ( empty( $d['padding_time'] ) ) ? 0 : (int) $d['padding_time'];

		$add = $time_allowed + $padding_time;

		$elapsed += $add;

		$editline = '';

		if ( ! empty( $d['role'] ) ) {
				$class = 'agenda_planner_role';
				$start = ( empty( $d['start'] ) ) ? 1 : $d['start'];
				$index = 'role_'.str_replace( ' ', '_', $d['role'] ) . '-' . $start;
				$label = (($d['role'] == 'custom')) ? $d['custom_role'] : $d['role'];
				//$label = $d['role'];
			if ( $d['role'] == 'Speaker' ) {
				$fields = sprintf( 'Time <input type="number" min="0" value="%s" class="time_allowed" id="time_allowed_%s" name="time_allowed[%s]" > Padding <input type="number" min="0" value="%s" class="padding_time" id="padding_time_%s" name="padding_time[%s]" > Count <input type="number" min="0" value="%s" class="count" id="count_%s" name="count[%s]" block_count="%s" role="%s" /> <input type="checkbox" class="role_remove" name="remove[%s]" value="%s"  block_count="%d" /> Remove', $time_allowed, $index, $index, $padding_time, $index, $index, $d['count'], $index, $index, $index, $d['role'], $index, $index, $block_count );
			} else {
				$fields = sprintf( 'Time <input type="number" min="0" value="%s" class="time_allowed" id="time_allowed_%s" name="time_allowed[%s]" > <input type="hidden" value="%s" class="padding_time" id="padding_time_%s" name="padding_time[%s]" > Count <input type="number" min="0" value="%s" class="count" id="count_%s" name="count[%s]" block_count="%s" role="%s" /> <input type="checkbox" class="role_remove" name="remove[%s]" value="%s" block_count="%d" /> Remove', $time_allowed, $index, $index, $padding_time, $index, $index, $d['count'], $index, $index, $index, $d['role'], $index, $index, $block_count );
			}
			if ( ( $d['role'] == 'Speaker' ) && ! rsvpmaker_is_template() ) {
				$fields .= role_count_time( $post->ID, $d );
			}
			if ( $d['role'] == 'Speaker' ) {
				$fields .= '<br /><strong>Padding</strong> (optional) is for a little extra time for transitions between speeches (Example: Allow 24 minutes for speeches and 1 additional Padding minute for introductions and setup)';
			}
		} elseif ( ! empty( $d['uid'] ) ) {
			$class = 'agenda_planner_note';
			$start = 1;
			$index = $d['uid'];
			$label = ( empty( $rawdata[ $index ]['content'] ) ) ? $index : 'Note: ' . substr( trim( strip_tags( $rawdata[ $index ]['content'] ) ), 0, 50 ) . '...';
			$index = str_replace( '.', '_', $index );
			if ( ! empty( $d['editable'] ) ) {
				$class    = 'agenda_planner_editable';
				$label    = $d['editable'];
				$html     = get_post_meta( $post->ID, 'agenda_note_' . $index, true );
				$excerpt  = ( empty( $html ) ) ? 'empty' : substr( strip_tags( $html ), 0, 75 ) . ' ...';
				$editline = sprintf( ' <div class="check-wrapper" id="check-wrapper-%s"><input id="check%s" type="checkbox" class="planner_edits_checkbox" name="edits[]" value="%s" /> Check to Edit: <em>%s</em></div><div class="planner_edits_wrapper" id="wrapper-%s"><textarea name="%s" class="mce">%s</textarea></div>', $index, $index, $index, $excerpt, $index, $index, $html );
			}
			$fields  = sprintf( 'Time <input type="number" min="0" value="%s" class="time_allowed" id="time_allowed_%s" name="time_allowed[%s]" > <input type="hidden" value="%s" class="padding_time" id="padding_time_%s" name="padding_time[%s]" > ', $time_allowed, $index, $index, $padding_time, $index, $index );
			$fields .= sprintf( ' <input type="checkbox" class="role_remove" name="remove[%s]" value="%s" block_count="%d" /> Remove', $index, $index, $block_count );
		} else {
			continue;
		}
		$output .= sprintf( '<div class="%s" id="timeline_%s"><p><strong><span id="calctime%s" class="calctime">%s</span> %s </strong><br />%s %s</p></div>', $class, $index, $block_count, $start_time_text, $label, $fields, $editline );
		$block_count++;
	}
	$output .= '<p>End <span id="tweak_time_end"></span></p><p><button>Update Times</button></p><p id="tweak_times_result"></p>';
	return $output;
}

function summarize_agenda_times( $editor_atts ) {
	global $rsvp_options, $post;

	$time_format = str_replace( 'T', '', $rsvp_options['time_format'] );
	if ( rsvpmaker_is_template( $post->ID ) ) {
		$sked = get_template_sked( $post->ID );
		$date = '2030-01-01 ' . $sked['hour'] . ':' . $sked['minutes'];
	} else {
		$date = get_rsvp_date( $post->ID );
	}
	$ts_start = rsvpmaker_strtotime( $date );

	$elapsed = 0;
	$time_array = array();
	$output      = '';
	$lines       = explode( "\n", $post->post_content );
	$block_count = 0;
	$uids        = array();
	$update      = false;
	$new         = '';
	foreach ( $lines as $index => $line ) {
		$pattern = '/{"role":[^}]+}/';
		preg_match( $pattern, $line, $match );
		if ( ! empty( $match[0] ) ) {
			$data[] = (array) json_decode( $match[0] );
			// $block_count++;
		} elseif ( strpos( $line, '-- wp:wp4toastmasters/agendanoterich2' ) || strpos( $line, '-- wp:wp4toastmasters/agendaedit' ) ) {
			$pattern = '/{.+}/';
			preg_match( $pattern, $line, $match );
			if ( ! empty( $match[0] ) ) {
				$atts = (array) json_decode( $match[0] );
				if ( in_array( $atts['uid'], $uids ) ) {
						$atts['uid'] = 'note' . rand( 100, 10000 );
						$line        = preg_replace( '/{.+}/', json_encode( $atts ), $line );
						$update      = true;
				}
				$uids[] = $atts['uid'];
				$data[] = $atts;
				// $block_count++;
			}
		}
		$new .= $line . "\n";
	}

	$block_count = 0;
	$output      = '<h2>Timing Summary</h2>';

	$rawdata = wpt_blocks_to_data( $new );

	foreach ( $data as $d ) {
		$t               = $ts_start + ( $elapsed * 60 );
		$start_time_text = rsvpmaker_date( $time_format, $t );
		if ( ! $start_time_text ) {
			$start_time_text = rsvpmaker_date( 'h:i A', $t );
		}
		$start_time = $elapsed;

		$time_allowed = ( empty( $d['time_allowed'] ) ) ? 0 : (int) $d['time_allowed'];

		$padding_time = ( empty( $d['padding_time'] ) ) ? 0 : (int) $d['padding_time'];

		if ( ! empty( $d['role'] ) ) {
			$editor_start = ( empty( $editor_atts['start'] ) ) ? 1 : $editor_atts['start'];
			$start = ( empty( $d['start'] ) ) ? 1 : $d['start'];
			if(isset($editor_atts['role']) && ($editor_atts['role'] == $d['role']) && ($start == $editor_start) ) {
				$bold = true;
				$time_allowed = ( empty( $editor_atts['time_allowed'] ) ) ? 0 : (int) $editor_atts['time_allowed'];
				$padding_time = ( empty( $editor_atts['padding_time'] ) ) ? 0 : (int) $editor_atts['padding_time'];
			}
			else
				$bold = false;
				$index = 'role_'.str_replace( ' ', '_', $d['role'] ) . '-' . $start;
				$label = (($d['role'] == 'custom')) ? $d['custom_role'] : wp4t_role_display($d['role']);
		} elseif ( ! empty( $d['uid'] ) ) {
			if(isset($editor_atts['uid']) && ($editor_atts['uid'] == $d['uid']) ) {
				$time_allowed = ( empty( $editor_atts['time_allowed'] ) ) ? 0 : (int) $editor_atts['time_allowed'];
				$bold = true;
			}
			else
				$bold = false;
			$start = 1;
			$index = $d['uid'];
			$label = ( empty( $rawdata[ $index ]['content'] ) ) ? $index : 'Note: ' . substr( trim( strip_tags( $rawdata[ $index ]['content'] ) ), 0, 50 ) . '...';
			$index = str_replace( '.', '_', $index );
			if ( ! empty( $d['editable'] ) ) {
				$label    = $d['editable'];
				$html     = get_post_meta( $post->ID, 'agenda_note_' . $index, true );
				$label .= ( empty( $html ) ) ? '' : ' '.substr( strip_tags( $html ), 0, 75 ) . ' ...';
			}
		} else {
			continue;
		}
		if($bold)
			$output .= sprintf('<div><strong>%s %s</strong></div>',$start_time_text, $label);
		else
			$output .= sprintf('<div>%s %s</div>',$start_time_text, $label);
		//$output .= sprintf( '<div class="%s" id="timeline_%s"><p><strong><span id="calctime%s" class="calctime">%s</span> %s </strong><br />%s %s</p></div>', $class, $index, $block_count, $start_time_text, $label, $fields, $editline );
		$block_count++;
		$add = $time_allowed + $padding_time;
		$elapsed += $add;
	}
	$start_time_text = rsvpmaker_date( $time_format, $t );
	$output .= sprintf('<div><strong>%s %s</strong></div>',$start_time_text, __('End','rsvpmaker-for-toastmasters'));
	return $output;
}

function random_available_check() {
	global $wpdb;
	global $post;
	global $current_user;
	global $random_available;
	if ( ! empty( $random_available ) ) {
		return $random_available;
	} else {
		$random_available = array();
	}
	if ( isset( $_REQUEST['rm'] ) ) {

		if ( isset( $_REQUEST['sure'] ) ) {
			$sure = (int) $_REQUEST['sure'];
			update_user_meta( $current_user->ID, 'assign_okay', $sure );
		}

		$sql     = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key LIKE '_role_%' AND post_id=$post->ID";
		$results = $wpdb->get_results( $sql );

		$preassigned = array();
		global $histories;
		if ( empty( $histories ) ) {
			$histories = tm_get_histories();
		}

		foreach ( $results as $row ) {
			if ( is_numeric( $row->meta_value ) ) {
				$preassigned[] = $row->meta_value;
			}
		}

		$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
		foreach ( $blogusers as $user ) {
			if ( isset( $_GET['debug'] ) ) {
				echo '<div style="background-color: #fff;">test user ' . $user->ID . ': <pre>';
				echo "\npreassigned";
				print_r( $preassigned );
				echo "\naway";
				print_r( $histories[ $user->ID ]->away_active );
				echo '</pre></div>';
			}

			if ( in_array( $user->ID, $preassigned ) ) {
				continue;
			}
			if ( ! empty( $histories[ $user->ID ]->away_active ) ) {
				continue;
			}
			$userdata = get_userdata( $user->ID );
			// if($userdata->hidden_profile)
			// continue;
			if ( is_array( $random_available ) ) {
				$random_available[] = $user->ID;
			} elseif ( isset( $_GET['debug'] ) ) {
				echo '<div>not an array"';
				print_r( $random_array );
				echo '"</div>';
			}
			if ( isset( $_GET['debug'] ) ) {
				echo '<div style="background-color: #fff;">add to array ' . $user->ID;
				print_r( $random_available );
				echo '</div>';
			}
		}
		if ( ! empty( $random_available ) && is_array( $random_available ) ) {
			shuffle( $random_available );
		}
	}
	return $random_available;
}

function pick_random_member( $role ) {
	global $random_available;
	global $histories;
	global $last_attended;
	global $last_filled;
	global $current_user;

	$attempts            = 0;
	$last_filled_limit   = get_option( 'last_filled_limit' );
	$last_attended_limit = get_option( 'last_attended_limit' );

	$assigned = array_shift( $random_available );
	if ( ! $histories[ $assigned ]->get_eligibility( $role ) ) {
		$random_available[] = $assigned; // put on end and try again
		$assigned           = array_shift( $random_available );
		if ( ! $histories[ $assigned ]->get_eligibility( $role ) ) {
			$random_available[] = $assigned; // put on end and try again
			$assigned           = array_shift( $random_available ); // may not be perfect, but ...
		}
	}

	if ( ! isset( $last_filled[ $role ][ $assigned ] ) ) {
		$last_filled[ $role ][ $assigned ] = $histories[ $assigned ]->get_last_held( $role );
		$last_attended[ $assigned ]        = get_latest_visit( $assigned );
	}

	if ( ! empty( $last_attended_limit ) ) {
		$last_attended_limit = strtotime( $last_attended_limit . ' days ago' ); // turn into timestamp
		while ( ( $last_attended[ $assigned ] == 'N/A' ) || ( $last_attended_limit > strtotime( $last_attended[ $assigned ] ) ) ) {
			$assigned = array_shift( $random_available );
			if ( ! isset( $last_attended[ $assigned ] ) ) {
				$last_filled[ $role ][ $assigned ] = $histories[ $assigned ]->get_last_held( $role );
				$last_attended[ $assigned ]        = get_latest_visit( $assigned );
			}
			$attempts++;
			if ( $attempts > 2 ) {
				continue;
			}
		}
	}
	return $assigned;
}

function awesome_members( $atts ) {
	if ( isset( $_GET['action'] ) ) {
		return; // don't let gutenberg try to display in editor
	}
	wp_suspend_cache_addition(true);
	ob_start();
	global $wpdb, $current_user;

	$wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );

	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
	foreach ( $blogusers as $user ) {

		if ( isset( $atts['paid_only'] ) ) {
			$paid = (int) get_user_meta( $user->ID, 'paid_until', true );
			if ( $paid < time() ) {
				continue;
			}
		}

		$userdata = get_userdata( $user->ID );
		// if($userdata->hidden_profile)
		// continue;
		$index = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );

		if ( is_array( $wp4toastmasters_officer_ids ) && in_array( $user->ID, $wp4toastmasters_officer_ids ) ) {
			$officers[ array_search( $user->ID, $wp4toastmasters_officer_ids ) ] = $userdata;
			$officer_emails[] = $userdata->user_email;
		} else {
			$members[ $index ] = $userdata;
			$clubemails[]      = $userdata->user_email;
		}
	}
	if ( is_club_member() ) {
		echo '<p><em>' . __( 'Contact details such as phone numbers and email are only displayed when you are logged into the website (and should only be used for Toastmasters business)', 'rsvpmaker-for-toastmasters' ) . '.</em></p>';
		if ( current_user_can( 'view_contact_info' ) ) {
			echo '<p><em>' . __( 'Related', 'rsvpmaker-for-toastmasters' ) . ': <a href="' . site_url() . '?print_contacts=1">' . __( 'Print Contact List', 'rsvpmaker-for-toastmasters' ) . '</a></em></p>';
		}
	} else {
		printf( '<p><em>%s <a href="%s">%s</a>.</em></p>', __( 'These members have chosen to create public profiles. For an expanded listing, members may', 'rsvpmaker-for-toastmasters' ), login_redirect( sanitize_text_field($_SERVER['REQUEST_URI']) ), __( 'login', 'rsvpmaker-for-toastmasters' ) );
	}

	if ( ! empty( $officers ) && is_array( $officers ) ) {
		ksort( $officers );
		foreach ( $officers as $officer_index => $officer ) {
			display_member( $officer, $wp4toastmasters_officer_titles[ $officer_index ] );
		}
	}
	if ( is_array( $members ) ) {
		ksort( $members );
		foreach ( $members as $userdata ) {
			if ( $userdata->user_login != '0_NOT_AVAILABLE' ) {
				display_member( $userdata );
			}
		}
	}

	if ( is_club_member() ) {
		if ( ! empty( $officer_emails ) && is_array( $officer_emails ) ) {
			$o = implode( ',', $officer_emails );
		}
		if ( ! empty( $clubemails ) && is_array( $clubemails ) ) {
			$c = implode( ',', $clubemails );
			if ( isset( $o ) ) {
				$c .= ',' . $o;
			}
			printf( '<p><a href="mailto:%s?subject=Toastmasters">' . __( 'Email All', 'rsvpmaker-for-toastmasters' ) . '</a></p>', $c );
		}
		if ( isset( $o ) ) {
			printf( '<p><a href="mailto:%s?subject=Toastmasters">' . __( 'Email Officers', 'rsvpmaker-for-toastmasters' ) . '</a></p>', $o );
		}
		printf( '<p><strong><em>%s</em></strong></p>', __( 'Email addresses and other contact information provided for Toastmasters business only.', 'rsvpmaker-for-toastmasters' ) );
	}
	wp_suspend_cache_addition(false);
	return ob_get_clean();
}

function display_member( $userdata, $title = '' ) {
	global $post, $current_user;

	$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['facebook_url'] = __( 'Facebook Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['twitter_url']  = __( 'Twitter Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['linkedin_url'] = __( 'LinkedIn Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['business_url'] = __( 'Business Web Address', 'rsvpmaker-for-toastmasters' );
	$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );

	$default_expires = date( 'Y-m-d', strtotime( '+1 Month' ) );
	if ( is_club_member() ) {
		$public_context = false;
	} elseif ( ! empty( $title ) || ( ( $userdata->public_profile == 1 ) || strtolower( trim( $userdata->public_profile ) ) == 'yes' ) ) {
		$public_context = true;
	} else {
		return;
	}
	?>
<div class="member-entry" style="margin-bottom: 50px; clear: both;">
	<?php
	echo $avatar = get_avatar( $userdata->ID );
	
	if ( ! empty( $title ) ) {
		printf( '<h3 style="clear: none;">%s</h3>', esc_attr($title) );
	}
	?>
<p id="member_<?php echo esc_attr($userdata->ID); ?>"><strong><?php echo esc_html(get_member_name($userdata->ID)); ?></strong> 
	</p>
	<?php
	if(	$userdata->tm_directory_blocked	)
		return;
		
	foreach ( $contactmethods as $name => $value ) {
		if ( strpos( $name, 'phone' ) ) {
			if ( ( ! $public_context ) && current_user_can( 'view_contact_info' ) && $userdata->$name ) {
				printf( '<div>%s: %s</div>', esc_html($value), esc_html($userdata->$name) );
			}
		}
		if ( strpos( $name, 'url' ) ) {
			if ( $userdata->$name && strpos( $userdata->$name, '://' ) ) {
				printf( '<div><a target="_blank" href="%s">%s</a></div>', esc_attr($userdata->$name), esc_attr($value) );
			}
		}
	}

	if ( ( ! $public_context && current_user_can( 'view_contact_info' ) ) || $userdata->public_email ) {
			$clubemail[] = $userdata->user_email;
			printf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>', esc_attr($userdata->user_email), esc_html($userdata->user_email) );
	}

	if ( $userdata->user_description ) {
		echo wpautop( '<strong>' . __( 'About Me', 'rsvpmaker-for-toastmasters' ) . ':</strong> ' . add_implicit_links( $userdata->user_description ) );
	}

	if ( ! $public_context && function_exists( 'bp_get_user_last_activity' ) && ! isset( $_REQUEST['email_prompt'] ) ) {
		printf( '<p><strong>%s</strong> %s</p>', __( 'BuddyPress Profile', 'rsvpmaker-for-toastmasters' ), bp_core_get_userlink( $userdata->ID ) );
	}

	$joinedslug = 'joined' . get_current_blog_id();
	if ( ! empty( $userdata->$joinedslug ) ) {
		printf( '<div class="club_join_date">%s: %s</div>', __( 'Joined Club', 'rsvpmaker-for-toastmasters' ), $userdata->$joinedslug );
	} elseif ( ! empty( $userdata->club_member_since ) ) {
		printf( '<div class="club_join_date">%s: %s</div>', __( 'Joined Club', 'rsvpmaker-for-toastmasters' ), $userdata->club_member_since );
	}
	if ( ! empty( $userdata->original_join_date ) ) {
		printf( '<div class="original_join_date">%s: %s</div>', __( 'Joined Toastmasters', 'rsvpmaker-for-toastmasters' ), $userdata->original_join_date );
	}
	if ( $userdata->ID == $current_user->ID ) {
		if ( function_exists( 'get_simple_local_avatar' ) ) {
			printf( '<p><a href="%s">%s</a></p>', admin_url( 'profile.php#simple-local-avatar-section' ), __( 'Set Your Profile Picture', 'rsvpmaker-for-toastmasters' ) );
		} elseif ( class_exists( 'WP_User_Avatar_Shortcode' ) ) {
			$picup = new WP_User_Avatar_Shortcode();
			echo str_replace( 'Profile Picture', __( 'Set Your Profile Picture', 'rsvpmaker-for-toastmasters' ), $picup->wpua_edit_shortcode( array() ) );
		}
		printf( '<p><a href="%s">%s</a>', admin_url( 'profile.php' ), __( 'Edit Your Profile', 'rsvpmaker-for-toastmasters' ) );
	}
	?>
</div>
	<?php

}

function wpt_member_upload_to_array() {
	global $current_user;
	$active_ids = array();
	$label      = array();
	$users      = array();
	$index      = 0;
	$csv_array  = array();
	if ( ! empty( $_FILES['upload_file']['tmp_name'] ) ) {
		$file = fopen( $_FILES['upload_file']['tmp_name'], 'r' );
		if ( $file ) {
			while ( ( $line = fgetcsv( $file ) ) !== false ) {
				// $line is an array of the csv elements
				array_push( $csv_array, $line );
			}
			fclose( $file );
		}
	} elseif ( ! empty( $_POST['spreadsheet'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$lines = explode( "\n", trim( sanitize_textarea_field($_POST['spreadsheet']) ) );
		foreach ( $lines as $linenumber => $line ) {
				$cells = explode( "\t", $line );
				array_push( $csv_array, $cells );
		}
	}
	if ( ! empty( $csv_array ) ) {
		foreach ( $csv_array as $linenumber => $cells ) {
			if ( $linenumber == 0 ) {
				foreach ( $cells as $index => $cell ) {
					if(strpos(strtoupper($cell),' ID'))
						$label['toastmasters_id'] = preg_replace('/[^0-9]/','',$index);
					else
						$label[ trim( $cell ) ] = $index;
				}
			} else {
				$user = array();

				if ( isset( $label['First Name'] ) ) {
					$user['first_name'] = $cells[ $label['First Name'] ];
					$user['last_name']  = $cells[ $label['Last Name'] ];
				} elseif ( isset( $label['First'] ) ) {
					$user['first_name'] = $cells[ $label['First'] ];
					$user['last_name']  = $cells[ $label['Last'] ];
				} elseif ( isset( $label['Name'] ) ) {
					$user = name2fields( $cells[ $label['Name'] ] );
				}
				$user['nickname'] = $user['display_name'] = $user['first_name'] . ' ' . $user['last_name'];
				if ( isset( $label['Paid Until'] ) ) {
					if ( time() > strtotime( $cells[ $label['Paid Until'] ] ) ) {
						continue;
					}
				}

				if ( ! empty( $label['Edu.'] ) && ! empty( $cells[ $label['Edu.'] ] ) ) {
					$user['education_awards'] = $cells[ $label['Edu.'] ];
				}

				if ( isset( $label['E-mail'] ) ) {
					$user['user_email'] = strtolower( trim( $cells[ $label['E-mail'] ] ) );
				} elseif ( isset( $label['Email'] ) ) {
					$user['user_email'] = strtolower( trim( $cells[ $label['Email'] ] ) );
				}
				if ( $user['user_email'] == strtolower( trim( $current_user->user_email ) ) ) {
					continue;
				}

				$user['user_login'] = preg_replace( '/[^a-z]/', '', strtolower( $user['first_name'] . $user['last_name'] ) );

				if ( isset( $label['Home Phone'] ) && isset( $cells[ $label['Home Phone'] ] ) ) {
					$user['home_phone'] = $cells[ $label['Home Phone'] ];
				} elseif ( isset( $label['Home'] ) ) {
					$user['home_phone'] = $cells[ $label['Home'] ];
				}

				if ( isset( $label['Work Phone'] ) ) {
					$user['work_phone'] = $cells[ $label['Work Phone'] ];
				} elseif ( isset( $label['Work'] ) ) {
					$user['work_phone'] = $cells[ $label['Work'] ];
				}

				if ( isset( $label['Cell'] ) ) {
					$user['mobile_phone'] = $cells[ $label['Cell'] ];
				} elseif ( isset( $label['Cell Phone'] ) ) {
					$user['mobile_phone'] = $cells[ $label['Cell Phone'] ];
				} elseif ( isset( $label['Mobile Phone'] ) ) {
					$user['mobile_phone'] = $cells[ $label['Mobile Phone'] ];
				} elseif ( isset( $label['Mobile'] ) ) {
					$user['mobile_phone'] = $cells[ $label['Mobile'] ];
				}

				$user['toastmasters_id'] = (empty($cells[ $label['toastmasters_id'] ])) ? '' : preg_replace('/[^0-9]+/','',$cells[ $label['toastmasters_id'] ]);

				$blog_id = get_current_blog_id();
				if ( isset( $label['Member of Club Since'] ) ) {
					$user['club_member_since']               = $cells[ $label['Member of Club Since'] ];
					$user[ 'club_member_since_' . $blog_id ] = $cells[ $label['Member of Club Since'] ];
				}
				if ( isset( $label['Paid Until'] ) ) {
					$user[ 'paid_until_' . $blog_id ] = $cells[ $label['Member of Club Since'] ];
				}
				if ( isset( $label['Original Join Date'] ) ) {
					$user['original_join_date'] = $cells[ $label['Original Join Date'] ];
				}

				$user['user_pass'] = password_hurdle( wp_generate_password() );

				$users[] = $user;
			}
		}
	}
	return $users;
}

function add_awesome_member() {

	rsvpmaker_admin_heading(__( 'Add Members', 'rsvpmaker-for-toastmasters' ), 'add_awesome_member');

	global $wpdb;
	global $current_user;
	$blog_id = get_current_blog_id();

	if ( ! empty( $_POST ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$_POST = stripslashes_deep( $_POST );
	}

	if ( isset( $_POST['addtid'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['addtid'] as $user_id => $member_id ) {
			$member_id = preg_replace('/[^0-9]/','',$member_id);
			$member_id = (int) $member_id;
			if ( $member_id ) {
				update_user_meta( (int) $user_id, 'toastmasters_id', $member_id );
			}
		}
	}

	if ( isset( $_POST['newuser'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$member_factory = new Toastmasters_Member();

		foreach ( $_POST['newuser'] as $index => $user ) {
				$type = ( ! empty( $_POST['new_or_existing'][ $index ] ) ) ? $_POST['new_or_existing'][ $index ] : 'new';
			if ( $type == 'new' ) {
				$user['confirmed'] = 1;
				$users[]           = $user;
			} else {
				$p       = explode( ':', $type );
				$user_id = (int) $p[0];
				make_blog_member( $user_id );
				$tid = (int) $p[1];
				if ( $tid ) {
					update_user_meta( $user_id, 'toastmasters_id', preg_replace('/[^0-9]/','',$tid) );
				}
				$userdata = get_userdata( $user_id );
				$msg      = $userdata->first_name . ' ' . $userdata->last_name . ' ' . __( 'added to website', 'rsvpmaker-for-toastmasters' );
				echo '<div class="notice notice-success is-dismissible"><p>' . $msg . '</p></div>';
			}
		}
		if ( ! empty( $users ) ) {
			if ( empty( $member_factory ) ) {
				$member_factory = new Toastmasters_Member();
			}
			foreach ( $users as $index => $user ) {
				$users[ $index ] = $member_factory->check( $user );
			}
			foreach ( $users as $user ) {
				if ( ! empty( $user ) ) {
					$active_ids[] = $member_factory->add( $user );
				}
			}
			$member_factory->show_prompts();
			$member_factory->show_confirmations();
		}
	}
	if ( isset( $_POST['remove_user'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['remove_user'] as $user_id ) {
			if ( function_exists( 'remove_user_from_blog' ) ) {
				remove_user_from_blog( (int) $user_id, $blog_id ); // multisite
			} else {
				wp_delete_user( (int) $user_id );
			}
		}
	}

	if ( isset( $_POST['member_ids'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['member_ids'] as $user_login => $member_id ) {
			$user              = array_map('sanitize_text_field',$_POST['verify'][ $user_login ]);
			$user['member_id'] = (int) $member_id;
			add_member_user( $user );
		}
	}

	if ( (! empty( $_POST['spreadsheet'] ) || ! empty( $_FILES )) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$active_ids = array();
		$users      = wpt_member_upload_to_array();
		if ( empty( $users ) ) {
			return;
		}

		$member_factory = new Toastmasters_Member();
		foreach ( $users as $index => $user ) {
			$users[ $index ] = $member_factory->check( $user );
		}
		foreach ( $users as $user ) {
			if ( ! empty( $user ) ) {
				$active_ids[] = $member_factory->add( $user );
			}
		}
		$member_factory->show_prompts();
		$member_factory->show_confirmations();
	}

	if ( isset( $_POST['first_name'] ) && $_POST['first_name'] && isset( $_POST['last_name'] ) && $_POST['last_name'] && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$user['user_login']      = sanitize_text_field(trim( $_POST['user_login'] ));
		$user['user_email']      = sanitize_text_field(trim( $_POST['email'] ));
		$user['user_pass']       = sanitize_text_field($_POST['user_pass']);
		$user['first_name']      = sanitize_text_field($_POST['first_name']);
		$user['last_name']       = sanitize_text_field($_POST['last_name']);
		$user['nickname']        = $user['display_name'] = sanitize_text_field($_POST['first_name'] . ' ' . $_POST['last_name']);
		$user['home_phone']      = sanitize_text_field($_POST['home_phone']);
		$user['work_phone']      = sanitize_text_field($_POST['work_phone']);
		$user['mobile_phone']    = sanitize_text_field($_POST['mobile_phone']);
		$user['toastmasters_id'] = (int) preg_replace('/[^0-9]/','',$_POST['toastmasters_id']);

		$member_factory = new Toastmasters_Member();
		$user           = $member_factory->check( $user );
		if ( ! empty( $user ) ) {
			$member_factory->add( $user );
		}
		$member_factory->show_prompts();
		$member_factory->show_confirmations();
	}

	$user_pass_default = password_hurdle( wp_generate_password() );

	if ( isset( $_POST['resend'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$member_factory = new Toastmasters_Member();
		foreach ( $_POST['resend'] as $resend ) {
			$user = get_userdata( (int) $resend );
			$member_factory->sendWelcome(
				array(
					'user_login' => $user->user_login,
					'user_email' => $user->user_email,
				), $user->user_id
			);
		}
		$member_factory->show_confirmations();
	}

	if ( isset( $_POST['existing_email'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$email_exists = get_user_by( 'email', sanitize_text_field($_POST['existing_email']) );
		if ( $email_exists ) {
			if ( is_multisite() ) {
				add_user_to_blog( get_current_blog_id(), $email_exists->ID, 'subscriber' );
			}
			echo '<div class="notice notice-success is-dismissible"><p>' . __( 'Added user', 'rsvpmaker-for-toastmasters' ) . ': ' . $email_exists->user_login . '<p></div>';
		} else {
			echo '<div class="notice notice-error is-dismissible"><p>' . __( 'No user record found for', 'rsvpmaker-for-toastmasters' ) . ': ' . sanitize_text_field($_POST['existing_email']) . '<p></div>';
		}
	}

	?>

		<div class="wrap">

<div id="ajax-response"></div>

<p><?php _e( 'Create a website user account for a new member. The only required fields are name and email address.', 'rsvpmaker-for-toastmasters' ); ?></p>
<form action="<?php echo admin_url( 'users.php?page=add_awesome_member' ); ?>" method="post" name="createuser" id="createuser" class="add:users: validate">
<input name="action" type="hidden" value="createuser" />
<input type="hidden" id="_wpnonce_create-user" name="_wpnonce_create-user" value="6f56987dd6" /><input type="hidden" name="_wp_http_referer" value="/wp-admin/user-new.php" /><table class="form-table">
	<tr class="form-field form-required">
		<th scope="row"><label for="user_login"><?php _e( 'Username', 'rsvpmaker-for-toastmasters' ); ?> <span class="description"></span></label></th>
		<td><input name="user_login" type="text" id="user_login" value="" aria-required="true" />
		<br /><?php _e( 'Hint: try the part of the email before the @ sign. If you leave this blank, a username will be assigned based on first and last name.', 'rsvpmaker-for-toastmasters' ); ?>
		<br /><?php _e( 'If a member does not have an email address, or shares an email address with someone else, leave the email field blank. Since WordPress requires an email address, a nonworking address will be assigned in the format firstnamelastname@example.com (example.com is an Internet domain name reserved for examples and tests).', 'rsvpmaker-for-toastmasters' ); ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="email"><?php _e( 'Email', 'rsvpmaker-for-toastmasters' ); ?></label></th>
		<td><input name="email" type="text" id="email" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e( 'First Name', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="first_name" type="text" id="first_name" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="last_name"><?php _e( 'Last Name', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="last_name" type="text" id="last_name" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="home_phone"><?php _e( 'Home Phone', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="home_phone" type="text" id="home_phone" value="" /></td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="work_phone"><?php _e( 'Work Phone', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="work_phone" type="text" id="work_phone" value="" /></td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="mobile_phone"><?php _e( 'Mobile Phone', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="mobile_phone" type="text" id="mobile_phone" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e( 'Toastmasters ID #', 'rsvpmaker-for-toastmasters' ); ?> </label></th>
		<td><input name="toastmasters_id" type="text" id="toastmasters_id" value="" /></td>
	</tr>
	</table>
<p>You will be prompted to confirm this information on the next page.</p>
<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e( 'Add Member (Step 1 of 2)', 'rsvpmaker-for-toastmasters' ); ?>"  /></p>
<?php rsvpmaker_nonce(); ?>
</form>

	<?php
	if ( is_multisite() ) {
		?>
<h3><?php _e( 'Add member to site by email', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p>Users who are members of other clubs whose websites are hosted here can be added by entering the member's email address. This must be the same email address they use on the other club's website.</p>
<form action ="<?php echo admin_url( 'users.php?page=add_awesome_member' ); ?>" method="post">
	<p><strong>Email:</strong> <input type="text" name="existing_email" ></p>
<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e( 'Add By Email', 'rsvpmaker-for-toastmasters' ); ?>"  /></p>
<?php rsvpmaker_nonce(); ?>
</form>

		<?php
	}
	?>
<div id="import">
<h3><?php _e( 'Batch Import From Toastmasters.org spreadsheet', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p><?php _e( 'If you download the member spreadsheet from toastmasters.org, you can import it here to create or update member records.', 'rsvpmaker-for-toastmasters' ); ?></p>
<form method="post" enctype="multipart/form-data" action="<?php echo admin_url( 'users.php?page=add_awesome_member' ); ?>">
<p><?php _e( 'Select file to upload', 'rsvpmaker-for-toastmasters' ); ?>: <input type="file" name="upload_file" /></p>
<p><?php _e( 'Alternative: you can open the CSV export file in Excel, then copy-and-paste records (including the header row of column labels) into the field below (use CTRL-C to copy, CTRL-V to paste on Windows).', 'rsvpmaker-for-toastmasters' ); ?></p>
<p><?php _e( 'If you do not have access to Club Central, you can use the same copy-and-paste method after putting member names and email addresses in this spreadsheet: ', 'rsvpmaker-for-toastmasters' ); ?><a href="https://www.wp4toastmasters.com/wp-content/uploads/2023/07/Club-Member-Import.xlsx">Excel</a> or <a href="https://docs.google.com/spreadsheets/d/16ZqaQXKcxpMsUEYPOyx9tHVrDkL7Zdd4/edit?usp=sharing&ouid=113166369746212246457&rtpof=true&sd=true">Google Sheets</a> (make a copy).</p>
<p><textarea cols="80" rows="3" name="spreadsheet"></textarea></p>
	<div><input type="checkbox" name="check_missing" value="1" /> <?php _e( 'Check for missing members (if you post a complete list of current members, this checkbox triggers a check of which website users are NOT currently on the toastmasters.org list and gives you an option to delete them).', 'rsvpmaker-for-toastmasters' ); ?></div>
	<div>
	<?php
	clean_toastmasters_id();
	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
	$addids    = '';
	// Array of WP_User objects.
	foreach ( $blogusers as $user ) {
		$tid = get_user_meta( $user->ID, 'toastmasters_id', true );
		if ( empty( $tid ) ) {
			$addids .= sprintf( '<div><input type="text" name="addtid[%d]"> %s %s %s</div>', $user->ID, get_user_meta( $user->ID, 'first_name', true ), get_user_meta( $user->ID, 'last_name', true ), $user->user_email );
		}
	}
	if ( ! empty( $addids ) ) {
		echo '<p>';
		_e( 'For better results when synchronizing with your list, add IDs for these members.' );
		echo '</p>';
		echo $addids;
	}

	?>
	</div>

<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e( 'Import', 'rsvpmaker-for-toastmasters' ); ?>"  /></p>
<?php rsvpmaker_nonce(); ?>
</form>
<p><img src="<?php echo plugins_url( 'spreadsheet.png', __FILE__ ); ?>" width="500" height="169" /></p>
</div>

<div id="resend">
<h3>Resend Welcome Message</h3>
	<p>If members did not receive the email inviting them to set their password, or if you added them before turning on email notifications, you can resend those notifications by checking off the names below and clicking Send. Note that this will generate a new password reset code (invalidating any that may have been sent previously).</p>
<form method="post" action="<?php echo admin_url( 'users.php?page=add_awesome_member' ); ?>">
	<p><input type="checkbox" id="checkAll"> <strong>Check all</strong></p>
	<?php
	$blogusers = get_users( 'orderby=nicename&blog_id=' . get_current_blog_id() );
	// Array of WP_User objects.
	foreach ( $blogusers as $user ) {
		printf( '<div><input type="checkbox" class="resend" name="resend[]" value="%d">%s %s</div>', $user->ID, $user->user_login, $user->display_name );
	}
	?>
<input type="submit" value="<?php _e( 'Send', 'rsvpmaker-for-toastmasters' ); ?>" />
<?php rsvpmaker_nonce(); ?>
</form>	
</div>

</div>
<script>
(function($) {
$("#checkAll").change(function () {
	$(".resend").prop('checked', $(this).prop("checked"));
});	
})( jQuery );
</script>
	<?php
}

function extract_fields_tm( $matches ) {
	// used with paste from HTML display on toastmasters.org
	foreach ( $matches[1] as $index => $webfield ) {
		if ( $webfield == 'Email' ) {
			$contact['user_email'] = trim( $matches[2][ $index ] );
			$ep                    = explode( '@', $contact['user_email'] );
		} else {
			$phone = trim( $matches[2][ $index ] );
			$phone = str_replace( ' ', '', $phone );
			$phone = str_replace( '1(', '(', $phone );
			if ( $webfield == 'Home' ) {
				$contact['home_phone'] = $phone;
			} elseif ( $webfield == 'Work' ) {
				$contact['work_phone'] = $phone;
			} elseif ( $webfield == 'Cell' ) {
				$contact['mobile_phone'] = $phone;
			}
		}
	}
	return $contact;
}

function name2fields( $name ) {
	$edpattern = '/, ([A-Z0-9]{2,6})/';
	preg_match_all( $edpattern, $name, $matches );
	$user['nickname']   = $user['display_name'] = preg_replace( $edpattern, '', $name );
	$np                 = explode( ' ', $user['display_name'] );
	$user['last_name']  = array_pop( $np );
	$user['first_name'] = implode( ' ', $np );
	if ( ! empty( $matches[1][0] ) ) {
		$user['education_awards'] = implode( ', ', $matches[1] );
	}
	return $user;
}

function get_user_by_tmid( $id ) {
	$args  = array(
		'meta_key'     => 'toastmasters_id',
		'meta_compare' => '=',
		'meta_value'   => $id,
	);
	$users = get_users( $args );
	if ( $users ) {
		return $users[0];
	}
}

function make_blog_member( $user_id, $blog_id = 0, $role = 'subscriber' ) {
	if ( ! is_multisite() ) {
		return;
	}
	if($blog_id)
		switch_to_blog($blog_id);
	else
		$blog_id = get_current_blog_id();

	if ( ! is_user_member_of_blog( $user_id, $blog_id ) ) {
		add_user_to_blog( $blog_id, $user_id, $role );
		$w = get_option( 'wp4toastmasters_welcome_message' );
		if ( ! empty( $w ) ) {
			$p = get_post( $w );
			if ( ! empty( $p->post_content ) ) {
				$welcome = '<h1>' . $p->post_title . "</h1>\n\n" . wpautop( $p->post_content );
			}
		} else {
			$welcome = '';
		}

		$userdata = get_userdata( $user_id );

		$blogs    = get_blogs_of_user( $user_id );
		$bloglist = '';
		if ( ! empty( $blogs ) ) {
			foreach ( $blogs as $blog ) {
				$bloglist .= ( empty( $bloglist ) ) ? 'You are a member of these sites: ' : ', ';
				$bloglist .= sprintf( '<a href="%s">%s</a>', $blog->siteurl, $blog->blogname );
			}
		}

		$message  = '<p>' . __( 'You have been registered at' ) . ': ' . site_url() . '</p>';
		$message .= '<p>' . __( 'Username' ) . ': ' . $userdata->user_login . '</p>';
		$message .= '<p>' . $bloglist . '</p>';
		$message .= '<p>To reset your password, visit <a href="' . site_url() . '/wp-login.php?action=lostpassword">' . site_url() . '/wp-login.php?action=lostpassword</a></p>
		
		<p>Your password is the same for all the sites listed above.</p>';
		$message .= '<p>' . __( 'For a basic orientation to the website setup we are using, see the <a href="http://wp4toastmasters.com/new-member-guide-to-wordpress-for-toastmasters/">New Member Guide to WordPress for Toastmasters</a>', 'rsvpmaker-for-toastmasters' ) . '</p>';

			$admin_email      = get_bloginfo( 'admin_email' );
			$mail['subject']  = 'Welcome to ' . get_bloginfo( 'name' );
			$mail['replyto']  = $admin_email;
			$mail['html']     = "<html>\n<body>\n" . $message . $welcome . "\n</body></html>";
			$mail['to']       = $userdata->user_email;
			$mail['cc']       = $admin_email;
			$mail['from']     = $admin_email;
			$mail['fromname'] = get_bloginfo( 'name' );
			$return      = awemailer( $mail );
		if ( $return ) {
			printf( '<p style="color: red;">Emailing to %s</p>', $userdata->user_email );
		}
		echo wp_kses_post($message);
	}

}

class Toastmasters_Member {

	public $prompts;
	public $confirmations;
	public $active_ids;
	public $blog_id;
	public $welcome;
	public $prompt_count;
	public $sync_time;

	function __construct() {
		$this->prompt_count = 0;
		$this->blog_id      = get_current_blog_id();
		$this->sync_time    = time();
		$welcome            = '';
		$w                  = get_option( 'wp4toastmasters_welcome_message' );
		if ( ! empty( $w ) ) {
			$p = get_post( $w );
			if ( ! empty( $p->post_content ) ) {
				$welcome = '<h1>' . $p->post_title . "</h1>\n\n" . wpautop( $p->post_content );
			}
		}
	}

	function add( $user ) {
		$member_id = ( ! empty( $user['ID'] ) ) ? $user['ID'] : 0;
		if ( $member_id ) {
			$name               = get_member_name( $member_id );
			$this->active_ids[] = $member_id;
			if ( is_multisite() && ! is_user_member_of_blog( $member_id, $this->blog_id ) && ! user_can( $member_id, 'manage_options' ) ) {
				add_user_to_blog( $this->blog_id, $member_id, 'subscriber' );
				$this->confirmation[] = $name . ' ' . __( 'added to this site', 'rsvpmaker-for-toastmasters' );
			}
			if ( ! empty( $user['toastmasters_id'] ) && ! get_user_meta( $member_id, 'toastmasters_id', true ) ) {
				$this->confirmation[] = $name . ' ' . __( 'adding Toastmasters ID', 'rsvpmaker-for-toastmasters' );
				update_user_meta( $member_id, 'toastmasters_id', preg_replace('/[^0-9]/','',$user['toastmasters_id']) );
			}
			if ( ! empty( $user['education_awards'] ) ) {
				$this->confirmation[] = $name . ' ' . __( 'educational awards updated', 'rsvpmaker-for-toastmasters' );
				update_user_meta( $member_id, 'education_awards', $user['education_awards'] );
			}
			if ( ! empty( $user['club_member_since'] ) ) {
				update_user_meta( $member_id, 'club_member_since', $user['club_member_since'] );
				update_user_meta( $member_id, 'joined' . get_current_blog_id(), $user['club_member_since'] );
			}
			if ( ! empty( $user['original_join_date'] ) ) {
				update_user_meta( $member_id, 'original_join_date', $user['original_join_date'] );
			}
			return $member_id;
		} else {
			// register user
			if ( isset( $user['ID'] ) ) {
				unset( $user['ID'] ); // if set but empty, discard
			}
			if ( $user_id = wp_insert_user( $user ) ) {
				$this->active_ids[] = $user_id;
				// Generate something random for a password reset key.
				$this->sendWelcome( $user, $user_id );
				if ( empty( $user['club_member_since'] ) ) {
					update_user_meta( $user_id, 'joined' . get_current_blog_id(), rsvpmaker_date( 'm/d/Y' ) );
				} else {
					update_user_meta( $user_id, 'joined' . get_current_blog_id(), $user['club_member_since'] );
				}
				if ( ! empty( $user['application_id'] ) ) {
					update_user_meta( $user_id, 'application_id_' . get_current_blog_id(), $user['application_id'] );
					$until = get_post_meta($user['application_id'],'tm_application_until',true);
					update_user_meta($user_id,'tm_renew_until_'.get_current_blog_id(),$until);
					$email_prompt = get_post_meta($user['application_id'],'tm_privacy_prompt',true);
					if($email_prompt != '') {
						update_user_meta($user_id,'tm_privacy_prompt',intval($email_prompt));
						update_user_meta($user_id,'tm_directory_blocked',intval(get_post_meta($user['application_id'],'tm_directory_blocked',true)));
					}
				}
				} else {
				echo '<h3 style="color: red;">WordPress ' . __( 'registration error', 'rsvpmaker-for-toastmasters' ) . '</h3>';
				print_r( $user );
				echo '<br />';
			}
		}

		return $user_id;
	}

	function sendWelcome( $user, $user_id ) {
		$key = wp_generate_password( 20, false );

		do_action( 'retrieve_password_key', $user['user_login'], $key );

		// Now insert the key, hashed, into the DB.
		if ( empty( $wp_hasher ) ) {
			require_once ABSPATH . WPINC . '/class-phpass.php';
			$wp_hasher = new PasswordHash( 8, true );
		}
		$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
		global $wpdb;
		$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user['user_login'] ) );
		$set_password_msg = __( 'To set your password, visit the following address:' );
		$site_url = apply_filters('wpt_welcome_site_url',site_url());
		$set_password = $site_url. "/wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user['user_login']);

		$set_password = apply_filters( 'welcome_message_set_password', $set_password, $key, $user['user_login'] );

		$profile_url = admin_url( 'profile.php#user_login' );
		$message     = '<p>' . __( 'You have been registered at' ) . ': ' . site_url() . '</p>';
		$message    .= '<p>' . __( 'Username' ) . ': ' . $user['user_login'] . '</p>';
		$message    .= '<p>' . $set_password_msg . '<br /><a href="' . $set_password . '">' . $set_password . '</a></p>';
		$message    .= '<p>After setting your password, you will use <a href="' . wp_login_url() . '">' . wp_login_url() . '</a> when logging in to sign up for roles or do other club business.</p>';
		
		$message    .= '<p>' . __( 'For a basic orientation to the website setup we are using, see the <a href="http://wp4toastmasters.com/new-member-guide-to-wordpress-for-toastmasters/">New Member Guide to WordPress for Toastmasters</a>', 'rsvpmaker-for-toastmasters' ) . '</p>';
		$message    .= '<p>' . __( 'Note that your club website user name and password are <em>not</em> the same as the credentials you will use on toastmasters.org (the website of Toastmasters International) to access Pathways educational materials.', 'rsvpmaker-for-toastmasters' ) . '</p>';
		$message    .= apply_filters('wpt_set_password_host_note','');

		$welcome_id = get_option( 'wp4toastmasters_welcome_message' );
		if ( $welcome_id ) {
			$welcome = get_post( $welcome_id );
			if ( ! empty( $welcome->post_content ) ) {
				if ( strpos( $welcome->post_content, '!--' ) ) {
					$welcome->post_content = do_blocks( $welcome->post_content );
				}
				if ( ! strpos( $welcome->post_content, '</p>' ) ) {
					$welcome->post_content = wpautop( $welcome->post_content );
				}
				$message .= '<h2>' . $welcome->post_title . "</h2>\n" . $welcome->post_content;
			}
		}

		if ( isset( $_POST['no_email'] ) && $_POST['no_email'] ) {
			echo '<h3>' . __( 'Email notification disabled', 'rsvpmaker-for-toastmasters' ) . '</h3><pre>' . $message . '</pre>';
		} else {
			$admin_email      = get_bloginfo( 'admin_email' );
			$mail['subject']  = 'Welcome to ' . get_bloginfo( 'name' );
			$mail['replyto']  = $admin_email;
			$mail['html']     = "<html>\n<body>\n" . $message . $this->welcome . "\n</body></html>";
			$mail['to']       = $user['user_email'];
			$mail['cc']       = $admin_email;
			$mail['from']     = $admin_email;
			$mail['fromname'] = get_bloginfo( 'name' );
			$mail['skip_check'] = true;
			$return           = awemailer( $mail );
			$message .= $return;
			if(!isset($user['tm_application_id']))
				update_user_meta($user_id,'tm_privacy_prompt',1);
			if ( $return === false ) {
				$this->confirmations[] = '<h3>' . __( 'Emailing notifications disabled', 'rsvpmaker-for-toastmasters' ) . '</h3><pre>' . $message . '</pre>';
			} else {
				$this->confirmations[] = '<h3>' . __( 'Emailing to', 'rsvpmaker-for-toastmasters' ) . ' ' . $user['user_email'] . '</h3>' . wpautop( $message );
			}
		}
	}

	function check( $user ) {
		foreach ( $user as $name => $value ) {
			$user[ $name ] = trim( $value );
		}
		if ( empty( $user['first_name'] ) || empty( $user['last_name'] ) ) {
			return;
		}

		if ( empty( $user['user_login'] ) ) {
			// assign based on first name or first+last
			$user['user_login'] = preg_replace( '/[^a-z]/', '', strtolower( $user['first_name'] ) );
			if ( get_user_by( 'login', $user['user_login'] ) ) {
				$user['user_login'] = preg_replace( '/[^a-z]/', '', strtolower( $user['first_name'] . $user['last_name'] ) );
			}
		}
		if ( empty( $user['user_login'] ) ) {
			return;
		}

		if ( empty( $user['user_email'] ) ) {
			$user['user_email'] = $user['user_login'] . '@example.com';
		}
		if ( empty( $user['user_pass'] ) ) {
			$user['user_pass'] = wp_generate_password();
		}
		if ( ! empty( $user['member_id'] ) ) {
			$member_id     = (int) $user['member_id'];
			$member_exists = get_user( $member_id );
			if ( ! empty( $member_exists->ID ) ) {
				$this->confirmations[] = $user['first_name'] . ' ' . $user['last_name'] . ' recognized by user ID';
				$this->active_ids[]    = $member_exists->ID;
				$user['ID']            = $member_exists->ID;
				return $user;
			}
		} else {
			if ( ! empty( $user['toastmasters_id'] ) ) {
				$user['toastmasters_id'] = (int) $user['toastmasters_id']; // get rid of any zero padding
				$member_exists           = get_user_by_tmid( $user['toastmasters_id'] );
				if ( ! empty( $member_exists->ID ) ) {
					$this->confirmations[] = $user['first_name'] . ' ' . $user['last_name'] . ' recognized by Toastmasters ID';
					$this->active_ids[]    = $member_exists->ID;
					$user['ID']            = $member_exists->ID;
					return tm_sync_fields( $user );
				}
			}
			$login_exists = get_user_by( 'login', $user['user_login'] );
			$email_exists = get_user_by( 'email', $user['user_email'] );
			if ( ( $login_exists && $email_exists ) && ( $login_exists->ID == $email_exists->ID ) ) {
				$user['ID']            = $login_exists->ID;
				$this->confirmations[] = get_member_name( $login_exists->ID ) . ' recognized by name and email';
				return $user; // add the toastmasters ID
			} elseif ( $email_exists ) {
				$tmid = get_user_meta( $email_exists->ID, 'toastmasters_id', true );
				if ( empty( $tmid ) && ! empty( $user['toastmasters_id'] ) ) {
					$user['ID'] = $email_exists->ID;
					return tm_sync_fields( $user ); // right user, no tmid
				} elseif ( ! empty( $tmid ) && ! empty( $user['toastmasters_id'] ) && ( $tmid != $user['toastmasters_id'] ) ) {
					// different person with same email address
					$user['user_email']    = $user['user_login'] . '@example.com';
					$this->confirmations[] = '<span style="color: red;">' . $user['first_name'] . ' ' . $user['last_name'] . ' appears to have the same email address as ' . get_member_name( $email_exists->ID ) . ': ' . $email_exists->user_email . '(set to ' . $user['user_email'] . ' instead to keep records distinct)</span>';
					return tm_sync_fields( $user );
				} else {
					$this->prompts[] = '<span style="color: red;">' . $user['first_name'] . ' ' . $user['last_name'] . ' appears to have the same email address as ' . get_member_name( $email_exists->ID ) . ': ' . $email_exists->user_email . ' Each user must have a distinct email address.</span><br />' . $this->prompt_fields( $user, $email_exists );
					return;
				}
			}
			if ( ! rsvpmail_contains_email( $user['user_email'] ) && ! strpos( $user['user_email'], 'example.com' ) ) {
				$this->prompts[] = '<span style="color: red;">' . __( 'Error: invalid email address', 'rsvpmaker-for-toastmasters' ) . ' ' . $user['user_email'] . '</span><br />' . $this->prompt_fields( $user );
				 return;
			}

			if ( $login_exists ) {
				for ( $i = 0; $i < 100; $i++ ) {
					$suffix   = ( $i ) ? $i : '';
					$newlogin = preg_replace( '/[^A-Za-z]/', '', strtolower( $user['first_name'] ) ) . $suffix;
					if ( ! get_user_by( 'login', $newlogin ) ) {
						$user['user_login'] = $newlogin;
						break;
					}
				}
				$this->prompts[] = $this->prompt_fields( $user, $login_exists );
				return;
			}

			if ( ! empty( $user['confirmed'] ) ) {
				return $user;
			} else {
				$this->prompts[] = $this->prompt_fields( $user );
			}
		}
	}

	function prompt_fields( $user, $other_user = null ) {
		$o       = '';
		$visible = array( 'user_login', 'first_name', 'last_name', 'educational_awards', 'user_email', 'home_phone', 'work_phone', 'mobile_phone', 'toastmasters_id', 'club_member_since', 'original_join_date', 'application_id' );

		if ( empty( $other_user ) ) {
			$o = '<h3>New</h3>';
		} else {
			$member   = ( is_user_member_of_blog( $other_user->ID ) ) ? '' : '<div>(user account not currently associated with this club website)</div>';
			$userdata = get_userdata( $other_user->ID );
			$tid      = empty( $user['toastmasters_id'] ) ? '' : $user['toastmasters_id'];
			$o       .= sprintf( '<h3><input type="radio" name="new_or_existing[%d]" value="%d:%d" checked="checked" /> Add this existing record?</h3>%s', $this->prompt_count, $other_user->ID, $tid, $member );
			foreach ( $visible as $field ) {
				$value = ( empty( $userdata->$field ) ) ? '' : $userdata->$field;
				$o    .= sprintf( '<div>%s %s</div>', $field, $value );
			}
			$blogs    = get_blogs_of_user( $other_user->ID );
			$bloglist = '';
			foreach ( $blogs as $blog ) {
				$bloglist  = ( empty( $bloglist ) ) ? 'Member of: ' : ', ';
				$bloglist .= $blog->blogname;
			}
			$o .= '<div>' . $bloglist . '</div>';
			$o .= '<h3><input type="radio" name="new_or_existing[%d]" value="skip" /> Skip entry for ' . $user['display_name'] . '</h3>';
			$o .= sprintf( '<h3><input type="radio" name="new_or_existing[%d]" value="new" /> Or record as new member?</h3><p><em>Email address must change. System will accept @example.com placeholder emails.</em></p><div>', $this->prompt_count );
		}
		$o .= '<table>';
		foreach ( $visible as $field ) {
			$value = ( empty( $user[ $field ] ) ) ? '' : $user[ $field ];
			$o    .= sprintf( '<tr><td>%s</td><td><input type="text" name="newuser[%d][%s]" value="%s" ></td></tr>', $field, $this->prompt_count, $field, $value );
		}
		$o .= '</table>';

		$this->prompt_count++;
		return $o;

	}

	function show_prompts() {
		$o       = '';
		$missing = '';
		if ( ! empty( $this->prompts ) ) {
			foreach ( $this->prompts as $p ) {
				$o .= '<p class="prompt">' . $p . '</p>';
			}
		}
		if ( ! empty( $_POST['check_missing'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			global $current_user;
			$this->active_ids[] = $current_user->ID;
			$blogusers          = get_users( 'blog_id=' . get_current_blog_id() );
			foreach ( $blogusers as $user ) {
				if ( ! in_array( $user->ID, $this->active_ids ) ) {
					if ( $user->user_login == '0_NOT_AVAILABLE' ) {
						continue;
					}
					$userdata = get_userdata( $user->ID );
					$missing .= sprintf( '<p><input type="checkbox" name="remove_user[%d]" value="%d"> Remove: %s (%s) </p>', $user->ID, $user->ID, $userdata->display_name, $userdata->user_login );
				}
			}

			if ( ! empty( $missing ) ) {
				$o .= '<p>' . _e( "The members below don't show up on the current list. Check those who should be deleted.", 'rsvpmaker-for-toastmasters' ) . '</p>' . $missing;
			}
		}
		if ( ! empty( $o ) ) {
			?>
<h3>Verify Member Accounts to Be Added or Removed</h3>
<form method="post" action="<?php echo admin_url( 'users.php?page=add_awesome_member' ); ?>">
			<?php
			echo $o; //escaping happens above
			?>
<p><input type="checkbox" name="no_email" value="1" 
			<?php
			if ( isset( $_POST['no_email'] ) ) {
				echo ' checked="checked" ';}
			?>
	 /> Do not send email invites (for example, if you are still testing the site).</p> 
<input type="submit"  class="button-primary" value="<?php _e( 'Confirm Add Member(s)', 'rsvpmaker-for-toastmasters' ); ?>" />
<?php rsvpmaker_nonce(); ?>
</form>
			<?php
		}
	}
	function show_confirmations() {
		if ( empty( $this->confirmations ) ) {
			return;
		} else {
			foreach ( $this->confirmations as $conf ) {
				echo '<div class="confirmation">' . wp_kses_post($conf) . '</div>';
			}
		}
	}
}

function add_member_user( $user, $override_check = false ) {
	$member_factory = new Toastmasters_Member();
	if ( ! $override_check ) {
		$user = $member_factory->check( $user );
	}
	if ( ! empty( $user ) ) {
		$member_factory->add( $user );
		$member_factory->show_prompts();
		$member_factory->show_confirmations();
	}
}

function awesome_contactmethod( $contactmethods ) {
	clean_toastmasters_id();
	$contactmethods['other_email']       = __( 'Other Email', 'rsvpmaker-for-toastmasters' );
	$contactmethods['home_phone']       = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['work_phone']       = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['mobile_phone']     = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['facebook_url']     = __( 'Facebook Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['twitter_url']      = __( 'Twitter Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['linkedin_url']     = __( 'LinkedIn Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['business_url']     = __( 'Business Web Address', 'rsvpmaker-for-toastmasters' );
	$contactmethods['toastmasters_id']  = 'Toastmasters ID';
	$contactmethods['education_awards'] = 'Toastmasters Awards (DTM etc)';
	unset( $contactmethods['yim'] );
	unset( $contactmethods['aim'] );
	unset( $contactmethods['jabber'] );
	unset( $contactmethods['url'] );
	return $contactmethods;
}

function login_redirect( $link ) {
	if ( is_club_member() ) {
		return $link;
	} else {
		return site_url() . '/wp-login.php?redirect_to=' . urlencode( $link );
	}
}

/**
 * CPEventsWidget Class
 */
class AwesomeWidget extends WP_Widget {
	/** constructor */
	function __construct() {
		parent::__construct( 'rsvptoast_widget', $name = 'Member Access' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );
		$instance   = apply_filters( 'tm_widget_settings', $instance );
		$title      = ( isset( $instance['title'] ) ) ? $instance['title'] : 'Member Access';
		$limit      = ( isset( $instance['limit'] ) ) ? $instance['limit'] : 10;
		$showmore   = ( isset( $instance['showmore'] ) ) ? $instance['showmore'] : 4;
		$showlog    = ( isset( $instance['showlog'] ) ) ? $instance['showlog'] : 1;
		$dateformat = ( isset( $instance['dateformat'] ) && strpos( $instance['dateformat'], '%s' ) ) ? $instance['dateformat'] : '%b %e';
		if ( $showlog ) {
			$activity_sql = "SELECT meta_value, post_id from $wpdb->postmeta JOIN $wpdb->posts ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE meta_key='_activity' ORDER BY meta_id DESC LIMIT 0,5";
			$log          = $wpdb->get_results( $activity_sql );
		} else {
			$log = false;
		}

		global $rsvp_options;
		?>
			  <?php echo wp_kses_post($before_widget); ?>
				  <?php
					if ( $title ) {
						echo wp_kses_post($before_title . $title . $after_title);}
					?>
			  <?php
				$dates = future_toastmaster_meetings( $limit );
				echo "\n<ul>\n";
				if ( $dates ) {
					foreach ( $dates as $row ) {
						if(isset($_GET['debug']))
							printf('<li>%s %s</li>',$row->post_title, $row->date);
						if ( isset( $ev[ $row->ID ] ) ) {
							$ev[ $row->ID ] .= ', ' . rsvpmaker_date( $dateformat, (int) $row->ts_start );
						} else {
							$t         = (int) $row->ts_start;
							if(!$row->post_title) {
								$row->post_title = get_the_title($row->ID);
								$wpdb->update($wpdb->prefix.'event',array('post_title'=>$row->post_title),array('event'=>$row->ID));
							}
							$title     = $row->post_title . ' ' . rsvpmaker_date( $dateformat, $t );
							$permalink = get_permalink( $row->ID );
							if ( is_user_logged_in() ) {
								$ev[ $row->ID ] = sprintf( '<a class="meeting" href="%s">%s</a>', $permalink, $title );
							} else {
								$ev[ $row->ID ]  = sprintf( '<a class="meeting" href="%s">%s</a>', $permalink, $title );
								$ev[ $row->ID ] .= sprintf( '<div class="login_signup">&nbsp;&#8594; <a href="%s">%s</a>', login_redirect( $permalink ), __( 'Login/Sign Up', 'rsvpmaker-for-toastmasters' ) );
							}
							$ev[ $row->ID ] = '<div class="meetinglinks">' . $ev[ $row->ID ] . '</div>';
						}
					}
				}// end if dates
				// pluggable function widgetlink can be overridden from custom.php
				if ( isset( $ev ) && ! empty( $ev ) ) {

					// echo '<li class="widgetrsvpview"><a href="'.get_post_type_archive_link( 'rsvpmaker' ).'">'.__('View Upcoming Events','rsvpmaker-for-toastmasters').'</a></li>';

					echo '<li class="widgetsignup">' . __( 'Member sign up for roles', 'rsvpmaker-for-toastmasters' ) . ':';
					$class = '';
					$count = 1;
					foreach ( $ev as $id => $e ) {
						printf( '<div %s>%s</div>', $class, $e );
						if ( $count == $showmore ) {
							  $class = ' class="moremeetings" ';
						}
						$count++;
					}
					if ( sizeof( $ev ) > $showmore ) {
						echo '<div id="showmorediv"><a href="#" id="showmore">' . __( 'Show More', 'rsvpmaker-for-toastmasters' ) . '</a></div>';
					}
					echo '</li>';
				}

				echo '<li>' . __( 'Your membership', 'rsvpmaker-for-toastmasters' ) . ':';
				if ( is_club_member() ) {
					printf( '<div><a href="%s">' . __( 'Edit Member Profile', 'rsvpmaker-for-toastmasters' ) . '</a></div>', login_redirect( admin_url( 'profile.php#user_login' ) ) );

					printf( '<div><a href="%s">' . __( 'Member Dashboard', 'rsvpmaker-for-toastmasters' ) . '</a></div>', login_redirect( admin_url( 'index.php' ) ) );
					if ( class_exists( 'WP_User_Avatar_Setup' ) ) {
						printf( '<div><a href="%s">' . __( 'Change Profile Photo', 'rsvpmaker-for-toastmasters' ) . '</a></div>', admin_url( 'profile.php#profilephoto' ) );
					}
					if ( function_exists( 'bp_core_get_userlink' ) ) {
						  global $current_user;
						  printf( '<div><a href="%s#whats-new-form">' . __( 'Post to Social Profile', 'rsvpmaker-for-toastmasters' ) . '</a></div>', bp_core_get_userlink( $current_user->ID, false, true ) );
						  printf( '<div><a href="%sprofile/change-avatar/#avatar-upload-form">' . __( 'Change Profile Photo', 'rsvpmaker-for-toastmasters' ) . '</a></div>', bp_core_get_userlink( $current_user->ID, false, true ) );
					}
				} else {
					printf( '<div><a href="%s">' . __( 'Login', 'rsvpmaker-for-toastmasters' ) . '</a></div>', login_redirect( site_url() ) );
				}
				echo '</li>';

				if ( isset( $log ) && ! empty( $log ) ) {
					$most_recent = get_rsvp_date( $log[0]->post_id );
					if ( strtotime( $most_recent ) > strtotime( '-1 month' ) ) {
						echo '<li><strong>' . __( 'Activity', 'rsvpmaker-for-toastmasters' ) . '</strong><br />';
						foreach ( $log as $row ) {
							echo '<div>' . $row->meta_value . '</div>';
						}
						echo '</li>';
					}
				}
				do_action( 'awesome_widget_bottom' );
				echo "\n</ul>\n";

				echo wp_kses_post($after_widget);
				?>
		<?php
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['dateformat'] = strip_tags( $new_instance['dateformat'] );
		$instance['limit']      = (int) $new_instance['limit'];
		$instance['showmore']   = (int) $new_instance['showmore'];
		$instance['showlog']    = (int) $new_instance['showlog'];
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		$title      = ( isset( $instance['title'] ) ) ? $instance['title'] : 'Member Access';
		$title      = apply_filters( 'tm_widget_title', $title );
		$title      = esc_attr( $title );
		$limit      = ( isset( $instance['limit'] ) ) ? $instance['limit'] : 10;
		$showmore   = ( isset( $instance['showmore'] ) ) ? $instance['showmore'] : 4;
		$showlog    = ( isset( $instance['showlog'] ) ) ? $instance['showlog'] : 1;
		$dateformat = ( isset( $instance['dateformat'] ) ) ? $instance['dateformat'] : '%b %e';
		?>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'rsvpmaker-for-toastmasters' ); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'limit' )); ?>"><?php _e( 'Number to Show:', 'rsvpmaker-for-toastmasters' ); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'limit' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'limit' )); ?>" type="text" value="<?php echo esc_attr($limit); ?>" /></label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'showmore' )); ?>"><?php _e( 'Show More Link After:', 'rsvpmaker-for-toastmasters' ); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'showmore' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'showmore' )); ?>" type="text" value="<?php echo esc_attr($showmore); ?>" /></label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'showmore' )); ?>"><?php _e( 'Show Member Activity Log:', 'rsvpmaker-for-toastmasters' ); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'showlog' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'showlog' )); ?>" type="radio" value="1" 
									  <?php
										if ( $showlog ) {
											echo ' checked="checked" ';}
										?>
			 /> <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'showlog' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'showlog' )); ?>" type="radio" value="0" 
											<?php
											if ( ! $showlog ) {
															echo ' checked="checked" ';}
											?>
 /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id( 'dateformat' )); ?>"><?php _e( 'Date Format:', 'rsvpmaker-for-toastmasters' ); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'dateformat' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'dateformat' )); ?>" type="text" value="<?php echo esc_attr($dateformat); ?>" /></label> (<?php _e( 'PHP <a target="_blank" href="http://us2.php.net/manual/en/function.date.php">date</a> format string', 'rsvpmaker-for-toastmasters' ); ?>)</p>

		<?php
	}

} // class AwesomeWidget

function wpt_member_access($args) {
	global $wpdb;
	ob_start();
	$title      = ( isset( $args['title'] ) ) ? $args['title'] : 'Member Access';
	$limit      = ( isset( $args['limit'] ) ) ? $args['limit'] : 10;
	$showmore   = ( isset( $args['showmore'] ) ) ? $args['showmore'] : 4;
	$showlog    = ( isset( $args['showlog'] ) ) ? $args['showlog'] : 1;
	$dateformat = ( isset( $args['dateformat'] ) ) ? $args['dateformat'] : 'M j';
		if ( $showlog ) {
		$activity_sql = "SELECT meta_value, post_id from $wpdb->postmeta JOIN $wpdb->posts ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE meta_key='_activity' ORDER BY meta_id DESC LIMIT 0,5";
		$log          = $wpdb->get_results( $activity_sql );
	} else {
		$log = false;
	}

	global $rsvp_options;
	?>
			  <?php
				if ( $title ) {
					echo '<h5 class="member-access-title">'.$title .'</h5>';}
				?>
		  <?php
			$dates = future_toastmaster_meetings( $limit );
			echo "\n<ul class=\"member-access-prompts\">\n";
			if ( $dates ) {
				foreach ( $dates as $row ) {
					if(isset($_GET['debug']))
						printf('<li>%s %s</li>',$row->post_title, $row->date);
					if ( isset( $ev[ $row->ID ] ) ) {
						$ev[ $row->ID ] .= ', ' . rsvpmaker_date( $dateformat, (int) $row->ts_start );
					} else {
						$t         = (int) $row->ts_start;
						$title     = $row->post_title . ' ' . rsvpmaker_date( $dateformat, $t );
						$permalink = get_permalink( $row->ID );
						if ( is_user_logged_in() ) {
							$ev[ $row->ID ] = sprintf( '<a class="meeting" href="%s">%s</a>', $permalink, $title );
						} else {
							$ev[ $row->ID ]  = sprintf( '<a class="meeting" href="%s">%s</a>', $permalink, $title );
							$ev[ $row->ID ] .= sprintf( '<div class="login_signup">&nbsp;&#8594; <a href="%s">%s</a>', login_redirect( $permalink ), __( 'Login/Sign Up', 'rsvpmaker-for-toastmasters' ) );
						}
						$ev[ $row->ID ] = '<div class="meetinglinks">' . $ev[ $row->ID ] . '</div>';
					}
				}
			}// end if dates
			// pluggable function widgetlink can be overridden from custom.php
			if ( isset( $ev ) && ! empty( $ev ) ) {

				// echo '<li class="widgetrsvpview"><a href="'.get_post_type_archive_link( 'rsvpmaker' ).'">'.__('View Upcoming Events','rsvpmaker-for-toastmasters').'</a></li>';

				echo '<li class="widgetsignup">' . __( 'Member sign up for roles', 'rsvpmaker-for-toastmasters' ) . ':';
				$class = '';
				$count = 1;
				foreach ( $ev as $id => $e ) {
					printf( '<div %s>%s</div>', $class, $e );
					if ( $count == $showmore ) {
						  $class = ' class="moremeetings" ';
					}
					$count++;
				}
				if ( sizeof( $ev ) > $showmore ) {
					echo '<div id="showmorediv"><a href="#" id="showmore">' . __( 'Show More', 'rsvpmaker-for-toastmasters' ) . '</a></div>';
				}
				echo '</li>';
			}

			echo '<li>' . __( 'Your membership', 'rsvpmaker-for-toastmasters' ) . ':';
			if ( is_club_member() ) {
				printf( '<div><a href="%s">' . __( 'Edit Member Profile', 'rsvpmaker-for-toastmasters' ) . '</a></div>', login_redirect( admin_url( 'profile.php#user_login' ) ) );

				printf( '<div><a href="%s">' . __( 'Member Dashboard', 'rsvpmaker-for-toastmasters' ) . '</a></div>', login_redirect( admin_url( 'index.php' ) ) );
				if ( function_exists( 'get_simple_local_avatar' ) ) {
					printf( '<div><a href="%s">' . __( 'Change Profile Photo', 'rsvpmaker-for-toastmasters' ) . '</a></div>', admin_url( 'profile.php#simple-local-avatar-section' ) );
				}
				if ( function_exists( 'bp_core_get_userlink' ) ) {
					  global $current_user;
					  printf( '<div><a href="%s#whats-new-form">' . __( 'Post to Social Profile', 'rsvpmaker-for-toastmasters' ) . '</a></div>', bp_core_get_userlink( $current_user->ID, false, true ) );
					  printf( '<div><a href="%sprofile/change-avatar/#avatar-upload-form">' . __( 'Change Profile Photo', 'rsvpmaker-for-toastmasters' ) . '</a></div>', bp_core_get_userlink( $current_user->ID, false, true ) );
				}
			} else {
				printf( '<div><a href="%s">' . __( 'Login', 'rsvpmaker-for-toastmasters' ) . '</a></div>', login_redirect( site_url() ) );
			}
			echo '</li>';

			if ( isset( $log ) && ! empty( $log ) ) {
				$most_recent = get_rsvp_date( $log[0]->post_id );
				if ( strtotime( $most_recent ) > strtotime( '-1 month' ) ) {
					echo '<li><strong>' . __( 'Activity', 'rsvpmaker-for-toastmasters' ) . '</strong><br />';
					foreach ( $log as $row ) {
						echo '<div>' . $row->meta_value . '</div>';
					}
					echo '</li>';
				}
			}
			echo "\n</ul>\n";
return ob_get_clean();
}


function awesome_roles() {
	global $wp_roles;
	$wp_roles->add_cap( 'contributor', 'upload_files' );
}


function recommend_hash( $role, $user, $post_id = 0 ) {
	global $post;
	if ( empty( $post_id ) && ! empty( $post->ID ) ) {
		$post_id = $post->ID;
	}
	return md5( $role . $user . $post_id );
}

function accept_recommended_role() {
	// key=General_Evaluator-1&you=31&code=eZHuvRnuvb^(
	global $post;
	if ( ! isset( $post ) || ( $post->post_type != 'rsvpmaker' ) ) {
		return;
	}
	$permalink     = rsvpmaker_permalink_query( $post->ID );
	$custom_fields = get_post_custom( $post->ID );
	if ( isset( $_REQUEST['key'] ) && isset( $_REQUEST['you'] ) && isset( $_REQUEST['code'] ) ) {
		$you   = (int) $_REQUEST['you'];
		$key = sanitize_text_field($_REQUEST['key']);
		$hash  = recommend_hash( $key, $you );
		$count = (int) $_REQUEST['count'];
		$key   = preg_replace( '/[0-9]/', '', $key );
		if ( $hash != sanitize_text_field($_REQUEST['code']) ) {
			header( 'Location: ' . $permalink . 'recommendation=code_error' );
			exit();
		}
		$success = false;
		for ( $i = 1; $i <= $count; $i++ ) {
				$name = $key . $i;
			if ( ! empty( $custom_fields[ $name ][0] ) ) {

				// echo "<p>Role is taken</p>";
			} else {
				update_post_meta( $post->ID, $name, $you );
				$actiontext = __( 'accepted the role', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $name );
				$success = true;
				break;
			}
		}
		if ( $success ) {
			header( 'Location: ' . $permalink . 'recommendation=success' );
		} else {
			header( 'Location: ' . $permalink . 'recommendation=oops' );
		}
		exit();
	}
}

function signup_sheet_editor() {
	if ( ! current_user_can( 'edit_signups' ) ) {
		die( 'security error' );
	}
	global $rsvp_options;
	global $post;
	global $current_user;
	$limit  = get_option( 'tm_signup_count' );
	$maxrow = 0;
	if ( isset( $_GET['limit'] ) ) {
			$limit = (int) $_GET['limit'];
		if ( current_user_can( 'manage_options' ) ) {
			update_option( 'tm_signup_count', $limit );
		}
	}
	if ( empty( $limit ) ) {
		$limit = 3;
	}
	if(isset($_GET['focus']))
	{
		$date = get_rsvpmaker_event(intval($_GET['focus']));
		$post = get_post(intval($_GET['focus']));
		$post->ts_start = $date->ts_start;
		$dates[] = $post;
	}
	else {
		$dates     = future_toastmaster_meetings( $limit, 0 );
	}
	$head      = $cells = '';
	$datecount = 0;
	foreach ( $dates as $index => $date ) {
		$guestopt          = '';
		$post              = get_post( $date->ID );
		$t                 = (int) $date->ts_start;
		$head             .= '<th>' . $post->post_title . '<br /><a href="'.site_url('?signup_sheet_editor=1&focus='.$post->ID).'">' . rsvpmaker_date( 'F j', $t ) . '</a></th>';
		$cell[ $date->ID ] = '';
		$data              = wpt_blocks_to_data( $date->post_content );
		foreach ( $data as $row => $item ) {
			if ( empty( $item['role'] ) ) {
				continue;
			}
			$role       = sanitize_text_field($item['role']);
			$count      = (int) $item['count'];
			for ( $i = 1; $i <= $count; $i++ ) {
				$field = wp4t_fieldbase($role,$i);
				$assigned = get_post_meta( $post->ID, $field, true );
				if ( empty( $assigned ) ) {
					$guestopt .= sprintf( '<option value="%s">%s</option>', $field, $field );
				}
				if ( ! empty( $assigned ) && ! is_numeric( $assigned ) ) {
					$show = $assigned . ' (guest)';
				} else {
					$show = awe_user_dropdown( $field, $assigned );
				}
				$cell[ $date->ID ] .= '<div><div class="role">' . $role . ':</div><div>' . $show . '</div><div id="status' . $field . $post->ID . '" class="status"></div></div>';
			}
			if(isset($_GET['focus']) && ($count % 3 == 0))
				$cell[ $date->ID ] .= '</td><td>';
		}
		if ( ! empty( $guestopt ) ) {
			$addguest           = sprintf( '<div>Assign role to guest<br /><select id="addguest_role%d">%s</select><br />Name:<br /><input type="text" id="addguest_name%d" /><br /><button class="assign_to_guest" post_id="%d">Assign</button></div><div id="addguest%d"></div>', $post->ID, $guestopt, $post->ID, $post->ID, $post->ID );
			$cell[ $date->ID ] .= $addguest;
		}
		if ( strpos( $date->post_content, 'wp4toastmasters/absences' ) ) {
			$cell[ $date->ID ] .= tm_absence( array() );
		}
		$cell[ $date->ID ] .= sprintf( '<p><a href="%s">Edit</a></p>', add_query_arg('edit_roles_new','1',get_permalink( $post->ID )) );
		$cell[ $date->ID ] .= sprintf( '<div id="norole%d"></div>', $date->ID );
		$norole_call[]      = sprintf( 'norole(%d);', $date->ID );
		$datecount++;
		if ( $datecount == $limit ) {
			break;
		}
	}
		if(isset($_GET['focus']))
		$cells = '<tr><td>' . implode( ' ', $cell ) . '</td></tr>';
		else
		$cells = '<tr><td>' . implode( '</td><td>', $cell ) . '</td></tr>';

	$colwidth = floor( 100 / $limit );

	echo '<html><head>
	<title>Signup Sheet Editor</title>
	<style>
	table#signup {
	width: 100%;
	}
	#signup th {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	}
	#signup td, #signup th {
	padding: 3px;
	margin: 2px;
	width: ' . $colwidth . '%;
	vertical-align: top;
	}
	#signup .signuprole {
	font-size: 10px;
	border: thin solid #000;
	margin-bottom: 2px;
	font-weight: bold;
	}
	#signup .assignedto {
	font-size: 14px;
	border-bottom: thin solid #000;
	padding-bottom: 10px;
	font-weight: normal;
	}
	select, option {
	max-width: 150px;
	overflow: hidden;
	}
	.role {
	font-size: small;
	}
	.status {
	color: blue;
	}
	.editor_assign {
		width: 30em;
	}
	</style>
	</head><body><table id="signup"><tr>' . $head . '</tr>' . $cells . "</table>
	
	<script type='text/javascript' src='" . admin_url( 'load-scripts.php?c=1&amp;load%5B%5D=jquery-core,jquery-migrate,utils&amp;ver=4.9.8' ) . "'></script>
	<link rel='stylesheet' id='style-toastmasters-select2-css' href='" . plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/css/select2.min.css?ver=3.74' ) . "' type='text/css' media='all' />
	<script type='text/javascript' src='" . plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/js/select2.min.js?ver=3.74' ) . "' id='script-toastmasters-select2-js'></script>

	<script>
jQuery(document).ready(function($) {

$.ajaxSetup({
	headers: {
		'X-WP-Nonce': '" . wp_create_nonce( 'wp_rest' ) . "',
	}
});

var ajaxurl = '".get_rest_url()."rsvptm/v1/tm_role?tm_ajax=role';
var timelord = '".rsvpmaker_nonce('value')."';

$('.editor_assign').select2();

$('.editor_assign').on('change', function(){
	var user_id = this.value;
	var id = this.id;
	var role = $('#'+id).attr('role');
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'status'+role.replace(' ','')+post_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	if(post_id > 0)
	{
		var data = {
			'action': 'editor_assign',
			'role': role,
			'user_id': user_id,
			'editor_id': editor_id,
			'timelord': timelord,
			'post_id': post_id
		};
		console.log(data);
		jQuery.post(ajaxurl, data, function(response) {
		$('#'+statusid).html(response.content);
		$('#'+statusid).fadeIn(200);
		norole(post_id);
		});
	}
});	

$('.absences').on('change', function(){
	var user_id = this.value;
	if(user_id < 1)
		return;
	var id = this.id;
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'status_absences'+post_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	if(post_id > 0)
	{
		var data = {
			'action': 'editor_absences',
			'away_user_id': user_id,
			'editor_id': editor_id,
			'timelord': timelord,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		console.log(response);
		$('#'+statusid).html(response.content);
		$('#'+statusid).fadeIn(200);
		norole(post_id);
		});
	}
});	

$('.assign_to_guest').on('click', function(){
	var post_id = $(this).attr('post_id');
	var role = $('#addguest_role'+post_id).val();
	var guest = $('#addguest_name'+post_id).val();
	var statusid = 'addguest'+post_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	if(post_id > 0)
	{
		var data = {
			'action': 'editor_assign',
			'role': role,
			'user_id': 0,
			'guest': guest,
			'editor_id': editor_id,
			'timelord': timelord,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		$('#'+statusid).html(response.content);
		$('#'+statusid).fadeIn(200);
		});
	}
});

$('.absences_remove').on('click', function(){
	var user_id = this.value;
	if(user_id < 1)
		return;
	var id = this.id;
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'current_absences'+post_id+user_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	if(post_id > 0)
	{
		var data = {
			'action': 'absences_remove',
			'user_id': user_id,
			'editor_id': editor_id,
			'timelord': timelord,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		console.log(response);
		$('#'+statusid).html(response);
		$('#'+statusid).fadeIn(200);
		norole(post_id);
		});
	}
});	

function norole(post_id) {
	$('#norole'+post_id).html('updating list of members with no role');
	$.getJSON('/wp-json/rsvptm/v1/norole/'+post_id,function(data) {
		$('#norole'+post_id).html('<strong>Members with No Role</strong><br />'+data.join('<br />'));
    });
}
" . implode( "\n", $norole_call ) . "
});
</script>

" . rsvpmaker_nonce('return') . "
<input id='editor_id' type='hidden' value='" . $current_user->ID . "' />

<form action=\"" . site_url() . '" method="get" style="margin-top: 20px; margin-left: 10px; padding: 10px; border: thin solid #000; width: 300px;" >
<input type="hidden" name="signup_sheet_editor"  value="1">
Number of Meetings Shown: 
<select name="limit">
<option value="' . $limit . '">' . $limit . '</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
</select>
<button>Get</button>
</form>

	</body></html>';
		exit();
}

function signup_sheet( $atts = array() ) {

	if ( isset( $_GET['signup_sheet_editor'] ) ) {
		signup_sheet_editor();
		return;
	}

	if ( isset( $_REQUEST['signup'] ) || isset( $_REQUEST['signup2'] ) || isset( $atts['limit'] ) ) {
		global $wpdb;
		global $rsvp_options;
		global $post;
		if ( function_exists( 'register_block_type' ) ) {
			register_block_type( 'wp4toastmasters/role', array( 'render_callback' => 'toastmaster_short' ) );
		}

		$limit = get_option( 'tm_signup_count' );
		if ( empty( $limit ) ) {
			$limit = 3;
		}
		$sql  = 'SELECT date as datetime
	 FROM ' . $wpdb->posts . '
	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event
	 WHERE a1.date > CURDATE() AND (post_status='publish' OR post_status='draft') AND (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ORDER BY a1.date";
		$next = "'" . $wpdb->get_var( $sql ) . "'";
		if ( isset( $atts['limit'] ) ) {// shortcode version
			$limit              = $atts['limit'];
			$_REQUEST['signup'] = $_REQUEST['signup2'] = 1;
			$next               = 'CURDATE()';
			ob_start();
		}
		$dates     = get_future_events( " date > $next AND (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ", $limit );
		$head      = $cells = '';
		$datecount = 0;
		foreach ( $dates as $date ) {
			$t     = intval( $date->ts_start );
			$post  = get_post( $date->postID );
			$head .= '<th>' . $post->post_title . '<br />' . rsvpmaker_date( 'F j', $t ) . '</th>';

			$absent_names = array();
			$absences     = get_absences_array( $date->postID );
			if ( ! empty( $absences ) ) {
				foreach ( $absences as $a ) {
					$user           = get_userdata( $a );
					$absent_names[] = ( ! empty( $user->first_name ) ) ? $user->first_name . ' ' . $user->last_name : $user->user_login;
				}
			}

			$ab = ( empty( $absent_names ) ) ? '' : '<p><strong>Planned Absences:</strong> ' . implode( ', ', $absent_names ) . '</p>';

			if ( strpos( $post->post_content, '{"role":"' ) ) {
				preg_match_all( '/\<.+wp4toastmasters\/role.+\>/', $post->post_content, $matches );
				$filtered = implode( "\n\n", $matches[0] ); // filter out all content other than role signups
				$cells   .= '<td>' . do_blocks( $filtered ) . $ab . '</td>';
			} else {
				preg_match_all( '/\[toastmaster.+\]/', $post->post_content, $matches );
				$filtered = implode( "\n", $matches[0] ); // filter out all content other than role signups
				$cells   .= '<td>' . do_shortcode( $filtered ) . $ab . '</td>';
			}
			$datecount++;
			if ( $datecount == $limit ) {
				break;
			}
		}

		$colwidth = floor( 100 / $limit );

		echo '<html><head>
	<title>Signup Sheet</title>
	<style>
	table#signup {
	width: 100%;
	}
	#signup th {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	}
	#signup td, #signup th {
	padding: 3px;
	margin: 2px;
	width: ' . $colwidth . '%;
	vertical-align: top;
	}
	#signup .signuprole {
	font-size: 10px;
	border: thin solid #000;
	margin-bottom: 2px;
	font-weight: bold;
	}
	#signup .assignedto {
	font-size: 14px;
	border-bottom: thin solid #000;
	padding-bottom: 10px;
	font-weight: normal;
	}
	</style>
	</head><body><table id="signup"><tr>' . $head . '</tr><tr>' . $cells . '</tr></table></body></html>';
		if ( isset( $atts['limit'] ) ) {// shortcode version
			unset( $_REQUEST['signup'] );
			unset( $_REQUEST['signup2'] );
			return ob_get_clean();
		} else {
			exit();
		}
	}

}

function upcoming_open_roles( $limit = 10 ) {

	global $wpdb;
	global $rsvp_options;
	global $post;

	$openings  = array();
	$dates     = future_toastmaster_meetings( $limit );
	$head      = $cells = '';
	$datecount = 0;
	foreach ( $dates as $date ) {
		$t = (int) $date->ts_start;
		// $datestr = date("F j",$t);
		preg_match_all( '/\[.+role="([^"]+).+\]/', $date->post_content, $matches );
		// echo '<h3>'.$datestr.'</h3>';
		foreach ( $matches[1] as $index => $role ) {
			$field_base = '_role_' . preg_replace( '/[^a-zA-Z0-9]/', '_', $role );
			if ( strpos( $field_base, 'Backup' ) ) {
				continue;
			}
			preg_match( '/count="([\d]+)/', $matches[0][ $index ], $counts );
			$count = ( empty( $counts[1] ) ) ? 1 : $counts[1];
			// echo '<div>Role '.$role.': '.$count.'<div>';
			for ( $i = 1; $i <= $count; $i++ ) {
				$field    = $field_base . '_' . $i;
				$assigned = get_post_meta( $date->ID, $field, true );
				if ( ! $assigned ) {
					$openings[ $t ][] = $field;
					break;
				}
			}
		}
	}
	return $openings;
}

function openings_for_date( $datepost, $user_id = 0 ) {
	global $current_user;
	if ( ! $user_id ) {
		$user_id = $current_user->ID;
	}
	$data = wpt_blocks_to_data( $datepost->post_content );
	// printf('<pre>%s</pre>',var_export($data,true));
	$openings = $bases = array();
	foreach ( $data as $row ) {
		if ( empty( $row['role'] ) ) {
			continue;
		}
		$role       = $row['role'];
		if ( strpos( $field_base, 'Backup' ) ) {
			continue;
		}
		$count = (int) $row['count'];
		if ( empty( $count ) ) {
			$count = 1;
		}
		for ( $i = 1; $i <= $count; $i++ ) {
			$field    = wp4t_fieldbase($role,$i);
			$assigned = (int) get_post_meta( $datepost->ID, $field, true );
			$open     = ( ( $assigned == '' ) || ( $assigned == 0 ) );
			// printf('<p>%d %s %d</p>',$datepost->ID,$field,$assigned);
			if ( $assigned == $user_id ) {
				$openings['assigned'] = $field;
			}
			if ( $open && ! in_array( $field_base, $bases ) ) {
				$openings[] = $field;
				$bases[]    = $field_base;
			}
		}
	}
	return $openings;
}

function wp_ajax_wptoast_role_planner_update() {
	$post_id = (int) $_POST['datepost'];
	$user_id = sanitize_text_field($_POST['user_id']);
	if ( ! empty( $_POST['takerole'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$role = sanitize_text_field($_POST['takerole']);
		update_post_meta( $post_id, $role, $user_id );
		printf( '<p>Added %s</p>', clean_role( $role ) );
		if ( strpos( $role, 'Speaker' ) ) {
			printf( '<p><a href="%s#%s">* Edit speech details</a></p>', get_permalink( $post_id ), $role );
		}
		$actiontext = __( 'signed up for', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $role );
		do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $user_id );
		do_action('toastmasters_agenda_change',$post_id,$role,$user_id,0,0);
		if ( ! empty( $_POST['project'] ) && strpos( $role, 'Speaker' ) ) {
			update_post_meta( $post_id, '_manual' . $role, sanitize_text_field($_POST['manual']) );
			update_post_meta( $post_id, '_project' . $role, santize_text_field($_POST['project']) );
			update_post_meta( $post_id, '_display_time' . $role, sanitize_text_field($_POST['display_time']) );
			update_post_meta( $post_id, '_maxtime' . $role, sanitize_text_field($_POST['maxtime']) );
			if ( ! empty( $_POST['title'] ) ) {
				update_post_meta( $post_id, '_title' . $role, sanitize_text_field($_POST['title']) );
			}
			if ( ! empty( $_POST['intro'] ) ) {
				update_post_meta( $post_id, '_intro' . $role, wp_kses_post($_POST['intro']) );
			}
		}
	}
	if ( ! empty( $_POST['was'] ) && ( $_POST['was'] != $_POST['takerole'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$was = sanitize_text_field($_POST['was']);
		do_action('toastmasters_agenda_change',$post_id,$was,0,get_post_meta($post_id,$was,true),0);
		update_post_meta( $post_id, $was, 0 );
		if ( strpos( $was, 'Speaker' ) ) {
				delete_post_meta( $post_id, '_manual' . $was );
				delete_post_meta( $post_id, '_project' . $was );
				delete_post_meta( $post_id, '_title' . $was );
				delete_post_meta( $post_id, '_intro' . $was );
		}
		printf( '<p>Dropped %s</p>', clean_role( $was ) );
		$actiontext = __( 'withdrawn:', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $was );
		do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $user_id );
	}
	die();
}

add_action( 'wp_ajax_wptoast_role_planner_update', 'wp_ajax_wptoast_role_planner_update' );

function toastmasters_planner() {
	$hook = tm_admin_page_top( __( 'Multi-Meeting Role Planner', 'rsvpmaker-for-toastmasters' ) );
	?>
<p>This tool allows you to see your currently assigned roles and open roles at upcoming meetings. If you do not have a role, the software will attempt to recommend one you have not filled recently. Open roles are shuffled into a random order.</p>
<p>You can change your role assignments one meeting at a time or scroll to the bottom and click <strong>Save All Updates</strong>.</p>
	<?php
	printf( '<form method="post" action="%s">', admin_url( 'admin.php?page=toastmasters_planner' ) );
	if ( isset( $_REQUEST['user_id'] ) ) {
		$user_id = (int) $_REQUEST['user_id'];
	} else {
		global $current_user;
		$user_id = $current_user->ID;
	}
	if ( isset( $_POST['takerole'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$userdata = get_userdata( $user_id );
		foreach ( $_POST['takerole'] as $post_id => $role ) {
			$t = get_rsvpmaker_timestamp( $post_id );
			$d = rsvpmaker_date( 'F j', $t );
			if ( ! empty( $_POST['wasrole'][ $post_id ] ) ) {
				if ( $_POST['wasrole'][ $post_id ] == $role ) {
					continue; // no change
				}
				$was = sanitize_text_field($_POST['wasrole'][ $post_id ]);
				update_post_meta( $post_id, $was, 0 );
				printf( '<p>Dropped %s for %s</p>', clean_role( $_POST['wasrole'][ $post_id ] ), $d );
				add_post_meta( $post_id, '_activity_editor', $userdata->display_name . ' dropped ' . clean_role( $_POST['wasrole'][ $post_id ] ) . ' for ' . $d );
				$actiontext = __( 'withdrawn', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $_POST['wasrole'][ $post_id ] );
				do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $user_id );
				do_action('toastmasters_agenda_change',$post_id,$was,0,get_post_meta($post_id,$was,true),0);
			}
			if ( ! empty( $role ) ) {
				do_action('toastmasters_agenda_change',$post_id,$role,$user_id,get_post_meta($post_id,$role,true),0);
				update_post_meta( $post_id, $role, $user_id );
				printf( '<p>Added %s for %s</p>', clean_role( $role ), $d );
				add_post_meta( $post_id, '_activity_editor', $userdata->display_name . ' added ' . clean_role( $_POST['wasrole'][ $post_id ] ) . ' for ' . $d );
				if ( strpos( $role, 'Speaker' ) ) {
					printf( '<p><a href="%s">* Edit speech details</a></p>', get_permalink( $post_id ) );
				}
				$actiontext = __( 'signed up for', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $role );
				do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $user_id );
			}
		}

		$actiontext = '<strong>' . $userdata->display_name . ':</strong> ' . __( 'signed up for roles on', 'rsvpmaker-for-toastmasters' ) . ' ' . implode( ', ', $mdate );
		add_post_meta( $post_id, '_activity', $actiontext );
	}
	$suggested = array();
	$dates     = future_toastmaster_meetings();
	foreach ( $dates as $date ) {
		$permalink = get_permalink( $date->ID );
		$prompt    = '';
		$t         = (int) $date->ts_start;
		printf( '<h3><a href="%s">Agenda</a> - %s %s</h3>', $permalink, rsvpmaker_date( 'F j', $t ), $date->post_title );
		$absences = get_post_meta($date->ID,'tm_absence');
		if(!empty($absences) && in_array($user_id,$absences)) {
			printf('<p>%s</p>',__('Planned Absence','rsvpmaker-for-toastmasters'));
			continue;
		}
		$meeting_openings = openings_for_date( $date, $user_id );
		$recent_history   = wp4t_recent_history($user_id);
		if ( ! empty( $suggested ) ) {
			$recent_history = array_merge( $recent_history, $suggested );
		}
		$suggest    = $olow = '';
		$dontrepeat = array();
		$o          = '<option value="">None</option>';
		$picked     = false;

		if ( ! empty( $meeting_openings ) ) {
			if ( ! empty( $meeting_openings['assigned'] ) ) {
				$o     .= sprintf( '<option value="%s" selected="selected">%s (currently assigned)</option>', $meeting_openings['assigned'], clean_role( $meeting_openings['assigned'] ) );
				$picked = true;
				printf( '<input type="hidden" id="was%d" name="wasrole[%d]" value="%s" />', $date->ID, $date->ID, $meeting_openings['assigned'] );
				if ( strpos( $meeting_openings['assigned'], 'Speaker' ) && ! get_post_meta( $date->ID, '_project' . $meeting_openings['assigned'], true ) ) {
					$prompt = '<p><a href="' . $permalink . '#' . $meeting_openings['assigned'] . '">* Add speech project details</a></p>';
				}
			} else {
				$prompt = '<span style="color: red;">Suggested role (not confirmed)</span>';
			}
			shuffle( $meeting_openings );
			foreach ( $meeting_openings as $role ) {
				// echo '<div>'.$role.'</div>';
				$clean_role = clean_role( $role );
				if ( $picked || in_array( $clean_role, $recent_history ) ) {
					if ( in_array( $clean_role, $dontrepeat ) ) {
						continue;
					}
					$o .= sprintf( '<option value="%s">%s</option>', $role, $clean_role );
				} elseif ( empty( $suggest ) ) {
					$suggest    .= sprintf( '<option value="%s" selected="selected">%s (suggested)</option>', $role, $clean_role );
					$suggested[] = $clean_role;
					// printf('<p>Suggested %s</p>',$clean_role);
					$picked = true;
				} else {
					$o .= sprintf( '<option value="%s">%s</option>', $role, $clean_role );
				}
				$dontrepeat[] = $clean_role;
			}
			if ( empty( $suggest ) && ! empty( $meeting_openings ) ) {
				$role        = array_shift( $meeting_openings );
				$clean_role  = clean_role( $role );
				$suggest    .= sprintf( '<option value="%s" selected="selected">%s (suggested)</option>', $role, $clean_role );
				$suggested[] = $clean_role;
				// printf('<p>Suggested %s</p>',$clean_role);
				$picked = true;
			}
			if ( ! empty( $suggest ) || ! empty( $olow ) || $picked ) {
				printf( '<p>%s <select class="takerole" id="takerole%d" name="takerole[%d]" post_id="%d">%s</select></p>', __( 'Choices', 'rsvpmaker-for_toastmasters' ), $date->ID, $date->ID, $date->ID, $suggest . $o . $olow );
				printf( '<div class="takerole_speaker" id="takerolespeaker%d">%s</div>', $date->ID, speaker_details( '_role_Speaker_' . $date->ID ) );
				printf( '<p><button class="roleplanupdate button button-primary" datepost="%d">%s</button></p>', $date->ID, __( 'Update', 'rsvpmaker-for_toastmasters' ) );
				// submit_button('Update');
			}
			echo '<div id="change' . $date->ID . '">' . $prompt . '</div>';
		}
	}
	rsvpmaker_nonce();
	submit_button( 'Save All Updates' );
	printf( '<input type="hidden" id="user_id" name="user_id" value="%d" /></form>', $user_id );
	tm_admin_page_bottom( $hook );
}

function print_contacts( $cron = false ) {

	if ( $cron ) {

		// not init
	} else {
		if ( ! isset( $_REQUEST['print_contacts'] ) ) {
			return;
		}
		if ( ! is_club_member() || ! current_user_can( 'view_contact_info' ) ) {
			die( 'You must log in first' );
		}
		echo '<html><body>';
	}

	member_list();

	if ( isset( $_REQUEST['print_contacts'] ) ) {
		echo '</body></html>';
	}
	exit();
}


function detect_default_password() {

	require_once ABSPATH . WPINC . '/class-phpass.php';
	// require_once( ABSPATH . WPINC . '/registration.php');

	$blogusers = get_users( 'blog_id=1&orderby=nicename' );
	foreach ( $blogusers as $user ) {
		$wp_hasher = new PasswordHash( 8, true );

		$password_hashed = $user->user_pass;
		$plain_password  = 'someawe';
		if ( $wp_hasher->CheckPassword( $plain_password, $password_hashed ) ) {
			wp_update_user(
				array(
					'ID'        => $user->ID,
					'user_pass' => wp_generate_password(),
				)
			);
			echo esc_html($user->user_login) . ' ' . __( 'YES, Matched changing now', 'rsvpmaker-for-toastmasters' ) . '<br />';
		} else {
			echo esc_html($user->user_login) . ' ' . __( 'Password already reset', 'rsvpmaker-for-toastmasters' ) . '<br />';
		}
	}
	?>
<form action="<?php echo sanitize_text_field($_SERVER['REQUEST_URI']); ?>" method="post">
<input type="submit" name="changepass" value="Change All Passwords" />
<?php rsvpmaker_nonce(); ?>
</form>
	<?php
}

function awesome_user_profile_fields( $user ) {
	tm_grant_privacy_permission_ui (false, true, $user);
	if(wp4t_is_district())
		return;
	?>
<table class="form-table">
<tr>
<th><label for="public_profile"><?php _e( 'Public Profile', 'rsvpmaker-for-toastmasters' ); ?></label></th>
<td>
<p><input type="checkbox" name="public_profile" id="public_profile" value="yes" 
	<?php
	if ( get_the_author_meta( 'public_profile', $user->ID ) ) {
		echo ' checked="checked" ';}
	?>
 />
<span class="description"><?php _e( 'Check to allow name, social media links, photo, and the description you provided to be displayed publicly.<br /> Otherwise, your contact info will only be shown to other members who have logged in with a password. (Officer profiles are public by default)', 'rsvpmaker-for-toastmasters' ); ?></span></p>
<blockquote>
<input type="checkbox" name="public_email" id="public_email" value="yes" 
	<?php
	if ( get_the_author_meta( 'public_email', $user->ID ) ) {
		echo ' checked="checked" ';}
	?>
 /> <?php _e( 'Also show email publicly', 'rsvpmaker-for-toastmasters' ); ?>
</blockquote>
	<?php
	if ( current_user_can( 'manage_network' ) ) {
		?>
<p><input type="checkbox" name="hidden_profile" id="hidden_profile" value="yes" 
		<?php
		if ( get_the_author_meta( 'hidden_profile', $user->ID ) ) {
			echo ' checked="checked" ';}
		?>
 />
<span class="description"><?php _e( 'Check to HIDE profile from member listings. Use to hide accounts used for administration that do not represent member accounts.', 'rsvpmaker-for-toastmasters' ); ?></span></p>
		<?php
	}
	?>
</td>
</tr>
<tr>
<th><label for="public_profile"><?php _e( 'Email Notifications', 'rsvpmaker-for-toastmasters' ); ?></label></th>
<td>
	<?php

	if ( isset( $_GET['debug'] ) && current_user_can( 'manage_options' ) ) {
		$data = get_userdata( $user->ID );
		echo '<pre>';
		print_r( $data );
		echo '</pre>';
	}

	$e     = strtolower( $user->user_email );
	$unsub = get_option( 'rsvpmail_unsubscribed' );
	if ( empty( $unsub ) ) {
		$unsub = array();
	}
	if ( isset( $_GET['resubcribe'] ) ) {
		$key = array_search( $e, $unsub );
		if ( $key !== false ) {
			echo __( 'Removing block on', 'rsvpmaker-for-toastmasters' ) . ' ' . $e;
			unset( $unsub[ $key ] );
			update_option( 'rsvpmail_unsubscribed', $unsub );
			$chimp_options = get_option( 'chimp' );
			if ( ! empty( $chimp_options ) && ! empty( $chimp_options['chimp-key'] ) ) {
				echo ' - ' . __( 'Does not change unsubscribed status on MailChimp.', 'rsvpmaker-for-toastmasters' );
			}
		}
	} elseif ( in_array( $e, $unsub ) ) {
		printf( '%s %s (<a href="%s">%s</a>)', __( 'Notifications are BLOCKED for', 'rsvpmaker-for-toastmasters' ), $e, admin_url( 'user-edit.php?user_id=' . $user->ID . '&resubcribe=' . $e ), __( 'remove block' ) );
	} else {
		printf( '%s %s (<a href="%s">%s</a>)', __( 'Notifications are being sent to', 'rsvpmaker-for-toastmasters' ), $e, site_url( '?rsvpmail_unsubscribe=' . $e ), __( 'block / unsubscribe' ) );
	}
	?>
</td>
<tr>
<th><label for="evaluation_preference"><?php _e( 'Evaluation Preference', 'rsvpmaker-for-toastmasters' ); ?></label></th>
<td>
<?php
$second_language = get_user_meta($user->ID,'second_language_feedback',true);
$checkedyes = ($second_language) ? ' checked="checked" ' : '';
$checkedno = (!$second_language) ? ' checked="checked" ' : '';
printf('<p><input type="radio" name="second_language_feedback" value="1" %s> Show <input type="radio" name="second_language_feedback" value="0" %s> DO NOT Show additional evaluation form prompts for those speaking a second language.</p><p>When this is checked, the evaluator will be asked to rate you on </p><ul><li>Pace: not too fast or too slow</li><li>Grammar and word usage</li><li>Word tense, gender, and pronouns</li><li>Clear pronunciation</li></ul>',$checkedyes,$checkedno);
?>	
</td>
</tr>
</tr>
	<?php
	if ( current_user_can( 'manage_options' ) ) {
		printf(
			'<tr>
<th><label for="joined_club">Date Joined Club</label></th>
<td><input type="text" id="joined_club" name="joined_club" value="%s" /> MM/DD/YYYY </td>
</tr>',
			get_user_meta( $user->ID, 'joined' . get_current_blog_id(), true )
		);
		printf(
			'<tr>
<th><label for="joined_club">Original Join Date</label></th>
<td><input type="text" id="original_join_date" name="original_join_date" value="%s" /> MM/DD/YYYY </td>
</tr>',
			get_user_meta( $user->ID, 'original_join_date', true )
		);
	}
	?>
</table>
	<?php
}

function save_awesome_user_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false; }
	update_user_meta( $user_id,'second_language_feedback',intval($_POST['second_language_feedback']));
	update_user_meta( $user_id,'tm_privacy_prompt',intval($_POST['tm_privacy_permission']));
	update_user_meta( $user_id,'tm_directory_blocked',intval($_POST['tm_directory_blocked']));
	update_user_meta( $user_id, 'public_profile', ! empty( $_POST['public_profile'] ) );
	update_user_meta( $user_id, 'public_email', ! empty( $_POST['public_email'] ) );
	update_user_meta( $user_id, 'hidden_profile', ! empty( $_POST['hidden_profile'] ) );
	if ( isset( $_POST['application_id'] ) )
		update_user_meta( $user_id, 'application_id_'.get_current_blog_id(), sanitize_text_field( $_POST['application_id'] ) );
	if ( isset( $_POST['joined_club'] ) ) {
		update_user_meta( $user_id, 'joined' . get_current_blog_id(), sanitize_text_field($_POST['joined_club']) );
		update_user_meta( $user_id, 'original_join_date', sanitize_text_field($_POST['original_join_date']) );
	}
}

function speech_intros_shortcode( $atts ) {
	return '<h1>' . __( 'Speech Introductions', 'rsvpmaker-for-toastmasters' ) . "</h1>\n\n" . speech_intros( true );
}

function speech_intros( $agenda = 0 ) {

	if ( ! isset( $_REQUEST['intros'] ) && ! $agenda ) {
		return;
	}
	ob_start();
	if ( ! $agenda ) {
		?>
<html>
<head>
<style>
h1 {
font-size: 24px;
}
p 
{
	font-size: 18px;
}
</style>
</head>
<body>
	<h1>Speech Introductions</h1>
		<?php
	}
	if ( isset( $_REQUEST['intros'] ) && is_numeric( $_REQUEST['intros'] ) ) {
		$event = (int) $_REQUEST['intros'];
	} else {
			global $post;
			$event = $post->ID;
	}

	global $wpdb;

	$results = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = $event and meta_key LIKE '_role_Speaker_%' ");

	foreach ( $results as $row ) {
			echo '<div style="margin-bottom: 20px; padding: 10px; border: thin dotted #000;">' . wpautop( speech_intro_data( $row->meta_value, $event, $row->meta_key ) ) . '</div>';
	}
	if ( ! $agenda ) {
		?>
</body>
</html>
		<?php
		ob_get_flush();
		exit();
	}
	return ob_get_clean();
}


function profile_prompt() {

		echo nl2br( __( 'Can we get a photo of you for the members listing on our Toastmasters website? With our club growing, we would like to have a member roster with photos to help everyone get to know each other.', 'rsvpmaker-for-toastmasters' ) . "\n" . __( 'You can also log into the website and upload a photo. Take a few minutes to review your profile, making any needed additions or corrections to the contact info we have for you.', 'rsvpmaker-for-toastmasters' ) );

	$contactmethods['home_phone']   = 'Home Phone';
	$contactmethods['work_phone']   = 'Work Phone';
	$contactmethods['mobile_phone'] = 'Mobile Phone';

	$blogusers = get_users( 'blog_id=1&orderby=nicename' );
	foreach ( $blogusers as $user ) {
		$userdata = get_userdata( $user->ID );
		if ( $userdata->hidden_profile ) {
			continue;
		}
		echo esc_html($userdata->first_name . ' ' . $userdata->last_name);
		if ( isset( $userdata->fbuid ) ) {
			$fbset = true;
		} else {
			$fbset = false;
		}

		if ( userphoto_exists( $userdata ) ) {
			$photo = true;
		} else {
			$photo = false;
		}
		$phone = false;
		foreach ( $contactmethods as $name => $value ) {
			if ( isset( $userdata->$name ) ) {
				$phone = true;
			}
		}
		if ( ! $phone ) {
			echo ' <strong>' . __( 'No Phone Number', 'rsvpmaker-for-toastmasters' ) . '</strong>';
		}

		if ( $fbset ) {
			echo ' <strong>' . __( 'Facebook Connection Set', 'rsvpmaker-for-toastmasters' ) . '</strong>';
		} elseif ( $photo ) {
			echo ' <strong>' . __( 'Photo Provided', 'rsvpmaker-for-toastmasters' ) . '</strong>';
		} else {
			echo ' <strong>' . __( 'Please provide a photo.', 'rsvpmaker-for-toastmasters' ) . '</strong>';

			printf( '<br /><a target="_blank" href="mailto:%s?subject=' . __( 'Please add your photo to your member listiong on the Toastmasters website', 'rsvpmaker-for-toastmasters' ) . '">send note</a><br />', $userdata->user_email );

		}
		echo '<br />';
	}
}


function awesome_rating() {
	global $wpdb;
	global $wpdb;
	$sql = 'SELECT * FROM `' . $wpdb->prefix . 'postmeta` JOIN ' . $wpdb->prefix . 'rsvp_dates ON ' . $wpdb->prefix . 'rsvp_dates.postID = ' . $wpdb->prefix . "postmeta.post_id WHERE `meta_key` LIKE '%1' OR  `meta_key` LIKE '%2' OR  `meta_key` LIKE '%3' AND ( (meta_key IS NOT NULL) AND (meta_value IS NOT NULL) AND (datetime > DATE_SUB('" . get_sql_now() . "', INTERVAL 3 MONTH)) AND (datetime < '" . get_sql_now() . "') )";
	$r   = $wpdb->get_results( $sql );
	foreach ( $r as $row ) {
		// print_r($row);
		$id = (int) $row->meta_value;
		if ( $id && ! empty( $row->meta_key ) && ! strpos( $row->meta_key, 'Backup' ) ) {
			$rate[ $id ]++;
			$tags[ $id ] .= $row->meta_key . ', ';
		}
	}
	arsort( $rate );

	foreach ( $rate as $id => $value ) {
		$userdata = get_userdata( $id );
		if ( ! isset( $top ) ) {
			$top = $value;
		}
		$score = round( ( $value / $top ) * 5 );
		if ( $score < 1 ) {
			$score = 1;
		}
		printf( '<p>%s : %s %s</p>', esc_html($score), esc_html($userdata->first_name), esc_html($userdata->last_name) );
		echo esc_html($tags[ $id ]) . '<br />';
	}
}

function get_speaker_array( $assigned, $post_id = 0, $backup = false ) {
	global $speaker_arrays;
	$key = $assigned . ':' . $post_id;
	if ( ! empty( $speaker_arrays[ $key ] ) ) {
		return $speaker_arrays[ $key ];
	}
	if ( empty( $assigned ) ) {
		return array(
			'ID'           => 0,
			'manual'       => '',
			'project'      => '',
			'project_text'      => '',
			'maxtime'      => '',
			'display_time' => '',
			'title'        => '',
			'intro'        => '',
		);
	}
	global $wpdb;
	if ( ! $post_id ) {
		global $post;
		$post_id = $post->ID;
	}
	if ( $backup ) {
		$field = '_role_Backup_Speaker_1';
	} elseif ( ! is_numeric( $assigned ) ) { // guest speaker
		return array(
			'ID'           => '',
			'manual'       => '',
			'project'      => '',
			'project_text'      => '',
			'maxtime'      => 0,
			'display_time' => '',
			'title'        => '',
			'intro'        => '',
		);
	} else {
		$field = $wpdb->get_var( "SELECT meta_key from $wpdb->postmeta WHERE post_id=$post_id AND meta_key LIKE '%Speaker%' AND meta_value='" . $assigned . "' " );
	}
	$speaker_arrays[ $key ] = get_speaker_array_by_field( $field, $assigned, $post_id );
	return $speaker_arrays[ $key ];
}

function get_speaker_array_by_field( $field, $assigned, $post_id = 0 ) {
	if ( ! $post_id ) {
		global $post;
		$post_id = $post->ID;
	}
	$speaker['ID']           = $assigned;
	$speaker['manual']       = get_post_meta( $post_id, '_manual' . $field, true );
	$speaker['project']      = get_post_meta( $post_id, '_project' . $field, true );
	$speaker['project_text'] = ($speaker['project']) ? get_project_text($speaker['project']) : '';
	$speaker['maxtime']      = get_post_meta( $post_id, '_maxtime' . $field, true );
	$speaker['display_time'] = get_post_meta( $post_id, '_display_time' . $field, true );
	$speaker['title']        = get_post_meta( $post_id, '_title' . $field, true );
	$speaker['intro']        = get_post_meta( $post_id, '_intro' . $field, true );

	if ( empty( $speaker['manual'] ) ) {
		$speaker['manual'] = 'Path Not Set Level 1 Mastering Fundamentals';
	}
	if ( empty( $speaker['maxtime'] ) ) {
		$speaker['maxtime'] = 7;
	}
	return apply_filters( 'get_speaker_array', $speaker, $field, $post_id );
}

function save_speaker_array( $speaker, $count, $post_id = 0 ) {
	$field = wp4t_fieldbase('Speaker',$count);
	if ( ! $post_id ) {
		global $post;
		$post_id = $post->ID;
	}
	update_post_meta( $post_id, $field, $speaker['ID'] );
	foreach ( $speaker as $name => $value ) {
		if ( $name == 'ID' ) {
			continue;
		}
		update_post_meta( $post_id, $name . $field, strip_tags( $value, '<p><br><strong><em><a>' ) );
	}
}

function pack_speakers( $count, $post_id = null ) {
	global $post;
	if(!$post_id)
		$post_id = $post->ID;

	for ( $i = 1; $i <= $count; $i++ ) {

		$field    = wp4t_fieldbase('Speaker',$i);
		$assigned = get_post_meta( $post_id, $field, true );
		if ( empty( $assigned ) ) {
			// fill the first open speaker slot with backup speaker, if any
			$backup = (int) get_post_meta( $post->ID, '_role_Backup_Speaker_1', true );
			if ( $backup > 0 ) {
				$speaker = get_speaker_array( $backup, $post_id, true );
				save_speaker_array( $speaker, $i, $post_id );
				delete_post_meta( $post_id, '_role_Backup_Speaker_1' );
				delete_post_meta( $post_id, '_manual_role_Backup_Speaker_1' );
				delete_post_meta( $post_id, '_project_role_Backup_Speaker_1' );
				delete_post_meta( $post_id, '_maxtime_role_Backup_Speaker_1' );
				delete_post_meta( $post_id, '_display_time_role_Backup_Speaker_1' );
				delete_post_meta( $post_id, '_title_role_Backup_Speaker_1' );
				delete_post_meta( $post_id, '_intro_role_Backup_Speaker_1' );
				backup_speaker_notify( $backup, $post_id );
			}
			return;
		}
	}
}//end pack_speakers()

function pack_roles( $count, $fieldbase ) {
	global $post;
	for ( $i = 1; $i <= $count; $i++ ) {

		$field    = '_' . $fieldbase . '_' . $i;
		$assigned = get_post_meta( $post->ID, $field, true );
		if ( empty( $assigned ) ) {
				$backupfield = '_Backup_' . $fieldbase . '_1';
				$backup      = (int) get_post_meta( $post->ID, $backupfield, true );
			if ( $backup > 0 ) {
				update_post_meta( $post->ID, $field, $backup );
				delete_post_meta( $post->ID, $backupfield );
			}
			return;
		}
	}
}//end pack_roles()

add_action( 'template_redirect', 'wp4t_redirect' );
function wp4t_redirect() {
		global $post;
		
		if ( isset( $_REQUEST['tm_reports'] ) ) {
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/reports-fullscreen.php';
			die();
		} elseif ( isset( $_REQUEST['blank'] ) ) {

			$template = get_block_template( get_stylesheet() . '//blank' );
			if(!empty($template->content)) {
				echo do_blocks($template->content);
				die();	
			}
		} elseif ( isset( $_REQUEST['timer'] ) ) {
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/timer.php';
			die();
		} elseif ( isset( $_REQUEST['jitsi'] ) ) {
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/jitsi.php';
			die();
		} elseif ( isset( $_REQUEST['zoom'] ) ) {
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/zoom.php';
			die();
		} elseif ( isset( $_REQUEST['scoring'] ) ) {
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/scoring.php';
			die();
		}

		if ( ! ( isset( $post ) )) {
			return;
		}
		if(is_admin())
			return;

		if ( isset( $_REQUEST['word_agenda'] )) {
			if ( get_option( 'wp4toastmasters_stoplight' ) ) {
				add_filter( 'agenda_time_display', 'display_time_stoplight' );
			}
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda-word.php';
			die();
		} 
		elseif ( isset( $_REQUEST['print_agenda'] ) ) {
			if ( get_option( 'wp4toastmasters_stoplight' ) ) {
				add_filter( 'agenda_time_display', 'display_time_stoplight' );
			}
			$agendapath = WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda-custom.php';
			// advanced customization option
			$agendapath = apply_filters( 'toastmasters_agendapath', $agendapath );
			include $agendapath;
			die();
		}
		elseif ( isset( $_REQUEST['agenda_layout'] ) ) {
			$agendapath = WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda_layout.php';
			include $agendapath;
			die();
		}
		elseif ( isset( $_REQUEST['print'] ) ) {
			$agendapath = WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/print.php';
			include $agendapath;
			die();
		}
		
		elseif ( isset($_GET['email_agenda']) || is_email_context() ) {
			if ( get_option( 'wp4toastmasters_stoplight' ) ) {
				add_filter( 'agenda_time_display', 'display_time_stoplight' );
			}
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/email_agenda.php';
			die();
		}
		
		elseif ( isset( $_REQUEST['voting'] ) ) {
			include WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/voting.php';
			die();
		} elseif ( isset( $_REQUEST['intros'] ) ) {
			speech_intros();
			die();
		}
}

function tm_sidebar_post( $post_id ) {
	$sidebar          = wp_kses_post(simplify_html( $_POST['_tm_sidebar'] ) );
	$template         = ( isset( $_POST['template'] ) ) ? (int) $_POST['template'] : 0;
	$sidebar_officers = ( isset( $_POST['sidebar_officers'] ) && $_POST['sidebar_officers'] ) ? 1 : 0;
	update_post_meta( $post_id, '_tm_sidebar', $sidebar );
	update_post_meta( $post_id, '_sidebar_officers', $sidebar_officers );
	if ( $template ) {
		update_post_meta( $template, '_tm_sidebar', $sidebar );
		update_post_meta( $template, '_sidebar_officers', $sidebar_officers );
		$future_events = future_rsvpmakers_by_template( $template );
		if ( ! empty( $future_events ) ) {
			foreach ( $future_events as $event ) {
				update_post_meta( $event, '_tm_sidebar', $sidebar );
				update_post_meta( $event, '_sidebar_officers', $sidebar_officers );
			}
		}
	}
}

function themewords( $atts ) {
	global $post;

	if ( isset( $_POST['themewords'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		update_post_meta( $post->ID, '_themewords', wp_kses_post(simplify_html( $_POST['themewords'] ) ) );
	}

	ob_start();

	if ( is_club_member() && is_edit_roles() ) {
		?>
					<div id="themewords">
					<h3><?php _e( 'Theme/Words', 'rsvpmaker-for-toastmasters' ); ?></h3>
					<textarea name="themewords" rows="5" cols="80" class="mce">
					<?php

					echo wpautop( get_post_meta( $post->ID, '_themewords', true ) );
					?>
					 </textarea>
					</div>
		<?php
	} elseif ( isset( $_REQUEST['print_agenda'] ) ) {
		$th = get_post_meta( $post->ID, '_themewords', true );
		if ( ! empty( $th ) ) {
			return '<div class="agenda_note">' . wpautop( $th ) . '</div>';
		}
	} else {
		$th = get_post_meta( $post->ID, '_themewords', true );
		if ( ! empty( $th ) ) {
			?>
					<div id="themewords">
					<h3 style="font-weight: bold; margin-top: 20px;"><?php _e( 'Theme/Words', 'rsvpmaker-for-toastmasters' ); ?></h3>
					<?php echo wpautop( $th ); ?>
					</div>
			<?php
		}
	}
	return ob_get_clean();
}

function simplify_html( $text, $allowable_tags = '<p><br><div><b><strong><em><i><h1><h2><h3><h4><h5><h6><ol><ul><li><a>' ) {
	$text = strip_tags( $text, $allowable_tags );
	// $text = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $text);
	$text = preg_replace( '/style="[^"]+"/i', '', $text );
	$text = trim( str_replace( '&nbsp;', ' ', $text ) );
	return preg_replace( '|</{0,1}p>|i', "\n", $text );
}

function user_archive() {
	global $wpdb;
	$wpdb->show_errors();

	toast_activate(  );

	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
	foreach ( $blogusers as $user ) {
		$meta = get_user_meta( $user->ID );
		// Filter out empty meta data
		$meta     = array_filter(
			array_map(
				function( $a ) {
					return $a[0];
				},
				$meta
			)
		);
		$userdata = array_merge(
			array(
				'ID'         => $user->ID,
				'user_login' => $user->user_login,
				'user_email' => $user->user_email,
			),
			$meta
		);
		$index    = ( isset( $userdata['last_name'] ) ) ? $userdata['last_name'] . $userdata['first_name'] : $user->user_login;
		$index    = preg_replace( '/[^A-Za-z]/', '', $index );
		$id       = $wpdb->get_var( 'SELECT id FROM ' . $wpdb->prefix . 'users_archive WHERE user_id=' . $user->ID );
		if ( ! $id ) {
			$id = $wpdb->get_var( 'SELECT id FROM ' . $wpdb->prefix . "users_archive WHERE sort='" . $index . "' AND email='" . $user->user_email . "'" );
		}
		if ( ! $id && isset( $meta['toastmasters_id'] ) ) {
			$id = $wpdb->get_var( 'SELECT id FROM ' . $wpdb->prefix . "users_archive WHERE toastmasters_id='" . $meta['toastmasters_id'] . "'" );
		}
		if ( $id ) {
			$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->prefix . 'users_archive SET data=%s, sort=%s, email=%s, user_id=%d WHERE id=%d', serialize( $userdata ), $index, $user->user_email, $user->ID, $id ) );
		} else {
			$id = $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->prefix . 'users_archive SET data=%s, sort=%s, user_id=%d, email=%s', serialize( $userdata ), $index, $user->ID, $user->user_email ) );
		}
		if ( isset( $meta['toastmasters_id'] ) && $meta['toastmasters_id'] ) {
			$toastmasters_id = (int) $meta['toastmasters_id'];
			$sql             = 'UPDATE ' . $wpdb->prefix . 'users_archive SET toastmasters_id=' . $toastmasters_id . ' WHERE id=' . $id;
			$wpdb->query( $sql );
		}
	}
}

if ( ! function_exists( 'add_implicit_links' ) ) {
	function add_implicit_links( $text ) {
		$text = preg_replace( '! ([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{3})!i', ' <a href="mailto:$1">$1</a>', $text );
		$text = preg_replace( '! (www.[a-z0-9_./?=&-;]+)!i', ' <a href="http://$1">$1</a>', $text );
		$text = preg_replace( '! (https{0,1}://[a-z0-9_./?=&-;]+)!i', ' <a href="$1">$1</a>', $text );
		return $text;
	}
}

function member_not_user() {
	echo '<p style="color: red;"><b>For Toastmasters members, please use the <a href="' . admin_url( 'users.php?page=add_awesome_member' ) . '">Add Member</a> form instead.</b></p>';
}

// want this to run ASAP, even before init
add_action( 'plugins_loaded', 'add_awesome_roles' );

function add_awesome_roles() {
	$manager = get_role( 'manager' );

	if ( ! $manager ) {
		add_role(
			'manager',
			'Manager',
			array(
				'delete_others_pages'       => true,
				'read'                      => true,
				'upload_files'              => true,
				'delete_others_posts'       => true,
				'delete_pages'              => true,
				'delete_posts'              => true,
				'delete_private_pages'      => true,
				'delete_private_posts'      => true,
				'delete_published_pages'    => true,
				'delete_published_posts'    => true,
				'edit_others_pages'         => true,
				'edit_others_posts'         => true,
				'edit_pages'                => true,
				'edit_posts'                => true,
				'edit_private_pages'        => true,
				'edit_private_posts'        => true,
				'edit_published_pages'      => true,
				'edit_published_posts'      => true,
				'manage_categories'         => true,
				'manage_links'              => true,
				'moderate_comments'         => true,
				'publish_pages'             => true,
				'publish_posts'             => true,
				'read_private_pages'        => true,
				'read_private_posts'        => true,
				'delete_others_rsvpmakers'  => true,
				'delete_rsvpmakers'         => true,
				'delete_others_pages'       => true,
				'edit_published_rsvpmakers' => true,
				'publish_rsvpmakers'        => true,
				'read_private_rsvpmakers'   => true,
				'promote_users'             => true,
				'remove_users'              => true,
				'delete_users'              => true,
				'list_users'                => true,
				'edit_users'                => true,
				'view_reports'              => true,
				'view_contact_info'         => true,
				'edit_signups'              => true,
				'edit_member_stats'         => true,
				'edit_own_stats'            => true,
				'agenda_setup'              => true,
				'email_list'                => true,
				'add_member'                => true,
				'edit_members'              => true,
			)
		);
	}
}

function manager_author_editor() {
	$users = get_users(
		array(
			'role__in'     => array( 'manager' ),
			'role__not_in' => array( 'editor' ),
			'blog_id'      => get_current_blog_id(),
		)
	);
	foreach ( $users as $user ) {
		$user->add_role( 'editor' );
	}
}
add_action( 'admin_init', 'manager_author_editor' );

function awesome_role_activation_wrapper() {

	global $current_user;

	// print_r($_REQUEST);

	register_activation_hook( __FILE__, 'add_awesome_roles' );
	if ( isset( $_REQUEST['add_awesome_roles'] ) ) {
		add_awesome_roles();
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['make_manager'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		foreach($_POST['wp4toastmasters_officer_ids'] as $id) {
			$id = intval($id);
			if($id && !user_can($id,'edit_users'))
			{
				$user     = array(
					'ID'         => $id,
					'role'       => 'manager',
				);
				wp_update_user( $user );
			}
		}
	}

	if ( isset( $_POST['wp4toastmasters_manager_ids'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['wp4toastmasters_manager_ids'] as $id ) {
				$id = (int) $id;
			if ( ( $id == 0 ) || ( $id == $current_user->ID ) ) {
				continue;
			} elseif ( user_can( $id, 'manage_options' ) || user_can( $id, 'administrator' ) ) {
				continue; // don't mess with the admin
			} else {
					$userdata = get_userdata( $id );
					$user     = array(
						'ID'         => $id,
						'role'       => 'manager',
						'user_email' => $userdata->user_email,
					);
					wp_update_user( $user );
			}
		}
		// exit();
	}

	if ( ! empty( $_POST['wpt_remove_admin'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$primary = wpt_primary_admin();

		if ( ( $current_user->ID == $primary ) && current_user_can( 'manage_options' ) ) {
			$id = (int) $_POST['wpt_remove_admin'];
			if ( user_can( $id, 'manage_network' ) ) {
				return; // don't mess with the network admin
			}
			$userdata = get_userdata( $id );
			$user     = array(
				'ID'         => $id,
				'role'       => 'manager',
				'user_email' => $userdata->user_email,
			);
			wp_update_user( $user );
		}
	}
	if ( ! empty( $_POST['set_wpt_primary_admin'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$id = (int) $_POST['set_wpt_primary_admin'];
		set_wpt_primary_admin( $id ); // this function will check rights
	}

	if ( isset( $_POST['wp4toastmasters_admin_ids'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['wp4toastmasters_admin_ids'] as $id ) {
				$id = (int) $id;
			if ( ( $id == 0 ) || ( $id == $current_user->ID ) ) {
				continue;
			} elseif ( user_can( $id, 'manage_options' ) || user_can( $id, 'administrator' ) ) {
				continue; // don't mess with the admin
			} else {
					$userdata = get_userdata( $id );
					$user     = array(
						'ID'         => $id,
						'role'       => 'administrator',
						'user_email' => $userdata->user_email,
					);
					wp_update_user( $user );
			}
		}
	}

}

function set_wpt_primary_admin( $user_id ) {
	if ( current_user_can( 'manage_options' ) ) {
		update_option( 'wpt_primary_admin', $user_id );
	}
}

function wpt_primary_admin() {
	$primary = (int) get_option( 'wpt_primary_admin' );
	if ( $primary && is_user_member_of_blog($primary) ) {
		$user = get_userdata( $primary );
	}
	if ( empty( $user ) ) {
		$admin_email = get_option( 'admin_email' );
		$user        = get_user_by( 'email', $admin_email );
		if ( $user ) {
			$primary = $user->ID;
		}
		if(is_user_member_of_blog($primary))
			update_option( 'wpt_primary_admin', $primary );
	}

	if ( !empty($user) && $primary && is_user_member_of_blog($primary) ) { // if this is set and matches an active user record
		return $primary;
	}
	return false;
}

function jstest() {
	global $post;
	if ( ( isset( $post->post_content ) && is_wp4t() ) || ( isset( $_REQUEST['page'] ) && ( ( $_REQUEST['page'] == 'toastmasters_reconcile' ) || ( $_REQUEST['page'] == 'my_progress_report' ) || ( $_REQUEST['page'] == 'wp4t_evaluations' ) || ( $_REQUEST['page'] == 'toastmasters_reports' ) ) ) ) {
		return 'js yes';
	} else {
		return 'jsno';
	}
}


function wp4t_assigned_open() {
	global $post;
	$roster = '';
	$signup = get_post_custom( $post->ID );

	$data = wpt_blocks_to_data( $post->post_content );
	foreach ( $data as $d ) {
		if ( ! empty( $d['role'] ) ) {
			$role  = $d['role'];
			$count = ( empty( $d['count'] ) ) ? 1 : (int) $d['count'];
			for ( $i = 1; $i <= $count; $i++ ) {
				$field           = wp4t_fieldbase($role,$i);
				$roles[ $field ] = wp4t_role($role);
			}
		}
	}

	$has_assignment = array();
	foreach ( $roles as $field => $role ) {
		   $assigned = ( isset( $signup[ $field ][0] ) ) ? $signup[ $field ][0] : '';
		if ( ! empty( $assigned ) ) {
			$has_assignment[] = $assigned;
		}
		if ( is_numeric( $assigned ) ) {
			  $userdata = get_userdata( $assigned );
			  $status   = wp4_format_contact( $userdata );
			if ( $role == 'Speaker' ) {
				if ( ! empty( $signup[ '_manual' . $field ][0] ) ) {
					  $status .= $signup[ '_manual' . $field ][0] . "\n";
				}
			}
		} else {
			$status = $assigned;
		}
		   $roster .= sprintf( "<strong>%s:</strong>\n%s" . "\n", str_replace( '_', ' ', wp4t_role($role) ), $status );
	}
	$absences       = get_absences_array( $post->ID );
	$has_assignment = array_merge( $has_assignment, $absences );

	if ( ! empty( $absences ) ) {
		foreach ( $absences as $a ) {
			$user           = get_userdata( $a );
			$absent_names[] = ( ! empty( $user->first_name ) ) ? $user->first_name . ' ' . $user->last_name : $user->user_login;
		}
	}

	if ( ! empty( $absent_names ) ) {
		$roster .= '<p><strong>'.__('Planned Absences','rsvpmaker-for-toastmasters').':</strong> ' . implode( ', ', $absent_names ) . '</p>';
	}
	$roster .= wp4_email_contacts( $has_assignment );

	$roster = wpautop( $roster );
	if ( isset( $_REQUEST['email_me'] ) ) {
		global $current_user;
		wp_mail( $current_user->user_email, __( 'Meeting Roster', 'rsvpmaker-for-toastmasters' ), $roster, array( 'Content-Type: text/html; charset=UTF-8' ) );
	}
	return $roster;
}

function get_absences_array( $post_id ) {
	global $post;
	$absences = get_post_meta( $post_id, 'tm_absence' );
	if ( empty( $absences ) ) {
		$absences = array();
	}
	if(isset($_GET['test']))
		print_r($absences);
		$time      = get_rsvpmaker_timestamp( $post_id );
		$away      = '';
		$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
		// Array of WP_User objects.
	foreach ( $blogusers as $user ) {
		$exp = get_user_meta( $user->ID, 'status_expires', true );
		if ( empty( $exp ) ) {
			continue;
		}
		if ( $exp >= $time ) {
			$absences[] = $user->ID;
		}
	}
	return array_unique( $absences );
}

function wp4_email_contacts( $has_assignment = array() ) {
	global $wpdb, $post;
	$nonce = get_post_meta($post->ID,'oneclicknonce',true);
	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post->ID AND meta_key LIKE '_suggest%' ";
	$results = $wpdb->get_results($sql);
	foreach($results as $row){
		$sugg[$row->meta_value] = $row->meta_key;
	}

	$output = '';
	if ( ! empty( $has_assignment ) ) {
		$output .= '<h2>' . __( 'List of Members Without an Assignment', 'rsvpmaker-for-toastmasters' ) . "</h2>\n\n";
	}

	$blogusers = get_users( 'blog_id=' . get_current_blog_id() . '&orderby=nicename' );
	foreach ( $blogusers as $user ) {
		if ( in_array( $user->ID, $has_assignment ) ) {
			continue;
		}
		$userdata = get_userdata( $user->ID );
		$index             = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );
		$members[ $index ] = $userdata;
	}

	if ( ! empty( $members ) ) {
		ksort( $members );
		foreach ( $members as $userdata ) {
			$output .= wp4_format_contact( $userdata );
			if(!empty($sugg[$userdata->ID])) {
				$roletag = str_replace('_suggest','',$sugg[$userdata->ID]);
				$role = wp4t_role(clean_role($sugg[$userdata->ID]));
				$args = array('oneclick' => $nonce,'role' => $roletag,'e' => $userdata->user_email);
				$url = add_query_arg($args,get_permalink($post->ID)).'#oneclick';
				$output .= sprintf('<div>Suggested role for %s: %s<br><a href="%s">One-Click Signup: %s</a></p>',$userdata->display_name,clean_role($sugg[$userdata->ID]),$url,$url);	
			}
		}
	}
	return $output;
}

function toolbar_add_member( $wp_admin_bar ) {
	if ( current_user_can( 'edit_others_posts' ) ) {
	$args = array(
		'id'     => 'youtube_tool',
		'title'  => __( 'YouTube Replay', 'rsvpmaker-for-toastmasters' ),
		'href'   => admin_url( 'upload.php?page=tm_youtube_tool' ),
		'parent' => 'new-content',
		'meta'   => array( 'class' => 'youtube_tool' ),
	);
	$wp_admin_bar->add_node( $args );
	}

	if ( ! current_user_can( 'list_users' ) ) {
		return $wp_admin_bar;
	}
	$args = array(
		'id'     => 'add_member',
		'title'  => __( 'Member', 'rsvpmaker-for-toastmasters' ),
		'href'   => admin_url( 'users.php?page=add_awesome_member' ),
		'parent' => 'new-content',
		'meta'   => array( 'class' => 'add_member' ),
	);
	$wp_admin_bar->add_node( $args );
}

if ( ! function_exists( 'rsvpmaker_permalink_query' ) ) {
	function rsvpmaker_permalink_query( $id, $query = '' ) {
		if ( ! $id ) {
			return;
		}
		$p  = get_permalink( $id );
		$p .= strpos( $p, '?' ) ? '&' : '?';
		if ( is_array( $query ) ) {
			foreach ( $query as $name => $value ) {
				$qstring .= $name . '=' . $value . '&';
			}
		} else {
			$qstring = $query;
		}

		return $p . $qstring;

	}
} // end function exists

function toastmasters_datebox_message() {
	echo '<div style="padding: 5px; margin: 5px; backround-color: #eee; border: thin dotted black;">' . __( 'For a regular Toastmasters meeting, do not worry about the parameters below. You may use this RSVP functionality to schedule other sorts of events (for example, training or open house events.)', 'rsvpmaker-for-toastmasters' ) . '</div>';
}


function wp4toast_template( $user_id = 1, $autorenew = false ) {

	global $wpdb, $rsvp_options;
	$sql = "SELECT ID FROM `$wpdb->posts` WHERE (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') AND post_status='publish' ORDER BY `ID` DESC ";
	if ( $wpdb->get_var( $sql ) ) {
		return;
	}

	$default = '<!-- wp:wp4toastmasters/help /-->

<!-- wp:wp4toastmasters/agendaedit {"editable":"Welcome and Introductions","uid":"editable16181528933590.29714489144034184","time_allowed":"5","inline":true} /-->

<!-- wp:wp4toastmasters/role {"role":"Toastmaster of the Day","agenda_note":"Introduces supporting roles. Leads the meeting.","time_allowed":"4"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ah Counter"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer"} /-->

<!-- wp:wp4toastmasters/role {"role":"Vote Counter"} /-->

<!-- wp:wp4toastmasters/role {"role":"Grammarian","agenda_note":"Leads word of the day contest."} /-->

<!-- wp:wp4toastmasters/role {"role":"Topics Master","time_allowed":"10"} /-->

<!-- wp:wp4toastmasters/role {"role":"Speaker","count":3,"time_allowed":"23","backup":"1"} /-->

<!-- wp:wp4toastmasters/role {"role":"General Evaluator","agenda_note":"Explains the importance of evaluations. Introduces Evaluators."} /-->

<!-- wp:wp4toastmasters/role {"role":"Evaluator","count":3,"time_allowed":"9"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"2","uid":"note31972"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">General Evaluator asks for reports from the Grammarian, Ah Counter, and Body Language Monitor. General Evaluator gives an overall assessment of the meeting.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"1","uid":"note21837"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Toastmaster of the Day presents the awards.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"1","uid":"note30722"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President wraps up the meeting.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/milestone {"label":"Meeting Ends"} -->
<p maxtime="x" class="wp-block-wp4toastmasters-milestone">Meeting Ends</p>
<!-- /wp:wp4toastmasters/milestone -->

<!-- wp:wp4toastmasters/agendaedit {"editable":"Theme and Word of the Day","uid":"editable16181528612380.6987292403509966"} /-->

<!-- wp:wp4toastmasters/absences /-->';

	$post       = array(
		'post_content' => $default,
		'post_name'    => 'toastmasters-meeting',
		'post_title'   => 'Toastmasters Meeting',
		'post_status'  => 'publish',
		'post_type'    => 'rsvpmaker_template',
		'post_author'  => $user_id,
		'ping_status'  => 'closed',
	);
	$templateID = wp_insert_post( $post );

	if ( $parent_id = wp_is_post_revision( $templateID ) ) {
		$templateID = $parent_id;
	}
	$sked = get_option( 'initial_sked' );
	if ( isset( $_POST['sked'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$template = array_map('sanitize_text_field',$_POST['sked']);
		if ( isset( $_POST['hour'] ) ) {
			$template['hour'] = sanitize_text_field($_POST['hour']);
		}
		if ( isset( $_POST['minutes'] ) ) {
			$template['minutes'] = sanitize_text_field($_POST['minutes']);
		}
	} elseif ( $sked ) {
		$template = $sked;
	} else {
		$template['week'] = 0;
		$template['dow'] = 9;
		$template['hour']    = 19;
		$template['minutes'] = '00';
		$template['week']    = 0;
	}

	new_template_schedule( $templateID, $template );
	update_option( 'default_toastmasters_template', $templateID );
	update_option( 'toastmasters_meeting_template', $templateID );
	update_option( 'wp4toastmasters_agenda_layout', 'custom' );
	update_post_meta( $templateID, '_tm_sidebar', '<strong>Club Mission:</strong> We provide a supportive and positive learning experience in which members are empowered to develop communication and leadership skills, resulting in greater self-confidence and personal growth.' );
	update_post_meta( $templateID, '_sidebar_officers', 1 );
	update_option( 'default_toastmasters_template', $templateID );
	if($autorenew) {
		update_post_meta($templateID,'_rsvp_on',1);
		auto_renew_project($templateID,false);
		$rsvp_options['rsvp_on'] = 1;
		update_option('RSVPMAKER_Options',$rsvp_options);
	}
	wp4t_contest_templates ();
}

function wp4t_contest_templates () {
$v = 4;
$version = (int) get_option('wpt_contest_templates_version');
if($version >= $v)
	return $version;
global $wpdb, $current_user;

$contest_templates['Contest'] = '<!-- wp:wp4toastmasters/help /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note5474"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms calls the meeting to the order.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9971"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President or Presiding Officer introduces the Contest Master.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Contest Master","count":"1","agenda_note":"Delivers opening remarks","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Chief Judge","count":"1","agenda_note":"Explains the rules. Asks the timers to demonstrate the timing lights.","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ballot Counter","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"International Contest Speaker","count":"6","time_allowed":"48"} /-->

<!-- wp:wp4toastmasters/role {"role":"Humorous Contest Speaker","count":"6","time_allowed":"48"} /-->

<!-- wp:wp4toastmasters/role {"role":"Tall Tales Contest Speaker","count":"6","time_allowed":"48"} /-->

<!-- wp:wp4toastmasters/role {"role":"Evaluation Contestant","count":"6","time_allowed":"24"} /-->

<!-- wp:wp4toastmasters/role {"role":"Table Topics Contestant","count":"6","time_allowed":"18"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note16295494558540.26410404771729024"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Ballot counters collect the votes of the judges and report back when the ballot counting is finished. During this time, the Contest Master may interview the contestants.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note15913"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Awards Ceremony</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9646"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Announcements and conclusion.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';

$contest_templates['International Speech Contest'] = '<!-- wp:wp4toastmasters/help /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note5474"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms calls the meeting to the order.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9971"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President or Presiding Officer introduces the Contest Master.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Contest Master","count":"1","agenda_note":"Delivers opening remarks","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Chief Judge","count":"1","agenda_note":"Explains the rules. Asks the timers to demonstrate the timing lights.","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ballot Counter","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"International Contest Speaker","count":"6","time_allowed":"48"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note16295494558540.26410404771729024"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Ballot counters collect the votes of the judges and report back when the ballot counting is finished. During this time, the Contest Master may interview the contestants.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note15913"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Awards Ceremony</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9646"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Announcements and conclusion.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';

$contest_templates['Humorous Speech Contest'] = '<!-- wp:wp4toastmasters/help /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note5474"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms calls the meeting to the order.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9971"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President or Presiding Officer introduces the Contest Master.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Contest Master","count":"1","agenda_note":"Delivers opening remarks","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Chief Judge","count":"1","agenda_note":"Explains the rules. Asks the timers to demonstrate the timing lights.","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ballot Counter","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Humorous Contest Speaker","count":"6","time_allowed":"48"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note16295494558540.26410404771729024"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Ballot counters collect the votes of the judges and report back when the ballot counting is finished. During this time, the Contest Master may interview the contestants.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note15913"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Awards Ceremony</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9646"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Announcements and conclusion.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';

$contest_templates['Tall Tales Speech Contest'] = '<!-- wp:wp4toastmasters/help /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note5474"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms calls the meeting to the order.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9971"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President or Presiding Officer introduces the Contest Master.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Contest Master","count":"1","agenda_note":"Delivers opening remarks","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Chief Judge","count":"1","agenda_note":"Explains the rules. Asks the timers to demonstrate the timing lights.","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ballot Counter","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Tall Tales Contest Speaker","count":"6","time_allowed":"48"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note16295494558540.26410404771729024"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Ballot counters collect the votes of the judges and report back when the ballot counting is finished. During this time, the Contest Master may interview the contestants.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note15913"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Awards Ceremony</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9646"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Announcements and conclusion.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';

$contest_templates['Table Topics Contest'] = '<!-- wp:wp4toastmasters/help /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note5474"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms calls the meeting to the order.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9971"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President or Presiding Officer introduces the Contest Master.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Contest Master","count":"1","agenda_note":"Delivers opening remarks","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Chief Judge","count":"1","agenda_note":"Explains the rules. Asks the timers to demonstrate the timing lights.","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ballot Counter","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Table Topics Contestant","count":"6","time_allowed":"18"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note16295494558540.26410404771729024"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Ballot counters collect the votes of the judges and report back when the ballot counting is finished. During this time, the Contest Master may interview the contestants.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note15913"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Awards Ceremony</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9646"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Announcements and conclusion.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';

$contest_templates['Evaluation Contest'] = '<!-- wp:wp4toastmasters/help /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note5474"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms calls the meeting to the order.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9971"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President or Presiding Officer introduces the Contest Master.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Contest Master","count":"1","agenda_note":"Delivers opening remarks","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Chief Judge","count":"1","agenda_note":"Explains the rules. Asks the timers to demonstrate the timing lights.","time_allowed":"5"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"2"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ballot Counter","count":"2"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note16295488898690.6030916952992875"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">The Contest Master introduces the Test Speaker, who delivers a 5-7 minute speech.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"5","uid":"note16295492510330.21824611896692914"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">The contestants leave the room to prepare their notes.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Evaluation Contestant","count":"6","time_allowed":"24"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note16295494558540.26410404771729024"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Ballot counters collect the votes of the judges and report back when the ballot counting is finished. During this time, the Contest Master may interview the contestants.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"10","uid":"note15913"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Awards Ceremony</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"uid":"note9646"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Announcements and conclusion.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';

foreach($contest_templates as $title => $default) {

	$sql = $wpdb->prepare("select ID from $wpdb->posts join $wpdb->postmeta ON $wpdb->posts.ID=$wpdb->postmeta.post_id where meta_key='_sked_Varies' and post_title=%s ",$title);
	$results = $wpdb->get_results($sql);
	foreach($results as $row) {
		$sql = $wpdb->prepare("UPDATE $wpdb->posts SET post_title=%s WHERE ID=%d",$title.' (Backup '.date('Y-m-d').')',$row->ID);
		$wpdb->query($sql);
	}
	$post       = array(
		'post_content' => $default,
		'post_title'   => $title,
		'post_status'  => 'publish',
		'post_type'    => 'rsvpmaker_template',
		'post_author'  => $current_user->ID,
		'ping_status'  => 'closed',
	);
	$templateID = wp_insert_post( $post );

	if ( $parent_id = wp_is_post_revision( $templateID ) ) {
		$templateID = $parent_id;
	}
	$template['hour']    = 19;
	$template['minutes'] = '00';
	$template['week']    = 0;

	new_template_schedule( $templateID, $template );
}
update_option('wpt_contest_templates_version',$v);
return $v;
}

register_activation_hook( __FILE__, 'wp4toast_template' );

function new_agenda_template() {
	global $current_user;
	if ( ! isset( $_REQUEST['submit'] ) || ( $_REQUEST['submit'] != 'Make New Agenda Template' ) ) {
		return;
	}
	$default = '[toastmaster role="Speaker" count="1" ]';

	$post       = array(
		'post_content' => $default,
		'post_title'   => 'Title Goes Here',
		'post_status'  => 'publish',
		'post_type'    => 'rsvpmaker',
		'post_author'  => $current_user->ID,
		'ping_status'  => 'closed',
	);
	$templateID = wp_insert_post( $post );

	if ( $parent_id = wp_is_post_revision( $templateID ) ) {
		$templateID = $parent_id;
	}
	$template['hour']      = 19;
	$template['minutes']   = '00';
	$template['week']      = 6;
	$template['dayofweek'] = 1;

	new_template_schedule( $templateID, $template );
	header( 'Location: ' . admin_url( 'edit.php?post_type=rsvpmaker&page=agenda_setup&post_id=' . $templateID ) );
	exit();
}

function toast_activate(  ) {
	if(!function_exists('rsvpmaker_create_post_type'))
	{
		//rsvpmaker is not active
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die('<strong>RSVPMaker</strong> must be activated before <strong>RSVPMaker for Toastmasters</strong> can be used.');
	}
	tm_security_setup();

	global $wpdb;
	$history_table = $wpdb->base_prefix.'tm_history';
	$speech_history_table = $wpdb->base_prefix.'tm_speech_history';

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$sql = 'CREATE TABLE `' . $wpdb->prefix . "users_archive` (
  	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `sort` varchar(255) NOT NULL,
	  `data` text NOT NULL,
	  `user_id` int(11) NOT NULL DEFAULT '0',
	  `toastmasters_id` int(11) NOT NULL DEFAULT '0',
	  `guest` tinyint(4) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;
	";
    $sql .= "CREATE TABLE `$history_table` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`role` varchar(100) NOT NULL,
	`datetime` datetime NOT NULL,
	`rolecount` smallint(6) NOT NULL,
	`domain` varchar(255) NOT NULL,
	`user_id` int(11) NOT NULL,
	`post_id` int(11) NOT NULL,
	`metadata` text,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY  (`id`),
	KEY `user_id` (`user_id`),
	KEY `role` (`role`),
	KEY `datetime` (`datetime`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ";
$sql .= "CREATE TABLE `$speech_history_table` (
	`speech_id` int(11) NOT NULL AUTO_INCREMENT,
	`history_id` int(11) NOT NULL,
	`manual` varchar(255) NOT NULL,
	`project_key` varchar(255) NOT NULL,
	`project` varchar(255) NOT NULL,
	`title` varchar(255) NOT NULL,
	`intro` text NULL,
	`basecamp_record` VARCHAR(255),
	PRIMARY KEY  (`speech_id`),
	KEY `manual` (`manual`),
	KEY `history_id` (`history_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	$storedversion = get_option('rsvptoast_db');
	error_log('tm db check '.$storedversion);
	$version = hash('sha256',$sql);
	if($version == $storedversion)
		return;
	dbDelta( $sql );
	error_log('tm db update '.$version);
	// establish custom roles
	tm_security_setup();
	update_option( 'rsvptoast_db', $version );
}

function check_first_login() {
	$first = get_option( 'first_tm_login' );
	if ( $first ) {
		return;
	}
	update_option( 'first_tm_login', current_time( 'timestamp' ) );
	toast_activate(  ); // in case this didn't run on plugin activation (multisite)
}

function archive_users_init() {
	// if a logged in user access the users list, back up users
	if ( ! strpos( $_SERVER['REQUEST_URI'], 'user' ) ) {
		return;
	}
	user_archive();
}

register_activation_hook( __FILE__, 'toast_activate' );

function toolbar_link_to_agenda( $wp_admin_bar ) {
	global $post;
	if ( ! is_wp4t() || get_post_meta($post->ID,'_rsvpmaker_special',true) ) {
		return;
	}

	if ( ! current_user_can( 'edit_others_rsvpmakers' ) ) {
		return;
	}

	$args  = array(
		'id'    => 'agenda_layout',
		'title' => 'Agenda Layout',
		'href'  => add_query_arg('agenda_layout','1',get_permalink($post->ID)),
		'meta'  => array( 'class' => 'edit-agenda-layout' ),
	);
	$wp_admin_bar->add_node( $args );
}


function edit_template_url( $post_id ) {
	return admin_url( 'post.php?action=edit&post=' . $post_id );
}

function add_from_template_url( $post_id ) {
	return admin_url( 'edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=' . $post_id );
}

function agenda_setup_url( $post_id ) {
	return admin_url( 'edit.php?post_type=rsvpmaker&page=agenda_setup&post_id=' . $post_id );
}

function members_only_jetpack( $tag_array ) {
	if ( ! in_category( 'members-only' ) && ! has_term( 'members-only', 'rsvpmaker-type' ) ) {
		return $tag_array;
	}
	$tag_array['description'] = __( 'Members only content', 'rsvpmaker-for-toastmasters' );
	return $tag_array;
}



// widget for members only posts
class WP_Widget_Members_Posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_members_entries',
			'description' => __( 'Your site&#8217;s most recent members-only posts.', 'rsvpmaker-for-toastmasters' ),
		);
		parent::__construct( 'members-posts', __( 'Members Posts', 'rsvpmaker-for-toastmasters' ), $widget_ops );
		$this->alt_option_name = 'widget_members_entries';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	public function widget( $args, $instance ) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_members_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Members Only Posts', 'rsvpmaker-for-toastmasters' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the members Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the members posts.
		 */
		$r = new WP_Query(
			apply_filters(
				'widget_posts_args',
				array(
					'posts_per_page'      => $number,
					'category_name'       => 'members-only',
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				)
			)
		);

		if ( $r->have_posts() ) :
			?>
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php
			if ( $title ) {
				echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
			}
			?>
		<ul>
			<?php
			while ( $r->have_posts() ) :
				$r->the_post();
				?>
			<li>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_members_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_members_entries'] ) ) {
			delete_option( 'widget_members_entries' );
		}

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete( 'widget_members_posts', 'widget' );
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'rsvpmaker-for-toastmasters' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php _e( 'Number of posts to show:', 'rsvpmaker-for-toastmasters' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php _e( 'Display post date?', 'rsvpmaker-for-toastmasters' ); ?></label></p>
		<?php
	}
}

function wpt_blog_posts($atts) {
	$type = isset($atts['type']) ? $atts['type'] : 'private';
	$title = isset($atts['title']) ? $atts['title'] : 'Members Only';
	$number = isset($atts['number']) ? intval($atts['number']) : 10;
	if('public' == $type)
		return wpt_club_news_posts($title, $number);
	else
		return wpt_members_only_posts($title, $number);
}

function wpt_members_only_posts($title, $number) {
	ob_start();
	$r = new WP_Query(
		apply_filters(
			'widget_posts_args',
			array(
				'posts_per_page'      => $number,
				'category_name'       => 'members-only',
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			)
		)
	);

	if ( $r->have_posts() ) :
		if ( $title ) {
			echo '<h5 class="members-only-posts">' . $title . '</h5>';
		}
		?>
	<ul>
		<?php
		while ( $r->have_posts() ) :
			$r->the_post();
			?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<span class="post-date"><?php echo get_the_date(); ?></span>
		</li>
	<?php endwhile; ?>
	</ul>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
			endif;
	return ob_get_clean();
}

function wpt_club_news_posts($title, $number) {
	ob_start();
	$category = get_category_by_slug( 'members-only' );
	if ( $category ) {
		$qargs = array(
			'posts_per_page'      => $number,
			'cat'                 => '-' . $category->term_id,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);
	} else {
		$qargs = array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);
	}

	$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs ) );

	if ( $r->have_posts() ) :
		if ( $title ) {
			echo '<h5 class="club-news-posts">' . $title . '</h5>';
		}
		?>
	<ul>
		<?php
		while ( $r->have_posts() ) :
			$r->the_post();
			?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<span class="post-date"><?php echo get_the_date(); ?></span>
		</li>
	<?php endwhile; ?>
	</ul>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
			endif;
	return ob_get_clean();
}

// widget for posts excluding members only
class WP_Widget_Club_News_Posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_club_news_entries',
			'description' => __( 'Your site&#8217;s most recent public blog posts.', 'rsvpmaker-for-toastmasters' ),
		);
		parent::__construct( 'club-news-posts', __( 'Club News Posts', 'rsvpmaker-for-toastmasters' ), $widget_ops );
		$this->alt_option_name = 'widget_club_news_entries';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	public function widget( $args, $instance ) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_club_news_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Club News', 'rsvpmaker-for-toastmasters' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the club_news Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the club_news posts.
		 */
		$category = get_category_by_slug( 'members-only' );
		if ( $category ) {
			$qargs = array(
				'posts_per_page'      => $number,
				'cat'                 => '-' . $category->term_id,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			);
		} else {
			$qargs = array(
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			);
		}

		$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs ) );

		if ( $r->have_posts() ) :
			?>
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php
			if ( $title ) {
				echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
			}

			?>
		<ul>
			<?php
			while ( $r->have_posts() ) :
				$r->the_post();
				?>
			<li>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_club_news_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_club_news_entries'] ) ) {
			delete_option( 'widget_club_news_entries' );
		}

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete( 'widget_club_news_posts', 'widget' );
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php _e( 'Display post date?' ); ?></label></p>
		<?php
	}
}

class NewestMembersWidget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'newest_members',
			'description' => __( 'Newest Members of Club.', 'rsvpmaker-for-toastmasters' ),
		);
		parent::__construct( 'newest_members', __( 'Newest Members', 'rsvpmaker-for-toastmasters' ), $widget_ops );
		$this->alt_option_name = 'widget_newest_members';
	}

	public function widget( $args, $instance ) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_newest_members', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Newest Members', 'rsvpmaker-for-toastmasters' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		/**
		 * Filter the arguments for the newest_members widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the club_news posts.
		 */
		// fetch user list and sort
		$joinedslug = 'joined' . get_current_blog_id();
		$q          = 'blog_id=' . get_current_blog_id();
		$blogusers  = get_users( $q );
		foreach ( $blogusers as $user ) {
			$userdata = get_userdata( $user->ID );
			if ( ! empty( $userdata->$joinedslug ) ) {
				$index = rsvpmaker_date( 'Y-m-d', rsvpmaker_strtotime( $userdata->$joinedslug ) );
			} elseif ( ! empty( $userdata->club_member_since ) ) {
				$index = rsvpmaker_date( 'Y-m-d', rsvpmaker_strtotime( $userdata->club_member_since ) );
			} else {
				continue; // don't include if no join date
			}
			$month             = rsvpmaker_date( 'F Y', rsvpmaker_strtotime( $index ) );
			$index            .= $userdata->user_registered;
			$members[ $index ] = $userdata->first_name . ' ' . $userdata->last_name . ' (' . $month . ')';
		}

		?>
		<?php echo wp_kses_post($args['before_widget']); ?>
		<?php
		if ( $title ) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
			$count = 1;
			if ( ! empty( $members ) ) {
				krsort( $members );
				echo '<ul>';
				foreach ( $members as $index => $member ) {
						printf( '<li>%s</li>', esc_html($member) );
						$count++;
					if ( $count > $number ) {
						break;
					}
				}
				echo '</ul>';
			}
		}
		// display list
		?>
		<?php echo wp_kses_post($args['after_widget']); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_newest_members', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_newest_members'] ) ) {
			delete_option( 'widget_newest_members' );
		}

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete( 'widget_newest_members', 'widget' );
	}

	public function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

		<?php
	}
}

function wpt_newest_members_block ($atts) {
	ob_start();
	$number = isset($atts['number']) ? intval($atts['number']) : 5;
	$title = isset($atts['title']) ? $atts['title'] : 'Newest Members';
	$joinedslug = 'joined' . get_current_blog_id();
	$q          = 'blog_id=' . get_current_blog_id();
	$blogusers  = get_users( $q );
	foreach ( $blogusers as $user ) {
		$userdata = get_userdata( $user->ID );
		if ( ! empty( $userdata->$joinedslug ) ) {
			$index = rsvpmaker_date( 'Y-m-d', rsvpmaker_strtotime( $userdata->$joinedslug ) );
		} elseif ( ! empty( $userdata->club_member_since ) ) {
			$index = rsvpmaker_date( 'Y-m-d', rsvpmaker_strtotime( $userdata->club_member_since ) );
		} else {
			continue; // don't include if no join date
		}
		$month             = rsvpmaker_date( 'F Y', rsvpmaker_strtotime( $index ) );
		$index            .= $userdata->user_registered;
		$members[ $index ] = $userdata->first_name . ' ' . $userdata->last_name . ' (' . $month . ')';
	}

	if ( $title ) {
		echo '<h5 class="newest-members">' . $title . '</h5>';
		$count = 1;
		if ( ! empty( $members ) ) {
			krsort( $members );
			echo '<ul>';
			foreach ( $members as $index => $member ) {
					printf( '<li>%s</li>', esc_html($member) );
					$count++;
				if ( $count > $number ) {
					break;
				}
			}
			echo '</ul>';
		}
	}
	return ob_get_clean();
}


function wptoast_widgets() {
	register_widget( 'AwesomeWidget' );
	register_widget( 'WP_Widget_Members_Posts' );
	register_widget( 'WP_Widget_Club_News_Posts' );
	register_widget( 'NewestMembersWidget' );
}

function club_news( $args ) {
	ob_start();
		$show_date      = ( ! empty( $args['show_date'] ) ) ? 1 : 0;
		$show_excerpt   = ( ! empty( $args['show_excerpt'] ) ) ? 1 : 0;
		$show_thumbnail = ( ! empty( $args['show_thumbnail'] ) ) ? 1 : 0;
		$number         = ( ! empty( $args['posts_per_page'] ) ) ? $args['posts_per_page'] : 10;
		$title          = ( isset( $args['title'] ) ) ? $args['title'] : __( 'Club News', 'rsvpmaker-for-toastmasters' );
	if ( ! empty( $title ) ) {
		echo '<h2 class="club_news">' . $title . "</h2>\n";
	}
		$category = get_category_by_slug( 'members-only' );
	if ( $category ) {
		$qargs = array(
			'posts_per_page'      => $number,
			'cat'                 => '-' . $category->term_id,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);
	} else {
		$qargs = array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);
	}

		$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs ) );

	if ( $r->have_posts() ) :
		?>
		<?php
		while ( $r->have_posts() ) :
			$r->the_post();
			?>
			<h3>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</h3>
			<?php

			if ( $show_thumbnail && has_post_thumbnail() ) :
				?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( 'thumbnail' ); ?>
				</a>
					<?php
			endif;

			if ( $show_excerpt ) :
				?>
				<div class="post-excerpt"><?php the_excerpt(); ?></div>
			   <?php endif; ?>
		<?php endwhile; ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		endif;
		return ob_get_clean();
}

function toast_modify_query_exclude_category( $query ) {
	if ( ( get_post_type() == 'rsvpmaker' ) && ! is_club_member() ) {
			$query->set(
				'tax_query',
				array(
					array(
						'taxonomy' => 'rsvpmaker-type',
						'field'    => 'slug',
						'terms'    => 'members-only',
						'operator' => 'NOT IN',
					),
				)
			);
	} elseif ( ! is_admin() && $query->is_main_query() && ! is_club_member() ) {
		$category = get_category_by_slug( 'members-only' );
		if ( $category ) {
			$query->set( 'cat', '-' . $category->term_id );
		}
	}
}

function members_only( $args ) {
	ob_start();
		$show_date      = ( ! empty( $args['show_date'] ) ) ? 1 : 0;
		$show_excerpt   = ( ! empty( $args['show_excerpt'] ) ) ? 1 : 0;
		$show_thumbnail = ( ! empty( $args['show_thumbnail'] ) ) ? 1 : 0;
		$number         = ( ! empty( $args['posts_per_page'] ) ) ? $args['posts_per_page'] : 10;
		$title          = ( isset( $args['title'] ) ) ? $args['title'] : 'Members Only';
	if ( ! empty( $title ) ) {
		echo '<h2 class="club_news">' . $title . "</h2>\n";
	}
		$qargs = array(
			'posts_per_page'      => $number,
			'category_name'       => 'members-only',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);

		$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs ) );

		if ( $r->have_posts() ) :
			?>
			<?php
			while ( $r->have_posts() ) :
				$r->the_post();
				?>
			<h3>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</h3>
				<?php

				if ( $show_thumbnail && has_post_thumbnail() ) :
					?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( 'thumbnail' ); ?>
				</a>
					<?php
			endif;

				if ( $show_excerpt ) :
					?>
				<div class="post-excerpt"><?php the_excerpt(); ?></div>
			   <?php endif; ?>
		<?php endwhile; ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		endif;
		return ob_get_clean();
}

function toast_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">[' . __( 'Read More', 'your-text-domain' ) . ']</a>';
}
function toastmasters_sidebar_mce_css( $mce_css ) {
	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$mce_css .= plugins_url( '/rsvpmaker-for-toastmasters/sidebar.css' );

	return $mce_css;
}


function agenda_sidebar_editor( $post_id ) {

	ob_start();
	?>
<h2><?php _e( 'Sidebar Content', 'rsvpmaker-for-toastmasters' ); ?></h2>
<div style="width: 500px;">
<p><?php _e( 'Use this space for dues reminders, previews of upcoming events and other supporting information.', 'rsvpmaker-for-toastmasters' ); ?></p>
	<?php

	$custom   = get_post_meta( $post_id, '_tm_sidebar', true );
	$template = (int) get_post_meta( $post_id, '_meet_recur', true );
	$sked     = ( $template ) ? false : get_template_sked( $post_id );

	if ( empty( $custom ) && $template ) {
		$sidebar          = get_post_meta( $template, '_tm_sidebar', true );
		$sidebar_officers = get_post_meta( $template, '_sidebar_officers', true );
	} else {
		$sidebar          = $custom;
		$sidebar_officers = get_post_meta( $post_id, '_sidebar_officers', true );
	}

	if ( empty( $custom ) && $template ) {
		$sidebar          = get_post_meta( $template, '_tm_sidebar', true );
		$sidebar_officers = get_post_meta( $template, '_sidebar_officers', true );
		printf( '<p>%s <input type="radio" name="template" value="0" /> %s <input type="radio" name="template" value="%d" checked="checked" /> %s</p>', __( 'Apply edit to', 'rsvpmaker-for-toastmasters' ), __( 'This event only', 'rsvpmaker-for-toastmasters' ), $template, __( 'Template (default for future events)', 'rsvpmaker-for-toastmasters' ) );
	} else {
		if ( is_array( $sked ) ) {
			printf( '<p>%s: %s</p><input type="hidden" name="template" value="%d" />', __( 'Will be applied to', 'rsvpmaker-for-toastmasters' ), __( 'Template (default for future events)', 'rsvpmaker-for-toastmasters' ), $post_id );
		} elseif ( $template ) {
			printf( '<p>%s <input type="radio" name="template" value="0" /> %s <input type="radio" name="template" value="%d" checked="checked" /> %s</p>', __( 'Apply edit to', 'rsvpmaker-for-toastmasters' ), __( 'This event only', 'rsvpmaker-for-toastmasters' ), $template, __( 'Template (default for future events)', 'rsvpmaker-for-toastmasters' ) );
		} else {
			printf( '<p>%s: %s</p>', __( 'Will be applied to', 'rsvpmaker-for-toastmasters' ), __( 'This event only', 'rsvpmaker-for-toastmasters' ) );
		}
		$sidebar          = $custom;
		$sidebar_officers = get_post_meta( $post_id, '_sidebar_officers', true );
	}

	if ( is_admin() ) {
		$editor_id = '_tm_sidebar';

		$settings = array();

		wp_editor( $sidebar, $editor_id, $settings );
	} else {
		?>
<textarea name="_tm_sidebar" rows="5" cols="80" class="mce">
		<?php
		echo wpautop( $sidebar );
		?>
		 </textarea>
		<?php
	}
	?>
</div>
<p><input type="checkbox" name="sidebar_officers" value="1" 
	<?php
	if ( $sidebar_officers ) {
		echo ' checked="checked" ';}
	?>
 > <?php _e( 'Include officer listing', 'rsvpmaker-for-toastmasters' ); ?></p>
	<?php
	return ob_get_clean();
}

// boost random password complexity
function password_hurdle( $pass ) {
	$upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$lower   = 'abcdefghijklmnopqrstuvwxyz';
	$symbols = '!@#$%^&*()';
	if ( ! preg_match( '/[!@#$%^&*()]/', $pass ) ) {
		$pass .= $symbols[ rand( 0, 9 ) ];
	}
	if ( ! preg_match( '/[0-9]/', $pass ) ) {
		$pass .= rand( 0, 9 );
	}
	if ( ! preg_match( '/[a-z]/', $pass ) ) {
		$pass .= $lower[ rand( 0, 25 ) ];
	}
	if ( ! preg_match( '/[A-Z]/', $pass ) ) {
		$pass .= $upper[ rand( 0, 25 ) ];
	}
	return $pass;
}

function show_wpt_promo( $atts = array() ) {
	$width  = ( isset( $atts['width'] ) ) ? $atts['width'] : 1030;
	$height = ( isset( $atts['height'] ) ) ? $atts['height'] : 300;
	?>
<div style="background-color: #fff; padding: 10px;"><p>Learn more about <a href="https://wp4toastmasters.com" target="_blank">WordPress for Toastmasters</a>. This open source software project was created by <a target="_blank" href="https://davidfcarr.com">David F. Carr, DTM</a>, and receives no financial or logistical support from Toastmasters International. The Toastmasters-branded themes available through Toastmost.org have been reviewed for conformance to Toastmasters branding requirements.</p>
	<p>Thanks to the volunteers, donors, and toastmost.org subscribers who lend their support.</p>
<p>The <a href="https://toastmost.org">Toastmost.org</a> club website hosting service is operated by <a href="https://carrcommunications.com">Carr Communications Inc.</a>, offering convenient low-cost access to the software. The software and related business arrangements have been reviewed by Toastmasters International for conformance to their brand guidelines.</p>
</div>
	<?php
}

add_action( 'wp_ajax_wptoast_dismissed_notice_handler', 'wptoast_ajax_notice_handler' );

/**
 * AJAX handler to store the state of dismissible notices.
 */
function wptoast_ajax_notice_handler() {
	$cleared = get_option( 'cleared_rsvptoast_notices' );
	$cleared = is_array( $cleared ) ? $cleared : array();
	// Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)
	$cleared[] = sanitize_text_field($_REQUEST['type']);
	update_option( 'cleared_rsvptoast_notices', $cleared );
	//print_r( $cleared );
}

function rsvptoast_admin_notice() {
	if ( isset( $_GET['action'] ) && ( $_GET['action'] == 'edit' ) ) {
		return; // don't clutter edit page with admin notices. Gutenberg hides them anyway.
	}
	if ( isset( $_GET['post_type'] ) && ( $_GET['post_type'] == 'rsvpmaker' ) && ! isset( $_GET['page'] ) ) {
		return; // don't clutter post listing page with admin notices
	}
	if(isset($_GET['page']) && in_array($_GET['page'],array('fth_importer_docs','wp4t_setup_wizard')))
		return; 
	if(wp4t_is_district())
		return;
	global $wpdb;
	global $current_user;
	global $post;
	global $rsvp_options;

	if(isset($_GET['remove_problem']) && rsvpmaker_verify_nonce()) {
		rsvpmail_remove_problem(sanitize_text_field($_GET['remove_problem']));
	}

	$problem = rsvpmail_is_problem($current_user->user_email);
	if($problem) {
		$fix = admin_url('?remove_problem='.$current_user->user_email.'&'.rsvpmaker_nonce('query'));
		$block = strpos($problem,'block') ? 'You may need to "whitelist" email from this domain with your email provider' : '';
		echo '<div class="notice notice-info"><p>Email delivery issue, <span style="color:red;">' . $problem . ' </span> '.$block.' (<a href="'.$fix.'">Re-enable email delivery</a>)</p></div>';
	}

	/* notices NOT just for admin */
	/* upgrade renewals page */
	$renewal_page_id = get_option( 'ti_dues_renewal_page',true);
	if($renewal_page_id) {
	$renewal_page = get_post($renewal_page_id);
	if(isset($renewal_page->post_content)){
			$pattern = '/<!-- wp:rsvpmaker\/stripecharge.+Dues Renewal","showdescription":"yes","amount"[^>]+>/';
			preg_match($pattern,$renewal_page->post_content,$match);
			if(!empty($match)) {
				$update['post_content'] = preg_replace($pattern,'<!-- wp:wp4toastmasters/duesrenewal /-->',$renewal_page->post_content);
				$update['ID'] = $renewal_page_id;
				wp_update_post($update);
			}       
		}
	}

	if ( isset( $_GET['calendar_toastmost'] ) ) {
		$action = 'calendar_toastmost_' . sanitize_text_field($_GET['calendar_toastmost']);
		set_transient( $action, true );
		printf(
			'<div class="notice notice-info">
	<h1>Toastmost Calendar Sync On/Off</h1>
	<p><a href="https://calendar.toastmost.org/site-sync-on-off/?%s=%s">Confirm action: %s</a></p></div>',
			sanitize_text_field($_GET['calendar_toastmost']),
			sanitize_text_field($_SERVER['SERVER_NAME']),
			$action
		);
	}

	$pdir = str_replace( 'rsvpmaker-for-toastmasters/', '', plugin_dir_path( __FILE__ ) );

	if ( ! is_plugin_active( 'rsvpmaker/rsvpmaker.php' ) ) {
		if ( file_exists( $pdir . 'rsvpmaker/rsvpmaker.php' ) ) {
			echo '<div class="notice notice-error"><p>' . sprintf( __( 'The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker is installed but must be activated. <a href="%s#name">Activate now</a>', 'rsvpmaker-for-toastmasters' ), admin_url( 'plugins.php?s=rsvpmaker' ) ) . "</p></div>\n";
		} else {
			echo '<div class="notice notice-error"><p>' . sprintf( __( 'The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker must be installed and activated. <a href="%s">Install now</a>', 'rsvpmaker-for-toastmasters' ), admin_url( 'plugin-install.php?tab=search&s=rsvpmaker#plugin-filter' ) ) . "</p></div>\n";
		}
		return; // if this is not configured, the rest doesn't matter
	}

	$next_show_promo = (int) get_user_meta( $current_user->ID, 'next_show_promo', true );

	if ( ( time() > $next_show_promo ) || isset( $_REQUEST['show_ad'] ) ) {
		show_wpt_promo();
		$next_show_promo = strtotime( '+ 1 day' );
		update_user_meta( $current_user->ID, 'next_show_promo', $next_show_promo );
	}

	if ( isset( $_REQUEST['page'] ) && ( $_REQUEST['page'] == 'agenda_timing' ) && isset( $_REQUEST['post_id'] ) ) {
		echo '<div class="notice notice-info"><p>' . __( 'Related', 'rsvpmaker-for-toastmasters' ) . ': ';
		$template_id = get_post_meta( (int) $_REQUEST['post_id'], '_meet_recur', true );
		if ( $template_id && current_user_can( 'agenda_setup' ) ) {
			printf( '<a href="%s">%s</a> | ', admin_url( 'edit.php?post_type=rsvpmaker&page=agenda_timing&post_id=' . $template_id ), __( 'Agenda Timing: Template', 'rsvpmaker-for-toastmasters' ) );
		}

		if ( current_user_can( 'agenda_setup' ) ) {
			printf( '<a href="%s">%s</a> | ', admin_url( 'post.php?action=edit&post=' . (int) $_REQUEST['post_id'] ), __( 'Edit/Agenda Setup', 'rsvpmaker-for-toastmasters' ) );
		}

		printf( '<a href="%s" target="_blank">%s</a> | ', rsvpmaker_permalink_query( (int) $_REQUEST['post_id'], 'print_agenda=1&no_print=1' ), __( 'View Agenda', 'rsvpmaker-for-toastmasters' ) );
		printf( '<a href="%s">%s</a>', get_permalink( (int) $_REQUEST['post_id'] ), __( 'View Signup Form', 'rsvpmaker-for-toastmasters' ) );
		echo '</div>';
	}
	
	$sync_ok = get_option( 'wp4toastmasters_enable_sync' );

	if ( $sync_ok ) {
		if ( isset( $_REQUEST['page'] ) && ( ( $_REQUEST['page'] == 'my_progress_report' ) || isset( $_REQUEST['toastmaster'] ) ) ) {
			$user_id         = ( isset( $_REQUEST['toastmaster'] ) ) ? $_REQUEST['toastmaster'] : $current_user->ID;
			$toastmasters_id = get_user_meta( $user_id, 'toastmasters_id', true );
			if ( $toastmasters_id ) {
				$sync_result = wpt_json_user_id( $user_id, $toastmasters_id );
				if ( ! empty( $sync_result ) ) {
					echo '<div class="notice notice-info"><p>' . $sync_result . '</p></div>';
				}
			}
		} else {
			if ( isset( $_GET['reset_sync_count'] ) ) {
				update_option( 'last_wpt_json_batch_upload_timestamp', '' );
			}
			$sync = wpt_json_batch_upload();
			if ( $sync ) {
				echo '<div class="notice notice-info"><p>' . $sync . "</p></div>\n";
			}
		}
	}
	
	/* notices for admin only */

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_GET['reset_notices'] ) ) {
		$cleared = array();
		delete_option( 'cleared_rsvptoast_notices' );
	} else {
		$cleared = get_option( 'cleared_rsvptoast_notices' );
		$cleared = is_array( $cleared ) ? $cleared : array();
	}
	if ( isset( $_REQUEST['cleared_rsvptoast_notices'] ) && $_REQUEST['cleared_rsvptoast_notices'] ) {
		$cleared[] = sanitize_text_field($_REQUEST['cleared_rsvptoast_notices']);
		update_option( 'cleared_rsvptoast_notices', $cleared );
	}
	if ( isset( $_REQUEST['create_welcome_page'] ) && ( $_REQUEST['create_welcome_page'] == 0 ) ) {
		$cleared[] = 'front';
		update_option( 'cleared_rsvptoast_notices', $cleared );
	}
	if ( isset( $_REQUEST['meetings_nag'] ) && ( $_REQUEST['meetings_nag'] == 0 ) ) {
		$cleared[] = 'meetings_nag';
		update_option( 'cleared_rsvptoast_notices', $cleared );
	}

	if ( isset( $_POST['sked'] ) ) {
		delete_option( 'default_toastmasters_template' );
	}

	if ( ! get_option( 'page_on_front' ) && ! in_array( 'front', $cleared ) ) {

		if ( isset( $_REQUEST['create_welcome_page'] ) && $_REQUEST['create_welcome_page'] ) {
			echo '<div class="updated">';
			global $current_user;

			$welcome = '<!-- invite widget -->	
				
			<!-- wp:paragraph -->
			<p><strong>Your custom welcome message here:</strong> Delete this and replace it with what YOU want to say about your club. See the video tutorial on <a target="_blank" href="https://wp4toastmasters.com/2018/09/09/creating-and-editing-pages-and-blog-posts-with-the-new-wordpress-editor/" rel="noreferrer noopener">adding and editing content for a WordPress for Toastmasters website</a>. If you would like to change the design/layout of your website, <a href="https://www.wp4toastmasters.com/2020/11/03/new-website-design-choices-for-toastmost-org-users/" target="_blank">see these instructions</a>.</p>
			<!-- /wp:paragraph -->
						
				<!-- wp:paragraph -->
				<p>Some boilerplate content from toastmasters.org is included below to get you started, but right up at the top of the page here you should say <em>what makes your club special</em>. Don\'t be afraid to <a href="https://wp4toastmasters.com/2014/11/16/your-toastmasters-club-website-show-some-personality/" target="_blank" rel="noreferrer noopener">show some personality</a>!</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:paragraph -->
				<p><strong>Make sure to include the basics -- where and when does your club meet?</strong> Include the town/city and as much additional detail as is necessary to prevent ambiguity ("Chicago" vs. "Melbourne, Florida"). If the location is tricky to find, consider including a map or a link to an online mapping service or a photo of the entry to the building.</p>
				<!-- /wp:paragraph -->
			
				<!-- wp:paragraph -->
				<p>A group photo of smiling club members is a very common element to include at the top of the page, but also try to include photos of your members in action -- speaking, laughing, and learning. If you have video of a members giving dynamic speeches, or improvising their way through Table Topics, including one of those on the home page could be a good way of showing what Toastmasters is all about.</p>
				<!-- /wp:paragraph -->
					
				<!-- wp:separator -->
				<hr class="wp-block-separator"/>
				<!-- /wp:separator -->
				
				<!-- wp:heading {"level":3} -->
				<h3>The proven way to help you speak and lead.</h3>
				<!-- /wp:heading -->
				
				<!-- wp:image {"id":513,"align":"right","linkDestination":"custom"} -->
				<figure class="wp-block-image alignright"><a href="https://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/28_ClubMeetings.jpg"><img src="https://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/28_ClubMeetings-300x278.jpg" alt="28_ClubMeetings" class="wp-image-513"/></a></figure>
				<!-- /wp:image -->
				
				<!-- wp:paragraph -->
				<p>Congratulations - you\'re on your way to becoming a better communicator and leader! Toastmasters International, founded in 1924, is a proven product, regarded as the leading organization dedicated to communication and leadership skill development. As a member, you will gain all the tools, resources and support you need.</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:paragraph -->
				<p>Through its worldwide network of clubs, <a href="http://www.toastmasters.org" target="_blank" rel="noreferrer noopener">Toastmasters International</a> helps people communicate effectively and achieve the confidence to lead others. Why pay thousands of dollars for a seminar or class when you can join a Toastmasters club for a fraction of the cost and have fun in the process?</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:heading {"level":3} -->
				<h3>What\'s in it for you?</h3>
				<!-- /wp:heading -->
				
				<!-- wp:paragraph -->
				<p>Toastmasters is a place where you develop and grow - both personally and professionally. You join a community of learners, and in Toastmasters meetings we learn by doing. Whether you\'re an executive or a stay-at-home parent, a college student or a retiree, you will improve yourself; building skills to express yourself in a variety of situations. You\'ll open up a world of new possibilities: giving better work presentations; leading meetings - and participating in them - more confidently; speaking more smoothly off the cuff; even handling one-on-one interactions with family, friends and colleagues more positively.</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:heading {"level":3} -->
				<h3>How does it work?</h3>
				<!-- /wp:heading -->
				
				<!-- wp:image {"id":514,"align":"right","linkDestination":"custom"} -->
				<figure class="wp-block-image alignright"><a href="https://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/02_Evaluations_LR.jpg"><img src="https://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/02_Evaluations_LR-200x300.jpg" alt="02_Evaluations_LR" class="wp-image-514"/></a></figure>
				<!-- /wp:image -->
				
				<!-- wp:paragraph -->
				<p>The environment in a Toastmasters club is friendly and supportive. Everyone at a Toastmasters meeting feels welcome and valued - from complete beginners to advanced speakers. In a club meeting, you practice giving prepared speeches as well as brief impromptu presentations, known as Table Topics. There is no rush and no pressure: The Toastmasters program allows you to progress at your own pace.</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:paragraph -->
				<p>Constructive evaluation is central to the Toastmasters philosophy. Each time you give a prepared speech, an evaluator will point out strengths as well as suggest improvements. Receiving - and giving - such feedback is a great learning experience. In Toastmasters, encouragement and improvement go hand-in-hand.</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:heading {"level":3} -->
				<h3>Good leaders are good communicators</h3>
				<!-- /wp:heading -->
				
				<!-- wp:paragraph -->
				<p>Anyone who is a strong leader has to first be an effective communicator. In Toastmasters you will hone your speaking skills, and you will develop leadership abilities - through evaluations, listening, mentoring, serving as club officers and filling roles in club meetings. You will take those leadership skills out into the world, running businesses, mentoring youths, organizing fund-raisers, coaching teams and heading up families.</p>
				<!-- /wp:paragraph -->';
			$post    = array(
				'post_content' => $welcome,
				'post_name'    => 'welcome',
				'post_title'   => 'Welcome',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => $current_user->ID,
				'ping_status'  => 'closed',
			);
			$home_id = wp_insert_post( $post );

			$post    = array(
				'post_content' => '',
				'post_name'    => 'blog',
				'post_title'   => __( 'Blog', 'rsvpmaker-for-toastmasters' ),
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => $current_user->ID,
				'ping_status'  => 'closed',
			);
			$blog_id = wp_insert_post( $post );
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home_id );
			update_option( 'page_for_posts', $blog_id );
			printf( '<p><a href="%s">' . __( 'Edit welcome page', 'rsvpmaker-for-toastmasters' ) . '</a></p>', admin_url( 'post.php?action=edit&post=' ) . $home_id );
			echo '</div>';
		}

		if ( isset( $_REQUEST['create_welcome_page'] ) ) { // even if set to 0, clear the reminder
			$cleared[] = 'front';
			update_option( 'cleared_rsvptoast_notices', $cleared );
		} else {
			ob_start();
			?>
	<p>Do you want to create a welcome page as the front page (rather than having a blog listing as the front page)?</p>
	<form action="<?php echo admin_url( 'edit.php?post_type=page' ); ?>" method="get">
	<p><input type="radio" name="create_welcome_page" value="1" checked="checked">Yes - create welcome page based on default content. Show blog listing on a separate page.</p>
	<p><input type="radio" name="create_welcome_page" value="0">No, I prefer the blog listing as front page.</p>
	<p><input type="checkbox" name="addpages" value="1" checked="checked" /> Add pages for calendar, member directory, Toastmasters International info; set up menu.</p>
	<button><?php _e( 'Submit', 'rsvpmaker-for-toastmasters' ); ?></button>
	<?php rsvpmaker_nonce(); ?>
	</form>
			<?php
				$message = ob_get_clean();
				$notice[] = rsvptoast_admin_notice_format( $message, 'front', $cleared, 'info' );
		}
	} // end page on front routine

	if ( isset( $_REQUEST['addpages'] ) ) {
		rsvptoast_pages( $current_user->ID );
		if ( ! in_array( 'front', $cleared ) ) {
			$cleared[] = 'front';
			update_option( 'cleared_rsvptoast_notices', $cleared );
		}
	}

	if ( ! in_array( 'settings', $cleared ) ) {

		if ( ! isset( $missing ) ) {
			$missing = '';
		}

		if ( get_option( 'wp4toast_reminder' ) && ! get_option( 'wp4toast_reminders_cron' ) ) {
			$missing .= '<li>' . __( 'Meeting role reminders need to be reset.', 'rsvpmaker-for-toastmasters' ) . '</li>';
		}

		if ( ! get_option( 'wp4toastmasters_officer_ids' ) ) {
			$missing .= '<li>' . __( 'You have not yet set the officers list for your club.', 'rsvpmaker-for-toastmasters' ) . '</li>';
		}

		$public = get_option( 'blog_public' );

		if ( ! $public ) {
			$missing .= '<li>' . __( 'This site is not being indexed by search engines.', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . admin_url( 'options-general.php?page=wp4toastmasters_settings' ) . '">' . __( 'Make the site public?', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
		}

		$email = get_option( 'wp4toastmasters_disable_email' );
		if ( $email ) {
			$missing .= '<li>' . __('Toastmasters-specific functions for sending email (such as sending a welcome message and password to a new member) are currently disabled.', 'rsvpmaker-for-toastmasters' );
			$missing .= ' <a href="' . admin_url( 'options-general.php?page=wp4toastmasters_settings' ) . '">' . __( 'Enable email?', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
		}

		$tz = get_option( 'timezone_string' );
		if ( empty( $tz ) ) {
			$missing .= '<li>' . __( 'Make sure to set the correct timezone for your site so scheduling functions will work properly.', 'rsvpmaker-for-toastmasters' ) . '</li>';
		}

		if ( ! empty( $missing ) && ! ( isset( $_GET['page'] ) && ( $_GET['page'] == 'wp4toastmasters_settings' ) ) ) {
			$message = sprintf( __( 'Visit the <a href="%s">Toastmasters Settings</a> screen', 'rsvpmaker-for-toastmasters' ) . '<p><ul>' . $missing . '</ul>', admin_url( 'options-general.php?page=wp4toastmasters_settings' ) );
			$notice[] = rsvptoast_admin_notice_format( $message, 'visit_settings', $cleared, 'info' );
		}
	}

	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
	if ( sizeof( $blogusers ) == 1 ) {
		$message = sprintf( __( '<a href="%s">Add club members</a> as website users. You can import your whole roster, using the spreadsheet from toastmasters.org\'s Club Central. Or selectively add a few members to help you with testing.', 'rsvpmaker-for-toastmasters' ), admin_url( 'users.php?page=add_awesome_member' ) );
		$notice[] = rsvptoast_admin_notice_format( $message, 'users', $cleared, 'info' );
	}

	if ( ! in_array( 'simple-local-avatars', $cleared ) && ! is_plugin_active( 'simple-local-avatars/simple-local-avatars.php' ) && ! is_plugin_active( 'simple-local-avatars/simple-local-avatars.php' ) ) {
		if ( file_exists( $pdir . 'simple-local-avatars/simple-local-avatars.php' ) ) {
			$message = sprintf( __( 'The Simple Local Avatars plugin is recommended for allowing members to add a profile picture. WP User Avatar is installed but must be activated. <a href="%s#name">Activate now</a> or <a href="%s">No thanks</a>', 'rsvpmaker-for-toastmasters' ), admin_url( 'plugins.php?s=simple-local-avatars' ), admin_url( 'options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=simple-local-avatars' ) );
			$notice[] = rsvptoast_admin_notice_format( $message, 'simple-local-avatars', $cleared, 'info' );
		} else {
			$message = sprintf( __( 'The Simple Local Avatars plugin is recommended for allowing members to add a profile picture. <a href="%s">Install now</a> or <a href="%s">No thanks</a>', 'rsvpmaker-for-toastmasters' ), admin_url( 'plugin-install.php?tab=search&s=simple-local-avatars#plugin-filter' ), admin_url( 'options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=simple-local-avatars' ) );
			$notice[] = rsvptoast_admin_notice_format( $message, 'simple-local-avatars', $cleared, 'info' );
		}
	}

	if ( ! in_array( 'meetings_nag', $cleared ) && ! strpos( $_SERVER['REQUEST_URI'], 'rsvpmaker_template_list' ) && ! strpos( $_SERVER['REQUEST_URI'], 'agenda_setup' ) ) {
		global $wpdb;
		$future   = future_toastmaster_meetings();
		$upcoming = sizeof( $future );
		if ( $upcoming == 0 ) {
			$message = sprintf( __( 'No meetings currently published. Add based on template (standard schedule and roles):</p><ul>%s</ul>', 'rsvpmaker-for-toastmasters' ), get_toast_templates() );
			$notice[] = rsvptoast_admin_notice_format( $message, 'meetings_nag', $cleared, 'info' );
		} elseif ( $upcoming < 5 ) {
			$message = sprintf( $upcoming . ' ' . __( 'meetings currently published. Add more based on template (standard schedule and roles):</p><ul>%s</ul>', 'rsvpmaker-for-toastmasters' ) . 'or <a href="%s">clear reminder</a>', get_toast_templates(), admin_url( 'options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=meetings_nag' ) );
			$notice[] = rsvptoast_admin_notice_format( $message, 'meetings_nag', $cleared, 'info' );
		}
	}

	if ( $sync_ok == '' ) {
		$message = sprintf( __( 'You can choose to allow the member data on the Progress Reports screen to sync with other websites that use this software. See <a target="_blank" href="https://wp4toastmasters.com/2017/05/13/sync-member-progress-report-data/">blog post</a>.</p><p>Choose whether this should be on our off: <a href="%s">Toastmasters Settings.</a>', 'rsvpmaker-for-toastmasters' ), admin_url( 'options-general.php?page=wp4toastmasters_settings' ) );
		$notice[] = rsvptoast_admin_notice_format( $message, 'sync_ok', $cleared, 'info' );
	}

	if(!empty($notice))
	{
		if(isset($_GET['show_rsvpmaker_notices'])) {
			echo implode("\n",$notice);
		}
		else {
			$size = sizeof($notice);
			$message = __('Toastmasters setup notices for administrator','rsvpmaker').': '.$size;
			$message .= sprintf(' - <a href="%s">%s</a>',admin_url('?show_rsvpmaker_notices=1'),__('Display','rsvpmaker'));
			echo rsvptoast_admin_notice_format($message, 'RSVPMaker', $cleared, $type='info');	
		}
	}

}

function rsvptoast_admin_notice_format( $message, $slug='', $cleared = array(), $type = 'info' ) {
	if ( is_array($cleared) && in_array( $slug, $cleared ) ) {
		return; // $slug.' cleared';
	}
	if ( empty( $slug ) ) {
		return '<div>No message slug set</div>';
	}
	if ( empty( $message ) ) {
		return '<div>empty message:'.$slug.'</div>';
	}
	return sprintf(
		'<div class="notice notice-%s wptoast-notice is-dismissible" data-notice="%s">
<p>%s</p>
</div>',
		$type,
		$slug,
		$message
	);
}

function get_toast_templates() {

	global $post;
	$post_backup = $post;
	global $wp_query;

	add_filter( 'posts_fields', 'rsvpmaker_template_fields' );

	add_filter( 'posts_join', 'rsvpmaker_template_join' );

	add_filter( 'posts_where', 'rsvpmaker_template_where' );

	add_filter( 'posts_orderby', 'rsvpmaker_template_orderby' );

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	$querystring = "post_type=rsvpmaker&post_status=publish&paged=$paged&posts_per_page=50";

	$backup = $wp_query;

	$wp_query            = new WP_Query( $querystring );
	$templates_projected = '';
	while ( have_posts() ) {
		the_post();

		$template_recur_url = admin_url( 'edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=' . $post->ID );

		$templates_projected .= sprintf( '<li><a href="%s#template_ck">%s</a></li>', $template_recur_url, $post->post_title );

	}

	remove_filter( 'posts_fields', 'rsvpmaker_template_fields' );

	remove_filter( 'posts_join', 'rsvpmaker_template_join' );

	remove_filter( 'posts_where', 'rsvpmaker_template_where' );

	remove_filter( 'posts_orderby', 'rsvpmaker_template_orderby' );

	$wp_query = $backup;
	$post     = $post_backup;

	wp_reset_postdata();

	return $templates_projected;

}

// make lectern default to Toastmasters branding
function wp4t_header( $default ) {
	return 'https://toastmost.org/tmbranding/toastmasters3.jpg';
}

function rsvptoast_pages( $user_id ) {
	$pages = get_pages();
	foreach ( $pages as $page ) {
		$titles[] = $page->page_title;
	}
	$post = array(
		'post_content' => '<!-- wp:shortcode -->
		[awesome_members comment="This placeholder code displays the member listing"]
		<!-- /wp:shortcode -->',
		'post_name'    => 'members',
		'post_title'   => 'Members',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_author'  => $user_id,
		'ping_status'  => 'closed',
	);
	if ( ! in_array( 'Members', $titles ) ) {
		$members = wp_insert_post( $post );
	}
	$post = array(
		'post_content' => '<!-- wp:rsvpmaker/upcoming {"calendar":"1","hideauthor":"true"} /-->',
		'post_name'    => 'calendar',
		'post_title'   => 'Calendar',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_author'  => $user_id,
		'ping_status'  => 'closed',
	);
	if ( ! in_array( 'Calendar', $titles ) ) {
		$calendar = wp_insert_post( $post );
	}

	$post = array(
		'post_content' => '<!-- wp:rsvpmaker/contact /-->',
		'post_name'    => 'contact-us',
		'post_title'   => 'Contact Us',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_author'  => $user_id,
		'ping_status'  => 'closed',
	);
	if ( ! in_array( 'Contact Us', $titles ) ) {
		$contact = wp_insert_post( $post );
	}

	$name    = 'Primary Menu';
	$menu_id = wp_create_nav_menu( $name );
	$menu    = get_term_by( 'name', $name, 'nav_menu' );
	$blog_id = get_option( 'page_for_posts' );
	$home_id = get_option( 'page_on_front' );

	if ( $home_id ) {
		$args = array(
			'menu-item-object-id' => $home_id,
			'menu-item-title'     => __( 'Welcome' ),
			'menu-item-classes'   => 'welcome',
			'menu-item-object'    => 'page',
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		);
	} else {
		$args = array(
			'menu-item-title'   => __( 'Welcome' ),
			'menu-item-classes' => 'welcome',
			'menu-item-url'     => '/',
			'menu-item-status'  => 'publish',
		);
	}
	wp_update_nav_menu_item( $menu->term_id, 0, $args );

	if ( $blog_id ) {
		wp_update_nav_menu_item(
			$menu->term_id,
			0,
			array(
				'menu-item-object-id' => $blog_id,
				'menu-item-title'     => __( 'Blog' ),
				'menu-item-classes'   => 'blog',
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	wp_update_nav_menu_item(
		$menu->term_id,
		0,
		array(
			'menu-item-object-id' => $calendar,
			'menu-item-title'     => __( 'Calendar' ),
			'menu-item-classes'   => 'calendar',
			'menu-item-object'    => 'page',
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		)
	);
	wp_update_nav_menu_item(
		$menu->term_id,
		0,
		array(
			'menu-item-object-id' => $members,
			'menu-item-title'     => __( 'Members' ),
			'menu-item-classes'   => 'members',
			'menu-item-object'    => 'page',
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		)
	);
	wp_update_nav_menu_item(
		$menu->term_id,
		0,
		array(
			'menu-item-object-id' => $contact,
			'menu-item-title'     => __( 'Contact Us' ),
			'menu-item-classes'   => 'contact-us',
			'menu-item-object'    => 'page',
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		)
	);
	wp_update_nav_menu_item(
		$menu->term_id,
		0,
		array(
			'menu-item-title'   => __( 'Login' ),
			'menu-item-classes' => 'tm',
			'menu-item-url'     => '#tmlogin',
			'menu-item-status'  => 'publish',
		)
	);

	// you add as many items as you need with wp_update_nav_menu_item()

	// then you set the wanted theme  location
	$locations                 = get_theme_mod( 'nav_menu_locations' );
	$locations['primary-menu'] = $menu->term_id;
	$locations['primary']      = $menu->term_id;
	$locations['menu-1']       = $menu->term_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

function get_manuals_by_type_options( $type ) {
	$types   = get_manuals_by_type();
	$manuals = $types[ $type ];
	$o       = '';
	foreach ( $manuals as $manual => $label ) {
		$o .= sprintf( '<option value="%s">%s</option>', $manual, $label );
	}
	return $o;
}

function get_manuals_by_type() {

	$arr = array(
		'Path Not Set'            => array( 'Path Not Set Level 1 Mastering Fundamentals' => __( 'Path Not Set Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ) ),
		'Dynamic Leadership'      => array(
			'Dynamic Leadership Level 1 Mastering Fundamentals' => __( 'Dynamic Leadership Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Dynamic Leadership Level 2 Learning Your Style' => __( 'Dynamic Leadership Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Dynamic Leadership Level 3 Increasing Knowledge' => __( 'Dynamic Leadership Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Dynamic Leadership Level 4 Building Skills' => __( 'Dynamic Leadership Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Dynamic Leadership Level 5 Demonstrating Expertise' => __( 'Dynamic Leadership Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Effective Coaching'      => array(
			'Effective Coaching Level 1 Mastering Fundamentals' => __( 'Effective Coaching Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Effective Coaching Level 2 Learning Your Style' => __( 'Effective Coaching Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Effective Coaching Level 3 Increasing Knowledge' => __( 'Effective Coaching Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Effective Coaching Level 4 Building Skills' => __( 'Effective Coaching Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Effective Coaching Level 5 Demonstrating Expertise' => __( 'Effective Coaching Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Engaging Humor'          => array(
			'Engaging Humor Level 1 Mastering Fundamentals' => __( 'Engaging Humor Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Engaging Humor Level 2 Learning Your Style'  => __( 'Engaging Humor Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Engaging Humor Level 3 Increasing Knowledge' => __( 'Engaging Humor Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Engaging Humor Level 4 Building Skills'      => __( 'Engaging Humor Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Engaging Humor Level 5 Demonstrating Expertise' => __( 'Engaging Humor Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Innovative Planning'     => array(
			'Innovative Planning Level 1 Mastering Fundamentals' => __( 'Innovative Planning Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Innovative Planning Level 2 Learning Your Style' => __( 'Innovative Planning Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Innovative Planning Level 3 Increasing Knowledge' => __( 'Innovative Planning Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Innovative Planning Level 4 Building Skills' => __( 'Innovative Planning Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Innovative Planning Level 5 Demonstrating Expertise' => __( 'Innovative Planning Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Leadership Development'  => array(
			'Leadership Development Level 1 Mastering Fundamentals' => __( 'Leadership Development Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Leadership Development Level 2 Learning Your Style'  => __( 'Leadership Development Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Leadership Development Level 3 Increasing Knowledge' => __( 'Leadership Development Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Leadership Development Level 4 Building Skills'      => __( 'Leadership Development Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Leadership Development Level 5 Demonstrating Expertise' => __( 'Leadership Development Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Motivational Strategies' => array(
			'Motivational Strategies Level 1 Mastering Fundamentals' => __( 'Motivational Strategies Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Motivational Strategies Level 2 Learning Your Style'  => __( 'Motivational Strategies Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Motivational Strategies Level 3 Increasing Knowledge' => __( 'Motivational Strategies Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Motivational Strategies Level 4 Building Skills'      => __( 'Motivational Strategies Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Motivational Strategies Level 5 Demonstrating Expertise' => __( 'Motivational Strategies Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Persuasive Influence'    => array(
			'Persuasive Influence Level 1 Mastering Fundamentals' => __( 'Persuasive Influence Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Persuasive Influence Level 2 Learning Your Style' => __( 'Persuasive Influence Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Persuasive Influence Level 3 Increasing Knowledge' => __( 'Persuasive Influence Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Persuasive Influence Level 4 Building Skills' => __( 'Persuasive Influence Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Persuasive Influence Level 5 Demonstrating Expertise' => __( 'Persuasive Influence Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Presentation Mastery'    => array('Presentation Mastery Level 1 Mastering Fundamentals' => __( 'Presentation Mastery Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Presentation Mastery Level 2 Learning Your Style' => __( 'Presentation Mastery Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Presentation Mastery Level 3 Increasing Knowledge' => __( 'Presentation Mastery Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Presentation Mastery Level 4 Building Skills' => __( 'Presentation Mastery Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Presentation Mastery Level 5 Demonstrating Expertise' => __( 'Presentation Mastery Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Strategic Relationships' => array(
			'Strategic Relationships Level 1 Mastering Fundamentals' => __( 'Strategic Relationships Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Strategic Relationships Level 2 Learning Your Style'  => __( 'Strategic Relationships Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Strategic Relationships Level 3 Increasing Knowledge' => __( 'Strategic Relationships Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Strategic Relationships Level 4 Building Skills'      => __( 'Strategic Relationships Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Strategic Relationships Level 5 Demonstrating Expertise' => __( 'Strategic Relationships Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Team Collaboration'      => array(
			'Team Collaboration Level 1 Mastering Fundamentals' => __( 'Team Collaboration Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Team Collaboration Level 2 Learning Your Style' => __( 'Team Collaboration Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Team Collaboration Level 3 Increasing Knowledge' => __( 'Team Collaboration Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Team Collaboration Level 4 Building Skills' => __( 'Team Collaboration Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Team Collaboration Level 5 Demonstrating Expertise' => __( 'Team Collaboration Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Visionary Communication' => array(
			'Visionary Communication Level 1 Mastering Fundamentals' => __( 'Visionary Communication Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
			'Visionary Communication Level 2 Learning Your Style'  => __( 'Visionary Communication Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
			'Visionary Communication Level 3 Increasing Knowledge' => __( 'Visionary Communication Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
			'Visionary Communication Level 4 Building Skills'      => __( 'Visionary Communication Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
			'Visionary Communication Level 5 Demonstrating Expertise' => __( 'Visionary Communication Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		),
		'Pathways 360'            => array( 'Pathways 360 Level 5 Demonstrating Expertise' => __( 'Pathways 360 Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ) ),
		'Pathways Mentor Program' => array( 'Pathways Mentor Program Level 1 Educational Program' => __( 'Pathways Mentor Program Level 1 Educational Program', 'rsvpmaker-for-toastmasters' ) ),
		'Other'                   => array( 'Other Manual or Non Manual Speech' => __( 'Other Manual or Non Manual Speech', 'rsvpmaker-for-toastmasters' ) ),
	);

	$legacy = get_option( 'show_legacy_manuals' );

	if ( $legacy == 'yes' ) {
		$arr['Manual'] = array(
			'COMPETENT COMMUNICATION'      => __( 'COMPETENT COMMUNICATION', 'rsvpmaker-for-toastmasters' ),
			'ADVANCED MANUAL TBD'          => __( 'ADVANCED MANUAL TBD', 'rsvpmaker-for-toastmasters' ),
			'COMMUNICATING ON VIDEO'       => __( 'COMMUNICATING ON VIDEO', 'rsvpmaker-for-toastmasters' ),
			'FACILITATING DISCUSSION'      => __( 'FACILITATING DISCUSSION', 'rsvpmaker-for-toastmasters' ),
			'HIGH PERFORMANCE LEADERSHIP'  => 'HIGH PERFORMANCE LEADERSHIP (ALS)',
			'HUMOROUSLY SPEAKING'          => 'HUMOROUSLY SPEAKING',
			'INTERPERSONAL COMMUNICATIONS' => __( 'INTERPERSONAL COMMUNICATIONS', 'rsvpmaker-for-toastmasters' ),
			'INTERPRETIVE READING'         => __( 'INTERPRETIVE READING', 'rsvpmaker-for-toastmasters' ),
			'PERSUASIVE SPEAKING'          => __( 'PERSUASIVE SPEAKING', 'rsvpmaker-for-toastmasters' ),
			'PUBLIC RELATIONS'             => __( 'PUBLIC RELATIONS', 'rsvpmaker-for-toastmasters' ),
			'SPEAKING TO INFORM'           => __( 'SPEAKING TO INFORM', 'rsvpmaker-for-toastmasters' ),
			'SPECIAL OCCASION SPEECHES'    => __( 'SPECIAL OCCASION SPEECHES', 'rsvpmaker-for-toastmasters' ),
			'SPECIALTY SPEECHES'           => __( 'SPECIALTY SPEECHES', 'rsvpmaker-for-toastmasters' ),
			'SPEECHES BY MANAGEMENT'       => __( 'SPEECHES BY MANAGEMENT', 'rsvpmaker-for-toastmasters' ),
			'STORYTELLING'                 => __( 'STORYTELLING', 'rsvpmaker-for-toastmasters' ),
			'TECHNICAL PRESENTATIONS'      => __( 'TECHNICAL PRESENTATIONS', 'rsvpmaker-for-toastmasters' ),
			'THE DISCUSSION LEADER'        => __( 'THE DISCUSSION LEADER', 'rsvpmaker-for-toastmasters' ),
			'THE ENTERTAINING SPEAKER'     => __( 'THE ENTERTAINING SPEAKER', 'rsvpmaker-for-toastmasters' ),
			'THE PROFESSIONAL SALESPERSON' => __( 'THE PROFESSIONAL SALESPERSON', 'rsvpmaker-for-toastmasters' ),
			'THE PROFESSIONAL SPEAKER'     => __( 'THE PROFESSIONAL SPEAKER', 'rsvpmaker-for-toastmasters' ),
			'BETTER SPEAKER SERIES'        => __( 'BETTER SPEAKER SERIES', 'rsvpmaker-for-toastmasters' ),
			'SUCCESSFUL CLUB SERIES'       => __( 'SUCCESSFUL CLUB SERIES', 'rsvpmaker-for-toastmasters' ),
			'LEADERSHIP EXCELLENCE SERIES' => __( 'LEADERSHIP EXCELLENCE SERIES', 'rsvpmaker-for-toastmasters' ),
		);
	}

	return $arr;

}

function get_manuals_array() {
	return array(
		'Select Manual/Path'                               => __( 'Select Manual/Path', 'rsvpmaker-for-toastmasters' ),
		'COMPETENT COMMUNICATION'                          => __( 'COMPETENT COMMUNICATION', 'rsvpmaker-for-toastmasters' ),
		'ADVANCED MANUAL TBD'                              => __( 'ADVANCED MANUAL TBD', 'rsvpmaker-for-toastmasters' ),
		'COMMUNICATING ON VIDEO'                           => __( 'COMMUNICATING ON VIDEO', 'rsvpmaker-for-toastmasters' ),
		'FACILITATING DISCUSSION'                          => __( 'FACILITATING DISCUSSION', 'rsvpmaker-for-toastmasters' ),
		'HIGH PERFORMANCE LEADERSHIP'                      => 'HIGH PERFORMANCE LEADERSHIP (ALS)',
		'HUMOROUSLY SPEAKING'                              => 'HUMOROUSLY SPEAKING',
		'INTERPERSONAL COMMUNICATIONS'                     => __( 'INTERPERSONAL COMMUNICATIONS', 'rsvpmaker-for-toastmasters' ),
		'INTERPRETIVE READING'                             => __( 'INTERPRETIVE READING', 'rsvpmaker-for-toastmasters' ),
		'Other Manual or Non Manual Speech'                => __( 'Other Manual or Non Manual Speech', 'rsvpmaker-for-toastmasters' ),
		'PERSUASIVE SPEAKING'                              => __( 'PERSUASIVE SPEAKING', 'rsvpmaker-for-toastmasters' ),
		'PUBLIC RELATIONS'                                 => __( 'PUBLIC RELATIONS', 'rsvpmaker-for-toastmasters' ),
		'SPEAKING TO INFORM'                               => __( 'SPEAKING TO INFORM', 'rsvpmaker-for-toastmasters' ),
		'SPECIAL OCCASION SPEECHES'                        => __( 'SPECIAL OCCASION SPEECHES', 'rsvpmaker-for-toastmasters' ),
		'SPECIALTY SPEECHES'                               => __( 'SPECIALTY SPEECHES', 'rsvpmaker-for-toastmasters' ),
		'SPEECHES BY MANAGEMENT'                           => __( 'SPEECHES BY MANAGEMENT', 'rsvpmaker-for-toastmasters' ),
		'STORYTELLING'                                     => __( 'STORYTELLING', 'rsvpmaker-for-toastmasters' ),
		'TECHNICAL PRESENTATIONS'                          => __( 'TECHNICAL PRESENTATIONS', 'rsvpmaker-for-toastmasters' ),
		'THE DISCUSSION LEADER'                            => __( 'THE DISCUSSION LEADER', 'rsvpmaker-for-toastmasters' ),
		'THE ENTERTAINING SPEAKER'                         => __( 'THE ENTERTAINING SPEAKER', 'rsvpmaker-for-toastmasters' ),
		'THE PROFESSIONAL SALESPERSON'                     => __( 'THE PROFESSIONAL SALESPERSON', 'rsvpmaker-for-toastmasters' ),
		'THE PROFESSIONAL SPEAKER'                         => __( 'THE PROFESSIONAL SPEAKER', 'rsvpmaker-for-toastmasters' ),
		'BETTER SPEAKER SERIES'                            => __( 'BETTER SPEAKER SERIES', 'rsvpmaker-for-toastmasters' ),
		'SUCCESSFUL CLUB SERIES'                           => __( 'SUCCESSFUL CLUB SERIES', 'rsvpmaker-for-toastmasters' ),
		'LEADERSHIP EXCELLENCE SERIES'                     => __( 'LEADERSHIP EXCELLENCE SERIES', 'rsvpmaker-for-toastmasters' ),
		'Pathways 360 Level 5 Demonstrating Expertise'     => __( 'Pathways 360 Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Pathways Mentor Program Level 1 Educational Program' => __( 'Pathways Mentor Program Level 1 Educational Program', 'rsvpmaker-for-toastmasters' ),
		'Path Not Set Level 1 Mastering Fundamentals'      => __( 'Path Not Set Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 1 Mastering Fundamentals' => __( 'Dynamic Leadership Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 2 Learning Your Style'   => __( 'Dynamic Leadership Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 3 Increasing Knowledge'  => __( 'Dynamic Leadership Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 4 Building Skills'       => __( 'Dynamic Leadership Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 5 Demonstrating Expertise' => __( 'Dynamic Leadership Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 1 Mastering Fundamentals' => __( 'Effective Coaching Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 2 Learning Your Style'   => __( 'Effective Coaching Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 3 Increasing Knowledge'  => __( 'Effective Coaching Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 4 Building Skills'       => __( 'Effective Coaching Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 5 Demonstrating Expertise' => __( 'Effective Coaching Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 1 Mastering Fundamentals'    => __( 'Engaging Humor Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 2 Learning Your Style'       => __( 'Engaging Humor Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 3 Increasing Knowledge'      => __( 'Engaging Humor Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 4 Building Skills'           => __( 'Engaging Humor Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 5 Demonstrating Expertise'   => __( 'Engaging Humor Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 1 Mastering Fundamentals' => __( 'Innovative Planning Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 2 Learning Your Style'  => __( 'Innovative Planning Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 3 Increasing Knowledge' => __( 'Innovative Planning Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 4 Building Skills'      => __( 'Innovative Planning Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 5 Demonstrating Expertise' => __( 'Innovative Planning Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 1 Mastering Fundamentals' => __( 'Leadership Development Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 2 Learning Your Style' => __( 'Leadership Development Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 3 Increasing Knowledge' => __( 'Leadership Development Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 4 Building Skills'   => __( 'Leadership Development Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 5 Demonstrating Expertise' => __( 'Leadership Development Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 1 Mastering Fundamentals' => __( 'Motivational Strategies Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 2 Learning Your Style' => __( 'Motivational Strategies Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 3 Increasing Knowledge' => __( 'Motivational Strategies Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 4 Building Skills'  => __( 'Motivational Strategies Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 5 Demonstrating Expertise' => __( 'Motivational Strategies Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 1 Mastering Fundamentals' => __( 'Persuasive Influence Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 2 Learning Your Style' => __( 'Persuasive Influence Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 3 Increasing Knowledge' => __( 'Persuasive Influence Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 4 Building Skills'     => __( 'Persuasive Influence Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 5 Demonstrating Expertise' => __( 'Persuasive Influence Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 1 Mastering Fundamentals' => __( 'Presentation Mastery Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 2 Learning Your Style' => __( 'Presentation Mastery Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 3 Increasing Knowledge' => __( 'Presentation Mastery Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 4 Building Skills'     => __( 'Presentation Mastery Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 5 Demonstrating Expertise' => __( 'Presentation Mastery Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 1 Mastering Fundamentals' => __( 'Strategic Relationships Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 2 Learning Your Style' => __( 'Strategic Relationships Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 3 Increasing Knowledge' => __( 'Strategic Relationships Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 4 Building Skills'  => __( 'Strategic Relationships Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 5 Demonstrating Expertise' => __( 'Strategic Relationships Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 1 Mastering Fundamentals' => __( 'Team Collaboration Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 2 Learning Your Style'   => __( 'Team Collaboration Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 3 Increasing Knowledge'  => __( 'Team Collaboration Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 4 Building Skills'       => __( 'Team Collaboration Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 5 Demonstrating Expertise' => __( 'Team Collaboration Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 1 Mastering Fundamentals' => __( 'Visionary Communication Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 2 Learning Your Style' => __( 'Visionary Communication Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 3 Increasing Knowledge' => __( 'Visionary Communication Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 4 Building Skills'  => __( 'Visionary Communication Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 5 Demonstrating Expertise' => __( 'Visionary Communication Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
	);
}

function get_pathways() {
	return array(
		'Dynamic Leadership Level 1 Mastering Fundamentals' => __( 'Dynamic Leadership Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 2 Learning Your Style'   => __( 'Dynamic Leadership Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 3 Increasing Knowledge'  => __( 'Dynamic Leadership Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 4 Building Skills'       => __( 'Dynamic Leadership Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Dynamic Leadership Level 5 Demonstrating Expertise' => __( 'Dynamic Leadership Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 1 Mastering Fundamentals' => __( 'Effective Coaching Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 2 Learning Your Style'   => __( 'Effective Coaching Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 3 Increasing Knowledge'  => __( 'Effective Coaching Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 4 Building Skills'       => __( 'Effective Coaching Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Effective Coaching Level 5 Demonstrating Expertise' => __( 'Effective Coaching Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 1 Mastering Fundamentals'    => __( 'Engaging Humor Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 2 Learning Your Style'       => __( 'Engaging Humor Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 3 Increasing Knowledge'      => __( 'Engaging Humor Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 4 Building Skills'           => __( 'Engaging Humor Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Engaging Humor Level 5 Demonstrating Expertise'   => __( 'Engaging Humor Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 1 Mastering Fundamentals' => __( 'Innovative Planning Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 2 Learning Your Style'  => __( 'Innovative Planning Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 3 Increasing Knowledge' => __( 'Innovative Planning Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 4 Building Skills'      => __( 'Innovative Planning Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Innovative Planning Level 5 Demonstrating Expertise' => __( 'Innovative Planning Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 1 Mastering Fundamentals' => __( 'Leadership Development Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 2 Learning Your Style' => __( 'Leadership Development Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 3 Increasing Knowledge' => __( 'Leadership Development Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 4 Building Skills'   => __( 'Leadership Development Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Leadership Development Level 5 Demonstrating Expertise' => __( 'Leadership Development Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 1 Mastering Fundamentals' => __( 'Motivational Strategies Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 2 Learning Your Style' => __( 'Motivational Strategies Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 3 Increasing Knowledge' => __( 'Motivational Strategies Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 4 Building Skills'  => __( 'Motivational Strategies Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Motivational Strategies Level 5 Demonstrating Expertise' => __( 'Motivational Strategies Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 1 Mastering Fundamentals' => __( 'Persuasive Influence Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 2 Learning Your Style' => __( 'Persuasive Influence Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 3 Increasing Knowledge' => __( 'Persuasive Influence Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 4 Building Skills'     => __( 'Persuasive Influence Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Persuasive Influence Level 5 Demonstrating Expertise' => __( 'Persuasive Influence Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 1 Mastering Fundamentals' => __( 'Presentation Mastery Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 2 Learning Your Style' => __( 'Presentation Mastery Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 3 Increasing Knowledge' => __( 'Presentation Mastery Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 4 Building Skills'     => __( 'Presentation Mastery Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Presentation Mastery Level 5 Demonstrating Expertise' => __( 'Presentation Mastery Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 1 Mastering Fundamentals' => __( 'Strategic Relationships Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 2 Learning Your Style' => __( 'Strategic Relationships Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 3 Increasing Knowledge' => __( 'Strategic Relationships Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 4 Building Skills'  => __( 'Strategic Relationships Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Strategic Relationships Level 5 Demonstrating Expertise' => __( 'Strategic Relationships Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 1 Mastering Fundamentals' => __( 'Team Collaboration Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 2 Learning Your Style'   => __( 'Team Collaboration Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 3 Increasing Knowledge'  => __( 'Team Collaboration Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 4 Building Skills'       => __( 'Team Collaboration Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Team Collaboration Level 5 Demonstrating Expertise' => __( 'Team Collaboration Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 1 Mastering Fundamentals' => __( 'Visionary Communication Level 1 Mastering Fundamentals', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 2 Learning Your Style' => __( 'Visionary Communication Level 2 Learning Your Style', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 3 Increasing Knowledge' => __( 'Visionary Communication Level 3 Increasing Knowledge', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 4 Building Skills'  => __( 'Visionary Communication Level 4 Building Skills', 'rsvpmaker-for-toastmasters' ),
		'Visionary Communication Level 5 Demonstrating Expertise' => __( 'Visionary Communication Level 5 Demonstrating Expertise', 'rsvpmaker-for-toastmasters' ),
	);
}

function get_manuals_options( $manual = '' ) {
	$manuals = get_manuals_array();
	$out     = '';
	foreach ( $manuals as $manual_index => $manual_text ) {
		$s    = ( $manual == $manual_index ) ? ' selected="selected" ' : '';
		$out .= sprintf( '<option value="%s" %s>%s</option>', $manual_index, $s, $manual_text );
	}
	return $out;
}

function get_project_text( $slug ) {
	$project = get_projects_array();
	if ( isset( $project[ $slug ] ) ) {
		return $project[ $slug ];
	}
	return;
}

function get_project_key( $project ) {
	$projects = get_projects_array();
	return array_search( $project, $projects );
}

function get_projects_array( $choice = 'projects' ) {
	include 'projects_array.php';

	if ( $choice == 'projects' ) {
		return $projects;
	} elseif ( $choice == 'options' ) {
		return $project_options;
	} elseif ( $choice == 'display_times' ) {
		return $display_times;
	} else {
		return $project_times;
	}
}

function timeplanner_option( $count ) {
	$count   = (int) $count;
	$options = '';
	if ( $count == 0 ) {
		$options .= '<option value="0">Not Set</option><option value="delete">Delete</option>';
	} else {
		$options .= sprintf( '<option value="%s">%s</option><option value="delete">Delete</option><option value="0">Not Set</option>', $count, $count );
	}

	for ( $i = 1; $i < 61; $i++ ) {
		$options .= sprintf( '<option value="%s">%s</option>', $i, $i );
	}
	return $options;
}

function timeplanner( $atts, $content ) {

	global $time_counter;
	global $newoutput;
	global $timeplanner_total;
	global $post;
	if ( isset( $atts['themewords'] ) ) {
		if ( ! empty( $newoutput ) ) {
			$newoutput .= '[toastmaster themewords="1" ]' . "\n\n";
		}
		return;
	}
	if ( empty( $atts['time_allowed'] ) ) {
		 $atts['time_allowed'] = 0;
	}
	if ( empty( $atts['padding_time'] ) ) {
		 $atts['padding_time'] = 0;
	}

	$txt                = $output = '';
	$padding_time_block = sprintf( '<input type="hidden" class="time_count" id="padding_time%d" value="0" />', $time_counter ); // default except for speaker

	if ( isset( $atts['role'] ) ) {
		$c     = '';
		$role  = $atts['role'];
		$count = 1;
		if ( isset( $atts['count'] ) ) {
				$count = (int) $atts['count'];
			if ( $count > 1 ) {
				$c = '(' . $count . ')';
			}
		}
		$txt     = sprintf( 'Role: %s %s', $atts['role'], $c );
		$signups = get_role_signups( $post->ID, $role, $count );
		if ( ! empty( $signups ) ) {
			$txt .= ' ' . $signups;
		}
		if ( strpos( $atts['role'], 'peaker' ) && ! strpos( $atts['role'], 'ackup' ) ) {
			global $max_speakers;
			$max_speakers       = $count;
			$txt               .= sprintf( '<p>Time Allowed should be at least %d minutes (%d speeches, 7-minutes each) or more to allow for longer speeches. The signup form will show a warning if members sign up for speeches that exceed the limit. Use <strong>Extra Time</strong> to pad the agenda for introductions and presentation setup.</p>', ( $count * 7 ), $count );
			$padding_time_block = sprintf( '<br /><strong>Extra Time</strong><br /><select class="time_count" name="padding_time[%d]" id="padding_time%d">%s</select>', $time_counter, $time_counter, timeplanner_option( $atts['padding_time'] ) );
				$speak_count    = 0;
			for ( $i = 1; $i <= $count; $i++ ) {
				if ( get_post_meta( $post->ID, '_role_Speaker_' . $i, true ) ) { // if speaker assigned
					$speak_count += (int) get_post_meta( $post->ID, '_maxtime_role_Speaker_' . $i, true );
				}
			}
			if ( $speak_count ) {
				$time_allowed = (int) $atts['time_allowed'];
				if ( $speak_count > $time_allowed ) {
					$s    = ' style="color:red;" ';
					$txt .= sprintf( '<input type="hidden" id="speaker_time_count" value="%s" />', $speak_count - $time_allowed );
				} else {
					$s = '';
				}
				$txt .= sprintf( '<p><strong %s>Speakers have reserved: %s minutes</strong></p>', $s, $speak_count );
			}
		}
	}
	if ( ! empty( $content ) ) {
		$txt .= ' ' . $content;
	}
	if ( ! empty( $atts['editable'] ) ) {
		$txt .= ' Editable: ' . $atts['editable'];
	}

	$output = sprintf( '<tr class="timerow" timecount="%d"><td id="time%s"></td><td class="time_allowed_cell"><select class="time_count" name="time_allowed[%d]" id="time_allowed%d">%s</select>%s</td><td class="text_cell">%s</td></tr>', $time_counter, $time_counter, $time_counter, $time_counter, timeplanner_option( $atts['time_allowed'] ), $padding_time_block, $txt );

	return $output;
}

function admin_link_menu() {
	global $post;
	$permalink   = get_permalink( $post->ID ) . '?';
	$security    = get_tm_security();
	$template_id = get_post_meta( $post->ID, '_meet_recur', true );

	$link = '<div id="cssmenu"><ul>';
	if ( current_user_can( $security['agenda_setup'] ) ) {
		$agenda_menu[ __( 'Agenda Setup', 'rsvpmaker-for-toastmasters' ) ] = admin_url( 'post.php?action=edit&post=' . $post->ID );
		if ( $template_id ) {
			$agenda_menu[ __( 'Agenda Setup: Template', 'rsvpmaker-for-toastmasters' ) ] = admin_url( 'post.php?action=edit&post=' . $template_id );
		}
		if ( ! function_exists( 'do_blocks' ) ) {
			$agenda_menu[ __( 'Agenda Timing', 'rsvpmaker-for-toastmasters' ) ] = admin_url( 'edit.php?post_type=rsvpmaker&page=agenda_timing&post_id=' . $post->ID );
			if ( $template_id ) {
				$agenda_menu[ __( 'Agenda Timing: Template', 'rsvpmaker-for-toastmasters' ) ] = admin_url( 'edit.php?post_type=rsvpmaker&page=agenda_timing&post_id=' . $template_id );
			}
		}

		$size        = sizeof( $agenda_menu );
		$linkcounter = 1;
		foreach ( $agenda_menu as $label => $agenda_link ) {
			if ( $linkcounter == 1 ) {
				if ( $size == 1 ) {
					$link .= sprintf( '<li><a href="%s">%s</a></li>', $agenda_link, $label );
				} else {
					$link .= sprintf( '<li class="has-sub"><a href="%s">%s</a><ul>', $agenda_link, $label );
				}
			} else {
				if ( $linkcounter == $size ) {
					$link .= sprintf( '<li class="last"><a href="%s">%s</a></li></ul></li>', $agenda_link, $label );
				} else {
					$link .= sprintf( '<li><a href="%s">%s</a></li>', $agenda_link, $label );
				}
			}
				$linkcounter++;
		}
	}
	if ( $template_id ) { // if it has a template, it's not itself a template
		$link .= '<li><a target="_blank" href="' . esc_attr($permalink) . '">' . __( 'View Event', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	} else {
		$link .= '<li><a target="_blank" href="' . esc_attr($permalink) . '">' . __( 'View Template on Site', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	}
	$link .= '<li class="last"><a target="_blank" href="' . esc_attr($permalink) . 'print_agenda=1&test=1">' . __( 'View Agenda', 'rsvpmaker-for-toastmasters' ) . '</a></li>';
	$link .= '</ul></div>';
	return $link;

}

function tm_security_setup( $check = true, $cookie = true ) {
	if ( $cookie ) {
		if(isset($_SERVER['REMOTE_ADDR']))
			setcookie( 'tm_member', sanitize_text_field($_SERVER['REMOTE_ADDR']), time() + 15552000 );// 180 days
	}
	global $tm_security;
	$security_roles = array( 'administrator', 'manager', 'editor', 'author', 'contributor', 'subscriber' );

	$tm_security['administrator']['view_reports']      = 1;
	$tm_security['administrator']['view_contact_info'] = 1;
	$tm_security['administrator']['edit_signups']      = 1;
	$tm_security['administrator']['organize_agenda']      = 1;
	$tm_security['administrator']['edit_member_stats'] = 1;
	$tm_security['administrator']['edit_own_stats']    = 1;
	$tm_security['administrator']['agenda_setup']      = 1;
	$tm_security['administrator']['edit_members']      = 1;
	$tm_security['administrator']['email_list']        = 1;
	$tm_security['administrator']['add_member']        = 1;

	$tm_security['manager']['view_reports']      = 1;
	$tm_security['manager']['view_contact_info'] = 1;
	$tm_security['manager']['edit_signups']      = 1;
	$tm_security['manager']['organize_agenda']      = 1;
	$tm_security['manager']['edit_member_stats'] = 1;
	$tm_security['manager']['edit_own_stats']    = 1;
	$tm_security['manager']['agenda_setup']      = 1;
	$tm_security['manager']['email_list']        = 1;
	$tm_security['manager']['add_member']        = 1;
	$tm_security['manager']['edit_members']      = 1;
	$tm_security['manager']['edit_users']        = 1;
	$tm_security['manager']['promote_users']     = 1;
	$tm_security['manager']['remove_users']      = 1;
	$tm_security['manager']['delete_users']      = 1;
	$tm_security['manager']['list_users']        = 1;
	$tm_security['manager']['upload_files']      = 1;

	$tm_security['editor']['view_reports']      = 1;
	$tm_security['editor']['view_contact_info'] = 1;
	$tm_security['editor']['edit_signups']      = 1;
	$tm_security['editor']['organize_agenda']      = 1;
	$tm_security['editor']['edit_member_stats'] = 1;
	$tm_security['editor']['edit_own_stats']    = 1;
	$tm_security['editor']['agenda_setup']      = 1;
	$tm_security['editor']['email_list']        = 1;
	$tm_security['editor']['add_member']        = 0;
	$tm_security['editor']['edit_users']        = 0;
	$tm_security['editor']['edit_members']      = 0;
	$tm_security['editor']['promote_users']     = 0;
	$tm_security['editor']['remove_users']      = 0;
	$tm_security['editor']['delete_users']      = 0;
	$tm_security['editor']['list_users']        = 0;
	$tm_security['editor']['upload_files']      = 1;

	$tm_security['author']['view_reports']      = 1;
	$tm_security['author']['view_contact_info'] = 1;
	$tm_security['author']['edit_signups']      = 1;
	$tm_security['author']['organize_agenda']      = 1;
	$tm_security['author']['edit_member_stats'] = 0;
	$tm_security['author']['edit_own_stats']    = 0;
	$tm_security['author']['agenda_setup']      = 0;
	$tm_security['author']['email_list']        = 1;
	$tm_security['author']['add_member']        = 0;
	$tm_security['author']['upload_files']      = 1;

	$tm_security['contributor']['view_reports']      = 1;
	$tm_security['contributor']['view_contact_info'] = 1;
	$tm_security['contributor']['edit_signups']      = 1;
	$tm_security['contributor']['organize_agenda']      = 1;
	$tm_security['contributor']['edit_member_stats'] = 0;
	$tm_security['contributor']['edit_own_stats']    = 0;
	$tm_security['contributor']['agenda_setup']      = 0;
	$tm_security['contributor']['email_list']        = 1;
	$tm_security['contributor']['add_member']        = 0;
	$tm_security['contributor']['upload_files']      = 0;

	$tm_security['subscriber']['view_reports']      = 1;
	$tm_security['subscriber']['view_contact_info'] = 1;
	$tm_security['subscriber']['edit_signups']      = 1;
	$tm_security['subscriber']['organize_agenda']      = 1;
	$tm_security['subscriber']['edit_member_stats'] = 0;
	$tm_security['subscriber']['edit_own_stats']    = 0;
	$tm_security['subscriber']['agenda_setup']      = 0;
	$tm_security['subscriber']['email_list']        = 1;
	$tm_security['subscriber']['upload_files']      = 0;

	if ( is_multisite() ) {
		$tm_role = get_role( 'administrator' );
		$tm_role->add_cap( 'edit_members' ); // site admins need to be able to edit member records
	}

	if ( $check ) {

		$security = get_option( 'tm_security' );
		if ( ! empty( $security ) ) {
			// if this was customized the old way, adjust defaults
			$caparray['read']              = array( 'administrator', 'manager', 'editor', 'author', 'contributor', 'subscriber' );
			$caparray['edit_others_posts'] = array( 'administrator', 'manager', 'editor' );
			$caparray['manage_options']    = array( 'administrator' );
			foreach ( $security as $tm_cap => $cap ) {
				if ( $tm_cap == 'view_attendance' ) {
					continue;
				}
				foreach ( $security_roles as $role ) {
					$tm_security[ $role ][ $tm_cap ] = in_array( $role, $caparray[ $cap ] );
				}
			}
		}

		add_awesome_roles();

		$tm_cap_set = get_option( 'tm_cap_set' );
		if ( ! $tm_cap_set || ( $check == 2 ) ) {
			foreach ( $security_roles as $role ) {
				$tm_role = get_role( $role );
				if ( $tm_role ) {
					foreach ( $tm_security[ $role ] as $cap => $value ) {
						if ( $value ) {
							$tm_role->add_cap( $cap );
						} else {
							$tm_role->remove_cap( $cap );
						}
					}
				}
			}
			update_option( 'tm_cap_set', 1 );
		}

		// make sure administrator gets all rights
		$tm_role = get_role( 'administrator' );
		foreach ( $tm_security['administrator'] as $cap => $value ) {
			$tm_role->add_cap( $cap );
		}
	}
	return $tm_security;
}

function tm_security_caps() {
	?>
<div class="wrap">
<h2>Toastmasters Security Options</h2>
	<?php
	if ( isset( $_REQUEST['reset_security'] ) ) {
		$tm_security = tm_security_setup( 2, false );
	} else {
		$tm_security = tm_security_setup( false, false );
	}

	$action = admin_url( 'options-general.php?page=tm_security_caps' );

	$action = admin_url( 'options-general.php?page=wp4toastmasters_settings' );

	$security_roles = array( 'manager', 'editor', 'author', 'contributor', 'subscriber' );

	if ( isset( $_POST['tm_caps'] ) && $_POST['tm_caps'] && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $security_roles as $role ) {
			$tm_role = get_role( $role );
			foreach ( $_POST['tm_caps'][ $role ] as $cap => $value ) {
				$cap = sanitize_text_field($cap);
				$value = sanitize_text_field($value);
				if ( $value ) {
					$tm_role->add_cap( $cap );
				} else {
					$tm_role->remove_cap( $cap );
				}
				if ( $value && ( $cap = 'agenda_setup' ) ) {
					$tm_role->add_cap( 'edit_rsvpmakers' );
					$tm_role->add_cap( 'edit_others_rsvpmakers' );
				}
			}
		}
	}

	if ( isset( $_POST['user_caps'] ) && $_POST['user_caps'] && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$user = get_user_by( 'ID', $_POST['user_id'] );
		foreach ( $_POST['user_caps'] as $cap => $value ) {
		$cap = sanitize_text_field($cap);
		$value = sanitize_text_field($value);
		if ( $value ) {
				$user->add_cap( $cap );
			} else {
				$user->remove_cap( $cap );
			}
		}
	}

	if ( isset( $_POST['user_id'] ) && $_POST['user_id'] && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$user_id = (int) $_POST['user_id'];
		$user    = get_user_by( 'id', $user_id );
		printf( '<form method="post" action="%s"><h3>%s</h3><input type="hidden" name="user_id" value="%s" />', $action, $user->user_login, $user_id );
		foreach ( $tm_security['manager'] as $cap => $value ) {
			$cap = sanitize_text_field($cap);
			$value = sanitize_text_field($value);
			if ( ( $cap == 'delete_users' ) && is_multisite() ) {
				continue;
			}
			if ( ( $cap == 'remove_users' ) && ! is_multisite() ) {
				continue;
			}
				$opt = ( $user->has_cap( $cap ) ) ? '<option value="1" selected="selected">' . __( 'Yes', 'rsvpmaker-for-toastmasters' ) . '</option><option value="0">' . __( 'No', 'rsvpmaker-for-toastmasters' ) . '</option>' : '<option value="1">' . __( 'Yes', 'rsvpmaker-for-toastmasters' ) . '</option><option value="0" selected="selected">' . __( 'No', 'rsvpmaker-for-toastmasters' ) . '</option>';
				printf( '<p><select name="user_caps[%s]">%s</select> %s</p>', $cap, $opt, $cap );
		}
		if ( isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] == 'security' ) {
			?>
			<input type="hidden" id="activetab" value="security" />
			<?php
		}
		?>
			<input type="hidden" name="tab" value="security">
			<?php
			submit_button();
			rsvpmaker_nonce();
			echo '</form>';
	}

	printf( '<form method="post" action="%s">', $action );
	echo '<input type="hidden" name="tab" value="security">';

	foreach ( $security_roles as $role ) {
		if ( $role == 'administrator' ) {
				continue;
		}
		$tm_role = get_role( $role );
		$label   = ucfirst( $role );

		if ( $role == 'subscriber' ) {
				$label .= ' (' . __( 'Member', 'rsvpmaker-for-toastmasters' ) . ')';
		}
		printf( '<div style="width: 200px; float: left;"><h3>%s</h3>', $label );
		foreach ( $tm_security[ $role ] as $cap => $value ) {
			if ( ( $cap == 'delete_users' ) && is_multisite() ) {
				continue;
			}
			if ( ( $cap == 'remove_users' ) && ! is_multisite() ) {
				continue;
			}
				$opt = ( ! empty( $tm_role->capabilities[ $cap ] ) ) ? '<option value="1" selected="selected">' . __( 'Yes', 'rsvpmaker-for-toastmasters' ) . '</option><option value="0">' . __( 'No', 'rsvpmaker-for-toastmasters' ) . '</option>' : '<option value="1">' . __( 'Yes', 'rsvpmaker-for-toastmasters' ) . '</option><option value="0" selected="selected">' . __( 'No', 'rsvpmaker-for-toastmasters' ) . '</option>';
				printf( '<p><select name="tm_caps[%s][%s]">%s</select> %s</p>', $role, $cap, $opt, $cap );
		}
		echo '</div>';
	}

	echo '<div style="clear: both;">';
	?>
<input type="hidden" name="tab" value="security">
	<?php

	submit_button();
	echo '</div>';
	rsvpmaker_nonce();
	echo '</form>';

	printf( '<form method="post" action="%s"><h2>Set for User</h2>', $action );
	echo awe_user_dropdown( 'user_id', 0, true );
	rsvpmaker_nonce();
	submit_button( 'Show Form' );
?>
<input type="hidden" name="tab" value="security">
<?php rsvpmaker_nonce(); ?>
</form>
</div>
<h3>About these security options</h3>
<p>WordPress security is based on a series of roles, which define categories of users. By default, members are assigned to the standard WordPress security role <strong>Subscriber</strong>, a user with no rights to edit or publish content. At the other extreme, the <strong>Administrator</strong> has all rights on the site. In between are the <a href="https://codex.wordpress.org/Roles_and_Capabilities">standard WordPress roles</a> <strong>Contributor</strong>, <strong>Author</strong>, and <strong>Editor</strong>, each with increasing rights to submit, publish, and edit website content.</p>
<p>We have assigned each of these roles, plus the custom role <strong>Manager</strong> an additional set of privledges related to Toastmasters functionality, and you can change the default choices as necessary. You can also grant or revoke rights for a specific user. Additional customization is possible using a plugin such as <a href="https://wordpress.org/plugins/user-role-editor/">User Role Editor</a> (included with wp4toastmasters.com / toastmost.org accounts).</p>
<p>Visitors to the site who are not logged in cannot perform any of these actions. They also will not be able to view content designated as "members only" such as members only blog posts.</p>
	<?php
}

// BuddyPress support

function bp_toastmasters( $post_id, $actiontext, $user_id ) {

	if ( ! function_exists( 'bp_activity_add' ) ) {
		return;
	}

	global $bp;
	// hack for multisite
	if ( empty( $bp->activity->table_name ) ) {
		do_action( 'bp_init' );
	}
	$profile_link = bp_core_get_userlink( $user_id );
	$permalink    = get_permalink( $post_id );
	global $wpdb;

	$ts          = get_rsvpmaker_timestamp( $post_id );
	$actiontext .= ' for <a href="' . $permalink . '">' . rsvpmaker_date( 'F jS', $ts ) . '</a>';
	if ( is_multisite() ) {
		$urlparts    = explode( '//', site_url() );
		$actiontext .= ' (' . $urlparts[1] . ')';
	}
	$args   = array(
		'action'       => $profile_link . ' posted an update',
		'content'      => $actiontext,
		'component'    => 'activity',
		'type'         => 'activity_update',
		'primary_link' => bp_core_get_userlink( $user_id, false, true ),
		'user_id'      => $user_id,
	);
	$row_id = bp_activity_add( $args );
	// bp_update_user_last_activity( $user_id, time() );
}

function wpt_get_member_profile($user_id,$email_query = '') {
	$userdata = get_userdata( $user_id );
	$output = '';
	$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['facebook_url'] = __( 'Facebook Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['twitter_url']  = __( 'Twitter Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['linkedin_url'] = __( 'LinkedIn Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['business_url'] = __( 'Business Web Address', 'rsvpmaker-for-toastmasters' );
	$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
	foreach ( $contactmethods as $name => $value ) {
		if ( strpos( $name, 'phone' ) && $userdata->$name ) {
			$output .= sprintf( '<div>%s: %s</div>', $value, $userdata->$name );
		}
		elseif ( strpos( $name, 'url' && $userdata->$name ) ) {
			$output .= sprintf( '<div><a target="_blank" href="%s">%s</a></div>', $userdata->$name, $userdata->name );
		}
		elseif ( strpos( $name, 'email' ) && $userdata->$name) {
			$output .= sprintf( '<div><a target="_blank" href="mailto:%s%s">%s</a></div>', $userdata->$name, $email_query, $userdata->$name );
		}
	}
	return $output;
}

function display_toastmasters_profile() {
	global $bp;
	$userdata = get_userdata( $bp->displayed_user->id );

	if ( is_club_member() ) {
		echo '<p><em>' . __( 'Contact details such as phone numbers and email are displayed only for logged in members (and should only be used for Toastmasters business)', 'rsvpmaker-for-toastmasters' ) . '.</em></p>';
	} else {
		return;
	}

	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
	$title                          = $wp4toastmasters_officer_titles[ $userdata->ID ];
	$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['facebook_url'] = __( 'Facebook Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['twitter_url']  = __( 'Twitter Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['linkedin_url'] = __( 'LinkedIn Profile', 'rsvpmaker-for-toastmasters' );
	$contactmethods['business_url'] = __( 'Business Web Address', 'rsvpmaker-for-toastmasters' );
	$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );

	?>
<p id="member_<?php echo esc_attr($userdata->ID); ?>"><strong><?php echo esc_html($userdata->first_name . ' ' . $userdata->last_name); ?></strong> 
						 <?php
							if ( ! empty( $userdata->education_awards ) ) {
								echo '(' . esc_html($userdata->education_awards) . ')';}
							?>
	<?php
	if ( ! empty( $title ) ) {
		echo ' ' . esc_html($title);
	}
	?>
</p>
	<?php

	foreach ( $contactmethods as $name => $value ) {
		if ( empty( $userdata->$name ) ) {
			continue;
		}
		if ( strpos( $name, 'phone' ) ) {
				printf( '<div>%s: %s</div>', $value, $userdata->$name );
		}
		if ( strpos( $name, 'url' ) ) {
				printf( '<div><a target="_blank" href="%s">%s</a></div>', $userdata->$name, $value );
		}
	}

		printf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>', $userdata->user_email, $userdata->user_email );

	if ( $userdata->user_description ) {
		echo wpautop( '<strong>' . __( 'About Me', 'rsvpmaker-for-toastmasters' ) . ':</strong> ' . add_implicit_links( $userdata->user_description ) );
	}
	global $current_user;
	if ( bp_displayed_user_id() == $current_user->ID ) {
		printf( '<p>&mdash;<a href="%s">%s</a></p>', admin_url( 'profile.php' ), __( 'Edit my Toastmasters profile', 'rsvpmaker-for-toastmasters' ) );
	}
}

/* Ajax */

function toastmasters_stats_model_check() {
	$model = get_option( 'stats_data_model' );
	if ( empty( $model ) || $model < 1 ) {
		update_stats_model();
	}	
}

function update_stats_model() {
	global $wpdb;
	$users = get_users();
	foreach ( $users as $user ) {
		$sql     = 'SELECT SUM(quantity) as total,role FROM `' . $wpdb->prefix . 'toastmasters_history` where user_id=' . $user->ID . ' group by role';
		$results = $wpdb->get_results( $sql );
		if ( $results ) {
			foreach ( $results as $row ) {
				$role = $row->role;
				if ( $role == 'COMPETENT COMMUNICATION' ) {
					$role = 'COMPETENT COMMUNICATION';
				}
				update_user_meta( $user->ID, 'tmstat:' . $role, $row->total );
			}
		}
	}
	update_option( 'stats_data_model', 1 );
}
add_action('admin_init','toastmasters_stats_model_check');

add_filter( 'bp_get_activity_content_body', 'members_only_bp' );

function members_only_bp( $args ) {
	global $activities_template;

	if ( $activities_template->activity->secondary_item_id ) {
		$cat = wp_get_post_categories( $activities_template->activity->secondary_item_id );
		foreach ( $cat as $cat_id ) {
			$category = get_category( $cat_id );
			if ( $category->slug == 'members-only' ) {
				return 'Members-only content (login required)';
			}
		}
	}

	return $args;
}

function officers_limit_promotion( $all_roles ) {
	if ( current_user_can( 'manage_options' ) ) {
		return $all_roles;
	}

	unset( $all_roles['administrator'] );

	return $all_roles;
}

add_filter( 'editable_roles', 'officers_limit_promotion', 99 );

add_shortcode( 'blogs_by_member_tag', 'blogs_by_member_tag' );
function blogs_by_member_tag( $atts ) {
	global $wp_query,$post;

	$original_query = $wp_query;
	$wp_query       = null;
	$index          = $output = '';
	// $output .= sprintf('<form method="get" action="%s">',get_permalink());
	if ( isset( $_GET['altslug'] ) ) {
		foreach ( $_GET['altslug'] as $user_id => $slug ) {
			if ( ! empty( $slug ) ) {
				add_user_meta( (int) $user_id, 'blogs_by_member_tag', sanitize_text_field($slug) );
				$output .= sprintf( '<p>Adding %s to %s</p>', $slug, $user_id );
			}
		}
	}

	$members = get_club_members();
	foreach ( $members as $member ) {
		$user_id = $member->ID;
		$m       = get_userdata( $member->ID );
		$name    = trim( $m->first_name . ' ' . $m->last_name );
		$slug    = strtolower( preg_replace( '/[^a-zA-Z0-9]+/', '-', $name ) );
		$slugs   = get_user_meta( $user_id, 'blogs_by_member_tag' );
		if ( empty( $slugs ) || ! in_array( $slug, $slugs ) ) {
			add_user_meta( $user_id, 'blogs_by_member_tag', $slug );
			$slugs[] = $slug;
		}
		$output     .= sprintf( '<h2 id="member%d">%s</h2>', $user_id, $name );
		$index      .= sprintf( '<a href="#member%d">%s</a> * ', $user_id, $m->first_name . '&nbsp;' . $m->last_name );
		$taggedposts = array();
		foreach ( $slugs as $slug ) {
			$args     = array(
				'posts_per_page' => 500,
				'tag'            => $slug,
			);
			$wp_query = new WP_Query( $args );
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					$t            = rsvpmaker_strtotime( $post->post_date );
					$date         = rsvpmaker_date( 'M d, Y', $t );
					$members_only = ( has_category( 'Members Only', $post->ID ) ) ? ' (members only)' : '';
					$link    = sprintf( '<h3><a href="%s">%s</a> Posted: %s %s</h3>', get_permalink( $post->ID ), get_the_title(), $date, $members_only );
					$excerpt = strip_tags( $post->post_content );
					$p       = explode( "\n", $excerpt );
					$excerpt = '';
					foreach ( $p as $line ) {
						$pos = strpos( $line, $name );
						if ( $pos !== false ) {
							$excerpt .= '<p>' . $line . '</p>';
						}
					}
					if ( empty( $excerpt ) && ( sizeof( $slugs ) > 1 ) ) {
						$slugname = ucwords( str_replace( '-', ' ', $slug ) );
						// $output .= $slugname;
						if ( $slugname != $name ) {
							foreach ( $p as $line ) {
								$pos = strpos( $line, $slugname );
								if ( $pos !== false ) {
									$excerpt .= '<p>' . $line . '</p>';
								}
							}
						}
					}
					$taggedposts[ $post->post_date ] = $link . $excerpt;
				endwhile;
			endif;
			$wp_query = null;
		}
		if ( ! empty( $taggedposts ) ) {
			krsort( $taggedposts );
			$output .= implode( "\n", $taggedposts );
		}
	}

	$tags = get_tags();
	if ( $tags ) {
		$output .= '<h3>' . __( 'All Blog Tags', 'rsvpmaker-for-toastmasters' ) . "</h3>\n<p>* ";
		foreach ( $tags as $tag ) {
			$output .= sprintf( '<a href="%s" title="%s">%s</a> * ', esc_url( get_tag_link( $tag->term_id ) ), esc_attr( $tag->name ), esc_html( $tag->name ) );
		}
		$output .= '</p>';
	}

	$wp_query = $original_query;
	wp_reset_postdata();
	return '<p>* ' . $index . '</p>' . $output;
}

function tm_youtube_tool() {
	echo '<div style="padding-bottom: 500px; margin-bottom: 300px; padding: 10px; ">';
	echo '<h1>Toastmasters YouTube Video Tool</h1>';
	echo '<p>';
	_e( 'This tool was designed to capture a listing of videos you have uploaded to YouTube and use them as the basis of a blog post (categorized as members-only by default) and / or an email to distribute to your members.', 'rsvpmaker-for-toastmasters' );
	echo ' ';
	_e( 'YouTube video links can be associated with either a single speaker or the meeting date (for example, a Zoom recording of the whole meeting).', 'rsvpmaker-for-toastmasters' );
	printf( ' <a href="https://wp4toastmasters.com/knowledge-base/youtube/">%s</a>.', __( 'Documentation', 'rsvpmaker-for-toastmasters' ) );
	echo '</p>';

	global $current_user, $rsvp_options;
	global $wpdb;
	$wpdb->show_errors();

	if(!empty($_POST['message'])  && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		//print_r($_POST);
		$blog   = sanitize_text_field($_POST['blog']);
		$email  = sanitize_text_field($_POST['email']);
		$policy = wp_kses_post(stripslashes( $_POST['policy'] ));
		$message = wp_kses_post(stripslashes($_POST['message']))."\n".$policy;
		$subject = sanitize_text_field($_POST['youtube_subject']);
		if(isset($_POST['event_ids'])) {
			$ids = explode(',',$_POST['event_ids']);
			foreach($ids as $id) {
				update_post_meta(intval($id),'youtube_shared',true);
			}
		}
		$lines = explode("\n",$message);
		$email_content = $content = '';
		foreach($lines as $line) {
			$line = trim($line);
			if(empty($line))
				continue;
			if(strpos($line,'://www.youtube.com') || strpos($line,'://youtu.be')) {
				$line = trim($line);
			$email_content .= YouTubeEmailFormat($line);
			$content .= sprintf(
					'<!-- wp:core-embed/youtube {"url":"%s","type":"video","providerNameSlug":"youtube","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
<figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
%s
</div></figure>
<!-- /wp:core-embed/youtube -->' . "\n\n",
					$line,
					$line
				);
			}
			else {
				$email_content .= "<!-- wp:paragraph -->\n<p>".$line."</p>\n<!-- /wp:paragraph -->\n\n";
				$content .= "<!-- wp:paragraph -->\n<p>".$line."</p>\n<!-- /wp:paragraph -->\n\n";
			}
		}
		update_option( 'tm_video_blog', $blog );
		update_option( 'tm_video_email', $email );
		update_option( 'tm_video_policy', $policy );
		$speakers = (!empty($_POST['speakers'])) ? explode(',',$_POST['speakers']) : array();

		$video_cat = wp_create_category( __( 'Video', 'rsvpmaker-for-toastmasters' ) );

		$categories = array( $video_cat );
		if ( ( $blog == 'publish' ) || ( $blog == 'draft' ) ) {
			$members_category = get_category_by_slug( 'members-only' );
			$members_cat_id   = ( empty( $members_category->term_id ) ) ? wp_create_category( 'Members Only' ) : $members_category->term_id;
			$categories[]     = $members_cat_id;
		}

		$status = ( ( $blog == 'publish' ) || ( $blog == 'publish_public' ) ) ? 'publish' : 'draft';
		// Create post object
		$my_post = array(
			'post_title'    => $subject,
			'post_type'    => 'post',
			'post_status'   => $status,
			'post_author'   => $current_user->ID,
			'post_category' => $categories,
			'post_content' => $content,
		);
		$email_post = array(
			'post_title'    => $subject,
			'post_type'    => 'rsvpemail',
			'post_status'   => 'publish',
			'post_author'   => $current_user->ID,
			'post_content' => $content,
		);

		if ( ! empty( $speakers ) ) {
			$my_post['tags_input']     = $speakers;
		}

		// Insert the post into the database
		if ( $blog != 'none' ) {
			$id = wp_insert_post( $my_post );
			if ( $id ) {
				printf( '<p><a href="%s?post=%d&action=edit">%s</a></p>', admin_url( 'post.php' ), $id, __( 'Edit blog post', 'rsvpmaker-for-toastmasters' ) );
			}
			if ( $status == 'publish' ) {
				printf( '<p><a href="%s">%s</a></p>', get_permalink( $id ), __( 'View blog post', 'rsvpmaker-for-toastmasters' ) );
			}
		}

		if ( $email ) {
			$email_post['post_content'] = rsvpmailer_default_block_template_wrapper($email_post['post_content']);
			$id                        = wp_insert_post( $email_post );
			printf( '<p><a href="%s?post=%d&action=edit">%s</a></p>', admin_url( 'post.php' ), $id, __( 'Edit email', 'rsvpmaker-for-toastmasters' ) );
			printf( '<p><a href="%s?list=members">%s</a></p>', get_permalink( $id ), __( 'Preview/send email', 'rsvpmaker-for-toastmasters' ) );
		}
		echo do_blocks($email_content);
	}//end post to server
	$policy = get_option( 'tm_video_policy' );
	if ( empty( $policy ) ) {
		$policy = "<strong>Video policy</strong>: speech videos are intended as a tool for speakers to see their own performances and think about how they can improve. Even though these are on YouTube, they are published as \"unlisted\" by default, meaning they won't show up in search results. Don't forward these links or post them on Facebook or in any other forum without the speaker's permission. From time to time, we may ask a speaker for permission to use a video as part of our marketing of the club. Volunteers are also welcome - if you're proud of a particular speech, let us know.";
	}

	$blog = get_option( 'tm_video_blog' );
	if ( empty( $blog ) ) {
		$blog = 'draft';
	}
	$email = (int) get_option( 'tm_video_email' );
	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
	$options   = '<option value="">Select Member</option>';
	foreach ( $blogusers as $user ) {
		$userdata = get_userdata( $user->ID );
		if ( $userdata->hidden_profile ) {
			continue;
		}

		$index            = preg_replace( '/[^A-Za-z]/', '', $userdata->last_name . $userdata->first_name . $userdata->user_login );
		$names[ $index ]  = $userdata->first_name . ' ' . $userdata->last_name;
		$index            = preg_replace( '/[^A-Za-z]/', '', $userdata->first_name . $userdata->last_name . $userdata->user_login );
		$fnames[ $index ] = $userdata->first_name . ' ' . $userdata->last_name;
	}

	ksort( $names );
	ksort( $fnames );
	$options .= '<optgroup label="First Names">';
	foreach ( $fnames as $name ) {
		$options .= sprintf( '<option value="%s" /> %s </option>', $name, $name );
	}
	$options .= '</optgroup><optgroup label="Last Names">';
	foreach ( $names as $name ) {
		$options .= sprintf( '<option value="%s" /> %s </option>', $name, $name );
	}
	$options .= '</optgroup>';

	$ptext = '';
	$count = 1;
	$show = (isset($_GET['show'])) ? intval($_GET['show']) : 5;
	$past  = past_toastmaster_meetings($show);
	if ( $past ) {
		foreach ( $past as $pindex => $pst ) {			
			$speakerdate = rsvpmaker_date($rsvp_options['long_date'], (int) $pst->ts_start);
			$j[] = '{"date":"'.$speakerdate.'","previewtext":""}';
			if(get_post_meta($pst->ID,'youtube_shared',true))
			{
				$speakerdate .= ' (shared)';
			}
			$wrapup[]       = $speakerdate;
			$alldetails[]   = '<strong>' . $speakerdate . '</strong>';
			$ptext .= (empty($ptext)) ? '<div>' : '<div class="ptextmore">';
			$ptext         .= '<strong>' . $speakerdate . "</strong>\n";
			$nameanddetails = '';
			$sql            = "SELECT *, meta_value as user_id FROM $wpdb->postmeta WHERE post_id=$pst->ID AND meta_key LIKE '_role_Speaker%' ORDER BY meta_key";
			$speakers       = $wpdb->get_results( $sql );
			if ( $speakers ) {
				foreach ( $speakers as $row ) {
					$name = $details = '';
					if ( ! empty( $row->user_id ) && is_numeric( $row->user_id ) ) {
						$user    = get_userdata( $row->user_id );
						$name    = ( empty( $user->first_name ) ) ? 'User ' . $row->user_id : $user->first_name . ' ' . $user->last_name;
						$ptext  .= sprintf( '<div class="checkbox_section"><input class="youtube_speaker_check youtube_speaker_check'.$pindex.'" type="checkbox" name="speakers['.$pst->ts_start.'][%d]" id="speaker%d" value="%s" /> ', $count, $count, $name );
						$title   = get_post_meta( $pst->ID, '_title' . $row->meta_key, true );
						$details = '';
						if ( ! empty( $title ) ) {
							$details = trim( $title );
						}
						$pkey = get_post_meta( $pst->ID, '_project' . $row->meta_key, true );
						if ( ! empty( $pkey ) ) {
							$project = get_project_text( $pkey );
							if ( ! empty( $details ) ) {
								$details .= ', ';
							}
							$details .= __( 'Project:', 'rsvpmaker-for-toastmasters' ) . ' ' . $project;
						}
						// $alldetails[] = '<strong>'.$user->first_name.' '.$user->last_name.'</strong> '.$details;
						$ptext .= sprintf( '%s: %s<br />Details: <input type="text" name="speech['.$pst->ts_start.'][%d]" id="speech%d" value="%s" class="speech"> YouTube Link: <input type="text" name="link['.$pst->ts_start.'][%d]" id="linkspeaker%d" class="checkboxlink" i="%d" class="link">', $name, $details, $count, $count, htmlentities( $details), $count, $count, $count );
						$ptext .= "</div>\n\n";
						$ptext .= sprintf('<input type="hidden" id="event_id_%d" value="%d">',$count,$pst->ID);
						$count++;
					}
					$nameanddetails .= '<p>' . $name . ': ' . $details . '</p>';
				}
				$count++;
				$ptext .= '</div>';
			}
			$ptext .= sprintf( '<p><select name="speakers['.$pst->ts_start.'][%d]" id="youtube_speaker_select%d" class="youtube_speaker_select" >%s</select> Details: <input type="text" class="speech" name="speech['.$pst->ts_start.'][%d]" id="selectspeech%d"> YouTube Link: <input type="text" class="link" name="link['.$pst->ts_start.'][%d]" id="link%d"></p>', $pindex, $pindex, $options, $pindex, $pindex, $pindex, $pindex );
			$ptext .= sprintf( '<p>Wrapup YouTube Link <input class="wrapuplink" id="wrapuplink%d" wrapindex="%d" name="wrapuplink['.$pst->ts_start.']" /></p>', $pindex, $pindex);
	}
	}
	echo $ptext; 
?>
<p>To show more than 5 past events, enter the number here.</p>
<form method="get" action="<?php echo admin_url('upload.php') ?>"><input type="hidden" name="page" value="tm_youtube_tool">
<input type="text" name="show" value="10"> <button>Show</button>
</form>

<form method="post" action="<?php echo admin_url( 'upload.php?page=tm_youtube_tool' ); ?>">
<h3><?php _e( 'Policy to include in email', 'rsvpmaker-for-toastmasters' ); ?></h3>
<p><textarea name="policy" rows="3" style="width: 90%"><?php echo wp_kses_post($policy); ?></textarea></p>
<input type="hidden" name="speakers" id="speakers">
<input type="hidden" name="event_ids" id="event_ids">
<div id="youtube_preview"></div>
<p>To display a listing of videos and blog posts indexed by member name on your website, include the code [blogs_by_member_tag] on the page where you want it to appear.</p>
</div>
<div style="display: flex; background-color: #fff; position: fixed; bottom: 15px; width: 100%; border-top: thick solid #2271B1; padding: 10px;">
<div style="min-width:300px;max-width:600px;">
<input type="text" placeholder="Subject" id="youtube_subject" name="youtube_subject" style="width:100%; font-size:small" />
<br /><textarea name="message" id="newpreview" rows="4" style="width:100%; font-size: small;"></textarea>
<br><em>YouTube links must be on a separate line for the video to display properly. The &lt;strong&gt; tags are for bold text.</em>
</div>
<div style="width: 180px;padding-left:10px;font-size:small;">
<input type="radio" name="blog" value="draft_public" 
	<?php
	if ( $blog == 'draft_public' ) {
		echo ' checked="checked" ';}
	?>
 ><?php _e( 'Draft blog post', 'rsvpmaker-for-toastmasters' ); ?>
<br />
<input type="radio" name="blog" value="publish_public" 
	<?php
	if ( $blog == 'publish_public' ) {
		echo ' checked="checked" ';}
	?>
 ><?php _e( 'Publish blog post', 'rsvpmaker-for-toastmasters' ); ?>
<br />
<input type="radio" name="blog" value="draft" 
	<?php
	if ( $blog == 'draft' ) {
		echo ' checked="checked" ';}
	?>
 ><?php _e( 'Draft post (members only)', 'rsvpmaker-for-toastmasters' ); ?>
<br />
<input type="radio" name="blog" value="publish" 
	<?php
	if ( $blog == 'publish' ) {
		echo ' checked="checked" ';}
	?>
 ><?php _e( 'Publish post (members only)', 'rsvpmaker-for-toastmasters' ); ?>
<br />
<input type="radio" name="blog" value="none" 
	<?php
	if ( $blog == 'none' ) {
		echo ' checked="checked" ';}
	?>
 ><?php _e( 'No blog post', 'rsvpmaker-for-toastmasters' ); ?>
<br />
	<?php _e( 'Email message', 'rsvpmaker-for-toastmasters' ); ?> <input type="radio" name="email" value="1" 
			  <?php
				if ( $email ) {
					echo ' checked="checked" ';}
				?>
				 ><?php _e( 'Yes', 'rsvpmaker-for-toastmasters' ); ?> <input type="radio" name="email" value="0" 
			  <?php
				if ( ! $email ) {
						echo ' checked="checked" ';}
				?>
 ><?php _e( 'No', 'rsvpmaker-for-toastmasters' ); ?>
<?php submit_button(); ?>
</div>

</div>

<?php rsvpmaker_nonce(); ?>
</form>

<script>

jQuery(document).ready(function($) {

var previewobj = [<?php echo implode(',',$j); ?>];
var speakers = [];
var dates = [];
var checkid;
var count;
var link;
var event_id;
var event_ids = [];
var speaker;
var speakerdetails;

function make_youtube_preview() {
	console.log(previewobj);

	previewobj.forEach(
		function(dateobj, dateindex) {
			dateobj.previewtext = '';//reset
			$('.youtube_speaker_check'+dateindex).each( function() {
			checkid = $(this).attr('id');
			count = checkid.replace('speaker','');
			link = $('#link'+checkid).val();
			event_id = $('#event_id_'+count).val();
			console.log('check for #event_id_'+count);
			console.log(event_id);
			speaker = $('#'+checkid).val();
			if($('#'+checkid).is(':checked')) {
				if(!speakers.includes(speaker))
					speakers.push(speaker);
				if(!dates.includes(dateobj.date))
					dates.push(dateobj.date);
				if(!event_ids.includes(event_id))
					event_ids.push(event_id);
				dateobj.previewtext = dateobj.previewtext + speaker;
				dateobj.previewtext = dateobj.previewtext + ': '+$('#speech'+count).val() + "\n\n";
				if('' != link) {
					dateobj.previewtext = dateobj.previewtext + link+"\n\n";
				}
			}
		});
		var selectname = $('#youtube_speaker_select'+dateindex).val();
		var link = $('#link'+dateindex).val();
		var selectdetails = $('#selectspeech'+dateindex).val()
		if(selectname != '') {
			if(!speakers.includes(selectname))
				speakers.push(selectname);
			dateobj.previewtext = dateobj.previewtext + selectname;
			if(selectdetails)
				dateobj.previewtext = dateobj.previewtext +': '+selectdetails;
			dateobj.previewtext = dateobj.previewtext  + "\n\n";
			if('' != link) {
					dateobj.previewtext = dateobj.previewtext + link+"\n\n";
			}
		}
		link = $('#wrapuplink'+dateindex).val();
		if(link != '')
			dateobj.previewtext = dateobj.previewtext + link+"\n\n";
		}
	);

	var newpreviewtext = '';
	previewobj.forEach(
		function(dateobj) {
			if(dateobj.previewtext != '') {
				newpreviewtext = newpreviewtext + dateobj.date+"\n"+dateobj.previewtext;
			}
		}
	);
	$('#newpreview').val(newpreviewtext);
	console.log(previewobj);
	console.log(speakers);
	console.log(dates);
	$('#youtube_subject').val('Replay: '+speakers.join(', ')+', '+dates.join(', '));
	$('#speakers').val(speakers.join(','));
	$('#event_ids').val(event_ids.join(','));
}

$('.youtube_speaker_check').click( function() { make_youtube_preview() } );
$('.youtube_speaker_select').change( function() { make_youtube_preview() } );
$('.speech').change( function() { make_youtube_preview() } );
$('.link').change( function() { make_youtube_preview() } );
$('.wrapuplink').change( function() { make_youtube_preview() } );

});
</script>
	<?php

	// foreach($alldetails as $line)
	// printf('<p>%s</p>',$line);
}

function rsvpmaker_special_toastmasters( $slug ) {
	global $post;
	if ( $slug != 'Agenda Layout' ) {
		return;
	}
	echo '<p>' . __( 'This is an agenda layout. CSS coding can be customized below.', 'rsvpmaker-for-toastmasters' ) . '</p>';
	global $post;
	$meetings = future_toastmaster_meetings( 1 );
	if ( ! isset( $meetings[0]->ID ) ) {
		return 'View the agenda of a current meeting to test this';
	}
	$permalink  = get_permalink( $meetings[0]->ID );
	$permalink .= ( strpos( $permalink, '?' ) ) ? '&' : '?';
	$permalink .= 'print_agenda=1';
	echo '<p>';
	printf( 'View the <a href="%s" target="_blank">agenda of a current meeting</a> to test your changes.', $permalink );
	echo '</p>';

	$css = get_post_meta( $post->ID, '_rsvptoast_agenda_css_2018', true );

	if ( empty( $css ) || isset( $_REQUEST['reset'] ) ) {
		$css = wpt_default_agenda_css();
		update_post_meta( $post->ID, '_rsvptoast_agenda_css_2018', $css );
	}

	echo '<h3>CSS tweaks (same as on Toastmasters settings page)</h3><p>These settings will override anything in the full CSS specified below.</p>';
	agenda_css_customization_form();

	echo '<h3>Full CSS</h3>';

	echo '<pre>' . $css . '</pre>';

	$missing = '';

	if ( ! strpos( $css, 'stoplight' ) ) {
		$missing .= sprintf( '<p><strong>/*%s*/</strong></p><pre>%s</pre>', __( 'Stoplight display, green-yellow-red times', 'rsvpmaker-for-toastmasters' ), wpt_default_agenda_css( 'stoplight' ) );
	}
	if ( ! strpos( $css, '.role' ) ) {
		$missing .= sprintf(
			'<p><strong>/*%s*/</strong></p><pre>%s</pre>',
			__( 'Bold role label', 'rsvpmaker-for-toastmasters' ),
			'.role {
font-weight: bold;
}'
		);
	}
	if ( ! strpos( $css, '.indent' ) ) {
		$missing .= sprintf(
			'<p><strong>/*%s*/</strong></p><pre>%s</pre>',
			__( 'Indented items', 'rsvpmaker-for-toastmasters' ),
			'div.indent {
margin-left: 15px;
}'
		);
	}
	if ( ! strpos( $css, '.role_agenda_note' ) ) {
		$missing .= sprintf(
			'<p><strong>/*%s*/</strong></p><pre>%s</pre>',
			__( 'Formatting for notes displayed below roles.', 'rsvpmaker-for-toastmasters' ),
			'.role_agenda_note {
font-style: italic;
}'
		);
	}
	if ( ! strpos( $css, '.role-agenda-item ul ' ) ) {
		$missing .= sprintf(
			'<p><strong>/*%s*/</strong></p><pre>%s</pre>',
			__( 'Agenda role list items (by default, we do not show bullet points)', 'rsvpmaker-for-toastmasters' ),
			'.role-agenda-item ul {
  list-style-type: none;
  padding-left: 0;
  margin-left: 0;
}'
		);
	}

	if ( ! empty( $missing ) ) {
		echo "<h3>Missing CSS Elements</h3><p>Consider adding these to your CSS code</p>\n" . $missing;
	}

}

function save_rsvpmaker_special_toastmasters( $post_id ) {
	if ( isset( $_POST['_rsvptoast_agenda_css'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		update_post_meta( $post_id, '_rsvptoast_agenda_css_2018', stripslashes( $_POST['_rsvptoast_agenda_css'] ) );
	}
	if ( isset( $_POST['wp4toastmasters_agenda_css'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		update_option( 'wp4toastmasters_agenda_css', sanitize_text_field(stripslashes( $_POST['wp4toastmasters_agenda_css'] ) ) );
	}
}

add_action( 'save_post', 'save_rsvpmaker_special_toastmasters' );

add_action( 'rsvpmaker_special_metabox', 'rsvpmaker_special_toastmasters' );

add_action('admin_init','wpt_agenda_layout_change');

function wpt_agenda_layout_change () {
	global $current_user;
	if(current_user_can('edit_others_rsvpmakers') && isset($_GET['agenda']) && isset($_GET['parent']) && ('change' == $_GET['agenda']) ) {
		$parent = intval($_GET['parent']);
		if(isset($_GET['source'])) {
			$source = intval($_GET['source']);
			$sourcepost = get_post($source);
			$new['post_title'] = 'Agenda Layout: '.$parent;
			$new['post_content'] = $sourcepost->post_content;
			$new['post_status'] = 'publish';
			$new['post_type'] = 'rsvpmaker';
			$new['post_author'] = $current_user->ID;
			$new['post_parent'] = $parent;
			$id = wp_insert_post($new);
			update_post_meta($id,'_rsvpmaker_special','Agenda Layout');
			update_post_meta( $parent,'rsvptoast_agenda_layout', $id );
		}
		elseif(isset($_GET['default'])) {
			delete_post_meta($parent,'rsvptoast_agenda_layout');
			$id = get_option('rsvptoast_agenda_layout');
		}

		if ( ! empty( $id ) ) {
			$destination = admin_url( 'post.php?action=edit&post=' ) . $id;
			$destination .= '&back=' . $parent;
			header( 'Location: ' . $destination );
			exit();
		}
	}

	if(current_user_can('manage_options') && isset($_GET['reset_agenda_layout'])) {
		$id = get_option('rsvptoast_agenda_layout');
		$update['ID'] = $id;
		if('no_sidebar' == $_GET['reset_agenda_layout']) {
			$update['post_content'] = '<!-- wp:columns {"className":"titleblock"} -->
			<div class="wp-block-columns titleblock"><!-- wp:column {"width":"10%"} -->
			<div class="wp-block-column" style="flex-basis:10%"><!-- wp:image {"align":"center","id":666,"width":50,"sizeSlug":"large","linkDestination":"media"} -->
			<div class="wp-block-image"><figure class="aligncenter size-large is-resized"><a href="https://toastmost.org/tmbranding/ToastmastersAgendaLogo.png"><img src="https://toastmost.org/tmbranding/ToastmastersAgendaLogo.png" alt="Toastmasters logo" class="wp-image-666" width="50" height="50" /></a></figure></div>
			<!-- /wp:image --></div>
			<!-- /wp:column -->
			
			<!-- wp:column {"width":"90%"} -->
			<div class="wp-block-column" style="flex-basis:90%"><!-- wp:paragraph {"style":{"typography":{"fontSize":22}}} -->
			<p id="block-25ecbefc-681f-4f15-aee4-936431ed20f3" style="font-size:22px">'.get_bloginfo('name').'</p>
			<!-- /wp:paragraph -->
			
			<!-- wp:paragraph {"fontSize":"medium"} -->
			<p class="has-medium-font-size" id="block-25ecbefc-681f-4f15-aee4-936431ed20f3">[tmlayout_meeting_date] </p>
			<!-- /wp:paragraph --></div>
			<!-- /wp:column --></div>
			<!-- /wp:columns -->
		<!-- wp:wp4toastmasters/agendamain /-->';
		}
		else {
			$update['post_content'] = wpt_custom_layout_default(true);
		}
		$result = wp_update_post($update);
		$destination = admin_url( 'post.php?action=edit&post=' ) . $id;
		header( 'Location: ' . $destination );
		exit();
	}
}

function tmlayout_club_name( $atts ) {
	if ( is_admin() || wp_is_json_request() ) {
		return;
	}
	return get_bloginfo( 'name' );
}

function tmlayout_tag_line( $atts ) {
	if ( is_admin() || wp_is_json_request() ) {
		return;
	}
	return get_bloginfo( 'description' );
}

function tmlayout_post_title( $atts ) {
	if ( is_admin() || wp_is_json_request() ) {
		return;
	}
	return get_the_title();
}

function tmlayout_meeting_date( $atts = array() ) {
	if ( is_admin() || wp_is_json_request() ) {
		return;
	}
	global $post;
	global $rsvp_options;
	$datestring = get_rsvp_date( $post->ID );
	if ( ! empty( $datestring ) ) {
		return rsvpmaker_date( $rsvp_options['long_date'], rsvpmaker_strtotime( $datestring ) );
	}
	else {
		$next = next_toastmaster_meeting();
		if($next) 
			return rsvpmaker_date( $rsvp_options['long_date'], rsvpmaker_strtotime( $next->date ) );
	}
}
function tmlayout_sidebar( $atts ) {
	if ( is_admin() || wp_is_json_request() ) {
		return;
	}

	global $post;
	$recur            = get_post_meta( $post->ID, '_meet_recur', true );
	$template_sidebar = ( $recur ) ? get_post_meta( $recur, '_tm_sidebar', true ) : '';
	$post_sidebar     = get_post_meta( $post->ID, '_tm_sidebar', true );
	$option_sidebar   = get_option( '_tm_sidebar' );

	if ( ! empty( $post_sidebar ) ) {
		$sidebar  = $post_sidebar;
		$officers = get_post_meta( $post->ID, '_sidebar_officers', true );
	} elseif ( ! empty( $template_sidebar ) ) {
		$sidebar  = $template_sidebar;
		$officers = get_post_meta( $recur, '_sidebar_officers', true );
	} elseif ( ! empty( $option_sidebar ) ) {
		$sidebar  = $option_sidebar;
		$officers = get_option( '_sidebar_officers' );
	} else {
		$sidebar = __( '<p>Sidebar text not set</p>', 'rsvpmaker-for-toastmasters' );
	}

	if ( ! empty( $custom['_tm_sidebar'][0] ) ) {
		$sidebar = $custom['_tm_sidebar'][0];
		// $officers = $custom["_sidebar_officers"][0];
	}

	if ( ! empty( $officers ) ) {
		echo '<p>';
		$sidebar .= toastmaster_officers( $atts );
		echo '</p>';
	}

	return wpautop( trim( str_replace( '&nbsp;', ' ', $sidebar ) ) );
}

function tmlayout_main_block($atts) {
	$atts['block'] = 1;
	return tmlayout_main($atts);
}

function tmlayout_main( $atts ) {
	if (empty($atts['block']) && ( is_admin() || wp_is_json_request() )) {
		return '<p>block not set</p>';
	}

	global $post;
	$layout = get_option( 'rsvptoast_agenda_layout' );
	if ( get_post_meta($post->ID,'_rsvpmaker_special',true) ) {
		$next = next_toastmaster_meeting();
		if ( empty( $next ) ) {
			return 'View the agenda of a current meeting to test this';
		}
		return '<div><em>Preview based on next meeting</em></div>'.tm_agenda_content($next->ID);
	}
	$content = tm_agenda_content();
	return $content;
}

add_action( 'rsvp_recorded', 'rsvp_to_member_auto' );

function rsvp_to_member_auto( $rsvp ) {
	if ( isset( $_POST['rsvp_to_member_auto'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$blog_id = get_current_blog_id();
		$user    = get_user_by( 'email', $rsvp['email'] );
		if ( $user ) {
			$member = is_user_member_of_blog( $user->ID );
		} else {
			$member = false;
		}
		if ( ! $user || ! $member ) {
			if ( $user && ! $member && is_multisite() ) {
				add_user_to_blog( $blog_id, $user->ID, 'subscriber' );
			} else {
				$userdata['first_name'] = $rsvp['first'];
				$userdata['last_name']  = $rsvp['last'];
				$userdata['user_email'] = $rsvp['email'];
				ob_start();
				add_member_user( $userdata, true );
				$log = ob_get_clean();
			}
		}
	}
}

function rsvp_to_member() {
	$hook = tm_admin_page_top( __( 'RSVP List to Member', 'rsvpmaker-for-toastmasters' ) );
	global $wpdb;
	$blog_id = get_current_blog_id();

	if ( isset( $_POST['add'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$member_factory = new Toastmasters_Member();
		foreach ( $_POST['add'] as $index => $check ) {
			$user['first_name'] = sanitize_text_field($_POST['first_name'][ $index ]);
			$user['last_name']  = sanitize_text_field($_POST['last_name'][ $index ]);
			$user['user_email'] = sanitize_text_field($_POST['user_email'][ $index ]);
			if ( ! empty( $_POST['toastmasters_id'][ $index ] ) ) {
				$user['toastmasters_id'] = (int) $_POST['toastmasters_id'][ $index ];
			}
			$member_factory->check( $user );
		}
		$member_factory->show_prompts();
		$member_factory->show_confirmations();

	}

	if ( isset( $_POST['add_to_site'] ) && is_multisite() && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['add_to_site'] as $user_id ) {
			make_blog_member( $user_id );
		}
	}

	$table   = $wpdb->prefix . 'rsvpmaker';
	$results = $wpdb->get_results( 'SELECT * FROM ' . $table . ' ORDER BY id DESC LIMIT 0, 30' );
	$count   = 0;

	foreach ( $results as $row ) {
		$user = get_user_by( 'email', $row->email );
		if ( $user ) {
			$member = is_user_member_of_blog( $user->ID );
		} else {
			$member = false;
		}

		// if they're both users and members already, don't list them
		if ( ! $user || ! $member ) {

			if ( empty( $out[ $row->email ] ) ) {
				if ( $user && ! $member ) {
						$out[ $row->email ] = sprintf( '<p><input type="checkbox" name="add_to_site[]" value="%d"> Add To Site %s %s %s</p>', $user->ID, $row->first, $row->last, $row->email );
				} else {
						$out[ $row->email ] = sprintf( '<p><input type="checkbox" name="add[%d]" value="1"> Add User<br />%s<input type="text" name="first_name[%d]" value="%s" /><br />%s<input type="text" name="last_name[%d]" value="%s" /><br />%s<input type="text" name="user_email[%d]" value="%s" /><br />Toastmasters ID# <input type="text" name="toastmasters_id[%d]" value="" /></p>', $count, __( 'First Name', 'rsvpmaker-for-toastmasters' ), $count, $row->first, __( 'Last Name', 'rsvpmaker-for-toastmasters' ), $count, $row->last, __( 'Email', 'rsvpmaker-for-toastmasters' ), $count, $row->email, $count );
					echo "\n";
				}
			}
					$out[ $row->email ] .= get_rsvp_date( $row->event ) . '<br />';

					$details = unserialize( $row->details );
			foreach ( $details as $name => $value ) {
				if ( $value ) {
					$out[ $row->email ] .= $name . ': ' . esc_attr( $value ) . '<br />';
				}
			}
			if ( $row->note ) {
				$out[ $row->email ] .= 'note: ' . nl2br( esc_attr( $row->note ) ) . '<br />';
			}
			$count++;
		}
	}
	if ( ! empty( $out ) ) {
		?>
<form action="<?php echo admin_url( 'users.php?page=rsvp_to_member' ); ?>" method="post" style="max-width: 800px;">
		<?php
		foreach ( $out as $o ) {
			echo "\n" . '<div style="border: thin solid #000;">';
			echo $o;//escaped above
			echo '</div>';
		}
		echo '<div style="position: fixed; bottom: 30px; right: 30px; width: 100px;">';
		submit_button();
		echo '</div>';
		rsvpmaker_nonce(); ?>
</form>
		<?php
	}
	tm_admin_page_bottom( $hook );
}

add_filter( 'rsvpmaker_meta_update_from_template', 'rsvpmaker_meta_update_from_template_tm' );

function rsvpmaker_meta_update_from_template_tm( $post_meta_infos ) {
	$toast_roles = array(
		'Ah_Counter',
		'Body_Language_Monitor',
		'Evaluator',
		'General_Evaluator',
		'Grammarian',
		'Humorist',
		'Speaker',
		'Topics_Master',
		'Table_Topics',
		'Timer',
		'Toastmaster_of_the_Day',
		'Vote_Counter',
	);

	foreach ( $post_meta_infos as $index => $meta_info ) {
		$meta_key = $meta_info->meta_key;
		foreach ( $toast_roles as $role ) {
			if ( strpos( $meta_key, $role ) ) {
				unset( $post_meta_infos[ $index ] );
				break;
			}
		}
	}
	return $post_meta_infos;
}

function rsvp_yes_emails_filter_users( $emails ) {
	$users = get_users();
	foreach ( $users as $user ) {
		if ( in_array( $user->user_email, $emails ) ) {
			unset( $emails[ $user->user_email ] );
		}
	}
	return $emails;
}
add_filter( 'rsvp_yes_emails', 'rsvp_yes_emails_filter_users' );

function wpt_notification_forms( $template_forms ) {
	$template_forms['role_reminder']          = array(
		'subject' => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]',
		'body'    => "You are scheduled to serve as [wptrole] for [rsvpdate].\n\nIf for any reason you cannot fulfill this duty, please post an update to the agenda\n\n[wptagendalink]\n\n\n\n[wpt_tod] ",
	);
	$template_forms['Toastmaster of the Day'] = array(
		'subject' => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]',
		'body'    => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]'.".\n\n[wp4t_assigned_open]",
	);
	$template_forms['Speaker']                = array(
		'subject' => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]',
		'body'    => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]'.".\n\n[wpt_speech_details]\n\n".__('If for any reason you cannot speak as scheduled, please post an update to the agenda','rsvpmaker-for-toastmasters')."\n\n[wptagendalink]\n\n[wpt_tod]",
	);
	$template_forms['Evaluator']              = array(
		'subject' => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]',
		'body'    => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]'.".\n\n[speaker_evaluator]\n\n[evaluation_links]\n\n[tmlayout_intros]\n\n\n\n[wpt_speakers]\n\nEvaluation Team:\n\n[wpt_evaluators]\n\n[wpt_general_evaluator]\n\[wptagendalink]\n\n[wpt_tod] ",
	);
	$template_forms['General Evaluator']      = array(
		'subject' => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]',
		'body'    => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]'.".\n\n[speaker_evaluator]\n\n[evaluation_links]\n\n[wpt_speakers]\n\nEvaluation Team:\n\n[wpt_evaluators]\n\n[wptagendalink]\n\n[wpt_tod] ",
	);
	$template_forms['Vote Counter']      = array(
		'subject' => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]',
		'body'    => __('Your role','rsvpmaker-for-toastmasters').': [wptrole] - [rsvpdate]'.".\n\n[wpt_voting_tool_link]\n\n[wptagendalink]\n\n[wpt_tod] ",
	);
	$template_forms['norole']                 = array(
		'subject' => __('Meeting Reminder','rsvpmaker-for-toastmasters').'; [rsvpdate]',
		'body'    => "[wpt_open_roles]\n\n[tmlayout_main]\n\n[wpt_tod]",
	);
	$template_forms['suggest']  = array(
		'subject' => __('Nominating you for','rsvpmaker-for-toastmasters').' [wptrole] - [rsvpdate]',
		'body'    => "[custom_message]\n\n".__('To confirm','rsvpmaker-for-toastmasters').":\n[oneclicklink]\n(".__('no password required with these buttons','rsvpmaker-for-toastmasters').")",
	);
	return $template_forms;
}

add_filter( 'rsvpmaker_notification_template_forms', 'wpt_notification_forms' );

function wpt_notifications_doc() {
	if ( ! get_option( 'wp4toast_reminders_cron' ) ) {
		printf( '<p>Reminders not active - see <a href="%s">Settings -> Toastmasters</a></p>', admin_url( 'options-general.php?page=wp4toastmasters_settings' ) );
	} else {
		printf( '<p>See a <a target="_blank" href="%s">preview</a> of the Toastmasters meeting reminders (based on the next meeting).</p>', site_url( '?tm_reminders_preview' ) );
	}
	?>
<h3>Additional Codes for Toastmasters Agenda Notifications</h3>
<p>[wptrole] the member's meeting role</p>
<p>[wptagendalink] link to the meeting agenda</p>
<p>[wpt_tod] name and contact info for Toastmasters of the Day</p>
<p>[wp4t_assigned_open] agenda with contact info for participants, plus a listing of members with no assignment</p>
<p>[wpt_open_roles] open roles listing, with sign up</p>
<p>[tmlayout_main] same as info on printable agenda</p>
<p>[tmlayout_intros] speech introductions for speakers</p>
<p>[speaker_evaluator] listing of the speakers and evaluators</p>
<p>[evaluation_links] links to the online forms</p>
<p>[wpt_speakers] listing of speakers</p>
<p>[wpt_evaluators] listing of evaluators</p>
<p>[wpt_general_evaluator] general evaluator</p>
<p>[officer title="VP of Education"] name and contact info for the officer with the specified title (title must exactly match how it's specified on your settings page)</p>
<p>[wpt_voting_tool_link] link to vote counter's tools and tutorial</p>

<p>You can create a custom notification for a specific role, such as Timer or Ah Counter, by creating a custom notification template with the name of that role (as used on the agenda) in the Custom label field.</p>

	<?php
}

add_action( 'rsvpmaker_notification_templates_doc', 'wpt_notifications_doc' );

function wpt_officers() {
	global $tmagendadata;
	global $post;
	if ( isset( $tmagendadata['wpt_officers'] ) ) {
		return $tmagendadata['wpt_officers'];
	}
	$tmagendadata['wpt_officers'] = "<h3>Officers</h3>\n";

	$wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );

	foreach ( $wp4toastmasters_officer_ids as $index => $id ) {
		if ( ! $id ) {
			continue;
		}
		$title                          = $wp4toastmasters_officer_titles[ $index ];
		$userdata                       = get_userdata( $id );
		$contact                        = '';
		$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
		foreach ( $contactmethods as $name => $value ) {
			if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {
				$contact .= sprintf( "<div>%s: %s</div>\n", $value, $userdata->$name );
			}
		}
		$contact                      .= sprintf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );
		$tmagendadata['wpt_officers'] .= sprintf( '<div><strong>%s: %s %s</strong></div>', $title, $userdata->first_name, $userdata->last_name ) . $contact;
	}
	return $tmagendadata['wpt_officers'];
}

function speaker_evaluator() {
	global $tmagendadata;
	global $post;
	global $wpdb;
	if ( isset( $tmagendadata['speaker_evaluator'] ) ) {
		return $tmagendadata['speaker_evaluator'];
	}
	$tmagendadata['speaker_evaluator'] = '';
	$high                              = 0;
	$sql                               = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post->ID AND (meta_key LIKE '_role_Speaker%' OR meta_key LIKE '_role_Evaluator%') ";
	$results                           = $wpdb->get_results( $sql );
	foreach ( $results as $row ) {
		$assigned = $row->meta_value;
		$slug     = $row->meta_key;
		$p        = (int) preg_replace( '/[^0-9]/', '', $slug );
		if ( strpos( $slug, '_role_Speaker' ) !== false ) {
			$userdata      = get_userdata( $assigned );
			$speaker[ $p ] = $userdata->first_name . ' ' . $userdata->last_name;
			$high          = ( $p > $high ) ? $p : $high;
		}
		if ( strpos( $slug, '_role_Evaluator' ) !== false ) {
			$userdata = get_userdata( $assigned );
			if ( empty( $userdata ) ) {
				$evaluator[ $p ] = $assigned;
			} else {
				$evaluator[ $p ] = $userdata->first_name . ' ' . $userdata->last_name;
			}
			$high = ( $p > $high ) ? $p : $high;
		}
	}
	$tmagendadata['speaker_evaluator'] = '<table><tr><th style="width: 200px; text-align: left">Speaker</th><th style="width: 200px; text-align: left">Evaluator</th></tr>';
	for ( $i = 1; $i <= $high; $i++ ) {
		$tmagendadata['speaker_evaluator'] .= '<tr><td>';
		if ( empty( $speaker[ $i ] ) ) {
			$tmagendadata['speaker_evaluator'] .= 'Open';
		} else {
			$tmagendadata['speaker_evaluator'] .= $speaker[ $i ];
		}
		$tmagendadata['speaker_evaluator'] .= '</td><td>';
		if ( empty( $evaluator[ $i ] ) ) {
			$tmagendadata['speaker_evaluator'] .= 'Open';
		} else {
			$tmagendadata['speaker_evaluator'] .= $evaluator[ $i ];
		}
		$tmagendadata['speaker_evaluator'] .= '</td></tr>';
	}
	$tmagendadata['speaker_evaluator'] .= '</table>';
	return $tmagendadata['speaker_evaluator'];
}

function evaluation_links() {
	global $wpdb;
	global $post;
	global $tmagendadata;
	if ( isset( $tmagendadata['evaluation_links'] ) ) {
		return $tmagendadata['evaluation_links'];
	}

	$is_current                       = false;
	$tmagendadata['evaluation_links'] = '';
	$future                           = get_future_events( '', 1 );
	if ( $future ) {
		foreach ( $future as $meet ) {
			$sql     = "SELECT * FROM $wpdb->postmeta WHERE post_id=" . $post->ID . " AND meta_key LIKE '_role_Speak%' ORDER BY meta_key";
			$results = $wpdb->get_results( $sql );
			if ( $results ) {
				foreach ( $results as $row ) {
					$speaker = (int) $row->meta_value;
					if ( ! $speaker ) {
						continue;
					}
					$role                              = $row->meta_key;
					$project_index                     = get_post_meta( $meet->ID, '_project' . $role, true );
					$project                           = ( ! empty( $project_index ) ) ? get_project_text( $project_index ) : ' (project ?) ';
					$speaker_name                      = get_user_meta( $speaker, 'first_name', true ) . ' ' . get_user_meta( $speaker, 'last_name', true );
					$tmagendadata['evaluation_links'] .= sprintf( '<p><a href="%s&speaker=%d&meeting_id=%d&project=%s">%s, %s, %s</a></p>', admin_url( 'admin.php?page=wp4t_evaluations' ), $speaker, $meet->ID, $project_index, $speaker_name, $project, $meet->date );
					$text                              = get_post_meta( $meet->ID, '_title' . $role, true );
					if ( ! empty( $text ) ) {
						$tmagendadata['evaluation_links'] .= '<p>Title: ' . $text . "</p>\n";
					}
					$text = get_post_meta( $meet->ID, '_intro' . $role, true );
					if ( ! empty( $text ) ) {
						$tmagendadata['evaluation_links'] .= wpautop( $text );
					}
				}
			}
		}
	}

	return $tmagendadata['evaluation_links'];
}

function wpt_speakers() {
	global $tmagendadata;
	global $post;
	global $wpdb;
	if ( isset( $tmagendadata['wpt_speakers'] ) ) {
		return $tmagendadata['wpt_speakers'];
	}
	$tmagendadata['wpt_speakers'] = '';
	$sql                          = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post->ID AND meta_key LIKE '_role_Speaker%' ";
	$results                      = $wpdb->get_results( $sql );
	foreach ( $results as $row ) {
		$assigned                       = $row->meta_value;
		$slug                           = $row->meta_key;
		$userdata                       = get_userdata( $assigned );
		$contact                        = '';
		$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
		foreach ( $contactmethods as $name => $value ) {
			if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {
				$contact .= sprintf( "<div>%s: %s</div>\n", $value, $userdata->$name );
			}
		}
		$contact                      .= sprintf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );
		$tmagendadata['wpt_speakers'] .= sprintf( '<div><strong>Speaker: %s %s</strong></div>', $userdata->first_name, $userdata->last_name ) . $contact;
	}
	return $tmagendadata['wpt_speakers'];
}

function wpt_evaluators() {
	global $tmagendadata;
	global $post;
	global $wpdb;
	if ( isset( $tmagendadata['wpt_evaluators'] ) ) {
		return $tmagendadata['wpt_evaluators'];
	}
	$tmagendadata['wpt_evaluators'] = '';
	$sql                            = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post->ID AND meta_key LIKE '_role_Evaluator%' ";
	$results                        = $wpdb->get_results( $sql );
	foreach ( $results as $row ) {
		$assigned = $row->meta_value;
		$slug     = $row->meta_key;
		$userdata = get_userdata( $assigned );
		if ( empty( $userdata ) ) {
			// might be a guest or member record removed
			$tmagendadata['wpt_evaluators'] .= sprintf( '<div><strong>Evaluator: %s</strong></div>', $assigned );
		}
		$contact                        = '';
		$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
		foreach ( $contactmethods as $name => $value ) {
			if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {
				$contact .= sprintf( "<div>%s: %s</div>\n", $value, $userdata->$name );
			}
		}
		$contact                        .= sprintf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );
		$tmagendadata['wpt_evaluators'] .= sprintf( '<div><strong>Evaluator: %s %s</strong></div>', $userdata->first_name, $userdata->last_name ) . $contact;
	}
	return $tmagendadata['wpt_evaluators'];
}

function wpt_general_evaluator() {
	global $tmagendadata;
	global $post;
	global $tmroles;
	if ( isset( $tmagendadata['wpt_general_evaluator'] ) ) {
		return $tmagendadata['wpt_general_evaluator'];
	}
	$ge_id = get_post_meta( $post->ID, '_role_General_Evaluator_1', true );

	if ( empty( $ge_id ) ) {
		return __( 'General Evaluator not yet assigned', 'rsvpmaker-for-toastmasters' );
	}

	$userdata                       = get_userdata( $ge_id );
	$contact                        = '';
	$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
	$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
	foreach ( $contactmethods as $name => $value ) {
		if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {
			$contact .= sprintf( "<div>%s: %s</div>\n", $value, $userdata->$name );
		}
	}
	$contact .= sprintf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );

	return $tmagendadata['wpt_general_evaluator'] = sprintf( '<div><strong>General Evaluator %s %s</strong></div>', $userdata->first_name, $userdata->last_name ) . $contact;
}

function wpt_tod() {
	global $tmagendadata;
	global $post;
	if ( ! empty( $tmagendadata['wpt_tod'] ) ) {
		return $tmagendadata['wpt_tod'];
	}
	$toastmaster = get_post_meta( $post->ID, '_Toastmaster_of_the_Day_1', true );
	if ( $toastmaster ) {
		$userdata                       = get_userdata( $toastmaster );
		$toastmaster_email              = $userdata->user_email;
		$contact                        = '';
		$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
		foreach ( $contactmethods as $name => $value ) {
			if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {
				$contact .= sprintf( "<div>%s: %s</div>\n", $value, $userdata->$name );
			}
		}
		$contact .= sprintf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );

		return $tmagendadata['wpt_tod'] = sprintf( '<div><strong>Toastmaster of the Day %s %s</strong></div>', $userdata->first_name, $userdata->last_name ) . $contact;
	} else {
		return __( 'Toastmasters of the Day not yet assigned', 'rsvpmaker-for-toastmasters' );
	}
}

function wptagendalink() {
	global $tmagendadata;
	global $post;
	if ( isset( $tmagendadata['wptagendalink'] ) ) {
		return $tmagendadata['wptagendalink'];
	}
	$permalink                            = get_permalink( $post->ID );
	return $tmagendadata['wptagendalink'] = sprintf( '%s<br /><a href="%s">%s</a>', __( 'Agenda', 'rsvpmaker-for-toastmasters' ), $permalink, $permalink );
}

add_shortcode('wpt_voting_tool_link','wpt_voting_tool_link');
function wpt_voting_tool_link() {
	global $post;
	$permalink                            = get_permalink( $post->ID );
	return sprintf( '<a href="%s">%s</a> - <a href="https://www.wp4toastmasters.com/knowledge-base/how-to-use-the-vote-counters-tool/">%s</a>', add_query_arg('voting',1,$permalink), __( 'Vote Counter\'s Tool', 'rsvpmaker-for-toastmasters' ), __( 'Tutorial', 'rsvpmaker-for-toastmasters' ) );
}

class role_history {

	public $full_history;
	public $recent_history;
	public $last_held_role;
	public $user_id;
	public $away_active;

	function __construct( $user_id, $start_date = '' ) {
		global $wpdb;
		$this->recent_history = array();
		$this->last_held_role = array();
		$this->user_id        = $user_id;
		$start_date           = ( empty( $start_date ) ) ? ' CURDATE() ' : " '$start_date' ";
		$recent_history_count = get_option( 'recent_history_count' );
		if ( empty( $recent_history_count ) ) {
			$recent_history_count = 3;
		}
		$this->away_active = (int) get_user_meta( $user_id, 'status_expires', true );

		global $post;
		if ( $this->away_active && ( $this->away_active < strtotime( $start_date ) ) ) {
			$this->away_active = 0; // only positive if expireation date set and not reached
		}
		if ( ! empty( $post->ID ) && ! $this->away_active ) {
			$absences = get_post_meta( $post->ID, 'tm_absence' );
			if ( ! empty( $absences ) && in_array( $user_id, $absences ) ) {
				$this->away_active = 1;
			}
		}

		$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.post_title, a1.date as datetime, date_format(a1.date,'%Y-%m-%d') as ymddate, a2.meta_key as role
	 FROM " . $wpdb->posts . '
	 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . '.ID =a1.event
	 JOIN ' . $wpdb->postmeta . ' a2 ON ' . $wpdb->posts . ".ID =a2.post_id 
	 WHERE  a1.date < " . $start_date . " AND post_status='publish' AND a2.meta_key LIKE '_role_%' AND a2.meta_value=" . $user_id . ' 
	 ORDER BY a1.date DESC';

		$this->full_history = $wpdb->get_results( $sql );
		if ( $this->full_history ) {
			foreach ( $this->full_history as $row ) {
				$role = $this->clean_role( $row->role );
				if ( ! isset( $this->last_held_role[ $role ] ) ) {
					$this->last_held_role[ $role ] = $row->ymddate;
				}
				if ( sizeof( $this->recent_history ) < $recent_history_count ) {
					$this->recent_history[] = $role;
				}
			}
		}
	}

	function clean_role( $role ) {
		$role = str_replace('_role_','',$role);
		$role = preg_replace( '/[0-9]/', '', $role );
		$role = str_replace( '_', ' ', $role );
		return trim( $role );
	}

	function get_eligibility( $role ) {
		if ( $this->away_active ) {
			return false;
		}
		$role   = $this->clean_role( $role );
		$senior = array( 'Toastmaster of the Day', 'Evaluator', 'General Evaluator' );
		if ( in_array( $role, $senior ) ) {
			// check number of speeches
			if ( $this->get_speech_count() < 3 ) {
				return false;
			}
		}
		return ( $this->get_held_recently( $role ) ) ? false : true;
	}

	function get_speech_count() {
			global $wpdb;
			$history_table = $wpdb->base_prefix.'tm_history';
			$sql = "SELECT count(*) FROM `$history_table` WHERE role = 'Speaker' AND user_id=" . $this->user_id;
			return $wpdb->get_var( $sql );
	}

	function get_held_recently( $role ) {
		$role = $this->clean_role( $role );
		return ( in_array( $role, $this->recent_history ) ) ? true : false;
	}
	function get_last_held( $role ) {
		$role = $this->clean_role( $role );
		if ( isset( $this->last_held_role[ $role ] ) ) {
			return date( 'M j Y', strtotime( $this->last_held_role[ $role ] ) );
		} else {
			return '';
		}
	}
}

function tm_goal_form() {
	global $wpdb, $rsvp_options, $current_user;
	$history_table = $wpdb->base_prefix.'tm_history';

	$options = get_manuals_options();
	?>
<h3>Set Goal (beta)</h3>
<form action="<?php echo admin_url(); ?>" method="post">
	<p><select name="tm_goal_manual"><?php echo $options; ?></select></p>
	<p>Completed After <input type="text" placeholder="Month day, Year" name="tm_goal_date" />
	<?php rsvpmaker_nonce(); ?>
		<button>Submit</button></form>
<p>This is intended for setting a start date for goals such as earning a second Competent Communication award.</p>
	<?php
	$goals = get_user_meta( $current_user->ID, 'tm_manual_goal' );
	if ( ! empty( $goals ) ) {
		$user_id = $current_user->ID;
		$sql     = "SELECT * FROM `$history_table` WHERE user_id = $user_id AND role = 'Speaker' ORDER BY datetime";
		$results = $wpdb->get_results( $sql );
		if($results) {
		foreach ( $goals as $goal ) {
			$gp          = explode( ':', $goal );
			$goal_manual = $gp[0];
			$start       = (int) $gp[1];
			printf( '<p><strong>Goal: %s<br />after: %s</strong></h3>', $goal_manual, rsvpmaker_date( $rsvp_options['long_date'], $start ) );
			if ( $results ) {
				foreach ( $results as $row ) {
					$role       = $row->role;
					$event_date = $row->datetime;
					$rolecount  = $row->rolecount;
					$domain     = $row->domain;
					$post_id    = $row->post_id;
					$t          = rsvpmaker_strtotime( $event_date );
					if ( $t < $start ) {
						continue;
					}
					$manual   = $row->manual;
					if ( $manual != $goal_manual ) {
						continue;
					}

					if ( empty( $row->project_key ) ) {
						$speech_details = 'Project not specified';
					} else {
						$project_text   = $row->project;
						$speech_details = $manual . ': ' . $project_text;
						}
					}
					if ( ! empty( $row->title ) ) {
						$speech_details .= '<br />' . esc_html($row->title);
					}
					if ( $domain != $_SERVER['SERVER_NAME'] ) {
						$speech_details .= '<br /><em>' . esc_html($domain) . '</em>';
					}

					$speech_details = '<p>' . rsvpmaker_date( $rsvp_options['long_date'], rsvpmaker_strtotime( $event_date ) ) . '<br />' . esc_html($speech_details) . '</p>';
					echo $speech_details;
				}
			}
		}
	} // goals output

}
function tm_goal_save() {
	global $current_user;
	if ( empty( $_POST['tm_goal_date'] ) || empty( $_POST['tm_goal_manual'] ) || !wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key'))) {
		return;
	}
	add_user_meta( $current_user->ID, 'tm_manual_goal', sanitize_text_field($_POST['tm_goal_manual'] . ':' . strtotime( $_POST['tm_goal_date'] ) ));
}

add_action( 'admin_init', 'tm_goal_save' );

function rsvptoast_showbutton( $showbutton ) {
	if ( isset( $_GET['recommend_roles'] ) || is_edit_roles() ) {
		return true;
	} else {
		return $showbutton;
	}
}

add_filter( 'rsvpmaker_showbutton', 'rsvptoast_showbutton' );

function tm_absence( $atts ) {
	global $email_context;
	global $post;
	global $current_user;
	global $wpdb;
	global $rsvp_options, $email_context;

	if ( is_admin() && isset( $_GET['convert'] ) ) {
		$show = ( empty( $atts['show_on_agenda'] ) ) ? 0 : 1;
		return '<!-- wp:wp4toastmasters/absences {"show_on_agenda":"' . $show . '"} /-->';
	}
	if ( is_admin() ) {
		return;
	}
	if ( empty( $atts['show_on_agenda'] ) && ( isset( $_GET['print_agenda'] ) || isset( $_GET['email_agenda'] ) ) ) {
		return;
	}
	if ( ! is_user_member_of_blog() && empty($email_context) ) {
		return '<div><strong>Planned Absences</strong> - Only displayed for logged in members of this site</div>';
	}
	$event_table = get_rsvpmaker_event_table();
	$output = '';
	if ( isset( $_POST['add_absence'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$away_user_id = intval($_POST['away_user_id']);
		add_post_meta( $post->ID, 'tm_absence', $away_user_id );
		if(!empty($_POST['until'])) {
			$until = sanitize_text_field($_POST['until']);
			$thisdate = get_rsvp_date($post->ID);
			$results = $wpdb->get_results("SELECT event from $event_table WHERE date > '$thisdate' AND date <= '$until' ");
			foreach($results as $row)
				add_post_meta( $row->event, 'tm_absence', $away_user_id );
		}
	}

	if ( isset( $_POST['cancel_absence'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$away_user_id = intval($_POST['away_user_id']);
		delete_post_meta( $post->ID, 'tm_absence', $away_user_id );
		if(!empty($_POST['until'])) {
			$until = sanitize_text_field($_POST['until']);
			$results = $wpdb->get_results("SELECT event from $event_table WHERE  date > '$thisdate' AND date <= '$until' ");
			foreach($results as $row)
				delete_post_meta( $row->event, 'tm_absence', $away_user_id );
		}
	}

	if(isset($_POST['remove_absence'])) {
		foreach($_POST['remove_absence'] as $a) {
			$a = intval($a);
			delete_post_meta( $post->ID, 'tm_absence', $a );
		}
	}

	$absences = get_post_meta( $post->ID, 'tm_absence' );
	if ( is_array( $absences ) ) {
		$absences = array_unique( $absences );
	}

	if ( is_edit_roles() || isset( $_GET['recommend_roles'] ) || isset( $_GET['signup_sheet_editor'] ) ) {
		if ( ! empty( $absences ) && is_array( $absences ) ) {
			$output .= '<div><strong>Planned Absences</strong> : ';
			foreach ( $absences as $absent ) {
				$userdata = get_userdata( $absent );
				if(is_email_context() || isset($_GET['print_agenda']))
				$output  .= sprintf( '<div id="current_absences%s%s">%s %s  Cancel</div>', $post->ID, $absent, $userdata->first_name, $userdata->last_name );
				else
				$output  .= sprintf( '<div id="current_absences%s%s">%s %s <input type="checkbox" id="absences_remove%d" class="absences_remove" name="cancel_absences[]" post_id="%s" value="%d" /> Cancel</div>', $post->ID, $absent, $userdata->first_name, $userdata->last_name, $absent, $post->ID, $absent );
			}
			$output .= '</div>';
		}
		$output .= '<div>Add to Planned Absences list</div>';
		for ( $i = 0; $i < 4; $i++ ) {
			$select  = awe_user_dropdown( 'absences[]', 0, true );
			$select  = str_replace( '<select ', '<select id="absences' . $i . $post->ID . '" class="absences" post_id="' . $post->ID . '"', $select );
			$output .= sprintf( '<div>%s</div>', $select );
		}
		$output .= '<div id="status_absences' . $post->ID . '"></div>';
		return $output;
	}

	if ( isset( $_GET['print_agenda'] ) || isset( $_GET['email_agenda'] ) || isset( $_GET['signup_sheet_editor'] ) || $email_context || !is_user_logged_in() ) {
		return $output; // don't display button
	}

	if ( ! empty( $absences ) && is_array( $absences )  ) {
		$output .= '<div><strong>Planned Absences</strong>: ';
		$output .= '<form method="post" action="'.get_permalink().'">';
		foreach ( $absences as $absent ) {
			$userdata = get_userdata( $absent );
			if ( ! empty( $userdata->first_name ) ) {
				$output .= sprintf( '<br /><input class="remove_absences" type="checkbox" name="remove_absence[]" value="%d"> %s %s', $absent, $userdata->first_name, $userdata->last_name );
			}
		}
		$output .= '<p class="remove_absences"><button>Remove Checked</button></p></form>';
		$output .= '<p class="remove_names_line"><input type="checkbox" class="remove_names"> Remove names</p>';
		$output .= '</div>';
	}
		$time      = get_rsvpmaker_timestamp( $post->ID );
		$away      = '';
		$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
		// Array of WP_User objects.
	foreach ( $blogusers as $user ) {
		$exp = get_user_meta( $user->ID, 'status_expires', true );
		if ( empty( $exp ) ) {
			continue;
		}
		if ( $exp < $time ) {
			delete_user_meta( $user->ID, 'status_expires' );
			delete_user_meta( $user->ID, 'status' );
		} else {
			$status = get_user_meta( $user->ID, 'status', true );
			if ( ! empty( $status ) ) {
				$userdata = get_userdata( $user->ID );
				$away    .= '<br />' . $userdata->first_name . ' ' . $userdata->last_name . ' ' . $status . sprintf( ' (Expires: %s)', rsvpmaker_date( $rsvp_options['long_date'], $exp ) );
			}
		}
	}

	if ( ! empty( $away ) ) {
		$output .= '<div><strong>Away Messages:</strong>' . $away . '</div>';
	}

	$future = future_toastmaster_meetings(26);
	if('rsvpmaker' == $post->post_type)
		$o = '<option value="">'.__('Just this meeting','rsvpmaker-for-toastmasters').'</option>';
	else
		$o = '<option value="'.$future[0]->date.'">'.__('Just the next meeting','rsvpmaker-for-toastmasters').'</option>';
	foreach($future  as $f) {
		$o .= sprintf('<option value="%s">%s %s</option>',$f->datetime,__('Until','rsvpmaker-for-taostmasters'),rsvpmaker_prettydate($f->ts_start,'short_date'));
	}
	$dropdown = awe_user_dropdown( 'away_user_id', $current_user->ID, true );

	if ( ! empty( $absences ) && is_array( $absences ) && in_array( $current_user->ID, $absences ) ) {
		$output .= sprintf( '<form method="post" action="%s"><input type="hidden" name="cancel_absence" value="1"><button>%s</button><select name="until">%s</select> %s %s</form>', get_permalink(),__('Cancel My Absence','rsvpmaker-for-toastmasters'),$o,$dropdown,rsvpmaker_nonce('return') );
	} else {
		$output .= sprintf( '<form class="planned_absence_form" method="post" action="%s"><h4>%s</h4><input type="hidden" name="add_absence" value="1"><p><select name="until">%s</select> <span class="absence_user">%s</span> %s</p><p><button>%s</button></p></form>', get_permalink(),__('Planned Absence','rsvpmaker-for-toastmasters'),$o,$dropdown, rsvpmaker_nonce('return'),__('Submit','rsvpmaker-for-toastmasters') );
	}

	$output .= '<p>'. __( 'Use this to mark yourself or another member unavailable for one more meetings.', 'rsvpmaker-for-toastmasters' ).'</p>';

	return $output;
}

function tm_absences_json() {
global $wpdb;
$event_table = get_rsvpmaker_event_table();
$operation = '';
$data = array();
$json = file_get_contents('php://input');
if($json) {
	$data = json_decode($json);
	$operation = $data->operation;
}

if(isset($_GET['post_id']))
	$post_id = intval($_GET['post_id']);
$status = '';

if ( 'add' == $operation ) {
	$away_user_id = intval($data->ID);
	add_post_meta( $post_id, 'tm_absence', $away_user_id );
	if(!empty($data->until)) {
		$until = sanitize_text_field($data->until);
		update_user_meta($away_user_id,'tm_absence_until',$until);
		$thisdate = get_rsvp_date($post_id);
		$results = $wpdb->get_results("SELECT event from $event_table WHERE date > '$thisdate' AND date <= '$until' ");
		foreach($results as $row) {
			add_post_meta( $row->event, 'tm_absence', $away_user_id );
			$status .= 'add '.$row->event.' ';
		}
	}
}

if ( 'remove' == $operation ) {
	$away_user_id = intval($data->ID);
	$status .= 'attempt to remove '.$away_user_id.' post_id '.$post_id;
	delete_post_meta( $post_id, 'tm_absence', $away_user_id );
	delete_user_meta($away_user_id,'tm_absence_until');
	if(!empty($data->until)) {
		$until = sanitize_text_field($data->until);
		$results = $wpdb->get_results("SELECT event from $event_table WHERE  date > '$thisdate' AND date <= '$until' ");
		foreach($results as $row)
			delete_post_meta( $row->event, 'tm_absence', $away_user_id );
	}
}

$absences = get_post_meta( $post_id, 'tm_absence' );
if ( is_array( $absences ) ) {
	$absences = array_unique( $absences );
}
$result = [];
foreach($absences as $ab) {
	$result[] = array('ID'=>$ab,'name' => get_member_name($ab),'until'=> get_user_meta($ab,'tm_absence_until',true),'operation' => $operation, 'status' => $status, 'request' => $data);
}
return $result;
}

function toastmasters_role_signup() {
	global $wpdb;
	if ( isset( $_REQUEST['tm_ajax'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$aj = sanitize_text_field($_REQUEST['tm_ajax']);
		if ( $aj == 'role' ) {
			$user_id = intval($_POST['user_id']);
			if ( ! empty( $_POST['guest'] ) ) {
				$user_id = sanitize_text_field( $_POST['guest'] );
			}
			$role    = sanitize_text_field($_POST['role']);
			$post_id = (int) $_POST['post_id'];
			if(wp4t_hour_past($post_id))
				return __('Role data associated with this event has now been archived and cannot be updated through the front end of the website.','rsvpmaker-for-toastmasters');
			tm_in_person_update($post_id);
			do_action('toastmasters_agenda_change',$post_id,$role,$user_id,get_post_meta($post_id,$role,true),0);
			update_post_meta( $post_id, $role, $user_id );
			if ( strpos( $role, 'Speaker' ) ) {
				update_post_meta( $post_id, '_manual' . $role, sanitize_text_field(strip_tags( $_POST['_manual'][ $role ] ) ));
				update_post_meta( $post_id, '_project' . $role, sanitize_text_field( strip_tags( $_POST['_project'][ $role ] ) ) );
				update_post_meta( $post_id, '_title' . $role, sanitize_text_field( strip_tags( stripslashes( $_POST['_title'][ $role ] ) ) ) );
				$intro = $_POST['_intro'][ $role ];
				$intro=strip_tags($intro,'<p><br><strong><em><a>');
				update_post_meta( $post_id, '_intro' . $role, wp_kses_post( stripslashes( $intro ) ) );
			}
			$o = 'Assigned to: ' . get_member_name( $user_id );
			if(isset($_REQUEST['action']))
				return $o;
			foreach ( $_POST as $name => $value ) {
				if ( ( $name == 'user_id' ) || ( $name == 'post_id' ) || ( $name == 'timelord' ) || ( $name == 'editor_assign' ) ) {
					continue;
				}
				if ( is_array( $value ) ) {
					foreach ( $value as $v ) {
						$showv = sanitize_text_field( $v );
					}
				} else {
					$showv = sanitize_text_field($value);
				}

				if ( ! empty( $showv ) ) {
					if ( strpos( $name, 'project' ) ) {
						$showv = get_project_text( $showv );
					}
					$o .= '<br />' . clean_role( $name ) . ': ' . $showv;
				}
			}
			$actiontext = __( 'signed up for', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $role );
			do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $user_id );
			$date = get_rsvp_date( $post_id );

			$startfrom = " '$date' ";

			$sql  = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.date as datetime, a1.date as datetime, date_format(a1.date,'%M %e, %Y') as date
		 FROM " . $wpdb->posts . '
		 JOIN ' . get_rsvpmaker_event_table() . ' a1 ON ' . $wpdb->posts . ".ID =a1.event
		 WHERE a1.date > " . $startfrom . " AND post_status='publish' AND (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ORDER BY a1.date ";
			$next = $wpdb->get_row( $sql );
			if ( $next && ! isset( $_REQUEST['editor_assign'] ) ) {
				$o .= sprintf( '<p>Would you also like to sign up for <a href="%s">%s</a>?</p>', get_permalink( $next->ID ), $next->date );
			}
			return $o;
		} elseif ( ($aj == 'remove_role') && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			$role  = sanitize_text_field($_POST['remove_role']);
			$user_id = sanitize_text_field($_POST['user_id']);
			$post_id = (int) $_POST['post_id'];
			do_action('toastmasters_agenda_change',$post_id,$role,0,get_post_meta($post_id,$role,true),0);
			update_post_meta( $post_id, $role, 0 );
			if ( strpos( $role, 'peaker' ) ) {
				delete_post_meta( $post_id, '_manual' . $role );
				delete_post_meta( $post_id, '_project' . $role );
				delete_post_meta( $post_id, '_title' . $role );
				delete_post_meta( $post_id, '_intro' . $role );
			}
			$actiontext = __( 'withdrawn: ', 'rsvpmaker-for-toastmasters' ) . ' ' . clean_role( $role );
			do_action( 'toastmasters_agenda_notification', $post_id, $actiontext, $user_id );
			return $actiontext;
		}
	}
}

function agenda_note_convert( $atts, $content ) {
	if ( ! empty( $atts['editable'] ) ) {
		return '<!-- wp:wp4toastmasters/agendaedit {"editable":"' . $atts['editable'] . '"} /-->';
	}
	if ( $atts['agenda_display'] == 'web' ) {
		return '<!-- wp:wp4toastmasters/signupnote -->
<p class="wp-block-wp4toastmasters-signupnote">' . trim( $content ) . '</p>
<!-- /wp:wp4toastmasters/signupnote -->';
	} elseif ( $atts['agenda_display'] == 'both' ) {
		return '<!-- wp:paragraph -->
<p>' . trim( $content ) . '</p>
<!-- /wp:paragraph -->';
	} else {
		if ( empty( $atts['time_allowed'] ) ) {
			$atts['time_allowed'] = '';
		}
		$u = rand();
		return '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"' . $atts['time_allowed'] . '","uid":"note' . $u . '"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">' . trim( strip_tags( $content ) ) . '</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';
	}
}

function toastmaster_short_convert( $atts ) {

	$toast_roles = array(
		'Ah Counter',
		'Body Language Monitor',
		'Evaluator',
		'General Evaluator',
		'Grammarian',
		'Humorist',
		'Speaker',
		'Topics Master',
		'Table Topics',
		'Timer',
		'Toastmaster of the Day',
		'Vote Counter',
	);

	if ( ! in_array( $atts['role'], $toast_roles ) ) {
		$atts['custom_role'] = $atts['role'];
		$atts['role']        = 'custom';
	}
	return '<!-- wp:wp4toastmasters/role ' . json_encode( $atts ) . ' /-->';
}

function wpt_embed_agenda( $atts ) {
	if ( isset( $atts['id'] ) ) {
		$id = $atts['id'];
	} else {
		$f = future_toastmaster_meetings( 1 );
		if ( empty( $f ) ) {
			return;
		}
		$id = $f[0];
	}
	$permalink  = get_permalink( $id );
	$permalink .= ( strpos( $permalink, '?' ) ) ? '&' : '?';
	$style      = ( empty( $atts['style'] ) ) ? 'height: 1000px; width: 100%;' : $atts['style'];
	return sprintf( '<iframe src="%sprint_agenda=1&no_print=1" style="%s"></iframe>', $permalink, $style );
}


function agenda_note_upgrade_helper( $matches ) {
	if ( empty( $matches[1] ) ) {
		$props = '{"uid":"note' . rand( 100, 10000 ) . '"}';
	} else {
		$props = $matches[1];
		if ( ! strpos( $props, '"uid"' ) ) {
			$props = str_replace( '}', ',"uid":"note' . rand( 100, 10000 ) . '"}', $props );
		}
		$props = str_replace( ',"className":"wp-block-wp4toastmasters-agendanoterich"', '', $props );
	}

	return sprintf(
		'<!-- wp:wp4toastmasters/agendanoterich2 %s -->
<p class="wp-block-wp4toastmasters-agendanoterich2">%s</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->',
		$props,
		trim( strip_tags( $matches[0], '<strong><em><a>' ) )
	);
}

if ( strtotime( '2018-12-31' ) > time() ) {
	add_action( 'admin_init', 'agenda_note_upgrade' );
}

function agenda_note_upgrade() {
	if ( ! empty( $_SESSION['did_agenda_note_upgrade'] ) ) {
		return;
	}
	$_SESSION['did_agenda_note_upgrade'] = 1;
	global $wpdb;
	$f = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE (post_content LIKE '%wp4toastmasters/agendanoterich %' OR post_content LIKE '%wp4toastmasters/agendanote%') AND post_type='rsvpmaker' " );
	// echo '<div>check agendas '.var_export($f,true).'</div>';
	if ( empty( $f ) ) {
		return;
	}
	foreach ( $f as $r ) {
		$content = $r->post_content;
		$content = preg_replace_callback( '/\<.+wp\:wp4toastmasters\/agendanoterich ({[^}]+})[^<]+<p[^>]+>.+<\/p>[^<]+<!-- \/wp:wp4toastmasters\/agendanoterich -->/', 'agenda_note_upgrade_helper', $content );

		$pattern = '/<!-- wp:wp4toastmasters\/agendanote ({[^}]+}){0,1}[^!]+!-- \/wp:wp4toastmasters\/agendanote -->/s';
		$content = preg_replace_callback( $pattern, 'agenda_note_upgrade_helper', $content );
		$sql     = $wpdb->prepare( "UPDATE $wpdb->posts SET post_content=%s WHERE ID=%d", $content, $r->ID );
		$wpdb->query( $sql );
	}
}


register_deactivation_hook( __FILE__, 'wptoast_deactivation' );

function wptoast_deactivation() {
	wp_clear_scheduled_hook( 'wp4toast_reminders_cron' );
	wp_clear_scheduled_hook( 'wp4toast_reminders_dst_fix' );
}

function tm_branded_image( $att ) {
	if ( is_array( $att ) ) {
		$image = $att['image'];
	} else {
		$image = $att;
	}
	// if($image=='agenda-rays.png')
		return '<img src="https://toastmost.org/tmbranding/agenda-rays.png" />';

	if ( isset( $_GET['reset'] ) ) {
		delete_option( $image );
	}

	if ( strpos( $_SERVER['SERVER_NAME'], 'toastmost.org' ) ) {
		$newurl = 'https://toastmost.org/tmbranding/' . $image;
	} else {
		$newurl = get_option( $image );
	}

	if ( isset( $_GET['retrieve'] ) ) {
		$wp_upload_dir = wp_upload_dir();
		$url           = 'http://toastmost.org/tmbranding/' . $image;
		$file_path     = $wp_upload_dir['path'] . '/' . $image;
		$newurl        = $wp_upload_dir['url'] . '/' . $image;
		$myhttp        = new WP_Http();
		$result        = $myhttp->get(
			$url,
			array(
				'filename' => $file_path,
				'stream'   => true,
			)
		);
		if ( is_wp_error( $result ) ) {
			printf( '<div class="error">%s: %s</div>', __( 'Error retrieving', 'lectern' ), $url );
			return;
		}

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$parent_post_id = 0;

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $file_path ), null );

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $newurl,
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $file_path, $parent_post_id );

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		update_option( $image, $newurl );
	}
	if ( empty( $newurl ) ) {
		return sprintf( 'If you are authorized to use the Toastmasters logo, <a href="%s">click to download</a>.', add_query_arg( 'retrieve', '1', site_url( $_SERVER['REQUEST_URI'] ) ) );
	} elseif ( $image == 'agenda-rays.png' ) {
		return '<img src="' . $newurl . '" width="700" height="79">';
	} elseif ( $image == 'toastmasters-75.png' ) {
		return '<img src="' . $newurl . '" width="75" height="65">';
	}
}

function edit_signups_role( $post_id = 0 ) {
	global $post, $current_user;
	if ( ! $post_id ) {
		$post_id = $post->ID;
	}
	$signup_roles = get_option( 'edit_signups_meeting_roles' );
	if ( empty( $signup_roles ) || ! is_array( $signup_roles ) ) {
		return false;
	}
	foreach ( $signup_roles as $role => $key ) {
		$hit = (int) get_post_meta( $post_id, $key, true );
		if ( $current_user->ID == $hit ) {
				return true;
		}
	}
	return false;
}

function wpt_contributor_notification( $new_status, $old_status, $post ) {
	if ( ( $new_status != $old_status ) && ( $new_status == 'pending' ) ) {
		global $current_user;
		$result                   = '';
		$contributor_notification = get_option( 'wpt_contributor_notification' );
		if ( empty( $contributor_notification ) ) {
			$contributor_notification = get_option( 'admin_email' );
		}
			$emails = explode( ',', $contributor_notification );
		foreach ( $emails as $email ) {
			$email = trim( $email );
			if ( rsvpmail_contains_email( $email ) ) {
					mail( $email, 'Contributor Post: ' . $post->post_title, admin_url( 'post.php?action=edit&post=' . $post->ID ), 'From: ' . $current_user->user_email );
			}
		}
	}
}

add_action( 'transition_post_status', 'wpt_contributor_notification', 10, 3 );

function wp4t_cron_nudge_setup() {
	wp_unschedule_hook( 'wp4t_reminders_nudge' );
	wp_schedule_event( strtotime( 'tomorrow 1 am' ), 'daily', 'wp4t_reminders_nudge' );
}
add_action( 'wp4t_reminders_nudge', 'wp4t_reminders_nudge' );
function wp4t_reminders_nudge() {
	wp_suspend_cache_addition(true);
	$future = future_toastmaster_meetings( 2 );

	$temp = get_option( 'wp4toast_reminder' );
	if ( ! empty( $temp ) ) {
		$reminders[] = $temp;
	}
	$temp = get_option( 'wp4toast_reminder2' );
	if ( ! empty( $temp ) ) {
		$reminders[] = $temp;
	}
	wp_unschedule_hook( 'wp4toast_reminders_intro' );
	$temp = get_option( 'wp4toast_reminder_intros' );
	if ( ! empty( $temp ) ) {
		$hours = $temp;
		foreach ( $future as $meeting ) {
			$time = $meeting->datetime;
				$string = $time . ' -' . $hours;
				$timestamp = rsvpmaker_strtotime( $string );
				$hours = trim( str_replace( 'hours', '', $hours ) );
				if ( $timestamp > time() ) {
					$result = wp_schedule_single_event( $timestamp, 'wp4toast_reminders_intros', array( $meeting->ID,$hours ) );
				}
		}
	}

	if ( empty( $reminders ) ) {
		wp_suspend_cache_addition(false);
		return;
	}

	wp_unschedule_hook( 'wp4toast_reminders_cron' );
	foreach ( $future as $meeting ) {
		$time = $meeting->datetime;
		foreach ( $reminders as $hours ) {
			$string = $time . ' -' . $hours;
			$timestamp = rsvpmaker_strtotime( $string );
			$hours = trim( str_replace( 'hours', '', $hours ) );
			if ( $timestamp > time() ) {
				$result = wp_schedule_single_event( $timestamp, 'wp4toast_reminders_cron', array( $meeting->ID . ':' . $hours ) );
			}
		}
	}
	if(get_option('wpt_evaluation_reminder')) {
		$timestamp = rsvpmaker_strtotime( $time . ' +4 hours' );
		wp_schedule_single_event( $timestamp, 'wpt_evaluation_reminder');	
	}
	wp_suspend_cache_addition(false);
}

if ( ! wp_is_json_request() ) {
	add_shortcode( 'wpt_open_roles', 'wpt_open_roles' );
	add_shortcode( 'contest_demo', 'contest_demo' );
	add_shortcode( 'agenda_role', 'toastmaster_short' );
	add_shortcode( 'toastmaster', 'toastmaster_short' );
	add_shortcode( 'agenda_note', 'agenda_note' );
	add_shortcode( 'officer', 'toastmasters_officer_single' );
	add_shortcode( 'toastmaster_officers', 'toastmaster_officers' );
	add_shortcode( 'stoplight', 'stoplight_shortcode' );
	add_shortcode( 'awesome_members', 'awesome_members' );
	add_shortcode( 'signup_sheet', 'signup_sheet' );
	add_shortcode( 'themewords', 'themewords' );
	add_shortcode( 'jstest', 'jstest' );
	add_shortcode( 'club_news', 'club_news' );
	add_shortcode( 'members_only', 'members_only' );
	add_shortcode( 'tmlayout_club_name', 'tmlayout_club_name' );
	add_shortcode( 'tmlayout_tag_line', 'tmlayout_tag_line' );
	add_shortcode( 'tmlayout_post_title', 'tmlayout_post_title' );
	add_shortcode( 'tmlayout_meeting_date', 'tmlayout_meeting_date' );
	add_shortcode( 'tmlayout_sidebar', 'tmlayout_sidebar' );
	add_shortcode( 'tmlayout_main', 'tmlayout_main' );
	add_shortcode( 'tmlayout_intros', 'speech_intros_shortcode' );
	add_shortcode( 'wpt_officers', 'wpt_officers' );
	add_shortcode( 'speaker_evaluator', 'speaker_evaluator' );
	add_shortcode( 'evaluation_links', 'evaluation_links' );
	add_shortcode( 'wpt_speakers', 'wpt_speakers' );
	add_shortcode( 'wpt_evaluators', 'wpt_evaluators' );
	add_shortcode( 'wpt_general_evaluator', 'wpt_general_evaluator' );
	add_shortcode( 'wpt_tod', 'wpt_tod' );
	add_shortcode( 'wptagendalink', 'wptagendalink' );
	add_shortcode( 'wp4t_assigned_open', 'wp4t_assigned_open' );
	add_shortcode( 'tm_absence', 'tm_absence' );
	add_shortcode( 'wpt_embed_agenda', 'wpt_embed_agenda' );
	add_shortcode( 'tm_branded_image', 'tm_branded_image' );
	add_shortcode( 'tm_member_application', 'tm_member_application' );
}

add_action( 'wp_head', 'wpt_richtext' );
function wpt_richtext() {
	global $post;
	if ( empty( $post->post_content ) ) {
		return;
	}
	if ( ! strpos( $post->post_content, 'wp:wp4toastmasters' ) && ! strpos( $post->post_content, 'agenda_role' ) ) {
		return;
	}

	echo '<script>
tinymce.init({
	selector:"textarea.mce",plugins: "link",
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
</script>';
}

function rsvpmaker4t_deactivate() {
	wp_unschedule_hook( 'wp4toast_reminders_cron' );
	wp_unschedule_hook( 'wp4toast_reminders_dst_fix' );
	wp_unschedule_hook( 'wp4t_reminders_nudge' );
}
register_deactivation_hook( __FILE__, 'rsvpmaker4t_deactivate' );

function profile_photo_anchor() {
	?>
<p id="profilephoto">The Avatar image is your profile photo for the member page.</p>
	<?php
}

add_action( 'wpua_before_avatar_admin', 'profile_photo_anchor' );

function toastmasters_shared_templates() {
	?>
<p>For shared Toastmasters meeting templates, see <a href="https://wp4toastmasters.com/shared-templates/" target="_blank">https://wp4toastmasters.com/shared_templates/</a></p>
	<?php
}

add_action( 'import_shared_template_prompt', 'toastmasters_shared_templates' );

function wp4t_agenda_display_context($atts, $content) {
	global $email_context;
	if(isset($_GET['agenda_email']))
		$email_context = true;
	$agenda_context = (isset($_GET['print_agenda']) || isset($_GET['agenda_email']));
	$print_context = isset($_GET['print_agenda']);
	$anon_context = (!$email_context && !is_user_member_of_blog());
	if(isset($atts['emailContext']) && (false == $atts['emailContext']) && $email_context )
		return;
	if(isset($atts['agendaContext']) && (false == $atts['agendaContext']) && $agenda_context )
		return;
	if(isset($atts['webContext']) && (false == $atts['webContext']) && !$print_context && !$agenda_context && !$email_context )
		return;
	if(isset($atts['printContext']) && (false == $atts['printContext']) && $print_context )
		return;
	if(isset($atts['anonContext']) && (false == $atts['anonContext']) && $anon_context )
		return;
	return $content;
}

add_action('wp4t_log_notify','wp4t_log_notify');
function wp4t_log_notify($post_id, $test = false) {
	global $post;
	if(!$post_id)
		$post_id = $post->ID;
	global $wpdb, $rsvp_options;
	$emails = get_option('wpt_notification_emails');
	$leader_notify = get_option('wpt_notification_leader'); // 1 or 0 if set;
	$titles = get_option('wpt_notification_titles');
	if(!empty($emails)) {
		$send = explode(',',$emails);
	}
	else
		$send = array();
	if($leader_notify) {
		$meeting_leader = get_post_meta( $post_id, '_Toastmaster_of_the_Day_1', true );
		if(empty($meeting_leader))
			$meeting_leader = get_post_meta( $post_id, '_Contest_Master_1', true );
		if(!empty($meeting_leader))
			$user = get_userdata($meeting_leader);
		if(isset($user->user_email))
			$send[] = $user->user_email;
	}
	if($titles && is_array($titles)) {
		foreach($titles as $title)
			$send[] = toastmasters_officer_email_by_title($title);
	}
	else
		$send[] =  toastmasters_officer_email_by_title('VP of Education');
	$send = array_unique($send);
	if($test) {
		$output = var_export($send,true);
		$output .= ' titles '.var_export($titles,true);
		$output .= ' post_id '.$post_id;
		$output .= ' notify leader '.$leader_notify;
		$output .= ' meeting leader '.$meeting_leader;
		return $output;
	}
	else {
	$mail['from'] = get_bloginfo('admin_email');
	$mail['subject'] = 'Role signups for '.rsvpmaker_date($rsvp_options['long_date'],get_rsvpmaker_timestamp( $post_id ));
	$mail['html'] = '';
	$sql = "select meta_value from $wpdb->postmeta where meta_key='_activity' AND post_id=$post_id ORDER by meta_id DESC ";
	$results = $wpdb->get_results($sql);
	foreach($results as $row)
		$mail['html'] .= '<div>'.$row->meta_value.'</div>'."\n";
	$hash = hash('crc32c',$mail['html']);
	$check_sent = get_post_meta($post_id,'wp4t_log_notify_sent',true);
	if($check_sent == $hash) {
		mail(postmark_admin_email(),'duplicate notification blocked','blog: '.get_currnt_blog_id().' post: '.$post_id);
		return;
	}
	update_post_meta($post_id,'wp4t_log_notify_sent',$hash);
	foreach($send as $to) {
		$to = trim($to);
		$mail['to'] = $to;
		rsvpmailer( $mail );	
	}
	}
}

function tmlayout_role_output($atts) {
$content = '<table class="roletable">
<tr><th>Speaker</th><th>Speech Title</th><th>Evaluator</th></div>
[tmlayout_role_iterator role="Speaker"]
<tr><td>{Speaker}</td><td>{Title}</td><td>{Evaluator}</td></tr>
[/tmlayout_role_iterator]
</table>
';
return do_shortcode($content);
}

function tmlayout_role_iterator($atts, $content) {
global $post, $role_data, $role_count;
$role = $atts['role'];
if(empty($role_data))
	$role_data = wpt_blocks_to_data($post->post_content);
$role_count = $role_data[$role.'1']['count'];
$output = '';
for($i = 1; $i <= $role_count; $i++){
	$row = $content;
	$key = wp4t_fieldbase($role,$i);
	$id = get_post_meta($post->ID,$key,true);
	$name = get_member_name($id);
	$row = str_replace("{".$role."}",$name,$row);
	$row = str_replace("{Role}",$name,$row);
	$title = $intro = $path = $project = '';
	if('Speaker' == $role) {
		$key = '_title_role_Speaker_'.$i;
		$title = get_post_meta($post->ID,$key,true);
		$key = '_intro_role_Speaker_'.$i;
		$intro = get_post_meta($post->ID,$key,true);	
		$key = '_manual_role_Speaker_'.$i;
		$path = get_post_meta($post->ID,$key,true);
		$key = '_project_role_Speaker_'.$i;
		$project_key = get_post_meta($post->ID,$key,true);
		if(!empty($project_key))
			$project = get_project_text($project_key);
		}
	$row = str_replace("{Title}",$title,$row);
	$row = str_replace("{Intro}",$intro,$row);
	$row = str_replace("{Path}",$path,$row);
	$row = str_replace("{Project}",$project,$row);
	preg_match('/\{([^}]+)\}/',$row,$match);
	if(isset($match[1]))
	{
		$role2 = $match[1];
		$key = wp4t_fieldbase($role2,$i);
		$id = get_post_meta($post->ID,$key,true);
		$name = get_member_name($id);
		$row = str_replace($match[0],$name,$row);
	}
	//print_r($match);
	$output .= $row;
}
return $output;//'<pre>'.var_export($role_data,true).'</pre>';
}

function tm_role_member($atts) {
	global $post, $role_data, $role_count;
	$key = wp4t_fieldbase($role,$role_count);
	$assigned = get_post_meta($post->ID,$key,true);
	return get_member_name($assigned);
}

function tm_speech_title($atts) {
	global $post, $role_data, $role_count;
	$key = '_title_Speaker_'.$role_count;
	return get_post_meta($post->ID,$key,true);
}

add_shortcode('tmlayout_speech_title','tmlayout_speech_title');
add_shortcode('tmlayout_speech_project','tmlayout_speech_project');
add_shortcode('tmlayout_speech_path','tmlayout_speech_path');
add_shortcode('tmlayout_role_member','tmlayout_role_member');
add_shortcode('tmlayout_role_name','tmlayout_role_name');
add_shortcode('tmlayout_role_iterator','tmlayout_role_iterator');
add_shortcode('tmlayout_role_output','tmlayout_role_output');

function tm_attend_in_person($atts) {
global $current_user,$post, $wpdb;
$output = '';
$in_person = get_post_meta($post->ID,'tm_attend_in_person'); // returns array
if(empty($in_person))
	$in_person = array();
if(isset($_GET['rsvp']))
	{
		$rsvp_id = intval($_GET['rsvp']);
		$sql = "SELECT details from ".$wpdb->prefix."rsvpmaker WHERE id=$rsvp_id";
		$details = unserialize($wpdb->get_var($sql));
		if(isset($details['attending_in_person'])) {
			$name = '';
			if(isset($details['first']))
				$name = $details['first'].' ';
			if(isset($details['last']))
				$name .= $details['last'].' ';
			if( !in_array($name, $in_person) ) {
				add_post_meta($post->ID,'tm_attend_in_person',$name);
				$in_person[] = $name;
			}
		}
		//$output .= var_export($details,true);
	}
if(isset($_POST['remove_in_person'])) {
	foreach($_POST['remove_in_person'] as $person) {
		$person = sanitize_text_field($person);
		delete_post_meta($post->ID,'tm_attend_in_person',$person);
		if (($key = array_search($person, $in_person)) !== false) {
			unset($in_person[$key]);
		}
	}
}

$in_person = tm_in_person_update($post->ID, $in_person);

if(isset($_POST['in_person_other']) && is_numeric($_POST['in_person_other'])) {
	$other = intval($_POST['in_person_other']);
	if(($other > 0) && !in_array($other, $in_person) ) {
		add_post_meta($post->ID,'tm_attend_in_person',$other);
		$in_person[] = $other;	
	}
}

$checked = (in_array($current_user->ID, $in_person)) ? ' checked="checked" ' : '';
$limit = isset($atts['limit']) ? intval($atts['limit']) : 0;
$limit_text = ($limit) ? '(Limit: '.$limit.' people)' : '';

$output .= sprintf('<h3>%s %s</h3>',__('In person attendance','rsvpmaker-for-toastmasters'),$limit_text);
if(!is_email_context())
{
if(is_club_member()) {
	$dropdown = awe_user_dropdown( 'in_person_other', 0, true, $openlabel = __('Add another_member','rsvpmaker-for-toastmasters') );
	$output .= sprintf('<form action="%s" method="post"><p><input type="checkbox" name="in_person_yes" value="%d" %s> %s</p><p>%s</p><input type="hidden" name="in_person_check"> <button>%s</button></p></form>',get_permalink($post->ID),$current_user->ID, $checked,__('I plan to attend in person','rsvpmaker-for-toastmasters'),$dropdown,__('Submit','rsvpmaker-for-toastmasters'));
}
else {
	$output .= '<p>Members please login to see list</p>';
	return $output;
}
	
}

$attendees = sizeof($in_person);
$attendee_list = '';
if($attendees) {
	foreach($in_person as $person) {
		if(is_email_context())
			$attendee_list .= '<div>'.get_member_name($person).'</div>';
		else
			$attendee_list .= '<div><input type="checkbox" name="remove_in_person[]" class="remove_in_person" value="'.$person.'" /> '.get_member_name($person).'</div>';
	}
}
if(!empty($attendee_list))
	if(is_email_context())
		$output .= sprintf('<p>%s (%d)</p>%s',__('In-person attendees','rsvpmaker-for-toastmasters'),$attendees,$attendee_list);
	else
		$output .= sprintf('<form method="post" action="%s"><p>%s (%d)</p>%s<p class="remove_in_person"><button>%s</button></p></form><p class="remove_names_line"><input type="checkbox" class="remove_names"> Remove names</p>',get_permalink($post->ID),__('In-person attendees','rsvpmaker-for-toastmasters'),$attendees,$attendee_list,__('Remove Checked','rsvpmaker-for-toastmasters'));
return $output;
}

function tm_attend_in_person_json($data) {
	global $current_user,$post, $wpdb;
	$output = '';
	$operation = (isset($data->operation)) ? $data->operation : '';
	$post_id = $_GET['post_id'];
	$in_person = get_post_meta($post_id,'tm_attend_in_person'); // returns array
	if(empty($in_person))
		$in_person = array();
	if('remove' == $operation) {
			delete_post_meta($post_id,'tm_attend_in_person',$data->ID);
			if (($key = array_search($person, $in_person)) !== false) {
				unset($in_person[$key]);
			}
	}
	elseif('add' == $operation) {
		add_post_meta($post_id,'tm_attend_in_person',$data->ID);
		$in_person[] = $data->ID;
	}

	//$in_person = tm_in_person_update($post_id, $in_person);
	
	$attendee_list = [];
	if(sizeof($in_person)) {
		foreach($in_person as $person) {
			if(is_numeric($person))
				$attendee_list[] = array('ID'=>$person,'name'=>get_member_name($person));
			else
				$attendee_list[] = array('ID'=>$person,'name'=>$person);
		}
	}
	$response = array('hybrid'=>$attendee_list,'memberlist'=> []);
	$response['memberlist'][] = array('value'=>'0','label'=>'Choose Member');
	$members = get_club_members();
	foreach($members as $m)
		$response['memberlist'][] = array('value'=>$m->ID,'label'=>$m->display_name);

	return $response;
}

add_shortcode('tm_attend_in_person','tm_attend_in_person');

function tm_in_person_checkbox($user_id = 0) {
	global $current_user,$post, $wpdb, $in_person_checkbox;
	if(!empty($in_person_checkbox))
		return $in_person_checkbox;
	$in_person = get_post_meta($post->ID,'tm_attend_in_person'); // returns array
	if(empty($in_person))
		$in_person = array();
	if(isset($current_user->ID))
		$user_id = $current_user->ID;

	$checked = (in_array($user_id, $in_person)) ? ' checked="checked" ' : '';
	$in_person_checkbox = sprintf('<div><input type="checkbox" name="in_person_yes" value="%d" %s> %s. %s %d <input type="hidden" name="in_person_check" value="1" ></div>',$user_id, $checked,__('I plan to attend in person','rsvpmaker-for-toastmasters'),__('In-person attendance so far:','rsvpmaker-for-toastmasters'), sizeof($in_person));
	return $in_person_checkbox;
}

function tm_in_person_update($post_id = 0, $in_person = array()) {
	if(empty($in_person))
		$in_person = get_post_meta($post_id,'tm_attend_in_person'); // returns array
	if(empty($in_person) || !is_array($in_person))
		$in_person = array();
	
	if(isset($_POST['in_person_check'])) {
		if(isset($_POST['in_person_yes']) ) {
			$user_id = intval($_POST['in_person_yes']);
			if( !in_array($user_id, $in_person) ) {
				add_post_meta($post_id,'tm_attend_in_person',$user_id);
				$in_person[] = $user_id;	
			}
		}
		else {
			delete_post_meta($post_id,'tm_attend_in_person',$user_id);
			if (($key = array_search($user_id, $in_person)) !== false) {
				unset($in_person[$key]);
			}
		}
	}
	return $in_person;
}

function rsvp_attend_in_person($atts) {
if(wp_is_json_request())
	return;
global $current_user,$post;
$in_person = get_post_meta($post->ID,'tm_attend_in_person'); // returns array
if(empty($in_person))
	$in_person = array();
$output = sprintf('<input type="checkbox" name="profile[attending_in_person]" value="1"> %s',__('I plan to attend in person','rsvpmaker-for-toastmasters'));
$attendees = sizeof($in_person);
$list = array();
if($attendees) {
	$output .= sprintf('. %s: %s',__('In-person attendees','rsvpmaker-for-toastmasters'),$attendees);
}
return '<p>'.$output.'</p>';
}

add_shortcode('rsvp_attend_in_person','rsvp_attend_in_person');

function wpt_clipboard_links() {
	$meetings = future_toastmaster_meetings(3);
	$output = '';
	foreach($meetings as $meeting) {
		$link = get_permalink($meeting->ID).'?clipboard=1#clipboard';
		$output .= sprintf('<li><a href="%s">%s: %s</a></li>',$link, __( 'Easy Online Meeting Signup', 'rsvpmaker-for-toastmasters' ),rsvpmaker_date('M j',intval($meeting->ts_start)));	
	}
	return $output;
}

function wpt_clipboard() {
	ob_start();
	global $current_user, $rsvp_options, $post;
	$post_id = $post->ID;
	$event = get_rsvpmaker_event($post_id);
	$t = intval($event->ts_start);
	$clipboard = get_post_meta($post_id,'wpt_clipboard_enabled',true);
	if(empty($clipboard))
		$clipboard = array('code' => '', 'expiration' => 0);
	$code = isset($_REQUEST['clipboard']) ? sanitize_text_field($_REQUEST['clipboard']) : '';
	$member = isset($_GET['member']) ? intval($_GET['member']) : 0;
	$d = rsvpmaker_date($rsvp_options['long_date'],$t);
	echo '<div id="clipboard" style="border: thin solid gray; border-radius: 25px; padding:25px;padding-top: 100px;padding-bottom: 100px;">';
	printf('<h3>Role Signup for %s</h3>',$d);
	$action = get_permalink()."?clipboard=".$clipboard['code'].'#clipboard';

	if(!empty($_POST['member']) && rsvpmaker_verify_nonce()) {
		$member = intval($_POST['member']);
		$role = sanitize_text_field($_POST['role']);
		if($role == 'tm_absence') {
			add_post_meta($post_id,'tm_absence',$member);
			echo '<h1>Planned absence recorded</h1><p>We will miss you!</p>';
			return ob_get_clean();
		}
		$meeting = get_post($post_id);
		$data = wpt_blocks_to_data( $meeting->post_content );
		$success = false;
		foreach ( $data as $row => $item ) {
			if ( $role == $item['role'] ) {
				$count = (int) $item['count'];
				for ( $i = 1; $i <= $count; $i++ ) {
					$field    = wp4t_fieldbase($role,$i);
					$assigned = get_post_meta( $post_id, $field, true );
					if ( empty( $assigned ) || ($assigned == $member) ) {
						
						update_post_meta($post_id, $field, $member);
						if($role == 'Speaker') {
							update_post_meta($post_id,'_manual'.$field,sanitize_text_field($_POST['_manual']));
							update_post_meta($post_id,'_project'.$field,sanitize_text_field($_POST['_project']));
							update_post_meta($post_id,'_title'.$field,sanitize_text_field($_POST['_title']));
							update_post_meta($post_id,'_intro'.$field,sanitize_text_field($_POST['_intro']));
							update_post_meta($post_id,'_display_time'.$field,sanitize_text_field($_POST['_display_time']));
							update_post_meta($post_id,'_maxtime'.$field,wp_kses_post($_POST['_maxtime']));
						}
						$success = true;
						break;
				}
			}

	}
	}
if($success)
	printf('<p>Confirmed! You are signed up as %s</p>',$role);
else
	printf('<p>Looks like someone beat you to that role. Can we ask you to <a href="%s">pick another another</a>?</p>',$action);
}
	elseif(($clipboard['code'] == $code) && $clipboard['expiration'] > time())
	{
		if(isset($_POST['member']))
			echo 'Oops, looks like you forgot to enter your name';
		printf('<form id="signup" method="post" action="%s">',$action);
		printf('<p>Please select your name from the list ... %s</p><p>... and choose an open role.</p>',awe_user_dropdown( 'member', $member, true ));
		echo '<p id="status"></p>';
		$sofar = '';
		$data = wpt_blocks_to_data( $post->post_content );
			foreach ( $data as $row => $item ) {
				if ( empty( $item['role'] ) ) {
					continue;
				}
				$role       = sanitize_text_field($item['role']);
				$count      = (int) $item['count'];
				for ( $i = 1; $i <= $count; $i++ ) {
					$field    = wp4t_fieldbase($role,$i);
					$assigned = get_post_meta( $post_id, $field, true );
					if ( empty( $assigned ) ) {
						if(empty($openroles[$role]))
							$openroles[$role] = 1;
						else
							$openroles[$role]++;
					}
					else {
						$name = get_member_name($assigned);
						$sofar .= sprintf('<p>%s: %s</p>'."\n",$role,$name);
					}
				}
			}
		foreach($openroles as $role => $count) {
			$counter = ($count > 1) ? "($count openings)" : '';
			if('Speaker' == $role)
				printf('<p><input type="radio" name="role" value="%s" id="speech"> %s %s</p><div id="speechfields">%s</div>',$role,$role,$counter,str_replace('[0]','',speaker_details(0,array())));
			else
				printf('<p><input type="radio" name="role" value="%s"> %s %s</p>',$role,$role,$counter);
		}
		echo '<p><input type="radio" name="role" value="tm_absence"> Planned absence</p>';
		rsvpmaker_nonce();
		echo '<input type="hidden" name="post_id" value="'.$post_id.'">';
		echo '<p><button>Sign Up</button></p></form>';

		if(!empty($sofar))
			echo '<h3>Signed Up So Far</h3>'.$sofar;
		}
	elseif(is_user_logged_in()) {
		if($clipboard['expiration'] < time()) {
			$clipboard = array('code' => wp_create_nonce(), 'expiration' => strtotime("+3 hours"));
			update_post_meta($post_id,'wpt_clipboard_enabled',$clipboard);	
		}
		else {
			$clipboard['expiration'] = strtotime("+3 hours");
			update_post_meta($post_id,'wpt_clipboard_enabled',$clipboard);	
		}
		$action = get_permalink()."?clipboard=".$clipboard['code'].'#clipboard';
		echo '<p>In an online meeting, share this link in the chat to allow members to sign up for roles without the need to log in:</p>';
		printf('<p><textarea class="signuplink" rows="3" cols="80">Please take a role for our next meeting. No password required with this link %s</textarea></p><div id="status"></div>',$action);
		printf('<p>These coded links are good until %s</p>',rsvpmaker_date($rsvp_options['time_format'],$clipboard['expiration']));
		echo '<h3>Personalized Links</h3><p>You may want to message members without a role for this meeting one at a time using these links rather than the generic one above.</p>';
		$norole = wpt_norole($post_id, true);
		printf('<p>%d members without a role for this meeting.</p>',sizeof($norole));
		foreach($norole as $name => $member_id)
			printf('<p><textarea class="signuplink" rows="3" cols="80">Please take a role for our next meeting. Personalized link for %s, no password required with this link %s</textarea></p>',$name,str_replace('#clipboard','&member='.$member_id.'#clipboard',$action));
	}
	else {
		printf('<p>If you have a password, please <a href="%s">login now</a> to unlock the clipboard. Other members you share the coded link with will then be able to sign up for roles without the need to log in.</p>',wp_login_url('?clipboard=1'));
	}

	echo "<script type='text/javascript' src='" . admin_url( 'load-scripts.php?c=1&amp;load%5B%5D=jquery-core,jquery-migrate,utils&amp;ver=4.9.8' ) . "'></script>
	<link rel='stylesheet' id='style-toastmasters-select2-css' href='" . plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/css/select2.min.css?ver=3.74' ) . "' type='text/css' media='all' />
	<script type='text/javascript' src='" . plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/js/select2.min.js?ver=3.74' ) . "' id='script-toastmasters-select2-js'></script>
	<script>
	jQuery(document).ready(function($) {
	
	$.ajaxSetup({
		headers: {
			'X-WP-Nonce': '" . wp_create_nonce( 'wp_rest' ) . "',
		}
	});
	
	var ajaxurl = '".get_rest_url()."rsvptm/v1/clipboard/';
	console.log(ajaxurl);
	var timelord = '".rsvpmaker_nonce('value')."';
	$('#speechfields').hide();
	$('#speech').click( function() {
		$('#speechfields').show();
		/* lookup path maybe?	
		var member = $('#member_select').val();
		console.log(ajaxurl);
		$.getJSON( ajaxurl + member, function( data ) {
			$('#speechfields').html(data);
		});
		*/
	} ); 
	$('#member_select').select2();

	$('#signup').submit(
		function (e) {
			if($('#member_select').val() == '0')
			{
				e.preventDefault();
				alert('Please pick your name from the list');
			}
		}
	);
    $('.signuplink').click(
        function() {
        this.select();
        this.setSelectionRange(0, 99999); /* For mobile devices */
        /* Copy the text inside the text field */
        navigator.clipboard.writeText(this.value);
        /* Alert the copied text */
		this.style = 'border: thick solid green;';
		$(this).after('<p style=\"color:green\">Copied!</p>');
        }
    );
	
});
</script>
</div>";
return ob_get_clean();	
}

add_action('init','wp4t_server_block_render');
function wp4t_server_block_render() {
	register_block_type( 'wp4toastmasters/memberaccess', array( 'render_callback' => 'wpt_member_access' ) );
	register_block_type( 'wp4toastmasters/blog', array( 'render_callback' => 'wpt_blog_posts' ) );
	register_block_type( 'wp4toastmasters/newestmembers', array( 'render_callback' => 'wpt_newest_members_block' ) );
}

add_filter( 'nocache_headers', function() {
    global $post;
    if(empty($post) || empty($post->post_content) || !strpos($post->post_content,'wp:wp4toastmasters'))
        return;
    
    return array(
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, some-custom-thing',
        'Pragma'        => 'no-cache',
        'Expires'       => gmdate( 'D, d M Y H:i:s \G\M\T', time() )
    );
} );

add_filter('block_categories_all','toastmasters_agenda_category',10,2);

function toastmasters_agenda_category($categories, $post) {
	if(in_array($post->post_type,['rsvpmaker','rsvpmaker_template'])) {
		array_unshift( $categories, array(
			'slug'	=> 'toastmasters-agenda',
			'title' => 'Toastmasters Agenda'
		) );
	}
	return $categories;
}

add_filter( 'jetpack_seo_meta_tags', 'members_only_jetpack' );
add_filter( 'excerpt_more', 'toast_excerpt_more' );
add_filter( 'lectern_default_header', 'wp4t_header' );
add_filter( 'user_contactmethods', 'awesome_contactmethod', 10, 1 );
add_action( 'init', 'signup_sheet' );
add_action( 'init', 'print_contacts' );
add_action( 'init', 'awesome_open_roles' );
add_action( 'init', 'role_post' );
add_action('init','minutes_post_type');
add_action( 'widgets_init', 'wptoast_widgets' );
add_action( 'wp_enqueue_scripts', 'toastmasters_css_js' );
add_action( 'pre_get_posts', 'toast_modify_query_exclude_category' );
//was wp_login
add_action( 'admin_menu', 'tm_security_setup', 1 );
add_action( 'admin_bar_menu', 'toolbar_add_member', 999 );
add_action( 'admin_bar_menu', 'toolbar_link_to_agenda', 999 );
add_action( 'admin_init', 'check_first_login' );
add_action( 'admin_init', 'archive_users_init' );
add_action( 'admin_menu', 'awesome_menu' );
add_action( 'admin_init', 'awesome_role_activation_wrapper' );
add_action( 'admin_init', 'register_wp4toastmasters_settings' );
add_action( 'admin_init', 'new_agenda_template' );
add_action( 'admin_notices', 'rsvptoast_admin_notice' );
add_action( 'wp_dashboard_setup', 'awesome_add_dashboard_widgets', 99 );
add_action( 'admin_init', 'awesome_roles' );
add_action( 'wp', 'accept_recommended_role' );
add_action( 'show_user_profile', 'awesome_user_profile_fields' );
add_action( 'edit_user_profile', 'awesome_user_profile_fields' );
add_action( 'personal_options_update', 'save_awesome_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_awesome_user_profile_fields' );
add_action( 'user_new_form', 'member_not_user' );
add_action( 'rsvpmaker_datebox_message', 'toastmasters_datebox_message' );
add_action( 'toastmasters_agenda_notification', 'bp_toastmasters', 10, 3 );
add_action( 'toastmasters_agenda_notification', 'wp4t_intro_notification', 10, 5 );
add_action( 'bp_profile_header_meta', 'display_toastmasters_profile' );
add_action( 'admin_head', 'profile_richtext' );
add_action( 'admin_init', 'wp4t_cron_nudge_setup' );
