<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <colgroup>
                <col width="5%" />
                <col width="85%" />
                <col width="10%" />
            </colgroup>
            <tr>
                <th><input type="checkbox" name="chk_check_all" onclick="toggle_check_all(this,this.form.chk);"/></th>
                <th><?php echo __('menu name'); ?></th>
                <th><?php echo __('order1'); ?></th>
            </tr>
            <?php
            $row = 0;
            $i   = 0
            ?>
            <?php
            for ($i = 0; $i < count($arr_all_menu); $i++):
                $v_menu_id        = $arr_all_menu[$i]['PK_MENU'];
                $v_name           = $arr_all_menu[$i]['C_NAME'];
                $v_order          = $arr_all_menu[$i]['C_ORDER'];
                $v_internal_order = $arr_all_menu[$i]['C_INTERNAL_ORDER'];
                $v_parent         = $arr_all_menu[$i]['FK_PARENT'];
                $v_level          = strlen($arr_all_menu[$i]['C_INTERNAL_ORDER']) / 3 - 1;
                $v_level_text     = '';
                for ($j = 0; $j < $v_level; $j++)
                {
                    $v_level_text .= ' -- ';
                }

                $v_next_item = $v_menu_id;
                $v_prev_item = $v_menu_id;

                $j = $i - 1;
                while (isset($arr_all_menu[$j]))
                {
                    if ($arr_all_menu[$j]['FK_PARENT'] == $v_parent)
                    {
                        $v_prev_item = $arr_all_menu[$j]['PK_MENU'];
                        break;
                    }
                    else
                    {
                        $j--;
                    }
                }

                $j = $i + 1;
                while (isset($arr_all_menu[$j]))
                {
                    if ($arr_all_menu[$j]['FK_PARENT'] == $v_parent)
                    {
                        $v_next_item = $arr_all_menu[$j]['PK_MENU'];
                        break;
                    }
                    else
                    {
                        $j++;
                    }
                }
                ?>

                <tr>
                    <td class="Center">
                        <input type="checkbox" name="chk"
                               value="<?php echo $v_menu_id; ?>" 
                               onclick="if (!this.checked) this.form.chk_check_all.checked=false;" 
                               />
                    </td>
                    <td>
                        <a href="javascript:void(0)" onclick="row_onclick(<?php echo $v_menu_id; ?>)"><?php echo $v_level_text . $v_name; ?></a>
                    </td>
                    <td>
                <center>

                        <?php if ($v_prev_item != $v_menu_id): ?>
                            <a href="javascript:void(0);" onClick="swap_order_menu(<?php echo $v_menu_id ?>,<?php echo $v_prev_item; ?>);"
                               <i class="fa fa-arrow-up" style="font-size: 18px;"></i>
                            </a>
                            <?php endif; ?>
                            <?php if ($v_next_item != $v_menu_id): ?>
                                <a href="javascript:void(0);" onClick="swap_order_menu(<?php echo $v_menu_id ?>,<?php echo $v_next_item; ?>);"
                                    <i class="fa fa-arrow-down" style="font-size: 18px;"></i>
                                </a>
                        <?php endif; ?>
                </center>
            </td>    
            </tr>
            <?php
            $row = ($row == 1) ? 0 : 1;
            ?>
        <?php endfor; ?>
        <?php $n   = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
        <?php for ($i; $i < $n; $i++): ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endfor; ?>
        </table>
    </div>
</div>
<div class="button-area">

    <button type="button" name="addnew" class="btn btn-outline btn-primary" onclick="btn_addnew_onclick();">
        <i class="fa fa-plus"></i> <?php echo __('add new');?>
    </button>
   
    <button type="button" name="trash" class="btn btn-outline btn-danger" onClick="btn_delete_onclick();" style="margin-left:10px;">
        <i class="fa fa-times"></i> <?php echo __('delete'); ?>
    </button>
</div>
