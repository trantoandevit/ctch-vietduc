<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed');?>
<?php
    $v_month = get_post_var('sel_month',(int) Date('m'));
    $v_year = get_post_var('sel_year',(int) Date('Y'));
    
    $json_data          = json_encode($arr_synthesis_chart);
    $json_data_village  = json_encode($arr_synthesis_of_village);
?>
<html>
    <head>
        <!--style-->
        <link rel="stylesheet" href="<?php echo SITE_ROOT; ?>apps/frontend/slideshow.css" type="text/css"  />
        <link rel="SHORTCUT ICON" href="<?php echo SITE_ROOT ?>favicon.ico">
        <!--jquery-->
        <script type="text/javascript" src="<?php echo SITE_ROOT.'public/bootstrap/'?>js/jquery.min.js"></script>
        <!--bootstrap-->
        <link rel="stylesheet" href="<?php echo SITE_ROOT.'public/bootstrap'?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo SITE_ROOT.'public/bootstrap'?>/css/bootstrap-theme.min.css">
        <script src="<?php echo SITE_ROOT.'public/bootstrap'?>/js/bootstrap.min.js"></script>
        <!--flot chart-->
        <script language="javascript" type="text/javascript" src="<?php echo SITE_ROOT.'public/flot/jquery.flot.js'?>"></script>
        <script language="javascript" type="text/javascript" src="<?php echo SITE_ROOT.'public/flot/jquery.flot.categories.js'?>"></script>
        <script language="javascript" type="text/javascript" src="<?php echo SITE_ROOT.'public/flot/jquery.flot.stack.js'?>"></script>
        <script language="javascript" type="text/javascript" src="<?php echo SITE_ROOT.'public/flot/jquery.flot.pie.js'?>"></script>
        <style>
            .tickLabel{
               font-weight: bold;
               font-size: 10pt;
            }
        </style>
    </head>
    <body>
        <?php echo $this->hidden('hdn_json_data',$json_data)?>
        <?php echo $this->hidden('hdn_json_data_village',$json_data_village)?>
        <script>
            var data_json           = JSON.parse($('#hdn_json_data').val());
            var data_json_village   = JSON.parse($('#hdn_json_data_village').val());
            var interval;
            var interval_status = 1;
            var index = 1;
            //tao bieu do 
            function create_chart(div_show,data,option)
            {
                $.plot(div_show, data, option);
            }
            //function tao bieu do pie
            function create_pie_chart(div_show,data)
            {
                var options = {
				series: {
					pie: { 
						show: true,
						radius: 1,
						label: {
							show: true,
							radius: 3/4,
							formatter: labelFormatter,
							background: {
								opacity: 0
							}
						}
					}
				},
				legend: {
					show: false
				}
			};
                create_chart(div_show,data,options);
            }
            
            //formart label
            function labelFormatter(label, series) 
            {
		return "<div style='font-size:8pt; background-color: transparent;text-align:center; padding:0px; color:white;'>" 
                        + label + "<br/>" + Math.round(series.percent) + "% - " + number_format(series.data[0][1],0) + "\n\
                        </div>";
            }
            
            //function tao bieu do stack
            function create_stack_chart(div_show,data,ticks,div_note)
            {
                var stack = 0,
                    bars = true,
                    lines = false,
                    steps = false;
    
                var options = {
                            series: {
                                bars: {
                                    show: true,
                                    fillColor: "#D9D9D9"
                                }
                            },
                            bars: {
                                align: "center",
                                barWidth: 0.5,
                                horizontal: true,
                                fillColor: { colors: [{ opacity: 0.5 }, { opacity: 1}] },
                                lineWidth: 1
                            },
                            xaxis: {
                                axisLabelPadding: 10,
                                color: "#D9D9D9"
                            },
                            yaxis: {
                                axisLabelPadding: 3,
                                axisLabelFontSizePixels: 11,
                                axisLabelFontFamily: 'Tahoma',
                                ticks: ticks
                            },
                            legend: {
                                noColumns: 0,
                                labelBoxBorderColor: "#858585",
                                position: "ne"
                            },
                            grid: {
                                          borderWidth: 1,
                                          borderColor: "#545454",
                                          autoHighlight: true
                                      }
                                  };
                options.series.stack = stack;
                options.series.lines = {show: lines,fill: true,steps: steps};
                options.legend.show = false;
                
                //tao bieu do
                create_chart(div_show,data,options);
                //tao note
                var label = '';
                var color = '';
                var note = '';
                for (var key in data)
                {
                    label = data[key].label;
                    color = data[key].color;
                    note = data[key].note;
                    if(note != '')
                    {
                        $(div_note).append('<div><label class="width_50" style="background-color: '+color+'">&nbsp;</label>&nbsp;'+label+': '+note+'</div>');
                    }
                }
            }
            function show_slide(div_slide)
            {
                if($(div_slide).find('.item').length == index)
                {
                    index = 0;
                }
                $(div_slide).find('.item').hide(2000);
                $(div_slide).find('.item:eq('+index+')').show(2000);
                index++;
            }
            //format number
            function number_format(n,d)
            {
                var number = String(n.toFixed(d).replace('.',','));
                return number.replace(/./g, function(c, i, a) {
                            return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
                        });
            }
        </script>
        
        <div id="myCarousel" >
            <div id="carousel-inner">
                <div class="benner" style="width: 100%;text-align: center;padding: 0 15px 0 15px;background: rgb(0, 51, 153); ">
                    <!--<img src="<?php echo FULL_SITE_ROOT.'public/images/DuAnTangCuongCCHC.png' ?>" width="100%">-->
                    <?php
                    $v_array_str = explode('.', $v_banner);
                    $v_extension = $v_array_str[count($v_array_str) - 1];
                ?>
                <?php if (strtolower($v_extension) == 'swf'): ?>
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="<?php SITE_ROOT . "upload/flash/swflash.cab" ?>"  width="100%" height="100%">
                        <param name="movie" value="<?php echo SITE_ROOT . "upload/" . $v_banner; ?>">
                        <param name="quality" value="high">
                        <PARAM NAME="SCALE" VALUE="exactfit">
                        <embed src="<?php echo SITE_ROOT . "upload/" . $v_banner; ?>" quality="high" width="100%" height="100%" SCALE="exactfit" 
                               pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" 
                        >
                    </object>
                <?php else: ?>
                    <img src="<?php echo SITE_ROOT . "upload/" . $v_banner; ?>"/>
                <?php endif; ?>
                </div>
                <div class="item">
                    <div class="div-synthesis">
                        <h4 class="right-line" style='margin-left: 10px;font-size: 20px;font-weight: bold'>Bảng tổng hợp giải quyết thủ tục hành chính tháng <?php echo Date('m').'/'.Date('Y')?></h4>
                        <div>
                            <table class="table table-bordered">
                                <tr>
                                    <th class="first blue" style="width: 17%;" rowspan="2"><?php echo __('unit name'); ?></th>
                                    <th class="top orange" colspan="3"><?php echo __('receive'); ?></th>
                                    <th class="top green" colspan="4"><?php echo __('outstanding'); ?></th>
                                    <th class="top purple" colspan="8"><?php echo __('has settled'); ?></th>
                                </tr>
                                <tr>
                                    <th class="orange"><?php echo __('cumulative'); ?></th>
                                    <th class="orange"><?php echo __('previous period'); ?></th>
                                    <th class="orange"><?php echo __('in month'); ?></th>

                                    <th class="green"><?php echo __('total'); ?></th>
                                    <th class="green"><?php echo __('not yet'); ?></th>
                                    <th class="green"><?php echo __('overdue'); ?></th>
                                    <th class="green"><?php echo __('Bổ sung'); ?></th>

                                    <th class="purple"><?php echo __('total'); ?></th>
                                    <th class="purple"><?php echo __('soon'); ?></th>
                                    <th class="purple"><?php echo __('on time'); ?></th>
                                    <th class="purple"><?php echo __('overdue'); ?></th>
                                    <th class="purple"><?php echo __('Đang chờ trả'); ?></th>
                                    <th class="purple"><?php echo __('reject'); ?></th>
                                    <th class="purple"><?php echo __('citizens withdraw'); ?></th>
                                    <th class="purple"><?php echo __('the rate of soon and on time'); ?></th>
                                </tr>
                                <?php 
                                    $i = 1;
                                ?>
                                <?php foreach($arr_table_synthesis as $arr_value):
                                        $v_member_name = $arr_value['C_NAME'];

                                        $v_tong_tiep_nhan_thang = $arr_value['C_COUNT_TONG_TIEP_NHAN_TRONG_THANG'];

                                        $v_luy_ke = $arr_value['C_COUNT_LUY_KE'];

                                        $v_dang_thu_ly             = $arr_value['C_COUNT_DANG_THU_LY'];
                                        $v_dang_cho_tra_ket_qua    = $arr_value['C_COUNT_DANG_CHO_TRA_KET_QUA'];
                                        $v_dang_thu_ly_dung_tien_do= $arr_value['C_COUNT_DANG_THU_LY_DUNG_TIEN_DO'];
                                        $v_dang_thu_ly_cham_tien_do= $arr_value['C_COUNT_DANG_THU_LY_CHAM_TIEN_DO'];
                                        $v_thu_ly_qua_han          = $arr_value['C_COUNT_THU_LY_QUA_HAN'];
                                        $v_thue                    = $arr_value['C_COUNT_THUE'];

                                        $v_da_tra_ket_qua_truoc_han= $arr_value['C_COUNT_DA_TRA_KET_QUA_TRUOC_HAN'];
                                        $v_da_tra_ket_qua_dung_han = $arr_value['C_COUNT_DA_TRA_KET_QUA_DUNG_HAN'];
                                        $v_da_tra_ket_qua_qua_han  = $arr_value['C_COUNT_DA_TRA_KET_QUA_QUA_HAN'];
                                        $v_da_tra_ket_qua          = $arr_value['C_COUNT_DA_TRA_KET_QUA'];

                                        $v_cong_dan_rut = $arr_value['C_COUNT_CONG_DAN_RUT'];
                                        $v_tu_choi      = $arr_value['C_COUNT_TU_CHOI'];
                                        $v_bo_sung      = $arr_value['C_COUNT_BO_SUNG'];

                                        $v_tong_da_tra          = $v_da_tra_ket_qua_truoc_han + $v_da_tra_ket_qua_dung_han + $v_da_tra_ket_qua_qua_han;
                                        $v_tong_dang_giai_quyet = $v_dang_thu_ly + $v_bo_sung;
                                        $v_ky_truoc             = ($v_tong_dang_giai_quyet + $v_tong_da_tra + $v_tu_choi + $v_cong_dan_rut + $v_dang_cho_tra_ket_qua) - $v_tong_tiep_nhan_thang;
                                        $v_ky_truoc = ($v_ky_truoc > 0) ? $v_ky_truoc : 0;
                                        //tinh toan ty le
                                        $v_ty_le = 0;
                                        if ($v_tong_da_tra > 0)
                                        {
                                            $v_ty_le = (($v_da_tra_ket_qua_truoc_han + $v_da_tra_ket_qua_dung_han) / $v_tong_da_tra) * 100;
                                        }

                                        $v_ty_le = number_format($v_ty_le, 2,',','.');
                                ?>
                                <tr class="<?php echo ($i % 2) ? 'xam' : ''; ?>">
                                    <td class="blue left" style="width: 23%">
                                        <?php echo $i . '.  ' . $v_member_name ?>
                                    </td>
                                    <td class="orange center bold" style="width: 5%">
                                        <?php echo $v_luy_ke ?>
                                    </td>
                                    <td class="orange center" style="width: 5%">
                                        <?php echo $v_ky_truoc ?>
                                    </td>
                                    <td class="orange center" style="width: 5%">
                                        <?php echo $v_tong_tiep_nhan_thang ?>
                                    </td>

                                    <td class="green center" style="width: 5%">
                                        <?php echo $v_dang_thu_ly + $v_bo_sung ?>
                                    </td>
                                    <td class="green center" style="width: 5%">
                                        <?php echo ($v_dang_thu_ly - $v_thu_ly_qua_han) ?>
                                    </td>
                                    <td class="green center" style="width: 5%">
                                        <?php echo $v_thu_ly_qua_han ?>
                                    </td>
                                    <td class="green center" style="width: 5%">
                                        <?php echo $v_bo_sung ?>
                                    </td>

                                    <td class="purple center bold" style="width: 5%">
                                        <?php echo (      $v_da_tra_ket_qua_truoc_han 
                                                        + $v_da_tra_ket_qua_dung_han 
                                                        + $v_da_tra_ket_qua_qua_han 
                                                        + $v_dang_cho_tra_ket_qua
                                                        + $v_cong_dan_rut
                                                        + $v_tu_choi
                                                    ) ?>
                                    </td>
                                    <td class="purple center" style="width: 5%">
                                        <?php echo $v_da_tra_ket_qua_truoc_han ?>
                                    </td>
                                    <td class="purple center" style="width: 5%">
                                        <?php echo $v_da_tra_ket_qua_dung_han ?>
                                    </td>
                                    <td class="purple center" style="width: 5%">
                                        <?php echo $v_da_tra_ket_qua_qua_han ?>
                                    </td>
                                    <td class="purple center" style="width: 5%">
                                        <?php echo $v_dang_cho_tra_ket_qua ?>
                                    </td>

                                    <td class="purple center" style="width: 5%">
                                        <?php echo $v_tu_choi ?>
                                    </td>
                                    <td class="purple center" style="width: 5%">
                                        <?php echo $v_cong_dan_rut ?>
                                    </td>
                                    <td class="purple right center" >
                                        <?php echo $v_ty_le . '%' ?>
                                    </td>
                                </tr>
                                <?php $i++;?>
                                <?php endforeach;?>
                                <tr>
                                    <td class="center end left"><?php echo __('total'); ?> (<?php echo $i - 1 ?> <?php echo __('units') ?>)</td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end"></td>
                                    <td class="center end right"></td>
                                </tr>
                            </table>
                            <script>
                                $(document).ready(function(){
                                    var obj_sum = {
                                            TN_luy_ke            : parseInt(sum_col_table_synthesis(1)),
                                            TN_ky_truoc          : parseInt(sum_col_table_synthesis(2)),
                                            TN_trong_thang       : parseInt(sum_col_table_synthesis(3)),
                                            DANG_GQ_tong_so      : parseInt(sum_col_table_synthesis(4)),
                                            DANG_GQ_chua_den_han : parseInt(sum_col_table_synthesis(5)),
                                            DANG_GQ_chua_qua_han : parseInt(sum_col_table_synthesis(6)),
                                            DANG_GQ_bo_sung      : parseInt(sum_col_table_synthesis(7)),
                                            DA_GQ_tong_so        : parseInt(sum_col_table_synthesis(8)),
                                            DA_GQ_som_han        : parseInt(sum_col_table_synthesis(9)),
                                            DA_GQ_dung_han       : parseInt(sum_col_table_synthesis(10)),
                                            DA_GQ_qua_han        : parseInt(sum_col_table_synthesis(11)),
                                            DA_GQ_dang_cho_tra   : parseInt(sum_col_table_synthesis(12)),
                                            tu_choi              : parseInt(sum_col_table_synthesis(13)),
                                            cong_dan_rut         : parseInt(sum_col_table_synthesis(14))
                                    };

                                    //tinh toan bang sum cua bang tong hop
                                    insert_to_table_synthesis(obj_sum);
                                });
                                function insert_to_table_synthesis(obj_sum)
                                {
                                    var tong_da_tra = obj_sum.DA_GQ_som_han + obj_sum.DA_GQ_dung_han + obj_sum.DA_GQ_qua_han;
                                    if(tong_da_tra == 0)
                                    {
                                        var tong_ty_le = '--';
                                    }
                                    else
                                    {
                                        var tong_ty_le = ((obj_sum.DA_GQ_som_han + obj_sum.DA_GQ_dung_han) / tong_da_tra) * 100;
                                        tong_ty_le = number_format(tong_ty_le, 2) + '%';
                                    }

                                    $('table.table_synthesis tr td.end').eq(1).html(number_format(obj_sum.TN_luy_ke,0));
                                    $('table.table_synthesis tr td.end').eq(2).html(number_format(obj_sum.TN_ky_truoc,0));
                                    $('table.table_synthesis tr td.end').eq(3).html(number_format(obj_sum.TN_trong_thang,0));

                                    $('table.table_synthesis tr td.end').eq(4).html(number_format(obj_sum.DANG_GQ_tong_so,0));
                                    $('table.table_synthesis tr td.end').eq(5).html(number_format(obj_sum.DANG_GQ_chua_den_han,0));
                                    $('table.table_synthesis tr td.end').eq(6).html(number_format(obj_sum.DANG_GQ_chua_qua_han,0));
                                    $('table.table_synthesis tr td.end').eq(7).html(number_format(obj_sum.DANG_GQ_bo_sung,0));

                                    $('table.table_synthesis tr td.end').eq(8).html(number_format(obj_sum.DA_GQ_tong_so,0));
                                    $('table.table_synthesis tr td.end').eq(9).html(number_format(obj_sum.DA_GQ_som_han,0));
                                    $('table.table_synthesis tr td.end').eq(10).html(number_format(obj_sum.DA_GQ_dung_han,0));
                                    $('table.table_synthesis tr td.end').eq(11).html(number_format(obj_sum.DA_GQ_qua_han,0));
                                    $('table.table_synthesis tr td.end').eq(12).html(number_format(obj_sum.DA_GQ_dang_cho_tra,0));

                                    $('table.table_synthesis tr td.end').eq(13).html(number_format(obj_sum.tu_choi,0));
                                    $('table.table_synthesis tr td.end').eq(14).html(number_format(obj_sum.cong_dan_rut,0));

                                    $('table.table_synthesis tr td.end').eq(15).html(tong_ty_le);
                                    $('.result .val').text(tong_ty_le);

                                }
                                function sum_col_table_synthesis(index,searchVal,v_float)
                                {
                                    if (typeof searchVal == 'undefined')
                                    {
                                        searchVal = ' ';
                                    }

                                    if (typeof vfloat == 'undefined')
                                    {
                                        vfloat = 0;
                                    }

                                    var return_val = 0;
                                    var val = '';
                                    var selector = 'td:eq(' + index + '):not(.end)';

                                    //tinh toan du lieu
                                    $('table.table_synthesis tr').find(selector).each(function() {
                                        val = $(this).html();
                                        //format number
                                        if (vfloat == 0) {
                                            $(this).html(number_format(parseInt(val), 0));
                                            return_val = parseInt(val) + return_val;
                                        }
                                        else
                                        {
                                            $(this).html(number_format(parseFloat(val), 2));
                                            return_val = parseFloat(val) + return_val;
                                        }
                                    });

                                    return return_val;
                                }
                            </script>
                        </div>
                    <div class="div-footer">
                    </div>
                    </div><!--end synthesis-->
                </div>
            <?php 
                $cur_unit_code = '';
                $html          = '';               
            ?>
            <?php 
            foreach($arr_synthesis_chart as $synthesis_chart)
            {
                $v_unit_code     = $synthesis_chart['C_UNIT_CODE'];
                $v_unit_name     = $synthesis_chart['C_NAME'];
                $v_count_village = $synthesis_chart['C_COUNT_VILLAGE'];
                
                if($cur_unit_code != $v_unit_code)
                {
                    $v_synthesis_chart_title = "Tình hình giải quyết TTHC";
                    $v_progress_chart_title = "Biểu đồ tiến độ";
                    $v_return_title = "Biểu đồ trả kết quả";
                    if($cur_unit_code == '')
                    {
                        $v_active = "active";
                    }
                    else
                    {
                        $v_active = '';
                    }
                    $html = '<div class="item '.$v_active.'">
                                    <div class="row">
                                        <div class="col-md-12 title">'. $v_unit_name . ' - Tháng ' . date('m') . '/' . date('Y').'</div>
                                        <div class="col-md-12 sub_title"><b>'. $v_synthesis_chart_title .'</b></div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="clear"></div>
                                            <div class="chart" id="synthesis_chart_'.$v_unit_code.'"></div>
                                            <div id="synthesis_note_'.$v_unit_code.'"></div>
                                        </div>
                                        <div class="col-md-4"> 
                                            <div class="row pie_chart">
                                                <div class="col-md-12 sub_title"><b>'.$v_progress_chart_title.'</b></div>
                                                <div class="col-md-12 tiny_chart" id="progress_chart_'.$v_unit_code.'"></div>
                                            </div>
                                            <div class="row pie_chart">
                                                <div class="col-md-12 sub_title"><b>'.$v_return_title.'</b></div>
                                                <div class="col-md-12 tiny_chart" id="return_chart_'.$v_unit_code.'"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    if((int)$v_count_village > 0)
                    {
                        $html .= '<div class="item">
                                <div class="row">
                                    <div class="col-md-12 title">
                                        Tình hình giải quyết TTHC các xã trực thuộc '.$v_unit_name.'
                                    </div>
                                    <div class="col-md-12 chart" id="synthesis_chart_'.$v_unit_code.'_of_village">
                                       
                                    </div>
                                     <div id="synthesis_note_'.$v_unit_code.'_of_village" ></div>
                                </div>
                            </div>';
                    }
                    $cur_unit_code = $v_unit_code;
                    echo $html;
                }
            }
           
            ?>
            </div><!--end carousel-inner-->
        </div><!--end my carousel-->
        <script>
            $(document).keypress(function(event){
               if(event.charCode == 32) 
               {
                   event.preventDefault();
                   if(interval_status == 1)
                   {
                        clearInterval(interval);
                        interval_status = 0;
                   }
                   else if(interval_status == 0)
                   {
                       show_slide('#myCarousel');
                       interval = setInterval(function(){
                            show_slide('#myCarousel');   
                        },8000);
                        interval_status = 1;
                   }
               }
            });
            $(document).ready(function() {
                //tao bien luu tru thong tin cua stack
                var data_receive = [];
                var data_processing = [];
                var data_return = [];
                
                var ticks = [];
                var div_note = '';
                var unit_code = '';
                var cur_unit_code = '';
                if(data_json.lenglength>0){
                    cur_unit_code = data_json[0].C_UNIT_CODE;
                }
                var div_id = '';
                
                //tao bien luu tru thong tin cua pie
                var data_progress_notyet = 0;
                var data_progress_overdue = 0;
                
                var data_return_soon = 0;
                var data_return_on_time = 0;
                var data_return_overdue = 0;
                
                //data set dung chung
                var dataSet = [];
                

                //tao du lieu cho bieu do tien do
                for(var i=0;i<data_json.length;i++)
                {
                    //unit code
                    unit_code = data_json[i].C_UNIT_CODE;
                    //ket thuc don vi => tao bieu do
                    if((unit_code != cur_unit_code) ||(i == data_json.length - 1))
                    {
                        //neu la bien cuoi cung
                        if(i == data_json.length - 1)
                        {
                            //du lieu bieu do stack
                            data_receive.push([data_json[i].C_COUNT_TONG_TIEP_NHAN_TRONG_THANG,i]);
                            data_processing.push([data_json[i].C_COUNT_DANG_THU_LY,i]);
                            data_return.push([data_json[i].C_COUNT_DA_TRA_KET_QUA,i]);
                            
                            ticks.push([i, data_json[i].C_SPEC_NAME]);
                            //gan thong tin (pie)
                            data_progress_notyet  = data_progress_notyet + (data_json[i].C_COUNT_DANG_THU_LY - data_json[i].C_COUNT_THU_LY_QUA_HAN);
                            data_progress_overdue = data_progress_overdue + data_json[i].C_COUNT_THU_LY_QUA_HAN;
                        }
                        
                        //tao selector
                        div_id   = '#synthesis_chart_' + cur_unit_code;
                        div_note = '#synthesis_note_' + cur_unit_code;
                        
                        dataSet = [{
                                    label: '<?php echo __('receive')?>',
                                    data: data_receive,
                                    color: '#EDC240',
                                    note: '<?php echo __('receiving records in month')?>'
                               },{
                                   label: '<?php echo __('processing')?>',
                                    data: data_processing,
                                    color: '#4DA74D',
                                    note: '<?php echo __('records are processing in month')?>'
                               },{
                                   label: '<?php echo __('return')?>',
                                    data: data_return,
                                    color: '#AFD8F8',
                                    note: '<?php echo __('return reocrd in month')?>'
                               }
                              ];
                        //tao bieu do stack
                        create_stack_chart(div_id,dataSet,ticks,div_note);
                        
                        //tao bieu do progress (pie)
                        div_id = '#progress_chart_' + cur_unit_code;
                        dataSet = [ 
                                    {
                                        label: "<?php echo __('not yet') ?>",
                                        data: data_progress_notyet,
                                        color: '#4DA74D',
                                        note: '<?php echo __('records are processing schedule as planned'); ?>'
                                    },  {
                                        label: "<?php echo __('overdue') ?>",
                                        data: data_progress_overdue,
                                        color: '#CB4B4B',
                                        note: '<?php echo __('records are processing overdue compared to the return date'); ?>'
                                    }
                                ];
                        create_pie_chart(div_id,dataSet,ticks,div_note);
                        
                        //tao bieu do return (pie)
                        div_id = '#return_chart_' + cur_unit_code;
                        dataSet = [ 
                                    {
                                        label: "<?php echo __('soon') ?>",
                                        data: data_return_soon,
                                        color: '#4DA74D',
                                        note: '<?php echo __('records are processing schedule as planned'); ?>'
                                    },  {
                                        label: "<?php echo __('on time') ?>",
                                        data: data_return_on_time,
                                        color: '#AFD8F8',
                                        note: '<?php echo __('records are processing overdue compared to the return date'); ?>'
                                    },  {
                                        label: "<?php echo __('overdue') ?>",
                                        data: data_return_overdue,
                                        color: '#CB4B4B',
                                        note: '<?php echo __('records are processing overdue compared to the return date'); ?>'
                                    }
                                ];
                        create_pie_chart(div_id,dataSet,ticks,div_note);
                        
                        //reset bien
                        data_receive    = [];
                        data_processing = [];
                        data_return     = [];
                        dataSet = [];
                        ticks = [];
                        
                        data_progress_notyet  = 0;
                        data_progress_overdue = 0;
                        data_return_soon      = 0;
                        data_return_on_time   = 0;
                        data_return_overdue   = 0;
                                                
                        //gan dv moi
                        cur_unit_code = unit_code;
                    }
                    //gan thong tin vao cac arr data (stack)
                    data_receive.push([data_json[i].C_COUNT_TONG_TIEP_NHAN_TRONG_THANG,i]);
                    data_processing.push([data_json[i].C_COUNT_DANG_THU_LY,i]);
                    data_return.push([data_json[i].C_COUNT_DA_TRA_KET_QUA,i]);
                    ticks.push([i, data_json[i].C_SPEC_NAME]);
                    
                    //gan thong tin (pie)
                    data_progress_notyet  = data_progress_notyet + (parseInt(data_json[i].C_COUNT_DANG_THU_LY) - parseInt(data_json[i].C_COUNT_THU_LY_QUA_HAN));
                    data_progress_overdue = data_progress_overdue + parseInt(data_json[i].C_COUNT_THU_LY_QUA_HAN);
                    data_return_soon      = data_return_soon + parseInt(data_json[i].C_COUNT_DA_TRA_KET_QUA_TRUOC_HAN);
                    data_return_on_time   = data_return_on_time + parseInt(data_json[i].C_COUNT_DA_TRA_KET_QUA_DUNG_HAN);
                    data_return_overdue   = data_return_overdue + parseInt(data_json[i].C_COUNT_DA_TRA_KET_QUA_QUA_HAN);
                }
                
                //build chart village
                console.log(data_json_village);
                cur_unit_code = data_json_village[0]['C_UNIT_CODE'];
                //reset bien
                data_receive    = [];
                data_processing = [];
                data_return     = [];
                dataSet = [];
                ticks = [];
                i=1;
                for(var j=0;j<data_json_village.length;j++)
                {                 
                    //unit code
                    unit_code = data_json_village[j].C_UNIT_CODE;
                    //ket thuc don vi => tao bieu do
                    if((unit_code != cur_unit_code) ||(j == data_json_village.length - 1))
                    {
                        //neu la bien cuoi cung
                        if(j == data_json_village.length - 1)
                        {
                            //du lieu bieu do stack
                            data_receive.push([data_json_village[j].C_COUNT_TONG_TIEP_NHAN_TRONG_THANG,i]);
                            data_processing.push([data_json_village[j].C_COUNT_DANG_THU_LY,i]);
                            data_return.push([data_json_village[j].C_COUNT_DA_TRA_KET_QUA,i]);
                            
                            ticks.push([i, data_json_village[j].C_NAME]);                            
                        } 
                        
                        //tao selector
                        div_id   = '#synthesis_chart_' + cur_unit_code+ '_of_village';
                        div_note = '#synthesis_note_' + cur_unit_code + '_of_village';
                        //neu so luong xa qua it mac dinh them 10 row
                        if(data_receive.length < 10)
                        {
                            var count = 10 - data_receive.length;
                            for(var loop=0; loop > (count*-1); loop--)
                            {
                                data_receive.push([0,loop]);
                                data_processing.push([0,loop]);
                                data_return.push([0,loop]);
                                ticks.push([loop,'']);
                            }
                        }
                        //tao dataset
                        dataSet = [{
                                    label: '<?php echo __('receive')?>',
                                    data: data_receive,
                                    color: '#EDC240',
                                    note: '<?php echo __('receiving records in month')?>'
                               },{
                                   label: '<?php echo __('processing')?>',
                                    data: data_processing,
                                    color: '#4DA74D',
                                    note: '<?php echo __('records are processing in month')?>'
                               },{
                                   label: '<?php echo __('return')?>',
                                    data: data_return,
                                    color: '#AFD8F8',
                                    note: '<?php echo __('return reocrd in month')?>'
                               }
                              ];
                        //tao bieu do stack cap xa
                        create_stack_chart(div_id,dataSet,ticks,div_note);                        
                       
                        //reset bien
                        data_receive    = [];
                        data_processing = [];
                        data_return     = [];
                        dataSet = [];
                        ticks = [];
                        i=1;
                        //gan dv moi
                        cur_unit_code = unit_code;
                    }
                    
                    //gan thong tin vao cac arr data (stack)
                    data_receive.push([data_json_village[j].C_COUNT_TONG_TIEP_NHAN_TRONG_THANG,i]);
                    data_processing.push([data_json_village[j].C_COUNT_DANG_THU_LY,i]);
                    data_return.push([data_json_village[j].C_COUNT_DA_TRA_KET_QUA,i]);
                    ticks.push([i, data_json_village[j].C_NAME]);                     
                    i++;
                }
                
                $('#myCarousel').find('.item').hide();
                $('#myCarousel').find('.item:eq(0)').show();
                
                interval = setInterval(function(){
                    show_slide('#myCarousel');   
                },8000);
            });
        </script>
    </body>
</html>
