<?php
defined('DS') or die('no direct access');
?>

<div class="panel panel-default">
    <div class="news-title">
        <span style="line-height:17px;"><img src="<?php echo SITE_ROOT . "public/images/slider/icon.png" ?>" /></span><label><?php echo $v_widget_name ?></label>
    </div>
    <div class="panel-body">
        <?php if (!empty($arr_single_poll)): ?>
            <?php
            $v_poll_name = $arr_single_poll['C_NAME'];
            $ck_begin    = $arr_single_poll['CK_BEGIN_DATE'];
            $ck_end      = $arr_single_poll['CK_END_DATE'];
            $v_disable   = Cookie::get('WIDGET_POLL_' . $v_poll_id) ? 'disabled' : ''; 
        ?>

            <p class='widget-content-title'><?php echo $v_poll_name ?></p>

            <form>
                <input type='hidden' id="hdn_poll_id" name='hdn_poll_id' value='<?php echo $v_poll_id ?>'/>
                <input type='hidden' name='hdn_answer_id' value=''/>
                <?php $n = count($arr_all_opt); ?>
                <?php
                for ($i = 0; $i < $n; $i++):
                    ?>
                    <?php
                    $item = $arr_all_opt[$i];
                    $v_opt_val = $item['PK_POLL_DETAIL'];
                    $v_opt_answer = $item['C_ANSWER'];
                    ?>
                    <label>
                        <input type="radio" name='rad_widget_poll_<?php echo $v_index ?>' value='<?php echo $v_opt_val ?>' onclick="this.form.hdn_answer_id.value=this.value"/>
                        <?php echo $v_opt_answer ?></br>
                    </label>
                <br/>
                <?php endfor; ?>
                <br/>
                <?php if ($ck_begin < 0 or $ck_end < 0): ?>
                    <?php echo __('this poll is expired'); ?>
                <?php else: ?>
                    <a class="vote" href="javascript:void(0)" onclick="btn_vote_onclick(this);" >
                        <span>
                            <?php echo $v_disable ? __('thank you for voting') : __('vote') ?>
                        </span>
                    </a>
                <?php endif; ?>
                &nbsp;&nbsp;
                <a class="a_poll_result" href='javascript:void(0)'  onclick="dsp_poll_result(this)">
                    <?php echo __('see result') ?>
                </a>
            </form>
        <?php endif; ?>
    </div>
</div>
<!-- Trigger the modal with a button -->
<button style="display: none" type="button" id='myModal_poll_results_btn' data-toggle="modal" data-target="#myModal_poll_results">Open Modal</button>

<!-- Modal -->
<div id="myModal_poll_results" class="modal fade" role="dialog">
  <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"></h4>
          </div>
            <div class="modal-body" style="height: 235px">
              <iframe src="" style="width:100%;height:100%;border:none;"></iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Đóng')?></button>
          </div>
        </div>
  </div>
</div>
<?php if (!defined('WIDGET_POLL')): ?>
    <?php define('WIDGET_POLL', 1); ?>
    <div id="widget_poll_modal" title="" name="widget_poll_modal" style="display: none;overflow: hidden; margin: 0 auto"></div>

    <script>
        $(document).ready(function(){
            jQuery.browser = {};
                 (function () {
                     jQuery.browser.msie = false;
                     jQuery.browser.version = 0;
                     if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                         jQuery.browser.msie = true;
                         jQuery.browser.version = RegExp.$1;
                     }
                 })();
        })
        function dsp_poll_result($a_obj)
        {
            var v_id = $($a_obj).parents('form:first').find('#hdn_poll_id').val();
            var url = "<?php echo $this->get_controller_url() ?>" + 'dsp_poll_result/' + v_id;
            $('#myModal_poll_results iframe').attr('src',url);
            $('#myModal_poll_results .modal-title').text('<?php echo __('poll result') ?>')
            $('#myModal_poll_results_btn').trigger('click');
            console.log( $('#myModal_poll_results_btn'));
        }
        function btn_vote_onclick($btn_obj){
            var cookie = document.cookie;
            var aid = $($btn_obj).parents('form:first').find('[name=hdn_answer_id]').val();   
            var pid = $($btn_obj).parents('form:first').find('[name=hdn_poll_id]').val();  
            if(!aid || !pid){
              alert('<?php echo __('please choose answer')?>!')
                return;
            }
            if(cookie.match('WIDGET_POLL_'+pid) != null)
            {
                dsp_poll_result($btn_obj);
                return;
            }
            
            var url= "<?php echo $this->get_controller_url() ?>" + 'handle_widget/';
            url += '&code=poll';
            url += '&pid=' + pid;
            url += '&aid=' + aid;
            $('#myModal_poll_results iframe').attr('src',url);
            $('#myModal_poll_results .modal-title').text('Bình chọn');
            $('#myModal_poll_results_btn').trigger('click');
        }
                                
    </script>
<?php endif; ?>