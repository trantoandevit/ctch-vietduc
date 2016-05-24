<?php
defined('DS') or die('no direct access');
$v_title          = isset($arr_single_gallery['C_TITLE']) ? $arr_single_gallery['C_TITLE'] : '';
$v_status         = isset($arr_single_gallery['C_STATUS']) ? $arr_single_gallery['C_STATUS'] : 0;
$v_summary        = isset($arr_single_gallery['C_SUMMARY']) ? $arr_single_gallery['C_SUMMARY'] : '';
$v_slug           = isset($arr_single_gallery['C_SLUG']) ? $arr_single_gallery['C_SLUG'] : '';
$v_thumbnail_file = isset($arr_single_gallery['C_THUMBNAIL_FILE']) ? $arr_single_gallery['C_THUMBNAIL_FILE'] : '';
?>
<div id="msg-box" style="">

</div>
<form class="grid_23" name="frmMain" id="frmMain" action="#" method="post">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_gallery');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_gallery');
    echo $this->hidden('hdn_update_method', 'update_general_info');
    echo $this->hidden('hdn_delete_method', 'delete_gallery');

    echo $this->hidden('hdn_item_id', $v_id);
    echo $this->hidden('hdn_thumbnail', $v_thumbnail_file);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('XmlData', '');
    ?>

    <div class="left-article grid_16">
        <div class="Row">
            <div class="left-Col">
                <?php echo __('title'); ?><span class="required">(*)</span>
            </div>
            <div class="right-Col">
                <input type="text" name="txt_title" value="<?php echo $v_title; ?>" id="txt_title"
                       class="inputbox" maxlength="500" size="50"
                       data-allownull="no" data-validate="text"
                       data-name="<?php echo __('title'); ?>"
                       data-xml="no" data-doc="no" onKeyUp="auto_slug(this, '#txt_slug');"
                       />
            </div>
        </div>
        <div class="Row">
            <div class="left-Col">
                <?php echo __('slug'); ?><span class="required">(*)</span>
            </div>
            <div class="right-Col">
                <input type="text" name="txt_slug" value="<?php echo $v_slug; ?>" id="txt_slug"
                       class="inputbox" maxlength="500" size="50"
                       data-allownull="no" data-validate="text"
                       data-name="<?php echo __('slug'); ?>"
                       data-xml="no" data-doc="no"
                       />
            </div>
        </div>
        <div class="Row">
            <?php echo __('summary'); ?>
            <textarea 
                name="txt_summary" style="width:100%" id="txt_summary"
                ><?php echo $v_summary; ?></textarea>
        </div>
    </div>
    <div class="right-article grid_7">
        <div style="padding-left:10px;">
            <div class="ui-widget">
                <div class="ui-widget-header ui-state-default ui-corner-all">
                    <h4>
                        <a 
                            href="javascript:;" style="float:right;text-decoration: underline;"
                            onClick="delete_thumbnail_onclick();"
                            >
                                <?php echo __('delete') ?>
                        </a>
                        <font><?php echo __('thumbnail') ?></font>
                    </h4>

                </div>
                <div class="ui-widget-content Center" id="thumbnail_container" 
                     style="padding-bottom: 5px;" onClick="thumbnail_onclick();">
                    </br>
                    <?php if ($v_thumbnail_file): ?>
                        <img 
                             width="250" 
                            src="<?php echo SITE_ROOT . 'upload/' . $v_thumbnail_file ?>"
                            />
                        <?php else: ?>
                        <div style="width:250px;height: 150px;border:dashed #C0C0C0;margin: 0 auto;">
                            <a href="javascript:;">
                                <h4 class="Center">
                                    <?php echo __('choose image') ?>
                                </h4>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div><!--widget thumbnail-->
        </div>
    </div>
</form>
<div class="button-area">
    <input
        type="button" class="ButtonAccept" value="<?php echo __('apply') ?>"
        onClick="frm_on_submit();return false;"
        />
    <input
        type="button" class="ButtonBack" value="<?php echo __('goback to list') ?>"
        onClick="btn_back_onclick();"
        />
