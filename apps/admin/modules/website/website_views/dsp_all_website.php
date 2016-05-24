<?php if (!defined('SERVER_ROOT')) {exit('No direct script access allowed');}?>
<?php
//header
$this->_page_title = __('website manager');
?>
<div class="row">
    <div class="col-lg-12" style="font-size: 32px;">
        <h1 class="page-header"><?php echo __('website manager');?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST">
    <?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id','0');
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_website');
    echo $this->hidden('hdn_dsp_all_method','dsp_all_website');
    echo $this->hidden('hdn_update_method','update_website');
    echo $this->hidden('hdn_delete_method','delete_website');
    ?>

    <?php
    $this->load_xml('xml_dsp_all_website.xml');
    //$check_premission = session::check_permission('SUA_CHUYEN_TRANG',FALSE);
    //echo session::check_permission('SUA_CHUYEN_TRANG');
    echo $this->render_form_display_all($arr_all_website);

    //Phan trang
    echo $this->paging2($arr_all_website);
    ?>

    <div class="button-area">
        <button type="button" name="addnew" class="btn btn-outline btn-primary" style="margin-right: 10px;" onclick="btn_addnew_onclick();">
            <i class="fa fa-plus"></i> <?php echo __('add new');?>
        </button>
        <button type="button" name="trash" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();">
            <i class="fa fa-times" ></i> <?php echo __('delete');?>
        </button>
    </div>
</form>