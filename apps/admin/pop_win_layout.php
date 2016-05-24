<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<!DOCTYPE html>
<html ng-app>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Cache-Control" content="no-cache"/>
        <!--<link rel="SHORTCUT ICON" href="<?php echo SITE_ROOT ?>favicon.ico">-->
        <title><?php echo $this->_page_title; ?></title>
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

        <!--combobox-->
        <script src="<?php echo SITE_ROOT; ?>public/js/jquery/jquerycombobox/js/jquery.combobox.js" type="text/javascript"></script>
        <link href="<?php echo SITE_ROOT; ?>public/js/jquery/jquerycombobox/css/style.css" rel="stylesheet" type="text/css"/>
        
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
    <body style="background-color:white;">
                <?php
                echo $content;
                ?>

    </body>
</html>