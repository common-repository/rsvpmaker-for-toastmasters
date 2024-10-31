<?php



function tm_welcome_screen_assets( $hook ) {

	if(is_network_admin())

		return;



	// everywhere except posts screen

	$ver = '3.58';

	if ( ! strpos( $_SERVER['REQUEST_URI'], 'post.php' ) ) {

		wp_enqueue_style( 'tm_welcome_screen_css', plugin_dir_url( __FILE__ ) . '/admin-style.css', array(), $ver );

		wp_enqueue_script( 'tm_welcome_screen_js', plugin_dir_url( __FILE__ ) . '/admin-script.js', array( 'jquery' ), $ver, true );

		wp_localize_script(

			'tm_welcome_screen_js',

			'wpt_rest',

			wpt_rest_array()

		);

	}

}



function wpt_is_evaluation_demo() {

	return apply_filters('wpt_is_evaluation_demo',false);

}



function wpt_rest_array() {

	global $post;

	$post_id = (empty($post) || empty($post->ID)) ? 0 : $post->ID;

	$post_type = (empty($post) || empty($post->post_type)) ? '' : $post->post_type;

	$is_agenda = ($post && isset($post->post_content) && strpos($post->post_content,'wp4toastmasters/role'));

	return array(

		'nonce'   => wp_create_nonce( 'wp_rest' ),

		'url'     => get_rest_url(),

		'post_id' => $post_id,

		'post_type' => $post_type,

		'is_agenda' => $is_agenda,

	);

}

//use rsvpmaker script for tabbed ui

add_filter('rsvpmaker_tab_pages','toastmasters_tabs');

function toastmasters_tabs($hastabs) {

	if(isset($_GET['page']) && in_array($_GET['page'],array('wp4toastmasters_settings','wp4t_evaluations','toastmasters_reports','toastmasters_welcome','wpt_dues_report')))

		$hastabs = true;

	return $hastabs;

}

