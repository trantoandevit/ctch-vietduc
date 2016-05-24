<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<?php
//header
@session::init();

$this->_page_title = __('danh_sach_co_quan_ban_hanh');

$arr_img_ext = explode(',', strtolower(EXT_IMAGE));
?>
<h1 class="page-header"><?php echo __('danh_sach_co_quan_ban_hanh'); ?></h1>

<form action="<?php $this->get_controller_url();?>" name="frmMain" id="frmMain" method="POST">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', '0');
    echo $this->hidden('hdn_item_id_list', '');
    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_co_quan_ban_hanh');
    echo $this->hidden('hdn_dsp_all_method', 'qry_all_co_quan_ban_hanh');
    echo $this->hidden('hdn_update_method', 'update_co_quan_ban_hanh');
    echo $this->hidden('hdn_delete_method', 'delete_co_quan_ban_hanh');
    ?>
    

        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <colgroup>
                        <col width="5%" />
                        <col width="10%" />
                        <col width="*" />
                        <col width="10%" />
                    </colgroup>
                    <tr>
                        <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                        <th><?php echo __('order'); ?></th>
                        <th><?php echo __('ten_co_quan_ban_hanh'); ?></th>
                        <th><?php echo __('status'); ?></th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <?php $row = 0; ?>
                        <?php foreach ($arr_all_co_quan_ban_hanh as $arr_row): ?>
                            <tr>
                                <td class="Center">
                                    <input type="checkbox" name="chk"
                                           value="<?php echo $arr_row['PK_CO_QUAN_BAN_HANH']; ?>" 
                                           onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                                           />
                                </td>
                                <td style="text-align:center" align="center">
                                     <?php echo $arr_row['C_ORDER']; ?>
                                </td>
                                <td style="text-align:center" align="center">
                                        <a href="javascript:void(0)" onclick="row_onclick(<?php echo $arr_row['PK_CO_QUAN_BAN_HANH']; ?>)">  
                                            <?php echo $arr_row['C_NAME']; ?>
                                        </a>
                                </td>
                                <td style="text-align:center" align="center">
                                    <?php echo ($arr_row['C_STATUS'] == 1) ? __('display') : __('display none'); ?>
                                </td>
                            </tr>
                            <?php $row = ($row == 1) ? 0 : 1; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    
    
    <?php //echo $this->paging2($arr_all_co_quan_ban_hanh); ?>
    <div class="button-area">

        <button type="button" name="addnew" class="btn btn-outline btn-primary" onclick="btn_addnew_onclick();">
            <i class="fa fa-plus"></i> <?php echo __('add new'); ?>
        </button>
        <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();" style="margin-left:10px;">
            <i class="fa fa-times"></i> <?php echo __('delete'); ?> 
        </button>
        
        <?php if (get_system_config_value(CFGKEY_CACHE) == 'true'): ?>
            <button type="button" name="trash" class="btn btn-outline btn-success" onClick="btn_cache_onclick();" style="margin-left:10px;">
                <i class="fa fa-save"></i> <?php echo __('save cache');?>
            </button>
        <?php endif;?>
    </div>
</form>

<?php
//$this->template->display('dsp_footer.php');