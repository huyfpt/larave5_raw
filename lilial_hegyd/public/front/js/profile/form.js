(function ($) {
    $('#profile_zip').select2({
        language: 'fr',
        multiple: false,
        closeOnSelect: true,
        allowClear: false,
        maximumInputLength: 20,
        ajax: {
            url: "/admin/plans/address/postcode",
            dataType: 'json',
            processResults: function (data, params) {
              return {
                results: data,
              };
            },
            cache: true
        },
    });

    /*$('.btn-upload').on('click', function(e) {
        $('.upload-photo img').attr('src', '');
        var protocol = window.location.protocol;
        var hostname = location.hostname;
        $('.upload-photo img').attr('src', protocol+'//'+hostname+'/media/32/1/0/1/download.png');
    });*/
})(jQuery)