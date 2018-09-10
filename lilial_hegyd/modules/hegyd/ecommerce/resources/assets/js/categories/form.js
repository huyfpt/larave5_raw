(function ($) {

    /**
     * Init summernote textarea
     */
    $('textarea.summernote').summernote({
        lang: 'fr-FR',
        height: 300,
    });

    $('.save-btn, .save-and-close-btn, .save-and-new-btn').click(function (e){
        var error = 0;
        $(':input[required]').each(function(){
            if($(this).val() == '' || $(this).val() ==  '<p><br></p>'){

                if(error == 0){ 
                    $(this).focus(); 
                    var tab = $(this).closest('.tab-pane').attr('id');
                    $('#formTab a[href="#' + tab + '"]').tab('show');
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

})(jQuery)