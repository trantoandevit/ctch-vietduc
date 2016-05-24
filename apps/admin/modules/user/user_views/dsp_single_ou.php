<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');}
//display header
$this->_page_title = __('update ou info');

$v_pop_win = isset($_REQUEST['pop_win']) ? '_pop_win' : '';
//------------------------------------------------------------------------------

$arr_single_ou          = $VIEW_DATA['arr_single_ou'];
$arr_parent_ou_path     = $VIEW_DATA['arr_parent_ou_path'];

if (isset($arr_single_ou['PK_OU']))
{
    $v_ou_id       = $arr_single_ou['PK_OU'];
    $v_name        = $arr_single_ou['C_NAME'];
    $v_order       = $arr_single_ou['C_ORDER'];
    $v_status      = $arr_single_ou['C_STATUS'];
    $v_xml_data    = $arr_single_ou['C_XML_DATA'];
}
else
{
    $v_ou_id       = 0;
    $v_name        = '';
    $v_order       = $arr_single_ou['C_ORDER'];
    $v_status      = 1;
    $v_xml_data    = '';
}
?>
<form name="frmMain" method="post" id="frmMain" action="" class="form-horizontal"><?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_ou');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_ou');
    echo $this->hidden('hdn_update_method', 'update_ou');
    echo $this->hidden('hdn_delete_method', 'delete_ou');

    echo $this->hidden('hdn_item_id', $v_ou_id);
    echo $this->hidden('XmlData', $v_xml_data);

    echo $this->hidden('pop_win', $v_pop_win);
    ?>
    <!-- Toolbar -->
    <!-- Cot tuong minh -->
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo __('parent ou')?></label>
            <?php foreach ($arr_parent_ou_path as $id => $name): ?>
                <label class="col-sm-9 control-label" style="text-align: left">/<?php echo $name;?></label>
            <?php endforeach; ?>
            <?php echo $this->hidden('hdn_parent_ou_id', $id);?>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo __('ou name')?> <label class="required">(*)</label></label>
        <div class="col-sm-9">
            <input type="text" name="txt_name" id="txt_name" value="<?php echo $v_name; ?>"
                   class="form-control" maxlength="255" style="width:80%"
                   onKeyDown="return handleEnter(this, event);"
                   data-allownull="no" data-validate="text"
                   data-name="Tên đơn vị"
                   data-xml="no" data-doc="no"
                   autofocus="autofocus"
            />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo __('order'); ?> <label class="required">(*)</label></label>
        <div class="col-sm-9">
            <input type="text" name="txt_order" value="<?php echo $v_order; ?>" id="txt_order"
                   class="form-control" size="4" maxlength="3" pattern="[0-9]*"
                   data-allownull="no" data-validate="unsignNumber"
                   data-name="<?php echo __('order'); ?>"
                   data-xml="no" data-doc="no" style="width:80%"
                   />
        </div>
    </div>

    <!-- Button -->
    <div class="button-area">
        <button type="button" class="btn btn-outline btn-success" onClick="btn_update_onclick();">
            <i class="fa fa-check"></i> <?php echo __('update'); ?>
        </button>
        <?php $v_back_action = ($v_pop_win === '') ? 'btn_back_onclick();' : 'try{window.parent.hidePopWin();}catch(e){window.close();};';?>
        <button type="button" class="btn btn-outline btn-danger" onclick="<?php echo $v_back_action;?>">
            <i class="fa fa-times"></i> <?php echo __('cancel'); ?>
        </button>
    </div>
</form>