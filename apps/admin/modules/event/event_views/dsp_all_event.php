<?php if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
} ?>
<?php
//header
//@session::init();
$this->_page_title = __('event manager');
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('event manager'); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', 0);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_event');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_event');
    echo $this->hidden('hdn_update_method', 'update_event');
    echo $this->hidden('hdn_delete_method', 'delete_event');
    echo $this->hidden('hdn_item_id_swap', 0);
    ?>
    <div class="form-group">
    <div class="col-sm-12">
        <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-5">
                <label class="col-sm-3 control-label"><?php echo __('type'); ?></label>
                <div class="col-sm-9">
                    <select name="type_event" id="type_event" onchange="type_event_onchange()" class="form-control">
                        <option value=""><?php echo '----- ' . __('type') . ' -----'; ?></option>
                        <option value="0" <?php echo ($arr_search['type_event'] == '0') ? 'selected' : ''; ?>><?php echo __('event'); ?></option>
                        <option value="1" <?php echo ($arr_search['type_event'] == '1') ? 'selected' : ''; ?>><?php echo __('report'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <label class="col-sm-3 control-label"><?php echo __('file name'); ?></label>
                <div class="col-sm-9 input-group">
                    <input type="textbox" class="form-control" name="txt_search" id="txt_search" value="<?php echo $arr_search['txt_search']; ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" onclick="btn_submit_onclick()" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                </div>
    </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <colgroup>
                    <col width="5%" />
                    <col width="45%" />
                    <col width="15%" />
                    <col width="15%" />
                    <col width="10%" />
                </colgroup>
                <thead>
                    <tr>
                        <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                        <th><?php echo __('event name'); ?></th>
                        <th><?php echo __('total record'); ?></th>
                        <th><?php echo __('status'); ?></th>
                        <th><?php echo __('order1'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = 0;
                    $i = 0
                    ?>
                    <?php
                    for ($i = 0; $i < count($arr_all_event); $i++):
                        $v_event_id = $arr_all_event[$i]['PK_EVENT'];
                        $v_name = $arr_all_event[$i]['C_NAME'];
                        $v_total_article = $arr_all_event[$i]['C_TOTAL_ARTICLE'];
                        $v_status = $arr_all_event[$i]['C_STATUS'];
                        $next = isset($arr_all_event[$i + 1]['PK_EVENT']) ? $arr_all_event[$i + 1]['PK_EVENT'] : false;
                        $prev = isset($arr_all_event[$i - 1]['PK_EVENT']) ? $arr_all_event[$i - 1]['PK_EVENT'] : false;
                        ?>
                        <tr>
                            <td class="Center">
                                <input type="checkbox" name="chk" 
                                       value="<?php echo $v_event_id; ?>" 
                                       onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                                       />
                            </td>
                            <td>
                                <a href="javascript:void(0)" onclick="row_onclick(<?php echo $v_event_id; ?>)"><?php echo $v_name; ?></a>
                            </td>
                            <td><center><?php echo $v_total_article; ?></center></td>
                <td><center><?php echo ($v_status == 1) ? __('Hiển thị') : __('Không hiển thị'); ?></center></td>
                <td>
                <center>
                    <?php if ($i == 0): ?>
                        <a href="javascript:void(0)" onclick="swap_order_event(<?php echo $v_event_id ?>,<?php echo $next; ?>)">
                            <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                        </a>
                    <?php elseif ($i == count($arr_all_event) - 1): ?>
                        <a href="javascript:void(0)" onclick="swap_order_event(<?php echo $v_event_id ?>,<?php echo $prev; ?>)">
                            <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                        </a>
                    <?php else: ?>
                        <a href="javascript:void(0)" onclick="swap_order_event(<?php echo $v_event_id ?>,<?php echo $next; ?>)">
                            <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                        </a>
                    
                        <a href="javascript:void(0)" onclick="swap_order_event(<?php echo $v_event_id ?>,<?php echo $prev; ?>)">
                            <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                        </a>
                    <?php endif; ?>
                </center>
                </td>    
                </tr>
                    <?php
                    $row = ($row == 1) ? 0 : 1;
                    ?>
                            <?php endfor; ?>
                            <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
                            <?php for ($i; $i < $n; $i++): ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
        <?php echo $this->paging2($arr_all_event); ?>
    <div class="button-area">
        <button type="button" name="addnew" class="btn btn-outline btn-primary" style="margin-right: 10px;" onclick="btn_addnew_onclick();">
            <i class="fa fa-plus"></i> <?php echo __('add new'); ?>
        </button>
        <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();">
            <i class="fa fa-times" ></i> <?php echo __('delete'); ?>
        </button>

    <?php if (get_system_config_value(CFGKEY_CACHE) == 'true'): ?>
        <button type="button" name="trash" class="btn btn-outline btn-success" onClick="save_cache_onclick();" style="margin-left:10px;">
            <i class="fa fa-save"></i> <?php echo __('save cache html'); ?>
        </button>
    <?php endif; ?>
    </div>

</form>
<script type="text/javascript">
    function swap_order_event(id,swap_id)
    {
        $('#hdn_item_id').attr('value',id);
        $('#hdn_item_id_swap').attr('value',swap_id);
        var str = "<?php echo $this->get_controller_url() . "swap_order" ?>";
        $('#frmMain').attr('action',str);
        $('#frmMain').submit();
    }
    function btn_submit_onclick()
    {
        $('#frmMain').attr('action','<?php echo $this->get_controller_url() . "dsp_all_event" ?>');
        $('#frmMain').submit();
    }
    function type_event_onchange()
    {
        btn_submit_onclick();
    }
    function save_cache_onclick()
    {
        url = '<?php echo $this->get_controller_url(); ?>create_cache';
        $('#frmMain').attr('action',url);
        $('#frmMain').submit();
    }
</script>