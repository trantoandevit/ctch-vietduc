<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<?php
//display header
$this->_page_title = __('event detail');

$v_file_name = isset($arr_single_event['C_FILE_NAME']) ? $arr_single_event['C_FILE_NAME'] : '';
$v_extension = substr($v_file_name, strrpos($v_file_name, '.') + 1);

$v_event_id        = isset($arr_single_event['PK_EVENT']) ? $arr_single_event['PK_EVENT'] : '';
$v_event_name      = isset($arr_single_event['C_NAME']) ? $arr_single_event['C_NAME'] : '';
$v_event_slug      = isset($arr_single_event['C_SLUG']) ? $arr_single_event['C_SLUG'] : '';
$v_event_status    = isset($arr_single_event['C_STATUS']) ? $arr_single_event['C_STATUS'] : '';
$v_event_default   = isset($arr_single_event['C_DEFAULT']) ? $arr_single_event['C_DEFAULT'] : '';
$v_event_is_report = isset($arr_single_event['C_IS_REPORT']) ? $arr_single_event['C_IS_REPORT'] : '';

$v_begin_date_time   = isset($arr_single_event['C_BEGIN_DATE']) ? $arr_single_event['C_BEGIN_DATE'] : '';
$arr_begin_date_time = explode(' ', $v_begin_date_time);
$v_begin_date        = isset($arr_begin_date_time[0]) ? $arr_begin_date_time[0] : '';
$v_begin_time        = isset($arr_begin_date_time[1]) ? $arr_begin_date_time[1] : date("H:i:s");

$v_begin_end_time  = isset($arr_single_event['C_END_DATE']) ? $arr_single_event['C_END_DATE'] : '';
$arr_end_date_time = explode(' ', $v_begin_end_time);
$v_end_date        = isset($arr_end_date_time[0]) ? $arr_end_date_time[0] : '';
$v_end_time        = isset($arr_end_date_time[1]) ? $arr_end_date_time[1] : date("H:i:s");

$arr_img_ext = explode(',', str_replace(' ', '', constant("EXT_IMAGE")));

$v_txt_search = get_post_var('txt_search', '');
$v_text_type  = get_post_var('type_event', '');
?>

