<?php
defined('DS') or die('no direct access');
$this->_page_title =  __('photo gallery');
$v_begin_date          = get_request_var('txt_begin_date', '');
$v_end_date            = get_request_var('txt_end_date', '');
$v_status              = intval(get_request_var('sel_status', -1));
$v_init_user           = intval(get_request_var('sel_init_user', 0));
$v_keyword             = get_request_var('txt_keyword', '');
$v_title               = get_request_var('txt_title');
$arr_status            = array(
    0 => __('draft'),
    3 => __('published')
);

$v_advanced_search = 'false';
if ($v_begin_date or $v_end_date or ($v_status != -1) or $v_keyword or $v_init_user)
{
    $v_advanced_search = 'true';
}

function show_insert_delete_button()
{
    $html = '<div class="button-area">';

        $html .= '<input type="button" class="ButtonAdd" onClick="row_onclick(0);" value="' . __('add new') . '"></input>';

        $html .= '<input type="button" class="ButtonDelete" onClick="btn_delete_onclick(\'hdn_id_list\');" value="' . __('delete') . '"></input>';
    
    
    if (get_system_config_value(CFGKEY_CACHE) == 'true')
    {
        $html .= '<input type="button" class="ButtonAccept" onclick="save_cache_onclick();" value="' . __('save cache') . '"></input>';
    }
    
    $html .= '</div>';
    echo $html;
}
?>
<h1 class="page-header" style="font-size: 32px;"><?php echo __('photo gallery'); ?></h1>
<?php
echo $this->hidden('controller', $this->get_controller_url());
echo $this->hidden('hdn_dsp_all_method', 'dsp_all_article');
echo $this->hidden('hdn_item_id', '');
echo $this->hidden('XmlData', '');
?>
<form name="frm_filter" id="frm_filter" style="overflow: hidden;" method="post" action="" autocomplete="off">
    <input 
        type="hidden" name="sel_rows_per_page" id="page_size" 
        value="<?php echo get_post_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE) ?>"
        />
    <input 
        type="hidden" name="sel_goto_page" id="page_no" 
        value="<?php echo get_post_var('sel_go_to_page', 1) ?>"
        />
    <input 
        type="button" class="ButtonSearch" id="btn-advanced-search" 
        value="<?php echo __('advanced search') ?>" style="font-weight: bold;"
        />
    <table class="advanced-search">
        <colgroup>
            <col width="15%" />
            <col width="35%" />
            <col width="15%" />
            <col width="35%" />
        </colgroup>
        <tr>
            <td><?php echo __('publish time range') ?></td>
            <td>
                <?php echo __('begin date') ?>
                <input type="text" name="txt_begin_date" id="txt_begin_date" value="<?php echo $v_begin_date; ?>" 
                       class="inputbox" maxlength="255" style="width:50%" 
                       data-allownull="yes" data-validate="date" data-name="<?php echo __('begin date'); ?>" 
                       data-xml="no" data-doc="no" onclick="DoCal('txt_begin_date');"
                       />
                <img 
                    height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/calendar.png"
                    onClick="$('#txt_begin_date').focus();"
                    />
            </td>
            <td><?php echo __('end date'); ?></td>
            <td>
                <input type="text" name="txt_end_date" id="txt_end_date" value="<?php echo $v_end_date; ?>" 
                       class="inputbox" maxlength="255" style="width:50%" 
                       data-allownull="yes" data-validate="date" data-name="<?php echo __('end date'); ?>" 
                       data-xml="no" data-doc="no" onClick="DoCal('txt_end_date');"
                       /> 
                <img 
                    height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/calendar.png"
                    onClick="DoCal('txt_end_date');"
                    />
            </td>
        </tr>
        <tr>
            <td><?php echo __('status') ?></td>
            <td>
                <select name="sel_status" id="sel_status" onChange="form_auto_submit();">
                    <option value="-1"> -- <?php echo __('all') ?> -- </option>
                    <option value="0"><?php echo __('draft') ?></option>
                    <option value="3"><?php echo __('published') ?></option>
                </select>
                <script>$('#sel_status option[value=<?php echo $v_status ?>]').attr('selected', '1');</script>
            </td>
            <td></td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo __('init user') ?>
            </td>
            <td colspan="3">
                <select name="sel_init_user" id="sel_init_user" onChange="form_auto_submit();">
                    <option value="0"> -- <?php echo __('all') ?> -- </option>
                    <?php foreach ($arr_all_user as $item): ?>
                        <option value="<?php echo $item['PK_USER']; ?>">
                            <?php echo $item['C_NAME'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <script>$('#sel_init_user').val(<?php echo $v_init_user ?>);</script>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo __('keywords'); ?>
            </td>
            <td colspan="3">
                <input type="text" name="txt_keyword" id="txt_category" value="<?php echo $v_keyword; ?>" 
                       class="inputbox" maxlength="255" style="width:50%" 
                       data-allownull="yes" data-validate="text" data-name="<?php echo __('keywords'); ?>" 
                       data-xml="no" data-doc="no" 
                       /> 
                <input type="submit" class="ButtonSearch" value="<?php echo __('search') ?>"/>
            </td>
        </tr>
    </table>
    <div class="clear"></div>
    <div style="float:right" class="search">
        <label><?php echo __('title') ?></label>
        <input 
            type="text" name="txt_title" id="txt_title" 
            value="<?php echo $v_title ?>" size="50"
            />
        <input type="submit" class="ButtonSearch" value="<?php echo __('search') ?>"/>

    </div>
    <div class="clear"></div>

</form>
<?php show_insert_delete_button(); ?>
<form name="frmMain" id="frmMain" action="#" method="post">
    <table width="100%" class="adminlist" cellspacing="0" border="1">
        <colgroup>
            <col width="5%">
            <col width="45%">
            <col width="20%">
            <col width="15%">
            <col width="15%">
        </colgroup>
        <tr>
            <th><input type="checkbox" name="chk_all" id="chk_all"/></th>
            <th><?php echo __('title') ?></th>
            <th><?php echo __('author') ?></th>
            <th><?php echo __('begin date') ?></th>
            <th><?php echo __('status') ?></th>
        </tr>
        <?php $n = count($arr_all_gallery); ?>
        <?php for ($i = 0; $i < $n; $i++): ?>
            <?php
            $item         = $arr_all_gallery[$i];
            $v_item_id    = $item['PK_PHOTO_GALLERY'];
            $v_title      = $item['C_TITLE'];
            $v_status     = $arr_status[$item['C_STATUS']];
            $v_begin_date = $item['C_BEGIN_DATE'];
            $v_author     = $item['C_INIT_USER_NAME'];
            ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td class="Center" >
                    <input
                        type="checkbox" name="chk_item[]" class="chk_item"
                        value="<?php echo $v_item_id; ?>"
                        />
                </td>
                <td>
                    <a href="javascript:;" onClick="row_onclick(<?php echo $v_item_id ?>)">
                        <?php echo $v_title ?>
                    </a>
                </td>
                <td class="Center"><?php echo $v_author ?></td>
                <td class="Center"><?php echo $v_begin_date ?></td>
                <td class="Center status_<?php echo $item['C_STATUS'] ?>"><b><?php echo $v_status ?></b></td>
            </tr>
        <?php endfor; ?>
        <?php $n            = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
        <?php for ($i; $i < $n; $i++): ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endfor; ?>
    </table>
</form>
<div class="button-area" style="float:right;padding-top: 0;">
    <?php echo $this->paging2($arr_all_gallery); ?>
</div>
<div class="clear"></div>
<?php show_insert_delete_button(); ?>

<script>
    toggle_checkbox('#chk_all', '.chk_item');
    var is_advanced_search = <?php echo $v_advanced_search ?>;
    var SITE_ROOT = "<?php echo SITE_ROOT ?>";    
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
        function form_auto_submit()
        {
            $('#sel_go_to_page').val(1);
            $('#frm_filter').submit();
        }
    });
    
    function form_auto_submit()
    {
        $('#sel_go_to_page').val(1);
        $('#frm_filter').submit();
    }
    
    window.row_onclick = function(article_id){
        var $controller = $('#controller').val();
        var $dsp_single = 'dsp_single_gallery';
        var $url = $controller + $dsp_single + '/' + article_id;
        
        $('#frm_filter').attr('action', $url);
        $('#frm_filter').submit();
    }
    
    window.btn_delete_onclick = function(){
        var $controller = $('#controller').val();
        var $url = $controller + 'delete_gallery';
        if($('.chk_item:checked').length == 0)
        {
            alert("<?php echo __('you must choose atleast one object') ?>");
            return;
        }
        if(!confirm('<?php echo __('are you sure to delete all selected object?') ?>'))
        {
            return;
        }
        
        $.ajax({
            type:'post',
            url: $url,
            data: $('#frmMain').serialize(),
            success: function(){
                $('#frm_filter').submit();
            }
        });
    }
    
    $('select[name=sel_rows_per_page]').change(function(){
        $('#page_size').val($(this).val());
        $('#frm_filter').submit();
    });
    $('select[name=sel_goto_page]').change(function(){
        $('#page_no').val($(this).val());
        $('#frm_filter').submit();
    });
    
    $('#txt_title').keyup(function(e){
        if(e.keyCode == 13)
        {
            $('#txt_title').parents('form').submit();
        }
    });
    
    function btn_cache_onclick(){
        $url = "<?php echo $this->get_controller_url() ?>write_cache";
        $(window.frm_filter).attr('action', $url).submit();
    }

    function save_cache_onclick()
    {
        str = '<?php echo $this->get_controller_url(); ?>create_cache';
        $('#frmMain').attr('action',str).submit();
    }
</script>

