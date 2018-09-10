(function (document, $) {
    /**
     *  Generic js controller for a list view
     * Object
     */
    var List = function () {
        var self = this;

        this.initDatatable = function () {
            AppDatatable.handleDataTable();
        };
        return {
            init: function () {
                self.initDatatable();
            }
        };
    }();

    $(document).ready(function () {
        List.init();
    });

})(document, jQuery);
