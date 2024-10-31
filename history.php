<?php
/*
* Speech and role history
*/

function wp4toastmasters_history() {

    $nonce = wp_create_nonce( 'tm_export' );

	$timelord = rsvpmaker_nonce('query');

	$export_link = sprintf( '<a href="%s?page=%s&tm_export=%s&%s">Export Summary</a>', admin_url( 'admin.php' ), 'import_export', $nonce,$timelord );

	$export_role = sprintf( '<a href="%s?page=%s&tm_export=%s&%s&role=1">Export Role Report</a>', admin_url( 'admin.php' ), 'import_export', $nonce,$timelord );

    $sidebar = sprintf('<div>Export Options (Spreadsheet/CSV)<br>%s<br>%s</div>',$export_link,$export_role);

    wpt_rsvpmaker_admin_heading(__('Reports','rsvpmaker-for-toastmasters'),__FUNCTION__,'',$sidebar);

    //$hook = tm_admin_page_top(__('Reports','rsvpmaker-for-toastmasters'),$sidebar);

    if(empty($_GET['rsvp_print']))

        update_user_role_archive_all();

    global $wpdb, $rsvp_options, $current_user, $page;

    $history_table = $wpdb->base_prefix.'tm_history';

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

    $startover = isset($_GET['startover']);

    update_user_role_archive_all();

    $output = '';

    if(isset($_GET['user_id']))

        $user_id = intval($_GET['user_id']);

    else

        $user_id = ('my_progress_report' == $_GET['page']) ? $current_user->ID : 0;

        $members = get_club_members();

        foreach($members as $member)

            $and[] = 'user_id='.$member->ID;

        $where = 'WHERE 1 AND ('.implode(' OR ',$and).')';

        $allchecked = '';

        $notallchecked = '';

        $datechecked = '';

        $nodatechecked = '';

        $speakerchecked = '';

        $pathchecked = '';

        $countbyrolechecked = '';

        $countspeecheschecked = '';

        $mostactivechecked = '';

        $latestchecked = '';



        if(isset($_GET['limit'])) {

            $limit = sanitize_text_field($_GET['limit']);

            if($limit == 'all')

                $limitsql = '';

            else

               $limitsql = ' LIMIT 0,'.$limit; 

        }

        else

            {

                $limit = 100;

                $limitsql = ' LIMIT 0,'.$limit; 

            }

        if(empty($_GET['all']))

            {

                $notallchecked = ' checked="checked" ';

                $where .= " AND domain='".$_SERVER['SERVER_NAME']."' ";

                $filters[] = 'for all member clubs on this website';

            }

        else

        {

            $allchecked = ' checked="checked" ';

            $filters[] = 'for clubs on this website';

        }

        if($user_id) {

            $where .= " AND user_id=" . $user_id. ' ';

            $filters[] = 'filtered by user';

        }

        if(!empty($_GET['datefilter']) && !empty($_GET['since']))

        {

            $datechecked = ' checked="checked" ';

            $date = sanitize_text_field($_GET['since']);

            $where .= sprintf(" AND datetime > '%s' ",$date);

            $filters[] = ' more recent than '.$date;

        }

        else {

            $nodatechecked = ' checked="checked" ';

            $filters[] = 'not filtered by date';

        }

        if(isset($_GET['type']) && ($_GET['type'] == 'speaker'))

        {

            $speakerchecked = ' checked="checked" ';

            $where .= " AND role LIKE '%Speaker%' ";

            $filters[] = 'speaker roles only';

            $sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where ORDER BY datetime DESC ".$limitsql;

            $results = $wpdb->get_results($sql);

            foreach($results as $row) {

                $temp = sprintf('<p><strong>%s</strong>, %s %s %s</p>',get_member_name($row->user_id),$row->role,rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($row->datetime)), $row->domain);

                $temp .= sprintf('<p class="speech_details">Title: <em>%s</em>, Path/Level: %s, Project: %s</p>',$row->title,$row->manual,$row->project);

                $output .= $temp;

                if(!empty($row->manual)) {

                    $index = (strpos($row->manual,'Level')) ? ' '.$row->manual : $row->manual;//pathways at top of list

                    $manualsort[$index] = $temp;

                }

            }

            ksort($manualsort);

            foreach($manualsort as $manual => $content)

                $output .= '<h2>'.$manual.'</h2>'.$content;

        }

        elseif(isset($_GET['type']) && ($_GET['type'] == 'path'))

        {

            $pathchecked = 'checked="checked"';

            $filters[] = 'speech by path';

            $where .= " AND role LIKE '%Speaker%' ";

            $sql = "SELECT  user_id, manual, count(manual) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id, manual ORDER BY user_id, manual".$limitsql;

            $results = $wpdb->get_results($sql);

            foreach($results as $row) {

                $index = wp4t_name_index($row->user_id);

                if(empty($msort[$index]))

                    $msort[$index] = '';

                $msort[$index] .= sprintf('<p><strong>%s</strong>, %s <strong>%s</strong></p>',get_member_name($row->user_id),$row->manual,$row->tally);

            }

            ksort($msort);

            $output .= implode("\n",$msort);

        }

        elseif(isset($_GET['type']) && ($_GET['type'] == 'countbyrole'))

        {

            $countbyrolechecked = ' checked="checked" ';

            $filters[] = 'count by member, by role';

            $sql = "SELECT  user_id, role, count(*) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id, role ORDER BY user_id, role ".$limitsql;

            $results = $wpdb->get_results($sql);

            foreach($results as $row) {

                $index = wp4t_name_index($row->user_id);

                if(empty($msort[$index]))

                    $msort[$index] = '';

                $msort[$index] .= sprintf('<p><strong>%s</strong>, %s %s</p>',get_member_name($row->user_id),$row->role,$row->tally);

            }

            ksort($msort);

            $output .= implode("\n",$msort);

        }

        elseif(isset($_GET['type']) && ($_GET['type'] == 'countspeeches'))

        {

            $countspeecheschecked = ' checked="checked" ';

            $filters[] = 'count speeches';

            $where .= " AND role = 'speaker' ";

            $sql = "SELECT  user_id, role, count(*) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id, role ORDER BY tally DESC ".$limitsql;

            $results = $wpdb->get_results($sql);

            foreach($results as $row) {

                $output .= sprintf('<p><strong>%s</strong>, %s %s</p>',get_member_name($row->user_id),$row->role,$row->tally);

            }

        }

        elseif(isset($_GET['type']) && ($_GET['type'] == 'mostactive'))

        {

            $mostactivechecked = ' checked="checked" ';

            $filters[] = 'count by most active';

            $sql = "SELECT  user_id, count(role) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id ORDER BY count(role) DESC".$limitsql;

            $results = $wpdb->get_results($sql);

            foreach($results as $row) {

                $output .= sprintf('<p><strong>%s</strong>, %s total roles</p>',get_member_name($row->user_id),$row->tally);

            }

        }

        else {

            $latestchecked = ' checked="checked" ';

            $filters[] = '100 most recent';

            $sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where ORDER BY datetime DESC ".$limitsql;

            $results = $wpdb->get_results($sql);

            foreach($results as $row) {

                $output .= sprintf('<p><strong>%s</strong>, %s %s %s</p>',get_member_name($row->user_id),$row->role,rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($row->datetime)), $row->domain);

                if(strpos($row->role,'peaker'))

                    $output .= sprintf('<p class="speech_details">Title: <em>%s</em>, Path/Level: %s, Project: %s</p>',$row->title,$row->manual,$row->project);

            }    

        }



    $year = (rsvpmaker_date('n') < 7) ? (rsvpmaker_date('Y') - 1) : rsvpmaker_date('Y');

    $since = (empty($_GET['since'])) ?  $year.'-07-01': sanitize_text_field($_GET['since']);

    if(empty($_GET['rsvp_print'])) {

        printf("<p>Active filters: %s</p>",implode(', ',$filters));

        printf('<form method="get" action="%s">

        <p>%s</p>

        <input type="hidden" name="page" value="toastmasters_reports" >

        Available filters: <br>

        <input type="radio" name="type" value="latest" %s> Latest <input type="radio" name="type" value="speaker" %s> Speeches <input type="radio" name="type" value="path" %s> Speeches by manual/path & level <input type="radio" name="type" value="mostactive" %s> Most Active <input type="radio" name="type" value="countbyrole" %s> Count by role <input type="radio" name="type" value="countspeeches" %s> Count speeches<br>

        <input type="radio" name="all" value="0" %s> Just for this club website <input type="radio" name="all" value="1" %s> Include data from other clubs (where available)<br>

        <input type="radio" name="datefilter" value="0" %s> Not filtered by date <input type="radio" name="datefilter" value="1" %s> Filtered by date > <input type="text" name="since" value="%s" > (YEAR-MONTH-DATE)<br>

        Up to <select name="limit"><option value="%s">%s</option> records

        <option value="100">100</option>

        <option value="200">200</option>

        <option value="300">300</option>

        <option value="400">400</option>

        <option value="500">500</option>

        <option value="all">%s</option>

        </select><br>

        <button>Filter</button>

        </form>',admin_url('admin.php'), awe_user_dropdown('user_id',$user_id, true, 'All Members'), $latestchecked, $speakerchecked, $pathchecked, $mostactivechecked, $countbyrolechecked, $countspeecheschecked, $notallchecked, $allchecked, $nodatechecked, $datechecked, $since, $limit, $limit, __('No limit','rsvpmaker-for-toastmasters') );    

    }

    echo $output;

}



