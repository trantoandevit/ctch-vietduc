<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<?php
//header
@session::init();

$this->_page_title = __('danh_sach_van_ban');

$arr_img_ext    = explode(',', strtolower(EXT_IMAGE));
$v_cqbh         = get_request_var('sel_cqbh','');
$v_lvtk         = get_request_var('sel_lvtk','');
$v_loai_vb      = get_request_var('sel_loai_vb','');

?>
<style>
    .pager
    {
        padding: 0;
        margin:0;
    }
</style>
<h1 class="page-header"><?php echo __('danh_sach_van_ban'); ?></h1>

<form action="<?php $this->get_controller_url();?>" name="frmMain" id="frmMain" method="POST">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', '0');
    echo $this->hidden('hdn_item_id_list', '');
    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_van_ban');
    echo $this->hidden('hdn_dsp_all_method', 'qry_all_van_ban');
    echo $this->hidden('hdn_update_method', 'update_van_ban');
    echo $this->hidden('hdn_delete_method', 'delete_van_ban');
    ?>
    <style>
        .block
        {
            padding: 0;
            margin: 0;
        }
    </style>

        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-sm-3 block">Lĩnh vực thống kê</label>
                <div class="col-sm-5 block">
                    <select name="sel_lvtk" id="sel_lvtk" class="form-control ">
                        <option value="">-- Lĩnh vực thống kê --</option>
                        <?php foreach ($arrStatistics as $key => $Statistics) : ?>
                            <?php $selected = ($v_lvtk == $Statistics['PK_LINH_VUC_VAN_BAN']) ? "selected='selected'" : ''; ?>
                            <option  <?php echo $selected; ?> value="<?php echo $Statistics['PK_LINH_VUC_VAN_BAN'] ?>"><?php echo $Statistics['C_NAME'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-4">&nbsp;</div>
             </div>
            <div class="clear" style="height: 10px;"></div>
            <div class="form-group">
                    <label class="control-label col-sm-3 block">Loại văn bản</label>
                    <div class="col-sm-5 block">
                        <select name="sel_loai_vb" id="sel_loai_vb" class="form-control ">
                            <option value="">-- Loại văn bản --</option>
                            <?php foreach ($arrDocType as $col => $DocType) : ?>
                                <?php $selected = ($v_loai_vb == $DocType['C_LOAI_VAN_BAN']) ? "selected='selected'" : ''; ?>
                            <option <?php echo $selected;  ?> value="<?php echo $DocType['C_LOAI_VAN_BAN'] ?>"><?php echo $DocType['C_LOAI_VAN_BAN'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-4"></div>
            </div>
            <div class="clear" style="height: 10px;"></div>
            
            <div class="form-group">
                <label class="control-label col-sm-3 block">Cơ quan ban hành</label>
                       <div class="col-sm-5 block ">
                           <select name="sel_cqbh" id="sel_cqbh" class="form-control ">
                               <option value="">-- Cơ quan ban hành --</option>
                               <?php foreach ($arrOrganization as $k => $Organization) : ?>
                                   <?php $selected = ($v_cqbh == $Organization['PK_CO_QUAN_BAN_HANH']) ? "selected='selected'" : ''; ?>
                                   <option <?php echo $selected; ?> value="<?php echo $Organization['PK_CO_QUAN_BAN_HANH'] ?>"><?php echo $Organization['C_NAME'] ?></option>
                               <?php endforeach; ?>
                           </select>
                       </div>
                 <div class="col-sm-4">&nbsp;</div>
            </div>
            <div class="clear" style="height: 10px;"></div>
            
            <div class="form-group">
                <label class="control-label col-sm-3 block">Từ khóa</label>
                <div class="col-sm-5 block">
                    <input type="text" class="form-control" value="<?php echo get_request_var('txt_title','')?>" id="txt_title" name="txt_title" placeholder="Tiêu đề/Số hiệu văn bản"></div>
                <div class="col-sm-4 no-padding">
                    <button type="submit" class="btn btn_submit">Tìm kiếm</button>
                    <button type="reset" class="btn btn_submit" onclick="fc_reset_form()">Xóa điều kiện lọc</button>
                </div>
            </div>
            <div class="clear" style="height: 10px;"></div>
            
            
                
                
                
                
            
            <div class="clear" style="height: 10px;"></div>


            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <colgroup>
                            <col width="5%" />
                            <col width="*" />
                            <col width="10%" />
                            <col width="10%" />
                            <col width="10%" />
                            <col width="10%" />
                            <col width="10%" />
                            <col width="10%" />
                            <col width="10%" />
                            <col width="10%" />
                        </colgroup>
                        <tr>
                            <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                            <th><?php echo __('ten_van_ban'); ?></th>
                            <th><?php echo __('so_hieu'); ?></th>
                            <th><?php echo __('co_quan_ban_hanh'); ?></th>
                            <th><?php echo __('linh_vuc_thong_ke'); ?></th>
                            <th><?php echo __('loai_van_ban'); ?></th>
                            <th><?php echo __('status'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row = 0; $arr_all_van_ban = is_array($arr_all_van_ban) ? $arr_all_van_ban : array();  ?>
                        <?php foreach ($arr_all_van_ban as $arr_row): ?>
                            <tr>
                                <td class="Center">
                                    <input type="checkbox" name="chk"
                                           value="<?php echo $arr_row['PK_VAN_BAN']; ?>" 
                                           onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                                           />
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="row_onclick(<?php echo $arr_row['PK_VAN_BAN']; ?>)">  
                                        <?php echo $arr_row['C_TITLE']; ?>
                                    </a>
                                    
                                </td>
                                <td style="text-align:center" align="center">
                                     <?php echo $arr_row['C_SO_HIEU_VAN_BAN']; ?>
                                </td>
                                <td style="text-align:center" align="center">
                                     <?php echo $arr_row['C_NAME_CO_QUAN_BAN_HANH']; ?>
                                </td>
                                <td style="text-align:center" align="center">
                                     <?php echo $arr_row['C_NAME_LINH_VUC_BAN_HANH']; ?>
                                </td>
                                <td style="text-align:center" align="center">
                                     <?php echo $arr_row['C_LOAI_VAN_BAN']; ?>
                                </td>
                                <td style="text-align:center" align="center">
                                     <?php echo ($arr_row['C_STATUS'] == 1) ? __('display') : __('display none'); ?>
                                </td>
                            </tr>
                            <?php $row = ($row == 1) ? 0 : 1; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                 <!-- /.table-responsive -->
                <div class="button-area" style="float:right;padding-top: 0;">
                    <?php 
                    $arr_all_van_ban[0]['TOTAL_RECORD'] = isset($arr_all_van_ban[0]['TOTAL_RECORD']) ? $arr_all_van_ban[0]['TOTAL_RECORD'] : 0;
                    echo $this->paging2($arr_all_van_ban);
                    ?>
                </div>
            </div>
           
        </div>
        <!-- /.panel-body -->
        
    
    <?php //echo $this->paging2($arr_all_van_ban); ?>
    <div class="button-area">

        <button type="button" name="addnew" class="btn btn-outline btn-primary" onclick="btn_addnew_onclick();">
            <i class="fa fa-plus"></i> <?php echo __('add new'); ?>
        </button>
        <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();" style="margin-left:10px;">
            <i class="fa fa-times"></i> <?php echo __('delete'); ?> 
        </button>
    </div>
</form>
<script>

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
    function fc_reset_form()
    {
        $('#sel_cqbh option').removeAttr('selected','');
        $('#sel_lvtk option').removeAttr('selected','');
        $('#sel_loai_vb option').removeAttr('selected','');
        $('#txt_title').attr('value','');
    }
</script>