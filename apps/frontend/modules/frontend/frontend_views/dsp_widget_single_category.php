<?php
defined('DS') or die('no direct access');
$arr_single_category = isset($arr_single_category) ? $arr_single_category : array();

$v_category_name = isset($arr_single_category[0]['C_CATEGORY_NAME']) ? $arr_single_category[0]['C_CATEGORY_NAME'] : '';
$v_category_id = isset($arr_single_category[0]['PK_CATEGORY']) ? $arr_single_category[0]['PK_CATEGORY'] : '';
$category_slug = isset($arr_single_category[0]['C_SLUG_CAT']) ? $arr_single_category[0]['C_SLUG_CAT'] : '';
$v_limit = isset($arr_single_category[0]['C_LIMIT']) ? $arr_single_category[0]['C_LIMIT'] : '10';

?>
<div class="news-title">
    <a href="<?php echo build_url_category($category_slug, $this->website_id, $v_category_id) ?>">
        <span style="line-height:17px;">
            <img src="<?php echo SITE_ROOT . "public/images/slider/icon.png" ?>" />
        </span> 
        <?php echo $v_category_name ?>
    </a>
</div>
<div id="news-vertical">
    <!--<div class="jcarousel-wrapper">-->
    <div class="Myjcarousel">
        <ul  id="news-2">
            <?php
            $i = 1;
            foreach ($arr_single_category as $arr_article):
                $v_title = $arr_article['C_TITLE'];
                $v_date = $arr_article['C_BEGIN_DATE_DDMMYY'];
                $article_slug = $arr_article['C_SLUG'];
                $article_id = $arr_article['PK_ARTICLE'];
                $website_id = $this->website_id;

                $v_url = build_url_article($category_slug, $article_slug, $website_id, $v_category_id, $article_id)
                ?>
                <li class="item <?php echo ($i == count($arr_single_category)) ? 'last' : ''; ?>">
                    <table class="table"> 
                        <tbody>
                            <tr> 
                                <td> <span class="asset-index"><?php echo $i; ?></span> </td> 
                                <td> 
                                    <a href="<?php echo $v_url; ?>">
                                        <span class="asset-title"> <?php echo $v_title ?></span> 
                                    </a> 
                                </td> 
                            </tr> 
                        </tbody>
                    </table>
                </li>

                <?php
                $i++;
            endforeach;
            ?>

        </ul>
    </div>
    <!--</div>-->
</div>
