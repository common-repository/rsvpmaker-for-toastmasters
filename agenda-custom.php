<?php
if ( isset( $_GET['word_agenda'] ) ) {
	global $post;
	header( 'Content-Type: application/msword' );
	header( 'Content-disposition: attachment; filename=' . $post->post_name . '.doc' );
}
global $post;
$layout = get_post_meta($post->ID,'rsvptoast_agenda_layout',true);
if(empty($layout)) {
	$template_id = rsvpmaker_has_template($post->ID);
	$layout = get_post_meta($template_id,'rsvptoast_agenda_layout',true);
}
if(empty($layout)) // default
	$layout      = wp4toastmasters_agenda_layout_check(  );
$layout_post = get_post( $layout );
if(empty($layout_post))
{
	$layout      = wp4toastmasters_agenda_layout_check(  );
	$layout_post = get_post( $layout );
}
if(isset($_GET["test"])) {
	echo "layout id $layout";
	print_r($layout_post);
	exit();	
}
if ( ! isset( $_GET['reset'] ) ) {
	$layout_css = get_post_meta( $layout, '_rsvptoast_agenda_css_2018-07', true );
}
if ( empty( $layout_css ) ) {
	$layout_css = wpt_default_agenda_css();
	update_post_meta( $layout, '_rsvptoast_agenda_css_2018-07', $layout_css );
}
if ( isset( $_GET['word_agenda'] ) ) {
	$layout_css .= '.dateblock {margin-bottom: -1em;}';
}

?>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<style>
<?php 
	echo wpt_default_agenda_css();
	$main = get_option( 'wp4toastmasters_agenda_font_main' );
	if($main) {
		printf('#agenda, #agenda p, #agenda div, #agenda li {font-size: %dpx;} ',$main);
		printf('#agenda h3 {font-size: %dpx;} #agenda h2 {font-size: %dpx;} #agenda h1 {font-size: %dpx;} ',$main+2,$main+4,$main+6 );
	}
	$side = get_option( 'wp4toastmasters_agenda_font_sidebar' );
	if($side)
		printf('#agenda-sidebar, #agenda-sidebar p, #agenda-sidebar div, #agenda-sidebar li {font-size: %dpx;} ',$side);
	echo get_option( 'wp4toastmasters_agenda_css' );
?>
</style>
</head>

<body lang=EN-US style='tab-interval:.5in' <?php if(isset($_GET['no_print'])) echo ' id="show" '; ?> >
<div class="Section1">
<?php
if(isset($_GET['simple'])) {
	$output = '<h2>'.tmlayout_meeting_date()."</h2>\n".tm_agenda_content();
}
else {
	if ( function_exists( 'do_blocks' ) ) {
		$layout_post->post_content = do_blocks( $layout_post->post_content );
	}
	$output = wpautop( convert_chars( wptexturize( do_shortcode( $layout_post->post_content ) ) ) );	
}
if ( isset( $_GET['word_agenda'] ) || isset( $_GET['word_test'] ) ) {
	$output = str_replace( '</p>', '</p><p>&nbsp;</p>', $output );
	$output = str_replace( '</div>', '</div><p>&nbsp;</p>', $output );
}

echo $output;
?>
</div>
<?php
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
