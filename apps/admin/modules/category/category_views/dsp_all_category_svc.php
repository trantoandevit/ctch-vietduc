<?php
defined('DS') or die('no direct access');

$enable_all = get_request_var('enable_all') ? true : false;

$this->_page_title = __('category');

$v_single_pick = get_request_var('single_pick','0');
?>

<?php

function show_button()
{
    $html      = '<div class="button-area">';
    $html .= '<button type="button" class="btn btn-outline btn-success" onClick="return_func();" style="margin-right:10px"><i class="fa fa-check"></i> ' . __('select') . '</button>';
    $html .= '<button type="button" class="btn btn-outline btn-danger" onClick="window.parent.hidePopWin(false);"><i class="fa fa-times"></i> ' . __('cancel') . '</button>';
    $html .= '</div>';
    echo $html;
}
?>

<!--<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header"><?php echo __('category'); ?></h4>
    </div>
     /.col-lg-12 
</div>-->
<?php
$v_disable = $website_id == 0 ? '' : 'disabled';
?>
<select id="sel_website" style="width:50%;" class="form-control" onChange="reload_page(this.value);" <?php echo $v_disable ?>>
    <option value="0"> -- <?php echo __('category') ?> -- </option>
    <?php foreach ($arr_all_website as $val): ?>
        <option value="<?php echo $val['PK_WEBSITE']; ?>"><?php echo $val['C_NAME'] ?></option>
    <?php endforeach; ?>
    <script>$('#sel_website option[value=<?php echo $website_id ?>]').attr('selected', 1);</script>
</select>

<?php show_button(); ?>
<form name="frmMain" id="frmMain" method="post" class="form-horizontal">
    <div style="height:300px;overflow: scroll;overflow-x: hidden;">
        <button type="button" class="btn btn-outline btn-danger" onClick="not_select_category_onclick();">
            <i class="fa fa-times"></i> <?php echo __('not select category')?>
        </button>
        <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <colgroup>
                    <col width="10%" />
                    <col width="90%" />
                </colgroup>
                <tr>
                    <?php if($v_single_pick != '0'):?>
                    <th>&nbsp;</th>
                    <?php else:?>
                    <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                    <?php endif;?>
                    <th><?php echo __('category'); ?></th>
                </tr>
                <?php if (count($arr_all_category) == 0): ?>
                    <tr>
                        <td class="Center" colspan="2">
                            <b><?php echo __('there are no record') ?></b>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php $n = count($arr_all_category); ?>
                <?php for ($i = 0; $i < $n; $i++): ?>
                    <?php
                    $item      = $arr_all_category[$i];
                    $v_id      = $item['PK_CATEGORY'];
                    $v_name    = $item['C_NAME'];
                    $v_slug    = $item['C_SLUG'];
                    $v_disable = ($item['C_STATUS'] == 0 && $enable_all == false) ? 'disabled' : '';
                    $v_level   = strlen($item['C_INTERNAL_ORDER']) / 3 - 1;
                    $v_indent  = '';

                    for ($j = 0; $j < $v_level; $j++)
                    {
                        $v_indent .= ' -- ';
                    }
                    ?>
                    <tr>
                        <td class="Center">
                            <input
                                type="checkbox" name="chk" class="chk-item"
                                value="<?php echo $v_id ?>"
                                id="item_<?php echo $v_id ?>"
                                data-name="<?php echo $v_name ?>"
                                data-slug="<?php echo $v_slug ?>"
                                <?php echo $v_disable; ?>
                                />
                        </td>
                        <td>
                            <label for="item_<?php echo $v_id ?>">
                                <?php echo $v_indent . $v_name ?>
                            </label>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
            </div>
        </div>
    </div>
</form>
<?php show_button() ?>

<script>
    toggle_checkbox('#chk-all', '.chk-item');
    function reload_page(website_id)
    {
        var url = "<?php echo $this->get_controller_url(); ?>dsp_all_category_svc/" + website_id;
        window.location = url;
        return;
    }
    
    function return_func()
    {
        var a = [];
        $('.chk-item:checked').each(function(){
            var v_id = $(this).val();
            var v_name = $(this).attr('data-name');
            var v_slug = $(this).attr('data-slug');
            
            a.push({id: v_id, name: v_name, slug: v_slug});
        });
        returnVal = a;
        window.parent.hidePopWin(true);
    }
    
    function not_select_category_onclick(chk_not_select)    
    {
        $('.chk-item:checked').removeAttr('checked');
    }
    
    //single pick onclick
    <?php if($v_single_pick != '0'):?>
        $('[name="chk-item[]"]').click(function (){
            cur_chk = $(this);
            $('[name="chk-item[]"]:checked').each(function (){
                 if($(this).val() != $(cur_chk).val())
                 {

                     $(this).removeAttr('checked');
                 }
            });
         });
    <?php endif;?>
</script>