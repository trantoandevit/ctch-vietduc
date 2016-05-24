<?php
defined('DS') or die();
//direct_url Chưa sử dụng

$v_id             = isset($arr_single_article['PK_ARTICLE']) ? $arr_single_article['PK_ARTICLE'] : 0;
$v_title          = isset($arr_single_article['C_TITLE']) ? $arr_single_article['C_TITLE'] : '';
$v_message        = isset($arr_single_article['C_MESSAGE']) ? $arr_single_article['C_MESSAGE'] : '';
$v_status         = isset($arr_single_article['C_STATUS']) ? $arr_single_article['C_STATUS'] : 0;
$v_sub_title      = isset($arr_single_article['C_SUB_TITLE']) ? $arr_single_article['C_SUB_TITLE'] : '';
$v_summary        = isset($arr_single_article['C_SUMMARY']) ? $arr_single_article['C_SUMMARY'] : '';
$v_content        = isset($arr_single_article['C_CONTENT']) ? $arr_single_article['C_CONTENT'] : '';
$v_slug           = isset($arr_single_article['C_SLUG']) ? $arr_single_article['C_SLUG'] : '';
$v_keyword        = isset($arr_single_article['C_KEYWORDS']) ? $arr_single_article['C_KEYWORDS'] : '';
$v_tags           = isset($arr_single_article['C_TAGS']) ? $arr_single_article['C_TAGS'] : '';
$v_init_user_name = isset($arr_single_article['C_INIT_USER_NAME']) ? $arr_single_article['C_INIT_USER_NAME'] : '';
$v_thumbnail_file = get_array_value($arr_single_article, 'C_FILE_NAME', null);
$v_pen_name       = isset($arr_single_article['C_PEN_NAME']) ? $arr_single_article['C_PEN_NAME'] : '';
$v_init_user      = isset($arr_single_article['FK_INIT_USER']) ? $arr_single_article['FK_INIT_USER'] : '';
$v_has_video      = (int) get_array_value($arr_single_article, 'C_HAS_VIDEO');
$v_has_photo      = (int) get_array_value($arr_single_article, 'C_HAS_PHOTO');

$v_is_copy        = (int) get_array_value($arr_single_article, 'C_IS_COPY');
$v_is_img_news    = (int) get_array_value($arr_single_article, 'C_IS_IMG_NEWS');

$v_employee       = (int) get_array_value($arr_single_article, 'FK_EMPLOYEE');
if ($v_init_user == Session::get('user_id') or $v_id == 0)
{
    $v_disable_pen_name = '';
}
else
{
    $v_disable_pen_name = 'disabled';
}
?>

<style>
    #txt_content_tbl{
        width: 100% !important;
    }
    #txt_summary_tbl{
        width: 100% !important;
    }
</style>

