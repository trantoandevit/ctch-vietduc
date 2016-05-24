<?php if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
} ?>
<?php
//header
//@session::init();
$this->template->title = __('office info list');
$this->template->display('dsp_header.php');


?>
<h2 class="module_title"><?php echo __('office info list'); ?></h2>
<form name="frmMain" id="frmMain" action="" method="POST">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', 0);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_office_info');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_office_info');
    echo $this->hidden('hdn_update_method', 'update_office_info');
    echo $this->hidden('hdn_delete_method', 'delete_office_info');
    ?>
    <!--lay danh sach tat ca thong tin toa soan-->
    <table width="100%" class="adminlist" cellspacing="0" border="1">
        <colgroup>
            <col width="5%" />
            <col width="45%" />
            <col width="15%" />
            <col width="15%" />
            <col width="10%" />
            <col width="10%" />
        </colgroup>
        <tr>
            <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
            <th><?php echo __('title'); ?></th>
            <th><?php echo __('begin date'); ?></th>
            <th><?php echo __('end date'); ?></th>
            <th><?php echo __('status'); ?></th>
            <th><?php echo __('default'); ?></th>
        </tr>
        <?php for ($i = 0; $i < count($arr_all_office_info); $i++):
                $arr_office_info = $arr_all_office_info[$i];
        
                $v_id            = $arr_office_info['PK_OFFICE_INFO'];
                $v_art_id        = $arr_office_info['FK_ARTICLE'];
                $v_website_id    = $arr_office_info['FK_WEBSITE'];
                $v_name          = $arr_office_info['C_NAME'];
                
                $v_status        = $arr_office_info['C_STATUS'];
                $v_status = ($v_status == 1)?__('display'):__('display none');
                
                $v_type          = $arr_office_info['C_TYPE'];
                $v_type = ($v_type == 1)?__('display'):__('display none');
                
                
                $v_begin_date    = $arr_office_info['C_BEGIN_DATE'];
                $v_end_date      = $arr_office_info['C_END_DATE'];
        ?>
        <tr class="row<?php echo $i % 2 ?>">
                <td>
                    <input type="checkbox" name="chk"
                           value="<?php echo $v_id; ?>" 
                           onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                           />
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="row_onclick(<?php echo $v_id; ?>)"><?php echo $v_name; ?></a>
                </td>
                <td><?php echo $v_begin_date?></td>
                <td><?php echo $v_end_date?></td>
                <td><?php echo $v_status;?></td>
                <td><?php echo $v_type?></td>
        </tr>
        <?php endfor; ?>
<?php $n   = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
<?php for ($i; $i < $n; $i++): ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
<?php endfor; ?>
    </table>
    <?php echo $this->paging2($arr_all_office_info); ?>
    <div class="button-area">
        <?php if(session::check_permission('THEM_MOI_THONG_TIN',0)==TRUE):?>
        <input type="button" name="addnew" class="ButtonAdd" value="<?php echo __('add new'); ?>" onclick="btn_addnew_onclick();"/>
        <?php endif;?>
        
        <?php if(session::check_permission('XOA_THONG_TIN',0)==TRUE):?>
        <input type="button" name="trash" class="ButtonDelete" value="<?php echo __('delete'); ?>" onclick="btn_delete_onclick();"/>
        <?php endif;?>
        
    </div>
</form>
<?php
$this->template->display('dsp_footer.php');