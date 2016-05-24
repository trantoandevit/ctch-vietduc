<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php
$VIEW_DATA['title'] = $this->website_name;

$VIEW_DATA['v_banner'] = $v_banner;
$VIEW_DATA['arr_all_website'] = $arr_all_website;
$VIEW_DATA['arr_all_menu_position'] = $arr_all_menu_position;

$VIEW_DATA['arr_css'] = array();

$VIEW_DATA['arr_script'] = array('my_js/article/article', 'my_js/sidebar_right');
$cat_id = get_request_var('category_id',0);
$art_id = get_request_var('article_id',0);
$this->render('dsp_header', $VIEW_DATA, $this->theme_code);
?>
<script>
    var cat_id = '<?php echo $cat_id?>';
    var art_id = '<?php echo $art_id?>';
</script>
<section>
    <div class="container content" ng-controller="article">
        <div class="row news" ng-cloak="true">
            <div class="col-md-8 new_left">
                <div class="row">
                    <div class="col-md-12 nlr_content">
                        <h3>{{article.C_TITLE}}</h3>
                        <p><i class="fa fa-clock-o" aria-hidden="true"></i><span ng-cloak>Tạo vào ngày {{article.C_BEGIN_DATE}}</span><p>
                        <p ng-if="article.update"><i class="fa fa-clock-o" aria-hidden="true"></i><span ng-cloak>Sửa : {{article.C_UPDATE_DATE}} ngày {{article.C_UPDATE_BY}}</span></p>
                        <div ng-bind-html="article.C_CONTENT" ng-cloak></div>
                    </div>
                    <div class="col-md-12 social-plugin">
                        <?php $this->render('dsp_social_plugin', $VIEW_DATA, $this->theme_code); ?>
                    </div>
                    <div class="col-md-12 other-article">
                        <h4><i class="fa fa-tags" aria-hidden="true"></i> Các bài viết liên quan</h4>
                        <ul class="list-unstyled">
                            <li ng-repeat="other_article in other_article_list">
                                <a href="{{other_article.C_URL}}"><i class="fa fa-caret-right"></i> {{other_article.C_TITLE}}</a>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            <?php $this->render('dsp_sidebar_right', $VIEW_DATA, $this->theme_code); ?>
        </div>

    </div>
</section>
<style>
    .other-article
    {
        margin:10px 0px;
    }
</style>
<?php
$this->render('dsp_footer', $VIEW_DATA, $this->theme_code);
