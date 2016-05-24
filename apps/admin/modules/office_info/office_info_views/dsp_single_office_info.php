<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed');
//display header
$this->template->title = __('office info');
$this->template->display('dsp_header.php');


$v_id           = isset($arr_single_office_info['PK_OFFICE_INFO'])?$arr_single_office_info['PK_OFFICE_INFO']:0;
$v_art_id       = isset($arr_single_office_info['FK_ARTICLE'])?$arr_single_office_info['FK_ARTICLE']:0;
$v_website_id   = isset($arr_single_office_info['FK_WEBSITE'])?$arr_single_office_info['FK_WEBSITE']:0;
$v_name         = isset($arr_single_office_info['C_NAME'])?$arr_single_office_info['C_NAME']:'';
$v_art_title    = isset($arr_single_office_info['C_ART_TITLE'])?$arr_single_office_info['C_ART_TITLE']:'';

$v_status       = isset($arr_single_office_info['C_STATUS'])?$arr_single_office_info['C_STATUS']:'';
$v_status = ($v_status == 1)?'checked':'';

$v_type         = isset($arr_single_office_info['C_TYPE'])?$arr_single_office_info['C_TYPE']:'';
$v_type = ($v_type == 1)?'checked':'';

$v_begin_date   = isset($arr_single_office_info['C_BEGIN_DATE'])?$arr_single_office_info['C_BEGIN_DATE']:'';
$v_end_date     = isset($arr_single_office_info['C_END_DATE'])?$arr_single_office_info['C_END_DATE']:'';
?>
<h2 class="module_title"><?php echo __('office info'); ?></h2>
<form name="frmMain" id="frmMain" action="" method="POST">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', $v_id);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_office_info');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_office_info');
    echo $this->hidden('hdn_update_method', 'update_office_info');
    echo $this->hidden('hdn_delete_method', 'delete_office_info');
    
    echo $this->hidden('XmlData', '');
    
    echo $this->hidden('hdn_article_id',$v_art_id);
    ?>
    <!--tieu de-->
    <div class="Row">
        <div class="left-Col"><?php echo __('title')?> <label class="required">(*)</label></div>
        <div class="right-Col">
            <input type="textbox" name="txt_name" id="txt_name" size="80" value="<?php echo $v_name?>"
                   data-allownull="no" data-validate="text" data-name="<?php echo __('title'); ?>"
                   />
        </div>
    </div>
    <!--tin bai-->
    <div class="Row">
        <div class="left-Col"><?php echo __('article')?> <label class="required">(*)</label></div>
        <div class="right-Col">
            <input type="textbox" name="txt_title" id="txt_title" disabled size="80" value="<?php echo $v_art_title?>"/>
            <input type="button" class="ButtonAdd" onclick="add_article();" value=""/>    
        </div>
    </div>
    <!--trang thai-->
    <div class="Row">
        <div class="left-Col">&nbsp;</div>
        <div class="right-Col">
            <label>
                <input type="checkbox" name="chk_status" id="chk_status" <?php echo $v_status?>/>
                <?php echo __('status')?>
            </label>
        </div>
    </div>
    <!--the loai-->
    <div class="Row">
        <div class="left-Col">&nbsp;</div>
        <div class="right-Col">
            <label>
                <input type="checkbox" name="chk_default" id="chk_default" <?php echo $v_type?>/>
                <?php echo __('default')?>
            </label>
        </div>
    </div>
    <!--ngay bat dau-->
    <div class="Row">
        <div class="left-Col"><?php echo __('begin date')?> <label class="required">(*)</label></div>
        <div class="right-Col">
            <input type="textbox" name="txt_begin_date" id="txt_begin_date" value="<?php echo $v_begin_date?>"
                   onclick="Docal('txt_begin_date')" 
                   data-allownull="no" data-validate="text" data-name="<?php echo __('begin date'); ?>"/>
            <img 
                        height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/calendar.png"
                        onClick="DoCal('txt_begin_date')"
                        />
        </div>
    </div>
    <!--ngay ket thuc-->
    <div class="Row">
        <div class="left-Col"><?php echo __('end date')?> <label class="required">(*)</label></div>
        <div class="right-Col">
            <input type="textbox" name="txt_end_date" id="txt_end_date" value="<?php echo $v_end_date?>"
                   onclick="Docal('txt_end_date')" 
                   data-allownull="no" data-validate="text" data-name="<?php echo __('end date'); ?>"/>
            <img 
                        height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/calendar.png"
                        onClick="DoCal('txt_end_date')"
                        />
        </div>
    </div>
    <div class="button-area">
        <?php if(session::check_permission('THEM_MOI_THONG_TIN',0)==TRUE OR session::check_permission('SUA_THONG_TIN',0)==TRUE ):?>
        <input type="button" class="ButtonAccept" value="<?php echo __('accept')?>" onclick="btn_update_onclick();" 
               />
        <?php endif;?>
        
        
        <input type="button" class="ButtonBack" value="<?php echo __('back')?>" onclick="btn_back_onclick();" />
    </div>
</form>
<script>
function add_article()
{
    var $svc_url = "<?php echo $this->get_controller_url('article', 'admin') ?>dsp_all_article_svc";
    $svc_url += '&disable_website=1';
    $svc_url += '&status=3';
    
    showPopWin($svc_url, 800, 600, function(json){
        if(json)
        {
            article_id = json[0].article_id;
            article_title = json[0].article_title;
            
            console.log(json[0]);
            
            $('#txt_title').val(article_title);
            $('#hdn_article_id').val(article_id);
        }
    });
}
</script>
<?php $this->template->display('dsp_footer.php');