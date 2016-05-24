<?php
if (!defined('SERVER_ROOT'))
{
    exit('No direct script access allowed');
}
?>
<?php
//header
@session::init();
//$this->template->title = __('banner manager');
//$this->template->display('dsp_header.php');

$this->_page_title = __('banner detail');

$arr_img_ext = explode(',', strtolower(EXT_IMAGE));
?>
<h1 class="page-header"><?php echo __('banner manager'); ?></h1>

<form action="<?php $this->get_controller_url();?>" name="frmMain" id="frmMain" method="POST">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', '0');
    echo $this->hidden('hdn_item_id_list', '');
    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_banner');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_banner');
    echo $this->hidden('hdn_update_method', 'update_banner');
    echo $this->hidden('hdn_delete_method', 'delete_banner');
    ?>
    

        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <colgroup>
                        <col width="5%" />
                        <col width="75%" />
                        <col width="10%" />
                        <col width="10%" />
                    </colgroup>
                    <tr>
                        <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                        <th><?php echo __('banner image'); ?></th>
                        <th><?php echo __('status'); ?></th>
                        <th><?php echo __('default'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $row = 0; ?>
                        <?php foreach ($arr_all_banner as $arr_row): ?>
                            <tr>
                                <td class="Center">
                                    <input type="checkbox" name="chk"
                                           value="<?php echo $arr_row['PK_BANNER']; ?>" 
                                           onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                                           />
                                </td>
                                <td style="text-align:center" align="center">
                                    <div>
                                        <?php $v_extension = substr($arr_row['C_FILE_NAME'], strrpos($arr_row['C_FILE_NAME'], '.') + 1); ?>
                                        <?php if (strtolower($v_extension) == 'swf'): ?>
                                            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                                    codebase="<?php SITE_ROOT . "upload/flash/swflash.cab" ?>" 
                                                    width="150" height="150" >
                                                <param name="movie" value="" />
                                                <param name="quality" value="high" />
                                                <param name="wmode" value="transparent" />
                                                <embed src="<?php echo SITE_ROOT . "upload/" . $arr_row['C_FILE_NAME']; ?>" wmode="transparent" quality="high"
                                                       pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"
                                                       style="max-width:590;max-height:70">
                                                </embed>
                                            </object>
                                        <?php else: ?>
                                            <img src="<?php echo SITE_ROOT . "upload/" . $arr_row['C_FILE_NAME']; ?>" style="max-width:590px;max-height:70px;" />
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" onclick="row_onclick(<?php echo $arr_row['PK_BANNER']; ?>)">  
                                            <?php echo __('detail'); ?>
                                        </a>
                                    </div>
                                </td>
                                <td style="text-align:center" align="center">
                                    <?php echo ($arr_row['C_STATUS'] == 1) ? __('display') : __('display none'); ?>
                                </td>
                                <td style="text-align:center" align="center">
                                    <?php echo ($arr_row['C_DEFAULT'] == 1) ? __('yes') : __('no'); ?>
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
    
    
    <?php //echo $this->paging2($arr_all_banner); ?>
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

<script type="text/javascript">
    function btn_cache_onclick(){
        m = '<?php echo $this->get_controller_url() ?>write_cache';
        $("#frmMain").attr("action", m);
        frmMain.submit();
    }
</script>
<?php
//$this->template->display('dsp_footer.php');