</div>
<script>
    function thumbnail_onclick()
    {
        var $url = "<?php echo $this->get_controller_url('advmedia', 'admin') . 'dsp_service/image'; ?>";
        showPopWin($url, 800, 600, function(json_obj){
            if(json_obj[0])
            {
                $file = json_obj[0]['path'];
                var $html = '</br><img  width="250"';
                $html += 'onClick="thumbnail_onclick();"';
                $html += ' src="<?php echo SITE_ROOT . 'upload' . '/' ?>' + $file + '"/>';
                $('#thumbnail_container').html($html);
                $('#hdn_thumbnail').val($file);
            }
        });
    }
    
    function delete_thumbnail_onclick()
    {
        var $html = '</br>'
            + '<div style="width:250px;height: 150px;border:dashed #C0C0C0;margin: 0 auto;">'
            +'<a href="javascript:;">'
            + '<h4 class="center">'
            +    ' <?php echo __('choose image') ?>'
            +  '</h4>'
            + '</a>'
            +  '</div>';
        $('#thumbnail_container').html($html);
        $('#hdn_thumbnail').val('');
    }
    function btn_add_attachment_onclick()
    {
        var $url = "<?php echo $this->get_controller_url('media', 'admin') . 'dsp_service/'; ?>";
        $url += '&pop_win=1';
        showPopWin($url, 800, 600, function(json_obj){
            if(json_obj[0])
            {
                $id = json_obj[0]['media_id'];
                $file = json_obj[0]['media_file_name'];
                $html = '<p style="margin:3px;width:200%;">'
                    + '<img height="12" width="12" src="<?php echo SITE_ROOT; ?>public/images/icon_bannermenu_exit.gif"'
                    + 'onClick="delete_attachment(this);"/>'
                    + '<input type="hidden" name="hdn_attachment[]" value="'+ $id +'"/>'
                    + '&nbsp;' + $file
                    + '</p>';
                
                $('#attachment_container').append($html);
            }
 
        });
    }
    
    function delete_attachment(img_obj)
    {
        $(img_obj).parent().remove();
    }
    
    function frm_on_submit(){
        $v_id = <?php echo $v_id; ?>;
        tinyMCE.triggerSave();
        reset_div_msg();
        $('#msg-box').fadeIn('slow');

        var f = document.frmMain;
        m = $("#controller").val() + f.hdn_update_method.value + '/0/';
        var xObj = new DynamicFormHelper('','',f);
        if (xObj.ValidateForm(f)){
            f.XmlData.value = xObj.GetXmlData();
            $("#frmMain").attr("action", m);
            $.ajax({
                type: 'post',
                url: m,
                data: $(f).serialize(),
                success: function(json_obj){
                    window.onbeforeunload = function() {};
                    json_obj = JSON.parse(json_obj);
                    var $url = $('#controller').val() + $('#hdn_dsp_single_method').val() + '/' + json_obj['id'];
                    
                    if($v_id == 0)
                    {
                        $('#frm_filter').attr('action', $url);
                        $('#frm_filter').submit();
                    }
                    else
                    {
                        $('#msg-box').html(json_obj['msg']);
                        add_btnOK_to_div_msg();
                    }
                }
            });
        }
        else
        {
            $('#msg-box').fadeOut('slow');
        }
    }
       
    $(document).ready(function(){
        reset_div_msg();
        tinyMCE.execCommand('mceAddControl', false, 'txt_summary');
    });
    
    function reset_div_msg(){
        $html = '<p>';
        $html += '<img height="16" width="16" src="' + '<?php echo SITE_ROOT ?>public/images/loading.gif' + '"/>';
        $html += '<?php echo __('processing') ?>';
        $html += '</p>';
        $('#msg-box').html($html);
        $('#msg-box').removeAttr('class');
    }

    function add_btnOK_to_div_msg()
    {
        $html = '</br><input type="button" onClick="div_msg_hide();" value="OK" style="width:30px;"/>';
        $('#msg-box').append($html);
    }
    
    function div_msg_hide()
    {
        $('#msg-box').fadeOut('fast', reset_div_msg);
    }
</script>