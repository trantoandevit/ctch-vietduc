<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');} ?>
<?php
//display header
$this->_page_title = __('poll detail');

$v_poll_id         = isset($arr_single_poll['PK_POLL'])?$arr_single_poll['PK_POLL']:'';  
$v_poll_name       = isset($arr_single_poll['C_NAME'])?$arr_single_poll['C_NAME']:'';
$v_poll_slug       = isset($arr_single_poll['C_SLUG'])?$arr_single_poll['C_SLUG']:'';
$v_poll_status     = isset($arr_single_poll['C_STATUS'])?$arr_single_poll['C_STATUS']:'';

$v_begin_date_time  = isset($arr_single_poll['C_BEGIN_DATE'])?$arr_single_poll['C_BEGIN_DATE']:'';
$arr_begin_date_time= explode(' ', $v_begin_date_time);
$v_begin_date       = isset($arr_begin_date_time[0])?$arr_begin_date_time[0]:'';
$v_begin_time       = isset($arr_begin_date_time[1])?$arr_begin_date_time[1]:date("H:i:s");

$v_begin_end_time   = isset($arr_single_poll['C_END_DATE'])?$arr_single_poll['C_END_DATE']:'';
$arr_end_date_time  = explode(' ', $v_begin_end_time);
$v_end_date         = isset($arr_end_date_time[0])?$arr_end_date_time[0]:'';
$v_end_time         = isset($arr_end_date_time[1])?$arr_end_date_time[1]:date("H:i:s");

?>

<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id',$v_poll_id);
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_poll');
    echo $this->hidden('hdn_dsp_all_method','dsp_all_poll');
    echo $this->hidden('hdn_update_method','update_poll');
    echo $this->hidden('hdn_delete_method','delete_poll');
    echo $this->hidden('XmlData','');
    
    echo $this->hidden('hdn_item_id_list_old','');
    echo $this->hidden('hdn_item_id_list_new','');
    echo $this->hidden('hdn_id_delete_answer_list','');
    //Luu dieu kien loc
    ?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo __('poll detail'); ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /Toolbar -->
    <div class="form-group">
        <div class="col-sm-12">
            <label class="col-sm-2 control-label" style="padding-right: 30px;"><?php echo __('question');?></label>
            <div class="col-sm-10">
                <input type="textbox" name="txt_poll_name" id="txt_poll_name" value="<?php echo $v_poll_name;?>" 
                            data-allownull="no" data-validate="text" 
                            data-name="<?php echo __('question')?>" 
                            data-xml="no" data-doc="no" 
                            autofocus="autofocus" class="form-control"
                            size="70"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('answer');?></label>
        <div class="col-sm-10">
            <div name="div_poll_answer" class="form-group" id="div_poll_answer">
                <?php
                foreach ($arr_all_answer as $row_answer):
                    $v_answer_id = $row_answer['PK_POLL_DETAIL'];
                    $v_poll_answer = $row_answer['C_ANSWER'];
                    $v_vote = $row_answer['C_VOTE'];
                    ?>
                <div class="row" id="row_<?php echo $v_answer_id; ?>">
                        <div class="checkbox">
                            <label class="col-sm-1 control-label">
                                <input type="checkbox" name="chk_old" id="chk_old" value="<?php echo $v_answer_id; ?>" data-poll_answer="<?php echo $v_poll_answer; ?>"/>
                            </label>
                            <div class="col-sm-9">
                                <input type="textbox" class="form-control" name="txt_poll_answer[]" id="txt_poll_answer" value ="<?php echo $v_poll_answer; ?>" size="50"/>
                            </div>
                            <label class="col-sm-2 control-label" style="text-align: left;">
                                <?php echo $v_vote; ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="button-area">
                <button type="button" name="btn_add_article" id="btn_add_article" style="margin-right: 10px;" class="btn btn-outline btn-primary" onclick="btn_add_answer_onclick();">
                    <i class="fa fa-plus"></i> <?php echo __('add answer'); ?>
                </button>
                <button type="button" name="btn_delete_article" id="btn_delete_article" class="btn btn-outline btn-danger" onclick="btn_delete_answer_onclick();">
                    <i class="fa fa-times"></i> <?php echo __('delete'); ?>
                </button>
            </div>
        </div>
    </div>
    <div class="form-group">
            <div class ="col-sm-12">
                    <label class='col-sm-2 control-label'><?php echo __('begin date'); ?></label>
                <div class="col-sm-4">
                    <div class="input-group date" id="bg_date" style="width: 100%; display: block;">
                        <input type='text' name="txt_begin_date" value="<?php echo $v_begin_date; ?>" id="txt_begin_date" class="form-control"
                               data-allownull="no" data-validate="date" 
                               data-name="<?php echo __('begin date') ?>" 
                               data-xml="no" data-doc="no" style="width: 85%;"
                               autofocus="autofocus" />
                        <span class="input-group-addon" style="width: 15%; height: 34px;">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>     
                    </div>                                     
                    <!--img src="</*?php echo $this->image_directory . "calendar.png"; ?>" onclick="DoCal('txt_begin_date')"-->
                </div>
                    <label class='col-sm-2 control-label'><?php echo __('begin time');?></label>
                <div class="col-sm-4">
                    <input type="textbox" name="txt_begin_time" id="txt_begin_time" class="form-control" value="<?php echo $v_begin_time; ?>"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class ="col-sm-12">   
                    <label class='col-sm-2 control-label'><?php echo __('end date'); ?></label>
                <div class="col-sm-4" style="float: left">
                        <div class='input-group date' id="ed_date" style="width: 100%; display: block;">
                            <input type='text' name="txt_end_date" value="<?php echo $v_end_date; ?>" id="txt_end_date" class="form-control"
                                   data-allownull="no" data-validate="date" style="width: 85%;"
                                   data-name="<?php echo __('end date') ?>" 
                                   data-xml="no" data-doc="no" 
                                   autofocus="autofocus" />
                            <span class="input-group-addon" style="width: 15%; height: 34px;">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                </div>
                    <label class='col-sm-2 control-label'><?php echo __('end time');?></label>
                <div class="col-sm-4">
                    <input type="textbox" class="form-control" name="txt_end_time" id="txt_end_time" value="<?php echo $v_end_time; ?>"/>
                </div>
                <br>
                <label style="color: red;display: none" id="error-date"><?php echo __('end date not smaller start date'); ?></label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-2 control-label"><?php echo __('status'); ?></label>
                <div class="col-sm-10">
                    <select name="poll_status" id="poll_status" class="form-control">
                        <option value="0"><?php echo __('display none') ?></option>
                        <option value="1" <?php echo ($v_poll_status == 1) ? 'selected' : ''; ?>><?php echo __('display') ?></option>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <label class="required" id="message_err"></label>
        <br>
        <div class="button-area">
            <button type="button" name="btn_update" id="btn_update" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="btn_accept_onclick();">
                <i class="fa fa-check"></i> <?php echo __('update');?>
            </button>
            <button type="button" name="btn_back" id="btn_cancel" class="btn btn-outline btn-warning" onclick="btn_back_onclick();">
                <i class="fa fa-reply"></i> <?php echo __('go back'); ?>
            </button>
        </div>
