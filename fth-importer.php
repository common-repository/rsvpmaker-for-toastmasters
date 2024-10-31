<?php
function grab_fth_content($s, $page = '') {
    global $site;
    $tidy = new \tidy;
    $s = preg_replace('/\/\/([A-Za-z0-9_\-]+.html)/',"/$1",$s);
    $s = preg_replace('/\?.+/','',$s);
    ob_start();
    $content = file_get_contents($s);
    ob_get_clean();
    if(!$content) {
        echo '<p>Error: unable to import source content</p>';
        return;
    }
    if(empty($page)) {
        preg_match('/id="PublicMenuLinks(.*?)<\/div>/sim',$content,$sidebar_match); //<\/div>
        $sidebar = $sidebar_match[1];
        preg_match_all('/<a href="([^"]+)">([^<]+)<\/a>/',$sidebar,$sidebar_links);
        $sidebar_links[1] = array_reverse($sidebar_links[1]);
        $sidebar_links[2] = array_reverse($sidebar_links[2]);
        preg_match('/<div id="AllUserContent" class="ContentColumn">(.*?)(<div id="MeetingInfo">|<div class="homepagepanels">)/sim',$content,$match);
        $content = $match[1];
        //printf("Sidebar links <pre>%s\n%s\n</pre>",var_export($sidebar_links,true),htmlentities($content));
        //home page
    } 
    elseif ('/directions.html'== $page) {
        preg_match('/<div id="MeetingInfo">(.+)<div id="MeetOurMembers">/sim',$content,$match);
        $content = $match[1];
        //standard page
    } 
    elseif ('/meetourmembers.html'== $page) {
        preg_match('/<div id="MeetOurMembers">(.+)<div id="FileDownloads">/sim',$content,$match);
        $content = $match[1];
        //standard page
    } 
    else {
        //custom page
        preg_match('/<div id="CustomWebPage">(.+)<div id="FileDownloads">/sim',$content,$match);
        $content = $match[1];
        //printf('<p>%s %s</p><pre>%s</pre>',$page,htmlentities(var_export($match,true)),htmlentities($content));
    }

    $s = preg_replace('/\/{0,1}[^\/]+.html/','',$s);
    $site = trailingslashit($s);
    $content = strip_tags($content,'<p><h1><h2><h3><h4><a><iframe><img><br><strong><b><em><i><ul><ol><li><table><tr><th><td>');//
    $content = str_replace('href="/','href="'.$site,$content);
    $content = str_replace('src="/','src="'.$site,$content);
    $content = preg_replace("/[\r\n]/"," ",$content);
    $content = str_replace("&nbsp;"," ",$content);
    $content = preg_replace(" {2,}"," ",$content);
    $content = str_replace('<img',"\n<img",$content);
    $content = preg_replace_callback('/<table.*?<\/table>/mis','fth_table_cleanup',$content); //table cells to paragraphs
    $content = preg_replace("/(<p|<h|<iframe|<ol|<ul|<table)/","\n$1",$content); //|<table
    //$content = str_replace('<td','<p',$content);
    //$content = str_replace('</td','</p',$content);
    $content = preg_replace("/\n{2,}/","\n",$content);
    //$content = preg_replace("/(<\/th>|<\/td>)/"," ",$content);
    /*$content = preg_replace('/<img[^>].*?>/',"\n\n$0\n\n",$content);*/
    $content = preg_replace('/align="[^"]+"/',"",$content);
    $content = preg_replace('/style="[^"]+"/',"",$content);
    $content = preg_replace('/<div id="Unsubscribed">.+/sim','',$content);

    //$parts = explode('<div id="AllUserContent" class="ContentColumn">',$content);
    //$content = $parts[1];

    $lines = explode("\n",$content);
    $html = '';
    $paragraph = 0;
    foreach($lines as $index => $line)
    {
        $line = trim($line);
        if(empty(trim(strip_tags($line,'<img><iframe>'))))
            continue;
        if(strpos($line,'<iframe') !== false)
        {
            $line = strip_tags($line,'<iframe>');
            $line = str_replace('</iframe>','',$line);
            $line = str_replace('<','[',$line);
            $line = str_replace('>',']',$line);
            $line = str_replace("'",'"',$line);

            printf('<p>Imported iframe %s</p>',htmlentities($line));
            $html .= '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="wp-block-group"><!-- wp:shortcode -->'.$line.'<!-- /wp:shortcode --></div><!-- /wp:group -->'."\n";            
        }
        elseif(strpos($line,'<table') !== false || strpos($line,'<ol') !== false  || strpos($line,'<ul') !== false) {
            $html .= "<!-- wp -->".$line."\n";
        }
        elseif(strpos($line,'<img') !== false) {
            if(!strpos($line,'.ashx'))
                $html .= preg_replace_callback('/<img[^>]+src="([^"]+)"[^>]*>/m','fth_importer_image', $line);
        }
        elseif(strpos($line,'<p') !== false) {
            $html .=  "<!-- wp:paragraph -->".$line."<!-- /wp:paragraph -->\n";
            $paragraph++;
        }
        elseif(preg_match('/<h([0-9])/',$line,$match)) {
            $heading = preg_replace("/<h([0-9])[^>]*>([^<]+</h[0-9]>/","<!-- wp:heading {\"level\":$1} --><h$1 class=\"wp-block-heading\">$2</h$1><!-- /wp:heading -->\n",$line);// "<!-- wp:paragraph -->".$line."<!-- /wp:paragraph -->\n";
            $html .= $heading;
        }
        else {
            $html .= "<!-- wp -->".$line."\n";
        }
    }

    //$html = preg_replace("/\n.*<!-- wp/","\n<!-- wp",$html);//stray content
    $html = preg_replace('/\n{2,}/',"\n",$html);
    $html = preg_replace('/\s+>/',">",$html);
    $html = preg_replace('/> +/',">",$html);
    $html = preg_replace('/ {2,}/'," ",$html);

    if(empty($page)) { // home page logic
        $front_id = get_option('page_on_front');
        $rewrite = $_POST['rewrite'];
        if('append' != $rewrite) {
            $lines = explode("\n",$html);
            $first = array_shift($lines);
            $first .= "\n".array_shift($lines);
            array_unshift($lines,$first,get_tm_guest_registration());
            //array_unshift($lines,get_tm_guest_registration());     
            $html = implode("\n",$lines);
            $html .= "\n".'<!-- wp:heading -->
            <h2 class="wp-block-heading">Club News</h2>
            <!-- /wp:heading -->
            
            <!-- wp:latest-posts {"displayPostContent":true,"displayFeaturedImage":true,"featuredImageSizeSlug":"medium"} /-->';
        }
        if(!empty($rewrite)) {
            if('append' == $rewrite){
                $post = get_post($front_id);
                if(strpos($post->post_content,'id="boilerplate"'))
                    wpt_remove_boilerplate($front_id,$html);
                else {
                    //add to the end
                    $html = $post->post_content.$html;
                    $update['post_content'] = $html;
                    $update['ID'] = $front_id;
                    $result = wp_update_post($update);    
                }
            }
            else {
                //full rewrite
                $update['post_content'] = $html;
                $update['ID'] = $front_id;
                $result = wp_update_post($update);    
            }
            printf('<h1>Home Page</h1><p>Updating home page. <a href="%s" target="_blank">Edit</a></p>',admin_url("post.php?post=$front_id&action=edit"));    
        } else {
            $update['post_title'] = 'Imported Home Page';
            $update['post_type'] = 'page';
            $update['post_status'] = 'draft';
            $update['post_content'] = $html;
            $id = wp_insert_post($update);
            update_post_meta($id,'fth_draft','home');
            //printf('<h1>Saved Old Home Page Content as Draft</h1><p><a href="%s" target="_blank">Edit</a></p>',admin_url("post.php?post=$id&action=edit"));    
        }
        //echo do_blocks($html);
    }

    if(!empty($sidebar_links))
    foreach($sidebar_links[1] as $index => $link) {
        if(($link == '/calendar.html') || ($link == '/downloads.html'))
            continue;
        if(!strpos($link,'ttp')) {
            $url = $site.$link;
        if(strpos($url,$site) === false)
            continue;//not external links
        $text = $sidebar_links[2][$index];
        $new['post_title'] = $text;
        $inner = grab_fth_content($url,$link);
        if('/meetourmembers.html'== $link) {
            preg_match_all('/<img.*?>/',$inner,$matches);
            if(!empty($matches) && !empty($matches[0])) {
                printf('<p>%d membership page images saved to <a href="%s" target="_blank">media library</a></p>',sizeof($matches[0]),admin_url('upload.php'));
            }
        }
        else {
            $new['post_content'] = $inner;
            $new['post_type'] = 'post';
            $new['post_status'] = 'draft';
            $id = wp_insert_post($new);
            update_post_meta($id,'fth_draft','post');
            //printf('<p>%s saved as draft. <a href="%s" target="_blank">Edit as a blog post</a> or <a href="%s" target="_blank">Edit as a page</a></p>',$text,admin_url("post.php?post=$id&action=edit"),admin_url("post.php?post=$id&action=edit&blog_post_to_page=1"));
            //echo "<p>A blog post is an article that will be displayed, latest posts first, in the blog section of your website. Make this content a page if it is core content you want to add to your website's main menu.</p>";
        }
        //echo do_blocks($inner);
        }
    }
    return $html;
}

 function fth_table_cleanup($match) {
    //printf('<pre>table cleanup %s</pre>',htmlentities(var_export($match))."\n");
    $table = $match[0];
    $source = $table;
    //preg_match_all('/<img/',$table,$matches);
    //printf('<pre>image matches %s</pre>',htmlentities(var_export($matches))."\n");  || (!empty($matches) && sizeof($matches[0]) > 2)
    //$table = preg_replace('/[\r\n]/',' ',$table);
    if(strpos($table,'<p') || strpos($table,'<li')) {
        //$table = strip_tags($table,'<p><td><a><img><ol><ul><h1><h2><h3><h4><br><strong><b><em><i>');
        $table = preg_replace('/<(table|tr|tbody)>/','',$table);
        $table = preg_replace('/<td[^>]*>/',"<p>",$table);
        $table = str_replace('</td>',"</p>",$table);
        $table = preg_replace('/<th[^>]*>/',"<p>",$table);
        $table = str_replace('</th>',"</p>",$table);
        $table = preg_replace('/<p[^<]+<p[^>]*>/','<p>',$table);//no double paragraphs
        $table = preg_replace('/<\/p[^<]+<\/p[^>]*>/','</p>',$table);//no double paragraphs
        //$content = preg_replace("/(<p|<h|<iframe|<img|<ol|<ul)/","\n$1",$content);
    }
    else {
        $table = str_replace("\n<img","<img",$table);
    }
    return $table;
}

