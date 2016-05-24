<?php
if (!defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
}
?>
<?php
//display header
$this->_page_title = __('update list');
?>
<?php
$arr_single_list = $VIEW_DATA['arr_single_list'];
if (isset($arr_single_list['PK_LIST'])) {
    $v_list_id = $arr_single_list['PK_LIST'];
    $v_list_code = $arr_single_list['C_CODE'];
    $v_list_name = $arr_single_list['C_NAME'];
    $v_order = $arr_single_list['C_ORDER'];
    $v_status = $arr_single_list['C_STATUS'];
    $v_xml_data = $arr_single_list['C_XML_DATA'];
    $v_xml_file_name = $arr_single_list['C_XML_FILE_NAME'];
    $v_listtype_id = $arr_single_list['FK_LISTTYPE'];
} else {
    $v_list_id = 0;
    $v_list_code = '';
    $v_list_name = '';
    $v_order = $arr_single_list['C_ORDER'] + 1;
    $v_status = 1;
    $v_xml_data = '';
    $v_xml_file_name = $arr_single_list['C_XML_FILE_NAME'];
    $v_listtype_id = $arr_single_list['FK_LISTTYPE'];
}

//$v_xml_data = fix_xml_cdata($v_xml_data);


?>
<script src="<?php echo SITE_ROOT; ?>public/tinymce/script/tiny_mce.js"></script>
<form name="frmMain" method="post" id="frmMain" action="" class="form-horizontal"><?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_list');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_list');
    echo $this->hidden('hdn_update_method', 'update_list');
    echo $this->hidden('hdn_delete_method', 'delete_list');

    echo $this->hidden('hdn_item_id', $v_list_id);
    echo $this->hidden('XmlData', $v_xml_data);

    // Luu dieu kien loc
    $v_filter = isset($_POST['txt_filter']) ? $_POST['txt_filter'] : '';
    $v_page = isset($_POST['sel_goto_page']) ? replace_bad_char($_POST['sel_goto_page']) : 1;
    $v_rows_per_page = isset($_POST['sel_rows_per_page']) ? replace_bad_char($_POST['sel_rows_per_page']) : _CONST_DEFAULT_ROWS_PER_PAGE;

    echo $this->hidden('txt_filter', $v_filter);
    echo $this->hidden('sel_listtype_filter', $v_listtype_id);
    echo $this->hidden('sel_goto_page', $v_page);
    echo $this->hidden('sel_rows_per_page', $v_rows_per_page);
    ?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12" style="font-size: 32px;">
            <h1 class="page-header"><?php echo __('update list'); ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /Toolbar -->

    <!-- Cot tuong minh -->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('listtype'); ?></label>
        <div class="col-sm-10">
            <select name="sel_listtype" style="width:50%" disabled="disabled" style="Z-INDEX:-1;" class="form-control">
                <?php echo $this->generate_select_option($VIEW_DATA['arr_all_listtype_option'], $v_listtype_id); ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('list code'); ?> <label class="required">(*)</label></label>
        <div class="col-sm-10">
            <input type="text" name="txt_code" value="<?php echo $v_list_code; ?>" id="txt_code"
                   class="form-control" maxlength="255" style="width:50%"
                   onKeyDown="return handleEnter(this, event);"
                   data-allownull="no" data-validate="text"
                   data-name="<?php echo __('list code'); ?>"
                   data-xml="no" data-doc="no"
                   onblur="check_code()" autofocus="autofocus"
                   />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('list name'); ?> <label class="required">(*)</label></label>
        <div class="col-sm-10">
            <input type="text" name="txt_name" value="<?php echo $v_list_name; ?>" id="txt_name"
                   class="form-control" style="width:50%"
                   data-allownull="no" data-validate="text"
                   data-name="<?php echo __('list name'); ?>"
                   data-xml="no" data-doc="no"
                   onblur="check_name()"
                   />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('order'); ?> <label class="required">(*)</label></label>
        <div class="col-sm-10">
            <input type="text" name="txt_order" value="<?php echo $v_order; ?>" id="txt_order"
                   class="form-control" size="4" maxlength="3" style="width:50%"
                   data-allownull="no" data-validate="unsignNumber"
                   data-name="<?php echo __('order'); ?>"
                   data-xml="no" data-doc="no"
                   />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('status'); ?></label>
        <div class="col-sm-10">
            <input type="checkbox" name="chk_status" value="1"
                <?php echo ($v_status > 0) ? ' checked' : ''; ?>
                   id="chk_status"
                   /><label for="chk_status"><?php echo __('active status'); ?></label><br/>
            <input type="checkbox" name="chk_save_and_addnew" value="1"
                <?php echo ($v_list_id > 0) ? '' : ' checked'; ?>
                   id="chk_save_and_addnew"
                   /><label for="chk_save_and_addnew"><?php echo __('save and add new'); ?></label>
        </div>
    </div>
    <!-- XML data -->
    <?php
    if ($v_xml_file_name != '') {
        $this->load_xml($v_xml_file_name);
        echo $this->render_form_display_single();
    }
    
    ?>
    <!-- Button -->
    <div class="button-area">
        <button type="button" name="update" class="btn btn-outline btn-success" style="margin-right: 10px;" onclick="tinyMCE.triggerSave(); btn_update_onclick();">
            <i class="fa fa-check"></i> <?php echo __('update'); ?>
        </button>
        <button type="button" name="cancel" class="btn btn-outline btn-warning" onclick="btn_back_onclick();">
            <i class="fa fa-reply" ></i> <?php echo __('go back'); ?>
        </button>
    </div>
</form>
<script type="text/javascript">
    var f=document.frmMain;
    listtype_id = $("#sel_listtype_filter").val();
    list_id     = $("#hdn_item_id").val();

    function check_code(){
        if (f.txt_code.value != ''){
            var v_url = f.controller.value + 'check_existing_list_code/' + f.txt_code.value + _CONST_LIST_DELIM + listtype_id + _CONST_LIST_DELIM + list_id;
            $.getJSON(v_url, function(json) {
                if (json.COUNT > 0){
                    show_error('txt_code','Mã đối tượng danh mục đã tồn tai!');
                } else {
                    clear_error('txt_code');
                }
            });
        }
    }

    function check_name(){
        if (f.txt_name.value != ''){
            var v_url = f.controller.value + 'check_existing_list_name/' + f.txt_name.value + _CONST_LIST_DELIM + listtype_id + _CONST_LIST_DELIM + list_id;
            $.getJSON(v_url, function(json) {
                if (json.COUNT > 0){
                    show_error('txt_name','Tên đối tượng danh mục đã tồn tai!');
                } else {
                    clear_error('txt_name');
                }
            });
        }
    }

    $(document).ready(function() {
        //Fill data
        var formHelper = new DynamicFormHelper('','',document.frmMain);
        formHelper.BindXmlData();
    });
</script>

<script>
    $(document).ready(function() {
        if($('textarea[data-editor="true"]').length > 0)
        {
            SITE_ROOT = "<?php echo SITE_ROOT ?>";
            tinyMCE_init();
            $('textarea[data-editor="true"]').each(function(){
                tinyMCE.execCommand('mceAddControl', false, $(this).attr('id'));
            });
        }
    });
</script>