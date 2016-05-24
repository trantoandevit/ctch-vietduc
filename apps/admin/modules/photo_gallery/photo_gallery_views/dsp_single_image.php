<?php
defined('DS') or die('no direct access');
$v_file_name = isset($arr_single_image['C_FILE_NAME']) ? $arr_single_image['C_FILE_NAME'] : '';
$v_basename = basename($v_file_name);
$v_desc      = isset($arr_single_image['C_NOTE']) ? $arr_single_image['C_NOTE'] : '';
?>
<form name="frm_single_image" id="frm_single_image" action="#" method="post">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('XmlData', '');
    echo $this->hidden('hdn_item_id', $v_id);
    echo $this->hidden('hdn_gallery_id', get_post_var('gallery_id'));
    ?>
    <div class="Row">
        <div class="left-Col">
            <?php echo __('image') ?><span class="required">(*)</span>
        </div>
        <div class="right-Col">
            <input type="text" name="txt_file_name" value="<?php echo $v_basename; ?>" id="txt_file_name"
                   class="inputbox" maxlength="500" size="50" disabled
                   data-allownull="yes" data-validate="text"
                   data-name="<?php echo __('image'); ?>"
                   data-xml="no" data-doc="no"
                   />
            <img 
                height="16" width="16" id="choose_img" onClick="choose_img_onclick()"
                src="<?php echo SITE_ROOT ?>public/images/MediaLogo.gif"
                />
            <input type="hidden" name="hdn_file_name" value="<?php echo $v_file_name; ?>" id="hdn_file_name"
                   class="inputbox" maxlength="500"
                   data-allownull="no" data-validate="text"
                   data-name="<?php echo __('image'); ?>"
                   data-xml="no" data-doc="no"
                   />
        </div>
    </div>
    <div class="Row">
        <div class="left-Col">
            <?php echo __('description'); ?>
        </div>
        <div class="right-Col">
            <textarea name="txt_desc" id="txt_desc" cols="50" rows="3"
                      class="inputbox" maxlength="500" 
                      data-allownull="yes" data-validate="text"
                      data-name="<?php echo __('description'); ?>"
                      data-xml="no" data-doc="no"
                      ><?php echo $v_desc ?></textarea>
        </div>
    </div>
    <div class="button-area">
        <input 
            type="button" class="ButtonAccept" value="<?php echo __('update'); ?>"
            onclick="frm_single_image_on_submit()"
            />
        <input 
            type="button" class="ButtonCancel" value="<?php echo __('cancel') ?>"
            onclick="frm_single_image_on_cancel()"
            />
    </div>
</form>
<script>
    function frm_single_image_on_submit(){
        $url = "<?php echo $this->get_controller_url() ?>" + 'update_image';
        var f = document.frm_single_image;
        var xObj = new DynamicFormHelper('','',f);
        if (xObj.ValidateForm(f)){
            f.XmlData.value = xObj.GetXmlData();
            $.ajax({
                type: 'post',
                url: $url,
                data: $('#frm_single_image').serialize(),
                success: function(){
                    reload_current_tab();
                }
            });
        }
    }
    
    function frm_single_image_on_cancel(){
        reload_current_tab();
    }
    
    function choose_img_onclick(){
        $url = "<?php echo $this->get_controller_url('advmedia', 'admin') ?>"
            + 'dsp_service/image';
        showPopWin($url, 800, 600, function(json){
            if(json){
                $v_file_name = json[0]['path'];
                $('#txt_file_name').val($v_file_name);
                $('#hdn_file_name').val($v_file_name);
            }
        });
    }
</script>