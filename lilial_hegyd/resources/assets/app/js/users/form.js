(function ($) {
    $('button.btnForcePasswordReset').on('click', function (e) {
        e.preventDefault();
        $this = $(this);
        swal({
            title: 'Attention !',
            text: 'Êtes-vous sûr de vouloir réinitialiser le mot de passe de l\'utilisateur ?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: "Non",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Oui"
        }).then(function (result) {
            if (result.value) {
                $('input[id="_action"]', '#userForm').val($this.attr('name'));
                document.getElementById("userForm").submit()
            }
        });
    });

    $('#commission_type').on('change', function (e) {
        showHideCommission();
    });
    $('#mentor_type').on('change', function (e) {
        showHideMentor();
    });

    function showHideCommission() {
        var $block = $('.commission_percent_block');
        var hide = $block.data('hide') == $("#commission_type").val();

        if (hide) {
            $block.addClass('hide');
            $('[name="commission_percent"]', $block).val('');
        }
        else {
            $block.removeClass('hide');
        }
    }

    function showHideMentor() {
        var $block = $('.mentor_percent_block');
        var hide = $block.data('hide') == $("#mentor_type").val();

        if (hide) {
            $block.addClass('hide');
            $('[name="mentor_percent"]', $block).val('');
        }
        else {
            $block.removeClass('hide');
        }
    }

    showHideCommission();
    showHideMentor();

    $('#user_city').select2({
        language: 'fr',
        multiple: false,
        closeOnSelect: true,
        allowClear: false,
        maximumInputLength: 20,
        ajax: {
            url: "/admin/utilisateurs/address/cities",
            dataType: 'json',
            processResults: function (data, params) {
              return {
                results: data,
              };
            },
            cache: true
        },
    });

})(jQuery)