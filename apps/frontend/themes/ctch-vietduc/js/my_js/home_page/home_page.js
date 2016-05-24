ctch_vietduc.controller('content', function ($scope, $apply, $timeout, $http, $sce) {
    $scope.domSlide;
    $scope.domBxslider;
    $scope.sticky_slide = [];
    $scope.stickey_news = [];
    $scope.homepage_cat = {};
    $scope.art_of_cat = {};
    $scope.config = {
        slide_no: 4,
        other_art_of_cat_no: 5,
        cat_on_1_row: 3,
        weblink: {
            code: _CONST_LIST_DS_DOI_TAC
        }
    };
    $scope.partner_list = {};
    $scope.medical_register = {
        link_register: {name: 'Đội ngũ Bác sỹ',
                url: 'http://112.213.91.6/#register'
        },
        link: [
            {name: 'Đội ngũ Bác sỹ',
                url: 'http://112.213.91.6/#team',
                target: '_blank'},
            {name: 'Hướng dẫn',
                url: 'http://112.213.91.6/#register',
                target: '_blank'
            },
            {name: 'Tra cứu lịch',
                url: sv.url.build_category('lich-lam-viec', _VAR_WEBSITE_ID, '1334'),
                target: ''
            }
        ]
    };

    sv.data.sticky(function (response) {
        var sticky_slide = [];
        var stickey_news = [];
        var cat_slug = '';
        var art_slug = '';
        var cat_id = '';
        var art_id = '';
        var count = 1;

        for (var key in response)
        {
            cat_slug = response[key].C_CAT_SLUG;
            art_slug = response[key].C_ART_SLUG;
            cat_id = response[key].PK_CATEGORY;
            art_id = response[key].PK_ARTICLE;

            response[key].C_URL = sv.url.build_article(cat_slug, art_slug, _VAR_WEBSITE_ID, cat_id, art_id);
            response[key].C_FILE_NAME = sv.url.upload_file('/' + response[key].C_FILE_NAME);
            response[key].C_SUMMARY = $sce.trustAsHtml(response[key].C_SUMMARY);

            if (count <= $scope.config.slide_no)
                sticky_slide.push(response[key]);
            else
                stickey_news.push(response[key]);

            count++;
        }
        $apply(function () {
            $scope.sticky_slide = sticky_slide;
            $scope.stickey_news = stickey_news;
        });
    });

    sv.data.homepage_category(function (response) {
        var homepage_cat = [];
        var obj_data = {};
        var obj_tmp = {};
        var cat_slug = '';
        var art_slug = '';
        var cat_id = '';
        var art_id = '';
        var url = '';

        var last_index = 0;

        for (var key in response)
        {
            if ((parseInt(key) % $scope.config.cat_on_1_row) == 0)
            {
                obj_data = {};
                obj_data.other_cat = [];
                cat_slug = response[key].C_SLUG;
                cat_id = response[key].PK_CATEGORY;

                obj_data.cat_name = response[key].C_NAME;
                obj_data.cat_url = sv.url.build_category(cat_slug, _VAR_WEBSITE_ID, cat_id);

                obj_data.arr_articles = {};
                obj_data.arr_articles.first = {};
                obj_data.arr_articles.has_img = [];
                obj_data.arr_articles.other = [];

                for (var index in response[key].arr_articles)
                {
                    obj_tmp = {};
                    art_slug = response[key].arr_articles[index].C_SLUG;
                    art_id = response[key].arr_articles[index].PK_ARTICLE;

                    obj_tmp.title = response[key].arr_articles[index].C_TITLE;
                    obj_tmp.date = response[key].arr_articles[index].C_BEGIN_DATE_DDMMYYY;
                    obj_tmp.summary = $sce.trustAsHtml(response[key].arr_articles[index].C_SUMMARY);
                    obj_tmp.file_name = sv.url.upload_file('/' + response[key].arr_articles[index].C_FILE_NAME);
                    obj_tmp.url = sv.url.build_article(cat_slug, art_slug, _VAR_WEBSITE_ID, cat_id, art_id);
                    ;

                    if (parseInt(index) == 0)
                    {
                        obj_data.arr_articles.first = obj_tmp;
                    }
                    else if (parseInt(index) < $scope.config.other_art_of_cat_no)
                    {
                        obj_data.arr_articles.has_img.push(obj_tmp);
                    }
                    else
                    {
                        obj_data.arr_articles.other.push(obj_tmp);
                    }
                }

                homepage_cat.push(obj_data);
            }
            else
            {
                obj_data = {};
                last_index = homepage_cat.length - 1;
                cat_slug = response[key].C_SLUG;
                cat_id = response[key].PK_CATEGORY;

                obj_data.cat_name = response[key].C_NAME;
                obj_data.cat_url = sv.url.build_category(cat_slug, _VAR_WEBSITE_ID, cat_id);

                homepage_cat[last_index].other_cat.push(obj_data);
            }
        }

        $apply(function () {
            $scope.homepage_cat = homepage_cat;
        });

    });

    sv.data.weblink($scope.config.weblink.code, function (response) {
        console.log(response);
        $apply(function () {
            $scope.partner_list = response;
            var width = $($scope.domBxslider).width();
            $timeout(function () {
                $($scope.domBxslider).bxSlider({
                    slideWidth: width,
                    minSlides: 6,
                    maxSlides: 12,
                    moveSlides: 2,
                    slideMargin: 10,
                    infiniteLoop: true,
                    auto: false,
                    pause: 2000
                });
            }, 500);

        });
    })


    $scope.upload_file = function (file_name) {
        return sv.url.upload_file(file_name);
    }
});