<?php

global $post, $current_user, $wpdb;

show_admin_bar( false );

$is_timer      = false;

$contest_timer = '';

function timer_display_time_stoplight( $content, $name, $speechid ) {

	preg_match_all( '/\d{1,3}/', $content, $matches );

		$output = '';

	if ( ! empty( $matches ) ) {

		$green   = array_shift( $matches[0] );

		$red     = array_shift( $matches[0] );

		$output .= timer_get_stoplight_options( $name, $green, $red, $speechid );

	}

		return $output;

}



function timer_get_background_image( $key ) {

	global $wpdb;

	$o       = '';

	$results = $wpdb->get_results( "SELECT guid, post_title from $wpdb->posts where post_type='attachment' and post_title like '%$key%' " );

	foreach ( $results as $row ) {

		$o .= sprintf( '<option value="%s">%s</option>', $row->guid, $row->post_title );

	}

	return $o;

}



function timer_get_stoplight_options( $name, $green, $red, $speechid = '' ) {

	if ( empty( $yellow ) ) {

		$diff         = $red - $green;

		$plus_minutes = ( $diff - $diff % 2 ) / 2;

		$yellow       = $green + $plus_minutes;

		if ( $diff % 2 ) {

			if ( ( $green > 5 ) && ( $diff > 2 ) ) {

				$yellow++;

			} else {

				$yellow = $yellow .= ':30';

			}

		} else {

			$yellow = $yellow .= ':00';

		}

	}

		$red   = $red .= ':00';

		$green = $green .= ':00';

		return sprintf( '<option value="%s|%s|%s|%s|%s">%s (%s - %s)</option>', $name, $green, $yellow, $red, $speechid, $name, $green, $red );

}



if ( is_user_logged_in() ) {

	$sql      = "SELECT * FROM `$wpdb->postmeta` where post_id=" . $post->ID . '  AND meta_value=' . $current_user->ID . " AND meta_key LIKE '_role_%' ";

	$role_row = $wpdb->get_row( $sql );

	if ( $role_row ) {

		$role = trim( preg_replace( '/[^A-Za-z]/', ' ', $role_row->meta_key ) );

	} else {

		$role = '';

	}

	$name     = $role . ' ' . $current_user->display_name;

	$email    = $current_user->user_email;

	$is_timer = ( ( $role == 'Timer' ) && ! isset( $_GET['exit_timer'] ) );

} elseif ( isset( $_GET['email'] ) && rsvpmail_contains_email( $_GET['email'] ) ) {

		$email = sanitize_text_field($_GET['email']);

		$sql   = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'rsvpmaker WHERE email LIKE %s AND event=%d', $email, $post->ID );

		$row   = $wpdb->get_row( $sql );

	if ( $row ) {

		$name = 'Guest:' . $row->first . ' ' . $row->last;

	}

}

if ( isset( $_GET['demo'] ) ) {

	if ( current_user_can( 'manage_options' ) ) {

			update_post_meta( $post->ID, 'jitsi_demo', true );

			$name  = 'Testy Tester';

			$email = 'testy@example.com';

	} elseif ( get_post_meta( $post->ID, 'jitsi_demo', true ) ) {

		$name  = 'Testy Tester';

		$email = 'testy@example.com';

	}

}

if ( $post->post_type != 'rsvpmaker' ) {

	// test configuration, not associated with an event or club

	$name  = 'Testy Tester';

	$email = 'testy@example.com';

	// if last used more than 2 hours ago

	$colorts = (int) get_post_meta( $post->ID, 'timing_timestamp', true );

	if ( $colorts < strtotime( '-2 hours' ) ) {

		update_post_meta( $post->ID, 'timing_light_color', 'default' );

	}

	update_post_meta( $post->ID, 'timing_timestamp', time() );

}



if ( isset( $_GET['claim_timer'] ) ) {

	$is_timer = true;

}



if ( isset( $_GET['nosync'] ) ) {

	$nosync = true;

	update_post_meta( $post->ID, 'nosync', true );

} else {

	$nosync = get_post_meta( $post->ID, 'nosync', true );

}

