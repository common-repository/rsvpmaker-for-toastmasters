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
	echo '.dateblock {margin-bottom: -1em;}';
}

?>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<style>
<?php 
if(empty($_GET['simple']))
{
	echo wpt_default_agenda_css(); 
	echo get_option( 'wp4toastmasters_agenda_css' );
}
if (class_exists('PrintFriendly_WordPress'))
{
	echo "<style type=\"text/css\">
	@media screen {
		  .printfriendly {
			 position: relative;
			  z-index: 1000;
		   margin: 
			  0px 0px 0px 0px                     ;
		}
		.printfriendly a, .printfriendly a:link, .printfriendly a:visited, .printfriendly a:hover, .printfriendly a:active {
			 font-weight: 600;
			cursor: pointer;
			 text-decoration: none;
		   border: none;
			-webkit-box-shadow: none;
			-moz-box-shadow: none;
		   box-shadow: none;
			outline:none;
			  font-size: 14px !important;
			  color: #3AAA11 !important;
		 }
		.printfriendly.pf-alignleft {
			float: left
		  }
		.printfriendly.pf-alignright {
		   float: right;
		}
		.printfriendly.pf-aligncenter {
			  display: flex;
		   align-items: center;
			 justify-content: center;
		 }
	}
}

@media print {
   .printfriendly {
		 display: none;
   }
}

.pf-button-img {
	 border: none;
	-webkit-box-shadow: none; 
   -moz-box-shadow: none; 
	  box-shadow: none; 
   padding: 0; 
	 margin: 0;
   display: inline; 
	vertical-align: middle;
  }

 img.pf-button-img + .pf-button-text {
	margin-left: 6px;
}
</style>

<style type=\"text/css\" id=\"pf-excerpt-styles\">
.pf-button.pf-button-excerpt {
	display: none;
 }
</style>";
}
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
if (class_exists('PrintFriendly_WordPress'))
$output .= do_shortcode('[printfriendly]')."
<script type=\"text/javascript\" id=\"pf_script\">
var pfHeaderImgUrl = '';
var pfHeaderTagline = '';
var pfdisableClickToDel = '0';
var pfImagesSize = 'full-size';
var pfImageDisplayStyle = 'block';
var pfEncodeImages = '0';
var pfShowHiddenContent  = '0';
var pfDisableEmail = '0';
var pfDisablePDF = '0';
var pfDisablePrint = '0';
var pfCustomCSS = '';
var pfPlatform = 'WordPress';

(function($){
$(document).ready(function(){
if($('.pf-button-content').length === 0){
$('style#pf-excerpt-styles').remove();
}
});
})(jQuery);
</script>
<script defer src='https://cdn.printfriendly.com/printfriendly.js'></script>";

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
