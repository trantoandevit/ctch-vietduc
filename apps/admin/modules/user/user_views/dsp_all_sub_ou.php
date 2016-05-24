<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

$arr_all_sub_ou         = $VIEW_DATA['arr_all_sub_ou'];
$arr_all_user_by_ou     = $VIEW_DATA['arr_all_user_by_ou'];
$arr_all_group_by_ou    = $VIEW_DATA['arr_all_group_by_ou'];
$arr_ou_path            = $VIEW_DATA['arr_ou_path'];
$v_ou_id                = $VIEW_DATA['ou_id'];

//header
$this->_page_title = __('user managerment');
?>

<div id="right_content">
<form name="frmMain" id="frmMain" action="" method="POST">
    <?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id','0');
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_ou');
    echo $this->hidden('hdn_dsp_all_method','dsp_all_ou');
    echo $this->hidden('hdn_update_method','update_ou');
    echo $this->hidden('hdn_delete_method','delete_ou');

    $v_row = 0;
    ?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="font-size: 32px;"><?php echo __('user managerment')?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
     <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header" style="margin: 0">
                <?php foreach ($arr_ou_path as $id => $name): ?>
                /<a href="<?php echo $this->get_controller_url() . 'dsp_all_sub_ou/' . $id; ?>"><?php echo $name; ?></a>
                <?php endforeach; ?>
                <?php
                echo $this->hidden('hdn_current_ou_id', $id);
                echo $this->hidden('hdn_current_ou_name', $name);
                ?>
            </h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="button-area">
        <div class="col-sm-12">
            <label class="col-sm-2">&nbsp;</label>
            <a href="javascript:void(0);" onclick="row_ou_onclick_pop_win(0)" class="col-sm-3"><i class="fa fa-folder-open"></i> <?php echo __('Add OU')?></a>
            <a href="javascript:void(0);" onclick="row_user_onclick_pop_win(0)" class="col-sm-3"><i class="fa fa-user"></i> <?php echo __('add user')?></a>
            <a href="javascript:void(0);" onclick="row_group_pop_win(0)" class="col-sm-3"><i class="fa fa-group"></i> <?php echo __('add user group')?></a>
            <label class="col-sm-2">&nbsp;</label>
	</div>
    <!-- /Toolbar -->

    <!-- Don vi -->
    <div class="panel-body" style="overflow: hidden">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <colgroup>
                <col width="60%" />
                <col width="10%" />
                <col width="20%" />
                <col width="10%" />
            </colgroup>
            <tr>
                <th><?php echo __('user name')?> </th>
                <th><?php echo __('order')?></th>
                <th><?php echo __('user type')?></th>
                <th>#</th>
            </tr>
            <?php for ($i=0; $i<count($arr_all_sub_ou); $i++): ?>
                <?php
                $v_sub_ou_id     = $arr_all_sub_ou[$i]['PK_OU'];
                $v_sub_ou_name   = $arr_all_sub_ou[$i]['C_NAME'];
                $v_sub_ou_order  = $arr_all_sub_ou[$i]['C_ORDER'];

                $v_class = 'row' . ($v_row % 2);
                $v_row++;

                $v_link = $this->get_controller_url() . 'dsp_all_sub_ou/' . $v_sub_ou_id;
                ?>
                <tr>
                    <td>
                        <a href="#"><i class="fa fa-folder-open"></i></a>
                        <a href="<?php echo $v_link;?>">
                            <?php echo $v_sub_ou_name;?>
                        </a>
                    </td>
                    <td><?php echo $v_sub_ou_order;?></td>
                    <td><?php echo __('user ou type')?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="row_ou_onclick_pop_win(<?php echo $v_sub_ou_id;?>)"><?php echo __('edit')?></a> |
                        <a href="javascript:void(0)" onclick="quick_delete_ou(<?php echo $v_sub_ou_id . ',' . $id;?>)"><?php echo __('delete')?></a>
                    </td>
                </tr>
            <?php endfor; ?>
            <!-- NSD -->
            <?php for ($i=0; $i<count($arr_all_user_by_ou); $i++): ?>
                <?php
                $v_user_id      = $arr_all_user_by_ou[$i]['PK_USER'];
                $v_user_name    = $arr_all_user_by_ou[$i]['C_NAME'];
                $v_order        = $arr_all_user_by_ou[$i]['C_ORDER'];
                $v_status       = $arr_all_user_by_ou[$i]['C_STATUS'];
                $v_login_name   = $arr_all_user_by_ou[$i]['C_LOGIN_NAME'];

                $v_class = 'row' . ($v_row % 2);
                $v_row++;

                $v_url = $this->get_controller_url() . 'dsp_single_user/' . $v_user_id
                        . '/?hdn_item_id=' . $v_user_id . '&pop_up=1';

                $v_icon_file_name = ($v_status > 0) ? 'icon-16-user.png' : 'icon-16-user-inactive.png';
                ?>
                <tr class="<?php echo $v_class;?>">
                    <td>
                        <a href="#"><i class="fa fa-user"></i></a>
                        <?php echo $v_user_name;?>
                    </td>
                    <td class="center"><?php echo $v_order;?></td>
                    <td><?php echo __('user')?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="row_user_onclick_pop_win(<?php echo $v_user_id;?>)"><?php echo __('edit')?></a>
                        <?php if ($v_login_name != 'admin'):?>
                             | <a href="javascript:void(0)" onclick="quick_delete_user(<?php echo $v_user_id;?>)"><?php echo __('delete')?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endfor; ?>
            <!-- Group -->
            <?php for ($i=0; $i<count($arr_all_group_by_ou); $i++): ?>
                <?php
                $v_group_id         = $arr_all_group_by_ou[$i]['PK_GROUP'];
                $v_name             = $arr_all_group_by_ou[$i]['C_NAME'];

                $v_is_built_in      = $arr_all_group_by_ou[$i]['C_BUILT_IN'];

                $v_class = 'row' . ($v_row % 2);
                $v_row++;
                ?>
                <tr class="<?php echo $v_class;?>">
                    <td>
                        <a href="#"><i class="fa fa-group"></i></a>
                        <?php echo $v_name;?>
                    </td>
                    <td></td>
                    <td><?php echo __('user group type')?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="row_group_pop_win(<?php echo $v_group_id;?>)"><?php echo __('edit')?></a>
                        <?php if ($v_is_built_in == 0): ?>
                            | <a href="javascript:void(0)" onclick="quick_delete_group(<?php echo $v_group_id;?>)"><?php echo __('delete')?></a>
                        <?php endif; ?>
                    </td>
                </tr>

            <?php endfor; ?>
            <?php echo $this->add_empty_rows($v_row, _CONST_DEFAULT_ROWS_PER_PAGE, 4); ?>
        </table>
    </div>
