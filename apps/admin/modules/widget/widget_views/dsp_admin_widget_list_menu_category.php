<?php
defined('DS') or die('no direct access');
?>
<label>
    <input <?php echo (isset($title_list_menu_category) && $title_list_menu_category == 1) ? ' checked ' : ''?>  type="checkbox" name="chk_show_title" id="chk_show_title" > Hiển thị tiêu đề
</label>

<label>
    <?php echo __('title') ?></br>
    <input type="text" name="txt_list_menu_category" style="width: 100%;" value="<?php echo isset($title) ? $title : ''; ?>"/>
</label>
<label>
    <?php echo __('Chọn menu hiển thị') ?></br>
    <select name="menu_display" style="width:100%;">
        <option><?php echo __('select position') ?></option>
        <?php foreach ($arr_all_position as $v_menu):?>
        <option value="<?php echo $v_menu['PK_MENU_POSITION']?>" <?php echo ($menu_display == $v_menu['PK_MENU_POSITION']) ? 'selected':''?> >
            <?php echo $v_menu['C_NAME']?>
        </option>
        <?php endforeach;?>
    </select>
</label>    