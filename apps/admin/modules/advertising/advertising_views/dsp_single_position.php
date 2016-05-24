<!-- /.panel-heading -->
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
            <thead>
                <tr>
                    <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this, this.form.chk);"/></th>
                    <th><?php echo __('advertising name'); ?></th>
                    <th><?php echo __('begin date'); ?></th>
                    <th><?php echo __('end date'); ?></th>
                    <th><?php echo __('order1'); ?></th>
                </tr>

            </thead>
            <tbody>
                <?php
                $row = 0;
                $i = 0
                ?>
                <?php
                for ($i = 0; $i < count($arr_all_advertising); $i++):
                    $v_advertising_id = $arr_all_advertising[$i]['PK_ADVERTISING'];
                    $v_name = $arr_all_advertising[$i]['C_NAME'];
                    $v_begin_date = $arr_all_advertising[$i]['C_BEGIN_DATE'];
                    $v_end_date = $arr_all_advertising[$i]['C_END_DATE'];
                    $next = isset($arr_all_advertising[$i + 1]['PK_ADVERTISING']) ? $arr_all_advertising[$i + 1]['PK_ADVERTISING'] : false;
                    $prev = isset($arr_all_advertising[$i - 1]['PK_ADVERTISING']) ? $arr_all_advertising[$i - 1]['PK_ADVERTISING'] : false;
                    ?>

                    <tr>
                        <td class="Center">
                            <input type="checkbox" name="chk"
                                   value="<?php echo $v_advertising_id; ?>" 
                                   onclick="if (!this.checked)
                                                       this.form.chk_check_all.checked = false;" 
                                   />
                        </td>
                        <td>
                            <a href="javascript:void(0)" onclick="row_onclick(<?php echo $v_advertising_id; ?>)"><?php echo $v_name; ?></a>
                        </td>
                        <td><center><?php echo $v_begin_date; ?></center></td>
                <td><center><?php echo $v_end_date; ?></center></td>
                <td>
                    <?php if (count($arr_all_advertising) != 1): ?>
                    <center>
                        <?php if ($i == 0): ?>
                            <a href="javascript:void(0)" onclick="swap_order_advertising(<?php echo $v_advertising_id ?>,<?php echo $next; ?>)">
                                <i class=" fa fa-arrow-down" style="font-size:18px;"></i>
                            </a>
                        <?php elseif ($i == count($arr_all_advertising) - 1): ?>
                            <a href="javascript:void(0)" onclick="swap_order_advertising(<?php echo $v_advertising_id ?>,<?php echo $prev; ?>)">
                                        <i class="fa fa-arrow-up" style="font-size:18px;"></i>
                            </a>
                        <?php else: ?>
                            <a href="javascript:void(0)" onclick="swap_order_advertising(<?php echo $v_advertising_id ?>,<?php echo $next; ?>)">
                                <i class=" fa fa-arrow-down" style="font-size:18px;"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="swap_order_advertising(<?php echo $v_advertising_id ?>,<?php echo $prev; ?>)">
                                <i class=" fa fa-arrow-up" style="font-size:18px;"></i>
                            </a>
                        <?php endif; ?>
                    </center>
                <?php endif; ?>
                </td>    
                </tr>
                <?php
                $row = ($row == 1) ? 0 : 1;
                ?>
            <?php endfor; ?>
            <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
            <?php
            for ($i; $i < $n; $i++):
                ?>
                <tr >
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endfor; ?>   
            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->
</div>
<!-- /.panel-body -->


<div class="button-area">

    <button type="button" name="addnew" class="btn btn-outline btn-primary"  onclick="btn_addnew_onclick();">
        <i class="fa fa-plus"></i> <?php echo __('add new'); ?>
    </button>

    <button type="button" name="trash" class="btn btn-outline btn-danger"  style="margin-left:10px;" onclick="btn_delete_onclick();">
        <i class="fa fa-times"></i> <?php echo __('delete'); ?>
    </button>
</div>
