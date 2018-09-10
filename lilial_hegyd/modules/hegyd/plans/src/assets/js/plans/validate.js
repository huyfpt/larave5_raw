$('.fileinput-remove-button').click(function(){
    $("input[name='visual']").attr("required", true)
});
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
        else {
            $(this).siblings('.help-block').html('');
            $(this).parent().parent().removeClass('has-error');
        }
    });

    function showZipError(error, error_help) {
        if(error == 0) {
            $('input[name="address[zip]"]').focus();
            var tab = $('input[name="address[zip]"]').closest('.tab-pane').attr('id');
            $('#formTab a[href="#' + tab + '"]').tab('show');
        }
        $('input[name="address[zip]"]').siblings('.help-block').html(error_help);
        $('input[name="address[zip]"]').parent().parent().addClass('has-error');
    }

    var zipIsNumeric = '<ul><li><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Le code postal est requis.</font></font></li></ul>';
    var zipLenght = '<ul><li><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Le code postal doit être composé de 5 chiffres.</font></font></li></ul>';

    if($('input[name="address[zip]"]').val() != '') {
        if(!$.isNumeric($('input[name="address[zip]"]').val())) {
            showZipError(error, zipIsNumeric);
            error +=1 ;
        } else if($('input[name="address[zip]"]').val().length != 5) {
            showZipError(error, zipLenght);
            error +=1 ;
        } else {
            $('input[name="address[zip]"]').siblings('.help-block').html('');
            $('input[name="address[zip]"]').parent().parent().removeClass('has-error');
        }
    }
    
    if (error != 0) {
        var message = error + '  champs ne sont pas valides. Ils sont entourés de rouge';
        toastr.error(message);
        return false;
    }

    return true;

});