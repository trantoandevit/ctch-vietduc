<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php

//header
//$this->template->title = __('internet record');
//$this->template->display('dsp_header.php');
$this->_page_title = __('internet record');
$v_record_type_id = get_post_var('hdn_record_type_id','');
$v_member_id = get_post_var('sel_member','');
//don vi thanh vien
$arr_all_village  =  $arr_all_member['arr_all_village'];
$arr_all_district =  $arr_all_member['arr_all_district'];

?>
<!--<script src="<?php echo SITE_ROOT?>public/js/jquery/jquery.slimscroll.min.js"></script>-->
<form name="frmMain" id="frmMain" action="#" method="POST" class="form-horizontal">
    <?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id','0');
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_record');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_record');
    echo $this->hidden('hdn_delete_method', 'do_delete_record');
    
    echo $this->hidden('hdn_record_type_id', $v_record_type_id);
    ?>
<h1 class="page-header" style="font-size: 32px;"><?php echo __('internet record');?></h1>

<div class="panel panel-primary">
    <div class="panel-heading">
        <?php echo __('record Statistics')?> 
    </div>
    <div class="panel-body">
        <ul>
            <?php
            foreach ($arr_all_notice as $arr_notice):
                $record_type_id = $arr_notice['FK_RECORD_TYPE'];
                $count = $arr_notice['C_COUNT'];
                $record_type_name = $arr_notice['C_RECORD_TYPE_NAME'];
                ?>
                <li>
                    <a href="javascript:void(0)" onclick="record_type_filter('<?php echo $record_type_id ?>')">
                        - <?php echo $record_type_name ?> (có <?php echo $count ?> hồ sơ)
                    </a>
                </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <!--div class="panel-footer">
        Panel Footer
    </div-->
</div>


<div class="row" style="margin: 20px 0px 20px 0px;">
    <div class="col-lg-12">        
    <!--filter ma loai hs-->
    <div class="col-lg-1">
       <label>Mã loại hồ sơ:</label> 
    </div>
    <div class="col-lg-2">
        <input type="textbox" id="txt_record_type_code" name="txt_record_type_code" class="form-control"
           size="10" style="text-transform: uppercase;" onkeypress="txt_record_type_code_onkeypress(event);" />
    </div>
    
    <div class="col-lg-5">
    <select class="form-control" id="sel_record_type" name="sel_record_type" onchange="sel_record_type_onchange(this)">
        <option value=''>-- <?php echo __('select record type');?> --</option>
        <?php foreach ($arr_all_notice as $arr_notice):
            $record_type_id = $arr_notice['FK_RECORD_TYPE'];
            $count = $arr_notice['C_COUNT'];
            $record_type_name = $arr_notice['C_RECORD_TYPE_NAME'];
            $record_type_code = $arr_notice['C_RECORD_TYPE_CODE'];
            $selected = ($v_record_type_id == $record_type_id) ? 'selected' : '';
            ?>
            <option <?php echo $selected; ?> data-code="<?php echo $record_type_code ?>" value="<?php echo $record_type_id ?>"><?php echo $record_type_name ?></option>
        <?php endforeach; ?>
    </select>
    </div>
    
    
    <!--filter don vi tiep nhan-->
    <div class="col-lg-1" style="padding-top: 5px;">
        <label><?php echo __('units')?>:</label>
    </div>
    
    <div class="col-lg-3">
        <select class="form-control" name="sel_member" onchange="btn_filter_onclick()">
            <option value=''>-- <?php echo __('receiving unit records')?> --</option>
            <?php
            foreach ($arr_all_district as $arr_district):
                $v_name = $arr_district['C_NAME'];
                $v_id = $arr_district['PK_MEMBER'];
                $v_selected = ($v_id == $v_member_id) ? 'selected' : '';
                ?>
                <option <?php echo $v_selected ?> value="<?php echo $v_id ?>"><?php echo $v_name; ?></option>
                <?php
                foreach ($arr_all_village as $key => $arr_village):
                    $v_village_name = $arr_village['C_NAME'];
                    $v_village_id = $arr_village['PK_MEMBER'];
                    $v_parent_id = $arr_village['FK_MEMBER'];
                    if ($v_parent_id != $v_id) {
                        continue;
                    }
                    $v_selected = ($v_village_id == $v_member_id) ? 'selected' : '';
                    ?>
                    <option <?php echo $v_selected ?> value="<?php echo $v_village_id ?>">----- <?php echo $v_village_name; ?></option>
                    <?php
                    unset($arr_all_village[$key]);
                endforeach;
                ?>
<?php endforeach; ?>
        </select>
    </div>
    

    </div>
</div>  
    <!--danh sach-->
    
        <?php
        $xml_file = strtolower('xml_internet_record_list.xml');
        if ($this->load_xml($xml_file)) {
            echo $this->render_form_display_all($arr_all_record);
        }
        ?>

        <!--pagging-->
    <div class="row">
        <!--div id="dyntable_length" class="dataTables_length"-->
            <?php
            $v_total_rows = isset($arr_all_record[0]['C_TOTAL_ROWS']) ? $arr_all_record[0]['C_TOTAL_ROWS'] : 0;
            $v_rows_per_page = get_post_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE);
            $v_current_page = get_post_var('sel_goto_page', 1);
            echo $this->paging($v_current_page, $v_rows_per_page, $v_total_rows);
            ?>
        <!--/div-->   
    </div>    

    <!--button--> 
    <div class="button-area">
        <button  name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();"><i class="fa fa-times fa-fw"></i> <?php echo __('delete');?></button>
    </div>
</form>

<script>
     $(document).ready(function(){
       var record_type_code = $('#sel_record_type option:selected').attr('data-code');
       $('#txt_record_type_code').val(record_type_code);
    });
    function record_type_filter(record_type_id)
    {
        $('select[name="sel_goto_page"]').val(1);
        $('#hdn_record_type_id').val(record_type_id);
        btn_filter_onclick();
    }
    
    function sel_record_type_onchange(v_sel_record_type)
    {
        record_type_filter($(v_sel_record_type).val());
    }
    
    function txt_record_type_code_onkeypress(evt)
    {
        if (IE()){
            theKey=window.event.keyCode
        } else {
            theKey=evt.which;
        }

        if(theKey == 13){
            var v_record_type_code = trim($("#txt_record_type_code").val()).toUpperCase();
            if(v_record_type_code != '')
            {
                $("#sel_record_type option").each(function(){
                    if($(this).attr('data-code') == v_record_type_code)
                    {
                        record_type_filter($(this).val());
                    }
                });
            }
        }
        return false;
    }
</script>
<?php //$this->template->display('dsp_footer.php');