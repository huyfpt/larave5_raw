(function ($) {

    var initModal = function (url, loadedCallback) {
        HegydNews.initRemoteModal('#modal', url, loadedCallback, function (data) {
            refreshView(data);
        }, function () {
            toastr.error('Une erreur est survenue !');
        });
    };

    var refreshView = function (data) {
        if (data.success == false) {
            toastr.error('Une erreur s\'est produite.')
        } 
    }

    $('body').on('click', 'a.send-mail', function (e) {
        e.preventDefault();
        initModal($(this).attr('href'), function () {
            HegydNews.init();
            $('textarea.summernote').summernote({
                lang: 'fr-FR',
                height: 300,
            });
        });
    });

    $('body').on('click', 'a.delete-comment', function (e) {
        e.preventDefault();

    });

    window.displayList = function (self, data) {
        refreshView(data);
    }
})(jQuery)