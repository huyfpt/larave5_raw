var BulkActions = function () {

    var self = this;

    this.runAction = function (href, confirm, confirmTitle, confirmText, ajax) {

        $checkedRows = $('input[name="select-row"]:checked');

        if(confirmText.indexOf("Import Excel") != -1) {
            $('#import-excel-modal').modal('show') ;
        }
        else {
            if (!$checkedRows.length) {
                swal({
                    title: 'Attention !',
                    text: confirmText,
                    allowOutsideClick: true,
                    html: 'Vous devez sélectionner au moins un élément pour lancer l\'action.',
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: "#D2282D",
                    confirmButtonText: "Ok"
                });

                return false;
            }

            if (confirm) {
                swal({
                    title: confirmTitle,
                    text: confirmText,
                    allowOutsideClick: true,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#D2282D',
                    cancelButtonText: 'Annuler',
                    confirmButtonText: 'Oui !',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return new Promise(function (resolve) {
                            self.executeRequest($checkedRows, href, ajax, undefined, undefined, resolve);
                        });
                    }
                }).then((result) => {
                    swal.close();
            });

            } else {
                self.executeRequest($checkedRows, href, ajax);
            }
            
        }

    };

    this.executeRequest = function ($checkedRows, href, ajax, callbackSuccess, callbackError, callbackComplete) {

        var ids = [];
        $checkedRows.each(function () {
            ids.push($(this).val());
        });


        if (ajax) {
            $.ajax({
                url: href,
                data: {ids: ids},
                success: function () {
                    toastr.success('Action effectuée avec succès');
                    window.location.href = href + '?ids=' + ids;
                },
                error: function () {
                    toastr.error('Une erreur s\'est produite');
                },
                complete: function () {
                    window.AppDatatable.table.ajax.reload();
                    if(callbackComplete !== undefined)
                    {
                        callbackComplete();
                    }
                }
            });
        } else {
            window.location.href = href + '?ids=' + ids;
        }
    };

    this.initEvents = function () {

        $('#wrapper').on('click', '.bulkAction', function (e) {

            e.preventDefault();
            e.stopPropagation();

            self.runAction(
                $(this).attr('href'),
                $(this).data('confirm'),
                $(this).data('confirm-title') ? $(this).data('confirm-title') : 'Êtes-vous sûr ?',
                $(this).data('confirm-text'),
                $(this).data('ajax')
            );

        });
    };


    return {
        init: function () {
            self.initEvents();
            return self;
        }
    };
}();

(function ($) {
    BulkActions.init();
})(jQuery);