<?php
if ( isset( $_GET['word_agenda'] ) ) {
	global $post;
	header( 'Content-Type: application/msword' );
	header( 'Content-disposition: attachment; filename=' . $post->post_name . '.doc' );
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<!-- No Sidebar Agenda Template -->
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
</style>
</head>

<body lang=EN-US style='tab-interval:.5in'>
<div class="Section1">
<?php
the_post();
global $post;
global $wpdb;
global $rsvp_options;
$custom = get_post_custom( $post->ID );

if ( function_exists( 'get_rsvp_date' ) ) {
	$datestring = get_rsvp_date( $post->ID );
} else {
	$sql        = 'SELECT datetime FROM ' . $wpdb->prefix . 'rsvp_dates WHERE postID=' . $post->ID . ' ORDER BY datetime';
	$datestring = $wpdb->get_var( $sql );
}
$date = rsvpmaker_date( $rsvp_options['long_date'], rsvpmaker_strtotime( $datestring ) );

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
?>
<table width="700">
<tr><td width="*">
<h1><?php echo get_bloginfo( 'name' ); ?></h1>
<h2>
<?php
the_title();
echo ' ' . $date;
?>
</h2>
</td><td width="80">
<?php echo tm_branded_image( 'toastmasters-75.png' ); ?>
<!-- img src="< ?php echo plugins_url('rsvpmaker-for-toastmasters/toastmasters-75.png'); ?>" width="75" height="65" / -->
</td></tr>
</table>
<div id="agenda">
<?php
echo tm_agenda_content();
?>
</div>
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
