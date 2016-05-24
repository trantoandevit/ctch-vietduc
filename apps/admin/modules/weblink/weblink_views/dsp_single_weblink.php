<?php
defined('DS') or die();

//$this->template->title = __('web link');
//$this->template->display('dsp_header.php');

$this->_page_title = __('web link');

//lay du lieu

$v_name = get_array_value($arr_single_weblink, 'C_NAME');
$v_url  = get_array_value($arr_single_weblink, 'C_URL');

$v_logo_file = get_array_value($arr_single_weblink, 'C_FILE_NAME');
$v_logo_url  = SITE_ROOT . 'upload/' . $v_logo_file;

$v_date       = get_array_value($arr_single_weblink, 'C_INIT_DATE');
$v_user       = get_array_value($arr_single_weblink, 'C_INIT_USER_NAME');

$v_status     = get_array_value($arr_single_weblink, 'C_STATUS');
$v_status = ($v_status == 1)?'checked':'';

$v_new_window = get_array_value($arr_single_weblink, 'C_NEW_WINDOWN');
$v_new_window = ($v_new_window == 1)?'checked':'';

$v_begin_date = get_array_value($arr_single_weblink, 'C_BEGIN_DATE');
$v_end_date   = get_array_value($arr_single_weblink, 'C_END_DATE');

$v_type_id    = get_array_value($arr_single_weblink, 'FK_TYPE');
//lay id list da chon
$v_type_checked = isset($arr_all_group_type[0]['PK_LIST'])?$arr_all_group_type[0]['PK_LIST']:0;
foreach($arr_all_group_type as $arr_group_type)
{
    if(in_array($v_type_id,$arr_group_type) == TRUE)
    {
        $v_type_checked = $arr_group_type['PK_LIST'];
        break;
    }
}


//default
if ($v_id == 0)
{
    $v_begin_date = date('d/m/Y');
    $v_end_date   = '1/1/2100';
}

?>
<h1 class="page-header"><?php echo __('web link') ?></h1>
<style>
    .txtbox{
        padding-bottom: 20px;
    }