function toastmasters_css_js() {

	if(is_network_admin())

		return;

	global $post, $current_user;

	$version = '5.4.5';

	if ( is_admin() && ( strpos( $_SERVER['REQUEST_URI'], 'edit.php' ) || ( strpos( $_SERVER['REQUEST_URI'], 'post.php' ) && empty( $_GET['page'] ) ) || strpos( $_SERVER['REQUEST_URI'], 'post-new.php' ) ) ) {

		return; // don't load all this in editor or post listings wp4toastmasters_history_edit

	}

	if ( ( isset( $post->post_content ) && is_wp4t() ) || ( isset( $_REQUEST['page'] ) && 	( ( $_REQUEST['page'] == 'toastmasters_reconcile' ) || ( $_REQUEST['page'] == 'add_member_speech' ) || ( $_REQUEST['page'] == 'wp4toastmasters_history_edit' ) || ( $_REQUEST['page'] == 'my_progress_report' )

	|| ( $_REQUEST['page'] == 'wp4t_evaluations' ) || ( $_REQUEST['page'] == 'toastmasters_reports' )

	|| ( $_REQUEST['page'] == 'toastmasters_planner' ) ) ) ) {

		wp_enqueue_style( 'jquery' );

		wp_enqueue_style( 'jquery-ui-core' );

		wp_enqueue_style( 'jquery-ui-sortable' );

		wp_register_script( 'script-toastmasters', plugins_url( 'rsvpmaker-for-toastmasters/toastmasters.min.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), $version );

		wp_enqueue_script( 'script-toastmasters' );

		$options['manuals'] = get_manuals_options();

		$options['projects'] = get_projects_array( 'options' );

		wp_localize_script( 'script-toastmasters', 'project_list', $options );

		$times = get_projects_array( 'times' );

		wp_localize_script( 'script-toastmasters', 'project_times', $times );

		$display_times = get_projects_array( 'display_times' );

		wp_localize_script( 'script-toastmasters', 'display_times', $display_times );

		wp_localize_script(

			'script-toastmasters',

			'wpt_rest',

			wpt_rest_array(),

		);

		$tm_vars               = array_map('sanitize_text_field',$_GET);

		$tm_vars['php_self']   = sanitize_text_field($_SERVER['PHP_SELF']);

		$tm_vars['user_id']    = ( empty( $current_user->ID ) ) ? 0 : $current_user->ID;

		$tm_vars['user_roles'] = ( empty( $current_user->roles ) ) ? array() : $current_user->roles;

		$tm_vars['post_id']    = ( empty( $post->ID ) ) ? 0 : $post->ID;

		wp_localize_script( 'script-toastmasters', 'tm_vars', $tm_vars );

		wp_enqueue_style( 'style-toastmasters', plugins_url( 'rsvpmaker-for-toastmasters/toastmasters.css' ), array(), $version );

		wp_enqueue_style( 'select2', plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/css/select2.min.css' ), array(), $version );

		wp_enqueue_script( 'select2', plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/js/select2.min.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), $version );

	}

	if(strpos($_SERVER['REQUEST_URI'],'valuation-forms')) {

		wp_enqueue_style( 'jquery' );

		wp_enqueue_style( 'jquery-ui-core' );

		wp_enqueue_style( 'jquery-ui-sortable' );

		wp_register_script( 'script-toastmasters', plugins_url( 'rsvpmaker-for-toastmasters/toastmasters.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), $version );

		wp_enqueue_script( 'script-toastmasters' );

		$manuals = get_manuals_options();

		wp_localize_script( 'script-toastmasters', 'manuals_list', $manuals );

		$projects = get_projects_array( 'options' );

		wp_localize_script( 'script-toastmasters', 'project_list', $projects );

		wp_localize_script(

			'script-toastmasters',

			'wpt_rest',

			wpt_rest_array(),

		);

		$tm_vars               = array_map('sanitize_text_field',$_GET);

		$tm_vars['php_self']   = sanitize_text_field($_SERVER['PHP_SELF']);

		$tm_vars['user_id']    = ( empty( $current_user->ID ) ) ? 0 : $current_user->ID;

		$tm_vars['user_roles'] = ( empty( $current_user->roles ) ) ? array() : $current_user->roles;

		$tm_vars['post_id']    = ( empty( $post->ID ) ) ? 0 : $post->ID;

		wp_localize_script( 'script-toastmasters', 'tm_vars', $tm_vars );

		wp_enqueue_style( 'select2', plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/css/select2.min.css' ), array(), $version );

		wp_enqueue_script( 'select2', plugins_url( 'rsvpmaker-for-toastmasters/select2/dist/js/select2.min.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), $version );

	}



	if ( ( isset( $post->post_content ) && is_wp4t() )

	|| ( strpos( $_SERVER['REQUEST_URI'], 'profile.php' ) || strpos( $_SERVER['REQUEST_URI'], 'user-edit.php' ) )

	) {

		wp_enqueue_script( 'wp-tinymce' );

	}

	if ( isset( $_REQUEST['page'] ) && ( $_REQUEST['page'] == 'wp4t_setup_wizard' ) ) {

		wp_enqueue_script( 'password-strength-meter' );

		wp_enqueue_script( 'user-profile' );

	}

	if ( isset( $_GET['scoring'] ) ) {

		wp_enqueue_script( 'wp-tinymce' );

		wp_register_script( 'contest-toastmasters', plugins_url( 'rsvpmaker-for-toastmasters/contest.js' ), array( 'jquery','wp-tinymce' ), $version );

		wp_enqueue_script( 'contest-toastmasters' );

		$contestvars = array(

			'rest_nonce'     => wp_create_nonce( 'wp_rest' ),

			'votecheck'      => rest_url( '/wptcontest/v1/votecheck/' . $post->ID ),

			'post_id'        => $post->ID,

			'vote_submitted' => isset( $_POST['vote'] ),

		);

		$order       = get_post_meta( $post->ID, 'tm_scoring_order', true );

		if ( $order && is_array( $order ) ) {

			foreach ( $order as $index => $value ) {

				$scoreArr[ $index ] = array(

					'index' => $index,

					'score' => 0,

				);

			}

		} else {

			$scoreArr = array();

		}

		wp_localize_script( 'contest-toastmasters', 'scoreArr', $scoreArr );

		foreach ( $_GET as $index => $value ) {

			$contestvars[ $index ] = $value;

		}

		if ( isset( $_GET['judge'] ) ) {

			$contestvars['votereceived'] = rest_url( 'wptcontest/v1/votereceived/' . $post->ID . '/' . sanitize_text_field($_GET['judge']) );

		}

		if(!empty($contestvars))

		wp_localize_script( 'contest-toastmasters', 'contest', $contestvars );

	}

}



function wpt_fetch_report( $report, $user_id ) {

	printf( '<div id="%s_content">Loading ...</div>', $report );

}

