(function( $ ) {

    $('#search_top #keyword_top').autocomplete({
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
            $('#search_top').submit();
        }
    });
    
    //set cookie accept
    $('#cookie-accept').click(function () {
          days = 182;
          myDate = new Date();
          myDate.setTime(myDate.getTime() + days * 24 * 60 * 60 * 1000);
          document.cookie = "comply_cookie = comply_yes; expires = " + myDate.toGMTString();
          $("#cookies").slideUp("slow");
    });

    // set cookie decline
    $('#cookie-decline').click(function () {
          days = 182;
          myDate = new Date();
          myDate.setTime(myDate.getTime() + days * 24 * 60 * 60 * 1000);
          document.cookie = "comply_cookie = comply_no; expires = " + myDate.toGMTString();
          $("#cookies").slideUp("slow");
    });

});