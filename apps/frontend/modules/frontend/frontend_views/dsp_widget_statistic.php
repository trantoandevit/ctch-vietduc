<?php
defined('DS') or die();
?>
<div class="panel panel-default">
    <div class="news-title">
        <span style="line-height:17px;"><img src="<?php echo SITE_ROOT . "public/images/counter_icon.png" ?>" />
            <label><?php echo __('statistic') ?></label>
        </div>
    <div class="panel-body">
        <table style="border:none;border-spacing: 0px;">
            <colgroup>
                <col width="50%">
                <col width="60%">
            </colgroup>
            <tr>
                <td><?php echo __('viewing') ?>:</td>
                <td>
                    <h4 class="blue" style="margin:0;">&nbsp;<script>var ref = (''+document.referrer+'');document.write('<script src="http://freehostedscripts.net/ocounter.php?site=ID2833473&&r=' + ref + '"><\/script>');</script><?php //echo $stats_online; ?></h4>
                </td>
            </tr>
            <tr>
                <td><?php echo __('web counter') ?>:</td>
                <td><h4 class="blue" style="margin:0;">&nbsp;<?php echo $stats_all; ?></h4></td>
            </tr>
        </table>
    </div>
</div>