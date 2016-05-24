<?php if (!defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
} ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Cache-Control" content="no-cache"/>
        <title>Đăng nhập hệ thống</title>
        <!-- Bootstrap 3 -->
        <!-- Bootstrap Core CSS -->
    <link href="<?php echo SITE_ROOT; ?>public/bootstrap-3/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo SITE_ROOT; ?>public/bootstrap-3/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo SITE_ROOT; ?>public/bootstrap-3/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo SITE_ROOT; ?>public/bootstrap-3/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo SITE_ROOT; ?>public/bootstrap-3/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo SITE_ROOT; ?>public/bootstrap-3/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo SITE_ROOT; ?>public/bootstrap-3/dist/js/sb-admin-2.js"></script>
        <script language="javascript" type="text/javascript">

            function setFocus() {
                document.loginForm.txt_login_name.select();
                document.loginForm.txt_login_name.focus();
            }

            function btn_login_onclick(){
                var f=document.loginForm;
                if (f.txt_login_name.value == ''){
                    alert("Ban phai nhap [Ten dang nhap]!");
                    f.txt_login_name.focus();
                    return false;
                }
                
                if (document.loginForm.txt_password.value == ''){
                    alert("Ban phai nhap [Mat khau]!");
                    f.txt_password.focus();
                    return false;
                }
                
                f.submit();
            }

            function login(evt){
                if(navigator.appName=="Netscape"){theKey=evt.which}
                if(navigator.appName.indexOf("Microsoft")!=-1){theKey=window.event.keyCode}
                if(theKey==13){
                    btn_login_onclick();
                }
            }
        </script>
    </head>
    <body>
        <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Đăng nhập hệ thống</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo $this->get_controller_url();?>do_login" method="post" name="loginForm" id="loginForm">
                            <fieldset>
                                <div class="ErrorMessage">
                                    <span id="lblErrorMessage"></span>
                                    <div id="vsLogin" style="color:Red;display:none;">

                                    </div>
                                </div>
                                <div class="ErrorMessage" style="margin-bottom:10px;">
                                    <span id="lblUserName">Tên đăng nhập:</span>
                                    <span id="rfvUserName" style="color:Red;display:none;">Tên đăng nhập không được bỏ trống</span>
                                </div>
                                <div class="form-group">
                                    <input name="txt_login_name" type="text" id="txt_login_name" class="form-control" onkeypress="login(event);" autofocus="autofocus" placeholder="Tên đăng nhập"/>
                                </div>
                                <div class="ErrorMessage" style="margin-bottom:10px;">
                                    <span id="lblPassword">Mật khẩu:</span>
                                    <span id="rfvPassword" style="color:Red;display:none;">Mật khẩu không được bỏ trống</span>
                                </div>
                                <div class="form-group">
                                    <input name="txt_password" type="password" id="txt_password" class="form-control" value="123456" onkeypress="login(event);" placeholder="Mật Khẩu"/>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="javascript:void(0)" onclick="btn_login_onclick();" id="cmdLogin" class="btn btn-lg btn-success btn-block">Đăng nhập</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    setFocus();
</script>
<noscript>
    <h2 align="center">Thông báo: Javascript đang bị cấp!</h2>
</noscript>
    </body>
</html>