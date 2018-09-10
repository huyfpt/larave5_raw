var NewsForm = function () {

    var self = this;

    this.likeNews = function() {
        $('body').on('click', '.news_like', function(e) {
            e.preventDefault();

            var $this = $(this);
            var $like = $this.data('like');
            var $id = $this.data('id');

            $.ajax({
                url: $this.data('href'),
                data: {
                    'like_status' : $like
                },
                method: 'PUT',
                loader: false,
                success: function (data) {
                    if (data.success == false) {
                        toastr.error('Une erreur s\'est produite.');
                    } else if (data.hasOwnProperty('view')) {
                        $('#like_' + $id).empty().append(data.view);
                    }
                }
            });
        })
    };

    return {
        init: function () {
            self.likeNews();
        }
    };
}();

$(window).load(function () {
    NewsForm.init();
});