add_shortcode('fth_importer_docs','fth_importer_docs');

function draftgd_imagesize() {
    $imgsize = fth_importer_image_size();
    add_image_size('max'.$imgsize,$imgsize,$imgsize);
}
add_action('after_setup_theme','draftgd_imagesize');

add_filter( 'image_size_names_choose', 'fth_importer_custom_sizes' );
 
function fth_importer_custom_sizes( $sizes ) {
    $imgsize = fth_importer_image_size();
    return array_merge( $sizes, array(
        'max'.$imgsize => __( 'Max Width: '.$imgsize.'px' ),
    ) );
}

function fth_importer_nq() {
    global $post;
    if(isset($_GET['import_agenda'])) {
        wp_enqueue_script( 'wp-tinymce' );
        wp_enqueue_script( 'fth-importer', plugins_url( 'rsvpmaker-for-toastmasters/drafty.js' ), array('wp-tinymce'), '3.1', true );    
    }
}
add_action( 'wp_enqueue_scripts', 'fth_importer_nq', 10000 );
add_action( 'admin_enqueue_scripts', 'fth_importer_nq' );

function fth_importer_docs_link($arg) {
    $link = $arg[0]; // without closing tag
    if(!strpos($link,$_SERVER['SERVER_NAME']))
        $link .= ' target="_blank"';
    return $link;
}

