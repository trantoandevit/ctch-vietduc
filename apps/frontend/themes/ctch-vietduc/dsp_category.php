<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php
$VIEW_DATA['title'] = $this->website_name;

$VIEW_DATA['v_banner'] = $v_banner;
$VIEW_DATA['arr_all_website'] = $arr_all_website;
$VIEW_DATA['arr_all_menu_position'] = $arr_all_menu_position;

$VIEW_DATA['arr_css'] = array('category');

$VIEW_DATA['arr_script'] = array('my_js/category/category', 'my_js/sidebar_right');
$category_id = get_request_var('category_id');

$this->render('dsp_header', $VIEW_DATA, $this->theme_code);
//echo '<script> var FULL_SITE_ROOT = "' . FULL_SITE_ROOT . '"</script>';
?>
<script>
    var category_id = "<?php echo $category_id; ?>";
</script>
<section ng-cloak ng-controller="content">
    <div class="container content">
        <div class="row news">
            <div class="col-md-8 new_left">
                <div class="row nlc_head">
                    <div class="rnlc_content">
                        <ul class="list-unstyled list-inline">
                            <li><a href="<?php echo FULL_SITE_ROOT; ?>">Trang chủ</a></li>
                            <li><a href="">{{category_name}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row nlc_row_head">
                    <h3>{{category_name}}</h3>
                    <div class="bg_row_head"></div>
                    <div class="bg_row_head_last">
                        <img src="<?php echo CONST_SITE_THEME_ROOT; ?>img/n1.jpg" alt="" />
                    </div>
                </div>
                <div class="row nlc_list">
                    <div ng-repeat="item in arr_category" class="col-md-12 col-sm-6 col-xs-12 rnlc_1 single_khoa">
                        <div class="row">
                            <div class="col-md-5 rnlc_img">
                                <img src="{{item.C_FILE_NAME}}" alt="" />
                            </div>
                            <div class="col-md-7 rnlc_info">
                                <div class="ni_head">
                                    <h3><a href="{{item.C_URL}}">{{item.C_TITLE}}</a></h3>
                                </div>
                                <div class="ni_time">
                                    <p><span class="fa fa-clock-o"></span> {{item.C_BEGIN_DATE}}</p>
                                </div>
                                <div class="ni_introtext">
                                    <p ng-bind-html="item.C_SUMMARY">
                                    </p>
                                </div>
                                <div class="ni_seemore">
                                    <a href="{{item.C_URL}}">Đọc tiếp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <paging
                        page="paging.page" 
                        page-size="paging.pagesize" 
                        total="paging.total"
                        paging-action="paging.pagging_action()">
                    </paging> 
                </div>
            </div>
            <?php $this->render('dsp_sidebar_right', $VIEW_DATA, $this->theme_code); ?>
        </div>

    </div>
</section>
<?php
$this->render('dsp_footer', $VIEW_DATA, $this->theme_code);
