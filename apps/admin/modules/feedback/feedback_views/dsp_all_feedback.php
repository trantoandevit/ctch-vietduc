<?php defined('DS') or die('no direct access') ?>
<?php
$this->_page_title = __('feedback');
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('feedback'); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frmMain" id="frmMain" action="" method="POST">
<?php
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_item_id', 0);
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_feedback');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_feedback');
    echo $this->hidden('hdn_update_method', 'update_feedback');
    echo $this->hidden('hdn_delete_method', 'delete_feedback');
?>
    <!--seach-->
    <div class="div_filter_magazine">
        <div class="float_right">
            
        </div>
    </div>
    <div class="clear" style="height: 10px">&nbsp;</div> 
    <!--danh sach nguoi dat bao-->
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <colgroup>
                    <col width="5%" />
                    <col width="45%" />
                    <col width="15%" />
                    <col width="15%" />
                    <col width="10%" />
                </colgroup>
                <tr>
                    <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                    <th><?php echo __('title'); ?></th>
                    <th><?php echo __('email'); ?></th>
                    <th><?php echo __('date'); ?></th>
                    <th><?php echo __('status'); ?></th>
                </tr>
                <?php for($i=0;$i<count($arr_all_feedback);$i++):
                        $arr_feedback = $arr_all_feedback[$i];

                        $v_id    = $arr_feedback['PK_FEEDBACK'];
                        $v_name  = $arr_feedback['C_TITLE'];
                        $v_email = $arr_feedback['C_EMAIL'];
                        $v_phone = $arr_feedback['C_INIT_DATE'];

                        $v_status = $arr_feedback['C_REPLY'];
                        $v_status = ($v_status == NULL OR $v_status == '')? __('unanswered') : __('answered');

                        $row = ($i % 2 == 0)?0:1;
                ?>
                 <tr>
                        <td class="Center">
                            <input type="checkbox" name="chk"
                                   value="<?php echo $v_id; ?>" 
                                   onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                                   />
                        </td>
                    <td>
                        <a href="javascript:void(0)" onclick="row_onclick(<?php echo $v_id; ?>)">
                            <?php echo $v_name;?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <?php echo $v_email;?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo $v_phone;?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo $v_status;?>
                    </td>
                </tr>
                <?php endfor;?>
            </table>
        </div>
    </div>
    <?php echo $this->paging2($arr_all_feedback);?>
    <div class="button-area">
        <button type="button" name="btn_delete" class="btn btn-outline btn-danger" style="margin-right: 10px;" onclick="btn_delete_onclick();">
            <i class="fa fa-times"> </i> <?php echo __('delete')?>
        </button>
    </div>
</form>
<script>
function btn_filtter_onclick()
{
    m = $('#controller').val();
    $('#frmMain').attr('action',m);
    $('#frmMain').submit();
}
</script>