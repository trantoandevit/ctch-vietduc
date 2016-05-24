
<?php
defined('DS') or die('no direct access');

$this->_page_title        = __('article');
?>
<script src="<?php echo SITE_ROOT; ?>public/tinymce/script/tiny_mce.js"></script>
<!--jwplayer-->
<script type="text/javascript" src="<?php echo SITE_ROOT ?>public/jwplayer/jwplayer.js" ></script>
<script type="text/javascript">jwplayer.key="Qa3rOiiEqCKn+SICIA6EkRGZKHyS0etl1/ioTQ==";</script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo __('article') ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form name="frm_filter" id="frm_filter" action="" method="post">
   <?php
//        foreach ($_POST as $key => $val)
//        {
//            echo $this->hidden($key, $val);
//        }
   ?>
   <input type="hidden" name="controller" id="controller" value="<?php echo $this->get_controller_url()?>">
   <input type="hidden" name="hdn_item_id" id="hdn_item_id" value="0">
   <input type="hidden" name="hdn_dsp_single_method" id="hdn_dsp_single_method" value="dsp_single_article">
   <input type="hidden" name="hdn_dsp_all_method" id="hdn_dsp_all_method" value="dsp_all_article">
   <input type="hidden" name="hdn_update_method" id="hdn_update_method" value="update_article">
   <input type="hidden" name="hdn_delete_method" id="hdn_delete_method"
</form>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="category_tab">
                    <li class="active">
                        <a href="#category_content" data-toggle="tab"><?php echo __('general info') ?></a>
                    </li>
                    <?php if ($article_id): ?>
                        <li>
                            <a href="#category_content" data-toggle="tab"><?php echo __('preview') ?></a>
                        </li>
                        <li>
                            <a href="#category_content" data-toggle="tab"><?php echo __('edit article'); ?></a>
                        </li>
                        <li>
                            <a href="#category_content" data-toggle="tab"><?php echo __('version'); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="margin-top: 20px;">
                    <div class="tab-pane fade in active" id="category_content">
                        
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
<div id="msg-box" style="">

</div>


<script>
    var tab_index_url = {0:'<?php echo $this->get_controller_url() . 'dsp_general_info/' . $article_id; ?>',
                            1:'<?php echo $this->get_controller_url() . 'dsp_preview/' . $article_id; ?>',
                                2:'<?php echo $this->get_controller_url() . 'dsp_edit_article/' . $article_id; ?>',
                                    3:'<?php echo $this->get_controller_url() . 'dsp_all_version/' . $article_id ?>'};
        $(document).ready(function(){
            get_arp_by_tab_index(0);
        });
        
        $('#category_tab a').click(function (e) {
            e.preventDefault();
            var tab_index = $($(this).parent('li')).index();
            get_arp_by_tab_index(tab_index);
        });
        
        function get_arp_by_tab_index(tab)
        {
            var url = tab_index_url[tab];
            $.ajax({
                type: 'post',
                url: url,
                beforeSend: function () {
                    var img = '<center><img src="<?php echo SITE_ROOT; ?>public/images/loading.gif"/></center>';
                    $('#category_content').html(img);
                },
                success: function (result)
                {
                    
                    $('#category_content').html(result);
                }
            });
        }
        function reload_current_tab()
        {
            var tab_index = $('#category_tab li.active').index();
            get_arp_by_tab_index(tab_index);
        }
        
    SITE_ROOT = "<?php echo SITE_ROOT ?>";
    $(document).ready(function(){
        reset_div_msg();

        $('.TopMenuAdmin *').attr('onclick','');
        $('.TopMenuAdmin *').addClass('disabled');
    });
    
    function reset_div_msg(){
        $html = '<p>';
        $html += '<img height="16" width="16" src="' + '<?php echo SITE_ROOT ?>public/images/loading.gif' + '"/>';
        $html += '<?php echo __('dang_xu_ly') ?>';
        $html += '</p>';
        $('#msg-box').html($html);
        $('#msg-box').removeAttr('class');
    }

    function add_btnOK_to_div_msg()
    {
        $html = '</br><input type="button" onClick="div_msg_hide();" value="OK" style="width:30px;"/>';
        $('#msg-box').append($html);
    }
    
    function div_msg_hide()
    {
        $('#msg-box').fadeOut('fast', reset_div_msg);
    }
    window.btn_back_onclick = function()
    {
        $('#frm_filter').attr('action', "<?php echo $this->get_controller_url(); ?>")
        $('#frm_filter').submit();
    }

</script>


