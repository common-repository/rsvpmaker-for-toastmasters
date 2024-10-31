<?php

global $wpdb, $post, $rsvp_options, $current_user, $wp_styles;



foreach( $wp_styles->queue as $style ) {

    if($style != 'admin-bar')

    wp_dequeue_style($style);

}



if(is_user_member_of_blog()) 

$identifier = $current_user->ID;

else {

    if(empty($_COOKIE["tm_voting_cookie"]))

    {

        $identifier = rand(1000,100000);

        setcookie("tm_voting_cookie", $identifier, time()+DAY_IN_SECONDS);

    }

    else {

        $identifier = $_COOKIE["tm_voting_cookie"];

        if(empty($identifier))

            $identifier = $_SERVER['REMOTE_ADDR'];

    }

}

if(isset($_POST['switch_vote_counter']) && rsvpmaker_verify_nonce()) {

    $user_id = intval($_POST['switch_vote_counter']);

    if($user_id) {

        update_post_meta($post->ID,'_Vote_Counter_1',$user_id);

        update_post_meta($post->ID,'vote_counter_claimed',$user_id);

    }

}



?>

<html>

<head>

<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php wp_head(); ?>

<style>

    h1, h2, h3 {font-family: Arial, Helvetica, sans-serif; }

    h1 {font-size: 40px;}

    h2 {font-size: 36px;}

    h3 {font-size: 30px;}

    button {

    border: medium solid transparent;

    border-radius: 5px;

    cursor: pointer;

    font-weight: bold;

    font-family: Arial, Helvetica, sans-serif;

    font-size: 30px;

    line-height: 1.2;

    padding: 5px;

    text-decoration: none;

    }

    input[type="radio"] {width: 2em; height: 2em;}

    body {padding: 15px; background-color: #fff; background-image:none;}

    p {font-size: large;}

    #votingresults {padding: 10px; border: thin dotted #000;}

    .votinglink {width: 95%;}

    .more, .editblock {display: none}

    .editblock {border: thick solid yellow; padding: 10px;}

    button {color: red;}

    body {color: black;}

    #votingtool {color: #000;background-color:#fff;}

    a {color: blue}

</style>

</style>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>

<div id="votingtoool">

<h2>Voting for <?php echo rsvpmaker_date($rsvp_options['short_date'],get_rsvpmaker_timestamp( $post_id )) ?></h2>

<?php

$actionlink = add_query_arg('voting',1,get_permalink());

if(isset($_POST['claim']) && isset($current_user->ID) && rsvpmaker_verify_nonce())

{

    update_post_meta($post->ID,'_Vote_Counter_1',$current_user->ID);

    update_post_meta($post->ID,'vote_counter_claimed',$current_user->ID);

    $vote_counter = $claimed = $current_user->ID;

}

else {

    $vote_counter = (int) get_post_meta($post->ID,'_Vote_Counter_1',true);

    $claimed = (int) get_post_meta($post->ID,'vote_counter_claimed',true);

}



if(isset($_POST['addvote_contest']) && rsvpmaker_verify_nonce()) {

    $contest = sanitize_text_field($_POST['addvote_contest']);

    $addvote = array_map('sanitize_text_field',$_POST['addvote']);

    update_post_meta($post->ID,'addvote_'.$contest,$addvote);

}



if(isset($_POST['custom_club_contests']) && rsvpmaker_verify_nonce())

    {

        $input = sanitize_text_field($_POST['custom_club_contests']);

        $c = explode(',',$input);

        update_option('custom_club_contests',$c);

    }



    $vote_counter_name = ($vote_counter) ? get_member_name($vote_counter) : 'not yet claimed';

    if(isset($_POST['my_vote']) && rsvpmaker_verify_nonce()){

        $vote = sanitize_text_field($_POST['my_vote']);

        $key = sanitize_text_field($_POST['key']);

        $identifier = sanitize_text_field($_POST['identifier']);

        $metakey = 'myvote_'.$key.'_'.$identifier;

        update_post_meta($post->ID,$metakey,$vote);

        echo '<div style="border: thin solid red; padding: 10px; background-color:#ffe">Vote recorded: '.$key.'</div>';

    }

    elseif(isset($_GET['key'])) {

        $key = sanitize_text_field($_GET['key']);

        $label = get_post_meta($post->ID,'votelabel_'.$key,true);

        printf('<h2>Voting for %s</h2>',$label);

        $check = 'voting_'.$key;

        $contestants = get_post_meta($post->ID,$check,true);

        if(is_array($contestants)) {

            printf('<form method="post" action="%s">',$actionlink);

            $indentifier = (is_user_member_of_blog()) ? $current_user->ID : $_SERVER['REMOTE_ADDR'];

            foreach($contestants as $contestant) {

                printf('<h3><input type="radio" name="my_vote" value="%s" > %s</h3>',$contestant,$contestant);

            }

            rsvpmaker_nonce();

            printf('<input type="hidden" name="key" value="%s">',$key);

            printf('<input type="hidden" name="identifier" value="%s">',$identifier);

            echo '<button>Vote!</button></form>';        

        }

    }



$admin_view = false;

if(isset($_GET['admin_view']) && current_user_can('manage_options')) {

    $admin_view = true;

    add_post_meta($post->ID,'voting_admin_view',true);

}

elseif(current_user_can('manage_options'))

    $admin_view = get_post_meta($post->ID,'voting_admin_view',true);



if(($admin_view || ($current_user->ID == $vote_counter)) && !isset($_GET['preview'])) {

    $open = get_post_meta($post->ID,'openvotes'); // get array

    $prompt = sprintf('<p><button id="votecheck">START VOTE COUNT</button> | <a href="%s">Check Now</a> | <a href="#addvotes">Add votes</a></p>',$actionlink);

    printf('<p>Logged in as vote counter </p>%s',$prompt);

    $metakey = 'myvote_'.$key.'_'.$identifier;



    echo '<div id="score_status"></div><div id="scores">'.wptm_count_votes($post->ID).'</div>';



    //show vote counter controls

    $claimed = $current_user->ID;



    if(isset($_POST['candidates']))

    {

        if(isset($_POST['openvotes'])){

            $label = $openvotes = sanitize_text_field($_POST['openvotes']);

            $openvotes = preg_replace('/[^a-z]/','',strtolower($openvotes));

            update_post_meta($post->ID,'votelabel_'.$openvotes,$label);

            if(!in_array($openvotes,$open)) // don't add duplicates

                add_post_meta($post->ID,'openvotes',$openvotes);

        }

        else

            $openvotes = sanitize_text_field($_POST['edit_candidates']);

        $raw = $_POST['candidates'];

        foreach($raw as $r) {

            $r = trim($r);

            if(!empty($r)) {

                $candidates[] = sanitize_text_field($r);

            }

        }

        //print_r($candidates);

        $key = 'voting_'.$openvotes;

        update_post_meta($post->ID,$key,$candidates);

    }



    $open = get_post_meta($post->ID,'openvotes'); // get array

    

    if(is_array($open)) {

        foreach($open as $v) {

            $check = 'voting_'.$v;

            $contestants = get_post_meta($post->ID,$check,true);

            if(empty($contestants))

                continue;

            $label = get_post_meta($post->ID,'votelabel_'.$v,true);

            $voting_link = $actionlink.'&key='.$v;

            printf('<h3>Contest set %s: %s - <a href="#" target="edit_%s" class="editnow">Edit</a> - <a href="%s" target="_blank">Preview Ballot</a></h3>',$label,implode(', ',$contestants),$v,$voting_link.'&preview=1');

            printf('<div class="editblock" id="edit_%s">',$v);

            printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink())); 

            printf('<p>%s</p>',__('Make any necessary edits and click Update','rsvpmaker-for-toastmasters'));

            foreach($contestants as $contestant)

                printf('<div><input type="checkbox" name="candidates[]" value="%s" checked="checked"> %s</div>',$contestant,$contestant);

            for($i=0; $i < 5; $i++)

                echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

            echo '<input type="hidden" name="edit_candidates" value="'.$v.'">';

            rsvpmaker_nonce();

            echo '<button>Update</button></form></div>';

            printf('<p>Link to share:<br><input type="text" class="votinglink" status="status_%s" value="Vote for %s %s"></p><div id="status_%s"></div>',$v,$label, $voting_link,$v);

        }

    }

    else {

        ?>

        <p>This tool is intended for use in online meetings, as well as those with both online and in-person participants, to gather and score votes for best speaker,

        best evaluator, best table topics, and any other contests or procedural votes. Members signed up on the agenda are checked off by default, and you can type in

        additional names. Then copy the digital ballot link and paste into Zoom. As vote counter, you can also record votes on behalf of other members if they you

        received them on paper or by any other means. Once members have started voting, click "Check for Votes" to check for results.</p>

        <?php    

    }

    



    $more = 0;



    if(!is_array($open) || !in_array('speaker',$open)) {

        $sql = "SELECT * FROM $wpdb->postmeta where post_id=$post->ID AND meta_key LIKE '_role_Speaker_%' ";

        $results = $wpdb->get_results($sql);

        foreach($results as $row) {

            if(is_numeric($row->meta_value)) {

                $row->meta_value = intval($row->meta_value);

                if($row->meta_value < 1)

                    continue;

                $speakers[] = get_member_name($row->meta_value);

            }

            else

                $speakers[] = $row->meta_value;//guest

        }

        

        printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    

        printf('<h2>%s</h2>',__('Set up vote for Speaker','rsvpmaker-for-toastmasters'));

        foreach($speakers as $speaker)

            printf('<div><input type="checkbox" name="candidates[]" value="%s" checked="checked"> %s</div>',$speaker,$speaker);

        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

        printf('<div id="moreprompt%d"><a href="#" more="%d" class="showmore">Show More Blanks</a></div><div id="more%d" class="more">',$more,$more,$more);

        $more++;

        for($i=0; $i < 10; $i++)

            echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

        echo '</div>';

        echo '<input type="hidden" name="openvotes" value="Speaker">';

        rsvpmaker_nonce();

        echo '<button>Submit</button></form>';    

    }



    if(!is_array($open) || !in_array('evaluator',$open)) {

    $sql = "SELECT * FROM $wpdb->postmeta where post_id=$post->ID AND meta_key LIKE '_role_Evaluator_%' ";

    $results = $wpdb->get_results($sql);

    foreach($results as $row) {

        if(is_numeric($row->meta_value)) {

            $row->meta_value = intval($row->meta_value);

            if($row->meta_value < 1)

                continue;

            $evaluators[] = get_member_name($row->meta_value);

        }

        else

            $evaluators[] = $row->meta_value;//guest

    }



    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    

    printf('<h2>%s</h2>',__('Set up vote for Evaluator','rsvpmaker-for-toastmasters'));

    foreach($evaluators as $evaluator)

        printf('<div><input type="checkbox" name="candidates[]" value="%s" checked="checked"> %s</div>',$evaluator,$evaluator);

    echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

    printf('<div id="moreprompt%d"><a href="#moreprompt%d" more="%d" class="showmore">Show More Blanks</a></div><div id="more%d" class="more">',$more,$more,$more,$more);

    $more++;

    for($i=0; $i < 10; $i++)

        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

    echo '</div>';

    echo '<input type="hidden" name="openvotes" value="Evaluator">';

    rsvpmaker_nonce();

    echo '<button>Submit</button></form>';    

    }//end show evaluators setup





    if(!is_array($open) || !in_array('tabletopicsspeaker',$open)) {

    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    

    printf('<h2>%s</h2>',__('Set up vote for Table Topics Speaker','rsvpmaker-for-toastmasters'));

    for($i=0; $i < 5; $i++)

        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

    printf('<div id="moreprompt%d"><a href="#moreprompt%d" more="%d" class="showmore">Show More Blanks</a></div><div id="more%d" class="more">',$more,$more,$more,$more);

    $more++;

    for($i=0; $i < 10; $i++)

        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

    echo '</div>';

    echo '<input type="hidden" name="openvotes" value="Table Topics Speaker">';

    rsvpmaker_nonce();

    echo '<button>Submit</button></form>';

    }



    $club_contests = get_option('custom_club_contests');

    if(is_array($club_contests))

    foreach($club_contests as $contest) {

        $contest = trim($contest);

        if(!empty($contest)) {

            printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));

            echo '<input type="hidden" name="openvotes" value="'.$contest.'">';

            echo '<h2>Set up vote for '.$contest.'</h2>';

            for($i=0; $i < 10; $i++)

                echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

            printf('<div id="moreprompt%d"><a href="#moreprompt%d" class="moreprompt" more="%d" class="showmore">Show More Blanks</a></div><div id="more%d" class="more">',$more,$more,$more,$more);

            $more++;

            for($i=0; $i < 10; $i++)

                echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

            echo '</div>';

            rsvpmaker_nonce();

            echo '<button>Submit</button></form>';    

        }

    }



    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));

    echo '<h2>Custom</h2><p>Label: <input type="text" name="openvotes" value="Other Vote for Member"></p><p>Choices</p>';

    for($i=0; $i < 10; $i++)

        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

    printf('<div id="moreprompt%d"><a href="#moreprompt%d" class="moreprompt" more="%d" class="showmore">Show More Blanks</a></div><div id="more%d" class="more">',$more,$more,$more,$more);

    $more++;

    for($i=0; $i < 10; $i++)

        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

    echo '</div>';

    rsvpmaker_nonce();

    echo '<button>Submit</button></form>';



    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    

    echo '<h2>Custom</h2><p>Label: <input type="text" name="openvotes" value="Other Procedural Vote"></p><p>Choices</p>';

    echo '<div><input class="candidates" type="text" name="candidates[]" value="Yes"></div>';

    echo '<div><input class="candidates" type="text" name="candidates[]" value="No"></div>';

    printf('<div id="moreprompt%d"><a href="#moreprompt%d" more="%d" class="showmore">Show More Blanks</a></div><div id="more%d" class="more">',$more,$more,$more,$more);

    $more++;

    for($i=0; $i < 10; $i++)

        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';

    echo '</div>';

    rsvpmaker_nonce();

    echo '<button>Submit</button></form>';



    //$club_contests = get_option('custom_club_contests');

    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    

    echo '<h2>Custom Club Contests</h2>';

    printf('<div>Enter a list separated by commas <input type="text" name="custom_club_contests" value="%s"><br><em>For example, some clubs do a Word of the Day contest</em></div>',implode(',',$club_contests));

    rsvpmaker_nonce();

    echo '<button>Submit</button></form>';



    $open = get_post_meta($post->ID,'openvotes'); // get array

    if(is_array($open)) {

        printf('<h3 id="addvotes">%s</h3>',__('Add votes','rsvpmaker-for-toastmasters'));

            foreach($open as $v) {

                $check = 'voting_'.$v;

                $contestants = get_post_meta($post->ID,$check,true);

                $addvote = get_post_meta($post->ID,'addvote_'.$v,true);

                if(empty($addvote))

                    $addvote = array();

                if(is_array($contestants)) {

                    $label = get_post_meta($post->ID,'votelabel_'.$v,true);

                    printf('<h3>Add Votes for %s</h3><form method="post" action="%s">',$label,$actionlink);

                    foreach($contestants as $contestant) {

                        //calculate current value

                        $value = (isset($addvote[$contestant])) ? $addvote[$contestant] : 0;

                        printf('<p><input type="number" name="addvote[%s]" value="%d" > %s</p>',$contestant,$value,$contestant);

                    }

                    rsvpmaker_nonce();

                    printf('<input type="hidden" name="addvote_contest" value="%s">',$v);

                    echo '<button>Submit</button></form>';        

                }

        }

    }

    

    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    

    echo '<h2>Switch Vote Counter Role to Another Member</h2>';

    echo awe_user_dropdown( 'switch_vote_counter', 0, true, 'Select Member' );

    rsvpmaker_nonce();

    echo '<button>Submit</button></form>';

    

} // end vote counter controls



