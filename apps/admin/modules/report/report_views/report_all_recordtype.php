<?php
defined('DS') or die('no direct access');
$this->_page_title = __('report recordtype');
$controller = $this->get_controller_url();

$arr_all_village  =  $arr_all_member['arr_all_village'];
$arr_all_district =  $arr_all_member['arr_all_district'];

$arr_all_record_list_type = isset($arr_all_record_list_type) ? $arr_all_record_list_type : array();
$arr_all_record_type      = isset($arr_all_record_type) ? $arr_all_record_type : array();

$v_year     = get_post_var('sel_year',date('Y'));
$v_month    = get_post_var('sel_month',date('m'));
$v_quarter  = get_post_var('sel_quarter',1);
$v_member_id=  get_post_var('sel_district',0);

?>
<!--<style>
    .right-Col label,.right-Col label input
    {
        cursor: pointer;
        padding: 5px;
    }
</style>-->
<!--</style>-->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px"><?php echo __('report recordtype') ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php 
        echo $this->hidden('controller', $this->get_controller_url());
        echo $this->hidden('hdn_dsp_all_method', '');
        echo $this->hidden('hdn_method_print', 'print_all_recordtype');
    ?>
<div class="" id="filter">
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('unit') ?>:</label>
        <div class="col-sm-10">
            <select id="sel_district" name="sel_district" style="width: 50%" class="form-control">
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
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('Kỳ báo cáo') ?>:</label>
        <div class="col-sm-10">
            <label class="radio-inline">
                <input value="month" type="radio" checked="true" id="rd_month" name="rd_date" onclick="rd_onclick_date(this)" /><?php echo __('month') ?>
            </label>
            <label class="radio-inline">
                <input value="quarter" type="radio" id="rd_quarter" name="rd_date" onclick="rd_onclick_date(this)" /><?php echo __('quarter') ?>
            </label>
            <label class="radio-inline">
                <input value="year" type="radio" id="rd_year" name="rd_date" onclick="rd_onclick_date(this)" /><?php echo __('year') ?>
        </label>
        </div>
    </div>
    <div id="wrp-filder-date">
        <div  style="display: block">
            <div class="form-group" > 
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <div id="div-rd_month" class="col-sm-6">
                        <label class="col-sm-2 control-label"><?php echo __('month'); ?>:</label>
                        <div class="col-sm-10">
                            <select name="sel_month" id="sel_month" style="width: 100%" class="form-control">
                                <?php
                                    for($i =1;$i<=12;$i ++)
                                    {
                                        $v_selected = ($i == $v_month) ? 'selected' : '';
                                        echo "<option $v_selected value='$i'>".__('month')." $i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="div-rd_quarter" class="col-sm-6" style="display: none" >
                        <label class="col-sm-2 control-label"><?php echo __('quarter'); ?>:</label>
                        <div class="col-sm-10">
                            <select name="sel_quarter" id="sel_quarter" class="form-control">
                                <?php
                                for ($i = 1; $i <= 4; $i ++) {
                                    $v_selected = ($i == $v_year) ? 'selected' : '';
                                    echo "<option $v_selected value='$i'>" . __('quarter') . " $i</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="div-sel_year" class="col-sm-6">
                        <label class="col-sm-2 control-label"><?php echo __('year'); ?>:</label>
                        <div class="col-sm-10">
                            <select name="sel_year" id="sel_year" class="form-control">
                                <?php
                                if (sizeof($arr_year) > 0) {
                                    for ($i = 0; $i < count($arr_year); $i ++) {
                                        $v_selected = ($v_year == $arr_year[$i]['C_YEAR']) ? 'selected' : '';

                                        echo "<option $v_selected value='" . $arr_year[$i]['C_YEAR'] . "'>" . $arr_year[$i]['C_YEAR'] . "</option>";
                                    }
                                } else {
                                    echo "<option  value='$v_year'> $v_year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End ky-->

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
</div>
</form>
<script>
    
    //<![CDATA[
    
    /**
     * Thay doi dieu kien loc in bao cao
     */
    $(document).ready(function(){
       $('#sel_record_type').chained('#sel_record_list_type') ;
    });
    /**
     * Thay doi dieu kien loc in bao cao
     */
    
    function rd_onclick_date(anchor) 
    {
        var select_id = $(anchor).attr('id') || '';
        if(select_id.trim() == 'rd_month')
        {
            $('#div-rd_quarter').hide();
            $('#div-rd_month').show();
        }
        else if(select_id.trim() == 'rd_year')
        {
            $('#div-rd_month').hide();
            $('#div-rd_quarter').hide();
        }
        else if(select_id.trim() == 'rd_quarter')
        {
            $('#div-rd_month').hide();
            $('#div-rd_quarter').show();
        }
             
    }
    
    function print_member() 
    {
        var f = document.frmMain; 
        var sel_year     = $('#sel_year').val() || 0;
        var sel_month    = $('#sel_month').val() || 0;
        var sel_district = $('#sel_district').val() || 0;
        var sel_quarter  = $('#sel_quarter').val() || 0;
        
        var sel_rd_date  = $('input[name="rd_date"]:checked').val() || '';
        
        var params = '';
        if(sel_rd_date == 'year')
        {
            params += '&district='+ sel_district + '&year=' +sel_year;
        }
        else if(sel_rd_date == 'month')
        {
            params += '&district='+ sel_district +  '&month=' + sel_month  + '&year=' +sel_year;
        }
        else if(sel_rd_date == 'quarter')
        {
            params += '&district='+ sel_district +  '&quarter=' + sel_quarter  + '&year=' +sel_year;
        }   
        else
        {
            return false;
        }
        
       
        var url = $('#controller').val() + $('#hdn_method_print').val() + '?' + params;
        showPopWin(url, 800, 600);
    }
    
//    ]]>
    
</script>
