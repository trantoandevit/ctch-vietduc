<?php
defined('DS') or die('no direct access');

$v_date                = new DateTime(strval($dom_single_version->date));
$v_date                = $v_date->format('d/m/Y H:i');
$this->_page_title = $v_date;
?>
<div class="article-view" style="height: 500px;overflow-y: scroll;">
    <h3><?php echo strval($dom_single_version->title); ?></h3>
    <div class="summary-container"><?php echo $dom_single_version->summary ?></div>
    <?php echo $dom_single_version->content ?>
</div>
<div class="button-area">
    <button type="button" class="btn btn-outline btn-success" style="margin-right: 10px;" onclick="buttonAccept_onClick();">
        <i class="fa fa-check"></i> <?php echo __('restore') ?>
    </button>
    <button type="button" class="btn btn-outline btn-warning" onclick="javascript:window.parent.hidePopWin(false);">
        <i class="fa fa-reply" ></i> <?php echo __('goback') ?>
    </button>
</div>


<script>
    function buttonAccept_onClick()
    {
        if(confirm("<?php echo __('restore') . '?' ?>"))
        {
            var $url = "<?php echo $this->get_controller_url() . 'restore_version/' ?>";       
            $.ajax({
                type: 'post',
                url: $url,
                data: {
                    article_id: <?php echo $article_id ?>
                    ,version_id: <?php echo $version_id ?>
                },
                success: function(json){
                    window.parent.location.reload();
                }
            }); 
        }
    }

</script>
<?php $this->template->display('dsp_footer_pop_win.php'); ?>