function wp4toastmasters_history_edit() {

    echo '<h1>Edit Records</h1>';

    global $wpdb, $rsvp_options, $current_user, $page;

    $history_table = $wpdb->base_prefix.'tm_history';

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';



    if(isset($_POST['confirmed_delete'])) {

        foreach($_POST['confirmed_delete'] as $id)

        {

            $wpdb->query("delete from $history_table WHERE id=$id");

            $wpdb->query("delete from $speech_history_table WHERE history_id=$id");

            echo "<p>Deleted: $id</p>";

        }

    }



    if(isset($_POST['editor_assign'])) {

        foreach($_POST['editor_assign'] as $key => $value)

        {

            $role = clean_role($key);

            $id = preg_replace('/[^0-9]/','',$key);

            echo "<p>Updating $role record $id</p>";

            $sql = "update $history_table SET user_id=$value WHERE id=$id";

            $wpdb->query($sql);

            if('Speaker' == $role)

            {

                $manual = sanitize_text_field($_POST['_manual'][$key]);

                $project_key = sanitize_text_field($_POST['_project'][$key]);

                $project = get_project_text($project_key);

                $title = sanitize_text_field(stripslashes($_POST['_title'][$key]));

                $intro = wp_kses_post(stripslashes($_POST['_intro'][$key]));

                $sql = $wpdb->prepare("UPDATE $speech_history_table SET manual=%s, project_key=%s, project=%s, title=%s, intro=%s WHERE history_id=%d",$manual,$project_key,$project,$title,$intro,$id);

                $wpdb->query($sql);

            }

        }

    }



    if(isset($_POST['select'])) {

        foreach($_POST['select'] as $item){

            $p = explode(':',sanitize_text_field($item));

            if($p[0] == 'edit') 

                $edit[] = intval($p[1]);

            else

                $delete[] = intval($p[1]);

        }

        if(!empty($edit) || !empty($delete))

        printf('<h3>Form Starts Here</h3><form method="post" action="%s">',admin_url('admin.php?page=wp4toastmasters_history_edit'));

        if(!empty($edit)) {

            foreach($edit as $history_id) {

                foreach($edit as $history_id) {

                    $row = $wpdb->get_row("select * from $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id WHERE id=$history_id");

                    $role = $row->role;

                    $field = '_role_'.str_replace(' ','_',$role).'_'.$row->id;

                    $detailsform = '';

                    if($role == 'Speaker') {

                        $detailsform = speaker_details_history($row->post_id, $field, $row, $row->id );

                    }

                    $awe_user_dropdown = awe_user_dropdown( $field, $row->user_id );

                    printf('<div><h3>%s</h3><div> %s %s </div></div>',$role,$awe_user_dropdown,$detailsform);

                }    

            }

        }

        if(!empty($delete)) {

            echo '<h3>'.__('Confirm: Delete These Records?','rsvpmaker-for-toastmasters').'</h3>';

            foreach($delete as $history_id) {

                $row = $wpdb->get_row("select * from $history_table WHERE id=$history_id");

                printf('<p><input type="checkbox" name="confirmed_delete[]" value="%s" checked="checked"> %s %s %s</p>',$row->id,get_member_name($row->user_id),$row->role,$row->datetime);

            }

        }

        printf('<p><button style="font-size: larger;">%s</button></p></form>',__('Submit Edits','rsvpmaker_for_toastmasters'));

    }



    if(!empty($_POST['select']))

       {

        printf('<p><a href="%s">%s</a></p>',admin_url('admin.php?page=wp4toastmasters_history_edit'),__('Refresh','rsvpmaker-for-toastmasters'));

        return;

       } 



    $output = '<h2>Select Records</h2>';

    if(isset($_REQUEST['user_id']))

        $user_id = intval($_REQUEST['user_id']);

    else

        $user_id = 0;



        $members = get_club_members();

        foreach($members as $member)

            $and[] = 'user_id='.$member->ID;

        $where = 'WHERE 1 AND ('.implode(' OR ',$and).')';

        $allchecked = '';

        $notallchecked = '';

        $datechecked = '';

        $nodatechecked = '';

        $speakerchecked = '';

        $latestchecked = '';



        if(isset($_GET['limit'])) {

            $limit = sanitize_text_field($_GET['limit']);

            if($limit == 'all')

                $limitsql = '';

            else

               $limitsql = ' LIMIT 0,'.$limit; 

        }

        else

            {

                $limit = 100;

                $limitsql = ' LIMIT 0,'.$limit; 

            }

        if(empty($_GET['all']))

            {

                $notallchecked = ' checked="checked" ';

                $where .= " AND domain='".$_SERVER['SERVER_NAME']."' ";

                $filters[] = 'for all member clubs on this website';

            }

        else

        {

            $allchecked = ' checked="checked" ';

            $filters[] = 'for clubs on this website';

        }

        if($user_id) {

            $where .= " AND user_id=" . $user_id. ' ';

            $filters[] = 'filtered by user';

        }

        if(!empty($_GET['datefilter']) && !empty($_GET['since']))

        {

            $datechecked = ' checked="checked" ';

            $date = sanitize_text_field($_GET['since']);

            $where .= sprintf(" AND datetime > '%s' ",$date);

            $filters[] = ' more recent than '.$date;

        }

        else {

            $nodatechecked = ' checked="checked" ';

            $filters[] = 'not filtered by date';

        }

        if(isset($_GET['type']) && ($_GET['type'] == 'speaker'))

        {

            $speakerchecked = ' checked="checked" ';

            $where .= " AND role LIKE '%Speaker%' ";

            $filters[] = 'speaker roles only';        

        }

        else 

            $latestchecked = ' checked="checked" ';

        $sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where ORDER BY datetime DESC ".$limitsql;

        $results = $wpdb->get_results($sql);

        foreach($results as $row) {

            $controls = sprintf('<input type="radio" name="select[%d]" value="edit:%s"> %s <input type="radio" name="select[%d]" value="delete:%s"> %s ',$row->id,$row->id,__('Edit','rsvpmaker-for-toastmasters'),$row->id,$row->id,__('Delete','rsvpmaker-for-toastmasters') );

            $output .= sprintf('<p>%s<strong>%s</strong>, %s %s %s</p>',$controls,get_member_name($row->user_id),$row->role,rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($row->datetime)), $row->domain);

            if(strpos($row->role,'peaker'))

                $output .= sprintf('<p class="speech_details">Title: <em>%s</em>, Path/Level: %s, Project: %s</p>',$row->title,$row->manual,$row->project);

        }

    

    $output = '<form style="margin-bottom: 100px;" method="post" action="'.admin_url('admin.php?page=wp4toastmasters_history_edit').'">'.$output.'

    <div style="position: fixed; top: 50%; right: 0; width: 200px; padding: 50px; background-color: #fff; border-radius: 10px; ">

    <p>Pick records to edit or delete and click Select.</p>

    <button style="font-size: larger;">'.__('Select','rsvpmaker-for-toastmasters').'</button></div></form>';



    $year = (rsvpmaker_date('n') < 7) ? (rsvpmaker_date('Y') - 1) : rsvpmaker_date('Y');

    $since = (empty($_GET['since'])) ?  $year.'-07-01': sanitize_text_field($_GET['since']);

    printf("<p>Active filters: %s</p>",implode(', ',$filters));

    printf('<form method="get" action="%s">

    <p>%s</p>

    <input type="hidden" name="page" value="wp4toastmasters_history_edit" >

    Available filters: <br>

    <input type="radio" name="type" value="latest" %s> Latest <input type="radio" name="type" value="speaker" %s> Speeches <br>

    <input type="radio" name="all" value="0" %s> Just for this club website <input type="radio" name="all" value="1" %s> Include data from other clubs (where available)<br>

    <input type="radio" name="datefilter" value="0" %s> Not filtered by date <input type="radio" name="datefilter" value="1" %s> Filtered by date > <input type="text" name="since" value="%s" > (YEAR-MONTH-DATE)<br>

    Up to <select name="limit"><option value="%s">%s</option> records

    <option value="100">100</option>

    <option value="200">200</option>

    <option value="300">300</option>

    <option value="400">400</option>

    <option value="500">500</option>

    <option value="all">%s</option>

    </select><br>

    <button>Filter</button>

    </form>',admin_url('admin.php'), awe_user_dropdown('user_id',$user_id, true, 'Overview'), $latestchecked, $speakerchecked, $notallchecked, $allchecked, $nodatechecked, $datechecked, $since, $limit, $limit, __('No limit','rsvpmaker-for-toastmasters') );

    echo $output;



$examined = array();

echo $sql = "SELECT * from $history_table order by datetime DESC LIMIT 0, 30";

$results = $wpdb->get_results($sql);

foreach($results as $row) {

    if(in_array($row->id,$examined))

        continue;

    $examined[] = $row->id;

    $sql = $wpdb->prepare("SELECT * FROM $history_table WHERE role=%s AND datetime=%s AND domain=%s AND id != %d",$row->role, $row->datetime,$row->domain,$row->ID);

    $dres = $wpdb->get_results($sql);

    if(sizeof($dres))

    {

    //printf('<p>%s %s %s %s %s</p>',$row->role, $row->rolecount, $row->user_id, $row->datetime, $row->domain);

    foreach($dres as $drow) {

        if(in_array($drow->id,$examined))

            continue;

        $examined[] = $drow->id;

        //echo 'possible duplicate';

        printf('<p><em>Duplicate?</em> %s %s %s %s %s</p>',$drow->role, $drow->rolecount, $drow->user_id, $drow->datetime, $drow->domain);

    }

    }

}

return;

echo '<h3>Debugging</h3>';

echo $sql = "SELECT * FROM $wpdb->usermeta where meta_key LIKE 'tm|Ah%' ORDER BY umeta_id DESC LIMIT 0,100";

$results = $wpdb->get_results($sql);

foreach($results as $row) {

    printf('<p>%s</p>',$row->meta_key);

    $data = unserialize($row->meta_value);

    printf('<pre>%s</pre>',var_export($data,true));

}



}



