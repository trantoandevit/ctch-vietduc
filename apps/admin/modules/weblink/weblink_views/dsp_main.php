<?php
defined('DS') or die();
//$this->template->title = __('web link');
//$this->template->display('dsp_header.php');
$this->_page_title = __('web link');
?>
<script src="<?php echo SITE_ROOT ?>public/js/angular.min.js"></script>

<?php
function buttons() {
    ?>
    <div class="button-area">
        <button type="button" class="btn btn-outline btn-primary" onclick="row_onclick(0)">
            <i class="fa fa-plus"></i><?php echo __('add new') ?></button>
        <button type="button" class="btn btn-outline btn-danger" onclick="btn_delete_onclick();">
            <i class="fa fa-times"></i><?php echo __('delete') ?></button>
    </div>
    <?php
}

//end function  
?>

<h1 class="page-header" style="font-size: 32px;"><?php echo __('web link') ?></h1>

<form name="frmMain" id="frmMain" method="post">
    <input type="hidden"  id="controller" value="<?php echo $this->get_controller_url(); ?>"/>
    <input type="hidden" id="hdn_dsp_single_method" value="dsp_single_weblink"/>
    <?php echo buttons() ?>

        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <colgroup>
                        <col width="10%">
                        <col width="22%">
                        <col width="22%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="chk_all"/></th>
                            <th><?php echo __('name') ?></th>
                            <th><?php echo __('url') ?></th>
                            <th><?php echo __('begin date') ?></th>
                            <th><?php echo __('status') ?></th>
                            <th><?php echo __('order') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = count($arr_all_weblink) ?>
                        <?php
                        for ($i = 0; $i < $n; $i++):
                            ?>
                            <?php
                            $item = $arr_all_weblink[$i];
                            $v_prev = isset($arr_all_weblink[$i - 1]) ? $arr_all_weblink[$i - 1]['PK_WEBLINK'] : '';
                            $v_next = isset($arr_all_weblink[$i + 1]) ? $arr_all_weblink[$i + 1]['PK_WEBLINK'] : '';

                            $tr_class = 'row' . ($i % 2);
                            $img_up = SITE_ROOT . 'public/images/up.png';
                            $img_down = SITE_ROOT . 'public/images/down.png';
                            $arr_statuses = array(
                                1 => __('active status')
                                , 0 => __('inactive status')
                            );
                            ?>
                            <tr>
                                <td class="Center">
                                    <input type="checkbox" value="<?php echo $item['PK_WEBLINK'] ?>" name="chk_item[]" class="chk_item"
                                           />
                                </td>
                                <td>
                                    <a href="javascript:;" onclick="row_onclick(<?php echo $item['PK_WEBLINK'] ?>)">
                                        <?php echo $item['C_NAME'] ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo $item['C_URL'] ?>">
                                        <?php echo $item['C_URL'] ?>
                                    </a>
                                </td>
                                <td class="Center"><?php echo $item['C_BEGIN_DATE'] ?></td>
                                <td class="Center">
                                    <?php echo $arr_statuses[$item['C_STATUS']] ?>
                                </td>
                                <td class="Center">
                                    <?php if ($v_prev): ?>
                                        <a href="javascript:;" onclick="swap_order(<?php echo $item['PK_WEBLINK'] ?>,<?php echo $v_prev ?>)">
                                            <i class=" fa fa-arrow-up" style="font-size:18px;"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($v_next): ?>
                                        <a href="javascript:;" onclick="swap_order(<?php echo $item['PK_WEBLINK'] ?>,<?php echo $v_next ?>)">
                                            <i class=" fa fa-arrow-down" style="font-size:18px;"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endfor; ?>
                        <?php
                        for ($i; $i < _CONST_DEFAULT_ROWS_PER_PAGE; $i++):
                            ?>
                            <tr>
                                <td></td>
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
    

<?php echo buttons() ?>
</form>
<script>
    toggle_checkbox('#chk_all', '.chk_item');
    function swap_order(v_item1, v_item2) {
        $.ajax({
            type: 'post'
            , url: '<?php echo $this->get_controller_url() ?>' + 'swap_order'
            , data: {item1: v_item1, item2: v_item2}
            , success: function () {
                window.location.reload();
            }
        });
    }

    window.btn_delete_onclick = function(){
        $url = "<?php echo $this->get_controller_url() ?>" + "delete_weblink";
        if($('.chk_item:checked').length == 0)
        {
            alert("<?php echo __('you must choose atleast one object') ?>");
            return;
        }
        if(!confirm("<?php echo __('are you sure to delete all selected object?') ?>"))
        {
            return;
        }
        $.ajax({
            type: 'post',
            url: $url,
            data: $('#frmMain').serialize(),
            success: function(){window.location.reload();}
        });
    }


    window.row_onclick = function (id) {
        v_url = $('#controller').val() + $('#hdn_dsp_single_method').val() + '/' + id;
        window.location = v_url;
    }
</script>