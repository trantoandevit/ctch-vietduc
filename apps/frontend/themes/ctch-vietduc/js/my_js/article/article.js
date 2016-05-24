ctch_vietduc.controller('article', function ($scope, $apply, $timeout, $http, $sce) {
    $scope.article = [];
    $scope.other_article_list = []
    sv.data.article(cat_id, art_id, function (response) {
        $apply(function () {
            $scope.article = response;
            $scope.article.C_CONTENT = $sce.trustAsHtml(response.C_CONTENT);
        });
    });
    sv.data.other_article(cat_id, art_id, function (response) {
            console.log(response);
            for (var key in response) {
                var category_id = response[key].PK_CATEGORY;
                var article_id = response[key].PK_ARTICLE;
                response[key].C_URL = sv.url.build_article(response[key].C_CAT_SLUG, response[key].C_SLUG, _VAR_WEBSITE_ID, category_id, article_id);
            }
            $apply(function () {
                $scope.other_article_list = response;
            });
    });

});