</div>
</form>
</div>
<script>
    function user_pop_win(url)
    {
        showPopWin(url ,800,600, null);
    }
    function ou_pop_win(url)
    {
        showPopWin(url ,800,600, null);
    }

    function row_user_onclick_pop_win(user_id)
    {
        var url = '<?php echo $this->get_controller_url();?>/dsp_single_user/'  + user_id
            url += '/?&user_id=' + user_id + '&hdn_item_id=' + user_id + '&pop_win=1';
            url += '&parent_ou_id=' + $("#hdn_current_ou_id").val();
            url += '&parent_ou_name=' + escape($("#hdn_current_ou_name").val());

        user_pop_win(url);
    }

    function row_ou_onclick_pop_win(id)
    {
        var url = '<?php echo $this->get_controller_url();?>dsp_single_ou/'  + id
            url += '/?&ou_id=' + id + '&hdn_item_id=' + id + '&pop_win=1';
            url += '&parent_ou_id=' + $("#hdn_current_ou_id").val();
            url += '&parent_ou_name=' + escape($("#hdn_current_ou_name").val());

        ou_pop_win(url);
    }

    function row_group_pop_win(id)
    {
        var url = '<?php echo $this->get_controller_url();?>dsp_single_group/'  + id
            url += '/?&group_id=' + id + '&hdn_item_id=' + id + '&pop_win=1';
            url += '&parent_ou_id=' + $("#hdn_current_ou_id").val();
            url += '&parent_ou_name=' + escape($("#hdn_current_ou_name").val());

        user_pop_win(url);
    }

    function quick_delete_ou(ou_id)
    {
        var f = document.frmMain;
        if (confirm('<?php echo __('are you sure to delete all selected object?');?>')){
            f.hdn_item_id.value =  ou_id;
            m = $("#controller").val() + 'delete_ou';
            $("#frmMain").attr("action", m);
            f.submit();
        }
    }


    function quick_delete_user(user_id)
    {
        var f = document.frmMain;
        if (confirm('<?php echo __('are you sure to delete all selected object?');?>')){
            f.hdn_item_id.value =  user_id;
            m = $("#controller").val() + 'delete_user';
            $("#frmMain").attr("action", m);
            f.submit();
        }
    }

    function quick_delete_group(group_id)
    {
        var f = document.frmMain;
        if (confirm('<?php echo __('are you sure to delete all selected object?');?>')){
            f.hdn_item_id.value =  group_id;
            m = $("#controller").val() + 'delete_group';
            $("#frmMain").attr("action", m);
            f.submit();
        }
    }
</script>