function fth_importer_image_inline($img) {
    global $imgcount, $download_images, $image_slug, $download_ok, $editor_format;
    $download_ok = true;
    $imgcount++;
    $src = is_array($img) ? $img[1] : $img;
    $src = preg_replace('/\?.+/','',$src);
    $imgsize = fth_importer_image_size();
    $filename = array_pop(explode('/',$src));
    $image = '<img src="'.$src.'" alt=""/>';
    if($download_ok) {
        $attach_id = fth_importer_insert_attachment_from_url( $src, $filename );
        if($attach_id) {
            $imgarr = wp_get_attachment_image_src($attach_id,'max'.$imgsize);
            $url = $imgarr[0];
            $imghtml = '<img src="'.$url.'" width="'.$imgarr[1].'" height="'.$imgarr[2].'" alt="" class="wp-image-'.$attach_id.'"'."/>";
            return $imghtml;
        }
        else
            printf('<p><strong>Error importing image %s</strong><br />%s</p>',esc_html($image_slug).'_'.$imgcount.'.png',$src);
    }
    else {
        $download_images .= sprintf('<span style="display: inline-block; margin: 10px;"><a href="%s" download="%s.png" target="_blank">%s</a></span>',$match[1], $image_slug.'_'.$imgcount, $image);
    }
    return sprintf('<p>*** IMAGE %s GOES HERE ***</p>',$imgcount);
}

function fth_importer_image($img) {
    global $imgcount, $download_images, $image_slug, $download_ok, $editor_format;
    $download_ok = true;
    $imgcount++;
    $src = is_array($img) ? $img[1] : $img;
    $src = preg_replace('/\?.+/','',$src);
    $imgsize = fth_importer_image_size();
    $filename = array_pop(explode('/',$src));
    $image = '<img src="'.$src.'" alt=""/>';
    if($download_ok) {
        $attach_id = fth_importer_insert_attachment_from_url( $src, $filename );
        if($attach_id) {
            $imgarr = wp_get_attachment_image_src($attach_id,'max'.$imgsize);
            $url = $imgarr[0];
            $imghtml = '<!-- wp:image {"id":'.$attach_id.',"width":'.$imgarr[1].',"height":'.$imgarr[2].',"sizeSlug":"max'.$imgsize.'"} --><figure class="wp-block-image size-max'.$imgsize.'"><img src="'.$url.'" width="'.$imgarr[1].'" height="'.$imgarr[2].'" alt="" class="wp-image-'.$attach_id.'"'."></figure><!-- /wp:image -->\n";
            $imghtml = str_replace('loading="lazy"','',$imghtml);
            return $imghtml;
        }
        else
            printf('<p><strong>Error importing image %s</strong><br />%s</p>',esc_html($image_slug).'_'.$imgcount.'.png',$src);
    }
    else {
        $download_images .= sprintf('<span style="display: inline-block; margin: 10px;"><a href="%s" download="%s.png" target="_blank">%s</a></span>',$match[1], $image_slug.'_'.$imgcount, $image);
    }
    return sprintf('<p>*** IMAGE %s GOES HERE ***</p>',$imgcount);
}

