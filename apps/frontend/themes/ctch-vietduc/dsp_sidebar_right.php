    <div class="col-md-4 new_right" ng-cloak ng-controller="sidebar_right">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12  nr_one">
            <div class="nr_header">
                <h3><a href="{{default_cat.C_URL}}">{{default_cat.CAT_NAME}}</a></h3>
            </div>
            <div class="new_right_border"></div>
            <div class="nr_content">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 nrc_left">
                        <ul class="list-unstyled">
                            <li ng-repeat="item in default_cat.data" ng-if="$index < config.default_cat_config.data_haft_length">
                                <a href="{{build_art_url(default_cat.CAT_SLUG, item.C_SLUG, default_cat.CAT_ID, item.PK_ARTICLE)}}">
                                    <i class="fa fa-caret-right"></i> 
                                    {{item.C_TITLE}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 nrc_right">
                        <ul class="list-unstyled">
                            <li ng-repeat="item in default_cat.data" ng-if="$index >= config.default_cat_config.data_haft_length">
                                <a href="{{build_art_url(default_cat.CAT_SLUG, item.C_SLUG, default_cat.CAT_ID, item.PK_ARTICLE)}}">
                                    <i class="fa fa-caret-right"></i>
                                    {{item.C_TITLE}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="nr_header">
                <h3>Giới thiệu bệnh viện</h3>
            </div>
            <div class="new_right_border_two"></div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12 col-sm-6 col-xs-12  nr_two">

            <div class="nr_content">
                <div class="row nrb_two_img">
                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/N6CWHaF99Lg?rel=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6 col-xs-12  nr_three">
            <div class="nrt_content">
                <div class="row nrb_three_img">
                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                        <a href="<?php echo FULL_SITE_ROOT ?>"><img src="<?php echo CONST_SITE_THEME_ROOT ?>img/intro_hospital_three.JPG" alt="Giới thiệu bệnh viện" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12  col-sm-6 col-xs-12 nr_facebook" id="nr_facebook">
            <div class="fb-page" data-href="https://www.facebook.com/Vi%E1%BB%87n-ch%E1%BA%A5n-th%C6%B0%C6%A1ng-ch%E1%BB%89nh-h%C3%ACnh-610298395800083/"
                 data-tabs="timeline" data-height="400" data-small-header="true" data-adapt-container-width="true"
                 data-hide-cover="false" data-show-facepile="true">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 nr_bottom_top">
            <div class="nr_header">
                <h3>Góc tri ân</h3>
            </div>
            <div class="new_right_border_bottom"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-12 nr_bottom">
            <div class="nr_content">
                <div class="row nrb_bottom_img">
                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                        <div id="carousel_thanks" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel_thanks" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel_thanks" data-slide-to="1"></li>
                                <li data-target="#carousel_thanks" data-slide-to="2"></li>
                                <li data-target="#carousel_thanks" data-slide-to="3"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner thanks" role="listbox">
                                <div class="item active">
                                    <div class="box_thanks">
                                        <div class="car_top">
                                            <p><i class="fa fa-quote-left"></i> Sau 1 tháng điều trị tại khoa phục hồi chức năng bệnh viện Việt Đức cháu đã đi bình phục. Gia đình rất vui vì bệnh của cháu đã được chữa khỏi <i class="fa fa-quote-right"></i></p>
                                        </div>
                                        <div class="mess_box">
                                            <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/box_mess.png" alt="" />
                                        </div>
                                        <div class="car_bottom">
                                            <div class="cb_img">
                                                <div class="box_mess_img">
                                                    <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/gia_dinh_1.png" alt="" />
                                                </div>
                                            </div>
                                            <div class="cb_info">
                                                <p>Gia đình bé Đặng Minh Hiếu</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="box_thanks">
                                        <div class="car_top">
                                            <p><i class="fa fa-quote-left"></i> Rất cảm ơn sự nhiệt tình trong công tác khám bệnh của đội ngũ cán bộ bệnh viện Việt Đức <i class="fa fa-quote-right"></i></p>
                                        </div>
                                        <div class="mess_box">
                                            <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/box_mess.png" alt="" />
                                        </div>
                                        <div class="car_bottom">
                                            <div class="cb_img">
                                                <div class="box_mess_img">
                                                    <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/gia_dinh_1.png" alt="" />
                                                </div>
                                            </div>
                                            <div class="cb_info">
                                                <p>Một bệnh nhân cho biế</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="box_thanks">
                                        <div class="car_top">
                                            <p><i class="fa fa-quote-left"></i> Sau 1 tháng điều trị tại khoa phục hồi chức năng bệnh viện Việt Đức cháu đã đi bình phục. Gia đình rất vui vì bệnh của cháu đã được chữa khỏi <i class="fa fa-quote-right"></i></p>
                                        </div>
                                        <div class="mess_box">
                                            <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/box_mess.png" alt="" />
                                        </div>
                                        <div class="car_bottom">
                                            <div class="cb_img">
                                                <div class="box_mess_img">
                                                    <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/gia_dinh_1.png" alt="" />
                                                </div>
                                            </div>
                                            <div class="cb_info">
                                                <p>Gia đình bé Đặng Minh Hiếu</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="box_thanks">
                                        <div class="car_top">
                                            <p><i class="fa fa-quote-left"></i> Sau 1 tháng điều trị tại khoa phục hồi chức năng bệnh viện Việt Đức cháu đã đi bình phục. Gia đình rất vui vì bệnh của cháu đã được chữa khỏi <i class="fa fa-quote-right"></i></p>
                                        </div>
                                        <div class="mess_box">
                                            <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/box_mess.png" alt="" />
                                        </div>
                                        <div class="car_bottom">
                                            <div class="cb_img">
                                                <div class="box_mess_img">
                                                    <img src="<?php echo CONST_SITE_THEME_ROOT; ?>/img/gia_dinh_1.png" alt="" />
                                                </div>
                                            </div>
                                            <div class="cb_info">
                                                <p>Gia đình bé Đặng Minh Hiếu</p>
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
</div>
<style>
/*    .fb-page, 
    .fb-page span, 
    .fb-page span iframe[style] { 
        width: 100% !important; 
    }
    .fb-page span iframe[style] ._2p3a
    {
        width:100% !important;
    }
    .fb-page span iframe[style] .uiScaledImageContainer ._2zfr
    {
        width:100%;
    }*/
</style>