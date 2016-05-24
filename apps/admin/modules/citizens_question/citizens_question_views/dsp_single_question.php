<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');} ?>
<?php
//display header
$this->_page_title = __('citizens question detail');

$v_cq_id           = isset($arr_single_question['PK_CQ'])?$arr_single_question['PK_CQ']:'0';
$v_field_id        = isset($arr_single_question['FK_FIELD'])?$arr_single_question['FK_FIELD']:'';
$v_sender          = isset($arr_single_question['C_NAME'])?$arr_single_question['C_NAME']:''; 
$v_address         = isset($arr_single_question['C_ADDRESS'])?$arr_single_question['C_ADDRESS']:''; 
$v_phone           = isset($arr_single_question['C_PHONE'])?$arr_single_question['C_PHONE']:''; 
$v_email           = isset($arr_single_question['C_EMAIL'])?$arr_single_question['C_EMAIL']:''; 
$v_date_send       = isset($arr_single_question['C_DATE'])?$arr_single_question['C_DATE']:''; 
$v_order           = isset($arr_single_question['C_ORDER'])?$arr_single_question['C_ORDER']:''; 
$v_title           = isset($arr_single_question['C_TITLE'])?$arr_single_question['C_TITLE']:''; 
$v_content         = isset($arr_single_question['C_CONTENT'])?$arr_single_question['C_CONTENT']:''; 
$v_answer          = isset($arr_single_question['C_ANSWER'])?$arr_single_question['C_ANSWER']:''; 
$v_status          = isset($arr_single_question['C_STATUS'])?$arr_single_question['C_STATUS']:''; 
$v_slug            = isset($arr_single_question['C_SLUG'])?$arr_single_question['C_SLUG']:''; 

?>

<script src="<?php echo SITE_ROOT; ?>public/tinymce/script/tiny_mce.js"></script>

<form id="frmMain" name="frmMain" action="" method="POST" class="form-horizontal">
<?php echo $this->hidden('controller',$this->get_controller_url());?>
<?php echo $this->hidden('hdn_item_id', $v_cq_id);?>
<?php echo $this->hidden('hdn_item_id_list','');?>
<?php echo $this->hidden('hdn_item_id_swap', '');?>
<?php echo $this->hidden('hdn_delete_method', '');?>
<?php echo $this->hidden('hdn_dsp_single_method', '');?>
<?php echo $this->hidden('hdn_dsp_all_method', 'dsp_all_cq');?>
<?php echo $this->hidden('hdn_update_method', 'update_question');?>
<?php echo $this->hidden('hdn_current_order', $v_order);?>
<?php echo $this->hidden('XmlData', '');?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo __('citizens question detail'); ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /Toolbar -->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('field');?></label>
        <div class="col-sm-10">
            <select id="select_field" name="select_field" style="min-width: 206px" class="form-control">
                <?php foreach ($arr_all_field as $field): ?>
                    <?php if ($field['C_STATUS'] == 1): ?>
                        <option value="<?php echo $field['PK_FIELD']; ?>" <?php echo ($v_field_id == $field['PK_FIELD']) ? 'selected' : ''; ?>>
                            <?php echo $field['C_NAME']; ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('sender');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_sender" class="form-control" value="<?php echo $v_sender?>" size="40">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('address');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_address" class="form-control" value="<?php echo $v_address?>" size="70">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('phone');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_phone" class="form-control" value="<?php echo $v_phone?>" size="40">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('email');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_email" class="form-control" value="<?php echo $v_email?>" size="40">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('date submitted');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_datesend" class="form-control" value="<?php echo $v_date_send?>" size="40" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('order');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_order" class="form-control" value="<?php echo $v_order?>" size="20">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('title');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_title" class="form-control" 
                   onkeyup="auto_slug(this,'#txt_slug');" 
                   value="<?php echo $v_title?>" size="70">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('slug');?></label>
        <div class="col-sm-10">
            <input type="textbox" name="txt_slug" class="form-control" id="txt_slug"value="<?php echo $v_slug?>" size="70">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('content')?></label>
        <div class="col-sm-10">
            <textarea 
                name="txt_content" style="width:100%" id="txt_content"
                ><?php echo $v_content; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('answer')?></label>
        <div class="col-sm-10">
            <textarea 
                name="txt_answer" style="width:100%" id="txt_answer"
                ><?php echo $v_answer; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('status');?></label>
        <div class="col-sm-10">
            <input type="checkbox" id="chk_status" name="chk_status" <?php echo ($v_status=='1')?'checked':'';?>>
            <label for="chk_status" class="control-label"><?php echo __('display');?></label>
        </div>
    </div>
    <div class="button-area">
        <button type="button" name="addnew" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="btn_update_onclick();">
            <i class="fa fa-check"></i> <?php echo __('apply'); ?>
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