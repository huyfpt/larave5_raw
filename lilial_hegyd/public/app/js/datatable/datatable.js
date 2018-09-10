(function (document, window, $) {
    'use strict';
    var ajaxParams = {};


    var order = [[0, 'asc']];

    if ($('[data-order]').length) {
        var $field = $('[data-order]');
        order = [[$field.data('field-key'), $field.data('order')]];
    }

    if ($('[name="bulk_actions"]').length) {
        order = [[1, 'asc']];
    }


    var columnDefs = [];


    columnDefs.push({targets: 'nofilter', searchable: false});
    columnDefs.push({targets: 'noorder', orderable: false});

    $('thead th').each(function (key) {
        if ($(this).data('class-row')) {
            columnDefs.push({
                targets: key,
                className: $(this).data('class-row')
            });
        }
    });

    window.AppDatatable = {
        /**
         * Default options
         */
        defaults: {
            cache: false,
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            responsive: false,
            autoWidth: false,
            ajax: {
                data: function (data) { // add request parameters before submit
                    $.each(ajaxParams, function (key, value) {
                        data[key] = value;
                    });
                }
            },
            columnDefs: columnDefs,
            order: order,
            lengthMenu: [25, 50, 75, 100, 150, 200, 250, 500],
            language: {
                processing: '',
                search: '',
                sSearchPlaceholder: 'Recherche...',
                emptyTable: 'Pas de donnée disponible dans le tableau',
                paginate: {
                    first: '<<',
                    last: '>>',
                    next: '>',
                    previous: '<'
                },
                info: 'Affichage de l\'élément _START_ à _END_ sur _TOTAL_ élément(s) trouvé(s)',
                infoFiltered: '',
                infoEmpty: '',
                thousands: '',
                lengthMenu: '_MENU_',
                loadingRecords: '',
                zeroRecords: 'Aucun enregistrement correspondant trouvé'
            },
            drawCallback: function (settings) {
                if (settings._iRecordsTotal <= 25) {
                    $('.dataTables_length').hide();
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_length').show();
                    $('.dataTables_paginate').show();
                }
                window.AppDatatable.onDatatableDraw();
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex) {
                nRow.className = 'footable-even';
                return nRow;
            },
            /**
             * the jQuery selector of the datatable element
             */
            selector: '#app-datatable'
        },
        /**
         * options contains:
         *  - selector the jQuery selector of the datatable elemen (default: #backend-datatable)
         * @param Object options
         * @returns Datatable Object
         */
        handleDataTable: function (options) {
            options = $.extend(AppDatatable.defaults, options);
            if ($.fn.DataTable) {
                var $table = $(options.selector);
                var table = window.AppDatatable.table = $table.DataTable(options);
                var $loader = $('.loader-wrapper');
                table.on('processing.dt', function (e, settings, processing) {
                    if (processing) {
                        $loader.addClass('active');
                    } else {
                        $loader.removeClass('active');
                    }
                });
                window.AppDatatable.initFilters($table, table);
                window.AppDatatable.handleDatePickers();
                return table;
            }
        },
        setAjaxParam: function (name, value) {
            ajaxParams[name] = value;
        },
        /**
         *
         * @param tablebackend
         * @returns
         */
        submitFilter: function (table) {
            // get all typeable inputs
            $('.form-filter').each(function () {
                var $filter = $(this);
                window.AppDatatable.setAjaxParam($filter.attr('name'), $filter.val());
            });
            table.ajax.reload();
        },
        /**
         * Initialize Filters
         * @param $element $table
         * @returns
         */
        initFilters: function ($table, table) {
            window.AppDatatable.initSelectFilter($table);
            $table.find('input').on('change', function () {
                if ($(this).hasClass('nofilter'))
                    return false;

                window.AppDatatable.submitFilter(table);
            });
            $table.find('select').on('change', function (event) {
                event.preventDefault();
                window.AppDatatable.submitFilter(table);
            });
            $table.find('.date-picker input').on('change', function (event) {
                event.preventDefault();
                window.AppDatatable.submitFilter(table);
            });
            $table.find('input[type="checkbox"]#select-all').on('change', function (event) {
                event.preventDefault();
                $('input[type="checkbox"][name="select-row"]').prop('checked', $(this).is(':checked'));
            });
            $('#btn-reset').click(function () {
                $('.form-filter').each(function () {
                    var $this = $(this);
                    $this.val('');
                    if (this.tagName.toLowerCase() === 'select') {
                        $this.select2('val', '');
                    }
                });
                window.AppDatatable.submitFilter(table);
            });
        },
        /**
         * Initialize select2
         * @param $Element $table
         * @returns
         */
        initSelectFilter: function ($table) {
            $table.find('select').select2();
        },
        /**
         * Called when the datatable is redrawn
         * @returns
         */
        onDatatableDraw: function () {
            this.handleBootstrapSwitch();
            this.handleToggleActive();
            this.handleDeleteModal();
        },
        /**
         *  initialize switch on datatable using data-witch-urk
         * @returns
         */
        handleBootstrapSwitch: function () {
            if (!$().bootstrapSwitch) {
                return;
            }
            $('.make-switch').bootstrapSwitch().on('switchChange.bootstrapSwitch', function (event, state) {
                var $this = $(this);
                window.AppDatatable.executeSwitchChange($this.attr('data-switch-url'), state);
            });
        },
        handleToggleActive: function () {
            $('a.toggle-active').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $this = $(this);
                var state = $this.data('active');

                if (!state) {
                    swal({
                        title: 'Êtes-vous sûr ?',
                        allowOutsideClick: true,
                        type: 'warning',
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: true,
                        confirmButtonColor: '#D2282D',
                        cancelButtonText: 'Annuler',
                        confirmButtonText: 'Oui !',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                window.AppDatatable.executeSwitchChange($this.attr('href'), state, undefined, undefined, resolve);
                            });
                        }
                    }).then(function (result) {
                        swal.close();
                    });
                } else {
                    window.AppDatatable.executeSwitchChange($this.attr('href'), state);
                }
            });
        },
        /**
         * Execute the swith change ajax query
         * @param string url
         * @returns void
         */
        executeSwitchChange: function (url, state, callbackSuccess, callbackError, callbackComplete) {
            $.ajax({
                method: 'PUT',
                url: url,
                data: {
                    state: state ? 1 : 0
                },
                statusCode: {
                    404: function (xhr) {
                        AppNotification.error('Cette ligne n\'existe plus.');
                    },
                    500: function (xhr) {
                        AppNotification.error('Une erreur est survenue.');
                    }
                },
                success: function (data) {
                    AppNotification.success('Changement d\'état effectué avec succès');
                    if (callbackSuccess !== undefined) {
                        callbackSuccess();
                    }
                },
                error: function (data) {
                    var response = JSON.parse(data.responseText);
                    if (typeof(response.messages) !== 'undefined') {
                        var message = response.main_message + '<br/>';
                        $(response.messages).each(function (index, msg) {
                            message += (index + 1) + '. ' + msg;
                        });
                        AppNotification.error(message);
                    }

                    if (callbackError !== undefined) {
                        callbackError();
                    }
                },
                complete: function (data) {
                    window.AppDatatable.table.ajax.reload();
                    if (callbackComplete !== undefined) {
                        callbackComplete();
                    }
                }
            });
        },
        /**
         * initialize confirmation on datatable
         * @returns
         */
        handleDeleteModal: function () {
            var deleteUrl = null;
            $('[data-delete-url]').click(function (e) {
                e.preventDefault();
                deleteUrl = $(this).attr('data-delete-url');
                swal({
                    title: 'Êtes-vous sûr ?',
                    allowOutsideClick: true,
                    html: $(this).data('text'),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#D2282D",
                    cancelButtonText: 'Annuler',
                    confirmButtonText: "Oui !",
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            AppDatatable.executeDeleteRow(deleteUrl, undefined, undefined, resolve);
                        });
                    }
                }).then(function (result) {
                    swal.close();
                })
                ;
            });
        },
        /**
         *  Handle date pickers
         *   - force validation on changeDate
         */
        handleDatePickers: function () {
            if ($.fn.datepicker) {
                $('.date').datepicker({
                    format: 'dd/mm/yyyy',
                    language: 'fr',
                    rtl: false,
                    orientation: 'bottom auto',
                    autoclose: true
                });
            }
        },
        /**
         * Execute the delete query ajax
         * @param string url
         * @returns
         */
        executeDeleteRow: function (url, callbackSuccess, callbackError, callbackComplete) {
            $.ajax({
                method: 'DELETE',
                url: url,
                statusCode: {
                    404: function (xhr) {
                        AppNotification.error('Cette ligne a déjà été supprimée.');
                    },
                    500: function (xhr) {
                        // AppNotification.error('Une erreur est survenue.');
                    }
                },
                success: function (data) {
                    AppNotification.success('Suppression effectuée avec succès.');

                    if (callbackSuccess !== undefined) {
                        callbackSuccess();
                    }
                },
                error: function (data) {
                    var response = JSON.parse(data.responseText);
                    if (typeof(response.messages) !== 'undefined') {
                        var message = response.main_message + '<br/>';
                        $(response.messages).each(function (index, msg) {
                            message += (index + 1) + '. ' + msg;
                        });
                        AppNotification.error(message);
                    }

                    if (callbackError !== undefined) {
                        callbackError();
                    }
                },
                complete: function (data) {
                    window.AppDatatable.table.ajax.reload();

                    if (callbackComplete !== undefined) {
                        callbackComplete();
                    }
                }
            });
        }
    };
})(document, window, jQuery);
