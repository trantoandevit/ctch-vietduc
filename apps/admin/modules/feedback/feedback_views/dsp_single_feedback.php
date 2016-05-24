<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<?php
//display header
$this->_page_title = __('feedback detail');

$v_id              = isset($arr_single_feedback['PK_FEEDBACK'])?$arr_single_feedback['PK_FEEDBACK']:0;
$v_name            = isset($arr_single_feedback['C_NAME'])?$arr_single_feedback['C_NAME']:'';
$v_address         = isset($arr_single_feedback['C_ADDRESS'])?$arr_single_feedback['C_ADDRESS']:'';
$v_email           = isset($arr_single_feedback['C_EMAIL'])?$arr_single_feedback['C_EMAIL']:'';
$v_date            = isset($arr_single_feedback['C_INIT_DATE'])?$arr_single_feedback['C_INIT_DATE']:'';
$v_title           = isset($arr_single_feedback['C_TITLE'])?$arr_single_feedback['C_TITLE']:'';
$v_content         = isset($arr_single_feedback['C_CONTENT'])?$arr_single_feedback['C_CONTENT']:'';
$v_reply           = isset($arr_single_feedback['C_REPLY'])?$arr_single_feedback['C_REPLY']:'';
$v_website_id      = isset($arr_single_feedback['FK_WEBSITE'])?$arr_single_feedback['FK_WEBSITE']:0;
$v_user_id         = isset($arr_single_feedback['FK_USER'])?$arr_single_feedback['FK_USER']:0;
$v_file_name       = isset($arr_single_feedback['C_FILE_NAME'])?$arr_single_feedback['C_FILE_NAME']:'';

$v_public          = isset($arr_single_feedback['C_PUBLIC'])?$arr_single_feedback['C_PUBLIC']:0;
$v_public          = ($v_public == 1)?'checked':'';
        
$v_private_answer  = isset($arr_single_feedback['C_PRIVATE_ANSWER'])?$arr_single_feedback['C_PRIVATE_ANSWER']:0;
$v_private_answer  = ($v_private_answer == 1)?'checked':'';

$v_user_name       = isset($arr_single_feedback['C_USER_NAME'])?$arr_single_feedback['C_USER_NAME']:'';

?>
<script src="<?php echo SITE_ROOT; ?>public/tinymce/script/tiny_mce.js"></script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo __('feedback detail'); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
<?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_feedback');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_feedback');
    echo $this->hidden('hdn_update_method', 'update_feedback');
    echo $this->hidden('hdn_delete_method', 'delete_banner');

    echo $this->hidden('hdn_item_id', $v_id);
    echo $this->hidden('hdn_item_id_list', '');
    echo $this->hidden('XmlData', '');
?>
    <!--ho va ten-->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('full name')?></label>
        <div class="col-sm-10 control-label" style="text-align: left;"><?php echo $v_name?></div>
    </div>
     <!--dia chi-->
     <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('address')?></label>
        <div class="col-sm-10 control-label" style="text-align: left;"><?php echo $v_address?></div>
    </div>
      <!--emai-->
    <div class="form-group">
        <label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10 control-label" style="text-align: left;"><?php echo $v_email?></div>
    </div>
      <!--tieu de-->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo ('title')?></label>
        <div class="col-sm-10 control-label" style="text-align: left;">
            <input disabled class="form-control" type="textbox" name="txt_title" id="txt_title" value="<?php echo $v_title?>" size="100" style="width:77%;">
        </div>
    </div>
      <!--emai-->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('content')?></label>
        <div class="col-sm-10 control-label" style="text-align: left;">
            <textarea disabled name="txt_content" id="txt_content" style="width: 666px;min-height: 134px;" ><?php echo $v_content;?></textarea>
        </div>
    </div>
    <!--tra loi cau hoi-->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('reply')?></label>
        <div class="col-sm-10 control-label" style="text-align: left;">
            <textarea name="txt_reply" style="width: 630px;min-height: 134px;" id="txt_reply" >
                <?php echo $v_reply; ?>
            </textarea>
        </div>
    </div>
      <!--file dinh kem-->
      <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo __('attachments')?></label>
          <div class="col-sm-10 control-label" style="text-align: left;">
              <?php if ($v_file_name != '' && $v_file_name != NULL):
                  ?>
                  <a target="_blank" href="<?php echo SITE_ROOT . 'upload/' . $v_file_name ?>"><?php echo end(explode(DS, $v_file_name)) ?></a>
              <?php else: ?>
                  <?php echo __('no attachments') ?>
              <?php endif; ?>
          </div>
      </div>
    <!--nguoi tra loi cau hoi-->
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('init user');?></label>
        <div class="col-sm-10 control-label" style="text-align: left;">
            <input disabled class="form-control" type="textbox" name="txt_init_user" id="txt_init_user" 
                   value="<?php echo $v_user_name?>" size="100" style="width:77%;" disabled
                   />
        </div>
    </div>
    <!--hien thi-->
    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>
        <div class="col-sm-10 control-label" style="text-align: left;">
            <input <?php echo $v_public;?> type="checkbox" name="chk_public" id="chk_public" />
            <label class="control-label"><?php echo __('display')?></label>
        </div>
    </div>
    <!--private answer-->
    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>
        <div class="col-sm-10 control-label" style="text-align: left;">
            <input <?php echo ($v_private_answer == 1)?'disabled':'';?> <?php echo $v_private_answer;?> type="checkbox" name="chk_private_answer" id="chk_private_answer" />
            <label class="control-label"><?php echo __('private answer')?></label>
        </div>
    </div>
    <!--button-->
    <div class="button-area">
        <button type="button" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="btn_update_onclick();">
            <i class="fa fa-check"></i> <?php echo __('accept')?>
        </button>
        <button type="button" class="btn btn-outline btn-warning" onclick="btn_back_onclick();">
            <i class="fa fa-reply"></i> <?php echo __('back')?>
        </button>
    </div> 
</form>
<script>
    tinyMCE_init(); 
    tinyMCE.execCommand('mceAddControl', false, 'txt_reply');
</script>