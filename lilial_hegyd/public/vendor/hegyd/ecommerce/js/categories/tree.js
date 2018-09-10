(function ($) {

    loadNestableTree();

    function loadNestableTree(){
        $.ajax({
            type : 'GET',
            url  : '/admin/referentiel/categories/ajax-nestable',
            success : function(data) {
              $('#category').html(data.html);
              $('#category').nestable({ });
            }
        });
    }

    $('#category').on('change', function(e) {
        var list   = e.length ? e : $(e.target);
        var json = window.JSON.stringify(list.nestable('serialize'));

        updateNestable(json);
    });

    function updateNestable(data){
        $.ajax({
            type : 'POST',
            url  : '/admin/referentiel/categories/update-nestable',
            data : {'json': data},
            success : function(data) {

            }
        });
    }


    $('#category').on('click', '.dd-delete a', function(e) {
        deleteUrl = $(this).data('delete-url');

        var confirm = swal({
            title: 'Êtes-vous sûr ?',
            allowOutsideClick: true,
            text: $(this).data('text'),
            type: 'warning',
            html: true,
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonColor: "#D2282D",
            cancelButtonText: 'Annuler',
            confirmButtonText: "Oui !"
        }, function (isConfirm) {
            if (isConfirm) {
                deleteCategory(deleteUrl);
            }
        });
    });

    function deleteCategory(url) {
            $.ajax({
                method: 'DELETE',
                url: url,
                statusCode: {
                    404: function (xhr) {
                        AppNotification.error('Cette ligne a déjà été supprimée.');
                    },
                    500: function (xhr) {
                        // AppNotification.error('Une erreur est survenue.');
                    }
                },
                success: function (data) {
                    if (data.error) {
                      AppNotification.error('Suppression impossible.');
                    }
                    else {
                      AppNotification.success('Suppression effectuée avec succès.');
                    }
                },
                error: function (data) {
                    var response = JSON.parse(data.responseText);
                    if (typeof(response.messages) !== 'undefined') {
                        var message = response.main_message + '<br/>';
                        $(response.messages).each(function (index, msg) {
                            message += (index + 1) + '. ' + msg;
                        });
                        AppNotification.error(message);
                    }
                },
                complete: function (data) {
                    loadNestableTree();
                }
            });
        }



})(jQuery)