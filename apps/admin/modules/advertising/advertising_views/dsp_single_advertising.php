<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<?php
//display header
$this->_page_title = __('advertising detail');

$v_file_name = isset($arr_single_adv['C_FILE_NAME']) ? $arr_single_adv['C_FILE_NAME'] : '';
$v_extension = substr($v_file_name, strrpos($v_file_name, '.') + 1);

$v_adv_id            = isset($arr_single_adv['PK_ADVERTISING']) ? $arr_single_adv['PK_ADVERTISING'] : '';
$v_adv_name          = isset($arr_single_adv['C_NAME']) ? $arr_single_adv['C_NAME'] : '';
$v_adv_url           = isset($arr_single_adv['C_URL']) ? $arr_single_adv['C_URL'] : '';
$v_begin_date_time   = isset($arr_single_adv['C_BEGIN_DATE']) ? $arr_single_adv['C_BEGIN_DATE'] : '';
$arr_begin_date_time = explode(' ', $v_begin_date_time);
$v_begin_date        = isset($arr_begin_date_time[0]) ? $arr_begin_date_time[0] : '';
$v_begin_time        = isset($arr_begin_date_time[1]) ? $arr_begin_date_time[1] : date("H:i:s");

$v_begin_end_time  = isset($arr_single_adv['C_END_DATE']) ? $arr_single_adv['C_END_DATE'] : '';
$arr_end_date_time = explode(' ', $v_begin_end_time);
$v_end_date        = isset($arr_end_date_time[0]) ? $arr_end_date_time[0] : '';
$v_end_time        = isset($arr_end_date_time[1]) ? $arr_end_date_time[1] : date("H:i:s");

$arr_img_ext   = explode(',', EXT_IMAGE);
$v_position_id = isset($_POST['hdn_position_id']) ? $_POST['hdn_position_id'] : '';
?>