function wp4t_record_history_to_table($user_id, $role, $timestamp, $post_id, $function, $manual = '',$project_key='',$title='',$intro='', $domain='', $role_count = 0, $was = 0) {

    //echo "<p> $user_id, $role, $timestamp, $post_id, $function, $manual, $project_key, $title, $intro, $domain, role count $role_count, $was </p>";	

    do_action('wp4t_record_history_to_table',$user_id, $role, $timestamp, $post_id, $function, $manual,$project_key,$title,$intro, $domain, $role_count, $was);

    global $wpdb, $increment;

	$history_table = $wpdb->base_prefix.'tm_history';

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

    if(empty($domain))

	    $domain = sanitize_text_field($_SERVER['SERVER_NAME']); 

    $role = str_replace( 'Contest_Speaker', 'Speaker', $role );

    $role = trim( preg_replace( '/[^\sa-zA-Z]/', ' ', $role ) );

    if(empty($role_count)) {

        if(!empty($increment))

        {

            $increment++;

            $role_count = $increment;

        }

        else {

            $sql = "SELECT rolecount from $history_table WHERE domain='$domain' AND post_id=$post_id ORDER BY rolecount DESC";

            $role_count = (int) $wpdb->get_var($sql);

            $role_count++;

            $increment = $role_count;

        }

    }

    if(empty($timestamp) && $post_id)

        $timestamp = get_rsvp_date($post_id);

	$sql = $wpdb->prepare("SELECT id FROM $history_table WHERE domain=%s AND role=%s AND (rolecount=%s OR user_id=%s) AND datetime=%s",$domain,$role,$role_count,$user_id,$timestamp);

    //echo "<p>$sql</p>";

	$id = $wpdb->get_var($sql);

	if($id) {

		$sql = $wpdb->prepare("UPDATE $history_table SET domain=%s, role=%s, rolecount=%s, datetime=%s, user_id=%d, post_id=%d, metadata=%s WHERE id=%d",$domain,$role,$role_count,$timestamp,$user_id,$post_id, serialize(make_tm_roledata_array( $function )),$id);

        $wpdb->query($sql);

    }

	else

    {

	$sql = $wpdb->prepare("INSERT INTO $history_table SET domain=%s, role=%s, rolecount=%s, datetime=%s, user_id=%d, post_id=%d, metadata=%s",$domain,$role,$role_count,$timestamp,$user_id,$post_id, serialize(make_tm_roledata_array( $function )));

    do_action('wp4t_add_history_to_table',$user_id, $role, $timestamp, $post_id, $function, $manual,$project_key,$title,$intro, $domain, $role_count, $was);

	$success = $wpdb->query($sql);

    $id = ($success) ? $wpdb->insert_id : 0;

    }

	if($role == 'Speaker') {

		$speech_id = $wpdb->get_var("SELECT speech_id from $speech_history_table WHERE history_id=$id");

		if($speech_id)

			$sql = $wpdb->prepare("UPDATE $speech_history_table SET manual=%s, project_key=%s, project=%s, title=%s, intro=%s, history_id=%d WHERE speech_id=%d",$manual,$project_key,get_project_text($project_key),$title,$intro,$id,$speech_id);

		else

			$sql = $wpdb->prepare("INSERT INTO $speech_history_table SET manual=%s, project_key=%s, project=%s, title=%s, intro=%s, history_id=%d",$manual,$project_key,get_project_text($project_key),$title,$intro,$id);

		$wpdb->query($sql);

	}

}



