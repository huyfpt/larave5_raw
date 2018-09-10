(function ($) {

    var initModal = function (url, loadedCallback) {
        HegydPlans.initRemoteModal('#modal', url, loadedCallback, function (data) {
            refreshView(data);
        }, function () {
            toastr.error('Une erreur est survenue !');
        });
    };

    var refreshView = function (data) {
        if (data.success == false) {
            toastr.error('Une erreur s\'est produite.')
        } else if (data.hasOwnProperty('view')) {
            $('.list-comment .comment-items').empty().append(data.view);
            toastr.success(data.message);
        } else if(data.hasOwnProperty('hide')) {
            $('#comment-report_' + data.id).hide();
            toastr.success(data.message);
        }
    }

    $('body').on('click', 'a.add-comment, a.edit-comment, a.report-comment', function (e) {
        e.preventDefault();
        initModal($(this).attr('href'), function () {
            HegydPlans.init();
        });
    });

    window.displayList = function (self, data) {
        refreshView(data);
    }
})(jQuery)