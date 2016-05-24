
<?php
defined('DS') or die();
$v_website_id = $this->website_id;
?>
<style>
    .widget-gallery-row a
    {
        padding: 5px;
        margin-bottom: 5px;
        text-decoration: none;
        display: block;
    }
    .widget-gallery-row a .widget-gallery-title
    {
        color: rgb(51, 51, 51);
        font-weight: bold;
        padding: 5px 0;
        text-align: justify
    }
    .widget-gallery-row a .widget-gallery-title:hover
    {
        color: rgb(35, 82, 124);
    }
</style>
<div class="panel panel-default">
    <div class="news-title">
        <a href="<?php echo build_url_all_photo_gallery($this->website_id); ?>"><span style="line-height:17px;"><img src="<?php echo SITE_ROOT . "public/images/slider/icon.png" ?>" /></span><label style="text-transform: uppercase;font-weight: bold;text-decoration: none;">Thư viện ảnh</label></a>
    </div>
    <div class="panel-body" style="padding: 0">
        <div class="widget-gallery-content">
            <?php
            foreach ($arr_all_photo_gallery as $row_gallery):
                $v_id = $row_gallery[0];
                $v_title = $row_gallery[1];
                $v_slug = $row_gallery[2];
                $v_file_name = $row_gallery[3];
                $v_summary = $row_gallery[4];

                $path_file = $this->image_default_sticky;
                if ($v_file_name != '') {
                    $path_file = SITE_ROOT . 'upload/' . $v_file_name;
                }
                ?>
                <div class="widget-gallery-row">
                    <a href="<?php echo build_url_photo_gallery($v_website_id, $v_slug, $v_id) ?>" >
                        <img src="<?php echo $path_file ?>" width="100%" />
                        <div class="widget-gallery-title">
                            <?php echo $v_title ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
