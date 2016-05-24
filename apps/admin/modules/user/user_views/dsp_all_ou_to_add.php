<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

//display header
$this->_page_title = 'Chọn đơn vị';

$v_pop_win = isset($_REQUEST['pop_win']) ? '_pop_win' : '';
$arr_all_ou_to_add = $VIEW_DATA['arr_all_ou'];
?>
<form name="frmMain" method="post" id="frmMain" action="#">
    <table width="100%" class="adminlist" cellspacing="0" border="1">
                <colgroup>
                <col width="95%" />
            </colgroup>
            <tr>
                <th>Tên đơn vị</th>
            </tr>
    </table>
    <div style="height:200px;overflow: scroll">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                        <colgroup>
                        <col width="100%" />
                        </colgroup>

                    <?php for ($i=0; $i<count($arr_all_ou_to_add); $i++): ?>
                        <?php
                            $v_ou_id        = $arr_all_ou_to_add[$i]['PK_OU'];
                            $v_ou_name      = $arr_all_ou_to_add[$i]['C_NAME'];
                            $v_ou_level     = strlen($arr_all_ou_to_add[$i]['C_INTERNAL_ORDER'])/3-1;
                            $v_ou_patch     = $v_ou_name;
                            $v_ou_parent    = $arr_all_ou_to_add[$i]['FK_OU'];
                            for($j=0;$j<$v_ou_level;$j++)
                            {
                                for($n=0;$n<count($arr_all_ou_to_add);$n++)
                                {
                                    if($v_ou_parent == $arr_all_ou_to_add[$n]['PK_OU'])
                                    {
                                        $v_ou_parent = $arr_all_ou_to_add[$n]['FK_OU'];
                                        $v_ou_patch="/".$arr_all_ou_to_add[$n]['C_NAME'].'/'.$v_ou_patch;
                                        break;
                                    }
                                }
                            }
                        ?>
                        <tr class="<?php echo $v_class;?>">
                            <td>

                                <?php 
                                    for($j=0;$j<$v_ou_level;$j++)
                                    {
                                        echo " -- ";
                                    }
                                ?>
                                <a href="javascript:void(0)" data-ou_patch="<?php echo $v_ou_patch;?>"
                                   data-ou_id="<?php echo $v_ou_id;?>" 
                                   onclick="get_selected_ou(this)">
                                    <?php echo $v_ou_name;?>
                                </a>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        </div>
    </div>
    <!-- Button -->
    <div class="button-area">
        <button type="button" name="update" class="btn btn-outline btn-success" onclick="get_selected_group();">
            <i class="fa fa-check"></i> <?php echo __('update'); ?>
        </button>
        <?php $v_back_action = ($v_pop_win === '') ? 'btn_back_onclick();' : 'try{window.parent.hidePopWin();}catch(e){window.close();};';?>
        <button type="button" name="cancel" class="btn btn-outline btn-danger" onclick="<?php echo $v_back_action;?>">
            <i class="fa fa-times"></i> <?php echo __('cancel'); ?>
        </button>
    </div>
</form>
<script>
    function get_selected_ou(ou)
    {
        var jsonObj = []; //declare array
        var ou_id=$(ou).attr('data-ou_id');
        var ou_patch=$(ou).attr('data-ou_patch');
        //alert(ou_patch);return;
        jsonObj.push({'ou_id': ou_id, 'ou_patch': ou_patch});

        returnVal = jsonObj;
        window.parent.hidePopWin(true);
    }
</script>