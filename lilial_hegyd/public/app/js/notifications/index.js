var Notification = function () {

    var self = this;


    this.readNotification = function (element) {
        var $element = $(element);
        var id = $element.data('id');

        if (typeof id !== 'undefined') {
            self.sendNotificationRequest('/notifications/' + id + '/read', 'PUT')
        }
    };

    this.readAllNotification = function () {
        self.sendNotificationRequest('/notifications/read-all', 'PUT')
    };

    this.unreadNotification = function (element) {

        var $element = $(element);
        var id = $element.data('id');

        if (typeof id !== 'undefined') {
            self.sendNotificationRequest('/notifications/' + id + '/unread', 'PUT')
        }
    };

    this.deleteNotification = function (element) {
        var $element = $(element);
        var id = $element.data('id');
        if (typeof id !== 'undefined') {
            self.sendNotificationRequest('/notifications/' + id, 'DELETE')
        }
    };

    this.sendNotificationRequest = function (url, method) {
        $.ajax({
            url: url,
            method: method,
            success: function (data) {
                $('.notifications').empty().append(data);
            }
        });
    };

    this.initEvents = function () {
        $('.notifications').on('click', 'span.mark-as-read', function (e) {
            e.preventDefault();
            var parent = $(this).parents('div.feed-element');
            if (parent.length) {
                self.readNotification(parent);
            }
        });
        $('.notifications').on('click', 'span.mark-as-unread', function (e) {
            e.preventDefault();
            var parent = $(this).parents('div.feed-element');
            if (parent.length) {
                self.unreadNotification(parent);
            }
        });
        $('.notifications').on('click', 'span.delete', function (e) {
            e.preventDefault();
            var parent = $(this).parents('div.feed-element');
            if (parent.length) {
                self.deleteNotification(parent);
            }
        });

        $('.read-all').on('click', function (e) {
            e.preventDefault();
            console.log('zll');
            self.readAllNotification();
        });

        var valPre = "";
        $('select[name="nbNotifPerPage"]').click(function () {
            valPre = $('select[name="nbNotifPerPage"]').val();
        });

        $('select[name="nbNotifPerPage"]').change(function (){
            var valPost = $(this).val();
            if(window.location.href.indexOf('perPage') !== -1){
                window.location.href.replace("perPage="+valPre,"perPage="+valPost);
            }
            else{
                window.location.replace('?perPage='+valPost);
            }
        });
    };

    return {
        init: function () {
            self.initEvents();
        }
    }
}();

(function ($) {

    Notification.init();

})(jQuery)