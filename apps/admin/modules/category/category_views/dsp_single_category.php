<?php
defined('SERVER_ROOT') or die('No direct access');
$v_id       = isset($arr_single_category['PK_CATEGORY']) ? $arr_single_category['PK_CATEGORY'] : 0;
$v_name     = isset($arr_single_category['C_NAME']) ? $arr_single_category['C_NAME'] : '';
$v_parent   = isset($arr_single_category['FK_PARENT']) ? $arr_single_category['FK_PARENT'] : '';
$v_slug     = isset($arr_single_category['C_SLUG']) ? $arr_single_category['C_SLUG'] : '';
$v_status   = isset($arr_single_category['C_STATUS']) ? $arr_single_category['C_STATUS'] : 0;
$v_order    = isset($arr_single_category['C_ORDER']) ? $arr_single_category['C_ORDER'] : 1;
$v_is_video = isset($arr_single_category['C_IS_VIDEO']) ? $arr_single_category['C_IS_VIDEO'] : '';
$v_is_radio = isset($arr_single_category['C_IS_RADIO']) ? $arr_single_category['C_IS_RADIO'] : '';
//$v_news_photos = isset($arr_single_category['C_NEWS_PHOTOS']) ? $arr_single_category['C_NEWS_PHOTOS'] : '';
$txt_link_adv = isset($arr_single_category['C_LINK_ADV']) ? $arr_single_category['C_LINK_ADV'] : '';
$v_file_name = isset($arr_single_category['C_FILE_NAME']) ? $arr_single_category['C_FILE_NAME'] : '';
$arr_category_type = isset($arr_single_category['C_TYPE']) ?$arr_single_category['C_TYPE'] : '';

if (intval($v_is_video))
{
    $v_is_video = 'checked';
}
else
{
    $v_is_video = '';
}

if (intval($v_is_radio))
{
    $v_is_radio = 'checked';
}
else
{
    $v_is_radio = '';
}
//if(intval($v_news_photos))
//{
//    $v_news_photos = 'checked';
//}
//else
//{
//    $v_news_photos ='';
//}
$this->_page_title = __('category');
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo __('category'); ?></h1>
    </div>
       <!-- /.col-lg-12 -->