function wp4t_delete_history($role, $timestamp, $post_id) {

	global $wpdb;

	$key      = make_tm_usermeta_key( $role, $timestamp, $post_id );

	$sql = $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE meta_key=%s", $key );

	$wpdb->query( $sql );

}



function refresh_tm_history() {

    wp_suspend_cache_addition(true);

    global $wpdb;

    $history_table = $wpdb->base_prefix.'tm_history';

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

	$events_table = $wpdb->prefix . 'rsvpmaker_event';

    echo $sql = "SELECT * FROM $wpdb->posts JOIN $events_table ON $wpdb->posts.ID=$events_table.event WHERE post_content LIKE '%wp:wp4toastmasters%' AND post_status='publish' AND date < NOW() ORDER BY date DESC LIMIT 0, 5";

    $results = $wpdb->get_results($sql);

    print_r($results);

    foreach($results as $row) {

        echo $sql = "SELECT id FROM $history_table WHERE post_id=$row->ID";

        $found = $wpdb->get_var($sql);

        if(!$found) {

            update_user_role_archive( $row->ID, $row->date );

        }

    }

    wp_suspend_cache_addition(false);

}

add_action( 'refresh_tm_history', 'refresh_tm_history' );



function wp4t_recent_history($user_id) {

    global $wpdb;

    $history_table = $wpdb->base_prefix.'tm_history';

    $sql = "SELECT * FROM $history_table WHERE user_id=$user_id ORDER BY datetime DESC LIMIT 0,3";

    $results = $wpdb->get_results($sql);

    $roles = array();

    foreach($results as $row) {

        if(!in_array($row->role,$roles))

            $roles[] = $row->role;

    }

    return $roles;

}



