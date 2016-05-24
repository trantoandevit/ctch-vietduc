<?php
defined('DS') or die();
?>
<div class="widget list_menu_category">
    
    <?php if ($title_list_menu_category == 1): ?>
    <div class="widget-title">
        <a >
            <span style="line-height:17px;">
                <img src="<?php echo CONST_SITE_THEME_ROOT . "images/site_map_portlet_icon.png" ?>" />
            </span> 
            <?php echo $title ?>
        </a>
    </div>
    <?php endif; ?>
    <div class="widget-content" >
        <ul class="nav navbar-nav">
            <?php $arr_all_menu['widget_menu'] = isset($arr_all_menu['widget_menu']) ? $arr_all_menu['widget_menu'] : array(); ?>
            <?php
            $v_current_index = 0;
            $v_selected_menu = -1;
            for ($i = 0; $i < count($arr_all_menu['widget_menu']); $i++):
                $row_menu        = $arr_all_menu['widget_menu'][$i];
                $v_menu_id       = $row_menu['PK_MENU'];
                $v_internal_order= $row_menu['C_INTERNAL_ORDER'];
                $v_level_index   = strlen($v_internal_order) / 3 - 1;
                $v_url           = $row_menu['C_URL'];
                $v_name          = $row_menu['C_NAME'];
                $v_menu_type     = $row_menu['C_MENU_TYPE'];
                $v_title         = $v_name;

                $v_current_class = '';

                if($v_menu_type === 'link')
                {
                    $v_reques_uri    = $_SERVER['REQUEST_URI'];
                    if($v_url == $v_reques_uri)
                    {
                        $v_current_class = ' active';
                    }
                }
                elseif($v_menu_type === 'category')
                {
                    $v_cat_id = get_xml_value(simplexml_load_string($row_menu['C_VALUE']), "//item[@data='1' and @type='category']/id");
                    if (isset($_GET['category_id']) == TRUE && $_GET['category_id'] == $v_cat_id) {
                        $v_current_class = ' active';
                        if ($v_level_index == 0) {
                            $v_selected_menu = $v_current_index;
                        }
                    }
                }
                elseif($v_menu_type === 'article')
                {
                    $v_art_id = get_xml_value(simplexml_load_string($row_menu['C_VALUE']), "//item[@data='1' and @type='article']/article_id");
                    if (isset($_GET['article_id']) == TRUE && $_GET['article_id'] == $v_art_id) 
                    {
                        $v_current_class = ' active';                                            
                    }
                }
                elseif($v_menu_type === 'module')
                {
                    $v_current_menu = $row_menu['C_MODULE_CURRENT'];
                    if(isset($this->active_menu_top) && $this->active_menu_top === $v_current_menu)
                    {
                        $v_current_class = ' active';   
                    }                                        
                }

                if (isset($arr_all_menu['widget_menu'][$i - 1]['C_INTERNAL_ORDER'])) {
                    $v_internal_order_pre = $arr_all_menu['widget_menu'][$i - 1]['C_INTERNAL_ORDER'];
                } else {
                    $v_internal_order_pre = '000';
                }

                if ($v_level_index == 0) {
                    $v_current_index++;
                }
                $v_level_pre = strlen($v_internal_order_pre) / 3 - 1;
                ?>
                <?php if ($v_level_pre == $v_level_index && $i != 0): ?>
                    </li>
                <?php elseif ($v_level_pre < $v_level_index): ?>
                    <ul>
                    <?php
                elseif ($v_level_pre > $v_level_index):
                    echo "</li>";
                    for ($n = 0; $n < ($v_level_pre - $v_level_index); $n++) {
                        echo "</ul>";
                        echo "</li>";
                    }
                    ?>
                    <?php endif; ?>                           
                        <li class="menu-<?php echo $v_menu_id ?> <?php echo $v_current_class; ?>">
                        <a href="<?php echo $v_url; ?>" title="<?php echo $v_title; ?>">
                            <span class="nowrap" ><?php echo $v_name; ?></span>
                        </a>

                <?php endfor; ?>
            </ul>
    </div>
</div>

