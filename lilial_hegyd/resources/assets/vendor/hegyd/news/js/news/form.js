(function ($) {

    /**
     * Init summernote textarea
     */
    $('textarea.summernote').summernote({
        lang: 'fr-FR',
        height: ($(window).height() - 300),
        dialogsInBody: true,
        callbacks: {
            onImageUpload: function(files){
                that = $(this);
                model = $('#news_form').attr('id').replace('_form', '');
                ajaxUploadImage(files[0], that, model);
            }
        },
    });

    $('.date').datepicker({
        format: 'dd/mm/yyyy',
        language: 'fr',
        rtl: false,
        orientation: 'bottom auto',
        autoclose: true
    });

    $('select[name="category_id"]').select2({
        language: 'fr'
    });

    $('select[name="author_id"]').select2({
        language: 'fr'
    });


    $.fn.select2.amd.require([
        'select2/utils',
        'select2/dropdown',
        'select2/dropdown/attachBody'
    ], function (Utils, Dropdown, AttachBody) {
        function SelectAll() {
        }

        SelectAll.prototype.render = function (decorated) {
            var $rendered = decorated.call(this);
            var self = this;

            var $selectAll = $('<a/>')
                .addClass('btn btn-info')
                .text('Tous')
                .prepend('<i class="fas fa-plus"></i> ');

            var $selectNone = $('<a/>')
                .addClass('btn btn-danger')
                .text('Aucun')
                .prepend('<i class="fas fa-times"></i> ');

            var $div = $('<div/>')
                .addClass('btn-in-select2')
                .append($selectAll)
                .append($selectNone);

            var checkOptionsCount = function () {
                var count = $('.select2-results__option').length;
                $selectAll.prop('disabled', count > 25);
            };

            var $container = $('.select2-container');
            $container.bind('keyup click', checkOptionsCount);

            var $dropdown = $rendered.find('.select2-dropdown');

            $dropdown.prepend($div);

            $selectAll.on('click', function (e) {
                var $results = $rendered.find('.select2-results__option[aria-selected=false]');

                // Get all results that aren't selected
                $results.each(function () {
                    var $result = $(this);

                    // Get the data object for it
                    var data = $result.data('data');

                    // Trigger the select event
                    self.trigger('select', {
                        data: data
                    });
                });

                self.trigger('close');
            });

            $selectNone.on('click', function (e) {
                // Trigger the select event
                self.$element.val(null);
                self.$element.trigger('change');
                self.trigger('close');
            });

            return $rendered;
        };

        $('select[name="role_ids[]"]').select2({
            dropdownAdapter: Utils.Decorate(
                Utils.Decorate(
                    Dropdown,
                    AttachBody
                ),
                SelectAll
            )
        });
    });


    Modal.init('#modal-category', '[name="category_id"]');

})(jQuery)