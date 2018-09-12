var AppNotification = null;
(function ($) {
    var _AppNotification = function () {
        var self = this;
        this.warning = function (msg, title) {
            toastr.warning(msg, title);
        };
        this.success = function (msg, title) {
            toastr.success(msg, title);
        };
        this.error = function (msg, title) {
            toastr.error(msg, title);
        };
        this.info = function (msg, title) {
            toastr.info(msg, title);
        };
        /**
         * Initialize flash notification from the global variable flashNotifications
         */
        this.initializeFlashNotifications = function () {
            if (typeof (flashNotifications) === "undefined") {
                return;
            }
            for (var notification in flashNotifications) {
                this.flashNotify(notification, flashNotifications[notification]);
            }
        };
        /**
         * Execute the appropriate method for notify in function of the type
         * @param String msg
         * @param String type
         */
        this.flashNotify = function (msg, type) {
            if (type == 'success') {
                this.success(msg);
            } else if (type == 'error') {
                this.error(msg);
            } else if (type == 'warning') {
                this.warning(msg);
            } else if (type == 'info') {
                this.info(msg);
            }
        };
        return {
            init: function () {

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "3000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                self.initializeFlashNotifications();

                return self;
            }
        };
    }();

    $(document).ready(function () {
        AppNotification = _AppNotification.init();
    });

})(window.jQuery);
