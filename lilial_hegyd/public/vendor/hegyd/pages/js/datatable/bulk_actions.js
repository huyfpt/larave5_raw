var BulkActions = function () {

    var self = this;

    this.runAction = function (href, confirm, ajax) {

        $checkedRows = $('input[name="select-row"]:checked');

        if (!$checkedRows.length) {
            swal({
                title: 'Attention !',
                allowOutsideClick: true,
                text: 'Vous devez sélectionner au moins un élément pour lancer l\'action.',
                type: 'error',
                html: true,
                showCancelButton: false,
                closeOnConfirm: true,
                confirmButtonColor: "#D2282D",
                confirmButtonText: "Ok"
            });

            return false;
        }

        if (confirm) {
            var confirm = swal({
                title: 'Êtes-vous sûr ?',
                allowOutsideClick: true,
                type: 'warning',
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
                confirmButtonColor: '#D2282D',
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Oui !'
            }, function (isConfirm) {
                if (isConfirm) {
                    self.executeRequest($checkedRows, href, ajax);
                }
            });

        } else {
            self.executeRequest($checkedRows, href, ajax);
        }

    };

    this.executeRequest = function ($checkedRows, href, ajax) {

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
                },
                error: function () {
                    toastr.error('Une erreur s\'est produite');
                },
                complete: function () {
                    window.AppDatatable.table.ajax.reload();
                }
            });
        } else {
            window.location.href = href + '?ids=' + ids;
        }
    };

    this.initEvents = function () {

        $('.wrapper-content').on('click', '.bulkAction', function (e) {
            e.preventDefault();
            e.stopPropagation();

            self.runAction($(this).attr('href'), $(this).data('confirm'), $(this).data('ajax'));
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