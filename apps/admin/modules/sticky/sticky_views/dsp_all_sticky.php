<?php
defined('DS') or die('no direct access');
?>

<form name="frm_filter_<?php echo $v_default ?>" id="frm_filter_<?php echo $v_default ?>" action="" method="post">
    <?php if ($v_default == 0): ?>
        <select name="sel_category" class="form-control"style="width:30%;" id="sel_category" onChange="sel_category_onchange();">
            <?php if (!empty($arr_all_category)): ?>
                <?php foreach ($arr_all_category as $item): ?>
                    <?php
                    $v_level  = strlen($item['C_INTERNAL_ORDER']) / 3 - 1;
                    $v_indent = '';
                    for ($i = 0; $i < $v_level; $i++)
                    {
                        $v_indent .= ' -- ';
                    }
                    ?>
                    <option value="<?php echo $item['PK_CATEGORY'] ?>">
                        <?php echo $v_indent . $item['C_NAME'] ?>
                    </option>
                <?php endforeach; ?>
                <script>
                    $('#sel_category').val(<?php echo get_post_var('sel_category', $arr_all_category[0]['PK_CATEGORY']); ?>);
                </script>
            <?php endif; ?>
        </select>
    <?php endif; ?>
</form>
<div class="button-area">
    <button type="button" class="btn btn-outline btn-primary" onClick="add_sticky();"><i class="fa fa-plus"></i> <?php echo __('add new');?></button>
        
    <button type="button" class="btn btn-outline btn-danger" onClick="delete_sticky();" style="margin-left:10px;"><i class="fa fa-times"></i> <?php echo __('delete');?></button>
    
        <?php if (get_system_config_value(CFGKEY_CACHE) == 'true'): ?>
    <button type="button" class="btn btn-outline btn-success" onClick="html_cache_onclick();" style="margin-left:10px;">
        <i class="fa fa-save"></i> <?php echo __('save cache') ?>
    </button>
        <?php endif; ?>
</div>

<form name="frmMain_<?php echo $v_default; ?>" id="frmMain_<?php echo $v_default; ?>" action="" method="post">
    <?php echo hidden('hdn_current_tab',0);?>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
        <colgroup>
            <col width="10%">
            <col width="75%">
            <col width="15%">
        </colgroup>
        <tr>
            <th><input type="checkbox" name="chk_check_all" id="chk-all"/></th>
            <th><?php echo __('title') ?></th>
            <th><?php echo __('order') ?></th>
        </tr>
        <?php $n = count($arr_all_sticky); ?>
        <?php if ($n == 0): ?>
            <tr>
                <td colspan="3" class="Center">
                    <b><?php echo __('there are no record') ?></b>
                </td>
            </tr>
        <?php endif; ?>
        <?php for ($i = 0; $i < $n; $i++): ?>
            <?php
            $item    = $arr_all_sticky[$i];
            $prev_id = isset($arr_all_sticky[$i - 1]) ? $arr_all_sticky[$i - 1]['PK_STICKY'] : '';
            $next_id = isset($arr_all_sticky[$i + 1]) ? $arr_all_sticky[$i + 1]['PK_STICKY'] : '';
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
            <center>
                <input 
                    type="checkbox" name="chk[]" class="chk-item" 
                    value="<?php echo $item['PK_STICKY'] ?>" id="item_<?php echo $item['PK_STICKY'] ?>"
                    />
            </center>
            </td>
            <td>
                <label class="<?php echo $v_class ?>" for="item_<?php echo $item['PK_STICKY'] ?>">
                    <?php echo $item['C_TITLE']; ?>
                </label>
            </td>
            <td class="Center">
            <center>
                    <?php if($prev_id):  ?>
                        <a href="javascript:void(0);" onclick="swap_order(<?php echo $item['PK_STICKY'] ?>, <?php echo $prev_id ?>)">
                            <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                        </a>
                    <?php endif; ?>
                    <?php if($next_id):?>
                        <a href="javascript:void(0);" onclick="swap_order(<?php echo $item['PK_STICKY'] ?>, <?php echo $next_id ?>)">
                            <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                        </a>
                    <?php endif;?>
            </center>
            </td>
            </tr>
        <?php endfor; ?>
        <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
        <?php for ($i; $i < $n; $i++): ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endfor; ?>
    </table>
        </div>
    </div>
</form>
<div class="button-area">
    <button type="button" class="btn btn-outline btn-primary" onClick="add_sticky();">
        <i class="fa fa-plus"></i> <?php echo __('add new');?>
    </button>
        
    <button type="button" class="btn btn-outline btn-danger" onClick="delete_sticky();" style="margin-left:10px;">
        <i class="fa fa-times"></i> <?php echo __('delete');?>
    </button>
    
        <?php if (get_system_config_value(CFGKEY_CACHE) == 'true'): ?>
    <button type="button" class="btn btn-outline btn-success" onClick="html_cache_onclick();" style="margin-left:10px;">
        <i class="fa fa-save"></i> <?php echo __('save cache') ?>
    </button>
        <?php endif; ?>
</div>
<script>
    toggle_checkbox('#chk-all', '.chk-item');
    
    function sel_category_onchange()
    {
        $.ajax({
            type: 'post',
            url: $('#controller').val() + 'dsp_all_sticky/0',
            data: $('#frm_filter_<?php echo $v_default ?>').serialize(),
            success:function(obj){
                $('#frm_filter_<?php echo $v_default ?>').parent().html(obj);
            }
        });
        
    }

    function add_sticky()
    {
        var $default = "<?php echo $v_default; ?>";
        var $svc_url = "<?php echo $this->get_controller_url('article', 'admin') ?>dsp_all_article_svc";
        if($default == 0)
        {
            $svc_url += '&disable_website=1&disable_category=1';
            $svc_url += '&hdn_category=' + $('#sel_category').val();
        }
        $svc_url += '&status=3';
        showPopWin($svc_url, 800, 600, function(json){
            if(json)
            {
                $.ajax({
                    type: 'post',
                    url: $('#controller').val() + $('#hdn_insert_method').val(),
                    data: {
                        'default': $default,
                        'article': json
                    },
                    success: function(json){
                        reload_ajax();
                    }
                });
            }
        });
    }
    
    function delete_sticky()
    {
        if(!confirm("<?php echo __('are you sure to delete all selected object?') ?>"))
        {
            return;
        }
        $.ajax({
            type: 'post',
            url: $('#controller').val() + $('#hdn_delete_method').val(),
            data: $('#frmMain_<?php echo $v_default ?>').serialize(),
            success: function(json){
                reload_ajax();
            }
        });
    }
    
    function swap_order($item1, $item2)
    {
        var data = {item1: $item1, item2: $item2};
        var data_filter = {sel_category: ''};
        if(get_current_tab_index() == '1')
        {
            data_filter.sel_category = $('#sel_category').val();
        }
        
        $.ajax({
            type: 'post',
            url: $('#controller').val() + 'swap_sticky_order',
            data: data,
            success: function(){
                reload_ajax(data_filter);
            }
        });
    }
    
    function reload_ajax(data)
    {
        reload_current_tab(data);
    }
    
    function html_cache_onclick()
    {
        url='<?php echo $this->get_controller_url(); ?>create_cache';
        $('#frmMain_<?php echo $v_default; ?>').attr('action',url);
        $('#frmMain_<?php echo $v_default; ?>').submit();
    }
    
</script>