function fth_importer_docs_options() {
    if(isset($_POST['allowed_types']) && wp_verify_nonce( $_POST['drafty_field'], 'drafty' ) )
    {
        $types = get_post_types();
        $builtin = array("attachment", "revision", "nav_menu_item", "custom_css", "customize_changeset", "oembed_cache", "user_request", "wp_block", "wp_template", "wp_template_part", "wp_global_styles", "wp_navigation");
        $legal_types = array_diff($types,$builtin);
        foreach($_POST['allowed_types'] as $type) {
            if(in_array($type,$legal_types))
                $allowed_types[] = sanitize_text_field($type);
        }
        update_option('fth_importer_docs_allowed',$allowed_types);
        $imgsize = intval($_POST['imgsize']);
        update_option('docs_from_google_image_size',$imgsize);
    }
}
add_action('admin_init','fth_importer_docs_options');

function fth_importer_docs($atts = array()) {
    $action = admin_url('admin.php?page=fth_importer_docs');
    $agenda_action = $action . '&import_agenda=1';
    $setup_wizard = sprintf(' Setup Wizard: <a href="%s">User Accounts</a> | <a href="%s">Next Steps</a>',admin_url('admin.php?page=wp4t_setup_wizard&setup_wizard=1'),admin_url('admin.php?page=wp4t_setup_wizard&setup_wizard=2'));
    
    if(isset($_GET['import_agenda']))
        printf('<div style="padding: 20px; text-align: center;" ><h1>Import Agenda Content</h1><p>Or Switch to <a href="%s">Import Web Page Content</a>. %s</p></div>',$action,$setup_wizard);
    else
        printf('<div style="padding: 20px; text-align: center;" ><h1>Import Web Page Content</h1><p>Or Switch to <a href="%s">Import Agenda Content</a>. %s</p></div>',$agenda_action,$setup_wizard);

	$toast_roles = array(
		'Ah Counter',
		'Body Language Monitor',
		'Evaluator',
		'General Evaluator',
		'Grammarian',
		'Humorist',
		'Speaker',
		'Topics Master',
		'Table Topics',
		'Timer',
		'Toastmaster of the Day',
		'Vote Counter',
		'Contestant',
	);

  global $imgcount, $image_slug, $download_images, $current_user, $download_ok, $editor_format, $wp_scripts, $wpdb;

$url = '';
if(isset($_POST['url'])){
    $url = sanitize_text_field($_POST['url']);
    update_option('freetoasthost',$url);
    grab_fth_content($url);
}

if(isset($_POST['src'])){
    echo $src = sanitize_text_field($_POST['src']);
    $code = fth_importer_image($src);
    printf('<p>%s<br>%s</p>',$code,htmlentities($code));
}


  if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
  $editor_format = is_plugin_active('classic-editor/classic-editor.php') ? 'classic' : 'block';
  $download_ok = (is_admin() || isset($atts['download_ok']));
    $imgcount = 0;
    $download_images = '';
    $types = get_post_types();
    $builtin = array("attachment", "revision", "nav_menu_item", "custom_css", "customize_changeset", "oembed_cache", "user_request", "wp_block", "wp_template", "wp_template_part", "wp_global_styles", "wp_navigation");
    $legal_types = array_diff($types,$builtin);

    $imgsize = get_option('docs_from_google_image_size');
    if(empty($imgsize))
        $imgsize = 600;


    if(isset($_POST['item']) && wp_verify_nonce( $_POST['drafty_field'], 'drafty' ) )
    {
        $agenda_content = '';
        foreach($_POST['item'] as $index => $item) {
            $item = trim(preg_replace('/[0-9\#]*/','',$item));
            $type = $_POST['item_type'][$index];
            $time = $_POST['item_time'][$index];
            $note = empty($_POST['note'][$index]) ? '' :esc_html($_POST['note'][$index]);
            $count = empty($_POST['item_count'][$index]) ? 1 : intval($_POST['item_count'][$index]);
            if('role' == $type)
                $html = sprintf('<!-- wp:wp4toastmasters/role {"role":"%s","count":"%d","agenda_note":"%s","time_allowed":"%s"} /-->',$item,$count,$note,$time);
            elseif('skip' == $type)
                continue;
            elseif('editable_note' == $type)
                $html = sprintf('<!-- wp:wp4toastmasters/agendaedit {"editable":"%s","uid":"editable%d","time_allowed":"5"} /-->',$item,$index,$time);
            else
                $html = sprintf('<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"%s","uid":"note%s"} --><p class="wp-block-wp4toastmasters-agendanoterich2">%s</p><!-- /wp:wp4toastmasters/agendanoterich2 -->',$time,$index,$item.' '.$note);
            //printf('<p>item: %s, type: %s, time: %s, note: %s</p>',$item,$type,$time,$note);
            //printf('<div>%s</div>',htmlentities($html));
            $agenda_content .= $html."\n";
        }

        if ( ! empty( $_POST['absences'] ) ) {
            $agenda_content .= '<!-- wp:wp4toastmasters/absences /-->' . "\n\n";
        }

        if(!empty($_POST['agenda_officers']))
            wp4toastmasters_agenda_layout_check(true);
        $rsvp_options['rsvp_on'] = $rsvp = (int) $_POST['invite'];
        $sync = (int) $_POST['sync'];
        $rsvp_options['add_timezone'] = $rsvp_options['convert_timezone'] = $timezone = (int) $_POST['timezone'];
        $update['post_content'] = $agenda_content;
        if('new' == $_POST['template_id']) {
            $update['post_title'] = sanitize_text_field($_POST['new_title']);
            $update['post_type'] = 'rsvpmaker_template';
            $update['post_status'] = 'publish';
            global $current_user;
            $update['post_author'] = $current_user->ID;
            $template_id = wp_insert_post($update);
        } else {
            $template_id = (int) $_POST['template_id'];
            // update template_first
            $update['ID'] = $template_id;
            wp_update_post( $update );    
        }
        $form = rsvpmaker_get_form_id( 'simple' );
        update_post_meta( $template_id, '_rsvp_on', $rsvp );
        update_post_meta( $template_id, '_rsvp_form', $form );
        update_post_meta( $template_id, '_add_timezone', $timezone );
        update_post_meta( $template_id, '_convert_timezone', $timezone );
        $toupdate = future_rsvpmakers_by_template( $template_id );
        if ( !empty( $toupdate ) ) {
            foreach ( $toupdate as $post_id ) {
                $update['ID'] = $post_id;
                $result = wp_update_post( $update );
                if ( empty( $updated_date ) ) {
                    $updated_date = $wpdb->get_var( "SELECT post_modified from $wpdb->posts WHERE ID=" . $post_id );
                }
                update_post_meta( $post_id, '_updated_from_template', $updated_date );
                update_post_meta( $post_id, '_rsvp_on', $rsvp );
                update_post_meta( $post_id, '_rsvp_form', $form );
                update_post_meta( $post_id, '_add_timezone', $timezone );
                update_post_meta( $post_id, '_convert_timezone', $timezone );
            }
        }
        $rsvp_options['calendar_icons'] = 1;
        update_option( 'RSVPMAKER_Options', $rsvp_options );
        update_option( 'wp4toastmasters_enable_sync', $sync );
        $permalink = (empty($toupdate)) ? get_permalink($template_id) : get_permalink($toupdate[0]);
        
        printf('<div class="notice notice-success"><h3>Agenda Saved, %d events updated</h3><a href="%s">View Signup Form</a> | <a href="%s">Edit</a>.</p></div>',sizeof($toupdate),$permalink,admin_url("post.php?post=$template_id&action=edit"));
        return;
    }
    
    if(isset($_POST['copy']) && wp_verify_nonce( $_POST['drafty_field'], 'drafty' ) )
    {
        ?>
        <h2>Review the Choices Below, Then Submit to Create a Toastmost Agenda</h2>
        <p>Options:</p>
        <ol>
            <li><strong>Role</strong> - a meeting role members can sign up for</li>
            <li><strong>Agenda Note</strong> - stage directions for your meeting. Example: "Presiding officer leads a round of self introductions."</li>
            <li><strong>Editable Note</strong> - Agenda content that's different for every meeting, like Theme and Word of the Day</li>
            <li><strong>Skip</strong> - don't include on new agenda.</li>
        </ol>
        <form method="post" action="<?php echo esc_url($agenda_action); ?>">
    <?php
        $rawcopy = $copy = stripslashes($_POST['copy']); //sanitized html
        $copy = str_replace('*','',$copy);
        preg_match_all('/<textarea[^>]+>([^>]+)<\/textarea>/',$copy,$matches);
        $items = preg_split('/[0-9]{1,2}:[0-9]{2}[ap]m<br/',$copy);
        array_shift($items);
        //preg_match_all('/data-eid[^>]+>(.*?)<label/mis',$copy,$matches);
        $first_speaker = 0;
        $first_evaluator = 0;
        $speaker_count = 0;
        $evaluator_count = 0;

        $inputs = [];

        foreach($items as $index => $match) {
            preg_match('/fth-role.*?value="([^"]+)/',$match,$rolematch);//.*?([0-9]*)
            preg_match('/([0-9]*) minutes/',$match,$minutes);//.*?([0-9]*)
            //printf('<p>%s: %s</p>',$rolematch[1],$minutes[1]);
            $maybenote = true;
            preg_match('/([0-9]*) minutes/',$match,$minutes);//.*?([0-9]*)
            $parts = explode('minutes',$match);
            $note = $parts[1];
            $note = str_replace('>','> ',$note);
            $note = strip_tags($note);
            $note = str_replace('&nbsp;',' ',$note);
            $note = trim(preg_replace('/Click to Assign.+/mis','',$note));
            foreach($toast_roles as $role) {
                $score = similar_text($role,$rolematch[1],$percent);
                if($score) {
                    if($role == 'Toastmaster of the Day' && ($percent > 60))
                        { // match Toastmaster, Toastmaster of the Evening
                            $percent = 100;
                        }
                    if($role == 'Contestant' && ($percent > 40))
                        { // 
                            $percent = 100;
                        }
                    if($percent > 75) {
                        $maybenote = false;
                        if($role == 'Speaker') {
                            $speaker_count++;
                            if(!$first_speaker)
                                $first_speaker = $index;
                            $inputs[$first_speaker] = sprintf('<p><input type="text" name="item[%d]" value="%s" /> Minutes <input type="text" name="item_time[%d]" value="%d" /> Count <input type="text" name="item_count[%d]" value="%d" /><br /><input type="radio" name="item_type[%d]" value="role" checked /> Meeting Role <input type="radio" name="item_type[%d]" value="agenda_note" /> Agenda Note <input type="radio" name="item_type[%d]" value="editable_note" /> Editable Note <input type="radio" name="item_type[%d]" value="skip" /> Skip</p>',$first_speaker,$role,$first_speaker,$minutes[1] * $speaker_count,$first_speaker,$speaker_count,$first_speaker,$first_speaker,$first_speaker,$first_speaker);
                        }
                        elseif($role == 'Evaluator') {
                            $evaluator_count++;
                            if(!$first_evaluator)
                                $first_evaluator = $index;
                            $inputs[$first_evaluator] = sprintf('<p><input type="text" name="item[%d]" value="%s" /> Minutes <input type="text" name="item_time[%d]" value="%d" /> Count <input type="text" name="item_count[%d]" value="%d" /><br /><input type="radio" name="item_type[%d]" value="role" checked /> Meeting Role <input type="radio" name="item_type[%d]" value="agenda_note" /> Agenda Note <input type="radio" name="item_type[%d]" value="editable_note" /> Editable Note <input type="radio" name="item_type[%d]" value="skip" /> Skip</p>',$first_evaluator,$role,$first_evaluator,$minutes[1] * $evaluator_count,$first_evaluator,$evaluator_count,$first_evaluator,$first_evaluator,$first_evaluator,$first_evaluator);
                        }
                        else {
                            $inputs[$index] = sprintf('<p><input type="text" name="item[%d]" value="%s" /> Minutes <input type="text" name="item_time[%d]" value="%d" />Count <input type="text" name="item_count[%d]" value="1" /><br /><input type="radio" name="item_type[%d]" value="role" checked /> Meeting Role <input type="radio" name="item_type[%d]" value="agenda_note" /> Agenda Note <input type="radio" name="item_type[%d]" value="editable_note" /> Editable Note <input type="radio" name="item_type[%d]" value="skip" /> Skip</p>',$index,esc_attr($rolematch[1]),$index,$minutes[1],$index,$index,$index,$index,$index) . sprintf('<p><textarea cols="80" rows="3" name="note[%d]">%s</textarea></p>',$index,esc_html($note));
                        }
                    }
                }
            }
            if($maybenote) {
                if((strpos($rolematch[1],'Theme') !== false) || (strpos($rolematch[1],'Word of') !== false) || (strpos($rolematch[1],'Words of') !== false))
                    $inputs[$index] = sprintf('<p><input type="text" name="item[%d]" value="%s" /> Minutes <input type="text" name="item_time[%d]" value="%d" /><br /><input type="radio" name="item_type[%d]" value="role" /> Meeting Role <input type="radio" name="item_type[%d]" value="agenda_note" /> Agenda Note <input type="radio" name="item_type[%d]" value="editable_note" checked /> Editable Note <input type="radio" name="item_type[%d]" value="skip" /> Skip</p>',$index,esc_attr($rolematch[1]),$index,$minutes[1],$index,$index,$index,$index) . sprintf('<p><textarea cols="80" rows="3" name="note[%d]">%s</textarea></p>',$index,$note);
                else
                    $inputs[$index] = sprintf('<p><input type="text" name="item[%d]" value="%s" /> Minutes <input type="text" name="item_time[%d]" value="%d" /><br /><input type="radio" name="item_type[%d]" value="role" /> Meeting Role <input type="radio" name="item_type[%d]" value="agenda_note" checked /> Agenda Note <input type="radio" name="item_type[%d]" value="editable_note" /> Editable Note <input type="radio" name="item_type[%d]" value="skip" /> Skip</p>',$index,esc_attr($rolematch[1]),$index,$minutes[1],$index,$index,$index,$index) . sprintf('<p><textarea cols="80" rows="3" name="note[%d]">%s</textarea></p>',$index,$note);
            }
        }

        echo implode("\n",$inputs);

        $templates = rsvpmaker_get_templates();
        $template_id = get_option( 'default_toastmasters_template' );
        if ( $template_id ) {    
            $template = get_post( $template_id );
            if ( empty( $template ) ) {
                $template_id = $templates[0]->ID;
            }
        }
        $options = '';
        foreach ( $templates as $template ) {
            $s = ( $template->ID == $template_id ) ? ' selected="selected" ' : '';
            $options .= sprintf( '<option value="%s" %s>%s</option>', $template->ID, $s, $template->post_title );    
        }
        $options .= '<option value="new">New Agenda Template</option>';
    
        ?>
        <p><label>Include Member Absences Widget</label> <input type="radio" name="absences" value="1" checked="checked" /> Yes <input type="radio" name="absences" value="0" > No</p>
        <p><label>Include Officers Listing on Agenda</label> <input type="radio" name="agenda_officers" value="1" checked="checked" /> Yes <input type="radio" name="agenda_officers" value="0" > No</p>
        <p><label>Invite Guests to Register Online</label> <input type="radio" name="invite" value="1" checked="checked" /> Yes <input type="radio" name="invite" value="0" > No</p>
        <p><label>Show timezone on events (recommended for online clubs)</label> <input type="radio" name="timezone" value="1" checked="checked" /> Yes <input type="radio" name="timezone" value="0" > No</p>
        <p><label>Allow Member Data to Sync (see <a target="_blank" href="" target="_blank">blog post</a>)</label> <input type="radio" name="sync" value="1" checked="checked" /> Yes <input type="radio" name="sync" value="0" > No</p>
        <p>Template to Update <select name="template_id"><?php echo $options; ?></select></p>
        <p>If you selected "New Agenda Template," enter a title: <input type="text" name="new_title"></p>
    <?php
        wp_nonce_field( 'drafty', 'drafty_field' );
        submit_button('Submit');
        echo '</form>';
        return;
    }

if(isset($_GET['import_agenda'])) {
?>
<h1>Import FreeToastHost Agenda</h1>
<form method="post" action="<?php echo esc_url($agenda_action); ?>">
<p>Paste agenda content into the textarea below and click submit.</p>
<p><textarea id="mytextarea" name="copy"></textarea></p>
<?php
    wp_nonce_field( 'drafty', 'drafty_field' );
    if(is_admin())
        submit_button('Submit');
    else
        echo '<p><button>Submit</button></p>';
    echo '</form>';
    echo "<h1>Instructions</h1>";
    printf('<p>From the FreeToastHost admin console, navigate to Meeting Agenda Settings and choose the agenda template you want to copy.</p><p><img width="500" src="%s" /></p>',plugins_url( 'images/toastmost-import-agenda.png', __FILE__ ));
    printf('<p>Copy all content displayed and paste it into the text box above. On Windows, the copy all command is CTRL + A; on Macs, Command (⌘) + A.</p><p>Do not worry about copying too much. The import tool will filter for just the agenda content.</p><p><img width="500" src="%s" /></p>',plugins_url( 'images/fth-copyall.png', __FILE__ ));
} // end import agenda UI
else {

    global $wpdb;
    if(isset($_GET['reset']) && function_exists('toastmost_starter_club_homepage')) {
        $update['ID'] = get_option('page_on_front');
        $update['post_content'] = toastmost_starter_club_homepage();
        wp_update_post($update);
        printf('<p>Home page reset. <a href="%s">Edit</a></p>',admin_url("post.php?post=$front_id&action=edit"));
        $wpdb->query("delete from $wpdb->postmeta where meta_key='fth_draft'");
        $results = [];
    }
    else {
        $results = $wpdb->get_results("select * from $wpdb->postmeta where meta_key='fth_draft' ORDER BY meta_value, meta_id DESC");
    }
    if($results)
    echo "<h2>Imported Page and Post Drafts</h2><p>Choose content to be posted to your website as a blog article or as a page. Typically, blogs are more timely content like the winners of a recent contest. Pages are evergreen content like reference information and additional detail about your club beyond what is shown on the home page.</p>";
    foreach($results as $row) {
        $post = get_post($row->post_id);
        if($post && $post->post_status == 'draft') {
            printf('<p>Imported content <strong>%s</strong> saved as draft. <a href="%s" target="_blank">Edit as a blog post</a> or <a href="%s" target="_blank">Edit as a page</a></p>',$post->post_title,admin_url("post.php?post=$post->ID&action=edit&change_post_type=post"),admin_url("post.php?post=$post->ID&action=edit&change_post_type=page"));
        }
        if($post && $post->post_status == 'publish') {
            printf('<p>Imported content <strong>%s</strong> published. <a href="%s" target="_blank">Edit</a></a></p>',$post->post_title,admin_url("post.php?post=$post->ID&action=edit"));
        }
    }    
?>
<h1>Import HTML from FreeToastHost site</h1>
<p>This tool will import text, images, and other content from your FreeToastHost website, giving you a head start on setting up your new home page, supporting pages (like Meeting Info and Directions), and your blog.</p>
<p>A guest registration block will be added near the top of your home page, but you can move it or delete it. You can replace the current home page with the version generated by the importer, append the imported content, or save the old home page as a draft.<p>
<p>The content of other pages will be saved as drafts, and you can decide which of them to keep, update, or discard.</p>
<form method="post" action="<?php echo esc_url($action); ?>">
<p>Paste the home page web address of your old toastmastersclubs.org website below. If you have a custom domain name, enter your club number followed by .toastmastersclubs.org (entering the custom domain name below will not work).</p>
<p><input type="text" name="url" value="<?php echo get_option('freetoasthost'); ?>" size="100" placeholder="https://2445.toastmastersclubs.org" /></p>
<p><input type="radio" name="rewrite" value="replace" checked="checked" /> Replace home page content with imported content</p>
<p><input type="radio" name="rewrite" value="append" /> Append imported home page content (for example, if you have already started editing your home page)</p>
<p><input type="radio" name="rewrite" value="0" /> Save as draft</p>
<?php
    wp_nonce_field( 'drafty', 'drafty_field' );
    if(is_admin())
        submit_button('Submit');
    else
        echo '<p><button>Submit</button></p>';
    echo '</form>';
    }
    
    if(function_exists('toastmost_starter_club_homepage') && current_user_can('manage_network')) {
        printf('<p style="margin-top: 100px;"><a href="%s">Reset</a></p>',admin_url('admin.php?page=fth_importer_docs&reset=1'));
    }
}

