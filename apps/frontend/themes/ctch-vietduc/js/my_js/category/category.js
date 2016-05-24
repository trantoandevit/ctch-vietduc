ctch_vietduc.controller('content', function ($scope, $apply, $timeout, $http, $sce) {
    // so bai doc moi page
    var article_per_page = 10;
    $scope.arr_category = [];
    $scope.category_name = '';
    $scope.paging = {
        page: 1,
        pagesize: article_per_page,
        total: 0
    };

    $scope.render_article = function () {
        sv.data.art_of_cat(filter.page, filter.cat_id, filter.key_word, function (response) {
            $scope.paging.total = response.TOTAL_RECORD;
            
            var arr_category = [];
            var cat_slug = response.CAT_SLUG;
            var cat_id = response.CAT_ID;
            var count = 1;
            var art_slug = '';
            var category_name = response.CAT_NAME;

            for (var key in response.data)
            {
                art_slug = response.data[key].C_SLUG;
                art_id = response.data[key].PK_ARTICLE;

                response.data[key].C_URL = sv.url.build_article(cat_slug, art_slug, _VAR_WEBSITE_ID, cat_id, art_id);
                response.data[key].C_FILE_NAME = sv.url.upload_file('/' + response.data[key].C_FILE_NAME);
                response.data[key].C_SUMMARY = $sce.trustAsHtml(response.data[key].C_SUMMARY);

                arr_category.push(response.data[key]);

                count++;
            }
            $apply(function () {
                $scope.arr_category = arr_category;
                $scope.category_name = category_name;
            });
        });
    };

    var url_cat_id = category_id;
    var filter = {
        page: 1,
        key_word: '',
        cat_id: url_cat_id
    };
    $scope.render_article();
    $scope.paging.pagging_action = function () {
        $timeout(function () {
            filter.page = $scope.paging.page;
            $scope.render_article();

        });
    };

});