$widthadj      = ( $is_timer ) ? 100 : 50;

$is_jitsi      = ( isset( $_GET['embed'] ) && ( $_GET['embed'] == 'jitsi' ) );

$scriptversion = ( isset( $_GET['css'] ) ) ? time() : date( 'Ymdh' );

?>

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8"/>

  <?php global $post; ?>

  <title>Timer: Toastmasters Online Meeting</title>



  <meta name="viewport" content="width=device-width"/>



  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?php echo plugins_url( 'rsvpmaker-for-toastmasters/timer.css?v=' . $scriptversion ); ?>" rel="stylesheet" />

 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="<?php echo plugins_url( 'rsvpmaker-for-toastmasters/timer.js?v=' ) . $scriptversion; ?>"></script>

<style>

<?php

if ( isset( $_GET['embed'] ) && ( $_GET['embed'] == 'zoom' ) ) {

	?>

.zoom-window-wrap h1, .zoom-window-wrap h2, .zoom-window-wrap h3,

.zoom-window-wrap a.button, .zoom-window-wrap a.start-meeting-btn,

.zoom-app-notice, .zoom-links  {

display: none;

}

	<?php

}

?>

@media only screen and (max-width: 400px) {
  #viewcontrol {
	display: none;
  }

  #jitsi {
	  display: none;
	  width: 5px;
  }
}

</style>

<?php

if ( isset( $_GET['embed'] ) && ( $_GET['embed'] == 'jitsi' ) ) {

	?>

<script src='https://meet.jit.si/external_api.js'></script>

	<?php

}

?>

</head>

<body>

<div id="body">

	<div>

<div id="viewcontrol"><span 

<?php

if ( $nosync ) {

	echo ' style="display:none;" ';}

?>

 >View <select id="view" >

		<option value="self">Timer (no sync)</option>

		<option value="timer"

		<?php

		if ( $is_jitsi && $is_timer ) {

			echo ' selected="selected" ';}

		?>

		>Timer (sync with Audience)</option>

		<option value="normal" 

		<?php

		if ( $is_jitsi && ! $is_timer ) {

			echo ' selected="selected" ';}

		?>

		 >Audience</option>

</select></span><button id="popup">Popup Light</button> <button id="enlargecontrols">Enlarge</button> <button id="hideit">Hide Instructions</button></div>



		<div id="timelog">

		<p id="explanation"></p>        

		<div id="checkcontrols">

		<div id="checkstatus"></div>

		<p><button id="checknow">Check Now</button></p>

		</div>

		<div class="timer-controls">

<?php

$options = '';