function wp4t_history_query($where_or_array = '') {

    global $wpdb;

    $where = $groupby = $limit = '';

    $select = '*';

    $orderby = 'ORDER BY datetime DESC';

    if(is_array($where_or_array)){

        if(isset($where_or_array['where']))

            $where = 'WHERE '.$where_or_array['where'];

        if(isset($where_or_array['orderby']))

            $orderby = 'ORDER BY '.$where_or_array['orderby'];

        if(isset($where_or_array['groupby']))

            $groupby = 'GROUP BY '.$where_or_array['groupby'];

        if(isset($where_or_array['limit']))

            $limit = 'LIMIT 0,'.$where_or_array['limit'];

        if(isset($where_or_array['select']))

            $select = $where_or_array['select'];

    }

    elseif(!empty($where_or_array))

        $where = 'WHERE '.$where_or_array;



    $history_table = $wpdb->base_prefix.'tm_history';

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

    $sql = "SELECT $select FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where $groupby $orderby $limit";

    return $wpdb->get_results($sql);   

} 



function new_speaker_details_history($history_id, $manual, $project_key, $project_text, $title ) {



	if ( empty( $project_key ) ) {

			$project_text = 'Choose Project';

	}

	if ( empty( $project_options ) ) {

		$project_options  = sprintf( '<option value="%s">%s</option>', $project_key, $project_text );

		$pa               = get_projects_array( 'options' );

		$project_options .= isset( $pa[ $manual ] ) ? $pa[ $manual ] : $pa['COMPETENT COMMUNICATION'];

	}



		$output = '<select class="speaker_details manual" name="_manual[' . $history_id . ']" id="_manual_' . $history_id . '"">' . get_manuals_options( $manual ) . '</select><br /><select class="speaker_details project" name="_project[' . $history_id . ']" id="_project_' . $history_id . '">' . $project_options . '</select> ';

		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text' . $history_id . '" name="_title[' . $history_id . ']" value="' . $title . '" /></div>';

	$output = '<div class="speaker_details_form">'.$output.'</div>';

	return $output;

}



