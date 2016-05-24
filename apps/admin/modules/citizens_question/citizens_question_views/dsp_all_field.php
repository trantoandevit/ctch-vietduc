<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-heading">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <i class="fa fa-search"></i> <?php echo __('advanced search') ?>
        </a>

    </div>
    <div id="collapseOne" class="panel-collapse collapse <?php echo $show_box_search; ?>">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('time to search'); ?></label>
                <div class="col-sm-5">
                    <div class="input-group date" id="txt_bg_date">
                        <input type='textbox' name="txt_begin_time" value="<?php echo empty($arr_search['txt_begin_time']) ? '' : $arr_search['txt_begin_time']; ?>" 
                               id="txt_begin_time" class="form-control"
                               data-allownull="no" data-validate="date" maxlength="255"
                               data-name="<?php echo __('begin date') ?>" 
                               data-xml="no" data-doc="no" placeholder="<?php echo __('begin time to search'); ?>"
                               autofocus="autofocus" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>     
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="input-group date" id="txt_ed_date">
                        <input type='textbox' name="txt_end_time" value="<?php echo empty($arr_search['txt_end_time']) ? '' : $arr_search['txt_end_time']; ?>" 
                               id="txt_end_time" class="form-control"
                               data-allownull="no" data-validate="date" maxlength="255"
                               data-name="<?php echo __('end date'); ?>" style="width:100%"
                               data-xml="no" data-doc="no" placeholder="<?php echo __('end time to search'); ?>"
                               autofocus="autofocus" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>     
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('field'); ?></label>
                <div class="col-sm-10">
                    <select id="select_field" name="select_field" class="form-control">
                        <option value="0" <?php echo ($arr_search['select_field'] == '0') ? 'selected' : ''; ?>>
                            <?php echo '----' . __('select field') . '----' ?>
                        </option>
                        <?php foreach ($arr_all_field as $field): ?>
                            <?php if ($field['C_STATUS'] == 1): ?>
                                <option value="<?php echo $field['PK_FIELD']; ?>" <?php echo ($arr_search['select_field'] == $field['PK_FIELD']) ? 'selected' : ''; ?>>
                                    <?php echo $field['C_NAME']; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('key words'); ?></label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" name="txt_advanced_search" id="txt_advanced_search" 
                               value="<?php echo $arr_search['txt_advanced_search'] ?>" 
                               class="form-control" maxlength="255" 
                               data-allownull="yes" data-validate="text" data-name="<?php echo __('keywords'); ?>" 
                               data-xml="no" data-doc="no" 
                               />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="btn_search_onclick('question')">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
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
            <tr>
                <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this, this.form.chk);"/></th>
                <th><?php echo __('title'); ?></th>
                <th><?php echo __('sender'); ?></th>
                <th><?php echo __('status'); ?></th>
                <th><?php echo __('order'); ?></th>
            </tr>
            <?php
            $row = 0;
            $i = 0
            ?>
            <?php
            for ($i = 0; $i < count($arr_all_question); $i++):
                $v_question_id = $arr_all_question[$i]['PK_CQ'];
                $v_title = $arr_all_question[$i]['C_TITLE'];
                $v_name = $arr_all_question[$i]['C_NAME'];
                $v_status = $arr_all_question[$i]['C_STATUS'];
                $next = isset($arr_all_question[$i + 1]['PK_CQ']) ? $arr_all_question[$i + 1]['PK_CQ'] : false;
                $prev = isset($arr_all_question[$i - 1]['PK_CQ']) ? $arr_all_question[$i - 1]['PK_CQ'] : false;
                ?>

                <tr>
                    <td class="Center">
                        <input type="checkbox" name="chk"
                               value="<?php echo $v_question_id; ?>" 
                               onclick="if (!this.checked)
                                           this.form.chk_check_all.checked = false;" 
                               />
                    </td>
                    <td>
                        <a href="javascript:void(0)" onclick="row_cq_onclick('question',<?php echo $v_question_id; ?>)" class="<?php echo ($v_status == 0) ? 'line_fail' : '' ?>">
    <?php echo $v_title; ?>
                        </a>
                    </td>
                    <td><center><?php echo $v_name; ?></center></td>
                <td><center><?php echo ($v_status == 1) ? __('approved') : __('not approved'); ?></center></td>
                <td>
                    <?php if (count($arr_all_question) != 1): ?>
                    <center>
        <?php if ($i == 0): ?>
                            <a href="javascript:void(0)" onclick="swap_order('question',<?php echo $v_question_id ?>,<?php echo $next; ?>);">
                                <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                            </a>
        <?php elseif ($i == count($arr_all_question) - 1): ?>
                            <a href="javascript:void(0)" onclick="swap_order('question',<?php echo $v_question_id ?>,<?php echo $prev; ?>);">
                                <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                            </a>
        <?php else: ?>
                            <a href="javascript:void(0)" onclick="swap_order('question',<?php echo $v_question_id ?>,<?php echo $next; ?>);">
                                <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="swap_order('question',<?php echo $v_question_id ?>,<?php echo $prev; ?>);">
                                <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                            </a>
                    <?php endif; ?>
                    </center>
    <?php endif; ?>
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
        </table>
    </div>
</div>
<?php echo $this->paging2($arr_all_question); ?>
<div class="button-area">
    <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_cq_onclick();">
        <i class="fa fa-times"></i> <?php echo __('delete'); ?>
    </button>
</div>

<script>
    $(document).ready(function(){
        $('#txt_bg_date').datetimepicker({
                format: 'D/M/YYYY' 
                //HH:mm:ss
        });
        $('#txt_ed_date').datetimepicker({
                format: 'D/M/YYYY'
                //HH:ss
        });
    });
    function btn_advanced_search_onclick(button_search)
{
    id='#'+$(button_search).attr('data-target');
    $(id).toggle();
}
function btn_search_onclick(type)
{
    $('#hdn_tab_select').val(type);
    url="<?php echo $this->get_controller_url()?>dsp_all_cq";
    $('#frmMain').attr('action',url);
    $('#frmMain').submit();
}
function swap_order(type,id,id_swap)
{
    $('#hdn_item_id').val(id);
    $('#hdn_item_id_swap').val(id_swap);
    $('#hdn_tab_select').val(type);
    url="<?php echo $this->get_controller_url()?>swap_order/"+type;
    $('#frmMain').attr('action',url);
    $('#frmMain').submit();
}
function btn_delete_cq_onclick(type)
{
    method="delete_"+type;
    $('#hdn_delete_method').val(method);
    btn_delete_onclick();
}
function row_cq_onclick(type,id)
{
    if(type=='question')
    {
        $('#hdn_dsp_single_method').val('dsp_single_question');
        row_onclick(id);
    }
    else if(type=='field')
    {
        $('#hdn_dsp_single_method').val('dsp_single_field');
        row_onclick(id);
    }
}
function btn_addnew_field_onclick()
{
     $('#hdn_dsp_single_method').val('dsp_single_field');
     btn_addnew_onclick();
}
</script>