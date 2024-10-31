<?php

function wp4t_block_theme_menu() {

	global $wpdb, $current_user;

	$menu_id = $wpdb->get_var("SELECT ID from $wpdb->posts WHERE post_type='wp_navigation' and post_status='publish' AND post_title='Toastmasters Navigation' ORDER BY ID DESC");

	if(!$menu_id)

	{

	$link_format = '<!-- wp:navigation-link {"label":"%s","type":"page","id":%d,"url":"%s","kind":"post-type","isTopLevelLink":true} /-->'."\n\n";

	$sql = "SELECT ID FROM $wpdb->posts WHERE post_status='publish' and post_name='calendar' ";

	$calendar_id = $wpdb->get_var($sql);

	$sql = "SELECT ID FROM $wpdb->posts WHERE post_status='publish' and post_name='members' ";

	$members_id = $wpdb->get_var($sql);

	$blog_id = get_option('page_for_posts');

	$home_id = get_option('page_on_front');

	if($home_id) {

		$menu['post_content'] = sprintf($link_format,__('Home','rsvpmaker-for-toastmasters'),$home_id,site_url());

		if($blog_id)

			$menu['post_content'] .= sprintf($link_format,__('Blog','rsvpmaker-for-toastmasters'),$blog_id,get_permalink($blog_id));

	}

	else

		$menu['post_content'] = sprintf('<!-- wp:navigation-link {"label":"'.__('Home','rsvpmaker-for-toastmasters').'","type":"custom",url":"%s","kind":"post-type","isTopLevelLink":true} /-->'."\n\n",site_url());

	if($calendar_id)

		$menu['post_content'] .= sprintf($link_format,__('Calendar','rsvpmaker-for-toastmasters'),$calendar_id,get_permalink($calendar_id));

	else {

		$post = array(

			'post_content' => '<!-- wp:rsvpmaker/upcoming {"calendar":"1","hideauthor":"true"} /-->',

			'post_name'    => 'calendar',

			'post_title'   => 'Calendar',

			'post_status'  => 'publish',

			'post_type'    => 'page',

			'post_author'  => $current_user->ID,

			'ping_status'  => 'closed',

		);

		$calendar_id = wp_insert_post( $post );

		$menu['post_content'] .= sprintf($link_format,__('Calendar','rsvpmaker-for-toastmasters'),$calendar_id,get_permalink($calendar_id));



	}

	if($members_id)

		$menu['post_content'] .= sprintf($link_format,__('Members','rsvpmaker-for-toastmasters'),$members_id,get_permalink($members_id));

	else {

		$post = array(

			'post_content' => '<!-- wp:shortcode -->

			[awesome_members comment="This placeholder code displays the member listing"]

			<!-- /wp:shortcode -->',

			'post_name'    => 'members',

			'post_title'   => 'Members',

			'post_status'  => 'publish',

			'post_type'    => 'page',

			'post_author'  => $current_user->ID,

			'ping_status'  => 'closed',

		);

		$members_id = wp_insert_post( $post );

		$menu['post_content'] .= sprintf($link_format,__('Members','rsvpmaker-for-toastmasters'),$members_id,get_permalink($members_id));

	}



	$menu['post_content'] .= '<!-- wp:navigation-link {"label":"Dashboard","url":"'.admin_url().'","kind":"custom","isTopLevelLink":true} /-->';



	$menu['post_title'] = 'Toastmasters Navigation';

	$menu['post_status'] = 'publish';

	$menu['post_type'] = 'wp_navigation';

	$menu['post_author'] = $current_user->ID;

	$menu_id = wp_insert_post($menu);

	}

return $menu_id;

}

function wpt_add_menu_to_nav($content, $menu_id) {

preg_match('/<!-- wp:navigation (\{){0,1}/',$content,$match);

if(empty($match[0]))

	;

elseif(empty($match[1]))

	$content = str_replace('wp:navigation', 'wp:navigation {"ref":'.$menu_id.'}',$content);

else

	$content = str_replace('wp:navigation {', 'wp:navigation {"ref":'.$menu_id.',',$content);

return $content;

}

function check_toastmasters_logo_header() {

global $wpdb;

$logo_id = get_option('site_logo');

if($logo_id) {
	$tag = get_custom_logo();
}

//if not defined or not installed locally
if(!$logo_id || !strpos($tag,$_SERVER['SERVER_NAME'])) {
	$logo_id = media_sideload_image('https://toastmost.org/tmbranding/toastmasters-75.png', 0, 'copy of Toastmasters logo','id' );
	update_option('site_logo',$logo_id);
}

$nav_menu_id = $wpdb->get_var("select ID from $wpdb->posts WHERE post_type='wp_navigation' AND post_status='publish' ");

if(!$nav_menu_id)
	$nav_menu_id = wp4t_block_theme_menu();
}

add_action('admin_init','check_toastmasters_logo_header');