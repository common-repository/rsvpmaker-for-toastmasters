<?php



add_shortcode('wp4t_todolist','wp4t_todolist_short');

function wp4t_todolist_short () {

    $blog_id = (is_multisite()) ? get_current_blog_id() : 1;

    $list = wp4t_todolist($blog_id);

    return $list;

}



function wp4t_todolist_screen() {

    $blog_id = (is_multisite()) ? get_current_blog_id() : 1;

    echo wp4t_todolist($blog_id);

    if(isset($_GET['weekly_reminder'])) {

        wp_schedule_event( time() + DAY_IN_SECONDS, 'weekly', 'wp4t_todolist_cron', array($blog_id, true) );

    }

    elseif(! wp_next_scheduled ( 'wp4t_todolist_cron', array($blog_id, true) )) {

        printf('<p><a href="%s">Send Weekly Reminder</a></p>',admin_url('admin.php?page=wp4t_todolist_screen&weekly_reminder=1'));

    }

}



function wp4t_todolist($blog_id, $send = false) {

    global $wpdb, $rsvp_options;

    if(is_multisite() && !get_site($blog_id))

        return; //maybe a deleted test site



    if(is_multisite())

    switch_to_blog($blog_id);

    $output = '<h2>This Is The Website Administrator Todo List</h2>'."\n";

    $theme = wp_get_theme();



    $demo_sites = array(

        "astra-tm" => "astra.toastmost.org",

        "lectern" => "lectern.toastmost.org",

        "twentynineteen-tm" => "2019.toastmost.org",

        "twentyseventeen-tm" => "2017.toastmost.org",

        "twentysixteen-tm" => "2016.toastmost.org",

        "twentytwenty-tm" => "2020.toastmost.org",

        "twentytwentyone-tm" => "2021.toastmost.org",

        "twentytwentyone-true-maroon" => "maroon.toastmost.org",

        "twentytwentytwo-tm" => "2022.toastmost.org",

        "twentytwentythree-tm" => "2023.toastmost.org",

        "wuqi-tm" => "wuqi.toastmost.org");

    

    if(isset($demo_sites[$theme->stylesheet]))

        $output .= sprintf('<h3><a target="_blank" href="https://%s">%s</a></h3><p>Consult this demo site for tips related to your chosentheme (design) choice, %s </p>',$demo_sites[$theme->stylesheet],$demo_sites[$theme->stylesheet], $theme->Name);

    if($fth = get_option('freetoasthost'))
    {
        $todo['freetoasthost'] = 'Your home page should include content imported from your old FreeToastHost website, and you can see what other content was imported by visiting the Free Toast Host Import screen. That tool also gives you the option of importing agendas from an FTH website.';
        $label['freetoasthost'] = 'Free Toast Host Import Tool';
        $link['freetoasthost'] = admin_url('admin.php?page=fth_importer_docs');
        $help['freetoasthost'] = 'hhttps://www.wp4toastmasters.com/2024/09/10/new-freetoasthost-import-tool/';
    }
    else
        $done['freetoasthost'] = 'You have the option of importing content from a FreeToastHost website. That tool also gives you the option of importing agendas from an FTH website.';


    $wizard_timestamp = (int) get_option('wp4t_setup_wizard_used');

    if(!$wizard_timestamp && !$fth)

        $todo['wizard'] = 'If you are still at the beginning of setting up your website, the setup wizard can make that easier.';

    $home = 0;

    if('page' == get_option('show_on_front')) {

        $home = get_option('page_on_front');

        $post = get_post($home);

        if(strpos($post->post_content,'Your custom welcome message here'))

            $todo['homepage'] =  'Home page still says "Your custom welcome message here"';

        else

            $done['homepage'] = 'Freshen up your home page?';        

    }



    if(!get_option('blog_public'))

        $todo['make_public'] = 'If you are ready to make your blog public (advertised in search engines), change the option at the top of the Toastmasters settings page.';



    //customize the agenda 

    $template = get_option('default_toastmasters_template');

    $revisions = wp_get_post_revisions($template);

    $agendaprompt = 'Update the agenda template to set up a standard model for the roles displayed on the agenda (and the signup form), as well as agenda notes ("stage directions" for the flow of the meeting), and timing for each activity.';

    if($revisions) {

        $done['agenda_customized'] = $agendaprompt;

    }

    else {

        $todo['agenda_customized'] = $agendaprompt;

    }

    //metric here?



    $members = get_club_members();

    $member_count = sizeof($members);

    if($member_count > 1)

        $done['members'] = "You have created $member_count member accounts. The more the merrier! You can create more member accounts one at a time, or import your whole membership list (which can be downloaded from toastmasters.org)";

    else

        $todo['members'] = 'Inviting in at least a few other members will make this website a more interesting place. You can create member accounts one at a time, or import your whole membership list (which can be downloaded from toastmasters.org).';

    //use the agenda to plan meetings



    $done['confirmation'] = '<strong>Meeting online?</strong> Edit your guest registration confirmation message to include online meeting details.';



    if($home)

    {

        $featured_image = get_the_post_thumbnail_url($home);

        if($featured_image) {

            /*

            $defaultimages = array('MEL_665-scaled',

            'public-speaking-3956908_1920',

            'MEL_534-scaled',

            'NBM_1721-scaled',

            '2019-LASTUDIO-5-scaled',

            '2019-LASTUDIO-6-scaled',

            '2019-LASTUDIO-7-scaled',

            '2019-LASTUDIO-8-scaled',

            '2019-LASTUDIO-9-scaled',

            '2019-LASTUDIO-16-scaled');

            $is_default = false;

            foreach($defaultimages as $img)

            {

                if(strpos($featured_image, $img))

                    $is_default = true;

            }

            if($is_default)

                $todo['change_featured_image'] = 'How to change the default image on the home page. Your current theme (WordPress design) is set up to use featured images at the top of the page, which can be different from page to page. Currently, you have one of the featured images from the initial setup on the home page.';

            else

                $done['change_featured_image'] = 'Looks like you know how to change the featured image, but here is a reminder just in case.';

            */

            $done['change_featured_image'] = 'Your current theme (WordPress design) is set up to let you set a featured images for each page. If you do not like the one currently shown on the home page, you can change it or remove it. You can have a different featured image for each page.';

        }

        //does the home page have a featured image? Is it one of the defaults? Instructions on how to change

    }



    if($theme->stylesheet == 'twentytwentytwo-tm')

    {

        $label['theme2022'] = 'Edit the header and menu <em>(new Full Site Editing method)</em>';

        $link['theme2022'] = admin_url('site-editor.php?postType=wp_template_part&postId=twentytwentytwo-tm%2F%2Fheader');

        $help['theme2022'] = 'https://2022.toastmost.org';

        $done['theme2022'] = 'Learn the new method for changing layout elements such as navigation menus with the new Full Site Editor feature.';

    }

    else {

        /*

        $label[$theme->stylesheet] = 'Tips for '.$theme->stylesheet;

        $link[$theme->stylesheet] = admin_url('site-editor.php?postType=wp_template_part&postId=twentytwentytwo-tm%2F%2Fheader');

        $help[$theme->stylesheet] = 'https://2022.toastmost.org';

        $done[$theme->stylesheet] = 'Learn the new method for changing layout elements such as navigation menus with the new Full Site Editor feature.';

        */

    }



    //add_theme_support( 'custom-header' ); get_header_image() 

    if(current_theme_supports('custom-header')) {

        //how to change

        $done['change_custom_header'] = 'Your current theme (WordPress design) allows you to set a custom image that appears at the top of each page. You can change the one that is currently displayed.';

    }





    /*

    $theme = get_option('current_theme');

    $status['theme'] = $theme;

    $theme_changed = (('Lectern' != $theme) && ('Twenty Nineteen TM' != $theme));

    if($theme_changed)

        $done['change_theme'] = 'Looks like you have already changed the default theme.';

    else

    */

    $done['change_theme'] = "If you don't like the way your website looks, you have the option of changing the theme (design) and customizing from there.";

    //give advice for specific themes



    //create a page and add it to the menu



    //creeate a blog post



    //setup online payments

    $stripe = get_rsvpmaker_stripe_keys();

    $paypal = get_option('rsvpmaker_paypal_rest_keys');

    $payments = array();

    if(!empty($paypal['client_id']))

    $payments[] = 'PayPal production keys';

    if(!empty($paypal['sandbox_client_id']))

    $payments[] = 'PayPal sandbox keys';

    if(!empty($stripe['pk']))

    $payments[] = 'Stripe production keys';

    if(!empty($stripe['sandbox_pk']))

    $payments[] = 'Stripe sandbox keys';



    if(empty($payments)) {

        $todo['payments'] = 'Online payments not yet set up';

    }

    else {

        $done['payments'] = 'Online payments set up so far: '.implode(', ',$payments);

    }



    $dues = get_option( 'club_dues' );

    if(empty($dues))

        $todo['member_application'] = 'The web-based application lets you invite new members to enroll by filling out a web-based form, with an online payment option presented at the end of the process. Use it to move beyond paper-based/PDF-based processes';

    else

        $done['member_application'] = 'You have set up the online application. Revisit this settings page if you need to update the dues schedule or other settings';



    $label['wizard'] = 'Setup Wizard';

    $link['wizard'] = admin_url('admin.php?page=wp4t_setup_wizard');

    $help['wizard'] = 'https://www.wp4toastmasters.com/knowledge-base/setup-wizard/';



    $label['homepage'] = 'Edit Home Page';

    $link['homepage'] = admin_url('post.php?action=edit&post='.$home);

    $help['homepage'] = 'https://www.wp4toastmasters.com/knowledge-base/how-to-add-wordpress-blocks-content-types/';



    $label['make_public'] = 'Make Site Public';

    $link['make_public'] = admin_url('admin.php?page=wp4toastmasters_settings');

    $help['make_public'] = 'https://www.wp4toastmasters.com/knowledge-base/toastmasters-settings/';



    $label['agenda_customized'] = 'Edit Agenda';

    $link['agenda_customized'] = admin_url('post.php?action=edit&post='.$template);

    $help['agenda_customized'] = 'https://www.wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/';



    $next = next_toastmaster_meeting();

    if(!empty($next)) {

        $label['agenda_use'] = 'Sign up for roles or assign them to other members.';

        $link['agenda_use'] = get_permalink($next->ID);

        $help['agenda_use'] = 'https://www.wp4toastmasters.com/knowledge-base/sign-up-for-a-role/';    

    }

    $label['members'] = 'Create member accounts';

    $link['members'] = admin_url('users.php?page=add_awesome_member');

    $help['members'] = 'https://www.wp4toastmasters.com/knowledge-base/create-member-accounts/';



    $label['payments'] = 'Set up online payments';

    $link['payments'] = admin_url('options-general.php?page=rsvpmaker_settings');

    $help['payments'] = 'https://www.wp4toastmasters.com/knowledge-base/online-payments-for-dues-and-events/';



    $label['member_application'] = 'Set up the web-based member application and dues schedule';

    $link['member_application'] = admin_url('options-general.php?page=member_application_settings');

    $help['member_application'] = 'https://www.wp4toastmasters.com/knowledge-base/web-based-toastmasters-membership-application/';



    $label['confirmation'] = 'Edit RSVP confirmation message';

    $link['confirmation'] = admin_url( 'post.php?post=' . $rsvp_options['rsvp_confirm'] . '&action=edit' );

    $help['confirmation'] = 'https://rsvpmaker.com/knowledge-base/confirmation-and-reminder-messages/?seq_no=2';



    if(function_exists('toastmost_club_email_list')) {

        $label['lists'] = 'Member and officer email lists';

        $link['lists'] = admin_url( 'admin.php?page=toastmost_club_email_list' );

        $help['lists'] = 'https://www.wp4toastmasters.com/knowledge-base/member-and-officer-email-lists-toastmost/';

        $done['lists'] = 'Set up private email discussion lists. Members can send a message to all other members, and officers can send a message to all other officers. By default, only messages from an email associated with the member profile will be shared with the group. You can whitelist or block additional addresses.';

    

        $label['forwarding'] = 'Email forwarding addresses';

        $link['forwarding'] = admin_url( 'admin.php?page=toastmost_forwarders' );

        $help['forwarding'] = 'https://www.wp4toastmasters.com/knowledge-base/email-forwarders/';

        $done['forwarding'] = 'Configure email forwarders, in addition to those provided by default for officer roles.';

        

        $label['findaclub'] = 'Handle Find-a-Club and other notifications from toastmasters.org';

        $link['findaclub'] = admin_url( 'admin.php?page=findaclub' );

        $help['findaclub'] = 'https://www.wp4toastmasters.com/knowledge-base/notification-tools-for-find-a-club-basecamp-and-other-toastmasters-org-notifications/';

        $done['findaclub'] = 'You can choose to set up an auto-response message for prospective member inquiries relayed through the Find-a-Club search on toastmasters.org. Forward Basecamp notifications and other notifications from toastmasters.org to the appropriate officers.';

    }

    //else mailing list setup for stanalone?



    $label['change_theme'] = 'Change the WordPress theme';

    $link['change_theme'] = admin_url('themes.php');

    $help['change_theme'] = 'https://www.wp4toastmasters.com/2020/11/09/video-change-the-look-of-your-club-website/';



    $label['change_featured_image'] = 'Change the featured image on the home page ';//.var_export($theme,true);

    $link['change_featured_image'] = admin_url('post.php?action=edit&post='.$home);

    $help['change_featured_image'] = 'https://firstsiteguide.com/wordpress-featured-image/';



    $label['change_custom_header'] = 'Change the header image that appears at the top of each page.';

    $link['change_custom_header'] = admin_url('customize.php');

    $help['change_custom_header'] = 'https://wordpress.com/support/custom-header-image/';



    if(is_plugin_active('jetpack/jetpack.php') && (get_option('jetpack_activated') != '1') ) // 2 if not connected

    {

        $done['jetpack'] = 'Jetpack plugin provides access to additional search engine optimization, performance, and social media features. Requires you to connect to the WordPress.com online service.';

    }



    $label['jetpack'] = 'Configure Jetpack';

    $link['jetpack'] = admin_url('admin.php?page=jetpack#/');

    $help['jetpack'] = 'https://www.wp4toastmasters.com/2020/11/19/jetpack-the-swiss-army-knife-plugin-for-your-website/';



    if(empty($todo))

        $output .= '<p>[none]</p>';

    

    foreach($todo as $slug => $status) {

        $l = $label[$slug];

        $u = $link[$slug];

        $h = $help[$slug];

        $output .= sprintf('<h3><a href="%s">%s</a> - <a href="%s" target="_blank">Help</a></h3>'."\n".'<p>%s</p>',$u,$l,$h,$status)."\n";

    }

    if(!empty($done)) {

    $output .= '<h2>The Items Below Are Optional Or Already Started</h2>'."\n";

        foreach($done as $slug => $status) {

            $l = $label[$slug];

            $u = $link[$slug];

            $h = $help[$slug];

            $output .= sprintf('<h3><a href="%s">%s</a> - <a href="%s" target="_blank">Help</a></h3>'."\n".'<p>%s</p>',$u,$l,$h,$status)."\n";

        }

    }

    //$output .= var_export($done,true);

    $output .= '<h2>Need More Help?</h2><p>See the <a href="https://www.wp4toastmasters.com/knowledge-base/">WordPress for Toastmasters knowledge base</a> and <a href="https://www.wp4toastmasters.com/video-course/">Video Course</a>.

    Or write to <a href="mailto:david@wp4toastmasters.com?subject=Todo page query">david@wp4toastmasters.com</a>.</p>

    <p>There is also a <a href="https://www.facebook.com/groups/wp4toastmasters">Facebook group</a> where users of the software and the Toastmost service can compare notes and give feedback.</p>';

    $output .= '<h2>Volunteer Help</h2><p>The WordPress for Toastmasters project is looking for volunteers to help with documentation and training materials.

    If you have web programming or design skills, this is open source software for which your contributions are welcome. 

    Write to <a href="mailto:david@wp4toastmasters.com?subject=Todo page volunteer">david@wp4toastmasters.com</a>.</p>';



    if(isset($_GET['cancel_reminder'])) {

        wp_clear_scheduled_hook('wp4t_todolist_cron', array($blog_id, true) );

    }

    elseif( wp_next_scheduled ( 'wp4t_todolist_cron', array($blog_id, true) )) {

        $output .= sprintf('<p><a href="%s">Cancel Todo List reminder emails</a></p>',admin_url('admin.php?page=wp4t_todolist_screen&cancel_reminder=1'));

    }



    if($send) {

        $mail['html'] = "<p>This email is intended to nudge you toward fleshing out your Toastmost website and taking full advantage of it. You can find the same list on the administrative dashboard under TM Administration.</p>\n".$output;

        $mail['subject'] = 'Toastmost.org todo list for '.get_bloginfo('name');

        $mail['from'] = 'david@wp4toastmasters.com';

        $mail['fromname'] = 'Toastmost.org';

        $blogusers = get_users( array( 'role__in' => array( 'administrator', 'manager' ), 'blog_id' => $blog_id ) );

        foreach ( $blogusers as $user ) {

            $mail['to'] = $user->user_email;

            rsvpmailer($mail);

        }

        $mail['to'] = 'david@carrcommunications.com';

        rsvpmailer($mail);

    }



    if(is_multisite())

    restore_current_blog();

    return $output;

}



add_action('wp4t_todolist_cron','wp4t_todolist',10,2);

