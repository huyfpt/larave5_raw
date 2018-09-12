(function ($) {

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
    $.each($('input.unique-file-file-input'), function () {
        $this = $(this);

        var data = {
            language: 'fr',
            showCaption: false,
            showUpload: false,
            showDrag: false,
            fileActionSettings: {
                showZoom: false,
                showUpload: false,
                showDrag: false
            }
        };

        if ($this.data('allowed-format')) {
            data.allowedFileTypes = $this.data('allowed-format');
        }

        if ($this.data('show-remove') == 'false') {
            data.showRemove = false;
            data.fileActionSettings.showRemove = false;
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
        var $input = $('<input/>', {
            name: $formgroup.data('field') + '-removed',
            type: 'hidden',
            value: 1
        });
        $(this).parents('form').append($input);
    });

})(jQuery);