</style>
<div class="grid_12">
    <form name="frmMain" id="frmMain" action="#" method="post">
        <?php
        echo $this->hidden('controller', $this->get_controller_url());
        echo $this->hidden('hdn_dsp_single_method', 'dsp_single_weblink');
        echo $this->hidden('hdn_dsp_all_method', 'dsp_all_weblink');
        echo $this->hidden('hdn_update_method', 'update_weblink');
        echo $this->hidden('hdn_delete_method', 'delete_weblink');

        echo $this->hidden('hdn_item_id', $v_id);
        echo $this->hidden('hdn_item_id_list', '');
        echo $this->hidden('XmlData', '');
        echo $this->hidden('hdn_logo', $v_logo_file);
        ?>
        <!--ten lien ket-->
        
        <div class="row txtbox">
            <div class="col-lg-2">
                <label><?php echo __('name') ?> <span class="required">(*)</span></label>
            </div>
            <div class="col-lg-6">
                <input type="text" name="txt_name" value="<?php echo $v_name; ?>" id="txt_name"
                       class="form-control" maxlength="500"
                       data-allownull="no" data-validate="text"
                       data-name="<?php echo __('name'); ?>"
                       data-xml="no" data-doc="no"
                       />
            </div>
        </div>
        <!--link lien ket-->
        <div class="row txtbox">
            <div class="col-lg-2">
                <label for="txt_url"><?php echo __('url') ?><span class="required">(*)</span></label>
            </div>
            <div class="col-lg-6">
                <input type="text" name="txt_url" value="<?php echo $v_url; ?>" id="txt_url"
                       class="form-control" maxlength="500"
                       data-allownull="no" data-validate="text" data-name="<?php echo __('url'); ?>" data-xml="no" data-doc="no"
                       />
            </div>
        </div>
        <!--ngay khoi tao-->
        <div class="row txtbox">
            <div class="col-lg-2">
                <label><?php echo __('init date') ?></label>
            </div>
            <div class="col-lg-6">
                <input type="text" name="txt_date" value="<?php echo $v_date; ?>" id="txt_date"
                       class="form-control" maxlength="500"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('date'); ?>"
                       data-xml="no" data-doc="no"
                       disabled
                       />
            </div>
        </div>
        <!--nguoi khoi tao-->
        <div class="row txtbox">
            <div class="col-lg-2">
                <label><?php echo __('init user') ?></label>
            </div>
            <div class="col-lg-6">
                <input type="text" name="txt_user" value="<?php echo $v_user; ?>" id="txt_user"
                       class="form-control" maxlength="500"
                       data-allownull="yes" data-validate="text"
                       data-name="<?php echo __('user'); ?>"
                       data-xml="no" data-doc="no"
                       disabled
                       />
            </div>
        </div>
        <!--ngay bat dau-->
        <div class="row txtbox">
            <div class="col-lg-2">
                <label><?php echo __('begin date') ?></label>
            </div>
            <div class="col-lg-6">
                <div class="input-group date" id="bg_date">
                <input type="text" name="txt_begin_date" value="<?php echo $v_begin_date; ?>" id="txt_begin_date"
                       class="form-control" maxlength="500" style=""
                       data-allownull="no" data-validate="date"
                       data-name="<?php echo __('begin date'); ?>"
                       data-xml="no" data-doc="no" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>   
                </div>
                <!--img height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/calendar.png" onclick="DoCal('txt_begin_date')"/-->
            </div>
        </div>
        <!--ngay ket thuc-->
        <div class="row txtbox">
            <div class="col-lg-2">
                <label><?php echo __('end date') ?></label>
            </div>
            <div class="col-lg-6">
                <div class="input-group date" id="ed_date">
                <input type="text" name="txt_end_date" value="<?php echo $v_end_date; ?>" id="txt_end_date"
                       class="form-control" maxlength="500" style=""
                       data-allownull="no" data-validate="date"
                       data-name="<?php echo __('end date'); ?>"
                       data-xml="no" data-doc="no" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span> 
                </div>
                <!--img height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/calendar.png" onclick="DoCal('txt_end_date')"/-->
            </div>
        </div>
        <!--Nhom lien ket-->
        <div class="row txtbox">
            <div class="col-lg-2">
                <label><?php echo __('weblink group');?></label>
            </div>
            <div class="col-lg-6">
                <div class="ui-widget" style="width: 80%">
                    <!--div class="ui-widget-header ui-state-default ui-corner-top">
                        &nbsp;
                    </div-->
                    <div class="ui-widget-content Center"  style="width: 99%;float: left;">
                        <?php foreach($arr_all_group_type as $arr_group_type):
                                $v_id   = $arr_group_type['PK_LIST'];
                                $v_name = $arr_group_type['C_NAME'];
                                
                                $v_checked = ($v_type_checked == $v_id)?'checked':'';
                        ?>
                        <label style="width: 100%;float: left;text-align: left;">
                            <input <?php echo $v_checked?> type="radio" name="rad_group" id="rad_group" value="<?php echo $v_id?>"/>
                            <?php echo $v_name?>
                        </label>    
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <!--trang thai-->
        <div class="row">
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-6">
                <label>
                    <input type="checkbox" name="chk_status"  id="chk_status" <?php echo $v_status?>/>
                    <?php echo __('active status')?>
                </label>
            </div>
        </div>
        <!--mo cua so moi-->
        <div class="row">
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-6">
                <label>
                    <input type="checkbox" name="chk_new_window" id="chk_new_window" <?php echo $v_new_window?>/>
                    <?php echo __('new window') ?>
                </label>
            </div>
        </div>
        <div class="button-area">
            <!--input class="ButtonAccept" type="button" value="<?php echo __('update') ?>" onclick="btn_update_onclick()"/>
            <input class="ButtonBack" type="button" value="<?php echo __('go back') ?>" onclick="btn_back_onclick()"/-->
            <button type="button" class="btn btn-outline btn-success" onclick="btn_update_onclick()">
                <i class="fa fa-check fa-fw"></i> <?php echo __('update') ?>
            </button>
            <button type="button" class="btn btn-outline btn-warning" onclick="btn_back_onclick()">
                <i class="fa fa-reply fa-fw"></i><?php echo __('go back') ?>
            </button>
        </div>
    </form>
</div>

<hr>

<div class="grid_7">
    <div class="ui-widget">      
        <div class="ui-widget-header ui-state-default ui-corner-top">
            <div class="row">
                <div class="col-lg-2">
                    <label><?php echo __('thumbnail') ?>: </label>
                </div>
                <div class="col-lg-4">                
                    <a href="javascript:;" class="btn btn-outline btn-danger btn-sm" style="text-align: center;float:right;"
                       onClick="delete_thumbnail_onclick();">
                       <i class="fa fa- fa-times "></i> <?php echo __('delete') ?>
                    </a></div>
            </div> 
        </div>
        
        <div class="ui-widget-content Center" id="thumbnail_container" 
             style="padding-bottom:5px;" onClick="thumbnail_onclick();">
            </br>
            <?php if ($v_logo_file): ?>
                <img 
                    width="250" 
                    src="<?php echo $v_logo_url ?>"
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
<script>
    $(document).ready(function(){
        window.btn_back_onclick = function(){
            window.location = $('#controller').val();
        };
        
        $('#bg_date').datetimepicker({
            format: 'D/M/YYYY'//HH:mm:ss
        });
        $('#ed_date').datetimepicker({
            format: 'D/M/YYYY'//HH:ss
        });
        
        
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
                $('#hdn_logo').val($file);
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
        $('#hdn_logo').val('');
    }
</script>
<?php //$this->template->display('dsp_footer.php') ?>