function add_speaker_details_history($index) {

    $type = manual_type_options( $index, '' );

    $project_options  = '<option value="">Choose Project</option>';

    $pa               = get_projects_array( 'options' );

    $project_options .= $pa['Path Not Set Level 1 Mastering Fundamentals'];

    $output = '<div>

    <div>'.$type.'</div>

    <select class="speaker_details manual" name="history_add_manual[' . $index . ']" id="_manual_' . $index . '"">' . get_manuals_options( '' ) . '</select><br /><select class="speaker_details project" name="history_add_project[' . $index . ']" id="_project_' . $index . '">' . $project_options . '</select> ';

    $output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text' . $index . '" name="history_add_title[' . $index . ']" value="" /></div>';

	$output = '<div class="speaker_details_form">'.$output.'</div>';

	return $output;

}



function wpt_history_get_roles() {

    global $wpdb, $toast_roles;

    $toast_roles[] = 'Best Speaker';

    $toast_roles[] = 'Best Table Topics';

    $toast_roles[] = 'Best Evaluator';

    $history_table = $wpdb->base_prefix.'tm_history';

    $domain = sanitize_text_field($_SERVER['SERVER_NAME']);

    $sql = "SELECT distinct role FROM $history_table WHERE domain='$domain' AND role != 'Speaker' AND role != 'Attended' ORDER BY role ";

    $results = $wpdb->get_results($sql);

    if($results) {

        foreach($results as $row) 

        if(!in_array($row->role,$toast_roles))

            $toast_roles[] = $row->role;

        sort($toast_roles);

    }

    return $toast_roles;

}



function wpt_get_history_by_meeting($date) {

    global $wpdb;

    $history_table = $wpdb->base_prefix.'tm_history';

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

    $domain = sanitize_text_field($_SERVER['SERVER_NAME']);

    $results = $wpdb->get_results("SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id WHERE datetime='$date' AND domain='$domain' ");

    return $results;

}



function wpt_update_history_by_id($history_id, $user_id, $post_id, $was=0) {

    global $wpdb;

    $history_table = $wpdb->base_prefix.'tm_history';

    $role = $wpdb->get_var("select role from $history_table where id=$history_id");

    if($user_id) {

        $sql = "UPDATE $history_table set user_id=$user_id WHERE id=$history_id";

        do_action('wpt_update_history_by_id',$user_id, $role, $post_id, $was);

    }

    else {

        $sql = "DELETE FROM $history_table WHERE id=$history_id";

        do_action('wpt_remove_history_by_id',$was, $role, $post_id);

    }

    $wpdb->query($sql);

}



