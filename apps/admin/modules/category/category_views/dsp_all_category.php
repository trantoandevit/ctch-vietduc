<?php
defined('SERVER_ROOT') or die('No direct script');

function show_insert_delete_button()
{
    $html = '<div class="button-area">';
    
        $html .= '<button type="button" class="btn btn-outline btn-primary" onClick="dsp_single_category(0);"><i class="fa fa-plus"></i> ' . __('add new') . '</button>';
   
        $html .= '<button type="button" class="btn btn-outline btn-danger" onClick="delete_multi_category();" style="margin-left:10px;"><i class="fa fa-times"></i> ' . __('delete') . '</button>';
   
    if (get_system_config_value(CFGKEY_CACHE) == 'true')
    {
        $html .= '<button type="button" class="btn btn-outline btn-success" onClick="btn_cache_onclick();" style="margin-left:10px;"><i class="fa fa-save"></i> ' . __('save cache') . '</button>';
    }
    $html .= '</div>';

    echo $html;
}
?>
<?php show_insert_delete_button(); ?>
<!-- /.panel-heading -->
<form name="frmMain" id="frmMain" method="post">
    <?php echo $this->hidden('hdn_controller', $this->get_controller_url()) ?>
    <?php echo $this->hidden('hdn_active_tab', 0); ?>
    <?php echo $this->user_token(); ?>
<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <colgroup>
                <col width="10%" />
                <col width="60%" />
                <col width="15%" />
                <col width="15%" />
            </colgroup>
            <thead>
                <tr>
                    <th><input type="checkbox" id="chk-all" name="chk_check_all"/></th>
                    <th><?php echo __('category'); ?></th>
                    <th><?php echo __('order'); ?></th>
                    <th><?php echo __('status'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $n = count($arr_all_category); ?>
            <?php for ($i = 0; $i < $n; $i++): ?>
                <?php
                $item             = $arr_all_category[$i];
                $v_category_id    = $item['PK_CATEGORY'];
                $v_name           = $item['C_NAME'];
                $v_status         = $item['C_STATUS'];
                $v_order          = $item['C_ORDER'];
                $v_internal_order = $item['C_INTERNAL_ORDER'];
                $v_parent         = $item['FK_PARENT'];
                $v_indent         = strlen($item['C_INTERNAL_ORDER']) / 3 - 1;
                $v_indent_text    = '';
                $v_disable        = ($item['C_COUNT_CHILD_CAT'] > 0) ? 'disabled' : '';
                $v_disable        = ($item['C_COUNT_CHILD_ART'] > 0 ) ? 'disabled' : $v_disable;
                $line_throught    = $v_status == 0 ? 'line-through' : '';

                for ($j = 0; $j < $v_indent; $j++)
                {
                    $v_indent_text .= ' -- ';
                }

                $v_next_item = $v_category_id;
                $v_prev_item = $v_category_id;

                $j = $i - 1;
                while (isset($arr_all_category[$j]))
                {
                    if ($arr_all_category[$j]['FK_PARENT'] == $v_parent)
                    {
                        $v_prev_item = $arr_all_category[$j]['PK_CATEGORY'];
                        break;
                    }
                    else
                    {
                        $j--;
                    }
                }

                $j = $i + 1;
                while (isset($arr_all_category[$j]))
                {
                    if ($arr_all_category[$j]['FK_PARENT'] == $v_parent)
                    {
                        $v_next_item = $arr_all_category[$j]['PK_CATEGORY'];
                        break;
                    }
                    else
                    {
                        $j++;
                    }
                }
                ?>
                <tr>
                    <td class="Center">
                        <input 
                            type="checkbox" class="chk-item" name="chk[]" onclick="if (!this.checked)this.form.chk_check_all.checked = false;"
                            value="<?php echo $v_category_id; ?>" <?php echo $v_disable ?>
                            />
                    </td>
                    <td 
                        class="<?php echo $line_throught ?>"
                        style="cursor:pointer;"
                       
                            onClick="dsp_single_category(<?php echo $v_category_id; ?>);"
                      
                        >
                            <?php echo $v_indent_text . $v_name; ?>
                    </td>
                            <td class="Center">

                            <?php if ($v_prev_item != $v_category_id): ?>
                                <a href="#" onClick="swap_order(<?php echo $v_prev_item ?>,<?php echo $v_category_id; ?>);">
                                    <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                                </a>

                            <?php endif; ?>
                            <?php if ($v_next_item != $v_category_id): ?>
                                <a href="#" onClick="swap_order(<?php echo $v_next_item ?>,<?php echo $v_category_id; ?>);">
                                    <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                                </a>
                                <?php endif; ?>

                        </td>
                    <td class="Center">
                        <?php echo $v_status ? __('active status') : __('inactive status'); ?>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>
    <?php show_insert_delete_button(); ?>
</form>

<script>
    $(document).ready(function(){
        toggle_checkbox('#chk-all', '.chk-item');        
        var has_edit_right = 1;
    });
    function swap_order(p_item1, p_item2)
    {
        $.ajax({
            type: 'post',
            url: '<?php echo $this->get_controller_url() . 'swap_category_order'; ?>',
            data: {item1: p_item1, item2: p_item2},
            success: function(){ 
                reload_current_tab();
            }
        });
    };
    
    function dsp_single_category(id)
    {
        window.location = "<?php echo $this->get_controller_url() . 'dsp_single_category/' ?>" + id;
    }
    

    function delete_multi_category()
    {
        if($('.chk-item:checked').length == 0)
        {
            alert("<?php echo __('you must choose atleast one object') ?>");
            return;
        }
        
        if(confirm('<?php echo __('are you sure to delete all selected object?') ?>'))
        {
            var url = "<?php echo $this->get_controller_url() . 'delete_category' ?>";
            $.ajax({
                type: 'post',
                url: url,
                data: $('#frmMain').serialize(),
                success: function(respond){
                    reload_current_tab();
                }
            });
        }
    }

</script>