if ( isset( $_GET['contest'] ) ) {



	$dt = get_post_meta( $post->ID, 'toast_timing', true );

	if ( empty( $dt ) ) {

		$dt = '5 to 7';

	}



	$contestants = get_post_meta( $post->ID, 'tm_scoring_contestants', true );

	if ( empty( $contestants ) ) {

		echo 'Contestants list not set';

	} else {

		$order = get_post_meta( $post->ID, 'tm_scoring_order', true );



		if ( empty( $order ) ) {

			echo '<p>Refresh this page once the contestant order has been set.</p>';

			?>

<div id="order_status"></div>

<script>

jQuery(document).ready(function($) {



function refreshOrder() {

$('#score_status').html('Checking for contestant order ...');

$.get( "<?php echo site_url( '/wp-json/wptcontest/v1/order/' . $post->ID ); ?>", function( data ) {

console.log(data);

if(Array.isArray(data)) {

	$('#order_status').html('Order set, reload the page now if it does not do so automatically');

	location.reload();	

}

else

  $('#order_status').html('Order still not set');

});	

}



setInterval(function(){

  refreshOrder();	

}, 10000);

	

$('#track_role').on('change', function(){

var role = $(this).val();

if(role == '')

	{

$('#role_track_status').html('');

$('#manual_contestants').show();		

	}

else {

$('#role_track_status').html('<p>Contestant names will be pulled from the '+role+' role on the agenda</p>');

$('#manual_contestants').hide();	

}

});



});

</script>

			<?php

		}



		if ( empty( $order ) ) {

			$order = $contestants;

		}



		foreach ( $order as $index => $speakername ) {

			$options .= timer_display_time_stoplight( $dt, $speakername, $index );

		}

	}

} elseif ( $post->post_type == 'rsvpmaker' ) {

	$count = 0;

	if ( strpos( $post->post_content, 'wp:wp4toastmasters' ) ) {

		$data  = wpt_blocks_to_data( $post->post_content, false, true );

		$count = ( isset( $data['Speaker']['count'] ) ) ? $data['Speaker']['count'] : 0;

	} else {

		preg_match( '/role="Speaker" count="([^"])"/', $post->post_content, $matches );

		$count = isset($matches[1]) ? $matches[1] : 1;

	}



	if ( empty( $options ) ) {

		$options = '';

	}

	for ( $i = 1; $i <= $count; $i++ ) {

		// echo 'Lookup '.'_Speaker_'.$i;

		$member_id = get_post_meta( $post->ID, '_role_Speaker_' . $i, true );

		// echo ' id '.$member_id;

		if ( $member_id ) {

			if ( is_numeric( $member_id ) ) {

				$member      = get_userdata( $member_id );

				$speakername = $member->first_name . ' ' . $member->last_name;

			} else {

				$speakername = $member_id; // guest

			}

			// print_r($member);

			$dt = get_post_meta( $post->ID, '_display_time_role_Speaker_' . $i, true );

			if ( empty( $dt ) ) {

				$dt = '5 to 7';

			}

			$options .= timer_display_time_stoplight( $dt, $speakername, $i );

		}

	}



	for ( $i = 1; $i <= $count; $i++ ) {

		$member_id = get_post_meta( $post->ID, '_role_Evaluator_' . $i, true );

		// echo ' id '.$member_id;

		if ( $member_id ) {

			if ( is_numeric( $member_id ) ) {

				$speakername = get_member_name( $member_id );

			} else {

				$name = 'Guest: ' . $member_id;

			}

			// print_r($member);

			$options .= timer_display_time_stoplight( '2 to 3', 'Evaluator: ' . $speakername, $i );

		}

	}

}

