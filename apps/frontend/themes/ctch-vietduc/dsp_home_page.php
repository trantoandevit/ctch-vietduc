<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php
$VIEW_DATA['title'] = $this->website_name;

$VIEW_DATA['v_banner'] = $v_banner;
$VIEW_DATA['arr_all_website'] = $arr_all_website;
$VIEW_DATA['arr_all_menu_position'] = $arr_all_menu_position;

$VIEW_DATA['arr_css'] = array('jquery.bxslider', 'home_page/slider');
$VIEW_DATA['arr_script'] = array('jquery.bxslider', 'my_js/home_page/home_page', 'my_js/sidebar_right');



$this->render('dsp_header', $VIEW_DATA, $this->theme_code);
?>
<script>
    var _CONST_LIST_DS_DOI_TAC = '<?php echo _CONST_LIST_DS_DOI_TAC ?>';
</script>
<section ng-cloak ng-controller="content">
    <div class="container content">
        <div class="row slide_top">
            <div class="col-md-8 c_slide">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
                    </ol>

                    <div class="carousel-inner" role="listbox">
                        <div ng-repeat="item in sticky_slide" class="item" ng-class="{active: $first}">
                            <a href="{{item.C_URL}}" alt="{{item.C_TITLE}}" title="{{item.C_TITLE}}">
                                <img src="{{item.C_FILE_NAME}}" alt="{{item.C_TITLE}}">
                            </a>
                        </div>
                    </div>

                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-4 slide-right">
                <div class="sr_bg_box text-center">
                    <img src="<?php echo CONST_SITE_THEME_ROOT ?>img/slide-right.png" alt="">
                </div>
                <div class="sr-box text-center">
                    <div class="srb_top">
                        <h3>Đăng ký khám qua mạng</h3>
                        <h4>Khoa phẫu thuật cột sống - Bệnh viện Việt Đức</h4>
                        <div class="row text-center">
                            <div class="col-md-1 col-sm-3"></div>
                            <div class="col-md-10 col-sm-6 text-center">
                                <a target="_blank" href="{{medical_register.link_register.url}}" class="btn btn-success form-control">Đăng ký</a>
                            </div>
                        </div>
                    </div>
                    <div class="srb_bottom">
                        <h4>Để biết thêm thông tin, xin liên hệ đường dây nóng hỗ trợ đăng ký:</h4>
                        <h3><?php echo $this->theme_config['medical_register_hotline']?></h3>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row btn_service">
            <div ng-repeat="item in medical_register.link" class="col-md-3 col-sm-6 col-xs-12">
                <a target="{{item.target}}" href="{{item.url}}" class="btn btn-primary form-control">{{item.name}}</a>
            </div>
            <div class="col-md-3  col-sm-6 col-xs-12">
                <a href="#" class="btn btn-primary form-control">Đăng nhập</a>
            </div>
        </div>
        <div class="row news">
            <div class="col-md-8 new_left">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nl_header">
                            <h3>Tin tức - Sự kiện</h3>
                        </div>
                        <div class="new_border"></div>
                        <div ng-repeat="item in stickey_news" class="nl_content">
                            <div class="row">
                                <div class="nlc_img col-md-4 col-sm-4 col-xs-12">
                                    <a href="{{item.C_URL}}"><img src="{{item.C_FILE_NAME}}" alt=""></a>
                                </div>
                                <div class="nlc_info col-md-8 col-sm-8 col-xs-12">
                                    <div class="ni_head">
                                        <h3><a href="{{item.C_URL}}">{{item.C_TITLE}}</a></h3>
                                    </div>
                                    <div class="ni_time">
                                        <p><span class="fa fa-clock-o"></span> {{item.C_BEGIN_DATE_DDMMYYY}}</p>
                                    </div>
                                    <div class="ni_introtext">
                                        <p ng-bind-html="item.C_SUMMARY">
                                        </p>
                                    </div>
                                    <div class="ni_seemore">
                                        <a href="{{item.C_URL}}">Đọc thêm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" ng-repeat="item in homepage_cat">
                        <div class="nl_header">
                            <h3><a href="{{item.cat_url}}">{{item.cat_name}}</a></h3>
                            <div class="nlh_box_right">
                                <ul class="list-unstyled list-inline">
                                    <li ng-repeat="other_cat in item.other_cat"><a href="{{other_cat.cat_url}}">{{other_cat.cat_name}}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="new_border"></div>
                        <div class="nl_content">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 nlcb_img">
                                    <div class="row box_img">
                                        <div class="col-md-12">
                                            <a href="{{item.arr_articles.first.url}}"><img src="{{item.arr_articles.first.file_name}}" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="row box_info">
                                        <div class="col-md-12">
                                            <div class="ni_head">
                                                <h3><a href="{{item.arr_articles.first.url}}">{{item.arr_articles.first.title}}</a></h3>
                                            </div>
                                            <div class="ni_time">
                                                <p><span class="fa fa-clock-o"></span> 10/03/2016</p>
                                            </div>
                                            <div class="ni_introtext">
                                                <p ng-bind-html="item.arr_articles.first.summary">
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row box_news_best">
                                        <div class="col-md-12 li_news">
                                            <ul class="list-unstyled">
                                                <li ng-repeat="other_article in item.arr_articles.other">
                                                    <a href="{{other_article.url}}">
                                                        <i class="fa fa-caret-right"></i> 
                                                        {{other_article.title}}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 nlcb_info">
                                    <div class="row">
                                        <div ng-repeat="article in item.arr_articles.has_img" class="col-md-12 nr_1">
                                            <div class="row">
                                                <div class="nlcbr_img col-md-4 col-sm-4 col-xs-4">
                                                    <a href="{{article.url}}"><img src="{{article.file_name}}" alt=""></a>
                                                </div>
                                                <div class="nlcbr_info col-md-8 col-sm-8 col-xs-8">
                                                    <div class="ni_head">
                                                        <h3><a href="{{article.url}}">{{article.title}}</a></h3>
                                                    </div>
                                                    <div class="ni_time">
                                                        <p><span class="fa fa-clock-o"></span> {{article.date}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->render('dsp_sidebar_right', $VIEW_DATA, $this->theme_code); ?>
        </div>
        <div class="row list_doi_tac text-center">
            <div class="list_head">
                <h3>Danh sách đối tác</h3>
            </div>
            <div class="list_content">
                <div class="row">
                    <ul class="bxslider container" ng-dom="domBxslider">
                        <li ng-repeat="item in partner_list">
                            <a href="{{item.C_URL}}"><img src="{{upload_file('/' + item.C_FILE_NAME)}}" /></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->render('dsp_footer', $VIEW_DATA, $this->theme_code);
