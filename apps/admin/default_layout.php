<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<!DOCTYPE html>
<?php
    $unit_name = get_system_config_value('unit_name');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Cache-Control" content="no-cache"/>
        <!--<link rel="SHORTCUT ICON" href="<?php echo SITE_ROOT ?>favicon.ico">-->
        <title><?php echo $unit_name . ' - ' .$this->_page_title; ?></title>
        <link rel="stylesheet" href="<?php echo SITE_ROOT; ?>public/css/reset.css" type="text/css" media="screen" />
<!--        <link rel="stylesheet" href="<?php echo SITE_ROOT; ?>public/css/1008_24_0_0.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo SITE_ROOT; ?>public/css/text.css" type="text/css" media="screen" />-->
        <script src="<?php echo SITE_ROOT; ?>public/bootstrap-3/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
        
        <link rel="stylesheet" href="<?php echo SITE_ROOT; ?>apps/admin/style.css" type="text/css"  />
        
        <script type="text/javascript">
            var SITE_ROOT='<?php echo SITE_ROOT; ?>';
            var _CONST_LIST_DELIM = '<?php echo _CONST_LIST_DELIM; ?>';
        </script>
        <!--  Modal dialog -->
        <script src="<?php echo SITE_ROOT; ?>public/js/submodal.js" type="text/javascript"></script>
        <link href="<?php echo SITE_ROOT; ?>public/css/subModal.css" rel="stylesheet" type="text/css"/>
        
        <!--combobox-->
        <script src="<?php echo SITE_ROOT; ?>public/js/jquery/jquerycombobox/js/jquery.combobox.js" type="text/javascript"></script>
        <link href="<?php echo SITE_ROOT; ?>public/js/jquery/jquerycombobox/css/style.css" rel="stylesheet" type="text/css"/>
        
        <!-- Tooltip -->
        <script src="<?php echo SITE_ROOT; ?>public/js/overlib_mini.js" type="text/javascript"></script>

        <script src="<?php echo SITE_ROOT; ?>public/js/mylibs.js" type="text/javascript"></script>
        <script src="<?php echo SITE_ROOT; ?>public/js/DynamicFormHelper.js" type="text/javascript"></script>
        <script src="<?php echo SITE_ROOT; ?>public/js/jquery/auto-slug.js"></script>

        <!-- Upload -->
        <script src="<?php echo SITE_ROOT; ?>public/js/jquery/jquery.MultiFile.pack.js" type="text/javascript"></script>
        <script src="<?php echo SITE_ROOT; ?>public/js/jquery/jquery.MetaData.js" type="text/javascript"></script>
         
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
    
    
    <!--datepicker-->
    <script src="<?php echo SITE_ROOT; ?>public/bootstrap-3/js/moment-with-locales.js"></script>
    <script src="<?php echo SITE_ROOT; ?>public/bootstrap-3/js/bootstrap-datepicker.js"></script>
    <link href="<?php echo SITE_ROOT; ?>public/bootstrap-3/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>
    
        <script>
            <?php
                if(check_file_htaccess())
                {
                    echo 'QS = "'.DS . '\";' ;
                }
                else
                {
                    echo 'QS = "?"';
                }
            ?>

        </script>
        
        <?php if (isset($this->local_js)): ?>
            <!-- Module JS -->
            <script src="<?php echo $this->local_js; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <!--css ie-->
        <!--[if IE]>
       <link href="<?php echo SITE_ROOT; ?>apps/admin/style_ie.css" rel="stylesheet" type="text/css" />
       <![endif]-->
    </head>
    <body>
        <?php
        Session::init();
        $arr_all_grant_website = $this->arr_all_grant_website; //
        $arr_all_lang          = $this->arr_all_lang;
        $arr_count_article     = $this->arr_count_article;
        //var_dump($arr_all_grant_website);

        $v_user_login_name = Session::get('user_login_name');

        $v_session_website_id = isset($_SESSION['session_website_id']) ? $_SESSION['session_website_id'] : '';
        $v_session_lang_id    = isset($_SESSION['session_lang_id']) ? $_SESSION['session_lang_id'] : '';
        $v_show_div_website   = (isset($this->show_div_website) && $this->show_div_website == FALSE) ? FALSE : TRUE;

        $v_menu_select = session::get('menu_select');
        echo view::hidden('hdn_menu_select', $v_menu_select);
    ?>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; z-index:0;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo SITE_ROOT; ?>admin" style="padding:5px 0 5px 20px;"><img src="<?php echo SITE_ROOT; ?>logo.png" width="40" height="40"/></a>
        <p class="navbar-brand" style="margin-bottom:0;"><?php echo $unit_name?></p>
        
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
    <!-- /.dropdown -->
        <li class="dropdown">
            <a href="#" data-toggle="modal" data-target="#myModal" title="<?php echo __('account'); ?>">
                <i class="fa fa-user fa-fw"></i>
            </a>
        </li>
        <li class="divider"></li>
        <li class="dropdown">
            <a href="<?php echo SITE_ROOT . "logout.php" ?>" title="<?php echo __('logout'); ?>">
                <i class="fa fa-sign-out fa-fw"></i>
            </a>
        </li>
    <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <?php include 'dsp_admin_menu.php'; ?>
    <!-- /.navbar-static-side -->
    </nav>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php require SERVER_ROOT.'apps'.DS.'admin'.DS.'modules'.DS.'dashboard'.DS.'dashboard_views'.DS.'dsp_change_password.php';?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $content;
            ?>

        <script>
            var SITE_ROOT = "<?php echo SITE_ROOT; ?>";
            $(document).ready(function(){
                var div_select = '#'+$('#hdn_menu_select').val();
                //alert($('#hdn_menu_select').attr('value'));
                $(div_select).attr('class','TopMenuActive');
            });
            function choose_website_onchange()
            {
                var lang_id     = $('#select_lang').val();
                var website_id  = $('#select_website').val();
                var html = '<form name="form_submit" id="form_submit" method="POST" action=""></form>';
                $('#header_admin').append(html);
                $('#form_submit').attr('action','<?php echo get_admin_controller_url('dashboard/do_change_session_website_id'); ?>&website_id='+website_id+'&lang_id='+lang_id);
                $('#form_submit').submit();
            }
            function choose_lang_onchange()
            {
                var lang_id     = $('#select_lang').val();
                var website_id  = 0;
                var html = '<form name="form_submit" id="form_submit" method="POST" action=""></form>';
                $('#header_admin').append(html);
                $('#form_submit').attr('action','<?php echo get_admin_controller_url('dashboard/do_change_session_website_id'); ?>&website_id='+website_id+'&lang_id='+lang_id);
                $('#form_submit').submit();
            }
            function change_password_onclick()
            {
                var url="<?php echo get_admin_controller_url('dashboard/dsp_change_password'); ?>&pop_win=1";
                showPopWin(url,800,500);
            }
            function set_cookie_menu(value)
            {
                var html = '<form name="form_submit" id="form_submit" method="POST" action=""></form>';
                $('#header_admin').append(html);
                $('#form_submit').attr('action','<?php echo get_admin_controller_url('dashboard/do_change_session_menu_select'); ?>'+value);
                $('#form_submit').submit();
            }
        </script>
        <?php
        //?>
        </div>
        <div class="clear">&nbsp;</div>
        <div class="col-lg-12" style="float: right;">
            <?php
                $v_unit_name = defined('_CONST_UNIT_NAME_ERRORS') ? _CONST_UNIT_NAME_ERRORS : '';
            ?>
        </div>
    </div>
</div>
<footer style="padding: 10px;font-size: 12px; background-color: #f8f8f8;color: #777;">
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="text-align: center;">
                    © 2015 | Phần mềm Cổng thông tin: <a href="<?php echo FULL_SITE_ROOT?>" style="color: #777;"><?php echo get_system_config_value(CFGKEY_UNIT_NAME);?></a>
                </div>

            </div>
        </div>
</footer>

</div>
<script>
function choose_website_onchange()
    {
        var website_id  = $('#select_website').val();
        var html = '<form name="form_submit" id="form_submit" method="POST" action=""></form>';
        $('#wrapper').append(html);
        $('#form_submit').attr('action','<?php echo get_admin_controller_url('dashboard/do_change_session_website_id'); ?>&website_id='+website_id);
        $('#form_submit').submit();
    }
</script>
        
</body>
</html>