?>

	<div><select id="dropdowntime">

	<option value="">Speaker/Speech Type</option>

	<?php echo $options; ?>

	<?php if ( isset( $_GET['contest'] ) ) { ?> 

	<option value="One Minute|0:30|0:45|1:00|minute">One Minute</option>

	<option value="Two Minutes|1:00|1:30|2:00|2minute">Two Minutes</option>

	<option value="Three Minutes|2:00|2:30|3:00|3minute">Three Minutes</option>

	<option value="Four Minutes|3:00|3:30|4:00|4minute">Four Minutes</option>

	<option value="Five Minutes|4:00|4:30|5:00|5minute">Five Minutes</option>

	<?php } ?>

	<option value="Speech (5-7)|5:00|6:00|7:00|standard">Speech (5-7)</option>

	<option value="Table Topics|1:00|1:30|2:00|tt">Table Topics</option>

	<option value="Evaluation|2:00|2:30|3:00|eval">Evaluation</option>

	<option value="Speech (3-4)|3:00|3:30|4:00|3to4">Speech (3-4)</option>

	<option value="Speech (4-6)|4:00|5:00|6:00|4to6">Speech (4-6)</option>

	<option value="Speech (6-8)|6:00|7:00|8:00|6to8">Speech (6-8)</option>

	<option value="Speech (8-10)|8:00|9:00|10:00|8to10">Speech (8-10)</option>

	<option value="Speech (10-15)|10:00|12:30|15:00|10to15">Speech (10-15)</option>

	<option value="Speech (15-20)|15:00|17:30|20:00|15to20">Speech (15-20)</option>

	<option value="Speech (20-30)|20:00|22:30|30:00|20to30">Speech (20-30)</option>

	<option value="Test|0:05|0:10|0:15|test">Test (15 seconds)</option>

	<option value="30 Seconds|0:20|0:25|0:30|30sec">30 Seconds</option>

	<?php if ( ! isset( $_GET['contest'] ) ) { ?> 

	<option value="One Minute|0:30|0:45|1:00|minute">One Minute</option>

	<option value="Two Minutes|1:00|1:30|2:00|2minute">Two Minutes</option>

	<option value="Three Minutes|2:00|2:30|3:00|3minute">Three Minutes</option>

	<option value="Four Minutes|3:00|3:30|4:00|4minute">Four Minutes</option>

	<option value="Five Minutes|4:00|4:30|5:00|5minute">Five Minutes</option>

	<?php } ?>

	</select></div>

	<div>

	<input type="hidden" id="speechid" />    

	<input type="text" placeholder="Speaker Name" id="speakername" size="30">

	</div>

	<span class="hidecount">

		  <div><input id="green-light" type="text" class="greenyellowred"></div>

		  <div><input id="yellow-light" type="text" class="greenyellowred"></div>

		  <div><input id="red-light" type="text" class="greenyellowred"></div>

	</span>



	<button class="btn-primary btnStart" id="btnStart" type="button" value="Start">Start</button>

	<button class=" btn-default btnReset" id="btnReset" type="button" value="Reset">Stop</button>

	<select id="correction">

	  <option value="0" selected="selected">Correction (0)</option>

	  <?php

		for ( $min = 0; $min < 11; $min++ ) {

			for ( $seconds = 0; $seconds < 60; $seconds += 5 ) {

				if ( ( $min == 0 ) && ( $seconds == 0 ) ) {

					continue;

				}

				printf( '<option value="%s">+ %s:%s%s</option>', $seconds + ( $min * 60 ), $min, ( $seconds < 10 ) ? '0' : '', $seconds );

			}

		}

		?>

	  </select>

	  <div class="hidecount">

	  <button id="greennow" class="colorbuttons">Green</button>

	  <button id="yellownow" class="colorbuttons">Yellow</button>

	  <button id="rednow" class="colorbuttons">Red</button>

	  <div id="clearwrap"><button id="clearlog">Clear Log</button></div>

	  </div>

	</div>



			<div id="smallcounter"></div>

			<div id="logentries"></div>





<?php



