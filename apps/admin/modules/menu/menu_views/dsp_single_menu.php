<?php if (!defined('SERVER_ROOT')) { exit('No direct script access allowed');} ?>
<?php
//display header
$this->_page_title = __('menu detail');

$v_menu_id           = isset($arr_single_menu['PK_MENU'])?$arr_single_menu['PK_MENU']:'';  
$v_menu_name         = isset($arr_single_menu['C_NAME'])?$arr_single_menu['C_NAME']:'';
$v_parent_id         = isset($arr_single_menu['FK_PARENT'])?$arr_single_menu['FK_PARENT']:'';  

$v_menu_value        = isset($arr_single_menu['C_VALUE'])?$arr_single_menu['C_VALUE']:'';
$v_menu_order        = isset($arr_single_menu['PK_MENU'])?$arr_single_menu['C_ORDER'] : 1;

$v_module_value      ='';
$v_url               ='';
$v_article_id        ='';
$v_category_id       ='';
$v_title             ='';
$v_category_name     ='';
$v_menu_type         ='';

if($v_menu_value!='')
{
    $dom = simplexml_load_string($v_menu_value);
    $x_path = "//MenuType/item[@data='1']";
    $r = $dom->xpath($x_path);
    
    $v_menu_type = isset($r[0]->attributes()->type)?$r[0]->attributes()->type:'';
    
   if($v_menu_type == 'article') 
    {
        $v_article_id = $r[0]->article_id;
        $v_article_slug = $r[0]->article_slug;
        $v_category_id = $r[0]->category_id;
        $v_category_slug = $r[0]->category_slug;
        $v_title = $r[0]->title;
    } 
    elseif($v_menu_type == 'url')
    {
        $v_url = $r[0];
    }
    elseif($v_menu_type == 'category')
    {
        $v_category_id   =  $r[0]->id;
        $v_category_slug = $r[0]->slug;
        $v_category_name = $r[0]->name;
    }
    elseif($v_menu_type == 'module')
    {
        $v_module = $r[0];
        $v_module_value = $r[0]->attributes()->value;
    }
}

$v_position_id      = isset($_POST['hdn_position_id'])?$_POST['hdn_position_id']:'';
?>

