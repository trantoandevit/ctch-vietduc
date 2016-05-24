<?php
defined('DS') or die('no direct access');
?>
<form class="grid_23" name="frmMain" id="frmMain" action="#" method="post">
    <?php
    echo $this->hidden('controller', $this->get_controller_url());

    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_article');
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_article');
    echo $this->hidden('hdn_update_method', 'update_general_info');
    echo $this->hidden('hdn_delete_method', 'delete_article');

    echo $this->hidden('hdn_item_id', $v_id);
    echo $this->hidden('hdn_thumbnail', $v_thumbnail_file);
    echo $this->hidden('hdn_user', Session::get('user_id'));
    echo $this->hidden('hdn_item_id_list', '');

    echo $this->hidden('XmlData', '');
    ?>
</form>
<form name="frmVersion" id="frmVersion">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <colgroup>
                    <col width="10%">
                    <col width="20%">
                    <col width="15%">
                    <col width="25%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <tr>
                    <th><?php echo __('version') ?></th>
                    <th><?php echo __('date') ?></th>
                    <th><?php echo __('action') ?></th>
                    <th><?php echo __('user') ?></th>
                    <th><?php echo __('status') ?></th>
                    <th><?php echo __('details') ?></th>
                </tr>
                <?php
                $n = count($arr_all_version);
                $i = 0;
                ?>
                <?php for ($i = $n - 1; $i >= 0; $i--): ?>
                    <?php
                    $item         = $arr_all_version[$i];
                    $v_version_id = $item['id'];
                    $v_date       = new DateTime($item['date']);
                    $v_user_name  = $item['user_name'];
                    $arr_status   = array(
                        0              => __('draft'),
                        3              => __('published')
                    );
                    $v_status      = $arr_status[$item['status']];
                    $v_action      = __($item['action']);
                    $v_has_content = $item['has_content'];
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="Center"><?php echo $v_version_id ?></td>
                        <td class="Center"><?php echo $v_date->format('d/m/Y H:i') ?></td>
                        <td class="Center"><?php echo $v_action ?></td>
                        <td><?php echo $v_user_name ?></td>
                        <td class="Center"><?php echo $v_status ?></td>
                        <td class="Center">
                            <?php if ($v_has_content): ?>
                                <a href="javascript:;" onClick="version_onclick(<?php echo $v_version_id ?>);">
                                    <?php echo __('details') ?>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
                <?php $n = get_request_var('sel_rows_per_page', _CONST_DEFAULT_ROWS_PER_PAGE); ?>
                <?php for ($i; $i < $n; $i++): ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
</form>
<div class="button-area">
    <button type="button" class="btn btn-outline btn-warning" onClick="btn_back_onclick();">
        <i class="fa fa-reply" ></i> <?php echo __('goback to list'); ?>
    </button>
</div>

<script>
    function version_onclick($version_id)
    {
        $url = "<?php echo $this->get_controller_url() . 'dsp_single_version/' . "&article=$v_id" ?>";
        $url += "&version=" +$version_id;
        showPopWin($url, 800, 600, null);
    }
</script>