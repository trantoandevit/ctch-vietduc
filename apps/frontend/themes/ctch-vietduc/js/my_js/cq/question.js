ctch_vietduc.controller('content', function ($scope, $apply, $timeout, $sce) {
    // so cau hoi moi page
    var cq_per_page = 10;
    $scope.arr_category = [];
    $scope.category_name = '';
    $scope.cq_field_list = {};
    $scope.paging = {
        page: 1,
        pagesize: cq_per_page,
        total: 0
    };
    var filter = {
        page: 1,
        key_word: ''
    };
    $scope.popup_question = {};
    $scope.render_question = function () {
        sv.data.all_cq(filter, function (response) {
            $scope.paging.total = response.count;
            var arr_question = [];
            for (var key in response.data)
            {
                response.data[key].C_CONTENT = $sce.trustAsHtml(response.data[key].C_CONTENT);
                response.data[key].C_ANSWER = $sce.trustAsHtml(response.data[key].C_ANSWER);
                arr_question.push(response.data[key]);
            }
            $apply(function () {
                $scope.arr_question = arr_question;
            });
        });
    };


    $scope.render_question();
    $scope.paging.pagging_action = function () {
        $timeout(function () {
            filter.page = $scope.paging.page;
            $scope.render_question();

        });
    };
    $('#key_search_cq').keypress(function (e) {
        var key = e.which;
        if (key == 13)  // the enter key code
        {
            filter.page = 1;
            filter.keyword = $('#key_search_cq').val();
            $scope.paging.pagging_action();
        }
    });
    $("#frmCQ").submit(function (e) {
        e.preventDefault();
        var data = $('#frmCQ').serialize();
        sv.data.do_insesrt_cq(data, function (respone) {
            console.log(respone);
            if (respone.stt == 'done') {
                grecaptcha.reset();
                alert(respone.msg_error);
                $("#frmCQ")[0].reset();
                $("#msg_error_captchar").html("");
            } else {
                if (respone.stt == 'false_captcha') {
                    $("#msg_error_captchar").html(respone.msg_error)
                } else {
                    alert(respone.msg_error);
                }
            }
        });

    });
    $scope.show_answer = function (item) {
        $("#myModalCTCH").on('shown.bs.modal', function () {
            $apply(function () {
                $scope.popup_question = item;
            });
        });
    };
    $scope.get_cq_field = function () {
        sv.data.get_cq_field(function (response) {
            $apply(function () {
                $scope.cq_field_list = response;
            });
        });
    };
    $scope.get_cq_field();
});

$(document).ready(function () {
    $('#list_cq').slimScroll({
        height: '510px'
    });


});