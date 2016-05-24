ctch_vietduc.controller('header', function ($scope, $apply, $timeout, $http) {
    $scope.domMenuPosition;
    $scope.menuPosition = '';
    $scope.menus = {};
    
    sv.data.menu(function(response){
        $scope.menuPosition = $($scope.domMenuPosition).attr('data-id');
        $apply(function () {
            $scope.menus = response[$scope.menuPosition];
        });
    });
    
});