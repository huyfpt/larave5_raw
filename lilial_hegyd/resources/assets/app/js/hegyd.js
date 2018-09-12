window.Hegyd = function () {
    var self = this;
    this.updateCartViews = function (data) {
        if (data.hasOwnProperty('templates')) {
            $.each(data.templates, function (templateName, templateHtml) {
                var $element = $('[data-cart-template="' + templateName + '"]', 'body');
                if ($element.length) {
                    $element.children().remove();
                    $element.append(templateHtml);
                } else if (templateName == 'cart-popup') {
                    toastr.success(templateHtml);
                }
            });
        }
    };

    this.handleConfirm = function () {
        $('[data-confirm]').bind('submit', function (el) {
            el.preventDefault();
            var form = $(this);

            swal({
                title: form.attr("data-swal-title"),
                text: form.attr("data-swal-text"),
                type: form.attr("data-swal-type"),
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
            }).then(function (result) {
                if (result.value
                ) {
                    // En cas de confirmation, on submit le formulaire normalement.
                    form.unbind('submit').submit();
                }
            })
            ;

        });
        $('[data-confirm="onclick"]').on('click', function (el) {
            el.preventDefault();
            var $this = $(this);

            swal({
                title: $this.attr("data-swal-title"),
                html: $this.attr("data-swal-text"),
                type: $this.attr("data-swal-type"),
                showCancelButton: true,
                confirmButtonText: 'Oui',
                confirmButtonColor: '#FF004E',
                cancelButtonText: 'Non',
            }).then(function (result) {
                if (result.value
                ) {
                    window.location.href = $this.attr('href');
                }
            })
            ;
        });
    };

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

    /**
     * Init switchery checkbox
     */
    this.initSwitchery = function (elems) {

        if (elems === undefined) {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.switcheryable,.js-switch'));
        }

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

    this.initRadioButtons = function (elems) {

        if (!jQuery().iCheck)
            return;

        if (elems === undefined) {
            var elems = $('.icheckable, .js-radio');
        }

        elems.iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        elems.on('ifChecked', function (event) {
            $(event.target).change();
        });
    };

    this.initDatePicker = function () {
        $('.datepicker.not-init').each(function () {
            $this = $(this);
            var data = {
                format: $this.data('format'),
                language: 'fr',
                rtl: false,
                orientation: 'bottom auto',
                autoclose: true,
                zIndexOffset: 999
            };

            if ($this.data('allowClear'))
                data.clearBtn = true;

            $this.datepicker(data);
            $this.removeClass('not-init');
        });
    };
    this.initDateMask = function () {
        $('.datemask.not-init').each(function () {
            $this = $(this);
            $this.inputmask();
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

        selector = typeof selector !== 'undefined' ? selector : 'select.selectable2, select.select2';
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

    /**
     * Initialize Summernote WYSIWYG
     * @param selector      Force jQuery  selector (default : .summernoteable)
     */
    this.initSummernote = function (selector) {

        selector = typeof selector !== 'undefined' ? selector : '.summernoteable,textarea.summernote';

        var $selector = $(selector);

        if ($selector != undefined && $selector.length) {
            if (typeof $selector.summernote === "function") {
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
                        ['insert', ['link']],
                    ],
                    height: 250,
                    disableDragAndDrop: true,
                    lang: 'fr-FR'
                });

                return $selector;
            } else {
                console.error('Summernote library is not available, not loaded properly');
            }
        }
    };

    /**
     * Init tooltip items
     */
    this.initTooltip = function () {
        $('body').tooltip({
            items: '[data-toggle="tooltip"]',
            position: {
                // 24/11/17 - Quentin
                // J'ai commenté car dans les news (front) ils étaient mal placés, à voir si cela pose des problèmes ailleurs.
                // at: 'bottom-3',
                // collision: "none"
            }
        });
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
                            '   <i class="fas fa-times"></i>' +
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

    this.initAjaxRequestHeader = function () {
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
    };

    this.initFlashAlert = function () {
        if ($('[name="flash-alert"]').length) {
            $('[name="flash-alert"]').each(function () {
                $that = $(this);
                swal($that.data('title'), $that.data('content'), $that.data('type'));
            });
        }
    };

    this.initFormValidate = function ($parent) {

        if ($parent && $parent !== undefined)
            $selector = $('form.js-validate', $parent);
        else
            $selector = $('form.js-validate');


        if (!$selector.length)
            return;

        // This will set `ignore` for all validation calls
        jQuery.validator.setDefaults({
            // This will ignore all hidden elements alongside `contenteditable` elements
            // that have no `name` attribute
            ignore: ":hidden:not(.summernoteable,textarea.summernote),.note-editable"
        });

        jQuery.validator.addMethod('dateFR', function (value, element) {
            return this.optional( element ) || /^(([0-2]\d|[3][0-1])[\/\-]([0]\d|[1][0-2])[\/\-]\d{4})$/.test( value );
        }, jQuery.validator.messages.date);

        var form_validate = $selector.validate({
            // validation rules for registration form
            errorClass: "has-error",
            errorElement: 'ul',
            errorPlacement: function (error, element) {
                element.parents('.form-group').addClass('has-error');
                var errorBlock = element.parents('.form-group').find('.help-block');

                if (!errorBlock.length) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }

                errorBlock.append(error);
            },
            // The div has the following class `.note-editable .panel-body` that we can use to
            // exclude it from validation
            invalidHandler: function (event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1
                        ? 'Un champs n\'est pas valide, il est entouré de rouge'
                        : errors + '  champs ne sont pas valides. Ils sont entourés de rouge';
                    toastr.error(message);
                }
            },
            success: function (label, element) {
                $(element).parents('.has-error').removeClass('has-error');
            }
        });

        $summernote = self.initSummernote();

        if ($summernote !== undefined) {
            $summernote.on('summernote.change', function (event, contents) {
                var $this = $(this);
                $this.val($this.summernote('isEmpty') ? "" : contents);
                form_validate.element($this);
            });
        }
    };

    this.init = function () {
        self.initAjaxRequestHeader();
        self.initToastr();
        self.initSwitchery();
        self.initRadioButtons();
        self.initSelect2();
        self.initSummernote();
        self.initTooltip();
        self.initFlashAlert();
        self.initFormValidate();
    };

    return self;
}();

