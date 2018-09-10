window.eCommerce = function () {
    var self = this;
    this.updateCartViews = function (data) {
        if (data.hasOwnProperty('templates')) {
            var showToastr = false;
            $.each(data.templates, function (templateName, templateHtml) {
                var $element = $('[data-cart-template="' + templateName + '"]', 'body');
                if ($element.length) {
                    $element.children().remove();
                    $element.append(templateHtml);
                } else if (templateName == 'cart-popup') {
                    self.showToastr(data, templateHtml);
                    showToastr = true;
                }
            });
            if (!showToastr)
                self.showToastr(data, data.text);
        }
    };

    this.showToastr = function (data, text) {
        if (!text)
            return;

        if (data.warning) {
            toastr.warning(text);
        } else if (data.success) {
            toastr.success(text);
        } else if (!data.success) {
            toastr.error(text);
        }
    }

    this.forwardToPage = function (data) {
        if (data.hasOwnProperty('href')) {
            window.location = data.href;
        }
    };

    this.sendRequest = function (url, method, data, callbackSuccess, callbackError) {
        $.ajax({
            url: url,
            method: method,
            data: data
        }).success(function (data) {
            if (callbackSuccess) {
                callbackSuccess(data);
            }
        }).error(function (data) {
            if (callbackError) {
                callbackError(data);
            }
        });
    };


    this.initSearch = function () {


        $.widget("custom.catcomplete", $.ui.autocomplete, {

            _create: function () {
                this._super();
                this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
            },

            _resizeMenu: function () {
                // this.menu.element.outerWidth(470).outerHeight(300);
            },

            _renderMenu: function (ul, items) {

                var that = this,
                    currentCategory = "";

                $.each(items, function (index, item) {
                    var li;
                    if (item.category != currentCategory) {
                        ul.append("<li class='ui-autocomplete-category " + item.category + "'>" + item.category + "</li>");
                        currentCategory = item.category;
                    }

                    li = that._renderItemData(ul, item);

                    if (item.category) {
                        li.attr("aria-label", item.category + " : " + item.label);
                    }
                });
            },

            _renderItem: function (ul, item) {
                return $("<li>")
                    .addClass(item.category)
                    .attr("data-value", item.value)
                    .attr('href', item.url)
                    .append(
                        $("<a>").append(item.label + '<br><span class="desc">' + item.desc + "</span>").attr('href', item.url))
                    .appendTo(ul);
            }
        });

        $("#search").catcomplete({
            source: '/recherche/autocomplete',
            minLength: 3,
            select: function (event, ui) {
                if (ui.item.url) {
                    window.location.href = ui.item.url;
                }
            }
        });

        $(window).resize(function () {
            var sH = $(window).width();
            if (sH > 768) {
                $('.dropdown-menu').css('width', sH - 320 + 'px');
                $('.dropdown-menu').css('min-width', sH - 320 + 'px');
            }
        });

        if ($(window).width() > 768) {
            var sH = $(window).width();
            $('.dropdown-menu').css('width', sH - 320 + 'px');
            $('.dropdown-menu').css('min-width', sH - 320 + 'px');
        }

        $('.item-search').on('click', function () {
            $('.form-header').addClass('active');
            $('.collapse').removeClass('in');
            $('#search').focus();
        });

        $('.close-search-header').on('click', function () {
            $('.form-header').removeClass('active');
        });
    };


    this.initToastr = function () {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    };


    this.initRemoteModal = function (selector, remoteUrl, afterLoadedCallback, successCallback, errorCallback) {

        var $modal = $(selector);

        if (!$modal.length) {
            console.error('Modal not found !');
            return false;
        }

        $modal.on('hidden.bs.modal', function () {
            $('.modal-content', $modal).empty();
        });

        $('.modal-content', $modal).load(remoteUrl, function () {
            if (afterLoadedCallback != undefined) {
                afterLoadedCallback();
            }

            var $form = $modal.find('form');
            var $loader = $modal.find('.loading');

            $form.ajaxForm({
                beforeSubmit: function (arr, $form, option) {
                    $('form', $modal).addClass('hide');
                    $loader.removeClass('hide');

                },
                success: function (data) {

                    $modal.modal('hide');

                    if (successCallback != undefined) {
                        successCallback(data);
                    }
                },
                error: function (data, error, msg) {

                    if (errorCallback != undefined) {
                        errorCallback(data);
                    }

                    $loader.addClass('hide');
                    $('form', $modal).removeClass('hide');
                    var $error = $('<div/>').addClass('alert alert-block alert-danger fade in')
                        .html('' +
                            '<button data-dismiss="alert" class="close close-sm" type="button">' +
                            '   <i class="fa fa-times"></i>' +
                            '</button>' + self.getModalOutputData(data.responseJSON)
                        );
                    $form.prepend($error);
                }
            });
        });
        $modal.modal('show');
    };


    this.getModalOutputData = function (data) {

        if (typeof data !== 'undefined') {

            var list = data;

            if (data.hasOwnProperty('errors'))
                list = data.errors;

            var html = '<ul>';
            $.each(list, function (key, item) {
                html += '<li>' + item + '</li>';
            });
            html += '</ul>';

            return html;
        }

        return 'Un problème est survenue lors de l\'enregistrement';
    };

    this.initDatePicker = function () {
        $('.datepicker.not-init').each(function () {
            $this = $(this);
            $this.datepicker({
                format: $this.data('format'),
                language: 'fr',
                rtl: false,
                orientation: 'bottom auto',
                autoclose: true
            });
            $this.removeClass('not-init');
        });
    };
    this.initDateTimePicker = function () {
        moment().locale('fr');

        $('.datetimepicker.not-init').each(function () {
            $this = $(this);
            $this.datetimepicker({
                allowInputToggle: true,
                ignoreReadonly: true,
                stepping: 15,
            });
            $this.removeClass('not-init');
        });
    };

    /**
     * Initialize Select2.js items. No options required to initialise a select
     * @param selector
     * @param options_forced
     */
    this.initSelect2 = function (selector, options_forced) {

        selector = typeof selector !== 'undefined' ? selector : '.selectable2';
        options_forced = typeof options_forced !== 'undefined' ? options_forced : {};

        var options_default = {
            language: 'fr'
        };
        $.extend(options_default, options_forced);

        var $selector = $(selector);

        if ($selector != undefined && $selector.length) {
            if ($selector.length > 1) {

                $selector.each(function () {

                    var placeholder = $(this).data('placeholder');
                    if (placeholder != undefined && placeholder.length > 0) {
                        $.extend(options_default, {'placeholder': placeholder});
                    }

                    $(this).select2(options_default);

                    // Is selected items are available in data-selected as array then force them
                    var selected = $(this).data('selected');
                    if (selected != undefined && selected.length > 0) {
                        $("div" + selector).select2('data', selected);
                    }

                });

            } else {

                // Manage default placeholder
                var placeholder = $selector.data('placeholder');
                if (placeholder != undefined && placeholder.length > 0) {
                    $.extend(options_default, {'placeholder': placeholder});
                }

                $selector.select2(options_default);

                // Is selected items are available in data-selected as array then force them
                var selected = $selector.data('selected');
                if (selected != undefined && selected.length > 0) {
                    $("div" + selector).select2('data', selected);
                }

            }

        }

    };

    return self;
}();

