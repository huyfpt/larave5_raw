(function ($) {
    $('#page-wrapper').on('click', 'a.force-reset-password', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $this = $(this);

        swal({
            title: 'Attention !',
            text: 'Êtes-vous sûr de vouloir réinitialiser le mot de passe de l\'utilisateur ?',
            allowOutsideClick: true,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D2282D',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'Oui !',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        method: 'PUT',
                        url: $this.attr('href'),
                        statusCode: {
                            404: function (xhr) {
                                AppNotification.error('Cette ligne n\'existe plus.');
                            },
                            500: function (xhr) {
                                AppNotification.error('Une erreur est survenue.');
                            }
                        },
                        success: function (data) {
                            AppNotification.success('Envoi du nouveau mot de passe effectué avec succès');
                        },
                        complete: function (data) {
                            window.AppDatatable.table.ajax.reload();
                            resolve();
                        }
                    });
                });
            }
        }).then(function (result) {
            swal.close();
        });
    });
})(jQuery)