var Cart = function () {

    var self = this;

    this.updateProductQuantity = function () {
        $parent = $(this).parents('tr');
        $article = $(this).parents('article');

        var data = {
            'product_id': $parent.data('product-id'),
            'user_id': $parent.data('user-id'),
            'quantity': $(this).val(),
            'return_templates': [$article.data('template'), 'cart-header']
        };

        eCommerce.sendRequest($(this).attr('href'), 'PUT', data, eCommerce.updateCartViews);
    };

    this.deleteProduct = function ($this, dataDefault) {
        $parent = $this.parents('tr');
        $article = $this.parents('article');
        dataDefault = dataDefault || {};

        var data = {
            'product_id': $parent.data('product-id'),
            'user_id': $parent.data('user-id'),
            'return_templates': [$article.data('template'), 'cart-header']
        };
        data = $.extend(dataDefault, data);

        eCommerce.sendRequest($this.attr('href'), 'DELETE', data, self.updateCartIndexView);
    };

    this.updateCartIndexView = function (data) {
        eCommerce.updateCartViews(data);
        swal.close();
    };

    this.initCartAddressesModal = function(url, loadedCallback){
        eCommerce.initRemoteModal('#cart-modal', url, loadedCallback, function(data){
            setTimeout(function(){
                eCommerce.updateCartViews(data);
                toastr.success('L\'adresse a été mise à jour !');
            }, 300);
        });
    };

    this.askToDelete = function (deleteText, buttonText, callback) {
        swal({
            title: '',
            text: "<span style='color: #F17474;'>ATTENTION ! <br />" + deleteText + "</span>",
            type: 'error',
            html: true,
            showCancelButton: true,
            confirmButtonColor: '#ee0000',
            confirmButtonText: buttonText,
            cancelButtonText: 'Annuler',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function () {
            if (callback) {
                callback();
            }
        });
    };

    this.initSelect2Countries = function(){
        console.log('initSelect2');
        $('#country_id').select2({
            language: 'fr',
            ajax: {
                url: '/countries',
                data: function (params) {
                    return {
                        query: params.term
                    };
                },
                processResults: function (data, params) {
                    var results = [];
                    $.each(data, function (id, entity) {
                        results.push({
                            id: entity.id,
                            text: entity.title_fr
                        });
                    });
                    return {results: results}
                },
                templateResult: function (data) {
                    return data.title_fr;
                }
            },
            initSelection: function (element, callback) {
                var id = $('[name=address_country_id]').val();
                results = [];
                if (id) {
                    $.ajax("/countries/" + id, {
                        dataType: "json"
                    }).done(function (entity) {
                        if (entity) {
                            var id = entity.id;
                            var text = entity.title_fr;
                            results.push({id: id, text: text});
                        }
                        callback(results);
                    });
                }
                callback(results);
            }
        });
    };

    /**
     * Init all cart events
     */
    this.initEvents = function () {
        /* Changement de la quantité d'une ligne */
        $('body').on('change', 'input[name="quantity"]', $.throttle(300, self.updateProductQuantity));

        /* Suppression d'une ligne du panier */
        $('body').on('click', 'a.delete-cart-line', function (e) {
            e.preventDefault();
            $this = $(this);
            askToDelete('Êtes-vous sûr de vouloir <strong>supprimer le produit</strong> de votre panier&nbsp;?',
                'Supprimer le produit',
                function () {
                    deleteProduct($this);
                });
        });

        /* Mise à jour du commentaire */
        $('body').on('change', 'textarea.comment', function (e) {
            $article = $(this).parents('article');

            var data = {
                'comment': $(this).val(),
                'update-cart': true,
                'return_templates': [$article.data('template')]
            };

            eCommerce.sendRequest($(this).attr('href'), 'PUT', data, function(data){
                eCommerce.updateCartViews(data);
                toastr.success('Votre commentaire a été mise à jour !');
            });
        });

        /* Mise à jour du moyen de paiement */
        $('body').on('click', 'input.payment_means', function (e) {
            $article = $(this).parents('article');

            var data = {
                'payment_means': $(this).val(),
                'update-cart': true,
                'return_templates': [$article.data('template')]
            };

            eCommerce.sendRequest($(this).attr('href'), 'PUT', data);
        });

        /* Choix d'une adresse */
        $('body').on('click', 'a.choose-address', function(e){
            e.preventDefault();
            self.initCartAddressesModal($(this).attr('href'));
        });

        /* Ajout d'une nouvelle adresse */
        $('body').on('click', 'a.add-address', function(e){
            e.preventDefault();
            self.initCartAddressesModal($(this).attr('href'), self.initSelect2Countries);
        });

        /* Edition d'une adresse */
        $('body').on('click', 'a.edit-address', function(e){
            e.preventDefault();
            self.initCartAddressesModal($(this).attr('href'), self.initSelect2Countries);
        });

        /* Remise à zéro du panier */
        $('body').on('click', 'a.reset-cart', function (e) {
            e.preventDefault();

            $article = $(this).parents('article');
            var url = $(this).attr('href');

            askToDelete('Êtes-vous sûr de vouloir <strong>vider votre panier</strong>&nbsp;?<br />' +
                'Cette action est immédiate et irréversible.',
                'Vider',
                function () {
                    var data = {
                        'return_templates': [$article.data('template'), 'cart-header']
                    };
                    result = eCommerce.sendRequest(url, 'PUT', data, self.updateCartIndexView);
                });
        });

        /* Validation du panier */
        $('body').on('click', 'a.btnValidateCart', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            swal({
                title: '',
                text: 'Êtes-vous sûr de vouloir valider le panier ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#950382',
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                closeOnConfirm: false
            }, function () {
                window.location = href;
            });
        });

        $('body').on('click', 'a.leave-comment', function(e){
            e.preventDefault();
            $('.comment-area').toggleClass('show');
        });
    };

    return {
        init: function () {
            self.initEvents();
        }
    };
}();


(function ($) {
    Cart.init();
})(jQuery);