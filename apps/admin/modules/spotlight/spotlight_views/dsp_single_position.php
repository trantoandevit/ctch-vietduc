<?php
defined('DS') or die('no direct access');
$v_pos_name = isset($arr_single_position['C_NAME']) ? $arr_single_position['C_NAME'] : '';
$v_pos_id   = isset($arr_single_position['PK_SPOTLIGHT_POSITION']) ? $arr_single_position['PK_SPOTLIGHT_POSITION'] : '';
?>
<?php

function show_button()
{
    $html = '';
    $html .= '<div class="button-area">';
    
    $html .= '<button type="button" class="btn btn-primary btn-outline" onClick="btn_add_onclick();"><i class="fa fa-plus"></i> ' . __('add new') . '</button>';
            
    $html .= '<button type="button" class="btn btn-danger btn-outline" onClick="btn_delete_onclick();" style="margin-left:10px;"><i class="fa fa-times"></i> ' . __('delete') . '</button>';
            
    $html .= '</div>';
   
    echo $html;
}
?>
    <div class="row" style="margin-top: 20px;">
        <label class="col-lg-1" for="txt_name" style="padding-top:5px;"><?php echo __('name') ?><span class="required">(*)</span></label>
        <div class="form-group col-lg-5">
            <input class="form-control" type="text" name="txt_name" id="txt_name"     
                   data-allownull="no" data-validate="text"
                   data-name="<?php echo __('name'); ?>" 
                   value="<?php echo $v_pos_name ?>"
                   data-xml="no" data-doc="no"/>
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-success btn-outline" onClick="frmMain_on_submit();"><i class="fa fa-check"></i> <?php echo __('apply'); ?></button>
            <button type="button" class="btn btn-danger btn-outline" style="margin-left:10px;" onClick="$('span[data-id=<?php echo $v_pos_id ?>]').click();"><i class="fa fa-times"></i> <?php echo __('delete position'); ?></button>
        <?php if (get_system_config_value(CFGKEY_CACHE) == 'true'): ?>
            <button type="button" class="btn btn-outline btn-success"  style="margin-left:10px;" onClick="btn_cache_onclick(<?php echo $v_pos_id ?>)"><i class="fa fa-save"></i> <?php echo __('save cache') ?></button>
        <?php endif; ?>
        </div>
    </div>
        
    <hr></hr>

        <?php show_button(); ?>
        <div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
                <colgroup>
                    <col width="10%">
                    <col width="70%">
                    <col width="20%">
                </colgroup>
                <tr>
                    <th><input type="checkbox" id="chk_all"/></th>
                    <th><?php echo __('title') ?></th>
                    <th><?php echo __('order') ?></th>
                </tr>
                <?php $n = count($arr_all_spotlight) ?>
                <?php for ($i = 0; $i < $n; $i++): ?>
                    <?php
                    $item    = $arr_all_spotlight[$i];
                    $v_id    = $item['PK_SPOTLIGHT'];
                    $v_title = $item['C_TITLE'];
                    $v_prev  = isset($arr_all_spotlight[$i - 1]) ? $arr_all_spotlight[$i - 1]['PK_SPOTLIGHT'] : 0;
                    $v_next  = isset($arr_all_spotlight[$i + 1]) ? $arr_all_spotlight[$i + 1]['PK_SPOTLIGHT'] : 0;
                    $v_class = '';
                    if (
                            $item['C_STATUS'] < 3
                            OR $item['CK_BEGIN_DATE'] < 0
                            OR $item['CK_END_DATE'] < 0
                            OR $item['C_CAT_STATUS'] == 0
                    )
                    {
                        $v_class = 'line-through';
                    }
                    ?>
                    <tr>
                        <td class="Center">
                            <input 
                                type="checkbox" name="chk_item[]" class="chk_item"
                                value="<?php echo $v_id ?>"
                                id="item_<?php echo $i ?>"
                                />
                        </td>
                        <td>
                            <label class="<?php echo $v_class ?>" for="item_<?php echo $i ?>"><?php echo $v_title ?></label>
                        </td>
                        <td class="Center">
                                <?php if ($v_prev): ?>
                                    <a href="javascript:void(0)" onClick="swap_order(<?php echo $v_id ?>,<?php echo $v_prev ?>)">
                                        <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($v_next): ?>
                                    <a href="javascript:void(0)" onClick="swap_order(<?php echo $v_id ?>,<?php echo $v_next ?>)">
                                        <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                                    </a>
                                <?php endif; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
                <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
                <?php for ($i; $i < $n; $i++): ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
        </div>
        <?php show_button(); ?>
<script>
    toggle_checkbox('#chk_all', '.chk_item');
    function frmMain_on_submit()
    {
        var f = document.frmMain;
        var xObj = new DynamicFormHelper('','',f);
        if (xObj.ValidateForm(f)){
            $.ajax({
                type: 'post',
                url: $('#controller').val() + 'update_position',
                data: $(f).serialize(),
                success: function(){
                    window.location.reload();
                }
            });
        }
        return false;
    }
    
    function btn_add_onclick(){
        $url_svc = "<?php echo $this->get_controller_url('article', 'admin'); ?>" + 'dsp_all_article_svc';
        $url_insert = "<?php echo $this->get_controller_url(); ?>" + 'insert_spotlight';
        showPopWin($url_svc, 800, 600, function(json){
            if(json)
            {
                $.ajax({
                    type: 'post',
                    url: $url_insert,
                    data: {article: json, position: $('#hdn_position_id').val()},
                    success: function(){
                        reload_current_tab();
                    }
                });
            }
        });
    }
    
    function swap_order($item1, $item2)
    {
        $url = "<?php echo $this->get_controller_url() ?>" + "swap_spotlight_order";
        $.ajax({
            type: 'post',
            url: $url,
            data: {item1: $item1, item2: $item2},
            success: function (){reload_current_tab();}
        });
    }
    
    window.btn_delete_onclick = function(){
        $url = "<?php echo $this->get_controller_url() ?>" + "delete_spotlight";
        if($('.chk_item:checked').length == 0)
        {
            alert("<?php echo __('you must choose atleast one object') ?>");
            return;
        }
        if(!confirm("<?php echo __('are you sure to delete all selected object?') ?>"))
        {
            return;
        }
        $.ajax({
            type: 'post',
            url: $url,
            data: $('#frmMain').serialize(),
            success: function(){reload_current_tab();}
        });
    }
    
    function btn_cache_onclick($pos_id){
        $url = '<?php echo $this->get_controller_url() ?>cache/' + $pos_id;
        window.location.href = $url;
    }
</script>
