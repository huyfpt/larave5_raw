$(document).ready(function() {
    $('#societe').hide(); 
    $('#association').hide(); 
    $('#sl-vous').change(function() {
        // var selectValue = $(this).val();
        // alert(selectValue);
        if($('#sl-vous').val() == 'professionnel'){
            $('#societe').show(); 
            $('#association').hide(); 
        } else if ($('#sl-vous').val() == 'association'){
            $('#association').show(); 
            $('#societe').hide();
        } else {
            $('#societe').hide(); 
            $('#association').hide(); 
        }
    })
});

// $.ajax({
//     type: 'POST',
//     url: url,
//     data: $('form').serialize(),
//     beforeSend: function() {

//     },
//     success:function(res) {
//         alert(res);
//     },
//     error: function(err) {
//         console.log(err);
//     }
// })