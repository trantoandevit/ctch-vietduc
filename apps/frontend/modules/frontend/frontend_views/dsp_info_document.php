<div class="docModalContent">
    <h2 class="title_modal"><?php echo $title ?></h2>
    <table class="table" id="table_Modal"> 
        <tbody>
            <tr style="border-bottom: 1px dotted #d2d2d2"> 
                <td style="width: 35%;" class="link">Số hiệu văn bản</td> 
                <td style="width: 65%;"><?php echo $arrData['C_SO_HIEU_VAN_BAN'] ?></td> 
            </tr> 
            <tr style="border-bottom: 1px dotted #d2d2d2"> 
                <td style="width: 35%;" class="link">Cơ quan ban hành</td> 
                <td style="width: 65%;"><?php echo $arrData['C_CQBH'] ?></td> 
            </tr> 
            <tr style="border-bottom: 1px dotted #d2d2d2"> 
                <td style="width: 35%;" class="link">Lĩnh vực thống kê</td> 
                <td style="width: 65%;"><?php echo $arrData['C_LVTK'] ?></td> 
            </tr> 
            <tr style="border-bottom: 1px dotted #d2d2d2"> 
                <td style="width: 35%;" class="link">Loại văn bản</td> 
                <td style="width: 65%;"><?php echo $arrData['C_LOAI_VAN_BAN'] ?></td> 
            </tr> 
            <tr style="border-bottom: 1px dotted #d2d2d2"> 
                <td style="width: 35%;" class="link">Ngày văn bản</td> 
                <td style="width: 65%;"><?php echo date_create($arrData['C_NGAY_BAN_HANH'])->format('d/m/Y') ?></td> 
            </tr> 
            <tr style="border-bottom: 1px dotted #d2d2d2"> 
                <td style="width: 35%;" class="link">Ngày có hiệu lực</td> 
                <td style="width: 65%;"><?php echo date_create($arrData['C_NGAY_HIEU_LUC'])->format('d/m/Y') ?></td> 
            </tr> 
            <tr style="border-bottom: 1px dotted #d2d2d2"> 
                <td style="width: 35%;" class="link">Văn bản đính kèm</td> 
                <td style="width: 65%;">
                   <?php
                    $arr_all_attachment = is_array($arr_all_attachment) ? $arr_all_attachment : array();
                    for($i = 0; $i <count($arr_all_attachment); $i ++)
                    {
                        $path_file = SITE_ROOT . 'upload'  . DS .  $arr_all_attachment[$i]['C_FILE_NAME'];
                        
                        $file_name = $arr_all_attachment[$i]['C_FILE_NAME'];
                        
                        echo "<a style='text-decoration:none' title='$file_name'  target='_blank' class='attacment' href='$path_file'>
                                    <img width='20px' height='20px' src='". CONST_SITE_THEME_ROOT ."images/attachment.png' />
                                    $file_name
                            </a><br />";
                    }   
                   ?> 
                    
                    
                </td> 
            </tr> 
        </tbody>
    </table>
    <?php if ($isCheck && (!empty($arrDocCQBH) || !empty($arrDocLVTK) )): ?>
        <h4 class="vbpq-search-result-title"><label class="control-label">Các văn bản liên quan</label></h4>
        <div class="panel-body no-padding">
            <ul class="news">
                <?php foreach ($arrDocCQBH as $key => $DocCQBH): ?>
                    <?php
                    $v_summary = remove_html_tag(htmlspecialchars_decode($DocCQBH['C_TITLE']));
                    $v_summary = get_leftmost_words(remove_html_tag($v_summary), 15);
                    ?>
                    <li><a href="javascript:void(0);" title="<?php echo $DocCQBH['C_TITLE'] ?>" data-pk="<?php echo $DocCQBH['PK_VAN_BAN'] ?>"><?php echo $v_summary; ?></a> <span class="time_news"><?php echo (!empty($DocCQBH['C_NGAY_BAN_HANH'])) ? "(" . date_create($DocCQBH['C_NGAY_BAN_HANH'])->format('d/m/Y') . ")" : ''; ?></span></li>
                <?php endforeach; ?>

                <?php foreach ($arrDocLVTK as $key => $DocLVTK): ?>
                    <?php
                    $v_summary2 = remove_html_tag(htmlspecialchars_decode($DocLVTK['C_TITLE']));
                    $v_summary2 = get_leftmost_words(remove_html_tag($v_summary2), 15);
                    ?>
                    <li><a href="javascript:void(0);"  title="<?php echo $DocLVTK['C_TITLE'] ?>" data-pk="<?php echo $DocLVTK['PK_VAN_BAN'] ?>"><?php echo $v_summary2; ?></a> <span class="time_news"><?php echo (!empty($DocLVTK['C_NGAY_BAN_HANH'])) ? "(" . date_create($DocLVTK['C_NGAY_BAN_HANH'])->format('d/m/Y') . ")" : ''; ?></span></li>
                <?php endforeach; ?>

            </ul>
        </div>
    <?php endif; ?>
</div>