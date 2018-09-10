$(document).ready(function(){

    /**
     * Init summernote textarea
     */
    /*$('textarea.summernote').summernote({
        lang: 'fr-FR',
        height: 300,
    });*/


    /**
     * Init switchery checkbox
     */
    Switcheryable = function (elems) {

        var elems = Array.prototype.slice.call(document.querySelectorAll('.switcheryable'));

        elems.forEach(function (html) {
            var switchery = new Switchery(html, defaults = {
                color: '#64bd63'
                , secondaryColor: '#dfdfdf'
                , jackColor: '#fff'
                , jackSecondaryColor: null
                , className: 'switchery'
                , size: 'small'
            });
        });
    };

    /**
     * Initialize Select2.js items. No options required to initialise a select
     * @param selector
     * @param options_forced
     */
    var initSelect2 = function (selector, options_forced){

        selector = typeof selector !== 'undefined' ? selector : '.selectable2';
        options_forced = typeof options_forced !== 'undefined' ? options_forced : {};

        var options_default = {
            language: 'fr'
        };
        $.extend(options_default, options_forced);

        var $selector = $(selector);

        if ( $selector != undefined && $selector.length ) {
            if ( $selector.length > 1 ) {

                $selector.each(function(){

                    $(this).select2(options_default);

                    // Is selected items are available in data-selected as array then force them
                    var selected = $(this).data('selected');
                    if (selected != undefined && selected.length > 0) {
                        $("div"+selector).select2('data', selected);
                    }

                });

            } else {

                $selector.select2(options_default);

                // Is selected items are available in data-selected as array then force them
                var selected = $selector.data('selected');
                if (selected != undefined && selected.length > 0) {
                    $("div"+selector).select2('data', selected);
                }

            }

        }

    };


    // initSelect2();

    // Switcheryable('.switcheryable');

    // Permet d'automatiquement rajouter un formulaire appelant avec la requête stocké dans
    // data-form. <a href="/entity/1" data-form="delete"> a.wizard > .content > .body span.switchery appelerai l'url dans href
    // avec la méthode "delete"
    // Rajouter un data-confirm="false" pour désactiver la demande [Actif par défaut]
    // UTILISE SWEETALERT ET NON CONFIRM
    $('body').on('click', '[data-form]', function (evt) {
        evt.preventDefault();
        var self = $(this);

        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        self.append(function () {

            if (self.find('form').length)
                return;

            return "\n" +
                "<form action='" + self.attr('href') + "' method='POST' style='display:none;'>\n" +
                "<input type='hidden' name='_token' value='" + csrf_token + "' />" +
                "	<input type='hidden' name='_method' value='" + self.data('form') + "'>\n" +
                "</form>";

        });

        self.removeAttr('href');
        self.attr('style', 'cursor:pointer');

        var ajax = $(this).data('ajax') || false;

        var action = $(this).data('action') || undefined;
        var ajaxCall = {
            success: function (data) {
                if (action !== undefined)
                    window[action](self, data);
            }
        };

        if ($(this).data('confirm') === undefined || $(this).data('confirm') === true) {
            var text = $(this).data('text') || "L'action sera irréversible";

            var confirm = swal({
                title: 'Êtes-vous sûr ?',
                allowOutsideClick: true,
                text: text,
                type: 'warning',
                showCancelButton: true,
                closeOnConfirm: false, closeOnCancel: true,
                confirmButtonColor: "#D2282D",
                cancelButtonText: 'Annuler',
                confirmButtonText: "Oui !"
            }).then(function(result){
                if(result.value) {
                swal({
                    title: "C'est fait !",
                    text: "L'action a bien été effectuée",
                    type: "success",
                    allowOutsideClick: true,
                });
                setTimeout(function () {
                    if (ajax) {
                        $('form', self).ajaxForm(ajaxCall);
                    }
                    $('form', self).submit();
                }, 750);
            }else {}
        });

        } else {
            if (ajax) {
                $('form', $(this)).ajaxForm(ajaxCall);
            }
            $('form', $(this)).submit();
        }

        $(this).trigger('complete');

        return false;
    });


    /***
     * Modal de sélection du site à la connexion
     */
    if ($('#modal-select-site').length) {
        $('#modal-select-site').modal('show');
    }


    /***
     * Form update
     */

    $('.wrapper').on('change', 'form', function (e) {
        window.onbeforeunload = goodbye;
    });

    $('.wrapper').on('submit', 'form', function (e) {
        window.onbeforeunload = null;
    });

    function goodbye(e) {
        if (!e) e = window.event;

        e.cancelBubble = true;
        e.returnValue = 'Des modifications sont en cours, êtes-vous sûr de vouloir changer de page ?';

        if (e.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
        }
    }

    var refreshHeader = false;

    /**
     * Récupère les informations pour le menu du haut
     * Nombre de notifications non lues / 5 premières non lues
     */
    function getHeaderCounter() {
        $.ajax({
            url: '/notifications/counter',
            method: 'GET',
            loader: false,
            success: function (data, textStatus, jqXHR) {
                $('.navbar-menutop .notifications-dropdown').empty().append(data);
            }
        });
    }

    setInterval(function () {
        if(refreshHeader)
        {
            getHeaderCounter();
        }
    }, 5000);

    $('.navbar-menutop .notifications-dropdown').on('click', '.notif-item a', function (e) {
        e.preventDefault();
        refreshHeader = false;
        $this = $(this);
        var id = $this.parent().data('id');

        $.ajax({
            url: '/notifications/' + id + '/read',
            method: 'PUT',
            loader: false,
            success: function (data, textStatus, jqXHR) {
                window.location = $this.attr('href');
            }
        });
    });

});