$(document).ready(function () {

    Hegyd.init();

    $(".preloader").fadeOut();
    $('#side-menu').metisMenu();

    $('.vcarousel').carousel({
        interval: 3000
    });

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

    /**
     * Search given named buttons into given form to deactivate them
     * Bould be extended to all submit buttons (to test...)
     * This allow to avoid double click causing trouble by creating dupplicates entries in create forms
     */
    function disableFormSaveButtons($form, name) {

        if ($form != undefined && $form.is('form')) {

            $button = $form.find('[name=' + name + ']');

            if ($button != undefined) {

                if ($button.length != undefined && $button.length > 1) {
                    for (var i = 0, item; item = $button[i]; i++) {
                        var $item = $(item);
                        if ($item != undefined && $item.length > 0)
                            $item.attr('disabled', true);
                    }
                } else {
                    $button.attr('disabled', true);
                }

            }

        } else {
            console.error('$form is not a form');
        }

    }

    /**
     * Listen each submit event to disable save buttons if exists
     * This allow to avoid double click causing trouble by creating dupplicates entries in create forms
     */
    $('body').on('submit', 'form', function (e) {
        // Seems to block normal process...
        //e.preventDefault();

        var $form = $(this);

        disableFormSaveButtons($form, 'save');
        disableFormSaveButtons($form, 'save-and-close');
        disableFormSaveButtons($form, 'save-and-new');

        var $btn = $("button[type=submit][clicked=true]");
        if ($btn.length) {
            var $_action = $('input[name=_action]', $(this));
            if ($_action.length) {
                $_action.val($btn.attr('name'));
            }
        }
    });

    $('body').on('click', 'form button[type=submit]', function (e) {
        $('button[type=submit]', $(this).parents('form')).removeAttr('clicked');
        $(this).attr('clicked', true);
    });
});
