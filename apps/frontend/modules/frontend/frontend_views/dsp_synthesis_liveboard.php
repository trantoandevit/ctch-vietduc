<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading uppercase">
            <?php echo __('liveboard') ?>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th class="first blue" width="5%">#</th>
                    <th class="top blue"><?php echo __('unit name') ?></th>
                </tr>
                <?php
                $j = 0;
                for ($i = 0, $n = sizeof($arr_all_liveboard); $i < $n; $i++) {
                    $arr_liveboard = $arr_all_liveboard[$i];
                    $v_unit_name = $arr_liveboard['C_NAME'];
                    $v_url = $arr_liveboard['C_LIVEBOARD_LINK'];
                    ?>
                    <tr>
                        <td class="left blue center"><?php echo $j + 1; ?></td>
                        <td class="right blue">
                            <a target="_blank" href="<?php echo $v_url ?>"><?php echo $v_unit_name; ?></a>
                        </td>
                    </tr>
                    <?php
                    $j++;
                }//end for i
                ?>
         </table>
        </div>
    </div>
</div><!-- .container-fluid -->
<div class="clear" style="height: 10px;"></div>
<script>
    function btn_reset_onclick()
    {
        var f = document.frmMain;
        f.sel_village.value = '';
        f.sel_spec_code.value = '';
        f.sel_month.value = '';
        f.sel_year.value = '<?php echo (int) Date('Y') ?>';
    }
</script>