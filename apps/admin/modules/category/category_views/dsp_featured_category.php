<?php
defined('SERVER_ROOT') or die('no direct access');
?>
<?php

function show_insert_delete_button()
{
    $html = '<div class="button-area">';
    $html .= '<button type="button" class="btn btn-outline btn-primary" onClick="dsp_modal();"><i class="fa fa-plus"></i> ' . __('add new') . '</button>';
    
    $html .= '<button type="button" class="btn btn-outline btn-danger" onClick="delete_multi_category();" style="margin-left:10px;"><i class="fa fa-times"></i> ' . __('delete') . '</button>';
    
    if (get_system_config_value(CFGKEY_CACHE) == 'true')
    {
        $html .= '<button type="button" class="btn btn-outline btn-success" onClick="btn_cache_onclick();" style="margin-left:10px;"><i class="fa fa-save"></i> ' . __('save cache') . '</button>';
    }

    $html .= '</div>';

    echo $html;
}
?>
<form name="frmMain" id="frmMain" method="post">
    <?php show_insert_delete_button() ?>
    <?php echo $this->hidden('hdn_controller', $this->get_controller_url()) ?>
    <?php echo $this->hidden('hdn_active_tab', 1); ?>
    <?php echo $this->user_token(); ?>
    <div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <colgroup>
                <col width="10%" />
                <col width="75%" />
                <col width="15%" />
            </colgroup>
            <thead>
                <tr>
                    <th>
                    <input type="checkbox" id="chk-all" name="chk_check_all"/>
                </th>
                <th><?php echo __('category'); ?></th>
                <th><?php echo __('order') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = count($arr_all_featured);
                ?>
                <?php for ($i = 0; $i < $n; $i++): ?>
                    <?php
                    $item = $arr_all_featured[$i];
                    $v_id = $item['PK_HOMEPAGE_CATEGORY'];
                    $v_name = $item['C_NAME'];
                    $v_disable = $item['C_STATUS'] == 0 ? 'line-through' : '';
                    $v_cat_id = $item['PK_CATEGORY'];
                    $v_prev_item = isset($arr_all_featured[$i - 1]) ? $arr_all_featured[$i - 1]['PK_HOMEPAGE_CATEGORY'] : false;
                    $v_next_item = isset($arr_all_featured[$i + 1]) ? $arr_all_featured[$i + 1]['PK_HOMEPAGE_CATEGORY'] : false;
                    $v_website_id = intval(Session::get('session_website_id'));
                    ?>
                    <tr>
                        <td class="Center">
                            <input
                                type="checkbox" name="chk[]" class="chk-item" onclick="if (!this.checked)this.form.chk_check_all.checked = false;"
                                value="<?php echo $v_id; ?>"
                                data-cat-id="<?php echo $v_cat_id ?>"
                                data-website-id="<?php echo $v_website_id ?>"
                                id="item-<?php echo $v_id ?>"
                                />
                        </td>
                        <td>
                            <label class="<?php echo $v_disable ?>" for="item-<?php echo $v_id ?>"><?php echo $v_name; ?></label>
                        </td>
                        <td class="Center">

                            <?php if ($v_prev_item): ?>
                                <a href="#" onClick="swap_order(<?php echo $v_id ?>,<?php echo $v_prev_item ?>);">
                                    <i class="fa fa-arrow-up" style="font-size:18px;"></i>
                                </a>
                                <?php endif; ?>
                                <?php if ($v_next_item): ?>
                                <a href="#" onClick="swap_order(<?php echo $v_id ?>,<?php echo $v_next_item ?>);">
                                    <i class="fa fa-arrow-down" style="font-size:18px;"></i>
                                </a>
                                <?php endif; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
    
    <?php show_insert_delete_button() ?>
</form>
<script>
    toggle_checkbox('#chk-all', '.chk-item');
    
    function dsp_modal()
    {
        var url = "<?php echo $this->get_controller_url() ?>dsp_all_category_svc/" 
            + <?php echo intval(Session::get('session_website_id')) ?>;
        
        var v_inserted = '0';
        
        $('.chk-item').each(function(){
            v_inserted += ', ' + $(this).attr('data-cat-id');
        });
        window.showPopWin(url, 800, 600, function(obj){
            if(obj.length == 0)
                return;
            $.ajax({
                type: 'post',
                url: '<?php echo $this->get_controller_url() ?>insert_featured_category/',
                data: {
                    'category': obj
                    , 'website-id': <?php echo $website_id; ?>
                    , 'inserted-category': v_inserted
                    , 'goback': "<?php echo $this->get_controller_url() . 'dsp_all_featured/' ?>"
                },
                success: function(){
                    reload_current_tab();
                }
            });
        });
    }
    
    function delete_multi_category()
    {
        if($('.chk-item:checked').length == 0)
        {
            alert("<?php echo __('you must choose atleast one object') ?>");
            return;
        }
        
        if(! confirm("<?php echo __('are you sure to delete all selected object?') ?>"))
        {
            return;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo $this->get_controller_url() . 'delete_featured_category/'; ?>',
            data: $('#frmMain').serialize(),
            success: function(){
                reload_current_tab();
            }
        });
    }
    
    function swap_order($item1, $item2)
    {
        $.ajax({
            type: 'post',
            url: '<?php echo $this->get_controller_url() . 'swap_featured_order/' ?>',
            data: {'item1': $item1, 'item2': $item2},
            success: function()
            {
                reload_current_tab();
            }
        });
    }
</script>