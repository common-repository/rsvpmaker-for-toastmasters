<?php
global $post;
header( 'Content-Type: application/msword' );
header( 'Content-disposition: attachment; filename=' . $post->post_name . '.doc' );
$layout = get_post_meta($post->ID,'rsvptoast_agenda_layout',true);
if(empty($layout)) {
	$template_id = rsvpmaker_has_template($post->ID);
	$layout = get_post_meta($template_id,'rsvptoast_agenda_layout',true);
}
if(empty($layout)) // default
	$layout      = wp4toastmasters_agenda_layout_check(  );
$layout_post = get_post( $layout );
if ( ! isset( $_GET['reset'] ) ) {
	$layout_css = get_post_meta( $layout, '_rsvptoast_agenda_css_2018-07', true );
}
if ( empty( $layout_css ) ) {
	$layout_css = wpt_default_agenda_css();
	update_post_meta( $layout, '_rsvptoast_agenda_css_2018-07', $layout_css );
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
echo get_option( 'wp4toastmasters_agenda_css' );
?>
.dateblock {margin-bottom: -1em;}
</style>
</head>

<body lang=EN-US style='tab-interval:.5in' <?php if(isset($_GET['no_print'])) echo ' id="show" '; ?> >
<div class="Section1">
<?php
$content = $layout_post->post_content;
$content = preg_replace('|<!-- wp:columns -->[^<]+<div class="wp-block-columns">|s','<table class="layout_table" style="width: 700px;"><tr>',$content);
$content = preg_replace("|<\/div>[^<]+<!-- \/wp:columns -->|s",'</tr></table>',$content);
$content = preg_replace('|<!-- wp:column {"width":"([0-9\.\%]+)"} -->[^<]+<div[^>]+>|s','<td style="width: $1">',$content);
$content = preg_replace("|<\/div>[^<]+<!-- \/wp:column -->|s",'</td>',$content);
$content = do_blocks( $content );
$output = wpautop( convert_chars( wptexturize( do_shortcode( $content ) ) ) );	
$output = str_replace( '</p>', '</p><p>&nbsp;</p>', $output );
$output = str_replace( '</div>', '</div><p>&nbsp;</p>', $output );

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
