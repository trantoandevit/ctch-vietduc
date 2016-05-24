<?php
defined('DS') or die('no direct access');
$arr_status = array(
    0         => __('draft'),
    3         => __('published')
);


$v_msg              = isset($arr_single_article['C_MESSAGE']) ? $arr_single_article['C_MESSAGE'] : '';
$v_author           = $arr_single_article['C_INIT_USER_NAME'];
$v_begin_date       = new DateTime($arr_single_article['C_BEGIN_DATE']);
$v_begin_time       = $v_begin_date->format('H:i');
$v_begin_date       = $v_begin_date->format('d/m/Y');
$v_pen_name         = isset($arr_single_article['C_PEN_NAME']) ? $arr_single_article['C_PEN_NAME'] : '';
$v_disable_pen_name = $arr_single_article['FK_INIT_USER'] == Session::get('user_id') ? '' : 'disabled';

$v_end_date = new DateTime($arr_single_article['C_END_DATE']);
$v_end_time = $v_end_date->format('H:i');
$v_end_date = $v_end_date->format('d/m/Y');


?>
<form class="grid_23" name="frmMain" id="frmMain" action="#" method="post">
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
</form>
<form name="frm_edit" id="frm_edit" action="<?php echo $this->get_controller_url() . 'update_edit_article/' ?>" style="width:966px;" class="form-horizontal">
    <div class="row">

        <?php echo $this->hidden('hdn_item_id', $v_id); ?>
        <div class="form-group">
            <div class="col-sm-12">
                <label class="col-sm-2 control-label" style="text-align: left;"><?php echo __('status') ?> <span class="required">(*)</span></label>
                <div class="col-sm-10">
                    <select name="sel_status" id="sel_status" class="form-control" style="width: 50%;">
                        <?php echo View::generate_select_option($arr_status, $arr_single_article['C_STATUS']); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group" style="display: none;text-align: left;">
            <label class="col-sm-2 control-label"><?php echo __('message') ?></label>
            <div class="col-sm-10">
                <input type="text" name="txt_msg" value="<?php echo $v_msg; ?>" id="txt_msg"
                       class="form-control" maxlength="500" size="50"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('title'); ?>"
                       data-xml="no" data-doc="no"
                       />
            </div>
        </div>
        <div class="form-group" style="display: none;text-align: left;">
            <label class="col-sm-2 control-label"><?php echo __('pen name') ?></label>
            <div class="col-sm-10">
                <input type="text" name="txt_pen_name" value="<?php echo $v_pen_name; ?>" id="txt_pen_name"
                       class="form-control" maxlength="500" size="50"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('pen name'); ?>"
                       data-xml="no" data-doc="no" <?php echo $v_disable_pen_name ?>
                       />
            </div>
        </div>
        <div class="form-group">
            <div class ="col-sm-12">
                    <label class='col-sm-2 control-label' style="text-align: left;"><?php echo __('begin date'); ?></label>
                <div class="col-sm-4">
                    <div class="input-group date" id="bg_date">
                        <input type='text' name="txt_begin_date" value="<?php echo $v_begin_date; ?>" id="txt_begin_date" class="form-control"
                               data-allownull="no" data-validate="date" 
                               data-name="<?php echo __('begin date') ?>" 
                               data-xml="no" data-doc="no" 
                               autofocus="autofocus" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>     
                    </div>                                     
                    <!--img src="</*?php echo $this->image_directory . "calendar.png"; ?>" onclick="DoCal('txt_begin_date')"-->
                </div>
                    <label class='col-sm-1 control-label'><?php echo __('at') ?></label>
                <div class="col-sm-4">
                    <input type="textbox" name="txt_begin_time" id="txt_begin_time" class="form-control" value="<?php echo $v_begin_time; ?>"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class ="col-sm-12">   
                    <label class='col-sm-2 control-label' style="text-align: left;"><?php echo __('end date'); ?></label>
                <div class="col-sm-4" style="float: left">
                        <div class='input-group date' id="ed_date">
                            <input type='text' name="txt_end_date" value="<?php echo $v_end_date; ?>" id="txt_end_date" class="form-control"
                                   data-allownull="no" data-validate="date" 
                                   data-name="<?php echo __('end date') ?>" 
                                   data-xml="no" data-doc="no" 
                                   autofocus="autofocus" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                </div>
                    <label class='col-sm-1 control-label'><?php echo __('at') ?></label>
                <div class="col-sm-4">
                    <input type="textbox" class="form-control" name="txt_end_time" id="txt_end_time" value="<?php echo $v_end_time; ?>"/>
                </div>
                <br>
                <label style="color: red;display: none" id="error-date"><?php echo __('end date not smaller start date'); ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div style="padding-left:10px;">
            <div class="ui-widget" id="category-widget">
                <div class="row">
                    <label class="col-sm-2">&nbsp;</label>
                    <div class="col-sm-10">
                        <div class="ui-widget-header ui-state-default ui-corner-top">
                            <h4><?php echo __('sticky of category') ?></h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2">&nbsp;</label>
                        <div class="col-sm-10">
                            <div class="ui-widget-content" style="height:150px;overflow-y: scroll;" id="category-content">                 
                                <?php foreach ($arr_all_category as $category): ?>
                                    <?php if (in_array($category['PK_CATEGORY'], $arr_category_article)): ?>
                                        <?php
                                        $checked = in_array($category['PK_CATEGORY'], $arr_sticky_category) ? 'checked' : '';
                                        ?>
                                        <input 
                                            type="checkbox" 
                                            name="chk_category[]"
                                            id="chk_category_<?php echo $category['PK_CATEGORY'] ?>"
                                            value="<?php echo $category['PK_CATEGORY'] ?>"
                                            <?php echo $checked ?>
                                            />
                                        <label for="chk_category_<?php echo $category['PK_CATEGORY'] ?>">
                                            <?php echo $category['C_NAME'] ?>
                                        </label>
                                        <br/>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="button-area">
        <button type="button" name="addnew" class="btn btn-outline btn-success" style="margin-right: 10px;" onclick="btn_update_edit_onclick();">
            <i class="fa fa-check"></i> <?php echo __('update') ?>
        </button>
        <button type="button" name="trash" class="btn btn-outline btn-warning" onclick="btn_back_onclick();">
            <i class="fa fa-reply" ></i> <?php echo __('goback to list') ?>
        </button>
    </div>
</form>

<script>
    window.btn_update_edit_onclick = function(){
        var f = document.frm_edit;
        m = '<?php echo $this->get_controller_url() ?>' + 'update_edited_article/';
        var xObj = new DynamicFormHelper('','',f); 
        if (xObj.ValidateForm(f)){
            $('#msg-box').show();
            //f.XmlData.value = xObj.GetXmlData();
            $.ajax({
                type: 'post',
                url: m,
                data: $(f).serialize(),
                success: function(json){
                    $('#frm_filter').attr('action', "<?php echo $this->get_controller_url(); ?>");
                    $('#frm_filter').submit();
                }
            });
        }
    }
    $(document).ready(function(){      
        $('#bg_date').datetimepicker({
                format: 'D/M/YYYY' 
                //HH:mm:ss
        });
        $('#ed_date').datetimepicker({
                format: 'D/M/YYYY'
                //HH:ss
        });
    });
</script>