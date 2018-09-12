$('#client_zip').select2({
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