function fth_importer_image_size() {
    $imgsize = get_option('docs_from_google_image_size');
    if(empty($imgsize))
        $imgsize = 512;
    return $imgsize;
}

// adapted from https://gist.github.com/m1r0/f22d5237ee93bcccb0d9
function fth_importer_insert_attachment_from_url( $url, $file_name, $parent_post_id = null ) {
    ob_start();
    global $wpdb;
    $sql = "SELECT ID from $wpdb->posts WHERE guid LIKE '%".$file_name."' ";
    $existing = $wpdb->get_var($sql);
    if($existing)
    {
        return $existing;
    }

    if(strpos($url,'base64')) {
        $parts = explode('base64,',$url);
        $b64 = trim($parts[1]);
        $image = base64_decode($b64);
        $upload = wp_upload_bits( $file_name, null, $image );
    }
    else {
        if ( ! class_exists( 'WP_Http' ) ) {
            require_once ABSPATH . WPINC . '/class-http.php';
        }
    
        $http     = new WP_Http();
        $response = $http->request( $url );
         if ( !is_array($response) || ( 200 !== $response['response']['code'] ) ) {
            if(current_user_can('manage_options'))
                print_r($response);
            return false;
        }
        $upload = wp_upload_bits( $file_name, null, $response['body'] );
    }

	if ( ! empty( $upload['error'] ) ) {
		return false;
	}

	$file_path        = $upload['file'];
	$file_type        = 'image/png';
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir    = wp_upload_dir();

	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type,
		'post_title'     => $attachment_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	// Create the attachment.
	$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );

	// Include image.php.
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Generate the attachment metadata.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
 
	// Assign metadata to attachment.
	wp_update_attachment_metadata( $attach_id, $attach_data );

    ob_get_clean();
	return $attach_id;
}

