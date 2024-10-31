<?php
if ( isset( $_GET['word_agenda'] ) ) {
	global $post;
	header( 'Content-Type: application/msword' );
	header( 'Content-disposition: attachment; filename=' . $post->post_name . '.doc' );
}
the_post();
global $post;

global $wpdb;
global $rsvp_options;
$custom = get_post_custom( $post->ID );
if ( ! isset( $custom['_sked'][0] ) ) {
	if ( function_exists( 'get_rsvp_date' ) ) {
		$datestring = get_rsvp_date( $post->ID );
		if ( ! empty( $_GET['debug'] ) ) {
			echo "<p>get_rsvp_date: $datestring </p>";
		}
	} else {
		$sql        = 'SELECT datetime FROM ' . $wpdb->prefix . 'rsvp_dates WHERE postID=' . $post->ID . ' ORDER BY datetime';
		$datestring = $wpdb->get_var( $sql );
		if ( ! empty( $_GET['debug'] ) ) {
			echo "<p>$sql : $datestring </p>";
		}
	}
	$date = rsvpmaker_date( $rsvp_options['long_date'], rsvpmaker_strtotime( $datestring ) );
} else {
	$date = ' (' . __( 'Template', 'rsvpmaker-for-toastmasters' ) . ')';
}

global $wp_filter;
$corefilters = array( 'convert_chars', 'wpautop', 'wptexturize' );
foreach ( $wp_filter['the_content'] as $priority => $filters ) {
	foreach ( $filters as $name => $details ) {
		// keep only core text processing or shortcode
		if ( ! in_array( $name, $corefilters ) && ! strpos( $name, 'hortcode' ) ) {
			$r = remove_filter( 'the_excerpt', $name, $priority );
			$r = remove_filter( 'the_content', $name, $priority );
		}
	}
}
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<!-- Sidebar Agenda Template -->
<!--[if gte mso 9]>
<xml>
<w:WordDocument>
<w:View>Print</w:View>
<w:Zoom>90</w:Zoom>
<w:DoNotOptimizeForBrowser/>
</w:WordDocument>
</xml>
<![endif]-->
<style>
<!-- /* Style Definitions */
<?php echo wpt_default_agenda_css(); ?>
<?php echo get_option( 'wp4toastmasters_agenda_css' ); ?>
</style>
<!-- agenda with sidebar -->
</head>

<body lang=EN-US style='tab-interval:.5in'>
<div class="Section1">
<div id="banner">
<?php echo tm_branded_image( 'agenda-rays.png' ); ?>
<!--img src="< ?php echo plugins_url('rsvpmaker-for-toastmasters/agenda-rays.png'); ?>" width="700" height="79" -->
</div>
<h2 id="title"><?php echo get_bloginfo( 'name' ); ?><?php echo ' - ' . $date; ?></h2>
<table id="main" width="700">
<tr>
<td id="sidebar" width="175">
<?php

// display sidebar specific to post, sidebar specific to template, or sidebar set in options - or default message

	$template_sidebar = ( isset( $custom['_meet_recur'][0] ) ) ? get_post_meta( $custom['_meet_recur'][0], '_tm_sidebar', true ) : '';
	$option_sidebar   = get_option( '_tm_sidebar' );

if ( ! empty( $custom['_tm_sidebar'][0] ) ) {
	$sidebar  = $custom['_tm_sidebar'][0];
	$officers = $custom['_sidebar_officers'][0];
} elseif ( ! empty( $template_sidebar ) ) {
	$sidebar  = $template_sidebar;
	$officers = get_post_meta( $custom['_meet_recur'][0], '_sidebar_officers', true );
} elseif ( ! empty( $option_sidebar ) ) {
	$sidebar  = $option_sidebar;
	$officers = get_option( '_sidebar_officers' );
} else {
	$sidebar = sprintf( __( '<p>Set sidebar text using the <a href="%s">Agenda Sidebar editor</a></p>', 'rsvpmaker-for-toastmasters' ), admin_url( 'edit.php?post_type=rsvpmaker&page=agenda_sidebar&post_id=' . $post->ID ) );
}

echo wpautop( trim( str_replace( '&nbsp;', '', $sidebar ) ) );

$atts['sep'] = 'br';
if ( isset( $officers ) ) {
	echo '<p>';
	echo toastmaster_officers( $atts );
	echo '</p>';
}
?>
</td>
<td id="agenda" width="*">
<?php
echo tm_agenda_content();
?>
</td>
</tr>
</table>
</div>
	
<?php
// if(!isset($_GET["word_agenda"]))
   // agenda_timing_footer($datestring);
if ( ! isset( $_GET['word_agenda'] ) && ! isset( $_GET['no_print'] ) ) {
	echo '<script type="text/javascript">
<!--
window.print();
//-->
</script>
';
}
?>
</body>
</html>
