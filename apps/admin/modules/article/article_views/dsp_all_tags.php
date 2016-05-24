<?php
defined('DS') or die();
$all_characters        = explode(' ', 'a ă â b c d đ e ê g h i j k l m n o ô ơ p q r s t u ư v x y z');
$v_character           = get_request_var('character');
$this->_page_title = __('tags');
$cur_url               = $this->get_controller_url() . 'dsp_all_tags';
?>
<?php $n                     = count($all_characters); ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo __('tags') ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<h5 style="text-transform: uppercase;">
    <a href="<?php echo $cur_url ?>">[<?php echo __('all') ?>]</a>
    <?php for ($i = 0; $i < $n; $i++): ?>
        <?php
        $item = $all_characters[$i];
        ?>
        <a href="<?php echo $cur_url ?>&character=<?php echo $item ?>"><?php echo $item ?></a>
    <?php endfor; ?>
</h5>
<div style="overflow-y: auto;height: 500px;width:100%">
    <div class="button-area">
        <button type="button" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="add_tags();">
            <i class="fa fa-check"></i> <?php echo __('submit') ?>
        </button>
        <button type="button" class="btn btn-outline btn-danger" onclick="window.parent.hidePopWin(false);">
            <i class="fa fa-times"></i> <?php echo __('close') ?>
        </button>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="main">
                <colgroup>
                    <col width="10%"/>
                    <col width="90%"/>
                </colgroup>
                <tr>
                    <th><input type="checkbox" id="chk_all"></input></th>
                    <th><?php echo __('name') ?></th>
                </tr>
                <?php $i    = 0; ?>
                <?php foreach ($arr_all_tags as $key => $val): ?>
                    <?php if ($v_character == '' or preg_match("/^$v_character/i", $val)): ?>
                        <?php $i++; ?>
                        <tr>
                            <td class="Center">
                                <input 
                                    type="checkbox" value="<?php echo $val ?>" 
                                    class="chk_item" id="chk_item_<?php echo $key ?>"
                                    />
                            </td>
                            <td><label for="chk_item_<?php echo $key ?>"><?php echo $val ?></label></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php for ($i; $i < _CONST_DEFAULT_ROWS_PER_PAGE; $i++): ?>
                    <tr>
                        <td></td><td></td>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
    <div class="button-area">
        <button type="button" style="margin-right: 10px;" class="btn btn-outline btn-success" onclick="add_tags();">
            <i class="fa fa-check"></i> <?php echo __('submit') ?>
        </button>
        <button type="button" class="btn btn-outline btn-danger" onclick="window.parent.hidePopWin(false);">
            <i class="fa fa-times"></i> <?php echo __('close') ?>
        </button>
    </div>
</div>
<script>
    $(document).ready(function(){
        toggle_checkbox('#chk_all', '.chk_item');
    });
    function add_tags(){
        arr = [];
        $('.chk_item:checked').each(function(){
            arr.push($(this).val());
        });
        returnVal = arr;
        window.parent.hidePopWin(true);
    }
</script>
<?php $this->template->display('dsp_footer_pop_win.php') ?>