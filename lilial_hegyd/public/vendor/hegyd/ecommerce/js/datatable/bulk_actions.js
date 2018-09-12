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

        $('#page-wrapper').on('click', '.import-modal', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $('#import-product-modal').modal('show');

            /*if ($(this).data('confirm-title') == 'import.zip') {
                $('#import-product-modal').modal('show');
            }*/
        });

/*        $('#form_import').submit(function (e) {

            var form_data =  new FormData($('#form_import'));

            $.ajax({
                type : 'POST',
                url  : '/admin/referentiel/produits/import-zip',
                data : form_data,
                processData: false,
                contentType: false,
                success : function(data) {
                    console.log(data);
                }
            });

            return false;
        });*/

        var bar = $('#bar');
        var percent = $('#percent');
        var result = $('#result');
        var progress = $('#progress');
        var percentValue = "0%";

        $('#form-import').ajaxForm({

             // Do something before uploading
              beforeUpload: function() {
                progress.removeClass('hidden');
                $('.import-error').addClass('hidden');
                result.empty();
                percentValue = "0%";
                bar.width = percentValue;
                percent.html(percentValue);

                validate_import_size();
              },
              // Do somthing while uploading
              uploadProgress: function(event, position, total, percentComplete) {
                var percentValue = percentComplete + '%';
                bar.width(percentValue)
                percent.html(percentValue);
                progress.removeClass('hidden');
                $('.import-error').addClass('hidden');
              },
              // Do something while uploading file finish
              success: function() {
                var percentValue = '100%';
                bar.width(percentValue)
                percent.html(percentValue);
              },

            complete: function(xhr) {

                progress.addClass('hidden');

                var json = JSON.parse(xhr.responseText);

                if (json['alert-type'] == 'error') {
                    $('.import-error').html(json.message).removeClass('hidden');
                }
                else {
                    location.reload(); 
                    //$('#import-product-modal').modal('hide');
                }

            }

          });

        $('#zip_file').change(function(){
            var limit = 80;
            var file_size = $('#zip_file')[0].files[0].size;

            if(file_size > limit * 1097152) {
                $('.import-error').removeClass('hidden').html('File size is greater than '+ limit +'MB');
                $('#submit-import').attr('disabled','disabled');
                return;
            }
            else {
                $('.import-error').addClass('hidden');
                $('#submit-import').removeAttr('disabled');
            }

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