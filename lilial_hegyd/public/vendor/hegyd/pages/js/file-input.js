(function ($) {
    jQuery.event.props.push('dataTransfer');
    $.each($('input.unique-image-file-input'), function () {
        $this = $(this);

        var data = {
            language: 'fr',
            showCaption: false,
            showUpload: false,
            allowedFileTypes: ['image']
        };

        if ($this.data('show-remove') == 'false') {
            data.showRemove = false;
        }

        $this.on('drop', function (e) {
            if (e.dataTransfer) {
                if (e.dataTransfer.files.length) {
                    // Stop the propagation of the event
                    e.preventDefault();
                    e.stopPropagation();
                    // Main function to upload
                    $(this)[0].files = e.dataTransfer.files;
                    $(this).trigger('change');
                    console.log($(this));
                    console.log(e.dataTransfer.files);
                }
            }else if (e.originalEvent.dataTransfer) {
                if (e.originalEvent.dataTransfer.files.length) {
                    // Stop the propagation of the event
                    e.preventDefault();
                    e.stopPropagation();
                    // Main function to upload
                    $(this)[0].files = e.originalEvent.dataTransfer.files;
                }
            }
        });

        $this.fileinput(data);

    });

    $.each($('input.unique-video-file-input'), function () {
        $this = $(this);

        var data = {
            language: 'fr',
            showCaption: false,
            showUpload: false,
            allowedFileTypes: ['video']
        };

        if ($this.data('show-remove') == 'false') {
            data.showRemove = false;
        }

        $this.on('drop', function (e) {
            if (e.originalEvent.dataTransfer) {
                if (e.originalEvent.dataTransfer.files.length) {
                    // Stop the propagation of the event
                    e.preventDefault();
                    e.stopPropagation();
                    // Main function to upload
                    $(this)[0].files = e.originalEvent.dataTransfer.files;
                }
            }
        });

        $this.fileinput(data);

    });


    $('button.fileinput-remove').on('click', function () {
        $formgroup = $(this).parents('.form-group');
        console.log($formgroup, $formgroup.data('field'));
        var $input = $('<input/>', {
            name: $formgroup.data('field') + '-removed',
            type: 'hidden',
            value: 1
        });
        $(this).parents('form').append($input);
    });

})(jQuery);