<form class="form-horizontal" name="frmMain" id="frmMain" action="#" method="post">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_article');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_article');
    echo $this->hidden('hdn_update_method', 'update_general_info');
    echo $this->hidden('hdn_delete_method', 'delete_article');

    echo $this->hidden('hdn_item_id', $v_id);
    echo $this->hidden('hdn_thumbnail', $v_thumbnail_file);
    echo $this->hidden('hdn_user', Session::get('user_id'));
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('XmlData', '');
    ?>

    <div id="left-article" class="col-sm-8">
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('title'); ?> <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="txt_title" value="<?php echo $v_title; ?>" id="txt_title"
                       class="form-control" maxlength="500" style="width:100%"
                       data-allownull="no" data-validate="text"
                       data-name="<?php echo __('title'); ?>"
                       onblur="check_title()"
                       data-xml="no" data-doc="no" onKeyUp="auto_slug(this, '#txt_slug');"
                       />
                <input type="button" style="display: none;" id="btn_check_title"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('slug'); ?> <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    <input type="text" name="txt_slug" value="<?php echo $v_slug; ?>" id="txt_slug"
                       class="form-control" maxlength="500" style="width:100%"
                       data-allownull="no" data-validate="text"
                       data-name="<?php echo __('slug'); ?>"
                       data-xml="no" data-doc="no"
                       />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('sub title'); ?> </label>
                <div class="col-sm-9">
                    <input type="text" name="txt_sub_title" value="<?php echo $v_sub_title; ?>" id="txt_sub_title"
                       class="form-control" maxlength="500" style="width:100%"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('sub title'); ?>"
                       data-xml="no" data-doc="no"
                       />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('summary'); ?> </label>
                <div class="col-sm-9">
                    
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <textarea name="txt_summary" style="width:100%" rows="4" id="txt_summary"
                ><?php echo $v_summary; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('content'); ?> <span class="required">(*)</span></label>
                <div class="col-sm-9">
                    
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <textarea name="txt_content" id="txt_content" style="width:100%"
                      ><?php echo $v_content; ?></textarea>
            </div>
        </div>
        <div class="form-group" style="display: none">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('pen name') ?></label>
                <div class="col-sm-9">
                    <input type="text" name="txt_pen_name" value="<?php echo $v_pen_name; ?>" id="txt_pen_name"
                       class="form-control" maxlength="500" style="width:100%"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('pen name'); ?>"
                       data-xml="no" data-doc="no" <?php echo $v_disable_pen_name ?>
                       />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('tags') ?></label>
                <div class="col-sm-9 input-group">
                    <input type="text" name="txt_tags" value="<?php echo $v_tags; ?>" id="txt_tags"
                       class="form-control" maxlength="500" style="width:100%"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('tags'); ?>"
                       data-xml="no" data-doc="no"
                       />
                    <span class="input-group-btn" onclick="dsp_service_tags()">
                        <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-pencil"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label"><?php echo __('keywords') ?></label>
                <div class="col-sm-9 input-group">
                    <textarea type="text" name="txt_keywords" id="txt_keywords"
                          maxlength="500" style="width:100%"
                          data-allownull="yes" data-validate="text"
                          data-name="<?php echo __('keywords'); ?>"
                          data-xml="no" data-doc="no"
                          cols="19" rows="5"
                          ><?php echo $v_keyword; ?></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9 input-group">
                    <?php $checked = $v_has_video > 0 ? 'checked' : '' ?>
                    <input type="checkbox" <?php echo $checked ?> value="1" name="chk_has_video" id="chk_has_video"/>
                    <label for="chk_has_video"><?php echo __('has video') ?></label>
                    <br/>
                    <div style="display: none">
                        <?php $checked = $v_has_photo > 0 ? 'checked' : '' ?>
                        <input type="checkbox" <?php echo $checked ?> value="1" name="chk_has_photo" id="chk_has_photo"/>
                        <label for="chk_has_photo"><?php echo __('has gallery') ?></label>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="form-group" style="display: none">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label">Chuyển hướng tin bài đến:</label>
                <div class="col-sm-9 input-group">
                    <input type="text" name="txt_redirect_url" id="txt_redirect_url" class="form-control" maxlength="500" style="width:90%" data-allownull="yes" data-validate="text" data-name="Tags" data-xml="no" data-doc="no" />
                &nbsp;<img height="20" src="<?php echo SITE_ROOT;?>public/images/icon_media_folder_32x32.png" onclick="btn_redirect_to_onclick()">
                </div>
            </div>
        </div>
        <div class="form-group" style="display: none">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label">Tác giả:</label>
                <div class="col-sm-9 input-group">
                    <select name="sel_employee" id="sel_employee" style="width:200px;" class="form-control">
                     <option value="0">--- Chọn tác giả ---</option>
                     <?php foreach ($arr_all_employee as $employee):
                            $v_employee_id   = $employee['PK_EMPLOYEE'];
                            $v_employee_name = $employee['C_NAME'];
                     ?>
                     <option <?php echo ($v_employee == $v_employee_id)?'selected':'';?> value="<?php echo $v_employee_id?>"><?php echo $v_employee_name?></option>
                     <?php endforeach;?>
                </select>
                </div>
            </div>
        </div>
        <div class="form-group" style="display: none">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9 input-group">
                    <label>
                        <input type="checkbox" name="chk_is_copy" id="chk_is_copy" <?php echo ($v_is_copy == 1) ? ' checked' : ''; ?> />Tin bài copy
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" style="display: none">
            <div class="col-sm-12">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9 input-group">
                    <label>
                     <input type="checkbox" name="chk_is_img_news" id="chk_is_img_news" <?php echo ($v_is_img_news == 1)?' checked':'';?> />Tin ảnh
                 </label>
                </div>
            </div>
        </div>
    </div><!--left article -->
    <div id="right-article" class="col-sm-4">
        <div style="padding-left:10px;">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo __('category') ?> <span class="required">(*)</span>
                </div>
                <div class="panel-body" id="category-content">
                    <?php $arr_granted_cat = Session::get('granted_category', array()); ?>
                    <?php foreach ($arr_all_category as $item): ?>
                        <?php
                        $level = strlen($item['C_INTERNAL_ORDER']) / 3 - 1;
                        $indent = '';
                        $disabled = in_array($item['PK_CATEGORY'], $arr_granted_cat) ? '' : 'disabled';
                        $checked = (in_array($item['PK_CATEGORY'], $arr_category_article)) ? 'checked' : '';
                        for ($i = 0; $i < $level; $i++) {
                            $indent .= '&nbsp;&nbsp;';
                        }
                        ?>
                        <?php echo $indent; ?>
                        <input 
                            type="checkbox" name="chk_category[]" class="chk_category"
                            value="<?php echo $item['PK_CATEGORY'] ?>" 
                            id="category_<?php echo $item['PK_CATEGORY'] ?>"
                            <?php echo $checked; ?> <?php echo $disabled ?>
                            >
                        </input>                        
                        <label for="category_<?php echo $item['PK_CATEGORY']; ?>">
                            <?php echo $item['C_NAME'] ?>
                        </label></br>
                    <?php endforeach; ?>
                </div>
            </div>
            <br/>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a 
                        href="javascript:;" style="float:right;text-decoration: none;color:white;"
                        onClick="delete_thumbnail_onclick();"
                        >
                            <?php echo __('delete') ?>
                    </a>
                    <font><?php echo __('thumbnail') ?></font>
                </div>
                <div class="panel-body" id="category-content">
                    <div class="ui-widget-content Center" id="thumbnail_container" 
                     style="padding-bottom:5px;" onClick="thumbnail_onclick();">
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
                </div>
            </div>
            <br/>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a style="float:right;text-decoration: none;color:white;" href="javascript:;" onClick="btn_add_attachment_onclick();">
                        <?php echo __('add new') ?>
                    </a>
                    <font><?php echo __('attachment') ?> </font>
                </div>
                <div class="panel-body" id="category-content">
                    <div class="ui-widget-content Center" id="attachment_container" style="height:120px;overflow-x: hidden;overflow-y: scroll;">
                    <?php foreach ($arr_all_attachment as $item): ?>
                        <p style="margin:3px;width:100%;">
                            <img height="12" width="12" onClick="delete_attachment(this);"
                                 src="<?php echo SITE_ROOT; ?>public/images/icon_bannermenu_exit.gif"'
                                 />
                            <input type="hidden" name="hdn_attachment[]" value="<?php echo $item['C_FILE_NAME'] ?>"/>
                            &nbsp;<?php echo basename($item['C_FILE_NAME']) ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                </div>
            </div>
        </div> <!--widget container-->
    </div><!--right article-->
    <div class="clear"></div>
    <div class="button-area">
        <button type="button" class="btn btn-outline btn-success" onClick="frm_on_submit();return false";>
            <i class="fa fa-check" ></i> <?php echo __('apply') ?>
        </button>
        <button type="button" class="btn btn-outline btn-warning" onClick="btn_back_onclick();">
            <i class="fa fa-reply" ></i> <?php echo __('goback to list') ?>
        </button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $('#txt_pen_name').combobox(<?php echo json_encode($arr_my_pen_name) ?>);
       
    tinyMCE_init();
    tinyMCE.execCommand('mceRemoveControl', false, 'txt_content');
    tinyMCE.execCommand('mceRemoveControl', false, 'txt_summary');
    tinyMCE.execCommand('mceAddControl', false, 'txt_content');
    tinyMCE.execCommand('mceAddControl', false, 'txt_summary');
    });
    function thumbnail_onclick()
    {
        var $url = "<?php echo $this->get_controller_url('advmedia', 'admin') . 'dsp_service/image'; ?>";
        showPopWin($url, 800, 600, function(json_obj){
            if(json_obj[0])
            {
                $file = json_obj[0]['path'];
                var $html = '</br><img width="250"';
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
        var $url = "<?php echo $this->get_controller_url('advmedia', 'admin') . 'dsp_service/'; ?>";

        showPopWin($url, 800, 600, function(json_obj){
            console.log(json_obj);
            $.each(json_obj, function(k, v){
                $file = v['path'];
                $name = v['name'];
                $html = '<p style="margin:3px;width:200%;">'
                    + '<img height="12" width="12" src="<?php echo SITE_ROOT; ?>public/images/icon_bannermenu_exit.gif"'
                    + 'onClick="delete_attachment(this);"/>'
                    + '<input type="hidden" name="hdn_attachment[]" value="'+ $file +'"/>'
                    + '&nbsp;' + $name
                    + '</p>';
                
                $('#attachment_container').append($html);
            });
        });
    }
    
    function delete_attachment(img_obj)
    {
        $(img_obj).parent().remove();
    }
    
   
    function frm_on_submit(){
        reset_div_msg();
        $v_id = <?php echo $v_id; ?>;
        if($v_id == 0)
        {
            window.onbeforeunload = function() {};
        }
        tinyMCE.triggerSave();
        //kiem tra chuyen muc
        $('.category-msg').remove();
        
        var is_form_valid = true;
        $err_msg = '';
        //kiem tra content
        if(! $('#txt_content').val())
        {
            $('#txt_content').before('<span id= "text-content-error" class="required">Trường này không được để trống</span>');
            is_form_valid = false;
            $err_msg = '<?php echo __('update error, please check all required field') ?>';
        }
        else
        {
            $('#text-content-error').hide();
        }
        
        //kiem tra category
        if($('.chk_category:checked:not(:disabled)').length == 0)
        {
            $('#category-widget').before(
            '<span class="required category-msg">' 
                + '<?php echo __('you must choose atleast one object') ?>' 
                + '</span>'
        );
            is_form_valid = false;
            $err_msg = '<?php echo __('update error, please check all required field') ?>';
        }
        
        //kiem tra employee
//        if($('#sel_employee').val() == '0')
//        {
//            $('#sel_employee').after('<span class="required">Bạn phải chọn tác giả</span>');
//            is_form_valid = false;
//            $err_msg = '<?php echo __('update error, please check all required field') ?>';
//        }
        
        var f = document.frmMain;
        m = '<?php echo $this->get_controller_url() ?>' + f.hdn_update_method.value + '/0/';
        var xObj = new DynamicFormHelper('','',f);
        if (xObj.ValidateForm(f) && is_form_valid == true){
            $('#msg-box').fadeIn('slow');
            f.XmlData.value = xObj.GetXmlData();
            $("#frmMain").attr("action", m);
            $.ajax({
                type: 'post',
                url: m,
                data: $(f).serialize(),
                success: function(json_obj){
                    json_obj = JSON.parse(json_obj);
                    $('#msg-box').addClass(json_obj['status']);
                    $('#msg-box').html(json_obj['msg']);
                    add_btnOK_to_div_msg();
                    if($('#hdn_item_id').val() == '0')
                    {
                        
                        var $url = $('#controller').val() + $('#hdn_dsp_single_method').val() + '/' + json_obj['id'];
                        $('#frm_filter').attr('action', $url);
                        $('#frm_filter').submit();
                    }
                }
            });
        }
        else{
            $('#msg-box').fadeIn('slow');
            $('#msg-box').addClass('error');
            $('#msg-box').html($err_msg);
            add_btnOK_to_div_msg();
        }
    }
    
    function check_title(){
        v_url = "<?php echo $this->get_controller_url() ?>" + 'check_unique_title_service';
        v_title = $('#txt_title').val();
        v_id = $('#hdn_item_id').val();
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: v_url,
            data: {title: v_title, id: v_id},
            success: function(msg){

                if(msg.errors){
                    alert(msg.errors);
                    $('#btn_check_title').attr('class', 'ButtonDelete');
                    return false;
                }else{
                    $('#btn_check_title').attr('class', 'ButtonAccept');
                    return true;
                }
            }
        });
    }
    
    function dsp_service_tags(){
        url = '<?php echo $this->get_controller_url() . 'dsp_all_tags' ?>';
        showPopWin(url, 800, 600, function(returnVal){
            str = '';
            current_tags = $('#txt_tags').val();
            for(i = 0; i < returnVal.length; i++){
                if(i == 0 && current_tags == ''){
                    seperator = '';
                }else{
                    seperator = ', ';
                }
                str += seperator + returnVal[i];
            }
            $('#txt_tags').val(current_tags + str);
        });
    }

    function btn_redirect_to_onclick()
    {
        var $url = "<?php echo $this->get_controller_url('advmedia', 'admin') . 'dsp_service/'; ?>";

        showPopWin($url, 800, 600, function(json_obj){
           
            $.each(json_obj, function(k, v){
                $('#txt_redirect_url').val('<?php echo SITE_ROOT?>' + 'upload/' + v['path']);
            });
        });
    }
    
</script>


