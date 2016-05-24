ctch_vietduc.controller('sidebar_right', function($scope, $apply, $timeout, $http, $sce){
    $scope.config = {
        default_cat_config: {
            page: '-1',
            id: 1332,
            key_word: '',
            data_haft_length: 0
        },
        website_id: _VAR_WEBSITE_ID
    };
    
    $scope.default_cat = {};
    $scope.build_art_url = function(cat_slug, art_slug, cat_id, art_id){
        return sv.url.build_article(cat_slug, art_slug, _VAR_WEBSITE_ID, cat_id, art_id);
    }
    
    sv.data.art_of_cat(
            $scope.config.default_cat_config.page, 
            $scope.config.default_cat_config.id, 
            $scope.config.default_cat_config.key_word,
            function(reponse){
                var length_data = reponse.data.length;
                reponse.C_URL = sv.url.build_category(reponse.CAT_SLUG, _VAR_WEBSITE_ID, reponse.CAT_ID);
                $apply(function(){
                    $scope.config.default_cat_config.data_haft_length = Math.ceil(length_data/2);
                    $scope.default_cat = reponse;
                });
            }
    );
});
