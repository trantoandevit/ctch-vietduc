<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');} ?>
<?php
//display header
$this->_page_title = __('citizens question manager');
$tab_select ='#tab_'. $tab_select;
?>

<form id="frmMain" name="frmMain" action="" method="POST" class="form-horizontal">
<?php echo $this->hidden('controller',$this->get_controller_url());?>
<?php echo $this->hidden('hdn_item_id', '');?>
<?php echo $this->hidden('hdn_item_id_list','');?>
<?php echo $this->hidden('hdn_item_id_swap', '');?>
<?php echo $this->hidden('hdn_delete_method', '');?>
<?php echo $this->hidden('hdn_dsp_single_method', '');?>
<?php echo $this->hidden('hdn_tab_select', $tab_select);?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="font-size: 32px;"><?php echo __('citizens question manager'); ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /Toolbar -->
    <div class="panel-body" id="tabs_cq">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="tab_list_cq">
            <li class="active"><a href="#tab_question" data-toggle="tab"><?php echo __('manager question'); ?></a>
            </li>
            <li><a href="#tab_field" data-toggle="tab"><?php echo __('manager field'); ?></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" style="margin-top: 20px;">
            <div class="tab-pane fade in active" id="tab_question">
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
                                        <input type='textbox' name="txt_begin_time" value="<?php echo empty($arr_search['txt_begin_time'])?'':$arr_search['txt_begin_time'];?>" 
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
                                        <input type='textbox' name="txt_end_time" value="<?php echo empty($arr_search['txt_end_time'])?'':$arr_search['txt_end_time'];?>" 
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
                                               value="<?php echo $arr_search['txt_advanced_search']?>" 
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
                                <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
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
                                               onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
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
                            <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_cq_onclick('question');">
                                <i class="fa fa-times"></i> <?php echo __('delete'); ?>
                            </button>
                        </div>
            </div>
            <div class="tab-pane fade" id="tab_field">
                <div class="panel panel-default" style="margin-top: 20px;">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#field_advanced_search">
                            <i class="fa fa-search"></i> <?php echo __('advanced search') ?>
                        </a>

                    </div>
                    <div id="field_advanced_search" class="panel-collapse collapse <?php echo $show_box_search; ?>">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo __('time to search'); ?></label>
                                <div class="col-sm-5">
                                    <div class="input-group date" id="txt_field_begin_time">
                                        <input type='textbox' name="txt_field_begin_time" value="<?php echo $arr_search_field['txt_field_begin_time']?>" 
                                               id="txt_field_begin_time" class="form-control"
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
                                    <div class="input-group date" id="txt_field_end_time">
                                        <input type='textbox' name="txt_field_end_time" value="<?php echo $arr_search_field['txt_field_end_time']?>" 
                                               id="txt_field_end_time" class="form-control"
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
                                    <select id="select_status" name="select_status" class="form-control">
                                    <option value="-1">
                                        <?php echo '----'.__('status').'----'?>
                                    </option>
                                    <option value="1" <?php echo ($arr_search_field['select_status']=='1')?'selected':'';?>>
                                        <?php echo __('display')?>
                                    </option>
                                    <option value="0" <?php echo ($arr_search_field['select_status']=='0')?'selected':'';?>>
                                        <?php echo __('display none')?>
                                    </option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo __('key words'); ?></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" name="txt_field_advanced_search" id="txt_field_advanced_search" 
                                               value="<?php echo $arr_search_field['txt_field_advanced_search']?>" 
                                               class="form-control" maxlength="255" 
                                               data-allownull="yes" data-validate="text" data-name="<?php echo __('keywords'); ?>" 
                                               data-xml="no" data-doc="no" 
                                               />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="btn_search_onclick('field')">
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
                                <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                                <th><?php echo __('field name'); ?></th>
                                <th><?php echo __('status'); ?></th>
                                <th><?php echo __('order'); ?></th>
                            </tr>
                            <?php
                            $row = 0;
                            $i = 0
                            ?>
                            <?php
                            for ($i = 0; $i < count($arr_all_field); $i++):
                                $v_field_id = $arr_all_field[$i]['PK_FIELD'];
                                $v_file_name = $arr_all_field[$i]['C_NAME'];
                                $v_field_status = $arr_all_field[$i]['C_STATUS'];
                                $next = isset($arr_all_field[$i + 1]['PK_FIELD']) ? $arr_all_field[$i + 1]['PK_FIELD'] : false;
                                $prev = isset($arr_all_field[$i - 1]['PK_FIELD']) ? $arr_all_field[$i - 1]['PK_FIELD'] : false;
                                $v_count_depend = $arr_all_field[$i]['COUNT_DEPEND'];
                                ?>

                                <tr>
                                    <td class="Center">
                                        <input type="checkbox" name="chk"
                                               value="<?php echo $v_field_id; ?>" 
                                               onclick="if (!this.checked) this.form.chk_check_all.checked=false;"
                                               <?php echo ($v_count_depend>0)?'disabled':'';?>
                                               />
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="row_cq_onclick('field',<?php echo $v_field_id; ?>)" 
                                           class="<?php echo ($v_field_status == 0) ? 'line_fail' : '' ?>">
                                            <?php echo $v_file_name; ?>
                                        </a>
                                    </td>
                                <td><center><?php echo ($v_field_status == 1) ? __('approved') : __('not approved'); ?></center></td>
                                <td>
                                    <?php if (count($arr_all_field) != 1): ?>
                                    <center>
                                        <?php if ($i == 0): ?>
                                            <a href="javascript:void(0)" onclick="swap_order('field',<?php echo $v_field_id ?>,<?php echo $next; ?>)">
                                                <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                                            </a>
                                        <?php elseif ($i == count($arr_all_field) - 1): ?>
                                            <a href="javascript:void(0)" onclick="swap_order('field',<?php echo $v_field_id ?>,<?php echo $prev; ?>)">
                                                <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" onclick="swap_order('field',<?php echo $v_field_id ?>,<?php echo $next; ?>)">
                                                <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="swap_order('field',<?php echo $v_field_id ?>,<?php echo $prev; ?>)">
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
                                </tr>
                            <?php endfor; ?>
                </table>
                    </div>
                </div>
            <div class="button-area">
                <button type="button" style="margin-right: 10px;" class="btn btn-outline btn-primary" onclick="btn_addnew_field_onclick();">
                    <i class="fa fa-plus"></i> <?php echo __('add answer'); ?>
                </button>
                <button type="button" class="btn btn-outline btn-danger" onclick="btn_delete_cq_onclick('field');">
                    <i class="fa fa-times"></i> <?php echo __('delete'); ?>
                </button>
            </div>
            </div>
        </div>
    </div>
</form>
<script>
//    $(document).ready(function(){
//     $('#tabs_cq').tabs();
//    <?php if ($arr_search['boolen_question_search'] == '1'): ?>
//                 $('#div_question_advanced_search').toggle();
//    <?php endif; ?>
//         
//    <?php if ($arr_search_field['boolen_field_search'] == '1'): ?>
//                 $('#div_field_advanced_search').toggle();
//    <?php endif; ?>
//     var tab = $('#hdn_tab_select').val();
//     $('#tabs_cq').tabs('select',tab);
// });
// $(document).ready(function(){
//     
//        var tab = '';
//        var current_position_id = $('#hdn_position_id').val();
//        if(current_position_id == '')
//        {
//            tab = '#tab_list_cq a:first';
//        }
//        else
//        {
//            tab = '#tab_list_cq a';
//        }
//        $(tab).tab('show');
//    });
        //single_position_onclick($(tab));
     
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
    $(document).ready(function(){
        $('#txt_field_begin_time').datetimepicker({
                format: 'D/M/YYYY' 
                //HH:mm:ss
        });
        $('#txt_field_end_time').datetimepicker({
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
    var method="delete_"+type;
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