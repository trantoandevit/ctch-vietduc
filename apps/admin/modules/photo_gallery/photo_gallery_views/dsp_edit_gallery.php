<?php
defined('DS') or die('no direct access');
$arr_status = array(
    0         => __('draft'),
    3         => __('published')
);

$v_author     = $arr_single_gallery['C_INIT_USER_NAME'];
$v_begin_date = new DateTime($arr_single_gallery['C_BEGIN_DATE']);
$v_begin_time = $v_begin_date->format('H:i');
$v_begin_date = $v_begin_date->format('d/m/Y');

$v_end_date = new DateTime($arr_single_gallery['C_END_DATE']);
$v_end_time = $v_end_date->format('H:i');
$v_end_date = $v_end_date->format('d/m/Y');

//xem co hien begin end date ko
$show_date         = true;
$arr_required_role = array('ADMINISTRATORS', 'TONG_BIEN_TAP', 'BIEN_TAP_VIEN');
$arr_user_role = Session::get('arr_all_grant_group_code');
$arr_intersect = array_intersect($arr_required_role, $arr_user_role);

if (empty($arr_intersect))
{
    $show_date = false;
}
?>
<form name="frm_edit" id="frm_edit" action="<?php echo $this->get_controller_url() . 'update_edit_article/' ?>">
    <?php echo $this->hidden('hdn_item_id', $v_id); ?>
    <div class="Row">
        <div class="left-Col">
            <?php echo __('status') ?> <span class="required">(*)</span>
        </div>
        <div class="right-Col">
            <select name="sel_status" id="sel_status">
                <?php echo View::generate_select_option($arr_status, $arr_single_gallery['C_STATUS']); ?>
            </select>
        </div>
    </div>
    <div class="Row">
        <div class="left-Col">
            <?php echo __('author') ?>
        </div>
        <div class="right-Col">
            <input type="text" name="txt_author" value="<?php echo $v_author; ?>" id="txt_author"
                   class="inputbox" maxlength="500" size="50"
                   data-allownull="yes" data-validate="text"
                   data-name="<?php echo __('author'); ?>"
                   data-xml="no" data-doc="no" disabled
                   />
        </div>
    </div>
    <?php if ($show_date): ?>
        <div class="Row">
            <div class="left-Col">
                <?php echo __('begin date') ?>
            </div>
            <div class="right-Col">
                <input type="text" name="txt_begin_date" value="<?php echo $v_begin_date; ?>" id="txt_begin_date"
                       class="inputbox" maxlength="500" size="20"
                       data-allownull="no" data-validate="date"
                       data-name="<?php echo __('begin date'); ?>"
                       data-xml="no" data-doc="no" onClick="DoCal('txt_begin_date')"
                       />
                <img 
                    src="<?php echo SITE_ROOT ?>public/images/calendar.png"
                    onClick="DoCal('txt_begin_date')"
                    />
                &nbsp;
                <?php echo __('at') ?>
                <input type="text" name="txt_begin_time" value="<?php echo $v_begin_time; ?>" id="txt_begin_time"
                       class="inputbox" maxlength="500" size="20"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('begin time'); ?>"
                       data-xml="no" data-doc="no"
                       />
                &nbsp;
                hh:mm

            </div>
        </div>
        <div class="Row">
            <div class="left-Col">
                <?php echo __('end date') ?>
            </div>
            <div class="right-Col">
                <input type="text" name="txt_end_date" value="<?php echo $v_end_date; ?>" id="txt_end_date"
                       class="inputbox" maxlength="500" size="20"
                       data-allownull="no" data-validate="date"
                       data-name="<?php echo __('end date'); ?>"
                       data-xml="no" data-doc="no" onClick="DoCal('txt_end_date')"
                       />
                <img 
                    src="<?php echo SITE_ROOT ?>public/images/calendar.png"
                    onClick="DoCal('txt_end_date')"
                    />
                &nbsp;
                <?php echo __('at') ?>
                <input type="text" name="txt_end_time" value="<?php echo $v_end_time; ?>" id="txt_end_time"
                       class="inputbox" maxlength="500" size="20"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('end time'); ?>"
                       data-xml="no" data-doc="no"
                       />
                &nbsp;
                hh:mm

            </div>
        </div>
    <?php endif; //xem co hien beginend ko ?>
    <div class="button-area">
        <input type="button" class="ButtonAccept" onClick="btn_update_edit_onclick();" value="<?php echo __('update') ?>"/>
        <input type="button" class="ButtonBack" onClick="btn_back_onclick();" value="<?php echo __('goback to list') ?>"/>
    </div>
</form>

<script>
    window.btn_update_edit_onclick = function(){
        var f = document.frm_edit;
        m = '<?php echo $this->get_controller_url() ?>' + 'update_edited_gallery/';
        var xObj = new DynamicFormHelper('','',f); 
        if (xObj.ValidateForm(f)){
            //f.XmlData.value = xObj.GetXmlData();
            $.ajax({
                type: 'post',
                url: m,
                data: $(f).serialize(),
                success: function(json){
                    reload_current_tab();
                }
            });
        }
    }
</script>