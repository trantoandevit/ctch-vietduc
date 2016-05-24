<?php
if (!defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
}


$this->_page_title = __('chi_tiet_linh_vuc_thong_ke');
$v_name = isset($arr_single_linh_vuc_thong_ke['C_NAME']) ? $arr_single_linh_vuc_thong_ke['C_NAME'] : '';
$v_linh_vuc_thong_ke_id = isset($arr_single_linh_vuc_thong_ke['PK_LINH_VUC_VAN_BAN']) ? $arr_single_linh_vuc_thong_ke['PK_LINH_VUC_VAN_BAN'] : 0;
$v_order = isset($arr_single_linh_vuc_thong_ke['C_ORDER']) ? $arr_single_linh_vuc_thong_ke['C_ORDER'] : '';
$v_status = isset($arr_single_linh_vuc_thong_ke['C_STATUS']) ? $arr_single_linh_vuc_thong_ke['C_STATUS'] : '';
?>

<form class="form-horizontal" name="frmMain" id="frmMain" method="post" action="<?php echo $this->get_controller_url() . 'update_linh_vuc_thong_ke'; ?>">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_linh_vuc_thong_ke');
    echo $this->hidden('hdn_dsp_all_method', 'qry_all_linh_vuc_thong_ke');
    echo $this->hidden('hdn_update_method', 'update_linh_vuc_thong_ke');
    echo $this->hidden('hdn_delete_method', 'delete_linh_vuc_thong_ke');

    echo $this->hidden('hdn_item_id_list', '');
    echo $this->hidden('hdn_item_id', $v_linh_vuc_thong_ke_id);
    echo $this->hidden('XmlData', '');
//Luu dieu kien loc
    ?>
    <h1 class="page-header"><?php echo __('linh_vuc_thong_ke_detail'); ?></h1>
    <div>
        <div class=" panel-default">

            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('ten_linh_vuc_thong_ke'); ?> <label class="required">(*)</label></label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_name" id="txt_name" value="<?php echo $v_name; ?>" 
                               class="form-control" maxlength="255"
                               data-allownull="no" data-validate="text" data-name="<?php echo __('ten_linh_vuc_thong_ke'); ?>" 
                               data-xml="no" data-doc="no" 
                               />
                    </div>
                </div>
          
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('order') ?> <label class="required">(*)</label></label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_order" id="txt_order" value="<?php echo $v_order; ?>" 
                               class="form-control" maxlength="255"
                               data-allownull="yes" data-validate="unsignNumber"  data-name="<?php echo __('order'); ?>" 
                               data-xml="no" data-doc="no" 
                               />
                    </div>
                </div>
             
                <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                    <div class="col-sm-9">
                        
                        <label><input type="checkbox" name="chk_status" id="chk_status" <?php echo ($v_status == 1) ? 'checked' : ''; ?> /> <?php echo __('active status') ?></label>
                    </div>
                </div>

            </div>
        </div>

        <label class="required" id="message_err"></label>

        <div class="button-area">
            <button type="button" class="btn btn-outline btn-success" name="btn_update" id="btn_update" onclick="btn_update_onclick()"> 
                <i class="fa fa-check fa-fw"></i> <?php echo __('update'); ?>
            </button>
            <button type="button" class="btn btn-outline btn-warning" name="btn_back" id="btn_cancel" onclick="btn_back_onclick()">
                <i class="fa fa-reply fa-fw"></i> <?php echo __('go back'); ?>
            </button>
        </div>
    </div>
</form>