</div> 
<form class="form-horizontal" name="frmMain" id="frmMain" method="post" action="<?php echo $this->get_controller_url() . 'update_insert_category'; ?>">
    <?php
    echo $this->hidden('hdn_dsp_single_method', 'dsp_single_category');
    echo $this->hidden('controller', $this->get_controller_url());
    echo $this->hidden('hdn_dsp_all_method', 'dsp_all_category');
    echo $this->hidden('hdn_update_method', 'update_category');
    echo $this->hidden('hdn_delete_method', 'delete_category');
    echo $this->hidden('hdn_item_id', $v_id);
    echo $this->hidden('XmlData', '');
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo __('detail')?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('category name'); ?> <label class="required">(*)</label></label>
                <div class="col-sm-9">
                    <input type="text" name="txt_name" id="txt_name" value="<?php echo $v_name; ?>" 
                       onKeyUp="auto_slug(this, '#txt_slug');"
                       class="form-control" maxlength="255"
                       data-allownull="no" data-validate="text" data-name="<?php echo __('name'); ?>" 
                       data-xml="no" data-doc="no" placeholder="<?php echo __('category name'); ?>"
                       />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('slug'); ?> <label class="required">(*)</label></label>
                <div class="col-sm-9">
                    <input type="text" name="txt_slug" id="txt_slug" value="<?php echo $v_slug; ?>" 
                               class="form-control" maxlength="255"
                               data-allownull="no" data-validate="text" data-name="<?php echo __('slug'); ?>" 
                               data-xml="no" data-doc="no" placeholder="<?php echo __('slug'); ?>"
                               />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('parent category'); ?> <label class="required">(*)</label></label>
                <div class="col-sm-9">
                    <select 
                        name="sel_category" id="sel_category" class="form-control"
                        data-validate="number" data-name="<?php echo __('parent category'); ?>"
                        >
                        <option value="0"> --- <?php echo __('root category') ?> ---</option>
                        <?php foreach ($arr_all_category as $item): ?>
                            <?php
                            $indent     = strlen($item['C_INTERNAL_ORDER']) / 3 - 1;
                            $index_text = '';
                            for ($i = 0; $i < $indent; $i++)
                            {
                                $index_text .= ' -- ';
                            }
                            ?>
                            <option value="<?php echo $item['PK_CATEGORY']; ?>">
                                <?php echo $index_text . $item['C_NAME'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <script>$('select[name="sel_category"] option[value=<?php echo $v_parent ?>]').attr('selected',1);</script>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('order') ?> <label class="required">(*)</label></label>
                <div class="col-sm-9">
                    <input type="text" name="txt_order" id="txt_order" value="<?php echo $v_order; ?>" 
                               class="form-control" maxlength="255"
                               data-allownull="yes" data-validate="unsignNumber"  data-name="<?php echo __('order'); ?>" 
                               data-xml="no" data-doc="no" 
                               />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                    <label>
                        <input type="checkbox" name="sel_status" id="sel_status" <?php echo ($v_status == 1)?'checked':'';?> />
                        <?php echo __('active status')?>
                    </label>
                </div>
            </div>
<!--             <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                    
                    <label>
                        <input type="checkbox" name="chk_is_video" id="chk_is_video" value="1" <?php echo $v_is_video; ?>/>
                        <?php echo __('is video category'); ?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                    <label> 
                        <input type="checkbox" name="chk_is_radio" id="chk_is_radio" value="1" <?php echo $v_is_radio; ?>/>
                        <?php echo __('Chuyên mục radio'); ?>
                    </label>
                </div>
            </div>-->
            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                    <label> 
                        <input type="radio" name="rd_type" id="rd_type" value="news" 
                               <?php echo (('news'==$arr_category_type ) or $arr_category_type == '') ? 'checked' : ''; ?> />
                        <?php echo __('Chuyên mục tin tức'); ?>
                    </label>
                    <br />
                    <label> 
                        <input type="radio" name="rd_type" id="rd_type" value="video" 
                               <?php echo ('video' == $arr_category_type) ? 'checked' : ''; ?> />
                        <?php echo __('Chuyên mục video'); ?>
                    </label>
                    <br/>
                    <label> 
                        <input type="radio" name="rd_type" id="rd_type" value="radio" 
                               <?php echo ('radio' == $arr_category_type) ? 'checked' : ''; ?> />
                        <?php echo __('Chuyên mục radio'); ?>
                    </label>
                    <br/>
                    <label> 
                        <input type="radio" 
                               name="rd_type" 
                               class="chk_type"
                               value="to_chuc_bo_may" 
                                <?php echo ('to_chuc_bo_may' == $arr_category_type) ? 'checked' : ''; ?> />
                        <?php echo __('Chuyên mục tổ chức bộ máy'); ?>
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('link_anh_quang_cao'); ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="255" id="txt_link_adv" name="txt_link_adv" value="<?php echo $txt_link_adv; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo __('anh_quang_cao') ?></label>
                <div class="col-sm-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a style="float:right;text-decoration: none;color:white;" href="javascript:;" onClick="btn_add_attachment_onclick();">
                                <?php echo __('add new') ?>
                            </a>
                            <font><?php echo __('attachment') ?> </font>
                        </div>
                        <div class="panel-body" id="category-content">
                            <div class="ui-widget-content Center" id="attachment_container" style="height:120px;overflow-x: hidden;overflow-y: scroll;">
                            <?php if ($v_file_name): ?>
                                <p style="margin:3px;width:100%;float:left;text-align: left">
                                    <img height="12" width="12" onClick="delete_attachment(this);"
                                         src="<?php echo SITE_ROOT; ?>public/images/icon_bannermenu_exit.gif"
                                         />
                                    <input type="hidden" name="hdn_attachment[]" value="<?php echo $v_file_name ?>"/>
                                    &nbsp;<?php echo basename($v_file_name) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-9">
                    <button type="button" class="btn btn-outline btn-success" style="margin-right:10px;" onClick="btn_update_onclick();">
                        <i class="fa fa-check"></i> <?php echo __('update'); ?>
                    </button>
                    <button type="button" class="btn btn-outline btn-warning" onClick="window.location = '<?php echo $this->get_controller_url(); ?>';">
                        <i class="fa fa-reply"></i> <?php echo __('goback'); ?>
                    </button>
                </div>
            </div> 
            
        </div>
    </div>
</form>
<script>

function btn_add_attachment_onclick()
{
    if($('#attachment_container p').length > 0 )
    {
        return;
    }
    
    var $url = "<?php echo $this->get_controller_url('advmedia', 'admin') . 'dsp_service/'; ?>";

    showPopWin($url, 800, 600, function(json_obj){
        $.each(json_obj, function(k, v){
            $file = v['path'];
            $name = v['name'];
            $html = '<p style="margin:3px;width:100%;float:left;text-align:left;">'
                + '<img height="12" width="12" src="<?php echo SITE_ROOT; ?>public/images/icon_bannermenu_exit.gif"'
                + 'onClick="delete_attachment(this);"/>'
                + '<input type="hidden" name="hdn_attachment[]" value="'+ $file +'"/>'
                + '&nbsp;' + $name
                + '</p>';

            $('#attachment_container').append($html);
        });
    });
}
    
    function delete_attachment(img_obj)
    {
        $(img_obj).parent().remove();
    }
</script>