$open = get_post_meta($post->ID,'openvotes'); // get array

if(is_array($open)) {

    printf('<h3>%s (<a href="%s">%s</a>)</h3>',__('Active contests','rsvpmaker-for-toastmasters'),$actionlink,__('Check for updates','rsvpmaker-for-toastmasters'));

        foreach($open as $v) {

            $check = 'voting_'.$v;

            $voting_link = $actionlink.'&key='.$v;

            $metakey = 'myvote_'.$v.'_'.$identifier;

            $label = get_post_meta($post->ID,'votelabel_'.$v,true);

            if(get_post_meta($post->ID,$metakey,true))

                printf('<h3>Vote recorded for %s</a></h3>',$label);

            else

                printf('<h3><a href="%s">Vote for %s</a></h3>',$voting_link,$label);

        }

}



$users = get_club_members();

foreach ( $users as $user ) {

	$userdata = get_userdata( $user->ID );

	$u[]      = $userdata->first_name . ' ' . $userdata->last_name;

}

if ( ! empty( $u ) ) {

	sort( $u );

}

?>

<script>

jQuery( document ).ready(

	function($) {

	var members = <?php echo json_encode( $u ); ?>;

	$( ".candidates" ).autocomplete({

	  source: members

	});



    $('.votinglink').click(

        function() {

        this.select();

        this.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */

        navigator.clipboard.writeText(this.value);

        /* Alert the copied text */

        var statusid = $(this).attr('status');

        $('#'+statusid).html('<p style="color:green">Copied!</p>');

        }

    );



    $('.showmore').click(

        function(e) {

        e.preventDefault();

        let id = $(this).attr('more');

        console.log('more id '+id);

        $('#more'+id).show();

        $('#moreprompt'+id).hide();

        }

    );



    $('.editnow').click(

        function(e) {

        e.preventDefault();

        let target = $(this).attr('target');

        $('#'+target).show();

        }

    );



    var checkvoteinterval;

    var countdown = 30;

    var iterations = 0;



    $( '#votecheck' ).click(

        function (e) {

            e.preventDefault();

            var label = $( '#votecheck' ).text();

            console.log( label + ' checking for scores' );

            if (label == 'START VOTE COUNT') {

                checkvoteinterval = setInterval(

                    function(){

                        refreshScores();

                    },

                    1000

                );

                $( '#votecheck' ).text( 'STOP VOTE COUNT' );

            } else {

                clearInterval( checkvoteinterval );

                $( '#votecheck' ).text( 'START VOTE COUNT' );

            }

        }

    );

<?php

//start automatically

if(!empty($open)) {

echo "checkvoteinterval = setInterval(

    function(){

        refreshScores();

    },

    1000

);

$( '#votecheck' ).text( 'START/STOP VOTE COUNT' );

";

}

?>

    function refreshScores() {

			if (countdown == 0) {

				$( '#score_status' ).html( 'Checking for new scores ...' );

				console.log( 'checking for scores' );

				$.get(

					<?php echo "'".rest_url('rsvptm/v1/regularvoting/').$post->ID."'"; ?>,

					function( data ) {

						$( "#scores" ).html( data );

						$( '#score_status' ).html( 'Updated' );

					}

				);

				countdown = 30;

                iterations++;

			} else {

                if(iterations == 90) {

                    /* stop after 45 minutes */ 

                    clearInterval( checkvoteinterval );

                    $( '#score_status' ).html( 'Timed out. Click <strong>START VOTE COUNT</strong> to restart.' );

                    $( '#votecheck' ).text( 'START VOTE COUNT' );

                } 

                else {

                    $( '#score_status' ).html( 'Checking for votes in ' + countdown );

                    countdown--;

                }

			}

	}



} );

