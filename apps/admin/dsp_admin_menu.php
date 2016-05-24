<?php
$menu_file_path = SERVER_ROOT . 'apps' . DS . 'admin' . DS . 'menu.xml';
$dom_xml_menu = simplexml_load_file($menu_file_path);
$result_category = $dom_xml_menu->xpath('//category');

$modules_code_active = '';
$result = $dom_xml_menu->xpath("//item[modules='".$this->module_name."']/@code");
if(count($result) > 1)
{
    $modules_code_active = xpath($dom_xml_menu,"//item[modules='".$this->module_name."' and param='".$this->function_active."']/@code",XPATH_STRING);
}
elseif($result == NULL){
    $modules_code_active = xpath($dom_xml_menu,"//category/@category_code",XPATH_STRING);
}else
{
    $modules_code_active = (string) $result[0];
}
?>
<input type="hidden" value="<?php echo $modules_code_active?>" id="global_current_modules_active" name="global_current_modules_active" />
<script>
    $(function(){
        var modules_code_active = $('#global_current_modules_active').val();
        var element = $('ul.nav a').filter(function() {
            return $(this).attr('data-item-code') == modules_code_active;
        }).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        }
    });
</script>
<div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="form-group" style="padding:15px; margin: 0;">
                    <select class="form-control" name="select_website" id="select_website" onchange="choose_website_onchange()">

                        <?php foreach ($arr_all_grant_website as $key => $value): ?>
                            <option value="<?php echo $key; ?>" 
                            <?php
                            if ($key == $v_session_website_id) {
                                echo 'selected';
                            }
                            ?>
                                    > 
                                        <?php echo $value; ?> 
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- /input-group -->
                </li>
                <?php
                foreach ($result_category as $category):
                    $category_name = (string) $category->category_name;
                    $category_code = (string) $category->attributes()->category_code;
                    if(empty($category_code)) :
                    ob_start();
                    foreach ($category->item as $item):
                        $item_name           = (string) $item->name;
                        $modules             = (string) $item->modules;
                        $permissions_role    = (string) $item->attributes()->code;
                        $param               = isset($item->param) ? (string) $item->param : '';
                        $icon_list           = (string) $item->icon;
                        $permissions_website = ((string) $item->permission_on_website == '1') ? TRUE : FALSE;
                        $target              = isset($item->target)? (string) $item->target: '';
                        
                        if (session::check_permission($permissions_role, $permissions_website) == FALSE) {
                            continue;
                        }
                        ?>
                        <li>
                            <a target="<?php echo $target?>" href="<?php echo get_admin_controller_url($modules, $param); ?>" data-item-code="<?php echo $permissions_role ?>">
                                <i class="<?php echo $icon_list ?>"></i> 
                                <?php echo __($item_name) ?>
                            </a>
                        </li>
                    <?php endforeach; 
                    $html = ob_get_clean();
                    if ($html == '') {
                        continue;
                    }
                    ?>
                    <li>
                        <a href="#"> <?php echo __($category_name); ?><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php echo $html; ?>
                        </ul>
                    </li>
                <?php 
                    endif;
                    if(!empty($category_code)) :
                ?>
                    <li>
                        <a href="<?php echo get_admin_controller_url($category_code); ?>" data-item-code="<?php echo $category_code ?>"> 
                            <?php echo __($category_code); ?>
                        </a>
                    </li>
                <?php
                    endif;
                    endforeach; ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>