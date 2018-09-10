var NewsForm = function () {

    var self = this;

    this.likeNews = function() {
        $('body').on('click', '.news_like', function(e) {
            e.preventDefault();

            var $this = $(this);
            $.ajax({
                url: $this.data('href'),
                method: 'PUT',
                loader: false,
                success: function (data) {

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