</script>



<p style="margin-top: 30px;"><em>This tool is intended for casual voting at weekly meetings. See the Contest Dashboard to set up digital ballots for contests.</em></p>

<?php

printf('<h3>Vote counter: %s</h3>',$vote_counter_name);



if(!$claimed || (($vote_counter != $current_user->ID) && current_user_can('manage_options')) ) {

    if(is_user_member_of_blog() || current_user_can('manage_network')) {

        printf('<form method="post" adtion="%s"><input type="hidden" name="claim" value="1">',add_query_arg('voting',1,get_permalink()));

        rsvpmaker_nonce();

        echo '<button>'.__('Make Yourself Vote Counter','rsvpmaker-for-toastmasters').'</button></form>';

        if($claimed) {

            echo '<p><em>Website administrator can override</em></p>';

            if(current_user_can('manage_options'))

                printf('<p><a href="%s">%s</a></p>',add_query_arg(array('voting' => 1,'admin_view' => 1),get_permalink()), __('View as vote counter','rsvpmaker-for-toastmasters'));

        }

    }

    else {

        printf('<p><a href="%s">Login</a> to claim the vote counter role.</p>',wp_login_url(add_query_arg('voting',1,get_permalink())));

    }

}

?>

<?php //wp_footer(); ?>

</div>

</body>

</html>