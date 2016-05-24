<?php
if (!defined('SERVER_ROOT')) {
    exit('No direct script access allowed');
}
?>
<?php
//$this->template->title = __('manager citizen account');
//$this->template->display('dsp_header.php');

//filter
$v_filter_username = get_post_var('txt_username','');
$v_filter_email    = get_post_var('txt_email','');
$v_filter_name     = get_post_var('txt_name','');
$v_filter_address  = get_post_var('txt_address','');
$v_filter_status   = get_post_var('sel_status','');
$v_filter_organize = get_post_var('sel_organize','');

$count_account_overduce_confirm = isset($count_account_overduce_confirm)? $count_account_overduce_confirm : 0;
?>

<h1 class="page-header" style="font-size: 32px;"><?php echo __('all citizen'); ?></h1>
<form name="frmMain" id="frmMain" action="" method="POST">
<?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', 0);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_account');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_account');
    echo $this->hidden('hdn_delete_method', 'delete_account');
    echo $this->hidden('hdn_count_overdue_confirm', $count_account_overduce_confirm);
?>
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <b><?php echo __('search'); ?></b>
        </div>
        <div class="panel-body">
            
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-12">               
                    <div class="col-lg-2"><label><?php echo __('username'); ?>:</label></div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control"  name="txt_username" id="txt_username" value="<?php echo $v_filter_username ?>" />
                    </div>
                    <div class="col-lg-1"><label><?php echo __('email'); ?>:</label></div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control"  name="txt_email" id="txt_email" value="<?php echo $v_filter_email ?>" />
                    </div>
                </div>
            </div><!--End username-->
            
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-12">
                    <div class="col-lg-2"><label><?php echo __('full name'); ?>:</label></div>
                    <div class="col-lg-5">
                        <input type="text" class="form-control" name="txt_name" id="txt_name" value="<?php echo $v_filter_name ?>"/>
                    </div>
                </div>
            </div>
            <!--End full name-->
            
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-12">
                    <div class="col-lg-2"><label><?php echo __('address'); ?>:</label></div>
                    <div class="col-lg-5">
                        <input type="text" class="form-control" name="txt_address" id="txt_address" value="<?php echo $v_filter_address ?>" />
                    </div>
                </div>
            </div>    
            <!--End address-->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-2"><label><?php echo __('status');?>:</label></div>
                    <div class="col-lg-4">
                        <select class="form-control" name="sel_status" id="sel_status">
                            <option value=""> -- <?php echo __('all'); ?> --</option>
                            <option value="0" <?php echo ($v_filter_status == '0')?'selected':'';?> > Đã khóa</option>
                            <option value="1" <?php echo ($v_filter_status == '1')?'selected':'';?>> Hoạt động</option>
                            <option value="-1" <?php echo ($v_filter_status == '-1')?'selected':'';?>> Chưa kích hoạt</option>
                        </select>
                    </div>
  
                    <div class="col-lg-1"><label style="float:right;"><?php echo __('organize');?>:</label></div>
                     <div class="col-lg-4">
                         <select class="form-control" name="sel_organize" id="sel_organize">
                             <option value=""> -- <?php echo __('all'); ?> --</option>
                             <option value="0" <?php echo ($v_filter_organize == '0')?'selected':'';?>> Cá nhân </option>
                             <option value="1" <?php echo ($v_filter_organize == '1')?'selected':'';?>> Tổ chức</option>
                         </select>
                    </div>
                </div>
            </div>
            <!--End status and organize-->
            
            
        </div><!-- End Panel Body -->
        <div class="panel-footer">
            <div style="text-align: center;">
                <button type="button" class="btn btn-outline btn-info" onclick="btn_submit_onclick()">
                    <i class="fa fa-search"></i> <?php echo __('search'); ?>
                </button>
            </div>
        </div>
    </div>
    
    <div class="clear" style="height: 0px"></div>
    
    <div style="text-align: right;" class="alert alert-info">
                <label>Tổng số tài khoản đăng ký quá hạn kích hoạt (<?php echo $count_account_overduce_confirm; ?>) 
                    <button type="button" class="btn btn-danger" onclick="btn_delete_account_overdue_confirmed()" ><?php echo __('Xóa tài khoản quá hạn kích hoạt')?></button></label>
    </div>
    
    <!--div class="row" style="text-align: right;padding: 5px 5px 5px 0; border: 1px solid black; background-color: lightgray;">
        <label>Tổng số tài khoản đăng ký quá hạn kích hoạt (<?php echo $count_account_overduce_confirm; ?>) 
            <button type="button" onclick="btn_delete_account_overdue_confirmed()" style="border: solid 1px #A7AAAD;padding: 5px;cursor: pointer; margin: auto"><?php echo __('Xóa tài khoản quá hạn kích hoạt')?></button></label>
    </div-->
    
    <div class="clear" style="height: 5px"></div>
    
    <table class="table table-striped table-bordered table-hover">
        <colgroup>
            <col width="5%" />
            <col width="10%" />
            <col width=20%" />
            <col width="20%" />
            <col width="10%" />
            <col width="15%" />
            <col width="10%" />
        </colgroup>
        <tr>
            <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
            <th><?php echo __('username'); ?></th>
            <th><?php echo __('Cá nhân/Tổ chức'); ?></th>
            <th><?php echo __('address'); ?></th>
            <th><?php echo __('organize'); ?></th>
            <th><?php echo __('email'); ?></th>
            <th><?php echo __('status'); ?></th>
        </tr>
        <?php
        $row = 0;
        $i = 0
        ?>
        <?php for ($i = 0; $i < count($arr_all_account); $i++):; ?>
            <?php
                $arr_account        = $arr_all_account[$i];
                $v_customer_id      = isset($arr_account['PK_CITIZEN']) ? $arr_account['PK_CITIZEN'] : 0;
                $v_user_name        = isset($arr_account['C_USERNAME']) ? $arr_account['C_USERNAME'] : '';
                $v_xml_data         = isset($arr_account['C_XML_DATA']) ? $arr_account['C_XML_DATA'] : '';
                $v_organ            = isset($arr_account['C_ORGAN']) ? $arr_account['C_ORGAN'] : 0;
                $v_status           = isset($arr_account['C_STATUS']) ? $arr_account['C_STATUS'] : 0;
                $v_email            = isset($arr_account['C_EMAIL']) ? $arr_account['C_EMAIL'] : 0;
                $v_address = $v_customer_name =  '';
                
                $dom = simplexml_load_string($v_xml_data, 'SimpleXMLElement', LIBXML_NOCDATA);
                if(!empty($dom))
                {
                    $v_xpath    = '//item'; 
                    $obj_data   = $dom->xpath($v_xpath);
                    $v_customer_name    = (string)$obj_data[0]->name;
                    $v_address          = (string)$obj_data[0]->address;
                }
                $v_organ = ($v_organ == 0) ? 'Cá nhân' : 'Tổ chức';
            ?>
            <tr>
                <td class="center">
                    <center>
                        <input type="checkbox" name="chk"
                                   value="<?php echo $v_customer_id; ?>" 
                                   onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                                   />
                    </center>
                </td>
                <td>
                    <?php if($v_status == '-1'):?>
                        <?php echo $v_user_name; ?>
                    <?php else:?>
                        <a href="javascript:void(0)" onclick="row_onclick(<?php echo $v_customer_id; ?>)"><?php echo $v_user_name; ?></a>
                    <?php endif;?>
                </td>
                <td><?php echo $v_customer_name; ?></td>
                <td><?php echo $v_address;?></td>
                <td><center><?php echo $v_organ; ?></center></td>
                <td><?php echo $v_email;?></td>
                <td>
                    <center style="font-weight: bold">
                        <?php 
                            if($v_status == 1)
                            { 
                                echo '<span class="status_3">' . __('Hoạt động') . '</span>';

                            }
                            elseif($v_status == 0)
                            {
                                echo '<span class="status_2">' . __('Đã khóa') . '</span>';
                            }
                            else
                            {
                                echo '<span class="status_0">' . __('Chưa kích hoạt') . '</span>';
                            }
                         ?>
                    </center>
                </td>    
            </tr>
            <?php
            $row = ($row == 1) ? 0 : 1;
            ?>
            <?php endfor; ?>
            <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
            <?php for ($i; $i < $n; $i++): ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
    <?php endfor; ?>
    </table>
    <?php echo $this->paging2($arr_all_account); ?>
    <div class="button-area">
        <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();"><i class="fa fa-times"></i> <?php echo __('delete'); ?></button>
    </div>
</form>
<script>
    function btn_submit_onclick()
    {
        $('#frmMain').attr('action','<?php echo $this->get_controller_url() ?>' );
        $('#frmMain').submit();
    }
    function btn_delete_account_overdue_confirmed()
    {
        var count_account_overdue_confirm = $('#hdn_count_overdue_confirm').val() || 0;
        if(parseInt(count_account_overdue_confirm) <=0)
        {
            alert('Hiện tại không có tài khoản mới đăng ký quá hạn yêu cầu kích hoạt.');
            return false;
        }
        if(confirm('Bạn Chắc chắn muốn xóa danh sách tài khoản đăng ký quá hạn kích hoạt.'))
        {
            var url = '<?php echo $this->get_controller_url?>do_delete_overdue_confirm';
            $.ajax({
                url:url,
                data: {delete_account_overdue_confrim: '1'},
                beforeSend :function()
                {
                    return ;
                },
                success:function(data)
                {
                    if(data.trim().toString() == 'TRUE' && data != 'undefined')
                    {
                        alert('Bạn đã xóa thành công!');
                    }
                    else
                    {
                        alert('Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thực hiện lại');
                    }
                    window.location.reload();
                }
            });   
        }
    }
</script>
<?php
//$this->template->display('dsp_footer.php');