function dfgd_category_picker($pick = '') {
    $o = '<option></option>';
    $categories = get_categories( array(
        'orderby' => 'name',
        'parent'  => 0 // top level only
    ) );
    foreach($categories as $category) {
        $s = ($pick == $category->term_id) ? ' selected="selected" ' : '';
        $o .= sprintf('<option value="%s" %s>%s</option>',$category->term_id, $s, $category->name);
    }
    echo '<p>Primary Category: <select name="category">'.$o.'</select></p>';
}


if(isset($_GET['change_post_type']))
    add_action('admin_init','wpt_post_to_page');

function wpt_post_to_page() {
    if(isset($_GET['change_post_type']) && isset($_GET['post'])) {
        $id = intval($_GET['post']);
        wp_update_post(array("ID"=>$id,'post_type'=>sanitize_text_field($_GET['change_post_type'])));
    }
}

if(!empty($_GET['remove_boilerplate']))
add_action('admin_init','wpt_remove_boilerplate');

function wpt_remove_boilerplate($front_id = 0,$insert = '') {
    if(!$front_id)
        $front_id = get_option('page_on_front');
    $post = get_post($front_id); 
    if($post && strpos($post->post_content,'id="boilerplate"')) {
    $parts = explode("<!-- wp:separator -->",$post->post_content);//\s*<!-- \/wp:heading -->
    $content = $parts[0].$insert;
    if(!empty($parts[2])) {
        $parts = explode('<!-- /wp:separator -->',$parts[2]);
        $content .= $parts[1];
    }
    $update['ID'] = $front_id;
    $update['post_content'] = $content;
    wp_update_post($update);
    if(!isset($_GET['page']))
        wp_safe_redirect(admin_url("post.php?post=$front_id&action=edit"));
    }
}
