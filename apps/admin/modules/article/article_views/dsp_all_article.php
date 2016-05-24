<?php
defined('DS') or die('no direct access');

$v_begin_date    = get_request_var('txt_begin_date', '');
$v_end_date      = get_request_var('txt_end_date', '');
$v_status        = intval(get_request_var('sel_status', -1));
$v_category_name = empty($category_name) ? ' -- ' . __('all') . ' -- ' : $category_name;
$v_init_user     = intval(get_request_var('sel_init_user', 0));
$v_category_id   = intval(get_request_var('hdn_category', ''));

$v_keyword       = get_request_var('txt_keyword', '');
$v_title         = get_request_var('txt_title');

$v_advanced_search = 'false';
if ($v_begin_date or $v_end_date or ($v_status != -1) or $v_keyword or $v_init_user)
{
    $v_advanced_search = 'true';
}

$show_box_search = '';
if ($v_begin_date or $v_end_date or ($v_status != -1) or $v_keyword or $v_init_user)
{
    $show_box_search = 'in';
}

$this->_page_title = __('article management');

?>
<?php

function show_insert_delete_button()
{
    $html = '<div class="button-area">';
    $html .= '<button type="button" class="btn btn-outline btn-primary" onClick="row_onclick(0);"><i class="fa fa-plus"></i> ' . __('add new') . '</button>';
    
    $html .= '<button type="button" class="btn btn-outline btn-danger" onClick="btn_delete_onclick();" style="margin-left:10px;"><i class="fa fa-times"></i> ' . __('delete') . '</button>';
    
    if (get_system_config_value(CFGKEY_CACHE) == 'true')
    {
        $html .= '<button type="button" class="btn btn-outline btn-success" onClick="btn_cache_onclick();" style="margin-left:10px;"><i class="fa fa-save"></i> ' . __('save cache') . '</button>';
    }

    $html .= '</div>';

    echo $html;
}
?>
<?php
echo $this->hidden('hdn_dsp_single_method', 'dsp_single_article');
echo $this->hidden('controller', $this->get_controller_url());
echo $this->hidden('hdn_dsp_all_method', 'dsp_all_article');
echo $this->hidden('hdn_update_method', 'update_article');
echo $this->hidden('hdn_delete_method', 'delete_article');
echo $this->hidden('hdn_item_id', '');
echo $this->hidden('XmlData', '');
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('article management'); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" method="post" class="form-horizontal">
    <input 
        type="hidden" name="sel_rows_per_page" id="page_size" 
        value="<?php echo get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE) ?>"
        />
    <input 
        type="hidden" name="sel_goto_page" id="page_no" 
        value="<?php echo get_request_var('sel_goto_page', 1) ?>"
        />

    <input
        type="hidden" name="hdn_category" id="hdn_category" 
        value="<?php echo $v_category_id; ?>"
        />
    <div class="panel panel-default" style="margin-top: 20px;">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                <i class="fa fa-search"></i> <?php echo __('advanced search') ?>
            </a>
            
        </div>
        <div id="collapseOne" class="panel-collapse collapse <?php echo $show_box_search; ?>">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('publish time range') ?></label>
                    <div class="col-sm-5">
                        <div class="input-group date" id="txt_bg_date">
                        <input type='text' name="txt_begin_date" value="<?php echo $v_begin_date; ?>" id="txt_begin_date" class="form-control"
                               data-allownull="no" data-validate="date" maxlength="255"
                               data-name="<?php echo __('begin date') ?>" 
                               data-xml="no" data-doc="no" placeholder="<?php echo __('begin date') ?>"
                               autofocus="autofocus" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>     
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group date" id="txt_ed_date">
                        <input type='text' name="txt_end_date" value="<?php echo txt_end_date; ?>" id="txt_end_date" class="form-control"
                               data-allownull="no" data-validate="date" maxlength="255"
                               data-name="<?php echo __('end date'); ?>" style="width:100%"
                               data-xml="no" data-doc="no" placeholder="<?php echo __('end date') ?>"
                               autofocus="autofocus" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>     
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('status') ?></label>
                    <div class="col-sm-10">
                        <select name="sel_status" id="sel_status" onChange="form_auto_submit();" class="form-control">
                        <option value="-1"> -- <?php echo __('all') ?> -- </option>
                        <option value="0"><?php echo __('draft') ?></option>
                        <option value="3"><?php echo __('published') ?></option>
                    </select>
                    <script>$('#sel_status option[value=<?php echo $v_status ?>]').attr('selected', '1');</script>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('init user') ?></label>
                    <div class="col-sm-10">
                        <select name="sel_init_user" id="sel_init_user" onChange="form_auto_submit();" class="form-control">
                        <option value="0"> -- <?php echo __('all') ?> -- </option>
                        <?php foreach ($arr_all_user as $item): ?>
                            <option value="<?php echo $item['PK_USER']; ?>">
                                <?php echo $item['C_NAME'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <script>$('#sel_init_user').val(<?php echo $v_init_user ?>);</script>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('keywords'); ?></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" name="txt_keyword" id="txt_keyword" value="<?php echo $v_keyword; ?>" 
                                   class="form-control" maxlength="255" 
                                   data-allownull="yes" data-validate="text" data-name="<?php echo __('keywords'); ?>" 
                                   data-xml="no" data-doc="no" 
                                   />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('category') ?></label>

                        <div class="col-sm-3"><label for="txt_category" onClick="show_category_svc();">
                                <input type="text" name="txt_category" id="txt_category" value="<?php echo $v_category_name; ?>" 
                               class="form-control" maxlength="255" 
                               data-allownull="yes" data-validate="text" data-name="<?php echo __('category'); ?>" 
                               data-xml="no" data-doc="no" 
                               disabled
                               /> </label>
                        </div>

                        <div class="col-sm-7">
                                    <label class="col-sm-2 control-label"><?php echo __('title');?></label>
                                <div class="col-sm-10"></div>
                                <div class="input-group">
                                <input type="text" name="txt_title" id="txt_title" value="<?php echo $v_title; ?>" 
                                       class="form-control" maxlength="255" 
                                       data-allownull="yes" data-validate="text"
                                       data-xml="no" data-doc="no" placeholder="<?php echo __('title');?>"
                                       />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                    </button>
                                </span>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    

    <?php show_insert_delete_button(); ?>
    
    
    
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', '0');
    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_article');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_article');
    echo $this->hidden('hdn_update_method', 'update_article');
    echo $this->hidden('hdn_delete_method', 'delete_article');
    echo $this->hidden('hdn_delete_method', 'delete_article');
    ?>
    <?php
    $n          = count($arr_all_article);
    $i          = 0;
    ?>
    <?php
    $arr_status = array(
        0 => __('draft'),
        3 => __('published')
    );
    ?>
    <div class="panel-body">
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <colgroup>
            <col width="5%">
            <col width="34%">
            <col width="18%">
            <col width="18%">
            <col width="10%">
            <col width="15%">
        </colgroup>
        <tr>
            <th>
                <input type="checkbox" id="chk_all" name="chk_check_all"/>
            </th>
            <th><?php echo __('title') ?></th>
            <th><?php echo __('init user') ?></th>
            <th><?php echo __('editor') ?></th>
            <th><?php echo __('begin date') ?></th>
            <th><?php echo __('status') ?></th>
        </tr>
        <?php for ($i = 0; $i < $n; $i++): ?>
            <?php
            $item = $arr_all_article[$i];
            ?>
            <tr>
                <td class="Center">
                    <input 
                        type="checkbox" name="chk_item[]" class="chk_item" id="item_<?php echo $i ?>" onclick="if (!this.checked)
                                                       this.form.chk_check_all.checked = false;"
                        value="<?php echo $item['PK_ARTICLE'] ?>"
                        />
                </td>
                <td>
                        <a href="javascript:;" onClick="row_onclick(<?php echo $item['PK_ARTICLE'] ?>)">
                            <?php echo $item['C_TITLE']; ?>
                        </a>
                
                </td>
                <td class="Center"><?php echo $item['C_INIT_USER_NAME'] ?></td>
                <td class="Center"><?php echo $item['C_SENSORER'] ? $item['C_SENSORER'] : '' ?></td>
                <td class="Center"><?php echo $item['C_BEGIN_DATE'] ?></td>
                <td class="Center status_<?php echo $item['C_STATUS'] ?>"><b><?php echo $arr_status[$item['C_STATUS']] ?></b></td>
            </tr>
        <?php endfor; ?>
        <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>

    </table>
    </div>
    </div>
    <div class="button-area" style="float:right;padding-top: 0;">
        <?php echo $this->paging2($arr_all_article); ?>
    </div>
