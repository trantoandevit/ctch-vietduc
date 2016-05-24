<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

//$this->template->title =__('member');
//$this->template->display('dsp_header.php');

$arr_all_member = isset($arr_all_member) ? $arr_all_member : array();
$v_filter = isset($_REQUEST['txt_filter']) ? $_REQUEST['txt_filter'] :'';
?>


<?php
/**
 * hien thi nut xoa va cap nhat
 */
function show_insert_delete_button()
{
    $html = '<div class="button-area">';
    $html .= '<button type="button" class="btn btn-outline btn-warning" onClick="btn_syn_onclick();"><i class="fa fa-refresh"></i> ' . __('synchronize') . '</button> &nbsp;&nbsp;';
    $html .= '<button type="button" class="btn btn-outline btn-primary" onClick="btn_addnew_onclick();"><i class="fa fa-plus"></i> ' . __('add new') . '</button>&nbsp;&nbsp;';
    $html .= '<button type="button" class="btn btn-outline btn-danger" onClick="btn_delete_onclick();"><i class="fa fa-times"></i> ' . __('delete') . '</button>&nbsp;&nbsp;';
    if (get_system_config_value(CFGKEY_CACHE) == 'true')
    {
        $html .= '<button type="button" class="btn btn-outline btn-success" onclick="save_cache_onclick();" value=""><i class="fa fa-check"></i> ' . __('save cache') . '</button>&nbsp;&nbsp;';
    }

    $html .= '</div>';

    echo $html;
}
?>

<form name="frmMain" id="frmMain" action="" method="POST">
    <?php
        echo $this->hidden('controller',$this->get_controller_url());
        echo $this->hidden('hdn_item_id',0);
        echo $this->hidden('hdn_item_id_list','');
        
        echo $this->hidden('hdn_dsp_single_method','dsp_single_member');
        echo $this->hidden('hdn_dsp_all_method','dsp_all_member');
        echo $this->hidden('hdn_delete_method','dsp_delete_member');
        echo $this->hidden('hdn_syn_method','do_synchronize');
    ?>
    
    <!-- Toolbar -->
    <h1 class="page-header" style="font-size: 32px;"><?php echo __('member list'); ?></h1>
    <!--Start filter-->
    <div class="row" id="box-filter">
        <div class="col-lg-12">
            <div class="col-lg-3" style="text-align: center; padding-top: 5px;">
                <label><?php echo __('filter text member'); ?>:</label>
            </div>
<!--        <input type="text" name="txt_filter" value="<?php echo $v_filter; ?>" size="40">
        <input type="submit" class="ButtonSearch" value="Lọc" name="btn_filter">
        -->
        <div class="col-lg-6 input-group">
            
        <input type="textbox" class="form-control" name="txt_filter" id="txt_filter" value="<?php echo $v_filter; ?>">
        <span class="input-group-btn">
            <button class="btn btn-default" name="btn_filter" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </span>   
            
        </div>
 
        </div>
    </div>
    <!--End filter-->
    
    <?php show_insert_delete_button(); ?>
    <table class="table table-striped table-bordered table-hover" >
        <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="50%">
            <col width="10%">
        </colgroup>
        <tr>
            <th>
                <input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this, this.form)"/>
            </th>
            <th><?php echo __('code member') ?></th>
            <th><?php echo __('name member') ?></th>
            <th><?php echo __('member level') ?></th>
        </tr>
        <?php for($i = 0;$i < sizeof($arr_all_member); $i ++):; ?>
     
        <?php 
                $v_member_id        = $arr_all_member[$i]['PK_MEMBER'];
                $v_member_name      = $arr_all_member[$i]['C_NAME'];
                $v_member_code      = $arr_all_member[$i]['C_CODE'];
                $v_member_address   = $arr_all_member[$i]['C_SCOPE'];
                $v_member_email     = $arr_all_member[$i]['C_EXCHANGE_EMAIL'];
                $v_status           = ($arr_all_member[$i]['C_STATUS'] == 1) ? 'Hiển thị' : 'Không hiển thị';
                $v_xml_data         = $arr_all_member[$i]['C_XML_DATA'];
                $v_xml_member_child = $arr_all_member[$i]['C_XML_MEMBER_CHILD'];    
        ?>
            <tr>
                 <td class="Center">
                        <input type="checkbox" name="chk" class="chk" id="item_<?php echo $i ?>"
                            value="<?php echo $v_member_id; ?>"
                            />
                </td>
                <td><a data-id="<?php echo $v_member_id; ?>" href="javascript:void()"   onclick="onlick_single_member(this);" ><?php echo $v_member_code; ?></a></td>
                <td><a data-id="<?php echo $v_member_id; ?>" href="javascript:void()"   onclick="onlick_single_member(this);" ><?php echo $v_member_name; ?></a></td>
                <td><?php echo $v_status;?></td>
            </tr>
            <?php
                if(trim($v_xml_member_child) != '')
                {
                    $dom     = simplexml_load_string($v_xml_member_child);
                    $v_xpath = '//row';
                    $arr_memeber_child = $dom->xpath($v_xpath);
                    for($m=0; $m<count($arr_memeber_child);$m ++)
                    {
                        $v_member_child_id        = $arr_memeber_child[$m]['PK_MEMBER'];
                        $v_member_child_name      = $arr_memeber_child[$m]['C_NAME'];
                        $v_member_child_code      = $arr_memeber_child[$m]['C_CODE'];
                        $v_member_child_address   = $arr_memeber_child[$m]['C_SCOPE'];
                        $v_member_child_email     = $arr_memeber_child[$m]['C_EXCHANGE_EMAIL'];
                        $v_status_child           = ($arr_memeber_child[$m]['C_STATUS'] == 1) ? 'Hiển thị' : 'Không hiển thị';
                    ?>
                        <tr>
                             <td class="Center"  >
                                    <input  type="checkbox" name="chk" class="chk" id="item_<?php echo $i.'-'.$m ?>"  
                                            value="<?php echo $v_member_child_id; ?>"
                                        />
                            </td>
                            <td><a data-id="<?php echo $v_member_child_id; ?>" href="javascript:void()"   onclick="onlick_single_member(this);" ><?php echo $v_member_child_code; ?></a></td>
                            <td><a data-id="<?php echo $v_member_child_id; ?>" href="javascript:void()"   onclick="onlick_single_member(this);" >--&nbsp<?php echo $v_member_child_name; ?></a></td>
                            <td><?php echo $v_status_child;?></td>
                        </tr>
                    <?php
                    }
                }
            ?>
       <?php endfor; ?>
    </table>
    <?php show_insert_delete_button(); ?>
</form>
<script>
    
    toggle_checkbox('#chk_all', '.chk');
    $(document).ready(function(){        
    });
    
    /*
     *Xem chi tiet member theo Id member
     * @param int member_id Ma cua member
     */
    function onlick_single_member(selector)
    {
        var member_id = $(selector).attr('data-id');
        if(parseInt(member_id) >0)
        {
            var f = document.frmMain;
            $('#hdn_item_id').val(member_id);
            m = $("#controller").val() + f.hdn_dsp_single_method.value;
            $('#frmMain').attr('action',m);
            f.submit();
        }
    }
    
    function btn_syn_onclick()
    {
        if(confirm('Bạn chắc chắn đồng bộ hóa dữ liệu !!!'))
        {
            var f = document.frmMain;
            m = $("#controller").val() + f.hdn_syn_method.value;
            $('#frmMain').attr('action',m);
            f.submit();
        }
    }
</script>
<?php
//$this->template->display('dsp_footer.php');

