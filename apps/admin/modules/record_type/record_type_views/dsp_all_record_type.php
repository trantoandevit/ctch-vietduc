<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php
//header
//$this->template->title = __('record type');
//$this->template->display('dsp_header.php');

$arr_all_record_type    = $VIEW_DATA['arr_all_record_type'];

$arr_filter             = $VIEW_DATA['arr_filter'];
$v_filter               = $arr_filter['txt_filter'];
$v_status               = $arr_filter['sel_status'];
$v_member               = $arr_filter['sel_member'];
$v_internet             = ($arr_filter['chk_internet']==1)?'checked':'';


$v_rows_per_page        = $arr_filter['sel_rows_per_page'];
$v_page                 = $arr_filter['sel_goto_page'];

$arr_all_village  =  $arr_all_member['arr_all_village'];
$arr_all_district =  $arr_all_member['arr_all_district'];
?>
<h1 class="page-header" style="font-size: 32px;"><?php echo __('record type');?></h1>
<form name="frmMain" id="frmMain" action="#" method="POST" class="form-horizontal"><?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id','0');
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_record_type');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_record_type');
    echo $this->hidden('hdn_delete_method','do_delete_record_type');
    ?>

    <div class="row-fluid">
        <div id="div_filter">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-12">
                    <div class="col-lg-2"><label><?php echo __('code or name');?></label></div>
                <div class="col-lg-5">
                    <input type="text" name="txt_filter" class="form-control"
                        value="<?php echo $v_filter;?>"
                        class="inputbox" size="80"
                        onkeypress="txt_filter_onkeypress(this.form.btn_filter,event);"
                    />
                </div>
                </div>
            </div>
            
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-12">
                    <div class="col-lg-2"><label><?php echo __('status');?></label></div>
                <div class="col-lg-5">
                    <select class="form-control" name="sel_status">
                        <option <?php echo ($v_status == -1)?'selected':'';?> value="-1"> -- <?php echo __('all');?> -- </option>
                        <option <?php echo ($v_status == 0)?'selected':'';?> value="0"> -- <?php echo __('inactive status');?> -- </option>
                        <option <?php echo ($v_status == 1)?'selected':'';?> value="1"> -- <?php echo __('active status');?> -- </option>
                    </select>
                </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-12">
                    <div class="col-lg-2"><label><?php echo __('receiving unit records');?></label></div>
                <div class="col-lg-5">
                    <select class="form-control" name="sel_member">
                        <option value="0"> -- <?php echo __('all');?> -- </option>
                        <?php foreach($arr_all_district as $arr_district):
                                $v_name     = $arr_district['C_NAME'];
                                $v_id       = $arr_district['PK_MEMBER'];
                                $v_selected = ($v_id == $v_member)?'selected':'';
                        ?>
                        <option <?php echo $v_selected?> value="<?php echo $v_id?>"><?php echo $v_name?></option>
                        <?php foreach($arr_all_village as $key => $arr_village):
                                $v_village_name = $arr_village['C_NAME'];
                                $v_village_id   = $arr_village['PK_MEMBER'];
                                $v_parent_id    = $arr_village['FK_MEMBER'];
                                if($v_parent_id != $v_id)
                                {
                                    continue;
                                }
                                $v_selected = ($v_village_id == $v_member)?'selected':'';
                        ?>
                        <option <?php echo $v_selected?> value="<?php echo $v_village_id?>"><?php echo '---- '.$v_village_name?></option>
                        <?php 
                            unset($arr_all_village[$key]);
                            endforeach;
                        ?>
                        <?php endforeach;?>
                    </select>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                <div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-5">
                    <label>
                    <input type="checkbox" name="chk_internet" value="1" <?php echo $v_internet?> />
                    <?php echo __('submit internet record');?>
                    </label>
                </div>
                </div>
            </div>
            <div class="row" style="text-align: center; margin-bottom: 20px;">
                <button type="button" class="btn btn-outline btn-info" onclick="btn_filter_onclick();" name="btn_filter"><i class="fa fa-search"></i> <?php echo __('filter');?></button>
            </div>
        </div>

        <?php
        $xml_file = strtolower('xml_record_type_list.xml');
        if ($this->load_xml($xml_file))
        {
            echo $this->render_form_display_all($arr_all_record_type);
        }
        ?>
        <div id="dyntable_length" class="dataTables_length">
            <?php echo $this->paging2($arr_all_record_type);?>
        </div>

        <div class="button-area">
            <button type="button" name="addnew" class="btn btn-outline btn-primary" onclick="btn_addnew_onclick();"><i class="fa fa-plus"></i> <?php echo __('add new'); ?></button>
            <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();"><i class="fa fa-times"></i> <?php echo __('delete'); ?></button>
        </div>
    </div>
</form>
<?php //$this->template->display('dsp_footer.php');