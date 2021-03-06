<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php
$arr_all_village = $arr_all_member['arr_all_village'];
$arr_all_district = $arr_all_member['arr_all_district'];

$v_spec_code = get_post_var('sel_spec_code', '');
$v_member_id = get_post_var('sel_village', '');
$v_month = get_post_var('sel_month', (int) Date('m'));
$v_year = get_post_var('sel_year', (int) Date('Y'));
?>
<div class="col-md-12">
    <h3 class="synthesis-title margin-top-0" ><?php echo __('statistical records denied') ?></h3>
</div>
<div class="col-md-12">
    <div class="div-synthesis">
        <form class="form-horizontal" action="" method="post" name="frmMain" id="frmMain" role="form">
            <?php echo $this->hidden('controller', $this->get_controller_url()); ?>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label col-md-3"><?php echo __('field') ?></label>
                        <div class="col-md-9">
                            <select name="sel_spec_code" id="sel_spec_code" class="form-control">
                                <option value="">-- <?php echo __('all field') ?> --</option>
                                <?php foreach ($arr_all_spec as $v_code => $v_name): ?>
                                    <?php $v_selected = ($v_code == $v_spec_code) ? ' selected' : ''; ?>
                                    <option value="<?php echo $v_code; ?>" <?php echo $v_selected; ?>><?php echo $v_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label col-md-3"><?php echo __('units') ?></label>
                        <div class="col-md-9">
                            <select name="sel_village" id="sel_village" class="form-control">
                                <option value="">-- <?php echo __('all unit') ?> --</option>
                                <?php
                                foreach ($arr_all_district as $arr_district):
                                    $v_name = $arr_district['C_NAME'];
                                    $v_id = $arr_district['PK_MEMBER'];
                                    $v_selected = ($v_id == $v_member_id) ? 'selected' : '';
                                    ?>
                                    <option  <?php echo $v_selected ?> value="<?php echo $v_id ?>"><?php echo $v_name ?></option>
                                    <?php
                                    foreach ($arr_all_village as $key => $arr_village):
                                        $v_village_name = $arr_village['C_NAME'];
                                        $v_village_id = $arr_village['PK_MEMBER'];
                                        $v_parent_id = $arr_village['FK_MEMBER'];
                                        if ($v_parent_id != $v_id) {
                                            continue;
                                        }
                                        $v_selected = ($v_village_id == $v_member_id) ? 'selected' : '';
                                        ?>
                                        <option <?php echo $v_selected ?> value="<?php echo $v_village_id ?>"><?php echo '---- ' . $v_village_name ?></option>
                                        <?php
                                        unset($arr_all_village[$key]);
                                    endforeach;
                                    ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <label class='col-md-3 control-label'><?php echo __('month') ?></label>
                        <div class="col-md-9">
                            <select class='form-control' name='sel_month' id='sel_month'>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    $selected = ($i == $v_month) ? 'selected' : '';
                                    echo "<option $selected value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-md-3 control-label"><?php echo __('year') ?></label>
                        <div class="col-md-9">
                            <select class="form-control" name='sel_year' id='sel_year'>
                                <?php
                                $v_max_year = $arr_year['C_MAX_YEAR'];
                                $v_min_year = $arr_year['C_MIN_YEAR'];
                                $v_loop = ($v_max_year - $v_min_year) + 1;
                                for ($i = 0; $i < $v_loop; $i++) {
                                    $year = $v_min_year + $i;
                                    $selected = ($year == $v_year) ? 'selected' : '';
                                    echo "<option $selected value='$year'>$year</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align: right">
                    <button type="submit" class="btn btn-search">
                        <span class="glyphicon glyphicon-search "></span>
                        <?php echo __('search') ?>
                    </button>
                    <button type="button" class="btn btn-default" onclick="btn_reset_onclick();">
                        <i class="glyphicon glyphicon-remove "></i>
                        <?php echo __('clear') ?>
                    </button>
                </div>
            </div><!--end synthesis-->
            <div class="clearfix"></div>
        </form>
    </div> <!--end col md 12 block-->


    <div class="col-md-12 block">
        <div class="panel panel-default">
            <div class="panel-heading uppercase">
                <?php echo __('record list') ?>
            </div>
                <div class="panel-body">
                    <table class="table table-bordered">
            <tr>
                <th class="top blue"><?php echo __('unit name') ?></th>
<!--                        <th class="top orange"><?php echo __('receive') ?></th>
                <th class="top orange"><?php echo __('previous period') ?></th>-->
                <th class="top blue"><?php echo __('reject') ?></th>
                <th class="last blue"><?php echo __('citizens withdraw') ?></th>
            </tr>
            <?php
            $v_current_spec = '';
            for ($i = 0, $n = sizeof($arr_all_report_data); $i < $n; $i++) {
                $arr_report_data = $arr_all_report_data[$i];

                $v_unit_name = $arr_report_data['C_NAME'];
                $v_unit_code = $arr_report_data['C_UNIT_CODE'];
                $v_ky_truoc = $arr_report_data['C_COUNT_KY_TRUOC'];

                $v_spec_name = $arr_report_data['C_SPEC_NAME'];
                $v_spec_code = $arr_report_data['C_SPEC_CODE'];

                $v_total_record = $arr_report_data['C_COUNT_TONG_TIEP_NHAN_TRONG_THANG'];

                $v_cong_dan_rut = $arr_report_data['C_COUNT_CONG_DAN_RUT'];
                $v_tu_choi = $arr_report_data['C_COUNT_TU_CHOI'];

                if ($v_unit_code == NULL or $v_unit_code == '') {
                    continue;
                }

                if ($v_current_spec != $v_spec_code) {
                    $v_current_spec = $v_spec_code;
                    echo "<tr data-spec='$v_spec_code'>
                                    <td class='end' >$v_spec_name</td>
                                    <td class='end center' data-index = '1' data-sum='1' data-format='1'></td>
                                    <td class='end center' data-index = '2' data-sum='1' data-format='1'></td>
                                <!--   <td class='end center' data-index = '3' data-sum='1' data-format='1'></td>
                                    <td class='end center' data-index = '4' data-sum='1' data-format='1'></td> -->
                                  </tr>";
                }
                ?>
                <tr data-spec-child="<?php echo $v_spec_code ?>">
                    <td class="blue" style="width: 70%"><?php echo $v_unit_name; ?></td>
                    <!--<td data-format='1' class="orange center"><?php echo $v_total_record; ?></td>-->
                    <!--<td data-format='1' class="orange center"><?php echo $v_ky_truoc; ?></td>-->
                    <td data-format='1' class="blue center" style="width: 15%"><?php echo $v_tu_choi ?></td>
                    <td data-format='1' class="right blue center" style="width: 15%"><?php echo $v_cong_dan_rut; ?></td>
                </tr>
                <?php
            }//end for i
            ?>
        </table>
                </div>
        </div>
    </div><!--  #result -->
</div>
<div class="clear" style="height: 10px;"></div>
<script>
    $(document).ready(function () {
        //dem tong so
        $('.table_synthesis tr[data-spec]').each(function () {
            var spec_code = $(this).attr('data-spec');
            fill_total_data(this, spec_code);
        });

        //formart number
        $('.table_synthesis tr').each(function () {
            $(this).find('td[data-format="1"]').each(function () {
                $(this).html(number_format(parseInt($(this).html()), 0));
            });
        });
    });
    function fill_total_data(tr, spec_code)
    {
        $(tr).find('td[data-sum="1"]').each(function () {
            var index = $(this).attr('data-index');
            var data = sum_data(spec_code, index);
            $(this).html(data);
        });
    }
    function sum_data(spec_code, index)
    {
        var data = 0;
        $('.table_synthesis tr[data-spec-child="' + spec_code + '"]').each(function () {
            data = data + parseInt($(this).find('td:eq(' + index + ')').html());
        });

        return data;
    }
    function number_format(n, d)
    {
        var number = String(n.toFixed(d).replace('.', ','));
        return number.replace(/./g, function (c, i, a) {
            return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
        });
    }
    function btn_reset_onclick()
    {
        var f = document.frmMain;
        f.sel_village.value = '';
        f.sel_spec_code.value = '';
        f.sel_month.value = '';
        f.sel_year.value = '<?php echo (int) Date('Y') ?>';
    }
</script>