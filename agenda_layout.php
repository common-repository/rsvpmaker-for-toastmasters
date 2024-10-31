<html lang="en-US" >
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Toastmasters Agenda Layout</title>
<style>
    #layoutcontrols {
        display: flex;
        gap: 20px;
    }
    .fontcontrol {
        width: 50px;
    }
</style>
</head>
<body>
<?php
function agenda_layout_options() {
    global $post;
    if(!current_user_can('edit_others_rsvpmakers'))
        return;
    $permalink = get_permalink($post->ID);
    $agendalink = add_query_arg(array('print_agenda'=>1,'no_print'=>1,'t'=>time()),$permalink);
    $layoutlink = add_query_arg(array('agenda_layout'=>1),$permalink);
    $layout = wp4toastmasters_agenda_layout_check( );
    $layout_edit = admin_url( 'post.php?action=edit&post=' . $layout );

    if(isset($_POST['main']))
    {
        $mainfont = intval($_POST['main']);
        update_option('wp4toastmasters_agenda_font_main',$mainfont);
    }
    else
    	$mainfont = get_option( 'wp4toastmasters_agenda_font_main' );
    if(isset($_POST['side']))
        {
            $sidebarfont = intval($_POST['side']);
            update_option('wp4toastmasters_agenda_font_sidebar',$sidebarfont);
        }
    else
        $sidebarfont = get_option( 'wp4toastmasters_agenda_font_sidebar' );
    if(!$mainfont)
        $mainfont = 12;
    if(!$sidebarfont)
        $sidebarfont = 12;
    $custom = get_option( 'wp4toastmasters_agenda_css' );

    $agenda_header = '<!-- wp:columns {"className":"titleblock"} -->
    <div class="wp-block-columns titleblock"><!-- wp:column {"width":"10%"} -->
    <div class="wp-block-column" style="flex-basis:10%"><!-- wp:image {"width":40,"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large is-resized"><img src="https://toastmost.org/tmbranding/ToastmastersAgendaLogo.png" alt="" style="width:40px" width="40"/></figure>
    <!-- /wp:image --></div>
    <!-- /wp:column -->
    
    <!-- wp:column {"width":"90%"} -->
    <div class="wp-block-column" style="flex-basis:90%"><!-- wp:heading {"style":{"typography":{"fontSize":22}}} -->
    <!-- wp:paragraph {"style":{"typography":{"fontSize":22}},"className":"agenda-title"} -->
    <p class="agenda-title" style="font-size:22px">'.esc_html(get_option('blogname')).' [tmlayout_post_title]</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:wp4toastmasters/meetingdate /--></div>
    <!-- /wp:column --></div>
    <!-- /wp:columns -->';

    if(isset($_POST['change_layout'])) {
        $l = $_POST['change_layout'];
        if('default'==$l) {
            $up['ID'] = $layout;

            $up['post_content'] = $agenda_header . '
            
            <!-- wp:columns -->
            <div class="wp-block-columns"><!-- wp:column {"width":"33.33%"} -->
            <div class="wp-block-column" style="flex-basis:33.33%" id="agenda-sidebar"><!-- wp:paragraph -->
            <p><br><strong>Club Mission: </strong>We provide a supportive and positive learning experience in which members are empowered to develop communication and leadership skills, resulting in greater self-confidence and personal growth.</p>
            <!-- /wp:paragraph -->
            
            <!-- wp:wp4toastmasters/officers /--></div>
            <!-- /wp:column -->
            
            <!-- wp:column {"width":"66.66%"} -->
            <div class="wp-block-column" style="flex-basis:66.66%" id="agenda"><!-- wp:wp4toastmasters/agendamain /--></div>
            <!-- /wp:column --></div>
            <!-- /wp:columns -->';
        }
        elseif('nosidebar' == $l) {
            $up['ID'] = $layout;
            $up['post_content'] = $agenda_header . '
            
            <!-- wp:wp4toastmasters/agendamain /-->';
        }

        if(!empty($up))
            wp_update_post($up);
    }
    if(isset($_POST['wp4toastmasters_agenda_css'])) {
        update_option( 'wp4toastmasters_agenda_css',sanitize_textarea_field(stripslashes($_POST['wp4toastmasters_agenda_css'])));
    }
    if(isset($_POST['wp4t_disable_timeblock'])) {
        $notime = (bool) $_POST['wp4t_disable_timeblock'];
        update_option('wp4t_disable_timeblock', $notime);
    }
    else
        $notime = (bool) get_option('wp4t_disable_timeblock');
?>
<div id="layoutcontrols">
<form method="post" action="<?php echo $layoutlink; ?>">
Agenda Items Font <input class="fontcontrol" type="number" name="main" value="<?php if($mainfont) echo $mainfont; ?>" />
<button>Update</button>
</form>
<form method="post" action="<?php echo $layoutlink; ?>">
Sidebar Items Font <input class="fontcontrol" type="number" name="side" value="<?php if($sidebarfont) echo $sidebarfont; ?>" />
<button>Update</button>
</form>
<form method="post" action="<?php echo $layoutlink; ?>">
Layout Template <input type="radio" name="change_layout" value="default" checked="checked" /> Default (reset) <input type="radio" name="change_layout" value="nosidebar" /> No Sidebar 
<button>Update</button>
<?php if(current_user_can('manage_options')) { printf('<p><a href="%s">Update Officers List</a></p>',admin_url('options-general.php?page=wp4toastmasters_settings#officers')); } else echo '<p>Update officers list on the Settings -> Toastmasters screen (requires website administrator access)</p>'; ?>
<p><a href="<?php echo $layout_edit; ?>">Advanced: open layout document in the WordPress editor</a></p>
</form>
</div>
<form method="post" action="<?php echo $layoutlink; ?>">
<?php
if($notime)
echo '<input type="hidden" name="wp4t_disable_timeblock" value="0"><button>Show Times on the Agenda</button>';
else
echo '<input type="hidden" name="wp4t_disable_timeblock" value="1"><button>Remove Times from Agenda</button>';
?>
</form>

<div id="customon"><input type="checkbox" onclick="csstoggle()" /> Custom CSS code <?php
if(!empty($custom))
    echo '(code previously added)';
?>
</div>
<div id="custom_css" style="display: none;">
<h4>Custom CSS</h4>
<form method="post" action="<?php echo $layoutlink; ?>">
    <?php agenda_css_customization_form(); ?>
    <p><button>Update</button></p>
</form>
</div>
<script>
    function csstoggle() {
        document.getElementById('custom_css').style = 'display:block';
        document.getElementById('customon').style = 'display:none';
    }
</script>
<iframe width="100%;" height="3000px;" src="<?php echo $agendalink; ?>"></iframe>
<?php
}
agenda_layout_options();
?>
</body>
</html>