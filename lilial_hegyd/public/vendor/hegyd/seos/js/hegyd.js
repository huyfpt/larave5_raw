window.HegydNews = function () {
    var self = this;

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

    var initModal = function (url, loadedCallback) {
        Hegyd.initRemoteModal('#modal', url, loadedCallback, function (data) {
            // refreshView(data);
        }, function () {
            toastr.error('Une erreur est survenue !');
        });
    };

    /**
     * Initialize Summernote WYSIWYG
     * @param selector      Force jQuery  selector (default : .summernoteable)
     */
    this.initSummernote = function (selector) {

        if (!$.fn.summernote)
            return false;

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
                lang: 'fr-FR',
                dialogsInBody: true,
                // onCreateLink : function(originalLink) {
                //     console.log(originalLink);
                //     // var attr = $(this).attr('target');
                //     //
                //     // if (typeof attr !== typeof undefined && attr !== false) {
                //     //     $(originalLink).attr('rel', 'noopener noreferrer');
                //     // }
                //     // else {
                //     //     $(originalLink).removeAttr('rel', 'noopener noreferrer');
                //     // }
                //     return originalLink; // return original link
                // }
            });

            /*
             * Test si le summernote required est vide
             */
            $('button[type="submit"]').on('click', function () {
                var stop = false;
                $.each($selector, function (key, item) {
                    $parent = $(item).parent();
                    if ($('.error-content', $parent).length) {
                        $('.error-content', $parent).remove();
                    }

                    if (item.hasAttribute('required')) {
                        if ($(item).summernote('isEmpty')) {
                            stop = true;
                            $parent.append($('<div/>').addClass('error-content alert alert-danger').text('Veuillez remplir le contenu'));
                        }
                    }
                });

                if (stop)
                    return false;

                return true;
            });
        } else {
            console.warn('Summernote item not found. Selector : ' + selector);
        }
    };


    this.initRemoteModal = function (selector, remoteUrl, afterLoadedCallback, successCallback, errorCallback) {

        var $modal = $(selector);

        if (!$modal.length) {
            console.error('Modal not found !' + selector);
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
            $('input:text').first().focus();


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

                    setTimeout(function () {
                        if(data.new != null){
                            $('a.'+ data.new).trigger('click');
                        }
                    }, 500);
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

    $('body').on('click', '[data-form]', function (evt) {
        console.log('here');
        evt.preventDefault();
        var self = $(this);
        var csrf_token = $('input[name="_token"]').val();

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
            },
            error: function (response) {
                if(response.responseJSON.hasOwnProperty('main_message'))
                {
                    toastr.error(response.responseJSON.main_message);
                    return false;
                }
                toastr.error(response.responseText);
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
            }, function (isConfirm) {
                if (isConfirm) {
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
                } else {
                }
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

    this.init = function () {
        self.initSummernote();
        self.initAjaxRequestHeader();
    };

    return self;
}();

$(document).ready(function () {
    HegydNews.init();
});
