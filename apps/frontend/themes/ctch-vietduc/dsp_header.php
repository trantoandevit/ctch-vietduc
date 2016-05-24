<!DOCTYPE html>
<?php
    
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <link rel="icon" type="image/png" href="<?php echo FULL_SITE_ROOT . 'favicon.ico'?>">
		
        <!-- Bootstrap -->
        <link href="<?php echo CONST_SITE_THEME_ROOT ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo CONST_SITE_THEME_ROOT ?>css/font-opensans.css" rel="stylesheet">
        <link href="<?php echo CONST_SITE_THEME_ROOT ?>css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo CONST_SITE_THEME_ROOT ?>style.css" media="screen" title="no title" charset="utf-8" rel="stylesheet">
        <!-- cap cha -->
        <script src='https://www.google.com/recaptcha/api.js?hl=vi'></script>
        <script src="<?php echo CONST_SITE_THEME_ROOT ?>js/jquery-2.2.3.min.js"></script>
        <script src="<?php echo CONST_SITE_THEME_ROOT ?>js/jquery.js"></script>
        <script src="<?php echo CONST_SITE_THEME_ROOT ?>js/bootstrap.min.js"></script>
        <?php
            $arr_css = isset($arr_css) ? $arr_css : array();
            
            function add_css($arr_css)
            {
                //css
                $html_css = '';
                foreach ($arr_css as $value)
                {
                    $html_css .= "<link rel='stylesheet' href='" . CONST_SITE_THEME_ROOT . 'css/' . $value . ".css'> \n";
                }
                echo $html_css;
            }

            add_css($arr_css);
            ?>
    </head>
    <body ng-app="ctch_vietduc">
        <div id="wrapper">
            <header ng-cloak ng-controller="header">
                <div class="container header">
                    <div class="row">
                        <div class="col-md-12 top-info">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <?php if($this->theme_config['unit_address']):?>
                                    <i class="fa fa-hospital-o fa-2x" aria-hidden="true"></i>
                                    <label> Địa chỉ: <?php echo $this->theme_config['unit_address']?></label>
                                    <?php endif;?>
                                </div>
                                <div class="col-md-6 col-xs-12 right-top-info">
                                    <div style="float:right">
                                        <a href="#">Liên hệ</a>
                                        <a href="<?php echo FULL_SITE_ROOT; ?>hoi-dap">Hỏi đáp</a>
                                        <img src="<?php echo CONST_SITE_THEME_ROOT ?>img/English-icon.png" height="14" width="30" style="margin-top:-5px">
                                        <a href="#">English</a>
                                        <a href="https://www.facebook.com/vienchanthuongchinhhinhvietduc/" target="_blank"><img src="<?php echo CONST_SITE_THEME_ROOT ?>img/fa-facebook.png" height="30" width="30"></a>
                                        <img src="<?php echo CONST_SITE_THEME_ROOT ?>img/fa-google+.png" height="30" width="30">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 top-logo">
                            <div class="row">
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <img src="<?php echo CONST_SITE_THEME_ROOT ?>img/Layer-1.png">
<!--                                    <span><?php echo $this->theme_config['unit_name']?></span>-->
                                    <span>Viện Chấn Thương Chỉnh Hình</span>
                                    <span>Bệnh Viện Hữu Nghị Việt Đức</span>
                                </div>
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <?php if($this->theme_config['unit_phone']):?>
                                        <div class="fl-right mid-top-right col-md-6">
                                            <div class="fl-right">
                                                <p>Điện thoại</p>
                                                <p class="red-text"><?php echo $this->theme_config['unit_phone']?></p>
                                            </div>
                                            <div class="fl-right">
                                                <img src="<?php echo CONST_SITE_THEME_ROOT ?>img/Shape-292.png">
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <?php if($this->theme_config['unit_hotline']):?>
                                        <div class="fl-right mid-top-right col-md-6">
                                            <div class="fl-right">
                                                <p>HOTLINE</p>
                                                <p class="red-text"><?php echo $this->theme_config['unit_hotline']?></p>
                                            </div>
                                            <div class="fl-right">
                                                <img src="<?php echo CONST_SITE_THEME_ROOT ?>img/Shape-289.png">
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 top-nav">
                            <div class="row">
                                <nav class="navbar navbar-default my-top-nav">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>


                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" ng-dom="domMenuPosition" data-id="menu_header">
                                        <ul class="nav navbar-nav">
                                            <li style="text-transform: uppercase;" ng-repeat="menu in menus"><a href="{{menu.C_URL}}">{{menu.C_NAME}}</a></li>
                                        </ul>
                                    </div><!-- /.navbar-collapse -->
                                </nav>

                            </div>
                        </div>
                    </div>
            </header>