$(document).ready(function () {

    /**
     * CSRF token for ajax queries
     * @type {*|jQuery}
     */
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrf_token
        }
    });

    /**
     * Initialize Summernote WYSIWYG
     * @param selector      Force jQuery  selector (default : .summernoteable)
     */
    var initSummernote = function (selector) {

        selector = typeof selector !== 'undefined' ? selector : '.summernoteable,textarea.summernote';

        var $selector = $(selector);

        if ($selector != undefined && $selector.length) {
            $selector.summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['style']],
                    ['fontstyle', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['misc', ['fullscreen', 'codeview']],
                    ['help', ['help']],
                ],
                height: 250,
                lang: 'fr-FR'
            });
        } else {
            console.warn('Summernote item not found. Selector : ' + selector);
        }

    };


    // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function () {
        var data = {
            size: 'small'
        };
        data = $.extend(data, $(this).data());
        new Switchery($(this)[0], data);
    });

    initSummernote();

    $(".preloader").fadeOut();
    $('#side-menu').metisMenu();

    $('.vcarousel').carousel({
        interval: 3000
    });

    $(document).tooltip({
        items: '[data-toggle="tooltip"]',
        position: {
            at: 'bottom-3',
            collision: "none"
        }
    });

    // Sidebar open close
    /*$(".open-close").on('click', function () {
        if ($("body").hasClass("content-wrapper")) {
            $("body").trigger("resize");
            $(".sidebar-nav, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible");
            $("body").removeClass("content-wrapper");
            $(".open-close i").addClass("icon-arrow-left-circle");
            $(".logo span").show();
        }
        else {
            $("body").trigger("resize");
            $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
            $("body").addClass("content-wrapper");
            $(".open-close i").removeClass("icon-arrow-left-circle");
            $(".logo span").hide();
        }
    });*/

    var refreshHeader = true;

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
                $('.navbar .notifications-dropdown').empty().append(data);
            }
        });
    }

    getHeaderCounter();

    // setInterval(function () {
    //     if(refreshHeader)
    //     {
    //         getHeaderCounter();
    //     }
    // }, 5000);

    $('.navbar .notifications-dropdown').on('click', '.notif-item a', function (e) {
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