<form name="frmMain" id="frmMain" action="" method="POST">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', $v_adv_id);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_advertising');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_advertising');
    echo $this->hidden('hdn_update_method', 'update_advertising');
    echo $this->hidden('hdn_delete_method', 'delete_advertising');
    echo $this->hidden('hdn_position_id', $v_position_id);
    echo $this->hidden('hdn_file_name', $v_file_name);
    echo $this->hidden('XmlData', '');
    //Luu dieu kien loc
    ?>
    <!-- Toolbar -->
    <h1 class="page-header"><?php echo __('advertising detail'); ?></h1>
    <!-- /Toolbar -->
        <div class="row">
            <input type="button" class="ButtonMediaService" value="<?php echo __('select avatar'); ?>" onclick="btn_service_media_onclick()">
        </div>
    <div style="padding-bottom: 10px;">
        
        <center id="show_img">
            <?php if ($v_extension == 'swf'): ?>
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                        codebase="<?php SITE_ROOT . "upload/flash/swflash.cab" ?>" 
                        width="150" height="150" >
                    <param name="movie" value="" />
                    <param name="quality" value="high" />
                    <param name="wmode" value="transparent" />
                    <embed id="banner_img" src="<?php echo SITE_ROOT . "upload/" . $v_file_name; ?>" wmode="transparent" quality="high"
                           pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"
                           style="max-width:836;max-height:120">
                    </embed>
                </object>
            <?php else: ?>
                <img id="banner_img" src="<?php echo SITE_ROOT . "upload/" . $v_file_name; ?>" style="max-width: 100%;max-height:120;overflow: hidden;"/>
            <?php endif; ?>
        </center> 
    </div>
    
    
    
    <div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-12">
                <div class="col-lg-2">
                    <label><?php echo __('advertising name'); ?></label>              
                </div>
                <div class="col-lg-4">
                    <input type="textbox" class="form-control" name="txt_adv_name" id="txt_adv_name" value="<?php echo $v_adv_name; ?>" 
                           data-allownull="no" data-validate="text" data-name="<?php echo __('advertising name') ?>" 
                           data-xml="no" data-doc="no" autofocus="autofocus" size="30">
                </div>
            </div>
        </div>
        
        <div class="row" style="margin-bottom: 20px;">
            <div class ="col-lg-12">
                <div class="col-lg-2">
                    <label><?php echo __('begin date'); ?></label>  
                </div>
                <div class="col-lg-4">
                    <div class="input-group date" id="bg_date" style="width: 100%; display: block;">
                        <input type='text' name="txt_begin_date" value="<?php echo $v_begin_date; ?>" id="txt_begin_date" class="form-control"
                               data-allownull="no" data-validate="date" 
                               data-name="<?php echo __('begin date') ?>" 
                               data-xml="no" data-doc="no" style="width: 85%;"
                               autofocus="autofocus" />
                        <span class="input-group-addon" style="width: 15%; height: 34px;">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>     
                    </div>                                     
                    <!--img src="</*?php echo $this->image_directory . "calendar.png"; ?>" onclick="DoCal('txt_begin_date')"-->
                </div>
                <div class="col-lg-2">
                    <label><?php echo __('begin time'); ?></label>
                </div>
                <div class="col-lg-4">
                    <input type="textbox" name="txt_begin_time" id="txt_begin_time" class="form-control" value="<?php echo $v_begin_time; ?>"/>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 20px;">
            <div class ="col-lg-12">        
                <div class="col-lg-2">
                    <label><?php echo __('end date'); ?></label>
                </div>
                <div class="col-lg-4" style="float: left">
                        <div class='input-group date' id="ed_date" style="width: 100%; display: block;">
                            <input type='text' name="txt_end_date" value="<?php echo $v_end_date; ?>" id="txt_end_date" class="form-control"
                                   data-allownull="no" data-validate="date" style="width: 85%;"
                                   data-name="<?php echo __('end date') ?>" 
                                   data-xml="no" data-doc="no" 
                                   autofocus="autofocus" />
                            <span class="input-group-addon" style="width: 15%; height: 34px;">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                </div>
                <div class="col-lg-2">
                    <label><?php echo __('end time'); ?></label>
                </div>
                <div class="col-lg-4">
                    <input type="textbox" class="form-control" name="txt_end_time" id="txt_end_time" value="<?php echo $v_end_time; ?>"/>
                </div>
                <br>
                <label style="color: red;display: none" id="error-date"><?php echo __('end date not smaller start date'); ?></label>
            </div>
        </div>
        

        <div class="row" style="margin-bottom: 20px;">
            <div class ="col-lg-12">
                <div class="col-lg-2">
                    <label><?php echo __('url'); ?></label>
                </div>
                <div class="col-lg-4">
                    <input type="textbox" class="form-control" name="txt_url" id="txt_url"value="<?php echo $v_adv_url; ?>" 
                           data-allownull="yes" data-validate="text" data-name="<?php echo __('url') ?>" 
                           data-xml="no" data-doc="no" autofocus="autofocus" size="30"/>
                </div>
            </div>
        </div>
    </div>
    

    <label class="required" id="message_err"></label>
  
    <div class="button-area">
        <button type="button" name="btn_update" id="btn_update" class="btn btn-outline btn-success" onclick="btn_accept_onclick();">
            <i class="fa fa-check"></i> <?php echo __('update'); ?></button>
        <button type="button" name="btn_back" id="btn_cancel" class="btn btn-warning btn-outline" onclick="btn_back_onclick();">
            <i class="fa fa-reply"></i> <?php echo __('go back'); ?></button>
    </div>
</form>
<script>
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
    function btn_service_media_onclick()
    {
        var url="<?php echo $this->get_controller_url('advmedia') . "dsp_service/image"; ?>";
        showPopWin(url, 800, 600,do_attach);
    }
    function do_attach(returnVal)
    {
        if(returnVal[0]){
            var media_file_ext    =returnVal[0].type;
            var media_file_name   =returnVal[0].path;
            
            $('#hdn_file_name').attr('value',media_file_name);
            $('#show_img').html('');
      
     
            str = "<img src='<?php echo SITE_ROOT . "upload/"; ?>"+media_file_name+"'style='max-width: 100%;max-height:120;' id='banner_img'/>";
            $('#show_img').html(str);
        }
       
       
        //str= "<img src='<?php echo $this->image_directory; ?>"+media_file_ext+"-image.png' style='max-width:836;max-height:120'/>";
    }
    function btn_accept_onclick()
    {
        if($('#hdn_media_id').val()=='')
        {
            $('#message_err').html('Bạn chưa chọn ảnh quảng cáo !!!');
            return;
        }
        else
        {
            $('#message_err').html('');
        }
        
        var begin_date      = $('#txt_begin_date').val();
        var begin_date_time = $('#txt_begin_time').val();
        var end_date        = $('#txt_end_date').val();
        var end_date_time   = $('#txt_end_time').val();
        //        var current_date    = getdate();
        if(paresDate_getTime(begin_date,begin_date_time) >= paresDate_getTime(end_date,end_date_time))
        {
            console.log('end_date');
            $('#error-date').show();
            return;
        }
        else
        {
            $('#error-date').hide();
        }        
        btn_update_onclick();
    }
</script>
