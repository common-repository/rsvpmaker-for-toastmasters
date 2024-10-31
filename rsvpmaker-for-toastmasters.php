<?php
/*
Plugin Name: RSVPMaker for Toastmasters
Plugin URI: http://wp4toastmasters.com
Description: This Toastmasters extension to the RSVPMaker events plugin adds role signups and member performance tracking. Better Toastmasters websites!
Author: David F. Carr
Tags: Toastmasters, public speaking, community, agenda
Author URI: http://www.carrcommunications.com
Text Domain: rsvpmaker-for-toastmasters
Domain Path: /translations
Version: 6.2.5
*/

function rsvptoast_load_plugin_textdomain() {
	load_plugin_textdomain( 'rsvpmaker-for-toastmasters', false, basename( dirname( __FILE__ ) ) . '/translations/' );
}
add_action( 'init', 'rsvptoast_load_plugin_textdomain' );
function wp4t_js_translation () {
	wp_set_script_translations( 'wpt-cgb-block-js', 'rsvpmaker-for-toastmasters',plugin_dir_path( __FILE__ ) . 'translations' );
}
add_action('wp_enqueue_scripts','wp4t_js_translation',100);

require 'core.php';
require 'filters.php';
require 'tm-reports.php';
require 'contest.php';
require 'utility.php';
require 'toastmasters-privacy.php';
require 'tm-online-application.php';
require 'api.php';
require 'enqueue.php';
require 'setup-wizard.php';
require 'fth-importer.php';
require 'email.php';
require 'history.php';
require 'todo-list.php';
require 'fse-navigation-block.php';
require 'email-forwarders-and-groups.php';
require 'toastmasters-dynamic-agenda/toastmasters-dynamic-agenda.php';
require 'speaker-evaluator/speaker-evaluator.php';
require 'mobile.php';
require 'agenda-layout/agenda-layout.php';
require 'memberoptions/memberoptions.php';

require_once plugin_dir_path( __FILE__ ) . 'gutenberg/src/init.php';

if ( isset( $_GET['email_agenda'] ) || isset( $_GET['send_by_email'] ) ) {
	global $email_context;
	$email_context = true;
}

