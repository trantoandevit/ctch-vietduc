<footer ng-cloak="" ng-controller="footer">
    <div class="container footer">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <h4>VIỆN CHẤN THƯƠNG CHỈNH HÌNH VIỆT ĐỨC</h4>
                <p>Địa chỉ: <?php echo $this->theme_config['unit_address'] ?><p>
                <p>Điện thoại: <?php echo $this->theme_config['unit_phone'] ?> - Fax: <?php echo $this->theme_config['unit_fax'] ?></p>
                <?php if ($this->theme_config['unit_email']): ?>
                    <p>Email: <?php echo $this->theme_config['unit_email'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <nav class="navbar navbar-default navbar-right">
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
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" ng-dom="domMenuPosition" data-id="menu_footer">
                                <ul class="nav navbar-nav list_menu">
                                    <li style="text-transform: uppercase;" ng-repeat="menu in menus"><a href="{{menu.C_URL}}">{{menu.C_NAME}}</a></li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </nav>
                    </div>
                    <div class="col-xs-12">
                        <a href="http://newtel.vn/" target="_blank"><img class="fl-right" src="<?php echo CONST_SITE_THEME_ROOT ?>img/newtel-logo.png" height="30"></a>
                        <span class="fl-right">Hỗ trợ kĩ thuật bởi</span>
                    </div>
                    <div class="col-xs-12">
                        <p class="fl-right">Mọi thông tin xin ghi rõ nguồn từ website &copy; <?php echo date("Y"); ?> Bệnh viện Việt Đức</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<style>
    footer .col-xs-12 span
    {
        line-height:30px;
        font-family: "roboto-regular";
        color: #222222;
    }
</style>
<script>
    (function (d, s, id) {
        var width = $('#nr_facebook').outerWidth();
        $('#nr_facebook .fb-page').attr('data-width', width);
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script src="<?php echo CONST_SITE_THEME_ROOT ?>js/angular.min.js"></script>
<script src="<?php echo CONST_SITE_THEME_ROOT ?>js/paging.js"></script>
<script>
    var SITE_ROOT = '<?php echo SITE_ROOT ?>';
    var _VAR_WEBSITE_ID = '<?php echo $this->website_id ?>';
    var _CONST_CLIENT_CAPTCHA_PUBLIC_KEY = '<?php echo _CONST_CLIENT_CAPTCHA_PUBLIC_KEY ?>';
    var _CONST_SERVER_CAPTCHA_PRIVATE_KEY = '<?php echo _CONST_SERVER_CAPTCHA_PRIVATE_KEY ?>';
    var ctch_vietduc = angular.module('ctch_vietduc', ['bw.paging']);
    ctch_vietduc.factory('$apply', function ($rootScope) {
        return function (fn) {
            setTimeout(function () {
                $rootScope.$apply(fn);
            });
        };
    });

    ctch_vietduc.directive('ngDom', function ($apply) {
        return {
            scope: {'ngDom': '='},
            link: function (scope, elem) {
                scope.ngDom = elem[0];
                $apply(function () {
                    scope.ngDom = elem[0];
                });
            }
        };
    });
</script>

<!--my js-->
<script src="<?php echo CONST_SITE_THEME_ROOT ?>js/my_js/services.js"></script>
<script src="<?php echo CONST_SITE_THEME_ROOT ?>js/my_js/header.js"></script>
<script src="<?php echo CONST_SITE_THEME_ROOT ?>js/my_js/footer.js"></script>

<?php
$arr_script = isset($arr_script) ? $arr_script : array();

function add_javascript($arr_script)
{
    //javascript
    $html_javascript = '';
    foreach ($arr_script as $value)
    {

        $html_javascript .= "<script type='text/javascript' src='" . CONST_SITE_THEME_ROOT . "js/" . $value . ".js'></script>\n";
    }
    echo $html_javascript;
}

add_javascript($arr_script);
?>
</body>
</html>
