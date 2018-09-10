(function ($) {

    /**
     * Init summernote textarea
     */
    $('textarea.summernote').summernote({
        lang: 'fr-FR',
        height: 300,
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

    Modal.init('#modal-category', '[name="category_id"]');

    $('#product_related').select2({
        language: 'fr',
        multiple: true,
        closeOnSelect: false,
        allowClear: true,
        maximumInputLength: 20,
        ajax: {
            url: "/admin/referentiel/produits/product-related",
            dataType: 'json',
            processResults: function (data, params) {
              return {
                results: data,
              };
            },
            cache: true
        },
    });

    $('#product_faq').select2({
        language: 'fr',
        multiple: true,
        closeOnSelect: false,
        allowClear: true,
        maximumInputLength: 20,
        ajax: {
            url: "/admin/faqs/ajax-list-faq",
            dataType: 'json',
            processResults: function (data, params) {
              return {
                results: data,
              };
            },
            cache: true
        },
    });

    $('.save-btn, .save-and-close-btn, .save-and-new-btn').click(function (e){
        var error = 0;
        $(':input[required]', '#product_form').each(function(){
            if($(this).val() == ''){

                if(error == 0){ 
                    $(this).focus(); 
                    var tab = $(this).closest('.tab-pane').attr('id');
                    $('#formTabProduct a[href="#' + tab + '"]').tab('show');
                }
                error = 1;

                var alert_error = '<ul><li>Champ requis manqués.</li></ul>';
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
        });

        if (error == 1) {
            return false;
        }

        return true;

    });

    $("#field-brand").change( function (){

        // update logo
        $.ajax({
            type : 'GET',
            url  : '/admin/referentiel/produits/brand-logo',
            data : {'id': $(this).val()},
            success : function(data) {

                if (data.logo) {
                    $('img.brand_logo').attr('src', data.logo);
                }
            }
        });

    });

})(jQuery)