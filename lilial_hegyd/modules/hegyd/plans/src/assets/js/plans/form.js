(function ($) {
    /**
     * Init summernote textarea
     */
    $('textarea.summernote').summernote({
        lang: 'fr-FR',
        height: 300,
        dialogsInBody: true,
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

    $('.save-btn, .save-and-close-btn, .save-and-new-btn').click(function (e){
        var error = 0;

        $(':input[required]', '#plans_form').each(function(){
            if($(this).val() == ''){

                if(error == 0){ 
                    $(this).focus();
                    var tab = $(this).closest('.tab-pane').attr('id');
                    $('#formTab a[href="#' + tab + '"]').tab('show');
                }
                error += 1;

                var name = $(this).attr('name');

                alert_error = '<ul><li><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Le champ '+ name +' est obligatoire.</font></font></li></ul>';
                if ($(this).attr('name') == 'visual') {
                    var file_input = $(this).parent().parent();
                    file_input.siblings('.help-block').html(alert_error);
                    file_input.parent().parent().addClass('has-error');
                }
                else {
                    $(this).siblings('.help-block').html(alert_error);
                    $(this).parent().parent().addClass('has-error');
                }
            }
            var input_zip = $('input[name="address[zip]"]');
            if(input_zip.val().length != 5) {
                zip_error = '<ul><li><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Les codes postaux doivent comporter 5 chiffres.</font></font></li></ul>';
                error +=1 ;
                input_zip.siblings('.help-block').html(zip_error);
                input_zip.parent().parent().addClass('has-error');
                input_zip.focus();
            }
        });
        
        
        if (error != 0) {
            var message = error + '  champs ne sont pas valides. Ils sont entourés de rouge';
            toastr.error(message);
            return false;
        }

        return true;

    });

})(jQuery)