</form>
<script>
    $(document).ready(function(){      
        $('#bg_date').datetimepicker({
                format: 'D/M/YYYY' 
                //HH:mm:ss
        });
        $('#ed_date').datetimepicker({
                format: 'D/M/YYYY'
                //HH:ss
        });
    });
var arr_answer_delete = new Array();
function btn_add_answer_onclick()
{
   var html='';
   html+='<div class="row" id="row_new">';
   html+='<div class="checkbox">';
   html+='<label class="col-sm-1 control-label"><input type="checkbox" name="chk_new" id="chk_new"/></label>';
   html+='<div class="col-sm-9"><input class="form-control" type="textbox" name="txt_poll_answer_new" id="txt_poll_answer" value ="" size="50"/></div><label class="col-sm-2 control-label" style="text-align:left;">0</label></div></div>';
   $('#div_poll_answer').append(html);
}
function btn_delete_answer_onclick()
{
   
    $('#div_poll_answer input[type="checkbox"]').each(function(index){
      if($(this).is(':checked'))
      {
          if($(this).attr('id')=='chk_old')
          {
              arr_answer_delete.push($(this).val());
          }
          $(this).parent().remove();
      }
    });
    $('#hdn_id_delete_answer_list').val(arr_answer_delete.join());
}
function btn_accept_onclick()
{
    var arr_answer_old = new Array();
    var arr_answer_new = new Array();
    
    var begin_date      = $('#txt_begin_date').val();
    var end_date        = $('#txt_end_date').val();
//        var current_date    = getdate();
    if(paresDate_getTime(begin_date) > paresDate_getTime(end_date))
    {
        $('#error-date').show();
        return;
    }
    else
    {
        $('#error-date').hide();
    }
     $('#div_poll_answer input[name="chk_old"]').each(function(index){
         v_answer_id   = $(this).val();
         arr_answer_old.push(v_answer_id);
     });
     $('#hdn_item_id_list_old').val(arr_answer_old.join());
     
    $('#div_poll_answer input[name="txt_poll_answer_new"]').each(function(index){
        v_answer_id   = $(this).val();
        arr_answer_new.push(v_answer_id);
    });
    $('#hdn_item_id_list_new').val(arr_answer_new.join());
    btn_update_onclick();
}

    function paresDate_getTime(str) 
    {
        date = str.split('-');
        return new Date(date[2],date[1],date[0]).getTime();
    }
</script>