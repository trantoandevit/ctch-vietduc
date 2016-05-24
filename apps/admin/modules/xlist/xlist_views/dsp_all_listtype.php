<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php
//header
$this->_page_title = __('listtype manager');
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('listtype manager');?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST"><?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id','0');
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_listtype');
    echo $this->hidden('hdn_dsp_all_method','dsp_all_listtype');
    echo $this->hidden('hdn_update_method','update_listtype');
    echo $this->hidden('hdn_delete_method','delete_listtype');

    //Luu dieu kien loc
    $v_filter 			= isset($_POST['txt_filter']) ?($_POST['txt_filter']) : '';
    ?>
    <!-- filter -->
    <div id="div_filter" class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('filter by listtype name') ?></label>
        <div class="col-sm-10 input-group" style="width: 50%">
            <input type="text" name="txt_filter"
                   value="<?php echo $v_filter; ?>" 
                   class="form-control" size="30" autofocus="autofocus"
                   onkeypress="txt_filter_onkeypress(this.form.btn_filter,event);"
                   />
            <span class="input-group-btn">
                <button class="btn btn-default" name="btn_filter" onclick="btn_filter_onclick();" type="button">
                    <i class="fa fa-search"></i> <?php echo __('filter'); ?>
                </button>
            </span>
        </div>
    </div>
	<!-- /filter -->
    <?php
    //==========================================================================
    $arr_all_listtype = $VIEW_DATA['arr_all_listtype'];
    $this->load_xml('xml_listtype.xml');
    echo $this->render_form_display_all($arr_all_listtype);

    //Phan trang
    $v_rows_per_page = isset($_POST['sel_rows_per_page']) ? replace_bad_char($_POST['sel_rows_per_page']) : _CONST_DEFAULT_ROWS_PER_PAGE;
    if (isset($arr_all_listtype[1]['TOTAL_RECORD'])){
        $v_page = isset($_POST['sel_goto_page']) ? replace_bad_char($_POST['sel_goto_page']) : 1;
        $v_total_record = $arr_all_listtype[1]['TOTAL_RECORD'];
    } else {
        $v_page = 1;
        $v_total_record = $v_rows_per_page;
    }
    echo $this->paging($v_page, $v_rows_per_page, $v_total_record);
    ?>
        <div class="button-area">
            <button type="button" name="btn_addnew" id="btn_addnew" style="margin-right: 10px;" class="btn btn-outline btn-primary" onclick="btn_addnew_onclick();">
                <i class="fa fa-plus"></i> <?php echo __('add new'); ?>
            </button>
            <button type="button" name="btn_delete" id="btn_delete" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();">
                <i class="fa fa-times"></i> <?php echo __('delete'); ?>
            </button>
        </div>
</form>