</form>
<div class="clear"></div>
<?php show_insert_delete_button(); ?>


<script>
    toggle_checkbox('#chk_all', '.chk_item');
    $(document).ready(function(){
        $('#txt_bg_date').datetimepicker({
                format: 'D/M/YYYY' 
                //HH:mm:ss
        });
        $('#txt_ed_date').datetimepicker({
                format: 'D/M/YYYY'
                //HH:ss
        });
    });
    
    var is_advanced_search = <?php echo $v_advanced_search ?>;
    toggle_checkbox('#chk_all', '.chk');
    $(document).ready(function(){
        if(!is_advanced_search)
        {
            $('.advanced-search').toggle();
            $('.advanced-search input,.advanced-search select').attr('disabled', 1);
        }
        else
        {
            $('.search').toggle();
            $('.search input,.search select').attr('disabled', 1);
        }
        $('#btn-advanced-search').click(function(){
            $('.advanced-search').toggle('slow');
            $('.search').toggle('slow');
            var disabled_advanced = $('.advanced-search input,.advanced-search select').attr('disabled');
            $('.advanced-search input,.advanced-search select').attr('disabled', !disabled_advanced);
            $('.search input,.search select').attr('disabled', disabled_advanced);
            $('[name="txt_category"],[name="txt_category_2"]').attr('disabled', 1);
        });

    });
    function save_cache_onclick()
    {
        str = '<?php echo $this->get_controller_url(); ?>create_cache';
        $('#frmMain').attr('action',str).submit();
    }
    function show_category_svc()
    {
        $url = "<?php echo $this->get_controller_url('category', 'admin'); ?>dsp_all_category_svc/";
        $url += <?php echo Session::get('session_website_id'); ?> + '/';
        $url += '&enable_all=1&single_pick=1';
        showPopWin($url, 800, 600, function(obj){
            if(obj.length == 0)
            {
                $('#hdn_category').val(0);
                $('#frmMain').submit();
            }
            
            $('#txt_category').val(obj[0]['name']);
            $('#txt_category_2').val(obj[0]['name']);
            $('#hdn_category').val(obj[0]['id']);
            $('#frmMain').submit();
        });
    }
    function form_auto_submit()
    {
        $('#sel_go_to_page').val(1);
        $('#frmMain').submit();
    }
    
    window.row_onclick = function(article_id){
        var $controller = $('#controller').val();
        var $dsp_single = $('#hdn_dsp_single_method').val();
        var $url = $controller + $dsp_single + '/' + article_id;
        
        $('#frmMain').attr('action', $url);
        $('#frmMain').submit();
    }
    
    window.btn_delete_onclick = function(){
        $url = "<?php echo $this->get_controller_url() ?>" + "delete_article";
        if($('.chk_item:checked').length == 0)
        {
            alert("<?php echo __('you must choose atleast one object') ?>");
            return;
        }
        if(!confirm("<?php echo __('are you sure to delete all selected object?') ?>"))
        {
            return;
        }
        $.ajax({
            type: 'post',
            url: $url,
            data: $('#frmMain').serialize(),
            success: function(){window.location.reload();}
        });
    }
    
    $('select[name=sel_rows_per_page]').change(function(){
        $('#page_size').val($(this).val());
        $('#frmMain').submit();
    });
    $('select[name=sel_goto_page]').change(function(){
        $('#page_no').val($(this).val());
        $('#frmMain').submit();
    });
   
    $('#txt_title').keyup(function(e){
        if(e.keyCode == 13)
        {
            $('#txt_title').parents('form').submit();
        }
    });
    
   
    
</script>
