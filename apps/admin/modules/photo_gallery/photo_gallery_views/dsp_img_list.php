<?php
defined('DS') or die('no direct access');

function show_insert_delete_button()
{
    $html = '<div class="button-area">';
    if (Session::check_permission('SUA_TIN_ANH'))
    {
        $html .= '<input type="button" class="ButtonAdd" onClick="row_onclick(0);" value="' . __('add new') . '"></input>';
        $html .= '<input type="button" class="ButtonDelete" onClick="btn_delete_onclick();" value="' . __('delete') . '"></input>';
        $html .= '<input type="button" class="ButtonBack" onClick="btn_back_onclick()" value="' . __('goback to list') . '"/>';
    }
    $html .= '</div>';
    echo $html;
}
?>
<?php show_insert_delete_button(); ?>
<form name="frm_img_list" id="frm_img_list" action="#" method="post">
    <table width="100%" class="adminlist" cellspacing="0" border="1">
        <colgroup>
            <col width="5%">
            <col width="80%">
            <col width="15%">
        </colgroup>
        <tr>
            <th><input type="checkbox" id="chk_all_img"/></th>
            <th><?php echo __('image list') ?></th>
            <th><?php echo __('order') ?></th>
        </tr>
        <?php $n = count($arr_all_image); ?>
        <?php if ($n == 0): ?>
            <tr>
                <td colspan="3" class="Center">
                    <b><?php echo __('there are no record') ?></b>
                </td>
            </tr>
        <?php endif; ?>
        <?php for ($i = 0; $i < $n; $i++): ?>
            <?php
            $item      = $arr_all_image[$i];
            $v_item_id = $item['PK_PHOTO_GALLERY_DETAIL'];
            $v_prev    = isset($arr_all_image[$i - 1]) ? $arr_all_image[$i - 1]['PK_PHOTO_GALLERY_DETAIL'] : 0;
            $v_next    = isset($arr_all_image[$i + 1]) ? $arr_all_image[$i + 1]['PK_PHOTO_GALLERY_DETAIL'] : 0;
            ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td class="Center">
                    <input 
                        type="checkbox" name="chk_img[]" class="chk_img" 
                        id="img_<?php echo $i ?>" value="<?php echo $v_item_id ?>"
                        />
                </td>
                <td>
                    <a href="javascript:;" onClick="row_onclick(<?php echo $v_item_id ?>);">
                        <img 
                            height="24" width="32" 
                            src="<?php echo SITE_ROOT . 'upload/' . $item['C_FILE_NAME'] ?>"
                            />
                            <?php echo basename($item['C_FILE_NAME']) ?>
                    </a>
                </td>
                <td class="Center">
                    <?php if ($v_prev): ?>
                        <img 
                            height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/up.png"
                            onClick="swap_order(<?php echo $v_item_id; ?>, <?php echo $v_prev ?>)"
                            />
                        <?php endif; ?>
                        <?php if ($v_next): ?>
                        <img 
                            height="16" width="16" src="<?php echo SITE_ROOT ?>public/images/down.png"
                            onClick="swap_order(<?php echo $v_item_id; ?>, <?php echo $v_next ?>)"
                            />
                        <?php endif; ?>
                </td>
            </tr>
        <?php endfor; ?>
        <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
        <?php for ($i; $i < $n; $i++): ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endfor; ?>
    </table>
</form>
<?php show_insert_delete_button(); ?>
<script>
    toggle_checkbox('#chk_all_img', '.chk_img');
    function row_onclick($item_id){
        $url = "<?php echo $this->get_controller_url() ?>" + 'dsp_single_image/' + $item_id;
        $.ajax({
            type: 'post',
            url: $url,
            data: {gallery_id: <?php echo $v_id ?>},
            success: function($html){
                $('#frm_img_list').parent().html($html);
            }
        });
    }
    
    function swap_order($item1, $item2)
    {
        $url = "<?php echo $this->get_controller_url() ?>" + 'swap_image_order/';
        $.ajax({
            type: 'post',
            url: $url,
            data: {item1: $item1, item2: $item2},
            success: function(){
                reload_current_tab();
            }
        });
    }
    
    window.btn_delete_onclick = function(){
        if($('.chk_img:checked').length == 0)
        {
            alert("<?php echo __('you must choose atleast one object') ?>");
            return;
        }
        if(!confirm('<?php echo __('are you sure to delete all selected object?') ?>'))
        {
            return;
        }
        $url = "<?php echo $this->get_controller_url() ?>" + 'delete_image';
        
        $.ajax({
            type: 'post',
            url: $url,
            data: $('#frm_img_list').serialize(),
            success: function(){
                reload_current_tab();
            }
        });
            
    }
</script>