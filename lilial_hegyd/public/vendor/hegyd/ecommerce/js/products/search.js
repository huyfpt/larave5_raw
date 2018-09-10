
jQuery(document).ready(function(){

    $('#keyword').autocomplete({
        minChars: 2,
        lookup: function (query, done) {

            var result = null;
            $.ajax({
                url: '/produits/suggest?q=' + query,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    result = data;
                    done(result);
                },
            });
        },

        onSelect: function (suggestion) {
            //console.log('select');
            //$('.hp-form').submit();
        }
    });

});