if ( isset( $_REQUEST['contest'] ) ) {

	$timer_code = get_post_meta( $post->ID, 'tm_timer_code', true );

	if ( $timer_code != $_REQUEST['contest'] ) {

		wp_die( 'incorrect code' );

	}

	if ( isset( $_POST['time'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {

		$disqualified = ( isset( $_POST['disqualified'] ) ) ? array_map('sanitize_text_field',$_POST['disqualified']) : array();

		$timereport   = '';

		foreach ( $_POST['time'] as $index => $value ) {

			$timereport .= $order[ $index ] . ': ' . sanitize_text_field($value);

			if ( in_array( $index, $disqualified ) ) {

				$timereport .= ' (disqualified)';

			}

			$timereport .= '<br />';

		}

		if ( ! empty( $timereport ) ) {

			update_post_meta( $post->ID, '_time_report', $timereport );

			printf( '<h2>Recorded</h2><p>%s</p>', $timereport );

		}

		update_post_meta( $post->ID, '_time_disqualified', $disqualified );



	}

	$action          = add_query_arg(

		array(

			'timer'   => '1',

			'contest' => $timer_code,

		),

		get_permalink( $post->ID )

	);

	$timer_user      = (int) get_post_meta( $post->ID, 'contest_timer', true );

	$dashboard_users = get_post_meta( $post->ID, 'tm_contest_dashboard_users', true );

	if ( $timer_user && ( $current_user->ID != $timer_user ) && ! in_array( $current_user->ID, $dashboard_users ) ) {

		printf( '<p>You must <a href="%s">login</a> use the timer\'s report form.</p>', wp_login_url( sanitize_text_field($_SERVER['REQUEST_URI']) ) );

	} else {

		ob_start();

		?>

<form method="post" action="<?php echo esc_attr($action); ?>" id="voting">

<p><strong>Record Time</strong></p>

		<?php

		foreach ( $order as $index => $contestant ) {

			printf( '<p>%s <br /><input type="text" class="timefield" name="time[]" value="0:00" id="actualtime%d" ><br /><input type="checkbox" name="disqualified[]" value="%d" id="disqualified%d" /> Disqualified</p>', $contestant, $index, $index, $index );

		}



		?>

<div id="readyline"><input type="checkbox" id="readytovote" value="1" /> Check to digitally sign this as the official time record</div>

<div id="readyprompt"></div>

			<div id="timesend" ><button >Send</button></div>

			<?php rsvpmaker_nonce(); ?>

		</form>			

		<?php

		$contest_timer = ob_get_clean();

	}// end display of form

} // end contest output

echo $contest_timer;

echo '<p id="background-image-control">Background Choices</p>';

printf(

	'<p><select class="background-image-picker" id="bg-green"><option value="none">Green Image: None</option>

<option value="https://wp4toastmasters.com/tmbranding/en-toastmasters-TA662D-toastmasters-zoom-virtual-logo-bk-timer-green-1920x1080-c1.jpg">Green TM logo</option>

<option value="https://wp4toastmasters.com/tmbranding/en-toastmasters-TA662D-toastmasters-zoom-virtual-wordmark-bk-timer-green-1920x1080-c1.jpg">Green TM wordmark</option>

%s</select></p>',

	timer_get_background_image( 'green' )

);

printf(

	'<p><select class="background-image-picker" id="bg-yellow"><option value="none">Yellow Image: None</option>

<option value="https://wp4toastmasters.com/tmbranding/en-toastmasters-TA662D-toastmasters-zoom-virtual-logo-bk-timer-yellow-1920x1080-c1.jpg">Yellow TM logo</option>

<option value="https://wp4toastmasters.com/tmbranding/en-toastmasters-TA662D-toastmasters-zoom-virtual-wordmark-bk-timer-yellow-1920x1080-c1_.jpg">Yellow TM wordmark</option>

%s</select></p>',

	timer_get_background_image( 'yellow' )

);

printf(

	'<p><select class="background-image-picker" id="bg-red"><option value="none">Red Image: None</option>

<option value="https://wp4toastmasters.com/tmbranding/en-toastmasters-TA662D-toastmasters-zoom-virtual-logo-bk-timer-red-1920x1080-c1.jpg">Red TM logo</option>

<option value="https://wp4toastmasters.com/tmbranding/en-toastmasters-TA662D-toastmasters-zoom-virtual-wordmark-bk-timer-red-1920x1080-c1.jpg">Red TM wordmark</option>

%s</select></p>',

	timer_get_background_image( 'red' )

);

?>

<p><select class="background-image-picker" id="bg-default">

<option value="#000000">Default/Ready Color</option>

<option value="#000000">Black </option>

<option value="#DCDCDC">Gainsboro </option>

<option value="#D3D3D3">LightGray </option>

<option value="#C0C0C0">Silver </option>

<option value="#A9A9A9">DarkGray </option>

<option value="#696969">DimGray </option>

<option value="#808080">Gray </option>

<option value="#778899">LightSlateGray </option>

<option value="#708090">SlateGray </option>

<option value="#2F4F4F">DarkSlateGray </option>

<option value="#FFFFFF">White </option>

<option value="#FFFAFA">Snow </option>

<option value="#F0FFF0">HoneyDew </option>

<option value="#F5FFFA">MintCream </option>

<option value="#F0FFFF">Azure </option>

<option value="#F0F8FF">AliceBlue </option>

<option value="#F8F8FF">GhostWhite </option>

<option value="#F5F5F5">WhiteSmoke </option>

<option value="#FFF5EE">SeaShell </option>

<option value="#F5F5DC">Beige </option>

<option value="#FDF5E6">OldLace </option>

<option value="#FFFAF0">FloralWhite </option>

<option value="#FFFFF0">Ivory </option>

<option value="#FAEBD7">AntiqueWhite </option>

<option value="#FAF0E6">Linen </option>

<option value="#FFF0F5">LavenderBlush </option>

<option value="#FFE4E1">MistyRose </option>

<option value="#7B68EE">MediumSlateBlue </option>

<option value="#6A5ACD">SlateBlue </option>

<option value="#483D8B">DarkSlateBlue </option>

<option value="#663399">RebeccaPurple </option>

<option value="#4B0082">Indigo  </option>

<option value="#4169E1">RoyalBlue </option>

<option value="#0000FF">Blue </option>

<option value="#0000CD">MediumBlue </option>

<option value="#00008B">DarkBlue </option>

<option value="#000080">Navy </option>

<option value="#191970">MidnightBlue </option>

<option value="#E6E6FA">Lavender </option>

<option value="#D8BFD8">Thistle </option>

<option value="#DDA0DD">Plum </option>

<option value="#DA70D6">Orchid </option>

<option value="#EE82EE">Violet </option>

<option value="#FF00FF">Fuchsia </option>

<option value="#FF00FF">Magenta </option>

<option value="#BA55D3">MediumOrchid </option>

<option value="#9932CC">DarkOrchid </option>

<option value="#9400D3">DarkViolet </option>

<option value="#8A2BE2">BlueViolet </option>

<option value="#8B008B">DarkMagenta </option>

<option value="#800080">Purple </option>

<option value="#9370DB">MediumPurple </option>

</select></p>

<blockquote><a href="https://www.wp4toastmasters.com/knowledge-base/online-timer-tool/" target="_blank">Instructions</a></blockquote>
<?php if(current_user_can(('edit_posts'))) {
?>
<form action="<?php echo rest_url('rsvptm/v1/timerimage'); ?>" method="post" enctype="multipart/form-data" class="newcolor">
<p><strong>Upload color image</strong></p>
<label for="file">File</label>
  <input id="file" name="colorimage" type="file" /><br>
  Slug / Keyword<br>
  <input name="slug" size="10"><br>
  <input type="radio" name="color" value="green" checked="checked"> Green<br>
  <input type="radio" name="color" value="yellow"> Yellow<br>
  <input type="radio" name="color" value="red"> Red<br>
  <button>Upload</button>
  <?php 
global $post;
$nonce = wp_create_nonce('timer_upload');
update_post_meta($post->ID,'timer_nonce',$nonce);
printf('<input type="hidden" name="timer_upload" value="%s" /><input type="hidden" name="post_id" value="%d" /><input type="hidden" id="checkcheck" value="%s" />',$nonce,$post->ID,wp_create_nonce( 'wp_rest' ));
?>
</form>
<?php
}
?>

</div><!-- end timer controls -->


		</div>



	</div>

  </div>

  <input type="hidden" id="seturl" value="<?php echo site_url( '/wp-json/toasttimer/v1/control/' . $post->ID ); ?>" />

</div>

<?php

if ( ! empty( $_GET['embed'] ) && empty( $name ) ) {

	printf( '<h1>%s</h1><p>To join the online meeting</p><ul>', $post->post_title );

	printf( '<li>Members please <a href="%s">login</a></li>', wp_login_url( sanitize_text_field($_SERVER['REQUEST_URI']) ) );

	printf( '<li>Guests, please enter the email you used to RSVP</li></ul><form action="%s" method="get"><p>Email <input type="text" name="email"></p><input type="hidden" name="jitsi" value="1"><p><button>Submit</button></p>%s</form></p>', site_url( sanitize_text_field($_SERVER['REQUEST_URI']) ), rsvpmaker_nonce('return') );

} elseif ( empty( $_GET['embed'] ) ) {

	?>

<div id="jitsi">

	<?php

	printf( '<div id="timer2021"><img src="%s" width="150" height="155"></div>', plugins_url( 'rsvpmaker-for-toastmasters/stopwatch.png' ) );

	?>

<div id="instructions">

<h1>Usage Tips</h1>

<p>Speakers and Evaluators from the agenda should be listed under Speakers/Speech Type, along with the associated time for their speeches. This is also true for contestants in a speech contest.</p>

<p>You can also set the standard timing for Table Topics and Evaluations, or set custom timing. The Correction control can be used to make minor adjustments, for example if you started timing a few seconds late.</p>

<p>In a Zoom meeting, you can share the color indicators using webcam software or a video streaming software such as <a href="https://obsproject.com/" target="_blank">OBS Studio</a>. (<a href="https://www.wp4toastmasters.com/2021/02/02/showing-the-online-timer-in-zoom-with-obs-studio-2021-tutorial/" target="_blank">Learn how</a>)</p>

<p>Another technique is to share a <a href="<?php echo get_permalink(); ?>?timer=1&audience=1">view timer link</a> with the audience. See <a href="https://www.wp4toastmasters.com/2020/05/10/online-timer-zoom/" target="_blank">blog post</a>.</p>



<h2>Contest Timer</h2>

<p>When used in the context of a contest, a Timer's Report form is displayed that you should use to report results even if you share the timer colors some other way. Contest organizers will be able to see within seconds whether anyone has been disqualified.</p>

<p>Contestants will be listed under Speakers/Speech Type, according to the official speaking order. When you click Stop on the timer, the speaker's time will be added to the Timer's Report form, with the Disqualified checkbox check for times over or under by more than 30 seconds. You can make adjustments as necessary.</p>

</div>



</div>

		<?php

} elseif ( ( $_GET['embed'] == 'zoom' ) && empty( $_GET['zoom_login_confirmed'] ) ) {

	printf( '<h1>Confirm Your Zoom Login</h1><p>To use the web-based version of Zoom, you must first <a href="https://zoom.us/signin" target="_blank">login at zoom.us</a></p><p><a href="%s">Refresh this page</a> when you have confirmed you are logged into Zoom.</p>', get_permalink() . '?timer=1&embed=zoom&zoom_login_confirmed=1' );

} elseif ( $_GET['embed'] == 'zoom' ) {

		$meeting_id = get_post_meta( $post->ID, 'zoom_meeting_id', true );

	if ( empty( $meeting_id ) ) {

		$online     = get_option( 'tm_online_meeting' );

		$meeting_id = ( empty( $online['personal_meeting_id'] ) ) ? '' : $online['personal_meeting_id'];

	}

	if ( $meeting_id ) {

		$meeting_id = preg_replace( '/[^0-9]/', '', $meeting_id ); // remove any dashes

		echo '<div id="jitsi">' . do_shortcode( '[zoom_api_link meeting_id="' . $meeting_id . '" link_only="no"]' ) . '

            <p>To start meeting as host, log in at <a href="https://zoom.us/signin" target="_blank">zoom.us/signin</a>, then refresh this page.</p></div>';

	} else {

		echo '<p>Zoom meeting ID not set</p>';

	}

} else {

	echo '<div id="jitsi"></div><input type="hidden" id="is_jitsi" value="1" >';

}



$users = get_club_members();

foreach ( $users as $user ) {

	$userdata = get_userdata( $user->ID );

	$u[]      = $userdata->first_name . ' ' . $userdata->last_name;

}

if ( ! empty( $u ) ) {

	sort( $u );

}

{

?>

<script>

  $( function() {

	var members = <?php echo json_encode( $u ); ?>;

	$( "#speakername" ).autocomplete({

	  source: members

	});

  } );

<?php

if ( isset( $_GET['embed'] ) && ( $_GET['embed'] == 'jitsi' ) ) {

	?>

const domain = 'meet.jit.si';

const options = {

	roomName: '

	<?php

	$room_name = get_post_meta( $post->ID, 'jitsi_room_name', true );

	if ( empty( $room_name ) ) {

		$room_name = $post->post_title . ' ' . rand();

		update_post_meta( $post->ID, 'jitsi_room_name', $room_name );

	}

	echo esc_html($room_name);

	?>

	',

	width: window.innerWidth - <?php echo esc_attr($widthadj); ?>,

	height: window.innerHeight - 50,

	parentNode: document.querySelector('#jitsi')

};

const api = new JitsiMeetExternalAPI(domain, options);

api.executeCommand('displayName', '<?php echo esc_attr($name); ?>');

api.executeCommand('email', '<?php echo esc_attr($email); ?>');

	<?php

}//end jitsi only

?>



</script>



<?php

}



do_action( 'timer_footer' );

?>

</body>

</html>

