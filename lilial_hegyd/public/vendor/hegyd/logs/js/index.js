(function ($) {

    /**
     * Init datepicker
     */
    $('.form_datetime.day').datepicker({
        language: 'fr',
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayBtn: true,
        pickerPosition: 'bottom-left',
        minView: 2
    });


    /**
     * Init users select
     */
    $('[name="user_ids[]"]').select2({
        allowClear: true,
        multiple: true,
        ajax: {
            url: '/admin/users',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    query: params.term
                }
            },
            processResults: function (data) {
                var results = [];
                $.each(data, function (id, entity) {
                    results.push({
                        id: entity.id,
                        text: entity.firstname + ' ' + entity.lastname
                    });
                });
                return {results: results}
            },
            cache: false
        },
        initSelection: function (element, callback) {
            var ids = $('[name="user_ids"]').val();
            results = [];
            $.ajax("/admin/utilisateurs/multi/" + ids, {
                dataType: "json"
            })
                .done(function (data) {
                    $.each(data, function (idx, entity) {
                        var id = entity.id;
                        var text = entity.firstname + ' ' + entity.lastname;
                        element.append(new Option(text, id, false, true));
                        results.push({id: id, text: text});
                    });
                    callback(results);
                });
        }
    });


    /**
     * Events
     */
    $('body').on('change', 'select[name="nb_by_page"]', function () {

        var url = '/admin/logs';

        if (window.location.search) {
            url += window.location.search + '&';
        } else {
            url += '?';
        }

        url += 'page=0&limit=' + $(this).val();

        $.ajax({
            type: "POST",
            url: url,
            success: function (data, textStatus, jqXHR) {
                var table = $('div.logs');
                var parent = table.parent();
                table.remove();
                parent.append(data);
            }
        });


        return false;
    });

    $("#export_csv").click(function (e) {
        e.preventDefault();
        document.location = "/admin/logs/exportcsv" + window.location.search;
    });
    $("#export_excel").click(function (e) {
        e.preventDefault();
        document.location = "/admin/logs/exportexcel" + window.location.search;
    });

    $("#export_pdf").click(function (e) {
        e.preventDefault();
        document.location = "/admin/logs/exportpdf" + window.location.search;
    });
    
    $('.btn-reset').click(function (e) {
        e.preventDefault();
        $('input, select').val('');
        $('form').submit();
    })
})(jQuery);