<?php
defined('DS') or die('no direct access');
$this->_page_title = __('report staff');
$controller = $this->get_controller_url();

$arr_all_village  =  $arr_all_member['arr_all_village'];
$arr_all_district =  $arr_all_member['arr_all_district'];

$v_district    = get_request_var('district',0);
$v_begin_date  = get_request_var('txt_begin_date',date('d/m/Y'));
$v_end_date    = get_request_var('txt_end_date',date('d/m/Y'));

?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo __('report single evaluation') ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php 
        echo $this->hidden('controller', $this->get_controller_url());
        echo $this->hidden('hdn_dsp_all_method', '');
        echo $this->hidden('hdn_method_print', 'print_evaluation_single');
    ?>
<div class="" id="filter">
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('unit') ?>:</label>
        <div class="col-sm-10">
            <select id="sel_district" name="sel_district" style="width: 100%" class="form-control">
                <option value="0">--     <?php echo __('unit') ?>      --</option>
                <?php 
                    foreach($arr_all_district as $arr_district)
                    {
                        $v_name = $arr_district['C_NAME'];
                        $v_id   = $arr_district['PK_MEMBER'];
                        $v_checked ='';
                        $v_checked = ($v_id == $v_member_id)?' selected':'';
                        echo "<option $v_checked value='$v_id'>$v_name</option>";
                         foreach($arr_all_village as $key => $arr_village)
                         {
                            $v_village_name = $arr_village['C_NAME'];
                            $v_village_id   = $arr_village['PK_MEMBER'];
                            $v_parent_id    = $arr_village['FK_MEMBER'];
                            if($v_parent_id != $v_id)
                            {
                                continue;
                            }
                            $v_checked = ($v_village_id == $v_member_id)?' selected':'';

                            echo "<option $v_checked value='$v_village_id'> ----- $v_village_name</option>";
                         }
                    }
                    ?>
            </select>
        </div>
    </div>
    <!--End chon don vi-->

    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('begin time to search') ?>:</label>
        <div class="col-sm-5">
            <div class="input-group date" id="txt_bg_date" style="width: 100%; display: block;">
                <input type='text' name="txt_begin_date" value="<?php echo $v_begin_date; ?>" id="txt_begin_date" class="form-control"
                       data-allownull="no" data-validate="date" maxlength="255"
                       data-name="<?php echo __('begin date') ?>" style="width:90%"
                       data-xml="no" data-doc="no" placeholder="<?php echo __('begin date') ?>"
                       autofocus="autofocus" />
                <span class="input-group-addon" style="width: 10%; height: 34px;">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>     
            </div>
        </div>
        <div class="col-sm-5">
            <div class="input-group date" id="txt_ed_date" style="width: 100%; display: block;">
                <input type='text' name="txt_end_date" value="<?php echo $v_end_date; ?>" id="txt_end_date" class="form-control"
                       data-allownull="no" data-validate="date" maxlength="255"
                       data-name="<?php echo __('end date'); ?>" 
                       data-xml="no" data-doc="no" placeholder="<?php echo __('end date') ?>" style="width:90%"
                       autofocus="autofocus" />
                <span class="input-group-addon" style="width: 10%; height: 34px;">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>     
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>
        <div class="col-sm-10">
            <div class="btn-filter">
                <button type="button" name="btn_print" id="btn_print" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="print_member();">
                    <i class="fa fa-check"></i> <?php echo __('report print'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
</form>
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
    function print_member() 
    {
        var f = document.frmMain;
            var xObj = new DynamicFormHelper('','',f);
            if (xObj.ValidateForm(f))
            {
               
                var sel_begin_date = $('#txt_begin_date').val() || 0;
                var sel_end_date   = $('#txt_end_date').val() || 0;
                var sel_district   = $('#sel_district').val() || 0;

                var params = '&district='+ sel_district +  '&txt_begin_date=' + sel_begin_date  + '&txt_end_date=' +sel_end_date;

                var url = $('#controller').val() + $('#hdn_method_print').val() + '?' + params;
                showPopWin(url, 800, 600);
          }
    }
    
    
    
</script>