<?php

if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
////header
//$this->template->title = get_system_config_value('unit_name');
//
//$this->template->display('dsp_header.php');
@session::init();
if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
{
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
{
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
    $ip = $_SERVER['REMOTE_ADDR'];
}

$menu_file_path = SERVER_ROOT . 'apps' . DS . 'admin' . DS . 'menu.xml';
$dom_xml_menu = simplexml_load_file($menu_file_path);
$arr_category_name = $dom_xml_menu->xpath('//category/category_name');
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('dashboard');?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<style>
    .panel:hover {
        opacity: 0.6;
    }
</style>

<div class="panel-body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="dashboard_tab">
        <?php for($i = 0; $i < count($arr_category_name); $i++):
                $category_name  = (string) $arr_category_name[$i];
                $tab_id = 'dashboard_tab_' . $i;
                //kiem tra cac phan con
                $check = 'check_'.$tab_id;
                $$check = 0;
                $category_position = $i + 1;
                $arr_all_item = $dom_xml_menu->xpath('//category['.$category_position.']/item');
                foreach($arr_all_item as $item)
                {
                    $permissions_role    	= (string)  $item->attributes()->code;
                    $permissions_website 	= ((string)  $item->permission_on_website == '1')?TRUE:FALSE;
                    if(session::check_permission($permissions_role,$permissions_website) == FALSE)
                    {
                        continue;
                    }
                    $$check ++;
                }
                if($$check < 1)
                {
                    continue;
                }
        ?>
        <li><a href="#<?php echo $tab_id; ?>" data-toggle="tab" aria-expanded="true"><?php echo __($category_name); ?></a></li>
        <?php endfor;?>
    </ul>
     <!-- Tab panes -->
    <div class="tab-content" style="margin-top: 50px;">
    <?php for($i = 0; $i < count($arr_category_name); $i++):
            $tab_id = 'dashboard_tab_' . $i;
            //kiem tra cac phan con
            $check = 'check_'.$tab_id;
            if($$check < 1)
            {
                continue;
            }
    ?>
        <div class="tab-pane fade in" id="<?php echo $tab_id?>">
            <div class="row">
                <?php
                $category_position = $i + 1;
                $arr_all_item = $dom_xml_menu->xpath('//category['.$category_position.']/item');
                foreach($arr_all_item as $item):
                    $item_name           	= (string) $item->name;
                    $modules             	= (string)  $item->modules;
                    $permissions_role    	= (string)  $item->attributes()->code;
                    $icon_list           	= (string)  $item->icon;
                    $color_list           	= (string)  $item->color;
                    $permissions_website 	= ((string)  $item->permission_on_website == '1')?TRUE:FALSE;
                    $target                     = isset($item->target)? (string) $item->target: '';
                    if(session::check_permission($permissions_role,$permissions_website) == FALSE)
                    {
                        continue;
                    }
                ?>
                <div class="col-lg-3 col-md-6">
                    <a target="<?php echo $target?>" href="<?php echo get_admin_controller_url($modules); ?>">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="<?php echo $icon_list?>" style="font-size: 50px;"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">&nbsp;</div>
                                        <div><?php echo __($item_name)?></div>
                                    </div>
                                </div>
                            </div>
                                <div class="panel-footer">
                                    <span class="pull-left <?php echo $color_list;?>"><?php echo __('details')?></span>
                                    <span class="pull-right <?php echo $color_list;?>"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                    </a>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    <?php endfor;?>
    </div>
</div>

<script>
    $(document).ready(function(){
        var tab = '#dashboard_tab a:first';
        $(tab).tab('show');
    });
</script>