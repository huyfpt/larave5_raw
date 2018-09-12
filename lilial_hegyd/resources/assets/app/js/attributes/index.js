
var Attributes = function () {

    var self = this;


    this.initNestedList = function (container) {

        // Initialise container if undefined
        container = typeof container !== 'undefined' ? container : $('.nestable-items');

        // Initialize Nestable for all availble list on page
        container.nestable({
            group: 0,
            maxDepth: 1
        }).on('change', self.saveNewOrder);

    };


    this.saveNewOrder = function (e) {

        var request = {
            new_order: $(this).nestable('serialize'),
            attribute_id: $(this).data('attribute-id')
        };

        console.log($(this));
        console.log(request);

        $.ajax({
            url: '/admin/attributs/valeurs/deplacer',
            type: 'POST',
            data: request
        }).success(function(data) {

            toastr.success(data.message);

        }).error(function(data){

            toastr.error('Une erreur est survenue au cours du changement de l\'ordre', 'Attention!');
            window.location.reload();

        });

    };


    this.updateNestableList = function(container, values_list) {

        // Update .nestable-list-container DIV html
        container.find('.nestable-items').html(values_list);

        // Force reloading associated list
        //self.initNestedList(container.find('.nestable-items'));

    };


    this.initAddEditValueButton = function() {

        $('#page-wrapper').on('click', 'a.jsAddValue, a.jsEditValue', function (e) {

            e.preventDefault();

            Hegyd.initRemoteModal('#modal', $(this).data('href'), self.initAddEditValuePopup, function (data) {
                toastr.success(data.message);
                // Replace values list content and reload nestable on list
                var $container = $('#attribute_'+data.attribute_id);
                console.log($container);
                self.updateNestableList($container, data.values_list);
            });

        });

    };


    this.initAddEditValuePopup = function() {

        // Load Select2 if available for some fields
        Hegyd.initSelect2();

        // Load ColorPicker if necessary
        $.each($('div.colorpicker-component'), function () {
            $(this).colorpicker();
        });

    };


    this.initDeleteValueButton = function() {

        $('#page-wrapper').on('click', 'a.jsDeleteValue', function (e) {

            $this = $(this);

            e.preventDefault();

            swal({
                title: "Êtes-vous sûr ?",
                html: "Voulez-vous supprimer cette valeur ?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Non',
                confirmButtonText: "Oui",
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function (resolve) {
                        $.ajax({
                            url: $this.data('href'),
                            method: 'DELETE'
                        }).success(function (data) {
                            toastr.success(data.message);
                            // Remove item in HTML list
                            self.removeValueItem(data.value_id);
                        }).error(function () {
                            toastr.error('Une erreur est survenue');
                        }).complete(function(){
                            resolve();
                        });
                    });
                }
            }).then((result) => {
                swal.close();
        });
        });

    };


    this.removeValueItem = function(valueId){

        if (valueId != undefined){
            $valueItem = $('#value_'+valueId);

            // If value item found then remove it, else reload all the page
            if ( $valueItem != undefined ){
                $valueItem.hide('slow', function(){ $valueItem.remove(); });
            } else {
                window.location.reload();
            }
        }

    };


    return {
        init: function () {
            self.initNestedList();
            self.initAddEditValueButton();
            self.initDeleteValueButton();
        }
    };

}();
