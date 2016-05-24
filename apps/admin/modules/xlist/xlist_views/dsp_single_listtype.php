<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');} ?>
<?php
//display header
$this->_page_title = __('update listtype');
?>
<?php
$arr_single_listtype = $VIEW_DATA['arr_single_listtype'];
if (sizeof($arr_single_listtype) > 2) {
    $v_listtype_id = $arr_single_listtype['PK_LISTTYPE'];
    $v_listtype_code = $arr_single_listtype['C_CODE'];
    $v_listtype_name = $arr_single_listtype['C_NAME'];
    $v_owner_code_list = $arr_single_listtype['C_OWNER_CODE_LIST'];
    $v_xml_file_name = $arr_single_listtype['C_XML_FILE_NAME'];
    $v_order = $arr_single_listtype['C_ORDER'];
    $v_status = $arr_single_listtype['C_STATUS'];
} else {
    $v_listtype_id = 0;
    $v_listtype_code = '';
    $v_listtype_name = '';
    $v_owner_code_list = '';
    $v_xml_file_name = '';
    $v_order = $arr_single_listtype['C_ORDER'] + 1;
    $v_status = 1;
}
?>
<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal"><?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_listtype');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_listtype');
    echo $this->hidden('hdn_update_method', 'update_listtype');
    echo $this->hidden('hdn_delete_method', 'delete_listtype');

    echo $this->hidden('hdn_item_id', $v_listtype_id);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('XmlData', '');

    //Luu dieu kien loc
    $v_filter = isset($_POST['txt_filter']) ? replace_bad_char($_POST['txt_filter']) : '';
    $v_page = isset($_POST['sel_goto_page']) ? replace_bad_char($_POST['sel_goto_page']) : 1;
    $v_rows_per_page = isset($_POST['sel_rows_per_page']) ? replace_bad_char($_POST['sel_rows_per_page']) : _CONST_DEFAULT_ROWS_PER_PAGE;
    echo $this->hidden('txt_filter', $v_filter);
    echo $this->hidden('sel_goto_page', $v_page);
    echo $this->hidden('sel_rows_per_page', $v_rows_per_page);
    ?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12" style="font-size: 32px;">
            <h1 class="page-header"><?php echo __('update listtype'); ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /Toolbar -->

    <!-- Update Form -->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('listtype code'); ?> <span class="required">(*)</span></label>
        <div class="col-sm-10">
            <input type="text" name="txt_code" value="<?php echo $v_listtype_code; ?>" id="txt_code"
                   class="form-control" maxlength="255" style="width:60%"
                   onKeyDown="return handleEnter(this, event);"
                   data-allownull="no" data-validate="text"
                   data-name="<?php echo __('listtype code'); ?>"
                   data-xml="no" data-doc="no"
                   onblur="check_code()" autofocus="autofocus"
                   />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('listtype name'); ?> <span class="required">(*)</span></label>
        <div class="col-sm-10">
            <input type="text" name="txt_name" value="<?php echo $v_listtype_name; ?>" id="txt_name"
                   class="form-control" style="width:60%"
                   onKeyDown="return handleEnter(this, event);"
                   data-allownull="no" data-validate="text"
                   data-name="<?php echo __('listtype name'); ?>"
                   data-xml="no" data-doc="no"
                   onblur="check_name()"

                   />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('order'); ?> <span class="required">(*)</span></label>
        <div class="col-sm-10">
            <input type="text" name="txt_order" value="<?php echo $v_order; ?>" id="txt_order"
                   class="form-control" size="4" maxlength="3" style="width:60%"
                   onKeyDown="return handleEnter(this, event);"
                   data-allownull="no" data-validate="unsignNumber"
                   data-name="<?php echo __('order'); ?>"
                   data-xml="no" data-doc="no"
                   />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">File XML</label>
        <div class="col-sm-10">
            <div class="input-group" style="width: 60%">
                <input type="text" name="txt_xml_file_name" id="txt_xml_file_name"
                       value="<?php echo $v_xml_file_name; ?>" class="form-control" size="255"
                       onKeyDown="return handleEnter(this, event);"
                       data-allownull="yes" data-validate="text"
                       data-name="" data-xml="no" data-doc="no" 
                       readonly="readonly" />
                <span class="input-group-btn">
                    <button class="btn btn-default" name="btn_upload" onclick="btn_select_listype_xml_file_onclick();" type="button">
                        <i class="fa fa-search"></i> <?php echo __('select'); ?>
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('status'); ?></label>
        <div class="col-sm-10">
            <div class="input-group" style="width: 60%">
                <input type="checkbox" name="chk_status" value="1"
                <?php echo ($v_status > 0) ? ' checked' : ''; ?>
                   id="chk_status"
                   /><label for="chk_status"><?php echo __('active status'); ?></label><br/>
            <input type="checkbox" name="chk_save_and_addnew" value="1"
                <?php echo ($v_listtype_id > 0) ? '' : ' checked'; ?>
                   id="chk_save_and_addnew"
                   /><label for="chk_save_and_addnew"><?php echo __('save and add new'); ?></label>
            </div>
        </div>
    </div>

    <div class="button-area">
        <button type="button" name="btn_update" class="btn btn-outline btn-success" style="margin-right: 10px;" onclick="btn_update_onclick()">
            <i class="fa fa-check"></i> <?php echo __('update'); ?>
        </button>
        <button type="button" name="btn_cancel" class="btn btn-outline btn-warning" onclick="btn_back_onclick();">
            <i class="fa fa-reply" ></i> <?php echo __('go back'); ?>
        </button>
    </div>
</form>
<script type="text/javascript">
    var f=document.frmMain;
    listtype_id = $("#hdn_item_id").val();

    function check_code(){
        if (f.txt_code.value != ''){
            var v_url = f.controller.value + 'check_existing_listtype_code/' + f.txt_code.value + _CONST_LIST_DELIM + listtype_id;
            $.getJSON(v_url, function(json) {
                if (json.COUNT > 0){
                    show_error('txt_code','Mã loại danh mục đã tồn tai!');
                } else {
                    clear_error('txt_code');
                }
            });
        }
    }

    function check_name(){
        if (f.txt_name.value != ''){
            var v_url = f.controller.value + 'check_existing_listtype_name/' + f.txt_name.value + _CONST_LIST_DELIM + listtype_id;
            $.getJSON(v_url, function(json) {
                if (json.COUNT > 0){
                    show_error('txt_name','Tên loại danh mục đã tồn tai!');
                } else {
                    clear_error('txt_name');
                }
            });
        }
    }
</script>