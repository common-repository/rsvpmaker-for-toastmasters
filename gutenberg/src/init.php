<?php

/**

 * Blocks Initializer

 *

 * Enqueue CSS/JS of all the blocks.

 *

 * @since   1.0.0

 * @package CGB

 */



// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



/**

 * Enqueue Gutenberg block assets for both frontend + backend.

 *

 * `wp-blocks`: includes block type registration and related functions.

 *

 * @since 1.0.0

 */

function wpt_cgb_block_assets() {

	// Styles.

	wp_enqueue_style(

		'wpt-cgb-style-css', // Handle.

		plugins_url( 'rsvpmaker-for-toastmasters/toastmasters-dynamic-agenda/build/gblocks/index.css' ), // Block style CSS.

		array( 'wp-editor' ), // Dependency to include the CSS after it.

		filemtime( str_replace('gutenberg','toastmasters-dynamic-agenda',plugin_dir_path( __DIR__ )) . '/build/gblocks/index.css' ) // Version: filemtime — Gets file modification time.

	);

} // End function wpt_cgb_block_assets().



// Hook: Frontend assets.



add_action( 'enqueue_block_assets', 'wpt_cgb_block_assets' );



/**

 * Enqueue Gutenberg block assets for backend editor.

 *

 * `wp-blocks`: includes block type registration and related functions.

 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.

 * `wp-i18n`: To internationalize the block's text.

 *

 * @since 1.0.0

 */

function wpt_cgb_editor_assets() {

	global $post, $toast_roles;

	// Scripts.

	$path = str_replace('gutenberg','toastmasters-dynamic-agenda',plugin_dir_path( __DIR__ ));

	wp_enqueue_script(

		'wpt-cgb-block-js', // Handle.

		plugins_url( 'rsvpmaker-for-toastmasters/toastmasters-dynamic-agenda/build/gblocks/index.js' ), // Block.build.js: We register the block here. Built with Webpack.

		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-block-editor' ), // Dependencies, defined above.

		filemtime(  $path.'build/gblocks/index.js' ),

		true // Enqueue the script in the footer.

	);



	$wpt_rest = array('nonce' => wp_create_nonce( 'wp_rest' ), 'url' => get_rest_url() );

	if(isset($post->ID))

	{

		$wpt_test['post_id'] = $post->ID;

		$rsvpmaker_special = get_post_meta($post->ID,'_rsvpmaker_special',true);	

		if(!empty($rsvpmaker_special))

			$wpt_rest['special'] = $rsvpmaker_special;

	}

	wp_localize_script('wpt-cgb-block-js', 'wpt_rest', $wpt_rest );

	$toast[] = array('value' =>'', 'label' => __('Select Role (not set)','rsvpmaker-for-toastmasters'));

	$toast[] = array('value' =>'custom', 'label' => __('Custom Role','rsvpmaker-for-toastmasters'));

	foreach($toast_roles as $key => $value)

		$toast[] = array('value' => $key, 'label' => $value);

	wp_localize_script('wpt-cgb-block-js', 'toast_roles', $toast );

	// Styles.

	wp_enqueue_style(

		'wpt-cgb-block-editor-css', // Handle.

		plugins_url( 'rsvpmaker-for-toastmasters/toastmasters-dynamic-agenda/build/gblocks/index.css' ), // Block editor CSS.

		array( 'wp-edit-blocks' ), 

		filemtime( $path.'build/gblocks/index.css' )

	);

} // End function wpt_cgb_editor_assets().



// Hook: Editor assets.

add_action( 'enqueue_block_editor_assets', 'wpt_cgb_editor_assets' );





function wpt_server_block_render(){

	$roleatts = array('role' => array('type' => 'string', 'default' => ''),'custom_role' => array('type' => 'string', 'default' => ''),'count' => array('type' => 'integer', 'default' => 1),'start' => array('type' => 'integer', 'default' => 1),'agenda_note' => array('type' => 'string', 'default' => ''),'time_allowed' => array('type' => 'string', 'default' => '0'),'padding_time' => array('type' => 'string', 'default' => '0'),'timing_updated' => array('type' => 'integer', 'default' => 0),'backup' => array('type' => 'string', 'default' => ''),'show_timing_summary' => array('type' => 'boolean', 'default' => false));

	$noteatts = array('time_allowed' => array('type' => 'string', 'default' => '0'),'timing_updated' => array('type' => 'integer', 'default' => 0),'uid' => array('type' => 'string', 'default' => ''),'content' => array('type' => 'array', 'default' => array() ),'show_timing_summary' => array('type' => 'boolean', 'default' => false) );

	register_block_type('wp4toastmasters/agendanoterich2', ['render_callback' => 'agendanoterich2', 'attributes' => $noteatts]);

	$noteatts = array('editable' => array('type' => 'string', 'default' => ''),'time_allowed' => array('type' => 'string', 'default' => '0'),'timing_updated' => array('type' => 'integer', 'default' => 0),'uid' => array('type' => 'string', 'default' => ''),'inline' => array('type' => 'integer', 'default' => 0 ),'show_timing_summary' => array('type' => 'boolean', 'default' => false) );

	register_block_type('wp4toastmasters/agendaedit', ['render_callback' => 'editable_note', 'attributes' => $noteatts]);

	register_block_type('wp4toastmasters/role', ['render_callback' => 'toastmaster_short', 'attributes' => $roleatts ]);

	//register_block_type('wp4toastmasters/agendamain', ['render_callback' => 'tmlayout_main_block']);
	//register_block_type('wp4toastmasters/officers', ['render_callback' => 'toastmaster_officers']);	

	register_block_type('wp4toastmasters/absences', ['render_callback' => 'tm_absence']);	

	register_block_type('wp4toastmasters/hybrid', ['render_callback' => 'tm_attend_in_person']);	

	register_block_type('wp4toastmasters/duesrenewal', ['render_callback' => 'wp4t_dues_renewal']);

	register_block_type('wp4toastmasters/context', ['render_callback' => 'wp4t_agenda_display_context' ]);

}

function agendanoterich2($atts, $content) {

//if(wp_is_json_request())

	//return summarize_agenda_times($atts);


$output = false;

global $emailcontext;

if($emailcontext)

	$output = true;

if(isset($_GET['print_agenda']) || isset($_GET['email_agenda']))

	$output = true;

if($output)

	return $content;

return;

}



add_action('init','wpt_server_block_render');