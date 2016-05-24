<?php
defined('DS') or die('no direct access');
$this->_page_title =  __('photo gallery');
?>
<style>
    .ui-tabs-panel{
        overflow: hidden;
    }
</style>
<script src="<?php echo SITE_ROOT; ?>public/tinymce/script/tiny_mce.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="font-size: 32px;"><?php echo __('photo gallery'); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="photo_gallery_tab">
                    <li class="active">
                        <a data-toggle="tab" href="#photo_gallery_content" id="dsp_general_info">
                               <?php echo __('general info') ?>
                        </a>
                    </li>
                    <?php if ($v_id): ?>
                        <li>
                            <a data-toggle="tab" href="#photo_gallery_content">
                                <?php echo __('image list') ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#photo_gallery_content">
                                <?php echo __('edit article'); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="photo_gallery_content">
                        
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
<form name="frm_filter" id="frm_filter" action="" method="post">
    <?php
    foreach ($_POST as $key => $val)
    {
        echo $this->hidden($key, strval($val));
    }
    ?>
</form>

<script>
    var tab_index_url = {   0:'<?php echo $this->get_controller_url() . 'dsp_general_info/' . $v_id; ?>',
                            1:'<?php echo $this->get_controller_url() . 'dsp_img_list/' . $v_id; ?>'
                            ,2:'<?php echo $this->get_controller_url() . 'dsp_edit_gallery/' . $v_id; ?>'
                        };
    
    $(document).ready(function(){
       get_arp_by_tab_index(0);
    });
    
    $('#photo_gallery_tab a').click(function (e) {
            e.preventDefault();
            var tab_index = $($(this).parent('li')).index();
            get_arp_by_tab_index(tab_index);
            tinyMCE.execCommand('mceRemoveControl', false, 'txt_summary');
            tinyMCE.init();
            
        });
        
        function get_arp_by_tab_index(tab)
        {
            var url = tab_index_url[tab];
            $.ajax({
                type: 'post',
                url: url,
                beforeSend: function () {
                    var img = '<center><img src="<?php echo SITE_ROOT; ?>public/images/loading.gif"/></center>';
                    $('#photo_gallery_content').html(img);
                },
                success: function (result)
                {
                    $('#photo_gallery_content').html(result);
                }
            });
        }
        function reload_current_tab()
        {
            var tab_index = $('#photo_gallery_tab li.active').index();
            get_arp_by_tab_index(tab_index);
        }
    
    window.btn_back_onclick = function(){
        $url = "<?php echo $this->get_controller_url() ?>";
        $('#frm_filter').attr('action', $url);
        $('#frm_filter').submit();
    }
    
</script>