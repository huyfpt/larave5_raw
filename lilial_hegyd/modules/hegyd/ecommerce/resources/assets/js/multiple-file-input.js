(function ($) {

    $('.multiple-file-input').each(function () {
        $this = $(this);

        var updateUrl = $this.data('update-url');

        var documentFileInputData = {
            uploadUrl: updateUrl,
            uploadAsync: false,
            language: 'fr',
            showCaption: false,
            showUpload: false,
            overwriteInitial: false,
            minFileCount: 1,
            fileActionSettings: {
                showZoom: false,
                showUpload: false,
            }
        };

        var $initDocument = $('div[name="initDocuments"]', $this.parent());

        if ($initDocument.data('preview-config')) {
            $.extend(documentFileInputData, {
                initialPreviewConfig: $initDocument.data('preview-config')
            });
        }

        if ($initDocument.data('preview')) {
            $.extend(documentFileInputData, {
                initialPreview: $initDocument.data('preview')
            });
        }

        $this.fileinput(
            documentFileInputData
        ).on('filesorted', function (e, params) {

            if (!updateUrl)
                return false;

            var datas = [];

            $.each(params.stack, function (i, item) {
                datas.push({id: item.document_id, position: i});
            });

            if (datas.length) {
                $.ajax({
                    url: updateUrl,
                    method: 'PUT',
                    data: {'uploads': datas},
                });
            }
        });
    });
})(jQuery);