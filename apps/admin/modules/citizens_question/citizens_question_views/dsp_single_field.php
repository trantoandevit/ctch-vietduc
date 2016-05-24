<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');} ?>
<?php
//display header
$this->_page_title = __('citizens question detail');

$v_field_id        = isset($arr_single_field['PK_FIELD'])?$arr_single_field['PK_FIELD']:'';
$v_field_name      = isset($arr_single_field['C_NAME'])?$arr_single_field['C_NAME']:'';
$v_date            = isset($arr_single_field['C_DATE'])?$arr_single_field['C_DATE']:date('d/m/Y'); 
$v_order           = isset($arr_single_field['C_ORDER'])?$arr_single_field['C_ORDER']:$arr_single_field['C_ORDER_MAX']+1; 
$v_status          = isset($arr_single_field['C_STATUS'])?$arr_single_field['C_STATUS']:''; 
?>

<script src="<?php echo SITE_ROOT; ?>public/tinymce/script/tiny_mce.js"></script>

<form id="frmMain" name="frmMain" action="" method="POST" class="form-horizontal">
<?php echo $this->hidden('controller',$this->get_controller_url());
 echo $this->hidden('hdn_item_id', $v_field_id);
 echo $this->hidden('hdn_item_id_list','');
 echo $this->hidden('hdn_item_id_swap', '');
 echo $this->hidden('hdn_delete_method', '');
 echo $this->hidden('hdn_dsp_single_method', '');
 echo $this->hidden('hdn_dsp_all_method', 'dsp_all_cq');
 echo $this->hidden('hdn_update_method', 'update_field');
 echo $this->hidden('hdn_current_order', $v_order);
 echo $this->hidden('hdn_tab_select', 'field');
 echo $this->hidden('XmlData', '');
 ?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo __('field detail'); ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /Toolbar -->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('field name');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_field_name" class="form-control" id="txt_field_name" value="<?php echo $v_field_name?>" size="40">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('order');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_order" class="form-control" id="txt_order" value="<?php echo $v_order?>" size="20">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('init date');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_date" class="form-control" id="txt_date" value="<?php echo $v_date?>" size="30" disabled/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('status');?></label>
        <div class="col-sm-10">
            <input type="checkbox" name="chk_status" id="chk_status" <?php echo ($v_status=='1')?'checked':'';?>/>
            <label for="chk_status" class="control-label"><?php echo __('display');?></label>
        </div>
    </div>
    <div class="button-area">
        <button type="button" name="addnew" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="btn_update_onclick();">
            <i class="fa fa-check"></i> <?php echo __('update'); ?>
        </button>
        <button type="button" name="trash" class="btn btn-outline btn-warning" onclick="btn_back_onclick();">
            <i class="fa fa-reply"></i> <?php echo __('back'); ?>
        </button>
    </div>
</form>
<script>
     tinyMCE_init();
     tinyMCE.execCommand('mceAddControl', false, 'txt_content');
     tinyMCE.execCommand('mceAddControl', false, 'txt_answer');
</script>