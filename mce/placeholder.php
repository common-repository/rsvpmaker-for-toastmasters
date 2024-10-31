<?php
// Create a 800*100 image

$impath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'placeholder.png';
$im     = imagecreatefrompng( $impath );
if ( ! $im ) {
	$im = imagecreate( 800, 50 );
	imagefilledrectangle( $im, 5, 5, 790, 45, imagecolorallocate( $im, 50, 50, 255 ) );
}

// White background and blue text
$bg        = imagecolorallocate( $im, 200, 200, 255 );
$border    = imagecolorallocate( $im, 0, 0, 0 );
$textcolor = imagecolorallocate( $im, 255, 255, 255 );


$text = '';

if ( isset( $_GET['role'] ) ) {
	$text = sprintf( 'Role: %s Count: %s', sanitize_text_field($_GET['role']), (int) $_GET['count'] );
	$tip  = '(double-click for popup editor)';
} elseif ( isset( $_GET['agenda_note'] ) ) {
	$text = sprintf( 'Note: %s Display: %s', sanitize_textarea_field($_GET['agenda_note']), sanitize_text_field($_GET['agenda_display']) );
	$tip  = '(double-click for popup editor)';
} elseif ( isset( $_GET['themewords'] ) ) {
	$text = 'Placeholder for Theme/Words of the Day';
	$tip  = '(no popup editor)';
} else {
	$text = 'error: unrecognized';
}

// Write the string at the top left
imagestring( $im, 5, 10, 10, $text, $textcolor );
imagestring( $im, 5, 10, 25, $tip, $textcolor );

// Output the image
header( 'Content-type: image/png' );

imagepng( $im );
imagedestroy( $im );