<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', $v_event_id);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_event');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_event');
    echo $this->hidden('hdn_update_method', 'update_event');
    echo $this->hidden('hdn_delete_method', 'delete_event');
    echo $this->hidden('hdn_file_name', $v_file_name);
    echo $this->hidden('XmlData', '');

    echo $this->hidden('txt_search', $v_txt_search);
    echo $this->hidden('type_event', $v_text_type);

    //Luu dieu kien loc
    ?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo __('event detail'); ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
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
                           style="width:101px;height:68px">
                    </embed>
                </object>
            <?php else: ?>
                <img id="banner_img" src="<?php echo SITE_ROOT . "upload/" . $v_file_name; ?>" style="width: 101px;height:68px;"/>
            <?php endif; ?>
        </center>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('event'); ?></label>
            <div class="col-sm-10">
                <input type="textbox" name="txt_event_name" id="txt_event_name" value="<?php echo $v_event_name; ?>" 
                       onkeyup="auto_slug(this, '#txt_event_slug');"
                       data-allownull="no" data-validate="text" 
                       data-name="<?php echo __('event name') ?>" 
                       data-xml="no" data-doc="no" 
                       autofocus="autofocus" class="form-control"
                       size="70">
            </div>
        </div>

        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('Slug'); ?></label>
            <div class="col-sm-10">
                <input type="textbox" name="txt_event_slug" id="txt_event_slug" value="<?php echo $v_event_slug; ?>" 
                       data-allownull="no" data-validate="text" 
                       data-name="<?php echo __('slug') ?>" 
                       data-xml="no" data-doc="no" 
                       autofocus="autofocus" class="form-control"
                       size="70">
            </div>
        </div>

        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo __('article'); ?></label>
        <div class="col-sm-10">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" name="tbl_article" id="tbl_article">
                        <colgroup>
                            <col width="5%" />
                            <col width="95%" />
                        </colgroup>
                        <tr>
                            <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                            <th><?php echo __('title'); ?></th>
                        </tr>
                        <?php
                        $row = 0;
                        foreach ($arr_all_article as $row_article):
                            $v_article_id = $row_article['FK_ARTICLE'];
                            $v_article_name = $row_article['C_TITLE'];
                            $v_cat_id = $row_article['FK_CATEGORY'];
                            $v_class = '';
                            if (
                                    $row_article['CK_END_DATE'] < 0
                                    OR $row_article['CK_BEGIN_DATE'] < 0
                                    OR $row_article['C_STATUS'] < 3
                                    OR $row_article['C_CAT_STATUS'] == 0
                            ) {
                                $v_class = 'line-through';
                            }
                            ?>
                            <tr>
                                <td class="Center">
                                    <input type="checkbox" name="chk" id="chk_<?php echo $v_article_id; ?>"
                                           value="<?php echo $v_article_id; ?>" 
                                           data-category="<?php echo $v_cat_id; ?>" 
                                           data-article_name="<?php echo $v_article_name; ?>" 
                                           onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                                           />
                                </td>
                                <td>
                                    <label class="<?php echo $v_class ?>" for="chk_<?php echo $v_article_id; ?>"><?php echo $v_article_name; ?></label>
                                </td>
                            </tr>
                            <?php
                            $row = ($row == 1) ? 0 : 1;
                        endforeach;
                        ?>
                    </table>
                    <div class="button-area">
                        <button type="button" name="btn_add_article" class="btn btn-outline btn-primary" id="btn_add_article" style="margin-right: 10px;" onclick="btn_add_article_onclick();">
                            <i class="fa fa-plus"></i> <?php echo __('add article'); ?>
                        </button>
                        <button type="button" name="btn_delete_article" class="btn btn-outline btn-danger" id="btn_delete_article" onclick="btn_delete_article_onclick();">
                            <i class="fa fa-times" ></i> <?php echo __('delete'); ?>
                        </button>
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class ="col-sm-12">
                    <label class='col-sm-2 control-label'><?php echo __('begin date'); ?></label>
                <div class="col-sm-4">
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
                    <label class='col-sm-2 control-label'><?php echo __('begin time'); ?></label>
                <div class="col-sm-4">
                    <input type="textbox" name="txt_begin_time" id="txt_begin_time" class="form-control" value="<?php echo $v_begin_time; ?>"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class ="col-sm-12">   
                    <label class='col-sm-2 control-label'><?php echo __('end date'); ?></label>
                <div class="col-sm-4" style="float: left">
                        <div class='input-group date' id="ed_date" style="width: 100%; display: block;">
                            <input type='text' name="txt_end_date" value="<?php echo $v_end_date; ?>" id="txt_end_date" class="form-control"
                                   data-allownull="no" data-validate="date" 
                                   data-name="<?php echo __('end date') ?>" 
                                   data-xml="no" data-doc="no" style="width: 85%;"
                                   autofocus="autofocus" />
                            <span class="input-group-addon" style="width: 15%; height: 34px;">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                </div>
                    <label class='col-sm-2 control-label'><?php echo __('end time'); ?></label>
                <div class="col-sm-4">
                    <input type="textbox" class="form-control" name="txt_end_time" id="txt_end_time" value="<?php echo $v_end_time; ?>"/>
                </div>
                <br>
                <label style="color: red;display: none" id="error-date"><?php echo __('end date not smaller start date'); ?></label>
            </div>
        </div>

        <div class="form-group">
            <div class ="col-sm-12">
                    <label class='col-sm-2 control-label'><?php echo __('status'); ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" value="1" name="event_status" id="event_status" <?php echo ($v_event_status == 1) ? 'checked' : ''; ?> />
                    <label for="event_status"><?php echo __('display') ?></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class ="col-sm-12">
                    <label class='col-sm-2 control-label'><?php echo __('show in homepage'); ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" value="1" name="event_default" id="event_default" <?php echo ($v_event_default == 1) ? 'checked' : ''; ?> />
                    <label for="event_default"><?php echo __('yes'); ?></label>
                </div>
            </div>
        </div>
        <div class="form-group" style="display: none">
            <div class ="col-sm-12">
                    <label class='col-sm-2 control-label'><?php echo __('report'); ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" value="1" name="is_report" id="chk_is_report" <?php echo ($v_event_is_report == 1) ? 'checked' : ''; ?>/>
                    <label for="chk_is_report"><?php echo __('yes'); ?></label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <label class="required" id="message_err"></label>
    <br>
    <div class="button-area">
        <button type="button" name="btn_update" class="btn btn-outline btn-success" id="btn_update" style="margin-right: 10px;" onclick="btn_accept_onclick();">
            <i class="fa fa-check"></i> <?php echo __('update'); ?>
        </button>
        <button type="button" name="btn_back" class="btn btn-outline btn-warning" id="btn_cancel" onclick="btn_back_onclick();">
            <i class="fa fa-reply" ></i> <?php echo __('go back'); ?>
        </button>
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
        showPopWin(url, 800, 600,do_attach_media);
    }
    function do_attach_media(returnVal)
    {
        console.log(returnVal);
        if(returnVal[0]){
            media_file_name   = returnVal[0].path;
            media_file_ext    = returnVal[0].type;
        }
        $('#hdn_file_name').attr('value',media_file_name);
        $('#show_img').html('');
      
     
        str = "<img src='<?php echo SITE_ROOT . "upload/"; ?>"+media_file_name+"'style='max-width: 100%;max-height:120;' id='banner_img'/>";
        $('#show_img').html(str);
        
    }
    function btn_add_article_onclick()
    {
        var url = "<?php echo $this->get_controller_url('article', 'admin') ?>dsp_all_article_svc";
        showPopWin(url, 800, 500,do_attach_article);
    }
    function do_attach_article(returnVal)
    {
        var html='';
        for(i=0;i<returnVal.length;i++)
        {
            category_id   = returnVal[i].article_category_id;
            article_id    = returnVal[i].article_id;
            article_title = returnVal[i].article_title;
            row_exist     = '#chk_'+article_id; 
            //alert($(row_exist).val());
            if($(row_exist).val()== null )
            {
                html+='<tr>';
                html+='<td class="center">';
                html+='<input type="checkbox" name="chk" id="chk_'+article_id+'"';
                html+='value="'+article_id+'"';
                html+='data-category="'+category_id+'" ';
                html+='data-article_name="'+article_title+'" ';
                html+='onclick="if (!this.checked) this.form.chk_check_all.checked=false;" />';
                html+='</td><td><label for="chk_'+article_id+'">'+article_title+'</label></td>';
                html+='</tr>';
                $('#tbl_article').append(html);
                html='';
            }
        }
    }
    function btn_delete_article_onclick()
    {
        var table = '#tbl_article input[name="chk"]';
        $(table).each(function(){
          
            if($(this).is(':checked'))
            {
                $(this).parent().parent().remove();
            }
        });
    }
    
    
    function btn_accept_onclick()
    {
        

        //alert(1);
        if($('#hdn_media_id').val()=='')
        {
            $('#message_err').html('Bạn chưa chọn ảnh sự kiện !!!');
            return;
        }
        else
        {
            $('#message_err').html('');
        }
        
        var table = '#tbl_article input[name="chk"]';
        var arr_article = new Array();
        length = 0;
        $(table).each(function(){
            //alert(1);
            article_id  = $(this).val();
            category_id = $(this).attr('data-category');
            v_article   = category_id+' '+article_id
            arr_article.push(v_article);
            length ++;
        });
        //kiem tra xem co tin bai chua
        if(length == 0)
        {
            alert('Bạn chưa chọn tin bài !!!');
            return;
        }
        
        $('#hdn_item_id_list').val(arr_article.join());
        // alert($('#hdn_item_id_list').val());
        
        var begin_date      = $('#txt_begin_date').val();
        var begin_date_time = $('#txt_begin_time').val();
        var end_date        = $('#txt_end_date').val();
        var end_date_time   = $('#txt_end_time').val();
        //        var current_date    = getdate();
        if(paresDate_getTime(begin_date,begin_date_time) >= paresDate_getTime(end_date,end_date_time))
        {
            $('#error-date').show();
            return;
        }
        else
        {
            $('#error-date').hide();
        }        
        btn_update_onclick();
    }
    
    function paresDate_getTime(str_date,str_time) 
    {
        var date    = str_date.split('-');
        
        if(str_time.length == 0 || typeof(str_time) == 'undefined')
        {
            var hours   = '';
            var minutes = '';
            var seconds = '';
        }
        var   time = str_time.split(':');
        hours   = time[0] || '';
        minutes = time[1] || '';
        seconds = time[2] || '';
        return new Date(date[2],date[1],date[0],hours,minutes,seconds).getTime();
    }
</script>
