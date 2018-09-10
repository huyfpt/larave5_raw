var Modal = function () {
    var self = this;

    this.initModal = function (selector, targetInput, callback) {

        var $modal = $(selector);

        if (!$modal.length) {
            console.error('Modal not found !');
            return false;
        }

        var $form = $modal.find('form');
        var $loader = $modal.find('.loading');
        var $inputTarget = '';

        if (typeof targetInput !== 'undefined') {
            $inputTarget = $(targetInput);
        }


        $modal.on('hidden.bs.modal', function () {
            $form.find('input').not('[type="hidden"]').val('');
            $loader.addClass('hide');
            $form.removeClass('hide');
            $('div.alert.alert-danger', $form).remove();
        });

        $form.ajaxForm({
            beforeSubmit: function (arr, $form, option) {
                $form.addClass('hide');
                $loader.removeClass('hide');
            },
            success: function (data) {
                if ($inputTarget.length) {
                    var $option = $('<option/>');
                    $option.val(data.entity.id).attr('selected', 'selected').html(data.entity.name);
                    $inputTarget.append($option);
                }

                if (callback != undefined) {
                    callback(data);
                }

                $modal.modal('hide');
            },
            error: function (data, error, msg) {
                $loader.addClass('hide');
                $form.removeClass('hide');
                var $error = $('<div/>').addClass('alert alert-block alert-danger fade in').html('<button data-dismiss="alert" class="close close-sm" type="button">\
                <i class="fa fa-times"></i>\
                </button>' + self.getOutputData(data.responseJSON));
                $form.prepend($error);
            }
        });
    }

    self.getOutputData = function (data) {
        if (typeof data !== 'undefined') {
            var html = '<ul>';
            $.each(data, function (key, item) {
                html += '<li>' + item + '</li>';
            });
            html += '</ul>';

            return html;
        }

        return 'Un problème est survenue lors de l\'enregistrement';
    }

    return {
        init: function (selector, targetInput, callback) {
            self.initModal(selector, targetInput, callback);
        }
    }
}();