function wpt_update_speech_history_by_id($history_id,$manual,$project_key,$title,$post_id,$user_id) {

    global $wpdb;

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

    $current_record = $wpdb->get_row("select * from $speech_history_table where history_id=$history_id");

    if(!$current_record)

        return;

    if(($current_record->manual != $manual) || ($current_record->project_key != $project_key) || ($current_record->title != $title)) {

        $project = get_project_text($project_key);

        $sql = $wpdb->prepare("UPDATE $speech_history_table SET manual=%s, project_key=%s, title=%s, project=%s WHERE history_id=%d",$manual,$project_key,$title,$project,$history_id);

        do_action('wpt_update_speech_history_by_id',$manual,$project_key,$project,$title,$post_id,$user_id);

        $wpdb->query($sql);

    }

}



function wpt_minutes_from_history($history_post_id = '') {

    if(!isset($_GET['minutes_from_history']) && !is_numeric($history_post_id))

        return $history_post_id;//default content in filter context

    global $wpdb;

    $history_table = $wpdb->base_prefix.'tm_history';

    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

    if(empty($history_post_id))

        $history_post_id = intval($_GET['minutes_from_history']);

    $history_post = get_post($history_post_id);

    $agenda_data = wpt_blocks_to_data($history_post->post_content);

    $notes = '';

    foreach($agenda_data as $index => $item) {

        if(!empty($item['role'])) {

            for($i=1; $i <= intval($item['count']); $i++)

            $allroles['_role_'.str_replace(' ','_',$item['role']).'_'.$i] = '';

            $agenda_order[$item['role']] = '';

        }

        elseif(isset($item['editable'])) {

            $temp = get_post_meta($history_post_id,'agenda_note_'.$item['uid'],true);

            if($temp) {

                $temp = str_replace('<p>',"<!-- wp:paragraph -->\n<p>",$temp);

                $temp = str_replace('</p>',"</p>\n<!-- /wp:paragraph -->\n\n",$temp);

                $notes .= sprintf('<!-- wp:heading {"level":3} -->

<h3 class="wp-block-heading">%s</h3>

<!-- /wp:heading -->'."\n\n",$item['editable']).$temp."\n";                

            }

        }

    }

    $additions = '';

    $attended = $role_holder = $present = array();

    $content = '';

    $sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id=$speech_history_table.history_id where post_id=$history_post_id AND domain='".$_SERVER["SERVER_NAME"]."' ";

    //$content .= '<p>'.$sql.'</p>';

    $history_records = $wpdb->get_results($sql);

    //$content .= '<p>$history_records '.var_export($history_records,true).'</p>';



    foreach($history_records as $record) {

        if(!in_array($record->user_id,$present))

            $present[] = $record->user_id;

        if($record->role == 'Attended') {

            if(!in_array($record->user_id,$attended))

                $attended[] = $record->user_id;

        }

        else {

            if(!in_array($record->user_id,$role_holder))

                $role_holder[] = $record->user_id;

        }

        $meta_index = wp4t_fieldbase($record->role,$record->rolecount);

        $name = get_member_name($record->user_id);

        $allroles[$meta_index] = $name;

        if(!empty($record->title))

            $allroles[$meta_index] .= '<br>&quot;'.$record->title.'&quot;';

        if(!empty($record->manual))

            $allroles[$meta_index] .= '<br>'.$record->manual;

        if(!empty($record->project))

            $allroles[$meta_index] .= '<br>'.$record->project;

    }



    ksort($allroles);

    foreach($allroles as $index => $roleline) {

        $output = '';

        $role = trim(preg_replace('/[^A-Za-z]/',' ',$index));

        if(empty($roleline)) {

            $assigned = get_post_meta($history_post_id,$index,true);

            if(!empty($assigned) && (($assigned < '0') || !is_numeric($assigned)))

                $roleline = sprintf('<em>Agenda shows %s</em>',get_member_name($assigned));

        }

        $output .= sprintf("<!-- wp:paragraph -->\n<p><strong>%s:</strong> %s</p>\n<!-- /wp:paragraph -->\n\n", $role,$roleline);

        if(isset($agenda_order[$role]))

            $agenda_order[$role] = $output;

        else

            $additions = $output;

    }



    $content .= implode("\n",$agenda_order).$additions;



	if ( ! empty( $role_holder ) ) {

		foreach ( $role_holder as $index => $marked ) {

			$user = get_userdata( $marked );

			$participant[] = $user->display_name;

		}

        $label = __('Held a role','rsvpmaker-for-toastmasters');

        $content .= sprintf("<!-- wp:paragraph -->\n<p><strong>%s:</strong> %s</p>\n<!-- /wp:paragraph -->\n\n", $label,implode(', ',$participant));

	}



	if ( ! empty( $attended ) ) {

		foreach ( $attended as $user_id ) {

			$showed_up[] = get_member_name($user_id);

		}

        $label = __('No role but marked present','rsvpmaker-for-toastmasters');

        $content .= sprintf("<!-- wp:paragraph -->\n<p><strong>%s:</strong> %s</p>\n<!-- /wp:paragraph -->\n\n", $label,implode(', ',$showed_up));

	}

    $total_attendance = 0;

    if(!empty($showed_up))

        $total_attendance = sizeof($showed_up);

    if(!empty($participant))

        $total_attendance += sizeof($participant);

    

    $content .= sprintf("<!-- wp:paragraph -->\n<p><strong>%s:</strong> %s</p>\n<!-- /wp:paragraph -->\n\n", __('Total attendance','rsvpmaker-for-toastmasters'),$total_attendance);



	$members   = array();

	$blogusers = get_users( 'blog_id=' . get_current_blog_id() );

	foreach ( $blogusers as $user ) {    

        if(in_array($user->ID,$present))

            continue;

		$userdata = get_userdata( $user->ID );

		$index             = preg_replace( '/[^A-Za-z]/', '', $userdata->first_name . $userdata->last_name . $userdata->user_login );

		$absent[ $index ] = $userdata->display_name;

	}

    if(!empty($absent)) {

        ksort( $absent );

        $label = __('Absent','rsvpmaker-for-toastmasters');

        $content .= sprintf("<!-- wp:paragraph -->\n<p><strong>%s:</strong> %s</p>\n<!-- /wp:paragraph -->\n\n", $label,implode(', ',$absent));

    }



    $content = $notes . $content;



return $content;

}



function wpt_minutes_from_history_title($title = '') {

    if(isset($_GET['minutes_from_history'])) {

        $title = __('Minutes for','rsvpmaker-for-toastmasters').' ';

        $history_post_id = intval($_GET['minutes_from_history']);

        $title .= rsvpmaker_long_date($history_post_id);

    }

    return $title;

}



function wpt_minutes_from_history_draft() {

    if(isset($_GET['minutes_from_history']) && isset($_GET['draft'])) {

        $history_post_id = intval($_GET['minutes_from_history']);

        $new['post_title'] = wpt_minutes_from_history_title();

        $new['post_content'] = wpt_minutes_from_history();

        $new['post_status'] = 'draft';

        $new['post_type'] = 'tmminutes';

        $new['post_date'] = get_rsvp_date($history_post_id);

        $id = wp_insert_post($new);

        update_post_meta($id,'minutes_for',$history_post_id);

        wp_safe_redirect(admin_url("post.php?post=$id&action=edit"));

        die();

    }    

}

add_action('admin_init','wpt_minutes_from_history_draft');



add_filter('default_title','wpt_minutes_from_history_title');

add_filter('default_content','wpt_minutes_from_history');



add_action('wp4t_add_history_to_table','wp4t_add_history_to_table_log',10, 12);

add_action('wpt_update_speech_history_by_id','wpt_update_speech_history_by_id_log',10,6);

add_action('wpt_remove_history_by_id','wpt_remove_history_by_id_log',10,3);

add_action('wpt_update_history_by_id','wpt_update_history_by_id_log',10,4);



//new role logged

function wp4t_add_history_to_table_log($user_id, $role, $timestamp, $post_id, $function, $manual,$project_key,$title,$intro, $domain, $role_count, $was) {

    $name = get_member_name($user_id);

    //$message = "Recorded for $name $role, $timestamp, $post_id, $function, $manual, $project_key, $title, $intro, $domain, role count $role_count, $was";

    //echo '<div class="notice notice-success"><p>'.$message.'</p></div>';

    $short_message = "<strong>$name</strong>: $role $role_count";

    if('toastmasters_reconcile' == $function)

        echo '<div class="notice notice-success"><p>'.$short_message.'</p></div>';

}



function wpt_update_speech_history_by_id_log($manual,$project_key,$project,$title,$post_id,$user_id) {

    $name = get_member_name($user_id);

    $message = '<strong>Updated speech for '.$name."</strong>: $manual, $project, $title";

    echo '<div class="notice notice-success"><p>'.$message.'</p></div>';

}



//changed from assigned to Open

function wpt_remove_history_by_id_log($was, $role, $post_id) {

    $name = get_member_name($was);

    $message = '<strong>Removed '.$name."</strong>: $role";

    echo '<div class="notice notice-success"><p>'.$message.'</p></div>';

}



//changed from one member to another

function wpt_update_history_by_id_log($user_id, $role, $post_id, $was) {

    $name = get_member_name($user_id);

    $wasname = get_member_name($was);

    $message = "Changed <strong>$wasname to $name</strong>: $role";

    echo '<div class="notice notice-success"><p>'.$message.'</p></div>';

}