<form name="frmMain" id="frmMain" action="" method="POST" class="form-horizontal">
    <?php
    echo $this->hidden('controller',$this->get_controller_url());
    echo $this->hidden('hdn_item_id',$v_menu_id);
    echo $this->hidden('hdn_item_id_list','');

    echo $this->hidden('hdn_dsp_single_method','dsp_single_menu');
    echo $this->hidden('hdn_dsp_all_method','dsp_all_menu');
    echo $this->hidden('hdn_update_method','update_menu');
    echo $this->hidden('hdn_delete_method','delete_menu');
    echo $this->hidden('hdn_position_id',$v_position_id);
    echo $this->hidden('XmlData','');
    
    echo $this->hidden('hdn_menu_type','');
    echo $this->hidden('hdn_category_id','');
    echo $this->hidden('hdn_category_slug');
    echo $this->hidden('hdn_article_id','');
    echo $this->hidden('hdn_article_slug','');
    echo $this->hidden('hdn_current_order',$v_menu_order);
    echo $this->hidden('hdn_module_value','');
    //Luu dieu kien loc
    ?>
    <!-- Toolbar -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo __('menu detail'); ?></h1>
        </div>
           <!-- /.col-lg-12 -->
    </div> 
    <!-- /Toolbar -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo __('detail')?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('menu name');?></label>
                <div class="col-sm-10">
                    <input type="textbox" name="txt_menu_name" id="txt_menu_name" value="<?php echo $v_menu_name;?>" 
                        data-allownull="no" data-validate="text" 
                        data-name="<?php echo __('menu name')?>" 
                        data-xml="no" data-doc="no" 
                        autofocus="autofocus" class="form-control"
                        size="60"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('the menu'); ?></label>
                <div class="col-sm-10">
                    <select name="menu_select" id="menu_select" class="form-control">
                        <option value="0"> << <?php echo __('root menu') ?> >></option>
                        <?php foreach ($arr_all_menu as $item): ?>
                            <?php
                            $level = strlen($item['C_INTERNAL_ORDER']) / 3 - 1;
                            $level_text = '';
                            for ($i = 0; $i < $level; $i++) {
                                $level_text .= ' -- ';
                            }
                            ?>
                            <option value="<?php echo $item['PK_MENU']; ?>" <?php echo ($v_parent_id==$item['PK_MENU'])?'Selected':'';?>>
                                <?php echo $level_text . $item['C_NAME'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('order');?></label>
                <div class="col-sm-10">
                    <input type="textbox" name="txt_menu_order" id="txt_menu_order" value="<?php echo $v_menu_order;?>" 
                        data-allownull="no" data-validate="number" 
                        data-name="<?php echo __('order')?>" 
                        data-xml="no" data-doc="no" 
                        autofocus="autofocus" class="form-control"
                        size="10"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('kind of'); ?></label>
                <div class="col-sm-10">
                    <label class="radio-inline">
                        <input type="radio" value="Url ngoài" data-type="url" name="rad_type" id="rad_url" disabled><?php echo __('url')?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="Chuyên mục" data-type="category" name="rad_type" id="rad_category" disabled><?php echo __('category')?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="Tin bài" data-type="article" name="rad_type" id="rad_article" disabled><?php echo __('article')?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" value="Module" data-type="module" name="rad_type" id="rad_module" disabled><?php echo __('module')?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <div class="col-sm-8">
                        <input type="textbox" name="txt_menu_type_detail" id="txt_menu_type_detail" 
                           value="<?php 
                             if($v_menu_type == 'article')
                             {
                                 echo $v_title;
                             }
                             elseif($v_menu_type == 'category')
                             {
                                 echo $v_category_name;
                             }
                             elseif($v_menu_type == 'url')
                             {
                                 echo $v_url;
                             }
                             elseif($v_menu_type == 'module')
                             {
                                 echo $v_module;
                             }
                            ;?>"  
                            data-allownull="no" data-validate="text" 
                            data-name="<?php echo __('kind of')?>" 
                            data-xml="no" data-doc="no" 
                            autofocus="autofocus" class="form-control"
                            size="60" disabled/>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-default" type="button" name="btn_menu_service" id="btn_menu_service" onclick="btn_menu_service_onclick();" value="">
                            <i class="fa fa-th"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <br>
        <label class="required" id="message_err"></label>
        <div class="button-area">
            <button type="button" name="btn_update" id="btn_update"class="btn btn-outline btn-success" style="margin-right:10px;" onclick="btn_accept_onclick();">
                        <i class="fa fa-check"></i> <?php echo __('update'); ?>
                    </button>
                    <button type="button" name="btn_back" id="btn_cancel" class="btn btn-outline btn-warning" onclick="btn_back_onclick();">
                        <i class="fa fa-reply"></i> <?php echo __('goback'); ?>
                    </button>
        </div>
</form>
<script>
    $(document).ready(function (){
        <?php if($v_menu_type=='article'):?>
        $('#hdn_menu_type').val('article');
        $('#hdn_category_id').val('<?php echo $v_category_id;?>');
        $('#hdn_category_slug').val('<?php echo $v_category_slug;?>');
        $('#hdn_article_id').val('<?php echo $v_article_id;?>');
        $('#hdn_article_slug').val('<?php echo $v_article_slug;?>');
        
        $('#rad_article').removeAttr('disabled');
        $('#rad_article').attr('CHECKED',1);
        <?php elseif($v_menu_type=='category'):?>
        $('#hdn_menu_type').val('category');
        $('#hdn_category_id').val('<?php echo $v_category_id?>');
        $('#hdn_category_slug').val('<?php echo $v_category_slug?>');
            
        $('#rad_category').removeAttr('disabled');
        $('#rad_category').attr('CHECKED',1);
        <?php elseif($v_menu_type=='url'):?>
        $('#hdn_menu_type').val('url');            

        $('#rad_url').removeAttr('disabled');
        $('#rad_url').attr('CHECKED',1);
        <?php elseif($v_menu_type=='module'):?>
        $('#hdn_menu_type').val('module');            
        $('#hdn_module_value').val('<?php echo $v_module_value?>');            

        $('#rad_module').removeAttr('disabled');
        $('#rad_module').attr('CHECKED',1);
        <?php endif;?>
    });
function btn_menu_service_onclick()
{
   var type=$('input[name="rad_type"]:checked').attr('data-type');
   var url="<?php echo $this->get_controller_url()."dsp_menu_service/&pop_win=1";?>&type="+type;
   showPopWin(url,800,500,do_attach);
}
function do_attach(returnVal)
{
    console.log(returnVal);
    var service_type = returnVal[0].service_type;
    //alert(returnVal[0].category_id);
    if(service_type=='url')
    {
        $('#rad_category').attr('disabled',1);
        $('#rad_article').attr('disabled',1);
        $('#rad_module').attr('disabled',1);
        
        $('#rad_url').removeAttr('disabled');
        $('#rad_url').attr('CHECKED',1);
        
        $('#hdn_menu_type').val(service_type);
        
        $('#txt_menu_type_detail').val(returnVal[0].url);
        //alert($('#hdn_menu_type').val());
    }
    else if(service_type=='category')
    {
        $('#rad_url').attr('disabled',1);
        $('#rad_article').attr('disabled',1);
        $('#rad_module').attr('disabled',1);
        
        $('#rad_category').removeAttr('disabled');
        $('#rad_category').attr('CHECKED',1);
        
        $('#hdn_menu_type').val(service_type);
        $('#hdn_category_id').val(returnVal[0].category_id);
        $('#hdn_category_slug').val(returnVal[0].category_slug);
        
        $('#txt_menu_name').val(returnVal[0].category_name);
        $('#txt_menu_type_detail').val(returnVal[0].category_name);
    }
    else if(service_type == 'module')
    {
        $('#rad_category').attr('disabled',1);
        $('#rad_url').attr('disabled',1);
        $('#rad_article').attr('disabled',1);
        
        $('#rad_module').removeAttr('disabled');
        $('#rad_module').attr('CHECKED',1);hdn_module_value
        
        $('#hdn_menu_type').val(service_type);
        $('#hdn_module_value').val(returnVal[0].module_value);
        
        $('#txt_menu_name').val(returnVal[0].module_name);
        $('#txt_menu_type_detail').val(returnVal[0].module_name);
    }
    else 
    {
        $('#rad_category').attr('disabled',1);
        $('#rad_url').attr('disabled',1);
        $('#rad_module').attr('disabled',1);
        
        $('#rad_article').removeAttr('disabled');
        $('#rad_article').attr('CHECKED',1);
        
        $('#hdn_menu_type').val('article');
        $('#hdn_category_id').val(returnVal[0].article_category_id);
        $('#hdn_category_slug').val(returnVal[0].article_category_slug);
        $('#hdn_article_id').val(returnVal[0].article_id);
        $('#hdn_article_slug').val(returnVal[0].article_slug);
        
        $('#txt_menu_name').val(returnVal[0].article_title);
        $('#txt_menu_type_detail').val(returnVal[0].article_title);
       // alert($('#hdn_menu_type').val());
    }
}
function btn_accept_onclick()
{
    $('#txt_menu_type_detail').removeAttr('disabled');
    btn_update_onclick();
}
</script>