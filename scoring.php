<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
global $post;
$contest_name   = get_post_meta( $post->ID, 'toast_contest_name', true );
$dashboard_name = ( empty( $contest_name ) ) ? $post->post_title : $contest_name;
?>
<title>
<?php
global $post;
echo esc_html($dashboard_name);
?>
 - Scoring 
 <?php
	if ( $_GET['scoring'] == 'dashboard' ) {
		echo 'Dashboard';}
	?>
	</title>

<?php
	wp_head();
?>
<style>
input,select {max-width: 45%; min-width: 100px;}
#scorebody { margin: 10px; background-color: #fff; padding: 15px;}
	input.setscore {width: 50px;}
	h2.nav-tab-wrapper {
	margin:22px 0 0 0;
	padding-bottom: 30px;
}

#sections {
	padding:22px;
	background: #fff;
	border:1px solid #ccc;
	border-top:0px;
}

section.nav-tab {
	display:none;
}
.nav-tab-wrapper {
	background-color: #efefef;
}
.nav-tab {
	background-color: gray;
	color: #fff;
	display: inline-block;
	margin-right: 5px;
	border: thin solid gray;
	border-bottom: none;
}
.nav-tab-active {
	color: #000;
	background-color: #fff;
}

section.nav-tab-active {
	display:block;
	border: medium solid gray;
}

.no-js h2.nav-tab-wrapper {
	display:none;
}

.no-js #sections {
	border-top:1px solid #ccc;
	margin-top:22px;
}

.no-js section {
	border-top: 1px dashed #aaa;
	margin-top:22px;
	padding-top:22px;
}

.no-js section:first-child {
	margin:0px;
	padding:0px;
	border:0px;
}
a {
	color: blue;
}
.other {
	display: none;
}
h1, h2, h3, h4 {
	clear: none;
}
.email_links {display: none;}
#voting label {
	display: inline-block;
	width: 100px;
}
.ballot_links_preview {
	display: none;
}
input[type=checkbox],input[type=radio]{
	min-width: auto !important;
}
#morecontests {
	display: none;
}
.more {
	padding-top: 5px;
	padding-bottom: 5px;
	border-bottom: thin dotted #000;
}
body {
	color: #000;
}
</style>
</head>
<body>
<div id="scorebody">

<?php
if ( isset( $_REQUEST['scoring'] ) ) {
	echo toast_contest( $_REQUEST['scoring'] );
}
?>
</div>
</body>
</html>
