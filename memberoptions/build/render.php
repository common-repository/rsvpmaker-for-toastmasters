<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render  
 */
global $rsvp_options;
$future_meetings = '';
$top_label = (is_user_logged_in()) ? 'Dashboard' : 'Login';
$top_link = (is_user_logged_in()) ? admin_url() : wp_login_url();
if(function_exists('future_toastmaster_meetings')) {
	$future = future_toastmaster_meetings(5);
	if($future)
	{
		$top_label = (is_user_logged_in()) ? 'Sign Up' : 'Login/Sign Up';
		$top_link = (is_user_logged_in()) ? get_permalink($future[0]->ID) : wp_login_url(get_permalink($future[0]->ID));
		foreach($future as $meeting)
		$future_meetings .= sprintf('<li class=" wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content" href="%s"><span class="wp-block-navigation-item__label">%s</span></a></li>',get_permalink($meeting->ID),rsvpmaker_date( $rsvp_options['short_date'], (int) $meeting->ts_start ));
	}
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
<div><a class="toastmasters-login-signup" href="<?php echo $top_link; ?>"><?php echo $top_label; ?></a></div>
<?php if(is_user_logged_in()) {
?>
<nav class="toastmasters-navigation is-responsive wp-block-navigation is-layout-flex wp-container-5" aria-label="Toastmasters Navigation"><button aria-haspopup="true" aria-label="Open menu" class="wp-block-navigation__responsive-container-open " data-micromodal-trigger="modal-99"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="4" y="7.5" width="16" height="1.5"></rect><rect x="4" y="15" width="16" height="1.5"></rect></svg></button>
<div class="wp-block-navigation__responsive-container  " style="" id="modal-99">
<div class="wp-block-navigation__responsive-close" tabindex="-1" data-micromodal-close="">
<div class="wp-block-navigation__responsive-dialog" aria-label="Menu">
<button aria-label="Close menu" data-micromodal-close="" class="wp-block-navigation__responsive-container-close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg></button>
<div class="wp-block-navigation__responsive-container-content" id="modal-99-content">

<ul class="wp-block-navigation__container">

<li class=" wp-block-navigation-item has-child open-on-hover-click wp-block-navigation-submenu">
<a class="wp-block-navigation-item__content" href="<?php admin_url('profile.php'); ?>">Edit Profile</a>
<button aria-label="Login submenu" class="wp-block-navigation__submenu-icon wp-block-navigation-submenu__toggle" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true" focusable="false"><path d="M1.50002 4L6.00002 8L10.5 4" stroke-width="1.5"></path></svg></button>
<ul class="wp-block-navigation__submenu-container wp-block-navigation-submenu">
<li class=" wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content" href="<?php echo admin_url('profile.php#simple-local-avatar-section'); ?>"><span class="wp-block-navigation-item__label">Profile Picture</span></a></li>
<li class=" wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content" href="<?php echo admin_url('profile.php#password'); ?>"><span class="wp-block-navigation-item__label">Password</span></a></li>
<?php 
if($future_meetings) {
	printf('<li class=" wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content" href="%s"><span class="wp-block-navigation-item__label">Dashboard</span></a></li>',admin_url());
	echo $future_meetings;
}
?>
</ul></li>
</ul>
</div>
</div>
</div>
</div></nav>
<?php } //end is logged in ?>
</div>
