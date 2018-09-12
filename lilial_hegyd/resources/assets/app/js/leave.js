(function($) {

    $('form').on('change', function(e) {
        window.onbeforeunload = goodbye;
    });

    $('form').on('submit', function(e){
        window.onbeforeunload = null;
    });

    $('.summernote').on('summernote.change', function(){
       $('form').trigger('change');
    });

})(jQuery);

function goodbye(e) {
    if ( ! e ) e = window.event;

    e.cancelBubble = true;
    e.returnValue = 'Une modification est en cours, êtes-vous sûr de vouloir changer de page sans enregistrer ?';

    if ( e.stopPropagation ) {
        e.stopPropagation();
        e.preventDefault();
    }
}