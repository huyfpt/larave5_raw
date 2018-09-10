(function ($) {
    $('body').on('click', '.add-to-cart', function (e) {
        e.preventDefault();

        var data = {
            'product_id':  $('input#product_id').val(),
            'quantity': $('#quantity').val(),
            return_templates: ['cart-popup', 'cart-header']
        };

        eCommerce.sendRequest($(this).attr('href'), 'POST', data, eCommerce.updateCartViews);
    });

    $('body').on('submit', 'form.form-add-to-cart', function (e) {
        e.preventDefault();
        $('.add-to-cart').trigger('click');
    });

    $("[data-fancybox]").fancybox();
})(jQuery)