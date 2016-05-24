<?php
    defined('DS') or die();
    $session_key = 'WIDGET_MEDIA_VIDEO_COUNT';
    @session_start();
    $index  = (int) Session::get($session_key);
    $index += 1;
    Session::set("$session_key", $index);
    
    $url_cat = '';
    if(isset($arr_all_new_video_clip[0]))
    {
        $v_category_id    = $arr_all_new_video_clip[0]['PK_CATEGORY'];
        $v_category_slug  = $arr_all_new_video_clip[0]['C_CAT_SLUG'];
        $v_website_id     = Session::get('session_website_id');
        $url_cat = build_url_category($v_category_slug, $v_website_id, $v_category_id);
        $url_cat = SITE_ROOT . 'frontend/frontend/dsp_list_video?website_id=' .   $v_website_id;
    }

$v_file_default = $this->image_default_sticky;
?>
<div class="panel panel-default">
    <?php if(trim($title) !=''):?>
    <div class="news-title">
        <a href="<?php echo $url_cat ?>"><span style="line-height:17px;"><img src="<?php echo SITE_ROOT . "public/images/slider/icon.png" ?>" /></span><label style=""><?php echo $title ?></label></a>
    </div>
    <?php endif;?>
    <div class="panel-body" style="padding: 0">
        <?php if(isset($arr_all_new_video_clip[0])):?>
        <?php 
            $first_video      = get_array_value($arr_all_new_video_clip, 0);
            $v_article_id     = get_array_value($first_video, 0);
            $v_art_slug       = get_array_value($first_video, 1);
            $v_art_title      = get_array_value($first_video, 2);
            $v_category_id    = get_array_value($first_video, 3);
            $v_category_slug  = get_array_value($first_video, 4);
            $v_file_name      = get_array_value($first_video, 5);
            $v_content        = get_array_value($first_video, 6);
            
            if(!file_exists(SERVER_ROOT.'upload/'.$v_file_name))
            {
                $v_file_name = $v_file_default;
            }
            else
            {
                $v_file_name = SITE_ROOT.'upload/'.$v_file_name;
            }
            
            $video_src = strip_tags($v_content);                               
            $video_src = str_replace(array('[video]', '[/video]'), '', $video_src);
            $count_dr = count(explode('/', $video_src));
            if ($count_dr == 1)
            {
                //is Youtube.
                $youtube_url = 'https://www.youtube.com/embed/' . $video_src;
                $html = '<iframe width="100%" height="189px" src="' . $youtube_url . '" frameborder="0" allowfullscreen></iframe>';
            }
            else
            {
                preg_match("/\[VIDEO\](.*)\[\/VIDEO\]/i", $v_content, $matches, PREG_OFFSET_CAPTURE);
                $v_video_url = get_array_value(get_array_value($matches, 1), 0);
                $html = " <center class='tieude'><h2>". html_entity_decode($v_art_title) ."</h2></center>
                <center class='auto_video'>
                    <video data-key='$index'  video-id-current='$v_article_id'  width='100%' height='189px' poster='$v_file_name' controls='' name='video_play' id='video_play'>
                    <source src='$v_video_url' type='video/mp4'>
                    </video>
                </center>";
            }
        ?>
        <div class="video" id='box-video-hx' data-key="<?php echo $index ?>" >
            <?php echo $html ?>
        </div>
        <?php endif;?>
        <div id="list-video" class="list-video" data="widget-video">
            <ul class="list" style="padding: 0;margin: 0">
            <?php for($i = 0; $i < count($arr_all_new_video_clip); $i++):?>
            <?php           
            $v_article_id      = $arr_all_new_video_clip[$i][0];
            $v_art_slug        = $arr_all_new_video_clip[$i][1];
            $v_art_title       = $arr_all_new_video_clip[$i][2];
            $v_category_id     = $arr_all_new_video_clip[$i][3];
            $v_category_slug   = $arr_all_new_video_clip[$i][4];
            $v_file_name       = $arr_all_new_video_clip[$i][5];
            $v_content         = $arr_all_new_video_clip[$i][6];
            if(!file_exists(SERVER_ROOT.'upload/'.$v_file_name))
            {
                $v_file_name = $v_file_default;
            }
            else
            {
                $v_file_name = SITE_ROOT.'upload/'.$v_file_name;
            }
            $video_src = strip_tags($v_content);                               
            $video_src = str_replace(array('[video]', '[/video]'), '', $video_src);
            $count_dr = count(explode('/', $video_src));
            $style_hide_title = '';
            if($i ==0)
            {
                $style_hide_title = 'style="display:none"';
            }
            $html = '';
            if ($count_dr == 1)
            {
                //is Youtube.
                $youtube_url = 'https://www.youtube.com/embed/' . $video_src;
                $html  = "<li $style_hide_title data-key='$index' video-id='$v_article_id ;' >
                         <a  href='javascript:' id-youtobe='$video_src' onclick=\"show_video(this);\">
                                ".html_entity_decode($v_art_title)."
                        </a>
                        <div style='display:none'>
                            <iframe width=\"100%\" height=\"189px\" src=\"$youtube_url\" frameborder=\"0\" allowfullscreen></iframe>
                        </div>
                        </li>";
            }
            else
            {
                preg_match("/\[VIDEO\](.*)\[\/VIDEO\]/i", $v_content, $matches, PREG_OFFSET_CAPTURE);
                $v_video_url = get_array_value(get_array_value($matches, 1), 0); 
                $html = " 
                            <li $style_hide_title data-key='$index' video-id='$v_article_id ;'>
                                    <a  href='javascript:' onclick=\"show_video(this);\">
                                            ".html_entity_decode($v_art_title)."
                                    </a>
                                    <div style='display:none'>
                                        <center class='tieude'><h2>". html_entity_decode($v_art_title) ."</h2></center>
                                            <center class='auto_video'>
                                                <video data-key='$index'  video-id-current='$v_article_id'  width='100%' height='189px' poster='$v_file_name' controls='' name='video_play' id='video_play'>
                                                <source src='$v_video_url' type='video/mp4'>
                                                </video>
                                            </center>
                                    </div>
                        </li> ";
            }
            echo $html;
            ?> 
            <?php endfor; ?>  
            </ul> 
        </div>
    </div>
</div>
